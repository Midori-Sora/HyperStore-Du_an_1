<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin người dùng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Sửa thông tin người dùng</h2>
        <form method="post" action="index.php?action=updateUser&id=<?= htmlspecialchars($_GET['id']) ?>"
            enctype="multipart/form-data" class="border p-4 shadow-sm">
            <div class="form-group">
                <label>Tên người dùng:</label>
                <input type="text" class="form-control" name="user_name"
                    value="<?= htmlspecialchars($user['user_name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                    required>
            </div>
            <div class="form-group">
                <label>Mật khẩu mới:</label>
                <input type="password" class="form-control" name="user_password">
            </div>
            <div class="form-group">
                <label>Địa chỉ:</label>
                <input type="text" class="form-control" name="address"
                    value="<?= htmlspecialchars($user['address']) ?>">
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" class="form-control" name="phone_number"
                    value="<?= htmlspecialchars($user['phone_number']) ?>" required>
            </div>
            <div class="form-group">
                <label>Giới tính:</label>
                <select name="sex" class="form-control">
                    <option value="1" <?= $user['sex'] == 1 ? 'selected' : '' ?>>Nam</option>
                    <option value="0" <?= $user['sex'] == 0 ? 'selected' : '' ?>>Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ảnh đại diện hiện tại:</label><br>
                <img src="<?= htmlspecialchars($user['avata']) ?>" width="100"><br><br>
            </div>
            <div class="form-group">
                <label>Đổi ảnh đại diện:</label>
                <input type="file" class="form-control-file" name="avata" accept="image/*">
            </div>
            <div class="form-group">
                <label>Quyền:</label>
                <input type="number" class="form-control" name="role" value="<?= htmlspecialchars($user['role']) ?>">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="user_status" value="1"
                    <?= $user['user_status'] ? 'checked' : '' ?>>
                <label class="form-check-label">Trạng thái</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Cập nhật người dùng</button>
        </form>
    </div>
</body>

</html>