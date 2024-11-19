<?php
$productModel = new ProductModel();
$categories = $productModel->getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/client/sidebar.css">
</head>
<body>
    <div class="sidebar-container">
        <h2>Danh mục sản phẩm</h2>
        <ul>
            <?php foreach ($categories as $category) : ?>
                <li>
                    <i class="fas fa-mobile-alt"></i>
                    <a href="?action=product-category&cate_id=<?php echo $category['cate_id']; ?>">
                        <?php echo $category['cate_name']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>