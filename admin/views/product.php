<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="././assets/css/admin/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        background: #f5f5f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    header {
        margin-bottom: 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .main {
        display: flex;
        justify-content: space-between;
        max-width: 1400px;
        margin: auto;
        padding: 0 20px;
    }
    .main .sidebar {
        width: 20%;
    }
    .main main {
        width: 78%;
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .table {
        margin-top: 20px;
    }
    .table thead {
        background-color: #f8f9fa;
    }
    .table th {
        font-weight: 600;
        color: #495057;
        vertical-align: middle;
    }
    .table td {
        vertical-align: middle;
    }
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }
    .btn-action {
        padding: 5px 15px;
        margin: 0 5px;
        border-radius: 5px;
        font-size: 14px;
    }
    .btn-edit {
        background-color: #4CAF50;
        color: white;
        border: none;
    }
    .btn-delete {
        background-color: #f44336;
        color: white;
        border: none;
    }
    .btn-edit:hover {
        background-color: #45a049;
    }
    .btn-delete:hover {
        background-color: #da190b;
    }
    .page-title {
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .alert {
        margin-bottom: 20px;
    }
    .product-status {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-active {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    .status-inactive {
        background-color: #ffebee;
        color: #c62828;
    }
</style>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="main">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <main>
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="page-title">Quản lý sản phẩm</h2>
                    <a href="?action=addProduct" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm sản phẩm mới
                    </a>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i>
                        <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td><?php echo $product['pro_id']; ?></td>
                                    <td>
                                        <img src="../Uploads/<?php echo $product['img']?>" 
                                             class="product-image" 
                                             alt="<?php echo $product['pro_name']; ?>">
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?php echo $product['pro_name']; ?></div>
                                        <small class="text-muted">Lượt xem: <?php echo $product['pro_view']; ?></small>
                                    </td>
                                    <td><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</td>
                                    <td><?php echo $product['cate_name']; ?></td>
                                    <td>
                                        <span class="product-status <?php echo $product['pro_status'] == 'active' ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $product['pro_status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a class="btn btn-action btn-edit" 
                                           href="?action=editProduct&id=<?php echo $product['pro_id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-action btn-delete" 
                                           href="?action=deleteProduct&id=<?php echo $product['pro_id']; ?>"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>