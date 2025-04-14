<?php
namespace App\Controllers;

use App\Models\Reuniao;

class ReuniaoController {
    public static function store()
    {
        $title = $_POST['title'];
        $date = $_POST['date'];
        $assunto = $_POST['assunto'];
        Reuniao::create($assunto, $date, $title);
        header('Location: /reuniao');
        exit;
    }

    public static function update()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $date = $_POST['date'];
        $assunto = $_POST['assunto'];
        Reuniao::update($id, $assunto, $date, $title);
        header('Location: /reuniao');
        exit;
    }

    public static function edit()
    {
        $id = $_GET['id'];
        $reuniao = Reuniao::find($id);
        $reunioes = Reuniao::all();
        extract(['reuniao' => $reuniao, 'reunioes' => $reunioes]);
        require __DIR__ . '/../Views/reunioes.php';
    }
}
