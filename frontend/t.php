<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Dropdown</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="t.css"> </head>
<body>
    <header class="navbar">
        <div class="nav-icons">
            <div class="notification-bell-wrapper" id="bell-wrapper">
                <i class="fas fa-bell" onclick="toggleNotificationDropdown()"></i>
                <span id="pending-badge" class="badge">0</span> </div>

            <div class="user-profile-icon nav-icon-item">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    <div class="notification-overlay">
        <div class="notification-dropdown show-dropdown">
            <div class="dropdown-header">
                <h3>Notifications</h3>
                <div class="header-actions">
                    <span class="all-btn active">All</span>
                    <span class="unread-btn">Unread</span>
                </div>
            </div>

            <div class="notification-section">
               
                <div class="notification-list">

                    <div class="notification-item">
                        <div class="notification-content">
                            <p><strong>Yuvraj Kalauni</strong> commented on <strong>Niraj Giri's</strong> photo. <span class="time">2d</span></p>
                        </div>
                        <div class="notification-status"></div> 
                    </div>

                    <div class="notification-item friend-request">
                        <div class="notification-content">
                            <p><strong>Puspa Raj Bhatta</strong> sent you a friend request. <span class="time">1w</span></p>
                            <div class="friend-request-actions">
                                <button class="confirm-btn">Confirm</button>
                                <button class="delete-btn">Delete</button>
                            </div>
                        </div>
                        <div class="notification-status"></div>
                    </div>
                </div>
            </div>

            <div class="dropdown-footer">
                <a href="#" class="prev-notifications-btn">See previous notifications</a>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript to toggle the dropdown for demonstration
        function toggleNotificationDropdown() {
            const dropdown = document.querySelector('.notification-dropdown');
            dropdown.classList.toggle('show-dropdown');
        }

        // Optional: Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const bellWrapper = document.getElementById('bell-wrapper');
            const dropdown = document.querySelector('.notification-dropdown');

            if (!bellWrapper.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show-dropdown');
            }
        });
    </script>
</body>
</html>