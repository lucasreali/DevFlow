<?php

namespace App\Controllers;

use Core\Database;
use PDO;
use function Core\view;

class UserController
{
    public function store() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        if (empty($name)) {
            $errors['error_name'] = 'Name is required.';
        }

        if (empty($email)) {
            $errors['error_email'] = 'Email is required.';
        }

        if (empty($password)) {
            $errors['error_password'] = 'Password is required.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['error_email'] = 'Invalid email address.';
        }

        if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[a-zA-Z]/', $password)) {
            $errors['error_password'] = 'Password must be at least 8 characters long and contain at least one letter and one number.';
        }

        if (!empty($errors)) {
            return view('auth/register', ['errors' => $errors]);
        }

        $db = Database::getInstance();

        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $errors['error_email'] = 'User already exists.';
            return view('auth/register', ['errors' => $errors]);
        }

        try {
            $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);
            
            return view('auth/login', ['success' => 'User registered successfully.']);

        } catch (\PDOException $e) {
            die('Error registering the user: ' . $e->getMessage());
        }
    }
    

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        if (empty($email)) {
            $errors['error_email'] = 'Email is required.';
        }

        if (empty($password)) {
            $errors['error_password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            return view('auth/login', ['errors' => $errors]);
        }

        $db = Database::getInstance();

        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $errors['error'] = 'Wrong credentials.';
            return view('auth/login', ['errors' => $errors]);
        }

        if (!password_verify($password, $user['password'])) {
            $errors['error'] = 'Wrong credentials.';
            return view('auth/login', ['errors' => $errors]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user'] = $user;

        return view('dashboard', ['user' => $user]);
    }
}
