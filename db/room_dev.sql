-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2016 at 05:29 AM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `room_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `block_domain_dataroom`
--

CREATE TABLE IF NOT EXISTS `block_domain_dataroom` (
  `id` int(10) unsigned NOT NULL,
  `domain` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `dataroom_id` int(11) NOT NULL,
  `history` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `block_projects_domain`
--

CREATE TABLE IF NOT EXISTS `block_projects_domain` (
  `id` int(10) unsigned NOT NULL,
  `domain` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(11) NOT NULL,
  `history` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_role_file`
--

CREATE TABLE IF NOT EXISTS `data_role_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `folderid` int(11) NOT NULL,
  `filename` varchar(355) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` varchar(255) NOT NULL,
  `file_resolution` varchar(255) NOT NULL,
  `title` varchar(50) NOT NULL,
  `alt` varchar(50) NOT NULL,
  `camefrom` enum('direct','search engine') NOT NULL,
  `source` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `folderid` (`folderid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `data_room`
--

CREATE TABLE IF NOT EXISTS `data_room` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `domain_restrict` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `internal_user` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `view_only` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_by` int(11) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=65 ;

--
-- Dumping data for table `data_room`
--

INSERT INTO `data_room` (`id`, `name`, `company`, `photo`, `description`, `domain_restrict`, `internal_user`, `view_only`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(22, 'My dataroom', 'www.dataroom.com', '56ebc142301d7_1458291010.jpg', 'My test', '', '0', '0', '1', 0, '2016-03-18 14:27:15', '2016-03-18 14:27:15'),
(23, 'Singh Data', 'www.singh.com', '56ebcc90d1f6b_1458293904.jpg', 'My test descrioption', '', '0', '0', '1', 0, '2016-03-18 09:38:39', '2016-03-18 09:38:39'),
(25, 'Test Dataroom', 'socialsoftsolutions.com', '56ecf23aec028_1458369082.JPG', 'Test Dataroom', '', '0', '0', '1', 0, '2016-03-19 06:32:06', '2016-03-19 06:32:06'),
(37, 'fgh', '', '', '', '', '0', '0', '1', 17, '2016-04-01 10:13:30', '2016-04-01 10:13:30'),
(38, 'test dataroom second', '', '', '', '', '0', '0', '1', 17, '2016-04-01 10:35:31', '2016-04-01 10:35:31'),
(39, 'Dataroom', '', '', '', '', '0', '0', '1', 17, '2016-04-01 11:22:59', '2016-04-01 11:22:59'),
(40, 'My dataroom test', 'www.test.com', '', 'test', '', '0', '0', '1', 17, '2016-04-01 11:40:26', '2016-04-01 11:40:26'),
(41, 'My datatest', '', '', '', '', '0', '0', '1', 23, '2016-04-01 11:56:46', '2016-04-01 11:56:46'),
(42, 'new test dataroom', '', '', 'Wanting to become a social media marketer? These 6 free online courses will help', '', '0', '0', '1', 17, '2016-04-01 12:17:01', '2016-04-01 12:17:01'),
(43, 'A Datdaroom', '', '', '', '', '0', '0', '1', 23, '2016-04-01 12:20:26', '2016-04-01 12:20:26'),
(44, 'test data', '', '', '', '', '0', '0', '1', 17, '2016-04-01 12:21:48', '2016-04-01 12:21:48'),
(45, 'dataroom1', '', '', 'dataroom1', '', '0', '0', '1', 17, '2016-04-01 12:47:03', '2016-04-01 12:47:03'),
(46, 'dataroom2', '', '', 'dataroom2', '', '0', '0', '1', 17, '2016-04-01 12:48:36', '2016-04-01 12:48:36'),
(47, 'dataroom3', '', '', 'dataroom3', '', '0', '0', '1', 17, '2016-04-01 12:50:16', '2016-04-01 12:50:16'),
(48, 'SASASA', '', '', 'SASASA', '', '0', '0', '1', 1, '2016-04-01 12:51:19', '2016-04-01 12:51:19'),
(49, 'T20 IPL', '', '', 'T20 IPL', '', '0', '0', '1', 1, '2016-04-01 13:00:20', '2016-04-01 13:00:20'),
(50, 'dataroom4', '', '', 'dataroom4', '', '0', '0', '1', 17, '2016-04-01 13:00:23', '2016-04-01 13:00:23'),
(51, 'dataroom5', '', '', 'dataroom5', '', '0', '0', '1', 17, '2016-04-01 13:03:49', '2016-04-01 13:03:49'),
(52, 'hey ram', '', '56fe71a1201de_1459515809.jpg', 'hey ram', '', '0', '0', '1', 1, '2016-04-01 13:04:16', '2016-04-01 13:04:16'),
(53, 'last and final', '', '', 'kapildevsogarwal@gmail.comkapildevsogarwal@gmail.com', '', '0', '0', '1', 1, '2016-04-01 13:08:24', '2016-04-01 13:08:24'),
(54, '30Data Roomassasa', '', '', 'sdfdfgegfvde', '', '0', '0', '1', 1, '2016-04-01 13:12:49', '2016-04-01 13:12:49'),
(55, 'My cricket record', 'www.test.com', '', 'My test cricket record', '', '0', '0', '1', 17, '2016-04-01 15:09:56', '2016-04-01 15:09:56'),
(56, 'Sushant data', 'www.dataroom.com', '', 'my test sushant', '', '0', '0', '1', 17, '2016-04-01 15:14:28', '2016-04-01 15:14:28'),
(57, 'My kapil data', 'www.dataroom.com', '', 'My test data for send mail kapildevsogarwal@gmail.com', '', '0', '0', '1', 17, '2016-04-01 15:16:58', '2016-04-01 15:16:58'),
(58, 'Alistair', '', '', '', '', '0', '0', '1', 25, '2016-04-01 15:43:40', '2016-04-01 15:43:40'),
(59, 'My Project Sushant', 'www.dataroom.com', '', 'My test data room', '', '0', '0', '1', 17, '2016-04-01 15:55:26', '2016-04-01 15:55:26'),
(60, 'Test again', '', '', '', '', '0', '1', '1', 25, '2016-04-01 22:12:46', '2016-04-01 22:12:46'),
(61, 'adpifjasodij', '', '', '', '', '0', '0', '1', 25, '2016-04-01 23:49:53', '2016-04-01 23:49:53'),
(62, 'WorldPoverty', '', '', '', '', '0', '0', '1', 30, '2016-04-02 00:12:55', '2016-04-02 00:12:55'),
(63, 'world peace', '', '', '', '', '0', '0', '1', 25, '2016-04-02 00:20:08', '2016-04-02 00:20:08'),
(64, 'showing lesli', '', '', '', '', '0', '0', '1', 25, '2016-04-02 04:42:36', '2016-04-02 04:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `file_tags`
--

CREATE TABLE IF NOT EXISTS `file_tags` (
  `id` int(10) unsigned NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  `fileid` int(11) NOT NULL,
  `folderid` int(10) unsigned NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folder_relation`
--

CREATE TABLE IF NOT EXISTS `folder_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `role` enum('admin','upload','view','downloded') COLLATE utf8_unicode_ci NOT NULL,
  `dataroom_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `folder_relation_user_id_foreign` (`user_id`),
  KEY `folder_relation_folder_id_foreign` (`folder_id`),
  KEY `folder_relation_dataroom_id_foreign` (`dataroom_id`),
  KEY `folder_relation_project_id_foreign` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `folder_relation`
--

INSERT INTO `folder_relation` (`id`, `folder_id`, `user_id`, `role`, `dataroom_id`, `project_id`, `created_at`, `updated_at`) VALUES
(3, 3, 16, 'admin', 23, 9, '2016-03-18 11:46:30', '2016-03-18 11:46:30'),
(4, 4, 16, 'admin', 23, 9, '2016-03-18 12:15:33', '2016-03-18 12:15:33'),
(5, 5, 1, 'admin', 25, 11, '2016-03-19 06:37:04', '2016-03-19 06:37:04'),
(6, 6, 19, 'admin', 26, 12, '2016-03-28 12:12:30', '2016-03-28 12:12:30'),
(7, 7, 1, 'admin', 27, 13, '2016-03-28 13:13:39', '2016-03-28 13:13:39'),
(8, 8, 1, 'admin', 27, 13, '2016-03-28 13:17:23', '2016-03-28 13:17:23'),
(9, 9, 1, 'admin', 28, 14, '2016-03-29 07:21:07', '2016-03-29 07:21:07'),
(10, 10, 1, 'admin', 28, 14, '2016-03-29 08:25:24', '2016-03-29 08:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `profile_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'header-profile.png',
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `job_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `organization` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `phone_code` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `firstname`, `lastname`, `photo`, `location`, `timezone`, `job_title`, `organization`, `created_at`, `updated_at`, `phone_code`, `phone_number`) VALUES
(1, 1, 'pooran', 'singh', '56fe0b7fdbde5_1459489663.jpg', '', 'America/Barbados', '', '', '2016-03-09 05:54:23', '2016-04-01 05:48:16', NULL, NULL),
(5, 5, 'SUJEET ', 'KUMAR', '', '', 'Asia/Kolkata', '', '', '2016-03-11 09:52:04', '2016-03-11 09:52:04', NULL, NULL),
(6, 6, 'desh', 'raj', '', '', 'Asia/Kolkata', '', '', '2016-03-11 09:52:25', '2016-03-11 09:52:25', NULL, NULL),
(7, 7, 'Anuj', 'Chauhan', '', '', 'Asia/Kolkata', '', '', '2016-03-11 09:53:07', '2016-03-11 09:53:07', NULL, NULL),
(8, 8, 'SUJEET', 'KUMAR', '', '', 'Asia/Kolkata', '', '', '2016-03-11 11:12:37', '2016-03-11 11:12:37', NULL, NULL),
(9, 9, 'pradeep', 'kumar', '', '', 'Asia/Kolkata', '', '', '2016-03-11 11:55:47', '2016-03-11 11:55:47', NULL, NULL),
(10, 10, 'Surendra ', 'Shrivastava', '', '', 'America/Anchorage', '', '', '2016-03-11 12:15:39', '2016-03-11 12:15:39', NULL, NULL),
(11, 11, 'kapil', 'dev', '56ebc85918fd3_1458292825.jpg', '', 'America/Los_Angeles', '', '', '2016-03-14 11:29:44', '2016-03-18 09:20:33', NULL, NULL),
(12, 12, 'Kapil', 'Dev', '', '', 'America/Edmonton', '', '', '2016-03-14 12:31:06', '2016-03-14 12:31:06', NULL, NULL),
(13, 13, 'project', 'nnnn', '', '', 'America/Edmonton', '', '', '2016-03-14 13:46:33', '2016-03-14 13:46:33', NULL, NULL),
(14, 14, 'project', 'nnnn', '', '', 'America/Edmonton', '', '', '2016-03-14 13:53:53', '2016-03-14 13:53:53', NULL, NULL),
(15, 15, 'Rana', 'NBishant', '', '', 'America/Edmonton', '', '', '2016-03-14 14:04:37', '2016-03-14 14:04:37', NULL, NULL),
(16, 16, 'Pooran', 'Singh', '', '', 'America/Barbados', '', '', '2016-03-15 09:26:59', '2016-03-18 10:31:16', NULL, NULL),
(17, 17, 'amit', 'kumar', '56fe647d30567_1459512445.jpg', '', 'America/Barbados', '', '', '2016-03-18 04:15:07', '2016-04-01 12:07:27', NULL, NULL),
(18, 18, 'Sushant', 'Bhardwaj', 'header-profile.png', '', 'Asia/Kolkata', '', '', '2016-03-19 06:53:50', '2016-03-19 06:53:50', NULL, NULL),
(19, 19, 'Pankaj', 'Jha', '56f91f2359ecd_1459167011.png', '', 'America/Barbados', '', '', '2016-03-28 08:55:54', '2016-03-28 12:10:14', NULL, NULL),
(20, 20, 'keshav', 't', 'header-profile.png', '', 'Asia/Kolkata', '', '', '2016-03-28 10:52:57', '2016-03-28 10:52:57', NULL, NULL),
(21, 21, 'jmghkjtnu', 'yhgyunt', 'header-profile.png', '', 'Asia/Kolkata', '', '', '2016-03-28 12:14:39', '2016-03-28 12:14:39', NULL, NULL),
(22, 22, 'Sumit', 'Krrish', 'header-profile.png', '', 'Asia/Kolkata', '', '', '2016-03-30 04:23:30', '2016-03-30 04:23:30', NULL, NULL),
(23, 23, 'Sus', 'Pan', 'header-profile.png', '', 'Asia/Kolkata', '', 'Pk', '2016-04-01 11:28:59', '2016-04-01 11:28:59', '011', '9958486037'),
(24, 24, 'my test', 'test', 'header-profile.png', '', 'Asia/Kolkata', '', 'sss', '2016-04-01 11:44:50', '2016-04-01 11:44:50', '98', '4115415152'),
(25, 26, 'SURENDRA', 'SRIVASTAVA', '56fe6a60e4c3c_1459513952.jpg', '', 'America/Barbados', '', 'SOCIAL SOFT SOLUTIONS', '2016-04-01 12:22:23', '2016-04-01 12:32:36', '0120', '4542818'),
(26, 25, 'Alistair', 'Ritchie', '56ff4ea912771_1459572393.jpg', '', 'America/Barbados', '', '', '2016-04-01 15:40:42', '2016-04-02 04:46:34', '', ''),
(27, 30, 'dinesh', 'srivastava', 'header-profile.png', '', 'Asia/Kolkata', '', 'ravabe', '2016-04-01 23:54:59', '2016-04-01 23:54:59', '91', '2334567');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_room_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `domain_restrict` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `internal_user` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `view_only` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `updateby` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `data_room_id`, `name`, `company`, `photo`, `description`, `domain_restrict`, `internal_user`, `view_only`, `created_by`, `updateby`, `status`, `created_at`, `updated_at`) VALUES
(1, 39, 'Project1', '', '', '', '', '0', '0', 23, 0, '1', '2016-04-01 11:40:40', '2016-04-01 11:40:40'),
(2, 39, 'Project2', '', '', '', '', '0', '0', 23, 0, '1', '2016-04-01 11:41:45', '2016-04-01 11:41:45'),
(3, 40, 'My new ss Project', 'www.test.com', '', 'My test description', '', '0', '0', 17, 0, '1', '2016-04-01 11:50:15', '2016-04-01 11:50:15'),
(4, 43, 'A Company Project', '', '', '', '', '0', '0', 23, 0, '1', '2016-04-01 12:31:15', '2016-04-01 12:31:15'),
(5, 43, 'Folder Test', '', '', '', '', '0', '0', 23, 0, '1', '2016-04-01 12:32:46', '2016-04-01 12:32:46'),
(6, 23, 'My Test add', 'www.test.com', '', 'My test test', '', '0', '0', 17, 0, '1', '2016-04-01 14:06:21', '2016-04-01 14:06:21'),
(7, 41, 'My Test Project', '', '', 'My datatest', '', '0', '0', 17, 0, '1', '2016-04-01 14:27:33', '2016-04-01 14:27:33'),
(8, 38, 'kapil dev project', 'www.test.com', '', 'mny test', '', '0', '0', 17, 0, '1', '2016-04-01 14:29:00', '2016-04-01 14:29:00'),
(9, 59, 'My data Project', 'www.test.com', '', 'test it with data', '', '0', '0', 17, 0, '1', '2016-04-01 16:24:58', '2016-04-01 16:24:58'),
(10, 43, 'kapil add data', 'www.test.com', '', 'My project test', '', '0', '0', 17, 0, '1', '2016-04-01 17:11:45', '2016-04-01 17:11:45'),
(11, 43, 'data2', 'www.test.com', '', 'test 2', '', '0', '0', 17, 0, '1', '2016-04-01 17:15:38', '2016-04-01 17:15:38'),
(12, 49, 'Create', '', '', 'Test', '', '0', '0', 25, 0, '1', '2016-04-01 22:10:46', '2016-04-01 22:10:46'),
(13, 60, 'test for dinesh', '', '', '', '', '0', '0', 25, 0, '1', '2016-04-01 23:59:51', '2016-04-01 23:59:51'),
(14, 60, 'the 2nd test for dinesh', '', '', '', '', '0', '0', 25, 0, '1', '2016-04-02 00:06:31', '2016-04-02 00:06:31'),
(15, 60, 'WorldHunger', '', '', '', '', '0', '0', 30, 0, '1', '2016-04-02 00:08:49', '2016-04-02 00:08:49'),
(16, 62, 'Alistair want to solve world peace as well', '', '', '', '', '0', '0', 25, 0, '1', '2016-04-02 00:13:35', '2016-04-02 00:13:35'),
(17, 62, 'PovertyBeGone', '', '', '', '', '0', '0', 30, 0, '1', '2016-04-02 00:13:36', '2016-04-02 00:13:36'),
(18, 61, 'worldpeace', '', '', '', '', '0', '0', 25, 0, '1', '2016-04-02 00:19:44', '2016-04-02 00:19:44'),
(19, 63, 'the world is a calmer place with hierarchy', '', '', '', '', '0', '0', 25, 0, '1', '2016-04-02 00:20:33', '2016-04-02 00:20:33'),
(20, 64, 'showing lesli', '', '', '', '', '0', '0', 25, 0, '1', '2016-04-02 04:43:19', '2016-04-02 04:43:19'),
(21, 64, 'and a different project', '', '', '', '', '0', '0', 25, 0, '1', '2016-04-02 04:43:54', '2016-04-02 04:43:54');

-- --------------------------------------------------------

--
-- Table structure for table `projects_old`
--

CREATE TABLE IF NOT EXISTS `projects_old` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `updateby` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `projects_old`
--

INSERT INTO `projects_old` (`id`, `name`, `company`, `photo`, `description`, `updateby`, `status`, `created_at`, `updated_at`) VALUES
(6, 'My Project', NULL, NULL, NULL, 1, '1', '2016-03-18 09:01:30', '2016-03-18 09:01:30'),
(7, 'My second project', NULL, NULL, NULL, 1, '1', '2016-03-18 09:03:59', '2016-03-18 09:03:59'),
(8, 'pk', NULL, NULL, NULL, 9, '1', '2016-03-18 00:00:00', '2016-03-18 00:00:00'),
(9, 'My project', NULL, NULL, NULL, 16, '1', '2016-03-18 11:11:10', '2016-03-18 11:11:10'),
(10, 'project test', '', '', 'dest ', 9, '1', '2016-03-18 00:00:00', '2016-03-18 00:00:00'),
(11, 'Test Project', 'socialsoftsol.com', '', 'Test Project', 1, '1', '2016-03-19 00:00:00', '2016-03-19 00:00:00'),
(12, 'test pro', '', '56f91f87e666a_1459167111.png', 'cxdfgdxc', 19, '1', '2016-03-28 00:00:00', '2016-03-28 00:00:00'),
(13, 'this UE is wrong - maybe', '', '', '', 1, '1', '2016-03-28 00:00:00', '2016-03-28 00:00:00'),
(14, 'project 1', '', '', 'test', 1, '1', '2016-03-29 00:00:00', '2016-03-29 00:00:00'),
(15, 'manika', 'http://www.rvabe.com', '56fa3d262c527_1459240230.png', '', 1, '1', '2016-03-29 00:00:00', '2016-03-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_folder`
--

CREATE TABLE IF NOT EXISTS `project_folder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `folder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=60 ;

--
-- Dumping data for table `project_folder`
--

INSERT INTO `project_folder` (`id`, `folder_name`, `parent_id`, `created_at`, `updated_at`, `created_by`, `project_id`, `alias`) VALUES
(9, 'Parent1', 0, '2016-04-01 10:21:00', '2016-04-01 10:21:21', 17, 6, 'Parent1'),
(10, 'Child1', 9, '2016-04-01 10:21:29', '2016-04-01 10:21:29', 17, 6, 'Child1'),
(11, 'Child2', 10, '2016-04-01 10:21:40', '2016-04-01 10:21:40', 17, 6, 'Child2'),
(12, 'Child3', 11, '2016-04-01 10:21:48', '2016-04-01 10:21:48', 17, 6, 'Child3'),
(13, 'Child4', 12, '2016-04-01 10:22:00', '2016-04-01 10:22:00', 17, 6, 'Child4'),
(14, 'Child5', 13, '2016-04-01 10:22:13', '2016-04-01 10:22:13', 17, 6, 'Child5'),
(15, 'Child4', 11, '2016-04-01 10:22:27', '2016-04-01 10:22:27', 17, 6, 'Child4'),
(18, 'Parent1', 0, '2016-04-01 11:43:44', '2016-04-01 11:43:44', 23, 1, 'Parent1'),
(20, 'TEST1', 18, '2016-04-01 12:29:17', '2016-04-01 12:29:17', 26, 1, 'TEST1'),
(21, 'PARENT2', 0, '2016-04-01 12:29:53', '2016-04-01 12:29:53', 26, 1, 'PARENT2'),
(22, 'Parent', 0, '2016-04-01 12:31:30', '2016-04-01 12:31:30', 23, 4, 'Parent'),
(23, 'Child', 22, '2016-04-01 12:31:38', '2016-04-01 12:31:38', 23, 4, 'Child'),
(24, 'Child2', 23, '2016-04-01 12:31:47', '2016-04-01 12:31:47', 23, 4, 'Child2'),
(25, 'Parent', 0, '2016-04-01 12:33:13', '2016-04-01 12:33:13', 23, 5, 'Parent'),
(26, 'Root', 0, '2016-04-01 12:33:18', '2016-04-01 12:33:18', 23, 5, 'Root'),
(27, 'Test_Folder', 0, '2016-04-01 12:33:26', '2016-04-01 12:33:26', 23, 5, 'Test Folder'),
(28, 'Child', 25, '2016-04-01 12:33:33', '2016-04-01 12:33:33', 23, 5, 'Child'),
(29, 'Child1', 28, '2016-04-01 12:33:41', '2016-04-01 12:33:41', 23, 5, 'Child1'),
(30, 'Child_Root', 26, '2016-04-01 12:33:50', '2016-04-01 12:33:50', 23, 5, 'Child Root'),
(31, 'Chiuld_Test', 27, '2016-04-01 12:34:00', '2016-04-01 12:34:00', 23, 5, 'Chiuld Test'),
(32, 'Child_Test', 0, '2016-04-01 12:34:38', '2016-04-01 12:34:38', 23, 5, 'Child Test'),
(33, 'Alistair', 0, '2016-04-01 23:47:27', '2016-04-01 23:47:27', 25, 9, 'Alistair'),
(34, 'alir123', 0, '2016-04-01 23:47:45', '2016-04-01 23:47:45', 25, 9, 'alir123'),
(35, 'lihjo', 33, '2016-04-01 23:48:14', '2016-04-01 23:48:14', 25, 9, 'lihjo'),
(36, 'for_dinesh', 0, '2016-04-02 00:02:41', '2016-04-02 00:02:41', 25, 13, 'for dinesh'),
(37, 'dinesh_2', 0, '2016-04-02 00:02:50', '2016-04-02 00:02:50', 25, 13, 'dinesh 2'),
(38, 'level_1', 36, '2016-04-02 00:03:05', '2016-04-02 00:03:05', 25, 13, 'level 1'),
(39, 'level_3', 38, '2016-04-02 00:03:18', '2016-04-02 00:03:18', 25, 13, 'level 3'),
(40, 'level_2', 0, '2016-04-02 00:03:32', '2016-04-02 00:03:32', 25, 13, 'level 2'),
(41, 'level_2', 38, '2016-04-02 00:03:45', '2016-04-02 00:03:45', 25, 13, 'level 2'),
(42, 'level_4', 38, '2016-04-02 00:03:58', '2016-04-02 00:03:58', 25, 13, 'level 4'),
(43, 'level_5', 41, '2016-04-02 00:04:12', '2016-04-02 00:04:12', 25, 13, 'level 5'),
(44, '1_more_time', 39, '2016-04-02 00:05:28', '2016-04-02 00:05:28', 25, 13, '1 more time'),
(45, 'big_al_was_here', 0, '2016-04-02 00:09:13', '2016-04-02 00:09:13', 25, 15, 'big al was here'),
(46, 'here_we_go', 0, '2016-04-02 00:17:21', '2016-04-02 00:17:21', 25, 17, 'here we go'),
(47, 'HailMary', 0, '2016-04-02 00:19:05', '2016-04-02 00:19:05', 30, 17, 'HailMary'),
(48, 'HelloHailMary', 0, '2016-04-02 00:19:39', '2016-04-02 00:19:39', 30, 16, 'HelloHailMary'),
(49, 'New_Challenges', 0, '2016-04-02 00:22:22', '2016-04-02 00:22:22', 30, 19, 'New Challenges'),
(50, 'are_always_cool', 49, '2016-04-02 00:22:51', '2016-04-02 00:22:51', 25, 19, 'are always cool'),
(51, 'so_be_it', 49, '2016-04-02 00:23:08', '2016-04-02 00:23:08', 30, 19, 'so be it'),
(52, 'try_again', 50, '2016-04-02 00:23:15', '2016-04-02 00:23:15', 25, 19, 'try again'),
(53, 'and_one_more_time', 52, '2016-04-02 00:23:27', '2016-04-02 00:23:27', 25, 19, 'and one more time'),
(54, 'and_one_more', 53, '2016-04-02 00:23:55', '2016-04-02 00:23:55', 25, 19, 'and one more'),
(55, 'how_the_folders_work', 0, '2016-04-02 04:44:10', '2016-04-02 04:44:10', 25, 21, 'how the folders work'),
(56, 'and_there_is_more', 55, '2016-04-02 04:44:20', '2016-04-02 04:44:20', 25, 21, 'and there is more'),
(57, 'and_more', 56, '2016-04-02 04:44:30', '2016-04-02 04:44:30', 25, 21, 'and more'),
(58, 'see_how_it_works', 0, '2016-04-02 04:44:50', '2016-04-02 04:44:50', 25, 20, 'see how it works'),
(59, 'and_more_and_more', 0, '2016-04-02 04:49:44', '2016-04-02 04:49:44', 25, 21, 'and more and more');

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `attempts` int(11) NOT NULL,
  `suspended` tinyint(4) NOT NULL,
  `banned` tinyint(4) NOT NULL,
  `last_attempt_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `suspended_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `created_at`, `updated_at`) VALUES
(3, 1, '119.82.68.210', 0, 0, 0, '2016-04-04 04:23:45', '2016-04-04 04:23:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 6, '119.82.68.210', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 5, '119.82.68.210', 0, 0, 0, '2016-03-11 09:54:57', '2016-03-11 09:54:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 7, '122.177.124.3', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 8, '119.82.68.210', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, '122.177.124.3', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 10, '122.177.124.3', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 7, '119.82.68.210', 5, 1, 0, '2016-03-14 12:30:02', '2016-03-14 12:30:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 9, '119.82.68.210', 0, 0, 0, '2016-03-14 07:23:44', '2016-03-14 07:23:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 12, '119.82.68.210', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 11, '119.82.68.210', 0, 0, 0, '2016-03-18 09:17:03', '2016-03-18 09:17:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 16, '119.82.68.210', 1, 0, 0, '2016-03-18 12:47:33', '2016-03-18 09:37:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 17, '122.173.85.13', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 1, '122.173.85.13', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 18, '122.173.85.13', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 19, '122.177.106.135', 0, 0, 0, '2016-03-29 10:13:49', '2016-03-28 10:55:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 19, '119.82.68.210', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 20, '122.177.106.135', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 1, '101.228.17.148', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 1, '122.177.106.135', 1, 0, 0, '2016-04-01 08:30:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 22, '119.82.68.210', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 17, '122.177.106.135', 0, 0, 0, '2016-04-01 04:56:24', '2016-04-01 04:56:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 17, '119.82.68.210', 0, 0, 0, '2016-04-01 12:28:29', '2016-04-01 11:48:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 7, '122.177.106.135', 0, 0, 0, '2016-04-01 05:39:45', '2016-04-01 05:39:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 23, '122.177.106.135', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 24, '119.82.68.210', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 26, '122.177.106.135', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 25, '45.55.17.6', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 18, '119.82.68.210', 0, 0, 0, '2016-04-01 17:17:58', '2016-04-01 17:17:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 25, '119.82.68.210', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 26, '122.177.146.83', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 25, '69.172.210.33', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 30, '172.58.32.17', 0, 0, 0, '2016-04-01 23:58:20', '2016-04-01 23:58:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 30, '66.234.206.224', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 17, '122.177.18.245', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `source` enum('internel','external') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'internel',
  `bring_by` int(11) NOT NULL,
  `photo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_time` tinyint(1) NOT NULL DEFAULT '1',
  `last_known_location` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` enum('admin','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=32 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `source`, `bring_by`, `photo`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `login_time`, `last_known_location`, `usertype`, `created_at`, `updated_at`) VALUES
(1, 'pooran@ravabe.com', '$2y$10$njjC3Q80JUaqqeXSRVGj1.VmmSU80JnH6lzNDw8/dZgXJNMvlPZwC', NULL, 1, 'iahP2VAbJipb2eHkyq7bZW1pl7R6e2NOAgjR1yg5i1', NULL, 'internel', 0, '', '2016-04-04 05:22:50', '$2y$10$gVcIofcpx9l0Lk69tu3iS.9pzQi1prJLqfGGXM5YQQJoAO7A7jKy2', NULL, NULL, NULL, 1, '', 'admin', '2016-03-09 00:24:23', '2016-04-04 05:22:50'),
(5, 'sujeetkumarmails@gmail.com', '$2y$10$vni.lGyCnR2WHFfihdOImuz9V/S0CrRMLZI2exzgc4lUdjcb4SemG', NULL, 1, 'pk1FRwwJLmGcE2aSQgOvJ4pvollIVgIq7fLZvCWJwv', NULL, 'internel', 0, '', '2016-03-18 05:37:41', '$2y$10$ThPeuCWYE15tj.oY5ndt8.t2S2XRHkF..w7TB/09MAZkMzTE.pk8i', NULL, NULL, NULL, 1, '', 'user', '2016-03-11 09:52:04', '2016-03-18 05:37:41'),
(6, 'deshraj@ravabe.com', '$2y$10$O8bHSkXhs26TOb3FXAdnn.LzlIuBNfHc2B3EbZvtvs34w.tOiPKii', NULL, 1, '8RA8Sour37RTZ66QjwLiBA5EMtwb9FejHmUQnr2HQr', NULL, 'internel', 0, '', '2016-03-11 09:52:49', '$2y$10$2pONCuGYjOsqx7/n7At95ewqwen1ioqdc9KGlVgV1vqB4MHIjcy9S', NULL, NULL, NULL, 1, '', 'user', '2016-03-11 09:52:25', '2016-03-11 09:52:49'),
(7, 'anuj@ravabe.com', '$2y$10$hv4AIa6fVf2uLHmmhB45Z.i070sway3GEWZ/VpOsmUG6KYjiFzDXG', NULL, 1, 'lNYSlbzcPmmcvwOEMUxywlWVsDBloHcDTOhXVsgO2T', NULL, 'internel', 0, '', '2016-04-01 05:39:45', '$2y$10$MvtNnAoTTWxZjQPc.uryc.UBArZI.eDQf2ag06mY4/567qHpqDdRK', NULL, NULL, NULL, 1, '', 'user', '2016-03-11 09:53:07', '2016-04-01 05:39:45'),
(8, 'sujit@ravabe.com', '$2y$10$JST9oliGGV/80E.SPK9ASOFm9jTxWUf2XwaJ5fWCpWBddg4fO85U.', NULL, 1, 'vcosbjU7JBT2TY3h4q1ev0OoNT40m7QiflvyI5jl6O', NULL, 'internel', 0, '', '2016-03-14 10:15:26', '$2y$10$aMEr3iUZnF661yapRkPQ3.8FpDburaemQxdRoNWwEqybcy8fVK5ya', NULL, NULL, NULL, 1, '', 'user', '2016-03-11 11:12:37', '2016-03-14 10:15:26'),
(9, 'pradeep@ravabe.com', '$2y$10$RuSXFL3BgMkditrmpW3sYe1os14FPlOeNj4h/0trh5uqpwoDTzwG6', NULL, 1, 'KAuFmjC1z5DzvCEkDbY9wQaVNbEgnjX5lK5VCN5XWF', NULL, 'internel', 0, '', '2016-03-18 06:07:51', '$2y$10$ho0o/iQYP2N1YfgJa/tv/O4vj/bGEB7XnVfI2e.9ETJbxx4bFJj8y', NULL, NULL, NULL, 1, '', 'user', '2016-03-11 11:55:47', '2016-03-18 06:07:51'),
(10, 'nnsk@ravabe.com', '$2y$10$c6Tb5wGcjz5BGKCNcXiKYelGvAecU4XA0CVk.fxH.xXlA6Dt5qubC', NULL, 1, '9LOU4PKDlDSlDo9CnSgmkfPcbUH8NsAgStITs1cb5d', NULL, 'internel', 0, '', '2016-03-11 12:16:11', '$2y$10$KrUGc7uAaHPafUXcVqxyZe/MkYdkhsKoqbDpjudTLatUEyzw/ZR1G', NULL, NULL, NULL, 1, '', 'user', '2016-03-11 12:15:39', '2016-03-11 12:16:11'),
(11, 'kapil@ravabe.com', '$2y$10$6097cbFCdqTa2SowdWNpuOduZJvvizettXttgjuLNs0Pmgq2ErfjK', NULL, 1, 'uiVrMHoUeilq7Xf6Iif93sWXfw149qJ0Ec5HIIZKkc', NULL, 'internel', 0, '', '2016-03-18 10:02:49', '$2y$10$T4L1r5fIrg5OM0jteda5puhDvAiKJQPFqY1cMFg5VojjMFgARgCcW', NULL, NULL, NULL, 1, '', 'user', '2016-03-14 11:29:44', '2016-03-18 10:02:49'),
(12, 'ravebe2@gmail.com', '$2y$10$mdeoZIHDrT3jAZg4vpGzs.0Q/haLBX3cdbDJ3lDUQcC3JAg4rJ4Ja', NULL, 1, NULL, NULL, 'external', 0, '', '2016-03-14 12:36:32', '$2y$10$bHe7EDUvc14xp5iTXSfAQeE41Vkwmx6bVMnDIK5eYOn6YeVA.b7LC', NULL, NULL, NULL, 1, '', 'user', '2016-03-14 00:00:00', '2016-03-14 12:36:32'),
(13, 'pradeepsre95@gmail.com', '$2y$10$mdeoZIHDrT3jAZg4vpGzs.0Q/haLBX3cdbDJ3lDUQcC3JAg4rJ4Ja', NULL, 0, NULL, NULL, 'external', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'user', '2016-03-14 00:00:00', '2016-03-14 00:00:00'),
(14, 'ravabe3@gmail.com', '$2y$10$mdeoZIHDrT3jAZg4vpGzs.0Q/haLBX3cdbDJ3lDUQcC3JAg4rJ4Ja', NULL, 1, NULL, NULL, 'external', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'user', '2016-03-14 00:00:00', '2016-03-14 13:54:33'),
(15, 'ravabe4@gmail.com', '$2y$10$mdeoZIHDrT3jAZg4vpGzs.0Q/haLBX3cdbDJ3lDUQcC3JAg4rJ4Ja', NULL, 1, NULL, NULL, 'external', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'user', '2016-03-14 00:00:00', '2016-03-14 14:08:23'),
(16, 'singh.pooran@gmail.com', '$2y$10$6097cbFCdqTa2SowdWNpuOduZJvvizettXttgjuLNs0Pmgq2ErfjK', NULL, 1, NULL, NULL, 'external', 0, '', '2016-03-18 09:37:50', '$2y$10$7xO10dJ/rkCpbf6cZ1N4MeHghVZm/sFglbmc0ghTb8UXR5N9JOGjW', NULL, NULL, NULL, 1, '', 'user', '2016-03-15 00:00:00', '2016-03-18 09:37:50'),
(17, 'amit@ravabe.com', '$2y$10$lUiN5q36hEcaExrk0XB7P.l53p9IWRA756mFjpgQrl0A//lCEFI6m', NULL, 1, 'ItwTYI9oZyzYWt2b12n8suYFgkOQTBy6MbmOaiYNbu', NULL, 'internel', 0, '', '2016-04-04 04:11:25', '$2y$10$7cklcbU/2DdDQ3AC1FqqnOAK14ND15Q/zgx5wDe7dqLtxgC.j7ra6', NULL, NULL, NULL, 1, '', 'admin', '2016-03-18 04:15:07', '2016-04-04 04:11:25'),
(18, 'kapildevsogarwal@gmail.com', '$2y$10$lUiN5q36hEcaExrk0XB7P.l53p9IWRA756mFjpgQrl0A//lCEFI6m', NULL, 1, 'R9pO934hEwfp5pbepfq41jczSqnc5lSXXgRK0K8JS3', NULL, 'internel', 0, '', '2016-04-01 17:23:45', '$2y$10$SFnlV6kCHRWKvlLcfaN1E.VFohyLyFNAzd9j4NZaymDhAXmHJiGY.', NULL, NULL, NULL, 1, '', 'user', '2016-03-19 06:53:50', '2016-04-01 17:23:45'),
(19, 'pankaj@ravabe.com', '$2y$10$CTtlpb.v2AnmtvdfWz1Boelcia1VFz4afjoGwBlZ.Qwr2AQrkjZ06', NULL, 1, 'wmUtdOal88irndhltd7XQF4lWqYdvAtv5Pev5zvzh7', NULL, 'internel', 0, '', '2016-03-30 08:37:57', '$2y$10$550G/GAwOa3INdaQceo87e7QTzWIG87JHA6AKvLkGuaIGoLXoYSSa', NULL, NULL, NULL, 1, '', 'user', '2016-03-28 08:55:54', '2016-03-30 08:37:57'),
(20, 'keshav@ravabe.com', '$2y$10$Hyn9pfTkG2inNIn75J.EFOMOeWyKVx33wsHuDxS9YOfNNaUSrg4Z2', NULL, 0, 'UutqS2vpbeOrcXSYYpLo1EobJZ48y8vxgEvdpmXojp', NULL, 'internel', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'user', '2016-03-28 10:52:57', '2016-03-28 10:52:57'),
(21, 'pop@pop.cpop', '$2y$10$xOJ6sJknQr1jLKzDydOGeeYLcqStdoofz6NaAu3xXrix53No6tWeq', NULL, 0, 'Z2vj87dsQhwuvtoY9mMQI1m3U2pggxzoPSxLql9vXE', NULL, 'internel', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'user', '2016-03-28 12:14:39', '2016-03-28 12:14:39'),
(22, 'sumit@ravabe.com', '$2y$10$BU5pXFEhzBlJUL3csaEjKO6tt8l6Nq/r8jevsD0FJ6OdAmnHHfI62', NULL, 1, 'uBBynWkuS5nA9qMdiAcYlxJYJR9an1sxvcyOGlpyx3', NULL, 'internel', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'user', '2016-03-30 04:23:30', '2016-03-30 04:56:59'),
(23, 'jhapankaj4u@gmail.com', '$2y$10$5HnQQONqzrIJBk8S7o05sO341KKLKwOvmuBNNZ8HDyjQn1mrOs77O', NULL, 1, '4J0g9mh6lHwklZl', NULL, 'external', 0, '', '2016-04-01 11:55:54', '$2y$10$PZwEXtynZAdRUX5qRqyoauKRpb3AllJnBXAJMxzab2fyglqU1bmHe', NULL, NULL, NULL, 1, '', 'admin', '2016-04-01 00:00:00', '2016-04-01 11:55:54'),
(24, 'ravabetest1@gmail.com', '$2y$10$9gvuToAzDMHo0sBup4Pvxe5VVcKmuXq1TMxfN0UKZGFAnuXSsMx9W', NULL, 1, 'rtLsB1DdeHcd76B', NULL, 'external', 0, '', '2016-04-01 11:45:10', '$2y$10$FeIwaybuGvTQfOnl8G58zu90o5qsfIyyFepAG/f2cFN2eDGO0XfUC', NULL, NULL, NULL, 1, '', 'user', '2016-04-01 00:00:00', '2016-04-01 11:45:10'),
(25, 'alritchie@ravabe.com', '$2y$10$OfUR6TVRGnSAuxU6y2du2u/hiPyDF52wdV2.TtnuP9QX8EsDvxJVm', NULL, 1, 'PPr8siESnfouG2k', NULL, 'internel', 0, '', '2016-04-01 23:46:29', '$2y$10$.WkLqrMC/81LxbprPOFXMOWljDwyTsy532U.oc5h7uAp4Nn2kmPAa', NULL, NULL, NULL, 1, '', 'admin', '2016-04-01 00:00:00', '2016-04-01 23:46:29'),
(26, 'sk@ravabe.com', '$2y$10$yI73ypkVddkL084V.53M0unuFCAl48nUy11WognKuqqCWhkFJINNO', NULL, 1, 'ykRuzfwfvvJW8Fd', NULL, 'external', 0, '', '2016-04-01 17:32:49', '$2y$10$Ou30XYU40MSmDB6hPb4niuMEBonB16vuqzq7nHv6/7NdfJRVLAOuK', NULL, NULL, NULL, 1, '', 'admin', '2016-04-01 00:00:00', '2016-04-01 17:32:49'),
(27, 'abhinavumang18@gmail.com', '', NULL, 0, 'Az2CwQI2nPxFhgo', NULL, 'external', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'admin', '2016-04-01 00:00:00', '2016-04-01 00:00:00'),
(28, 'abhinavumang18@gmail.com', '', NULL, 0, 'Ik0uKgKxSMXuH6J', NULL, 'external', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'admin', '2016-04-01 00:00:00', '2016-04-01 00:00:00'),
(29, 'kapildevsogarwal@gmail.com', '', NULL, 0, 'JbZjgUN1uLrEbAJ', NULL, 'external', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'admin', '2016-04-01 00:00:00', '2016-04-01 00:00:00'),
(30, 'dxs@ravabe.com', '$2y$10$k/Zw0PBlKmG5IPjbFi2jmejzsHrYEQyDqYGRnW.IbwiwD3/YnML8S', NULL, 1, 'nNLZQiYp85423jR', NULL, 'external', 0, '', '2016-04-02 00:17:06', '$2y$10$g0mQBAD1jxAXeBNcygKa1euhIsg6s/bjZqgItwijZDqq0tksSx2Qu', NULL, NULL, NULL, 1, '', 'admin', '2016-04-01 00:00:00', '2016-04-02 00:17:06'),
(31, 'lesli.ligorner@gmail.com', '', NULL, 0, 'dXrTkoqPizIimGd', NULL, 'external', 0, '', NULL, NULL, NULL, NULL, NULL, 1, '', 'user', '2016-04-02 00:00:00', '2016-04-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_dataroom`
--

CREATE TABLE IF NOT EXISTS `user_dataroom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `data_room_id` int(10) unsigned NOT NULL,
  `role` enum('admin','view','downlod','upload') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'view',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_dataroom_user_id_foreign` (`user_id`),
  KEY `user_dataroom_data_room_id_foreign` (`data_room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=97 ;

--
-- Dumping data for table `user_dataroom`
--

INSERT INTO `user_dataroom` (`id`, `user_id`, `data_room_id`, `role`, `created_at`, `updated_at`) VALUES
(39, 1, 22, 'admin', '2016-03-18 14:27:15', '2016-03-18 14:27:15'),
(40, 11, 22, 'view', '2016-03-18 14:27:15', '2016-03-18 14:27:15'),
(41, 1, 22, 'view', '2016-03-18 14:27:15', '2016-03-18 14:27:15'),
(42, 16, 23, 'admin', '2016-03-18 09:38:39', '2016-03-18 09:38:39'),
(43, 11, 23, 'view', '2016-03-18 09:38:39', '2016-03-18 09:38:39'),
(44, 9, 24, 'admin', '2016-03-18 10:19:30', '2016-03-18 10:19:30'),
(45, 11, 24, 'view', '2016-03-18 10:19:30', '2016-03-18 10:19:30'),
(46, 1, 25, 'admin', '2016-03-19 06:32:06', '2016-03-19 06:32:06'),
(47, 19, 26, 'admin', '2016-03-28 12:11:22', '2016-03-28 12:11:22'),
(48, 1, 27, 'admin', '2016-03-28 13:09:31', '2016-03-28 13:09:31'),
(49, 1, 28, 'admin', '2016-03-29 07:11:05', '2016-03-29 07:11:05'),
(50, 1, 29, 'admin', '2016-03-29 08:18:00', '2016-03-29 08:18:00'),
(51, 1, 30, 'admin', '2016-03-29 08:24:11', '2016-03-29 08:24:11'),
(52, 1, 31, 'admin', '2016-04-01 06:11:03', '2016-04-01 06:11:03'),
(53, 1, 32, 'admin', '2016-04-01 06:12:19', '2016-04-01 06:12:19'),
(54, 0, 32, 'view', '2016-04-01 06:12:19', '2016-04-01 06:12:19'),
(55, 1, 33, 'admin', '2016-04-01 06:16:55', '2016-04-01 06:16:55'),
(56, 1, 34, 'admin', '2016-04-01 06:17:17', '2016-04-01 06:17:17'),
(57, 1, 35, 'admin', '2016-04-01 06:21:18', '2016-04-01 06:21:18'),
(58, 1, 36, 'admin', '2016-04-01 06:21:56', '2016-04-01 06:21:56'),
(59, 17, 37, 'admin', '2016-04-01 10:13:30', '2016-04-01 10:13:30'),
(60, 17, 38, 'admin', '2016-04-01 10:35:31', '2016-04-01 10:35:31'),
(61, 17, 39, 'admin', '2016-04-01 11:22:59', '2016-04-01 11:22:59'),
(62, 23, 39, 'admin', '2016-04-01 11:22:59', '2016-04-01 11:22:59'),
(63, 17, 40, 'admin', '2016-04-01 11:40:26', '2016-04-01 11:40:26'),
(64, 24, 40, 'view', '2016-04-01 11:40:26', '2016-04-01 11:40:26'),
(65, 23, 41, 'admin', '2016-04-01 11:56:46', '2016-04-01 11:56:46'),
(66, 17, 42, 'admin', '2016-04-01 12:17:01', '2016-04-01 12:17:01'),
(67, 23, 43, 'admin', '2016-04-01 12:20:26', '2016-04-01 12:20:26'),
(68, 25, 43, 'view', '2016-04-01 12:20:26', '2016-04-01 12:20:26'),
(69, 26, 43, 'view', '2016-04-01 12:20:28', '2016-04-01 12:20:28'),
(70, 17, 44, 'admin', '2016-04-01 12:21:48', '2016-04-01 12:21:48'),
(71, 17, 45, 'admin', '2016-04-01 12:47:03', '2016-04-01 12:47:03'),
(72, 17, 46, 'admin', '2016-04-01 12:48:36', '2016-04-01 12:48:36'),
(73, 17, 47, 'admin', '2016-04-01 12:50:16', '2016-04-01 12:50:16'),
(74, 1, 48, 'admin', '2016-04-01 12:51:19', '2016-04-01 12:51:19'),
(75, 1, 49, 'admin', '2016-04-01 13:00:20', '2016-04-01 13:00:20'),
(76, 27, 49, 'view', '2016-04-01 13:00:20', '2016-04-01 13:00:20'),
(77, 17, 50, 'admin', '2016-04-01 13:00:23', '2016-04-01 13:00:23'),
(78, 28, 50, 'view', '2016-04-01 13:00:23', '2016-04-01 13:00:23'),
(79, 17, 51, 'admin', '2016-04-01 13:03:49', '2016-04-01 13:03:49'),
(80, 1, 52, 'admin', '2016-04-01 13:04:16', '2016-04-01 13:04:16'),
(81, 1, 53, 'admin', '2016-04-01 13:08:24', '2016-04-01 13:08:24'),
(82, 29, 53, 'view', '2016-04-01 13:08:24', '2016-04-01 13:08:24'),
(83, 1, 54, 'admin', '2016-04-01 13:12:49', '2016-04-01 13:12:49'),
(84, 17, 55, 'admin', '2016-04-01 15:09:56', '2016-04-01 15:09:56'),
(85, 17, 56, 'admin', '2016-04-01 15:14:28', '2016-04-01 15:14:28'),
(86, 17, 57, 'admin', '2016-04-01 15:16:58', '2016-04-01 15:16:58'),
(87, 25, 58, 'admin', '2016-04-01 15:43:40', '2016-04-01 15:43:40'),
(88, 17, 59, 'admin', '2016-04-01 15:55:26', '2016-04-01 15:55:26'),
(89, 18, 59, '', '2016-04-01 15:55:26', '2016-04-01 15:55:26'),
(90, 25, 60, 'admin', '2016-04-01 22:12:46', '2016-04-01 22:12:46'),
(91, 25, 61, 'admin', '2016-04-01 23:49:53', '2016-04-01 23:49:53'),
(92, 30, 61, 'admin', '2016-04-01 23:49:53', '2016-04-01 23:49:53'),
(93, 30, 62, 'admin', '2016-04-02 00:12:55', '2016-04-02 00:12:55'),
(94, 25, 63, 'admin', '2016-04-02 00:20:08', '2016-04-02 00:20:08'),
(95, 25, 64, 'admin', '2016-04-02 04:42:36', '2016-04-02 04:42:36'),
(96, 31, 64, '', '2016-04-02 04:42:36', '2016-04-02 04:42:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_project`
--

CREATE TABLE IF NOT EXISTS `user_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `dataroom_id` int(10) NOT NULL,
  `role` enum('admin','view','downlod','upload') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'view',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=60 ;

--
-- Dumping data for table `user_project`
--

INSERT INTO `user_project` (`id`, `user_id`, `project_id`, `dataroom_id`, `role`, `created_at`, `updated_at`) VALUES
(16, 1, 6, 22, 'admin', '2016-03-18 09:03:17', '2016-03-18 09:03:17'),
(17, 1, 7, 22, 'admin', '2016-03-18 09:04:24', '2016-03-18 09:04:24'),
(18, 9, 8, 24, 'admin', '2016-03-18 00:00:00', '2016-03-18 00:00:00'),
(19, 16, 9, 23, 'admin', '2016-03-18 11:12:44', '2016-03-18 11:12:44'),
(20, 9, 10, 24, 'admin', '2016-03-18 00:00:00', '2016-03-18 00:00:00'),
(21, 1, 10, 24, 'view', '2016-03-18 00:00:00', '2016-03-18 00:00:00'),
(22, 1, 11, 25, 'admin', '2016-03-19 00:00:00', '2016-03-19 00:00:00'),
(23, 19, 12, 26, 'admin', '2016-03-28 00:00:00', '2016-03-28 00:00:00'),
(24, 1, 13, 27, 'admin', '2016-03-28 00:00:00', '2016-03-28 00:00:00'),
(25, 1, 14, 28, 'admin', '2016-03-29 00:00:00', '2016-03-29 00:00:00'),
(26, 1, 15, 30, 'admin', '2016-03-29 00:00:00', '2016-03-29 00:00:00'),
(27, 23, 0, 39, 'admin', '2016-04-01 11:31:22', '2016-04-01 11:31:22'),
(28, 22, 0, 39, '', '2016-04-01 11:31:22', '2016-04-01 11:31:22'),
(29, 23, 0, 39, 'admin', '2016-04-01 11:37:25', '2016-04-01 11:37:25'),
(30, 19, 0, 39, '', '2016-04-01 11:37:25', '2016-04-01 11:37:25'),
(31, 23, 1, 39, 'admin', '2016-04-01 11:40:40', '2016-04-01 11:40:40'),
(32, 23, 2, 39, 'admin', '2016-04-01 11:41:45', '2016-04-01 11:41:45'),
(33, 19, 2, 39, '', '2016-04-01 11:41:45', '2016-04-01 11:41:45'),
(34, 17, 3, 40, 'admin', '2016-04-01 11:50:15', '2016-04-01 11:50:15'),
(35, 23, 4, 43, 'admin', '2016-04-01 12:31:15', '2016-04-01 12:31:15'),
(36, 23, 5, 43, 'admin', '2016-04-01 12:32:46', '2016-04-01 12:32:46'),
(37, 26, 5, 43, '', '2016-04-01 12:32:46', '2016-04-01 12:32:46'),
(38, 17, 6, 23, 'admin', '2016-04-01 14:06:21', '2016-04-01 14:06:21'),
(39, 11, 6, 23, 'upload', '2016-04-01 14:06:21', '2016-04-01 14:06:21'),
(40, 17, 7, 41, 'admin', '2016-04-01 14:27:33', '2016-04-01 14:27:33'),
(41, 11, 7, 41, '', '2016-04-01 14:27:33', '2016-04-01 14:27:33'),
(42, 17, 8, 38, 'admin', '2016-04-01 14:29:00', '2016-04-01 14:29:00'),
(43, 11, 8, 38, 'upload', '2016-04-01 14:29:00', '2016-04-01 14:29:00'),
(44, 17, 9, 59, 'admin', '2016-04-01 16:24:58', '2016-04-01 16:24:58'),
(45, 18, 9, 59, '', '2016-04-01 16:24:58', '2016-04-01 16:24:58'),
(46, 17, 10, 43, 'admin', '2016-04-01 17:11:45', '2016-04-01 17:11:45'),
(47, 17, 11, 43, 'admin', '2016-04-01 17:15:38', '2016-04-01 17:15:38'),
(48, 18, 11, 43, 'view', '2016-04-01 17:15:38', '2016-04-01 17:15:38'),
(49, 25, 12, 49, 'admin', '2016-04-01 22:10:46', '2016-04-01 22:10:46'),
(50, 25, 13, 60, 'admin', '2016-04-01 23:59:51', '2016-04-01 23:59:51'),
(51, 30, 13, 60, '', '2016-04-01 23:59:51', '2016-04-01 23:59:51'),
(52, 25, 14, 60, 'admin', '2016-04-02 00:06:31', '2016-04-02 00:06:31'),
(53, 30, 15, 60, 'admin', '2016-04-02 00:08:49', '2016-04-02 00:08:49'),
(54, 25, 16, 62, 'admin', '2016-04-02 00:13:35', '2016-04-02 00:13:35'),
(55, 30, 17, 62, 'admin', '2016-04-02 00:13:36', '2016-04-02 00:13:36'),
(56, 25, 18, 61, 'admin', '2016-04-02 00:19:44', '2016-04-02 00:19:44'),
(57, 25, 19, 63, 'admin', '2016-04-02 00:20:33', '2016-04-02 00:20:33'),
(58, 25, 20, 64, 'admin', '2016-04-02 04:43:19', '2016-04-02 04:43:19'),
(59, 25, 21, 64, 'admin', '2016-04-02 04:43:54', '2016-04-02 04:43:54');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
