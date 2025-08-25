<?php
require_once '../select_hostel.php';
require_once '../func.php';

header('Content-Type: application/json'); // Tell browser to expect JSON

$inputJSON = file_get_contents('php://input'); // Read the raw request body
$input = json_decode($inputJSON, true); // Decode JSON into a PHP associative array

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON received.']);
    exit();
}

$amenityID = $input['amenityID'] ?? null;

if (!$amenityID) {
    echo json_encode(['success' => false, 'message' => 'Missing data.']);
    exit();
}


$mysqli = dbConnect();
$query = "delete from tbl_amenities where id = '$amenityID'";
if ($mysqli->query($query) != TRUE)
            echo "Error updating: " . $mysqli->error;
        $mysqli->close();

echo json_encode(["success" => true]); // Output JSON