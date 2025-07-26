<?php
session_start();

// Block access if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$page = basename(__FILE__);
$message = "";

// Vulnerable upload handling
if (isset($_POST['submit'])) {
    $target_dir = "uploads/"; // Make sure this folder exists and is web accessible
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    // NO VALIDATION or sanitization of file type or extension
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
    } else {
        $message = "Sorry, there was an error uploading your file.";
    }
}

$user_id = $_GET['user_id'] ?? 1;
$conn = new mysqli('db','root','example','gyenyame');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>GyeNyame Bank - Upload</title>
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
    .footer {
        background: #2c3e50;
        color: #bdc3c7;
        text-align: center;
        padding: 15px;
        margin-left: 250px;
        box-shadow: -2px -2px 5px rgba(0,0,0,0.1);
    }
    input[type="file"], input[type="submit"] {
        padding: 10px;
        margin-top: 10px;
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
            <h1>Upload Document</h1>
        </div>
        <div class="section">
            <p>Select a document to upload</p>
            <form method="POST" enctype="multipart/form-data" action="upload.php">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <br>
                <input type="submit" value="Upload File" name="submit">
            </form>
            <p><strong>Note:</strong> Upload only pdf files and then visit <code>/uploads</code> to get your uploaded files.</p>
        </div>
    </div>

    <div class="footer">
        &copy; <?= date('Y') ?> GyeNyame Bank. All rights reserved.
        <p>Niihack Labs</p>
    </div>

    <?php if (!empty($message)): ?>
    <script>
        alert("<?= addslashes($message) ?>");
    </script>
    <?php endif; ?>
</body>
</html>
