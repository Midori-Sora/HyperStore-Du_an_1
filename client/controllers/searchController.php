<?php
require_once "client/models/searchModel.php";

class SearchController {
    public static function searchController() {
        $searchModel = new SearchModel();
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        if (empty($keyword)) {
            header('Location: index.php');
            exit;
        }

        $products = $searchModel->searchProducts($keyword);
        require_once "client/views/search/search-results.php";
    }
}
