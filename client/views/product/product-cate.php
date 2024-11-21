<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category['cate_name']; ?> - HyperStore</title>
    <link rel="stylesheet" href="assets/css/client/product-cate.css">
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
                <h2><?php echo $category['cate_name']; ?></h2>
            </div>

            <?php if (!empty($products)) : ?>
            <div class="product-list">
                <?php foreach ($products as $product) : ?>
                <div class="product-box">
                    <div class="product-image">
                        <img src="Uploads/Product/<?php echo $product['img']; ?>"
                            alt="<?php echo $product['pro_name']; ?>">
                        <div class="product-actions">
                            <button class="action-btn"><i class="fas fa-heart"></i></button>
                            <button class="action-btn"><i class="fas fa-shopping-cart"></i></button>
                        </div>
                    </div>
                    <div class="product-infor">
                        <h3 class="product-name">
                            <a href="index.php?action=product-detail&id=<?php echo $product['pro_id']; ?>">
                                <?php echo $product['pro_name']; ?>
                            </a>
                        </h3>
                        <div class="product-price">
                            <?php echo number_format($product['price'], 0, ',', '.'); ?>₫
                        </div>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span>(45)</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else : ?>
            <div class="no-products">
                <i class="fas fa-box-open"></i>
                <p>Không có sản phẩm nào trong danh mục này.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php'; ?>
    </div>
</body>

</html>