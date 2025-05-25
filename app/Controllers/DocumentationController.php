<?php

namespace App\Controllers;

use App\Models\Documentation;
use function Core\view;
use function Core\redirect;

class DocumentationController {
    public static function index($data) {
        $projectId = $data['projectId'] ?? null;
        $page = 'documentation';
        
        // Validate all required parameters
        if (empty($projectId)) {
            return redirect('/', ['error' => "Project ID is required", 'page' => $page]);
        }

        $docs = Documentation::getAllByProjectId($projectId);

        return view('documentation', ['projectId' => $projectId, 'docs' => $docs, 'page' => $page]);
    }

    public static function store(array $data) {
        $title = $_POST["title"] ?? null;
        $content = $_POST["content"] ?? null;
        $projectId = $data["projectId"] ?? null;
        $page = 'documentation';

        // Validate all required parameters
        if (empty($projectId)) {
            return redirect('/documentation', ['error' => "Project ID is required", 'page' => $page]);
        }
        
        if (empty($title)) {
            return redirect('/documentation/' . $projectId, ['error' => "Title is required", 'page' => $page]);
        }
        
        if (empty($content)) {
            return redirect('/documentation/' . $projectId, ['error' => "Content is required", 'page' => $page]);
        }

        $error = self::validateForm($title, $content);

        if ($error) {
            return redirect('/documentation/' . $projectId, ['error' => $error, 'page' => $page]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated", 'page' => $page]);
        }

        $documentationId = Documentation::create($title, $content, $projectId, $userId);

        if ($documentationId) {
            return redirect('/documentation/' . $projectId, ['success' => 'Document created successfully.', 'page' => $page]);
        } else {
            return redirect('/documentation/' . $projectId, ['error' => 'Failed to create document.', 'page' => $page]);
        }
    }

    public static function validateForm($title, $content) {
        $error = [];
        if (empty($title)) {
            $error['title'] = "Title is required";
        }

        if (empty($content)) {
            $error['content'] = "Content is required";
        }

        return !empty($error) ? implode(", ", $error) : null;
    }

    public static function update($data) {
        $id = $data['id'] ?? null;
        $projectId = $data['projectId'] ?? null;
        $title = $_POST["title"] ?? null;
        $content = $_POST["content"] ?? null;
        $page = 'documentation';

        // Validate all required parameters
        if (empty($id)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document ID is required", 'page' => $page]);
        }
        
        if (empty($projectId)) {
            return redirect('/documentation', ['error' => "Project ID is required", 'page' => $page]);
        }
        
        if (empty($title)) {
            return redirect('/documentation/' . $projectId, ['error' => "Title is required", 'page' => $page]);
        }
        
        if (empty($content)) {
            return redirect('/documentation/' . $projectId, ['error' => "Content is required", 'page' => $page]);
        }

        $error = self::validateForm($title, $content);

        if ($error) {
            return redirect('/documentation/' . $projectId, ['error' => $error, 'page' => $page]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated", 'page' => $page]);
        }

        $doc = Documentation::getById($id);

        if (empty($doc)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document not found", 'page' => $page]);
        }

        if ($doc['project_id'] != $projectId) {
            return redirect('/documentation/' . $projectId, ['error' => "Document does not belong to the specified project", 'page' => $page]);
        }

        try {
            Documentation::update($id, $title, $content);
            return redirect('/documentation/' . $projectId, ['success' => 'Document updated successfully.', 'page' => $page]);
        } catch (\Exception $e) {
            return redirect('/documentation/' . $projectId, ['error' => "Failed to update document: " . $e->getMessage(), 'page' => $page]);
        }
    }

    public static function delete($data) {
        $projectId  = $data['projectId'] ?? null;
        $id = $data['id'] ?? null;
        $page = 'documentation';

        // Validate all required parameters
        if (empty($id)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document ID is required", 'page' => $page]);
        }
        
        if (empty($projectId)) {
            return redirect('/documentation', ['error' => "Project ID is required", 'page' => $page]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated", 'page' => $page]);
        }

        $doc = Documentation::getById($id);

        if (empty($doc)) {
            return redirect('/documentation/' . $projectId, ['error' => "Document not found", 'page' => $page]);
        }

        if ($doc['project_id'] != $projectId) {
            return redirect('/documentation/' . $projectId, ['error' => "Document does not belong to the specified project", 'page' => $page]);
        }

        try {
            Documentation::delete($id);
            return redirect('/documentation/' . $projectId, ['success' => 'Document deleted successfully.', 'page' => $page]);
        } catch (\Exception $e) {
            return redirect('/documentation/' . $projectId, ['error' => "Failed to delete document: " . $e->getMessage(), 'page' => $page]);
        }
    }

}