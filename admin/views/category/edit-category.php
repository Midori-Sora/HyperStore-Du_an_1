<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
    }
    .container{
            --bs-gutter-x: 0;
    }
    .main main {
        width: calc(100% - 270px);
        margin-left: 270px;
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .form-control {
        margin: 10px 0;
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #dce0e4;
    }

    .form-select {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #dce0e4;
        margin: 10px 0;
    }

    .category-image {
        max-width: 200px;
        height: 200px;
        object-fit: cover;
        margin: 10px 0;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .preview-image {
        max-width: 200px;
        height: 200px;
        object-fit: cover;
        margin-top: 10px;
        display: none;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .current-image,
    .select-new-image {
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

    .btn-primary {
        background: #1976D2;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #1565C0;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #f5f5f5;
        color: #666;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        margin-left: 10px;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .preview-container {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .current-image {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
    }

    .select-image {
        margin-bottom: 20px;
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
                <h2 class="mb-4">Chỉnh sửa danh mục</h2>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php
                        echo htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']);
                        ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php
                        echo htmlspecialchars($_SESSION['success']);
                        unset($_SESSION['success']);
                        ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form action="index.php?action=updateCategory&id=<?= htmlspecialchars($category['cate_id']) ?>"
                    method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" name="cate_name"
                            value="<?= htmlspecialchars($category['cate_name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh danh mục</label>
                        <div class="select-image">
                            <div class="current-image mb-3">
                                <p class="mb-2">Ảnh hiện tại:</p>
                                <img src="../<?= htmlspecialchars($category['img']) ?>" class="category-image"
                                    alt="<?= htmlspecialchars($category['cate_name']) ?>"
                                    style="max-width: 200px; height: 200px; object-fit: cover; border-radius: 8px;">
                            </div>

                            <select class="form-select" name="img" id="imageSelect">
                                <option value="<?= $category['img'] ?>">Giữ ảnh hiện tại
                                    (<?= basename($category['img']) ?>)</option>
                                <?php
                                $imageDir = '../Uploads/Category/';
                                $images = glob($imageDir . "*.{jpg,jpeg,png,gif,webp}", GLOB_BRACE);
                                foreach ($images as $image):
                                    $imageName = basename($image);
                                    if ($imageName != basename($category['img'])):
                                ?>
                                <option value="<?= htmlspecialchars($imageName) ?>">
                                    <?= htmlspecialchars($imageName) ?>
                                </option>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </select>

                            <div class="preview-container mt-3">
                                <p class="mb-2">Xem trước ảnh mới:</p>
                                <img id="preview" src="" alt="Preview"
                                    style="max-width: 200px; height: 200px; object-fit: cover; border-radius: 8px; display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description"
                            rows="4"><?= htmlspecialchars($category['description']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select class="form-select" name="cate_status" required>
                            <option value="1" <?= $category['cate_status'] == 1 ? 'selected' : '' ?>>Hiển thị</option>
                            <option value="0" <?= $category['cate_status'] == 0 ? 'selected' : '' ?>>Ẩn</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Cập nhật
                    </button>
                    <a href="?action=category" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.needs-validation');

        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });
    });
    </script>
    <script>
    document.getElementById('imageSelect').onchange = function() {
        const preview = document.getElementById('preview');
        const selectedImage = this.value;

        if (selectedImage) {
            if (selectedImage.includes('Uploads/')) {
                // Nếu giữ ảnh hiện tại, ẩn preview
                preview.style.display = 'none';
            } else {
                // Nếu chọn ảnh mới, hiển thị preview
                preview.src = '../Uploads/Category/' + selectedImage;
                preview.style.display = 'block';
            }
        } else {
            preview.style.display = 'none';
        }
    }
    </script>
</body>

</html>