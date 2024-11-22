<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
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

    .category-image {
        width: 100px;
        height: 100px;
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

    .category-image-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-image:hover {
        transform: scale(1.1);
    }

    .description-cell {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .description-cell:hover {
        white-space: normal;
        overflow: visible;
        cursor: pointer;
    }

    .table> :not(caption)>*>* {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #dee2e6;
    }

    .empty-state p {
        font-size: 16px;
        margin: 0;
    }

    .alert {
        border: none;
        border-radius: 10px;
        padding: 15px 20px;
    }

    .alert-success {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .alert-danger {
        background-color: #ffebee;
        color: #c62828;
    }

    .modal-preview {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1050;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .modal-preview img {
        max-width: 90%;
        max-height: 90vh;
        object-fit: contain;
        border-radius: 8px;
        cursor: default;
    }

    .category-image-wrapper {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }

    .category-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-image:hover {
        transform: scale(1.1);
    }

    .modal-confirm {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .btn-action {
        min-width: 80px;
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
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-folder me-2"></i>
                            Quản lý danh mục
                        </h2>
                        <a href="index.php?action=addCategory" class="btn-add">
                            <i class="fas fa-plus"></i>
                            Thêm danh mục
                        </a>
                    </div>

                    <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= htmlspecialchars($_SESSION['success']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']);
                    endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($_SESSION['error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']);
                    endif; ?>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Tên</th>
                                    <th width="15%">Ảnh</th>
                                    <th width="30%">Mô tả</th>
                                    <th width="10%">Trạng thái</th>
                                    <th width="20%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                <?php
                                    // Tạo mảng để kiểm tra ID đã hiển thị
                                    $displayed_ids = [];
                                    ?>
                                <?php foreach ($categories as $category): ?>
                                <?php
                                        // Kiểm tra nếu ID đã hiển thị thì bỏ qua
                                        if (in_array($category['cate_id'], $displayed_ids)) continue;
                                        $displayed_ids[] = $category['cate_id'];
                                        ?>
                                <tr>
                                    <td><?= htmlspecialchars($category['cate_id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($category['cate_name'] ?? '') ?></td>
                                    <td>
                                        <div class="category-image-wrapper">
                                            <img src="../<?= htmlspecialchars($category['img']) ?>"
                                                alt="<?= htmlspecialchars($category['cate_name']) ?>"
                                                class="category-image" onclick="showImagePreview(this.src)"
                                                onerror="this.src='../assets/images/default-category.jpg'">
                                        </div>
                                    </td>
                                    <td class="description-cell"
                                        title="<?= htmlspecialchars($category['description'] ?? '') ?>">
                                        <?= htmlspecialchars($category['description'] ?? '') ?>
                                    </td>
                                    <td>
                                        <span
                                            class="status-badge <?= ($category['cate_status'] ?? 0) ? 'status-active' : 'status-inactive' ?>">
                                            <?= ($category['cate_status'] ?? 0) ? 'Hiển thị' : 'Ẩn' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="index.php?action=editCategory&id=<?= htmlspecialchars($category['cate_id'] ?? '') ?>"
                                                class="btn btn-success btn-action">
                                                <i class="fas fa-edit me-1"></i>Sửa
                                            </a>
                                            <button
                                                onclick="confirmDelete(<?= htmlspecialchars($category['cate_id'] ?? '') ?>)"
                                                class="btn btn-danger btn-action">
                                                <i class="fas fa-trash me-1"></i>Xóa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-folder-open"></i>
                                            <p>Chưa có danh mục nào</p>
                                        </div>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Preview Image -->
    <div class="modal-preview" id="imagePreviewModal" onclick="hideImagePreview()">
        <img id="previewImage" src="" alt="Preview">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showImagePreview(src) {
        const modal = document.getElementById('imagePreviewModal');
        const img = document.getElementById('previewImage');
        img.src = src;
        modal.style.display = 'flex';
    }

    function hideImagePreview() {
        document.getElementById('imagePreviewModal').style.display = 'none';
    }

    function confirmDelete(id) {
        if (!id) return;

        if (confirm('Bạn có chắc muốn xóa danh mục này?')) {
            window.location.href = `index.php?action=deleteCategory&id=${id}`;
        }
    }

    // Đóng modal khi nhấn ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideImagePreview();
        }
    });
    </script>
</body>

</html>