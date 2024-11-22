<?php
global $MainModel;

class CategoryModel
{
    public static function getAllCategories()
    {
        global $MainModel;
        try {
            $stmt = $MainModel->SUNNY->prepare("
                SELECT DISTINCT * FROM categories 
                ORDER BY cate_name ASC
            ");
            $stmt->execute();
            
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $uniqueCategories = array_unique($categories, SORT_REGULAR);
            
            return $uniqueCategories;
        } catch (PDOException $e) {
            error_log("Query failed: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy danh sách danh mục");
        }
    }

    public static function addCategory($data)
    {
        global $MainModel;
        try {
            // Chuẩn hóa đường dẫn ảnh
            if (!empty($data['img'])) {
                $data['img'] = str_replace('\\', '/', $data['img']);
                // Đảm bảo đường dẫn không có ../
                $data['img'] = str_replace('../', '', $data['img']);
            }
            
            $stmt = $MainModel->SUNNY->prepare("
                INSERT INTO categories (cate_name, img, description, cate_status) 
                VALUES (:name, :img, :description, :status)
            ");
            
            return $stmt->execute([
                ':name' => $data['cate_name'],
                ':img' => $data['img'],
                ':description' => $data['description'],
                ':status' => $data['cate_status']
            ]);
        } catch (PDOException $e) {
            error_log("Add category failed: " . $e->getMessage());
            throw new Exception("Lỗi khi thêm danh mục");
        }
    }


    public static function getCategoryById($id)
    {
        global $MainModel;
        try {
            $stmt = $MainModel->SUNNY->prepare("SELECT * FROM categories WHERE cate_id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                throw new Exception("Không tìm thấy danh mục");
            }
            
            // Chuẩn hóa đường dẫn ảnh
            if (!empty($result['img'])) {
                // Đảm bảo đường dẫn bắt đầu từ Uploads/Category/
                if (strpos($result['img'], 'Uploads/Category/') !== 0) {
                    $result['img'] = 'Uploads/Category/' . basename($result['img']);
                }
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Get category by ID failed: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy thông tin danh mục");
        }
    }

    public static function updateCategory($data)
    {
        global $MainModel;
        try {
            if (empty($data['cate_name']) || !isset($data['cate_status'])) {
                throw new Exception('Thiếu thông tin bắt buộc');
            }

            // Chuẩn hóa đường dẫn ảnh
            if (!empty($data['img'])) {
                $data['img'] = str_replace('\\', '/', $data['img']);
                // Đảm bảo đường dẫn không có ../
                $data['img'] = str_replace('../', '', $data['img']);
                // Đảm bảo đường dẫn bắt đầu bằng Uploads/Category/
                if (strpos($data['img'], 'Uploads/Category/') !== 0) {
                    $data['img'] = 'Uploads/Category/' . basename($data['img']);
                }
            }

            $MainModel->SUNNY->beginTransaction();

            $stmt = $MainModel->SUNNY->prepare("
                UPDATE categories 
                SET cate_name = :name,
                    img = :img,
                    description = :description,
                    cate_status = :status
                WHERE cate_id = :id
            ");

            $result = $stmt->execute([
                ':name' => $data['cate_name'],
                ':img' => $data['img'],
                ':description' => $data['description'],
                ':status' => $data['cate_status'],
                ':id' => $data['cate_id']
            ]);

            if ($result) {
                $MainModel->SUNNY->commit();
                return true;
            }

            $MainModel->SUNNY->rollBack();
            return false;

        } catch (Exception $e) {
            if ($MainModel->SUNNY->inTransaction()) {
                $MainModel->SUNNY->rollBack();
            }
            error_log("Update category failed: " . $e->getMessage());
            throw $e;
        }
    }





    public static function deleteCategory($id)
    {
        global $MainModel;
        try {
            // Kiểm tra xem danh mục có sản phẩm không
            $checkStmt = $MainModel->SUNNY->prepare("
                SELECT COUNT(*) FROM products WHERE cate_id = ?
            ");
            $checkStmt->execute([$id]);
            $productCount = $checkStmt->fetchColumn();

            if ($productCount > 0) {
                return false; // Có sản phẩm, không thể xóa
            }

            // Bắt đầu transaction
            $MainModel->SUNNY->beginTransaction();

            // Xóa category
            $stmt = $MainModel->SUNNY->prepare("DELETE FROM categories WHERE cate_id = ?");
            $result = $stmt->execute([$id]);

            if ($result) {
                $MainModel->SUNNY->commit();
                return true;
            }

            $MainModel->SUNNY->rollBack();
            return false;

        } catch (PDOException $e) {
            if ($MainModel->SUNNY->inTransaction()) {
                $MainModel->SUNNY->rollBack();
            }
            error_log("Delete category failed: " . $e->getMessage());
            throw new Exception("Lỗi khi xóa danh mục");
        }
    }
}