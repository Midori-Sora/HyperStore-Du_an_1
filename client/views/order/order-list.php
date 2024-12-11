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

                <h3>Chưa có đơn hàng nào</h3>
                <p>Hãy khám phá các sản phẩm và đặt hàng ngay!</p>
                <a href="index.php?action=product" class="btn btn-primary">Mua sắm ngay</a>
            </div>
        <?php else: ?>
            <div class="order-list">
                <?php foreach ($orders as $order): ?>
                    <div class="order-item" data-status="<?= $order['status'] ?>" data-order-id="<?= $order['order_id'] ?>">
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
                                <?php
                                $remainingDays = OrderHelper::getRemainingReturnDays($order['updated_at']);
                                if ($remainingDays > 0):
                                ?>
                                    <button class="btn btn-primary" onclick="confirmReturn('<?= $order['order_id'] ?>')">
                                        Yêu cầu trả hàng (còn <?= $remainingDays ?> ngày)
                                    </button>
                                <?php endif; ?>
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
                        alert('Yêu cầu trả hàng đã được gửi thành công');
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

        let pollingInterval;

        function startOrdersPolling() {
            const orderItems = document.querySelectorAll('.order-item');
            const orderIds = Array.from(orderItems).map(item => item.dataset.orderId);

            pollingInterval = setInterval(() => {
                orderIds.forEach(orderId => {
                    fetch(`index.php?action=checkOrderStatus&orderId=${orderId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const orderItem = document.querySelector(
                                    `.order-item[data-order-id="${orderId}"]`);
                                if (orderItem) {
                                    // Cập nhật trạng thái
                                    const statusElement = orderItem.querySelector('.order-status');
                                    if (statusElement) {
                                        statusElement.textContent = data.statusText;
                                        statusElement.className = `order-status ${data.statusClass}`;
                                    }

                                    // Cập nhật footer với các nút hành động
                                    const footer = orderItem.querySelector('.order-footer');
                                    const existingCancelButton = footer.querySelector('.btn-cancel');
                                    const existingReturnButton = footer.querySelector('.btn-primary');

                                    // Xóa các nút cũ
                                    if (existingCancelButton) existingCancelButton.remove();
                                    if (existingReturnButton) existingReturnButton.remove();

                                    // Thêm nút mới dựa trên trạng thái
                                    if (data.canCancel) {
                                        const cancelButton = document.createElement('button');
                                        cancelButton.className = 'btn btn-cancel';
                                        cancelButton.onclick = () => cancelOrder(orderId);
                                        cancelButton.textContent = 'Hủy đơn hàng';
                                        footer.appendChild(cancelButton);
                                    }

                                    if (data.status === 'delivered') {
                                        if (data.canReturn) {
                                            const returnButton = document.createElement('button');
                                            returnButton.className = 'btn btn-primary';
                                            returnButton.onclick = () => confirmReturn(orderId);
                                            returnButton.textContent =
                                                `Yêu cầu trả hàng (còn ${data.remainingDays} ngày)`;
                                            footer.appendChild(returnButton);
                                        }
                                    }
                                }
                            }
                        })
                        .catch(error => console.error('Error polling orders:', error));
                });
            }, 2000);
        }

        // Dừng polling khi rời khỏi trang
        window.addEventListener('beforeunload', () => {
            if (pollingInterval) {
                clearInterval(pollingInterval);
            }
        });

        // Bắt đầu polling khi trang được load
        document.addEventListener('DOMContentLoaded', () => {
            startOrdersPolling();
        });
    </script>

    <!-- Thêm modal -->
    <div id="cancelModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Hủy đơn hàng</h3>
            <div class="form-group">
                <label for="cancelReason">Lý do hủy đơn hàng:</label>
                <textarea id="cancelReason" class="form-control" rows="3"
                    placeholder="Vui lòng nhập lý do hủy đơn hàng"></textarea>
            </div>
            <div class="modal-buttons">
                <button onclick="submitCancelRequest()" class="btn btn-danger">Xác nhận hủy</button>
                <button onclick="closeCancelModal()" class="btn btn-secondary">Đóng</button>
            </div>
        </div>
    </div>

    <script>
        let currentOrderId = null;

        function cancelOrder(orderId) {
            currentOrderId = orderId;
            document.getElementById('cancelModal').style.display = 'block';
            document.getElementById('cancelReason').value = '';
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').style.display = 'none';
        }

        function submitCancelRequest() {
            const reason = document.getElementById('cancelReason').value.trim();
            if (!reason) {
                alert('Vui lòng nhập lý do hủy đơn hàng');
                return;
            }

            fetch('index.php?action=request-cancel', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `order_id=${currentOrderId}&reason=${encodeURIComponent(reason)}`
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

        // Đóng modal khi click bên ngoài
        window.onclick = function(event) {
            const modal = document.getElementById('cancelModal');
            if (event.target == modal) {
                closeCancelModal();
            }
        }
    </script>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
        }
    </style>

</body>

</html>