<?php
session_start();
require_once '../../backend/hostel_profile.php';
require_once '../../backend/auth_check.php'; // blocks if not logged in
$user_id = $_SESSION['user_id'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Hostels</title>
    <link rel="stylesheet" href="css/navbarS.css" />
    <link rel="stylesheet" href="../css/hostel-profile.css">
    <link rel="stylesheet" href="../css/footer.css">  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
<div class="container">
  <main class="main-containerH">

            <!-- Cover Image -->
            <div class="hostel-cover">

            <img src="<?php echo '/frontend/hostel_owner/' . (!empty($hostel['image']) ? $hostel['image'] : 'img/default-cover.jpg'); ?>"
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
                     <h2>About Us</h2>
                    <p><?= htmlspecialchars($hostel['description'] ?? 'No description provided.') ?></p>
                </div>

                <!-- Contact Details -->
                <section class="contact-details-card">
                    <h2>Contact</h2>
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
                                    <span>&bull;  <?= htmlspecialchars($amenity['name']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No amenities added yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Rooms Section -->
            <h2>Available Rooms</h2>
            <section class="rooms">
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <div class="card">
                            
                          <img src="<?= !empty($room['images']) ? '/' . $room['images'] : 'img/room.png' ?>" alt="Room Image">
                            <div class="card-content">
                                <h2><?= htmlspecialchars($room['room_type']) ?> room</h2>
                                <p class="price"><span style="color:#e74c3c;">Rs. <?= htmlspecialchars($room['price']) ?> </span> <span class="duration">per day</span></p>

                                 <div class="room-features">
                                    <span class="duration"> Available beds:</span>
                                    <div class="feature">
                                        <i class="fas fa-bed"></i>
                                        <span><?= htmlspecialchars($room['available_beds']) ?> bed</span>
                                    </div>
                                 </div>
      


                                <div class="buttons">
            <form method="GET" action="../../frontend/seeker/booking.php">
                <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                <button type="submit" class="book">Book Now</button>
            </form>
        </div>
 

                    </div>
                                </div>
                          
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No rooms added yet.</p>
                <?php endif; ?>
            </section>

            <!-- Reviews Section -->
             <h2>Reviews</h2>
<section class="reviews-section">
    

    <!-- Existing Reviews -->
    <div class="reviews-list">
        <?php
        require_once '../../backend/func.php';
        $con = dbConnect();
        $hostel_id = $hostel['id'];
        $reviewQuery = $con->prepare("SELECT r.id, r.user_id, r.rating, r.comment, u.first_name, u.last_name, r.created_at 
                                      FROM tbl_reviews r
                                      JOIN tbl_users u ON r.user_id = u.id
                                      WHERE r.hostel_id = ? 
                                      ORDER BY r.created_at DESC");
        $reviewQuery->bind_param("i", $hostel_id);
        $reviewQuery->execute();
        $reviews = $reviewQuery->get_result();
        $reviewQuery->close();

        if ($reviews->num_rows > 0):
            while ($review = $reviews->fetch_assoc()):
        ?>
                <div class="review-item">
                    <div class="review-header">
                        <strong><?= htmlspecialchars($review['first_name'] . ' ' . $review['last_name']) ?></strong>
                        <span class="review-rating"><?= str_repeat('★', $review['rating']) ?><?= str_repeat('☆', 5 - $review['rating']) ?></span>
                        <span class="review-date"><?= date('M d, Y', strtotime($review['created_at'])) ?></span>
                    </div>
                    <p class="review-comment"><?= htmlspecialchars($review['comment']) ?></p>
                </div>
        <?php
            endwhile;
        else:
            echo "<p>No reviews yet. Be the first to review!</p>";
        endif;
        ?>
    </div>

    <!-- Submit Review Form -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="review-form">
        <h3>Leave a Review</h3>
        <form method="POST" action="../../backend/add_review.php">
            <input type="hidden" name="hostel_id" value="<?= $hostel['id'] ?>">
            <label for="rating">Rating:</label>
            <div class="star-rating">
    <div class="stars">
        <span class="star" data-value="1">&#9734;</span>
        <span class="star" data-value="2">&#9734;</span>
        <span class="star" data-value="3">&#9734;</span>
        <span class="star" data-value="4">&#9734;</span>
        <span class="star" data-value="5">&#9734;</span>
    </div>
    <input type="hidden" name="rating" id="rating" required>
</div>

            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" rows="4" placeholder="Write your review..." required></textarea>

            <button type="submit" class="submit-review">Submit Review</button>
        </form>
    </div>
    <?php else: ?>
        <p><a href="../../frontend/auth/login.php">Login</a> to leave a review.</p>
    <?php endif; ?>
</section>

        </main>
                </div>
    <?php include "../footer.php"; ?>




    <script>
const stars = document.querySelectorAll('.star-rating .star');
const ratingInput = document.getElementById('rating');

stars.forEach(star => {
    star.addEventListener('click', () => {
        const value = parseInt(star.getAttribute('data-value'));
        ratingInput.value = value;

        // Highlight selected stars
        stars.forEach(s => s.classList.remove('selected'));
        for (let i = 0; i < value; i++) {
            stars[i].classList.add('selected');
        }
    });

    star.addEventListener('mouseover', () => {
        const value = parseInt(star.getAttribute('data-value'));
        stars.forEach((s, idx) => {
            if (idx < value) s.classList.add('hovered');
            else s.classList.remove('hovered');
        });
    });

    star.addEventListener('mouseout', () => {
        stars.forEach(s => s.classList.remove('hovered'));
    });
});
</script>

</body>
</html>
