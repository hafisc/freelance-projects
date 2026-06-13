-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2026 at 01:13 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_231006`
--

-- --------------------------------------------------------

--
-- Table structure for table `otp_requests`
--

CREATE TABLE `otp_requests` (
  `id` int NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `otp_code` varchar(6) NOT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `otp_requests`
--

INSERT INTO `otp_requests` (`id`, `phone_number`, `otp_code`, `expired_at`, `created_at`) VALUES
(1, '6282292844281', '391026', '2026-06-03 02:58:42', '2026-06-03 02:53:42'),
(15, '+6282346432467', '631263', '2026-06-11 13:48:32', '2026-06-11 13:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `status_231006`
--

CREATE TABLE `status_231006` (
  `id_status` int NOT NULL,
  `id_user` int NOT NULL,
  `media` varchar(255) NOT NULL,
  `caption` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expired_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `status_231006`
--

INSERT INTO `status_231006` (`id_status`, `id_user`, `media`, `caption`, `created_at`, `expired_at`) VALUES
(20, 9, 'assets/image_status/status2.jpeg', NULL, '2026-06-12 19:12:24', NULL),
(21, 9, 'assets/image_status/status9.jpeg', NULL, '2026-06-12 19:12:48', NULL),
(22, 38, 'desktop_image.jpg', '', '2026-06-13 17:28:52', NULL),
(23, 38, 'desktop_image.jpg', '', '2026-06-13 17:56:32', NULL),
(24, 38, 'desktop_image.jpg', '', '2026-06-13 18:08:03', NULL),
(25, 38, 'desktop_image.jpg', '', '2026-06-13 19:08:24', NULL),
(26, 38, 'Ujung Pandang.jpg', '', '2026-06-13 19:42:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_231006`
--

CREATE TABLE `user_231006` (
  `id_user` int NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `otp_code` varchar(20) DEFAULT NULL,
  `otp_expired_at` datetime DEFAULT NULL,
  `login_code` varchar(8) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `business_hours` varchar(100) DEFAULT NULL,
  `schedule` text,
  `profile_photo` varchar(255) DEFAULT NULL,
  `address` text,
  `website` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verified` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_231006`
--

INSERT INTO `user_231006` (`id_user`, `phone_number`, `otp_code`, `otp_expired_at`, `login_code`, `business_name`, `category`, `business_hours`, `schedule`, `profile_photo`, `address`, `website`, `description`, `created_at`, `is_verified`) VALUES
(6, '+62859106724023', '405152', NULL, 'SLMQK59E', 'Toko Kelontong', 'Toko Kelontong', 'Hanya buka pada jam-jam tertentu', 'Rabu, Kamis, Jumat', '', 'Jl. Melati', '', 'Semua ada', '2026-06-04 09:17:23', 0),
(7, '+6285231446461', '868530', NULL, '4DNVESZ6', 'studio coding', 'Bisnis lain', 'Selalu buka', 'Senin, Selasa, Rabu, Kamis, Jumat', '', 'jl. melati', '', '', '2026-06-05 03:06:43', 0),
(8, '+6285756065540', '729726', NULL, 'YXXTHMQ8', 'Toko kosmetik', 'Kecantikan, Kosmetik & Perawatan Diri', 'Selalu buka', 'Senin, Selasa, Rabu, Kamis, Jumat', '', 'Jl. melati', '', '', '2026-06-11 12:13:15', 0),
(9, '+6282346832467', '474516', NULL, 'MK1DNAK9', 'user', 'Bisnis lain', 'Selalu buka', 'Senin, Selasa, Rabu, Kamis, Jumat', '', '', '', '', '2026-06-11 13:46:19', 0),
(35, '+629868768698709', '997108', NULL, 'NT1WQIYW', 'dff', 'Layanan Otomotif', 'Hanya janji temu', 'Senin, Selasa, Rabu, Kamis, Jumat', '', '', '', '', '2026-06-11 18:12:36', 0),
(36, '+6287687568374655', '632550', NULL, 'QECVGDW1', 'xc', 'Medis & Kesehatan', 'Hanya buka pada jam-jam tertentu', 'Senin, Selasa, Rabu, Kamis, Jumat', '', '', '', '', '2026-06-11 18:20:15', 0),
(37, '+62765434567876543', '419950', NULL, 'RD7ACJ31', 'cx', 'Medis & Kesehatan', 'Hanya buka pada jam-jam tertentu', 'Senin, Selasa, Rabu, Kamis, Jumat', '', '', '', '', '2026-06-11 18:22:03', 0),
(38, '+6282189915833', '815719', NULL, 'JHQTEPL0', 'Toko kue', 'Bisnis lain', 'Selalu buka', 'Senin, Selasa, Rabu, Kamis, Jumat', '', '', '', '', '2026-06-12 11:11:58', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `otp_requests`
--
ALTER TABLE `otp_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_231006`
--
ALTER TABLE `status_231006`
  ADD PRIMARY KEY (`id_status`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user_231006`
--
ALTER TABLE `user_231006`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `phone_number` (`phone_number`),
  ADD UNIQUE KEY `login_code` (`login_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `otp_requests`
--
ALTER TABLE `otp_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `status_231006`
--
ALTER TABLE `status_231006`
  MODIFY `id_status` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_231006`
--
ALTER TABLE `user_231006`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `status_231006`
--
ALTER TABLE `status_231006`
  ADD CONSTRAINT `status_231006_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user_231006` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
