<?php
     namespace App\Controllers;

     use App\Models\Reuniao;
     class ReuniaoController{
        public static function store()
        {
            $title = $_POST['title'];
            $date = $_POST['date'];
            $assunto = $_POST['assunto'];
            Reuniao::create($assunto, $date, $title);
        }
}