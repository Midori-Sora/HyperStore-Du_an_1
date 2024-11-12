<?php
class ProductModel extends MainModel
{
    public function __construct()
    {
        try {
            parent::__construct();
            error_log("Database connection established");
        } catch (Exception $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function getProductList()
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pr.ram_type, pr.ram_price, pc.color_type, pc.color_price,
                    (p.price + COALESCE(pr.ram_price, 0) + COALESCE(pc.color_price, 0)) as total_price
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_ram pr ON p.ram_id = pr.ram_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    ORDER BY p.pro_id DESC";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get product list error: " . $e->getMessage());
            return false;
        }
    }

    public function getProductById($id)
    {
        try {
            $sql = "SELECT p.*, c.cate_name, pr.ram_type, pr.ram_price, pc.color_type, pc.color_price
                    FROM products p
                    LEFT JOIN categories c ON p.cate_id = c.cate_id
                    LEFT JOIN product_ram pr ON p.ram_id = pr.ram_id
                    LEFT JOIN product_color pc ON p.color_id = pc.color_id
                    WHERE p.pro_id = :id";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get product by id error: " . $e->getMessage());
            return false;
        }
    }

    public function editProduct($id, $name, $img, $price, $description, $status, $cate_id, $ram_id, $color_id)
    {
        try {
            $sql = "UPDATE products 
                    SET pro_name = :name,
                        img = :img,
                        price = :price,
                        description = :description,
                        pro_status = :status,
                        cate_id = :cate_id,
                        ram_id = :ram_id,
                        color_id = :color_id
                    WHERE pro_id = :id";
            $stmt = $this->SUNNY->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':img' => $img,
                ':price' => $price,
                ':description' => $description,
                ':status' => $status,
                ':cate_id' => $cate_id,
                ':ram_id' => $ram_id,
                ':color_id' => $color_id,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            error_log("Edit product error: " . $e->getMessage());
            return false;
        }
    }

    public function addProduct($name, $img, $price, $description, $status, $cate_id, $ram_id, $color_id)
    {
        try {
            $sql = "INSERT INTO products (pro_name, img, price, description, pro_status, cate_id, ram_id, color_id, import_date) 
                    VALUES (:name, :img, :price, :description, :status, :cate_id, :ram_id, :color_id, NOW())";
            $stmt = $this->SUNNY->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':img' => $img,
                ':price' => $price,
                ':description' => $description,
                ':status' => $status,
                ':cate_id' => $cate_id,
                ':ram_id' => $ram_id,
                ':color_id' => $color_id
            ]);
        } catch (PDOException $e) {
            error_log("Add product error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id)
    {
        try {
            $this->SUNNY->beginTransaction();
            
            // Xóa sản phẩm (các bảng liên quan sẽ tự động xóa do ON DELETE CASCADE)
            $sql = "DELETE FROM products WHERE pro_id = :id";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            if ($result) {
                $this->SUNNY->commit();
                return true;
            } else {
                $this->SUNNY->rollBack();
                return false;
            }
        } catch (PDOException $e) {
            $this->SUNNY->rollBack();
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }

    public function getCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRamOptions()
    {
        try {
            $sql = "SELECT * FROM product_ram ORDER BY ram_price";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get RAM options error: " . $e->getMessage());
            return [];
        }
    }

    public function getColorOptions()
    {
        try {
            $sql = "SELECT * FROM product_color ORDER BY color_price";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get color options error: " . $e->getMessage());
            return [];
        }
    }
}
?>