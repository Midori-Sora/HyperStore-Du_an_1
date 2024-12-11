<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="assets/css/client/order.css">
</head>

<body>
    <?php require_once "client/views/layout/header.php"; ?>

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
                                </span>
                            <?php endif; ?>

                            <?php if ($item['storage_type']): ?>
                                <span class="variant storage">
                                    <i class="fas fa-memory"></i>
                                    <?= htmlspecialchars($item['storage_type']) ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <p class="product-quantity">Số lượng: <?= $item['quantity'] ?></p>
                        <div class="product-price">
                            <div class="price-row">
                                <span class="price-label">Đơn giá:</span>
                                <span class="unit-price"><?= number_format($item['unit_price'], 0, ',', '.') ?>₫</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Thành tiền:</span>
                                <span class="total-price"><?= number_format($item['total_price'], 0, ',', '.') ?>₫</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="order-summary">
            <div class="summary-row">
                <span class="summary-label">Tổng tiền hàng:</span>
                <span class="summary-value"><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Phí vận chuyển:</span>
                <span class="summary-value">0₫</span>
            </div>
            <div class="summary-row total">
                <span class="summary-label">Tổng thanh toán:</span>
                <span
                    class="summary-value final-total"><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</span>
            </div>
        </div>


    </div>

    <?php require_once "client/views/layout/footer.php"; ?>

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

        let pollingInterval;

        function startStatusPolling(orderId) {
            pollingInterval = setInterval(() => {
                fetch(`index.php?action=checkOrderStatus&orderId=${orderId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const statusElement = document.querySelector('.order-status');
                            if (statusElement) {
                                // Cập nhật trạng thái
                                statusElement.textContent = data.statusText;
                                statusElement.className = `order-status ${data.statusClass}`;

                                // Cập nhật nút hành động
                                const orderInfo = document.querySelector('.order-info');
                                const existingCancelButton = orderInfo.querySelector('.btn-cancel');
                                const existingReturnButton = orderInfo.querySelector('.btn-return');

                                // Xóa các nút cũ
                                if (existingCancelButton) existingCancelButton.remove();
                                if (existingReturnButton) existingReturnButton.remove();

                                // Thêm nút mới dựa trên trạng thái
                                if (data.canCancel) {
                                    const cancelButton = document.createElement('button');
                                    cancelButton.className = 'btn btn-cancel';
                                    cancelButton.onclick = () => cancelOrder(orderId);
                                    cancelButton.textContent = 'Hủy đơn hàng';
                                    orderInfo.appendChild(cancelButton);
                                }

                                if (data.status === 'delivered') {
                                    if (data.canReturn) {
                                        const returnButton = document.createElement('button');
                                        returnButton.className = 'btn btn-primary';
                                        returnButton.onclick = () => confirmReturn(orderId);
                                        returnButton.textContent =
                                            `Yêu cầu trả hàng (còn ${data.remainingDays} ngày)`;
                                        orderInfo.appendChild(returnButton);
                                    }
                                }
                            }
                        }
                    })
                    .catch(error => console.error('Error polling status:', error));
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
            const orderId = <?= $order['order_id'] ?>;
            startStatusPolling(orderId);
        });
    </script>
</body>

</html>