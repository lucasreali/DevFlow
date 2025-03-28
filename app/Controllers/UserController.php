<?php

namespace App\Controllers;

use App\Controllers\Auth\AuthController;
use App\Models\Account;
use App\Models\User;
use function Core\view;

class UserController
{
    public static function store()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $errors = self::validateRegister($name, $email, $password);

        if (!empty($errors)) {
            return view('auth/register', ['errors' => $errors]);
        }

        if (User::findByEmail($email)) {
            $errors['error_email'] = 'User already exists.';
            return view('auth/register', ['errors' => $errors]);
        }

        if (User::create($name, $email, $password)) {
            return view('auth/login', ['success' => 'User registered successfully.']);
        } else {
            $errors['error'] = 'Failed to register user.';
            return view('auth/register', ['errors' => $errors]);
        }
    }

    public static function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $errors = self::validateLogin($email, $password);

        if (!empty($errors)) {
            return view('auth/login', ['errors' => $errors]);
        }

        $user = User::findByEmail($email);
        $accont = Account::findByGithubId($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors['error'] = 'Wrong credentials.';
            return view('auth/login', ['errors' => $errors]);
        }

        if ($accont) {
            $user = array_merge($user, $accont);
        }

        AuthController::setUserSession($user);
        return view('dashboard');
    }
    private static function validateRegister($name, $email, $password)
    {
        $errors = [];

        if (empty($name)) {
            $errors['error_name'] = 'Name is required.';
        }

        if (empty($email)) {
            $errors['error_email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['error_email'] = 'Invalid email address.';
        }

        if (empty($password)) {
            $errors['error_password'] = 'Password is required.';
        } elseif (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[a-zA-Z]/', $password)) {
            $errors['error_password'] = 'Password must be at least 8 characters long and contain at least one letter and one number.';
        }

        return $errors;
    }

    private static function validateLogin($email, $password)
    {
        $errors = [];

        if (empty($email)) {
            $errors['error_email'] = 'Email is required.';
        }

        if (empty($password)) {
            $errors['error_password'] = 'Password is required.';
        }

        return $errors;
    }
}
