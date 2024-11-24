<?php
require_once "client/commons/function.php";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="assets/css/client/order.css">
</head>

<body>
    <?php require_once "client/views/layout/header.php"; ?>

    <div class="order-container">
        <h2>Đơn hàng của tôi</h2>

        <?php if (empty($orders)): ?>
            <div class="empty-orders">
                <img src="assets/images/empty-order.png" alt="Không có đơn hàng">
                <p>Bạn chưa có đơn hàng nào</p>
                <a href="index.php?action=product" class="btn">Mua sắm ngay</a>
            </div>
        <?php else: ?>
            <div class="order-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-item">
                        <div class="order-header">
                            <div class="order-info">
                                <span>Mã đơn: <?= $order['order_code'] ?></span>
                                <span>Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                            </div>
                            <div class="order-status" data-status="<?= $order['status'] ?>">
                                <?= getOrderStatus($order['status']) ?>
                            </div>
                        </div>
                        <div class="order-content">
                            <?php if (!empty($order['product_image'])): ?>
                                <img src="<?= htmlspecialchars($order['product_image']) ?>" alt="Sản phẩm">
                            <?php else: ?>
                                <img src="assets/images/default-product.png" alt="Sản phẩm mặc định">
                            <?php endif; ?>
                            <div class="order-info">
                                <p>Mã đơn: <?= htmlspecialchars($order['order_code']) ?></p>
                                <p><?= $order['total_items'] ?> sản phẩm</p>
                                <p class="total">Tổng tiền: <?= number_format($order['total_amount']) ?>đ</p>
                            </div>
                        </div>
                        <div class="order-footer">
                            <a href="index.php?action=order-detail&id=<?= htmlspecialchars($order['order_id']) ?>" class="btn">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php require_once "client/views/layout/footer.php"; ?>
</body>

</html>