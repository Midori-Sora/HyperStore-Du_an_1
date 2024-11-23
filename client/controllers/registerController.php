<?php
require_once "client/models/registerModel.php";

class RegisterController {
    public static function registerController() {
        require_once "client/views/authentication/register.php";
    }

    public static function registerProcessController() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirmPassword = trim($_POST['confirm_password']);
            $fullname = trim($_POST['fullname']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);

            // Validate input
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin bắt buộc";
                header("Location: index.php?action=register");
                exit;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Mật khẩu xác nhận không khớp";
                header("Location: index.php?action=register");
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email không hợp lệ";
                header("Location: index.php?action=register");
                exit;
            }

            if (!empty($phone) && !preg_match("/^[0-9]{10}$/", $phone)) {
                $_SESSION['error'] = "Số điện thoại không hợp lệ";
                header("Location: index.php?action=register");
                exit;
            }

            $registerModel = new RegisterModel();

            // Kiểm tra email đã tồn tại
            if ($registerModel->checkEmailExists($email)) {
                $_SESSION['error'] = "Email đã được sử dụng";
                header("Location: index.php?action=register");
                exit;
            }

            // Kiểm tra username đã tồn tại
            if ($registerModel->checkUsernameExists($username)) {
                $_SESSION['error'] = "Tên đăng nhập đã tồn tại";
                header("Location: index.php?action=register");
                exit;
            }

            // Thực hiện đăng ký (store password as plain text)
            if ($registerModel->register($username, $email, $password, $fullname, $phone, $address)) {
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
