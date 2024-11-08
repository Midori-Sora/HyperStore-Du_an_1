<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Danh Mục - Dạng Danh Sách</title>
    <link rel="stylesheet" href="../../assets/css/admin/category.css">
</head>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="row">
        <div class="sidebar">
            <?php include 'sidebar.php' ?>
        </div>
        <main>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>1</th>
                        <th>Iphone</th>
                        <th><img src="../../Uploads/Category/apple.webp" alt=""></th>
                        <th>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </th>
                    </tr>
                    <tr>
                        <th>2</th>
                        <th>Oppo</th>
                        <th><img src="../../Uploads/Category/oppo.webp" alt=""></th>
                        <th>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <th>Samsung</th>
                        <th><img src="../../Uploads/Category/samsung.webp" alt=""></th>
                        <th>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <th>Xiaomi</th>
                        <th><img src="../../Uploads/Category/xiaomi.webp" alt=""></th>
                        <th>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </th>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
