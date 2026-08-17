-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th8 11, 2026 lúc 04:20 AM
-- Phiên bản máy phục vụ: 5.7.31
-- Phiên bản PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_hososo`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `album_hinh_anh`
--

DROP TABLE IF EXISTS `album_hinh_anh`;
CREATE TABLE IF NOT EXISTS `album_hinh_anh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) NOT NULL,
  `url_hinh_anh` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thu_tu` int(11) NOT NULL DEFAULT '0',
  `mo_ta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_album_hinh_thu_tu` (`id_album`,`thu_tu`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `album_hinh_anh`
--

INSERT INTO `album_hinh_anh` (`id`, `id_album`, `url_hinh_anh`, `thu_tu`, `mo_ta`, `ngay_tao`) VALUES
(1, 1, 'uploads/album/8496092f-31e2-4a08-baca-c3b9f72ee1b2.jpg', 0, NULL, '2026-06-20 01:54:54'),
(2, 1, 'uploads/album/d1799b99-329d-4814-8e6c-01866751abc1.png', 1, NULL, '2026-06-20 01:54:54'),
(8, 3, 'uploads/album/b524a654-4fde-4c55-903e-03e47a52a761.jpg', 0, NULL, '2026-06-20 02:24:02'),
(9, 3, 'uploads/album/ddd2894a-c87b-476c-a556-4355b3fddb57.png', 1, NULL, '2026-06-20 02:24:02'),
(10, 4, 'uploads/album/9d95aefd-9091-4b26-8d46-1620307f8484.jpg', 0, NULL, '2026-06-21 01:42:42'),
(11, 4, 'uploads/album/01cc3b68-34cc-406f-94fd-78d61b677971.png', 1, NULL, '2026-06-21 01:42:42'),
(12, 5, 'uploads/album/1f71d3d6-9648-4d0a-a4b8-86273b9eb7f8.jpg', 0, NULL, '2026-06-21 01:54:33'),
(13, 5, 'uploads/album/5e4b15ed-0ef6-4529-89d8-60c3af4fc7c7.png', 1, NULL, '2026-06-21 01:54:33'),
(14, 6, 'uploads/album/d81537cd-986e-4d05-ad27-59f39ab5d1af.jpg', 0, NULL, '2026-06-21 01:59:32'),
(15, 6, 'uploads/album/9b107268-3ee3-440d-b891-d942096e1a72.png', 1, NULL, '2026-06-21 01:59:32'),
(16, 7, 'uploads/album/29abb7ea-2885-4493-858f-b5a8b519d070.jpg', 0, NULL, '2026-06-23 00:17:00'),
(17, 7, 'uploads/album/1727058d-e1b1-4eb8-bd21-c295cf2234c5.png', 1, NULL, '2026-06-23 00:17:00'),
(18, 8, 'uploads/album/e17103a4-d810-496e-a35e-a963de757dcd.jpg', 0, NULL, '2026-06-23 00:18:17'),
(19, 8, 'uploads/album/04925bdf-356c-4f82-9586-a7c0f9ec15bb.png', 1, NULL, '2026-06-23 00:18:17'),
(20, 9, 'uploads/album/0a9c60f5-9cd7-441c-97b2-403f3e0320d5.jpg', 0, NULL, '2026-06-23 00:25:19'),
(21, 9, 'uploads/album/a9a8f434-4b7a-420e-af00-ab6dc6bd5db4.png', 1, NULL, '2026-06-23 00:25:19'),
(22, 10, 'uploads/album/828f7321-3852-4e84-8be6-efe08fdbbad1.jpg', 0, NULL, '2026-06-24 06:31:26'),
(23, 10, 'uploads/album/28b6262b-0a52-4597-948f-5f73eb6b41a5.png', 1, NULL, '2026-06-24 06:31:26'),
(24, 11, 'uploads/album/871b76d1-9f15-4502-8b0d-a74ce834339f.jpg', 0, NULL, '2026-06-24 06:36:46'),
(25, 11, 'uploads/album/2af362b2-2b05-481a-8bfd-96ff9dc8ed40.png', 1, NULL, '2026-06-24 06:36:46'),
(26, 12, 'uploads/album/51a40082-fb08-44cd-9e3e-f6b3203a62cb.jpg', 0, NULL, '2026-06-24 06:41:23'),
(27, 12, 'uploads/album/48825428-856a-493f-82e1-f25b1b83de03.png', 1, NULL, '2026-06-24 06:41:23'),
(28, 13, 'uploads/album/9a002e21-0d6f-45f8-bebb-ad8a52b58c71.jpg', 0, NULL, '2026-06-24 06:42:34'),
(29, 13, 'uploads/album/89da749e-5be5-4b85-bfc7-4a63474ef54b.png', 1, NULL, '2026-06-24 06:42:34'),
(30, 14, 'uploads/album/a2bfecac-59d7-4b6c-a166-8fd98c5ffbdf.jpg', 0, NULL, '2026-06-24 06:48:52'),
(31, 14, 'uploads/album/c074caa8-0ee0-489a-bc02-f31834aace97.png', 1, NULL, '2026-06-24 06:48:52'),
(32, 15, 'uploads/album/b3d9d15a-0faa-4e83-9db9-c92e4bfc4dc2.jpg', 0, NULL, '2026-06-25 20:38:20'),
(33, 15, 'uploads/album/4f202052-e0bf-479a-bc90-e7e04df7573d.png', 1, NULL, '2026-06-25 20:38:20'),
(34, 2, 'uploads/album/c79679a7-9401-4402-86c7-f8f78ce7b6dc.jpg', 0, NULL, '2026-07-07 21:12:11'),
(35, 2, 'uploads/album/62ed9422-2226-44a1-85ac-9276c3fbf1a9.jpg', 1, NULL, '2026-07-07 21:12:11'),
(36, 2, 'uploads/album/391f1bb6-d627-43ae-bd0c-8b7b32400c37.png', 2, NULL, '2026-07-07 21:12:11'),
(37, 16, 'uploads/album/1cc1630b-0365-4192-bf6b-4b61ca8296f0.jpg', 0, NULL, '2026-07-07 21:50:44'),
(38, 16, 'uploads/album/f6a09bc4-e764-44a7-a458-9ca98fe44918.png', 1, NULL, '2026-07-07 21:50:44'),
(39, 17, 'uploads/album/5b71803f-ba6e-40f5-a7b6-ced8fc774ca1.jpg', 0, NULL, '2026-07-07 21:59:25'),
(40, 17, 'uploads/album/6336ebbf-ff69-4d06-9c6e-6855e5c56b5e.png', 1, NULL, '2026-07-07 21:59:25'),
(41, 18, 'uploads/album/43947720-1557-4f29-868c-13c92103c5c4.jpg', 0, NULL, '2026-07-07 22:01:09'),
(42, 18, 'uploads/album/f44bd701-d21e-4ef8-8cdc-eaeda64386bc.png', 1, NULL, '2026-07-07 22:01:09'),
(43, 19, 'uploads/album/d3c0f47d-2081-4123-b217-3e1f8274ee0a.jpg', 0, NULL, '2026-07-07 22:03:14'),
(44, 19, 'uploads/album/42d94b21-d68b-4900-a736-3b275b32a414.png', 1, NULL, '2026-07-07 22:03:14'),
(45, 20, 'uploads/album/67fab073-df15-4a9c-9920-90a715301377.jpg', 0, NULL, '2026-07-07 22:05:45'),
(46, 20, 'uploads/album/9294931a-30e5-4910-bf9a-4040e665701c.png', 1, NULL, '2026-07-07 22:05:45'),
(47, 21, 'uploads/album/086af5d7-93ba-43e7-aef0-4ec1e4511560.jpg', 0, NULL, '2026-07-07 22:07:37'),
(48, 21, 'uploads/album/87cdbab8-a71d-416d-a033-5fefb2f8cc0e.png', 1, NULL, '2026-07-07 22:07:37'),
(49, 22, 'uploads/album/1f9c297e-d7a0-4971-94c1-a8f78dc18d6c.jpg', 0, NULL, '2026-07-07 22:12:44'),
(50, 22, 'uploads/album/d3764535-53a0-4221-a0b1-025b489f26ce.png', 1, NULL, '2026-07-07 22:12:44'),
(51, 23, 'uploads/album/de085024-99a3-4234-8d33-5a85746f438a.jpg', 0, NULL, '2026-07-07 22:14:20'),
(52, 23, 'uploads/album/8a77bfbd-cc98-4700-8ade-bf7195a0f54f.png', 1, NULL, '2026-07-07 22:14:20'),
(53, 24, 'uploads/album/a3fb7b41-b865-49b4-8694-4c609419f2d2.jpg', 0, NULL, '2026-07-07 22:17:25'),
(54, 24, 'uploads/album/933a846b-81b3-4786-bbb1-8c5ce6ff281c.png', 1, NULL, '2026-07-07 22:17:25'),
(55, 25, 'uploads/album/a871fa7b-f32a-42f2-b028-aee6efdad457.jpg', 0, NULL, '2026-07-07 22:19:44'),
(56, 25, 'uploads/album/cdd2d851-a228-4599-9b51-de9879907ac5.png', 1, NULL, '2026-07-07 22:19:44'),
(57, 26, 'uploads/album/55f108b2-3134-4c27-9721-15089d280384.jpg', 0, NULL, '2026-07-07 22:21:06'),
(58, 27, 'uploads/album/97034b6b-f572-43df-9ee6-eb959fe01717.jpg', 0, NULL, '2026-07-07 22:24:58'),
(59, 27, 'uploads/album/e50de50f-9b52-4338-a74f-ee6423c431b5.png', 1, NULL, '2026-07-07 22:24:58'),
(60, 28, 'uploads/album/d4754788-7518-4e73-ac0a-63e86f6dc5ad.jpg', 0, NULL, '2026-07-07 22:25:39'),
(61, 28, 'uploads/album/0b862ed6-014b-41eb-b6e2-ebaca0eb69c3.png', 1, NULL, '2026-07-07 22:25:39'),
(62, 29, 'uploads/album/355cf1c1-af8e-40ca-bd49-172690a92ca7.jpg', 0, NULL, '2026-07-07 22:31:25'),
(63, 29, 'uploads/album/6abcc717-e510-47ad-89bb-4e021a93ba94.png', 1, NULL, '2026-07-07 22:31:25'),
(64, 30, 'uploads/album/774d59b9-2aae-47c1-b572-79a7119b5df6.jpg', 0, NULL, '2026-07-07 22:33:31'),
(65, 30, 'uploads/album/41081a26-a537-417b-beb5-9dcfcb79db96.png', 1, NULL, '2026-07-07 22:33:31'),
(66, 31, 'uploads/album/f8246975-3f5f-4c5a-95f3-13c61b53f4b0.jpg', 0, NULL, '2026-07-07 22:34:52'),
(67, 31, 'uploads/album/8a6b8194-ce0b-480b-a1da-b980cc5c1b34.png', 1, NULL, '2026-07-07 22:34:52'),
(68, 32, 'uploads/album/a3aa00af-5977-4451-a309-e79f355297fe.jpg', 0, NULL, '2026-07-07 22:36:53'),
(69, 32, 'uploads/album/e4dd4547-6dbb-4730-add0-f48e015f2ff8.png', 1, NULL, '2026-07-07 22:36:53'),
(70, 33, 'uploads/album/75362f80-d14a-4191-9cad-1b602881d834.jpg', 0, NULL, '2026-07-07 22:38:07'),
(71, 33, 'uploads/album/5b0e84ec-5bc9-4833-a284-e689f1cc9170.png', 1, NULL, '2026-07-07 22:38:07'),
(72, 34, 'uploads/album/5fdfc82f-b3c0-4720-b103-8e668190b122.jpg', 0, NULL, '2026-07-07 22:40:46'),
(73, 34, 'uploads/album/82d45f41-a2ce-417d-b8b6-7cf100d3b5b8.png', 1, NULL, '2026-07-07 22:40:46'),
(74, 35, 'uploads/album/0bd59487-c575-4cb8-a9c3-6c665fcc8bae.jpg', 0, NULL, '2026-07-07 22:43:48'),
(75, 35, 'uploads/album/febe4e47-5329-45e5-8d77-f6f7bc8c34ac.png', 1, NULL, '2026-07-07 22:43:48'),
(76, 36, 'uploads/album/29295a52-95d8-4164-86c8-ed56cf27623c.jpg', 0, NULL, '2026-07-07 22:44:48'),
(77, 36, 'uploads/album/ce3a76c3-abd0-42f2-93f3-8aa8d7025ffc.png', 1, NULL, '2026-07-07 22:44:48'),
(78, 37, 'uploads/album/9940f1b6-12e6-47a8-a763-a092b539d07a.jpg', 0, NULL, '2026-07-07 22:46:07'),
(79, 37, 'uploads/album/57d55ff9-355b-4294-b1fb-63f6e03c2294.png', 1, NULL, '2026-07-07 22:46:07'),
(80, 38, 'uploads/album/bb70d120-9e37-4562-b16b-109db58b1b97.jpg', 0, NULL, '2026-07-10 03:12:47'),
(81, 38, 'uploads/album/96fa0a54-a782-4853-8d2b-5990859f26de.png', 1, NULL, '2026-07-10 03:12:47'),
(82, 39, 'uploads/album/724cc48d-3707-4f0a-a91a-4d1f0e6f3d73.jpg', 0, NULL, '2026-07-10 03:13:21'),
(83, 39, 'uploads/album/c7441c08-fe00-4673-9fc4-908ac935aed4.png', 1, NULL, '2026-07-10 03:13:21'),
(84, 40, 'uploads/album/b39cfd4d-9da0-4e39-b3a2-0bd5bc7f0f79.jpg', 0, NULL, '2026-07-14 20:55:48'),
(85, 40, 'uploads/album/847246bf-fe78-4253-97e7-2fb79bfce21e.png', 1, NULL, '2026-07-14 20:55:48'),
(86, 41, 'uploads/album/6dc89233-2c72-4288-8150-4cc434be6cda.jpg', 0, NULL, '2026-07-14 21:02:58'),
(87, 41, 'uploads/album/f23bf12e-ab40-431e-86e8-7dc1ca6add66.png', 1, NULL, '2026-07-14 21:02:58'),
(90, 42, 'uploads/album/76e2b073-b891-4355-a91f-133619b470cb.png', 0, NULL, '2026-08-03 22:59:07'),
(91, 42, 'uploads/album/dce4b0f0-a6ff-4a18-9103-2c0c6667602b.jpg', 1, NULL, '2026-08-03 23:00:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `album_su_kien`
--

DROP TABLE IF EXISTS `album_su_kien`;
CREATE TABLE IF NOT EXISTS `album_su_kien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` int(11) NOT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `ngay_dien_ra` date DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_nguoi_dung` (`id_nguoi_dung`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `album_su_kien`
--

INSERT INTO `album_su_kien` (`id`, `id_nguoi_dung`, `tieu_de`, `mo_ta`, `ngay_dien_ra`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-20 01:54:54', '2026-06-20 01:54:54'),
(2, 2, 'đi leo nút', 'đi leo núi ở Everest', '2026-06-20', '2026-06-20 01:59:00', '2026-07-07 21:12:11'),
(3, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-20 02:24:02', '2026-06-20 02:24:02'),
(4, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-21 01:42:39', '2026-06-21 01:42:39'),
(5, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-21 01:54:33', '2026-06-21 01:54:33'),
(6, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-21 01:59:31', '2026-06-21 01:59:31'),
(7, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-23 00:16:58', '2026-06-23 00:16:58'),
(8, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-23 00:18:17', '2026-06-23 00:18:17'),
(9, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-23 00:25:19', '2026-06-23 00:25:19'),
(10, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-24 06:31:24', '2026-06-24 06:31:24'),
(11, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-24 06:36:43', '2026-06-24 06:36:43'),
(12, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-24 06:41:23', '2026-06-24 06:41:23'),
(13, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-24 06:42:34', '2026-06-24 06:42:34'),
(14, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-24 06:48:52', '2026-06-24 06:48:52'),
(15, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-06-25 20:38:20', '2026-06-25 20:38:20'),
(16, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 21:50:44', '2026-07-07 21:50:44'),
(17, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 21:59:25', '2026-07-07 21:59:25'),
(18, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:01:09', '2026-07-07 22:01:09'),
(19, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:03:14', '2026-07-07 22:03:14'),
(20, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:05:45', '2026-07-07 22:05:45'),
(21, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:07:37', '2026-07-07 22:07:37'),
(22, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:12:44', '2026-07-07 22:12:44'),
(23, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:14:20', '2026-07-07 22:14:20'),
(24, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:17:25', '2026-07-07 22:17:25'),
(25, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:19:44', '2026-07-07 22:19:44'),
(26, 3, 'đi ăn gà rán', 'ở texas', '2026-07-07', '2026-07-07 22:21:06', '2026-07-07 22:21:06'),
(27, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:24:58', '2026-07-07 22:24:58'),
(28, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:25:39', '2026-07-07 22:25:39'),
(29, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:31:25', '2026-07-07 22:31:25'),
(30, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:33:31', '2026-07-07 22:33:31'),
(31, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:34:52', '2026-07-07 22:34:52'),
(32, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:36:53', '2026-07-07 22:36:53'),
(33, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:38:07', '2026-07-07 22:38:07'),
(34, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:40:46', '2026-07-07 22:40:46'),
(35, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:43:48', '2026-07-07 22:43:48'),
(36, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:44:48', '2026-07-07 22:44:48'),
(37, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-07 22:46:07', '2026-07-07 22:46:07'),
(38, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-10 03:12:47', '2026-07-10 03:12:47'),
(39, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-10 03:13:20', '2026-07-10 03:13:20'),
(40, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-14 20:55:46', '2026-07-14 20:55:46'),
(41, 1, 'Bảo vệ đồ án tốt nghiệp', 'Một ngày tuyệt vời với bạn bè và gia đình.', '2026-06-15', '2026-07-14 21:02:58', '2026-07-14 21:02:58'),
(42, 5, 'Kỷ niệm bảo vệ luận văn tốt nghiệp 2024', 'Hình ảnh kỷ niệm tham gia cuộc thi Hackathon và lễ bảo vệ đồ án tốt nghiệp.', '2024-11-20', '2026-08-03 22:47:27', '2026-08-03 23:00:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chung_chi`
--

DROP TABLE IF EXISTS `chung_chi`;
CREATE TABLE IF NOT EXISTS `chung_chi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noi_bat` tinyint(4) NOT NULL DEFAULT '0',
  `id_nguoi_dung` int(11) NOT NULL,
  `ten_chung_chi` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_chuc_cap` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_cap` date DEFAULT NULL,
  `ngay_het_han` date DEFAULT NULL,
  `ma_chung_chi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_tap_tin` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_pdf` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phan_loai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_nguoi_dung` (`id_nguoi_dung`)
) ENGINE=InnoDB AUTO_INCREMENT=203 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chung_chi`
--

INSERT INTO `chung_chi` (`id`, `noi_bat`, `id_nguoi_dung`, `ten_chung_chi`, `to_chuc_cap`, `ngay_cap`, `ngay_het_han`, `ma_chung_chi`, `url_tap_tin`, `file_pdf`, `phan_loai`) VALUES
(1, 1, 2, 'Laravel Certified Developer', 'Laravel.com', '2025-01-20', NULL, 'LC-990-123X', NULL, 'uploads/chung-chi/1782549457_6a3f8bd197aec.pdf', 'chuyen_mon'),
(2, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(3, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(4, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(6, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(7, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(8, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(10, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(11, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(12, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(14, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(15, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(16, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(18, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(19, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(20, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(22, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(23, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(24, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(26, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(27, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(28, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(30, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(31, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(32, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(33, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782199458_6a3a34a223d0c.pdf', 'chuyen_mon'),
(34, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(35, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(36, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(37, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782199520_6a3a34e000d58.pdf', 'chuyen_mon'),
(39, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(40, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(41, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(42, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782307887_6a3bdc2f61965.pdf', 'chuyen_mon'),
(44, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(45, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(46, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(47, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782308207_6a3bdd6f5a5a6.pdf', 'chuyen_mon'),
(49, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(50, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(51, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(52, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782308483_6a3bde83b0757.pdf', 'chuyen_mon'),
(54, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(55, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(56, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(57, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782308555_6a3bdecb33081.pdf', 'chuyen_mon'),
(59, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(60, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(61, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(62, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782308932_6a3be044d5639.pdf', 'chuyen_mon'),
(64, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(65, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(66, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(67, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1782445100_6a3df42cdbdbf.pdf', 'chuyen_mon'),
(68, 0, 3, 'IELTS Academic Certificate', 'IDP Education', '2023-05-20', '2025-05-20', '23VN004561H', NULL, NULL, 'ngoai_ngu'),
(69, 1, 3, 'AWS Certified Solutions Architect – Associate', 'Amazon Web Services', '2024-08-15', '2027-08-15', 'AWS-ASA-998822', NULL, 'uploads/chung-chi/1783486708_6a4dd8f4bffa5.pdf', 'chuyen_mon'),
(70, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(71, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(72, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(73, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783486245_6a4dd725661b0.pdf', 'chuyen_mon'),
(75, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(76, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(77, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(78, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783486765_6a4dd92d61123.pdf', 'chuyen_mon'),
(80, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(81, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(82, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(83, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783486869_6a4dd995a6478.pdf', 'chuyen_mon'),
(85, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(86, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(87, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(88, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783486995_6a4dda130c558.pdf', 'chuyen_mon'),
(90, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(91, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(92, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(93, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783487145_6a4ddaa9f351c.pdf', 'chuyen_mon'),
(95, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(96, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(97, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(98, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783487257_6a4ddb19c95af.pdf', 'chuyen_mon'),
(100, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(101, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(102, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(103, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783487565_6a4ddc4d1d205.pdf', 'chuyen_mon'),
(105, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(106, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(107, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(108, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783487661_6a4ddcad33fec.pdf', 'chuyen_mon'),
(110, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(111, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(112, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(113, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783487846_6a4ddd6668da5.pdf', 'chuyen_mon'),
(115, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(116, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(117, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(118, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783487984_6a4dddf0cf2a7.pdf', 'chuyen_mon'),
(120, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(121, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(122, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(123, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783488299_6a4ddf2b2ec2f.pdf', 'chuyen_mon'),
(125, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(126, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(127, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(128, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783488339_6a4ddf53d176c.pdf', 'chuyen_mon'),
(130, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(131, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(132, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(133, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783488686_6a4de0ae5a80a.pdf', 'chuyen_mon'),
(135, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(136, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(137, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(138, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783488812_6a4de12c4c391.pdf', 'chuyen_mon'),
(140, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(141, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(142, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(143, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783488892_6a4de17cd566d.pdf', 'chuyen_mon'),
(145, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(146, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(147, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(148, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783489013_6a4de1f5bb002.pdf', 'chuyen_mon'),
(150, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(151, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(152, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(153, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783489088_6a4de24052788.pdf', 'chuyen_mon'),
(155, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(156, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(157, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(158, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783489246_6a4de2de9ed25.pdf', 'chuyen_mon'),
(160, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(161, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(162, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(163, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783489429_6a4de395150a1.pdf', 'chuyen_mon'),
(165, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(166, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(167, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(168, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783489488_6a4de3d074e89.pdf', 'chuyen_mon'),
(170, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(171, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(172, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(173, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783489568_6a4de4202fd5e.pdf', 'chuyen_mon'),
(175, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(176, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(177, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(178, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783678368_6a50c5a003eb8.pdf', 'chuyen_mon'),
(180, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(181, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(182, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(183, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1783678401_6a50c5c183cbc.pdf', 'chuyen_mon'),
(185, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(186, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(187, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(188, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1784087748_6a5704c4d552d.pdf', 'chuyen_mon'),
(190, 0, 1, 'AWS Certified Practitioner @#$ *()', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(191, 0, 1, 'AWS Solutions Architect', 'Amazon Web Services & Partners *()', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(192, 0, 1, 'alert(\"xss\")Certificate XSS', 'Amazon Web Services', '2023-01-01', NULL, NULL, NULL, NULL, 'chuyen_mon'),
(193, 0, 1, 'AWS Advanced Security', 'AWS Enterprise', '2023-01-01', NULL, NULL, NULL, 'uploads/chung-chi/1784088179_6a5706734f35b.pdf', 'chuyen_mon'),
(200, 1, 5, 'AWS Certified Solutions Architect – Associate', 'Amazon Web Services (AWS)', '2025-02-15', '2028-02-15', 'AWS-SAA-889021', 'https://aws.amazon.com/verification/AWS-SAA-889021', NULL, 'chuyen_mon'),
(201, 1, 5, 'IELTS Academic 7.5', 'IDP Education', '2024-08-20', '2026-08-20', 'IDP-IELTS-750192', 'https://ielts.org/verify/IDP-IELTS-750192', NULL, 'ngoai_ngu'),
(202, 0, 5, 'Meta Full-Stack Engineer Certificate', 'Coursera & Meta', '2024-03-10', NULL, 'COURSERA-META-FS99', 'https://coursera.org/verify/professional-cert/META-FS99', NULL, 'chuyen_mon');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cv_ca_nhan`
--

DROP TABLE IF EXISTS `cv_ca_nhan`;
CREATE TABLE IF NOT EXISTS `cv_ca_nhan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` int(11) NOT NULL,
  `ten_cv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ma_template` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `la_cv_chinh` tinyint(1) DEFAULT '0',
  `du_lieu_tuy_chinh` json DEFAULT NULL,
  `ngay_xoa` timestamp NULL DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ma_template` (`ma_template`),
  KEY `idx_cvcn_xoa` (`id_nguoi_dung`,`ngay_xoa`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cv_ca_nhan`
--

INSERT INTO `cv_ca_nhan` (`id`, `id_nguoi_dung`, `ten_cv`, `ma_template`, `la_cv_chinh`, `du_lieu_tuy_chinh`, `ngay_xoa`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 2, 'CV của tôi', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"mo_ta_ngan\": \"cv tạo tự động\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"\", \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}}', '2026-07-07 21:20:20', '2026-07-07 21:17:24', '2026-07-27 04:27:32'),
(2, 2, 'CV của tôi', 'template_classic', 1, '{\"kieu_cv\": \"tu_dong\", \"mo_ta_ngan\": \"cv tạo tự động\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"\", \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}}', NULL, '2026-07-07 21:20:39', '2026-07-26 21:27:37'),
(11, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 21:50:47', '2026-07-07 21:50:47'),
(20, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 21:59:26', '2026-07-07 21:59:26'),
(29, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:01:11', '2026-07-07 22:01:11'),
(38, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:03:16', '2026-07-07 22:03:16'),
(47, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:05:47', '2026-07-07 22:05:47'),
(56, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:07:39', '2026-07-07 22:07:39'),
(65, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:12:46', '2026-07-07 22:12:46'),
(74, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:14:22', '2026-07-07 22:14:22'),
(83, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:17:28', '2026-07-07 22:17:28'),
(92, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:19:46', '2026-07-07 22:19:46'),
(93, 3, 'CV của tôi', 'template_classic', 1, '{\"kieu_cv\": \"tu_dong\", \"mo_ta_ngan\": \"123123\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"\", \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}}', NULL, '2026-07-07 22:21:30', '2026-07-07 22:21:30'),
(102, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:25:00', '2026-07-07 22:25:00'),
(111, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:25:41', '2026-07-07 22:25:41'),
(120, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:31:28', '2026-07-07 22:31:28'),
(129, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:33:33', '2026-07-07 22:33:33'),
(138, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:34:54', '2026-07-07 22:34:54'),
(147, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:36:55', '2026-07-07 22:36:55'),
(156, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:38:09', '2026-07-07 22:38:09'),
(165, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:40:48', '2026-07-07 22:40:48'),
(174, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:43:50', '2026-07-07 22:43:50'),
(183, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:44:49', '2026-07-07 22:44:49'),
(192, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-07 22:46:09', '2026-07-07 22:46:09'),
(201, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-10 03:12:52', '2026-07-10 03:12:52'),
(210, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-10 03:13:24', '2026-07-10 03:13:24'),
(219, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-14 20:55:50', '2026-07-14 20:55:50'),
(228, 2, 'CV của other', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"noi_dung_chinh_sua\": {\"email\": \"other_test@gmail.com\", \"dia_chi\": \"123 Đường ABC, TP HCM\", \"so_dien_thoai\": \"0387654321\"}}', NULL, '2026-07-14 21:03:01', '2026-07-14 21:03:01'),
(229, 2, 'cv tự động', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"mo_ta_ngan\": \"\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"\", \"lua_chon_items\": {\"du_an\": [], \"hoc_van\": [], \"ky_nang\": [], \"lien_ket\": [], \"ngon_ngu\": [], \"chung_chi\": [], \"thanh_tuu\": [], \"kinh_nghiem\": []}, \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}, \"noi_dung_chinh_sua\": []}', NULL, '2026-07-26 21:18:12', '2026-07-27 04:27:37'),
(230, 5, 'CV của tôi', 'template_classic', 0, '{\"kieu_cv\": \"tu_dong\", \"mo_ta_ngan\": \"cv được tạo tự động\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"uploads/avatar/2fa89c78-b98d-456a-85e0-9d87839457cc.jpg\", \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}}', NULL, '2026-08-03 23:02:40', '2026-08-04 08:48:39'),
(231, 5, 'sdasdas', 'template_classic', 0, '{\"kieu_cv\": \"thu_cong\", \"mo_ta_ngan\": \"12313\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"uploads/avatar/08ae995e-fbfb-4d9f-80fc-f8c7b17e6850.jpg\", \"lua_chon_items\": {\"du_an\": [\"240\", \"241\"], \"hoc_van\": [\"125\"], \"ky_nang\": [], \"lien_ket\": [], \"ngon_ngu\": [], \"chung_chi\": [\"200\", \"201\"], \"thanh_tuu\": [\"174\"], \"kinh_nghiem\": []}, \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"ky_nang\", \"thanh_tuu\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}, \"noi_dung_chinh_sua\": []}', NULL, '2026-08-04 01:46:08', '2026-08-04 01:46:57'),
(232, 5, 'cvtd', 'template_classic', 1, '{\"kieu_cv\": \"tu_dong\", \"mo_ta_ngan\": \"1231231\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"uploads/avatar/08ae995e-fbfb-4d9f-80fc-f8c7b17e6850.jpg\", \"lua_chon_items\": {\"du_an\": [], \"hoc_van\": [], \"ky_nang\": [], \"lien_ket\": [], \"ngon_ngu\": [], \"chung_chi\": [], \"thanh_tuu\": [], \"kinh_nghiem\": []}, \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": false, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}, \"noi_dung_chinh_sua\": {\"gioi_thieu\": \"Kính gửi công ty .... ad\", \"hoc_van.125.gpa\": \"GPA: 3.65 / 4.0\", \"hoc_van.125.khoa\": \"Khoa: Trường CNTT & Truyền thông\", \"hoc_van.125.mo_ta\": \"Chuyên sâu về Kiến trúc phần mềm, Cơ sở dữ liệu nâng cao, Lập trình Web Fullstack và An toàn thông tin.\", \"hoc_van.125.nganh\": \"Ngành: Kỹ thuật Phần mềm\", \"hoc_van.125.tieu_de\": \"Cử nhân Công nghệ Thông tin\", \"hoc_van.125.xep_loai\": \"Xếp loại: Xuất sắc\", \"section_title.hoc_van\": \"HỌC VẤN & BẰNG CẤP\", \"hoc_van.125.ten_truong\": \"Đại học Bách Khoa Hà Nội\", \"section_title.gioi_thieu\": \"MÔ TẢ\", \"section_title.kinh_nghiem\": \"KINH NGHIỆM LÀM VIỆC\"}}', NULL, '2026-08-04 01:47:33', '2026-08-04 01:56:04'),
(233, 5, 'CV Ứng tuyển IT Support - Nguyễn Hoàng Hải', 'template_classic', 0, '{\"du_an\": \"- **Hệ thống Quản lý Hồ sơ Cá nhân & Tạo CV Tự động** (2025-01-10 – 2025-05-20)\\n  *Vai trò: Backend & Fullstack Developer*\\n  * Mô tả: Xây dựng hệ thống quản lý thông tin hồ sơ cá nhân toàn diện, bao gồm phân tích nhật ký hoạt động, tạo CV theo template chuẩn và xuất PDF chất lượng cao. Đảm bảo tính ổn định và bảo mật dữ liệu người dùng.\\n  * Công nghệ: Laravel, MySQL, JavaScript, CSS3, PDF Export\\n  * Liên kết: [https://github.com/hai281104/luanvan_doan](https://github.com/hai281104/luanvan_doan)\\n- **Ứng dụng Quản lý Tài chính Cá nhân Thông minh** (2024-09-01 – 2024-12-15)\\n  *Vai trò: Trưởng nhóm Phát triển*\\n  * Mô tả: Phát triển ứng dụng Web/Mobile theo dõi thu chi, lập kế hoạch tiết kiệm và biểu đồ phân tích xu hướng tài chính hàng tháng, giúp người dùng quản lý tài chính hiệu quả. Đảm bảo tính dễ sử dụng và độ chính xác của dữ liệu.\\n  * Công nghệ: Vue.js, Node.js, Chart.js, MongoDB\\n  * Liên kết: [https://github.com/hai281104/smart-finance](https://github.com/hai281104/smart-finance)\", \"hoc_van\": \"- **Cử nhân Công nghệ Thông tin** | Đại học Bách Khoa Hà Nội\\n  *Khoa: Trường CNTT & Truyền thông - Ngành: Kỹ thuật Phần mềm*\\n  *Thời gian: 2022 – 2026 (Dự kiến tốt nghiệp)*\\n  * Xếp loại: Xuất sắc (GPA: 3.65 / 4.0)\\n  * Chuyên sâu về Kiến trúc phần mềm, Cơ sở dữ liệu nâng cao, Lập trình Web Fullstack và An toàn thông tin.\\n  * Các môn học liên quan đến IT Support: Hệ điều hành, Mạng máy tính, Cơ sở dữ liệu, An toàn thông tin.\", \"ky_nang\": \"- **Kỹ năng Kỹ thuật:**\\n  * **Hệ điều hành:** Windows, Linux (Ubuntu, CentOS)\\n  * **Cơ sở dữ liệu:** MySQL, MongoDB, SQL Server (hiểu biết cơ bản)\\n  * **Mạng:** Hiểu biết về kiến trúc Client-Server, RESTful API, TCP/IP cơ bản\\n  * **Ngôn ngữ lập trình:** PHP, JavaScript, HTML/CSS, Go, C#, C++, Java (khả năng đọc hiểu và debug code)\\n  * **Công cụ:** Docker, Git, VS Code, Postman\\n  * **Cloud:** AWS (hiểu biết về các dịch vụ cơ bản)\\n  * **Xử lý sự cố:** Khả năng phân tích và xử lý các vấn đề phần mềm, phần cứng cơ bản, lỗi mạng.\\n- **Kỹ năng Mềm:**\\n  * Giải quyết vấn đề\\n  * Chịu áp lực công việc\\n  * Khả năng tự học và thích nghi nhanh với công nghệ mới\\n  * Chú ý đến chi tiết\\n  * Giao tiếp hiệu quả (Tiếng Anh và Tiếng Việt)\\n  * Làm việc độc lập và làm việc nhóm\", \"muc_tieu\": \"Với nền tảng vững chắc về phát triển phần mềm và kiến thức hệ thống, tôi mong muốn ứng dụng khả năng phân tích, giải quyết vấn đề và kỹ năng giao tiếp hiệu quả để hỗ trợ người dùng, đảm bảo hệ thống hoạt động ổn định. Tôi cam kết học hỏi nhanh chóng các công nghệ mới và đóng góp tích cực vào việc cải thiện trải nghiệm người dùng trong vai trò IT Support, đồng thời phát triển chuyên môn sâu hơn về quản lý và vận hành hệ thống.\", \"chung_chi\": \"- **AWS Certified Solutions Architect – Associate** | Amazon Web Services (AWS)\\n  *Ngày cấp: 2025-02-15 – Ngày hết hạn: 2028-02-15*\\n  * Mã chứng chỉ: AWS-SAA-889021\\n  * Liên kết: [https://aws.amazon.com/verification/AWS-SAA-889021](https://aws.amazon.com/verification/AWS-SAA-889021)\\n  * Chứng minh khả năng thiết kế và triển khai các hệ thống phân tán, có khả năng mở rộng, chịu lỗi cao và tiết kiệm chi phí trên AWS, hữu ích trong việc hỗ trợ các giải pháp đám mây.\\n- **IELTS Academic 7.5** | IDP Education\\n  *Ngày cấp: 2024-08-20 – Ngày hết hạn: 2026-08-20*\\n  * Mã chứng chỉ: IDP-IELTS-750192\\n  * Liên kết: [https://ielts.org/verify/IDP-IELTS-750192](https://ielts.org/verify/IDP-IELTS-750192)\\n  * Khẳng định khả năng giao tiếp tiếng Anh thành thạo, phục vụ tốt cho việc hỗ trợ khách hàng và tìm kiếm tài liệu kỹ thuật quốc tế.\\n- **Meta Full-Stack Engineer Certificate** | Coursera & Meta\\n  *Ngày cấp: 2024-03-10*\\n  * Mã chứng chỉ: COURSERA-META-FS99\\n  * Liên kết: [https://coursera.org/verify/professional-cert/META-FS99](https://coursera.org/verify/professional-cert/META-FS99)\\n  * Chứng nhận kiến thức toàn diện về phát triển phần mềm, từ frontend đến backend, giúp hiểu rõ cấu trúc hệ thống và quy trình hoạt động.\", \"hoat_dong\": \"\", \"kinh_nghiem\": \"- **Lập trình viên Fullstack Web (Laravel & Vue.js)** | FPT Software Hà Nội\\n  *Ngày bắt đầu: 2024-06-15 – Hiện tại*\\n  * Phát triển các module quản lý dữ liệu cho hệ thống doanh nghiệp, đảm bảo tính toàn vẹn và khả năng truy xuất dữ liệu.\\n  * Thiết kế và triển khai RESTful API bảo mật, tối ưu hóa hiệu suất và khả năng mở rộng của hệ thống.\\n  * Xây dựng giao diện người dùng Vue.js, tập trung vào trải nghiệm người dùng và tối ưu hóa tốc độ tải trang (dưới 1.2s), giúp cải thiện hiệu quả sử dụng.\\n  * Tham gia vào quy trình xử lý sự cố và duy trì hệ thống, đảm bảo hoạt động liên tục và ổn định.\\n- **Thực tập sinh Lập trình PHP / Web Developer** | Tập đoàn Công nghệ BKAV\\n  *Ngày bắt đầu: 2023-11-01 – Ngày kết thúc: 2024-05-30*\\n  * Tham gia phát triển các portal nội bộ, hỗ trợ vận hành và quản lý thông tin trong tổ chức.\\n  * Thực hiện sửa lỗi giao diện người dùng và tối ưu hóa câu truy vấn SQL để cải thiện hiệu suất ứng dụng.\\n  * Viết unit test phủ 80% mã nguồn, đảm bảo chất lượng và độ ổn định của các tính năng mới.\", \"mau_chu_dao\": \"#1e3a8a\"}', '2026-08-10 01:43:49', '2026-08-10 01:42:09', '2026-08-10 08:43:49'),
(234, 5, 'CV Ứng tuyển IT Support', 'template_classic', 0, '{\"sdt\": \"0767783346\", \"du_an\": \"- **Hệ thống Quản lý Hồ sơ Cá nhân & Tạo CV Tự động**\\n  - Vai trò: Backend & Fullstack Developer\\n  - Mô tả: Phát triển hệ thống quản lý thông tin hồ sơ cá nhân toàn diện, bao gồm phân tích nhật ký hoạt động và tạo CV theo template chuẩn, xuất PDF chất lượng cao. Dự án này rèn luyện kỹ năng quản lý dữ liệu, tối ưu hóa quy trình và xử lý thông tin nhạy cảm, có thể ứng dụng trong quản lý hệ thống người dùng và dữ liệu hỗ trợ.\\n  - Công nghệ: Laravel, MySQL, JavaScript, CSS3, PDF Export.\\n  - Liên kết: https://github.com/hai281104/luanvan_doan\\n- **Ứng dụng Quản lý Tài chính Cá nhân Thông minh**\\n  - Vai trò: Trưởng nhóm Phát triển\\n  - Mô tả: Dẫn dắt nhóm phát triển ứng dụng Web/Mobile theo dõi thu chi, lập kế hoạch tiết kiệm và biểu đồ phân tích xu hướng tài chính hàng tháng. Kinh nghiệm quản lý dự án, phối hợp nhóm và phát triển các tính năng hướng tới người dùng cuối, giúp cải thiện khả năng hỗ trợ và giải thích các vấn đề kỹ thuật cho người dùng không chuyên.\\n  - Công nghệ: Vue.js, Node.js, Chart.js, MongoDB.\\n  - Liên kết: https://github.com/hai281104/smart-finance\", \"email\": \"nguyenhai281104@gmail.com\", \"ho_ten\": \"Nguyễn Hoàng Hải\", \"dia_chi\": \"Hà Nội, Việt Nam\", \"hoc_van\": \"- **Cử nhân Công nghệ Thông tin** | Đại học Bách Khoa Hà Nội (2022 - 2026)\\n  - Chuyên ngành: Kỹ thuật Phần mềm\\n  - Xếp loại: Xuất sắc (GPA: 3.65 / 4.0)\\n  - Mô tả: Chuyên sâu về Kiến trúc phần mềm, Cơ sở dữ liệu nâng cao, Lập trình Web Fullstack và An toàn thông tin, cung cấp nền tảng vững chắc để hiểu và xử lý các vấn đề kỹ thuật phức tạp trong môi trường IT.\", \"ky_nang\": {\"chuyen_mon\": [\"Hệ điều hành: Windows, Linux (Docker)\", \"Cơ sở dữ liệu: MySQL, MongoDB, SQL\", \"Mạng & Bảo mật: RESTful API, JWT/OAuth2, Kiến thức nền tảng An toàn thông tin\", \"Công cụ & Nền tảng: Docker, Git, VS Code\", \"Ngôn ngữ lập trình: JavaScript, PHP (Laravel), Vue.js, Node.js, HTML/CSS, C#, C++, Java (nền tảng)\", \"Troubleshooting & Debugging\", \"Phân tích hệ thống và yêu cầu người dùng\"], \"ky_nang_mem\": [\"Giải quyết vấn đề\", \"Khả năng tự học & thích nghi nhanh\", \"Chú ý đến chi tiết\", \"Làm việc độc lập và hợp tác nhóm\", \"Chịu áp lực công việc\", \"Giao tiếp hiệu quả (Đàm phán, Giải quyết xung đột)\"]}, \"muc_tieu\": \"Với nền tảng vững chắc về phát triển phần mềm Fullstack và kinh nghiệm thực tế trong việc xây dựng, tối ưu hóa hệ thống, tôi mong muốn ứng dụng kỹ năng phân tích và giải quyết vấn đề của mình vào vị trí IT Support. Mục tiêu của tôi là cung cấp hỗ trợ kỹ thuật hiệu quả, đảm bảo hoạt động hệ thống ổn định và nâng cao trải nghiệm người dùng, đồng thời không ngừng học hỏi để phát triển chuyên môn trong lĩnh vực hỗ trợ công nghệ thông tin.\", \"chuc_danh\": \"Fullstack developer\", \"chung_chi\": [\"- **AWS Certified Solutions Architect – Associate** | Amazon Web Services (AWS) | Cấp ngày: 15/02/2025 | Mã: AWS-SAA-889021 | Liên kết: https://aws.amazon.com/verification/AWS-SAA-889021\", \"- **IELTS Academic 7.5** | IDP Education | Cấp ngày: 20/08/2024 | Mã: IDP-IELTS-750192 | Liên kết: https://ielts.org/verify/IDP-IELTS-750192\", \"- **Meta Full-Stack Engineer Certificate** | Coursera & Meta | Cấp ngày: 10/03/2024 | Mã: COURSERA-META-FS99 | Liên kết: https://coursera.org/verify/professional-cert/META-FS99\"], \"hoat_dong\": \"\", \"kinh_nghiem\": \"- **Lập trình viên Fullstack Web (Laravel & Vue.js)** | FPT Software Hà Nội (06/2024 - Hiện tại)\\n  - Tham gia phát triển và duy trì các module quản lý dữ liệu cho hệ thống doanh nghiệp, đảm bảo tính ổn định và hiệu suất hoạt động.\\n  - Áp dụng kiến thức về thiết kế RESTful API và bảo mật (JWT/OAuth2) để hiểu và khắc phục các vấn đề liên quan đến kết nối và quyền truy cập hệ thống.\\n  - Tối ưu hóa hiệu suất giao diện người dùng Vue.js, góp phần nâng cao trải nghiệm cho người sử dụng cuối (tốc độ tải trang dưới 1.2s).\\n  - Phát triển kỹ năng debug và xử lý lỗi hiệu quả trong môi trường phát triển web phức tạp.\\n- **Thực tập sinh Lập trình PHP / Web Developer** | Tập đoàn Công nghệ BKAV (11/2023 - 05/2024)\\n  - Hỗ trợ phát triển và duy trì các portal nội bộ, xử lý các yêu cầu thay đổi và cải tiến hệ thống.\\n  - Thực hiện sửa lỗi giao diện người dùng và tối ưu hóa hiệu suất câu truy vấn SQL, trực tiếp cải thiện trải nghiệm người dùng.\\n  - Phát triển kỹ năng kiểm thử và đảm bảo chất lượng phần mềm bằng cách viết unit test phủ 80% mã nguồn, giúp xác định và giải quyết các vấn đề tiềm ẩn.\\n  - Tích lũy kinh nghiệm về quy trình phát triển phần mềm và vòng đời hỗ trợ kỹ thuật.\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"uploads/avatar/08ae995e-fbfb-4d9f-80fc-f8c7b17e6850.jpg\"}', '2026-08-10 01:47:09', '2026-08-10 01:44:23', '2026-08-10 08:47:09'),
(235, 5, '1231231', 'mau_thu3', 0, '{\"kieu_cv\": \"thu_cong\", \"mo_ta_ngan\": \"123123123\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"uploads/avatar/08ae995e-fbfb-4d9f-80fc-f8c7b17e6850.jpg\", \"lua_chon_items\": {\"du_an\": [], \"hoc_van\": [], \"ky_nang\": [], \"lien_ket\": [], \"ngon_ngu\": [], \"chung_chi\": [], \"thanh_tuu\": [], \"kinh_nghiem\": []}, \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}}', '2026-08-10 02:34:48', '2026-08-10 02:30:35', '2026-08-10 09:34:48'),
(236, 5, 'mẫu 3', 'mau_thu3', 0, '{\"kieu_cv\": \"thu_cong\", \"mo_ta_ngan\": \"123123\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"uploads/avatar/08ae995e-fbfb-4d9f-80fc-f8c7b17e6850.jpg\", \"lua_chon_items\": {\"du_an\": [\"240\", \"241\"], \"hoc_van\": [\"125\"], \"ky_nang\": [], \"lien_ket\": [\"13\", \"14\"], \"ngon_ngu\": [\"C#\", \"C++\", \"Docker\"], \"chung_chi\": [\"200\", \"201\", \"202\"], \"thanh_tuu\": [\"174\", \"173\"], \"kinh_nghiem\": [\"8\", \"9\"]}, \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}, \"noi_dung_chinh_sua\": []}', '2026-08-10 02:37:33', '2026-08-10 02:35:02', '2026-08-10 09:37:33'),
(237, 5, 'mẫu 3', 'mau_thu3', 0, '{\"kieu_cv\": \"thu_cong\", \"mo_ta_ngan\": \"mẫu 3\", \"trang_thai\": \"nhap\", \"mau_chu_dao\": \"#1e3a8a\", \"anh_dai_dien\": \"uploads/avatar/08ae995e-fbfb-4d9f-80fc-f8c7b17e6850.jpg\", \"lua_chon_items\": {\"du_an\": [\"240\", \"241\"], \"hoc_van\": [\"125\"], \"ky_nang\": [], \"lien_ket\": [\"13\", \"14\", \"15\"], \"ngon_ngu\": [\"C++\", \"Docker\"], \"chung_chi\": [\"200\", \"201\", \"202\"], \"thanh_tuu\": [\"174\", \"173\"], \"kinh_nghiem\": [\"8\", \"9\"]}, \"thu_tu_cac_muc\": [\"hoc_van\", \"kinh_nghiem\", \"du_an\", \"chung_chi\", \"thanh_tuu\", \"ky_nang\", \"lien_ket\", \"so_thich\"], \"hien_thi_cac_muc\": {\"du_an\": true, \"hoc_van\": true, \"ky_nang\": true, \"lien_ket\": true, \"so_thich\": true, \"chung_chi\": true, \"thanh_tuu\": true, \"kinh_nghiem\": true}, \"noi_dung_chinh_sua\": []}', NULL, '2026-08-10 02:37:43', '2026-08-10 02:38:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dich_vu_ca_nhan`
--

DROP TABLE IF EXISTS `dich_vu_ca_nhan`;
CREATE TABLE IF NOT EXISTS `dich_vu_ca_nhan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` bigint(20) UNSIGNED NOT NULL,
  `ten_dich_vu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phan_loai` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lap_trinh_web',
  `trang_thai` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 = hiển thị lên cộng đồng, 0 = ẩn',
  `trang_thai_duyet` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = chờ duyệt, 1 = đã duyệt, 2 = từ chối',
  `ly_do_tu_choi` text COLLATE utf8mb4_unicode_ci COMMENT 'Lý do từ chối (nếu có)',
  `mo_ta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `zalo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gmail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cv` bigint(20) UNSIGNED DEFAULT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dich_vu_ca_nhan_id_nguoi_dung_foreign` (`id_nguoi_dung`),
  KEY `dich_vu_ca_nhan_id_cv_foreign` (`id_cv`)
) ENGINE=MyISAM AUTO_INCREMENT=214 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dich_vu_ca_nhan`
--

INSERT INTO `dich_vu_ca_nhan` (`id`, `id_nguoi_dung`, `ten_dich_vu`, `phan_loai`, `trang_thai`, `trang_thai_duyet`, `ly_do_tu_choi`, `mo_ta`, `zalo`, `gmail`, `id_cv`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(137, 2, 'Xây dựng Website Doanh nghiệp trọn gói', 'lap_trinh_web', 0, 0, NULL, 'Cung cấp giải pháp phát triển website doanh nghiệp chuyên nghiệp bằng Laravel và VueJS. Tối ưu SEO, giao diện responsive mượt mà trên di động, tích hợp cổng thanh toán trực tuyến và hệ thống quản trị nội dung dễ sử dụng.', '0912345678', 'nguoidunga@gmail.com', 2, '2026-07-07 22:38:00', '2026-07-07 22:38:00'),
(138, 2, 'Tối ưu hóa & Thiết kế Database lớn', 'toi_uu_sql', 0, 0, NULL, 'Phân tích, thiết kế lại cấu trúc bảng và tối ưu hóa các câu truy vấn SQL chậm. Cấu hình Indexing thông minh, tối ưu bộ nhớ đệm MySQL/PostgreSQL giúp cải thiện 80% tốc độ tải trang cho hệ thống của bạn.', '0912345678', 'nguoidunga@gmail.com', 2, '2026-07-07 22:38:00', '2026-07-07 22:38:00'),
(139, 3, 'Thiết kế UI/UX ứng dụng di động & Web', 'thiet_ke_uiux', 1, 1, NULL, 'Thiết kế Wireframe, UI/UX Prototype chuyên nghiệp trên Figma cho ứng dụng iOS/Android và hệ thống Web Dashboard. Tập trung tối đa vào trải nghiệm người dùng, nghiên cứu hành vi và tối ưu hóa tỷ lệ chuyển đổi.', '0987654321', 'nguoidungb@gmail.com', 93, '2026-07-07 22:39:00', '2026-07-07 22:38:34'),
(140, 3, 'Phát triển App Mobile đa nền tảng Flutter', 'lap_trinh_mobile', 1, 1, NULL, 'Xây dựng ứng dụng di động chất lượng cao trên cả hai hệ điều hành iOS và Android bằng Flutter. Code sạch, cấu trúc logic dễ mở rộng, tối ưu bộ nhớ và trải nghiệm cuộn mượt mà như native app.', '0987654321', 'nguoidungb@gmail.com', 93, '2026-07-07 22:40:00', '2026-07-07 22:38:38'),
(141, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:38:09', '2026-07-07 22:38:09'),
(142, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-07 22:38:09', '2026-07-07 22:38:09'),
(143, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-07 22:38:09', '2026-07-07 22:38:09'),
(145, 2, 'Dịch vụ của other', 'lap_trinh_web', 1, 1, NULL, 'Mô tả', '0987654321', 'other@gmail.com', NULL, '2026-07-07 22:38:09', '2026-07-07 22:38:46'),
(146, 2, 'Dịch vụ của other đính kèm CV', 'lap_trinh_web', 1, 1, NULL, 'Mô tả', '0387654321', 'other_test@gmail.com', 156, '2026-07-07 22:38:09', '2026-07-07 22:38:42'),
(147, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-07 22:38:09', '2026-07-07 22:38:09'),
(148, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:38:09', '2026-07-07 22:38:09'),
(149, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:40:48', '2026-07-07 22:40:48'),
(150, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-07 22:40:48', '2026-07-07 22:40:48'),
(151, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-07 22:40:48', '2026-07-07 22:40:48'),
(181, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-10 03:12:51', '2026-07-10 03:12:51'),
(154, 2, 'Dịch vụ của other đính kèm CV', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0387654321', 'other_test@gmail.com', 165, '2026-07-07 22:40:48', '2026-07-07 22:40:48'),
(155, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-07 22:40:48', '2026-07-07 22:40:48'),
(156, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:40:48', '2026-07-07 22:40:48'),
(157, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:43:50', '2026-07-07 22:43:50'),
(158, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-07 22:43:50', '2026-07-07 22:43:50'),
(159, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-07 22:43:50', '2026-07-07 22:43:50'),
(182, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-10 03:12:52', '2026-07-10 03:12:52'),
(163, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-07 22:43:50', '2026-07-07 22:43:50'),
(164, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:43:50', '2026-07-07 22:43:50'),
(165, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:44:49', '2026-07-07 22:44:49'),
(166, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-07 22:44:49', '2026-07-07 22:44:49'),
(167, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-07 22:44:49', '2026-07-07 22:44:49'),
(186, 2, 'Dịch vụ của other đính kèm CV', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0387654321', 'other_test@gmail.com', 201, '2026-07-10 03:12:52', '2026-07-10 03:12:52'),
(183, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-10 03:12:52', '2026-07-10 03:12:52'),
(171, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-07 22:44:49', '2026-07-07 22:44:49'),
(172, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:44:49', '2026-07-07 22:44:49'),
(173, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:46:09', '2026-07-07 22:46:09'),
(174, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-07 22:46:09', '2026-07-07 22:46:09'),
(175, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-07 22:46:09', '2026-07-07 22:46:09'),
(185, 2, 'Dịch vụ của other', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0987654321', 'other@gmail.com', NULL, '2026-07-10 03:12:52', '2026-07-10 03:12:52'),
(179, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-07 22:46:10', '2026-07-07 22:46:10'),
(180, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-07 22:46:10', '2026-07-07 22:46:10'),
(187, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-10 03:12:52', '2026-07-10 03:12:52'),
(188, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-10 03:12:52', '2026-07-10 03:12:52'),
(189, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-10 03:13:24', '2026-07-10 03:13:24'),
(190, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-10 03:13:24', '2026-07-10 03:13:24'),
(191, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-10 03:13:24', '2026-07-10 03:13:24'),
(193, 2, 'Dịch vụ của other', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0987654321', 'other@gmail.com', NULL, '2026-07-10 03:13:24', '2026-07-10 03:13:24'),
(194, 2, 'Dịch vụ của other đính kèm CV', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0387654321', 'other_test@gmail.com', 210, '2026-07-10 03:13:24', '2026-07-10 03:13:24'),
(195, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-10 03:13:24', '2026-07-10 03:13:24'),
(196, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-10 03:13:25', '2026-07-10 03:13:25'),
(197, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-14 20:55:50', '2026-07-14 20:55:50'),
(198, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-14 20:55:50', '2026-07-14 20:55:50'),
(199, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-14 20:55:50', '2026-07-14 20:55:50'),
(201, 2, 'Dịch vụ của other', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0987654321', 'other@gmail.com', NULL, '2026-07-14 20:55:50', '2026-07-14 20:55:50'),
(202, 2, 'Dịch vụ của other đính kèm CV', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0387654321', 'other_test@gmail.com', 219, '2026-07-14 20:55:50', '2026-07-14 20:55:50'),
(203, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-14 20:55:50', '2026-07-14 20:55:50'),
(204, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-14 20:55:51', '2026-07-14 20:55:51'),
(205, 1, 'Dịch vụ test tự động', 'lap_trinh_web', 0, 0, NULL, 'Mô tả dịch vụ test tự động có độ dài hợp lệ', '0987654321', 'test@gmail.com', NULL, '2026-07-14 21:03:00', '2026-07-14 21:03:00'),
(206, 1, 'Dịch vụ an ninh mạng', 'an_ninh_mang', 0, 0, NULL, 'Cung cấp các giải pháp bảo mật và an ninh mạng', '0987654321', 'security@gmail.com', NULL, '2026-07-14 21:03:00', '2026-07-14 21:03:00'),
(207, 1, 'Dịch vụ đã sửa', 'toi_uu_sql', 0, 0, NULL, 'Mô tả đã sửa', '0387654321', 'newtest@gmail.com', NULL, '2026-07-14 21:03:00', '2026-07-14 21:03:00'),
(209, 2, 'Dịch vụ của other', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0987654321', 'other@gmail.com', NULL, '2026-07-14 21:03:01', '2026-07-14 21:03:01'),
(210, 2, 'Dịch vụ của other đính kèm CV', 'lap_trinh_web', 1, 0, NULL, 'Mô tả', '0387654321', 'other_test@gmail.com', 228, '2026-07-14 21:03:01', '2026-07-14 21:03:01'),
(211, 1, 'alert(\"xss\")Lập trình Python', 'lap_trinh_web', 0, 0, NULL, 'Mô tả gói dịch vụ Python', '0912345678', 'contact_us@gmail.com', NULL, '2026-07-14 21:03:01', '2026-07-14 21:03:01'),
(212, 1, 'Dịch vụ 2000 ký tự', 'lap_trinh_web', 0, 0, NULL, 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', '0987654321', 'test@gmail.com', NULL, '2026-07-14 21:03:01', '2026-07-14 21:03:01'),
(213, 5, 'Xây dựng hệ thống crm online', 'lap_trinh_web', 1, 1, NULL, 'sử dụng java spring boot, kiến trúc clean architecture', '0767783346', 'nguyenhai281104@gmail.com', 230, '2026-08-03 23:05:38', '2026-08-03 23:12:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dong_gop_y_kien`
--

DROP TABLE IF EXISTS `dong_gop_y_kien`;
CREATE TABLE IF NOT EXISTS `dong_gop_y_kien` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` bigint(20) UNSIGNED NOT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dong_gop_y_kien_id_nguoi_dung_foreign` (`id_nguoi_dung`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `du_an`
--

DROP TABLE IF EXISTS `du_an`;
CREATE TABLE IF NOT EXISTS `du_an` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noi_bat` tinyint(4) NOT NULL DEFAULT '0',
  `id_nguoi_dung` int(11) NOT NULL,
  `ten_du_an` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vai_tro` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `ngay_bat_dau` date DEFAULT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `tu_khoa` json DEFAULT NULL,
  `ngay_xoa` timestamp NULL DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_duan_xoa` (`id_nguoi_dung`,`ngay_xoa`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `du_an`
--

INSERT INTO `du_an` (`id`, `noi_bat`, `id_nguoi_dung`, `ten_du_an`, `vai_tro`, `mo_ta`, `ngay_bat_dau`, `ngay_ket_thuc`, `tu_khoa`, `ngay_xoa`, `ngay_tao`) VALUES
(1, 1, 2, 'Hệ thống Quản lý và Tạo CV tự động', 'Backend Lead', 'Xây dựng toàn bộ hệ thống lưu trữ, phân tích log lỗi, hiển thị dung lượng DB và bảo mật xác thực của hệ thống.', '2025-02-10', '2025-05-15', '[\"Laravel\", \"MySQL\", \"CSS\", \"Javascript\"]', NULL, '2026-06-20 01:54:44'),
(2, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-20 01:54:57'),
(3, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-20 01:54:57'),
(4, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-20 01:54:57'),
(5, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-20 01:54:57'),
(6, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-20 01:54:57'),
(8, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-20 02:24:04'),
(9, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-20 02:24:04'),
(10, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-20 02:24:04'),
(11, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-20 02:24:04'),
(12, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-20 02:24:04'),
(14, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:42:47'),
(15, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:42:47'),
(16, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:42:47'),
(17, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-21 01:42:47'),
(18, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-21 01:42:47'),
(20, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:54:36'),
(21, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:54:36'),
(22, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:54:36'),
(23, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-21 01:54:36'),
(24, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-21 01:54:36'),
(26, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:59:35'),
(27, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:59:35'),
(28, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-21 01:59:35'),
(29, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-21 01:59:35'),
(30, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-21 01:59:35'),
(32, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:17:06'),
(33, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:17:06'),
(34, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:17:06'),
(35, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-23 00:17:06'),
(36, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-23 00:17:06'),
(38, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:18:20'),
(39, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:18:21'),
(40, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:18:21'),
(41, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-23 00:18:21'),
(42, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-23 00:18:21'),
(44, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:25:21'),
(45, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:25:21'),
(46, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-23 00:25:22'),
(47, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-23 00:25:22'),
(48, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-23 00:25:22'),
(50, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:31:30'),
(51, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:31:31'),
(52, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:31:31'),
(53, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-24 06:31:31'),
(54, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-24 06:31:31'),
(56, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:36:50'),
(57, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:36:50'),
(58, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:36:50'),
(59, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-24 06:36:50'),
(60, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-24 06:36:50'),
(62, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:41:25'),
(63, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:41:25'),
(64, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:41:25'),
(65, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-24 06:41:25'),
(66, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-24 06:41:25'),
(68, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:42:37'),
(69, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:42:37'),
(70, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:42:37'),
(71, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-24 06:42:38'),
(72, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-24 06:42:38'),
(74, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:48:56'),
(75, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:48:56'),
(76, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-24 06:48:56'),
(77, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-24 06:48:56'),
(78, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-24 06:48:56'),
(80, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-25 20:38:23'),
(81, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-25 20:38:23'),
(82, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-06-25 20:38:23'),
(83, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-06-25 20:38:23'),
(84, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-06-25 20:38:23'),
(85, 0, 3, 'Hệ thống Quản lý Đào tạo Trực tuyến', 'Fullstack Developer', 'Xây dựng website học trực tuyến cho phép giảng viên đăng bài giảng video, bài tập và cho phép học sinh tham gia học tập, thảo luận trực tuyến.', '2024-03-01', '2024-06-30', '[\"Laravel\", \"MySQL\", \"VueJS\", \"TailwindCSS\"]', NULL, '2026-07-08 04:46:24'),
(86, 1, 3, 'Ứng dụng Theo dõi Sức khỏe cá nhân', 'Frontend Developer', 'Phát triển ứng dụng di động theo dõi lượng calo, lịch tập thể dục và nhắc nhở uống nước hàng ngày cho người dùng.', '2023-09-15', '2023-12-15', '[\"React Native\", \"Expo\", \"Redux\", \"Firebase\"]', NULL, '2026-07-08 04:46:24'),
(87, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 21:50:47'),
(88, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 21:50:47'),
(89, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 21:50:47'),
(90, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 21:50:47'),
(91, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 21:50:47'),
(93, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 21:59:27'),
(94, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 21:59:27'),
(95, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 21:59:27'),
(96, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 21:59:27'),
(97, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 21:59:27'),
(99, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:01:11'),
(100, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:01:11'),
(101, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:01:11'),
(102, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:01:11'),
(103, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:01:11'),
(105, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:03:17'),
(106, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:03:17'),
(107, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:03:17'),
(108, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:03:17'),
(109, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:03:17'),
(111, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:05:47'),
(112, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:05:47'),
(113, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:05:47'),
(114, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:05:47'),
(115, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:05:47'),
(117, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:07:39'),
(118, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:07:39'),
(119, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:07:39'),
(120, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:07:39'),
(121, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:07:39'),
(123, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:12:46'),
(124, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:12:47'),
(125, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:12:47'),
(126, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:12:47'),
(127, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:12:47'),
(129, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:14:23'),
(130, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:14:23'),
(131, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:14:23'),
(132, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:14:23'),
(133, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:14:23'),
(135, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:17:28'),
(136, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:17:29'),
(137, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:17:29'),
(138, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:17:29'),
(139, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:17:29'),
(141, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:19:46'),
(142, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:19:46'),
(143, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:19:46'),
(144, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:19:47'),
(145, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:19:47'),
(147, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:25:00'),
(148, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:25:00'),
(149, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:25:00'),
(150, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:25:00'),
(151, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:25:00'),
(153, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:25:41'),
(154, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:25:41'),
(155, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:25:41'),
(156, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:25:42'),
(157, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:25:42'),
(159, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:31:28'),
(160, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:31:28'),
(161, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:31:28'),
(162, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:31:29'),
(163, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:31:29'),
(165, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:33:33'),
(166, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:33:33'),
(167, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:33:33'),
(168, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:33:33'),
(169, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:33:33'),
(171, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:34:54'),
(172, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:34:54'),
(173, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:34:55'),
(174, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:34:55'),
(175, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:34:55'),
(177, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:36:55'),
(178, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:36:55'),
(179, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:36:55'),
(180, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:36:56'),
(181, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:36:56'),
(183, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:38:09'),
(184, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:38:09'),
(185, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:38:09'),
(186, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:38:09'),
(187, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:38:09'),
(189, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:40:48'),
(190, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:40:48'),
(191, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:40:48'),
(192, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:40:49'),
(193, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:40:49'),
(195, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:43:50'),
(196, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:43:50'),
(197, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:43:50'),
(198, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:43:50'),
(199, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:43:51'),
(201, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:44:49'),
(202, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:44:49'),
(203, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:44:49'),
(204, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:44:50'),
(205, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:44:50'),
(207, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:46:10'),
(208, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:46:10'),
(209, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-07 22:46:10'),
(210, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-07 22:46:10'),
(211, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-07 22:46:10'),
(213, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-10 03:12:53'),
(214, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-10 03:12:53'),
(215, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-10 03:12:53'),
(216, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-10 03:12:53'),
(217, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-10 03:12:53'),
(219, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-10 03:13:25'),
(220, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-10 03:13:25'),
(221, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-10 03:13:25'),
(222, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-10 03:13:25'),
(223, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-10 03:13:25'),
(225, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-14 20:55:51'),
(226, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-14 20:55:51'),
(227, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-14 20:55:51'),
(228, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-14 20:55:51'),
(229, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-14 20:55:51'),
(231, 0, 1, 'Dự án @!#$ *()_+', 'Backend Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-14 21:03:01'),
(232, 0, 1, 'Du an test', 'Backend & Frontend *()', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-14 21:03:01'),
(233, 0, 1, 'alert(\"xss\")Dự án XSS', 'Fullstack Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[]', NULL, '2026-07-14 21:03:01'),
(234, 0, 1, 'Dự án test tag', 'Developer', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"HTML / CSS\", \"R & D\", \"React Native\", \"C++\"]', NULL, '2026-07-14 21:03:01'),
(235, 0, 1, 'Du an test', 'Lập trình viên Fullstack', 'Mo ta chi tiet du an.', '2023-01-01', NULL, '[\"Laravel\", \"MySQL\"]', NULL, '2026-07-14 21:03:01'),
(240, 1, 5, 'Hệ thống Quản lý Hồ sơ Cá nhân & Tạo CV Tự động', 'Backend & Fullstack Developer', 'Hệ thống quản lý thông tin hồ sơ cá nhân toàn diện, phân tích nhật ký hoạt động, tạo CV theo template chuẩn và xuất PDF chất lượng cao.', '2025-01-10', '2025-05-20', '[\"Laravel\", \"MySQL\", \"JavaScript\", \"CSS3\", \"PDF Export\"]', NULL, '2026-08-03 22:47:27'),
(241, 1, 5, 'Ứng dụng Quản lý Tài chính Cá nhân Thông minh', 'Trưởng nhóm Phát triển', 'Ứng dụng Web/Mobile theo dõi thu chi, lập kế hoạch tiết kiệm và biểu đồ phân tích xu hướng tài chính hàng tháng.', '2024-09-01', '2024-12-15', '[\"Vue.js\", \"Node.js\", \"Chart.js\", \"MongoDB\"]', NULL, '2026-08-03 22:47:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `du_an_lien_ket`
--

DROP TABLE IF EXISTS `du_an_lien_ket`;
CREATE TABLE IF NOT EXISTS `du_an_lien_ket` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_du_an` int(11) NOT NULL,
  `loai_lien_ket` enum('github','website','fanpage','tiktok','youtube','instagram','playstore','appstore','figma','demo','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `duong_dan` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nhan_hien_thi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thu_tu` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_duan_loai` (`id_du_an`,`loai_lien_ket`),
  KEY `idx_duan_lienket_thutu` (`id_du_an`,`thu_tu`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `du_an_lien_ket`
--

INSERT INTO `du_an_lien_ket` (`id`, `id_du_an`, `loai_lien_ket`, `duong_dan`, `nhan_hien_thi`, `thu_tu`) VALUES
(1, 1, 'github', 'https://github.com/nguoidunga/ho-so-ca-nhan', 'Mã nguồn Dự án', 1),
(2, 6, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(3, 12, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(4, 18, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(5, 24, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(6, 30, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(7, 36, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(8, 42, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(9, 48, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(10, 54, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(11, 60, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(12, 66, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(13, 72, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(14, 78, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(15, 84, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(16, 91, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(17, 97, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(18, 103, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(19, 109, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(20, 115, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(21, 121, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(22, 127, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(23, 133, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(24, 139, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(25, 145, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(26, 151, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(27, 157, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(28, 163, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(29, 169, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(30, 175, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(31, 181, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(32, 187, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(33, 193, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(34, 199, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(35, 205, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(36, 211, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(37, 217, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(38, 223, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(39, 229, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(40, 235, 'github', 'https://github.com/test', 'GitHub Repo', 1),
(47, 240, 'github', 'https://github.com/hai281104/luanvan_doan', 'Mã nguồn GitHub', 1),
(48, 240, 'demo', 'https://hoso.hai281104.dev', 'Trang Demo Live', 2),
(49, 241, 'github', 'https://github.com/hai281104/smart-finance', 'GitHub Repository', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoc_van`
--

DROP TABLE IF EXISTS `hoc_van`;
CREATE TABLE IF NOT EXISTS `hoc_van` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noi_bat` tinyint(4) NOT NULL DEFAULT '0',
  `id_nguoi_dung` int(11) NOT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_truong` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `xep_loai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gpa` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `khoa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nganh` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` enum('dang_hoc','da_tot_nghiep','tam_dung') COLLATE utf8mb4_unicode_ci DEFAULT 'dang_hoc',
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `nam_bat_dau` int(11) NOT NULL DEFAULT '2020',
  `nam_ket_thuc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_nguoi_dung` (`id_nguoi_dung`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `hoc_van`
--

INSERT INTO `hoc_van` (`id`, `noi_bat`, `id_nguoi_dung`, `tieu_de`, `ten_truong`, `xep_loai`, `gpa`, `khoa`, `nganh`, `trang_thai`, `mo_ta`, `nam_bat_dau`, `nam_ket_thuc`) VALUES
(1, 1, 2, 'Cử nhân Công nghệ thông tin', 'Đại học Bách Khoa', 'Giỏi', '3.4/4.0', 'Khoa Công nghệ thông tin', 'Kỹ thuật Phần mềm', 'da_tot_nghiep', 'Nghiên cứu về thuật toán, thiết kế hệ thống phần mềm, cơ sở dữ liệu và bảo mật thông tin.', 2020, 2024),
(3, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(4, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(6, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(7, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(9, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(10, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(12, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(13, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(15, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(16, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(18, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(19, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(21, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(22, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(24, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(25, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(27, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(28, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(30, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(31, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(33, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(34, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(36, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(37, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(39, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(40, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(42, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(43, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(44, 1, 3, 'Cử nhân Công nghệ Thông tin', 'Trường Đại học Công nghệ Thông tin - ĐHQG TP.HCM', 'Giỏi', '8.5', 'Khoa Khoa học Máy tính', 'Khoa học Máy tính', 'da_tot_nghiep', 'Chuyên ngành Trí tuệ nhân tạo và Phát triển phần mềm.', 2021, 2025),
(45, 0, 3, 'Bằng tốt nghiệp THPT', 'Trường THPT Chuyên Lê Hồng Phong', 'Giỏi', '9', 'Chuyên Tin học', NULL, 'da_tot_nghiep', 'Học sinh lớp chuyên Tin học, tham gia đội tuyển học sinh giỏi.', 2018, 2021),
(47, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(48, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(50, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(51, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(53, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(54, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(56, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(57, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(59, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(60, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(62, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(63, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(65, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(66, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(68, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(69, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(71, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(72, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(74, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(75, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(77, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(78, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(80, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(81, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(83, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(84, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(86, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(87, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(89, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(90, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(92, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(93, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(95, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(96, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(98, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(99, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(101, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(102, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(104, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(105, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(107, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(108, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(110, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(111, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(113, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(114, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(116, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(117, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(119, 0, 1, 'Cu nhan Khoa hoc May tinh', 'Dai hoc Bach Khoa', NULL, NULL, 'Cong nghe Thong tin', 'Khoa hoc May tinh', 'da_tot_nghiep', NULL, 2021, 2025),
(120, 0, 1, 'B.S. Computer Science (Honor)', 'Đại học KHTN, ĐHQG-HCM / CTU+', NULL, NULL, 'Khoa học Máy tính (DI-CS)', 'B.S. Computer Science', 'da_tot_nghiep', NULL, 2021, 2025),
(125, 1, 5, 'Cử nhân Công nghệ Thông tin', 'Đại học Bách Khoa Hà Nội', 'Xuất sắc', '3.65 / 4.0', 'Trường CNTT & Truyền thông', 'Kỹ thuật Phần mềm', 'dang_hoc', 'Chuyên sâu về Kiến trúc phần mềm, Cơ sở dữ liệu nâng cao, Lập trình Web Fullstack và An toàn thông tin.', 2022, 2026);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kinh_nghiem`
--

DROP TABLE IF EXISTS `kinh_nghiem`;
CREATE TABLE IF NOT EXISTS `kinh_nghiem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noi_bat` tinyint(4) NOT NULL DEFAULT '0',
  `id_nguoi_dung` int(11) NOT NULL,
  `vi_tri_cong_viec` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_cong_ty` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date DEFAULT NULL,
  `dang_lam_viec` tinyint(1) DEFAULT '0',
  `mo_ta_chi_tiet` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `id_nguoi_dung` (`id_nguoi_dung`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `kinh_nghiem`
--

INSERT INTO `kinh_nghiem` (`id`, `noi_bat`, `id_nguoi_dung`, `vi_tri_cong_viec`, `ten_cong_ty`, `ngay_bat_dau`, `ngay_ket_thuc`, `dang_lam_viec`, `mo_ta_chi_tiet`) VALUES
(1, 1, 2, 'Lập trình viên Backend PHP (Laravel)', 'Công ty Công nghệ ABC', '2024-06-01', NULL, 1, 'Phát triển APIs cho ứng dụng di động, thiết kế cơ sở dữ liệu tối ưu hóa tốc độ tìm kiếm và viết kiểm thử tự động (Unit Test).'),
(2, 0, 3, 'Lập trình viên Frontend', 'Công ty Cổ phần VNG', '2024-07-01', NULL, 1, 'Phát triển các tính năng giao diện người dùng cho dự án Zalo Web, tối ưu hiệu năng tải trang và trải nghiệm người dùng.'),
(3, 0, 3, 'Thực tập sinh Lập trình Web', 'FPT Software', '2023-06-01', '2023-09-30', 0, 'Tham gia học tập quy trình phát triển phần mềm Agile/Scrum, hỗ trợ viết code các module quản trị hệ thống bằng PHP/Laravel.'),
(8, 1, 5, 'Lập trình viên Fullstack Web (Laravel & Vue.js)', 'FPT Software Hà Nội', '2024-06-15', NULL, 1, 'Phát triển các module quản lý dữ liệu cho hệ thống doanh nghiệp. Thiết kế RESTful API bảo mật với JWT / OAuth2, xây dựng giao diện Vue.js tối ưu hóa tốc độ tải trang dưới 1.2s.'),
(9, 1, 5, 'Thực tập sinh Lập trình PHP / Web Developer', 'Tập đoàn Công nghệ BKAV', '2023-11-01', '2024-05-30', 0, 'Tham gia phát triển các portal nội bộ, sửa lỗi giao diện, tối ưu hóa câu truy vấn SQL và viết unit test phủ 80% mã nguồn.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ky_nang_mem`
--

DROP TABLE IF EXISTS `ky_nang_mem`;
CREATE TABLE IF NOT EXISTS `ky_nang_mem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_ky_nang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_ky_nang_mem` (`ten_ky_nang`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ky_nang_mem`
--

INSERT INTO `ky_nang_mem` (`id`, `ten_ky_nang`) VALUES
(17, 'Chịu áp lực công việc'),
(22, 'Chú ý đến chi tiết'),
(14, 'Đàm phán'),
(5, 'Giải quyết vấn đề'),
(20, 'Giải quyết xung đột'),
(3, 'Giao tiếp hiệu quả'),
(9, 'Khả năng tự học'),
(16, 'Làm việc độc lập'),
(4, 'Làm việc nhóm'),
(18, 'Lắng nghe tích cực'),
(11, 'Lãnh đạo'),
(1, 'múa'),
(2, 'nhảy'),
(7, 'Quản lý thời gian'),
(15, 'Ra quyết định'),
(12, 'Sáng tạo'),
(8, 'Thích ứng linh hoạt'),
(10, 'Thuyết trình'),
(19, 'Tổ chức công việc'),
(13, 'Trí tuệ cảm xúc (EQ)'),
(21, 'Tư duy logic'),
(6, 'Tư duy phản biện');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lich_cong_viec`
--

DROP TABLE IF EXISTS `lich_cong_viec`;
CREATE TABLE IF NOT EXISTS `lich_cong_viec` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` int(11) NOT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `gio_bat_dau` time DEFAULT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `gio_ket_thuc` time DEFAULT NULL,
  `phan_loai` enum('ca_nhan','hop_tac','deadline','su_kien','khac') COLLATE utf8mb4_unicode_ci DEFAULT 'ca_nhan',
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_lich_user_ngay` (`id_nguoi_dung`,`ngay_bat_dau`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lich_cong_viec`
--

INSERT INTO `lich_cong_viec` (`id`, `id_nguoi_dung`, `tieu_de`, `ngay_bat_dau`, `gio_bat_dau`, `ngay_ket_thuc`, `gio_ket_thuc`, `phan_loai`, `mo_ta`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 2, 'Giao ban dự án mới', '2026-06-21', '09:00:00', '2026-06-21', '10:30:00', 'hop_tac', 'Họp bàn về các tính năng phát triển trong sprint mới.', '2026-06-20 01:54:44', '2026-06-20 01:54:44'),
(2, 2, 'Hạn hoàn thành báo cáo tháng', '2026-06-23', '17:00:00', '2026-06-23', '17:30:00', 'deadline', 'Gửi báo cáo hiệu suất công việc lên hệ thống cho Quản lý.', '2026-06-20 01:54:44', '2026-06-20 01:54:44'),
(3, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-20 01:54:59', '2026-06-20 01:54:59'),
(6, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-20 02:24:07', '2026-06-20 02:24:07'),
(8, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-20 02:24:07', '2026-06-20 02:24:07'),
(9, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-21 01:42:53', '2026-06-21 01:42:53'),
(11, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-21 01:42:53', '2026-06-21 01:42:53'),
(12, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-21 01:54:38', '2026-06-21 01:54:38'),
(14, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-21 01:54:38', '2026-06-21 01:54:38'),
(15, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-21 01:59:38', '2026-06-21 01:59:38'),
(17, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-21 01:59:38', '2026-06-21 01:59:38'),
(18, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-23 00:17:13', '2026-06-23 00:17:13'),
(20, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-23 00:17:13', '2026-06-23 00:17:13'),
(21, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-23 00:18:24', '2026-06-23 00:18:24'),
(23, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-23 00:18:25', '2026-06-23 00:18:25'),
(24, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-23 00:25:24', '2026-06-23 00:25:24'),
(26, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-23 00:25:24', '2026-06-23 00:25:24'),
(27, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-24 06:31:35', '2026-06-24 06:31:35'),
(29, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-24 06:31:35', '2026-06-24 06:31:35'),
(30, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-24 06:36:54', '2026-06-24 06:36:54'),
(32, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-24 06:36:54', '2026-06-24 06:36:54'),
(33, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-24 06:41:27', '2026-06-24 06:41:27'),
(35, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-24 06:41:27', '2026-06-24 06:41:27'),
(36, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-24 06:42:41', '2026-06-24 06:42:41'),
(38, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-24 06:42:41', '2026-06-24 06:42:41'),
(39, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-24 06:48:59', '2026-06-24 06:48:59'),
(41, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-24 06:48:59', '2026-06-24 06:48:59'),
(42, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-06-25 20:38:28', '2026-06-25 20:38:28'),
(44, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-06-25 20:38:28', '2026-06-25 20:38:28'),
(45, 2, 'làm backend dự án CRM online', '2026-07-09', '13:00:00', '2026-07-11', '20:00:00', 'hop_tac', 'chỉnh sửa các yêu cầu của khách hàng', '2026-07-07 21:13:43', '2026-07-07 21:13:43'),
(46, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 21:50:49', '2026-07-07 21:50:49'),
(48, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 21:50:50', '2026-07-07 21:50:50'),
(49, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 21:59:29', '2026-07-07 21:59:29'),
(51, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 21:59:30', '2026-07-07 21:59:30'),
(52, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:01:14', '2026-07-07 22:01:14'),
(54, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:01:14', '2026-07-07 22:01:14'),
(55, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:03:19', '2026-07-07 22:03:19'),
(57, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:03:20', '2026-07-07 22:03:20'),
(58, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:05:50', '2026-07-07 22:05:50'),
(60, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:05:50', '2026-07-07 22:05:50'),
(61, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:07:42', '2026-07-07 22:07:42'),
(63, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:07:42', '2026-07-07 22:07:42'),
(64, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:12:49', '2026-07-07 22:12:49'),
(66, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:12:49', '2026-07-07 22:12:49'),
(67, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:14:25', '2026-07-07 22:14:25'),
(69, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:14:25', '2026-07-07 22:14:25'),
(70, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:17:31', '2026-07-07 22:17:31'),
(72, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:17:31', '2026-07-07 22:17:31'),
(73, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:19:49', '2026-07-07 22:19:49'),
(75, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:19:49', '2026-07-07 22:19:49'),
(76, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:25:02', '2026-07-07 22:25:02'),
(78, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:25:02', '2026-07-07 22:25:02'),
(79, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:25:44', '2026-07-07 22:25:44'),
(81, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:25:44', '2026-07-07 22:25:44'),
(82, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:31:31', '2026-07-07 22:31:31'),
(84, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:31:31', '2026-07-07 22:31:31'),
(85, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:33:36', '2026-07-07 22:33:36'),
(87, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:33:36', '2026-07-07 22:33:36'),
(88, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:34:57', '2026-07-07 22:34:57'),
(90, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:34:57', '2026-07-07 22:34:57'),
(91, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:36:58', '2026-07-07 22:36:58'),
(93, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:36:58', '2026-07-07 22:36:58'),
(94, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:38:11', '2026-07-07 22:38:11'),
(96, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:38:11', '2026-07-07 22:38:11'),
(97, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:40:51', '2026-07-07 22:40:51'),
(99, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:40:52', '2026-07-07 22:40:52'),
(100, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:43:52', '2026-07-07 22:43:52'),
(102, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:43:52', '2026-07-07 22:43:52'),
(103, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:44:51', '2026-07-07 22:44:51'),
(105, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:44:51', '2026-07-07 22:44:51'),
(106, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-07 22:46:13', '2026-07-07 22:46:13'),
(108, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-07 22:46:13', '2026-07-07 22:46:13'),
(109, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-10 03:12:56', '2026-07-10 03:12:56'),
(111, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-10 03:12:57', '2026-07-10 03:12:57'),
(112, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-10 03:13:29', '2026-07-10 03:13:29'),
(114, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-10 03:13:29', '2026-07-10 03:13:29'),
(115, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-14 20:55:55', '2026-07-14 20:55:55'),
(117, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-14 20:55:55', '2026-07-14 20:55:55'),
(118, 1, 'Báo cáo luận văn tốt nghiệp', '2026-06-18', '08:00:00', '2026-06-18', '11:30:00', 'su_kien', 'Địa điểm: Phòng hội trường C1. Báo cáo trước hội đồng.', '2026-07-14 21:03:03', '2026-07-14 21:03:03'),
(120, 2, 'Sự kiện của user khác', '2026-06-18', NULL, '2026-06-18', NULL, 'khac', NULL, '2026-07-14 21:03:03', '2026-07-14 21:03:03'),
(127, 5, 'Họp giao ban sprint dự án Laravel', '2026-08-05', '08:30:00', '2026-08-05', '10:00:00', 'hop_tac', 'Thảo luận với team về kế hoạch triển khai API v2 và tích hợp thông báo đẩy.', '2026-08-03 22:47:27', '2026-08-03 22:47:27'),
(128, 5, 'Hạn nộp báo cáo Đồ án tốt nghiệp', '2026-08-07', '17:00:00', '2026-08-07', '17:30:00', 'deadline', 'Gửi tài liệu báo cáo đầy đủ cho thầy giáo hướng dẫn duyệt lần cuối.', '2026-08-03 22:47:27', '2026-08-03 22:47:27'),
(129, 5, 'Tham gia Workshop TechTalk Cloud Native', '2026-08-09', '14:00:00', '2026-08-09', '16:30:00', 'su_kien', 'Lắng nghe chia sẻ về Docker, Kubernetes và CI/CD Pipelines.', '2026-08-03 22:47:27', '2026-08-03 22:47:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lien_ket_mxh`
--

DROP TABLE IF EXISTS `lien_ket_mxh`;
CREATE TABLE IF NOT EXISTS `lien_ket_mxh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` int(11) NOT NULL,
  `ten_nen_tang` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duong_dan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hien_thi` int(11) DEFAULT NULL,
  `thu_tu` int(11) DEFAULT '0',
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_nen_tang` (`id_nguoi_dung`,`ten_nen_tang`),
  KEY `idx_mxh_user_thutu` (`id_nguoi_dung`,`thu_tu`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lien_ket_mxh`
--

INSERT INTO `lien_ket_mxh` (`id`, `id_nguoi_dung`, `ten_nen_tang`, `duong_dan`, `hien_thi`, `thu_tu`, `ngay_tao`) VALUES
(3, 2, 'LinkedIn', 'https://linkedin.com/in/nguoidunga', 1, 1, '2026-07-07 21:16:08'),
(4, 2, 'Facebook', 'https://github.com/nguoidunga', 1, 2, '2026-07-07 21:16:08'),
(13, 5, 'GitHub', 'https://github.com/hai281104', 1, 1, '2026-08-03 22:47:27'),
(14, 5, 'LinkedIn', 'https://linkedin.com/in/nguyenhai281104', 1, 2, '2026-08-03 22:47:27'),
(15, 5, 'Facebook', 'https://facebook.com/nguyenhai281104', 1, 3, '2026-08-03 22:47:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mau_cv`
--

DROP TABLE IF EXISTS `mau_cv`;
CREATE TABLE IF NOT EXISTS `mau_cv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_mau_cv` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ten_mau` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phien_ban` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'v1.0',
  `kich_thuoc_file` bigint(20) UNSIGNED DEFAULT NULL,
  `anh_xem_truoc` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duong_dan_file` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trang_thai` enum('hoat_dong','tam_an') COLLATE utf8mb4_unicode_ci DEFAULT 'hoat_dong',
  `ngay_xoa` timestamp NULL DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ma_mau_cv` (`ma_mau_cv`),
  KEY `idx_maucv_xoa` (`ngay_xoa`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mau_cv`
--

INSERT INTO `mau_cv` (`id`, `ma_mau_cv`, `ten_mau`, `phien_ban`, `kich_thuoc_file`, `anh_xem_truoc`, `duong_dan_file`, `trang_thai`, `ngay_xoa`, `ngay_tao`, `ngay_cap_nhat`) VALUES
(1, 'template_classic', 'Cổ điển đơn giản (Classic)', 'v1.0', 0, 'uploads/cv-templates/classic.png', 'ho-so.cv-templates.template_classic', 'hoat_dong', NULL, '2026-06-20 01:54:44', '2026-06-20 01:54:44'),
(2, 'template_modern', 'Hiện đại chuyên nghiệp (Modern)', 'v1.0', 0, 'uploads/cv-templates/modern.png', 'ho-so.cv-templates.template_modern', 'hoat_dong', NULL, '2026-06-20 01:54:44', '2026-06-20 01:54:44'),
(3, 'mau_thu3', 'Mẫu 3', 'v1.0', 8895, 'uploads/cv-templates/7b7d7b72-5440-4b17-bd77-3a3e3ea3fa38.png', 'ho-so.cv-templates.mau_thu3', 'hoat_dong', NULL, '2026-08-10 02:28:24', '2026-08-10 02:34:36');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_06_16_123002_add_link_minh_chung_to_thanh_tuu_table', 1),
(2, '2026_06_17_080000_add_noi_bat_to_modules_tables', 2),
(3, '2026_06_18_013649_add_mo_ta_to_lich_cong_viec_table', 3),
(4, '2026_06_18_022500_create_dich_vu_ca_nhan_table', 4),
(5, '2026_06_18_023000_add_phan_loai_to_dich_vu_ca_nhan_table', 5),
(6, '2026_06_18_100000_add_trang_thai_to_dich_vu_ca_nhan_table', 6),
(7, '2026_06_18_150000_create_nhat_ky_hoat_dong_table', 7),
(8, '2026_06_18_160000_create_thong_bao_table', 8),
(9, '2026_06_18_085749_add_thong_bao_bat_to_nguoi_dung_table', 9),
(10, '2026_06_18_085844_create_dong_gop_y_kien_table', 10),
(11, '2026_06_18_090613_change_loai_thong_bao_column_name_in_thong_bao_table', 11),
(12, '2026_06_13_054504_add_url_tap_tin_to_chung_chi_table', 12),
(13, '2026_06_16_071230_add_vai_tro_to_du_an_table', 12),
(14, '2026_06_17_090000_add_noi_bat_to_skills_tables', 12),
(15, '2026_06_18_170000_cleanup_unused_tables_and_columns', 12),
(16, '2026_06_20_072228_add_hoat_dong_cuoi_to_nguoi_dung_table', 13),
(17, '2026_06_20_072238_create_truy_cap_table', 13),
(18, '2026_06_20_073606_add_lock_fields_to_nguoi_dung_table', 14),
(19, '2026_06_20_074500_alter_trang_thai_in_nguoi_dung_table', 15),
(20, '2026_06_21_090000_add_trang_thai_duyet_to_dich_vu_ca_nhan_table', 16),
(21, '2026_06_23_142054_add_file_pdf_to_chung_chi_table', 17),
(22, '2026_07_10_091805_create_password_resets_table', 18),
(23, '2026_08_04_100000_add_ke_hoach_to_nguoi_dung_table', 19),
(24, '2026_08_10_100000_alter_nguoi_dung_columns_for_encryption', 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ngon_ngu_lap_trinh`
--

DROP TABLE IF EXISTS `ngon_ngu_lap_trinh`;
CREATE TABLE IF NOT EXISTS `ngon_ngu_lap_trinh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_ngon_ngu` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_ngon_ngu_lap_trinh` (`ten_ngon_ngu`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `ngon_ngu_lap_trinh`
--

INSERT INTO `ngon_ngu_lap_trinh` (`id`, `ten_ngon_ngu`) VALUES
(13, 'C#'),
(6, 'C++'),
(19, 'Docker'),
(8, 'Go'),
(5, 'HTML/CSS'),
(1, 'Java'),
(3, 'JavaScript'),
(11, 'Kotlin'),
(20, 'Kubernetes'),
(16, 'Next.js'),
(18, 'Node.js'),
(7, 'PHP'),
(2, 'Python'),
(14, 'React'),
(9, 'Ruby'),
(12, 'Rust'),
(17, 'Spring Boot'),
(21, 'SQL'),
(10, 'Swift'),
(4, 'TypeScript'),
(15, 'Vue.js');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

DROP TABLE IF EXISTS `nguoi_dung`;
CREATE TABLE IF NOT EXISTS `nguoi_dung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_nguoi_dung` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ho_ten` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mat_khau` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `so_dien_thoai` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `dia_chi` text COLLATE utf8mb4_unicode_ci,
  `chuc_danh` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gioi_thieu` text COLLATE utf8mb4_unicode_ci,
  `anh_dai_dien` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vai_tro` enum('quan_tri','nguoi_dung') COLLATE utf8mb4_unicode_ci DEFAULT 'nguoi_dung',
  `trang_thai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'hoat_dong',
  `thong_bao_bat` tinyint(1) NOT NULL DEFAULT '1',
  `ngay_xoa` timestamp NULL DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ngay_cap_nhat` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ma_khoi_phuc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `han_ma_khoi_phuc` datetime DEFAULT NULL,
  `so_thich` text COLLATE utf8mb4_unicode_ci,
  `ke_hoach` text COLLATE utf8mb4_unicode_ci,
  `hoat_dong_cuoi` timestamp NULL DEFAULT NULL,
  `ly_do_khoa` text COLLATE utf8mb4_unicode_ci,
  `ngay_khoa` timestamp NULL DEFAULT NULL,
  `khoa_den` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `ma_nguoi_dung` (`ma_nguoi_dung`),
  KEY `idx_nguoidung_xoa` (`ngay_xoa`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ma_nguoi_dung`, `ho_ten`, `email`, `mat_khau`, `so_dien_thoai`, `ngay_sinh`, `dia_chi`, `chuc_danh`, `gioi_thieu`, `anh_dai_dien`, `vai_tro`, `trang_thai`, `thong_bao_bat`, `ngay_xoa`, `ngay_tao`, `ngay_cap_nhat`, `ma_khoi_phuc`, `han_ma_khoi_phuc`, `so_thich`, `ke_hoach`, `hoat_dong_cuoi`, `ly_do_khoa`, `ngay_khoa`, `khoa_den`) VALUES
(1, 'eyJpdiI6Inc4TVJNalY5UHVuK0Exbmx3dnVsVEE9PSIsInZhbHVlIjoiWGJ3L0NKRFBrYWN6MDZCMWFpbmRjQT09IiwibWFjIjoiOWM1NWNiNWZjZmE0YzA0OGU4OGYxMjk0ODk5NjFhOTE2NjcxMTFmZWRlNDUyYjIwMGQyMTkyM2U0ZjU2NjcyNyIsInRhZyI6IiJ9', 'eyJpdiI6IjQ1cER0SGEwRjdjSDBRMUNVZEV1NGc9PSIsInZhbHVlIjoia1B4QnF6L1RTVFZhTEhpNDVYNWJOMGZndlZJTStTU1NPb0RSR01QQU1ZOD0iLCJtYWMiOiI2MmFjOWM0YzU2Njc0MGE5ZGVmY2U0M2RlOGYyYjk5YTliMzdlYmUxYTQwZmZmNDc3YzRhYjcxOTgyMzczZjliIiwidGFnIjoiIn0=', 'test@gmail.com', '$2y$10$phIUBt/vgvi6dgLSAtVbaOkU2DQ/v.nzkEBIvTB0ajY4sTsmLPTJi', 'eyJpdiI6IlRDRTBIWjFlbVlqL0lwYUw2c3hzRFE9PSIsInZhbHVlIjoiVFR6bjJiRlA2cTV0TzVnNHhabUQ0UT09IiwibWFjIjoiZjkwY2M5MzI2YWZmZjNiMWYzY2RkNmE5NmQzZWE1MWI3NjY2MDZiNDNhNTMzMDJhYjZkZTU0MWFiNGY1NTE4NyIsInRhZyI6IiJ9', '2000-01-01', 'eyJpdiI6InRKUWs1RlZ4ZUYza1R3OER1K2Rzd0E9PSIsInZhbHVlIjoiNnA3M3BjeVRickRoUmVKcE5uQ3d4YTR4QVZZN3ZxbDNsTndxTTlsUGlFRT0iLCJtYWMiOiIwODUzYzI4YzY4NmFhZmE3YjYwNTg1NWEwNTg5NjkxY2MxYzNiNGI5NDE2NjM5MDMxMDZlNWUwYTY0MGUxYzg2IiwidGFnIjoiIn0=', 'eyJpdiI6IlJXR0JjbkVBUTQveWVzLzFrQkpENnc9PSIsInZhbHVlIjoic3I3ODVkNlp2UzVGZzRKNEhSRjBwQT09IiwibWFjIjoiMjU0ZTYyMzZlNzk5N2ZhNTY4OTM3YjE4ZTQ5NTI5NjZlNGM0YWNmZjNmZmNiNjc2YWFmMmQzOGU2MGMwZjQ4NCIsInRhZyI6IiJ9', 'eyJpdiI6Im5yOFdaZzhjRFk0VGpCMjFKY1Fvb1E9PSIsInZhbHVlIjoic3FJQWlVM0RPc1pvUXNhR0xlY253WlMvMXFUSkpqSlFqYWQzaUdGZHRKMmNJMEgwMVdJNkRVRmVvZXA0Z2FKMTVvYXI4a1Z4aGhEUDNoNGZrOGRJcnc9PSIsIm1hYyI6IjBkYWU0ZDliZTliODZhNzViMjgwYmU0MzhiZmRiNzA2NThhOTU1ZjM1ZGI0OWVmZmZmZWJlMTViOGNmMzA1YzkiLCJ0YWciOiIifQ==', NULL, 'nguoi_dung', 'hoat_dong', 1, NULL, '2026-06-20 01:54:44', '2026-08-10 02:50:23', NULL, NULL, NULL, NULL, '2026-07-14 21:03:04', NULL, NULL, NULL),
(2, 'eyJpdiI6Ikw3OFRFRkxxMWVXdWs4cit4Si85L1E9PSIsInZhbHVlIjoiYmcrSVJWQTljTXFtY3Qyd1pqVy9Sdz09IiwibWFjIjoiMjk4NjNkOGY0MTM2MzA2MjkwNGM3YmE3OWEzMmNlY2Y2MmE0ZWRjM2Q0YTgzNTc5MTJkNzcxNDZmYmMzMWI1ZCIsInRhZyI6IiJ9', 'eyJpdiI6ImU0bko0Y3QwM0VZUlRVQ290S2ptN0E9PSIsInZhbHVlIjoiN2dpVWtmWkRXKzdlV3hIaDB2Y0ZZNUdOTks0ZkhiM2Erck9obGVsamdvND0iLCJtYWMiOiI5N2MxN2UyMzhjNmM5MzNmNThhNmQ2ZDViMmI5YmFhMzE4ZDk4YjA1MDMyMTkyYjdjNzEwZWU1OTFjMmYzM2VjIiwidGFnIjoiIn0=', 'nguoidunga@gmail.com', '$2y$10$kIo.R7UOLxDGJwjBB6dt1e1yUWi2rvtfEOmN43oZ1Y7TSS2gHwBcu', 'eyJpdiI6ImZtanJRdjhvVWQwK0xPM3ViZm8vZFE9PSIsInZhbHVlIjoiY3ZoM2RWeXVLV3A4anhJKzNOUU1ldz09IiwibWFjIjoiODgyMWUzNTYyZWM2N2MwNjNiMTQ1YmJkZWYzNzBmODBiZWY2ZTc4M2UwNzZkODgxY2RiYjExNWVlY2E4M2M1YyIsInRhZyI6IiJ9', '2000-01-01', 'eyJpdiI6IkR6bE14V080ZSt3emd5OUVmbExieEE9PSIsInZhbHVlIjoieURNZlI3QUg3SUxFRmFITHFnZ3JkV3FUdmVRdjh6YTZGdVdDY0JtbUJUST0iLCJtYWMiOiI1YTcyNDU3ZjJmY2JkNmYyNTZkYWRlMjk4NjFiMjE4MWUwY2QwNjllNTM5NGE5NjkxNjc2ZTZiN2ViZjM1MzM1IiwidGFnIjoiIn0=', 'eyJpdiI6Ii9oQVpDenNxS2FpaU9KQy80M09KclE9PSIsInZhbHVlIjoiNXJQZklyUGIvQXVRUUkycmM0dWxyTHVLT1VacFJVWWx1TnRxQ1J6cVcvND0iLCJtYWMiOiI0ZDBkOTA1YzIxNGIwZGQ3OWJjNmZjOTNhODU3MmM2Y2UzOTY4OGQyMzdkZGRmNTkxNzBkMWUwYThmOTljNWE1IiwidGFnIjoiIn0=', 'eyJpdiI6InNaY0JIcXJwNEtwTk5pWjBqdVBtYXc9PSIsInZhbHVlIjoicGlyTkJXdjlqSlN1NDUrMTVtUDF6U0dXSTZ0Y2t3QllNSlhLdFExY2RTbmU3bm1oRUdHRSswOW1mN0xmQXhhREFNT251dnpCVExNNG5DdTFiS284cFV6MkpBejlwT3F0V2hmNXJjSWdzQktXZktVL28wYXhyK2xXZDR0MmlNeVN1UzI2N3g1eVNPRmJrVkVzQm1vMFJTZGhKUVlCVWVRNTloVEZsTW1BS3UwWnV6YkFia1lSMktobTNWRE5UTVk1aG1pRVNjUVIxVjJEMC9nQjhLVWhKZz09IiwibWFjIjoiNzFlYmI4ZTMwOTJkNWZlOWE2NTZiM2U2NzVlMWVlNTRhNDBmMmI0NGMxYmQwODM5ODY3NmUzMGFhODFiM2ZjOCIsInRhZyI6IiJ9', NULL, 'nguoi_dung', 'hoat_dong', 1, NULL, '2026-06-20 01:54:44', '2026-08-10 02:50:23', NULL, NULL, NULL, NULL, '2026-08-03 02:16:03', NULL, NULL, NULL),
(3, 'eyJpdiI6ImxWZHVYUXoySzRMQk1LM1M4aDI0cWc9PSIsInZhbHVlIjoiTTl1bjJzbGZPYkoxMkRwdXVBa210Zz09IiwibWFjIjoiZjc2NjZhOTc1OWMwMzRlMTQ0M2I1ZWQxOWNhNzVjZGEzZGRkZjliNzgzZmY3OTMzY2RlMjE0YzJmYjU4ZWY0MiIsInRhZyI6IiJ9', 'eyJpdiI6IkRPQ2JkemFnWThla3EwZ2lya0dmYUE9PSIsInZhbHVlIjoiY2F4cU1LZ20vNGlVOGQ2Nk5USmMyaTlOSkZ0eTVRajA1ZSt4eW1idk5DQT0iLCJtYWMiOiI4ODNiZmZmYjU0ZTYwZDUwN2IwMmU4MGI5MjZlZWFlYzkxYzY0MzE2ZDYwOWI2OTA0MGI5ZTI0MzQyZDg2OTY5IiwidGFnIjoiIn0=', 'nguoidungb@gmail.com', '$2y$10$CKAfuzZRLgbz3lR5tPRgW.LhVXNOf8tsOODE64LhV4XuMa5A3nrc2', 'eyJpdiI6IlZXME1UWG9qRSszZEVjSkhrYzNFL2c9PSIsInZhbHVlIjoiZ1Nlc281cmppYTNkVFJ2YzBqcno2QT09IiwibWFjIjoiNzZjMTc4Y2YyZjEyODM5NDhlOWU1MTY1MmY1YzRkZGQ3MDZjMGJiYTNlNjA5MDZmODViNzFjNTI4OTQzMTYwZCIsInRhZyI6IiJ9', '2001-05-15', 'eyJpdiI6IlJUaUw1NGpvQUNxdFV4TFRuWlh6c2c9PSIsInZhbHVlIjoiald3QlNEYVVvNVJZVXRnRTAzUUFWR01aZzJUY1Jsd09tcUc0MUF4MU13cz0iLCJtYWMiOiJiZTY1NTEzYmRjOWM1MDNkOTY5ODNkZjRiNGY3YjZhMmEyMWYwNTA2MzA3YWQ1ZWExY2NhYzI3MDRmYjM1MjJmIiwidGFnIjoiIn0=', 'eyJpdiI6IjhVZ0d1V0VLYmtNazdlNERqdkpFSFE9PSIsInZhbHVlIjoicVFuSGFTeFQ5TUhscm9FV2YrU2YwSFR6cVZjTUs1dnlYeEFDS2xOU3ZLQ0pxdGlMZ3IyVU1zSlJ0Vit2dlh6OSIsIm1hYyI6IjRiNmI2YmI4MDcyMGRmZTUyNjRkYTFmMzJjNmY0ZDczMmM0NmI0ZjNjYWI3ODMxZWJjYjUwZjVmMDA4NjgzNjMiLCJ0YWciOiIifQ==', 'eyJpdiI6IlViS1Z0ZVdURk80VTNCVE13b0tXWEE9PSIsInZhbHVlIjoiSmY2ZEJUOFVKTVFMaENVbHJ1RGd3YXBzY0xNaWllY1UzbjR1R0dNMEF0NHNKNENUVlFZYWJTRVdTK2g0RG9nNFpabTQ5dEt5bVFUNHVIeU9XR0YxSStwRDlScEY3WDVxUk1tOVo5VGc4N0hUZStsVEhROCtESldaT3RSRkV5clNidHFFSEpzNjJWUkp5WlQwZE9JTFVVeUZOQlpzemtFR3FSUU9DSWFGRXcybWwzV1JoMEJ4c2RqelNOV0JwRG1OMHNaSjEvcWx1eThlc1lUemRyWDRNUT09IiwibWFjIjoiMWM1ZmFiYTMwZjhiMmU5MWI3ZDlmMWQ5YmQ1NzNkZmI1YjZlMzhlODBmOTI1NTI4YmZkODgyM2IyMjcyYTBmNiIsInRhZyI6IiJ9', NULL, 'nguoi_dung', 'hoat_dong', 1, NULL, '2026-06-20 01:54:44', '2026-08-10 02:50:23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'eyJpdiI6ImkvUDhUakpnUGRZc3VLZXhKMm80akE9PSIsInZhbHVlIjoieTVScGJqanVJOXRDczFSRlhCSVlldz09IiwibWFjIjoiMjg4NzYzZDU2OTI0ODMwOTA2NTA2MDgzZWIyNDE0Y2ViMWVkODE1ZjExZTVjYjdhYWFiMTA3ZTIzNTNmNWMwNyIsInRhZyI6IiJ9', 'eyJpdiI6Im1zOGIrUmhIcmZFRGxRZ0NYb3ArN2c9PSIsInZhbHVlIjoiM3UveFoxYUVxUU03SFJXRC9GbDkvWmhtWFAxNHRPbVVVZm1hM3NzUlo4UT0iLCJtYWMiOiI1NDkxNDZjYjBmZjRkOTY4ZDc4MDUwOTRlMDczMDg5YjRjMmIzMGEwNGMzMGVlNzAxODQ5NzFhNjZkNzA5ODk1IiwidGFnIjoiIn0=', 'admin@gmail.com', '$2y$10$727KjrSUZrHDvZCGw9W5l.ohumw0vCL0ac4ELBmlWDJ7UNaeTp3QO', 'eyJpdiI6ImdaZHJsUGN4WktTSnRqSEpQZzI0WHc9PSIsInZhbHVlIjoiVFRuK2dOdWtFWnFLTGJlRFJKSnQydz09IiwibWFjIjoiMjNiMzY4NjQzNmE3OGMwNDc0N2NhMjgxZTFjZjYwMjFlNzEzODJiNWNiZTkyZmZiZWI1MzRiY2ZhZmJlZTc2NCIsInRhZyI6IiJ9', '1995-10-10', 'eyJpdiI6IkRNVENJSG9zc2hIeVJESmVRU3pyU0E9PSIsInZhbHVlIjoiS2tvZlVjdjRyT1lYak83SkcyZXNnc3ZQUWkyQXhQSU1WanpqT2JTMWc5ND0iLCJtYWMiOiI0M2JjYWMwY2M2NTQ0OGEwYjI2MDI2ZGRlM2JlOTQwY2UwNmJhM2M1NzVmNWY1ZDYxY2E2ZjA0NjI4MDU1ZjUxIiwidGFnIjoiIn0=', 'eyJpdiI6IkMwOWtMOXgyempQejh5YUtFYmYrT3c9PSIsInZhbHVlIjoiQjliekRoYVFNTW5RbDNnQTVxMzV6OEFGUGp3dTVoUlZuL2JrZjU0dGpiUT0iLCJtYWMiOiI1NzQzZjBmM2ZkMjVhMDkxYjJiZmMwNTJhNTJlYzUxOWRiNzAxNTFlNzU5OTYzNDMxNDUxOTZiZGFhNTcyZDNlIiwidGFnIjoiIn0=', 'eyJpdiI6Im05ZFV6cGYyRmtSY3lndG9reDZ6MUE9PSIsInZhbHVlIjoiR0lVUnk1KzJlY0dTNXdmVEQ2YldtczNhKzhFZWQwckZadldXZDB5U00yNC9pVjZsVGl4RGRKeWlTUlRyNHBsZXV1V250UXhnUHRZN0s5aVlvTnZoYjhVUkkrb1E5RXJkOFRCS05HODZpUDVSc202dDNSeVA1SUJBWHFta2kzOEJCcXhRMEJFNTdUL3hzYzBRcllRMlNBPT0iLCJtYWMiOiIyOGJjZWFkOTk4NWI2ZWQ5MjNiNWVkZWIyNjlmMDdlN2M1YjQzNWNjMWJlZjdhNmI2OGU2YjlhNWRhNjY0M2NmIiwidGFnIjoiIn0=', NULL, 'quan_tri', 'hoat_dong', 1, NULL, '2026-06-20 01:54:44', '2026-08-11 00:28:50', NULL, NULL, NULL, NULL, '2026-08-10 17:28:50', NULL, NULL, NULL),
(5, 'eyJpdiI6IlNjMllNNC9XazEveS9hRko1ajBhOFE9PSIsInZhbHVlIjoieWw4Tk01dGpmclVsYW5JeEI2eUtqbXVlVnFGQTRJTERNRXBQUXlVNlN4dz0iLCJtYWMiOiI5OGUyNDJhMDJlYTVlYWQwNDc3ZjI3MjBhNjZiMmNiY2FlYTk0YWVhZjEwZTAwYzNiYzE3ZmVhZWZhZWU1OGQ2IiwidGFnIjoiIn0=', 'eyJpdiI6IktWNnZ5QTJ0dTlHSTh2ajhVNjdnSFE9PSIsInZhbHVlIjoiNmZlTmlBOUNWSm84Ni9XVU5SME1zNUI1RDlqYXdGRjlSL0ErYmVsNFRJYz0iLCJtYWMiOiIwYmFjNWU1NGRiMjE2MDQyY2VkYWFjYjg4NTcyNTk1NmE1MzAyNGQ5MGFmYWQ1Mjc1MzJjMzExNjA0ZjBjZmY2IiwidGFnIjoiIn0=', 'nguyenhai281104@gmail.com', '$2y$10$9SmGyUOxMEgUHKAb84c.E.dSApe55rTXovtJZUOgyXtAHwXyaakt2', 'eyJpdiI6ImtkSERXWmVNR0tsVFcrSVFhMU9kdGc9PSIsInZhbHVlIjoiSm1LT2R2djgyaldVSVowbkp2a1FaQT09IiwibWFjIjoiN2NmZDRjODYxODhlMDBjMjNjYjM5OWJhZGQ0YjE1NTBhODQ5NjU0NGRmZmU5NDM0ZWYyMmE2NGE0YmI0ZmZkYiIsInRhZyI6IiJ9', '2004-11-28', 'eyJpdiI6IkV4NzRVaEh4SGxYVTI2M2x2a081Snc9PSIsInZhbHVlIjoiRW96dExJSm1vcDhBT2M0cEFLZCtiSURTcktJMmN1Z1FFYVlSVDVOL0l0Zz0iLCJtYWMiOiJmNDI5Y2NjNjQzNDQ2NzhkYTMxNTg5NGZiZGM0YTg2ODc0NDAxNzRjYmU4NzdjNGVjNzc4MzBlOGVhZTBjMzdlIiwidGFnIjoiIn0=', 'eyJpdiI6IlRua09ueFYxUTQ4UzQ4UFRjYWtCeGc9PSIsInZhbHVlIjoiTG96VU9LOXduNUk3eW1BZjRwRkYzVmpZM1dtdVN0Yzh0c1hHcUdVVTl1RT0iLCJtYWMiOiJkMDJiOGVkYmI0Y2UyYTA1ZThkMzcwNjE5YmNmNDZlNDA1NDBlYjYxYTZlMTg3MWUwY2EyMDNmNzQ2NzUwNjFkIiwidGFnIjoiIn0=', 'eyJpdiI6IkxLbFhvQlJyN20yc1BwL2JwMUxVRUE9PSIsInZhbHVlIjoiM2I5Z3lBR0dsYnhjQjBReVJiUjNnK205RzdhK2lRSFRGY1ZDbVpOZVBTdUJ4TVNpT3VUdFpjU1Y5R1llMFhuWUlleWNpaHRDU2oxT2w5SGdnbHZqbWlXdnNTVk5HQUNvUFhMd1Z3K01ocllReFl5UFFUc0hqc1Q1MloxTXRXTTNNUmczblNXOFJub3VSZmhGVG9acHFSbjhZVjVUNVhFSllRMmxKNUpiRGNGV3BaUURNdTQ1YWZSMFRibG9ndTVIbGc4OWVIOTJkVWNlcHlLRUE5eTVtN1dvaWZtMlVJR2FPU0JPNHNOVlRDNmsyZnpHb0o0QWlVRHM0WUxjb0JQVG0yVncraHFHL1RLaVZRNHM5TUxTZ2tqU1lRZkhOSEZYNlEwZnJXbGxlNVNUcngzSkZ0U05VYU1zUWFhbjNRZVdvRkZCQ2dUZWdTc1Y0UUFqVzY3M2JBPT0iLCJtYWMiOiIzOGM2MjdiYmNhNDdiYTQxY2JkNDI0YTljODc5Nzc3NmU1YjllODMxNmMxNjUzM2M1ZmIxZWVkYTkzYTg1MjBhIiwidGFnIjoiIn0=', 'eyJpdiI6IkZnMk1uZ0ZKYWo3ZGp6R1pWQndwRVE9PSIsInZhbHVlIjoiMUdsREJuSnZ2VnNDQUtYa05SUlluOVFQa0dpWVgra2ZpMi9scXBhSkw5S05UaXlMNU81NFkwcTJ3dFpNUVVuUHRndkg4RnFpdUt0cmMvbEQrUUY5Q3c9PSIsIm1hYyI6ImRmMmU0NzFhYTU2NTU4ZmRmYTQ0Nzk4YTY2YmRmMDg1NjU5NzI1MWFlZDNhMDkyZTllNWIzYTc2YzUyY2Q4MGIiLCJ0YWciOiIifQ==', 'nguoi_dung', 'hoat_dong', 1, NULL, '2026-08-04 05:19:52', '2026-08-10 12:32:47', NULL, NULL, 'eyJpdiI6Ii9HWjBVaGdLeFJjNnhlUXdJTkFkY2c9PSIsInZhbHVlIjoiQXNxK0pSeWViZm5tK0VLc24vcTh1MXROL0s4UCtxZnpnSm1iazVxMWdkOD0iLCJtYWMiOiI1NjEwOWM1OWMzNmZjOTMwMzI5N2QwM2NjYmNkM2UyYjk2ZjBiZGNmYjc3NjhmNDA5MDRiY2ViZDA5ZDA1NzhlIiwidGFnIjoiIn0=', 'eyJpdiI6InB0aWxPemRyUjg1Q3hUVmt5WlN6K3c9PSIsInZhbHVlIjoiNU8rcEhOTXJJWGZGVzRsTkdDTWZkSXMxMllYZkFGdlNFQ0N0SUxUeTZsZHRXY3BSZ2d4STdhOVBEc09ta29GeCIsIm1hYyI6IjU0YTQyYjM5OWUyNDJkMjkwNTQ0YjJmMTJlNjI1NzJjNzQ4NzRhODAzN2Q0NmU2NTYyY2UzMWYxYThmOTk2MTkiLCJ0YWciOiIifQ==', '2026-08-10 05:32:47', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung_ky_nang_mem`
--

DROP TABLE IF EXISTS `nguoi_dung_ky_nang_mem`;
CREATE TABLE IF NOT EXISTS `nguoi_dung_ky_nang_mem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nguoi_dung_id` int(11) NOT NULL,
  `ky_nang_mem_id` int(11) NOT NULL,
  `noi_bat` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_ndknm` (`nguoi_dung_id`,`ky_nang_mem_id`),
  KEY `fk_ndknm_ky_nang_mem` (`ky_nang_mem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung_ky_nang_mem`
--

INSERT INTO `nguoi_dung_ky_nang_mem` (`id`, `nguoi_dung_id`, `ky_nang_mem_id`, `noi_bat`) VALUES
(1, 2, 16, 1),
(2, 2, 10, 1),
(3, 2, 4, 1),
(4, 2, 11, 0),
(5, 2, 15, 0),
(26, 5, 17, 1),
(27, 5, 22, 1),
(28, 5, 14, 1),
(29, 5, 5, 0),
(30, 5, 20, 0),
(31, 5, 9, 0),
(32, 5, 16, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung_ngon_ngu_lap_trinh`
--

DROP TABLE IF EXISTS `nguoi_dung_ngon_ngu_lap_trinh`;
CREATE TABLE IF NOT EXISTS `nguoi_dung_ngon_ngu_lap_trinh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nguoi_dung_id` int(11) NOT NULL,
  `ngon_ngu_lap_trinh_id` int(11) NOT NULL,
  `noi_bat` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_ndnnlt` (`nguoi_dung_id`,`ngon_ngu_lap_trinh_id`),
  KEY `fk_ndnnlt_ngon_ngu` (`ngon_ngu_lap_trinh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung_ngon_ngu_lap_trinh`
--

INSERT INTO `nguoi_dung_ngon_ngu_lap_trinh` (`id`, `nguoi_dung_id`, `ngon_ngu_lap_trinh_id`, `noi_bat`) VALUES
(3, 2, 8, 1),
(4, 2, 5, 1),
(5, 2, 17, 1),
(6, 2, 19, 0),
(7, 2, 12, 0),
(8, 2, 10, 0),
(32, 5, 13, 1),
(33, 5, 6, 1),
(34, 5, 19, 1),
(35, 5, 21, 1),
(36, 5, 8, 0),
(37, 5, 5, 0),
(38, 5, 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhat_ky_hoat_dong`
--

DROP TABLE IF EXISTS `nhat_ky_hoat_dong`;
CREATE TABLE IF NOT EXISTS `nhat_ky_hoat_dong` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` bigint(20) UNSIGNED NOT NULL,
  `loai_hoat_dong` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_dia_chi` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thiet_bi` text COLLATE utf8mb4_unicode_ci,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `nhat_ky_hoat_dong_id_nguoi_dung_foreign` (`id_nguoi_dung`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nhat_ky_hoat_dong`
--

INSERT INTO `nhat_ky_hoat_dong` (`id`, `id_nguoi_dung`, `loai_hoat_dong`, `mo_ta`, `ip_dia_chi`, `thiet_bi`, `ngay_tao`) VALUES
(68, 5, 'chinh_sua', 'Đã chuyển dự án \'Hệ thống Quản lý Hồ sơ Cá nhân & Tạo CV Tự động\' sang chế độ nổi bật', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 22:47:55'),
(3, 4, 'chinh_sua', 'Đã xóa ý kiến đóng góp ID: 1', '127.0.0.1', 'Symfony', '2026-07-14 21:02:58'),
(67, 5, 'chinh_sua', 'Đã chuyển dự án \'Hệ thống Quản lý Hồ sơ Cá nhân & Tạo CV Tự động\' sang chế độ thường', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 22:47:54'),
(65, 5, 'truy_cap', 'Đăng nhập thành công vào hệ thống', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0', '2026-08-03 22:02:27'),
(66, 5, 'chinh_sua', 'Cập nhật thông tin kinh nghiệm làm việc và dự án mới', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0', '2026-08-03 22:37:27'),
(61, 2, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-08-03 01:50:40'),
(60, 2, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-08-02 23:16:02'),
(15, 4, 'chinh_sua', 'Đã thêm ngôn ngữ lập trình mới: TestLangPhp', '127.0.0.1', 'Symfony', '2026-07-14 21:03:00'),
(16, 4, 'chinh_sua', 'Đã thêm ngôn ngữ lập trình mới: TestLangClean', '127.0.0.1', 'Symfony', '2026-07-14 21:03:00'),
(17, 4, 'chinh_sua', 'Đã cập nhật ngôn ngữ lập trình từ \"TestLangOld\" thành \"TestLangNew\"', '127.0.0.1', 'Symfony', '2026-07-14 21:03:00'),
(18, 4, 'chinh_sua', 'Đã xóa ngôn ngữ lập trình: TestLangPhp', '127.0.0.1', 'Symfony', '2026-07-14 21:03:00'),
(19, 4, 'chinh_sua', 'Đã thêm kỹ năng mềm mới: TestSkillCommunication', '127.0.0.1', 'Symfony', '2026-07-14 21:03:00'),
(20, 4, 'chinh_sua', 'Đã cập nhật kỹ năng mềm từ \"TestSkillOld\" thành \"TestSkillNew\"', '127.0.0.1', 'Symfony', '2026-07-14 21:03:00'),
(21, 4, 'chinh_sua', 'Đã xóa kỹ năng mềm: TestSkillComm', '127.0.0.1', 'Symfony', '2026-07-14 21:03:00'),
(59, 2, 'truy_cap', 'Đã xem danh sách nhật ký hoạt động cá nhân', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-26 21:32:48'),
(58, 2, 'chinh_sua', 'Đặt CV làm CV chính: CV của tôi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-26 21:27:37'),
(57, 2, 'chinh_sua', 'Đặt CV làm CV chính: cv tự động', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-26 21:27:32'),
(56, 2, 'chinh_sua', 'Cập nhật thông tin CV: cv tự động', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-26 21:25:19'),
(55, 2, 'chinh_sua', 'Tạo mới CV: cv tự động', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-26 21:18:12'),
(54, 2, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', '2026-07-26 21:08:04'),
(53, 29, 'bao_mat', 'Đổi mật khẩu thành công qua chức năng Quên mật khẩu', '127.0.0.1', 'Symfony', '2026-07-14 21:03:04'),
(52, 1, 'chinh_sua', 'Thêm mới thành tựu: Học bổng Khuyến khích học tập', '127.0.0.1', 'Symfony', '2026-07-14 21:03:04'),
(51, 1, 'chinh_sua', 'Thêm mới thành tựu: alert(\"xss\")Giải Nhất', '127.0.0.1', 'Symfony', '2026-07-14 21:03:04'),
(49, 1, 'bao_mat', 'Đã xóa toàn bộ lịch sử nhật ký hoạt động', '127.0.0.1', 'Symfony', '2026-07-14 21:03:04'),
(50, 1, 'chinh_sua', 'Thêm mới thành tựu: Giải Nhất Hackathon @#$%^&*()_+ 2026', '127.0.0.1', 'Symfony', '2026-07-14 21:03:04'),
(40, 4, 'chinh_sua', 'Đã thêm mới mẫu CV: Mẫu Sáng Tạo Test (test_tpl_creative)', '127.0.0.1', 'Symfony', '2026-07-14 21:03:03'),
(41, 4, 'chinh_sua', 'Đã cập nhật mẫu CV: Tên Cập Nhật (test_tpl_update)', '127.0.0.1', 'Symfony', '2026-07-14 21:03:03'),
(42, 4, 'chinh_sua', 'Thay đổi trạng thái mẫu CV Mẫu Toggle Status sang Tạm ẩn', '127.0.0.1', 'Symfony', '2026-07-14 21:03:03'),
(43, 4, 'chinh_sua', 'Đã xóa mềm mẫu CV: Mẫu Sắp Xóa', '127.0.0.1', 'Symfony', '2026-07-14 21:03:03'),
(69, 5, 'chinh_sua', 'Cập nhật ảnh đại diện mới', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 22:48:28'),
(70, 5, 'chinh_sua', 'Cập nhật thành tựu: Học bổng Khuyến khích Học tập Loại Xuất sắc', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 22:52:57'),
(71, 5, 'chinh_sua', 'Cập nhật thành tựu: Giải Nhì cuộc thi Hackathon CNTT Toàn quốc 2024', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 22:55:13'),
(72, 5, 'chinh_sua', 'Cập nhật album ảnh nổi bật: Kỷ niệm bảo vệ luận văn tốt nghiệp 2024', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 22:59:07'),
(73, 5, 'chinh_sua', 'Cập nhật album ảnh nổi bật: Kỷ niệm bảo vệ luận văn tốt nghiệp 2024', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:00:12'),
(74, 5, 'chinh_sua', 'Tạo mới CV: CV của tôi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:02:40'),
(75, 5, 'chinh_sua', 'Đăng ký dịch vụ cá nhân mới (chờ duyệt): Xây dựng hệ thống crm online', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:05:38'),
(76, 4, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:10:34'),
(77, 5, 'chinh_sua', 'Cập nhật thông tin cơ bản: Nguyễn Hoàng Hải', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:11:39'),
(78, 4, 'chinh_sua', 'Admin duyệt dịch vụ: Xây dựng hệ thống crm online (ID: 213)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:12:10'),
(79, 5, 'truy_cap', 'Đã xem danh sách nhật ký hoạt động cá nhân', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:19:41'),
(80, 5, 'truy_cap', 'Đã xem danh sách nhật ký hoạt động cá nhân', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-03 23:21:06'),
(81, 5, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:32:45'),
(82, 5, 'chinh_sua', 'Cập nhật ảnh đại diện mới', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:35:11'),
(83, 5, 'chinh_sua', 'Cập nhật kỹ năng chuyên môn', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:35:47'),
(84, 5, 'chinh_sua', 'Cập nhật kỹ năng chuyên môn', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:37:59'),
(85, 5, 'chinh_sua', 'Xóa học vấn: Bằng Tốt nghiệp THPT', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:39:11'),
(86, 5, 'chinh_sua', 'Đã chuyển dự án \'Ứng dụng Quản lý Tài chính Cá nhân Thông minh\' sang chế độ thường', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:39:44'),
(87, 5, 'chinh_sua', 'Đã chuyển dự án \'Ứng dụng Quản lý Tài chính Cá nhân Thông minh\' sang chế độ nổi bật', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:39:46'),
(88, 5, 'truy_cap', 'Đã xem danh sách nhật ký hoạt động cá nhân', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:45:15'),
(89, 5, 'chinh_sua', 'Tạo mới CV: sdasdas', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:46:08'),
(90, 5, 'chinh_sua', 'Cập nhật thông tin CV: sdasdas', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:46:57'),
(91, 5, 'chinh_sua', 'Tạo mới CV: cvtd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:47:33'),
(92, 5, 'chinh_sua', 'Đặt CV làm CV chính: cvtd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:48:39'),
(93, 5, 'chinh_sua', 'Cập nhật thông tin CV: cvtd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:56:04'),
(94, 5, 'bao_mat', 'Đã mã hóa bảo mật mật khẩu cho hồ sơ PDF', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:56:56'),
(95, 5, 'bao_mat', 'Đã mã hóa bảo mật mật khẩu cho hồ sơ PDF', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 01:58:03'),
(96, 4, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 02:00:02'),
(97, 5, 'chinh_sua', 'Cập nhật thông tin cơ bản: Nguyễn Hoàng Hải', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 02:29:14'),
(98, 5, 'chinh_sua', 'Cập nhật thông tin cơ bản: Nguyễn Hoàng Hải', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-04 02:30:51'),
(99, 5, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 01:00:36'),
(100, 5, 'chinh_sua', 'Xóa CV: CV Ứng tuyển IT Support - Nguyễn Hoàng Hải', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 01:43:49'),
(101, 5, 'chinh_sua', 'Xóa CV: CV Ứng tuyển IT Support', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 01:47:09'),
(102, 5, 'bao_mat', 'Đăng xuất khỏi hệ thống', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:11:03'),
(103, 4, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:11:19'),
(104, 4, 'chinh_sua', 'Đã thêm mới mẫu CV: 21323123123 (mau_thu3)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:28:24'),
(105, 4, 'bao_mat', 'Đăng xuất khỏi hệ thống', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:30:08'),
(106, 5, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:30:20'),
(107, 5, 'chinh_sua', 'Tạo mới CV: 1231231', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:30:35'),
(108, 4, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:31:58'),
(109, 4, 'chinh_sua', 'Đã cập nhật mẫu CV: Mẫu 3 (mau_thu3)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:34:36'),
(110, 5, 'chinh_sua', 'Xóa CV: 1231231', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:34:48'),
(111, 5, 'chinh_sua', 'Tạo mới CV: mẫu 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:35:02'),
(112, 5, 'chinh_sua', 'Cập nhật thông tin CV: mẫu 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:35:41'),
(113, 5, 'chinh_sua', 'Xóa CV: mẫu 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:37:33'),
(114, 5, 'chinh_sua', 'Tạo mới CV: mẫu 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:37:43'),
(115, 5, 'chinh_sua', 'Cập nhật thông tin CV: mẫu 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:37:53'),
(116, 5, 'chinh_sua', 'Cập nhật thông tin CV: mẫu 3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 02:38:33'),
(117, 5, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 05:32:46'),
(118, 4, 'bao_mat', 'Đăng nhập vào hệ thống thành công', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', '2026-08-10 17:28:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nguoidunga@gmail.com', 'XzMlaO17MiAGBcXTiQfaN6g0eb6IJJxj7Z1ff1iXl1TMB5VViaLavRWErA4D', '2026-07-10 02:20:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanh_tuu`
--

DROP TABLE IF EXISTS `thanh_tuu`;
CREATE TABLE IF NOT EXISTS `thanh_tuu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `noi_bat` tinyint(4) NOT NULL DEFAULT '0',
  `id_nguoi_dung` int(11) NOT NULL,
  `ten_thanh_tuu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_chuc_cap` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thoi_gian` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phan_loai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mo_ta` text COLLATE utf8mb4_unicode_ci,
  `anh_minh_hoa` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_minh_chung` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_nguoi_dung` (`id_nguoi_dung`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thanh_tuu`
--

INSERT INTO `thanh_tuu` (`id`, `noi_bat`, `id_nguoi_dung`, `ten_thanh_tuu`, `to_chuc_cap`, `thoi_gian`, `phan_loai`, `mo_ta`, `anh_minh_hoa`, `link_minh_chung`) VALUES
(72, 1, 1, 'Giải Nhất Cuộc thi Hackathon Techshow 2025', 'Tập đoàn VNG & Trường Đại học Bách Khoa TP.HCM', '25/04/2025', 'giai_thuong', 'Phát triển giải pháp nhà thông minh ứng dụng AI và IoT. Đoạt giải Nhất trên tổng số 50 đội dự thi từ các trường đại học khu vực phía Nam.', NULL, 'https://vng.com.vn'),
(73, 1, 1, 'Học bổng Khuyến khích học tập kỳ I (2024-2025)', 'Đại học Quốc gia TP.HCM (VNU-HCM)', '15/12/2024', 'hoc_bong', 'Đạt thành tích học tập xuất sắc với GPA 3.9/4.0, xếp hạng 2 toàn khoa Công nghệ Thông tin.', NULL, NULL),
(74, 0, 1, 'Sinh viên 5 Tốt cấp Thành phố', 'Hội Sinh viên Việt Nam - TP.HCM', '09/01/2025', 'danh_hieu', 'Đạt danh hiệu danh giá dành cho sinh viên xuất sắc hội tụ đủ 5 tiêu chuẩn: Học tập tốt, Đạo đức tốt, Thể lực tốt, Tình nguyện tốt và Hội nhập tốt.', NULL, NULL),
(75, 1, 2, 'Giải Nhất Cuộc thi Hackathon Techshow 2025', 'Tập đoàn VNG & Trường Đại học Bách Khoa TP.HCM', '25/04/2025', 'giai_thuong', 'Phát triển giải pháp nhà thông minh ứng dụng AI và IoT. Đoạt giải Nhất trên tổng số 50 đội dự thi từ các trường đại học khu vực phía Nam.', NULL, 'https://vng.com.vn'),
(76, 1, 2, 'Học bổng Khuyến khích học tập kỳ I (2024-2025)', 'Đại học Quốc gia TP.HCM (VNU-HCM)', '15/12/2024', 'hoc_bong', 'Đạt thành tích học tập xuất sắc với GPA 3.9/4.0, xếp hạng 2 toàn khoa Công nghệ Thông tin.', NULL, NULL),
(77, 0, 2, 'Sinh viên 5 Tốt cấp Thành phố', 'Hội Sinh viên Việt Nam - TP.HCM', '09/01/2025', 'danh_hieu', 'Đạt danh hiệu danh giá dành cho sinh viên xuất sắc hội tụ đủ 5 tiêu chuẩn: Học tập tốt, Đạo đức tốt, Thể lực tốt, Tình nguyện tốt và Hội nhập tốt.', NULL, NULL),
(78, 0, 3, 'Giải Nhất Cuộc thi Hackathon Techshow 2025', 'Tập đoàn VNG & Trường Đại học Bách Khoa TP.HCM', '25/04/2025', 'giai_thuong', 'Phát triển giải pháp nhà thông minh ứng dụng AI và IoT. Đoạt giải Nhất trên tổng số 50 đội dự thi từ các trường đại học khu vực phía Nam.', NULL, 'https://vng.com.vn'),
(79, 0, 3, 'Học bổng Khuyến khích học tập kỳ I (2024-2025)', 'Đại học Quốc gia TP.HCM (VNU-HCM)', '15/12/2024', 'hoc_bong', 'Đạt thành tích học tập xuất sắc với GPA 3.9/4.0, xếp hạng 2 toàn khoa Công nghệ Thông tin.', 'uploads/thanh-tuu/58c84d05-df68-4636-ba47-ce34d62fcbc3.jpg', NULL),
(80, 1, 3, 'Sinh viên 5 Tốt cấp Thành phố', 'Hội Sinh viên Việt Nam - TP.HCM', '09/01/2025', 'danh_hieu', 'Đạt danh hiệu danh giá dành cho sinh viên xuất sắc hội tụ đủ 5 tiêu chuẩn: Học tập tốt, Đạo đức tốt, Thể lực tốt, Tình nguyện tốt và Hội nhập tốt.', 'uploads/thanh-tuu/03375aa4-0364-40e3-a548-c1ef5c147ef0.jpg', NULL),
(82, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(83, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(84, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(86, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(87, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(88, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(90, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(91, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(92, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(94, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(95, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(96, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(98, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(99, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(100, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(102, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(103, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(104, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(106, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(107, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(108, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(110, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(111, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(112, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(114, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(115, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(116, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(118, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(119, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(120, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(122, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(123, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(124, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(126, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(127, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(128, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(130, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(131, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(132, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(134, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(135, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(136, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(138, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(139, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(140, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(142, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(143, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(144, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(146, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(147, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(148, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(150, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(151, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(152, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(154, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(155, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(156, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(158, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(159, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(160, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(162, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(163, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(164, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(166, 0, 1, 'Giải Nhất Hackathon @#$%^&*()_+ 2026', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(167, 0, 1, 'alert(\"xss\")Giải Nhất', NULL, NULL, 'giai_thuong', NULL, NULL, NULL),
(168, 0, 1, 'Học bổng Khuyến khích học tập', 'Khoa Công nghệ thông tin', 'Học kỳ I (2024 - 2025)', 'hoc_bong', 'Đạt thành tích học tập xuất sắc loại giỏi.', NULL, 'https://drive.google.com/some-file-link'),
(173, 1, 5, 'Giải Nhì cuộc thi Hackathon CNTT Toàn quốc 2024', 'Bộ Thông tin và Truyền thông', NULL, 'giai_thuong', 'Giải thưởng dành cho giải pháp \"Ứng dụng AI phân tích và cảnh báo an toàn giao thông đường bộ\".', 'uploads/thanh-tuu/a2e4d5ec-1f68-4270-9d8b-f894506e8ef9.jpg', NULL),
(174, 1, 5, 'Học bổng Khuyến khích Học tập Loại Xuất sắc', 'Đại học Bách Khoa Hà Nội', NULL, 'hoc_bong', 'Dành cho sinh viên có thành tích học tập và rèn luyện nằm trong TOP 1% của khóa.', 'uploads/thanh-tuu/c7aff94e-77d1-47b9-ac13-21a939c3f5c4.jpg', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thong_bao`
--

DROP TABLE IF EXISTS `thong_bao`;
CREATE TABLE IF NOT EXISTS `thong_bao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nguoi_dung` int(11) NOT NULL,
  `tieu_de` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noi_dung` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_lien_ket` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `loai` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `da_doc` tinyint(1) DEFAULT '0',
  `khoa_trung` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_tao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_thong_bao_user_da_doc` (`id_nguoi_dung`,`da_doc`),
  KEY `thong_bao_khoa_trung_index` (`khoa_trung`),
  KEY `thong_bao_id_nguoi_dung_da_doc_index` (`id_nguoi_dung`,`da_doc`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `thong_bao`
--

INSERT INTO `thong_bao` (`id`, `id_nguoi_dung`, `tieu_de`, `noi_dung`, `url_lien_ket`, `loai`, `da_doc`, `khoa_trung`, `ngay_tao`) VALUES
(1, 2, '🚀 Tài khoản kích hoạt thành công', 'Chào mừng bạn đến với Hệ thống quản lý hồ sơ cá nhân DPCS. Hãy bắt đầu tạo CV đầu tiên của mình ngay bây giờ.', NULL, 'he_thong', 0, 'welcome_user_2', '2026-06-20 01:54:44'),
(2, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 15:56 20/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-20 01:56:33'),
(3, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 16:49 21/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-21 02:49:58'),
(4, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 17:14 21/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-21 03:14:08'),
(5, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 13:17 23/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-22 23:17:06'),
(6, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 13:59 23/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-22 23:59:47'),
(7, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 20:43 24/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-24 06:43:37'),
(8, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 15:36 27/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-27 01:36:03'),
(9, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 15:43 27/06/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-06-27 01:43:42'),
(10, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 10:54 08/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-07 20:54:08'),
(11, 3, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 11:44 08/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-07 21:44:23'),
(12, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 12:29 08/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-07 22:29:25'),
(13, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 12:39 08/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-07 22:39:05'),
(14, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 20:30 08/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-08 06:30:41'),
(15, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 15:48 10/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-10 01:48:47'),
(19, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 09:57 15/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-14 19:57:34'),
(20, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 10:23 15/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-14 20:23:13'),
(21, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 10:39 15/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-14 20:39:25'),
(22, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 11:08 27/07/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-07-26 21:08:04'),
(23, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 13:16 03/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-02 23:16:02'),
(24, 2, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 15:50 03/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-03 01:50:40'),
(26, 5, '🎉 Chào mừng Nguyễn Hoàng Hải!', 'Hồ sơ cá nhân của bạn đã được khởi tạo dữ liệu mẫu thành công.', '/ho-so', 'he_thong', 1, 'welcome_5', '2026-08-03 22:47:27'),
(28, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 13:10 04/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-03 23:10:34'),
(29, 5, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 15:32 04/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-04 01:32:45'),
(30, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 16:00 04/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-04 02:00:02'),
(31, 5, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 15:00 10/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-10 01:00:36'),
(32, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 16:11 10/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-10 02:11:19'),
(33, 5, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 16:30 10/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-10 02:30:20'),
(34, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 16:31 10/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-10 02:31:58'),
(35, 5, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 19:32 10/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-10 05:32:46'),
(36, 4, '🔒 Đăng nhập thành công', 'Thiết bị: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) | IP: 127.0.0.1 | Lúc: 07:28 11/08/2026', '/ho-so/nhat-ky', 'bao_mat', 0, NULL, '2026-08-10 17:28:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `truy_cap`
--

DROP TABLE IF EXISTS `truy_cap`;
CREATE TABLE IF NOT EXISTS `truy_cap` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_dia_chi` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ngay_truy_cap` date NOT NULL,
  `ngay_tao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `truy_cap_session_id_index` (`session_id`),
  KEY `truy_cap_ngay_truy_cap_index` (`ngay_truy_cap`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `truy_cap`
--

INSERT INTO `truy_cap` (`id`, `session_id`, `ip_dia_chi`, `ngay_truy_cap`, `ngay_tao`) VALUES
(1, '6vRIinMqw4MHyfbufzx6gAsxXbxa8EgKzeHTuAqe', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(2, 'j0LkApRhmjOHK4A9o5oc8uhSPmpnPDopiq6A5dgM', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(3, 'xWomGfUQjsdK5XXMNNJvxgPCSdWhO1pDr7G8pXvU', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(4, '1JEuoBbRbp3T0ph9j5def4WrIZWPwmbP2leymdRJ', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(5, 'SOngTirRIdV3Ab8NnWP8KZXbWP8ekFumWyP3TYD0', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(6, 'qAla2ViX52qe0FfZBpEka23AuXQg0oi5iRndzoHP', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(7, 'D2QQYhBOLU608jcMgyUyUUOuQQFjsLTjxtpt1Hb2', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(8, 'DkLWseWqi9FkJoW16GmbraI7MAvsyZmBGtLLYNuT', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(9, 'FoBQpAUVJu9gnShPY5vpi6xQ65vxVrn4anEsIXOj', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(10, '51egAwqbXhaNlTjSgLg39MCRrktCVgKvcuas3MHo', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(11, 'K5qN0PmkzhgWt5qXdY4bj6maT5lkW10O6Ozh1CKp', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(12, 'kgcbZ6H7Ue4XNu6J1C4TxSUAAQW7Z27YYxuxIbda', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(13, '3w3yA0dJ2RyMHl1V09HAOOZCaNkgY5LGJE3RpjDT', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:57'),
(14, 'WaJaJzFFP7OkFPw8QVsuvRlKPquJcfBEEhBn9SX7', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(15, 'HMYzekkIrQCEKIUbHttAmVc0MbXRfs24u19l5ITK', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(16, 'Z12VL4Ura2o0JipwOOhdP2S6YYJymtPQ0j1Snlbt', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(17, 'TYV9WxXPFk8uz7N2TBDGqqfIJcKCAmCkhg2lc9f6', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(18, '60oAEYhRnOGnbDTb2Q8NyhFrQpd5PLEPnCwq9RtE', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(19, 'mgydxm6etYBeY84aTSx9cwA0CQT3kAwHWFMut6VV', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(20, '4pUE4HlMlkS6oVKMgcr1Ghrc26wLI0qtLsHlgFFb', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(21, 'GsWqHVfdWODsieXoo1kpkVnOW6yWXxRvgfHOIpi8', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(22, 'bDwpmkqa9XTWXGfduq9JUdrzb4EBGeLXLx6eXlpP', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:58'),
(23, 'Sefnf6qBH1PklNMnYQiT0llrphN0yr6UbkkBPdYa', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:59'),
(24, 'CgMLCcRqt8yBRscjE51neVSjdG80ADFo8bPDdPZZ', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:59'),
(25, '9jHvMkRmDv84eh8qQOSvTRL7xWmch4350v2GHyar', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:59'),
(26, '1ixv9FUmbjepAbV7jg9OV38xPVJjIczoXXwET0py', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:59'),
(27, 'GXNg1XkGeN8DMvWIA3GMlw9TU4VmXkvy8qsO6eli', '127.0.0.1', '2026-07-15', '2026-07-14 21:02:59'),
(28, 'Cbt1OWbUH4wwjtDGjF8iVHxbnFYbAWaBUd6PpZnJ', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:00'),
(29, 'v2bcrnrK4Okmz2ALQ0bFMrR9e28LnSRptOlQBEdZ', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:00'),
(30, 'Y1IJF9c1Wus2YgLHGY5F73WPNJDsngrPy69MYhhR', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:00'),
(31, '67KZe6HWN4EszfK4NXdHOS8vIQFSWByhErA3qRYy', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:00'),
(32, 'KqHk6vycmp3ZcBQpgLVadNtn1Z5r8bbiIoNpAUWP', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:01'),
(33, 'ZAPCgYSB8vXzp0aODkEM7fXrZd142IXxGr78jqff', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:01'),
(34, 'yEQO7eGJyUPQIzrYdQlOO7XrjRFUE8W9S5cIv6qp', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:01'),
(35, '7nz0xqhHPsda5RBnJA9oMHR5LlutWCuVfKum83yC', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:01'),
(36, 'LOQK4eYbBl7godFOupTLvVpeiwNPYgSWUjKMGRy8', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:02'),
(37, 'WqpxHyLwZQWgsZ6X8cshUjowEEdvjLCZEgRPZOIh', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:03'),
(38, 'xfohgokSReXIsjYG2TvRRzlJIgbtYfwOkQ8UNnYy', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:03'),
(39, 'FxOEMvBJqWAydmSMxXX4GSFq8ZZk70OlQQ9I5un5', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:03'),
(40, 'slMp7BONH9l0UJ8f4uC8cjRWjPhXPs7EiSAmuYwj', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:04'),
(41, 'FwT2aS2cOtsPQzn4D4CZGkkN7iDs4OUh5T5I7i4Z', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:04'),
(42, 'FF2fyCBK87Er0Cpb6QEnqQzHnExkePv6SrZJVWZA', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:04'),
(43, 'PFuMLwkngLR2XzGCtNH2yQ3gFTIiAEmIhDUaFl3e', '127.0.0.1', '2026-07-15', '2026-07-14 21:03:04'),
(44, 'B1QDAMUVxzrpkNQXsDjkvr03a1zcMBMRtDpX07R1', '127.0.0.1', '2026-07-27', '2026-07-26 21:07:48'),
(45, 'jMLxE4XfYZSuooLegopeOBGbq3dzMXy5olmkoiaB', '127.0.0.1', '2026-07-27', '2026-07-26 21:08:05'),
(46, 'SREMTvokQsmYoVKs1mcc8qqLEZInWafI2j9T1RVw', '127.0.0.1', '2026-08-03', '2026-08-02 23:15:44'),
(47, 'DNUz02HmBxXFhhiikvjCiNlCqFuYyEkrF6fmmGpB', '127.0.0.1', '2026-08-03', '2026-08-02 23:16:04'),
(48, 'e04r6e9Y5tRV3RGYLCpj3yTJ6VucQN7VIg8auGR8', '127.0.0.1', '2026-08-03', '2026-08-03 01:50:41'),
(49, 'zvN5OgfUseJaArn1pv25rujufHcykXxL1Z56wot9', '127.0.0.1', '2026-08-04', '2026-08-03 22:19:01'),
(50, 'uW2ZkerM001pzxUvGtz16K52TYRtJiKerumyfUTz', '127.0.0.1', '2026-08-04', '2026-08-03 22:19:53'),
(51, 'Xplc1eP4s1WzNjDsmMrs0nfzcu1QdkpPvzGOhpDp', '127.0.0.1', '2026-08-04', '2026-08-03 23:10:20'),
(52, 'CPcrEmretzFap0LcSj7wNgZc3tIOcgL9almS0pSW', '127.0.0.1', '2026-08-04', '2026-08-03 23:10:34'),
(53, 'o3GVCG45M8PRpCCYK0QeQl8b5Mb0vugJ3OSrnHrU', '127.0.0.1', '2026-08-04', '2026-08-04 01:32:46'),
(54, 'BMUSf0sedLyszCqUuQ32aL0hniE5yZGajTKSSxcc', '127.0.0.1', '2026-08-04', '2026-08-04 02:00:03'),
(55, 'O6uGTIRdTiIU8eoSd6YgqANofTf8MAhN60OWKQ3p', '127.0.0.1', '2026-08-10', '2026-08-10 01:00:23'),
(56, 'IjVTJBXjrMD6dWs7u4AWEkpKj2SJM4RhqgMZ0BHB', '127.0.0.1', '2026-08-10', '2026-08-10 01:00:37'),
(57, '09qsLnTcxq9h8itMK3yHhEWB2bAFaBHhINFlFTSg', '127.0.0.1', '2026-08-10', '2026-08-10 02:11:04'),
(58, 'PaKvKTIXQJpB5i3pJcTJSpFpwNi99kWyWKh1hWLI', '127.0.0.1', '2026-08-10', '2026-08-10 02:11:20'),
(59, '4bg0Kxt6fcnEiBfIH9L6CYBypzdOCxeif7efbGbm', '127.0.0.1', '2026-08-10', '2026-08-10 02:30:09'),
(60, 'A4pOH8cZUzLhUCN4Q9QWMS1xJtESdMPT5hKMQPZg', '127.0.0.1', '2026-08-10', '2026-08-10 02:30:21'),
(61, 'liTTJzCAaaALvDfEeFI4aPSX2jgHE5IH8vyIP2jk', '127.0.0.1', '2026-08-10', '2026-08-10 02:31:45'),
(62, 'JBREyOiJlmoR7DxWrK9m4KwiGoT3KPzlHlIlLlp9', '127.0.0.1', '2026-08-10', '2026-08-10 02:31:59'),
(63, 'nbgnNcr4OiA7jSiZGjUyHktH7QI5ID63G3H2FYbp', '127.0.0.1', '2026-08-10', '2026-08-10 03:02:18'),
(64, 'Oa2EbuYJ6L83bBy0NiqRMvdocwtU4Cb9kK17OOW5', '127.0.0.1', '2026-08-10', '2026-08-10 05:32:47'),
(65, 'Axbxe0L11oteYGBDoAFIlihMRzniae4KMfvGdaRG', '127.0.0.1', '2026-08-11', '2026-08-10 17:10:32'),
(66, 'Xozgvrjygj3EBE8Y1XdlVpYSKAqYt5JCGgU5EqPN', '127.0.0.1', '2026-08-11', '2026-08-10 17:28:45');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `album_hinh_anh`
--
ALTER TABLE `album_hinh_anh`
  ADD CONSTRAINT `album_hinh_anh_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `album_su_kien` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `album_su_kien`
--
ALTER TABLE `album_su_kien`
  ADD CONSTRAINT `album_su_kien_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chung_chi`
--
ALTER TABLE `chung_chi`
  ADD CONSTRAINT `chung_chi_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cv_ca_nhan`
--
ALTER TABLE `cv_ca_nhan`
  ADD CONSTRAINT `cv_ca_nhan_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cv_ca_nhan_ibfk_2` FOREIGN KEY (`ma_template`) REFERENCES `mau_cv` (`ma_mau_cv`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `du_an`
--
ALTER TABLE `du_an`
  ADD CONSTRAINT `du_an_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `du_an_lien_ket`
--
ALTER TABLE `du_an_lien_ket`
  ADD CONSTRAINT `du_an_lien_ket_ibfk_1` FOREIGN KEY (`id_du_an`) REFERENCES `du_an` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hoc_van`
--
ALTER TABLE `hoc_van`
  ADD CONSTRAINT `hoc_van_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `kinh_nghiem`
--
ALTER TABLE `kinh_nghiem`
  ADD CONSTRAINT `kinh_nghiem_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lich_cong_viec`
--
ALTER TABLE `lich_cong_viec`
  ADD CONSTRAINT `lich_cong_viec_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `lien_ket_mxh`
--
ALTER TABLE `lien_ket_mxh`
  ADD CONSTRAINT `lien_ket_mxh_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nguoi_dung_ky_nang_mem`
--
ALTER TABLE `nguoi_dung_ky_nang_mem`
  ADD CONSTRAINT `fk_ndknm_ky_nang_mem` FOREIGN KEY (`ky_nang_mem_id`) REFERENCES `ky_nang_mem` (`id`),
  ADD CONSTRAINT `fk_ndknm_nguoi_dung` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `nguoi_dung_ngon_ngu_lap_trinh`
--
ALTER TABLE `nguoi_dung_ngon_ngu_lap_trinh`
  ADD CONSTRAINT `fk_ndnnlt_ngon_ngu` FOREIGN KEY (`ngon_ngu_lap_trinh_id`) REFERENCES `ngon_ngu_lap_trinh` (`id`),
  ADD CONSTRAINT `fk_ndnnlt_nguoi_dung` FOREIGN KEY (`nguoi_dung_id`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thanh_tuu`
--
ALTER TABLE `thanh_tuu`
  ADD CONSTRAINT `thanh_tuu_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thong_bao`
--
ALTER TABLE `thong_bao`
  ADD CONSTRAINT `thong_bao_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
