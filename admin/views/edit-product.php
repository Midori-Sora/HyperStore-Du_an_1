<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .form-control{
        margin: 10px 0;
    }
    .product-image {
        max-width: 200px;
        margin: 10px 0;
    }
    .preview-image {
        max-width: 200px;
        margin-top: 10px;
        display: none;
    }
</style>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="row">
        <main>
            <div class="container">
                <h2>Chỉnh sửa sản phẩm</h2>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=editProduct&id=<?=$product['pro_id']?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm</label>
                        <input class="form-control" type="text" name="pro_name" value="<?=$product['pro_name']?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh sản phẩm</label>
                        <input class="form-control" type="file" name="img" id="imageInput" accept="image/*">
                        <?php if($product['img']): ?>
                            <img src="../Uploads/<?=$product['img']?>" alt="Current product image" class="product-image">
                        <?php endif; ?>
                        <img id="preview" class="preview-image">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá sản phẩm</label>
                        <input class="form-control" type="number" name="price" value="<?=$product['price']?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description"><?=$product['description']?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <input class="form-control" type="text" name="pro_status" value="<?=$product['pro_status']?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select class="form-control" name="cate_id" required>
                            <?php foreach($categories as $category): ?>
                                <option value="<?=$category['cate_id']?>" 
                                    <?php echo ($category['cate_id'] == $product['cate_id']) ? 'selected' : ''; ?>>
                                    <?=$category['cate_name']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button class="btn btn-primary" name="sua" type="submit">Cập nhật</button>
                    <a href="index.php?action=product" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </main>
    </div>
</body>
</html>