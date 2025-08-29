<?php
require_once '../../backend/func.php';
$conn = dbConnect();

$sql = "SELECT h.id, h.hostel_name, h.status, h.type, h.image, h.description,
               p.id AS province_id, p.title AS province_name,
               d.id AS district_id, d.title AS district_name,
               m.id AS municipality_id, m.title AS municipality_name
        FROM tbl_hostel h
        LEFT JOIN tbl_province p ON h.province_id = p.id
        LEFT JOIN tbl_district d ON h.district_id = d.id
        LEFT JOIN tbl_municipality m ON h.municip_id = m.id
        WHERE h.is_delete = 0 AND h.status = 'Approved'";

$result = $conn->query($sql);
?>

<div class="hostel-grid">

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="hostel-card"
             data-type="<?php echo strtolower($row['type']); ?>"
             data-province="<?php echo $row['province_id']; ?>"
             data-district="<?php echo $row['district_id']; ?>"
             data-municipality="<?php echo $row['municipality_id']; ?>">

            <a href="../../frontend/seeker/hostelProfileS.php?hostel_id=<?= $row['id'] ?>">
                <img src="/frontend/hostel_owner/<?php echo !empty($row['image']) ? htmlspecialchars($row['image']) : 'default.svg'; ?>" 
                     alt="<?php echo htmlspecialchars($row['hostel_name']); ?>">
            </a>

            <h3 class="hostel-name"><?php echo htmlspecialchars($row['hostel_name']); ?></h3>
            <p class="hostel-location">
                <i class="fas fa-map-marker-alt"></i> 
                <?php echo htmlspecialchars($row['municipality_name'] . ', ' . $row['district_name']); ?>
            </p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No hostels found.</p>
<?php endif; ?>

</div>
