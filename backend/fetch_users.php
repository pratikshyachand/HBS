<?php
require_once 'func.php';

$conn = dbConnect();

$sql = "SELECT id, first_name, last_name, email FROM tbl_users";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

if ($result->num_rows > 0) {
    $sn = 1; // serial number counter
    while ($row = $result->fetch_assoc()) {
        echo "<tr id='row-" . $row['id'] . "'>";
        echo "<td>" . $sn++ . "</td>"; // S.N instead of id
        echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>
                <button class='delete-btn' data-id='" . $row['id'] . "'>
                    <i class='fas fa-trash' style='color:red;'></i>
                </button>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}

$conn->close();
?>
