-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2019 at 12:57 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crawler`
--

-- --------------------------------------------------------

--
-- Table structure for table `website`
--

CREATE TABLE `website` (
  `id` int(10) NOT NULL,
  `url` varchar(250) NOT NULL,
  `nofollow` tinyint(1) NOT NULL,
  `time_checked` datetime NOT NULL DEFAULT '1001-01-01 00:00:00',
  `url_host` varchar(250) NOT NULL,
  `contains_link` tinyint(1) NOT NULL DEFAULT '0',
  `checked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `website`
--

INSERT INTO `website` (`id`, `url`, `nofollow`, `time_checked`, `url_host`, `contains_link`, `checked`) VALUES
(2, 'http://www.hostinger.com', 0, '2019-02-25 00:53:20', 'https://www.hostinger.lt', 1, 0),
(4, 'https://hostinger.com', 0, '2019-02-25 00:53:21', 'https://www.hostinger.lt', 1, 0),
(8, 'http://www.hostinger.com', 0, '2019-02-25 00:53:22', 'https://www.hostinger.kr', 1, 0),
(10, 'http://www.hostinger.com', 1, '2019-02-25 00:53:22', 'hostinger.com', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `website`
--
ALTER TABLE `website`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `website`
--
ALTER TABLE `website`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
