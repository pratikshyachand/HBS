<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms List</title>
    <link rel="stylesheet" href="css/room.css">
    <link rel="stylesheet" href="css/booking.css">
    <link rel="stylesheet" href="css/hostel-registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php include 'sidebar.php'; ?>

        
        <main class="main-content">
            <?php include '../nav_barA.php'; ?>

            <div class="tab-header">
                <h1>Rooms</h1>
            </div>

            <div class="form">
              <div class="search-bar-header">
                <div class="search-input-wrapper">
                    <input type="text" placeholder="Search">
                    <i class="fas fa-search"></i>
                </div>
                <button class="btn-add-room" onclick="window.location.href='add-room.php'"><i class="fas fa-plus"></i>   Add New Room</button>
              </div>
            
            
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Room</th>
            <th>Room Type</th>
            <th>Occupied</th>
            <th>Available</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>BK001</td>
            <td>Single Sitter</td>
            <td>1</td>
            <td>1</td>
            <td><button class="edit-room"><i class="fas fa-edit"></i>
            </button>
            <button class="edit-room"><i class="fas fa-trash"></i>
            </button>
        </td>
            
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
     <div class="pagination">
      <span>1 - 10 of 13 Pages</span>
      <div>
        <label>Page on</label>
        <select>
          <option value="1">1</option>
        </select>
      </div>
    </div>
    </main>

</body>
</html>