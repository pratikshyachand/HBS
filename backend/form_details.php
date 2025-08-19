<?php
include 'func.php';  // Your DB connection file
$conn = dbConnect();

// Get hostel ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("Invalid hostel ID.");
}

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

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Hostel not found.");
}

$location = $row['municipality_name'] . ', ' . $row['district_name'] . ', ' . $row['province_name'];


function safe($value) {
    return htmlspecialchars($value);
}


// //on approval set status to approved

if (isset($_POST['btn_approve'])) {
    $hostel_id = (int)$_POST['hostel_id'];

    $stmt = $conn->prepare("SELECT  user_id, hostel_name, status FROM tbl_hostel WHERE id = ?");
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hostel = $result->fetch_assoc();

    if (!$hostel) {
        die("Hostel not found.");
    }

    $hostel_name = $hostel['hostel_name'];
    $user_id = $hostel['user_id'];
    $status = $hostel['status'];

    
    if ($status === 'Approved') {
    $popup_message = "❗ This hostel is already approved.";
    $popup_type = "warning";
} elseif ($status === 'Rejected') {
    $popup_message = "❗ This hostel has already been rejected.";
    $popup_type = "warning";
} else {
    $status = 'Approved';
    $stmt = $conn->prepare("UPDATE tbl_hostel SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $hostel_id);
    $stmt->execute();
    $popup_message = "✅ Hostel approved successfully!";
    $popup_type = "success";
}
    
    
} 


//on reject

if (isset($_POST['btn_reject'])) {
    $hostel_id = (int)$_POST['hostel_id'];

    $stmt = $conn->prepare("SELECT user_id, hostel_name, status FROM tbl_hostel WHERE id = ?");
    $stmt->bind_param("i", $hostel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hostel = $result->fetch_assoc();
    

    if (!$hostel) {
        die("Hostel not found.");
    }

    $hostel_name = $hostel['hostel_name'];
    $user_id = $hostel['user_id'];
    $status = $hostel['status'];


    if ($status === 'Approved') {
    $popup_message = "❗ This hostel is already approved.";
    $popup_type = "warning";
} elseif ($status === 'Rejected') {
    $popup_message = "❗ This hostel has already been rejected.";
    $popup_type = "warning";
} else {
    $status = 'Rejected';
    $stmt = $conn->prepare("UPDATE tbl_hostel SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $hostel_id);
    $stmt->execute();
    $popup_message = "❌ Hostel rejected successfully.";
    $popup_type = "error";
}

    
}

?>
