<?php
require_once './models/bannerModel.php';

class BannerController {
    private static $bannerModel;

    public static function init() {
        if (!self::$bannerModel) {
            self::$bannerModel = new BannerModel();
        }
    }

    public static function bannerController() {
        self::init();
        $banners = self::$bannerModel->getBannerList();
        require_once './views/banner/banner.php';
    }

    public static function addBannerController() {
        self::init();
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize and validate inputs
                $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
                $image = trim(filter_var($_POST['image_url'], FILTER_SANITIZE_STRING));
                $status = filter_var($_POST['status'], FILTER_VALIDATE_INT);
                $created_at = date('Y-m-d H:i:s');

                // Validate title length
                if (strlen($title) < 3 || strlen($title) > 255) {
                    throw new Exception('Tiêu đề phải từ 3 đến 255 ký tự');
                }

                // Validate status
                if ($status !== 0 && $status !== 1) {
                    throw new Exception('Trạng thái không hợp lệ');
                }

                // Validate image exists
                $target = '../Uploads/Slides/' . $image;
                if (!file_exists($target)) {
                    throw new Exception('Ảnh không tồn tại trong thư mục Uploads/Slides');
                }

                // Validate image extension
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                if (!in_array($extension, $allowedExtensions)) {
                    throw new Exception('Định dạng ảnh không hợp lệ');
                }

                if (self::$bannerModel->addBanner($title, $image, $status, $created_at)) {
                    $_SESSION['success'] = 'Thêm banner thành công';
                    header('Location: index.php?action=banner');
                    exit();
                } else {
                    throw new Exception('Thêm banner thất bại');
                }
            }
            require_once './views/banner/add-banner.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=banner');
            exit();
        }
    }

    public static function deleteBannerController() {
        self::init();
        try {
            if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];
                
                // Get banner info to check if image exists
                $banner = self::$bannerModel->getBannerById($id);
                if (!$banner) {
                    throw new Exception('Banner không tồn tại');
                }

                if (self::$bannerModel->deleteBanner($id)) {
                    $_SESSION['success'] = 'Xóa banner thành công';
                } else {
                    throw new Exception('Xóa banner thất bại');
                }
            } else {
                throw new Exception('ID banner không hợp lệ');
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        header('Location: index.php?action=banner');
        exit();
    }

    public static function editBannerController() {
        self::init();
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('ID banner không hợp lệ');
            }

            $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
            if ($id === false) {
                throw new Exception('ID banner phải là số nguyên');
            }

            $banner = self::$bannerModel->getBannerById($id);
            if (!$banner) {
                throw new Exception('Banner không tồn tại');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize and validate inputs
                $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
                $image_url = trim(filter_var($_POST['image_url'], FILTER_SANITIZE_STRING));
                $status = filter_var($_POST['status'], FILTER_VALIDATE_INT);

                // Additional validation
                if (strlen($title) < 3 || strlen($title) > 255) {
                    throw new Exception('Tiêu đề phải từ 3 đến 255 ký tự');
                }

                if ($status !== 0 && $status !== 1) {
                    throw new Exception('Trạng thái không hợp lệ');
                }

                // Validate image exists
                $target = '../Uploads/Slides/' . $image_url;
                if (!file_exists($target)) {
                    throw new Exception('Ảnh không tồn tại trong thư mục Uploads/Slides');
                }

                if (self::$bannerModel->updateBanner($id, $title, $image_url, $status)) {
                    $_SESSION['success'] = 'Cập nhật banner thành công';
                    header('Location: index.php?action=banner');
                    exit();
                } else {
                    throw new Exception('Cập nhật banner thất bại');
                }
            }

            require_once './views/banner/edit-banner.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php?action=banner');
            exit();
        }
    }
}
?>