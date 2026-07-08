-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql300.infinityfree.com
-- Generation Time: Jul 08, 2026 at 11:47 AM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_42235879_bekaledu`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `buyer_id`, `product_id`, `quantity`, `created_at`) VALUES
(8, 29, 98, 2, '2026-07-02 17:13:12'),
(9, 29, 95, 1, '2026-07-02 17:13:25');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `province_id`, `name`) VALUES
(1, 1, 'Kabupaten Pandeglang'),
(2, 1, 'Kabupaten Lebak'),
(3, 1, 'Kabupaten Tangerang'),
(4, 1, 'Kabupaten Serang'),
(5, 1, 'Kota Tangerang'),
(6, 1, 'Kota Cilegon'),
(7, 1, 'Kota Serang'),
(8, 1, 'Kota Tangerang Selatan'),
(9, 2, 'Jakarta Pusat'),
(10, 2, 'Jakarta Utara'),
(11, 2, 'Jakarta Barat'),
(12, 2, 'Jakarta Selatan'),
(13, 2, 'Jakarta Timur'),
(14, 2, 'Kepulauan Seribu'),
(15, 3, 'Kabupaten Bandung'),
(16, 3, 'Kabupaten Bandung Barat'),
(17, 3, 'Kabupaten Bekasi'),
(18, 3, 'Kabupaten Bogor'),
(19, 3, 'Kabupaten Ciamis'),
(20, 3, 'Kabupaten Cianjur'),
(21, 3, 'Kabupaten Cirebon'),
(22, 3, 'Kabupaten Garut'),
(23, 3, 'Kabupaten Indramayu'),
(24, 3, 'Kabupaten Karawang'),
(25, 3, 'Kabupaten Kuningan'),
(26, 3, 'Kabupaten Majalengka'),
(27, 3, 'Kabupaten Pangandaran'),
(28, 3, 'Kabupaten Purwakarta'),
(29, 3, 'Kabupaten Subang'),
(30, 3, 'Kabupaten Sukabumi'),
(31, 3, 'Kabupaten Sumedang'),
(32, 3, 'Kabupaten Tasikmalaya'),
(33, 3, 'Kota Bandung'),
(34, 3, 'Kota Banjar'),
(35, 3, 'Kota Bekasi'),
(36, 3, 'Kota Bogor'),
(37, 3, 'Kota Cimahi'),
(38, 3, 'Kota Cirebon'),
(39, 3, 'Kota Depok'),
(40, 3, 'Kota Sukabumi'),
(41, 3, 'Kota Tasikmalaya'),
(42, 4, 'Kabupaten Banjarnegara'),
(43, 4, 'Kabupaten Banyumas'),
(44, 4, 'Kabupaten Batang'),
(45, 4, 'Kabupaten Blora'),
(46, 4, 'Kabupaten Boyolali'),
(47, 4, 'Kabupaten Brebes'),
(48, 4, 'Kabupaten Cilacap'),
(49, 4, 'Kabupaten Demak'),
(50, 4, 'Kabupaten Grobogan'),
(51, 4, 'Kabupaten Jepara'),
(52, 4, 'Kabupaten Karanganyar'),
(53, 4, 'Kabupaten Kebumen'),
(54, 4, 'Kabupaten Kendal'),
(55, 4, 'Kabupaten Klaten'),
(56, 4, 'Kabupaten Kudus'),
(57, 4, 'Kabupaten Magelang'),
(58, 4, 'Kabupaten Pati'),
(59, 4, 'Kabupaten Pekalongan'),
(60, 4, 'Kabupaten Pemalang'),
(61, 4, 'Kabupaten Purbalingga'),
(62, 4, 'Kabupaten Purworejo'),
(63, 4, 'Kabupaten Rembang'),
(64, 4, 'Kabupaten Semarang'),
(65, 4, 'Kabupaten Sragen'),
(66, 4, 'Kabupaten Sukoharjo'),
(67, 4, 'Kabupaten Tegal'),
(68, 4, 'Kabupaten Temanggung'),
(69, 4, 'Kabupaten Wonogiri'),
(70, 4, 'Kabupaten Wonosobo'),
(71, 4, 'Kota Magelang'),
(72, 4, 'Kota Pekalongan'),
(73, 4, 'Kota Salatiga'),
(74, 4, 'Kota Semarang'),
(75, 4, 'Kota Surakarta'),
(76, 4, 'Kota Tegal'),
(77, 5, 'Kabupaten Bantul'),
(78, 5, 'Kabupaten Gunungkidul'),
(79, 5, 'Kabupaten Kulon Progo'),
(80, 5, 'Kabupaten Sleman'),
(81, 5, 'Kota Yogyakarta'),
(82, 6, 'Kabupaten Bangkalan'),
(83, 6, 'Kabupaten Banyuwangi'),
(84, 6, 'Kabupaten Blitar'),
(85, 6, 'Kabupaten Bojonegoro'),
(86, 6, 'Kabupaten Bondowoso'),
(87, 6, 'Kabupaten Gresik'),
(88, 6, 'Kabupaten Jember'),
(89, 6, 'Kabupaten Jombang'),
(90, 6, 'Kabupaten Kediri'),
(91, 6, 'Kabupaten Lamongan'),
(92, 6, 'Kabupaten Lumajang'),
(93, 6, 'Kabupaten Madiun'),
(94, 6, 'Kabupaten Magetan'),
(95, 6, 'Kabupaten Malang'),
(96, 6, 'Kabupaten Mojokerto'),
(97, 6, 'Kabupaten Nganjuk'),
(98, 6, 'Kabupaten Ngawi'),
(99, 6, 'Kabupaten Pacitan'),
(100, 6, 'Kabupaten Pamekasan'),
(101, 6, 'Kabupaten Pasuruan'),
(102, 6, 'Kabupaten Ponorogo'),
(103, 6, 'Kabupaten Probolinggo'),
(104, 6, 'Kabupaten Sampang'),
(105, 6, 'Kabupaten Sidoarjo'),
(106, 6, 'Kabupaten Situbondo'),
(107, 6, 'Kabupaten Sumenep'),
(108, 6, 'Kabupaten Trenggalek'),
(109, 6, 'Kabupaten Tuban'),
(110, 6, 'Kabupaten Tulungagung'),
(111, 6, 'Kota Batu'),
(112, 6, 'Kota Blitar'),
(113, 6, 'Kota Kediri'),
(114, 6, 'Kota Madiun'),
(115, 6, 'Kota Malang'),
(116, 6, 'Kota Mojokerto'),
(117, 6, 'Kota Pasuruan'),
(118, 6, 'Kota Probolinggo'),
(119, 6, 'Kota Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `user1_id`, `user2_id`, `created_at`) VALUES
(4, 29, 37, '2026-06-27 15:36:35');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `message`, `created_at`) VALUES
(21, 4, 29, 'test  diterima', '2026-06-27 15:36:57'),
(20, 4, 37, 'test', '2026-06-27 15:36:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(18,2) DEFAULT NULL,
  `status` enum('pending','diproses','dikirim','selesai','dibatalkan') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `payment_status` enum('belum_bayar','menunggu_verifikasi','sudah_dibayar','ditolak') NOT NULL DEFAULT 'belum_bayar',
  `payment_proof` varchar(255) DEFAULT NULL,
  `payment_uploaded_at` datetime DEFAULT NULL,
  `payment_verified_at` datetime DEFAULT NULL,
  `payment_verified_by` int(11) DEFAULT NULL,
  `status_pembayaran` enum('belum_dibayar','menunggu_verifikasi','sudah_dibayar','dibatalkan') DEFAULT 'belum_dibayar',
  `bukti_transfer` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `buyer_id`, `seller_id`, `product_id`, `quantity`, `total_price`, `status`, `created_at`, `payment_status`, `payment_proof`, `payment_uploaded_at`, `payment_verified_at`, `payment_verified_by`, `status_pembayaran`, `bukti_transfer`) VALUES
(4, 29, 37, 76, 1, '210000.00', 'selesai', '2026-06-27 15:34:00', 'sudah_dibayar', 'payment_4_1782574493.png', '2026-06-27 08:34:53', '2026-06-27 08:35:17', 37, 'belum_dibayar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `rating_avg` decimal(3,2) DEFAULT 0.00,
  `rating_count` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `name`, `description`, `price`, `stock`, `category`, `image`, `created_at`, `rating_avg`, `rating_count`) VALUES
(8, 32, 'Laptop Lenovo ThinkPad X260', 'Laptop bekas untuk kebutuhan belajar dan Office.', '2850000.00', 1, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(9, 33, 'Buku Fisika Kelas 11', 'Buku pelajaran fisika lengkap dengan latihan soal.', '90000.00', 3, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(10, 33, 'Tas Ransel Polo Classic', 'Tas sekolah kapasitas besar kondisi sangat baik.', '190000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(3, 31, 'Buku Matematika Kelas 10 Kurikulum Merdeka', 'Buku pelajaran Matematika bekas kondisi sangat baik, hampir tanpa coretan.', '85000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(4, 31, 'Tas Sekolah Eiger 25L', 'Tas sekolah original, semua resleting berfungsi normal.', '275000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(5, 31, 'Kalkulator Casio FX-991EX', 'Kalkulator scientific original, cocok untuk SMA dan kuliah.', '295000.00', 3, 'Kalkulator', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(6, 32, 'Seragam SMA Putih Abu Ukuran M', 'Seragam bekas masih rapi dan layak pakai.', '70000.00', 4, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(7, 32, 'Pulpen Gel Set Isi 12', 'Pulpen gel warna hitam, tinta lancar.', '45000.00', 10, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(11, 33, 'Mouse Wireless Logitech M331', 'Mouse wireless original, baterai awet.', '175000.00', 5, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(12, 34, 'Seragam Pramuka SMA Lengkap', 'Kemeja dan celana pramuka kondisi bersih.', '130000.00', 2, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(13, 34, 'Kalkulator Casio FX-570ES Plus', 'Masih berfungsi sempurna untuk ujian.', '185000.00', 4, 'Kalkulator', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(14, 34, 'Binder A5 Premium', 'Binder lengkap dengan pembatas dan refill.', '85000.00', 8, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(15, 35, 'Buku Biologi Kelas 12', 'Buku pelajaran Biologi Kurikulum Merdeka.', '80000.00', 4, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(16, 35, 'Headset Bluetooth Baseus', 'Headset wireless cocok untuk kelas online.', '325000.00', 2, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(17, 35, 'Tempat Pensil Hardcase', 'Tempat pensil anti bentur kapasitas besar.', '50000.00', 7, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(18, 36, 'Tas Sekolah Adidas Original', 'Tas sekolah original dengan banyak kompartemen.', '315000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(19, 36, 'Seragam Olahraga SMA', 'Setelan olahraga sekolah ukuran L.', '95000.00', 3, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(20, 36, 'Penggaris Set Lengkap', 'Set penggaris matematika untuk siswa.', '35000.00', 12, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:27:45', '0.00', 0),
(21, 37, 'Buku Kimia Kelas 12 Kurikulum Merdeka', 'Buku Kimia lengkap dengan latihan soal dan pembahasan.', '88000.00', 4, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(22, 37, 'Tas Sekolah Converse Original', 'Tas sekolah original kondisi sangat baik, resleting normal.', '245000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(23, 37, 'Keyboard Logitech K120 USB', 'Keyboard USB cocok untuk belajar dan mengetik.', '135000.00', 5, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(24, 38, 'Seragam SMP Putih Biru Ukuran L', 'Seragam bekas bersih, jahitan masih sangat rapi.', '65000.00', 5, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(25, 38, 'Kalkulator Casio FX-350MS', 'Kalkulator scientific original, seluruh tombol berfungsi.', '145000.00', 4, 'Kalkulator', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(26, 38, 'Pensil Mekanik Faber-Castell 0.5mm', 'Pensil mekanik lengkap dengan isi ulang.', '42000.00', 10, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(27, 39, 'Buku Bahasa Inggris Kelas 11', 'Buku pelajaran Bahasa Inggris sesuai Kurikulum Merdeka.', '76000.00', 6, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(28, 39, 'Tas Sekolah Bodypack Urban', 'Tas sekolah kapasitas besar dengan slot laptop.', '265000.00', 3, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(29, 39, 'Webcam Logitech C270 HD', 'Webcam HD cocok untuk kelas online.', '295000.00', 2, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(30, 40, 'Seragam Batik Sekolah Lengan Pendek', 'Seragam batik sekolah kondisi sangat baik.', '85000.00', 4, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(31, 40, 'Pulpen Pilot G2 Set Isi 6', 'Pulpen gel original dengan tinta halus.', '68000.00', 12, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(32, 40, 'Power Bank Xiaomi 10000mAh', 'Power bank original, baterai masih sehat.', '245000.00', 3, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(33, 41, 'Buku Sejarah Indonesia Kelas 10', 'Buku pelajaran sejarah lengkap dan masih bersih.', '72000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(34, 41, 'Kalkulator Citizen Scientific SR-270X', 'Kalkulator scientific cocok untuk SMA dan kuliah.', '170000.00', 3, 'Kalkulator', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(35, 41, 'Kotak Pensil Transparan Besar', 'Kotak pensil plastik tebal dengan dua kompartemen.', '35000.00', 8, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(36, 42, 'Seragam SMK Abu-Abu Ukuran XL', 'Seragam sekolah bekas kondisi 90%, nyaman dipakai.', '78000.00', 4, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(37, 42, 'Buku Ekonomi Kelas 12', 'Buku pelajaran ekonomi lengkap dengan contoh soal.', '81000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(38, 42, 'Flashdisk SanDisk 64GB USB 3.0', 'Flashdisk original, kecepatan transfer tinggi.', '125000.00', 6, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:29:24', '0.00', 0),
(39, 43, 'Buku Geografi Kelas 11 Kurikulum Merdeka', 'Buku pelajaran Geografi kondisi sangat baik dan lengkap.', '79000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(40, 43, 'Tas Sekolah Nike Original', 'Tas sekolah original dengan kompartemen laptop.', '315000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(41, 43, 'Penghapus dan Penggaris Set Faber-Castell', 'Satu set alat tulis berkualitas untuk kebutuhan sekolah.', '28000.00', 12, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(42, 44, 'Seragam SD Putih Merah Ukuran L', 'Seragam SD bekas kondisi bersih dan rapi.', '55000.00', 4, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(43, 44, 'Kalkulator Canon LS-100TK', 'Kalkulator meja original, cocok untuk pelajar.', '95000.00', 6, 'Kalkulator', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(44, 44, 'Tablet Samsung Galaxy Tab A8', 'Tablet bekas untuk belajar online, kondisi normal.', '2450000.00', 1, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(45, 45, 'Buku Bahasa Indonesia Kelas 12', 'Buku pelajaran lengkap sesuai Kurikulum Merdeka.', '74000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(46, 45, 'Tas Selempang Sekolah Eiger', 'Tas selempang multifungsi untuk membawa buku.', '165000.00', 3, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(47, 45, 'Stapler Kenko HD-10', 'Stapler original lengkap dengan isi staples.', '45000.00', 8, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(48, 46, 'Seragam SMP Putih Biru Ukuran M', 'Seragam sekolah bekas kondisi 90%, nyaman dipakai.', '68000.00', 4, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(49, 46, 'Buku Informatika Kelas 10', 'Buku pelajaran Informatika Kurikulum Merdeka.', '92000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(50, 46, 'Printer Epson L3110', 'Printer ink tank bekas masih berfungsi dengan baik.', '1650000.00', 1, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(51, 47, 'Kalkulator Casio FX-82MS', 'Kalkulator scientific original untuk SMP dan SMA.', '155000.00', 5, 'Kalkulator', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(52, 47, 'Pensil Warna Faber-Castell 24 Warna', 'Pensil warna original kondisi baru.', '68000.00', 7, 'Alat Tulis', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(53, 47, 'Tas Sekolah Puma Original', 'Tas sekolah original dengan bahan tahan air.', '285000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(54, 48, 'Buku PPKn Kelas 10 Kurikulum Merdeka', 'Buku pelajaran PPKn kondisi sangat baik.', '70000.00', 6, 'Buku Pelajaran', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(55, 48, 'Seragam Batik Sekolah Motif Biru', 'Seragam batik sekolah ukuran XL kondisi bagus.', '89000.00', 3, 'Seragam', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(56, 48, 'Speaker Bluetooth JBL Go 3', 'Speaker Bluetooth original, suara jernih dan baterai awet.', '425000.00', 2, 'Elektronik', 'gambar-produk-contoh.png', '2026-06-27 14:31:13', '0.00', 0),
(57, 31, 'Buku Matematika Kelas 10 Kurikulum Merdeka', 'Buku pelajaran bekas kondisi sangat baik.', '85000.00', 6, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(58, 31, 'Seragam SMA Putih Abu Size M', 'Seragam sekolah bersih dan masih layak pakai.', '120000.00', 3, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(59, 31, 'Tas Sekolah Eiger 25L', 'Tas sekolah original dengan banyak kompartemen.', '250000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(60, 32, 'Kalkulator Casio FX-991EX', 'Kalkulator scientific original kondisi mulus.', '310000.00', 4, 'Kalkulator', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(61, 32, 'Paket Alat Tulis Lengkap', 'Berisi pensil, pulpen, penghapus dan penggaris.', '45000.00', 10, 'Alat Tulis', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(62, 32, 'Laptop Lenovo ThinkPad Bekas', 'Laptop bekas cocok untuk pelajar.', '2850000.00', 1, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(63, 33, 'Buku Fisika SMA Kelas 11', 'Buku pelajaran fisika lengkap.', '70000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(64, 33, 'Tas Sekolah Adidas', 'Tas sekolah original kondisi bagus.', '180000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(65, 33, 'Mouse Wireless Logitech', 'Mouse wireless untuk belajar.', '95000.00', 7, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(66, 34, 'Seragam Pramuka SMA', 'Seragam lengkap ukuran L.', '95000.00', 4, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(67, 34, 'Buku Kimia SMA', 'Buku kimia kurikulum terbaru.', '82000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(68, 34, 'Flashdisk Sandisk 64GB', 'Flashdisk original kecepatan tinggi.', '120000.00', 6, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(69, 35, 'Kalkulator Casio FX-570ES Plus', 'Kalkulator untuk SMA dan kuliah.', '225000.00', 4, 'Kalkulator', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(70, 35, 'Tas Sekolah Polo', 'Tas sekolah ringan dan kuat.', '195000.00', 3, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(71, 35, 'Pulpen Gel Set 10 Warna', 'Pulpen warna-warni untuk catatan.', '60000.00', 12, 'Alat Tulis', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(72, 36, 'Buku Biologi SMA', 'Buku lengkap dengan latihan soal.', '78000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(73, 36, 'Seragam Olahraga SMA', 'Kondisi masih sangat baik.', '85000.00', 3, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(74, 36, 'Headset JBL Original', 'Headset cocok untuk belajar online.', '350000.00', 2, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:33:20', '0.00', 0),
(75, 37, 'Buku Bahasa Inggris SMA Kelas 12', 'Buku pelajaran lengkap dan masih rapi.', '72000.00', 6, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(76, 37, 'Tas Sekolah Converse', 'Tas sekolah original kondisi sangat baik.', '210000.00', 998, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(77, 37, 'Power Bank Xiaomi 10000mAh', 'Power bank original cocok untuk pelajar.', '190000.00', 5, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(78, 38, 'Seragam Batik Sekolah', 'Seragam batik ukuran M kondisi bagus.', '90000.00', 4, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(79, 38, 'Buku Sejarah Indonesia SMA', 'Buku pelajaran lengkap.', '68000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(80, 38, 'Set Pensil Gambar Faber Castell', 'Pensil gambar berbagai tingkat kekerasan.', '125000.00', 8, 'Alat Tulis', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(81, 39, 'Kalkulator Citizen Scientific', 'Kalkulator scientific cocok ujian.', '175000.00', 6, 'Kalkulator', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(82, 39, 'Tas Sekolah Nike', 'Tas sekolah original banyak kompartemen.', '235000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(83, 39, 'Lampu Belajar LED USB', 'Lampu belajar hemat listrik.', '85000.00', 9, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(84, 40, 'Buku Ekonomi SMA', 'Buku ekonomi kurikulum terbaru.', '76000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(85, 40, 'Seragam Putih Abu Size L', 'Seragam bersih dan siap pakai.', '115000.00', 3, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(86, 40, 'Binder A5 Premium', 'Binder lengkap dengan refill.', '98000.00', 10, 'Alat Tulis', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(87, 41, 'Kalkulator Casio FX-82MS', 'Kalkulator scientific original.', '165000.00', 5, 'Kalkulator', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(88, 41, 'Laptop Sleeve 14 Inch', 'Pelindung laptop berbahan tebal.', '78000.00', 7, 'Lainnya', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(89, 41, 'Keyboard USB Logitech', 'Keyboard nyaman untuk belajar.', '145000.00', 4, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(90, 42, 'Buku Geografi SMA', 'Buku pelajaran kondisi sangat baik.', '69000.00', 6, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(91, 42, 'Tas Sekolah Bodypack', 'Tas sekolah original tahan air.', '245000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(92, 42, 'Penggaris Set Lengkap', 'Berisi penggaris, busur dan segitiga.', '35000.00', 15, 'Alat Tulis', 'gambar-produk-contoh-2.png', '2026-06-27 14:34:39', '0.00', 0),
(93, 43, 'Seragam Pramuka Lengkap', 'Seragam pramuka lengkap kondisi sangat baik.', '135000.00', 4, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(94, 43, 'Buku Kimia SMA Kelas 11', 'Buku pelajaran lengkap dan terawat.', '74000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(95, 43, 'Mouse Wireless Logitech M170', 'Mouse wireless original nyaman digunakan.', '145000.00', 6, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(96, 44, 'Tas Sekolah Adidas', 'Tas sekolah original kapasitas besar.', '225000.00', 3, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(97, 44, 'Kalkulator Casio FX-991EX', 'Kalkulator scientific original.', '310000.00', 3, 'Kalkulator', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(98, 44, 'Pulpen Gel Set 12 Warna', 'Pulpen warna-warni untuk belajar dan mencatat.', '65000.00', 10, 'Alat Tulis', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(99, 45, 'Buku Biologi SMA', 'Buku pelajaran kurikulum terbaru.', '73000.00', 6, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(100, 45, 'Seragam Olahraga Sekolah', 'Seragam olahraga ukuran L kondisi bagus.', '118000.00', 3, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(101, 45, 'Flashdisk SanDisk 64GB', 'Flashdisk original kecepatan tinggi.', '135000.00', 8, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(102, 46, 'Tas Sekolah Eiger', 'Tas sekolah premium tahan air.', '285000.00', 2, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(103, 46, 'Buku Bahasa Indonesia SMA', 'Buku pelajaran kondisi sangat baik.', '69000.00', 7, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(104, 46, 'Stapler Kenko HD-10', 'Stapler berkualitas untuk kebutuhan sekolah.', '42000.00', 12, 'Alat Tulis', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(105, 47, 'Kalkulator Citizen CT-555N', 'Kalkulator meja multifungsi.', '95000.00', 7, 'Kalkulator', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(106, 47, 'Headset JBL C100SI', 'Headset original cocok untuk kelas online.', '180000.00', 5, 'Elektronik', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(107, 47, 'Tempat Pensil Hardcase', 'Tempat pensil kuat dan luas.', '52000.00', 11, 'Lainnya', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(108, 48, 'Buku Matematika Wajib SMA', 'Buku pelajaran lengkap kondisi mulus.', '76000.00', 5, 'Buku Pelajaran', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(109, 48, 'Seragam Putih Abu Premium', 'Seragam sekolah premium ukuran M.', '125000.00', 4, 'Seragam', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0),
(110, 48, 'Tas Laptop 15 Inch', 'Tas laptop cocok untuk mahasiswa dan pelajar.', '265000.00', 3, 'Tas Sekolah', 'gambar-produk-contoh-2.png', '2026-06-27 14:36:42', '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_wishlist`
--

CREATE TABLE `product_wishlist` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`) VALUES
(1, 'Banten'),
(2, 'DKI Jakarta'),
(3, 'Jawa Barat'),
(4, 'Jawa Tengah'),
(5, 'DI Yogyakarta'),
(6, 'Jawa Timur');

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `level` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `partner_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`id`, `title`, `institution`, `location`, `level`, `description`, `image`, `deadline`, `created_at`, `partner_id`) VALUES
(14, 'ITS Green Technology Scholarship', 'Institut Teknologi Sepuluh Nopember', 'Surabaya', 'S2', 'Dukungan penelitian energi terbarukan dan teknologi ramah lingkungan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-09-15', '2026-06-27 06:05:12', 13),
(13, 'ITS Smart Engineering Scholarship', 'Institut Teknologi Sepuluh Nopember', 'Surabaya', 'S1', 'Beasiswa bagi mahasiswa teknik dengan prestasi nasional.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-04-30', '2026-06-27 06:05:12', 13),
(7, 'Beasiswa Prestasi UI 2028', 'Universitas Indonesia', 'Depok', 'S1', 'Beasiswa penuh bagi mahasiswa berprestasi akademik dengan IPK tinggi dan aktif organisasi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-05-31', '2026-06-27 06:05:12', 10),
(8, 'Beasiswa Riset Muda UI', 'Universitas Indonesia', 'Depok', 'S2', 'Pendanaan penelitian dan bantuan biaya pendidikan untuk mahasiswa magister.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-09-30', '2026-06-27 06:05:12', 10),
(9, 'ITB Future Innovator Scholarship', 'Institut Teknologi Bandung', 'Bandung', 'S1', 'Beasiswa untuk calon inovator di bidang teknologi, sains, dan rekayasa.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-06-15', '2026-06-27 06:05:12', 11),
(10, 'Beasiswa Startup Teknologi ITB', 'Institut Teknologi Bandung', 'Bandung', 'S1', 'Dukungan biaya kuliah bagi mahasiswa yang memiliki startup atau proyek teknologi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-10-15', '2026-06-27 06:05:12', 11),
(11, 'Beasiswa Kepemimpinan UGM', 'Universitas Gadjah Mada', 'Yogyakarta', 'S1', 'Program bagi mahasiswa aktif organisasi dengan prestasi akademik baik.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-07-31', '2026-06-27 06:05:12', 12),
(12, 'UGM Graduate Excellence Scholarship', 'Universitas Gadjah Mada', 'Yogyakarta', 'S2', 'Pendanaan pendidikan pascasarjana untuk lulusan berprestasi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-11-30', '2026-06-27 06:05:12', 12),
(15, 'IPB Agritech Scholarship', 'IPB University', 'Bogor', 'S1', 'Beasiswa untuk mahasiswa bidang pertanian, pangan, dan peternakan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-06-30', '2026-06-27 06:05:12', 14),
(16, 'IPB Sustainable Agriculture Scholarship', 'IPB University', 'Bogor', 'S2', 'Pendanaan riset pertanian berkelanjutan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-12-15', '2026-06-27 06:05:12', 14),
(17, 'UNAIR Health Excellence Scholarship', 'Universitas Airlangga', 'Surabaya', 'S1', 'Program bantuan biaya pendidikan bagi mahasiswa bidang kesehatan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-05-20', '2026-06-27 06:05:12', 15),
(18, 'UNAIR Medical Research Grant', 'Universitas Airlangga', 'Surabaya', 'S2', 'Pendanaan penelitian kedokteran dan kesehatan masyarakat.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-10-20', '2026-06-27 06:05:12', 15),
(19, 'UNDIP Maritime Scholarship', 'Universitas Diponegoro', 'Semarang', 'S1', 'Beasiswa bagi mahasiswa yang meneliti bidang kemaritiman Indonesia.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-07-10', '2026-06-27 06:05:12', 16),
(20, 'UNDIP Future Leader Scholarship', 'Universitas Diponegoro', 'Semarang', 'S1', 'Program kepemimpinan dan bantuan biaya kuliah.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-11-15', '2026-06-27 06:05:12', 16),
(21, 'UB Entrepreneur Scholarship', 'Universitas Brawijaya', 'Malang', 'S1', 'Beasiswa untuk mahasiswa yang mengembangkan bisnis rintisan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-05-10', '2026-06-27 06:05:12', 17),
(22, 'UB Agriculture Innovation Scholarship', 'Universitas Brawijaya', 'Malang', 'S2', 'Pendanaan riset inovasi pertanian modern.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-09-25', '2026-06-27 06:05:12', 17),
(23, 'UNPAD Academic Achievement Scholarship', 'Universitas Padjadjaran', 'Bandung', 'S1', 'Beasiswa prestasi akademik untuk mahasiswa baru.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-08-20', '2026-06-27 06:05:12', 18),
(24, 'UNPAD Public Health Scholarship', 'Universitas Padjadjaran', 'Bandung', 'S2', 'Pendanaan studi kesehatan masyarakat dan epidemiologi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-12-20', '2026-06-27 06:05:12', 18),
(25, 'Beasiswa Digital Future Telkom', 'Telkom University', 'Bandung', 'S1', 'Beasiswa bagi mahasiswa yang memiliki minat tinggi pada bidang teknologi digital, software engineering, dan AI.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-02-15', '2026-06-27 06:09:33', 19),
(26, 'Beasiswa Startup Innovator', 'Telkom University', 'Bandung', 'S1', 'Pendanaan pendidikan bagi calon founder startup teknologi yang memiliki ide bisnis inovatif.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-05-31', '2026-06-27 06:09:33', 19),
(27, 'Beasiswa BINUS Global Talent', 'BINUS University', 'Jakarta', 'S1', 'Beasiswa untuk siswa berprestasi yang ingin menempuh pendidikan bertaraf internasional.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-03-20', '2026-06-27 06:09:33', 20),
(28, 'Beasiswa Creative Technology', 'BINUS University', 'Jakarta', 'S1', 'Program bantuan biaya kuliah bagi mahasiswa di bidang game development, animation, dan creative technology.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-08-15', '2026-06-27 06:09:33', 20),
(29, 'Beasiswa Petra Excellence', 'Universitas Kristen Petra', 'Surabaya', 'S1', 'Beasiswa prestasi akademik bagi mahasiswa baru Universitas Kristen Petra.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-04-12', '2026-06-27 06:09:33', 21),
(30, 'Beasiswa Architecture Vision', 'Universitas Kristen Petra', 'Surabaya', 'S1', 'Beasiswa khusus calon mahasiswa Arsitektur dengan portofolio terbaik.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-09-10', '2026-06-27 06:09:33', 21),
(31, 'Beasiswa Hafidz Nusantara', 'UIN Syarif Hidayatullah', 'Jakarta', 'S1', 'Beasiswa bagi calon mahasiswa penghafal Al-Quran dengan prestasi akademik baik.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-03-01', '2026-06-27 06:09:33', 22),
(32, 'Beasiswa Islamic Leadership', 'UIN Syarif Hidayatullah', 'Jakarta', 'S2', 'Program beasiswa untuk pengembangan pemimpin muda muslim di bidang pendidikan dan sosial.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-10-01', '2026-06-27 06:09:33', 22),
(33, 'Beasiswa Garuda Sebelas Maret', 'Universitas Sebelas Maret', 'Solo', 'S1', 'Beasiswa penuh bagi siswa berprestasi dari seluruh Indonesia.', '/media/beasiswa-gambar/contoh-gambar-beasiswa.png', '2028-05-18', '2026-06-27 06:09:33', 23),
(34, 'Beasiswa UNS Research Grant', 'Universitas Sebelas Maret', 'Solo', 'S2', 'Pendanaan pendidikan dan penelitian bagi mahasiswa pascasarjana.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-11-15', '2026-06-27 06:09:33', 23),
(35, 'Beasiswa Calon Guru Inspiratif', 'Universitas Negeri Yogyakarta', 'Yogyakarta', 'S1', 'Beasiswa untuk calon pendidik yang memiliki dedikasi tinggi terhadap dunia pendidikan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-04-30', '2026-06-27 06:09:33', 24),
(36, 'Beasiswa Pendidikan Inklusif', 'Universitas Negeri Yogyakarta', 'Yogyakarta', 'S1', 'Program bantuan biaya kuliah bagi mahasiswa yang fokus pada pendidikan inklusif.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-08-25', '2026-06-27 06:09:33', 24),
(37, 'Beasiswa Guru Masa Depan', 'Universitas Negeri Jakarta', 'Jakarta', 'S1', 'Program beasiswa bagi calon guru profesional dengan prestasi akademik tinggi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-06-20', '2026-06-27 06:09:33', 25),
(38, 'Beasiswa Pendidikan Digital', 'Universitas Negeri Jakarta', 'Jakarta', 'S2', 'Beasiswa bagi mahasiswa yang mengembangkan inovasi teknologi pembelajaran.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-09-18', '2026-06-27 06:09:33', 25),
(39, 'Beasiswa Vokasi Unggul', 'Politeknik Negeri Bandung', 'Bandung', 'D3', 'Program bantuan biaya pendidikan bagi mahasiswa vokasi dengan prestasi akademik.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-03-28', '2026-06-27 06:09:33', 26),
(40, 'Beasiswa Smart Manufacturing', 'Politeknik Negeri Bandung', 'Bandung', 'D4', 'Beasiswa untuk mahasiswa bidang manufaktur modern dan otomasi industri.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-10-08', '2026-06-27 06:09:33', 26),
(41, 'Beasiswa LPDP Nusantara', 'LPDP Indonesia', 'Jakarta', 'S2', 'Program pendanaan pendidikan magister penuh untuk putra-putri terbaik Indonesia.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-05-15', '2026-06-27 06:09:33', 27),
(42, 'Beasiswa LPDP Doktor Unggul', 'LPDP Indonesia', 'Jakarta', 'S3', 'Pendanaan penuh studi doktor bagi calon peneliti dan akademisi Indonesia.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-09-30', '2026-06-27 06:09:33', 27),
(43, 'Beasiswa UI Green Innovation', 'Universitas Indonesia', 'Depok', 'S2', 'Beasiswa penelitian inovasi lingkungan, energi terbarukan, dan pembangunan berkelanjutan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-12-10', '2026-06-27 06:11:35', 10),
(44, 'Beasiswa ITB Artificial Intelligence', 'Institut Teknologi Bandung', 'Bandung', 'S2', 'Program beasiswa bagi mahasiswa yang meneliti Artificial Intelligence dan Machine Learning.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-11-22', '2026-06-27 06:11:35', 11),
(45, 'Beasiswa UGM Future Agriculture', 'Universitas Gadjah Mada', 'Yogyakarta', 'S2', 'Pendanaan pendidikan bagi mahasiswa yang berkontribusi pada inovasi pertanian modern.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-10-15', '2026-06-27 06:11:35', 12),
(46, 'Beasiswa ITS Maritime Engineering', 'Institut Teknologi Sepuluh Nopember', 'Surabaya', 'S1', 'Beasiswa untuk mahasiswa teknik kelautan dan teknologi maritim Indonesia.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-09-18', '2026-06-27 06:11:35', 13),
(47, 'Beasiswa IPB Sustainable Food', 'IPB University', 'Bogor', 'S1', 'Program bantuan pendidikan untuk pengembangan pangan berkelanjutan.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-08-20', '2026-06-27 06:11:35', 14),
(48, 'Beasiswa UNAIR Medical Research', 'Universitas Airlangga', 'Surabaya', 'S2', 'Pendanaan riset kesehatan dan kedokteran bagi mahasiswa berprestasi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-07-15', '2026-06-27 06:11:35', 15),
(49, 'Beasiswa UNDIP Blue Economy', 'Universitas Diponegoro', 'Semarang', 'S2', 'Program beasiswa riset ekonomi kelautan dan pengelolaan pesisir.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-12-05', '2026-06-27 06:11:35', 16),
(50, 'Beasiswa UB Green Campus', 'Universitas Brawijaya', 'Malang', 'S1', 'Beasiswa bagi mahasiswa yang aktif dalam kegiatan lingkungan dan sustainability.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-06-28', '2026-06-27 06:11:35', 17),
(51, 'Beasiswa UNPAD Health Innovation', 'Universitas Padjadjaran', 'Bandung', 'S2', 'Pendanaan penelitian bidang kesehatan masyarakat dan inovasi medis.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-11-12', '2026-06-27 06:11:35', 18),
(52, 'Beasiswa Telkom AI Developer', 'Telkom University', 'Bandung', 'S1', 'Program beasiswa bagi calon software engineer dan AI developer.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-05-25', '2026-06-27 06:11:35', 19),
(53, 'Beasiswa BINUS Cyber Security', 'BINUS University', 'Jakarta', 'S1', 'Beasiswa untuk mahasiswa yang mendalami keamanan siber dan digital forensik.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-04-18', '2026-06-27 06:11:35', 20),
(54, 'Beasiswa Petra Creative Design', 'Universitas Kristen Petra', 'Surabaya', 'S1', 'Program bantuan biaya kuliah bagi mahasiswa desain komunikasi visual dan interior.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-03-30', '2026-06-27 06:11:35', 21),
(55, 'Beasiswa UIN Islamic Finance', 'UIN Syarif Hidayatullah', 'Jakarta', 'S1', 'Beasiswa untuk mahasiswa yang fokus pada ekonomi syariah dan keuangan Islam.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-10-08', '2026-06-27 06:11:35', 22),
(56, 'Beasiswa UNS Smart Agriculture', 'Universitas Sebelas Maret', 'Solo', 'S1', 'Program bantuan pendidikan bidang pertanian cerdas berbasis teknologi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-09-02', '2026-06-27 06:11:35', 23),
(57, 'Beasiswa UNY Educational Technology', 'Universitas Negeri Yogyakarta', 'Yogyakarta', 'S2', 'Pendanaan bagi mahasiswa yang mengembangkan media pembelajaran digital.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-08-12', '2026-06-27 06:11:35', 24),
(58, 'Beasiswa UNJ Education Leadership', 'Universitas Negeri Jakarta', 'Jakarta', 'S2', 'Beasiswa untuk calon pemimpin pendidikan masa depan Indonesia.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-07-08', '2026-06-27 06:11:35', 25),
(59, 'Beasiswa POLBAN Industrial Automation', 'Politeknik Negeri Bandung', 'Bandung', 'D4', 'Program beasiswa pada bidang otomasi industri dan robotika.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-11-01', '2026-06-27 06:11:35', 26),
(60, 'Beasiswa LPDP Emerging Leaders', 'LPDP Indonesia', 'Jakarta', 'S2', 'Pendanaan penuh bagi calon pemimpin muda Indonesia dengan prestasi akademik dan organisasi.', '/media/beasiswa-gambar/contoh-gambar-beasiswa-2.png', '2028-12-20', '2026-06-27 06:11:35', 27);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `city_id`, `name`) VALUES
(1, 9, 'SMA Negeri 1'),
(2, 9, 'SMA Negeri 2'),
(3, 9, 'SMK Negeri 1'),
(4, 9, 'SMP Negeri 1'),
(5, 9, 'SD Negeri 1'),
(6, 9, 'Lainnya'),
(7, 11, 'SMA Negeri 1'),
(8, 11, 'SMA Negeri 2'),
(9, 11, 'SMK Negeri 1'),
(10, 11, 'SMP Negeri 1'),
(11, 11, 'SD Negeri 1'),
(12, 11, 'Lainnya'),
(13, 13, 'SMA Negeri 1'),
(14, 13, 'SMA Negeri 2'),
(15, 13, 'SMK Negeri 1'),
(16, 13, 'SMP Negeri 1'),
(17, 13, 'SD Negeri 1'),
(18, 13, 'Lainnya'),
(19, 12, 'SMA Negeri 1'),
(20, 12, 'SMA Negeri 2'),
(21, 12, 'SMK Negeri 1'),
(22, 12, 'SMP Negeri 1'),
(23, 12, 'SD Negeri 1'),
(24, 12, 'Lainnya'),
(25, 10, 'SMA Negeri 1'),
(26, 10, 'SMA Negeri 2'),
(27, 10, 'SMK Negeri 1'),
(28, 10, 'SMP Negeri 1'),
(29, 10, 'SD Negeri 1'),
(30, 10, 'Lainnya'),
(31, 14, 'SMA Negeri 1'),
(32, 14, 'SMA Negeri 2'),
(33, 14, 'SMK Negeri 1'),
(34, 14, 'SMP Negeri 1'),
(35, 14, 'SD Negeri 1'),
(36, 14, 'Lainnya'),
(37, 15, 'SMA Negeri 1 Soreang'),
(38, 15, 'SMAN 1 Banjaran'),
(39, 15, 'SMKN 1 Katapang'),
(40, 15, 'SMP Negeri 1 Baleendah'),
(41, 15, 'SD Negeri Pamekaran'),
(42, 15, 'Lainnya'),
(43, 16, 'SMA Negeri 1 Lembang'),
(44, 16, 'SMAN 1 Padalarang'),
(45, 16, 'SMKN 1 Cililin'),
(46, 16, 'SMP Negeri 1 Ngamprah'),
(47, 16, 'SD Negeri Ciburuy'),
(48, 16, 'Lainnya'),
(49, 20, 'SMA Negeri 1 Cianjur'),
(50, 20, 'SMAN 1 Pacet'),
(51, 20, 'SMKN 1 Cianjur'),
(52, 20, 'SMP Negeri 1 Ciranjang'),
(53, 20, 'SD Negeri Muka'),
(54, 20, 'Lainnya'),
(55, 21, 'SMA Negeri 1 Sumber'),
(56, 21, 'SMAN 1 Arjawinangun'),
(57, 21, 'SMKN 1 Jamblang'),
(58, 21, 'SMP Negeri 1 Weru'),
(59, 21, 'SD Negeri Tuk'),
(60, 21, 'Lainnya'),
(61, 30, 'SMA Negeri 1 Cibadak'),
(62, 30, 'SMAN 1 Palabuhanratu'),
(63, 30, 'SMKN 1 Sukaraja'),
(64, 30, 'SMP Negeri 1 Cisaat'),
(65, 30, 'SD Negeri Cibolang'),
(66, 30, 'Lainnya'),
(67, 33, 'SMA Negeri 3 Bandung'),
(68, 33, 'SMA Negeri 5 Bandung'),
(69, 33, 'SMKN 2 Bandung'),
(70, 33, 'SMP Negeri 2 Bandung'),
(71, 33, 'SD Negeri Merdeka'),
(72, 33, 'Lainnya'),
(73, 37, 'SMA Negeri 1 Cimahi'),
(74, 37, 'SMA Negeri 2 Cimahi'),
(75, 37, 'SMKN 1 Cimahi'),
(76, 37, 'SMP Negeri 1 Cimahi'),
(77, 37, 'SD Negeri Cibabat'),
(78, 37, 'Lainnya'),
(79, 38, 'SMA Negeri 1 Cirebon'),
(80, 38, 'SMA Negeri 2 Cirebon'),
(81, 38, 'SMKN 1 Cirebon'),
(82, 38, 'SMP Negeri 1 Cirebon'),
(83, 38, 'SD Negeri Kebonbaru'),
(84, 38, 'Lainnya'),
(85, 77, 'SMA Negeri 1 Bantul'),
(86, 77, 'SMA Negeri 2 Bantul'),
(87, 77, 'SMP Negeri 1 Bantul'),
(88, 77, 'SMK Negeri 1 Bantul'),
(89, 77, 'SD Negeri Bantul 1'),
(90, 77, 'Lainnya'),
(91, 78, 'SMA Negeri 1 Wonosari'),
(92, 78, 'SMA Negeri 2 Wonosari'),
(93, 78, 'SMP Negeri 1 Wonosari'),
(94, 78, 'SMK Negeri 2 Wonosari'),
(95, 78, 'SD Negeri Kepek'),
(96, 78, 'Lainnya'),
(97, 79, 'SMA Negeri 1 Wates'),
(98, 79, 'SMA Negeri 2 Wates'),
(99, 79, 'SMP Negeri 1 Wates'),
(100, 79, 'SMK Negeri 1 Wates'),
(101, 79, 'SD Negeri Wates 2'),
(102, 79, 'Lainnya'),
(103, 80, 'SMA Negeri 1 Sleman'),
(104, 80, 'SMA Negeri 2 Sleman'),
(105, 80, 'SMP Negeri 1 Sleman'),
(106, 80, 'SMK Negeri 1 Depok Sleman'),
(107, 80, 'SD Negeri Caturtunggal 3'),
(108, 80, 'Lainnya'),
(109, 81, 'SMA Negeri 1 Yogyakarta'),
(110, 81, 'SMA Negeri 3 Yogyakarta'),
(111, 81, 'SMP Negeri 5 Yogyakarta'),
(112, 81, 'SMK Negeri 2 Yogyakarta'),
(113, 81, 'SD Negeri Ungaran 1'),
(114, 81, 'Lainnya'),
(115, 77, 'SMA Negeri 1 Bantul'),
(116, 77, 'SMA Negeri 2 Bantul'),
(117, 77, 'SMP Negeri 1 Bantul'),
(118, 77, 'SMK Negeri 1 Bantul'),
(119, 77, 'SD Negeri Bantul 1'),
(120, 77, 'Lainnya'),
(121, 78, 'SMA Negeri 1 Wonosari'),
(122, 78, 'SMA Negeri 2 Wonosari'),
(123, 78, 'SMP Negeri 1 Wonosari'),
(124, 78, 'SMK Negeri 2 Wonosari'),
(125, 78, 'SD Negeri Kepek'),
(126, 78, 'Lainnya'),
(127, 79, 'SMA Negeri 1 Wates'),
(128, 79, 'SMA Negeri 2 Wates'),
(129, 79, 'SMP Negeri 1 Wates'),
(130, 79, 'SMK Negeri 1 Wates'),
(131, 79, 'SD Negeri Wates 2'),
(132, 79, 'Lainnya'),
(133, 80, 'SMA Negeri 1 Sleman'),
(134, 80, 'SMA Negeri 2 Sleman'),
(135, 80, 'SMP Negeri 1 Sleman'),
(136, 80, 'SMK Negeri 1 Depok Sleman'),
(137, 80, 'SD Negeri Caturtunggal 3'),
(138, 80, 'Lainnya'),
(139, 81, 'SMA Negeri 1 Yogyakarta'),
(140, 81, 'SMA Negeri 3 Yogyakarta'),
(141, 81, 'SMP Negeri 5 Yogyakarta'),
(142, 81, 'SMK Negeri 2 Yogyakarta'),
(143, 81, 'SD Negeri Ungaran 1'),
(144, 81, 'Lainnya'),
(145, 83, 'SMA Negeri 1 Banyuwangi'),
(146, 83, 'SMA Negeri 2 Banyuwangi'),
(147, 83, 'SMK Negeri 1 Banyuwangi'),
(148, 83, 'SMP Negeri 1 Banyuwangi'),
(149, 83, 'SD Negeri Model Banyuwangi'),
(150, 83, 'Lainnya'),
(151, 36, 'SMA Negeri 1 Yogyakarta'),
(152, 36, 'SMA Negeri 3 Yogyakarta'),
(153, 36, 'SMK Negeri 2 Yogyakarta'),
(154, 36, 'SMP Negeri 5 Yogyakarta'),
(155, 36, 'SD Negeri Tegalrejo 1'),
(156, 36, 'Lainnya'),
(157, 37, 'SMA Negeri 1 Sleman'),
(158, 37, 'SMA Negeri 2 Sleman'),
(159, 37, 'SMK Negeri 1 Depok'),
(160, 37, 'SMP Negeri 4 Sleman'),
(161, 37, 'SD Negeri Condongcatur'),
(162, 37, 'Lainnya'),
(163, 38, 'SMA Negeri 1 Bantul'),
(164, 38, 'SMA Negeri 2 Bantul'),
(165, 38, 'SMK Negeri 1 Bantul'),
(166, 38, 'SMP Negeri 2 Bantul'),
(167, 38, 'SD Negeri Bantul 1'),
(168, 38, 'Lainnya'),
(169, 39, 'SMA Negeri 1 Wates'),
(170, 39, 'SMA Negeri 2 Wates'),
(171, 39, 'SMK Negeri 1 Pengasih'),
(172, 39, 'SMP Negeri 1 Wates'),
(173, 39, 'SD Negeri Wates'),
(174, 39, 'Lainnya'),
(175, 40, 'SMA Negeri 1 Wonosari'),
(176, 40, 'SMA Negeri 2 Playen'),
(177, 40, 'SMK Negeri 1 Wonosari'),
(178, 40, 'SMP Negeri 1 Wonosari'),
(179, 40, 'SD Negeri Wonosari'),
(180, 40, 'Lainnya'),
(181, 36, 'SMA Negeri 1 Yogyakarta'),
(182, 36, 'SMA Negeri 3 Yogyakarta'),
(183, 36, 'SMK Negeri 2 Yogyakarta'),
(184, 36, 'SMP Negeri 5 Yogyakarta'),
(185, 36, 'SD Negeri Tegalrejo 1'),
(186, 36, 'Lainnya'),
(187, 37, 'SMA Negeri 1 Sleman'),
(188, 37, 'SMA Negeri 2 Sleman'),
(189, 37, 'SMK Negeri 1 Depok'),
(190, 37, 'SMP Negeri 4 Sleman'),
(191, 37, 'SD Negeri Condongcatur'),
(192, 37, 'Lainnya'),
(193, 38, 'SMA Negeri 1 Bantul'),
(194, 38, 'SMA Negeri 2 Bantul'),
(195, 38, 'SMK Negeri 1 Bantul'),
(196, 38, 'SMP Negeri 2 Bantul'),
(197, 38, 'SD Negeri Bantul 1'),
(198, 38, 'Lainnya'),
(199, 39, 'SMA Negeri 1 Wates'),
(200, 39, 'SMA Negeri 2 Wates'),
(201, 39, 'SMK Negeri 1 Pengasih'),
(202, 39, 'SMP Negeri 1 Wates'),
(203, 39, 'SD Negeri Wates'),
(204, 39, 'Lainnya'),
(205, 40, 'SMA Negeri 1 Wonosari'),
(206, 40, 'SMA Negeri 2 Playen'),
(207, 40, 'SMK Negeri 1 Wonosari'),
(208, 40, 'SMP Negeri 1 Wonosari'),
(209, 40, 'SD Negeri Wonosari'),
(210, 40, 'Lainnya'),
(211, 36, 'SMA Negeri 1 Yogyakarta'),
(212, 36, 'SMA Negeri 3 Yogyakarta'),
(213, 36, 'SMK Negeri 2 Yogyakarta'),
(214, 36, 'SMP Negeri 5 Yogyakarta'),
(215, 36, 'SD Negeri Tegalrejo 1'),
(216, 36, 'Lainnya'),
(217, 37, 'SMA Negeri 1 Sleman'),
(218, 37, 'SMA Negeri 2 Sleman'),
(219, 37, 'SMK Negeri 1 Depok'),
(220, 37, 'SMP Negeri 4 Sleman'),
(221, 37, 'SD Negeri Condongcatur'),
(222, 37, 'Lainnya'),
(223, 38, 'SMA Negeri 1 Bantul'),
(224, 38, 'SMA Negeri 2 Bantul'),
(225, 38, 'SMK Negeri 1 Bantul'),
(226, 38, 'SMP Negeri 2 Bantul'),
(227, 38, 'SD Negeri Bantul 1'),
(228, 38, 'Lainnya'),
(229, 39, 'SMA Negeri 1 Wates'),
(230, 39, 'SMA Negeri 2 Wates'),
(231, 39, 'SMK Negeri 1 Pengasih'),
(232, 39, 'SMP Negeri 1 Wates'),
(233, 39, 'SD Negeri Wates'),
(234, 39, 'Lainnya'),
(235, 40, 'SMA Negeri 1 Wonosari'),
(236, 40, 'SMA Negeri 2 Playen'),
(237, 40, 'SMK Negeri 1 Wonosari'),
(238, 40, 'SMP Negeri 1 Wonosari'),
(239, 40, 'SD Negeri Wonosari'),
(240, 40, 'Lainnya'),
(241, 1, 'SMA Negeri 1'),
(242, 1, 'SMK Negeri 1'),
(243, 1, 'SMP Negeri 1'),
(244, 1, 'SD Negeri 1 Pandeglang'),
(245, 1, 'MAN 1 Pandeglang'),
(246, 1, 'Lainnya'),
(247, 2, 'SMA Negeri 1'),
(248, 2, 'SMK Negeri 1'),
(249, 2, 'SMP Negeri 1 Rangkasbitung'),
(250, 2, 'SD Negeri 1 Rangkasbitung'),
(251, 2, 'MAN 1 Lebak'),
(252, 2, 'Lainnya'),
(253, 4, 'SMA Negeri 1 Ciruas'),
(254, 4, 'SMK Negeri 1 Kragilan'),
(255, 4, 'SMP Negeri 1 Serang'),
(256, 4, 'SD Negeri 1 Serang'),
(257, 4, 'MAN 1 Serang'),
(258, 4, 'Lainnya'),
(259, 3, 'SMA Negeri 1 Tigaraksa'),
(260, 3, 'SMK Negeri 2 Kabupaten Tangerang'),
(261, 3, 'SMP Negeri 1 Tigaraksa'),
(262, 3, 'SD Negeri Tigaraksa 1'),
(263, 3, 'MAN 1 Kabupaten Tangerang'),
(264, 3, 'Lainnya'),
(265, 7, 'SMA Negeri 1 Kota Serang'),
(266, 7, 'SMA Negeri 2 Kota Serang'),
(267, 7, 'SMK Negeri 1 Kota Serang'),
(268, 7, 'SMP Negeri 1 Kota Serang'),
(269, 7, 'SD Negeri Serang 1'),
(270, 7, 'Lainnya'),
(271, 6, 'SMA Negeri 1 Cilegon'),
(272, 6, 'SMA Negeri 2 Cilegon'),
(273, 6, 'SMK Negeri 1 Cilegon'),
(274, 6, 'SMP Negeri 1 Cilegon'),
(275, 6, 'SD Negeri Cilegon 1'),
(276, 6, 'Lainnya'),
(277, 5, 'SMA Negeri 1 Tangerang'),
(278, 5, 'SMA Negeri 2 Tangerang'),
(279, 5, 'SMK Negeri 1 Tangerang'),
(280, 5, 'SMP Negeri 2 Tangerang'),
(281, 5, 'SD Negeri Tangerang 1'),
(282, 5, 'Lainnya'),
(283, 8, 'SMA Negeri 1 Tangerang Selatan'),
(284, 8, 'SMA Negeri 2 Tangerang Selatan'),
(285, 8, 'SMK Negeri 1 Tangerang Selatan'),
(286, 8, 'SMP Negeri 4 Tangerang Selatan'),
(287, 8, 'SD Negeri Ciputat 1'),
(288, 8, 'Lainnya'),
(289, 42, 'SMA Negeri 1 Banjarnegara'),
(290, 42, 'SMK Negeri 1 Banjarnegara'),
(291, 42, 'SMP Negeri 1 Banjarnegara'),
(292, 42, 'SD Negeri 1 Banjarnegara'),
(293, 42, 'Lainnya'),
(294, 43, 'SMA Negeri 1 Purwokerto'),
(295, 43, 'SMK Negeri 2 Purwokerto'),
(296, 43, 'SMP Negeri 1 Purwokerto'),
(297, 43, 'SD Negeri 1 Purwokerto'),
(298, 43, 'Lainnya'),
(299, 44, 'SMA Negeri 1 Batang'),
(300, 44, 'SMK Negeri 1 Batang'),
(301, 44, 'SMP Negeri 1 Batang'),
(302, 44, 'SD Negeri 1 Batang'),
(303, 44, 'Lainnya'),
(304, 45, 'SMA Negeri 1 Blora'),
(305, 45, 'SMK Negeri 1 Blora'),
(306, 45, 'SMP Negeri 1 Blora'),
(307, 45, 'SD Negeri 1 Blora'),
(308, 45, 'Lainnya'),
(309, 46, 'SMA Negeri 1 Boyolali'),
(310, 46, 'SMK Negeri 1 Boyolali'),
(311, 46, 'SMP Negeri 1 Boyolali'),
(312, 46, 'SD Negeri 1 Boyolali'),
(313, 46, 'Lainnya'),
(314, 47, 'SMA Negeri 1 Brebes'),
(315, 47, 'SMK Negeri 1 Brebes'),
(316, 47, 'SMP Negeri 1 Brebes'),
(317, 47, 'SD Negeri 1 Brebes'),
(318, 47, 'Lainnya'),
(319, 48, 'SMA Negeri 1 Cilacap'),
(320, 48, 'SMK Negeri 1 Cilacap'),
(321, 48, 'SMP Negeri 1 Cilacap'),
(322, 48, 'SD Negeri 1 Cilacap'),
(323, 48, 'Lainnya'),
(324, 49, 'SMA Negeri 1 Demak'),
(325, 49, 'SMK Negeri 1 Demak'),
(326, 49, 'SMP Negeri 1 Demak'),
(327, 49, 'SD Negeri 1 Demak'),
(328, 49, 'Lainnya'),
(329, 50, 'SMA Negeri 1 Purwodadi'),
(330, 50, 'SMK Negeri 1 Purwodadi'),
(331, 50, 'SMP Negeri 1 Purwodadi'),
(332, 50, 'SD Negeri 1 Purwodadi'),
(333, 50, 'Lainnya'),
(334, 51, 'SMA Negeri 1 Jepara'),
(335, 51, 'SMK Negeri 1 Jepara'),
(336, 51, 'SMP Negeri 1 Jepara'),
(337, 51, 'SD Negeri 1 Jepara'),
(338, 51, 'Lainnya'),
(339, 52, 'SMA Negeri 1 Karanganyar'),
(340, 52, 'SMK Negeri 1 Karanganyar'),
(341, 52, 'SMP Negeri 1 Karanganyar'),
(342, 52, 'SD Negeri 1 Karanganyar'),
(343, 52, 'Lainnya'),
(344, 53, 'SMA Negeri 1 Kebumen'),
(345, 53, 'SMK Negeri 1 Kebumen'),
(346, 53, 'SMP Negeri 1 Kebumen'),
(347, 53, 'SD Negeri 1 Kebumen'),
(348, 53, 'Lainnya'),
(349, 54, 'SMA Negeri 1 Kendal'),
(350, 54, 'SMK Negeri 1 Kendal'),
(351, 54, 'SMP Negeri 1 Kendal'),
(352, 54, 'SD Negeri 1 Kendal'),
(353, 54, 'Lainnya'),
(354, 55, 'SMA Negeri 1 Klaten'),
(355, 55, 'SMK Negeri 1 Klaten'),
(356, 55, 'SMP Negeri 1 Klaten'),
(357, 55, 'SD Negeri 1 Klaten'),
(358, 55, 'Lainnya'),
(359, 56, 'SMA Negeri 1 Kudus'),
(360, 56, 'SMK Negeri 1 Kudus'),
(361, 56, 'SMP Negeri 1 Kudus'),
(362, 56, 'SD Negeri 1 Kudus'),
(363, 56, 'Lainnya'),
(364, 57, 'SMA Negeri 1 Magelang'),
(365, 57, 'SMK Negeri 1 Magelang'),
(366, 57, 'SMP Negeri 1 Magelang'),
(367, 57, 'SD Negeri 1 Magelang'),
(368, 57, 'Lainnya'),
(369, 58, 'SMA Negeri 1 Pati'),
(370, 58, 'SMK Negeri 1 Pati'),
(371, 58, 'SMP Negeri 1 Pati'),
(372, 58, 'SD Negeri 1 Pati'),
(373, 58, 'Lainnya'),
(374, 59, 'SMA Negeri 1 Kajen'),
(375, 59, 'SMK Negeri 1 Kajen'),
(376, 59, 'SMP Negeri 1 Kajen'),
(377, 59, 'SD Negeri 1 Kajen'),
(378, 59, 'Lainnya'),
(379, 60, 'SMA Negeri 1 Pemalang'),
(380, 60, 'SMK Negeri 1 Pemalang'),
(381, 60, 'SMP Negeri 1 Pemalang'),
(382, 60, 'SD Negeri 1 Pemalang'),
(383, 60, 'Lainnya'),
(384, 74, 'SMA Negeri 1 Semarang'),
(385, 74, 'SMK Negeri 7 Semarang'),
(386, 74, 'SMP Negeri 2 Semarang'),
(387, 74, 'SD Negeri Karangayu 01'),
(388, 74, 'Lainnya'),
(389, 75, 'SMA Negeri 1 Surakarta'),
(390, 75, 'SMK Negeri 2 Surakarta'),
(391, 75, 'SMP Negeri 1 Surakarta'),
(392, 75, 'SD Negeri Mangkubumen'),
(393, 75, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('buyer','seller','pending_partner','partner','admin') NOT NULL,
  `school` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `jenjang` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `no_rekening` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `school`, `created_at`, `jenjang`, `phone`, `institution`, `website`, `full_name`, `city`, `address`, `nama_bank`, `no_rekening`) VALUES
(15, 'unair_partner', 'partner@unair.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111006', 'Universitas Airlangga', 'https://unair.ac.id', 'Admin UNAIR', NULL, 'Surabaya', NULL, NULL),
(16, 'undip_partner', 'partner@undip.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111007', 'Universitas Diponegoro', 'https://undip.ac.id', 'Admin UNDIP', NULL, 'Semarang', NULL, NULL),
(17, 'ub_partner', 'partner@ub.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111008', 'Universitas Brawijaya', 'https://ub.ac.id', 'Admin UB', NULL, 'Malang', NULL, NULL),
(14, 'ipb_partner', 'partner@ipb.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111005', 'IPB University', 'https://ipb.ac.id', 'Admin IPB', NULL, 'Bogor', NULL, NULL),
(13, 'its_partner', 'partner@its.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111004', 'Institut Teknologi Sepuluh Nopember', 'https://its.ac.id', 'Admin ITS', NULL, 'Surabaya', NULL, NULL),
(10, 'ui_partner', 'partner@ui.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111001', 'Universitas Indonesia', 'https://ui.ac.id', 'Admin UI', NULL, 'Depok', NULL, NULL),
(11, 'itb_partner', 'partner@itb.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111002', 'Institut Teknologi Bandung', 'https://itb.ac.id', 'Admin ITB', NULL, 'Bandung', NULL, NULL),
(12, 'ugm_partner', 'partner@ugm.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111003', 'Universitas Gadjah Mada', 'https://ugm.ac.id', 'Admin UGM', NULL, 'Yogyakarta', NULL, NULL),
(18, 'unpad_partner', 'partner@unpad.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111009', 'Universitas Padjadjaran', 'https://unpad.ac.id', 'Admin UNPAD', NULL, 'Bandung', NULL, NULL),
(19, 'telkom_partner', 'partner@telkomuniversity.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111010', 'Telkom University', 'https://telkomuniversity.ac.id', 'Admin Tel-U', NULL, 'Bandung', NULL, NULL),
(20, 'binus_partner', 'partner@binus.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111011', 'BINUS University', 'https://binus.ac.id', 'Admin BINUS', NULL, 'Jakarta', NULL, NULL),
(21, 'petra_partner', 'partner@petra.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111012', 'Universitas Kristen Petra', 'https://petra.ac.id', 'Admin Petra', NULL, 'Surabaya', NULL, NULL),
(22, 'uin_partner', 'partner@uinjkt.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111013', 'UIN Syarif Hidayatullah', 'https://uinjkt.ac.id', 'Admin UIN', NULL, 'Jakarta', NULL, NULL),
(23, 'uns_partner', 'partner@uns.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111014', 'Universitas Sebelas Maret', 'https://uns.ac.id', 'Admin UNS', NULL, 'Solo', NULL, NULL),
(24, 'uny_partner', 'partner@uny.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111015', 'Universitas Negeri Yogyakarta', 'https://uny.ac.id', 'Admin UNY', NULL, 'Yogyakarta', NULL, NULL),
(25, 'unj_partner', 'partner@unj.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111016', 'Universitas Negeri Jakarta', 'https://unj.ac.id', 'Admin UNJ', NULL, 'Jakarta', NULL, NULL),
(26, 'polban_partner', 'partner@polban.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111017', 'Politeknik Negeri Bandung', 'https://polban.ac.id', 'Admin POLBAN', NULL, 'Bandung', NULL, NULL),
(27, 'lpdp_partner', 'partner@lpdp.go.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'partner', NULL, '2026-06-26 19:13:17', NULL, '081111111018', 'LPDP Indonesia', 'https://lpdp.kemenkeu.go.id', 'Admin LPDP', NULL, 'Jakarta', NULL, NULL),
(29, 'qwertyuiop', 'qwertyuiop@gmail.com', '$2y$10$MldIRCrOps.SLl31xmObbO5jd7fYgtdFLIfPKKiQwae5TJ8Kkwf96', 'buyer', 'SMA Negeri 1 Cianjur', '2026-06-27 07:22:18', 'SMA', NULL, NULL, NULL, 'qwertyuiop', NULL, 'buyer / pelajar alamattttttttttttttttttttttttttttttttttttttt', NULL, NULL),
(31, 'seller_jakarta', 'seller1@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000001', NULL, NULL, 'Andi Pratama', NULL, 'Jakarta Selatan', 'BCA', '1234567801'),
(32, 'seller_bandung', 'seller2@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000002', NULL, NULL, 'Budi Santoso', NULL, 'Bandung', 'BRI', '1234567802'),
(33, 'seller_surabaya', 'seller3@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000003', NULL, NULL, 'Citra Lestari', NULL, 'Surabaya', 'Mandiri', '1234567803'),
(34, 'seller_yogya', 'seller4@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000004', NULL, NULL, 'Dewi Anggraini', NULL, 'Yogyakarta', 'BNI', '1234567804'),
(35, 'seller_semarang', 'seller5@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000005', NULL, NULL, 'Eko Saputra', NULL, 'Semarang', 'BCA', '1234567805'),
(36, 'seller_malang', 'seller6@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000006', NULL, NULL, 'Fajar Nugroho', NULL, 'Malang', 'BRI', '1234567806'),
(37, 'seller_bogor', 'seller7@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000007', NULL, NULL, 'Gilang Ramadhan', NULL, 'Bogor', 'Mandiri', '1234567807'),
(38, 'seller_depok', 'seller8@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000008', NULL, NULL, 'Hendra Wijaya', NULL, 'Depok', 'BNI', '1234567808'),
(39, 'seller_bekasi', 'seller9@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000009', NULL, NULL, 'Indra Gunawan', NULL, 'Bekasi', 'BCA', '1234567809'),
(40, 'seller_tangerang', 'seller10@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000010', NULL, NULL, 'Joko Hartono', NULL, 'Tangerang', 'BRI', '1234567810'),
(41, 'seller_medan', 'seller11@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000011', NULL, NULL, 'Kevin Saputra', NULL, 'Medan', 'Mandiri', '1234567811'),
(42, 'seller_makassar', 'seller12@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000012', NULL, NULL, 'Lukman Hakim', NULL, 'Makassar', 'BNI', '1234567812'),
(43, 'seller_denpasar', 'seller13@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000013', NULL, NULL, 'Maya Putri', NULL, 'Denpasar', 'BCA', '1234567813'),
(44, 'seller_palembang', 'seller14@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000014', NULL, NULL, 'Nanda Prakoso', NULL, 'Palembang', 'BRI', '1234567814'),
(45, 'seller_padang', 'seller15@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000015', NULL, NULL, 'Olivia Maharani', NULL, 'Padang', 'Mandiri', '1234567815'),
(46, 'seller_balikpapan', 'seller16@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000016', NULL, NULL, 'Putra Firmansyah', NULL, 'Balikpapan', 'BNI', '1234567816'),
(47, 'seller_pekanbaru', 'seller17@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000017', NULL, NULL, 'Qori Aulia', NULL, 'Pekanbaru', 'BCA', '1234567817'),
(48, 'seller_manado', 'seller18@bekaledu.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'seller', NULL, '2026-06-27 14:03:52', NULL, '081210000018', NULL, NULL, 'Rizky Maulana', NULL, 'Manado', 'BRI', '1234567818'),
(58, 'ssadddddddda', 'ss@gmail.com', '$2y$10$wzGxUgdwQ2y2pH1fN8u2UOzqZ.0QaS/uPEKcf2qAOWrExWZl4ix7W', 'pending_partner', NULL, '2026-07-08 14:23:33', NULL, '58585821501221', 'sss', 'https://pornhub.com', 'sss', NULL, 'dawdawwadawd', NULL, NULL),
(57, 'qads', 'aaaaa@gmail.com', '$2y$10$w.tEjhFdHxLe1H90.7b0J.STa936SBToh0uzMCyPV/d7DoONexEZu', 'buyer', 'SMK Negeri 1 Bantul', '2026-07-08 14:03:25', 'SD', NULL, NULL, NULL, 'aaa', NULL, 'aa', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `province_id` (`province_id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_conversation` (`user1_id`,`user2_id`),
  ADD KEY `idx_user1` (`user1_id`),
  ADD KEY `idx_user2` (`user2_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_conversation` (`conversation_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer_id` (`buyer_id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_rating` (`product_id`,`buyer_id`),
  ADD KEY `buyer_id` (`buyer_id`);

--
-- Indexes for table `product_wishlist`
--
ALTER TABLE `product_wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_wishlist` (`buyer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_wishlist`
--
ALTER TABLE `product_wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=394;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
