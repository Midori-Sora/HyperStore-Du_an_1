<?php
require_once './models/productModel.php';

class ProductController
{
    private static $productModel;

    public static function init()
    {
        if (!self::$productModel) {
            self::$productModel = new ProductModel();
        }
    }

    public static function productController()
    {
        try {
            self::init();
            $products = self::$productModel->getProductList();
            
            error_log("Products in controller: " . ($products ? count($products) : 'null'));
            
            if ($products === false) {
                throw new Exception('Không thể lấy danh sách sản phẩm');
            }
            
            require_once './views/product/product.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=product');
            exit();
        }
    }

    public static function editProductController()
    {
        try {
            self::init();
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }

            $id = $_GET['id'];
            $product = self::$productModel->getProductById($id);
            if (!$product) {
                throw new Exception('Không tìm thấy sản phẩm');
            }

            $categories = self::$productModel->getCategories();
            $storageOptions = self::$productModel->getStorageOptions();
            $colorOptions = self::$productModel->getColorOptions();

            if (isset($_POST['sua'])) {
                $name = $_POST['pro_name'];
                $price = $_POST['price'];
                $description = $_POST['description'];
                $status = $_POST['pro_status'];
                $cate_id = $_POST['cate_id'];
                $storage_id = $_POST['storage_id'];
                $color_id = $_POST['color_id'];
                $img = $_POST['img'];
                $quantity = $_POST['quantity'];

                if (self::$productModel->editProduct($id, $name, $img, $price, $description, $status, $cate_id, $storage_id, $color_id, $quantity)) {
                    $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                    header('location: index.php?action=product');
                    exit();
                } else {
                    throw new Exception('Cập nhật sản phẩm thất bại');
                }
            }

            require_once './views/product/edit-product.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=product');
            exit();
        }
    }

    public static function deleteProductController()
    {
        try {
            self::init();
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }

            $id = $_GET['id'];
            $product = self::$productModel->getProductById($id);
            if (!$product) {
                throw new Exception('Không tìm thấy sản phẩm');
            }

            if (self::$productModel->deleteProduct($id)) {
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
            self::init();
            $categories = self::$productModel->getCategories();
            $storageOptions = self::$productModel->getStorageOptions();
            $colorOptions = self::$productModel->getColorOptions();

            if (isset($_POST['them'])) {
                $name = $_POST['pro_name'];
                $price = $_POST['price'];
                $description = $_POST['description'];
                $status = $_POST['pro_status'];
                $cate_id = $_POST['cate_id'];
                $storage_id = $_POST['storage_id'];
                $color_id = $_POST['color_id'];
                $img = $_POST['img'];
                $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

                // Validate quantity
                if ($quantity < 0) {
                    throw new Exception('Số lượng không được âm');
                }

                // Check if image exists using relative path
                $target = '../Uploads/Product/' . $img;
                if (!file_exists($target)) {
                    throw new Exception('Ảnh không tồn tại trong thư mục Uploads/Product');
                }

                if (self::$productModel->addProduct($name, $img, $price, $description, $status, $cate_id, $storage_id, $color_id, $quantity)) {
                    $_SESSION['success'] = 'Thêm sản phẩm thành công';
                    header('location: index.php?action=product');
                    exit();
                } else {
                    throw new Exception('Thêm sản phẩm thất bại');
                }
            }
            require_once './views/product/add-product.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=product');
            exit();
        }
    }

    public static function productVariantController()
    {
        try {
            self::init();
            $storageOptions = self::$productModel->getStorageOptions();
            $colorOptions = self::$productModel->getColorOptions();
            $products = self::$productModel->getProductList();
            require_once './views/product/product-variant.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    public static function addStorageController()
    {
        try {
            self::init();
            if (isset($_POST['storage_type']) && isset($_POST['storage_price'])) {
                $storage_type = $_POST['storage_type'];
                $storage_price = $_POST['storage_price'];
                
                if (self::$productModel->addStorage($storage_type, $storage_price)) {
                    $_SESSION['success'] = 'Thêm bộ nhớ thành công';
                } else {
                    throw new Exception('Thêm bộ nhớ thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function editStorageController()
    {
        try {
            self::init();
            if (isset($_POST['storage_id']) && isset($_POST['storage_type']) && isset($_POST['storage_price'])) {
                $storage_id = $_POST['storage_id'];
                $storage_type = $_POST['storage_type'];
                $storage_price = $_POST['storage_price'];
                
                if (self::$productModel->editStorage($storage_id, $storage_type, $storage_price)) {
                    $_SESSION['success'] = 'Cập nhật bộ nhớ thành công';
                } else {
                    throw new Exception('Cập nhật bộ nhớ thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function deleteStorageController()
    {
        try {
            self::init();
            if (isset($_POST['storage_id'])) {
                $storage_id = $_POST['storage_id'];
                if (self::$productModel->deleteStorage($storage_id)) {
                        $_SESSION['success'] = 'Xóa bộ nhớ thành công';
                } else {
                    throw new Exception('Xóa bộ nhớ thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function addColorController()
    {
        try {
            self::init();
            if (isset($_POST['color_type']) && isset($_POST['color_price'])) {
                $color_type = $_POST['color_type'];
                $color_price = $_POST['color_price'];
                
                if (self::$productModel->addColor($color_type, $color_price)) {
                    $_SESSION['success'] = 'Thêm màu thành công';
                } else {
                    throw new Exception('Thêm màu thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function editColorController()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $color_id = $_POST['color_id'];
                $color_type = $_POST['color_type'];
                $color_price = $_POST['color_price'];

                $productModel = new ProductModel();
                if ($productModel->editColor($color_id, $color_type, $color_price)) {
                    $_SESSION['success'] = "Cập nhật màu sắc thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật màu sắc!";
                }
            }
            header('Location: index.php?action=productVariant');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?action=productVariant');
            exit();
        }
    }

    public static function deleteColorController()
    {
        try {
            self::init();
            if (isset($_POST['color_id'])) {
                $color_id = $_POST['color_id'];
                if (self::$productModel->deleteColor($color_id)) {
                    $_SESSION['success'] = 'Xóa màu thành công';
                } else {
                    throw new Exception('Xóa màu thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function updateQuantityController()
    {
        try {
            self::init();
            if (isset($_POST['pro_id']) && isset($_POST['quantity'])) {
                $pro_id = $_POST['pro_id'];
                $quantity = $_POST['quantity'];
                
                if ($quantity < 0) {
                    throw new Exception('Số lượng không được âm');
                }
                
                if (self::$productModel->updateQuantity($pro_id, $quantity)) {
                    $_SESSION['success'] = 'Cập nhật số lượng thành công';
                } else {
                    throw new Exception('Cập nhật s lượng thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function productDetailController()
    {
        try {
            self::init();
            
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id <= 0) {
                throw new Exception('ID sản phẩm không hợp lệ');
            }

            $product = self::$productModel->getProductById($id);
            if (!$product) {
                throw new Exception('Không tìm thấy sản phẩm');
            }

            // Fetch current deal for the product
            $currentDeal = self::$productModel->getCurrentDeal($id);
            $product['current_discount'] = $currentDeal ? $currentDeal['discount'] : 0;

            // Fetch available colors
            $availableColors = self::$productModel->getColorOptions();

            // Debug log
            error_log("Product detail controller - ID: $id, Data: " . json_encode($product));

            require_once './views/product/product-detail.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ?action=product');
            exit();
        }
    }
}