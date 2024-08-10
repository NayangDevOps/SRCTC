-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 21, 2024 at 03:30 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `srctc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `srctc_company_setting`
--

CREATE TABLE `srctc_company_setting` (
  `id` int NOT NULL,
  `company_name` varchar(250) DEFAULT NULL,
  `company_banner` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `company_header_logo` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `company_welcome_page_image` varchar(250) DEFAULT NULL,
  `updated_by` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srctc_company_setting`
--

INSERT INTO `srctc_company_setting` (`id`, `company_name`, `company_banner`, `company_header_logo`, `company_welcome_page_image`, `updated_by`, `updated_time`) VALUES
(1, 'SRCTC', '1711994806_8113bf06a3b48389c4eb.jpeg', '1711994806_6d2956fec99324347b39.jpeg', '1711994806_cdef993deaf6b22d8c6c.jpeg', '1', '2024-04-13 04:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `srctc_feedback`
--

CREATE TABLE `srctc_feedback` (
  `id` int NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text,
  `rating` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srctc_feedback`
--

INSERT INTO `srctc_feedback` (`id`, `name`, `email`, `message`, `rating`, `created_at`) VALUES
(1, 'Test', 'test@gmail.com', 'test', 3, '2024-04-28 09:51:30'),
(2, 'test', 'test@gmail.com', 'sbhabsha', 5, '2024-04-28 09:53:14');

-- --------------------------------------------------------

--
-- Table structure for table `srctc_routes`
--

CREATE TABLE `srctc_routes` (
  `id` int NOT NULL,
  `route_train` int DEFAULT NULL,
  `route_start` int DEFAULT NULL,
  `route_end` int DEFAULT NULL,
  `route_stations` varchar(150) DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `arrival_time` time DEFAULT NULL,
  `avl_days` varchar(250) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srctc_routes`
--

INSERT INTO `srctc_routes` (`id`, `route_train`, `route_start`, `route_end`, `route_stations`, `departure_time`, `arrival_time`, `avl_days`, `created_at`, `updated_at`) VALUES
(1, 5, 3, 5, '3,2|3,5|3,6', '22:00:00', '06:00:00', '1,2,3,4,5,6,7', '2024-05-12 11:50:54', NULL),
(2, 3, 5, 4, '5,2|5,4', '00:00:00', '00:00:00', '1,2,3,4,5,6,7', '2024-05-12 17:53:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `srctc_stations`
--

CREATE TABLE `srctc_stations` (
  `id` int NOT NULL,
  `station_name` varchar(150) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srctc_stations`
--

INSERT INTO `srctc_stations` (`id`, `station_name`, `created_at`) VALUES
(2, 'Rajkot', '2024-05-07 16:52:25'),
(3, 'Porbandar', '2024-05-07 16:52:40'),
(4, 'Junagadh', '2024-05-07 16:53:01'),
(5, 'Ahmedabad', '2024-05-07 16:53:19'),
(6, 'Jamnagar', '2024-05-07 16:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `srctc_tariff_routes`
--

CREATE TABLE `srctc_tariff_routes` (
  `id` int NOT NULL,
  `route_id` int DEFAULT NULL,
  `sub_routes` varchar(150) DEFAULT NULL,
  `route_km` int DEFAULT NULL,
  `route_rates` int DEFAULT NULL,
  `adult_price` int DEFAULT NULL,
  `child_price` int DEFAULT NULL,
  `senior_price` int DEFAULT NULL,
  `route_default_rate_pkm` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srctc_tariff_routes`
--

INSERT INTO `srctc_tariff_routes` (`id`, `route_id`, `sub_routes`, `route_km`, `route_rates`, `adult_price`, `child_price`, `senior_price`, `route_default_rate_pkm`) VALUES
(7, 2, '5,2', 10, 1000, 1180, 590, 944, 100),
(8, 2, '5,4', 500, 50000, 59000, 29500, 47200, 100);

-- --------------------------------------------------------

--
-- Table structure for table `srctc_train`
--

CREATE TABLE `srctc_train` (
  `id` int NOT NULL,
  `train_code` varchar(150) DEFAULT NULL,
  `train_name` varchar(200) DEFAULT NULL,
  `coaches` varchar(150) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `rates` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srctc_train`
--

INSERT INTO `srctc_train` (`id`, `train_code`, `train_name`, `coaches`, `release_date`, `rates`, `status`, `created_at`, `updated_at`) VALUES
(3, '927205', 'Saurashtra Express', '1, 2, 3, 4, 5', '2024-05-20', 100, 1, '2024-05-07 16:58:35', NULL),
(4, '432969', 'Saurashtra Mail', '4, 5', '2024-05-25', 145, 0, '2024-05-07 16:59:22', NULL),
(5, '524753', 'Gujarat Express', '1, 2, 3, 4, 5', '2024-05-30', 200, 1, '2024-05-07 17:00:47', NULL),
(6, '715763', 'Vande Bharat', '1, 2, 3, 4, 5', '2024-06-01', 250, 1, '2024-05-07 17:02:13', NULL),
(7, '266100', 'Saurashtra Janta', '1, 2, 3, 4, 5', '2024-05-20', 120, 0, '2024-05-07 17:05:04', NULL),
(8, '966718', 'Rajkot SF Express', '3, 4, 5', '2024-05-25', 150, 0, '2024-05-07 17:07:00', NULL),
(9, '394748', 'Intercity Express', '4, 5', '2024-05-15', 180, 0, '2024-05-07 17:07:52', NULL),
(10, '412298', 'Sudama Express', '2, 3, 4, 5', '2024-05-25', 90, 0, '2024-05-07 17:08:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `srctc_user_reg`
--

CREATE TABLE `srctc_user_reg` (
  `id` int NOT NULL,
  `first_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `display_name` varchar(250) DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mobile_no` int DEFAULT NULL,
  `profile_pic` varchar(250) DEFAULT NULL,
  `gender` int DEFAULT NULL,
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_type` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `srctc_user_reg`
--

INSERT INTO `srctc_user_reg` (`id`, `first_name`, `last_name`, `display_name`, `email`, `mobile_no`, `profile_pic`, `gender`, `password`, `user_type`) VALUES
(1, 'Admin', 'Test', 'Admin', 'admintest@gmail.com', 115151151, '1711876021_5cbe762c06151019aa87.png', 0, '$2y$10$QsiLr/Ny.u4.da6WKPOWZu1Sd29CbX.qRw5PM908vMaY2oNwgPUTG', 10),
(27, 'Shubham', 'Jontagiya', 'Shubham', 'shubham@gmail.com', 1234567890, NULL, 0, '$2y$10$0Y8TkCIwaQtZq7q5Ktr7vO4pscCXUVmS6abJQuGQLVpC5P7vMOrfy', NULL),
(28, 'Tanish ', 'Prajapati ', 'Tanish', 'tanish@gmail.com', 123456789, '1712940063_42410454c46a35ab3384.jpg', 0, '$2y$10$pUxpRrkgSZxX8LWjaN8Gn.AXg/mcDb1NPPBsCUiMb.NAbUg/VAuMy', 1),
(29, 'Test', 'Admin', 'Admin', 'testadmin@gmail.com', 2147483647, NULL, 0, '$2y$10$BLVCWAp6QQ9WxrlGmDkRoedrFGGnDcjT/Lolh6cjkAgTKqnJrBpoC', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `srctc_company_setting`
--
ALTER TABLE `srctc_company_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srctc_feedback`
--
ALTER TABLE `srctc_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srctc_routes`
--
ALTER TABLE `srctc_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srctc_stations`
--
ALTER TABLE `srctc_stations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srctc_tariff_routes`
--
ALTER TABLE `srctc_tariff_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srctc_train`
--
ALTER TABLE `srctc_train`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srctc_user_reg`
--
ALTER TABLE `srctc_user_reg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `srctc_company_setting`
--
ALTER TABLE `srctc_company_setting`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `srctc_feedback`
--
ALTER TABLE `srctc_feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `srctc_routes`
--
ALTER TABLE `srctc_routes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `srctc_stations`
--
ALTER TABLE `srctc_stations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `srctc_tariff_routes`
--
ALTER TABLE `srctc_tariff_routes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `srctc_train`
--
ALTER TABLE `srctc_train`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `srctc_user_reg`
--
ALTER TABLE `srctc_user_reg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
