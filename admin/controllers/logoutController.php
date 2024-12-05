<?php
class LogoutController {
    public static function logoutController() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $logoutModel = new LogoutModel();
        
        // Cập nhật last_logout trong database
        if (isset($_SESSION['user_id'])) {
            $logoutModel->updateLastLogout($_SESSION['user_id']);
        }
        
        // Xóa tất cả các biến session
        $_SESSION = array();
        
        // Xóa cookie session
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-3600, '/');
        }
        
        // Hủy session
        session_destroy();
        
        // Chuyển hướng về trang login
        header('Location: ../index.php?action=login');
        exit;
    }
}
