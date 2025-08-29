<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Amenities</title>
<link rel="stylesheet" href="css/room.css">
<link rel="stylesheet" href="css/styles.css">
<link rel="stylesheet" href="/frontend/admin/css/registration_reg.css">
<link rel="stylesheet" href="css/manage-hostel-profile.css">
<link rel="stylesheet" href="css/hostel-registration.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container">
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
        <?php include 'notifBar_Owner.php'; ?>

        <div class="tab-header">
            <h1>Amenities</h1>
            <div class="add-button-row">
                <button class="btn-add-room" id="btnAddAmenity">
                    <i class="fas fa-plus"></i> Add New Amenity
                </button>
            </div>
        </div>

        <div class="form">
            <div class="controls-row">
                <div class="search-bar-wrapper">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search amenities..." id="searchInput">
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table id="amenities-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Amenity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="amenities-body">
                    <tr><td colspan="3">No amenities added</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Add/Edit Amenity Modal -->
<div id="addAmenityModal" class="deleteModal">
  <div class="deleteModal-content">
    <span class="close">&times;</span>
    <h3 id="modalTitle">Add New Amenity</h3>
    <input type="text" id="amenityName" name="amenityName" placeholder="Enter amenity name">
    <div class="deleteModal-actions">
      <button id="saveAmenity" class="btns btn-primary">Save</button>
      <button class="btns btn-secondary" onclick="document.getElementById('addAmenityModal').style.display='none'">Cancel</button>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
 <div id="deleteModal" class="deleteModal">
  <div class="deleteModal-content">
    <span class="close">&times;</span>
    <h3>Are you sure?</h3>
    <p>Are you sure you want to delete this item? This action cannot be undone.</p>
    <div class="deleteModal-actions">
      <button id="cancelDelete" class="btn-cancel">Cancel</button>
      <button id="confirmDelete" class="btn-delete">Delete</button>
    </div>
  </div>
</div>


<script src="amenities_fetch.js"></script>
</body>
</html>
