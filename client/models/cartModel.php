<?php

class CartModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getCartItems($cart) {
        $items = [];
        foreach ($cart as $product_id => $quantity) {
            $sql = "SELECT p.*, pc.color_type, ps.storage_type, 
                    (p.price + COALESCE(pc.color_price, 0) + COALESCE(ps.storage_price, 0)) as final_price 
                    FROM products p 
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id 
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id 
                    WHERE p.pro_id = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            
            // Lấy kết quả
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
            
            if ($product) {
                $product['quantity'] = $quantity;
                $items[] = $product;
            }
            
            $stmt->close();
        }
        return $items;
    }

    public function __destruct() {
        $this->conn->close();
    }
}