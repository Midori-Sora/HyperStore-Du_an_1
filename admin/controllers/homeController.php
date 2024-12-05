<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './models/homeModel.php';
require_once 'productController.php';

class HomeController
{
    private static $mainModel;

    public static function init() {
        if (!self::$mainModel) {
            self::$mainModel = new HomeModel();
        }
    }

    public static function homeController()
    {
        self::init();
        try {
            $totalProducts = self::$mainModel->countProducts();
            $totalUsers = self::$mainModel->countUsers();
            $totalComments = self::$mainModel->countComments();
            $totalOrders = self::$mainModel->countOrders();
            $monthlyRevenue = self::$mainModel->getMonthlyRevenue();
            $productDistribution = self::$mainModel->getProductDistribution();
            $topProducts = self::$mainModel->getTopProducts();

            require_once './views/home.php';
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            header('Location: index.php');
            exit();
        }
    }
}
?>