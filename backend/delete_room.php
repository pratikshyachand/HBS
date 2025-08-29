<?php
require_once 'func.php';

$popup_message =[];
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $conn = dbConnect();
   

     // Soft delete: set is_deleted = 1
    $sql = "UPDATE tbl_room SET is_deleted = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete room']);
    }

    $stmt->close();
    $conn->close();
}
?>
