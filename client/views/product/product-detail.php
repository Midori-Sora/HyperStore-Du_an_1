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
    <div class="header">
        <?php include 'client/views/layout/header.php' ?>
    </div>

    <div class="container">
        <div class="product-detail">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="Uploads/Product/<?php echo $product['img']; ?>" alt="<?php echo $product['pro_name']; ?>" id="mainImage">
                </div>
                <div class="thumbnail-list">
                    <img src="Uploads/Product/<?php echo $product['img']; ?>" alt="" class="thumbnail active">
                    <?php foreach ($productImages as $image): ?>
                        <img src="Uploads/Product/<?php echo $image['img']; ?>" alt="" class="thumbnail">
                    <?php endforeach; ?>
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
                        <i class="fas <?php echo $product['quantity'] > 0 ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                        <?php echo $product['quantity'] > 0 ? 'Còn hàng' : 'Hết hàng'; ?>
                    </div>
                </div>

                <div class="product-price">
                    <div class="current-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</div>
                </div>

                <?php if ($product['ram_type']): ?>
                <div class="product-variants">
                    <h3>Phiên bản</h3>
                    <div class="variant-options">
                        <button class="variant-btn active"><?php echo $product['ram_type']; ?></button>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($product['color_type']): ?>
                <div class="product-colors">
                    <h3>Màu sắc</h3>
                    <div class="color-options">
                        <button class="color-btn active"><?php echo $product['color_type']; ?></button>
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
                    <button class="btn-add-cart">
                        <i class="fas fa-shopping-cart"></i>
                        Thêm vào giỏ hàng
                    </button>
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

        <div class="related-products">
            <h2>Sản phẩm liên quan</h2>
            <div class="product-list">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <div class="product-box">
                        <div class="product-image">
                            <img src="Uploads/Product/<?php echo $relatedProduct['thumbnail']; ?>" alt="<?php echo $relatedProduct['name']; ?>">
                            <div class="product-actions">
                                <button class="action-btn"><i class="fas fa-heart"></i></button>
                                <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                            <div class="product-tag">Mới</div>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><?php echo $relatedProduct['name']; ?></h3>
                            <div class="product-price">
                                <span class="current-price"><?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?>₫</span>
                                <?php if ($relatedProduct['original_price'] > $relatedProduct['price']): ?>
                                    <span class="original-price"><?php echo number_format($relatedProduct['original_price'], 0, ',', '.'); ?>₫</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>(38)</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="product-comments">
            <h2>Đánh giá sản phẩm</h2>
            <div class="comments-summary">
                <div class="rating-overview">
                    <div class="average-rating">
                        <span class="rating">4.5</span>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="total-reviews">(45 đánh giá)</span>
                    </div>
                    <div class="rating-bars">
                        <div class="rating-bar">
                            <span>5 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 70%"></div>
                            </div>
                            <span>35</span>
                        </div>
                        <div class="rating-bar">
                            <span>4 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 20%"></div>
                            </div>
                            <span>5</span>
                        </div>
                        <div class="rating-bar">
                            <span>3 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 10%"></div>
                            </div>
                            <span>3</span>
                        </div>
                        <div class="rating-bar">
                            <span>2 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 0%"></div>
                            </div>
                            <span>0</span>
                        </div>
                        <div class="rating-bar">
                            <span>1 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 5%"></div>
                            </div>
                            <span>2</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="comment-form">
                <h3>Viết đánh giá của bạn</h3>
                <form action="" method="POST">
                    <div class="rating-select">
                        <span>Đánh giá của bạn:</span>
                        <div class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5">
                            <label for="star5"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2"><i class="fas fa-star"></i></label>
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1"><i class="fas fa-star"></i></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Họ và tên" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <textarea name="comment" placeholder="Nhận xét của bạn" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Gửi đánh giá</button>
                </form>
            </div>

            <div class="comments-list">
                <div class="comment-item">
                    <div class="user-avatar">
                        <img src="../../Uploads/User/nam.jpg" alt="User Avatar">
                    </div>
                    <div class="comment-content">
                        <div class="user-info">
                            <h4>Nguyễn Văn A</h4>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="comment-date">15/03/2024</span>
                        </div>
                        <p class="comment-text">Sản phẩm rất tốt, đóng gói cẩn thận, giao hàng nhanh!</p>
                        <div class="comment-actions">
                            <button class="like-btn"><i class="far fa-thumbs-up"></i> Hữu ích (12)</button>
                            <button class="reply-btn"><i class="far fa-comment"></i> Trả lời</button>
                        </div>
                    </div>
                </div>
                <!-- Thêm các comment-item khác tương tự -->
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

        // Xử lý tăng giảm số lượng
        const minusBtn = document.querySelector('.minus');
        const plusBtn = document.querySelector('.plus');
        const qtyInput = document.querySelector('.qty-input');

        minusBtn.addEventListener('click', () => {
            const currentValue = parseInt(qtyInput.value);
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', () => {
            const currentValue = parseInt(qtyInput.value);
            qtyInput.value = currentValue + 1;
        });
    </script>
</body>
</html>