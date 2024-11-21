<?php
require_once "client/models/cartModel.php";

class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            $userId = $_SESSION['user_id'] ?? 0;

            if (!$userId) {
                $_SESSION['error'] = "Vui lòng đăng nhập để thêm vào giỏ hàng";
                header('Location: index.php?action=login');
                exit;
            }

            if ($userId && $productId) {
                $result = $this->cartModel->addToCart($userId, $productId, $quantity);
                if ($result) {
                    $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ hàng";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại";
                }
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;
            $userId = $_SESSION['user_id'] ?? 0;

            if ($userId && $productId) {
                $result = $this->cartModel->updateQuantity($userId, $productId, $quantity);
                echo json_encode(['success' => $result]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
    }

    public function removeFromCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $userId = $_SESSION['user_id'] ?? 0;

            if ($userId && $productId) {
                $result = $this->cartModel->removeFromCart($userId, $productId);
                echo json_encode(['success' => $result]);
                exit;
            }
        }
        echo json_encode(['success' => false]);
    }

    public function getCartItems()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if ($userId) {
            $items = $this->cartModel->getCartItems($userId);
            $total = $this->cartModel->getCartTotal($userId);
            echo json_encode([
                'items' => $items,
                'total' => $total
            ]);
            exit;
        }
        echo json_encode(['items' => [], 'total' => 0]);
    }

    public function viewCart()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        if (!$userId) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xem giỏ hàng";
            header('Location: index.php?action=login');
            exit;
        }

        $items = $this->cartModel->getCartItems($userId);
        $total = $this->cartModel->getCartTotal($userId);

        // Load view giỏ hàng
        require_once "client/views/cart/cart.php";
    }

    public function index()
    {
        $cart_items = $this->cartModel->getCartItems($_SESSION['user_id']);

        // Đảm bảo $cart_items là array
        if (!is_array($cart_items)) {
            $cart_items = [];
        }

        $total = $this->cartModel->getCartTotal($_SESSION['user_id']);

        // Truyền dữ liệu sang view
        require_once 'client/views/cart/cart.php';
    }
}
