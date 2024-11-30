<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
define('PATH_ROOT', dirname(__DIR__));

require_once 'models/commentModel.php';
require_once 'models/homeModel.php';
require_once 'models/logoutModel.php';
require_once 'models/orderModel.php';
require_once 'models/productModel.php';
require_once 'models/dealModel.php';
require_once 'models/bannerModel.php';
require_once 'models/categoryModel.php';
require_once 'models/userModel.php';
require_once 'models/MainModel.php';
require_once 'models/orderModel.php';

require_once 'controllers/homeController.php';
require_once 'controllers/productController.php';
require_once 'controllers/commentController.php';
require_once 'controllers/categoryController.php';
require_once 'controllers/userController.php';
require_once 'controllers/bannerController.php';
require_once 'controllers/orderController.php';
require_once 'controllers/dealController.php';
require_once 'controllers/logoutController.php';

require_once "./commons/env.php";
require_once "./commons/function.php";

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        HomeController::homeController();
        break;
    case 'logout':
        LogoutController::logoutController();
        break;
    case 'product':
        ProductController::productController();
        break;
    case 'editProduct':
        ProductController::editProductController();
        break;
    case 'deleteProduct':
        ProductController::deleteProductController();
        break;
    case 'addProduct':
        ProductController::addProductController();
        break;
    case 'productDetail':
        ProductController::productDetailController();
        break;
    case 'productVariant':
        ProductController::productVariantController();
        break;
    case 'addStorage':
        ProductController::addStorageController();
        break;
    case 'addColor':
        ProductController::addColorController();
        break;
    case 'deleteStorage':
        ProductController::deleteStorageController();
        break;
    case 'deleteColor':
        ProductController::deleteColorController();
        break;
    case 'updateQuantity':
        ProductController::updateQuantityController();
        break;
    case 'comment':
        CommentController::commentController();
        break;
    case 'deleteComment':
        CommentController::deleteCommentController();
        break;
    case 'updateCommentStatus':
        CommentController::updateStatusController();
        break;
    case 'category':
        CategoryController::categoryController();
        break;

    case 'addCategory':
        CategoryController::addCategoryController();
        break;

    case 'editCategory':
        CategoryController::editCategoryController();
        break;

    case 'updateCategory':
        CategoryController::updateCategoryController();
        break;

    case 'deleteCategory':
        CategoryController::deleteCategoryController();
        break;
    case 'editUser':
        UserController::editUserController();
        break;

    case 'storeUser':
        UserController::storeUserController();
        break;

    case 'user':
        UserController::userController();
        break;

    case 'addUser':
        UserController::addUserController();
        break;

    case 'updateUser':
        UserController::updateUserController();
        break;

    case 'deleteUser':
        UserController::deleteUserController();
        break;
    case 'banner':
        BannerController::bannerController();
        break;
    case 'addBanner':
        BannerController::addBannerController();
        break;
    case 'editBanner':
        BannerController::editBannerController();
        break;
    case 'deleteBanner':
        BannerController::deleteBannerController();
        break;
    case 'order':
        OrderController::orderController();
        break;
    case 'orderDetail':
        OrderController::orderDetailController();
        break;
    case 'updateOrderStatus':
        OrderController::updateOrderStatusController();
        break;
    case 'searchOrder':
        OrderController::searchOrderController();
        break;
    case 'sendSMS':
        OrderController::sendSMSController();
        break;
        // ... cc case khác ...
    case 'searchUsers':
        UserController::searchUsersController();
        break;
    case 'viewUser':
        UserController::viewUserController();
        break;
        // ... các case khác ...
    case 'printInvoice':
        OrderController::printInvoiceController();
        break;
    case 'deal':
        DealController::dealController();
        break;
    case 'addDeal':
        DealController::addDealController();
        break;
    case 'deleteDeal':
        DealController::deleteDealController();
        break;
    case 'editDeal':
        DealController::editDealController();
        break;
    case 'dealDetails':
        DealController::dealDetailsController();
        break;
    case 'deleteManyDeals':
        DealController::deleteManyDealsController();
        break;
    case 'logout':
        LogoutController::logoutController();
    case 'editColor':
        ProductController::editColorController();
        break;
    case 'editStorage':
        ProductController::editStorageController();
        break;
    case 'handleReturnRequest':
        OrderController::handleReturnRequestController();
        break;
}
