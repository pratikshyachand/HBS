<?php
     session_start();
     require_once '../../backend/auth_check.php';
     


// Save submitted form data
if (isset($_POST['btn_submit'])) {
    $_SESSION['form_data'] = $_POST;
}

// Clear form data only if page is loaded without POST (i.e., manual refresh)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    unset($_SESSION['form_data']);
}

if (isset($_POST['btn_cancel'])) {
    unset($_SESSION['form_data']); // clear saved form data
    header("Location: ".$_SERVER['PHP_SELF']); // reload page with empty fields
    exit();
}






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
    <link rel="stylesheet" href="../css/popup.css">
     <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <main class="mainH-content">
        <?php include 'notifBar_Owner.php'; ?>

        
            <div class="tab-header">
                <h1>Register Hostel</h1>
            </div>
            
            <p class="mandatory-note" style="margin-left:20px;"><span style="color:red">*</span> All fields are mandatory. 
            Highlighted fields are critical for verification.</p>

             <div class="info-banner">
                    <i class="fas fa-info-circle"></i>
                    <p>Your business information will be verified by our team. Please ensure all documents are clear, valid, and match the information provided.</p>
            </div>

            <form class="business-info-form" action="" method="post" enctype="multipart/form-data" name="hostel-register">
                <div class="form-grid">
                    <div class="form-group">
                        <label><i class="fas fa-building"></i>Hostel Type</label>
                        <select name="type" required>
    <option value="" disabled <?php if(empty($_SESSION['form_data']['type'])) echo 'selected'; ?>>Select Type</option>
    <option value="boys" <?php if(($_SESSION['form_data']['type'] ?? '') === 'boys') echo 'selected'; ?>>Boys</option>
    <option value="girls" <?php if(($_SESSION['form_data']['type'] ?? '') === 'girls') echo 'selected'; ?>>Girls</option>
    <option value="traveller" <?php if(($_SESSION['form_data']['type'] ?? '') === 'traveller') echo 'selected'; ?>>Travellers</option>
</select>
  
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-user"></i>Hostel Owner Name<span style="color:red">*</span></label>
                        <input type="text" placeholder="Enter Hostel Owner's Full Name" name="owner_name"  value="<?php echo htmlspecialchars($_SESSION['form_data']['owner_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-home"></i>Hostel Name</label>
                        <input type="text" placeholder="Enter Registered Hostel Name" name="hostel_name" value="<?php echo htmlspecialchars($_SESSION['form_data']['hostel_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-id-card"></i>Hostel Registration Number (PAN/VAT)<span style="color:red">*</span></label>
                        <input type="text" placeholder="Enter Official Registration Number" name="pan_no" pattern="\d{9}" maxlength="9" value="<?php echo htmlspecialchars($_SESSION['form_data']['pan_no'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-map"></i>Province<span style="color:red">*</span></label>
                        <select name="province" onchange="getDistricts(this.value, 'hostel-register')" required>
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

                    <div class="form-group">
                        <label><i class="fas fa-city"></i>District<span style="color:red">*</span></label>
                        <select id = "district" name="district" onchange="getMunicipalities(this.value, 'hostel-register')" value="<?php echo $_SESSION['form_data']['district'] ?? ''; ?>" required>
                            <option value="" selected >Select District</option>
                            

                        </select>   
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-city"></i>Municipality<span style="color:red">*</span></label>
                        <select id = "municipality" name="municipality" value="<?php echo $_SESSION['form_data']['municipaliity'] ?? ''; ?>" required>
                            <option value="" selected >Select Municipality</option>
                            
                        </select>   
                    </div>

                     <div class="form-group">
                        <label><i class="fas fa-location-dot"></i> Ward No.</label>
                        <input type="number" placeholder="Ward Number" name="ward_no" min="1" max="32" value="<?php echo htmlspecialchars($_SESSION['form_data']['ward_no'] ?? ''); ?>" required>
                     </div>

                    <div class="form-group">
                      <label><i class="fas fa-phone"></i> Contact Number</label>
                      <input type="tel" placeholder="98XXXXXXXX" pattern="[0-9]{10}"  maxlength="10" name="contact" value="<?php echo htmlspecialchars($_SESSION['form_data']['contact'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                      <label><i class="fas fa-envelope"></i> Official Email</label>
                      <input type="email" placeholder="example@gmail.com" name="emailID" value="<?php echo htmlspecialchars($_SESSION['form_data']['emailID'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group upload-group full-width">
                        <label>Upload Business Document <span style="color:red">*</span></label>
                        <div class="upload-box">
                            <p class="note">Note: Format photos SVG, PNG, or JPG</p>
                            
                                 <input type="file" class= "browse" id = "businessDocument" name="doc_img" accept="image/*" onchange="previewCoverImage(this)" required />
                                 <div class="preview-container"></div>
                           
                        </div>
                        
                     </div>
            </div>
                    <div class="form-actions">
                    <button type="submit" class="btns btn-primary" name="btn_submit">Submit</button>
                    <button type="submit" class="btns btn-secondary" name="btn_cancel" onclick="clearfield()">Cancel</button>
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

    <!-- scripts -->
    <script src="dropdown.js"></script>
    <script src="preview_images.js"></script>
    <script src="../popup.js"></script>

  <script>
function clearfield() {
    // Clear all inputs inside the form
    document.querySelectorAll("form input, form select, form textarea").forEach(el => {
        if (el.type !== "hidden" && el.type !== "submit" && el.type !== "button") {
            el.value = "";
        }
    });
}
</script>


</body>
</html>