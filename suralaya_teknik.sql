-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 05, 2026 at 02:04 AM
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
-- Database: `suralaya_teknik`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--


-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `pesan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('belum_dibaca','sudah_dibaca') DEFAULT 'belum_dibaca'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `keterangan` text,
  `tanggal_upload` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `katalog`
--

CREATE TABLE `katalog` (
  `id` int NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `merek` varchar(50) DEFAULT NULL,
  `jenis_ac` varchar(50) DEFAULT NULL,
  `tipe_ac` varchar(50) DEFAULT NULL,
  `kategori_elektronik` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `katalog`
--

INSERT INTO `katalog` (`id`, `kategori`, `nama`, `deskripsi`, `gambar`, `merek`, `jenis_ac`, `tipe_ac`, `kategori_elektronik`) VALUES
(2, 'Barang / Unit', 'AC Wall Mounted 1 pk', 'hkuguih', '6ab63f7d9cfc3_STC.jpg', 'Daikin', 'AC Single', 'AC Wall Mounted', 'AC'),
(3, 'Barang / Unit', 'grg', 'ertfe', '6ab6422738202_CLEANING_AC.jpeg', 'Polytron', 'AC Single', 'Mesin Cuci 1 Tabung (Top Loading)', 'Mesin Cuci'),
(4, 'Barang / Unit', 'csc', 'c', '6ab6437e9e088_STC.jpg', 'KDK', NULL, 'Kipas Berdiri (Stand Fan)', 'Kipas'),
(5, 'Barang / Unit', 'csc', 'sf', '6ab6438dc26fa_STC.jpg', 'LG', NULL, 'Kulkas Side by Side', 'Kulkas'),
(6, 'Barang / Unit', 'gs', 'gss', '6ab6445a092cd_CLEANING_AC.jpeg', 'Samsung', 'AC VRV / VRF', 'AC Wall Mounted', 'AC'),
(7, 'Barang / Unit', 'teht', 'yhrtey', '6ab644e3b302a_STC.jpg', 'AQUA', NULL, 'Mesin Cuci 2 Tabung (Twin Tub)', 'Mesin Cuci');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `deskripsi_proyek` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `tahun`, `nama_perusahaan`, `deskripsi_proyek`, `created_at`) VALUES
(1, '2026', 'PT. PERMATA BUNDA', 'Proyek Pengadaan dan Penggantian Unit AC VRV System (On Going)', '2026-09-15 05:04:03'),
(2, '2026', 'RSU Bunda Padang', 'Proyek Pengadaan dan Penggantian Unit AC VRV System (On Going)', '2026-09-15 05:04:03'),
(3, '2026', 'PT. NKE', 'Proyek Mekanikal dan Elektrikal Gedung Fakultas Teknik Universitas Negeri Padang (On Going)', '2026-09-15 05:04:03'),
(4, '2025', 'RSIA CICIK', 'Proyek Pengadaan dan Penggantian AC VRV System', '2026-09-15 05:04:03'),
(5, '2025', 'Bank Mandiri Bukittinggi', 'Proyek Pengadaan dan Penggantian Unit AC VRV System', '2026-09-15 05:04:03'),
(6, '2025', 'PT. PERMATA BUNDA', 'Proyek Pengadaan dan Penggantian Unit AC VRV System (On Going)', '2026-09-15 05:04:03'),
(7, '2025', 'RSU Bunda Padang', 'Proyek Pengadaan dan Penggantian Unit AC VRV System (On Going)', '2026-09-15 05:04:03'),
(8, '2025', 'PT. NKE', 'Proyek Mekanikal dan Elektrikal Gedung Fakultas Teknik Universitas Negeri Padang (On Going)', '2026-09-15 05:04:03'),
(9, '2024', 'Semen Padang Hospital', 'Proyek Pengadaan dan Penggantian AC VRF Semen Padang Hospital', '2026-09-15 05:04:03'),
(10, '2023', 'PT. Atar Graha Mandiri', 'Proyek Pembangunan Gedung Fakultas Kedokteran Gigi Universitas Andalas Padang', '2026-09-15 05:04:03'),
(11, '2023', 'PT. Tambarang Elastika Mas', 'Proyek Pembangunan Rumkit RSAD TK III dr. Reksodiwiryo KESDAM I/BB', '2026-09-15 05:04:03'),
(12, '2023', 'PT. Citra Karya Jaya', 'Proyek Lanjutan Pembangunan RSUD Sungai Dareh Kabupaten Dharmasraya', '2026-09-15 05:04:03'),
(13, '2023', 'PT. Satria Lestari Multi', 'Proyek Lanjutan Pembangunan RS Pratama Kabupaten Sijunjung', '2026-09-15 05:04:03'),
(14, '2022', 'Anugerah - Nindya Beton Kso.', 'Proyek Pembangunan Gedung Laboratorium Sentral Universitas Andalas Padang', '2026-09-15 05:04:03'),
(15, '2022', 'PT. Grafos Grahapersada', 'Proyek Pembangunan Lanjutan Balai Diklat Bukittinggi & Gedung Apoteker STIFARM Padang', '2026-09-15 05:04:03'),
(16, '2021', 'PT. Semen Padang / PO PT. Pasoka Sumber Karya', 'Pemasangan Unit AC VRV System Indarung VI', '2026-09-15 05:04:03'),
(17, '2021', 'PT. Bumi Permata Kendari', 'Proyek Pembangunan Gedung Labor FIS UNP', '2026-09-15 05:04:03'),
(18, '2021', 'PT. Bumi Delta Hatten', 'Proyek Pembangunan Gedung Fakultas Teknik UNP & Rumah Tahfiz Adzkia Padang', '2026-09-15 05:04:03'),
(19, '2020', 'PT. Rimbo Arafah', 'Proyek Rumah Sakit Pratama Solok Selatan', '2026-09-15 05:04:03'),
(20, '2020', 'PT. Sas Bunaiyya Innovation & PT. Surya Pratama Mandiri', 'Proyek RSUD Sungai Dareh Dharmasraya', '2026-09-15 05:04:03'),
(21, '2019', 'CV. Yulindo Jaya Mandiri', 'Proyek Badan Pertahanan Nasional', '2026-09-15 05:04:03'),
(22, '2019', 'CV. Alivindo Perkasa', 'Proyek Gedung ISI Padang Panjang', '2026-09-15 05:04:03'),
(23, '2019', 'PT. Grafos', 'Proyek UNP Micro Teaching & English School', '2026-09-15 05:04:03'),
(24, '2019', 'PT. Satria Lestari Multi', 'Proyek Asrama Haji Gedung Serba Guna', '2026-09-15 05:04:03'),
(25, '2019', 'KSO PT. Multi Structure - PT. Mitiga Power', 'Proyek Pembangunan PLTM Gumanti III Alahan Panjang', '2026-09-15 05:04:03'),
(26, '2018', 'PT. Rimbo Peraduan', 'Proyek Asrama Haji Sumbar & RSUD Rengat', '2026-09-15 05:04:03'),
(27, '2018', 'PT. Tunas Pembangunan', 'Proyek BNI Cabang Cibinong', '2026-09-15 05:04:03'),
(28, '2018', 'PT. Tasya Total Persada', 'Proyek BAPEDA Padang', '2026-09-15 05:04:03'),
(29, '2017', 'PT. Rimbo Peraduan', 'Proyek Pembangunan Gedung SDM', '2026-09-15 05:04:03'),
(30, '2017', 'PT. Tasya Total Persada', 'Proyek Pembangunan Gedung DPKD Padang', '2026-09-15 05:04:03'),
(31, '2017', 'PT. Putra Giat Pembangunan', 'Proyek Taman Budaya Padang', '2026-09-15 05:04:03'),
(32, '2016', 'PT. Grafos & PT. Putra Giat Pembangunan', 'Proyek LPMP Padang & RSUD Solok', '2026-09-15 05:04:03'),
(33, '2016', 'PT. CTA', 'Proyek Kantor Gubernur Sumatera Barat', '2026-09-15 05:04:03'),
(34, '2016', 'PT. Trisco Jaya Utama', 'Proyek Kantor Pajak Payakumbuh', '2026-09-15 05:04:03'),
(35, '2015', 'PT. Paduan Bakti', 'Proyek POLDA Padang', '2026-09-15 05:04:03'),
(36, '2015', 'PT. Grafos', 'Proyek Bank Nagari Batu Sangkar', '2026-09-15 05:04:03'),
(37, '2015', 'PT. Putra Giat Pembangunan', 'Proyek Rumah Sakit Paru Lubuk Alung', '2026-09-15 05:04:03'),
(38, '2014', 'PT. Bank Nagari Jl. Pemuda Padang', 'Proyek Pemasangan AC System VRV & Perawatan sampai sekarang', '2026-09-15 05:04:03'),
(39, '2014', 'PT. Grafos & PT. Brantas Adipraya', 'Proyek Balai Pustaka Padang & PLN Pekanbaru', '2026-09-15 05:04:03'),
(40, '2014', 'CV. Utama Jaya Kontruksi', 'Proyek BNI Siak Riau', '2026-09-15 05:04:03'),
(41, '2013', 'Kantor BPK Padang & PT. GBE', 'Perawatan & Proyek Gedung Bea Cukai Padang, UNP Teknik', '2026-09-15 05:04:03'),
(42, '2013', 'PT. Rimbo Peraduan', 'Proyek Gedung Bung Hatta & Gedung Pertanian Padang', '2026-09-15 05:04:03'),
(43, '2012', 'PT. CASA PRIMA', 'Proyek Renovasi Gedung RSUD M. Djamil Padang', '2026-09-15 05:04:03'),
(44, '2012', 'PT. Raikin', 'Proyek PLTU Teluk Sirih Padang', '2026-09-15 05:04:03'),
(45, '2011', 'PT. Grafos', 'Proyek Gedung Nasional Batu Sangkar', '2026-09-15 05:04:03'),
(46, '2011', 'PT. Paduan Bakti', 'Proyek BPKP Padang', '2026-09-15 05:04:03'),
(47, '2010', 'PT. Rimbo Peraduan', 'Proyek PDAM Padang', '2026-09-15 05:04:03'),
(48, '2010', 'PT. Paduan Bakti', 'Proyek Taspen Padang', '2026-09-15 05:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `proyek`
--

CREATE TABLE `proyek` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitor_logs`
--

CREATE TABLE `visitor_logs` (
  `id` int NOT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text,
  `halaman` varchar(255) DEFAULT NULL,
  `visited_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visitor_logs`
--

INSERT INTO `visitor_logs` (`id`, `ip_address`, `user_agent`, `halaman`, `visited_at`) VALUES
(6, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-21 03:11:09'),
(7, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 06:32:55'),
(8, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 06:53:46'),
(9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 06:54:58'),
(10, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 06:55:19'),
(11, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/galeri.php', '2026-09-25 06:55:34'),
(12, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/galeri.php', '2026-09-25 07:00:21'),
(13, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/galeri.php', '2026-09-25 07:03:51'),
(14, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:04:00'),
(15, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:04:20'),
(16, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:04:32'),
(17, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:04:43'),
(18, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:05:20'),
(19, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/galeri.php', '2026-09-25 07:05:27'),
(20, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:05:47'),
(21, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:07:41'),
(22, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/galeri.php', '2026-09-25 07:08:03'),
(23, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:08:17'),
(24, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:08:28'),
(25, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:09:42'),
(26, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:12:32'),
(27, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:12:43'),
(28, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:50:30'),
(29, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:51:18'),
(30, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-25 07:56:29'),
(31, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-26 02:23:38'),
(32, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/galeri.php', '2026-09-26 02:23:55'),
(33, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/index.php', '2026-09-28 06:43:33'),
(34, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '/suralaya_teknik/galeri.php', '2026-09-28 06:43:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `katalog`
--
ALTER TABLE `katalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proyek`
--
ALTER TABLE `proyek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `katalog`
--
ALTER TABLE `katalog`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `proyek`
--
ALTER TABLE `proyek`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
