-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 30, 2026 lúc 09:44 PM
-- Phiên bản máy phục vụ: 8.0.40
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `its`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `order_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `station_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time DEFAULT '00:00:00',
  `end_date` date NOT NULL,
  `end_time` time DEFAULT '00:00:00',
  `actual_return_date` datetime DEFAULT NULL,
  `total_amount` decimal(12,0) NOT NULL,
  `deposit_amount` decimal(12,0) DEFAULT '0',
  `late_fee` decimal(12,0) DEFAULT '0',
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'CASH',
  `payment_status` enum('UNPAID','PAID','REFUNDED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'UNPAID',
  `status` enum('NEW','RENTING','WAITING_RETURN','COMPLETED','CANCELLED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'NEW',
  `cancel_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `station_id`, `user_id`, `vehicle_id`, `start_date`, `start_time`, `end_date`, `end_time`, `actual_return_date`, `total_amount`, `deposit_amount`, `late_fee`, `notes`, `payment_method`, `payment_status`, `status`, `cancel_reason`, `cancelled_at`, `completed_at`, `created_at`, `confirmed_at`) VALUES
(1, 'DHCC36A', 1, 1, 10, '2026-01-31', '00:00:00', '2026-02-01', '00:00:00', NULL, 450000, 300000, 0, NULL, 'CASH', 'PAID', 'COMPLETED', NULL, NULL, NULL, '2026-01-30 20:38:42', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `transaction_id` int NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `payment_type` varchar(20) DEFAULT 'MOMO',
  `amount` decimal(15,0) DEFAULT NULL,
  `trans_id` varchar(50) DEFAULT NULL,
  `result_code` int DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `payment_transactions`
--

INSERT INTO `payment_transactions` (`transaction_id`, `order_code`, `payment_type`, `amount`, `trans_id`, `result_code`, `message`, `created_at`) VALUES
(1, 'DHCC36A', 'CASH', 450000, NULL, 0, 'Đã xác nhận thanh toán tại trạm', '2026-01-30 20:38:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `review_type` enum('VEHICLE','STATION','SERVICE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'VEHICLE',
  `rating` tinyint NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('PENDING','APPROVED','REJECTED','HIDDEN') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `report_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_reported` tinyint(1) NOT NULL DEFAULT '0',
  `admin_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reply` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `replied_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `order_id`, `review_type`, `rating`, `comment`, `status`, `report_reason`, `is_reported`, `admin_note`, `created_at`, `updated_at`, `reply`, `replied_at`) VALUES
(1, 1, 1, 'VEHICLE', 5, 'Xe tốt, trải nghiệm tuyệt vời', 'APPROVED', NULL, 0, NULL, '2026-01-30 20:41:04', '2026-01-30 20:41:37', 'Cảm ơn bạn đã trải nghiệm dịch vụ', '2026-01-30 20:41:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stations`
--

CREATE TABLE `stations` (
  `station_id` int NOT NULL,
  `station_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `stations`
--

INSERT INTO `stations` (`station_id`, `station_name`, `address`, `district`, `city`, `created_at`, `is_maintenance`, `status`, `latitude`, `longitude`) VALUES
(1, 'Trạm Bến Thành', '01 Công xã Paris', 'Quận 1', 'TP. Hồ Chí Minh', '2026-01-30 19:47:39', 0, 'ACTIVE', 10.77986981, 106.69901890),
(2, 'Trạm Landmark 81', '208 Nguyễn Hữu Cảnh', 'Quận Bình Thạnh', 'TP. Hồ Chí Minh', '2026-01-30 19:48:46', 0, 'ACTIVE', 10.79573471, 106.71915495),
(3, 'Trạm ĐH Giao Thông Vận Tải', '02 Võ Oanh, P.25', 'Quận Bình Thạnh', 'TP. Hồ Chí Minh', '2026-01-30 19:49:53', 0, 'ACTIVE', 10.80496786, 106.71628732),
(4, 'Trạm Sân Bay Tân Sơn Nhất', 'Ga Quốc Nội', 'Quận Tân Bình', 'TP. Hồ Chí Minh', '2026-01-30 19:50:25', 0, 'ACTIVE', 10.81419181, 106.66262356),
(5, 'Trạm Bùi Viện', '150 Bùi Viện, P. Phạm Ngũ Lão', 'Quận 1', 'TP. Hồ Chí Minh', '2026-01-30 19:52:19', 0, 'ACTIVE', 10.76710749, 106.69236428),
(6, 'Trạm Phố Lồng Đèn', '80 Lương Nhữ Học, P. 11', 'Quận 5', 'TP. Hồ Chí Minh', '2026-01-30 19:52:54', 0, 'ACTIVE', 10.75172080, 106.66027310),
(7, 'Trạm Hùng Vương Plaza', '126 Hùng Vương, P. 12', 'Quận 5', 'TP. Hồ Chí Minh', '2026-01-30 19:53:35', 0, 'ACTIVE', 10.75672798, 106.66243954);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `id_card_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('USER','STATION','ADMIN','DISPATCHER') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USER',
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','BLOCKED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
  `is_verified` enum('PENDING','VERIFIED','REJECTED') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'PENDING',
  `verified_at` datetime DEFAULT NULL,
  `verification_note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `managed_station_id` int DEFAULT NULL,
  `id_card_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card_date` date DEFAULT NULL,
  `id_card_place` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card_front` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_card_back` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `face_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_front` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_back` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_account_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `emergency_contact` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `birthday`, `id_card_number`, `driver_license_number`, `role`, `avatar`, `status`, `is_verified`, `verified_at`, `verification_note`, `created_at`, `managed_station_id`, `id_card_name`, `id_card_date`, `id_card_place`, `id_card_front`, `id_card_back`, `face_image`, `driver_license_front`, `driver_license_back`, `bank_account_number`, `bank_account_name`, `bank_name`, `address`, `emergency_contact`, `emergency_name`) VALUES
(1, 'Admin', 'admin@thuexe.com', NULL, '$2y$10$9JoR8PffIzb1CEdR2v4zauHMrtMnXeqtxGEy/gWje..dTF3xQOM2G', NULL, NULL, NULL, 'ADMIN', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-30 19:39:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'User1', 'user1@thuexe.com', '0944941198', '$2y$10$XGTfuiR0gJUkUzWxKjwC6egRjL5FWEjmHF3yChP1ukYCZfbdA11nK', '2005-11-17', NULL, NULL, 'USER', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-30 19:42:33', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'User2', 'user2@thuexe.com', '0601952132', '$2y$10$LAaVxbEYlJLqxu8QJM86eOLpq0i/wKDU/H7dGPmKlOq1JEKZlKw56', '2005-12-31', NULL, NULL, 'USER', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-30 19:43:24', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Dispatcher', 'dispatcher@thuexe.com', '0555342840', '$2y$10$wpUMj49y0oZobQa6aTTYouiap9lhCb2uzcgrJg/uMhuPA8xRJD.N.', '2004-11-11', NULL, NULL, 'DISPATCHER', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-30 19:44:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Station', 'station@thuexe.com', '0123456789', '$2y$10$.gb2yvRg2d1SNz5Du7YtjuB6472a4pxKsSNPpc/gfivNcPdA0TkGy', '1999-02-25', NULL, NULL, 'STATION', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-30 19:44:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int NOT NULL,
  `vehicle_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_plate` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `station_id` int DEFAULT NULL,
  `vehicle_type` enum('Oto','Xemay') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int DEFAULT NULL,
  `seats` int DEFAULT NULL,
  `price_per_day` decimal(12,0) NOT NULL,
  `price_per_hour` decimal(12,0) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('AVAILABLE','RENTED','MAINTENANCE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'AVAILABLE',
  `last_maintenance_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_name`, `license_plate`, `station_id`, `vehicle_type`, `brand`, `model`, `year`, `seats`, `price_per_day`, `price_per_hour`, `description`, `image`, `created_at`, `status`, `last_maintenance_date`) VALUES
(1, 'Toyota Vios', '51-S1-001.01', 1, 'Oto', 'Toyota', 'Vios', 2023, 5, 800000, 100000, 'Sedan quốc dân, bền bỉ, tiết kiệm nhiên liệu.', 'Toyota_Vios.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(2, 'Toyota Vios', '51-S1-001.02', 1, 'Oto', 'Toyota', 'Vios', 2023, 5, 800000, 100000, 'Sedan quốc dân, bền bỉ, tiết kiệm nhiên liệu.', 'Toyota_Vios.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(3, 'Toyota Vios', '51-S1-001.03', 1, 'Oto', 'Toyota', 'Vios', 2023, 5, 800000, 100000, 'Sedan quốc dân, bền bỉ, tiết kiệm nhiên liệu.', 'Toyota_Vios.jpg', '2026-01-30 20:08:41', 'RENTED', NULL),
(4, 'Honda City', '51-S1-001.04', 1, 'Oto', 'Honda', 'City', 2022, 5, 900000, 120000, 'Thiết kế thể thao, không gian rộng rãi, vận hành mượt mà.', 'Honda_City.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(5, 'Honda City', '51-S1-001.05', 1, 'Oto', 'Honda', 'City', 2022, 5, 900000, 120000, 'Thiết kế thể thao, không gian rộng rãi, vận hành mượt mà.', 'Honda_City.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(6, 'Honda City', '51-S1-001.06', 1, 'Oto', 'Honda', 'City', 2022, 5, 900000, 120000, 'Thiết kế thể thao, không gian rộng rãi, vận hành mượt mà.', 'Honda_City.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(7, 'Mitsubishi Xpander', '51-S1-001.07', 1, 'Oto', 'Mitsubishi', 'Xpander', 2023, 7, 1100000, 150000, 'Xe 7 chỗ đa dụng, nội thất thoáng, phù hợp gia đình.', 'Mitsubishi_Xpander.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(8, 'Mitsubishi Xpander', '51-S1-001.08', 1, 'Oto', 'Mitsubishi', 'Xpander', 2023, 7, 1100000, 150000, 'Xe 7 chỗ đa dụng, nội thất thoáng, phù hợp gia đình.', 'Mitsubishi_Xpander.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(9, 'Mitsubishi Xpander', '51-S1-001.09', 1, 'Oto', 'Mitsubishi', 'Xpander', 2023, 7, 1100000, 150000, 'Xe 7 chỗ đa dụng, nội thất thoáng, phù hợp gia đình.', 'Mitsubishi_Xpander.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(10, 'Honda Vision', '59-S1-101.01', 1, 'Xemay', 'Honda', 'Vision', 2023, 2, 150000, 20000, 'Xe ga nhỏ gọn, thời trang, dễ điều khiển phố đông.', 'Honda_Vision.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(11, 'Honda Vision', '59-S1-101.02', 1, 'Xemay', 'Honda', 'Vision', 2023, 2, 150000, 20000, 'Xe ga nhỏ gọn, thời trang, dễ điều khiển phố đông.', 'Honda_Vision.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(12, 'Honda Vision', '59-S1-101.03', 1, 'Xemay', 'Honda', 'Vision', 2023, 2, 150000, 20000, 'Xe ga nhỏ gọn, thời trang, dễ điều khiển phố đông.', 'Honda_Vision.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(13, 'Honda Air Blade', '59-S1-101.04', 1, 'Xemay', 'Honda', 'Air Blade', 2024, 2, 250000, 35000, 'Kiểu dáng nam tính, động cơ mạnh mẽ, cốp rộng.', 'Honda_Air_Blade.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(14, 'Honda Air Blade', '59-S1-101.05', 1, 'Xemay', 'Honda', 'Air Blade', 2024, 2, 250000, 35000, 'Kiểu dáng nam tính, động cơ mạnh mẽ, cốp rộng.', 'Honda_Air_Blade.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(15, 'Honda Air Blade', '59-S1-101.06', 1, 'Xemay', 'Honda', 'Air Blade', 2024, 2, 250000, 35000, 'Kiểu dáng nam tính, động cơ mạnh mẽ, cốp rộng.', 'Honda_Air_Blade.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(16, 'Honda SH 150i', '59-S1-101.07', 1, 'Xemay', 'Honda', 'SH', 2024, 2, 400000, 60000, 'Xe ga cao cấp, biểu tượng thượng lưu, vận hành êm ái.', 'Honda_SH.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(17, 'Honda SH 150i', '59-S1-101.08', 1, 'Xemay', 'Honda', 'SH', 2024, 2, 400000, 60000, 'Xe ga cao cấp, biểu tượng thượng lưu, vận hành êm ái.', 'Honda_SH.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(18, 'Honda SH 150i', '59-S1-101.09', 1, 'Xemay', 'Honda', 'SH', 2024, 2, 400000, 60000, 'Xe ga cao cấp, biểu tượng thượng lưu, vận hành êm ái.', 'Honda_SH.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(19, 'Rolls-Royce Cullinan', '51-RR-001.00', 1, 'Oto', 'Rolls-Royce', 'Cullinan', 2024, 4, 50000000, 5000000, 'Đỉnh cao SUV hạng sang, đẳng cấp hoàng gia.', 'Rolls_Royce_Cullinan.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(20, 'Mazda 3 Luxury', '51-S2-002.01', 2, 'Oto', 'Mazda', '3', 2023, 5, 1000000, 130000, 'Ngôn ngữ thiết kế Kodo, nội thất tinh tế, hiện đại.', 'Mazda_3.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(21, 'Mazda 3 Luxury', '51-S2-002.02', 2, 'Oto', 'Mazda', '3', 2023, 5, 1000000, 130000, 'Ngôn ngữ thiết kế Kodo, nội thất tinh tế, hiện đại.', 'Mazda_3.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(22, 'Mazda 3 Luxury', '51-S2-002.03', 2, 'Oto', 'Mazda', '3', 2023, 5, 1000000, 130000, 'Ngôn ngữ thiết kế Kodo, nội thất tinh tế, hiện đại.', 'Mazda_3.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(23, 'Kia Carnival', '51-S2-002.04', 2, 'Oto', 'Kia', 'Carnival', 2023, 7, 2200000, 300000, 'Xe gia đình hạng sang, rộng rãi như phòng khách di động.', 'Kia_Carnival.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(24, 'Kia Carnival', '51-S2-002.05', 2, 'Oto', 'Kia', 'Carnival', 2023, 7, 2200000, 300000, 'Xe gia đình hạng sang, rộng rãi như phòng khách di động.', 'Kia_Carnival.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(25, 'Kia Carnival', '51-S2-002.06', 2, 'Oto', 'Kia', 'Carnival', 2023, 7, 2200000, 300000, 'Xe gia đình hạng sang, rộng rãi như phòng khách di động.', 'Kia_Carnival.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(26, 'VinFast VF8 Plus', '51-S2-002.07', 2, 'Oto', 'VinFast', 'VF8', 2023, 5, 1300000, 180000, 'Xe SUV điện thông minh, công nghệ tương lai.', 'VinFast_VF8.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(27, 'VinFast VF8 Plus', '51-S2-002.08', 2, 'Oto', 'VinFast', 'VF8', 2023, 5, 1300000, 180000, 'Xe SUV điện thông minh, công nghệ tương lai.', 'VinFast_VF8.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(28, 'VinFast VF8 Plus', '51-S2-002.09', 2, 'Oto', 'VinFast', 'VF8', 2023, 5, 1300000, 180000, 'Xe SUV điện thông minh, công nghệ tương lai.', 'VinFast_VF8.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(29, 'Yamaha Exciter 155', '59-S2-202.01', 2, 'Xemay', 'Yamaha', 'Exciter', 2023, 2, 250000, 35000, 'Vua côn tay phố thị, động cơ mạnh mẽ, thể thao.', 'Yamaha_Exciter.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(30, 'Yamaha Exciter 155', '59-S2-202.02', 2, 'Xemay', 'Yamaha', 'Exciter', 2023, 2, 250000, 35000, 'Vua côn tay phố thị, động cơ mạnh mẽ, thể thao.', 'Yamaha_Exciter.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(31, 'Yamaha Exciter 155', '59-S2-202.03', 2, 'Xemay', 'Yamaha', 'Exciter', 2023, 2, 250000, 35000, 'Vua côn tay phố thị, động cơ mạnh mẽ, thể thao.', 'Yamaha_Exciter.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(32, 'Yamaha Grande', '59-S2-202.04', 2, 'Xemay', 'Yamaha', 'Grande', 2023, 2, 200000, 30000, 'Xe ga thời trang nữ tính, tiết kiệm xăng hàng đầu.', 'Yamaha_Grande.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(33, 'Yamaha Grande', '59-S2-202.05', 2, 'Xemay', 'Yamaha', 'Grande', 2023, 2, 200000, 30000, 'Xe ga thời trang nữ tính, tiết kiệm xăng hàng đầu.', 'Yamaha_Grande.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(34, 'Yamaha Grande', '59-S2-202.06', 2, 'Xemay', 'Yamaha', 'Grande', 2023, 2, 200000, 30000, 'Xe ga thời trang nữ tính, tiết kiệm xăng hàng đầu.', 'Yamaha_Grande.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(35, 'Vespa Sprint S', '59-S2-202.07', 2, 'Xemay', 'Piaggio', 'Vespa', 2024, 2, 350000, 50000, 'Thiết kế Ý cổ điển, thanh lịch và cá tính.', 'Vespa_Sprint.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(36, 'Vespa Sprint S', '59-S2-202.08', 2, 'Xemay', 'Piaggio', 'Vespa', 2024, 2, 350000, 50000, 'Thiết kế Ý cổ điển, thanh lịch và cá tính.', 'Vespa_Sprint.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(37, 'Vespa Sprint S', '59-S2-202.09', 2, 'Xemay', 'Piaggio', 'Vespa', 2024, 2, 350000, 50000, 'Thiết kế Ý cổ điển, thanh lịch và cá tính.', 'Vespa_Sprint.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(38, 'Tesla Model S Plaid', '51-EV-002.00', 2, 'Oto', 'Tesla', 'Model S', 2024, 5, 12000000, 1800000, 'Siêu sedan điện, tăng tốc nhanh nhất thế giới.', 'Tesla_Model_S.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(39, 'Hyundai Accent', '51-S3-003.01', 3, 'Oto', 'Hyundai', 'Accent', 2023, 5, 800000, 100000, 'Ngoại hình trẻ trung, tiện nghi đầy đủ trong tầm giá.', 'Hyundai_Accent.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(40, 'Hyundai Accent', '51-S3-003.02', 3, 'Oto', 'Hyundai', 'Accent', 2023, 5, 800000, 100000, 'Ngoại hình trẻ trung, tiện nghi đầy đủ trong tầm giá.', 'Hyundai_Accent.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(41, 'Hyundai Accent', '51-S3-003.03', 3, 'Oto', 'Hyundai', 'Accent', 2023, 5, 800000, 100000, 'Ngoại hình trẻ trung, tiện nghi đầy đủ trong tầm giá.', 'Hyundai_Accent.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(42, 'Toyota Innova Cross', '51-S3-003.04', 3, 'Oto', 'Toyota', 'Innova', 2023, 7, 1200000, 160000, 'Xe đa dụng MPV, phù hợp chở khách và gia đình đông người.', 'Toyota_Innova.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(43, 'Toyota Innova Cross', '51-S3-003.05', 3, 'Oto', 'Toyota', 'Innova', 2023, 7, 1200000, 160000, 'Xe đa dụng MPV, phù hợp chở khách và gia đình đông người.', 'Toyota_Innova.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(44, 'Toyota Innova Cross', '51-S3-003.06', 3, 'Oto', 'Toyota', 'Innova', 2023, 7, 1200000, 160000, 'Xe đa dụng MPV, phù hợp chở khách và gia đình đông người.', 'Toyota_Innova.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(45, 'Toyota Fortuner Legender', '51-S3-003.07', 3, 'Oto', 'Toyota', 'Fortuner', 2022, 7, 1500000, 200000, 'SUV hầm hố, khung gầm chắc chắn, chinh phục mọi nẻo đường.', 'Toyota_Fortuner.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(46, 'Toyota Fortuner Legender', '51-S3-003.08', 3, 'Oto', 'Toyota', 'Fortuner', 2022, 7, 1500000, 200000, 'SUV hầm hố, khung gầm chắc chắn, chinh phục mọi nẻo đường.', 'Toyota_Fortuner.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(47, 'Toyota Fortuner Legender', '51-S3-003.09', 3, 'Oto', 'Toyota', 'Fortuner', 2022, 7, 1500000, 200000, 'SUV hầm hố, khung gầm chắc chắn, chinh phục mọi nẻo đường.', 'Toyota_Fortuner.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(48, 'Honda Wave Alpha', '59-S3-303.01', 3, 'Xemay', 'Honda', 'Wave', 2023, 2, 120000, 15000, 'Xe số kinh điển, bền bỉ và cực kỳ tiết kiệm.', 'Honda_Wave.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(49, 'Honda Wave Alpha', '59-S3-303.02', 3, 'Xemay', 'Honda', 'Wave', 2023, 2, 120000, 15000, 'Xe số kinh điển, bền bỉ và cực kỳ tiết kiệm.', 'Honda_Wave.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(50, 'Honda Wave Alpha', '59-S3-303.03', 3, 'Xemay', 'Honda', 'Wave', 2023, 2, 120000, 15000, 'Xe số kinh điển, bền bỉ và cực kỳ tiết kiệm.', 'Honda_Wave.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(51, 'Honda Winner X V3', '59-S3-303.04', 3, 'Xemay', 'Honda', 'Winner', 2024, 2, 250000, 35000, 'Phong cách thể thao, phanh ABS an toàn.', 'Honda_Winner.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(52, 'Honda Winner X V3', '59-S3-303.05', 3, 'Xemay', 'Honda', 'Winner', 2024, 2, 250000, 35000, 'Phong cách thể thao, phanh ABS an toàn.', 'Honda_Winner.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(53, 'Honda Winner X V3', '59-S3-303.06', 3, 'Xemay', 'Honda', 'Winner', 2024, 2, 250000, 35000, 'Phong cách thể thao, phanh ABS an toàn.', 'Honda_Winner.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(54, 'Yamaha Sirius FI', '59-S3-303.07', 3, 'Xemay', 'Yamaha', 'Sirius', 2023, 2, 130000, 18000, 'Xe số linh hoạt, động cơ phun xăng điện tử.', 'Yamaha_Sirius.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(55, 'Yamaha Sirius FI', '59-S3-303.08', 3, 'Xemay', 'Yamaha', 'Sirius', 2023, 2, 130000, 18000, 'Xe số linh hoạt, động cơ phun xăng điện tử.', 'Yamaha_Sirius.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(56, 'Yamaha Sirius FI', '59-S3-303.09', 3, 'Xemay', 'Yamaha', 'Sirius', 2023, 2, 130000, 18000, 'Xe số linh hoạt, động cơ phun xăng điện tử.', 'Yamaha_Sirius.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(57, 'Ducati Panigale V4 S', '59-PK-003.00', 3, 'Xemay', 'Ducati', 'Panigale', 2024, 1, 4500000, 600000, 'Siêu mô tô phân khối lớn, sức mạnh mãnh thú.', 'Ducati_Panigale.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(58, 'Mercedes C200 Avantgarde', '51-S4-004.01', 4, 'Oto', 'Mercedes', 'C200', 2023, 5, 2500000, 350000, 'Đẳng cấp xe Đức, sang trọng và lịch lãm.', 'Mercedes_C200.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(59, 'Mercedes C200 Avantgarde', '51-S4-004.02', 4, 'Oto', 'Mercedes', 'C200', 2023, 5, 2500000, 350000, 'Đẳng cấp xe Đức, sang trọng và lịch lãm.', 'Mercedes_C200.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(60, 'Mercedes C200 Avantgarde', '51-S4-004.03', 4, 'Oto', 'Mercedes', 'C200', 2023, 5, 2500000, 350000, 'Đẳng cấp xe Đức, sang trọng và lịch lãm.', 'Mercedes_C200.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(61, 'Ford Everest Titanium', '51-S4-004.04', 4, 'Oto', 'Ford', 'Everest', 2023, 7, 1800000, 250000, 'SUV cơ bắp Mỹ, nhiều công nghệ an toàn hiện đại.', 'Ford_Everest.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(62, 'Ford Everest Titanium', '51-S4-004.05', 4, 'Oto', 'Ford', 'Everest', 2023, 7, 1800000, 250000, 'SUV cơ bắp Mỹ, nhiều công nghệ an toàn hiện đại.', 'Ford_Everest.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(63, 'Ford Everest Titanium', '51-S4-004.06', 4, 'Oto', 'Ford', 'Everest', 2023, 7, 1800000, 250000, 'SUV cơ bắp Mỹ, nhiều công nghệ an toàn hiện đại.', 'Ford_Everest.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(64, 'Hyundai SantaFe Premium', '51-S4-004.07', 4, 'Oto', 'Hyundai', 'SantaFe', 2024, 7, 1700000, 230000, 'Diện mạo hoàn toàn mới, tiện nghi sang trọng.', 'Hyundai_SantaFe.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(65, 'Hyundai SantaFe Premium', '51-S4-004.08', 4, 'Oto', 'Hyundai', 'SantaFe', 2024, 7, 1700000, 230000, 'Diện mạo hoàn toàn mới, tiện nghi sang trọng.', 'Hyundai_SantaFe.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(66, 'Hyundai SantaFe Premium', '51-S4-004.09', 4, 'Oto', 'Hyundai', 'SantaFe', 2024, 7, 1700000, 230000, 'Diện mạo hoàn toàn mới, tiện nghi sang trọng.', 'Hyundai_SantaFe.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(67, 'Honda Lead Smartkey', '59-S4-404.01', 4, 'Xemay', 'Honda', 'Lead', 2023, 2, 200000, 28000, 'Cốp xe siêu rộng, lựa chọn số 1 cho phái đẹp.', 'Honda_Lead.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(68, 'Honda Lead Smartkey', '59-S4-404.02', 4, 'Xemay', 'Honda', 'Lead', 2023, 2, 200000, 28000, 'Cốp xe siêu rộng, lựa chọn số 1 cho phái đẹp.', 'Honda_Lead.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(69, 'Honda Lead Smartkey', '59-S4-404.03', 4, 'Xemay', 'Honda', 'Lead', 2023, 2, 200000, 28000, 'Cốp xe siêu rộng, lựa chọn số 1 cho phái đẹp.', 'Honda_Lead.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(70, 'Yamaha Janus', '59-S4-404.04', 4, 'Xemay', 'Yamaha', 'Janus', 2023, 2, 160000, 22000, 'Xe ga trẻ trung, nhỏ gọn cho sinh viên.', 'Yamaha_Janus.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(71, 'Yamaha Janus', '59-S4-404.05', 4, 'Xemay', 'Yamaha', 'Janus', 2023, 2, 160000, 22000, 'Xe ga trẻ trung, nhỏ gọn cho sinh viên.', 'Yamaha_Janus.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(72, 'Yamaha Janus', '59-S4-404.06', 4, 'Xemay', 'Yamaha', 'Janus', 2023, 2, 160000, 22000, 'Xe ga trẻ trung, nhỏ gọn cho sinh viên.', 'Yamaha_Janus.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(73, 'Yamaha NVX 155 V2', '59-S4-404.07', 4, 'Xemay', 'Yamaha', 'NVX', 2024, 2, 280000, 40000, 'Mô tô tay ga, động cơ 155cc VVA bốc lửa.', 'Yamaha_NVX.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(74, 'Yamaha NVX 155 V2', '59-S4-404.08', 4, 'Xemay', 'Yamaha', 'NVX', 2024, 2, 280000, 40000, 'Mô tô tay ga, động cơ 155cc VVA bốc lửa.', 'Yamaha_NVX.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(75, 'Yamaha NVX 155 V2', '59-S4-404.09', 4, 'Xemay', 'Yamaha', 'NVX', 2024, 2, 280000, 40000, 'Mô tô tay ga, động cơ 155cc VVA bốc lửa.', 'Yamaha_NVX.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(76, 'Ford Transit DCar Limousine', '51-BUS-004.00', 4, 'Oto', 'Ford', 'Transit', 2023, 10, 3500000, 500000, 'Xe vận chuyển cao cấp, khoang nội thất chuẩn 5 sao.', 'Ford_Transit.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(77, 'Kia Morning X-Line', '51-S5-005.01', 5, 'Oto', 'Kia', 'Morning', 2023, 5, 600000, 80000, 'Xe đô thị mini, dễ dàng luồn lách hẻm nhỏ.', 'Kia_Morning.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(78, 'Kia Morning X-Line', '51-S5-005.02', 5, 'Oto', 'Kia', 'Morning', 2023, 5, 600000, 80000, 'Xe đô thị mini, dễ dàng luồn lách hẻm nhỏ.', 'Kia_Morning.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(79, 'Kia Morning X-Line', '51-S5-005.03', 5, 'Oto', 'Kia', 'Morning', 2023, 5, 600000, 80000, 'Xe đô thị mini, dễ dàng luồn lách hẻm nhỏ.', 'Kia_Morning.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(80, 'Hyundai i10 Grand', '51-S5-005.04', 5, 'Oto', 'Hyundai', 'i10', 2023, 5, 650000, 85000, 'Rộng rãi nhất phân khúc hạng A, vận hành ổn định.', 'Hyundai_i10.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(81, 'Hyundai i10 Grand', '51-S5-005.05', 5, 'Oto', 'Hyundai', 'i10', 2023, 5, 650000, 85000, 'Rộng rãi nhất phân khúc hạng A, vận hành ổn định.', 'Hyundai_i10.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(82, 'Hyundai i10 Grand', '51-S5-005.06', 5, 'Oto', 'Hyundai', 'i10', 2023, 5, 650000, 85000, 'Rộng rãi nhất phân khúc hạng A, vận hành ổn định.', 'Hyundai_i10.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(83, 'Suzuki Swift Sport', '51-S5-005.07', 5, 'Oto', 'Suzuki', 'Swift', 2022, 5, 850000, 110000, 'Hatchback thời thượng, phong cách châu Âu.', 'Suzuki_Swift.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(84, 'Suzuki Swift Sport', '51-S5-005.08', 5, 'Oto', 'Suzuki', 'Swift', 2022, 5, 850000, 110000, 'Hatchback thời thượng, phong cách châu Âu.', 'Suzuki_Swift.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(85, 'Suzuki Swift Sport', '51-S5-005.09', 5, 'Oto', 'Suzuki', 'Swift', 2022, 5, 850000, 110000, 'Hatchback thời thượng, phong cách châu Âu.', 'Suzuki_Swift.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(86, 'Honda PCX 160', '59-S5-505.01', 5, 'Xemay', 'Honda', 'PCX', 2023, 2, 350000, 45000, 'Tư thế ngồi thoải mái, phù hợp cho những chuyến đi xa.', 'Honda_PCX.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(87, 'Honda PCX 160', '59-S5-505.02', 5, 'Xemay', 'Honda', 'PCX', 2023, 2, 350000, 45000, 'Tư thế ngồi thoải mái, phù hợp cho những chuyến đi xa.', 'Honda_PCX.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(88, 'Honda PCX 160', '59-S5-505.03', 5, 'Xemay', 'Honda', 'PCX', 2023, 2, 350000, 45000, 'Tư thế ngồi thoải mái, phù hợp cho những chuyến đi xa.', 'Honda_PCX.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(89, 'Honda Vario 160', '59-S5-505.04', 5, 'Xemay', 'Honda', 'Vario', 2024, 2, 280000, 40000, 'Kiểu dáng góc cạnh, tăng tốc ấn tượng.', 'Honda_Vario.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(90, 'Honda Vario 160', '59-S5-505.05', 5, 'Xemay', 'Honda', 'Vario', 2024, 2, 280000, 40000, 'Kiểu dáng góc cạnh, tăng tốc ấn tượng.', 'Honda_Vario.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(91, 'Honda Vario 160', '59-S5-505.06', 5, 'Xemay', 'Honda', 'Vario', 2024, 2, 280000, 40000, 'Kiểu dáng góc cạnh, tăng tốc ấn tượng.', 'Honda_Vario.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(92, 'Honda Rebel 300', '59-PK-505.07', 5, 'Xemay', 'Honda', 'Rebel', 2022, 2, 800000, 120000, 'Cruiser phong trần, đậm chất bụi bặm.', 'Honda_Rebel.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(93, 'Honda Rebel 300', '59-PK-505.08', 5, 'Xemay', 'Honda', 'Rebel', 2022, 2, 800000, 120000, 'Cruiser phong trần, đậm chất bụi bặm.', 'Honda_Rebel.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(94, 'Honda Rebel 300', '59-PK-505.09', 5, 'Xemay', 'Honda', 'Rebel', 2022, 2, 800000, 120000, 'Cruiser phong trần, đậm chất bụi bặm.', 'Honda_Rebel.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(95, 'Sidecar Ural Classic', '59-PK-005.00', 5, 'Xemay', 'Ural', 'Classic', 2022, 3, 1500000, 200000, 'Xe 3 bánh độc đáo, trải nghiệm hành trình mới lạ.', 'Ural_Classic.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(96, 'Toyota Camry 2.5Q', '51-S6-006.01', 6, 'Oto', 'Toyota', 'Camry', 2023, 5, 1600000, 220000, 'Biểu tượng của sự thành đạt, đẳng cấp doanh nhân.', 'Toyota_Camry.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(97, 'Toyota Camry 2.5Q', '51-S6-006.02', 6, 'Oto', 'Toyota', 'Camry', 2023, 5, 1600000, 220000, 'Biểu tượng của sự thành đạt, đẳng cấp doanh nhân.', 'Toyota_Camry.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(98, 'Toyota Camry 2.5Q', '51-S6-006.03', 6, 'Oto', 'Toyota', 'Camry', 2023, 5, 1600000, 220000, 'Biểu tượng của sự thành đạt, đẳng cấp doanh nhân.', 'Toyota_Camry.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(99, 'Toyota Corolla Altis', '51-S6-006.04', 6, 'Oto', 'Toyota', 'Altis', 2023, 5, 1100000, 150000, 'Vận hành tinh tế, bền bỉ và sang trọng thầm lặng.', 'Toyota_Altis.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(100, 'Toyota Corolla Altis', '51-S6-006.05', 6, 'Oto', 'Toyota', 'Altis', 2023, 5, 1100000, 150000, 'Vận hành tinh tế, bền bỉ và sang trọng thầm lặng.', 'Toyota_Altis.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(101, 'Toyota Corolla Altis', '51-S6-006.06', 6, 'Oto', 'Toyota', 'Altis', 2023, 5, 1100000, 150000, 'Vận hành tinh tế, bền bỉ và sang trọng thầm lặng.', 'Toyota_Altis.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(102, 'Toyota Corolla Cross', '51-S6-006.07', 6, 'Oto', 'Toyota', 'Corolla Cross', 2024, 5, 1300000, 170000, 'Crossover thời thượng, gầm cao linh hoạt trong phố.', 'Toyota_Corolla_Cross.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(103, 'Toyota Corolla Cross', '51-S6-006.08', 6, 'Oto', 'Toyota', 'Corolla Cross', 2024, 5, 1300000, 170000, 'Crossover thời thượng, gầm cao linh hoạt trong phố.', 'Toyota_Corolla_Cross.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(104, 'Toyota Corolla Cross', '51-S6-006.09', 6, 'Oto', 'Toyota', 'Corolla Cross', 2024, 5, 1300000, 170000, 'Crossover thời thượng, gầm cao linh hoạt trong phố.', 'Toyota_Corolla_Cross.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(105, 'Honda Future LED', '59-S6-606.01', 6, 'Xemay', 'Honda', 'Future', 2023, 2, 160000, 22000, 'Xe số cao cấp, động cơ êm ái, lịch lãm.', 'Honda_Future.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(106, 'Honda Future LED', '59-S6-606.02', 6, 'Xemay', 'Honda', 'Future', 2023, 2, 160000, 22000, 'Xe số cao cấp, động cơ êm ái, lịch lãm.', 'Honda_Future.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(107, 'Honda Future LED', '59-S6-606.03', 6, 'Xemay', 'Honda', 'Future', 2023, 2, 160000, 22000, 'Xe số cao cấp, động cơ êm ái, lịch lãm.', 'Honda_Future.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(108, 'Yamaha Jupiter Finn', '59-S6-606.04', 6, 'Xemay', 'Yamaha', 'Jupiter', 2023, 2, 150000, 20000, 'Phanh UBS an toàn, thiết kế thanh lịch cho mọi đối tượng.', 'Yamaha_Jupiter.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(109, 'Yamaha Jupiter Finn', '59-S6-606.05', 6, 'Xemay', 'Yamaha', 'Jupiter', 2023, 2, 150000, 20000, 'Phanh UBS an toàn, thiết kế thanh lịch cho mọi đối tượng.', 'Yamaha_Jupiter.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(110, 'Yamaha Jupiter Finn', '59-S6-606.06', 6, 'Xemay', 'Yamaha', 'Jupiter', 2023, 2, 150000, 20000, 'Phanh UBS an toàn, thiết kế thanh lịch cho mọi đối tượng.', 'Yamaha_Jupiter.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(111, 'Honda Super Cub C125', '59-S6-606.07', 6, 'Xemay', 'Honda', 'Cub', 2024, 2, 500000, 70000, 'Huyền thoại tái sinh, phong cách Retro quý tộc.', 'Honda_Cub.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(112, 'Honda Super Cub C125', '59-S6-606.08', 6, 'Xemay', 'Honda', 'Cub', 2024, 2, 500000, 70000, 'Huyền thoại tái sinh, phong cách Retro quý tộc.', 'Honda_Cub.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(113, 'Honda Super Cub C125', '59-S6-606.09', 6, 'Xemay', 'Honda', 'Cub', 2024, 2, 500000, 70000, 'Huyền thoại tái sinh, phong cách Retro quý tộc.', 'Honda_Cub.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(114, 'Vespa 150 Vintage 1960', '59-AK-006.00', 6, 'Xemay', 'Piaggio', 'Vespa', 1960, 2, 1000000, 150000, 'Vespa cổ nguyên bản, dành cho người yêu hoài niệm.', 'Vespa_Vintage.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(115, 'Ford Ranger Wildtrak', '51-S7-007.01', 7, 'Oto', 'Ford', 'Ranger', 2023, 5, 1400000, 180000, 'Vua bán tải, mạnh mẽ và đầy đủ tiện nghi như SUV.', 'Ford_Ranger.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(116, 'Ford Ranger Wildtrak', '51-S7-007.02', 7, 'Oto', 'Ford', 'Ranger', 2023, 5, 1400000, 180000, 'Vua bán tải, mạnh mẽ và đầy đủ tiện nghi như SUV.', 'Ford_Ranger.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(117, 'Ford Ranger Wildtrak', '51-S7-007.03', 7, 'Oto', 'Ford', 'Ranger', 2023, 5, 1400000, 180000, 'Vua bán tải, mạnh mẽ và đầy đủ tiện nghi như SUV.', 'Ford_Ranger.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(118, 'Mitsubishi Triton Athlete', '51-S7-007.04', 7, 'Oto', 'Mitsubishi', 'Triton', 2023, 5, 1200000, 160000, 'Thiết kế Dynamic Shield, bền bỉ và đa dụng.', 'Mitsubishi_Triton.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(119, 'Mitsubishi Triton Athlete', '51-S7-007.05', 7, 'Oto', 'Mitsubishi', 'Triton', 2023, 5, 1200000, 160000, 'Thiết kế Dynamic Shield, bền bỉ và đa dụng.', 'Mitsubishi_Triton.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(120, 'Mitsubishi Triton Athlete', '51-S7-007.06', 7, 'Oto', 'Mitsubishi', 'Triton', 2023, 5, 1200000, 160000, 'Thiết kế Dynamic Shield, bền bỉ và đa dụng.', 'Mitsubishi_Triton.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(121, 'Toyota Hilux Adventure', '51-S7-007.07', 7, 'Oto', 'Toyota', 'Hilux', 2024, 5, 1300000, 170000, 'Dòng bán tải bền bỉ nhất thế giới, sẵn sàng mọi địa hình.', 'Toyota_Hilux.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(122, 'Toyota Hilux Adventure', '51-S7-007.08', 7, 'Oto', 'Toyota', 'Hilux', 2024, 5, 1300000, 170000, 'Dòng bán tải bền bỉ nhất thế giới, sẵn sàng mọi địa hình.', 'Toyota_Hilux.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(123, 'Toyota Hilux Adventure', '51-S7-007.09', 7, 'Oto', 'Toyota', 'Hilux', 2024, 5, 1300000, 170000, 'Dòng bán tải bền bỉ nhất thế giới, sẵn sàng mọi địa hình.', 'Toyota_Hilux.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(124, 'Honda SH Mode', '59-S7-707.01', 7, 'Xemay', 'Honda', 'SH Mode', 2023, 2, 300000, 45000, 'Kiểu dáng sang trọng chuẩn Âu, vận hành mượt mà.', 'Honda_SH_Mode.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(125, 'Honda SH Mode', '59-S7-707.02', 7, 'Xemay', 'Honda', 'SH Mode', 2023, 2, 300000, 45000, 'Kiểu dáng sang trọng chuẩn Âu, vận hành mượt mà.', 'Honda_SH_Mode.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(126, 'Honda SH Mode', '59-S7-707.03', 7, 'Xemay', 'Honda', 'SH Mode', 2023, 2, 300000, 45000, 'Kiểu dáng sang trọng chuẩn Âu, vận hành mượt mà.', 'Honda_SH_Mode.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(127, 'Piaggio Medley 150', '59-S7-707.04', 7, 'Xemay', 'Piaggio', 'Medley', 2023, 2, 350000, 50000, 'Xe ga bánh lớn, an toàn tối đa với hệ thống ABS kép.', 'Piaggio_Medley.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(128, 'Piaggio Medley 150', '59-S7-707.05', 7, 'Xemay', 'Piaggio', 'Medley', 2023, 2, 350000, 50000, 'Xe ga bánh lớn, an toàn tối đa với hệ thống ABS kép.', 'Piaggio_Medley.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(129, 'Piaggio Medley 150', '59-S7-707.06', 7, 'Xemay', 'Piaggio', 'Medley', 2023, 2, 350000, 50000, 'Xe ga bánh lớn, an toàn tối đa với hệ thống ABS kép.', 'Piaggio_Medley.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(130, 'Yamaha FreeGo S', '59-S7-707.07', 7, 'Xemay', 'Yamaha', 'FreeGo', 2023, 2, 180000, 25000, 'Xe ga thể thao, tính năng hiện đại trong tầm giá.', 'Yamaha_FreeGo.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(131, 'Yamaha FreeGo S', '59-S7-707.08', 7, 'Xemay', 'Yamaha', 'FreeGo', 2023, 2, 180000, 25000, 'Xe ga thể thao, tính năng hiện đại trong tầm giá.', 'Yamaha_FreeGo.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(132, 'Yamaha FreeGo S', '59-S7-707.09', 7, 'Xemay', 'Yamaha', 'FreeGo', 2023, 2, 180000, 25000, 'Xe ga thể thao, tính năng hiện đại trong tầm giá.', 'Yamaha_FreeGo.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL),
(133, 'Land Rover Defender 110', '51-SUV-007.00', 7, 'Oto', 'Land Rover', 'Defender', 2024, 7, 8000000, 1200000, 'Biểu tượng Off-road thế giới, mạnh mẽ và kiêu hãnh.', 'Land_Rover_Defender.jpg', '2026-01-30 20:08:41', 'AVAILABLE', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `fk_orders_station` (`station_id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_vehicle` (`vehicle_id`);

--
-- Chỉ mục cho bảng `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_reviews_user` (`user_id`),
  ADD KEY `fk_reviews_order` (`order_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_rating` (`rating`),
  ADD KEY `idx_review_type` (`review_type`);

--
-- Chỉ mục cho bảng `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`station_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `fk_users_managed_station` (`managed_station_id`);

--
-- Chỉ mục cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `license_plate` (`license_plate`),
  ADD KEY `station_id` (`station_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `stations`
--
ALTER TABLE `stations`
  MODIFY `station_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`station_id`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_orders_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_managed_station` FOREIGN KEY (`managed_station_id`) REFERENCES `stations` (`station_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `stations` (`station_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
