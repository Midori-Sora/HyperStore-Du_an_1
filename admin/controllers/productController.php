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
            require_once './views/product/product.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php');
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
            $ramOptions = self::$productModel->getRamOptions();
            $colorOptions = self::$productModel->getColorOptions();

            if (isset($_POST['sua'])) {
                $name = $_POST['pro_name'];
                $price = $_POST['price'];
                $description = $_POST['description'];
                $status = $_POST['pro_status'];
                $cate_id = $_POST['cate_id'];
                $ram_id = $_POST['ram_id'];
                $color_id = $_POST['color_id'];
                $img = $_POST['img'];

                if (self::$productModel->editProduct($id, $name, $img, $price, $description, $status, $cate_id, $ram_id, $color_id)) {
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
            $ramOptions = self::$productModel->getRamOptions();
            $colorOptions = self::$productModel->getColorOptions();

            if (isset($_POST['them'])) {
                $name = $_POST['pro_name'];
                $price = $_POST['price'];
                $description = $_POST['description'];
                $status = $_POST['pro_status'];
                $cate_id = $_POST['cate_id'];
                $ram_id = $_POST['ram_id'];
                $color_id = $_POST['color_id'];
                $img = $_POST['img'];

                $target = PATH_ROOT . '/Uploads/Product/' . $img;
                if (!file_exists($target)) {
                    throw new Exception('Ảnh không tồn tại trong thư mục Uploads/Product');
                }

                if (self::$productModel->addProduct($name, $img, $price, $description, $status, $cate_id, $ram_id, $color_id)) {
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
            $ramOptions = self::$productModel->getRamOptions();
            $colorOptions = self::$productModel->getColorOptions();
            $products = self::$productModel->getProductList();
            require_once './views/product/product-variant.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }

    public static function addRamController()
    {
        try {
            self::init();
            if (isset($_POST['ram_type']) && isset($_POST['ram_price'])) {
                $ram_type = $_POST['ram_type'];
                $ram_price = $_POST['ram_price'];
                
                if (self::$productModel->addRam($ram_type, $ram_price)) {
                    $_SESSION['success'] = 'Thêm RAM thành công';
                } else {
                    throw new Exception('Thêm RAM thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function editRamController()
    {
        try {
            self::init();
            if (isset($_POST['ram_id']) && isset($_POST['ram_type']) && isset($_POST['ram_price'])) {
                $ram_id = $_POST['ram_id'];
                $ram_type = $_POST['ram_type'];
                $ram_price = $_POST['ram_price'];
                
                if (self::$productModel->editRam($ram_id, $ram_type, $ram_price)) {
                    $_SESSION['success'] = 'Cập nhật RAM thành công';
                } else {
                    throw new Exception('Cập nhật RAM thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
    }

    public static function deleteRamController()
    {
        try {
            self::init();
            if (isset($_POST['ram_id'])) {
                $ram_id = $_POST['ram_id'];
                if (self::$productModel->deleteRam($ram_id)) {
                    $_SESSION['success'] = 'Xóa RAM thành công';
                } else {
                    throw new Exception('Xóa RAM thất bại');
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
            self::init();
            if (isset($_POST['color_id']) && isset($_POST['color_type']) && isset($_POST['color_price'])) {
                $color_id = $_POST['color_id'];
                $color_type = $_POST['color_type'];
                $color_price = $_POST['color_price'];
                
                if (self::$productModel->editColor($color_id, $color_type, $color_price)) {
                    $_SESSION['success'] = 'Cập nhật màu thành công';
                } else {
                    throw new Exception('Cập nhật màu thất bại');
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
        }
        header('Location: index.php?action=productVariant');
        exit();
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
                    throw new Exception('Cập nhật s��� lượng thất bại');
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
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }

            $id = $_GET['id'];
            $product = self::$productModel->getProductDetail($id);
            
            if (!$product) {
                throw new Exception('Không tìm thấy sản phẩm');
            }

            require_once './views/product/product-detail.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=product');
            exit();
        }
    }
}
