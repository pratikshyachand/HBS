<?php

session_start();
require_once __DIR__ . '/../../backend/booking.php';
require_once '../../backend/auth_check.php'; 

$user_id = (int)$_SESSION['user_id'];
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 0;

$user = getUser($user_id);
$room = $room_id ? getRoomDetails($room_id) : null;

$popup_message = '';
$popup_type = '';

if (!$room) {
    $popup_message = "Room not found.";
    $popup_type = "error";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_booking'])) {
    $posted_room_id = (int)($_POST['room_id'] ?? 0);
    $beds = (int)($_POST['beds'] ?? 0);
    $check_in = trim($_POST['check_in'] ?? '');
     $check_out = trim($_POST['check_out'] ?? '');

   
        $result = bookRoom($user_id, $posted_room_id, $beds, $check_in, $check_out);
        $popup_message = $result['msg'];
        $popup_type = $result['ok'] ? 'success' : 'error';
    $booking_id = $result['booking_id'];

    // redirect to payment.php
    header("Location: payment.php?id=" . urlencode($booking_id));
    exit;
}
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Hostel Room</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/booking.css">
    <link rel="stylesheet" href="../css/nav-bar.css">
</head>
<body>

<?php if (!empty($popup_message)): ?>
<div class="popup-message popup-<?php echo htmlspecialchars($popup_type); ?>">
    <p><?php echo htmlspecialchars($popup_message); ?></p>
    <span class="popup-close" onclick="this.parentElement.style.display='none'">×</span>
</div>
<?php endif; ?>
<?php include 'navbar.php' ?>
<div class="container">
    

    <h2>Booking Form</h2>

    <?php if ($room && $user): ?>
    <form action="booking.php?room_id=<?php echo (int)$room_id; ?>" method="post" class="booking-form">
        <div class="form-row">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <span class="label">Full Name</span>
                <input type="text" value="<?php 
                    echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); 
                ?>" readonly>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <span class="label">Email</span>
                <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <i class="fas fa-door-open"></i>
                <span class="label">Room Type</span>
                <input type="text" value="<?php echo htmlspecialchars($room['room_type']); ?>" readonly>
            </div>
            <div class="form-group">
                <i class="fas fa-money-bill-wave"></i>
                <span class="label">Price per Bed</span>
                <input type="text" value="<?php echo htmlspecialchars($room['price']); ?>" readonly>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <i class="fas fa-bed"></i>
                <span class="label">Available Beds</span>
                <input type="number" value="<?php echo (int)$room['available_beds']; ?>" readonly>
            </div>
            <div class="form-group">
                <i class="fas fa-bed"></i>
                <span class="label">Beds to Book</span>
                <input type="number" name="beds" min="1" max="<?php echo (int)$room['available_beds']; ?>" value="1" required>
            </div>
        </div>
       <div class="form-row">
    <div class="form-group">
        <i class="fas fa-calendar-check"></i>
        <span class="label">Check-In Date</span>
        <input type="date" name="check_in" required value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="form-group">
        <i class="fas fa-calendar-day"></i>
        <span class="label">Check-Out Date</span>
        <input type="date" name="check_out" required value="<?php echo date('Y-m-d'); ?>">
    </div>
</div>
        

        <input type="hidden" name="room_id" value="<?php echo (int)$room['id']; ?>">

        <div class="form-row" style="justify-content:center; gap:20px; margin-top:20px;">
            <button type="submit" name="submit_booking" class="btn submit-btn"><i class="fas fa-check"></i> Submit</button>
            <a href="javascript:history.back()" class="btn discard-btn"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
    <?php else: ?>
        <p class="error-text">Unable to load user/room details.</p>
    <?php endif; ?>
</div>

</body>
</html>
