<?php
session_start();
require_once '../../backend/auth_check.php';
require_once '../../backend/edit_room.php';


if (!isset($_GET['id'])) {
    die("Room ID not provided.");
}

$room_id = intval($_GET['id']);

// fetch room details
$con = dbConnect();
$sql = "SELECT * FROM tbl_room WHERE id = $room_id";
$result = mysqli_query($con, $sql);
$room = mysqli_fetch_assoc($result);

if (!$room) {
    die("Room not found.");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Room Details</title>
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
                <h1>Edit Room Details</h1>
            </div>

        <div class="forms">
            <form method="POST" action="" enctype="multipart/form-data">
               <div class="form-grid-profile">
                 

        <div class="form-group">
            <label>Room Type</label>
              <div class="select-wrapper">
        <select id="roomType" name="room_type" required>
    <option value="One seater" <?php echo $room['room_type']=="One seater"?"selected":""; ?>>One seater</option>
    <option value="Double seater" <?php echo $room['room_type']=="Double seater"?"selected":""; ?>>Double seater</option>
    <option value="Three seater" <?php echo $room['room_type']=="Three seater"?"selected":""; ?>>Three seater</option>
    <option value="Four seater" <?php echo $room['room_type']=="Four seater"?"selected":""; ?>>Four seater</option>
</select>
    </div>
        </div>

        <div class="form-group">
            <label for="noOfBed">No. of beds</label>
            <input type="number" id="noOfBed" name="no_of_beds"  required value="<?php echo htmlspecialchars($room['total_beds']); ?>">
        </div>

        <div class="form-group">
            <label for="price">Price/bed per day</label>
            <input type="number" id="price" name="price"  required placeholder="Input Price" value="<?php echo htmlspecialchars($room['price']); ?>">
        </div>
    </div>
<div class="form-group upload-group full-width">
    <label>Upload Room Image</label>
    <div class="upload-box">
        <p class="note">Note: Format photos SVG, PNG, or JPG</p>

     

        <!-- File input for new upload -->
        <input type="file" class="browse" id="room_images" name="room_images" 
               accept="image/*" onchange="previewCoverImage(this)" />

           <!-- Show existing image if available -->
        <?php if (!empty($room['images'])): ?>
            <div class="preview-container">
                <img src="../../<?php echo htmlspecialchars($room['images']); ?>" 
                     alt="Room Image" 
                     style="max-width:150px; max-height:120px; border:1px solid #ccc; margin-bottom:10px;">
            </div>
        <?php endif; ?>
    </div>
</div>
    
    </div>
    <div class="form-actions">
        <button type="submit" name="btn_submit" class="btns btn-primary">Save Changes</button>
        <button type="reset" class="btns btn-secondary" onclick="window.location.href='room-list.php'">Discard Changes</button>    </div>
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