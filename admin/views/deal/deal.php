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
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-percent me-2"></i>
                            Quản lý khuyến mãi
                        </h2>
                        <a href="?action=addDeal" class="btn-add">
                            <i class="fas fa-plus"></i>
                            Thêm khuyến mãi
                        </a>
                    </div>

                    <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="20%">Sản phẩm</th>
                                    <th width="8%">Giảm giá</th>
                                    <th width="12%">Giá gốc</th>
                                    <th width="10%">Giá sau giảm</th>
                                    <th width="10%">Ngày bắt đầu</th>
                                    <th width="10%">Ngày kết thúc</th>
                                    <th width="12%">Trạng thái</th>
                                    <th width="10%">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($deals)): ?>
                                <?php foreach ($deals as $deal): ?>
                                <tr>
                                    <td><?= $deal['deal_id'] ?></td>
                                    <td><?= htmlspecialchars($deal['pro_name']) ?></td>
                                    <td>
                                        <span class="badge bg-danger">
                                            -<?= $deal['discount'] ?>%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="original-price">
                                            <?= number_format($deal['pro_price'], 0, ',', '.') ?>đ
                                        </span>
                                    </td>
                                    <td>
                                        <span class="discounted-price text-success fw-bold">
                                            <?= number_format($deal['pro_price'] * (1 - $deal['discount'] / 100), 0, ',', '.') ?>đ
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($deal['start_date'])) ?></td>
                                    <td><?= date('d/m/Y', strtotime($deal['end_date'])) ?></td>
                                    <td>
                                        <span
                                            class="status-badge <?= $deal['status'] ? 'status-active' : 'status-inactive' ?>">
                                            <?= $deal['status'] ? 'Hoạt động' : 'Không hoạt động' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="?action=editDeal&id=<?= $deal['deal_id'] ?>"
                                            class="btn btn-success btn-action me-2">
                                            <i class="fas fa-edit me-1"></i>
                                            Sửa
                                        </a>
                                        <a href="?action=deleteDeal&id=<?= $deal['deal_id'] ?>"
                                            class="btn btn-danger btn-action"
                                            onclick="return confirm('Bạn có chắc muốn xóa khuyến mãi này?')">
                                            <i class="fas fa-trash me-1"></i>
                                            Xóa
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-percent me-2"></i>
                                        Không có khuyến mãi nào
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>