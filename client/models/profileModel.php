<?php
class ProfileModel extends MainModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getUserInfo($userId)
    {
        try {
            $sql = "SELECT * FROM users WHERE user_id = :userId";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':userId' => $userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
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
                    fullname = :fullname, 
                    phone = :phone, 
                    birthday = :birthday, 
                    gender = :gender, 
                    address = :address,
                    avatar = :avatar 
                    WHERE user_id = :user_id";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':fullname' => $data['fullname'],
                ':phone' => $data['phone'],
                ':birthday' => $data['birthday'],
                ':gender' => $data['gender'],
                ':address' => $data['address'],
                ':avatar' => $data['avatar'],
                ':user_id' => $data['user_id']
            ]);
        } catch (PDOException $e) {
            error_log("Update profile failed: " . $e->getMessage());
            return false;
        }
    }
}
