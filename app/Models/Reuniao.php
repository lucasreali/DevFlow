<?php
namespace App\Models;

use Core\Database;

class Reuniao {
    public static function create($assunto, $data_reuniao, $title)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO meetings (assunto, title, data_reuniao) VALUES (:assunto, :title, :data_reuniao)");
        $stmt->execute([
            'title' => $title,
            'assunto' => $assunto,
            'data_reuniao' => $data_reuniao
        ]);
        return $db->lastInsertId();
    }

    public static function update($id, $assunto, $data_reuniao, $title): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE meetings SET assunto = :assunto, title = :title, data_reuniao = :data_reuniao WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'assunto' => $assunto,
            'title' => $title,
            'data_reuniao' => $data_reuniao
        ]);
    }

    public static function find($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM meetings WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM meetings");
        return $stmt->fetchAll();
    }

    public static function delete($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM meetings WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

}
