<?php
     require "../../backend/province.php";
     require "../../backend/district.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Hostel</title>
    <link rel="stylesheet" href="css/hostel-registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <main class="main-content">
            <header class="navbar">
                <!-- yet to change -->
                <div class="nav-icons">
                    <i class="fas fa-bell"></i>
                    <i class="fas fa-user"></i>
                </div>
            </header>

            <div class="tab-header">
                <h1>Register Hostel</h1>
            </div>
            

             <div class="info-banner">
                    <i class="fas fa-info-circle"></i>
                    <p>Your business information will be verified by our team. Please ensure all documents are clear, valid, and match the information provided.</p>
            </div>

            <form class="business-info-form" action="" method="post" enctype="multipart/form-data" name="hostel-register">
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-building"></i>Hostel Type</label>
                        <select name="type" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="boys">Boys</option>
                            <option value="girls">Girls</option>
                            <option value="traveller">Traveller</option>
                        </select>   
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user"></i>Hostel Owner Name</label>
                        <input type="text" placeholder="Enter Hostel Owner's Full Name" name="owner_name" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-home"></i>Hostel Name</label>
                        <input type="text" placeholder="Enter Registered Hostel Name" name="hostel_name" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i>Hostel Registration Number (PAN/VAT)</label>
                        <input type="text" placeholder="Enter Official Registration Number" name="pan_no" pattern="\d{9}" maxlength="9" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map"></i>Province</label>
                        <select name="province" onchange="getDistricts(this.value, 'hostel-register')" required>
                            <option value="" selected disabled>Select Province</option>
                            
                            <!-- populate with PHP-->
                            <?php
                               $provinces = getProvince();
                               foreach($provinces as $province)
                               {
                            ?>
                                 
                               <option value="<?php echo $province['id'] ?>">
                                <?php echo $province['title'] ?>
                               </option>
                               <?php
                               }
                               ?> 

                        </select>   
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-city"></i>District</label>
                        <select name="district" onchange="getMunicipalities(this.value, 'hostel-register')" required>
                            <option value="" selected >Select District</option>
                            

                        </select>   
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-city"></i>Municipality</label>
                        <select name="municipality" required>
                            <option value="" selected >Select Municipality</option>
                            
                        </select>   
                    </div>

                     <div class="form-group">
                        <label><i class="fas fa-location-dot"></i> Ward No.</label>
                        <input type="number" placeholder="Ward Number" name="ward_no" min="1" max="32" required />
                     </div>

                    <div class="form-group">
                      <label><i class="fas fa-phone"></i> Contact Number</label>
                      <input type="tel" placeholder="98XXXXXXXX" pattern="[0-9]{10}"  maxlength="10" name="contact" required />
                    </div>

                    <div class="form-group">
                      <label><i class="fas fa-envelope"></i> Official Email</label>
                      <input type="email" placeholder="example@gmail.com" name="emailID" required />
                    </div>

                    <div class="form-group upload-group full-width">
                        <label>Upload Business Document </label>
                        <div class="upload-box">
                            <input type="file" id="businessDocument" name="doc_img" hidden>
                            <label for="businessDocument" class="upload-btn">
                                <i class="fas fa-upload"></i>
                                <span>Upload</span>
                            </label>
                        </div>
                        
                     </div>
            </div>
                    <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                    <button type="reset" class="btn btn-secondary" name="btn_cancel" onclick="clearfield()">Cancel</button>
                    </div>
         </form>

        </main>
    </div>

    <script src="dropdown.js"></script>
   
</body>
</html>