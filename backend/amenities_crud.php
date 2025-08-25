<?php
require_once 'func.php';

//$hostelId = $_GET['hostel_id'] ?? 0;


    // Add new amenity
    if (isset($_POST['btn_save'])) {
        $conn = dbConnect();
        $hostel_id = $_POST['hostel_id'];
        $amenity_name = trim($_POST['amenity_name']);

        if (!empty($hostel_id) && !empty($amenity_name)) {
            $stmt = $conn->prepare("INSERT INTO tbl_amenities (hostel_id, name) VALUES (?, ?)");
            $stmt->bind_param("is", $hostel_id, $amenity_name);
            $res = $stmt->execute();
            if ($amenity_name === $res['name']) {
            $popup_message = "⚠️ Amenity already exists";
           
             $popup_message = "✅ Amenity added successfully!";
            }
        } else {
            echo "empty";
        }
        $conn->close();
    }

    // Update amenity
    if (isset($_POST['btn_update'])) {
        $conn = dbConnect();
        $id = $_POST['amenity_id'];
        $amenity_name = trim($_POST['amenity_name']);

        if (!empty($id) && !empty($amenity_name)) {
            $stmt = $conn->prepare("UPDATE tbl_amenity SET name=? WHERE id=?");
            $stmt->bind_param("si", $amenity_name, $id);
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "empty";
        }
        $conn->close();
    }

    // Delete amenity
    if (isset($_POST['btn_delete'])) {
        $conn = dbConnect();
        $id = $_POST['amenity_id'];

        if (!empty($id)) {
            $stmt = $conn->prepare("DELETE FROM tbl_amenity WHERE id=?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "empty";
        }
        $conn->close();
    }