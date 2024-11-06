<?php
class ProductModel extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProductList()
    {
        $sql = "SELECT * FROM san_pham.*, danhmuc.ten_danh_muc FROM san_pham INNER JOIN danh_muc ON san_pham.danh_muc_id = danh_muc.danh_muc_id";
        
    }
}
?>