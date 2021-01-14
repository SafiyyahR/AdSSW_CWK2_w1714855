-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 14, 2021 at 11:39 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `w1714855_0`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `user_fname` varchar(40) NOT NULL,
  `user_lname` varchar(40) NOT NULL,
  `user_password` varchar(350) NOT NULL,
  `wishlist_name` varchar(150) NOT NULL,
  `wishlist_description` varchar(150) NOT NULL,
  `wishlist_occasion` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_fname`, `user_lname`, `user_password`, `wishlist_name`, `wishlist_description`, `wishlist_occasion`) VALUES
(8, 'safiyyahlk', 'Safiyyah', 'Rahman', '$2y$10$mtPTF5He6OQpej.K0oyDguOLtMvZpuaHzKHvX8DYM3FcVJzaYaRv2', 'Important List', 'Important stuff to buy', 'Christmas'),
(9, 'safiyyahlts', 'Safiyyah', 'Rahman', '$2y$10$XW4PbMZARkV8rFoiiZVK..CqPswEBT7qRevMWDdEJF02V5CE/Hg7O', 'Important List', 'Important stuff to buy', 'Christmas'),
(10, 'samsam', 'Sameeha', 'Rahman', '$2y$10$HW0YXJ.TrGBFmyv/xpRWJ.9UFUpU2EXT51ezkyrBY..sqq7IDy63e', 'Baby Shower', 'Baby Shower 30/01/2021', 'Baby Shower');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `wli_id` int(10) NOT NULL,
  `wli_user_id` int(10) NOT NULL,
  `wli_title` varchar(40) NOT NULL,
  `wli_url` varchar(350) NOT NULL,
  `wli_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wli_priority` enum('A must have','Nice to have','Only if you can') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wishlist_items`
--

INSERT INTO `wishlist_items` (`wli_id`, `wli_user_id`, `wli_title`, `wli_url`, `wli_price`, `wli_priority`) VALUES
(4, 8, 'Perfume', 'htttp/dfjnd.dffdf.cvo', '40.00', 'Nice to have');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`wli_id`),
  ADD KEY `wli_user_id` (`wli_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `wli_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_fk` FOREIGN KEY (`wli_user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
