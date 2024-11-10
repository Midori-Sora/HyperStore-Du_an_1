-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 09, 2024 lúc 09:20 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `duan1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `duan1`;

-- Tạo bảng users
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `avata` varchar(255) DEFAULT NULL,
  `role` tinyint(1) DEFAULT 0,
  `import_date` date DEFAULT NULL,
  `user_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng categories
CREATE TABLE `categories` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) NOT NULL,
  `img` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `cate_status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng products
CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_name` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `import_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `pro_view` int(11) DEFAULT 0,
  `pro_status` tinyint(1) DEFAULT 1,
  `cate_id` int(11) NOT NULL,
  PRIMARY KEY (`pro_id`),
  KEY `cate_id` (`cate_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cate_id`) REFERENCES `categories` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo lại bảng product_ram với giá tăng cố định
CREATE TABLE `product_ram` (
  `ram_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `ram_type` enum('128GB','256GB','512GB') NOT NULL,
  `price_increase` int(11) GENERATED ALWAYS AS (
    CASE ram_type
      WHEN '128GB' THEN 0
      WHEN '256GB' THEN 200000
      WHEN '512GB' THEN 500000
    END
  ) STORED,
  `stock` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`ram_id`),
  UNIQUE KEY `unique_product_ram` (`pro_id`, `ram_type`),
  KEY `pro_id` (`pro_id`),
  CONSTRAINT `product_ram_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo lại bảng product_color với giá tăng cố định cho màu vàng
CREATE TABLE `product_color` (
  `color_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `color_type` enum('Vàng','Xanh','Đỏ','Trắng','Hồng','Đen') NOT NULL,
  `price_increase` int(11) GENERATED ALWAYS AS (
    CASE color_type
      WHEN 'Vàng' THEN 500000
      ELSE 0
    END
  ) STORED,
  `stock` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`color_id`),
  UNIQUE KEY `unique_product_color` (`pro_id`, `color_type`),
  KEY `pro_id` (`pro_id`),
  CONSTRAINT `product_color_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo lại bảng cart
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `import_date` date DEFAULT NULL,
  `ram_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`),
  KEY `pro_id` (`pro_id`),
  KEY `ram_id` (`ram_id`),
  KEY `color_id` (`color_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`),
  CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`ram_id`) REFERENCES `product_ram` (`ram_id`) ON DELETE SET NULL,
  CONSTRAINT `cart_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `product_color` (`color_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng comments
CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `import_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`com_id`),
  KEY `user_id` (`user_id`),
  KEY `pro_id` (`pro_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng payments
CREATE TABLE `payments` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `import_date` datetime DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1,
  `total` int(11) DEFAULT NULL,
  `pay_method` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`pay_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo lại bảng orders
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_code` varchar(20) NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `order_date` datetime DEFAULT current_timestamp(),
  `pay_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total` int(11) DEFAULT NULL,
  `ram_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `pay_id` (`pay_id`),
  KEY `pro_id` (`pro_id`),
  KEY `ram_id` (`ram_id`),
  KEY `color_id` (`color_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`pay_id`) REFERENCES `payments` (`pay_id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`),
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`ram_id`) REFERENCES `product_ram` (`ram_id`) ON DELETE SET NULL,
  CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `product_color` (`color_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng thumbnails
CREATE TABLE `thumbnails` (
  `thumb_id` int(11) NOT NULL AUTO_INCREMENT,
  `img` varchar(255) NOT NULL,
  `thumb_status` tinyint(1) DEFAULT 1,
  `pro_id` int(11) NOT NULL,
  PRIMARY KEY (`thumb_id`),
  KEY `pro_id` (`pro_id`),
  CONSTRAINT `thumbnails_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tạo bảng product_deals
CREATE TABLE `product_deals` (
  `deal_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `discount_amount` int(11) NOT NULL,
  `discount_type` tinyint(1) DEFAULT 1 COMMENT '1: Giảm theo %, 2: Giảm theo số tiền',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `deal_status` tinyint(1) DEFAULT 1 COMMENT '1: Đang áp dụng, 0: Không áp dụng',
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`deal_id`),
  KEY `pro_id` (`pro_id`),
  CONSTRAINT `product_deals_ibfk_1` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
