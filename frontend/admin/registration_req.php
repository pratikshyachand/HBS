<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Registration Requests</title>
  <link rel="stylesheet" href="css/registration_reg.css">
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
                <h1>Hostel Registration Requests</h1>
            </div>
            
            <table>
             <thead>
               <tr>
                 <th>ID</th>
                 <th>Hostel Name</th>
                 <th>Owner</th>
                 <th>Email</th>
                 <th>Contact</th>
                 <th>Location</th>
                 <th>Date Registered</th>
                 <th>Status</th>
               </tr>
             </thead>

             <tbody id="hostelTableBody">
             <tr><td colspan="8">Loading...</td></tr>
             </tbody>
            </table>

        </main>
    </div>

<script>
function loadHostels() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../../backend/fetch_hostels.php", true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("hostelTableBody").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

loadHostels();

setInterval(loadHostels, 5000);
</script>

</body>
</html>
