<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/client/header.css">
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .header-container a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="home.php" class="logo">
                <img src="../../Uploads/Logo/logo.png" alt="">
                <h1>
                    Hyper <br>
                    Store
                </h1>
            </a>
            <div class="menu">
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li class="has-child"><a href="#">SẢN PHẨM</a>
                            <ul class="sub-menu"></li>
                                <li><a href="#">CẤU HÌNH HYPERPC</a></li>
                                <li><a href="#">CPU</a></li>
                                <li><a href="#">GEAR</a></li>
                                <li><a href="#">MÀN HÌNH</a></li>
                                <li><a href="#">THIẾT BỊ VĂN PHÒNG</a></li>
                            </ul>
                    </li>
                    <li class="has-child"><a href="#">WORKSTATION PC</a>
                        <ul class="sub-menu">
                            <li><a href="#">PC PHOTO EDITTING</a></li>
                            <li><a href="#">PC VIDEO EDITTING</a></li>
                            <li><a href="#">PC 3D & ANIMATION</a></li>
                            <li><a href="#">PC RENDERING</a></li>
                            <li><a href="#">PC CAD</a></li>
                        </ul>
                    </li>
                    <li class="has-child"><a href="#">TIN TỨC</a>
                        <ul class="sub-menu">
                            <li><a href="#">Kiến thức đồ họa</a></li>
                            <li><a href="#">Tin tức công nghệ</a></li>
                            <li><a href="#">Đánh giá sản phẩm</a></li>
                            <li><a href="#">Deep Learning-AI</a></li>
                        </ul></li>
                    <li><a href="#">LIÊN HỆ</a></li>
                </ul>
            </div>
            <div class="icons">
                <ul>
                    <li class="search">
                        <form>
                            <input type="text" placeholder="Type here...">
                            <button><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </li>
                    <li><i class="fa-solid fa-heart"></i></li>
                    <li id="cart"><i class="fa-solid fa-basket-shopping"></i><span>0</span>
                        <section class="cart">
                            <i class="fa-solid fa-caret-up"></i>
                            <form action="">
                                    <div class="producct"></div>
                                <div class="price-total">
                                    <p>Tổng tiền: </p>
                                    <p><span>0</span><sup style="color: #6d6d6d;">đ</sup></p>
                                </div>
                            </form>
                            <button>THANH TOÁN</button>
                        </section>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</body>
</html>