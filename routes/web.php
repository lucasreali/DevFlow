<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\CallbackController;
use App\Controllers\BoardController;
use App\Controllers\PageController;
use App\Controllers\TaskController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use Core\Router;




Router::get('/callback', [CallbackController::class, 'handle']);
Router::post('/github', [AuthController::class, 'github']);

// Guest Routes
// Login and Registration
Router::group(['middleware' => GuestMiddleware::class], function() {
    Router::post('/github', [AuthController::class, 'github']);
    Router::get('/callback', [CallbackController::class, 'handle']);
    Router::post('/register', [UserController::class, 'store']);
    Router::post('/login', [UserController::class, 'login']);
    Router::get('/register', [PageController::class, 'register']);
    Router::get('/login', [PageController::class, 'login']);
});

// Authenticated Routes
// User Actions
Router::group(['middleware' => AuthMiddleware::class], function() {
    Router::post('/logout', [AuthController::class, 'logout']);
    Router::get('/dashboard', [PageController::class, 'dashboard']);

    // Documentation
    Router::post('/documentation', [DocsController::class, 'store']);
    Router::get('/documentation', [DocsController::class, 'showDocs']);
    Router::get('/documentation/view', [DocsController::class, 'viewDoc']);
    Router::get('/documentation/edit', [DocsController::class, 'editForm']);
    Router::post('/documentation/update', [DocsController::class, 'updateDoc']);
    Router::get('/documentation/delete', [DocsController::class, 'deleteDoc']);

    // Board and Task Management
    Router::post('/board', [BoardController::class, 'store']);
    Router::post('/task', [TaskController::class, 'store']);
});

// Public Routes
// Home
Router::get('/{number}', [PageController::class, 'home']);
Router::get('/', [PageController::class, 'home']);



