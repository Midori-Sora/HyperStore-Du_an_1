<?php
require_once "client/models/productModel.php";

class ProductController
{
    public static function productController()
    {
        $productModel = new ProductModel();
        $products = $productModel->getProductList();
        require_once "client/views/product/product.php";
    }

    public static function productCategoryController()
    {
        $productModel = new ProductModel();
        
        // Lấy category_id từ URL
        $cateId = isset($_GET['cate_id']) ? (int)$_GET['cate_id'] : 0;
        
        // Lấy thông tin danh mục
        $category = $productModel->getCategoryById($cateId);
        
        if (!$category) {
            header('Location: index.php');
            exit;
        }

        // Lấy sản phẩm theo danh mục
        $products = $productModel->getProductsByCategory($cateId);
        
        require_once "client/views/product/product-cate.php";
    }
}
