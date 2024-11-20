<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../index.php?action=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<style>
    .header {
        background: white;
        padding: 15px 30px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav-left img {
        width: 10%;
    }

    .nav-left h3 {
        color: #1976D2;
        font-size: 24px;
        font-weight: 600;
    }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-right .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 15px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .nav-right .user-info:hover {
        background: #f5f5f5;
    }

    .user-info img {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-info .user-name {
        font-size: 15px;
        font-weight: 500;
        color: #333;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border: none;
        border-radius: 8px;
        background: #f5f5f5;
        color: #666;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .logout-btn:hover {
        background: #ff4444;
        color: white;
    }

    .logout-btn i {
        font-size: 16px;
    }

    .view-website-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        border: none;
        border-radius: 8px;
        background: #1976D2;
        color: white;
        font-size: 15px;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .view-website-btn:hover {
        background: #1565C0;
        color: white;
    }

    .view-website-btn i {
        font-size: 16px;
    }
</style>
<body>
    <header class="header">
        <nav class="nav">
            <div class="nav-left">
                <img src="../Uploads/Logo/logo.png" alt="Logo">
                <h3>Admin Dashboard</h3>
            </div>
            <div class="nav-right">
                <a href="../index.php" class="view-website-btn">
                    <i class="fas fa-globe"></i>
                    <span>Xem Website</span>
                </a>
                <div class="user-info">
                    <img src="../Uploads/User/nam.jpg" alt="User avatar">
                    <span class="user-name">
                        <?php 
                        // Kiểm tra và hiển thị tên người dùng
                        echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Admin';
                        ?>
                    </span>
                </div>
                <a href="?action=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Đăng xuất</span>
                </a>
            </div>
        </nav>
    </header>
</body>
</html>