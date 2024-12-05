-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 02, 2024 lúc 03:04 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duan1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `title`, `image_url`, `status`, `created_at`) VALUES
(1, 'Banner 1', 'b1.png', 1, '2024-11-16 14:19:01'),
(2, 'Banner 2', 'b2.png', 1, '2024-11-16 16:36:32'),
(3, 'Banner 3', 'b3.png', 1, '2024-11-16 16:36:53'),
(4, 'Banner 4', 'b4.png', 1, '2024-11-16 16:37:22'),
(5, 'Banner 5', 'b5.png', 1, '2024-11-16 16:37:54'),
(6, 'Banner 6', 'b6.png', 1, '2024-11-16 16:38:11'),
(7, 'Banner 7', 'b7.png', 1, '2024-11-21 16:03:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `import_date` date DEFAULT NULL,
  `storage_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `cate_id` int(11) NOT NULL,
  `cate_name` varchar(50) NOT NULL,
  `img` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cate_status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`cate_id`, `cate_name`, `img`, `description`, `cate_status`) VALUES
(1, 'iPhone 11', 'Uploads/Category/apple.webp', '', 1),
(3, 'iPhone 13', 'Uploads/Category/apple.webp', '', 1),
(4, 'iPhone 14', 'Uploads/Category/apple.webp', '', 1),
(5, 'iPhone 15', 'Uploads/Category/apple.webp', '', 1),
(6, 'iPhone 16', 'Uploads/Category/apple.webp', '', 1),
(7, 'iPhone 12', 'Uploads/Category/apple.webp', '', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `rating` int(1) NOT NULL DEFAULT 5,
  `content` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `import_date` datetime DEFAULT current_timestamp(),
  `cmt_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0: Chờ duyệt, 1: Đã duyệt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`com_id`, `rating`, `content`, `user_id`, `pro_id`, `import_date`, `cmt_status`) VALUES
(16, 5, 'Sản phẩm rất tốt, đóng gói cẩn thận', 3, 31, '2024-11-25 10:00:00', 1),
(17, 4, 'Máy đẹp, chụp ảnh sắc nét', 4, 31, '2024-11-26 15:30:00', 1),
(18, 5, 'Pin trâu, dùng rất bền', 5, 31, '2024-11-27 09:15:00', 1),
(19, 5, 'Màu xanh rất đẹp, rất hài lòng', 3, 32, '2024-11-25 11:20:00', 1),
(20, 4, 'Máy mượt, camera chụp đẹp', 4, 32, '2024-11-26 14:45:00', 1),
(21, 5, 'Giao hàng nhanh, sản phẩm chất lượng', 5, 32, '2024-11-27 16:30:00', 1),
(22, 5, 'Màu trắng sang trọng, rất thích', 3, 33, '2024-11-25 13:40:00', 1),
(23, 4, 'Hiệu năng tốt, pin trâu', 4, 33, '2024-11-26 17:20:00', 1),
(24, 5, 'Sản phẩm chính hãng, rất yên tâm', 5, 33, '2024-11-27 08:50:00', 1),
(25, 5, 'Bộ nhớ lớn, lưu trữ thoải mái', 3, 60, '2024-11-25 09:30:00', 1),
(26, 4, 'Thiết kế đẹp, cầm vừa tay', 4, 60, '2024-11-26 14:15:00', 1),
(27, 5, 'Camera chụp đêm rất tốt', 5, 60, '2024-11-27 16:45:00', 1),
(28, 5, 'Màu xanh biển rất độc đáo', 3, 61, '2024-11-25 10:45:00', 1),
(29, 4, 'Máy mượt, chơi game tốt', 4, 61, '2024-11-26 15:30:00', 1),
(30, 5, 'Rất hài lòng với sản phẩm', 5, 61, '2024-11-27 11:20:00', 1),
(31, 5, 'Dynamic Island rất tiện lợi', 3, 65, '2024-11-25 08:20:00', 1),
(32, 4, 'Pin trâu, sạc nhanh', 4, 65, '2024-11-26 13:40:00', 1),
(33, 5, 'Camera chụp rất đẹp', 5, 65, '2024-11-27 15:15:00', 1),
(34, 5, 'Màu trắng rất sang trọng', 3, 66, '2024-11-25 09:50:00', 1),
(35, 4, 'Máy mượt, không lag', 4, 66, '2024-11-26 14:25:00', 1),
(36, 5, 'Rất hài lòng với chất lượng', 5, 66, '2024-11-27 16:30:00', 1),
(37, 5, 'Máy chạy rất mượt, pin trâu', 3, 81, '2024-11-25 10:15:00', 1),
(38, 4, 'Camera chụp đẹp, màu sắc tự nhiên', 4, 81, '2024-11-26 15:45:00', 1),
(39, 5, 'Giao hàng nhanh, đóng gói cẩn thận', 5, 81, '2024-11-27 14:20:00', 1),
(40, 5, 'Màu trắng rất đẹp và sang trọng', 3, 82, '2024-11-25 11:30:00', 1),
(41, 4, 'Hiệu năng tốt, chơi game mượt', 4, 82, '2024-11-26 16:20:00', 1),
(42, 5, 'Sản phẩm chính hãng, rất uy tín', 5, 82, '2024-11-27 13:45:00', 1),
(43, 5, 'Màu đỏ rất nổi bật và đẹp', 3, 93, '2024-11-25 09:40:00', 1),
(44, 4, 'Máy chạy ổn định, pin tốt', 4, 93, '2024-11-26 14:50:00', 1),
(45, 5, 'Giá tốt, chất lượng đáng mua', 5, 93, '2024-11-27 16:15:00', 1),
(46, 5, 'Thiết kế đẹp, cầm vừa tay', 3, 94, '2024-11-25 10:55:00', 1),
(47, 4, 'Camera chụp đẹp, màu sắc tự nhiên', 4, 94, '2024-11-26 15:30:00', 1),
(48, 5, 'Rất hài lòng với sản phẩm', 5, 94, '2024-11-27 13:25:00', 1),
(49, 4, 'srbdrbdb', 1, 32, '2024-12-02 17:37:33', 0),
(50, 5, 'jyjyjyky', 1, 31, '2024-12-02 19:00:30', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_code` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiver_name` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `bank_code` varchar(50) DEFAULT NULL,
  `status` enum('pending','confirmed','processing','shipping','delivered','cancelled','returned','refunded','failed','awaiting_payment','return_requested') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `return_reason` text DEFAULT NULL,
  `return_request_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `user_id`, `receiver_name`, `total_amount`, `shipping_address`, `shipping_phone`, `shipping_email`, `bank_code`, `status`, `payment_method`, `payment_status`, `created_at`, `updated_at`, `return_reason`, `return_request_reason`) VALUES
(161, 'ORD1733054135', 1, 'Bùi Đức Dương', 21239700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-01 11:55:35', '2024-12-01 11:55:35', NULL, NULL),
(162, 'ORD1733076726', 1, 'Bùi Đức Dương', 52895900.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-01 18:12:06', '2024-12-01 18:12:06', NULL, NULL),
(163, 'ORD1733076951', 1, 'Bùi Đức Dương', 42935900.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-01 18:15:51', '2024-12-01 18:15:51', NULL, NULL),
(164, 'ORD1733130155', 1, 'Bùi Đức Dương', 48496900.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'returned', 'cod', 'unpaid', '2024-12-02 09:02:35', '2024-12-02 09:32:00', NULL, 'ukuikil'),
(165, 'ORD1733132022', 1, 'Bùi Đức Dương', 21239700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-02 09:33:42', '2024-12-02 09:34:22', NULL, 'dgnfgng'),
(166, 'ORD1733135313', 1, 'Bùi Đức Dương', 73679100.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-02 10:28:33', '2024-12-02 10:29:01', NULL, NULL),
(167, 'ORD1733135670', 1, 'Bùi Đức Dương', 21239700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'delivered', 'cod', 'unpaid', '2024-12-02 10:34:30', '2024-12-02 10:34:55', NULL, NULL),
(168, 'ORD1733135920', 1, 'Bùi Đức Dương', 31199700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'return_requested', 'cod', 'unpaid', '2024-12-02 10:38:40', '2024-12-02 10:39:09', NULL, 'egwrg'),
(169, 'ORD1733135967', 1, 'Bùi Đức Dương', 21239700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-02 10:39:27', '2024-12-02 10:39:31', NULL, NULL),
(170, 'ORD1733138356', 1, 'Bùi Đức Dương', 31199700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-02 11:19:16', '2024-12-02 11:19:16', NULL, NULL),
(171, 'ORD1733138377', 1, 'Bùi Đức Dương', 31199700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-02 11:19:37', '2024-12-02 11:37:51', NULL, 'rthrynyrn'),
(172, 'ORD1733140568', 1, 'Bùi Đức Dương', 43101900.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-02 11:56:08', '2024-12-02 11:56:17', NULL, NULL),
(173, 'ORD1733140587', 1, 'Bùi Đức Dương', 63312400.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-02 11:56:27', '2024-12-02 12:00:02', NULL, 'htjggj'),
(174, 'ORD1733141909', 1, 'Bùi Đức Dương', 21696200.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-02 12:18:29', '2024-12-02 12:18:29', NULL, NULL),
(177, 'ORD1733143880', 1, 'Bùi Đức Dương', 31199700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-02 12:51:20', '2024-12-02 12:51:20', NULL, NULL);

--
-- Bẫy `orders`
--
DELIMITER $$
CREATE TRIGGER `after_order_return_request` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    IF NEW.status = 'return_requested' AND OLD.status != 'return_requested' THEN
        INSERT INTO payment_logs (order_id, payment_type, status, message)
        VALUES (NEW.order_id, 'return', 'pending', CONCAT('Yêu cầu trả hàng: ', NEW.return_request_reason));
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(158, 161, 32, 1, 21239700.00),
(159, 162, 35, 1, 21696200.00),
(160, 162, 39, 1, 31199700.00),
(161, 163, 32, 1, 21239700.00),
(162, 163, 35, 1, 21696200.00),
(163, 164, 39, 1, 31199700.00),
(164, 164, 47, 1, 17297200.00),
(165, 165, 33, 1, 21239700.00),
(166, 166, 39, 1, 31199700.00),
(167, 166, 32, 2, 21239700.00),
(168, 167, 33, 1, 21239700.00),
(169, 168, 39, 1, 31199700.00),
(170, 169, 32, 1, 21239700.00),
(171, 170, 39, 1, 31199700.00),
(172, 171, 39, 1, 31199700.00),
(173, 172, 44, 1, 16840700.00),
(174, 172, 64, 1, 26261200.00),
(175, 173, 40, 2, 31656200.00),
(176, 174, 35, 1, 21696200.00),
(181, 177, 37, 1, 31199700.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `pay_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `import_date` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1,
  `total` int(11) DEFAULT NULL,
  `pay_method` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_logs`
--

INSERT INTO `payment_logs` (`id`, `order_id`, `payment_type`, `status`, `message`, `created_at`) VALUES
(20, 164, 'return', 'pending', 'Yêu cầu trả hàng: ukuikil', '2024-12-02 09:31:42'),
(21, 165, 'return', 'pending', 'Yêu cầu trả hàng: dgnfgng', '2024-12-02 09:34:16'),
(22, 168, 'return', 'pending', 'Yêu cầu trả hàng: egwrg', '2024-12-02 10:39:09'),
(23, 171, 'return', 'pending', 'Yêu cầu trả hàng: rthrynyrn', '2024-12-02 11:37:41'),
(24, 173, 'return', 'pending', 'Yêu cầu trả hàng: htjggj', '2024-12-02 11:59:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `img` varchar(255) NOT NULL,
  `import_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pro_view` int(11) DEFAULT 0,
  `pro_status` tinyint(1) DEFAULT 1,
  `cate_id` int(11) NOT NULL,
  `storage_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `price`, `quantity`, `img`, `import_date`, `description`, `pro_view`, `pro_status`, `cate_id`, `storage_id`, `color_id`) VALUES
(31, 'IPhone 16 256Gb Mới chính hãng', 21490000, 5, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 2, 1),
(32, 'IPhone 16 256Gb Mới chính hãng', 21490000, 35, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 2, 4),
(33, 'IPhone 16 256Gb Mới chính hãng', 21490000, 40, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 2, 2),
(34, 'IPhone 16 256Gb Mới chính hãng', 21490000, 50, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 2, 5),
(35, 'IPhone 16 256Gb Mới chính hãng', 21490000, 43, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 2, 6),
(36, 'IPhone 16 512Gb Mới chính hãng', 27490000, 50, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 3, 1),
(37, 'IPhone 16 512Gb Mới chính hãng', 27490000, 45, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 3, 2),
(38, 'IPhone 16 512Gb Mới chính hãng', 27490000, 47, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 3, 5),
(39, 'IPhone 16 512Gb Mới chính hãng', 27490000, 43, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 3, 4),
(40, 'IPhone 16 512Gb Mới chính hãng', 27490000, 48, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 3, 6),
(41, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 1, 1),
(42, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 1, 2),
(43, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 1, 5),
(44, 'IPhone 16 128Gb Mới chính hãng', 19190000, 49, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 1, 4),
(47, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 1, 6),
(60, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 den.png', '2024-11-28', '', 0, 1, 5, 3, 1),
(61, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 xanhbien.png', '2024-11-28', '', 0, 1, 5, 3, 10),
(62, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 xanhla.png', '2024-11-28', '', 0, 1, 5, 3, 11),
(63, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 vang.png', '2024-11-28', '', 0, 1, 5, 3, 12),
(64, 'IPhone 15 512Gb Mới chính hãng', 20990000, 49, 'iphone15 hong.png', '2024-11-28', '', 0, 1, 5, 3, 6),
(65, 'IPhone 14 128Gb Mới chính hãng', 24490000, 50, 'iphone14pm den.png', '2024-11-28', '', 0, 1, 4, 1, 1),
(66, 'IPhone 14 128Gb Mới chính hãng', 24490000, 50, 'iphone14pm trang.png', '2024-11-28', '', 0, 1, 4, 1, 2),
(67, 'IPhone 14 128Gb Mới chính hãng', 24490000, 50, 'iphone14pm vangkim.png', '2024-11-28', '', 0, 1, 4, 1, 3),
(68, 'IPhone 14 128Gb Mới chính hãng', 24490000, 50, 'iphone14pm tim.png', '2024-11-28', '', 0, 1, 4, 1, 13),
(69, 'IPhone 14 Pro Max 256Gb Mới chính hãng', 26590000, 50, 'iphone14pm den.png', '2024-11-28', '', 0, 1, 4, 2, 1),
(70, 'IPhone 14 Pro Max 256Gb Mới chính hãng', 26590000, 50, 'iphone14pm trang.png', '2024-11-28', '', 0, 1, 4, 2, 2),
(71, 'IPhone 14 Pro Max 256Gb Mới chính hãng', 26590000, 50, 'iphone14pm vangkim.png', '2024-11-28', '', 0, 1, 4, 2, 3),
(72, 'IPhone 14 Pro Max 256Gb Mới chính hãng', 26590000, 50, 'iphone14pm tim.png', '2024-11-28', '', 0, 1, 4, 2, 13),
(73, 'IPhone 14 Pro Max 512Gb Mới chính hãng', 28190000, 50, 'iphone14pm den.png', '2024-11-28', '', 0, 1, 4, 3, 1),
(74, 'IPhone 14 Pro Max 512Gb Mới chính hãng', 28190000, 50, 'iphone14pm trang.png', '2024-11-28', '', 0, 1, 4, 3, 2),
(75, 'IPhone 14 Pro Max 512Gb Mới chính hãng', 28190000, 50, 'iphone14pm vangkim.png', '2024-11-28', '', 0, 1, 4, 3, 3),
(76, 'IPhone 14 Pro Max 512Gb Mới chính hãng', 28190000, 50, 'iphone14pm tim.png', '2024-11-28', '', 0, 1, 4, 3, 13),
(77, 'IPhone 14 Pro Max 1Tb Mới chính hãng', 30040000, 50, 'iphone14pm den.png', '2024-11-28', '', 0, 1, 4, 5, 1),
(78, 'IPhone 14 Pro Max 1Tb Mới chính hãng', 30040000, 50, 'iphone14pm trang.png', '2024-11-28', '', 0, 1, 4, 5, 2),
(79, 'IPhone 14 Pro Max 1Tb Mới chính hãng', 30040000, 50, 'iphone14pm vangkim.png', '2024-11-28', '', 0, 1, 4, 5, 3),
(80, 'IPhone 14 Pro Max 1Tb Mới chính hãng', 30040000, 50, 'iphone14pm tim.png', '2024-11-28', '', 0, 1, 4, 5, 13),
(81, 'IPhone 13 Pro Max 128Gb Mới chính hãng', 26390000, 50, 'iphone13pm den.png', '2024-11-28', '', 0, 1, 3, 1, 1),
(82, 'IPhone 13 Pro Max 128Gb Mới chính hãng', 26390000, 50, 'iphone13pm trang.png', '2024-11-28', '', 0, 1, 3, 1, 2),
(83, 'IPhone 13 Pro Max 128Gb Mới chính hãng', 26390000, 50, 'iphone13pm vangkim.png', '2024-11-28', '', 0, 1, 3, 1, 3),
(84, 'IPhone 13 Pro Max 128Gb Mới chính hãng', 26390000, 50, 'iphone13pm xanh.png', '2024-11-28', '', 0, 1, 3, 1, 10),
(85, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm den.png', '2024-11-28', '', 0, 1, 3, 2, 1),
(86, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm trang.png', '2024-11-28', '', 0, 1, 3, 2, 2),
(87, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm vangkim.png', '2024-11-28', '', 0, 1, 3, 2, 3),
(88, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm xanh.png', '2024-11-28', '', 0, 1, 3, 2, 10),
(89, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm den.png', '2024-11-28', '', 0, 1, 3, 3, 1),
(90, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm trang.png', '2024-11-28', '', 0, 1, 3, 3, 2),
(91, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 47, 'iphone13pm vangkim.png', '2024-11-28', '', 0, 1, 3, 3, 3),
(92, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm xanh.png', '2024-11-28', '', 0, 1, 3, 3, 10),
(93, 'IPhone 12 128Gb Mới chính hãng', 13290000, 50, 'iphone12 do.png', '2024-11-28', '', 0, 1, 7, 1, 7),
(94, 'IPhone 12 128Gb Mới chính hãng', 13290000, 50, 'iphone12 trang.png', '2024-11-28', '', 0, 1, 7, 1, 2),
(95, 'IPhone 12 128Gb Mới chính hãng', 13290000, 50, 'iphone12 tím.png', '2024-11-28', '', 0, 1, 7, 1, 13),
(96, 'IPhone 12 128Gb Mới chính hãng', 13290000, 50, 'iphone12 xanh.png', '2024-11-28', '', 0, 1, 7, 1, 11),
(97, 'IPhone 12 256Gb Mới chính hãng', 16490000, 50, 'iphone12 do.png', '2024-11-28', '', 0, 1, 7, 2, 7),
(98, 'IPhone 12 256Gb Mới chính hãng', 16490000, 50, 'iphone12 trang.png', '2024-11-28', '', 0, 1, 7, 2, 2),
(99, 'IPhone 12 256Gb Mới chính hãng', 16490000, 50, 'iphone12 tím.png', '2024-11-28', '', 0, 1, 7, 2, 13),
(100, 'IPhone 12 256Gb Mới chính hãng', 16490000, 50, 'iphone12 xanh.png', '2024-11-28', '', 0, 1, 7, 2, 11),
(101, 'IPhone 12 64Gb Mới chính hãng', 11990000, 50, 'iphone12 do.png', '2024-11-28', '', 0, 1, 7, 4, 7),
(102, 'IPhone 12 64Gb Mới chính hãng', 11990000, 50, 'iphone12 trang.png', '2024-11-28', '', 0, 1, 7, 4, 2),
(103, 'IPhone 12 64Gb Mới chính hãng', 11990000, 50, 'iphone12 tím.png', '2024-11-28', '', 0, 1, 7, 4, 13),
(104, 'IPhone 12 64Gb Mới chính hãng', 11990000, 50, 'iphone12 xanh.png', '2024-11-28', '', 0, 1, 7, 4, 11),
(105, 'IPhone 11 64Gb Mới chính hãng', 8990000, 50, 'iphone11 trang.png', '2024-11-28', '', 0, 1, 1, 4, 2),
(106, 'IPhone 11 64Gb Mới chính hãng', 8990000, 50, 'iphone11 do.png', '2024-11-28', '', 0, 1, 1, 4, 7),
(107, 'IPhone 11 128Gb Mới chính hãng', 10290000, 50, 'iphone11 do.png', '2024-11-28', '', 0, 1, 1, 1, 7),
(108, 'IPhone 11 128Gb Mới chính hãng', 10290000, 50, 'iphone11 trang.png', '2024-11-28', '', 0, 1, 1, 1, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_color`
--

CREATE TABLE `product_color` (
  `color_id` int(11) NOT NULL,
  `color_type` varchar(50) NOT NULL,
  `color_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_color`
--

INSERT INTO `product_color` (`color_id`, `color_type`, `color_price`, `created_at`) VALUES
(1, 'Đen', 0.00, '2024-11-12 13:16:16'),
(2, 'Trắng', 1100000.00, '2024-11-12 13:16:16'),
(3, 'Vàng Kim', 500000.00, '2024-11-12 13:16:16'),
(4, 'Xanh Lưu Ly', 1100000.00, '2024-11-16 10:08:22'),
(5, 'Xanh Mòng Két', 1050000.00, '2024-11-16 10:08:35'),
(6, 'Hồng', 1650000.00, '2024-11-16 10:08:57'),
(7, 'Đỏ', 0.00, '2024-11-16 10:27:38'),
(10, 'Xanh Biển', 300000.00, '2024-11-28 04:20:00'),
(11, 'Xanh Lá', 300000.00, '2024-11-28 04:21:13'),
(12, 'Vàng', 300000.00, '2024-11-28 04:22:18'),
(13, 'Tím', 0.00, '2024-11-28 04:30:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_deals`
--

CREATE TABLE `product_deals` (
  `deal_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `discount` decimal(5,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_deals`
--

INSERT INTO `product_deals` (`deal_id`, `pro_id`, `discount`, `start_date`, `end_date`, `status`) VALUES
(246, 96, 25.00, '2024-12-20', '2025-01-03', 1),
(247, 93, 25.00, '2024-12-20', '2025-01-03', 1),
(248, 95, 25.00, '2024-12-20', '2025-01-03', 1),
(249, 94, 25.00, '2024-12-20', '2025-01-03', 1),
(250, 99, 25.00, '2024-12-20', '2025-01-03', 1),
(251, 98, 25.00, '2024-12-20', '2025-01-03', 1),
(252, 100, 25.00, '2024-12-20', '2025-01-03', 1),
(253, 97, 25.00, '2024-12-20', '2025-01-03', 1),
(254, 104, 25.00, '2024-12-20', '2025-01-03', 1),
(255, 101, 25.00, '2024-12-20', '2025-01-03', 1),
(256, 103, 25.00, '2024-12-20', '2025-01-03', 1),
(257, 102, 25.00, '2024-12-20', '2025-01-03', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_storage`
--

CREATE TABLE `product_storage` (
  `storage_id` int(11) NOT NULL,
  `storage_type` varchar(50) NOT NULL,
  `storage_price` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_storage`
--

INSERT INTO `product_storage` (`storage_id`, `storage_type`, `storage_price`, `created_at`) VALUES
(1, '128GB', 0.00, '2024-11-12 13:16:16'),
(2, '256GB', 3000000.00, '2024-11-12 13:16:16'),
(3, '512GB', 9000000.00, '2024-11-12 13:16:16'),
(4, '64GB', 0.00, '2024-11-17 09:53:31'),
(5, '1TB', 15000000.00, '2024-11-17 14:19:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `return_items`
--

CREATE TABLE `return_items` (
  `return_item_id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `condition_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `return_requests`
--

CREATE TABLE `return_requests` (
  `request_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason` text NOT NULL,
  `images` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `processed_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `return_requests`
--

INSERT INTO `return_requests` (`request_id`, `order_id`, `user_id`, `request_date`, `reason`, `images`, `status`, `admin_note`, `processed_date`) VALUES
(4, 164, 1, '2024-12-02 09:32:00', '', NULL, 'approved', 'jmuu', '2024-12-02 09:32:00'),
(5, 165, 1, '2024-12-02 09:34:22', '', NULL, 'rejected', 'mghm', '2024-12-02 09:34:22'),
(6, 171, 1, '2024-12-02 11:37:51', '', NULL, 'rejected', 'rehet', '2024-12-02 11:37:51'),
(7, 173, 1, '2024-12-02 12:00:02', '', NULL, 'rejected', 'fntt', '2024-12-02 12:00:02');

--
-- Bẫy `return_requests`
--
DELIMITER $$
CREATE TRIGGER `after_return_approved` AFTER UPDATE ON `return_requests` FOR EACH ROW BEGIN
    IF NEW.status = 'approved' AND OLD.status != 'approved' THEN
        -- Cập nhật số lượng sản phẩm
        UPDATE products p
        INNER JOIN return_items ri ON ri.product_id = p.pro_id
        SET p.quantity = p.quantity + ri.quantity
        WHERE ri.request_id = NEW.request_id;
        
        -- Cập nhật trạng thái đơn hàng
        UPDATE orders 
        SET status = 'returned'
        WHERE order_id = NEW.order_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`, `description`, `created_at`) VALUES
(1, 'Admin', 'Quản trị viên hệ thống', '2024-11-12 20:16:16'),
(2, 'User', 'Người dùng thông thường', '2024-11-12 20:16:16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thumbnails`
--

CREATE TABLE `thumbnails` (
  `thumb_id` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `thumb_status` tinyint(1) DEFAULT 1,
  `pro_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `transaction_code` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(20) NOT NULL COMMENT 'momo, zalopay, bank_transfer',
  `bank_code` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending' COMMENT 'pending, completed, failed, refunded',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `birthday` date DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL COMMENT '0: Nữ, 1: Nam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `fullname`, `phone`, `address`, `avatar`, `role_id`, `status`, `created_at`, `birthday`, `gender`) VALUES
(1, 'Sora', 'sora123', 'soramidori843@gmail.com', 'Bùi Đức Dương', '0355032605', 'Thanh Liêm-Hà Nam', 'Uploads/User/Sora.jpg', 1, 1, '2024-11-13 07:46:27', '1990-01-01', 1),
(2, 'duongbd', 'duong123', 'duongbdph50213@gmail.com', 'sfafasdzxv', '09987667656', 'văn khúc, cẩm khê, nckdj,gfgf', 'Uploads/User/user.png', 2, 1, '2024-11-17 21:00:12', NULL, NULL),
(3, 'nguyenthanhnam', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'thanhnam@gmail.com', 'Nguyễn Thành Nam', '0912345678', 'Quận 1, TP.HCM', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(4, 'tranthihuong', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'huong.tran@gmail.com', 'Trần Thị Hương', '0923456789', 'Cầu Giấy, Hà Nội', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(5, 'levanminh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'minhle@gmail.com', 'Lê Văn Minh', '0934567890', 'Hải Châu, Đà Nẵng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(6, 'phamthi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hoapham@gmail.com', 'Phạm Thị Hoa', '0945678901', 'Ninh Kiều, Cần Thơ', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(7, 'hoangvantuan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tuanhoang@gmail.com', 'Hoàng Văn Tuấn', '0956789012', 'Ngô Quyền, Hải Phòng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(8, 'nguyenthilan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lan.nguyen@gmail.com', 'Nguyễn Thị Lan', '0967890123', 'Lê Chân, Hải Phòng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(9, 'vuducmanh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manhvu@gmail.com', 'Vũ Đức Mạnh', '0978901234', 'Thanh Xuân, Hà Nội', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(10, 'tranthihien', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hientran@gmail.com', 'Trần Thị Hiền', '0989012345', 'Sơn Trà, Đà Nẵng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(20, 'kien', '1', 'kien49182@gmail.com', 'đỗ trung kiên ', '0998766765633', 'văn khúc ', 'Uploads/User/nam.jpg', 1, 1, '2024-11-25 09:10:43', NULL, NULL),
(21, 'kienneeee', '1', 'kiennenennen@gmail.com', 'kiên', '0998766777', 'văn khúc', 'Uploads/User/nam.jpg', 2, 1, '2024-11-26 10:40:54', '2014-11-14', 1),
(22, '', '1', 'mm@gmail.com', 'đỗ trung kiên ', '03777777777', 'văn khúc , cẩm khê , phú thọ ', NULL, 2, 1, '2024-11-30 11:36:05', '2024-11-13', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pro_id` (`pro_id`),
  ADD KEY `storage_id` (`storage_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cate_id`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`pay_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `cate_id` (`cate_id`),
  ADD KEY `storage_id` (`storage_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Chỉ mục cho bảng `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`color_id`);

--
-- Chỉ mục cho bảng `product_deals`
--
ALTER TABLE `product_deals`
  ADD PRIMARY KEY (`deal_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Chỉ mục cho bảng `product_storage`
--
ALTER TABLE `product_storage`
  ADD PRIMARY KEY (`storage_id`);

--
-- Chỉ mục cho bảng `return_items`
--
ALTER TABLE `return_items`
  ADD PRIMARY KEY (`return_item_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Chỉ mục cho bảng `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD PRIMARY KEY (`thumb_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_code_UNIQUE` (`transaction_code`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT cho bảng `product_color`
--
ALTER TABLE `product_color`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `product_deals`
--
ALTER TABLE `product_deals`
  MODIFY `deal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT cho bảng `product_storage`
--
ALTER TABLE `product_storage`
  MODIFY `storage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `return_items`
--
ALTER TABLE `return_items`
  MODIFY `return_item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `thumbnails`
--
ALTER TABLE `thumbnails`
  MODIFY `thumb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`),
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`storage_id`) REFERENCES `product_storage` (`storage_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cart_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `product_color` (`color_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`pro_id`);

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `categories` (`cate_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`storage_id`) REFERENCES `product_storage` (`storage_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `product_color` (`color_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `product_deals`
--
ALTER TABLE `product_deals`
  ADD CONSTRAINT `product_deals_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`);

--
-- Các ràng buộc cho bảng `return_items`
--
ALTER TABLE `return_items`
  ADD CONSTRAINT `return_items_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `return_requests` (`request_id`),
  ADD CONSTRAINT `return_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`pro_id`);

--
-- Các ràng buộc cho bảng `return_requests`
--
ALTER TABLE `return_requests`
  ADD CONSTRAINT `return_requests_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `return_requests_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD CONSTRAINT `thumbnails_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`);

--
-- Các ràng buộc cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
