-- ============================================
-- SQL Script untuk Import ke phpMyAdmin
-- Database: hcis_app
-- ============================================

-- Buat database jika belum ada (opsional, sesuaikan dengan nama database Anda)
-- CREATE DATABASE IF NOT EXISTS hcis_app CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE hcis_app;

-- ============================================
-- Tabel: users
-- Sesuai dengan: app/Database/Migrations/2025-11-05-080456_CreateUsersTable.php
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Tabel: purchase_requisitions
-- Sesuai dengan: app/Database/Migrations/2025-11-05-084750_CreatePurchaseRequisitionsTable.php
-- ============================================
CREATE TABLE IF NOT EXISTS `purchase_requisitions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pr_number` VARCHAR(100) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `requester` VARCHAR(100) NOT NULL,
  `department` VARCHAR(100) NULL DEFAULT NULL,
  `total_price` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Pending',
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Data Sample (Opsional)
-- ============================================

-- Sample data untuk tabel users (password di-hash dengan password_hash)
-- Password default: 'password123' (silahkan ganti sesuai kebutuhan)
INSERT INTO `users` (`nama`, `email`, `password`, `created_at`, `updated_at`) VALUES
('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Sample data untuk tabel purchase_requisitions
INSERT INTO `purchase_requisitions` (`pr_number`, `description`, `requester`, `department`, `total_price`, `status`, `created_at`, `updated_at`) VALUES
('PR-2025-001', 'Permintaan pembelian peralatan kantor', 'John Doe', 'IT', 1500000.00, 'Pending', NOW(), NOW()),
('PR-2025-002', 'Permintaan pembelian software lisensi', 'Jane Smith', 'IT', 5000000.00, 'Approved', NOW(), NOW());

-- ============================================
-- Tabel: personal_admin
-- Sesuai dengan: app/Database/Migrations/2025-11-05-100000_CreatePersonalAdminTable.php
-- ============================================
CREATE TABLE IF NOT EXISTS `personal_admin` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nik` VARCHAR(50) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `divisi` VARCHAR(100) NULL DEFAULT NULL,
  `jabatan` VARCHAR(100) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `phone` VARCHAR(20) NULL DEFAULT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Active',
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Tabel: training_dev
-- Sesuai dengan: app/Database/Migrations/2025-11-05-100001_CreateTrainingDevTable.php
-- ============================================
CREATE TABLE IF NOT EXISTS `training_dev` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `duration` VARCHAR(50) NULL DEFAULT NULL,
  `instructor` VARCHAR(100) NULL DEFAULT NULL,
  `start_date` DATE NULL DEFAULT NULL,
  `end_date` DATE NULL DEFAULT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Scheduled',
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Tabel: performance
-- Sesuai dengan: app/Database/Migrations/2025-11-05-100002_CreatePerformanceTable.php
-- ============================================
CREATE TABLE IF NOT EXISTS `performance` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id` INT UNSIGNED NULL DEFAULT NULL,
  `employee_name` VARCHAR(100) NOT NULL,
  `period` VARCHAR(50) NULL DEFAULT NULL,
  `score` DECIMAL(5,2) NOT NULL DEFAULT 0.00,
  `rating` VARCHAR(50) NULL DEFAULT NULL,
  `notes` TEXT NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Tabel: data_validation
-- Sesuai dengan: app/Database/Migrations/2025-11-05-100003_CreateDataValidationTable.php
-- ============================================
CREATE TABLE IF NOT EXISTS `data_validation` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `check_item` VARCHAR(200) NOT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `total` INT NOT NULL DEFAULT 0,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Pending',
  `last_check` DATETIME NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- Tabel: system_settings
-- Sesuai dengan: app/Database/Migrations/2025-11-05-100004_CreateSystemSettingsTable.php
-- ============================================
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL,
  `setting_value` TEXT NULL DEFAULT NULL,
  `description` TEXT NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

