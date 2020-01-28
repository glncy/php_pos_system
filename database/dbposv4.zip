-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2017 at 12:49 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

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
(1, 'admin', '123456', 'Admin');

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

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblexpired_report`
--

CREATE TABLE `tblexpired_report` (
  `id` int(255) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `generic_name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `expired_qty` int(11) NOT NULL,
  `remaining_qty` int(11) NOT NULL,
  `date` date NOT NULL,
  `barcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `id` int(255) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `generic_name` varchar(100) NOT NULL,
  `qty` int(10) NOT NULL,
  `sold` int(10) NOT NULL,
  `arrival_date` date NOT NULL,
  `category` varchar(50) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `profit_per_piece` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
  `total_amnt` decimal(10,2) NOT NULL,
  `profit` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `id` int(255) NOT NULL
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
  `amount` decimal(10,2) NOT NULL,
  `profit` decimal(10,2) NOT NULL,
  `id` int(255) NOT NULL
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
-- Indexes for table `tblexpired_report`
--
ALTER TABLE `tblexpired_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblproduct_inventory`
--
ALTER TABLE `tblproduct_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblsales_report`
--
ALTER TABLE `tblsales_report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `system_accounts`
--
ALTER TABLE `system_accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblactivity_log`
--
ALTER TABLE `tblactivity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblexpired_report`
--
ALTER TABLE `tblexpired_report`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `tblproduct_inventory`
--
ALTER TABLE `tblproduct_inventory`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblsales_report`
--
ALTER TABLE `tblsales_report`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
