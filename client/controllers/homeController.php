<?php
require_once "client/models/homeModel.php";
class HomeController
{
    public static function homeController()
    {
        $model = new HomeModel();
        $featuredProducts = $model->getFeaturedProducts();
        $newestPhones = $model->getNewestPhones();
        
        // Pass data to view
        require_once "client/views/home.php";
    }
}
?>