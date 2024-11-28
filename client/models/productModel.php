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
            $sql = "SELECT DISTINCT p.*, c.cate_name, pc.color_type, pc.color_price, 
                    ps.storage_type, ps.storage_price,
                    (p.price + COALESCE(pc.color_price, 0) + COALESCE(ps.storage_price, 0)) as final_price
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    WHERE p.pro_status = 1 
                    GROUP BY p.pro_name, p.storage_id, p.color_id
                    ORDER BY p.import_date DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $products = $result->fetch_all(MYSQLI_ASSOC);
            
            // Thêm thông tin giảm giá cho mỗi sản phẩm
            foreach ($products as &$product) {
                $currentDeal = $this->getCurrentDeal($product['pro_id']);
                $product['current_discount'] = $currentDeal ? $currentDeal['discount'] : 0;
                
                if ($product['current_discount'] > 0) {
                    $product['discounted_price'] = $product['final_price'] * (1 - $product['current_discount'] / 100);
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
            $sql = "SELECT p.*, c.cate_name, pc.color_type, ps.storage_type 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id 
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    WHERE p.pro_status = 1 AND p.cate_id = ? 
                    ORDER BY p.import_date DESC";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $cateId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);
            
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
        $sql = "SELECT * FROM categories WHERE cate_id = ? AND cate_status = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cateId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getProductById($id)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pc.color_type, pc.color_id, ps.storage_type, ps.storage_id 
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    WHERE p.pro_id = ? AND p.pro_status = 1";
                    
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                return null;
            }
            
            return $result->fetch_assoc();
            
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
            'Xanh Lưu Ly' => '#0066CC', // Màu xanh dương đậm
            'Xanh Mòng Két' => '#00A36C', // Màu xanh ngọc
            'Hồng' => '#FFC0CB',
            'Đỏ' => '#FF0000',
            'Tím' => '#800080',
            'Xanh Biển' => '#87CEEB', // Cập nhật màu xanh biển nhạt hơn (Sky Blue)
            'Xanh Lá' => '#90EE90', // Cập nhật màu xanh lá nhạt (Light Green)
            'Vàng' => '#FFFF00'
        ];
        
        return $colorMap[$colorName] ?? '#CCCCCC'; // Màu mặc định nếu không tìm thấy
    }

    public function getProductVariant($productId, $colorId = null, $storageId = null)
    {
        try {
            // Lấy ID mặc định nếu không có ID được truyền vào
            if ($colorId === null) {
                $colorId = $this->getDefaultColorId($productId);
            }
            if ($storageId === null) {
                $storageId = $this->getDefaultStorageId($productId);
            }

            $sql = "SELECT p.*, c.cate_name, 
                           pc.color_type, pc.color_id, COALESCE(pc.color_price, 0) as color_price,
                           ps.storage_type, ps.storage_id, COALESCE(ps.storage_price, 0) as storage_price,
                           (p.price + COALESCE(pc.color_price, 0) + COALESCE(ps.storage_price, 0)) as variant_price
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON pc.color_id = ?
                    LEFT JOIN product_storage ps ON ps.storage_id = ?
                    WHERE p.pro_id = ? AND p.pro_status = 1";

            $stmt = $this->conn->prepare($sql);
            
            // Tạo biến tạm để có thể truyền tham chiếu
            $colorIdParam = $colorId;
            $storageIdParam = $storageId;
            $productIdParam = $productId;
            
            $stmt->bind_param("iii", $colorIdParam, $storageIdParam, $productIdParam);
            $stmt->execute();
            $result = $stmt->get_result();
            $variant = $result->fetch_assoc();
            
            if (!$variant) {
                // Nếu không tìm thấy variant, lấy thông tin sản phẩm cơ bản
                $sql = "SELECT p.*, p.price as variant_price 
                       FROM products p 
                       WHERE p.pro_id = ? AND p.pro_status = 1";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $productIdParam);
                $stmt->execute();
                $variant = $stmt->get_result()->fetch_assoc();
            }
            
            return $variant;
        } catch (Exception $e) {
            error_log("Error in getProductVariant: " . $e->getMessage());
            return null;
        }
    }

    // Thêm các phương thức hỗ trợ
    private function getDefaultColorId($productId)
    {
        try {
            $sql = "SELECT color_id FROM products WHERE pro_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result ? $result['color_id'] : null;
        } catch (Exception $e) {
            error_log("Error in getDefaultColorId: " . $e->getMessage());
            return null;
        }
    }

    private function getDefaultStorageId($productId)
    {
        try {
            $sql = "SELECT storage_id FROM products WHERE pro_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result ? $result['storage_id'] : null;
        } catch (Exception $e) {
            error_log("Error in getDefaultStorageId: " . $e->getMessage());
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
    public static function productController()
    {
        $productModel = new ProductModel();
        $products = $productModel->getProductList();

        // Lấy mã giảm giá cho từng sản phẩm
        foreach ($products as &$product) {
            $currentDeal = $productModel->getCurrentDeal($product['pro_id']);
            $product['discount'] = $currentDeal ? $currentDeal['discount'] : 0;
        }

        require_once "client/views/product/product.php";
    }
    public function getCurrentDeal($productId)
    {
        try {
            $sql = "SELECT discount FROM product_deals WHERE pro_id = ? AND status = 1 ORDER BY start_date DESC LIMIT 1"; // Changed from :pro_id to ?
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $productId); // Bind the parameter
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc(); // Fetch the result
        } catch (mysqli_sql_exception $e) { // Changed to mysqli_sql_exception
            error_log("Get current deal error: " . $e->getMessage());
            return false;
        }
    }

    public function getProductImageByColor($productId, $colorId)
    {
        try {
            // Lấy thông tin sản phẩm và màu sắc
            $sql = "SELECT p.img, p.pro_name, pc.color_type 
                    FROM products p 
                    LEFT JOIN product_color pc ON pc.color_id = ? 
                    WHERE p.pro_id = ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $colorId, $productId);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            
            if (!$result) {
                return null;
            }

            // Lấy tên file ảnh gốc và phần mở rộng
            $originalImage = $result['img'];
            $pathInfo = pathinfo($originalImage);
            $filename = $pathInfo['filename'];
            $extension = $pathInfo['extension'];
            
            // Tạo tên file mới dựa trên màu sắc
            // Ví dụ: iphone-16.png -> iphone-16-den.png
            $colorSuffix = strtolower($this->convertColorToSuffix($result['color_type']));
            
            // Kiểm tra xem file có tồn tại không
            $newImageName = $filename . '-' . $colorSuffix . '.' . $extension;
            $imagePath = "Uploads/Product/" . $newImageName;
            
            // Nếu file tồn tại thì trả về tên file mới, ngược lại trả về file gốc
            return file_exists($imagePath) ? $newImageName : $originalImage;
            
        } catch (Exception $e) {
            error_log("Error in getProductImageByColor: " . $e->getMessage());
            return null;
        }
    }

    private function convertColorToSuffix($colorType)
    {
        $colorMap = [
            'Đen' => 'den',
            'Trắng' => 'trang',
            'Vàng' => 'vang',
            'Xanh lá' => 'xanhla',
            'Xanh dương' => 'xanhduong',
            'Tím' => 'tim',
            'Hồng' => 'hong',
            'Đỏ' => 'do'
            // Thêm các màu khác nếu cần
        ];
        
        return isset($colorMap[$colorType]) ? $colorMap[$colorType] : 'default';
    }

    public function getTotalProducts()
    {
        try {
            $sql = "SELECT COUNT(DISTINCT p.pro_id) as total 
                    FROM products p 
                    WHERE p.pro_status = 1";
            $result = $this->conn->query($sql);
            $row = $result->fetch_assoc();
            return $row['total'];
        } catch (Exception $e) {
            error_log("Error in getTotalProducts: " . $e->getMessage());
            return 0;
        }
    }

    public function getProductListPaginated($page, $itemsPerPage)
    {
        try {
            $offset = ($page - 1) * $itemsPerPage;
            
            $sql = "SELECT DISTINCT p.*, c.cate_name, pc.color_type, pc.color_price, 
                    ps.storage_type, ps.storage_price,
                    (p.price + COALESCE(pc.color_price, 0) + COALESCE(ps.storage_price, 0)) as final_price
                    FROM products p 
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    WHERE p.pro_status = 1 
                    GROUP BY p.pro_name, p.storage_id, p.color_id
                    ORDER BY p.import_date DESC
                    LIMIT ? OFFSET ?";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $itemsPerPage, $offset);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $products = $result->fetch_all(MYSQLI_ASSOC);
            
            // Thêm thông tin giảm giá cho mỗi sản phẩm
            foreach ($products as &$product) {
                $currentDeal = $this->getCurrentDeal($product['pro_id']);
                $product['current_discount'] = $currentDeal ? $currentDeal['discount'] : 0;
                
                if ($product['current_discount'] > 0) {
                    $product['discounted_price'] = $product['final_price'] * (1 - $product['current_discount'] / 100);
                }
            }
            
            return $products;
            
        } catch (Exception $e) {
            error_log("Error in getProductListPaginated: " . $e->getMessage());
            return [];
        }
    }
}
