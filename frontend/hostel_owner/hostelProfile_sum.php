<?php
session_start();
require_once '../../backend/auth_check.php';
require_once '../../backend/hostel_profile.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Hostels</title>
    <link rel="stylesheet" href="css/hostel-registration.css" />
    <link rel="stylesheet" href="/frontend/css/hostel-grid.css" />
    <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css" />
    <link rel="stylesheet" href="css/myHostels.css" />
    <link rel="stylesheet" href="../css/hostel-profile.css">
    <link rel="stylesheet" href="../css/footer.css">  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
         <?php include 'sidebar.php'; ?>
      
  <main class="main-container">
    <?php include 'notifBar_Owner.php'; ?>
            <!-- Cover Image -->
            <div class="hostel-cover">
                <img src="<?= !empty($hostel['image']) ? $hostel['image'] : 'img/default-cover.jpg' ?>" 
                     alt="<?= htmlspecialchars($hostel['hostel_name']) ?>" class="cover-img">
            </div>

            
           <!-- Hostel Name & Location -->
<h2 class="hostel-name"><?= htmlspecialchars($hostel['hostel_name']) ?></h2>
<p class="location">
    <i class="fas fa-location-dot"></i> 
    <?= htmlspecialchars($hostel['full_location']) ?> - 
    Ward <?= htmlspecialchars($hostel['ward']) ?>
</p>


            <!-- Hostel Description -->
            <div class="hostel-overview-section">
                <div class="description-text">
                    <p><?= htmlspecialchars($hostel['description'] ?? 'No description provided.') ?></p>
                </div>

                <!-- Contact Details -->
                <section class="contact-details-card">
                    <div class="contact-row">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span><?= htmlspecialchars($hostel['contact']) ?></span>
                        </div>
                    </div>
                    <div class="contact-row">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><?= htmlspecialchars($hostel['email']) ?></span>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Amenities Section -->
            <section class="hostel-features-section">
                <div class="facilities-services">
                    <h2>Facilities & Services</h2>
                    <div class="facility-grid">
                        <?php if (!empty($amenities)): ?>
                            <?php foreach ($amenities as $amenity): ?>
                                <div class="facility-item">
                                    <span><?= htmlspecialchars($amenity['name']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No amenities added yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Rooms Section -->
            <h2 class="hrooms">Rooms</h2>
            <section class="rooms">
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <div class="card">
                          <img src="<?= !empty($room['images']) ? '/' . $room['images'] : 'img/room.png' ?>" alt="Room Image">
                            <div class="card-content">
                                <h2><?= htmlspecialchars($room['room_type']) ?></h2>
                                <p class="price">Rs. <?= htmlspecialchars($room['price']) ?> per month</p>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No rooms added yet.</p>
                <?php endif; ?>
            </section>

            
        </main>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>
