<?php
require_once "client/controllers/registerController.php";

class RegisterModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function checkEmailExists($email) {
        try {
            $sql = "SELECT COUNT(*) as count FROM users WHERE email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log("Error in checkEmailExists: " . $e->getMessage());
            return false;
        }
    }

    public function checkUsernameExists($username) {
        try {
            $sql = "SELECT COUNT(*) as count FROM users WHERE username = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log("Error in checkUsernameExists: " . $e->getMessage());
            return false;
        }
    }

    public function register($username, $email, $password, $fullname = null, $phone = null, $address = null) {
        try {
            $sql = "INSERT INTO users (username, email, password, fullname, phone, address, role_id) 
                    VALUES (?, ?, ?, ?, ?, ?, 2)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssssss", $username, $email, $password, $fullname, $phone, $address);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error in register: " . $e->getMessage());
            return false;
        }
    }
}
