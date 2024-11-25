<?php
require_once 'orderHelper.php';

class MainModel
{
    public $SUNNY;

    public function __construct()
    {
        $this->SUNNY = $this->connect_db();
    }

    public function connect_db()
    {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
            $SUNNY = new PDO($dsn, DB_USER, DB_PASS, PDO_OPTIONS);

            return $SUNNY;
        } catch (PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new Exception("Không thể kết nối đến database");
        }
    }
}

// Initialize MainModel
try {
    $MainModel = new MainModel();
} catch (Exception $e) {
    error_log("MainModel initialization error: " . $e->getMessage());
    die("Không thể khởi tạo kết nối database");
}
