<?php
require_once 'func.php'; // DB connection functions

$booking_id = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
function getBookingDetails(int $booking_id): ?array {
    $conn = dbConnect();
    $sql = "SELECT b.id AS booking_id, b.user_id, b.room_id, b.booked_beds, b.check_in, b.check_out,r.images, r.room_type, r.price, r.hostel_id AS room_hostel_id, h.id AS hostel_id, h.hostel_name, h.description, p.title AS province_name, d.title AS district_name, m.title AS municipality_name FROM tbl_booking b JOIN tbl_room r ON b.room_id = r.id JOIN tbl_hostel h ON r.hostel_id = h.id JOIN tbl_province p ON h.province_id = p.id JOIN tbl_district d ON h.district_id = d.id JOIN tbl_municipality m ON h.municip_id = m.id WHERE b.id = ?"; 

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$res) return null;

    // Calculate duration in nights
    $check_in = new DateTime($res['check_in']);
    $check_out = new DateTime($res['check_out']);
    $duration = $check_out->diff($check_in)->days;
    $res['duration'] = $duration > 0 ? $duration : 1; // at least 1 night

    // Room charge
    $res['room_charge'] = $res['price'] * $res['booked_beds'] * $res['duration'];

    // Service fee (fixed for example)
    $res['service_fee'] = 1000; 

    // Tax 10% of (room_charge + service_fee)
    $res['tax'] = round(0.1 * ($res['room_charge'] + $res['service_fee']), 2);

    // Total
    $res['total'] = $res['room_charge'] + $res['service_fee'] + $res['tax'];

    return $res;
}
