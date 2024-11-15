<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm danh mục</title>
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
                <h2 class="text-center mb-4">Thêm danh mục mới</h2>
                <form method="POST" action="index.php?action=addCategory" enctype="multipart/form-data"
                    class="border p-4 shadow-sm">
                    <div class="form-group">
                        <label for="cate_name">Tên danh mục:</label>
                        <input type="text" class="form-control" name="cate_name" required>
                    </div>
                    <div class="form-group">
                        <label for="img">Ảnh:</label>
                        <input type="file" class="form-control-file" name="img" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cate_status">Trạng thái:</label>
                        <select name="cate_status" class="form-control">
                            <option value="1">Hiện</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Thêm danh mục</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>