<?php
     namespace App\Models;

     use Core\Database;

     
     class Reuniao{
        public static function create($assunto, $data_reuniao, $title)
        {
            $db = Database::getInstance();
            $stmt = $db->prepare("insert into reunioes (assunto, title, data_reuniao) VALUES(:assunto, :title, :data_reuniao)");
            $stmt->execute([
                'title' => $title,
                'assunto' => $assunto,
                'data_reuniao' => $data_reuniao
            ]);
            return $db->lastInsertId();
        }
    }