<?php include 'client/views/layout/header.php'; ?>

<div class="cart-page">
    <div class="container">
        <h1 class="cart-title">Giỏ hàng của bạn</h1>

        <?php if (empty($cart_items)): ?>
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <p>Giỏ hàng của bạn đang trống</p>
                <a href="index.php?action=product" class="btn-shopping">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="cart-content">
                <div class="cart-list">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item" data-product-id="<?= $item['pro_id'] ?>" data-price="<?= $item['price'] ?>">
                            <div class="item-image">
                                <img src="Uploads/Product/<?= $item['img'] ?>" alt="<?= $item['pro_name'] ?>">
                            </div>
                            <div class="item-details">
                                <h3 class="item-name"><?= $item['pro_name'] ?></h3>
                                <div class="item-price"><?= number_format($item['price'], 0, ',', '.') ?>₫</div>
                                <div class="quantity-controls">
                                    <button type="button" class="qty-btn minus">-</button>
                                    <input type="number" value="<?= $item['quantity'] ?>" min="1" max="10" class="qty-input"
                                        data-product-id="<?= $item['pro_id'] ?>">
                                    <button type="button" class="qty-btn plus">+</button>
                                </div>
                                <div class="item-subtotal">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫
                                </div>
                                <button class="remove-btn" onclick="removeFromCart(<?= $item['pro_id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <h3>Tổng đơn hàng</h3>
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span class="subtotal"><?= number_format($total, 0, ',', '.') ?>₫</span>
                    </div>
                    <div class="summary-row total">
                        <span>Tổng cộng:</span>
                        <span class="total-amount"><?= number_format($total, 0, ',', '.') ?>₫</span>
                    </div>
                    <button class="btn-checkout">Thanh toán</button>
                    <a href="index.php?action=product" class="btn-continue">Tiếp tục mua sắm</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .cart-page {
        padding: 40px 0;
        background: #f5f5f5;
        min-height: calc(100vh - 200px);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .cart-title {
        font-size: 24px;
        margin-bottom: 30px;
        color: #333;
    }

    .cart-content {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
    }

    .cart-list {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cart-item {
        display: flex;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 120px;
        margin-right: 20px;
    }

    .item-image img {
        width: 100%;
        border-radius: 8px;
    }

    .item-details {
        flex: 1;
        position: relative;
    }

    .item-name {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .item-price {
        color: #ff4500;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .qty-btn {
        width: 30px;
        height: 30px;
        border: 1px solid #ddd;
        background: #fff;
        border-radius: 4px;
        cursor: pointer;
    }

    .qty-input {
        width: 50px;
        height: 30px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .item-subtotal {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    .remove-btn {
        position: absolute;
        top: 0;
        right: 0;
        background: none;
        border: none;
        color: #ff4500;
        cursor: pointer;
    }

    .cart-summary {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        height: fit-content;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }

    .total {
        font-weight: bold;
        font-size: 18px;
    }

    .btn-checkout {
        width: 100%;
        padding: 15px;
        background: #ff4500;
        color: #fff;
        border: none;
        border-radius: 4px;
        margin-top: 20px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-continue {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #666;
        text-decoration: none;
    }

    .cart-empty {
        text-align: center;
        padding: 50px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .cart-empty i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .btn-shopping {
        display: inline-block;
        padding: 12px 24px;
        background: #ff4500;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .cart-content {
            grid-template-columns: 1fr;
        }

        .cart-item {
            flex-direction: column;
        }

        .item-image {
            width: 100%;
            margin-bottom: 15px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartItems = document.querySelectorAll('.cart-item');

        cartItems.forEach(item => {
            const minusBtn = item.querySelector('.minus');
            const plusBtn = item.querySelector('.plus');
            const input = item.querySelector('.qty-input');
            const productId = item.dataset.productId;
            const price = parseFloat(item.dataset.price);
            const itemSubtotal = item.querySelector('.item-subtotal');

            // Xử lý nút giảm
            minusBtn.addEventListener('click', () => {
                let value = parseInt(input.value);
                if (value > 1) {
                    value--;
                    updateQuantity(input, value, productId, price, itemSubtotal);
                }
            });

            // Xử lý nút tăng
            plusBtn.addEventListener('click', () => {
                let value = parseInt(input.value);
                if (value < 10) {
                    value++;
                    updateQuantity(input, value, productId, price, itemSubtotal);
                }
            });

            // Xử lý khi nhập trực tiếp
            input.addEventListener('change', () => {
                let value = parseInt(input.value);
                // Giới hạn giá trị từ 1-10
                value = Math.max(1, Math.min(10, value));
                updateQuantity(input, value, productId, price, itemSubtotal);
            });
        });

        updateCartCount();
    });

    function updateCartCount() {
        fetch('index.php?action=get-cart-items')
            .then(response => response.json())
            .then(data => {
                const cartCount = document.querySelector('.count');
                if (cartCount) {
                    let totalItems = 0;
                    if (data.items && Array.isArray(data.items)) {
                        data.items.forEach(item => {
                            totalItems += parseInt(item.quantity) || 0;
                        });
                    }
                    cartCount.textContent = totalItems;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateQuantity(input, newValue, productId, price, itemSubtotal) {
        input.value = newValue;
        const subtotal = price * newValue;
        itemSubtotal.textContent = new Intl.NumberFormat('vi-VN').format(subtotal) + '₫';

        fetch('index.php?action=update-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&quantity=${newValue}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartTotal();
                    updateCartCount();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateCartTotal() {
        let total = 0;
        // Tính tổng từ tất cả các sản phẩm
        document.querySelectorAll('.cart-item').forEach(item => {
            const price = parseFloat(item.dataset.price);
            const quantity = parseInt(item.querySelector('.qty-input').value);
            total += price * quantity;
        });

        // Cập nhật hiển thị tổng tiền
        document.querySelector('.subtotal').textContent =
            new Intl.NumberFormat('vi-VN').format(total) + '₫';
        document.querySelector('.total-amount').textContent =
            new Intl.NumberFormat('vi-VN').format(total) + '₫';
    }

    function removeFromCart(productId) {
        if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
            fetch('index.php?action=remove-from-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `product_id=${productId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCartCount();
                        location.reload();
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>

<?php include 'client/views/layout/footer.php'; ?>