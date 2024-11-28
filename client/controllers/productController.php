<?php
class ProductController
{
    public static function productController()
    {
        $productModel = new ProductModel();
        
        // Lấy trang hiện tại từ URL, mặc định là trang 1
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $itemsPerPage = 20; // Số sản phẩm mỗi trang
        
        // Lấy tổng số sản phẩm và số trang
        $totalProducts = $productModel->getTotalProducts();
        $totalPages = ceil($totalProducts / $itemsPerPage);
        
        // Đảm bảo trang hiện tại không vượt quá tổng số trang
        $currentPage = max(1, min($currentPage, $totalPages));
        
        // Lấy danh sách sản phẩm cho trang hiện tại
        $products = $productModel->getProductListPaginated($currentPage, $itemsPerPage);
        
        // Truyền dữ liệu sang view
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

        // Lấy variant của sản phẩm
        $variant = $productModel->getProductVariant(
            $productId,
            $colorId ?? $product['color_id'],
            $storageId ?? $product['storage_id']
        );
        
        if ($variant) {
            $product = array_merge($product, $variant);
        }

        // Lấy ảnh theo màu sắc
        if ($colorId) {
            $productImage = $productModel->getProductImageByColor($productId, $colorId);
            if ($productImage) {
                $product['img'] = $productImage;
            }
        }

        // Đảm bảo variant_price luôn có giá trị
        if (!isset($product['variant_price'])) {
            $product['variant_price'] = $product['price'];
        }

        $availableColors = $productModel->getAllColorsByCategory($product['cate_id']);
        $availableStorages = $productModel->getAllStoragesByCategory($product['cate_id']);

        require_once "client/views/product/product-detail.php";
    }
}
