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
        $success = $data['success'] ?? null;

        if (!$user) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        $projects = Project::getAll($user['id']);

        $friendsRelenshionship = Friendship::getFriends($user['id']);

        $friends = [];

        foreach ($friendsRelenshionship as &$friend) {
            if ($friend['user_id'] == $user['id']) {
                $friends[] = [
                    'id' => $friend['friend_id'],
                    'name' => $friend['friend_name'],
                    'username' => $friend['friend_username'],
                    'avatar_url' => $friend['friend_avatar'],
                    'status' => $friend['status'],
                    'invited' => false
                ];
            } else {
                $friends[] = [
                    'id' => $friend['user_id'],
                    'name' => $friend['user_name'],
                    'username' => $friend['user_username'],
                    'avatar_url' => $friend['user_avatar'],
                    'status' => $friend['status'],
                    'invited' => true
                ];
            }
        }


        return view('home', [
            'user' => $user,
            'projects' => $projects,
            'friends' => $friends,
            'error' => $error,
            'success' => $success,
        ]);
    }
}