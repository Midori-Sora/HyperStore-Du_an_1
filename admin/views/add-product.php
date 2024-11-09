<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .form-control{
        margin: 10px 0;
    }
</style>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="row">
        <main>
            <div class="container">
                <h2>Thêm sản phẩm</h2>
                <form action="index.php?action=addProduct" method="POST" enctype="multipart/form-data">
                    <input class="form-control" type="text" name="pro_name" placeholder="Tên sản phẩm" required>
                    <input class="form-control" type="file" name="img" required>
                    <input class="form-control" type="number" name="price" placeholder="Giá sản phẩm" required>
                    <textarea class="form-control" name="description" placeholder="Mô tả sản phẩm" required></textarea>
                    <input class="form-control" type="text" name="pro_status" placeholder="Trạng thái" required>
                    <select class="form-control" name="cate_id" required>
                        <option value="">Chọn danh mục</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category['cate_id']; ?>"><?php echo $category['cate_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary" name="them" type="submit">Thêm sản phẩm</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html> 