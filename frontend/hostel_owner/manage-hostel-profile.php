<?php
session_start();
require '../../backend/auth_check.php';
     require "../../backend/province.php";
     require "../../backend/district.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hostel Details</title>
    <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css" />
    <link rel="stylesheet" href="../css/popup.css">
    <link rel="stylesheet" href="css/hostel-registration.css">
    <link rel="stylesheet" href="css/manage-hostel-profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        <main class="main-content">
               <?php include 'notifBar_Owner.php'; ?>


            <div class="tab-header">
                <h1>Manage Hostel Profile</h1>
            </div>
<!-- Popup message-->
<?php if (!empty($popup_message)): ?>
<div class="popup-message">
    <p><?php echo htmlspecialchars($popup_message); ?></p>
    <span class="popup-close" onclick="this.parentElement.style.display='none'">×</span>
</div>
<?php endif; ?>   





<div class="select-hostel">
                <select id="hostel_id" name="selectedHostel">
                  <option value="" selected disabled>Select your hostel to manage</option>
                <?php
                               $hostels = getHostelName();
                               foreach($hostels as $hostel)
                               {
                            ?>
                                 
                               <option value="<?php echo $hostel['id'] ?>">
                                <?php echo $hostel['hostel_name'] ?>
                               </option>
                               <?php
                               }
                               ?> 
                </select>
            </div>

           <form action="" method="post" name="edit-hostel" enctype="multipart/form-data" >
            <input type="hidden" name="hostel_id" id="hostel_id_hidden" value="">

           <div class="grid-wrapper">

           <!-- hostel edit section left -->
             <div class="form-grid-profile">
                <div class="hostel-info-grid">
                    <div class="form-group">
                        <label><i class="fas fa-building"></i>Hostel Type</label>
                        <select name="type" id="type" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="boys">Boys</option>
                            <option value="girls">Girls</option>
                            <option value="traveller">Traveller</option>
                        </select>   
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user"></i>Hostel Owner Name</label>
                        <input type="text" placeholder="Enter Hostel Owner's Full Name" id="owner_name" name="owner_name" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-home"></i>Hostel Name</label>
                        <input type="text" placeholder="Enter Registered Hostel Name" id="hostel_name" name="hostel_name" required>
                    </div>

                     <div class="form-group full-width">
                        <label>	<i class="fa-solid fa-pen-to-square"></i>Short Description</label>
                        <textarea id="description" placeholder="Short Description" name="description"></textarea>
                    </div>
              </div>

                <div class="two-columns address">
                    <div class="form-group">
                        <label><i class="fas fa-map"></i>Province</label>
                        <select name="province" id="province"  onchange="getDistricts(this.value, 'edit-hostel')"required>
                            <option value="" selected disabled>Select Province</option>
                            
                            <!-- populate with PHP-->
                            <?php
                               $provinces = getProvince();
                               foreach($provinces as $province)
                               {
                            ?>
                                 
                               <option value="<?php echo $province['id'] ?>">
                                <?php echo $province['title']; ?>
                               </option>
                               <?php
                               }
                               ?> 

                        </select>   
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-city"></i>District</label>
                        <select name="district" id="district"  onchange="getMunicipalities(this.value, 'edit-hostel')" required>
                            <option value="" selected >Select District</option>
                            

                        </select>   
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-city"></i>Municipality</label>
                        <select name="municipality" id="municipality" required>
                            <option value="" selected >Select Municipality</option>
                            
                        </select>   
                    </div>

                     <div class="form-group">
                        <label><i class="fas fa-location-dot"></i> Ward No.</label>
                        <input type="number" placeholder="Ward Number" id="ward_no" name="ward_no" min="1" max="32" required />
                     </div>
        </div>

        <div class="two-columns contact">
                    <div class="form-group">
                      <label><i class="fas fa-phone"></i> Contact Number</label>
                      <input type="tel" placeholder="98XXXXXXXX" pattern="[0-9]{10}"  maxlength="10" id="contact" name="contact" required />
                    </div>

                    <div class="form-group">
                      <label><i class="fas fa-envelope"></i> Official Email</label>
                      <input type="email" placeholder="example@gmail.com" id="emailID" name="emailID" required />
                    </div>
                    
                   
                   
        </div>
            </div>

                <!-- image section right -->
                <div class="gallery-section">
                       <h3>Cover Image</h3>
<p class="note">Note: Format photos SVG, PNG, or JPG</p>
<label class="cover-photo">
    <input type="file" name="cover_image" accept="image/*" onchange="previewCoverImage(this)" required />
    <div class="preview-container"></div>
</label>

<!-- Gallery Images -->
<!-- <h3 class="spacing">Gallery Images</h3>
<p class="note">Note: Format photos SVG, PNG, or JPG</p>
<label class="gallery-photo-slot">
    <input type="file" name="gallery_images[]" multiple accept="image/*" onchange="previewGalleryImages(this)" required />

    <div class="gallery-preview-container"></div>
</label> -->
                          
                        </div>
                        
                </div>
                
            <div class="form-actions">
                    <button name= "btnSave" class="btn btn-primary">Save Changes</button>
                    <button type="reset" class="btn btn-secondary">Discard Changes</button>
                </div>
        </div>

                
            </div>
            </div>
</form>
        </main>
    </div>

     <script src="dropdown.js"></script>
     
     <script src="get_hostel_details.js"></script>

    <script src="../popup.js"></script>

     <script src="preview_images.js"></script>

</body>
</html>