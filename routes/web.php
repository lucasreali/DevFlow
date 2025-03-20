<?php

use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;
use Core\Router;
use function Core\view;

Router::get('/auth/login', [AuthController::class, 'login']);

Router::get('/auth/logout', [AuthController::class, 'logout']);

Router::get('/', function() {
    return view('home', ['title' => 'Home']);
});

Router::get('/dashboard', function() {
    AuthMiddleware::handle();
    return view('dashboard', ['title' => 'Dashboard']);
});


