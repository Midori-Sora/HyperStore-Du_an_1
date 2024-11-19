<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/client/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-container">
            <a href="index.php" class="logo">
                <img src="../../Uploads/Logo/logo.png" alt="Hyper Store">
                <h1>Hyper<span>Store</span></h1>
            </a>

            <div class="search-bar">
                <form action="" method="GET">
                    <input type="text" placeholder="Tìm kiếm sản phẩm...">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="index.php" class="active">Trang chủ</a></li>
                    <li class="has-child">
                        <a href="#">Sản phẩm <i class="fas fa-chevron-down"></i></a>
                        <ul class="sub-menu">
                            <li><a href="#">Cấu hình HyperPC</a></li>
                            <li><a href="#">CPU</a></li>
                            <li><a href="#">Gear</a></li>
                            <li><a href="#">Màn hình</a></li>
                            <li><a href="#">Thiết bị văn phòng</a></li>
                        </ul>
                    </li>
                    <li class="has-child">
                        <a href="#">Giới thiệu</a>
                    </li>
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
                    <a href="#" class="wishlist">
                        <i class="fas fa-heart"></i>
                        <span class="count">0</span>
                    </a>
                    <div class="cart-dropdown">
                        <a href="#" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="count">0</span>
                        </a>
                        <div class="cart-popup">
                            <div class="cart-header">
                                <h3>Giỏ hàng</h3>
                            </div>
                            <div class="cart-items">
                                <!-- Cart items will be dynamically added here -->
                                <div class="empty-cart">
                                    <p>Giỏ hàng trống</p>
                                </div>
                            </div>
                            <div class="cart-footer">
                                <div class="cart-total">
                                    <span>Tổng cộng:</span>
                                    <span class="total-amount">0₫</span>
                                </div>
                                <button class="checkout-btn">Thanh toán</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>
</html>