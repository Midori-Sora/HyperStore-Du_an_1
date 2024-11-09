<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="././assets/css/admin/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        padding-top: 80px;
    }
    .main {
        display: flex;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    .main main {
        width: calc(100% - 270px);
        margin-left: 270px;
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }
    .btn-add {
        background: #1976D2;
        color: white;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 500;
    }
    .btn-add:hover {
        background: #1565C0;
        color: white;
        transform: translateY(-2px);
    }
    .table {
        margin-top: 20px;
        border-collapse: separate;
        border-spacing: 0 8px;
    }
    .table th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 15px;
        border: none;
    }
    .table td {
        padding: 15px;
        vertical-align: middle;
        background: white;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }
    .table tr td:first-child {
        border-left: 1px solid #eee;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .table tr td:last-child {
        border-right: 1px solid #eee;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .table tr:hover td {
        background: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }
    .product-image {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
    }
    .btn-action {
        padding: 6px 12px;
        margin: 0 3px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .btn-edit {
        background: #4CAF50;
        color: white;
    }
    .btn-delete {
        background: #f44336;
        color: white;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
                <div class="page-header">
                    <h2>Quản lý sản phẩm</h2>
                    <a href="?action=addProduct" class="btn-add">
                        <i class="fas fa-plus"></i> Thêm sản phẩm mới
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $product): ?>
                            <tr>
                                <td><?php echo $product['pro_id']; ?></td>
                                <td><?php echo $product['pro_name']; ?></td>
                                <td><img src="../Uploads/Product/<?php echo $product['img']; ?>" class="product-image"></td>
                                <td><?php echo number_format($product['price']); ?>đ</td>
                                <td><?php echo $product['pro_status']; ?></td>
                                <td>
                                    <a href="?action=editProduct&id=<?php echo $product['pro_id']; ?>" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?action=deleteProduct&id=<?php echo $product['pro_id']; ?>" 
                                       class="btn-action btn-delete"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
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