<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\CallbackController;
use App\Controllers\BoardController;
use App\Controllers\DocsController;
use App\Controllers\Page\DashboardController;
use App\Controllers\Page\HomeController;
use App\Controllers\ProjectController;
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
    Router::post('/register', [UserController::class, 'store']);
    Router::post('/login', [UserController::class, 'login']);
    Router::get('/register', [AuthController::class, 'register']);
    Router::get('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
// User Actions
Router::group(['middleware' => AuthMiddleware::class], function() {
    Router::post('/logout', [AuthController::class, 'logout']);
    Router::get('/dashboard/{projectId}', [DashboardController::class, 'index']);

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

    // Project Management
    Router::post('/project', [ProjectController::class, 'store']);
});

// Public Routes
// Home
Router::get('/', [HomeController::class, 'index']);




