CREATE DATABASE du_an_1;
USE du_an_1;

CREATE TABLE danhmuc (
	danh_muc_id INT(11) AUTO_INCREMENT PRIMARY KEY,
	ten_danh_muc VARCHAR(50) NOT NULL,
  hinh VARCHAR(255) NOT NULL
);

CREATE TABLE sanpham (
  san_pham_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten_san_pham VARCHAR(50) NOT NULL,
  gia INT NOT NULL,
  hinh VARCHAR(255) NOT NULL,
  ngay_nhap DATE,
  mo_ta TEXT,
  so_luot_xem INT(11) DEFAULT 0,
  danh_muc_id INT(11) NOT NULL,
  FOREIGN KEY (danh_muc_id) REFERENCES danhmuc(danh_muc_id)
);

CREATE TABLE taikhoan (
  tai_khoan_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ho_va_ten VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL,
  mat_khau VARCHAR(50) NOT NULL,
  dia_chi VARCHAR(255),
  so_dien_thoai VARCHAR(20) NOT NULL,
  gioi_tinh TINYINT(1) NOT NULL,
  hinh VARCHAR(255),
  vai_tro TINYINT(1) DEFAULT 0
);

CREATE TABLE slide (
    slides_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    img VARCHAR(255) NOT NULL,
    trang_thai TINYINT(1) DEFAULT 1,
    san_pham_id INT(11) NOT NULL,
    FOREIGN KEY (san_pham_id) REFERENCES sanpham(san_pham_id)
);


CREATE TABLE binhluan (
  binhluanid INT(11) AUTO_INCREMENT PRIMARY KEY,
  noi_dung VARCHAR(255) NOT NULL,
  tai_khoan_id INT(11) NOT NULL,
  san_pham_id INT(11) NOT NULL,
  ngay_binh_luan DATETIME,
  FOREIGN KEY (tai_khoan_id) REFERENCES taikhoan(tai_khoan_id),
  FOREIGN KEY (san_pham_id) REFERENCES sanpham(san_pham_id)
);

CREATE TABLE donhang (
  don_hang_id INT(11) PRIMARY KEY AUTO_INCREMENT,
  tai_khoan_id INT(11) NOT NULL,
  ho_va_ten VARCHAR(50) NOT NULL,
  dia_chi VARCHAR(255),
  so_dien_thoai VARCHAR(20) NOT NULL,
  email VARCHAR(255) NOT NULL,
  ngay_dat DATE,
  tong_tien INT,
  phuong_thuc_thanh_toan TINYINT(1) DEFAULT 1,
  trang_thai TINYINT(1) DEFAULT 1,
  FOREIGN KEY (tai_khoan_id) REFERENCES taikhoan(tai_khoan_id)
);

CREATE TABLE chitietdonhang (
  chi_tiet_don_hang_id INT(11) PRIMARY KEY AUTO_INCREMENT,
  don_hang_id INT(11) NOT NULL,
  san_pham_id INT(11) NOT NULL,
  so_luong INT NOT NULL,
  gia INT NOT NULL,
  tong_tien INT,
  FOREIGN KEY (don_hang_id) REFERENCES donhang(don_hang_id),
  FOREIGN KEY (san_pham_id) REFERENCES sanpham(san_pham_id)
);

CREATE TABLE giohang (
  gio_hang_id INT(11) PRIMARY KEY AUTO_INCREMENT,
  tai_khoan_id INT(11) NOT NULL,
  san_pham_id INT(11) NOT NULL,
  so_luong INT NOT NULL,
  FOREIGN KEY (tai_khoan_id) REFERENCES taikhoan(tai_khoan_id),
  FOREIGN KEY (san_pham_id) REFERENCES sanpham(san_pham_id)
);