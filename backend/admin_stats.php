<?php
session_start();
require_once 'func.php'; 
require_once 'auth_check.php'; 


header('Content-Type: application/json');

$conn = dbConnect();
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

try {
    // Total users
    $res = $conn->query("SELECT COUNT(*) AS total_users FROM tbl_users where is_delete =0");
    $total_users = $res->fetch_assoc()['total_users'];

    // Approved hostels
    $res = $conn->query("SELECT COUNT(*) AS approved_hostels FROM tbl_hostel WHERE status = 'approved' and is_delete=0");
    $approved_hostels = $res->fetch_assoc()['approved_hostels'];

    // Rejected hostels
    $res = $conn->query("SELECT COUNT(*) AS rejected_hostels FROM tbl_hostel WHERE status = 'rejected' and is_delete=0 ");
    $rejected_hostels = $res->fetch_assoc()['rejected_hostels'];

    //Pending hostels
    $res = $conn->query("SELECT COUNT(*) AS pending_hostels FROM tbl_hostel WHERE status = 'pending' and is_delete=0 ");
    $pending_hostels = $res->fetch_assoc()['pending_hostels'];

    // Total bookings
    $res = $conn->query("SELECT COUNT(*) AS total_bookings FROM tbl_booking where status <> 'pending' ");
    $total_bookings = $res->fetch_assoc()['total_bookings'];

    echo json_encode([
        'success' => true,
        'total_users' => $total_users,
        'approved_hostels' => $approved_hostels,
        'rejected_hostels' => $rejected_hostels,
        'pending_hostels' => $pending_hostels,

        'total_bookings' => $total_bookings
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
$conn->close();
