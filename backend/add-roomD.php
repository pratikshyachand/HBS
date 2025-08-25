<?php
require_once 'func.php';
$conn = dbConnect();
$popup_message = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hostel_id    = mysqli_real_escape_string($conn, $_POST['hostel_id'] ?? '');
    $room_type    = mysqli_real_escape_string($conn, $_POST['room_type'] ?? '');
    $total_beds   = intval($_POST['no_of_beds'] ?? 0);
    $price        = floatval($_POST['price'] ?? 0);

    // Validation
    if (empty($hostel_id) || empty($room_type) || $total_beds <= 0 || $price <= 0) {
        $popup_message = "⚠️ Please fill all fields correctly.";
    } else {
        $available_beds = $total_beds;

        $imgPath = null;
        if (!empty($_FILES['room_images']['name'][0])) {
            $uploadDir = "../../uploads/rooms/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $tmp_name = $_FILES['room_images']['tmp_name'][0];
            $fileName = basename($_FILES['room_images']['name'][0]);
            $targetFile = $uploadDir . time() . "_" . $fileName;

            if ($_FILES['room_images']['size'][0] <= 4 * 1024 * 1024 && move_uploaded_file($tmp_name, $targetFile)) {
                $imgPath = str_replace("../../", "", $targetFile); // relative path for DB
            }
        }

        // Insert into tbl_room including image column
        $query = "INSERT INTO tbl_room (hostel_id, room_type, total_beds, available_beds, price, images) 
                  VALUES ('$hostel_id', '$room_type', '$total_beds', '$available_beds', '$price', '$imgPath')";
        
        if (mysqli_query($conn, $query)) {
            $popup_message[] = "✅ Room added successfully!";
        } else {
            $popup_message[] = "❌ Error: " . mysqli_error($conn) ;
        }
    }
}
?>
