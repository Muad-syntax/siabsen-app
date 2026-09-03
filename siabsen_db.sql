-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 03, 2026 at 11:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siabsen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `target_type` varchar(50) DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `detail` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`detail`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','izin','sakit','alpha','belum_hadir') NOT NULL DEFAULT 'belum_hadir',
  `scan_at` datetime DEFAULT NULL,
  `scan_ip` varchar(45) DEFAULT NULL,
  `override_by` bigint(20) UNSIGNED DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `session_id`, `siswa_id`, `kelas_id`, `tanggal`, `status`, `scan_at`, `scan_ip`, `override_by`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 4, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:41:39', '2026-09-03 13:42:31'),
(2, 1, 12, 4, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:41:39', '2026-09-03 13:42:31'),
(3, 1, 13, 4, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:41:39', '2026-09-03 13:42:31'),
(4, 1, 14, 4, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:41:39', '2026-09-03 13:42:31'),
(5, 1, 15, 4, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:41:39', '2026-09-03 13:42:31'),
(6, 1, 16, 4, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:41:39', '2026-09-03 13:42:31'),
(7, 1, 17, 4, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:41:39', '2026-09-03 13:42:31'),
(8, 2, 18, 3, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:48:31', '2026-09-03 13:48:35'),
(9, 2, 19, 3, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:48:31', '2026-09-03 13:48:35'),
(10, 2, 20, 3, '2026-09-03', 'alpha', NULL, NULL, NULL, NULL, '2026-09-03 13:48:31', '2026-09-03 13:48:35'),
(11, 3, 18, 3, '2026-09-03', 'hadir', NULL, NULL, 8, NULL, '2026-09-03 13:48:54', '2026-09-03 14:01:43'),
(12, 3, 19, 3, '2026-09-03', 'sakit', NULL, NULL, 8, NULL, '2026-09-03 13:48:54', '2026-09-03 14:02:11'),
(13, 3, 20, 3, '2026-09-03', 'izin', NULL, NULL, 8, NULL, '2026-09-03 13:48:54', '2026-09-03 14:02:08');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_sessions`
--

CREATE TABLE `attendance_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token` char(36) NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `starts_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_closed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance_sessions`
--

INSERT INTO `attendance_sessions` (`id`, `token`, `kelas_id`, `guru_id`, `tanggal`, `starts_at`, `expires_at`, `is_closed`, `created_at`) VALUES
(1, 'c2364a16-ec72-45de-9d3f-ad18f2d161c5', 4, 9, '2026-09-03', '2026-09-03 20:41:39', '2026-09-03 20:56:39', 1, '2026-09-03 20:41:39'),
(2, 'd248ef37-d850-4565-a89f-e73d689e8029', 3, 8, '2026-09-03', '2026-09-03 20:48:31', '2026-09-03 21:03:31', 1, '2026-09-03 20:48:31'),
(3, '862f91a0-7c38-4d55-9a09-b6bf7c84947f', 3, 8, '2026-09-03', '2026-09-03 20:48:54', '2026-09-03 21:03:54', 1, '2026-09-03 20:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru_kelas`
--

CREATE TABLE `guru_kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `guru_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru_kelas`
--

INSERT INTO `guru_kelas` (`id`, `guru_id`, `kelas_id`) VALUES
(4, 8, 3),
(6, 9, 4),
(5, 10, 3),
(7, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `tingkat` varchar(5) NOT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `tahun_ajaran` varchar(10) NOT NULL,
  `wali_kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama_kelas`, `tingkat`, `jurusan`, `tahun_ajaran`, `wali_kelas_id`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 'RPL 1', 'XII', 'RPL', '2026/2027', 10, 1, '2026-09-03 13:33:05', '2026-09-03 13:33:05'),
(4, 'RPL 2', 'XII', 'RPL', '2026/2027', 10, 1, '2026-09-03 13:33:20', '2026-09-03 13:33:20');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_09_04_000001_create_siabsen_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `siswa_kelas`
--

CREATE TABLE `siswa_kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` bigint(20) UNSIGNED NOT NULL,
  `kelas_id` bigint(20) UNSIGNED NOT NULL,
  `joined_at` date NOT NULL,
  `left_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa_kelas`
--

INSERT INTO `siswa_kelas` (`id`, `siswa_id`, `kelas_id`, `joined_at`, `left_at`) VALUES
(5, 11, 4, '2026-09-03', NULL),
(6, 12, 4, '2026-09-03', NULL),
(7, 13, 4, '2026-09-03', NULL),
(8, 14, 4, '2026-09-03', NULL),
(9, 15, 4, '2026-09-03', NULL),
(10, 16, 4, '2026-09-03', NULL),
(11, 17, 4, '2026-09-03', NULL),
(12, 18, 3, '2026-09-03', NULL),
(13, 19, 3, '2026-09-03', NULL),
(14, 20, 3, '2026-09-03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL DEFAULT 'siswa',
  `nis` varchar(20) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `nis`, `nip`, `photo`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Kepala Sekolah (Admin)', 'admin@absensiku.com', NULL, '$2y$12$Sq0Lor2jsEa5ObY43sha.eIjsuECszXR6TOqMXYVPmfZOR7o7BzqO', 'admin', NULL, NULL, NULL, 1, NULL, '2026-09-03 13:23:46', '2026-09-03 13:23:46'),
(4, 'Ahmad Rizky', 'siswa1@absensiku.com', NULL, '$2y$12$x5JfW/1TrD7tRrqabr.4N.BWSOt6afFSQz60e5qPXMxATA65rXWha', 'siswa', '20261001', NULL, NULL, 1, NULL, '2026-09-03 13:23:47', '2026-09-03 13:23:47'),
(5, 'Ani Rahayu', 'siswa2@absensiku.com', NULL, '$2y$12$EWK/SfTDJqej3g6JvG2FX.xziCLSyaBkqIjeOL7W30ayscUST5Y8O', 'siswa', '20261002', NULL, NULL, 1, NULL, '2026-09-03 13:23:47', '2026-09-03 13:23:47'),
(6, 'Citra Dewi', 'siswa3@absensiku.com', NULL, '$2y$12$WWb6TAkArb0hagHBZVOuKuFHCyGSWlO9Q4CA8kAZW3pJGMldwTSay', 'siswa', '20261003', NULL, NULL, 1, NULL, '2026-09-03 13:23:47', '2026-09-03 13:23:47'),
(7, 'Doni Pratama', 'siswa4@absensiku.com', NULL, '$2y$12$dn6u8a0PK2A0tfLu5wKPPuJOQ8jqB.QrW9gWHrVTaTsFqFGalWIz.', 'siswa', '20261004', NULL, NULL, 1, NULL, '2026-09-03 13:23:47', '2026-09-03 13:23:47'),
(8, 'Aulia Rachman S. Kom', 'guru1@absensiku.com', NULL, '$2y$12$pXxfAkMc1wAus9QIHtZKgOU93QmpFqi/cXR8j3A1aA5zTt11HWwTu', 'guru', NULL, '1111111', NULL, 1, NULL, '2026-09-03 13:30:20', '2026-09-03 13:30:20'),
(9, 'Haris Maulana Ikhsan', 'guru2@absensiku.com', NULL, '$2y$12$Ka5Q7LM.2EcOzl8fOxmLjuIelsq/wHeLF22wyHVv.UOW/tuc/hGKy', 'guru', NULL, '2222222', NULL, 1, NULL, '2026-09-03 13:31:10', '2026-09-03 13:31:10'),
(10, 'Maulana Ahmad', 'malik@gmail.com', NULL, '$2y$12$xv1BVOmXbLHGAyC97i8/yOU9I7WdnyC72eMY1XBWmZ.dCsxwZ0DwW', 'guru', NULL, '3333333', NULL, 1, NULL, '2026-09-03 13:32:34', '2026-09-03 13:32:34'),
(11, 'Muhammad Zein Akbar Susanto', 'zein@gmail.com', NULL, '$2y$12$/iC705391.42b5Mzyllmd.bXbxyf976AQE8mH2G1M.jNzciKMw8ci', 'siswa', '001', NULL, NULL, 1, NULL, '2026-09-03 13:36:33', '2026-09-03 13:36:33'),
(12, 'Muhammad Arfan Al Adaby', 'arfan@gmail.com', NULL, '$2y$12$nX06msfmbXCuH4iseguaMOIxLRDqAQJZpa1lvyfuVn.VyDIfDp3FG', 'siswa', '002', NULL, NULL, 1, NULL, '2026-09-03 13:37:07', '2026-09-03 13:37:07'),
(13, 'Muhammad Suaebummuad', 'muad@gmail.com', NULL, '$2y$12$pJ8mgwPtmDoJNFCIaCo01O0m./KQex4.HPHbT8VCtdQ00KKNrGXZq', 'siswa', '003', NULL, NULL, 1, NULL, '2026-09-03 13:37:48', '2026-09-03 13:37:48'),
(14, 'Muhammad Azka Syaputra', 'azka@gmail.com', NULL, '$2y$12$lpMfSCoLs4WW8WSQix62TuJvs64UF1t6ILOk2bPe0IfaLSnyCL4rG', 'siswa', '004', NULL, NULL, 1, NULL, '2026-09-03 13:38:37', '2026-09-03 13:38:37'),
(15, 'Muhammad Rasyad Nabil', 'nabil@gmail.com', NULL, '$2y$12$Jwcb7/3.ASbIILXn4b0uOOqfJwRWOcBPTd35KzPx4a7m3AcER6bY.', 'siswa', '005', NULL, NULL, 1, NULL, '2026-09-03 13:39:20', '2026-09-03 13:39:20'),
(16, 'Muhammad Budiansyah', 'budi@gmail.com', NULL, '$2y$12$xRfGlo9Ht4m8QvFzed/YPuNU6.ch2FC/D6VKF/ZZCQzO5mvvOHJjC', 'siswa', '006', NULL, NULL, 1, NULL, '2026-09-03 13:39:55', '2026-09-03 13:39:55'),
(17, 'Afif Gedig', 'apip@gmail.com', NULL, '$2y$12$CyYEMyuAjmHxNsja3GjBJO8Hp6w4LC8tTf7Fe6fJ/VqpwWjVSIdgi', 'siswa', '007', NULL, NULL, 1, NULL, '2026-09-03 13:40:49', '2026-09-03 13:40:49'),
(18, 'Baskoro Rinankit', 'bagas@gmail.com', NULL, '$2y$12$KrqyrZflWUDK0wwMQM7Xi.k45.eK0ecWx49VOlFPiq.IHEpIsaJ3C', 'siswa', '011', NULL, NULL, 1, NULL, '2026-09-03 13:45:06', '2026-09-03 13:45:06'),
(19, 'Muhammad Farel', 'farel@gmail.com', NULL, '$2y$12$1EYBVGC4btqkQhCxpqKHjenQkxKMNCKm23BfXSN3N96EB7yviYEMW', 'siswa', '012', NULL, NULL, 1, NULL, '2026-09-03 13:45:39', '2026-09-03 13:45:39'),
(20, 'Kayla Anisa Cahya', 'kayla@gmail.com', NULL, '$2y$12$EXmpqtFqpCueqJ.HcnGmPemZHi7S0gzbYlePPvHrP2i1Jxu0ALEzK', 'siswa', '013', NULL, NULL, 1, NULL, '2026-09-03 13:46:36', '2026-09-03 13:46:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_records_siswa_id_session_id_unique` (`siswa_id`,`session_id`),
  ADD KEY `attendance_records_session_id_foreign` (`session_id`),
  ADD KEY `attendance_records_kelas_id_foreign` (`kelas_id`),
  ADD KEY `attendance_records_override_by_foreign` (`override_by`);

--
-- Indexes for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendance_sessions_token_unique` (`token`),
  ADD KEY `attendance_sessions_kelas_id_foreign` (`kelas_id`),
  ADD KEY `attendance_sessions_guru_id_foreign` (`guru_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `guru_kelas`
--
ALTER TABLE `guru_kelas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guru_kelas_guru_id_kelas_id_unique` (`guru_id`,`kelas_id`),
  ADD KEY `guru_kelas_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_wali_kelas_id_foreign` (`wali_kelas_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_kelas_siswa_id_foreign` (`siswa_id`),
  ADD KEY `siswa_kelas_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru_kelas`
--
ALTER TABLE `guru_kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_override_by_foreign` FOREIGN KEY (`override_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `attendance_records_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `attendance_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_sessions`
--
ALTER TABLE `attendance_sessions`
  ADD CONSTRAINT `attendance_sessions_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `attendance_sessions_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`);

--
-- Constraints for table `guru_kelas`
--
ALTER TABLE `guru_kelas`
  ADD CONSTRAINT `guru_kelas_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guru_kelas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_wali_kelas_id_foreign` FOREIGN KEY (`wali_kelas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `siswa_kelas`
--
ALTER TABLE `siswa_kelas`
  ADD CONSTRAINT `siswa_kelas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswa_kelas_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
