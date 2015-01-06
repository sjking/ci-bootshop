-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 23, 2014 at 07:27 PM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fba`
--

-- --------------------------------------------------------

--
-- Table structure for table `vegetable`
--

CREATE TABLE IF NOT EXISTS `vegetable` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vegetable`
--

INSERT INTO `vegetable` (`id`, `name`, `order`) VALUES
(1, 'brocolli', 3),
(2, 'tomato', 13),
(3, 'celery', 1),
(4, 'carrot', 9),
(5, 'beet', 2),
(6, 'spinach', 4),
(7, 'cabbage', 11),
(8, 'cactus', 12),
(9, 'eggplant', 7),
(10, 'squash', 10),
(11, 'kale', 8),
(12, 'bok choy', 5),
(13, 'kai-lan', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vegetable`
--
ALTER TABLE `vegetable`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `order` (`order`), ADD UNIQUE KEY `order_2` (`order`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vegetable`
--
ALTER TABLE `vegetable`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
