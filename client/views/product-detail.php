<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="../../assets/css/client/product-detail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="header">
        <?php include 'header.php' ?>
    </div>

    <div class="container">
        <div class="product-detail">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="../../Uploads/Product/iphone-11-do.png" alt="iPhone 13" id="mainImage">
                </div>
                <div class="thumbnail-list">
                    <img src="../../Uploads/Product/iphone-11-do.png" alt="" class="thumbnail active">
                    <img src="../../Uploads/Product/iphone-13.png" alt="" class="thumbnail">
                    <img src="../../Uploads/Product/iphone-12-xanhnhat.png" alt="" class="thumbnail">
                    <img src="../../Uploads/Product/iphone-14-vangkim.png" alt="" class="thumbnail">
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-name">iPhone 13 Pro Max 256GB</h1>
                <div class="product-meta">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span>(120 đánh giá)</span>
                    </div>
                    <div class="stock-status in-stock">
                        <i class="fas fa-check-circle"></i> Còn hàng
                    </div>
                </div>

                <div class="product-price">
                    <div class="current-price">13.990.000₫</div>
                    <div class="original-price">15.990.000₫</div>
                    <div class="discount">-12%</div>
                </div>

                <div class="product-variants">
                    <h3>Lựa chọn phiên bản</h3>
                    <div class="variant-options">
                        <button class="variant-btn active">128GB</button>
                        <button class="variant-btn">256GB</button>
                        <button class="variant-btn">512GB</button>
                    </div>
                </div>

                <div class="product-colors">
                    <h3>Màu sắc</h3>
                    <div class="color-options">
                        <button class="color-btn active" style="background-color: #000"></button>
                        <button class="color-btn" style="background-color: #c0c0c0"></button>
                        <button class="color-btn" style="background-color: #ffd700"></button>
                    </div>
                </div>

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
                <!-- Danh sách sản phẩm liên quan -->
            </div>
        </div>
    </div>

    <div class="footer">
        <?php include 'footer.php' ?>
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