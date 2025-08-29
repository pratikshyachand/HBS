<?php
session_start();
require_once 'auth_check.php';
require_once 'func.php';



$user_id = $_SESSION['user_id']; 

if(isset($_POST['pay_now'])) {
    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;

    if (!$booking_id) {
        die("Invalid booking ID.");
    }

    // Get booking details
    $booking = getBookingDetails($booking_id);

           

    if (!$booking) {
        die("Booking not found.");
    }

    $card_number = $_POST['cardNumber'] ?? '';
    $card_name   = $_POST['cardName'] ?? '';
    $expiry_date = $_POST['expiryDate'] ?? '';
    $cvv         = $_POST['cvv'] ?? '';

    $amount  = $booking['total']; 
    $beds_to_book = $booking['booked_beds'];
    $room_id = $booking['room_id'];

    $con = dbConnect();
    $con->begin_transaction();

    try {
        // Insert payment
        $stmt = $con->prepare("
            INSERT INTO tbl_payment 
            (booking_id, user_id, amount, card_number, card_name, expiry_date, cvv, payment_date, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'Completed')
        ");
        $stmt->bind_param("iiissss", $booking_id, $user_id, $amount, $card_number, $card_name, $expiry_date, $cvv);
        $stmt->execute();
        $stmt->close();

       
     $sql = "SELECT room_id, booked_beds, status FROM tbl_booking WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("i", $booking_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $booking = $result->fetch_assoc();
            $stmt->close();

     // Increase available beds in the room
            $sql = "UPDATE tbl_room SET available_beds = available_beds + ? WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ii", $beds_to_book , $room_id);
            $stmt->execute();
            $stmt->close();


        // If cancellation exists, mark refund as 'Completed'
        $stmt = $con->prepare("UPDATE tbl_cancellation_refund SET refund_status = 'Completed' WHERE booking_id = ?");
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $stmt->close();

        //  Notifications
        $stmt = $con->prepare("
            SELECT h.user_id AS owner_id, h.hostel_name, b.user_id AS seeker
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
            $owner_id   = $row['owner_id'];
            $hostelName = $row['hostel_name'];
            $seeker = $row['seeker'];

            // Notify owner
            $message = "✅ Refund completed for: Booking ID:" . $booking_id;
            $link = "/frontend/hostel_owner/booking_detailsO.php?id=" . $booking_id;

            $notif_stmt = $con->prepare("INSERT INTO notifications (recipient_id, message, link) VALUES (?,?,?)");
            $notif_stmt->bind_param("iss", $owner_id, $message, $link);
            $notif_stmt->execute();
            $notif_stmt->close();

            // Notify user
            $userMessage = "✅ " . $hostelName . " refunded for your cancelled booking id: " . $booking_id;
            $userLink    = "/frontend/seeker/booking_detailS.php?id=" . $booking_id;

            $notif_stmt2 = $con->prepare("INSERT INTO notifications (recipient_id, message, link) VALUES (?,?,?)");
            $notif_stmt2->bind_param("iss", $seeker, $userMessage, $userLink);
            $notif_stmt2->execute();
            $notif_stmt2->close();
        }

        $con->commit();
         $popup_message[] = "✅ Refund successful!  ";
    } catch (Exception $e) {
        $con->rollback();
        die("❌ Payment processing failed: " . $e->getMessage());
    }
}
?>
