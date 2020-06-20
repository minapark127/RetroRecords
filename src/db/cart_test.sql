-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2020 at 09:59 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cart_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL,
  `categoryTitle` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoryDesc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryId`, `categoryTitle`, `categoryDesc`) VALUES
(1, 'Retro', 'Retro records'),
(2, 'Rare', 'Rare LPs');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ordersId` int(11) NOT NULL,
  `orderDate` datetime DEFAULT NULL,
  `orderName` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `orderAddress` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `orderCity` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `orderState` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `orderPostcode` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `orderTel` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `orderEmail` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `productTotal` float(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `orders_productsId` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `sel_productId` int(11) DEFAULT NULL,
  `sel_productQty` smallint(6) DEFAULT NULL,
  `sel_productSize` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sel_productColor` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sel_productPrice` float(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `productTitle` varchar(75) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `productPrice` float(8,2) DEFAULT NULL,
  `productDesc` text COLLATE utf8mb4_general_ci,
  `productImg` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoryId` int(11) NOT NULL,
  `productsQty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productTitle`, `productPrice`, `productDesc`, `productImg`, `categoryId`, `productsQty`) VALUES
(1, 'retro1', 100.00, 'retro record 1', 'retro1.jpg', 1, 1000),
(2, 'retro2', 150.00, 'retro record 2', 'retro2.jpg', 1, 1000),
(3, 'retro3', 120.00, 'retro record 3', 'retro3.jpg', 1, 1000),
(4, 'retro4', 120.00, 'retro record 4', 'retro4.jpg', 1, 1000),
(5, 'retro5', 80.00, 'retro record 5', 'retro5.jpg', 1, 1000),
(6, 'rare1', 80.00, 'rare record 1', 'rare1.jpg', 2, 1000),
(7, 'rare2', 280.00, 'rare record 2', 'rare2.jpg', 2, 1000),
(8, 'rare3', 220.00, 'rare record 3', 'rare3.jpg', 2, 1000),
(9, 'rare4', 530.00, 'rare record 4', 'rare4.jpg', 2, 1000),
(10, 'rare5', 180.00, 'rare record 5', 'rare5.jpg', 2, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `shoppertrack`
--

CREATE TABLE `shoppertrack` (
  `trackId` int(11) NOT NULL,
  `sessionId` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sel_productId` int(11) DEFAULT NULL,
  `sel_productQty` smallint(6) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`),
  ADD UNIQUE KEY `categoryTitle` (`categoryTitle`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ordersId`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`orders_productsId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `shoppertrack`
--
ALTER TABLE `shoppertrack`
  ADD PRIMARY KEY (`trackId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ordersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `orders_productsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shoppertrack`
--
ALTER TABLE `shoppertrack`
  MODIFY `trackId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
