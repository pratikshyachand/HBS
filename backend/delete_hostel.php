<?php
require_once 'func.php';
session_start();

// Set JSON header for JS
header('Content-Type: application/json');

// Default response
$response = [
    'success' => false,
    'message' => ''
];

// Check if ID is sent
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // sanitize input
    $conn = dbConnect();

    if ($conn) {
        // Make sure the column matches your DB (id or hostel_id)
        $sql = "UPDATE tbl_hostel SET is_delete = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "✅ Hostel deleted successfully!";
        } else {
            $response['message'] = "❌ Error deleting hostel. Try again.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $response['message'] = "❌ Database connection failed.";
    }
} else {
    $response['message'] = "❌ Hostel ID not provided.";
}

// Send JSON response
echo json_encode($response);
exit;
?>
