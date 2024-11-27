<?php
require_once "client/models/cartModel.php";

class CartController
{
    public static function addToCart()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng';
            header('Location: index.php?action=login');
            exit();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $product_id = $_POST['product_id'] ?? '';
        $quantity = $_POST['quantity'] ?? 1;

        if ($product_id) {
            $cart_model = new CartModel();
            $product = $cart_model->getProductById($product_id);

            if ($product) {
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
                $_SESSION['global_success'] = 'Đã thêm sản phẩm ' . $product['pro_name'] . ' vào giỏ hàng';
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public static function viewCart()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem giỏ hàng';
            header('Location: index.php?action=login');
            exit();
        }

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
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thực hiện thao tác này';
            header('Location: index.php?action=login');
            exit();
        }

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
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thực hiện thao tác này';
            header('Location: index.php?action=login');
            exit();
        }

        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        $action = $_POST['quantity_action'];

        if (isset($_SESSION['cart'][$product_id])) {
            $current_quantity = $_SESSION['cart'][$product_id];

            if ($action === 'increase') {
                $_SESSION['cart'][$product_id] = min(99, $current_quantity + 1);
            } else if ($action === 'decrease' && $current_quantity > 1) {
                $_SESSION['cart'][$product_id] = max(1, $current_quantity - 1);
            }
        }

        header('Location: index.php?action=view-cart');
        exit();
    }

    public static function checkout()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thanh toán';
            header('Location: index.php?action=login');
            exit();
        }

        // Xử lý thanh toán ở đây
        // ...

        // Sau khi thanh toán thành công
        $cart_model = new CartModel();
        $cart_model->clearCart(); // Xóa giỏ hàng

        $_SESSION['success'] = 'Đặt hàng thành công';
        header('Location: index.php?action=order-success');
        exit();
    }
}