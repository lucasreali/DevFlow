<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\Friendship;
use function Core\redirect;

class FriendshipController
{
    public static function store($data) {
        $userId = $_SESSION['user']['id'] ?? null;
        $friendIdentifier = $data['friend_identifier'] ?? null;

        if ($friendIdentifier == $_SESSION['user']['username'] || $friendIdentifier == $_SESSION['user']['email']) {
            return redirect('/', ['error' => 'You cannot add yourself as a friend.']);
        }

        if (empty($friendIdentifier)) {
            return redirect('/', ['error' => 'Friend identifier is required.']);
        }

        try {
            $friendAccount = Account::findByUsername($friendIdentifier) ?? Account::findByEmail($friendIdentifier);

            if (!$friendAccount) {
                return redirect('/', ['error' => 'Friend not found.']);
            }

            $friendId = $friendAccount['user_id'];

            $friendship = Friendship::checkFriendship($userId, $friendId);
            if ($friendship && $friendship['status'] === 'pending') {
                return redirect('/', ['error' => 'Friend request already sent.']);
            }

            if ($friendship && $friendship['status'] === 'accepted') {
                return redirect('/', ['error' => 'You are already friends with this user.']);
            }

            if ($friendship && $friendship['status'] === 'rejected') {
                return redirect('/', ['error' => 'Friend request was rejected.']);
            }
            Friendship::create($userId, $friendId);
            return redirect('/', ['success' => 'Friend request sent successfully.']);

        } catch (\Exception $e) {
            return redirect('/', ['error' => 'An error occurred while sending the friend request.']);
        }
    }

    public static function delete($data) {
        $friendId = $data['friend_id'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;

        if (empty($friendId) || empty($userId)) {
            return redirect('/', ['error' => 'Friend ID is required.']);
        }
        try {
            $friendship = Friendship::checkFriendship($userId, $friendId);
            if (!$friendship) {
                return redirect('/', ['error' => 'Friendship not found.']);
            }

            Friendship::delete($userId, $friendId);
            return redirect('/', ['success' => 'Friend removed successfully.']);

        } catch (\Exception $e) {
            return redirect('/', ['error' => 'An error occurred while removing the friend.']);
        }        
    }

    public static function accept($data) {
        $friendId = $data['friend_id'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;

        if (empty($friendId) || empty($userId)) {
            return redirect('/', ['error' => 'Friend ID is required.']);
        }

        try {
            $friendship = Friendship::checkFriendship($userId, $friendId);
            if (!$friendship) {
                return redirect('/', ['error' => 'Friendship not found.']);
            }

            Friendship::changeStatus($userId, $friendId, 'accepted');
            return redirect('/', ['success' => 'Friend request accepted successfully.']);

        } catch (\Exception $e) {
            return redirect('/', ['error' => 'An error occurred while accepting the friend request.']);
        }
    }

    public static function reject($data) {
        $friendId = $data['friend_id'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;

        if (empty($friendId) || empty($userId)) {
            return redirect('/', ['error' => 'Friend ID is required.']);
        }

        try {
            $friendship = Friendship::checkFriendship($userId, $friendId);
            if (!$friendship) {
                return redirect('/', ['error' => 'Friendship not found.']);
            }

            Friendship::changeStatus($userId, $friendId, 'rejected');
            return redirect('/', ['success' => 'Friend request rejected successfully.']);

        } catch (\Exception $e) {
            return redirect('/', ['error' => 'An error occurred while rejecting the friend request.']);
        }
    }
}