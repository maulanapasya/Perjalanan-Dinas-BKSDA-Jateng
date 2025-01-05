-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2024 at 02:05 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BKSDA_Jateng`
--

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
-- Table structure for table `Kegiatan`
--

CREATE TABLE `Kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `id_program` int(11) NOT NULL,
  `kode_kegiatan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MAK`
--

CREATE TABLE `MAK` (
  `id_mak` int(11) NOT NULL,
  `id_dinas` int(11) NOT NULL,
  `kode_mak` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

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
-- Table structure for table `Pelaksana_Dinas`
--

CREATE TABLE `Pelaksana_Dinas` (
  `id_pegawai` int(11) NOT NULL,
  `id_dinas` int(11) NOT NULL,
  `nama_pegawai` text DEFAULT NULL,
  `status_pegawai` varchar(10) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `nilai_dibayar` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Perjalanan_Dinas`
--

CREATE TABLE `Perjalanan_Dinas` (
  `id_dinas` int(11) NOT NULL,
  `id_kegiatan` int(11) DEFAULT NULL,
  `id_satker` int(11) DEFAULT NULL,
  `nomor_surat_tugas` varchar(30) DEFAULT NULL,
  `nomor_sp2d` varchar(20) DEFAULT NULL,
  `tanggal_surat_tugas` date DEFAULT NULL,
  `tanggal_mulai_dinas` date DEFAULT NULL,
  `tanggal_selesai_dinas` date DEFAULT NULL,
  `tujuan_dinas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `Program`
--

CREATE TABLE `Program` (
  `id_program` int(11) NOT NULL,
  `kode_program` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Satuan_Kerja`
--

CREATE TABLE `Satuan_Kerja` (
  `id_satker` int(11) NOT NULL,
  `kode_satker` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `Kegiatan`
--
ALTER TABLE `Kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `FOREIGN_id_program` (`id_program`);

--
-- Indexes for table `MAK`
--
ALTER TABLE `MAK`
  ADD PRIMARY KEY (`id_mak`),
  ADD KEY `FOREIGN_id_dinas` (`id_dinas`);

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
-- Indexes for table `Pelaksana_Dinas`
--
ALTER TABLE `Pelaksana_Dinas`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `FOREIGN_id_dinas_pelaksana` (`id_dinas`);

--
-- Indexes for table `Perjalanan_Dinas`
--
ALTER TABLE `Perjalanan_Dinas`
  ADD PRIMARY KEY (`id_dinas`),
  ADD KEY `FOREIGN_id_kegiatan` (`id_kegiatan`),
  ADD KEY `FOREIGN_id_satker` (`id_satker`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `Program`
--
ALTER TABLE `Program`
  ADD PRIMARY KEY (`id_program`);

--
-- Indexes for table `Satuan_Kerja`
--
ALTER TABLE `Satuan_Kerja`
  ADD PRIMARY KEY (`id_satker`);

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Kegiatan`
--
ALTER TABLE `Kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `MAK`
--
ALTER TABLE `MAK`
  MODIFY `id_mak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Pelaksana_Dinas`
--
ALTER TABLE `Pelaksana_Dinas`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Perjalanan_Dinas`
--
ALTER TABLE `Perjalanan_Dinas`
  MODIFY `id_dinas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Program`
--
ALTER TABLE `Program`
  MODIFY `id_program` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `Satuan_Kerja`
--
ALTER TABLE `Satuan_Kerja`
  MODIFY `id_satker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Kegiatan`
--
ALTER TABLE `Kegiatan`
  ADD CONSTRAINT `FOREIGN_id_program` FOREIGN KEY (`id_program`) REFERENCES `Program` (`id_program`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `MAK`
--
ALTER TABLE `MAK`
  ADD CONSTRAINT `FOREIGN_id_dinas` FOREIGN KEY (`id_dinas`) REFERENCES `Perjalanan_Dinas` (`id_dinas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Pelaksana_Dinas`
--
ALTER TABLE `Pelaksana_Dinas`
  ADD CONSTRAINT `FOREIGN_id_dinas_pelaksana` FOREIGN KEY (`id_dinas`) REFERENCES `Perjalanan_Dinas` (`id_dinas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Perjalanan_Dinas`
--
ALTER TABLE `Perjalanan_Dinas`
  ADD CONSTRAINT `FOREIGN_id_kegiatan` FOREIGN KEY (`id_kegiatan`) REFERENCES `Kegiatan` (`id_kegiatan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FOREIGN_id_satker` FOREIGN KEY (`id_satker`) REFERENCES `Satuan_Kerja` (`id_satker`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
