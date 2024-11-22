<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm khuyến mãi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    body {
        background: #f8f9fa;
        padding-top: 80px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main {
        display: flex;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    main {
        width: calc(100% - 270px);
        margin-left: 270px;
    }

    .card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 30px;
        border: none;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .btn-primary {
        background: #1976D2;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        background: #1565C0;
        transform: translateY(-2px);
    }
    </style>
</head>

<body>
    <div class="main">
        <?php require_once './views/layout/sidebar.php'; ?>
        <main>
            <div class="container-fluid">
                <div class="card">
                    <h2 class="mb-4">Thêm khuyến mãi mới</h2>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="pro_id" class="form-label">Sản phẩm</label>
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
                            <label for="discount" class="form-label">Giảm giá (%)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="discount" name="discount" required min="0"
                                    max="100" onchange="calculateDiscountedPrice(this.value)">
                                <span class="input-group-text">%</span>
                            </div>
                            <div id="discountedPrice" class="form-text text-success mt-2"></div>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1">Hoạt động</option>
                                <option value="0">Không hoạt đng</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-plus me-2"></i>Thêm khuyến mãi
                            </button>
                            <a href="index.php?action=deal" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script>
    function calculateDiscountedPrice(discount) {
        const productSelect = document.getElementById('pro_id');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const originalPrice = parseFloat(selectedOption.getAttribute('data-price'));

        if (!isNaN(originalPrice) && !isNaN(discount)) {
            const discountAmount = originalPrice * (discount / 100);
            const finalPrice = originalPrice - discountAmount;

            document.getElementById('discountedPrice').innerHTML =
                `Giá gốc: <strong>${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(originalPrice)}</strong><br>
                     Giảm: <strong>${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(discountAmount)}</strong><br>
                     Giá sau giảm: <strong>${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(finalPrice)}</strong>`;
        }
    }

    // Tính toán giá khi thay đổi sản phẩm
    document.getElementById('pro_id').addEventListener('change', function() {
        const discount = document.getElementById('discount').value;
        if (discount) {
            calculateDiscountedPrice(discount);
        }
    });

    // Tính toán giá khi thay đổi % giảm giá
    document.getElementById('discount').addEventListener('input', function() {
        calculateDiscountedPrice(this.value);
    });
    </script>
</body>

</html>