<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <?php include "./views/layout/sidebar.php"; ?>
            </div>
            <div class="col-md-10 mt-4">
                <h2 class="text-center mb-4">Danh Sách Người Dùng</h2>
                <div class="text-right mb-3">
                    <a href="index.php?action=addUser" class="btn btn-success">Thêm Người Dùng</a>
                </div>
                <table class="table table-bordered table-hover table-striped">
                    <thead class="thead-dark">
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
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td>
                                <?php if (!empty($user['avatar'])): ?>
                                <img src="<?= htmlspecialchars($user['avatar']) ?>" width="50" height="50" alt="Avatar">
                                <?php else: ?>
                                Không có ảnh
                                <?php endif; ?>
                            </td>



                            <td><?= htmlspecialchars($user['role_name']) ?></td>
                            <td><?= $user['status'] ? 'Hoạt động' : 'Ngừng hoạt động' ?></td>
                            <td>
                                <a href="index.php?action=editUser&id=<?= htmlspecialchars($user['user_id']) ?>"
                                    class="btn btn-warning btn-sm">Sửa</a>
                                <a href="index.php?action=deleteUser&id=<?= htmlspecialchars($user['user_id']) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">Xóa</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có người dùng nào.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>