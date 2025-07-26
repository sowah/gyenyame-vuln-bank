<?php
session_start();

// Prevent access if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("db", "gyenyame_user", "password123", "gyenyame");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'] ?? 1;
?>
<!DOCTYPE html>
<html>
<head>
    <title>GyeNyame Bank - Dashboard</title>
    <style>
    html, body {
margin: 0;
padding: 0;
height: 100%;
font-family: 'Segoe UI', sans-serif;
background: linear-gradient(to right, #243b55, #141e30);
color: #f4f4f4;
overflow: hidden;
}

.top-bar {
background: #203a43;
color: white;
padding: 15px 20px;
height: 54px;
display: flex;
align-items: center;
justify-content: space-between;
}

.logout {
background: #c0392b;
color: white;
padding: 6px 10px;
text-decoration: none;
border-radius: 6px;
}

.logout:hover {
background: #a93226;
}

.wrapper {
display: flex;
height: calc(100vh - 54px); /* full height minus top bar */
}

.sidebar {
width: 220px;
background: #1c2b36;
padding-top: 20px;
height: 100%;
display: flex;
flex-direction: column;
}

.sidebar a {
display: block;
padding: 12px 20px;
color: #f4f4f4;
text-decoration: none;
border-left: 4px solid transparent;
}

.sidebar a:hover {
background-color: #34495e;
border-left: 4px solid #00c3ff;
}

.content {
flex-grow: 1;
padding: 30px;
background: #fff;
color: #333;
border-top-left-radius: 20px;
overflow-y: auto;
}

h2 {
color: #243b55;
}

.summary-card {
background: #e6f0f5;
padding: 20px;
margin: 10px 0;
border-radius: 12px;
box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
}

.summary-card h3 {
color: #2e3a59;
margin-bottom: 10px;
}

.footer {
background: #2c3e50;
color: #bdc3c7;
text-align: center;
padding: 10px;
font-size: 14px;
position: absolute;
bottom: 0;
left: 220px;
right: 0;
}

    </style>
</head>
<body>
    <div class="top-bar">
        <span>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> | GyeNyame Bank</span>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="wrapper">
        <div class="sidebar">
            <a href="dashboard.php">🏠 Dashboard</a>
            <a href="transactions.php?user_id=1">📄 Transactions</a>
            <a href="profile.php?id=<?= $id ?>">👤 Profile</a>
            <a href="transfer.php">💸 Transfer Funds</a>
            <a href="upload.php">📄 Upload Document</a>
            <a href="search.php" class="<?= $page == 'search.php' ? 'active' : '' ?>">🔍 Search</a>
            <a href="logout.php">🚪 Logout</a>
        </div>

        <div class="content">
            <h2>Account Overview</h2>

            <div class="summary-card">
                <h3>Current Balance</h3>
                <p>GHS 5,200.00</p>
            </div>

            <div class="summary-card">
                <h3>Recent Activity</h3>
                <ul>
                    <li>Received GHS 150 from Kojo - Today</li>
                    <li>Paid GHS 75 to ECG - Yesterday</li>
                    <li>Transfer GHS 500 to Abena - 3 days ago</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer" style="">
       &copy; <?= date('Y') ?> GyeNyame Bank. All rights reserved.
       <p>Niihack Labs</p>
   </div>
</body>
</html>
