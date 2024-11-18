<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-add {
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
    .btn-add:hover {
        background: #1565C0;
        color: white;
        transform: translateY(-2px);
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .btn-action {
        padding: 8px 15px;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }
    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .status-inactive {
        background: #ffebee;
        color: #c62828;
    }
    .option-item {
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        display: inline-block;
    }
    .price-tag {
        color: #28a745;
        font-weight: 500;
        margin-left: 4px;
    }
</style>
<body>
    <header>
        <?php include './views/layout/header.php' ?>
    </header>
    <div class="main">
        <div class="sidebar">
            <?php include './views/layout/sidebar.php'; ?>
        </div>
        <main>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-box me-2"></i>
                            Quản lý sản phẩm
                        </h2>
                        <a href="?action=addProduct" class="btn-add">
                            <i class="fas fa-plus"></i>
                            Thêm sản phẩm mới
                        </a>
                    </div>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="15%">Tên sản phẩm</th>
                                    <th width="10%">Hình ảnh</th>
                                    <th width="10%">Giá gốc</th>
                                    <th width="10%">Số lượng</th>
                                    <th width="10%">Danh mục</th>
                                    <th width="10%">Trạng thái</th>
                                    <th width="20%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['pro_id']; ?></td>
                                        <td><?php echo $product['pro_name']; ?></td>
                                        <td>
                                            <img src="../Uploads/Product/<?php echo $product['img']; ?>" 
                                                 class="product-image"
                                                 alt="Product">
                                        </td>
                                        <td>
                                            <strong><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</strong>
                                        </td>
                                        <td>
                                            <?php echo $product['quantity']; ?>
                                        </td>
                                        <td><?php echo $product['cate_name']; ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $product['pro_status'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                                <?php echo $product['pro_status'] == 1 ? 'Hoạt động' : 'Không hoạt động'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="?action=productDetail&id=<?php echo $product['pro_id']; ?>" 
                                                class="btn btn-info btn-action me-2">
                                                <i class="fas fa-eye me-1"></i>
                                                Chi tiết
                                            </a>
                                            <a href="?action=editProduct&id=<?php echo $product['pro_id']; ?>" 
                                               class="btn btn-success btn-action me-2">
                                                <i class="fas fa-edit me-1"></i>
                                                Sửa
                                            </a>
                                            <a href="?action=deleteProduct&id=<?php echo $product['pro_id']; ?>" 
                                               class="btn btn-danger btn-action"
                                               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                <i class="fas fa-trash me-1"></i>
                                                Xóa
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>