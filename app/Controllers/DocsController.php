<?php

namespace App\Controllers;
use App\Models\Documentation;
use function Core\view;

class DocsController{
    public static function store(){
        $title = $_POST["title"] ?? '';
        $content = $_POST["content"] ?? '';

        $error = self::validateForm($title,$content);

        if($error)
        {
            return view('documentation', ['error' => $error]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $userId = $_SESSION['user']['id'] ?? null;

        if($userId){
            return view('documentation', ['error' => "User not found: $userId"]);
        }
            
        $projectId = 1;


        if(Documentation::create($title, $content, $projectId, $userId)) {
            return view('documentation', ['success' => 'Document created successfully.']);
        } else {
            throw new \Exception('Failed to create document.');

        }




    }

    public static function validateForm($title, $content)
    {
        $error = [];
        if (empty($title)) {
            $error['title'] = "Title is required";
        }

        if (empty($content)) {
            $error['content'] = "Content is required";
        }

        return !empty($error) ? implode(", ", $error) : null;
    }
}