<?php
// File: Config/Database.php
namespace Config;

use PDO;
use PDOException;

class Database {
    private static $host = "localhost";
    private static $db_name = "password_manager";
    private static $username = "root";
    private static $password = "";
    private static $conn = null;

    public static function getPDO() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db_name,
                    self::$username,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
