-- Cập nhật bảng users để thêm các trường xác minh tài khoản (KYC)
-- Chạy script này để thêm các trường mới vào database

ALTER TABLE `users` 
ADD COLUMN `id_card_number` VARCHAR(20) NULL COMMENT 'Số CCCD/CMND' AFTER `birthday`,
ADD COLUMN `id_card_name` VARCHAR(100) NULL COMMENT 'Họ tên trên CCCD' AFTER `id_card_number`,
ADD COLUMN `id_card_date` DATE NULL COMMENT 'Ngày cấp CCCD' AFTER `id_card_name`,
ADD COLUMN `id_card_place` VARCHAR(100) NULL COMMENT 'Nơi cấp CCCD' AFTER `id_card_date`,
ADD COLUMN `id_card_front` VARCHAR(255) NULL COMMENT 'Ảnh CCCD mặt trước' AFTER `id_card_place`,
ADD COLUMN `id_card_back` VARCHAR(255) NULL COMMENT 'Ảnh CCCD mặt sau' AFTER `id_card_front`,
ADD COLUMN `face_image` VARCHAR(255) NULL COMMENT 'Ảnh khuôn mặt xác thực' AFTER `id_card_back`,
ADD COLUMN `driver_license_number` VARCHAR(20) NULL COMMENT 'Số bằng lái xe' AFTER `face_image`,
ADD COLUMN `driver_license_front` VARCHAR(255) NULL COMMENT 'Ảnh bằng lái mặt trước' AFTER `driver_license_number`,
ADD COLUMN `driver_license_back` VARCHAR(255) NULL COMMENT 'Ảnh bằng lái mặt sau' AFTER `driver_license_front`,
ADD COLUMN `bank_account_number` VARCHAR(50) NULL COMMENT 'Số tài khoản ngân hàng' AFTER `driver_license_back`,
ADD COLUMN `bank_account_name` VARCHAR(100) NULL COMMENT 'Tên chủ tài khoản' AFTER `bank_account_number`,
ADD COLUMN `bank_name` VARCHAR(100) NULL COMMENT 'Tên ngân hàng' AFTER `bank_account_name`,
ADD COLUMN `address` VARCHAR(255) NULL COMMENT 'Địa chỉ thường trú' AFTER `bank_name`,
ADD COLUMN `emergency_contact` VARCHAR(20) NULL COMMENT 'SĐT người thân khẩn cấp' AFTER `address`,
ADD COLUMN `emergency_name` VARCHAR(100) NULL COMMENT 'Tên người thân khẩn cấp' AFTER `emergency_contact`,
ADD COLUMN `is_verified` ENUM('PENDING', 'VERIFIED', 'REJECTED') DEFAULT 'PENDING' COMMENT 'Trạng thái xác minh' AFTER `emergency_name`,
ADD COLUMN `verified_at` DATETIME NULL COMMENT 'Thời gian xác minh' AFTER `is_verified`,
ADD COLUMN `verification_note` TEXT NULL COMMENT 'Ghi chú xác minh (lý do từ chối)' AFTER `verified_at`;

-- Tạo index cho các trường quan trọng
ALTER TABLE `users` ADD INDEX `idx_id_card_number` (`id_card_number`);
ALTER TABLE `users` ADD INDEX `idx_is_verified` (`is_verified`);
ALTER TABLE `users` ADD INDEX `idx_driver_license` (`driver_license_number`);

-- Cập nhật comment cho bảng
ALTER TABLE `users` COMMENT = 'Bảng người dùng với thông tin xác minh KYC';
