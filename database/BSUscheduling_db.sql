-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2024 at 03:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsuscheduling_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_ID` int(11) NOT NULL,
  `department_code` varchar(11) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `department_status` enum('Active','Not Active') NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_ID`, `department_code`, `department_name`, `department_status`) VALUES
(1, 'BS EE', 'BS Electrical Engineering', 'Not Active'),
(2, 'BS ARCH', 'BS Architecture', 'Active'),
(3, 'BS SE', 'BS Sanitary Engineering', 'Active'),
(4, 'BS ICE', 'BS Instrumentation and Control Engineering', 'Active'),
(5, 'BS PetE', 'BS Petroleum Engineering', 'Active'),
(6, 'BS CpE', 'BS Computer Engineering', 'Not Active'),
(7, 'BS CE', 'BS Civil Engineering', 'Active'),
(8, 'BS CHEM', 'BS Chemical Engineering', 'Active'),
(9, 'BS IT', 'BS Information Technology', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `device_ID` int(11) NOT NULL,
  `device_name` varchar(50) NOT NULL,
  `device_status` enum('Active','Not Active') NOT NULL DEFAULT 'Active',
  `facility_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`device_ID`, `device_name`, `device_status`, `facility_ID`) VALUES
(1, 'NBVCaa', 'Not Active', 1),
(2, 'adad', 'Not Active', 1),
(3, 'addada', 'Not Active', 1),
(4, 'dgdsgsgwqw', 'Not Active', 1),
(5, 'hgnfdsfad', 'Active', 1),
(6, 'sample123123', 'Active', 6),
(7, 'loremisum', 'Active', 3);

-- --------------------------------------------------------

--
-- Table structure for table `event_booking`
--

CREATE TABLE `event_booking` (
  `event_ID` int(11) NOT NULL,
  `event_code` varchar(50) NOT NULL,
  `event_name` varchar(50) NOT NULL,
  `event_purpose` varchar(600) NOT NULL,
  `start_from` datetime NOT NULL,
  `end_to` datetime NOT NULL,
  `participants` varchar(50) NOT NULL,
  `event_status` enum('pending','approved','declined') NOT NULL DEFAULT 'pending',
  `facility_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_booking`
--

INSERT INTO `event_booking` (`event_ID`, `event_code`, `event_name`, `event_purpose`, `start_from`, `end_to`, `participants`, `event_status`, `facility_ID`, `user_ID`) VALUES
(45, 'SCH1711935431', 'sdfghjkl;\';lkjh', 'asdkl;l\';\'l/k.j,hmgnb', '2024-04-18 09:34:00', '2024-04-18 01:34:00', 'asdfghjkl;lkjhg', 'declined', 6, 7),
(46, 'SCH1711935447', 'sdfghjkl;\';lkjh', 'asdkl;l\';\'l/k.j,hmgnb', '2024-05-16 09:34:00', '2024-05-16 01:34:00', 'asdfghjkl;lkjhg', 'declined', 6, 7),
(47, 'SCH1711935476', 'sertyujkl;', 'ertyuio sdfghjk sertyuik artgyhujkl', '2024-05-11 09:37:00', '2024-04-01 00:37:00', 'sdfghjkl;', 'declined', 5, 7),
(48, 'SCH1711935506', 'sertyujkl;', 'ertyuio sdfghjk sertyuik artgyhujkl', '2024-05-11 09:37:00', '2024-04-01 00:37:00', 'sdfghjkl;', 'declined', 5, 7),
(49, 'SCH1711935543', 'sertyujkl;', 'ertyuio sdfghjk sertyuik artgyhujkl', '2024-05-11 09:37:00', '2024-04-01 00:37:00', 'sdfghjkl;', 'declined', 5, 7),
(50, 'SCH1711935669', 'sample event fetching', 'sample sample sample sample sample sample sample s', '2024-04-19 17:40:00', '2024-04-19 19:00:00', 'sample participants', 'approved', 7, 7),
(51, 'SCH1711936267', 'another sample', 'another sample another sample another sample anoth', '2024-04-20 10:50:00', '2024-04-20 12:50:00', 'another sample participants', 'approved', 6, 7),
(52, 'SCH1711979887', 'sample event fetching search testing', 'sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample event fetching search testing sample e', '2024-04-19 12:00:00', '2024-04-19 16:00:00', 'sample event fetching search testing ', 'approved', 1, 7),
(53, 'BSUsch1711987881', 'something new, thousands sample ', 'something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample something new, thousands sample ', '2024-06-18 12:11:00', '2024-06-18 17:11:00', 'something new, thousands sample ', 'declined', 3, 7),
(58, 'BSUsch1713550897', 'sample 20/04/24_2:20am ', 'sample 20/04/24_2:20am sample 20/04/24_2:20am sample 20/04/24_2:20am sample 20/04/24_2:20am sample 20/04/24_2:20am sample 20/04/24_2:20am ', '2024-04-21 07:00:00', '2024-04-21 09:00:00', 'sample 20/04/24_2:20am ', 'pending', 5, 35);

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `facility_ID` int(11) NOT NULL,
  `facility_code` varchar(20) NOT NULL,
  `facility_name` varchar(50) NOT NULL,
  `building_loc` varchar(50) NOT NULL,
  `facility_capacity` int(11) NOT NULL,
  `facility_status` enum('available','reserved','disable') NOT NULL DEFAULT 'available',
  `staff` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`facility_ID`, `facility_code`, `facility_name`, `building_loc`, `facility_capacity`, `facility_status`, `staff`) VALUES
(1, 'AVR-SH', 'Audio Visual Room', 'SteerHub, 3rd floor', 300, 'available', ''),
(2, '', '', '', 0, 'disable', ''),
(3, 'CONF-COT', 'Conference Room', 'COT, 2nd Floor', 150, 'available', ''),
(4, 'AVR-CEAFA', 'Audio Visual Room', 'CEAFA, 4th Floor', 300, 'available', ''),
(5, 'AMPH-CEAFA', 'Amphitheater', 'CEAFA, 3rd Floor', 600, 'available', ''),
(6, 'AMPH-SHxx', 'Amphitheater', 'SteerHub, 4th floor', 400, 'available', ''),
(7, 'GYM', 'GYMNASIUM', 'CE, 2nd floor', 1000, 'disable', ''),
(8, 'AVR-CIT', 'Audio Visual Room', 'CIT, 2nd floor', 501, 'available', ''),
(9, 'AVR-SH', 'Audio Visual Room', 'SteerHub, 4th floor', 600, 'available', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm_pass` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `user_status` enum('Active','Pending','Rejected') NOT NULL DEFAULT 'Pending',
  `contact_number` int(10) NOT NULL,
  `reset_code` int(6) NOT NULL,
  `verification_code` int(6) NOT NULL,
  `verification_status` enum('Verified','Pending') NOT NULL DEFAULT 'Pending',
  `reset_expiration` timestamp NULL DEFAULT NULL,
  `employee_ID` int(11) NOT NULL,
  `department_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_ID`, `first_name`, `last_name`, `email`, `password`, `confirm_pass`, `role`, `user_status`, `contact_number`, `reset_code`, `verification_code`, `verification_status`, `reset_expiration`, `employee_ID`, `department_ID`) VALUES
(7, 'Frenz Jonathan', 'Alulod', 'frenz@example.com', '0affd1d02bc5bc471d712de1fc346987', '', 'USER', 'Active', 2147483647, 0, 0, 'Pending', NULL, 123852, 2),
(8, 'Zyke Nathan', 'Villanueva', 'zyke@sample.com', '@sample123', '', 'USER', 'Active', 2147483647, 0, 0, '', NULL, 123258, 2),
(10, 'nathan Renz', 'villanueva', 'nathan@sample.com', '123@sample', '', 'USER', 'Rejected', 2147483647, 0, 0, '', NULL, 587412369, 6),
(11, 'sample admin', 'administrator', 'admin@example.com', 'Admin123!', '', 'ADMIN', 'Active', 2147483647, 0, 0, '', NULL, 2147483647, 6),
(12, 'Lorem Ipsum', 'Villanueva', 'lorem@sample.com', '@lorem123', '', 'USER', 'Active', 966263351, 0, 0, '', NULL, 2147483647, 6),
(13, 'Mell Godwin', 'Barza', 'frenzjonathan5958@gmail.com', '$2y$10$PApBB60bV3iU0H8yTTgXf.9Arsm05cL9cga7aO4VhllhQyJBAC46S', '$2y$10$PApBB60bV3iU0H8yTTgXf.9Arsm05cL9cga7aO4VhllhQyJBAC46S', 'USER', 'Pending', 965247562, 999691, 0, '', '0000-00-00 00:00:00', 2147483647, 6),
(14, 'Krishna Rozel', 'Hernandez', 'krishna@sample.com', 'krishnasample!23', '', 'USER', 'Pending', 2147483647, 0, 0, '', NULL, 2147483647, 4),
(15, 'Krishna Rozel', 'Hernandez', 'krishna@sample.com', 'kirshnasample!23', '', 'USER', 'Pending', 2147483647, 0, 0, '', NULL, 2147483647, 4),
(16, 'Krishna Rozel', 'Hernandez', 'krishna@sample.com', 'kirshnasample!23', '', 'USER', 'Pending', 2147483647, 0, 0, '', NULL, 2147483647, 4),
(17, 'Krishna Rozel', 'Hernandez', 'krishna@sample.com', 'krishsample!23', '', 'USER', 'Pending', 2147483647, 0, 0, '', NULL, 2147483647, 4),
(18, 'Krishna Rozel', 'Hernandez', 'krishna@sample.com', 'krishsample!23', '', 'USER', 'Pending', 2147483647, 0, 0, '', NULL, 2147483647, 4),
(19, 'Frenz Jonathan', 'Alulod', 'frenzjonathan5958+test@gmail.com', 'sample!23', '', 'USER', 'Pending', 2147483647, 0, 0, '', NULL, 2147483647, 1),
(25, 'Karla Mae', 'Alulod', 'villanuevamara23@gmail.com', '$2y$10$QI2TeHRTquQZhYcOrwyT5ewaXHxqUe7QA4PMDGwQhnnWzDnncsroC', '$2y$10$QI2TeHRTquQZhYcOrwyT5ewaXHxqUe7QA4PMDGwQhnnWzDnncsroC', 'USER', 'Pending', 2147483647, 0, 0, '', '0000-00-00 00:00:00', 123852, 9),
(26, 'Mell Godwin', 'Barza', 'mellgodwinbarza04@gmail.com', '$2y$10$LhrNgSIA1SoxzXrGP0ZtwuUzqAnBcpnQiHVeJnW735cnxg/6uHuYK', '', 'USER', 'Pending', 2147483647, 0, 998384, '', NULL, 1234587, 3),
(27, 'Krishna Rozel', 'Hernandez', 'hernandezkrishna09@gmail.com', '$2y$10$qutvJ1FzEzGXuoDBaaPDy.BNY/8bhI1iPkQR7BKFYk2nGyVGdTBWm', '', 'USER', 'Pending', 2147483647, 0, 346512, '', NULL, 1234587, 3),
(28, 'Aira', 'Mutya', 'airamutya0611@gmail.com', '$2y$10$YKwc9drcsVY7.TghQNkAy.u60UZaYgZLQyuikMcygIl7tIO7codeW', '', 'USER', 'Pending', 2147483647, 0, 394617, '', NULL, 1234587, 9),
(29, 'Denz Lythan', 'Avuenalliv', 'frenzjonathan8056@gmail.com', '$2y$10$jPChSVs1xm5oXs.wCLXnn.M46rvrkNESU6wm6EH/F.5Gf9Jpe4ddW', '', 'USER', 'Pending', 2147483647, 0, 160101, '', NULL, 2147483647, 6),
(30, 'Denz Lythan', 'Avuenalliv', 'frenzjonathan86@gmail.com', '$2y$10$dM0F.EDZFV/MWNd4z5XFeuFPJnS1TOJZrSFOesXPJyiCRM24AN2C2', '', 'USER', 'Pending', 2147483647, 0, 729887, '', NULL, 2147483647, 6),
(31, 'Karla Mae', 'sasasa', 'frenzjonathan5958+karla@gmail.com', '$2y$10$KuovciDyHOVPUani338qWed98tG9iVTdd3J.A/tTBXT/RJzENa3Pi', '', 'USER', 'Pending', 966263351, 0, 129146, 'Verified', NULL, 123456, 9),
(32, 'angelica', 'Alulod', 'frenzjonathan5958+lyka@gmail.com', '$2y$10$JYm1srDbPtlFSyiUqvBBdug/QpRo..2k.ldVLAPknGwGVrkXCwoOa', '', 'USER', 'Pending', 2147483647, 0, 571910, 'Verified', NULL, 2147483647, 4),
(33, 'sample', 'registration', 'frenzjonathan5958+regis@gmail.com', '$2y$10$rhBvrhosO4eb8z11raUEoO6ONQwiWUTE3CGI.UnIcaV4Qbiwrl70m', '', 'USER', 'Pending', 2147483647, 0, 956056, 'Verified', NULL, 789965326, 4),
(34, 'Aira', 'Mutya', 'airamutya0611+test2@gmail.com', '$2y$10$vnYIk2UAeUzVrnOWNk27YOT5v78VyIwTMjo14rD2VRPuJcQXQwLqy', '$2y$10$vnYIk2UAeUzVrnOWNk27YOT5v78VyIwTMjo14rD2VRPuJcQXQwLqy', 'USER', 'Active', 2147483647, 0, 209513, 'Pending', '0000-00-00 00:00:00', 2147483647, 9),
(35, 'Aira Duenas', 'Mutya', 'airamutya0611+test3@gmail.com', 'd5ea7e93f1dff863a75275426e26949f', '', 'USER', 'Active', 2147483647, 0, 484851, 'Verified', NULL, 123852796, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_facility`
--

CREATE TABLE `user_facility` (
  `user_facility_ID` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `facility_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_ID`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`device_ID`),
  ADD KEY `facility_ID` (`facility_ID`);

--
-- Indexes for table `event_booking`
--
ALTER TABLE `event_booking`
  ADD PRIMARY KEY (`event_ID`),
  ADD KEY `facility_ID` (`facility_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`facility_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD KEY `department_ID` (`department_ID`);

--
-- Indexes for table `user_facility`
--
ALTER TABLE `user_facility`
  ADD PRIMARY KEY (`user_facility_ID`),
  ADD KEY `facility_ID` (`facility_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `device_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `event_booking`
--
ALTER TABLE `event_booking`
  MODIFY `event_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `facility_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `user_facility`
--
ALTER TABLE `user_facility`
  MODIFY `user_facility_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `device_ibfk_1` FOREIGN KEY (`facility_ID`) REFERENCES `facilities` (`facility_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_booking`
--
ALTER TABLE `event_booking`
  ADD CONSTRAINT `event_booking_ibfk_1` FOREIGN KEY (`facility_ID`) REFERENCES `facilities` (`facility_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_booking_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`department_ID`) REFERENCES `department` (`department_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_facility`
--
ALTER TABLE `user_facility`
  ADD CONSTRAINT `user_facility_ibfk_1` FOREIGN KEY (`facility_ID`) REFERENCES `facilities` (`facility_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_facility_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `user` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
