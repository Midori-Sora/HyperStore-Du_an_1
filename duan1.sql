-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 29, 2024 lúc 10:08 PM
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
  `status` enum('pending','confirmed','processing','shipping','delivered','cancelled','returned','refunded','failed','awaiting_payment') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(50) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `return_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `user_id`, `receiver_name`, `total_amount`, `shipping_address`, `shipping_phone`, `shipping_email`, `bank_code`, `status`, `payment_method`, `payment_status`, `created_at`, `updated_at`, `return_reason`) VALUES
(129, 'ORD1732799883', 1, 'Bùi Đức Dương', 21490000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-11-28 13:18:03', '2024-11-28 13:18:03', NULL),
(130, 'ORD1732799907', 1, 'Bùi Đức Dương', 21490000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-11-28 13:18:27', '2024-11-29 11:41:43', NULL),
(131, 'ORD1732800912', 1, 'Bùi Đức Dương', 21490000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'delivered', 'cod', 'unpaid', '2024-11-28 13:35:12', '2024-11-29 09:11:48', NULL),
(132, 'ORD1732880794', 1, 'Bùi Đức Dương', 99999999.99, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-11-29 11:46:34', '2024-11-29 11:46:34', NULL),
(133, 'ORD1732880842', 1, 'Bùi Đức Dương', 64470000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-11-29 11:47:22', '2024-11-29 11:47:22', NULL),
(134, 'ORD1732881894', 1, 'Bùi Đức Dương', 21490000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-11-29 12:04:54', '2024-11-29 12:04:54', NULL),
(135, 'ORD1732881910', 1, 'Bùi Đức Dương', 21490000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-11-29 12:05:10', '2024-11-29 12:05:10', NULL),
(136, 'ORD1732881990', 1, 'Bùi Đức Dương', 21490000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-11-29 12:06:30', '2024-11-29 12:06:30', NULL),
(137, 'ORD1732905949', 1, 'Bùi Đức Dương', 54980000.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'cancelled', 'cod', 'unpaid', '2024-11-29 18:45:49', '2024-11-29 18:45:55', NULL),
(138, 'ORD1732914319', 1, 'Bùi Đức Dương', 16311500.00, 'Thanh Liêm-Hà Nam', '0355032605', NULL, NULL, 'pending', 'cod', 'unpaid', '2024-11-29 21:05:19', '2024-11-29 21:05:19', NULL);

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
(131, 137, 38, 1, 27490000.00),
(132, 137, 39, 1, 27490000.00),
(133, 138, 41, 1, 19190000.00);

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
(31, 'IPhone 16 256Gb Mới chính hãng', 21490000, 50, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 2, 1),
(32, 'IPhone 16 256Gb Mới chính hãng', 21490000, 50, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 2, 4),
(33, 'IPhone 16 256Gb Mới chính hãng', 21490000, 50, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 2, 2),
(34, 'IPhone 16 256Gb Mới chính hãng', 21490000, 50, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 2, 5),
(35, 'IPhone 16 256Gb Mới chính hãng', 21490000, 50, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 2, 6),
(36, 'IPhone 16 512Gb Mới chính hãng', 27490000, 50, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 3, 1),
(37, 'IPhone 16 512Gb Mới chính hãng', 27490000, 50, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 3, 2),
(38, 'IPhone 16 512Gb Mới chính hãng', 27490000, 49, 'iphone16 xanhmk.png', '2024-11-28', '', 0, 1, 6, 3, 5),
(39, 'IPhone 16 512Gb Mới chính hãng', 27490000, 49, 'iphone16 xanhll.png', '2024-11-28', '', 0, 1, 6, 3, 4),
(40, 'IPhone 16 512Gb Mới chính hãng', 27490000, 50, 'iphone16 hong.png', '2024-11-28', '', 0, 1, 6, 3, 6),
(41, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 den.png', '2024-11-28', '', 0, 1, 6, 1, 1),
(42, 'IPhone 16 128Gb Mới chính hãng', 19190000, 50, 'iphone16 trang.png', '2024-11-28', '', 0, 1, 6, 1, 2),
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
(85, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm den.png', '2024-11-28', '', 0, 1, 3, 2, 1),
(86, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm trang.png', '2024-11-28', '', 0, 1, 3, 2, 2),
(87, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm vangkim.png', '2024-11-28', '', 0, 1, 3, 2, 3),
(88, 'IPhone 13 Pro Max 256Gb Mới chính hãng', 28390000, 50, 'iphone13pm xanh.png', '2024-11-28', '', 0, 1, 3, 2, 10),
(89, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm den.png', '2024-11-28', '', 0, 1, 3, 3, 1),
(90, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm trang.png', '2024-11-28', '', 0, 1, 3, 3, 2),
(91, 'IPhone 13 Pro Max 512Gb Mới chính hãng', 32890000, 50, 'iphone13pm vangkim.png', '2024-11-28', '', 0, 1, 3, 3, 3),
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
(67, 42, 15.00, '2024-11-05', '2024-12-29', 1),
(68, 44, 15.00, '2024-11-05', '2024-12-29', 1),
(69, 41, 15.00, '2024-11-05', '2024-12-29', 1),
(70, 43, 15.00, '2024-11-05', '2024-12-29', 1),
(71, 47, 15.00, '2024-11-05', '2024-12-29', 1),
(72, 34, 15.00, '2024-11-05', '2024-12-29', 1),
(73, 31, 15.00, '2024-11-05', '2024-12-29', 1),
(74, 33, 15.00, '2024-11-05', '2024-12-29', 1),
(75, 35, 15.00, '2024-11-05', '2024-12-29', 1),
(76, 32, 15.00, '2024-11-05', '2024-12-29', 1),
(77, 39, 15.00, '2024-11-05', '2024-12-29', 1),
(78, 36, 15.00, '2024-11-05', '2024-12-29', 1),
(79, 38, 15.00, '2024-11-05', '2024-12-29', 1),
(80, 40, 15.00, '2024-11-05', '2024-12-29', 1),
(81, 37, 15.00, '2024-11-05', '2024-12-29', 1);

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
(1, 'Sora', 'sora123', 'soramidori843@gmail.com', 'Bùi Đức Dương', '0355032605', 'Thanh Liêm-Hà Nam', 'Uploads/User/nam.jpg', 1, 1, '2024-11-13 07:46:27', '1990-01-01', 1),
(2, 'duongbd', 'duong123', 'duongbdph50213@gmail.com', '', '', '', 'Uploads/User/user.png', 2, 1, '2024-11-17 21:00:12', NULL, NULL),
(3, 'nguyenthanhnam', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'thanhnam@gmail.com', 'Nguyễn Thành Nam', '0912345678', 'Quận 1, TP.HCM', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(4, 'tranthihuong', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'huong.tran@gmail.com', 'Trần Thị Hương', '0923456789', 'Cầu Giấy, Hà Nội', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(5, 'levanminh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'minhle@gmail.com', 'Lê Văn Minh', '0934567890', 'Hải Châu, Đà Nẵng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(6, 'phamthi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hoapham@gmail.com', 'Phạm Thị Hoa', '0945678901', 'Ninh Kiều, Cần Thơ', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(7, 'hoangvantuan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tuanhoang@gmail.com', 'Hoàng Văn Tuấn', '0956789012', 'Ngô Quyền, Hải Phòng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(8, 'nguyenthilan', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lan.nguyen@gmail.com', 'Nguyễn Thị Lan', '0967890123', 'Lê Chân, Hải Phòng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(9, 'vuducmanh', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'manhvu@gmail.com', 'Vũ Đức Mạnh', '0978901234', 'Thanh Xuân, Hà Nội', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(10, 'tranthihien', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hientran@gmail.com', 'Trần Thị Hiền', '0989012345', 'Sơn Trà, Đà Nẵng', 'Uploads/User/nam.jpg', 2, 1, '2024-11-17 21:30:55', NULL, NULL),
(20, 'kien', '1', 'kien49182@gmail.com', 'đỗ trung kiên ', '0998766765633', 'văn khúc ', 'Uploads/User/nam.jpg', 1, 1, '2024-11-25 09:10:43', NULL, NULL),
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
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `pay_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `deal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT cho bảng `product_storage`
--
ALTER TABLE `product_storage`
  MODIFY `storage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
