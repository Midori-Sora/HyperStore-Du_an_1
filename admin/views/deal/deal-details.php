<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết khuyến mãi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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

    .product-image-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-thumbnail {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .table {
        table-layout: fixed;
        width: 100%;
    }

    .table td {
        vertical-align: middle;
        word-wrap: break-word;
    }

    .table-responsive {
        min-height: 200px;
    }

    .product-name {
        flex: 1;
        min-width: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    </style>
</head>

<body>
    <?php include_once './views/layout/header.php'; ?>
    <div class="main">
        <?php include_once './views/layout/sidebar.php'; ?>
        <main>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết khuyến mãi</h5>
                        <a href="index.php?action=deal" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    // Debug để kiểm tra dữ liệu
                    error_log("Deal Details in View: " . print_r($dealDetails, true));
                    ?>

                    <?php if (isset($dealDetails) && $dealDetails): ?>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Thông tin chung:</h6>
                            <p>Giảm giá: <?= htmlspecialchars($dealDetails['main_deal']['discount']) ?>%</p>
                            <p>Ngày bắt đầu: <?= date('d/m/Y', strtotime($dealDetails['main_deal']['start_date'])) ?>
                            </p>
                            <p>Ngày kết thúc: <?= date('d/m/Y', strtotime($dealDetails['main_deal']['end_date'])) ?></p>
                            <p>Trạng thái: <?= $dealDetails['main_deal']['status'] ? 'Đang hoạt động' : 'Đã kết thúc' ?>
                            </p>
                        </div>
                    </div>

                    <h6>Danh sách sản phẩm áp dụng:</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Dung lượng</th>
                                    <th>Màu sắc</th>
                                    <th>Giá gốc</th>
                                    <th>Giảm giá</th>
                                    <th>Giá sau giảm</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dealDetails['products'] as $product): ?>
                                <?php
                                        $discountAmount = $product['price'] * ($product['discount'] / 100);
                                        $finalPrice = $product['price'] - $discountAmount;
                                        ?>
                                <tr>
                                    <td>
                                        <?php
                                                $imagePath = $product['img'] ? "../Uploads/Product/" . $product['img'] : "../assets/images/default.jpg";
                                                ?>
                                        <div class="product-image-container">
                                            <img src="<?= htmlspecialchars($imagePath) ?>"
                                                alt="<?= htmlspecialchars($product['pro_name']) ?>"
                                                class="product-thumbnail"
                                                onerror="this.src='../assets/images/default.jpg'">
                                            <span
                                                class="product-name ms-2"><?= htmlspecialchars($product['pro_name']) ?></span>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($product['storage_type']) ?></td>
                                    <td><?= htmlspecialchars($product['color_type']) ?></td>
                                    <td><?= number_format($product['price']) ?>đ</td>
                                    <td><?= number_format($discountAmount) ?>đ</td>
                                    <td><?= number_format($finalPrice) ?>đ</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="alert alert-warning">Không tìm thấy thông tin khuyến mãi</div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>