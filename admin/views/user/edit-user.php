<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa người dùng</title>
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
        min-height: 100vh;
        overflow-y: auto;
    }

    .main {
        display: flex;
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
        min-height: calc(100vh - 80px);
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
        overflow-y: visible;
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

    .current-avatar {
        width: 150px;
        height: 150px;
        object-fit: cover;
        margin: 10px 0;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: 3px solid #fff;
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
        margin-right: 10px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .form-check {
        margin: 20px 0;
    }

    .form-check-input:checked {
        background-color: #1976D2;
        border-color: #1976D2;
    }

    .container {
        padding-bottom: 50px;
        height: auto;
        overflow: visible;
    }

    form {
        margin-bottom: 50px;
        height: auto;
        overflow: visible;
    }

    .actions-container {
        margin-top: 20px;
        padding: 20px 0;
        border-top: 1px solid #eee;
        position: relative;
        z-index: 1000;
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
                <h2 class="mb-4">Chỉnh sửa người dùng</h2>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                </div>
                <?php endif; ?>

                <form method="post" action="index.php?action=updateUser&id=<?= htmlspecialchars($user['user_id']) ?>"
                    enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Tên người dùng
                        </label>
                        <input type="text" name="username" class="form-control"
                            value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" name="email" class="form-control"
                            value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-key me-2"></i>Mật khẩu mới
                        </label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Để trống nếu không muốn thay đổi mật khẩu">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-image me-2"></i>Ảnh đại diện
                        </label>
                        <div class="current-image mb-3">
                            <p class="mb-2">Ảnh hiện tại:</p>
                            <img src="../<?= htmlspecialchars($user['avatar']) ?>" class="current-avatar"
                                alt="Current Avatar" onerror="this.src='../Uploads/User/default-avatar.jpg'">
                        </div>
                        <div class="select-new-image">
                            <label class="form-label">Chọn ảnh mới (nếu muốn thay đổi):</label>
                            <select class="form-select" name="avatar" id="imageSelect">
                                <option value="<?= $user['avatar'] ?>">Giữ ảnh hiện tại
                                    (<?= basename($user['avatar']) ?>)</option>
                                <?php
                                $imageDir = '../Uploads/User/';
                                $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                foreach ($images as $image):
                                    $imageName = basename($image);
                                    if ($imageName != basename($user['avatar'])):
                                ?>
                                <option value="<?= htmlspecialchars($imageName) ?>"><?= htmlspecialchars($imageName) ?>
                                </option>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </select>
                            <div class="preview-container mt-3" style="display: none;">
                                <p class="mb-2">Xem trước ảnh mới:</p>
                                <img id="preview" class="current-avatar" alt="Preview">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-id-card me-2"></i>Họ và tên
                        </label>
                        <input type="text" name="fullname" class="form-control"
                            value="<?= htmlspecialchars($user['fullname']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-phone me-2"></i>Số điện thoại
                        </label>
                        <input type="text" name="phone" class="form-control"
                            value="<?= htmlspecialchars($user['phone']) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt me-2"></i>Địa chỉ
                        </label>
                        <textarea name="address" class="form-control"
                            rows="3"><?= htmlspecialchars($user['address']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-user-shield me-2"></i>Quyền
                        </label>
                        <select name="role_id" class="form-select">
                            <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                            <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>User</option>
                        </select>
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" name="status" value="1"
                            <?= $user['status'] ? 'checked' : '' ?>>
                        <label class="form-check-label">
                            <i class="fas fa-toggle-on me-2"></i>Hoạt động
                        </label>
                    </div>

                    <div class="actions-container">
                        <a href="?action=user" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('imageSelect').onchange = function() {
        const preview = document.getElementById('preview');
        const previewContainer = document.querySelector('.preview-container');
        const selectedImage = this.value;

        if (selectedImage && !selectedImage.includes('Uploads/')) {
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