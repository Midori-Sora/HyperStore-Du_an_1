<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="assets/css/client/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="header">
        <?php include 'client/views/layout/header.php' ?>
    </div>

    <div class="container">
        <div class="register-container">
            <h2>Đăng ký tài khoản</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
            <?php endif; ?>

            <form action="index.php?action=register-process" method="POST" class="register-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Tên đăng nhập <span class="required">*</span></label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Mật khẩu <span class="required">*</span></label>
                        <div class="password-input">
                            <input type="password" id="password" name="password" required>
                            <i class="fas fa-eye-slash toggle-password"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Xác nhận mật khẩu <span class="required">*</span></label>
                        <div class="password-input">
                            <input type="password" id="confirm_password" name="confirm_password" required>
                            <i class="fas fa-eye-slash toggle-password"></i>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="fullname">Họ và tên <span class="required">*</span></label>
                        <input type="text" id="fullname" name="fullname" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại <span class="required">*</span></label>
                        <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="birthday">Ngày sinh <span class="required">*</span></label>
                        <input type="date" id="birthday" name="birthday" required
                               max="<?= date('Y-m-d', strtotime('-10 years')) ?>"
                               min="<?= date('Y-m-d', strtotime('-100 years')) ?>">
                    </div>

                    <div class="form-group">
                        <label for="gender">Giới tính <span class="required">*</span></label>
                        <select id="gender" name="gender" required>
                            <option value="">Chọn giới tính</option>
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="address">Địa chỉ <span class="required">*</span></label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>

                <button type="submit" class="register-btn">Đăng ký</button>
            </form>

            <div class="login-link">
                Đã có tài khoản? <a href="index.php?action=login">Đăng nhập ngay</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php' ?>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
</body>
</html>
