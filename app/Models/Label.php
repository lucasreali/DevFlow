<?php

namespace App\Models;

use Core\Database;

class Label {
    public static function create($userId , $title , $color) {

        $db = Database::getInstance();

        $stmt = $db->prepare('
        INSERT INTO labels (userid, title, color)
        VALUES (:id, :title, :color)
    ');
    $stmt->execute([
        'id' => $userId,
        'name' => $title,
        'color' => $color,
    ]);
    }

    return $db->lastInsertId();

}

?>