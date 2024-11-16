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
            $sql = "INSERT INTO banners (title, image_url, status, created_at) VALUES (:title, :image_url, :status, :created_at)";
            $stmt = self::$conn->SUNNY->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':image_url', $image, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
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
            $sql = "UPDATE banners SET title = :title, image_url = :image_url, status = :status WHERE id = :id";
            $stmt = self::$conn->SUNNY->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi cập nhật banner: " . $e->getMessage());
        }
    }

}
?>