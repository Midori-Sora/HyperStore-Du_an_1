<?php
session_start();
require_once 'controllers/Main.php';
require_once 'models/Main.php';
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        // echo "Home";
        MainController::homeController();
        break;
    case 'login':
        MainController::loginController();
        break;
    case 'logout':
        MainController::logoutController();
        break;
    case 'user':
        MainController::userController();
        break;
    case 'delete-user':
        $id = $_GET['id'];
        MainController::deleteUserController($id);
        break;
    case 'addUser':
        MainController::addUserController();
        break;
    case 'cate':
        MainController::cateController();
        break;
    case 'deleteCate':
        $id = $_GET['id'];
        MainController::deleteCateController($id);
        break;
    case 'addCate':
        MainController::addCateController();
        break;
    case 'editCate':
        $id = $_GET['id'];
        MainController::editCateController($id);
        break;
    case 'product':
        MainController::productController();
        break;
    case 'deleteProduct':
        $id = $_GET['id'];
        MainController::deleteProductController($id);
        break;
    case 'addProduct':
        MainController::addProductController();
        break;
    case 'editProduct':
        $id = $_GET['id'];
        MainController::editProductController($id);
        break;
    // case 'change-password':
    //     MainController::changePasswordController();
    //     break;
    case 'updateUser':
        $id = $_GET['id'];
        MainController::updateUserController($id);
        break;
    case 'comment':
        MainController::showCommentController();
        break;
    case 'deleteComment':
        $id = $_GET['id'];
        MainController::deleteCommentController($id);
        break;
    default:
        echo "This page is building...";
        break;
}
