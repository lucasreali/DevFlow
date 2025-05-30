<?php

use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\CallbackController;
use App\Controllers\BoardController;
use App\Controllers\DocumentationController;
use App\Controllers\FriendshipController;
use App\Controllers\GitHubController;
use App\Controllers\LabelController;
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
    Router::get('/documentation/{projectId}', [DocumentationController::class, 'index']);
    Router::post('/documentation/{projectId}', [DocumentationController::class, 'store']);
    Router::get('/documentation/{projectId}/{id}', [DocumentationController::class, 'view']);
    Router::post('/documentation/update/{projectId}/{id}',[DocumentationController::class, 'update']);
    Router::post('/documentation/delete/{projectId}/{id}',[DocumentationController::class, 'delete']);

    // Board Management
    Router::post('/board', [BoardController::class, 'store']);
    Router::post('/board/update', [BoardController::class, 'update']);
    Router::post('/board/delete', [BoardController::class, 'delete']);

    // Task Management
    Router::post('/task', [TaskController::class, 'store']);
    Router::post('/task/update', [TaskController::class, 'update']);
    Router::post('/task/delete', [TaskController::class, 'delete']);
    Router::post('/task/update-priority', [TaskController::class, 'updatePriority']);
    Router::post('/task/move-board', [TaskController::class, 'moveBoard']);
    Router::post('/task/update-positions', [TaskController::class, 'updatePositions']);

    // Project Management
    Router::post('/project', [ProjectController::class, 'store']);
    Router::post('/project/update', [ProjectController::class, 'update']);
    Router::post('/project/delete', [ProjectController::class, 'delete']);
    Router::post('project/set-github-project', [ProjectController::class, 'setGitHubProject']);

    // Label
    Router::post("/label/{projectId}", [LabelController::class, 'store']);
    Router::post("/label/update/{projectId}", [LabelController::class, 'update']);
    Router::post("/label/delete/{projectId}", [LabelController::class, 'delete']);

    // Friendship
    Router::post('/friends', [FriendshipController::class, 'store']);
    Router::post('/friends/delete', [FriendshipController::class, 'delete']);
    Router::post('/friends/accept', [FriendshipController::class, 'accept']);
    Router::post('/friends/reject', [FriendshipController::class, 'reject']);

    // User Profile
    Router::post('/user/update', [UserController::class, 'update']);
});
