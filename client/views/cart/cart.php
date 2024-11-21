<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - HyperStore</title>
    <link rel="stylesheet" href="assets/css/client/cart.css">
</head>

<body>
    <div class="header">
        <?php include 'client/views/layout/header.php'; ?>
    </div>

    <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <h2>Giỏ hàng trống</h2>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <h2>Giỏ hàng của bạn</h2>
            <div class="cart-items">
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="Uploads/Product/<?= $item['img'] ?>" alt="<?= $item['pro_name'] ?>">
                        <div class="item-details">
                            <h3><?= $item['pro_name'] ?></h3>
                            <p class="price"><?= number_format($item['price']) ?>đ</p>
                            <div class="quantity">
                                <select name="quantity">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($i == $item['quantity']) ? 'selected' : '' ?>><?= $i ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <button class="update">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cart-total">
                <p>Tổng cộng: <?= number_format($total) ?>đ</p>
                <button class="checkout">Thanh toán</button>
            </div>
        </div>
    <?php endif; ?>

    <div class="footer">
        <?php include 'client/views/layout/footer.php'; ?>
    </div>
</body>

</html>