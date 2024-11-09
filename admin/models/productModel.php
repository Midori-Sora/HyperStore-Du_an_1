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
        $sql = "SELECT products.*,categories.cate_name
                FROM products
                INNER JOIN categories
                ON products.cate_id = categories.cate_id";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getProductById($id)
    {
        $sql = "SELECT products.*, categories.cate_name 
                FROM products 
                INNER JOIN categories ON products.cate_id = categories.cate_id 
                WHERE pro_id = ?";
        $stmt = $this->SUNNY->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editProduct($id, $name, $img, $price, $description, $status, $cate_id)
    {
        try {
            $sql = "UPDATE products 
                    SET pro_name = ?, 
                        img = ?, 
                        price = ?, 
                        description = ?, 
                        pro_status = ?, 
                        cate_id = ? 
                    WHERE pro_id = ?";
            $stmt = $this->SUNNY->prepare($sql);
            $description = empty($description) ? null : $description;
            return $stmt->execute([$name, $img, $price, $description, $status, $cate_id, $id]);
        } catch (PDOException $e) {
            error_log("Edit product error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id)
    {
        try {
            $sql = "DELETE FROM products WHERE pro_id = :id";
            $stmt = $this->SUNNY->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }

    public function addProduct($name, $img, $price, $description, $status, $cate_id)
    {
        try {
            $sql = "INSERT INTO products (pro_name, img, price, description, pro_status, cate_id, import_date) 
                    VALUES (:name, :img, :price, :description, :status, :cate_id, NOW())";
            $stmt = $this->SUNNY->prepare($sql);
            
            $description = empty($description) ? null : $description;
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':img', $img);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':cate_id', $cate_id);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Add product error: " . $e->getMessage());
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