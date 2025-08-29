<?php
session_start();
require_once 'func.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? null;
$hostel_id = $_GET['hostel_id'] ?? null;

if (!$user_id || !$hostel_id) {
    echo json_encode([]);
    exit;
}

$con = dbConnect();

// Verify that the hostel belongs to this owner
$stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $hostel_id, $user_id);
$stmt->execute();
$hostel = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$hostel) {
    echo json_encode([]);
    exit;
}

// Fetch rooms
$stmt = $con->prepare("SELECT * FROM tbl_room WHERE hostel_id = ? and is_deleted = 0 ");
$stmt->bind_param("i", $hostel_id);
$stmt->execute();
$result = $stmt->get_result();
$rooms = [];
while($row = $result->fetch_assoc()){
    $rooms[] = $row;
}
$stmt->close();

echo json_encode($rooms);
