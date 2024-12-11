<?php
class RegisterController {
    public static function registerController() {
        require_once "client/views/authentication/register.php";
    }

    public static function registerProcessController() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = [
                'username' => trim($_POST['username']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'fullname' => trim($_POST['fullname']),
                'phone' => trim($_POST['phone']),
                'birthday' => trim($_POST['birthday']),
                'gender' => isset($_POST['gender']) ? $_POST['gender'] : '',
                'address' => trim($_POST['address'])
            ];

            foreach ($data as $key => $value) {
                if (empty($value) && $key != 'avatar') {
                    $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin bắt buộc";
                    header("Location: index.php?action=register");
                    exit;
                }
            }

            if ($data['password'] !== $data['confirm_password']) {
                $_SESSION['error'] = "Mật khẩu xác nhận không khớp";
                header("Location: index.php?action=register");
                exit;
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email không hợp lệ";
                header("Location: index.php?action=register");
                exit;
            }

            if (!preg_match("/^[0-9]{10}$/", $data['phone'])) {
                $_SESSION['error'] = "Số điện thoại không hợp lệ";
                header("Location: index.php?action=register");
                exit;
            }

            $birthday = DateTime::createFromFormat('Y-m-d', $data['birthday']);
            $minAge = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('-100 years')));
            $maxAge = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime('-10 years')));
            
            if (!$birthday || $birthday > $maxAge || $birthday < $minAge) {
                $_SESSION['error'] = "Ngày sinh không hợp lệ";
                header("Location: index.php?action=register");
                exit;
            }

            if (!in_array($data['gender'], ['0', '1'])) {
                $_SESSION['error'] = "Giới tính không hợp lệ";
                header("Location: index.php?action=register");
                exit;
            }

            $registerModel = new RegisterModel();

            if ($registerModel->checkEmailExists($data['email'])) {
                $_SESSION['error'] = "Email đã được sử dụng";
                header("Location: index.php?action=register");
                exit;
            }

            if ($registerModel->checkUsernameExists($data['username'])) {
                $_SESSION['error'] = "Tên đăng nhập đã tồn tại";
                header("Location: index.php?action=register");
                exit;
            }

            if ($registerModel->register($data)) {
                $_SESSION['success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header("Location: index.php?action=login");
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại";
                header("Location: index.php?action=register");
                exit;
            }
        }
    }
}
