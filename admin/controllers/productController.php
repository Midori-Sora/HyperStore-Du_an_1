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
            
            // Xử lý upload ảnh
            if(!empty($_FILES['img']['name'])) {
                $imagePath = time() . '_' . $_FILES['img']['name'];
                $target = PATH_ROOT . '/Uploads/' . $imagePath;
                
                if ($product['img']) {
                    $oldImagePath = PATH_ROOT . '/Uploads/' . $product['img'];
                    if(file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                if (!file_exists(PATH_ROOT . '/Uploads/')) {
                    mkdir(PATH_ROOT . '/Uploads/', 0777, true);
                }
                
                if(move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
                    $img = $imagePath;
                } else {
                    $img = $product['img'];
                }
            } else {
                $img = $product['img'];
            }

            if($productModel->editProduct($id, $name, $img, $price, $description, $status, $cate_id)) {
                $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                header('location: index.php?action=product');
                exit();
            } else {
                $_SESSION['error'] = 'Cập nhật sản phẩm thất bại';
            }
        }
        
        require_once './views/edit-product.php';
    }

    public static function deleteProductController()
    {
        try {
            $productModel = new ProductModel();
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }
            
            $id = $_GET['id'];
            
            // Lấy thông tin sản phẩm trước khi xóa
            $product = $productModel->getProductById($id);
            if (!$product) {
                throw new Exception('Không tìm thấy sản phẩm');
            }

            // Xóa ảnh cũ nếu tồn tại
            if ($product['img']) {
                $imagePath = PATH_ROOT . '/Uploads/' . $product['img'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Thực hiện xóa sản phẩm
            if ($productModel->deleteProduct($id)) {
                $_SESSION['success'] = 'Xóa sản phẩm thành công';
                header('Location: /HyperStore-Du_an_1/admin/index.php?action=product');
                exit();
            } else {
                throw new Exception('Không thể xóa sản phẩm');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
            header('Location: /HyperStore-Du_an_1/admin/index.php?action=product');
            exit();
        }
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
                
                // Xử lý upload ảnh
                if(!empty($_FILES['img']['name'])) {
                    $imagePath = time() . '_' . $_FILES['img']['name'];
                    $target = PATH_ROOT . '/Uploads/' . $imagePath;
                    
                    if (!file_exists(PATH_ROOT . '/Uploads/')) {
                        mkdir(PATH_ROOT . '/Uploads/', 0777, true);
                    }
                    
                    if(move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
                        $img = $imagePath;
                        
                        if($productModel->addProduct($name, $img, $price, $description, $status, $cate_id)) {
                            $_SESSION['success'] = 'Thêm sản phẩm thành công';
                            header('location: index.php?action=product');
                            exit();
                        } else {
                            $_SESSION['error'] = 'Không thể thêm sản phẩm';
                        }
                    } else {
                        $_SESSION['error'] = 'Không thể upload ảnh';
                    }
                } else {
                    $_SESSION['error'] = 'Vui lòng chọn ảnh';
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
