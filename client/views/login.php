<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - HyperStore</title>
    <link rel="stylesheet" href="assets/css/client/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <?php include 'client/views/layout/header.php'; ?>
    </div>

    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>Đăng nhập</h2>
                <p>Chào mừng bạn đến với HyperStore</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=login" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Nhập email của bạn" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
                        <button type="button" class="toggle-password">
                            <i class="fas fa-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        <span>Ghi nhớ đăng nhập</span>
                    </label>
                    <a href="?action=forgot-password" class="forgot-password">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="login-button">Đăng nhập</button>

                <div class="social-login">
                    <p>Hoặc đăng nhập với</p>
                    <div class="social-buttons">
                        <button type="button" class="social-button facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </button>
                        <button type="button" class="social-button google">
                            <i class="fab fa-google"></i>
                            <span>Google</span>
                        </button>
                    </div>
                </div>

                <div class="register-link">
                    <p>Chưa có tài khoản? <a href="?action=register">Đăng ký ngay</a></p>
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
        <?php include 'client/views/layout/footer.php'; ?>
    </div>

    <script>
        // Toggle password visibility
        document.querySelector('.toggle-password').addEventListener('click', function(e) {
            e.preventDefault();
            const passwordInput = document.querySelector('#password');
            const icon = this.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>
</html>
