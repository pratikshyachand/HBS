<?php
session_start();
require '../../backend/auth_check.php';
     require "../../backend/province.php";
     require "../../backend/district.php";
     require_once '../../backend/select_hostel.php';

     $user_id = $_SESSION['user_id'];

     //fetch amenities
$conn = dbConnect();
$amenities = [];
$amenities_query = "SELECT id, name FROM tbl_amenities WHERE is_delete=0 ORDER BY name";
$amenities_result = mysqli_query($conn, $amenities_query);

if ($amenities_result && mysqli_num_rows($amenities_result) > 0) {
    while ($row = mysqli_fetch_assoc($amenities_result)) {
        $amenities[$row['id']] = $row['name'];
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hostel Details</title>
    <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css" />
    <link rel="stylesheet" href="../css/popup.css">
    <link rel="stylesheet" href="css/room.css">
    <link rel="stylesheet" href="css/hostel-registration.css">
    <link rel="stylesheet" href="css/manage-profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
            <?php include 'sidebar.php'; ?>

       
        <!-- Main Content -->
        <main class="main-content">
            <?php include 'notifBar_Owner.php'; ?>

            <div class="header">
                <h2>Manage Hostel Profile</h2>
                <button type="button" id="deleteHostelBtn" class="btn btn-primary">Delete Hostel</button>

            </div>
            

            <div class="select-hostel">
                <select id="hostel_id" name="selectedHostel" class="hostel-select">
                    <option value="" selected disabled>Select your hostel to manage</option>
                    <?php
                    $hostels = getHostelName($user_id);
                    foreach($hostels as $hostel) {
                    ?>
                    <option value="<?php echo $hostel['id'] ?>">
                        <?php echo $hostel['hostel_name'] ?>
                    </option>
                    <?php } ?>
                </select>
            </div>

            <form action="" method="post" name="edit-hostel" enctype="multipart/form-data" class="hostel-form">
                <input type="hidden" name="hostel_id" id="hostel_id_hidden" value="">
                
                <div class="profile-card">
                    <h3>Basic Information</h3>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="type"><i class="fas fa-building"></i> Hostel Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="" selected disabled>Select Type</option>
                                    <option value="boys">Boys</option>
                                    <option value="girls">Girls</option>
                                    <option value="traveller">Traveller</option>
                                </select>   
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                <label for="owner_name"><i class="fas fa-user"></i> Hostel Owner Name</label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Enter Hostel Owner's Full Name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="hostel_name"><i class="fas fa-home"></i> Hostel Name</label>
                        <input type="text" class="form-control" id="hostel_name" name="hostel_name" placeholder="Enter Registered Hostel Name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description"><i class="fa-solid fa-pen-to-square"></i> Short Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Short Description"></textarea>
                    </div>
                </div>
                
                <div class="profile-card">
                    <h3>Location Details</h3>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="province"><i class="fas fa-map"></i> Province</label>
                                <select name="province" id="province" class="form-control" onchange="getDistricts(this.value, 'edit-hostel')" required>
                                    <option value="" selected disabled>Select Province</option>
                                    <?php
                                    $provinces = getProvince();
                                    foreach($provinces as $province) {
                                    ?>
                                    <option value="<?php echo $province['id'] ?>">
                                        <?php echo $province['title']; ?>
                                    </option>
                                    <?php } ?>
                                </select>   
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                <label for="district"><i class="fas fa-city"></i> District</label>
                                <select name="district" id="district" class="form-control" onchange="getMunicipalities(this.value, 'edit-hostel')" required>
                                    <option value="" selected>Select District</option>
                                </select>   
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="municipality"><i class="fas fa-city"></i> Municipality</label>
                                <select name="municipality" id="municipality" class="form-control" required>
                                    <option value="" selected>Select Municipality</option>
                                </select>   
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                <label for="ward_no"><i class="fas fa-location-dot"></i> Ward No.</label>
                                <input type="number" class="form-control" id="ward_no" name="ward_no" placeholder="Ward Number" min="1" max="32" required />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="profile-card">
                    <h3>Contact Information</h3>
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="contact"><i class="fas fa-phone"></i> Contact Number</label>
                                <input type="tel" class="form-control" id="contact" name="contact" placeholder="98XXXXXXXX" pattern="[0-9]{10}" maxlength="10" required />
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                <label for="emailID"><i class="fas fa-envelope"></i> Official Email</label>
                                <input type="email" class="form-control" id="emailID" name="emailID" placeholder="example@gmail.com" required />
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="profile-card">
    <h3>Cover Image</h3>

      <div class="upload-box">
        <p class="note">Note: Format photos SVG, PNG, or JPG</p>

     

        <!-- File input for new upload -->
        <input type="file" class="browse" id="cover_image" name="cover_image" 
               accept="image/*" onchange="previewCoverImage(this)" />

         
         <!-- Preview existing image -->
        <div class="preview-container">
            <?php if (!empty($formData['cover_image'])): ?>
                <img src="<?php echo htmlspecialchars($formData['cover_image']); ?>" 
                     alt="Cover Image" 
                     style="max-width:200px; max-height:150px; border:1px solid #ccc; margin-top:10px;">
            <?php endif; ?>
        </div>
    </div>
</div>
    
    

                  <!-- Amenities Section  -->
                <div class="profile-card">
                    <h3>Amenities</h3>
                    
                    <div class="form-group">
                        <label><i class="fas fa-concierge-bell"></i> Select Amenities</label>
                        <div class="amenities-container">
                            <?php
                            if (!empty($amenities)) {
                                foreach ($amenities as $id => $name) {
                                    echo '<label class="amenity-checkbox">';
                                    echo '<input type="checkbox" name="amenities[]" value="' . $id . '">';
                                    echo '<span class="checkmark"></span>';
                                    echo htmlspecialchars($name);
                                    echo '</label>';
                                }
                            } else {
                                echo '<p>No amenities available. Please add amenities first from Amenities tab.</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                 <!-- Admission Fee Section -->
                <div class="profile-card">
                    <h3>Admission Fee</h3>
                    <div class="form-group">
                        <label for="admission_fee"><i class="fas fa-money-bill-wave"></i> Admission Fee (in Rs.)</label>
                        <input 
                            type="number" 
                            id="admission_fee" 
                            name="admission_fee" 
                            placeholder="Enter Admission Fee" 
                            min="100" 
                            required
                        >
                    </div>
                </div>

                <div class="action-buttons">
                    <button type="reset" class="btn btn-outline">Discard Changes</button>
                    <button type="submit" name="btnSave" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </main>

        <!-- popup message -->
        <?php if (!empty($popup_message)): ?>
<div class="popup-message popup" id="popup">
    <span class="popup-close" onclick="this.parentElement.style.display='none'">×</span>
    <?php foreach ($popup_message as $msg): ?>
        <p><?php echo htmlspecialchars($msg); ?></p>
    <?php endforeach; ?>
</div>
<script>
    document.getElementById('popup').style.display = 'block';
</script>
<?php endif; ?>

</div>
  

  <!-- Delete Confirmation Modal -->
<div id="deleteModal" class="deleteModal">
  <div class="deleteModal-content">
    <span class="close">&times;</span>
    <h3>Are you sure?</h3>
    <p>Are you sure you want to delete this hostel? This action cannot be undone.</p>
    <div class="deleteModal-actions">
      <button id="cancelDelete" class="btn-cancel">Cancel</button>
      <button id="confirmDelete" class="btn-delete">Delete</button>
    </div>
  </div>
</div> 

    <script src="dropdown.js"></script>
    <script src="delete_hostel.js"></script>
    <script src="get_hostel_details.js"></script>
    <script src="../popup.js"></script>
    <script src="preview_images.js"></script>
    
    
</body>
</html>