<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './models/homeModel.php';
require_once 'productController.php';

class HomeController
{
    private static $mainModel;

    public function __construct()
    {
        self::$mainModel = new HomeModel();
    }
    
    public static function homeController()
    {
        try {
            if (!self::$mainModel) {
                self::$mainModel = new HomeModel();
            }

            $totalProducts = self::$mainModel->countProducts();
            $totalUsers = self::$mainModel->countUsers();
            $totalComments = self::$mainModel->countComments();
            $totalRevenue = self::$mainModel->getTotalRevenue();
            $topProducts = self::$mainModel->getTopProducts();
            $totalOrders = self::$mainModel->countOrders();

            require_once './views/home.php';
        } catch (Exception $e) {
            error_log("Home controller error: " . $e->getMessage());
            $_SESSION['error'] = 'Có lỗi xảy ra';
            header('Location: index.php');
            exit();
        }
    }
}
?>