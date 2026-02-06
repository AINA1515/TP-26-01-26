use siteTemplate;

DROP VIEW IF EXISTS vw_messages_with_users;
CREATE VIEW vw_messages_with_users AS
SELECT 
    m.id,
    m.from_user_id,
    m.to_user_id,
    m.message_text,
    m.is_read,
    m.created_at,
    u_sender.username as sender_name,
    u_sender.photoProfil as sender_photo,
    u_recipient.username as recipient_name,
    u_recipient.photoProfil as recipient_photo
FROM messages m
JOIN users u_sender ON m.from_user_id = u_sender.id
JOIN users u_recipient ON m.to_user_id = u_recipient.id;

DROP VIEW IF EXISTS vw_conversation_list;
CREATE VIEW vw_conversation_list AS
SELECT 
    m.from_user_id,
    m.to_user_id,
    m.message_text as last_message,
    m.created_at as last_message_time,
    m.is_read,
    u_from.username as from_username,
    u_from.photoProfil as from_photo,
    u_to.username as to_username,
    u_to.photoProfil as to_photo
FROM messages m
JOIN users u_from ON m.from_user_id = u_from.id
JOIN users u_to ON m.to_user_id = u_to.id
WHERE m.created_at = (
    SELECT MAX(m2.created_at)
    FROM messages m2
    WHERE (m2.from_user_id = m.from_user_id AND m2.to_user_id = m.to_user_id)
       OR (m2.from_user_id = m.to_user_id AND m2.to_user_id = m.from_user_id)
);
