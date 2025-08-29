<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/registration_reg.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f4f7f9;
            color: #333;
        }
        .main-content {
            display: flex;
        }
        /* Stats grid */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 40px 20px;
            flex: 1;
        }
        .card {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .card h2 {
            font-size: 2rem;
            margin: 10px 0;
            color: #1A3B64;
        }
        .card p {
            font-size: 1rem;
            color: #777;
        }
        .tab-header {
            padding: 20px;
            background-color: #1875bb;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include 'notifBar_Admin.php'; ?>
    <?php include 'sidebarA.php'; ?>
    <main class="main-content">
        

        <div style="flex:1;">
            <div class="tab-header">
                <h1>Admin Dashboard</h1>
            </div>

            <div class="dashboard-cards">
                <div class="card">
                    <p>Total Users</p>
                    <h2 id="total-users">0</h2>
                </div>
                <div class="card">
                    <p>Approved Hostels</p>
                    <h2 id="approved-hostels">0</h2>
                </div>
                <div class="card">
                    <p>Rejected Hostels</p>
                    <h2 id="rejected-hostels">0</h2>
                </div>
                <div class="card">
                    <p>On Pending Hostels</p>
                    <h2 id="pending-hostels">0</h2>
                </div>
                <div class="card">
                    <p>Total Bookings</p>
                    <h2 id="total-bookings">0</h2>
                </div>
            </div>
        </div>
    </main>

    <script>
     fetch('../../backend/admin_stats.php')
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            document.getElementById('total-users').innerText = data.total_users;
            document.getElementById('approved-hostels').innerText = data.approved_hostels;
            document.getElementById('rejected-hostels').innerText = data.rejected_hostels;
            document.getElementById('pending-hostels').innerText = data.pending_hostels;

            document.getElementById('total-bookings').innerText = data.total_bookings;
        }
    })
    .catch(err => console.error("Error fetching stats:", err));

    </script>
</body>
</html>
