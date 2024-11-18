<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
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

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .table {
        margin-top: 20px;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 15px;
        border: none;
    }

    .table td {
        padding: 15px;
        vertical-align: middle;
        background: white;
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
    }

    .status-badge {
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 6px;
    }

    .status-badge.pending {
        background: #ffeeba;
        color: #856404;
    }

    .status-badge.completed {
        background: #d4edda;
        color: #155724;
    }

    .status-badge.processing {
        background: #cce5ff;
        color: #004085;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: none;
        background: #1976D2;
        color: white;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        opacity: 0.9;
    }

    .search-filter {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .search-filter select,
    .search-filter input {
        height: 40px;
        border: 1px solid #ddd;
    }

    .search-filter .btn-primary {
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    </style>
</head>

<body>
    <?php include "./views/layout/header.php"; ?>
    <div class="main">
        <div class="sidebar">
            <?php include "./views/layout/sidebar.php"; ?>
        </div>
        <main>
            <div class="container-fluid">
                <div class="page-header">
                    <h2>Quản lý đơn hàng</h2>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="search-filter mb-4">
                    <form action="?action=searchOrder" method="GET" class="row g-3">
                        <input type="hidden" name="action" value="searchOrder">

                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control"
                                placeholder="Tìm theo mã đơn hàng, tên KH hoặc SĐT..."
                                value="<?= $_GET['keyword'] ?? '' ?>">
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">-- Trạng thái --</option>
                                <option value="1"
                                    <?= isset($_GET['status']) && $_GET['status'] == 1 ? 'selected' : '' ?>>Chờ xử lý
                                </option>
                                <option value="2"
                                    <?= isset($_GET['status']) && $_GET['status'] == 2 ? 'selected' : '' ?>>Hoàn thành
                                </option>
                                <option value="3"
                                    <?= isset($_GET['status']) && $_GET['status'] == 3 ? 'selected' : '' ?>>Đang xử lý
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="sort" class="form-select">
                                <option value="">-- Sắp xếp --</option>
                                <option value="newest"
                                    <?= isset($_GET['sort']) && $_GET['sort'] == 'newest' ? 'selected' : '' ?>>Mới nhất
                                </option>
                                <option value="oldest"
                                    <?= isset($_GET['sort']) && $_GET['sort'] == 'oldest' ? 'selected' : '' ?>>Cũ nhất
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['order_code'] ?></td>
                                <td><?= $order['username'] ?></td>
                                <td><?= number_format($order['total_amount']) ?>đ</td>
                                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                <td>
                                    <?php
                                            $statusClass = '';
                                            $statusText = '';
                                            switch($order['status']) {
                                                case 1:
                                                    $statusClass = 'pending';
                                                    $statusText = 'Chờ xử lý';
                                                    break;
                                                case 2:
                                                    $statusClass = 'completed';
                                                    $statusText = 'Hoàn thành';
                                                    break;
                                                case 3:
                                                    $statusClass = 'processing';
                                                    $statusText = 'Đang xử lý';
                                                    break;
                                            }
                                            ?>
                                    <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                                </td>
                                <td>
                                    <a href="?action=orderDetail&id=<?= $order['order_id'] ?>" class="btn-action">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>