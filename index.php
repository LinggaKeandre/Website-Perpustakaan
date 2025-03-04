<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $result = $conn->query("SELECT * FROM admin WHERE username='$username' AND password='$password'");

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $username;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Username atau password salah.";
        }
    } elseif (isset($_POST['guest_login'])) {
        $_SESSION['guest'] = true;
        header('Location: dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet" type="text/css" href="assets/index.css">
    <script src="assets/index.js" defer></script>  
</head>
<body>
    <div class="form-container">
        <h1>Login Admin</h1>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit" class="btn-login">Login</button>
        </form>
        <form method="POST" action="">
            <button type="submit" name="guest_login" class="btn-guest">Login sebagai Tamu</button>
        </form>
    </div>
</body>
</html>