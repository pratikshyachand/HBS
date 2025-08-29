<?php
session_start();
header('Content-Type: application/json');
require_once 'auth_check.php';
require_once 'func.php'; 

$con = dbConnect();
$hostel_id = isset($_GET['hostel_id']) ? (int)$_GET['hostel_id'] : 0;
$date_filter = $_GET['date_filter'] ?? 'all';
$user_id = $_SESSION['user_id'] ?? 0; // current user

if ($hostel_id === 0) {
    echo json_encode(['error' => 'Invalid hostel_id']);
    exit;
}

// --- Date filter for booking ---
$where_booking_date = '';
if ($date_filter === 'today') {
    $where_booking_date = " AND DATE(b.created_at) = CURDATE() ";
} elseif ($date_filter === 'week') {
    $where_booking_date = " AND YEARWEEK(b.created_at, 1) = YEARWEEK(CURDATE(), 1) ";
} elseif ($date_filter === 'month') {
    $where_booking_date = " AND MONTH(b.created_at) = MONTH(CURDATE()) AND YEAR(b.created_at) = YEAR(CURDATE()) ";
}

// --- 1. Booking stats ---
$bookingSql = "
    SELECT 
        COUNT(*) AS total_booking,
        SUM(CASE WHEN b.status='Booked' THEN 1 ELSE 0 END) AS active_booking,
        SUM(CASE WHEN b.status='Cancelled' THEN 1 ELSE 0 END) AS cancelled,
        SUM(CASE WHEN b.status='Completed' THEN 1 ELSE 0 END) AS completed
    FROM tbl_booking b
    JOIN tbl_room r ON b.room_id = r.id
    WHERE r.hostel_id = ? $where_booking_date
";

$stmt = $con->prepare($bookingSql);
$stmt->bind_param("i", $hostel_id);
$stmt->execute();
$bookingResult = $stmt->get_result()->fetch_assoc();
$stmt->close();

// --- 2. Total payments (exclude current user) ---
// Assuming tbl_payment has payment_date column
$where_payment_date = '';
if ($date_filter === 'today') {
    $where_payment_date = " AND DATE(payment_date) = CURDATE() ";
} elseif ($date_filter === 'week') {
    $where_payment_date = " AND YEARWEEK(payment_date,1) = YEARWEEK(CURDATE(),1) ";
} elseif ($date_filter === 'month') {
    $where_payment_date = " AND MONTH(payment_date) = MONTH(CURDATE()) AND YEAR(payment_date) = YEAR(CURDATE()) ";
}

$paymentSql = "
    SELECT COALESCE(SUM(p.amount),0) AS total_value
    FROM tbl_payment p
    JOIN tbl_booking b ON p.booking_id = b.id
    JOIN tbl_room r ON b.room_id = r.id
    WHERE r.hostel_id = ? AND p.user_id <> ? AND p.status='Completed' $where_payment_date
";

$stmt2 = $con->prepare($paymentSql);
$stmt2->bind_param("ii", $hostel_id, $user_id);
$stmt2->execute();
$paymentResult = $stmt2->get_result()->fetch_assoc();
$stmt2->close();

$con->close();

// Merge results and ensure no nulls
$response = array_merge(
    array_map(fn($v) => $v ?? 0, $bookingResult),
    array_map(fn($v) => $v ?? 0, $paymentResult)
);

echo json_encode($response);
exit;
?>
