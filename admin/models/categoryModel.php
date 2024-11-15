<?php
global $MainModel;

class CategoryModel
{
    public static function getAllCategories()
    {
        global $MainModel;

        try {
            $stmt = $MainModel->SUNNY->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return [];
        }
    }

    public static function addCategory($data)
    {
        global $MainModel;
        try {
            $stmt = $MainModel->SUNNY->prepare("INSERT INTO categories (cate_name, img, description, cate_status) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$data['cate_name'], $data['img'], $data['description'], $data['cate_status']]);
        } catch (PDOException $e) {
            echo "Add category failed: " . $e->getMessage();
            return false;
        }
    }


    public static function getCategoryById($id)
    {
        global $MainModel;
        try {
            $stmt = $MainModel->SUNNY->prepare("SELECT * FROM categories WHERE cate_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Get category by ID failed: " . $e->getMessage();
            return false;
        }
    }

    public static function updateCategory($data)
    {
        global $MainModel;


        $stmt = $MainModel->SUNNY->prepare("UPDATE categories SET cate_name = ?, img = ?, description = ?, cate_status = ? WHERE cate_id = ?");


        if (!$stmt->execute([
            $data['cate_name'],
            $data['img'],
            $data['description'],
            $data['cate_status'],
            $data['cate_id']
        ])) {

            print_r($stmt->errorInfo());
            return false;
        }

        return true;
    }





    public static function deleteCategory($id)
    {
        global $MainModel;
        try {
            $stmt = $MainModel->SUNNY->prepare("DELETE FROM categories WHERE cate_id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "Delete category failed: " . $e->getMessage();
            return false;
        }
    }
}
