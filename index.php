<?php
define('PATH_ROOT', dirname(__DIR__));
session_start();
require_once "client/commons/env.php";
require_once "client/commons/function.php";

require_once "client/controllers/homeController.php";
require_once "client/controllers/productController.php";
require_once "client/controllers/cartController.php";
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
    case 'add-to-cart':
        require_once 'client/controllers/cartController.php';
        $cartController = new CartController();
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
        require_once 'client/controllers/cartController.php';
        $cartController = new CartController();
        $cartController->viewCart();
        break;
}
