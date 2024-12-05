<?php
class SearchController {
    public static function searchController() {
        try {
            $searchModel = new SearchModel();
            $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
            
            if (empty($keyword)) {
                header('Location: index.php');
                exit;
            }

            $products = $searchModel->searchProducts($keyword);
            
            if (empty($products)) {
                error_log("No products found for keyword: " . $keyword);
            }

            require_once "client/views/search/search-results.php";
            
        } catch (Exception $e) {
            error_log("Search error: " . $e->getMessage());
            header('Location: index.php');
            exit;
        }
    }
}
