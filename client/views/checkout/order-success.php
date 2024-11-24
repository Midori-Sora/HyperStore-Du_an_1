<?php
if (!isset($_SESSION['success'])) {
    header('Location: index.php');
    exit();
}
$successMessage = $_SESSION['success'];
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link rel="stylesheet" href="assets/css/client/checkout.css">
</head>

<body>
    <?php require_once "client/views/layout/header.php"; ?>

    <div class="order-success-container">
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <h2>Đặt hàng thành công!</h2>
            <p><?= htmlspecialchars($successMessage) ?></p>
        </div>

        <div class="next-steps">
            <a href="index.php?action=orders" class="btn primary">Xem đơn hàng của tôi</a>
            <a href="index.php" class="btn secondary">Tiếp tục mua sắm</a>
        </div>
    </div>

    <?php require_once "client/views/layout/footer.php"; ?>
</body>

</html>