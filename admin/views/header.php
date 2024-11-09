<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .header-container {
        background: white;
        padding: 15px 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .header-content {
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .brand-logo {
        width: 15%;
    }

    .brand-name {
        font-size: 24px;
        font-weight: 600;
        color: #1976D2;
        margin: 0;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .admin-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #1976D2;
    }

    .admin-name {
        font-weight: 500;
        color: #333;
        margin: 0;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .notification-btn {
        position: relative;
        background: none;
        border: none;
        color: #666;
        font-size: 20px;
        cursor: pointer;
        transition: color 0.3s;
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #f44336;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
    }

    .notification-btn:hover {
        color: #1976D2;
    }

    .logout-btn {
        background-color: #f5f5f5;
        color: #666;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s;
    }

    .logout-btn:hover {
        background-color: #ff4444;
        color: white;
    }

    .dropdown-menu {
        min-width: 200px;
        padding: 10px 0;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .dropdown-item {
        padding: 8px 20px;
        color: #666;
        transition: all 0.3s;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #1976D2;
    }

    .dropdown-item i {
        margin-right: 10px;
        width: 20px;
    }
</style>
<body>
    <div class="header-container">
        <div class="header-content">
            <div class="brand">
                <img src="../Uploads/Logo/logo.png" alt="Logo" class="brand-logo">
                <h1 class="brand-name">Admin Dashboard</h1>
            </div>

            <div class="header-right">
                <div class="header-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <div class="dropdown">
                        <button class="btn dropdown-toggle admin-info" type="button" data-bs-toggle="dropdown">
                            <img src="../Uploads/User/nam.jpg" alt="Admin" class="admin-avatar">
                            <span class="admin-name">Admin Name</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i>Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i>Cài đặt</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>