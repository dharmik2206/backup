-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 10:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carinfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `carinfo`
--

CREATE TABLE `carinfo` (
  `car_year` int(11) NOT NULL,
  `car_company` varchar(50) NOT NULL,
  `car_name` varchar(50) NOT NULL,
  `car_speed` int(11) NOT NULL,
  `car_speedtime` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carinfo`
--

INSERT INTO `carinfo` (`car_year`, `car_company`, `car_name`, `car_speed`, `car_speedtime`, `id`) VALUES
(2012, 'MITSUBISHI', 'i-MiEV', 100, 7, 1),
(2012, 'NISSAN', 'LEAF', 117, 7, 2),
(2013, 'FORD', 'FOCUS ELECTRIC', 122, 4, 3),
(2013, 'MITSUBISHI', 'i-MiEV', 100, 7, 4),
(2013, 'NISSAN', 'LEAF', 117, 7, 5),
(2013, 'SMART', 'FORTWO ELECTRIC DRIVE CABRIOLET', 109, 8, 6),
(2013, 'SMART', 'FORTWO ELECTRIC DRIVE COUPE', 109, 8, 7),
(2013, 'TESLA', 'MODEL S (40 kWh battery)', 224, 6, 8),
(2013, 'TESLA', 'MODEL S (60 kWh battery)', 335, 10, 9),
(2013, 'TESLA', 'MODEL S (85 kWh battery)', 426, 12, 10),
(2013, 'TESLA', 'MODEL S PERFORMANCE', 426, 12, 11),
(2014, 'CHEVROLET', 'SPARK EV', 131, 7, 12),
(2014, 'FORD', 'FOCUS ELECTRIC', 122, 4, 13),
(2014, 'MITSUBISHI', 'i-MiEV', 100, 7, 14),
(2014, 'NISSAN', 'LEAF', 135, 5, 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carinfo`
--
ALTER TABLE `carinfo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carinfo`
--
ALTER TABLE `carinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
