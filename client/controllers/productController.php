<?php
class ProductController
{
    public static function productController()
    {
        $productModel = new ProductModel();
        $products = $productModel->getProductList();
        
        // Tạo mảng tạm để kiểm tra sản phẩm trùng
        $uniqueProducts = [];
        
        foreach ($products as $product) {
            $productName = $product['pro_name'];
            
            // Nếu sản phẩm chưa tồn tại trong mảng tạm
            if (!isset($uniqueProducts[$productName])) {
                // Lấy mã giảm giá
                $currentDeal = $productModel->getCurrentDeal($product['pro_id']);
                $product['current_discount'] = $currentDeal ? $currentDeal['discount'] : 0;
                
                // Thêm vào mảng tạm
                $uniqueProducts[$productName] = $product;
            }
        }
        
        // Chuyển mảng kết quả về dạng tuần tự
        $products = array_values($uniqueProducts);

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
