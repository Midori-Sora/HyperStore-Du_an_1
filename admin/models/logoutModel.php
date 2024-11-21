<?php
require_once "./commons/env.php";
require_once "./commons/function.php";

class LogoutModel extends MainModel
{
    public $SUNNY;

    public function __construct()
    {
        try {
            parent::__construct();
        } catch (PDOException $e) {
            error_log("Database connection failed in LogoutModel: " . $e->getMessage());
            throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
        }
    }

    public function updateLastLogout($userId) {
        try {
            $sql = "UPDATE users SET last_logout = NOW() WHERE user_id = ?";
            $stmt = $this->SUNNY->prepare($sql);
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Update last logout error: " . $e->getMessage());
            return false;
        }
    }
}
