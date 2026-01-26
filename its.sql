-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th1 26, 2026 lúc 08:50 PM
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
-- Cơ sở dữ liệu: `its`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_code` varchar(10) NOT NULL,
  `station_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `actual_return_date` datetime DEFAULT NULL,
  `total_amount` decimal(12,0) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('NEW','RENTING','WAITING_RETURN','COMPLETED','CANCELLED') DEFAULT 'NEW',
  `cancel_reason` varchar(255) DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `station_id`, `user_id`, `vehicle_id`, `start_date`, `end_date`, `actual_return_date`, `total_amount`, `notes`, `status`, `cancel_reason`, `cancelled_at`, `completed_at`, `created_at`) VALUES
(1, 'DH001', 1, 2, 1, '2026-01-07', '2026-01-10', NULL, 3600000, NULL, 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(2, 'DH002', 2, 3, 2, '2026-01-05', '2026-01-12', '2026-01-25 17:22:16', 10500000, NULL, 'COMPLETED', NULL, NULL, '2026-01-25 17:22:40', '2026-01-18 17:08:05'),
(3, 'DH003', 3, 4, 3, '2026-01-01', '2026-01-10', NULL, 16200000, NULL, 'COMPLETED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(4, 'DH004', 1, 2, 4, '2026-01-15', '2026-01-16', NULL, 900000, NULL, 'COMPLETED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(5, 'DH005', 4, 3, 5, '2026-01-18', '2026-01-18', NULL, 150000, NULL, 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(6, 'DH006', 2, 2, 6, '2026-01-20', '2026-01-20', NULL, 200000, NULL, 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `stations`
--

CREATE TABLE `stations` (
  `station_id` int(11) NOT NULL,
  `station_name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `is_maintenance` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `stations`
--

INSERT INTO `stations` (`station_id`, `station_name`, `address`, `created_at`, `is_maintenance`, `status`) VALUES
(1, 'Nguyễn Huệ - Q1', '123 Nguyễn Huệ, Quận 1', '2026-01-18 17:07:48', 0, 'ACTIVE'),
(2, 'Lê Lợi - Q1', '45 Lê Lợi, Quận 1', '2026-01-18 17:07:48', 0, 'ACTIVE'),
(3, 'Võ Văn Tần - Q3', '78 Võ Văn Tần, Quận 3', '2026-01-18 17:07:48', 0, 'ACTIVE'),
(4, 'Hoàng Văn Thụ - Tân Bình', '12 Hoàng Văn Thụ, Tân Bình', '2026-01-18 17:07:48', 0, 'ACTIVE'),
(6, 'Trạm Lê Lợi - Q1', '45 Lê Lợi, Quận 1, TP.HCM', '2026-01-19 09:33:11', 0, 'ACTIVE'),
(7, 'Trạm Võ Văn Tần - Q3', '88 Võ Văn Tần, Quận 3, TP.HCM', '2026-01-19 09:33:11', 0, 'ACTIVE'),
(8, 'Trạm Cách Mạng Tháng 8 - Q10', '120 CMT8, Quận 10, TP.HCM', '2026-01-19 09:33:11', 0, 'ACTIVE'),
(9, 'Trạm Bảo Trì Trung Tâm', '200 Điện Biên Phủ, Quận Bình Thạnh', '2026-01-19 09:33:11', 0, 'INACTIVE'),
(10, 'Trạm Bảo Trì Kỹ Thuật', '15 Nguyễn Thị Minh Khai, Quận 1', '2026-01-19 09:33:11', 1, 'INACTIVE');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `id_card_number` varchar(20) DEFAULT NULL COMMENT 'Số CCCD/CMND',
  `id_card_name` varchar(100) DEFAULT NULL COMMENT 'Họ tên trên CCCD',
  `id_card_date` date DEFAULT NULL COMMENT 'Ngày cấp CCCD',
  `id_card_place` varchar(100) DEFAULT NULL COMMENT 'Nơi cấp CCCD',
  `id_card_front` varchar(255) DEFAULT NULL COMMENT 'Ảnh CCCD mặt trước',
  `id_card_back` varchar(255) DEFAULT NULL COMMENT 'Ảnh CCCD mặt sau',
  `face_image` varchar(255) DEFAULT NULL COMMENT 'Ảnh khuôn mặt xác thực',
  `driver_license_number` varchar(20) DEFAULT NULL COMMENT 'Số bằng lái xe',
  `driver_license_front` varchar(255) DEFAULT NULL COMMENT 'Ảnh bằng lái mặt trước',
  `driver_license_back` varchar(255) DEFAULT NULL COMMENT 'Ảnh bằng lái mặt sau',
  `bank_account_number` varchar(50) DEFAULT NULL COMMENT 'Số tài khoản ngân hàng',
  `bank_account_name` varchar(100) DEFAULT NULL COMMENT 'Tên chủ tài khoản',
  `bank_name` varchar(100) DEFAULT NULL COMMENT 'Tên ngân hàng',
  `address` varchar(255) DEFAULT NULL COMMENT 'Địa chỉ thường trú',
  `emergency_contact` varchar(20) DEFAULT NULL COMMENT 'SĐT người thân khẩn cấp',
  `emergency_name` varchar(100) DEFAULT NULL COMMENT 'Tên người thân khẩn cấp',
  `is_verified` enum('PENDING','VERIFIED','REJECTED') DEFAULT 'PENDING' COMMENT 'Trạng thái xác minh',
  `verified_at` datetime DEFAULT NULL COMMENT 'Thời gian xác minh',
  `verification_note` text DEFAULT NULL COMMENT 'Ghi chú xác minh (lý do từ chối)',
  `role` enum('USER','STATION','ADMIN') DEFAULT 'USER',
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','BLOCKED') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `station_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Bảng người dùng với thông tin xác minh KYC';

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `birthday`, `id_card_number`, `id_card_name`, `id_card_date`, `id_card_place`, `id_card_front`, `id_card_back`, `face_image`, `driver_license_number`, `driver_license_front`, `driver_license_back`, `bank_account_number`, `bank_account_name`, `bank_name`, `address`, `emergency_contact`, `emergency_name`, `is_verified`, `verified_at`, `verification_note`, `role`, `avatar`, `status`, `created_at`, `station_id`) VALUES
(1, 'Nguyen Anh Huy', 'soicaca77@gmail.com', '', '$2y$10$vM.cJyEINjknC8EKrYlT6OwRW4HwTHQyspTdzj7pNr7avPajBKcam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING', NULL, NULL, 'ADMIN', NULL, 'ACTIVE', '2025-12-28 14:10:42', NULL),
(2, 'Nguyen Anh Huy', 'kolshoppe100@gmail.com', NULL, '$2y$10$CCXQMhxeKtzMh6UHq.FuBug8jofOXxBPRI064Mib.nYCMCngdfLS6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING', NULL, NULL, 'USER', NULL, 'ACTIVE', '2026-01-11 07:43:45', NULL),
(3, 'Huy Nguyễn Anh', 'soicacwa77@gmail.com', '6019521325', '$2y$10$TbwxcTFjtt9pbyqI562gT.5YiUmbL9KKOUrJmgnuj4qiJ5KQWlDQS', '2026-02-07', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING', NULL, NULL, 'USER', NULL, 'ACTIVE', '2026-01-15 15:01:07', NULL),
(4, 'Nguyễn Phước Thịnh', '1111dwdwdw@gmail.com', '0374188826', '$2y$10$jy/dRh2M8fNduxfjuJbRD.6JUoZcoTPT0qKiNWVPLaZi/qLbWNM4K', '2026-01-21', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'REJECTED', NULL, 'hông thích cho âpp', 'USER', '1.png', 'ACTIVE', '2026-01-15 15:02:48', NULL),
(5, 'LeThanh', 'HaiConVit@gmail.com', NULL, '$2y$10$35S0at784D2w6Ktzq28pcODVcBTHTirckqAc8saxikDaA10uIaYy.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING', NULL, NULL, 'STATION', '5_1769450494.jpg', 'ACTIVE', '2026-01-25 09:13:30', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `license_plate` varchar(20) NOT NULL,
  `station_id` int(11) DEFAULT NULL,
  `vehicle_type` enum('Oto','Xemay') DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `price_per_day` decimal(12,0) NOT NULL,
  `price_per_hour` decimal(12,0) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('AVAILABLE','RENTED','MAINTENANCE') DEFAULT 'AVAILABLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_name`, `license_plate`, `station_id`, `vehicle_type`, `brand`, `model`, `year`, `seats`, `price_per_day`, `price_per_hour`, `description`, `image`, `created_at`, `status`) VALUES
(1, 'Toyota Camry', '51G-12345', 1, 'Oto', 'Toyota', 'Camry', 2022, 5, 1200000, 150000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(2, 'Honda CR-V', '51H-67890', 2, 'Oto', 'Honda', 'CR-V', 2023, 7, 1500000, 180000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(3, 'Ford Tourneo', '51F-24680', 3, 'Oto', 'Ford', 'Tourneo', 2021, 9, 1800000, 200000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(4, 'Toyota Vios', '51A-99999', 1, 'Oto', 'Toyota', 'Vios', 2022, 5, 900000, 120000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(5, 'Honda Wave', '59X1-88888', 4, 'Xemay', 'Honda', 'Wave', 2023, 2, 150000, 30000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(6, 'Yamaha Exciter', '59X1-77777', 2, 'Xemay', 'Yamaha', 'Exciter', 2023, 2, 200000, 40000, NULL, NULL, '2026-01-19 12:22:13', 'MAINTENANCE'),
(13, 'Toyota Camry', '51G-99901', 1, 'Oto', 'Toyota', 'Camry', 2022, 5, 1200000, 150000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(14, 'Honda Civic', '51G-99902', 1, 'Oto', 'Honda', 'Civic', 2023, 5, 1000000, 130000, NULL, NULL, '2026-01-19 12:22:13', 'RENTED'),
(15, 'Mazda CX-5', '51H-99903', 2, 'Oto', 'Mazda', 'CX-5', 2022, 5, 1100000, 140000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(16, 'Yamaha Exciter', '59X1-99904', 2, 'Xemay', 'Yamaha', 'Exciter', 2023, 2, 150000, 30000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(17, 'Ford Ranger', '51C-99905', 6, 'Oto', 'Ford', 'Ranger', 2023, 5, 1300000, 160000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(18, 'Honda SH', '59X2-99906', 6, 'Xemay', 'Honda', 'SH', 2023, 2, 200000, 40000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(20, 'bá dơ', '59X2-9123123123', 1, 'Oto', 'Honda', 'sfdasdfasdf', 2021, 12, 1231231313, 123123, 'úm ba la xì bùa', NULL, '2026-01-25 09:57:49', 'AVAILABLE');

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
  ADD KEY `station_id` (`station_id`),
  ADD KEY `idx_id_card_number` (`id_card_number`),
  ADD KEY `idx_is_verified` (`is_verified`),
  ADD KEY `idx_driver_license` (`driver_license_number`);

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
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `stations`
--
ALTER TABLE `stations`
  MODIFY `station_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `stations` (`station_id`);

--
-- Các ràng buộc cho bảng `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `stations` (`station_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
