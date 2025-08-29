<?php
session_start();
require_once "../../backend/func.php"; 

$user_id = $_SESSION['user_id']; 
$conn = dbConnect();
// Fetch bookings from tbl_booking for this hostel_owner
$sql = "SELECT 
    b.id AS booking_id, 
    b.room_id, 
    b.created_at, 
    r.hostel_id, 
    r.images, 
    r.room_type,
    b.user_id, 
    b.booked_beds,  
    b.status, 
    h.hostel_name,
    u.first_name, 
    u.last_name,
    cr.refund_status   
FROM tbl_booking b
JOIN tbl_room r ON b.room_id = r.id
JOIN tbl_users u ON b.user_id = u.id
JOIN tbl_hostel h ON r.hostel_id = h.id
LEFT JOIN tbl_cancellation_refund cr ON b.id = cr.booking_id  
WHERE h.user_id = ? AND b.status <> 'pending'
ORDER BY b.id DESC";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookings = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="css/myBookings.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/notifBar.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'notifBar_Owner.php'; ?>

    <?php include 'sidebar.php'; ?>

    <div class="container">
        <header>
            <p>Bookings</p>
        </header>
        
        <div class="filter-options">
            <button class="filter-btn active">All Bookings</button>
            <button class="filter-btn" data-status="Booked">Booked</button>
            <button class="filter-btn" data-status="Cancelled">Cancelled</button>
            <button class="filter-btn" data-status="Completed">Completed</button>
       
        </div>
          <div class="date-filters">
        <label>Filter by Date:</label>
        <button class="filter-btn-date" data-date="all">All</button>
        <button class="filter-btn-date" data-date="today">Today</button>
        <button class="filter-btn-date" data-date="week">This Week</button>
        <button class="filter-btn-date" data-date="month">This Month</button>
    </div>
        
        <div class="search-container">
            <div class="search-box">
                <input type="text"  placeholder="Search by hostel name, room type or seeker name">
                <button><i class="fas fa-search"></i> Search</button>
            </div>
        </div>

        
        
        <div class="orders-container">
            <?php foreach($bookings as $booking): ?>
            <div class="order-card"  data-date="<?= date('Y-m-d', strtotime($booking['created_at'])); ?>"   data-status="<?= $booking['status']; ?>" onclick="window.location='booking_detailsO.php?id=<?= $booking['booking_id']; ?>'">
                <div class="order-header">
                    <div class="seller-name"><?= htmlspecialchars($booking['hostel_name']); ?></div>
<div style="display: flex; gap: 10px; align-items: center;">
        <div class="order-status <?php echo strtolower($booking['status']); ?>">
            <?= ucfirst($booking['status']); ?>
        </div>
        
        <?php if (strtolower($booking['status']) === 'cancelled' && !empty($booking['refund_status'])): ?>
            <div class="order-status">
                Refund: <?= ucfirst($booking['refund_status']); ?>
            </div>
        <?php endif; ?>
    </div>                </div>
                <div class="order-content">
                    <div class="product">

                        <div class="product-image">                <img src="<?= !empty($booking['images']) ? '/' . $booking['images'] : 'img/room.png' ?>" alt="Room Image">
</div>
                        <div class="product-details">
<div class="product-nam">Booking ID: <?= htmlspecialchars($booking['booking_id']); ?> </div>

                            <div class="product-name">Room Type: <?= htmlspecialchars($booking['room_type']); ?> (ID: <?= $booking['room_id']; ?>)</div>                            <div class="product-price">
                                <div class="price">Booked By: <?= htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?> </div>
                                <div class="quantity">Booked Date: <?= htmlspecialchars($booking['created_at']); ?></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

<script src="date-filter.js"></script>

<script src="search-booking.js"></script>
</body>
</html>
