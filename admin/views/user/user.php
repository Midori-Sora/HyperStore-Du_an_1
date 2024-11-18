<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            padding-top: 80px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        main {
            width: calc(100% - 270px);
            margin-left: 270px;
        }
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 30px;
            margin-bottom: 20px;
            border: none;
        }
        .card-header {
            background: none;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-add {
            background: #1976D2;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-add:hover {
            background: #1565C0;
            color: white;
            transform: translateY(-2px);
        }
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }
        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .status-inactive {
            background: #ffebee;
            color: #c62828;
        }
        .table {
            margin-bottom: 0;
        }
        .table th {
            border-bottom: 2px solid #f0f0f0;
            padding: 15px 10px;
            font-weight: 600;
            color: #333;
        }
        .table td {
            padding: 15px 10px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
        }
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            display: block;
        }
        .card-header h2 {
            font-size: 1.5rem;
            margin: 0;
            color: #333;
            display: flex;
            align-items: center;
        }
        .alert {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            border: none;
            border-radius: 10px;
            margin-bottom: 20px;
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
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-users me-2"></i>
                            Quản lý người dùng
                        </h2>
                        <a href="?action=addUser" class="btn-add">
                            <i class="fas fa-user-plus"></i>
                            Thêm người dùng mới
                        </a>
                    </div>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="10%">Tên</th>
                                    <th width="20%">Email</th>
                                    <th width="15%">Số điện thoại</th>
                                    <th width="10%">Ảnh</th>
                                    <th width="10%">Quyền</th>
                                    <th width="10%">Trạng thái</th>
                                    <th width="20%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td class="text-center"><?= htmlspecialchars($user['user_id']) ?></td>
                                            <td>
                                                <span class="fw-medium"><?= htmlspecialchars($user['username']) ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td><?= htmlspecialchars($user['phone']) ?></td>
                                            <td class="text-center">
                                                <?php if (!empty($user['avatar'])): ?>
                                                    <img src="<?= htmlspecialchars($user['avatar']) ?>" 
                                                         class="user-avatar" 
                                                         alt="Avatar"
                                                         width="100%">
                                                <?php else: ?>
                                                    <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="fw-medium"><?= htmlspecialchars($user['role_name']) ?></span>
                                            </td>
                                            <td>
                                                <span class="status-badge <?= $user['status'] ? 'status-active' : 'status-inactive' ?>">
                                                    <?= $user['status'] ? 'Hoạt động' : 'Ngừng hoạt động' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="index.php?action=editUser&id=<?= htmlspecialchars($user['user_id']) ?>" 
                                                   class="btn btn-success btn-action me-2">
                                                    <i class="fas fa-edit"></i>
                                                    Sửa
                                                </a>
                                                <a href="index.php?action=deleteUser&id=<?= htmlspecialchars($user['user_id']) ?>" 
                                                   class="btn btn-danger btn-action"
                                                   onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                                    <i class="fas fa-trash"></i>
                                                    Xóa
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="fas fa-users me-2"></i>
                                            Chưa có người dùng nào
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>