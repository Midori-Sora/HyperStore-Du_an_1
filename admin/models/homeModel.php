<?php
require_once "./commons/env.php";
require_once "./commons/function.php";

class HomeModel extends MainModel
{
    public $SUNNY;

    public function __construct()
    {
        try {
            parent::__construct();
            error_log("Database connection established in HomeModel");
        } catch (PDOException $e) {
            error_log("Database connection failed in HomeModel: " . $e->getMessage());
            throw new Exception("Không thể kết nối đến cơ sở dữ liệu");
        }
    }

    public function countProducts()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN pro_status = 1 THEN 1 END) as active,
                    COUNT(CASE WHEN pro_status = 0 THEN 1 END) as inactive
                    FROM products";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Count products error: " . $e->getMessage());
            return [
                'total' => 0,
                'active' => 0,
                'inactive' => 0
            ];
        }
    }

    public function countUsers()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN role_id = 1 THEN 1 ELSE 0 END) as admin,
                    SUM(CASE WHEN role_id = 2 THEN 1 ELSE 0 END) as customer
                    FROM users";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'total' => (int)$result['total'] ?? 0,
                'admin' => (int)$result['admin'] ?? 0,
                'customer' => (int)$result['customer'] ?? 0
            ];
        } catch (PDOException $e) {
            error_log("Count users error: " . $e->getMessage());
            return [
                'total' => 0,
                'admin' => 0,
                'customer' => 0
            ];
        }
    }

    public function countComments()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN cmt_status = 1 THEN 1 END) as approved,
                    COUNT(CASE WHEN cmt_status = 0 THEN 1 END) as pending   
                    FROM comments";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Ép kiểu kết quả về số nguyên và xử lý null
            return [
                'total' => (int)($result['total'] ?? 0),
                'approved' => (int)($result['approved'] ?? 0), 
                'pending' => (int)($result['pending'] ?? 0)
            ];
        } catch (PDOException $e) {
            error_log("Count comments error: " . $e->getMessage());
            return [
                'total' => 0,
                'approved' => 0,
                'pending' => 0
            ];
        }
    }

    public function getTotalRevenue()
    {
        try {
            $sql = "SELECT SUM(price * quantity) as total_revenue 
                    FROM products 
                    WHERE pro_status = 1";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_revenue'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get total revenue error: " . $e->getMessage());
            return 0;
        }
    }

    public function getTopProducts($limit = 5)
    {
        try {
            $sql = "SELECT p.pro_name, p.quantity, p.price, c.cate_name
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    WHERE p.pro_status = 1
                    ORDER BY p.quantity DESC
                    LIMIT :limit";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get top products error: " . $e->getMessage());
            return [];
        }
    }
}
?>
