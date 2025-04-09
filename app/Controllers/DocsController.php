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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $userId = $_SESSION['user']['id'] ?? null;
            $docs = $userId ? Documentation::getAll($userId) : [];
            return view('documentation', ['error' => $error, 'docs' => $docs]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        $userId = $_SESSION['user']['id'] ?? null;

        if(!$userId){
            return view('documentation', ['error' => "User not found: $userId"]);
        }
            
        $projectId = 1;


        if(Documentation::create($title, $content, $projectId, $userId)) {
            $docs = Documentation::getAll($userId);
            return view('documentation', ['success' => 'Document created successfully.', 'docs' => $docs]);
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


    public static function showDocs()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if(!$userId){
            return view('documentation', ['error' => "User not authenticated", 'docs' => []]);
        }

        $docs = Documentation::getAll($userId);

        return view('documentation', ['docs' => $docs]);
    }

    public static function viewDoc()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            return view('documentation', ['error' => "Document ID is required"]);
        }
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;
        
        if(!$userId) {
            return view('documentation', ['error' => "User not authenticated"]);
        }
        
        $doc = Documentation::getById($id);
        
        if (empty($doc)) {
            return view('documentation', ['error' => "Document not found"]);
        }
        
        return view('documentation_view', ['doc' => $doc[0]]);
    }

    public static function editForm()
    {
        $id = $_GET["id"] ?? null;

        if (!$id) {
            return view('documentation', ['error' => "Document ID is required"]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;
        
        if(!$userId) {
            return view('documentation', ['error' => "User not authenticated"]);
        }
        
        $doc = Documentation::getById($id);
        
        if (empty($doc)) {
            return view('documentation', ['error' => "Document not found"]);
        }
        
        return view('documentation_edit', ['doc' => $doc[0]]);
    }

    public static function updateDoc()
    {

        $id = $_GET['id'] ?? null;

        if (!$id) {
            return view('documentation', ['error' => "Document ID is required"]);
        }

        $title = $_POST["title"] ?? '';
        $content = $_POST["content"] ?? '';

        $error = self::validateForm($title, $content);

        if($error) {
            return view('documentation_edit', ['error' => $error, 'doc' => ['id' => $id, 'title' => $title, 'content' => $content]]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if(!$userId) {
            return view('documentation', ['error' => "User not authenticated"]);
        }
            
        $projectId = 1; // This should be dynamically set based on your app's context

        try {
            Documentation::update($id, $title, $content);
            return self::showDocs();
        } catch (\Exception $e) {
            return view('documentation_edit', ['error' => "Failed to update document: " . $e->getMessage()]);
        }
    }

    public static function deleteDoc()
    {
        $id = $_GET["id"] ?? null;
        if (!$id) {
            return view('documentation', ['error' => "Document ID is required"]);
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;
        
        if(!$userId) {
            return view('documentation', ['error' => "User not authenticated"]);
        }
        
        try {
            Documentation::delete($id);
            return self::showDocs();
        } catch (\Exception $e) {
            return view('documentation', ['error' => "Failed to delete document: " . $e->getMessage()]);
        }
    }
}