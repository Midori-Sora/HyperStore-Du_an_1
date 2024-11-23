<?php
require_once "client/models/cartModel.php";

class CartController
{
    public static function addToCart()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $product_id = $_POST['product_id'] ?? '';
        $quantity = $_POST['quantity'] ?? 1;

        if ($product_id) {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public static function viewCart()
    {
        $cart_items = [];
        $total = 0;

        if (isset($_SESSION['cart'])) {
            $cart_model = new CartModel();
            $cart_data = $cart_model->getCartItems($_SESSION['cart']);
            $cart_items = $cart_data['items'];
            $total = $cart_data['total'];
        }

        require_once "client/views/cart/cart.php";
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     * @return void
     */
    public static function removeFromCart()
    {
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);

        if (!$product_id) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm cần xóa';
            header('Location: index.php?action=view-cart');
            exit();
        }

        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng';
        }

        header('Location: index.php?action=view-cart');
        exit();
    }

    public static function updateQuantity()
    {
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        $action = $_POST['quantity_action']; // 'increase' hoặc 'decrease'

        if (isset($_SESSION['cart'][$product_id])) {
            if ($action === 'increase') {
                $_SESSION['cart'][$product_id] = min(99, $_SESSION['cart'][$product_id] + 1);
            } else if ($action === 'decrease') {
                $_SESSION['cart'][$product_id] = max(1, $_SESSION['cart'][$product_id] - 1);
            }
        }

        header('Location: index.php?action=view-cart');
        exit();
    }
}