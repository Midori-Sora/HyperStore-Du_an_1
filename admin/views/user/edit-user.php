<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="container mt-4">
        <?php include "./views/layout/sidebar.php"; ?>
        <h2 class="text-center">Sửa Thông Tin Người Dùng</h2>
        <form method="post" action="index.php?action=updateUser&id=<?= htmlspecialchars($user['user_id']) ?>"
            enctype="multipart/form-data">
            <div class="form-group">
                <label>Tên người dùng:</label>
                <input type="text" name="username" class="form-control"
                    value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>"
                    required>
            </div>
            <div class="form-group">
                <label>Mật khẩu mới:</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label>Họ và tên:</label>
                <input type="text" name="fullname" class="form-control"
                    value="<?= htmlspecialchars($user['fullname']) ?>">
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>">
            </div>
            <div class="form-group">
                <label>Địa chỉ:</label>
                <textarea name="address" class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>
            </div>
            <div class="form-group">
                <label>Ảnh đại diện hiện tại:</label>
                <?php if (!empty($user['avatar'])): ?>
                    <img src="<?= htmlspecialchars($user['avatar']) ?>" width="50" alt="Avatar"><br>
                <?php else: ?>
                    <p>Không có ảnh đại diện</p>
                <?php endif; ?>
                <input type="file" name="avatar" class="form-control-file mt-2">
            </div>

            <div class="form-group">
                <label>Quyền:</label>
                <select name="role_id" class="form-control">
                    <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                    <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <div class="form-group">
                <label>Trạng thái:</label>
                <input type="checkbox" name="status" value="1" <?= $user['status'] ? 'checked' : '' ?>> Hoạt động
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật người dùng</button>
        </form>
    </div>
</body>

</html>