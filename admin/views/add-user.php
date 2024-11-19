<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm người dùng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Thêm người dùng mới</h2>
        <form method="post" action="index.php?action=storeUser" enctype="multipart/form-data"
            class="border p-4 shadow-sm">
            <div class="form-group">
                <label>Tên người dùng:</label>
                <input type="text" class="form-control" name="user_name" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" class="form-control" name="user_password" required>
            </div>
            <div class="form-group">
                <label>Địa chỉ:</label>
                <input type="text" class="form-control" name="address">
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" class="form-control" name="phone_number" required>
            </div>
            <div class="form-group">
                <label>Giới tính:</label>
                <select name="sex" class="form-control">
                    <option value="1">Nam</option>
                    <option value="0">Nữ</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ảnh đại diện:</label>
                <input type="file" class="form-control-file" name="avata" accept="image/*">
            </div>
            <div class="form-group">
                <label>Quyền:</label>
                <input type="number" class="form-control" name="role" value="0">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="user_status" value="1" checked>
                <label class="form-check-label">Trạng thái</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Thêm người dùng</button>
        </form>
    </div>
</body>

</html>