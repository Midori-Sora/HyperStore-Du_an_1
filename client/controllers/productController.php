<?php
require_once "client/models/productModel.php";
require_once 'client/controllers/commentController.php';

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

    public static function productDetailController()
    {
        $productModel = new ProductModel();
        
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $colorId = isset($_GET['color']) ? (int)$_GET['color'] : null;
        $storageId = isset($_GET['storage']) ? (int)$_GET['storage'] : null;
        
        $product = $productModel->getProductById($productId);
        if (!$product) {
            header('Location: index.php');
            exit;
        }

        $availableColors = $productModel->getAllColorsByCategory($product['cate_id']);
        $availableStorages = $productModel->getAllStoragesByCategory($product['cate_id']);
        
        if ($colorId || $storageId) {
            $variant = $productModel->getProductVariant(
                $productId,
                $colorId ?? $product['color_id'],
                $storageId ?? $product['storage_id']
            );
            
            if ($variant) {
                $product = $variant;
            }
        }

        // Initialize CommentController and get rating info
        CommentController::init();
        $ratingInfo = CommentController::getAverageRating($productId);

        require_once "client/views/product/product-detail.php";
    }
}
