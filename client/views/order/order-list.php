<?php
require_once "client/commons/orderHelper.php";
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

        <!-- Thêm tabs -->
        <div class="order-tabs">
            <button class="order-tab active" data-status="all">Tất cả</button>
            <button class="order-tab" data-status="pending">Chờ xác nhận</button>
            <button class="order-tab" data-status="confirmed">Đã xác nhận</button>
            <button class="order-tab" data-status="processing">Đang xử lý</button>
            <button class="order-tab" data-status="shipping">Đang giao</button>
            <button class="order-tab" data-status="delivered">Đã giao</button>
            <button class="order-tab" data-status="returned">Trả hàng</button>
            <button class="order-tab" data-status="refunded">Hoàn tiền</button>
            <button class="order-tab" data-status="cancelled">Đã hủy</button>
        </div>

        <?php if (empty($orders)): ?>
            <div class="empty-orders">
                <img src="assets/images/empty-order.png" alt="Không có đơn hàng">
                <p>Bạn chưa có đơn hàng nào</p>
                <a href="index.php?action=product" class="btn btn-primary">Mua sắm ngay</a>
            </div>
        <?php else: ?>
            <div class="order-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-item" data-status="<?= $order['status'] ?>">
                        <div class="order-header">
                            <div>
                                <span class="order-code">#<?= $order['order_code'] ?></span>
                                <span class="order-date">
                                    <i class="fas fa-calendar-alt"></i>
                                    <?= OrderHelper::formatOrderDate($order['created_at']) ?>
                                </span>
                            </div>
                            <span class="order-status <?= OrderHelper::getOrderStatusClass($order['status']) ?>">
                                <?= OrderHelper::getOrderStatus($order['status']) ?>
                            </span>
                        </div>
                        <div class="order-content">
                            <?php if (!empty($order['product_image'])): ?>
                                <img src="<?= htmlspecialchars($order['product_image']) ?>" alt="Sản phẩm">
                            <?php else: ?>
                                <img src="assets/images/default-product.png" alt="Sản phẩm mặc định">
                            <?php endif; ?>
                            <div class="order-info">
                                <h3><?= htmlspecialchars($order['pro_name']) ?></h3>
                                <?php if ($order['color_type'] || $order['storage_type']): ?>
                                    <div class="product-variants">
                                        <?php if ($order['color_type']): ?>
                                            <span class="variant color">
                                                <i class="fas fa-palette"></i> <?= htmlspecialchars($order['color_type']) ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($order['storage_type']): ?>
                                            <span class="variant storage">
                                                <i class="fas fa-memory"></i> <?= htmlspecialchars($order['storage_type']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <p><?= $order['total_items'] ?> sản phẩm</p>
                                <p class="total">
                                    <?= OrderHelper::formatCurrency($order['total_amount']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="order-footer">
                            <a href="index.php?action=order-detail&id=<?= htmlspecialchars($order['order_id']) ?>"
                                class="btn btn-detail">
                                Xem chi tiết
                            </a>
                            <?php if (OrderHelper::canCancelOrder($order['status'])): ?>
                                <button onclick="cancelOrder(<?= $order['order_id'] ?>)" class="btn btn-cancel">
                                    Hủy đơn hàng
                                </button>
                            <?php endif; ?>
                            <?php if ($order['status'] === 'delivered'): ?>
                                <button class="btn btn-primary" onclick="confirmReturn('<?= $order['order_id'] ?>')">
                                    Yêu cầu trả hàng
                                </button>
                            <?php elseif ($order['status'] === 'returned'): ?>
                                <div class="alert alert-info">
                                    Vui lòng đợi xác nhận từ người bán
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã có lỗi xảy ra');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.order-tab');
            const orders = document.querySelectorAll('.order-item');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    tab.classList.add('active');

                    const status = tab.dataset.status;

                    // Show/hide orders based on status
                    orders.forEach(order => {
                        if (status === 'all' || order.dataset.status === status) {
                            order.style.display = 'block';
                        } else {
                            order.style.display = 'none';
                        }
                    });
                });
            });
        });

        function confirmReturn(orderId) {
            const reason = prompt('Vui lòng nhập lý do trả hàng:');
            if (!reason) return;

            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('reason', reason);

            fetch('index.php?action=request-return', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Yêu cầu trả hàng đã được gửi. Vui lòng đợi xác nhận từ người bán');
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã có lỗi xảy ra');
                });
        }

        function closeModal() {
            document.getElementById('returnModal').style.display = 'none';
        }

        function submitReturn(orderId) {
            const reason = document.getElementById('returnReason').value;
            if (!reason) {
                alert('Vui lòng nhập lý do trả hàng');
                return;
            }

            const formData = new FormData();
            formData.append('order_id', orderId);
            formData.append('reason', reason);

            fetch('index.php?action=request-return', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã có lỗi xảy ra');
                });
        }
    </script>

    <!-- Thêm modal -->
    <div id="returnModal" class="modal">
        <div class="modal-content">
            <h3>Yêu cầu trả hàng</h3>
            <form id="returnForm">
                <textarea id="returnReason" placeholder="Nhập lý do trả hàng..." required></textarea>
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Hủy</button>
                </div>
            </form>
        </div>
    </div>


</body>

</html>