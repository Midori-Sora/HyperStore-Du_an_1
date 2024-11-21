<?php
class AuthController {
    public static function logoutController() {
        session_start();
        session_destroy();
        header('Location: login.php');
        exit();
    }
} 