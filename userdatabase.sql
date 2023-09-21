-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2023 at 11:41 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spendrite`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(50) NOT NULL,
  `verification_code` varchar(50) NOT NULL,
  `verification_status` int(2) NOT NULL DEFAULT 0,
  `user_status` int(2) NOT NULL DEFAULT 0,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `picture`, `verification_code`, `verification_status`, `user_status`, `username`) VALUES
(39, 'book label', 'book@gmail.com', '821f03288846297c2cf43c34766a38f7', '', '', 0, 0, 'book'),
(40, 'Sudip Khadka', 'ksudip0123@gmail.com', 'b3d97746dbb45e92dc083db205e1fd14', '', '', 0, 0, 'phoenix'),
(42, 'Mahesh Mahesh', 'mahesh@gmail.com', '$2y$10$gt8wLIYx02cP7/.T9ov0wuOEFEDg5NKlBJYtaTJCtrv', '', '', 0, 0, 'mahesh'),
(44, 'user', 'user@gmail.com', '$2y$10$6UWSBw8OLhIJnAuadzRF0.QHkfyPNN9ZeydNlIWMxhf', '', '', 0, 0, 'user'),
(45, 'apple', 'apple@gmail.com', '$2y$10$YWD0KtD0xN9BG58CPnsGbOIKpgfEYjsQ9Zu0y5v0QWmMQ.AeTdDM2', '', '', 0, 0, 'apple');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
