<?php

namespace App\Controllers\Page;

use App\Models\Friendship;
use App\Models\Project;
use function Core\redirect;
use function Core\view;

class HomeController
{
    public static function index(array $data)
    {
        $user = $_SESSION['user'] ?? null;
        $error = $data['error'] ?? null;

        if (!$user) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        $projects = Project::getAll($user['id']);

        $friends = Friendship::getFriends($user['id']);


        return view('home', [
            'user' => $user,
            'projects' => $projects,
            'friends' => $friends,
            'error' => $error,
        ]);
    }
}