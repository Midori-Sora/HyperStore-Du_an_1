<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận thanh toán</title>
    <link rel="stylesheet" href="assets/css/client/payment.css">
</head>

<body>
    <?php require_once "client/views/layout/header.php"; ?>

    <div class="payment-container">
        <div class="payment-info">
            <h2>Thông tin thanh toán</h2>

            <div class="order-info">
                <p>Mã đơn hàng: <strong><?= $_SESSION['pending_order']['order_id'] ?></strong></p>
                <p>Số tiền:
                    <strong><?= number_format($_SESSION['pending_order']['total_amount'], 0, ',', '.') ?>đ</strong></p>
            </div>

            <div class="bank-info">
                <h3>Thông tin chuyển khoản</h3>
                <p>Ngân hàng: <strong><?= $_SESSION['pending_order']['bank_info']['name'] ?></strong></p>
                <p>Số tài khoản: <strong><?= $_SESSION['pending_order']['bank_info']['account_number'] ?></strong></p>
                <p>Tên tài khoản: <strong><?= $_SESSION['pending_order']['bank_info']['account_name'] ?></strong></p>
                <p>Chi nhánh: <?= $_SESSION['pending_order']['bank_info']['branch'] ?></p>
            </div>

            <div class="payment-note">
                <h3>Nội dung chuyển khoản</h3>
                <p class="transfer-content">DH<?= $_SESSION['pending_order']['order_id'] ?></p>
                <button class="copy-btn" onclick="copyContent()">Sao chép</button>
            </div>

            <div class="payment-steps">
                <h3>Hướng dẫn thanh toán</h3>
                <ol>
                    <li>Sao chép thông tin chuyển khoản</li>
                    <li>Mở ứng dụng ngân hàng của bạn</li>
                    <li>Thực hiện chuyển khoản theo thông tin bên trên</li>
                    <li>Đơn hàng sẽ được xử lý sau khi nhận được thanh toán</li>
                </ol>
            </div>

            <div class="buttons">
                <a href="index.php?action=order-detail&id=<?= $_SESSION['pending_order']['order_id'] ?>" class="btn">
                    Xem đơn hàng
                </a>
                <a href="index.php" class="btn btn-home">Về trang chủ</a>
            </div>
        </div>
    </div>

    <script>
    function copyContent() {
        const content = document.querySelector('.transfer-content').textContent;
        navigator.clipboard.writeText(content).then(() => {
            alert('Đã sao chép nội dung chuyển khoản!');
        });
    }
    </script>

    <?php require_once "client/views/layout/footer.php"; ?>
</body>

</html>