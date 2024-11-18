<?php
require_once './models/orderModel.php';

class OrderController
{
    private static $orderModel;

    public static function init()
    {
        if (!self::$orderModel) {
            self::$orderModel = new OrderModel();
        }
    }

    public static function orderController()
    {
        try {
            self::init();
            error_log("Debug: OrderController initialized");

            $orders = self::$orderModel->getAllOrders();
            error_log("Debug: Orders fetched: " . print_r($orders, true));

            if (empty($orders)) {
                error_log("Debug: No orders found");
            }

            require_once './views/order/order.php';
        } catch (Exception $e) {
            error_log("Error in orderController: " . $e->getMessage());
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    public static function orderDetailController()
    {
        try {
            if (isset($_GET['id'])) {
                self::init();
                $order = self::$orderModel->getOrderById($_GET['id']);
                if ($order) {
                    require_once './views/order/order-detail.php';
                } else {
                    $_SESSION['error'] = "Không tìm thấy đơn hàng";
                    header("Location: index.php?action=order");
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=order');
            exit();
        }
    }

    public static function updateOrderStatusController()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
                self::init();
                if (self::$orderModel->updateOrderStatus($_POST['order_id'], $_POST['status'])) {
                    $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công";
                } else {
                    $_SESSION['error'] = "Cập nhật trạng thái thất bại";
                }
                header("Location: index.php?action=order");
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=order');
            exit();
        }
    }

    public static function searchOrderController()
    {
        try {
            self::init();
            $searchParams = [
                'keyword' => $_GET['keyword'] ?? '',
                'status' => $_GET['status'] ?? '',
                'sort' => $_GET['sort'] ?? ''
            ];

            $orders = self::$orderModel->searchOrders($searchParams);
            require_once './views/order/order.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=order');
            exit();
        }
    }

    public static function sendSMSController()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['phone']) && isset($_POST['message'])) {
                self::init();
                $phone = $_POST['phone'];
                $message = $_POST['message'];

                if (self::$orderModel->sendSMS($phone, $message)) {
                    $_SESSION['success'] = "Đã gửi SMS thành công đến số $phone";
                } else {
                    $_SESSION['error'] = "Gửi SMS thất bại";
                }
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}
