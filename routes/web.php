<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\CallbackController;
use App\Controllers\BoardController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Controllers\DocsController;
use Core\Router;
use function Core\view;


// Auth Controllers

Router::post('/github', [AuthController::class, 'github'])->middleware(GuestMiddleware::class);

Router::get('/callback', [CallbackController::class, 'handle'])->middleware(GuestMiddleware::class);

Router::post('/logout', [AuthController::class, 'logout'])->middleware(AuthMiddleware::class);

Router::post('/register', [UserController::class, 'store'])->middleware(GuestMiddleware::class);

Router::post('/login', [UserController::class, 'login'])->middleware(GuestMiddleware::class);

Router::post('/documentation', [DocsController::class, 'store'])->middleware(AuthMiddleware::class);

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

Router::get('/documentation', function() {
    return view('documentation');
})->middleware(AuthMiddleware::class);
