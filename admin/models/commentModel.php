<?php
class CommentModel
{
    private $db;

    public function __construct()
    {
        global $MainModel;
        $this->db = $MainModel->SUNNY;
    }

    public function getCommentList() {
        try {
            $sql = "SELECT 
                    c.com_id,
                    c.content,
                    c.rating,
                    c.cmt_status,
                    DATE_FORMAT(c.import_date, '%d/%m/%Y %H:%i') as import_date,
                    c.pro_id,
                    p.pro_name,
                    u.user_id,
                    u.username
                FROM comments c
                LEFT JOIN products p ON c.pro_id = p.pro_id
                LEFT JOIN users u ON c.user_id = u.user_id
                ORDER BY c.import_date DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("GetCommentList Error: " . $e->getMessage());
            throw new Exception("Không thể lấy danh sách bình luận");
        }
    }

    public function updateCommentStatus($id, $status) {
        try {
            $checkSql = "SELECT com_id FROM comments WHERE com_id = :id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':id' => $id]);
            
            if (!$checkStmt->fetch()) {
                throw new Exception("Bình luận không tồn tại");
            }

            $sql = "UPDATE comments 
                    SET cmt_status = :status
                    WHERE com_id = :id";

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':id' => $id,
                ':status' => $status
            ]);

            if (!$result) {
                throw new Exception("Cập nhật thất bại");
            }

            $this->logCommentAction($id, "update_status_to_$status");
            return true;

        } catch (PDOException $e) {
            error_log("UpdateCommentStatus Error: " . $e->getMessage());
            throw new Exception("Không thể cập nhật trạng thái bình luận");
        }
    }

    private function logCommentAction($commentId, $action) {
        try {
            $sql = "INSERT INTO comment_logs (comment_id, action, admin_id, created_at) 
                    VALUES (:comment_id, :action, :admin_id, CURRENT_TIMESTAMP)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':comment_id' => $commentId,
                ':action' => $action,
                ':admin_id' => $_SESSION['admin_id'] ?? null
            ]);
        } catch (PDOException $e) {
            error_log("Log Comment Action Error: " . $e->getMessage());
        }
    }

    public function deleteComment($id) {
        try {
            $this->logCommentAction($id, "delete");
            
            $sql = "DELETE FROM comments WHERE com_id = :id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([':id' => $id]);
            
            if (!$result) {
                throw new Exception("Xóa bình luận thất bại");
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("DeleteComment Error: " . $e->getMessage());
            throw new Exception("Không thể xóa bình luận");
        }
    }
}
