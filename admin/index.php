<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('PATH_ROOT', dirname(__DIR__));

session_start();


require_once 'controllers/mainController.php';
require_once 'controllers/productController.php';
require_once 'controllers/commentController.php';
require_once "./commons/env.php";
require_once "./commons/function.php";

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        MainController::homeController();
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
    case 'comment':
        CommentController::commentController();
        break;
    case 'deleteComment':
        CommentController::deleteCommentController();
        break;
}
