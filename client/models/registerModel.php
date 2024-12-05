<?php
require_once "client/controllers/registerController.php";

class RegisterModel 
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function checkEmailExists($email)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Error in checkEmailExists: " . $e->getMessage());
            return false;
        }
    }

    public function checkUsernameExists($username)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM users WHERE username = :username";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':username' => $username]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Error in checkUsernameExists: " . $e->getMessage());
            return false;
        }
    }

    public function register($data)
    {
        try {
            $sql = "INSERT INTO users (
                username, email, password, fullname, phone, 
                address, birthday, gender, role_id, status, avatar
            ) VALUES (
                :username, :email, :password, :fullname, :phone,
                :address, :birthday, :gender, :role_id, :status, :avatar
            )";
            
            $roleId = 2; // User role
            $status = 1; // Active status
            $defaultAvatar = 'Uploads/User/nam.jpg';
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':username' => $data['username'],
                ':email' => $data['email'],
                ':password' => $data['password'],
                ':fullname' => $data['fullname'],
                ':phone' => $data['phone'],
                ':address' => $data['address'],
                ':birthday' => $data['birthday'],
                ':gender' => $data['gender'],
                ':role_id' => $roleId,
                ':status' => $status,
                ':avatar' => $defaultAvatar
            ]);
        } catch (PDOException $e) {
            error_log("Error in register: " . $e->getMessage());
            return false;
        }
    }
}
