<?php
require_once 'func.php';
header('Content-Type: application/json');

$con = dbConnect();

$sql = "SELECT id, message, link, created_at 
        FROM notifications 
        WHERE is_read = 0 
        ORDER BY created_at DESC 
        LIMIT 5";

$res = $con->query($sql);

$notifications = [];
while ($row = $res->fetch_assoc()) {
    $notifications[] = [
        'id' => $row['id'],
        'message' => $row['message'],
        'link' => $row['link'],
        'created_at' => date("M j, Y H:i", strtotime($row['created_at']))
    ];
}

echo json_encode([
    'count' => count($notifications),
    'notifications' => $notifications
]);


