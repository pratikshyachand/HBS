<?php
require_once '../../backend/select_hostel.php';
require_once '../../backend/amenities_crud.php'; 
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amenities</title>
    <link rel="stylesheet" href="css/room.css">
    <link rel="stylesheet" href="/frontend/admin/css/registration_reg.css" />
    <link rel="stylesheet" href="css/manage-hostel-profile.css">

    <link rel="stylesheet" href="css/hostel-registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="amenities.js" defer></script>
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <?php include 'notifBar_Owner.php'; ?>
        
        <main class="main-content">
            

            <div class="tab-header">
                <h1>Amenities</h1>
            </div>

            <div class="form">
              <div class="search-bar-header">
                <div class="select-hostel">
                <select id="hostel_id" name="selectedHostel">
                  <option value="" selected disabled>Select your hostel to manage</option>
                <?php
                               $hostels = getHostelName();
                               foreach($hostels as $hostel)
                               {
                            ?>
                                 
                               <option value="<?php echo $hostel['id'] ?>">
                                <?php echo $hostel['hostel_name'] 
                                // hoste-id?>
                               </option>
                               <?php
                               }
                               ?> 
                </select>
            </div>
            
                <button class="btn-add-room" onclick="checkAndOpenAdd()"><i class="fas fa-plus"></i>   Add New Amenities</button>
              </div>

              
<?php

if (isset($_SESSION['popup_message'])): ?>
<div class="popup-message">
  <p><?php echo htmlspecialchars($_SESSION['popup_message']); ?></p>
  <span class="popup-close" onclick="this.parentElement.style.display='none'">×</span>
</div>
<?php unset($_SESSION['popup_message']); endif; ?>

           <table id="amenities-table">
             <thead>
               <tr>
                 <th>S.N</th>
                 <th>Amenity</th>
                 <th>Action</th>
               </tr>
             </thead>
             <tbody id="tableBody">
             <td></td>
            <td></td>
            <td><button class="edit-room" onclick="checkAndOpenEdit()"><i class="fas fa-edit"></i>
            </button>
            <button class="edit-room" onclick=""><i class="fas fa-trash"></i>
            </button>
            </td>           
          </tbody>
            </table>

     
    </main>

     <!-- Add Amenity Modal -->
<div id="amenityAddModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeAddModal()">&times;</span>
    <h2>Add New Amenity</h2>

    
      <form method="POST" >
      <input type="hidden" name="hostel_id" id="selectedHostelAdd">

      <div class="form-group">
        <input type="text" name="amenity_name" placeholder="Enter amenity name" required>
      </div>

      <div class="form-actions">
        <button class="btn btn-primary" name="btn_save">Save</button>
      </div>
    </form>
  </div>
</div>


<!-- Edit Amenity Modal -->
 <div id="amenityEditModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEditModal()">&times;</span>
    <h2>Edit Amenity</h2>

    
                    <div class="form-group">
                        
                        <input type="text" name="amenity_name" placeholder="Enter amenity name">
                    </div>
        
        
    <div class="form-actions">
                    <button class="btn btn-primary" name="btn_update">Save Changes</button>
    </div>
  </div>
</div>

<div id="popupMessage" class="popup-message">
  <p id="popupText"></p>
  
</div>

</body>
</html>