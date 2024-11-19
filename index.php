<?php
define('PATH_ROOT', dirname(__DIR__));
session_start();
require_once "client/commons/env.php";
require_once "client/commons/function.php";

require_once "client/controllers/homeController.php";
require_once "client/controllers/productController.php";
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        HomeController::homeController();
        break;
    case 'product':
        ProductController::productController();
        break;
    case 'product-category':
        ProductController::productCategoryController();
        break;
}
?>