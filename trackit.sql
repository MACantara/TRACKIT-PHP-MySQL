-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2024 at 02:43 PM
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

--
-- Dumping data for table `department_events`
--

INSERT INTO `department_events` (`departments_id`, `events_id`) VALUES
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49);

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
(1, 90),
(1, 91),
(2, 92);

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
(44, 91, '2ed3b87869b778d2c7d49bc07934e9d052f4b097ff4a6a80a73df78f125f88d6', 'mangelo0902@gmail.com', '2024-05-16 16:52:59'),
(45, 92, '9fa58f666b0d7b608cd9bfa44b32b7f6ba969e64f13382ebb633ecd8c51fcb1e', 'macantara@proton.me', '2024-05-16 16:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `events_id` int(11) NOT NULL,
  `events_status` varchar(50) NOT NULL,
  `events_name` varchar(255) DEFAULT NULL,
  `events_description` text DEFAULT NULL,
  `events_date` datetime DEFAULT NULL,
  `events_budget` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`events_id`, `events_status`, `events_name`, `events_description`, `events_date`, `events_budget`) VALUES
(38, 'Upcoming', 'Data Mining Onsite Seminar', 'The students will benefit by understanding how data mining enhances analytical skills, improves data\r\nliteracy and recognize its impact. By learning data mining, it will help students gain skills on critical\r\nthinking, problem solving, data literacy and prepare them in their data mining career. The seminar is for\r\nall the students from the College of the Computer Studies at the University of Perpetual Help System Dalta\r\nMolino.', '2024-05-15 13:00:00', 1320.00),
(39, 'Canceled', 'On-Site Community Outreach Seminar TechTutor: Empowering Communities with AI-Assisted IT Skills', 'The College of Computer Studies Council and Junior Philippine Computer Society Student Council will host\r\nan on-site community outreach Seminar program for the second semester of S.Y. 2024–2025 entitled &quot;TechTutor:\r\nEmpowering Communities with AI-Assisted IT Skills&quot; focused on empowering the fifteen adopted families through\r\nbasic IT skills and AI integration. This event will provide a fun and interactive environment where participants can\r\nlearn from presentations, engage in hands-on activities, and utilize AI-powered tools. The goal is to equip them with\r\npractical technology knowledge that can benefit their daily lives. This program combines the focus on building\r\nrelationships and addressing community needs with the specific educational component of introducing basic IT skills\r\nand AI tools.', '2024-05-17 09:00:00', 2280.00),
(40, 'Canceled', 'Hackin’ ka na lang 2024: “Unveiling Future Horizon: Exploring Limitless Potentials in the field of  Cybersecurity and Artificial Intelligence”', 'The College of Computer Studies will participate in the upcoming jam-packed knowledge event, Hackin’ Ka\r\nNa Lang (HKNL) with the theme “Unveiling Future Horizon: Exploring Limitless Potentials in the field of Cybersecurity\r\nand Artificial Intelligence” this coming April 27, 2024 from 8:00 AM – 5:00 PM, at Lipa City, Batangas. This event\r\nprovides a broader idea about Information Technology, the rising need for Information Security, and an introduction\r\nto the realm of Ethical Hacking. With a purpose of serving the fellow Filipinos to take information security seriously\r\nand wholeheartedly, SitesPhil truly believes that this will inspire and help the numerous I.T. enthusiasts see that\r\nthere are infinite opportunities in the field of I.T. Security.', '2024-04-27 08:00:00', 3400.00),
(41, 'Upcoming', 'CompTia and IC3 Certification Examination', 'The College of Computer Studies will be conducting two certification examinations\r\nduring the upcoming second semester of the academic year 2023-2024. These\r\nexaminations include the CompTIA IT Fundamentals (ITF+) &amp; Cloud Essentials\r\nTraining and Examination in partnership with our esteemed industry partner,\r\nSophies Information Technology Services (SitesPhil) / CompTIA Philippines.\r\nAdditionally, the IC3 Certification Examination will be facilitated through our valued industry partner, Innovative Training Works.', '2024-05-30 08:00:00', 0.00),
(42, 'Done', 'College of Computer Studies 2nd Semester Student Orientation S.Y 2023-2024:  &amp;quot;Innovating with A.I.: Building Tomorrow&amp;#39;s Leaders&amp;quot;', 'The College of Computer Studies Department regularly conduct orientation to\r\ndiscuss about events, different examination related in IT’s career and some\r\nimportant college activities. This theme explores how AI technologies are\r\nencouraging creativity, and equipping people to take on leadership roles in a\r\nworld that is changing quickly. It focuses on the relationship between artificial\r\nintelligence (AI) and leadership development, outlining tactics to employ AI for\r\ndigital era organizational growth, adaptable leadership, and sustainable\r\nadvancement.', '2024-03-14 13:00:00', 0.00),
(43, 'Done', 'Clutch or Cancel: CCS Valorant Masters Invitational', 'Valorant is a popular tactical first-person shooter (FPS) game developed and\r\npublished by Riot Games. These tournaments provide a platform players or teams\r\nto showcase their skills and teamwork. The College of Computer Studies will have\r\n3 days Tournament Event for CCS Students only.', '2024-01-29 08:00:00', 4460.00),
(44, 'Done', 'Gifts of Heart: Developing Connection and Kindness through Giving', 'Gift-giving is an act of self-gratification. It is a way and\r\nan expression of love. It strengthens human\r\nconnections and builds relationships. The social value\r\nof giving has been recognized throughout the year\r\nand Christmas Day is one of the happiest days of the\r\nyear when children receive gifts from their parents,\r\ngodparents, and relatives. It is one way of saying that\r\nthey are important and loved but for some children\r\nbuying food is more important than receiving toys and\r\npresents.\r\nCommunity Outreach title reflects the essence of\r\nfostering meaningful connections and cultivating\r\nempathy within a community. By emphasizing &quot;Gifts\r\nof Heart,&quot; it suggests a focus on thoughtful, heartfelt\r\ngestures that go beyond material value, emphasizing\r\nthe emotional impact of giving. The phrase\r\n&quot;Developing Connection and Kindness through\r\nGiving&quot; underscores the intention to build a stronger\r\nsense of community by encouraging individuals to\r\nengage in acts of generosity. This initiative aims not\r\nonly to provide tangible gifts but also to create a\r\nculture of compassion, ultimately enriching the social\r\nfabric of the community and promoting a spirit of\r\nkindness that extends beyond the immediate act of\r\ngiving.', '2023-12-11 13:00:00', 8515.00),
(45, 'Done', 'IT Specialist (ITS) Certification Exam', 'These examinations evaluate a student’s proficiency in using these programs to among\r\nother activities. Different certification levels (such as Specialist, Expert, and Master)\r\nindicate varying application proficiency levels. Successfully passing these exams can\r\nvalidate one’s skills and knowledge in using IT programs, application, general knowledge,\r\nand potentially leading to enhance career opportunities and credibility in the workplace.', '2024-01-11 08:00:00', 0.00),
(46, 'Done', '1st National Student Conference &amp;quot;AI Tools in Education&amp;quot;', 'The 1st National Student Conference &amp;quot;AI Tools in Education&amp;quot; is a conference event\r\nprovided by ISITE Inc. This provides seminars, workshops, and conferences as a means of\r\neducating students and enhancing their knowledge and skills while also keeping them\r\ninformed of the most recent advancements in the fields of computer science and\r\ninformation technology. This promotes friendship among IT enthusiasts from various\r\nPhilippine universities, institutions, and schools.', '2023-11-20 08:00:00', 0.00),
(47, 'Done', 'I.T. Skills Olympics 2023', 'The I.T. Skills Olympics is a yearly competition of IT students from all over the\r\nPhilippines, hosted by the College of Computing and Information Sciences of the\r\nUniversity of Makati and powered by Cebuana Lhuillier. It seeks out students\r\nwith extraordinary IT skills. The competition offers students the opportunity to\r\nshowcase their skills. It also promotes innovation and creativity in the IT industry\r\nand contributes to the development of the IT sector in the Philippines.', '2023-11-24 08:00:00', 3000.00),
(48, 'Done', 'AppCon 2023 “A web or mobile application to resolve social issues in the Philippines”', 'The College of Computer Studies will participate in the upcoming AppCon 2023 An\r\nInvitational Application Development Contest entitled “A web or mobile application to\r\nresolve social issues in the Philippines” hosted by Otis Japan Inc. It is a yearly competition\r\nof the development of web and mobile applications that aims to address the social issues\r\nin the Philippines. This competition offers opportunities for all CCS students to push\r\ntheir limits, establish their reputation, enhance their schools&#039; prestige, and\r\ncontribute to society by addressing social issues in the Philippines.', '2023-12-01 13:00:00', 0.00),
(49, 'Done', 'College of Computer Studies 1st Semester Student Orientation S.Y 2023-2024:  “Technological Upskilling in the Age of Intelligent Artificial Intelligence”', 'The College of Computer Studies Department regularly conduct orientation to\r\ndiscuss about events, different examination related in IT’s career and some\r\nimportant college activities.', '2023-09-22 13:00:00', 0.00);

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
(1, '::1', 0, '2024-05-17 09:01:45');

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
(11, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to Mikmikk03\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 90),
(12, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to Mika\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 91),
(13, 'Hello! I\'m a new user on this platform and excited to explore and connect with others.', 'Welcome to Mikz\'s profile!', 'I\'m still setting up my profile, but please feel free to reach out and connect with me in the meantime.', 92);

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

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`transaction_id`, `events_id`, `transaction_name`, `transaction_description`, `transaction_date`, `transaction_amount`, `transaction_price`, `transaction_category`, `transaction_type`) VALUES
(27, 38, 'Afternoon Food Snack', 'Afternoon Food Snack', '2024-05-17 02:04:00', 12.00, 80.00, 'Food', 'expense'),
(28, 38, 'Tarpaulin', 'Tarpaulin', '2024-05-17 02:04:00', 1.00, 360.00, 'Supplies', 'expense'),
(29, 39, 'Lunch Meal', 'Lunch Meal', '2024-05-17 02:06:00', 24.00, 80.00, 'Food', 'expense'),
(30, 39, 'Tarpaulin', 'Tarpaulin', '2024-05-17 02:07:00', 1.00, 360.00, 'Supplies', 'expense'),
(31, 40, 'Toll Fee', 'Toll Fee', '2024-05-17 02:21:00', 1.00, 400.00, 'Fees', 'expense'),
(32, 40, 'Gas', 'Gas', '2024-05-17 02:22:00', 1.00, 2000.00, 'Gas & Oils', 'expense'),
(33, 40, 'Food for Driver', 'Food for Driver', '2024-05-17 02:22:00', 1.00, 1000.00, 'Food', 'expense'),
(34, 43, 'Trophy (25 cm)', 'Trophy (25 cm)', '2024-05-17 02:33:00', 1.00, 220.00, 'Prizes', 'expense'),
(35, 43, 'Gold Medals', 'Gold Medals', '2024-05-17 02:34:00', 5.00, 80.00, 'Prizes', 'expense'),
(36, 43, 'Silver Medals', 'Silver Medals', '2024-05-17 02:34:00', 5.00, 80.00, 'Prizes', 'expense'),
(37, 43, 'Bronze Medals', 'Bronze Medals', '2024-05-17 02:34:00', 5.00, 80.00, 'Prizes', 'expense'),
(38, 43, 'Vellum Board (Certificates)', 'Vellum Board (Certificates)', '2024-05-17 02:35:00', 1.00, 40.00, 'Supplies', 'expense'),
(39, 43, '1st Place Cash Prize', '1st Place Cash Prize', '2024-05-17 02:36:00', 1.00, 1500.00, 'Cash Prizes', 'expense'),
(40, 43, '2nd Place Cash Prize', '2nd Place Cash Prize', '2024-05-17 02:36:00', 1.00, 1000.00, 'Cash Prizes', 'expense'),
(41, 43, '3rd Place Cash Prize', '3rd Place Cash Prize', '2024-05-17 02:36:00', 1.00, 500.00, 'Cash Prizes', 'expense'),
(42, 44, 'Marby Pinoy Tasty', 'Marby Pinoy Tasty', '2024-05-17 02:42:00', 12.00, 41.00, 'Food', 'expense'),
(43, 44, 'DM Todays', 'DM Todays', '2024-05-17 02:43:00', 15.00, 86.00, 'Food', 'expense'),
(44, 44, 'Alaska Kremdensada', 'Alaska Kremdensada', '2024-05-17 02:44:00', 8.00, 97.00, 'Food', 'expense'),
(45, 47, 'Toll Fee', 'Toll Fee', '2024-05-17 17:11:00', 1.00, 400.00, 'Fees', 'expense'),
(46, 47, 'Food for Driver', 'Food for Driver', '2024-05-17 17:11:00', 1.00, 600.00, 'Food', 'expense'),
(47, 47, 'Registration', 'Registration', '2024-05-17 17:11:00', 10.00, 200.00, 'Fees', 'expense'),
(48, 44, 'Lucky 7 Carne Norte', 'Lucky 7 Carne Norte', '2024-05-17 17:21:00', 10.00, 83.00, 'Food', 'expense'),
(49, 44, 'Nestea Apple', 'Nestea Apple', '2024-05-17 17:22:00', 15.00, 19.00, 'Drinks', 'expense'),
(50, 44, 'Daily Quezo', 'Daily Quezo', '2024-05-17 17:22:00', 15.00, 42.00, 'Food', 'expense'),
(51, 44, 'Fiesta Sweet Spaghetti', 'Fiesta Sweet Spaghetti', '2024-05-17 17:25:00', 15.00, 74.00, 'Food', 'expense'),
(52, 44, 'Eco Bag Large', 'Eco Bag Large', '2024-05-17 17:25:00', 17.00, 11.00, 'Supplies', 'expense'),
(53, 44, 'Certificate Holder', 'Certificate Holder', '2024-05-17 17:26:00', 1.00, 44.00, 'Supplies', 'expense'),
(54, 44, 'HBW Black Ballpen', 'HBW Black Ballpen', '2024-05-17 17:26:00', 9.00, 11.00, 'Supplies', 'expense'),
(55, 44, 'Marby Pinoy Tasty', 'Marby Pinoy Tasty', '2024-05-17 17:26:00', 3.00, 56.00, 'Food', 'expense'),
(56, 44, 'Certificates and Program Flyers', 'Certificates and Program Flyers', '2024-05-17 17:26:00', 1.00, 128.00, 'Supplies', 'expense'),
(57, 44, 'Wilkins Pure Water', 'Wilkins Pure Water', '2024-05-17 17:27:00', 3.00, 7.00, 'Drinks', 'expense'),
(58, 44, 'Jofels Canteen Meal', 'Jofels Canteen Meal', '2024-05-17 17:27:00', 2.00, 70.00, 'Food', 'expense'),
(59, 44, '3x2 Tarpaulin', '3x2 Tarpaulin', '2024-05-17 17:27:00', 1.00, 120.00, 'Supplies', 'expense'),
(60, 44, 'Hansel Choco', 'Hansel Choco', '2024-05-17 17:27:00', 1.00, 57.00, 'Drinks', 'expense'),
(61, 44, 'Hansel Mocha', 'Hansel Mocha', '2024-05-17 17:27:00', 2.00, 57.00, 'Drinks', 'expense'),
(62, 44, 'Fiesta Sweet Spaghetti', 'Fiesta Sweet Spaghetti', '2024-05-17 17:28:00', 2.00, 74.00, 'Food', 'expense'),
(63, 44, 'Big250 Orange', 'Big250 Orange', '2024-05-17 17:28:00', 8.00, 9.00, 'Drinks', 'expense'),
(64, 44, 'Plus Orange', 'Plus Orange', '2024-05-17 17:28:00', 1.00, 9.00, 'Drinks', 'expense'),
(65, 44, 'Big250 Apple', 'Big250 Apple', '2024-05-17 17:28:00', 7.00, 9.00, 'Drinks', 'expense'),
(66, 44, 'Daily Quezo', 'Daily Quezo', '2024-05-17 17:29:00', 2.00, 42.00, 'Food', 'expense'),
(67, 44, 'Alaska Kremdensada', 'Alaska Kremdensada', '2024-05-17 17:29:00', 1.00, 53.00, 'Food', 'expense');

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
(90, 'Michael Angelo', 'Cantara', 'Mikmikk03', 'cantara.michaelangelo@gmail.com', 'Student-Council-Officer', '$2y$10$6px4s3k72FFr7vMyScMP7ejziA5n/2/PpKFUdMiLh1lk0m4pASXOO', 1),
(91, 'Mika', 'Mika', 'Mika', 'mangelo0902@gmail.com', 'Faculty', '$2y$10$vsA36LqQsDzOxdkTQA10eOWj5YRUGZyG/lXxmcLcxQ/9mu.Q5a2tu', 0),
(92, 'Mikz', 'Mikz', 'Mikz', 'macantara@proton.me', 'Student-Council-Officer', '$2y$10$SdcYhsBDhyo7MCSXd9PW7O/NakzOKqn7mZ1Clezx00S5hnBIWQSzq', 0);

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
  MODIFY `email_verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `events_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

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
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

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
