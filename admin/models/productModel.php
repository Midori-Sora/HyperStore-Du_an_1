<?php
class ProductModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getProductList()
    {
        try {
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, pc.color_type, pc.color_price,
                    (p.price + COALESCE(ps.storage_price, 0) + COALESCE(pc.color_price, 0)) as total_price,
                    pd.discount
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    ORDER BY p.pro_name ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Products fetched: " . count($result));
            return $result;
        } catch (PDOException $e) {
            error_log("Get product list error: " . $e->getMessage());
            throw new Exception("Không thể lấy danh sách sản phẩm");
        }
    }

    public function getProductById($id)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, pc.color_type, pc.color_price,
                    (p.price + COALESCE(ps.storage_price, 0) + COALESCE(pc.color_price, 0)) as total_price,
                    pd.discount,
                    (p.price * (1 - COALESCE(pd.discount, 0) / 100)) as discounted_price
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    WHERE p.pro_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            error_log("Product detail fetched for ID $id: " . ($result ? 'success' : 'not found'));
            return $result;
        } catch (PDOException $e) {
            error_log("Get product by id error: " . $e->getMessage());
            return false;
        }
    }

    public function editProduct($id, $name, $img, $price, $description, $status, $cate_id, $storage_id, $color_id, $quantity)
    {
        try {
            $sql = "UPDATE products 
                    SET pro_name = :name,
                        img = :img,
                        price = :price,
                        description = :description,
                        pro_status = :status,
                        cate_id = :cate_id,
                        storage_id = :storage_id,
                        color_id = :color_id,
                        quantity = :quantity
                    WHERE pro_id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':img' => $img,
                ':price' => $price,
                ':description' => $description,
                ':status' => $status,
                ':cate_id' => $cate_id,
                ':storage_id' => $storage_id,
                ':color_id' => $color_id,
                ':quantity' => $quantity,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Edit product error: " . $e->getMessage());
            return false;
        }
    }

    public function addProduct($name, $img, $price, $description, $status, $cate_id, $storage_id, $color_id, $quantity)
    {
        try {
            $sql = "INSERT INTO products (pro_name, img, price, description, pro_status, cate_id, storage_id, color_id, quantity, import_date) 
                    VALUES (:name, :img, :price, :description, :status, :cate_id, :storage_id, :color_id, :quantity, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':img' => $img,
                ':price' => $price,
                ':description' => $description,
                ':status' => $status,
                ':cate_id' => $cate_id,
                ':storage_id' => $storage_id,
                ':color_id' => $color_id,
                ':quantity' => $quantity
            ]);
        } catch (PDOException $e) {
            error_log("Add product error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id)
    {
        try {
            $this->db->beginTransaction();

            $sql = "DELETE FROM products WHERE pro_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            if ($result) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }

    public function getCategories()
    {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get categories error: " . $e->getMessage());
            throw new Exception("Không thể lấy danh sách danh mục");
        }
    }

    public function getStorageOptions()
    {
        try {
            $sql = "SELECT * FROM product_storage ORDER BY storage_price ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get storage options error: " . $e->getMessage());
            return [];
        }
    }

    public function getColorOptions()
    {
        try {
            $sql = "SELECT * FROM product_color ORDER BY color_price";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get color options error: " . $e->getMessage());
            return [];
        }
    }

    public function addStorage($storage_type, $storage_price) 
    {
        try {
            $sql = "INSERT INTO product_storage (storage_type, storage_price) VALUES (:type, :price)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':type' => $storage_type,
                ':price' => $storage_price
            ]);
        } catch (PDOException $e) {
            error_log("Add storage error: " . $e->getMessage());
            return false;
        }
    }

    public function editStorage($storage_id, $storage_type, $storage_price)
    {
        try {
            $sql = "UPDATE product_storage SET storage_type = :type, storage_price = :price WHERE storage_id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':type' => $storage_type,
                ':price' => $storage_price,
                ':id' => $storage_id
            ]);
        } catch (PDOException $e) {
            error_log("Edit storage error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteStorage($storage_id)
    {
        try {
            $sql = "DELETE FROM product_storage WHERE storage_id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $storage_id]);
        } catch (PDOException $e) {
            error_log("Delete storage error: " . $e->getMessage());
            return false;
        }
    }

    public function addColor($color_type, $color_price)
    {
        try {
            $sql = "INSERT INTO product_color (color_type, color_price) VALUES (:type, :price)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':type' => $color_type,
                ':price' => $color_price
            ]);
        } catch (PDOException $e) {
            error_log("Add color error: " . $e->getMessage());
            return false;
        }
    }

    public function editColor($color_id, $color_type, $color_price)
    {
        try {
            $sql = "UPDATE product_color 
                    SET color_type = :type, 
                        color_price = :price 
                    WHERE color_id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':type' => $color_type,
                ':price' => $color_price,
                ':id' => $color_id
            ]);
        } catch (PDOException $e) {
            error_log("Edit color error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteColor($color_id)
    {
        try {
            $sql = "DELETE FROM product_color WHERE color_id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $color_id]);
        } catch (PDOException $e) {
            error_log("Delete color error: " . $e->getMessage());
            return false;
        }
    }

    public function updateQuantity($pro_id, $quantity)
    {
        try {
            $sql = "UPDATE products SET quantity = :quantity WHERE pro_id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':quantity' => $quantity,
                ':id' => $pro_id
            ]);
        } catch (PDOException $e) {
            error_log("Update quantity error: " . $e->getMessage());
            return false;
        }
    }

    public function getProductDetail($id)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pr.ram_type, pr.ram_price, pc.color_type, pc.color_price,
                    (p.price + COALESCE(pr.ram_price, 0) + COALESCE(pc.color_price, 0)) as total_price,
                    pd.discount
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_ram pr ON p.ram_id = pr.ram_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    WHERE p.pro_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get product detail error: " . $e->getMessage());
            return false;
        }
    }

    public function getCurrentDeal($productId)
    {
        try {
            $sql = "SELECT discount FROM product_deals WHERE pro_id = :pro_id AND status = 1 ORDER BY start_date DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':pro_id' => $productId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get current deal error: " . $e->getMessage());
            return false;
        }
    }

    public function searchProducts($searchTerm)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, ps.storage_type, ps.storage_price, pc.color_type, pc.color_price,
                    (p.price + COALESCE(ps.storage_price, 0) + COALESCE(pc.color_price, 0)) as total_price,
                    pd.discount
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_storage ps ON p.storage_id = ps.storage_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    LEFT JOIN product_deals pd ON p.pro_id = pd.pro_id AND pd.status = 1
                    WHERE p.pro_name LIKE :search
                    ORDER BY p.pro_name ASC";
            
            $stmt = $this->db->prepare($sql);
            $searchTerm = "%{$searchTerm}%";
            $stmt->execute([':search' => $searchTerm]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search products error: " . $e->getMessage());
            throw new Exception("Không thể tìm kiếm sản phẩm");
        }
    }

    public function checkStorageExists($storageType)
    {
        try {
            $sql = "SELECT COUNT(*) FROM product_storage WHERE storage_type = :storage_type";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':storage_type' => $storageType]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Check storage exists error: " . $e->getMessage());
            return false;
        }
    }

    public function checkColorExists($colorType)
    {
        try {
            $sql = "SELECT COUNT(*) FROM product_color WHERE color_type = :color_type";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':color_type' => $colorType]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Check color exists error: " . $e->getMessage());
            return false;
        }
    }

    public function checkProductWithVariantsExists($name, $storage_id, $color_id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM products WHERE pro_name = :pro_name AND storage_id = :storage_id AND color_id = :color_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':pro_name' => $name,
                ':storage_id' => $storage_id,
                ':color_id' => $color_id
            ]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Check product with variants exists error: " . $e->getMessage());
            return false;
        }
    }
}