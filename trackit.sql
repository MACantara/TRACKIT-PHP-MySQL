-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 02:49 PM
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
-- Database: `trackit`
--

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
(26, 'College of Computer Studies Christmas Party 2023', 'Christmas party for the council officers, faculty and staff.', '2023-12-13 13:00:00', 6806.00);

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
-- Table structure for table `event_users`
--

CREATE TABLE `event_users` (
  `users_id` int(11) NOT NULL,
  `events_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_users`
--

INSERT INTO `event_users` (`users_id`, `events_id`) VALUES
(79, 22),
(79, 23),
(79, 24),
(79, 25),
(79, 26);

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
(1, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to Mikmikk03\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 79),
(2, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to Michi\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 80),
(3, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to Michu\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 81),
(4, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to carlosrodriguez\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 82),
(5, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to mikadavis\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 83);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `transaction_id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
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

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`transaction_id`, `users_id`, `events_id`, `transaction_name`, `transaction_description`, `transaction_date`, `transaction_amount`, `transaction_price`, `transaction_category`, `transaction_type`) VALUES
(1, 79, 22, 'Afternoon Snacks', 'Afternoon snacks for the CSS faculties and council committees', '2024-05-13 20:19:00', 12.00, 80.00, 'Food', 'expense'),
(2, 79, 22, 'Tarpaulin', 'Tarpaulin for the onsite seminar', '2024-05-13 20:20:00', 1.00, 360.00, 'Supplies', 'expense'),
(3, 79, 23, 'School Canteens Regular Meal for Lunch', 'Meals for the adopted families, faculty, and committee members', '2024-05-13 20:23:00', 24.00, 80.00, 'Food', 'expense'),
(4, 79, 23, 'Tarpaulin', 'Tarpaulin for the onsite seminar', '2024-05-13 20:24:00', 1.00, 360.00, 'Supplies', 'expense'),
(5, 79, 24, 'Toll Fee', 'Fee for the toll gates', '2024-05-13 20:27:00', 1.00, 400.00, 'Fees', 'expense'),
(6, 79, 24, 'Gas', 'Gas for the transportation vehicle.', '2024-05-13 20:27:00', 1.00, 2000.00, 'Fuel & Oil', 'expense'),
(7, 79, 24, 'Food for the driver', 'Food for the driver', '2024-05-13 20:28:00', 1.00, 1000.00, 'Food', 'expense'),
(8, 79, 25, 'Trophy', 'Trophy for the 1st place', '2024-05-13 20:31:00', 1.00, 220.00, 'Supplies', 'expense'),
(9, 79, 25, 'Medals', 'Gold, silve, and bronze medals for the participants', '2024-05-13 20:32:00', 15.00, 80.00, 'Supplies', 'expense'),
(10, 79, 25, 'Vellum Board (Certificates)', 'To be used for the certificates for the participants', '2024-05-13 20:32:01', 1.00, 40.00, 'Supplies', 'expense'),
(11, 79, 25, 'Cash Prizes', 'Cash prizes for 1st place, 2nd place and 3rd place', '2024-05-13 20:34:00', 3.00, 1000.00, 'Cash Prize', 'expense'),
(12, 79, 26, 'SNR PIZZAS (Cheese and Pepperoni and Combo Garlic)', 'SNR PIZZAS (Cheese and Pepperoni and Combo Garlic)', '2024-05-13 20:40:00', 2.00, 848.00, 'Food', 'expense'),
(13, 79, 26, 'DUNKIN DONUTS (Supreme Bundle)', 'DUNKIN DONUTS (Supreme Bundle)', '2024-05-13 20:42:00', 2.00, 615.00, 'Food', 'expense'),
(14, 79, 26, 'PAPA CHOW&#039;S (9 DISHES PROMO)', 'PAPA CHOW&#039;S (9 DISHES PROMO)', '2024-05-13 20:42:00', 1.00, 2000.00, 'Food', 'expense'),
(15, 79, 26, 'JOFELS RICE', 'JOFELS RICE', '2024-05-13 20:43:00', 30.00, 10.00, 'Food', 'expense'),
(16, 79, 26, 'COKE', 'COKE', '2024-05-13 20:43:00', 2.00, 80.00, 'Drinks', 'expense'),
(17, 79, 26, 'SPRITE', 'SPRITE', '2024-05-13 20:43:00', 2.00, 80.00, 'Drinks', 'expense'),
(18, 79, 26, 'ROOTBEER', 'ROOTBEER', '2024-05-13 20:43:00', 2.00, 80.00, 'Drinks', 'expense'),
(19, 79, 26, 'Cash Price for Tumpakners Game', 'Cash Price for Tumpakners Game', '2024-05-13 20:44:00', 1.00, 100.00, 'Cash Prize', 'expense'),
(20, 79, 26, 'Cash Price for Trip to Jerusalem', 'Cash Price for Trip to Jerusalem', '2024-05-13 20:44:00', 8.00, 50.00, 'Cash Prize', 'expense'),
(21, 79, 26, 'Cash Price for CSS Feud', 'Cash Price for CSS Feud', '2024-05-13 20:44:00', 2.00, 100.00, 'Cash Prize', 'expense'),
(22, 79, 26, 'UTENSILS', 'UTENSILS', '2024-05-13 20:47:00', 3.00, 40.00, 'Supplies', 'expense'),
(23, 79, 26, 'CUPS', 'CUPS', '2024-05-13 20:47:00', 2.00, 45.00, 'Supplies', 'expense'),
(24, 79, 26, 'GARBAGE BAG', 'GARBAGE BAG', '2024-05-13 20:48:00', 1.00, 35.00, 'Supplies', 'expense'),
(25, 79, 26, 'PAPER PLATES', 'PAPER PLATES', '2024-05-13 20:48:00', 3.00, 40.00, 'Supplies', 'expense'),
(26, 79, 26, 'TISSUE PAPER', 'TISSUE PAPER', '2024-05-13 20:48:00', 1.00, 35.00, 'Supplies', 'expense');

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
  `users_password` varchar(255) NOT NULL,
  `users_email_verified` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_first_name`, `users_last_name`, `users_username`, `users_email`, `users_password`, `users_email_verified`) VALUES
(79, 'Michael Angelo', 'Cantara', 'Mikmikk03', 'cantara.michaelangelo@gmail.com', '$2y$10$nVvWZd3dEUuJjXgB0QqtkOZ0fwjUcxdU1yY/2G.s/pkgQEC40QQxi', 1),
(80, 'Michi', 'Michi', 'Michi', 'macantara@proton.me', '$2y$10$7FSflgbw/GAZMM1w6hactOGyRRfykjALIabzlICKNrA5e31LIbfWa', 1),
(81, 'Michu', 'Michu', 'Michu', 'michaelangelocantara@zoho.com', '$2y$10$.lft/0GUrKWOMqB1Lt7f/eEWRHHdXcBMxaNOwNjplHRarrpDw.6a2', 1),
(82, 'Carlos', 'Rodriguez', 'carlosrodriguez', 'mangelo0902@gmail.com', '$2y$10$K7CtOGUp83GyOlO6vQr4Au.T6cwLhBgjiFgC3g9GPSTY14SUfZAFK', 1),
(83, 'Mika', 'Davis', 'mikadavis', 'macantara@pm.me', '$2y$10$IlwkMrNgrt8um7kiyBzaluWwUhnE5CIEu.1V/vuhSBzZDBnR6oZPe', 1);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `event_users`
--
ALTER TABLE `event_users`
  ADD PRIMARY KEY (`users_id`,`events_id`),
  ADD KEY `events_id` (`events_id`);

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
  ADD KEY `users_id` (`users_id`,`events_id`),
  ADD KEY `events_id` (`events_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `email_verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `events_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `event_invitations`
--
ALTER TABLE `event_invitations`
  MODIFY `event_invitations_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `login_attempt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `event_users`
--
ALTER TABLE `event_users`
  ADD CONSTRAINT `event_users_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_users_ibfk_4` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `transaction_history_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_history_ibfk_4` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
