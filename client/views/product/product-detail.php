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
            <span class="alert-message"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></span>
        </div>
        <button class="alert-close"><i class="fas fa-times"></i></button>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error" id="errorAlert">
        <div class="alert-content">
            <i class="fas fa-exclamation-circle"></i>
            <span class="alert-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></span>
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
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span>(120 đánh giá)</span>
                    </div>
                    <div class="stock-status <?php echo $product['quantity'] > 0 ? 'in-stock' : 'out-of-stock'; ?>">
                        <i
                            class="fas <?php echo $product['quantity'] > 0 ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                        <?php echo $product['quantity'] > 0 ? 'Còn hàng' : 'Hết hàng'; ?>
                    </div>
                </div>

                <div class="product-price">
                    <?php if (isset($product['current_discount']) && $product['current_discount'] > 0): ?>
                        <div class="discount-info">
                            <div class="current-price">
                                <?php echo number_format($product['price'] * (1 - $product['current_discount'] / 100), 0, ',', '.'); ?>₫
                            </div>
                            <div class="original-price">
                                <span><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</span>
                            </div>
                            <span class="discount-percentage">-<?php echo $product['current_discount']; ?>%</span>
                        </div>
                    <?php else: ?>
                        <div class="current-price">
                            <?php echo number_format($product['price'], 0, ',', '.'); ?>₫
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
                                <a href="?action=product-detail&id=<?php echo $product['pro_id']; ?>&color=<?php echo $color['color_id']; ?>&storage=<?php echo $product['storage_id']; ?>&discount=<?php echo isset($product['current_discount']) ? $product['current_discount'] : 0; ?>" 
                                   class="color-btn <?php echo ($color['color_id'] == $product['color_id']) ? 'active' : ''; ?>"
                                   data-color="<?php echo $color['color_type']; ?>">
                                    <div class="color-wrapper">
                                        <span class="color-circle" style="background-color: <?php echo $productModel->getColorCode($color['color_type']); ?>"></span>
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
                        <input type="number" value="1" min="1" class="qty-input">
                        <button class="qty-btn plus"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <div class="action-buttons">
                    <form action="index.php?action=add-to-cart" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
                        <input type="hidden" name="quantity" id="hidden-quantity" value="1">
                        <button type="submit" class="btn-add-cart">
                            <i class="fas fa-shopping-cart"></i>
                            Thêm vào giỏ hàng
                        </button>
                    </form>
                    <button class="btn-buy-now">Mua ngay</button>
                </div>
            </div>
        </div>

        <div class="product-description">
            <h2>Mô tả sản phẩm</h2>
            <div class="description-content">
                <!-- Nội dung mô tả sản phẩm -->
            </div>
        </div>

        <div class="product-comments">
            <h2>Bình luận sản phẩm</h2>
            
            <!-- Form bình luận -->
            <?php if (isset($_SESSION['user_id'])): ?>
            <div class="comment-form">
                <h3>Viết bình luận của bạn</h3>
                <form action="index.php?action=add-comment" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
                    <div class="form-group">
                        <textarea name="content" placeholder="Nhận xét của bạn" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Gửi bình luận</button>
                </form>
            </div>
            <?php else: ?>
            <p class="login-notice">Vui lòng <a href="index.php?action=login">đăng nhập</a> để viết bình luận</p>
            <?php endif; ?>

            <!-- Danh sách bình luận -->
            <div class="comments-list">
                <?php 
                // Lấy danh sách bình luận
                $comments = CommentController::getComments($product['pro_id']);
                
                if (!empty($comments)): 
                ?>
                    <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="user-avatar">
                            <img src="<?php echo $comment['avatar'] ?? 'assets/images/default-avatar.jpg'; ?>" alt="User Avatar">
                        </div>
                        <div class="comment-content">
                            <div class="user-info">
                                <h4><?php echo htmlspecialchars($comment['username']); ?></h4>
                                <span class="comment-date"><?php echo date('d/m/Y', strtotime($comment['import_date'])); ?></span>
                            </div>
                            <p class="comment-text"><?php echo htmlspecialchars($comment['content']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-comments">Chưa có bình luận nào cho sản phẩm này</p>
                <?php endif; ?>
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
            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            this.classList.add('active');
            // Update main image
            mainImage.src = this.src;
        });
    });

    // Xử lý tăng giảm s lượng
    const minusBtn = document.querySelector('.minus');
    const plusBtn = document.querySelector('.plus');
    const qtyInput = document.querySelector('.qty-input');
    const hiddenQuantity = document.getElementById('hidden-quantity');

    // Cập nhật hidden input khi số lượng thay đổi
    qtyInput.addEventListener('change', function() {
        hiddenQuantity.value = this.value;
    });

    minusBtn.addEventListener('click', () => {
        const currentValue = parseInt(qtyInput.value);
        if (currentValue > 1) {
            qtyInput.value = currentValue - 1;
            hiddenQuantity.value = currentValue - 1; // Cập nhật hidden input
        }
    });

    plusBtn.addEventListener('click', () => {
        const currentValue = parseInt(qtyInput.value);
        qtyInput.value = currentValue + 1;
        hiddenQuantity.value = currentValue + 1; // Cập nhật hidden input
    });

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
    </script>
</body>

</html>