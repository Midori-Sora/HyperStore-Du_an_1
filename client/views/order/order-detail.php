<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="assets/css/client/order.css">
</head>

<body>
    <?php require_once "client/views/layout/header.php"; ?>

    <div class="order-detail-container">
        <h2>Chi tiết đơn hàng #<?= htmlspecialchars($order['order_code']) ?></h2>

        <div class="order-info">
            <p>Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
            <p>Trạng thái: <?= getOrderStatus($order['status']) ?></p>
            <p>Người nhận: <?= htmlspecialchars($order['receiver_name']) ?></p>
            <p>Địa chỉ: <?= htmlspecialchars($order['shipping_address']) ?></p>
            <p>Số điện thoại: <?= htmlspecialchars($order['shipping_phone']) ?></p>
        </div>

        <div class="order-items">
            <?php foreach ($orderDetails as $item): ?>
                <div class="order-item">
                    <img src="Uploads/Product/<?= htmlspecialchars($item['product_image']) ?>"
                        alt="<?= htmlspecialchars($item['pro_name']) ?>">
                    <div class="item-info">
                        <h3><?= htmlspecialchars($item['pro_name']) ?></h3>
                        <p>Số lượng: <?= $item['quantity'] ?></p>
                        <p>Đơn giá: <?= number_format($item['price']) ?>đ</p>
                        <?php if (!empty($item['color_type'])): ?>
                            <p>Màu: <?= htmlspecialchars($item['color_type']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($item['storage_type'])): ?>
                            <p>Bộ nhớ: <?= htmlspecialchars($item['storage_type']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="order-summary">
            <p>Tổng tiền: <?= number_format($order['total_amount']) ?>đ</p>
        </div>
    </div>

    <?php require_once "client/views/layout/footer.php"; ?>
</body>

</html>