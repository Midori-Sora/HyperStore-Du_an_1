<?php
require_once "client/models/profileModel.php";

class ProfileController
{
    public static function profileController()
    {
        try {
            // Kiểm tra đăng nhập
            if (!isset($_SESSION['user_id'])) {
                header('Location: ?action=login');
                exit;
            }

            $userId = $_SESSION['user_id'];
            $profileModel = new ProfileModel();
            $user = $profileModel->getUserInfo($userId);

            if (!$user) {
                throw new Exception("Không tìm thấy thông tin người dùng");
            }

            require_once "client/views/profile/profile.php";
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php');
            exit;
        }
    }

    public static function updateProfileController()
    {
        try {
            // Kiểm tra đăng nhập
            if (!isset($_SESSION['user_id'])) {
                header('Location: ?action=login');
                exit;
            }

            // Kiểm tra phương thức request
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Phương thức không hợp lệ");
            }

            // Validate dữ liệu
            $data = [
                'user_id' => $_SESSION['user_id'],
                'fullname' => trim($_POST['fullname'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'birthday' => $_POST['birthday'] ?? null,
                'gender' => $_POST['gender'] ?? null,
                'address' => trim($_POST['address'] ?? '')
            ];

            // Kiểm tra dữ liệu
            if (empty($data['fullname'])) {
                throw new Exception("Vui lòng nhập họ tên");
            }

            if (!empty($data['phone']) && !preg_match('/^[0-9]{10}$/', $data['phone'])) {
                throw new Exception("Số điện thoại không hợp lệ");
            }

            // Thực hiện cập nhật
            $profileModel = new ProfileModel();
            if ($profileModel->updateProfile($data)) {
                $_SESSION['success'] = "Cập nhật thông tin thành công";
            } else {
                throw new Exception("Cập nhật thông tin thất bại");
            }

            header('Location: ?action=profile');
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ?action=profile');
            exit;
        }
    }
}
?>