<?php

class CartModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getCartItems($cart)
    {
        $items = [];
        $total = 0;

        foreach ($cart as $product_id => $quantity) {
            $sql = "SELECT p.*, pc.color_type, pc.color_price, 
                          ps.storage_type, ps.storage_price,
                          pd.discount as current_discount,
                          p.price as base_price,
                          (p.price + COALESCE(pc.color_price, 0) + COALESCE(ps.storage_price, 0)) as final_price
                   FROM products p 
                   LEFT JOIN product_color pc ON p.color_id = pc.color_id 
                   LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id 
                   LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
                   WHERE p.pro_id = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                $product['quantity'] = $quantity;

                // Tính giá sau khuyến mãi nếu có
                if (isset($product['current_discount']) && $product['current_discount'] > 0) {
                    $product['discounted_price'] = $product['final_price'] * (1 - $product['current_discount'] / 100);
                    $product['subtotal'] = $product['discounted_price'] * $quantity;
                } else {
                    $product['subtotal'] = $product['final_price'] * $quantity;
                }

                $total += $product['subtotal'];
                $items[] = $product;
            }
            $stmt->close();
        }

        return ['items' => $items, 'total' => $total];
    }

    public function getProductById($pro_id)
    {
        $sql = "SELECT p.*, pc.color_type, pc.color_price, 
                   ps.storage_type, ps.storage_price,
                   pd.discount as current_discount,
                   p.price as base_price,
                   (p.price + COALESCE(pc.color_price, 0) + COALESCE(ps.storage_price, 0)) as final_price
            FROM products p 
            LEFT JOIN product_color pc ON p.color_id = pc.color_id 
            LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id 
            LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
            WHERE p.pro_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $pro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function checkStockQuantity($product_id)
    {
        $sql = "SELECT quantity FROM products WHERE pro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        return $product ? $product['quantity'] : 0;
    }

    public function clearCart($productIds = null)
    {
        if (empty($_SESSION['cart'])) {
            return;
        }

        if ($productIds === null) {
            unset($_SESSION['cart']);
        } else {
            foreach ($productIds as $productId) {
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                }
            }
        }

        // Cập nhật session nếu giỏ hàng trống
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}
