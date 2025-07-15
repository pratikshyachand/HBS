
    <header class="navbar">
     <div class="nav-icons">
    <div class="notification-bell-wrapper" id="bell-wrapper">
      <i class="fas fa-bell" onclick="toggleDropdown()"></i>
      <span id="pending-badge" class="badge">0</span>
      <div id="notif-dropdown" class="notif-dropdown">
        <div id="notif-content">Loading...</div>
        <a href="registration_req.php" class="view-all">View All</a>
      </div>
    </div>

    <i class="fas fa-user"></i>
  </div>
  </header>
  


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
      console.log("fetching notifications");
      fetch("/backend/notification.php")
        .then(response => response.json())
        .then(data => {
          const badge = document.getElementById("pending-badge");
          const content = document.getElementById("notif-content");

          badge.style.display = data.count > 0 ? "inline-block" : "none";
          badge.textContent = data.count;

          // if (data.count > lastNotifCount) {
          //   notifySound();
          // }

          lastNotifCount = data.count;

          if (data.notifications && data.notifications.length > 0) {
            content.innerHTML = data.notifications.map(n =>
              `<a href="${n.link}">${n.message}<span class="time">${n.created_at}</span></a>`
            ).join('');
          } else {
            content.innerHTML = "<p style='padding:10px;'>No new notifications</p>";
          }
        });
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


