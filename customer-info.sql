-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2017 at 06:07 PM
-- Server version: 5.7.18-1
-- PHP Version: 7.1.6-2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customer-info`
--
CREATE DATABASE IF NOT EXISTS `customer-info` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `customer-info`;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `contact` varchar(60) NOT NULL,
  `name` varchar(50) NOT NULL,
  `order_no` varchar(20) NOT NULL,
  `issue_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `contact`, `name`, `order_no`, `issue_date`) VALUES
(44, '01771224089', 'Martin', '254', '2017-11-28 15:48:47'),
(45, '01818775899', 'John', '445', '2017-11-28 17:29:49'),
(47, '01771224089', 'Martin', '446', '2017-11-28 17:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(60) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_name`, `user_password`, `user_type`) VALUES
(17, 'admin@demo.com', 'John Adam', '$2y$10$3IJOTupJbwSunKAnOssoJOPa1bkRQCksIkzr6mcV6gGTP/aQHetsC', 'admin'),
(19, 'alice@demo.com', 'Alice', '$2y$10$rhQft6ncyZq783/Nn.N7XuaPqOuftoyohRVP4k1Mvm.CEStP9OaTq', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
