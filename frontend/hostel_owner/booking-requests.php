<?php
 session_start();
require_once '../../backend/auth_check.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Registration Requests</title>
  <link rel="stylesheet" href="css/hostel-registration.css" />
    <link rel="stylesheet" href="css/popup.css" />

  <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    table tbody tr {
      cursor: pointer;
      transition: background-color 0.2s;
    }
    table tbody tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        
        <main class="mainH-content">
            <?php include 'notifBar_Owner.php'; ?>
            <div class="tab-header">
                <h1>Bookings</h1>
            </div>
            <div class="table-controls" style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
    <input type="text" id="searchInput" placeholder="Search bookings..." style="padding:5px 10px; width:250px; border-radius:5px; border:1px solid #ccc;">
</div>
           <table>
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Hostel Name</th>
            <th>Room ID</th>
            <th>Room Type</th>
            <th>No. of beds booked</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <tr><td colspan="6">Loading...</td></tr>
    </tbody>
</table>


        </main>
    </div>

<script>
function loadBookings() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../backend/fetch_booking_table.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("tableBody").innerHTML = xhr.responseText;
        } else {
            document.getElementById("tableBody").innerHTML = "<tr><td colspan='6'>Error loading bookings</td></tr>";
        }
    };
    xhr.send();
}

loadBookings();
setInterval(loadBookings, 5000); 

</script>

<script src="search.js"></script>

</body>
</html>
