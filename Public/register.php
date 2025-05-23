<?php
session_start();
require_once __DIR__ . '/../Classes/User.php';

use Classes\User;

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $user = new User();
        if ($user->register($username, $password)) {
            $message = "✅ Registration successful. You can login now.";
        } else {
            $message = "❌ Username already taken.";
        }
    } else {
        $message = "❌ Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>
<p><?php echo $message; ?></p>
<p><a href="login.php">Already have an account? Login here</a></p>
</body>
</html>