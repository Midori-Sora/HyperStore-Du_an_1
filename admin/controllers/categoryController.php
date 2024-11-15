<?php
require_once 'models/categoryModel.php';

class CategoryController
{
    public static function categoryController()
    {
        $categories = CategoryModel::getAllCategories();
        include 'views/category/category.php';
    }
    public static function addCategoryController()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cate_name' => $_POST['cate_name'],
                'description' => $_POST['description'],
                'cate_status' => $_POST['cate_status']
            ];


            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/Category/';


                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = basename($_FILES['img']['name']);
                $uploadFilePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFilePath)) {
                    $data['img'] = $uploadFilePath;
                } else {
                    echo "Lỗi khi tải lên ảnh.";
                    return;
                }
            } else {
                echo "Vui lòng chọn một ảnh hợp lệ.";
                return;
            }

            if (CategoryModel::addCategory($data)) {
                header("Location: index.php?action=category");
                exit();
            } else {
                echo "Lỗi khi thêm danh mục.";
            }
        }

        include 'views/category/add-category.php';
    }

    public static function editCategoryController($id)
    {
        $category = CategoryModel::getCategoryById($id);
        if ($category) {
            include 'views/category/edit-category.php';
        } else {
            echo "Danh mục không tồn tại.";
        }
    }

    public static function updateCategoryController()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'cate_name' => $_POST['cate_name'],
                'description' => $_POST['description'],
                'cate_status' => $_POST['cate_status'],
                'cate_id' => $_GET['id'],
            ];


            if (!empty($_FILES['img']['name'])) {
                $uploadDir = '../uploads/Category/';
                $uploadFilePath = $uploadDir . basename($_FILES['img']['name']);

                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadFilePath)) {
                    $data['img'] = $uploadFilePath;
                } else {
                    echo "Lỗi khi tải lên ảnh mới.";
                    return;
                }
            } else {

                $category = CategoryModel::getCategoryById($data['cate_id']);
                $data['img'] = $category['img'];
            }

            if (CategoryModel::updateCategory($data)) {
                header("Location: index.php?action=category");
                exit();
            } else {
                echo "Failed to update category";
            }
        }
    }


    public static function deleteCategoryController($id)
    {
        if (CategoryModel::deleteCategory($id)) {
            header("Location: index.php?action=category");
            exit();
        } else {
            echo "Không thể xóa danh mục.";
        }
    }
}
