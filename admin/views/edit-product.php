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
    .form-control {
        margin: 10px 0;
    }
    .product-image {
        max-width: 200px;
        height: 250px;
        object-fit: cover;
        margin: 10px 0;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .preview-image {
        max-width: 200px;
        height: 250px;
        object-fit: cover;
        margin-top: 10px;
        display: none;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .current-image, .select-new-image {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .preview-container {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }
</style>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="main">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <main>
            <div class="container">
                <h2 class="mb-4">Chỉnh sửa sản phẩm</h2>
                
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
                        <label class="form-label">Hình ảnh sản phẩm</label>
                        <div class="current-image mb-3">
                            <p class="mb-2">Ảnh hiện tại:</p>
                            <img src="../Uploads/Product/<?=$product['img']?>" 
                                 class="product-image" 
                                 alt="Current product image"
                                 style="max-width: 200px; height: auto;">
                        </div>
                        <div class="select-new-image">
                            <label class="form-label">Chọn ảnh mới (nếu muốn thay đổi):</label>
                            <select class="form-select" name="img" id="imageSelect">
                                <option value="<?=$product['img']?>">Giữ ảnh hiện tại (<?=$product['img']?>)</option>
                                <?php 
                                $imageDir = PATH_ROOT . '/Uploads/Product/';
                                $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                foreach($images as $image): 
                                    $imageName = basename($image);
                                    if($imageName != $product['img']):
                                ?>
                                    <option value="<?php echo $imageName; ?>"><?php echo $imageName; ?></option>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </select>
                            <div class="preview-container mt-3" style="display: none;">
                                <p class="mb-2">Xem trước ảnh mới:</p>
                                <img id="preview" 
                                     class="preview-image" 
                                     alt="Preview image"
                                     style="max-width: 200px; height: auto; display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá sản phẩm</label>
                        <input class="form-control" type="number" name="price" value="<?=$product['price']?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description" rows="4"><?=$product['description']?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="pro_status" required>
                            <option value="1" <?php echo ($product['pro_status'] == 1) ? 'selected' : ''; ?>>
                                Hoạt động
                            </option>
                            <option value="0" <?php echo ($product['pro_status'] == 0) ? 'selected' : ''; ?>>
                                Không hoạt động
                            </option>
                        </select>
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

                    <div class="mb-3">
                        <label class="form-label">RAM</label>
                        <div id="ram-options">
                            <?php 
                            $ram_options = explode(', ', $product['ram_options'] ?? '');
                            if (!empty($ram_options)) {
                                foreach($ram_options as $ram): 
                                    $ram_type = trim(explode(' (+', $ram)[0]); // Lấy phần RAM type (ví dụ: 128GB)
                            ?>
                            <div class="ram-option mb-2">
                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <select class="form-select" name="ram_type[]" required>
                                            <option value="">Chọn RAM</option>
                                            <option value="128GB" <?php echo ($ram_type == '128GB') ? 'selected' : ''; ?>>128GB (+0đ)</option>
                                            <option value="256GB" <?php echo ($ram_type == '256GB') ? 'selected' : ''; ?>>256GB (+200.000đ)</option>
                                            <option value="512GB" <?php echo ($ram_type == '512GB') ? 'selected' : ''; ?>>512GB (+500.000đ)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-ram">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                endforeach;
                            } else {
                            // Nếu không có RAM options, hiển thị một option trống
                            ?>
                            <div class="ram-option mb-2">
                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <select class="form-select" name="ram_type[]" required>
                                            <option value="">Chọn RAM</option>
                                            <option value="128GB">128GB (+0đ)</option>
                                            <option value="256GB">256GB (+200.000đ)</option>
                                            <option value="512GB">512GB (+500.000đ)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-ram">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="add-ram">
                            <i class="fas fa-plus"></i> Thêm RAM
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Màu sắc</label>
                        <div id="color-options">
                            <?php 
                            $color_options = explode(', ', $product['color_options'] ?? '');
                            if (!empty($color_options)) {
                                foreach($color_options as $color): 
                                    $color_type = trim(explode(' (+', $color)[0]); // Lấy phần Color type (ví dụ: Vàng)
                            ?>
                            <div class="color-option mb-2">
                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <select class="form-select" name="color_type[]" required>
                                            <option value="">Chọn màu</option>
                                            <option value="Vàng" <?php echo ($color_type == 'Vàng') ? 'selected' : ''; ?>>Vàng (+500.000đ)</option>
                                            <option value="Xanh" <?php echo ($color_type == 'Xanh') ? 'selected' : ''; ?>>Xanh (+0đ)</option>
                                            <option value="Đỏ" <?php echo ($color_type == 'Đỏ') ? 'selected' : ''; ?>>Đỏ (+0đ)</option>
                                            <option value="Trắng" <?php echo ($color_type == 'Trắng') ? 'selected' : ''; ?>>Trắng (+0đ)</option>
                                            <option value="Hồng" <?php echo ($color_type == 'Hồng') ? 'selected' : ''; ?>>Hồng (+0đ)</option>
                                            <option value="Đen" <?php echo ($color_type == 'Đen') ? 'selected' : ''; ?>>Đen (+0đ)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-color">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                endforeach;
                            } else {
                            // Nếu không có Color options, hiển thị một option trống
                            ?>
                            <div class="color-option mb-2">
                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <select class="form-select" name="color_type[]" required>
                                            <option value="">Chọn màu</option>
                                            <option value="Vàng">Vàng (+500.000đ)</option>
                                            <option value="Xanh">Xanh (+0đ)</option>
                                            <option value="Đỏ">Đỏ (+0đ)</option>
                                            <option value="Trắng">Trắng (+0đ)</option>
                                            <option value="Hồng">Hồng (+0đ)</option>
                                            <option value="Đen">Đen (+0đ)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-color">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="add-color">
                            <i class="fas fa-plus"></i> Thêm màu sắc
                        </button>
                    </div>

                    <button class="btn btn-primary" name="sua" type="submit">Cập nhật</button>
                    <a href="index.php?action=product" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('imageSelect').onchange = function() {
            const preview = document.getElementById('preview');
            const previewContainer = document.querySelector('.preview-container');
            const selectedImage = this.value;
            
            if(selectedImage && selectedImage !== '<?=$product['img']?>') {
                preview.src = '../Uploads/Product/' + selectedImage;
                preview.style.display = 'block';
                previewContainer.style.display = 'block';
            } else {
                preview.style.display = 'none';
                previewContainer.style.display = 'none';
            }
        }

        document.getElementById('add-ram').onclick = function() {
            const template = document.querySelector('.ram-option').cloneNode(true);
            template.querySelector('select[name="ram_type[]"]').value = '';
            document.getElementById('ram-options').appendChild(template);
        };

        document.getElementById('add-color').onclick = function() {
            const template = document.querySelector('.color-option').cloneNode(true);
            template.querySelector('select[name="color_type[]"]').value = '';
            document.getElementById('color-options').appendChild(template);
        };

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ram')) {
                if (document.querySelectorAll('.ram-option').length > 1) {
                    e.target.closest('.ram-option').remove();
                }
            }
            if (e.target.classList.contains('remove-color')) {
                if (document.querySelectorAll('.color-option').length > 1) {
                    e.target.closest('.color-option').remove();
                }
            }
        });
    </script>
</body>
</html>