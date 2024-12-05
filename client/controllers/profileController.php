<?php
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
                'address' => trim($_POST['address'] ?? ''),
                'avatar' => null // Initialize avatar
            ];

            // Kiểm tra dữ liệu
            if (empty($data['fullname']) && empty($_FILES['avatar']['name'])) {
                throw new Exception("Vui lòng nhập họ tên hoặc chọn ảnh đại diện");
            }

            // Kiểm tra số điện thoại
            if (!empty($data['phone']) && !preg_match('/^[0-9]{10}$/', $data['phone'])) {
                throw new Exception("Số điện thoại không hợp lệ");
            }

            // Kiểm tra giới tính
            if (!is_null($data['gender']) && !in_array($data['gender'], [0, 1])) {
                throw new Exception("Giới tính không hợp lệ");
            }

            // Kiểm tra ngày sinh
            if (!empty($data['birthday']) && !DateTime::createFromFormat('Y-m-d', $data['birthday'])) {
                throw new Exception("Ngày sinh không hợp lệ");
            }

            // Handle avatar upload
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
                $avatarPath = '/' . basename($_FILES['avatar']['name']);
                // Kiểm tra xem thư mục có tồn tại không, nếu không thì tạo nó
                if (!is_dir(PATH_ROOT . '/')) {
                    mkdir(PATH_ROOT . '/', 0777, true);
                }
                if (move_uploaded_file($_FILES['avatar']['tmp_name'], PATH_ROOT . '/' . $avatarPath)) {
                    $data['avatar'] = $avatarPath; // Set the avatar path
                } else {
                    throw new Exception("Lỗi khi tải lên ảnh đại diện");
                }
            } else {
                // Nếu không có ảnh mới, giữ nguyên ảnh cũ
                $user = (new ProfileModel())->getUserInfo($data['user_id']);
                $data['avatar'] = $user['avatar'] ?? null; // Giữ nguyên ảnh cũ, kiểm tra null
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
