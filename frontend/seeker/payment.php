<?php
session_start();
require_once '../../backend/fetch_booking.php';
require_once '../../backend/auth_check.php';


$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
$booking = getBookingDetails($booking_id);
if (!$booking) {
    die("Booking not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Booking - Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/payment.css">
        <link rel="stylesheet" href="../css/nav-bar.css">

   
</head>
<body>
     <?php include 'navbar.php' ?>
    <?php if (!empty($popup_message)): ?>
<div class="popup-message popup-<?php echo htmlspecialchars($popup_type); ?>">
    <p><?php echo htmlspecialchars($popup_message); ?></p>
    <span class="popup-close" onclick="this.parentElement.style.display='none'">×</span>
</div>
<?php endif; ?>


    <div class="payment-container">
        <div class="booking-summary">
            <h2><i class="fas fa-receipt"></i> Booking Summary</h2>
            
            <div class="hostel-details">
                <h3><?php echo htmlspecialchars($booking['hostel_name']); ?></h3>
                <p><i class="fas fa-map-marker-alt"></i> 
                    <?php echo htmlspecialchars($booking['province_name'] . ', ' . $booking['district_name']); ?>
                </p>
                <div class="booking-dates">
                    <p><strong>Check-in:</strong> <?php echo date('M d, Y', strtotime($booking['check_in'])); ?></p>
                    <p><strong>Check-out:</strong> <?php echo date('M d, Y', strtotime($booking['check_out'])); ?></p>
                    <p><strong>Duration:</strong> <?php echo $booking['duration']; ?> nights</p>
                    <p><strong>Beds booked:</strong> <?php echo $booking['booked_beds']; ?></p>
                </div>
            </div>

            <div class="price-details">
                <h3>Price Details</h3>
                <div class="price-row">
                    <span>Room charge (<?php echo $booking['duration']; ?> nights × <?php echo $booking['booked_beds']; ?> beds × Rs.<?php echo $booking['price']; ?>)</span>
                    <span>Rs.<?php echo number_format($booking['room_charge'], 2); ?></span>
                </div>
                <div class="price-row">
                    <span>Admission fee</span>
                    <span>Rs.<?php echo number_format($booking['service_fee'], 2); ?></span>
                </div>
                <div class="price-row total">
                    <span>Total</span>
                    <span>Rs.<?php echo number_format($booking['total'], 2); ?></span>
                </div>
            </div>
        </div>

        <div class="payment-form">
            <h2><i class="fas fa-credit-card"></i> Payment Method</h2>
            
            <div class="payment-methods">
                <div class="payment-method active">
                    <img src="https://esewa.com.np/common/images/esewa_logo.png" alt="eSewa" class="payment-logo">
                </div>
            </div>

            <!-- eSewa Payment Option -->
            <div id="esewaPayment" class="payment-option active">
                <div class="digital-wallet-info">
                    <p>You will be redirected to eSewa to complete your payment securely.</p>
                    <img src="https://esewa.com.np/common/images/esewa_logo.png" alt="eSewa" class="wallet-logo">
                </div>
                <button class="pay-now-btn esewa-btn" onclick="redirectToEsewa(<?php echo $booking_id; ?>)">
                    <i class="fas fa-external-link-alt"></i> Pay with eSewa
                </button>
            </div>
        </div>
    </div>

    <script>
        function redirectToEsewa(bookingId) {
            // For now, a mock redirect
            alert('Redirecting to eSewa for booking ID: ' + bookingId);
            // In real integration, call your backend to create eSewa payment request
            // window.location.href = 'https://esewa.com.np/...';
        }
    </script>
</body>
</html>
