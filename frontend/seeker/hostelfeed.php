<?php
  session_start();
 require_once '../../backend/auth_check.php'; 
 require_once '../../backend/province.php';
  require_once '../../backend/district.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Listing</title>
    <link rel="stylesheet" href="css/hostel-feed.css">
    <link rel="stylesheet" href="../css/footer.css">
     <link rel="stylesheet" href="css/navbarS.css">
    <link rel="stylesheet" href="../css/hostel-grid.css">
  
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include "navbar.php";?>


    <div class="page-wrapper">
    <div class="container">
        <div class="page-title">
            <h1>Find Your Perfect Hostel</h1>
            <p>Discover the best hostels across Nepal with HostelHub</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i>
                <span>Filter by Location</span>
            </div>
            
            <div class="filter-grid">
                
                <div class="filter-group">
                    <form name="hostel-register" >
                    <label for="province">Province</label>
                        <select id="province" name="province" onchange="getDistricts(this.value, 'hostel-register')" required>
                            <option value="" selected disabled>Select Province</option>
                            
                            <!-- populate with PHP-->
                           <?php
        $provinces = getProvince();
        foreach($provinces as $p){
            $selected = ($_SESSION['form_data']['province'] ?? '') == $p['id'] ? 'selected' : '';
            echo "<option value='{$p['id']}' $selected>{$p['title']}</option>";
        }
        ?>

                        </select> 
                
                </div>
                
                <div class="filter-group">
                    <label for="district">District</label>
                    <select id = "district" name="district" onchange="getMunicipalities(this.value, 'hostel-register')" value="<?php echo $_SESSION['form_data']['district'] ?? ''; ?>" required>
                            <option value="" selected >Select District</option>
                            

                        </select>   
                </div>
                
                <div class="filter-group">
                    <label for="municipality">Municipality</label>
                     <select id = "municipality" name="municipality" value="<?php echo $_SESSION['form_data']['municipaliity'] ?? ''; ?>" required>
                            <option value="" selected >Select Municipality</option>
                            
                        </select> 
   
                </div>
                 </form> 
            </div>
            
            <div class="filter-title">
                <i class="fas fa-users"></i>
                <span>Filter by Hostel Type</span>
            </div>
            <div class="filter-options">
                <div class="filter-option active">All</div>
                <div class="filter-option">Boys</div>
                <div class="filter-option">Girls</div>
                <div class="filter-option">Travellers</div>
            </div>
        </div>

        <!-- Hostel Listings -->
        
     <?php include 'hostel-gridS.php' ?>
  
            <!-- Morse Girls Hostel -->
            <!-- <div class="hostel-card">
                <div class="hostel-image">
                    <i class="fas fa-building"></i>
                </div>
                <div class="hostel-content">
                    <h2 class="hostel-name">Morse Girls Hostel</h2>
                    <div class="hostel-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Dhangadhi, Kailali</span>
                    </div>
                    <div class="hostel-type girls">Girls Hostel</div>
                    <p>Premium accommodation for female students with high-speed internet and recreational areas.</p>
                    <div class="hostel-footer">
                        <div class="rating">
                            <i class="fas fa-star"></i>
                            <span>4.6 (112 reviews)</span>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
 <?php include '../footer.php' ?>
 
    <script>
       
        

        

        // Filter option selection
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.filter-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        
    
    </script>

    <script src="../hostel_owner/dropdown.js"></script>
    <script src="search.js"></script>

</body>
</html>