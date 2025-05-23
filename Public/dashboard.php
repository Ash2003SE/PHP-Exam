<?php
session_start();
require_once __DIR__ . '/../Classes/PasswordStorage.php';

use Classes\PasswordStorage;

if (!isset($_SESSION['user_id']) || !isset($_SESSION['plain_password'])) {
    header("Location: login.php");
    exit;
}

$storage = new PasswordStorage();
$message = '';
$userId = $_SESSION['user_id'];
$userPlainPassword = $_SESSION['plain_password'];

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Password Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }
        h2, h3 {
            color: #333;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        form input[type="text"], form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        form input[type="submit"], button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .message {
            margin-top: 10px;
            font-weight: bold;
            color: #007bff;
        }
        .password-list {
            margin-top: 30px;
        }
        .password-card {
            background: #f9f9f9;
            border-left: 5px solid #007bff;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
        }
        .password-card strong {
            font-size: 16px;
        }
        .password-card em {
            font-size: 12px;
            color: #666;
            float: right;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['username'] ?? 'User') ?> 👋</h2>
    <p><a href="generate.php">➕ Generate a Password</a> | <a href="logout.php">Logout</a></p>

    <h3>Save a New Password</h3>
    <form method="POST">
        <label>Service Name:</label>
        <input type="text" name="service" required>
        <label>Password:</label>
        <input type="text" name="password" required>
        <input type="submit" value="Save Password">
    </form>

    <?php if (!empty($message)): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <h3 class="password-list">Your Saved Passwords</h3>
    <?php if (count($saved) === 0): ?>
        <p>No passwords saved yet.</p>
    <?php else: ?>
        <?php foreach ($saved as $entry): ?>
            <div class="password-card">
                <strong><?= htmlspecialchars($entry['service']) ?>:</strong>
                <div><?= htmlspecialchars($entry['password']) ?></div>
                <em><?= $entry['created_at'] ?></em>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
