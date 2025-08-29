<?php
session_start();
require_once '../../backend/auth_check.php';
 require_once '../../backend/func.php';



$con = dbConnect();

// Update bookings that have passed checkout
$con->query("
    UPDATE tbl_booking b
    JOIN tbl_room r ON b.room_id = r.id
    SET b.status = 'Completed',
        r.available_beds = r.available_beds + b.booked_beds
    WHERE b.status = 'Booked' AND b.check_out < CURDATE()
");

$con->close();

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="mainH-content">
      <?php include 'notifBar_Owner.php'; ?>
    <div class="tab-header">
        <h1>My Hostels</h1>
    </div>
    <div class="add-btn">
        <button class="btn-add-hostel" onclick="window.location.href='business-info.php'"><i class="fas fa-plus"></i>   Add New Hostel</button>
    </div>
    <?php include 'hostel-gridO.php'; ?>
</main>
</div>


<script>

  </script>

</body>

</html>