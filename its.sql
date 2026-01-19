-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2026 at 12:36 PM
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
  `order_code` varchar(10) NOT NULL,
  `station_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vehicle_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_amount` decimal(12,0) NOT NULL,
  `status` enum('NEW','RENTING','WAITING_RETURN','COMPLETED','CANCELLED') DEFAULT 'NEW',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_code`, `station_id`, `user_id`, `vehicle_id`, `start_date`, `end_date`, `total_amount`, `status`, `created_at`) VALUES
(1, 'DH001', 1, 2, 1, '2026-01-07', '2026-01-10', 3600000, 'CANCELLED', '2026-01-18 17:08:05'),
(2, 'DH002', 2, 3, 2, '2026-01-05', '2026-01-12', 10500000, 'RENTING', '2026-01-18 17:08:05'),
(3, 'DH003', 3, 4, 3, '2026-01-01', '2026-01-10', 16200000, 'COMPLETED', '2026-01-18 17:08:05'),
(4, 'DH004', 1, 2, 4, '2026-01-15', '2026-01-16', 900000, 'COMPLETED', '2026-01-18 17:08:05'),
(5, 'DH005', 4, 3, 5, '2026-01-18', '2026-01-18', 150000, 'CANCELLED', '2026-01-18 17:08:05'),
(6, 'DH006', 2, 2, 6, '2026-01-20', '2026-01-20', 200000, 'CANCELLED', '2026-01-18 17:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE `stations` (
  `station_id` int NOT NULL,
  `station_name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_maintenance` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`station_id`, `station_name`, `address`, `created_at`, `is_maintenance`) VALUES
(1, 'Nguyễn Huệ - Q1', '123 Nguyễn Huệ, Quận 1', '2026-01-18 17:07:48', 0),
(2, 'Lê Lợi - Q1', '45 Lê Lợi, Quận 1', '2026-01-18 17:07:48', 0),
(3, 'Võ Văn Tần - Q3', '78 Võ Văn Tần, Quận 3', '2026-01-18 17:07:48', 0),
(4, 'Hoàng Văn Thụ - Tân Bình', '12 Hoàng Văn Thụ, Tân Bình', '2026-01-18 17:07:48', 0),
(6, 'Trạm Lê Lợi - Q1', '45 Lê Lợi, Quận 1, TP.HCM', '2026-01-19 09:33:11', 0),
(7, 'Trạm Võ Văn Tần - Q3', '88 Võ Văn Tần, Quận 3, TP.HCM', '2026-01-19 09:33:11', 0),
(8, 'Trạm Cách Mạng Tháng 8 - Q10', '120 CMT8, Quận 10, TP.HCM', '2026-01-19 09:33:11', 0),
(9, 'Trạm Bảo Trì Trung Tâm', '200 Điện Biên Phủ, Quận Bình Thạnh', '2026-01-19 09:33:11', 1),
(10, 'Trạm Bảo Trì Kỹ Thuật', '15 Nguyễn Thị Minh Khai, Quận 1', '2026-01-19 09:33:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `role` enum('USER','STATION','ADMIN') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USER',
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','BLOCKED') DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password`, `birthday`, `role`, `avatar`, `status`, `created_at`) VALUES
(1, 'Nguyen Anh Huy', 'soicaca77@gmail.com', '', '$2y$10$vM.cJyEINjknC8EKrYlT6OwRW4HwTHQyspTdzj7pNr7avPajBKcam', NULL, 'ADMIN', NULL, 'BLOCKED', '2025-12-28 14:10:42'),
(2, 'Nguyen Anh Huy', 'kolshoppe100@gmail.com', NULL, '$2y$10$CCXQMhxeKtzMh6UHq.FuBug8jofOXxBPRI064Mib.nYCMCngdfLS6', NULL, 'USER', NULL, 'ACTIVE', '2026-01-11 07:43:45'),
(3, 'Huy Nguyễn Anh', 'soicacwa77@gmail.com', '6019521325', '$2y$10$TbwxcTFjtt9pbyqI562gT.5YiUmbL9KKOUrJmgnuj4qiJ5KQWlDQS', '2026-02-07', 'USER', NULL, 'ACTIVE', '2026-01-15 15:01:07'),
(4, 'Huy Nguyễn Anh', '1111dwdwdw@gmail.com', '0374188826', '$2y$10$jy/dRh2M8fNduxfjuJbRD.6JUoZcoTPT0qKiNWVPLaZi/qLbWNM4K', '2026-01-21', 'USER', '1.png', 'BLOCKED', '2026-01-15 15:02:48');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int NOT NULL,
  `vehicle_name` varchar(100) NOT NULL,
  `license_plate` varchar(20) NOT NULL,
  `station_id` int DEFAULT NULL,
  `vehicle_type` enum('Oto','Xemay') DEFAULT NULL,
  `price_per_day` decimal(12,0) NOT NULL,
  `price_per_hour` decimal(12,0) NOT NULL,
  `status` enum('AVAILABLE','RENTED','MAINTENANCE') DEFAULT 'AVAILABLE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `vehicle_name`, `license_plate`, `station_id`, `vehicle_type`, `price_per_day`, `price_per_hour`, `status`) VALUES
(1, 'Toyota Camry', '51G-12345', 1, 'Oto', 1200000, 150000, 'AVAILABLE'),
(2, 'Honda CR-V', '51H-67890', 2, 'Oto', 1500000, 180000, 'RENTED'),
(3, 'Ford Tourneo', '51F-24680', 3, 'Oto', 1800000, 200000, 'AVAILABLE'),
(4, 'Toyota Vios', '51A-99999', 1, 'Oto', 900000, 120000, 'AVAILABLE'),
(5, 'Honda Wave', '59X1-88888', 4, 'Xemay', 150000, 30000, 'AVAILABLE'),
(6, 'Yamaha Exciter', '59X1-77777', 2, 'Xemay', 200000, 40000, 'MAINTENANCE'),
(13, 'Toyota Camry', '51G-99901', 1, 'Oto', 1200000, 150000, 'AVAILABLE'),
(14, 'Honda Civic', '51G-99902', 1, 'Oto', 1000000, 130000, 'RENTED'),
(15, 'Mazda CX-5', '51H-99903', 2, 'Oto', 1100000, 140000, 'AVAILABLE'),
(16, 'Yamaha Exciter', '59X1-99904', 2, 'Xemay', 150000, 30000, 'AVAILABLE'),
(17, 'Ford Ranger', '51C-99905', 6, 'Oto', 1300000, 160000, 'AVAILABLE'),
(18, 'Honda SH', '59X2-99906', 6, 'Xemay', 200000, 40000, 'AVAILABLE');

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
  ADD UNIQUE KEY `phone` (`phone`);

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
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stations`
--
ALTER TABLE `stations`
  MODIFY `station_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `stations` (`station_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
