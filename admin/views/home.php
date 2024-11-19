<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <link rel="stylesheet" href="././assets/css/admin/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="../Uploads/Logo/logo.png">
</head>
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
    header {
        margin-bottom: 30px;
    }
    .main {
        display: flex;
        justify-content: flex-end;
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }
    .main main {
        width: calc(100% - 270px);
        margin-left: 270px;
    }
    .stats-card {
        text-decoration: none;
        color: inherit;
        display: block;
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        text-decoration: none;
        color: inherit;
    }
    .stats-card h5 {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }
    .stats-card h3 {
        font-size: 1.8rem;
        margin-bottom: 15px;
    }
    .stats-card p {
        margin: 0;
        font-size: 0.9rem;
    }
    .stats-card i {
        margin-right: 5px;
    }
    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .chart-container h4 {
        color: #333;
        margin-bottom: 20px;
        font-size: 1.2rem;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table th, table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    table th {
        font-weight: 600;
        color: #666;
        background: #f8f9fa;
    }
    table tr:hover {
        background: #f8f9fa;
    }
</style>
<body>
    <header>
        <?php include 'layout/header.php' ?>
    </header>
    <div class="main">
        <div class="sidebar">
            <?php include 'layout/sidebar.php'; ?>
        </div>
        <main>
            <div class="container">
                <!-- Thống kê tổng quan -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <a href="./index.php?action=product" class="stats-card">
                            <h5>Sản phẩm</h5>
                            <h3 class="text-success"><?php echo number_format($totalProducts['total']); ?></h3>
                            <p>
                                <i class="fas fa-check-circle me-2 text-success"></i>Hoạt động: <?php echo number_format($totalProducts['active']); ?>
                                <br>
                                <i class="fas fa-times-circle me-2 text-danger"></i>Không hoạt động: <?php echo number_format($totalProducts['inactive']); ?>
                            </p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="./index.php?action=user" class="stats-card">
                            <h5>Người dùng</h5>
                            <h3 class="text-info"><?php echo number_format($totalUsers['total']); ?></h3>
                            <p>
                                <i class="fas fa-user-shield me-2"></i>Admin: <?php echo number_format($totalUsers['admin']); ?>
                                <br>
                                <i class="fas fa-users me-2"></i>Khách hàng: <?php echo number_format($totalUsers['customer']); ?>
                            </p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="./index.php?action=comment" class="stats-card">
                            <h5>Bình luận</h5>
                            <h3 class="text-warning"><?php echo number_format($totalComments['total']); ?></h3>
                            <p>
                                <i class="fas fa-check me-2 text-success"></i>Đã duyệt: <?php echo number_format($totalComments['approved']); ?>
                                <br>
                                <i class="fas fa-clock me-2 text-warning"></i>Chờ duyệt: <?php echo number_format($totalComments['pending']); ?>
                            </p>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="./index.php?action=order" class="stats-card">
                            <h5>Đơn hàng</h5>
                            <h3 class="text-warning"><?php echo number_format($totalOrders['total']); ?></h3>
                            <p>
                                <i class="fas fa-check me-2 text-success"></i>Hoàn thành: <?php echo number_format($totalOrders['completed']); ?>
                                <br>
                                <i class="fas fa-cog me-2 text-primary"></i>Đang xử lý: <?php echo number_format($totalOrders['processing']); ?>
                                <br>
                                <i class="fas fa-clock me-2 text-warning"></i>Chờ xử lý: <?php echo number_format($totalOrders['pending']); ?>
                            </p>
                        </a>
                    </div>
                </div>

                <!-- Biểu đồ -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-container">
                            <h4>Doanh thu theo tháng</h4>
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-container">
                            <h4>Phân bố sản phẩm</h4>
                            <canvas id="productChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Bảng thống kê chi tiết -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="stats-card">
                            <h4>Sản phẩm bán chạy</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Đã bán</th>
                                        <th>Doanh thu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>iPhone 15 Pro Max</td>
                                        <td>Điện thoại</td>
                                        <td>150</td>
                                        <td>75.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>Samsung Galaxy S24</td>
                                        <td>Điện thoại</td>
                                        <td>120</td>
                                        <td>60.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td>Xiaomi 14 Pro</td>
                                        <td>Điện thoại</td>
                                        <td>90</td>
                                        <td>45.000.000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Biểu đồ doanh thu
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                datasets: [{
                    label: 'Doanh thu (triệu đồng)',
                    data: [65, 59, 80, 81, 56, 55, 40, 88, 96, 67, 120, 150],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Biểu đồ phân bố sản phẩm
        const productCtx = document.getElementById('productChart').getContext('2d');
        new Chart(productCtx, {
            type: 'doughnut',
            data: {
                labels: ['iPhone 11', 'iPhone 12', 'iPhone 13', 'iPhone 14', 'iPhone 15', 'iPhone 16'],
                datasets: [{
                    data: [30, 25, 20, 15, 10, 5],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    </script>
</body>
</html> 