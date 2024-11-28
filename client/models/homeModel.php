<?php

class HomeModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getFeaturedProducts()
    {
        try {
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, pc.color_type, pc.color_price,
                    (p.price + COALESCE(ps.storage_price, 0) + COALESCE(pc.color_price, 0)) as total_price,
                    pd.discount
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    ORDER BY total_price DESC LIMIT 5";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get featured products error: " . $e->getMessage());
            return [];
        }
    }

    public function getNewestPhones()
    {
        try {
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, pc.color_type, pc.color_price,
                    (p.price + COALESCE(ps.storage_price, 0) + COALESCE(pc.color_price, 0)) as total_price,
                    pd.discount
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    ORDER BY p.import_date DESC LIMIT 5";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get newest phones error: " . $e->getMessage());
            return [];
        }
    }
}
