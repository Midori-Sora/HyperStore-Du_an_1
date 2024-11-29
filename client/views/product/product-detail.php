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
                        <input type="number" value="1" min="1" max="<?php echo $product['quantity']; ?>" class="qty-input">
                        <button class="qty-btn plus"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <div class="action-buttons">
                    <form action="index.php?action=add-to-cart" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
                        <input type="hidden" name="quantity" id="hidden-quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>">
                        <button type="submit" class="btn-add-cart" <?php echo $product['quantity'] > 0 ? '' : 'disabled'; ?>>
                            <i class="fas fa-shopping-cart"></i>
                            <?php echo $product['quantity'] > 0 ? 'Thêm vào giỏ hàng' : 'Hết hàng'; ?>
                        </button>
                    </form>
                    <form action="index.php?action=checkout" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
                        <input type="hidden" name="quantity" id="buy-now-quantity" value="1" max="<?php echo $product['quantity']; ?>">
                        <button type="submit" class="btn-buy-now" <?php echo $product['quantity'] > 0 ? '' : 'disabled'; ?>>
                            <?php echo $product['quantity'] > 0 ? 'Mua ngay' : 'Hết hàng'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="product-sections">
            <!-- Comments section -->
            <?php include 'client/views/product/comments-list.php'; ?>
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
                // Remove active class from all thumbnails
                thumbnails.forEach(t => t.classList.remove('active'));
                // Add active class to clicked thumbnail
                this.classList.add('active');
                // Update main image
                mainImage.src = this.src;
            });
        });

        // Xử lý tăng giảm số lượng
        const minusBtn = document.querySelector('.minus');
        const plusBtn = document.querySelector('.plus');
        const qtyInput = document.querySelector('.qty-input');
        const hiddenQuantity = document.getElementById('hidden-quantity');
        const buyNowQuantity = document.getElementById('buy-now-quantity');
        const MAX_QUANTITY = <?php echo $product['quantity']; ?>;

        // Cập nhật hidden input khi số lượng thay đổi
        qtyInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            // Giới hạn giá trị trong khoảng 1-MAX_QUANTITY
            value = Math.min(Math.max(value, 1), MAX_QUANTITY);
            this.value = value;
            hiddenQuantity.value = value;
            buyNowQuantity.value = value;
        });

        minusBtn.addEventListener('click', () => {
            const currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                const newValue = currentValue - 1;
                qtyInput.value = newValue;
                hiddenQuantity.value = newValue;
                buyNowQuantity.value = newValue;
            }
        });

        plusBtn.addEventListener('click', () => {
            const currentValue = parseInt(qtyInput.value);
            if (currentValue < MAX_QUANTITY) {
                const newValue = currentValue + 1;
                qtyInput.value = newValue;
                hiddenQuantity.value = newValue;
                buyNowQuantity.value = newValue;
            }
        });

        // Disable nút plus khi đạt số lượng tối đa
        function updateButtonStates() {
            const currentValue = parseInt(qtyInput.value);
            minusBtn.disabled = currentValue <= 1;
            plusBtn.disabled = currentValue >= MAX_QUANTITY;
        }

        // Thêm sự kiện để cập nhật trạng thái nút
        qtyInput.addEventListener('change', updateButtonStates);
        minusBtn.addEventListener('click', updateButtonStates);
        plusBtn.addEventListener('click', updateButtonStates);

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
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    const rating = this.dataset.rating;

                    // Show loading state
                    commentsContainer.innerHTML = '<div class="loading">Đang tải...</div>';

                    // Fetch filtered comments
                    fetch(`index.php?action=filter-comments&product_id=${productId}&rating=${rating}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        commentsContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        commentsContainer.innerHTML = '<div class="error">Có lỗi xảy ra khi tải bình luận</div>';
                    });
                });
            });
        });
    </script>

    <style>
        /* CSS cho phần rating */
        .rating-input {
            margin-bottom: 15px;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            gap: 5px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            color: #ddd;
            font-size: 24px;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffd700;
        }

        /* CSS cho hiển thị rating trong comment */
        .comment-rating {
            margin: 5px 0;
        }

        .comment-rating .fa-star {
            color: #ddd;
            font-size: 14px;
        }

        .comment-rating .fa-star.active {
            color: #ffd700;
        }

        .rating-text {
            display: block;
            margin-top: 5px;
            font-size: 14px;
            color: #666;
        }

        .rating .fa-star.active {
            color: #ffd700;
        }

        /* Thêm CSS */
        .rating {
            margin-bottom: 20px;
        }

        .rating .stars {
            display: inline-flex;
            gap: 5px;
        }

        .rating-summary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-left: 10px;
        }

        .rating-summary .average {
            font-size: 18px;
            font-weight: bold;
        }

        .rating-details {
            margin-top: 10px;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
        }

        .progress-bar {
            flex: 1;
            height: 8px;
            background: #eee;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background: #ffd700;
            transition: width 0.3s ease;
        }

        .star-count {
            width: 50px;
        }

        .product-rating-section {
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .product-rating-section h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .rating-summary {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .average-rating {
            text-align: center;
            margin-right: 40px;
        }

        .rating-number {
            font-size: 32px;
            font-weight: bold;
            color: #ff424f;
        }

        .rating-text {
            color: #666;
            font-size: 14px;
            margin-left: 5px;
        }

        .stars {
            color: #ffd700;
            font-size: 20px;
            margin-top: 5px;
        }

        .stars .fa-star.active {
            color: #ffd700;
        }

        .stars .fa-star:not(.active) {
            color: #ddd;
        }

        .rating-filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .filter-btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            transition: all 0.2s ease;
            background: #fff;
        }

        .filter-btn:hover {
            border-color: #ff424f;
            color: #ff424f;
        }

        .filter-btn.active {
            background-color: #ff424f;
            border-color: #ff424f;
            color: #fff;
        }

        /* CSS cho comment đang chờ duyệt */
        .comment-item.pending {
            opacity: 0.7;
            background-color: #f9f9f9;
            border-left: 3px solid #ffd700;
        }

        .pending-status {
            display: inline-block;
            padding: 2px 8px;
            background-color: #ffd700;
            color: #333;
            border-radius: 12px;
            font-size: 12px;
            margin-left: 10px;
        }

        .comment-item {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .comment-date {
            color: #666;
            font-size: 13px;
        }

        .rating-filters {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 20px;
            text-decoration: none;
            color: #666;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background-color: #f5f5f5;
            border-color: #ccc;
        }

        .filter-btn.active {
            background-color: #ffd700;
            border-color: #ffd700;
            color: #333;
            font-weight: 500;
        }

        .no-comments {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        .product-sections {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .product-section {
            background: #fff;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 20px;
            font-weight: 500;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .product-description {
            color: #333;
            line-height: 1.6;
            font-size: 15px;
        }

        /* Style cho phần rating */
        .rating-overview {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .rating-summary {
            display: flex;
            align-items: center;
            gap: 40px;
            padding: 20px;
            background: #f8f8f8;
            border-radius: 8px;
        }

        .average-rating {
            text-align: center;
        }

        .rating-number {
            font-size: 32px;
            font-weight: bold;
            color: #ff424f;
        }

        .rating-text {
            color: #666;
            font-size: 14px;
            margin-left: 5px;
        }

        .rating-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 15px 0;
        }

        .filter-btn {
            padding: 8px 16px;
            border: 1px solid #ddd;
            border-radius: 16px;
            text-decoration: none;
            color: #333;
            font-size: 14px;
            transition: all 0.2s ease;
            background: #fff;
        }

        .filter-btn:hover {
            border-color: #ff424f;
            color: #ff424f;
        }

        .filter-btn.active {
            background-color: #ffd700;
            border-color: #ffd700;
            color: #333;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-section {
                padding: 15px;
            }

            .rating-summary {
                flex-direction: column;
                gap: 20px;
                padding: 15px;
            }

            .filter-btn {
                padding: 6px 12px;
                font-size: 13px;
            }
        }

        /* Thêm style cho loading state */
        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .error {
            text-align: center;
            padding: 20px;
            color: #ff424f;
        }

        /* Style cho active button */
        .filter-btn.active {
            background-color: #ffd700;
            border-color: #ffd700;
            color: #333;
        }

        .comments-list {
            margin-top: 20px;
        }

        .comment-item {
            padding: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
            background: #fff;
            border-radius: 8px;
        }

        .comment-user-info {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-details {
            flex-grow: 1;
        }

        .username {
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
        }

        .rating-stars {
            color: #ffd700;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .rating-stars .fa-star:not(.active) {
            color: #ddd;
        }

        .comment-date {
            font-size: 12px;
            color: #666;
        }

        .comment-content {
            margin-left: 52px;
        }

        .comment-text {
            color: #333;
            line-height: 1.5;
            margin: 0;
            white-space: pre-line;
        }

        .no-comments {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
            background: #f8f8f8;
            border-radius: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .comment-item {
                padding: 15px;
            }

            .comment-content {
                margin-left: 0;
                margin-top: 10px;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
            }
        }

        /* Animation cho comment mới */
        .comment-item {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>