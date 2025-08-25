<?php
session_start();
require_once '../../backend/func.php';
require_once '../../backend/auth_check.php';

$conn = dbConnect();
$user_id = $_SESSION['user_id'];

$sql = "SELECT h.id, h.hostel_name, h.status, h.image, h.description, h.user_id,
               p.title AS province_name, d.title AS district_name, m.title AS municipality_name
        FROM tbl_hostel h
        LEFT JOIN tbl_province p ON h.province_id = p.id
        LEFT JOIN tbl_district d ON h.district_id = d.id
        LEFT JOIN tbl_municipality m ON h.municip_id = m.id
        WHERE h.is_delete = 0 AND h.status = 'Approved' AND h.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>


        <div class="hostel-grid">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="hostel-card">
                    <a href="hostelProfile_sum.php?hostel_id=<?= $row['id'] ?>"><img src="/frontend/hostel_owner/<?php echo !empty($row['image']) ? htmlspecialchars($row['image']) : 'default.svg'; ?>" 
                         alt="<?php echo htmlspecialchars($row['hostel_name']); ?>"></a>

                    <h3 class="hostel-name"><?php echo htmlspecialchars($row['hostel_name']); ?></h3>
                    <p class="hostel-location">
                        <i class="fas fa-map-marker-alt"></i> 
                        <?php echo htmlspecialchars($row['municipality_name'] . ', ' . $row['district_name'] ); ?>
                    </p>

                    <div class="rating-view">
                        <?php if ($row['status'] === 'Approved'): ?>
                            <div class="rating">
                               
                            </div>
                            
                        <?php else: ?>
                            <div class="rating">
                                <p class="not-approved">Hostel not approved yet</p>
                            </div>
                            
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hostels registered yet.</p>
        <?php endif; ?>

        </div>
    

