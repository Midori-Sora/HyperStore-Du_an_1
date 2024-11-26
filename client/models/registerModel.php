<?php
require_once "client/controllers/registerController.php";

class RegisterModel 
{
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "duan1");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
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

    public function register($data) {
        try {
            $sql = "INSERT INTO users (
                username, email, password, fullname, phone, 
                address, birthday, gender, role_id, status, avatar
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->conn->prepare($sql);
            $roleId = 2; // User role
            $status = 1; // Active status
            $defaultAvatar = 'Uploads/User/nam.jpg';
            
            $stmt->bind_param(
                "sssssssiiis",
                $data['username'],
                $data['email'],
                $data['password'],
                $data['fullname'],
                $data['phone'],
                $data['address'],
                $data['birthday'],
                $data['gender'],
                $roleId,
                $status,
                $defaultAvatar
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error in register: " . $e->getMessage());
            return false;
        }
    }
}
