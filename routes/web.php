<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\CallbackController;
use App\Controllers\BoardController;
use App\Controllers\DocumantationController;
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
    // Home
    Router::get('/', [HomeController::class, 'index']);

    Router::post('/logout', [AuthController::class, 'logout']);
    Router::get('/dashboard/{projectId}', [DashboardController::class, 'index']);

    // Documentation
    Router::get('/documentation/{projectId}', [DocumantationController::class, 'index']);
    Router::post('/documentation/{projectId}', [DocumantationController::class, 'store']);
    Router::get('/documentation/{projectId}/{id}', [DocumantationController::class, 'view']);

    Router::post('/documentation/update/{projectId}/{id}', [DocumantationController::class, 'update']);
    Router::post('/documentation/delete/{projectId}/{id}', [DocumantationController::class, 'delete']);

    // Board and Task Management
    Router::post('/board', [BoardController::class, 'store']);
    Router::post('/task', [TaskController::class, 'store']);
    Router:: post('/task/update', [TaskController::class, 'update']);
    Router::post('/task/delete', [TaskController::class, 'delete']);

    // Project Management
    Router::post('/project', [ProjectController::class, 'store']);
    Router::post('/project/update/{projectId}', [ProjectController::class, 'update']);
    Router::post('/project/delete/{projectId}', [ProjectController::class, 'delete']);
});

// Public Routes





