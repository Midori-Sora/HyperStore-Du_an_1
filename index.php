<?php

session_start();

require_once 'app\controller\MainController.php';
require_once 'app\model\MainModel.php';


$action = isset($_GET['action']) ? $_GET['action'] : 'home';

//Home controller
if ($action == 'home') {
    MainController::homeController();
}
//Account controller
elseif ($action == 'register') {
    AccountController::accountRegController($Model);
} elseif ($action == 'login') {
    AccountController::accountLoginController($Model);
} elseif ($action == 'logout') {
    AccountController::accountLogoutController();
}
//Product controller
elseif ($action == 'search') {
    MainController::searchController();
} elseif ($action == 'product') {
    ProductController::productController();
} elseif ($action == 'category') {
    CategoryController::categoryController();
}
// Else 404
else {
    echo 'Oops! This function is building';
    die();
}
