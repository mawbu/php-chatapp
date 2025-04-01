-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 01, 2025 lúc 08:17 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `chatapp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_url` varchar(255) DEFAULT NULL,
  `sticker_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `timestamp`, `image_url`, `sticker_url`) VALUES
(27, 205767893, 486310938, 'HI', '2025-03-06 06:31:51', NULL, NULL),
(28, 486310938, 205767893, 'hello', '2025-03-06 06:32:12', NULL, NULL),
(29, 486310938, 205767893, 'cmm', '2025-03-06 06:39:12', NULL, NULL),
(31, 486310938, 205767893, 'hi', '2025-03-06 08:03:24', NULL, NULL),
(34, 205767893, 486310938, 'labubu', '2025-03-09 07:20:46', NULL, NULL),
(38, 205767893, 486310938, '', '2025-03-09 08:07:24', 'images/1741507644_67cd4c3c8d9bd.png', NULL),
(39, 205767893, 486310938, 'aaaa', '2025-03-09 08:14:54', '', NULL),
(40, 486310938, 205767893, 'lỏ', '2025-03-09 08:35:49', '', NULL),
(41, 205767893, 486310938, '', '2025-03-09 14:16:00', 'images/1741529760_67cda2a070a86.png', NULL),
(42, 205767893, 486310938, '', '2025-03-13 07:50:01', 'images/1741852201_67d28e29bd22a.png', NULL),
(43, 205767893, 486310938, '', '2025-03-13 08:28:06', 'images/1741854486_67d297163f162.jpg', NULL),
(44, 486310938, 205767893, 'Đẹp mày', '2025-03-13 08:29:40', '', NULL),
(45, 205767893, 486310938, 'đi mua không cu :>>', '2025-03-13 08:42:42', '', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `unique_id`, `fname`, `lname`, `email`, `password`, `img`, `status`, `last_activity`) VALUES
(8, 205767893, 'ma', 'buw', 'mabuw@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1740896902THE-MONSTERS-ONE-PIECE-Labubu-Pop-Mart-2-1.jpg', 'Active now', '2025-04-01 06:45:47'),
(9, 486310938, 'NGUYEN', 'CANH', 'huycanh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1740921526THE-MONSTERS-ONE-PIECE-Labubu-Pop-Mart-1-1.jpg', 'Active now', '2025-03-13 08:42:33');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
