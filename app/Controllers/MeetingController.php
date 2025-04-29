<?php
namespace App\Controllers;

use App\Models\Meeting;
use App\Models\Project;
use function Core\view;

class MeetingController {
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            header('Location: /login');
            exit;
        }
        
        $meetings = Meeting::getAllByUserId($userId);
        $projects = Project::getAll($userId);
        
        return view('meetings', [
            'meetings' => $meetings,
            'projects' => $projects
        ]);
    }

    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            header('Location: /login');
            exit;
        }
        
        $title = $_POST['title'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $meetingDate = $_POST['meeting_date'] ?? '';
        $projectId = $_POST['project_id'] ?? null;
        
        if (empty($title) || empty($subject) || empty($meetingDate) || empty($projectId)) {
            // Return with error
            header('Location: /meetings?error=All fields are required');
            exit;
        }
        
        $meetingId = Meeting::create($title, $subject, $meetingDate, $projectId, $userId);
        
        if ($meetingId) {
            header('Location: /meetings?success=Meeting created successfully');
        } else {
            header('Location: /meetings?error=Failed to create meeting');
        }
        exit;
    }

    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            header('Location: /login');
            exit;
        }
        
        $id = $_POST['id'] ?? null;
        $title = $_POST['title'] ?? '';
        $subject = $_POST['subject'] ?? '';
        $meetingDate = $_POST['meeting_date'] ?? '';
        
        if (empty($id) || empty($title) || empty($subject) || empty($meetingDate)) {
            // Return with error
            header('Location: /meetings?error=All fields are required');
            exit;
        }
        
        $result = Meeting::update($id, $title, $subject, $meetingDate);
        
        if ($result) {
            header('Location: /meetings?success=Meeting updated successfully');
        } else {
            header('Location: /meetings?error=Failed to update meeting');
        }
        exit;
    }

    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            header('Location: /login');
            exit;
        }
        
        $id = $_POST['id'] ?? null;
        
        if (empty($id)) {
            header('Location: /meetings?error=Meeting ID is required');
            exit;
        }
        
        $result = Meeting::delete($id);
        
        if ($result) {
            header('Location: /meetings?success=Meeting deleted successfully');
        } else {
            header('Location: /meetings?error=Failed to delete meeting');
        }
        exit;
    }
}
