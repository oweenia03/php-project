-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2020 at 12:40 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nodemcu_rfid_iot_projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `table_the_iot_projects`
--

CREATE TABLE `table_the_iot_projects` (
  `num` int AUTO_INCREMENT NOT NULL,
  `id` varchar(100) NOT NULL,
  `uname` varchar(20) NOT NULL,
  `price` varchar(15) NOT NULL,
  `Expiration` date NOT NULL,
  `stock_status` char(1) NOT NULL,
  PRIMARY KEY (`num`)  -- PRIMARY KEY를 num에 유지
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;  -- utf8mb4로 통일


--
-- Dumping data for table `table_the_iot_projects`
--

INSERT INTO `table_the_iot_projects` (`id`, `uname`, `price`, `Expiration`, `stock_status`) VALUES
('39EAB06D', 'Chocolate', '1000', '2025-12-31', 'Y'),
('769174F8', 'Milk', '1500', '2024-11-30', 'N'),
('81A3DC79', 'Juice', '1200', '2023-10-15', 'Y'),
('866080F8', 'Ramen', '1800', '2026-01-01', 'N');

-- Indexes for dumped tables
--

-- No need to add another PRIMARY KEY on `id` because `num` is the PRIMARY KEY
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

