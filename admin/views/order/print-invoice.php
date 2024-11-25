<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa Đơn #<?= $order['order_code'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .table th {
            background-color: #f8f9fa;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-header">
            <h1>HÓA ĐƠN BÁN HÀNG</h1>
            <p>Mã đơn hàng: <?= $order['order_code'] ?></p>
            <p>Ngày: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
        </div>

        <div class="invoice-details">
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
                    <p><strong>Trạng thái:</strong> <?= self::$orderModel->getOrderStatusText($order['status']) ?></p>
                    <p><strong>Phương thức thanh toán:</strong>
                        <?= $order['payment_method'] == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' ?>
                    </p>
                </div>
            </div>
        </div>

        <?php if ($orderDetails): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Dung lượng</th>
                        <th>Màu sắc</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orderDetails as $item): ?>
                        <tr>
                            <td><?= $item['pro_name'] ?></td>
                            <td><?= $item['storage_type'] ?></td>
                            <td><?= $item['color_type'] ?></td>
                            <td><?= number_format($item['price']) ?>đ</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'] * $item['quantity']) ?>đ</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="5" class="text-end"><strong>Tổng cộng:</strong></td>
                        <td><strong><?= number_format($order['total_amount']) ?>đ</strong></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="row mt-4">
            <div class="col-6 text-center">
                <p><strong>Người mua hàng</strong></p>
                <p><em>(Ký, ghi rõ họ tên)</em></p>
            </div>
            <div class="col-6 text-center">
                <p><strong>Người bán hàng</strong></p>
                <p><em>(Ký, ghi rõ họ tên)</em></p>
            </div>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>