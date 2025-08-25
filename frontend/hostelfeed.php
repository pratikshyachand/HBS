<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Listing</title>
    <link rel="stylesheet" href="css/hostel-feed.css">
    <link rel="stylesheet" href="css/footer.css">
     <link rel="stylesheet" href="css/nav-bar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php";?>

    <div class="container">
        <aside class="sidebar">
            <div class="filter-group address-filter">
                <label for="address">Province</label>
                <div class="select-wrapper">
                    <select id="address">
                        <option></option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            
             <div class="filter-group address-filter">
                <label for="address">District</label>
                <div class="select-wrapper">
                    <select id="address">
                        <option></option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
             <div class="filter-group address-filter">
                <label for="address">Municipality</label>
                <div class="select-wrapper">
                    <select id="address">
                        <option></option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            

            <div class="filter-group type-filter">
                <label>Type</label>
                <div class="radio-options">
                    <label class="radio-container">All
                        <input type="radio" checked="checked" name="radio">
                        <span class="checkmark"></span>
                    </label>
                    <label class="radio-container">Boys
                        <input type="radio" name="radio">
                        <span class="checkmark"></span>
                    </label>
                    <label class="radio-container">Girls
                        <input type="radio" name="radio">
                        <span class="checkmark"></span>
                    </label>
                    <label class="radio-container">Travellers
                        <input type="radio" name="radio">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <div class="search-bar-and-filters">
                <div class="search-input-wrapper">
                    <input type="text" placeholder="Search">
                    <i class="fas fa-search"></i>
                </div>
                <div class="sort-options">
                  
                </div>
            </div>

            <?php include 'hostel-grid.php'?>
           
        </main>
    </div>

    <?php include ".footer.php"; ?>
</body>
</html>