<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="././assets/css/admin/sidebar.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<style>
    *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Barlow', sans-serif;
}
.sidebar-container ul{
    list-style: none;
}
.sidebar-container ul li{
    margin: 15px 10px;
    height: 40px;
    line-height: 40px;
    border-radius: 5px;
}
.sidebar-container ul li a{
    text-decoration: none;
    display: flex;
    justify-content: start;
    align-items: center;
    color: #000;
    margin-left: 10px;
}
.sidebar-container ul li ion-icon{
    margin-right: 10px;
    color: #000;
    background: #ebebeb;
    padding: 5px;
    border-radius: 5px;
    transition: 0.5s;
}
.sidebar-container ul li:hover ion-icon{
    background-image: linear-gradient(to bottom right,#bf5600,#ff8c2d);
    margin-right: 20px;
}
.sidebar-container ul li:hover{
    background: #fff;
    box-shadow: 0 5px 5px #c6c6c6;
}
</style>
<body>
    <div class="sidebar-container">
        <ul>
            <li><a href="#"><ion-icon name="home-outline"></ion-icon>Bảng điều khiển</a></li>
            <li><a href="#"><ion-icon name="library-outline"></ion-icon>Danh mục</a></li>
            <li><a href="#"><ion-icon name="images-outline"></ion-icon>Ảnh trình chiếu</a></li>
            <li><a href="#"><ion-icon name="phone-portrait-outline"></ion-icon>Sản phẩm</a></li>
            <li><a href="#"><ion-icon name="person-outline"></ion-icon>Tài khoản</a></li>
            <li><a href="#"><ion-icon name="chatbubbles-outline"></ion-icon>Bình luận</a></li>
            <li><a href="#"><ion-icon name="cart-outline"></ion-icon>Đơn hàng</a></li>
        </ul>
    </div>
</body>
</html>