<?php
namespace App\Models;

use Core\Database;

class Meeting {
    public static function create($title, $subject, $meetingDate, $projectId, $creatorId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO meetings (title, subject, meeting_date, project_id)
            VALUES (:title, :subject, :meeting_date, :project_id)
        ");
        $stmt->execute([
            'title' => $title,
            'subject' => $subject,
            'meeting_date' => $meetingDate,
            'project_id' => $projectId
        ]);
        
        $meetingId = $db->lastInsertId();
        
        // Add the creator as a participant
        if ($meetingId) {
            self::addParticipant($meetingId, $creatorId);
        }
        
        return $meetingId;
    }

    public static function update($id, $title, $subject, $meetingDate)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            UPDATE meetings 
            SET title = :title, subject = :subject, meeting_date = :meeting_date 
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'subject' => $subject,
            'meeting_date' => $meetingDate
        ]);
    }

    public static function find($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM meetings WHERE id = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function all()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM meetings ORDER BY meeting_date");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public static function getAllByUserId($userId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT m.* 
            FROM meetings m
            INNER JOIN meeting_participants mp ON m.id = mp.meeting_id
            WHERE mp.participant_id = :user_id
            ORDER BY m.meeting_date
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public static function getAllByProjectId($projectId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM meetings 
            WHERE project_id = :project_id
            ORDER BY meeting_date
        ");
        $stmt->execute(['project_id' => $projectId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function delete($id)
    {
        $db = Database::getInstance();
        
        // First delete all participants
        $participantsStmt = $db->prepare("DELETE FROM meeting_participants WHERE meeting_id = :id");
        $participantsStmt->execute(['id' => $id]);
        
        // Then delete the meeting
        $stmt = $db->prepare("DELETE FROM meetings WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    // Methods for managing participants
    public static function addParticipant($meetingId, $userId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO meeting_participants (meeting_id, participant_id)
            VALUES (:meeting_id, :participant_id)
        ");
        return $stmt->execute([
            'meeting_id' => $meetingId,
            'participant_id' => $userId
        ]);
    }
    
    public static function removeParticipant($meetingId, $userId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            DELETE FROM meeting_participants 
            WHERE meeting_id = :meeting_id AND participant_id = :participant_id
        ");
        return $stmt->execute([
            'meeting_id' => $meetingId,
            'participant_id' => $userId
        ]);
    }
    
    public static function getParticipants($meetingId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT u.* 
            FROM users u
            INNER JOIN meeting_participants mp ON u.id = mp.participant_id
            WHERE mp.meeting_id = :meeting_id
        ");
        $stmt->execute(['meeting_id' => $meetingId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
