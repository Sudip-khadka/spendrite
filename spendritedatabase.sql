-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2023 at 11:42 AM
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
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expense_head` varchar(50) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `Details` varchar(255) NOT NULL,
  `user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_head`, `amount`, `created_at`, `updated_at`, `Details`, `user_id`) VALUES
(58, 'Travel', 2000, '2023-08-13', '0000-00-00', 'visited pokhera', 40),
(59, 'Bills Payment', 6500, '2023-08-06', '0000-00-00', 'paid room rent for month of august', 40),
(60, 'Bills Payment', 824, '2023-08-10', '0000-00-00', 'paid internet bill', 40),
(61, 'Household', 3000, '2023-08-12', '0000-00-00', 'purchased a table and chair for studying', 40),
(62, 'Bills Payment', 2, '0000-00-00', '0000-00-00', '', 42),
(63, 'Purchases', 400, '2023-08-14', '0000-00-00', 'asf', 42),
(64, 'Food', 500, '2023-09-20', '0000-00-00', 'spent in resturant', 40);

-- --------------------------------------------------------

--
-- Table structure for table `expensesum`
--

CREATE TABLE `expensesum` (
  `education` varchar(255) NOT NULL,
  `food` varchar(255) NOT NULL,
  `travel` varchar(255) NOT NULL,
  `health` varchar(255) NOT NULL,
  `household` varchar(255) NOT NULL,
  `entertainment` varchar(255) NOT NULL,
  `others` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` int(11) NOT NULL,
  `source` varchar(50) NOT NULL,
  `amount` int(50) NOT NULL,
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  `Details` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `source`, `amount`, `created_at`, `updated_at`, `Details`, `user_id`) VALUES
(244, 'Allowance', 50000, '2023-08-01', '0000-00-00', 'got allowance for this month from home', 40),
(246, 'Profit', 600, '2023-08-14', '0000-00-00', 'aefg', 42),
(247, 'Salary', 20000, '2023-08-22', '0000-00-00', 'got paid', 40),
(248, 'Allowance', 40000, '2023-08-29', '0000-00-00', 'mother gave me ', 42),
(252, 'Salary', 6000, '2023-09-20', '0000-00-00', '700', 40);

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
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
