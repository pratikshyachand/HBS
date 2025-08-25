<?php
require 'db.php';

$search = $_GET['search'] ?? '';
$province = $_GET['province'] ?? '';
$type = $_GET['type'] ?? 'All';

$con = dbConnect();

$query = "SELECT * FROM tbl_hostels WHERE 1=1";
$params = [];
$types = '';

if($province !== '') {
    $query .= " AND province_id = ?";
    $params[] = $province;
    $types .= 'i';
}

if($type !== '' && $type !== 'All') {
    $query .= " AND type = ?";
    $params[] = $type;
    $types .= 's';
}

if($search !== '') {
    $query .= " AND name LIKE ?";
    $params[] = "%$search%";
    $types .= 's';
}

$stmt = $con->prepare($query);
if($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    echo "<div class='hostel-card'>";
    echo "<img src='images/{$row['image']}' alt='{$row['name']}'>";
    echo "<div class='hostel-info'>";
    echo "<h3>{$row['name']}</h3>";
    echo "<p>{$row['address']}</p>";
    echo "</div></div>";
}
