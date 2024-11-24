<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        color: #333;
        padding-top: 80px;
    }

    .main {
        display: flex;
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
    }
    .container{
        --bs-gutter-x: 0;
    }
    main {
        width: calc(100% - 270px);
        margin-left: 270px;
        padding: 30px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .card,
    .user-info {
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .card:hover,
    .user-info:hover {
        transform: translateY(-5px);
    }

    .card-header,
    .d-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .btn-add,
    .btn-secondary,
    .btn-action {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        transition: background-color 0.3s, border-color 0.3s;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover,
    .btn-secondary:hover,
    .btn-action:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .product-image,
    .user-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        border: 3px solid #dee2e6;
    }

    .status-badge,
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }

    .status-active,
    .bg-success {
        background: #28a745;
        color: #fff;
    }

    .status-inactive,
    .bg-danger {
        background: #dc3545;
        color: #fff;
    }

    .table th,
    .table td {
        padding: 15px 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-item {
        margin-bottom: 15px;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
    }
    </style>
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="main">
        <div class="sidebar">
            <?php include "./views/layout/sidebar.php"; ?>
        </div>
        <main>
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Chi tiết người dùng</h2>
                    <a href="?action=user" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>

                <div class="avata">
                    <div>
                        <?php if (!empty($user['avatar'])): ?>
                        <img src="../<?= htmlspecialchars($user['avatar']) ?>" class="user-avatar" alt="Avatar"
                            onerror="this.src='../Uploads/User/nam.jpg'">
                        <?php else: ?>
                        <img src="../Uploads/User/nam.jpg" class="user-avatar" alt="Default Avatar">
                        <?php endif; ?>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Tên đăng nhập:</div>
                        <div><?= htmlspecialchars($user['username']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Email:</div>
                        <div><?= htmlspecialchars($user['email']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Họ và tên:</div>
                        <div><?= htmlspecialchars($user['fullname'] ?? 'Chưa cập nhật') ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Số điện thoại:</div>
                        <div><?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Địa chỉ:</div>
                        <div><?= htmlspecialchars($user['address'] ?? 'Chưa cập nhật') ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Vai trò:</div>
                        <div><?= htmlspecialchars($user['role_name']) ?></div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Trạng thái:</div>
                        <div>
                            <span class="badge <?= $user['status'] ? 'bg-success' : 'bg-danger' ?>">
                                <?= $user['status'] ? 'Đang hoạt động' : 'Ngừng hoạt động' ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>