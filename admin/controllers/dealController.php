<?php
require_once './models/dealModel.php';

class DealController
{
    private static $dealModel;

    public static function init()
    {
        if (!self::$dealModel) {
            self::$dealModel = new DealModel();
        }
    }

    public static function dealController()
    {
        self::init();
        $deals = self::$dealModel->getDealList();
        require_once './views/deal/deal.php';
    }

    public static function addDealController()
    {
        self::init();
        $products = self::$dealModel->getProducts();
        $categories = self::$dealModel->getCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
            $discount = $_POST['discount'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $status = $_POST['status'];

            if (self::$dealModel->addDeal($discount, $start_date, $end_date, $status, $product_ids)) {
                $_SESSION['success'] = 'Thêm khuyến mãi thành công';
                header('Location: index.php?action=deal');
                exit();
            } else {
                $_SESSION['error'] = 'Thêm khuyến mãi thất bại';
            }
        }

        require_once './views/deal/add-deal.php';
    }

    public static function editDealController()
    {
        self::init();
        if (isset($_GET['id'])) {
            $deal_id = $_GET['id'];
            $deal = self::$dealModel->getDeal($deal_id);
            $products = self::$dealModel->getProducts();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $current_product_ids = isset($_POST['current_product_ids']) ? $_POST['current_product_ids'] : [];
                $new_product_ids = isset($_POST['product_ids']) ? $_POST['product_ids'] : [];
                $product_ids = array_merge($current_product_ids, $new_product_ids);

                $discount = $_POST['discount'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $status = $_POST['status'];

                if (self::$dealModel->updateDeal($deal_id, $discount, $start_date, $end_date, $status, $product_ids)) {
                    $_SESSION['success'] = 'Cập nhật khuyến mãi thành công';
                    header('Location: index.php?action=deal');
                    exit();
                } else {
                    $_SESSION['error'] = 'Cập nhật khuyến mãi thất bại';
                }
            }

            require_once './views/deal/edit-deal.php';
        }
    }

    public static function deleteDealController()
    {
        self::init();
        if (isset($_GET['id'])) {
            $deal_id = $_GET['id'];

            if (self::$dealModel->deleteDeal($deal_id)) {
                $_SESSION['success'] = 'Xóa khuyến mãi thành công';
            } else {
                $_SESSION['error'] = 'Xóa khuyến mãi thất bại';
            }
        }
        header('Location: index.php?action=deal');
        exit();
    }

    public static function deleteManyDealsController()
    {
        self::init();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_deals'])) {
            $dealIds = $_POST['selected_deals'];

            if (self::$dealModel->deleteManyDeals($dealIds)) {
                $_SESSION['success'] = 'Xóa các khuyến mãi đã chọn thành công';
            } else {
                $_SESSION['error'] = 'Xóa khuyến mãi thất bại';
            }
        }
        header('Location: index.php?action=deal');
        exit();
    }

    public static function dealDetailsController()
    {
        self::init();
        if (isset($_GET['id'])) {
            $deal_id = $_GET['id'];
            $dealDetails = self::$dealModel->getDealDetails($deal_id);

            if ($dealDetails === false) {
                $_SESSION['error'] = 'Không thể tải thông tin chi tiết khuyến mãi';
                header('Location: index.php?action=deal');
                exit();
            }

            error_log('Deal Details: ' . print_r($dealDetails, true));

            $view_path = './views/deal/deal-details.php';
            if (!file_exists($view_path)) {
                error_log('View file not found: ' . $view_path);
                $_SESSION['error'] = 'Không tìm thấy trang chi tiết';
                header('Location: index.php?action=deal');
                exit();
            }

            require_once $view_path;
            exit();
        } else {
            header('Location: index.php?action=deal');
            exit();
        }
    }
}