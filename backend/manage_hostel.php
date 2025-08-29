<?php
include 'func.php';
$conn = dbConnect();

$query = "SELECT 
            h.id, 
            h.hostel_name, 
            h.owner, 
            h.email, 
            h.contact, 
            p.title AS province_name, 
            d.title AS district_name, 
            m.title AS municipality_name, 
            h.date_registered, 
            h.status
          FROM tbl_hostel h
          LEFT JOIN tbl_province p ON h.province_id = p.id
          LEFT JOIN tbl_district d ON h.district_id = d.id
          LEFT JOIN tbl_municipality m ON h.municip_id = m.id where is_delete=0
          ORDER BY h.date_registered DESC";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusColor = ($row['status'] == 'Pending') ? 'orange' : 
                       (($row['status'] == 'Approved') ? 'green' : 'red');

$location = $row['municipality_name'] . ', ' . $row['district_name'] . ', ' . $row['province_name'];
       echo "<td>{$row['id']}</td>";
        echo "<td>{$row['hostel_name']}</td>";
        echo "<td>{$row['owner']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$location}</td>";
        echo "<td>" . date("Y-m-d", strtotime($row['date_registered'])) . "</td>";
        echo "<td><span style='color: {$statusColor};'>{$row['status']}</span></td>";
        echo "<td>
                    <button class='delete-btn' data-id='{$row['id']}' style='padding:5px 10px; border:none; background:#e74c3c; color:#fff; border-radius:5px; cursor:pointer;'>Delete</button>
                </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hostel registration requests found</td></tr>";
}
?>
