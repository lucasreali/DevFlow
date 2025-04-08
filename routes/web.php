<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\CallbackController;
use App\Controllers\BoardController;
use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Core\Router;
use function Core\view;

// Auth Controllers

Router::post('/github', [AuthController::class, 'github']);

Router::get('/callback', [CallbackController::class, 'handle']);

Router::post('/logout', [AuthController::class, 'logout']);

Router::post('/register', [UserController::class, 'store']);

Router::post('/login', [UserController::class, 'login']);

// Auth pages

Router::get('/register', function() {
    return view('auth/register');
})->middleware(GuestMiddleware::class);

Router::get('/login', function() {
    return view('auth/login');
})->middleware(GuestMiddleware::class);

// Pages

Router::get('/', function() {
    return view('home');
});

Router::get('/dashboard', function() {
    return view('dashboard');
})->middleware(AuthMiddleware::class);

Router::post('/board', [BoardController::class, 'store']);


Router::post ('/task', [TaskController::class, 'store']);

