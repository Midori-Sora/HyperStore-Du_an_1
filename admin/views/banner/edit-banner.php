<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
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
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 30px;
        margin-bottom: 20px;
        border: none;
    }
    .card-header {
        background: none;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
        margin-bottom: 30px;
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
    }
    .form-control:focus {
        border-color: #1976D2;
        box-shadow: 0 0 0 0.2rem rgba(25,118,210,0.1);
    }
    .image-preview {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }
    .preview-image {
        max-width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }
    .btn-submit {
        background: #1976D2;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        border: none;
        font-weight: 500;
        transition: all 0.3s;
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
        transition: all 0.3s;
    }
    .btn-cancel:hover {
        background: #e0e0e0;
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
                        <h2>
                            <i class="fas fa-edit me-2"></i>
                            Sửa Banner
                        </h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="?action=editBanner&id=<?= $banner['id'] ?>" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Tiêu đề banner</label>
                                        <input type="text" class="form-control" name="title" 
                                               value="<?= htmlspecialchars($banner['title']) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Hình ảnh</label>
                                        <select class="form-select" name="image_url" id="imageSelect" required>
                                            <option value="">Chọn hình ảnh</option>
                                            <?php 
                                            $imageDir = PATH_ROOT . '/Uploads/Slides/';
                                            $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                            foreach($images as $image): 
                                                $imageName = basename($image);
                                                $selected = ($imageName == $banner['image_url']) ? 'selected' : '';
                                            ?>
                                                <option value="<?= $imageName ?>" <?= $selected ?>>
                                                    <?= $imageName ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="image-preview mt-3">
                                            <img id="preview" class="preview-image" 
                                                 src="../Uploads/Slides/<?= $banner['image_url'] ?>" 
                                                 alt="Preview" style="display: block;">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái</label>
                                        <select class="form-select" name="status" required>
                                            <option value="1" <?= $banner['status'] == 1 ? 'selected' : '' ?>>
                                                Hiển thị
                                            </option>
                                            <option value="0" <?= $banner['status'] == 0 ? 'selected' : '' ?>>
                                                Ẩn
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="?action=banner" class="btn btn-cancel">
                                    <i class="fas fa-times me-2"></i>Hủy
                                </a>
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-save me-2"></i>Cập nhật banner
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
                preview.src = '../Uploads/Slides/' + selectedImage;
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
</body>
</html>
