-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 03:23 PM
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
-- Database: `aralink`
--

-- --------------------------------------------------------

--
-- Table structure for table `classadmin`
--

CREATE TABLE `classadmin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `classname` varchar(200) NOT NULL,
  `classcode` varchar(200) NOT NULL,
  `images` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classadmin`
--

INSERT INTO `classadmin` (`id`, `name`, `email`, `password`, `code`, `status`, `classname`, `classcode`, `images`) VALUES
(1, 'darwannn', 'darwinsanluis.ramos14@gmail.com', '$2y$10$UaPrwAhdOUxzWXv4SGIuPe8vi.mY8FQw/2wI3BhiVKmVMCKhyG7xq', '0', 'verified', 'Web Development', 'rHRD0C8d', '');

-- --------------------------------------------------------

--
-- Table structure for table `classsubject`
--

CREATE TABLE `classsubject` (
  `id` int(11) NOT NULL,
  `subjects` varchar(200) NOT NULL,
  `subjectcode` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classsubject`
--

INSERT INTO `classsubject` (`id`, `subjects`, `subjectcode`) VALUES
(6, 'HTML', 'rHRD0C8d'),
(7, 'CSS', 'rHRD0C8d'),
(8, 'JS', 'rHRD0C8d'),
(9, 'PHP', 'rHRD0C8d');

-- --------------------------------------------------------

--
-- Table structure for table `classvideo`
--

CREATE TABLE `classvideo` (
  `id` int(11) NOT NULL,
  `titles` varchar(200) NOT NULL,
  `subjects` varchar(200) NOT NULL,
  `dates` varchar(200) DEFAULT NULL,
  `links` varchar(200) NOT NULL,
  `linkcode` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classvideo`
--

INSERT INTO `classvideo` (`id`, `titles`, `subjects`, `dates`, `links`, `linkcode`) VALUES
(1, 'What is HTML', 'HTML', 'May 20, 2024', 'https://www.youtube.com/embed/0e24EcNapsA?si=Z9vD0_b9oDJEGc0o', 'rHRD0C8d'),
(2, 'Syntax and Document Structure', 'HTML', 'May 20, 2024', 'https://www.youtube.com/embed/ak2K86gCR-I?si=Qq_qUEp8XaVO0S36', 'rHRD0C8d'),
(3, 'rHRD0C8d', 'HTML', 'May 20, 2024', 'https://www.youtube.com/embed/Dm_38sQiaI4?si=CBSepFYqqrq8Of_f', 'rHRD0C8d'),
(4, 'What is JavaScript?', 'JS', 'May 20, 2024', 'https://www.youtube.com/embed/eVVyXoBueb8?si=FefHXUOkMrtgYaay', 'rHRD0C8d'),
(5, 'JavaScript Syntax and Comments', 'JS', 'May 20, 2024', 'https://www.youtube.com/embed/y4tWF-wHMCE?si=SkS7PRwEsoLh5COH', 'rHRD0C8d'),
(6, 'What is CSS?', 'JS', 'August 8, 2021', 'https://www.youtube.com/embed/FFOQRK1K7N0?si=LBLtaCiaXzpv4Anf', 'rHRD0C8d'),
(7, 'CSS Syntax', 'CSS', 'May 20, 2024', 'https://www.youtube.com/embed/KjfjCnu64tc?si=IN440PPfQwJuSw2a', 'rHRD0C8d'),
(8, 'CSS Comments', 'CSS', 'May 20, 2024', 'https://www.youtube.com/embed/H_QalUqonfc?si=bt2IsJDaBU3-rzit', 'rHRD0C8d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classadmin`
--
ALTER TABLE `classadmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classsubject`
--
ALTER TABLE `classsubject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classvideo`
--
ALTER TABLE `classvideo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classadmin`
--
ALTER TABLE `classadmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `classsubject`
--
ALTER TABLE `classsubject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `classvideo`
--
ALTER TABLE `classvideo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
