<?php

namespace App\Controllers;

use App\Controllers\Auth\AuthController;
use App\Models\Account;
use App\Models\User;
use function Core\redirect;
use function Core\view;

class UserController
{
    public static function store($data)
    {
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Validate all required parameters
        $errors = self::validateRegister($name, $email, $password);

        if (!empty($errors)) {
            return view('auth/register', ['errors' => $errors]);
        }

        if (User::findByEmail($email)) {
            $errors['error_email'] = 'User already exists.';
            return view('auth/register', ['errors' => $errors]);
        }

        if (User::create($name, $email, $password)) {
            return redirect('/login', ['success' => 'User registered successfully.']);
        } else {
            $errors['error'] = 'Failed to register user.';
            return view('auth/register', ['errors' => $errors]);
        }
    }

    public static function login($data)
    {
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Validate all required parameters
        $errors = self::validateLogin($email, $password);

        if (!empty($errors)) {
            return view('auth/login', ['errors' => $errors]);
        }

        $user = User::findByEmail($email);
        $accont = Account::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors['error'] = 'Wrong credentials.';
            return view('auth/login', ['errors' => $errors]);
        }

        if ($accont) {
            $user = array_merge($user, $accont);
        }

        AuthController::setUserSession($user);
        header('Location: /');
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
    
    public static function update($data)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get the logged-in user
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            return redirect('/', ['error' => 'You must be logged in to update your profile.']);
        }

        // Extract form data
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $currentPassword = $data['password'] ?? '';
        $newPassword = $data['new_password'] ?? '';
        $newPasswordConfirm = $data['new_password_confirm'] ?? '';

        // Validate required fields
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Name is required';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        if (empty($currentPassword)) {
            $errors['password'] = 'Current password is required to save changes';
        }

        // Verify the current password
        if (!empty($currentPassword) && !User::verifyPassword($userId, $currentPassword)) {
            $errors['password'] = 'Current password is incorrect';
        }

        // If a new password is provided, validate it
        if (!empty($newPassword)) {
            if (strlen($newPassword) < 8) {
                $errors['new_password'] = 'New password must be at least 8 characters long';
            } elseif ($newPassword !== $newPasswordConfirm) {
                $errors['new_password_confirm'] = 'Passwords do not match';
            }
        }

        // If there are errors, redirect back with errors
        if (!empty($errors)) {
            // Convert errors array to a single string for the error flash message
            $errorMsg = implode(', ', array_values($errors));
            return redirect('/', ['error' => $errorMsg]);
        }

        // Prepare data for update
        $updateData = [
            'name' => $name,
            'email' => $email
        ];

        // Only include new password if it's provided
        if (!empty($newPassword)) {
            $updateData['new_password'] = $newPassword;
        }

        // Attempt to update the user
        if (User::update($userId, $updateData)) {
            // Update the session with new data
            $user = User::findById($userId);
            $_SESSION['user']['name'] = $user['name'];
            $_SESSION['user']['email'] = $user['email'];
            
            return redirect('/', ['success' => 'Profile updated successfully.']);
        } else {
            return redirect('/', ['error' => 'Failed to update profile.']);
        }
    }
}
