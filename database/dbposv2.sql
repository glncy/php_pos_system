-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2017 at 08:49 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpos`
--

-- --------------------------------------------------------

--
-- Table structure for table `system_accounts`
--

CREATE TABLE `system_accounts` (
  `id` int(255) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `pw` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `system_accounts`
--

INSERT INTO `system_accounts` (`id`, `user_name`, `pw`, `role`) VALUES
(1, 'admin', '123456', 'Admin'),
(2, 'cashier1', '123456', 'Cashier');

-- --------------------------------------------------------

--
-- Table structure for table `tblactivity_log`
--

CREATE TABLE `tblactivity_log` (
  `activity_id` varchar(50) NOT NULL,
  `activity_date` date NOT NULL,
  `activity` text NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblactivity_log`
--

INSERT INTO `tblactivity_log` (`activity_id`, `activity_date`, `activity`, `id`) VALUES
('274027', '2017-09-13', 'Added  in Product List.', 77),
('666972', '2017-09-13', 'Added oioi in Product List.', 78),
('426925', '2017-09-13', 'Edited  in Product List.', 79),
('276434', '2017-09-13', 'Edited  in Product List.', 80),
('955545', '2017-09-13', 'Added 10 stocks to  .', 81),
('391401', '2017-09-13', 'Added 30 stocks to oioi oioi.', 82),
('505351', '2017-09-13', 'Edited  in Product List.', 83),
('931837', '2017-09-13', 'Edited  in Product List.', 84);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `category`) VALUES
(1, 'Vitamins');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(255) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `original_price` float NOT NULL,
  `selling_price` float NOT NULL,
  `generic_name` varchar(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `sold` int(10) NOT NULL,
  `arrival_date` date NOT NULL,
  `category` varchar(50) NOT NULL,
  `total_price` float NOT NULL,
  `profit_per_piece` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `barcode`, `brand_name`, `original_price`, `selling_price`, `generic_name`, `qty`, `sold`, `arrival_date`, `category`, `total_price`, `profit_per_piece`) VALUES
(96, '0', '', 10.25, 20.5, '', 50, 0, '0000-00-00', '', 1025, 10.25),
(97, '0', 'oioi', 12, 20, 'oioi', 40, 0, '2017-09-13', 'Vitamins', 800, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct_inventory`
--

CREATE TABLE `tblproduct_inventory` (
  `invoice` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `brand_name` varchar(50) NOT NULL,
  `generic_name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `qty` int(10) NOT NULL,
  `remain_qty` int(10) NOT NULL,
  `total_amnt` float NOT NULL,
  `profit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblsales_report`
--

CREATE TABLE `tblsales_report` (
  `trans_id` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `invoice` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `profit` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `system_accounts`
--
ALTER TABLE `system_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblactivity_log`
--
ALTER TABLE `tblactivity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `system_accounts`
--
ALTER TABLE `system_accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tblactivity_log`
--
ALTER TABLE `tblactivity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
