<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý biến thể sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    body {
        background: #f5f5f5;
        padding-top: 80px;
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
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        padding: 30px;
        margin-bottom: 20px;
    }
    .card-header {
        background: none;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    .card-header h2 {
        margin: 0;
        color: #2c3345;
        font-size: 24px;
        font-weight: 600;
    }
    .variant-table {
        margin-top: 20px;
    }
    .variant-table th {
        background: #f8f9fa;
        font-weight: 600;
    }
    .btn-add {
        background: #1976D2;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        transition: all 0.3s;
    }
    .btn-add:hover {
        background: #1565C0;
        transform: translateY(-2px);
    }
    .price-column {
        min-width: 150px;
    }
    .action-column {
        width: 100px;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 14px;
    }
    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .status-inactive {
        background: #ffebee;
        color: #c62828;
    }
    .quantity-column {
        min-width: 100px;
    }
    .form-select {
        padding: 0.5rem;
        border-radius: 8px;
        border: 1px solid #dce0e4;
        margin-bottom: 1rem;
    }
    .form-select:focus {
        border-color: #1976D2;
        box-shadow: 0 0 0 0.2rem rgba(25,118,210,0.1);
    }
    input[type="number"] {
        padding: 0.5rem;
        border-radius: 8px;
        border: 1px solid #dce0e4;
    }
    input[type="number"]:focus {
        border-color: #1976D2;
        box-shadow: 0 0 0 0.2rem rgba(25,118,210,0.1);
    }
</style>

<body>
    <?php include "./views/layout/header.php" ?>
    
    <div class="main">
        <?php include "./views/layout/sidebar.php" ?>
        
        <main>
            <!-- Storage Variants Section -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-memory me-2"></i>Quản lý Bộ nhớ</h2>
                    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addStorageModal">
                        <i class="fas fa-plus me-2"></i>Thêm Bộ nhớ
                    </button>
                </div>
                <div class="table-responsive variant-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Dung lượng</th>
                                <th class="price-column">Giá (+)</th>
                                <th>Ngày tạo</th>
                                <th class="action-column">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($storageOptions as $storage): ?>
                            <tr>
                                <td><?= $storage['storage_id'] ?></td>
                                <td><?= $storage['storage_type'] ?></td>
                                <td><?= number_format($storage['storage_price'], 0, ',', '.') ?>đ</td>
                                <td><?= date('d/m/Y', strtotime($storage['created_at'])) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editStorageModal"
                                            data-id="<?= $storage['storage_id'] ?>"
                                            data-type="<?= $storage['storage_type'] ?>"
                                            data-price="<?= $storage['storage_price'] ?>"
                                            title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="index.php?action=deleteStorage" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa bộ nhớ này?');">
                                        <input type="hidden" name="storage_id" value="<?= $storage['storage_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Color Variants Section -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2><i class="fas fa-palette me-2"></i>Quản lý Màu sắc</h2>
                    <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#addColorModal">
                        <i class="fas fa-plus me-2"></i>Thêm màu
                    </button>
                </div>
                <div class="table-responsive variant-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên màu</th>
                                <th class="price-column">Giá (+)</th>
                                <th>Ngày tạo</th>
                                <th class="action-column">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($colorOptions as $color): ?>
                            <tr>
                                <td><?= $color['color_id'] ?></td>
                                <td><?= $color['color_type'] ?></td>
                                <td><?= number_format($color['color_price'], 0, ',', '.') ?>đ</td>
                                <td><?= date('d/m/Y', strtotime($color['created_at'])) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editColorModal"
                                            data-id="<?= $color['color_id'] ?>"
                                            data-type="<?= $color['color_type'] ?>"
                                            data-price="<?= $color['color_price'] ?>"
                                            title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="index.php?action=deleteColor" method="POST" class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa màu này?');">
                                        <input type="hidden" name="color_id" value="<?= $color['color_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Add RAM Modal -->
    <div class="modal fade" id="addRamModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm RAM mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="index.php?action=addRam" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Dung lượng RAM</label>
                            <input type="text" class="form-control" name="ram_type" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thêm</label>
                            <input type="number" class="form-control" name="ram_price" required min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Color Modal -->
    <div class="modal fade" id="addColorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm màu mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="index.php?action=addColor" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên màu</label>
                            <input type="text" class="form-control" name="color_type" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thêm</label>
                            <input type="number" class="form-control" name="color_price" required min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit RAM Modal -->
    <div class="modal fade" id="editRamModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa RAM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="index.php?action=editRam" method="POST">
                    <input type="hidden" name="ram_id" id="editRamId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Dung lượng RAM</label>
                            <input type="text" class="form-control" name="ram_type" id="editRamType" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thêm</label>
                            <input type="number" class="form-control" name="ram_price" id="editRamPrice" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Color Modal -->
    <div class="modal fade" id="editColorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa màu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="index.php?action=editColor" method="POST">
                    <input type="hidden" name="color_id" id="editColorId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tên màu</label>
                            <input type="text" class="form-control" name="color_type" id="editColorType" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thêm</label>
                            <input type="number" class="form-control" name="color_price" id="editColorPrice" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Storage Modal -->
    <div class="modal fade" id="addStorageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm bộ nhớ mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="index.php?action=addStorage" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Dung lượng bộ nhớ</label>
                            <input type="text" class="form-control" name="storage_type" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thêm</label>
                            <input type="number" class="form-control" name="storage_price" required min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Storage Modal -->
    <div class="modal fade" id="editStorageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa bộ nhớ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="index.php?action=editStorage" method="POST">
                    <input type="hidden" name="storage_id" id="editStorageId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Dung lượng bộ nhớ</label>
                            <input type="text" class="form-control" name="storage_type" id="editStorageType" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá thêm</label>
                            <input type="number" class="form-control" name="storage_price" id="editStoragePrice" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function deleteRam(id) {
        if(confirm('Bạn có chắc muốn xóa RAM này?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?action=deleteRam';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ram_id';
            input.value = id;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function deleteColor(id) {
        if(confirm('Bạn có chắc muốn xóa màu này?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?action=deleteColor';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'color_id';
            input.value = id;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }

    const editQuantityModal = document.getElementById('editQuantityModal');
    if (editQuantityModal) {
        editQuantityModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const proId = button.getAttribute('data-id');
            const quantity = button.getAttribute('data-quantity');
            
            document.getElementById('editProId').value = proId;
            document.getElementById('editQuantity').value = quantity;
        });
    }

    // Xử lý modal edit RAM
    const editRamModal = document.getElementById('editRamModal');
    if (editRamModal) {
        editRamModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ramId = button.getAttribute('data-id');
            const ramType = button.getAttribute('data-type');
            const ramPrice = button.getAttribute('data-price');
            
            document.getElementById('editRamId').value = ramId;
            document.getElementById('editRamType').value = ramType;
            document.getElementById('editRamPrice').value = ramPrice;
        });
    }

    // Xử lý modal edit Color
    const editColorModal = document.getElementById('editColorModal');
    if (editColorModal) {
        editColorModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const colorId = button.getAttribute('data-id');
            const colorType = button.getAttribute('data-type');
            const colorPrice = button.getAttribute('data-price');
            
            document.getElementById('editColorId').value = colorId;
            document.getElementById('editColorType').value = colorType;
            document.getElementById('editColorPrice').value = colorPrice;
        });
    }

    const editStorageModal = document.getElementById('editStorageModal');
    if (editStorageModal) {
        editStorageModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const storageId = button.getAttribute('data-id');
            const storageType = button.getAttribute('data-type');
            const storagePrice = button.getAttribute('data-price');
            
            document.getElementById('editStorageId').value = storageId;
            document.getElementById('editStorageType').value = storageType;
            document.getElementById('editStoragePrice').value = storagePrice;
        });
    }
    </script>
</body>
</html>
