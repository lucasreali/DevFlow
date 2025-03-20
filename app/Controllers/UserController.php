<?php

namespace App\Controllers;

use Core\Database;
use PDO;
use function Core\view;

class UserController
{
    public function store() {
        $name = $_GET['name'];
        $email = $_GET['email'];
        $password = $_GET['password'];

        if (empty($name) || empty($email) || empty($password)) {
            return view('register', ['error' => 'All fields are required.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return view('register', ['error' => 'Invalid email address.']);
        }

        if (strlen($password) < 8 || !preg_match('/[0-9]/', $password) || !preg_match('/[a-zA-Z]/', $password)) {
            return view('register', ['error' => 'Password must be at least 8 characters long and contain at least one letter and one number.']);
        }

        $db = Database::getInstance();

        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            return view('register', ['message' => 'User already exists.']);
        }

        try {
            $stmt = $db->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);
            
            return view('login', ['success' => 'User registered successfully.']);

        } catch (\PDOException $e) {
            die('Erro ao cadastrar o usuário: ' . $e->getMessage());
        }
    }

    public function login() {
        $email = $_GET['email'];
        $password = $_GET['password'];

        if (empty($email) || empty($password)) {
            return view('login', ['error' => 'All fields are required.']);
        }

        $db = Database::getInstance();

        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            return view('login', ['error' => 'Invalid email or password.']);
        }

        session_start();
        $_SESSION['user'] = $user;

        return view('dashboard', ['user' => $user]);
    }
}
