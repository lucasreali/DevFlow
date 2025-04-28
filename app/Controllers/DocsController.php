<?php

namespace App\Controllers;

use App\Models\Documentation;
use function Core\view;
use function Core\redirect;

class DocsController {
    public static function index($data) {
        $projectId = $data['projectId'];

        $docs = Documentation::getAllByProjectId($projectId);

        return view('documentation', ['projectId' => $projectId, 'docs' => $docs]);
    }

    public static function store(array $data) {
        $title = $_POST["title"] ?? '';
        $content = $_POST["content"] ?? '';
        $projectId = $data["projectId"] ?? null;

        $error = self::validateForm($title, $content);

        if ($error) {
            redirect('/documentation/' . $projectId, ['error' => $error]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            redirect('/documentation/' . $projectId, ['error' => "User not authenticated"]);
        }

        $documentationId = Documentation::create($title, $content, $projectId, $userId);

        if ($documentationId) {
            return redirect('/documentation/' . $projectId, ['success' => 'Document created successfully.']);
        } else {
            return redirect('/documentation/' . $projectId, ['error' => 'Failed to create document.']);
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

    public static function view($data) {
        $id = $data['id'];
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$id) {
            return redirect('/documentation/' , ['error' => "Document ID is required"]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!$userId) {
            return view('documentation', ['error' => "User not authenticated"]);
        }

        $doc = Documentation::getById($id);

        if (empty($doc)) {
            return view('documentation', ['error' => "Document not found"]);
        }

        return view('documentation_view', ['doc' => $doc]);
    }

    public static function update($data) {
        $id = $data['id'];;
        $projectId = $data['projectId'];
        $title = $_POST["title"] ?? '';
        $content = $_POST["content"] ?? '';

        if (!$id) {
            return redirect('/documentation/' . $projectId, ['error' => "Document ID is required"]);
        }

        $error = self::validateForm($title, $content);

        if ($error) {
            return redirect('/documentation/' . $projectId, ['error' => $error]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated"]);
        }

        try {
            Documentation::update($id, $title, $content);
            return redirect('/documentation/' . $projectId, ['success' => 'Document updated successfully.']);
        } catch (\Exception $e) {
            return redirect('/documentation/' . $projectId, ['error' => "Failed to update document: " . $e->getMessage()]);
        }
    }

    public static function delete($data) {
        $projectId  = $data['projectId'];
        $id = $data['id'];

        if (!$id) {
            return redirect('/documentation/' . $projectId, ['error' => "Document ID is required"]);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/documentation/' . $projectId, ['error' => "User not authenticated"]);
        }

        try {
            Documentation::delete($id);
            return redirect('/documentation/' . $projectId, ['success' => 'Document deleted successfully.']);
        } catch (\Exception $e) {
            return redirect('/documentation/' . $projectId, ['error' => "Failed to delete document: " . $e->getMessage()]);
        }
    }

}