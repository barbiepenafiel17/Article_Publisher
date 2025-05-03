-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 08:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbclm_college`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `audience` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `notify` tinyint(1) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `publication_date`, `expiry_date`, `audience`, `attachment`, `notify`, `status`, `created_at`) VALUES
(6, 'Yearbook Orders', 'Last chance to order your yearbook! Deadline is April 20th.', NULL, NULL, 'students', '', 0, 'published', '2025-05-03 05:52:18'),
(7, 'Summer Programs', 'Registration for summer enrichment programs opens next Monday.', NULL, NULL, 'students', '', 0, 'published', '2025-05-03 05:54:43'),
(10, 'Hello', 'hello world', NULL, NULL, 'students', NULL, 1, 'published', '2025-05-03 06:17:15');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `abstract` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `allow_comments` tinyint(1) DEFAULT 1,
  `notify_comments` tinyint(1) DEFAULT 1,
  `status` enum('PENDING','APPROVED','REJECTED') NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `institute_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT current_timestamp(),
  `comments_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `notifications` tinyint(1) NOT NULL DEFAULT 0,
  `feedback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `abstract`, `content`, `featured_image`, `allow_comments`, `notify_comments`, `status`, `created_at`, `institute_id`, `created`, `comments_enabled`, `notifications`, `feedback`) VALUES
(4, 8, 'PAldooo ', 'papart', 'ambot', 'uploads/img_680a044e904819.70602670.jpg', 1, 1, 'APPROVED', '2025-04-24 09:28:46', NULL, '2025-04-24 17:28:46', 1, 1, NULL),
(5, 8, 'Bombarat', 'fdjoahsgiofhae', 'a.g,sm;sjd;gh', 'uploads/img_680a0792689883.97526885.jpg', 1, 1, 'APPROVED', '2025-04-24 09:42:42', NULL, '2025-04-24 17:42:42', 1, 1, NULL),
(6, 8, 'Trulalalal', 'ghghfuguygf', 'gugvhujbb', 'uploads/img_680a0d039f2be6.59772375.jpg', 1, 1, 'APPROVED', '2025-04-24 10:05:55', NULL, '2025-04-24 18:05:55', 1, 1, NULL),
(7, 8, 'ajijghsfiugais', 'agsrafdhatj', 'aerhejeat', 'uploads/img_680a198e18aa58.54635471.jpg', 1, 1, 'APPROVED', '2025-04-24 10:59:26', NULL, '2025-04-24 18:59:26', 1, 1, NULL),
(8, 8, 'jkafgisdgig', 'aghiufih', 'ssjgoihrhhhgilse', 'uploads/img_680a28d58a81c3.60514892.jpg', 1, 1, 'REJECTED', '2025-04-24 12:04:37', NULL, '2025-04-24 20:04:37', 1, 1, NULL),
(9, 8, 'barbie', 'ajklkhsgs', 'ageahtajtj', 'uploads/img_680a2903cc9743.27319197.jpg', 1, 1, 'REJECTED', '2025-04-24 12:05:23', NULL, '2025-04-24 20:05:23', 1, 1, NULL),
(10, 8, 'blabla', 'spofugiopsahopihi', 'ajglk;wldsgp', 'uploads/img_680a34b1780bc0.80740942.jpg', 1, 1, 'REJECTED', '2025-04-24 12:55:13', NULL, '2025-04-24 20:55:13', 1, 1, NULL),
(11, 8, 'blabla', 'spofugiopsahopihi', 'ajglk;wldsgp', 'uploads/img_680a353b8ee3d8.92023325.jpg', 1, 1, 'APPROVED', '2025-04-24 12:57:31', NULL, '2025-04-24 20:57:31', 1, 1, NULL),
(12, 8, 'Barbie', 'asklkjfahg', 'jaghsa', 'uploads/img_680a38b1905de3.97995522.jpg', 1, 1, 'APPROVED', '2025-04-24 13:12:17', NULL, '2025-04-24 21:12:17', 1, 1, NULL),
(13, 8, 'Barbie', 'asklkjfahg', 'jaghsa', 'uploads/img_680a38de3da2e2.36940066.jpg', 1, 1, 'REJECTED', '2025-04-24 13:13:02', NULL, '2025-04-24 21:13:02', 1, 1, NULL),
(14, 9, 'neglknweklhsilhaed', 'agjljselg', 'nsdlkgkldsnglkhsd', 'uploads/img_680a467bd3a1c7.61405220.jpg', 1, 1, '', '2025-04-24 14:11:07', NULL, '2025-04-24 22:11:07', 1, 1, NULL),
(15, 8, 'Hello worlds', 'everyone', 'alooooo', 'uploads/img_680a50721bc053.21801741.jpg', 1, 1, 'REJECTED', '2025-04-24 14:53:38', NULL, '2025-04-24 22:53:38', 1, 1, NULL),
(16, 8, 'sfasgas', 'agsasg', 'asghag', 'uploads/img_680b761fbd9aa4.70161297.jpg', 1, 1, 'REJECTED', '2025-04-25 11:46:39', NULL, '2025-04-25 19:46:39', 1, 1, NULL),
(17, 8, 'Hello world', 'Web Designer', 'Professional', 'uploads/img_680ba1683fdab4.17357827.jpg', 1, 1, '', '2025-04-25 14:51:20', NULL, '2025-04-25 22:51:20', 1, 1, NULL),
(18, 8, 'AFASF', 'SAGADGA', 'AGASG', 'uploads/img_680ba20eb70010.84367171.jpg', 1, 1, 'APPROVED', '2025-04-25 14:54:06', NULL, '2025-04-25 22:54:06', 1, 1, 'Make it personal'),
(19, 8, 'The Audience', 'basvkjlba', 'adb./,msdnb', 'uploads/img_680c458c213a46.09308117.jpg', 1, 1, 'APPROVED', '2025-04-26 02:31:40', NULL, '2025-04-26 10:31:40', 0, 1, NULL),
(20, 8, 'The Books', 'srhdjtft', 'tjxghf', 'uploads/img_680c494bd7a303.11563588.jpg', 1, 1, 'APPROVED', '2025-04-26 02:47:39', NULL, '2025-04-26 10:47:39', 1, 1, 'I dont Like\r\n'),
(21, 8, 'The Latter', 'kjshdvjkshjkv', 'sdndgng', 'uploads/img_680c4afc4fc1b4.86927574.jpg', 1, 1, 'APPROVED', '2025-04-26 02:54:52', NULL, '2025-04-26 10:54:52', 1, 1, NULL),
(22, 8, 'What a bitch', 'gsrhs', 'jsttyjsty', 'uploads/img_680c4d6cdfe461.96823667.jpg', 1, 1, '', '2025-04-26 03:05:16', NULL, '2025-04-26 11:05:16', 1, 1, 'not this'),
(23, 8, 'Hello Medrr', 'Deymmm', 'bsfhbe', 'uploads/img_680c9ade2ff681.22537909.jpg', 1, 1, 'REJECTED', '2025-04-26 08:35:42', NULL, '2025-04-26 16:35:42', 1, 1, 'I dont Like plese delete'),
(24, 8, 'Hello Beybi', 'hdsjhsfjsfj', 'gvsdbdx', NULL, 1, 1, 'APPROVED', '2025-04-26 08:40:50', NULL, '2025-04-26 16:40:50', 1, 1, NULL),
(25, 8, 'hagsfgasifgkasgf', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-04-26 08:48:43', NULL, '2025-04-26 16:48:43', 0, 0, NULL),
(26, 8, 'hello', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-04-26 08:48:51', NULL, '2025-04-26 16:48:51', 0, 0, NULL),
(27, 8, 'hihi', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-04-26 08:52:20', NULL, '2025-04-26 16:52:20', 0, 0, NULL),
(28, 10, 'samoka uy', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-04-26 08:56:29', NULL, '2025-04-26 16:56:29', 0, 0, NULL),
(29, 10, 'Hinako!', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-04-26 09:25:55', NULL, '2025-04-26 17:25:55', 0, 0, NULL),
(30, 9, 'Hello', NULL, NULL, NULL, 1, 1, '', '2025-04-26 13:28:35', NULL, '2025-04-26 21:28:35', 0, 0, NULL),
(31, 11, 'jjklsdklbsklhklsfdf', 'klkdjckl; dnb;k', 'l;jmfjbl;kdfl;b ', 'uploads/img_6810ce6b12e7c9.05614138.jpg', 1, 1, 'REJECTED', '2025-04-29 13:04:43', NULL, '2025-04-29 21:04:43', 1, 1, 'kldlknv lkxnvlk'),
(32, 11, 'adjvlksdlkjvljsdlkjvd', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-04-29 13:08:42', NULL, '2025-04-29 21:08:42', 0, 0, NULL),
(33, 11, 'kalibangon', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-04-29 13:09:09', NULL, '2025-04-29 21:09:09', 0, 0, NULL),
(34, 12, 'iurd0iiuh90eir09dk', NULL, NULL, NULL, 1, 1, '', '2025-04-30 05:45:09', NULL, '2025-04-30 13:45:09', 0, 0, NULL),
(35, 12, 'dhdfhdfhd', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-05-01 16:39:24', NULL, '2025-05-02 00:39:24', 0, 0, NULL),
(36, 12, 'yuiuiigig', NULL, NULL, NULL, 1, 1, 'APPROVED', '2025-05-01 18:15:42', NULL, '2025-05-02 02:15:42', 0, 0, NULL),
(37, 12, 'bar', 'xcbxb', 'xbxcb', 'uploads/img_6813bdd1d17c05.73350542.png', 1, 1, 'APPROVED', '2025-05-01 18:30:41', NULL, '2025-05-02 02:30:41', 1, 1, NULL),
(38, 12, 'Barb???', NULL, 'hello?', 'uploads/img_6813c1ba597028.90594245.jpg', 1, 1, 'APPROVED', '2025-05-01 18:47:22', NULL, '2025-05-02 02:47:22', 1, 1, NULL),
(39, 12, 'Donna', 'hello?????', NULL, 'uploads/img_6813c24e1f7697.97449506.jpg', 1, 1, 'APPROVED', '2025-05-01 18:49:50', NULL, '2025-05-02 02:49:50', 1, 1, NULL);

--
-- Triggers `articles`
--
DELIMITER $$
CREATE TRIGGER `after_article_insert` AFTER INSERT ON `articles` FOR EACH ROW BEGIN
    INSERT INTO article_logs (article_id, action)
    VALUES (NEW.id, 'INSERT');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `log_article_submission` AFTER INSERT ON `articles` FOR EACH ROW BEGIN
  INSERT INTO article_logs (article_id, action)
  VALUES (NEW.id, 'submitted');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `article_logs`
--

CREATE TABLE `article_logs` (
  `id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article_logs`
--

INSERT INTO `article_logs` (`id`, `article_id`, `action`, `timestamp`) VALUES
(1, 1, 'submitted', '2025-04-23 14:35:09'),
(2, 1, 'INSERT', '2025-04-23 14:35:09'),
(3, 2, 'submitted', '2025-04-23 14:49:53'),
(4, 2, 'INSERT', '2025-04-23 14:49:53'),
(5, 3, 'submitted', '2025-04-24 08:48:25'),
(6, 3, 'INSERT', '2025-04-24 08:48:25'),
(7, 4, 'submitted', '2025-04-24 09:28:46'),
(8, 4, 'INSERT', '2025-04-24 09:28:46'),
(9, 5, 'submitted', '2025-04-24 09:42:42'),
(10, 5, 'INSERT', '2025-04-24 09:42:42'),
(11, 6, 'submitted', '2025-04-24 10:05:55'),
(12, 6, 'INSERT', '2025-04-24 10:05:55'),
(13, 7, 'submitted', '2025-04-24 10:59:26'),
(14, 7, 'INSERT', '2025-04-24 10:59:26'),
(15, 8, 'submitted', '2025-04-24 12:04:37'),
(16, 8, 'INSERT', '2025-04-24 12:04:37'),
(17, 9, 'submitted', '2025-04-24 12:05:23'),
(18, 9, 'INSERT', '2025-04-24 12:05:23'),
(19, 10, 'submitted', '2025-04-24 12:55:13'),
(20, 10, 'INSERT', '2025-04-24 12:55:13'),
(21, 11, 'submitted', '2025-04-24 12:57:31'),
(22, 11, 'INSERT', '2025-04-24 12:57:31'),
(23, 12, 'submitted', '2025-04-24 13:12:17'),
(24, 12, 'INSERT', '2025-04-24 13:12:17'),
(25, 13, 'submitted', '2025-04-24 13:13:02'),
(26, 13, 'INSERT', '2025-04-24 13:13:02'),
(27, 14, 'submitted', '2025-04-24 14:11:07'),
(28, 14, 'INSERT', '2025-04-24 14:11:07'),
(29, 15, 'submitted', '2025-04-24 14:53:38'),
(30, 15, 'INSERT', '2025-04-24 14:53:38'),
(31, 16, 'submitted', '2025-04-25 11:46:39'),
(32, 16, 'INSERT', '2025-04-25 11:46:39'),
(33, 17, 'submitted', '2025-04-25 14:51:20'),
(34, 17, 'INSERT', '2025-04-25 14:51:20'),
(35, 18, 'submitted', '2025-04-25 14:54:06'),
(36, 18, 'INSERT', '2025-04-25 14:54:06'),
(37, 19, 'submitted', '2025-04-26 02:31:40'),
(38, 19, 'INSERT', '2025-04-26 02:31:40'),
(39, 20, 'submitted', '2025-04-26 02:47:39'),
(40, 20, 'INSERT', '2025-04-26 02:47:39'),
(41, 21, 'submitted', '2025-04-26 02:54:52'),
(42, 21, 'INSERT', '2025-04-26 02:54:52'),
(43, 22, 'submitted', '2025-04-26 03:05:16'),
(44, 22, 'INSERT', '2025-04-26 03:05:16'),
(45, 23, 'submitted', '2025-04-26 08:35:42'),
(46, 23, 'INSERT', '2025-04-26 08:35:42'),
(47, 24, 'submitted', '2025-04-26 08:40:50'),
(48, 24, 'INSERT', '2025-04-26 08:40:50'),
(49, 25, 'submitted', '2025-04-26 08:48:43'),
(50, 25, 'INSERT', '2025-04-26 08:48:43'),
(51, 26, 'submitted', '2025-04-26 08:48:51'),
(52, 26, 'INSERT', '2025-04-26 08:48:51'),
(53, 27, 'submitted', '2025-04-26 08:52:20'),
(54, 27, 'INSERT', '2025-04-26 08:52:20'),
(55, 28, 'submitted', '2025-04-26 08:56:29'),
(56, 28, 'INSERT', '2025-04-26 08:56:29'),
(57, 29, 'submitted', '2025-04-26 09:25:55'),
(58, 29, 'INSERT', '2025-04-26 09:25:55'),
(59, 30, 'submitted', '2025-04-26 13:28:35'),
(60, 30, 'INSERT', '2025-04-26 13:28:35'),
(61, 31, 'submitted', '2025-04-29 13:04:43'),
(62, 31, 'INSERT', '2025-04-29 13:04:43'),
(63, 32, 'submitted', '2025-04-29 13:08:42'),
(64, 32, 'INSERT', '2025-04-29 13:08:42'),
(65, 33, 'submitted', '2025-04-29 13:09:09'),
(66, 33, 'INSERT', '2025-04-29 13:09:09'),
(67, 34, 'submitted', '2025-04-30 05:45:09'),
(68, 34, 'INSERT', '2025-04-30 05:45:09'),
(69, 35, 'submitted', '2025-05-01 16:39:24'),
(70, 35, 'INSERT', '2025-05-01 16:39:24'),
(71, 36, 'submitted', '2025-05-01 18:15:42'),
(72, 36, 'INSERT', '2025-05-01 18:15:42'),
(73, 37, 'submitted', '2025-05-01 18:30:41'),
(74, 37, 'INSERT', '2025-05-01 18:30:41'),
(75, 38, 'submitted', '2025-05-01 18:47:22'),
(76, 38, 'INSERT', '2025-05-01 18:47:22'),
(77, 39, 'submitted', '2025-05-01 18:49:50'),
(78, 39, 'INSERT', '2025-05-01 18:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `article_reports`
--

CREATE TABLE `article_reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article_reports`
--

INSERT INTO `article_reports` (`id`, `user_id`, `article_id`, `reported_at`) VALUES
(1, 9, 33, '2025-05-01 17:10:28'),
(2, 9, 33, '2025-05-01 17:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `action` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `action`, `created_at`) VALUES
(1, 'New user created: Almie Penafiel with email barbie@dbclm.com', '2025-04-23 10:14:43'),
(2, 'New user created: Almie Penafiel with email abiii@dbclm.com', '2025-04-23 10:16:20'),
(3, 'New user created: cheni with email dal@dbclm.com', '2025-04-23 10:20:16'),
(4, 'New user created: laiza with email lai@dbclm.com', '2025-04-23 10:25:01'),
(5, 'New user created: Marjorie Casilao with email casilao123@dbclm.com', '2025-04-23 10:36:04'),
(6, 'New user created: Donameg with email eran@dbclm.com', '2025-04-24 06:20:01'),
(7, 'New user created: Cheni with email chenibibs@dbclm.com', '2025-04-24 14:10:00'),
(8, 'New user created: Almie Penafiel with email almie@dbclm.com', '2025-04-26 08:55:32'),
(9, 'New user created: Christian with email chan@dbclm.com', '2025-04-26 12:57:30'),
(10, 'New user created: Geni with email geni@dbclm.com', '2025-04-29 16:49:19');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `user_id`, `comment_text`, `created_at`) VALUES
(1, 16, 8, 'hello', '2025-04-25 22:37:00'),
(2, 16, 9, 'Hi', '2025-04-25 22:37:26'),
(3, 15, 9, 'Kuyaw Sya', '2025-04-25 22:37:44'),
(4, 6, 9, 'damnnn', '2025-04-25 22:38:21'),
(5, 18, 9, 'Ambot', '2025-04-25 23:03:52'),
(6, 7, 8, 'jgfjfhjfjfjhffjf', '2025-04-26 12:00:34'),
(7, 21, 8, 'yygtigtuig', '2025-04-26 12:00:40'),
(8, 26, 8, 'Deymm', '2025-04-26 16:51:49'),
(10, 27, 8, 'bogshhshshhs', '2025-04-26 22:04:00'),
(11, 27, 11, 'lqhgoihsaioghs', '2025-04-29 21:03:31'),
(12, 18, 11, 'mnavlknxsbd', '2025-04-29 21:07:34'),
(13, 30, 11, 'tanga kaba', '2025-04-29 21:07:57'),
(14, 33, 11, 'bd, ./fc,xn', '2025-04-29 21:10:16'),
(15, 33, 12, 'gbazDxdn', '2025-04-30 00:51:19'),
(16, 36, 8, 'Hi', '2025-05-02 23:18:49'),
(17, 33, 9, 'xcbxcnx', '2025-05-03 00:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `hidden_articles`
--

CREATE TABLE `hidden_articles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hidden_articles`
--

INSERT INTO `hidden_articles` (`id`, `user_id`, `article_id`) VALUES
(12, 9, 17),
(6, 9, 33),
(4, 12, 32),
(1, 12, 33);

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`) VALUES
(1, 'Institute of Computing'),
(2, 'Institute of Teacher Education'),
(3, 'Institute of Leadership, Entrepreneurship, and Good Governance'),
(4, 'Institute of Aquatic and Applied Sciences');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`, `seen`) VALUES
(1, 8, '🎉 Your article titled \'<strong>AFASF</strong>\' has been approved!', 0, '2025-04-25 15:00:06', 0),
(2, 8, '🎉 Your article titled \'<strong>AFASF</strong>\' has been approved!', 0, '2025-04-25 15:02:25', 0),
(3, 8, '🎉 Your article titled \'<strong>AFASF</strong>\' has been approved!', 0, '2025-04-25 15:02:27', 0),
(4, 8, '🎉 Your article titled \'<strong>AFASF</strong>\' has been approved!', 0, '2025-04-25 15:03:08', 0),
(5, 8, '🎉 Your article titled \'<strong>Hello worlds</strong>\' has been approved!', 0, '2025-04-25 15:03:11', 0),
(6, 8, '🎉 Your article titled \'<strong>Hello worlds</strong>\' has been approved!', 0, '2025-04-25 15:03:14', 0),
(7, 8, '🎉 Your article titled \'<strong>sfasgas</strong>\' has been approved!', 0, '2025-04-25 15:03:14', 0),
(8, 8, '🎉 Your article titled \'<strong>Hello world</strong>\' has been approved!', 0, '2025-04-25 15:03:15', 0),
(9, 8, '🎉 Your article titled \'<strong>sfasgas</strong>\' has been approved!', 0, '2025-04-25 15:03:15', 0),
(10, 8, '🎉 Your article titled \'<b>AFASF</b>\' has been approved!', 0, '2025-04-25 15:41:02', 0),
(11, 8, '🎉 Your article titled \'<b>Hello world</b>\' has been approved!', 0, '2025-04-25 15:41:04', 0),
(12, 8, '🎉 Your article titled \'<b>AFASF</b>\' has been approved!', 0, '2025-04-25 15:45:53', 0),
(13, 8, '🎉 Your article titled \'<b>AFASF</b>\' has been approved!', 0, '2025-04-25 15:47:58', 0),
(14, 8, '🎉 Your article titled \'<b>The Audience</b>\' has been approved!', 0, '2025-04-26 02:32:15', 0),
(15, 8, 'Your article titled \'\' has been rejected. Reason: I dont Like\r\n', 0, '2025-04-26 02:48:04', 0),
(16, 8, '🎉 Your article titled \'The Books\' has been approved!', 0, '2025-04-26 02:48:13', 0),
(17, 8, '🎉 Your article titled \'The Latter\' has been approved!', 0, '2025-04-26 02:55:12', 0),
(18, 8, '🎉 Your article titled \'What a bitch\' has been approved!', 0, '2025-04-26 03:05:22', 0),
(19, 8, 'Your article titled \'\' has been rejected. Reason: not this', 0, '2025-04-26 03:10:24', 0),
(20, 8, '🎉 Your article titled \'What a bitch\' has been approved!', 0, '2025-04-26 04:01:10', 0),
(21, 8, '🎉 Your article titled \'Hello Medrr\' has been approved!', 0, '2025-04-26 08:35:53', 0),
(22, 8, 'Your article titled \'\' has been rejected. Reason: I dont Like plese delete', 0, '2025-04-26 08:37:22', 0),
(23, 8, '🎉 Your article titled \'Hello Beybi\' has been approved!', 0, '2025-04-26 08:41:00', 0),
(24, 8, '🎉 Your article titled \'hello\' has been approved!', 0, '2025-04-26 08:48:57', 0),
(25, 8, '🎉 Your article titled \'hagsfgasifgkasgf\' has been approved!', 0, '2025-04-26 08:48:58', 0),
(26, 8, '🎉 Your article titled \'hihi\' has been approved!', 0, '2025-04-26 08:52:29', 0),
(27, 10, '🎉 Your article titled \'samoka uy\' has been approved!', 0, '2025-04-26 08:56:48', 0),
(28, 10, '🎉 Your article titled \'Hinako!\' has been approved!', 0, '2025-04-26 13:11:54', 0),
(29, 9, '🎉 Your article titled \'Hello\' has been approved!', 0, '2025-04-26 13:28:51', 0),
(30, 11, 'Your article titled \'\' has been rejected. Reason: kldlknv lkxnvlk', 0, '2025-04-29 13:04:57', 0),
(31, 11, '🎉 Your article titled \'kalibangon\' has been approved!', 0, '2025-04-29 13:09:17', 0),
(32, 11, '🎉 Your article titled \'adjvlksdlkjvljsdlkjvd\' has been approved!', 0, '2025-04-29 16:35:50', 0),
(33, 12, '🎉 Your article titled \'iurd0iiuh90eir09dk\' has been approved!', 0, '2025-04-30 05:45:23', 0),
(34, 12, '🎉 Your article titled \'dhdfhdfhd\' has been approved!', 0, '2025-05-01 16:39:40', 0),
(35, 12, '🎉 Your article titled \'yuiuiigig\' has been approved!', 0, '2025-05-01 18:15:50', 0),
(36, 12, '🎉 Your article titled \'bar\' has been approved!', 0, '2025-05-01 18:30:46', 0),
(37, 12, '🎉 Your article titled \'Barb???\' has been approved!', 0, '2025-05-01 18:47:27', 0),
(38, 12, '🎉 Your article titled \'Donna\' has been approved!', 0, '2025-05-01 18:49:55', 0),
(39, 12, '🎉 Your article titled \'dhdfhdfhd\' has been approved!', 0, '2025-05-03 03:31:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reaction_type` enum('like','love','haha','wow','sad','angry') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `article_id`, `user_id`, `reaction_type`, `created_at`) VALUES
(5, 7, 9, 'like', '2025-04-25 21:43:51'),
(6, 6, 9, 'like', '2025-04-25 21:44:02'),
(7, 5, 9, 'like', '2025-04-25 21:44:04'),
(8, 4, 9, 'like', '2025-04-25 21:44:06'),
(9, 11, 9, 'like', '2025-04-25 21:44:11'),
(10, 12, 9, 'like', '2025-04-25 21:44:13'),
(11, 16, 9, 'like', '2025-04-25 21:44:45'),
(12, 15, 9, 'like', '2025-04-25 21:44:46'),
(13, 14, 9, 'like', '2025-04-25 21:44:53'),
(14, 16, 8, 'like', '2025-04-25 21:45:24'),
(15, 15, 8, 'like', '2025-04-25 21:45:25'),
(16, 18, 9, 'like', '2025-04-25 23:03:33'),
(17, 17, 9, 'like', '2025-04-25 23:03:36'),
(18, 19, 8, 'like', '2025-04-26 10:35:27'),
(25, 18, 8, 'like', '2025-04-26 14:07:21'),
(26, 17, 8, 'like', '2025-04-26 14:07:23'),
(27, 14, 8, 'like', '2025-04-26 14:07:24'),
(28, 12, 8, 'like', '2025-04-26 14:07:26'),
(29, 7, 8, 'like', '2025-04-26 14:07:30'),
(30, 20, 8, 'like', '2025-04-26 14:46:00'),
(31, 21, 8, 'like', '2025-04-26 14:46:03'),
(35, 25, 8, 'like', '2025-04-26 16:51:54'),
(38, 29, 8, 'like', '2025-04-26 21:17:02'),
(39, 28, 8, 'like', '2025-04-26 21:17:03'),
(40, 27, 8, 'like', '2025-04-26 21:28:18'),
(41, 30, 8, 'like', '2025-04-26 22:03:52'),
(42, 30, 11, 'like', '2025-04-29 21:03:21'),
(43, 27, 11, 'like', '2025-04-29 21:03:23'),
(44, 26, 11, 'like', '2025-04-29 21:03:25'),
(45, 19, 11, 'like', '2025-04-29 21:07:20'),
(46, 33, 11, 'like', '2025-04-29 21:10:12'),
(47, 32, 8, 'like', '2025-04-30 00:36:09'),
(48, 26, 8, 'like', '2025-04-30 00:37:12'),
(49, 24, 8, 'like', '2025-04-30 00:37:14'),
(50, 22, 8, 'like', '2025-04-30 00:37:18'),
(53, 34, 12, 'like', '2025-05-01 22:54:17'),
(57, 36, 12, 'like', '2025-05-02 02:19:45'),
(62, 37, 9, 'like', '2025-05-03 00:26:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role` enum('Student','Teacher') NOT NULL DEFAULT 'Student',
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `institute` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `full_name`, `email`, `password`, `institute`, `created_at`, `profile_picture`) VALUES
(1, '', 'Barbie Penafiel', 'Penafiel@dbclm.com', '$2y$10$wSKgVo8RcOFe795rKzF6yejF336i.a0WFDC0UOXmWuiAkdg1yXNuq', 'ITed', '2025-04-23 10:00:35', NULL),
(5, 'Student', 'laiza', 'lai@dbclm.com', '$2y$10$BDRH/DnCZ9dC/5A4cZ6IgeWr2wMauF7bVwh1rC1CydiirSw7zB5cu', 'IC', '2025-04-23 10:25:01', NULL),
(7, 'Student', 'Marjorie Casilao', 'casilao123@dbclm.com', '$2y$10$kThqJnKrluPZNXjhaxehVu6W4060GRdCk4pqMOzrxsOdQJUhAs3NS', 'IC', '2025-04-23 10:36:04', NULL),
(8, 'Student', 'Donameg', 'eran@dbclm.com', '$2y$10$bwbsQ5gXmc28IAl67c1jeeadJk5TE.TXIqxrZ0RFfOKOzuNlYZ2eS', 'ITed', '2025-04-24 06:20:01', 'profile_8_1745674731.jpg'),
(9, 'Student', 'Cheni', 'chenibibs@dbclm.com', '$2y$10$x4kkwBUiMb6MeMqe8tUw0ud/1OQ.s9AsR/lPxEGJ7zNARYaZnnkXu', 'IC', '2025-04-24 14:10:00', 'profile_9_1745674682.png'),
(11, 'Teacher', 'Christian', 'chan@dbclm.com', '$2y$10$X57OfbsvcYL5GPirENdFuee89f1EriiM3PJCux7OfRTe1MmO0GDaK', 'ITed', '2025-04-26 12:57:30', 'marj.jpg'),
(12, 'Teacher', 'Geni', 'geni@dbclm.com', '$2y$10$h3YAb0Z23CgcdaGdy7Wm7ucZ9KLES09pDWvbC/ZDuV8ZtCVeb5R1u', 'IC', '2025-04-29 16:49:19', 'barb.jpg');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO audit_log (action) 
    VALUES (CONCAT('New user created: ', NEW.full_name, ' with email ', NEW.email));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_insert_users` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    -- Check for duplicate email
    IF EXISTS (
        SELECT 1 FROM users WHERE email = NEW.email
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Email already exists.';
    END IF;

    -- Check for duplicate full name
    IF EXISTS (
        SELECT 1 FROM users WHERE full_name = NEW.full_name
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Full name already exists.';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_user_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO user_logs (user_id, action_type, action_details)
    VALUES (NEW.id, 'CREATE', CONCAT('New account created for ', NEW.full_name, ' (', NEW.role, ')'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_after_user_update` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    INSERT INTO user_logs (user_id, action_type, action_details)
    VALUES (NEW.id, 'UPDATE', CONCAT('Account info updated for ', NEW.full_name));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_type` varchar(50) DEFAULT NULL,
  `action_details` text DEFAULT NULL,
  `action_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`log_id`, `user_id`, `action_type`, `action_details`, `action_time`) VALUES
(1, 1, 'CREATE', 'New account created for Barbie Penafiel ()', '2025-04-23 10:00:35'),
(5, 5, 'CREATE', 'New account created for laiza (Student)', '2025-04-23 10:25:01'),
(6, 7, 'CREATE', 'New account created for Marjorie Casilao (Student)', '2025-04-23 10:36:04'),
(7, 8, 'CREATE', 'New account created for Donameg (Student)', '2025-04-24 06:20:01'),
(8, 9, 'CREATE', 'New account created for Cheni (Student)', '2025-04-24 14:10:00'),
(26, 11, 'CREATE', 'New account created for Christian (Teacher)', '2025-04-26 12:57:30'),
(27, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:04:04'),
(28, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:04:04'),
(29, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:10:52'),
(30, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:16:08'),
(31, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:16:12'),
(32, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:16:15'),
(33, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:16:18'),
(34, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:16:23'),
(35, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:16:40'),
(36, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-26 13:19:13'),
(37, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-26 13:19:35'),
(38, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-26 13:19:35'),
(39, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:24:16'),
(40, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:28:10'),
(41, 9, 'UPDATE', 'Account info updated for Cheni', '2025-04-26 13:29:20'),
(42, 9, 'UPDATE', 'Account info updated for Cheni', '2025-04-26 13:30:31'),
(43, 9, 'UPDATE', 'Account info updated for Cheni', '2025-04-26 13:38:02'),
(44, 9, 'UPDATE', 'Account info updated for Cheni', '2025-04-26 13:38:06'),
(45, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:38:51'),
(46, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:42:57'),
(47, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:50:04'),
(48, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:50:11'),
(49, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 13:50:15'),
(50, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 14:14:10'),
(51, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 14:14:22'),
(52, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-26 14:16:27'),
(53, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-29 13:05:41'),
(54, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-29 13:05:49'),
(55, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-29 13:06:08'),
(56, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-29 13:06:16'),
(57, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-29 13:06:23'),
(58, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-29 13:06:31'),
(59, 11, 'UPDATE', 'Account info updated for Christian', '2025-04-29 13:06:42'),
(60, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 14:09:45'),
(61, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 14:09:49'),
(62, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 14:52:53'),
(63, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 15:11:14'),
(64, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:01:26'),
(65, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:01:30'),
(66, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:02:55'),
(67, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:02:56'),
(68, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:42:26'),
(69, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:43:43'),
(70, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:46:00'),
(71, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:46:31'),
(72, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:46:43'),
(73, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:46:45'),
(74, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:46:46'),
(75, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:46:50'),
(76, 8, 'UPDATE', 'Account info updated for Donameg', '2025-04-29 16:46:53'),
(77, 12, 'CREATE', 'New account created for Geni (Teacher)', '2025-04-29 16:49:19'),
(78, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-29 16:49:54'),
(79, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-29 16:49:59'),
(80, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-29 16:50:43'),
(81, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-29 16:50:47'),
(82, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-29 16:51:55'),
(83, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-29 16:51:58'),
(84, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-30 01:23:40'),
(85, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-30 05:53:42'),
(86, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-30 05:53:50'),
(87, 12, 'UPDATE', 'Account info updated for Geni', '2025-04-30 05:53:54'),
(88, 9, 'UPDATE', 'Account info updated for Cheni', '2025-04-30 09:04:49'),
(89, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:58:08'),
(90, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:58:22'),
(91, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:58:30'),
(92, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:58:38'),
(93, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:58:51'),
(94, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:58:55'),
(95, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:04'),
(96, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:08'),
(97, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:20'),
(98, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:29'),
(99, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:33'),
(100, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:39'),
(101, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:45'),
(102, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:48'),
(103, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:51'),
(104, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 14:59:55'),
(105, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 15:00:10'),
(106, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 15:00:17'),
(107, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 15:00:26'),
(108, 12, 'UPDATE', 'Account info updated for Geni', '2025-05-01 15:00:31'),
(109, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:28:45'),
(110, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:28:52'),
(111, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:29:04'),
(112, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:29:13'),
(113, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:29:18'),
(114, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:29:41'),
(115, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:29:45'),
(116, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:29:53'),
(117, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:29:56'),
(118, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:02'),
(119, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:07'),
(120, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:14'),
(121, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:22'),
(122, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:27'),
(123, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:29'),
(124, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:39'),
(125, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:43'),
(126, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:46'),
(127, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:49'),
(128, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:30:54'),
(129, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:31:59'),
(130, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:32:14'),
(131, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:32:18'),
(132, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:32:22'),
(133, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:34:10'),
(134, 8, 'UPDATE', 'Account info updated for Donameg', '2025-05-02 16:34:16');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_profile_view`
-- (See below for the actual view)
--
CREATE TABLE `user_profile_view` (
);

-- --------------------------------------------------------

--
-- Structure for view `user_profile_view`
--
DROP TABLE IF EXISTS `user_profile_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_profile_view`  AS SELECT `a`.`id` AS `id`, `a`.`user_id` AS `user_id`, `a`.`title` AS `title`, `a`.`institute` AS `institute`, `a`.`abstract` AS `abstract`, `a`.`content` AS `content`, `a`.`featured_image` AS `featured_image`, `a`.`allow_comments` AS `allow_comments`, `a`.`is_private` AS `is_private`, `a`.`notify_comments` AS `notify_comments`, `a`.`status` AS `status`, `a`.`created_at` AS `created_at`, `a`.`institute_id` AS `institute_id`, `a`.`author` AS `author`, `a`.`category` AS `category`, `a`.`email` AS `email`, `a`.`created` AS `created`, `a`.`approved` AS `approved`, `a`.`is_draft` AS `is_draft`, `a`.`comments_enabled` AS `comments_enabled`, `a`.`private` AS `private`, `a`.`notifications` AS `notifications`, `a`.`feedback` AS `feedback`, `u`.`profile_picture` AS `profile_picture` FROM (`articles` `a` join `users` `u` on(`a`.`user_id` = `u`.`id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_institute` (`institute_id`);

--
-- Indexes for table `article_logs`
--
ALTER TABLE `article_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_reports`
--
ALTER TABLE `article_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hidden_articles`
--
ALTER TABLE `hidden_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`article_id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_id` (`article_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `full_name` (`full_name`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `article_logs`
--
ALTER TABLE `article_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `article_reports`
--
ALTER TABLE `article_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `hidden_articles`
--
ALTER TABLE `hidden_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_institute` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD CONSTRAINT `user_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
