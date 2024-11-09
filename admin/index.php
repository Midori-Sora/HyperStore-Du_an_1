<?php
    define('PATH_ROOT', dirname(__DIR__));  // Đường dẫn tới thư mục gốc của project

    session_start();

    require_once 'controllers/mainController.php';
    require_once 'controllers/productController.php';
    require_once 'controllers/commentController.php';
    require_once 'models/mainModel.php';
    require_once 'controllers/authController.php';

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
        case 'addComment':
            CommentController::addCommentController();
            break;
    }
?>