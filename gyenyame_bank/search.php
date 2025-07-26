<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$page = basename(__FILE__);

// ✅ OOP-style DB connection
$conn = new mysqli("db", "gyenyame_user", "password123", "gyenyame");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_GET['id'] ?? 1;
$results = [];
$error = "";

if (isset($_GET['q'])) {
    $q = $_GET['q'];

    // ❌ VULNERABLE raw SQL injection
    $sql = "SELECT id, username FROM users WHERE username LIKE '%$q%'";

    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    } else {
        // 👉 Show SQL error directly to help exploitation
        $error = $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GyeNyame Bank - Search</title>
    <style>
        /* reuse same styles */
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
        .section {
            margin-top: 30px;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        input[type="text"], input[type="submit"] {
            padding: 10px;
            margin-top: 10px;
        }
        table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            background: #f4f4f4;
        }
        .footer {
            background: #2c3e50;
            color: #bdc3c7;
            text-align: center;
            padding: 15px;
            margin-left: 250px;
            box-shadow: -2px -2px 5px rgba(0,0,0,0.1);
        }
        .error {
          color: red;
          margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>GyeNyame Bank</h2>
        <a href="dashboard.php" class="<?= $page == 'dashboard.php' ? 'active' : '' ?>">🏦 Dashboard</a>
        <a href="transactions.php?user_id=1" class="<?= $page == 'transactions.php' ? 'active' : '' ?>">📋 Transactions</a>
        <a href="profile.php?id=<?= $id ?>" class="<?= $page == 'profile.php' ? 'active' : '' ?>">👤 Profile</a>
        <a href="transfer.php" class="<?= $page == 'transfer.php' ? 'active' : '' ?>">💸 Transfer Funds</a>
        <a href="upload.php" class="<?= $page == 'upload.php' ? 'active' : '' ?>">📁 Upload Document</a>
        <a href="search.php" class="<?= $page == 'search.php' ? 'active' : '' ?>">🔍 Search</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Search Users</h1>
        </div>
        <div class="section">
            <form method="GET" action="search.php">
                <input type="text" name="q" placeholder="Search username">
                <input type="submit" value="Search">
            </form>

            <?php if (!empty($error)): ?>
       <div class="error"><strong>SQL Error:</strong> <?= htmlspecialchars($error) ?></div>
   <?php endif; ?>

   <?php if (!empty($results)): ?>
       <table>
           <tr>
               <th>ID</th>
               <th>Username</th>
           </tr>
           <?php foreach ($results as $row): ?>
               <tr>
                   <td><?= htmlspecialchars($row['id']) ?></td>
                   <td><?= htmlspecialchars($row['username']) ?></td>
               </tr>
           <?php endforeach; ?>
       </table>
   <?php elseif (isset($_GET['q']) && empty($results) && empty($error)): ?>
       <p>No results found.</p>
   <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        &copy; <?= date('Y') ?> GyeNyame Bank. All rights reserved.
        <p>Niihack Labs</p>
    </div>
</body>
</html>
