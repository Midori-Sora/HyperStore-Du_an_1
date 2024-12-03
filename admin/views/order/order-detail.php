<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f5f5f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding-top: 80px;
    }

    .main {
        display: flex;
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
    }

    .main main {
        width: calc(100% - 270px);
        margin-left: 270px;
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .btn-back {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #5a6268;
        color: white;
    }

    .order-info {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .order-info h4 {
        color: #1976D2;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .order-info p {
        margin-bottom: 10px;
        color: #495057;
    }

    .order-status {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .form-select {
        max-width: 200px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ced4da;
    }

    .product-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }

    .table {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .status-badge {
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 6px;
    }

    .status-badge.warning {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.info {
        background: #cce5ff;
        color: #004085;
    }

    .status-badge.success {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.danger {
        background: #f8d7da;
        color: #721c24;
    }

    .status-badge.secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    .status-badge.dark {
        background: #d6d8d9;
        color: #1b1e21;
    }

    .status-badge.primary {
        background: #cce5ff;
        color: #004085;
    }
    </style>
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="main">
        <div class="sidebar">
            <?php include "./views/layout/sidebar.php"; ?>
        </div>
        <main>
            <div class="container-fluid">
                <div class="page-header">
                    <h2>Chi tiết đơn hàng #<?= $order['order_code'] ?></h2>
                    <div>
                        <?php if (in_array($order['status'], ['confirmed', 'processing', 'shipping', 'delivered'])): ?>
                        <a href="?action=printInvoice&id=<?= $order['order_id'] ?>" class="btn btn-primary me-2"
                            target="_blank">
                            <i class="fas fa-print"></i> In hóa đơn
                        </a>
                        <?php endif; ?>
                        <a href="?action=order" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="order-info">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Thông tin khách hàng</h4>
                            <p><strong>Tên:</strong> <?= $order['username'] ?></p>
                            <p><strong>Email:</strong> <?= $order['shipping_email'] ?></p>
                            <p><strong>Số điện thoại:</strong> <?= $order['shipping_phone'] ?></p>
                            <p><strong>Địa chỉ:</strong> <?= $order['shipping_address'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <h4>Thông tin đơn hàng</h4>
                            <p><strong>Mã đơn hàng:</strong> <?= $order['order_code'] ?></p>
                            <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                            <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount']) ?>đ</p>
                            <p><strong>Phương thức thanh toán:</strong>
                                <?= $order['payment_method'] == 1 ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="order-status mb-4">
                    <h3>Trạng thái đơn hàng</h3>
                    <select id="orderStatus" class="form-select">
                        <?php
                        $allowedTransitions = OrderHelper::getAllowedStatusTransitions($order['status']);
                        // Hiển thị trạng thái hiện tại
                        echo "<option value='{$order['status']}' selected>" .
                            OrderHelper::getOrderStatus($order['status']) .
                            " (Hiện tại)</option>";
                        // Hiển thị các trạng thái được phép chuyển đổi
                        foreach ($allowedTransitions as $status => $label) {
                            echo "<option value='{$status}'>{$label}</option>";
                        }
                        ?>
                    </select>
                    <button onclick="updateStatus()" class="btn btn-primary mt-2">Cập nhật trạng thái</button>
                </div>

                <div class="sms-box mt-4">
                    <h4>Gửi SMS thông báo</h4>
                    <form action="?action=sendSMS" method="POST">
                        <input type="hidden" name="phone" value="<?= $order['shipping_phone'] ?>">
                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="3" required
                                placeholder="Nhập nội dung tin nhắn..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Gửi SMS
                        </button>
                    </form>
                </div>

                <div class="order-products mt-4">
                    <h4>Sản phẩm đã đặt</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>RAM</th>
                                    <th>Màu sắc</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($orderDetails): ?>
                                <?php foreach ($orderDetails as $item): ?>
                                <tr>
                                    <td>
                                        <img src="../Uploads/Product/<?= $item['img'] ?>" alt="<?= $item['pro_name'] ?>"
                                            class="product-thumbnail">
                                    </td>
                                    <td><?= $item['pro_name'] ?></td>
                                    <td><?= $item['storage_type'] ?></td>
                                    <td><?= $item['color_type'] ?></td>
                                    <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Không có sản phẩm nào</td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="6" class="text-end"><strong>Tổng cộng:</strong></td>
                                    <td><strong><?= number_format($order['total_amount'], 0, ',', '.') ?>đ</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if ($order['status'] === 'return_requested'): ?>
                <div class="return-request-section">
                    <h3>Xử lý yêu cầu trả hàng</h3>
                    <form id="returnRequestForm">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">

                        <div class="form-group">
                            <label>Lý do khách hàng:</label>
                            <p><?= htmlspecialchars($order['return_request_reason']) ?></p>
                        </div>

                        <div class="form-group">
                            <label for="admin_note">Ghi chú của admin:</label>
                            <textarea name="admin_note" id="admin_note" class="form-control" required></textarea>
                        </div>

                        <div class="return-request-actions">
                            <button onclick="handleReturnRequest('approve')" class="btn btn-success">Chấp nhận trả
                                hàng</button>
                            <button onclick="handleReturnRequest('reject')" class="btn btn-danger">Từ chối yêu
                                cầu</button>
                        </div>
                    </form>
                </div>
                <?php endif; ?>

                <?php if ($order['status'] === 'cancel_requested'): ?>
                <div class="cancel-request-section mt-4">
                    <h4>Yêu cầu hủy đơn hàng</h4>
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Lý do hủy:</strong> <?= htmlspecialchars($order['cancel_reason']) ?></p>
                            <div class="mt-3">
                                <button onclick="handleCancelRequest(true)" class="btn btn-success me-2">
                                    <i class="fas fa-check"></i> Chấp nhận
                                </button>
                                <button onclick="handleCancelRequest(false)" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Từ chối
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                function handleCancelRequest(approve) {
                    if (!confirm('Bạn có chắc chắn muốn ' + (approve ? 'chấp nhận' : 'từ chối') +
                            ' yêu cầu hủy đơn hàng này?')) {
                        return;
                    }

                    fetch('index.php?action=approveCancelRequest', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `order_id=<?= $order['order_id'] ?>&approve=${approve}`
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
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
    function updateStatus() {
        const status = document.getElementById('orderStatus').value;
        const orderId = <?= $order['order_id'] ?>;

        fetch('index.php?action=updateOrderStatus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `order_id=${orderId}&status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Cập nhật trạng thái thành công');
                    location.reload();
                } else {
                    alert(data.message || 'Không thể chuyển sang trạng thái này');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra');
            });
    }

    function handleReturnRequest(status) {
        const orderId = <?= $order['order_id'] ?>;
        const adminNote = document.getElementById('admin_note').value;

        if (!adminNote.trim()) {
            alert('Vui lòng nhập ghi chú của admin');
            return;
        }

        fetch('index.php?action=handleReturnRequest', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `order_id=${orderId}&status=${status}&admin_note=${encodeURIComponent(adminNote)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
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