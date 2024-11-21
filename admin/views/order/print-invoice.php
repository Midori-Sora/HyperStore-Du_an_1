<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Hóa Đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    body {
        padding: 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .container {
        background: white;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #333;
    }

    p {
        font-size: 1rem;
        margin-bottom: 10px;
        color: #555;
    }

    strong {
        color: #000;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hóa Đơn cho Đơn Hàng #<?= $order['order_code'] ?></h1>
        <p><strong>Tên khách hàng:</strong> <?= $order['username'] ?></p>
        <p><strong>Email:</strong> <?= $order['email'] ?></p>
        <p><strong>Số điện thoại:</strong> <?= $order['phone'] ?></p>
        <p><strong>Tổng tiền:</strong> <?= number_format($order['total_amount']) ?>đ</p>
    </div>
    <script>
    window.print();
    </script>
</body>

</html>