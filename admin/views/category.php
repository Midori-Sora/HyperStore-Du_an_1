<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Danh Sách Danh Mục</h2>
        <div class="text-right mb-3">
            <a href="index.php?action=addCategory" class="btn btn-success">Thêm Danh Mục</a>
        </div>
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
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
                            <td><?= htmlspecialchars($category['cate_name'] ?? '') ?></td>
                            <td>
                                <img src="<?= !empty($category['img']) ? htmlspecialchars($category['img']) : 'path/to/default_image.jpg' ?>"
                                    width="50" alt="Category Image">
                            </td>
                            <td><?= htmlspecialchars($category['description'] ?? '') ?></td>
                            <td><?= $category['cate_status'] ? 'Hiện' : 'Ẩn' ?></td>
                            <td>
                                <a href="index.php?action=editCategory&id=<?= htmlspecialchars($category['cate_id'] ?? '') ?>"
                                    class="btn btn-warning btn-sm">Sửa</a>
                                <a href="index.php?action=deleteCategory&id=<?= htmlspecialchars($category['cate_id'] ?? '') ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có danh mục nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>