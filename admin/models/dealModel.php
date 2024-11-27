<?php
class DealModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getDealList()
    {
        try {
            $sql = "SELECT d.*, p.pro_name, p.price as pro_price FROM product_deals d
                    LEFT JOIN products p ON d.pro_id = p.pro_id
                    ORDER BY d.deal_id DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get deal list error: " . $e->getMessage());
            throw new Exception("Không thể lấy danh sách khuyến mãi");
        }
    }

    public function addDeal($pro_id, $discount, $start_date, $end_date, $status)
    {
        try {
            $sql = "INSERT INTO product_deals (pro_id, discount, start_date, end_date, status) 
                    VALUES (:pro_id, :discount, :start_date, :end_date, :status)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':pro_id' => $pro_id,
                ':discount' => $discount,
                ':start_date' => $start_date,
                ':end_date' => $end_date,
                ':status' => $status
            ]);
        } catch (PDOException $e) {
            error_log("Add deal error: " . $e->getMessage());
            throw new Exception("Không thể thêm khuyến mãi");
        }
    }

    public function deleteDeal($deal_id)
    {
        $sql = "DELETE FROM product_deals WHERE deal_id = :deal_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':deal_id' => $deal_id]);
    }

    public function getDealById($deal_id)
    {
        $sql = "SELECT * FROM product_deals WHERE deal_id = :deal_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':deal_id' => $deal_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDeal($deal_id, $pro_id, $discount, $start_date, $end_date, $status)
    {
        $sql = "UPDATE product_deals SET pro_id = :pro_id, discount = :discount, start_date = :start_date, end_date = :end_date, status = :status WHERE deal_id = :deal_id";
        $stmt = $this->db->prepare($sql);
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
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}