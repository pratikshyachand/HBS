<?php
session_start();
require_once 'func.php';

$conn = dbConnect();

// Fetch all bookings for the hostel owner
$owner_id = $_SESSION['user_id'] ?? 0; // Logged-in hostel owner
if (!$owner_id) {
    echo "<tr><td colspan='6'>No owner logged in</td></tr>";
    exit;
}

// Get all bookings related to hostels of this owner
$sql = "SELECT b.id AS booking_id, h.hostel_name, b.room_id, r.room_type, b.booked_beds, b.status
        FROM tbl_booking b
        JOIN tbl_room r ON b.room_id = r.id
        JOIN tbl_hostel h ON r.hostel_id = h.id
        WHERE h.user_id = ?
        ORDER BY b.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".htmlspecialchars($row['booking_id'])."</td>";
        echo "<td>".htmlspecialchars($row['hostel_name'])."</td>";
        echo "<td>".htmlspecialchars($row['room_id'])."</td>";
        echo "<td>".htmlspecialchars($row['room_type'])."</td>";
        echo "<td>".htmlspecialchars($row['booked_beds'])."</td>";
        echo "<td>".htmlspecialchars($row['status'])."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No bookings found</td></tr>";
}

$stmt->close();
$conn->close();
