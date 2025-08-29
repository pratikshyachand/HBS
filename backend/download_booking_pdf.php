<?php
session_start();
require_once 'fetch_booking.php';
require_once 'auth_check.php';
require_once '../vendor/autoload.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$booking = getBookingDetails($booking_id);
if (!$booking) {
    die("Booking not found.");
}

$conn = dbConnect();
$sql = "SELECT status, created_at FROM tbl_booking WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$status = $stmt->get_result()->fetch_assoc();
$stmt->close();

ob_start(); // start output buffering
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin:20px; }
        .booking-header { display:flex; justify-content:space-between; align-items:center; }
        .booking-status { padding:5px 10px; border-radius:5px; }
        .confirmed { background: #4CAF50; color:#fff; }
        .pending { background: #FFC107; color:#000; }
        .cancelled { background: #F44336; color:#fff; }
        .price-row { display:flex; justify-content:space-between; margin:5px 0; }
        .total { font-weight:bold; font-size:16px; }
    </style>
</head>
<body>
    <h2>Booking Details</h2>
    <div class="booking-header">
        <span><strong>Booking ID:</strong> <?= $booking_id ?></span>
        <span class="booking-status <?= strtolower($status['status']); ?>">
            <?= htmlspecialchars($status['status']); ?>
        </span>
    </div>
    <p><strong>Date:</strong> <?= date('M d, Y', strtotime($status['created_at'])) ?></p>

    <h3>Hostel Info</h3>
    <p><strong>Hostel:</strong> <?= htmlspecialchars($booking['hostel_name']); ?></p>
    <p><strong>Location:</strong> <?= htmlspecialchars($booking['province_name'] . ', ' . $booking['district_name']); ?></p>
    <p><strong>Check-in:</strong> <?= date('M d, Y', strtotime($booking['check_in'])); ?></p>
    <p><strong>Check-out:</strong> <?= date('M d, Y', strtotime($booking['check_out'])); ?></p>
    <p><strong>Duration:</strong> <?= $booking['duration']; ?> nights</p>
    <p><strong>Room ID:</strong> <?php echo $booking['room_id']; ?></p>
    <p><strong>Room Type:</strong> <?= $booking['room_type']; ?></p>
    <p><strong>Beds Booked:</strong> <?= $booking['booked_beds']; ?></p>
    <p><strong>Booked By:</strong> <?= $booking['user_name']; ?></p>
    <p><strong>Contact no.:</strong> <?= $booking['user_contact']; ?></p>


    <h3>Payment Details</h3>
    <div class="price-row">
        <span><strong>Room charge</strong> (<?= $booking['duration']; ?> nights × <?= $booking['booked_beds']; ?> beds × Rs.<?= $booking['price']; ?>)</span>
        <span>Rs.<?= number_format($booking['room_charge'], 2); ?></span>
    </div>
    <div class="price-row">
        <span><strong>Admission fee</strong></span>
        <span>Rs.<?= number_format($booking['admission_fee'], 2); ?></span>
    </div>
    <div class="price-row total">
        <span>Total Paid</span>
        <span>Rs.<?= number_format($booking['total'], 2); ?></span>
    </div>
</body>
</html>
<?php
$html = ob_get_clean();

// ---- Generate PDF ----
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output file to browser (download)
$dompdf->stream("booking_$booking_id.pdf", ["Attachment" => 1]);
