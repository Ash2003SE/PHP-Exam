<?php
require_once 'config/db.php';
require_once 'classes/Encryption.php';

class PasswordStorage {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function savePassword($userId, $service, $password, $userPlainPassword) {
        $encryptedPassword = Encryption::encrypt($password, $userPlainPassword);

        $stmt = $this->conn->prepare("INSERT INTO saved_passwords (user_id, service_name, password_encrypted) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $service, $encryptedPassword]);
    }

    public function getPasswords($userId, $userPlainPassword) {
        $stmt = $this->conn->prepare("SELECT service_name, password_encrypted, created_at FROM saved_passwords WHERE user_id = ?");
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
