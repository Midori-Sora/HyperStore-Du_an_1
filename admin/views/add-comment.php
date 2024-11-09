<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bình luận</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .form-control{
        margin: 10px 0;
    }
</style>
<body>
    <header>
        <?php include 'header.php' ?>
    </header>
    <div class="main">
        <main>
            <div class="container">
                <h2>Thêm bình luận</h2>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?action=addComment" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Người dùng</label>
                        <select class="form-control" name="user_id" required>
                            <option value="">Chọn người dùng</option>
                            <?php if(isset($users) && is_array($users)): ?>
                                <?php foreach($users as $user): ?>
                                    <option value="<?php echo htmlspecialchars($user['user_id']); ?>">
                                        <?php echo htmlspecialchars($user['user_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sản phẩm</label>
                        <select class="form-control" name="pro_id" required>
                            <option value="">Chọn sản phẩm</option>
                            <?php if(isset($products) && is_array($products)): ?>
                                <?php foreach($products as $product): ?>
                                    <option value="<?php echo htmlspecialchars($product['pro_id']); ?>">
                                        <?php echo htmlspecialchars($product['pro_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea class="form-control" name="content" required rows="4"></textarea>
                    </div>

                    <button class="btn btn-primary" name="them" type="submit">Thêm bình luận</button>
                    <a href="index.php?action=comment" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </main>
    </div>
</body>
</html> 