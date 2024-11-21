<?php
define('PATH_ROOT', dirname(__DIR__));
session_start();
require_once "client/commons/env.php";
require_once "client/commons/function.php";
require_once "client/controllers/homeController.php";
require_once "client/controllers/productController.php";
require_once "client/controllers/loginController.php";
require_once "client/controllers/cartController.php";

$action = $_GET['action'] ?? 'home';
$cartController = new CartController();

switch ($action) {
    case 'home':
        HomeController::homeController();
        break;
    case 'login':
        LoginController::loginController();
        break;
    case 'logout':
        LoginController::logoutController();
        break;
    case 'product':
        ProductController::productController();
        break;
    case 'product-category':
        ProductController::productCategoryController();
        break;
    case 'product-detail':
        ProductController::productDetailController();
        break;
    case 'add-to-cart':
        $cartController->addToCart();
        break;
    case 'update-cart':
        $cartController->updateCart();
        break;
    case 'remove-from-cart':
        $cartController->removeFromCart();
        break;
    case 'get-cart':
        $cartController->getCartItems();
        break;
    case 'cart':
        $cartController->viewCart();
        break;
    default:
        HomeController::homeController();
        break;
}
