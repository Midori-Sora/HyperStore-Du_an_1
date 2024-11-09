<?php
class CateModel extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCateList()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>