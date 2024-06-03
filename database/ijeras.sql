-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2023 at 08:32 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ijeras`
--

-- --------------------------------------------------------

--
-- Table structure for table `board_members`
--

CREATE TABLE `board_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `spec` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `board_members`
--

INSERT INTO `board_members` (`id`, `name`, `spec`, `position`, `status`, `date_created`) VALUES
(1, 'Arpit Singh', 'zd', 0, 1, NULL),
(2, 'sdffgfh', 'dffgdsf', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_list`
--

CREATE TABLE `category_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '0= Inactive, 1 = Active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_list`
--

INSERT INTO `category_list` (`id`, `name`, `description`, `status`, `date_created`) VALUES
(2, 'Art', 'This is an Art Magazines Categories', 1, '2021-11-27 10:21:23'),
(3, 'Business', 'This is a Business Magazine Category', 1, '2021-11-27 10:24:03'),
(4, 'Cooking', 'This is a Cooking Magazines Category', 1, '2021-11-27 10:25:35'),
(5, 'Fashion', 'This is a Fashion Magazines Category', 1, '2021-11-27 10:30:22'),
(6, 'Technology', 'This is a Technology Magazines Category', 1, '2021-11-27 10:30:46'),
(7, 'Riders and Drivers', 'This is a Riders and Drivers Magazines Categories', 1, '2021-11-27 10:31:27'),
(8, 'Wild', 'This is a Wild Magazines Category.', 0, '2021-11-27 10:31:57');

-- --------------------------------------------------------

--
-- Table structure for table `comment_list`
--

CREATE TABLE `comment_list` (
  `id` int(30) NOT NULL,
  `magazine_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `name` text NOT NULL,
  `user_id` int(30) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = not verified,1= verified ',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `indexing`
--

CREATE TABLE `indexing` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `banner_path` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `indexing`
--

INSERT INTO `indexing` (`id`, `name`, `link`, `banner_path`, `type`, `status`, `date_created`) VALUES
(2, 'google', 'www.google.com', 'uploads/1695746280_google logo.png', 0, 1, '0000-00-00 00:00:00.000000'),
(3, 'youtube', 'www.youtube.com', 'uploads/1695746580_SCHOOL LOGO.jpg', 0, 1, '0000-00-00 00:00:00.000000'),
(4, 'facebook', 'www.facebbok.com', 'uploads/1695746700_face.png', 0, 1, '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `magazine_list`
--

CREATE TABLE `magazine_list` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `category_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `pdf_path` text DEFAULT NULL,
  `issue` int(11) NOT NULL,
  `author_name` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 = Not Published, 1= Published',
  `user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `magazine_list`
--

INSERT INTO `magazine_list` (`id`, `title`, `category_id`, `description`, `pdf_path`, `issue`, `author_name`, `status`, `user_id`, `date_created`, `date_updated`) VALUES
(5, 'test', 3, '&lt;p&gt;sdffd&lt;/p&gt;', 'uploads/pdf/magazine-.pdf?v=1695740631', 1, 'dggsdfghsdg', 1, 1, '2023-09-26 20:33:51', '2023-09-26 20:33:51'),
(6, 'how to get specific data from database in php', 2, '&lt;p&gt;dffg&lt;/p&gt;', 'uploads/pdf/magazine-.pdf?v=1695751943', 3, 'gdgdgdghshdf', 1, 1, '2023-09-26 23:42:23', '2023-09-26 23:50:01'),
(7, 'Teams who got mail from Sih register yourself accordingly and those who didn&#039;t get any&nbsp;mail&nbsp;message&nbsp;me', 4, '&lt;p&gt;zdgdfdgasddf&lt;/p&gt;', 'uploads/pdf/magazine-.pdf?v=1695752002', 1, 'gsdhsdffh', 1, 1, '2023-09-26 23:43:22', '2023-09-26 23:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'International journal of engineering research and applied science -Ijeras (Control Panel)'),
(6, 'short_name', 'Ijeras- Admin Panel'),
(11, 'logo', 'uploads/logo.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1637977267.png'),
(15, 'content', 'Array');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1635556826', NULL, 1, 1, '2021-01-20 14:02:37', '2021-11-27 13:39:11'),
(5, 'Dr.Ajay', '', 'Saini', 'drajaysaini', '1254737c076cf867dc53d60a0364f38e', NULL, NULL, 2, 1, '2021-11-27 14:24:16', '2023-09-26 18:50:53'),
(6, 'Claire', 'C', 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', NULL, NULL, 2, 1, '2021-11-27 14:25:31', '2021-11-27 14:43:24'),
(7, 'Arpit', '', 'Singh', 'arpit5513', '2ba0fe31f13cfd2ff6e601a03ef2ff14', NULL, NULL, 2, 0, '2023-09-26 18:51:53', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board_members`
--
ALTER TABLE `board_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_list`
--
ALTER TABLE `category_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment_list`
--
ALTER TABLE `comment_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `magazine_id` (`magazine_id`);

--
-- Indexes for table `indexing`
--
ALTER TABLE `indexing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magazine_list`
--
ALTER TABLE `magazine_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board_members`
--
ALTER TABLE `board_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_list`
--
ALTER TABLE `category_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `comment_list`
--
ALTER TABLE `comment_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `indexing`
--
ALTER TABLE `indexing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `magazine_list`
--
ALTER TABLE `magazine_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment_list`
--
ALTER TABLE `comment_list`
  ADD CONSTRAINT `comment_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `comment_list_ibfk_2` FOREIGN KEY (`magazine_id`) REFERENCES `magazine_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `magazine_list`
--
ALTER TABLE `magazine_list`
  ADD CONSTRAINT `magazine_list_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `magazine_list_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
