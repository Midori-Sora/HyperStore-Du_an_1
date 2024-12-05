<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết quả tìm kiếm</title>
    <link rel="stylesheet" href="assets/css/client/search.css">
</head>
<body>
    <div class="header">
        <?php include 'client/views/layout/header.php' ?>
    </div>

    <div class="container">
        <div class="search-header">
            <h1>Kết quả tìm kiếm cho "<?php echo htmlspecialchars($_GET['keyword']); ?>"</h1>
            <p>Tìm thấy <?php echo count($products); ?> sản phẩm</p>
        </div>

        <?php if (!empty($products)): ?>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="index.php?action=product-detail&id=<?php echo $product['pro_id']; ?>">
                            <div class="product-image">
                                <img src="Uploads/Product/<?php echo $product['img']; ?>" 
                                     alt="<?php echo $product['pro_name']; ?>">
                            </div>
                            <div class="product-info">
                                <h3 class="product-name"><?php echo $product['pro_name']; ?></h3>
                                <div class="product-meta">
                                    <span class="product-category"><?php echo $product['cate_name']; ?></span>
                                    <span class="product-color"><?php echo $product['color_type']; ?></span>
                                </div>
                                <div class="product-price">
                                    <?php echo number_format($product['price'], 0, ',', '.'); ?>₫
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-search"></i>
                <p>Không tìm thấy sản phẩm nào phù hợp</p>
                <a href="index.php" class="back-home">Quay về trang chủ</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php' ?>
    </div>
</body>
</html>