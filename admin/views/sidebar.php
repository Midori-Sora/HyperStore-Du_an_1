<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
* {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.sidebar-container {
    background: white;
    border-radius: 10px;
    padding: 20px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    position: fixed;
    top: 100px;
    left: 20px;
    width: 250px;
    height: calc(100vh - 120px);
    overflow-y: auto;
}

.sidebar-container ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-container ul li {
    padding: 0 15px;
    margin: 5px 0;
}

.sidebar-container ul li a {
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #666;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.sidebar-container ul li a i {
    font-size: 20px;
    margin-right: 10px;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.sidebar-container ul li a span {
    font-size: 15px;
    font-weight: 500;
}

.sidebar-container ul li a:hover {
    background: #f8f9fa;
    color: #1976D2;
}

.sidebar-container ul li a:hover i {
    color: #1976D2;
    transform: translateX(3px);
}

.sidebar-container ul li.active a {
    background: #e3f2fd;
    color: #1976D2;
}

.sidebar-container ul li.active a i {
    color: #1976D2;
}

.divider {
    height: 1px;
    background: #eee;
    margin: 10px 15px;
}

.sidebar-container::-webkit-scrollbar {
    width: 5px;
}

.sidebar-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.sidebar-container::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 5px;
}

.sidebar-container::-webkit-scrollbar-thumb:hover {
    background: #ccc;
}
</style>

<body>
    <div class="sidebar-container">
        <ul>
            <li class="active">
                <a href="./index.php?action=home">
                    <i class="fas fa-home"></i>
                    <span>Bảng điều khiển</span>
                </a>
            </li>
            <li>
                <a href="./index.php?action=category">
                    <i class="fas fa-list"></i>
                    <span>Danh mục</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-images"></i>
                    <span>Ảnh trình chiếu</span>
                </a>
            </li>
            <li>
                <a href="./index.php?action=product">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Sản phẩm</span>
                </a>
            </li>
            <li>
                <a href="./index.php?action=user">
                    <i class="fas fa-users"></i>
                    <span>Tài khoản</span>
                </a>
            </li>
            <li>
                <a href="./index.php?action=comment">
                    <i class="fas fa-comments"></i>
                    <span>Bình luận</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Đơn hàng</span>
                </a>
            </li>
        </ul>
    </div>
</body>

</html>