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
            // Lấy thông tin người dùng hiện tại
            $currentUser = $this->getUserInfo($data['user_id']);
            
            // Giữ lại thông tin cũ nếu không có thông tin mới
            $data['fullname'] = !empty($data['fullname']) ? $data['fullname'] : $currentUser['fullname'];
            $data['phone'] = !empty($data['phone']) ? $data['phone'] : $currentUser['phone'];
            $data['birthday'] = !empty($data['birthday']) ? $data['birthday'] : $currentUser['birthday'];
            $data['gender'] = isset($data['gender']) ? $data['gender'] : $currentUser['gender'];
            $data['address'] = !empty($data['address']) ? $data['address'] : $currentUser['address'];
            $data['avatar'] = !empty($data['avatar']) ? $data['avatar'] : $currentUser['avatar'];

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
