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
            <p>Ngày đặt: <?= OrderHelper::formatOrderDate($order['created_at']) ?></p>
            <p>Trạng thái:
                <span class="order-status <?= OrderHelper::getOrderStatusClass($order['status']) ?>">
                    <?= OrderHelper::getOrderStatus($order['status']) ?>
                </span>
            </p>
            <p>Người nhận: <?= htmlspecialchars($order['receiver_name']) ?></p>
            <p>Địa chỉ: <?= htmlspecialchars($order['shipping_address']) ?></p>
            <p>Số điện thoại: <?= htmlspecialchars($order['shipping_phone']) ?></p>
            <?php if (OrderHelper::canCancelOrder($order['status'])): ?>
                <button onclick="cancelOrder(<?= $order['order_id'] ?>)" class="btn btn-cancel">
                    Hủy đơn hàng
                </button>
            <?php endif; ?>
        </div>

        <div class="order-items">
            <?php foreach ($orderDetails as $item): ?>
                <div class="order-item">
                    <img src="Uploads/Product/<?= htmlspecialchars($item['product_image']) ?>"
                        alt="<?= htmlspecialchars($item['pro_name']) ?>">
                    <div class="item-info">
                        <h3><?= htmlspecialchars($item['pro_name']) ?></h3>

                        <div class="product-variants">
                            <?php if ($item['color_type']): ?>
                                <span class="variant color">
                                    <i class="fas fa-palette"></i>
                                    <?= htmlspecialchars($item['color_type']) ?>
                                    <?php if ($item['color_price'] > 0): ?>
                                        <span class="price-diff">+<?= number_format($item['color_price'], 0, ',', '.') ?>₫</span>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>

                            <?php if ($item['storage_type']): ?>
                                <span class="variant storage">
                                    <i class="fas fa-memory"></i>
                                    <?= htmlspecialchars($item['storage_type']) ?>
                                    <?php if ($item['storage_price'] > 0): ?>
                                        <span class="price-diff">+<?= number_format($item['storage_price'], 0, ',', '.') ?>₫</span>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <p class="product-quantity">x<?= $item['quantity'] ?></p>
                        <div class="product-price">
                            <?php if (isset($item['current_discount']) && $item['current_discount'] > 0): ?>
                                <span class="original-price"><?= number_format($item['final_price'], 0, ',', '.') ?>₫</span>
                                <span class="discounted-price">
                                    <?= number_format($item['final_price'] * (1 - $item['current_discount'] / 100), 0, ',', '.') ?>₫
                                </span>
                            <?php else: ?>
                                <span class="final-price"><?= number_format($item['final_price'], 0, ',', '.') ?>₫</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="order-summary">
            <p>Tổng tiền: <?= OrderHelper::formatCurrency($order['total_amount']) ?></p>
        </div>
    </div>

    <?php require_once "client/views/layout/footer.php"; ?>

    <script>
        function cancelOrder(orderId) {
            if (!confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
                return;
            }

            fetch('index.php?action=cancel-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'order_id=' + orderId
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        window.location.href = 'index.php?action=orders';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã có lỗi xảy ra');
                });
        }
    </script>
</body>

</html>