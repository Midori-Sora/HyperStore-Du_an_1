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
        $sql = "SELECT p.*, c.cate_name,
                GROUP_CONCAT(DISTINCT CONCAT(pr.ram_type, ' (+', 
                    CASE pr.ram_type 
                        WHEN '128GB' THEN '0'
                        WHEN '256GB' THEN '200.000'
                        WHEN '512GB' THEN '500.000'
                    END, 'đ)') SEPARATOR ', ') as ram_options,
                GROUP_CONCAT(DISTINCT CONCAT(pc.color_type, ' (+', 
                    CASE pc.color_type 
                        WHEN 'Vàng' THEN '500.000'
                        ELSE '0'
                    END, 'đ)') SEPARATOR ', ') as color_options
                FROM products p
                LEFT JOIN categories c ON p.cate_id = c.cate_id
                LEFT JOIN product_ram pr ON p.pro_id = pr.pro_id
                LEFT JOIN product_color pc ON p.pro_id = pc.pro_id
                GROUP BY p.pro_id";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.cate_name,
                GROUP_CONCAT(DISTINCT pr.ram_type) as ram_options,
                GROUP_CONCAT(DISTINCT pc.color_type) as color_options
                FROM products p
                LEFT JOIN categories c ON p.cate_id = c.cate_id
                LEFT JOIN product_ram pr ON p.pro_id = pr.pro_id
                LEFT JOIN product_color pc ON p.pro_id = pc.pro_id
                WHERE p.pro_id = ?
                GROUP BY p.pro_id";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editProduct($id, $name, $img, $price, $description, $status, $cate_id, $ram_data, $color_data)
    {
        try {
            $this->SUNNY->beginTransaction();

            // Cập nhật thông tin sản phẩm cơ bản
            $sql = "UPDATE products 
                    SET pro_name = :name, img = :img, price = :price, 
                        description = :description, pro_status = :status, 
                        cate_id = :cate_id
                    WHERE pro_id = :id";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':img' => $img,
                ':price' => $price,
                ':description' => $description,
                ':status' => $status,
                ':cate_id' => $cate_id,
                ':id' => $id
            ]);

            // Xóa RAM options cũ
            $sql = "DELETE FROM product_ram WHERE pro_id = :pro_id";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([':pro_id' => $id]);

            // Thêm RAM options mới
            foreach ($ram_data['types'] as $type) {
                if (!empty($type)) {
                    $sql = "INSERT INTO product_ram (pro_id, ram_type) 
                            VALUES (:pro_id, :type)";
                    $stmt = $this->SUNNY->prepare($sql);
                    $stmt->execute([
                        ':pro_id' => $id,
                        ':type' => $type
                    ]);
                }
            }

            // Xóa Color options cũ
            $sql = "DELETE FROM product_color WHERE pro_id = :pro_id";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([':pro_id' => $id]);

            // Thêm Color options mới
            foreach ($color_data['types'] as $type) {
                if (!empty($type)) {
                    $sql = "INSERT INTO product_color (pro_id, color_type) 
                            VALUES (:pro_id, :type)";
                    $stmt = $this->SUNNY->prepare($sql);
                    $stmt->execute([
                        ':pro_id' => $id,
                        ':type' => $type
                    ]);
                }
            }

            $this->SUNNY->commit();
            return true;
        } catch (PDOException $e) {
            $this->SUNNY->rollBack();
            error_log("Edit product error: " . $e->getMessage());
            return false;
        }
    }

    public function addProduct($name, $img, $price, $description, $status, $cate_id, $ram_data, $color_data)
    {
        try {
            $this->SUNNY->beginTransaction();

            // Thêm sản phẩm cơ bản
            $sql = "INSERT INTO products (pro_name, img, price, description, pro_status, cate_id, import_date) 
                    VALUES (:name, :img, :price, :description, :status, :cate_id, NOW())";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':img' => $img,
                ':price' => $price,
                ':description' => $description,
                ':status' => $status,
                ':cate_id' => $cate_id
            ]);
            
            $pro_id = $this->SUNNY->lastInsertId();

            // Thêm RAM options
            foreach ($ram_data['types'] as $type) {
                if (!empty($type)) {
                    $sql = "INSERT INTO product_ram (pro_id, ram_type) 
                            VALUES (:pro_id, :type)";
                    $stmt = $this->SUNNY->prepare($sql);
                    $stmt->execute([
                        ':pro_id' => $pro_id,
                        ':type' => $type
                    ]);
                }
            }

            // Thêm Color options
            foreach ($color_data['types'] as $type) {
                if (!empty($type)) {
                    $sql = "INSERT INTO product_color (pro_id, color_type) 
                            VALUES (:pro_id, :type)";
                    $stmt = $this->SUNNY->prepare($sql);
                    $stmt->execute([
                        ':pro_id' => $pro_id,
                        ':type' => $type
                    ]);
                }
            }

            $this->SUNNY->commit();
            return true;
        } catch (PDOException $e) {
            $this->SUNNY->rollBack();
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
}
?>