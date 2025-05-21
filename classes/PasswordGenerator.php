<?php
class PasswordGenerator {
    public static function generate($length, $uppercase, $lowercase, $numbers, $specials) {
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $nums = '0123456789';
        $spec = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        $password = [];

        // Ensure required characters are included
        $password = array_merge($password, self::getRandomChars($upper, $uppercase));
        $password = array_merge($password, self::getRandomChars($lower, $lowercase));
        $password = array_merge($password, self::getRandomChars($nums, $numbers));
        $password = array_merge($password, self::getRandomChars($spec, $specials));

        // Fill remaining length with random mix
        $remaining = $length - count($password);
        $all = $upper . $lower . $nums . $spec;
        $password = array_merge($password, self::getRandomChars($all, $remaining));

        shuffle($password); // Randomize order

        return implode('', $password);
    }

    private static function getRandomChars($charSet, $count) {
        $result = [];
        $max = strlen($charSet) - 1;
        for ($i = 0; $i < $count; $i++) {
            $result[] = $charSet[random_int(0, $max)];
        }
        return $result;
    }
}
