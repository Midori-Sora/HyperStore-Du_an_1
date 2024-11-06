<?php
    session_start();

    require_once 'controllers/mainController.php';
    require_once 'models/mainModel.php';

    $action = $_GET['action'] ?? 'home';

    switch ($action) {
        case 'product':
            MainController::productController();
            break;
    }
?>