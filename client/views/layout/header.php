<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/client/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-container">
            <a href="index.php" class="logo">
                <img src="Uploads/Logo/logo.png" alt="Hyper Store">
                <h1>Hyper<span>Store</span></h1>
            </a>

            <div class="search-bar">
                <form action="index.php" method="GET">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..."
                        value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>"
                        required minlength="2">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="index.php?action=home" class="active">Trang chủ</a></li>
                    <li class="has-child">
                        <a href="index.php?action=product">Sản phẩm <i class="fas fa-chevron-down"></i></a>
                        <ul class="sub-menu">
                            <li><a href="#">iPhone 11</a></li>
                            <li><a href="#">iPhone 12</a></li>
                            <li><a href="#">iPhone 13</a></li>
                            <li><a href="#">iPhone 14</a></li>
                            <li><a href="#">iPhone 15</a></li>
                            <li><a href="#">iPhone 16</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Giới thiệu</a></li>
                    <li class="has-child">
                        <a href="#">Tin tức <i class="fas fa-chevron-down"></i></a>
                        <ul class="sub-menu">
                            <li><a href="#">Kiến thức đồ họa</a></li>
                            <li><a href="#">Tin tức công nghệ</a></li>
                            <li><a href="#">Đánh giá sản phẩm</a></li>
                            <li><a href="#">Deep Learning-AI</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <div class="user-actions">
                    <a href="index.php?action=view-cart" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span
                            class="count"><?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?></span>
                    </a>

                    <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-dropdown">
                        <a href="#" class="user-menu">
                            <i class="fas fa-user"></i>
                            <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                        </a>
                        <div class="user-popup">
                            <ul>
                                <li>
                                    <a href="index.php?action=profile">
                                        <i class="fas fa-user-circle"></i> Tài khoản của tôi
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?action=logout">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php else: ?>
                    <a href="index.php?action=login" class="login-btn">
                        <i class="fas fa-user"></i>
                        <span>Đăng nhập</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <div class="notification-container">
        <?php if (isset($_SESSION['success'])): ?>
        <div class="notification success">
            <i class="fas fa-check-circle"></i>
            <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="notification error">
            <i class="fas fa-exclamation-circle"></i>
            <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>



    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('.notification');

        notifications.forEach(notification => {
            // Tự động ẩn thông báo sau 3 giây
            setTimeout(() => {
                notification.style.animation = 'fadeOut 0.5s ease-out forwards';
                setTimeout(() => {
                    notification.remove();
                }, 500);
            }, 3000);
        });
    });
    </script>
</body>

</html>