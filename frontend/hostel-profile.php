<?php
 require_once '../backend/hostel_profile.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($hostel['hostel_name']) ?> - Profile</title>
    <link rel="stylesheet" href="css/hostel-profile.css">
    <link rel="stylesheet" href="css/footer.css">    

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
      <div class="container">
    
 
    
<main class="main-container">

    <!-- Cover Image -->
    <div class="hostel-cover">
        <img src="<?= !empty($hostel['image']) ? $hostel['image'] : 'img/default-cover.jpg' ?>" 
             alt="<?= htmlspecialchars($hostel['hostel_name']) ?>" class="cover-img">
    </div>

    <!-- Hostel Name & Location -->
    <h2 class="hostel-name"><?= htmlspecialchars($hostel['hostel_name']) ?></h2>
    <p class="location"><i class="fas fa-location-dot"></i> Ward <?= $hostel['ward'] ?></p>

    <!-- Hostel Description -->
    <div class="hostel-overview-section">
        <div class="description-text">
            <p><?= htmlspecialchars($hostel['description'] ?? 'No description provided.') ?></p>
        </div>

        <!-- Contact Details -->
        <section class="contact-details-card">
            <div class="contact-row">
                <div class="contact-item">
                    <img src="img/phone.svg" alt="Phone" class="contact-icon">
                    <span><?= htmlspecialchars($hostel['contact']) ?></span>
                </div>
                <div class="contact-item">
                    <img src="img/mail.svg" alt="Email" class="contact-icon">
                    <span><?= htmlspecialchars($hostel['email']) ?></span>
                </div>
            </div>
        </section>
    </div>

    <!-- Amenities Section -->
    <!-- <section class="hostel-features-section">
        <div class="facilities-services">
            <h2>Facilities & Services</h2>
            <div class="facility-grid">
                <?php if (!empty($amenities)): ?>
                    <?php foreach ($amenities as $amenity): ?>
                        <div class="facility-item">
                            <img src="<?= htmlspecialchars($amenity['icon'] ?? 'img/default-amenity.svg') ?>" 
                                 alt="<?= htmlspecialchars($amenity['name']) ?>" class="facility-icon">
                            <span><?= htmlspecialchars($amenity['name']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No amenities added yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </section> -->

    <!-- Rooms Section -->
    <h2 class="hrooms">Rooms</h2>
    <section class="rooms">
        <?php if (!empty($rooms)): ?>
            <?php foreach ($rooms as $room): ?>
                <div class="card">
                
                    <img src="../frontend/<? !empty($room['images']) ? $room['images'] : 'img/room.png' ?>" alt="Room Image">
                    <div class="card-content">
                        <h2><?= htmlspecialchars($room['type']) ?></h2>
                        <p class="price">Rs. <?= htmlspecialchars($room['price']) ?> per month</p>
                        <div class="buttons" hidden>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No rooms added yet.</p>
        <?php endif; ?>
    </section>

    <!-- Map Section -->
    <h2 class="fmap">Find us on Google Map</h2>
    <section class="map">
        <iframe class="hmap" 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3499.3644564919127!2d80.5753797761672!3d28.70865227562327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39a1ecd1d11c53bf%3A0xc1c1d8360e27ee67!2sNational%20Academy%20Of%20Science%20And%20Technology%20(NAST)!5e0!3m2!1sen!2sus!4v1749718357112!5m2!1sen!2sus" 
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <!-- Review Section -->
    <section class="reviews">
        <h2>Latest Reviews</h2>
        <p>Reviews placeholder (static for now).</p>
    </section>
</main>
  
</div>


<?php include "footer.php"; ?>
</body>
</html>
