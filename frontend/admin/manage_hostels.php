<?php
session_start();
require '../../backend/auth_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Hostels</title>
  <link rel="stylesheet" href="../hostel_owner/css/hostel-registration.css" />
  <link rel="stylesheet" href="../hostel_owner/css/popup.css" />
  <link rel="stylesheet" href="css/registration_reg.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    table tbody tr {
      cursor: pointer;
      transition: background-color 0.2s;
    }
    table tbody tr:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>
<div class="container">
    <?php include 'sidebarA.php'; ?>
    <?php include 'notifBar_Admin.php'; ?>
    
    <main class="main-content">
        <div class="tab-header">
            <h1>Manage Hostels</h1>
        </div>
        <div class="table-controls" style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
            <input type="text" id="searchInput" placeholder="Search hostels..." style="padding:5px 10px; width:250px; border-radius:5px; border:1px solid #ccc;">
        </div>
       <table>
            <thead>
                <tr>
                    <th>Hostel ID</th>
                    <th>Hostel Name</th>
                    <th>Owner Name</th>
                     <th>Email</th>
                    <th>Location</th>
                    <th>Date Registered</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr><td colspan="5">Loading...</td></tr>
            </tbody>
        </table>
    </main>
</div>

<script>
// Load hostels
function loadHostels() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../backend/manage_hostel.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("tableBody").innerHTML = xhr.responseText;
        } else {
            document.getElementById("tableBody").innerHTML = "<tr><td colspan='5'>Error loading hostels</td></tr>";
        }
    };
    xhr.send();
}

// Initial load + refresh every 5 seconds
loadHostels();
setInterval(loadHostels, 5000);

// Delete hostel
document.addEventListener("click", function(e) {
    if (e.target.closest(".delete-btn")) {
        let btn = e.target.closest(".delete-btn");
        let hostelId = btn.getAttribute("data-id");

        if (confirm("Are you sure you want to delete this hostel?")) {
            fetch("../../backend/delete_hostel.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + hostelId
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    document.getElementById("row-" + hostelId).remove();
                } else {
                    alert("Failed to delete hostel.");
                }
            });
        }
    }
});
</script>

<script src="search.js"></script>
</body>
</html>
