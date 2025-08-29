<?php
session_start();
require_once "func.php";

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
 
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
 
}

$con = dbConnect();

// Check hostel_id parameter
if (!isset($_GET['hostel_id'])) {
    die("Hostel not specified.");
}

$hostel_id = (int)$_GET['hostel_id'];




// Fetch hostel

    $query = "SELECT 
                h.*, 
                p.title AS province_name, 
                d.title AS district_name, 
                m.title AS municipality_name
              FROM tbl_hostel h
              LEFT JOIN tbl_province p ON h.province_id = p.id
              LEFT JOIN tbl_district d ON h.district_id = d.id
              LEFT JOIN tbl_municipality m ON h.municip_id = m.id
              WHERE h.id = ?
              LIMIT 1";

    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $hostel = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Concatenate location
    if ($hostel) {
        $location = $hostel['municipality_name'] . ', ' . $hostel['district_name'] . ', ' . $hostel['province_name'];
        $hostel['full_location'] = $location;
    }



if (!$hostel) {
    die("Hostel not found or you do not have permission to view it.");
}


// Fetch amenities
$stmt = $con->prepare("SELECT a.id, a.name 
    FROM tbl_amenities a
    INNER JOIN tbl_hostel_amenities ha ON a.id = ha.amenity_id
    WHERE ha.hostel_id = ?");
$stmt->bind_param("i", $hostel_id);
$stmt->execute();
$amenities = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch rooms
if($role === 'seeker')
{
$stmt = $con->prepare("SELECT * FROM tbl_room WHERE hostel_id=? and available_beds >0");
$stmt->bind_param("i", $hostel_id);
$stmt->execute();
$rooms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
}

else{
   $stmt = $con->prepare("SELECT * FROM tbl_room WHERE hostel_id=? ");
$stmt->bind_param("i", $hostel_id);
$stmt->execute();
$rooms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close(); 
}
?>