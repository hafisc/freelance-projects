-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 09:43 AM
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
-- Database: `tps3r`
--

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`id`, `title`, `slug`, `thumbnail`, `content`, `author_id`, `status`, `created_at`, `updated_at`) VALUES
(12, 'Apa Itu Sampah?', 'apa-itu-sampah', 'educations/1780924407_6a26bff7661e1.jpg', 'Hallo', 8, 'draft', '2026-06-08 06:13:27', '2026-06-08 06:13:27'),
(13, 'Apa Itu Sampah?', 'apa-itu-sampah-1', 'educations/1780924460_6a26c02cac501.jpg', 'Hallo', 8, 'published', '2026-06-08 06:14:20', '2026-06-08 06:14:20'),
(16, 'Cara Mengolah Sampah', 'cara-mengolah-sampah', 'educations/1780986032_6a27b0b073faa.jpg', 'Pengelolaan sampah berbasis TPS 3R membutuhkan dukungan pencatatan,\r\nedukasi, dan pemantauan partisipasi warga agar proses reduce, reuse, dan recycle\r\ndapat berjalan lebih transparan. Permasalahan yang sering muncul pada\r\npengelolaan konvensional adalah pencatatan laporan yang belum terintegrasi,\r\nketerbatasan akses informasi edukasi, serta lambatnya proses verifikasi laporan\r\nwarga. Penelitian ini bertujuan merancang dan mendokumentasikan aplikasi sistem\r\ninformasi TPS 3R Brama Muda yang menggabungkan aplikasi mobile, backend\r\nAPI, dan website admin.\r\n\r\n Metode pengembangan yang digunakan adalah model waterfall yang\r\nmeliputi analisis kebutuhan, perancangan sistem, implementasi, dan pengujian\r\nfungsional. Aplikasi mobile dikembangkan menggunakan Flutter dengan integrasi\r\nHTTP API, penyimpanan token menggunakan SharedPreferences, serta unggah\r\nfoto menggunakan image_picker. Backend dikembangkan menggunakan Laravel\r\n10, Laravel Sanctum, REST API, dan database MySQL. Website admin berbasis\r\nPHP native digunakan untuk dashboard, manajemen edukasi, dan validasi laporan\r\nsampah. Hasil pengembangan menunjukkan bahwa sistem dapat menyediakan\r\nautentikasi pengguna, pengelolaan artikel edukasi, pengiriman laporan sampah\r\ndengan foto, serta verifikasi laporan oleh admin.', 8, 'published', '2026-06-08 23:20:32', '2026-06-08 23:20:32');

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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(22, 'App\\Models\\User', 8, 'auth_token', 'b6ab5cdb6f3f328aee9db1f9b0f2415ac3fbc730209e6315ff39286f6ea9d3b7', '[\"*\"]', NULL, NULL, '2026-06-08 03:23:05', '2026-06-08 03:23:05'),
(23, 'App\\Models\\User', 8, 'auth_token', '584476ca72c15cd9f7ebc77162406d1751a1e464f42ef768d7e15eeaa230dbe6', '[\"*\"]', '2026-06-08 05:09:39', NULL, '2026-06-08 03:24:07', '2026-06-08 05:09:39'),
(24, 'App\\Models\\User', 9, 'auth_token', '21b68b9a401fced5a7c6bd390498fe4ce2a2e52e811af2a84d1927ef0748430f', '[\"*\"]', NULL, NULL, '2026-06-08 03:24:55', '2026-06-08 03:24:55'),
(25, 'App\\Models\\User', 9, 'auth_token', '31e0b1e58807d50ae4f4ee1c46ab973a6284aff84900dc9a0b8592a3973e5d38', '[\"*\"]', '2026-06-08 04:16:40', NULL, '2026-06-08 03:25:23', '2026-06-08 04:16:40'),
(26, 'App\\Models\\User', 9, 'auth_token', 'cc236656bb21fd69a9b7ef32ef048aabde1bd594d9d1cc45731c0e05ded461fb', '[\"*\"]', '2026-06-08 05:45:47', NULL, '2026-06-08 04:40:43', '2026-06-08 05:45:47'),
(27, 'App\\Models\\User', 8, 'auth_token', '5998054ea82abf6624b99e3c76f9004f880f10db0443b1e01b2215fc3e93b7fe', '[\"*\"]', '2026-06-08 09:44:04', NULL, '2026-06-08 06:12:32', '2026-06-08 09:44:04'),
(28, 'App\\Models\\User', 10, 'auth_token', 'd379f5076de74bd6f4948fec7b54d8955f66c620d1be736ce7a57e89b2ca8810', '[\"*\"]', NULL, NULL, '2026-06-08 06:15:33', '2026-06-08 06:15:33'),
(29, 'App\\Models\\User', 10, 'auth_token', '8aa961a9a28e4c6e0e61b41f215124caa6f4b1799128ceda8c49d9378260e384', '[\"*\"]', '2026-06-08 06:17:51', NULL, '2026-06-08 06:15:47', '2026-06-08 06:17:51'),
(30, 'App\\Models\\User', 10, 'auth_token', 'e59356300614b4062daff0008ff056221622d467c53b4479da6a64eee31471f1', '[\"*\"]', '2026-06-08 06:20:17', NULL, '2026-06-08 06:18:13', '2026-06-08 06:20:17'),
(31, 'App\\Models\\User', 10, 'auth_token', '20bf6ba88630e401e40d854c8e2ff9c70c27b345cbf4128b2c580755f5ab3950', '[\"*\"]', '2026-06-08 08:18:21', NULL, '2026-06-08 07:07:53', '2026-06-08 08:18:21'),
(33, 'App\\Models\\User', 11, 'auth_token', '7ff98b00e3590c82fc982f7d0fc1b769932b9426103a3bbac0ff217838816e6a', '[\"*\"]', NULL, NULL, '2026-06-08 09:42:59', '2026-06-08 09:42:59'),
(35, 'App\\Models\\User', 9, 'auth_token', '66e217e2fef222119981f6c2a66a4e52a89ff391a8ba889ca55c60fdbbe08799', '[\"*\"]', '2026-06-08 10:25:37', NULL, '2026-06-08 10:25:27', '2026-06-08 10:25:37'),
(36, 'App\\Models\\User', 8, 'auth_token', 'fb14227069a54e8d3a2c9340bd86ea78a905a0677a6d2201c43d29fe95ab2ba2', '[\"*\"]', '2026-06-08 19:22:00', NULL, '2026-06-08 18:39:01', '2026-06-08 19:22:00'),
(37, 'App\\Models\\User', 8, 'auth_token', 'a9b7e8341af16790c7c47f8480f207901daca799492036793cd6e4b73d724e7b', '[\"*\"]', '2026-06-08 23:35:29', NULL, '2026-06-08 23:14:06', '2026-06-08 23:35:29'),
(38, 'App\\Models\\User', 10, 'auth_token', 'fe81bcd8b556578c0df4ea30ae0ffd7fc1a10f6b61dde4f8f2896fa7947ae9dc', '[\"*\"]', '2026-06-08 23:22:54', NULL, '2026-06-08 23:18:29', '2026-06-08 23:22:54'),
(39, 'App\\Models\\User', 10, 'auth_token', '9e07acfecaa7cb69626f446a105e860255cf8b3e26c262870acf809095aef99a', '[\"*\"]', '2026-06-08 23:36:01', NULL, '2026-06-08 23:23:14', '2026-06-08 23:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','member','petugas') NOT NULL DEFAULT 'member',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `avatar`, `phone`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, 'admin', 'admin@gmail.com', NULL, '$2y$12$uCkaJPX53zxo8qOeR3jYSO3jHMjqFtKiPRGAFq/xkMGK5KiV.X5z6', NULL, NULL, 'admin', 'active', NULL, '2026-06-08 03:23:05', '2026-06-08 03:23:05'),
(9, 'member', 'member@gmail.com', NULL, '$2y$12$bz9QBINQj9yulZhLg6qISeqPY5phKLUGGHkEpVJnukgcqeEILlocG', NULL, NULL, 'member', 'active', NULL, '2026-06-08 03:24:55', '2026-06-08 03:24:55'),
(10, 'Zahraa', 'saia@gmail.com', NULL, '$2y$12$5jkmiYxDmWEIqHHUqioyVOB93NfMW3cRZFA.upWt6gX2vHvCG61Zy', NULL, '08123456789', 'member', 'active', NULL, '2026-06-08 06:15:33', '2026-06-08 23:25:00'),
(11, 'ara', 'Ara123@gmail.com', NULL, '$2y$12$bf7/cQrEzbdcHU7MpL0/eeSE4rWAftr9t7DZk50V.phgajyFZ3LoS', NULL, NULL, 'member', 'active', NULL, '2026-06-08 09:42:59', '2026-06-08 09:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `waste_reports`
--

CREATE TABLE `waste_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','verified','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `waste_reports`
--

INSERT INTO `waste_reports` (`id`, `user_id`, `photo_path`, `location`, `category`, `description`, `status`, `created_at`, `updated_at`) VALUES
(7, 9, 'reports/j74yA8GYDtFGxdwWlPpCJpZV3iSJlblhtFi5jXRR.jpg', 'JAKARTA', 'B3', 'test uji coba V1', 'rejected', '2026-06-08 03:26:27', '2026-06-08 06:20:12'),
(8, 10, 'reports/Uk4XiEZftrDF79jm7ovaScC5kZUVAIU1Ngmxwmv3.jpg', 'jl.124', 'Anorganik', 'Hallo', 'verified', '2026-06-08 06:17:51', '2026-06-08 06:19:05'),
(9, 10, 'reports/oi5BbjZ21lYcNBzPRmV5iANU8sXd1Bbxew1JdzvG.jpg', 'jl.o', 'Daur Ulang', 'Yeayyy', 'pending', '2026-06-08 07:09:35', '2026-06-08 07:09:35'),
(10, 10, 'reports/RrNo1iP5LxscbF5hi97fpXBRIfuHL4NLl0X8HSH1.png', 'jl.i', 'B3', 'Okk', 'verified', '2026-06-08 08:17:36', '2026-06-08 18:49:16'),
(11, 10, 'reports/ciY6BoNpGrBqT9UoPnWlhu57RBWC1GprrUtjJ92p.jpg', 'jl.p', 'Daur Ulang', 'yyyyyy', 'rejected', '2026-06-08 08:26:37', '2026-06-08 18:47:09'),
(12, 10, 'reports/8wL4IiMejWOeSEoMzjZBOg7EYHSRN41AvUNvZm0z.jpg', 'Perumahan 1', 'Daur Ulang', 'Di cantol di pager', 'verified', '2026-06-08 23:22:54', '2026-06-08 23:24:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `educations_slug_unique` (`slug`),
  ADD KEY `educations_status_index` (`status`),
  ADD KEY `educations_author_id_index` (`author_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `waste_reports_status_index` (`status`),
  ADD KEY `waste_reports_user_id_index` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `waste_reports`
--
ALTER TABLE `waste_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `educations`
--
ALTER TABLE `educations`
  ADD CONSTRAINT `educations_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `waste_reports`
--
ALTER TABLE `waste_reports`
  ADD CONSTRAINT `waste_reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
