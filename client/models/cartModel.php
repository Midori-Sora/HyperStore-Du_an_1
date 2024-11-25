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
            $sql = "SELECT p.*, pc.color_type, ps.storage_type, 
                    p.price as final_price 
                    FROM products p 
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id 
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id 
                    WHERE p.pro_id = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            if ($product) {
                $product['quantity'] = $quantity;
                $product['subtotal'] = $product['final_price'] * $quantity;
                $total += $product['subtotal'];
                $items[] = $product;
            }

            $stmt->close();
        }

        return ['items' => $items, 'total' => $total];
    }

    public function getProductById($pro_id)
    {
        $sql = "SELECT * FROM products WHERE pro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$pro_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function clearCart()
    {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}
