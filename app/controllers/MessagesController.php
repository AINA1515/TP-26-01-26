<?php

namespace App\Controllers;

use App\Models\Message;

class MessagesController
{
    /**
     * GET /api/messages -> toutes conversations
     */
    public function getAllConversations()
    {
        $currentUserId = 1; // A adapter avec l'authentification
        
        try {
            $message = new Message();
            $conversations = $message->getConversations($currentUserId);
            
            echo json_encode([
                'status' => 'success',
                'data' => $conversations
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * GET /api/messages/@userId -> conversation specifique
     */
    public function getConversation($userId)
    {
        $currentUserId = 1; // A adapter avec l'authentification
        
        
        try {
            $message = new Message();
            $messages = $message->getConversationWith($currentUserId, (int)$userId);
            
            echo json_encode([
                'status' => 'success',
                'data' => $messages
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * POST /api/messages -> envoyer message
     */
    public function sendMessage()
    {
        $currentUserId = 1; // A adapter avec l'authentification
        
        
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (!$data || !isset($data['recipientId']) || !isset($data['content'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Missing required fields: recipientId, content'
                ]);
                return;
            }

            if (empty(trim($data['content']))) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Message content cannot be empty'
                ]);
                return;
            }
            
            $message = new Message();
            $messageId = $message->send(
                $currentUserId,
                (int)$data['recipientId'],
                trim($data['content'])
            );
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Message sent successfully',
                'messageId' => $messageId
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * GET /api/messages/unread -> compteur non lus
     */
    public function getUnreadCount()
    {
        $currentUserId = 1; // A adapter avec l'authentification
        
        
        try {
            $message = new Message();
            $count = $message->getUnreadCount($currentUserId);
            
            echo json_encode([
                'status' => 'success',
                'unreadCount' => $count
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
