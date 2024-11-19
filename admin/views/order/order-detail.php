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
            max-width: 1400px;
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
                    <a href="?action=order" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
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

                <div class="order-status">
                    <h4>Trạng thái đơn hàng</h4>
                    <form action="?action=updateOrderStatus" method="POST">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="1" <?= $order['status'] == 1 ? 'selected' : '' ?>>Chờ xử lý</option>
                            <option value="2" <?= $order['status'] == 2 ? 'selected' : '' ?>>Hoàn thành</option>
                            <option value="3" <?= $order['status'] == 3 ? 'selected' : '' ?>>Đang xử lý</option>
                        </select>
                    </form>
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
                                            <td><?= $item['ram_type'] ?></td>
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
            </div>
        </main>
    </div>
</body>

</html>