<?php
class CartModel extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addToCart($userId, $productId, $quantity = 1)
    {
        $sql = "INSERT INTO cart (user_id, pro_id, quantity) 
                VALUES (:userId, :productId, :quantity) 
                ON DUPLICATE KEY UPDATE quantity = quantity + :newQuantity";

        $stmt = $this->SUNNY->prepare($sql);
        return $stmt->execute([
            ':userId' => $userId,
            ':productId' => $productId,
            ':quantity' => $quantity,
            ':newQuantity' => $quantity
        ]);
    }

    public function getCartItems($userId)
    {
        try {
            $sql = "SELECT c.*, p.pro_name, p.price, p.img 
                    FROM cart c 
                    JOIN products p ON c.pro_id = p.pro_id 
                    WHERE c.user_id = :userId";

            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([':userId' => $userId]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Debug
            error_log("SQL Query: " . $sql);
            error_log("User ID: " . $userId);
            error_log("Items found: " . count($items));

            return $items;
        } catch (PDOException $e) {
            error_log("Error getting cart items: " . $e->getMessage());
            return [];
        }
    }

    public function updateQuantity($userId, $productId, $quantity)
    {
        $sql = "UPDATE cart SET quantity = :quantity WHERE user_id = :userId AND pro_id = :productId";
        $stmt = $this->SUNNY->prepare($sql);
        return $stmt->execute([
            ':quantity' => $quantity,
            ':userId' => $userId,
            ':productId' => $productId
        ]);
    }

    public function removeFromCart($userId, $productId)
    {
        $sql = "DELETE FROM cart WHERE user_id = :userId AND pro_id = :productId";
        $stmt = $this->SUNNY->prepare($sql);
        return $stmt->execute([
            ':userId' => $userId,
            ':productId' => $productId
        ]);
    }

    public function getCartTotal($userId)
    {
        $sql = "SELECT SUM(c.quantity * p.price) as total 
                FROM cart c
                INNER JOIN products p ON c.pro_id = p.pro_id 
                WHERE c.user_id = :userId";

        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getCartCount($userId)
    {
        try {
            $sql = "SELECT COUNT(*) FROM cart WHERE user_id = :userId";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([':userId' => $userId]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getCartItemCount($userId)
    {
        try {
            $sql = "SELECT SUM(quantity) as total FROM cart WHERE user_id = :userId";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([':userId' => $userId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error getting cart count: " . $e->getMessage());
            return 0;
        }
    }
}
