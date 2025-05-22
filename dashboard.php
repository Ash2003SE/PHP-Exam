<?php
require_once 'classes/PasswordStorage.php';

// Simulate a logged-in user for now
$userId = 1;
$userPlainPassword = 'userpassword123'; // Should come from login

$storage = new PasswordStorage();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = $_POST['service'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($service) && !empty($password)) {
        if ($storage->savePassword($userId, $service, $password, $userPlainPassword)) {
            $message = "✅ Password saved!";
        } else {
            $message = "❌ Failed to save password.";
        }
    }
}

$saved = $storage->getPasswords($userId, $userPlainPassword);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Save Passwords</title>
</head>
<body>
    <h2>Save New Password</h2>
    <form method="POST">
        Service Name: <input type="text" name="service" required><br><br>
        Password: <input type="text" name="password" required><br><br>
        <input type="submit" value="Save Password">
    </form>
    <p><?php echo $message; ?></p>

    <h3>Saved Passwords</h3>
    <ul>
        <?php foreach ($saved as $entry): ?>
            <li>
                <strong><?php echo htmlspecialchars($entry['service']); ?>:</strong>
                <?php echo htmlspecialchars($entry['password']); ?> –
                <em><?php echo $entry['created_at']; ?></em>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
