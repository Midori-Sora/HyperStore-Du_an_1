<?php
session_start();
define('PATH_ROOT', dirname(__DIR__));
require_once "client/commons/env.php";
require_once "client/commons/function.php";

require_once "client/controllers/homeController.php";
require_once "client/controllers/productController.php";
require_once "client/controllers/loginController.php";
require_once "client/controllers/cartController.php";

$action = $_GET['action'] ?? 'home';

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
    case 'cart':
        $cartController = new CartController();
        $cartController->viewCart();
        break;
    case 'add-to-cart':
        $cartController = new CartController();
        $cartController->addToCart();
        break;
    case 'update-cart':
        $cartController = new CartController();
        $cartController->updateCart();
        break;
    case 'remove-from-cart':
        $cartController = new CartController();
        $cartController->removeFromCart();
        break;
    case 'get-cart-items':
        $cartController = new CartController();
        $cartController->getCartItems();
        break;
}
