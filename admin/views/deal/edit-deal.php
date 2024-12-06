<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa khuyến mãi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            --bs-gutter-x: 0;
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

        .table {
            margin-top: 1rem;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table td,
        .table th {
            padding: 12px;
            vertical-align: middle;
        }

        .remove-product {
            padding: 4px 8px;
            font-size: 0.875rem;
        }

        .table-responsive {
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
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
                <form method="POST" class="needs-validation" novalidate>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>Sửa khuyến mãi</h4>
                            <a href="?action=deal" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Phần trăm giảm giá</label>
                                <input type="number" name="discount" id="discount" class="form-control"
                                    value="<?= $deal['discount'] ?>" min="0" max="10" required>
                                <small class="text-muted">Giảm giá tối đa 10%</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Thêm sản phẩm áp dụng</label>
                                <select name="product_ids[]" id="product_ids" class="form-select" multiple>
                                    <?php foreach ($products as $product): ?>
                                        <?php if (!in_array($product['pro_id'], $deal['product_ids'])): ?>
                                            <option value="<?= $product['pro_id'] ?>" data-price="<?= $product['price'] ?>">
                                                <?= $product['pro_name'] ?> - <?= number_format($product['price']) ?>đ
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sản phẩm đang áp dụng</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="appliedProductsTable">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Giá gốc</th>
                                                <th>Giảm giá</th>
                                                <th>Giá sau giảm</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $product): ?>
                                                <?php if (in_array($product['pro_id'], $deal['product_ids'])): ?>
                                                    <?php
                                                    $originalPrice = $product['price'];
                                                    $discountAmount = $originalPrice * ($deal['discount'] / 100);
                                                    $finalPrice = $originalPrice - $discountAmount;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $product['pro_name'] ?>
                                                            <input type="hidden" name="current_product_ids[]"
                                                                value="<?= $product['pro_id'] ?>">
                                                        </td>
                                                        <td><?= number_format($originalPrice) ?>đ</td>
                                                        <td class="text-danger">-<?= number_format($discountAmount) ?>đ</td>
                                                        <td class="text-success"><?= number_format($finalPrice) ?>đ</td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm btn-remove"
                                                                data-product-id="<?= $product['pro_id'] ?>">
                                                                <i class="fas fa-trash"></i> Xóa
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày bắt đầu</label>
                                    <input type="datetime-local" name="start_date" class="form-control"
                                        value="<?= date('Y-m-d\TH:i', strtotime($deal['start_date'])) ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày kết thúc</label>
                                    <input type="datetime-local" name="end_date" class="form-control"
                                        value="<?= date('Y-m-d\TH:i', strtotime($deal['end_date'])) ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select" required>
                                    <option value="1" <?= $deal['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="0" <?= $deal['status'] == 0 ? 'selected' : '' ?>>Tạm dừng</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product_ids').select2({
                placeholder: 'Chọn sản phẩm cần thêm...',
                width: '100%'
            });

            $('.btn-remove').click(function() {
                const row = $(this).closest('tr');
                const productId = $(this).data('product-id');

                // Xóa hidden input khi xóa sản phẩm
                row.find('input[name="current_product_ids[]"]').remove();

                // Thêm sản phẩm vào select
                const productName = row.find('td:first').text().trim();
                const originalPrice = row.find('td:eq(1)').text();
                const option = new Option(productName + ' - ' + originalPrice, productId);
                $('#product_ids').append(option).trigger('change');

                row.remove();
            });

            $('form').submit(function(e) {
                const appliedProducts = $('#appliedProductsTable tbody tr').length;
                const newProducts = $('#product_ids').val() ? $('#product_ids').val().length : 0;

                if (appliedProducts === 0 && newProducts === 0) {
                    alert('Vui lòng chọn ít nhất một sản phẩm để áp dụng khuyến mãi');
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>