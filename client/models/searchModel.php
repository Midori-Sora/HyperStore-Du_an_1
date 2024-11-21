<?php
class SearchModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function searchProducts($keyword) {
        try {
            $keyword = "%{$keyword}%";
            
            $sql = "SELECT p.*, c.cate_name, pc.color_type, ps.storage_type 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    WHERE p.pro_status = 1 
                    AND (p.pro_name LIKE ? 
                         OR c.cate_name LIKE ?
                         OR pc.color_type LIKE ?
                         OR ps.storage_type LIKE ?)
                    ORDER BY p.import_date DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssss", $keyword, $keyword, $keyword, $keyword);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error in searchProducts: " . $e->getMessage());
            return [];
        }
    }
}
