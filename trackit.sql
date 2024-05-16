-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2024 at 05:01 PM
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
-- Database: `trackit`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `departments_id` int(11) NOT NULL,
  `departments_name` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`departments_id`, `departments_name`) VALUES
(1, 'College of Computer Studies'),
(2, 'College of Engineering'),
(3, 'College of Architecture'),
(4, 'College of Criminology'),
(5, 'College of Nursing'),
(6, 'College of Arts and Sciences'),
(7, 'College of Business Administration and Accountancy'),
(8, 'College of Physical and Occupational Therapy'),
(9, 'College of International Tourism and Hospitality Management'),
(10, 'College of Pharmacy'),
(11, 'College of Radiologic Technology');

-- --------------------------------------------------------

--
-- Table structure for table `department_events`
--

CREATE TABLE `department_events` (
  `departments_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department_users`
--

CREATE TABLE `department_users` (
  `departments_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_users`
--

INSERT INTO `department_users` (`departments_id`, `users_id`) VALUES
(1, 89);

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `email_verification_id` int(11) NOT NULL,
  `email_verification_users_id` int(11) NOT NULL,
  `email_verification_token` varchar(64) NOT NULL,
  `email_verification_new_email` varchar(255) NOT NULL,
  `email_verification_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_verification`
--

INSERT INTO `email_verification` (`email_verification_id`, `email_verification_users_id`, `email_verification_token`, `email_verification_new_email`, `email_verification_created_at`) VALUES
(41, 89, 'fdc05733a019474c1e6250f14c762d646bab2be1db53d2ffc420484bc304aedb', 'cantara.michaelangelo@gmail.com', '2024-05-16 06:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `events_id` int(11) NOT NULL,
  `events_name` varchar(255) DEFAULT NULL,
  `events_description` text DEFAULT NULL,
  `events_date` datetime DEFAULT NULL,
  `events_budget` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`events_id`, `events_name`, `events_description`, `events_date`, `events_budget`) VALUES
(22, 'Data Mining Onsite Seminar', 'An onsite seminar to give students the understanding how data mining enhances analytical skills, improves data literacy and recognize its impact.', '2024-05-15 13:00:00', 1320.00),
(23, 'TechTutor: Empowering Communities with AI-Assisted IT Skills Community Outreach Seminar', 'This event will provide a fun and interactive environment where participants can learn from presentations, engage in hands-on activities, and utilize AI-powered tools.', '2024-05-17 09:00:00', 2280.00),
(24, 'Hackin’ ka na lang 2024: “Unveiling Future Horizon: Exploring Limitless Potentials in the field of  Cybersecurity and Artificial Intelligence”', 'Onsite seminar about information security and ethical hacking', '2024-04-27 08:00:00', 3400.00),
(25, 'Clutch or Cancel: CCS Valorant Masters Invitational', 'Online Valorant tournament for all CSS students.', '2024-01-29 08:00:00', 4460.00),
(26, 'College of Computer Studies Christmas Party 2023', 'Christmas party for the council officers, faculty and staff.', '2023-12-13 13:00:00', 6806.00),
(27, 'test', 'test', '2024-05-16 14:49:00', 1.00);

-- --------------------------------------------------------

--
-- Table structure for table `event_invitations`
--

CREATE TABLE `event_invitations` (
  `event_invitations_id` int(11) NOT NULL,
  `event_invitations_events_id` int(11) NOT NULL,
  `event_invitations_email` varchar(255) NOT NULL,
  `event_invitations_token` varchar(64) NOT NULL,
  `event_invitations_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `login_attempt_id` int(11) NOT NULL,
  `login_attempt_ip_address` varchar(45) NOT NULL,
  `login_attempt_count` int(11) NOT NULL DEFAULT 0,
  `login_attempt_last_attempt_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`login_attempt_id`, `login_attempt_ip_address`, `login_attempt_count`, `login_attempt_last_attempt_time`) VALUES
(1, '::1', 0, '2024-05-16 06:47:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `password_reset_id` int(11) NOT NULL,
  `password_reset_users_id` int(11) NOT NULL,
  `password_reset_selector` text NOT NULL,
  `password_reset_token` longtext NOT NULL,
  `password_reset_expires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `profiles_id` int(11) NOT NULL,
  `profiles_about` text NOT NULL,
  `profiles_introduction_title` text NOT NULL,
  `profiles_introduction_text` text NOT NULL,
  `users_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profiles_id`, `profiles_about`, `profiles_introduction_title`, `profiles_introduction_text`, `users_id`) VALUES
(10, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to michaelangelocantara\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 89);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` int(11) NOT NULL,
  `events_id` int(11) DEFAULT NULL,
  `transaction_name` varchar(255) DEFAULT NULL,
  `transaction_description` text DEFAULT NULL,
  `transaction_date` datetime DEFAULT NULL,
  `transaction_amount` decimal(10,2) DEFAULT NULL,
  `transaction_price` decimal(10,2) DEFAULT NULL,
  `transaction_total` decimal(10,2) GENERATED ALWAYS AS (`transaction_amount` * `transaction_price`) VIRTUAL,
  `transaction_category` varchar(255) DEFAULT NULL,
  `transaction_type` enum('expense','income') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `users_first_name` varchar(50) NOT NULL,
  `users_last_name` varchar(50) NOT NULL,
  `users_username` varchar(50) NOT NULL,
  `users_email` varchar(100) NOT NULL,
  `users_role` varchar(50) NOT NULL,
  `users_password` varchar(255) NOT NULL,
  `users_email_verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_first_name`, `users_last_name`, `users_username`, `users_email`, `users_role`, `users_password`, `users_email_verified`) VALUES
(89, 'Michael Angelo', 'Cantara', 'michaelangelocantara', 'cantara.michaelangelo@gmail.com', 'Student-Council-Officer', '$2y$10$7iY7WQXunYMdwD8s3QZNfO/fxiOsTBrjelmfwslsbirEI8wGzXMAy', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_attempts`
--

CREATE TABLE `user_login_attempts` (
  `users_id` int(11) NOT NULL,
  `login_attempt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`departments_id`);

--
-- Indexes for table `department_events`
--
ALTER TABLE `department_events`
  ADD PRIMARY KEY (`departments_id`,`events_id`),
  ADD KEY `events_id` (`events_id`);

--
-- Indexes for table `department_users`
--
ALTER TABLE `department_users`
  ADD PRIMARY KEY (`departments_id`,`users_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD PRIMARY KEY (`email_verification_id`),
  ADD KEY `email_verification_users_id` (`email_verification_users_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`events_id`);

--
-- Indexes for table `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD PRIMARY KEY (`event_invitations_id`),
  ADD KEY `event_invitations_events_id` (`event_invitations_events_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`login_attempt_id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`password_reset_id`),
  ADD KEY `password_reset_users_id` (`password_reset_users_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profiles_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `users_id` (`events_id`),
  ADD KEY `events_id` (`events_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `user_login_attempts`
--
ALTER TABLE `user_login_attempts`
  ADD PRIMARY KEY (`users_id`,`login_attempt_id`),
  ADD KEY `login_attempt_id` (`login_attempt_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `departments_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `email_verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `events_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `event_invitations`
--
ALTER TABLE `event_invitations`
  MODIFY `event_invitations_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `login_attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department_events`
--
ALTER TABLE `department_events`
  ADD CONSTRAINT `department_events_ibfk_1` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`departments_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `department_events_ibfk_2` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department_users`
--
ALTER TABLE `department_users`
  ADD CONSTRAINT `department_users_ibfk_1` FOREIGN KEY (`departments_id`) REFERENCES `departments` (`departments_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `department_users_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD CONSTRAINT `email_verification_ibfk_1` FOREIGN KEY (`email_verification_users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD CONSTRAINT `event_invitations_ibfk_1` FOREIGN KEY (`event_invitations_events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`password_reset_users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_4` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_login_attempts`
--
ALTER TABLE `user_login_attempts`
  ADD CONSTRAINT `user_login_attempts_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_login_attempts_ibfk_2` FOREIGN KEY (`login_attempt_id`) REFERENCES `login_attempts` (`login_attempt_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
