<?php
class SearchModel {
    private $db;

    public function __construct() {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function searchProducts($keyword) {
        try {
            $keyword = "%{$keyword}%";
            
            $sql = "SELECT p.*, c.cate_name, 
                    pc.color_type, pc.color_price,
                    ps.storage_type, ps.storage_price,
                    pd.discount
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    WHERE p.pro_status = 1 
                    AND LOWER(p.pro_name) LIKE LOWER(:keyword)
                    ORDER BY p.pro_name ASC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':keyword' => $keyword]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error in searchProducts: " . $e->getMessage());
            return [];
        }
    }
}
