<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa danh mục</title>
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
                <h2 class="text-center mb-4">Chỉnh sửa danh mục</h2>
                <form action="index.php?action=updateCategory&id=<?= htmlspecialchars($category['cate_id']) ?>"
                    method="post" enctype="multipart/form-data" class="border p-4 shadow-sm">
                    <div class="form-group">
                        <label for="cate_name">Tên danh mục:</label>
                        <input type="text" class="form-control" name="cate_name"
                            value="<?= htmlspecialchars($category['cate_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Ảnh hiện tại:</label><br>
                        <img src="<?= htmlspecialchars($category['img']) ?>" width="100"><br><br>
                    </div>
                    <div class="form-group">
                        <label for="img">Đổi ảnh:</label>
                        <input type="file" class="form-control-file" name="img" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea class="form-control" name="description"
                            rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cate_status">Trạng thái:</label>
                        <select name="cate_status" class="form-control">
                            <option value="1" <?= $category['cate_status'] == 1 ? 'selected' : '' ?>>Hiện</option>
                            <option value="0" <?= $category['cate_status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Cập nhật danh mục</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>