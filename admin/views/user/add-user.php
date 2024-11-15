<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="container">
        <?php include "./views/layout/sidebar.php"; ?>
        <h2 class="text-center mt-4">Thêm Người Dùng Mới</h2>
        <form action="index.php?action=storeUser" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Tên người dùng:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="fullname">Họ và tên:</label>
                <input type="text" class="form-control" id="fullname" name="fullname">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <div class="form-group">
                <label for="avatar">Ảnh đại diện:</label>
                <input type="file" class="form-control-file" id="avatar" name="avata">
            </div>
            <div class="form-group">
                <label for="role_id">Quyền:</label>
                <select class="form-control" id="role_id" name="role_id">
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                </select>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="status" name="status" checked>
                <label class="form-check-label" for="status">Hoạt động</label>
            </div>
            <button type="submit" class="btn btn-primary">Thêm người dùng</button>
        </form>
    </div>
</body>

</html>