<?php
$comments = CommentController::getComments($product['pro_id']);
?>
<div class="comments-list">
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment-item">
                <div class="user-info">
                    <img class="user-avatar" 
                         src="<?php echo htmlspecialchars($comment['avatar']); ?>" 
                         alt="Avatar">
                    <div class="user-meta">
                        <div class="username">
                            <?php echo htmlspecialchars($comment['username']); ?>
                        </div>
                    </div>
                </div>

                <div class="comment-time">
                    <?php echo date('d/m/Y H:i', strtotime($comment['import_date'])); ?>
                </div>

                <div class="comment-content">
                    <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-comments">
            <i class="fas fa-comments"></i>
            <p>Chưa có bình luận nào</p>
        </div>
    <?php endif; ?>
</div>

<div class="review-form-section">
    <h3>Bình luận sản phẩm</h3>
    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="index.php?action=add-comment" method="POST" class="review-form">
            <input type="hidden" name="product_id" value="<?php echo $product['pro_id']; ?>">
            
            <div class="comment-input">
                <textarea name="content" rows="4" placeholder="Chia sẻ bình luận của bạn về sản phẩm..." required></textarea>
            </div>

            <button type="submit" class="submit-review">Gửi bình luận</button>
        </form>
    <?php else: ?>
        <div class="login-prompt">
            <p>Vui lòng <a href="index.php?action=login">đăng nhập</a> để bình luận sản phẩm</p>
        </div>
    <?php endif; ?>
</div>

<style>
    .purchase-required {
    text-align: center;
    padding: 20px;
    background: #fff3cd;
    border: 1px solid #ffeeba;
    border-radius: 4px;
    color: #856404;
    }

    .purchase-required p {
        margin: 0;
    }
    .review-form-section {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .review-form-section h3 {
        margin-bottom: 20px;
        color: #333;
        font-size: 18px;
    }

    .review-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .rating-input {
        margin-bottom: 15px;
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        gap: 5px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        cursor: pointer;
        font-size: 24px;
        color: #ddd;
        transition: color 0.2s ease;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #ffd700;
    }

    .comment-input textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        resize: vertical;
        font-family: inherit;
    }

    .submit-review {
        background: #ff424f;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        align-self: flex-start;
        transition: background-color 0.2s ease;
    }

    .submit-review:hover {
        background: #ff1f1f;
    }

    .login-prompt {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 4px;
    }

    .login-prompt a {
        color: #ff424f;
        text-decoration: none;
        font-weight: 500;
    }

    .login-prompt a:hover {
        text-decoration: underline;
    }
    .rating-overview {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .rating-summary {
        display: flex;
        gap: 30px;
    }

    .average-rating {
        text-align: center;
        padding-right: 30px;
        border-right: 1px solid #ddd;
    }

    .rating-number {
        font-size: 48px;
        font-weight: bold;
        color: #333;
    }

    .rating-stars {
        margin: 10px 0;
    }

    .total-ratings {
        color: #666;
        font-size: 14px;
    }

    .rating-bars {
        flex-grow: 1;
    }

    .rating-bar-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .star-count {
        width: 60px;
        text-align: right;
    }

    .progress-bar {
        flex-grow: 1;
        height: 8px;
        background: #eee;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress {
        height: 100%;
        background: #ffc107;
        transition: width 0.3s ease;
    }
    .comments-section {
        margin-top: 20px;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .comment-item {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .comment-item:last-child {
        border-bottom: none;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .username {
        font-weight: 500;
        color: #333;
        margin-bottom: 4px;
    }

    .rating {
        display: flex;
        gap: 2px;
    }

    .rating .fa-star {
        color: #ddd;
        font-size: 14px;
    }

    .rating .fa-star.active {
        color: #ff9f00;
    }

    .comment-time {
        font-size: 13px;
        color: #666;
        margin: 8px 0;
    }

    .comment-content {
        color: #333;
        line-height: 1.5;
    }

    .no-comments {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    .no-comments i {
        font-size: 48px;
        margin-bottom: 10px;
        color: #ddd;
    }
    .pending-comments-section {
        margin-bottom: 30px;
        padding: 15px;
        background: #fff8e1;
        border-radius: 8px;
        border: 1px dashed #ffd54f;
    }

    .pending-comments-section h4 {
        color: #f57c00;
        margin-bottom: 15px;
        font-size: 16px;
    }

    .comment-item.pending {
        background: #fff;
        border: 1px solid #ffe0b2;
        position: relative;
        padding: 20px;
        margin-bottom: 15px;
    }

    .pending-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fff3e0;
        color: #f57c00;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pending-badge i {
        font-size: 14px;
    }
</style>