<?php

require_once  'func.php'; 


function getUser(int $user_id): ?array {
    $conn = dbConnect();
    $sql = "SELECT id, first_name, last_name, email FROM tbl_users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $res ?: null;
}

/**
 * Get room info
 */
function getRoomDetails(int $room_id): ?array {
  $conn = dbConnect();
    $sql = "SELECT id, hostel_id, room_type, total_beds, available_beds, price, images
            FROM tbl_room WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $res ?: null;
}

/**
 * Book room with race-safe check (transaction + SELECT ... FOR UPDATE)
 * - Inserts into tbl_booking (admission_fee defaults 0.00, status='booked')
 * - Decrements available_beds
 */
function bookRoom(int $user_id, int $room_id, int $beds_to_book, string $check_in, string $check_out): array {
    $conn = dbConnect();
    $conn->begin_transaction();

    try {
        // Lock room row
        $lockSql = "SELECT available_beds FROM tbl_room WHERE id = ? FOR UPDATE";
        $stmt = $conn->prepare($lockSql);
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $stmt->bind_result($available_beds);
        $rowFound = $stmt->fetch();
        $stmt->close();

        if (!$rowFound) {
            $conn->rollback();
            return ['ok' => false, 'msg' => 'Room not found'];
        }

        if ($beds_to_book < 1) {
            $conn->rollback();
            return ['ok' => false, 'msg' => 'Invalid number of beds'];
        }

        if ($beds_to_book > $available_beds) {
            $conn->rollback();
            return ['ok' => false, 'msg' => 'Not enough available beds'];
        }

        // Insert booking
        
        $insSql = "INSERT INTO tbl_booking (user_id, room_id, check_in, check_out, booked_beds)
                   VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insSql);
        $stmt->bind_param("iissi", $user_id, $room_id, $check_in, $check_out, $beds_to_book);

        if (!$stmt->execute()) {
            $err = $stmt->error;
            $stmt->close();
            $conn->rollback();
            return ['ok' => false, 'msg' => "Booking failed: $err"];
        }

        $booking_id = $stmt->insert_id;
        $stmt->close();

       

        $conn->commit();

        // Redirect to payment page with correct booking_id
        header("Location: ../seeker/payment.php?booking_id={$booking_id}");
        exit;

    } catch (Throwable $e) {
        $conn->rollback();
        return ['ok' => false, 'msg' => 'Transaction error: ' . $e->getMessage()];
    }
}

