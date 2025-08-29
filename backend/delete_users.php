<?php
require_once 'func.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $conn = dbConnect();

    $sql = "UPDATE tbl_users  set is_delete=1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
    $conn->close();
}
?>
