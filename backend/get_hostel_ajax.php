<?php
require_once "func.php";

if(isset($_POST['hostel_id'])) {
    $hostel_id = (int)$_POST['hostel_id'];
    $con = dbConnect();
    $stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE id = ?");
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hostel = $result->fetch_assoc();
    $stmt->close();

    header('Content-Type: application/json');
    echo json_encode($hostel);
    exit();
}
?>
