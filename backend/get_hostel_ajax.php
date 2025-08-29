<?php
require_once "func.php";
session_start();

if(isset($_POST['hostel_id'])) {
    $hostel_id = (int)$_POST['hostel_id'];
    $con = dbConnect();

    $stmt = $con->prepare("SELECT * FROM tbl_hostel WHERE id=?");
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $hostel = $res->fetch_assoc();
    $stmt->close();

    // Fetch amenities
    $amenities = [];
    $stmt2 = $con->prepare("SELECT amenity_id FROM tbl_hostel_amenities WHERE hostel_id=?");
    $stmt2->bind_param("i", $hostel_id);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    while($row = $res2->fetch_assoc()) {
        $amenities[] = (int)$row['amenity_id'];
    }
    $stmt2->close();

    $hostel['amenities'] = $amenities;

    echo json_encode($hostel);
}
?>
