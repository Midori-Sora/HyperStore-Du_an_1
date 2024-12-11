<?php
class LoginModel {
    private $db;

    public function __construct() {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function checkLogin($email, $password) {
        try {
            $sql = "SELECT u.user_id, u.email, u.password, u.fullname, u.role_id, r.role_name 
                    FROM users u 
                    LEFT JOIN roles r ON u.role_id = r.role_id
                    WHERE u.email = :email 
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                if ($password === $result['password']) {
                    unset($result['password']); 
                    return $result;
                }
            }
            return false;
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    public function auth($email, $password) {
        return $this->checkLogin($email, $password);
    }

    public function updateLastLogin($userId) {
        try {
            $sql = "UPDATE users SET last_login = NOW() WHERE user_id = :userId";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Update last login error: " . $e->getMessage());
            return false;
        }
    }

    public function __destruct() {
        if ($this->db) {
            $this->db = null;
        }
    }
}