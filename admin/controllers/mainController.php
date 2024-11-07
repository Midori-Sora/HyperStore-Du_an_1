<?php
require_once './models/mainModel.php';

class MainController
{
    public static function productController()
    {
        // $authModel = new AuthModel;
        // $authModel->check_login();
        $productModel = new ProductModel;
        $products = $productModel->getProductList();
        require_once './views/product.php';
    }
    public static function editProductController()
    {
        if(isset($_POST['']))
    }
}
?>