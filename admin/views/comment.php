<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bình luận</title>
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
        background: white;
    }
    .table thead {
        background-color: #f8f9fa;
    }
    .table th {
        font-weight: 600;
        color: #495057;
        padding: 15px;
    }
    .table td {
        padding: 15px;
        vertical-align: middle;
    }
    .comment-content {
        max-width: 400px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .btn-action {
        padding: 6px 12px;
        margin: 0 3px;
        border-radius: 4px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .btn-edit {
        background-color: #4CAF50;
        color: white;
    }
    .btn-delete {
        background-color: #f44336;
        color: white;
    }
    .btn-edit:hover {
        background-color: #45a049;
        color: white;
    }
    .btn-delete:hover {
        background-color: #da190b;
        color: white;
    }
    .page-title {
        color: #333;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .alert {
        margin-bottom: 20px;
        border-radius: 8px;
    }
    .alert-success {
        background-color: #e8f5e9;
        border-color: #c8e6c9;
        color: #2e7d32;
    }
    .alert-danger {
        background-color: #ffebee;
        border-color: #ffcdd2;
        color: #c62828;
    }
    .btn-add {
        background-color: #2196F3;
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .btn-add:hover {
        background-color: #1976D2;
        color: white;
    }
    .user-name {
        font-weight: 500;
        color: #1976D2;
    }
    .product-name {
        font-weight: 500;
        color: #333;
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="page-title">Quản lý bình luận</h2>
                    <a href="?action=addComment" class="btn btn-add">
                        <i class="fas fa-plus me-2"></i>Thêm bình luận
                    </a>
                </div>

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

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Người dùng</th>
                                <th>Nội dung bình luận</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td class="product-name"><?php echo htmlspecialchars($comment['pro_name']); ?></td>
                                <td class="user-name"><?php echo htmlspecialchars($comment['user_name']); ?></td>
                                <td class="comment-content"><?php echo htmlspecialchars($comment['content']); ?></td>
                                <td>
                                    <a href="?action=editComment&id=<?php echo $comment['com_id']; ?>" 
                                       class="btn btn-action btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?action=deleteComment&id=<?php echo $comment['com_id']; ?>" 
                                       class="btn btn-action btn-delete"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
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