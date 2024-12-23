<?php
class HomeController
{
    public static function homeController()
    {
        $model = new HomeModel();
        $featuredProducts = $model->getFeaturedProducts();
        $newestPhones = $model->getNewestPhones();
        $discountProducts = $model->getDiscountProducts();
        
        foreach ($featuredProducts as &$product) {
            $model->calculateProductPrice($product);
        }
        foreach ($newestPhones as &$product) {
            $model->calculateProductPrice($product);
        }
        foreach ($discountProducts as &$product) {
            $model->calculateProductPrice($product);
        }
        
        require_once "client/views/home.php";
    }
}
?>