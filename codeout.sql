-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 Haz 2023, 21:26:55
-- Sunucu sürümü: 10.4.28-MariaDB
-- PHP Sürümü: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `codeout`
--
CREATE DATABASE IF NOT EXISTS `codeout` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `codeout`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `altkategori`
--

CREATE TABLE `altkategori` (
  `id` int(120) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `altkategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `altkategori`
--

INSERT INTO `altkategori` (`id`, `kategori`, `altkategori`) VALUES
(1, 'Yazılım Geliştirme', 'Web Geliştirme'),
(2, 'Yazılım Geliştirme', 'Veri-Bilimi'),
(3, 'Yazılım Geliştirme', 'Mobil Yazılım Geliştirme'),
(4, 'Yazılım Geliştirme', 'Programlama Dilleri'),
(5, 'Yazılım Geliştirme', 'Oyun Geliştirme'),
(6, 'Yazılım Geliştirme', 'Veri Tabanı Tasarlama ve Geliştirme'),
(7, 'Yazılım Geliştirme', 'Yazılım Testi'),
(8, 'Yazılım Geliştirme', 'Yazılım Mühendisliği'),
(9, 'Yazılım Geliştirme', 'Geliştirme Aracı'),
(10, 'Yazılım Geliştirme', 'Kodsuz Yazılım Geliştirrme'),
(11, 'İşletme', 'Girişimcilik'),
(12, 'İşletme', 'İletişim'),
(13, 'İşletme', 'Yönetim'),
(14, 'İşletme', 'Satış'),
(15, 'İşletme', 'İş Stratejisi'),
(16, 'İşletme', 'Operasyon'),
(17, 'İşletme', 'Proje Yönetimi'),
(18, 'İşletme', 'İş Hukuku'),
(19, 'İşletme', 'İş Analitiği ve Zekası'),
(20, 'İşletme', 'İnsan Kaynakları'),
(21, 'İşletme', 'E-Ticaret'),
(22, 'İşletme', 'Diğer İşletme'),
(23, 'BT & Yazılım', 'BT sertifikaları'),
(24, 'BT & Yazılım', 'Ağ ve Güvenlik'),
(25, 'BT & Yazılım', 'Donanım'),
(26, 'BT & Yazılım', 'İşletim Sistemleri'),
(27, 'BT & Yazılım', 'Diğer BT & Yazılım'),
(28, 'Tasarım', 'Web Tasarımı'),
(29, 'Tasarım', 'Diğer Grafik ve İllüstrasyon'),
(30, 'Tasarım', 'Tasarım Araçları'),
(31, 'Tasarım', 'Kullanıcı Deneyimi Tasarımı'),
(32, 'Tasarım', 'Oyun Tasarımı'),
(33, 'Tasarım', 'Tasarımcı Düşünce'),
(34, 'Tasarım', '3D ve Animasyon'),
(35, 'Tasarım', 'Moda Tasarımı'),
(36, 'Tasarım', 'Mimari Tasarım'),
(37, 'Tasarım', 'İç Tasarım'),
(38, 'Tasarım', 'Diğer Tasarım');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alınan`
--

CREATE TABLE `alınan` (
  `id` int(11) NOT NULL,
  `alan` varchar(255) NOT NULL,
  `ders` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `alınan`
--

INSERT INTO `alınan` (`id`, `alan`, `ders`) VALUES
(87, 'rauf', 82),
(88, 'raufokumus', 83),
(89, 'rauf', 83);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bildirim`
--

CREATE TABLE `bildirim` (
  `id` int(120) NOT NULL,
  `ders` varchar(50) NOT NULL,
  `gönderen` varchar(120) NOT NULL,
  `alıcı` varchar(120) NOT NULL,
  `baslik` varchar(120) NOT NULL,
  `mesaj` text NOT NULL,
  `okundu` int(11) NOT NULL DEFAULT 0,
  `zaman` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `bildirim`
--

INSERT INTO `bildirim` (`id`, `ders`, `gönderen`, `alıcı`, `baslik`, `mesaj`, `okundu`, `zaman`) VALUES
(52, 'deneme', 'raufokumus', 'raufo', 'Yeni', 'duyuru\r\n', 0, '2021-05-11 00:16:10'),
(58, 'bu ne', 'Yetkili', 'raufokumus', '1.mp4 raporunuz için bilgilendirme', 'raporunuz için gerekli işlem uygulanmıştır', 1, '2021-06-04 18:26:20'),
(59, 'deneme', 'Yetkili', 'raufokumus', 'Yeni', 'duyuru\r\n', 1, '2021-06-04 18:26:18'),
(60, 'Yetkili', 'Yetkili', 'asdasda', 'Kişiye özel bilgilendirme', 'deneme', 0, '2021-06-05 08:25:41'),
(61, 'Yetkili', 'Yetkili', 'asdasda', 'Kişiye özel bilgilendirme', 'deneme', 0, '2021-06-05 08:25:58'),
(64, 'Yetkili', 'Yetkili', 'raufokumus', 'Kişiye özel mesaj', 'bu bir denemedir.', 0, '2021-06-12 19:15:10'),
(67, 'Yetkili', 'Yetkili', 'rauf', 'bu ne için özel mesaj', 'deneme', 1, '2021-08-22 15:16:55');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders3`
--

CREATE TABLE `ders3` (
  `id` int(250) NOT NULL,
  `video_adi` varchar(100) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  `sira` int(255) NOT NULL,
  `kaynak` varchar(255) DEFAULT '',
  `durum` int(11) NOT NULL DEFAULT 1,
  `uyarı` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ders3`
--

INSERT INTO `ders3` (`id`, `video_adi`, `aciklama`, `sira`, `kaynak`, `durum`, `uyarı`) VALUES
(1, '1.mkv', 'ders 1', 1, '', 1, 0),
(2, 'video862.mkv', 'ders 2', 2, '', 1, 0),
(3, 'video9099.mp4', 'ders 2-degis', 3, '', 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders74`
--

CREATE TABLE `ders74` (
  `id` int(250) NOT NULL,
  `video_adi` varchar(100) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  `sira` int(255) NOT NULL,
  `kaynak` varchar(255) DEFAULT '',
  `durum` int(2) NOT NULL DEFAULT 1,
  `uyarı` int(255) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ders74`
--

INSERT INTO `ders74` (`id`, `video_adi`, `aciklama`, `sira`, `kaynak`, `durum`, `uyarı`) VALUES
(19, '1.mp4', 'ders 2', 1, '', 1, 0),
(21, 'video5775.mp4', 'alev', 2, '', 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders82`
--

CREATE TABLE `ders82` (
  `id` int(250) NOT NULL,
  `video_adi` varchar(100) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  `sira` int(255) NOT NULL,
  `kaynak` varchar(255) DEFAULT '',
  `durum` int(11) NOT NULL DEFAULT 1,
  `uyarı` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ders82`
--

INSERT INTO `ders82` (`id`, `video_adi`, `aciklama`, `sira`, `kaynak`, `durum`, `uyarı`) VALUES
(2, '1.mp4', 'iş hukuku hukuka giriş', 1, 'dosya5455.log', 1, 0),
(3, 'tanıtım.mp4', 'Tanıtım', 0, '', 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders83`
--

CREATE TABLE `ders83` (
  `id` int(250) NOT NULL,
  `video_adi` varchar(100) NOT NULL,
  `aciklama` varchar(100) NOT NULL,
  `sira` int(255) NOT NULL,
  `kaynak` varchar(255) DEFAULT '',
  `durum` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ders83`
--

INSERT INTO `ders83` (`id`, `video_adi`, `aciklama`, `sira`, `kaynak`, `durum`) VALUES
(1, 'tanıtım.mp4', 'Tanıtım', 0, '', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dersler`
--

CREATE TABLE `dersler` (
  `id` int(255) NOT NULL,
  `ders_adi` varchar(50) NOT NULL,
  `tip` int(11) NOT NULL DEFAULT 1,
  `sahibi` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `fiyat` int(250) NOT NULL DEFAULT 0,
  `kategori` int(12) NOT NULL,
  `kayıtlı` int(11) NOT NULL DEFAULT 0,
  `aciklama` text DEFAULT NULL,
  `durum` int(11) NOT NULL DEFAULT 1,
  `uyarı` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `dersler`
--

INSERT INTO `dersler` (`id`, `ders_adi`, `tip`, `sahibi`, `fiyat`, `kategori`, `kayıtlı`, `aciklama`, `durum`, `uyarı`) VALUES
(3, 'Html', 0, 'raufokumus', 0, 1, 0, NULL, 1, 0),
(74, 'deneme', 1, 'raufokumus', 0, 1, 0, 'Bu derste deneme videolarını ve siteye yeni gelen güncellemeleri göreceksiniz. Şimdiden zihin açıklığı dilerim.', 1, 0),
(82, 'bu ne', 1, 'rauf', 0, 18, 1, 'bu derste iş hukuku hakkında bilgi sahibi olacaksınız.', 1, 0),
(83, 'Örnek ücretli ders', 1, 'rauf', 75, 10, 3, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ders_soru`
--

CREATE TABLE `ders_soru` (
  `id` int(255) NOT NULL,
  `ders` varchar(50) NOT NULL,
  `gönderen` varchar(120) NOT NULL,
  `alıcı` varchar(120) DEFAULT NULL,
  `mesaj` mediumtext NOT NULL,
  `okundu` int(11) NOT NULL DEFAULT 0,
  `durum` int(11) NOT NULL DEFAULT 0,
  `cevap` int(255) DEFAULT NULL,
  `zaman` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ö_durum` int(11) NOT NULL DEFAULT 0,
  `ö_okundu` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `ders_soru`
--

INSERT INTO `ders_soru` (`id`, `ders`, `gönderen`, `alıcı`, `mesaj`, `okundu`, `durum`, `cevap`, `zaman`, `ö_durum`, `ö_okundu`) VALUES
(92, '', 'raufokumus', 'rauf', 'soru var', 1, 1, NULL, '2021-07-01 17:44:14', 1, 1),
(94, '', 'rauf', 'raufokumus', 'cevap', 0, 0, 92, '2021-06-13 19:56:01', 1, 1),
(95, '', 'rauf', 'raufokumus', 'de', 0, 0, 92, '2021-06-13 19:56:01', 1, 1),
(106, '82', 'raufokumus', 'rauf', 'Soru 1', 1, 1, NULL, '2021-07-01 17:44:07', 1, 1),
(107, '82', 'rauf', 'raufokumus', 'cevap 1', 0, 1, 106, '2021-07-01 17:44:07', 1, 1),
(108, '83', 'rauf', 'rauf', 'Soru 1\r\n', 0, 1, NULL, '2021-08-22 15:13:54', 1, 1),
(109, '83', 'rauf', 'rauf', 'soru 1\r\n', 1, 1, NULL, '2021-08-22 15:14:01', 1, 1),
(110, '83', 'rauf', 'rauf', 'cevap 1', 0, 1, 109, '2021-08-22 15:14:02', 1, 1),
(111, '', 'rauf', 'rauf', 'neden', 1, 1, NULL, '2021-08-22 15:14:03', 1, 1),
(112, '', 'rauf', 'rauf', 'ders işte', 0, 1, 111, '2021-08-22 15:14:03', 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `h_bildirim`
--

CREATE TABLE `h_bildirim` (
  `id` int(250) NOT NULL,
  `alıcı` varchar(100) NOT NULL,
  `gonderen` varchar(100) NOT NULL,
  `ders` varchar(100) NOT NULL,
  `mesaj` mediumtext NOT NULL,
  `okundu` varchar(5) NOT NULL DEFAULT '0',
  `zaman` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `h_bildirim`
--

INSERT INTO `h_bildirim` (`id`, `alıcı`, `gonderen`, `ders`, `mesaj`, `okundu`, `zaman`) VALUES
(36, 'rauf', 'ADMİN', 'bu ne', 'deneme\r\n', '0', '2021-06-04 17:59:48'),
(37, 'rauf', 'ADMİN', 'bu ne', 'deneme', '0', '2021-06-04 18:02:11'),
(38, 'raufokumus', 'Yetkili', '82', 'hallettik', '0', '2021-06-04 18:18:54'),
(39, 'rauf', 'rauf', 'bu ne', 'bu ne dersine kayıt oldu', '0', '2021-06-12 18:04:40'),
(40, 'rauf', 'rauf', 'bu ne', 'bu ne dersine kayıt oldu', '0', '2021-06-12 18:47:41'),
(41, 'raufokumus', 'rauf', 'deneme', 'deneme dersine kayıt oldu', '0', '2021-06-12 18:49:44'),
(42, 'rauf', 'raufokumus', 'bu ne', 'bu ne dersine kayıt oldu', '0', '2021-06-13 19:42:32'),
(43, 'raufokumus', 'raufokumus', 'deneme', 'deneme dersine kayıt oldu', '0', '2021-06-13 19:53:11'),
(44, 'raufokumus', 'rauf', 'Html', 'Html dersine kayıt oldu', '0', '2021-06-17 16:59:44'),
(45, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:23:13'),
(46, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:33:25'),
(47, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:35:31'),
(48, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:36:10'),
(49, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:37:15'),
(50, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:39:27'),
(51, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:40:07'),
(52, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-06-17 17:40:24'),
(53, 'rauf', 'rauf', 'bu ne', 'bu ne dersine kayıt oldu', '0', '2021-07-01 17:07:47'),
(54, 'rauf', 'raufokumus', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-07-04 18:23:10'),
(55, 'rauf', 'rauf', 'Örnek ücretli ders', 'Örnek ücretli ders dersine kayıt oldu', '0', '2021-07-06 13:32:52');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `izlenen`
--

CREATE TABLE `izlenen` (
  `id` int(250) NOT NULL,
  `kullanıcı` varchar(50) DEFAULT NULL,
  `ders` int(11) DEFAULT NULL,
  `video` varchar(50) DEFAULT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `izlenen`
--

INSERT INTO `izlenen` (`id`, `kullanıcı`, `ders`, `video`, `durum`) VALUES
(31, 'rauf', 82, '1.mp4', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `odeme`
--

CREATE TABLE `odeme` (
  `id` int(11) NOT NULL,
  `kulad` varchar(100) NOT NULL,
  `ders` int(255) NOT NULL,
  `fiyat` int(255) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `odeme`
--

INSERT INTO `odeme` (`id`, `kulad`, `ders`, `fiyat`, `tarih`) VALUES
(2, 'rauf', 83, 75, '2021-06-17 17:40:24'),
(3, 'raufokumus', 83, 1500, '2021-06-17 18:25:11'),
(5, 'raufokumus', 83, 75, '2021-07-04 18:23:10'),
(6, 'rauf', 83, 75, '2021-07-06 13:32:52');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rapor`
--

CREATE TABLE `rapor` (
  `id` int(11) NOT NULL,
  `ders` int(11) NOT NULL,
  `video` varchar(50) NOT NULL,
  `raporlayan` varchar(120) NOT NULL,
  `rapor` text NOT NULL,
  `görüldü` int(11) NOT NULL DEFAULT 0,
  `zaman` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `admin` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rapor`
--

INSERT INTO `rapor` (`id`, `ders`, `video`, `raporlayan`, `rapor`, `görüldü`, `zaman`, `admin`) VALUES
(5, 74, '1.mp4', 'rauf', 'bu ne', 0, '2021-08-22 15:19:25', 'rauf'),
(6, 74, 'video5775.mp4', 'rauf', 'bence bu dersin burada bulunmamsaı gerekiyor dersin 00:03:15. dk\'sında söylenenlerin böyle bir siteye yakışmedığını düşünüyorum.', 0, '2021-05-26 13:01:48', ''),
(7, 82, '1.mp4', 'raufokumus', 'rapor denemesi bakalım hangi isim ile çıkacak', 0, '2021-06-05 09:31:08', 'rauf'),
(8, 82, '1.mp4', 'raufokumus', 'soru ?', 0, '2021-06-05 09:31:07', 'rauf');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uye`
--

CREATE TABLE `uye` (
  `id` int(11) NOT NULL,
  `tamad` varchar(50) DEFAULT NULL,
  `kulad` varchar(60) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `sifre` varchar(50) NOT NULL,
  `seviye` varchar(11) NOT NULL,
  `resim` mediumtext NOT NULL DEFAULT 'resim/uye.jpg',
  `hakkında` text DEFAULT NULL,
  `linkedin` varchar(200) DEFAULT NULL,
  `github` varchar(200) DEFAULT NULL,
  `durum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `uye`
--

INSERT INTO `uye` (`id`, `tamad`, `kulad`, `mail`, `sifre`, `seviye`, `resim`, `hakkında`, `linkedin`, `github`, `durum`) VALUES
(0, 'Rauf Okumuş', 'raufokumus', 'raufokumus@gmail.com', '6694a99f15fc901d6d7bc0b6e7ddce93', 'Eğitmen', 'resim/raufokumus.jpg', 'Websitesinin kodlayıcısı ve sahibidir', 'https://linkedin.com/in/raufokumus/', 'https://github.com/raufokumus', 0),
(5, 'Rauf Okumus', 'rauf', 'raufokums46@gmail.com', '6694a99f15fc901d6d7bc0b6e7ddce93', 'Yonetici', 'resim/rauf.jpg', 'deneme', ' ', NULL, 0),
(7, NULL, 'deneme', 'deneme@deneme.com', '6694a99f15fc901d6d7bc0b6e7ddce93', 'Eğitmen', 'resim/uye.jpg', NULL, NULL, NULL, 0),
(10, 'Ek Kullanıcı', 'raufo', 'mail@mail.com', '6694a99f15fc901d6d7bc0b6e7ddce93', 'Öğrenci', 'resim/uye.jpg', NULL, NULL, NULL, 0),
(12, NULL, 'asdasda', 'mail@deneme.com', '66b4efe46ee2e61e9075af60a6284291', 'Eğitmen', 'resim/uye.jpg', NULL, NULL, NULL, 0),
(13, NULL, '', 'admin', '', '', 'resim/uye.jpg', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` bigint(255) NOT NULL,
  `ders` bigint(255) NOT NULL,
  `yorum_yapan` varchar(250) NOT NULL,
  `yorum` text NOT NULL DEFAULT '',
  `puan` float NOT NULL DEFAULT 0,
  `begeni` int(11) NOT NULL DEFAULT 0,
  `dislike` int(11) NOT NULL DEFAULT 0,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `ders`, `yorum_yapan`, `yorum`, `puan`, `begeni`, `dislike`, `tarih`) VALUES
(6, 82, 'rauf', 'Güzel bir ders devamını başarılar dilerim', 4, 1, 1, '2021-06-13 19:55:04'),
(7, 82, 'rauf', 'sadasd', 5, 1, 1, '2021-06-13 19:55:16');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `y_begeni`
--

CREATE TABLE `y_begeni` (
  `id` int(11) NOT NULL,
  `y_id` int(11) NOT NULL,
  `kulad` varchar(50) NOT NULL DEFAULT '',
  `durum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `y_begeni`
--

INSERT INTO `y_begeni` (`id`, `y_id`, `kulad`, `durum`) VALUES
(21, 6, 'rauf', 1),
(22, 7, 'rauf', 1),
(23, 6, 'raufokumus', 1),
(24, 7, 'raufokumus', 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `altkategori`
--
ALTER TABLE `altkategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `alınan`
--
ALTER TABLE `alınan`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `bildirim`
--
ALTER TABLE `bildirim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ders3`
--
ALTER TABLE `ders3`
  ADD PRIMARY KEY (`id`,`sira`) USING BTREE;

--
-- Tablo için indeksler `ders74`
--
ALTER TABLE `ders74`
  ADD PRIMARY KEY (`id`,`sira`) USING BTREE;

--
-- Tablo için indeksler `ders82`
--
ALTER TABLE `ders82`
  ADD PRIMARY KEY (`id`,`sira`) USING BTREE;

--
-- Tablo için indeksler `ders83`
--
ALTER TABLE `ders83`
  ADD PRIMARY KEY (`id`,`sira`) USING BTREE;

--
-- Tablo için indeksler `dersler`
--
ALTER TABLE `dersler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ders_soru`
--
ALTER TABLE `ders_soru`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `h_bildirim`
--
ALTER TABLE `h_bildirim`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `izlenen`
--
ALTER TABLE `izlenen`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `odeme`
--
ALTER TABLE `odeme`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `rapor`
--
ALTER TABLE `rapor`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uye`
--
ALTER TABLE `uye`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `y_begeni`
--
ALTER TABLE `y_begeni`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `altkategori`
--
ALTER TABLE `altkategori`
  MODIFY `id` int(120) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Tablo için AUTO_INCREMENT değeri `alınan`
--
ALTER TABLE `alınan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Tablo için AUTO_INCREMENT değeri `bildirim`
--
ALTER TABLE `bildirim`
  MODIFY `id` int(120) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Tablo için AUTO_INCREMENT değeri `ders3`
--
ALTER TABLE `ders3`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `ders74`
--
ALTER TABLE `ders74`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Tablo için AUTO_INCREMENT değeri `ders82`
--
ALTER TABLE `ders82`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `ders83`
--
ALTER TABLE `ders83`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `dersler`
--
ALTER TABLE `dersler`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- Tablo için AUTO_INCREMENT değeri `ders_soru`
--
ALTER TABLE `ders_soru`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- Tablo için AUTO_INCREMENT değeri `h_bildirim`
--
ALTER TABLE `h_bildirim`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Tablo için AUTO_INCREMENT değeri `izlenen`
--
ALTER TABLE `izlenen`
  MODIFY `id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Tablo için AUTO_INCREMENT değeri `odeme`
--
ALTER TABLE `odeme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `rapor`
--
ALTER TABLE `rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `uye`
--
ALTER TABLE `uye`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `y_begeni`
--
ALTER TABLE `y_begeni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
