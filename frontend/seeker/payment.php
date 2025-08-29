<?php
session_start();
require_once '../../backend/fetch_booking.php';
require_once '../../backend/auth_check.php';
require_once '../../backend/process_payment.php';




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
    <link rel="stylesheet" href="css/navbarS.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="css/popup.css">


   
</head>
<body>
     <?php include 'navbar.php' ?>
 


    <div class="payment-container">
        <div class="booking-summary">
            <h2><i class="fas fa-receipt"></i> Booking Summary</h2>
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
                    <p><strong>Room Type:</strong> <?php echo $booking['room_type']; ?> </p>
                    <p><strong>Beds booked:</strong> <?php echo $booking['booked_beds']; ?></p>
                    <p><strong>Booked By:</strong> <?php echo $booking['user_name']; ?></p>
                    <p><strong>Contact no.:</strong> <?= $booking['user_contact']; ?></p>

                </div>
            </div>
            </div>
            

            <div class="price-details">
                <h3>Price Details</h3>
                <div class="price-row">
                    <span><strong>Room charge</strong> (<?php echo $booking['duration']; ?> nights × <?php echo $booking['booked_beds']; ?> beds × Rs.<?php echo $booking['price']; ?>)</span>
                    <span>Rs.<?php echo number_format($booking['room_charge'], 2); ?></span>
                </div>
                <div class="price-row">
                    <span><strong>Admission fee</strong></span>
                    <span>Rs.<?php echo number_format($booking['admission_fee'], 2); ?></span>
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
                    <i class="far fa-credit-card"></i>
                    <span>Card Payment</span>
                </div>
                <div class="payment-method">
                    <img src="https://esewa.com.np/common/images/esewa_logo.png" alt="eSewa" class="payment-logo">
                </div>
                <div class="payment-method">
                    <img src="https://fonepay.com/images/fonepay_logo.svg" alt="Fonepay" class="payment-logo">
                </div>
                <div class="payment-method">
                    <img src="https://khalti.com/static/images/logo.svg" alt="Khalti" class="payment-logo">
                </div>
            </div>

            <!-- Card Payment Form (default visible) -->
            <form id="cardPaymentForm" class="payment-option active" action=""  method="POST">
<input type="hidden" name="booking_id" value="<?= htmlspecialchars($booking_id) ?>">
            <div class="form-group">
        <label for="cardNumber">Card Number</label>
        <div class="input-with-icon">
            <i class="far fa-credit-card"></i>
            <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19" value="<?php echo htmlspecialchars($_SESSION['form_data']['cardNumber'] ?? ''); ?>" required>
        </div>
    </div>

    <div class="form-group">
        <label for="cardName">Name on Card</label>
        <input type="text" id="cardName" name="cardName" placeholder="Enter card name" value="<?php echo htmlspecialchars($_SESSION['form_data']['cardName'] ?? ''); ?>" required>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="expiryDate">Expiry Date</label>
            <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" value="<?php echo htmlspecialchars($_SESSION['form_data']['expiryDate'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="cvv">CVV</label>
            <div class="input-with-icon">
                <input type="password" id="cvv" name="cvv" placeholder="123" maxlength="3" value="<?php echo htmlspecialchars($_SESSION['form_data']['cvv'] ?? ''); ?>" required>
                <i class="fas fa-question-circle" title="3-digit code on back of card"></i>
            </div>
        </div>
    </div>

    <div class="terms">
        <input type="checkbox" id="agreeTerms" name="agreeTerms" required>
        <label for="agreeTerms">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Cancellation Policy</a></label>
    </div>

    <button type="submit" name ="pay_now" class="pay-now-btn">Pay Now</button>
</form>

            <!-- eSewa Payment Option -->
            <div id="esewaPayment" class="payment-option">
                <div class="digital-wallet-info">
                    <p>You will be redirected to eSewa to complete your payment securely.</p>
                    <img src="https://esewa.com.np/common/images/esewa_logo.png" alt="eSewa" class="wallet-logo">
                </div>
                <button class="pay-now-btn esewa-btn" onclick="redirectToEsewa()">
                    <i class="fas fa-external-link-alt"></i> Pay with eSewa
                </button>
            </div>

            <!-- Fonepay Payment Option -->
            <div id="fonepayPayment" class="payment-option">
                <div class="digital-wallet-info">
                    <p>You will be redirected to Fonepay to complete your payment securely.</p>
                    <img src="https://fonepay.com/images/fonepay_logo.svg" alt="Fonepay" class="wallet-logo">
                </div>
                <button class="pay-now-btn fonepay-btn" onclick="redirectToFonepay()">
                    <i class="fas fa-external-link-alt"></i> Pay with Fonepay
                </button>
            </div>

            <!-- Khalti Payment Option -->
            <div id="khaltiPayment" class="payment-option">
                <div class="digital-wallet-info">
                    <p>You will be redirected to Khalti to complete your payment securely.</p>
                    <img src="https://khalti.com/static/images/logo.svg" alt="Khalti" class="wallet-logo">
                </div>
                <button class="pay-now-btn khalti-btn" onclick="redirectToKhalti()">
                    <i class="fas fa-external-link-alt"></i> Pay with Khalti
                </button>
            </div>
        </div>
    </div>

   <?php if (!empty($popup_message)): ?>
<div class="popup-message popup" id="popup">
    <span class="popup-close" onclick="this.parentElement.style.display='none'">×</span>
    <?php foreach ($popup_message as $msg): ?>
        <p><?php echo htmlspecialchars($msg); ?></p>
    <?php endforeach; ?>
</div>

<script>
    document.getElementById('popup').style.display = 'block';
</script>
<?php endif; ?>

    </div>

    <script>
        // Format card number input
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '');
            if (value.length > 0) {
                value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
            }
            e.target.value = value;
        });

        // Format expiry date input
        document.getElementById('expiryDate').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D+/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // Payment method selection
        const paymentMethods = document.querySelectorAll('.payment-method');
        const paymentOptions = document.querySelectorAll('.payment-option');

        paymentMethods.forEach((method, index) => {
            method.addEventListener('click', () => {
                // Remove active class from all methods and options
                paymentMethods.forEach(m => m.classList.remove('active'));
                paymentOptions.forEach(o => o.classList.remove('active'));
                
                // Add active class to selected method and corresponding option
                method.classList.add('active');
                paymentOptions[index].classList.add('active');
            });
        });

        // Mock payment redirects
        function redirectToEsewa() {
            alert('Redirecting to eSewa payment gateway...');
            // window.location.href = 'https://esewa.com.np';
        }

        function redirectToFonepay() {
            alert('Redirecting to Fonepay payment gateway...');
            // window.location.href = 'https://fonepay.com';
        }

        function redirectToKhalti() {
            alert('Redirecting to Khalti payment gateway...');
            // window.location.href = 'https://khalti.com';
        }
    </script>

    <?php include '../footer.php' ?>
    <script src="../popup.js"></script>
</body>
</html>