<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Registration Requests</title>
  <link rel="stylesheet" href="css/registration_reg.css">
</head>
<body>
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
                 <th>Location</th>
                 <th>Date Applied</th>
                 <th>Status</th>
                 <th>Action</th>
               </tr>
             </thead>
             <tbody>
               <tr>
             <td>101</td>
             <td>Peace Hostel</td>
             <td>Laxmi Sharma</td>
             <td>peace@gmail.com</td>
             <td>Kathmandu, Bagmati</td>
             <td>2025-06-26</td>
             <td><span style="color: orange;">Pending</span></td>
             <td>
            <button class="btn btn-view" onclick="openModal()">View</button>
            <button class="btn btn-approve">Approve</button>
            <button class="btn btn-reject">Reject</button>
          </td>
        </tr>
    </tbody>
    </table>

    </main>
    </div>


 <!-- Modal -->
<div id="hostelModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Hostel Details</h2>
    <div class="details">
      <p><strong>Hostel Name:</strong> Peace Hostel</p>
      <p><strong>Owner:</strong> Laxmi Sharma</p>
      <p><strong>Contact:</strong> 9801234567</p>
      <p><strong>Email:</strong> peace@gmail.com</p>
      <p><strong>Location:</strong> Kathmandu, Bagmati (Ward 5)</p>
      <p><strong>Description:</strong> A peaceful hostel near the city center.</p>
      <p><strong>License:</strong> <a href="#">Download Document</a></p>
    </div>
    <div style="margin-top: 20px;">
      <button class="btn btn-approve">Approve</button>
      <button class="btn btn-reject">Reject</button>
    </div>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById("hostelModal").style.display = "block";
  }

  function closeModal() {
    document.getElementById("hostelModal").style.display = "none";
  }

  window.onclick = function(event) {
    const modal = document.getElementById("hostelModal");
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
   
   
</body>
</html>
