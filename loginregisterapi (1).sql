-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 07:43 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginregisterapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `professional_id` bigint(20) UNSIGNED NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `user_id`, `professional_id`, `scheduled_at`, `notes`, `created_at`, `updated_at`) VALUES
(9, 3, 4, '2024-08-15 00:40:00', 'ssssssssssssmm', '2024-08-10 11:01:02', '2024-08-10 22:51:23'),
(13, 1, 2, '2024-08-23 09:03:00', 'qqqqqqqqqq', '2024-08-10 22:03:23', '2024-08-10 22:03:23'),
(37, 5, 6, '1970-01-01 00:34:53', 'rr', '2024-08-11 11:27:24', '2024-08-11 11:27:24'),
(38, 5, 6, '1970-01-01 00:35:15', 'gg', '2024-08-11 11:49:17', '2024-08-11 11:49:17');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `attempts` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reserved_at` timestamp NULL DEFAULT NULL,
  `available_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payload` longtext NOT NULL
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

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_08_10_062942_create_consultations_table', 2),
(6, '2024_08_10_160951_create_jobs_table', 3),
(7, '2024_08_11_113154_add_fsm_token_to_users_table', 4),
(8, '2024_08_11_153349_add_phone_number_to_users_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
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
(1, 'App\\Models\\User', 4, 'AuthToken', 'c117b4afcf8fff9d412f0849f5ce72c4acf3b6e497f531060eaa317c109ce5dd', '[\"server:update\"]', NULL, NULL, '2024-04-17 04:29:16', '2024-04-17 04:29:16'),
(2, 'App\\Models\\User', 4, 'AuthToken', '6695625d9305a87eaa679ef9349a751297d54e6935a530d6f62032f97ee4799d', '[\"server:update\"]', NULL, NULL, '2024-04-17 04:32:01', '2024-04-17 04:32:01'),
(3, 'App\\Models\\User', 4, 'AuthToken', '205273ca5caf98c24ed2a6af4a23284b619c65152096bd11b4616f8db2fed751', '[\"*\"]', NULL, NULL, '2024-04-17 04:34:43', '2024-04-17 04:34:43'),
(4, 'App\\Models\\User', 4, 'AuthToken', 'b4baa8658b7a57932170ec2cb2372bcbcdf45a4efe07c30ecc1aeb485e8952dd', '[\"*\"]', NULL, NULL, '2024-04-17 04:36:05', '2024-04-17 04:36:05'),
(5, 'App\\Models\\User', 6, 'AuthToken', '619a521a137fa42eebdf56ecfb37e46b8c109a66ac5099cc665139d47962c6f6', '[\"*\"]', NULL, NULL, '2024-04-17 04:37:49', '2024-04-17 04:37:49'),
(6, 'App\\Models\\User', 6, 'AuthToken', '45a6898dcfa5f36feb66e7da5fd8500e63e89213d1541ba24a385e2edb7d24f6', '[\"*\"]', NULL, NULL, '2024-04-17 04:39:25', '2024-04-17 04:39:25'),
(7, 'App\\Models\\User', 6, 'AuthToken', 'ae4b9e60a727e5b2962f151d30fa77daf5fc3a14d862109429669fec62617c5d', '[\"*\"]', NULL, NULL, '2024-04-17 04:39:43', '2024-04-17 04:39:43'),
(8, 'App\\Models\\User', 6, 'AuthToken', '7a3309d90cf1efbf4a925a7188eb9d262ff4904c754e04d88fa76a8dd479fde7', '[\"*\"]', NULL, NULL, '2024-04-17 04:40:24', '2024-04-17 04:40:24'),
(9, 'App\\Models\\User', 6, 'AuthToken', '1f85ba5da59d9e028afb5b242fa685d49670d884f9c791f174ca3846d1cfa90d', '[\"*\"]', NULL, NULL, '2024-04-17 04:44:04', '2024-04-17 04:44:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `fsm_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `email_verified_at`, `is_verified`, `password`, `remember_token`, `created_at`, `updated_at`, `fsm_token`) VALUES
(1, 'mahesh', 'mahesh@gmail.com', NULL, NULL, 0, '$2y$10$FMtEjatvrXcJpmTSPL.MA.ozh4ZrkCa6Tr2k/sWLMCmIKbFm9Y5MK', NULL, '2024-04-17 02:53:31', '2024-04-17 02:53:31', NULL),
(2, 'mayank', 'mayank@gmail.com', NULL, NULL, 0, '$2y$10$Dc5qSzyUyeuujq84yNyLA.VOR.NzQBLdIPR8CJ2rtsuYl.KXiXiua', NULL, '2024-04-17 02:59:08', '2024-04-17 02:59:08', NULL),
(3, 'mayank', 'm@gmail.com', NULL, NULL, 0, '$2y$10$ba6X2MX6030rxh7idhsYXOIAn3.ECjYgibx3Wy12LuLrgMpopA/iK', NULL, '2024-04-17 02:59:52', '2024-04-17 02:59:52', NULL),
(4, 'mayank', 'bhavesh@gmail.com', NULL, NULL, 0, '$2y$10$l3DV9n5w93dsICWzW4NdFeq71iy/QtDFl9JpfTNyAU5q1M.Mtxo02', NULL, '2024-04-17 03:02:37', '2024-04-17 03:02:37', NULL),
(5, 'mayank001', 'hindumahesh3@gmail.com', '9024100955', NULL, 0, '$2y$10$siSzPEGv6yebS1aSkEQ7V.7qS.gcCUTX8b7Jvaq8feTsovy1ahEEu', '88f1751ccdbdc7a925f8dab64af0b58ac5a8857345ff00941c26e3c67e614989', '2024-04-17 04:07:39', '2024-04-17 04:07:39', NULL),
(6, 'harshit', 'hementajmerawebdeveloper005@gmail.com', '9672327856', NULL, 0, '$2y$10$P0ElfLbEzrwado85kO8JmepoX656MGdf3VDeOA0UxwNGSBVagBksK', 'c05f2dca8813a98ca2fbcef6f17e5b41769046e52dbb02ee7e8869de46a2a712', '2024-04-17 04:36:56', '2024-04-17 04:36:56', NULL),
(7, 'kishan', 'h3@gmail.com', NULL, NULL, 0, '$2y$10$IU0LW4RIz1E3f5OjGmI3UOkth/pCA88lQWjmFm6NtWgzf8BiAao2S', '6d99ddee2a28b3c3ac581c8b04fb29e8f03c7f3879552d65ee7da7abcc2e31fd', '2024-08-10 01:23:31', '2024-08-10 01:23:31', NULL),
(8, 'kishan', 'a@gmail.com', NULL, NULL, 0, '$2y$10$4YYJaTcKDefeFaAjb0c2e.BJSf.F0.pbflPdVDUqLUkrcCf3Cd7s2', 'c385503f2365fa179d61a75c1d05f2400c639e8553d7e71f47001acc3a75369c', '2024-08-10 01:37:59', '2024-08-10 01:37:59', NULL),
(9, 'kishan', 'akash@gmail.com', NULL, NULL, 0, '$2y$10$bDr47C64syJgYNS1hsj.l.UE18JyRO0b2k/8LuIFZh8z3MV.hZATq', '11a773a2e0b1633ed1b3d5393072c76ec7cb4af2ad25bef380e65fca648f9003', '2024-08-10 01:54:00', '2024-08-10 01:54:00', NULL),
(10, 'kishan', 'akah@gmail.com', NULL, NULL, 0, '$2y$10$59xStuLvNZRhdwEI9oWJ1epv.5HEx1Wkr3Q8bVYE7oN4OhvEf3DlO', '1b58988b116309d761e85c16595e87f682bc7cc4d920059a370e71e1e51a8c74', '2024-08-10 01:59:28', '2024-08-10 01:59:28', NULL),
(11, 'kishan', 'aka@gmail.com', NULL, NULL, 0, '$2y$10$iQKoyYXKHWAyLrTG7Z2C9uBkq2QR4sKQVNMYxzAo7ugZ3w25i2kZa', '8ed41cfad5005a546bc76bcaee8e23054c104c6990c22e0b7aa5c5a596f55d77', '2024-08-10 02:00:19', '2024-08-10 02:00:19', NULL),
(12, 'kishan', 'hindumah3@gmail.com', NULL, NULL, 0, '$2y$10$5QCS3yAPmUQPRtTuNxk.WOqu.pZRclpbBEsNSfwr1T6lOgCfOB3/y', '131836910ca827a5f67c1a5563849066cf56ea8e6f129980d8b5344f64a988fd', '2024-08-10 02:33:45', '2024-08-10 02:33:45', NULL),
(13, 'kishan', 'hinmah3@gmail.com', NULL, NULL, 0, '$2y$10$cX13.iQHfVMcsZT.ftSpWeYUCvC/IN11BZSrzF.iDSIDrdh9d3Z92', '73437662124b582f76a94f308dd541495251cb1590e9d73ed41f2c36996b81f8', '2024-08-10 02:34:33', '2024-08-10 02:34:33', NULL),
(14, 'kishan', 'aaaa99@gmail.com', NULL, NULL, 0, '$2y$10$inTDZTmEAwsniI0jj8jlMu6kkDX2ma75z6afbT0F4OSZ8T/hhUIPu', NULL, '2024-08-10 02:37:08', '2024-08-10 02:37:08', NULL),
(15, 'we', 'j@gmail.com', NULL, NULL, 0, '$2y$10$jAntIxBwjUx64R65/A7i..Uvk3DyNTupYjqpXGQnVpThrPkz3LRIe', NULL, '2024-08-10 02:39:59', '2024-08-10 02:39:59', NULL),
(16, 'we', 'juu@gmail.com', NULL, NULL, 0, '$2y$10$dKhQbbFSUOaZv5PYGO6RTu5o19w75vASzNTXW7Apdh7iCDzo2k6JK', NULL, '2024-08-10 02:45:21', '2024-08-10 02:45:21', NULL),
(17, 'we', 'y@gmail.com', NULL, NULL, 0, '$2y$10$0cpNC6u7hyrafzFzMzan1O8JLGp2na2ixpNkDXq/PQPFnCJWu5gCO', NULL, '2024-08-10 02:45:41', '2024-08-10 02:45:41', NULL),
(18, 'ram', 'rishabh@gmail.com', NULL, NULL, 0, '$2y$10$/4cxO.4GJyKMLf6MvL7Y/ukY4qsaWILJQrPtxayQN1gJC/frYHnWO', 'd6b40cc7564c2aa1f8c790d9ec3945787fcaa2916f99b1441f072d9b35d4cda0', '2024-08-10 05:35:20', '2024-08-10 05:35:20', NULL),
(19, 'bb', 'aaccc@gmail.com', NULL, NULL, 0, '$2y$10$Is4sED.8MuFXFX06z/5HYOaSVx9o.8epnKzTLevGCDVzt/oRU9T02', '902293c6d635162b350cf9a0cd32e6a2d957588d675ce965ee09daacf2ec16c4', '2024-08-10 05:36:37', '2024-08-10 05:36:37', NULL),
(20, 'bb', 'pp@gmail.com', NULL, NULL, 0, '$2y$10$Yffc72a5AcxfN2bFytkiheVe4KlOgKqyk8BmoFNcmFlUlzCgqYXUO', NULL, '2024-08-10 05:47:51', '2024-08-10 05:47:51', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_user_id_foreign` (`user_id`),
  ADD KEY `consultations_professional_id_foreign` (`professional_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_professional_id_foreign` FOREIGN KEY (`professional_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `consultations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
