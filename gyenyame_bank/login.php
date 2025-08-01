<?php
session_start();
$conn = mysqli_connect("db", "gyenyame_user", "password123", "gyenyame");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['login'])) {
    // No sanitization = SQLi vulnerable
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ⚠️ Intentionally vulnerable SQL statement
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    // Display the query to help with exploitation (for CTF/lab)
    //echo "<!-- DEBUG: $sql -->";

    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid login credentials";
    }
}
//echo "<pre>DEBUG SQL: $sql</pre>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>GyeNyame Bank - Secure Login</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
        }
        .login-box h2 {
            margin-bottom: 20px;
            color: #2c5364;
            text-align: center;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        .login-box button {
            width: 100%;
            background-color: #2c5364;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-box button:hover {
            background-color: #203a43;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .logo {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo img {
            width: 80px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="logo">
            <!-- You can replace the SVG below with your custom logo -->
            <img src="Gye_nyame2.png" alt="GyeNyame Logo" />
        </div>
        <h2>GyeNyame Bank Login</h2>

      <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>
