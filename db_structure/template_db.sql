-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2018 at 06:51 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `template_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `absence_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class` varchar(3) NOT NULL,
  `class_id` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `lesson` varchar(50) NOT NULL,
  `year` year(4) NOT NULL,
  `sem` int(1) NOT NULL,
  `date` date NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `avg_marks`
--

CREATE TABLE `avg_marks` (
  `mark_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson` varchar(50) NOT NULL,
  `class` varchar(3) NOT NULL,
  `class_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `sem` int(1) NOT NULL,
  `mark` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_name` varchar(100) NOT NULL,
  `lesson_shrt` varchar(100) NOT NULL,
  `type` varchar(8) NOT NULL,
  `avg_type` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `mark_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson` varchar(50) NOT NULL,
  `class` varchar(3) NOT NULL,
  `class_id` int(11) NOT NULL,
  `status` varchar(3) NOT NULL,
  `mark` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `sem` int(1) NOT NULL,
  `date` date NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `status` varchar(3) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `class` varchar(3) DEFAULT NULL,
  `profil` varchar(4) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `sy` int(11) DEFAULT NULL,
  `csy` int(11) DEFAULT NULL,
  `avg_mark` float DEFAULT NULL,
  `absences` int(11) DEFAULT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`absence_id`);

--
-- Indexes for table `avg_marks`
--
ALTER TABLE `avg_marks`
  ADD PRIMARY KEY (`mark_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`mark_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `absence_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `avg_marks`
--
ALTER TABLE `avg_marks`
  MODIFY `mark_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `mark_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
