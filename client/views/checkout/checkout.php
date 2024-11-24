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
                        <form id="shipping-form" onsubmit="updateAddress(event)">
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

        <!-- Thêm phần hiển thị sản phẩm -->
        <div class="order-products">
            <h2><i class="fas fa-shopping-cart"></i> HyperStore Official</h2>
            <div class="products-list">
                <?php foreach ($selectedProducts as $product): ?>
                    <div class="product-item">
                        <a href="index.php?action=product-detail&id=<?= $product['pro_id'] ?>" class="product-link">
                            <div class="product-image">
                                <img src="<?= $product['img'] ? 'Uploads/Product/' . $product['img'] : 'assets/images/no-image.png' ?>"
                                    alt="<?= htmlspecialchars($product['pro_name']) ?>">
                            </div>
                            <div class="product-details">
                                <h3><?= htmlspecialchars($product['pro_name']) ?></h3>
                                <p class="product-variant">
                                    Phân loại: <?= htmlspecialchars($product['storage_type']) ?>
                                </p>
                                <p class="product-quantity">x<?= $product['quantity'] ?></p>
                            </div>
                            <div class="product-price">
                                <?= number_format($product['price'], 0, ',', '.') ?>đ
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Form thanh toán chính -->
        <form action="index.php?action=process-payment" method="POST" id="checkout-form"
            onsubmit="return validateForm()">
            <input type="hidden" name="total_amount" value="<?= $totalAmount ?>">
            <input type="hidden" name="payment_method" id="payment_method" value="cod">
            <input type="hidden" name="selected_bank_code" id="selected_bank_code" value="">

            <!-- Thêm các trường ẩn cho thông tin người nhận -->
            <input type="hidden" name="receiver_name" value="<?= htmlspecialchars($userAddress['receiver_name']) ?>">
            <input type="hidden" name="shipping_phone" value="<?= htmlspecialchars($userAddress['phone']) ?>">

            <!-- Thêm sản phẩm vào form -->
            <?php foreach ($selectedProducts as $product): ?>
                <input type="hidden" name="products[]" value='<?= json_encode([
                                                                    "id" => $product["pro_id"],
                                                                    "quantity" => $product["quantity"],
                                                                    "price" => $product["price"]
                                                                ]) ?>'>
            <?php endforeach; ?>

            <!-- Phương thức thanh toán -->
            <div class="payment-methods">
                <h3>Phương Thức Thanh Toán</h3>
                <div class="method-options">
                    <label class="method-item">
                        <input type="radio" name="payment_method" value="cod" checked>
                        <div class="method-info">
                            <img src="Uploads/Payment/cod.png" alt="COD">
                            <span>Thanh toán khi nhận hàng</span>
                        </div>
                    </label>
                    <label class="method-item">
                        <input type="radio" name="payment_method" value="momo">
                        <div class="method-info">
                            <img src="Uploads/Payment/momo.png" alt="MoMo">
                            <span>Ví MoMo</span>
                        </div>
                    </label>
                    <label class="method-item">
                        <input type="radio" name="payment_method" value="zalopay">
                        <div class="method-info">
                            <img src="Uploads/Payment/zalopay.png" alt="ZaloPay">
                            <span>Ví ZaloPay</span>
                        </div>
                    </label>
                    <label class="method-item">
                        <input type="radio" name="payment_method" value="bank_transfer">
                        <div class="method-info">
                            <img src="Uploads/Payment/bank-transfer.png" alt="Bank Transfer">
                            <span>Chuyển khoản ngân hàng</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Danh sách ngân hàng -->
            <div id="bank-list" style="display: none;" class="bank-options">
                <h4>Chọn Ngân Hàng</h4>
                <div class="bank-list">
                    <label class="bank-item">
                        <input type="radio" name="bank_code" value="vcb">
                        <div class="bank-info">
                            <img src="Uploads/Payment/Banks/vcb.png" alt="Vietcombank">
                            <span>Vietcombank</span>
                        </div>
                    </label>
                    <label class="bank-item">
                        <input type="radio" name="bank_code" value="tcb">
                        <div class="bank-info">
                            <img src="Uploads/Payment/Banks/tcb.png" alt="Techcombank">
                            <span>Techcombank</span>
                        </div>
                    </label>
                    <label class="bank-item">
                        <input type="radio" name="bank_code" value="mb">
                        <div class="bank-info">
                            <img src="Uploads/Payment/Banks/mb.png" alt="MB Bank">
                            <span>MB Bank</span>
                        </div>
                    </label>
                    <label class="bank-item">
                        <input type="radio" name="bank_code" value="acb">
                        <div class="bank-info">
                            <img src="Uploads/Payment/Banks/acb.png" alt="ACB">
                            <span>ACB</span>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="checkout-button">Đặt hàng</button>
        </form>
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
                    document.getElementById('selected_bank_code').value = this.value;
                    document.querySelector('input[name="payment_method"][value="bank_transfer"]').checked =
                        true;
                }
            });
        });

        function updateAddress(event) {
            event.preventDefault();
            const form = document.getElementById('shipping-form');
            const formData = new FormData(form);

            // Cập nhật thông tin địa chỉ hiển thị
            const defaultAddress = document.getElementById('default-address');
            defaultAddress.querySelector('.name').textContent =
                `${formData.get('receiver_name')} | ${formData.get('phone')}`;
            defaultAddress.querySelector('.address').textContent = formData.get('address');

            toggleAddressForm();
        }

        // Thêm validation form
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            const bankTransfer = document.querySelector('input[name="payment_method"][value="bank_transfer"]');
            if (bankTransfer.checked) {
                const selectedBank = document.querySelector('input[name="bank_code"]:checked');
                if (!selectedBank) {
                    e.preventDefault();
                    alert('Vui lòng chọn ngân hàng để thanh toán');
                }
            }
        });

        // Cập nhật đường dẫn ảnh ngân hàng

        // Thêm event listener cho radio buttons
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('payment_method').value = this.value;
                if (this.value === 'bank_transfer') {
                    toggleBankList(true);
                } else {
                    toggleBankList(false);
                    document.getElementById('bank-info').style.display = 'none';
                }
            });
        });

        function validateForm() {
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                alert('Vui lòng chọn phương thức thanh toán');
                return false;
            }

            if (paymentMethod.value === 'bank_transfer') {
                const selectedBank = document.querySelector('input[name="bank_code"]:checked');
                if (!selectedBank) {
                    alert('Vui lòng chọn ngân hàng để thanh toán');
                    return false;
                }
            }

            // Validate products
            const products = document.querySelectorAll('input[name="products[]"]');
            if (products.length === 0) {
                alert('Giỏ hàng trống');
                return false;
            }

            return true;
        }
    </script>
</body>

</html>