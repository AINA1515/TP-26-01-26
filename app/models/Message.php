<?php

namespace App\Models;

use PDO;
use Flight;

class Message
{
    private $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    /**
     * Get all conversations for a user
     * Returns list of users with whom the user has exchanged messages
     */
    public function getConversations($userId)
    {
        $query = "
            SELECT 
                CASE 
                    WHEN from_user_id = :userId THEN to_user_id
                    ELSE from_user_id
                END as contact_id,
                CASE 
                    WHEN from_user_id = :userId THEN to_username
                    ELSE from_username
                END as username,
                CASE 
                    WHEN from_user_id = :userId THEN to_photo
                    ELSE from_photo
                END as photoProfil,
                CASE 
                    WHEN from_user_id = :userId THEN to_online
                    ELSE from_online
                END as is_online,
                last_message,
                last_message_time,
                CASE 
                    WHEN to_user_id = :userId AND is_read = 0 THEN 1
                    ELSE 0
                END as has_unread
            FROM vw_conversation_list
            WHERE from_user_id = :userId OR to_user_id = :userId
            ORDER BY last_message_time DESC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Group and count unread messages
        $conversations = [];
        $seen = [];
        
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $contactId = $row['contact_id'];
            if (!isset($seen[$contactId])) {
                $seen[$contactId] = true;
                // Count unread messages
                $unreadQuery = "SELECT COUNT(*) as count FROM messages 
                               WHERE from_user_id = :contactId AND to_user_id = :userId AND is_read = 0";
                $unreadStmt = $this->db->prepare($unreadQuery);
                $unreadStmt->bindValue(':contactId', $contactId, PDO::PARAM_INT);
                $unreadStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
                $unreadStmt->execute();
                $unreadResult = $unreadStmt->fetch(PDO::FETCH_ASSOC);
                
                $row['unread_count'] = (int)$unreadResult['count'];
                unset($row['has_unread']);
                $conversations[] = $row;
            }
        }
        
        return $conversations;
    }

    /**
     * Get conversation between two users
     */
    public function getConversationWith($currentUserId, $otherUserId)
    {
        $query = "
            SELECT * FROM vw_messages_with_users
            WHERE (from_user_id = :currentUserId AND to_user_id = :otherUserId)
               OR (from_user_id = :otherUserId AND to_user_id = :currentUserId)
            ORDER BY created_at ASC
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':currentUserId', $currentUserId, PDO::PARAM_INT);
        $stmt->bindValue(':otherUserId', $otherUserId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Send a message
     */
    public function send($senderId, $recipientId, $content)
    {
        $query = "
            INSERT INTO messages (from_user_id, to_user_id, message_text, is_read)
            VALUES (:senderId, :recipientId, :content, 0)
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':senderId', $senderId, PDO::PARAM_INT);
        $stmt->bindValue(':recipientId', $recipientId, PDO::PARAM_INT);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
        
        return $this->db->lastInsertId();
    }

    /**
     * Mark a message as read
     */
    public function markAsRead($messageId, $userId)
    {
        $query = "
            UPDATE messages 
            SET is_read = 1
            WHERE id = :messageId AND to_user_id = :userId
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':messageId', $messageId, PDO::PARAM_INT);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Get unread message count for a user
     */
    public function getUnreadCount($userId)
    {
        $query = "
            SELECT COUNT(*) as count FROM messages
            WHERE to_user_id = :userId AND is_read = 0
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int)$result['count'];
    }

    /**
     * Mark all messages in a conversation as read
     */
    public function markConversationAsRead($currentUserId, $otherUserId)
    {
        $query = "
            UPDATE messages
            SET is_read = 1
            WHERE from_user_id = :otherUserId AND to_user_id = :currentUserId
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':otherUserId', $otherUserId, PDO::PARAM_INT);
        $stmt->bindValue(':currentUserId', $currentUserId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
