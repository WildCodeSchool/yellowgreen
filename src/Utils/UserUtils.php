<?php

namespace App\Utils;

class UserUtils
{
    public static function checkName(string $key, mixed $value): array
    {
        $errors = array();
        if (!isset($value) || $value === '') {
            $errors[] = $key . " is required";
        } elseif (strlen($value) > 45 || strlen($value) < 2) {
            $errors[] = "Your " . $key . " must be between 2 and 45 characters";
        }
        return ['errors' => $errors, 'value' => $value];
    }

    public static function checkEmail(mixed $value): array
    {
        $errors = array();
        if ($value === '') {
            $errors[] = "Email is required";
        } else {
            $value = filter_var($value, FILTER_VALIDATE_EMAIL);
            if (!$value) {
                $errors[] = $value . "is not a valid email address";
            }
        }
        return ['errors' => $errors, 'value' => $value];
    }

    public static function checkPassword(mixed $value): array
    {
        $errors = array();
        if (!isset($value) || $value === '') {
            $errors[] = "Password is required";
        } elseif (strlen($value) > 45 || strlen($value) < 8) {
            $errors[] = "Your password must be between 8 and 45 characters";
        } else {
            $value = password_hash($value, PASSWORD_ARGON2ID);
        }
        return ['errors' => $errors, 'value' => $value];
    }

    public static function checkData(array $user): array
    {
        $errors = array();
        foreach ($user as $key => $value) {
            switch ($key) {
                case 'firstName':
                case 'lastName':
                case 'nickName':
                    $result = self::checkName($key, $value);
                    $errors = array_merge($errors, $result['errors']);
                    break;
                case 'email':
                    $result = self::checkEmail($value);
                    $errors = array_merge($errors, $result['errors']);
                    $user['email'] = $result['value'];
                    break;
                case 'passWord':
                    $result = self::checkPassword($value);
                    $errors = array_merge($errors, $result['errors']);
                    $user['passWord'] = $result['value'];
                    break;
                default:
            }
        }
        return ['errors' => $errors, 'user' => $user];
    }
}
