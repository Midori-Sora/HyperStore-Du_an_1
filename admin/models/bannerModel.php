<?php
class BannerModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getBannerList()
    {
        try {
            $sql = "SELECT * FROM banners ORDER BY id ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get banner list error: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy danh sách banner");
        }
    }

    public function getBannerById($id)
    {
        try {
            $sql = "SELECT * FROM banners WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get banner by id error: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy thông tin banner");
        }
    }

    public function addBanner($title, $image, $status, $created_at)
    {
        try {
            if (empty($title) || empty($image)) {
                throw new Exception("Tiêu đề và hình ảnh không được để trống");
            }

            $sql = "INSERT INTO banners (title, image_url, status, created_at, updated_at) 
                    VALUES (:title, :image_url, :status, :created_at, :created_at)";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':title' => $title,
                ':image_url' => $image,
                ':status' => $status,
                ':created_at' => $created_at
            ]);

            if (!$result) {
                throw new Exception("Không thể thêm banner");
            }
            return true;
        } catch (PDOException $e) {
            error_log("Add banner error: " . $e->getMessage());
            throw new Exception("Lỗi khi thêm banner");
        }
    }

    public function deleteBanner($id)
    {
        try {
            $sql = "DELETE FROM banners WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete banner error: " . $e->getMessage());
            throw new Exception("Lỗi khi xóa banner");
        }
    }

    public function updateBanner($id, $title, $image_url, $status)
    {
        try {
            $existingBanner = $this->getBannerById($id);
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

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':id' => $id,
                ':title' => $title,
                ':image_url' => $image_url,
                ':status' => $status
            ]);

            if (!$result) {
                error_log("Banner update failed for ID: $id - " . json_encode($stmt->errorInfo()));
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Update banner error: " . $e->getMessage());
            throw new Exception("Lỗi khi cập nhật banner");
        }
    }

    public function getActiveBanners()
    {
        try {
            $sql = "SELECT * FROM banners WHERE status = 1 ORDER BY id ASC";
            $stmt = $this->db->prepare($sql);  
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get active banners error: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy danh sách banner");
        }
    }
}
