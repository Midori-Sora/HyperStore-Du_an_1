<?php
require_once 'models/orderModel.php';
require_once '../client/commons/orderHelper.php';

class OrderController
{
    private static $orderModel = null;

    public static function init()
    {
        if (self::$orderModel === null) {
            self::$orderModel = new OrderModel();
        }
    }

    public static function orderController()
    {
        try {
            self::init();
            error_log("[DEBUG] Accessing orderController");

            if (!self::$orderModel) {
                error_log("[ERROR] orderModel is null");
                throw new Exception("OrderModel not initialized");
            }

            $orders = self::$orderModel->getAllOrders();
            error_log("[DEBUG] Orders count: " . count($orders));

            require_once './views/order/order.php';
        } catch (Exception $e) {
            error_log("[ERROR] " . $e->getMessage());
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    public static function orderDetailController()
    {
        try {
            if (isset($_GET['id'])) {
                $orderId = (int)$_GET['id'];

                // Khởi tạo model
                if (!isset(self::$orderModel)) {
                    self::$orderModel = new OrderModel();
                }

                // Debug
                error_log("Processing order ID: " . $orderId);

                // Lấy thông tin đơn hàng
                $order = self::$orderModel->getOrderById($orderId);
                error_log("Order info: " . print_r($order, true));

                // Lấy chi tiết đơn hàng
                $orderDetails = self::$orderModel->getOrderDetails($orderId);
                error_log("Order details: " . print_r($orderDetails, true));

                if ($order) {
                    require_once './views/order/order-detail.php';
                } else {
                    $_SESSION['error'] = "Không tìm thấy đơn hàng";
                    header("Location: index.php?action=order");
                    exit();
                }
            }
        } catch (Exception $e) {
            error_log("Error in orderDetailController: " . $e->getMessage());
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=order');
            exit();
        }
    }

    public static function updateOrderStatusController()
    {
        try {
            if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
                throw new Exception("Thiếu thông tin cần thiết");
            }

            self::init();
            $orderId = (int)$_POST['order_id'];
            $status = $_POST['status'];

            $result = self::$orderModel->updateOrderStatus($orderId, $status);

            if ($result) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Không thể cập nhật trạng thái");
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        exit();
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

    public static function printInvoiceController()
    {
        try {
            if (isset($_GET['id'])) {
                self::init();
                $order = self::$orderModel->getOrderById($_GET['id']);

                // Kiểm tra trạng thái đơn hàng
                $allowedStatuses = ['confirmed', 'processing', 'shipping', 'delivered'];

                if ($order && in_array($order['status'], $allowedStatuses)) {
                    $orderDetails = self::$orderModel->getOrderDetails($order['order_id']);
                    require_once './views/order/print-invoice.php';
                } else {
                    $_SESSION['error'] = "Không thể in hóa đơn cho đơn hàng này";
                    header("Location: index.php?action=order");
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=order');
            exit();
        }
    }

    public static function handleReturnRequestController()
    {
        try {
            if (!isset($_POST['order_id']) || !isset($_POST['status']) || !isset($_POST['admin_note'])) {
                throw new Exception("Thiếu thông tin cần thiết");
            }

            self::init();
            $orderId = (int)$_POST['order_id'];
            $status = $_POST['status'] === 'approve' ? 'returned' : 'cancelled';
            $adminNote = $_POST['admin_note'];

            $result = self::$orderModel->handleReturnRequest($orderId, $status, $adminNote);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Đã xử lý yêu cầu trả hàng thành công']);
            } else {
                throw new Exception("Không thể xử lý yêu cầu trả hàng");
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit();
    }
}
