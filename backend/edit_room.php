<?php
require_once 'func.php'; 

$popup_message = [];

//user clicked save changes button after making changes to room details
if (isset($_POST['btn_submit']) && isset($_GET['id'])) {
    $room_id = intval($_GET['id']);
    $room_type = $_POST['room_type'];
    $beds = intval($_POST['no_of_beds']);
    $price = floatval($_POST['price']);

    $conn = dbConnect();
    
    // Fetch existing image
    $sqlFetch = "SELECT images FROM tbl_room WHERE id = ?";
    $stmtFetch = $conn->prepare($sqlFetch);
    $stmtFetch->bind_param("i", $room_id);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();
    $room = $result->fetch_assoc();
    $imagePath = $room['images']; 
    $stmtFetch->close();

    // If new image is uploaded, replace it
    if (!empty($_FILES['room_images']['name'])) {
        $targetDir = "../../uploads/rooms/";
        $fileName = time() . '_' . basename($_FILES['room_images']['name']);
        $targetFile = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['room_images']['tmp_name'], $targetFile)) {
            $imagePath = "uploads/rooms/" . $fileName;
        } else {
            $popup_message[] = "❗Failed to upload image.";
        }
    }

    // If no image exists at all, show error
    if (empty($imagePath)) {
        $popup_message[] = "⚠️ Please select an image for the room.";
    }

    // Update room only if no error
    if (empty($popup_message)) {
        $sqlUpdate = "UPDATE tbl_room SET room_type=?, total_beds=?, price=?, images=? WHERE id=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sidsi", $room_type, $beds, $price, $imagePath, $room_id);

        if ($stmtUpdate->execute()) {
            $popup_message[] = "✅ Room updated successfully!";
        } else {
            $popup_message[] = "❗Error updating room.";
        }

        $stmtUpdate->close();
    }

    $conn->close();
}
?>
