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
            
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, 
                    pc.color_type, pc.color_price,
                    (p.price + COALESCE(ps.storage_price, 0) + COALESCE(pc.color_price, 0)) as total_price,
                    pd.discount
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    WHERE p.pro_status = 1 
                    AND (p.pro_name LIKE :keyword 
                         OR c.cate_name LIKE :keyword
                         OR pc.color_type LIKE :keyword
                         OR ps.storage_type LIKE :keyword)
                    ORDER BY p.import_date DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':keyword' => $keyword]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error in searchProducts: " . $e->getMessage());
            return [];
        }
    }
}
