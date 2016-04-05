-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2016 at 07:23 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `block_domain_dataroom`
--

INSERT INTO `block_domain_dataroom` (`id`, `domain`, `dataroom_id`, `history`, `created_at`, `updated_at`) VALUES
(1, '@test.com', 21, '', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(2, '@test.com', 22, '', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(3, '@test.com', 23, '', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(4, '', 24, '', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(5, '', 25, '', '2016-03-16 18:30:00', '2016-03-16 18:30:00');

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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_role_file`
--

CREATE TABLE IF NOT EXISTS `data_role_file` (
`id` int(11) NOT NULL,
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
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_room`
--

CREATE TABLE IF NOT EXISTS `data_room` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `data_room`
--

INSERT INTO `data_room` (`id`, `name`, `company`, `photo`, `description`, `status`, `created_at`, `updated_at`) VALUES
(13, 'Jai shri Krishna', '', '0', '', '1', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(14, 'data Room12121', '', '0', '', '1', '2016-03-10 18:30:00', '2016-03-11 05:49:51'),
(15, 'Anuj - data Room', '', '0', '', '1', '2016-03-10 18:30:00', '2016-03-13 23:06:04'),
(16, 'test', '', '0', 'tttttttttttttt', '1', '2016-03-14 18:30:00', '2016-03-14 18:30:00'),
(17, 'pk', 'test comp', '1', 'test', '1', '2016-03-14 18:30:00', '2016-03-14 18:30:00'),
(18, 'ppp', '', '0', '', '1', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(19, 'demo', 'test comp', '0', 'Organization nameOrganization nameOrganization nameOrganization name', '1', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(20, 'pk latest', 'test comp', '1', 'up dddddddddddddddd', '1', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(21, 'uploaded demo', 'test comp', '', 'ttt', '1', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(22, 'pk latest img', 'test comp', '', 'test', '1', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(23, 'test img lates', 'test comp', '', 'pppppp', '1', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(24, 'demo1111', '', '', 'tttt', '1', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(25, 'pk1111', '', '', 'test', '1', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(26, 'demonnn', 'test comp', '', 'test', '1', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(27, 'demonnnn', '', '56ea59b4a40ba_1458198964.png', 'ppppppppppppppppppp', '1', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(28, 'tested date room', 'test comp', '56eb9dd718f62_1458281943.png', 'tested date room', '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(29, 'demo par', 'tes com', '56f8d70c647c8_1459148556.png', 'desc', '1', '2016-03-28 01:32:50', '2016-03-28 01:32:50'),
(30, 'add image tt', 'test.com', '', 'test desc', '1', '2016-03-28 04:35:37', '2016-03-28 07:22:30');

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
-- Table structure for table `folder`
--

CREATE TABLE IF NOT EXISTS `folder` (
`id` int(11) NOT NULL,
  `foldername` varchar(355) NOT NULL,
  `parentid` varchar(100) NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `projectid` int(11) NOT NULL,
  `dataroomid` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `folder_relation`
--

CREATE TABLE IF NOT EXISTS `folder_relation` (
`id` int(10) unsigned NOT NULL,
  `folder_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `role` enum('admin','upload','view','downloded') COLLATE utf8_unicode_ci NOT NULL,
  `dataroom_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_03_08_095704_block_domain_dataroom', 1),
('2016_03_08_103712_block_projects_domain', 2),
('2016_03_08_103712_folder', 3),
('2016_03_08_105255_data_role_file', 4),
('2016_03_08_112338_file_taggs', 5),
('2016_03_08_112859_throttle', 6),
('2016_03_08_115458_data_room', 7),
('2016_03_08_120247_projects', 8),
('2016_03_08_095704_block_domain_dataroom', 1),
('2016_03_08_103712_block_projects_domain', 2),
('2016_03_08_103712_folder', 3),
('2016_03_08_105255_data_role_file', 4),
('2016_03_08_112338_file_taggs', 5),
('2016_03_08_112859_throttle', 6),
('2016_03_08_115458_data_room', 7),
('2016_03_08_120247_projects', 8);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
`profile_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `firstname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `job_title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `organisation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `firstname`, `lastname`, `photo`, `location`, `timezone`, `job_title`, `organisation`, `created_at`, `updated_at`) VALUES
(1, 1, 'pooran', 'singh', '56ea95310d0b7_1458214193.png', '', 'America/Barbados', '', '', '2016-03-09 05:54:23', '2016-03-17 06:03:46'),
(2, 2, 'pradeep', 'Kumar', '', '', 'America/Caracas', '', '', '2016-03-11 05:11:53', '2016-03-10 23:41:53'),
(3, 3, 'Anuj', 'Kumar', '', '', 'America/Jamaica', '', '', '2016-03-11 05:12:20', '2016-03-10 23:42:20'),
(4, 4, 'amit', 'Kumar', '', '', 'America/Edmonton', '', '', '2016-03-11 05:12:56', '2016-03-10 23:42:56'),
(7, 7, 'pk', 'nnnn', '', '', 'America/Edmonton', '', '', '2016-03-14 13:39:35', '2016-03-14 08:09:35'),
(8, 8, 'pradeep', 'kumar', '56f902abe9235_1459159723.png', '', 'America/Barbados', '', '', '2016-03-18 06:17:57', '2016-03-28 04:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `updateby` int(11) NOT NULL,
  `status` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `company`, `photo`, `description`, `updateby`, `status`, `created_at`, `updated_at`) VALUES
(6, 'project test', 'test comp', '56ebe381dbd59_1458299777.png', 'project', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(7, 'project test', 'test comp', '56ebe381dbd59_1458299777.png', 'project', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(8, 'project test', '', '56ebe41d1934a_1458299933.png', 'ttttt', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(9, 'Add a Project', 'test comp', '56ebe4a0bc46f_1458300064.png', 'Add a ProjectAdd a ProjectAdd a ProjectAdd a ProjectAdd a ProjectAdd a Project', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(10, 'Add a Project', 'test comp', '56ebe4a0bc46f_1458300064.png', 'Add a ProjectAdd a ProjectAdd a ProjectAdd a ProjectAdd a ProjectAdd a Project', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(11, 'Add a Project', 'test.com', '56ebe5c59b4d6_1458300357.png', 'Add a ProjectAdd a ProjectAdd a ProjectAdd a Project', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(12, 'Add a Project', 'test.com', '56ebe5c59b4d6_1458300357.png', 'Add a ProjectAdd a ProjectAdd a ProjectAdd a Project', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(13, 'sdfdfdff', '', '', '', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(14, 'project test', '', '', 'ppppp', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(15, 'pra test', '', '', '', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(16, 'aaaaaa', '', '', '', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(17, 'project test', '', '', 'dssssss', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(18, 'pra test', '', '', '', 1, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(19, 'project test', '', '', '', 8, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(20, 'project test', '', '', 'ppppppp', 8, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(21, 'project test new', '', '56ebef23a2a67_1458302755.png', 'test', 8, '1', '2016-03-17 18:30:00', '2016-03-17 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `project_folder`
--

CREATE TABLE IF NOT EXISTS `project_folder` (
`id` int(10) unsigned NOT NULL,
  `folder_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE IF NOT EXISTS `throttle` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `attempts` int(11) NOT NULL,
  `suspended` tinyint(4) NOT NULL,
  `banned` tinyint(4) NOT NULL,
  `last_attempt_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `suspended_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `ip_address`, `attempts`, `suspended`, `banned`, `last_attempt_at`, `suspended_at`, `created_at`, `updated_at`) VALUES
(1, 1, '::1', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 4, '::1', 0, 0, 0, '2016-03-11 05:34:39', '2016-03-11 05:34:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 3, '::1', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 8, '::1', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 7, '::1', 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `activation_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `source` enum('internel','external') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'internel',
  `bring_by` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `persist_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_password_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_time` tinyint(1) NOT NULL DEFAULT '1',
  `last_known_location` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` enum('superadmin','admin','user') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permissions`, `activated`, `activation_code`, `activated_at`, `source`, `bring_by`, `photo`, `last_login`, `persist_code`, `reset_password_code`, `first_name`, `last_name`, `login_time`, `last_known_location`, `usertype`, `created_at`, `updated_at`) VALUES
(1, 'pooran@ravabe.com', '$2y$10$VyMkrbCfL/4PJofR54yELu4zcn2o6cF4ZgRAfCcoryCtii7o.UYD2', NULL, 1, 'iahP2VAbJipb2eHkyq7bZW1pl7R6e2NOAgjR1yg5i1', NULL, 'internel', 0, '', '2016-03-28 07:17:10', '$2y$10$gVcIofcpx9l0Lk69tu3iS.9pzQi1prJLqfGGXM5YQQJoAO7A7jKy2', NULL, NULL, NULL, 1, '', 'superadmin', '2016-03-09 00:24:23', '2016-03-28 07:17:10'),
(2, 'praddep@ravabe.com', '$2y$10$fp0BVm0.rtQHwyFzzgHujuYCJz4EtIH2XytMaBuff/XYbF8ho2p.u', NULL, 1, 'z2acWVsIEk4QJ1HiBnqnf73J4YDiiFyHgqnxDRp8f3', NULL, 'internel', 0, '', NULL, NULL, 'MmyTFngusrLpJlU9AH4o7dmipENzCUtb0wPHtUMBGb', NULL, NULL, 1, '', 'user', '2016-03-10 23:41:53', '2016-03-17 03:45:04'),
(3, 'Anuj@ravabe.com', '$2y$10$fp0BVm0.rtQHwyFzzgHujuYCJz4EtIH2XytMaBuff/XYbF8ho2p.u', NULL, 1, 'ApGulzybFu7BpDuPsMRzQh2EsvPdcl4wTkWk3T2a5o', NULL, 'internel', 0, '', '2016-03-11 05:17:50', '$2y$10$jsNxCOmAQFp9FDxU4PiOZeARZkiyzJhnuq/eP1lnpt97CaeF6anUm', NULL, NULL, NULL, 1, '', 'user', '2016-03-10 23:42:20', '2016-03-11 05:17:50'),
(4, 'amit@ravabe.com', '$2y$10$fp0BVm0.rtQHwyFzzgHujuYCJz4EtIH2XytMaBuff/XYbF8ho2p.u', NULL, 1, 'tF7HTfRlcBe6HTShiQseq9vyOXpbk5Hs2fJQyHFjWc', NULL, 'internel', 0, '', '2016-03-11 00:04:39', '$2y$10$RHF13txlwYhxsCsX6FTmBeLsN/aBTPSqp1IX.e00W.tNnpnTfYYyu', NULL, NULL, NULL, 1, '', 'user', '2016-03-10 23:42:56', '2016-03-11 00:04:39'),
(7, 'pradeepsre95@gmail.com', '$2y$10$hiO6EWKIc1TscH5h5bc/XepCRvTORER/09ISigngke67a3Glz/DFW', NULL, 1, NULL, NULL, 'external', 0, '', '2016-03-18 00:51:13', '$2y$10$oWTymDF2zfxw13rOCZU7mO8IXbSHqWiKcP2nnFcac5NHt2EGeeJeG', NULL, NULL, NULL, 1, '', 'user', '2016-03-13 18:30:00', '2016-03-18 00:51:13'),
(8, 'pradeep@ravabe.com', '$2y$10$ZnERnCjGPRulQtkw/i5c8OCA03.qTZm9HcHluEegi.hLgc7c4lN.q', NULL, 1, '8V0YaMKhUO7DgxlP3XjvWCOJawEM0JpHpJk6fuNEV2', NULL, 'internel', 0, '', '2016-03-29 03:32:31', '$2y$10$xdj5.v9RyZSvUm4SwJwvK.uRkBM5OPgbF/ku7nosi/fVsGeEPGIGy', NULL, NULL, NULL, 1, '', 'user', '2016-03-18 00:47:57', '2016-03-29 03:32:31');

-- --------------------------------------------------------

--
-- Table structure for table `user_dataroom`
--

CREATE TABLE IF NOT EXISTS `user_dataroom` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `data_room_id` int(10) unsigned NOT NULL,
  `role` enum('admin','view','downlod','upload') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'view',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_dataroom`
--

INSERT INTO `user_dataroom` (`id`, `user_id`, `data_room_id`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 11, 'admin', '2016-03-09 18:30:00', '2016-03-09 18:30:00'),
(2, 2, 11, 'view', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(5, 4, 12, 'admin', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(6, 1, 12, 'view', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(7, 3, 11, 'upload', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(9, 4, 11, 'downlod', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(10, 3, 12, 'upload', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(11, 1, 13, 'admin', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(12, 1, 14, 'admin', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(14, 3, 15, 'admin', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(15, 4, 14, 'upload', '2016-03-10 18:30:00', '2016-03-10 18:30:00'),
(16, 1, 16, 'admin', '2016-03-14 18:30:00', '2016-03-14 18:30:00'),
(17, 1, 17, 'admin', '2016-03-14 18:30:00', '2016-03-14 18:30:00'),
(18, 1, 18, 'admin', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(19, 1, 19, 'admin', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(20, 1, 20, 'admin', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(21, 7, 20, 'view', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(22, 2, 20, 'view', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(23, 1, 21, 'admin', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(24, 1, 21, 'view', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(25, 1, 22, 'admin', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(26, 2, 22, 'view', '2016-03-15 18:30:00', '2016-03-15 18:30:00'),
(27, 1, 23, 'admin', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(28, 7, 23, 'view', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(29, 1, 24, 'admin', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(30, 1, 25, 'admin', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(31, 1, 25, 'view', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(32, 1, 26, 'admin', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(33, 1, 26, 'view', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(34, 1, 27, 'admin', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(35, 1, 27, 'view', '2016-03-16 18:30:00', '2016-03-16 18:30:00'),
(36, 8, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(37, 7, 28, 'view', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(38, 8, 29, 'admin', '2016-03-28 01:32:50', '2016-03-28 01:32:50'),
(39, 2, 29, 'view', '2016-03-28 01:32:50', '2016-03-28 01:32:50'),
(40, 8, 30, 'admin', '2016-03-28 04:35:37', '2016-03-28 04:35:37'),
(41, 4, 29, 'view', '2016-03-28 18:30:00', '2016-03-28 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_project`
--

CREATE TABLE IF NOT EXISTS `user_project` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `dataroom_id` int(10) NOT NULL,
  `role` enum('admin','view','downlod','upload') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'view',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_project`
--

INSERT INTO `user_project` (`id`, `user_id`, `project_id`, `dataroom_id`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 25, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(2, 1, 7, 25, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(3, 1, 8, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(4, 1, 9, 26, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(5, 1, 10, 26, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(6, 1, 11, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(7, 1, 12, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(8, 8, 12, 28, 'view', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(9, 8, 12, 28, 'view', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(10, 1, 13, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(11, 1, 14, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(12, 1, 15, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(13, 1, 16, 23, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(14, 1, 17, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(15, 1, 18, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(16, 8, 19, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(17, 8, 20, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(18, 8, 21, 28, 'admin', '2016-03-17 18:30:00', '2016-03-17 18:30:00'),
(19, 2, 21, 28, 'view', '2016-03-17 18:30:00', '2016-03-17 18:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `block_domain_dataroom`
--
ALTER TABLE `block_domain_dataroom`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `block_projects_domain`
--
ALTER TABLE `block_projects_domain`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_role_file`
--
ALTER TABLE `data_role_file`
 ADD PRIMARY KEY (`id`), ADD KEY `folderid` (`folderid`);

--
-- Indexes for table `data_room`
--
ALTER TABLE `data_room`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folder_relation`
--
ALTER TABLE `folder_relation`
 ADD PRIMARY KEY (`id`), ADD KEY `folder_relation_user_id_foreign` (`user_id`), ADD KEY `folder_relation_folder_id_foreign` (`folder_id`), ADD KEY `folder_relation_dataroom_id_foreign` (`dataroom_id`), ADD KEY `folder_relation_project_id_foreign` (`project_id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
 ADD PRIMARY KEY (`profile_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_folder`
--
ALTER TABLE `project_folder`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `throttle`
--
ALTER TABLE `throttle`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_dataroom`
--
ALTER TABLE `user_dataroom`
 ADD PRIMARY KEY (`id`), ADD KEY `user_dataroom_user_id_foreign` (`user_id`), ADD KEY `user_dataroom_data_room_id_foreign` (`data_room_id`);

--
-- Indexes for table `user_project`
--
ALTER TABLE `user_project`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `block_domain_dataroom`
--
ALTER TABLE `block_domain_dataroom`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `data_role_file`
--
ALTER TABLE `data_role_file`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `data_room`
--
ALTER TABLE `data_room`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `folder_relation`
--
ALTER TABLE `folder_relation`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
MODIFY `profile_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `project_folder`
--
ALTER TABLE `project_folder`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `throttle`
--
ALTER TABLE `throttle`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user_dataroom`
--
ALTER TABLE `user_dataroom`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `user_project`
--
ALTER TABLE `user_project`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_role_file`
--
ALTER TABLE `data_role_file`
ADD CONSTRAINT `data_role_file_ibfk_1` FOREIGN KEY (`folderid`) REFERENCES `folder` (`id`);

--
-- Constraints for table `folder_relation`
--
ALTER TABLE `folder_relation`
ADD CONSTRAINT `folder_relation_dataroom_id_foreign` FOREIGN KEY (`dataroom_id`) REFERENCES `data_room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `folder_relation_folder_id_foreign` FOREIGN KEY (`folder_id`) REFERENCES `project_folder` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `folder_relation_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `folder_relation_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
