<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .table-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            padding: 35px;
            margin: 25px 0;
        }

        .page-title {
            color: #1a237e;
            font-weight: 800;
            margin-bottom: 35px;
            position: relative;
            padding-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 4px;
            background: linear-gradient(to right, #1a237e, #3949ab);
            border-radius: 4px;
        }

        .btn-add-user {
            background: linear-gradient(45deg, #1a237e, #3949ab);
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-add-user:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(26, 35, 126, 0.3);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
            border: none;
            margin-top: 20px;
        }

        .table thead th {
            background: #1a237e;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            padding: 18px 15px;
            border: none;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e0e0e0;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
            transform: scale(1.01);
        }

        .table td {
            padding: 18px 15px;
            vertical-align: middle;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e8eaf6;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .status-active {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .status-inactive {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .btn-action {
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            margin: 0 4px;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .btn-edit {
            background-color: #fb8c00;
            border: none;
            color: white;
        }

        .btn-delete {
            background-color: #d32f2f;
            border: none;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-container {
            animation: fadeIn 0.6s ease-out;
        }

        /* Thêm style cho các cột */
        .user-name {
            font-weight: 600;
            color: #1a237e;
        }

        .user-email {
            color: #666;
            font-size: 0.9rem;
        }

        .user-role {
            font-weight: 500;
            color: #455a64;
        }
    </style>
</head>

<body class="bg-light">
    <?php include "./views/layout/header.php"; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include "./views/layout/sidebar.php"; ?>
            </div>
            <div class="col-md-10 mt-4">
                <div class="table-container">
                    <h2 class="text-center page-title">Danh Sách Người Dùng</h2>
                    <div class="d-flex justify-content-end">
                        <a href="index.php?action=addUser" class="btn btn-add-user">
                            <i class="fas fa-user-plus me-2"></i>Thêm Người Dùng
                        </a>
                    </div>
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
                                        <span class="status-badge <?= $user['status'] ? 'status-active' : 'status-inactive' ?>">
                                            <?= $user['status'] ? 'Hoạt động' : 'Ngừng hoạt động' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="index.php?action=editUser&id=<?= htmlspecialchars($user['user_id']) ?>"
                                            class="btn btn-action btn-edit">
                                            <i class="fas fa-edit me-1"></i>Sửa
                                        </a>
                                        <a href="index.php?action=deleteUser&id=<?= htmlspecialchars($user['user_id']) ?>"
                                            class="btn btn-action btn-delete"
                                            onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                            <i class="fas fa-trash-alt me-1"></i>Xóa
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
            </div>
        </div>
    </div>
</body>

</html>