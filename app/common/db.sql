-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2022 at 04:20 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timetable`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) NOT NULL,
  `login_id` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `actived_flag` int(1) DEFAULT 1,
  `reset_password_token` varchar(100) DEFAULT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `login_id`, `password`, `actived_flag`, `reset_password_token`, `updated`, `created`) VALUES
(10, 'admin', '25d55ad283aa400af464c76d713c07ad', 1, NULL, '2021-12-28 15:42:19', '2021-12-28 15:42:19'),
(13, '18001023', 'ec06f655b48b1902a211fa23ec6fa3ee', 1, NULL, '2022-01-01 00:20:42', '2022-01-01 00:20:42'),
(14, '18001027', '42a7bd0af5069e4858b200b2b0147dc2', 1, NULL, '2022-01-01 00:21:26', '2022-01-01 00:21:26'),
(15, '18001035', 'cca0ac09e8932fd07693dd5ea18b83b6', 1, NULL, '2022-01-01 00:21:43', '2022-01-01 00:21:43'),
(16, '18001037', '82a9b1d4176746f5fe2957c49dc52b0d', 1, NULL, '2022-01-01 00:22:00', '2022-01-01 00:22:00'),
(17, '18001043', 'dcffd6e75cf43ac75c59556ed8acc609', 1, NULL, '2022-01-01 00:22:18', '2022-01-01 00:22:18'),
(18, '18001066', '95a78942268688918f039fe31c76a8ea', 1, NULL, '2022-01-01 00:22:33', '2022-01-01 00:22:33'),
(19, '18001076', 'ce6f182dbde7b50ccf396a3506f410c4', 1, NULL, '2022-01-01 00:22:50', '2022-01-01 00:22:50'),
(20, '18001077', '656744c086b85d97745031755eb73e4e', 1, NULL, '2022-01-01 00:23:05', '2022-01-01 00:23:05'),
(21, '18001079', 'c08bb737e33d61acbfbb332ed5d6d18d', 1, NULL, '2022-01-01 00:23:20', '2022-01-01 00:23:20'),
(22, '18001080', '8af9c86f3593a915f9b6549d02596b04', 1, NULL, '2022-01-01 00:23:35', '2022-01-01 00:23:35'),
(23, '19000482', 'a99bde2a15b26751c4cb52c101eaf040', 1, NULL, '2022-01-01 00:23:58', '2022-01-01 00:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(10) NOT NULL,
  `teacher_id` int(10) NOT NULL,
  `weekday` char(10) NOT NULL,
  `lesson` char(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `teacher_id`, `weekday`, `lesson`, `notes`, `updated`, `created`) VALUES
(3, 1, 'Thứ 2', '3, 4', '', '2021-12-31 22:53:53', '2021-12-31 05:35:28'),
(6, 4, 'Thứ 5', '1, 2', '', '2022-01-03 20:23:39', '2022-01-01 20:07:13'),
(8, 7, 'Thứ 3', '6, 7', '', '2022-01-03 19:21:44', '2022-01-03 19:21:44'),
(9, 3, 'Thứ 4', '9, 10', '', '2022-01-03 20:23:47', '2022-01-03 19:22:00'),
(10, 6, 'Thứ 6', '1, 2, 3', '', '2022-01-03 21:47:44', '2022-01-03 19:32:17'),
(11, 11, 'Thứ 7', '4, 5', '', '2022-01-03 20:22:55', '2022-01-03 19:45:58'),
(12, 5, 'Thứ 2', '7, 8', '', '2022-01-03 22:03:31', '2022-01-03 22:03:31');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `school_year` char(10) NOT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `description`, `school_year`, `updated`, `created`) VALUES
(3, 'Giải tích', NULL, 'Năm 2', '2021-12-28 02:59:44', '2021-12-28 02:59:44'),
(4, 'Hoá học đại cương', '', 'Năm 1', '2022-01-03 19:47:52', '2021-12-28 02:59:58'),
(5, 'Vật lý lượng tử', '', 'Năm 4', '2021-12-29 10:19:27', '2021-12-28 03:00:10'),
(6, 'Xác suất thống kê', NULL, 'Năm 3', '2021-12-28 03:00:26', '2021-12-28 03:00:26'),
(8, 'Đại số tuyến tính', '', 'Năm 1', '2021-12-29 23:22:48', '2021-12-29 23:22:48'),
(9, 'Toán rời rạc', '', 'Năm 1', '2021-12-29 23:41:29', '2021-12-29 23:27:15'),
(10, 'Văn học thế giới', '', 'Năm 3', '2022-01-03 19:47:38', '2021-12-29 23:28:00'),
(11, 'Thực vật học', '', 'Năm 2', '2021-12-29 23:42:13', '2021-12-29 23:42:13');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `avatar` varchar(250) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subject_id` int(10) NOT NULL,
  `degree` char(30) NOT NULL,
  `updated` datetime NOT NULL DEFAULT current_timestamp(),
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `avatar`, `description`, `subject_id`, `degree`, `updated`, `created`) VALUES
(1, 'Nguyễn Văn A', 'Nguyễn Văn A.jpg', '', 3, 'Tiến sĩ', '2022-01-03 19:08:01', '2021-12-28 03:08:07'),
(2, 'Phạm Văn B', 'Phạm Văn B.jpg', '', 11, 'Thạc sĩ', '2022-01-03 19:08:19', '2021-12-28 03:08:26'),
(3, 'Trần Văn Z', 'Trần Văn Z.jpg', '', 9, 'Cử nhân', '2022-01-03 19:06:41', '2021-12-28 03:08:47'),
(4, 'Hoàng Thị D', 'Hoàng Thị D.jpg', '', 4, 'Tiến sĩ', '2022-01-03 19:07:18', '2021-12-28 03:09:13'),
(5, 'Nguyễn Thị P', 'Nguyễn Thị P.jpg', '', 10, 'Thạc sĩ', '2022-01-03 19:07:51', '2021-12-28 03:09:34'),
(6, 'Phan Văn H', 'Phan Văn H.jpg', '', 5, 'Cử nhân', '2022-01-03 19:08:30', '2021-12-28 03:10:10'),
(7, 'Nguyễn Thị C', 'Nguyễn Thị C.jpg', '', 6, 'Thạc sĩ', '2022-01-03 19:07:38', '2021-12-28 03:10:31'),
(11, 'Nguyễn Thị X', 'Nguyễn Thị X.jpg', '', 8, 'Giáo sư', '2022-01-03 19:16:08', '2021-12-31 05:03:12'),
(22, 'Nguyễn Y', 'Nguyễn Y.jpg', '', 8, 'Thạc sĩ', '2022-01-03 19:08:09', '2022-01-01 23:19:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login_id` (`login_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
