-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2018 at 05:29 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finalproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `indextable`
--

CREATE TABLE `indextable` (
  `term` varchar(30) NOT NULL,
  `hit` int(15) NOT NULL,
  `postid` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `indextable`
--

INSERT INTO `indextable` (`term`, `hit`, `postid`) VALUES
('hello', 2, 134),
('world', 2, 135),
('we', 3, 136),
('in', 1, 137),
('the', 1, 138),
('247', 1, 139),
('class', 1, 140),
('room', 1, 141),
('again!', 1, 142),
('here', 2, 143),
('again', 2, 144),
('what', 1, 145),
('can', 1, 146),
('i', 1, 147),
('say', 1, 148),
('!', 1, 149);

-- --------------------------------------------------------

--
-- Table structure for table `postfiletable`
--

CREATE TABLE `postfiletable` (
  `id` int(11) NOT NULL,
  `postid` int(15) NOT NULL,
  `docname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postfiletable`
--

INSERT INTO `postfiletable` (`id`, `postid`, `docname`) VALUES
(158, 134, '1'),
(159, 135, '1'),
(160, 136, '1'),
(161, 137, '1'),
(162, 138, '1'),
(163, 139, '1'),
(164, 140, '1'),
(165, 141, '1'),
(166, 142, '1'),
(167, 135, '2'),
(168, 134, '2'),
(169, 136, '2'),
(170, 143, '2'),
(171, 144, '2'),
(172, 145, '3'),
(173, 146, '3'),
(174, 147, '3'),
(175, 148, '3'),
(176, 149, '3'),
(177, 136, '3'),
(178, 143, '3'),
(179, 144, '3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `indextable`
--
ALTER TABLE `indextable`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `postfiletable`
--
ALTER TABLE `postfiletable`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `indextable`
--
ALTER TABLE `indextable`
  MODIFY `postid` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `postfiletable`
--
ALTER TABLE `postfiletable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
