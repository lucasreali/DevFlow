<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\CallbackController;
use App\Controllers\BoardController;
use App\Controllers\TaskController;
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

// Documentation routes - Updated to properly handle all actions
Router::get('/documentation', [DocsController::class, 'showDocs'])->middleware(AuthMiddleware::class);
Router::get('/documentation/view', [DocsController::class, 'viewDoc'])->middleware(AuthMiddleware::class);
Router::get('/documentation/edit', [DocsController::class, 'editForm'])->middleware(AuthMiddleware::class);
Router::post('/documentation/update', [DocsController::class, 'updateDoc'])->middleware(AuthMiddleware::class);
Router::get('/documentation/delete', [DocsController::class, 'deleteDoc'])->middleware(AuthMiddleware::class);

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


Router::post('/task', [TaskController::class, 'store']);

// Board Routes

Router::post('/board', [BoardController::class, 'store'])->middleware(AuthMiddleware::class);


