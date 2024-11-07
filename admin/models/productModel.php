<?php
class ProductModel extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProductList()
    {
        $sql = "SELECT products.*,categories.cate_name
                FROM products
                INNER JOIN categories
                ON products.cate_id = categories.cate_id";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>