-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2023 at 08:21 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garba.ca`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_artist`
--

CREATE TABLE `tbl_artist` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `artist_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_artist`
--

INSERT INTO `tbl_artist` (`id`, `event_id`, `artist_name`) VALUES
(27, 32, 'Aishwarya Majmudar'),
(28, 33, 'Pramesh Nandi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `contact_no` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`id`, `event_id`, `contact_no`) VALUES
(53, 32, '6479397750'),
(54, 32, '4372692108'),
(55, 33, '6473093939'),
(56, 33, '6475819773');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_event`
--

CREATE TABLE `tbl_event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_host` varchar(40) NOT NULL,
  `event_venue` varchar(60) NOT NULL,
  `event_poster` varchar(400) NOT NULL,
  `event_sponsor` varchar(60) DEFAULT NULL,
  `gmail` varchar(50) NOT NULL,
  `event_price` varchar(5) NOT NULL,
  `event_start_date` date NOT NULL,
  `event_end_date` date NOT NULL,
  `event_start_time` time NOT NULL,
  `event_end_time` time NOT NULL,
  `event_desc` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0',
  `is_complete` varchar(1) NOT NULL DEFAULT '0',
  `is_featured` varchar(1) NOT NULL DEFAULT '0',
  `give_away` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_event`
--

INSERT INTO `tbl_event` (`event_id`, `event_name`, `event_host`, `event_venue`, `event_poster`, `event_sponsor`, `gmail`, `event_price`, `event_start_date`, `event_end_date`, `event_start_time`, `event_end_time`, `event_desc`, `user_id`, `status`, `is_complete`, `is_featured`, `give_away`) VALUES
(32, 'Rangtaali Garba Night', 'The Weekenders and Sankalp Canada', 'At Pearson Convention Center, Brampton', '../file_images/64da592c422b3-garba1.jpg', 'Mayur Shah &amp; Amit Baroliya', 'sankalp@gmail.com', '55', '2023-08-15', '2023-08-18', '22:10:00', '12:10:00', 'Best event in canada', 1, '1', '0', '0', '0'),
(33, 'Raas Garba', 'SWAR GUNJAN MUSIC ACADEMY', 'Canada Event Centre', '../file_images/64da5a9bdecf9-garbaimg.jpg', 'Shree Ram Entertainment', 'swargunjan@gmail.com', '60', '2023-08-18', '2023-08-19', '19:16:00', '23:16:00', 'Best garba event in canada', 1, '1', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_giveaway`
--

CREATE TABLE `tbl_giveaway` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `event_id` int(11) NOT NULL,
  `is_winner` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_giveaway`
--

INSERT INTO `tbl_giveaway` (`id`, `name`, `email`, `contact_no`, `event_id`, `is_winner`) VALUES
(3, 'Home Town', 'official.webprojects@gmail.com', '0123456785', 29, '1'),
(4, 'Dhruv Goswami', 'dhruv@gmail.com', '0123456789', 29, '1'),
(5, 'Goswami Jogendrapuri', 'goswamidj16@gmail.com', '0123456789', 29, '1'),
(6, 'Chetan', 'chetan@gmail.com', '8572638963', 29, '1'),
(7, 'Raj ', 'raj@gmail.com', '4561238789', 29, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `is_verified` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `email`, `password`, `token`, `is_verified`) VALUES
(6, 'Dhruv', 'Goswami', 'goswamidj16@gmail.com', '$2y$10$IC.s/ldqfFxmBhl.rlcIN.cujE97S2YuQTnWw.6qMRXQFVwavjJGm', 'c385f61dc3aa31fcd65921084fcff06287ef4c15667edee4b3d0aa433aa625907814bd0e1adc720670118cccb723a78d16d8', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Artist` (`event_id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Contact` (`event_id`);

--
-- Indexes for table `tbl_event`
--
ALTER TABLE `tbl_event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `tbl_giveaway`
--
ALTER TABLE `tbl_giveaway`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `tbl_event`
--
ALTER TABLE `tbl_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_giveaway`
--
ALTER TABLE `tbl_giveaway`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  ADD CONSTRAINT `Artist` FOREIGN KEY (`event_id`) REFERENCES `tbl_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD CONSTRAINT `Contact` FOREIGN KEY (`event_id`) REFERENCES `tbl_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
