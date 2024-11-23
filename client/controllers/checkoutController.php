<?php
require_once "client/models/checkoutModel.php";

class CheckoutController
{
    private $checkoutModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
    }

    public function checkout()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục thanh toán';
            header('Location: index.php?action=login');
            exit();
        }

        $selectedProducts = [];
        $totalAmount = 0;

        if (isset($_POST['selected_products'])) {
            foreach ($_POST['selected_products'] as $productId) {
                $product = $this->checkoutModel->getProductDetails($productId);
                if ($product) {
                    // Lấy số lượng từ form nếu có (trường hợp mua ngay)
                    if (isset($_POST['quantities'][$productId])) {
                        $product['quantity'] = $_POST['quantities'][$productId];
                    }
                    $selectedProducts[] = $product;
                    $totalAmount += $product['price'] * $product['quantity'];
                }
            }
        }

        // Lấy địa chỉ người dùng
        $userAddress = $this->checkoutModel->getUserAddress($_SESSION['user_id']);

        // Hiển thị trang thanh toán
        require_once 'client/views/checkout/checkout.php';
    }
}
