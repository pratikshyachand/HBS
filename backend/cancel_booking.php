<?php
require_once 'func.php';
session_start();

$user = $_SESSION['user_id'];

// Set JSON header
header('Content-Type: application/json');

// Default response
$response = [
    'success' => false,
    'message' => ''
];

// Check if booking_id is sent
if (isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']); 
    $conn = dbConnect();

    if ($conn) {
        // Start transaction
        $conn->begin_transaction();
        try {
            // 1. Get booking details
            $sql = "SELECT room_id, booked_beds, status FROM tbl_booking WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $booking = $result->fetch_assoc();
            $stmt->close();

            if (!$booking) {
                throw new Exception("Booking not found.");
            }

             // Check if already cancelled
            if ($booking['status'] === 'cancelled') {
                $response['message'] = "⚠️ Booking ID $booking_id is already cancelled.";
                echo json_encode($response);
                exit;
            }

            $room_id = $booking['room_id'];
            $booked_beds = $booking['booked_beds'];

            // 2. Update booking status
            $sql = "UPDATE tbl_booking SET status = 'cancelled' WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $stmt->close();

            // 3. Update payment status (if you have a payment table)
            $sql = "UPDATE tbl_payment SET status = 'cancelled' WHERE booking_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $stmt->close();

          
            // 4. Insert into cancellation/refund table
$sql = "INSERT INTO tbl_cancellation_refund (booking_id) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$stmt->close();

            // 5. Get hostel owner and hostel name
               $stmt = $conn->prepare("
        SELECT h.user_id AS owner_id, h.hostel_name 
        FROM tbl_booking b
        JOIN tbl_room r ON b.room_id = r.id
        JOIN tbl_hostel h ON r.hostel_id = h.id
        WHERE b.id = ?
    ");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

            if ($row) {
                $owner_id = $row['owner_id'];
                $hostel_name = $row['hostel_name'];
                $msg = "❌ Booking ID: $booking_id has been cancelled for hostel '$hostel_name'. Click tab to refund.";
                $link = "booking_detailsO.php?id=" . $booking_id;

                $stmt = $conn->prepare("INSERT INTO notifications (recipient_id, message, link) VALUES (?, ?, ?)");
                $stmt->bind_param("iss", $owner_id, $msg, $link);
                $stmt->execute();
                $stmt->close();


    // Notify the user who booked
    $userMessage = "🔔  Your booking at " . $hostel_name . " has been cancelled! Request for refund sent.";
    $userLink    = "/frontend/seeker/booking_detailS.php?id=" . $booking_id;

    $notif_stmt2 = $conn->prepare("INSERT INTO notifications (recipient_id, message, link) VALUES (?,?,?)");
    $notif_stmt2->bind_param("iss", $user, $userMessage, $userLink);
    $notif_stmt2->execute();
    $notif_stmt2->close();
            }

            $conn->commit();

            $response['success'] = true;
            $response['message'] = "✅ Booking cancelled successfully!";

            
            


        } catch (Exception $e) {
            $conn->rollback();
            $response['message'] = "❌ Error cancelling booking: " . $e->getMessage();
        }

        $conn->close();
    } else {
        $response['message'] = "❌ Database connection failed.";
    }
} else {
    $response['message'] = "❌ Booking ID not provided.";
}

// Send JSON response
echo json_encode($response);
exit;
