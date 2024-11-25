<?php
require_once "client/models/orderModel.php";

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
            $_SESSION['error'] = "Không tìm thấy đơn hàng hoặc bn không có quyền xem đơn hàng này";
            header('Location: index.php?action=orders');
            exit();
        }

        $orderDetails = $this->orderModel->getOrderDetailById($orderId);

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
}
