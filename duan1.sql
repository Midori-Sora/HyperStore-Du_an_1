-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 05, 2024 lúc 10:03 PM
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
(1, 'Banner 1', 's1.png', 1, '2024-12-05 18:17:56'),
(2, 'Banner 2', 's2.png', 1, '2024-12-05 18:18:11'),
(3, 'Banner 3', 's3.png', 1, '2024-12-05 18:18:16'),
(4, 'Banner 4', 's4.png', 1, '2024-12-05 18:18:22'),
(5, 'Banner 5', 's5.png', 1, '2024-12-05 18:18:27'),
(6, 'Banner 6', 's6.png', 1, '2024-12-05 18:20:18'),
(7, 'Banner 7', 's7.png', 1, '2024-12-05 18:20:23');

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
(17, 5, 'Sản phẩm rất tốt, đáng tiền', 2, 31, '2024-12-06 03:19:36', 1),
(18, 4, 'Pin trâu, camera đẹp', 20, 31, '2024-12-06 03:19:36', 1),
(19, 5, 'Giao hàng nhanh, đóng gói cẩn thận', 2, 31, '2024-12-06 03:19:36', 1),
(20, 5, 'Máy chạy mượt, pin tốt', 2, 32, '2024-12-06 03:19:36', 1),
(21, 4, 'Camera chụp đẹp, màn hình sắc nét', 20, 32, '2024-12-06 03:19:36', 1),
(22, 5, 'Thiết kế đẹp, cầm vừa tay', 2, 32, '2024-12-06 03:19:36', 1),
(23, 5, 'Hiệu năng mạnh mẽ, chơi game tốt', 2, 33, '2024-12-06 03:19:36', 1),
(24, 4, 'Màn hình đẹp, độ sáng cao', 20, 33, '2024-12-06 03:19:36', 1),
(25, 5, 'Camera chụp đêm rất tốt', 2, 33, '2024-12-06 03:19:36', 1),
(26, 5, 'Sản phẩm chất lượng cao', 2, 34, '2024-12-06 03:19:36', 1),
(27, 4, 'Pin dùng được 2 ngày', 20, 34, '2024-12-06 03:19:36', 1),
(28, 5, 'Camera chụp ảnh rất đẹp', 2, 34, '2024-12-06 03:19:36', 1),
(29, 5, 'Thiết kế sang trọng, đẳng cấp', 2, 35, '2024-12-06 03:19:36', 1),
(30, 4, 'Face ID nhận diện nhanh', 20, 35, '2024-12-06 03:19:36', 1),
(31, 5, 'Chụp ảnh xóa phông tuyệt vời', 2, 35, '2024-12-06 03:19:36', 1),
(32, 5, 'Máy mới 100%, chính hãng', 2, 36, '2024-12-06 03:19:36', 1),
(33, 4, 'Giao hàng đúng hẹn', 20, 36, '2024-12-06 03:19:36', 1),
(34, 5, 'Sản phẩm worth the money', 2, 36, '2024-12-06 03:19:36', 1),
(35, 5, 'Rất hài lòng với sản phẩm', 2, 37, '2024-12-06 03:19:36', 1),
(36, 4, 'Chất lượng tốt, giá hợp lý', 20, 37, '2024-12-06 03:19:36', 1),
(37, 5, 'Đáng đồng tiền bát gạo', 2, 37, '2024-12-06 03:19:36', 1),
(38, 5, 'Sản phẩm chính hãng, yên tâm', 2, 85, '2024-12-06 03:19:36', 1),
(39, 4, 'Dịch vụ bảo hành tốt', 20, 85, '2024-12-06 03:19:36', 1),
(40, 5, 'Máy dùng rất ổn định', 2, 85, '2024-12-06 03:19:36', 1),
(41, 5, 'Chụp ảnh siêu nét', 2, 86, '2024-12-06 03:19:36', 1),
(42, 4, 'Pin trâu dùng thoải mái', 20, 86, '2024-12-06 03:19:36', 1),
(43, 5, 'Màn hình hiển thị sắc nét', 2, 86, '2024-12-06 03:19:36', 1),
(44, 5, 'Cấu hình mạnh mẽ', 2, 91, '2024-12-06 03:19:36', 1),
(45, 4, 'Chơi game không giật lag', 20, 91, '2024-12-06 03:19:36', 1),
(46, 5, 'Camera chụp đêm tuyệt vời', 2, 91, '2024-12-06 03:19:36', 1);

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
  `status` enum('pending','confirmed','processing','shipping','delivered','cancelled','returned','refunded','failed','awaiting_payment','return_requested','cancel_requested') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `return_reason` text DEFAULT NULL,
  `return_request_reason` text DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `previous_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `user_id`, `receiver_name`, `total_amount`, `shipping_address`, `shipping_phone`, `shipping_email`, `bank_code`, `status`, `payment_method`, `payment_status`, `created_at`, `updated_at`, `return_reason`, `return_request_reason`, `cancel_reason`, `previous_status`) VALUES
(172, 'ORD1733063503', 20, 'đỗ trung kiên', 52439400.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'delivered', 'cod', 'unpaid', '2024-12-01 14:31:43', '2024-12-03 16:24:07', NULL, NULL, NULL, NULL),
(173, 'ORD1733123393', 20, 'đỗ trung kiên', 26053700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-02 07:09:53', '2024-12-02 07:09:54', NULL, NULL, NULL, NULL),
(174, 'ORD1733220354', 2, 'sfafasdzxv', 21239700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-03 10:05:54', '2024-12-03 10:05:54', NULL, NULL, NULL, NULL),
(175, 'ORD1733220392', 20, 'đỗ trung kiên', 21239700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'returned', 'cod', 'unpaid', '2024-12-03 10:06:32', '2024-12-03 10:07:45', NULL, 'àdfsf', NULL, NULL),
(176, 'ORD1733220626', 20, 'đỗ trung kiên', 35183700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 10:10:26', '2024-12-03 10:12:46', NULL, 'hàng xấu quá ', NULL, NULL),
(177, 'ORD1733221213', 20, 'đỗ trung kiên', 21239700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, '', 'cod', 'unpaid', '2024-12-03 10:20:13', '2024-12-03 10:21:09', NULL, 'hàng xấu ', NULL, NULL),
(178, 'ORD1733221566', 20, 'đỗ trung kiên', 35183700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, '', 'cod', 'unpaid', '2024-12-03 10:26:06', '2024-12-03 10:27:35', NULL, 'tôi muốn trả hàng ', NULL, NULL),
(179, 'ORD1733221695', 20, 'đỗ trung kiên', 35183700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 10:28:15', '2024-12-03 10:28:19', NULL, NULL, NULL, NULL),
(180, 'ORD1733222273', 20, 'đỗ trung kiên', 30286700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'cancel_requested', 'cod', 'unpaid', '2024-12-03 10:37:53', '2024-12-03 16:36:19', NULL, NULL, 'tôi muốn hủy ', NULL),
(181, 'ORD1733231753', 2, 'sfafasdzxv', 35183700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 13:15:53', '2024-12-03 17:09:42', NULL, NULL, NULL, NULL),
(182, 'ORD1733245802', 20, 'đỗ trung kiên', 35183700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-03 17:10:02', '2024-12-03 17:10:02', NULL, NULL, NULL, NULL),
(183, 'ORD1733245823', 2, 'sfafasdzxv', 35183700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'delivered', 'cod', 'unpaid', '2024-12-03 17:10:23', '2024-12-03 17:11:26', NULL, NULL, NULL, NULL),
(184, 'ORD1733245908', 2, 'sfafasdzxv', 30286700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'processing', 'cod', 'unpaid', '2024-12-03 17:11:48', '2024-12-03 17:12:02', NULL, NULL, NULL, NULL),
(185, 'ORD1733246191', 2, 'sfafasdzxv', 20326700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'delivered', 'cod', 'unpaid', '2024-12-03 17:16:31', '2024-12-03 17:17:16', NULL, NULL, NULL, NULL),
(186, 'ORD1733246971', 2, 'sfafasdzxv', 20326700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 17:29:31', '2024-12-03 17:29:38', NULL, NULL, NULL, NULL),
(187, 'ORD1733246994', 2, 'sfafasdzxv', 30286700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 17:29:54', '2024-12-03 17:38:04', NULL, NULL, 'xấu', NULL),
(188, 'ORD1733247521', 2, 'sfafasdzxv', 21239700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 17:38:41', '2024-12-03 17:42:53', NULL, NULL, 'xấu', NULL),
(189, 'ORD1733247831', 2, 'sfafasdzxv', 21239700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-03 17:43:51', '2024-12-03 17:47:09', NULL, NULL, 'xấu', NULL),
(190, 'ORD1733247962', 2, 'sfafasdzxv', 20326700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 17:46:02', '2024-12-03 17:46:36', NULL, NULL, 'xấu', NULL),
(191, 'ORD1733248112', 2, 'sfafasdzxv', 30286700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-03 17:48:32', '2024-12-03 17:54:50', NULL, NULL, 'tôi muốn hủy', 'pending'),
(192, 'ORD1733248505', 2, 'sfafasdzxv', 30286700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-12-03 17:55:05', '2024-12-03 17:55:26', NULL, NULL, 'hủy', 'pending'),
(193, 'ORD1733248567', 20, 'đỗ trung kiên', 21239700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'cancel_requested', 'cod', 'unpaid', '2024-12-03 17:56:07', '2024-12-03 17:56:11', NULL, NULL, 'dgsdg', 'pending'),
(194, 'ORD1733248593', 20, 'đỗ trung kiên', 35183700.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'processing', 'cod', 'unpaid', '2024-12-03 17:56:33', '2024-12-04 12:07:37', NULL, NULL, NULL, NULL),
(195, 'ORD1733248612', 2, 'sfafasdzxv', 21239700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'processing', 'cod', 'unpaid', '2024-12-03 17:56:52', '2024-12-03 17:57:39', NULL, NULL, 'dfgdgf', 'processing'),
(196, 'ORD1733248709', 20, 'đỗ trung kiên', 70367400.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'cancel_requested', 'cod', 'unpaid', '2024-12-03 17:58:29', '2024-12-03 17:58:39', NULL, NULL, 'dffgsdg', 'pending'),
(197, 'ORD1733248741', 2, 'sfafasdzxv', 21239700.00, 'văn khúc, cẩm khê, nckdj,gfgf', '09987667656', NULL, NULL, 'confirmed', 'cod', 'unpaid', '2024-12-03 17:59:01', '2024-12-03 17:59:42', NULL, NULL, 'dgsg', 'confirmed'),
(198, 'ORD1733248810', 20, 'đỗ trung kiên', 62150400.00, 'văn khúc , cẩm khê', '0998766765633', NULL, NULL, 'processing', 'cod', 'unpaid', '2024-12-03 18:00:10', '2024-12-04 12:04:25', NULL, NULL, NULL, NULL),
(199, 'ORD1733313434', 1, 'Bùi Đức Dương', 20326700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-12-04 11:57:14', '2024-12-04 11:57:53', NULL, NULL, 'eewvrwv', 'pending'),
(200, 'ORD1733313596', 1, 'Bùi Đức Dương', 20326700.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'delivered', 'cod', 'unpaid', '2024-12-04 11:59:56', '2024-12-04 12:00:25', NULL, NULL, NULL, NULL);

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
(175, 172, 32, 1, 21239700.00),
(176, 172, 37, 1, 31199700.00),
(177, 173, 85, 1, 26053700.00),
(178, 174, 32, 1, 21239700.00),
(179, 175, 32, 1, 21239700.00),
(180, 176, 91, 1, 35183700.00),
(181, 177, 32, 1, 21239700.00),
(182, 178, 91, 1, 35183700.00),
(183, 179, 91, 1, 35183700.00),
(184, 180, 36, 1, 30286700.00),
(185, 181, 91, 1, 35183700.00),
(186, 182, 91, 1, 35183700.00),
(187, 183, 91, 1, 35183700.00),
(188, 184, 36, 1, 30286700.00),
(189, 185, 31, 1, 20326700.00),
(190, 186, 31, 1, 20326700.00),
(191, 187, 36, 1, 30286700.00),
(192, 188, 32, 1, 21239700.00),
(193, 189, 32, 1, 21239700.00),
(194, 190, 31, 1, 20326700.00),
(195, 191, 36, 1, 30286700.00),
(196, 192, 36, 1, 30286700.00),
(197, 193, 33, 1, 21239700.00),
(198, 194, 91, 1, 35183700.00),
(199, 195, 32, 1, 21239700.00),
(200, 196, 91, 2, 35183700.00),
(201, 197, 32, 1, 21239700.00),
(202, 198, 91, 1, 35183700.00),
(203, 198, 86, 1, 26966700.00),
(204, 199, 31, 1, 20326700.00),
(205, 200, 31, 1, 20326700.00);

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
(26, 175, 'return', 'pending', 'Yêu cầu trả hàng: àdfsf', '2024-12-03 10:07:21'),
(27, 176, 'return', 'pending', 'Yêu cầu trả hàng: hàng xấu quá ', '2024-12-03 10:11:50'),
(28, 177, 'return', 'pending', 'Yêu cầu trả hàng: hàng xấu ', '2024-12-03 10:20:49'),
(29, 178, 'return', 'pending', 'Yêu cầu trả hàng: tôi muốn trả hàng ', '2024-12-03 10:27:17');

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
(31, 'IPhone 16 256Gb Mới chính hãng', 21490000, 40, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 2, 1),
(32, 'IPhone 16 256Gb Mới chính hãng', 21490000, 28, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 2, 4),
(33, 'IPhone 16 256Gb Mới chính hãng', 21490000, 37, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 2, 2),
(34, 'IPhone 16 256Gb Mới chính hãng', 21490000, 50, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 2, 5),
(35, 'IPhone 16 256Gb Mới chính hãng', 21490000, 47, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 2, 6),
(36, 'IPhone 16 512Gb Mới chính hãng', 27490000, 41, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 3, 1),
(37, 'IPhone 16 512Gb Mới chính hãng', 27490000, 45, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 3, 2),
(38, 'IPhone 16 512Gb Mới chính hãng', 27490000, 49, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 3, 5),
(39, 'IPhone 16 512Gb Mới chính hãng', 27490000, 47, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 3, 4),
(40, 'IPhone 16 512Gb Mới chính hãng', 27490000, 50, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 3, 6),
(41, 'IPhone 16 128Gb Mới chính hãng', 19190000, 46, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 1, 1),
(42, 'IPhone 16 128Gb Mới chính hãng', 19190000, 46, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 1, 2),
(43, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 1, 5),
(44, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 1, 4),
(47, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 1, 6),
(60, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 den.png', '2024-11-28', '', 0, 1, 5, 3, 1),
(61, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 xanhbien.png', '2024-11-28', '', 0, 1, 5, 3, 10),
(62, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 xanhla.png', '2024-11-28', '', 0, 1, 5, 3, 11),
(63, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 vang.png', '2024-11-28', '', 0, 1, 5, 3, 12),
(64, 'IPhone 15 512Gb Mới chính hãng', 20990000, 50, 'iphone15 hong.png', '2024-11-28', '', 0, 1, 5, 3, 6),
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
(85, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 49, 'iphone13pm den.png', '2024-11-28', '', 0, 1, 3, 2, 1),
(86, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 49, 'iphone13pm trang.png', '2024-11-28', '', 0, 1, 3, 2, 2),
(87, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm vangkim.png', '2024-11-28', '', 0, 1, 3, 2, 3),
(88, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm xanh.png', '2024-11-28', '', 0, 1, 3, 2, 10),
(89, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm den.png', '2024-11-28', '', 0, 1, 3, 3, 1),
(90, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm trang.png', '2024-11-28', '', 0, 1, 3, 3, 2),
(91, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 34, 'iphone13pm vangkim.png', '2024-11-28', '', 0, 1, 3, 3, 3),
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
(246, 108, 20.00, '2024-12-01', '2024-12-29', 1),
(247, 107, 20.00, '2024-12-01', '2024-12-29', 1),
(248, 106, 20.00, '2024-12-01', '2024-12-29', 1),
(249, 105, 20.00, '2024-12-01', '2024-12-29', 1),
(250, 96, 20.00, '2024-12-01', '2024-12-29', 1),
(251, 93, 20.00, '2024-12-01', '2024-12-29', 1),
(252, 95, 20.00, '2024-12-01', '2024-12-29', 1),
(253, 94, 20.00, '2024-12-01', '2024-12-29', 1),
(254, 98, 20.00, '2024-12-01', '2024-12-29', 1),
(255, 100, 20.00, '2024-12-01', '2024-12-29', 1),
(256, 97, 20.00, '2024-12-01', '2024-12-29', 1),
(257, 99, 20.00, '2024-12-01', '2024-12-29', 1),
(258, 104, 20.00, '2024-12-01', '2024-12-29', 1),
(259, 101, 20.00, '2024-12-01', '2024-12-29', 1),
(260, 103, 20.00, '2024-12-01', '2024-12-29', 1),
(261, 102, 20.00, '2024-12-01', '2024-12-29', 1),
(262, 82, 20.00, '2024-12-01', '2024-12-29', 1),
(263, 84, 20.00, '2024-12-01', '2024-12-29', 1),
(264, 81, 20.00, '2024-12-01', '2024-12-29', 1),
(265, 83, 20.00, '2024-12-01', '2024-12-29', 1),
(266, 88, 20.00, '2024-12-01', '2024-12-29', 1),
(267, 85, 20.00, '2024-12-01', '2024-12-29', 1),
(268, 87, 20.00, '2024-12-01', '2024-12-29', 1),
(269, 86, 20.00, '2024-12-01', '2024-12-29', 1),
(270, 90, 20.00, '2024-12-01', '2024-12-29', 1),
(271, 92, 20.00, '2024-12-01', '2024-12-29', 1),
(272, 89, 20.00, '2024-12-01', '2024-12-29', 1),
(273, 91, 20.00, '2024-12-01', '2024-12-29', 1),
(274, 66, 20.00, '2024-12-01', '2024-12-29', 1),
(275, 68, 20.00, '2024-12-01', '2024-12-29', 1),
(276, 65, 20.00, '2024-12-01', '2024-12-29', 1),
(277, 67, 20.00, '2024-12-01', '2024-12-29', 1),
(278, 80, 20.00, '2024-12-01', '2024-12-29', 1),
(279, 77, 20.00, '2024-12-01', '2024-12-29', 1),
(280, 79, 20.00, '2024-12-01', '2024-12-29', 1),
(281, 78, 20.00, '2024-12-01', '2024-12-29', 1),
(282, 72, 20.00, '2024-12-01', '2024-12-29', 1),
(283, 69, 20.00, '2024-12-01', '2024-12-29', 1),
(284, 71, 20.00, '2024-12-01', '2024-12-29', 1),
(285, 70, 20.00, '2024-12-01', '2024-12-29', 1),
(286, 74, 20.00, '2024-12-01', '2024-12-29', 1),
(287, 76, 20.00, '2024-12-01', '2024-12-29', 1),
(288, 73, 20.00, '2024-12-01', '2024-12-29', 1),
(289, 75, 20.00, '2024-12-01', '2024-12-29', 1),
(290, 64, 20.00, '2024-12-01', '2024-12-29', 1),
(291, 61, 20.00, '2024-12-01', '2024-12-29', 1),
(292, 63, 20.00, '2024-12-01', '2024-12-29', 1),
(293, 60, 20.00, '2024-12-01', '2024-12-29', 1),
(294, 62, 20.00, '2024-12-01', '2024-12-29', 1),
(295, 42, 20.00, '2024-12-01', '2024-12-29', 1),
(296, 44, 20.00, '2024-12-01', '2024-12-29', 1),
(297, 41, 20.00, '2024-12-01', '2024-12-29', 1),
(298, 43, 20.00, '2024-12-01', '2024-12-29', 1),
(299, 47, 20.00, '2024-12-01', '2024-12-29', 1),
(300, 34, 20.00, '2024-12-01', '2024-12-29', 1),
(301, 31, 20.00, '2024-12-01', '2024-12-29', 1),
(302, 33, 20.00, '2024-12-01', '2024-12-29', 1),
(303, 35, 20.00, '2024-12-01', '2024-12-29', 1),
(304, 32, 20.00, '2024-12-01', '2024-12-29', 1),
(305, 39, 20.00, '2024-12-01', '2024-12-29', 1),
(306, 36, 20.00, '2024-12-01', '2024-12-29', 1),
(307, 38, 20.00, '2024-12-01', '2024-12-29', 1),
(308, 40, 20.00, '2024-12-01', '2024-12-29', 1),
(309, 37, 20.00, '2024-12-01', '2024-12-29', 1);

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
(10, 175, 20, '2024-12-03 10:07:45', '', NULL, 'approved', 'sfsaf', '2024-12-03 10:07:45'),
(11, 176, 20, '2024-12-03 10:12:47', '', NULL, 'rejected', 'không đồng ý ', '2024-12-03 10:12:47'),
(12, 177, 20, '2024-12-03 10:21:09', '', NULL, 'rejected', 'sfd', '2024-12-03 10:21:09');

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
(1, 'Sora', 'sora123', 'soramidori843@gmail.com', 'Bùi Đức Dương', '0355032605', 'Thanh Liêm-Hà Nam', '/Screenshot_2024-04-03-01-39-25-433_com.miui.videoplayer.jpg', 1, 1, '2024-11-13 07:46:27', '2005-06-30', 1),
(2, 'duongbd', 'duong123', 'duongbdph50213@gmail.com', 'sfafasdzxv', '09987667656', 'văn khúc, cẩm khê, nckdj,gfgf', 'Uploads/User/user.png', 2, 1, '2024-11-17 21:00:12', NULL, NULL),
(20, 'kien', '1', 'kien49182@gmail.com', 'đỗ trung kiên', '0998766765633', 'văn khúc , cẩm khê', 'Uploads/User/nam.jpg', 1, 1, '2024-11-25 09:10:43', NULL, NULL),
(21, 'kienneeee', '1', 'kiennenennen@gmail.com', 'kiên', '0998766777', 'văn khúc', 'Uploads/User/nam.jpg', 2, 1, '2024-11-26 10:40:54', '2014-11-14', 1);

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
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
  MODIFY `deal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

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
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
