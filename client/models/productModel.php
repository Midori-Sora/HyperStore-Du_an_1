<?php
class ProductModel  
{
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function getProductList()
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pc.color_type, pr.ram_type 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_ram pr ON p.ram_id = pr.ram_id
                    WHERE p.pro_status = 1 
                    ORDER BY p.import_date DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);
            
        } catch (Exception $e) {
            error_log("Error in getProductList: " . $e->getMessage());
            return [];
        }
    }

    public function getProductsByCategory($cateId) 
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pc.color_type, pr.ram_type 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id 
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_ram pr ON p.ram_id = pr.ram_id
                    WHERE p.pro_status = 1 AND p.cate_id = ? 
                    ORDER BY p.import_date DESC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $cateId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);
            
        } catch (Exception $e) {
            error_log("Error in getProductsByCategory: " . $e->getMessage());
            return [];
        }
    }
    // Lấy danh sách danh mục
    public function getCategories() {
        $sql = "SELECT * FROM categories WHERE cate_status = 1 ORDER BY cate_name ASC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy thông tin danh mục theo ID
    public function getCategoryById($cateId) {
        $sql = "SELECT * FROM categories WHERE cate_id = ? AND cate_status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cateId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
