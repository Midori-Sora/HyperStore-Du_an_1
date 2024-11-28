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

        <div class="product-container container">
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
                                        <div class="discount-badge">
                                            -<?php echo $product['current_discount']; ?>%
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name"><?php echo $product['pro_name']; ?></h3>
                                    <div class="product-meta">
                                        <?php if (!empty($product['storage_type'])) : ?>
                                            <div class="storage-container">
                                                <i class="fa-solid fa-memory"></i>
                                                <span class="storage"><?php echo $product['storage_type']; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($product['color_type'])) : ?>
                                            <div class="color-container">
                                                <i class="fa-solid fa-palette"></i>
                                                <span class="color"><?php echo $product['color_type']; ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-price">
                                        <?php if ($product['current_discount'] > 0) : ?>
                                            <span class="original-price">
                                                <?php echo number_format($product['final_price'], 0, ',', '.'); ?>₫
                                            </span>
                                            <span class="discounted-price">
                                                <?php echo number_format($product['discounted_price'], 0, ',', '.'); ?>₫
                                            </span>
                                        <?php else : ?>
                                            <span class="price">
                                                <?php echo number_format($product['final_price'], 0, ',', '.'); ?>₫
                                            </span>
                                        <?php endif; ?>
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
                <?php if ($totalPages > 1): ?>
                    <!-- Nút Previous -->
                    <?php if ($currentPage > 1): ?>
                        <a href="?action=product&page=<?php echo ($currentPage - 1); ?>" class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>

                    <!-- Các số trang -->
                    <?php
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $currentPage + 2);
                    
                    if ($startPage > 1): ?>
                        <a href="?action=product&page=1" class="page-link">1</a>
                        <?php if ($startPage > 2): ?>
                            <span class="page-dots">...</span>
                        <?php endif;
                    endif;

                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <a href="?action=product&page=<?php echo $i; ?>" 
                           class="page-link <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor;

                    if ($endPage < $totalPages): ?>
                        <?php if ($endPage < $totalPages - 1): ?>
                            <span class="page-dots">...</span>
                        <?php endif; ?>
                        <a href="?action=product&page=<?php echo $totalPages; ?>" class="page-link">
                            <?php echo $totalPages; ?>
                        </a>
                    <?php endif; ?>

                    <!-- Nút Next -->
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?action=product&page=<?php echo ($currentPage + 1); ?>" class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php'; ?>
    </div>
</body>

</html>