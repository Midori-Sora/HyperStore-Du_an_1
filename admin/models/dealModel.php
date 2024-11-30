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
            // Sửa lại câu query để lấy deal_id đầu tiên của mỗi nhóm
            $sql = "SELECT 
                    MIN(deal_id) as deal_id,
                    discount,
                    start_date,
                    end_date,
                    status,
                    GROUP_CONCAT(pro_id) as product_ids,
                    COUNT(pro_id) as product_count
                    FROM product_deals 
                    GROUP BY discount, start_date, end_date, status
                    ORDER BY start_date DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $deals = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Lấy thông tin sản phẩm cho mỗi nhóm
            foreach ($deals as &$deal) {
                $productIds = explode(',', $deal['product_ids']);
                $placeholders = str_repeat('?,', count($productIds) - 1) . '?';

                $sql = "SELECT pro_name, price FROM products WHERE pro_id IN ($placeholders)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($productIds);
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $deal['products'] = $products;
                $deal['products_text'] = implode(', ', array_column($products, 'pro_name'));
            }

            return $deals;
        } catch (PDOException $e) {
            error_log("Get deal list error: " . $e->getMessage());
            return false;
        }
    }

    public function addDeal($discount, $start_date, $end_date, $status, $product_ids)
    {
        try {
            $this->db->beginTransaction();

            foreach ($product_ids as $pro_id) {
                $sql = "INSERT INTO product_deals (pro_id, discount, start_date, end_date, status) 
                        VALUES (:pro_id, :discount, :start_date, :end_date, :status)";

                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':pro_id' => $pro_id,
                    ':discount' => $discount,
                    ':start_date' => $start_date,
                    ':end_date' => $end_date,
                    ':status' => $status
                ]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Add deal error: " . $e->getMessage());
            return false;
        }
    }

    public function getDeal($deal_id)
    {
        try {
            // Lấy thông tin cơ bản của deal
            $sql = "SELECT d.*, GROUP_CONCAT(d.pro_id) as selected_products
                    FROM product_deals d
                    WHERE d.deal_id = :deal_id
                    GROUP BY d.discount, d.start_date, d.end_date, d.status";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':deal_id' => $deal_id]);
            $deal = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($deal) {
                // Lấy tất cả sản phẩm có cùng điều kiện khuyến mãi
                $sql = "SELECT DISTINCT pro_id 
                        FROM product_deals 
                        WHERE discount = :discount 
                        AND start_date = :start_date 
                        AND end_date = :end_date";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':discount' => $deal['discount'],
                    ':start_date' => $deal['start_date'],
                    ':end_date' => $deal['end_date']
                ]);
                $deal['product_ids'] = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'pro_id');
            }

            return $deal;
        } catch (PDOException $e) {
            error_log("Get deal error: " . $e->getMessage());
            return false;
        }
    }

    public function updateDeal($deal_id, $discount, $start_date, $end_date, $status, $product_ids)
    {
        try {
            $this->db->beginTransaction();

            // Lấy thông tin deal cũ
            $sql = "SELECT discount, start_date, end_date FROM product_deals WHERE deal_id = :deal_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':deal_id' => $deal_id]);
            $oldDeal = $stmt->fetch(PDO::FETCH_ASSOC);

            // Xóa tất cả deal cũ có cùng điều kiện
            $sql = "DELETE FROM product_deals 
                    WHERE discount = :old_discount 
                    AND start_date = :old_start_date 
                    AND end_date = :old_end_date";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':old_discount' => $oldDeal['discount'],
                ':old_start_date' => $oldDeal['start_date'],
                ':old_end_date' => $oldDeal['end_date']
            ]);

            // Thm deal mới cho từng sản phẩm
            foreach ($product_ids as $pro_id) {
                $sql = "INSERT INTO product_deals (pro_id, discount, start_date, end_date, status) 
                        VALUES (:pro_id, :discount, :start_date, :end_date, :status)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':pro_id' => $pro_id,
                    ':discount' => $discount,
                    ':start_date' => $start_date,
                    ':end_date' => $end_date,
                    ':status' => $status
                ]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Update deal error: " . $e->getMessage());
            return false;
        }
    }

    public function getProducts()
    {
        try {
            $sql = "SELECT p.pro_id, p.pro_name, p.price, p.cate_id, c.cate_name 
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id 
                    WHERE p.pro_status = 1 
                    ORDER BY c.cate_name, p.pro_name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get products error: " . $e->getMessage());
            return false;
        }
    }

    public function getCategories()
    {
        $sql = "SELECT DISTINCT c.cate_id, c.cate_name 
                FROM categories c
                INNER JOIN products p ON c.cate_id = p.cate_id
                WHERE p.pro_status = 1
                ORDER BY c.cate_name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteDeal($deal_id)
    {
        try {
            $this->db->beginTransaction();

            // Lấy thông tin của deal cần xóa
            $sql = "SELECT discount, start_date, end_date FROM product_deals WHERE deal_id = :deal_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':deal_id' => $deal_id]);
            $dealInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dealInfo) {
                // Xóa tất cả các deal có cùng discount và thời gian
                $sql = "DELETE FROM product_deals 
                        WHERE discount = :discount 
                        AND start_date = :start_date 
                        AND end_date = :end_date";

                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    ':discount' => $dealInfo['discount'],
                    ':start_date' => $dealInfo['start_date'],
                    ':end_date' => $dealInfo['end_date']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Delete deal error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteManyDeals($dealIds)
    {
        try {
            $this->db->beginTransaction();

            // Xóa tất cả các deal có cùng discount và thời gian
            $sql = "DELETE pd1 FROM product_deals pd1
                    INNER JOIN (
                        SELECT discount, start_date, end_date 
                        FROM product_deals 
                        WHERE deal_id IN (" . str_repeat('?,', count($dealIds) - 1) . "?)
                    ) pd2 
                    ON pd1.discount = pd2.discount 
                    AND pd1.start_date = pd2.start_date 
                    AND pd1.end_date = pd2.end_date";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($dealIds);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Delete many deals error: " . $e->getMessage());
            return false;
        }
    }

    public function getDealDetails($deal_id)
    {
        try {
            error_log("Getting deal details for ID: " . $deal_id); // Debug log

            // Lấy thông tin deal chính
            $sql = "SELECT pd.*, 
                           p.pro_name, 
                           p.price, 
                           p.img,
                           ps.storage_type, 
                           pc.color_type
                    FROM product_deals pd
                    JOIN products p ON pd.pro_id = p.pro_id 
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    WHERE pd.deal_id = :deal_id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([':deal_id' => $deal_id]);
            $mainDeal = $stmt->fetch(PDO::FETCH_ASSOC);

            error_log("Main deal data: " . print_r($mainDeal, true)); // Debug log

            if (!$mainDeal) {
                error_log("No main deal found for ID: " . $deal_id);
                return false;
            }

            // Lấy tất cả sản phẩm trong cùng đợt khuyến mãi
            $sql = "SELECT pd.*, 
                           p.pro_name, 
                           p.price, 
                           p.img,
                           ps.storage_type, 
                           pc.color_type
                    FROM product_deals pd
                    JOIN products p ON pd.pro_id = p.pro_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    WHERE pd.discount = :discount 
                    AND pd.start_date = :start_date 
                    AND pd.end_date = :end_date";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':discount' => $mainDeal['discount'],
                ':start_date' => $mainDeal['start_date'],
                ':end_date' => $mainDeal['end_date']
            ]);

            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Related products: " . count($products)); // Debug log

            return [
                'main_deal' => $mainDeal,
                'products' => $products
            ];
        } catch (PDOException $e) {
            error_log("Error in getDealDetails: " . $e->getMessage());
            return false;
        }
    }
}
