<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room Details</title>
    <link rel="stylesheet" href="css/hostel-registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="container">
        <?php include 'sidebar.php'; ?>

        
        <main class="main-content">

    
              

            <div class="tab-header">
                <h1>Add Rooms</h1>
            </div>

           <div class="grid-wrapper">
                <div class="form-grid-profile">
                    <div class="form-group">
                        <label for="roomNo">Room No.</label>
                        <input type="text" id="roomNo" placeholder="Input Room Number">
                    </div>
                    <div class="form-group">
                        <label>Room Type</label>
                        <div class="select-wrapper">
                          <select id="roomType">
                          <option>Select Room Type </option>
                    </select>
                    <i class="fas fa-chevron-down"></i>
                </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" id="price" placeholder="Input Price">
                    </div>
                </div>
                <div class="gallery-section">
                        <h3>Room Images</h3>
                        <p class="note">Note: Format photos SVG, PNG, or JPG (Max-size: 4mb)</p>
                        <div class="gallery">
                          <label class="photo-slot">
                            <input type="file" hidden />
                            <img src="https://img.icons8.com/ios/50/image--v1.png" alt="Upload Icon" />
                            <span>Photo 1</span>
                          </label>
                          <label class="photo-slot">
                            <input type="file" hidden />
                            <img src="https://img.icons8.com/ios/50/image--v1.png" alt="Upload Icon" />
                            <span>Photo 2</span>
                          </label>
                          <label class="photo-slot">
                            <input type="file" hidden />
                            <img src="https://img.icons8.com/ios/50/image--v1.png" alt="Upload Icon" />
                            <span>Photo 3</span>
                          </label>
                          <label class="photo-slot">
                            <input type="file" hidden />
                            <img src="https://img.icons8.com/ios/50/image--v1.png" alt="Upload Icon" />
                            <span>Photo 4</span>
                          </label>
                        </div>
                </div>
                
            
        </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Save Changes</button>
                    <button class="btn btn-secondary">Discard Changes</button>
                </div>
            </div>
            </div>
        </main>
    </div>
</body>
</html>