-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2025 at 02:01 PM
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
-- Database: `srms_empty`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_terms`
--

CREATE TABLE `academic_terms` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ca` varchar(255) NOT NULL,
  `status` enum('ENABLED','DISABLED') NOT NULL DEFAULT 'ENABLED',
  `show_results` enum('YES','NO') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `announcement` longtext NOT NULL,
  `audience` enum('Teachers','Students','Both') NOT NULL,
  `date_published` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `programme` bigint(20) NOT NULL,
  `grading_system` bigint(20) DEFAULT NULL,
  `division_system` bigint(20) DEFAULT NULL,
  `award_method` enum('DIVISION','AVERAGE') NOT NULL,
  `status` enum('ENABLED','DISABLED') NOT NULL DEFAULT 'ENABLED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `continuous_assessments`
--

CREATE TABLE `continuous_assessments` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `weight` double NOT NULL,
  `status` enum('ENABLED','DISABLED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `division_systems`
--

CREATE TABLE `division_systems` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `points_sorting` enum('Ascending','Descending') NOT NULL,
  `details` text NOT NULL,
  `status` enum('ENABLED','DISABLED') NOT NULL DEFAULT 'ENABLED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `division_systems`
--

INSERT INTO `division_systems` (`id`, `name`, `points_sorting`, `details`, `status`) VALUES
(1, 'Division Calculation (CSEE)', 'Ascending', 'a:5:{i:0;a:6:{s:10:\"scale_name\";s:10:\"Division I\";s:9:\"min_point\";s:1:\"7\";s:9:\"max_point\";s:2:\"17\";s:6:\"remark\";s:9:\"Excellent\";s:15:\"teacher_comment\";s:48:\"Outstanding performance. Keep up the great work!\";s:20:\"head_teacher_comment\";s:47:\"An excellent student with exemplary discipline.\";}i:1;a:6:{s:10:\"scale_name\";s:11:\"Division Ii\";s:9:\"min_point\";s:2:\"18\";s:9:\"max_point\";s:2:\"21\";s:6:\"remark\";s:9:\"Very Good\";s:15:\"teacher_comment\";s:52:\"Very good work. A little more effort for excellence.\";s:20:\"head_teacher_comment\";s:47:\"Shows strong academic ability and good conduct.\";}i:2;a:6:{s:10:\"scale_name\";s:12:\"Division Iii\";s:9:\"min_point\";s:2:\"22\";s:9:\"max_point\";s:2:\"25\";s:6:\"remark\";s:4:\"Good\";s:15:\"teacher_comment\";s:48:\"Good effort but needs improvement in some areas.\";s:20:\"head_teacher_comment\";s:50:\"Average performance, potential for better results.\";}i:3;a:6:{s:10:\"scale_name\";s:11:\"Division Iv\";s:9:\"min_point\";s:2:\"26\";s:9:\"max_point\";s:2:\"33\";s:6:\"remark\";s:12:\"Satisfactory\";s:15:\"teacher_comment\";s:48:\"Fair work. Student should work harder next term.\";s:20:\"head_teacher_comment\";s:44:\"Below expected level, needs more dedication.\";}i:4;a:6:{s:10:\"scale_name\";s:10:\"Division 0\";s:9:\"min_point\";s:2:\"34\";s:9:\"max_point\";s:2:\"50\";s:6:\"remark\";s:4:\"Fail\";s:15:\"teacher_comment\";s:57:\"Performance unsatisfactory. Immediate improvement needed.\";s:20:\"head_teacher_comment\";s:38:\"Not promoted. Serious effort required.\";}}', 'ENABLED'),
(2, 'Division Calculation (ACSEE)', 'Descending', 'a:5:{i:0;a:6:{s:10:\"scale_name\";s:10:\"Division I\";s:9:\"min_point\";s:2:\"11\";s:9:\"max_point\";s:2:\"15\";s:6:\"remark\";s:9:\"Excellent\";s:15:\"teacher_comment\";s:51:\"Outstanding performance, well-prepared and focused.\";s:20:\"head_teacher_comment\";s:54:\"An excellent candidate showing high academic maturity.\";}i:1;a:6:{s:10:\"scale_name\";s:11:\"Division Ii\";s:9:\"min_point\";s:1:\"9\";s:9:\"max_point\";s:2:\"10\";s:6:\"remark\";s:9:\"Very Good\";s:15:\"teacher_comment\";s:50:\"Very good results, consistent and capable student.\";s:20:\"head_teacher_comment\";s:44:\"A hardworking student with strong potential.\";}i:2;a:6:{s:10:\"scale_name\";s:12:\"Division Iii\";s:9:\"min_point\";s:1:\"7\";s:9:\"max_point\";s:1:\"8\";s:6:\"remark\";s:4:\"Good\";s:15:\"teacher_comment\";s:53:\"Good performance, can reach higher level with effort.\";s:20:\"head_teacher_comment\";s:47:\"Average, needs to improve focus and commitment.\";}i:3;a:6:{s:10:\"scale_name\";s:11:\"Division Iv\";s:9:\"min_point\";s:1:\"5\";s:9:\"max_point\";s:1:\"6\";s:6:\"remark\";s:12:\"Satisfactory\";s:15:\"teacher_comment\";s:44:\"Fair performance, needs serious improvement.\";s:20:\"head_teacher_comment\";s:50:\"Below expectation, more study discipline required.\";}i:4;a:6:{s:10:\"scale_name\";s:10:\"Division 0\";s:9:\"min_point\";s:1:\"0\";s:9:\"max_point\";s:1:\"4\";s:6:\"remark\";s:4:\"Fail\";s:15:\"teacher_comment\";s:32:\"Did not meet required standards.\";s:20:\"head_teacher_comment\";s:57:\"Not eligible for university entry. Needs full repetition.\";}}', 'ENABLED');

-- --------------------------------------------------------

--
-- Table structure for table `examination_results`
--

CREATE TABLE `examination_results` (
  `id` bigint(20) NOT NULL,
  `reg_no` varchar(60) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `term` bigint(20) NOT NULL,
  `ca` bigint(20) NOT NULL,
  `results` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grading_systems`
--

CREATE TABLE `grading_systems` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` text NOT NULL,
  `status` enum('ENABLED','DISABLED') NOT NULL DEFAULT 'ENABLED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grading_systems`
--

INSERT INTO `grading_systems` (`id`, `name`, `details`, `status`) VALUES
(1, 'Ordinary Level (O-Level: Form I–IV)', 'a:5:{i:0;a:7:{s:5:\"grade\";s:1:\"A\";s:9:\"min_score\";s:2:\"75\";s:9:\"max_score\";s:3:\"100\";s:6:\"points\";s:1:\"1\";s:6:\"remark\";s:9:\"Excellent\";s:15:\"teacher_comment\";s:48:\"Outstanding performance. Keep up the great work!\";s:20:\"head_teacher_comment\";s:47:\"An excellent student with exemplary discipline.\";}i:1;a:7:{s:5:\"grade\";s:1:\"B\";s:9:\"min_score\";s:2:\"65\";s:9:\"max_score\";s:2:\"74\";s:6:\"points\";s:1:\"2\";s:6:\"remark\";s:9:\"Very Good\";s:15:\"teacher_comment\";s:52:\"Very good work. A little more effort for excellence.\";s:20:\"head_teacher_comment\";s:47:\"Shows strong academic ability and good conduct.\";}i:2;a:7:{s:5:\"grade\";s:1:\"C\";s:9:\"min_score\";s:2:\"45\";s:9:\"max_score\";s:2:\"64\";s:6:\"points\";s:1:\"3\";s:6:\"remark\";s:4:\"Good\";s:15:\"teacher_comment\";s:48:\"Good effort but needs improvement in some areas.\";s:20:\"head_teacher_comment\";s:50:\"Average performance, potential for better results.\";}i:3;a:7:{s:5:\"grade\";s:1:\"D\";s:9:\"min_score\";s:2:\"30\";s:9:\"max_score\";s:2:\"44\";s:6:\"points\";s:1:\"4\";s:6:\"remark\";s:12:\"Satisfactory\";s:15:\"teacher_comment\";s:48:\"Fair work. Student should work harder next term.\";s:20:\"head_teacher_comment\";s:44:\"Below expected level, needs more dedication.\";}i:4;a:7:{s:5:\"grade\";s:1:\"F\";s:9:\"min_score\";s:1:\"0\";s:9:\"max_score\";s:2:\"29\";s:6:\"points\";s:1:\"5\";s:6:\"remark\";s:4:\"Fail\";s:15:\"teacher_comment\";s:57:\"Performance unsatisfactory. Immediate improvement needed.\";s:20:\"head_teacher_comment\";s:38:\"Not promoted. Serious effort required.\";}}', 'ENABLED'),
(2, 'Advanced Level (A-Level: Form V–VI)', 'a:7:{i:0;a:7:{s:5:\"grade\";s:1:\"A\";s:9:\"min_score\";s:2:\"80\";s:9:\"max_score\";s:3:\"100\";s:6:\"points\";s:1:\"5\";s:6:\"remark\";s:9:\"Excellent\";s:15:\"teacher_comment\";s:3:\"N/A\";s:20:\"head_teacher_comment\";s:3:\"N/A\";}i:1;a:7:{s:5:\"grade\";s:1:\"B\";s:9:\"min_score\";s:2:\"70\";s:9:\"max_score\";s:2:\"79\";s:6:\"points\";s:1:\"4\";s:6:\"remark\";s:9:\"Very Good\";s:15:\"teacher_comment\";s:3:\"N/A\";s:20:\"head_teacher_comment\";s:3:\"N/A\";}i:2;a:7:{s:5:\"grade\";s:1:\"C\";s:9:\"min_score\";s:2:\"60\";s:9:\"max_score\";s:2:\"69\";s:6:\"points\";s:1:\"3\";s:6:\"remark\";s:4:\"Good\";s:15:\"teacher_comment\";s:3:\"N/A\";s:20:\"head_teacher_comment\";s:3:\"N/A\";}i:3;a:7:{s:5:\"grade\";s:1:\"D\";s:9:\"min_score\";s:2:\"50\";s:9:\"max_score\";s:2:\"59\";s:6:\"points\";s:1:\"2\";s:6:\"remark\";s:12:\"Satisfactory\";s:15:\"teacher_comment\";s:3:\"N/A\";s:20:\"head_teacher_comment\";s:3:\"N/A\";}i:4;a:7:{s:5:\"grade\";s:1:\"E\";s:9:\"min_score\";s:2:\"40\";s:9:\"max_score\";s:2:\"49\";s:6:\"points\";s:1:\"1\";s:6:\"remark\";s:4:\"Fair\";s:15:\"teacher_comment\";s:3:\"N/A\";s:20:\"head_teacher_comment\";s:3:\"N/A\";}i:5;a:7:{s:5:\"grade\";s:1:\"S\";s:9:\"min_score\";s:2:\"30\";s:9:\"max_score\";s:2:\"39\";s:6:\"points\";s:3:\"0.5\";s:6:\"remark\";s:15:\"Subsidiary Pass\";s:15:\"teacher_comment\";s:3:\"N/A\";s:20:\"head_teacher_comment\";s:3:\"N/A\";}i:6;a:7:{s:5:\"grade\";s:1:\"F\";s:9:\"min_score\";s:1:\"0\";s:9:\"max_score\";s:2:\"29\";s:6:\"points\";s:1:\"0\";s:6:\"remark\";s:4:\"Fail\";s:15:\"teacher_comment\";s:3:\"N/A\";s:20:\"head_teacher_comment\";s:3:\"N/A\";}}', 'ENABLED');

-- --------------------------------------------------------

--
-- Table structure for table `programmes`
--

CREATE TABLE `programmes` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `subjects` text NOT NULL,
  `status` enum('ENABLED','DISABLED') NOT NULL DEFAULT 'ENABLED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `results_serial_numbers`
--

CREATE TABLE `results_serial_numbers` (
  `id` bigint(20) NOT NULL,
  `reg_no` varchar(60) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `academic_term` bigint(20) NOT NULL,
  `serial_no` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_1` varchar(20) NOT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `email_1` varchar(100) NOT NULL,
  `email_2` varchar(100) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `logo` varchar(60) NOT NULL,
  `icon` varchar(60) NOT NULL,
  `stamp` varchar(60) NOT NULL,
  `stamp_enabled` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `timezone` varchar(100) NOT NULL,
  `slogan` varchar(100) NOT NULL,
  `short_code` varchar(60) NOT NULL,
  `theme` enum('0','1','2','3','4','5','6','7','8') NOT NULL DEFAULT '0',
  `sidebar` enum('sidebar-dark','sidebar-light') NOT NULL DEFAULT 'sidebar-dark'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `name`, `phone_1`, `phone_2`, `email_1`, `email_2`, `address`, `logo`, `icon`, `stamp`, `stamp_enabled`, `timezone`, `slogan`, `short_code`, `theme`, `sidebar`) VALUES
(1, 'Mwangavu Secondary School', '+255 713 456 789', '+255 762 987 654', 'info@mwangavusec.ac.tz', 'admissions@mwangavusec.ac.tz', 'P.O. Box 214, Mwangavu Village, Mbeya Region, Tanzania', 'logo_1762686117.png', 'icon_1762686212.png', 'stamp_1762687221.png', 'YES', 'Africa/Dar_es_Salaam', 'Lighting the Path to Knowledge and Excellence.', 'MSS', '0', 'sidebar-dark');

-- --------------------------------------------------------

--
-- Table structure for table `signatures`
--

CREATE TABLE `signatures` (
  `id` bigint(20) NOT NULL,
  `name_1` varchar(100) NOT NULL,
  `title_1` varchar(100) NOT NULL,
  `signature_1` varchar(60) NOT NULL,
  `1_enabled` enum('YES','NO') NOT NULL DEFAULT 'YES',
  `name_2` varchar(100) NOT NULL,
  `title_2` varchar(100) NOT NULL,
  `signature_2` varchar(60) NOT NULL,
  `2_enabled` enum('YES','NO') NOT NULL DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signatures`
--

INSERT INTO `signatures` (`id`, `name_1`, `title_1`, `signature_1`, `1_enabled`, `name_2`, `title_2`, `signature_2`, `2_enabled`) VALUES
(1, 'Hassan Mwampamba', 'Academic Teacher', 'H.mwampamba.', 'YES', 'Queen Malembeka', 'Head Teacher', 'Q.malembeka.', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` int(10) NOT NULL,
  `server` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `encryption` enum('tls','ssl') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `server`, `username`, `password`, `port`, `encryption`) VALUES
(1, 'smtp server', 'smtp username', 'smtp password', '587', 'tls');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `email` varchar(100) NOT NULL,
  `hashed_pw` varchar(100) NOT NULL,
  `role` enum('ADMIN','TEACHER') NOT NULL DEFAULT 'TEACHER',
  `account_status` enum('ENABLED','DISABLED') NOT NULL DEFAULT 'ENABLED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `last_name`, `gender`, `email`, `hashed_pw`, `role`, `account_status`) VALUES
(1, 'Abel', 'Msuya', 'Male', 'abel.msuya@srms.test', '$2y$10$f54QD6/8vwleOyPSpQLTuurOfoOiZoxzlxmQRpLIqkwrlHqpMeA1C', 'ADMIN', 'ENABLED');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `reg_no` varchar(60) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `hashed_pw` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL,
  `class` bigint(20) NOT NULL,
  `account_status` enum('ENABLED','DISABLED') NOT NULL,
  `display_img` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` bigint(20) NOT NULL,
  `code` varchar(60) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_principal` enum('YES','NO') NOT NULL,
  `status` enum('ENABLED','DISABLED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subject_combinations`
--

CREATE TABLE `subject_combinations` (
  `id` bigint(20) NOT NULL,
  `subject_id` bigint(20) NOT NULL,
  `class_id` bigint(20) NOT NULL,
  `teacher` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` bigint(20) NOT NULL,
  `continet` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timezone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `continet`, `timezone`) VALUES
(1, 'Africa', 'Africa/Abidjan'),
(2, 'Africa', 'Africa/Addis_Ababa'),
(3, 'Africa', 'Africa/Accra'),
(4, 'Africa', 'Africa/Algiers'),
(5, 'Africa', 'Africa/Asmara'),
(6, 'Africa', 'Africa/Bamako'),
(7, 'Africa', 'Africa/Bangui'),
(8, 'Africa', 'Africa/Banjul'),
(9, 'Africa', 'Africa/Bissau'),
(10, 'Africa', 'Africa/Blantyre'),
(11, 'Africa', 'Africa/Brazzaville'),
(12, 'Africa', 'Africa/Bujumbura'),
(13, 'Africa', 'Africa/Cairo'),
(14, 'Africa', 'Africa/Casablanca'),
(15, 'Africa', 'Africa/Ceuta'),
(16, 'Africa', 'Africa/Conakry'),
(17, 'Africa', 'Africa/Dakar'),
(18, 'Africa', 'Africa/Dar_es_Salaam'),
(19, 'Africa', 'Africa/Djibouti'),
(20, 'Africa', 'Africa/Douala'),
(21, 'Africa', 'Africa/El_Aaiun'),
(22, 'Africa', 'Africa/Freetown'),
(23, 'Africa', 'Africa/Gaborone'),
(24, 'Africa', 'Africa/Harare'),
(25, 'Africa', 'Africa/Johannesburg'),
(26, 'Africa', 'Africa/Juba'),
(27, 'Africa', 'Africa/Kampala'),
(28, 'Africa', 'Africa/Khartoum'),
(29, 'Africa', 'Africa/Kigali'),
(30, 'Africa', 'Africa/Kinshasa'),
(31, 'Africa', 'Africa/Lagos'),
(32, 'Africa', 'Africa/Libreville'),
(33, 'Africa', 'Africa/Lome'),
(34, 'Africa', 'Africa/Luanda'),
(35, 'Africa', 'Africa/Lubumbashi'),
(36, 'Africa', 'Africa/Lusaka'),
(37, 'Africa', 'Africa/Malabo'),
(38, 'Africa', 'Africa/Maputo'),
(39, 'Africa', 'Africa/Maseru'),
(40, 'Africa', 'Africa/Mbabane'),
(41, 'Africa', 'Africa/Mogadishu'),
(42, 'Africa', 'Africa/Monrovia'),
(43, 'Africa', 'Africa/Nairobi'),
(44, 'Africa', 'Africa/Ndjamena'),
(45, 'Africa', 'Africa/Niamey'),
(46, 'Africa', 'Africa/Nouakchott'),
(47, 'Africa', 'Africa/Ouagadougou'),
(48, 'Africa', 'Africa/Porto-Novo'),
(49, 'Africa', 'Africa/Sao_Tome'),
(50, 'Africa', 'Africa/Tripoli'),
(51, 'Africa', 'Africa/Tunis'),
(52, 'Africa', 'Africa/Windhoek'),
(53, 'Antarctica', 'Antarctica/Casey'),
(54, 'Antarctica', 'Antarctica/Davis'),
(55, 'Antarctica', 'Antarctica/DumontDUrville'),
(56, 'Antarctica', 'Antarctica/Macquarie'),
(57, 'Antarctica', 'Antarctica/Mawson'),
(58, 'Antarctica', 'Antarctica/McMurdo'),
(59, 'Antarctica', 'Antarctica/Palmer'),
(60, 'Antarctica', 'Antarctica/Rothera'),
(61, 'Antarctica', 'Antarctica/Syowa'),
(62, 'Antarctica', 'Antarctica/Troll'),
(63, 'Antarctica', 'Antarctica/Vostok'),
(64, 'Arctic', 'Arctic/Longyearbyen'),
(65, 'Australia', 'Australia/Adelaide'),
(66, 'Australia', 'Australia/Brisbane'),
(67, 'Australia', 'Australia/Broken_Hill'),
(68, 'Australia', 'Australia/Currie'),
(69, 'Australia', 'Australia/Darwin'),
(70, 'Australia', 'Australia/Eucla'),
(71, 'Australia', 'Australia/Hobart'),
(72, 'Australia', 'Australia/Lindeman'),
(73, 'Australia', 'Australia/Lord_Howe'),
(74, 'Australia', 'Australia/Melbourne'),
(75, 'Australia', 'Australia/Perth'),
(76, 'Australia', 'Australia/Sydney'),
(77, 'Atlantic', 'Atlantic/Azores'),
(78, 'Atlantic', 'Atlantic/Bermuda'),
(79, 'Atlantic', 'Atlantic/Canary'),
(80, 'Atlantic', 'Atlantic/Cape_Verde'),
(81, 'Atlantic', 'Atlantic/Faroe'),
(82, 'Atlantic', 'Atlantic/Madeira'),
(83, 'Atlantic', 'Atlantic/Reykjavik'),
(84, 'Atlantic', 'Atlantic/South_Georgia'),
(85, 'Atlantic', 'Atlantic/St_Helena'),
(86, 'Atlantic', 'Atlantic/Stanley'),
(87, 'Indian', 'Indian/Antananarivo'),
(88, 'Indian', 'Indian/Chagos'),
(89, 'Indian', 'Indian/Christmas'),
(90, 'Indian', 'Indian/Cocos'),
(91, 'Indian', 'Indian/Comoro'),
(92, 'Indian', 'Indian/Kerguelen'),
(93, 'Indian', 'Indian/Mahe'),
(94, 'Indian', 'Indian/Maldives'),
(95, 'Indian', 'Indian/Mauritius'),
(96, 'Indian', 'Indian/Mayotte'),
(97, 'Indian', 'Indian/Reunion'),
(98, 'Pacific', 'Pacific/Apia'),
(99, 'Pacific', 'Pacific/Auckland'),
(100, 'Pacific', 'Pacific/Bougainville'),
(101, 'Pacific', 'Pacific/Chatham'),
(102, 'Pacific', 'Pacific/Chuuk'),
(103, 'Pacific', 'Pacific/Easter'),
(104, 'Pacific', 'Pacific/Efate'),
(105, 'Pacific', 'Pacific/Enderbury'),
(106, 'Pacific', 'Pacific/Fakaofo'),
(107, 'Pacific', 'Pacific/Fiji'),
(108, 'Pacific', 'Pacific/Funafuti'),
(109, 'Pacific', 'Pacific/Galapagos'),
(110, 'Pacific', 'Pacific/Gambier'),
(111, 'Pacific', 'Pacific/Guadalcanal'),
(112, 'Pacific', 'Pacific/Guam'),
(113, 'Pacific', 'Pacific/Honolulu'),
(114, 'Pacific', 'Pacific/Kiritimati'),
(115, 'Pacific', 'Pacific/Kosrae'),
(116, 'Pacific', 'Pacific/Kwajalein'),
(117, 'Pacific', 'Pacific/Majuro'),
(118, 'Pacific', 'Pacific/Marquesas'),
(119, 'Pacific', 'Pacific/Midway'),
(120, 'Pacific', 'Pacific/Nauru'),
(121, 'Pacific', 'Pacific/Niue'),
(122, 'Pacific', 'Pacific/Norfolk'),
(123, 'Pacific', 'Pacific/Noumea'),
(124, 'Pacific', 'Pacific/Pago_Pago'),
(125, 'Pacific', 'Pacific/Palau'),
(126, 'Pacific', 'Pacific/Pitcairn'),
(127, 'Pacific', 'Pacific/Pohnpei'),
(128, 'Pacific', 'Pacific/Port_Moresby'),
(129, 'Pacific', 'Pacific/Rarotonga'),
(130, 'Pacific', 'Pacific/Saipan'),
(131, 'Pacific', 'Pacific/Tahiti'),
(132, 'Pacific', 'Pacific/Tarawa'),
(133, 'Pacific', 'Pacific/Tongatapu'),
(134, 'Pacific', 'Pacific/Wake'),
(135, 'Pacific', 'Pacific/Wallis'),
(136, 'Europe', 'Europe/Amsterdam'),
(137, 'Europe', 'Europe/Andorra'),
(138, 'Europe', 'Europe/Astrakhan'),
(139, 'Europe', 'Europe/Athens'),
(140, 'Europe', 'Europe/Belgrade'),
(141, 'Europe', 'Europe/Berlin'),
(142, 'Europe', 'Europe/Bratislava'),
(143, 'Europe', 'Europe/Brussels'),
(144, 'Europe', 'Europe/Bucharest'),
(145, 'Europe', 'Europe/Budapest'),
(146, 'Europe', 'Europe/Busingen'),
(147, 'Europe', 'Europe/Chisinau'),
(148, 'Europe', 'Europe/Copenhagen'),
(149, 'Europe', 'Europe/Dublin'),
(150, 'Europe', 'Europe/Gibraltar'),
(151, 'Europe', 'Europe/Guernsey'),
(152, 'Europe', 'Europe/Helsinki'),
(153, 'Europe', 'Europe/Isle_of_Man'),
(154, 'Europe', 'Europe/Istanbul'),
(155, 'Europe', 'Europe/Jersey'),
(156, 'Europe', 'Europe/Kaliningrad'),
(157, 'Europe', 'Europe/Kiev'),
(158, 'Europe', 'Europe/Kirov'),
(159, 'Europe', 'Europe/Lisbon'),
(160, 'Europe', 'Europe/Ljubljana'),
(161, 'Europe', 'Europe/London'),
(162, 'Europe', 'Europe/Luxembourg'),
(163, 'Europe', 'Europe/Madrid'),
(164, 'Europe', 'Europe/Malta'),
(165, 'Europe', 'Europe/Mariehamn'),
(166, 'Europe', 'Europe/Minsk'),
(167, 'Europe', 'Europe/Monaco'),
(168, 'Europe', 'Europe/Moscow'),
(169, 'Europe', 'Europe/Oslo'),
(170, 'Europe', 'Europe/Paris'),
(171, 'Europe', 'Europe/Podgorica'),
(172, 'Europe', 'Europe/Prague'),
(173, 'Europe', 'Europe/Riga'),
(174, 'Europe', 'Europe/Rome'),
(175, 'Europe', 'Europe/Samara'),
(176, 'Europe', 'Europe/San_Marino'),
(177, 'Europe', 'Europe/Sarajevo'),
(178, 'Europe', 'Europe/Saratov'),
(179, 'Europe', 'Europe/Simferopol'),
(180, 'Europe', 'Europe/Skopje'),
(181, 'Europe', 'Europe/Sofia'),
(182, 'Europe', 'Europe/Stockholm'),
(183, 'Europe', 'Europe/Tallinn'),
(184, 'Europe', 'Europe/Tirane'),
(185, 'Europe', 'Europe/Ulyanovsk'),
(186, 'Europe', 'Europe/Uzhgorod'),
(187, 'Europe', 'Europe/Vaduz'),
(188, 'Europe', 'Europe/Vatican'),
(189, 'Europe', 'Europe/Vienna'),
(190, 'Europe', 'Europe/Vilnius'),
(191, 'Europe', 'Europe/Volgograd'),
(192, 'Europe', 'Europe/Warsaw'),
(193, 'Europe', 'Europe/Zagreb'),
(194, 'Europe', 'Europe/Zaporozhye'),
(195, 'Europe', 'Europe/Zurich'),
(196, 'Asia', 'Asia/Aden'),
(197, 'Asia', 'Asia/Almaty'),
(198, 'Asia', 'Asia/Amman'),
(199, 'Asia', 'Asia/Anadyr'),
(200, 'Asia', 'Asia/Aqtau'),
(201, 'Asia', 'Asia/Aqtobe'),
(202, 'Asia', 'Asia/Ashgabat'),
(203, 'Asia', 'Asia/Atyrau'),
(204, 'Asia', 'Asia/Baghdad'),
(205, 'Asia', 'Asia/Bahrain'),
(206, 'Asia', 'Asia/Baku'),
(207, 'Asia', 'Asia/Bangkok'),
(208, 'Asia', 'Asia/Barnaul'),
(209, 'Asia', 'Asia/Beirut'),
(210, 'Asia', 'Asia/Bishkek'),
(211, 'Asia', 'Asia/Brunei'),
(212, 'Asia', 'Asia/Chita'),
(213, 'Asia', 'Asia/Choibalsan'),
(214, 'Asia', 'Asia/Colombo'),
(215, 'Asia', 'Asia/Damascus'),
(216, 'Asia', 'Asia/Dhaka'),
(217, 'Asia', 'Asia/Dili'),
(218, 'Asia', 'Asia/Dubai'),
(219, 'Asia', 'Asia/Dushanbe'),
(220, 'Asia', 'Asia/Famagusta'),
(221, 'Asia', 'Asia/Gaza'),
(222, 'Asia', 'Asia/Hebron'),
(223, 'Asia', 'Asia/Ho_Chi_Minh'),
(224, 'Asia', 'Asia/Hong_Kong'),
(225, 'Asia', 'Asia/Irkutsk'),
(226, 'Asia', 'Asia/Jakarta'),
(227, 'Asia', 'Asia/Jayapura'),
(228, 'Asia', 'Asia/Jerusalem'),
(229, 'Asia', 'Asia/Kabul'),
(230, 'Asia', 'Asia/Kamchatka'),
(231, 'Asia', 'Asia/Karachi'),
(232, 'Asia', 'Asia/Kathmandu'),
(233, 'Asia', 'Asia/Khandyga'),
(234, 'Asia', 'Asia/Kolkata'),
(235, 'Asia', 'Asia/Krasnoyarsk'),
(236, 'Asia', 'Asia/Kuala_Lumpur'),
(237, 'Asia', 'Asia/Kuching'),
(238, 'Asia', 'Asia/Kuwait'),
(239, 'Asia', 'Asia/Macau'),
(240, 'Asia', 'Asia/Magadan'),
(241, 'Asia', 'Asia/Makassar'),
(242, 'Asia', 'Asia/Manila'),
(243, 'Asia', 'Asia/Muscat'),
(244, 'Asia', 'Asia/Nicosia'),
(245, 'Asia', 'Asia/Novokuznetsk'),
(246, 'Asia', 'Asia/Novosibirsk'),
(247, 'Asia', 'Asia/Omsk'),
(248, 'Asia', 'Asia/Oral'),
(249, 'Asia', 'Asia/Phnom_Penh'),
(250, 'Asia', 'Asia/Pontianak'),
(251, 'Asia', 'Asia/Pyongyang'),
(252, 'Asia', 'Asia/Qatar'),
(253, 'Asia', 'Asia/Qyzylorda'),
(254, 'Asia', 'Asia/Riyadh'),
(255, 'Asia', 'Asia/Sakhalin'),
(256, 'Asia', 'Asia/Samarkand'),
(257, 'Asia', 'Asia/Seoul'),
(258, 'Asia', 'Asia/Shanghai'),
(259, 'Asia', 'Asia/Singapore'),
(260, 'Asia', 'Asia/Srednekolymsk'),
(261, 'Asia', 'Asia/Taipei'),
(262, 'Asia', 'Asia/Tashkent'),
(263, 'Asia', 'Asia/Tbilisi'),
(264, 'Asia', 'Asia/Tehran'),
(265, 'Asia', 'Asia/Thimphu'),
(266, 'Asia', 'Asia/Tokyo'),
(267, 'Asia', 'Asia/Tomsk'),
(268, 'Asia', 'Asia/Ulaanbaatar'),
(269, 'Asia', 'Asia/Urumqi'),
(270, 'Asia', 'Asia/Ust-Nera'),
(271, 'Asia', 'Asia/Vientiane'),
(272, 'Asia', 'Asia/Vladivostok'),
(273, 'Asia', 'Asia/Yakutsk'),
(274, 'Asia', 'Asia/Yangon'),
(275, 'Asia', 'Asia/Yekaterinburg'),
(276, 'Asia', 'Asia/Yerevan'),
(277, 'America', 'America/Adak'),
(278, 'America', 'America/Anchorage'),
(279, 'America', 'America/Anguilla'),
(280, 'America', 'America/Antigua'),
(281, 'America', 'America/Araguaina'),
(282, 'America', 'America/Argentina/Buenos_Aires'),
(283, 'America', 'America/Argentina/Catamarca'),
(284, 'America', 'America/Argentina/Cordoba'),
(285, 'America', 'America/Argentina/Jujuy'),
(286, 'America', 'America/Argentina/La_Rioja'),
(287, 'America', 'America/Argentina/Mendoza'),
(288, 'America', 'America/Argentina/Rio_Gallegos'),
(289, 'America', 'America/Argentina/Salta'),
(290, 'America', 'America/Argentina/San_Juan'),
(291, 'America', 'America/Argentina/San_Luis'),
(292, 'America', 'America/Argentina/Tucuman'),
(293, 'America', 'America/Argentina/Ushuaia'),
(294, 'America', 'America/Aruba'),
(295, 'America', 'America/Asuncion'),
(296, 'America', 'America/Atikokan'),
(297, 'America', 'America/Bahia'),
(298, 'America', 'America/Bahia_Banderas'),
(299, 'America', 'America/Barbados'),
(300, 'America', 'America/Belem'),
(301, 'America', 'America/Belize'),
(302, 'America', 'America/Blanc-Sablon'),
(303, 'America', 'America/Boa_Vista'),
(304, 'America', 'America/Bogota'),
(305, 'America', 'America/Boise'),
(306, 'America', 'America/Cambridge_Bay'),
(307, 'America', 'America/Campo_Grande'),
(308, 'America', 'America/Cancun'),
(309, 'America', 'America/Caracas'),
(310, 'America', 'America/Cayenne'),
(311, 'America', 'America/Cayman'),
(312, 'America', 'America/Chicago'),
(313, 'America', 'America/Chihuahua'),
(314, 'America', 'America/Costa_Rica'),
(315, 'America', 'America/Creston'),
(316, 'America', 'America/Cuiaba'),
(317, 'America', 'America/Curacao'),
(318, 'America', 'America/Danmarkshavn'),
(319, 'America', 'America/Dawson'),
(320, 'America', 'America/Dawson_Creek'),
(321, 'America', 'America/Denver'),
(322, 'America', 'America/Detroit'),
(323, 'America', 'America/Dominica'),
(324, 'America', 'America/Edmonton'),
(325, 'America', 'America/Eirunepe'),
(326, 'America', 'America/El_Salvador'),
(327, 'America', 'America/Fort_Nelson'),
(328, 'America', 'America/Fortaleza'),
(329, 'America', 'America/Glace_Bay'),
(330, 'America', 'America/Godthab'),
(331, 'America', 'America/Goose_Bay'),
(332, 'America', 'America/Grand_Turk'),
(333, 'America', 'America/Grenada'),
(334, 'America', 'America/Guadeloupe'),
(335, 'America', 'America/Guatemala'),
(336, 'America', 'America/Guayaquil'),
(337, 'America', 'America/Guyana'),
(338, 'America', 'America/Halifax'),
(339, 'America', 'America/Havana'),
(340, 'America', 'America/Hermosillo'),
(341, 'America', 'America/Indiana/Indianapolis'),
(342, 'America', 'America/Indiana/Knox'),
(343, 'America', 'America/Indiana/Marengo'),
(344, 'America', 'America/Indiana/Petersburg'),
(345, 'America', 'America/Indiana/Tell_City'),
(346, 'America', 'America/Indiana/Vevay'),
(347, 'America', 'America/Indiana/Vincennes'),
(348, 'America', 'America/Indiana/Winamac'),
(349, 'America', 'America/Inuvik'),
(350, 'America', 'America/Iqaluit'),
(351, 'America', 'America/Jamaica'),
(352, 'America', 'America/Juneau'),
(353, 'America', 'America/Kentucky/Louisville'),
(354, 'America', 'America/Kentucky/Monticello'),
(355, 'America', 'America/Kralendijk'),
(356, 'America', 'America/La_Paz'),
(357, 'America', 'America/Lima'),
(358, 'America', 'America/Los_Angeles'),
(359, 'America', 'America/Lower_Princes'),
(360, 'America', 'America/Maceio'),
(361, 'America', 'America/Managua'),
(362, 'America', 'America/Manaus'),
(363, 'America', 'America/Marigot'),
(364, 'America', 'America/Martinique'),
(365, 'America', 'America/Matamoros'),
(366, 'America', 'America/Mazatlan'),
(367, 'America', 'America/Menominee'),
(368, 'America', 'America/Merida'),
(369, 'America', 'America/Metlakatla'),
(370, 'America', 'America/Mexico_City'),
(371, 'America', 'America/Miquelon'),
(372, 'America', 'America/Moncton'),
(373, 'America', 'America/Monterrey'),
(374, 'America', 'America/Montevideo'),
(375, 'America', 'America/Montserrat'),
(376, 'America', 'America/Nassau'),
(377, 'America', 'America/New_York'),
(378, 'America', 'America/Nipigon'),
(379, 'America', 'America/Nome'),
(380, 'America', 'America/Noronha'),
(381, 'America', 'America/North_Dakota/Beulah'),
(382, 'America', 'America/North_Dakota/Center'),
(383, 'America', 'America/North_Dakota/New_Salem'),
(384, 'America', 'America/Ojinaga'),
(385, 'America', 'America/Panama'),
(386, 'America', 'America/Pangnirtung'),
(387, 'America', 'America/Paramaribo'),
(388, 'America', 'America/Phoenix'),
(389, 'America', 'America/Port-au-Prince'),
(390, 'America', 'America/Port_of_Spain'),
(391, 'America', 'America/Porto_Velho'),
(392, 'America', 'America/Puerto_Rico'),
(393, 'America', 'America/Punta_Arenas'),
(394, 'America', 'America/Rainy_River'),
(395, 'America', 'America/Rankin_Inlet'),
(396, 'America', 'America/Recife'),
(397, 'America', 'America/Regina'),
(398, 'America', 'America/Resolute'),
(399, 'America', 'America/Rio_Branco'),
(400, 'America', 'America/Santarem'),
(401, 'America', 'America/Santiago'),
(402, 'America', 'America/Santo_Domingo'),
(403, 'America', 'America/Sao_Paulo'),
(404, 'America', 'America/Scoresbysund'),
(405, 'America', 'America/Sitka'),
(406, 'America', 'America/St_Barthelemy'),
(407, 'America', 'America/St_Johns'),
(408, 'America', 'America/St_Kitts'),
(409, 'America', 'America/St_Lucia'),
(410, 'America', 'America/St_Thomas'),
(411, 'America', 'America/St_Vincent'),
(412, 'America', 'America/Swift_Current'),
(413, 'America', 'America/Tegucigalpa'),
(414, 'America', 'America/Thule'),
(415, 'America', 'America/Thunder_Bay'),
(416, 'America', 'America/Tijuana'),
(417, 'America', 'America/Toronto'),
(418, 'America', 'America/Tortola'),
(419, 'America', 'America/Vancouver'),
(420, 'America', 'America/Whitehorse'),
(421, 'America', 'America/Winnipeg'),
(422, 'America', 'America/Yakutat'),
(423, 'America', 'America/Yellowknife');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_terms`
--
ALTER TABLE `academic_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programme` (`programme`),
  ADD KEY `grading_system` (`grading_system`),
  ADD KEY `division_sytem` (`division_system`);

--
-- Indexes for table `continuous_assessments`
--
ALTER TABLE `continuous_assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `division_systems`
--
ALTER TABLE `division_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `examination_results`
--
ALTER TABLE `examination_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `term` (`term`),
  ADD KEY `reg_no` (`reg_no`),
  ADD KEY `coursework` (`ca`);

--
-- Indexes for table `grading_systems`
--
ALTER TABLE `grading_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `programmes`
--
ALTER TABLE `programmes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results_serial_numbers`
--
ALTER TABLE `results_serial_numbers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_no` (`serial_no`),
  ADD KEY `academic_term` (`academic_term`),
  ADD KEY `reg_no` (`reg_no`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `school`
--
ALTER TABLE `school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signatures`
--
ALTER TABLE `signatures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_combinations`
--
ALTER TABLE `subject_combinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `teacher` (`teacher`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_terms`
--
ALTER TABLE `academic_terms`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `continuous_assessments`
--
ALTER TABLE `continuous_assessments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `division_systems`
--
ALTER TABLE `division_systems`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `examination_results`
--
ALTER TABLE `examination_results`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grading_systems`
--
ALTER TABLE `grading_systems`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `programmes`
--
ALTER TABLE `programmes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `results_serial_numbers`
--
ALTER TABLE `results_serial_numbers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school`
--
ALTER TABLE `school`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `signatures`
--
ALTER TABLE `signatures`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subject_combinations`
--
ALTER TABLE `subject_combinations`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=424;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`programme`) REFERENCES `programmes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`division_system`) REFERENCES `division_systems` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `classes_ibfk_3` FOREIGN KEY (`grading_system`) REFERENCES `grading_systems` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `examination_results`
--
ALTER TABLE `examination_results`
  ADD CONSTRAINT `examination_results_ibfk_1` FOREIGN KEY (`term`) REFERENCES `academic_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examination_results_ibfk_2` FOREIGN KEY (`ca`) REFERENCES `continuous_assessments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examination_results_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `examination_results_ibfk_4` FOREIGN KEY (`reg_no`) REFERENCES `students` (`reg_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `results_serial_numbers`
--
ALTER TABLE `results_serial_numbers`
  ADD CONSTRAINT `results_serial_numbers_ibfk_1` FOREIGN KEY (`academic_term`) REFERENCES `academic_terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_serial_numbers_ibfk_2` FOREIGN KEY (`reg_no`) REFERENCES `students` (`reg_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_serial_numbers_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_combinations`
--
ALTER TABLE `subject_combinations`
  ADD CONSTRAINT `subject_combinations_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_combinations_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_combinations_ibfk_3` FOREIGN KEY (`teacher`) REFERENCES `staff` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
