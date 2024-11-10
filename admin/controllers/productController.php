<?php
require_once './models/productModel.php';

class ProductController {
    
    public static function productController()
    {
        $productModel = new ProductModel();
        $products = $productModel->getProductList();
        require_once './views/product.php';
    }

    public static function editProductController()
    {
        $productModel = new ProductModel();
        $id = $_GET['id'];
        $product = $productModel->getProductById($id);
        $categories = $productModel->getCategories();
        
        if(isset($_POST['sua'])) {
            $name = $_POST['pro_name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $status = $_POST['pro_status'];
            $cate_id = $_POST['cate_id'];
            $img = $_POST['img'];
            
            // Xử lý dữ liệu RAM và Color
            $ram_data = [
                'types' => isset($_POST['ram_type']) ? $_POST['ram_type'] : []
            ];
            
            $color_data = [
                'types' => isset($_POST['color_type']) ? $_POST['color_type'] : []
            ];
            
            $target = PATH_ROOT . '/Uploads/Product/' . $img;
            if(file_exists($target)) {
                if($productModel->editProduct($id, $name, $img, $price, $description, $status, $cate_id, $ram_data, $color_data)) {
                    $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                    header('location: index.php?action=product');
                    exit();
                } else {
                    $_SESSION['error'] = 'Cập nhật sản phẩm thất bại';
                }
            } else {
                $_SESSION['error'] = 'Ảnh không tồn tại trong thư mục Uploads/Product';
            }
        }
        
        require_once './views/edit-product.php';
    }

    public static function deleteProductController()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }
            
            $id = $_GET['id'];
            $productModel = new ProductModel();
            
            // Lấy thông tin sản phẩm trước khi xóa
            $product = $productModel->getProductById($id);
            if (!$product) {
                throw new Exception('Không tìm thấy sản phẩm');
            }

            // Thực hiện xóa sản phẩm
            if ($productModel->deleteProduct($id)) {
                $_SESSION['success'] = 'Xóa sản phẩm thành công';
            } else {
                throw new Exception('Không thể xóa sản phẩm');
            }
            
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        
        header('Location: index.php?action=product');
        exit();
    }

    public static function addProductController()
    {
        try {
            $productModel = new ProductModel();
            $categories = $productModel->getCategories();
            
            if(isset($_POST['them'])) {
                $name = $_POST['pro_name'];
                $price = $_POST['price'];
                $description = $_POST['description'];
                $status = $_POST['pro_status'];
                $cate_id = $_POST['cate_id'];
                $img = $_POST['img'];
                
                // Xử lý dữ liệu RAM và Color
                $ram_data = [
                    'types' => isset($_POST['ram_type']) ? $_POST['ram_type'] : []
                ];
                
                $color_data = [
                    'types' => isset($_POST['color_type']) ? $_POST['color_type'] : []
                ];
                
                $target = PATH_ROOT . '/Uploads/Product/' . $img;
                if(file_exists($target)) {
                    if($productModel->addProduct($name, $img, $price, $description, $status, $cate_id, $ram_data, $color_data)) {
                        $_SESSION['success'] = 'Thêm sản phẩm thành công';
                        header('location: index.php?action=product');
                        exit();
                    } else {
                        $_SESSION['error'] = 'Thêm sản phẩm thất bại';
                    }
                } else {
                    $_SESSION['error'] = 'Ảnh không tồn tại trong thư mục Uploads/Product';
                }
            }
            require_once './views/add-product.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=product');
            exit();
        }
    }
}
