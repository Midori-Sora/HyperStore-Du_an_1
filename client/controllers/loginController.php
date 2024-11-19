<?php
require_once "client/models/loginModel.php";

class LoginController {
    public static function loginController() {
        // Kiểm tra session trước khi start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password']; 

            // Validate input
            if (empty($email) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ email và mật khẩu';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ';
            } else {
                $loginModel = new LoginModel();
                $user = $loginModel->checkLogin($email, $password);

                if ($user) {
                    // Lưu thông tin vào session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role_name'] = $user['role_name'];

                    // Cập nhật thời gian đăng nhập
                    $loginModel->updateLastLogin($user['user_id']);

                    // Kiểm tra role và chuyển hướng
                    if ($user['role_name'] === 'Admin') {
                        header('Location: admin/index.php'); // Chuyển đến trang admin
                    } else {
                        header('Location: index.php?action=home'); // Chuyển đến trang chủ
                    }
                    exit;
                } else {
                    $error = 'Email hoặc mật khẩu không chính xác';
                }
            }
        }

        require_once "client/views/login.php";
    }

    public static function authController() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once "client/views/login.php";
    }

    public static function logoutController() {
        // Kiểm tra session trước khi start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_destroy(); // Hủy toàn bộ session
        header('Location: index.php?action=home'); // Chuyển về trang chủ
        exit;
    }
}
