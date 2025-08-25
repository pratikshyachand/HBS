<?php
  session_start();
 require_once '../../backend/auth_check.php'; 
 require_once '../../backend/province.php';
 require_once '../../backend/district_S.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Listing</title>
    <link rel="stylesheet" href="css/hostel-feed.css">
    <link rel="stylesheet" href="../css/footer.css">
     <link rel="stylesheet" href="../css/nav-bar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php";?>

    <div class="container">
        <aside class="sidebar">
            <!-- Province -->
             <label>Province</label>
<select id="province" onchange="filterHostels()">
    <option value="" selected disabled>Select Province</option>
    <?php
    $provinces = getProvince();
    foreach ($provinces as $province) {
        echo "<option value='{$province['id']}'>{$province['title']}</option>";
    }
    ?>
</select>

<!-- Type radios -->
  <label>Hostel</label>
<label class="radio-container">All
    <input type="radio" name="type" value="All" checked onchange="filterHostels()">
    <span class="checkmark"></span>
</label>
<label class="radio-container">Boys
    <input type="radio" name="type" value="Boys" onchange="filterHostels()">
    <span class="checkmark"></span>
</label>
<label class="radio-container">Girls
    <input type="radio" name="type" value="Girls" onchange="filterHostels()">
    <span class="checkmark"></span>
</label>
<label class="radio-container">Travellers
    <input type="radio" name="type" value="Travellers" onchange="filterHostels()">
    <span class="checkmark"></span>
</label>

        </aside>

        <main class="main-content">
            <div class="search-bar-and-filters">
                <div class="search-input-wrapper">
                    <input type="text" placeholder="Search">
                    <i class="fas fa-search"></i>
                </div>
                
            </div>
            <div class= "top">
            <?php include 'hostel-gridS.php'?>
</div>
          
        </main>
    </div>
   <script scr = "dropdown.js"></script>
</body>
</html>