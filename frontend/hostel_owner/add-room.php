<?php
session_start();
require_once '../../backend/auth_check.php';
require_once '../../backend/select_hostel.php';
require_once '../../backend/add-roomD.php';

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room Details</title>
    <link rel="stylesheet" href="css/hostel-registration.css">
    <link rel="stylesheet" href="css/room.css">
    <link rel="stylesheet" href="../css/popup.css">
     <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
       
        <?php include 'sidebar.php'; ?>

        <main class="mainH-content">
           <?php include 'notifBar_Owner.php'; ?>
         

            <div class="tab-header">
                <h1>Add Room Details</h1>
            </div>

        <div class="forms">
            <form method="POST" action="" enctype="multipart/form-data">
               <div class="form-grid-profile">
                  <select id="selected-hostel" name="hostel_id" required>
    <option value="" disabled <?php echo empty($_SESSION['form_data']['hostel_id']) ? 'selected' : ''; ?>>Select your hostel to manage</option>
    <?php
        $hostels = getHostelName($_SESSION['user_id']);
        foreach($hostels as $hostel) { ?>
            <option value="<?php echo $hostel['id'];?>"
                <?php echo (isset($_SESSION['form_data']['hostel_id']) && $_SESSION['form_data']['hostel_id'] == $hostel['id']) ? 'selected' : ''; ?>>
                <?php echo $hostel['hostel_name'];?>
            </option>
    <?php } ?>
</select>

        <div class="form-group">
            <label>Room Type</label>
              <div class="select-wrapper">
        <select id="roomType" name="room_type" required>
            <option value="">Select Room Type</option>
            <option value="One seater" <?php echo ($_SESSION['form_data']['room_type'] ?? '') == 'One seater' ? 'selected' : ''; ?>>One seater</option>
            <option value="Double seater" <?php echo ($_SESSION['form_data']['room_type'] ?? '') == 'Double seater' ? 'selected' : ''; ?>>Double seater</option>
            <option value="Three seater" <?php echo ($_SESSION['form_data']['room_type'] ?? '') == 'Three seater' ? 'selected' : ''; ?>>Three seater</option>
            <option value="Four seater" <?php echo ($_SESSION['form_data']['room_type'] ?? '') == 'Four seater' ? 'selected' : ''; ?>>Four seater</option>
        </select>
    </div>
        </div>

        <div class="form-group">
            <label for="noOfBed">No. of beds</label>
            <input type="number" id="noOfBed" name="no_of_beds" required value="<?php echo htmlspecialchars($_SESSION['form_data']['no_of_beds'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="price">Price/bed per day</label>
            <input type="number" id="price" name="price" required placeholder="Input Price" value="<?php echo htmlspecialchars($_SESSION['form_data']['price'] ?? ''); ?>">
        </div>
    </div>
 <div class="form-group upload-group full-width">
                        <label>Upload Room Image</label>
                        <div class="upload-box">
                            <p class="note">Note: Format photos SVG, PNG, or JPG</p>
                            
                                 <input type="file" class= "browse" id = "room_images" name="room_images" accept="image/*" onchange="previewCoverImage(this)" required />
                                 <div class="preview-container"></div>
                           
                        </div>
                        
                     </div>     
    </div>
    <div class="form-actions">
        <button type="submit" name="btn_submit" class="btns btn-primary">Save</button>
        <button type="button" name="btn_cancel" class="btns btn-secondary">Cancel</button>
    </div>
</form>

</div>
                
        </main>
        
    </div>


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

    <script>
document.getElementById("roomType").addEventListener("change", function() {
    let noOfBedInput = document.getElementById("noOfBed");
    let selectedType = this.value;

    switch (selectedType) {
        case "One seater":
            noOfBedInput.value = 1;
            break;
        case "Double seater":
            noOfBedInput.value = 2;
            break;
        case "Three seater":
            noOfBedInput.value = 3;
            break;
        case "Four seater":
            noOfBedInput.value = 4;
            break;
        default:
            noOfBedInput.value = "";
    }
});
</script>

<script src="preview_images.js"></script>
<script src="../popup.js"></script>

</body>
</html>