<?php
session_start();
define('PATH_ROOT', dirname(__DIR__));

// Load database connection first
require_once "client/commons/env.php";
require_once "client/commons/function.php";

// Then load models
require_once "client/models/cartModel.php";

// Finally load controllers
require_once "client/controllers/homeController.php";
require_once "client/controllers/productController.php";
require_once "client/controllers/loginController.php";
require_once "client/controllers/cartController.php";
require_once "client/controllers/commentController.php";
require_once "client/controllers/searchController.php";
require_once "client/controllers/registerController.php";
require_once "client/controllers/profileController.php";
$action = $_GET['action'] ?? 'home';

// Debug session
error_log('Session data: ' . print_r($_SESSION, true));

switch ($action) {
    case 'home':
        HomeController::homeController();
        break;
    case 'login':
        LoginController::loginController();
        break;
    case 'register':
        RegisterController::registerController();
        break;
    case 'register-process':
        RegisterController::registerProcessController();
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
        CartController::addToCart();
        break;
    case 'view-cart':
        CartController::viewCart();
        break;
    case 'remove-from-cart':
        CartController::removeFromCart();
        break;
    case 'add-comment':
        CommentController::addComment();
        break;
    case 'search':
        SearchController::searchController();
        break;
    case 'profile':
        ProfileController::profileController();
        break;
    case 'update-profile':
        ProfileController::updateProfileController();
        break;
}
