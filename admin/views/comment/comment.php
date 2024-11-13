<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bình luận</title>
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
    .card-header h2 {
        margin: 0;
        color: #2c3345;
        font-size: 24px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .card-header h2 i {
        color: #4a90e2;
    }
    .table {
        margin-top: 20px;
        border-collapse: separate;
        border-spacing: 0 12px;
    }
    .table thead th {
        border: none;
        background: #f8f9fa;
        padding: 15px;
        font-weight: 600;
        color: #2c3345;
    }
    .comment-item td {
        background: white;
        border: none;
        padding: 20px 15px;
        vertical-align: middle;
    }
    .comment-item {
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
    }
    .comment-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
    }
    .user-name {
        font-weight: 500;
        color: #2c3345;
    }
    .product-link {
        color: #4a90e2;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }
    .product-link:hover {
        color: #357abd;
    }
    .comment-content {
        color: #4a5568;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .comment-date {
        color: #6c757d;
        font-size: 0.9rem;
    }
    .comment-actions {
        display: flex;
        gap: 8px;
    }
    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .btn-danger {
        background: #dc3545;
        border: none;
    }
    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-1px);
    }
    .alert {
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
    }
</style>
<body>
    <header>
        <?php include './views/layout/header.php' ?>
    </header>
    <div class="main">
        <?php include './views/layout/sidebar.php'; ?>
        <main>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-comments"></i>
                            Quản lý bình luận
                        </h2>
                    </div>
                    <div class="card-body">
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
                                        <th>NGƯỜI DÙNG</th>
                                        <th>SẢN PHẨM</th>
                                        <th>NỘI DUNG</th>
                                        <th>THỜI GIAN</th>
                                        <th>THAO TÁC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comments as $comment): ?>
                                    <tr class="comment-item">
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <span class="user-name"><?= htmlspecialchars($comment['username']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="product-link">
                                                <?= htmlspecialchars($comment['pro_name']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="comment-content">
                                                <?= htmlspecialchars($comment['content']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="comment-date">
                                                <i class="far fa-clock me-1"></i>
                                                <?= $comment['import_date'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="comment-actions">
                                                <a href="index.php?action=deleteComment&id=<?= $comment['com_id'] ?>" 
                                                   class="btn btn-danger btn-action"
                                                   onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                                    <i class="fas fa-trash-alt me-1"></i>
                                                    Xóa
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
