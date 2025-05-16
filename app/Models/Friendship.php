<?php

namespace App\Models;

use Core\Database;

class Friendship
{
    public static function create($userId, $friendId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("INSERT INTO friendships (user_id, friend_id) VALUES (:userId, :friendId)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':friendId', $friendId);
        $stmt->execute();

        return true;
    }

    public static function getFriends($userId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT * FROM friendships WHERE user_id = :userId OR friend_id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function checkFriendship($userId, $friendId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT * FROM friendships WHERE user_id = :userId AND friend_id = :friendId");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':friendId', $friendId);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function changeStatus($userId, $friendId, $status)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("UPDATE friendships SET status = :status WHERE user_id = :userId AND friend_id = :friendId");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':friendId', $friendId);
        $stmt->execute();

        return true;
    }
}