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

    <div class="cart-container">
        <h1>Giỏ hàng của bạn</h1>

        <?php if (!empty($items)) : ?>
        <div class="cart-items">
            <?php foreach ($items as $item) : ?>
            <div class="cart-item">
                <img src="Uploads/Product/<?php echo $item['img']; ?>" alt="<?php echo $item['pro_name']; ?>">
                <div class="item-details">
                    <h3><?php echo $item['pro_name']; ?></h3>
                    <p class="price"><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</p>
                    <div class="quantity">
                        <form action="index.php?action=update-cart" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['pro_id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                            <button type="submit">Cập nhật</button>
                        </form>
                        <form action="index.php?action=remove-from-cart" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['pro_id']; ?>">
                            <button type="submit">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="cart-summary">
            <h3>Tổng tiền: <?php echo number_format($total, 0, ',', '.'); ?>₫</h3>
            <a href="index.php?action=checkout" class="checkout-btn">Thanh toán</a>
        </div>
        <?php else : ?>
        <div class="empty-cart">
            <p>Giỏ hàng trống</p>
            <a href="index.php?action=product" class="continue-shopping">Tiếp tục mua sắm</a>
        </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php'; ?>
    </div>
</body>

</html>