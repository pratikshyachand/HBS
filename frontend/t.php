<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hostel Registration Requests</title>
  <link rel="stylesheet" href="admin/css/registration_reg.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    /* Make rows clickable */
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
                 
                 <th>Hostel Name</th>
                                 <th>Hostel Name</th>

                                                 <th>Hostel Name</th>
                 <th>Hostel Name</th>
                 <th>Hostel Name</th>

                 
               </tr>
             </thead>
             <tbody>
           <?php
include '../backend/func.php';
$conn = dbConnect();

$query = "SELECT 
    id, 
    hostel_name, 
    owner, 
    email, 
    contact
    
FROM tbl_hostel 
";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        

        echo "<tr onclick=\"window.location.href='form_details.php?id={$row['id']}'\">";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['hostel_name']}</td>";
        echo "<td>{$row['owner']}</td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['contact']}</td>";
      
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hostel registration requests found</td></tr>";
}

// Close the connection
$conn->close();
?>


             </tbody>
            </table>

        </main>
    </div>
</body>
</html>
