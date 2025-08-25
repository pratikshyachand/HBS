<?php
session_start();
require_once '../../backend/select_hostel.php';
// require_once '../../backend/get_rooms.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
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
                <h1>Rooms</h1>
                <!-- Add Button Row -->
    <div class="add-button-row">
        <button class="btn-add-room" id="btnAddRoom" onclick="window.location.href='add-room.php'">
            <i class="fas fa-plus"></i> Add New Rooms
        </button>
    </div>
</div>

    <div class="form">
             
    <!-- Dropdown + Search Bar Row -->
    <div class="controls-row">
        <div class="select-hostel">
            <select id="selected-hostel">
                <option selected disabled>Select your hostel</option>
                <?php
                    $hostels = getHostelName($_SESSION['user_id']);
                    foreach($hostels as $hostel) { ?>
                        <option value="<?php echo $hostel['id'];?>">
                            <?php echo $hostel['hostel_name'];?>
                        </option>
                <?php } ?>
            </select>
        </div>

        <div class="search-bar-wrapper">
            <div class="search-input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search rooms..." id="searchInput">
            </div>
        </div>
    </div>

    <!-- Table -->
    <table id="rooms-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Room type</th>
                <th>Image</th>
                <th>Available</th>
                <th>Occupied</th>
                <th>Price/Bed/Night</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="7">Select a hostel to load rooms</td></tr>
        </tbody>
    </table>
</div>
        </main>
    </div>

    <!-- deleting modal -->
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

    <script src="get_rooms.js"></script>
    <script>
document.getElementById("searchInput").addEventListener("input", function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll("#rooms-table tbody tr").forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>


<script>
let roomToDelete = null;
const modal = document.getElementById("deleteModal");
const confirmBtn = document.getElementById("confirmDelete");
const cancelBtn = document.getElementById("cancelDelete");
const closeBtn = modal.querySelector(".close");

function deleteRoom(id) {
    roomToDelete = id;  // store ID
    modal.style.display = "block"; // show modal
}

// Close modal handlers
cancelBtn.onclick = () => modal.style.display = "none";
closeBtn.onclick = () => modal.style.display = "none";
window.onclick = (e) => { if (e.target == modal) modal.style.display = "none"; }

// Confirm delete
confirmBtn.onclick = () => {
    modal.style.display = "none";
    showPopup(`Room ID ${roomToDelete} deleted successfully.`, "success");

    // TODO: Add AJAX call here to delete from backend
    // Example:
    // fetch(`../../backend/delete_room.php?id=${roomToDelete}`, { method: 'POST' })
    //   .then(res => res.json())
    //   .then(data => {
    //       if(data.success){ refreshTable(); }
    //   });
}

</script>
</body>
</html>
