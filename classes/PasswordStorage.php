<?php
// File: Classes/PasswordStorage.php
namespace Classes;

use PDO;
use Config\Database;

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/Encryption.php';

class PasswordStorage {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getPDO();
    }

    public function savePassword($userId, $service, $password, $userPlainPassword) {
        $encryptedPassword = Encryption::encrypt($password, $userPlainPassword);
        $stmt = $this->pdo->prepare("INSERT INTO saved_passwords (user_id, service_name, password_encrypted, created_at) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $service, $encryptedPassword]);
    }

    public function getPasswords($userId, $userPlainPassword) {
        $stmt = $this->pdo->prepare("SELECT service_name, password_encrypted, created_at FROM saved_passwords WHERE user_id = ?");
        $stmt->execute([$userId]);

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $decrypted = Encryption::decrypt($row['password_encrypted'], $userPlainPassword);
            $results[] = [
                'service' => $row['service_name'],
                'password' => $decrypted,
                'created_at' => $row['created_at']
            ];
        }
        return $results;
    }
}
