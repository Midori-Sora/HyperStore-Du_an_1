<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .form-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
            padding: 50px;
            max-width: 800px;
            margin: 30px auto;
        }
        
        .page-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #3498db, #2980b9);
            border-radius: 3px;
        }
        
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 12px;
            font-size: 1rem;
            display: block;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            background-color: #fff;
        }
        
        .form-control-file {
            padding: 15px;
            background: #f8f9fa;
            border: 2px dashed #cbd5e0;
            border-radius: 10px;
            cursor: pointer;
        }
        
        .form-control-file:hover {
            border-color: #3498db;
            background: #e3f2fd;
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }
        
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 20px center;
            background-size: 16px;
            padding-right: 50px;
        }
        
        .btn-submit {
            background: linear-gradient(45deg, #3498db, #2980b9);
            border: none;
            padding: 15px 40px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border-radius: 10px;
            margin-top: 35px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.4);
            background: linear-gradient(45deg, #2980b9, #3498db);
        }

        .form-icon {
            color: #3498db;
            margin-right: 10px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-container {
            animation: fadeIn 0.6s ease-out;
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
                <div class="form-container">
                    <h2 class="text-center page-title">Thêm Danh Mục Mới</h2>
                    <form method="POST" action="index.php?action=addCategory" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label" for="cate_name">
                                <i class="fas fa-folder me-2"></i>Tên danh mục
                            </label>
                            <input type="text" class="form-control" name="cate_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="img">
                                <i class="fas fa-image me-2"></i>Ảnh
                            </label>
                            <input type="file" class="form-control form-control-file" name="img" accept="image/*" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="description">
                                <i class="fas fa-align-left me-2"></i>Mô tả
                            </label>
                            <textarea class="form-control" name="description" rows="4"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="cate_status">
                                <i class="fas fa-toggle-on me-2"></i>Trạng thái
                            </label>
                            <select name="cate_status" class="form-control">
                                <option value="1">Hiện</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="fas fa-plus-circle me-2"></i>Thêm danh mục
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>