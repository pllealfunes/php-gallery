<?php

namespace Core;

class Validator
{
    public static function string($value, $min = 1, $max = INF)
    {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function fileType($fileName, $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'])
    {
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        return in_array($fileType, $allowedTypes);
    }

    public static function email(string $value): bool
        {
            return filter_var($value, FILTER_VALIDATE_EMAIL);
        }

        public static function greaterThan(int $value, int $greaterThan): bool
        {
            return $value > $greaterThan;
        }
}