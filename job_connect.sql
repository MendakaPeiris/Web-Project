-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 02:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `job_type` varchar(50) NOT NULL,
  `application_deadline` date NOT NULL,
  `salary` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_title`, `company`, `location`, `job_type`, `application_deadline`, `salary`, `description`, `requirements`, `contact_name`, `contact_email`, `contact_phone`, `created_at`, `user_id`) VALUES
(4, 'Software Engineer ', 'TechSolutions Lanka', 'Colombo', 'Internship', '2023-08-15', 'LKR 100,000 - 150,000 per month', 'We are seeking a talented Software Engineer to join our dynamic team. The ideal candidate will have strong programming skills and a passion for creating innovative solutions.', 'Bachelor\'s degree in Computer Science, 3+ years of experience in software development, proficiency in Java and Python', 'Amelia Perera', 'careers@techsolutions.lk', '+94 11 2345678', '2024-10-01 22:19:52', 6),
(5, 'Marketing Manager', 'BrandBoost Inc.', 'Kandy', 'full-time', '2023-07-30', 'LKR 120,000 - 180,000 per month', 'BrandBoost Inc. is looking for an experienced Marketing Manager to lead our marketing efforts and drive brand growth in the Sri Lankan market.', 'MBA in Marketing, 5+ years of experience in digital marketing, strong analytical skills', 'Rajitha Fernando', 'hr@brandboost.lk', '+94 81 2345678', '2024-10-01 22:19:52', 6),
(6, 'Graphic Designer', 'CreativeMinds Studio', 'Galle', 'part-time', '2023-08-10', 'LKR 40,000 - 60,000 per month', 'CreativeMinds Studio is seeking a talented Graphic Designer to create visually stunning designs for various client projects.', 'Degree in Graphic Design, proficiency in Adobe Creative Suite, strong portfolio', 'Dilshan Gunasekara', 'jobs@creativeminds.lk', '+94 91 2345678', '2024-10-01 22:19:52', 6),
(7, 'Data Analyst', 'DataDriven Solutions', 'Colombo', 'full-time', '2023-08-20', 'LKR 90,000 - 130,000 per month', 'We are looking for a skilled Data Analyst to join our team and help derive valuable insights from complex datasets.', 'Bachelor\'s degree in Statistics or related field, experience with SQL and Python, strong analytical skills', 'Priyanka Silva', 'careers@datadriven.lk', '+94 11 3456789', '2024-10-01 22:19:52', 6),
(8, 'Customer Service', 'ServicePro Lanka', 'Negombo', 'full-time', '2023-07-25', 'LKR 40,000 - 60,000 per month', 'ServicePro Lanka is hiring friendly and efficient Customer Service Representatives to assist our clients and ensure customer satisfaction.', 'Excellent communication skills, fluency in English and Sinhala, customer service experience', 'Chamathka Perera', 'hr@servicepro.lk', '+94 31 2345678', '2024-10-01 22:19:52', 6),
(9, 'Junior Accountant', 'FinanceFirst Ltd.', 'Colombo', 'internship', '2023-08-05', 'LKR 25,000 - 35,000 per month', 'FinanceFirst Ltd. is offering an internship opportunity for a Junior Accountant to gain hands-on experience in financial operations.', 'Studying for a degree in Accounting or Finance, knowledge of basic accounting principles, attention to detail', 'Nuwan Bandara', 'internships@financefirst.lk', '+94 11 4567890', '2024-10-01 22:19:52', 6);

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `cv_file` varchar(255) NOT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monthly_payments`
--

CREATE TABLE `monthly_payments` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `card_number` varchar(255) NOT NULL,
  `expiry_date` varchar(10) NOT NULL,
  `cvv` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('job_seeker','employer','admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` int(11) DEFAULT NULL,
  `company` varchar(80) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `user_type`, `created_at`, `phone`, `company`, `location`) VALUES
(6, 'test', 'test@gmail.com', '$2y$10$uSECy.0kdMBdk/MTQ8RzCuU7hzI9oGMUzY1et3VaJrBIWLGc3D5zK', 'job_seeker', '2024-10-02 07:23:55', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monthly_payments`
--
ALTER TABLE `monthly_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `monthly_payments`
--
ALTER TABLE `monthly_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
