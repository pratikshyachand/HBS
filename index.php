
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HostelHub</title>
    <link rel="stylesheet" href="/frontend/css/home.css">
    <link rel="stylesheet" href="/frontend/css/hostel-grid.css">
    <link rel="stylesheet" href="/frontend/css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "frontend/navbar.php"?>

     <!-- Background image -->
      <div class="cover-image">
        <img src="/frontend/img/Image_fx.jpg" alt="Hostel">

      </div>
     <!-- Background image -->

      <h2>Explore Hostels</h2>
      <div class="grid">
      <?php include 'frontend/hostel-grid.php'; ?>
      </div>

      <div class="btn">
        <button class="btn-load">Load More</button>
      </div>
   
     
      <?php include 'frontend/footer.php'; ?>


</body>
</html>