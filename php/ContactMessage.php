<?php
/**
 * Contact Message Handler for VieGrand
 * 
 * This class handles storing and retrieving contact messages from the database
 */

require_once 'config.php';

class ContactMessage {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::connect();
    }
    
    /**
     * Save a new contact message to the database
     * @param array $data Message data
     * @return array Response with status and message
     */
    public function saveMessage($data) {
        try {
            // Validate required fields
            $required = ['full_name', 'email', 'subject', 'message'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    return [
                        'success' => false,
                        'message' => "Trường {$field} là bắt buộc."
                    ];
                }
            }
            
            // Validate email format
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return [
                    'success' => false,
                    'message' => 'Địa chỉ email không hợp lệ.'
                ];
            }
            
            // Validate message length
            if (strlen($data['message']) > AppConfig::$maxMessageLength) {
                return [
                    'success' => false,
                    'message' => 'Tin nhắn quá dài. Tối đa ' . AppConfig::$maxMessageLength . ' ký tự.'
                ];
            }
            
            // Validate phone number if provided
            if (!empty($data['phone'])) {
                if (!preg_match('/^[\+]?[0-9\s\-\(\)]{10,}$/', $data['phone'])) {
                    return [
                        'success' => false,
                        'message' => 'Số điện thoại không hợp lệ.'
                    ];
                }
            }
            
            // Check rate limiting
            if (!$this->checkRateLimit($_SERVER['REMOTE_ADDR'])) {
                return [
                    'success' => false,
                    'message' => 'Bạn đã gửi quá nhiều tin nhắn. Vui lòng thử lại sau.'
                ];
            }
            
            // Sanitize data
            $sanitizedData = [
                'full_name' => $this->sanitizeInput($data['full_name']),
                'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
                'phone' => !empty($data['phone']) ? $this->sanitizeInput($data['phone']) : null,
                'subject' => $this->sanitizeInput($data['subject']),
                'message' => $this->sanitizeInput($data['message']),
                'status' => 'unread'
            ];
            
            // Insert into database
            $sql = "INSERT INTO contact_messages (full_name, email, phone, subject, message, status, created_at) 
                    VALUES (:full_name, :email, :phone, :subject, :message, :status, NOW())";
            
            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($sanitizedData);
            
            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.',
                    'id' => $this->pdo->lastInsertId()
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại.'
                ];
            }
            
        } catch (PDOException $e) {
            error_log("Database error in ContactMessage::saveMessage: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Có lỗi hệ thống. Vui lòng thử lại sau.'
            ];
        } catch (Exception $e) {
            error_log("General error in ContactMessage::saveMessage: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Có lỗi xảy ra. Vui lòng thử lại.'
            ];
        }
    }
    
    /**
     * Get all messages (for admin panel)
     * @param string $status Filter by status
     * @param int $limit Number of messages to return
     * @param int $offset Offset for pagination
     * @return array
     */
    public function getMessages($status = null, $limit = 50, $offset = 0) {
        try {
            $sql = "SELECT * FROM contact_messages";
            $params = [];
            
            if ($status) {
                $sql .= " WHERE status = :status";
                $params['status'] = $status;
            }
            
            $sql .= " ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
            
            $stmt = $this->pdo->prepare($sql);
            
            // Bind parameters
            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            error_log("Database error in ContactMessage::getMessages: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Update message status
     * @param int $id Message ID
     * @param string $status New status
     * @return bool
     */
    public function updateStatus($id, $status) {
        try {
            $validStatuses = ['unread', 'read', 'archived'];
            if (!in_array($status, $validStatuses)) {
                return false;
            }
            
            $sql = "UPDATE contact_messages SET status = :status WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute([
                'status' => $status,
                'id' => $id
            ]);
            
        } catch (PDOException $e) {
            error_log("Database error in ContactMessage::updateStatus: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get message count by status
     * @return array
     */
    public function getMessageCount() {
        try {
            $sql = "SELECT status, COUNT(*) as count FROM contact_messages GROUP BY status";
            $stmt = $this->pdo->query($sql);
            
            $counts = ['unread' => 0, 'read' => 0, 'archived' => 0];
            while ($row = $stmt->fetch()) {
                $counts[$row['status']] = $row['count'];
            }
            
            return $counts;
            
        } catch (PDOException $e) {
            error_log("Database error in ContactMessage::getMessageCount: " . $e->getMessage());
            return ['unread' => 0, 'read' => 0, 'archived' => 0];
        }
    }
    
    /**
     * Check rate limiting for IP address
     * @param string $ip IP address
     * @return bool
     */
    private function checkRateLimit($ip) {
        try {
            $sql = "SELECT COUNT(*) as count FROM contact_messages 
                    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
            
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetch();
            
            return $result['count'] < AppConfig::$maxMessagesPerHour;
            
        } catch (PDOException $e) {
            error_log("Database error in ContactMessage::checkRateLimit: " . $e->getMessage());
            return true; // Allow if we can't check
        }
    }
    
    /**
     * Sanitize input data
     * @param string $input
     * @return string
     */
    private function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Delete a message
     * @param int $id Message ID
     * @return bool
     */
    public function deleteMessage($id) {
        try {
            $sql = "DELETE FROM contact_messages WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute(['id' => $id]);
            
        } catch (PDOException $e) {
            error_log("Database error in ContactMessage::deleteMessage: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get a specific message by ID
     * @param int $id Message ID
     * @return array|null
     */
    public function getMessage($id) {
        try {
            $sql = "SELECT * FROM contact_messages WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            error_log("Database error in ContactMessage::getMessage: " . $e->getMessage());
            return null;
        }
    }
}
?>
