-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 02:58 PM
-- Server version: 8.0.40
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `its`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `order_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `station_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `actual_return_date` datetime DEFAULT NULL,
  `total_amount` decimal(12,0) NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('NEW','RENTING','WAITING_RETURN','COMPLETED','CANCELLED') COLLATE utf8mb4_unicode_ci DEFAULT 'NEW',
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `station_id`, `user_id`, `vehicle_id`, `start_date`, `end_date`, `actual_return_date`, `total_amount`, `notes`, `status`, `cancel_reason`, `cancelled_at`, `completed_at`, `created_at`) VALUES
(1, 'DH001', 1, 2, 1, '2026-01-07', '2026-01-10', NULL, 3600000, NULL, 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(2, 'DH002', 2, 3, 2, '2026-01-05', '2026-01-12', NULL, 10500000, NULL, 'RENTING', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(3, 'DH003', 3, 4, 3, '2026-01-01', '2026-01-10', NULL, 16200000, NULL, 'COMPLETED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(4, 'DH004', 1, 2, 4, '2026-01-15', '2026-01-16', NULL, 900000, NULL, 'COMPLETED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(5, 'DH005', 4, 3, 5, '2026-01-18', '2026-01-18', NULL, 150000, NULL, 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(6, 'DH006', 2, 2, 6, '2026-01-20', '2026-01-20', NULL, 200000, NULL, 'CANCELLED', NULL, NULL, NULL, '2026-01-18 17:08:05'),
(32, 'DH007', 1, 2, 1, '2026-01-10', '2026-01-12', '2026-01-12 09:00:00', 1200000, 'Khách trả xe sạch sẽ', 'COMPLETED', NULL, NULL, '2026-01-12 09:15:00', '2026-01-08 07:00:00'),
(33, 'DH008', 2, 3, 2, '2026-01-20', '2026-01-25', NULL, 4500000, 'Thuê đi công tác', 'RENTING', NULL, NULL, NULL, '2026-01-19 02:15:00'),
(34, 'DH009', 1, 4, 3, '2026-01-22', '2026-01-23', NULL, 500000, NULL, 'CANCELLED', 'Tài khoản người dùng bị khóa', '2026-01-22 10:00:00', NULL, '2026-01-21 01:00:00'),
(35, 'DH010', 3, 2, 4, '2026-02-01', '2026-02-05', NULL, 3000000, 'Đặt trước cho kỳ nghỉ', 'NEW', NULL, NULL, NULL, '2026-01-24 01:00:00'),
(36, 'DH011', 2, 3, 1, '2026-01-18', '2026-01-22', NULL, 2000000, 'Khách chưa thấy liên hệ', 'WAITING_RETURN', NULL, NULL, NULL, '2026-01-17 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `stations`
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
-- Dumping data for table `stations`
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
(10, 'Trạm Bảo Trì Kỹ Thuật', '15 Nguyễn Thị Minh Khai, Quận 1', NULL, NULL, '2026-01-19 09:33:11', 1, 'INACTIVE', 21.19635500, 106.06776400),
(15, 'Trạm 11', '12 Nguyễn Huệ, Bến Nghé', 'Quận 1', 'TP. Hồ Chí Minh', '2026-01-24 00:56:20', 0, 'ACTIVE', 10.77299520, 106.70516820),
(17, 'Trạm Võ Oanh, Bình Thạnh', '02 Võ Oanh, Phường 25', 'Quận Bình Thạnh', 'TP. Hồ Chí Minh', '2026-01-25 07:55:20', 0, 'ACTIVE', 10.80425702, 106.71657801);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `full_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `role` enum('USER','STATION','ADMIN','DISPATCHER') COLLATE utf8mb4_unicode_ci DEFAULT 'USER',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','BLOCKED') COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `managed_station_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `birthday`, `role`, `avatar`, `status`, `created_at`, `managed_station_id`) VALUES
(1, 'Nguyen Anh Huy', 'soicaca77@gmail.com', '', '$2y$10$vM.cJyEINjknC8EKrYlT6OwRW4HwTHQyspTdzj7pNr7avPajBKcam', NULL, 'ADMIN', NULL, 'BLOCKED', '2025-12-28 14:10:42', NULL),
(2, 'Nguyen Anh Huy', 'kolshoppe100@gmail.com', NULL, '$2y$10$CCXQMhxeKtzMh6UHq.FuBug8jofOXxBPRI064Mib.nYCMCngdfLS6', NULL, 'USER', NULL, 'ACTIVE', '2026-01-11 07:43:45', NULL),
(3, 'Huy Nguyễn Anh', 'soicacwa77@gmail.com', '6019521325', '$2y$10$TbwxcTFjtt9pbyqI562gT.5YiUmbL9KKOUrJmgnuj4qiJ5KQWlDQS', '2026-02-07', 'USER', NULL, 'ACTIVE', '2026-01-15 15:01:07', NULL),
(4, 'Huy Nguyễn Anh', '1111dwdwdw@gmail.com', '03741888267', '$2y$10$jy/dRh2M8fNduxfjuJbRD.6JUoZcoTPT0qKiNWVPLaZi/qLbWNM4K', '2026-01-21', 'USER', '1.png', 'BLOCKED', '2026-01-15 15:02:48', NULL),
(5, 'Huy Nguyễn Anh', 'ng.anhhuy2005@gmail.com', '0374188826', '$2y$10$ACH/fATQkgi0cmgICbMJY.ys5yH0lKVsAkLDv3aB2dQFkU1C2opiK', '2026-01-20', 'STATION', NULL, 'ACTIVE', '2026-01-25 13:42:46', 2);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
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
  `status` enum('AVAILABLE','RENTED','MAINTENANCE') COLLATE utf8mb4_unicode_ci DEFAULT 'AVAILABLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_name`, `license_plate`, `station_id`, `vehicle_type`, `brand`, `model`, `year`, `seats`, `price_per_day`, `price_per_hour`, `description`, `image`, `created_at`, `status`) VALUES
(1, 'Toyota Camry', '51G-12345', 1, 'Oto', 'Toyota', 'Camry', 2022, 5, 1200000, 150000, NULL, NULL, '2026-01-19 12:22:13', 'AVAILABLE'),
(2, 'Honda CR-V', '51H-67890', 2, 'Oto', 'Honda', 'CR-V', 2023, 7, 1500000, 180000, NULL, NULL, '2026-01-19 12:22:13', 'RENTED'),
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
(20, 'VinFast Lux A2.0', '51K-123.45', 15, 'Oto', 'VinFast', 'Lux A2.0', 2023, 5, 1200000, 150000, 'Xe sang trọng, mạnh mẽ', 'vinfast-lux-a.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(21, 'Mazda 3 Luxury', '51K-234.56', 15, 'Oto', 'Mazda', 'Mazda 3', 2023, 5, 900000, 100000, 'Thiết kế đẹp, tiết kiệm xăng', 'mazda-3.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(22, 'Honda City RS', '51K-345.67', 15, 'Oto', 'Honda', 'City', 2022, 5, 800000, 90000, 'Nhỏ gọn, linh hoạt phố đông', 'honda-city.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(23, 'Honda SH 150i', '59-S1 123.45', 15, 'Xemay', 'Honda', 'SH', 2023, 2, 250000, 40000, 'Xe tay ga cao cấp', 'honda-sh.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(24, 'Honda Vision', '59-S1 234.56', 15, 'Xemay', 'Honda', 'Vision', 2022, 2, 120000, 20000, 'Xe nhỏ gọn cho nữ', 'honda-vision.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(25, 'Kia Carnival', '51K-888.88', 17, 'Oto', 'Kia', 'Carnival', 2023, 7, 2000000, 250000, 'Xe gia đình 7 chỗ rộng rãi', 'kia-carnival.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(26, 'Mitsubishi Xpander', '51K-777.77', 17, 'Oto', 'Mitsubishi', 'Xpander', 2023, 7, 1000000, 120000, '7 chỗ giá rẻ, tiết kiệm', 'mitsubishi-xpander.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(27, 'Toyota Vios G', '51K-666.66', 17, 'Oto', 'Toyota', 'Vios', 2022, 5, 800000, 90000, 'Vua doanh số, bền bỉ', 'toyota-vios.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(28, 'Yamaha Grande', '59-B1 555.55', 17, 'Xemay', 'Yamaha', 'Grande', 2023, 2, 150000, 25000, 'Xe tay ga thời trang', 'yamaha-grande.jpg', '2026-01-25 11:07:20', 'AVAILABLE'),
(29, 'Honda AirBlade 160', '59-B1 444.44', 17, 'Xemay', 'Honda', 'AirBlade', 2023, 2, 180000, 30000, 'Mạnh mẽ, thể thao', 'honda-airblade.jpg', '2026-01-25 11:07:20', 'AVAILABLE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `fk_orders_station` (`station_id`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_vehicle` (`vehicle_id`);

--
-- Indexes for table `stations`
--
ALTER TABLE `stations`
  ADD PRIMARY KEY (`station_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `fk_users_managed_station` (`managed_station_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `license_plate` (`license_plate`),
  ADD KEY `station_id` (`station_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `station_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_station` FOREIGN KEY (`station_id`) REFERENCES `stations` (`station_id`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_orders_vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_managed_station` FOREIGN KEY (`managed_station_id`) REFERENCES `stations` (`station_id`) ON DELETE SET NULL;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `stations` (`station_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
