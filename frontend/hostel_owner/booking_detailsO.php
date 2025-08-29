<?php
session_start();
require_once '../../backend/fetch_booking.php';
require_once '../../backend/auth_check.php';


$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$booking = getBookingDetails($booking_id);
if (!$booking) {
    die("Booking not found.");
}

 $conn = dbConnect();

    $sql = "SELECT 
                status, created_at from tbl_booking 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $status = $stmt->get_result()->fetch_assoc();
    $stmt->close();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Booking - Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../seeker/css/booking_details.css">
    <link rel="stylesheet" href="css/hostel-registration.css">
     <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css">




   
</head>
<body>
     <?php include 'notifBar_Owner.php' ?>
     <?php include 'sidebar.php' ?>
   <div class="payment-container">
    <input type="hidden" id="booking_id" value="<?= $booking_id ?>">

    <div class="booking-summary">
        <!-- Booking Header -->
         <!-- Hidden input for booking ID -->

        <div class="booking-header">
            <h2><i class="fas fa-receipt"></i> Booking Details</h2>
            <span class="booking-status <?php echo strtolower($status['status']); ?>">
                <?php echo htmlspecialchars($status['status']); ?>
            </span>
        </div>

        <div class="booking-meta">
            <p><strong>Booking ID:</strong> <?= $booking_id ?></p>
            <p><strong>Date:</strong> <?= date('M d, Y', strtotime($status['created_at'])) ?></p>
        </div>

        <div class="hostel-info">
            <div class="hostel-image">
                <img src="<?= !empty($booking['images']) ? '/' . $booking['images'] : 'img/room.png' ?>" alt="Room Image">
            </div>

            <div class="hostel-details">
                <h3><?php echo htmlspecialchars($booking['hostel_name']); ?></h3>
                <p><i class="fas fa-map-marker-alt"></i> 
                    <?php echo htmlspecialchars($booking['province_name'] . ', ' . $booking['district_name']); ?>
                </p>
                <div class="booking-dates">
                    <p><strong>Check-in:</strong> <?php echo date('M d, Y', strtotime($booking['check_in'])); ?></p>
                    <p><strong>Check-out:</strong> <?php echo date('M d, Y', strtotime($booking['check_out'])); ?></p>
                    <p><strong>Duration:</strong> <?php echo $booking['duration']; ?> nights</p>
                    <p><strong>Room ID:</strong> <?php echo $booking['room_id']; ?></p> 
                    <p><strong>Room Type:</strong> <?php echo $booking['room_type']; ?></p>
                    <p><strong>Beds booked:</strong> <?php echo $booking['booked_beds']; ?></p>
                    <p><strong>Booked By:</strong> <?php echo $booking['user_name']; ?></p>
                    <p><strong>Contact no.:</strong> <?= $booking['user_contact']; ?></p>

                    
                </div>
            </div>
        </div>

        <div class="price-details">
            <h3>Payment Details</h3>
            <div class="price-row">
                <span><strong>Room charge</strong> (<?php echo $booking['duration']; ?> nights × <?php echo $booking['booked_beds']; ?> beds × Rs.<?php echo $booking['price']; ?>)</span>
                <span>Rs.<?php echo number_format($booking['room_charge'], 2); ?></span>
            </div>
            <div class="price-row">
                <span><strong>Admission fee</strong></span>
                <span>Rs.<?php echo number_format($booking['admission_fee'], 2); ?></span>
            </div>
            <div class="price-row total">
                <span>Total Paid</span>
                <span>Rs.<?php echo number_format($booking['total'], 2); ?></span>
            </div>
            



<a href="../../backend/download_booking_pdf.php?id=<?= $booking_id ?>" class="btn-download">
    <i class="fa fa-download"></i> Download PDF
</a>
 </div>

</div>
<?php if (strtolower($status['status']) === 'cancelled'): ?>
            <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
            <button type="submit" class="btn-extend" onclick="window.location.href='refund.php?id=<?= $booking_id ?>'">
                <i class="fa fa-undo"></i> Refund
            </button>
    <?php endif; ?>

</div>


</body>
</html>