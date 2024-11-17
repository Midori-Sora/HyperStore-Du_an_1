<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .form-container {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            padding: 35px 40px;
            max-width: 850px;
            margin: 40px auto;
        }

        .page-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            font-size: 1.8rem;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(to right, #3498db, #2980b9);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
            font-size: 0.92rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            background-color: #fff;
        }

        .current-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 10px 0;
            border: 3px solid #e9ecef;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-control-file {
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #bdc3c7;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }

        .form-control-file:hover {
            border-color: #3498db;
            background: #ecf0f1;
        }

        .form-check {
            margin: 20px 0;
            padding-left: 30px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            border: 2px solid #bdc3c7;
        }

        .form-check-input:checked {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-submit {
            background: linear-gradient(45deg, #3498db, #2980b9);
            border: none;
            padding: 14px 35px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
            width: 100%;
            margin-top: 15px;
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3);
            background: linear-gradient(45deg, #2980b9, #3498db);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-container {
            animation: fadeIn 0.5s ease-out;
        }

        .col-md-10 {
            padding-top: 20px;
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
            <div class="col-md-10">
                <div class="form-container">
                    <h2 class="page-title">Sửa Thông Tin Người Dùng</h2>
                    <form method="post" action="index.php?action=updateUser&id=<?= htmlspecialchars($user['user_id']) ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Tên người dùng
                            </label>
                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-key me-2"></i>Mật khẩu mới
                            </label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Họ và tên
                            </label>
                            <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($user['fullname']) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone me-2"></i>Số điện thoại
                            </label>
                            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Địa chỉ
                            </label>
                            <textarea name="address" class="form-control"><?= htmlspecialchars($user['address']) ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-image me-2"></i>Ảnh đại diện hiện tại
                            </label>
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?= htmlspecialchars($user['avatar']) ?>" class="current-avatar" alt="Avatar">
                            <?php else: ?>
                                <div class="text-muted">Không có ảnh đại diện</div>
                            <?php endif; ?>
                            <input type="file" name="avatar" class="form-control form-control-file">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-shield me-2"></i>Quyền
                            </label>
                            <select name="role_id" class="form-control">
                                <option value="1" <?= $user['role_id'] == 1 ? 'selected' : '' ?>>Admin</option>
                                <option value="2" <?= $user['role_id'] == 2 ? 'selected' : '' ?>>User</option>
                            </select>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="status" value="1" <?= $user['status'] ? 'checked' : '' ?>>
                            <label class="form-check-label">
                                <i class="fas fa-toggle-on me-2"></i>Hoạt động
                            </label>
                        </div>

                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i>Cập nhật người dùng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>