-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jan 2020 pada 20.24
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobil`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`) VALUES
(1, 'Admin Gans', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(2, 'oki', 'admin2', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cicilan`
--

CREATE TABLE `cicilan` (
  `id` int(11) NOT NULL,
  `no_kontrak` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `harga_sisa_cicilan` double NOT NULL,
  `total_bayar` double NOT NULL,
  `status_bayar` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cicilan`
--

INSERT INTO `cicilan` (`id`, `no_kontrak`, `tgl_bayar`, `harga_sisa_cicilan`, `total_bayar`, `status_bayar`) VALUES
(1, 201910191, '2019-11-30', 100050000, 4350000, 1),
(2, 201911042, '0000-00-00', 81200000, 3383333, 0),
(3, 201910191, '0000-00-00', 95700000, 4350000, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket`
--

CREATE TABLE `paket` (
  `id` int(11) NOT NULL,
  `kode_paket` varchar(30) NOT NULL,
  `nama_mobil` varchar(50) NOT NULL,
  `harga_mobil` double NOT NULL,
  `cicilan` varchar(10) NOT NULL,
  `bunga` double NOT NULL,
  `dp` double NOT NULL,
  `total_paket_kredit` double NOT NULL,
  `cicilan_perbulan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `paket`
--

INSERT INTO `paket` (`id`, `kode_paket`, `nama_mobil`, `harga_mobil`, `cicilan`, `bunga`, `dp`, `total_paket_kredit`, `cicilan_perbulan`) VALUES
(4, 'Pkt-4', 'Carera GT', 100000000, '24', 8, 30000000, 81200000, 3383333),
(5, 'Pkt-5', 'mobilio', 120000000, '24', 8, 30000000, 104400000, 4350000),
(6, 'Pkt-6', 'Alpard', 100000000, '48', 8, 20000000, 105600000, 2200000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `pembayaran_id` int(11) NOT NULL,
  `no_kontrak` int(11) NOT NULL,
  `nama_rekening` varchar(50) NOT NULL,
  `no_rekening` varchar(25) NOT NULL,
  `jumlah_bayar` double NOT NULL,
  `denda` int(11) NOT NULL,
  `foto_resi` text NOT NULL,
  `alasan` text NOT NULL,
  `tgl_bayar` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`pembayaran_id`, `no_kontrak`, `nama_rekening`, `no_rekening`, `jumlah_bayar`, `denda`, `foto_resi`, `alasan`, `tgl_bayar`, `status`) VALUES
(1, 201910191, 'BCA', '2301379864', 4350000, 31, '1.PNG', '', '2019-10-19 06:12:10', 1),
(2, 201910191, 'BCA', '2301379864', 4350000, 61, '1.PNG', '<p><strong>Kepada Yth. Anindita</strong><br />\r\n<br />\r\nPembayaran kredit mobil dengan nomer kontrak 201910191 di tolak . Dengan alasan Papih Ochi Ganteng. Harap Mengirim data yang valid berdasarkan jumlah tagihan anda . Demikian pemberitahuan yang kami sampaikan,Terima kasih atas kerja samanya.<br />\r\n<br />\r\nOki<br />\r\nManager Jogja Mobilindo Finance</p>\r\n', '2019-10-19 06:15:49', 2),
(3, 201910191, 'BNI', '9312011239', 2500000, 45, 'ma5.png', '', '2019-11-04 04:17:32', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `no_kontrak` varchar(20) NOT NULL,
  `no_ktp` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `paket_id` int(11) NOT NULL,
  `tgl_tempo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `no_kontrak`, `no_ktp`, `password`, `nama`, `alamat`, `email`, `paket_id`, `tgl_tempo`) VALUES
(1, '201910191', '1245678900000101', 'd780dc14b58b090f5feefd6501af15354e78dc2e', 'Anindita', 'Wahana', 'ditakirana27@gmail.com', 5, '2020-01-19');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `cicilan`
--
ALTER TABLE `cicilan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`pembayaran_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `cicilan`
--
ALTER TABLE `cicilan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `paket`
--
ALTER TABLE `paket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
