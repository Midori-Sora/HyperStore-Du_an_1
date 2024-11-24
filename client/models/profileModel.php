<?php
class ProfileModel extends MainModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "duan1");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getUserInfo($userId)
    {
        try {
            $sql = "SELECT * FROM users WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("Error fetching user info: " . $e->getMessage());
            return false;
        }
    }

    public function updateProfile($data)
    {
        try {
            $sql = "UPDATE users SET 
                    fullname = ?, 
                    phone = ?, 
                    birthday = ?, 
                    gender = ?, 
                    address = ?,
                    avatar = ? 
                    WHERE user_id = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "ssssssi",
                $data['fullname'],
                $data['phone'],
                $data['birthday'],
                $data['gender'],
                $data['address'],
                $data['avatar'],
                $data['user_id']
            );

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Update profile failed: " . $e->getMessage());
            return false;
        }
    }
}
