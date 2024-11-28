<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm khuyến mãi</title>
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

    .select2-container--default .select2-selection--multiple {
        min-height: 200px;
        border: 1px solid #dce0e4;
        border-radius: 8px;
        padding: 8px;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background: #1976D2;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
        margin: 4px;
    }

    .select2-container--default .select2-selection__choice__remove {
        color: white !important;
        margin-right: 5px;
    }

    .select2-container--default .select2-search__field {
        margin-top: 7px;
    }

    .select2-container--default .select2-results__option {
        padding: 8px 12px;
    }

    .select2-container--default .select2-results__group {
        background: #f8f9fa;
        font-weight: 600;
        padding: 8px 12px;
    }

    .select-actions {
        display: flex;
        gap: 10px;
    }

    .price-details {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .price-details table {
        width: 100%;
        border-collapse: collapse;
    }

    .price-details th,
    .price-details td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .price-details th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .price-details tr:last-child td {
        border-bottom: none;
    }

    .price-details .discount {
        color: #dc3545;
    }

    .price-details .final-price {
        color: #28a745;
        font-weight: 600;
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
                            <h4>Thêm khuyến mãi mới</h4>
                            <a href="?action=deal" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phần trăm giảm giá</label>
                                    <input type="number" name="discount" id="discount" class="form-control" min="0"
                                        max="100" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sản phẩm áp dụng</label>
                                <div class="select-actions mb-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="selectAll">
                                        <i class="fas fa-check-square"></i> Chọn tất cả
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary me-2" id="clearAll">
                                        <i class="fas fa-times"></i> Bỏ chọn tất cả
                                    </button>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-filter"></i> Lọc theo danh mục
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php foreach ($categories as $category): ?>
                                            <li>
                                                <a class="dropdown-item category-filter" href="#"
                                                    data-category="<?= $category['cate_id'] ?>">
                                                    <?= $category['cate_name'] ?>
                                                </a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>

                                <select name="product_ids[]" id="product_ids" class="form-select" multiple required>
                                    <?php foreach ($categories as $category): ?>
                                    <optgroup label="<?= $category['cate_name'] ?>">
                                        <?php foreach ($products as $product): ?>
                                        <?php if ($product['cate_id'] == $category['cate_id']): ?>
                                        <option value="<?= $product['pro_id'] ?>"
                                            data-category="<?= $category['cate_id'] ?>"
                                            data-price="<?= $product['price'] ?>">
                                            <?= $product['pro_name'] ?> - <?= number_format($product['price']) ?>đ
                                        </option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày bắt đầu</label>
                                    <input type="datetime-local" name="start_date" id="start_date" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày kết thúc</label>
                                    <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select name="status" class="form-select" required>
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm dừng</option>
                                </select>
                            </div>

                            <div id="discountedPrice" class="price-details mt-3"></div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Lưu khuyến mãi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function calculateDiscountedPrice(discount) {
        const selectedOptions = Array.from($('#product_ids').select2('data'));
        let html = `
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá gốc</th>
                            <th>Giảm giá</th>
                            <th>Giá sau giảm</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

        selectedOptions.forEach(option => {
            const originalPrice = parseFloat($(option.element).data('price'));
            if (!isNaN(originalPrice) && !isNaN(discount)) {
                const discountAmount = originalPrice * (discount / 100);
                const finalPrice = originalPrice - discountAmount;

                html += `
                        <tr>
                            <td>${option.text}</td>
                            <td>${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(originalPrice)}</td>
                            <td class="discount">${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(discountAmount)}</td>
                            <td class="final-price">${new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(finalPrice)}</td>
                        </tr>
                    `;
            }
        });

        html += `
                </tbody>
            </table>
        `;

        $('#discountedPrice').html(html);
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
    document.getElementById('product_ids').addEventListener('change', function() {
        const discount = document.getElementById('discount').value;
        if (discount) {
            calculateDiscountedPrice(discount);
        }
    });

    document.getElementById('discount').addEventListener('input', function() {
        calculateDiscountedPrice(this.value);
    });

    $(document).ready(function() {
        // Khởi tạo Select2
        const $productSelect = $('#product_ids').select2({
            placeholder: 'Chọn sản phẩm...',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Không tìm thấy sản phẩm";
                }
            }
        });

        // Xử lý nút ch���n tất cả
        $('#selectAll').click(function() {
            $('#product_ids option').prop('selected', true);
            $productSelect.trigger('change');
        });

        // Xử lý nút bỏ chọn tất cả
        $('#clearAll').click(function() {
            $('#product_ids option').prop('selected', false);
            $productSelect.trigger('change');
        });

        // Xử lý lọc theo danh mục
        $('.category-filter').click(function(e) {
            e.preventDefault();
            const categoryId = $(this).data('category');

            // Bỏ chọn tất cả
            $('#product_ids option').prop('selected', false);

            // Chọn các sản phẩm thuộc danh mục
            $(`#product_ids option[data-category="${categoryId}"]`).prop('selected', true);

            $productSelect.trigger('change');
        });

        // Validation thời gian
        $('#end_date').on('change', function() {
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($(this).val());

            if (endDate < startDate) {
                alert('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                $(this).val('');
            }
        });

        // Cập nhật tính toán giá khi thay đ��i select2
        $('#product_ids').on('change', function() {
            const discount = $('#discount').val();
            if (discount) {
                calculateDiscountedPrice(discount);
            }
        });
    });
    </script>
</body>

</html>