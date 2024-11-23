<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/client/profile.css">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            animation: slideIn 0.5s ease-in-out;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert i {
            font-size: 20px;
        }

        .alert-close {
            margin-left: auto;
            cursor: pointer;
            font-size: 20px;
            color: inherit;
            opacity: 0.5;
        }

        .alert-close:hover {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <?php include 'client/views/layout/header.php' ?>

    <main>
        <div class="container">
            <div class="profile-wrapper">
                <!-- Sidebar -->
                <div class="profile-sidebar">
                    <div class="user-info">
                        <img src="<?= !empty($user['avatar']) ? $user['avatar'] : 'Uploads/User/default-avatar.jpg' ?>" 
                             alt="Avatar" class="avatar">
                        <h3><?= htmlspecialchars($user['fullname'] ?? $user['username']) ?></h3>
                        <p class="email"><?= htmlspecialchars($user['email']) ?></p>
                    </div>
                    <nav class="profile-nav">
                        <a href="#profile" class="active">
                            <i class="fas fa-user"></i>Thông tin cá nhân
                        </a>
                        <a href="#orders">
                            <i class="fas fa-shopping-bag"></i>Đơn hàng của tôi
                        </a>
                        <a href="#address">
                            <i class="fas fa-map-marker-alt"></i>Sổ địa chỉ
                        </a>
                        <a href="#password">
                            <i class="fas fa-lock"></i>Đổi mật khẩu
                        </a>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="profile-content">
                    <div class="content-section" id="profile">
                        <h2>Thông tin cá nhân</h2>
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger" id="errorAlert">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?= $_SESSION['error']; unset($_SESSION['error']); ?></span>
                                <span class="alert-close" onclick="closeAlert(this.parentElement)">&times;</span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success" id="successAlert">
                                <i class="fas fa-check-circle"></i>
                                <span><?= $_SESSION['success']; unset($_SESSION['success']); ?></span>
                                <span class="alert-close" onclick="closeAlert(this.parentElement)">&times;</span>
                            </div>
                        <?php endif; ?>

                        <form class="profile-form" action="?action=update-profile" method="POST">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="fullname" 
                                       value="<?= htmlspecialchars($user['fullname'] ?? '') ?>" 
                                       placeholder="Nhập họ và tên">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" name="phone" 
                                       value="<?= htmlspecialchars($user['phone'] ?? '') ?>" 
                                       placeholder="Nhập số điện thoại">
                            </div>
                            <div class="form-group">
                                <label>Ngày sinh</label>
                                <input type="date" name="birthday" 
                                       value="<?= htmlspecialchars($user['birthday'] ?? '') ?>">
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label>
                                <select name="gender">
                                    <option value="">Chọn giới tính</option>
                                    <option value="1" <?= ($user['gender'] ?? '') == 1 ? 'selected' : '' ?>>Nam</option>
                                    <option value="0" <?= ($user['gender'] ?? '') == 0 ? 'selected' : '' ?>>Nữ</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <textarea name="address" rows="3" 
                                          placeholder="Nhập địa chỉ"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                            </div>
                            <button type="submit" class="btn-save">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'client/views/layout/footer.php' ?>
    <script>
        // Tự động ẩn thông báo sau 5 giây
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert) {
                        fadeOutAlert(alert);
                    }
                }, 5000);
            });
        });

        // Hàm đóng thông báo khi click
        function closeAlert(alert) {
            fadeOutAlert(alert);
        }

        // Hiệu ứng fade out
        function fadeOutAlert(alert) {
            alert.style.animation = 'fadeOut 0.5s ease-in-out';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }
    </script>
</body>

</html>
