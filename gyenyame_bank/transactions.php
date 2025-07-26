<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$page = basename(__FILE__);
$user_id = $_GET['user_id'] ?? 1; // IDOR
$file = $_GET['file'] ?? null;    // LFI

$conn = new mysqli('db', 'root', 'example', 'gyenyame');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture LFI output
$lfi_output = '';
if ($file) {
    ob_start();
    @include($file); // ⚠️ Local File Inclusion vulnerability
    $lfi_output = ob_get_clean();
}

$result = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>GyeNyame Bank - Transactions</title>
    <style>
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
    .txn {
        background: #f9f9f9;
        margin: 10px 0;
        padding: 15px;
        border-left: 4px solid #3498db;
        border-radius: 4px;
    }
    .footer {
        background: #2c3e50;
        color: #bdc3c7;
        text-align: center;
        padding: 15px;
        margin-left: 250px;
        box-shadow: -2px -2px 5px rgba(0,0,0,0.1);
    }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>GyeNyame Bank</h2>
        <a href="dashboard.php" class="<?= $page == 'dashboard.php' ? 'active' : '' ?>">🏦 Dashboard</a>
        <a href="transactions.php?user_id=1" class="<?= $page == 'transactions.php' ? 'active' : '' ?>">📋 Transactions</a>
        <a href="profile.php?id=<?= $user_id ?>" class="<?= $page == 'profile.php' ? 'active' : '' ?>">👤 Profile</a>
        <a href="transfer.php" class="<?= $page == 'transfer.php' ? 'active' : '' ?>">💸 Transfer Funds</a>
        <a href="upload.php" class="<?= $page == 'upload.php' ? 'active' : '' ?>">📁 Upload Document</a>
        <a href="search.php" class="<?= $page == 'search.php' ? 'active' : '' ?>">🔍 Search</a>
        <a href="logout.php">🚪 Logout</a>
    </div>

    <div class="content">
        <div class="header">
            <h1>Your Transactions</h1>
        </div>

        <div class="section">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='txn'><strong>Txn #{$row['txn_id']}:</strong> {$row['note']}<br><strong>Amount:</strong> GHS {$row['amount']}</div>";
                }
            } else {
                echo "<p>No transactions found for this user.</p>";
            }
            ?>
        </div>

        <?php if ($file): ?>
        <div class="section">
            <pre style="background:#111;color:#0f0;padding:15px;border-radius:8px;overflow:auto;max-height:400px;">
<?= htmlspecialchars($lfi_output) ?>
            </pre>
        </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        &copy; <?= date('Y') ?> GyeNyame Bank. All rights reserved.
        <p>Niihack Labs</p>
    </div>
</body>
</html>
