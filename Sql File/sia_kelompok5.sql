-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Des 2019 pada 16.06
-- Versi server: 10.4.10-MariaDB
-- Versi PHP: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sia`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `kode` varchar(7) NOT NULL,
  `warna` varchar(20) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`kode`, `warna`, `harga`, `stok`) VALUES
('11003', 'Biru', 25000, 150),
('11004', 'Pink', 48000, 240);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal`
--

CREATE TABLE `jurnal` (
  `id` int(11) NOT NULL,
  `no_bukti` varchar(15) NOT NULL,
  `ref` varchar(5) NOT NULL,
  `debet` int(11) NOT NULL,
  `kredit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurnal`
--

INSERT INTO `jurnal` (`id`, `no_bukti`, `ref`, `debet`, `kredit`) VALUES
(1, '1', '11001', 50000000, 0),
(2, '1', '30001', 0, 50000000),
(3, '2', '12001', 10000000, 0),
(4, '2', '11001', 0, 10000000),
(5, '3', '11002', 7000000, 0),
(6, '3', '11001', 0, 7000000),
(7, '4', '11003', 3750000, 0),
(8, '4', '11004', 11520000, 0),
(9, '4', '11001', 0, 5270000),
(10, '4', '21001', 0, 10000000),
(11, '5', '40001', 0, 2500000),
(12, '5', '11001', 2500000, 0),
(13, '6', '11001', 6000000, 0),
(14, '6', '11006', 4200000, 0),
(15, '6', '40001', 0, 10200000),
(16, '7', '50001', 1000000, 0),
(17, '7', '11001', 0, 1000000),
(18, '8', '22001', 0, 80000000),
(19, '8', '11001', 80000000, 0),
(20, '9', '12001', 25000000, 0),
(21, '9', '11007', 10000000, 0),
(22, '9', '11001', 0, 35000000),
(23, '10', '40001', 0, 3500000),
(24, '10', '11001', 3500000, 0),
(25, '11', '21001', 7250000, 0),
(26, '11', '11001', 0, 7250000),
(27, '12', '11001', 4200000, 0),
(28, '12', '11006', 0, 4200000),
(29, '13', '50003', 15000000, 0),
(30, '13', '11001', 0, 15000000),
(31, '14', '60001', 800000, 0),
(32, '14', '11001', 0, 800000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_jurnal`
--

CREATE TABLE `master_jurnal` (
  `no_bukti` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_jurnal`
--

INSERT INTO `master_jurnal` (`no_bukti`, `tanggal`, `keterangan`) VALUES
('1', '2005-05-01', 'Setoran Awal'),
('10', '2005-05-19', 'Menyelesaikan Pemesanan'),
('11', '2005-05-20', 'Membayar Hutang ke Perusahaan Amanah'),
('12', '2005-05-22', 'Dibayar Tagihan Pesanan Seragam Sekolah'),
('13', '2005-05-29', 'Membayar Gaji Karyawan'),
('14', '2005-05-30', 'Prive'),
('2', '2005-05-02', 'Membeli Peralatan (Mesin Jahit)'),
('3', '2005-05-04', 'Membayar Sewa Toko untuk 1th kedepan'),
('4', '2005-05-05', 'Membeli Persediaan Dasar Kain'),
('5', '2005-05-06', 'Menyelesaikan Pemesanan Baju'),
('6', '2005-05-07', 'Menyelesaikan Pesanan Seragam Sekolah'),
('7', '2005-05-12', 'Bayar Listrik, Air, Telepon'),
('8', '2005-05-14', 'Utang Bank'),
('9', '2005-05-15', 'Membeli Kebutuhan Operasional');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perkiraan`
--

CREATE TABLE `perkiraan` (
  `kode` varchar(5) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `saldo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `perkiraan`
--

INSERT INTO `perkiraan` (`kode`, `nama`, `saldo`) VALUES
('11001', 'Kas', 0),
('11002', 'Sewa bayar dimuka', 0),
('11003', 'Kain Katun', 150),
('11004', 'Kain Borkat', 240),
('11005', 'Piutang', 0),
('11006', 'Piutang bu. Hani', 0),
('11007', 'Perlengkapan', 0),
('12001', 'Peralatan', 0),
('21001', 'Utang ke prsh. Amanah Textile', 0),
('22001', 'Hutang Bank', 0),
('30001', 'Modal', 0),
('40001', 'Pendapatan', 0),
('50001', 'Biaya LAT', 0),
('50002', 'Biaya Bunga', 0),
('50003', 'Biaya Gaji', 0),
('60001', 'Prive', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `posting`
--

CREATE TABLE `posting` (
  `id` varchar(11) NOT NULL,
  `waktu` date NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `posting`
--

INSERT INTO `posting` (`id`, `waktu`, `create_at`) VALUES
('1576807995', '2005-05-01', '2019-12-20 02:13:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `posting_detail`
--

CREATE TABLE `posting_detail` (
  `n` int(11) NOT NULL,
  `id` varchar(11) NOT NULL,
  `kode_p` varchar(255) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `posting_detail`
--

INSERT INTO `posting_detail` (`n`, `id`, `kode_p`, `saldo`) VALUES
(1, '1576807995', '11001', 18880000),
(2, '1576807995', '11002', 7000000),
(3, '1576807995', '11003', 3750000),
(4, '1576807995', '11004', 11520000),
(5, '1576807995', '11005', 0),
(6, '1576807995', '11006', 0),
(7, '1576807995', '11007', 20000000),
(8, '1576807995', '12001', 70000000),
(9, '1576807995', '21001', 2750000),
(10, '1576807995', '22001', 80000000),
(11, '1576807995', '30001', 50000000),
(12, '1576807995', '40001', 16200000),
(13, '1576807995', '50001', 2000000),
(14, '1576807995', '50002', 0),
(15, '1576807995', '50003', 15000000),
(16, '1576807995', '60001', 800000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `master_jurnal`
--
ALTER TABLE `master_jurnal`
  ADD PRIMARY KEY (`no_bukti`);

--
-- Indeks untuk tabel `perkiraan`
--
ALTER TABLE `perkiraan`
  ADD PRIMARY KEY (`kode`);

--
-- Indeks untuk tabel `posting`
--
ALTER TABLE `posting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `posting_detail`
--
ALTER TABLE `posting_detail`
  ADD PRIMARY KEY (`n`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jurnal`
--
ALTER TABLE `jurnal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `posting_detail`
--
ALTER TABLE `posting_detail`
  MODIFY `n` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
