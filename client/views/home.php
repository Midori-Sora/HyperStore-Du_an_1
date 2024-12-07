<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/client/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="header">
        <?php include 'layout/header.php' ?>
    </div>

    <div class="category">
        <div class="sidebar">
            <?php include 'layout/sidebar.php' ?>
        </div>
        <div class="slideshowimg">
            <?php include 'layout/slideshow.php' ?>
        </div>
        <div class="right-banner">
            <img src="Uploads/Slides/s1.png" alt="">
            <img src="Uploads/Slides/s8.png" alt="">
            <img src="Uploads/Slides/s3.png" alt="">
        </div>
    </div>

    <div class="category-list">
        <div class="category-item" id="hot-sale">
            <div class="category-title">
                <h2> <i class="fa-solid fa-fire"></i>HOT SALE <span>CUỐI TUẦN</span></h2>
                <a href="#" class="all">Xem tất cả <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="time">
                <span>Thời gian: &ensp;</span>
                <?php if (!empty($discountProducts[0]['formatted_start_date']) && !empty($discountProducts[0]['formatted_end_date'])): ?>
                    <span><?php echo $discountProducts[0]['formatted_start_date']; ?> - <?php echo $discountProducts[0]['formatted_end_date']; ?></span>
                <?php else: ?>
                    <span>Không có khuyến mãi</span>
                <?php endif; ?>
            </div>
            <div class="product-list">
                <?php foreach ($discountProducts as $product): ?>
                    <div class="product-box">
                        <a href="?action=product-detail&id=<?php echo $product['pro_id']; ?>">
                            <div class="product-image">
                                <img src="Uploads/Product/<?php echo $product['img']; ?>" alt="<?php echo $product['pro_name']; ?>">
                                <div class="product-actions">
                                    <button class="action-btn"><i class="fas fa-heart"></i></button>
                                    <form action="index.php?action=add-to-cart" method="POST" class="cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="action-btn">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="product-infor">
                                <h3 class="product-name"><?php echo $product['pro_name']; ?></h3>
                                <div class="product-meta">
                                    <?php if (!empty($product['storage_type'])) : ?>
                                        <span class="product-specs">
                                            <i class="fas fa-microchip"></i> <?php echo $product['storage_type']; ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($product['color_type'])) : ?>
                                        <span class="product-color">
                                            <i class="fas fa-palette"></i> <?php echo $product['color_type']; ?>
                                        </span>
                                    <?php endif; ?>
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
                                            <span class="original-price">
                                                <?php echo number_format($total_price, 0, ',', '.'); ?>₫
                                            </span>
                                            <span class="discount-price">
                                                <?php echo number_format($discount_price, 0, ',', '.'); ?>₫
                                            </span>
                                            <span class="discount-percent">
                                                -<?php echo $product['discount']; ?>%
                                            </span>
                                        </div>
                                    <?php else : ?>
                                        <span class="normal-price">
                                            <?php echo number_format($total_price, 0, ',', '.'); ?>₫
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="category-list">
        <div class="category-item">
            <div class="category-title">
                <h2>Sản phẩm nổi bật</h2>
                <a href="#" class="all">Xem tất cả <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-list">
                <?php foreach ($featuredProducts as $product): ?>
                    <div class="product-box">
                        <a href="?action=product-detail&id=<?php echo $product['pro_id']; ?>">
                            <div class="product-image">
                                <img src="Uploads/Product/<?php echo $product['img']; ?>" alt="<?php echo $product['pro_name']; ?>">
                                <?php if (!empty($product['discount'])) : ?>
                                    <span class="discount-label">-<?php echo $product['discount']; ?>%</span>
                                <?php endif; ?>
                                <div class="product-actions">
                                    <button class="action-btn"><i class="fas fa-heart"></i></button>
                                    <form action="index.php?action=add-to-cart" method="POST" class="cart-form">
                                        <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="action-btn">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="product-infor">
                                <h3 class="product-name"><?php echo $product['pro_name']; ?></h3>
                                <div class="product-meta">
                                    <?php if (!empty($product['storage_type'])) : ?>
                                        <span class="product-specs">
                                            <i class="fas fa-microchip"></i> <?php echo $product['storage_type']; ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($product['color_type'])) : ?>
                                        <span class="product-color">
                                            <i class="fas fa-palette"></i> <?php echo $product['color_type']; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-price">
                                    <?php if (!empty($product['discount'])) : ?>
                                        <div class="price-wrapper">
                                            <span class="original-price"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>₫</span>
                                            <span class="discount-price"><?php echo number_format($product['discount_price'], 0, ',', '.'); ?>₫</span>
                                            <span class="discount-percent">
                                                -<?php echo $product['discount']; ?>%
                                            </span>
                                        </div>
                                    <?php else : ?>
                                        <span class="normal-price"><?php echo number_format($product['original_price'], 0, ',', '.'); ?>₫</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="category-list">
        <div class="category-item">
            <div class="category-title">
                <h2>Điện thoại mới nhất</h2>
                <a href="#" class="all">Xem tất cả <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-list">
                <?php foreach ($newestPhones as $phone): ?>
                    <a href="?action=product-detail&id=<?php echo $phone['pro_id']; ?>" class="product-box">
                        <div class="product-image">
                            <img src="Uploads/Product/<?php echo $phone['img']; ?>" alt="<?php echo $phone['pro_name']; ?>">
                            <div class="product-actions">
                                <button class="action-btn"><i class="fas fa-heart"></i></button>
                                <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                            </div>
                        </div>
                        <div class="product-infor">
                            <h3 class="product-name"><?php echo $phone['pro_name']; ?></h3>
                            <div class="product-meta">
                                <?php if (!empty($product['storage_type'])) : ?>
                                    <span class="product-specs">
                                        <i class="fas fa-microchip"></i> <?php echo $product['storage_type']; ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($product['color_type'])) : ?>
                                    <span class="product-color">
                                        <i class="fas fa-palette"></i> <?php echo $phone['color_type']; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="product-price"><?php echo number_format($phone['price'], 0, ',', '.'); ?>₫</div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="special-offers">
        <div class="section_title">
            <h2><a href="#">Khuyến mãi đặc biệt</a></h2>
            <p>Ưu đãi độc quyền - Giá tốt nhất thị trường</p>
        </div>
        <div class="offers-grid">
            <div class="offer-item">
                <div class="offer-image">
                    <img src="Uploads/News/Co-nen-mua-tecno-spark-30c-2.jpg" alt="">
                    <div class="offer-tag">Giảm 20%</div>
                </div>
                <div class="offer-info">
                    <h3>Flash Sale Cuối Tuần</h3>
                    <p>Từ 15/3 - 17/3</p>
                    <a href="#" class="offer-btn">Xem ngay</a>
                </div>
            </div>
            <div class="offer-item">
                <div class="offer-image">
                    <img src="Uploads/News/Co-nen-mua-tecno-spark-30c-2.jpg" alt="">
                    <div class="offer-tag">Quà tặng</div>
                </div>
                <div class="offer-info">
                    <h3>Ưu đãi sinh viên</h3>
                    <p>Giảm thêm 5%</p>
                    <a href="#" class="offer-btn">Xem ngay</a>
                </div>
            </div>
            <div class="offer-item">
                <div class="offer-image">
                    <img src="Uploads/News/Co-nen-mua-tecno-spark-30c-2.jpg" alt="">
                    <div class="offer-tag">Quà tặng</div>
                </div>
                <div class="offer-info">
                    <h3>Ưu đãi sinh viên</h3>
                    <p>Giảm thêm 5%</p>
                    <a href="#" class="offer-btn">Xem ngay</a>
                </div>
            </div>
        </div>
    </div>

    <div class="section_banner">
        <div class="item">
            <img src="Uploads/Banner/Frame 2012 (2).png" alt="">
        </div>
        <div class="item">
            <img src="Uploads/Banner/Frame 2013 (2).png" alt="">
        </div>
    </div>

    <div class="section_blog">
        <div class="section_title">
            <h2><a href="#">Tin tức công nghệ</a></h2>
            <p>Cập nhật tin tức công nghệ mới nhất mỗi ngày</p>
        </div>
        <div class="blog-list">
            <div class="blog-item">
                <div class="blog-image">
                    <img src="Uploads/News/Co-nen-mua-tecno-spark-30c-2.jpg" alt="">
                </div>
                <div class="blog-infor">
                    <h3 class="blog-title">Có nên mua TECNO Spark 30C thời điểm hiện tại?</h3>
                    <p class="blog-describe">OPPO vừa ra mắt 2 flagship mới nhất mang tên Find X8 và Find X8 Pro với hàng loạt cải tiến vư���t trội so với các thế hệ trước. Bên cạnh đó, thông tin OPPO Find X8 Mini cũng đang thu hút sự chú ý. Theo các rò rỉ, phiên bản nhỏ gọn này có thể sẽ được ra...</p>
                    <a href="#">Đọc thêm</a>
                </div>
            </div>
            <div class="blog-item">
                <div class="blog-image">
                    <img src="Uploads/News/mau-sac-TECNO-Spark-30C-1.jpg" alt="">
                </div>
                <div class="blog-infor">
                    <h3 class="blog-title">Thông tin về màu sắc TECNO Spark 30C kèm những ưu điểm nổi bật</h3>
                    <p class="blog-describe">TECNO Spark 30C vừa ra mắt đã nhanh chóng thu hút sự chú ý của các tín đồ công nghệ nhờ mức giá hợp lý và nhiều tính năng nổi bật. Tuy nhiên, điều khiến người dùng tò mò nhất lúc này chính là màu sắc TECNO Spark 30C. Vậy sau đây là những thông tin về...</p>
                    <a href="#">Đọc thêm</a>
                </div>
            </div>
            <div class="blog-item">
                <div class="blog-image">
                    <img src="Uploads/News/mau-sac-TECNO-Spark-30C-2.jpg" alt="">
                </div>
                <div class="blog-infor">
                    <h3 class="blog-title">HONOR X7c có gì nổi bật để thu hút khách hàng chọn mua?</h3>
                    <p class="blog-describe">Ngay khi ra mắt, mẫu smartphone tầm trung mới HONOR X7c đã nhận được sự quan tâm của đông đảo người dùng yêu thích thương hiệu này. Vậy HONOR X7c có gì nổi bật để thu hút khách hng? Hãy cùng chúng mình tìm lời giải đáp ngay trong bài viết bên dưới nhé...</p>
                    <a href="#">Đọc thêm</a>
                </div>
            </div>
            <div class="blog-item">
                <div class="blog-image">
                    <img src="Uploads/News/thong-tin-OPPO-Find-X8-Mini-4.jpg" alt="">
                </div>
                <div class="blog-infor">
                    <h3 class="blog-title">Thông tin OPPO Find X8 Mini dần được tiết lộ, khả năng ra mắt cùng Find X8 Ultra</h3>
                    <p class="blog-describe">OPPO vừa ra mắt 2 flagship mới nhất mang tên Find X8 và Find X8 Pro với hàng loạt cải tiến vượt trội so với các thế hệ trước. Bên cạnh đó, thông tin OPPO Find X8 Mini cũng đang thu hút sự chú ý. Theo các rò rỉ, phiên bản nhỏ gọn này có thể sẽ được ra...</p>
                    <a href="#">Đọc thêm</a>
                </div>
            </div>
            <!-- Thêm các blog-item khác tương tự -->
        </div>
    </div>

    <div class="footer">
        <?php include 'layout/footer.php' ?>
    </div>
</body>
</html>