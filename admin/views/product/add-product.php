<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    body {
        background: #f5f5f5;
        padding-top: 80px;
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
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
    }
    .card-header {
        background: none;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    .card-header h2 {
        margin: 0;
        color: #2c3345;
        font-size: 24px;
        font-weight: 600;
    }
    .form-label {
        font-weight: 500;
        color: #2c3345;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #dce0e4;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        border-color: #1976D2;
        box-shadow: 0 0 0 0.2rem rgba(25,118,210,0.1);
    }
    textarea.form-control {
        min-height: 120px;
    }
    .form-select {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #dce0e4;
        margin-bottom: 20px;
        height: auto;
        max-height: none;
        position: relative;
    }
    .form-select:focus {
        position: relative;
        z-index: 1000;
        border-color: #1976D2;
        box-shadow: 0 0 0 0.2rem rgba(25,118,210,0.1);
    }
    .form-select option {
        padding: 8px;
        background-color: white;
        color: #2c3345;
    }
    .form-select option:hover {
        background-color: #f8f9fa;
    }
    .btn-submit {
        background: #1976D2;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        background: #1565C0;
        transform: translateY(-2px);
    }
    .btn-cancel {
        background: #f5f5f5;
        color: #666;
        padding: 12px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        margin-right: 10px;
        transition: all 0.3s ease;
    }
    .btn-cancel:hover {
        background: #e0e0e0;
    }
    .image-preview {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }
    .preview-image {
        max-width: 200px;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: none;
    }
    .image-select-container {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .price-increase {
        color: #666;
        font-size: 0.9em;
        margin-left: 5px;
    }
</style>
<body>
    <header>
        <?php include './views/layout/header.php' ?>
    </header>
    <div class="main">
        <div class="sidebar">
            <?php include './views/layout/sidebar.php'; ?>
        </div>
        <main>
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-plus-circle me-2"></i>Thêm sản phẩm mới</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <form action="index.php?action=addProduct" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên sản phẩm</label>
                                        <input class="form-control" type="text" name="pro_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Giá sản phẩm</label>
                                        <input class="form-control" type="number" name="price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Danh mục</label>
                                        <select class="form-select" name="cate_id" required>
                                            <option value="">Chọn danh mục</option>
                                            <?php foreach($categories as $category): ?>
                                                <option value="<?php echo $category['cate_id']; ?>">
                                                    <?php echo $category['cate_name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Bộ nhớ</label>
                                        <select class="form-select" name="storage_id" required>
                                            <option value="">Chọn bộ nhớ</option>
                                            <?php foreach($storageOptions as $storage): ?>
                                                <option value="<?php echo $storage['storage_id']; ?>">
                                                    <?php echo $storage['storage_type'] . ' (+' . number_format($storage['storage_price'], 0, ',', '.') . 'đ)'; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Màu sắc</label>
                                        <select class="form-select" name="color_id" required>
                                            <option value="">Chọn màu</option>
                                            <?php foreach($colorOptions as $color): ?>
                                                <option value="<?php echo $color['color_id']; ?>">
                                                    <?php echo $color['color_type'] . ' (+' . number_format($color['color_price'], 0, ',', '.') . 'đ)'; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Số lượng</label>
                                        <input class="form-control" type="number" name="quantity" min="0" value="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh sản phẩm</label>
                                        <div class="image-select-container">
                                            <select class="form-select" name="img" id="imageSelect" required>
                                                <option value="">Chọn ảnh sản phẩm</option>
                                                <?php 
                                                $imageDir = '../Uploads/Product/';
                                                $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                                foreach($images as $image): 
                                                    $imageName = basename($image);
                                                ?>
                                                    <option value="<?php echo htmlspecialchars($imageName); ?>">
                                                        <?php echo htmlspecialchars($imageName); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="image-preview">
                                                <p class="mb-2">Xem trước ảnh:</p>
                                                <img id="preview" class="preview-image" alt="Preview image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái</label>
                                        <select class="form-select" name="pro_status" required>
                                            <option value="">Chọn trạng thái</option>
                                            <option value="1">Hoạt động</option>
                                            <option value="0">Không hoạt động</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Mô tả sản phẩm</label>
                                        <textarea class="form-control" name="description" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <a href="?action=product" class="btn btn-cancel">
                                    <i class="fas fa-times me-2"></i>Hủy
                                </a>
                                <button class="btn btn-submit" name="them" type="submit">
                                    <i class="fas fa-save me-2"></i>Lưu sản phẩm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('imageSelect').onchange = function() {
        const preview = document.getElementById('preview');
        const selectedImage = this.value;
        if(selectedImage) {
            preview.style.display = 'block';
            preview.src = '../Uploads/Product/' + selectedImage;
        } else {
            preview.style.display = 'none';
        }
    }
    </script>
</body>
</html> 