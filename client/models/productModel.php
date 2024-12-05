<?php
class ProductModel  
{
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function getProductList()
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pc.color_type, ps.storage_type,
                    pd.discount, pd.start_date, pd.end_date 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
                        AND pd.status = 1 
                        AND CURRENT_DATE BETWEEN pd.start_date AND pd.end_date
                    WHERE p.pro_status = 1 
                    ORDER BY p.import_date DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);
            
            // Tính giá sau giảm giá cho mỗi sản phẩm
            foreach ($products as &$product) {
                $total_price = $product['price'] + 
                            floatval($product['color_price'] ?? 0) + 
                            floatval($product['storage_price'] ?? 0);
                $product['original_price'] = $total_price;
                if (!empty($product['discount'])) {
                    $product['discount_price'] = $total_price * (100 - $product['discount']) / 100;
                }
            }
            
            return $products;
            
        } catch (Exception $e) {
            error_log("Error in getProductList: " . $e->getMessage());
            return [];
        }
    }

    public function getProductsByCategory($cateId) 
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pc.color_type, ps.storage_type,
                    pd.discount, pd.start_date, pd.end_date 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id 
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
                        AND pd.status = 1 
                        AND CURRENT_DATE BETWEEN pd.start_date AND pd.end_date
                    WHERE p.pro_status = 1 AND p.cate_id = ? 
                    ORDER BY p.import_date DESC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $cateId);
            $stmt->execute();
            $result = $stmt->get_result();
            $products = $result->fetch_all(MYSQLI_ASSOC);
            
            // Tính giá sau giảm giá cho mỗi sản phẩm
            foreach ($products as &$product) {
                $total_price = $product['price'] + 
                            floatval($product['color_price'] ?? 0) + 
                            floatval($product['storage_price'] ?? 0);
                $product['original_price'] = $total_price;
                if (!empty($product['discount'])) {
                    $product['discount_price'] = $total_price * (100 - $product['discount']) / 100;
                }
            }
            
            return $products;
            
        } catch (Exception $e) {
            error_log("Error in getProductsByCategory: " . $e->getMessage());
            return [];
        }
    }
    // Lấy danh sách danh mục
    public function getCategories() {
        $sql = "SELECT * FROM categories WHERE cate_status = 1 ORDER BY cate_name ASC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy thông tin danh mục theo ID
    public function getCategoryById($cateId) {
        try {
            $sql = "SELECT * FROM categories WHERE cate_id = ? AND cate_status = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $cateId);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log("Error in getCategoryById: " . $e->getMessage());
            return null;
        }
    }

    public function getProductById($id)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, 
                    pc.color_type, pc.color_id, pc.color_price,
                    ps.storage_type, ps.storage_id, ps.storage_price,
                    pd.discount, pd.start_date, pd.end_date 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
                        AND pd.status = 1 
                        AND CURRENT_DATE BETWEEN pd.start_date AND pd.end_date
                    WHERE p.pro_id = ? AND p.pro_status = 1";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return null;
            }
            
            $product = $result->fetch_assoc();
            
            $total_price = $product['price'] + 
                        floatval($product['color_price'] ?? 0) + 
                        floatval($product['storage_price'] ?? 0);
            $product['original_price'] = $total_price;
            if (!empty($product['discount'])) {
                $product['discount_price'] = $total_price * (100 - $product['discount']) / 100;
            }
            
            return $product;
            
        } catch (Exception $e) {
            error_log("Error in getProductById: " . $e->getMessage());
            return null;
        }
    }

    public function getProductImages($productId)
    {
        try {
            $sql = "SELECT * FROM thumbnails WHERE pro_id = ? AND thumb_status = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getProductImages: " . $e->getMessage());
            return [];
        }
    }

    public function getRelatedProducts($cateId, $currentProductId, $limit = 4)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pc.color_type, ps.storage_type 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    WHERE p.cate_id = ? 
                    AND p.pro_id != ? 
                    AND p.pro_status = 1 
                    ORDER BY RAND() 
                    LIMIT ?";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $cateId, $currentProductId, $limit);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            
        } catch (Exception $e) {
            error_log("Error in getRelatedProducts: " . $e->getMessage());
            return [];
        }
    }

    public function getAllColorsByCategory($cateId)
    {
        try {
            $sql = "SELECT DISTINCT pc.* 
                    FROM product_color pc 
                    JOIN products p ON pc.color_id = p.color_id 
                    WHERE p.cate_id = ? AND p.pro_status = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $cateId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getAllColorsByCategory: " . $e->getMessage());
            return [];
        }
    }

    public function getAllStoragesByCategory($cateId)
    {
        try {
            $sql = "SELECT DISTINCT ps.* 
                    FROM product_storage ps 
                    JOIN products p ON ps.storage_id = p.storage_id 
                    WHERE p.cate_id = ? AND p.pro_status = 1
                    ORDER BY CAST(REGEXP_REPLACE(storage_type, '[^0-9]', '') AS UNSIGNED)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $cateId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log("Error in getAllStoragesByCategory: " . $e->getMessage());
            return [];
        }
    }

    public function getColorCode($colorName) {
        // Mapping màu tiếng Việt sang mã màu dựa theo database
        $colorMap = [
            'Đen' => '#000000',
            'Trắng' => '#FFFFFF',
            'Vàng Kim' => '#FFD700',
            'Xanh Lưu Ly' => '#0066CC',
            'Xanh Mòng Két' => '#00A36C',
            'Hồng' => '#FFC0CB',
            'Đỏ' => '#FF0000',
            'Xanh Biển' => '#1E90FF',
            'Xanh Lá' => '#32CD32',
            'Vàng' => '#FFD700',
            'Tím' => '#800080'
        ];
        
        return $colorMap[$colorName] ?? '#CCCCCC'; // Màu mặc định nếu không tìm thấy
    }

    public function getProductVariant($productId, $colorId = null, $storageId = null)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, 
                    pc.color_type, pc.color_id, pc.color_price,
                    ps.storage_type, ps.storage_id, ps.storage_price,
                    pd.discount, pd.start_date, pd.end_date 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id 
                        AND pd.status = 1 
                        AND CURRENT_DATE BETWEEN pd.start_date AND pd.end_date
                    WHERE p.cate_id = (SELECT cate_id FROM products WHERE pro_id = ?)
                    AND p.pro_status = 1";

            $params = [$productId];
            $types = "i";

            if ($colorId !== null) {
                $sql .= " AND p.color_id = ?";
                $params[] = $colorId;
                $types .= "i";
            }

            if ($storageId !== null) {
                $sql .= " AND p.storage_id = ?";
                $params[] = $storageId;
                $types .= "i";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $product = $result->fetch_assoc();
            if ($product) {
                $total_price = $product['price'] + 
                            floatval($product['color_price']) + 
                            floatval($product['storage_price']);
                $product['original_price'] = $total_price;
                if (!empty($product['discount'])) {
                    $product['discount_price'] = $total_price * (100 - $product['discount']) / 100;
                }
            }
            return $product;
        } catch (Exception $e) {
            error_log("Error in getProductVariant: " . $e->getMessage());
            return null;
        }
    }

    public function checkVariantExists($productId, $colorId, $storageId) 
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM products 
                    WHERE cate_id = (SELECT cate_id FROM products WHERE pro_id = ?) 
                    AND color_id = ? AND storage_id = ? AND pro_status = 1";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $productId, $colorId, $storageId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log("Error in checkVariantExists: " . $e->getMessage());
            return false;
        }
    }
}
