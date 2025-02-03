/**
 * A PHP program from Grocery Shop Management System Project.
 *
 * @author Noor Haider Khan
 * @version 1.0
 * @since 2025-02-04
 */

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2024 at 07:40 AM
-- Server version: 8.0.37
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `type` enum('regular','irregular') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `Name`, `contact_info`, `address`, `type`) VALUES
(11, 'Bijoy', '0199999233', 'Dighaloy', 'regular'),
(15, 'Avishek Paul', '01745504532', 'natore', 'regular'),
(17, 'Bikas', '0199999999', 'Khulna', 'regular'),
(19, 'Bijoy Avinav Chowdhury', '0199999999', 'nator', 'irregular'),
(20, 'Md Mamun', '01745504532', 'Khulna', 'irregular'),
(21, 'Shahin Chowdhury', '01745686995', 'Khulna', 'regular'),
(22, 'Nabi Hawladar', '01798653241', 'Khulna', 'regular'),
(23, 'Nurullah', '01988547825', 'Narail', 'regular'),
(24, 'Nuhash', '01988547825', 'Narail', 'regular');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `type` enum('owner','general') DEFAULT NULL,
  `workingHour` int DEFAULT NULL,
  `shift` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `Name`, `contact_info`, `address`, `salary`, `type`, `workingHour`, `shift`) VALUES
(2, 'Avishek', '7367832', 'hghdgfh', 56657.00, 'owner', 5, 'day'),
(3, 'Md Noman', '0199999233', 'Dhaka', 10000.00, 'general', 3, 'night');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `Inventory_ID` int NOT NULL AUTO_INCREMENT,
  `Product_ID` int NOT NULL,
  `Update_Date` date NOT NULL,
  `Total_Quantity` int DEFAULT '0',
  `Quantity_Available` int NOT NULL,
  PRIMARY KEY (`Inventory_ID`),
  KEY `Product_ID` (`Product_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`Inventory_ID`, `Product_ID`, `Update_Date`, `Total_Quantity`, `Quantity_Available`) VALUES
(1, 5, '2024-11-30', 71, 21),
(2, 5, '2024-11-30', 71, 21),
(3, 5, '2024-11-30', 71, 21),
(4, 5, '2024-11-30', 71, 21),
(5, 5, '2024-11-30', 71, 21),
(6, 5, '2024-11-30', 71, 10),
(7, 5, '2024-11-30', 71, 5),
(8, 5, '2024-11-30', 71, 5),
(9, 9, '2024-12-01', 5, 2),
(10, 1, '2024-12-10', 55, 10),
(11, 5, '2024-12-10', 200, 10),
(12, 14, '2024-12-11', 60, 10),
(13, 6, '2024-12-02', 60, 50);

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `Invoice_ID` int NOT NULL AUTO_INCREMENT,
  `Supplier_ID` int NOT NULL,
  `Date` date NOT NULL,
  `Total_Amount` decimal(10,2) NOT NULL,
  `Product_ID_1` int DEFAULT NULL,
  `Quantity_1` int DEFAULT NULL,
  `Rate_1` decimal(10,2) DEFAULT NULL,
  `Amount_1` decimal(10,2) DEFAULT NULL,
  `Product_ID_2` int DEFAULT NULL,
  `Quantity_2` int DEFAULT NULL,
  `Rate_2` decimal(10,2) DEFAULT NULL,
  `Amount_2` decimal(10,2) DEFAULT NULL,
  `Product_ID_3` int DEFAULT NULL,
  `Quantity_3` int DEFAULT NULL,
  `Rate_3` decimal(10,2) DEFAULT NULL,
  `Amount_3` decimal(10,2) DEFAULT NULL,
  `Product_ID_4` int DEFAULT NULL,
  `Quantity_4` int DEFAULT NULL,
  `Rate_4` decimal(10,2) DEFAULT NULL,
  `Amount_4` decimal(10,2) DEFAULT NULL,
  `Product_ID_5` int DEFAULT NULL,
  `Quantity_5` int DEFAULT NULL,
  `Rate_5` decimal(10,2) DEFAULT NULL,
  `Amount_5` decimal(10,2) DEFAULT NULL,
  `Product_ID_6` int DEFAULT NULL,
  `Quantity_6` int DEFAULT NULL,
  `Rate_6` decimal(10,2) DEFAULT NULL,
  `Amount_6` decimal(10,2) DEFAULT NULL,
  `Product_ID_7` int DEFAULT NULL,
  `Quantity_7` int DEFAULT NULL,
  `Rate_7` decimal(10,2) DEFAULT NULL,
  `Amount_7` decimal(10,2) DEFAULT NULL,
  `Product_Name_1` varchar(255) DEFAULT NULL,
  `Product_Name_2` varchar(255) DEFAULT NULL,
  `Product_Name_3` varchar(255) DEFAULT NULL,
  `Product_Name_4` varchar(255) DEFAULT NULL,
  `Product_Name_5` varchar(255) DEFAULT NULL,
  `Product_Name_6` varchar(255) DEFAULT NULL,
  `Product_Name_7` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Invoice_ID`),
  KEY `fk_invoice_supplier` (`Supplier_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`Invoice_ID`, `Supplier_ID`, `Date`, `Total_Amount`, `Product_ID_1`, `Quantity_1`, `Rate_1`, `Amount_1`, `Product_ID_2`, `Quantity_2`, `Rate_2`, `Amount_2`, `Product_ID_3`, `Quantity_3`, `Rate_3`, `Amount_3`, `Product_ID_4`, `Quantity_4`, `Rate_4`, `Amount_4`, `Product_ID_5`, `Quantity_5`, `Rate_5`, `Amount_5`, `Product_ID_6`, `Quantity_6`, `Rate_6`, `Amount_6`, `Product_ID_7`, `Quantity_7`, `Rate_7`, `Amount_7`, `Product_Name_1`, `Product_Name_2`, `Product_Name_3`, `Product_Name_4`, `Product_Name_5`, `Product_Name_6`, `Product_Name_7`) VALUES
(44, 2, '2024-11-30', 200.00, 5, 5, 40.00, 200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 2, '2024-11-30', 950.00, 6, 5, 150.00, 750.00, 5, 5, 40.00, 200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 2, '2024-11-30', 950.00, 6, 5, 150.00, 750.00, 5, 5, 40.00, 200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 5, '2024-11-30', 240.00, 5, 6, 40.00, 240.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALL time cake', NULL, NULL, NULL, NULL, NULL, NULL),
(50, 1, '2024-11-21', 800.00, 5, 20, 40.00, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALL time cake', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 5, '2024-11-30', 1200.00, 5, 30, 40.00, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALL time cake', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 1, '2024-11-30', 160.00, 5, 4, 40.00, 160.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALL time cake', NULL, NULL, NULL, NULL, NULL, NULL),
(53, 6, '2024-11-30', 38090.00, 5, 5, 40.00, 200.00, 1, 10, 3789.00, 37890.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ALL time cake', 'Minicate', NULL, NULL, NULL, NULL, NULL),
(55, 5, '2024-12-10', 74600.00, 10, 10, 1380.00, 13800.00, 5, 20, 40.00, 800.00, 1, 15, 4000.00, 60000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Teer Atta', 'ALL time cake', 'Minicate', NULL, NULL, NULL, NULL),
(56, 9, '2024-12-09', 18775.00, 15, 15, 125.00, 1875.00, 20, 20, 60.00, 1200.00, 19, 20, 140.00, 2800.00, 21, 10, 210.00, 2100.00, 16, 30, 110.00, 3300.00, 6, 50, 150.00, 7500.00, NULL, NULL, NULL, NULL, 'Mediplus DS', 'Pepsodent Small', 'Pepsodent Medium', 'Pepsodent Large', 'Closeup', 'Sunsilk', NULL),
(57, 8, '2024-12-10', 124350.00, 1, 10, 4000.00, 40000.00, 10, 10, 1380.00, 13800.00, 12, 20, 2200.00, 44000.00, 13, 20, 1200.00, 24000.00, 22, 50, 13.00, 650.00, 14, 10, 190.00, 1900.00, NULL, NULL, NULL, NULL, 'Minicate', 'Teer Atta', 'Fresh Sugar', 'Fresh Atta', 'Closeup Mini Pack', 'All time tea', NULL),
(58, 6, '2024-12-09', 56550.00, 23, 50, 48.00, 2400.00, 24, 50, 65.00, 3250.00, 18, 100, 65.00, 6500.00, 17, 80, 55.00, 4400.00, 1, 10, 4000.00, 40000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Lifebuoy Small', 'Lifebuoy Medium', 'Vanila Ice Cream', 'Igloo Cone Icecream', 'Minicate', NULL, NULL),
(59, 10, '2024-12-09', 139300.00, 1, 10, 4000.00, 40000.00, 5, 100, 40.00, 4000.00, 11, 10, 220.00, 2200.00, 10, 20, 1380.00, 27600.00, 12, 20, 2200.00, 44000.00, 13, 10, 1200.00, 12000.00, 14, 50, 190.00, 9500.00, 'Minicate', 'ALL time cake', 'Teer Oil', 'Teer Atta', 'Fresh Sugar', 'Fresh Atta', 'All time tea');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `Product_ID` int NOT NULL AUTO_INCREMENT,
  `Product_Name` varchar(100) DEFAULT NULL,
  `Buying_Date` date DEFAULT NULL,
  `Buying_Price` decimal(10,2) DEFAULT NULL,
  `Selling_Price` decimal(10,2) DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Product_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Product_Name`, `Buying_Date`, `Buying_Price`, `Selling_Price`, `Category`) VALUES
(1, 'Minicate', '2024-11-27', 4000.00, 4500.00, 'Rice'),
(5, 'ALL time cake', '2024-11-29', 40.00, 50.00, 'Food'),
(6, 'Sunsilk', '2024-11-30', 150.00, 200.00, 'Shampoo'),
(7, 'Merigold', '2024-11-30', 50.00, 55.00, 'Biscut'),
(9, 'Mojo', '2024-12-01', 20.00, 25.00, 'Soft Drinks'),
(10, 'Teer Atta', '2024-12-02', 1380.00, 1450.00, 'Grocery'),
(11, 'Teer Oil', '2024-12-11', 220.00, 230.00, 'Grocery'),
(12, 'Fresh Sugar', '2024-12-11', 2200.00, 2300.00, 'Grocery'),
(13, 'Fresh Atta', '2024-12-11', 1200.00, 1250.00, 'Grocery'),
(14, 'All time tea', '2024-12-17', 190.00, 210.00, 'Snacks'),
(15, 'Mediplus DS', '2024-12-11', 125.00, 140.00, 'Toothpaste'),
(16, 'Closeup', '2024-12-10', 110.00, 120.00, 'Toothpaste'),
(17, 'Igloo Cone Icecream', '2024-12-10', 55.00, 60.00, 'Snacks'),
(18, 'Vanila Ice Cream', '2024-12-09', 65.00, 75.00, 'Snacks'),
(19, 'Pepsodent Medium', '2024-12-10', 140.00, 150.00, 'Toothpaste'),
(20, 'Pepsodent Small', '2024-12-09', 60.00, 65.00, 'Toothpaste'),
(21, 'Pepsodent Large', '2024-12-03', 210.00, 225.00, 'Toothpaste'),
(22, 'Closeup Mini Pack', '2024-12-10', 13.00, 15.00, 'Toothpaste'),
(23, 'Lifebuoy Small', '2024-12-17', 48.00, 52.00, 'Soap'),
(24, 'Lifebuoy Medium', '2024-12-03', 65.00, 70.00, 'Soap');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `productType` varchar(50) DEFAULT NULL,
  `role` enum('specificDealer','ordinarySupplier') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `Name`, `contact_info`, `address`, `productType`, `role`) VALUES
(1, 'Rian', '01745504532', 'Khulna', 'Oil', 'specificDealer'),
(2, 'Avishek Paul', '01745504532', 'natore', 'rice', 'specificDealer'),
(3, 'Avishek Pau', '01745504532', 'natore', 'rice', 'specificDealer'),
(5, 'Arnob Roy', '0199388373', 'Natore', 'Rice', 'ordinarySupplier'),
(6, 'Md Mustakium Alam', '019385635372', 'Chuadanga', 'Oil', 'ordinarySupplier'),
(7, 'Md Nayeem Hossian', '0199388373', 'Khulna', 'Rice', 'ordinarySupplier'),
(8, 'Ashutosh Banerjee', '01523659847', 'Narail', 'Grocery', 'specificDealer'),
(9, 'Avi Roy Dutta', '01325486898', 'Rangpur', 'Cosmetics', 'ordinarySupplier'),
(10, 'Noor Haider Khan', '01988547825', 'Kishoreganj', 'Grocery', 'ordinarySupplier');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

DROP TABLE IF EXISTS `voucher`;
CREATE TABLE IF NOT EXISTS `voucher` (
  `Voucher_Id` int NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `party_id` int DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Due` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Voucher_Id`),
  KEY `party_id` (`party_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`Voucher_Id`, `date`, `type`, `party_id`, `Amount`, `Due`) VALUES
(12, '2024-11-28', 'Customer', 11, 3000.00, 100.00),
(13, '2024-11-21', 'Customer', 19, 1500.00, 200.00),
(14, '2024-11-22', 'Supplier', 1, 150000.00, 100000.00),
(15, '2024-11-30', 'Supplier', 2, 45789.00, 986.00),
(16, '2024-12-01', 'Supplier', 4, 10000.00, 500.00);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `fk_invoice_supplier` FOREIGN KEY (`Supplier_ID`) REFERENCES `supplier` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
