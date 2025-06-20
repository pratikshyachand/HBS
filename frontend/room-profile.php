<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Room Profile</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="css/navabar.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/room-profile.css" />
    <link rel="stylesheet" href="css/hostel-profile.css" />
</head>
<body>
    <?php include 'navbar.php' ?>

   <div class = "room-container">
    <section class="room-preview">
     <div class="gallery">
      <img id="gallery_img" src="img/room.png" alt="Slide 1" />
     </div>

     <div class="thumbnails">
      <img id = "room1" src="img/room.png" alt="Thumb 1"/>
      <img id = "room2" src="img/room1.png" alt="Thumb 2"/>
      <img id = "room3" src="img/room2.png" alt="Thumb 3"/>
     </div>
    </section>

    <!-- RIGHT: Room Info -->
      <div class="room-info">
          <div class="room-type">Double Sharing Room</div>
          <div class="price">
              <span class="currency">Rs</span>9000<span class="period">/month per bed</span>
          </div>
          <div class="booking-details">
              <div class="available-beds">
                  <label for="available">Available</label>
                  <input type="text" disabled id="available" value="1" >
              </div>
              <div class="num-seats">
                  <label for="seats-to-book">No. of beds to book</label>
                  <select id="seats-to-book">
                      <option disabled>select seats to book</option>
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                  </select>
              </div>
          </div>
          <button class="book-now-button">Book Now</button>
      </div>
 </div>

  <div class="room-info">
   <h3>Description</h3>
    <span>Cozy twin room featuring comfortable beds, ample storage, a dedicated workspace, and a bright, airy atmosphere</span>
    <h3>Room Specifications</h3>
    <span>
        Room Dimension :        &emsp;&emsp;&ensp;        4m×3m<br>
        Two single beds :       &emsp;&emsp;&emsp;         90cm×200cm each<br>
        Individual Wardrobes :  &emsp; 80cm×60cm×200cm<br>
        Shared Desk Area :      &emsp;&emsp;    1.2m×0.6m<br>
    </span>
</div>
<h3>You May Also Like</h3>
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
<?php include 'footer.php'?>

</body>
<script>
    const gallery_img = document.getElementById('gallery_img');
    const room1 = document.getElementById('room1');
    const room2 = document.getElementById('room2');
    const room3 = document.getElementById('room3');

    room1.addEventListener('mouseenter', () =>{
       gallery_img.src = room1.src;
    });
    room2.addEventListener('mouseenter', () =>{
        gallery_img.src = room2.src;
    });
    room3.addEventListener('mouseenter', () =>{
        gallery_img.src = room3.src;
    });
</script>
</html>
