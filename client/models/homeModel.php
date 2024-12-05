<?php

class HomeModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function calculateProductPrice(&$product)
    {
        $total_price = $product['price'] + 
                    floatval($product['storage_price'] ?? 0) + 
                    floatval($product['color_price'] ?? 0);
        $product['original_price'] = $total_price;
        if (!empty($product['discount'])) {
            $product['discount_price'] = $total_price * (100 - $product['discount']) / 100;
        }
    }

    public function getFeaturedProducts()
    {
        try {
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price,
                    pc.color_type, pc.color_price, pd.discount, pd.start_date, pd.end_date
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id
                        AND pd.status = 1
                        AND CURRENT_DATE BETWEEN pd.start_date AND pd.end_date
                    WHERE p.pro_status = 1
                    ORDER BY p.price DESC LIMIT 5";
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
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, 
                    pc.color_type, pc.color_price, pd.discount, pd.start_date, pd.end_date
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
                        AND pd.status = 1 
                        AND CURRENT_DATE BETWEEN pd.start_date AND pd.end_date
                    WHERE p.pro_status = 1
                    ORDER BY p.import_date DESC LIMIT 5";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get newest phones error: " . $e->getMessage());
            return [];
        }
    }

    public function getDiscountProducts($limit = 5)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, 
                    pc.color_type, pc.color_price, pd.discount, pd.start_date, pd.end_date
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
                        AND pd.status = 1 
                        AND CURRENT_DATE BETWEEN pd.start_date AND pd.end_date
                    WHERE p.pro_status = 1 
                    AND pd.discount IS NOT NULL
                    ORDER BY pd.discount DESC 
                    LIMIT ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get discount products error: " . $e->getMessage());
            return [];
        }
    }
}
