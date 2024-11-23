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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pro_id = $_POST['pro_id'];
            $discount = $_POST['discount'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];
            $status = $_POST['status'];

            // New validation check for date order
            if (strtotime($start_date) >= strtotime($end_date)) {
                $_SESSION['error'] = 'Ngày bắt đầu phải trước ngày kết thúc';
            } else {
                if (self::$dealModel->addDeal($pro_id, $discount, $start_date, $end_date, $status)) {
                    $_SESSION['success'] = 'Thêm khuyến mãi thành công';
                    header('Location: index.php?action=deal');
                    exit();
                } else {
                    $_SESSION['error'] = 'Thêm khuyến mãi thất bại';
                }
            }
        }
        require_once './views/deal/add-deal.php';
    }

    public static function deleteDealController()
    {
        self::init();
        if (isset($_GET['id'])) {
            $deal_id = (int)$_GET['id'];
            if (self::$dealModel->deleteDeal($deal_id)) {
                $_SESSION['success'] = 'Xóa khuyến mãi thành công';
            } else {
                $_SESSION['error'] = 'Xóa khuyến mãi thất bại';
            }
            header('Location: index.php?action=deal');
            exit();
        }
    }

    public static function editDealController()
    {
        self::init();
        if (isset($_GET['id'])) {
            $deal_id = (int)$_GET['id'];
            $deal = self::$dealModel->getDealById($deal_id);
            $products = self::$dealModel->getProducts();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pro_id = $_POST['pro_id'];
                $discount = $_POST['discount'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $status = $_POST['status'];

                if (self::$dealModel->updateDeal($deal_id, $pro_id, $discount, $start_date, $end_date, $status)) {
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
}
