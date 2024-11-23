<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="assets/css/client/checkout.css">
</head>

<body>
    <?php require_once "client/views/layout/header.php"; ?>

    <div class="checkout-container">
        <!-- Địa chỉ nhận hàng -->
        <div class="shipping-address">
            <h2><i class="fas fa-map-marker-alt"></i> Địa Chỉ Nhận Hàng</h2>
            <div class="address-content">
                <?php if (isset($userAddress)): ?>
                    <div class="address-info" id="default-address">
                        <p class="name"><?= $userAddress['receiver_name'] ?> | <?= $userAddress['phone'] ?></p>
                        <p class="address"><?= $userAddress['address'] ?></p>
                        <button type="button" class="change-address-btn" onclick="toggleAddressForm()">Thay đổi</button>
                    </div>

                    <!-- Form địa chỉ mới -->
                    <div class="new-address-form" id="address-form" style="display: none;">
                        <form id="shipping-form">
                            <div class="form-group">
                                <input type="text" name="receiver_name" placeholder="Họ tên người nhận" required>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" placeholder="Số điện thoại" required>
                            </div>
                            <div class="form-group">
                                <textarea name="address" placeholder="Địa chỉ chi tiết" required></textarea>
                            </div>
                            <div class="form-buttons">
                                <button type="button" onclick="toggleAddressForm()">Hủy</button>
                                <button type="submit">Xác nhận</button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Sản phẩm đặt hàng -->
        <div class="order-products">
            <div class="shop-header">
                <i class="fas fa-store"></i>
                <span>HyperStore Official</span>
            </div>

            <?php foreach ($selectedProducts as $product): ?>
                <div class="product-item">
                    <a href="index.php?action=product-detail&id=<?= $product['pro_id'] ?>" class="product-link">
                        <img src="Uploads/Product/<?= $product['img'] ?>" alt="<?= $product['pro_name'] ?>">
                        <div class="product-info">
                            <h3><?= $product['pro_name'] ?></h3>
                            <p class="variant">
                                Phân loại: <?= $product['color_type'] ?>, <?= $product['storage_type'] ?>
                            </p>
                            <p class="quantity">x<?= $product['quantity'] ?></p>
                        </div>
                        <div class="product-price">
                            <?= number_format($product['price'], 0, ',', '.') ?>đ
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>

            <!-- Phương thức thanh toán -->
            <div class="payment-methods">
                <h3>Phương Thức Thanh Toán</h3>
                <div class="method-options">
                    <label class="method-item">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <div class="method-info">
                            <img src="assets/images/payments/cod.png" alt="COD">
                            <span>Thanh toán khi nhận hàng</span>
                        </div>
                    </label>

                    <label class="method-item">
                        <input type="radio" name="payment_method" value="momo">
                        <div class="method-info">
                            <img src="assets/images/payments/momo.png" alt="MoMo">
                            <span>Ví MoMo</span>
                        </div>
                    </label>

                    <label class="method-item">
                        <input type="radio" name="payment_method" value="zalopay">
                        <div class="method-info">
                            <img src="assets/images/payments/zalopay.png" alt="ZaloPay">
                            <span>Ví ZaloPay</span>
                        </div>
                    </label>

                    <label class="method-item">
                        <input type="radio" name="payment_method" value="bank" onchange="toggleBankList(this.checked)">
                        <div class="method-info">
                            <img src="assets/images/payments/bank.png" alt="Bank">
                            <span>Chuyển khoản ngân hàng</span>
                        </div>
                    </label>

                    <!-- Danh sách ngân hàng -->
                    <div id="bank-list" class="bank-list" style="display: none;">
                        <div class="bank-grid">
                            <label class="bank-option">
                                <input type="radio" name="bank_code" value="vcb">
                                <img src="assets/images/payments/Banks/vcb.png" alt="Vietcombank">
                                <span>Vietcombank</span>
                            </label>

                            <label class="bank-option">
                                <input type="radio" name="bank_code" value="tcb">
                                <img src="assets/images/payments/Banks/tcb.png" alt="Techcombank">
                                <span>Techcombank</span>
                            </label>

                            <label class="bank-option">
                                <input type="radio" name="bank_code" value="mb">
                                <img src="assets/images/payments/Banks/mb.png" alt="MB Bank">
                                <span>MB Bank</span>
                            </label>

                            <label class="bank-option">
                                <input type="radio" name="bank_code" value="acb">
                                <img src="assets/images/payments/Banks/acb.png" alt="ACB">
                                <span>ACB</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng thanh toán -->
        <div class="order-summary">
            <div class="summary-row">
                <span>Tổng tiền hàng:</span>
                <span><?= number_format($totalAmount, 0, ',', '.') ?>đ</span>
            </div>
            <div class="summary-row">
                <span>Phí vận chuyển:</span>
                <span>Miễn phí</span>
            </div>
            <div class="summary-total">
                <span>Tổng thanh toán:</span>
                <span class="total-amount"><?= number_format($totalAmount, 0, ',', '.') ?>đ</span>
            </div>

            <form action="index.php?action=place-order" method="POST">
                <input type="hidden" name="total_amount" value="<?= $totalAmount ?>">
                <button type="submit" class="place-order-btn">
                    Đặt hàng
                </button>
            </form>
        </div>
    </div>

    <?php require_once "client/views/layout/footer.php"; ?>

    <!-- Thêm script -->
    <script>
        function toggleBankInfo(show) {
            const bankInfo = document.getElementById('bank-info');
            bankInfo.style.display = show ? 'block' : 'none';
        }

        function toggleAddressForm() {
            const defaultAddress = document.getElementById('default-address');
            const addressForm = document.getElementById('address-form');
            defaultAddress.style.display = defaultAddress.style.display === 'none' ? 'block' : 'none';
            addressForm.style.display = addressForm.style.display === 'none' ? 'block' : 'none';
        }

        function togglePaymentInfo(method) {
            const bankList = document.getElementById('bank-list');
            bankList.style.display = method === 'bank' ? 'block' : 'none';
        }

        function showBankInfo(bankCode) {
            const bankInfo = document.getElementById('bank-info');
            const bankDetails = getBankDetails(bankCode);

            bankInfo.innerHTML = `
                <div class="bank-details">
                    <h4>Thông tin chuyển khoản:</h4>
                    <p>Ngân hàng: <strong>${bankDetails.name}</strong></p>
                    <p>Số tài khoản: <strong>${bankDetails.accountNumber}</strong></p>
                    <p>Chủ tài khoản: <strong>${bankDetails.accountName}</strong></p>
                    <p>Chi nhánh: <strong>${bankDetails.branch}</strong></p>
                </div>
            `;
            bankInfo.style.display = 'block';
        }

        function getBankDetails(bankCode) {
            const banks = {
                vietcombank: {
                    name: 'Vietcombank',
                    accountNumber: '1234567890',
                    accountName: 'CONG TY TNHH CONG NGHE REALTECH',
                    branch: 'Chi nhánh Bà Rịa - Vũng Tàu'
                },
                techcombank: {
                    name: 'Techcombank',
                    accountNumber: '0987654321',
                    accountName: 'CONG TY TNHH CONG NGHE REALTECH',
                    branch: 'Chi nhánh Bà Rịa - Vũng Tàu'
                }
            };
            return banks[bankCode];
        }

        function toggleBankList(show) {
            const bankList = document.getElementById('bank-list');
            bankList.style.display = show ? 'block' : 'none';
        }

        // Thêm sự kiện cho việc chọn ngân hàng
        document.querySelectorAll('input[name="bank_code"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    // Hiển th�� thông tin ngân hàng tương ứng
                    showBankInfo(this.value);
                }
            });
        });
    </script>
</body>

</html>