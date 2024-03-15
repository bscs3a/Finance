-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2024 at 12:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `humanresourcesdb`
--

CREATE DATABASE IF NOT EXISTS `humanresourcesdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `humanresourcesdb`;

-- --------------------------------------------------------

--
-- Table structure for table `account_info`
--

CREATE TABLE `account_info` (
  `id` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Product Order','Human Resources','Point of Sale','Inventory','Finance','Delivery') NOT NULL,
  `employees_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `id` int(10) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dateofbirth` datetime NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `civil_status` enum('single','married','divorced','widowed') NOT NULL,
  `applyingForPosition` varchar(30) NOT NULL,
  `apply_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(10) NOT NULL,
  `attendance_date` datetime NOT NULL,
  `clock_in` timestamp NOT NULL DEFAULT current_timestamp(),
  `clock_out` timestamp NOT NULL DEFAULT current_timestamp(),
  `employees_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `benefit_info`
--

CREATE TABLE `benefit_info` (
  `id` int(10) NOT NULL,
  `philhealth` decimal(10,2) NOT NULL,
  `sss_fund` decimal(10,2) NOT NULL,
  `pagibig_fund` decimal(10,2) NOT NULL,
  `thirteenth_month` decimal(10,2) NOT NULL,
  `employees_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `dateofbirth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `civil_status` enum('single','married','divorced','widowed') NOT NULL,
  `department` enum('Product Order','Human Resources','Point of Sale','Inventory','Finance','Delivery') NOT NULL,
  `position` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `image_url`, `first_name`, `last_name`, `dateofbirth`, `gender`, `nationality`, `address`, `contact_no`, `email`, `civil_status`, `department`, `position`) VALUES
(1, 'https://pbs.twimg.com/profile_images/1761013959287623680/tzx6DEES_400x400.jpg', 'Jarelle Anne', 'Pamintuan', '2001-08-31', 'female', 'Filipino', 'Fox Undercover Corporate Kringe Unit', '09675222420', 'jaruunyan31@gmail.com', 'single', 'Human Resources', 'HR Manager'),
(2, NULL, 'Joshua', 'Casupang', '2003-06-21', 'male', 'Filipino', 'Hulaan mo', '123123123', 'joshuacasupang@example.com', 'single', 'Human Resources', 'HR Coordinator'),
(3, NULL, 'Emmanuel Louise', 'Gonzales', '2001-01-01', 'male', 'Filipino', 'Hulaan mo ulit', '456456456', 'emman@example.com', 'single', 'Human Resources', 'Recruiter'),
(4, NULL, 'Antonio Jessechael', 'Maglanque', '2003-01-01', 'male', 'Filipino', 'Di ko alam', '123123123', 'tonje@example.com', 'single', 'Product Order', 'Quality Control Inspector');

-- --------------------------------------------------------

--
-- Table structure for table `employment_info`
--

CREATE TABLE `employment_info` (
  `id` int(10) NOT NULL,
  `dateofhire` datetime NOT NULL,
  `startdate` datetime NOT NULL,
  `enddate` datetime DEFAULT NULL,
  `employees_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(10) NOT NULL,
  `type` varchar(30) NOT NULL,
  `details` varchar(255) NOT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('pending','approved','denied') DEFAULT NULL,
  `employees_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_info`
--

CREATE TABLE `salary_info` (
  `id` int(10) NOT NULL,
  `base_salary` decimal(10,2) NOT NULL,
  `bonus` decimal(10,2) NOT NULL,
  `total_salary` decimal(10,2) NOT NULL,
  `employees_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('Product Order','Human Resources','Point of Sale','Inventory','Finance','Delivery') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_info`
--

CREATE TABLE `tax_info` (
  `id` int(10) NOT NULL,
  `income_tax` decimal(10,2) NOT NULL,
  `withholding_tax` decimal(10,2) NOT NULL,
  `employees_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_info`
--
ALTER TABLE `account_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `employees_id` (`employees_id`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_id` (`employees_id`);

--
-- Indexes for table `benefit_info`
--
ALTER TABLE `benefit_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_id` (`employees_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employment_info`
--
ALTER TABLE `employment_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_id` (`employees_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_id` (`employees_id`);

--
-- Indexes for table `salary_info`
--
ALTER TABLE `salary_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_id` (`employees_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tax_info`
--
ALTER TABLE `tax_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_id` (`employees_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_info`
--
ALTER TABLE `account_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `benefit_info`
--
ALTER TABLE `benefit_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `employment_info`
--
ALTER TABLE `employment_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_info`
--
ALTER TABLE `salary_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_info`
--
ALTER TABLE `tax_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_info`
--
ALTER TABLE `account_info`
  ADD CONSTRAINT `account_info_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `benefit_info`
--
ALTER TABLE `benefit_info`
  ADD CONSTRAINT `benefit_info_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employment_info`
--
ALTER TABLE `employment_info`
  ADD CONSTRAINT `employment_info_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `salary_info`
--
ALTER TABLE `salary_info`
  ADD CONSTRAINT `salary_info_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `tax_info`
--
ALTER TABLE `tax_info`
  ADD CONSTRAINT `tax_info_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
