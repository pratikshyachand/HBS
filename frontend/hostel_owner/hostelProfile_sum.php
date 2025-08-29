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


    <div class="stats-container">
    <div class="stat-box">
        <div class="stat-number" id="total-bookings">0</div>
        <div class="stat-label">Total Bookings</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="active-bookings">0</div>
        <div class="stat-label">Active Bookings</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="cancelled-bookings">0</div>
        <div class="stat-label">Cancelled</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="completed-bookings">0</div>
        <div class="stat-label">Completed</div>
    </div>
    <div class="stat-box">
        <div class="stat-number" id="total-income">Rs.0</div>
        <div class="stat-label">Total Income</div>
    </div>
</div>

         <div class="date-filters">
        <label>Filter by Date:</label>
        <button class="filter-btn-date" data-date="all">All</button>
        <button class="filter-btn-date" data-date="today">Today</button>
        <button class="filter-btn-date" data-date="week">This Week</button>
        <button class="filter-btn-date" data-date="month">This Month</button>
    </div>


        <input type="hidden" id="hostel_id" value="<?= $hostel['id'] ?>">

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

            <!-- Amenities Section  -->
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
            <h2 class="hrooms">Rooms</h2>
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
        </main>
    </div>

    <?php include "footer.php"; ?>


    <script>
const hostelId = <?= (int)$hostel['id'] ?>; 

// Function to fetch and update stats based on selected date filter
function fetchStats(dateFilter = 'all') {
    console.log("Hostel ID:", hostelId, "Filter:", dateFilter);

    fetch(`../../backend/update_stats.php?hostel_id=${hostelId}&date_filter=${dateFilter}`)
        .then(response => response.json())
        .then(data => {
            // Update stats numbers
            document.getElementById('total-bookings').innerText = data.total_booking ?? 0;
            document.getElementById('active-bookings').innerText = data.active_booking ?? 0;
            document.getElementById('cancelled-bookings').innerText = data.cancelled ?? 0;
            document.getElementById('completed-bookings').innerText = data.completed ?? 0;
            document.getElementById('total-income').innerText = 'Rs.' + (data.total_value ?? 0);
        })
        .catch(err => console.error("Error fetching stats:", err));
}

// Attach event listener to each filter button
document.querySelectorAll('.filter-btn-date').forEach(button => {
    button.addEventListener('click', function() {
        const selectedFilter = this.getAttribute('data-date'); // "today", "all", "week", "month"
        fetchStats(selectedFilter);
    });
});

// Load default stats (All) when page loads
fetchStats('all');
</script>

</body>
</html>
