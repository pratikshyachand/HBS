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

$hostelID = $input['hostelID'] ?? null;

if (!$hostelID) {
    echo json_encode(['success' => false, 'message' => 'Missing data.']);
    exit();
}


$mysqli = dbConnect();
$query = "select name from tbl_amenities where hostel_id = '$hostelID'";
$amenities = [];
if ($result = $mysqli->query($query))
/*->num_rows > 0*/ {
    while($row = $result->fetch_assoc()) {
        $amenities[] = $row;
    }
}
else{
    echo $mysqli->error;
    exit();
}
$mysqli->close();

echo json_encode(["success" => true,
                  "amenities" => $amenities,
                ]); // Output JSON