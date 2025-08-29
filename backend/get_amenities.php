<?php
require 'func.php';
$conn = dbConnect();

if (isset($_GET['hostel_id'])) {
    $hostel_id = intval($_GET['hostel_id']);

    $stmt = $conn->prepare("SELECT id, name FROM tbl_amenities WHERE hostel_id = ?");
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $amenities = [];
    while ($row = $result->fetch_assoc()) {
        $amenities[] = $row;
    }

    echo json_encode($amenities);
    exit();
}
?>
