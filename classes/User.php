<?php
class Encryption {
    private const CIPHER = 'AES-256-CBC';

    public static function encrypt($data, $password) {
        $key = hash('sha256', $password, true); // 256-bit key
        $iv = openssl_random_pseudo_bytes(16);  // 128-bit IV

        $encrypted = openssl_encrypt($data, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted); // Save IV + encrypted data
    }

    public static function decrypt($data, $password) {
        $key = hash('sha256', $password, true);
        $data = base64_decode($data);

        $iv = substr($data, 0, 16);           // Extract IV
        $encrypted = substr($data, 16);

        return openssl_decrypt($encrypted, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
    }
}
