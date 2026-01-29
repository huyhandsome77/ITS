-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 29, 2026 lúc 10:02 AM
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
  `order_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `notes` text COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'CASH',
  `payment_status` enum('UNPAID','PAID','REFUNDED') COLLATE utf8mb4_unicode_ci DEFAULT 'UNPAID',
  `status` enum('NEW','RENTING','WAITING_RETURN','COMPLETED','CANCELLED') COLLATE utf8mb4_unicode_ci DEFAULT 'NEW',
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `confirmed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `station_id`, `user_id`, `vehicle_id`, `start_date`, `start_time`, `end_date`, `end_time`, `actual_return_date`, `total_amount`, `deposit_amount`, `late_fee`, `notes`, `payment_method`, `payment_status`, `status`, `cancel_reason`, `cancelled_at`, `completed_at`, `created_at`, `confirmed_at`) VALUES
(1, 'DH001', 1, 2, 1, '2026-01-07', '00:00:00', '2026-01-10', '00:00:00', NULL, 3600000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05', NULL),
(2, 'DH002', 2, 3, 2, '2026-01-05', '00:00:00', '2026-01-12', '00:00:00', NULL, 10500000, 0, 0, NULL, 'CASH', 'UNPAID', 'RENTING', NULL, NULL, NULL, '2026-01-18 17:08:05', NULL),
(3, 'DH003', 3, 4, 3, '2026-01-01', '00:00:00', '2026-01-10', '00:00:00', NULL, 16200000, 0, 0, NULL, 'CASH', 'UNPAID', 'COMPLETED', NULL, NULL, NULL, '2026-01-18 17:08:05', NULL),
(4, 'DH004', 1, 2, 4, '2026-01-15', '00:00:00', '2026-01-16', '00:00:00', NULL, 900000, 0, 0, NULL, 'CASH', 'UNPAID', 'COMPLETED', NULL, NULL, NULL, '2026-01-18 17:08:05', NULL),
(5, 'DH005', 4, 3, 5, '2026-01-18', '00:00:00', '2026-01-18', '00:00:00', NULL, 150000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05', NULL),
(6, 'DH006', 2, 2, 6, '2026-01-20', '00:00:00', '2026-01-20', '00:00:00', NULL, 200000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05', NULL),
(32, 'DH007', 1, 2, 1, '2026-01-10', '00:00:00', '2026-01-12', '00:00:00', '2026-01-12 09:00:00', 1200000, 0, 0, 'Khách trả xe sạch sẽ', 'CASH', 'UNPAID', 'COMPLETED', NULL, NULL, '2026-01-12 09:15:00', '2026-01-08 07:00:00', NULL),
(33, 'DH008', 2, 3, 2, '2026-01-20', '00:00:00', '2026-01-25', '00:00:00', NULL, 4500000, 0, 0, 'Thuê đi công tác', 'CASH', 'UNPAID', 'RENTING', NULL, NULL, NULL, '2026-01-19 02:15:00', NULL),
(34, 'DH009', 1, 4, 3, '2026-01-22', '00:00:00', '2026-01-23', '00:00:00', NULL, 500000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', 'Tài khoản người dùng bị khóa', '2026-01-22 10:00:00', NULL, '2026-01-21 01:00:00', NULL),
(35, 'DH010', 3, 2, 4, '2026-02-01', '00:00:00', '2026-02-05', '00:00:00', NULL, 3000000, 0, 0, 'Đặt trước cho kỳ nghỉ', 'CASH', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-24 01:00:00', NULL),
(36, 'DH011', 2, 3, 1, '2026-01-18', '00:00:00', '2026-01-22', '00:00:00', NULL, 2000000, 0, 0, 'Khách chưa thấy liên hệ', 'CASH', 'UNPAID', 'WAITING_RETURN', NULL, NULL, NULL, '2026-01-17 08:00:00', NULL),
(37, 'DHD9288', 15, 1, 22, '2026-01-26', '01:30:00', '2026-01-25', '03:30:00', NULL, 180000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 16:51:41', NULL),
(38, 'DH628B6', 15, 1, 22, '2026-01-27', '00:00:00', '2026-01-28', '00:00:00', NULL, 800000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 17:16:17', NULL),
(39, 'DHBD404', 15, 1, 22, '2026-01-28', '00:00:00', '2026-01-28', '03:00:00', NULL, 270000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 17:21:19', NULL),
(40, 'DH8CCDE', 15, 1, 22, '2026-01-29', '00:00:00', '2026-01-29', '02:00:00', NULL, 180000, 0, 0, NULL, 'MOMO', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:00:39', NULL),
(41, 'DH10024', 15, 1, 22, '2026-01-30', '00:30:00', '2026-01-30', '04:30:00', NULL, 360000, 0, 0, NULL, 'MOMO', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:12:55', NULL),
(42, 'DHDDE60', 15, 1, 21, '2026-01-27', '05:00:00', '2026-01-27', '08:00:00', NULL, 300000, 0, 0, NULL, 'MOMO', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:23:04', NULL),
(43, 'DH13ACA', 17, 1, 26, '2026-01-28', '00:00:00', '2026-01-28', '02:00:00', NULL, 240000, 0, 0, NULL, 'MOMO', 'PAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:30:10', NULL),
(44, 'DH18F7E', 17, 1, 25, '2026-01-29', '00:00:00', '2026-01-31', '00:00:00', NULL, 4000000, 0, 0, NULL, 'MOMO', 'PAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:33:06', NULL),
(45, 'DHA546A', 15, 1, 20, '2026-01-31', '00:00:00', '2026-01-31', '04:00:00', NULL, 600000, 0, 0, NULL, 'MOMO', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:39:39', NULL),
(46, 'DHED03E', 15, 1, 20, '2026-01-31', '05:00:00', '2026-01-31', '09:00:00', NULL, 600000, 0, 0, NULL, 'MOMO', 'PAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:40:59', NULL),
(47, 'DH59407', 15, 1, 23, '2026-01-31', '04:00:00', '2026-01-31', '09:00:00', NULL, 200000, 0, 0, NULL, 'CASH', 'UNPAID', 'CANCELLED', 'Payment Timeout', NULL, NULL, '2026-01-26 18:44:19', NULL),
(48, 'DHB2B4E', 15, 1, 22, '2026-01-29', '00:00:00', '2026-01-29', '04:00:00', NULL, 360000, 0, 0, NULL, 'CASH', 'UNPAID', 'COMPLETED', NULL, NULL, NULL, '2026-01-27 14:13:39', NULL),
(49, 'DH46852', 15, 1, 22, '2026-01-31', '00:00:00', '2026-02-01', '00:00:00', NULL, 1600000, 0, 0, '', 'CASH', 'UNPAID', 'COMPLETED', NULL, NULL, NULL, '2026-01-29 06:15:36', NULL);

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
(1, 'DHDDE60', 'MOMO', 300000, '4655049324', -1, 'Thành công.', '2026-01-26 18:23:24'),
(2, 'DH13ACA', 'MOMO', 240000, '4655069170', 0, 'Thành công.', '2026-01-26 18:30:46'),
(3, 'DH18F7E', 'MOMO', 4000000, '4655050356', 0, 'Thành công.', '2026-01-26 18:33:38'),
(4, 'DHED03E', 'MOMO', 600000, '4655080429', 0, 'Thành công.', '2026-01-26 18:41:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_id` int NOT NULL,
  `review_type` enum('VEHICLE','STATION','SERVICE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'VEHICLE',
  `rating` tinyint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `status` enum('PENDING','APPROVED','REJECTED','HIDDEN') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `report_reason` text COLLATE utf8mb4_unicode_ci,
  `is_reported` tinyint(1) NOT NULL DEFAULT '0',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reply` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `replied_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `order_id`, `review_type`, `rating`, `comment`, `status`, `report_reason`, `is_reported`, `admin_note`, `created_at`, `updated_at`, `reply`, `replied_at`) VALUES
(1, 4, 3, 'VEHICLE', 5, 'Xe rất mới, chạy êm, đúng như mô tả.', 'APPROVED', NULL, 0, NULL, '2026-01-11 03:00:00', '2026-01-11 03:10:00', NULL, NULL),
(2, 4, 3, 'STATION', 4, 'Trạm phục vụ nhanh, nhân viên thân thiện.', 'APPROVED', NULL, 0, NULL, '2026-01-11 03:05:00', '2026-01-11 03:10:00', NULL, NULL),
(3, 2, 4, 'VEHICLE', 3, 'Xe ổn nhưng nội thất hơi cũ.', 'APPROVED', NULL, 0, 'Nội dung hợp lệ', '2026-01-16 02:30:00', '2026-01-16 03:00:00', NULL, NULL),
(4, 2, 32, 'SERVICE', 5, 'Dịch vụ thuê xe rất tốt, sẽ quay lại.', 'APPROVED', NULL, 0, NULL, '2026-01-12 03:00:00', '2026-01-12 03:05:00', NULL, NULL),
(5, 2, 32, 'STATION', 1, 'Nhân viên thái độ kém!!!', 'PENDING', 'Ngôn từ tiêu cực', 1, NULL, '2026-01-12 03:10:00', '2026-01-12 03:10:00', NULL, NULL),
(6, 3, 36, 'VEHICLE', 4, 'Xe chạy tốt, đang chờ trả.', 'APPROVED', NULL, 0, NULL, '2026-01-21 07:00:00', '2026-01-28 05:29:25', NULL, NULL),
(7, 3, 36, 'SERVICE', 2, 'Dịch vụ quá tệ, không hài lòng.', 'REJECTED', 'Thông tin không đủ xác thực', 1, 'Review mang tính công kích', '2026-01-21 07:05:00', '2026-01-21 08:00:00', NULL, NULL),
(8, 1, 48, 'VEHICLE', 5, 'Xe rất tốt, đúng giờ, giá hợp lý.', 'HIDDEN', NULL, 0, NULL, '2026-01-27 08:00:00', '2026-01-28 05:29:09', NULL, NULL),
(9, 1, 48, 'STATION', 2, 'Trạm hơi khó tìm.', 'HIDDEN', NULL, 0, 'Ẩn theo yêu cầu quản trị', '2026-01-27 08:10:00', '2026-01-28 05:54:53', 'Xin lỗi quý khách vì trải nghiệm không tốt', '2026-01-28 05:54:53'),
(10, 1, 49, 'VEHICLE', 5, 'Tốt', 'APPROVED', NULL, 0, NULL, '2026-01-29 06:17:38', '2026-01-29 06:21:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stations`
--

CREATE TABLE `stations` (
  `station_id` int NOT NULL,
  `station_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `stations`
--

INSERT INTO `stations` (`station_id`, `station_name`, `address`, `district`, `city`, `created_at`, `is_maintenance`, `status`, `latitude`, `longitude`) VALUES
(1, 'Nguyễn Huệ - Q1', '123 Nguyễn Huệ, Quận 1', NULL, NULL, '2026-01-18 17:07:48', 0, 'ACTIVE', 21.17176400, 106.05996000),
(2, 'Lê Lợi - Q1', '45 Lê Lợi, Quận 1', NULL, NULL, '2026-01-18 17:07:48', 0, 'ACTIVE', 21.14133600, 105.50574000),
(3, 'Võ Văn Tần - Q3', '78 Võ Văn Tần, Quận 3', NULL, NULL, '2026-01-18 17:07:48', 0, 'ACTIVE', 22.41953300, 104.02032200),
(4, 'Hoàng Văn Thụ - Tân Bình', '12 Hoàng Văn Thụ, Tân Bình', NULL, NULL, '2026-01-18 17:07:48', 0, 'ACTIVE', 21.96823100, 106.36115000),
(6, 'Trạm Lê Lợi - Q1', '45 Lê Lợi, Quận 1, TP.HCM', NULL, NULL, '2026-01-19 09:33:11', 0, 'ACTIVE', 15.56817448, 108.47573161),
(7, 'Trạm Võ Văn Tần - Q3', '88 Võ Văn Tần, Quận 3, TP.HCM', NULL, NULL, '2026-01-19 09:33:11', 0, 'ACTIVE', 13.78183000, 109.22677800),
(8, 'Trạm Cách Mạng Tháng 8 - Q10', '120 CMT8, Quận 10, TP.HCM', NULL, NULL, '2026-01-19 09:33:11', 0, 'ACTIVE', NULL, NULL),
(9, 'Trạm Bảo Trì Trung Tâm', '200 Điện Biên Phủ, Quận Bình Thạnh', NULL, NULL, '2026-01-19 09:33:11', 0, 'INACTIVE', 21.35967400, 103.02346000),
(10, 'Trạm Bảo Trì Kỹ Thuật', '15 Nguyễn Thị Minh Khai, Quận 1', NULL, NULL, '2026-01-19 09:33:11', 0, 'INACTIVE', 21.19635500, 106.06776400),
(15, 'Trạm 11', '12 Nguyễn Huệ, Bến Nghé', 'Quận 1', 'TP. Hồ Chí Minh', '2026-01-24 00:56:20', 0, 'ACTIVE', 10.77299520, 106.70516820),
(17, 'Trạm Võ Oanh, Bình Thạnh', '02 Võ Oanh, Phường 25', 'Quận Bình Thạnh', 'TP. Hồ Chí Minh', '2026-01-25 07:55:20', 0, 'ACTIVE', 10.80425702, 106.71657801);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `id_card_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `driver_license_number` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('USER','STATION','ADMIN','DISPATCHER') COLLATE utf8mb4_unicode_ci DEFAULT 'USER',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','BLOCKED') COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
  `is_verified` enum('PENDING','VERIFIED','REJECTED') COLLATE utf8mb4_unicode_ci DEFAULT 'PENDING',
  `verified_at` datetime DEFAULT NULL,
  `verification_note` text COLLATE utf8mb4_unicode_ci,
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
(1, 'Nguyen Anh Huy', 'soicaca77@gmail.com', '0386699723', '$2y$10$vM.cJyEINjknC8EKrYlT6OwRW4HwTHQyspTdzj7pNr7avPajBKcam', '2005-11-17', '052205001707', '065515156165', 'ADMIN', '1_1769529263.jpg', 'ACTIVE', 'VERIFIED', '2026-01-29 07:15:16', NULL, '2025-12-28 14:10:42', NULL, 'Nguyễn Anh Huy', '2026-01-28', 'Cục Cảnh sát quản lý hành chính về trật tự xã hội', '1_id_card_front_1769667208.jpg', '1_id_card_back_1769667211.jpg', '1_face_image_1769667213.jpg', '1_driver_license_front_1769667218.jpg', '1_driver_license_back_1769667220.jpg', '086826269999', 'Nguyễn Anh Huy', 'MB BANK', 'Tây Bình, Tây Sơn, Bình Định', '0386699723', 'Nguyễn Anh Huy'),
(2, 'Nguyen Anh Huy', 'kolshoppe100@gmail.com', NULL, '$2y$10$CCXQMhxeKtzMh6UHq.FuBug8jofOXxBPRI064Mib.nYCMCngdfLS6', NULL, NULL, NULL, 'USER', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-11 07:43:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Huy Nguyễn Anh', 'soicacwa77@gmail.com', '6019521325', '$2y$10$TbwxcTFjtt9pbyqI562gT.5YiUmbL9KKOUrJmgnuj4qiJ5KQWlDQS', '2026-02-07', NULL, NULL, 'USER', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-15 15:01:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Huy Nguyễn Anh', '1111dwdwdw@gmail.com', '03741888267', '$2y$10$jy/dRh2M8fNduxfjuJbRD.6JUoZcoTPT0qKiNWVPLaZi/qLbWNM4K', '2026-01-21', NULL, NULL, 'USER', '1.png', 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-15 15:02:48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Huy Nguyễn Anh', 'ng.anhhuy2005@gmail.com', '0374188826', '$2y$10$ACH/fATQkgi0cmgICbMJY.ys5yH0lKVsAkLDv3aB2dQFkU1C2opiK', '2026-01-20', NULL, NULL, 'STATION', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-25 13:42:46', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Nguyen Anh Huy', 'soicaca771@gmail.com', NULL, '$2y$10$y61YMEloVFbjVvznzPbKjuFgwaSwgiATieq/NACgkA.Q39FfiTb7y', NULL, NULL, NULL, 'USER', NULL, 'ACTIVE', 'PENDING', NULL, NULL, '2026-01-29 05:54:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int NOT NULL,
  `vehicle_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license_plate` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `station_id` int DEFAULT NULL,
  `vehicle_type` enum('Oto','Xemay') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int DEFAULT NULL,
  `seats` int DEFAULT NULL,
  `price_per_day` decimal(12,0) NOT NULL,
  `price_per_hour` decimal(12,0) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('AVAILABLE','RENTED','MAINTENANCE') COLLATE utf8mb4_unicode_ci DEFAULT 'AVAILABLE',
  `last_maintenance_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_name`, `license_plate`, `station_id`, `vehicle_type`, `brand`, `model`, `year`, `seats`, `price_per_day`, `price_per_hour`, `description`, `image`, `created_at`, `status`, `last_maintenance_date`) VALUES
(1, 'Toyota Camry', '51G-12345', 1, 'Oto', 'Toyota', 'Camry', 2022, 5, 1200000, 150000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(2, 'Honda CR-V', '51H-67890', 2, 'Oto', 'Honda', 'CR-V', 2023, 7, 1500000, 180000, NULL, NULL, '2026-01-19 12:22:13', 'RENTED', NULL),
(3, 'Ford Tourneo', '51F-24680', 3, 'Oto', 'Ford', 'Tourneo', 2021, 9, 1800000, 200000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(4, 'Toyota Vios', '51A-99999', 1, 'Oto', 'Toyota', 'Vios', 2022, 5, 900000, 120000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(5, 'Honda Wave', '59X1-88888', 4, 'Xemay', 'Honda', 'Wave', 2023, 2, 150000, 30000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(6, 'Yamaha Exciter', '59X1-77777', 2, 'Xemay', 'Yamaha', 'Exciter', 2023, 2, 200000, 40000, NULL, NULL, '2026-01-19 12:22:13', 'MAINTENANCE', NULL),
(13, 'Toyota Camry', '51G-99901', 1, 'Oto', 'Toyota', 'Camry', 2022, 5, 1200000, 150000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(14, 'Honda Civic', '51G-99902', 1, 'Oto', 'Honda', 'Civic', 2023, 5, 1000000, 130000, NULL, NULL, '2026-01-19 12:22:13', 'RENTED', NULL),
(15, 'Mazda CX-5', '51H-99903', 2, 'Oto', 'Mazda', 'CX-5', 2022, 5, 1100000, 140000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(16, 'Yamaha Exciter', '59X1-99904', 2, 'Xemay', 'Yamaha', 'Exciter', 2023, 2, 150000, 30000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(17, 'Ford Ranger', '51C-99905', 6, 'Oto', 'Ford', 'Ranger', 2023, 5, 1300000, 160000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(18, 'Honda SH', '59X2-99906', 6, 'Xemay', 'Honda', 'SH', 2023, 2, 200000, 40000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE', NULL),
(20, 'VinFast Lux A2.0', '51K-123.45', 10, 'Oto', 'VinFast', 'Lux A2.0', 2023, 5, 1200000, 150000, 'Xe sang trọng, mạnh mẽ', 'vinfast-lux-a.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(21, 'Mazda 3 Luxury', '51K-234.56', 10, 'Oto', 'Mazda', 'Mazda 3', 2023, 5, 900000, 100000, 'Thiết kế đẹp, tiết kiệm xăng', 'mazda-3.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(22, 'Honda City RS', '51K-345.67', 15, 'Oto', 'Honda', 'City', 2022, 5, 800000, 90000, 'Nhỏ gọn, linh hoạt phố đông', 'honda-city.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(23, 'Honda SH 150i', '59-S1 123.45', 15, 'Xemay', 'Honda', 'SH', 2023, 2, 250000, 40000, 'Xe tay ga cao cấp', 'honda-sh.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(24, 'Honda Vision', '59-S1 234.56', 15, 'Xemay', 'Honda', 'Vision', 2022, 2, 120000, 20000, 'Xe nhỏ gọn cho nữ', 'honda-vision.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(25, 'Kia Carnival', '51K-888.88', 9, 'Oto', 'Kia', 'Carnival', 2023, 7, 2000000, 250000, 'Xe gia đình 7 chỗ rộng rãi', 'kia-carnival.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(26, 'Mitsubishi Xpander', '51K-777.77', 9, 'Oto', 'Mitsubishi', 'Xpander', 2023, 7, 1000000, 120000, '7 chỗ giá rẻ, tiết kiệm', 'mitsubishi-xpander.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(27, 'Toyota Vios G', '51K-666.66', 17, 'Oto', 'Toyota', 'Vios', 2022, 5, 800000, 90000, 'Vua doanh số, bền bỉ', 'toyota-vios.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(28, 'Yamaha Grande', '59-B1 555.55', 17, 'Xemay', 'Yamaha', 'Grande', 2023, 2, 150000, 25000, 'Xe tay ga thời trang', 'yamaha-grande.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(29, 'Honda AirBlade 160', '59-B1 444.44', 17, 'Xemay', 'Honda', 'AirBlade', 2023, 2, 180000, 30000, 'Mạnh mẽ, thể thao', 'honda-airblade.jpg', '2026-01-25 11:07:20', 'AVAILABLE', NULL),
(30, 'Mercedes C200 Avantgarde', '51G-02005', 15, 'Oto', 'Mercedes', 'C200 Avantgarde', 2018, 4, 700000, 100000, 'Kích thước tổng thể tăng thêm 5 cm, thiết kế nội thất sang trọng lấy cảm hứng từ S-Class, cùng động cơ tinh chỉnh kết hợp công nghệ EQ-Boost, mang đến trải nghiệm lái phấn khích cho người dùng Việt Nam trong suốt vòng đời sản phẩm.', 'vehicle_697a462750b37.jpg', '2026-01-28 17:23:51', 'AVAILABLE', NULL);

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
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `stations`
--
ALTER TABLE `stations`
  MODIFY `station_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
