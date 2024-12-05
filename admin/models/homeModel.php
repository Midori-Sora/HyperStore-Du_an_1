<?php
class HomeModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function countProducts()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN pro_status = 1 THEN 1 END) as active,
                    COUNT(CASE WHEN pro_status = 0 THEN 1 END) as inactive
                    FROM products";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Count products error: " . $e->getMessage());
            return [
                'total' => 0,
                'active' => 0,
                'inactive' => 0
            ];
        }
    }

    public function countUsers()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN role_id = 1 THEN 1 ELSE 0 END) as admin,
                    SUM(CASE WHEN role_id = 2 THEN 1 ELSE 0 END) as customer
                    FROM users";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return [
                'total' => (int)$result['total'] ?? 0,
                'admin' => (int)$result['admin'] ?? 0,
                'customer' => (int)$result['customer'] ?? 0
            ];
        } catch (PDOException $e) {
            error_log("Count users error: " . $e->getMessage());
            return [
                'total' => 0,
                'admin' => 0,
                'customer' => 0
            ];
        }
    }

    public function countComments()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN cmt_status = 1 THEN 1 END) as approved,
                    COUNT(CASE WHEN cmt_status = 0 THEN 1 END) as pending   
                    FROM comments";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return [
                'total' => (int)($result['total'] ?? 0),
                'approved' => (int)($result['approved'] ?? 0), 
                'pending' => (int)($result['pending'] ?? 0)
            ];
        } catch (PDOException $e) {
            error_log("Count comments error: " . $e->getMessage());
            return [
                'total' => 0,
                'approved' => 0,
                'pending' => 0
            ];
        }
    }

    public function getTotalRevenue()
    {
        try {
            $sql = "SELECT SUM(od.price * od.quantity) as total_revenue 
                    FROM order_details od
                    JOIN orders o ON od.order_id = o.order_id
                    WHERE o.status = 'delivered'";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_revenue'] ?? 0;
        } catch (PDOException $e) {
            error_log("Get total revenue error: " . $e->getMessage());
            return 0;
        }
    }

    public function getTopProducts($limit = 5)
    {
        try {
            $sql = "SELECT 
                    p.pro_name, 
                    SUM(od.quantity) as total_sold, 
                    SUM(od.price * od.quantity) as total_revenue, 
                    c.cate_name
                    FROM order_details od
                    JOIN products p ON od.product_id = p.pro_id
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    JOIN orders o ON od.order_id = o.order_id
                    WHERE p.pro_status = 1 
                    AND o.status = 'delivered'  -- Chỉ tính đơn hàng đã giao thành công
                    GROUP BY p.pro_id, p.pro_name, c.cate_name
                    ORDER BY total_sold DESC
                    LIMIT :limit";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get top products error: " . $e->getMessage());
            return [];
        }
    }

    public function countOrders()
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN status = 'delivered' THEN 1 END) as completed,
                    COUNT(CASE WHEN status IN ('confirmed', 'processing') THEN 1 END) as processing,
                    COUNT(CASE WHEN status = 'shipping' THEN 1 END) as shipping,
                    COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled,
                    COUNT(CASE WHEN status IN ('return_requested', 'returned') THEN 1 END) as returns
                    FROM orders";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return [
                'total' => (int)($result['total'] ?? 0),
                'completed' => (int)($result['completed'] ?? 0),
                'processing' => (int)($result['processing'] ?? 0),
                'shipping' => (int)($result['shipping'] ?? 0),
                'cancelled' => (int)($result['cancelled'] ?? 0),
                'returns' => (int)($result['returns'] ?? 0)
            ];
        } catch (PDOException $e) {
            error_log("Count orders error: " . $e->getMessage());
            return [
                'total' => 0,
                'completed' => 0,
                'processing' => 0,
                'shipping' => 0,
                'cancelled' => 0,
                'returns' => 0
            ];
        }
    }

    public function getMonthlyRevenue($year = null)
    {
        try {
            if (!$year) {
                $year = date('Y');
            }
            
            $sql = "SELECT 
                    MONTH(o.created_at) as month,
                    SUM(od.price * od.quantity) as revenue
                    FROM orders o
                    JOIN order_details od ON o.order_id = od.order_id
                    WHERE YEAR(o.created_at) = :year
                    AND o.status IN ('delivered', 'completed') -- Chỉ tính các đơn hàng đã hoàn thành
                    GROUP BY MONTH(o.created_at)
                    ORDER BY month";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':year', $year, PDO::PARAM_INT);
            $stmt->execute();
            
            // Khởi tạo mảng 12 tháng với giá trị 0
            $monthlyRevenue = array_fill(1, 12, 0);
            
            // Cập nhật doanh thu cho các tháng có dữ liệu
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $monthlyRevenue[(int)$row['month']] = (float)$row['revenue'];
            }
            
            return array_values($monthlyRevenue); // Chuyển về mảng tuần tự
        } catch (PDOException $e) {
            error_log("Get monthly revenue error: " . $e->getMessage());
            return array_fill(0, 12, 0);
        }
    }

    public function getProductDistribution()
    {
        try {
            $sql = "SELECT c.cate_name as category, 
                    COUNT(p.pro_id) as product_count
                    FROM categories c
                    LEFT JOIN products p ON c.cate_id = p.cate_id
                    WHERE p.pro_status = 1
                    GROUP BY c.cate_id, c.cate_name
                    ORDER BY product_count DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $labels = [];
            $data = [];
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $labels[] = $row['category'];
                $data[] = (int)$row['product_count'];
            }
            
            return [
                'labels' => $labels,
                'data' => $data
            ];
        } catch (PDOException $e) {
            error_log("Get product distribution error: " . $e->getMessage());
            return [
                'labels' => [],
                'data' => []
            ];
        }
    }
}
?>
