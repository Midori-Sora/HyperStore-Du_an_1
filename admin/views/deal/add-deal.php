<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm khuyến mãi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f5f5f5;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding-top: 80px;
    }

    .main {
        display: flex;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .main main {
        width: calc(100% - 270px);
        margin-left: 270px;
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #dce0e4;
        margin: 10px 0;
    }

    .btn-primary {
        background: #1976D2;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #1565C0;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #f5f5f5;
        color: #666;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        margin-left: 10px;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: #e0e0e0;
    }

    .form-label {
        font-weight: 500;
        color: #444;
        margin-bottom: 8px;
    }

    .input-group-text {
        background: #f8f9fa;
        border: 1px solid #dce0e4;
        border-radius: 0 8px 8px 0;
    }

    #discountedPrice {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .alert {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        border: none;
    }
    </style>
</head>

<body>
    <header>
        <?php include './views/layout/header.php' ?>
    </header>
    <div class="main">
        <div class="sidebar">
            <?php include './views/layout/sidebar.php'; ?>
        </div>
        <main>
            <div class="container">
                <h2 class="mb-4">
                    <i class="fas fa-plus me-2"></i>Thêm khuyến mãi mới
                </h2>

                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php
                        echo htmlspecialchars($_SESSION['error']);
                        unset($_SESSION['error']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="pro_id" class="form-label">
                            <i class="fas fa-box me-2"></i>Sản phẩm
                        </label>
                        <select class="form-select" id="pro_id" name="pro_id" required>
                            <option value="">Chọn sản phẩm</option>
                            <?php foreach ($products as $product): ?>
                            <option value="<?= $product['pro_id'] ?>" data-price="<?= $product['price'] ?>">
                                <?= $product['pro_name'] ?> - <?= number_format($product['price'], 0, ',', '.') ?>đ
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label">
                            <i class="fas fa-tag me-2"></i>Giảm giá (%)
                        </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="discount" name="discount" required min="0"
                                max="100">
                            <span class="input-group-text">%</span>
                        </div>
                        <div id="discountedPrice" class="form-text mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">
                            <i class="fas fa-calendar-alt me-2"></i>Ngày bắt đầu
                        </label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">
                            <i class="fas fa-calendar-alt me-2"></i>Ngày kết thúc
                        </label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">
                            <i class="fas fa-toggle-on me-2"></i>Trạng thái
                        </label>
                        <select class="form-select" id="status" name="status">
                            <option value="1">Hoạt động</option>
                            <option value="0">Không hoạt động</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Thêm khuyến mãi
                        </button>
                        <a href="?action=deal" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function calculateDiscountedPrice(discount) {
        const productSelect = document.getElementById('pro_id');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const originalPrice = parseFloat(selectedOption.getAttribute('data-price'));

        if (!isNaN(originalPrice) && !isNaN(discount)) {
            const discountAmount = originalPrice * (discount / 100);
            const finalPrice = originalPrice - discountAmount;

            document.getElementById('discountedPrice').innerHTML =
                `<div class="text-muted mb-1">Chi tiết giá:</div>
                 <div class="mb-1">Giá gốc: <strong>${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(originalPrice)}</strong></div>
                 <div class="mb-1">Giảm: <strong class="text-danger">-${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(discountAmount)}</strong></div>
                 <div>Giá sau giảm: <strong class="text-success">${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(finalPrice)}</strong></div>`;
        }
    }

    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.needs-validation');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Tính toán giá khi thay đổi sản phẩm hoặc % giảm giá
    document.getElementById('pro_id').addEventListener('change', function() {
        const discount = document.getElementById('discount').value;
        if (discount) {
            calculateDiscountedPrice(discount);
        }
    });

    document.getElementById('discount').addEventListener('input', function() {
        calculateDiscountedPrice(this.value);
    });
    </script>
</body>

</html>