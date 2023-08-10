-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2023 at 07:18 AM
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
(4, 27, 'Aishwarya Majmudar');

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
(9, 27, '6479397750'),
(10, 27, '4372692108');

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
  `event_sponsor` varchar(60) NOT NULL,
  `gmail` varchar(50) NOT NULL,
  `event_price` varchar(5) NOT NULL,
  `event_start_date` date NOT NULL,
  `event_end_date` date NOT NULL,
  `event_start_time` time NOT NULL,
  `event_end_time` time NOT NULL,
  `event_desc` varchar(255) NOT NULL,
  `request_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_event`
--

INSERT INTO `tbl_event` (`event_id`, `event_name`, `event_host`, `event_venue`, `event_poster`, `event_sponsor`, `gmail`, `event_price`, `event_start_date`, `event_end_date`, `event_start_time`, `event_end_time`, `event_desc`, `request_id`) VALUES
(27, 'Rangtaali', 'The Weekenders and Sankalp Canada', 'At Pearson Convention Center, Brampton', 'file_images/garba1.jpg', 'Mayur Shah & Amit Baroliya', 'sankalp@gmail.com', '40', '2023-09-09', '2023-09-10', '21:00:00', '00:00:00', 'We are thrilled to invite you to our Garba Night, a traditional dance celebration from the heart of Gujarat! Immerse yourself in the vibrant rhythms of dhol beats and dance the night away.', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

CREATE TABLE `tbl_request` (
  `request_id` int(11) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `phone_no` varchar(10) NOT NULL,
  `email_id` varchar(60) NOT NULL,
  `description` varchar(255) NOT NULL,
  `request_date` date NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_request`
--

INSERT INTO `tbl_request` (`request_id`, `first_name`, `last_name`, `phone_no`, `email_id`, `description`, `request_date`, `status`) VALUES
(4, 'Dhruv', 'Goswami', '1234567895', 'dhruv@gmail.com', 'I want to register my event..', '2023-08-07', '1'),
(5, 'John', 'Doe', '9876543210', 'john.doe@example.com', 'Event registration', '2023-08-01', '1'),
(6, 'Jane', 'Smith', '9876543211', 'jane.smith@example.com', 'Need help with event', '2023-08-02', '1'),
(7, 'Alice', 'Johnson', '9876543212', 'alice.johnson@example.com', 'Event inquiry', '2023-08-03', '0'),
(8, 'Bob', 'Williams', '9876543213', 'bob.williams@example.com', 'Event volunteer signup', '2023-08-04', '0'),
(9, 'Emma', 'Miller', '9876543214', 'emma.miller@example.com', 'Event sponsor information', '2023-08-05', '1'),
(10, 'Michael', 'Brown', '9876543215', 'michael.brown@example.com', 'Event logistics', '2023-08-06', '0'),
(11, 'Sophia', 'Lee', '9876543216', 'sophia.lee@example.com', 'Event venue booking', '2023-08-07', '1'),
(12, 'James', 'Kim', '9876543217', 'james.kim@example.com', 'Event ticket purchase', '2023-08-08', '0'),
(13, 'Olivia', 'Chen', '9876543218', 'olivia.chen@example.com', 'Event schedule information', '2023-08-09', '0'),
(14, 'Daniel', 'Nguyen', '9876543219', 'daniel.nguyen@example.com', 'Event speaker details', '2023-08-10', '-1');

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
-- Indexes for table `tbl_request`
--
ALTER TABLE `tbl_request`
  ADD PRIMARY KEY (`request_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_artist`
--
ALTER TABLE `tbl_artist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_event`
--
ALTER TABLE `tbl_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_request`
--
ALTER TABLE `tbl_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
