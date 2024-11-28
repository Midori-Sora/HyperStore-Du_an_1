<?php
class LoginController {
    public static function loginController() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (empty($email) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ email và mật khẩu';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ';
            } else {
                $loginModel = new LoginModel();
                $user = $loginModel->checkLogin($email, $password);

                if ($user && $user['status'] == 1) {
                    // Lưu thông tin user vào session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role_id'] = $user['role_id'];
                    $_SESSION['role_name'] = $user['role_name'];

                    // Cập nhật thời gian đăng nhập
                    $loginModel->updateLastLogin($user['user_id']);

                    // Chuyển hướng dựa vào role
                    if ($user['role_id'] == 1) {
                        header('Location: index.php?action=home');
                    } else {
                        header('Location: index.php?action=home');
                    }
                    exit;
                } else {
                    if (!$user) {
                        $error = 'Email hoặc mật khẩu không chính xác';
                    } else if ($user['status'] != 1) {
                        $error = 'Tài khoản của bạn đã bị khóa';
                    }
                }
            }
        }

        require_once "client/views/authentication/login.php";
    }

    public static function authController() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once "client/views/authentication/login.php";
    }

    public static function logoutController() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        session_destroy();
        header('Location: index.php?action=home');
        exit;
    }
}
