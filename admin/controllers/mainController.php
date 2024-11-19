<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './models/mainModel.php';
require_once 'productController.php';

class MainController
{
    public function __construct()
    {
        // Constructor
    }
    
    public static function homeController()
    {
        // $productModel = new ProductModel();
        // $totalProducts = $productModel->countProducts();
        // $totalCategories = $productModel->countCategories();
        // $totalUsers = $productModel->countUsers();
        require_once './views/home.php';
    }

    // Các phương thức khác không liên quan đến product
}
?>