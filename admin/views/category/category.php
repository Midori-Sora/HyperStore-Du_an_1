<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .page-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }
        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: #3498db;
        }
        .btn-add-category {
            margin-bottom: 20px;
            padding: 8px 20px;
            border-radius: 5px;
        }
        .table thead th {
            background-color: #34495e;
            color: white;
            border: none;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: all 0.3s;
        }
        .action-buttons .btn {
            margin: 0 3px;
            padding: 5px 15px;
        }
        .category-image {
            border-radius: 5px;
            object-fit: cover;
            border: 1px solid #ddd;
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
    </style>
</head>

<body class="bg-light">
    <?php include "./views/layout/header.php"; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include "./views/layout/sidebar.php"; ?>
            </div>
            <div class="col-md-10 mt-4">
                <div class="table-container">
                    <h2 class="text-center page-title">Danh Sách Danh Mục</h2>
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
                    <div class="d-flex justify-content-end">
                        <a href="index.php?action=addCategory" class="btn btn-success btn-add-category">
                            <i class="fas fa-plus me-2"></i>Thêm Danh Mục
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Ảnh</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
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
                                                    class="category-image" width="60" height="60" alt="Category Image">
                                            </td>
                                            <td class="description-cell" title="<?= htmlspecialchars($category['description'] ?? '') ?>">
                                                <?= htmlspecialchars($category['description'] ?? '') ?>
                                            </td>
                                            <td>
                                                <span class="badge <?= $category['cate_status'] ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $category['cate_status'] ? 'Hiện' : 'Ẩn' ?>
                                                </span>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="index.php?action=editCategory&id=<?= htmlspecialchars($category['cate_id'] ?? '') ?>"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit me-1"></i>Sửa
                                                </a>
                                                <a href="index.php?action=deleteCategory&id=<?= htmlspecialchars($category['cate_id'] ?? '') ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
                                                    <i class="fas fa-trash-alt me-1"></i>Xóa
                                                </a>
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
            </div>
        </div>
    </div>
</body>

</html>