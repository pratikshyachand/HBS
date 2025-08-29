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
    <link rel="stylesheet" href="css/booking_details.css">
    <link rel="stylesheet" href="css/navbarS.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/popup.css">



   
</head>
<body>
     <?php include 'navbar.php' ?>

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


        <?php
$booking_time = strtotime($status['created_at']);
$current_time = time();
$hours_since_booking = ($current_time - $booking_time) / 3600; // difference in hours
?>

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
            
<div class="cancel-extend">

     <!-- Cancel Booking -->
   <button type="button" class="btn-cancelB" id="cancelBookingBtn">
    <i class="fa fa-times-circle"></i> Cancel Booking
</button>


<a href="../../backend/download_booking_pdf.php?id=<?= $booking_id ?>" class="btn-download">
    <i class="fa fa-download"></i> Download PDF
</a>
</div>



        </div>
    </div>
</div>

</div>

<!-- <div class="extend-container"> -->
    <!-- Extend Stay Form -->
    <!-- <form id="extendStayForm" class="extend-form" method="POST" action="../../backend/extend_booking.php" 
          <?php if(strtolower($status['status']) === 'cancelled') echo 'class="disabled"'; ?>>
        <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
        <input type="hidden" name="additional_days" id="additionalDays" value="0">
        <input type="hidden" name="additional_amount" id="additionalAmount" value="0">

        <label for="new_checkout">Extend Check-out:</label>
        <input type="date" id="new_checkout" name="new_checkout" 
               min="<?= date('Y-m-d', strtotime($booking['check_out'].' +1 day')) ?>" 
               <?php if(strtolower($status['status']) === 'cancelled') echo 'disabled'; ?> required>

        <p><strong>Additional nights: </strong><span id="extraNights">0</span></p>
        <p><strong>Additional amount:</strong> Rs.<span id="extraAmount">0.00</span></p>

        <button type="submit" class="btn-extend" 
                <?php if(strtolower($status['status']) === 'cancelled') echo 'disabled'; ?>>
            <i class="fa fa-calendar-plus"></i> Extend & Pay
        </button>

     <?php if(strtolower($status['status']) === 'cancelled'): ?>
            <p style="color:red; margin-top:5px;">⚠️ Booking cancelled – cannot extend stay.</p>
        <?php endif; ?>
    </form>
</div> -->



    <?php include '../footer.php' ?>

<!-- Cancel Confirmation Modal -->
<div id="cancelModal" class="cancelModal">
  <div class="cancelModal-content">
    <span class="close">&times;</span>
    <h3>Are you sure?</h3>
    <p>Are you sure you want to cancel this booking? This action cannot be undone.</p>
    <div class="cancelModal-actions">
      <button id="cancelModalBtn" class="btn-cancel">No</button>
      <button id="confirmCancelBtn" class="btn-confirm">Yes</button>
    </div>
  </div>
</div>


    <?php 
    // Show refund button only if booking is cancelled and within 24 hours
    if (strtolower($status['status']) === 'cancelled' && $hours_since_booking <= 24): 
    ?>
        <form action="../../backend/process_refund.php" method="post" style="margin-top:15px;">
            <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
            <button type="submit" class="btn-refund">
                <i class="fa fa-undo"></i> Request Refund
            </button>
        </form>
    <?php elseif (strtolower($status['status']) === 'cancelled'): ?>
        <p style="color:red; margin-top:10px;">Refund request not allowed after 24 hours of cancellation.</p>
    <?php endif; ?>

<script src="cancel_booking.js" > </script>

<!-- <script>
    const originalCheckout = new Date("<?= $booking['check_out']; ?>");
    const nightlyRate = <?= $booking['price']; ?>;
    const bedsBooked = <?= $booking['booked_beds']; ?>;

    const newCheckoutInput = document.getElementById('new_checkout');
    const extraNightsEl = document.getElementById('extraNights');
    const extraAmountEl = document.getElementById('extraAmount');
    const additionalDaysInput = document.getElementById('additionalDays');
    const additionalAmountInput = document.getElementById('additionalAmount');

    newCheckoutInput.addEventListener('change', () => {
        const newCheckout = new Date(newCheckoutInput.value);
        let diffTime = newCheckout - originalCheckout;
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if(diffDays > 0) {
            const extraAmount = diffDays * bedsBooked * nightlyRate;
            extraNightsEl.innerText = diffDays;
            extraAmountEl.innerText = extraAmount.toFixed(2);
            additionalDaysInput.value = diffDays;
            additionalAmountInput.value = extraAmount;
        } else {
            extraNightsEl.innerText = 0;
            extraAmountEl.innerText = "0.00";
            additionalDaysInput.value = 0;
            additionalAmountInput.value = 0;
        }
    });
</script> -->

</body>
</html>