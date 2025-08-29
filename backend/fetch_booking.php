<?php
require_once 'func.php'; // DB connection functions

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;

function getBookingDetails(int $booking_id): ?array {
    $conn = dbConnect();

    $sql = "SELECT 
                b.id AS booking_id,b.status, b.user_id, b.room_id AS room_id, b.booked_beds, b.check_in, b.check_out,
                r.images, r.room_type, r.price, r.hostel_id AS room_hostel_id,
                h.id AS hostel_id, h.hostel_name, h.description, h.admission_fee,
                p.title AS province_name, d.title AS district_name, m.title AS municipality_name,
                u.first_name, u.last_name, u.contact AS user_contact
            FROM tbl_booking b
            JOIN tbl_room r ON b.room_id = r.id
            JOIN tbl_hostel h ON r.hostel_id = h.id
            JOIN tbl_users u ON b.user_id = u.id
            JOIN tbl_province p ON h.province_id = p.id
            JOIN tbl_district d ON h.district_id = d.id
            JOIN tbl_municipality m ON h.municip_id = m.id
            WHERE b.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$res) return null;

    // Combine first and last name
    $res['user_name'] = trim($res['first_name'] . ' ' . $res['last_name']);

    // Calculate duration in nights
    $check_in = new DateTime($res['check_in']);
    $check_out = new DateTime($res['check_out']);
    $duration = $check_out->diff($check_in)->days;
    $res['duration'] = $duration > 0 ? $duration : 1; // at least 1 night

    // Room charge
    $res['room_charge'] = $res['price'] * $res['booked_beds'] * $res['duration'];

   

  
    // Total including admission fee
    $res['total'] = $res['room_charge'] + $res['admission_fee'];

    return $res;
}
