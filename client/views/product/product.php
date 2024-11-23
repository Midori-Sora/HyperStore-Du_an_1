<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - HyperStore</title>
    <link rel="stylesheet" href="assets/css/client/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="header">
        <?php include 'client/views/layout/header.php'; ?>
    </div>

    <div class="category">
        <div class="sidebar">
            <?php include 'client/views/layout/sidebar.php' ?>
        </div>

        <div class="product-container">
            <div class="category-title">
                <h2>Sản Phẩm Mới Nhất</h2>
                <div class="product-filters">
                    <select class="filter-select">
                        <option value="">Sắp xếp theo</option>
                        <option value="price-asc">Giá tăng dần</option>
                        <option value="price-desc">Giá giảm dần</option>
                        <option value="name-asc">Tên A-Z</option>
                        <option value="name-desc">Tên Z-A</option>
                    </select>
                </div>
            </div>

            <?php if (!empty($products)) : ?>
                <div class="product-list">
                    <?php foreach ($products as $product) : ?>
                        <div class="product-box">
                            <a href="?action=product-detail&id=<?php echo $product['pro_id']; ?>">
                            <div class="product-image">
                                <img src="Uploads/Product/<?php echo $product['img']; ?>"
                                    alt="<?php echo $product['pro_name']; ?>">
                                    <?php if ($product['current_discount'] > 0) : ?>
                                        <div class="discount">
                                            -<?php echo $product['current_discount']; ?>%
                                        </div>
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
                                <h3 class="product-name">
                                    <?php echo $product['pro_name']; ?>
                                </h3>
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
                                <div class="product-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</div>
                                <div class="product-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span>(45)</span>
                                </div>
                            </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <p>Không có sản phẩm nào.</p>
                </div>
            <?php endif; ?>

            <div class="pagination">
                <a href="#" class="page-link active">1</a>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">3</a>
                <a href="#" class="page-link">
                    <i class="fas fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php'; ?>
    </div>
</body>

</html>