<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    body {
        background: #f5f5f5;
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
    main {
        width: calc(100% - 270px);
        margin-left: 270px;
    }

    .card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
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
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.1);
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
    }

    .form-select:focus {
        border-color: #1976D2;
        box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.1);
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

    .preview-container {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .preview-image {
        max-width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        display: none;
    }
    </style>
</head>

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
                        <h2><i class="fas fa-user-plus me-2"></i>Thêm người dùng mới</h2>
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

                        <form action="index.php?action=storeUser" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-user me-2"></i>Tên người dùng
                                        </label>
                                        <input type="text" class="form-control" name="username" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-envelope me-2"></i>Email
                                        </label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-lock me-2"></i>Mật khẩu
                                        </label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-id-card me-2"></i>Họ và tên
                                        </label>
                                        <input type="text" class="form-control" name="fullname">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-phone me-2"></i>Số điện thoại
                                        </label>
                                        <input type="text" class="form-control" name="phone">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-map-marker-alt me-2"></i>Địa chỉ
                                        </label>
                                        <textarea class="form-control" name="address" rows="4"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-image me-2"></i>Ảnh đại diện
                                        </label>
                                        <div class="select-new-image">
                                            <select class="form-select" name="avatar" id="imageSelect" required>
                                                <option value="">Chọn ảnh đại diện</option>
                                                <?php
                                                $imageDir = '../Uploads/User/';
                                                $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                                foreach ($images as $image):
                                                    $imageName = basename($image);
                                                ?>
                                                <option value="<?= htmlspecialchars($imageName) ?>">
                                                    <?= htmlspecialchars($imageName) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="preview-container mt-3" style="display: none;">
                                                <p class="mb-2">Xem trước ảnh:</p>
                                                <img id="preview" class="preview-image" alt="Preview">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="fas fa-user-shield me-2"></i>Quyền
                                        </label>
                                        <select class="form-select" name="role_id">
                                            <option value="1">Admin</option>
                                            <option value="2">User</option>
                                        </select>
                                    </div>

                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" name="status" value="1" checked>
                                        <label class="form-check-label">
                                            <i class="fas fa-toggle-on me-2"></i>Hoạt động
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="?action=user" class="btn btn-cancel">
                                    <i class="fas fa-times me-2"></i>Hủy
                                </a>
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-save me-2"></i>Lưu người dùng
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
        const previewContainer = document.querySelector('.preview-container');
        const selectedImage = this.value;

        if (selectedImage) {
            preview.src = '../Uploads/User/' + selectedImage;
            preview.style.display = 'block';
            previewContainer.style.display = 'block';
        } else {
            preview.style.display = 'none';
            previewContainer.style.display = 'none';
        }
    }
    </script>
</body>

</html>