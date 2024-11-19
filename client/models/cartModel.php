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

    public function addToCart($userId, $productId, $quantity = 1)
    {
        $sql = "INSERT INTO cart (user_id, pro_id, quantity) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE quantity = quantity + ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $userId, $productId, $quantity, $quantity);
        return $stmt->execute();
    }

    public function getCartItems($userId)
    {
        $sql = "SELECT c.*, p.pro_name, p.price, p.img 
                FROM cart c 
                JOIN products p ON c.pro_id = p.pro_id 
                WHERE c.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateQuantity($userId, $productId, $quantity)
    {
        $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $userId, $productId);
        return $stmt->execute();
    }

    public function removeFromCart($userId, $productId)
    {
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $userId, $productId);
        return $stmt->execute();
    }

    public function getCartTotal($userId)
    {
        $sql = "SELECT SUM(c.quantity * p.price) as total 
                FROM cart c 
                JOIN products p ON c.product_id = p.pro_id 
                WHERE c.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
    }
}
