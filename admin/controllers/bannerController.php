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
                // Sanitize inputs
                $title = trim(htmlspecialchars($_POST['title']));
                $image = trim(htmlspecialchars($_POST['image_url']));
                $status = (int)$_POST['status'];
                $created_at = date('Y-m-d H:i:s');

                // Validate inputs
                if (empty($title) || empty($image)) {
                    throw new Exception('Vui lòng điền đầy đủ thông tin');
                }
                

                // Validate image exists
                $target = PATH_ROOT . '/Uploads/Slides/' . $image;
                if (!file_exists($target)) {
                    throw new Exception('Ảnh không tồn tại trong thư mục Uploads/Slides');
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

            $id = (int)$_GET['id'];
            $banner = self::$bannerModel->getBannerById($id);
            
            if (!$banner) {
                throw new Exception('Banner không tồn tại');
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitize inputs
                $title = trim(htmlspecialchars($_POST['title']));
                $image_url = trim(htmlspecialchars($_POST['image_url']));
                $status = (int)$_POST['status'];

                // Validate inputs
                if (empty($title) || empty($image_url)) {
                    throw new Exception('Vui lòng điền đầy đủ thông tin');
                }

                // Validate image exists
                $target = PATH_ROOT . '/Uploads/Slides/' . $image_url;
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