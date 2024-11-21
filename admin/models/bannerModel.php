<?php
class BannerModel {
    private static $conn;

    public static function init() {
        if (!self::$conn) {
            self::$conn = new MainModel();
        }
    }

    public static function getBannerList() {
        self::init();
        try {
            $sql = "SELECT * FROM banners ORDER BY id DESC";
            $stmt = self::$conn->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi lấy danh sách banner: " . $e->getMessage());
        }
    }

    public static function getBannerById($id) {
        self::init();
        try {
            $sql = "SELECT * FROM banners WHERE id = :id";
            $stmt = self::$conn->SUNNY->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi lấy thông tin banner: " . $e->getMessage());
        }
    }

    public static function addBanner($title, $image, $status, $created_at) {
        self::init();
        try {
            // Validate inputs
            if (empty($title) || empty($image)) {
                throw new Exception("Tiêu đề và hình ảnh không được để trống");
            }

            if (strlen($title) < 3 || strlen($title) > 255) {
                throw new Exception("Tiêu đề phải từ 3 đến 255 ký tự");
            }

            if (!in_array($status, [0, 1])) {
                throw new Exception("Trạng thái không hợp lệ");
            }

            $sql = "INSERT INTO banners (title, image_url, status, created_at, updated_at) 
                    VALUES (:title, :image_url, :status, :created_at, :created_at)";
            
            $stmt = self::$conn->SUNNY->prepare($sql);
            $params = [
                ':title' => $title,
                ':image_url' => $image,
                ':status' => $status,
                ':created_at' => $created_at
            ];
            
            $result = $stmt->execute($params);
            
            if (!$result) {
                error_log("Banner insertion failed: " . json_encode($stmt->errorInfo()));
                throw new Exception("Không thể thêm banner");
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Error adding banner: " . $e->getMessage());
            throw new Exception("Lỗi khi thêm banner: " . $e->getMessage());
        }
    }

    public static function deleteBanner($id) {
        self::init();
        try {
            $sql = "DELETE FROM banners WHERE id = :id";
            $stmt = self::$conn->SUNNY->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi xóa banner: " . $e->getMessage());
        }
    }

    public static function updateBanner($id, $title, $image_url, $status) {
        self::init();
        try {
            // Validate banner exists before update
            $existingBanner = self::getBannerById($id);
            if (!$existingBanner) {
                error_log("Banner not found for ID: $id");
                return false;
            }

            $sql = "UPDATE banners 
                    SET title = :title, 
                        image_url = :image_url, 
                        status = :status, 
                        created_at = NOW() 
                    WHERE id = :id";
            
            $stmt = self::$conn->SUNNY->prepare($sql);
            $params = [
                ':id' => $id,
                ':title' => $title,
                ':image_url' => $image_url,
                ':status' => $status
            ];
            
            $result = $stmt->execute($params);
            
            if (!$result) {
                error_log("Banner update failed for ID: $id - " . json_encode($stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error updating banner: " . $e->getMessage());
            throw new Exception("Lỗi khi cập nhật banner: " . $e->getMessage());
        }
    }

}
?>