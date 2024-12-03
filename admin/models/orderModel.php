<?php
class OrderModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    // Lấy tất cả đơn hàng kèm thông tin người dùng
    public function getAllOrders()
    {
        try {
            $sql = "SELECT orders.*, users.username, users.email, users.phone 
                    FROM orders 
                    LEFT JOIN users ON orders.user_id = users.user_id 
                    ORDER BY orders.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting all orders: " . $e->getMessage());
            return false;
        }
    }

    // Lấy chi tiết một đơn hàng
    public function getOrderById($orderId)
    {
        try {
            $sql = "SELECT orders.*, users.username, users.email, users.phone,
                    orders.cancel_reason, orders.status 
                    FROM orders 
                    LEFT JOIN users ON orders.user_id = users.user_id 
                    WHERE orders.order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting order by ID: " . $e->getMessage());
            return false;
        }
    }

    // Lấy chi tiết sản phẩm trong đơn hàng
    public function getOrderDetails($order_id)
    {
        try {
            // Debug query
            error_log("Getting details for order ID: " . $order_id);

            $sql = "SELECT od.*, p.pro_name, p.img, pr.storage_type, pc.color_type
                    FROM order_details od
                    LEFT JOIN products p ON od.product_id = p.pro_id
                    LEFT JOIN product_storage pr ON p.storage_id = pr.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    WHERE od.order_id = :order_id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':order_id' => $order_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Debug result
            error_log("Query result: " . print_r($result, true));

            return $result;
        } catch (PDOException $e) {
            error_log("Error getting order details: " . $e->getMessage());
            return false;
        }
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $status)
    {
        try {
            // Lấy trạng thái hiện tại của đơn hàng
            $sql = "SELECT status FROM orders WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);
            $currentStatus = $stmt->fetchColumn();

            // Lấy danh sách trạng thái được phép chuyển đổi
            $allowedTransitions = OrderHelper::getAllowedStatusTransitions($currentStatus);

            // Kiểm tra xem trạng thái mới có được phép không
            if (!array_key_exists($status, $allowedTransitions)) {
                throw new Exception("Không thể chuyển từ trạng thái $currentStatus sang $status");
            }

            // Nếu hợp lệ, thực hiện cập nhật
            $sql = "UPDATE orders SET status = ?, updated_at = NOW() WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $orderId]);
        } catch (Exception $e) {
            error_log("Error updating order status: " . $e->getMessage());
            throw $e;
        }
    }

    // Xóa đơn hàng và chi tiết đơn hàng
    public function deleteOrder($orderId)
    {
        try {
            $this->db->beginTransaction();

            // Xóa chi tiết đơn hàng
            $sql = "DELETE FROM order_details WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);

            // Xóa đơn hàng
            $sql = "DELETE FROM orders WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleting order: " . $e->getMessage());
            return false;
        }
    }

    // Lấy thống kê đơn hàng theo trạng thái
    public function getOrderStats()
    {
        try {
            $sql = "SELECT status, COUNT(*) as count 
                    FROM orders 
                    GROUP BY status";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting order stats: " . $e->getMessage());
            return false;
        }
    }

    // Lấy tổng doanh thu
    public function getTotalRevenue()
    {
        try {
            $sql = "SELECT SUM(total_amount) as total FROM orders WHERE status = 'completed'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error getting total revenue: " . $e->getMessage());
            return 0;
        }
    }

    // Thêm phương thức tìm kiếm
    public function searchOrders($params)
    {
        try {
            $conditions = [];
            $values = [];

            // Base query
            $sql = "SELECT orders.*, users.username, users.email, users.phone 
                    FROM orders 
                    LEFT JOIN users ON orders.user_id = users.user_id";

            // Keyword search
            if (!empty($params['keyword'])) {
                $conditions[] = "(orders.order_code LIKE ? OR users.username LIKE ? OR users.phone LIKE ?)";
                $keyword = "%{$params['keyword']}%";
                $values = array_merge($values, [$keyword, $keyword, $keyword]);
            }

            // Status filter
            if (!empty($params['status'])) {
                $conditions[] = "orders.status = ?";
                $values[] = $params['status'];
            }

            // Add WHERE clause if conditions exist
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Add ORDER BY clause
            if (!empty($params['sort'])) {
                $sql .= match ($params['sort']) {
                    'newest' => " ORDER BY orders.created_at DESC",
                    'oldest' => " ORDER BY orders.created_at ASC",
                    default => " ORDER BY orders.created_at DESC"
                };
            } else {
                $sql .= " ORDER BY orders.created_at DESC";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching orders: " . $e->getMessage());
            return false;
        }
    }

    // Thêm phương thức gửi SMS
    public function sendSMS($phone, $message)
    {
        try {
            // Giả lập gửi SMS thành công
            // Trong thực tế, bạn sẽ tích hợp API gửi SMS thật ở đây
            error_log("SMS sent to $phone: $message");
            return true;
        } catch (Exception $e) {
            error_log("Error sending SMS: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderStatusText($status)
    {
        $statusMap = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'delivered' => 'Đã giao',
            'cancelled' => 'Đã hủy',
            'return_requested' => 'Yêu cầu trả hàng',
            'returned' => 'Đã trả hàng'
        ];
        return $statusMap[$status] ?? 'Không xác định';
    }

    public function getOrderStatusClass($status)
    {
        $classMap = [
            'pending' => 'status-pending',
            'confirmed' => 'status-confirmed',
            'processing' => 'status-processing',
            'shipping' => 'status-shipping',
            'delivered' => 'status-success',
            'cancelled' => 'status-danger',
            'return_requested' => 'status-warning',
            'returned' => 'status-info'
        ];
        return $classMap[$status] ?? '';
    }

    public function requestReturn($orderId, $userId, $reason)
    {
        try {
            // Kiểm tra đơn hàng
            $sql = "SELECT status FROM orders WHERE order_id = ? AND user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId, $userId]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$order) {
                throw new Exception("Không tìm thấy đơn hàng");
            }

            if ($order['status'] !== 'delivered') {
                throw new Exception("Chỉ có thể yêu cầu trả hàng với đơn hàng đã giao thành công");
            }

            // Cập nhật trạng thái
            $sql = "UPDATE orders 
                    SET status = 'returned', 
                        return_reason = ?,
                        updated_at = NOW() 
                    WHERE order_id = ? AND user_id = ?";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$reason, $orderId, $userId]);
        } catch (Exception $e) {
            error_log("Error in requestReturn: " . $e->getMessage());
            return false;
        }
    }

    public function handleReturnRequest($orderId, $status, $adminNote)
    {
        try {
            $this->db->beginTransaction();

            // Cập nhật trạng thái yêu cầu trả hàng
            $sql = "UPDATE return_requests 
                    SET status = ?, admin_note = ?, processed_date = NOW() 
                    WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$status === 'returned' ? 'approved' : 'rejected', $adminNote, $orderId]);

            // Cập nhật trạng thái đơn hàng
            $orderStatus = $status === 'returned' ? 'returned' : 'return_failed';
            $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderStatus, $orderId]);

            // Nếu chấp nhận trả hàng, cập nhật số lượng sản phẩm
            if ($status === 'returned') {
                $sql = "UPDATE products p 
                       INNER JOIN order_details od ON p.pro_id = od.product_id 
                       SET p.quantity = p.quantity + od.quantity 
                       WHERE od.order_id = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$orderId]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function processCancelRequest($orderId, $approve)
    {
        try {
            $status = $approve ? 'cancelled' : 'pending';
            $sql = "UPDATE orders 
                    SET status = ?,
                        updated_at = NOW()
                    WHERE order_id = ? 
                    AND status = 'cancel_requested'";

            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $orderId]);
        } catch (PDOException $e) {
            error_log("Error processing cancel request: " . $e->getMessage());
            return false;
        }
    }

    public static function updateCancelRequest($orderId, $status)
    {
        global $MainModel;
        $sql = "UPDATE orders SET cancel_status = ? WHERE id = ?";
        $stmt = $MainModel->SUNNY->prepare($sql);
        return $stmt->execute([$status, $orderId]);
    }
}