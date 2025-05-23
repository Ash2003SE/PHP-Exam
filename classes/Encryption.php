<?php
// File: Classes/Encryption.php
namespace Classes;

class Encryption {
    private static $cipher = "AES-256-CBC";

    public static function encrypt($data, $password) {
        $key = hash('sha256', $password, true);
        $iv = random_bytes(openssl_cipher_iv_length(self::$cipher));
        $encrypted = openssl_encrypt($data, self::$cipher, $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public static function decrypt($encryptedData, $password) {
        $data = base64_decode($encryptedData);
        $ivLength = openssl_cipher_iv_length(self::$cipher);
        $iv = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);
        $key = hash('sha256', $password, true);
        return openssl_decrypt($encrypted, self::$cipher, $key, 0, $iv);
    }
}
