<?php
require_once 'models/categoryModel.php';

class CategoryController
{
    public static function categoryController()
    {
        try {
            $categories = CategoryModel::getAllCategories();
            
            // Tạo mảng mới để lưu các danh mục unique dựa trên cate_id
            $uniqueCategories = [];
            foreach ($categories as $category) {
                $cate_id = $category['cate_id'];
                if (!isset($uniqueCategories[$cate_id])) {
                    if (!empty($category['img'])) {
                        // Đảm bảo đường dẫn bắt đầu từ Uploads
                        if (strpos($category['img'], 'Uploads/') === 0) {
                            $category['img'] = $category['img'];
                        } else {
                            $category['img'] = 'Uploads/Category/' . basename($category['img']);
                        }
                    }
                    $uniqueCategories[$cate_id] = $category;
                }
            }
            
            // Chuyển mảng associative thành indexed array
            $categories = array_values($uniqueCategories);
            
            include 'views/category/category.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?action=category');
            exit();
        }
    }
    public static function addCategoryController()
    {
        try {
            $imageDir = dirname(dirname(__DIR__)) . '/Uploads/Category/';
            if (!is_dir($imageDir)) {
                mkdir($imageDir, 0777, true);
            }
            
            // Lấy danh sách ảnh và sắp xếp theo thời gian mới nhất
            $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            usort($images, function($a, $b) {
                return filemtime($b) - filemtime($a);
            });
            $images = array_map('basename', $images);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'cate_name' => trim($_POST['cate_name']),
                    'description' => trim($_POST['description']),
                    'cate_status' => $_POST['cate_status']
                ];

                if (!empty($_POST['img'])) {
                    $imageName = basename($_POST['img']);
                    $target = dirname(dirname(__DIR__)) . '/Uploads/Category/' . $imageName;
                    
                    if (!file_exists($target)) {
                        throw new Exception('Ảnh không tồn tại trong thư mục Uploads/Category');
                    }
                    
                    $data['img'] = 'Uploads/Category/' . $imageName;
                } else {
                    throw new Exception('Vui lòng chọn ảnh cho danh mục');
                }

                if (CategoryModel::addCategory($data)) {
                    $_SESSION['success'] = 'Thêm danh mục thành công';
                    header('Location: index.php?action=category');
                    exit();
                }
            }
            
            include 'views/category/add-category.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?action=category');
            exit();
        }
    }

    public static function editCategoryController()
    {
        try {
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception('ID danh mục không hợp lệ');
            }

            $category = CategoryModel::getCategoryById($id);
            if (!$category) {
                throw new Exception('Không tìm thấy danh mục');
            }
            
            // Sửa đường dẫn imageDir
            $imageDir = dirname(dirname(__DIR__)) . '/Uploads/Category/';
            if (!is_dir($imageDir)) {
                mkdir($imageDir, 0777, true);
            }
            
            // Lấy và sắp xếp ảnh theo thời gian mới nhất
            $images = glob($imageDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
            usort($images, function($a, $b) {
                return filemtime($b) - filemtime($a);
            });
            $images = array_map('basename', $images);
            
            include 'views/category/edit-category.php';
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?action=category');
            exit();
        }
    }

    public static function updateCategoryController()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('ID không hợp lệ');
            }

            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception('ID danh mục không hợp lệ');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = [
                    'cate_id' => $id,
                    'cate_name' => trim($_POST['cate_name']),
                    'description' => trim($_POST['description']),
                    'cate_status' => $_POST['cate_status']
                ];

                // Xử lý ảnh
                if (!empty($_POST['img'])) {
                    $imageName = basename($_POST['img']);
                    $target = '../Uploads/Category/' . $imageName;
                    
                    if (!file_exists($target)) {
                        throw new Exception('Ảnh không tồn tại trong thư mục Uploads/Category');
                    }
                    
                    $data['img'] = '../Uploads/Category/' . $imageName;
                } else {
                    throw new Exception('Vui lòng chọn ảnh cho danh mục');
                }

                if (CategoryModel::updateCategory($data)) {
                    $_SESSION['success'] = 'Cập nhật danh mục thành công';
                    header('Location: index.php?action=category');
                    exit();
                } else {
                    throw new Exception('Cập nhật danh mục thất bại');
                }
            }

            header('Location: index.php?action=category');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?action=category');
            exit();
        }
    }

    public static function deleteCategoryController()
    {
        try {
            // Lấy ID từ URL và validate
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception("ID danh mục không hợp lệ");
            }

            // Kiểm tra xem category có tồn tại không
            $category = CategoryModel::getCategoryById($id);
            if (!$category) {
                throw new Exception("Danh mục không tồn tại");
            }

            // Lấy đường dẫn ảnh đầy đủ
            $imagePath = '../' . $category['img'];

            // Thực hiện xóa
            if (CategoryModel::deleteCategory($id)) {
                // Xóa file ảnh nếu tồn tại
                if (!empty($category['img']) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $_SESSION['success'] = "Xóa danh mục thành công";
            } else {
                throw new Exception("Không thể xóa danh mục vì danh mục đang chứa sản phẩm");
            }

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header("Location: index.php?action=category");
        exit();
    }
}