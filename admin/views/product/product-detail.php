<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    body {
        background: #f8f9fa;
        padding-top: 80px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .main {
        display: flex;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    main {
        width: calc(100% - 270px);
        margin-left: 270px;
    }
    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 30px;
        margin-bottom: 20px;
        border: none;
    }
    .card-header {
        background: none;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .product-image {
        width: 100%;
        max-width: 400px;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .product-info {
        padding: 20px;
    }
    .product-title {
        font-size: 24px;
        font-weight: 600;
        color: #2c3345;
        margin-bottom: 15px;
    }
    .product-price {
        font-size: 28px;
        color: #1976D2;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .product-meta {
        margin-bottom: 15px;
        color: #6c757d;
    }
    .meta-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .meta-item i {
        width: 25px;
        color: #1976D2;
    }
    .product-description {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #eee;
    }
    .variant-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .status-badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
    }
    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .status-inactive {
        background: #ffebee;
        color: #c62828;
    }
    .btn-back {
        background: #1976D2;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back:hover {
        background: #1565C0;
        color: white;
        transform: translateY(-2px);
    }
</style>

<body>
    <?php include "./views/layout/header.php" ?>
    
    <div class="main">
        <?php include "./views/layout/sidebar.php" ?>
        
        <main>
            <div class="container">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2><i class="fas fa-info-circle me-2"></i>Chi tiết sản phẩm</h2>
                        <a href="?action=product" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Quay lại
                        </a>
                    </div>

                    <div class="row">
                        <!-- Ảnh sản phẩm -->
                        <div class="col-md-5">
                            <img src="../Uploads/Product/<?php echo $product['img']; ?>" 
                                 class="product-image"
                                 alt="<?php echo $product['pro_name']; ?>">
                        </div>

                        <!-- Thông tin sản phẩm -->
                        <div class="col-md-7 product-info">
                            <h1 class="product-title"><?php echo $product['pro_name']; ?></h1>
                            
                            <div class="product-price">
                                <?php echo number_format($product['price'], 0, ',', '.'); ?> đ
                            </div>

                            <div class="product-meta">
                                <div class="meta-item">
                                    <i class="fas fa-folder me-2"></i>
                                    <span>Danh mục: <?php echo $product['cate_name']; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-boxes me-2"></i>
                                    <span>Số lượng: <?php echo $product['quantity']; ?></span>
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-circle-check me-2"></i>
                                    <span>Trạng thái: 
                                        <span class="status-badge <?php echo $product['pro_status'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $product['pro_status'] == 1 ? 'Hoạt động' : 'Không hoạt động'; ?>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <!-- Thông tin biến thể -->
                            <div class="variant-info">
                                <h5><i class="fas fa-memory me-2"></i>RAM</h5>
                                <p><?php echo $product['ram_type']; ?> 
                                   (+<?php echo number_format($product['ram_price'], 0, ',', '.'); ?> đ)</p>
                            </div>

                            <div class="variant-info">
                                <h5><i class="fas fa-palette me-2"></i>Màu sắc</h5>
                                <p><?php echo $product['color_type']; ?> 
                                   (+<?php echo number_format($product['color_price'], 0, ',', '.'); ?> đ)</p>
                            </div>

                            <!-- Mô tả sản phẩm -->
                            <div class="product-description">
                                <h5><i class="fas fa-align-left me-2"></i>Mô tả sản phẩm</h5>
                                <p><?php echo nl2br($product['description']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
