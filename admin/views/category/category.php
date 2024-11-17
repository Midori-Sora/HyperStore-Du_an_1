<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        .category-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .description-cell {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .description-cell:hover {
            white-space: normal;
            overflow: visible;
            background-color: #fff;
            position: relative;
            z-index: 1;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 4px;
            padding: 8px;
        }

        .action-column {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
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
            opacity: 0.9;
        }

        .badge {
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }
    </style>
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="main">
        <div class="sidebar">
            <?php include "./views/layout/sidebar.php"; ?>
        </div>
        <main>
            <div class="container-fluid">
                <div class="page-header">
                    <h2>Quản lý danh mục</h2>
                    <a href="index.php?action=addCategory" class="btn-add">
                        <i class="fas fa-plus me-2"></i>Thêm danh mục
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
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Ảnh</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($category['cate_id'] ?? '') ?></td>
                                        <td class="fw-bold"><?= htmlspecialchars($category['cate_name'] ?? '') ?></td>
                                        <td>
                                            <img src="<?= !empty($category['img']) ? htmlspecialchars($category['img']) : 'path/to/default_image.jpg' ?>"
                                                class="category-image" alt="Category Image">
                                        </td>
                                        <td class="description-cell" title="<?= htmlspecialchars($category['description'] ?? '') ?>">
                                            <?= htmlspecialchars($category['description'] ?? '') ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $category['cate_status'] ? 'bg-success' : 'bg-danger' ?>">
                                                <?= $category['cate_status'] ? 'Hiện' : 'Ẩn' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-column">
                                                <a href="index.php?action=editCategory&id=<?= htmlspecialchars($category['cate_id'] ?? '') ?>"
                                                    class="btn-action btn-edit" title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="index.php?action=deleteCategory&id=<?= htmlspecialchars($category['cate_id'] ?? '') ?>"
                                                    class="btn-action btn-delete" title="Xóa"
                                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-folder-open me-2"></i>Không có danh mục nào.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>