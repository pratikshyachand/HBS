<?php
     session_start();
     require '../../backend/auth_check.php';
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Registration Requests</title>
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
                <h1>Manage Users</h1>
            </div>
            <div class="table-controls" style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
    <input type="text" id="searchInput" placeholder="Search users..." style="padding:5px 10px; width:250px; border-radius:5px; border:1px solid #ccc;">
</div>
           <table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <tr><td colspan="6">Loading...</td></tr>
    </tbody>
</table>


        </main>
    </div>

<script>
function loadBookings() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../backend/fetch_users.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("tableBody").innerHTML = xhr.responseText;
        } else {
            document.getElementById("tableBody").innerHTML = "<tr><td colspan='6'>Error loading bookings</td></tr>";
        }
    };
    xhr.send();
}

loadBookings();
setInterval(loadBookings, 5000); 

</script>

<script src="search.js"></script>


<script >

document.addEventListener("click", function(e) {
    if (e.target.closest(".delete-btn")) {
        let btn = e.target.closest(".delete-btn");
        let userId = btn.getAttribute("data-id");

        if (confirm("Are you sure you want to delete this user?")) {
            fetch("../../backend/delete_users.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + userId
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    document.getElementById("row-" + userId).remove();
                } else {
                    alert("Failed to delete user.");
                }
            });
        }
    }
});
</script>



</body>
</html>
