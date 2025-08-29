<?php 
session_start();
 require "../../backend/form_details.php";
    require '../../backend/auth_check.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hostel Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../admin/css/form.css">

    
</head>

<body>
<div class="container">
    <h2>Hostel Details</h2>

    <?php if (!empty($popup_message)): ?>
<div class="popup-messageA popup">
    <p><?php echo htmlspecialchars($popup_message); ?></p>
    <span class="popup-closeA" onclick="this.parentElement.style.display='none'">×</span>
</div>
<?php endif; ?>



    <div class="form-row">
        <div class="form-group">
            <i class="fas fa-building"></i>
            <span class="label">Hostel Name</span>
            <div class="value"><?= safe($row['hostel_name']); ?></div>
        </div>
        <div class="form-group">
            <i class="fas fa-user"></i>
            <span class="label">Owner Name</span>
            <div class="value"><?= safe($row['owner']); ?></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <i class="fas fa-id-card"></i>
            <span class="label">PAN/VAT Number</span>
            <div class="value"><?= safe($row['pan_no']); ?></div>
        </div>
        <div class="form-group">
            <i class="fas fa-phone"></i>
            <span class="label">Contact Number</span>
            <div class="value"><?= safe($row['contact']); ?></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <i class="fas fa-envelope"></i>
            <span class="label">Email</span>
            <div class="value"><?= safe($row['email']); ?></div>
        </div>
        <div class="form-group">
            <i class="fas fa-list"></i>
            <span class="label">Hostel Type</span>
            <div class="value"><?= safe($row['type']); ?></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <i class="fas fa-map-marker-alt"></i>
            <span class="label">Province</span>
            <div class="value"><?= safe($row['province_name']); ?></div>
        </div>
        <div class="form-group">
            <i class="fas fa-map-marker-alt"></i>
            <span class="label">District</span>
            <div class="value"><?= safe($row['district_name']); ?></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <i class="fas fa-map-marker-alt"></i>
            <span class="label">Municipality</span>
            <div class="value"><?= safe($row['municipality_name']); ?></div>
        </div>
        <div class="form-group">
            <i class="fas fa-map-pin"></i>
            <span class="label">Ward No.</span>
            <div class="value"><?= safe($row['ward']); ?></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group" style="flex: 1 1 100%;">
            <i class="fas fa-map"></i>
            <span class="label">Location</span>
            <div class="value"><?= safe($location); ?></div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <i class="fas fa-calendar-alt"></i>
            <span class="label">Date Registered</span>
            <div class="value"><?= date("Y-m-d", strtotime($row['date_registered'])); ?></div>
        </div>
        <div class="form-group">
            <i class="fas fa-info-circle"></i>
            <span class="label">Status</span>
            <div class="value"><?= safe($row['status']); ?></div>
        </div>
    </div>

   <div class="form-row">
    <div class="form-group" style="flex: 1 1 100%;">
        <i class="fas fa-upload"></i>
        <span class="label">Uploaded Photo</span>
        <div class="uploads-box">
            <img id="hostelDoc"
     src="<?php echo '../hostel_owner/' . $row['business_doc']; ?>"
     alt="Uploaded Photo"
     style="max-width:200px; cursor:pointer; border-radius:5px;">


        </div>
    </div>
</div>




    <!-- Approve/Reject Buttons -->
    <div class="form-row">
        <div class="form-group" style="flex:1 1 100%; display:flex; justify-content:center; gap:20px; margin-top:20px;">
            <form action="form_details.php?id=<?php echo $row['id']; ?>" method="post" style="display:inline;">
                <input type="hidden" name="hostel_id" value="<?= $row['id']; ?>">
                <button type="submit" class="btn approve-btn" name="btn_approve"><i class="fas fa-check"></i> Approve</button>
            </form>
            <form action="form_details.php?id=<?php echo $row['id']; ?>" method="post" style="display:inline;">
                <input type="hidden" name="hostel_id" value="<?= $row['id']; ?>">
                <button type="submit" class="btn reject-btn" name="btn_reject"><i class="fas fa-times"></i> Reject</button>
            </form>
        </div>
    </div>

</div>

<!-- Modal for image -->
<div id="docModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<script>
var modal = document.getElementById("docModal");
var img = document.getElementById("hostelDoc");
var modalImg = document.getElementById("modalImage");
var span = document.getElementsByClassName("close")[0];

img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
}

span.onclick = function() { 
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
