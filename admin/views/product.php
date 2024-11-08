<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="././assets/css/admin/product.css">
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    background: #f5f5f5;
}
header{
    margin-bottom: 50px;
}
.row{
    display: flex;
    justify-content: space-between;
    width: 1300px;
    margin: auto;
}
.row .sidebar{
    width: 20%;
}
.row main{
    width: 80%;
    border-radius: 15px;
    overflow: hidden;
}
main table{
    width: 100%;
    text-align: center;
    border-radius: 15px;
}
main table thead{
    height: 40px;
    background: #303030;
}
main table tr th{
    color: #999999;
    font-weight: normal;
}
main tbody{
    background: #0b0b31;
}
main tbody img{
    width: 10%;
}
main tbody td{
    color: #fff;
}
</style>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="row">
        <div class="sidebar">
            <?php include 'sidebar.php'; ?>
        </div>
        <main>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Giá sản phẩm</th>
                        <th>Ngày nhập hàng</th>
                        <th>Mô tả sản phẩm</th>
                        <th>Số lượt xem</th>
                        <th>Trạng thái sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo $product['product_id']; ?></td>
                            <td><?php echo $product['product_name']; ?></td>
                            <td><img src="../Uploads/Product/<?php echo $product['product_image']?>" alt="" width="100"></td>
                            <td><?php echo number_format($product['product_price']); ?></td>
                            <td><?php echo $product['product_importDate']; ?></td>
                            <td><?php echo $product['product_describe']; ?></td>
                            <td><?php echo $product['product_view']; ?></td>
                            <td><?php echo $product['product_status']; ?></td>
                            <td><?php echo $product['cate_name']; ?></td>
                            <td>
                                <a href="#">Sửa</a>
                                <a href="#">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>1</td>
                        <td>Iphone</td>
                        <td><img src="././Uploads/Product/Apple/i1.png" alt=""></td>
                        <td>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Iphone</td>
                        <td><img src="././Uploads/Product/Apple/i1.png" alt=""></td>
                        <td>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Iphone</td>
                        <td><img src="././Uploads/Product/Apple/i1.png" alt=""></td>
                        <td>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Iphone</td>
                        <td><img src="././Uploads/Product/Apple/i1.png" alt=""></td>
                        <td>
                            <a href="#">Sửa</a>
                            <a href="#">Xóa</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>