-- Bảng danh_muc
CREATE TABLE danh_muc (
    danh_muc_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ten_danh_muc VARCHAR(50) NOT NULL,
    hinh VARCHAR(255) NOT NULL,
    mo_ta TEXT,  -- Thêm mô tả cho danh mục
    trang_thai TINYINT(1) DEFAULT 1  -- Trạng thái kích hoạt của danh mục
);

-- Bảng san_pham
CREATE TABLE san_pham (
    san_pham_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ten_san_pham VARCHAR(50) NOT NULL,
    gia INT NOT NULL,
    hinh VARCHAR(255) NOT NULL,
    ngay_nhap DATE,
    mo_ta TEXT,
    so_luot_xem INT(11) DEFAULT 0,
    trang_thai TINYINT(1) DEFAULT 1,  -- Trạng thái của sản phẩm (còn bán hay không)
    danh_muc_id INT(11) NOT NULL,
    FOREIGN KEY (danh_muc_id) REFERENCES danh_muc(danh_muc_id)
);

-- Bảng tai_khoan
CREATE TABLE tai_khoan (
    tai_khoan_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    ho_va_ten VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    mat_khau VARCHAR(50) NOT NULL,
    dia_chi VARCHAR(255),
    so_dien_thoai VARCHAR(20) NOT NULL,
    gioi_tinh TINYINT(1) NOT NULL,
    hinh VARCHAR(255),
    vai_tro TINYINT(1) DEFAULT 0,  -- Vai trò (0: Khách hàng, 1: Quản trị viên)
    ngay_dang_ky DATE DEFAULT NULL,  -- Ngày đăng ký tài khoản
    trang_thai TINYINT(1) DEFAULT 1  -- Trạng thái tài khoản (hoạt động hoặc bị khóa)
);

-- Bảng slides
CREATE TABLE slides (
    slides_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    img VARCHAR(255) NOT NULL,
    trang_thai TINYINT(1) DEFAULT 1,
    vi_tri INT(11),  -- Thứ tự hiển thị của slide
    san_pham_id INT(11) NOT NULL,
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(san_pham_id)
);

-- Bảng binh_luan
CREATE TABLE binh_luan (
    binh_luan_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    noi_dung VARCHAR(255) NOT NULL,
    tai_khoan_id INT(11) NOT NULL,
    san_pham_id INT(11) NOT NULL,
    ngay_binh_luan DATETIME DEFAULT CURRENT_TIMESTAMP,
    trang_thai TINYINT(1) DEFAULT 1,  -- Trạng thái bình luận (đã duyệt hoặc chưa duyệt)
    FOREIGN KEY (tai_khoan_id) REFERENCES tai_khoan(tai_khoan_id),
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(san_pham_id)
);

-- Bảng don_hang
CREATE TABLE don_hang (
    don_hang_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    tai_khoan_id INT(11) NOT NULL,
    ho_va_ten VARCHAR(50) NOT NULL,
    dia_chi VARCHAR(255),
    so_dien_thoai VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    ngay_dat DATE DEFAULT NULL,  -- Ngày đặt mặc định là NULL
    tong_tien INT,
    phuong_thuc_thanh_toan TINYINT(1) DEFAULT 1,  -- Phương thức thanh toán (1: Tiền mặt, 2: Thẻ)
    trang_thai TINYINT(1) DEFAULT 1,  -- Trạng thái đơn hàng (1: Đang xử lý, 2: Đã hoàn thành)
    ngay_xu_ly DATE,  -- Ngày xử lý đơn hàng
    FOREIGN KEY (tai_khoan_id) REFERENCES tai_khoan(tai_khoan_id)
);

-- Bảng chi_tiet_don_hang
CREATE TABLE chi_tiet_don_hang (
    chi_tiet_don_hang_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    don_hang_id INT(11) NOT NULL,
    san_pham_id INT(11) NOT NULL,
    so_luong INT NOT NULL,
    gia INT NOT NULL,
    tong_tien INT,
    khuyen_mai INT DEFAULT 0,  -- Giảm giá cho sản phẩm nếu có
    FOREIGN KEY (don_hang_id) REFERENCES don_hang(don_hang_id),
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(san_pham_id)
);

-- Bảng gio_hang
CREATE TABLE gio_hang (
    gio_hang_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    tai_khoan_id INT(11) NOT NULL,
    san_pham_id INT(11) NOT NULL,
    so_luong INT NOT NULL,
    ngay_them_vao DATE DEFAULT NULL,  -- Ngày thêm sản phẩm vào giỏ hàng
    FOREIGN KEY (tai_khoan_id) REFERENCES tai_khoan(tai_khoan_id),
    FOREIGN KEY (san_pham_id) REFERENCES san_pham(san_pham_id)
);
