<?php
class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function orderList()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem đơn hàng';
            header('Location: index.php?action=login');
            exit();
        }

        $orders = $this->orderModel->getOrdersByUserId($_SESSION['user_id']);
        require_once 'client/views/order/order-list.php';
    }

    public function orderDetail()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $orderId = $_GET['id'] ?? null;

        if (!$orderId) {
            header('Location: index.php?action=orders');
            exit();
        }

        $order = $this->orderModel->getOrderById($orderId, $userId);

        if (!$order) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn hàng này";
            header('Location: index.php?action=orders');
            exit();
        }

        $orderDetails = $this->orderModel->getOrderDetailById($orderId);

        // Tính tổng tiền từ chi tiết đơn hàng
        $totalAmount = array_reduce($orderDetails, function ($carry, $item) {
            return $carry + ($item['unit_price'] * $item['quantity']);
        }, 0);

        $order['total_amount'] = $totalAmount;

        require_once 'client/views/order/order-detail.php';
    }

    public function cancelOrder()
    {
        if (!isset($_SESSION['user_id']) || !isset($_POST['order_id'])) {
            echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
            exit();
        }

        $orderId = $_POST['order_id'];
        $userId = $_SESSION['user_id'];

        // Kiểm tra trạng thái đơn hàng trước khi hủy
        $order = $this->orderModel->getOrderById($orderId, $userId);
        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
            exit();
        }

        if (!OrderHelper::canCancelOrder($order['status'])) {
            echo json_encode(['success' => false, 'message' => 'Không thể hủy đơn hàng ở trạng thái này']);
            exit();
        }

        $result = $this->orderModel->cancelOrder($orderId, $userId);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Hủy đơn hàng thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể hủy đơn hàng. Vui lòng thử lại sau']);
        }
        exit();
    }

    public function requestReturn()
    {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Vui lòng đăng nhập để thực hiện chức năng này");
            }

            if (!isset($_POST['order_id']) || !isset($_POST['reason'])) {
                throw new Exception("Thiếu thông tin cần thiết");
            }

            $orderId = (int)$_POST['order_id'];
            $userId = (int)$_SESSION['user_id'];
            $reason = htmlspecialchars($_POST['reason']);

            // Gọi phương thức từ model
            $result = $this->orderModel->requestReturn($orderId, $userId, $reason);

            echo json_encode([
                'success' => true,
                'message' => 'Yêu cầu trả hàng đã được gửi thành công'
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function requestRefund()
    {
        if (!isset($_SESSION['user_id']) || !isset($_POST['order_id']) || !isset($_POST['reason'])) {
            echo json_encode(['success' => false, 'message' => 'Yêu cầu không hợp lệ']);
            exit();
        }

        $orderId = $_POST['order_id'];
        $userId = $_SESSION['user_id'];
        $reason = $_POST['reason'];

        $result = $this->orderModel->requestRefund($orderId, $userId, $reason);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Yêu cầu hoàn tiền đã được gửi']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể gửi yêu cầu hoàn tiền']);
        }
        exit();
    }
}
