<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng</title>
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

        .form-control-file {
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #bdc3c7;
            border-radius: 8px;
            cursor: pointer;
        }

        .form-control-file:hover {
            border-color: #3498db;
            background: #ecf0f1;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 45px;
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

        .form-check-label {
            font-weight: 500;
            cursor: pointer;
            color: #34495e;
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

        .form-icon {
            color: #3498db;
            margin-right: 8px;
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
                    <h2 class="page-title">Thêm Người Dùng Mới</h2>
                    <form action="index.php?action=storeUser" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label" for="username">
                                <i class="fas fa-user me-2"></i>Tên người dùng
                            </label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="email">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="password">
                                <i class="fas fa-lock me-2"></i>Mật khẩu
                            </label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="fullname">
                                <i class="fas fa-id-card me-2"></i>Họ và tên
                            </label>
                            <input type="text" class="form-control" id="fullname" name="fullname">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="phone">
                                <i class="fas fa-phone me-2"></i>Số điện thoại
                            </label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="address">
                                <i class="fas fa-map-marker-alt me-2"></i>Địa chỉ
                            </label>
                            <textarea class="form-control" id="address" name="address"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="avatar">
                                <i class="fas fa-image me-2"></i>Ảnh đại diện
                            </label>
                            <input type="file" class="form-control form-control-file" id="avatar" name="avata">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="role_id">
                                <i class="fas fa-user-shield me-2"></i>Quyền
                            </label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status" checked>
                            <label class="form-check-label" for="status">
                                <i class="fas fa-toggle-on me-2"></i>Hoạt động
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-user-plus me-2"></i>Thêm người dùng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>