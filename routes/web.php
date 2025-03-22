<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Core\Router;
use function Core\view;

Router::post('/github', [AuthController::class, 'github']);

Router::post('/logout', [AuthController::class, 'logout']);

Router::post('/register', [UserController::class, 'store']);

Router::post('/login', [UserController::class, 'login']);

Router::get('/register', function() {
    GuestMiddleware::handle();
    return view('auth/register');
});

Router::get('/login', function() {
    GuestMiddleware::handle();
    return view('auth/login');
});

Router::get('/', function() {
    return view('home');
});

Router::get('/dashboard', function() {
    AuthMiddleware::handle();
    return view('dashboard');
});


