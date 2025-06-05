-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jun 2025 pada 10.45
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pecinta_allam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `donasi`
--

CREATE TABLE `donasi` (
  `id_donasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nominal` decimal(10,2) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `donasi`
--

INSERT INTO `donasi` (`id_donasi`, `id_user`, `nama`, `email`, `nominal`, `bukti_transfer`, `tanggal`) VALUES
(3, 1, 'FirmanDN', 'firmandn8@gmail.com', 99999999.99, NULL, '2025-01-21 07:34:56'),
(4, 2, 'tahutek', 'firmandn8@gmail.com', 10000.00, NULL, '2025-01-30 06:38:52'),
(5, 1, 'FirmanDN', 'firmandn8@gmail.com', 100000.00, NULL, '2025-02-06 06:26:19'),
(10, 3, 'Afgan Gahzy', 'firmandn8@gmail.com', 99999999.99, NULL, '2025-04-21 07:29:26'),
(11, 1, 'FirmanDN', 'firman@gmail.com', 10000.00, NULL, '2025-04-28 09:38:03'),
(12, 1, 'FirmanDN', 'firmandn@gmail', 100000.00, NULL, '2025-05-16 17:00:00'),
(13, 1, 'FirmanDN', 'firman@gmail.com', 100000.00, NULL, '2025-05-10 04:23:21'),
(14, 1, 'FirmanDN', 'firman@gmail.com', 100003.00, NULL, '2025-05-10 04:28:22'),
(15, 1, 'FirmanDN', 'firman@gmail.com', 100003.00, NULL, '2025-05-10 04:28:54'),
(17, 1, 'FirmanDN', 'firman@gmail.com', 100000.00, NULL, '2025-05-14 17:00:00'),
(19, 1, 'FirmanDN', 'firman@gmail.com', 100000.00, NULL, '2025-05-19 00:34:29'),
(21, 13, 'hikmal', 'hikmal@gmail.com', 100000.00, NULL, '2025-05-20 00:12:48'),
(22, 13, 'hikmal', 'hikmal@gmail.com', 100000.00, NULL, '2025-05-20 03:27:13'),
(24, 13, 'hikmal', 'hikmal@gmail.com', 100000.00, 'bukti_682bf8d85131b.jpg', '2025-05-20 03:36:56'),
(25, 1, 'FirmanDN1', 'firman@gmail.com', 99999999.99, 'bukti_6840f1e08b5e3.png', '2025-06-05 01:24:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gerakan`
--

CREATE TABLE `gerakan` (
  `id_gerakan` int(11) NOT NULL,
  `judul_gerakan` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `id_kolaborator` int(11) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gerakan`
--

INSERT INTO `gerakan` (`id_gerakan`, `judul_gerakan`, `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `id_kolaborator`, `lokasi`) VALUES
(1, 'Gerakan Hijau', 'Menanam pohon di kota', '2025-03-01', '2025-03-16', NULL, NULL),
(2, 'Gerakan Bersih', 'Membersihkan pantai dari sampah', NULL, NULL, NULL, NULL),
(3, 'qpppp', 'qwx', NULL, NULL, NULL, NULL),
(4, 'cakto', 'tahu', '2025-05-15', '2025-05-31', NULL, 'tahu'),
(5, 'cakto00', 'tahu', '2025-05-15', '2025-05-31', NULL, 'Indonesia'),
(9, 'cakto', 'ppp', '2025-05-23', '2025-05-31', NULL, 'ct');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kolaborator`
--

CREATE TABLE `kolaborator` (
  `id_kolaborator` int(11) NOT NULL,
  `nama_kolaborator` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `no_telepon` varchar(100) DEFAULT NULL,
  `id_gerakan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` enum('pengguna','kolaborator','admin') NOT NULL,
  `id_gerakan` int(11) DEFAULT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `status_akun` enum('aktif','nonaktif','suspend') DEFAULT 'aktif',
  `tanggal_bergabung` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_user`, `nama`, `email`, `password`, `peran`, `id_gerakan`, `no_telepon`, `status_akun`, `tanggal_bergabung`) VALUES
(1, 'FirmanDN1', 'firman@gmail.com', '$2y$10$pgob2O/Wi4phdcBOTYhwguG7/8GNwi3.EPUOP999NQK3R/ISOFN72', 'kolaborator', NULL, '087826579333333', 'aktif', '2025-02-10 04:18:46'),
(2, 'tahutek', 'firmandn8@gmail.com', '$2y$10$Hv4DBI9l0zTt.eE8c1cws.sQ/79yfsQknS60uuht.8Naqdx5s9rFC', 'admin', NULL, '085643966568', 'aktif', '2025-02-10 04:18:46'),
(3, 'Afgan Gahzy', 'Afgan@gmail.com', '$2y$10$iIjbp.Vus/pyuA9OUhmo5eHElaTVwA.xJzawL/xcyrCxcUhARlX/.', 'pengguna', NULL, '085643986789', 'aktif', '2025-02-10 04:18:46'),
(4, 'anjay1', 'anjay@gmail.com', '$2y$10$pOO1qG6kY7ukIz17Qx2X1.nhowJbsxnKENb1.CiexZVlKcw8u9KFK', 'pengguna', NULL, '088102675regreg', 'aktif', '2025-02-11 07:14:31'),
(12, 'info', 'info@gmail.com', '$2y$10$7j4QwBOlFMPuG3hmem2O9.8fAxdy.DpP0NLjuqFwdhXkKIVuuzBhO', 'pengguna', NULL, '088888888888', 'aktif', '2025-03-06 00:48:54'),
(13, 'hikmal', 'hikmal@gmail.com', '$2y$10$GZriciUzrtoLgyMukDOf2.MsDdKqQu720C.HDoj7DSpsnTiHjRwaq', 'pengguna', NULL, '099878754543456', 'aktif', '2025-03-17 05:57:02'),
(14, 'Firman1', 'firmadn98@gmail.com', '$2y$10$JXd2LUU5JNs6jD4jbwBSx.8jeN2TunpzdQGBy5F9EP4fc2YXk9p6m', 'kolaborator', NULL, '1233388', 'aktif', '2025-05-06 00:30:34'),
(21, 'hikmawal', 'hikmalwal@gmail.com', '$2y$10$hHegjCJmgTAjOwqXSPBhI.xZAa2RmqAvy2jS2wPrdCdcyRKTJc8yK', 'admin', NULL, '089786756453423', 'aktif', '2025-05-19 07:17:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna_gerakan`
--

CREATE TABLE `pengguna_gerakan` (
  `id_user` int(11) NOT NULL,
  `id_gerakan` int(11) NOT NULL,
  `tanggal_ikut` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna_gerakan`
--

INSERT INTO `pengguna_gerakan` (`id_user`, `id_gerakan`, `tanggal_ikut`) VALUES
(1, 1, NULL),
(1, 2, NULL),
(1, 3, NULL),
(1, 5, '2025-05-23 03:43:45'),
(2, 1, NULL),
(2, 2, NULL),
(2, 3, NULL),
(3, 2, NULL),
(3, 3, NULL),
(4, 1, NULL),
(4, 2, NULL),
(4, 3, NULL),
(13, 2, '2025-05-20 00:25:14'),
(13, 3, '2025-05-20 00:36:14'),
(13, 4, '2025-05-20 03:26:55'),
(13, 5, '2025-05-23 03:45:20'),
(13, 9, '2025-05-23 03:45:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perpustakaan`
--

CREATE TABLE `perpustakaan` (
  `id_perpustakaan` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perpustakaan`
--

INSERT INTO `perpustakaan` (`id_perpustakaan`, `judul`, `penulis`, `kategori`, `tahun_terbit`, `deskripsi`, `id_user`) VALUES
(23, 'Kepunahan Spesies', '-', 'Konservasi', '2023', 'Kepunahan Spesies adalah hilangnya spesies dari ekosistem.', 1),
(24, 'Pemanasan Global', '-', 'Perubahan Iklim', '2022', 'Dampak pemanasan global terhadap ekosistem alam.', 1),
(25, 'Pengelolaan Sampah', '-', 'Lingkungan', '2021', 'Cara-cara mengelola sampah untuk mengurangi pencemaran.', 1),
(26, 'Deforestasi Hutan', '-', 'Konservasi', '2020', 'Dampak negatif dari penebangan hutan secara liar terhadap lingkungan.', 1),
(27, 'Pencemaran Air', '-', 'Lingkungan', '2019', 'Sumber-sumber pencemaran air dan cara mengatasinya.', 1),
(28, 'Energi Terbarukan', '-', 'Perubahan Iklim', '2021', 'Penggunaan energi terbarukan sebagai solusi mengurangi emisi karbon.', 1),
(29, 'Keanekaragaman Hayati', '-', 'Konservasi', '2023', 'Pentingnya menjaga keanekaragaman hayati untuk kelestarian lingkungan.', 1),
(30, 'Efek Rumah Kaca', '-', 'Perubahan Iklim', '2022', 'Bagaimana efek rumah kaca memengaruhi suhu global.', 1),
(31, 'Reboisasi', '-', 'Konservasi', '2020', 'Upaya penghijauan kembali hutan yang telah ditebang.', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD PRIMARY KEY (`id_donasi`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `gerakan`
--
ALTER TABLE `gerakan`
  ADD PRIMARY KEY (`id_gerakan`),
  ADD KEY `fk_gerakan_kolaborator` (`id_kolaborator`);

--
-- Indeks untuk tabel `kolaborator`
--
ALTER TABLE `kolaborator`
  ADD PRIMARY KEY (`id_kolaborator`),
  ADD KEY `id_gerakan` (`id_gerakan`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_gerakan` (`id_gerakan`);

--
-- Indeks untuk tabel `pengguna_gerakan`
--
ALTER TABLE `pengguna_gerakan`
  ADD PRIMARY KEY (`id_user`,`id_gerakan`),
  ADD KEY `id_gerakan` (`id_gerakan`);

--
-- Indeks untuk tabel `perpustakaan`
--
ALTER TABLE `perpustakaan`
  ADD PRIMARY KEY (`id_perpustakaan`),
  ADD KEY `fk_user` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `donasi`
--
ALTER TABLE `donasi`
  MODIFY `id_donasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `gerakan`
--
ALTER TABLE `gerakan`
  MODIFY `id_gerakan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kolaborator`
--
ALTER TABLE `kolaborator`
  MODIFY `id_kolaborator` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `perpustakaan`
--
ALTER TABLE `perpustakaan`
  MODIFY `id_perpustakaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `donasi`
--
ALTER TABLE `donasi`
  ADD CONSTRAINT `donasi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `pengguna` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `gerakan`
--
ALTER TABLE `gerakan`
  ADD CONSTRAINT `fk_gerakan_kolaborator` FOREIGN KEY (`id_kolaborator`) REFERENCES `kolaborator` (`id_kolaborator`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kolaborator`
--
ALTER TABLE `kolaborator`
  ADD CONSTRAINT `kolaborator_ibfk_1` FOREIGN KEY (`id_gerakan`) REFERENCES `gerakan` (`id_gerakan`);

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `pengguna_ibfk_1` FOREIGN KEY (`id_gerakan`) REFERENCES `gerakan` (`id_gerakan`);

--
-- Ketidakleluasaan untuk tabel `pengguna_gerakan`
--
ALTER TABLE `pengguna_gerakan`
  ADD CONSTRAINT `pengguna_gerakan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `pengguna` (`id_user`),
  ADD CONSTRAINT `pengguna_gerakan_ibfk_2` FOREIGN KEY (`id_gerakan`) REFERENCES `gerakan` (`id_gerakan`);

--
-- Ketidakleluasaan untuk tabel `perpustakaan`
--
ALTER TABLE `perpustakaan`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `pengguna` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
