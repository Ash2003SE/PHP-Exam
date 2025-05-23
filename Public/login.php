<?php
session_start();
require_once __DIR__ . '/../Classes/User.php';

use Classes\User;

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = new User();
    $userData = $user->login($username, $password);

    if ($userData) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['plain_password'] = $password;
        header("Location: dashboard.php");
        exit;
    } else {
        $message = "❌ Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>User Login</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>
<p><?php echo $message; ?></p>
<p><a href="register.php">Don't have an account? Register here</a></p>
</body>
</html>