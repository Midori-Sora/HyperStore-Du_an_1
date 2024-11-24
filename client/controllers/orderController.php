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
            $_SESSION['error'] = "Không tìm thấy đơn hàng hoặc bạn không có quyền xem đơn hàng này";
            header('Location: index.php?action=orders');
            exit();
        }

        $orderDetails = $this->orderModel->getOrderDetailById($orderId);

        require_once 'client/views/order/order-detail.php';
    }
}
