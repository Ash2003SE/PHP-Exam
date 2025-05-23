<?php
session_start();

require_once __DIR__ . '/../Classes/PasswordGenerator.php';
require_once __DIR__ . '/../Classes/PasswordStorage.php';

use Classes\PasswordGenerator;
use Classes\PasswordStorage;

$password = '';
$message = '';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['plain_password'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$plainPassword = $_SESSION['plain_password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $length = intval($_POST['length']);
    $uppercase = intval($_POST['uppercase']);
    $lowercase = intval($_POST['lowercase']);
    $numbers = intval($_POST['numbers']);
    $specials = intval($_POST['specials']);
    $service = trim($_POST['service'] ?? '');

    if ($service === '') {
        $message = "❌ Service name is required to save.";
    } else {
        $password = PasswordGenerator::generate($length, $uppercase, $lowercase, $numbers, $specials);

        $storage = new PasswordStorage();
        if ($storage->savePassword($userId, $service, $password, $plainPassword)) {
            $message = "✅ Password generated and saved for \"$service\".";
        } else {
            $message = "❌ Failed to save password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Generate & Save Password</title></head>
<body>
    <h2>Password Generator</h2>
    <form method="POST">
        Service Name: <input type="text" name="service" required><br><br>
        Length: <input type="number" name="length" value="10" required><br><br>
        Uppercase Letters: <input type="number" name="uppercase" value="2" required><br><br>
        Lowercase Letters: <input type="number" name="lowercase" value="2" required><br><br>
        Numbers: <input type="number" name="numbers" value="2" required><br><br>
        Special Characters: <input type="number" name="specials" value="2" required><br><br>
        <input type="submit" value="Generate and Save">
    </form>

    <?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (!empty($password)): ?>
        <h3>Generated Password:</h3>
        <p><strong><?= htmlspecialchars($password) ?></strong></p>
    <?php endif; ?>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
