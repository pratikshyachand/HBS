<?php
require_once 'func.php';
session_start();

header('Content-Type: application/json');

$con = dbConnect();

$user_id = $_SESSION['user_id']; 
$role    = $_SESSION['role'];  

if ($role === "admin") {
    // Admin sees only hostel registration requests (global notifications)
    $sql = "SELECT id, message, link, is_read, created_at 
            FROM notifications 
            WHERE recipient_id IS NULL 
            ORDER BY created_at DESC";
    $res = $con->query($sql);

} else {
    $sql = "SELECT id, message, link, is_read, created_at 
            FROM notifications 
            WHERE recipient_id = ?
            ORDER BY created_at DESC";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

} 

$notifications = [];
while ($row = $res->fetch_assoc()) {
    $notifications[] = [
        'id'        => $row['id'],
        'message'   => $row['message'],
        'link'      => $row['link'],
        'is_read'   => $row['is_read'],
        'created_at'=> date("M j, Y H:i", strtotime($row['created_at']))
    ];
}

echo json_encode([
    'count' => count(array_filter($notifications, fn($n) => $n['is_read'] == 0)), // badge count only unread
    'notifications' => $notifications
]);
