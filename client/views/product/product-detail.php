<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="assets/css/client/product-detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" id="successAlert">
            <div class="alert-content">
                <i class="fas fa-check-circle"></i>
                <span class="alert-message"><?php echo $_SESSION['success'];
                                            unset($_SESSION['success']); ?></span>
            </div>
            <button class="alert-close"><i class="fas fa-times"></i></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error" id="errorAlert">
            <div class="alert-content">
                <i class="fas fa-exclamation-circle"></i>
                <span class="alert-message"><?php echo $_SESSION['error'];
                                            unset($_SESSION['error']); ?></span>
            </div>
            <button class="alert-close"><i class="fas fa-times"></i></button>
        </div>
    <?php endif; ?>

    <div class="header">
        <?php include 'client/views/layout/header.php' ?>
    </div>

    <div class="container">
        <div class="product-detail">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="Uploads/Product/<?php echo $product['img']; ?>" alt="<?php echo $product['pro_name']; ?>"
                        id="mainImage">
                </div>
                <div class="thumbnail-list">
                    <img src="Uploads/Product/<?php echo $product['img']; ?>" alt="" class="thumbnail active">
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-name"><?php echo $product['pro_name']; ?></h1>
                <div class="product-meta">
                    <div class="stock-status <?php echo $product['quantity'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                        <i
                            class="fas <?php echo $product['quantity'] > 0 ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                        <?php
                        if ($product['quantity'] > 0) {
                            echo 'Còn hàng (' . $product['quantity'] . ' sản phẩm)';
                        } else {
                            echo 'Hết hàng';
                        }
                        ?>
                    </div>
                </div>

                <div class="product-price">
                    <?php
                    $total_price = $product['price'] +
                        floatval($product['color_price'] ?? 0) +
                        floatval($product['storage_price'] ?? 0);

                    if (!empty($product['discount'])) :
                        $discount_price = $total_price * (100 - $product['discount']) / 100;
                    ?>
                        <div class="price-wrapper">
                            <div class="discount-info">
                                <span class="original-price">
                                    <?php echo number_format($total_price, 0, ',', '.'); ?>₫
                                </span>
                                <span class="discount-badge">
                                    -<?php echo $product['discount']; ?>%
                                </span>
                            </div>
                            <div class="current-price discount-price">
                                <?php echo number_format($discount_price, 0, ',', '.'); ?>₫
                            </div>
                            <div class="save-price">
                                Tiết kiệm: <?php echo number_format($total_price - $discount_price, 0, ',', '.'); ?>₫
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="current-price">
                            <?php echo number_format($total_price, 0, ',', '.'); ?>₫
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($availableStorages)): ?>
                    <div class="product-variants">
                        <h3>Phiên bản</h3>
                        <div class="variant-options">
                            <?php foreach ($availableStorages as $storage): ?>
                                <?php
                                // Kiểm tra xem có variant cho storage này không
                                $variantExists = $productModel->checkVariantExists(
                                    $product['pro_id'],
                                    $product['color_id'],
                                    $storage['storage_id']
                                );
                                if ($variantExists):
                                ?>
                                    <a href="?action=product-detail&id=<?php echo $product['pro_id']; ?>&storage=<?php echo $storage['storage_id']; ?>&color=<?php echo $product['color_id']; ?>"
                                        class="variant-btn <?php echo ($storage['storage_id'] == $product['storage_id']) ? 'active' : ''; ?>">
                                        <?php echo $storage['storage_type']; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($availableColors)): ?>
                    <div class="product-colors">
                        <h3>Màu sắc</h3>
                        <div class="color-options">
                            <?php foreach ($availableColors as $color): ?>
                                <?php
                                // Kiểm tra xem có variant cho màu này không
                                $variantExists = $productModel->checkVariantExists(
                                    $product['pro_id'],
                                    $color['color_id'],
                                    $product['storage_id']
                                );
                                if ($variantExists):
                                ?>
                                    <a href="?action=product-detail&id=<?php echo $product['pro_id']; ?>&color=<?php echo $color['color_id']; ?>&storage=<?php echo $product['storage_id']; ?>"
                                        class="color-btn <?php echo ($color['color_id'] == $product['color_id']) ? 'active' : ''; ?>"
                                        data-color="<?php echo $color['color_type']; ?>">
                                        <div class="color-wrapper">
                                            <span class="color-circle"
                                                style="background-color: <?php echo $productModel->getColorCode($color['color_type']); ?>"></span>
                                            <?php if ($color['color_id'] == $product['color_id']): ?>
                                                <span class="check-icon">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="color-name"><?php echo $color['color_type']; ?></span>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="quantity-selector">
                    <h3>Số lượng</h3>
                    <div class="quantity-controls">
                        <button class="qty-btn minus"><i class="fas fa-minus"></i></button>
                        <input type="number" value="1" min="1" max="<?php echo min(10, $product['quantity']); ?>"
                            class="qty-input">
                        <button class="qty-btn plus"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <div class="action-buttons">
                    <form action="index.php?action=checkout" method="POST">
                        <input type="hidden" name="buy_now" value="1">
                        <input type="hidden" name="selected_products[]" value="<?php echo $product['pro_id']; ?>">
                        <input type="hidden" name="quantities[<?php echo $product['pro_id']; ?>]" id="buy-now-quantity"
                            value="1">
                        <button type="submit" class="btn-buy-now"
                            <?php echo $product['quantity'] > 0 ? '' : 'disabled'; ?>>
                            <i class="fas fa-bolt"></i>
                            Mua ngay
                        </button>
                    </form>

                    <form action="index.php?action=add-to-cart" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
                        <input type="hidden" name="quantity" id="hidden-quantity" value="1">
                        <button type="submit" class="btn-add-cart"
                            <?php echo $product['quantity'] > 0 ? '' : 'disabled'; ?>>
                            <i class="fas fa-shopping-cart"></i>
                            Thêm vào giỏ hàng
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="product-sections">
            <div class="product-section">
                <h2 class="section-title">Đánh giá sản phẩm</h2>
                <!-- Container cho danh sách bình luận -->
                <div id="comments-container">
                    <?php
                    // Truyền biến comments vào view
                    include 'client/views/product/comments-list.php';
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php' ?>
    </div>

    <script>
        // Xử lý chuyển đổi ảnh thumbnail
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('mainImage');

        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                mainImage.src = this.src;
            });
        });

        // Xử lý tăng giảm số lượng
        const minusBtn = document.querySelector('.minus');
        const plusBtn = document.querySelector('.plus');
        const qtyInput = document.querySelector('.qty-input');
        const hiddenQuantity = document.getElementById('hidden-quantity');
        const buyNowQuantity = document.getElementById('buy-now-quantity');
        const MAX_QUANTITY =
            <?php echo min(10, $product['quantity']); ?>; // Giới hạn tối đa 10 hoặc số lượng tồn kho nếu nhỏ hơn 10

        // Cập nhật hidden input khi số lượng thay đổi
        qtyInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            // Giới hạn giá trị trong khoảng 1-MAX_QUANTITY
            value = Math.min(Math.max(value, 1), MAX_QUANTITY);
            this.value = value;
            hiddenQuantity.value = value;
            buyNowQuantity.value = value;
            updateButtonStates();
        });

        // Ngăn chặn nhập số lượng vượt quá bằng bàn phím
        qtyInput.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp' && parseInt(this.value) >= MAX_QUANTITY) {
                e.preventDefault();
            }
        });

        minusBtn.addEventListener('click', () => {
            const currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                const newValue = currentValue - 1;
                qtyInput.value = newValue;
                hiddenQuantity.value = newValue;
                buyNowQuantity.value = newValue;
                updateButtonStates();
            }
        });

        plusBtn.addEventListener('click', () => {
            const currentValue = parseInt(qtyInput.value);
            if (currentValue < MAX_QUANTITY) {
                const newValue = currentValue + 1;
                qtyInput.value = newValue;
                hiddenQuantity.value = newValue;
                buyNowQuantity.value = newValue;
                updateButtonStates();
            }
        });

        // Disable nút plus khi đạt số lượng tối đa
        function updateButtonStates() {
            const currentValue = parseInt(qtyInput.value);
            minusBtn.disabled = currentValue <= 1;
            plusBtn.disabled = currentValue >= MAX_QUANTITY;

            // Thêm class để style cho nút bị disable
            minusBtn.classList.toggle('disabled', currentValue <= 1);
            plusBtn.classList.toggle('disabled', currentValue >= MAX_QUANTITY);
        }

        // Khởi tạo trạng thái ban đầu
        updateButtonStates();

        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                // Tự động ẩn sau 3 giây
                setTimeout(() => {  
                    alert.style.animation = 'slideOut 0.3s ease-out forwards';
                    setTimeout(() => alert.remove(), 300);
                }, 3000);

                // Xử lý nút đóng
                const closeBtn = alert.querySelector('.alert-close');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        alert.style.animation = 'slideOut 0.3s ease-out forwards';
                        setTimeout(() => alert.remove(), 300);
                    });
                }
            });
        });

        // Cập nhật ảnh sản phẩm khi đổi màu
        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('mainImage');
            const thumbnail = document.querySelector('.thumbnail');

            // Cập nhật ảnh khi URL thay đổi
            if (mainImage && thumbnail) {
                const newImageUrl = mainImage.src;
                thumbnail.src = newImageUrl;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const starLabels = document.querySelectorAll('.star-rating label');
            const ratingText = document.createElement('span');
            ratingText.className = 'rating-text';
            document.querySelector('.star-rating').appendChild(ratingText);

            starLabels.forEach(label => {
                label.addEventListener('mouseover', function() {
                    const rating = this.getAttribute('for').replace('star', '');
                    const ratingMessages = {
                        1: 'Rất tệ',
                        2: 'Tệ',
                        3: 'Bình thường',
                        4: 'Tốt',
                        5: 'Rất tốt'
                    };
                    ratingText.textContent = ratingMessages[rating];
                });
            });

            document.querySelector('.star-rating').addEventListener('mouseout', function() {
                const checkedRating = document.querySelector('.star-rating input:checked');
                if (checkedRating) {
                    const rating = checkedRating.value;
                    const ratingMessages = {
                        1: 'Rất tệ',
                        2: 'Tệ',
                        3: 'Bình thường',
                        4: 'Tốt',
                        5: 'Rất tốt'
                    };
                    ratingText.textContent = ratingMessages[rating];
                } else {
                    ratingText.textContent = '';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const commentsContainer = document.getElementById('comments-container');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const productId = <?php echo $product['pro_id']; ?>;

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const rating = this.dataset.rating;
                    commentsContainer.innerHTML = '<div class="loading">Đang tải...</div>';

                    fetch(
                            `index.php?action=filter-comments&product_id=${productId}&rating=${rating}`)
                        .then(response => response.text())
                        .then(html => {
                            commentsContainer.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            commentsContainer.innerHTML =
                                '<div class="error">Có lỗi xảy ra khi tải bình luận</div>';
                        });
                });
            });
        });
    </script>
</body>

</html>