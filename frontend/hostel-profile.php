<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Profile</title>
    <link rel="stylesheet" href="hostel-pro.css">
    <link rel="stylesheet" href="hostel-profile.css">
    <link rel="stylesheet" href="footer.css">    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<?php include "include/navbar.php"; ?>
 <main class="container">
<!-- Container for the image gallery -->
     <?php include "include/carousel.php"; ?>


    <h2 class="hname">Dhangadhi Girls Hostel</h2>
    <p class="location"><i class="fas fa-location-dot"></i> Dhangadhi-4, Hasanpur 
    <i class="fa-solid fa-star"></i>
    <i class="fa-solid fa-star"></i>
    <i class="fa-solid fa-star"></i>
    <i class="fa-solid fa-star"></i>
    <i class="fa-solid fa-star"></i>
   </p>

          <div class="hostel-overview-section">
              <div class="description-text">
                <p>Situated in the iconic Waterloo neighborhood, our hostel blends contemporary comfort with local charm. Immerse yourself in vibrant Nepali culture, explore the famous Westminster Abbey, and stay in modern accommodations with a cozy and fun atmosphere. Our hostel is your ideal home base for discovering Dhangadhi!</p>
              </div>

              <section class="contact-details-card">
                  <div class="contact-row">
                      <div class="contact-item">
                          <!-- <img src="img/phone.svg" alt="Phone" class="contact-icon"> -->
                          <span>(+977) 9812345678</span>
                      </div>
                      <div class="contact-item">
                          <!-- <img src="img/mail.svg" alt="Email" class="contact-icon"> -->
                          <span>dhngls@hostelBS.com</span>
                      </div>
                  </div>


                  <div class="social-row">
                      <p>Find us on :</p>
                      <div class="social-icons">
                          <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                          <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                          <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                          <a href="#" class="social-icon linkedin"><i class="fab fa-linkedin-in"></i></a>
                      </div>
                  </div>
              </section>
          </div>

      <section class="hostel-features-section">
          <div class="facilities-services">
              <h2>Facilities & Services</h2>
              <div class="facility-grid">
                  <div class="facility-item">
                      <img src="img/security.svg" alt="Security" class="facility-icon">
                      <span>24/7 Security</span>
                  </div>
                  <div class="facility-item">
                      <img src="img/locker.svg" alt="Locker" class="facility-icon">
                      <span>Locker</span>
                  </div>
                  <div class="facility-item">
                      <img src="img/water.svg" alt="Hot & Cold Water" class="facility-icon">
                      <span>Hot & Cold Water</span>
                  </div>
                  <div class="facility-item">
                      <img src="img/laundry.svg" alt="Laundry" class="facility-icon">
                      <span>Laundry</span>
                  </div>
                  <div class="facility-item">
                      <img src="img/meals.svg" alt="4 Meals" class="facility-icon">
                      <span>4 Meals</span>
                  </div>
                  <div class="facility-item">
                      <img src="img/peace.svg" alt="Peaceful Environment" class="facility-icon">
                      <span>Peaceful Environment</span>
                  </div>
              </div>
          </div>

          <div class="available-beds">
              <div class="beds-header">
                  <h2>Available Beds</h2>
              </div>
              <table>
                  <thead>
                  <tr>
                      <th>Room Type</th>
                      <th>Single Sitter</th>
                      <th>Double Sitter</th>
                      <th>Tripple Sitter</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td>Price Per Bed</td>
                      <td>Rs. 15000</td>
                      <td>Rs. 10000</td>
                      <td>Rs. 8000</td>
                  </tr>
                  <tr>
                      <td>Available Beds</td>
                      <td>3</td>
                      <td>7</td>
                      <td>5</td>
                  </tr>
                  </tbody>
              </table>
          </div>
      </section>

      <h3>Rooms</h3>
      <section class="rooms">
      <div class="card">
          <img src="img/room.png" alt="Room Image">
          <div class="card-content">
              <h3>Single Sharing Room</h3>
              <p class="price">Rs.9000 per month</p>
          <div class="buttons">
                  <button class="book">Book Now</button>
                  <button class="details" onclick="hostelRoom()">More details</button>
          </div>
          </div>
      </div>
          <div class="card">
              <img src="img/room.png" alt="Room Image">
              <div class="card-content">
                  <h3>Single Sharing Room</h3>
                  <p class="price">Rs.9000 per month</p>
                  <div class="buttons">
                      <button class="book">Book Now</button>
                      <button class="details">More details</button>
                  </div>
              </div>
          </div>

          <div class="card">
              <img src="img/room.png" alt="Room Image">
              <div class="card-content">
                  <h3>Single Sharing Room</h3>
                  <p class="price">Rs.9000 per month</p>
                  <div class="buttons">
                      <button class="book">Book Now</button>
                      <button class="details">More details</button>
                  </div>
              </div>
          </div>

          <div class="card">
              <img src="img/room.png" alt="Room Image">
              <div class="card-content">
                  <h3>Single Sharing Room</h3>
                  <p class="price">Rs.9000 per month</p>
                  <div class="buttons">
                      <button class="book">Book Now</button>
                      <button class="details">More details</button>
                  </div>
              </div>
          </div>

          <div class="card">
              <img src="img/room.png" alt="Room Image">
              <div class="card-content">
                  <h3>Single Sharing Room</h3>
                  <p class="price">Rs.9000 per month</p>
                  <div class="buttons">
                      <button class="book">Book Now</button>
                      <button class="details">More details</button>
                  </div>
              </div>
          </div>

          <div class="card">
              <img src="img/room.png" alt="Room Image">
              <div class="card-content">
                  <h3>Single Sharing Room</h3>
                  <p class="price">Rs.9000 per month</p>
                  <div class="buttons">
                      <button class="book">Book Now</button>
                      <button class="details">More details</button>
                  </div>
              </div>
          </div>

          <div class="card">
              <img src="img/room.png" alt="Room Image">
              <div class="card-content">
                  <h3>Single Sharing Room</h3>
                  <p class="price">Rs.9000 per month</p>
                  <div class="buttons">
                      <button class="book">Book Now</button>
                      <button class="details">More details</button>
                  </div>
              </div>
          </div>

          <div class="card">
              <img src="img/room.png" alt="Room Image">
              <div class="card-content">
                  <h3>Single Sharing Room</h3>
                  <p class="price">Rs.9000 per month</p>
                  <div class="buttons">
                      <button class="book">Book Now</button>
                      <button class="details">More details</button>
                  </div>
              </div>
          </div>
      </section>
<!-- ROOMS END ---->
      <!-- find us on google map -->

          <h2 class="fmap">Find us on Google Map</h2>
          <section class="map">
              <p><i class="fas fa-location-dot"></i> Dhangadhi-4, Hasanpur<br>Kailali, Sudurpaschim Province</p>
              <iframe class="hmap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3499.3644564919127!2d80.5753797761672!3d28.70865227562327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39a1ecd1d11c53bf%3A0xc1c1d8360e27ee67!2sNational%20Academy%20Of%20Science%20And%20Technology%20(NAST)!5e0!3m2!1sen!2sus!4v1749718357112!5m2!1sen!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </section>

      <section class="reviews">
          <h2>Latest Reviews</h2>
          <div class="review-grid">
              <div class="review-card">
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i> </div>
                  <h3 class="review-title">Well Run</h3>
                  <p class="review-body">Everything was so well run at the hostel. It was very close to the Westminster bridge if you don’t mind walking a bit. Some stuff was a bit dirty but if you said anything they would clean it. The staff was the highlight, putting a lot of love and care into both maintaining the hostel and running events. Squid at the front desk was incredibly welcoming and George ran the bar event safely and enjoyably.</p>
                  <div class="reviewer-info">
                      <img src="img/user.png" alt="Reviewer Avatar" class="reviewer-avatar"> <div class="reviewer-details">
                          <span class="reviewer-name">Ruchi Singh</span>
                          <span class="review-date">Jan 6, 2023</span>
                      </div>
                  </div>
              </div>

              <div class="review-card">
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                  </div>
                  <h3 class="review-title">All Were Great</h3>
                  <p class="review-body">Staff volunteers Rachel, Isaac, Will, Ian, and Jeff were all great! This hostel is as good as it gets.</p>
                  <div class="reviewer-info">
                      <img src="img/user.png" alt="Reviewer Avatar" class="reviewer-avatar">
                      <div class="reviewer-details">
                          <span class="reviewer-name">Tarannum Khatun</span>
                          <span class="review-date">Nov 4, 2024</span>
                      </div>
                  </div>
              </div>

              <div class="review-card">
                  <div class="stars">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                  </div>
                  <h3 class="review-title">Memorable Time</h3>
                  <p class="review-body">Had an absolutely memorable time at this hostel. The location was central, the staff were helpful, and the atmosphere was vibrantly social. I was also surprised by how generous they were with the free dinners. With free walking tours, free dinners, free drinking games, and free pub crawls, it is an absolute bargain for backpackers looking to have a good time in London without breaking the bank.</p>
                  <div class="reviewer-info">
                      <img src="img/user.png" alt="Reviewer Avatar" class="reviewer-avatar">
                      <div class="reviewer-details">
                          <span class="reviewer-name">Kabi Rana</span>
                          <span class="review-date">June 5, 2025</span>
                      </div>
                  </div>
              </div>

          </div>
      </section>
  </main>
<?php include "include/footer.php" ; ?>
</body>
<script>
    function hostelRoom(){
       window.location.href="room-profile.php";
    }
</script>
</html>