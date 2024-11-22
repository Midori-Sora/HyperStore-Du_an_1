<?php
class DealModel extends MainModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDealList()
    {
        $sql = "SELECT d.*, p.pro_name, p.price as pro_price FROM product_deals d
                LEFT JOIN products p ON d.pro_id = p.pro_id
                ORDER BY d.deal_id DESC";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addDeal($pro_id, $discount, $start_date, $end_date, $status)
    {
        $sql = "INSERT INTO product_deals (pro_id, discount, start_date, end_date, status) 
                VALUES (:pro_id, :discount, :start_date, :end_date, :status)";
        $stmt = $this->SUNNY->prepare($sql);
        return $stmt->execute([
            ':pro_id' => $pro_id,
            ':discount' => $discount,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':status' => $status
        ]);
    }

    public function deleteDeal($deal_id)
    {
        $sql = "DELETE FROM product_deals WHERE deal_id = :deal_id";
        $stmt = $this->SUNNY->prepare($sql);
        return $stmt->execute([':deal_id' => $deal_id]);
    }

    public function getDealById($deal_id)
    {
        $sql = "SELECT * FROM product_deals WHERE deal_id = :deal_id";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute([':deal_id' => $deal_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDeal($deal_id, $pro_id, $discount, $start_date, $end_date, $status)
    {
        $sql = "UPDATE product_deals SET pro_id = :pro_id, discount = :discount, start_date = :start_date, end_date = :end_date, status = :status WHERE deal_id = :deal_id";
        $stmt = $this->SUNNY->prepare($sql);
        return $stmt->execute([
            ':deal_id' => $deal_id,
            ':pro_id' => $pro_id,
            ':discount' => $discount,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':status' => $status
        ]);
    }

    public function getProducts()
    {
        $sql = "SELECT pro_id, pro_name, price FROM products WHERE pro_status = 1 ORDER BY pro_name";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}