
  
  <nav>
        <div class="logo">
            <span>Hostel<span class="blue">Hub</span></span>
        </div>
        
        <ul class="nav-links">
            <li><a href="hostelfeed.php"><i class="fas fa-home"></i> Home</a></li>
     
            <li class="nav-item">
                <a href="#">
                <div class="notification-bell-wrapper" id="bell-wrapper">
                    <i class="fas fa-bell" onclick="toggleDropdown()"></i> Notifications
                    <span id = "pending-badge" class="badge">3</span>
                     <div id="notif-dropdown" class="notif-dropdown">
                    <div id="notif-content">Loading...</div>
    </div>
      </div>
    </a>
            </li>
            
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-user-circle"></i> Profile
                </a>
                <div class="dropdown profile-dropdown">
                 
                    <ul class="dropdown-links">
                        <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
                        <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                        <li><a href="myBookings.php"><i class="fas fa-bookmark"></i> My Bookings</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> Help & Support</a></li>
                        <li><a href="../../backend/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

      <script>
    let lastNotifCount = 0;

    function toggleDropdown() {

  console.log("Bell clicked");
 
      const dropdown = document.getElementById("notif-dropdown");
      dropdown.classList.toggle("show");
    }
      

    // function notifySound() {
    //   const audio = new Audio('/assets/sound/notify.mp3');
    //   audio.play();
    // }

    function fetchNotifications() {
  fetch("/backend/notification.php")
    .then(response => response.json())
    .then(data => {
      const badge = document.getElementById("pending-badge");
      const content = document.getElementById("notif-content");

      // badge shows only unread count
      badge.style.display = data.count > 0 ? "inline-block" : "none";
      badge.textContent = data.count;

      if (data.notifications && data.notifications.length > 0) {
        content.innerHTML = data.notifications.map(n =>
          `<a href="${n.link}" class="notif-item ${n.is_read == 0 ? 'unread' : 'read'}" 
              onclick="markAsRead(${n.id})">
             ${n.message} 
             <span class="time">${n.created_at}</span>
           </a>`
        ).join('');
      } else {
        content.innerHTML = "<p style='padding:10px;'>No new notifications</p>";
      }
    });
}

function markAsRead(id) {
  fetch("/backend/mark_read.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "id=" + id
  }).then(() => fetchNotifications()); // refresh after marking read
}

setInterval(fetchNotifications, 10000);
fetchNotifications();

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
      const dropdown = document.getElementById("notif-dropdown");
      const bellWrapper = document.getElementById("bell-wrapper");

      if (!bellWrapper.contains(event.target)) {
        dropdown.classList.remove("show");
      }
    });
  </script>

   <script>
        // Toggle dropdowns
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                // Close all other dropdowns
                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    if (dropdown !== this.querySelector('.dropdown')) {
                        dropdown.classList.remove('active');
                    }
                });
                
                // Toggle current dropdown
                const dropdown = this.querySelector('.dropdown');
                if (dropdown) {
                    dropdown.classList.toggle('active');
                }
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.nav-item')) {
                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    dropdown.classList.remove('active');
                });
            }
        });

        // Filter option selection
        document.querySelectorAll('.filter-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.filter-option').forEach(opt => {
                    opt.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        
    
    </script>