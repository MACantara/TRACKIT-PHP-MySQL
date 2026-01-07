-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 02:56 PM
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
-- Table structure for table `actions_taken`
--

CREATE TABLE `actions_taken` (
  `actions_taken_id` int(11) NOT NULL,
  `actions_taken_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actions_taken`
--

INSERT INTO `actions_taken` (`actions_taken_id`, `actions_taken_name`) VALUES
(9, 'We always check the internet status.'),
(10, 'We always check the internet status.'),
(12, 'We Double time the preparation'),
(13, 'We call Sir Mario to fix the Sound System'),
(14, 'N/A'),
(15, 'N/A'),
(16, 'N/A'),
(17, 'N/A'),
(18, NULL),
(19, ''),
(20, ''),
(21, ''),
(22, ''),
(23, ''),
(24, ''),
(25, ''),
(26, ''),
(27, ''),
(28, ''),
(29, ''),
(30, ''),
(31, ''),
(32, ''),
(33, NULL),
(34, NULL),
(35, ''),
(36, ''),
(37, NULL),
(38, ''),
(39, '');

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
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(2, 3);

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
-- Table structure for table `documentation_pictures`
--

CREATE TABLE `documentation_pictures` (
  `documentation_pictures_id` int(11) NOT NULL,
  `documentation_pictures_item` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documentation_pictures`
--

INSERT INTO `documentation_pictures` (`documentation_pictures_id`, `documentation_pictures_item`) VALUES
(119, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb1e849fb-Picture2.png'),
(120, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb1e885a4-Picture1.png'),
(121, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb1e8a402-unnamed (1).png'),
(122, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb1e8d6f4-unnamed.png'),
(123, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb3bc6a44-Picture6.jpg'),
(124, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb3bc8dad-Picture5.jpg'),
(125, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb3bcabfa-Picture4.jpg'),
(126, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb3bcca23-Picture3.jpg'),
(127, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb443ba6b-Picture11.jpg'),
(128, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb443e3eb-Picture10.jpg'),
(129, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb44400bb-Picture9.jpg'),
(130, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb4441e90-Picture8.jpg'),
(131, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb4f0dfef-Picture15.jpg'),
(132, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb4f1055a-Picture14.jpg'),
(133, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb4f129fa-Picture13.jpg'),
(134, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb4f14628-Picture12.jpg'),
(135, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb5a45ae9-Picture19.jpg'),
(136, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb5a47dc4-Picture18.jpg'),
(137, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb5a4abf5-Picture17.jpg'),
(138, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb5a4c775-Picture16.jpg'),
(139, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb64915c9-Picture23.jpg'),
(140, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb6493b4a-Picture22.jpg'),
(141, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb6496be6-Picture21.jpg'),
(142, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb6498a1a-Picture20.jpg'),
(143, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb6ca7e6e-Picture26.png'),
(144, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb6ca9a69-Picture25.png'),
(145, 'C:/xampp/htdocs/TRACKIT-PHP-MySQL/static/img/664deb6cab9c0-Picture24.png');

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
  `events_name` varchar(255) DEFAULT NULL,
  `events_semester` varchar(50) NOT NULL,
  `events_academic_year` varchar(50) NOT NULL,
  `events_start_date` datetime DEFAULT NULL,
  `events_end_date` datetime DEFAULT NULL,
  `events_venue` varchar(255) DEFAULT NULL,
  `events_budget` decimal(20,2) DEFAULT NULL,
  `events_status` varchar(50) DEFAULT NULL,
  `events_description` text DEFAULT NULL,
  `events_remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`events_id`, `events_name`, `events_semester`, `events_academic_year`, `events_start_date`, `events_end_date`, `events_venue`, `events_budget`, `events_status`, `events_description`, `events_remarks`) VALUES
(1, 'Onsite Seminar: Data Mining', '2nd Semester', '2023-2024', '2024-05-15 13:00:00', '2024-05-15 16:00:00', 'IHM Building-Function Room, UPHSD-Molino', 1320.00, 'Upcoming', 'In partnership with Mr. Russel G. Reyes, the Assistant instructor at the College of\r\nEngineering and Information Technology, the College of Computer Studies will\r\nconduct and organize a free onsite seminar entitled &quot;Data mining&quot;. Data mining is\r\nthe process of uncovering hidden patterns and extracting valuable information\r\nfrom large datasets. The seminar will discuss about how data mining analyzes a\r\nlarge batch of data, why many corporations use them, and why data mining is\r\nimportant.', ''),
(2, '&quot;TechTutor: Empowering Communities with AI-Assisted IT Skills&quot;', '2nd Semester', '2023-2024', '2024-05-24 09:00:00', '2024-05-24 12:00:00', 'RM 203 Main Building UPHSD - Molino', 2280.00, 'Upcoming', 'The College of Computer Studies Council and Junior Philippine Computer Society Student Council will host\r\nan on-site community outreach Seminar program for the second semester of S.Y. 2024–2025 entitled &quot;TechTutor:\r\nEmpowering Communities with AI-Assisted IT Skills&quot; focused on empowering the fifteen adopted families through\r\nbasic IT skills and AI integration. This event will provide a fun and interactive environment where participants can\r\nlearn from presentations, engage in hands-on activities, and utilize AI-powered tools. The goal is to equip them with\r\npractical technology knowledge that can benefit their daily lives. This program combines the focus on building\r\nrelationships and addressing community needs with the specific educational component of introducing basic IT skills\r\nand AI tools.', ''),
(3, 'CompTIA and IC3 Certification Examination', '2nd Semester', '2023-2024', '2024-06-03 08:00:00', '2024-06-03 17:00:00', 'Computer Laboratory M-209 &amp; M-210', 0.00, 'Upcoming', 'The College of Computer Studies will be conducting two certification examinations\r\nduring the upcoming second semester of the academic year 2023-2024. These\r\nexaminations include the CompTIA IT Fundamentals (ITF+) &amp; Cloud Essentials\r\nTraining and Examination in partnership with our esteemed industry partner,\r\nSophies Information Technology Services (SitesPhil) / CompTIA Philippines.\r\nAdditionally, the IC3 Certification Examination will be facilitated through our\r\nvalued industry partner, Innovative Training Works.', ''),
(4, 'Hackin’ ka na lang 2024: “Unveiling Future Horizon: Exploring Limitless Potentials in the field of  Cybersecurity and Artificial Intelligence”', '2nd Semester', '2023-2024', '2024-04-27 08:00:00', '2024-04-27 17:00:00', 'Lipa City, Batangas', 3400.00, 'Canceled', 'Hackin’ Ka Na Lang (HKNL), that provides a broader idea about Information Technology,\r\nthe rising need for Information Security, and an introduction to the realm of Ethical\r\nHacking. With a purpose of serving the fellow Filipinos to take information security\r\nseriously and wholeheartedly, SitesPhil truly believes that this will inspire and help the\r\nnumerous I.T. enthusiasts see that there are infinite opportunities in the field of I.T.\r\nSecurity.', ''),
(5, 'College of Computer Studies 2nd Semester Student Orientation S.Y 2023-2024:  &quot;Innovating with A.I.: Building Tomorrow&#039;s Leaders&quot;', '2nd Semester', '2023-2024', '2024-03-14 13:00:00', '2024-03-14 16:00:00', 'UPHSD-Molino New Gymnasium', 0.00, 'Done', 'The College of Computer Studies Department regularly conduct orientation to\r\ndiscuss about events, different examination related in IT’s career and some\r\nimportant college activities. This theme explores how AI technologies are\r\nencouraging creativity, and equipping people to take on leadership roles in a\r\nworld that is changing quickly. It focuses on the relationship between artificial\r\nintelligence (AI) and leadership development, outlining tactics to employ AI for\r\ndigital era organizational growth, adaptable leadership, and sustainable\r\nadvancement.', ''),
(6, 'Clutch or Cancel: CCS Valorant Masters Invitational', '1st Semester', '2023-2024', '2024-01-29 08:00:00', '2024-01-31 17:00:00', 'Facebook Live', 4460.00, 'Done', 'Valorant is a popular tactical first-person shooter (FPS) game developed and\r\npublished by Riot Games. These tournaments provide a platform players or teams\r\nto showcase their skills and teamwork. The College of Computer Studies will have\r\n3 days Tournament Event for CCS Students only.', ''),
(7, 'Gifts of Heart: Developing Connection and Kindness through Giving', '1st Semester', '2023-2024', '2023-12-23 08:00:00', '2023-12-23 12:00:00', 'Sitio Sampalukan, Molino 3, Bacoor Cavite', 11000.00, 'Done', 'Gift-giving is an act of self-gratification. It is a way and\r\nan expression of love. It strengthens human\r\nconnections and builds relationships. The social value\r\nof giving has been recognized throughout the year\r\nand Christmas Day is one of the happiest days of the\r\nyear when children receive gifts from their parents,\r\ngodparents, and relatives. It is one way of saying that\r\nthey are important and loved but for some children\r\nbuying food is more important than receiving toys and\r\npresents.\r\nCommunity Outreach title reflects the essence of\r\nfostering meaningful connections and cultivating\r\nempathy within a community. By emphasizing &quot;Gifts\r\nof Heart,&quot; it suggests a focus on thoughtful, heartfelt\r\ngestures that go beyond material value, emphasizing\r\nthe emotional impact of giving. The phrase\r\n&quot;Developing Connection and Kindness through\r\nGiving&quot; underscores the intention to build a stronger\r\nsense of community by encouraging individuals to\r\nengage in acts of generosity. This initiative aims not\r\nonly to provide tangible gifts but also to create a\r\nculture of compassion, ultimately enriching the social\r\nfabric of the community and promoting a spirit of\r\nkindness that extends beyond the immediate act of\r\ngiving.', ''),
(8, 'IT Specialist (ITS)', '1st Semester', '2023-2024', '2024-01-12 08:00:00', '2024-01-12 17:00:00', 'UPHSD Computer Laboratory M-210', 0.00, 'Done', 'These examinations evaluate a student’s proficiency in using these programs to among other activities. Different certification levels (such as Specialist, Expert, and Master) indicate varying application proficiency levels. Successfully passing these exams can validate one’s skills and knowledge in using IT programs, application, general knowledge, and potentially leading to enhance career opportunities and credibility in the workplace.', ''),
(10, 'I.T. Skills Olympics 2023', '1st Semester', '2023-2024', '2023-11-24 07:00:00', '2023-11-24 19:00:00', 'University of Makati, City of Makati', 3000.00, 'Done', 'The I.T. Skills Olympics is a yearly competition of IT students from all over the\r\nPhilippines, hosted by the College of Computing and Information Sciences of the\r\nUniversity of Makati and powered by Cebuana Lhuillier. It seeks out students\r\nwith extraordinary IT skills. The competition offers students the opportunity to\r\nshowcase their skills. It also promotes innovation and creativity in the IT industry\r\nand contributes to the development of the IT sector in the Philippines.', 'c/o to the University of Makati'),
(11, 'Integrated Society of Information Technology Enthusiasts (iSITE) Conference 2023', '1st Semester', '2023-2024', '2023-11-29 08:00:00', '2023-11-29 17:00:00', 'New gym of UPHSD-Molino', 0.00, 'Done', 'The Integrated Society of Information Technology Enthusiasts (iSITE) Inc. is an organization\r\nthat provides seminars, workshops, and conferences as a means of educating students and\r\nenhancing their knowledge and skills while also keeping them informed of the most recent\r\nadvancements in the fields of computer science and information technology. This\r\npromotes friendship among IT enthusiasts from various Philippine universities, institutions,\r\nand schools.', 'c/o to the ISITE organization'),
(12, 'AppCon 2023 “A web or mobile application to resolve social issues in the Philippines”', '1st Semester', '2023-2024', '2023-12-01 13:00:00', '2023-12-01 17:00:00', 'Zoom Virtual Meeting', 0.00, 'Done', 'The College of Computer Studies will participate in the upcoming AppCon 2023 An\r\nInvitational Application Development Contest entitled “A web or mobile application to\r\nresolve social issues in the Philippines” hosted by Otis Japan Inc. It is a yearly competition\r\nof the development of web and mobile applications that aims to address the social issues\r\nin the Philippines. This competition offers opportunities for all CCS students to push\r\ntheir limits, establish their reputation, enhance their schools&#039; prestige, and\r\ncontribute to society by addressing social issues in the Philippines.', ''),
(13, 'College of Computer Studies Christmas Party 2023', '1st Semester', '2023-2024', '2023-12-13 13:00:00', '2023-12-13 17:00:00', 'RM 203 Main Building UPHSD-Molino', 6806.00, 'Done', 'The College of Computer Studies Officers of the University of Perpetual Help –\r\nMolino intends to conduct a Christmas Party for all College of Computer Studies\r\nOfficers on December 13, 2023, in Main Building Room 203. This Christmas Party\r\naims to make the students’ Christmas special.', 'N/A'),
(14, 'College of Computer Studies 1st Semester Student Orientation S.Y 2023-2024: “Technological Upskilling  in the Age of Intelligent Artificial Intelligence”', '1st Semester', '2023-2024', '2023-10-18 13:00:00', '2023-10-18 16:00:00', 'UPHSD Molino - Old Gymnasium', 0.00, 'Done', 'The College of Computer Studies Department regularly conduct orientation to\r\ndiscuss about events, different examination related in IT’s career and some\r\nimportant college activities.', 'Very Good 4.43'),
(15, '11th International Webinar: “Deep Fake News Detection”', '1st Semester', '2023-2024', '2023-09-29 13:00:00', '2023-09-29 16:00:00', 'Zoom Link and Facebook Live', 0.00, 'Done', 'In partnership with our keynote speaker Professor/ Dr. AHMED J. Omaid of Department\r\nof Computer Science and Mathematics of University of Kufa, Iraq the College of\r\nComputer studies will be having free webinar entitled “Deep Fake News Detection”.\r\nDeepfake news detection is the process of identifying and mitigating the spread of\r\nmanipulated and deceptive content that uses advanced artificial intelligence techniques\r\nto create fake news articles, images, videos, or audio clips. Detecting deepfake news\r\ninvolves a combination of technological methods, content analysis, and contextual\r\nunderstanding to distinguish between authentic and manipulated content.', 'Excellent 4.77');

-- --------------------------------------------------------

--
-- Table structure for table `event_actions_taken`
--

CREATE TABLE `event_actions_taken` (
  `events_id` int(11) NOT NULL,
  `actions_taken_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_actions_taken`
--

INSERT INTO `event_actions_taken` (`events_id`, `actions_taken_id`) VALUES
(10, 14),
(11, 15),
(13, 17),
(14, 12),
(14, 13),
(15, 10);

-- --------------------------------------------------------

--
-- Table structure for table `event_documentation_pictures`
--

CREATE TABLE `event_documentation_pictures` (
  `events_id` int(11) NOT NULL,
  `documentation_pictures_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_documentation_pictures`
--

INSERT INTO `event_documentation_pictures` (`events_id`, `documentation_pictures_id`) VALUES
(7, 139),
(7, 140),
(7, 141),
(7, 142),
(8, 143),
(8, 144),
(8, 145),
(10, 127),
(10, 128),
(10, 129),
(10, 130),
(11, 131),
(11, 132),
(11, 133),
(11, 134),
(13, 135),
(13, 136),
(13, 137),
(13, 138),
(14, 123),
(14, 124),
(14, 125),
(14, 126),
(15, 119),
(15, 120),
(15, 121),
(15, 122);

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
-- Table structure for table `event_objectives`
--

CREATE TABLE `event_objectives` (
  `events_id` int(11) NOT NULL,
  `objectives_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_objectives`
--

INSERT INTO `event_objectives` (`events_id`, `objectives_id`) VALUES
(1, 73),
(1, 74),
(1, 75),
(1, 76),
(2, 77),
(3, 78),
(3, 79),
(3, 80),
(4, 70),
(4, 71),
(4, 72),
(5, 66),
(5, 67),
(5, 68),
(5, 69),
(6, 63),
(6, 64),
(6, 65),
(7, 59),
(8, 60),
(8, 61),
(8, 62),
(10, 21),
(10, 22),
(10, 23),
(10, 24),
(10, 25),
(11, 26),
(11, 27),
(11, 28),
(11, 29),
(12, 56),
(12, 57),
(12, 58),
(13, 34),
(13, 35),
(13, 36),
(13, 37),
(13, 38),
(14, 15),
(14, 16),
(14, 17),
(14, 18),
(15, 12),
(15, 19),
(15, 20);

-- --------------------------------------------------------

--
-- Table structure for table `event_problems_encountered`
--

CREATE TABLE `event_problems_encountered` (
  `events_id` int(11) NOT NULL,
  `problems_encountered_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_problems_encountered`
--

INSERT INTO `event_problems_encountered` (`events_id`, `problems_encountered_id`) VALUES
(10, 14),
(11, 15),
(13, 17),
(14, 12),
(14, 13),
(15, 10);

-- --------------------------------------------------------

--
-- Table structure for table `event_recommendations`
--

CREATE TABLE `event_recommendations` (
  `events_id` int(11) NOT NULL,
  `recommendations_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_recommendations`
--

INSERT INTO `event_recommendations` (`events_id`, `recommendations_id`) VALUES
(10, 16),
(11, 17),
(13, 19),
(14, 13),
(14, 14),
(14, 15),
(15, 10),
(15, 11),
(15, 12);

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
(1, '::1', 0, '2024-05-22 05:37:50');

-- --------------------------------------------------------

--
-- Table structure for table `objectives`
--

CREATE TABLE `objectives` (
  `objectives_id` int(11) NOT NULL,
  `objectives_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `objectives`
--

INSERT INTO `objectives` (`objectives_id`, `objectives_name`) VALUES
(9, 'To learn the fundamental functions of machine learning anddeep learning techniques for fake news detection'),
(10, 'To learn the fundamental functions of machine learning anddeep learning techniques for fake news detection'),
(11, 'To learn the fundamental functions of machine learning anddeep learning techniques for fake news detection'),
(12, 'To learn the fundamental functions of machine learning anddeep learning techniques for fake news detection.'),
(14, 'To discuss artificial intelligence (AI) and computer science which focuses on the use of data and algorithms to fake news detection.'),
(15, 'To introduce again the Microsoft and CompTIA examinations that help students to certification for their career.'),
(16, 'To familiarize with CCS students, Guidance, School Protocol, and Library Utilization.'),
(17, 'To discuss all extracurricular, co-curricular, and academic activities that are related.'),
(18, 'To address the participants’ concerns and inquiries.'),
(19, 'To learn the three categories of news detection that identify the fake news automatically: linguistic features, temporal-structural features.'),
(20, 'To discuss artificial intelligence (AI) and computer science which focuses on the use of data and algorithms to fake news detection.'),
(21, 'To identify and recognize students with extraordinary IT skills.'),
(22, 'To provide a platform for IT students to showcase their skills and talents'),
(23, 'To encourage students to push their limits and strive for excellence.'),
(24, 'To promote innovation and creativity in the IT industry.'),
(25, 'To contribute to the development of the IT sector in the Philippines.'),
(26, 'To provide students with appropriate knowledge, abilities, and industry insights in order to prepare them for successful careers in information technology.'),
(27, 'To assist students in gaining practical skills in programming, software development, cybersecurity, and IT project management.'),
(28, 'To assist students in gaining practical skills in programming, software development, cybersecurity, and IT project management.'),
(29, 'To encourage members to engage in research and innovation in the field of information technology, promoting intellectual curiosity and creativity.'),
(30, 'To provide students with appropriate knowledge, abilities, and industry insights in order to prepare them for successful careers in information technology.'),
(31, 'To assist students in gaining practical skills in programming, software development, cybersecurity, and IT project management.'),
(32, 'To assist students in gaining practical skills in programming, software development, cybersecurity, and IT project management.'),
(33, 'To encourage members to engage in research and innovation in the field of information technology, promoting intellectual curiosity and creativity.'),
(34, 'The activity aims to make the students remember and make them feel the presence of Christmas.'),
(35, 'Christmas Dinner a buffet-style dinner will be served to all attendees.'),
(36, 'Exchange gifts with student officers will have the opportunity to exchange gifts with their peers.'),
(37, 'A variety of games will be played, such as bingo, trivia, and karaoke.'),
(38, 'Prizes on the activities will be awarded to the winners of the games.'),
(39, NULL),
(40, ''),
(41, ''),
(42, ''),
(43, ''),
(44, ''),
(45, ''),
(46, ''),
(47, ''),
(48, ''),
(49, ''),
(50, ''),
(51, ''),
(52, ''),
(53, ''),
(54, ''),
(55, NULL),
(56, 'To develop web or mobile applications based on the following: Artificial Intelligence (AI), Internet of Things (IoT), Blockchain, Web 3.0.'),
(57, 'To Explore and understand various algorithms and data structures.'),
(58, 'To create a competitive environment that motivates participants to strive for excellence.'),
(59, 'to develop the spirit of volunteerism in caring for others'),
(60, 'To examine the student&amp;#39;s knowledge\r\nand practical proficiency with relation\r\nto IT programs.'),
(61, 'To prepare the students with the\r\nfundamental IT skills needed in a\r\nvariety of disciplines and professional\r\nvocations, you may better prepare\r\nthem for their future jobs.'),
(62, 'To recognize and put into best\r\npractices for data management,\r\nsecurity, and integrity in each specific\r\napplication.'),
(63, 'To let students, enjoy, unite, help\r\neach other, and work together'),
(64, 'To foster strategic thinking in a\r\ndynamic digital arena'),
(65, 'To showcase their talents and\r\nstrengthen the sense of\r\ncommunity within our colleges\r\nenvironment.'),
(66, 'To introduce the CompTia\r\nexaminations that help students\r\nto certification for their career.'),
(67, 'To discuss the advantages of\r\nbeing a leader and encourage\r\nstudents to be part of one\r\norganization.'),
(68, 'To discuss the Calendar Activities\r\nfor this second semester.'),
(69, 'To address the participants&amp;#39;\r\nconcerns and inquiries.'),
(70, 'To provide a broader idea about\r\nInformation Technology, the rising\r\nneed for Information Security, and an\r\nintroduction to the realm of Ethical\r\nHacking'),
(71, 'To serve the fellow Filipinos to take\r\ninformation security seriously and\r\nwholeheartedly'),
(72, 'To inspire and help the numerous I.T.\r\nenthusiasts see that there are infinite\r\nopportunities in the field of I.T.\r\nSecurity.'),
(73, 'To understand data\r\nmining and differentiate\r\nit from traditional data\r\nanalysis.'),
(74, 'To understand data\r\npreparation and\r\nexploration'),
(75, 'To Explore about Core\r\nData Mining Techniques'),
(76, 'To recognize the impact\r\nand future of data\r\nmining'),
(77, 'To have an interactive seminars, we seek to empower\r\nparticipants with foundational knowledge and practical skills in\r\nutilizing AI-assisted IT tools. By doing so, we enable them to\r\nnavigate the digital landscape with confidence and proficiency.'),
(78, 'To helps students to decide if a\r\ncareer in IT is right for them or to\r\ndevelop a broader understanding of\r\nIT.'),
(79, 'To identify cloud networking\r\nconcepts and storage techniques,\r\nand understand cloud design\r\naspects.'),
(80, 'To learn fundamental skills and\r\nknowledge related to essential\r\ncomputing and internet usage.'),
(81, NULL),
(82, ''),
(83, ''),
(84, NULL),
(85, ''),
(86, '');

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
-- Table structure for table `problems_encountered`
--

CREATE TABLE `problems_encountered` (
  `problems_encountered_id` int(11) NOT NULL,
  `problems_encountered_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problems_encountered`
--

INSERT INTO `problems_encountered` (`problems_encountered_id`, `problems_encountered_name`) VALUES
(10, 'There were some technical issues.'),
(12, 'The general assembly started late from the assigned time.'),
(13, 'There were some technical issues with microphones and speakers.'),
(14, 'N/A'),
(15, 'N/A'),
(16, 'N/A'),
(17, 'N/A'),
(18, NULL),
(19, ''),
(20, ''),
(21, ''),
(22, ''),
(23, ''),
(24, ''),
(25, ''),
(26, ''),
(27, ''),
(28, ''),
(29, ''),
(30, ''),
(31, ''),
(32, ''),
(33, NULL),
(34, NULL),
(35, ''),
(36, ''),
(37, NULL),
(38, ''),
(39, '');

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
-- Table structure for table `recommendations`
--

CREATE TABLE `recommendations` (
  `recommendations_id` int(11) NOT NULL,
  `recommendations_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`recommendations_id`, `recommendations_name`) VALUES
(9, 'Opening a mic or video should be only for committees and panelist of the program.'),
(10, 'Opening a mic or video should be only for committees and panelist of the program.'),
(11, 'Other audiences get bored easily, it should have a break or Icebreaker to also know if they are still listening.'),
(12, 'Must provide a more audible audio.'),
(13, 'Additional preparation and double checking with a checklist beforehand.'),
(14, 'Sound check and technical testing before the start of the general assembly to provide clear audio.'),
(15, 'Plan ahead with contingency plans in cases of unexpected situations'),
(16, 'N/A'),
(17, 'N/A'),
(18, 'N/A'),
(19, 'N/A'),
(20, NULL),
(21, ''),
(22, ''),
(23, ''),
(24, ''),
(25, ''),
(26, ''),
(27, ''),
(28, ''),
(29, ''),
(30, ''),
(31, ''),
(32, ''),
(33, ''),
(34, ''),
(35, NULL),
(36, NULL),
(37, ''),
(38, ''),
(39, NULL),
(40, ''),
(41, '');

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
  `users_email_verified` int(11) NOT NULL DEFAULT 0
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
-- Indexes for table `actions_taken`
--
ALTER TABLE `actions_taken`
  ADD PRIMARY KEY (`actions_taken_id`);

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
-- Indexes for table `documentation_pictures`
--
ALTER TABLE `documentation_pictures`
  ADD PRIMARY KEY (`documentation_pictures_id`);

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
-- Indexes for table `event_actions_taken`
--
ALTER TABLE `event_actions_taken`
  ADD PRIMARY KEY (`events_id`,`actions_taken_id`),
  ADD KEY `actions_taken_id` (`actions_taken_id`);

--
-- Indexes for table `event_documentation_pictures`
--
ALTER TABLE `event_documentation_pictures`
  ADD PRIMARY KEY (`events_id`,`documentation_pictures_id`),
  ADD KEY `documentation_pictures_id` (`documentation_pictures_id`);

--
-- Indexes for table `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD PRIMARY KEY (`event_invitations_id`),
  ADD KEY `event_invitations_events_id` (`event_invitations_events_id`);

--
-- Indexes for table `event_objectives`
--
ALTER TABLE `event_objectives`
  ADD PRIMARY KEY (`events_id`,`objectives_id`),
  ADD KEY `objectives_id` (`objectives_id`);

--
-- Indexes for table `event_problems_encountered`
--
ALTER TABLE `event_problems_encountered`
  ADD PRIMARY KEY (`events_id`,`problems_encountered_id`),
  ADD KEY `problems_encountered_id` (`problems_encountered_id`);

--
-- Indexes for table `event_recommendations`
--
ALTER TABLE `event_recommendations`
  ADD PRIMARY KEY (`events_id`,`recommendations_id`),
  ADD KEY `recommendations_id` (`recommendations_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`login_attempt_id`);

--
-- Indexes for table `objectives`
--
ALTER TABLE `objectives`
  ADD PRIMARY KEY (`objectives_id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`password_reset_id`),
  ADD KEY `password_reset_users_id` (`password_reset_users_id`);

--
-- Indexes for table `problems_encountered`
--
ALTER TABLE `problems_encountered`
  ADD PRIMARY KEY (`problems_encountered_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profiles_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `recommendations`
--
ALTER TABLE `recommendations`
  ADD PRIMARY KEY (`recommendations_id`);

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
-- AUTO_INCREMENT for table `actions_taken`
--
ALTER TABLE `actions_taken`
  MODIFY `actions_taken_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `departments_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `documentation_pictures`
--
ALTER TABLE `documentation_pictures`
  MODIFY `documentation_pictures_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `email_verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `events_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `event_invitations`
--
ALTER TABLE `event_invitations`
  MODIFY `event_invitations_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `login_attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `objectives`
--
ALTER TABLE `objectives`
  MODIFY `objectives_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `problems_encountered`
--
ALTER TABLE `problems_encountered`
  MODIFY `problems_encountered_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `recommendations`
--
ALTER TABLE `recommendations`
  MODIFY `recommendations_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

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
-- Constraints for table `event_actions_taken`
--
ALTER TABLE `event_actions_taken`
  ADD CONSTRAINT `event_actions_taken_ibfk_3` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_actions_taken_ibfk_4` FOREIGN KEY (`actions_taken_id`) REFERENCES `actions_taken` (`actions_taken_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_documentation_pictures`
--
ALTER TABLE `event_documentation_pictures`
  ADD CONSTRAINT `event_documentation_pictures_ibfk_3` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_documentation_pictures_ibfk_4` FOREIGN KEY (`documentation_pictures_id`) REFERENCES `documentation_pictures` (`documentation_pictures_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_invitations`
--
ALTER TABLE `event_invitations`
  ADD CONSTRAINT `event_invitations_ibfk_1` FOREIGN KEY (`event_invitations_events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_objectives`
--
ALTER TABLE `event_objectives`
  ADD CONSTRAINT `event_objectives_ibfk_3` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_objectives_ibfk_4` FOREIGN KEY (`objectives_id`) REFERENCES `objectives` (`objectives_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_problems_encountered`
--
ALTER TABLE `event_problems_encountered`
  ADD CONSTRAINT `event_problems_encountered_ibfk_3` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_problems_encountered_ibfk_4` FOREIGN KEY (`problems_encountered_id`) REFERENCES `problems_encountered` (`problems_encountered_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_recommendations`
--
ALTER TABLE `event_recommendations`
  ADD CONSTRAINT `event_recommendations_ibfk_3` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_recommendations_ibfk_4` FOREIGN KEY (`recommendations_id`) REFERENCES `recommendations` (`recommendations_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`events_id`) REFERENCES `events` (`events_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
