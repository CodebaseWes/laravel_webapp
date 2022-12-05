-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 05, 2022 at 12:42 AM
-- Server version: 5.7.22
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Table structure for table `Holidays`
--

CREATE TABLE `Holidays` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Holidays`
--

INSERT INTO `Holidays` (`id`, `name`, `date`) VALUES
(1, 'MLK', 'third monday of january'),
(2, 'Presidents Day', 'third monday of February'),
(3, 'Easter', 'easter_date'),
(4, 'Memorial Day', 'last monday of may'),
(5, 'New Year', '1st Jan'),
(6, 'Independence Day', 'July 4'),
(7, 'Juneteenth', 'June 19'),
(8, 'Labor Day', 'September 5'),
(9, 'Columnbus Day', 'October 10'),
(10, 'Veterans Day', 'November 11'),
(11, 'Thanksgiving', 'November 24'),
(12, 'Christmas', 'December 25');

-- --------------------------------------------------------

--
-- Table structure for table `Manufacturers`
--

CREATE TABLE `Manufacturers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Manufacturers`
--

INSERT INTO `Manufacturers` (`id`, `name`) VALUES
(1, 'Scrooge Inc'),
(2, 'Holidays Off');

-- --------------------------------------------------------

--
-- Table structure for table `Manufacturers_Holidays`
--

CREATE TABLE `Manufacturers_Holidays` (
  `mfr_id` int(11) NOT NULL,
  `holiday_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Manufacturers_Holidays`
--

INSERT INTO `Manufacturers_Holidays` (`mfr_id`, `holiday_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `productId` int(11) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `inventoryQuantity` int(11) NOT NULL,
  `shipOnWeekends` tinyint(1) NOT NULL,
  `maxBusinessDaysToShip` int(11) NOT NULL,
  `Mfr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`productId`, `productName`, `inventoryQuantity`, `shipOnWeekends`, `maxBusinessDaysToShip`, `Mfr`) VALUES
(1, 'fugiat exercitation adipisicing', 43, 1, 13, 1),
(2, 'mollit cupidatat Lorem', 70, 1, 18, 1),
(3, 'non quis sint', 33, 0, 15, 1),
(4, 'voluptate cupidatat non', 52, 0, 18, 1),
(5, 'anim amet occaecat', 39, 1, 19, 1),
(6, 'cillum deserunt elit', 47, 0, 20, 1),
(7, 'adipisicing reprehenderit et', 71, 0, 15, 1),
(8, 'ex mollit laboris', 80, 0, 15, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Holidays`
--
ALTER TABLE `Holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Manufacturers`
--
ALTER TABLE `Manufacturers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`productId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Holidays`
--
ALTER TABLE `Holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Manufacturers`
--
ALTER TABLE `Manufacturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
