<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'duan1');
define('DB_USER', 'root');
define('DB_PASS', '');

// PDO Options
define('PDO_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
]);

// Require core files first
require_once "commons/function.php";

// Then require models
require_once "models/userModel.php";
require_once "models/categoryModel.php";
require_once "models/commentModel.php";
require_once "models/productModel.php";
require_once "models/orderModel.php";
