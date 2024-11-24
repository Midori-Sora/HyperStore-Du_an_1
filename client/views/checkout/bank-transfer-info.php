<?php
// Kiểm tra session
if (!isset($_SESSION['bank_transfer_info'])) {
    header('Location: index.php?action=checkout');
    exit();
}

// Debug session data
error_log('Bank transfer info: ' . print_r($_SESSION['bank_transfer_info'], true));

// Lấy thông tin từ session
$bankInfo = $_SESSION['bank_transfer_info']['bankInfo'] ?? null;
$amount = $_SESSION['bank_transfer_info']['amount'] ?? 0;
$transactionCode = $_SESSION['bank_transfer_info']['transactionCode'] ?? '';
$orderId = $_SESSION['bank_transfer_info']['orderId'] ?? null;

// Kiểm tra dữ liệu bắt buộc
if (!$bankInfo || !$orderId) {
    $_SESSION['error'] = 'Thông tin thanh toán không hợp lệ';
    header('Location: index.php?action=checkout');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin chuyển khoản</title>
    <link rel="stylesheet" href="assets/css/client/style.css">
</head>

<body>
    <?php require_once "client/views/layout/header.php"; ?>

    <div class="container">
        <h1 class="page-title">Thông tin chuyển khoản</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error'] ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="bank-info">
            <p><strong>Ngân hàng:</strong> <?= htmlspecialchars($bankInfo['name']) ?></p>
            <p><strong>Số tài khoản:</strong> <?= htmlspecialchars($bankInfo['account_number']) ?></p>
            <p><strong>Chủ tài khoản:</strong> <?= htmlspecialchars($bankInfo['account_name']) ?></p>
            <p><strong>Chi nhánh:</strong> <?= htmlspecialchars($bankInfo['branch']) ?></p>
            <p><strong>Số tiền cần chuyển:</strong> <?= number_format($amount, 0, ',', '.') ?>đ</p>
            <p><strong>Nội dung chuyển khoản:</strong> <?= htmlspecialchars($transactionCode) ?></p>
        </div>

        <div class="notice">
            <p>* Vui lòng chuyển khoản chính xác số tiền và nội dung chuyển khoản</p>
            <p>* Đơn hàng sẽ được xử lý sau khi chúng tôi nhận được tiền</p>
            <p>* Thời gian xử lý có thể mất từ 5-15 phút sau khi chuyển khoản</p>
        </div>

        <div class="actions">
            <form action="index.php?action=confirm-payment" method="POST" class="confirm-form">
                <input type="hidden" name="order_id" value="<?= $orderId ?>">
                <input type="hidden" name="transaction_code" value="<?= $transactionCode ?>">
                <input type="hidden" name="confirm_payment" value="1">
                <button type="submit" class="btn btn-primary">Tôi đã chuyển khoản</button>
            </form>
            <a href="index.php?action=orders" class="btn btn-secondary">Xem đơn hàng của tôi</a>
        </div>

        <div class="notice-footer">
            <p>* Vui lòng nhấn "Tôi đã chuyển khoản" sau khi bạn đã hoàn tất việc chuyển tiền</p>
            <p>* Đơn hàng của bạn sẽ được xử lý sau khi chúng tôi xác nhận được thanh toán</p>
        </div>
    </div>

    <?php require_once "client/views/layout/footer.php"; ?>

    <script>
        // Thêm JavaScript để xử lý form submit
        document.querySelector('.confirm-form').addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Bạn xác nhận đã chuyển khoản?')) {
                this.submit();
            }
        });
    </script>
</body>

</html>