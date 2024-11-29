<?php
if (!empty($comments)):
    foreach ($comments as $comment): 
        if ($comment['cmt_status'] == 1):
?>
    <div class="comment-item <?php echo $comment['cmt_status'] == 0 ? 'pending' : ''; ?>">
        <div class="user-info">
            <img class="user-avatar" 
                 src="<?php echo $comment['avatar'] ?? 'assets/images/default-avatar.jpg'; ?>" 
                 alt="Avatar">
            <div class="user-meta">
                <div class="username">
                    <?php echo htmlspecialchars($comment['username']); ?>
                    <?php if ($comment['cmt_status'] == 0): ?>
                        <span class="pending-status">Chờ duyệt</span>
                    <?php endif; ?>
                </div>
                <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star <?php echo $i <= $comment['rating'] ? 'active' : ''; ?>"></i>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="comment-time">
            <?php echo date('Y-m-d H:i', strtotime($comment['import_date'])); ?>
        </div>

        <div class="comment-content">
            <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
        </div>
    </div>
<?php 
        endif;
    endforeach;
else: 
?>
    <div class="no-comments">
        <i class="fas fa-comments"></i>
        <p>Chưa có đánh giá nào</p>
    </div>
<?php endif; ?> 

<style>
.comments-container {
    padding: 16px;
    background: #fff;
}

.comment-item {
    padding: 16px 0;
    border-bottom: 1px solid #efefef;
}

.user-info {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 12px;
}

.user-meta {
    flex: 1;
}

.username {
    font-size: 14px;
    font-weight: 500;
}

.rating {
    display: flex;
    gap: 2px;
}

.rating .fa-star {
    font-size: 14px;
    color: #ddd;
}

.rating .fa-star.active {
    color: #ee4d2d;
}

.comment-time {
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}

.comment-content {
    font-size: 14px;
    line-height: 1.5;
}

.comment-images {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.image-item {
    width: 72px;
    height: 72px;
}

.image-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 4px;
}

.comment-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.like-action {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border: none;
    background: none;
    color: #666;
    cursor: pointer;
}

.like-action:hover {
    color: #ee4d2d;
}

.comment-menu {
    padding: 6px;
    border: none;
    background: none;
    color: #666;
    cursor: pointer;
}

.no-comments {
    text-align: center;
    padding: 40px;
    color: #666;
}

.comment-item.pending {
    opacity: 0.7;
    background-color: #f9f9f9;
    border-left: 3px solid #ffd700;
}

.pending-status {
    display: inline-block;
    padding: 2px 8px;
    background-color: #ffd700;
    color: #333;
    border-radius: 12px;
    font-size: 12px;
    margin-left: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .comment-time {
        margin-left: 0;
    }

    .image-item {
        width: 60px;
        height: 60px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const commentsContainer = document.getElementById('comments-container');
    const productId = <?php echo $product['pro_id']; ?>;

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const rating = this.dataset.rating;
            
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            // Show loading state
            commentsContainer.innerHTML = '<div class="loading">Đang tải...</div>';

            // Fetch filtered comments
            fetch(`index.php?action=filter-comments&product_id=${productId}&rating=${rating}`)
                .then(response => response.text())
                .then(html => {
                    commentsContainer.innerHTML = html;
                })
                .catch(error => {
                    commentsContainer.innerHTML = '<div class="error">Có lỗi xảy ra khi tải bình luận</div>';
                });
        });
    });
});
</script>