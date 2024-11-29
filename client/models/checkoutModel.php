<?php
class CheckoutModel
{
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->conn->connect_error) {
                error_log("Database connection failed: " . $this->conn->connect_error);
                throw new Exception("Không thể kết nối database");
            }
            error_log("Database connected successfully");
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getProductDetails($productId)
    {
        $sql = "SELECT p.*, 
                pc.color_type, pc.color_price,
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
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if ($product && isset($product['current_discount']) && $product['current_discount'] > 0) {
            $product['discounted_price'] = $product['final_price'] * (1 - $product['current_discount'] / 100);
        }

        return $product;
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

    public function createOrder($orderData)
    {
        try {
            $sql = "INSERT INTO orders (
                order_code,
                user_id, 
                receiver_name,
                total_amount, 
                shipping_address,
                shipping_phone,
                shipping_email,
                bank_code, 
                status,
                payment_method,
                payment_status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            // Tạo order_code
            $orderCode = 'ORD' . time();

            $stmt->bind_param(
                "sisdsssssss",
                $orderCode,
                $orderData['user_id'],
                $orderData['receiver_name'],
                $orderData['total_amount'],
                $orderData['shipping_address'],
                $orderData['shipping_phone'],
                $orderData['shipping_email'],
                $orderData['bank_code'],
                $orderData['status'],
                $orderData['payment_method'],
                $orderData['payment_status']
            );

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return $this->conn->insert_id;
        } catch (Exception $e) {
            error_log('Create order error: ' . $e->getMessage());
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

    public function getBankInfo($bankCode)
    {
        $banks = [
            'vcb' => [
                'name' => 'Vietcombank',
                'account_number' => '1234567890',
                'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                'branch' => 'Chi nhánh Bà Rịa - Vũng Tàu'
            ],
            'tcb' => [
                'name' => 'Techcombank',
                'account_number' => '0987654321',
                'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                'branch' => 'Chi nhánh Bà Rịa - Vũng Tàu'
            ],
            'mb' => [
                'name' => 'MB Bank',
                'account_number' => '9876543210',
                'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                'branch' => 'Chi nhánh Bà Rịa - Vũng Tàu'
            ],
            'acb' => [
                'name' => 'ACB',
                'account_number' => '0123456789',
                'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                'branch' => 'Chi nhánh Bà Rịa - Vũng Tàu'
            ]
        ];

        return isset($banks[$bankCode]) ? $banks[$bankCode] : null;
    }

    public function saveTransaction($orderId, $transactionCode, $amount, $paymentMethod, $bankCode = null)
    {
        try {
            $sql = "INSERT INTO transactions (order_id, transaction_code, amount, payment_method, bank_code) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception('Prepare statement failed: ' . $this->conn->error);
            }

            $stmt->bind_param("isdss", $orderId, $transactionCode, $amount, $paymentMethod, $bankCode);

            if (!$stmt->execute()) {
                throw new Exception('Execute failed: ' . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Save transaction error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function beginTransaction()
    {
        $this->conn->begin_transaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollback()
    {
        $this->conn->rollback();
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function getOrderById($orderId)
    {
        try {
            $sql = "SELECT * FROM orders WHERE order_id = ? LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            $stmt->bind_param("i", $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            $result = $stmt->get_result();
            $order = $result->fetch_assoc();

            error_log("Found order: " . print_r($order, true));

            return $order;
        } catch (Exception $e) {
            error_log("Get order error: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateOrderStatus($orderId, $status)
    {
        try {
            $sql = "UPDATE orders SET status = ?, updated_at = NOW() WHERE order_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            $stmt->bind_param("si", $status, $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Update order status error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function logPaymentSuccess($orderId, $paymentType)
    {
        $sql = "INSERT INTO payment_logs (order_id, payment_type, status, message) 
                VALUES (?, ?, 'success', 'Thanh toán thành công')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $orderId, $paymentType);
        return $stmt->execute();
    }

    public function logPaymentFailure($orderId, $paymentType)
    {
        $sql = "INSERT INTO payment_logs (order_id, payment_type, status, message) 
                VALUES (?, ?, 'failed', 'Thanh toán thất bại')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $orderId, $paymentType);
        return $stmt->execute();
    }

    public function checkProductStock($productId, $quantity)
    {
        $sql = "SELECT quantity FROM products WHERE pro_id = ? AND quantity >= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $productId, $quantity);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function updateOrderPaymentStatus($orderId, $status)
    {
        try {
            $sql = "UPDATE orders SET payment_status = ?, updated_at = NOW() WHERE order_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            $stmt->bind_param("si", $status, $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Update payment status error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function logPaymentConfirmation($orderId, $transactionCode)
    {
        try {
            $sql = "INSERT INTO payment_logs (order_id, transaction_code, status, message) 
                    VALUES (?, ?, 'confirmed', 'Khách hàng đã xác nhận chuyển khoản')";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            $stmt->bind_param("is", $orderId, $transactionCode);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Log payment confirmation error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updatePaymentMethod($orderId, $paymentMethod)
    {
        try {
            $sql = "UPDATE orders SET payment_method = ? WHERE order_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            $stmt->bind_param("si", $paymentMethod, $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Update payment method error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updatePaymentStatus($orderId, $status)
    {
        try {
            $sql = "UPDATE orders SET payment_status = ? WHERE order_id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            $stmt->bind_param("si", $status, $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Update payment status error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function logPayment($orderId, $paymentType, $status, $message)
    {
        try {
            $sql = "INSERT INTO payment_logs (order_id, payment_type, status, message) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Prepare statement failed: " . $this->conn->error);
            }

            $stmt->bind_param("isss", $orderId, $paymentType, $status, $message);
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }

            return true;
        } catch (Exception $e) {
            error_log('Log payment error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateShippingAddress($data)
    {
        try {
            // Validate dữ liệu
            foreach (['receiver_name', 'phone', 'address', 'user_id'] as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Vui lòng điền đầy đủ thông tin");
                }
            }

            $sql = "UPDATE users 
                    SET fullname = ?, 
                        phone = ?, 
                        address = ?
                    WHERE user_id = ?";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi hệ thống, vui lòng thử lại sau");
            }

            $stmt->bind_param(
                "sssi",
                $data['receiver_name'],
                $data['phone'],
                $data['address'],
                $data['user_id']
            );

            if (!$stmt->execute()) {
                throw new Exception("Không thể cập nhật địa chỉ, vui lòng thử lại");
            }

            return true;
        } catch (Exception $e) {
            error_log('Update shipping address error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getOrderItems($orderId)
    {
        try {
            $sql = "SELECT od.product_id, od.quantity, od.price, p.pro_name 
                    FROM order_details od
                    JOIN products p ON od.product_id = p.pro_id
                    WHERE od.order_id = ?";

            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi chuẩn bị câu lệnh SQL");
            }

            $stmt->bind_param("i", $orderId);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi thực thi truy vấn");
            }

            $result = $stmt->get_result();
            $items = [];

            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }

            return $items;
        } catch (Exception $e) {
            error_log("Error getting order items: " . $e->getMessage());
            throw $e;
        }
    }
}
