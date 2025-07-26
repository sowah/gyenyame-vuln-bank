<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("db", "gyenyame_user", "password123", "gyenyame");
if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'] ?? 1;

// 💀 Still vulnerable to IDOR and SQLi – for lab use
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);


// Show SQL errors to help debug (not for production!)
if (!$result) {
    die("<strong>SQL Error:</strong> " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>GyeNyame Bank - Profile</title>
    <style>
        /* Same CSS as before for layout */
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: #ecf0f1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            height: 100vh;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            position: fixed;
        }
        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar a {
            display: block;
            color: #bdc3c7;
            padding: 12px 20px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #34495e;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 40px;
            flex-grow: 1;
        }
        .header {
            background: #3498db;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
        }
        .header h1 {
            margin: 0;
        }
        .section {
            margin-top: 30px;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .footer {
            background: #2c3e50;
            color: #bdc3c7;
            text-align: center;
            padding: 15px;
            margin-left: 250px;
            box-shadow: -2px -2px 5px rgba(0,0,0,0.1);
        }
        label, input {
            display: block;
            margin: 10px 0;
            padding: 8px;
            width: 100%;
        }
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-size: 14px;
        }
    </style>
</head>
<body>
  <div class="sidebar">
       <h2>GyeNyame Bank</h2>
       <a href="dashboard.php">🏦 Dashboard</a>
       <a href="transactions.php?user_id=1">📋 Transactions</a>
       <a href="profile.php?id=<?= $id ?>">👤 Profile</a>
       <a href="transfer.php">💸 Transfer Funds</a>
       <a href="upload.php">📁 Upload Document</a>
       <a href="search.php">🔍 Search</a>
       <a href="logout.php">🚪 Logout</a>
   </div>

   <div class="content">
       <div class="header">
           <h1>Profile of <?= htmlspecialchars($user['username']) ?></h1>
       </div>
       <div class="section">
           <p><strong>User ID:</strong> <?= $user['id'] ?></p>
           <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
           <p><strong>Password (😱):</strong> <?= htmlspecialchars($user['password']) ?></p>
       </div>
   </div>

   <div class="footer">
       &copy; <?= date('Y') ?> GyeNyame Bank. All rights reserved.
       <p>Niihack Labs</p>
   </div>
    <div class="footer">
        &copy; <?= date('Y') ?> GyeNyame Bank. All rights reserved.
        <p>Niihack Labs</p>
    </div>
</body>
</html>
