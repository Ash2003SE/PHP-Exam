<?php
// File: Classes/User.php
namespace Classes;

use PDO;
use Config\Database;
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/Encryption.php';

class User {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getPDO();
    }

    public function register($username, $password) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->fetch()) {
            return ["success" => false, "message" => "Username already taken."];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $encryptionKey = Encryption::encrypt(bin2hex(random_bytes(32)), $password);

        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, encryption_key) VALUES (?, ?, ?)");
        $stmt->execute([$username, $hashedPassword, $encryptionKey]);

        return ["success" => true, "message" => "Registration successful."];
    }

    public function login($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $user['encryption_key'] = Encryption::decrypt($user['encryption_key'], $password);
            return $user;
        }

        return false;
    }
}
