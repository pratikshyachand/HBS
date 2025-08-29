<?php
session_start();
require_once 'auth_check.php';
require_once 'fetch_booking.php'; 

$user_id = $_SESSION['user_id'];

if(isset($_POST['pay_now'])) {
    $booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;

    if (!$booking_id) {
        die("Invalid booking ID.");
    }

    // Get booking details (calculated total included)
    $booking = getBookingDetails($booking_id);
    if (!$booking) {
        die("Booking not found.");
    }

    // Collect card/payment info
    $card_number = $_POST['cardNumber'] ?? '';
    $card_name   = $_POST['cardName'] ?? '';
    $expiry_date = $_POST['expiryDate'] ?? '';
    $cvv         = $_POST['cvv'] ?? '';

    $user_id = $booking['user_id'];
    $amount  = $booking['total']; 
    $beds_to_book = $booking['booked_beds'];
    $room_id = $booking['room_id'];

    $con = dbConnect();

    // Insert payment
    $stmt = $con->prepare("
        INSERT INTO tbl_payment 
        (booking_id, user_id, amount, card_number, card_name, expiry_date, cvv, payment_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param(
        "iiissss",
        $booking_id,
        $user_id,
        $amount,
        $card_number,
        $card_name,
        $expiry_date,
        $cvv
    );
    if (!$stmt->execute()) {
        die("Payment failed: " . $stmt->error);
    }
    $stmt->close();

        // Update payment status
    $stmt = $con->prepare("UPDATE tbl_payment SET status = 'Completed' WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();

    // Update booking status
    $stmt = $con->prepare("UPDATE tbl_booking SET status = 'booked' WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();

     // Decrement available beds
        $updSql = "UPDATE tbl_room SET available_beds = available_beds - ? WHERE id = ?";
        $stmt = $con->prepare($updSql);
        $stmt->bind_param("ii", $beds_to_book, $room_id);
        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            $con->rollback();
            return ['ok' => false, 'msg' => "Update failed: $err"];
        }
        $stmt->close();

    $popup_message[] = "✅ Payment successful!  ";

    // After updating payment, booking and beds...
// Send notification to hostel owner about new booking
try {
    // Get hostel owner from the booking
    $stmt = $con->prepare("
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
        $owner_id   = $row['owner_id'];
        $hostelName = $row['hostel_name'];
        
        $message = "📝 New booking confirmed for hostel: " . $hostelName;
        $link = "/frontend/hostel_owner/booking_detailsO.php?id=" . $booking_id;

        $notif_stmt = $con->prepare("INSERT INTO notifications (recipient_id, message, link) VALUES (?,?,?)");
        $notif_stmt->bind_param("iss", $owner_id, $message, $link);
        $notif_stmt->execute();
        $notif_stmt->close();

        //notify user 
         // 2️⃣ Notify the user who booked
    $userMessage = "✅ Your booking at " . $hostelName . " has been confirmed!";
    $userLink    = "/frontend/seeker/booking_detailS.php?id=" . $booking_id;

    $notif_stmt2 = $con->prepare("INSERT INTO notifications (recipient_id, message, link) VALUES (?,?,?)");
    $notif_stmt2->bind_param("iss", $user_id, $userMessage, $userLink);
    $notif_stmt2->execute();
    $notif_stmt2->close();
    }
   
} catch (mysqli_sql_exception $e) {
    error_log("Notification insert failed: " . $e->getMessage());
}

}
?>
