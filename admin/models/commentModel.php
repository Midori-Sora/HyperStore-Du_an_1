<?php
class CommentModel extends MainModel {
    public function __construct() {
        parent::__construct();
    }

    public function getCommentList() {
            $sql = "SELECT 
                        c.com_id,
                        c.content,
                        DATE_FORMAT(c.import_date, '%d/%m/%Y %H:%i') as import_date,
                        c.pro_id,
                        p.pro_name,
                        u.user_id,
                        u.username
                    FROM comments c
                    LEFT JOIN products p ON c.pro_id = p.pro_id
                    LEFT JOIN users u ON c.user_id = u.user_id
                    ORDER BY c.import_date DESC";

            $stmt = $this->SUNNY->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateCommentStatus($id, $status) {
        try {
            $sql = "UPDATE comments 
                    SET status = :status,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE com_id = :id";

            $stmt = $this->SUNNY->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':status' => $status
            ]);

        } catch (PDOException $e) {
            error_log("UpdateCommentStatus Error: " . $e->getMessage());
            throw new Exception("Không thể cập nhật trạng thái bình luận");
        }
    }

    public function deleteComment($id) {
        try {
            $sql = "DELETE FROM comments WHERE com_id = :id";
            $stmt = $this->SUNNY->prepare($sql);
            return $stmt->execute([':id' => $id]);

        } catch (PDOException $e) {
            error_log("DeleteComment Error: " . $e->getMessage());
            throw new Exception("Không thể xóa bình luận");
        }
    }
}
