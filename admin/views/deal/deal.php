<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý khuyến mãi</title>
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
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            --bs-gutter-x: 0;
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
            margin-bottom: 20px;
            border: none;
        }

        .card-header {
            background: none;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-add {
            background: #1976D2;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover {
            background: #1565C0;
            color: white;
            transform: translateY(-2px);
        }

        .btn-action {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .status-active {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-inactive {
            background: #ffebee;
            color: #c62828;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .price-tag {
            color: #28a745;
            font-weight: 500;
            margin-left: 4px;
        }

        .original-price {
            color: #666;
            text-decoration: line-through;
            font-size: 0.95em;
        }

        .discounted-price {
            font-size: 1em;
            color: #28a745;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }

        td {
            vertical-align: middle;
        }

        .table> :not(caption)>*>* {
            padding: 1rem 0.5rem;
        }

        .product-item {
            margin-bottom: 8px;
            padding: 8px;
            border-bottom: 1px solid #eee;
        }

        .prices {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
        }

        .discounted-price {
            color: #dc3545;
            font-weight: bold;
        }

        .view-details.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .btn-group .btn {
            white-space: nowrap;
        }

        /* Animation cho loading */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .btn-group .btn {
            white-space: nowrap;
        }

        .btn-info {
            color: #fff;
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            color: #fff;
            background-color: #138496;
            border-color: #117a8b;
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
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Quản lý khuyến mãi</h4>
                        <div>
                            <a href="?action=addDeal" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm khuyến mãi
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="dealsForm" method="POST" action="?action=deleteManyDeals">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" id="checkAll" class="form-check-input">
                                        </th>
                                        <th width="8%">Giảm giá</th>
                                        <th width="35%">Sản phẩm áp dụng</th>
                                        <th width="12%">Ngày bắt đầu</th>
                                        <th width="12%">Ngày kết thúc</th>
                                        <th width="12%">Trạng thái</th>
                                        <th width="16%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($deals as $deal): ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected_deals[]"
                                                    value="<?= $deal['deal_id'] ?>" class="form-check-input deal-checkbox">
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?= $deal['discount'] ?>%</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-secondary me-2">
                                                        <?= $deal['product_count'] ?> sản phẩm
                                                    </span>
                                                    <div class="text-truncate" style="max-width: 300px;">
                                                        <?= $deal['products_text'] ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($deal['start_date'])) ?></td>
                                            <td><?= date('d/m/Y', strtotime($deal['end_date'])) ?></td>
                                            <td>
                                                <span class="badge <?= $deal['status'] ? 'bg-success' : 'bg-danger' ?>">
                                                    <?= $deal['status'] ? 'Hoạt động' : 'Tạm dừng' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="index.php?action=dealDetails&id=<?= $deal['deal_id'] ?>"
                                                        class="btn btn-sm btn-info me-1">
                                                        <i class="fas fa-eye"></i> Chi tiết
                                                    </a>
                                                    <a href="?action=editDeal&id=<?= $deal['deal_id'] ?>"
                                                        class="btn btn-sm btn-success me-1">
                                                        <i class="fas fa-edit"></i> Sửa
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="deleteDeal(<?= $deal['deal_id'] ?>)">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal chi tiết -->
    <div class="modal fade" id="dealDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết khuyến mãi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="dealDetailsContent">
                </div>
            </div>
        </div>
    </div>

    <!-- Thêm jQuery và Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Xử lý checkbox
            $('#checkAll').change(function() {
                $('.deal-checkbox').prop('checked', $(this).prop('checked'));
            });
        });

        // Function xóa deal
        function deleteDeal(dealId) {
            if (confirm('Bạn có chắc chắn muốn xóa khuyến mãi này? Tất cả sản phẩm trong khuyến mãi này sẽ bị xóa.')) {
                window.location.href = `index.php?action=deleteDeal&id=${dealId}`;
            }
        }
    </script>
</body>

</html>