<?php
class CheckoutController
{
    private $checkoutModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
    }

    public function checkout()
    {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục thanh toán';
            header('Location: index.php?action=login');
            exit();
        }

        $selectedProducts = [];
        $totalAmount = 0;

        // Xử lý khi mua ngay
        if (isset($_POST['buy_now']) && isset($_POST['selected_products'])) {
            foreach ($_POST['selected_products'] as $productId) {
                $product = $this->checkoutModel->getProductDetails($productId);
                if ($product) {
                    $quantity = isset($_POST['quantities'][$productId]) ? (int)$_POST['quantities'][$productId] : 1;
                    $product['quantity'] = $quantity;
                    $selectedProducts[] = $product;

                    // Tính tổng tiền
                    if (isset($product['current_discount']) && $product['current_discount'] > 0) {
                        $price = $product['price'] * (1 - $product['current_discount'] / 100);
                    } else {
                        $price = $product['price'];
                    }
                    $totalAmount += $price * $quantity;
                }
            }
        }
        // Xử lý khi mua từ giỏ hàng (giữ nguyên code cũ)
        else if (isset($_POST['selected_products']) && is_array($_POST['selected_products'])) {
            foreach ($_POST['selected_products'] as $productId) {
                $product = $this->checkoutModel->getProductDetails($productId);
                if ($product) {
                    // Lấy số lượng từ form POST
                    $quantity = isset($_POST['quantities'][$productId]) ?
                        (int)$_POST['quantities'][$productId] : (isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId] : 1);

                    $product['quantity'] = $quantity;
                    $selectedProducts[] = $product;

                    // Tính tổng tiền
                    if (isset($product['current_discount']) && $product['current_discount'] > 0) {
                        $price = $product['price'] * (1 - $product['current_discount'] / 100);
                    } else {
                        $price = $product['price'];
                    }
                    $totalAmount += $price * $quantity;
                }
            }
        }

        if (empty($selectedProducts)) {
            $_SESSION['error'] = 'Không có sản phẩm nào được chọn';
            header('Location: index.php?action=view-cart');
            exit();
        }

        $userAddress = $this->checkoutModel->getUserAddress($_SESSION['user_id']);
        require_once 'client/views/checkout/checkout.php';
    }

    public function processPayment()
    {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception('Vui lòng đăng nhập để thanh toán');
            }

            // Validate input
            if (empty($_POST['products'])) {
                throw new Exception('Giỏ hàng trống');
            }

            $this->checkoutModel->beginTransaction();

            // Get user info
            $userAddress = $this->checkoutModel->getUserAddress($_SESSION['user_id']);
            if (!$userAddress) {
                throw new Exception('Không tìm thấy thông tin địa chỉ');
            }

            // Create order
            $orderData = [
                'user_id' => $_SESSION['user_id'],
                'total_amount' => floatval($_POST['total_amount']),
                'shipping_address' => $userAddress['address'],
                'payment_method' => $_POST['payment_method'],
                'receiver_name' => $userAddress['receiver_name'],
                'shipping_phone' => $userAddress['phone'],
                'shipping_email' => $_SESSION['user_email'] ?? null,
                'bank_code' => $_POST['bank_code'] ?? null,
                'status' => '1',
                'payment_status' => 'unpaid',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $orderId = $this->checkoutModel->createOrder($orderData);
            if (!$orderId) {
                throw new Exception('Không thể tạo đơn hàng');
            }

            // Process products and remove from cart
            $purchasedProducts = [];
            foreach ($_POST['products'] as $productJson) {
                $product = json_decode($productJson, true);
                if (!$product) {
                    throw new Exception('Dữ liệu sản phẩm không hợp lệ');
                }

                $this->checkoutModel->addOrderDetails($orderId, $product['id'], $product['quantity'], $product['price']);
                $this->checkoutModel->updateProductQuantity($product['id'], $product['quantity']);
                $purchasedProducts[] = $product['id'];
            }

            // Xóa sản phẩm đã mua khỏi giỏ hàng
            if (!empty($purchasedProducts)) {
                $cartModel = new CartModel();
                $cartModel->clearCart($purchasedProducts);
            }

            // Process payment based on method
            switch ($_POST['payment_method']) {
                case 'bank_transfer':
                    $bankCode = $_POST['bank_code'] ?? '';
                    if (empty($bankCode)) {
                        throw new Exception('Vui lòng chọn ngân hàng');
                    }
                    $this->processBankTransfer($orderId, $orderData['total_amount'], $bankCode);
                    break;
                case 'momo':
                    $this->processMomoPayment($orderId, $orderData['total_amount']);
                    break;
                case 'zalopay':
                    $this->processZaloPayment($orderId, $orderData['total_amount']);
                    break;
                case 'cod':
                    $this->checkoutModel->updateOrderStatus($orderId, 'pending', 'unpaid');
                    $_SESSION['success'] = 'Đặt hàng thành công';
                    header('Location: index.php?action=order-success');
                    break;
            }

            $this->checkoutModel->commit();
            exit();
        } catch (Exception $e) {
            $this->checkoutModel->rollback();
            error_log('Payment error: ' . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?action=checkout');
            exit();
        }
    }

    private function processMomoPayment($orderId, $amount)
    {
        try {
            $transactionCode = 'MOMO' . time() . $orderId;

            // Cập nhật trạng thái đơn hàng
            $this->checkoutModel->updateOrderStatus($orderId, 'pending');

            // Cập nhật phương thức thanh toán
            $this->checkoutModel->updatePaymentMethod($orderId, 'momo');

            // Lưu thông tin giao dịch
            $this->checkoutModel->saveTransaction($orderId, $transactionCode, $amount, 'momo');

            // Lưu thông tin vào session
            $_SESSION['bank_transfer_info'] = [
                'bankInfo' => [
                    'name' => 'MoMo',
                    'account_number' => '0355032605',
                    'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                    'branch' => 'Ví điện tử MoMo'
                ],
                'amount' => $amount,
                'transactionCode' => $transactionCode,
                'orderId' => $orderId
            ];

            header('Location: index.php?action=bank-transfer-info');
            exit();
        } catch (Exception $e) {
            error_log('MoMo payment error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function processZaloPayment($orderId, $amount)
    {
        try {
            $transactionCode = 'ZALO' . time() . $orderId;

            // Cập nhật trạng thái đơn hàng
            $this->checkoutModel->updateOrderStatus($orderId, 'pending');

            // Cập nhật phương thức thanh toán
            $this->checkoutModel->updatePaymentMethod($orderId, 'zalopay');

            // Lưu thông tin giao dịch
            $this->checkoutModel->saveTransaction($orderId, $transactionCode, $amount, 'zalopay');

            // Lưu thông tin vào session
            $_SESSION['bank_transfer_info'] = [
                'bankInfo' => [
                    'name' => 'ZaloPay',
                    'account_number' => '0355032605',
                    'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                    'branch' => 'Ví điện tử ZaloPay'
                ],
                'amount' => $amount,
                'transactionCode' => $transactionCode,
                'orderId' => $orderId
            ];

            header('Location: index.php?action=bank-transfer-info');
            exit();
        } catch (Exception $e) {
            error_log('ZaloPay payment error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function processBankTransfer($orderId, $amount, $bankCode)
    {
        try {
            error_log("Processing bank transfer for order: " . $orderId);

            $transactionCode = 'BANK' . time() . $orderId;

            // Cập nhật trạng thái đơn hàng
            $this->checkoutModel->updateOrderStatus($orderId, 'pending');

            // Cập nhật phương thức thanh toán
            $this->checkoutModel->updatePaymentMethod($orderId, 'bank_transfer');

            // Log payment
            $this->checkoutModel->logPayment(
                $orderId,
                'bank_transfer',
                'pending',
                'Chờ khách hàng chuyển khoản'
            );

            // Lưu thông tin vào session
            $_SESSION['bank_transfer_info'] = [
                'bankInfo' => $this->getBankInfo($bankCode),
                'amount' => $amount,
                'transactionCode' => $transactionCode,
                'orderId' => $orderId
            ];

            header('Location: index.php?action=bank-transfer-info');
            exit();
        } catch (Exception $e) {
            error_log('Bank transfer error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getBankInfo($bankCode)
    {
        $banks = [
            'vietcombank' => [
                'name' => 'Vietcombank',
                'account_number' => '1234567890',
                'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                'branch' => 'Chi nhánh Bà Rịa - Vũng Tàu'
            ],
            'techcombank' => [
                'name' => 'Techcombank',
                'account_number' => '0987654321',
                'account_name' => 'CONG TY TNHH CONG NGHE REALTECH',
                'branch' => 'Chi nhánh Bà Rịa - Vũng Tàu'
            ]
        ];
        return $banks[$bankCode] ?? $banks['vietcombank'];
    }

    public function handlePaymentCallback()
    {
        try {
            $paymentType = $_GET['type'] ?? '';
            $orderId = $_GET['orderId'] ?? '';
            $orderInfo = $this->checkoutModel->getOrderById($orderId);
            if (empty($paymentType) || empty($orderId)) {
                throw new Exception('Thiếu thông tin thanh toán');
            }

            // Cập nhật trạng thái đơn hàng
            $this->checkoutModel->updateOrderStatus($orderId, 'pending', 'unpaid');

            $_SESSION['success'] = 'Đơn hàng đã được tạo thành công';
            header('Location: index.php?action=order-success');
        } catch (Exception $e) {
            error_log('Payment callback error: ' . $e->getMessage());
            $_SESSION['error'] = 'Có lỗi xảy ra trong quá trình thanh toán';
            header('Location: index.php?action=checkout');
        }
        exit();
    }

    public function confirmPayment()
    {
        try {
            if (!isset($_POST['confirm_payment']) || !isset($_POST['order_id']) || !isset($_POST['transaction_code'])) {
                throw new Exception('Thiếu thông tin xác nhận thanh toán');
            }

            $orderId = intval($_POST['order_id']);
            $transactionCode = $_POST['transaction_code'];

            // Debug
            error_log("Confirming payment for order: " . $orderId);
            error_log("Transaction code: " . $transactionCode);

            $this->checkoutModel->beginTransaction();

            // Kiểm tra đơn hàng tồn tại
            $order = $this->checkoutModel->getOrderById($orderId);
            error_log("Order data: " . print_r($order, true));

            if (!$order) {
                throw new Exception('Không tìm thấy đơn hàng');
            }

            // Cập nhật trạng thái đơn hàng (2 = đang xử lý)
            $this->checkoutModel->updateOrderStatus($orderId, '2');
            $this->checkoutModel->updatePaymentStatus($orderId, 'pending_verification');

            // Lưu log xác nhận thanh toán
            $this->checkoutModel->logPaymentConfirmation($orderId, $transactionCode);

            // Sau khi xác nhận thanh toán thành công
            if ($orderId) {
                // Lấy thông tin đơn hàng và xóa sản phẩm khỏi giỏ hàng
                $orderItems = $this->checkoutModel->getOrderItems($orderId);
                $productIds = array_column($orderItems, 'product_id');

                $cartModel = new CartModel();
                $cartModel->clearCart($productIds);
            }

            $this->checkoutModel->commit();

            unset($_SESSION['bank_transfer_info']);
            $_SESSION['success'] = 'Xác nhận thanh toán thành công!';

            header('Location: index.php?action=order-success');
            exit();
        } catch (Exception $e) {
            $this->checkoutModel->rollback();
            error_log('Payment confirmation error: ' . $e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?action=bank-transfer-info');
            exit();
        }
    }

    public function updateShippingAddress()
    {
        ob_clean();
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Vui lòng đăng nhập để cập nhật địa chỉ");
            }

            $data = [
                'receiver_name' => trim($_POST['receiver_name'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'user_id' => $_SESSION['user_id']
            ];

            if (empty($data['receiver_name']) || empty($data['phone']) || empty($data['address'])) {
                throw new Exception("Vui lòng điền đầy đủ thông tin");
            }

            $success = $this->checkoutModel->updateShippingAddress($data);

            if ($success) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cập nhật địa chỉ thành công',
                    'data' => [
                        'receiver_name' => $data['receiver_name'],
                        'phone' => $data['phone'],
                        'address' => $data['address']
                    ]
                ], JSON_UNESCAPED_UNICODE);
            } else {
                throw new Exception("Cập nhật địa chỉ thất bại");
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}
