<?php
require_once 'func.php'; // your database connection

if(isset($_GET['id'])) {
    $districtID = intval($_GET['id']);
    $stmt = dbConnect()->prepare("SELECT * FROM tbl_municipality WHERE district_id = ?");
    $stmt->bind_param("i", $districtID);
    $stmt->execute();
    $result = $stmt->get_result();
    $municipalities = [];
    while($row = $result->fetch_assoc()) $municipalities[] = $row;
    header('Content-Type: application/json');
    echo json_encode($municipalities);
}
