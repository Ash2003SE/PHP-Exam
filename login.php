<?php
require_once 'classes/User.php';

$message = '';
$decryptedKey = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $user = new User();
        $loggedInUser = $user->login($username, $password);

        if ($loggedInUser) {
            $message = "✅ Login successful!";
            $decryptedKey = $loggedInUser['encryption_key'];
        } else {
            $message = "❌ Invalid credentials.";
        }
    } else {
        $message = "⚠️ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

    <p><?php echo $message; ?></p>

    <?php if (!empty($decryptedKey)): ?>
        <p><strong>Your decrypted key:</strong> <?php echo htmlspecialchars($decryptedKey); ?></p>
    <?php endif; ?>
</body>
</html>
