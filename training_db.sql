-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.infinityfree.com
-- Generation Time: 01 أكتوبر 2024 الساعة 14:25
-- إصدار الخادم: 10.6.19-MariaDB
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
-- Database: `if0_37398810_training_db`
--

-- --------------------------------------------------------

--
-- بنية الجدول `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `opportunity_id_fk` int(11) NOT NULL,
  `student_id_fk` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `cover_letter` text NOT NULL,
  `resume` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- إرجاع أو استيراد بيانات الجدول `applications`
--

INSERT INTO `applications` (`id`, `opportunity_id_fk`, `student_id_fk`, `full_name`, `email`, `city`, `cover_letter`, `resume`, `submitted_at`, `status`) VALUES
(1, 1, 1, 'ahmad ali', 'a.ahmad @gmail.com', 'Jeddah', '', '', '2024-09-28 21:25:02', 'rejected'),
(2, 2, 2, 'ali ali', 'ali@gmail.com', 'jeddah', 'mmmmmmmmmm', '66fb388676644.pdf', '2024-09-30 23:47:18', 'accepted'),
(3, 2, 2, 'ali ali', 'ali@gmail.com', 'jeddah', 'mmmmmmmmmm', '66fb3b73068ce.pdf', '2024-09-30 23:59:47', 'accepted');

-- --------------------------------------------------------

--
-- بنية الجدول `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `type` varchar(200) NOT NULL,
  `established_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` varchar(255) NOT NULL,
  `status` enum('active','inactive','under_construction') NOT NULL,
  `website` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- إرجاع أو استيراد بيانات الجدول `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `type`, `established_date`, `address`, `phone`, `email`, `password`, `description`, `last_updated`, `category`, `created_at`, `note`, `status`, `website`) VALUES
(1, 'it', '', NULL, NULL, '95544', 'it@gmail.com', '$2y$10$Jkj3tMbNU0lH3PUXBhx6BuxEuqltSmhAHMFKj1Xa4kHiN9Qyh3tJ.', '', '2024-09-30 17:18:30', NULL, '2024-09-28 18:03:43', '', '', NULL),
(2, 'Tech Solutions', '', NULL, NULL, '965-55555', 'TechSolutions@gmail.com', '$2y$10$z.MHKK2WagI.8E4SiNwWSeoPrHmBhpEEKuT0GBMfBBR8XOTr016AK', '', '2024-09-30 17:18:47', NULL, '2024-09-28 18:06:54', '', '', NULL),
(3, 'cnd', 'Government', '2019-07-10', 'abbha', '965333330000', 'cnd@gmail.com', '$2y$10$GUgZ4PSH3hiiulj4T3m0Lenx4B8KPGhdSrJL2RXmECuisGhIbggsu', '\r\nThe body with the power to make and/or enforce laws to control a country, land area, people or organization.', '2024-10-01 11:39:16', NULL, '2024-09-30 12:05:13', '', 'active', 'www.cndinfo.com'),
(4, 'mm', '', NULL, NULL, NULL, 'mm@g.com', '$2y$10$/I/rkmIN70Sk/DWmiGUmseguX9C83ELo5lHUJyMTPGS90B1Zf58Ia', '', '2024-09-30 17:43:15', NULL, '2024-09-30 17:43:15', '', 'active', NULL),
(5, 'mmmmmmmmmm', 'mmmmmmmm', '2024-09-16', 'mmm88', '888888', 't@m.com', '', 'oo', '2024-09-30 20:03:48', NULL, '2024-09-30 20:03:48', '', 'active', 'tttt');

-- --------------------------------------------------------

--
-- بنية الجدول `opportunities`
--

CREATE TABLE `opportunities` (
  `id` int(11) NOT NULL,
  `company_name_fk` varchar(255) DEFAULT NULL,
  `opportunity_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `major` varchar(100) NOT NULL,
  `specialization` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `students_needed` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- إرجاع أو استيراد بيانات الجدول `opportunities`
--

INSERT INTO `opportunities` (`id`, `company_name_fk`, `opportunity_title`, `description`, `city`, `major`, `specialization`, `location`, `duration`, `requirements`, `students_needed`, `created_at`) VALUES
(1, 'cnd', 'android developer ', ' analysis , design , build ,test and deployee app using best practices', 'Abha', 'development', 'computer senice', 'Abha?,street-80', '60', 'Familiarity with object-oriented programming concepts, including inheritance.\r\nHow to define and implement interfaces.', 5, '2024-09-30 14:40:47'),
(2, 'cnd', 'design app', 'design app design app', 'riadh', 'design app', 'software', 'riadh , street 90', '90', '', 3, '2024-09-30 14:45:15'),
(3, 'cnd', 'developer IOS', 'developer IOS', 'Jeddah', 'developer IOS', 'IOS', 'Jeddah,Street -90', '50', 'Familiarity with object-oriented programming concepts, including inheritance.\r\n', 15, '2024-09-30 15:26:03');

-- --------------------------------------------------------

--
-- بنية الجدول `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` varchar(50) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `specialization` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- إرجاع أو استيراد بيانات الجدول `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `birthdate`, `phone_number`, `specialization`, `city`, `address`, `created_at`, `note`, `status`) VALUES
(1, 'mmmmmmmmm', 'mm@g.com', '$2y$10$gANvoHJ0EDokdo8zP7ltMukoLAXPGJkrAhC.nSV45bIgXbxbS5ZKC', '', '', '', '', NULL, '2024-09-28 17:28:46', '', ''),
(2, 'ali  muhammed', 'ali@gmail.com', '$2y$10$dmnQHxpds/wQnTX8QUjr1OtcPBUl4c.VOjRHNkDwpdGIuaKZp.oyy', '1995-10-07', '9655000000', 'it', 'abbha', 'abbha , street-70', '2024-09-30 22:28:49', '', '');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('student','institution') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `opportunity_id_fk` (`opportunity_id_fk`),
  ADD KEY `student_id_fk` (`student_id_fk`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `company_name` (`company_name`);

--
-- Indexes for table `opportunities`
--
ALTER TABLE `opportunities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `opportunities`
--
ALTER TABLE `opportunities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
