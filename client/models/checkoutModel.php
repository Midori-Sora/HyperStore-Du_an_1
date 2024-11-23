<?php
class CheckoutModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getProductDetails($productId)
    {
        $sql = "SELECT p.*, pc.color_type, ps.storage_type 
                FROM products p 
                LEFT JOIN product_color pc ON p.color_id = pc.color_id 
                LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id 
                WHERE p.pro_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getUserAddress($userId)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            return [
                'receiver_name' => $user['fullname'],
                'phone' => $user['phone'],
                'address' => $user['address']
            ];
        }
        return null;
    }

    public function createOrder($userId, $totalAmount, $paymentMethod, $address)
    {
        // Bắt đầu transaction
        $this->conn->begin_transaction();

        try {
            // Tạo đơn hàng mới
            $sql = "INSERT INTO orders (user_id, total_amount, payment_method, shipping_address, order_status, order_date) 
                    VALUES (?, ?, ?, ?, 'pending', NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("idss", $userId, $totalAmount, $paymentMethod, $address);
            $stmt->execute();
            $orderId = $this->conn->insert_id;

            // Commit transaction
            $this->conn->commit();
            return $orderId;
        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->conn->rollback();
            throw $e;
        }
    }

    public function addOrderDetails($orderId, $productId, $quantity, $price)
    {
        $sql = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $price);
        return $stmt->execute();
    }

    public function updateProductQuantity($productId, $quantity)
    {
        $sql = "UPDATE products SET quantity = quantity - ? WHERE pro_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $productId);
        return $stmt->execute();
    }

    public function getBankInfo()
    {
        return [
            'name' => 'Vietcombank',
            'account_number' => '1234567890',
            'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
            'branch' => 'Chi nhánh Bà Rịa - Vũng Tàu'
        ];
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}
