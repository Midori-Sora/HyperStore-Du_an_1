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
        try {
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
            
        } catch (Exception $e) {
            error_log("Error in productCategoryController: " . $e->getMessage());
            header('Location: index.php');
            exit;
        }
    }

    public static function productDetailController()
    {
        try {
            $productModel = new ProductModel();
            
            // Lấy product_id từ URL
            $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            
            // Lấy thông tin sản phẩm
            $product = $productModel->getProductById($productId);
            
            if (!$product) {
                header('Location: index.php');
                exit;
            }
            
            // Lấy danh sách ảnh của sản phẩm
            $productImages = $productModel->getProductImages($productId);
            
            // Lấy sản phẩm liên quan
            $relatedProducts = $productModel->getRelatedProducts($product['cate_id'], $productId);
            
            // Load view
            require_once "client/views/product/product-detail.php";
            
        } catch (Exception $e) {
            error_log("Error in productDetailController: " . $e->getMessage());
            header('Location: index.php');
            exit;
        }
    }
}
