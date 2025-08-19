<?php
require_once 'func.php';
session_start();

$con = dbConnect();

if (isset($_POST['id'])) {
    $notif_id = intval($_POST['id']);
    $sql = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $notif_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>