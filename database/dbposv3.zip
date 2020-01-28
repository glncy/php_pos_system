-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2017 at 12:46 AM
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
-- Table structure for table `admin_order_slip`
--

CREATE TABLE `admin_order_slip` (
  `id` int(6) NOT NULL,
  `product_id` varchar(30) NOT NULL,
  `qty` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(4, 'cashier', '1234', 'Cashier');

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
('908282', '2017-11-11', 'Added  in Product List.', 158),
('191436', '2017-11-11', 'Deleted  in Product List.', 159),
('386949', '2017-11-11', 'Added 1 in Product List.', 160),
('514742', '2017-11-11', 'Added  in Product List.', 161),
('139035', '2017-11-11', 'Deleted 1 in Product List.', 162),
('488296', '2017-11-11', 'Added iowrpoiw in Product List.', 163),
('681413', '2017-11-11', 'Added 300 stocks to iowrpoiw pwoirpwqoi.', 164),
('418630', '2017-11-11', 'Added 200 Expired Stocks in iowrpoiw.', 165),
('941880', '2017-11-11', 'Added 300 stocks to iowrpoiw pwoirpwqoi.', 166),
('757059', '2017-11-11', 'Added  in Product List.', 167),
('491642', '2017-11-11', 'Deleted  in category.', 168),
('880504', '2017-11-11', 'Added  in Product List.', 169),
('163596', '2017-11-11', 'Deleted  in category.', 170),
('293627', '2017-11-11', 'Deleted  in category.', 171),
('408277', '2017-11-11', 'Deleted  in category.', 172),
('438638', '2017-11-17', 'Added Vitamins in Product List.', 173),
('452049', '2017-11-17', 'Edited iowrpoiw in Product List.', 174),
('332968', '2017-11-17', 'Edited iowrpoiw in Product List.', 175),
('513317', '2017-11-17', 'Added Ceelin in Product List.', 176),
('733032', '2017-11-17', 'Added 300 stocks to Ceelin asdadawewfd.', 177),
('452382', '2017-11-17', 'Edited Ceelin in Product List.', 178),
('192764', '2017-11-17', 'Edited Ceelin in Product List.', 179),
('969852', '2017-11-17', 'Edited Ceelin in Product List.', 180),
('910264', '2017-11-17', 'Edited Ceelin in Product List.', 181),
('712731', '2017-11-17', 'Edited Ceelin in Product List.', 182),
('812386', '2017-11-17', 'Edited Ceelin in Product List.', 183),
('154176', '2017-11-17', 'Edited Ceelin in Product List.', 184);

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

--
-- Dumping data for table `tblexpired_report`
--

INSERT INTO `tblexpired_report` (`id`, `brand_name`, `generic_name`, `category`, `expired_qty`, `remaining_qty`, `date`, `barcode`) VALUES
(9, 'iowrpoiw', 'pwoirpwqoi', '', 200, 105, '2017-11-11', '0000000');

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

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`id`, `barcode`, `brand_name`, `original_price`, `selling_price`, `generic_name`, `qty`, `sold`, `arrival_date`, `category`, `total_price`, `profit_per_piece`) VALUES
(103, '82193812', 'Ceelin', '16.00', '20.24', 'asdadawewfd', 320, 0, '2017-11-08', 'Vitamins', '6476.80', '4.24');

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

--
-- Dumping data for table `tblproduct_inventory`
--

INSERT INTO `tblproduct_inventory` (`invoice`, `date`, `brand_name`, `generic_name`, `category`, `qty`, `remain_qty`, `total_amnt`, `profit`, `price`, `id`) VALUES
('403806', '2017-11-11', 'iowrpoiw', 'pwoirpwqoi', '', 30, 375, '300000.00', '150000.00', '10000.00', 1);

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
-- Dumping data for table `tblsales_report`
--

INSERT INTO `tblsales_report` (`trans_id`, `date`, `customer_name`, `invoice`, `amount`, `profit`, `id`) VALUES
('2017-20707', '2017-11-11', '', '403806', '300000.00', '150000.00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_order_slip`
--
ALTER TABLE `admin_order_slip`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `admin_order_slip`
--
ALTER TABLE `admin_order_slip`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_accounts`
--
ALTER TABLE `system_accounts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblactivity_log`
--
ALTER TABLE `tblactivity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblsales_report`
--
ALTER TABLE `tblsales_report`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
