<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 80px;
        }

        .main {
            display: flex;
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .main main {
            width: calc(100% - 270px);
            margin-left: 270px;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn-add {
            background: #1976D2;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }

        .btn-add:hover {
            background: #1565C0;
            color: white;
            transform: translateY(-2px);
        }

        .table {
            margin-top: 20px;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
            padding: 15px;
            border: none;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            background: white;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }

        .table tr td:first-child {
            border-left: 1px solid #eee;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .table tr td:last-child {
            border-right: 1px solid #eee;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .table tr:hover td {
            background: #f8f9fa;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.2s;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e8eaf6;
        }

        .badge {
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .action-column {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .btn-action {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-edit {
            background: #4CAF50;
            color: white;
        }

        .btn-delete {
            background: #f44336;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            opacity: 0.9;
        }

        .btn-action i {
            font-size: 14px;
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
            <div class="container-fluid">
                <div class="page-header">
                    <h2>Quản lý người dùng</h2>
                    <a href="?action=addUser" class="btn-add">
                        <i class="fas fa-user-plus me-2"></i>Thêm người dùng mới
                    </a>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
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
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Ảnh đại diện</th>
                                <th>Quyền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['user_id']) ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['phone']) ?></td>
                                <td>
                                    <?php if (!empty($user['avatar'])): ?>
                                    <img src="<?= htmlspecialchars($user['avatar']) ?>" class="user-avatar" alt="Avatar">
                                    <?php else: ?>
                                    <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($user['role_name']) ?></td>
                                <td>
                                    <span class="badge <?= $user['status'] ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $user['status'] ? 'Hoạt động' : 'Ngừng hoạt động' ?>
                                    </span>
                                </td>
                                <td class="action-column">
                                    <a href="index.php?action=editUser&id=<?= htmlspecialchars($user['user_id']) ?>"
                                        class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?action=deleteUser&id=<?= htmlspecialchars($user['user_id']) ?>"
                                        class="btn-action btn-delete"
                                        onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-users-slash me-2"></i>Không có người dùng nào.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>