<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include "./views/layout/sidebar.php"; ?>
            </div>
            <div class="col-md-10 mt-4">
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
        </div>
    </div>
</body>

</html>