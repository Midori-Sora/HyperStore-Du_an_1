<?php
require_once "client/commons/orderHelper.php";

class OrderModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            throw new Exception("Kết nối database thất bại");
        }
    }

    public function getOrdersByUserId($userId)
    {
        $sql = "SELECT o.*, od.quantity, 
                p.pro_name, CONCAT('Uploads/Product/', p.img) as product_image,
                COUNT(od.product_id) as total_items
                FROM orders o
                LEFT JOIN order_details od ON o.order_id = od.order_id
                LEFT JOIN products p ON od.product_id = p.pro_id
                WHERE o.user_id = ?
                GROUP BY o.order_id
                ORDER BY o.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderDetail($orderId)
    {
        $sql = "SELECT od.*, p.pro_name, CONCAT('Uploads/Product/', p.img) as product_image,
                pc.color_type, ps.storage_type
                FROM order_details od
                JOIN products p ON od.product_id = p.pro_id
                LEFT JOIN product_color pc ON p.color_id = pc.color_id
                LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                WHERE od.order_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrderById($orderId, $userId)
    {
        $sql = "SELECT o.*, u.fullname as user_name 
                FROM orders o
                JOIN users u ON o.user_id = u.user_id
                WHERE o.order_id = ? AND o.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $orderId, $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getOrderDetailById($orderId)
    {
        $sql = "SELECT od.*, p.pro_name, p.img as product_image,
                pc.color_type, ps.storage_type
                FROM order_details od
                JOIN products p ON od.product_id = p.pro_id
                LEFT JOIN product_color pc ON p.color_id = pc.color_id
                LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                WHERE od.order_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function cancelOrder($orderId, $userId)
    {
        $sql = "UPDATE orders 
                SET status = 'cancelled' 
                WHERE order_id = ? AND user_id = ? 
                AND status IN ('pending', 'confirmed', 'processing')";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $orderId, $userId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }
}
