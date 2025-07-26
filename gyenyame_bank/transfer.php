<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_GET['user_id'] ?? 1;
$conn = new mysqli('db','root','example','gyenyame');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Store command output (for UI rendering later)
$cmd_output = "";
if (!empty($_GET['cmd'])) {
    // ❗ CTF: Vulnerable to command injection
    $cmd_output = shell_exec($_GET['cmd']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_SESSION['username'];
    $to = $_POST['recipient'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $note = $_POST['cmd'] ?? '';

    if (!empty($to) && is_numeric($to) && is_numeric($amount)) {
        $stmt = $conn->prepare("INSERT INTO transactions (user_id, note, amount) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $to, $note, $amount);
        $stmt->execute();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GyeNyame Bank - Transfer</title>
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
            left: 0;
            top: 0;
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
        input[type="text"], input[type="number"], textarea, input[type="submit"] {
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #2980b9;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #1f618d;
        }
        .cmd-output {
            background: #1e1e1e;
            color: #00ff66;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            font-family: monospace;
            overflow-x: auto;
            white-space: pre-wrap;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
  <div class="sidebar">
       <h2>GyeNyame Bank</h2>
       <a href="dashboard.php">🏦 Dashboard</a>
       <a href="transactions.php?user_id=1">📄 Transactions</a>
       <a href="profile.php?id=<?= $user_id ?>">👤 Profile</a>
       <a href="transfer.php" class="active">💸 Transfer Funds</a>
       <a href="upload.php">📁 Upload Document</a>
       <a href="search.php" class="<?= $page == 'search.php' ? 'active' : '' ?>">🔍 Search</a>
       <a href="logout.php">🚪 Logout</a>
   </div>

    <div class="content">
        <div class="header">
            <h1>Transfer Funds</h1>
        </div>

        <div class="section">
            <form method="POST" action="">
                <label for="recipient">Recipient User ID (Integer)</label>
                <input type="text" id="recipient" name="recipient" required>

                <label for="amount">Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" required>

                <label for="note">Note</label>
                <textarea id="note" name="note"></textarea>

                <input type="submit" value="Transfer">
            </form>

            <?php if (!empty($cmd_output)): ?>
                <div class="cmd-output">
                    <?= htmlentities($cmd_output) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        &copy; <?= date('Y') ?> GyeNyame Bank. All rights reserved.
        <p>Niihack Labs</p>
    </div>
</body>
</html>
