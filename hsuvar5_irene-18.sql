-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 20, 2019 at 02:11 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hsuvar5_irene`
--

-- --------------------------------------------------------

--
-- Table structure for table `demo_user_details`
--

CREATE TABLE `demo_user_details` (
  `dmud_id` int(11) NOT NULL,
  `dmud_name` varchar(200) DEFAULT NULL,
  `dmud_email` varchar(200) DEFAULT NULL,
  `dmud_phone` varchar(100) DEFAULT NULL,
  `dmud_company` varchar(200) DEFAULT NULL,
  `dmud_ip` varchar(100) DEFAULT NULL,
  `dmud_location` varchar(100) DEFAULT NULL,
  `dmud_created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_admins`
--

CREATE TABLE `i_admins` (
  `ia_id` int(11) NOT NULL,
  `ia_uname` varchar(100) DEFAULT NULL,
  `ia_ustar` varchar(100) DEFAULT NULL,
  `ia_upassword` varchar(100) DEFAULT NULL,
  `ia_super` varchar(50) DEFAULT NULL,
  `ia_general` varchar(50) DEFAULT NULL,
  `ia_developer` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_admins`
--

INSERT INTO `i_admins` (`ia_id`, `ia_uname`, `ia_ustar`, `ia_upassword`, `ia_super`, `ia_general`, `ia_developer`) VALUES
(2, '9769351539', 'ava', '9769351539', 'true', 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_adm_cust_prefernces`
--

CREATE TABLE `i_adm_cust_prefernces` (
  `iacp_id` int(11) NOT NULL,
  `iacp_customer_id` int(11) DEFAULT NULL,
  `iacp_tag_id` int(11) DEFAULT NULL,
  `iacp_created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_adm_details`
--

CREATE TABLE `i_adm_details` (
  `iad_id` int(11) NOT NULL,
  `iad_a_id` int(11) DEFAULT NULL,
  `iad_a_name` varchar(100) DEFAULT NULL,
  `iad_a_phone` varchar(100) DEFAULT NULL,
  `iad_a_email` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_adm_details`
--

INSERT INTO `i_adm_details` (`iad_id`, `iad_a_id`, `iad_a_name`, `iad_a_phone`, `iad_a_email`) VALUES
(1, 8, 'krishna', '12345678', 'krishna@evomata.com'),
(2, 9, 'krishnakant', '123456789', 'krishnakant@evomata.com');

-- --------------------------------------------------------

--
-- Table structure for table `i_adm_tags`
--

CREATE TABLE `i_adm_tags` (
  `iat_id` int(11) NOT NULL,
  `iat_value` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_column_index`
--

CREATE TABLE `i_column_index` (
  `ici_id` int(11) NOT NULL,
  `ici_type` varchar(100) DEFAULT NULL,
  `ici_module_entity_id` varchar(100) DEFAULT NULL,
  `ici_table_name` varchar(100) DEFAULT NULL,
  `ici_column_name` varchar(100) DEFAULT NULL,
  `ici_default` varchar(100) DEFAULT NULL,
  `ici_name` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_customers`
--

CREATE TABLE `i_customers` (
  `ic_id` int(11) NOT NULL,
  `ic_name` varchar(200) DEFAULT NULL,
  `ic_owner` int(11) DEFAULT NULL,
  `ic_created` datetime DEFAULT NULL,
  `ic_created_by` int(11) DEFAULT NULL,
  `ic_modified` datetime DEFAULT NULL,
  `ic_modified_by` int(11) DEFAULT NULL,
  `ic_section` varchar(100) DEFAULT NULL,
  `ic_section_update` datetime DEFAULT NULL,
  `ic_uid` int(11) DEFAULT NULL,
  `ic_msg_invite` int(11) DEFAULT NULL,
  `ic_card_id` varchar(200) DEFAULT NULL,
  `ic_p_cid` int(11) DEFAULT NULL,
  `ic_p_rel` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_customers`
--

INSERT INTO `i_customers` (`ic_id`, `ic_name`, `ic_owner`, `ic_created`, `ic_created_by`, `ic_modified`, `ic_modified_by`, `ic_section`, `ic_section_update`, `ic_uid`, `ic_msg_invite`, `ic_card_id`, `ic_p_cid`, `ic_p_rel`) VALUES
(1, 'kpatole', 1, '2019-06-19 12:58:22', 1, NULL, NULL, 'customer', NULL, 2, NULL, NULL, NULL, NULL),
(2, 'vinaya', 1, '2019-06-19 12:58:22', 1, NULL, NULL, 'customer', NULL, 3, NULL, NULL, NULL, NULL),
(7, 'krishnakant@evomata.com', 3, '2019-06-19 00:00:00', 3, NULL, NULL, 'customer', NULL, 1, NULL, NULL, NULL, NULL),
(8, 'Test vendor', 4, NULL, 4, NULL, NULL, 'customer', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Test Customer', 4, '2019-06-20 12:28:40', 4, NULL, NULL, 'customer', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'krishnakant@evomata.com', 2, '2019-06-19 00:00:00', 2, NULL, NULL, 'customer', NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_customers_relations`
--

CREATE TABLE `i_customers_relations` (
  `icr_id` int(11) NOT NULL,
  `icr_parent_id` int(11) DEFAULT NULL,
  `icr_child_id` int(11) DEFAULT NULL,
  `icr_relation` varchar(100) DEFAULT NULL,
  `icr_owner` int(11) DEFAULT NULL,
  `icr_created` datetime DEFAULT NULL,
  `icr_created_by` int(11) DEFAULT NULL,
  `icr_modified` datetime DEFAULT NULL,
  `icr_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_c_attendance`
--

CREATE TABLE `i_c_attendance` (
  `ica_id` int(11) NOT NULL,
  `ica_card_id` varchar(200) DEFAULT NULL,
  `ica_date` datetime DEFAULT NULL,
  `ica_device_id` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_c_attendance`
--

INSERT INTO `i_c_attendance` (`ica_id`, `ica_card_id`, `ica_date`, `ica_device_id`) VALUES
(1, '12318', '2019-03-01 10:15:19', 'ABC123'),
(2, '12318', '2019-03-02 10:15:19', 'ABC123'),
(3, '12318', '2019-03-03 10:15:19', 'ABC123'),
(4, '12318', '2019-03-04 10:15:19', 'ABC123'),
(5, '12318', '2019-03-05 10:15:19', 'ABC123'),
(6, '12318', '2019-03-06 10:15:19', 'ABC123'),
(7, '12318', '2019-03-07 10:15:19', 'ABC123'),
(8, '12318', '2019-03-08 10:15:19', 'ABC123'),
(9, '12318', '2019-03-09 10:15:19', 'ABC123'),
(10, '12318', '2019-03-10 10:15:19', 'ABC123'),
(11, '12318', '2019-03-11 10:15:19', 'ABC123'),
(12, '12318', '2019-03-12 10:15:19', 'ABC123'),
(13, '12318', '2019-03-13 10:15:19', 'ABC123'),
(14, '12318', '2019-03-14 10:15:19', 'ABC123'),
(15, '12318', '2019-03-15 10:15:19', 'ABC123'),
(16, '12318', '2019-03-16 10:15:19', 'ABC123'),
(17, '12318', '2019-03-17 10:15:19', 'ABC123'),
(18, '12318', '2019-03-18 10:15:19', 'ABC123'),
(19, '12318', '2019-03-19 10:15:19', 'ABC123'),
(20, '12318', '2019-03-20 10:15:19', 'ABC123'),
(21, '12318', '2019-03-21 10:15:19', 'ABC123'),
(22, '12318', '2019-03-22 10:15:19', 'ABC123'),
(23, '12318', '2019-03-23 10:15:19', 'ABC123'),
(24, '12318', '2019-03-24 10:15:19', 'ABC123'),
(25, '12318', '2019-03-25 10:15:19', 'ABC123'),
(26, '12318', '2019-03-26 10:15:19', 'ABC123'),
(27, '12318', '2019-03-27 10:15:19', 'ABC123'),
(28, '12318', '2019-03-28 10:15:19', 'ABC123'),
(29, '12317', '2019-03-01 10:15:19', 'ABC123'),
(30, '12317', '2019-03-02 10:15:19', 'ABC123'),
(31, '12317', '2019-03-03 10:15:19', 'ABC123'),
(32, '12317', '2019-03-04 10:15:19', 'ABC123'),
(33, '12317', '2019-03-05 10:15:19', 'ABC123'),
(34, '12317', '2019-03-06 10:15:19', 'ABC123'),
(35, '12317', '2019-03-07 10:15:19', 'ABC123'),
(36, '12317', '2019-03-08 10:15:19', 'ABC123'),
(37, '12317', '2019-03-09 10:15:19', 'ABC123'),
(38, '12317', '2019-03-10 10:15:19', 'ABC123'),
(39, '12317', '2019-03-11 10:15:19', 'ABC123'),
(40, '12317', '2019-03-12 10:15:19', 'ABC123'),
(41, '12317', '2019-03-13 10:15:19', 'ABC123'),
(42, '12317', '2019-03-14 10:15:19', 'ABC123'),
(43, '12317', '2019-03-15 10:15:19', 'ABC123'),
(44, '12317', '2019-03-16 10:15:19', 'ABC123'),
(45, '12317', '2019-03-17 10:15:19', 'ABC123'),
(46, '12317', '2019-03-18 10:15:19', 'ABC123'),
(47, '12317', '2019-03-19 10:15:19', 'ABC123'),
(48, '12317', '2019-03-20 10:15:19', 'ABC123'),
(49, '12317', '2019-03-21 10:15:19', 'ABC123'),
(50, '12317', '2019-03-22 10:15:19', 'ABC123'),
(51, '12317', '2019-03-23 10:15:19', 'ABC123'),
(52, '12317', '2019-03-24 10:15:19', 'ABC123'),
(53, '12317', '2019-03-25 10:15:19', 'ABC123'),
(54, '12317', '2019-03-26 10:15:19', 'ABC123'),
(55, '12317', '2019-03-27 10:15:19', 'ABC123'),
(56, '12317', '2019-03-28 10:15:19', 'ABC123'),
(57, '12319', '2019-03-01 10:15:19', 'ABC123'),
(58, '12319', '2019-03-02 10:15:19', 'ABC123'),
(59, '12319', '2019-03-03 10:15:19', 'ABC123'),
(60, '12319', '2019-03-04 10:15:19', 'ABC123'),
(61, '12319', '2019-03-05 10:15:19', 'ABC123'),
(62, '12319', '2019-03-06 10:15:19', 'ABC123'),
(63, '12319', '2019-03-07 10:15:19', 'ABC123'),
(64, '12319', '2019-03-08 10:15:19', 'ABC123'),
(65, '12319', '2019-03-09 10:15:19', 'ABC123'),
(66, '12319', '2019-03-10 10:15:19', 'ABC123'),
(67, '12319', '2019-03-11 10:15:19', 'ABC123'),
(68, '12319', '2019-03-12 10:15:19', 'ABC123'),
(69, '12319', '2019-03-13 10:15:19', 'ABC123'),
(70, '12319', '2019-03-14 10:15:19', 'ABC123'),
(71, '12319', '2019-03-15 10:15:19', 'ABC123'),
(72, '12319', '2019-03-16 10:15:19', 'ABC123'),
(73, '12319', '2019-03-17 10:15:19', 'ABC123'),
(74, '12319', '2019-03-18 10:15:19', 'ABC123'),
(75, '12319', '2019-03-19 10:15:19', 'ABC123'),
(76, '12319', '2019-03-20 10:15:19', 'ABC123'),
(77, '12319', '2019-03-21 10:15:19', 'ABC123'),
(78, '12319', '2019-03-22 10:15:19', 'ABC123'),
(79, '12319', '2019-03-23 10:15:19', 'ABC123'),
(80, '12319', '2019-03-24 10:15:19', 'ABC123'),
(81, '12319', '2019-03-25 10:15:19', 'ABC123'),
(82, '12319', '2019-03-26 10:15:19', 'ABC123'),
(83, '12319', '2019-03-27 10:15:19', 'ABC123'),
(84, '12319', '2019-03-28 10:15:19', 'ABC123'),
(85, '12318', '2019-03-01 18:15:19', 'ABC123'),
(86, '12318', '2019-03-02 18:15:19', 'ABC123'),
(87, '12318', '2019-03-03 18:15:19', 'ABC123'),
(88, '12318', '2019-03-04 18:15:19', 'ABC123'),
(89, '12318', '2019-03-05 18:15:19', 'ABC123'),
(90, '12318', '2019-03-06 18:15:19', 'ABC123'),
(91, '12318', '2019-03-07 18:15:19', 'ABC123'),
(92, '12318', '2019-03-08 18:15:19', 'ABC123'),
(93, '12318', '2019-03-09 18:15:19', 'ABC123'),
(94, '12318', '2019-03-10 18:15:19', 'ABC123'),
(95, '12318', '2019-03-11 18:15:19', 'ABC123'),
(96, '12318', '2019-03-12 18:15:19', 'ABC123'),
(97, '12318', '2019-03-13 18:15:19', 'ABC123'),
(98, '12318', '2019-03-14 18:15:19', 'ABC123'),
(99, '12318', '2019-03-15 18:15:19', 'ABC123'),
(100, '12318', '2019-03-16 18:15:19', 'ABC123'),
(101, '12318', '2019-03-17 18:15:19', 'ABC123'),
(102, '12318', '2019-03-18 18:15:19', 'ABC123'),
(103, '12318', '2019-03-19 18:15:19', 'ABC123'),
(104, '12318', '2019-03-20 18:15:19', 'ABC123'),
(105, '12318', '2019-03-21 18:15:19', 'ABC123'),
(106, '12318', '2019-03-22 18:15:19', 'ABC123'),
(107, '12318', '2019-03-23 18:15:19', 'ABC123'),
(108, '12318', '2019-03-24 18:15:19', 'ABC123'),
(109, '12318', '2019-03-25 18:15:19', 'ABC123'),
(110, '12318', '2019-03-26 18:15:19', 'ABC123'),
(111, '12318', '2019-03-27 18:15:19', 'ABC123'),
(112, '12318', '2019-03-28 18:15:19', 'ABC123'),
(113, '12317', '2019-03-01 18:15:19', 'ABC123'),
(114, '12317', '2019-03-02 18:15:19', 'ABC123'),
(115, '12317', '2019-03-03 18:15:19', 'ABC123'),
(116, '12317', '2019-03-04 18:15:19', 'ABC123'),
(117, '12317', '2019-03-05 18:15:19', 'ABC123'),
(118, '12317', '2019-03-06 18:15:19', 'ABC123'),
(119, '12317', '2019-03-07 18:15:19', 'ABC123'),
(120, '12317', '2019-03-08 18:15:19', 'ABC123'),
(121, '12317', '2019-03-09 18:15:19', 'ABC123'),
(122, '12317', '2019-03-10 18:15:19', 'ABC123'),
(123, '12317', '2019-03-11 18:15:19', 'ABC123'),
(124, '12317', '2019-03-12 18:15:19', 'ABC123'),
(125, '12317', '2019-03-13 18:15:19', 'ABC123'),
(126, '12317', '2019-03-14 18:15:19', 'ABC123'),
(127, '12317', '2019-03-15 18:15:19', 'ABC123'),
(128, '12317', '2019-03-16 18:15:19', 'ABC123'),
(129, '12317', '2019-03-17 18:15:19', 'ABC123'),
(130, '12317', '2019-03-18 18:15:19', 'ABC123'),
(131, '12317', '2019-03-19 18:15:19', 'ABC123'),
(132, '12317', '2019-03-20 18:15:19', 'ABC123'),
(133, '12317', '2019-03-21 18:15:19', 'ABC123'),
(134, '12317', '2019-03-22 18:15:19', 'ABC123'),
(135, '12317', '2019-03-23 18:15:19', 'ABC123'),
(136, '12317', '2019-03-24 18:15:19', 'ABC123'),
(137, '12317', '2019-03-25 18:15:19', 'ABC123'),
(138, '12317', '2019-03-26 18:15:19', 'ABC123'),
(139, '12317', '2019-03-27 18:15:19', 'ABC123'),
(140, '12317', '2019-03-28 18:15:19', 'ABC123'),
(141, '12319', '2019-03-01 18:15:19', 'ABC123'),
(142, '12319', '2019-03-02 18:15:19', 'ABC123'),
(143, '12319', '2019-03-03 18:15:19', 'ABC123'),
(144, '12319', '2019-03-04 18:15:19', 'ABC123'),
(145, '12319', '2019-03-05 18:15:19', 'ABC123'),
(146, '12319', '2019-03-06 18:15:19', 'ABC123'),
(147, '12319', '2019-03-07 18:15:19', 'ABC123'),
(148, '12319', '2019-03-08 18:15:19', 'ABC123'),
(149, '12319', '2019-03-09 18:15:19', 'ABC123'),
(150, '12319', '2019-03-10 18:15:19', 'ABC123'),
(151, '12319', '2019-03-11 18:15:19', 'ABC123'),
(152, '12319', '2019-03-12 18:15:19', 'ABC123'),
(153, '12319', '2019-03-13 18:15:19', 'ABC123'),
(154, '12319', '2019-03-14 18:15:19', 'ABC123'),
(155, '12319', '2019-03-15 18:15:19', 'ABC123'),
(156, '12319', '2019-03-16 18:15:19', 'ABC123'),
(157, '12319', '2019-03-17 18:15:19', 'ABC123'),
(158, '12319', '2019-03-18 18:15:19', 'ABC123'),
(159, '12319', '2019-03-19 18:15:19', 'ABC123'),
(160, '12319', '2019-03-20 18:15:19', 'ABC123'),
(161, '12319', '2019-03-21 18:15:19', 'ABC123'),
(162, '12319', '2019-03-22 18:15:19', 'ABC123'),
(163, '12319', '2019-03-23 18:15:19', 'ABC123'),
(164, '12319', '2019-03-24 18:15:19', 'ABC123'),
(165, '12319', '2019-03-25 18:15:19', 'ABC123'),
(166, '12319', '2019-03-26 18:15:19', 'ABC123'),
(167, '12319', '2019-03-27 18:15:19', 'ABC123'),
(168, '12319', '2019-03-28 18:15:19', 'ABC123'),
(169, '12318', '2019-03-01 13:17:47', 'ABC123'),
(170, '12318', '2019-03-02 13:17:47', 'ABC123'),
(171, '12318', '2019-03-03 13:17:47', 'ABC123'),
(172, '12318', '2019-03-04 13:17:47', 'ABC123'),
(173, '12318', '2019-03-05 13:17:47', 'ABC123'),
(174, '12318', '2019-03-06 13:17:47', 'ABC123'),
(175, '12318', '2019-03-07 13:17:47', 'ABC123'),
(176, '12318', '2019-03-08 13:17:47', 'ABC123'),
(177, '12318', '2019-03-09 13:17:47', 'ABC123'),
(178, '12318', '2019-03-10 13:17:47', 'ABC123'),
(179, '12318', '2019-03-11 13:17:47', 'ABC123'),
(180, '12318', '2019-03-12 13:17:47', 'ABC123'),
(181, '12318', '2019-03-13 13:17:47', 'ABC123'),
(182, '12318', '2019-03-14 13:17:47', 'ABC123'),
(183, '12318', '2019-03-15 13:17:47', 'ABC123'),
(184, '12318', '2019-03-16 13:17:47', 'ABC123'),
(185, '12318', '2019-03-17 13:17:47', 'ABC123'),
(186, '12318', '2019-03-18 13:17:47', 'ABC123'),
(187, '12318', '2019-03-19 13:17:47', 'ABC123'),
(188, '12318', '2019-03-20 13:17:47', 'ABC123'),
(189, '12318', '2019-03-21 13:17:47', 'ABC123'),
(190, '12318', '2019-03-22 13:17:47', 'ABC123'),
(191, '12318', '2019-03-23 13:17:47', 'ABC123'),
(192, '12318', '2019-03-24 13:17:47', 'ABC123'),
(193, '12318', '2019-03-25 13:17:47', 'ABC123'),
(194, '12318', '2019-03-26 13:17:47', 'ABC123'),
(195, '12318', '2019-03-27 13:17:47', 'ABC123'),
(196, '12318', '2019-03-28 13:17:47', 'ABC123'),
(197, '12317', '2019-03-01 13:17:47', 'ABC123'),
(198, '12317', '2019-03-02 13:17:47', 'ABC123'),
(199, '12317', '2019-03-03 13:17:47', 'ABC123'),
(200, '12317', '2019-03-04 13:17:47', 'ABC123'),
(201, '12317', '2019-03-05 13:17:47', 'ABC123'),
(202, '12317', '2019-03-06 13:17:47', 'ABC123'),
(203, '12317', '2019-03-07 13:17:47', 'ABC123'),
(204, '12317', '2019-03-08 13:17:47', 'ABC123'),
(205, '12317', '2019-03-09 13:17:47', 'ABC123'),
(206, '12317', '2019-03-10 13:17:47', 'ABC123'),
(207, '12317', '2019-03-11 13:17:47', 'ABC123'),
(208, '12317', '2019-03-12 13:17:47', 'ABC123'),
(209, '12317', '2019-03-13 13:17:47', 'ABC123'),
(210, '12317', '2019-03-14 13:17:47', 'ABC123'),
(211, '12317', '2019-03-15 13:17:47', 'ABC123'),
(212, '12317', '2019-03-16 13:17:47', 'ABC123'),
(213, '12317', '2019-03-17 13:17:47', 'ABC123'),
(214, '12317', '2019-03-18 13:17:47', 'ABC123'),
(215, '12317', '2019-03-19 13:17:47', 'ABC123'),
(216, '12317', '2019-03-20 13:17:47', 'ABC123'),
(217, '12317', '2019-03-21 13:17:47', 'ABC123'),
(218, '12317', '2019-03-22 13:17:47', 'ABC123'),
(219, '12317', '2019-03-23 13:17:47', 'ABC123'),
(220, '12317', '2019-03-24 13:17:47', 'ABC123'),
(221, '12317', '2019-03-25 13:17:47', 'ABC123'),
(222, '12317', '2019-03-26 13:17:47', 'ABC123'),
(223, '12317', '2019-03-27 13:17:47', 'ABC123'),
(224, '12317', '2019-03-28 13:17:47', 'ABC123'),
(225, '12319', '2019-03-01 13:17:47', 'ABC123'),
(226, '12319', '2019-03-02 13:17:47', 'ABC123'),
(227, '12319', '2019-03-03 13:17:47', 'ABC123'),
(228, '12319', '2019-03-04 13:17:47', 'ABC123'),
(229, '12319', '2019-03-05 13:17:47', 'ABC123'),
(230, '12319', '2019-03-06 13:17:47', 'ABC123'),
(231, '12319', '2019-03-07 13:17:47', 'ABC123'),
(232, '12319', '2019-03-08 13:17:47', 'ABC123'),
(233, '12319', '2019-03-09 13:17:47', 'ABC123'),
(234, '12319', '2019-03-10 13:17:47', 'ABC123'),
(235, '12319', '2019-03-11 13:17:47', 'ABC123'),
(236, '12319', '2019-03-12 13:17:47', 'ABC123'),
(237, '12319', '2019-03-13 13:17:47', 'ABC123'),
(238, '12319', '2019-03-14 13:17:47', 'ABC123'),
(239, '12319', '2019-03-15 13:17:47', 'ABC123'),
(240, '12319', '2019-03-16 13:17:47', 'ABC123'),
(241, '12319', '2019-03-17 13:17:47', 'ABC123'),
(242, '12319', '2019-03-18 13:17:47', 'ABC123'),
(243, '12319', '2019-03-19 13:17:47', 'ABC123'),
(244, '12319', '2019-03-20 13:17:47', 'ABC123'),
(245, '12319', '2019-03-21 13:17:47', 'ABC123'),
(246, '12319', '2019-03-22 13:17:47', 'ABC123'),
(247, '12319', '2019-03-23 13:17:47', 'ABC123'),
(248, '12319', '2019-03-24 13:17:47', 'ABC123'),
(249, '12319', '2019-03-25 13:17:47', 'ABC123'),
(250, '12319', '2019-03-26 13:17:47', 'ABC123'),
(251, '12319', '2019-03-27 13:17:47', 'ABC123'),
(252, '12319', '2019-03-28 13:17:47', 'ABC123'),
(253, '12318', '2019-03-01 13:17:49', 'ABC123'),
(254, '12318', '2019-03-02 13:17:49', 'ABC123'),
(255, '12318', '2019-03-03 13:17:49', 'ABC123'),
(256, '12318', '2019-03-04 13:17:49', 'ABC123'),
(257, '12318', '2019-03-05 13:17:49', 'ABC123'),
(258, '12318', '2019-03-06 13:17:49', 'ABC123'),
(259, '12318', '2019-03-07 13:17:49', 'ABC123'),
(260, '12318', '2019-03-08 13:17:49', 'ABC123'),
(261, '12318', '2019-03-09 13:17:49', 'ABC123'),
(262, '12318', '2019-03-10 13:17:49', 'ABC123'),
(263, '12318', '2019-03-11 13:17:49', 'ABC123'),
(264, '12318', '2019-03-12 13:17:49', 'ABC123'),
(265, '12318', '2019-03-13 13:17:49', 'ABC123'),
(266, '12318', '2019-03-14 13:17:49', 'ABC123'),
(267, '12318', '2019-03-15 13:17:49', 'ABC123'),
(268, '12318', '2019-03-16 13:17:49', 'ABC123'),
(269, '12318', '2019-03-17 13:17:49', 'ABC123'),
(270, '12318', '2019-03-18 13:17:49', 'ABC123'),
(271, '12318', '2019-03-19 13:17:49', 'ABC123'),
(272, '12318', '2019-03-20 13:17:49', 'ABC123'),
(273, '12318', '2019-03-21 13:17:49', 'ABC123'),
(274, '12318', '2019-03-22 13:17:49', 'ABC123'),
(275, '12318', '2019-03-23 13:17:49', 'ABC123'),
(276, '12318', '2019-03-24 13:17:49', 'ABC123'),
(277, '12318', '2019-03-25 13:17:49', 'ABC123'),
(278, '12318', '2019-03-26 13:17:49', 'ABC123'),
(279, '12318', '2019-03-27 13:17:49', 'ABC123'),
(280, '12318', '2019-03-28 13:17:49', 'ABC123'),
(281, '12317', '2019-03-01 13:17:49', 'ABC123'),
(282, '12317', '2019-03-02 13:17:49', 'ABC123'),
(283, '12317', '2019-03-03 13:17:49', 'ABC123'),
(284, '12317', '2019-03-04 13:17:49', 'ABC123'),
(285, '12317', '2019-03-05 13:17:49', 'ABC123'),
(286, '12317', '2019-03-06 13:17:49', 'ABC123'),
(287, '12317', '2019-03-07 13:17:49', 'ABC123'),
(288, '12317', '2019-03-08 13:17:49', 'ABC123'),
(289, '12317', '2019-03-09 13:17:49', 'ABC123'),
(290, '12317', '2019-03-10 13:17:49', 'ABC123'),
(291, '12317', '2019-03-11 13:17:49', 'ABC123'),
(292, '12317', '2019-03-12 13:17:49', 'ABC123'),
(293, '12317', '2019-03-13 13:17:49', 'ABC123'),
(294, '12317', '2019-03-14 13:17:49', 'ABC123'),
(295, '12317', '2019-03-15 13:17:49', 'ABC123'),
(296, '12317', '2019-03-16 13:17:49', 'ABC123'),
(297, '12317', '2019-03-17 13:17:49', 'ABC123'),
(298, '12317', '2019-03-18 13:17:49', 'ABC123'),
(299, '12317', '2019-03-19 13:17:49', 'ABC123'),
(300, '12317', '2019-03-20 13:17:49', 'ABC123'),
(301, '12317', '2019-03-21 13:17:49', 'ABC123'),
(302, '12317', '2019-03-22 13:17:49', 'ABC123'),
(303, '12317', '2019-03-23 13:17:49', 'ABC123'),
(304, '12317', '2019-03-24 13:17:49', 'ABC123'),
(305, '12317', '2019-03-25 13:17:49', 'ABC123'),
(306, '12317', '2019-03-26 13:17:49', 'ABC123'),
(307, '12317', '2019-03-27 13:17:49', 'ABC123'),
(308, '12317', '2019-03-28 13:17:49', 'ABC123'),
(309, '12319', '2019-03-01 13:17:49', 'ABC123'),
(310, '12319', '2019-03-02 13:17:49', 'ABC123'),
(311, '12319', '2019-03-03 13:17:49', 'ABC123'),
(312, '12319', '2019-03-04 13:17:49', 'ABC123'),
(313, '12319', '2019-03-05 13:17:49', 'ABC123'),
(314, '12319', '2019-03-06 13:17:49', 'ABC123'),
(315, '12319', '2019-03-07 13:17:49', 'ABC123'),
(316, '12319', '2019-03-08 13:17:49', 'ABC123'),
(317, '12319', '2019-03-09 13:17:49', 'ABC123'),
(318, '12319', '2019-03-10 13:17:49', 'ABC123'),
(319, '12319', '2019-03-11 13:17:49', 'ABC123'),
(320, '12319', '2019-03-12 13:17:49', 'ABC123'),
(321, '12319', '2019-03-13 13:17:49', 'ABC123'),
(322, '12319', '2019-03-14 13:17:49', 'ABC123'),
(323, '12319', '2019-03-15 13:17:49', 'ABC123'),
(324, '12319', '2019-03-16 13:17:49', 'ABC123'),
(325, '12319', '2019-03-17 13:17:49', 'ABC123'),
(326, '12319', '2019-03-18 13:17:49', 'ABC123'),
(327, '12319', '2019-03-19 13:17:49', 'ABC123'),
(328, '12319', '2019-03-20 13:17:49', 'ABC123'),
(329, '12319', '2019-03-21 13:17:49', 'ABC123'),
(330, '12319', '2019-03-22 13:17:49', 'ABC123'),
(331, '12319', '2019-03-23 13:17:49', 'ABC123'),
(332, '12319', '2019-03-24 13:17:49', 'ABC123'),
(333, '12319', '2019-03-25 13:17:49', 'ABC123'),
(334, '12319', '2019-03-26 13:17:49', 'ABC123'),
(335, '12319', '2019-03-27 13:17:49', 'ABC123'),
(336, '12319', '2019-03-28 13:17:49', 'ABC123'),
(337, '12310', '2019-03-18 00:00:00', 'ABC123'),
(338, '54321', '2019-04-25 00:00:00', 'ABC123');

-- --------------------------------------------------------

--
-- Table structure for table `i_c_basic_details`
--

CREATE TABLE `i_c_basic_details` (
  `icbd_id` int(11) NOT NULL,
  `icbd_customer_id` int(11) DEFAULT NULL,
  `icbd_property` int(11) DEFAULT NULL,
  `icbd_value` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_c_basic_details`
--

INSERT INTO `i_c_basic_details` (`icbd_id`, `icbd_customer_id`, `icbd_property`, `icbd_value`) VALUES
(1, 1, 3, 'kpatole2@gmail.com'),
(2, 2, 3, 'vinayalokhande1993@gmail.com'),
(3, 3, NULL, 'krishnakant@evomata.com'),
(4, 4, NULL, 'krishnakant@evomata.com'),
(5, 5, NULL, 'krishnakant@evomata.com'),
(6, 6, 58, 'krishnakant@evomata.com'),
(7, 7, 59, 'krishnakant@evomata.com'),
(8, 9, 45, 'krishnakant@evomata.com');

-- --------------------------------------------------------

--
-- Table structure for table `i_c_doc`
--

CREATE TABLE `i_c_doc` (
  `icd_id` int(11) NOT NULL,
  `icd_cid` int(11) DEFAULT NULL,
  `icd_file` varchar(100) DEFAULT NULL,
  `icd_date` datetime DEFAULT NULL,
  `icd_owner` int(11) DEFAULT NULL,
  `icd_timestamp` varchar(100) DEFAULT NULL,
  `icd_type` varchar(100) DEFAULT NULL,
  `icd_mid` int(11) DEFAULT NULL,
  `icd_type_id` int(11) DEFAULT NULL,
  `icd_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_c_doc`
--

INSERT INTO `i_c_doc` (`icd_id`, `icd_cid`, `icd_file`, `icd_date`, `icd_owner`, `icd_timestamp`, `icd_type`, `icd_mid`, `icd_type_id`, `icd_status`) VALUES
(1, 8, 'linux_git_setiup_instructions', '2019-06-20 12:10:16', 4, '01561012816.pdf', 'document', 71, 4, 'true'),
(2, 9, 'teststing', '2019-06-20 12:28:40', 4, '01561013920.xls', 'document', 72, 5, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_c_excel_module`
--

CREATE TABLE `i_c_excel_module` (
  `icem_id` int(11) NOT NULL,
  `icem_path` varchar(500) DEFAULT NULL,
  `icem_name` varchar(100) DEFAULT NULL,
  `icem_status` varchar(100) DEFAULT NULL,
  `icem_table` varchar(200) DEFAULT NULL,
  `icem_owner` int(11) DEFAULT NULL,
  `icem_created` datetime DEFAULT NULL,
  `icem_created_by` int(11) DEFAULT NULL,
  `icem_col_prefix` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_c_excel_module`
--

INSERT INTO `i_c_excel_module` (`icem_id`, `icem_path`, `icem_name`, `icem_status`, `icem_table`, `icem_owner`, `icem_created`, `icem_created_by`, `icem_col_prefix`) VALUES
(121, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 12:11:48', 188, NULL),
(120, 'teststing.xls', NULL, NULL, NULL, 188, '2018-11-17 18:11:52', 188, NULL),
(119, 'teststing.csv', NULL, NULL, NULL, 188, '2018-11-17 18:11:44', 188, NULL),
(118, 'teststing.xls', NULL, NULL, NULL, 188, '2018-11-17 18:11:49', 188, NULL),
(117, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-17 18:11:27', 188, NULL),
(116, 'kandivali-Table 1.csv', NULL, NULL, NULL, 188, '2018-11-17 18:11:47', 188, NULL),
(115, 'Sheet1-Table 1.csv', NULL, NULL, NULL, 188, '2018-11-17 18:11:31', 188, NULL),
(114, NULL, NULL, NULL, NULL, 188, '2018-11-10 12:11:15', 188, NULL),
(113, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-10 12:11:53', 188, NULL),
(111, NULL, NULL, NULL, NULL, 6, '2018-10-01 13:10:23', 6, NULL),
(112, 'kandivali-Table 1.csv', NULL, NULL, NULL, 6, '2018-10-01 13:10:41', 6, NULL),
(94, '11th Sci Mum.xls', NULL, NULL, NULL, 6, '2018-08-21 13:08:22', 6, NULL),
(87, '11th Sci Mum.xls', NULL, NULL, NULL, 6, '2018-08-20 17:08:14', 6, NULL),
(63, 'Sheet1-Table 1.csv', NULL, NULL, NULL, 6, '2018-08-16 19:08:14', 6, NULL),
(70, 'Sheet1-Table 1.xls', NULL, NULL, NULL, 6, '2018-08-17 14:08:34', 6, NULL),
(61, 'Sheet1-Table 1.csv', NULL, NULL, NULL, 6, '2018-08-16 16:08:51', 6, NULL),
(79, '200910.xls', NULL, NULL, NULL, 6, '2018-08-17 14:08:53', 6, NULL),
(60, 'borivali-Table 1.csv', NULL, NULL, NULL, 6, '2018-08-16 16:08:23', 6, NULL),
(59, 'Sheet4-Table 1.csv', NULL, NULL, NULL, 6, '2018-08-16 16:08:05', 6, NULL),
(122, NULL, NULL, NULL, NULL, 188, '2018-11-22 12:11:55', 188, NULL),
(123, '11th Sci Mum.xlsx', NULL, NULL, NULL, 188, '2018-11-22 12:11:06', 188, NULL),
(124, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 12:11:15', 188, NULL),
(125, 'teststing.xls', NULL, NULL, NULL, 188, '2018-11-22 12:11:25', 188, NULL),
(126, NULL, NULL, NULL, NULL, 188, '2018-11-22 12:11:48', 188, NULL),
(127, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 12:11:08', 188, NULL),
(128, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:06', 188, NULL),
(129, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:31', 188, NULL),
(130, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:55', 188, NULL),
(131, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:33', 188, NULL),
(132, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:22', 188, NULL),
(133, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:05', 188, NULL),
(134, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:21', 188, NULL),
(135, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:36', 188, NULL),
(136, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:03', 188, NULL),
(137, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:20', 188, NULL),
(138, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:52', 188, NULL),
(139, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:49', 188, NULL),
(140, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:19', 188, NULL),
(141, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:52', 188, NULL),
(142, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:29', 188, NULL),
(143, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:22', 188, NULL),
(144, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:11', 188, NULL),
(145, '11th Sci Mum.xlsx', NULL, NULL, NULL, 188, '2018-11-22 13:11:11', 188, NULL),
(146, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:55', 188, NULL),
(147, '11th Sci Mum.xlsx', NULL, NULL, NULL, 188, '2018-11-22 13:11:09', 188, NULL),
(148, 'teststing.csv', NULL, NULL, NULL, 188, '2018-11-22 13:11:45', 188, NULL),
(149, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:00', 188, NULL),
(150, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:16', 188, NULL),
(151, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:50', 188, NULL),
(152, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:25', 188, NULL),
(153, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:50', 188, NULL),
(154, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:35', 188, NULL),
(155, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:58', 188, NULL),
(156, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:39', 188, NULL),
(157, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:55', 188, NULL),
(158, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:21', 188, NULL),
(159, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:36', 188, NULL),
(160, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:54', 188, NULL),
(161, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:35', 188, NULL),
(162, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:57', 188, NULL),
(163, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:17', 188, NULL),
(164, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:19', 188, NULL),
(165, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-22 13:11:37', 188, NULL),
(166, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-26 17:11:46', 188, NULL),
(167, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-11-26 17:11:23', 188, NULL),
(169, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-12-19 13:12:39', 188, NULL),
(170, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-12-19 13:12:41', 188, NULL),
(171, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-12-19 13:12:57', 188, NULL),
(172, '11th Sci Mum.xls', NULL, NULL, NULL, 188, '2018-12-19 13:12:53', 188, NULL),
(179, 'hsuvar5_irene.csv', NULL, NULL, NULL, 1, '2019-04-03 11:25:14', 1, NULL),
(180, 'hsuvar5_irene.csv', NULL, NULL, NULL, 1, '2019-04-03 11:27:38', 1, NULL),
(181, '11th Sci Mum.xls', NULL, NULL, NULL, 1, '2019-04-03 11:33:49', 1, NULL),
(182, '11th Sci Mum.xls', NULL, NULL, NULL, 1, '2019-04-03 11:34:23', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_c_e_m_columns`
--

CREATE TABLE `i_c_e_m_columns` (
  `icemc_id` int(11) NOT NULL,
  `icemc_m_id` int(11) DEFAULT NULL,
  `icemc_column` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_c_e_m_preferences`
--

CREATE TABLE `i_c_e_m_preferences` (
  `icemp_id` int(11) NOT NULL,
  `icemp_m_id` int(11) DEFAULT NULL,
  `icemp_tag_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_c_pic`
--

CREATE TABLE `i_c_pic` (
  `icp_id` int(11) NOT NULL,
  `icp_c_id` int(11) DEFAULT NULL,
  `icp_path` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_c_pic`
--

INSERT INTO `i_c_pic` (`icp_id`, `icp_c_id`, `icp_path`) VALUES
(49, 23, '01552709540.png'),
(47, 13, '1881543227735.'),
(48, 14, '1881543227891.'),
(50, 25, '01552709549.svg'),
(51, 26, '01552710628.png'),
(52, 31, '241553232821.'),
(53, 32, '241553233015.'),
(54, 34, '241553233196.'),
(55, 35, '241553233311.'),
(56, 36, '11553233375.jpg'),
(57, 37, '11553233395.png'),
(58, 38, '11553233903.jpg'),
(59, 40, '11553237308.png'),
(67, 0, '11553260666.jpg'),
(61, 63, '11553259220.jpg'),
(62, 64, '11553259220.jpg'),
(63, 65, '11553259220.jpg'),
(64, 66, '11553259249.jpg'),
(65, 67, '11553259277.jpg'),
(68, 73, '11553260938.jpg'),
(69, 75, '11553260938.jpg'),
(70, 74, '11553260938.jpg'),
(71, 76, '11553260939.jpg'),
(72, 77, '11553261013.jpg'),
(73, 78, '11553261068.jpg'),
(74, 79, '11553261068.jpg'),
(75, 80, '11553261483.jpg'),
(76, 82, '11553318329.jpg'),
(77, 6, '11553321830.jpg'),
(82, 84, '11553336068.jpg'),
(83, 2, '11553506587.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `i_c_t_prefernces`
--

CREATE TABLE `i_c_t_prefernces` (
  `ictp_id` int(11) NOT NULL,
  `ictp_customer_id` int(11) DEFAULT NULL,
  `ictp_tag_id` int(11) DEFAULT NULL,
  `ictp_created` datetime DEFAULT NULL,
  `ictp_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_c_t_prefernces`
--

INSERT INTO `i_c_t_prefernces` (`ictp_id`, `ictp_customer_id`, `ictp_tag_id`, `ictp_created`, `ictp_owner`) VALUES
(2, 14, 135, '2018-11-26 15:11:51', 188),
(7, 25, 177, '2018-12-23 19:12:45', 188),
(8, 35492, 7, '2018-12-23 19:12:33', 188);

-- --------------------------------------------------------

--
-- Table structure for table `i_daifunc_product`
--

CREATE TABLE `i_daifunc_product` (
  `idp_id` int(11) NOT NULL,
  `idp_name` varchar(200) DEFAULT NULL,
  `idp_created` datetime DEFAULT NULL,
  `idp_created_by` int(11) DEFAULT NULL,
  `idp_modified` datetime DEFAULT NULL,
  `idp_modified_by` int(11) DEFAULT NULL,
  `idp_link` varchar(500) DEFAULT NULL,
  `idp_file` varchar(200) DEFAULT NULL,
  `idp_pic` varchar(200) DEFAULT NULL,
  `idp_icon_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_daifunc_product`
--

INSERT INTO `i_daifunc_product` (`idp_id`, `idp_name`, `idp_created`, `idp_created_by`, `idp_modified`, `idp_modified_by`, `idp_link`, `idp_file`, `idp_pic`, `idp_icon_name`) VALUES
(2, 'Inventory', '2019-06-03 11:50:49', NULL, '2019-06-05 11:34:51', NULL, 'Inventory/inventory_new', '1559714691.json', '01559552201.jpg', 'shopping_cart');

-- --------------------------------------------------------

--
-- Table structure for table `i_daifunc_product_group`
--

CREATE TABLE `i_daifunc_product_group` (
  `idpg_id` int(11) NOT NULL,
  `idpg_product_id` int(11) DEFAULT NULL,
  `idpg_name` varchar(200) DEFAULT NULL,
  `idpg_created` datetime DEFAULT NULL,
  `idpg_created_by` int(11) DEFAULT NULL,
  `idpg_modified` datetime DEFAULT NULL,
  `idpg_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_daifunc_product_group`
--

INSERT INTO `i_daifunc_product_group` (`idpg_id`, `idpg_product_id`, `idpg_name`, `idpg_created`, `idpg_created_by`, `idpg_modified`, `idpg_modified_by`) VALUES
(2, 2, 'Inward, Outwards & Stock Status', '2019-06-03 11:50:49', NULL, '2019-06-14 13:01:43', NULL),
(4, 2, 'Godowns', '2019-06-03 11:58:04', NULL, NULL, NULL),
(8, 2, 'Analytical Reporting', '2019-06-03 11:59:40', NULL, NULL, NULL),
(15, 2, 'Barcode', '2019-06-03 14:55:51', NULL, NULL, NULL),
(16, 2, 'Your E-commerce Store', '2019-06-03 14:56:06', NULL, NULL, NULL),
(17, 2, 'Returns, Spares, Defects & Cancellations', '2019-06-03 14:56:31', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_daifunc_product_group_module`
--

CREATE TABLE `i_daifunc_product_group_module` (
  `idpgm_id` int(11) NOT NULL,
  `idpgm_product_id` int(11) DEFAULT NULL,
  `idpgm_group_id` int(11) DEFAULT NULL,
  `idpgm_module_id` int(11) DEFAULT NULL,
  `idpgm_created` datetime DEFAULT NULL,
  `idpgm_created_by` int(11) DEFAULT NULL,
  `idpgm_modified` datetime DEFAULT NULL,
  `idpgm_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_daifunc_product_group_module`
--

INSERT INTO `i_daifunc_product_group_module` (`idpgm_id`, `idpgm_product_id`, `idpgm_group_id`, `idpgm_module_id`, `idpgm_created`, `idpgm_created_by`, `idpgm_modified`, `idpgm_modified_by`) VALUES
(5, 2, 4, 67, '2019-06-03 11:58:04', NULL, NULL, NULL),
(9, 2, 8, 75, '2019-06-03 11:59:40', NULL, NULL, NULL),
(36, 2, 15, 55, '2019-06-03 14:55:51', NULL, NULL, NULL),
(37, 2, 16, 56, '2019-06-03 14:56:06', NULL, NULL, NULL),
(38, 2, 17, 74, '2019-06-03 14:56:31', NULL, NULL, NULL),
(49, 2, 2, 71, '2019-06-14 13:01:43', NULL, NULL, NULL),
(50, 2, 2, 72, '2019-06-14 13:01:43', NULL, NULL, NULL),
(51, 2, 2, 73, '2019-06-14 13:01:43', NULL, NULL, NULL),
(52, 2, 2, 76, '2019-06-14 13:01:43', NULL, NULL, NULL),
(53, 2, 2, 77, '2019-06-14 13:01:43', NULL, NULL, NULL),
(54, 2, 2, 78, '2019-06-14 13:01:43', NULL, NULL, NULL),
(55, 2, 2, 79, '2019-06-14 13:01:43', NULL, NULL, NULL),
(56, 2, 2, 80, '2019-06-14 13:01:43', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_daifunc_tax`
--

CREATE TABLE `i_daifunc_tax` (
  `idt_id` int(11) NOT NULL,
  `idt_name` varchar(100) DEFAULT NULL,
  `idt_percent` float DEFAULT NULL,
  `idt_tax_gid` int(11) DEFAULT NULL,
  `idt_created` datetime DEFAULT NULL,
  `idt_created_by` int(11) DEFAULT NULL,
  `idt_modified` datetime DEFAULT NULL,
  `idt_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_daifunc_tax`
--

INSERT INTO `i_daifunc_tax` (`idt_id`, `idt_name`, `idt_percent`, `idt_tax_gid`, `idt_created`, `idt_created_by`, `idt_modified`, `idt_modified_by`) VALUES
(24, 'CGST 9%', 9, 3, '2019-06-05 17:56:02', NULL, NULL, NULL),
(25, 'SGST 9%', 9, 3, '2019-06-05 17:56:02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_daifunc_tax_group`
--

CREATE TABLE `i_daifunc_tax_group` (
  `idtg_id` int(11) NOT NULL,
  `idtg_name` varchar(100) DEFAULT NULL,
  `idtg_created` datetime DEFAULT NULL,
  `idtg_created_by` int(11) DEFAULT NULL,
  `idtg_modified` datetime DEFAULT NULL,
  `idtg_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_daifunc_tax_group`
--

INSERT INTO `i_daifunc_tax_group` (`idtg_id`, `idtg_name`, `idtg_created`, `idtg_created_by`, `idtg_modified`, `idtg_modified_by`) VALUES
(3, 'GST 18%', '2019-06-05 17:56:02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_display`
--

CREATE TABLE `i_display` (
  `id_id` int(11) NOT NULL,
  `id_name` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_domain`
--

CREATE TABLE `i_domain` (
  `idom_id` int(11) NOT NULL,
  `idom_name` varchar(100) DEFAULT NULL,
  `idom_created` datetime DEFAULT NULL,
  `idom_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_domain`
--

INSERT INTO `i_domain` (`idom_id`, `idom_name`, `idom_created`, `idom_created_by`) VALUES
(7, 'Education', '2018-07-04 13:07:21', NULL),
(8, 'Enterprise', '2018-07-04 13:07:30', NULL),
(14, 'Research', '2018-08-06 12:08:36', NULL),
(17, 'Sales', '2018-09-18 11:09:52', NULL),
(15, 'Modx', '2018-08-08 17:08:38', NULL),
(18, 'Projects', '2018-09-20 19:09:00', NULL),
(19, 'Opportunity', '2018-09-24 16:09:48', NULL),
(20, 'Hr', '2018-10-31 15:10:56', NULL),
(21, 'Broadcast', '2018-11-10 12:11:10', NULL),
(22, 'Support', '2019-01-04 14:34:19', NULL),
(23, 'Barcoding', '2019-02-21 12:43:59', NULL),
(24, 'Orders', '2019-02-22 12:25:23', NULL),
(25, 'Letter', '2019-02-22 14:58:24', NULL),
(26, 'Requirement', '2019-03-04 18:15:25', NULL),
(27, 'Design_manager', '2019-03-06 12:20:52', NULL),
(28, 'BOQ', '2019-03-09 09:57:41', NULL),
(29, 'Quote_compare', '2019-03-12 16:44:52', NULL),
(30, 'Accounting', '2019-03-13 15:16:00', NULL),
(31, 'Agreement', '2019-03-25 10:41:07', NULL),
(32, 'Work_module', '2019-04-03 13:11:55', NULL),
(33, 'BOQ_fixed', '2019-04-22 15:31:55', NULL),
(34, 'Inventory', '2019-05-13 12:47:28', NULL),
(35, 'Godown', '2019-05-16 15:00:16', NULL),
(36, 'Purchase_order', '2019-05-25 15:27:36', NULL),
(37, 'Credit_note', '2019-05-27 12:31:01', NULL),
(38, 'Debit_note', '2019-05-27 13:47:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_d_values`
--

CREATE TABLE `i_d_values` (
  `idv_id` int(11) NOT NULL,
  `idv_d_id` int(11) DEFAULT NULL,
  `idv_type` varchar(100) DEFAULT NULL,
  `idv_value` varchar(900) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_explore_collection`
--

CREATE TABLE `i_explore_collection` (
  `iec_id` int(11) NOT NULL,
  `iec_title` varchar(200) DEFAULT NULL,
  `iec_img` varchar(200) DEFAULT NULL,
  `iec_timestamp` varchar(200) DEFAULT NULL,
  `iec_file` varchar(200) DEFAULT NULL,
  `iec_cat1` varchar(200) DEFAULT NULL,
  `iec_cat2` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_explore_collection`
--

INSERT INTO `i_explore_collection` (`iec_id`, `iec_title`, `iec_img`, `iec_timestamp`, `iec_file`, `iec_cat1`, `iec_cat2`) VALUES
(1, 'Exp1', 'done2', '01545291762.svg', '1545291762.txt', 'exp c1', 'exp c2');

-- --------------------------------------------------------

--
-- Table structure for table `i_explore_collection_module`
--

CREATE TABLE `i_explore_collection_module` (
  `iecm_id` int(11) NOT NULL,
  `iecm_ec_id` int(11) DEFAULT NULL,
  `iecm_mid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_explore_collection_module`
--

INSERT INTO `i_explore_collection_module` (`iecm_id`, `iecm_ec_id`, `iecm_mid`) VALUES
(1, 1, 53),
(2, 1, 52),
(3, 1, 51),
(4, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_broadcast`
--

CREATE TABLE `i_ext_broadcast` (
  `iebrod_id` int(11) NOT NULL,
  `iebrod_owner` int(11) DEFAULT NULL,
  `iebrod_name` varchar(200) DEFAULT NULL,
  `iebrod_date` datetime DEFAULT NULL,
  `iebrod_sub` varchar(500) DEFAULT NULL,
  `iebrod_content_type` varchar(50) DEFAULT NULL,
  `iebrod_content` varchar(100) DEFAULT NULL,
  `iebrod_created` datetime DEFAULT NULL,
  `iebrod_created_by` int(11) DEFAULT NULL,
  `iebrod_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_broadcast`
--

INSERT INTO `i_ext_broadcast` (`iebrod_id`, `iebrod_owner`, `iebrod_name`, `iebrod_date`, `iebrod_sub`, `iebrod_content_type`, `iebrod_content`, `iebrod_created`, `iebrod_created_by`, `iebrod_gid`) VALUES
(1, 188, 'test before', '2019-02-20 11:54:00', 'email test with attach', 'html', '1550816677188', '2019-02-22 11:54:37', 188, 0),
(2, 188, 'test after', '2019-02-23 11:54:00', 'final test', 'html', '1550816697188', '2019-02-22 11:54:57', 188, 0),
(3, 188, 'test on', '2019-02-22 11:54:00', 'sample', 'html', '1550816712188', '2019-02-22 11:55:12', 188, 0),
(4, 188, 'final test mail content', '2019-02-19 12:00:00', 'final test', 'html', '1550817073188', '2019-02-22 12:01:13', 188, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_broadcast_mail_batch`
--

CREATE TABLE `i_ext_broadcast_mail_batch` (
  `iextbmb_id` int(11) NOT NULL,
  `iextbmb_email_id` varchar(200) DEFAULT NULL,
  `iextbmb_content` varchar(100) DEFAULT NULL,
  `iextbmb_sub` varchar(500) DEFAULT NULL,
  `iextbmb_owner` int(11) DEFAULT NULL,
  `iextbmb_brod_id` int(11) DEFAULT NULL,
  `iextbmb_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_bro_contact`
--

CREATE TABLE `i_ext_bro_contact` (
  `iebrodc_id` int(11) NOT NULL,
  `iebrodc_brod_id` int(11) DEFAULT NULL,
  `iebrodc_cid` int(11) DEFAULT NULL,
  `iebrodc_oid` int(11) DEFAULT NULL,
  `iebrodc_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_bro_contact`
--

INSERT INTO `i_ext_bro_contact` (`iebrodc_id`, `iebrodc_brod_id`, `iebrodc_cid`, `iebrodc_oid`, `iebrodc_status`) VALUES
(1, 1, 2, 188, 'true'),
(2, 1, 1, 188, 'view'),
(3, 2, 2, 188, 'true'),
(4, 2, 1, 188, 'view'),
(5, 3, 2, 188, 'true'),
(6, 3, 1, 188, 'true'),
(7, 4, 2, 188, 'true'),
(8, 4, 1, 188, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_attendance`
--

CREATE TABLE `i_ext_ed_attendance` (
  `ieea_id` int(11) NOT NULL,
  `ieea_event` varchar(50) DEFAULT NULL,
  `ieea_event_id` int(11) DEFAULT NULL,
  `ieea_customer_id` int(11) DEFAULT NULL,
  `ieea_status` varchar(100) DEFAULT NULL,
  `ieea_date` date DEFAULT NULL,
  `ieea_owner` int(11) DEFAULT NULL,
  `ieea_created` int(11) DEFAULT NULL,
  `ieea_created_by` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_batch`
--

CREATE TABLE `i_ext_ed_batch` (
  `iextb_id` int(11) NOT NULL,
  `iextb_batch_name` varchar(100) DEFAULT NULL,
  `iextb_year` int(11) DEFAULT NULL,
  `iextb_status` varchar(50) DEFAULT NULL,
  `iextb_owner` int(11) DEFAULT NULL,
  `iextb_created` datetime DEFAULT NULL,
  `iextb_created_by` int(11) DEFAULT NULL,
  `iextb_modifed` datetime DEFAULT NULL,
  `iextb_modified_by` int(11) DEFAULT NULL,
  `iextb_course` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_batch_allot`
--

CREATE TABLE `i_ext_ed_batch_allot` (
  `iextba_id` int(11) NOT NULL,
  `iextba_batch_id` int(11) DEFAULT NULL,
  `iextba_customer_id` int(11) DEFAULT NULL,
  `iextba_created` datetime DEFAULT NULL,
  `iextba_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_chapters`
--

CREATE TABLE `i_ext_ed_chapters` (
  `iextc_id` int(11) NOT NULL,
  `iextc_subject` int(11) DEFAULT NULL,
  `iextc_name` varchar(100) DEFAULT NULL,
  `iextc_min_hours` int(11) DEFAULT NULL,
  `iextc_max_hours` int(11) DEFAULT NULL,
  `iextc_owner` int(11) DEFAULT NULL,
  `iextc_created` datetime DEFAULT NULL,
  `iextc_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_exam_schedule`
--

CREATE TABLE `i_ext_ed_exam_schedule` (
  `iextes_id` int(11) NOT NULL,
  `iextes_batch_id` int(11) DEFAULT NULL,
  `iextes_subject_id` int(11) DEFAULT NULL,
  `iextes_type` varchar(100) DEFAULT NULL,
  `iextes_chapter_id` int(11) DEFAULT NULL,
  `iextes_preliem_id` int(11) DEFAULT NULL,
  `iextes_from_date` datetime DEFAULT NULL,
  `iextes_to_date` datetime DEFAULT NULL,
  `iextes_notes` varchar(500) DEFAULT NULL,
  `iextes_owner` int(11) DEFAULT NULL,
  `iextes_created` datetime DEFAULT NULL,
  `iextes_created_by` int(11) DEFAULT NULL,
  `iextes_modified` datetime DEFAULT NULL,
  `iextes_modified_by` int(11) DEFAULT NULL,
  `iextes_att_status` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_expenses`
--

CREATE TABLE `i_ext_ed_expenses` (
  `iexte_id` int(11) NOT NULL,
  `iexte_details` varchar(300) DEFAULT NULL,
  `iexte_amount` float DEFAULT NULL,
  `iexte_date` date DEFAULT NULL,
  `iexte_owner` int(11) DEFAULT NULL,
  `iexte_created` datetime DEFAULT NULL,
  `iexte_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_expense_tag`
--

CREATE TABLE `i_ext_ed_expense_tag` (
  `iextet_id` int(11) NOT NULL,
  `iextet_e_id` int(11) DEFAULT NULL,
  `iextet_tag_id` int(11) DEFAULT NULL,
  `iextet_created` datetime DEFAULT NULL,
  `iextet_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_external_exams`
--

CREATE TABLE `i_ext_ed_external_exams` (
  `iextee_id` int(11) NOT NULL,
  `iextee_batch_id` int(11) DEFAULT NULL,
  `iextee_subject_id` int(11) DEFAULT NULL,
  `iextee_name` varchar(100) DEFAULT NULL,
  `iextee_date` datetime DEFAULT NULL,
  `iextee_owner` int(11) DEFAULT NULL,
  `iextee_created` datetime DEFAULT NULL,
  `iextee_created_by` int(11) DEFAULT NULL,
  `iextee_modified` datetime DEFAULT NULL,
  `iextee_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_fees`
--

CREATE TABLE `i_ext_ed_fees` (
  `iextf_id` int(11) NOT NULL,
  `iextf_customer_id` int(11) DEFAULT NULL,
  `iextf_total_fee` float DEFAULT NULL,
  `iextf_paid_fee` float DEFAULT NULL,
  `iextf_balance_fee` float DEFAULT NULL,
  `iextf_paid_date` datetime DEFAULT NULL,
  `iextf_medium` varchar(100) DEFAULT NULL,
  `iextf_details` varchar(200) DEFAULT NULL,
  `iextf_receipt` int(11) DEFAULT NULL,
  `iextf_status` varchar(50) DEFAULT NULL,
  `iextf_owner` int(11) DEFAULT NULL,
  `iextf_created` datetime DEFAULT NULL,
  `iextf_created_by` int(11) DEFAULT NULL,
  `iextf_modifed` datetime DEFAULT NULL,
  `iextf_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_followup`
--

CREATE TABLE `i_ext_ed_followup` (
  `iextfu_id` int(11) NOT NULL,
  `iextfu_module` varchar(100) DEFAULT NULL,
  `iextfu_customer_id` int(11) DEFAULT NULL,
  `iextfu_followup` datetime DEFAULT NULL,
  `iextfu_remind` datetime DEFAULT NULL,
  `iextfu_remarks` varchar(300) DEFAULT NULL,
  `iextfu_status` varchar(10) DEFAULT NULL,
  `iextfu_owner` int(11) DEFAULT NULL,
  `iextfu_created` datetime DEFAULT NULL,
  `iextfu_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_homework`
--

CREATE TABLE `i_ext_ed_homework` (
  `ieeh_id` int(11) NOT NULL,
  `ieeh_event` varchar(50) DEFAULT NULL,
  `ieeh_event_id` int(11) DEFAULT NULL,
  `ieeh_customer_id` int(11) DEFAULT NULL,
  `ieeh_status` varchar(100) DEFAULT NULL,
  `ieeh_date` date DEFAULT NULL,
  `ieeh_owner` int(11) DEFAULT NULL,
  `ieeh_created` int(11) DEFAULT NULL,
  `ieeh_created_by` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_lecture_schedule`
--

CREATE TABLE `i_ext_ed_lecture_schedule` (
  `iextls_id` int(11) NOT NULL,
  `iextls_batch_id` int(11) DEFAULT NULL,
  `iextls_subject_id` int(11) DEFAULT NULL,
  `iextls_chapter_id` int(11) DEFAULT NULL,
  `iextls_teacher_id` int(11) DEFAULT NULL,
  `iextls_from_date` datetime DEFAULT NULL,
  `iextls_to_date` datetime DEFAULT NULL,
  `iextls_notes` varchar(500) DEFAULT NULL,
  `iextls_owner` int(11) DEFAULT NULL,
  `iextls_created` datetime DEFAULT NULL,
  `iextls_created_by` int(11) DEFAULT NULL,
  `iextls_modified` datetime DEFAULT NULL,
  `iextls_modified_by` int(11) DEFAULT NULL,
  `iextls_att_status` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_marks`
--

CREATE TABLE `i_ext_ed_marks` (
  `iextm_id` int(11) NOT NULL,
  `iextm_event` varchar(100) DEFAULT NULL,
  `iextm_event_id` int(11) DEFAULT NULL,
  `iextm_owner` int(11) DEFAULT NULL,
  `iextm_created` datetime DEFAULT NULL,
  `iextm_created_by` int(11) DEFAULT NULL,
  `iextm_modified` datetime DEFAULT NULL,
  `iextm_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_marks_records`
--

CREATE TABLE `i_ext_ed_marks_records` (
  `iextmr_id` int(11) NOT NULL,
  `iextmr_m_id` int(11) DEFAULT NULL,
  `iextmr_customer_id` int(11) DEFAULT NULL,
  `iextmr_marks_obt` float DEFAULT NULL,
  `iextmr_out_of` float DEFAULT NULL,
  `iextmr_grade` varchar(10) DEFAULT NULL,
  `iextmr_details` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_marks_tags`
--

CREATE TABLE `i_ext_ed_marks_tags` (
  `iextemt_id` int(11) NOT NULL,
  `iextemt_m_id` int(11) DEFAULT NULL,
  `iextemt_tag_id` int(11) DEFAULT NULL,
  `iextet_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_preliem`
--

CREATE TABLE `i_ext_ed_preliem` (
  `iextp_id` int(11) NOT NULL,
  `iextp_subject_id` int(11) DEFAULT NULL,
  `iextp_preliem_name` varchar(100) DEFAULT NULL,
  `iextp_owner` int(11) DEFAULT NULL,
  `iextp_created` datetime DEFAULT NULL,
  `iextp_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_punishment`
--

CREATE TABLE `i_ext_ed_punishment` (
  `ieep_id` int(11) NOT NULL,
  `ieep_event` varchar(50) DEFAULT NULL,
  `ieep_event_id` int(11) DEFAULT NULL,
  `ieep_customer_id` int(11) DEFAULT NULL,
  `ieep_details` varchar(200) DEFAULT NULL,
  `ieep_status` varchar(100) DEFAULT NULL,
  `ieep_date` date DEFAULT NULL,
  `ieep_owner` int(11) DEFAULT NULL,
  `ieep_created` int(11) DEFAULT NULL,
  `ieep_created_by` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_purchases`
--

CREATE TABLE `i_ext_ed_purchases` (
  `iextp_id` int(11) NOT NULL,
  `iextp_c_id` int(11) DEFAULT NULL,
  `iextp_txn_no` varchar(100) DEFAULT NULL,
  `iextp_amount` float DEFAULT NULL,
  `iextp_date` date DEFAULT NULL,
  `iextp_detail` varchar(300) DEFAULT NULL,
  `iextp_owner` int(11) DEFAULT NULL,
  `iextp_created` datetime DEFAULT NULL,
  `iextp_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_purchase_document`
--

CREATE TABLE `i_ext_ed_purchase_document` (
  `iextpd_id` int(11) NOT NULL,
  `iextpd_p_id` int(11) DEFAULT NULL,
  `iextpd_document` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_purchase_tag`
--

CREATE TABLE `i_ext_ed_purchase_tag` (
  `iextpt_id` int(11) NOT NULL,
  `iextpt_e_id` int(11) DEFAULT NULL,
  `iextpt_tag_id` int(11) DEFAULT NULL,
  `iextpt_created` datetime DEFAULT NULL,
  `iextpt_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_receipt`
--

CREATE TABLE `i_ext_ed_receipt` (
  `iextr_id` int(11) NOT NULL,
  `iextr_c_id` int(11) DEFAULT NULL,
  `iextr_owner` int(11) DEFAULT NULL,
  `iextr_created` datetime DEFAULT NULL,
  `iextr_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_subjects`
--

CREATE TABLE `i_ext_ed_subjects` (
  `iexts_id` int(11) NOT NULL,
  `iexts_name` varchar(100) DEFAULT NULL,
  `iexts_owner` int(11) DEFAULT NULL,
  `iexts_created` datetime DEFAULT NULL,
  `iexts_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_teachers`
--

CREATE TABLE `i_ext_ed_teachers` (
  `iextt_id` int(11) NOT NULL,
  `iextt_subject` int(11) DEFAULT NULL,
  `iextt_t_id` int(11) DEFAULT NULL,
  `iextt_salary_type` varchar(100) DEFAULT NULL,
  `iextt_amount` int(11) DEFAULT NULL,
  `iextt_owner` int(11) DEFAULT NULL,
  `iextt_created` datetime DEFAULT NULL,
  `iextt_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_teacher_subjects`
--

CREATE TABLE `i_ext_ed_teacher_subjects` (
  `iextts_id` int(11) NOT NULL,
  `iextts_t_id` int(11) DEFAULT NULL,
  `iextts_s_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_tips`
--

CREATE TABLE `i_ext_ed_tips` (
  `iexttp_id` int(11) NOT NULL,
  `iexttp_tip` varchar(500) DEFAULT NULL,
  `iexttp_owner` int(11) DEFAULT NULL,
  `iexttp_created` int(11) DEFAULT NULL,
  `iexttp_created_by` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_ed_tip_tags`
--

CREATE TABLE `i_ext_ed_tip_tags` (
  `iexttt_id` int(11) NOT NULL,
  `iexttt_tip_id` int(11) DEFAULT NULL,
  `iexttt_tag_id` int(11) DEFAULT NULL,
  `iexttt_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_ac_classes`
--

CREATE TABLE `i_ext_et_ac_classes` (
  `iextetacc_id` int(11) NOT NULL,
  `iextetacc_name` varchar(100) DEFAULT NULL,
  `iextetacc_owner` int(11) DEFAULT NULL,
  `iextetacc_created` datetime DEFAULT NULL,
  `iextetacc_created_by` int(11) DEFAULT NULL,
  `iextetacc_modified` datetime DEFAULT NULL,
  `iextetacc_modified_by` int(11) DEFAULT NULL,
  `iextetacc_type` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_ac_classes`
--

INSERT INTO `i_ext_et_ac_classes` (`iextetacc_id`, `iextetacc_name`, `iextetacc_owner`, `iextetacc_created`, `iextetacc_created_by`, `iextetacc_modified`, `iextetacc_modified_by`, `iextetacc_type`) VALUES
(1, 'Assets', 1, '2019-03-13 15:58:45', 1, NULL, NULL, 'credit'),
(2, 'Liabilities', 1, '2019-03-13 15:59:38', 1, '2019-03-13 16:16:39', 1, 'debit'),
(3, 'Expenses', 1, '2019-03-13 15:59:49', 1, NULL, NULL, 'debit'),
(5, 'Income', 1, '2019-03-13 16:19:38', 1, NULL, NULL, 'credit');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_ac_groups`
--

CREATE TABLE `i_ext_et_ac_groups` (
  `iextetacg_id` int(11) NOT NULL,
  `iextetacg_name` varchar(100) DEFAULT NULL,
  `iextetacg_parent_id` int(11) DEFAULT NULL,
  `iextetacg_class_id` int(11) DEFAULT NULL,
  `iextetacg_owner` int(11) DEFAULT NULL,
  `iextetacg_created` datetime DEFAULT NULL,
  `iextetacg_created_by` int(11) DEFAULT NULL,
  `iextetacg_modified` datetime DEFAULT NULL,
  `iextetacg_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_ac_groups`
--

INSERT INTO `i_ext_et_ac_groups` (`iextetacg_id`, `iextetacg_name`, `iextetacg_parent_id`, `iextetacg_class_id`, `iextetacg_owner`, `iextetacg_created`, `iextetacg_created_by`, `iextetacg_modified`, `iextetacg_modified_by`) VALUES
(1, 'Current Assets', 0, 1, 1, '2019-03-13 16:08:20', 1, NULL, NULL),
(2, 'Bank Account', 1, 1, 1, '2019-03-13 16:25:31', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_ac_journal_entries`
--

CREATE TABLE `i_ext_et_ac_journal_entries` (
  `iextetacje_id` int(11) NOT NULL,
  `iextetacje_from` int(11) DEFAULT NULL,
  `iextetacje_to` int(11) DEFAULT NULL,
  `iextetacje_description` varchar(500) DEFAULT NULL,
  `iextetacje_amount` float DEFAULT NULL,
  `iextetacje_date` date DEFAULT NULL,
  `iextetacje_link_type` varchar(100) DEFAULT NULL,
  `iextetacje_link_id` int(11) DEFAULT NULL,
  `iextetacje_owner` int(11) DEFAULT NULL,
  `iextetacje_created` datetime DEFAULT NULL,
  `iextetacje_created_by` int(11) DEFAULT NULL,
  `iextetacje_modified` datetime DEFAULT NULL,
  `iextetacje_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_ac_journal_entries`
--

INSERT INTO `i_ext_et_ac_journal_entries` (`iextetacje_id`, `iextetacje_from`, `iextetacje_to`, `iextetacje_description`, `iextetacje_amount`, `iextetacje_date`, `iextetacje_link_type`, `iextetacje_link_id`, `iextetacje_owner`, `iextetacje_created`, `iextetacje_created_by`, `iextetacje_modified`, `iextetacje_modified_by`) VALUES
(1, 2, 4, 'invoice', 1000, '2019-03-13', 'Manual', 0, 1, '2019-03-13 18:03:17', 1, NULL, NULL),
(2, 6, 2, 'invoice_pay', 800, '2019-03-13', 'Manual', 0, 1, '2019-03-13 18:03:17', 1, NULL, NULL),
(3, 5, 3, 'purchase_inovice', 2000, '2019-03-13', 'Manual', 0, 1, '2019-03-13 18:03:17', 1, NULL, NULL),
(4, 3, 6, 'purchase_invoice_pay', 1800, '2019-03-13', 'Manual', 0, 1, '2019-03-13 18:03:17', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_ac_ledgers`
--

CREATE TABLE `i_ext_et_ac_ledgers` (
  `iextetacl_id` int(11) NOT NULL,
  `iextetacl_name` varchar(100) DEFAULT NULL,
  `iextetacl_group_id` int(11) DEFAULT NULL,
  `iextetacl_owner` int(11) DEFAULT NULL,
  `iextetacl_created` datetime DEFAULT NULL,
  `iextetacl_created_by` int(11) DEFAULT NULL,
  `iextetacl_modified` datetime DEFAULT NULL,
  `iextetacl_modified_by` int(11) DEFAULT NULL,
  `iextetacl_starred` int(11) DEFAULT NULL,
  `iextetacl_link` varchar(100) DEFAULT NULL,
  `iextetacl_link_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_ac_ledgers`
--

INSERT INTO `i_ext_et_ac_ledgers` (`iextetacl_id`, `iextetacl_name`, `iextetacl_group_id`, `iextetacl_owner`, `iextetacl_created`, `iextetacl_created_by`, `iextetacl_modified`, `iextetacl_modified_by`, `iextetacl_starred`, `iextetacl_link`, `iextetacl_link_id`) VALUES
(1, 'welcome', 2, 1, '2019-03-13 17:31:15', 1, '2019-03-13 17:44:10', 1, 1, 'contact', 0),
(2, 'Customer', 0, 1, '2019-03-13 18:28:33', 1, NULL, NULL, 0, '0', 0),
(3, 'Vendor', 0, 1, '2019-03-13 18:28:46', 1, NULL, NULL, 0, '0', 0),
(4, 'sales-account', 0, 1, '2019-03-13 18:29:12', 1, NULL, NULL, 0, '0', 0),
(5, 'purchase_account', 0, 1, '2019-03-13 18:29:26', 1, NULL, NULL, 0, '0', 0),
(6, 'cash', 0, 1, '2019-03-13 18:29:34', 1, NULL, NULL, 0, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc`
--

CREATE TABLE `i_ext_et_amc` (
  `iextamc_id` int(11) NOT NULL,
  `iextamc_customer_id` int(11) DEFAULT NULL,
  `iextamc_txn_id` varchar(100) DEFAULT NULL,
  `iextamc_txn_date` date DEFAULT NULL,
  `iextamc_period_from` date DEFAULT NULL,
  `iextamc_period_to` date DEFAULT NULL,
  `iextamc_type` varchar(100) DEFAULT NULL,
  `iextamc_amount` varchar(100) DEFAULT NULL,
  `iextamc_status` varchar(100) DEFAULT NULL,
  `iextamc_note` varchar(500) DEFAULT NULL,
  `iextamc_owner` int(11) DEFAULT NULL,
  `iextamc_created` datetime DEFAULT NULL,
  `iextamc_created_by` int(11) DEFAULT NULL,
  `iextamc_modified` datetime DEFAULT NULL,
  `iextamc_modified_by` int(11) DEFAULT NULL,
  `iextamc_discount` varchar(100) DEFAULT NULL,
  `iextamc_total` int(11) DEFAULT NULL,
  `iextamc_tax` int(11) DEFAULT NULL,
  `iextamc_gid` int(11) DEFAULT NULL,
  `iextamc_sheduled` varchar(50) DEFAULT NULL,
  `iextamc_amc_type` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_amc`
--

INSERT INTO `i_ext_et_amc` (`iextamc_id`, `iextamc_customer_id`, `iextamc_txn_id`, `iextamc_txn_date`, `iextamc_period_from`, `iextamc_period_to`, `iextamc_type`, `iextamc_amount`, `iextamc_status`, `iextamc_note`, `iextamc_owner`, `iextamc_created`, `iextamc_created_by`, `iextamc_modified`, `iextamc_modified_by`, `iextamc_discount`, `iextamc_total`, `iextamc_tax`, `iextamc_gid`, `iextamc_sheduled`, `iextamc_amc_type`) VALUES
(13, 1, '1234', '2019-05-16', '2019-05-16', '2019-05-31', 'formal', '1234', 'open', '', 1, '2019-05-16 11:10:14', 1, '2019-05-16 11:10:34', 1, NULL, NULL, 0, 0, 'monthly', 'com'),
(12, 1, '1234', '2019-05-08', '2019-05-08', '2020-05-08', 'formal', '20000', 'active', '', 1, '2019-05-08 10:40:17', 1, '2019-05-08 11:56:22', 1, NULL, NULL, 0, 31, 'monthly', 'com');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc_mutual`
--

CREATE TABLE `i_ext_et_amc_mutual` (
  `iextamcm_id` int(11) NOT NULL,
  `iextamcm_pid` int(11) DEFAULT NULL,
  `iextamcm_uid` int(11) DEFAULT NULL,
  `iextamcm_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc_product_details`
--

CREATE TABLE `i_ext_et_amc_product_details` (
  `iextamcpd_id` int(11) NOT NULL,
  `iextamcpd_d_id` int(11) DEFAULT NULL,
  `iextamcpd_product_id` int(11) DEFAULT NULL,
  `iextamcpd_model_number` varchar(100) DEFAULT NULL,
  `iextamcpd_serial_number` varchar(100) DEFAULT NULL,
  `iextamcpd_rate` float DEFAULT NULL,
  `iextamcpd_qty` float DEFAULT NULL,
  `iextamcpd_discount` varchar(10) DEFAULT NULL,
  `iextamcpd_amount` float DEFAULT NULL,
  `iextamcpd_tax` int(11) DEFAULT NULL,
  `iextamcpd_tax_amount` float DEFAULT NULL,
  `iextamcpd_owner` int(11) DEFAULT NULL,
  `iextamcpd_alias` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_amc_product_details`
--

INSERT INTO `i_ext_et_amc_product_details` (`iextamcpd_id`, `iextamcpd_d_id`, `iextamcpd_product_id`, `iextamcpd_model_number`, `iextamcpd_serial_number`, `iextamcpd_rate`, `iextamcpd_qty`, `iextamcpd_discount`, `iextamcpd_amount`, `iextamcpd_tax`, `iextamcpd_tax_amount`, `iextamcpd_owner`, `iextamcpd_alias`) VALUES
(1, 1, 154, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(2, 1, 155, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(3, 1, 156, NULL, '', NULL, 4, NULL, NULL, NULL, NULL, 188, 'NULL'),
(4, 1, 157, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(5, 1, 157, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(6, 2, 168, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(7, 2, 154, NULL, '', NULL, 20, NULL, NULL, NULL, NULL, 188, 'NULL'),
(8, 2, 165, NULL, '', NULL, 2, NULL, NULL, NULL, NULL, 188, 'NULL'),
(9, 2, 166, NULL, '', NULL, 5, NULL, NULL, NULL, NULL, 188, 'NULL'),
(10, 2, 167, NULL, '', NULL, 6, NULL, NULL, NULL, NULL, 188, 'NULL'),
(11, 3, 350, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(12, 3, 351, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(13, 3, 352, NULL, '', NULL, 4, NULL, NULL, NULL, NULL, 188, 'NULL'),
(14, 3, 353, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(15, 3, 353, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(16, 4, 364, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 188, 'NULL'),
(17, 4, 350, NULL, '', NULL, 20, NULL, NULL, NULL, NULL, 188, 'NULL'),
(18, 4, 361, NULL, '', NULL, 2, NULL, NULL, NULL, NULL, 188, 'NULL'),
(19, 4, 362, NULL, '', NULL, 5, NULL, NULL, NULL, NULL, 188, 'NULL'),
(20, 4, 363, NULL, '', NULL, 6, NULL, NULL, NULL, NULL, 188, 'NULL'),
(30, 5, 393, NULL, '12', NULL, 12, NULL, NULL, NULL, NULL, 188, 'false'),
(32, 7, 393, NULL, '', NULL, 12, NULL, NULL, NULL, NULL, 188, 'false'),
(33, 8, 393, NULL, '12', NULL, 12, NULL, NULL, NULL, NULL, 188, 'false'),
(37, 9, 393, NULL, '12', NULL, 12, NULL, NULL, NULL, NULL, 188, 'false'),
(1672, 13, 394, NULL, '12', NULL, 12, NULL, NULL, NULL, NULL, 1, 'false'),
(1671, 12, 395, NULL, '1000', NULL, 10, NULL, NULL, NULL, NULL, 1, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc_property`
--

CREATE TABLE `i_ext_et_amc_property` (
  `iextamcpt_id` int(11) NOT NULL,
  `iextamcpt_inid` int(11) DEFAULT NULL,
  `iextamcpt_property_value` varchar(200) DEFAULT NULL,
  `iextamcpt_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_amc_property`
--

INSERT INTO `i_ext_et_amc_property` (`iextamcpt_id`, `iextamcpt_inid`, `iextamcpt_property_value`, `iextamcpt_status`) VALUES
(164, NULL, 'Maharashtra', 'true'),
(165, NULL, '400011', 'true'),
(166, NULL, '18/48', 'true'),
(167, NULL, 'krishnakant@evomata.com', 'true'),
(168, NULL, '9821406714', 'true'),
(169, NULL, '9821227324', 'false'),
(170, NULL, 'RO NO,7 SHANTI NIWAS PATEL CHAWL, TEMBHIPADA, GAONDEVI ROAD, BHANDUP (W)', 'false'),
(171, NULL, '400078', 'false'),
(172, NULL, 'BRIGHT ANGELS ENGLISH SCHOOL, GANESH NAGAR GANESH PATH BHANDUP (W).MUMBAI', 'false'),
(225, 39, '9821406714', 'true'),
(226, 39, 'Maharashtra', 'true'),
(227, 39, '400011', 'false'),
(228, 39, 'Lower Parel, Mumbai', 'true'),
(229, 39, 'kpatole2@gmail.com', 'true'),
(253, 30, 'krishnakant@evomata.com', 'true'),
(265, 47, 'krishnakant@evomata.com', 'false'),
(266, 48, 'Maharashtra', 'true'),
(267, 48, '400011', 'false'),
(268, 48, '18/48', 'true'),
(269, 48, 'krishnakant@evomata.com', 'true'),
(270, 48, '9821406714', 'true'),
(271, 49, 'Maharashtra', 'true'),
(272, 49, '400011', 'false'),
(273, 49, '18/48', 'true'),
(274, 49, 'krishnakant@evomata.com', 'true'),
(275, 49, '9821406714', 'true'),
(276, 50, 'Maharashtra', 'true'),
(277, 50, '400011', 'false'),
(278, 50, '18/48', 'true'),
(279, 50, 'krishnakant@evomata.com', 'true'),
(280, 50, '9821406714', 'true'),
(281, 51, 'Maharashtra', 'true'),
(282, 51, '400011', 'false'),
(283, 51, '18/48', 'true'),
(284, 51, 'krishnakant@evomata.com', 'true'),
(285, 51, '9821406714', 'true'),
(286, 52, 'Maharashtra', 'true'),
(287, 52, '400011', 'false'),
(288, 52, '18/48', 'true'),
(289, 52, 'krishnakant@evomata.com', 'true'),
(290, 52, '9821406714', 'true'),
(291, 53, 'Maharashtra', 'true'),
(292, 53, '400011', 'false'),
(293, 53, '18/48', 'true'),
(294, 53, 'krishnakant@evomata.com', 'true'),
(295, 53, '9821406714', 'true'),
(296, 54, 'Maharashtra', 'true'),
(297, 54, '400011', 'false'),
(298, 54, '18/48', 'true'),
(299, 54, 'krishnakant@evomata.com', 'true'),
(300, 54, '9821406714', 'true'),
(301, 55, 'Maharashtra', 'true'),
(302, 55, '400011', 'false'),
(303, 55, '18/48', 'true'),
(304, 55, 'krishnakant@evomata.com', 'true'),
(305, 55, '9821406714', 'true'),
(306, 56, 'vinayalokhande1993@gmail.com', 'false'),
(307, 56, '400011', 'false'),
(308, 56, 'maharashtra', 'false'),
(309, 56, '2227794086', 'false'),
(310, 56, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(311, 56, '400708', 'false'),
(312, 56, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(313, 57, 'vinayalokhande1993@gmail.com', 'false'),
(314, 57, '400011', 'false'),
(315, 57, 'maharashtra', 'false'),
(316, 57, '2227794086', 'false'),
(317, 57, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(318, 57, '400708', 'false'),
(319, 57, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(320, 45, 'vinayalokhande1993@gmail.com', 'false'),
(321, 45, '400011', 'false'),
(322, 45, 'maharashtra', 'false'),
(323, 45, '2227794086', 'false'),
(324, 45, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(325, 45, '400708', 'false'),
(326, 45, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(337, 36, '9821406714', 'false'),
(338, 36, 'Maharashtra', 'false'),
(339, 36, '400011', 'false'),
(340, 36, 'Lower Parel, Mumbai', 'false'),
(341, 36, 'kpatole2@gmail.com', 'true'),
(342, 58, 'Maharashtra', 'true'),
(343, 58, '400011', 'false'),
(344, 58, '18/48', 'true'),
(345, 58, 'krishnakant@evomata.com', 'true'),
(346, 58, '9821406714', 'true'),
(352, 59, 'Maharashtra', 'true'),
(353, 59, '400011', 'false'),
(354, 59, '18/48', 'true'),
(355, 59, 'krishnakant@evomata.com', 'true'),
(356, 59, '9821406714', 'true'),
(357, 37, 'krishnakant@evomata.com', 'false'),
(359, 60, 'krishnakant@evomata.com', 'true'),
(360, 61, 'Maharashtra', 'true'),
(361, 61, '400011', 'false'),
(362, 61, '18/48', 'true'),
(363, 61, 'krishnakant@evomata.com', 'true'),
(364, 61, '9821406714', 'true'),
(365, 62, 'Maharashtra', 'true'),
(366, 62, '400011', 'false'),
(367, 62, '18/48', 'true'),
(368, 62, 'krishnakant@evomata.com', 'true'),
(369, 62, '9821406714', 'true'),
(370, 63, 'Maharashtra', 'true'),
(371, 63, '400011', 'false'),
(372, 63, '18/48', 'true'),
(373, 63, 'krishnakant@evomata.com', 'true'),
(374, 63, '9821406714', 'true'),
(375, 64, 'Maharashtra', 'true'),
(376, 64, '400011', 'false'),
(377, 64, '18/48', 'true'),
(378, 64, 'krishnakant@evomata.com', 'true'),
(379, 64, '9821406714', 'true'),
(380, 65, 'Maharashtra', 'true'),
(381, 65, '400011', 'false'),
(382, 65, '18/48', 'true'),
(383, 65, 'krishnakant@evomata.com', 'true'),
(384, 65, '9821406714', 'true'),
(385, 66, 'Maharashtra', 'true'),
(386, 66, '400011', 'false'),
(387, 66, '18/48', 'true'),
(388, 66, 'krishnakant@evomata.com', 'true'),
(389, 66, '9821406714', 'true'),
(390, 67, 'Maharashtra', 'true'),
(391, 67, '400011', 'false'),
(392, 67, '18/48', 'true'),
(393, 67, 'krishnakant@evomata.com', 'true'),
(394, 67, '9821406714', 'true'),
(395, 68, 'Maharashtra', 'true'),
(396, 68, '400011', 'false'),
(397, 68, '18/48', 'true'),
(398, 68, 'krishnakant@evomata.com', 'true'),
(399, 68, '9821406714', 'true'),
(400, 69, 'Maharashtra', 'true'),
(401, 69, '400011', 'false'),
(402, 69, '18/48', 'true'),
(403, 69, 'krishnakant@evomata.com', 'true'),
(404, 69, '9821406714', 'true'),
(405, 70, 'Maharashtra', 'true'),
(406, 70, '400011', 'false'),
(407, 70, '18/48', 'true'),
(408, 70, 'krishnakant@evomata.com', 'true'),
(409, 70, '9821406714', 'true'),
(419, 5, 'kpatole2@gmail.com', 'false'),
(421, 7, 'krishnakant@evomata.com', 'false'),
(422, 8, 'krishnakant@evomata.com', 'false'),
(426, 9, 'krishnakant@evomata.com', 'false'),
(429, 13, 'krishnakant@evomata.com', 'false'),
(430, 13, '18/48 harharwala bldg. n. m. joshi marg mumbai 400011.', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc_tags`
--

CREATE TABLE `i_ext_et_amc_tags` (
  `iextamctg_id` int(11) NOT NULL,
  `iextamctg_txn_id` int(11) DEFAULT NULL,
  `iextamctg_tag_id` int(11) DEFAULT NULL,
  `iextamctg_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc_task`
--

CREATE TABLE `i_ext_et_amc_task` (
  `iextamct_id` int(11) NOT NULL,
  `iextamct_owner` int(11) DEFAULT NULL,
  `iextamct_created_by` int(11) DEFAULT NULL,
  `iextamct_gid` int(11) DEFAULT NULL,
  `iextamct_aid` int(11) DEFAULT NULL,
  `iextamct_code` varchar(100) DEFAULT NULL,
  `iextamct_amc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_amc_task`
--

INSERT INTO `i_ext_et_amc_task` (`iextamct_id`, `iextamct_owner`, `iextamct_created_by`, `iextamct_gid`, `iextamct_aid`, `iextamct_code`, `iextamct_amc_id`) VALUES
(1, 1, 1, 0, 1, '681533', 12);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc_taxes`
--

CREATE TABLE `i_ext_et_amc_taxes` (
  `iextamct_id` int(11) NOT NULL,
  `iextamct_d_id` int(11) DEFAULT NULL,
  `iextamct_t_id` int(11) DEFAULT NULL,
  `iextamct_t_name` varchar(100) DEFAULT NULL,
  `iextamct_t_percent` float DEFAULT NULL,
  `iextamct_t_amount` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_amc_terms`
--

CREATE TABLE `i_ext_et_amc_terms` (
  `iextamctm_id` int(11) NOT NULL,
  `iextamctm_inid` int(11) DEFAULT NULL,
  `iextamctm_term_id` int(11) DEFAULT NULL,
  `iextamctm_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_amc_terms`
--

INSERT INTO `i_ext_et_amc_terms` (`iextamctm_id`, `iextamctm_inid`, `iextamctm_term_id`, `iextamctm_status`) VALUES
(121, 39, 66, 'true'),
(122, 39, 67, 'false'),
(133, 30, 66, 'false'),
(134, 30, 67, 'false'),
(147, 47, 66, 'false'),
(148, 47, 67, 'false'),
(149, 48, 66, 'false'),
(150, 48, 67, 'false'),
(151, 49, 66, 'false'),
(152, 49, 67, 'false'),
(153, 50, 66, 'false'),
(154, 50, 67, 'false'),
(155, 51, 66, 'false'),
(156, 51, 67, 'false'),
(157, 52, 66, 'false'),
(158, 52, 67, 'false'),
(159, 53, 66, 'false'),
(160, 53, 67, 'false'),
(161, 54, 66, 'false'),
(162, 54, 67, 'false'),
(163, 55, 66, 'false'),
(164, 55, 67, 'false'),
(165, 56, 66, 'false'),
(166, 56, 67, 'false'),
(167, 57, 66, 'false'),
(168, 57, 67, 'false'),
(169, 45, 66, 'false'),
(170, 45, 67, 'false'),
(175, 36, 66, 'true'),
(176, 36, 67, 'false'),
(177, 58, 66, 'false'),
(178, 58, 67, 'false'),
(181, 59, 66, 'false'),
(182, 59, 67, 'false'),
(183, 37, 66, 'true'),
(184, 37, 67, 'false'),
(187, 60, 66, 'false'),
(188, 60, 67, 'false'),
(189, 61, 66, 'false'),
(190, 61, 67, 'false'),
(191, 62, 66, 'false'),
(192, 62, 67, 'false'),
(193, 63, 66, 'false'),
(194, 63, 67, 'false'),
(195, 64, 66, 'false'),
(196, 64, 67, 'false'),
(197, 65, 66, 'false'),
(198, 65, 67, 'false'),
(199, 66, 66, 'false'),
(200, 66, 67, 'false'),
(201, 67, 66, 'false'),
(202, 67, 67, 'false'),
(203, 68, 66, 'false'),
(204, 68, 67, 'false'),
(205, 69, 66, 'false'),
(206, 69, 67, 'false'),
(207, 70, 66, 'false'),
(208, 70, 67, 'false'),
(212, 9, 30, 'true'),
(213, 9, 31, 'true'),
(309, 12, 46, 'true'),
(310, 12, 47, 'true'),
(311, 12, 48, 'true'),
(312, 12, 49, 'true'),
(317, 13, 46, 'false'),
(318, 13, 47, 'false'),
(319, 13, 48, 'false'),
(320, 13, 49, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_barcode`
--

CREATE TABLE `i_ext_et_barcode` (
  `iextb_id` int(11) NOT NULL,
  `iextb_pid` int(11) DEFAULT NULL,
  `iextb_qty` int(11) DEFAULT NULL,
  `iextb_barcode_type` varchar(50) DEFAULT NULL,
  `iextb_code` varchar(100) DEFAULT NULL,
  `iextb_owner` int(11) DEFAULT NULL,
  `iextb_created` datetime DEFAULT NULL,
  `iextb_created_by` int(11) DEFAULT NULL,
  `iextb_modify` datetime DEFAULT NULL,
  `iextb_modified_by` int(11) DEFAULT NULL,
  `iextb_title` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_barcode`
--

INSERT INTO `i_ext_et_barcode` (`iextb_id`, `iextb_pid`, `iextb_qty`, `iextb_barcode_type`, `iextb_code`, `iextb_owner`, `iextb_created`, `iextb_created_by`, `iextb_modify`, `iextb_modified_by`, `iextb_title`) VALUES
(11, 8, 10, 'same', '1234', 188, '2019-02-21 16:16:21', 188, NULL, NULL, NULL),
(12, 1, 10, 'individual', '99999', 188, '2019-02-22 13:21:06', 188, NULL, NULL, NULL),
(13, 419, 100, 'individual', '121', 19, '2019-06-12 15:04:35', 22, NULL, NULL, 'Krishna'),
(14, 403, 12, 'individual', '2121212', 1, '2019-06-20 10:40:31', 1, NULL, NULL, 'test'),
(15, 422, 30, 'individual', '1234', 4, '2019-06-20 12:37:23', 4, NULL, NULL, 'Silver Stand');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_barcode_design`
--

CREATE TABLE `i_ext_et_barcode_design` (
  `iextbd_id` int(11) NOT NULL,
  `iextbd_file` varchar(200) DEFAULT NULL,
  `iextbd_owner` int(11) DEFAULT NULL,
  `iextbd_created` datetime DEFAULT NULL,
  `iextbd_created_by` int(11) DEFAULT NULL,
  `iextbd_modified` datetime DEFAULT NULL,
  `iextbd_modified_by` int(11) DEFAULT NULL,
  `iextbd_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_barcode_design`
--

INSERT INTO `i_ext_et_barcode_design` (`iextbd_id`, `iextbd_file`, `iextbd_owner`, `iextbd_created`, `iextbd_created_by`, `iextbd_modified`, `iextbd_modified_by`, `iextbd_gid`) VALUES
(8, '156042177919.json', 19, '2019-06-13 15:59:39', 19, NULL, NULL, 36),
(9, '15610083991.json', 1, '2019-06-20 10:56:39', 1, NULL, NULL, 1),
(10, '15610145124.json', 4, '2019-06-20 12:38:32', 4, NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_barcode_printing`
--

CREATE TABLE `i_ext_et_barcode_printing` (
  `iextbp_id` int(11) NOT NULL,
  `iextbp_barcode_id` int(11) DEFAULT NULL,
  `iextbp_barcode_serial_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_barcode_printing`
--

INSERT INTO `i_ext_et_barcode_printing` (`iextbp_id`, `iextbp_barcode_id`, `iextbp_barcode_serial_number`) VALUES
(55, 11, 1),
(56, 11, 1),
(57, 11, 1),
(58, 11, 1),
(59, 11, 1),
(60, 11, 1),
(61, 11, 1),
(62, 11, 1),
(63, 11, 1),
(64, 11, 1),
(75, 12, 1),
(76, 12, 2),
(77, 12, 3),
(78, 12, 4),
(79, 12, 5),
(80, 12, 6),
(81, 12, 7),
(82, 12, 8),
(83, 12, 9),
(84, 12, 10),
(85, 13, 1),
(86, 13, 2),
(87, 13, 3),
(88, 13, 4),
(89, 13, 5),
(90, 13, 6),
(91, 13, 7),
(92, 13, 8),
(93, 13, 9),
(94, 13, 10),
(95, 13, 11),
(96, 13, 12),
(97, 13, 13),
(98, 13, 14),
(99, 13, 15),
(100, 13, 16),
(101, 13, 17),
(102, 13, 18),
(103, 13, 19),
(104, 13, 20),
(105, 13, 21),
(106, 13, 22),
(107, 13, 23),
(108, 13, 24),
(109, 13, 25),
(110, 13, 26),
(111, 13, 27),
(112, 13, 28),
(113, 13, 29),
(114, 13, 30),
(115, 13, 31),
(116, 13, 32),
(117, 13, 33),
(118, 13, 34),
(119, 13, 35),
(120, 13, 36),
(121, 13, 37),
(122, 13, 38),
(123, 13, 39),
(124, 13, 40),
(125, 13, 41),
(126, 13, 42),
(127, 13, 43),
(128, 13, 44),
(129, 13, 45),
(130, 13, 46),
(131, 13, 47),
(132, 13, 48),
(133, 13, 49),
(134, 13, 50),
(135, 13, 51),
(136, 13, 52),
(137, 13, 53),
(138, 13, 54),
(139, 13, 55),
(140, 13, 56),
(141, 13, 57),
(142, 13, 58),
(143, 13, 59),
(144, 13, 60),
(145, 13, 61),
(146, 13, 62),
(147, 13, 63),
(148, 13, 64),
(149, 13, 65),
(150, 13, 66),
(151, 13, 67),
(152, 13, 68),
(153, 13, 69),
(154, 13, 70),
(155, 13, 71),
(156, 13, 72),
(157, 13, 73),
(158, 13, 74),
(159, 13, 75),
(160, 13, 76),
(161, 13, 77),
(162, 13, 78),
(163, 13, 79),
(164, 13, 80),
(165, 13, 81),
(166, 13, 82),
(167, 13, 83),
(168, 13, 84),
(169, 13, 85),
(170, 13, 86),
(171, 13, 87),
(172, 13, 88),
(173, 13, 89),
(174, 13, 90),
(175, 13, 91),
(176, 13, 92),
(177, 13, 93),
(178, 13, 94),
(179, 13, 95),
(180, 13, 96),
(181, 13, 97),
(182, 13, 98),
(183, 13, 99),
(184, 13, 100),
(185, 14, 1),
(186, 14, 2),
(187, 14, 3),
(188, 14, 4),
(189, 14, 5),
(190, 14, 6),
(191, 14, 7),
(192, 14, 8),
(193, 14, 9),
(194, 14, 10),
(195, 14, 11),
(196, 14, 12),
(197, 15, 1),
(198, 15, 2),
(199, 15, 3),
(200, 15, 4),
(201, 15, 5),
(202, 15, 6),
(203, 15, 7),
(204, 15, 8),
(205, 15, 9),
(206, 15, 10),
(207, 15, 11),
(208, 15, 12),
(209, 15, 13),
(210, 15, 14),
(211, 15, 15),
(212, 15, 16),
(213, 15, 17),
(214, 15, 18),
(215, 15, 19),
(216, 15, 20),
(217, 15, 21),
(218, 15, 22),
(219, 15, 23),
(220, 15, 24),
(221, 15, 25),
(222, 15, 26),
(223, 15, 27),
(224, 15, 28),
(225, 15, 29),
(226, 15, 30);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_boq`
--

CREATE TABLE `i_ext_et_boq` (
  `iextetboq_id` int(11) NOT NULL,
  `iextetboq_title` varchar(200) DEFAULT NULL,
  `iextetboq_type` varchar(200) DEFAULT NULL,
  `iextetboq_type_id` int(11) DEFAULT NULL,
  `iextetboq_file` varchar(200) DEFAULT NULL,
  `iextetboq_owner` int(11) DEFAULT NULL,
  `iextetboq_created` datetime DEFAULT NULL,
  `iextetboq_created_by` int(11) DEFAULT NULL,
  `iextetboq_modified` datetime DEFAULT NULL,
  `iextetboq_modified_by` int(11) DEFAULT NULL,
  `iextetboq_gid` int(11) DEFAULT NULL,
  `iextetboq_status` varchar(100) DEFAULT NULL,
  `iextetboq_col_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_boq`
--

INSERT INTO `i_ext_et_boq` (`iextetboq_id`, `iextetboq_title`, `iextetboq_type`, `iextetboq_type_id`, `iextetboq_file`, `iextetboq_owner`, `iextetboq_created`, `iextetboq_created_by`, `iextetboq_modified`, `iextetboq_modified_by`, `iextetboq_gid`, `iextetboq_status`, `iextetboq_col_name`) VALUES
(10, 'Request for Proposal - CCTV to be installed at Evomata Innovations OPC Pvt Ltd', NULL, NULL, '1559216336.json', 1, '2019-05-30 14:04:00', 1, NULL, NULL, 0, 'pending', 'Amount');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_boq_fixed`
--

CREATE TABLE `i_ext_et_boq_fixed` (
  `iextetboqf_id` int(11) NOT NULL,
  `iextetboqf_title` varchar(100) DEFAULT NULL,
  `iextetboqf_file` varchar(100) DEFAULT NULL,
  `iextetboqf_owner` int(11) DEFAULT NULL,
  `iextetboqf_created` datetime DEFAULT NULL,
  `iextetboqf_created_by` int(11) DEFAULT NULL,
  `iextetboqf_modified` datetime DEFAULT NULL,
  `iextetboqf_modified_by` int(11) DEFAULT NULL,
  `iextetboqf_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_boq_fixed`
--

INSERT INTO `i_ext_et_boq_fixed` (`iextetboqf_id`, `iextetboqf_title`, `iextetboqf_file`, `iextetboqf_owner`, `iextetboqf_created`, `iextetboqf_created_by`, `iextetboqf_modified`, `iextetboqf_modified_by`, `iextetboqf_gid`) VALUES
(1, 'Krishna', '1556173728.json', 1, '2019-04-24 13:33:52', 1, '2019-04-25 11:58:48', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_boq_mail`
--

CREATE TABLE `i_ext_et_boq_mail` (
  `iextetboqm_id` int(11) NOT NULL,
  `iextetboqm_boq_id` int(11) DEFAULT NULL,
  `iextetboqm_cid` int(11) DEFAULT NULL,
  `iextetboqm_send_date` datetime DEFAULT NULL,
  `iextetboqm_res_date` datetime DEFAULT NULL,
  `iextetboqm_owner` int(11) DEFAULT NULL,
  `iextetboqm_file` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_boq_mail`
--

INSERT INTO `i_ext_et_boq_mail` (`iextetboqm_id`, `iextetboqm_boq_id`, `iextetboqm_cid`, `iextetboqm_send_date`, `iextetboqm_res_date`, `iextetboqm_owner`, `iextetboqm_file`) VALUES
(8, 10, 0, NULL, '2019-05-30 14:10:16', 1, '1559205616.json'),
(9, 10, 0, NULL, '2019-05-30 14:20:03', 1, '1559206203.json'),
(14, 10, 0, NULL, '2019-05-30 17:18:02', 1, '1559216882.json');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_boq_mutual`
--

CREATE TABLE `i_ext_et_boq_mutual` (
  `iextetboqm_id` int(11) NOT NULL,
  `iextetboqm_boq_id` int(11) DEFAULT NULL,
  `iextetboqm_uid` int(11) DEFAULT NULL,
  `iextetboqm_file` varchar(100) DEFAULT NULL,
  `iextetboqm_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_boq_mutual`
--

INSERT INTO `i_ext_et_boq_mutual` (`iextetboqm_id`, `iextetboqm_boq_id`, `iextetboqm_uid`, `iextetboqm_file`, `iextetboqm_status`) VALUES
(24, 6, 1, '15524640991.json', 'done'),
(25, 6, 2, '15524640992.json', 'done'),
(26, 6, 3, '15524640993.json', 'pending'),
(30, 5, 1, '15549781531.json', 'done'),
(31, 5, 2, '15549781532.json', 'pending'),
(32, 5, 3, '15549781533.json', 'pending'),
(33, 5, 1, '15549781531.json', 'done'),
(34, 7, 1, '15549803551.json', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_boq_template`
--

CREATE TABLE `i_ext_et_boq_template` (
  `iextetboqt_id` int(11) NOT NULL,
  `iextetboqt_title` varchar(100) DEFAULT NULL,
  `iextetboqt_file` varchar(100) DEFAULT NULL,
  `iextetboqt_owner` int(11) DEFAULT NULL,
  `iextetboqt_created` datetime DEFAULT NULL,
  `iextetboqt_created_by` int(11) DEFAULT NULL,
  `iextetboqt_modified` datetime DEFAULT NULL,
  `iextetboqt_modified_by` int(11) DEFAULT NULL,
  `iextetboqt_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_boq_template`
--

INSERT INTO `i_ext_et_boq_template` (`iextetboqt_id`, `iextetboqt_title`, `iextetboqt_file`, `iextetboqt_owner`, `iextetboqt_created`, `iextetboqt_created_by`, `iextetboqt_modified`, `iextetboqt_modified_by`, `iextetboqt_gid`) VALUES
(8, 'test final v1.4', '1556022016.json', 1, '2019-04-23 17:48:22', 1, '2019-04-23 17:50:16', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_design_manager`
--

CREATE TABLE `i_ext_et_design_manager` (
  `iextetdm_id` int(11) NOT NULL,
  `iextetdm_type` varchar(100) DEFAULT NULL,
  `iextetdm_type_id` int(11) DEFAULT NULL,
  `iextetdm_title` varchar(200) DEFAULT NULL,
  `iextetdm_owner` int(11) DEFAULT NULL,
  `iextetdm_created` datetime DEFAULT NULL,
  `iextetdm_created_by` int(11) DEFAULT NULL,
  `iextetdm_modified` datetime DEFAULT NULL,
  `iextetdm_modified_by` int(11) DEFAULT NULL,
  `iextetdm_gid` int(11) DEFAULT NULL,
  `iextetdm_file` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_design_manager`
--

INSERT INTO `i_ext_et_design_manager` (`iextetdm_id`, `iextetdm_type`, `iextetdm_type_id`, `iextetdm_title`, `iextetdm_owner`, `iextetdm_created`, `iextetdm_created_by`, `iextetdm_modified`, `iextetdm_modified_by`, `iextetdm_gid`, `iextetdm_file`) VALUES
(3, '0', 0, 'test 1', 1, '2019-04-30 22:34:45', 1, '2019-05-02 11:56:23', 1, 0, '1556778383.json');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_design_manager_category`
--

CREATE TABLE `i_ext_et_design_manager_category` (
  `iextetdmc_id` int(11) NOT NULL,
  `iextetdmc_name` varchar(200) DEFAULT NULL,
  `iextetdmc_dm_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_design_manager_category`
--

INSERT INTO `i_ext_et_design_manager_category` (`iextetdmc_id`, `iextetdmc_name`, `iextetdmc_dm_id`) VALUES
(1, 'test 1', 1),
(4, 'test 2', 1),
(5, 'test again', 1),
(6, 'Plumbing', 2),
(7, 'test pdf', 3);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_dm_category_upload`
--

CREATE TABLE `i_ext_et_dm_category_upload` (
  `iextetdmcu_id` int(11) NOT NULL,
  `iextetdmcu_dmc_id` int(11) DEFAULT NULL,
  `iextetdmcu_file_name` varchar(200) DEFAULT NULL,
  `iextetdmcu_timestamp` varchar(200) DEFAULT NULL,
  `iextetdmcu_final` varchar(100) DEFAULT NULL,
  `iextetdmcu_final_on` datetime DEFAULT NULL,
  `iextetdmcu_upload_by` int(11) DEFAULT NULL,
  `iextetdmcu_date` datetime DEFAULT NULL,
  `iextetdmcu_remark` varchar(500) DEFAULT NULL,
  `iextetdmcu_cat_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_dm_category_upload`
--

INSERT INTO `i_ext_et_dm_category_upload` (`iextetdmcu_id`, `iextetdmcu_dmc_id`, `iextetdmcu_file_name`, `iextetdmcu_timestamp`, `iextetdmcu_final`, `iextetdmcu_final_on`, `iextetdmcu_upload_by`, `iextetdmcu_date`, `iextetdmcu_remark`, `iextetdmcu_cat_id`) VALUES
(4, 3, 'test', '01556643885.sql', 'false', NULL, 1, '2019-04-30 22:34:45', '3 files selected', 'j2_5'),
(5, 3, 'test', '11556643885.svg', 'false', NULL, 1, '2019-04-30 22:34:45', '3 files selected', 'j2_5'),
(6, 3, 'test', '21556643885.txt', 'false', NULL, 1, '2019-04-30 22:34:45', '1 remark', 'j2_5'),
(7, 3, 'manager_view', '01556643951.html', 'true', '2019-04-30 22:35:58', 1, '2019-04-30 22:35:51', 'MANAGER FILES', 'j2_5');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_dm_template`
--

CREATE TABLE `i_ext_et_dm_template` (
  `iextetdmt_id` int(11) NOT NULL,
  `iextetdmt_title` varchar(100) DEFAULT NULL,
  `iextetdmt_file` varchar(100) DEFAULT NULL,
  `iextetdmt_owner` int(11) DEFAULT NULL,
  `iextetdmt_created` datetime DEFAULT NULL,
  `iextetdmt_created_by` int(11) DEFAULT NULL,
  `iextetdmt_modified` datetime DEFAULT NULL,
  `iextetdmt_modified_by` int(11) DEFAULT NULL,
  `iextetdmt_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_dm_template`
--

INSERT INTO `i_ext_et_dm_template` (`iextetdmt_id`, `iextetdmt_title`, `iextetdmt_file`, `iextetdmt_owner`, `iextetdmt_created`, `iextetdmt_created_by`, `iextetdmt_modified`, `iextetdmt_modified_by`, `iextetdmt_gid`) VALUES
(2, 'test template', '1556628764.json', 1, '2019-04-30 13:02:32', 1, '2019-04-30 18:22:44', 1, 0),
(3, 'New Template', '1556774860.json', 1, '2019-05-02 10:57:40', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_document_terms`
--

CREATE TABLE `i_ext_et_document_terms` (
  `iextdt_id` int(11) NOT NULL,
  `iextdt_term` varchar(900) DEFAULT NULL,
  `iextdt_document` varchar(100) DEFAULT NULL,
  `iextdt_owner` int(11) DEFAULT NULL,
  `iextdt_created` datetime DEFAULT NULL,
  `iextdt_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_document_terms`
--

INSERT INTO `i_ext_et_document_terms` (`iextdt_id`, `iextdt_term`, `iextdt_document`, `iextdt_owner`, `iextdt_created`, `iextdt_created_by`) VALUES
(1, '   Subject to Mumbai jurisdiction ', 'Invoice', 188, '2018-01-18 19:01:42', 188),
(2, '.100% Payment against delivery.', 'Invoice', 188, '2017-12-02 19:12:53', 188),
(3, 'Goods once sold will not be taken back.', 'Invoice', 188, '2017-12-02 19:12:09', 188),
(4, 'Delivery: With in 2 to 4 week.', 'Proposal', 188, '2017-12-05 19:12:20', 188),
(5, 'Any complaint against quality should be lodged with in 7 days.', 'Invoice', 188, '2017-12-02 19:12:24', 188),
(6, 'Payment: 50% against firm order, balance on delivery.', 'Proposal', 188, '2017-12-05 19:12:50', 188),
(7, '  Taxes: Extra if any levied at the time of delivery other than specified.', 'Proposal', 188, '2017-12-05 19:12:34', 188),
(8, 'Wiring at your scope', 'Proposal', 188, '2017-12-05 19:12:10', 188),
(9, 'Any fabrication, carpentry, mason, work if required will be at your scope.    ', 'Proposal', 188, '2017-12-08 14:12:21', 188),
(10, 'Warranty of the equipment will 12 month from date of purchase.', 'Proposal', 188, '2017-12-08 14:12:52', 188),
(11, 'A.M.C will be under taken after completion of warranty period @ 7% of the Invoice Value', 'Proposal', 188, '2017-12-08 14:12:54', 188),
(12, ' Lift CCTV Cabling will done by your lift service provider.', 'Proposal', 188, '2017-12-08 14:12:34', 188),
(13, 'Pole mounting or any mount to fix camera / monitor  if required  shall be fabricated at extra cost', 'Proposal', 188, '2017-12-08 14:12:40', 188),
(14, ' In the case of major fault the equipment shall  be bought to work station , will be repaired and returned back in due course of time.', 'Subscription', 188, '2018-05-03 17:05:10', 188),
(15, 'The above service contract does not cover any damage to the equipment caused by accident or gross negligence of the owner.', 'Subscription', 188, '2018-05-03 17:05:55', 188),
(16, 'Care will be taken of all equipment brought to the workshop for repair, however the company is not liable for any loss or damage arising from accident, fire , theft, riot or causes beyond our control.', 'Subscription', 188, '2018-05-03 17:05:38', 188),
(17, 'This contract is only for labour, thereby does not include any parts. Parts replaced will be charged extra.', 'Subscription', 188, '2018-05-03 17:05:06', 188),
(18, 'Any ornamental parts or outer casing of the equipment will not be taken under the contract.', 'Subscription', 188, '2018-05-03 17:05:55', 188),
(19, 'Housing/Dome of the equipment if corroded and needs replacement will be charged extra.', 'Subscription', 188, '2018-05-03 17:05:44', 188),
(20, 'In cases where our service technicians are unable to reach the place of installtion with your normal ladder, any special arrangement if required, shall be provided by the costumer.	  ', 'Subscription', 188, '2018-05-03 17:05:15', 188),
(21, 'This agreement shall not be assigned by the owner without the consent of the company.', 'Subscription', 188, '2018-05-03 17:05:48', 188),
(22, 'Any wiring/additional wiring ,disconnection/reconnection shall be charged extra.', 'Subscription', 188, '2018-05-03 17:05:22', 188),
(23, 'Our Bank Details:Name of the Bank: ICICI Bank.Andheri (E) Branch Beneficiary Name: Cosmos Eletronics Account No: 642705000217 RTGS/NEFT: ICIC0006427', 'Invoice', 188, '2018-05-11 12:05:34', 188),
(24, 'Payment: 100% on Delvary', 'Proposal', 188, '2018-05-11 15:05:15', 188),
(25, '  inventory terms', 'Inventory', 188, '2019-02-12 10:51:14', 188),
(26, '  inventory 2nd terms', 'Inventory', 188, '2019-02-12 11:11:39', 188),
(27, '  inventory 3rd', 'Inventory', 188, '2019-02-12 11:13:38', 188),
(28, '  inventory 4th', 'Inventory', 188, '2019-02-12 11:14:37', 188),
(29, '  inventory 5th', 'Inventory', 188, '2019-02-12 11:16:16', 188),
(30, '  ams 1', 'AMC', 188, '2019-02-12 12:59:14', 188),
(31, '  amc 2', 'AMC', 188, '2019-02-12 13:29:28', 188),
(32, '  invoice test', 'Invoice', 188, '2019-02-12 13:30:43', 188),
(33, 'invoice  final test', 'Invoice', 188, '2019-02-12 13:31:51', 188),
(34, '  purchase 1', 'Purchase', 188, '2019-02-12 13:44:59', 188),
(35, 'purchase 2', 'Purchase', 188, '2019-02-12 13:46:23', 188),
(36, '  testing proposal', 'Proposal', 188, '2019-02-12 16:11:51', 188),
(37, '  test pro', 'Proposal', 188, '2019-02-13 10:34:52', 188),
(38, 'testing order terms  ', 'Orders', 188, '2019-02-23 11:45:26', 188),
(39, '  test add terms', 'Orders', 188, '2019-02-23 12:23:37', 188),
(40, 'welcome to orders', 'Orders', 1, '2019-03-09 09:12:19', 1),
(41, '  inventory terms', 'Inventory', 1, '2019-04-10 11:58:29', 1),
(42, 'Proposal Terms 1', 'Proposal', 1, '2019-04-10 12:57:30', 1),
(43, 'Proposal Terms 2', 'Proposal', 1, '2019-04-10 12:57:35', 1),
(44, 'invoice term 1', 'Invoice', 1, '2019-04-10 13:14:00', 1),
(45, 'invoice term 2', 'Invoice', 1, '2019-04-10 13:14:05', 1),
(46, '  ams 1', 'AMC', 1, '2019-04-10 14:32:31', 1),
(47, '  ams 2', 'AMC', 1, '2019-04-10 14:32:36', 1),
(48, '  am 3', 'AMC', 1, '2019-04-12 12:16:48', 1),
(49, '  ams 44', 'AMC', 1, '2019-04-12 12:17:18', 1),
(50, '  3', 'Proposal', 1, '2019-04-13 15:26:41', 1),
(51, '  4', 'Proposal', 1, '2019-04-13 15:26:45', 1),
(52, '  2nd terms', 'Inventory', 1, '2019-05-14 15:42:48', 1),
(53, 'welcome', 'Invoice', 1, '2019-05-27 10:59:51', 1),
(54, 'quell', 'Invoice', 1, '2019-05-27 11:02:45', 1),
(55, 'testing purchase term', 'Purchase_order', 1, '2019-05-27 11:07:48', 1),
(56, 'test credit note  ', 'Credit_note', 1, '2019-05-27 12:35:36', 1),
(57, '2nd term from credit note', 'Credit_note', 1, '2019-05-27 12:53:24', 1),
(58, 'test debit terms', 'Debit_note', 1, '2019-05-27 14:39:06', 1),
(59, '  welcome to inward', 'Inventory', 22, '2019-06-10 10:38:10', 22),
(60, 'welcome to inward', 'Inward', 22, '2019-06-10 10:40:07', 22),
(61, 'add to inward terms', 'Inward', 19, '2019-06-10 10:44:24', 19),
(62, 'Welcome to new UI', 'Inward', 19, '2019-06-10 11:44:59', 22),
(63, 'outward terms', 'Inward', 19, '2019-06-10 16:30:10', 19),
(64, '  outward terms', 'Outward', 19, '2019-06-10 16:33:08', 19),
(65, 'welcome to orders terms', 'Orders', 19, '2019-06-12 12:09:54', 19),
(66, 'welcome to terms', 'Orders', 19, '2019-06-12 12:10:59', 19),
(67, 'welcome to orders terms', 'Orders', 19, '2019-06-12 12:12:38', 19),
(68, 'welcome to orders terms', 'Orders', 19, '2019-06-12 12:13:34', 19),
(69, 'welcome to rejection in', 'Outward', 19, '2019-06-14 11:36:15', 19),
(70, 'welcome to red in terms', 'Rejection In', 19, '2019-06-14 11:42:21', 19),
(71, 'rej out terms', 'Rejection Out', 19, '2019-06-14 12:10:34', 19),
(72, 'material in terms', 'Rejection In', 19, '2019-06-14 15:17:38', 22),
(73, '  Payment within 60 days', 'Inward', 4, '2019-06-20 11:43:02', 4),
(74, 'Goods to be picked up by customer', 'Inward', 4, '2019-06-20 11:43:32', 4),
(75, '  Delivery by Courier only', 'Outward', 4, '2019-06-20 12:28:15', 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_expenses`
--

CREATE TABLE `i_ext_et_expenses` (
  `iextete_id` int(11) NOT NULL,
  `iextete_details` varchar(300) NOT NULL,
  `iextete_amount` float NOT NULL,
  `iextete_date` date NOT NULL,
  `iextete_owner` int(11) NOT NULL,
  `iextete_file` varchar(20) NOT NULL,
  `iextete_created` datetime NOT NULL,
  `iextete_created_by` int(11) NOT NULL,
  `iextete_gid` int(11) DEFAULT NULL,
  `iextete_modified` datetime DEFAULT NULL,
  `iextete_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_expenses`
--

INSERT INTO `i_ext_et_expenses` (`iextete_id`, `iextete_details`, `iextete_amount`, `iextete_date`, `iextete_owner`, `iextete_file`, `iextete_created`, `iextete_created_by`, `iextete_gid`, `iextete_modified`, `iextete_modified_by`) VALUES
(72, '123', 123, '2018-11-30', 188, '11th Sci Mum.xls', '2018-11-30 11:11:30', 188, 0, '2018-12-28 17:12:59', 188),
(82, 'new', 123, '2018-11-30', 188, '11th Sci Mum.xlsx', '2018-11-30 17:11:12', 188, 0, '2018-12-28 17:12:35', 188),
(89, 'new', 10, '2018-11-25', 188, '11th Sci Mum.xlsx', '2018-11-30 20:11:10', 188, 0, '2018-12-28 17:12:40', 188);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_expense_tag`
--

CREATE TABLE `i_ext_et_expense_tag` (
  `iextetet_id` int(11) NOT NULL,
  `iextetet_e_id` int(11) NOT NULL,
  `iextetet_tag_id` int(11) NOT NULL,
  `iextetet_created` datetime NOT NULL,
  `iextetet_owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_extension_share`
--

CREATE TABLE `i_ext_et_extension_share` (
  `iextetes_id` int(11) NOT NULL,
  `iextetes_mid` int(11) DEFAULT NULL,
  `iextetes_type` varchar(100) DEFAULT NULL,
  `iextetes_type_id` int(11) DEFAULT NULL,
  `iextetes_from` int(11) DEFAULT NULL,
  `iextetes_to` int(11) DEFAULT NULL,
  `iextetes_created` datetime DEFAULT NULL,
  `iextetes_created_by` int(11) DEFAULT NULL,
  `iextetes_owner` int(11) DEFAULT NULL,
  `iextetes_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_extension_share`
--

INSERT INTO `i_ext_et_extension_share` (`iextetes_id`, `iextetes_mid`, `iextetes_type`, `iextetes_type_id`, `iextetes_from`, `iextetes_to`, `iextetes_created`, `iextetes_created_by`, `iextetes_owner`, `iextetes_gid`) VALUES
(1, 50, 'Opportunity', 51, 1, 3, '2019-03-07 12:34:50', 1, 1, 0),
(2, 58, 'Requirement', 11, 1, 3, '2019-03-07 12:37:48', 1, 1, 0),
(3, 58, 'Requirement', 6, 1, 3, '2019-03-07 12:38:48', 1, 1, 0),
(4, 50, 'Opportunity', 52, 1, 3, '2019-03-07 13:08:55', 1, 1, 9),
(5, 50, 'Opportunity', 52, 1, 3, '2019-03-07 13:12:42', 1, 1, 9),
(6, 50, 'Opportunity', 52, 1, 3, '2019-03-07 13:54:07', 1, 1, 9),
(7, 50, 'Opportunity', 51, 1, 0, '2019-03-08 23:09:14', 1, 1, 0),
(8, 58, 'Requirement', 6, 1, 0, '2019-03-14 11:13:35', 1, 1, 0),
(9, 59, 'Design manager', 51, 1, 0, '2019-04-05 11:47:59', 1, 1, 0),
(10, 59, 'Design manager', 51, 1, 0, '2019-04-05 11:52:23', 1, 1, 0),
(12, 0, NULL, 1, 1, 0, '2019-04-05 12:01:43', 1, 1, 0),
(13, 0, NULL, 2, 1, 0, '2019-04-05 12:02:40', 1, 1, 0),
(14, 59, 'Design Manager', 2, 1, 0, '2019-04-05 12:04:20', 1, 1, 0),
(15, 59, 'Design Manager', 1, 1, 0, '2019-04-05 12:04:44', 1, 1, 0),
(16, 59, 'Design Manager', 2, 1, 0, '2019-04-05 12:20:58', 1, 1, 0),
(17, 59, 'Design Manager', NULL, 1, 0, '2019-04-05 12:29:19', 1, 1, 0),
(18, 59, 'Design Manager', 3, 1, 0, '2019-04-05 12:38:43', 1, 1, 0),
(19, 59, 'Design Manager', 1, 1, 0, '2019-04-05 13:23:43', 1, 1, 0),
(20, 59, 'Design Manager', 3, 1, 0, '2019-04-05 13:38:36', 1, 1, 0),
(21, 59, 'Design Manager', 3, 1, 0, '2019-04-05 13:43:42', 1, 1, 0),
(22, 60, 'BOQ', 5, 1, 0, '2019-04-05 14:36:31', 1, 1, 0),
(23, 60, 'BOQ', 0, 1, 0, '2019-04-05 16:23:35', 1, 1, 0),
(24, 60, 'BOQ', 0, 1, 0, '2019-04-05 16:24:14', 1, 1, 0),
(25, 60, 'BOQ', 5, 1, 0, '2019-04-05 17:09:54', 1, 1, 0),
(26, 60, 'BOQ', 5, 1, 0, '2019-04-05 17:15:03', 1, 1, 0),
(27, 60, 'BOQ', 5, 1, 0, '2019-04-05 17:19:24', 1, 1, 0),
(28, 60, 'BOQ', 5, 1, 0, '2019-04-05 17:28:00', 1, 1, 0),
(29, 60, 'BOQ', 5, 1, 0, '2019-04-05 17:30:36', 1, 1, 0),
(30, 59, 'Design Manager', 1, 1, 0, '2019-04-05 17:36:25', 1, 1, 0),
(31, 59, 'Design Manager', 3, 1, 0, '2019-04-05 17:38:45', 1, 1, 0),
(32, 49, 'Projects', 22, 1, 0, '2019-04-08 10:56:03', 1, 1, 0),
(33, 49, 'Projects', 22, 1, 0, '2019-04-08 13:37:11', 1, 1, 0),
(34, 49, 'Projects', 22, 1, 0, '2019-04-08 14:46:47', 1, 1, 0),
(35, 49, 'Projects', 22, 1, 0, '2019-04-08 14:49:48', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_extension_share_info`
--

CREATE TABLE `i_ext_et_extension_share_info` (
  `iextetesi_id` int(11) NOT NULL,
  `iextetesi_sid` int(11) DEFAULT NULL,
  `iextetesi_type` varchar(100) DEFAULT NULL,
  `iextetesi_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_extension_share_info`
--

INSERT INTO `i_ext_et_extension_share_info` (`iextetesi_id`, `iextetesi_sid`, `iextetesi_type`, `iextetesi_owner`) VALUES
(1, 1, 'Likeihood of conversion', 1),
(2, 1, 'Basic Details', 1),
(3, 1, 'Notes', 1),
(4, 1, 'Status', 1),
(5, 2, 'Images And notes', 1),
(6, 2, 'Requirement List', 1),
(7, 3, 'Images And notes', 1),
(8, 3, 'Requirement List', 1),
(9, 4, 'Likeihood of conversion', 1),
(10, 4, 'Notes', 1),
(11, 4, 'Proposal', 1),
(12, 4, 'Status', 1),
(13, 5, 'Likeihood of conversion', 1),
(14, 5, 'Notes', 1),
(15, 5, 'Proposal', 1),
(16, 5, 'Status', 1),
(17, 6, 'Likeihood of conversion', 1),
(18, 6, 'Notes', 1),
(19, 6, 'Proposal', 1),
(20, 6, 'Status', 1),
(21, 7, 'Likeihood of conversion', 1),
(22, 7, 'Notes', 1),
(23, 7, 'Proposal', 1),
(24, 7, 'Status', 1),
(25, 8, 'Images And notes', 1),
(26, 8, 'Requirement List', 1),
(27, 19, 'test 1', 1),
(28, 19, 'test 2', 1),
(29, 20, 'test pdf', 1),
(30, 21, 'test pdf', 1),
(31, 25, 'krishnakant', 1),
(32, 25, 'kpatole', 1),
(33, 25, 'Vinaya', 1),
(34, 25, 'krishna', 1),
(35, 5, NULL, 1),
(36, 26, 'krishnakant', 1),
(37, 26, 'Vinaya', 1),
(38, 26, 'krishna', 1),
(39, 27, 'krishnakant', 1),
(40, 27, 'Vinaya', 1),
(41, 27, 'krishna', 1),
(42, 28, 'krishnakant', 1),
(43, 28, 'krishna', 1),
(44, 29, 'krishnakant', 1),
(45, 30, 'test 1', 1),
(46, 31, 'test pdf', 1),
(47, 32, 'Uploaded Files', 1),
(48, 32, 'Product List', 1),
(49, 32, 'Project Status', 1),
(50, 32, 'Group Status', 1),
(51, 32, 'welcome', 1),
(52, 33, 'Uploaded Files', 1),
(53, 33, 'Group Status', 1),
(54, 33, 'welcome', 1),
(55, 33, 'test share data', 1),
(56, 34, 'Uploaded Files', 1),
(57, 34, 'Product List', 1),
(58, 34, 'Project Status', 1),
(59, 34, 'Group Status', 1),
(60, 35, 'Uploaded Files', 1),
(61, 35, 'Product List', 1),
(62, 35, 'Project Status', 1),
(63, 35, 'Group Status', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_godown_location`
--

CREATE TABLE `i_ext_et_godown_location` (
  `iextetgdl_id` int(11) NOT NULL,
  `iextetgdl_file` varchar(100) DEFAULT NULL,
  `iextetgdl_owner` int(11) DEFAULT NULL,
  `iextetgdl_created` datetime DEFAULT NULL,
  `iextetgdl_created_by` int(11) DEFAULT NULL,
  `iextetgdl_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_godown_location`
--

INSERT INTO `i_ext_et_godown_location` (`iextetgdl_id`, `iextetgdl_file`, `iextetgdl_owner`, `iextetgdl_created`, `iextetgdl_created_by`, `iextetgdl_gid`) VALUES
(9, '1558176565.json', 1, '2019-05-18 16:19:25', 1, 0),
(10, '1560144430.json', 19, '2019-06-10 10:57:10', 22, 36),
(11, '1560935434.json', 1, '2019-06-19 14:40:34', 1, 1),
(12, '1561010810.json', 4, '2019-06-20 11:36:50', 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_hr`
--

CREATE TABLE `i_ext_et_hr` (
  `iexteth_id` int(11) NOT NULL,
  `iexteth_cid` int(11) DEFAULT NULL,
  `iexteth_dept_id` int(11) DEFAULT NULL,
  `iexteth_shift_id` int(11) DEFAULT NULL,
  `iexteth_salary` varchar(200) DEFAULT NULL,
  `iexteth_unit` varchar(200) DEFAULT NULL,
  `iexteth_owner` int(11) DEFAULT NULL,
  `iexteth_created` datetime DEFAULT NULL,
  `iexteth_created_by` int(11) DEFAULT NULL,
  `iexteth_modified` datetime DEFAULT NULL,
  `iexteth_modified_by` int(11) DEFAULT NULL,
  `iexteth_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_hr`
--

INSERT INTO `i_ext_et_hr` (`iexteth_id`, `iexteth_cid`, `iexteth_dept_id`, `iexteth_shift_id`, `iexteth_salary`, `iexteth_unit`, `iexteth_owner`, `iexteth_created`, `iexteth_created_by`, `iexteth_modified`, `iexteth_modified_by`, `iexteth_gid`) VALUES
(7, 19, 1, 1, '15000', 'test1', 1, '2019-03-15 13:22:35', 1, '2019-03-16 09:41:27', 1, 0),
(11, 23, 2, 1, '15000', '1', 1, '2019-03-15 14:10:30', 1, '2019-03-16 09:59:30', 1, 0),
(13, 25, 2, 1, '31000', '1', 1, '2019-03-15 17:24:53', 1, '2019-03-18 16:35:41', 1, 0),
(14, 26, 2, 1, '1000', '1', 1, '2019-03-16 10:00:28', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_hr_department`
--

CREATE TABLE `i_ext_et_hr_department` (
  `iextethd_id` int(11) NOT NULL,
  `iextethd_dept_name` varchar(200) DEFAULT NULL,
  `iextethd_owner` int(11) DEFAULT NULL,
  `iextethd_created` datetime DEFAULT NULL,
  `iextethd_created_by` int(11) DEFAULT NULL,
  `iextethd_modified` datetime DEFAULT NULL,
  `iextethd_modified_by` int(11) DEFAULT NULL,
  `iextethd_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_hr_department`
--

INSERT INTO `i_ext_et_hr_department` (`iextethd_id`, `iextethd_dept_name`, `iextethd_owner`, `iextethd_created`, `iextethd_created_by`, `iextethd_modified`, `iextethd_modified_by`, `iextethd_gid`) VALUES
(1, 'developer', 1, '2019-03-14 18:01:15', 1, NULL, NULL, 0),
(2, 'Testing', 1, '2019-03-14 18:01:26', 1, NULL, NULL, 0),
(3, 'design', 1, '2019-03-19 11:31:18', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_hr_policie`
--

CREATE TABLE `i_ext_et_hr_policie` (
  `iextethp_id` int(11) NOT NULL,
  `iextethp_late_deduct` varchar(200) DEFAULT NULL,
  `iextethp_late` varchar(100) DEFAULT NULL,
  `iextethp_absent_deduct` varchar(200) DEFAULT NULL,
  `iextethp_absent` varchar(100) DEFAULT NULL,
  `iextethp_owner` int(11) DEFAULT NULL,
  `iextethp_created` datetime DEFAULT NULL,
  `iextethp_created_by` int(11) DEFAULT NULL,
  `iextethp_modified` datetime DEFAULT NULL,
  `iextethp_modified_by` int(11) DEFAULT NULL,
  `iextethp_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_hr_policie`
--

INSERT INTO `i_ext_et_hr_policie` (`iextethp_id`, `iextethp_late_deduct`, `iextethp_late`, `iextethp_absent_deduct`, `iextethp_absent`, `iextethp_owner`, `iextethp_created`, `iextethp_created_by`, `iextethp_modified`, `iextethp_modified_by`, `iextethp_gid`) VALUES
(1, '1000', '10', '100', '2', 1, '2019-03-18 00:00:00', 1, '2019-03-18 16:33:19', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_hr_shift`
--

CREATE TABLE `i_ext_et_hr_shift` (
  `iexteths_id` int(11) NOT NULL,
  `iexteths_shift_name` varchar(200) DEFAULT NULL,
  `iexteths_in_time` time DEFAULT NULL,
  `iexteths_out_time` time DEFAULT NULL,
  `iexteths_owner` int(11) DEFAULT NULL,
  `iexteths_created` datetime DEFAULT NULL,
  `iexteths_created_by` int(11) DEFAULT NULL,
  `iexteths_modified` datetime DEFAULT NULL,
  `iexteths_modified_by` int(11) DEFAULT NULL,
  `iexteths_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_hr_shift`
--

INSERT INTO `i_ext_et_hr_shift` (`iexteths_id`, `iexteths_shift_name`, `iexteths_in_time`, `iexteths_out_time`, `iexteths_owner`, `iexteths_created`, `iexteths_created_by`, `iexteths_modified`, `iexteths_modified_by`, `iexteths_gid`) VALUES
(1, '1st ', '10:00:00', '03:00:00', 1, '2019-03-14 17:53:48', 1, NULL, NULL, 0),
(2, '2nd', '10:05:00', '18:00:00', 1, '2019-03-14 17:54:11', 1, '2019-03-19 12:01:25', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory`
--

CREATE TABLE `i_ext_et_inventory` (
  `iextei_id` int(11) NOT NULL,
  `iextei_customer_id` int(11) DEFAULT NULL,
  `iextei_txn_id` varchar(100) DEFAULT NULL,
  `iextei_txn_date` date DEFAULT NULL,
  `iextei_type` varchar(100) DEFAULT NULL,
  `iextei_owner` int(11) DEFAULT NULL,
  `iextei_created` datetime DEFAULT NULL,
  `iextei_created_by` int(11) DEFAULT NULL,
  `iextei_modified` datetime DEFAULT NULL,
  `iextei_modified_by` int(11) DEFAULT NULL,
  `iextei_status` varchar(50) DEFAULT NULL,
  `iextei_gid` int(11) DEFAULT NULL,
  `iextei_note` varchar(500) DEFAULT NULL,
  `iextei_fid` int(11) DEFAULT NULL,
  `iextei_ticket_id` int(11) DEFAULT NULL,
  `iextei_warranty` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_inventory`
--

INSERT INTO `i_ext_et_inventory` (`iextei_id`, `iextei_customer_id`, `iextei_txn_id`, `iextei_txn_date`, `iextei_type`, `iextei_owner`, `iextei_created`, `iextei_created_by`, `iextei_modified`, `iextei_modified_by`, `iextei_status`, `iextei_gid`, `iextei_note`, `iextei_fid`, `iextei_ticket_id`, `iextei_warranty`) VALUES
(1, 1, '', '2019-06-19', 'inward', 1, '2019-06-19 15:13:41', 1, NULL, NULL, 'pending', 1, '', 1, NULL, 0),
(4, 8, 'IN/2012', '2019-06-20', 'inward', 4, '2019-06-20 12:10:16', 4, NULL, NULL, 'pending', 4, 'Testing Note', 4, NULL, 12),
(5, 9, '1/OUT/', '2019-06-20', 'outward', 4, '2019-06-20 12:28:40', 4, NULL, NULL, 'pending', 4, 'FLAT Price', 4, NULL, 12),
(6, 0, '123', '2019-06-20', 'material_in', 4, '2019-06-20 12:31:40', 4, NULL, NULL, 'pending', 4, 'Providing Arnav with Spares', 4, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_details`
--

CREATE TABLE `i_ext_et_inventory_details` (
  `iexteid_id` int(11) NOT NULL,
  `iexteid_e_id` int(11) DEFAULT NULL,
  `iexteid_product_id` int(11) DEFAULT NULL,
  `iexteid_inward` int(11) DEFAULT NULL,
  `iexteid_outward` int(11) DEFAULT NULL,
  `iexteid_balance` int(11) DEFAULT NULL,
  `iexteid_owner` int(11) DEFAULT NULL,
  `iexteid_model_number` varchar(100) DEFAULT NULL,
  `iexteid_serial_number` varchar(100) DEFAULT NULL,
  `iexteid_alias` varchar(100) DEFAULT NULL,
  `iexteid_amount` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_inventory_details`
--

INSERT INTO `i_ext_et_inventory_details` (`iexteid_id`, `iexteid_e_id`, `iexteid_product_id`, `iexteid_inward`, `iexteid_outward`, `iexteid_balance`, `iexteid_owner`, `iexteid_model_number`, `iexteid_serial_number`, `iexteid_alias`, `iexteid_amount`) VALUES
(2, 17, 410, 0, 0, 5, 1, NULL, '', '', NULL),
(3, 8, 417, 0, 0, 0, 1, NULL, '', '', NULL),
(4, 8, 394, 0, 0, 1, 1, NULL, '11', 'false', NULL),
(5, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(6, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(7, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(8, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(9, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(10, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(11, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(12, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(13, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(14, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(15, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(16, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(17, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(18, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(19, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(20, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(21, 8, 394, 0, 0, 1, 1, NULL, '1', 'false', NULL),
(22, 8, 394, 0, 0, 1, 1, NULL, '11', 'false', NULL),
(23, 8, 394, 0, 0, 1, 1, NULL, '', 'false', NULL),
(24, 8, 394, 0, 0, 1, 1, NULL, '312', 'false', NULL),
(25, 8, 394, 0, 0, 1, 1, NULL, '12', 'false', NULL),
(26, 8, 394, 0, 0, 1, 1, NULL, '312', 'false', NULL),
(27, 8, 394, 0, 0, 1, 1, NULL, '31', 'false', NULL),
(28, 8, 394, 0, 0, 1, 1, NULL, '23', 'false', NULL),
(29, 8, 394, 0, 0, 1, 1, NULL, '12', 'false', NULL),
(30, 8, 394, 0, 0, 1, 1, NULL, '3', 'false', NULL),
(31, 8, 394, 0, 0, 1, 1, NULL, '123', 'false', NULL),
(32, 8, 394, 0, 0, 1, 1, NULL, '12', 'false', NULL),
(33, 8, 394, 0, 0, 1, 1, NULL, '3', 'false', NULL),
(34, 8, 394, 0, 0, 1, 1, NULL, '', 'false', NULL),
(35, 8, 394, 0, 0, 1, 1, NULL, '12', 'false', NULL),
(36, 8, 394, 0, 0, 1, 1, NULL, '3', 'false', NULL),
(37, 8, 394, 0, 0, 1, 1, NULL, '12', 'false', NULL),
(38, 8, 394, 0, 0, 1, 1, NULL, '312312', 'false', NULL),
(39, 8, 394, 0, 0, 1, 1, NULL, '312312', 'false', NULL),
(40, 8, 394, 0, 0, 1, 1, NULL, '3', 'false', NULL),
(41, 8, 394, 0, 0, 1, 1, NULL, '12', 'false', NULL),
(42, 8, 394, 0, 0, 1, 1, NULL, '3', 'false', NULL),
(43, 8, 394, 0, 0, 1, 1, NULL, '123', 'false', NULL),
(44, 8, 394, 0, 0, 1, 1, NULL, '12312', 'false', NULL),
(45, 8, 394, 0, 0, 1, 1, NULL, '312', 'false', NULL),
(46, 8, 394, 0, 0, 1, 1, NULL, '312', 'false', NULL),
(47, 8, 394, 0, 0, 1, 1, NULL, '3123123', 'false', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_locations`
--

CREATE TABLE `i_ext_et_inventory_locations` (
  `iexteil_id` int(11) NOT NULL,
  `iexteil_name` varchar(100) DEFAULT NULL,
  `iexteil_code` varchar(100) DEFAULT NULL,
  `iexteil_owner` int(11) DEFAULT NULL,
  `iexteil_created` datetime DEFAULT NULL,
  `iexteil_created_by` int(11) DEFAULT NULL,
  `iexteil_modified` datetime DEFAULT NULL,
  `iexteil_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_material_location`
--

CREATE TABLE `i_ext_et_inventory_material_location` (
  `iexteiml_id` int(11) NOT NULL,
  `iexteiml_type` varchar(100) DEFAULT NULL,
  `iexteiml_txn_no` varchar(100) DEFAULT NULL,
  `iexteiml_txn_p_id` int(11) DEFAULT NULL,
  `iexteiml_p_id` int(11) DEFAULT NULL,
  `iexteiml_location_id` int(11) DEFAULT NULL,
  `iexteiml_txn_date` datetime DEFAULT NULL,
  `iexteiml_available` float DEFAULT NULL,
  `iexteiml_owner` int(11) DEFAULT NULL,
  `iexteiml_created` datetime DEFAULT NULL,
  `iexteiml_created_by` int(11) DEFAULT NULL,
  `iexteiml_modified` datetime DEFAULT NULL,
  `iexteiml_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_mutual`
--

CREATE TABLE `i_ext_et_inventory_mutual` (
  `iexteinm_id` int(11) NOT NULL,
  `iexteinm_pid` int(11) DEFAULT NULL,
  `iexteinm_uid` int(11) DEFAULT NULL,
  `iexteinm_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_inventory_mutual`
--

INSERT INTO `i_ext_et_inventory_mutual` (`iexteinm_id`, `iexteinm_pid`, `iexteinm_uid`, `iexteinm_oid`) VALUES
(2, 16, 21, 19);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_property`
--

CREATE TABLE `i_ext_et_inventory_property` (
  `iexteinvept_id` int(11) NOT NULL,
  `iexteinvept_inid` int(11) DEFAULT NULL,
  `iexteinvept_property_value` varchar(200) DEFAULT NULL,
  `iexteinvept_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_replacement`
--

CREATE TABLE `i_ext_et_inventory_replacement` (
  `iexteir_id` int(11) NOT NULL,
  `iexteir_from_pid` int(11) DEFAULT NULL,
  `iexteir_from_serial_number` varchar(100) DEFAULT NULL,
  `iexteir_to_pid` int(11) DEFAULT NULL,
  `iexteir_to_serial_number` varchar(100) DEFAULT NULL,
  `iexteir_created` datetime DEFAULT NULL,
  `iexteir_created_by` int(11) DEFAULT NULL,
  `iexteir_owner` int(11) DEFAULT NULL,
  `iexteir_modified` datetime DEFAULT NULL,
  `iexteir_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_tags`
--

CREATE TABLE `i_ext_et_inventory_tags` (
  `iextett_id` int(11) NOT NULL,
  `iextett_txn_id` int(11) DEFAULT NULL,
  `iextett_tag_id` int(11) DEFAULT NULL,
  `iextett_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_inventory_tags`
--

INSERT INTO `i_ext_et_inventory_tags` (`iextett_id`, `iextett_txn_id`, `iextett_tag_id`, `iextett_owner`) VALUES
(6, 10, 2105, NULL),
(7, 10, 2101, NULL),
(8, 10, 2106, NULL),
(9, 10, 2107, NULL),
(13, 12, 2109, NULL),
(11, 11, 2108, NULL),
(15, 16, 2112, NULL),
(18, 17, 2112, NULL),
(19, 21, 2112, NULL),
(23, 23, 2109, NULL),
(22, 23, 2110, NULL),
(24, 24, 2101, NULL),
(25, 24, 2113, NULL),
(30, 26, 2116, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_inventory_terms`
--

CREATE TABLE `i_ext_et_inventory_terms` (
  `iexteinvetm_id` int(11) NOT NULL,
  `iexteinvetm_inid` int(11) DEFAULT NULL,
  `iexteinvetm_term_id` int(11) DEFAULT NULL,
  `iexteinvetm_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_inventory_terms`
--

INSERT INTO `i_ext_et_inventory_terms` (`iexteinvetm_id`, `iexteinvetm_inid`, `iexteinvetm_term_id`, `iexteinvetm_status`) VALUES
(35, 15, 41, 'false'),
(36, 15, 52, 'false'),
(47, 1, 41, 'false'),
(48, 1, 52, 'false'),
(53, 1, 41, 'false'),
(54, 1, 52, 'false'),
(61, 1, 41, 'false'),
(62, 1, 52, 'false'),
(151, 8, 41, 'false'),
(152, 8, 52, 'false'),
(173, 10, 61, 'true'),
(174, 10, 62, 'false'),
(189, 14, 61, 'true'),
(190, 14, 62, 'false'),
(191, 15, 61, 'true'),
(192, 15, 62, 'true'),
(203, 17, 64, 'true'),
(206, 21, 64, 'true'),
(207, 22, 64, 'true'),
(212, 23, 61, 'true'),
(213, 23, 62, 'false'),
(223, 25, 61, 'false'),
(224, 25, 62, 'false'),
(225, 25, 63, 'false'),
(235, 29, 70, 'false'),
(236, 30, 70, 'false'),
(237, 30, 72, 'false'),
(238, 31, 70, 'false'),
(239, 31, 72, 'false'),
(240, 32, 70, 'false'),
(241, 32, 72, 'false'),
(242, 33, 70, 'false'),
(243, 33, 72, 'false'),
(244, 1, 61, 'false'),
(245, 1, 62, 'false'),
(246, 1, 63, 'false'),
(247, 4, 64, 'false'),
(248, 4, 69, 'false'),
(249, 5, 70, 'false'),
(250, 5, 72, 'false'),
(251, 6, 71, 'false'),
(256, 4, 73, 'true'),
(257, 4, 74, 'true'),
(258, 5, 75, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice`
--

CREATE TABLE `i_ext_et_invoice` (
  `iextein_id` int(11) NOT NULL,
  `iextein_customer_id` int(11) DEFAULT NULL,
  `iextein_txn_id` varchar(100) DEFAULT NULL,
  `iextein_txn_date` date DEFAULT NULL,
  `iextein_type` varchar(100) DEFAULT NULL,
  `iextein_amount` varchar(100) DEFAULT NULL,
  `iextein_status` varchar(100) DEFAULT NULL,
  `iextein_note` varchar(500) DEFAULT NULL,
  `iextein_owner` int(11) DEFAULT NULL,
  `iextein_created` datetime DEFAULT NULL,
  `iextein_created_by` int(11) DEFAULT NULL,
  `iextein_modified` datetime DEFAULT NULL,
  `iextein_modified_by` int(11) DEFAULT NULL,
  `iextein_hsn` varchar(100) DEFAULT NULL,
  `iextein_desc` varchar(100) DEFAULT NULL,
  `iextein_gid` int(11) DEFAULT NULL,
  `iextein_warranty` int(11) DEFAULT NULL,
  `iextein_txn_type` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_invoice`
--

INSERT INTO `i_ext_et_invoice` (`iextein_id`, `iextein_customer_id`, `iextein_txn_id`, `iextein_txn_date`, `iextein_type`, `iextein_amount`, `iextein_status`, `iextein_note`, `iextein_owner`, `iextein_created`, `iextein_created_by`, `iextein_modified`, `iextein_modified_by`, `iextein_hsn`, `iextein_desc`, `iextein_gid`, `iextein_warranty`, `iextein_txn_type`) VALUES
(1, 32, 'COSEL/2017-2018/TI/1', '2017-12-02', 'formal', '2688', 'unpaid', 'Challan No: 132456 Dt: 12/11/17', 188, '2017-12-02 17:12:29', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(2, 32, 'COSEL/2017-2018/TI/1', '2017-12-02', 'formal', '0', 'unpaid', '', 188, '2017-12-02 17:12:31', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(3, 10, 'COSEL/2017-2018/TI/49', '2017-12-30', 'formal', '1770', 'unpaid', '', 188, '2017-12-30 11:12:53', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(4, 80, 'COSEL/2017-2018/TI/50', '2018-01-06', 'formal', '15576', 'unpaid', '', 188, '2018-01-06 11:01:45', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(5, 76, 'COSEL/2017-2018/TI/51', '2018-01-08', 'formal', '156480.314', 'unpaid', '', 188, '2018-01-09 13:01:47', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(6, 7, 'COSEL/2017-2018/TI/52', '2018-01-11', 'formal', '19234', 'unpaid', '', 188, '2018-01-11 11:01:58', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(7, 77, 'COSEL/17-18/TI/54', '2018-01-15', 'formal', '125810.656', 'unpaid', '', 188, '2018-01-17 12:01:19', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(8, 55, 'COSEL/2017-2018/TI/55', '2018-01-19', 'formal', '8142', 'unpaid', '', 188, '2018-01-19 17:01:21', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(9, 90, 'COSEL/2017-2018/TI/56', '2018-01-25', 'formal', '15340', 'unpaid', '', 188, '2018-01-25 14:01:00', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(10, 90, 'COSEL/2017-2018/TI/57', '2018-01-29', 'formal', '2891', 'unpaid', '', 188, '2018-01-29 12:01:40', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(11, 14, 'COSEL/2017-2018/TI/58', '2018-01-29', 'formal', '6224.5', 'unpaid', '', 188, '2018-01-29 13:01:55', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(12, 32, 'COSEL/2017-2018/TI/59', '2018-02-05', 'formal', '1416', 'unpaid', '', 188, '2018-02-05 14:02:04', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(13, 22, 'COSEL/2017-2018/TI/60', '2018-02-19', 'formal', '28096.98', 'unpaid', '', 188, '2018-02-19 17:02:31', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(14, 120, 'COSEL/2017-2018/TI/61', '2018-02-20', 'formal', '11564', 'unpaid', '', 188, '2018-02-20 12:02:33', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(15, 120, 'COSEL/2017-2018/TI/62', '2018-03-06', 'formal', '2478', 'unpaid', '', 188, '2018-02-22 11:02:53', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(16, 122, 'COSEL/2017-2018/TI/63', '2017-02-27', 'formal', '28792', 'unpaid', '', 188, '2018-03-10 11:03:49', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(17, 123, 'COSEL/2017-2018/TI/64', '2018-03-15', 'formal', '3746.5', 'unpaid', '', 188, '2018-03-15 13:03:54', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(18, 125, 'COSEL/2017-2018/TI/65', '2018-03-17', 'formal', '28400.24', 'unpaid', '', 188, '2018-03-17 15:03:11', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(19, 123, 'COSEL/2017-2018/TI/66', '2018-03-26', 'formal', '6540', 'unpaid', '', 188, '2018-03-26 12:03:22', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(20, 127, 'COSEL/2017-2018/TI/67', '2018-03-26', 'formal', '944', 'unpaid', '', 188, '2018-03-26 13:03:40', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(21, 128, 'COSEL/2017-2018/TI/70', '2018-03-28', 'formal', '182168.4', 'unpaid', '', 188, '2018-04-03 11:04:20', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(22, 122, 'COSEL/2018-2019/TI/01', '2018-04-09', 'formal', '14986', 'unpaid', '', 188, '2018-04-09 14:04:36', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(23, 32, 'COSEL/2017-2018/TI/02', '2018-04-14', 'formal', '1180', 'unpaid', '', 188, '2018-04-14 11:04:13', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(24, 38, 'COSEL/2018-2019/TI/03', '2018-04-20', 'formal', '17405', 'unpaid', 'Order no.F-3/Modernisation/CCTV AMC/EPPC/CSDN/2017-18 Dt.at Mbi-01 the 16.01.2018', 188, '2018-04-20 16:04:07', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(25, 38, 'COSEL/2018-2019/TI/03', '2018-04-20', 'formal', '17405', 'unpaid', 'Your Order no.F-3/Modernisation/CCTV AMC/eppc/c     sdn/2017-18  Dt.at Mbi-01 the 16.01.2018', 188, '2018-04-20 16:04:14', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(26, 80, 'COSEL/2018-2019/TI/05', '2018-04-21', 'formal', '15174.8', 'unpaid', '', 188, '2018-04-21 11:04:23', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(27, 14, 'COSEL/2018-2019/TI/06', '2018-04-28', 'formal', '590', 'unpaid', '', 188, '2018-04-28 11:04:46', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(28, 32, 'COSEL/2018-2019/TI/07', '2018-05-09', 'formal', '0', 'unpaid', '', 188, '2018-05-09 15:05:26', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(29, 32, 'COSEL/2018-2019/TI/09', '2018-05-09', 'formal', '0', 'unpaid', '', 188, '2018-05-09 15:05:26', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(30, 31, 'COSEL/2018-19/TI/11', '2018-05-11', 'formal', '2596', 'unpaid', '', 188, '2018-05-11 12:05:28', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(31, 90, 'CE/2018-19/TI/12', '2018-05-14', 'formal', '413', 'unpaid', '', 188, '2018-05-14 14:05:28', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(32, 55, 'CE/2018-19/TI/13', '2018-05-28', 'formal', '2478', 'unpaid', '', 188, '2018-05-28 11:05:32', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(33, 53, 'COSEL/2018-2019/TI/14', '2018-05-29', 'formal', '7268.8', 'unpaid', '', 188, '2018-05-29 15:05:54', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(34, 53, 'COSEL/2018-2019/TI/15', '2018-05-31', 'formal', '2773', 'unpaid', '', 188, '2018-05-31 12:05:04', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(35, 80, 'COSEL/2018-2019/TI/16', '2018-06-04', 'formal', '7965', 'unpaid', '', 188, '2018-06-04 11:06:39', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(36, 135, 'COSEL/2018-2019/TI/17', '2018-06-04', 'formal', '23659', 'unpaid', '', 188, '2018-06-04 12:06:27', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(37, 122, 'COSEL/2018-2019/TI/18', '2018-06-04', 'formal', '11210', 'unpaid', '', 188, '2018-06-08 12:06:17', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(38, 76, 'COSEL/2018-2019/TI/19', '2018-06-15', 'formal', '708', 'unpaid', '', 188, '2018-06-15 13:06:11', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(39, 51, 'COSEL/2018-2019/TI/20', '2018-06-27', 'formal', '2950', 'unpaid', '', 188, '2018-06-27 11:06:53', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(40, 120, 'COSEL/2018-2019/TI/25', '2018-08-11', 'formal', '12242.5', 'unpaid', '', 188, '2018-08-11 11:08:20', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(41, 28, 'COSEL/2017-2018/TI/30', '2018-08-30', 'formal', '1298', 'unpaid', '', 188, '2018-08-30 12:08:32', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(42, 14, 'COSEL/2017-2018/TI/32', '2018-09-17', 'formal', '34343.9', 'unpaid', '', 188, '2018-09-17 14:09:42', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(43, 128, 'COSEL/2017-2018/TI/33', '2018-09-17', 'formal', '28174.86', 'unpaid', '', 188, '2018-09-17 14:09:43', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(44, 136, 'COSEL/2017-2018/TI/35', '2018-09-22', 'formal', '2124', 'unpaid', '', 188, '2018-09-18 15:09:24', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(45, 20, 'COSEL/2017-2018/TI/34', '2018-09-18', 'formal', '0', 'unpaid', '', 188, '2018-09-18 15:09:27', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(46, 55, 'COSEL/2018-2019/TI/36', '2018-09-20', 'formal', '0', 'unpaid', '', 188, '2018-09-24 16:09:57', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(47, 14, 'COSEL/2017-2018/TI/37', '2018-09-29', 'formal', '5310', 'unpaid', '', 188, '2018-09-29 13:09:03', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(48, 5, 'COSEL/2018-2019/TI/38', '2018-10-09', 'formal', '11613.56', 'unpaid', '', 188, '2018-10-09 13:10:35', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(49, 32, 'COSEL/2018-2019/TI/39', '2018-10-15', 'formal', '0', 'unpaid', '', 188, '2018-10-15 15:10:28', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(50, 38, 'COSEL/2018-2019/TI/40', '2018-10-15', 'formal', '0', 'unpaid', '', 188, '2018-10-15 15:10:34', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(51, 141, 'COSEL/2018-2019/TI/41', '2018-10-16', 'formal', '0', 'unpaid', '', 188, '2018-10-20 15:10:23', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(52, 1, 'COSEL/2018-2019/TI/44', '2018-10-31', 'formal', '39991.675', 'unpaid', '', 188, '2018-10-31 10:10:12', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(53, 80, 'COSEL/2017-2018/TI/45', '2018-11-23', 'formal', '9204', 'unpaid', '', 188, '2018-11-23 12:11:02', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(54, 134, 'COSEL/2018-2019/TI/46', '2018-12-06', 'formal', '0', 'unpaid', '', 188, '2018-12-17 16:12:23', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(55, 146, 'COSEL/2018-2019/TI/47', '2018-12-12', 'formal', '0', 'unpaid', '', 188, '2018-12-17 16:12:20', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(56, 35, 'COSEL/2018-2019/TI/48', '2018-12-18', 'formal', '0', 'unpaid', '', 188, '2018-12-17 16:12:08', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(57, 134, 'COSEL/2018-2019/TI/46', '2018-12-19', 'formal', '0', 'unpaid', '', 188, '2018-12-28 17:12:51', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(58, 147, 'COSEL/2018-2019/TI/49', '2018-12-24', 'formal', '0', 'unpaid', '', 188, '2018-12-28 17:12:39', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(59, 27, 'COSEL/2018-2019/TI/50', '2018-12-28', 'formal', '0', 'unpaid', '', 188, '2018-12-28 17:12:24', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(60, 179, 'COSEL/2017-2018/TI/1', '2017-12-02', 'formal', '2688', 'unpaid', 'Challan No: 132456 Dt: 12/11/17', 188, '2017-12-02 17:12:29', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(61, 179, 'COSEL/2017-2018/TI/1', '2017-12-02', 'formal', '0', 'unpaid', '', 188, '2017-12-02 17:12:31', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(62, 157, 'COSEL/2017-2018/TI/49', '2017-12-30', 'formal', '1770', 'unpaid', '', 188, '2017-12-30 11:12:53', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(63, 227, 'COSEL/2017-2018/TI/50', '2018-01-06', 'formal', '15576', 'unpaid', '', 188, '2018-01-06 11:01:45', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(64, 223, 'COSEL/2017-2018/TI/51', '2018-01-08', 'formal', '156480.314', 'unpaid', '', 188, '2018-01-09 13:01:47', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(65, 154, 'COSEL/2017-2018/TI/52', '2018-01-11', 'formal', '19234', 'unpaid', '', 188, '2018-01-11 11:01:58', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(66, 224, 'COSEL/17-18/TI/54', '2018-01-15', 'formal', '125810.656', 'unpaid', '', 188, '2018-01-17 12:01:19', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(67, 202, 'COSEL/2017-2018/TI/55', '2018-01-19', 'formal', '8142', 'unpaid', '', 188, '2018-01-19 17:01:21', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(68, 237, 'COSEL/2017-2018/TI/56', '2018-01-25', 'formal', '15340', 'unpaid', '', 188, '2018-01-25 14:01:00', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(69, 237, 'COSEL/2017-2018/TI/57', '2018-01-29', 'formal', '2891', 'unpaid', '', 188, '2018-01-29 12:01:40', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(70, 161, 'COSEL/2017-2018/TI/58', '2018-01-29', 'formal', '6224.5', 'unpaid', '', 188, '2018-01-29 13:01:55', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(71, 179, 'COSEL/2017-2018/TI/59', '2018-02-05', 'formal', '1416', 'unpaid', '', 188, '2018-02-05 14:02:04', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(72, 169, 'COSEL/2017-2018/TI/60', '2018-02-19', 'formal', '28096.98', 'unpaid', '', 188, '2018-02-19 17:02:31', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(73, 267, 'COSEL/2017-2018/TI/61', '2018-02-20', 'formal', '11564', 'unpaid', '', 188, '2018-02-20 12:02:33', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(74, 267, 'COSEL/2017-2018/TI/62', '2018-03-06', 'formal', '2478', 'unpaid', '', 188, '2018-02-22 11:02:53', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(75, 269, 'COSEL/2017-2018/TI/63', '2017-02-27', 'formal', '28792', 'unpaid', '', 188, '2018-03-10 11:03:49', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(76, 270, 'COSEL/2017-2018/TI/64', '2018-03-15', 'formal', '3746.5', 'unpaid', '', 188, '2018-03-15 13:03:54', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(77, 272, 'COSEL/2017-2018/TI/65', '2018-03-17', 'formal', '28400.24', 'unpaid', '', 188, '2018-03-17 15:03:11', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(78, 270, 'COSEL/2017-2018/TI/66', '2018-03-26', 'formal', '6540', 'unpaid', '', 188, '2018-03-26 12:03:22', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(79, 274, 'COSEL/2017-2018/TI/67', '2018-03-26', 'formal', '944', 'unpaid', '', 188, '2018-03-26 13:03:40', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(80, 275, 'COSEL/2017-2018/TI/70', '2018-03-28', 'formal', '182168.4', 'unpaid', '', 188, '2018-04-03 11:04:20', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(81, 269, 'COSEL/2018-2019/TI/01', '2018-04-09', 'formal', '14986', 'unpaid', '', 188, '2018-04-09 14:04:36', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(82, 179, 'COSEL/2017-2018/TI/02', '2018-04-14', 'formal', '1180', 'unpaid', '', 188, '2018-04-14 11:04:13', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(83, 185, 'COSEL/2018-2019/TI/03', '2018-04-20', 'formal', '17405', 'unpaid', 'Order no.F-3/Modernisation/CCTV AMC/EPPC/CSDN/2017-18 Dt.at Mbi-01 the 16.01.2018', 188, '2018-04-20 16:04:07', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(84, 185, 'COSEL/2018-2019/TI/03', '2018-04-20', 'formal', '17405', 'unpaid', 'Your Order no.F-3/Modernisation/CCTV AMC/eppc/c     sdn/2017-18  Dt.at Mbi-01 the 16.01.2018', 188, '2018-04-20 16:04:14', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(85, 227, 'COSEL/2018-2019/TI/05', '2018-04-21', 'formal', '15174.8', 'unpaid', '', 188, '2018-04-21 11:04:23', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(86, 161, 'COSEL/2018-2019/TI/06', '2018-04-28', 'formal', '590', 'unpaid', '', 188, '2018-04-28 11:04:46', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(87, 179, 'COSEL/2018-2019/TI/07', '2018-05-09', 'formal', '0', 'unpaid', '', 188, '2018-05-09 15:05:26', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(88, 179, 'COSEL/2018-2019/TI/09', '2018-05-09', 'formal', '0', 'unpaid', '', 188, '2018-05-09 15:05:26', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(89, 178, 'COSEL/2018-19/TI/11', '2018-05-11', 'formal', '2596', 'unpaid', '', 188, '2018-05-11 12:05:28', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(90, 237, 'CE/2018-19/TI/12', '2018-05-14', 'formal', '413', 'unpaid', '', 188, '2018-05-14 14:05:28', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(91, 202, 'CE/2018-19/TI/13', '2018-05-28', 'formal', '2478', 'unpaid', '', 188, '2018-05-28 11:05:32', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(92, 200, 'COSEL/2018-2019/TI/14', '2018-05-29', 'formal', '7268.8', 'unpaid', '', 188, '2018-05-29 15:05:54', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(93, 200, 'COSEL/2018-2019/TI/15', '2018-05-31', 'formal', '2773', 'unpaid', '', 188, '2018-05-31 12:05:04', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(94, 227, 'COSEL/2018-2019/TI/16', '2018-06-04', 'formal', '7965', 'unpaid', '', 188, '2018-06-04 11:06:39', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(95, 282, 'COSEL/2018-2019/TI/17', '2018-06-04', 'formal', '23659', 'unpaid', '', 188, '2018-06-04 12:06:27', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(96, 269, 'COSEL/2018-2019/TI/18', '2018-06-04', 'formal', '11210', 'unpaid', '', 188, '2018-06-08 12:06:17', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(97, 223, 'COSEL/2018-2019/TI/19', '2018-06-15', 'formal', '708', 'unpaid', '', 188, '2018-06-15 13:06:11', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(98, 198, 'COSEL/2018-2019/TI/20', '2018-06-27', 'formal', '2950', 'unpaid', '', 188, '2018-06-27 11:06:53', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(99, 267, 'COSEL/2018-2019/TI/25', '2018-08-11', 'formal', '12242.5', 'unpaid', '', 188, '2018-08-11 11:08:20', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(100, 175, 'COSEL/2017-2018/TI/30', '2018-08-30', 'formal', '1298', 'unpaid', '', 188, '2018-08-30 12:08:32', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(101, 161, 'COSEL/2017-2018/TI/32', '2018-09-17', 'formal', '34343.9', 'unpaid', '', 188, '2018-09-17 14:09:42', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(102, 275, 'COSEL/2017-2018/TI/33', '2018-09-17', 'formal', '28174.86', 'unpaid', '', 188, '2018-09-17 14:09:43', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(103, 283, 'COSEL/2017-2018/TI/35', '2018-09-22', 'formal', '2124', 'unpaid', '', 188, '2018-09-18 15:09:24', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(104, 167, 'COSEL/2017-2018/TI/34', '2018-09-18', 'formal', '0', 'unpaid', '', 188, '2018-09-18 15:09:27', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(105, 202, 'COSEL/2018-2019/TI/36', '2018-09-20', 'formal', '0', 'unpaid', '', 188, '2018-09-24 16:09:57', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(106, 161, 'COSEL/2017-2018/TI/37', '2018-09-29', 'formal', '5310', 'unpaid', '', 188, '2018-09-29 13:09:03', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(107, 152, 'COSEL/2018-2019/TI/38', '2018-10-09', 'formal', '11613.56', 'unpaid', '', 188, '2018-10-09 13:10:35', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(108, 179, 'COSEL/2018-2019/TI/39', '2018-10-15', 'formal', '0', 'unpaid', '', 188, '2018-10-15 15:10:28', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(109, 185, 'COSEL/2018-2019/TI/40', '2018-10-15', 'formal', '0', 'unpaid', '', 188, '2018-10-15 15:10:34', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(110, 288, 'COSEL/2018-2019/TI/41', '2018-10-16', 'formal', '0', 'unpaid', '', 188, '2018-10-20 15:10:23', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(111, 148, 'COSEL/2018-2019/TI/44', '2018-10-31', 'formal', '39991.675', 'unpaid', '', 188, '2018-10-31 10:10:12', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(112, 227, 'COSEL/2017-2018/TI/45', '2018-11-23', 'formal', '9204', 'unpaid', '', 188, '2018-11-23 12:11:02', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(113, 281, 'COSEL/2018-2019/TI/46', '2018-12-06', 'formal', '0', 'unpaid', '', 188, '2018-12-17 16:12:23', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(114, 293, 'COSEL/2018-2019/TI/47', '2018-12-12', 'formal', '0', 'unpaid', '', 188, '2018-12-17 16:12:20', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(115, 182, 'COSEL/2018-2019/TI/48', '2018-12-18', 'formal', '0', 'unpaid', '', 188, '2018-12-17 16:12:08', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(116, 281, 'COSEL/2018-2019/TI/46', '2018-12-19', 'formal', '0', 'unpaid', '', 188, '2018-12-28 17:12:51', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(117, 294, 'COSEL/2018-2019/TI/49', '2018-12-24', 'formal', '0', 'unpaid', '', 188, '2018-12-28 17:12:39', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(118, 174, 'COSEL/2018-2019/TI/50', '2018-12-28', 'formal', '0', 'unpaid', '', 188, '2018-12-28 17:12:24', 188, '0000-00-00 00:00:00', 188, NULL, NULL, 0, NULL, NULL),
(119, 1, 'EVO/2018-2019/119', '2019-02-09', 'formal', '34020', 'unpaid', '', 188, '2019-02-09 15:49:26', 188, '2019-02-13 10:34:28', 188, NULL, NULL, 0, 0, NULL),
(120, 2, 'EVO/2018-2019/120', '2019-02-12', 'formal', '133.056', 'open', 'welcome', 188, '2019-02-12 12:20:19', 188, NULL, NULL, NULL, NULL, 8, 12, NULL),
(121, 1, '1234', '2019-04-08', 'formal', '1349.9199999999998', 'cancelled', 'asdfghjk', 1, '2019-04-08 17:46:05', 1, '2019-05-22 16:57:27', 1, NULL, NULL, 0, 12, NULL),
(123, 1, '4', '2019-05-22', 'formal', '708', 'paid', '', 1, '2019-05-22 11:43:59', 1, '2019-05-22 11:51:04', 1, NULL, NULL, 31, 12, NULL),
(128, 110, '1', '2019-05-27', 'unpaid', NULL, NULL, '', 1, '2019-05-27 15:10:20', 1, NULL, NULL, NULL, NULL, 0, 12, NULL),
(129, 110, '1', '2019-05-27', 'unpaid', NULL, NULL, '', 1, '2019-05-27 15:11:27', 1, NULL, NULL, NULL, NULL, 0, 12, NULL),
(125, 111, '12', '2019-05-27', 'formal', '11.8', 'open', '', 1, '2019-05-27 12:05:13', 1, NULL, NULL, NULL, NULL, 0, 12, 'invoice'),
(130, 110, '1', '2019-05-27', 'unpaid', NULL, NULL, '', 1, '2019-05-27 15:13:09', 1, NULL, NULL, NULL, NULL, 0, 12, NULL),
(131, 110, '1', '2019-05-27', 'formal', '9440', 'unpaid', '', 1, '2019-05-27 15:15:26', 1, '2019-05-27 15:15:54', 1, NULL, NULL, 0, 12, 'invoice');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice_inventory_map`
--

CREATE TABLE `i_ext_et_invoice_inventory_map` (
  `iexteiim_id` int(11) NOT NULL,
  `iexteiim_invoice_id` int(11) DEFAULT NULL,
  `iexteiim_inventory_id` int(11) DEFAULT NULL,
  `iexteiim_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice_mutual`
--

CREATE TABLE `i_ext_et_invoice_mutual` (
  `iexteim_id` int(11) NOT NULL,
  `iexteim_pid` int(11) DEFAULT NULL,
  `iexteim_uid` int(11) DEFAULT NULL,
  `iexteim_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_invoice_mutual`
--

INSERT INTO `i_ext_et_invoice_mutual` (`iexteim_id`, `iexteim_pid`, `iexteim_uid`, `iexteim_oid`) VALUES
(12, 124, 2, 1),
(17, 126, 2, 1),
(18, 127, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice_product_details`
--

CREATE TABLE `i_ext_et_invoice_product_details` (
  `iexteinpd_id` int(11) NOT NULL,
  `iexteinpd_d_id` int(11) DEFAULT NULL,
  `iexteinpd_product_id` int(11) DEFAULT NULL,
  `iexteinpd_model_number` varchar(100) DEFAULT NULL,
  `iexteinpd_serial_number` varchar(100) DEFAULT NULL,
  `iexteinpd_rate` float DEFAULT NULL,
  `iexteinpd_qty` float DEFAULT NULL,
  `iexteinpd_discount` varchar(10) DEFAULT NULL,
  `iexteinpd_amount` float DEFAULT NULL,
  `iexteinpd_tax` int(11) DEFAULT NULL,
  `iexteinpd_tax_amount` float DEFAULT NULL,
  `iexteinpd_owner` int(11) DEFAULT NULL,
  `iexteinpd_alias` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_invoice_product_details`
--

INSERT INTO `i_ext_et_invoice_product_details` (`iexteinpd_id`, `iexteinpd_d_id`, `iexteinpd_product_id`, `iexteinpd_model_number`, `iexteinpd_serial_number`, `iexteinpd_rate`, `iexteinpd_qty`, `iexteinpd_discount`, `iexteinpd_amount`, `iexteinpd_tax`, `iexteinpd_tax_amount`, `iexteinpd_owner`, `iexteinpd_alias`) VALUES
(1, 1, 24, NULL, '', 2100, 1, '', 2100, 89, NULL, 188, 'false'),
(2, 3, 41, NULL, '', 1200, 1, '', 1200, 88, NULL, 188, 'false'),
(3, 4, 14, NULL, '', 100, 1, '', 100, 88, NULL, 188, 'false'),
(4, 4, 41, NULL, '', 100, 1, '', 100, 88, NULL, 188, 'false'),
(5, 4, 57, NULL, '3H0373DPBQ2HXU9', 13000, 1, '', 13000, 88, NULL, 188, 'false'),
(6, 5, 65, NULL, '', 65, 250, '5', 15437.5, 88, NULL, 188, 'false'),
(7, 5, 28, NULL, '', 90, 50, '5', 4275, 88, NULL, 188, 'false'),
(8, 5, 60, NULL, '', 360, 8, '5', 2736, 88, NULL, 188, 'false'),
(9, 5, 48, NULL, '', 5400, 1, '5', 5130, 88, NULL, 188, 'false'),
(10, 5, 64, NULL, '', 8100, 1, '5', 7695, 88, NULL, 188, 'false'),
(11, 5, 62, NULL, '', 90, 40, '5', 3420, 88, NULL, 188, 'false'),
(12, 5, 63, NULL, '', 130, 60, '5', 7410, 88, NULL, 188, 'false'),
(13, 5, 25, NULL, '', 350, 12, '5', 3990, 89, NULL, 188, 'false'),
(14, 5, 15, NULL, '', 54, 26, '5', 1333.8, 88, NULL, 188, 'false'),
(15, 5, 30, NULL, '', 2250, 2, '5', 4275, 88, NULL, 188, 'false'),
(16, 5, 31, NULL, '', 2700, 10, '5', 25650, 88, NULL, 188, 'false'),
(17, 5, 57, NULL, '', 16000, 1, '5', 15200, 88, NULL, 188, 'false'),
(18, 5, 35, NULL, '', 12500, 1, '5', 11875, 88, NULL, 188, 'false'),
(19, 5, 46, NULL, '', 13500, 1, '5', 12825, 88, NULL, 188, 'false'),
(20, 5, 61, NULL, '', 1600, 1, '5', 1520, 88, NULL, 188, 'false'),
(21, 5, 49, NULL, '', 10000, 1, '5', 9500, 88, NULL, 188, 'false'),
(22, 6, 66, NULL, '', 14750, 1, '', 14750, 89, NULL, 188, 'false'),
(23, 6, 67, NULL, '', 300, 1, '', 300, 88, NULL, 188, 'false'),
(24, 7, 73, NULL, '', 6300, 1, '7.5', 5827.5, 88, NULL, 188, 'false'),
(25, 7, 49, NULL, '', 4000, 1, '7.5', 3700, 88, NULL, 188, 'false'),
(26, 7, 8, NULL, '', 9500, 1, '7.5', 8787.5, 88, NULL, 188, 'false'),
(27, 7, 75, NULL, '', 75, 10, '7.5', 693.75, 88, NULL, 188, 'false'),
(28, 7, 76, NULL, '', 1250, 1, '7.5', 1156.25, 88, NULL, 188, 'false'),
(29, 7, 67, NULL, '', 500, 1, '7.5', 462.5, 88, NULL, 188, 'false'),
(30, 7, 74, NULL, '', 8200, 1, '7.5', 7585, 88, NULL, 188, 'false'),
(31, 7, 48, NULL, '', 5400, 1, '7.5', 4995, 88, NULL, 188, 'false'),
(32, 7, 9, NULL, '', 2250, 7, '7.5', 14568.8, 88, NULL, 188, 'false'),
(33, 7, 43, NULL, '', 9000, 1, '7.5', 8325, 88, NULL, 188, 'false'),
(34, 7, 23, NULL, '', 3200, 1, '7.5', 2960, 88, NULL, 188, 'false'),
(35, 7, 15, NULL, '', 54, 16, '7.5', 799.2, 88, NULL, 188, 'false'),
(36, 7, 10, NULL, '', 5400, 1, '7.5', 4995, 88, NULL, 188, 'false'),
(37, 7, 49, NULL, '', 5000, 1, '7.5', 4625, 88, NULL, 188, 'false'),
(38, 7, 56, NULL, '', 450, 1, '7.5', 416.25, 88, NULL, 188, 'false'),
(39, 7, 45, NULL, '', 600, 2, '7.5', 1110, 88, NULL, 188, 'false'),
(40, 7, 47, NULL, '', 3750, 2, '7.5', 6937.5, 88, NULL, 188, 'false'),
(41, 7, 59, NULL, '', 13500, 2, '7.5', 24975, 88, NULL, 188, 'false'),
(42, 7, 49, NULL, '', 4000, 1, '7.5', 3700, 88, NULL, 188, 'false'),
(43, 8, 10, NULL, 'Z523W2CG', 6900, 1, '', 6900, 88, NULL, 188, 'false'),
(44, 9, 80, NULL, '3E06803PAZ7D590', 13000, 1, '', 13000, 88, NULL, 188, 'false'),
(45, 10, 25, NULL, '', 350, 7, '', 2450, 88, NULL, 188, 'false'),
(46, 11, 1, NULL, '', 2700, 1, '', 2700, 88, NULL, 188, 'false'),
(47, 11, 2, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(48, 11, 42, NULL, '', 75, 1, '', 75, 88, NULL, 188, 'false'),
(49, 12, 22, NULL, '', 1200, 1, '', 1200, 88, NULL, 188, 'false'),
(50, 13, 104, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(51, 13, 22, NULL, '', 1200, 1, '', 1200, 88, NULL, 188, 'false'),
(52, 13, 105, NULL, '', 2700, 1, '', 2700, 88, NULL, 188, 'false'),
(53, 13, 28, NULL, '', 85, 25, '', 2125, 88, NULL, 188, 'false'),
(54, 13, 49, NULL, '', 2000, 1, '', 2000, 88, NULL, 188, 'false'),
(55, 13, 7, NULL, '3L0514APAPC4650', 12500, 1, '', 12500, 88, NULL, 188, 'false'),
(56, 13, 15, NULL, '', 54, 4, '', 216, 88, NULL, 188, 'false'),
(57, 13, 16, NULL, '', 30, 2, '', 60, 88, NULL, 188, 'false'),
(58, 13, 60, NULL, '', 360, 1, '', 360, 88, NULL, 188, 'false'),
(59, 13, 42, NULL, '', 75, 2, '', 150, 88, NULL, 188, 'false'),
(60, 14, 35, NULL, 'ZGY1PE6Q', 9800, 1, '', 9800, 88, NULL, 188, 'false'),
(61, 15, 24, NULL, '', 2100, 1, '', 2100, 88, NULL, 188, 'false'),
(62, 16, 49, NULL, '', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(63, 16, 51, NULL, '', 2700, 2, '', 5400, 88, NULL, 188, 'false'),
(64, 16, 50, NULL, '', 9000, 2, '', 18000, 88, NULL, 188, 'false'),
(65, 17, 42, NULL, '', 100, 1, '', 100, 88, NULL, 188, 'false'),
(66, 17, 16, NULL, '', 30, 1, '', 30, 88, NULL, 188, 'false'),
(67, 17, 15, NULL, '', 45, 1, '', 45, 88, NULL, 188, 'false'),
(68, 17, 12, NULL, '3D05ECDPAR00342', 3000, 1, '', 3000, 88, NULL, 188, 'false'),
(69, 18, 124, NULL, '3H05D68PAL06658', 2700, 1, '12', 2376, 88, NULL, 188, 'false'),
(70, 18, 22, NULL, '', 1350, 1, '12', 1188, 88, NULL, 188, 'false'),
(71, 18, 124, NULL, '3H04EF6PAL02230', 2700, 1, '12', 2376, 88, NULL, 188, 'false'),
(72, 18, 11, NULL, '3J080BFPBQBP371', 7500, 1, '12', 6600, 88, NULL, 188, 'false'),
(73, 18, 124, NULL, '3H04EF6PAL02712', 2700, 1, '12', 2376, 88, NULL, 188, 'false'),
(74, 18, 49, NULL, '', 5000, 1, '12', 4400, 88, NULL, 188, 'false'),
(75, 18, 123, NULL, 'Z9C50K3K', 5400, 1, '12', 4752, 88, NULL, 188, 'false'),
(76, 19, 126, NULL, '', 3000, 1, '', 3000, 88, NULL, 188, 'false'),
(77, 19, 125, NULL, '', 3000, 1, '', 3000, NULL, NULL, 188, 'false'),
(78, 20, 128, NULL, '', 800, 1, '', 800, 88, NULL, 188, 'false'),
(79, 21, 15, NULL, '', 35, 28, '', 980, 88, NULL, 188, 'false'),
(80, 21, 132, NULL, 'PI3L02E0CPAZ00038', 22500, 1, '', 22500, 88, NULL, 188, 'false'),
(81, 21, 132, NULL, 'PI3L02E0CPAZ00030', 22500, 1, '', 22500, 88, NULL, 188, 'false'),
(82, 21, 130, NULL, 'HP  06L16110732', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(83, 21, 130, NULL, 'HPN206L16110573', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(84, 21, 130, NULL, 'HPN   L16110590', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(85, 21, 130, NULL, 'HP  06 16110596', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(86, 21, 130, NULL, 'HPN206L16110597', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(87, 21, 130, NULL, 'HP 2 6L 6110598', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(88, 21, 130, NULL, 'H   06 16110578', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(89, 21, 131, NULL, 'HPN203CL171206163', 1600, 1, '', 1600, 88, NULL, 188, 'false'),
(90, 21, 131, NULL, 'HPN  3CL171206160', 1600, 1, '', 1600, 88, NULL, 188, 'false'),
(91, 21, 131, NULL, 'HP 2 3CL171206170', 1600, 1, '', 1600, 88, NULL, 188, 'false'),
(92, 21, 25, NULL, '', 350, 25, '', 8750, 88, NULL, 188, 'false'),
(93, 21, 134, NULL, '', 7750, 1, '', 7750, 88, NULL, 188, 'false'),
(94, 21, 135, NULL, '', 20000, 1, '', 20000, 88, NULL, 188, 'false'),
(95, 21, 16, NULL, '', 45, 60, '', 2700, 88, NULL, 188, 'false'),
(96, 21, 107, NULL, '', 65, 600, '', 39000, 88, NULL, 188, 'false'),
(97, 21, 129, NULL, 'H   0  L171208550', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(98, 21, 129, NULL, 'H   0  L171208545', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(99, 21, 129, NULL, 'HFN203CL171208558', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(100, 21, 129, NULL, 'HFN  3CL171208549', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(101, 21, 129, NULL, 'HFN203CL171208566', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(102, 21, 129, NULL, 'H   0  L171208547', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(103, 22, 50, NULL, '', 9000, 1, '', 9000, 88, NULL, 188, 'false'),
(104, 22, 136, NULL, '', 2700, 1, '', 2700, 88, NULL, 188, 'false'),
(105, 22, 49, NULL, '', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(106, 23, 139, NULL, 'ST48F089224OY', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(107, 24, 30, NULL, '', 14750, 0, '', 0, 88, NULL, 188, 'false'),
(108, 24, 151, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(109, 24, 150, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(110, 24, 149, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(111, 24, 148, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(112, 24, 147, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(113, 24, 146, NULL, '', 1, 0, '', 0, NULL, NULL, 188, 'false'),
(114, 24, 145, NULL, '', 1, 0, '', 0, NULL, NULL, 188, 'false'),
(115, 24, 144, NULL, '', 3, 0, '', 0, NULL, NULL, 188, 'false'),
(116, 24, 143, NULL, '', 7, 0, '', 0, NULL, NULL, 188, 'false'),
(117, 24, 142, NULL, '', 10, 0, '', 0, NULL, NULL, 188, 'false'),
(118, 24, 30, NULL, '', 14750, 1, '', 14750, 88, NULL, 188, 'false'),
(119, 24, 142, NULL, '', 0, 10, '', 0, NULL, NULL, 188, 'false'),
(120, 24, 143, NULL, '', 0, 7, '', 0, NULL, NULL, 188, 'false'),
(121, 24, 144, NULL, '', 0, 3, '', 0, NULL, NULL, 188, 'false'),
(122, 24, 145, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(123, 24, 145, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(124, 24, 146, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(125, 24, 147, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(126, 24, 148, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(127, 24, 149, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(128, 24, 150, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(129, 24, 151, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(130, 25, 151, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(131, 25, 150, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(132, 25, 149, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(133, 25, 148, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(134, 25, 147, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(135, 25, 146, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(136, 25, 145, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(137, 25, 144, NULL, '', 0, 3, '', 0, NULL, NULL, 188, 'false'),
(138, 25, 143, NULL, '', 0, 7, '', 0, NULL, NULL, 188, 'false'),
(139, 25, 142, NULL, '', 0, 10, '', 0, NULL, NULL, 188, 'false'),
(140, 25, 30, NULL, '', 14750, 1, '', 14750, 88, NULL, 188, 'false'),
(141, 26, 160, NULL, 'VAC1710095I1013', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(142, 26, 160, NULL, 'VAC1710095I1017', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(143, 26, 160, NULL, 'VAC1710095I2768', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(144, 26, 152, NULL, '', 500, 4, '5', 1900, 88, NULL, 188, 'false'),
(145, 26, 16, NULL, '', 45, 4, '', 180, 88, NULL, 188, 'false'),
(146, 26, 15, NULL, '', 35, 4, '', 140, 88, NULL, 188, 'false'),
(147, 26, 160, NULL, 'VAC1710095I1016', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(148, 27, 58, NULL, '', 500, 1, '', 500, 88, NULL, 188, 'false'),
(149, 28, 172, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(150, 28, 166, NULL, '', 0, 4, '', 0, NULL, NULL, 188, 'false'),
(151, 28, 171, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(152, 28, 170, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(153, 28, 154, NULL, '', 0, 30, '', 0, NULL, NULL, 188, 'false'),
(154, 29, 154, NULL, '', 0, 30, '', 0, NULL, NULL, 188, 'false'),
(155, 29, 170, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(156, 29, 171, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(157, 29, 166, NULL, '', 0, 4, '', 0, NULL, NULL, 188, 'false'),
(158, 29, 172, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(159, 30, 173, NULL, '', 2500, 1, '12', 2200, 88, NULL, 188, 'false'),
(160, 31, 25, NULL, '', 350, 1, '', 350, 88, NULL, 188, 'false'),
(161, 32, 24, NULL, '', 2100, 1, '', 2100, 88, NULL, 188, 'false'),
(162, 33, 16, NULL, '', 35, 2, '', 70, 88, NULL, 188, 'false'),
(163, 33, 104, NULL, 'VA  71 095A086938', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(164, 33, 104, NULL, 'VAC  10 95A085530', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(165, 33, 15, NULL, '', 45, 2, '', 90, 88, NULL, 188, 'false'),
(166, 33, 49, NULL, '', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(167, 34, 24, NULL, '', 2350, 1, '', 2350, 88, NULL, 188, 'false'),
(168, 35, 24, NULL, '', 2250, 3, '', 6750, 88, NULL, 188, 'false'),
(169, 36, 11, NULL, '3J080BFPBQ0X70R', 7000, 1, '10', 6300, 88, NULL, 188, 'false'),
(170, 36, 158, NULL, '3E04942PAG07156', 2500, 1, '10', 2250, 88, NULL, 188, 'false'),
(171, 36, 15, NULL, '', 45, 4, '', 180, 88, NULL, 188, 'false'),
(172, 36, 162, NULL, '', 3900, 1, '10', 3510, 88, NULL, 188, 'false'),
(173, 36, 158, NULL, '3E04942PAG05706', 2500, 1, '10', 2250, 88, NULL, 188, 'false'),
(174, 36, 16, NULL, '', 35, 2, '', 70, 88, NULL, 188, 'false'),
(175, 36, 49, NULL, '', 1500, 1, '10', 1350, 88, NULL, 188, 'false'),
(176, 36, 107, NULL, '', 65, 50, '10', 2925, 88, NULL, 188, 'false'),
(177, 36, 22, NULL, '', 1350, 1, '10', 1215, 88, NULL, 188, 'false'),
(178, 37, 121, NULL, '', 1900, 5, '', 9500, 88, NULL, 188, 'false'),
(179, 38, 179, NULL, '', 600, 1, '', 600, 88, NULL, 188, 'false'),
(180, 39, 2, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(181, 40, 6, NULL, '1K0230SPAL09736', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(182, 40, 5, NULL, '3F00B42GAL00795', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(183, 40, 6, NULL, '1K0230SPAL09736', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(184, 40, 15, NULL, '', 45, 6, '', 270, 88, NULL, 188, 'false'),
(185, 40, 16, NULL, '', 35, 3, '', 105, 88, NULL, 188, 'false'),
(186, 40, 6, NULL, '1K0230SPAL09739', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(187, 41, 180, NULL, '', 110, 10, '', 1100, 88, NULL, 188, 'false'),
(188, 42, 42, NULL, '', 100, 3, '', 300, 88, NULL, 188, 'false'),
(189, 42, 49, NULL, '', 5000, 1, '', 5000, 88, NULL, 188, 'false'),
(190, 42, 10, NULL, 'Z526C5KA', 5400, 1, '', 5400, 88, NULL, 188, 'false'),
(191, 42, 15, NULL, '', 45, 4, '', 180, 88, NULL, 188, 'false'),
(192, 42, 11, NULL, '4A01A89PAZ0FA03', 7000, 1, '', 7000, 88, NULL, 188, 'false'),
(193, 42, 25, NULL, '', 350, 1, '', 350, 88, NULL, 188, 'false'),
(194, 42, 6, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(195, 42, 181, NULL, '', 90, 50, '', 4500, 88, NULL, 188, 'false'),
(196, 42, 65, NULL, '', 65, 45, '', 2925, 88, NULL, 188, 'false'),
(197, 42, 176, NULL, '', 950, 1, '', 950, 88, NULL, 188, 'false'),
(198, 43, 49, NULL, '', 600, 9, '', 5400, 88, NULL, 188, 'false'),
(199, 43, 16, NULL, '', 45, 9, '', 405, 88, NULL, 188, 'false'),
(200, 43, 129, NULL, '', 1900, 9, '', 17100, 88, NULL, 188, 'false'),
(201, 43, 15, NULL, '', 54, 18, '', 972, 88, NULL, 188, 'false'),
(202, 44, 23, NULL, '', 1800, 1, '', 1800, 88, NULL, 188, 'false'),
(203, 47, 104, NULL, 'vac1710095a076767', 2150, 1, '', 2150, 88, NULL, 188, 'false'),
(204, 47, 42, NULL, '', 100, 2, '', 200, 88, NULL, 188, 'false'),
(205, 47, 104, NULL, 'vac1708315a47507', 2150, 1, '', 2150, 88, NULL, 188, 'false'),
(206, 48, 159, NULL, '', 2542, 1, '', 2542, 88, NULL, 188, 'false'),
(207, 48, 104, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(208, 48, 23, NULL, '', 1800, 1, '', 1800, 88, NULL, 188, 'false'),
(209, 48, 12, NULL, '', 3000, 1, '', 3000, 88, NULL, 188, 'false'),
(210, 52, 6, NULL, '3J065B0PAR01464', 2700, 1, '5', 2565, 88, NULL, 188, 'false'),
(211, 52, 35, NULL, 'ZDH4PGA4', 9500, 1, '5', 9025, 88, NULL, 188, 'false'),
(212, 52, 23, NULL, '', 1800, 1, '5', 1710, 88, NULL, 188, 'false'),
(213, 52, 108, NULL, '3G0007CPA532450', 9000, 1, '5', 8550, 88, NULL, 188, 'false'),
(214, 52, 49, NULL, '', 2000, 1, '5', 1900, 88, NULL, 188, 'false'),
(215, 52, 15, NULL, '', 45, 15, '5', 641.25, 88, NULL, 188, 'false'),
(216, 52, 196, NULL, '', 2500, 4, '5', 9500, 88, NULL, 188, 'false'),
(217, 53, 162, NULL, '', 3900, 2, '', 7800, 88, NULL, 188, 'false'),
(218, 60, 220, NULL, '', 2100, 1, '', 2100, 89, NULL, 188, 'false'),
(219, 62, 237, NULL, '', 1200, 1, '', 1200, 88, NULL, 188, 'false'),
(220, 63, 210, NULL, '', 100, 1, '', 100, 88, NULL, 188, 'false'),
(221, 63, 237, NULL, '', 100, 1, '', 100, 88, NULL, 188, 'false'),
(222, 63, 253, NULL, '3H0373DPBQ2HXU9', 13000, 1, '', 13000, 88, NULL, 188, 'false'),
(223, 64, 261, NULL, '', 65, 250, '5', 15437.5, 88, NULL, 188, 'false'),
(224, 64, 224, NULL, '', 90, 50, '5', 4275, 88, NULL, 188, 'false'),
(225, 64, 256, NULL, '', 360, 8, '5', 2736, 88, NULL, 188, 'false'),
(226, 64, 244, NULL, '', 5400, 1, '5', 5130, 88, NULL, 188, 'false'),
(227, 64, 260, NULL, '', 8100, 1, '5', 7695, 88, NULL, 188, 'false'),
(228, 64, 258, NULL, '', 90, 40, '5', 3420, 88, NULL, 188, 'false'),
(229, 64, 259, NULL, '', 130, 60, '5', 7410, 88, NULL, 188, 'false'),
(230, 64, 221, NULL, '', 350, 12, '5', 3990, 89, NULL, 188, 'false'),
(231, 64, 211, NULL, '', 54, 26, '5', 1333.8, 88, NULL, 188, 'false'),
(232, 64, 226, NULL, '', 2250, 2, '5', 4275, 88, NULL, 188, 'false'),
(233, 64, 227, NULL, '', 2700, 10, '5', 25650, 88, NULL, 188, 'false'),
(234, 64, 253, NULL, '', 16000, 1, '5', 15200, 88, NULL, 188, 'false'),
(235, 64, 231, NULL, '', 12500, 1, '5', 11875, 88, NULL, 188, 'false'),
(236, 64, 242, NULL, '', 13500, 1, '5', 12825, 88, NULL, 188, 'false'),
(237, 64, 257, NULL, '', 1600, 1, '5', 1520, 88, NULL, 188, 'false'),
(238, 64, 245, NULL, '', 10000, 1, '5', 9500, 88, NULL, 188, 'false'),
(239, 65, 262, NULL, '', 14750, 1, '', 14750, 89, NULL, 188, 'false'),
(240, 65, 263, NULL, '', 300, 1, '', 300, 88, NULL, 188, 'false'),
(241, 66, 269, NULL, '', 6300, 1, '7.5', 5827.5, 88, NULL, 188, 'false'),
(242, 66, 245, NULL, '', 4000, 1, '7.5', 3700, 88, NULL, 188, 'false'),
(243, 66, 204, NULL, '', 9500, 1, '7.5', 8787.5, 88, NULL, 188, 'false'),
(244, 66, 271, NULL, '', 75, 10, '7.5', 693.75, 88, NULL, 188, 'false'),
(245, 66, 272, NULL, '', 1250, 1, '7.5', 1156.25, 88, NULL, 188, 'false'),
(246, 66, 263, NULL, '', 500, 1, '7.5', 462.5, 88, NULL, 188, 'false'),
(247, 66, 270, NULL, '', 8200, 1, '7.5', 7585, 88, NULL, 188, 'false'),
(248, 66, 244, NULL, '', 5400, 1, '7.5', 4995, 88, NULL, 188, 'false'),
(249, 66, 205, NULL, '', 2250, 7, '7.5', 14568.8, 88, NULL, 188, 'false'),
(250, 66, 239, NULL, '', 9000, 1, '7.5', 8325, 88, NULL, 188, 'false'),
(251, 66, 219, NULL, '', 3200, 1, '7.5', 2960, 88, NULL, 188, 'false'),
(252, 66, 211, NULL, '', 54, 16, '7.5', 799.2, 88, NULL, 188, 'false'),
(253, 66, 206, NULL, '', 5400, 1, '7.5', 4995, 88, NULL, 188, 'false'),
(254, 66, 245, NULL, '', 5000, 1, '7.5', 4625, 88, NULL, 188, 'false'),
(255, 66, 252, NULL, '', 450, 1, '7.5', 416.25, 88, NULL, 188, 'false'),
(256, 66, 241, NULL, '', 600, 2, '7.5', 1110, 88, NULL, 188, 'false'),
(257, 66, 243, NULL, '', 3750, 2, '7.5', 6937.5, 88, NULL, 188, 'false'),
(258, 66, 255, NULL, '', 13500, 2, '7.5', 24975, 88, NULL, 188, 'false'),
(259, 66, 245, NULL, '', 4000, 1, '7.5', 3700, 88, NULL, 188, 'false'),
(260, 67, 206, NULL, 'Z523W2CG', 6900, 1, '', 6900, 88, NULL, 188, 'false'),
(261, 68, 276, NULL, '3E06803PAZ7D590', 13000, 1, '', 13000, 88, NULL, 188, 'false'),
(262, 69, 221, NULL, '', 350, 7, '', 2450, 88, NULL, 188, 'false'),
(263, 70, 197, NULL, '', 2700, 1, '', 2700, 88, NULL, 188, 'false'),
(264, 70, 198, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(265, 70, 238, NULL, '', 75, 1, '', 75, 88, NULL, 188, 'false'),
(266, 71, 218, NULL, '', 1200, 1, '', 1200, 88, NULL, 188, 'false'),
(267, 72, 300, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(268, 72, 218, NULL, '', 1200, 1, '', 1200, 88, NULL, 188, 'false'),
(269, 72, 301, NULL, '', 2700, 1, '', 2700, 88, NULL, 188, 'false'),
(270, 72, 224, NULL, '', 85, 25, '', 2125, 88, NULL, 188, 'false'),
(271, 72, 245, NULL, '', 2000, 1, '', 2000, 88, NULL, 188, 'false'),
(272, 72, 203, NULL, '3L0514APAPC4650', 12500, 1, '', 12500, 88, NULL, 188, 'false'),
(273, 72, 211, NULL, '', 54, 4, '', 216, 88, NULL, 188, 'false'),
(274, 72, 212, NULL, '', 30, 2, '', 60, 88, NULL, 188, 'false'),
(275, 72, 256, NULL, '', 360, 1, '', 360, 88, NULL, 188, 'false'),
(276, 72, 238, NULL, '', 75, 2, '', 150, 88, NULL, 188, 'false'),
(277, 73, 231, NULL, 'ZGY1PE6Q', 9800, 1, '', 9800, 88, NULL, 188, 'false'),
(278, 74, 220, NULL, '', 2100, 1, '', 2100, 88, NULL, 188, 'false'),
(279, 75, 245, NULL, '', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(280, 75, 247, NULL, '', 2700, 2, '', 5400, 88, NULL, 188, 'false'),
(281, 75, 246, NULL, '', 9000, 2, '', 18000, 88, NULL, 188, 'false'),
(282, 76, 238, NULL, '', 100, 1, '', 100, 88, NULL, 188, 'false'),
(283, 76, 212, NULL, '', 30, 1, '', 30, 88, NULL, 188, 'false'),
(284, 76, 211, NULL, '', 45, 1, '', 45, 88, NULL, 188, 'false'),
(285, 76, 208, NULL, '3D05ECDPAR00342', 3000, 1, '', 3000, 88, NULL, 188, 'false'),
(286, 77, 320, NULL, '3H05D68PAL06658', 2700, 1, '12', 2376, 88, NULL, 188, 'false'),
(287, 77, 218, NULL, '', 1350, 1, '12', 1188, 88, NULL, 188, 'false'),
(288, 77, 320, NULL, '3H04EF6PAL02230', 2700, 1, '12', 2376, 88, NULL, 188, 'false'),
(289, 77, 207, NULL, '3J080BFPBQBP371', 7500, 1, '12', 6600, 88, NULL, 188, 'false'),
(290, 77, 320, NULL, '3H04EF6PAL02712', 2700, 1, '12', 2376, 88, NULL, 188, 'false'),
(291, 77, 245, NULL, '', 5000, 1, '12', 4400, 88, NULL, 188, 'false'),
(292, 77, 319, NULL, 'Z9C50K3K', 5400, 1, '12', 4752, 88, NULL, 188, 'false'),
(293, 78, 322, NULL, '', 3000, 1, '', 3000, 88, NULL, 188, 'false'),
(294, 78, 321, NULL, '', 3000, 1, '', 3000, NULL, NULL, 188, 'false'),
(295, 79, 324, NULL, '', 800, 1, '', 800, 88, NULL, 188, 'false'),
(296, 80, 211, NULL, '', 35, 28, '', 980, 88, NULL, 188, 'false'),
(297, 80, 328, NULL, 'PI3L02E0CPAZ00038', 22500, 1, '', 22500, 88, NULL, 188, 'false'),
(298, 80, 328, NULL, 'PI3L02E0CPAZ00030', 22500, 1, '', 22500, 88, NULL, 188, 'false'),
(299, 80, 326, NULL, 'HP  06L16110732', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(300, 80, 326, NULL, 'HPN206L16110573', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(301, 80, 326, NULL, 'HPN   L16110590', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(302, 80, 326, NULL, 'HP  06 16110596', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(303, 80, 326, NULL, 'HPN206L16110597', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(304, 80, 326, NULL, 'HP 2 6L 6110598', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(305, 80, 326, NULL, 'H   06 16110578', 2300, 1, '', 2300, 88, NULL, 188, 'false'),
(306, 80, 327, NULL, 'HPN203CL171206163', 1600, 1, '', 1600, 88, NULL, 188, 'false'),
(307, 80, 327, NULL, 'HPN  3CL171206160', 1600, 1, '', 1600, 88, NULL, 188, 'false'),
(308, 80, 327, NULL, 'HP 2 3CL171206170', 1600, 1, '', 1600, 88, NULL, 188, 'false'),
(309, 80, 221, NULL, '', 350, 25, '', 8750, 88, NULL, 188, 'false'),
(310, 80, 330, NULL, '', 7750, 1, '', 7750, 88, NULL, 188, 'false'),
(311, 80, 331, NULL, '', 20000, 1, '', 20000, 88, NULL, 188, 'false'),
(312, 80, 212, NULL, '', 45, 60, '', 2700, 88, NULL, 188, 'false'),
(313, 80, 303, NULL, '', 65, 600, '', 39000, 88, NULL, 188, 'false'),
(314, 80, 325, NULL, 'H   0  L171208550', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(315, 80, 325, NULL, 'H   0  L171208545', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(316, 80, 325, NULL, 'HFN203CL171208558', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(317, 80, 325, NULL, 'HFN  3CL171208549', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(318, 80, 325, NULL, 'HFN203CL171208566', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(319, 80, 325, NULL, 'H   0  L171208547', 1550, 1, '', 1550, 88, NULL, 188, 'false'),
(320, 81, 246, NULL, '', 9000, 1, '', 9000, 88, NULL, 188, 'false'),
(321, 81, 332, NULL, '', 2700, 1, '', 2700, 88, NULL, 188, 'false'),
(322, 81, 245, NULL, '', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(323, 82, 335, NULL, 'ST48F089224OY', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(324, 83, 226, NULL, '', 14750, 0, '', 0, 88, NULL, 188, 'false'),
(325, 83, 347, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(326, 83, 346, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(327, 83, 345, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(328, 83, 344, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(329, 83, 343, NULL, '', 2, 0, '', 0, NULL, NULL, 188, 'false'),
(330, 83, 342, NULL, '', 1, 0, '', 0, NULL, NULL, 188, 'false'),
(331, 83, 341, NULL, '', 1, 0, '', 0, NULL, NULL, 188, 'false'),
(332, 83, 340, NULL, '', 3, 0, '', 0, NULL, NULL, 188, 'false'),
(333, 83, 339, NULL, '', 7, 0, '', 0, NULL, NULL, 188, 'false'),
(334, 83, 338, NULL, '', 10, 0, '', 0, NULL, NULL, 188, 'false'),
(335, 83, 226, NULL, '', 14750, 1, '', 14750, 88, NULL, 188, 'false'),
(336, 83, 338, NULL, '', 0, 10, '', 0, NULL, NULL, 188, 'false'),
(337, 83, 339, NULL, '', 0, 7, '', 0, NULL, NULL, 188, 'false'),
(338, 83, 340, NULL, '', 0, 3, '', 0, NULL, NULL, 188, 'false'),
(339, 83, 341, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(340, 83, 341, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(341, 83, 342, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(342, 83, 343, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(343, 83, 344, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(344, 83, 345, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(345, 83, 346, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(346, 83, 347, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(347, 84, 347, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(348, 84, 346, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(349, 84, 345, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(350, 84, 344, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(351, 84, 343, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(352, 84, 342, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(353, 84, 341, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(354, 84, 340, NULL, '', 0, 3, '', 0, NULL, NULL, 188, 'false'),
(355, 84, 339, NULL, '', 0, 7, '', 0, NULL, NULL, 188, 'false'),
(356, 84, 338, NULL, '', 0, 10, '', 0, NULL, NULL, 188, 'false'),
(357, 84, 226, NULL, '', 14750, 1, '', 14750, 88, NULL, 188, 'false'),
(358, 85, 356, NULL, 'VAC1710095I1013', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(359, 85, 356, NULL, 'VAC1710095I1017', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(360, 85, 356, NULL, 'VAC1710095I2768', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(361, 85, 348, NULL, '', 500, 4, '5', 1900, 88, NULL, 188, 'false'),
(362, 85, 212, NULL, '', 45, 4, '', 180, 88, NULL, 188, 'false'),
(363, 85, 211, NULL, '', 35, 4, '', 140, 88, NULL, 188, 'false'),
(364, 85, 356, NULL, 'VAC1710095I1016', 2800, 1, '5', 2660, 88, NULL, 188, 'false'),
(365, 86, 254, NULL, '', 500, 1, '', 500, 88, NULL, 188, 'false'),
(366, 87, 368, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(367, 87, 362, NULL, '', 0, 4, '', 0, NULL, NULL, 188, 'false'),
(368, 87, 367, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(369, 87, 366, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(370, 87, 350, NULL, '', 0, 30, '', 0, NULL, NULL, 188, 'false'),
(371, 88, 350, NULL, '', 0, 30, '', 0, NULL, NULL, 188, 'false'),
(372, 88, 366, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(373, 88, 367, NULL, '', 0, 2, '', 0, NULL, NULL, 188, 'false'),
(374, 88, 362, NULL, '', 0, 4, '', 0, NULL, NULL, 188, 'false'),
(375, 88, 368, NULL, '', 0, 1, '', 0, NULL, NULL, 188, 'false'),
(376, 89, 369, NULL, '', 2500, 1, '12', 2200, 88, NULL, 188, 'false'),
(377, 90, 221, NULL, '', 350, 1, '', 350, 88, NULL, 188, 'false'),
(378, 91, 220, NULL, '', 2100, 1, '', 2100, 88, NULL, 188, 'false'),
(379, 92, 212, NULL, '', 35, 2, '', 70, 88, NULL, 188, 'false'),
(380, 92, 300, NULL, 'VA  71 095A086938', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(381, 92, 300, NULL, 'VAC  10 95A085530', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(382, 92, 211, NULL, '', 45, 2, '', 90, 88, NULL, 188, 'false'),
(383, 92, 245, NULL, '', 1000, 1, '', 1000, 88, NULL, 188, 'false'),
(384, 93, 220, NULL, '', 2350, 1, '', 2350, 88, NULL, 188, 'false'),
(385, 94, 220, NULL, '', 2250, 3, '', 6750, 88, NULL, 188, 'false'),
(386, 95, 207, NULL, '3J080BFPBQ0X70R', 7000, 1, '10', 6300, 88, NULL, 188, 'false'),
(387, 95, 354, NULL, '3E04942PAG07156', 2500, 1, '10', 2250, 88, NULL, 188, 'false'),
(388, 95, 211, NULL, '', 45, 4, '', 180, 88, NULL, 188, 'false'),
(389, 95, 358, NULL, '', 3900, 1, '10', 3510, 88, NULL, 188, 'false'),
(390, 95, 354, NULL, '3E04942PAG05706', 2500, 1, '10', 2250, 88, NULL, 188, 'false'),
(391, 95, 212, NULL, '', 35, 2, '', 70, 88, NULL, 188, 'false'),
(392, 95, 245, NULL, '', 1500, 1, '10', 1350, 88, NULL, 188, 'false'),
(393, 95, 303, NULL, '', 65, 50, '10', 2925, 88, NULL, 188, 'false'),
(394, 95, 218, NULL, '', 1350, 1, '10', 1215, 88, NULL, 188, 'false'),
(395, 96, 317, NULL, '', 1900, 5, '', 9500, 88, NULL, 188, 'false'),
(396, 97, 375, NULL, '', 600, 1, '', 600, 88, NULL, 188, 'false'),
(397, 98, 198, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(398, 99, 202, NULL, '1K0230SPAL09736', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(399, 99, 201, NULL, '3F00B42GAL00795', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(400, 99, 202, NULL, '1K0230SPAL09736', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(401, 99, 211, NULL, '', 45, 6, '', 270, 88, NULL, 188, 'false'),
(402, 99, 212, NULL, '', 35, 3, '', 105, 88, NULL, 188, 'false'),
(403, 99, 202, NULL, '1K0230SPAL09739', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(404, 100, 376, NULL, '', 110, 10, '', 1100, 88, NULL, 188, 'false'),
(405, 101, 238, NULL, '', 100, 3, '', 300, 88, NULL, 188, 'false'),
(406, 101, 245, NULL, '', 5000, 1, '', 5000, 88, NULL, 188, 'false'),
(407, 101, 206, NULL, 'Z526C5KA', 5400, 1, '', 5400, 88, NULL, 188, 'false'),
(408, 101, 211, NULL, '', 45, 4, '', 180, 88, NULL, 188, 'false'),
(409, 101, 207, NULL, '4A01A89PAZ0FA03', 7000, 1, '', 7000, 88, NULL, 188, 'false'),
(410, 101, 221, NULL, '', 350, 1, '', 350, 88, NULL, 188, 'false'),
(411, 101, 202, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(412, 101, 377, NULL, '', 90, 50, '', 4500, 88, NULL, 188, 'false'),
(413, 101, 261, NULL, '', 65, 45, '', 2925, 88, NULL, 188, 'false'),
(414, 101, 372, NULL, '', 950, 1, '', 950, 88, NULL, 188, 'false'),
(415, 102, 245, NULL, '', 600, 9, '', 5400, 88, NULL, 188, 'false'),
(416, 102, 212, NULL, '', 45, 9, '', 405, 88, NULL, 188, 'false'),
(417, 102, 325, NULL, '', 1900, 9, '', 17100, 88, NULL, 188, 'false'),
(418, 102, 211, NULL, '', 54, 18, '', 972, 88, NULL, 188, 'false'),
(419, 103, 219, NULL, '', 1800, 1, '', 1800, 88, NULL, 188, 'false'),
(420, 106, 300, NULL, 'vac1710095a076767', 2150, 1, '', 2150, 88, NULL, 188, 'false'),
(421, 106, 238, NULL, '', 100, 2, '', 200, 88, NULL, 188, 'false'),
(422, 106, 300, NULL, 'vac1708315a47507', 2150, 1, '', 2150, 88, NULL, 188, 'false'),
(423, 107, 355, NULL, '', 2542, 1, '', 2542, 88, NULL, 188, 'false'),
(424, 107, 300, NULL, '', 2500, 1, '', 2500, 88, NULL, 188, 'false'),
(425, 107, 219, NULL, '', 1800, 1, '', 1800, 88, NULL, 188, 'false'),
(426, 107, 208, NULL, '', 3000, 1, '', 3000, 88, NULL, 188, 'false'),
(427, 111, 202, NULL, '3J065B0PAR01464', 2700, 1, '5', 2565, 88, NULL, 188, 'false'),
(428, 111, 231, NULL, 'ZDH4PGA4', 9500, 1, '5', 9025, 88, NULL, 188, 'false'),
(429, 111, 219, NULL, '', 1800, 1, '5', 1710, 88, NULL, 188, 'false'),
(430, 111, 304, NULL, '3G0007CPA532450', 9000, 1, '5', 8550, 88, NULL, 188, 'false'),
(431, 111, 245, NULL, '', 2000, 1, '5', 1900, 88, NULL, 188, 'false'),
(432, 111, 211, NULL, '', 45, 15, '5', 641.25, 88, NULL, 188, 'false'),
(433, 111, 392, NULL, '', 2500, 4, '5', 9500, 88, NULL, 188, 'false'),
(434, 112, 358, NULL, '', 3900, 2, '', 7800, 88, NULL, 188, 'false'),
(444, 119, 1, NULL, '123', 2700, 12, '', 32400, 87, NULL, 188, 'false'),
(437, 120, 393, NULL, '12', 12, 12, '12', 144, 87, NULL, 188, 'false'),
(1115, 129, 413, NULL, '087654321101', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1114, 129, 413, NULL, '087654321110', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1113, 129, 413, NULL, '8765432159', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1112, 129, 413, NULL, '087654321129', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1111, 129, 413, NULL, '8765432166', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1110, 129, 413, NULL, '8765432197', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1099, 125, 402, NULL, '12', 10, 1, '', 10, 90, NULL, 1, 'false'),
(1109, 129, 413, NULL, '8765432173', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1011, 123, 410, NULL, '', 120, 5, '', 600, 90, NULL, 1, ''),
(1084, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1083, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1082, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1081, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1080, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1079, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1078, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1077, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1076, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1075, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1074, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1073, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1072, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1071, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1070, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1069, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1068, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1067, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1066, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1065, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1064, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1063, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1062, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1061, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1060, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1059, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1058, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1057, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1056, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1055, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1054, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1053, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1052, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1051, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1050, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1049, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1048, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1047, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1046, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1045, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1044, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1043, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1042, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1041, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1040, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1039, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1038, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1037, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1036, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1035, 121, 416, NULL, '1234', 12, 10, '', 120, 90, NULL, 1, 'true'),
(1034, 121, 394, NULL, '12', 1000, 1, '', 1000, 90, NULL, 1, 'true'),
(1033, 121, 416, NULL, '123', 12, 2, '', 24, 90, NULL, 1, 'true'),
(1032, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1031, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1030, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1029, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1028, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1027, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1026, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1025, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1024, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1023, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1022, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1021, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1020, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1019, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1018, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1017, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1016, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1015, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1014, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1013, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1012, 121, 416, NULL, '', 0, 0, '', 0, 0, NULL, 1, 'false'),
(1116, 129, 413, NULL, '8765432180', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1117, 130, 413, NULL, '8765432173', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1118, 130, 413, NULL, '8765432197', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1119, 130, 413, NULL, '8765432166', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1120, 130, 413, NULL, '087654321129', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1121, 130, 413, NULL, '8765432159', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1122, 130, 413, NULL, '087654321110', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1123, 130, 413, NULL, '087654321101', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1124, 130, 413, NULL, '8765432180', 1000, 1, NULL, 1000, 90, NULL, 1, 'false'),
(1140, 131, 413, NULL, '8765432180', 1000, 1, '', 1000, 90, NULL, 1, 'false'),
(1139, 131, 413, NULL, '087654321101', 1000, 1, '', 1000, 90, NULL, 1, 'false'),
(1138, 131, 413, NULL, '087654321110', 1000, 1, '', 1000, 90, NULL, 1, 'false'),
(1137, 131, 413, NULL, '8765432159', 1000, 1, '', 1000, 90, NULL, 1, 'false'),
(1136, 131, 413, NULL, '087654321129', 1000, 1, '', 1000, 90, NULL, 1, 'false'),
(1135, 131, 413, NULL, '8765432166', 1000, 1, '', 1000, 90, NULL, 1, 'false'),
(1134, 131, 413, NULL, '8765432197', 1000, 1, '', 1000, 90, NULL, 1, 'false'),
(1133, 131, 413, NULL, '8765432173', 1000, 1, '', 1000, 90, NULL, 1, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice_product_taxes`
--

CREATE TABLE `i_ext_et_invoice_product_taxes` (
  `iexteinpt_id` int(11) NOT NULL,
  `iexteinpt_d_id` int(11) DEFAULT NULL,
  `iexteinpt_p_id` int(11) DEFAULT NULL,
  `iexteinpt_t_id` int(11) DEFAULT NULL,
  `iexteinpt_t_name` varchar(100) DEFAULT NULL,
  `iexteinpt_t_percent` float DEFAULT NULL,
  `iexteinpt_t_amount` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice_property`
--

CREATE TABLE `i_ext_et_invoice_property` (
  `iexteinpt_id` int(11) NOT NULL,
  `iexteinpt_inid` int(11) DEFAULT NULL,
  `iexteinpt_property_value` varchar(200) DEFAULT NULL,
  `iexteinpt_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_invoice_property`
--

INSERT INTO `i_ext_et_invoice_property` (`iexteinpt_id`, `iexteinpt_inid`, `iexteinpt_property_value`, `iexteinpt_status`) VALUES
(18, 3, 'vinayalokhande1993@gmail.com', 'false'),
(19, 3, '400011', 'false'),
(20, 3, 'maharashtra', 'false'),
(21, 3, '2227794086', 'false'),
(22, 3, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(23, 3, '400708', 'false'),
(24, 3, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(30, 4, 'Maharashtra', 'false'),
(31, 4, '400011', 'false'),
(32, 4, '18/48', 'false'),
(33, 4, 'krishnakant@evomata.com', 'false'),
(34, 4, '9821406714', 'false'),
(50, 2, 'Maharashtra', 'true'),
(51, 2, '400011', 'false'),
(52, 2, '18/48', 'true'),
(53, 2, 'krishnakant@evomata.com', 'true'),
(54, 2, '9821406714', 'true'),
(55, 5, 'krishnakant@evomata.com', 'false'),
(84, 6, 'vinayalokhande1993@gmail.com', 'false'),
(85, 6, '400011', 'false'),
(86, 6, 'maharashtra', 'false'),
(87, 6, '2227794086', 'false'),
(88, 6, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(89, 6, '400708', 'false'),
(90, 6, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(96, 7, 'Maharashtra', 'false'),
(97, 7, '400011', 'false'),
(98, 7, '18/48', 'false'),
(99, 7, 'krishnakant@evomata.com', 'false'),
(100, 7, '9821406714', 'false'),
(108, 8, 'vinayalokhande1993@gmail.com', 'false'),
(109, 8, '400011', 'false'),
(110, 8, 'maharashtra', 'false'),
(111, 8, '2227794086', 'false'),
(112, 8, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(113, 8, '400708', 'false'),
(114, 8, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(120, 9, 'Maharashtra', 'false'),
(121, 9, '400011', 'false'),
(122, 9, '18/48', 'false'),
(123, 9, 'krishnakant@evomata.com', 'false'),
(124, 9, '9821406714', 'false'),
(130, 10, 'Maharashtra', 'false'),
(131, 10, '400011', 'false'),
(132, 10, '18/48', 'false'),
(133, 10, 'krishnakant@evomata.com', 'false'),
(134, 10, '9821406714', 'false'),
(135, 11, 'krishnakant@evomata.com', 'false'),
(137, 13, 'krishnakant@evomata.com', 'false'),
(140, 12, 'krishnakant@evomata.com', 'false'),
(156, 14, 'Maharashtra', 'true'),
(157, 14, '400011', 'false'),
(158, 14, '18/48', 'true'),
(159, 14, 'krishnakant@evomata.com', 'false'),
(160, 14, '9821406714', 'false'),
(176, 15, 'Maharashtra', 'false'),
(177, 15, '400011', 'false'),
(178, 15, '18/48', 'false'),
(179, 15, 'krishnakant@evomata.com', 'false'),
(180, 15, '9821406714', 'false'),
(184, 120, 'kpatole2@gmail.com', 'false'),
(191, 119, 'krishnakant@evomata.com', 'false'),
(219, 123, 'krishnakant@evomata.com', 'true'),
(220, 121, 'krishnakant@evomata.com', 'true'),
(221, 121, '18/48 harharwala bldg. n. m. joshi marg mumbai 400011.', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice_tags`
--

CREATE TABLE `i_ext_et_invoice_tags` (
  `iexteint_id` int(11) NOT NULL,
  `iexteint_txn_id` int(11) DEFAULT NULL,
  `iexteint_tag_id` int(11) DEFAULT NULL,
  `iexteint_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_invoice_terms`
--

CREATE TABLE `i_ext_et_invoice_terms` (
  `iexteintm_id` int(11) NOT NULL,
  `iexteintm_inid` int(11) DEFAULT NULL,
  `iexteintm_term_id` int(11) DEFAULT NULL,
  `iexteintm_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_invoice_terms`
--

INSERT INTO `i_ext_et_invoice_terms` (`iexteintm_id`, `iexteintm_inid`, `iexteintm_term_id`, `iexteintm_status`) VALUES
(10, 3, 55, 'false'),
(11, 3, 59, 'false'),
(12, 3, 65, 'false'),
(16, 4, 55, 'false'),
(17, 4, 59, 'false'),
(18, 4, 65, 'false'),
(28, 2, 55, 'false'),
(29, 2, 59, 'false'),
(30, 2, 65, 'false'),
(31, 5, 55, 'false'),
(32, 5, 59, 'false'),
(33, 5, 65, 'false'),
(46, 6, 55, 'false'),
(47, 6, 59, 'false'),
(48, 6, 65, 'false'),
(52, 7, 55, 'false'),
(53, 7, 59, 'false'),
(54, 7, 65, 'false'),
(58, 8, 55, 'false'),
(59, 8, 59, 'false'),
(60, 8, 65, 'false'),
(64, 9, 55, 'false'),
(65, 9, 59, 'false'),
(66, 9, 65, 'false'),
(70, 10, 55, 'true'),
(71, 10, 59, 'false'),
(72, 10, 65, 'false'),
(73, 11, 55, 'false'),
(74, 11, 59, 'false'),
(75, 11, 65, 'false'),
(79, 13, 55, 'false'),
(80, 13, 59, 'false'),
(81, 13, 65, 'false'),
(88, 12, 55, 'false'),
(89, 12, 59, 'false'),
(90, 12, 65, 'false'),
(100, 14, 55, 'true'),
(101, 14, 59, 'true'),
(102, 14, 65, 'false'),
(112, 15, 55, 'false'),
(113, 15, 59, 'false'),
(114, 15, 65, 'false'),
(115, 3, 0, 'false'),
(116, 3, 0, 'false'),
(117, 3, 0, 'false'),
(118, 3, 0, 'true'),
(119, 3, 0, 'false'),
(120, 3, 0, 'false'),
(121, 3, 0, 'false'),
(122, 3, 0, 'false'),
(123, 3, 0, 'false'),
(124, 3, 0, 'false'),
(125, 3, 0, 'false'),
(126, 3, 0, 'false'),
(127, 3, 0, 'false'),
(128, 3, 0, 'false'),
(129, 3, 0, 'false'),
(130, 3, 0, 'false'),
(131, 3, 0, 'false'),
(132, 3, 0, 'false'),
(133, 3, 0, 'false'),
(134, 3, 0, 'false'),
(135, 3, 0, 'false'),
(136, 3, 0, 'false'),
(137, 3, 0, 'false'),
(138, 3, 0, 'false'),
(139, 3, 0, 'false'),
(140, 3, 0, 'false'),
(141, 3, 0, 'false'),
(142, 3, 0, 'false'),
(143, 3, 0, 'false'),
(144, 3, 0, 'true'),
(145, 3, 0, 'false'),
(146, 3, 0, 'false'),
(147, 3, 0, 'false'),
(148, 3, 0, 'false'),
(149, 3, 0, 'false'),
(150, 3, 0, 'false'),
(151, 3, 0, 'false'),
(152, 3, 0, 'false'),
(153, 3, 0, 'false'),
(154, 3, 0, 'false'),
(155, 3, 0, 'false'),
(156, 3, 0, 'false'),
(157, 3, 0, 'false'),
(158, 3, 0, 'false'),
(159, 3, 0, 'false'),
(160, 3, 0, 'false'),
(161, 3, 0, 'false'),
(162, 3, 0, 'false'),
(163, 3, 0, 'false'),
(164, 3, 0, 'false'),
(165, 3, 0, 'false'),
(166, 3, 0, 'false'),
(167, 3, 0, 'false'),
(168, 3, 0, 'false'),
(169, 3, 0, 'true'),
(170, 3, 0, 'false'),
(171, 3, 0, 'false'),
(172, 3, 0, 'false'),
(173, 3, 0, 'false'),
(174, 3, 0, 'false'),
(175, 3, 0, 'false'),
(176, 3, 0, 'false'),
(177, 3, 0, 'false'),
(178, 3, 0, 'false'),
(179, 3, 0, 'false'),
(180, 3, 0, 'false'),
(181, 3, 0, 'false'),
(182, 3, 0, 'false'),
(183, 3, 0, 'false'),
(184, 3, 0, 'false'),
(185, 3, 0, 'false'),
(186, 3, 0, 'false'),
(187, 3, 0, 'false'),
(188, 3, 0, 'false'),
(189, 3, 0, 'false'),
(190, 3, 0, 'false'),
(191, 3, 0, 'false'),
(192, 3, 0, 'false'),
(193, 3, 0, 'false'),
(194, 3, 0, 'true'),
(195, 3, 0, 'false'),
(196, 3, 0, 'false'),
(197, 3, 0, 'false'),
(198, 3, 0, 'false'),
(199, 3, 0, 'false'),
(200, 3, 0, 'false'),
(201, 3, 0, 'false'),
(202, 3, 0, 'false'),
(203, 3, 0, 'false'),
(204, 3, 0, 'false'),
(205, 3, 0, 'false'),
(206, 3, 0, 'false'),
(207, 3, 0, 'false'),
(208, 3, 0, 'false'),
(209, 3, 0, 'false'),
(210, 3, 0, 'false'),
(211, 3, 0, 'false'),
(212, 3, 0, 'false'),
(213, 3, 0, 'false'),
(214, 3, 0, 'false'),
(215, 3, 0, 'false'),
(216, 3, 0, 'false'),
(217, 3, 0, 'false'),
(218, 3, 0, 'false'),
(219, 3, 0, 'true'),
(220, 3, 0, 'false'),
(221, 3, 0, 'false'),
(222, 3, 0, 'false'),
(223, 3, 0, 'false'),
(224, 3, 0, 'false'),
(225, 3, 0, 'false'),
(226, 3, 0, 'false'),
(227, 3, 0, 'false'),
(228, 3, 0, 'false'),
(229, 3, 0, 'false'),
(230, 3, 0, 'false'),
(231, 3, 0, 'false'),
(232, 3, 0, 'false'),
(233, 3, 0, 'false'),
(234, 3, 0, 'false'),
(235, 3, 0, 'false'),
(236, 3, 0, 'false'),
(237, 3, 0, 'false'),
(238, 3, 0, 'false'),
(239, 3, 0, 'false'),
(240, 3, 0, 'false'),
(241, 3, 0, 'false'),
(242, 3, 0, 'false'),
(243, 3, 0, 'false'),
(244, 3, 0, 'true'),
(245, 3, 0, 'false'),
(246, 3, 0, 'false'),
(247, 3, 0, 'false'),
(248, 3, 0, 'false'),
(249, 3, 0, 'false'),
(250, 3, 0, 'false'),
(251, 3, 0, 'false'),
(252, 3, 0, 'false'),
(253, 3, 0, 'false'),
(254, 3, 0, 'false'),
(255, 3, 0, 'false'),
(256, 3, 0, 'false'),
(257, 3, 0, 'false'),
(258, 3, 0, 'false'),
(259, 3, 0, 'false'),
(260, 3, 0, 'false'),
(261, 3, 0, 'false'),
(262, 3, 0, 'false'),
(263, 3, 0, 'false'),
(264, 3, 0, 'false'),
(265, 3, 0, 'false'),
(266, 3, 0, 'false'),
(267, 3, 0, 'false'),
(268, 3, 0, 'false'),
(269, 3, 0, 'true'),
(270, 3, 0, 'false'),
(271, 3, 0, 'false'),
(272, 3, 0, 'false'),
(273, 3, 0, 'false'),
(274, 3, 0, 'false'),
(275, 3, 0, 'false'),
(276, 3, 0, 'false'),
(277, 3, 0, 'false'),
(278, 3, 0, 'false'),
(279, 3, 0, 'false'),
(280, 3, 0, 'false'),
(281, 3, 0, 'false'),
(282, 3, 0, 'false'),
(283, 3, 0, 'false'),
(284, 3, 0, 'false'),
(285, 3, 0, 'false'),
(286, 3, 0, 'false'),
(287, 3, 0, 'false'),
(288, 3, 0, 'false'),
(289, 3, 0, 'false'),
(290, 3, 0, 'false'),
(291, 3, 0, 'false'),
(292, 3, 0, 'false'),
(293, 3, 0, 'false'),
(294, 3, 0, 'true'),
(295, 3, 0, 'false'),
(296, 3, 0, 'false'),
(297, 3, 0, 'false'),
(298, 3, 0, 'false'),
(299, 3, 0, 'false'),
(300, 3, 0, 'false'),
(301, 3, 0, 'false'),
(302, 3, 0, 'false'),
(303, 3, 0, 'false'),
(304, 3, 0, 'false'),
(305, 3, 0, 'false'),
(306, 3, 0, 'false'),
(307, 3, 0, 'false'),
(308, 3, 0, 'false'),
(309, 3, 0, 'false'),
(310, 3, 0, 'false'),
(311, 3, 0, 'false'),
(312, 3, 0, 'false'),
(313, 3, 0, 'false'),
(314, 3, 0, 'false'),
(315, 3, 0, 'false'),
(316, 3, 0, 'false'),
(317, 3, 0, 'false'),
(318, 3, 0, 'false'),
(319, 3, 0, 'true'),
(320, 3, 0, 'false'),
(321, 3, 0, 'false'),
(322, 3, 0, 'false'),
(323, 3, 0, 'false'),
(324, 3, 0, 'false'),
(325, 3, 0, 'false'),
(326, 3, 0, 'false'),
(327, 3, 0, 'false'),
(328, 3, 0, 'false'),
(329, 3, 0, 'false'),
(330, 3, 0, 'false'),
(331, 4, 0, 'false'),
(332, 4, 0, 'false'),
(333, 4, 0, 'false'),
(334, 4, 0, 'true'),
(335, 4, 0, 'false'),
(336, 4, 0, 'false'),
(337, 4, 0, 'false'),
(338, 4, 0, 'false'),
(339, 4, 0, 'false'),
(340, 4, 0, 'false'),
(341, 4, 0, 'false'),
(342, 4, 0, 'false'),
(343, 4, 0, 'false'),
(344, 4, 0, 'false'),
(345, 4, 0, 'false'),
(346, 4, 0, 'false'),
(347, 4, 0, 'false'),
(348, 4, 0, 'false'),
(349, 4, 0, 'false'),
(350, 4, 0, 'false'),
(351, 4, 0, 'false'),
(352, 4, 0, 'false'),
(353, 4, 0, 'false'),
(354, 4, 0, 'false'),
(355, 4, 0, 'false'),
(356, 4, 0, 'false'),
(357, 4, 0, 'false'),
(358, 4, 0, 'false'),
(359, 4, 0, 'false'),
(360, 4, 0, 'true'),
(361, 4, 0, 'false'),
(362, 4, 0, 'false'),
(363, 4, 0, 'false'),
(364, 4, 0, 'false'),
(365, 4, 0, 'false'),
(366, 4, 0, 'false'),
(367, 4, 0, 'false'),
(368, 4, 0, 'false'),
(369, 4, 0, 'false'),
(370, 4, 0, 'false'),
(371, 4, 0, 'false'),
(372, 4, 0, 'false'),
(373, 4, 0, 'false'),
(374, 4, 0, 'false'),
(375, 4, 0, 'false'),
(376, 4, 0, 'false'),
(377, 4, 0, 'false'),
(378, 4, 0, 'false'),
(379, 4, 0, 'false'),
(380, 4, 0, 'false'),
(381, 4, 0, 'false'),
(382, 4, 0, 'false'),
(383, 4, 0, 'false'),
(384, 4, 0, 'false'),
(385, 4, 0, 'true'),
(386, 4, 0, 'false'),
(387, 4, 0, 'false'),
(388, 4, 0, 'false'),
(389, 4, 0, 'false'),
(390, 4, 0, 'false'),
(391, 4, 0, 'false'),
(392, 4, 0, 'false'),
(393, 4, 0, 'false'),
(394, 4, 0, 'false'),
(395, 4, 0, 'false'),
(396, 4, 0, 'false'),
(397, 4, 0, 'false'),
(398, 4, 0, 'false'),
(399, 4, 0, 'false'),
(400, 4, 0, 'false'),
(401, 4, 0, 'false'),
(402, 4, 0, 'false'),
(403, 4, 0, 'false'),
(404, 4, 0, 'false'),
(405, 4, 0, 'false'),
(406, 4, 0, 'false'),
(407, 4, 0, 'false'),
(408, 4, 0, 'false'),
(409, 4, 0, 'false'),
(410, 4, 0, 'true'),
(411, 4, 0, 'false'),
(412, 4, 0, 'false'),
(413, 4, 0, 'false'),
(414, 4, 0, 'false'),
(415, 4, 0, 'false'),
(416, 4, 0, 'false'),
(417, 4, 0, 'false'),
(418, 4, 0, 'false'),
(419, 4, 0, 'false'),
(420, 4, 0, 'false'),
(421, 4, 0, 'false'),
(422, 4, 0, 'false'),
(423, 4, 0, 'false'),
(424, 4, 0, 'false'),
(425, 4, 0, 'false'),
(426, 4, 0, 'false'),
(427, 4, 0, 'false'),
(428, 4, 0, 'false'),
(429, 4, 0, 'false'),
(430, 4, 0, 'false'),
(431, 4, 0, 'false'),
(432, 4, 0, 'false'),
(433, 4, 0, 'false'),
(434, 4, 0, 'false'),
(435, 4, 0, 'true'),
(436, 4, 0, 'false'),
(437, 4, 0, 'false'),
(438, 4, 0, 'false'),
(439, 4, 0, 'false'),
(440, 4, 0, 'false'),
(441, 4, 0, 'false'),
(442, 4, 0, 'false'),
(443, 4, 0, 'false'),
(444, 4, 0, 'false'),
(445, 4, 0, 'false'),
(446, 4, 0, 'false'),
(447, 4, 0, 'false'),
(448, 4, 0, 'false'),
(449, 4, 0, 'false'),
(450, 4, 0, 'false'),
(451, 4, 0, 'false'),
(452, 4, 0, 'false'),
(453, 4, 0, 'false'),
(454, 4, 0, 'false'),
(455, 4, 0, 'false'),
(456, 4, 0, 'false'),
(457, 4, 0, 'false'),
(458, 4, 0, 'false'),
(459, 4, 0, 'false'),
(460, 4, 0, 'true'),
(461, 4, 0, 'false'),
(462, 4, 0, 'false'),
(463, 4, 0, 'false'),
(464, 4, 0, 'false'),
(465, 4, 0, 'false'),
(466, 4, 0, 'false'),
(467, 4, 0, 'false'),
(468, 4, 0, 'false'),
(469, 4, 0, 'false'),
(470, 4, 0, 'false'),
(471, 4, 0, 'false'),
(472, 4, 0, 'false'),
(473, 4, 0, 'false'),
(474, 4, 0, 'false'),
(475, 4, 0, 'false'),
(476, 4, 0, 'false'),
(477, 4, 0, 'false'),
(478, 4, 0, 'false'),
(479, 4, 0, 'false'),
(480, 4, 0, 'false'),
(481, 4, 0, 'false'),
(482, 4, 0, 'false'),
(483, 4, 0, 'false'),
(484, 4, 0, 'false'),
(485, 4, 0, 'true'),
(486, 4, 0, 'false'),
(487, 4, 0, 'false'),
(488, 4, 0, 'false'),
(489, 4, 0, 'false'),
(490, 4, 0, 'false'),
(491, 4, 0, 'false'),
(492, 4, 0, 'false'),
(493, 4, 0, 'false'),
(494, 4, 0, 'false'),
(495, 4, 0, 'false'),
(496, 4, 0, 'false'),
(497, 4, 0, 'false'),
(498, 4, 0, 'false'),
(499, 4, 0, 'false'),
(500, 4, 0, 'false'),
(501, 4, 0, 'false'),
(502, 4, 0, 'false'),
(503, 4, 0, 'false'),
(504, 4, 0, 'false'),
(505, 4, 0, 'false'),
(506, 4, 0, 'false'),
(507, 4, 0, 'false'),
(508, 4, 0, 'false'),
(509, 4, 0, 'false'),
(510, 4, 0, 'true'),
(511, 4, 0, 'false'),
(512, 4, 0, 'false'),
(513, 4, 0, 'false'),
(514, 4, 0, 'false'),
(515, 4, 0, 'false'),
(516, 4, 0, 'false'),
(517, 4, 0, 'false'),
(518, 4, 0, 'false'),
(519, 4, 0, 'false'),
(520, 4, 0, 'false'),
(521, 4, 0, 'false'),
(522, 4, 0, 'false'),
(523, 4, 0, 'false'),
(524, 4, 0, 'false'),
(525, 4, 0, 'false'),
(526, 4, 0, 'false'),
(527, 4, 0, 'false'),
(528, 4, 0, 'false'),
(529, 4, 0, 'false'),
(530, 4, 0, 'false'),
(531, 4, 0, 'false'),
(532, 4, 0, 'false'),
(533, 4, 0, 'false'),
(534, 4, 0, 'false'),
(535, 4, 0, 'true'),
(536, 4, 0, 'false'),
(537, 4, 0, 'false'),
(538, 4, 0, 'false'),
(539, 4, 0, 'false'),
(540, 4, 0, 'false'),
(541, 4, 0, 'false'),
(542, 4, 0, 'false'),
(543, 4, 0, 'false'),
(544, 4, 0, 'false'),
(545, 4, 0, 'false'),
(546, 4, 0, 'false'),
(547, 5, 0, 'false'),
(548, 5, 0, 'false'),
(549, 5, 0, 'false'),
(550, 5, 0, 'false'),
(551, 5, 0, 'false'),
(552, 5, 0, 'false'),
(553, 5, 0, 'false'),
(554, 5, 0, 'false'),
(555, 5, 0, 'false'),
(556, 5, 0, 'false'),
(557, 5, 0, 'true'),
(558, 5, 0, 'false'),
(559, 5, 0, 'false'),
(560, 5, 0, 'false'),
(561, 5, 0, 'false'),
(562, 5, 0, 'false'),
(563, 5, 0, 'false'),
(564, 5, 0, 'false'),
(565, 5, 0, 'false'),
(566, 5, 0, 'false'),
(567, 5, 0, 'false'),
(568, 5, 0, 'false'),
(569, 5, 0, 'false'),
(570, 5, 0, 'false'),
(571, 5, 0, 'false'),
(572, 5, 0, 'false'),
(573, 5, 0, 'false'),
(574, 5, 0, 'false'),
(575, 5, 0, 'false'),
(576, 5, 0, 'false'),
(577, 5, 0, 'false'),
(578, 5, 0, 'false'),
(579, 5, 0, 'false'),
(580, 5, 0, 'true'),
(581, 5, 0, 'false'),
(582, 5, 0, 'false'),
(583, 5, 0, 'false'),
(584, 5, 0, 'false'),
(585, 5, 0, 'false'),
(586, 5, 0, 'false'),
(587, 5, 0, 'false'),
(588, 5, 0, 'false'),
(589, 5, 0, 'false'),
(590, 5, 0, 'false'),
(591, 5, 0, 'false'),
(592, 5, 0, 'false'),
(593, 5, 0, 'false'),
(594, 5, 0, 'false'),
(595, 5, 0, 'false'),
(596, 5, 0, 'false'),
(597, 5, 0, 'false'),
(598, 5, 0, 'false'),
(599, 5, 0, 'false'),
(600, 5, 0, 'false'),
(601, 5, 0, 'false'),
(602, 5, 0, 'true'),
(603, 5, 0, 'false'),
(604, 5, 0, 'false'),
(605, 5, 0, 'false'),
(606, 5, 0, 'false'),
(607, 5, 0, 'false'),
(608, 5, 0, 'false'),
(609, 5, 0, 'false'),
(610, 5, 0, 'false'),
(611, 5, 0, 'false'),
(612, 5, 0, 'false'),
(613, 5, 0, 'false'),
(614, 5, 0, 'false'),
(615, 5, 0, 'false'),
(616, 5, 0, 'false'),
(617, 5, 0, 'false'),
(618, 5, 0, 'false'),
(619, 5, 0, 'false'),
(620, 5, 0, 'false'),
(621, 5, 0, 'false'),
(622, 5, 0, 'false'),
(623, 5, 0, 'false'),
(624, 5, 0, 'true'),
(625, 5, 0, 'false'),
(626, 5, 0, 'false'),
(627, 5, 0, 'false'),
(628, 5, 0, 'false'),
(629, 5, 0, 'false'),
(630, 5, 0, 'false'),
(631, 5, 0, 'false'),
(632, 5, 0, 'false'),
(633, 5, 0, 'false'),
(634, 5, 0, 'false'),
(635, 5, 0, 'false'),
(636, 5, 0, 'false'),
(637, 5, 0, 'false'),
(638, 5, 0, 'false'),
(639, 5, 0, 'false'),
(640, 5, 0, 'false'),
(641, 5, 0, 'false'),
(642, 5, 0, 'false'),
(643, 5, 0, 'false'),
(644, 5, 0, 'false'),
(645, 5, 0, 'false'),
(646, 5, 0, 'false'),
(647, 5, 0, 'false'),
(648, 5, 0, 'false'),
(649, 5, 0, 'true'),
(650, 5, 0, 'false'),
(651, 5, 0, 'false'),
(652, 5, 0, 'false'),
(653, 5, 0, 'false'),
(654, 5, 0, 'false'),
(655, 5, 0, 'false'),
(656, 5, 0, 'false'),
(657, 5, 0, 'false'),
(658, 5, 0, 'false'),
(659, 5, 0, 'false'),
(660, 5, 0, 'false'),
(661, 5, 0, 'false'),
(662, 5, 0, 'false'),
(663, 5, 0, 'false'),
(664, 5, 0, 'false'),
(665, 5, 0, 'false'),
(666, 5, 0, 'false'),
(667, 5, 0, 'false'),
(668, 5, 0, 'false'),
(669, 5, 0, 'false'),
(670, 5, 0, 'true'),
(671, 5, 0, 'false'),
(672, 5, 0, 'false'),
(673, 5, 0, 'false'),
(674, 5, 0, 'false'),
(675, 5, 0, 'false'),
(676, 5, 0, 'false'),
(677, 5, 0, 'false'),
(678, 5, 0, 'false'),
(679, 5, 0, 'false'),
(680, 5, 0, 'false'),
(681, 5, 0, 'false'),
(682, 5, 0, 'false'),
(683, 5, 0, 'false'),
(684, 5, 0, 'false'),
(685, 5, 0, 'false'),
(686, 5, 0, 'false'),
(687, 5, 0, 'false'),
(688, 5, 0, 'false'),
(689, 5, 0, 'false'),
(690, 5, 0, 'false'),
(691, 6, 0, 'false'),
(692, 6, 0, 'false'),
(693, 6, 0, 'false'),
(694, 6, 0, 'false'),
(695, 6, 0, 'false'),
(696, 6, 0, 'false'),
(697, 6, 0, 'false'),
(698, 6, 0, 'false'),
(699, 6, 0, 'false'),
(700, 6, 0, 'false'),
(701, 6, 0, 'true'),
(702, 6, 0, 'false'),
(703, 6, 0, 'false'),
(704, 6, 0, 'false'),
(705, 6, 0, 'false'),
(706, 6, 0, 'false'),
(707, 6, 0, 'false'),
(708, 6, 0, 'false'),
(709, 6, 0, 'false'),
(710, 6, 0, 'false'),
(711, 6, 0, 'false'),
(712, 6, 0, 'false'),
(713, 6, 0, 'false'),
(714, 6, 0, 'false'),
(715, 6, 0, 'false'),
(716, 6, 0, 'false'),
(717, 6, 0, 'false'),
(718, 6, 0, 'false'),
(719, 6, 0, 'false'),
(720, 6, 0, 'false'),
(721, 6, 0, 'false'),
(722, 6, 0, 'false'),
(723, 6, 0, 'false'),
(724, 6, 0, 'false'),
(725, 6, 0, 'false'),
(726, 6, 0, 'true'),
(727, 6, 0, 'false'),
(728, 6, 0, 'false'),
(729, 6, 0, 'false'),
(730, 6, 0, 'false'),
(731, 6, 0, 'false'),
(732, 6, 0, 'false'),
(733, 6, 0, 'false'),
(734, 6, 0, 'false'),
(735, 6, 0, 'false'),
(736, 6, 0, 'false'),
(737, 6, 0, 'false'),
(738, 6, 0, 'false'),
(739, 6, 0, 'false'),
(740, 6, 0, 'false'),
(741, 6, 0, 'false'),
(742, 6, 0, 'false'),
(743, 6, 0, 'false'),
(744, 6, 0, 'true'),
(745, 6, 0, 'false'),
(746, 6, 0, 'false'),
(747, 6, 0, 'false'),
(748, 6, 0, 'false'),
(749, 6, 0, 'false'),
(750, 6, 0, 'false'),
(751, 6, 0, 'false'),
(752, 6, 0, 'false'),
(753, 6, 0, 'false'),
(754, 6, 0, 'false'),
(755, 6, 0, 'false'),
(756, 6, 0, 'false'),
(757, 6, 0, 'false'),
(758, 6, 0, 'false'),
(759, 6, 0, 'false'),
(760, 6, 0, 'false'),
(761, 6, 0, 'false'),
(762, 6, 0, 'false'),
(763, 6, 0, 'false'),
(764, 6, 0, 'false'),
(765, 6, 0, 'false'),
(766, 6, 0, 'false'),
(767, 6, 0, 'false'),
(768, 6, 0, 'false'),
(769, 6, 0, 'false'),
(770, 6, 0, 'false'),
(771, 6, 0, 'true'),
(772, 6, 0, 'false'),
(773, 6, 0, 'false'),
(774, 6, 0, 'false'),
(775, 6, 0, 'false'),
(776, 6, 0, 'false'),
(777, 6, 0, 'false'),
(778, 6, 0, 'false'),
(779, 6, 0, 'false'),
(780, 6, 0, 'false'),
(781, 6, 0, 'false'),
(782, 6, 0, 'false'),
(783, 6, 0, 'false'),
(784, 6, 0, 'false'),
(785, 6, 0, 'false'),
(786, 6, 0, 'false'),
(787, 6, 0, 'false'),
(788, 6, 0, 'false'),
(789, 6, 0, 'false'),
(790, 6, 0, 'false'),
(791, 6, 0, 'false'),
(792, 6, 0, 'false'),
(793, 6, 0, 'false'),
(794, 6, 0, 'false'),
(795, 6, 0, 'false'),
(796, 6, 0, 'true'),
(797, 6, 0, 'false'),
(798, 6, 0, 'false'),
(799, 6, 0, 'false'),
(800, 6, 0, 'false'),
(801, 6, 0, 'false'),
(802, 6, 0, 'false'),
(803, 6, 0, 'false'),
(804, 6, 0, 'false'),
(805, 6, 0, 'false'),
(806, 6, 0, 'false'),
(807, 6, 0, 'false'),
(808, 6, 0, 'false'),
(809, 6, 0, 'false'),
(810, 6, 0, 'false'),
(811, 6, 0, 'false'),
(812, 6, 0, 'false'),
(813, 6, 0, 'false'),
(814, 6, 0, 'false'),
(815, 6, 0, 'false'),
(816, 6, 0, 'false'),
(817, 6, 0, 'true'),
(818, 6, 0, 'false'),
(819, 6, 0, 'false'),
(820, 6, 0, 'false'),
(821, 6, 0, 'false'),
(822, 6, 0, 'false'),
(823, 6, 0, 'false'),
(824, 6, 0, 'false'),
(825, 6, 0, 'false'),
(826, 6, 0, 'false'),
(827, 6, 0, 'false'),
(828, 6, 0, 'false'),
(829, 6, 0, 'false'),
(830, 6, 0, 'false'),
(831, 6, 0, 'false'),
(832, 6, 0, 'false'),
(833, 6, 0, 'false'),
(834, 6, 0, 'false'),
(835, 6, 0, 'false'),
(836, 6, 0, 'false'),
(837, 6, 0, 'false'),
(838, 6, 0, 'true'),
(839, 6, 0, 'false'),
(840, 6, 0, 'false'),
(841, 6, 0, 'false'),
(842, 6, 0, 'false'),
(843, 6, 0, 'false'),
(844, 6, 0, 'false'),
(845, 6, 0, 'false'),
(846, 6, 0, 'false'),
(847, 6, 0, 'false'),
(848, 6, 0, 'false'),
(849, 6, 0, 'false'),
(850, 6, 0, 'false'),
(851, 6, 0, 'false'),
(852, 6, 0, 'false'),
(853, 6, 0, 'false'),
(854, 6, 0, 'false'),
(855, 6, 0, 'false'),
(856, 6, 0, 'false'),
(857, 6, 0, 'false'),
(858, 6, 0, 'false'),
(859, 6, 0, 'false'),
(860, 6, 0, 'false'),
(861, 6, 0, 'false'),
(862, 6, 0, 'false'),
(863, 6, 0, 'false'),
(864, 6, 0, 'false'),
(865, 6, 0, 'false'),
(866, 6, 0, 'false'),
(867, 6, 0, 'false'),
(868, 6, 0, 'false'),
(869, 6, 0, 'false'),
(870, 6, 0, 'false'),
(871, 6, 0, 'true'),
(872, 6, 0, 'false'),
(873, 6, 0, 'false'),
(874, 6, 0, 'false'),
(875, 6, 0, 'false'),
(876, 6, 0, 'false'),
(877, 6, 0, 'false'),
(878, 6, 0, 'false'),
(879, 6, 0, 'false'),
(880, 6, 0, 'false'),
(881, 6, 0, 'false'),
(882, 6, 0, 'false'),
(883, 7, 0, 'false'),
(884, 7, 0, 'false'),
(885, 7, 0, 'false'),
(886, 7, 0, 'false'),
(887, 7, 0, 'false'),
(888, 7, 0, 'false'),
(889, 7, 0, 'false'),
(890, 7, 0, 'false'),
(891, 7, 0, 'false'),
(892, 7, 0, 'true'),
(893, 7, 0, 'false'),
(894, 7, 0, 'false'),
(895, 7, 0, 'false'),
(896, 7, 0, 'false'),
(897, 7, 0, 'false'),
(898, 7, 0, 'false'),
(899, 7, 0, 'false'),
(900, 7, 0, 'false'),
(901, 7, 0, 'false'),
(902, 7, 0, 'false'),
(903, 7, 0, 'false'),
(904, 7, 0, 'false'),
(905, 7, 0, 'false'),
(906, 7, 0, 'false'),
(907, 7, 0, 'false'),
(908, 7, 0, 'false'),
(909, 7, 0, 'false'),
(910, 7, 0, 'false'),
(911, 7, 0, 'false'),
(912, 7, 0, 'false'),
(913, 7, 0, 'false'),
(914, 7, 0, 'false'),
(915, 7, 0, 'false'),
(916, 7, 0, 'false'),
(917, 7, 0, 'true'),
(918, 7, 0, 'false'),
(919, 7, 0, 'false'),
(920, 7, 0, 'false'),
(921, 7, 0, 'false'),
(922, 7, 0, 'false'),
(923, 7, 0, 'false'),
(924, 7, 0, 'false'),
(925, 7, 0, 'false'),
(926, 7, 0, 'false'),
(927, 7, 0, 'false'),
(928, 7, 0, 'false'),
(929, 7, 0, 'false'),
(930, 7, 0, 'false'),
(931, 7, 0, 'false'),
(932, 7, 0, 'false'),
(933, 7, 0, 'false'),
(934, 7, 0, 'false'),
(935, 7, 0, 'false'),
(936, 7, 0, 'false'),
(937, 7, 0, 'false'),
(938, 7, 0, 'false'),
(939, 7, 0, 'true'),
(940, 7, 0, 'false'),
(941, 7, 0, 'false'),
(942, 7, 0, 'false'),
(943, 7, 0, 'false'),
(944, 7, 0, 'false'),
(945, 7, 0, 'false'),
(946, 7, 0, 'false'),
(947, 7, 0, 'false'),
(948, 7, 0, 'false'),
(949, 7, 0, 'false'),
(950, 7, 0, 'false'),
(951, 7, 0, 'false'),
(952, 7, 0, 'false'),
(953, 7, 0, 'false'),
(954, 7, 0, 'false'),
(955, 7, 0, 'false'),
(956, 7, 0, 'false'),
(957, 7, 0, 'false'),
(958, 7, 0, 'false'),
(959, 7, 0, 'false'),
(960, 7, 0, 'false'),
(961, 7, 0, 'false'),
(962, 7, 0, 'true'),
(963, 7, 0, 'false'),
(964, 7, 0, 'false'),
(965, 7, 0, 'false'),
(966, 7, 0, 'false'),
(967, 7, 0, 'false'),
(968, 7, 0, 'false'),
(969, 7, 0, 'false'),
(970, 7, 0, 'false'),
(971, 7, 0, 'false'),
(972, 7, 0, 'false'),
(973, 7, 0, 'false'),
(974, 7, 0, 'false'),
(975, 7, 0, 'false'),
(976, 7, 0, 'false'),
(977, 7, 0, 'false'),
(978, 7, 0, 'false'),
(979, 7, 0, 'false'),
(980, 7, 0, 'false'),
(981, 7, 0, 'false'),
(982, 7, 0, 'false'),
(983, 7, 0, 'false'),
(984, 7, 0, 'false'),
(985, 7, 0, 'true'),
(986, 7, 0, 'false'),
(987, 7, 0, 'false'),
(988, 7, 0, 'false'),
(989, 7, 0, 'false'),
(990, 7, 0, 'false'),
(991, 7, 0, 'false'),
(992, 7, 0, 'false'),
(993, 7, 0, 'false'),
(994, 7, 0, 'false'),
(995, 7, 0, 'false'),
(996, 7, 0, 'false'),
(997, 7, 0, 'false'),
(998, 7, 0, 'false'),
(999, 7, 0, 'false'),
(1000, 7, 0, 'false'),
(1001, 7, 0, 'false'),
(1002, 7, 0, 'false'),
(1003, 7, 0, 'false'),
(1004, 7, 0, 'false'),
(1005, 7, 0, 'false'),
(1006, 7, 0, 'true'),
(1007, 7, 0, 'false'),
(1008, 7, 0, 'false'),
(1009, 7, 0, 'false'),
(1010, 7, 0, 'false'),
(1011, 7, 0, 'false'),
(1012, 7, 0, 'false'),
(1013, 7, 0, 'false'),
(1014, 7, 0, 'false'),
(1015, 7, 0, 'false'),
(1016, 7, 0, 'false'),
(1017, 7, 0, 'false'),
(1018, 7, 0, 'false'),
(1019, 7, 0, 'false'),
(1020, 7, 0, 'false'),
(1021, 7, 0, 'false'),
(1022, 7, 0, 'false'),
(1023, 7, 0, 'false'),
(1024, 7, 0, 'false'),
(1025, 7, 0, 'false'),
(1026, 7, 0, 'false'),
(1027, 7, 0, 'false'),
(1028, 7, 0, 'false'),
(1029, 7, 0, 'false'),
(1030, 7, 0, 'false'),
(1031, 7, 0, 'false'),
(1032, 7, 0, 'false'),
(1033, 7, 0, 'false'),
(1034, 7, 0, 'false'),
(1035, 7, 0, 'false'),
(1036, 7, 0, 'false'),
(1037, 7, 0, 'false'),
(1038, 7, 0, 'false'),
(1039, 7, 0, 'true'),
(1040, 7, 0, 'false'),
(1041, 7, 0, 'false'),
(1042, 7, 0, 'false'),
(1043, 7, 0, 'false'),
(1044, 7, 0, 'false'),
(1045, 7, 0, 'false'),
(1046, 7, 0, 'false'),
(1047, 7, 0, 'false'),
(1048, 7, 0, 'false'),
(1049, 7, 0, 'false'),
(1050, 7, 0, 'false'),
(1051, 7, 0, 'false'),
(1052, 7, 0, 'false'),
(1053, 7, 0, 'false'),
(1054, 7, 0, 'false'),
(1055, 7, 0, 'false'),
(1056, 7, 0, 'true'),
(1057, 7, 0, 'false'),
(1058, 7, 0, 'false'),
(1059, 7, 0, 'false'),
(1060, 7, 0, 'false'),
(1061, 7, 0, 'false'),
(1062, 7, 0, 'false'),
(1063, 7, 0, 'false'),
(1064, 7, 0, 'false'),
(1065, 7, 0, 'false'),
(1066, 7, 0, 'false'),
(1067, 7, 0, 'false'),
(1068, 7, 0, 'false'),
(1069, 7, 0, 'false'),
(1070, 7, 0, 'false'),
(1071, 7, 0, 'false'),
(1072, 7, 0, 'false'),
(1073, 7, 0, 'false'),
(1074, 7, 0, 'false'),
(1075, 7, 0, 'false'),
(1076, 7, 0, 'false'),
(1077, 7, 0, 'false'),
(1078, 7, 0, 'false'),
(1079, 7, 0, 'false'),
(1080, 7, 0, 'false'),
(1081, 7, 0, 'false'),
(1082, 7, 0, 'false'),
(1083, 7, 0, 'false'),
(1084, 7, 0, 'false'),
(1085, 7, 0, 'false'),
(1086, 7, 0, 'true'),
(1087, 7, 0, 'false'),
(1088, 7, 0, 'false'),
(1089, 7, 0, 'false'),
(1090, 7, 0, 'false'),
(1091, 7, 0, 'false'),
(1092, 7, 0, 'false'),
(1093, 7, 0, 'false'),
(1094, 7, 0, 'false'),
(1095, 7, 0, 'false'),
(1096, 7, 0, 'false'),
(1097, 7, 0, 'false'),
(1098, 7, 0, 'false'),
(1099, 8, 0, 'false'),
(1100, 8, 0, 'false'),
(1101, 8, 0, 'false'),
(1102, 8, 0, 'false'),
(1103, 8, 0, 'false'),
(1104, 8, 0, 'false'),
(1105, 8, 0, 'false'),
(1106, 8, 0, 'false'),
(1107, 8, 0, 'false'),
(1108, 8, 0, 'false'),
(1109, 8, 0, 'false'),
(1110, 8, 0, 'false'),
(1111, 8, 0, 'true'),
(1112, 8, 0, 'false'),
(1113, 8, 0, 'false'),
(1114, 8, 0, 'false'),
(1115, 8, 0, 'false'),
(1116, 8, 0, 'false'),
(1117, 8, 0, 'false'),
(1118, 8, 0, 'false'),
(1119, 8, 0, 'false'),
(1120, 8, 0, 'false'),
(1121, 8, 0, 'false'),
(1122, 8, 0, 'false'),
(1123, 8, 0, 'false'),
(1124, 8, 0, 'false'),
(1125, 8, 0, 'false'),
(1126, 8, 0, 'true'),
(1127, 8, 0, 'false'),
(1128, 8, 0, 'false'),
(1129, 8, 0, 'false'),
(1130, 8, 0, 'false'),
(1131, 8, 0, 'false'),
(1132, 8, 0, 'false'),
(1133, 8, 0, 'false'),
(1134, 8, 0, 'false'),
(1135, 8, 0, 'false'),
(1136, 8, 0, 'false'),
(1137, 8, 0, 'false'),
(1138, 8, 0, 'false'),
(1139, 8, 0, 'false'),
(1140, 8, 0, 'false'),
(1141, 8, 0, 'false'),
(1142, 8, 0, 'false'),
(1143, 8, 0, 'false'),
(1144, 8, 0, 'false'),
(1145, 8, 0, 'false'),
(1146, 8, 0, 'false'),
(1147, 8, 0, 'false'),
(1148, 8, 0, 'false'),
(1149, 8, 0, 'false'),
(1150, 8, 0, 'false'),
(1151, 8, 0, 'false'),
(1152, 8, 0, 'false'),
(1153, 8, 0, 'false'),
(1154, 8, 0, 'false'),
(1155, 8, 0, 'false'),
(1156, 8, 0, 'false'),
(1157, 8, 0, 'false'),
(1158, 8, 0, 'true'),
(1159, 8, 0, 'false'),
(1160, 8, 0, 'false'),
(1161, 8, 0, 'false'),
(1162, 8, 0, 'false'),
(1163, 8, 0, 'false'),
(1164, 8, 0, 'false'),
(1165, 8, 0, 'false'),
(1166, 8, 0, 'false'),
(1167, 8, 0, 'false'),
(1168, 8, 0, 'false'),
(1169, 8, 0, 'false'),
(1170, 8, 0, 'false'),
(1171, 8, 0, 'false'),
(1172, 8, 0, 'false'),
(1173, 8, 0, 'false'),
(1174, 8, 0, 'false'),
(1175, 8, 0, 'false'),
(1176, 8, 0, 'true'),
(1177, 8, 0, 'false'),
(1178, 8, 0, 'false'),
(1179, 8, 0, 'false'),
(1180, 8, 0, 'false'),
(1181, 8, 0, 'false'),
(1182, 8, 0, 'false'),
(1183, 8, 0, 'false'),
(1184, 8, 0, 'false'),
(1185, 8, 0, 'false'),
(1186, 8, 0, 'false'),
(1187, 8, 0, 'false'),
(1188, 8, 0, 'false'),
(1189, 8, 0, 'false'),
(1190, 8, 0, 'false'),
(1191, 8, 0, 'false'),
(1192, 8, 0, 'false'),
(1193, 8, 0, 'false'),
(1194, 8, 0, 'false'),
(1195, 8, 0, 'false'),
(1196, 8, 0, 'false'),
(1197, 8, 0, 'false'),
(1198, 8, 0, 'false'),
(1199, 8, 0, 'false'),
(1200, 8, 0, 'false'),
(1201, 8, 0, 'false'),
(1202, 8, 0, 'false'),
(1203, 8, 0, 'true'),
(1204, 8, 0, 'false'),
(1205, 8, 0, 'false'),
(1206, 8, 0, 'false'),
(1207, 8, 0, 'false'),
(1208, 8, 0, 'false'),
(1209, 8, 0, 'false'),
(1210, 8, 0, 'false'),
(1211, 8, 0, 'false'),
(1212, 8, 0, 'false'),
(1213, 8, 0, 'false'),
(1214, 8, 0, 'false'),
(1215, 8, 0, 'false'),
(1216, 8, 0, 'false'),
(1217, 8, 0, 'false'),
(1218, 8, 0, 'false'),
(1219, 8, 0, 'false'),
(1220, 8, 0, 'false'),
(1221, 8, 0, 'false'),
(1222, 8, 0, 'false'),
(1223, 8, 0, 'false'),
(1224, 8, 0, 'false'),
(1225, 8, 0, 'true'),
(1226, 8, 0, 'false'),
(1227, 8, 0, 'false'),
(1228, 8, 0, 'false'),
(1229, 8, 0, 'false'),
(1230, 8, 0, 'false'),
(1231, 8, 0, 'false'),
(1232, 8, 0, 'false'),
(1233, 8, 0, 'false'),
(1234, 8, 0, 'false'),
(1235, 8, 0, 'false'),
(1236, 8, 0, 'false'),
(1237, 8, 0, 'false'),
(1238, 8, 0, 'false'),
(1239, 8, 0, 'false'),
(1240, 8, 0, 'false'),
(1241, 8, 0, 'false'),
(1242, 8, 0, 'false'),
(1243, 8, 0, 'false'),
(1244, 8, 0, 'false'),
(1245, 8, 0, 'false'),
(1246, 8, 0, 'false'),
(1247, 8, 0, 'false'),
(1248, 8, 0, 'false'),
(1249, 8, 0, 'false'),
(1250, 8, 0, 'false'),
(1251, 8, 0, 'false'),
(1252, 8, 0, 'false'),
(1253, 8, 0, 'true'),
(1254, 8, 0, 'false'),
(1255, 8, 0, 'false'),
(1256, 8, 0, 'false'),
(1257, 8, 0, 'false'),
(1258, 8, 0, 'false'),
(1259, 8, 0, 'false'),
(1260, 8, 0, 'false'),
(1261, 8, 0, 'false'),
(1262, 8, 0, 'false'),
(1263, 8, 0, 'false'),
(1264, 8, 0, 'false'),
(1265, 8, 0, 'false'),
(1266, 8, 0, 'false'),
(1267, 8, 0, 'false'),
(1268, 8, 0, 'false'),
(1269, 8, 0, 'false'),
(1270, 8, 0, 'false'),
(1271, 8, 0, 'false'),
(1272, 8, 0, 'false'),
(1273, 8, 0, 'false'),
(1274, 8, 0, 'false'),
(1275, 8, 0, 'false'),
(1276, 8, 0, 'true'),
(1277, 8, 0, 'false'),
(1278, 8, 0, 'false'),
(1279, 8, 0, 'false'),
(1280, 8, 0, 'false'),
(1281, 8, 0, 'false'),
(1282, 8, 0, 'false'),
(1283, 8, 0, 'false'),
(1284, 8, 0, 'false'),
(1285, 8, 0, 'false'),
(1286, 8, 0, 'false'),
(1287, 8, 0, 'false'),
(1288, 8, 0, 'false'),
(1289, 8, 0, 'false'),
(1290, 8, 0, 'false'),
(1291, 9, 0, 'false'),
(1292, 9, 0, 'false'),
(1293, 9, 0, 'false'),
(1294, 9, 0, 'false'),
(1295, 9, 0, 'false'),
(1296, 9, 0, 'false'),
(1297, 9, 0, 'false'),
(1298, 9, 0, 'false'),
(1299, 9, 0, 'false'),
(1300, 9, 0, 'true'),
(1301, 9, 0, 'false'),
(1302, 9, 0, 'false'),
(1303, 9, 0, 'false'),
(1304, 9, 0, 'false'),
(1305, 9, 0, 'false'),
(1306, 9, 0, 'false'),
(1307, 9, 0, 'false'),
(1308, 9, 0, 'false'),
(1309, 9, 0, 'false'),
(1310, 9, 0, 'false'),
(1311, 9, 0, 'false'),
(1312, 9, 0, 'false'),
(1313, 9, 0, 'false'),
(1314, 9, 0, 'false'),
(1315, 9, 0, 'false'),
(1316, 9, 0, 'false'),
(1317, 9, 0, 'false'),
(1318, 9, 0, 'false'),
(1319, 9, 0, 'false'),
(1320, 9, 0, 'false'),
(1321, 9, 0, 'false'),
(1322, 9, 0, 'false'),
(1323, 9, 0, 'true'),
(1324, 9, 0, 'false'),
(1325, 9, 0, 'false'),
(1326, 9, 0, 'false'),
(1327, 9, 0, 'false'),
(1328, 9, 0, 'false'),
(1329, 9, 0, 'false'),
(1330, 9, 0, 'false'),
(1331, 9, 0, 'false'),
(1332, 9, 0, 'false'),
(1333, 9, 0, 'false'),
(1334, 9, 0, 'false'),
(1335, 9, 0, 'false'),
(1336, 9, 0, 'false'),
(1337, 9, 0, 'false'),
(1338, 9, 0, 'false'),
(1339, 9, 0, 'false'),
(1340, 9, 0, 'false'),
(1341, 9, 0, 'false'),
(1342, 9, 0, 'false'),
(1343, 9, 0, 'false'),
(1344, 9, 0, 'false'),
(1345, 9, 0, 'false'),
(1346, 9, 0, 'true'),
(1347, 9, 0, 'false'),
(1348, 9, 0, 'false'),
(1349, 9, 0, 'false'),
(1350, 9, 0, 'false'),
(1351, 9, 0, 'false'),
(1352, 9, 0, 'false'),
(1353, 9, 0, 'false'),
(1354, 9, 0, 'false'),
(1355, 9, 0, 'false'),
(1356, 9, 0, 'false'),
(1357, 9, 0, 'false'),
(1358, 9, 0, 'false'),
(1359, 9, 0, 'false'),
(1360, 9, 0, 'false'),
(1361, 9, 0, 'false'),
(1362, 9, 0, 'false'),
(1363, 9, 0, 'false'),
(1364, 9, 0, 'false'),
(1365, 9, 0, 'false'),
(1366, 9, 0, 'false'),
(1367, 9, 0, 'false'),
(1368, 9, 0, 'false'),
(1369, 9, 0, 'true'),
(1370, 9, 0, 'false'),
(1371, 9, 0, 'false'),
(1372, 9, 0, 'false'),
(1373, 9, 0, 'false'),
(1374, 9, 0, 'false'),
(1375, 9, 0, 'false'),
(1376, 9, 0, 'false'),
(1377, 9, 0, 'false'),
(1378, 9, 0, 'false'),
(1379, 9, 0, 'false'),
(1380, 9, 0, 'false'),
(1381, 9, 0, 'false'),
(1382, 9, 0, 'false'),
(1383, 9, 0, 'false'),
(1384, 9, 0, 'false'),
(1385, 9, 0, 'false'),
(1386, 9, 0, 'false'),
(1387, 9, 0, 'false'),
(1388, 9, 0, 'false'),
(1389, 9, 0, 'false'),
(1390, 9, 0, 'true'),
(1391, 9, 0, 'false'),
(1392, 9, 0, 'false'),
(1393, 9, 0, 'false'),
(1394, 9, 0, 'false'),
(1395, 9, 0, 'false'),
(1396, 9, 0, 'false'),
(1397, 9, 0, 'false'),
(1398, 9, 0, 'false'),
(1399, 9, 0, 'false'),
(1400, 9, 0, 'false'),
(1401, 9, 0, 'false'),
(1402, 9, 0, 'false'),
(1403, 9, 0, 'false'),
(1404, 9, 0, 'false'),
(1405, 9, 0, 'false'),
(1406, 9, 0, 'false'),
(1407, 9, 0, 'false'),
(1408, 9, 0, 'false'),
(1409, 9, 0, 'false'),
(1410, 9, 0, 'false'),
(1411, 9, 0, 'false'),
(1412, 9, 0, 'false'),
(1413, 9, 0, 'false'),
(1414, 9, 0, 'false'),
(1415, 9, 0, 'false'),
(1416, 9, 0, 'true'),
(1417, 9, 0, 'false'),
(1418, 9, 0, 'false'),
(1419, 9, 0, 'false'),
(1420, 9, 0, 'false'),
(1421, 9, 0, 'false'),
(1422, 9, 0, 'false'),
(1423, 9, 0, 'false'),
(1424, 9, 0, 'false'),
(1425, 9, 0, 'false'),
(1426, 9, 0, 'false'),
(1427, 9, 0, 'false'),
(1428, 9, 0, 'false'),
(1429, 9, 0, 'false'),
(1430, 9, 0, 'false'),
(1431, 9, 0, 'false'),
(1432, 9, 0, 'false'),
(1433, 9, 0, 'false'),
(1434, 9, 0, 'false'),
(1435, 9, 0, 'false'),
(1436, 9, 0, 'false'),
(1437, 9, 0, 'false'),
(1438, 9, 0, 'false'),
(1439, 9, 0, 'false'),
(1440, 9, 0, 'false'),
(1441, 9, 0, 'false'),
(1442, 9, 0, 'false'),
(1443, 9, 0, 'false'),
(1444, 9, 0, 'false'),
(1445, 9, 0, 'false'),
(1446, 9, 0, 'false'),
(1447, 9, 0, 'true'),
(1448, 9, 0, 'false'),
(1449, 9, 0, 'false'),
(1450, 9, 0, 'false'),
(1451, 9, 0, 'false'),
(1452, 9, 0, 'false'),
(1453, 9, 0, 'false'),
(1454, 9, 0, 'false'),
(1455, 9, 0, 'false'),
(1456, 9, 0, 'false'),
(1457, 9, 0, 'false'),
(1458, 9, 0, 'false'),
(1459, 10, 0, 'false'),
(1460, 10, 0, 'false'),
(1461, 10, 0, 'false'),
(1462, 10, 0, 'false'),
(1463, 10, 0, 'false'),
(1464, 10, 0, 'false'),
(1465, 10, 0, 'false'),
(1466, 10, 0, 'false'),
(1467, 10, 0, 'false'),
(1468, 10, 0, 'false'),
(1469, 10, 0, 'true'),
(1470, 10, 0, 'false'),
(1471, 10, 0, 'false'),
(1472, 10, 0, 'false'),
(1473, 10, 0, 'false'),
(1474, 10, 0, 'false'),
(1475, 10, 0, 'false'),
(1476, 10, 0, 'false'),
(1477, 10, 0, 'false'),
(1478, 10, 0, 'false'),
(1479, 10, 0, 'false'),
(1480, 10, 0, 'false'),
(1481, 10, 0, 'false'),
(1482, 10, 0, 'false'),
(1483, 10, 0, 'false'),
(1484, 10, 0, 'false'),
(1485, 10, 0, 'false'),
(1486, 10, 0, 'false'),
(1487, 10, 0, 'false'),
(1488, 10, 0, 'false'),
(1489, 10, 0, 'false'),
(1490, 10, 0, 'false'),
(1491, 10, 0, 'false'),
(1492, 10, 0, 'true'),
(1493, 10, 0, 'false'),
(1494, 10, 0, 'false'),
(1495, 10, 0, 'false'),
(1496, 10, 0, 'false'),
(1497, 10, 0, 'false'),
(1498, 10, 0, 'false'),
(1499, 10, 0, 'false'),
(1500, 10, 0, 'false'),
(1501, 10, 0, 'false'),
(1502, 10, 0, 'false'),
(1503, 10, 0, 'false'),
(1504, 10, 0, 'false'),
(1505, 10, 0, 'false'),
(1506, 10, 0, 'false'),
(1507, 10, 0, 'false'),
(1508, 10, 0, 'false'),
(1509, 10, 0, 'false'),
(1510, 10, 0, 'false'),
(1511, 10, 0, 'false'),
(1512, 10, 0, 'false'),
(1513, 10, 0, 'false'),
(1514, 10, 0, 'true'),
(1515, 10, 0, 'false'),
(1516, 10, 0, 'false'),
(1517, 10, 0, 'false'),
(1518, 10, 0, 'false'),
(1519, 10, 0, 'false'),
(1520, 10, 0, 'false'),
(1521, 10, 0, 'false'),
(1522, 10, 0, 'false'),
(1523, 10, 0, 'false'),
(1524, 10, 0, 'false'),
(1525, 10, 0, 'false'),
(1526, 10, 0, 'false'),
(1527, 10, 0, 'false'),
(1528, 10, 0, 'false'),
(1529, 10, 0, 'false'),
(1530, 10, 0, 'false'),
(1531, 10, 0, 'false'),
(1532, 10, 0, 'false'),
(1533, 10, 0, 'false'),
(1534, 10, 0, 'false'),
(1535, 10, 0, 'false'),
(1536, 10, 0, 'false'),
(1537, 10, 0, 'false'),
(1538, 10, 0, 'false'),
(1539, 10, 0, 'true'),
(1540, 10, 0, 'false'),
(1541, 10, 0, 'false'),
(1542, 10, 0, 'false'),
(1543, 10, 0, 'false'),
(1544, 10, 0, 'false'),
(1545, 10, 0, 'false'),
(1546, 10, 0, 'false'),
(1547, 10, 0, 'false'),
(1548, 10, 0, 'false'),
(1549, 10, 0, 'false'),
(1550, 10, 0, 'false'),
(1551, 10, 0, 'false'),
(1552, 10, 0, 'false'),
(1553, 10, 0, 'false'),
(1554, 10, 0, 'false'),
(1555, 10, 0, 'false'),
(1556, 10, 0, 'false'),
(1557, 10, 0, 'false'),
(1558, 10, 0, 'false'),
(1559, 10, 0, 'false'),
(1560, 10, 0, 'false'),
(1561, 10, 0, 'true'),
(1562, 10, 0, 'false'),
(1563, 10, 0, 'false'),
(1564, 10, 0, 'false'),
(1565, 10, 0, 'false'),
(1566, 10, 0, 'false'),
(1567, 10, 0, 'false'),
(1568, 10, 0, 'false'),
(1569, 10, 0, 'false'),
(1570, 10, 0, 'false'),
(1571, 10, 0, 'false'),
(1572, 10, 0, 'false'),
(1573, 10, 0, 'false'),
(1574, 10, 0, 'false'),
(1575, 10, 0, 'false'),
(1576, 10, 0, 'false'),
(1577, 10, 0, 'false'),
(1578, 10, 0, 'false'),
(1579, 10, 0, 'false'),
(1580, 10, 0, 'false'),
(1581, 10, 0, 'false'),
(1582, 10, 0, 'true'),
(1583, 10, 0, 'false'),
(1584, 10, 0, 'false'),
(1585, 10, 0, 'false'),
(1586, 10, 0, 'false'),
(1587, 10, 0, 'false'),
(1588, 10, 0, 'false'),
(1589, 10, 0, 'false'),
(1590, 10, 0, 'false'),
(1591, 10, 0, 'false'),
(1592, 10, 0, 'false'),
(1593, 10, 0, 'false'),
(1594, 10, 0, 'false'),
(1595, 10, 0, 'false'),
(1596, 10, 0, 'false'),
(1597, 10, 0, 'false'),
(1598, 10, 0, 'false'),
(1599, 10, 0, 'false'),
(1600, 10, 0, 'false'),
(1601, 10, 0, 'false'),
(1602, 10, 0, 'false'),
(1603, 10, 0, 'false'),
(1604, 10, 0, 'false'),
(1605, 10, 0, 'false'),
(1606, 10, 0, 'false'),
(1607, 10, 0, 'false'),
(1608, 10, 0, 'true'),
(1609, 10, 0, 'false'),
(1610, 10, 0, 'false'),
(1611, 10, 0, 'false'),
(1612, 10, 0, 'false'),
(1613, 10, 0, 'false'),
(1614, 10, 0, 'false'),
(1615, 10, 0, 'false'),
(1616, 10, 0, 'false'),
(1617, 10, 0, 'false'),
(1618, 10, 0, 'false'),
(1619, 10, 0, 'false'),
(1620, 10, 0, 'false'),
(1621, 10, 0, 'false'),
(1622, 10, 0, 'false'),
(1623, 10, 0, 'false'),
(1624, 10, 0, 'false'),
(1625, 10, 0, 'false'),
(1626, 10, 0, 'false'),
(1627, 10, 0, 'false'),
(1628, 10, 0, 'false'),
(1629, 10, 0, 'false'),
(1630, 10, 0, 'false'),
(1631, 10, 0, 'false'),
(1632, 10, 0, 'false'),
(1633, 10, 0, 'false'),
(1634, 10, 0, 'false'),
(1635, 10, 0, 'false'),
(1636, 10, 0, 'false'),
(1637, 10, 0, 'false'),
(1638, 10, 0, 'true'),
(1639, 10, 0, 'false'),
(1640, 10, 0, 'false'),
(1641, 10, 0, 'false'),
(1642, 10, 0, 'false'),
(1643, 10, 0, 'false'),
(1644, 10, 0, 'false'),
(1645, 10, 0, 'false'),
(1646, 10, 0, 'false'),
(1647, 10, 0, 'false'),
(1648, 10, 0, 'false'),
(1649, 10, 0, 'false'),
(1650, 10, 0, 'false'),
(1651, 10, 0, 'false'),
(1652, 10, 0, 'false'),
(1653, 10, 0, 'false'),
(1654, 10, 0, 'false'),
(1655, 10, 0, 'false'),
(1656, 10, 0, 'false'),
(1657, 10, 0, 'false'),
(1658, 10, 0, 'false'),
(1659, 10, 0, 'false'),
(1660, 10, 0, 'false'),
(1661, 10, 0, 'false'),
(1662, 10, 0, 'false'),
(1663, 10, 0, 'true'),
(1664, 10, 0, 'false'),
(1665, 10, 0, 'false'),
(1666, 10, 0, 'false'),
(1667, 10, 0, 'false'),
(1668, 10, 0, 'false'),
(1669, 10, 0, 'false'),
(1670, 10, 0, 'false'),
(1671, 10, 0, 'false'),
(1672, 10, 0, 'false'),
(1673, 10, 0, 'false'),
(1674, 10, 0, 'false'),
(1675, 11, 0, 'false'),
(1676, 11, 0, 'false'),
(1677, 11, 0, 'false'),
(1678, 11, 0, 'false'),
(1679, 11, 0, 'false'),
(1680, 11, 0, 'false'),
(1681, 11, 0, 'false'),
(1682, 11, 0, 'false'),
(1683, 11, 0, 'false'),
(1684, 11, 0, 'false'),
(1685, 11, 0, 'false'),
(1686, 11, 0, 'true'),
(1687, 11, 0, 'false'),
(1688, 11, 0, 'false'),
(1689, 11, 0, 'false'),
(1690, 11, 0, 'false'),
(1691, 11, 0, 'false'),
(1692, 11, 0, 'false'),
(1693, 11, 0, 'false'),
(1694, 11, 0, 'false'),
(1695, 11, 0, 'false'),
(1696, 11, 0, 'false'),
(1697, 11, 0, 'false'),
(1698, 11, 0, 'false'),
(1699, 11, 0, 'false'),
(1700, 11, 0, 'false'),
(1701, 11, 0, 'false'),
(1702, 11, 0, 'false'),
(1703, 11, 0, 'false'),
(1704, 11, 0, 'false'),
(1705, 11, 0, 'false'),
(1706, 11, 0, 'false'),
(1707, 11, 0, 'false'),
(1708, 11, 0, 'false'),
(1709, 11, 0, 'false'),
(1710, 11, 0, 'false'),
(1711, 11, 0, 'true'),
(1712, 11, 0, 'false'),
(1713, 11, 0, 'false'),
(1714, 11, 0, 'false'),
(1715, 11, 0, 'false'),
(1716, 11, 0, 'false'),
(1717, 11, 0, 'false'),
(1718, 11, 0, 'false'),
(1719, 11, 0, 'false'),
(1720, 11, 0, 'false'),
(1721, 11, 0, 'false'),
(1722, 11, 0, 'false'),
(1723, 11, 0, 'false'),
(1724, 11, 0, 'false'),
(1725, 11, 0, 'false'),
(1726, 11, 0, 'true'),
(1727, 11, 0, 'false'),
(1728, 11, 0, 'false'),
(1729, 11, 0, 'false'),
(1730, 11, 0, 'false'),
(1731, 11, 0, 'false'),
(1732, 11, 0, 'false'),
(1733, 11, 0, 'false'),
(1734, 11, 0, 'false'),
(1735, 11, 0, 'false'),
(1736, 11, 0, 'false'),
(1737, 11, 0, 'false'),
(1738, 11, 0, 'false'),
(1739, 11, 0, 'false'),
(1740, 11, 0, 'false'),
(1741, 11, 0, 'false'),
(1742, 11, 0, 'false'),
(1743, 11, 0, 'false'),
(1744, 11, 0, 'false'),
(1745, 11, 0, 'false'),
(1746, 11, 0, 'false'),
(1747, 11, 0, 'false'),
(1748, 11, 0, 'false'),
(1749, 11, 0, 'false'),
(1750, 11, 0, 'false'),
(1751, 11, 0, 'false'),
(1752, 11, 0, 'true'),
(1753, 11, 0, 'false'),
(1754, 11, 0, 'false'),
(1755, 11, 0, 'false'),
(1756, 11, 0, 'false'),
(1757, 11, 0, 'false'),
(1758, 11, 0, 'false'),
(1759, 11, 0, 'false'),
(1760, 11, 0, 'false'),
(1761, 11, 0, 'false'),
(1762, 11, 0, 'false'),
(1763, 11, 0, 'false'),
(1764, 11, 0, 'false'),
(1765, 11, 0, 'false'),
(1766, 11, 0, 'false'),
(1767, 11, 0, 'false'),
(1768, 11, 0, 'false'),
(1769, 11, 0, 'false'),
(1770, 11, 0, 'false'),
(1771, 11, 0, 'false'),
(1772, 11, 0, 'false'),
(1773, 11, 0, 'false'),
(1774, 11, 0, 'false'),
(1775, 11, 0, 'false'),
(1776, 11, 0, 'false'),
(1777, 11, 0, 'true'),
(1778, 11, 0, 'false'),
(1779, 11, 0, 'false'),
(1780, 11, 0, 'false'),
(1781, 11, 0, 'false'),
(1782, 11, 0, 'false'),
(1783, 11, 0, 'false'),
(1784, 11, 0, 'false'),
(1785, 11, 0, 'false'),
(1786, 11, 0, 'false'),
(1787, 11, 0, 'false'),
(1788, 11, 0, 'false'),
(1789, 11, 0, 'false'),
(1790, 11, 0, 'false'),
(1791, 11, 0, 'false'),
(1792, 11, 0, 'false'),
(1793, 11, 0, 'false'),
(1794, 11, 0, 'false'),
(1795, 11, 0, 'false'),
(1796, 11, 0, 'false'),
(1797, 11, 0, 'false'),
(1798, 11, 0, 'false'),
(1799, 11, 0, 'false'),
(1800, 11, 0, 'false'),
(1801, 11, 0, 'false'),
(1802, 11, 0, 'true'),
(1803, 11, 0, 'false'),
(1804, 11, 0, 'false'),
(1805, 11, 0, 'false'),
(1806, 11, 0, 'false'),
(1807, 11, 0, 'false'),
(1808, 11, 0, 'false'),
(1809, 11, 0, 'false'),
(1810, 11, 0, 'false'),
(1811, 11, 0, 'false'),
(1812, 11, 0, 'false'),
(1813, 11, 0, 'false'),
(1814, 11, 0, 'false'),
(1815, 11, 0, 'false'),
(1816, 11, 0, 'false'),
(1817, 11, 0, 'false'),
(1818, 11, 0, 'false'),
(1819, 11, 0, 'false'),
(1820, 11, 0, 'false'),
(1821, 11, 0, 'false'),
(1822, 11, 0, 'false'),
(1823, 11, 0, 'false'),
(1824, 11, 0, 'false'),
(1825, 11, 0, 'false'),
(1826, 11, 0, 'false'),
(1827, 11, 0, 'true'),
(1828, 11, 0, 'false'),
(1829, 11, 0, 'false'),
(1830, 11, 0, 'false'),
(1831, 11, 0, 'false'),
(1832, 11, 0, 'false'),
(1833, 11, 0, 'false'),
(1834, 11, 0, 'false'),
(1835, 11, 0, 'false'),
(1836, 11, 0, 'false'),
(1837, 11, 0, 'false'),
(1838, 11, 0, 'false'),
(1839, 11, 0, 'false'),
(1840, 11, 0, 'false'),
(1841, 11, 0, 'false'),
(1842, 11, 0, 'false'),
(1843, 11, 0, 'false'),
(1844, 11, 0, 'false'),
(1845, 11, 0, 'false'),
(1846, 11, 0, 'false'),
(1847, 11, 0, 'false'),
(1848, 11, 0, 'false'),
(1849, 11, 0, 'false'),
(1850, 11, 0, 'false'),
(1851, 11, 0, 'false'),
(1852, 11, 0, 'true'),
(1853, 11, 0, 'false'),
(1854, 11, 0, 'false'),
(1855, 11, 0, 'false'),
(1856, 11, 0, 'false'),
(1857, 11, 0, 'false'),
(1858, 11, 0, 'false'),
(1859, 11, 0, 'false'),
(1860, 11, 0, 'false'),
(1861, 11, 0, 'false'),
(1862, 11, 0, 'false'),
(1863, 11, 0, 'false'),
(1864, 11, 0, 'false'),
(1865, 11, 0, 'false'),
(1866, 11, 0, 'false'),
(1867, 11, 0, 'false'),
(1868, 11, 0, 'false'),
(1869, 11, 0, 'false'),
(1870, 11, 0, 'false'),
(1871, 11, 0, 'false'),
(1872, 11, 0, 'false'),
(1873, 11, 0, 'false'),
(1874, 11, 0, 'false'),
(1875, 11, 0, 'false'),
(1876, 11, 0, 'false'),
(1877, 11, 0, 'true'),
(1878, 11, 0, 'false'),
(1879, 11, 0, 'false'),
(1880, 11, 0, 'false'),
(1881, 11, 0, 'false'),
(1882, 11, 0, 'false'),
(1883, 11, 0, 'false'),
(1884, 11, 0, 'false'),
(1885, 11, 0, 'false'),
(1886, 11, 0, 'false'),
(1887, 11, 0, 'false'),
(1888, 11, 0, 'false'),
(1889, 11, 0, 'false'),
(1890, 11, 0, 'false'),
(1891, 12, 0, 'false'),
(1892, 12, 0, 'false'),
(1893, 12, 0, 'false'),
(1894, 12, 0, 'false'),
(1895, 12, 0, 'false'),
(1896, 12, 0, 'false'),
(1897, 12, 0, 'false'),
(1898, 12, 0, 'false'),
(1899, 12, 0, 'false'),
(1900, 12, 0, 'false'),
(1901, 12, 0, 'true'),
(1902, 12, 0, 'false'),
(1903, 12, 0, 'false'),
(1904, 12, 0, 'false'),
(1905, 12, 0, 'false'),
(1906, 12, 0, 'false'),
(1907, 12, 0, 'false'),
(1908, 12, 0, 'false'),
(1909, 12, 0, 'false'),
(1910, 12, 0, 'false'),
(1911, 12, 0, 'false'),
(1912, 12, 0, 'false'),
(1913, 12, 0, 'false'),
(1914, 12, 0, 'false'),
(1915, 12, 0, 'false'),
(1916, 12, 0, 'false'),
(1917, 12, 0, 'false'),
(1918, 12, 0, 'true'),
(1919, 12, 0, 'false'),
(1920, 12, 0, 'false'),
(1921, 12, 0, 'false'),
(1922, 12, 0, 'false'),
(1923, 12, 0, 'false'),
(1924, 12, 0, 'false'),
(1925, 12, 0, 'false'),
(1926, 12, 0, 'false'),
(1927, 12, 0, 'false'),
(1928, 12, 0, 'false'),
(1929, 12, 0, 'false'),
(1930, 12, 0, 'false'),
(1931, 12, 0, 'false'),
(1932, 12, 0, 'false'),
(1933, 12, 0, 'false'),
(1934, 12, 0, 'false'),
(1935, 12, 0, 'false'),
(1936, 12, 0, 'false'),
(1937, 12, 0, 'false'),
(1938, 12, 0, 'false'),
(1939, 12, 0, 'false'),
(1940, 12, 0, 'false'),
(1941, 12, 0, 'false'),
(1942, 12, 0, 'false'),
(1943, 12, 0, 'false'),
(1944, 12, 0, 'false'),
(1945, 12, 0, 'true'),
(1946, 12, 0, 'false'),
(1947, 12, 0, 'false'),
(1948, 12, 0, 'false'),
(1949, 12, 0, 'false'),
(1950, 12, 0, 'false'),
(1951, 12, 0, 'false'),
(1952, 12, 0, 'false'),
(1953, 12, 0, 'false'),
(1954, 12, 0, 'false'),
(1955, 12, 0, 'false'),
(1956, 12, 0, 'false'),
(1957, 12, 0, 'false'),
(1958, 12, 0, 'false'),
(1959, 12, 0, 'false'),
(1960, 12, 0, 'false'),
(1961, 12, 0, 'false'),
(1962, 12, 0, 'false'),
(1963, 12, 0, 'false'),
(1964, 12, 0, 'false'),
(1965, 12, 0, 'false'),
(1966, 12, 0, 'false'),
(1967, 12, 0, 'false'),
(1968, 12, 0, 'true'),
(1969, 12, 0, 'false'),
(1970, 12, 0, 'false'),
(1971, 12, 0, 'false'),
(1972, 12, 0, 'false'),
(1973, 12, 0, 'false'),
(1974, 12, 0, 'false'),
(1975, 12, 0, 'false'),
(1976, 12, 0, 'false'),
(1977, 12, 0, 'false'),
(1978, 12, 0, 'false'),
(1979, 12, 0, 'false'),
(1980, 12, 0, 'false'),
(1981, 12, 0, 'false'),
(1982, 12, 0, 'false'),
(1983, 12, 0, 'false'),
(1984, 12, 0, 'false'),
(1985, 12, 0, 'false'),
(1986, 12, 0, 'false'),
(1987, 12, 0, 'false'),
(1988, 12, 0, 'false'),
(1989, 12, 0, 'false'),
(1990, 12, 0, 'false'),
(1991, 12, 0, 'false'),
(1992, 12, 0, 'false'),
(1993, 12, 0, 'false'),
(1994, 12, 0, 'false'),
(1995, 12, 0, 'false'),
(1996, 12, 0, 'true'),
(1997, 12, 0, 'false'),
(1998, 12, 0, 'false'),
(1999, 12, 0, 'false'),
(2000, 12, 0, 'false'),
(2001, 12, 0, 'false'),
(2002, 12, 0, 'false'),
(2003, 12, 0, 'false'),
(2004, 12, 0, 'false'),
(2005, 12, 0, 'false'),
(2006, 12, 0, 'false'),
(2007, 12, 0, 'false'),
(2008, 12, 0, 'false'),
(2009, 12, 0, 'false'),
(2010, 12, 0, 'false'),
(2011, 12, 0, 'false'),
(2012, 12, 0, 'false'),
(2013, 12, 0, 'false'),
(2014, 12, 0, 'false'),
(2015, 12, 0, 'false'),
(2016, 12, 0, 'false'),
(2017, 12, 0, 'false'),
(2018, 12, 0, 'false'),
(2019, 12, 0, 'true'),
(2020, 12, 0, 'false'),
(2021, 12, 0, 'false'),
(2022, 12, 0, 'false'),
(2023, 12, 0, 'false'),
(2024, 12, 0, 'false'),
(2025, 12, 0, 'false'),
(2026, 12, 0, 'false'),
(2027, 12, 0, 'false'),
(2028, 12, 0, 'false'),
(2029, 12, 0, 'false'),
(2030, 12, 0, 'false'),
(2031, 12, 0, 'false'),
(2032, 12, 0, 'false'),
(2033, 12, 0, 'false'),
(2034, 12, 0, 'false'),
(2035, 12, 0, 'false'),
(2036, 12, 0, 'false'),
(2037, 12, 0, 'false'),
(2038, 12, 0, 'false'),
(2039, 12, 0, 'false'),
(2040, 12, 0, 'false'),
(2041, 12, 0, 'false'),
(2042, 12, 0, 'true'),
(2043, 12, 0, 'false'),
(2044, 12, 0, 'false'),
(2045, 12, 0, 'false'),
(2046, 12, 0, 'false'),
(2047, 12, 0, 'false'),
(2048, 12, 0, 'false'),
(2049, 12, 0, 'false'),
(2050, 12, 0, 'false'),
(2051, 12, 0, 'false'),
(2052, 12, 0, 'false'),
(2053, 12, 0, 'false'),
(2054, 12, 0, 'false'),
(2055, 12, 0, 'false'),
(2056, 12, 0, 'false'),
(2057, 12, 0, 'false'),
(2058, 12, 0, 'false'),
(2059, 13, 0, 'false'),
(2060, 13, 0, 'false'),
(2061, 13, 0, 'false'),
(2062, 13, 0, 'true'),
(2063, 13, 0, 'false'),
(2064, 13, 0, 'false'),
(2065, 13, 0, 'false'),
(2066, 13, 0, 'false'),
(2067, 13, 0, 'false'),
(2068, 13, 0, 'false'),
(2069, 13, 0, 'false'),
(2070, 13, 0, 'false'),
(2071, 13, 0, 'false'),
(2072, 13, 0, 'false'),
(2073, 13, 0, 'false'),
(2074, 13, 0, 'false'),
(2075, 13, 0, 'false'),
(2076, 13, 0, 'false'),
(2077, 13, 0, 'false'),
(2078, 13, 0, 'false'),
(2079, 13, 0, 'false'),
(2080, 13, 0, 'false'),
(2081, 13, 0, 'false'),
(2082, 13, 0, 'false'),
(2083, 13, 0, 'false'),
(2084, 13, 0, 'false'),
(2085, 13, 0, 'false'),
(2086, 13, 0, 'false'),
(2087, 13, 0, 'false'),
(2088, 13, 0, 'false'),
(2089, 13, 0, 'false'),
(2090, 13, 0, 'false'),
(2091, 13, 0, 'false'),
(2092, 13, 0, 'true'),
(2093, 13, 0, 'false'),
(2094, 13, 0, 'false'),
(2095, 13, 0, 'false'),
(2096, 13, 0, 'false'),
(2097, 13, 0, 'false'),
(2098, 13, 0, 'false'),
(2099, 13, 0, 'false'),
(2100, 13, 0, 'false'),
(2101, 13, 0, 'false'),
(2102, 13, 0, 'false'),
(2103, 13, 0, 'false'),
(2104, 13, 0, 'false'),
(2105, 13, 0, 'false'),
(2106, 13, 0, 'false'),
(2107, 13, 0, 'false'),
(2108, 13, 0, 'false'),
(2109, 13, 0, 'false'),
(2110, 13, 0, 'false'),
(2111, 13, 0, 'false'),
(2112, 13, 0, 'true'),
(2113, 13, 0, 'false'),
(2114, 13, 0, 'false'),
(2115, 13, 0, 'false'),
(2116, 13, 0, 'false'),
(2117, 13, 0, 'false'),
(2118, 13, 0, 'false'),
(2119, 13, 0, 'false'),
(2120, 13, 0, 'false'),
(2121, 13, 0, 'false'),
(2122, 13, 0, 'false'),
(2123, 13, 0, 'false'),
(2124, 13, 0, 'false'),
(2125, 13, 0, 'false'),
(2126, 13, 0, 'false'),
(2127, 13, 0, 'false'),
(2128, 13, 0, 'false'),
(2129, 13, 0, 'false'),
(2130, 13, 0, 'false'),
(2131, 13, 0, 'false'),
(2132, 13, 0, 'false'),
(2133, 13, 0, 'false'),
(2134, 13, 0, 'false'),
(2135, 13, 0, 'false'),
(2136, 13, 0, 'false'),
(2137, 13, 0, 'true'),
(2138, 13, 0, 'false'),
(2139, 13, 0, 'false'),
(2140, 13, 0, 'false'),
(2141, 13, 0, 'false'),
(2142, 13, 0, 'false'),
(2143, 13, 0, 'false'),
(2144, 13, 0, 'false'),
(2145, 13, 0, 'false'),
(2146, 13, 0, 'false'),
(2147, 13, 0, 'false'),
(2148, 13, 0, 'false'),
(2149, 13, 0, 'false'),
(2150, 13, 0, 'false'),
(2151, 13, 0, 'false'),
(2152, 13, 0, 'false'),
(2153, 13, 0, 'false'),
(2154, 13, 0, 'false'),
(2155, 13, 0, 'false'),
(2156, 13, 0, 'false'),
(2157, 13, 0, 'false'),
(2158, 13, 0, 'false'),
(2159, 13, 0, 'false'),
(2160, 13, 0, 'false'),
(2161, 13, 0, 'false'),
(2162, 13, 0, 'false'),
(2163, 13, 0, 'true'),
(2164, 13, 0, 'false'),
(2165, 13, 0, 'false'),
(2166, 13, 0, 'false'),
(2167, 13, 0, 'false'),
(2168, 13, 0, 'false'),
(2169, 13, 0, 'false'),
(2170, 13, 0, 'false'),
(2171, 13, 0, 'false'),
(2172, 13, 0, 'false'),
(2173, 13, 0, 'false'),
(2174, 13, 0, 'false'),
(2175, 13, 0, 'false'),
(2176, 13, 0, 'false'),
(2177, 13, 0, 'false'),
(2178, 13, 0, 'false'),
(2179, 14, 0, 'false'),
(2180, 14, 0, 'false'),
(2181, 14, 0, 'false'),
(2182, 14, 0, 'true'),
(2183, 14, 0, 'false'),
(2184, 14, 0, 'false'),
(2185, 14, 0, 'false'),
(2186, 14, 0, 'false'),
(2187, 14, 0, 'false'),
(2188, 14, 0, 'false'),
(2189, 14, 0, 'false'),
(2190, 14, 0, 'false'),
(2191, 14, 0, 'false'),
(2192, 14, 0, 'false'),
(2193, 14, 0, 'false'),
(2194, 14, 0, 'false'),
(2195, 14, 0, 'false'),
(2196, 14, 0, 'false'),
(2197, 14, 0, 'false'),
(2198, 14, 0, 'false'),
(2199, 14, 0, 'false'),
(2200, 14, 0, 'false'),
(2201, 14, 0, 'false'),
(2202, 14, 0, 'false'),
(2203, 14, 0, 'false'),
(2204, 14, 0, 'false'),
(2205, 14, 0, 'false'),
(2206, 14, 0, 'false'),
(2207, 14, 0, 'false'),
(2208, 14, 0, 'false'),
(2209, 14, 0, 'false'),
(2210, 14, 0, 'true'),
(2211, 14, 0, 'false'),
(2212, 14, 0, 'false'),
(2213, 14, 0, 'false'),
(2214, 14, 0, 'false'),
(2215, 14, 0, 'false'),
(2216, 14, 0, 'false'),
(2217, 14, 0, 'false'),
(2218, 14, 0, 'false'),
(2219, 14, 0, 'false'),
(2220, 14, 0, 'false'),
(2221, 14, 0, 'false'),
(2222, 14, 0, 'false'),
(2223, 14, 0, 'false'),
(2224, 14, 0, 'false'),
(2225, 14, 0, 'false'),
(2226, 14, 0, 'false'),
(2227, 14, 0, 'false'),
(2228, 14, 0, 'false'),
(2229, 14, 0, 'false'),
(2230, 14, 0, 'false'),
(2231, 14, 0, 'false'),
(2232, 14, 0, 'false'),
(2233, 14, 0, 'false'),
(2234, 14, 0, 'false'),
(2235, 14, 0, 'false'),
(2236, 14, 0, 'false'),
(2237, 14, 0, 'false'),
(2238, 14, 0, 'false'),
(2239, 14, 0, 'false'),
(2240, 14, 0, 'false'),
(2241, 14, 0, 'false'),
(2242, 14, 0, 'false'),
(2243, 14, 0, 'false'),
(2244, 14, 0, 'false'),
(2245, 14, 0, 'false'),
(2246, 14, 0, 'false'),
(2247, 14, 0, 'false'),
(2248, 14, 0, 'false'),
(2249, 14, 0, 'false'),
(2250, 14, 0, 'true'),
(2251, 14, 0, 'false'),
(2252, 14, 0, 'false'),
(2253, 14, 0, 'false'),
(2254, 14, 0, 'false'),
(2255, 14, 0, 'false'),
(2256, 14, 0, 'false'),
(2257, 14, 0, 'false'),
(2258, 14, 0, 'false'),
(2259, 14, 0, 'true'),
(2260, 14, 0, 'false'),
(2261, 14, 0, 'false'),
(2262, 14, 0, 'false'),
(2263, 14, 0, 'false'),
(2264, 14, 0, 'false'),
(2265, 14, 0, 'false'),
(2266, 14, 0, 'false'),
(2267, 14, 0, 'false'),
(2268, 14, 0, 'false'),
(2269, 14, 0, 'false'),
(2270, 14, 0, 'false'),
(2271, 14, 0, 'false'),
(2272, 14, 0, 'false'),
(2273, 14, 0, 'false'),
(2274, 14, 0, 'false'),
(2275, 14, 0, 'false'),
(2276, 14, 0, 'false'),
(2277, 14, 0, 'false'),
(2278, 14, 0, 'false'),
(2279, 14, 0, 'false'),
(2280, 14, 0, 'false'),
(2281, 14, 0, 'false'),
(2282, 14, 0, 'false'),
(2283, 14, 0, 'false'),
(2284, 14, 0, 'true'),
(2285, 14, 0, 'false'),
(2286, 14, 0, 'false'),
(2287, 14, 0, 'false'),
(2288, 14, 0, 'false'),
(2289, 14, 0, 'false'),
(2290, 14, 0, 'false'),
(2291, 14, 0, 'false'),
(2292, 14, 0, 'false'),
(2293, 14, 0, 'false'),
(2294, 14, 0, 'false'),
(2295, 14, 0, 'false'),
(2296, 14, 0, 'false'),
(2297, 14, 0, 'false'),
(2298, 14, 0, 'false'),
(2299, 14, 0, 'false'),
(2300, 14, 0, 'false'),
(2301, 14, 0, 'false'),
(2302, 14, 0, 'false'),
(2303, 14, 0, 'false'),
(2304, 14, 0, 'false'),
(2305, 14, 0, 'true'),
(2306, 14, 0, 'false'),
(2307, 14, 0, 'false'),
(2308, 14, 0, 'false'),
(2309, 14, 0, 'false'),
(2310, 14, 0, 'false'),
(2311, 14, 0, 'false'),
(2312, 14, 0, 'false'),
(2313, 14, 0, 'false'),
(2314, 14, 0, 'false'),
(2315, 14, 0, 'false'),
(2316, 14, 0, 'false'),
(2317, 14, 0, 'false'),
(2318, 14, 0, 'false'),
(2319, 14, 0, 'false'),
(2320, 14, 0, 'false'),
(2321, 14, 0, 'false'),
(2322, 14, 0, 'false'),
(2323, 14, 0, 'false'),
(2324, 14, 0, 'false'),
(2325, 14, 0, 'false'),
(2326, 14, 0, 'false'),
(2327, 14, 0, 'false'),
(2328, 14, 0, 'false'),
(2329, 14, 0, 'false'),
(2330, 14, 0, 'false'),
(2331, 14, 0, 'false'),
(2332, 14, 0, 'false'),
(2333, 14, 0, 'true'),
(2334, 14, 0, 'false'),
(2335, 14, 0, 'false'),
(2336, 14, 0, 'false'),
(2337, 14, 0, 'false'),
(2338, 14, 0, 'false'),
(2339, 14, 0, 'false'),
(2340, 14, 0, 'false'),
(2341, 14, 0, 'false'),
(2342, 14, 0, 'false'),
(2343, 14, 0, 'false'),
(2344, 14, 0, 'false'),
(2345, 14, 0, 'false'),
(2346, 14, 0, 'false'),
(2347, 15, 0, 'false'),
(2348, 15, 0, 'false'),
(2349, 15, 0, 'false'),
(2350, 15, 0, 'false'),
(2351, 15, 0, 'false'),
(2352, 15, 0, 'false'),
(2353, 15, 0, 'true'),
(2354, 15, 0, 'false'),
(2355, 15, 0, 'false'),
(2356, 15, 0, 'false'),
(2357, 15, 0, 'false'),
(2358, 15, 0, 'false'),
(2359, 15, 0, 'false'),
(2360, 15, 0, 'false'),
(2361, 15, 0, 'false'),
(2362, 15, 0, 'false'),
(2363, 15, 0, 'false'),
(2364, 15, 0, 'false'),
(2365, 15, 0, 'false'),
(2366, 15, 0, 'false'),
(2367, 15, 0, 'false'),
(2368, 15, 0, 'false'),
(2369, 15, 0, 'false'),
(2370, 15, 0, 'false'),
(2371, 15, 0, 'false'),
(2372, 15, 0, 'false'),
(2373, 15, 0, 'false'),
(2374, 15, 0, 'true'),
(2375, 15, 0, 'false'),
(2376, 15, 0, 'false'),
(2377, 15, 0, 'false'),
(2378, 15, 0, 'false'),
(2379, 15, 0, 'false'),
(2380, 15, 0, 'false'),
(2381, 15, 0, 'false'),
(2382, 15, 0, 'false'),
(2383, 15, 0, 'false'),
(2384, 15, 0, 'false'),
(2385, 15, 0, 'false'),
(2386, 15, 0, 'false'),
(2387, 15, 0, 'false'),
(2388, 15, 0, 'false'),
(2389, 15, 0, 'false'),
(2390, 15, 0, 'false'),
(2391, 15, 0, 'false'),
(2392, 15, 0, 'false'),
(2393, 15, 0, 'false'),
(2394, 15, 0, 'false'),
(2395, 15, 0, 'false'),
(2396, 15, 0, 'false'),
(2397, 15, 0, 'false'),
(2398, 15, 0, 'false'),
(2399, 15, 0, 'false'),
(2400, 15, 0, 'true'),
(2401, 15, 0, 'false'),
(2402, 15, 0, 'false'),
(2403, 15, 0, 'false'),
(2404, 15, 0, 'false'),
(2405, 15, 0, 'false'),
(2406, 15, 0, 'false'),
(2407, 15, 0, 'false'),
(2408, 15, 0, 'false'),
(2409, 15, 0, 'false'),
(2410, 15, 0, 'false'),
(2411, 15, 0, 'false'),
(2412, 15, 0, 'false'),
(2413, 15, 0, 'false'),
(2414, 15, 0, 'false'),
(2415, 15, 0, 'false'),
(2416, 15, 0, 'false'),
(2417, 15, 0, 'false'),
(2418, 15, 0, 'false'),
(2419, 15, 0, 'false'),
(2420, 15, 0, 'false'),
(2421, 15, 0, 'false'),
(2422, 15, 0, 'false'),
(2423, 15, 0, 'false'),
(2424, 15, 0, 'false'),
(2425, 15, 0, 'false'),
(2426, 15, 0, 'true'),
(2427, 15, 0, 'false'),
(2428, 15, 0, 'false'),
(2429, 15, 0, 'false'),
(2430, 15, 0, 'false'),
(2431, 15, 0, 'false'),
(2432, 15, 0, 'false'),
(2433, 15, 0, 'false'),
(2434, 15, 0, 'false'),
(2435, 15, 0, 'false'),
(2436, 15, 0, 'false'),
(2437, 15, 0, 'false'),
(2438, 15, 0, 'false'),
(2439, 15, 0, 'false'),
(2440, 15, 0, 'false'),
(2441, 15, 0, 'false'),
(2442, 15, 0, 'false'),
(2443, 15, 0, 'false'),
(2444, 15, 0, 'false'),
(2445, 15, 0, 'false'),
(2446, 15, 0, 'false'),
(2447, 15, 0, 'false');
INSERT INTO `i_ext_et_invoice_terms` (`iexteintm_id`, `iexteintm_inid`, `iexteintm_term_id`, `iexteintm_status`) VALUES
(2448, 15, 0, 'false'),
(2449, 15, 0, 'false'),
(2450, 15, 0, 'false'),
(2451, 15, 0, 'true'),
(2452, 15, 0, 'false'),
(2453, 15, 0, 'false'),
(2454, 15, 0, 'false'),
(2455, 15, 0, 'false'),
(2456, 15, 0, 'false'),
(2457, 15, 0, 'false'),
(2458, 15, 0, 'false'),
(2459, 15, 0, 'false'),
(2460, 15, 0, 'false'),
(2461, 15, 0, 'false'),
(2462, 15, 0, 'false'),
(2463, 15, 0, 'false'),
(2464, 15, 0, 'false'),
(2465, 15, 0, 'false'),
(2466, 15, 0, 'false'),
(2467, 15, 0, 'false'),
(2468, 15, 0, 'false'),
(2469, 15, 0, 'false'),
(2470, 15, 0, 'false'),
(2471, 15, 0, 'false'),
(2472, 15, 0, 'false'),
(2473, 15, 0, 'false'),
(2474, 15, 0, 'false'),
(2475, 15, 0, 'false'),
(2476, 15, 0, 'true'),
(2477, 15, 0, 'false'),
(2478, 15, 0, 'false'),
(2479, 15, 0, 'false'),
(2480, 15, 0, 'false'),
(2481, 15, 0, 'false'),
(2482, 15, 0, 'false'),
(2483, 15, 0, 'false'),
(2484, 15, 0, 'false'),
(2485, 15, 0, 'false'),
(2486, 15, 0, 'false'),
(2487, 15, 0, 'false'),
(2488, 15, 0, 'false'),
(2489, 15, 0, 'false'),
(2490, 15, 0, 'false'),
(2491, 15, 0, 'false'),
(2492, 15, 0, 'false'),
(2493, 15, 0, 'false'),
(2494, 15, 0, 'false'),
(2495, 15, 0, 'false'),
(2496, 15, 0, 'false'),
(2497, 15, 0, 'false'),
(2498, 15, 0, 'false'),
(2499, 15, 0, 'false'),
(2500, 15, 0, 'false'),
(2501, 15, 0, 'true'),
(2502, 15, 0, 'false'),
(2503, 15, 0, 'false'),
(2504, 15, 0, 'false'),
(2505, 15, 0, 'false'),
(2506, 15, 0, 'false'),
(2507, 15, 0, 'false'),
(2508, 15, 0, 'false'),
(2509, 15, 0, 'false'),
(2510, 15, 0, 'false'),
(2511, 15, 0, 'false'),
(2512, 15, 0, 'false'),
(2513, 15, 0, 'false'),
(2514, 15, 0, 'false'),
(2515, 15, 0, 'false'),
(2516, 15, 0, 'false'),
(2517, 15, 0, 'false'),
(2518, 15, 0, 'false'),
(2519, 15, 0, 'false'),
(2520, 15, 0, 'false'),
(2521, 15, 0, 'false'),
(2522, 15, 0, 'false'),
(2523, 15, 0, 'false'),
(2524, 15, 0, 'false'),
(2525, 15, 0, 'false'),
(2526, 15, 0, 'true'),
(2527, 15, 0, 'false'),
(2528, 15, 0, 'false'),
(2529, 15, 0, 'false'),
(2530, 15, 0, 'false'),
(2531, 15, 0, 'false'),
(2532, 15, 0, 'false'),
(2533, 15, 0, 'false'),
(2534, 15, 0, 'false'),
(2535, 15, 0, 'false'),
(2536, 15, 0, 'false'),
(2537, 15, 0, 'false'),
(2538, 15, 0, 'false'),
(2539, 15, 0, 'false'),
(2540, 15, 0, 'false'),
(2541, 15, 0, 'false'),
(2542, 15, 0, 'false'),
(2543, 15, 0, 'false'),
(2544, 15, 0, 'false'),
(2545, 15, 0, 'false'),
(2546, 15, 0, 'false'),
(2547, 15, 0, 'false'),
(2548, 15, 0, 'false'),
(2549, 15, 0, 'false'),
(2550, 15, 0, 'false'),
(2551, 15, 0, 'true'),
(2552, 15, 0, 'false'),
(2553, 15, 0, 'false'),
(2554, 15, 0, 'false'),
(2555, 15, 0, 'false'),
(2556, 15, 0, 'false'),
(2557, 15, 0, 'false'),
(2558, 15, 0, 'false'),
(2559, 15, 0, 'false'),
(2560, 15, 0, 'false'),
(2561, 15, 0, 'false'),
(2562, 15, 0, 'false'),
(2563, 15, 0, 'false'),
(2564, 15, 0, 'false'),
(2565, 15, 0, 'false'),
(2566, 15, 0, 'false'),
(2567, 15, 0, 'false'),
(2568, 15, 0, 'false'),
(2569, 15, 0, 'false'),
(2570, 15, 0, 'false'),
(2571, 15, 0, 'false'),
(2572, 15, 0, 'false'),
(2573, 15, 0, 'false'),
(2574, 15, 0, 'false'),
(2575, 15, 0, 'false'),
(2576, 15, 0, 'false'),
(2577, 15, 0, 'false'),
(2578, 15, 0, 'false'),
(2579, 15, 0, 'false'),
(2580, 15, 0, 'false'),
(2581, 15, 0, 'false'),
(2582, 15, 0, 'false'),
(2583, 15, 0, 'false'),
(2584, 15, 0, 'false'),
(2585, 15, 0, 'false'),
(2586, 15, 0, 'true'),
(2587, 16, 0, 'false'),
(2588, 16, 0, 'false'),
(2589, 16, 0, 'false'),
(2590, 16, 0, 'false'),
(2591, 16, 0, 'false'),
(2592, 16, 0, 'false'),
(2593, 16, 0, 'false'),
(2594, 16, 0, 'false'),
(2595, 16, 0, 'false'),
(2596, 16, 0, 'false'),
(2597, 16, 0, 'false'),
(2598, 16, 0, 'false'),
(2599, 16, 0, 'true'),
(2600, 16, 0, 'false'),
(2601, 16, 0, 'false'),
(2602, 16, 0, 'false'),
(2603, 16, 0, 'false'),
(2604, 16, 0, 'false'),
(2605, 16, 0, 'false'),
(2606, 16, 0, 'false'),
(2607, 16, 0, 'false'),
(2608, 16, 0, 'false'),
(2609, 16, 0, 'false'),
(2610, 16, 0, 'false'),
(2611, 16, 0, 'false'),
(2612, 16, 0, 'false'),
(2613, 16, 0, 'false'),
(2614, 16, 0, 'false'),
(2615, 16, 0, 'false'),
(2616, 16, 0, 'false'),
(2617, 16, 0, 'false'),
(2618, 16, 0, 'false'),
(2619, 16, 0, 'false'),
(2620, 16, 0, 'false'),
(2621, 16, 0, 'false'),
(2622, 16, 0, 'true'),
(2623, 16, 0, 'false'),
(2624, 16, 0, 'false'),
(2625, 16, 0, 'false'),
(2626, 16, 0, 'false'),
(2627, 16, 0, 'false'),
(2628, 16, 0, 'false'),
(2629, 16, 0, 'false'),
(2630, 16, 0, 'false'),
(2631, 16, 0, 'false'),
(2632, 16, 0, 'false'),
(2633, 16, 0, 'false'),
(2634, 16, 0, 'false'),
(2635, 16, 0, 'false'),
(2636, 16, 0, 'false'),
(2637, 16, 0, 'false'),
(2638, 16, 0, 'false'),
(2639, 16, 0, 'false'),
(2640, 16, 0, 'false'),
(2641, 16, 0, 'false'),
(2642, 16, 0, 'true'),
(2643, 16, 0, 'false'),
(2644, 16, 0, 'false'),
(2645, 16, 0, 'false'),
(2646, 16, 0, 'false'),
(2647, 16, 0, 'false'),
(2648, 16, 0, 'false'),
(2649, 16, 0, 'false'),
(2650, 16, 0, 'false'),
(2651, 16, 0, 'false'),
(2652, 16, 0, 'false'),
(2653, 16, 0, 'false'),
(2654, 16, 0, 'false'),
(2655, 16, 0, 'false'),
(2656, 16, 0, 'false'),
(2657, 16, 0, 'false'),
(2658, 16, 0, 'false'),
(2659, 16, 0, 'false'),
(2660, 16, 0, 'false'),
(2661, 16, 0, 'false'),
(2662, 16, 0, 'false'),
(2663, 16, 0, 'false'),
(2664, 16, 0, 'false'),
(2665, 16, 0, 'false'),
(2666, 16, 0, 'false'),
(2667, 16, 0, 'false'),
(2668, 16, 0, 'false'),
(2669, 16, 0, 'true'),
(2670, 16, 0, 'false'),
(2671, 16, 0, 'false'),
(2672, 16, 0, 'false'),
(2673, 16, 0, 'false'),
(2674, 16, 0, 'false'),
(2675, 16, 0, 'false'),
(2676, 16, 0, 'false'),
(2677, 16, 0, 'false'),
(2678, 16, 0, 'false'),
(2679, 16, 0, 'false'),
(2680, 16, 0, 'false'),
(2681, 16, 0, 'false'),
(2682, 16, 0, 'false'),
(2683, 16, 0, 'false'),
(2684, 16, 0, 'false'),
(2685, 16, 0, 'false'),
(2686, 16, 0, 'false'),
(2687, 16, 0, 'false'),
(2688, 16, 0, 'false'),
(2689, 16, 0, 'true'),
(2690, 16, 0, 'false'),
(2691, 16, 0, 'false'),
(2692, 16, 0, 'false'),
(2693, 16, 0, 'false'),
(2694, 16, 0, 'false'),
(2695, 16, 0, 'false'),
(2696, 16, 0, 'false'),
(2697, 16, 0, 'false'),
(2698, 16, 0, 'false'),
(2699, 16, 0, 'false'),
(2700, 16, 0, 'false'),
(2701, 16, 0, 'false'),
(2702, 16, 0, 'false'),
(2703, 16, 0, 'false'),
(2704, 16, 0, 'false'),
(2705, 16, 0, 'false'),
(2706, 16, 0, 'false'),
(2707, 16, 0, 'false'),
(2708, 16, 0, 'false'),
(2709, 16, 0, 'false'),
(2710, 16, 0, 'false'),
(2711, 16, 0, 'false'),
(2712, 16, 0, 'false'),
(2713, 16, 0, 'false'),
(2714, 16, 0, 'false'),
(2715, 16, 0, 'false'),
(2716, 16, 0, 'true'),
(2717, 16, 0, 'false'),
(2718, 16, 0, 'false'),
(2719, 16, 0, 'false'),
(2720, 16, 0, 'false'),
(2721, 16, 0, 'false'),
(2722, 16, 0, 'false'),
(2723, 16, 0, 'false'),
(2724, 16, 0, 'false'),
(2725, 16, 0, 'false'),
(2726, 16, 0, 'false'),
(2727, 16, 0, 'false'),
(2728, 16, 0, 'false'),
(2729, 16, 0, 'false'),
(2730, 16, 0, 'false'),
(2731, 16, 0, 'false'),
(2732, 16, 0, 'false'),
(2733, 16, 0, 'false'),
(2734, 16, 0, 'false'),
(2735, 16, 0, 'false'),
(2736, 16, 0, 'false'),
(2737, 16, 0, 'false'),
(2738, 16, 0, 'false'),
(2739, 16, 0, 'true'),
(2740, 16, 0, 'false'),
(2741, 16, 0, 'false'),
(2742, 16, 0, 'false'),
(2743, 16, 0, 'false'),
(2744, 16, 0, 'false'),
(2745, 16, 0, 'false'),
(2746, 16, 0, 'false'),
(2747, 16, 0, 'false'),
(2748, 16, 0, 'false'),
(2749, 16, 0, 'false'),
(2750, 16, 0, 'false'),
(2751, 16, 0, 'false'),
(2752, 16, 0, 'false'),
(2753, 16, 0, 'false'),
(2754, 16, 0, 'false'),
(2755, 16, 0, 'false'),
(2756, 16, 0, 'false'),
(2757, 16, 0, 'false'),
(2758, 16, 0, 'false'),
(2759, 16, 0, 'false'),
(2760, 16, 0, 'true'),
(2761, 16, 0, 'false'),
(2762, 16, 0, 'false'),
(2763, 16, 0, 'false'),
(2764, 16, 0, 'false'),
(2765, 16, 0, 'false'),
(2766, 16, 0, 'false'),
(2767, 16, 0, 'false'),
(2768, 16, 0, 'false'),
(2769, 16, 0, 'false'),
(2770, 16, 0, 'false'),
(2771, 16, 0, 'false'),
(2772, 16, 0, 'false'),
(2773, 16, 0, 'false'),
(2774, 16, 0, 'false'),
(2775, 16, 0, 'false'),
(2776, 16, 0, 'false'),
(2777, 16, 0, 'false'),
(2778, 16, 0, 'false'),
(2779, 16, 0, 'false'),
(2780, 16, 0, 'false'),
(2781, 16, 0, 'false'),
(2782, 16, 0, 'true'),
(2783, 16, 0, 'false'),
(2784, 16, 0, 'false'),
(2785, 16, 0, 'false'),
(2786, 16, 0, 'false'),
(2787, 16, 0, 'false'),
(2788, 16, 0, 'false'),
(2789, 16, 0, 'false'),
(2790, 16, 0, 'false'),
(2791, 16, 0, 'false'),
(2792, 16, 0, 'false'),
(2793, 16, 0, 'false'),
(2794, 16, 0, 'false'),
(2795, 16, 0, 'false'),
(2796, 16, 0, 'false'),
(2797, 16, 0, 'false'),
(2798, 16, 0, 'false'),
(2799, 16, 0, 'false'),
(2800, 16, 0, 'false'),
(2801, 16, 0, 'false'),
(2802, 16, 0, 'false'),
(2803, 16, 0, 'false'),
(2804, 16, 0, 'false'),
(2805, 16, 0, 'false'),
(2806, 16, 0, 'false'),
(2807, 16, 0, 'false'),
(2808, 16, 0, 'false'),
(2809, 16, 0, 'false'),
(2810, 16, 0, 'false'),
(2811, 16, 0, 'false'),
(2812, 16, 0, 'false'),
(2813, 16, 0, 'false'),
(2814, 16, 0, 'false'),
(2815, 16, 0, 'false'),
(2816, 16, 0, 'false'),
(2817, 16, 0, 'false'),
(2818, 16, 0, 'false'),
(2819, 16, 0, 'false'),
(2820, 16, 0, 'false'),
(2821, 16, 0, 'false'),
(2822, 16, 0, 'false'),
(2823, 16, 0, 'false'),
(2824, 16, 0, 'false'),
(2825, 16, 0, 'false'),
(2826, 16, 0, 'true'),
(2827, 17, 0, 'false'),
(2828, 17, 0, 'false'),
(2829, 17, 0, 'false'),
(2830, 17, 0, 'true'),
(2831, 17, 0, 'false'),
(2832, 17, 0, 'false'),
(2833, 17, 0, 'false'),
(2834, 17, 0, 'false'),
(2835, 17, 0, 'false'),
(2836, 17, 0, 'false'),
(2837, 17, 0, 'false'),
(2838, 17, 0, 'false'),
(2839, 17, 0, 'false'),
(2840, 17, 0, 'false'),
(2841, 17, 0, 'false'),
(2842, 17, 0, 'false'),
(2843, 17, 0, 'false'),
(2844, 17, 0, 'false'),
(2845, 17, 0, 'false'),
(2846, 17, 0, 'false'),
(2847, 17, 0, 'false'),
(2848, 17, 0, 'false'),
(2849, 17, 0, 'false'),
(2850, 17, 0, 'false'),
(2851, 17, 0, 'false'),
(2852, 17, 0, 'false'),
(2853, 17, 0, 'false'),
(2854, 17, 0, 'false'),
(2855, 17, 0, 'false'),
(2856, 17, 0, 'true'),
(2857, 17, 0, 'false'),
(2858, 17, 0, 'false'),
(2859, 17, 0, 'false'),
(2860, 17, 0, 'false'),
(2861, 17, 0, 'false'),
(2862, 17, 0, 'false'),
(2863, 17, 0, 'false'),
(2864, 17, 0, 'false'),
(2865, 17, 0, 'false'),
(2866, 17, 0, 'false'),
(2867, 17, 0, 'false'),
(2868, 17, 0, 'false'),
(2869, 17, 0, 'false'),
(2870, 17, 0, 'false'),
(2871, 17, 0, 'false'),
(2872, 17, 0, 'false'),
(2873, 17, 0, 'false'),
(2874, 17, 0, 'false'),
(2875, 17, 0, 'false'),
(2876, 17, 0, 'false'),
(2877, 17, 0, 'false'),
(2878, 17, 0, 'false'),
(2879, 17, 0, 'false'),
(2880, 17, 0, 'false'),
(2881, 17, 0, 'true'),
(2882, 17, 0, 'false'),
(2883, 17, 0, 'false'),
(2884, 17, 0, 'false'),
(2885, 17, 0, 'false'),
(2886, 17, 0, 'false'),
(2887, 17, 0, 'false'),
(2888, 17, 0, 'false'),
(2889, 17, 0, 'false'),
(2890, 17, 0, 'false'),
(2891, 17, 0, 'false'),
(2892, 17, 0, 'false'),
(2893, 17, 0, 'false'),
(2894, 17, 0, 'false'),
(2895, 17, 0, 'false'),
(2896, 17, 0, 'false'),
(2897, 17, 0, 'false'),
(2898, 17, 0, 'false'),
(2899, 17, 0, 'false'),
(2900, 17, 0, 'false'),
(2901, 17, 0, 'false'),
(2902, 17, 0, 'false'),
(2903, 17, 0, 'false'),
(2904, 17, 0, 'false'),
(2905, 17, 0, 'false'),
(2906, 17, 0, 'false'),
(2907, 17, 0, 'true'),
(2908, 17, 0, 'false'),
(2909, 17, 0, 'false'),
(2910, 17, 0, 'false'),
(2911, 17, 0, 'false'),
(2912, 17, 0, 'false'),
(2913, 17, 0, 'false'),
(2914, 17, 0, 'false'),
(2915, 17, 0, 'false'),
(2916, 17, 0, 'false'),
(2917, 17, 0, 'false'),
(2918, 17, 0, 'false'),
(2919, 17, 0, 'false'),
(2920, 17, 0, 'false'),
(2921, 17, 0, 'false'),
(2922, 17, 0, 'false'),
(2923, 17, 0, 'false'),
(2924, 17, 0, 'false'),
(2925, 17, 0, 'false'),
(2926, 17, 0, 'false'),
(2927, 17, 0, 'false'),
(2928, 17, 0, 'false'),
(2929, 17, 0, 'false'),
(2930, 17, 0, 'false'),
(2931, 17, 0, 'false'),
(2932, 17, 0, 'true'),
(2933, 17, 0, 'false'),
(2934, 17, 0, 'false'),
(2935, 17, 0, 'false'),
(2936, 17, 0, 'false'),
(2937, 17, 0, 'false'),
(2938, 17, 0, 'false'),
(2939, 17, 0, 'false'),
(2940, 17, 0, 'false'),
(2941, 17, 0, 'false'),
(2942, 17, 0, 'false'),
(2943, 17, 0, 'false'),
(2944, 17, 0, 'false'),
(2945, 17, 0, 'false'),
(2946, 17, 0, 'false'),
(2947, 17, 0, 'false'),
(2948, 17, 0, 'false'),
(2949, 17, 0, 'false'),
(2950, 17, 0, 'false'),
(2951, 17, 0, 'false'),
(2952, 17, 0, 'false'),
(2953, 17, 0, 'false'),
(2954, 17, 0, 'false'),
(2955, 17, 0, 'false'),
(2956, 17, 0, 'false'),
(2957, 17, 0, 'false'),
(2958, 17, 0, 'true'),
(2959, 17, 0, 'false'),
(2960, 17, 0, 'false'),
(2961, 17, 0, 'false'),
(2962, 17, 0, 'false'),
(2963, 17, 0, 'false'),
(2964, 17, 0, 'false'),
(2965, 17, 0, 'false'),
(2966, 17, 0, 'false'),
(2967, 17, 0, 'false'),
(2968, 17, 0, 'false'),
(2969, 17, 0, 'false'),
(2970, 17, 0, 'false'),
(2971, 17, 0, 'false'),
(2972, 17, 0, 'false'),
(2973, 17, 0, 'false'),
(2974, 17, 0, 'false'),
(2975, 17, 0, 'false'),
(2976, 17, 0, 'false'),
(2977, 17, 0, 'false'),
(2978, 17, 0, 'false'),
(2979, 17, 0, 'false'),
(2980, 17, 0, 'false'),
(2981, 17, 0, 'false'),
(2982, 17, 0, 'false'),
(2983, 17, 0, 'true'),
(2984, 17, 0, 'false'),
(2985, 17, 0, 'false'),
(2986, 17, 0, 'false'),
(2987, 17, 0, 'false'),
(2988, 17, 0, 'false'),
(2989, 17, 0, 'false'),
(2990, 17, 0, 'false'),
(2991, 17, 0, 'false'),
(2992, 17, 0, 'false'),
(2993, 17, 0, 'false'),
(2994, 17, 0, 'false'),
(2995, 18, 0, 'false'),
(2996, 18, 0, 'false'),
(2997, 18, 0, 'false'),
(2998, 18, 0, 'true'),
(2999, 18, 0, 'false'),
(3000, 18, 0, 'false'),
(3001, 18, 0, 'false'),
(3002, 18, 0, 'false'),
(3003, 18, 0, 'false'),
(3004, 18, 0, 'false'),
(3005, 18, 0, 'false'),
(3006, 18, 0, 'false'),
(3007, 18, 0, 'false'),
(3008, 18, 0, 'false'),
(3009, 18, 0, 'false'),
(3010, 18, 0, 'false'),
(3011, 18, 0, 'false'),
(3012, 18, 0, 'false'),
(3013, 18, 0, 'false'),
(3014, 18, 0, 'false'),
(3015, 18, 0, 'false'),
(3016, 18, 0, 'false'),
(3017, 18, 0, 'false'),
(3018, 18, 0, 'false'),
(3019, 18, 0, 'false'),
(3020, 18, 0, 'false'),
(3021, 18, 0, 'false'),
(3022, 18, 0, 'false'),
(3023, 18, 0, 'false'),
(3024, 18, 0, 'false'),
(3025, 18, 0, 'false'),
(3026, 18, 0, 'false'),
(3027, 18, 0, 'false'),
(3028, 18, 0, 'false'),
(3029, 18, 0, 'false'),
(3030, 18, 0, 'true'),
(3031, 18, 0, 'false'),
(3032, 18, 0, 'false'),
(3033, 18, 0, 'false'),
(3034, 18, 0, 'false'),
(3035, 18, 0, 'false'),
(3036, 18, 0, 'false'),
(3037, 18, 0, 'false'),
(3038, 18, 0, 'false'),
(3039, 18, 0, 'false'),
(3040, 18, 0, 'false'),
(3041, 18, 0, 'false'),
(3042, 18, 0, 'false'),
(3043, 18, 0, 'false'),
(3044, 18, 0, 'false'),
(3045, 18, 0, 'false'),
(3046, 18, 0, 'false'),
(3047, 18, 0, 'false'),
(3048, 18, 0, 'false'),
(3049, 18, 0, 'false'),
(3050, 18, 0, 'false'),
(3051, 18, 0, 'true'),
(3052, 18, 0, 'false'),
(3053, 18, 0, 'false'),
(3054, 18, 0, 'false'),
(3055, 18, 0, 'false'),
(3056, 18, 0, 'false'),
(3057, 18, 0, 'false'),
(3058, 18, 0, 'false'),
(3059, 18, 0, 'false'),
(3060, 18, 0, 'false'),
(3061, 18, 0, 'false'),
(3062, 18, 0, 'false'),
(3063, 18, 0, 'false'),
(3064, 18, 0, 'false'),
(3065, 18, 0, 'false'),
(3066, 18, 0, 'false'),
(3067, 18, 0, 'false'),
(3068, 18, 0, 'false'),
(3069, 18, 0, 'false'),
(3070, 18, 0, 'false'),
(3071, 18, 0, 'false'),
(3072, 18, 0, 'false'),
(3073, 18, 0, 'true'),
(3074, 18, 0, 'false'),
(3075, 18, 0, 'false'),
(3076, 18, 0, 'false'),
(3077, 18, 0, 'false'),
(3078, 18, 0, 'false'),
(3079, 18, 0, 'false'),
(3080, 18, 0, 'false'),
(3081, 18, 0, 'false'),
(3082, 18, 0, 'false'),
(3083, 18, 0, 'false'),
(3084, 18, 0, 'false'),
(3085, 18, 0, 'false'),
(3086, 18, 0, 'false'),
(3087, 18, 0, 'false'),
(3088, 18, 0, 'false'),
(3089, 18, 0, 'false'),
(3090, 18, 0, 'false'),
(3091, 18, 0, 'false'),
(3092, 18, 0, 'false'),
(3093, 18, 0, 'false'),
(3094, 18, 0, 'false'),
(3095, 18, 0, 'false'),
(3096, 18, 0, 'true'),
(3097, 18, 0, 'false'),
(3098, 18, 0, 'false'),
(3099, 18, 0, 'false'),
(3100, 18, 0, 'false'),
(3101, 18, 0, 'false'),
(3102, 18, 0, 'false'),
(3103, 18, 0, 'false'),
(3104, 18, 0, 'false'),
(3105, 18, 0, 'false'),
(3106, 18, 0, 'false'),
(3107, 18, 0, 'false'),
(3108, 18, 0, 'false'),
(3109, 18, 0, 'false'),
(3110, 18, 0, 'false'),
(3111, 18, 0, 'false'),
(3112, 18, 0, 'false'),
(3113, 18, 0, 'false'),
(3114, 18, 0, 'false'),
(3115, 18, 0, 'false'),
(3116, 18, 0, 'false'),
(3117, 18, 0, 'false'),
(3118, 18, 0, 'false'),
(3119, 18, 0, 'false'),
(3120, 18, 0, 'false'),
(3121, 18, 0, 'false'),
(3122, 18, 0, 'false'),
(3123, 18, 0, 'false'),
(3124, 18, 0, 'true'),
(3125, 18, 0, 'false'),
(3126, 18, 0, 'false'),
(3127, 18, 0, 'false'),
(3128, 18, 0, 'false'),
(3129, 18, 0, 'false'),
(3130, 18, 0, 'false'),
(3131, 18, 0, 'false'),
(3132, 18, 0, 'false'),
(3133, 18, 0, 'false'),
(3134, 18, 0, 'false'),
(3135, 18, 0, 'false'),
(3136, 18, 0, 'false'),
(3137, 18, 0, 'false'),
(3138, 18, 0, 'false'),
(3139, 18, 0, 'false'),
(3140, 18, 0, 'false'),
(3141, 18, 0, 'false'),
(3142, 18, 0, 'false'),
(3143, 18, 0, 'false'),
(3144, 18, 0, 'false'),
(3145, 18, 0, 'false'),
(3146, 18, 0, 'false'),
(3147, 18, 0, 'false'),
(3148, 18, 0, 'false'),
(3149, 18, 0, 'false'),
(3150, 18, 0, 'false'),
(3151, 18, 0, 'true'),
(3152, 18, 0, 'false'),
(3153, 18, 0, 'false'),
(3154, 18, 0, 'false'),
(3155, 18, 0, 'false'),
(3156, 18, 0, 'false'),
(3157, 18, 0, 'false'),
(3158, 18, 0, 'false'),
(3159, 18, 0, 'false'),
(3160, 18, 0, 'false'),
(3161, 18, 0, 'false'),
(3162, 18, 0, 'false'),
(3163, 3, 0, 'false'),
(3164, 3, 0, 'false'),
(3165, 3, 0, 'false'),
(3166, 3, 0, 'true'),
(3167, 3, 0, 'false'),
(3168, 3, 0, 'false'),
(3169, 3, 0, 'false'),
(3170, 3, 0, 'false'),
(3171, 3, 0, 'false'),
(3172, 3, 0, 'false'),
(3173, 3, 0, 'false'),
(3174, 3, 0, 'false'),
(3175, 3, 0, 'false'),
(3176, 3, 0, 'false'),
(3177, 3, 0, 'false'),
(3178, 3, 0, 'false'),
(3179, 3, 0, 'false'),
(3180, 3, 0, 'false'),
(3181, 3, 0, 'false'),
(3182, 3, 0, 'false'),
(3183, 3, 0, 'false'),
(3184, 3, 0, 'false'),
(3185, 3, 0, 'false'),
(3186, 3, 0, 'false'),
(3187, 3, 0, 'false'),
(3188, 3, 0, 'false'),
(3189, 3, 0, 'false'),
(3190, 3, 0, 'false'),
(3191, 3, 0, 'false'),
(3192, 3, 0, 'true'),
(3193, 3, 0, 'false'),
(3194, 3, 0, 'false'),
(3195, 3, 0, 'false'),
(3196, 3, 0, 'false'),
(3197, 3, 0, 'false'),
(3198, 3, 0, 'false'),
(3199, 3, 0, 'false'),
(3200, 3, 0, 'false'),
(3201, 3, 0, 'false'),
(3202, 3, 0, 'false'),
(3203, 3, 0, 'false'),
(3204, 3, 0, 'false'),
(3205, 3, 0, 'false'),
(3206, 3, 0, 'false'),
(3207, 3, 0, 'false'),
(3208, 3, 0, 'false'),
(3209, 3, 0, 'false'),
(3210, 3, 0, 'false'),
(3211, 3, 0, 'false'),
(3212, 3, 0, 'false'),
(3213, 3, 0, 'false'),
(3214, 3, 0, 'false'),
(3215, 3, 0, 'false'),
(3216, 3, 0, 'false'),
(3217, 3, 0, 'true'),
(3218, 3, 0, 'false'),
(3219, 3, 0, 'false'),
(3220, 3, 0, 'false'),
(3221, 3, 0, 'false'),
(3222, 3, 0, 'false'),
(3223, 3, 0, 'false'),
(3224, 3, 0, 'false'),
(3225, 3, 0, 'false'),
(3226, 3, 0, 'false'),
(3227, 3, 0, 'false'),
(3228, 3, 0, 'false'),
(3229, 3, 0, 'false'),
(3230, 3, 0, 'false'),
(3231, 3, 0, 'false'),
(3232, 3, 0, 'false'),
(3233, 3, 0, 'false'),
(3234, 3, 0, 'false'),
(3235, 3, 0, 'false'),
(3236, 3, 0, 'false'),
(3237, 3, 0, 'false'),
(3238, 3, 0, 'false'),
(3239, 3, 0, 'false'),
(3240, 3, 0, 'false'),
(3241, 3, 0, 'false'),
(3242, 3, 0, 'true'),
(3243, 3, 0, 'false'),
(3244, 3, 0, 'false'),
(3245, 3, 0, 'false'),
(3246, 3, 0, 'false'),
(3247, 3, 0, 'false'),
(3248, 3, 0, 'false'),
(3249, 3, 0, 'false'),
(3250, 3, 0, 'false'),
(3251, 3, 0, 'false'),
(3252, 3, 0, 'false'),
(3253, 3, 0, 'false'),
(3254, 3, 0, 'false'),
(3255, 3, 0, 'false'),
(3256, 3, 0, 'false'),
(3257, 3, 0, 'false'),
(3258, 3, 0, 'false'),
(3259, 3, 0, 'false'),
(3260, 3, 0, 'false'),
(3261, 3, 0, 'false'),
(3262, 3, 0, 'false'),
(3263, 3, 0, 'false'),
(3264, 3, 0, 'false'),
(3265, 3, 0, 'false'),
(3266, 3, 0, 'false'),
(3267, 3, 0, 'true'),
(3268, 3, 0, 'false'),
(3269, 3, 0, 'false'),
(3270, 3, 0, 'false'),
(3271, 3, 0, 'false'),
(3272, 3, 0, 'false'),
(3273, 3, 0, 'false'),
(3274, 3, 0, 'false'),
(3275, 3, 0, 'false'),
(3276, 3, 0, 'false'),
(3277, 3, 0, 'false'),
(3278, 3, 0, 'false'),
(3279, 3, 0, 'false'),
(3280, 3, 0, 'false'),
(3281, 3, 0, 'false'),
(3282, 3, 0, 'false'),
(3283, 3, 0, 'false'),
(3284, 3, 0, 'false'),
(3285, 3, 0, 'false'),
(3286, 3, 0, 'false'),
(3287, 3, 0, 'false'),
(3288, 3, 0, 'false'),
(3289, 3, 0, 'false'),
(3290, 3, 0, 'false'),
(3291, 3, 0, 'false'),
(3292, 3, 0, 'true'),
(3293, 3, 0, 'false'),
(3294, 3, 0, 'false'),
(3295, 3, 0, 'false'),
(3296, 3, 0, 'false'),
(3297, 3, 0, 'false'),
(3298, 3, 0, 'false'),
(3299, 3, 0, 'false'),
(3300, 3, 0, 'false'),
(3301, 3, 0, 'false'),
(3302, 3, 0, 'false'),
(3303, 3, 0, 'false'),
(3304, 3, 0, 'false'),
(3305, 3, 0, 'false'),
(3306, 3, 0, 'false'),
(3307, 3, 0, 'false'),
(3308, 3, 0, 'false'),
(3309, 3, 0, 'false'),
(3310, 3, 0, 'false'),
(3311, 3, 0, 'false'),
(3312, 3, 0, 'false'),
(3313, 3, 0, 'false'),
(3314, 3, 0, 'false'),
(3315, 3, 0, 'false'),
(3316, 3, 0, 'false'),
(3317, 3, 0, 'true'),
(3318, 3, 0, 'false'),
(3319, 3, 0, 'false'),
(3320, 3, 0, 'false'),
(3321, 3, 0, 'false'),
(3322, 3, 0, 'false'),
(3323, 3, 0, 'false'),
(3324, 3, 0, 'false'),
(3325, 3, 0, 'false'),
(3326, 3, 0, 'false'),
(3327, 3, 0, 'false'),
(3328, 3, 0, 'false'),
(3329, 3, 0, 'false'),
(3330, 3, 0, 'false'),
(3331, 3, 0, 'false'),
(3332, 3, 0, 'false'),
(3333, 3, 0, 'false'),
(3334, 3, 0, 'false'),
(3335, 3, 0, 'false'),
(3336, 3, 0, 'false'),
(3337, 3, 0, 'false'),
(3338, 3, 0, 'false'),
(3339, 3, 0, 'false'),
(3340, 3, 0, 'false'),
(3341, 3, 0, 'false'),
(3342, 3, 0, 'true'),
(3343, 3, 0, 'false'),
(3344, 3, 0, 'false'),
(3345, 3, 0, 'false'),
(3346, 3, 0, 'false'),
(3347, 3, 0, 'false'),
(3348, 3, 0, 'false'),
(3349, 3, 0, 'false'),
(3350, 3, 0, 'false'),
(3351, 3, 0, 'false'),
(3352, 3, 0, 'false'),
(3353, 3, 0, 'false'),
(3354, 3, 0, 'false'),
(3355, 3, 0, 'false'),
(3356, 3, 0, 'false'),
(3357, 3, 0, 'false'),
(3358, 3, 0, 'false'),
(3359, 3, 0, 'false'),
(3360, 3, 0, 'false'),
(3361, 3, 0, 'false'),
(3362, 3, 0, 'false'),
(3363, 3, 0, 'false'),
(3364, 3, 0, 'false'),
(3365, 3, 0, 'false'),
(3366, 3, 0, 'false'),
(3367, 3, 0, 'true'),
(3368, 3, 0, 'false'),
(3369, 3, 0, 'false'),
(3370, 3, 0, 'false'),
(3371, 3, 0, 'false'),
(3372, 3, 0, 'false'),
(3373, 3, 0, 'false'),
(3374, 3, 0, 'false'),
(3375, 3, 0, 'false'),
(3376, 3, 0, 'false'),
(3377, 3, 0, 'false'),
(3378, 3, 0, 'false'),
(3379, 4, 0, 'false'),
(3380, 4, 0, 'false'),
(3381, 4, 0, 'false'),
(3382, 4, 0, 'true'),
(3383, 4, 0, 'false'),
(3384, 4, 0, 'false'),
(3385, 4, 0, 'false'),
(3386, 4, 0, 'false'),
(3387, 4, 0, 'false'),
(3388, 4, 0, 'false'),
(3389, 4, 0, 'false'),
(3390, 4, 0, 'false'),
(3391, 4, 0, 'false'),
(3392, 4, 0, 'false'),
(3393, 4, 0, 'false'),
(3394, 4, 0, 'false'),
(3395, 4, 0, 'false'),
(3396, 4, 0, 'false'),
(3397, 4, 0, 'false'),
(3398, 4, 0, 'false'),
(3399, 4, 0, 'false'),
(3400, 4, 0, 'false'),
(3401, 4, 0, 'false'),
(3402, 4, 0, 'false'),
(3403, 4, 0, 'false'),
(3404, 4, 0, 'false'),
(3405, 4, 0, 'false'),
(3406, 4, 0, 'false'),
(3407, 4, 0, 'false'),
(3408, 4, 0, 'true'),
(3409, 4, 0, 'false'),
(3410, 4, 0, 'false'),
(3411, 4, 0, 'false'),
(3412, 4, 0, 'false'),
(3413, 4, 0, 'false'),
(3414, 4, 0, 'false'),
(3415, 4, 0, 'false'),
(3416, 4, 0, 'false'),
(3417, 4, 0, 'false'),
(3418, 4, 0, 'false'),
(3419, 4, 0, 'false'),
(3420, 4, 0, 'false'),
(3421, 4, 0, 'false'),
(3422, 4, 0, 'false'),
(3423, 4, 0, 'false'),
(3424, 4, 0, 'false'),
(3425, 4, 0, 'false'),
(3426, 4, 0, 'false'),
(3427, 4, 0, 'false'),
(3428, 4, 0, 'false'),
(3429, 4, 0, 'false'),
(3430, 4, 0, 'false'),
(3431, 4, 0, 'false'),
(3432, 4, 0, 'false'),
(3433, 4, 0, 'true'),
(3434, 4, 0, 'false'),
(3435, 4, 0, 'false'),
(3436, 4, 0, 'false'),
(3437, 4, 0, 'false'),
(3438, 4, 0, 'false'),
(3439, 4, 0, 'false'),
(3440, 4, 0, 'false'),
(3441, 4, 0, 'false'),
(3442, 4, 0, 'false'),
(3443, 4, 0, 'false'),
(3444, 4, 0, 'false'),
(3445, 4, 0, 'false'),
(3446, 4, 0, 'false'),
(3447, 4, 0, 'false'),
(3448, 4, 0, 'false'),
(3449, 4, 0, 'false'),
(3450, 4, 0, 'false'),
(3451, 4, 0, 'false'),
(3452, 4, 0, 'false'),
(3453, 4, 0, 'false'),
(3454, 4, 0, 'false'),
(3455, 4, 0, 'false'),
(3456, 4, 0, 'false'),
(3457, 4, 0, 'false'),
(3458, 4, 0, 'true'),
(3459, 4, 0, 'false'),
(3460, 4, 0, 'false'),
(3461, 4, 0, 'false'),
(3462, 4, 0, 'false'),
(3463, 4, 0, 'false'),
(3464, 4, 0, 'false'),
(3465, 4, 0, 'false'),
(3466, 4, 0, 'false'),
(3467, 4, 0, 'false'),
(3468, 4, 0, 'false'),
(3469, 4, 0, 'false'),
(3470, 4, 0, 'false'),
(3471, 4, 0, 'false'),
(3472, 4, 0, 'false'),
(3473, 4, 0, 'false'),
(3474, 4, 0, 'false'),
(3475, 4, 0, 'false'),
(3476, 4, 0, 'false'),
(3477, 4, 0, 'false'),
(3478, 4, 0, 'false'),
(3479, 4, 0, 'false'),
(3480, 4, 0, 'false'),
(3481, 4, 0, 'false'),
(3482, 4, 0, 'false'),
(3483, 4, 0, 'true'),
(3484, 4, 0, 'false'),
(3485, 4, 0, 'false'),
(3486, 4, 0, 'false'),
(3487, 4, 0, 'false'),
(3488, 4, 0, 'false'),
(3489, 4, 0, 'false'),
(3490, 4, 0, 'false'),
(3491, 4, 0, 'false'),
(3492, 4, 0, 'false'),
(3493, 4, 0, 'false'),
(3494, 4, 0, 'false'),
(3495, 4, 0, 'false'),
(3496, 4, 0, 'false'),
(3497, 4, 0, 'false'),
(3498, 4, 0, 'false'),
(3499, 4, 0, 'false'),
(3500, 4, 0, 'false'),
(3501, 4, 0, 'false'),
(3502, 4, 0, 'false'),
(3503, 4, 0, 'false'),
(3504, 4, 0, 'false'),
(3505, 4, 0, 'false'),
(3506, 4, 0, 'false'),
(3507, 4, 0, 'false'),
(3508, 4, 0, 'true'),
(3509, 4, 0, 'false'),
(3510, 4, 0, 'false'),
(3511, 4, 0, 'false'),
(3512, 4, 0, 'false'),
(3513, 4, 0, 'false'),
(3514, 4, 0, 'false'),
(3515, 4, 0, 'false'),
(3516, 4, 0, 'false'),
(3517, 4, 0, 'false'),
(3518, 4, 0, 'false'),
(3519, 4, 0, 'false'),
(3520, 4, 0, 'false'),
(3521, 4, 0, 'false'),
(3522, 4, 0, 'false'),
(3523, 4, 0, 'false'),
(3524, 4, 0, 'false'),
(3525, 4, 0, 'false'),
(3526, 4, 0, 'false'),
(3527, 4, 0, 'false'),
(3528, 4, 0, 'false'),
(3529, 4, 0, 'false'),
(3530, 4, 0, 'false'),
(3531, 4, 0, 'false'),
(3532, 4, 0, 'false'),
(3533, 4, 0, 'true'),
(3534, 4, 0, 'false'),
(3535, 4, 0, 'false'),
(3536, 4, 0, 'false'),
(3537, 4, 0, 'false'),
(3538, 4, 0, 'false'),
(3539, 4, 0, 'false'),
(3540, 4, 0, 'false'),
(3541, 4, 0, 'false'),
(3542, 4, 0, 'false'),
(3543, 4, 0, 'false'),
(3544, 4, 0, 'false'),
(3545, 4, 0, 'false'),
(3546, 4, 0, 'false'),
(3547, 4, 0, 'false'),
(3548, 4, 0, 'false'),
(3549, 4, 0, 'false'),
(3550, 4, 0, 'false'),
(3551, 4, 0, 'false'),
(3552, 4, 0, 'false'),
(3553, 4, 0, 'false'),
(3554, 4, 0, 'false'),
(3555, 4, 0, 'false'),
(3556, 4, 0, 'false'),
(3557, 4, 0, 'false'),
(3558, 4, 0, 'true'),
(3559, 4, 0, 'false'),
(3560, 4, 0, 'false'),
(3561, 4, 0, 'false'),
(3562, 4, 0, 'false'),
(3563, 4, 0, 'false'),
(3564, 4, 0, 'false'),
(3565, 4, 0, 'false'),
(3566, 4, 0, 'false'),
(3567, 4, 0, 'false'),
(3568, 4, 0, 'false'),
(3569, 4, 0, 'false'),
(3570, 4, 0, 'false'),
(3571, 4, 0, 'false'),
(3572, 4, 0, 'false'),
(3573, 4, 0, 'false'),
(3574, 4, 0, 'false'),
(3575, 4, 0, 'false'),
(3576, 4, 0, 'false'),
(3577, 4, 0, 'false'),
(3578, 4, 0, 'false'),
(3579, 4, 0, 'false'),
(3580, 4, 0, 'false'),
(3581, 4, 0, 'false'),
(3582, 4, 0, 'false'),
(3583, 4, 0, 'true'),
(3584, 4, 0, 'false'),
(3585, 4, 0, 'false'),
(3586, 4, 0, 'false'),
(3587, 4, 0, 'false'),
(3588, 4, 0, 'false'),
(3589, 4, 0, 'false'),
(3590, 4, 0, 'false'),
(3591, 4, 0, 'false'),
(3592, 4, 0, 'false'),
(3593, 4, 0, 'false'),
(3594, 4, 0, 'false'),
(3595, 5, 0, 'false'),
(3596, 5, 0, 'false'),
(3597, 5, 0, 'false'),
(3598, 5, 0, 'false'),
(3599, 5, 0, 'false'),
(3600, 5, 0, 'false'),
(3601, 5, 0, 'false'),
(3602, 5, 0, 'false'),
(3603, 5, 0, 'false'),
(3604, 5, 0, 'false'),
(3605, 5, 0, 'true'),
(3606, 5, 0, 'false'),
(3607, 5, 0, 'false'),
(3608, 5, 0, 'false'),
(3609, 5, 0, 'false'),
(3610, 5, 0, 'false'),
(3611, 5, 0, 'false'),
(3612, 5, 0, 'false'),
(3613, 5, 0, 'false'),
(3614, 5, 0, 'false'),
(3615, 5, 0, 'false'),
(3616, 5, 0, 'false'),
(3617, 5, 0, 'false'),
(3618, 5, 0, 'false'),
(3619, 5, 0, 'false'),
(3620, 5, 0, 'false'),
(3621, 5, 0, 'false'),
(3622, 5, 0, 'false'),
(3623, 5, 0, 'false'),
(3624, 5, 0, 'false'),
(3625, 5, 0, 'false'),
(3626, 5, 0, 'false'),
(3627, 5, 0, 'false'),
(3628, 5, 0, 'true'),
(3629, 5, 0, 'false'),
(3630, 5, 0, 'false'),
(3631, 5, 0, 'false'),
(3632, 5, 0, 'false'),
(3633, 5, 0, 'false'),
(3634, 5, 0, 'false'),
(3635, 5, 0, 'false'),
(3636, 5, 0, 'false'),
(3637, 5, 0, 'false'),
(3638, 5, 0, 'false'),
(3639, 5, 0, 'false'),
(3640, 5, 0, 'false'),
(3641, 5, 0, 'false'),
(3642, 5, 0, 'false'),
(3643, 5, 0, 'false'),
(3644, 5, 0, 'false'),
(3645, 5, 0, 'false'),
(3646, 5, 0, 'false'),
(3647, 5, 0, 'false'),
(3648, 5, 0, 'false'),
(3649, 5, 0, 'false'),
(3650, 5, 0, 'true'),
(3651, 5, 0, 'false'),
(3652, 5, 0, 'false'),
(3653, 5, 0, 'false'),
(3654, 5, 0, 'false'),
(3655, 5, 0, 'false'),
(3656, 5, 0, 'false'),
(3657, 5, 0, 'false'),
(3658, 5, 0, 'false'),
(3659, 5, 0, 'false'),
(3660, 5, 0, 'false'),
(3661, 5, 0, 'false'),
(3662, 5, 0, 'false'),
(3663, 5, 0, 'false'),
(3664, 5, 0, 'false'),
(3665, 5, 0, 'false'),
(3666, 5, 0, 'false'),
(3667, 5, 0, 'false'),
(3668, 5, 0, 'false'),
(3669, 5, 0, 'false'),
(3670, 5, 0, 'false'),
(3671, 5, 0, 'false'),
(3672, 5, 0, 'true'),
(3673, 5, 0, 'false'),
(3674, 5, 0, 'false'),
(3675, 5, 0, 'false'),
(3676, 5, 0, 'false'),
(3677, 5, 0, 'false'),
(3678, 5, 0, 'false'),
(3679, 5, 0, 'false'),
(3680, 5, 0, 'false'),
(3681, 5, 0, 'false'),
(3682, 5, 0, 'false'),
(3683, 5, 0, 'false'),
(3684, 5, 0, 'false'),
(3685, 5, 0, 'false'),
(3686, 5, 0, 'false'),
(3687, 5, 0, 'false'),
(3688, 5, 0, 'false'),
(3689, 5, 0, 'false'),
(3690, 5, 0, 'false'),
(3691, 5, 0, 'false'),
(3692, 5, 0, 'false'),
(3693, 5, 0, 'false'),
(3694, 5, 0, 'false'),
(3695, 5, 0, 'false'),
(3696, 5, 0, 'false'),
(3697, 5, 0, 'true'),
(3698, 5, 0, 'false'),
(3699, 5, 0, 'false'),
(3700, 5, 0, 'false'),
(3701, 5, 0, 'false'),
(3702, 5, 0, 'false'),
(3703, 5, 0, 'false'),
(3704, 5, 0, 'false'),
(3705, 5, 0, 'false'),
(3706, 5, 0, 'false'),
(3707, 5, 0, 'false'),
(3708, 5, 0, 'false'),
(3709, 5, 0, 'false'),
(3710, 5, 0, 'false'),
(3711, 5, 0, 'false'),
(3712, 5, 0, 'false'),
(3713, 5, 0, 'false'),
(3714, 5, 0, 'false'),
(3715, 5, 0, 'false'),
(3716, 5, 0, 'false'),
(3717, 5, 0, 'false'),
(3718, 5, 0, 'true'),
(3719, 5, 0, 'false'),
(3720, 5, 0, 'false'),
(3721, 5, 0, 'false'),
(3722, 5, 0, 'false'),
(3723, 5, 0, 'false'),
(3724, 5, 0, 'false'),
(3725, 5, 0, 'false'),
(3726, 5, 0, 'false'),
(3727, 5, 0, 'false'),
(3728, 5, 0, 'false'),
(3729, 5, 0, 'false'),
(3730, 5, 0, 'false'),
(3731, 5, 0, 'false'),
(3732, 5, 0, 'false'),
(3733, 5, 0, 'false'),
(3734, 5, 0, 'false'),
(3735, 5, 0, 'false'),
(3736, 5, 0, 'false'),
(3737, 5, 0, 'false'),
(3738, 5, 0, 'false'),
(3739, 6, 0, 'false'),
(3740, 6, 0, 'false'),
(3741, 6, 0, 'false'),
(3742, 6, 0, 'false'),
(3743, 6, 0, 'false'),
(3744, 6, 0, 'false'),
(3745, 6, 0, 'false'),
(3746, 6, 0, 'false'),
(3747, 6, 0, 'false'),
(3748, 6, 0, 'false'),
(3749, 6, 0, 'true'),
(3750, 6, 0, 'false'),
(3751, 6, 0, 'false'),
(3752, 6, 0, 'false'),
(3753, 6, 0, 'false'),
(3754, 6, 0, 'false'),
(3755, 6, 0, 'false'),
(3756, 6, 0, 'false'),
(3757, 6, 0, 'false'),
(3758, 6, 0, 'false'),
(3759, 6, 0, 'false'),
(3760, 6, 0, 'false'),
(3761, 6, 0, 'false'),
(3762, 6, 0, 'false'),
(3763, 6, 0, 'false'),
(3764, 6, 0, 'false'),
(3765, 6, 0, 'false'),
(3766, 6, 0, 'false'),
(3767, 6, 0, 'false'),
(3768, 6, 0, 'false'),
(3769, 6, 0, 'false'),
(3770, 6, 0, 'false'),
(3771, 6, 0, 'false'),
(3772, 6, 0, 'false'),
(3773, 6, 0, 'false'),
(3774, 6, 0, 'true'),
(3775, 6, 0, 'false'),
(3776, 6, 0, 'false'),
(3777, 6, 0, 'false'),
(3778, 6, 0, 'false'),
(3779, 6, 0, 'false'),
(3780, 6, 0, 'false'),
(3781, 6, 0, 'false'),
(3782, 6, 0, 'false'),
(3783, 6, 0, 'false'),
(3784, 6, 0, 'false'),
(3785, 6, 0, 'false'),
(3786, 6, 0, 'false'),
(3787, 6, 0, 'false'),
(3788, 6, 0, 'false'),
(3789, 6, 0, 'false'),
(3790, 6, 0, 'false'),
(3791, 6, 0, 'false'),
(3792, 6, 0, 'true'),
(3793, 6, 0, 'false'),
(3794, 6, 0, 'false'),
(3795, 6, 0, 'false'),
(3796, 6, 0, 'false'),
(3797, 6, 0, 'false'),
(3798, 6, 0, 'false'),
(3799, 6, 0, 'false'),
(3800, 6, 0, 'false'),
(3801, 6, 0, 'false'),
(3802, 6, 0, 'false'),
(3803, 6, 0, 'false'),
(3804, 6, 0, 'false'),
(3805, 6, 0, 'false'),
(3806, 6, 0, 'false'),
(3807, 6, 0, 'false'),
(3808, 6, 0, 'false'),
(3809, 6, 0, 'false'),
(3810, 6, 0, 'false'),
(3811, 6, 0, 'false'),
(3812, 6, 0, 'false'),
(3813, 6, 0, 'false'),
(3814, 6, 0, 'false'),
(3815, 6, 0, 'false'),
(3816, 6, 0, 'false'),
(3817, 6, 0, 'false'),
(3818, 6, 0, 'false'),
(3819, 6, 0, 'true'),
(3820, 6, 0, 'false'),
(3821, 6, 0, 'false'),
(3822, 6, 0, 'false'),
(3823, 6, 0, 'false'),
(3824, 6, 0, 'false'),
(3825, 6, 0, 'false'),
(3826, 6, 0, 'false'),
(3827, 6, 0, 'false'),
(3828, 6, 0, 'false'),
(3829, 6, 0, 'false'),
(3830, 6, 0, 'false'),
(3831, 6, 0, 'false'),
(3832, 6, 0, 'false'),
(3833, 6, 0, 'false'),
(3834, 6, 0, 'false'),
(3835, 6, 0, 'false'),
(3836, 6, 0, 'false'),
(3837, 6, 0, 'false'),
(3838, 6, 0, 'false'),
(3839, 6, 0, 'false'),
(3840, 6, 0, 'false'),
(3841, 6, 0, 'false'),
(3842, 6, 0, 'false'),
(3843, 6, 0, 'false'),
(3844, 6, 0, 'true'),
(3845, 6, 0, 'false'),
(3846, 6, 0, 'false'),
(3847, 6, 0, 'false'),
(3848, 6, 0, 'false'),
(3849, 6, 0, 'false'),
(3850, 6, 0, 'false'),
(3851, 6, 0, 'false'),
(3852, 6, 0, 'false'),
(3853, 6, 0, 'false'),
(3854, 6, 0, 'false'),
(3855, 6, 0, 'false'),
(3856, 6, 0, 'false'),
(3857, 6, 0, 'false'),
(3858, 6, 0, 'false'),
(3859, 6, 0, 'false'),
(3860, 6, 0, 'false'),
(3861, 6, 0, 'false'),
(3862, 6, 0, 'false'),
(3863, 6, 0, 'false'),
(3864, 6, 0, 'false'),
(3865, 6, 0, 'true'),
(3866, 6, 0, 'false'),
(3867, 6, 0, 'false'),
(3868, 6, 0, 'false'),
(3869, 6, 0, 'false'),
(3870, 6, 0, 'false'),
(3871, 6, 0, 'false'),
(3872, 6, 0, 'false'),
(3873, 6, 0, 'false'),
(3874, 6, 0, 'false'),
(3875, 6, 0, 'false'),
(3876, 6, 0, 'false'),
(3877, 6, 0, 'false'),
(3878, 6, 0, 'false'),
(3879, 6, 0, 'false'),
(3880, 6, 0, 'false'),
(3881, 6, 0, 'false'),
(3882, 6, 0, 'false'),
(3883, 6, 0, 'false'),
(3884, 6, 0, 'false'),
(3885, 6, 0, 'false'),
(3886, 6, 0, 'true'),
(3887, 6, 0, 'false'),
(3888, 6, 0, 'false'),
(3889, 6, 0, 'false'),
(3890, 6, 0, 'false'),
(3891, 6, 0, 'false'),
(3892, 6, 0, 'false'),
(3893, 6, 0, 'false'),
(3894, 6, 0, 'false'),
(3895, 6, 0, 'false'),
(3896, 6, 0, 'false'),
(3897, 6, 0, 'false'),
(3898, 6, 0, 'false'),
(3899, 6, 0, 'false'),
(3900, 6, 0, 'false'),
(3901, 6, 0, 'false'),
(3902, 6, 0, 'false'),
(3903, 6, 0, 'false'),
(3904, 6, 0, 'false'),
(3905, 6, 0, 'false'),
(3906, 6, 0, 'false'),
(3907, 6, 0, 'false'),
(3908, 6, 0, 'false'),
(3909, 6, 0, 'false'),
(3910, 6, 0, 'false'),
(3911, 6, 0, 'false'),
(3912, 6, 0, 'false'),
(3913, 6, 0, 'false'),
(3914, 6, 0, 'false'),
(3915, 6, 0, 'false'),
(3916, 6, 0, 'false'),
(3917, 6, 0, 'false'),
(3918, 6, 0, 'false'),
(3919, 6, 0, 'true'),
(3920, 6, 0, 'false'),
(3921, 6, 0, 'false'),
(3922, 6, 0, 'false'),
(3923, 6, 0, 'false'),
(3924, 6, 0, 'false'),
(3925, 6, 0, 'false'),
(3926, 6, 0, 'false'),
(3927, 6, 0, 'false'),
(3928, 6, 0, 'false'),
(3929, 6, 0, 'false'),
(3930, 6, 0, 'false'),
(3931, 7, 0, 'false'),
(3932, 7, 0, 'false'),
(3933, 7, 0, 'false'),
(3934, 7, 0, 'false'),
(3935, 7, 0, 'false'),
(3936, 7, 0, 'false'),
(3937, 7, 0, 'false'),
(3938, 7, 0, 'false'),
(3939, 7, 0, 'false'),
(3940, 7, 0, 'true'),
(3941, 7, 0, 'false'),
(3942, 7, 0, 'false'),
(3943, 7, 0, 'false'),
(3944, 7, 0, 'false'),
(3945, 7, 0, 'false'),
(3946, 7, 0, 'false'),
(3947, 7, 0, 'false'),
(3948, 7, 0, 'false'),
(3949, 7, 0, 'false'),
(3950, 7, 0, 'false'),
(3951, 7, 0, 'false'),
(3952, 7, 0, 'false'),
(3953, 7, 0, 'false'),
(3954, 7, 0, 'false'),
(3955, 7, 0, 'false'),
(3956, 7, 0, 'false'),
(3957, 7, 0, 'false'),
(3958, 7, 0, 'false'),
(3959, 7, 0, 'false'),
(3960, 7, 0, 'false'),
(3961, 7, 0, 'false'),
(3962, 7, 0, 'false'),
(3963, 7, 0, 'false'),
(3964, 7, 0, 'false'),
(3965, 7, 0, 'true'),
(3966, 7, 0, 'false'),
(3967, 7, 0, 'false'),
(3968, 7, 0, 'false'),
(3969, 7, 0, 'false'),
(3970, 7, 0, 'false'),
(3971, 7, 0, 'false'),
(3972, 7, 0, 'false'),
(3973, 7, 0, 'false'),
(3974, 7, 0, 'false'),
(3975, 7, 0, 'false'),
(3976, 7, 0, 'false'),
(3977, 7, 0, 'false'),
(3978, 7, 0, 'false'),
(3979, 7, 0, 'false'),
(3980, 7, 0, 'false'),
(3981, 7, 0, 'false'),
(3982, 7, 0, 'false'),
(3983, 7, 0, 'false'),
(3984, 7, 0, 'false'),
(3985, 7, 0, 'false'),
(3986, 7, 0, 'false'),
(3987, 7, 0, 'true'),
(3988, 7, 0, 'false'),
(3989, 7, 0, 'false'),
(3990, 7, 0, 'false'),
(3991, 7, 0, 'false'),
(3992, 7, 0, 'false'),
(3993, 7, 0, 'false'),
(3994, 7, 0, 'false'),
(3995, 7, 0, 'false'),
(3996, 7, 0, 'false'),
(3997, 7, 0, 'false'),
(3998, 7, 0, 'false'),
(3999, 7, 0, 'false'),
(4000, 7, 0, 'false'),
(4001, 7, 0, 'false'),
(4002, 7, 0, 'false'),
(4003, 7, 0, 'false'),
(4004, 7, 0, 'false'),
(4005, 7, 0, 'false'),
(4006, 7, 0, 'false'),
(4007, 7, 0, 'false'),
(4008, 7, 0, 'false'),
(4009, 7, 0, 'false'),
(4010, 7, 0, 'true'),
(4011, 7, 0, 'false'),
(4012, 7, 0, 'false'),
(4013, 7, 0, 'false'),
(4014, 7, 0, 'false'),
(4015, 7, 0, 'false'),
(4016, 7, 0, 'false'),
(4017, 7, 0, 'false'),
(4018, 7, 0, 'false'),
(4019, 7, 0, 'false'),
(4020, 7, 0, 'false'),
(4021, 7, 0, 'false'),
(4022, 7, 0, 'false'),
(4023, 7, 0, 'false'),
(4024, 7, 0, 'false'),
(4025, 7, 0, 'false'),
(4026, 7, 0, 'false'),
(4027, 7, 0, 'false'),
(4028, 7, 0, 'false'),
(4029, 7, 0, 'false'),
(4030, 7, 0, 'false'),
(4031, 7, 0, 'false'),
(4032, 7, 0, 'false'),
(4033, 7, 0, 'true'),
(4034, 7, 0, 'false'),
(4035, 7, 0, 'false'),
(4036, 7, 0, 'false'),
(4037, 7, 0, 'false'),
(4038, 7, 0, 'false'),
(4039, 7, 0, 'false'),
(4040, 7, 0, 'false'),
(4041, 7, 0, 'false'),
(4042, 7, 0, 'false'),
(4043, 7, 0, 'false'),
(4044, 7, 0, 'false'),
(4045, 7, 0, 'false'),
(4046, 7, 0, 'false'),
(4047, 7, 0, 'false'),
(4048, 7, 0, 'false'),
(4049, 7, 0, 'false'),
(4050, 7, 0, 'false'),
(4051, 7, 0, 'false'),
(4052, 7, 0, 'false'),
(4053, 7, 0, 'false'),
(4054, 7, 0, 'true'),
(4055, 7, 0, 'false'),
(4056, 7, 0, 'false'),
(4057, 7, 0, 'false'),
(4058, 7, 0, 'false'),
(4059, 7, 0, 'false'),
(4060, 7, 0, 'false'),
(4061, 7, 0, 'false'),
(4062, 7, 0, 'false'),
(4063, 7, 0, 'false'),
(4064, 7, 0, 'false'),
(4065, 7, 0, 'false'),
(4066, 7, 0, 'false'),
(4067, 7, 0, 'false'),
(4068, 7, 0, 'false'),
(4069, 7, 0, 'false'),
(4070, 7, 0, 'false'),
(4071, 7, 0, 'false'),
(4072, 7, 0, 'false'),
(4073, 7, 0, 'false'),
(4074, 7, 0, 'false'),
(4075, 7, 0, 'false'),
(4076, 7, 0, 'false'),
(4077, 7, 0, 'false'),
(4078, 7, 0, 'false'),
(4079, 7, 0, 'false'),
(4080, 7, 0, 'false'),
(4081, 7, 0, 'false'),
(4082, 7, 0, 'false'),
(4083, 7, 0, 'false'),
(4084, 7, 0, 'false'),
(4085, 7, 0, 'false'),
(4086, 7, 0, 'false'),
(4087, 7, 0, 'true'),
(4088, 7, 0, 'false'),
(4089, 7, 0, 'false'),
(4090, 7, 0, 'false'),
(4091, 7, 0, 'false'),
(4092, 7, 0, 'false'),
(4093, 7, 0, 'false'),
(4094, 7, 0, 'false'),
(4095, 7, 0, 'false'),
(4096, 7, 0, 'false'),
(4097, 7, 0, 'false'),
(4098, 7, 0, 'false'),
(4099, 7, 0, 'false'),
(4100, 7, 0, 'false'),
(4101, 7, 0, 'false'),
(4102, 7, 0, 'false'),
(4103, 7, 0, 'false'),
(4104, 7, 0, 'true'),
(4105, 7, 0, 'false'),
(4106, 7, 0, 'false'),
(4107, 7, 0, 'false'),
(4108, 7, 0, 'false'),
(4109, 7, 0, 'false'),
(4110, 7, 0, 'false'),
(4111, 7, 0, 'false'),
(4112, 7, 0, 'false'),
(4113, 7, 0, 'false'),
(4114, 7, 0, 'false'),
(4115, 7, 0, 'false'),
(4116, 7, 0, 'false'),
(4117, 7, 0, 'false'),
(4118, 7, 0, 'false'),
(4119, 7, 0, 'false'),
(4120, 7, 0, 'false'),
(4121, 7, 0, 'false'),
(4122, 7, 0, 'false'),
(4123, 7, 0, 'false'),
(4124, 7, 0, 'false'),
(4125, 7, 0, 'false'),
(4126, 7, 0, 'false'),
(4127, 7, 0, 'false'),
(4128, 7, 0, 'false'),
(4129, 7, 0, 'false'),
(4130, 7, 0, 'false'),
(4131, 7, 0, 'false'),
(4132, 7, 0, 'false'),
(4133, 7, 0, 'false'),
(4134, 7, 0, 'true'),
(4135, 7, 0, 'false'),
(4136, 7, 0, 'false'),
(4137, 7, 0, 'false'),
(4138, 7, 0, 'false'),
(4139, 7, 0, 'false'),
(4140, 7, 0, 'false'),
(4141, 7, 0, 'false'),
(4142, 7, 0, 'false'),
(4143, 7, 0, 'false'),
(4144, 7, 0, 'false'),
(4145, 7, 0, 'false'),
(4146, 7, 0, 'false'),
(4147, 8, 0, 'false'),
(4148, 8, 0, 'false'),
(4149, 8, 0, 'false'),
(4150, 8, 0, 'false'),
(4151, 8, 0, 'false'),
(4152, 8, 0, 'false'),
(4153, 8, 0, 'false'),
(4154, 8, 0, 'false'),
(4155, 8, 0, 'false'),
(4156, 8, 0, 'false'),
(4157, 8, 0, 'false'),
(4158, 8, 0, 'false'),
(4159, 8, 0, 'true'),
(4160, 8, 0, 'false'),
(4161, 8, 0, 'false'),
(4162, 8, 0, 'false'),
(4163, 8, 0, 'false'),
(4164, 8, 0, 'false'),
(4165, 8, 0, 'false'),
(4166, 8, 0, 'false'),
(4167, 8, 0, 'false'),
(4168, 8, 0, 'false'),
(4169, 8, 0, 'false'),
(4170, 8, 0, 'false'),
(4171, 8, 0, 'false'),
(4172, 8, 0, 'false'),
(4173, 8, 0, 'false'),
(4174, 8, 0, 'true'),
(4175, 8, 0, 'false'),
(4176, 8, 0, 'false'),
(4177, 8, 0, 'false'),
(4178, 8, 0, 'false'),
(4179, 8, 0, 'false'),
(4180, 8, 0, 'false'),
(4181, 8, 0, 'false'),
(4182, 8, 0, 'false'),
(4183, 8, 0, 'false'),
(4184, 8, 0, 'false'),
(4185, 8, 0, 'false'),
(4186, 8, 0, 'false'),
(4187, 8, 0, 'false'),
(4188, 8, 0, 'false'),
(4189, 8, 0, 'false'),
(4190, 8, 0, 'false'),
(4191, 8, 0, 'false'),
(4192, 8, 0, 'false'),
(4193, 8, 0, 'false'),
(4194, 8, 0, 'false'),
(4195, 8, 0, 'false'),
(4196, 8, 0, 'false'),
(4197, 8, 0, 'false'),
(4198, 8, 0, 'false'),
(4199, 8, 0, 'false'),
(4200, 8, 0, 'false'),
(4201, 8, 0, 'false'),
(4202, 8, 0, 'false'),
(4203, 8, 0, 'false'),
(4204, 8, 0, 'false'),
(4205, 8, 0, 'false'),
(4206, 8, 0, 'true'),
(4207, 8, 0, 'false'),
(4208, 8, 0, 'false'),
(4209, 8, 0, 'false'),
(4210, 8, 0, 'false'),
(4211, 8, 0, 'false'),
(4212, 8, 0, 'false'),
(4213, 8, 0, 'false'),
(4214, 8, 0, 'false'),
(4215, 8, 0, 'false'),
(4216, 8, 0, 'false'),
(4217, 8, 0, 'false'),
(4218, 8, 0, 'false'),
(4219, 8, 0, 'false'),
(4220, 8, 0, 'false'),
(4221, 8, 0, 'false'),
(4222, 8, 0, 'false'),
(4223, 8, 0, 'false'),
(4224, 8, 0, 'true'),
(4225, 8, 0, 'false'),
(4226, 8, 0, 'false'),
(4227, 8, 0, 'false'),
(4228, 8, 0, 'false'),
(4229, 8, 0, 'false'),
(4230, 8, 0, 'false'),
(4231, 8, 0, 'false'),
(4232, 8, 0, 'false'),
(4233, 8, 0, 'false'),
(4234, 8, 0, 'false'),
(4235, 8, 0, 'false'),
(4236, 8, 0, 'false'),
(4237, 8, 0, 'false'),
(4238, 8, 0, 'false'),
(4239, 8, 0, 'false'),
(4240, 8, 0, 'false'),
(4241, 8, 0, 'false'),
(4242, 8, 0, 'false'),
(4243, 8, 0, 'false'),
(4244, 8, 0, 'false'),
(4245, 8, 0, 'false'),
(4246, 8, 0, 'false'),
(4247, 8, 0, 'false'),
(4248, 8, 0, 'false'),
(4249, 8, 0, 'false'),
(4250, 8, 0, 'false'),
(4251, 8, 0, 'true'),
(4252, 8, 0, 'false'),
(4253, 8, 0, 'false'),
(4254, 8, 0, 'false'),
(4255, 8, 0, 'false'),
(4256, 8, 0, 'false'),
(4257, 8, 0, 'false'),
(4258, 8, 0, 'false'),
(4259, 8, 0, 'false'),
(4260, 8, 0, 'false'),
(4261, 8, 0, 'false'),
(4262, 8, 0, 'false'),
(4263, 8, 0, 'false'),
(4264, 8, 0, 'false'),
(4265, 8, 0, 'false'),
(4266, 8, 0, 'false'),
(4267, 8, 0, 'false'),
(4268, 8, 0, 'false'),
(4269, 8, 0, 'false'),
(4270, 8, 0, 'false'),
(4271, 8, 0, 'false'),
(4272, 8, 0, 'false'),
(4273, 8, 0, 'true'),
(4274, 8, 0, 'false'),
(4275, 8, 0, 'false'),
(4276, 8, 0, 'false'),
(4277, 8, 0, 'false'),
(4278, 8, 0, 'false'),
(4279, 8, 0, 'false'),
(4280, 8, 0, 'false'),
(4281, 8, 0, 'false'),
(4282, 8, 0, 'false'),
(4283, 8, 0, 'false'),
(4284, 8, 0, 'false'),
(4285, 8, 0, 'false'),
(4286, 8, 0, 'false'),
(4287, 8, 0, 'false'),
(4288, 8, 0, 'false'),
(4289, 8, 0, 'false'),
(4290, 8, 0, 'false'),
(4291, 8, 0, 'false'),
(4292, 8, 0, 'false'),
(4293, 8, 0, 'false'),
(4294, 8, 0, 'false'),
(4295, 8, 0, 'false'),
(4296, 8, 0, 'false'),
(4297, 8, 0, 'false'),
(4298, 8, 0, 'false'),
(4299, 8, 0, 'false'),
(4300, 8, 0, 'false'),
(4301, 8, 0, 'true'),
(4302, 8, 0, 'false'),
(4303, 8, 0, 'false'),
(4304, 8, 0, 'false'),
(4305, 8, 0, 'false'),
(4306, 8, 0, 'false'),
(4307, 8, 0, 'false'),
(4308, 8, 0, 'false'),
(4309, 8, 0, 'false'),
(4310, 8, 0, 'false'),
(4311, 8, 0, 'false'),
(4312, 8, 0, 'false'),
(4313, 8, 0, 'false'),
(4314, 8, 0, 'false'),
(4315, 8, 0, 'false'),
(4316, 8, 0, 'false'),
(4317, 8, 0, 'false'),
(4318, 8, 0, 'false'),
(4319, 8, 0, 'false'),
(4320, 8, 0, 'false'),
(4321, 8, 0, 'false'),
(4322, 8, 0, 'false'),
(4323, 8, 0, 'false'),
(4324, 8, 0, 'true'),
(4325, 8, 0, 'false'),
(4326, 8, 0, 'false'),
(4327, 8, 0, 'false'),
(4328, 8, 0, 'false'),
(4329, 8, 0, 'false'),
(4330, 8, 0, 'false'),
(4331, 8, 0, 'false'),
(4332, 8, 0, 'false'),
(4333, 8, 0, 'false'),
(4334, 8, 0, 'false'),
(4335, 8, 0, 'false'),
(4336, 8, 0, 'false'),
(4337, 8, 0, 'false'),
(4338, 8, 0, 'false'),
(4339, 9, 0, 'false'),
(4340, 9, 0, 'false'),
(4341, 9, 0, 'false'),
(4342, 9, 0, 'false'),
(4343, 9, 0, 'false'),
(4344, 9, 0, 'false'),
(4345, 9, 0, 'false'),
(4346, 9, 0, 'false'),
(4347, 9, 0, 'false'),
(4348, 9, 0, 'true'),
(4349, 9, 0, 'false'),
(4350, 9, 0, 'false'),
(4351, 9, 0, 'false'),
(4352, 9, 0, 'false'),
(4353, 9, 0, 'false'),
(4354, 9, 0, 'false'),
(4355, 9, 0, 'false'),
(4356, 9, 0, 'false'),
(4357, 9, 0, 'false'),
(4358, 9, 0, 'false'),
(4359, 9, 0, 'false'),
(4360, 9, 0, 'false'),
(4361, 9, 0, 'false'),
(4362, 9, 0, 'false'),
(4363, 9, 0, 'false'),
(4364, 9, 0, 'false'),
(4365, 9, 0, 'false'),
(4366, 9, 0, 'false'),
(4367, 9, 0, 'false'),
(4368, 9, 0, 'false'),
(4369, 9, 0, 'false'),
(4370, 9, 0, 'false'),
(4371, 9, 0, 'true'),
(4372, 9, 0, 'false'),
(4373, 9, 0, 'false'),
(4374, 9, 0, 'false'),
(4375, 9, 0, 'false'),
(4376, 9, 0, 'false'),
(4377, 9, 0, 'false'),
(4378, 9, 0, 'false'),
(4379, 9, 0, 'false'),
(4380, 9, 0, 'false'),
(4381, 9, 0, 'false'),
(4382, 9, 0, 'false'),
(4383, 9, 0, 'false'),
(4384, 9, 0, 'false'),
(4385, 9, 0, 'false'),
(4386, 9, 0, 'false'),
(4387, 9, 0, 'false'),
(4388, 9, 0, 'false'),
(4389, 9, 0, 'false'),
(4390, 9, 0, 'false'),
(4391, 9, 0, 'false'),
(4392, 9, 0, 'false'),
(4393, 9, 0, 'false'),
(4394, 9, 0, 'true'),
(4395, 9, 0, 'false'),
(4396, 9, 0, 'false'),
(4397, 9, 0, 'false'),
(4398, 9, 0, 'false'),
(4399, 9, 0, 'false'),
(4400, 9, 0, 'false'),
(4401, 9, 0, 'false'),
(4402, 9, 0, 'false'),
(4403, 9, 0, 'false'),
(4404, 9, 0, 'false'),
(4405, 9, 0, 'false'),
(4406, 9, 0, 'false'),
(4407, 9, 0, 'false'),
(4408, 9, 0, 'false'),
(4409, 9, 0, 'false'),
(4410, 9, 0, 'false'),
(4411, 9, 0, 'false'),
(4412, 9, 0, 'false'),
(4413, 9, 0, 'false'),
(4414, 9, 0, 'false'),
(4415, 9, 0, 'false'),
(4416, 9, 0, 'false'),
(4417, 9, 0, 'true'),
(4418, 9, 0, 'false'),
(4419, 9, 0, 'false'),
(4420, 9, 0, 'false'),
(4421, 9, 0, 'false'),
(4422, 9, 0, 'false'),
(4423, 9, 0, 'false'),
(4424, 9, 0, 'false'),
(4425, 9, 0, 'false'),
(4426, 9, 0, 'false'),
(4427, 9, 0, 'false'),
(4428, 9, 0, 'false'),
(4429, 9, 0, 'false'),
(4430, 9, 0, 'false'),
(4431, 9, 0, 'false'),
(4432, 9, 0, 'false'),
(4433, 9, 0, 'false'),
(4434, 9, 0, 'false'),
(4435, 9, 0, 'false'),
(4436, 9, 0, 'false'),
(4437, 9, 0, 'false'),
(4438, 9, 0, 'true'),
(4439, 9, 0, 'false'),
(4440, 9, 0, 'false'),
(4441, 9, 0, 'false'),
(4442, 9, 0, 'false'),
(4443, 9, 0, 'false'),
(4444, 9, 0, 'false'),
(4445, 9, 0, 'false'),
(4446, 9, 0, 'false'),
(4447, 9, 0, 'false'),
(4448, 9, 0, 'false'),
(4449, 9, 0, 'false'),
(4450, 9, 0, 'false'),
(4451, 9, 0, 'false'),
(4452, 9, 0, 'false'),
(4453, 9, 0, 'false'),
(4454, 9, 0, 'false'),
(4455, 9, 0, 'false'),
(4456, 9, 0, 'false'),
(4457, 9, 0, 'false'),
(4458, 9, 0, 'false'),
(4459, 9, 0, 'false'),
(4460, 9, 0, 'false'),
(4461, 9, 0, 'false'),
(4462, 9, 0, 'false'),
(4463, 9, 0, 'false'),
(4464, 9, 0, 'true'),
(4465, 9, 0, 'false'),
(4466, 9, 0, 'false'),
(4467, 9, 0, 'false'),
(4468, 9, 0, 'false'),
(4469, 9, 0, 'false'),
(4470, 9, 0, 'false'),
(4471, 9, 0, 'false'),
(4472, 9, 0, 'false'),
(4473, 9, 0, 'false'),
(4474, 9, 0, 'false'),
(4475, 9, 0, 'false'),
(4476, 9, 0, 'false'),
(4477, 9, 0, 'false'),
(4478, 9, 0, 'false'),
(4479, 9, 0, 'false'),
(4480, 9, 0, 'false'),
(4481, 9, 0, 'false'),
(4482, 9, 0, 'false'),
(4483, 9, 0, 'false'),
(4484, 9, 0, 'false'),
(4485, 9, 0, 'false'),
(4486, 9, 0, 'false'),
(4487, 9, 0, 'false'),
(4488, 9, 0, 'false'),
(4489, 9, 0, 'false'),
(4490, 9, 0, 'false'),
(4491, 9, 0, 'false'),
(4492, 9, 0, 'false'),
(4493, 9, 0, 'false'),
(4494, 9, 0, 'false'),
(4495, 9, 0, 'true'),
(4496, 9, 0, 'false'),
(4497, 9, 0, 'false'),
(4498, 9, 0, 'false'),
(4499, 9, 0, 'false'),
(4500, 9, 0, 'false'),
(4501, 9, 0, 'false'),
(4502, 9, 0, 'false'),
(4503, 9, 0, 'false'),
(4504, 9, 0, 'false'),
(4505, 9, 0, 'false'),
(4506, 9, 0, 'false'),
(4507, 10, 0, 'false'),
(4508, 10, 0, 'false'),
(4509, 10, 0, 'false'),
(4510, 10, 0, 'false'),
(4511, 10, 0, 'false'),
(4512, 10, 0, 'false'),
(4513, 10, 0, 'false'),
(4514, 10, 0, 'false'),
(4515, 10, 0, 'false'),
(4516, 10, 0, 'false'),
(4517, 10, 0, 'true'),
(4518, 10, 0, 'false'),
(4519, 10, 0, 'false'),
(4520, 10, 0, 'false'),
(4521, 10, 0, 'false'),
(4522, 10, 0, 'false'),
(4523, 10, 0, 'false'),
(4524, 10, 0, 'false'),
(4525, 10, 0, 'false'),
(4526, 10, 0, 'false'),
(4527, 10, 0, 'false'),
(4528, 10, 0, 'false'),
(4529, 10, 0, 'false'),
(4530, 10, 0, 'false'),
(4531, 10, 0, 'false'),
(4532, 10, 0, 'false'),
(4533, 10, 0, 'false'),
(4534, 10, 0, 'false'),
(4535, 10, 0, 'false'),
(4536, 10, 0, 'false'),
(4537, 10, 0, 'false'),
(4538, 10, 0, 'false'),
(4539, 10, 0, 'false'),
(4540, 10, 0, 'true'),
(4541, 10, 0, 'false'),
(4542, 10, 0, 'false'),
(4543, 10, 0, 'false'),
(4544, 10, 0, 'false'),
(4545, 10, 0, 'false'),
(4546, 10, 0, 'false'),
(4547, 10, 0, 'false'),
(4548, 10, 0, 'false'),
(4549, 10, 0, 'false'),
(4550, 10, 0, 'false'),
(4551, 10, 0, 'false'),
(4552, 10, 0, 'false'),
(4553, 10, 0, 'false'),
(4554, 10, 0, 'false'),
(4555, 10, 0, 'false'),
(4556, 10, 0, 'false'),
(4557, 10, 0, 'false'),
(4558, 10, 0, 'false'),
(4559, 10, 0, 'false'),
(4560, 10, 0, 'false'),
(4561, 10, 0, 'false'),
(4562, 10, 0, 'true'),
(4563, 10, 0, 'false'),
(4564, 10, 0, 'false'),
(4565, 10, 0, 'false'),
(4566, 10, 0, 'false'),
(4567, 10, 0, 'false'),
(4568, 10, 0, 'false'),
(4569, 10, 0, 'false'),
(4570, 10, 0, 'false'),
(4571, 10, 0, 'false'),
(4572, 10, 0, 'false'),
(4573, 10, 0, 'false'),
(4574, 10, 0, 'false'),
(4575, 10, 0, 'false'),
(4576, 10, 0, 'false'),
(4577, 10, 0, 'false'),
(4578, 10, 0, 'false'),
(4579, 10, 0, 'false'),
(4580, 10, 0, 'false'),
(4581, 10, 0, 'false'),
(4582, 10, 0, 'false'),
(4583, 10, 0, 'false'),
(4584, 10, 0, 'false'),
(4585, 10, 0, 'false'),
(4586, 10, 0, 'false'),
(4587, 10, 0, 'true'),
(4588, 10, 0, 'false'),
(4589, 10, 0, 'false'),
(4590, 10, 0, 'false'),
(4591, 10, 0, 'false'),
(4592, 10, 0, 'false'),
(4593, 10, 0, 'false'),
(4594, 10, 0, 'false'),
(4595, 10, 0, 'false'),
(4596, 10, 0, 'false'),
(4597, 10, 0, 'false'),
(4598, 10, 0, 'false'),
(4599, 10, 0, 'false'),
(4600, 10, 0, 'false'),
(4601, 10, 0, 'false'),
(4602, 10, 0, 'false'),
(4603, 10, 0, 'false'),
(4604, 10, 0, 'false'),
(4605, 10, 0, 'false'),
(4606, 10, 0, 'false'),
(4607, 10, 0, 'false'),
(4608, 10, 0, 'false'),
(4609, 10, 0, 'true'),
(4610, 10, 0, 'false'),
(4611, 10, 0, 'false'),
(4612, 10, 0, 'false'),
(4613, 10, 0, 'false'),
(4614, 10, 0, 'false'),
(4615, 10, 0, 'false'),
(4616, 10, 0, 'false'),
(4617, 10, 0, 'false'),
(4618, 10, 0, 'false'),
(4619, 10, 0, 'false'),
(4620, 10, 0, 'false'),
(4621, 10, 0, 'false'),
(4622, 10, 0, 'false'),
(4623, 10, 0, 'false'),
(4624, 10, 0, 'false'),
(4625, 10, 0, 'false'),
(4626, 10, 0, 'false'),
(4627, 10, 0, 'false'),
(4628, 10, 0, 'false'),
(4629, 10, 0, 'false'),
(4630, 10, 0, 'true'),
(4631, 10, 0, 'false'),
(4632, 10, 0, 'false'),
(4633, 10, 0, 'false'),
(4634, 10, 0, 'false'),
(4635, 10, 0, 'false'),
(4636, 10, 0, 'false'),
(4637, 10, 0, 'false'),
(4638, 10, 0, 'false'),
(4639, 10, 0, 'false'),
(4640, 10, 0, 'false'),
(4641, 10, 0, 'false'),
(4642, 10, 0, 'false'),
(4643, 10, 0, 'false'),
(4644, 10, 0, 'false'),
(4645, 10, 0, 'false'),
(4646, 10, 0, 'false'),
(4647, 10, 0, 'false'),
(4648, 10, 0, 'false'),
(4649, 10, 0, 'false'),
(4650, 10, 0, 'false'),
(4651, 10, 0, 'false'),
(4652, 10, 0, 'false'),
(4653, 10, 0, 'false'),
(4654, 10, 0, 'false'),
(4655, 10, 0, 'false'),
(4656, 10, 0, 'true'),
(4657, 10, 0, 'false'),
(4658, 10, 0, 'false'),
(4659, 10, 0, 'false'),
(4660, 10, 0, 'false'),
(4661, 10, 0, 'false'),
(4662, 10, 0, 'false'),
(4663, 10, 0, 'false'),
(4664, 10, 0, 'false'),
(4665, 10, 0, 'false'),
(4666, 10, 0, 'false'),
(4667, 10, 0, 'false'),
(4668, 10, 0, 'false'),
(4669, 10, 0, 'false'),
(4670, 10, 0, 'false'),
(4671, 10, 0, 'false'),
(4672, 10, 0, 'false'),
(4673, 10, 0, 'false'),
(4674, 10, 0, 'false'),
(4675, 10, 0, 'false'),
(4676, 10, 0, 'false'),
(4677, 10, 0, 'false'),
(4678, 10, 0, 'false'),
(4679, 10, 0, 'false'),
(4680, 10, 0, 'false'),
(4681, 10, 0, 'false'),
(4682, 10, 0, 'false'),
(4683, 10, 0, 'false'),
(4684, 10, 0, 'false'),
(4685, 10, 0, 'false'),
(4686, 10, 0, 'true'),
(4687, 10, 0, 'false'),
(4688, 10, 0, 'false'),
(4689, 10, 0, 'false'),
(4690, 10, 0, 'false'),
(4691, 10, 0, 'false'),
(4692, 10, 0, 'false'),
(4693, 10, 0, 'false'),
(4694, 10, 0, 'false'),
(4695, 10, 0, 'false'),
(4696, 10, 0, 'false'),
(4697, 10, 0, 'false'),
(4698, 10, 0, 'false'),
(4699, 10, 0, 'false'),
(4700, 10, 0, 'false'),
(4701, 10, 0, 'false'),
(4702, 10, 0, 'false'),
(4703, 10, 0, 'false'),
(4704, 10, 0, 'false'),
(4705, 10, 0, 'false'),
(4706, 10, 0, 'false'),
(4707, 10, 0, 'false'),
(4708, 10, 0, 'false'),
(4709, 10, 0, 'false'),
(4710, 10, 0, 'false'),
(4711, 10, 0, 'true'),
(4712, 10, 0, 'false'),
(4713, 10, 0, 'false'),
(4714, 10, 0, 'false'),
(4715, 10, 0, 'false'),
(4716, 10, 0, 'false'),
(4717, 10, 0, 'false'),
(4718, 10, 0, 'false'),
(4719, 10, 0, 'false'),
(4720, 10, 0, 'false'),
(4721, 10, 0, 'false'),
(4722, 10, 0, 'false'),
(4723, 11, 0, 'false'),
(4724, 11, 0, 'false'),
(4725, 11, 0, 'false'),
(4726, 11, 0, 'false'),
(4727, 11, 0, 'false'),
(4728, 11, 0, 'false'),
(4729, 11, 0, 'false'),
(4730, 11, 0, 'false'),
(4731, 11, 0, 'false'),
(4732, 11, 0, 'false'),
(4733, 11, 0, 'false'),
(4734, 11, 0, 'true'),
(4735, 11, 0, 'false'),
(4736, 11, 0, 'false'),
(4737, 11, 0, 'false'),
(4738, 11, 0, 'false'),
(4739, 11, 0, 'false'),
(4740, 11, 0, 'false'),
(4741, 11, 0, 'false'),
(4742, 11, 0, 'false'),
(4743, 11, 0, 'false'),
(4744, 11, 0, 'false'),
(4745, 11, 0, 'false'),
(4746, 11, 0, 'false'),
(4747, 11, 0, 'false'),
(4748, 11, 0, 'false'),
(4749, 11, 0, 'false'),
(4750, 11, 0, 'false'),
(4751, 11, 0, 'false'),
(4752, 11, 0, 'false'),
(4753, 11, 0, 'false'),
(4754, 11, 0, 'false'),
(4755, 11, 0, 'false'),
(4756, 11, 0, 'false'),
(4757, 11, 0, 'false'),
(4758, 11, 0, 'false'),
(4759, 11, 0, 'true'),
(4760, 11, 0, 'false'),
(4761, 11, 0, 'false'),
(4762, 11, 0, 'false'),
(4763, 11, 0, 'false'),
(4764, 11, 0, 'false'),
(4765, 11, 0, 'false'),
(4766, 11, 0, 'false'),
(4767, 11, 0, 'false'),
(4768, 11, 0, 'false'),
(4769, 11, 0, 'false'),
(4770, 11, 0, 'false'),
(4771, 11, 0, 'false'),
(4772, 11, 0, 'false'),
(4773, 11, 0, 'false'),
(4774, 11, 0, 'true'),
(4775, 11, 0, 'false'),
(4776, 11, 0, 'false'),
(4777, 11, 0, 'false'),
(4778, 11, 0, 'false'),
(4779, 11, 0, 'false');
INSERT INTO `i_ext_et_invoice_terms` (`iexteintm_id`, `iexteintm_inid`, `iexteintm_term_id`, `iexteintm_status`) VALUES
(4780, 11, 0, 'false'),
(4781, 11, 0, 'false'),
(4782, 11, 0, 'false'),
(4783, 11, 0, 'false'),
(4784, 11, 0, 'false'),
(4785, 11, 0, 'false'),
(4786, 11, 0, 'false'),
(4787, 11, 0, 'false'),
(4788, 11, 0, 'false'),
(4789, 11, 0, 'false'),
(4790, 11, 0, 'false'),
(4791, 11, 0, 'false'),
(4792, 11, 0, 'false'),
(4793, 11, 0, 'false'),
(4794, 11, 0, 'false'),
(4795, 11, 0, 'false'),
(4796, 11, 0, 'false'),
(4797, 11, 0, 'false'),
(4798, 11, 0, 'false'),
(4799, 11, 0, 'false'),
(4800, 11, 0, 'true'),
(4801, 11, 0, 'false'),
(4802, 11, 0, 'false'),
(4803, 11, 0, 'false'),
(4804, 11, 0, 'false'),
(4805, 11, 0, 'false'),
(4806, 11, 0, 'false'),
(4807, 11, 0, 'false'),
(4808, 11, 0, 'false'),
(4809, 11, 0, 'false'),
(4810, 11, 0, 'false'),
(4811, 11, 0, 'false'),
(4812, 11, 0, 'false'),
(4813, 11, 0, 'false'),
(4814, 11, 0, 'false'),
(4815, 11, 0, 'false'),
(4816, 11, 0, 'false'),
(4817, 11, 0, 'false'),
(4818, 11, 0, 'false'),
(4819, 11, 0, 'false'),
(4820, 11, 0, 'false'),
(4821, 11, 0, 'false'),
(4822, 11, 0, 'false'),
(4823, 11, 0, 'false'),
(4824, 11, 0, 'false'),
(4825, 11, 0, 'true'),
(4826, 11, 0, 'false'),
(4827, 11, 0, 'false'),
(4828, 11, 0, 'false'),
(4829, 11, 0, 'false'),
(4830, 11, 0, 'false'),
(4831, 11, 0, 'false'),
(4832, 11, 0, 'false'),
(4833, 11, 0, 'false'),
(4834, 11, 0, 'false'),
(4835, 11, 0, 'false'),
(4836, 11, 0, 'false'),
(4837, 11, 0, 'false'),
(4838, 11, 0, 'false'),
(4839, 11, 0, 'false'),
(4840, 11, 0, 'false'),
(4841, 11, 0, 'false'),
(4842, 11, 0, 'false'),
(4843, 11, 0, 'false'),
(4844, 11, 0, 'false'),
(4845, 11, 0, 'false'),
(4846, 11, 0, 'false'),
(4847, 11, 0, 'false'),
(4848, 11, 0, 'false'),
(4849, 11, 0, 'false'),
(4850, 11, 0, 'true'),
(4851, 11, 0, 'false'),
(4852, 11, 0, 'false'),
(4853, 11, 0, 'false'),
(4854, 11, 0, 'false'),
(4855, 11, 0, 'false'),
(4856, 11, 0, 'false'),
(4857, 11, 0, 'false'),
(4858, 11, 0, 'false'),
(4859, 11, 0, 'false'),
(4860, 11, 0, 'false'),
(4861, 11, 0, 'false'),
(4862, 11, 0, 'false'),
(4863, 11, 0, 'false'),
(4864, 11, 0, 'false'),
(4865, 11, 0, 'false'),
(4866, 11, 0, 'false'),
(4867, 11, 0, 'false'),
(4868, 11, 0, 'false'),
(4869, 11, 0, 'false'),
(4870, 11, 0, 'false'),
(4871, 11, 0, 'false'),
(4872, 11, 0, 'false'),
(4873, 11, 0, 'false'),
(4874, 11, 0, 'false'),
(4875, 11, 0, 'true'),
(4876, 11, 0, 'false'),
(4877, 11, 0, 'false'),
(4878, 11, 0, 'false'),
(4879, 11, 0, 'false'),
(4880, 11, 0, 'false'),
(4881, 11, 0, 'false'),
(4882, 11, 0, 'false'),
(4883, 11, 0, 'false'),
(4884, 11, 0, 'false'),
(4885, 11, 0, 'false'),
(4886, 11, 0, 'false'),
(4887, 11, 0, 'false'),
(4888, 11, 0, 'false'),
(4889, 11, 0, 'false'),
(4890, 11, 0, 'false'),
(4891, 11, 0, 'false'),
(4892, 11, 0, 'false'),
(4893, 11, 0, 'false'),
(4894, 11, 0, 'false'),
(4895, 11, 0, 'false'),
(4896, 11, 0, 'false'),
(4897, 11, 0, 'false'),
(4898, 11, 0, 'false'),
(4899, 11, 0, 'false'),
(4900, 11, 0, 'true'),
(4901, 11, 0, 'false'),
(4902, 11, 0, 'false'),
(4903, 11, 0, 'false'),
(4904, 11, 0, 'false'),
(4905, 11, 0, 'false'),
(4906, 11, 0, 'false'),
(4907, 11, 0, 'false'),
(4908, 11, 0, 'false'),
(4909, 11, 0, 'false'),
(4910, 11, 0, 'false'),
(4911, 11, 0, 'false'),
(4912, 11, 0, 'false'),
(4913, 11, 0, 'false'),
(4914, 11, 0, 'false'),
(4915, 11, 0, 'false'),
(4916, 11, 0, 'false'),
(4917, 11, 0, 'false'),
(4918, 11, 0, 'false'),
(4919, 11, 0, 'false'),
(4920, 11, 0, 'false'),
(4921, 11, 0, 'false'),
(4922, 11, 0, 'false'),
(4923, 11, 0, 'false'),
(4924, 11, 0, 'false'),
(4925, 11, 0, 'true'),
(4926, 11, 0, 'false'),
(4927, 11, 0, 'false'),
(4928, 11, 0, 'false'),
(4929, 11, 0, 'false'),
(4930, 11, 0, 'false'),
(4931, 11, 0, 'false'),
(4932, 11, 0, 'false'),
(4933, 11, 0, 'false'),
(4934, 11, 0, 'false'),
(4935, 11, 0, 'false'),
(4936, 11, 0, 'false'),
(4937, 11, 0, 'false'),
(4938, 11, 0, 'false'),
(4939, 12, 0, 'false'),
(4940, 12, 0, 'false'),
(4941, 12, 0, 'false'),
(4942, 12, 0, 'false'),
(4943, 12, 0, 'false'),
(4944, 12, 0, 'false'),
(4945, 12, 0, 'false'),
(4946, 12, 0, 'false'),
(4947, 12, 0, 'false'),
(4948, 12, 0, 'false'),
(4949, 12, 0, 'true'),
(4950, 12, 0, 'false'),
(4951, 12, 0, 'false'),
(4952, 12, 0, 'false'),
(4953, 12, 0, 'false'),
(4954, 12, 0, 'false'),
(4955, 12, 0, 'false'),
(4956, 12, 0, 'false'),
(4957, 12, 0, 'false'),
(4958, 12, 0, 'false'),
(4959, 12, 0, 'false'),
(4960, 12, 0, 'false'),
(4961, 12, 0, 'false'),
(4962, 12, 0, 'false'),
(4963, 12, 0, 'false'),
(4964, 12, 0, 'false'),
(4965, 12, 0, 'false'),
(4966, 12, 0, 'true'),
(4967, 12, 0, 'false'),
(4968, 12, 0, 'false'),
(4969, 12, 0, 'false'),
(4970, 12, 0, 'false'),
(4971, 12, 0, 'false'),
(4972, 12, 0, 'false'),
(4973, 12, 0, 'false'),
(4974, 12, 0, 'false'),
(4975, 12, 0, 'false'),
(4976, 12, 0, 'false'),
(4977, 12, 0, 'false'),
(4978, 12, 0, 'false'),
(4979, 12, 0, 'false'),
(4980, 12, 0, 'false'),
(4981, 12, 0, 'false'),
(4982, 12, 0, 'false'),
(4983, 12, 0, 'false'),
(4984, 12, 0, 'false'),
(4985, 12, 0, 'false'),
(4986, 12, 0, 'false'),
(4987, 12, 0, 'false'),
(4988, 12, 0, 'false'),
(4989, 12, 0, 'false'),
(4990, 12, 0, 'false'),
(4991, 12, 0, 'false'),
(4992, 12, 0, 'false'),
(4993, 12, 0, 'true'),
(4994, 12, 0, 'false'),
(4995, 12, 0, 'false'),
(4996, 12, 0, 'false'),
(4997, 12, 0, 'false'),
(4998, 12, 0, 'false'),
(4999, 12, 0, 'false'),
(5000, 12, 0, 'false'),
(5001, 12, 0, 'false'),
(5002, 12, 0, 'false'),
(5003, 12, 0, 'false'),
(5004, 12, 0, 'false'),
(5005, 12, 0, 'false'),
(5006, 12, 0, 'false'),
(5007, 12, 0, 'false'),
(5008, 12, 0, 'false'),
(5009, 12, 0, 'false'),
(5010, 12, 0, 'false'),
(5011, 12, 0, 'false'),
(5012, 12, 0, 'false'),
(5013, 12, 0, 'false'),
(5014, 12, 0, 'false'),
(5015, 12, 0, 'false'),
(5016, 12, 0, 'true'),
(5017, 12, 0, 'false'),
(5018, 12, 0, 'false'),
(5019, 12, 0, 'false'),
(5020, 12, 0, 'false'),
(5021, 12, 0, 'false'),
(5022, 12, 0, 'false'),
(5023, 12, 0, 'false'),
(5024, 12, 0, 'false'),
(5025, 12, 0, 'false'),
(5026, 12, 0, 'false'),
(5027, 12, 0, 'false'),
(5028, 12, 0, 'false'),
(5029, 12, 0, 'false'),
(5030, 12, 0, 'false'),
(5031, 12, 0, 'false'),
(5032, 12, 0, 'false'),
(5033, 12, 0, 'false'),
(5034, 12, 0, 'false'),
(5035, 12, 0, 'false'),
(5036, 12, 0, 'false'),
(5037, 12, 0, 'false'),
(5038, 12, 0, 'false'),
(5039, 12, 0, 'false'),
(5040, 12, 0, 'false'),
(5041, 12, 0, 'false'),
(5042, 12, 0, 'false'),
(5043, 12, 0, 'false'),
(5044, 12, 0, 'true'),
(5045, 12, 0, 'false'),
(5046, 12, 0, 'false'),
(5047, 12, 0, 'false'),
(5048, 12, 0, 'false'),
(5049, 12, 0, 'false'),
(5050, 12, 0, 'false'),
(5051, 12, 0, 'false'),
(5052, 12, 0, 'false'),
(5053, 12, 0, 'false'),
(5054, 12, 0, 'false'),
(5055, 12, 0, 'false'),
(5056, 12, 0, 'false'),
(5057, 12, 0, 'false'),
(5058, 12, 0, 'false'),
(5059, 12, 0, 'false'),
(5060, 12, 0, 'false'),
(5061, 12, 0, 'false'),
(5062, 12, 0, 'false'),
(5063, 12, 0, 'false'),
(5064, 12, 0, 'false'),
(5065, 12, 0, 'false'),
(5066, 12, 0, 'false'),
(5067, 12, 0, 'true'),
(5068, 12, 0, 'false'),
(5069, 12, 0, 'false'),
(5070, 12, 0, 'false'),
(5071, 12, 0, 'false'),
(5072, 12, 0, 'false'),
(5073, 12, 0, 'false'),
(5074, 12, 0, 'false'),
(5075, 12, 0, 'false'),
(5076, 12, 0, 'false'),
(5077, 12, 0, 'false'),
(5078, 12, 0, 'false'),
(5079, 12, 0, 'false'),
(5080, 12, 0, 'false'),
(5081, 12, 0, 'false'),
(5082, 12, 0, 'false'),
(5083, 12, 0, 'false'),
(5084, 12, 0, 'false'),
(5085, 12, 0, 'false'),
(5086, 12, 0, 'false'),
(5087, 12, 0, 'false'),
(5088, 12, 0, 'false'),
(5089, 12, 0, 'false'),
(5090, 12, 0, 'true'),
(5091, 12, 0, 'false'),
(5092, 12, 0, 'false'),
(5093, 12, 0, 'false'),
(5094, 12, 0, 'false'),
(5095, 12, 0, 'false'),
(5096, 12, 0, 'false'),
(5097, 12, 0, 'false'),
(5098, 12, 0, 'false'),
(5099, 12, 0, 'false'),
(5100, 12, 0, 'false'),
(5101, 12, 0, 'false'),
(5102, 12, 0, 'false'),
(5103, 12, 0, 'false'),
(5104, 12, 0, 'false'),
(5105, 12, 0, 'false'),
(5106, 12, 0, 'false'),
(5107, 13, 0, 'false'),
(5108, 13, 0, 'false'),
(5109, 13, 0, 'false'),
(5110, 13, 0, 'true'),
(5111, 13, 0, 'false'),
(5112, 13, 0, 'false'),
(5113, 13, 0, 'false'),
(5114, 13, 0, 'false'),
(5115, 13, 0, 'false'),
(5116, 13, 0, 'false'),
(5117, 13, 0, 'false'),
(5118, 13, 0, 'false'),
(5119, 13, 0, 'false'),
(5120, 13, 0, 'false'),
(5121, 13, 0, 'false'),
(5122, 13, 0, 'false'),
(5123, 13, 0, 'false'),
(5124, 13, 0, 'false'),
(5125, 13, 0, 'false'),
(5126, 13, 0, 'false'),
(5127, 13, 0, 'false'),
(5128, 13, 0, 'false'),
(5129, 13, 0, 'false'),
(5130, 13, 0, 'false'),
(5131, 13, 0, 'false'),
(5132, 13, 0, 'false'),
(5133, 13, 0, 'false'),
(5134, 13, 0, 'false'),
(5135, 13, 0, 'false'),
(5136, 13, 0, 'false'),
(5137, 13, 0, 'false'),
(5138, 13, 0, 'false'),
(5139, 13, 0, 'false'),
(5140, 13, 0, 'true'),
(5141, 13, 0, 'false'),
(5142, 13, 0, 'false'),
(5143, 13, 0, 'false'),
(5144, 13, 0, 'false'),
(5145, 13, 0, 'false'),
(5146, 13, 0, 'false'),
(5147, 13, 0, 'false'),
(5148, 13, 0, 'false'),
(5149, 13, 0, 'false'),
(5150, 13, 0, 'false'),
(5151, 13, 0, 'false'),
(5152, 13, 0, 'false'),
(5153, 13, 0, 'false'),
(5154, 13, 0, 'false'),
(5155, 13, 0, 'false'),
(5156, 13, 0, 'false'),
(5157, 13, 0, 'false'),
(5158, 13, 0, 'false'),
(5159, 13, 0, 'false'),
(5160, 13, 0, 'true'),
(5161, 13, 0, 'false'),
(5162, 13, 0, 'false'),
(5163, 13, 0, 'false'),
(5164, 13, 0, 'false'),
(5165, 13, 0, 'false'),
(5166, 13, 0, 'false'),
(5167, 13, 0, 'false'),
(5168, 13, 0, 'false'),
(5169, 13, 0, 'false'),
(5170, 13, 0, 'false'),
(5171, 13, 0, 'false'),
(5172, 13, 0, 'false'),
(5173, 13, 0, 'false'),
(5174, 13, 0, 'false'),
(5175, 13, 0, 'false'),
(5176, 13, 0, 'false'),
(5177, 13, 0, 'false'),
(5178, 13, 0, 'false'),
(5179, 13, 0, 'false'),
(5180, 13, 0, 'false'),
(5181, 13, 0, 'false'),
(5182, 13, 0, 'false'),
(5183, 13, 0, 'false'),
(5184, 13, 0, 'false'),
(5185, 13, 0, 'true'),
(5186, 13, 0, 'false'),
(5187, 13, 0, 'false'),
(5188, 13, 0, 'false'),
(5189, 13, 0, 'false'),
(5190, 13, 0, 'false'),
(5191, 13, 0, 'false'),
(5192, 13, 0, 'false'),
(5193, 13, 0, 'false'),
(5194, 13, 0, 'false'),
(5195, 13, 0, 'false'),
(5196, 13, 0, 'false'),
(5197, 13, 0, 'false'),
(5198, 13, 0, 'false'),
(5199, 13, 0, 'false'),
(5200, 13, 0, 'false'),
(5201, 13, 0, 'false'),
(5202, 13, 0, 'false'),
(5203, 13, 0, 'false'),
(5204, 13, 0, 'false'),
(5205, 13, 0, 'false'),
(5206, 13, 0, 'false'),
(5207, 13, 0, 'false'),
(5208, 13, 0, 'false'),
(5209, 13, 0, 'false'),
(5210, 13, 0, 'false'),
(5211, 13, 0, 'true'),
(5212, 13, 0, 'false'),
(5213, 13, 0, 'false'),
(5214, 13, 0, 'false'),
(5215, 13, 0, 'false'),
(5216, 13, 0, 'false'),
(5217, 13, 0, 'false'),
(5218, 13, 0, 'false'),
(5219, 13, 0, 'false'),
(5220, 13, 0, 'false'),
(5221, 13, 0, 'false'),
(5222, 13, 0, 'false'),
(5223, 13, 0, 'false'),
(5224, 13, 0, 'false'),
(5225, 13, 0, 'false'),
(5226, 13, 0, 'false'),
(5227, 14, 0, 'false'),
(5228, 14, 0, 'false'),
(5229, 14, 0, 'false'),
(5230, 14, 0, 'true'),
(5231, 14, 0, 'false'),
(5232, 14, 0, 'false'),
(5233, 14, 0, 'false'),
(5234, 14, 0, 'false'),
(5235, 14, 0, 'false'),
(5236, 14, 0, 'false'),
(5237, 14, 0, 'false'),
(5238, 14, 0, 'false'),
(5239, 14, 0, 'false'),
(5240, 14, 0, 'false'),
(5241, 14, 0, 'false'),
(5242, 14, 0, 'false'),
(5243, 14, 0, 'false'),
(5244, 14, 0, 'false'),
(5245, 14, 0, 'false'),
(5246, 14, 0, 'false'),
(5247, 14, 0, 'false'),
(5248, 14, 0, 'false'),
(5249, 14, 0, 'false'),
(5250, 14, 0, 'false'),
(5251, 14, 0, 'false'),
(5252, 14, 0, 'false'),
(5253, 14, 0, 'false'),
(5254, 14, 0, 'false'),
(5255, 14, 0, 'false'),
(5256, 14, 0, 'false'),
(5257, 14, 0, 'false'),
(5258, 14, 0, 'true'),
(5259, 14, 0, 'false'),
(5260, 14, 0, 'false'),
(5261, 14, 0, 'false'),
(5262, 14, 0, 'false'),
(5263, 14, 0, 'false'),
(5264, 14, 0, 'false'),
(5265, 14, 0, 'false'),
(5266, 14, 0, 'false'),
(5267, 14, 0, 'false'),
(5268, 14, 0, 'false'),
(5269, 14, 0, 'false'),
(5270, 14, 0, 'false'),
(5271, 14, 0, 'false'),
(5272, 14, 0, 'false'),
(5273, 14, 0, 'false'),
(5274, 14, 0, 'false'),
(5275, 14, 0, 'false'),
(5276, 14, 0, 'false'),
(5277, 14, 0, 'false'),
(5278, 14, 0, 'false'),
(5279, 14, 0, 'false'),
(5280, 14, 0, 'false'),
(5281, 14, 0, 'false'),
(5282, 14, 0, 'false'),
(5283, 14, 0, 'false'),
(5284, 14, 0, 'false'),
(5285, 14, 0, 'false'),
(5286, 14, 0, 'false'),
(5287, 14, 0, 'false'),
(5288, 14, 0, 'false'),
(5289, 14, 0, 'false'),
(5290, 14, 0, 'false'),
(5291, 14, 0, 'false'),
(5292, 14, 0, 'false'),
(5293, 14, 0, 'false'),
(5294, 14, 0, 'false'),
(5295, 14, 0, 'false'),
(5296, 14, 0, 'false'),
(5297, 14, 0, 'false'),
(5298, 14, 0, 'true'),
(5299, 14, 0, 'false'),
(5300, 14, 0, 'false'),
(5301, 14, 0, 'false'),
(5302, 14, 0, 'false'),
(5303, 14, 0, 'false'),
(5304, 14, 0, 'false'),
(5305, 14, 0, 'false'),
(5306, 14, 0, 'false'),
(5307, 14, 0, 'true'),
(5308, 14, 0, 'false'),
(5309, 14, 0, 'false'),
(5310, 14, 0, 'false'),
(5311, 14, 0, 'false'),
(5312, 14, 0, 'false'),
(5313, 14, 0, 'false'),
(5314, 14, 0, 'false'),
(5315, 14, 0, 'false'),
(5316, 14, 0, 'false'),
(5317, 14, 0, 'false'),
(5318, 14, 0, 'false'),
(5319, 14, 0, 'false'),
(5320, 14, 0, 'false'),
(5321, 14, 0, 'false'),
(5322, 14, 0, 'false'),
(5323, 14, 0, 'false'),
(5324, 14, 0, 'false'),
(5325, 14, 0, 'false'),
(5326, 14, 0, 'false'),
(5327, 14, 0, 'false'),
(5328, 14, 0, 'false'),
(5329, 14, 0, 'false'),
(5330, 14, 0, 'false'),
(5331, 14, 0, 'false'),
(5332, 14, 0, 'true'),
(5333, 14, 0, 'false'),
(5334, 14, 0, 'false'),
(5335, 14, 0, 'false'),
(5336, 14, 0, 'false'),
(5337, 14, 0, 'false'),
(5338, 14, 0, 'false'),
(5339, 14, 0, 'false'),
(5340, 14, 0, 'false'),
(5341, 14, 0, 'false'),
(5342, 14, 0, 'false'),
(5343, 14, 0, 'false'),
(5344, 14, 0, 'false'),
(5345, 14, 0, 'false'),
(5346, 14, 0, 'false'),
(5347, 14, 0, 'false'),
(5348, 14, 0, 'false'),
(5349, 14, 0, 'false'),
(5350, 14, 0, 'false'),
(5351, 14, 0, 'false'),
(5352, 14, 0, 'false'),
(5353, 14, 0, 'true'),
(5354, 14, 0, 'false'),
(5355, 14, 0, 'false'),
(5356, 14, 0, 'false'),
(5357, 14, 0, 'false'),
(5358, 14, 0, 'false'),
(5359, 14, 0, 'false'),
(5360, 14, 0, 'false'),
(5361, 14, 0, 'false'),
(5362, 14, 0, 'false'),
(5363, 14, 0, 'false'),
(5364, 14, 0, 'false'),
(5365, 14, 0, 'false'),
(5366, 14, 0, 'false'),
(5367, 14, 0, 'false'),
(5368, 14, 0, 'false'),
(5369, 14, 0, 'false'),
(5370, 14, 0, 'false'),
(5371, 14, 0, 'false'),
(5372, 14, 0, 'false'),
(5373, 14, 0, 'false'),
(5374, 14, 0, 'false'),
(5375, 14, 0, 'false'),
(5376, 14, 0, 'false'),
(5377, 14, 0, 'false'),
(5378, 14, 0, 'false'),
(5379, 14, 0, 'false'),
(5380, 14, 0, 'false'),
(5381, 14, 0, 'true'),
(5382, 14, 0, 'false'),
(5383, 14, 0, 'false'),
(5384, 14, 0, 'false'),
(5385, 14, 0, 'false'),
(5386, 14, 0, 'false'),
(5387, 14, 0, 'false'),
(5388, 14, 0, 'false'),
(5389, 14, 0, 'false'),
(5390, 14, 0, 'false'),
(5391, 14, 0, 'false'),
(5392, 14, 0, 'false'),
(5393, 14, 0, 'false'),
(5394, 14, 0, 'false'),
(5395, 15, 0, 'false'),
(5396, 15, 0, 'false'),
(5397, 15, 0, 'false'),
(5398, 15, 0, 'false'),
(5399, 15, 0, 'false'),
(5400, 15, 0, 'false'),
(5401, 15, 0, 'true'),
(5402, 15, 0, 'false'),
(5403, 15, 0, 'false'),
(5404, 15, 0, 'false'),
(5405, 15, 0, 'false'),
(5406, 15, 0, 'false'),
(5407, 15, 0, 'false'),
(5408, 15, 0, 'false'),
(5409, 15, 0, 'false'),
(5410, 15, 0, 'false'),
(5411, 15, 0, 'false'),
(5412, 15, 0, 'false'),
(5413, 15, 0, 'false'),
(5414, 15, 0, 'false'),
(5415, 15, 0, 'false'),
(5416, 15, 0, 'false'),
(5417, 15, 0, 'false'),
(5418, 15, 0, 'false'),
(5419, 15, 0, 'false'),
(5420, 15, 0, 'false'),
(5421, 15, 0, 'false'),
(5422, 15, 0, 'true'),
(5423, 15, 0, 'false'),
(5424, 15, 0, 'false'),
(5425, 15, 0, 'false'),
(5426, 15, 0, 'false'),
(5427, 15, 0, 'false'),
(5428, 15, 0, 'false'),
(5429, 15, 0, 'false'),
(5430, 15, 0, 'false'),
(5431, 15, 0, 'false'),
(5432, 15, 0, 'false'),
(5433, 15, 0, 'false'),
(5434, 15, 0, 'false'),
(5435, 15, 0, 'false'),
(5436, 15, 0, 'false'),
(5437, 15, 0, 'false'),
(5438, 15, 0, 'false'),
(5439, 15, 0, 'false'),
(5440, 15, 0, 'false'),
(5441, 15, 0, 'false'),
(5442, 15, 0, 'false'),
(5443, 15, 0, 'false'),
(5444, 15, 0, 'false'),
(5445, 15, 0, 'false'),
(5446, 15, 0, 'false'),
(5447, 15, 0, 'false'),
(5448, 15, 0, 'true'),
(5449, 15, 0, 'false'),
(5450, 15, 0, 'false'),
(5451, 15, 0, 'false'),
(5452, 15, 0, 'false'),
(5453, 15, 0, 'false'),
(5454, 15, 0, 'false'),
(5455, 15, 0, 'false'),
(5456, 15, 0, 'false'),
(5457, 15, 0, 'false'),
(5458, 15, 0, 'false'),
(5459, 15, 0, 'false'),
(5460, 15, 0, 'false'),
(5461, 15, 0, 'false'),
(5462, 15, 0, 'false'),
(5463, 15, 0, 'false'),
(5464, 15, 0, 'false'),
(5465, 15, 0, 'false'),
(5466, 15, 0, 'false'),
(5467, 15, 0, 'false'),
(5468, 15, 0, 'false'),
(5469, 15, 0, 'false'),
(5470, 15, 0, 'false'),
(5471, 15, 0, 'false'),
(5472, 15, 0, 'false'),
(5473, 15, 0, 'false'),
(5474, 15, 0, 'true'),
(5475, 15, 0, 'false'),
(5476, 15, 0, 'false'),
(5477, 15, 0, 'false'),
(5478, 15, 0, 'false'),
(5479, 15, 0, 'false'),
(5480, 15, 0, 'false'),
(5481, 15, 0, 'false'),
(5482, 15, 0, 'false'),
(5483, 15, 0, 'false'),
(5484, 15, 0, 'false'),
(5485, 15, 0, 'false'),
(5486, 15, 0, 'false'),
(5487, 15, 0, 'false'),
(5488, 15, 0, 'false'),
(5489, 15, 0, 'false'),
(5490, 15, 0, 'false'),
(5491, 15, 0, 'false'),
(5492, 15, 0, 'false'),
(5493, 15, 0, 'false'),
(5494, 15, 0, 'false'),
(5495, 15, 0, 'false'),
(5496, 15, 0, 'false'),
(5497, 15, 0, 'false'),
(5498, 15, 0, 'false'),
(5499, 15, 0, 'true'),
(5500, 15, 0, 'false'),
(5501, 15, 0, 'false'),
(5502, 15, 0, 'false'),
(5503, 15, 0, 'false'),
(5504, 15, 0, 'false'),
(5505, 15, 0, 'false'),
(5506, 15, 0, 'false'),
(5507, 15, 0, 'false'),
(5508, 15, 0, 'false'),
(5509, 15, 0, 'false'),
(5510, 15, 0, 'false'),
(5511, 15, 0, 'false'),
(5512, 15, 0, 'false'),
(5513, 15, 0, 'false'),
(5514, 15, 0, 'false'),
(5515, 15, 0, 'false'),
(5516, 15, 0, 'false'),
(5517, 15, 0, 'false'),
(5518, 15, 0, 'false'),
(5519, 15, 0, 'false'),
(5520, 15, 0, 'false'),
(5521, 15, 0, 'false'),
(5522, 15, 0, 'false'),
(5523, 15, 0, 'false'),
(5524, 15, 0, 'true'),
(5525, 15, 0, 'false'),
(5526, 15, 0, 'false'),
(5527, 15, 0, 'false'),
(5528, 15, 0, 'false'),
(5529, 15, 0, 'false'),
(5530, 15, 0, 'false'),
(5531, 15, 0, 'false'),
(5532, 15, 0, 'false'),
(5533, 15, 0, 'false'),
(5534, 15, 0, 'false'),
(5535, 15, 0, 'false'),
(5536, 15, 0, 'false'),
(5537, 15, 0, 'false'),
(5538, 15, 0, 'false'),
(5539, 15, 0, 'false'),
(5540, 15, 0, 'false'),
(5541, 15, 0, 'false'),
(5542, 15, 0, 'false'),
(5543, 15, 0, 'false'),
(5544, 15, 0, 'false'),
(5545, 15, 0, 'false'),
(5546, 15, 0, 'false'),
(5547, 15, 0, 'false'),
(5548, 15, 0, 'false'),
(5549, 15, 0, 'true'),
(5550, 15, 0, 'false'),
(5551, 15, 0, 'false'),
(5552, 15, 0, 'false'),
(5553, 15, 0, 'false'),
(5554, 15, 0, 'false'),
(5555, 15, 0, 'false'),
(5556, 15, 0, 'false'),
(5557, 15, 0, 'false'),
(5558, 15, 0, 'false'),
(5559, 15, 0, 'false'),
(5560, 15, 0, 'false'),
(5561, 15, 0, 'false'),
(5562, 15, 0, 'false'),
(5563, 15, 0, 'false'),
(5564, 15, 0, 'false'),
(5565, 15, 0, 'false'),
(5566, 15, 0, 'false'),
(5567, 15, 0, 'false'),
(5568, 15, 0, 'false'),
(5569, 15, 0, 'false'),
(5570, 15, 0, 'false'),
(5571, 15, 0, 'false'),
(5572, 15, 0, 'false'),
(5573, 15, 0, 'false'),
(5574, 15, 0, 'true'),
(5575, 15, 0, 'false'),
(5576, 15, 0, 'false'),
(5577, 15, 0, 'false'),
(5578, 15, 0, 'false'),
(5579, 15, 0, 'false'),
(5580, 15, 0, 'false'),
(5581, 15, 0, 'false'),
(5582, 15, 0, 'false'),
(5583, 15, 0, 'false'),
(5584, 15, 0, 'false'),
(5585, 15, 0, 'false'),
(5586, 15, 0, 'false'),
(5587, 15, 0, 'false'),
(5588, 15, 0, 'false'),
(5589, 15, 0, 'false'),
(5590, 15, 0, 'false'),
(5591, 15, 0, 'false'),
(5592, 15, 0, 'false'),
(5593, 15, 0, 'false'),
(5594, 15, 0, 'false'),
(5595, 15, 0, 'false'),
(5596, 15, 0, 'false'),
(5597, 15, 0, 'false'),
(5598, 15, 0, 'false'),
(5599, 15, 0, 'true'),
(5600, 15, 0, 'false'),
(5601, 15, 0, 'false'),
(5602, 15, 0, 'false'),
(5603, 15, 0, 'false'),
(5604, 15, 0, 'false'),
(5605, 15, 0, 'false'),
(5606, 15, 0, 'false'),
(5607, 15, 0, 'false'),
(5608, 15, 0, 'false'),
(5609, 15, 0, 'false'),
(5610, 15, 0, 'false'),
(5611, 15, 0, 'false'),
(5612, 15, 0, 'false'),
(5613, 15, 0, 'false'),
(5614, 15, 0, 'false'),
(5615, 15, 0, 'false'),
(5616, 15, 0, 'false'),
(5617, 15, 0, 'false'),
(5618, 15, 0, 'false'),
(5619, 15, 0, 'false'),
(5620, 15, 0, 'false'),
(5621, 15, 0, 'false'),
(5622, 15, 0, 'false'),
(5623, 15, 0, 'false'),
(5624, 15, 0, 'false'),
(5625, 15, 0, 'false'),
(5626, 15, 0, 'false'),
(5627, 15, 0, 'false'),
(5628, 15, 0, 'false'),
(5629, 15, 0, 'false'),
(5630, 15, 0, 'false'),
(5631, 15, 0, 'false'),
(5632, 15, 0, 'false'),
(5633, 15, 0, 'false'),
(5634, 15, 0, 'true'),
(5635, 16, 0, 'false'),
(5636, 16, 0, 'false'),
(5637, 16, 0, 'false'),
(5638, 16, 0, 'false'),
(5639, 16, 0, 'false'),
(5640, 16, 0, 'false'),
(5641, 16, 0, 'false'),
(5642, 16, 0, 'false'),
(5643, 16, 0, 'false'),
(5644, 16, 0, 'false'),
(5645, 16, 0, 'false'),
(5646, 16, 0, 'false'),
(5647, 16, 0, 'true'),
(5648, 16, 0, 'false'),
(5649, 16, 0, 'false'),
(5650, 16, 0, 'false'),
(5651, 16, 0, 'false'),
(5652, 16, 0, 'false'),
(5653, 16, 0, 'false'),
(5654, 16, 0, 'false'),
(5655, 16, 0, 'false'),
(5656, 16, 0, 'false'),
(5657, 16, 0, 'false'),
(5658, 16, 0, 'false'),
(5659, 16, 0, 'false'),
(5660, 16, 0, 'false'),
(5661, 16, 0, 'false'),
(5662, 16, 0, 'false'),
(5663, 16, 0, 'false'),
(5664, 16, 0, 'false'),
(5665, 16, 0, 'false'),
(5666, 16, 0, 'false'),
(5667, 16, 0, 'false'),
(5668, 16, 0, 'false'),
(5669, 16, 0, 'false'),
(5670, 16, 0, 'true'),
(5671, 16, 0, 'false'),
(5672, 16, 0, 'false'),
(5673, 16, 0, 'false'),
(5674, 16, 0, 'false'),
(5675, 16, 0, 'false'),
(5676, 16, 0, 'false'),
(5677, 16, 0, 'false'),
(5678, 16, 0, 'false'),
(5679, 16, 0, 'false'),
(5680, 16, 0, 'false'),
(5681, 16, 0, 'false'),
(5682, 16, 0, 'false'),
(5683, 16, 0, 'false'),
(5684, 16, 0, 'false'),
(5685, 16, 0, 'false'),
(5686, 16, 0, 'false'),
(5687, 16, 0, 'false'),
(5688, 16, 0, 'false'),
(5689, 16, 0, 'false'),
(5690, 16, 0, 'true'),
(5691, 16, 0, 'false'),
(5692, 16, 0, 'false'),
(5693, 16, 0, 'false'),
(5694, 16, 0, 'false'),
(5695, 16, 0, 'false'),
(5696, 16, 0, 'false'),
(5697, 16, 0, 'false'),
(5698, 16, 0, 'false'),
(5699, 16, 0, 'false'),
(5700, 16, 0, 'false'),
(5701, 16, 0, 'false'),
(5702, 16, 0, 'false'),
(5703, 16, 0, 'false'),
(5704, 16, 0, 'false'),
(5705, 16, 0, 'false'),
(5706, 16, 0, 'false'),
(5707, 16, 0, 'false'),
(5708, 16, 0, 'false'),
(5709, 16, 0, 'false'),
(5710, 16, 0, 'false'),
(5711, 16, 0, 'false'),
(5712, 16, 0, 'false'),
(5713, 16, 0, 'false'),
(5714, 16, 0, 'false'),
(5715, 16, 0, 'false'),
(5716, 16, 0, 'false'),
(5717, 16, 0, 'true'),
(5718, 16, 0, 'false'),
(5719, 16, 0, 'false'),
(5720, 16, 0, 'false'),
(5721, 16, 0, 'false'),
(5722, 16, 0, 'false'),
(5723, 16, 0, 'false'),
(5724, 16, 0, 'false'),
(5725, 16, 0, 'false'),
(5726, 16, 0, 'false'),
(5727, 16, 0, 'false'),
(5728, 16, 0, 'false'),
(5729, 16, 0, 'false'),
(5730, 16, 0, 'false'),
(5731, 16, 0, 'false'),
(5732, 16, 0, 'false'),
(5733, 16, 0, 'false'),
(5734, 16, 0, 'false'),
(5735, 16, 0, 'false'),
(5736, 16, 0, 'false'),
(5737, 16, 0, 'true'),
(5738, 16, 0, 'false'),
(5739, 16, 0, 'false'),
(5740, 16, 0, 'false'),
(5741, 16, 0, 'false'),
(5742, 16, 0, 'false'),
(5743, 16, 0, 'false'),
(5744, 16, 0, 'false'),
(5745, 16, 0, 'false'),
(5746, 16, 0, 'false'),
(5747, 16, 0, 'false'),
(5748, 16, 0, 'false'),
(5749, 16, 0, 'false'),
(5750, 16, 0, 'false'),
(5751, 16, 0, 'false'),
(5752, 16, 0, 'false'),
(5753, 16, 0, 'false'),
(5754, 16, 0, 'false'),
(5755, 16, 0, 'false'),
(5756, 16, 0, 'false'),
(5757, 16, 0, 'false'),
(5758, 16, 0, 'false'),
(5759, 16, 0, 'false'),
(5760, 16, 0, 'false'),
(5761, 16, 0, 'false'),
(5762, 16, 0, 'false'),
(5763, 16, 0, 'false'),
(5764, 16, 0, 'true'),
(5765, 16, 0, 'false'),
(5766, 16, 0, 'false'),
(5767, 16, 0, 'false'),
(5768, 16, 0, 'false'),
(5769, 16, 0, 'false'),
(5770, 16, 0, 'false'),
(5771, 16, 0, 'false'),
(5772, 16, 0, 'false'),
(5773, 16, 0, 'false'),
(5774, 16, 0, 'false'),
(5775, 16, 0, 'false'),
(5776, 16, 0, 'false'),
(5777, 16, 0, 'false'),
(5778, 16, 0, 'false'),
(5779, 16, 0, 'false'),
(5780, 16, 0, 'false'),
(5781, 16, 0, 'false'),
(5782, 16, 0, 'false'),
(5783, 16, 0, 'false'),
(5784, 16, 0, 'false'),
(5785, 16, 0, 'false'),
(5786, 16, 0, 'false'),
(5787, 16, 0, 'true'),
(5788, 16, 0, 'false'),
(5789, 16, 0, 'false'),
(5790, 16, 0, 'false'),
(5791, 16, 0, 'false'),
(5792, 16, 0, 'false'),
(5793, 16, 0, 'false'),
(5794, 16, 0, 'false'),
(5795, 16, 0, 'false'),
(5796, 16, 0, 'false'),
(5797, 16, 0, 'false'),
(5798, 16, 0, 'false'),
(5799, 16, 0, 'false'),
(5800, 16, 0, 'false'),
(5801, 16, 0, 'false'),
(5802, 16, 0, 'false'),
(5803, 16, 0, 'false'),
(5804, 16, 0, 'false'),
(5805, 16, 0, 'false'),
(5806, 16, 0, 'false'),
(5807, 16, 0, 'false'),
(5808, 16, 0, 'true'),
(5809, 16, 0, 'false'),
(5810, 16, 0, 'false'),
(5811, 16, 0, 'false'),
(5812, 16, 0, 'false'),
(5813, 16, 0, 'false'),
(5814, 16, 0, 'false'),
(5815, 16, 0, 'false'),
(5816, 16, 0, 'false'),
(5817, 16, 0, 'false'),
(5818, 16, 0, 'false'),
(5819, 16, 0, 'false'),
(5820, 16, 0, 'false'),
(5821, 16, 0, 'false'),
(5822, 16, 0, 'false'),
(5823, 16, 0, 'false'),
(5824, 16, 0, 'false'),
(5825, 16, 0, 'false'),
(5826, 16, 0, 'false'),
(5827, 16, 0, 'false'),
(5828, 16, 0, 'false'),
(5829, 16, 0, 'false'),
(5830, 16, 0, 'true'),
(5831, 16, 0, 'false'),
(5832, 16, 0, 'false'),
(5833, 16, 0, 'false'),
(5834, 16, 0, 'false'),
(5835, 16, 0, 'false'),
(5836, 16, 0, 'false'),
(5837, 16, 0, 'false'),
(5838, 16, 0, 'false'),
(5839, 16, 0, 'false'),
(5840, 16, 0, 'false'),
(5841, 16, 0, 'false'),
(5842, 16, 0, 'false'),
(5843, 16, 0, 'false'),
(5844, 16, 0, 'false'),
(5845, 16, 0, 'false'),
(5846, 16, 0, 'false'),
(5847, 16, 0, 'false'),
(5848, 16, 0, 'false'),
(5849, 16, 0, 'false'),
(5850, 16, 0, 'false'),
(5851, 16, 0, 'false'),
(5852, 16, 0, 'false'),
(5853, 16, 0, 'false'),
(5854, 16, 0, 'false'),
(5855, 16, 0, 'false'),
(5856, 16, 0, 'false'),
(5857, 16, 0, 'false'),
(5858, 16, 0, 'false'),
(5859, 16, 0, 'false'),
(5860, 16, 0, 'false'),
(5861, 16, 0, 'false'),
(5862, 16, 0, 'false'),
(5863, 16, 0, 'false'),
(5864, 16, 0, 'false'),
(5865, 16, 0, 'false'),
(5866, 16, 0, 'false'),
(5867, 16, 0, 'false'),
(5868, 16, 0, 'false'),
(5869, 16, 0, 'false'),
(5870, 16, 0, 'false'),
(5871, 16, 0, 'false'),
(5872, 16, 0, 'false'),
(5873, 16, 0, 'false'),
(5874, 16, 0, 'true'),
(5875, 17, 0, 'false'),
(5876, 17, 0, 'false'),
(5877, 17, 0, 'false'),
(5878, 17, 0, 'true'),
(5879, 17, 0, 'false'),
(5880, 17, 0, 'false'),
(5881, 17, 0, 'false'),
(5882, 17, 0, 'false'),
(5883, 17, 0, 'false'),
(5884, 17, 0, 'false'),
(5885, 17, 0, 'false'),
(5886, 17, 0, 'false'),
(5887, 17, 0, 'false'),
(5888, 17, 0, 'false'),
(5889, 17, 0, 'false'),
(5890, 17, 0, 'false'),
(5891, 17, 0, 'false'),
(5892, 17, 0, 'false'),
(5893, 17, 0, 'false'),
(5894, 17, 0, 'false'),
(5895, 17, 0, 'false'),
(5896, 17, 0, 'false'),
(5897, 17, 0, 'false'),
(5898, 17, 0, 'false'),
(5899, 17, 0, 'false'),
(5900, 17, 0, 'false'),
(5901, 17, 0, 'false'),
(5902, 17, 0, 'false'),
(5903, 17, 0, 'false'),
(5904, 17, 0, 'true'),
(5905, 17, 0, 'false'),
(5906, 17, 0, 'false'),
(5907, 17, 0, 'false'),
(5908, 17, 0, 'false'),
(5909, 17, 0, 'false'),
(5910, 17, 0, 'false'),
(5911, 17, 0, 'false'),
(5912, 17, 0, 'false'),
(5913, 17, 0, 'false'),
(5914, 17, 0, 'false'),
(5915, 17, 0, 'false'),
(5916, 17, 0, 'false'),
(5917, 17, 0, 'false'),
(5918, 17, 0, 'false'),
(5919, 17, 0, 'false'),
(5920, 17, 0, 'false'),
(5921, 17, 0, 'false'),
(5922, 17, 0, 'false'),
(5923, 17, 0, 'false'),
(5924, 17, 0, 'false'),
(5925, 17, 0, 'false'),
(5926, 17, 0, 'false'),
(5927, 17, 0, 'false'),
(5928, 17, 0, 'false'),
(5929, 17, 0, 'true'),
(5930, 17, 0, 'false'),
(5931, 17, 0, 'false'),
(5932, 17, 0, 'false'),
(5933, 17, 0, 'false'),
(5934, 17, 0, 'false'),
(5935, 17, 0, 'false'),
(5936, 17, 0, 'false'),
(5937, 17, 0, 'false'),
(5938, 17, 0, 'false'),
(5939, 17, 0, 'false'),
(5940, 17, 0, 'false'),
(5941, 17, 0, 'false'),
(5942, 17, 0, 'false'),
(5943, 17, 0, 'false'),
(5944, 17, 0, 'false'),
(5945, 17, 0, 'false'),
(5946, 17, 0, 'false'),
(5947, 17, 0, 'false'),
(5948, 17, 0, 'false'),
(5949, 17, 0, 'false'),
(5950, 17, 0, 'false'),
(5951, 17, 0, 'false'),
(5952, 17, 0, 'false'),
(5953, 17, 0, 'false'),
(5954, 17, 0, 'false'),
(5955, 17, 0, 'true'),
(5956, 17, 0, 'false'),
(5957, 17, 0, 'false'),
(5958, 17, 0, 'false'),
(5959, 17, 0, 'false'),
(5960, 17, 0, 'false'),
(5961, 17, 0, 'false'),
(5962, 17, 0, 'false'),
(5963, 17, 0, 'false'),
(5964, 17, 0, 'false'),
(5965, 17, 0, 'false'),
(5966, 17, 0, 'false'),
(5967, 17, 0, 'false'),
(5968, 17, 0, 'false'),
(5969, 17, 0, 'false'),
(5970, 17, 0, 'false'),
(5971, 17, 0, 'false'),
(5972, 17, 0, 'false'),
(5973, 17, 0, 'false'),
(5974, 17, 0, 'false'),
(5975, 17, 0, 'false'),
(5976, 17, 0, 'false'),
(5977, 17, 0, 'false'),
(5978, 17, 0, 'false'),
(5979, 17, 0, 'false'),
(5980, 17, 0, 'true'),
(5981, 17, 0, 'false'),
(5982, 17, 0, 'false'),
(5983, 17, 0, 'false'),
(5984, 17, 0, 'false'),
(5985, 17, 0, 'false'),
(5986, 17, 0, 'false'),
(5987, 17, 0, 'false'),
(5988, 17, 0, 'false'),
(5989, 17, 0, 'false'),
(5990, 17, 0, 'false'),
(5991, 17, 0, 'false'),
(5992, 17, 0, 'false'),
(5993, 17, 0, 'false'),
(5994, 17, 0, 'false'),
(5995, 17, 0, 'false'),
(5996, 17, 0, 'false'),
(5997, 17, 0, 'false'),
(5998, 17, 0, 'false'),
(5999, 17, 0, 'false'),
(6000, 17, 0, 'false'),
(6001, 17, 0, 'false'),
(6002, 17, 0, 'false'),
(6003, 17, 0, 'false'),
(6004, 17, 0, 'false'),
(6005, 17, 0, 'false'),
(6006, 17, 0, 'true'),
(6007, 17, 0, 'false'),
(6008, 17, 0, 'false'),
(6009, 17, 0, 'false'),
(6010, 17, 0, 'false'),
(6011, 17, 0, 'false'),
(6012, 17, 0, 'false'),
(6013, 17, 0, 'false'),
(6014, 17, 0, 'false'),
(6015, 17, 0, 'false'),
(6016, 17, 0, 'false'),
(6017, 17, 0, 'false'),
(6018, 17, 0, 'false'),
(6019, 17, 0, 'false'),
(6020, 17, 0, 'false'),
(6021, 17, 0, 'false'),
(6022, 17, 0, 'false'),
(6023, 17, 0, 'false'),
(6024, 17, 0, 'false'),
(6025, 17, 0, 'false'),
(6026, 17, 0, 'false'),
(6027, 17, 0, 'false'),
(6028, 17, 0, 'false'),
(6029, 17, 0, 'false'),
(6030, 17, 0, 'false'),
(6031, 17, 0, 'true'),
(6032, 17, 0, 'false'),
(6033, 17, 0, 'false'),
(6034, 17, 0, 'false'),
(6035, 17, 0, 'false'),
(6036, 17, 0, 'false'),
(6037, 17, 0, 'false'),
(6038, 17, 0, 'false'),
(6039, 17, 0, 'false'),
(6040, 17, 0, 'false'),
(6041, 17, 0, 'false'),
(6042, 17, 0, 'false'),
(6043, 18, 0, 'false'),
(6044, 18, 0, 'false'),
(6045, 18, 0, 'false'),
(6046, 18, 0, 'true'),
(6047, 18, 0, 'false'),
(6048, 18, 0, 'false'),
(6049, 18, 0, 'false'),
(6050, 18, 0, 'false'),
(6051, 18, 0, 'false'),
(6052, 18, 0, 'false'),
(6053, 18, 0, 'false'),
(6054, 18, 0, 'false'),
(6055, 18, 0, 'false'),
(6056, 18, 0, 'false'),
(6057, 18, 0, 'false'),
(6058, 18, 0, 'false'),
(6059, 18, 0, 'false'),
(6060, 18, 0, 'false'),
(6061, 18, 0, 'false'),
(6062, 18, 0, 'false'),
(6063, 18, 0, 'false'),
(6064, 18, 0, 'false'),
(6065, 18, 0, 'false'),
(6066, 18, 0, 'false'),
(6067, 18, 0, 'false'),
(6068, 18, 0, 'false'),
(6069, 18, 0, 'false'),
(6070, 18, 0, 'false'),
(6071, 18, 0, 'false'),
(6072, 18, 0, 'false'),
(6073, 18, 0, 'false'),
(6074, 18, 0, 'false'),
(6075, 18, 0, 'false'),
(6076, 18, 0, 'false'),
(6077, 18, 0, 'false'),
(6078, 18, 0, 'true'),
(6079, 18, 0, 'false'),
(6080, 18, 0, 'false'),
(6081, 18, 0, 'false'),
(6082, 18, 0, 'false'),
(6083, 18, 0, 'false'),
(6084, 18, 0, 'false'),
(6085, 18, 0, 'false'),
(6086, 18, 0, 'false'),
(6087, 18, 0, 'false'),
(6088, 18, 0, 'false'),
(6089, 18, 0, 'false'),
(6090, 18, 0, 'false'),
(6091, 18, 0, 'false'),
(6092, 18, 0, 'false'),
(6093, 18, 0, 'false'),
(6094, 18, 0, 'false'),
(6095, 18, 0, 'false'),
(6096, 18, 0, 'false'),
(6097, 18, 0, 'false'),
(6098, 18, 0, 'false'),
(6099, 18, 0, 'true'),
(6100, 18, 0, 'false'),
(6101, 18, 0, 'false'),
(6102, 18, 0, 'false'),
(6103, 18, 0, 'false'),
(6104, 18, 0, 'false'),
(6105, 18, 0, 'false'),
(6106, 18, 0, 'false'),
(6107, 18, 0, 'false'),
(6108, 18, 0, 'false'),
(6109, 18, 0, 'false'),
(6110, 18, 0, 'false'),
(6111, 18, 0, 'false'),
(6112, 18, 0, 'false'),
(6113, 18, 0, 'false'),
(6114, 18, 0, 'false'),
(6115, 18, 0, 'false'),
(6116, 18, 0, 'false'),
(6117, 18, 0, 'false'),
(6118, 18, 0, 'false'),
(6119, 18, 0, 'false'),
(6120, 18, 0, 'false'),
(6121, 18, 0, 'true'),
(6122, 18, 0, 'false'),
(6123, 18, 0, 'false'),
(6124, 18, 0, 'false'),
(6125, 18, 0, 'false'),
(6126, 18, 0, 'false'),
(6127, 18, 0, 'false'),
(6128, 18, 0, 'false'),
(6129, 18, 0, 'false'),
(6130, 18, 0, 'false'),
(6131, 18, 0, 'false'),
(6132, 18, 0, 'false'),
(6133, 18, 0, 'false'),
(6134, 18, 0, 'false'),
(6135, 18, 0, 'false'),
(6136, 18, 0, 'false'),
(6137, 18, 0, 'false'),
(6138, 18, 0, 'false'),
(6139, 18, 0, 'false'),
(6140, 18, 0, 'false'),
(6141, 18, 0, 'false'),
(6142, 18, 0, 'false'),
(6143, 18, 0, 'false'),
(6144, 18, 0, 'true'),
(6145, 18, 0, 'false'),
(6146, 18, 0, 'false'),
(6147, 18, 0, 'false'),
(6148, 18, 0, 'false'),
(6149, 18, 0, 'false'),
(6150, 18, 0, 'false'),
(6151, 18, 0, 'false'),
(6152, 18, 0, 'false'),
(6153, 18, 0, 'false'),
(6154, 18, 0, 'false'),
(6155, 18, 0, 'false'),
(6156, 18, 0, 'false'),
(6157, 18, 0, 'false'),
(6158, 18, 0, 'false'),
(6159, 18, 0, 'false'),
(6160, 18, 0, 'false'),
(6161, 18, 0, 'false'),
(6162, 18, 0, 'false'),
(6163, 18, 0, 'false'),
(6164, 18, 0, 'false'),
(6165, 18, 0, 'false'),
(6166, 18, 0, 'false'),
(6167, 18, 0, 'false'),
(6168, 18, 0, 'false'),
(6169, 18, 0, 'false'),
(6170, 18, 0, 'false'),
(6171, 18, 0, 'false'),
(6172, 18, 0, 'true'),
(6173, 18, 0, 'false'),
(6174, 18, 0, 'false'),
(6175, 18, 0, 'false'),
(6176, 18, 0, 'false'),
(6177, 18, 0, 'false'),
(6178, 18, 0, 'false'),
(6179, 18, 0, 'false'),
(6180, 18, 0, 'false'),
(6181, 18, 0, 'false'),
(6182, 18, 0, 'false'),
(6183, 18, 0, 'false'),
(6184, 18, 0, 'false'),
(6185, 18, 0, 'false'),
(6186, 18, 0, 'false'),
(6187, 18, 0, 'false'),
(6188, 18, 0, 'false'),
(6189, 18, 0, 'false'),
(6190, 18, 0, 'false'),
(6191, 18, 0, 'false'),
(6192, 18, 0, 'false'),
(6193, 18, 0, 'false'),
(6194, 18, 0, 'false'),
(6195, 18, 0, 'false'),
(6196, 18, 0, 'false'),
(6197, 18, 0, 'false'),
(6198, 18, 0, 'false'),
(6199, 18, 0, 'true'),
(6200, 18, 0, 'false'),
(6201, 18, 0, 'false'),
(6202, 18, 0, 'false'),
(6203, 18, 0, 'false'),
(6204, 18, 0, 'false'),
(6205, 18, 0, 'false'),
(6206, 18, 0, 'false'),
(6207, 18, 0, 'false'),
(6208, 18, 0, 'false'),
(6209, 18, 0, 'false'),
(6210, 18, 0, 'false'),
(6226, 120, 1, 'true'),
(6227, 120, 2, 'true'),
(6228, 120, 3, 'false'),
(6229, 120, 5, 'false'),
(6230, 120, 23, 'false'),
(6269, 119, 1, 'true'),
(6270, 119, 2, 'true'),
(6271, 119, 3, 'false'),
(6272, 119, 5, 'false'),
(6273, 119, 23, 'false'),
(6274, 119, 32, 'false'),
(6275, 119, 33, 'true'),
(6306, 123, 44, 'false'),
(6307, 123, 45, 'false'),
(6308, 121, 44, 'true'),
(6309, 121, 45, 'true'),
(6324, 125, 44, 'false'),
(6325, 125, 45, 'false'),
(6326, 125, 53, 'false'),
(6327, 125, 54, 'false'),
(6343, 129, 44, 'false'),
(6344, 129, 45, 'false'),
(6345, 129, 53, 'false'),
(6346, 129, 54, 'false'),
(6347, 130, 44, 'false'),
(6348, 130, 45, 'false'),
(6349, 130, 53, 'false'),
(6350, 130, 54, 'false'),
(6355, 131, 44, 'false'),
(6356, 131, 45, 'false'),
(6357, 131, 53, 'false'),
(6358, 131, 54, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_letter`
--

CREATE TABLE `i_ext_et_letter` (
  `iextel_id` int(11) NOT NULL,
  `iextel_cid` int(11) DEFAULT NULL,
  `iextel_txn_id` int(11) DEFAULT NULL,
  `iextel_date` date DEFAULT NULL,
  `iextel_file` varchar(100) DEFAULT NULL,
  `iextel_created` datetime DEFAULT NULL,
  `iextel_created_by` int(11) DEFAULT NULL,
  `iextel_modified` datetime DEFAULT NULL,
  `iextel_modified_by` int(11) DEFAULT NULL,
  `iextel_owner` int(11) DEFAULT NULL,
  `iextel_gid` int(11) DEFAULT NULL,
  `iextel_subject` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_letter`
--

INSERT INTO `i_ext_et_letter` (`iextel_id`, `iextel_cid`, `iextel_txn_id`, `iextel_date`, `iextel_file`, `iextel_created`, `iextel_created_by`, `iextel_modified`, `iextel_modified_by`, `iextel_owner`, `iextel_gid`, `iextel_subject`) VALUES
(1, 1, 1, '2019-02-23', '1550899749.txt', '2019-02-22 18:03:38', 188, '2019-02-23 10:59:09', 188, 188, 0, 'test subject');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_letter_details`
--

CREATE TABLE `i_ext_et_letter_details` (
  `iexteld_id` int(11) NOT NULL,
  `iexteld_l_id` int(11) DEFAULT NULL,
  `iexteld_d_val` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_letter_details`
--

INSERT INTO `i_ext_et_letter_details` (`iexteld_id`, `iexteld_l_id`, `iexteld_d_val`) VALUES
(20, 1, 'patole'),
(21, 1, 'krishnakant@evomata.com');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_mapping_txn`
--

CREATE TABLE `i_ext_et_mapping_txn` (
  `iextemt_id` int(11) NOT NULL,
  `iextemt_from_mid` int(11) DEFAULT NULL,
  `iextemt_from_txn` varchar(100) DEFAULT NULL,
  `iextemt_to_mid` int(11) DEFAULT NULL,
  `iextemt_to_txn` varchar(100) DEFAULT NULL,
  `iextemt_created` datetime DEFAULT NULL,
  `iextemt_created_by` int(11) DEFAULT NULL,
  `iextemt_owner` int(11) DEFAULT NULL,
  `iextemt_modified` datetime DEFAULT NULL,
  `iextemt_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_mapping_txn`
--

INSERT INTO `i_ext_et_mapping_txn` (`iextemt_id`, `iextemt_from_mid`, `iextemt_from_txn`, `iextemt_to_mid`, `iextemt_to_txn`, `iextemt_created`, `iextemt_created_by`, `iextemt_owner`, `iextemt_modified`, `iextemt_modified_by`) VALUES
(72, 66, '1', 35, '131', '2019-05-27 15:15:26', 1, 1, NULL, NULL),
(73, 35, '125', 66, '8', '2019-05-27 15:16:53', 1, 1, NULL, NULL),
(74, NULL, '12', NULL, 'undefined', '2019-06-10 15:39:35', 19, 19, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_mobile`
--

CREATE TABLE `i_ext_et_mobile` (
  `iextetm_id` int(11) NOT NULL,
  `iextetm_company_name` varchar(200) DEFAULT NULL,
  `iextetm_owner_id` int(11) DEFAULT NULL,
  `iextetm_login_function` varchar(200) DEFAULT NULL,
  `iextetm_verify_function` varchar(200) DEFAULT NULL,
  `iextetm_logo` varchar(200) DEFAULT NULL,
  `iextetm_created` datetime DEFAULT NULL,
  `iextetm_created_by` int(11) DEFAULT NULL,
  `iextetm_modified` datetime DEFAULT NULL,
  `iextetm_modified_by` int(11) DEFAULT NULL,
  `iextetm_color` varchar(200) DEFAULT NULL,
  `iextetm_feedback_type` varchar(100) DEFAULT NULL,
  `iextetm_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_mobile`
--

INSERT INTO `i_ext_et_mobile` (`iextetm_id`, `iextetm_company_name`, `iextetm_owner_id`, `iextetm_login_function`, `iextetm_verify_function`, `iextetm_logo`, `iextetm_created`, `iextetm_created_by`, `iextetm_modified`, `iextetm_modified_by`, `iextetm_color`, `iextetm_feedback_type`, `iextetm_gid`) VALUES
(1, 'cosmos', 19, 'Mobile_app/cosmos_login', 'cosmos_home', '11557127250.png', '2019-03-05 13:28:22', 0, '0000-00-00 00:00:00', 0, 'indigo-light_green.min.css', 'true', 36),
(4, 'Evomata', 19, 'evomata_login', 'evomata_home', 'logo.jpg', '2019-03-05 14:54:47', 0, '0000-00-00 00:00:00', 0, 'material.red-deep_orange.min.css', 'true', 55);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_mobile_cart`
--

CREATE TABLE `i_ext_et_mobile_cart` (
  `iextetmc_id` int(11) NOT NULL,
  `iextetmc_pid` int(11) DEFAULT NULL,
  `iextetmc_qty` int(11) DEFAULT NULL,
  `iextetmc_mobile_id` int(11) DEFAULT NULL,
  `iextetmc_owner` int(11) DEFAULT NULL,
  `iextetmc_created` datetime DEFAULT NULL,
  `iextetmc_created_by` int(11) DEFAULT NULL,
  `iextetmc_modified` datetime DEFAULT NULL,
  `iextetmc_modified_by` int(11) DEFAULT NULL,
  `iextetmc_status` varchar(100) DEFAULT NULL,
  `iextetmc_order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_mobile_cart`
--

INSERT INTO `i_ext_et_mobile_cart` (`iextetmc_id`, `iextetmc_pid`, `iextetmc_qty`, `iextetmc_mobile_id`, `iextetmc_owner`, `iextetmc_created`, `iextetmc_created_by`, `iextetmc_modified`, `iextetmc_modified_by`, `iextetmc_status`, `iextetmc_order_id`) VALUES
(5, 413, 10, 1, 1, '2019-05-21 18:47:56', 1, '2019-05-22 11:06:51', 1, 'true', 4),
(6, 413, 15, 1, 1, '2019-05-21 18:49:19', 1, '2019-05-22 11:06:51', 1, 'true', 4),
(7, 410, 10, 1, 1, '2019-05-22 11:22:07', 1, '2019-05-22 11:22:28', 1, 'true', 5),
(8, 413, 10, 1, 1, '2019-05-22 11:33:25', 1, '2019-05-22 11:33:39', 1, 'true', 9);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_mobile_users`
--

CREATE TABLE `i_ext_et_mobile_users` (
  `iextetmu_id` int(11) NOT NULL,
  `iextetmu_name` varchar(200) DEFAULT NULL,
  `iextetmu_email` varchar(200) DEFAULT NULL,
  `iextetmu_company` varchar(200) DEFAULT NULL,
  `iextetmu_phone_no` varchar(100) DEFAULT NULL,
  `iextetmu_gst_no` varchar(200) DEFAULT NULL,
  `iextetmu_address` varchar(200) DEFAULT NULL,
  `iextetmu_code` varchar(300) DEFAULT NULL,
  `iextetmu_owner` int(11) DEFAULT NULL,
  `iextetmu_created` datetime DEFAULT NULL,
  `iextetmu_created_by` int(11) DEFAULT NULL,
  `iextetmu_password` varchar(200) DEFAULT NULL,
  `iextetmu_status` varchar(100) DEFAULT NULL,
  `iextetmu_mobile_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity`
--

CREATE TABLE `i_ext_et_opportunity` (
  `iextetop_id` int(11) NOT NULL,
  `iextetop_title` varchar(200) DEFAULT NULL,
  `iextetop_cid` int(11) DEFAULT NULL,
  `iextetop_created` datetime DEFAULT NULL,
  `iextetop_created_by` int(11) DEFAULT NULL,
  `iextetop_modify` datetime DEFAULT NULL,
  `iextetop_modified_by` int(11) DEFAULT NULL,
  `iextetop_owner` int(11) DEFAULT NULL,
  `iextetop_status` varchar(200) DEFAULT NULL,
  `iextetop_gid` int(11) DEFAULT NULL,
  `iextetop_mutual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity`
--

INSERT INTO `i_ext_et_opportunity` (`iextetop_id`, `iextetop_title`, `iextetop_cid`, `iextetop_created`, `iextetop_created_by`, `iextetop_modify`, `iextetop_modified_by`, `iextetop_owner`, `iextetop_status`, `iextetop_gid`, `iextetop_mutual`) VALUES
(51, 'krishnakant', 1, '2019-03-02 12:57:37', 1, '2019-03-08 14:20:38', 1, 1, 'not intrested', 0, 1),
(52, 'krishnakant', 1, '2019-03-07 13:08:42', 1, '2019-03-08 17:43:35', 1, 1, 'done', 9, 0),
(53, 'kpatole', 2, '2019-03-08 14:51:17', 1, '2019-03-25 15:11:53', 1, 1, 'open', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_activity`
--

CREATE TABLE `i_ext_et_opportunity_activity` (
  `iexteoa_id` int(11) NOT NULL,
  `iexteoa_aid` int(11) DEFAULT NULL,
  `iexteoa_oppo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_activity`
--

INSERT INTO `i_ext_et_opportunity_activity` (`iexteoa_id`, `iexteoa_aid`, `iexteoa_oppo_id`) VALUES
(1, 41, 51),
(2, 42, 51),
(3, 43, 53),
(4, 44, 53),
(5, 51, 52),
(6, 5, 53);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_information`
--

CREATE TABLE `i_ext_et_opportunity_information` (
  `iexteoi_id` int(11) NOT NULL,
  `iexteoi_title` varchar(200) DEFAULT NULL,
  `iexteoi_oid` int(11) DEFAULT NULL,
  `iexteoi_created` datetime DEFAULT NULL,
  `iexteoi_created_by` int(11) DEFAULT NULL,
  `iexteoi_modify` datetime DEFAULT NULL,
  `iexteoi_modified_by` int(11) DEFAULT NULL,
  `iexteoi_owner` int(11) DEFAULT NULL,
  `iexteoi_content` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_information`
--

INSERT INTO `i_ext_et_opportunity_information` (`iexteoi_id`, `iexteoi_title`, `iexteoi_oid`, `iexteoi_created`, `iexteoi_created_by`, `iexteoi_modify`, `iexteoi_modified_by`, `iexteoi_owner`, `iexteoi_content`) VALUES
(1, 'asflkahsdkjfasdf', 41, '2018-12-24 17:12:22', 188, NULL, NULL, 188, '1545653062.txt'),
(2, 'awsdfa', 47, '2019-02-04 18:02:25', 188, NULL, NULL, 188, '1549283545.txt'),
(3, 'asdf', 47, '2019-02-04 18:07:49', 188, NULL, NULL, 188, '1549283869.txt'),
(4, 'asdf', 47, '2019-02-04 18:29:39', 188, NULL, NULL, 188, '1549285179.txt'),
(5, 'add', 47, '2019-02-04 18:33:14', 188, NULL, NULL, 188, '1549285394.txt'),
(6, 'tp', 47, '2019-02-04 18:34:46', 188, NULL, NULL, 188, '1549285486.txt'),
(7, 'testing', 47, '2019-02-05 09:28:44', 188, NULL, NULL, 188, '1549339124.txt'),
(8, 'testing', 47, '2019-02-05 09:48:46', 188, NULL, NULL, 188, '1549340326.txt'),
(9, 'testing', 47, '2019-02-05 09:49:31', 188, NULL, NULL, 188, '1549340371.txt'),
(10, 'test', 47, '2019-02-05 09:51:47', 188, NULL, NULL, 188, '1549340507.txt'),
(11, 'test', 47, '2019-02-05 09:53:27', 188, NULL, NULL, 188, '1549340607.txt'),
(12, '', 47, '2019-02-05 09:56:09', 188, NULL, NULL, 188, '1549340769.txt'),
(13, '', 47, '2019-02-05 09:57:16', 188, NULL, NULL, 188, '1549340836.txt'),
(14, '', 47, '2019-02-05 10:01:14', 188, NULL, NULL, 188, '1549341074.txt'),
(15, '', 47, '2019-02-05 10:11:55', 188, NULL, NULL, 188, '1549341715.txt'),
(16, '', 47, '2019-02-05 10:12:33', 188, NULL, NULL, 188, '1549341753.txt'),
(17, '', 47, '2019-02-05 10:21:57', 188, NULL, NULL, 188, '1549342317.txt'),
(18, '', 47, '2019-02-05 10:25:17', 188, NULL, NULL, 188, '1549342517.txt'),
(19, '', 47, '2019-02-05 10:35:27', 188, NULL, NULL, 188, '1549343127.txt'),
(20, 'sample', 47, '2019-02-05 11:40:31', 188, NULL, NULL, 188, '1549347031.txt'),
(21, 'sample', 47, '2019-02-05 11:44:26', 188, NULL, NULL, 188, '1549347266.txt'),
(22, 'sample', 47, '2019-02-05 11:46:41', 188, NULL, NULL, 188, '1549347401.txt'),
(23, 'sample', 47, '2019-02-05 11:49:45', 188, NULL, NULL, 188, '1549347585.txt'),
(24, 'sample', 47, '2019-02-05 12:05:49', 188, NULL, NULL, 188, '1549348549.txt'),
(25, 'test', 49, '2019-02-12 14:00:38', 188, NULL, NULL, 188, '1549960238.txt'),
(26, 'email test with attach', 50, '2019-02-13 13:13:00', 188, NULL, NULL, 188, '1550043780.txt'),
(27, 'esfd', 51, '2019-03-07 15:08:25', 1, NULL, NULL, 1, '1551951505.txt');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_information_files`
--

CREATE TABLE `i_ext_et_opportunity_information_files` (
  `iextetoif_id` int(11) NOT NULL,
  `iextetoif_filename` varchar(100) DEFAULT NULL,
  `iextetoif_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_information_files`
--

INSERT INTO `i_ext_et_opportunity_information_files` (`iextetoif_id`, `iextetoif_filename`, `iextetoif_oid`) VALUES
(1, '01538127079', 1),
(2, '01538457733', 1),
(3, '8', 1),
(4, '94', 1),
(5, 'pics1', 3),
(6, 'Logo', 3),
(7, 'IRENE | Home', 3),
(8, 'pics1', 4),
(9, 'Logo', 4),
(10, 'pics1', 5),
(11, 'Logo', 5),
(12, 'localhost : localhost : hsuvar5_irene : i_notifications | phpMyAdmin 4.8.0.1', 6),
(13, 'pics1', 7),
(14, 'Logo', 7),
(15, 'pics1', 8),
(16, 'Logo', 8),
(17, 'Logo', 9),
(18, 'pics1', 9),
(19, 'pics1', 10),
(20, 'Logo', 11),
(21, 'IRENE | Home', 11),
(22, 'pics1', 12),
(23, 'Logo', 12),
(24, 'Logo', 13),
(25, 'Logo', 14),
(26, 'pics1', 14),
(27, 'pics1', 15),
(28, 'material_icon', 17),
(29, 'Get Started with Dropbox', 17),
(30, 'Get Started with Dropbox', 17),
(31, 'material_icon', 18),
(32, 'Get Started with Dropbox', 18),
(33, 'Get Started with Dropbox', 18),
(34, '11th Sci Mum', 18),
(35, 'animation', 19),
(36, 'pics1', 20),
(37, 'Logo', 20),
(38, 'pics1', 21),
(39, 'Logo', 21),
(40, 'pics1', 22),
(41, 'Logo', 22),
(42, 'pics1', 23),
(43, 'Logo', 23),
(44, 'animation', 23),
(45, 'daifunc_home', 23),
(46, 'dhristi_manifest', 23),
(47, 'done2', 23),
(48, '11th Sci Mum', 23),
(49, 'daifunc_home', 24),
(50, 'dhristi_manifest', 24),
(51, '2-4-15-199', 25),
(52, '11th Sci Mum-3', 26),
(53, '11th Sci Mum', 26),
(54, '11th Sci Mum', 26),
(55, '11th Sci Mum-2', 27),
(56, '2 (1)', 27),
(57, '3', 27),
(58, '11th Sci Mum-3', 27),
(59, '11th Sci Mum', 27),
(60, '11th Sci Mum', 27),
(61, '11th Sci Mum-2', 28),
(62, '2 (1)', 28),
(63, '3', 28),
(64, '11th Sci Mum-3', 28),
(65, '11th Sci Mum', 28),
(66, '11th Sci Mum', 28),
(67, '11th Sci Mum-2', 29),
(68, 'dai_func1', 27),
(69, 'daifunc_function', 27),
(70, 'daifunc_logo 2', 27);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_likehood`
--

CREATE TABLE `i_ext_et_opportunity_likehood` (
  `iexteoh_id` int(11) NOT NULL,
  `iexteoh_rate` int(11) DEFAULT NULL,
  `iexteoh_oid` int(11) DEFAULT NULL,
  `iexteoh_created` date DEFAULT NULL,
  `iexteoh_created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_likehood`
--

INSERT INTO `i_ext_et_opportunity_likehood` (`iexteoh_id`, `iexteoh_rate`, `iexteoh_oid`, `iexteoh_created`, `iexteoh_created_by`) VALUES
(2, 4, 35, '2018-11-28', 188),
(3, 7, 35, '2018-11-28', 188),
(4, 9, 35, '2018-11-28', 188),
(5, 10, 35, '2018-11-28', 188),
(6, 1, 35, '2018-11-28', 188),
(7, 5, 35, '2018-11-28', 188),
(8, 5, 35, '2018-11-28', 188),
(9, 5, 35, '2018-11-28', 188),
(10, 5, 35, '2018-11-28', 188),
(11, 5, 35, '2018-11-28', 188),
(12, 5, 35, '2018-11-28', 188),
(13, 5, 35, '2018-11-28', 188),
(14, 5, 35, '2018-11-28', 188),
(15, 5, 35, '2018-11-28', 188),
(16, 4, 40, '2018-12-14', 188),
(17, 5, 40, '2018-12-14', 188),
(18, 7, 40, '2018-12-14', 188),
(19, 3, 40, '2018-12-14', 188),
(20, 9, 40, '2018-12-14', 188),
(21, 1, 40, '2018-12-14', 188),
(22, 10, 40, '2018-12-14', 188),
(23, 1, 40, '2018-12-14', 188),
(24, 0, 40, '2018-12-14', 188),
(25, 2, 41, '2018-12-19', 188),
(26, 6, 41, '2018-12-19', 188),
(27, 1, 41, '2018-12-19', 188),
(28, 2, 41, '2018-12-19', 188),
(29, 1, 41, '2018-12-19', 188),
(30, 1, 41, '2018-12-19', 188),
(31, 0, 41, '2018-12-19', 188),
(32, 7, 41, '2019-01-14', 188),
(33, 10, 41, '2019-01-14', 188),
(34, 2, 41, '2019-01-14', 188),
(35, 4, 48, '2019-02-13', 188),
(36, 5, 48, '2019-02-13', 188),
(37, 9, 48, '2019-02-13', 188),
(38, 4, 48, '2019-02-13', 188),
(39, 3, 48, '2019-02-13', 188),
(40, 10, 48, '2019-02-13', 188),
(41, 0, 48, '2019-02-13', 188),
(42, 1, 48, '2019-02-13', 188),
(43, 1, 48, '2019-02-13', 188),
(44, 4, 51, '2019-03-07', 1),
(45, 2, 51, '2019-03-07', 1),
(46, 1, 51, '2019-03-07', 1),
(47, 6, 51, '2019-03-07', 1),
(48, 10, 51, '2019-03-07', 1),
(49, 7, 51, '2019-03-07', 1),
(50, NULL, 51, '2019-03-07', 1),
(51, 8, 51, '2019-03-07', 1),
(52, 8, 51, '2019-03-07', 1),
(53, 10, 51, '2019-03-07', 1),
(54, NULL, 51, '2019-03-07', 1),
(55, NULL, 51, '2019-03-07', 1),
(56, 5, 51, '2019-03-07', 1),
(57, 7, 51, '2019-03-07', 1),
(58, 9, 51, '2019-03-07', 1),
(59, NULL, 51, '2019-03-07', 1),
(60, 9, 51, '2019-03-07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_mutual`
--

CREATE TABLE `i_ext_et_opportunity_mutual` (
  `iexteom_id` int(11) NOT NULL,
  `iexteom_op_id` int(11) DEFAULT NULL,
  `iexteom_uid` int(11) DEFAULT NULL,
  `iexteom_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_mutual`
--

INSERT INTO `i_ext_et_opportunity_mutual` (`iexteom_id`, `iexteom_op_id`, `iexteom_uid`, `iexteom_oid`) VALUES
(9, 35, 214, 188),
(10, 51, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_note`
--

CREATE TABLE `i_ext_et_opportunity_note` (
  `iexteon_id` int(11) NOT NULL,
  `iexteon_note` varchar(200) DEFAULT NULL,
  `iexteon_oid` int(11) DEFAULT NULL,
  `iexteon_created` datetime DEFAULT NULL,
  `iexteon_created_by` int(11) DEFAULT NULL,
  `iexteon_modify` datetime DEFAULT NULL,
  `iexteon_modified_by` int(11) DEFAULT NULL,
  `iexteon_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_note`
--

INSERT INTO `i_ext_et_opportunity_note` (`iexteon_id`, `iexteon_note`, `iexteon_oid`, `iexteon_created`, `iexteon_created_by`, `iexteon_modify`, `iexteon_modified_by`, `iexteon_owner`) VALUES
(4, '1st note', 35, '2018-11-28 12:11:06', 188, NULL, NULL, 188),
(5, 'Meeting had a discussion and seems interested in a product edit done', 41, '2018-12-19 17:12:53', 188, '2019-01-14 16:01:15', 188, 188),
(6, 'welcome to notes', 51, '2019-03-07 15:08:42', 1, NULL, NULL, 1),
(7, 'welcome to evomata', 53, '2019-03-25 15:11:46', 1, '2019-03-25 15:11:53', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_proposal`
--

CREATE TABLE `i_ext_et_opportunity_proposal` (
  `iexteop_id` int(11) NOT NULL,
  `iexteop_oppo_id` int(11) DEFAULT NULL,
  `iexteop_proposal_id` int(11) DEFAULT NULL,
  `iexteop_owner` int(11) DEFAULT NULL,
  `iexteop_created` datetime DEFAULT NULL,
  `iexteop_created_by` int(11) DEFAULT NULL,
  `iexteop_modify` datetime DEFAULT NULL,
  `iexteop_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_proposal`
--

INSERT INTO `i_ext_et_opportunity_proposal` (`iexteop_id`, `iexteop_oppo_id`, `iexteop_proposal_id`, `iexteop_owner`, `iexteop_created`, `iexteop_created_by`, `iexteop_modify`, `iexteop_modified_by`) VALUES
(1, 41, 64, 188, '2019-01-15 10:01:48', 188, NULL, NULL),
(2, 0, 1, 188, '2019-02-12 15:58:51', 188, NULL, NULL),
(3, 0, 2, 188, '2019-02-12 16:11:17', 188, NULL, NULL),
(4, 50, 3, 188, '2019-02-21 16:04:23', 188, NULL, NULL),
(5, 51, 4, 1, '2019-03-07 15:07:56', 1, NULL, NULL),
(6, NULL, 5, 1, '2019-04-04 18:20:48', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_opportunity_status`
--

CREATE TABLE `i_ext_et_opportunity_status` (
  `iexteos_id` int(11) NOT NULL,
  `iexteos_name` varchar(100) DEFAULT NULL,
  `iexteos_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_opportunity_status`
--

INSERT INTO `i_ext_et_opportunity_status` (`iexteos_id`, `iexteos_name`, `iexteos_owner`) VALUES
(23, 'done', 188),
(24, 'well done', 188),
(25, 'done', 1),
(26, 'can do', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_orders`
--

CREATE TABLE `i_ext_et_orders` (
  `iextetor_id` int(11) NOT NULL,
  `iextetor_customer_id` int(11) DEFAULT NULL,
  `iextetor_txn_id` varchar(100) DEFAULT NULL,
  `iextetor_type` varchar(100) DEFAULT NULL,
  `iextetor_note` varchar(500) DEFAULT NULL,
  `iextetor_date` date DEFAULT NULL,
  `iextetor_amount` varchar(100) DEFAULT NULL,
  `iextetor_status` varchar(200) DEFAULT NULL,
  `iextetor_owner` int(11) DEFAULT NULL,
  `iextetor_created` datetime DEFAULT NULL,
  `iextetor_created_by` int(11) DEFAULT NULL,
  `iextetor_modified` datetime DEFAULT NULL,
  `iextetor_modified_by` int(11) DEFAULT NULL,
  `iextetor_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_orders`
--

INSERT INTO `i_ext_et_orders` (`iextetor_id`, `iextetor_customer_id`, `iextetor_txn_id`, `iextetor_type`, `iextetor_note`, `iextetor_date`, `iextetor_amount`, `iextetor_status`, `iextetor_owner`, `iextetor_created`, `iextetor_created_by`, `iextetor_modified`, `iextetor_modified_by`, `iextetor_gid`) VALUES
(1, 2, '1', 'self', '', '2019-05-16', '2000', 'approved', 1, '2019-05-16 11:14:08', 1, '2019-05-21 20:12:16', 1, 0),
(4, 1, '2', 'mobile', NULL, '2019-05-22', '29500', 'pending', 1, '2019-05-22 11:06:51', 1, NULL, NULL, 31),
(5, 1, '3', 'self', '', '2019-05-22', '600', 'approved', 1, '2019-05-22 11:22:28', 1, '2019-05-22 11:28:36', 1, 31),
(8, 1, '4', 'self', '', '2019-05-22', '600', 'pending', 1, '2019-05-22 11:28:36', 1, '2019-05-22 11:28:55', 1, 31),
(9, 1, '5', 'mobile', NULL, '2019-05-22', '66080', 'pending', 1, '2019-05-22 11:33:39', 1, NULL, NULL, 31),
(10, 138, '1', 'self', 'welcome to order note', '2019-06-12', '2000', 'approved', 19, '2019-06-12 12:37:52', 22, NULL, NULL, 36),
(14, 138, '2', 'self', 'welcome to orders note', '2019-06-12', '2200', 'approved', 19, '2019-06-12 13:17:13', 22, NULL, NULL, 36),
(15, 138, '3', 'self', 'welcome to orders note', '2019-06-12', '11000', 'pending', 19, '2019-06-12 13:17:13', 22, '2019-06-12 13:18:15', 22, 36),
(16, 138, '4', 'self', 'welcome to orders note', '2019-06-12', '0', 'pending', 19, '2019-06-12 13:18:15', 22, NULL, NULL, 36),
(19, 138, '/EVO/5', 'self', '', '2019-06-19', '1452', 'approved', 19, '2019-06-19 10:25:35', 19, NULL, NULL, 36),
(20, 9, '1/OR/', 'self', '', '2019-06-20', '1500', 'approved', 4, '2019-06-20 12:40:39', 4, NULL, NULL, 4),
(21, 9, '/OR/2', 'self', '', '2019-06-20', '500', 'pending', 4, '2019-06-20 12:40:39', 4, '2019-06-20 12:43:24', 4, 4),
(22, 9, '/OR/3', 'self', '', '2019-06-20', '0', 'pending', 4, '2019-06-20 12:43:24', 4, NULL, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_orders_mutual`
--

CREATE TABLE `i_ext_et_orders_mutual` (
  `iextetorm_id` int(11) NOT NULL,
  `iextetorm_order_id` int(11) DEFAULT NULL,
  `iextetorm_uid` int(11) DEFAULT NULL,
  `iextetorm_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_orders_product_details`
--

CREATE TABLE `i_ext_et_orders_product_details` (
  `iextetodp_id` int(11) NOT NULL,
  `iextetodp_order_id` int(11) DEFAULT NULL,
  `iextetodp_pid` int(11) DEFAULT NULL,
  `iextetodp_modal_id` varchar(100) DEFAULT NULL,
  `iextetodp_serial_number` varchar(100) DEFAULT NULL,
  `iextetodp_rate` varchar(100) DEFAULT NULL,
  `iextetodp_qty` varchar(100) DEFAULT NULL,
  `iextetodp_approved_qty` varchar(100) DEFAULT NULL,
  `iextetodp_amount` varchar(100) DEFAULT NULL,
  `iextetodp_owner` int(11) DEFAULT NULL,
  `iextetodp_alias` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_orders_product_details`
--

INSERT INTO `i_ext_et_orders_product_details` (`iextetodp_id`, `iextetodp_order_id`, `iextetodp_pid`, `iextetodp_modal_id`, `iextetodp_serial_number`, `iextetodp_rate`, `iextetodp_qty`, `iextetodp_approved_qty`, `iextetodp_amount`, `iextetodp_owner`, `iextetodp_alias`) VALUES
(3, 1, 394, NULL, NULL, '1000', '12', '2', '2000', 1, 'false'),
(8, 4, 413, NULL, NULL, '1000', '10', '10', '10000', 1, 'false'),
(9, 4, 413, NULL, NULL, '1000', '15', '15', '15000', 1, 'false'),
(17, 5, 410, NULL, NULL, '120', '10', '5', '600', 1, 'false'),
(19, 8, 410, NULL, NULL, '120', '5', '5', '600', 1, 'false'),
(20, 9, 413, NULL, NULL, '1000', '10', '10', '10000', 1, 'false'),
(21, 10, 418, NULL, NULL, '10', '100', '100', '1000', 19, 'false'),
(22, 10, 419, NULL, NULL, '10', '100', '100', '1000', 19, 'false'),
(35, 14, 418, NULL, NULL, '12', '100', '100', '1200', 19, 'false'),
(36, 14, 419, NULL, NULL, '10', '100', '100', '1000', 19, 'false'),
(41, 15, 418, NULL, NULL, '12', '500', '500', '6000', 19, 'false'),
(42, 15, 419, NULL, NULL, '10', '500', '500', '5000', 19, 'false'),
(43, 16, 418, NULL, NULL, '12', '400', '400', '4800', 19, 'false'),
(44, 16, 419, NULL, NULL, '10', '400', '400', '4000', 19, 'false'),
(45, 19, 419, NULL, NULL, '121', '12', '12', '1452', 19, 'false'),
(46, 20, 422, NULL, NULL, '500', '3', '3', '1500', 4, 'false'),
(48, 21, 422, NULL, NULL, '500', '1', '1', '500', 4, 'false'),
(49, 22, 422, NULL, NULL, '500', '1', '1', '500', 4, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_orders_property`
--

CREATE TABLE `i_ext_et_orders_property` (
  `iextetorp_id` int(11) NOT NULL,
  `iextetorp_inid` int(11) DEFAULT NULL,
  `iextetorp_property_value` varchar(200) DEFAULT NULL,
  `iextetorp_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_orders_property`
--

INSERT INTO `i_ext_et_orders_property` (`iextetorp_id`, `iextetorp_inid`, `iextetorp_property_value`, `iextetorp_status`) VALUES
(3, 1, 'kpatole2@gmail.com', 'false'),
(6, 4, 'krishnakant@evomata.com', 'false'),
(14, 5, 'krishnakant@evomata.com', 'false'),
(16, 8, 'krishnakant@evomata.com', 'false'),
(17, 9, 'krishnakant@evomata.com', 'false'),
(18, 10, 'krishnakant@evomata.com', 'true'),
(25, 14, 'krishnakant@evomata.com', 'false'),
(28, 15, 'krishnakant@evomata.com', 'false'),
(29, 16, 'krishnakant@evomata.com', 'false'),
(31, 19, 'krishnakant@evomata.com', 'false'),
(32, 20, 'krishnakant@evomata.com', 'true'),
(34, 21, 'krishnakant@evomata.com', 'true'),
(35, 22, 'krishnakant@evomata.com', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_orders_terms`
--

CREATE TABLE `i_ext_et_orders_terms` (
  `iextetort_id` int(11) NOT NULL,
  `iextetort_inid` int(11) DEFAULT NULL,
  `iextetort_term_id` int(11) DEFAULT NULL,
  `iextetort_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_orders_terms`
--

INSERT INTO `i_ext_et_orders_terms` (`iextetort_id`, `iextetort_inid`, `iextetort_term_id`, `iextetort_status`) VALUES
(3, 1, 40, 'false'),
(6, 4, 40, 'false'),
(14, 5, 40, 'false'),
(16, 8, 40, 'false'),
(17, 9, 40, 'false'),
(18, 10, 65, 'true'),
(19, 10, 66, 'true'),
(20, 10, 67, 'false'),
(21, 10, 68, 'false'),
(46, 14, 65, 'true'),
(47, 14, 66, 'true'),
(48, 14, 67, 'true'),
(49, 14, 68, 'true'),
(58, 15, 65, 'true'),
(59, 15, 66, 'true'),
(60, 15, 67, 'true'),
(61, 15, 68, 'true'),
(62, 16, 65, 'true'),
(63, 16, 66, 'true'),
(64, 16, 67, 'true'),
(65, 16, 68, 'true'),
(74, 19, 65, 'true'),
(75, 19, 66, 'false'),
(76, 19, 67, 'false'),
(77, 19, 68, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_payment`
--

CREATE TABLE `i_ext_et_payment` (
  `iextepay_id` int(11) NOT NULL,
  `iextepay_tx_no` int(11) DEFAULT NULL,
  `iextepay_mode` varchar(200) DEFAULT NULL,
  `iextepay_date` date DEFAULT NULL,
  `iextepay_desc` varchar(500) DEFAULT NULL,
  `iextepay_amount` varchar(200) DEFAULT NULL,
  `iextepay_vno` varchar(500) DEFAULT NULL,
  `iextepay_oid` int(11) DEFAULT NULL,
  `iextepay_gid` int(11) DEFAULT NULL,
  `iextepay_created` datetime DEFAULT NULL,
  `iextepay_created_by` int(11) DEFAULT NULL,
  `iextepay_mid` int(11) DEFAULT NULL,
  `iextepay_mname` varchar(100) DEFAULT NULL,
  `iextepay_modified` datetime DEFAULT NULL,
  `iextepay_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_payment`
--

INSERT INTO `i_ext_et_payment` (`iextepay_id`, `iextepay_tx_no`, `iextepay_mode`, `iextepay_date`, `iextepay_desc`, `iextepay_amount`, `iextepay_vno`, `iextepay_oid`, `iextepay_gid`, `iextepay_created`, `iextepay_created_by`, `iextepay_mid`, `iextepay_mname`, `iextepay_modified`, `iextepay_modified_by`) VALUES
(1, 174, 'cash', '2018-12-06', 'asdf123', '100', 'asdf123', 188, 0, '2018-12-06 15:12:19', 188, 35, 'Invoice', '2018-12-06 17:12:06', 188),
(8, 175, 'cash', '2018-12-06', '12', '12', '12', 188, 0, '2018-12-06 17:12:21', 188, 35, 'Invoice', NULL, NULL),
(9, 175, 'cash', '2018-12-06', '12', '2.16', '12', 188, 0, '2018-12-06 17:12:35', 188, 35, 'Invoice', NULL, NULL),
(10, 174, 'cash', '2018-12-06', '1234', '41.6', '1234', 188, 0, '2018-12-06 17:12:32', 188, 35, 'Invoice', NULL, NULL),
(13, 31, 'cash', '2018-12-06', '123', '1000', '123', 188, 0, '2018-12-06 17:12:39', 188, 40, 'Purchase', '2018-12-06 17:12:41', 188),
(14, 31, 'cash', '2018-12-06', '123', '416', '12', 188, 0, '2018-12-06 17:12:33', 188, 40, 'Purchase', NULL, NULL),
(15, 190, 'Cheque', '2018-12-18', 'Bharat Bank, Kandivali East.', '200', '123456', 188, 0, '2018-12-18 18:12:42', 188, 35, 'Invoice', '2018-12-18 18:12:00', 188),
(16, 52, 'Cheque', '2018-12-19', 'kjchkjwelf', '1221', 'dhjgvsdv', 188, 0, '2018-12-19 16:12:09', 188, 40, 'Purchase', '2018-12-19 16:12:21', 188),
(17, 123, 'check', '2019-05-22', '123', '708', '123', 1, 31, '2019-05-22 11:50:57', 1, 36, 'Inventory', NULL, NULL),
(18, 123, 'check', '2019-05-22', '123', '708', '1234', 1, 31, '2019-05-22 11:51:22', 1, 36, 'Inventory', NULL, NULL),
(19, 123, '12', '2019-05-22', '12', '100', '12', 1, 31, '2019-05-22 11:52:15', 1, 36, 'Inventory', NULL, NULL),
(20, 123, '12', '2019-05-22', '12', '12', '12', 1, 31, '2019-05-22 11:52:31', 1, 36, 'Inventory', NULL, NULL),
(22, 123, '', '0000-00-00', '', '', '', 1, 31, '2019-05-22 11:57:23', 1, 36, 'Inventory', NULL, NULL),
(23, 123, '', '0000-00-00', '', '708', '', 1, 31, '2019-05-22 12:00:33', 1, 35, 'Invoice', NULL, NULL),
(24, 124, 'cash', '2019-05-27', '123', '10000', '123', 1, 0, '2019-05-27 11:16:53', 1, 68, 'Purchase_order', NULL, NULL),
(25, 124, 'cash', '2019-05-27', '123', '4160', '123', 1, 0, '2019-05-27 11:17:21', 1, 68, 'Purchase_order', NULL, NULL),
(26, 126, 'cash', '2019-05-27', '12', '118', '12', 1, 0, '2019-05-27 13:35:43', 1, 69, 'Credit_note', NULL, NULL),
(27, 127, 'cash', '2019-05-27', '12', '1180', '12', 1, 0, '2019-05-27 14:41:19', 1, 70, 'Debit_note', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_proposal`
--

CREATE TABLE `i_ext_et_proposal` (
  `iextepro_id` int(11) NOT NULL,
  `iextepro_customer_id` int(11) DEFAULT NULL,
  `iextepro_txn_id` varchar(100) DEFAULT NULL,
  `iextepro_txn_date` date DEFAULT NULL,
  `iextepro_type` varchar(100) DEFAULT NULL,
  `iextepro_amount` varchar(100) DEFAULT NULL,
  `iextepro_status` varchar(100) DEFAULT NULL,
  `iextepro_note` varchar(500) DEFAULT NULL,
  `iextepro_owner` int(11) DEFAULT NULL,
  `iextepro_created` datetime DEFAULT NULL,
  `iextepro_created_by` int(11) DEFAULT NULL,
  `iextepro_modified` datetime DEFAULT NULL,
  `iextepro_modified_by` int(11) DEFAULT NULL,
  `iextepro_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_proposal`
--

INSERT INTO `i_ext_et_proposal` (`iextepro_id`, `iextepro_customer_id`, `iextepro_txn_id`, `iextepro_txn_date`, `iextepro_type`, `iextepro_amount`, `iextepro_status`, `iextepro_note`, `iextepro_owner`, `iextepro_created`, `iextepro_created_by`, `iextepro_modified`, `iextepro_modified_by`, `iextepro_gid`) VALUES
(1, 1, 'EVO/2018-2019/1', '2019-02-12', 'formal', '169.92', 'open', '', 188, '2019-02-12 15:58:51', 188, '2019-02-13 10:34:57', 188, 0),
(2, 2, 'EVO/2018-2019/2', '2019-02-12', 'formal', '149.688', 'open', '', 188, '2019-02-12 16:11:17', 188, '2019-02-13 10:33:53', 188, 8),
(3, 1, '', '2019-02-21', 'formal', '0', 'open', '', 188, '2019-02-21 16:04:23', 188, NULL, NULL, 0),
(4, 1, '1234', '2019-03-07', 'formal', '12149.5296', 'open', 'Welcome note', 1, '2019-03-07 15:07:56', 1, '2019-04-25 15:46:50', 1, 0),
(5, 1, '123', '2019-04-02', 'formal', '132160', 'open', 'Any other accessories like EM lock, agress switch , power adopters if required at time of installation will charge extra', 1, '2019-04-04 18:20:48', 1, '2019-05-25 14:28:37', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_proposal_mutual`
--

CREATE TABLE `i_ext_et_proposal_mutual` (
  `iextepm_id` int(11) NOT NULL,
  `iextepm_pid` int(11) DEFAULT NULL,
  `iextepm_uid` int(11) DEFAULT NULL,
  `iextepm_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_proposal_product_details`
--

CREATE TABLE `i_ext_et_proposal_product_details` (
  `iexteprod_id` int(11) NOT NULL,
  `iexteprod_pro_id` int(11) DEFAULT NULL,
  `iexteprod_product_id` int(11) DEFAULT NULL,
  `iexteprod_model_number` varchar(100) DEFAULT NULL,
  `iexteprod_serial_number` varchar(100) DEFAULT NULL,
  `iexteprod_rate` float DEFAULT NULL,
  `iexteprod_qty` float DEFAULT NULL,
  `iexteprod_discount` varchar(10) DEFAULT NULL,
  `iexteprod_amount` float DEFAULT NULL,
  `iexteprod_tax` int(11) DEFAULT NULL,
  `iexteprod_tax_amount` float DEFAULT NULL,
  `iexteprod_alias` varchar(100) DEFAULT NULL,
  `iexteprod_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_proposal_product_details`
--

INSERT INTO `i_ext_et_proposal_product_details` (`iexteprod_id`, `iexteprod_pro_id`, `iexteprod_product_id`, `iexteprod_model_number`, `iexteprod_serial_number`, `iexteprod_rate`, `iexteprod_qty`, `iexteprod_discount`, `iexteprod_amount`, `iexteprod_tax`, `iexteprod_tax_amount`, `iexteprod_alias`, `iexteprod_owner`) VALUES
(42, 2, 393, NULL, NULL, 12, 12, '1', 144, 87, NULL, 'false', 188),
(44, 1, 393, NULL, NULL, 12, 12, '', 144, 88, NULL, 'false', 188),
(242, 4, 394, NULL, NULL, 1000, 12, '', 12000, 0, NULL, 'false', 1),
(243, 4, 396, NULL, NULL, 12, 12, '12', 144, 90, NULL, 'false', 1),
(244, 5, 413, NULL, NULL, 1000, 112, '', 112000, 90, NULL, 'false', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_proposal_property`
--

CREATE TABLE `i_ext_et_proposal_property` (
  `iexteppt_id` int(11) NOT NULL,
  `iexteppt_pid` int(11) DEFAULT NULL,
  `iexteppt_property_value` varchar(200) DEFAULT NULL,
  `iexteppt_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_proposal_property`
--

INSERT INTO `i_ext_et_proposal_property` (`iexteppt_id`, `iexteppt_pid`, `iexteppt_property_value`, `iexteppt_status`) VALUES
(41, 2, 'kpatole2@gmail.com', 'false'),
(43, 1, 'krishnakant@evomata.com', 'false'),
(44, 3, 'kpatole2@gmail.com', 'false'),
(45, 3, 'krishnakant@evomata.com', 'false'),
(70, 4, 'krishnakant@evomata.com', 'false'),
(71, 5, 'krishnakant@evomata.com', 'true'),
(72, 5, '18/48 harharwala bldg. n. m. joshi marg mumbai 400011.', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_proposal_terms`
--

CREATE TABLE `i_ext_et_proposal_terms` (
  `iexteptm_id` int(11) NOT NULL,
  `iexteptm_pid` int(11) DEFAULT NULL,
  `iexteptm_term_id` int(11) DEFAULT NULL,
  `iexteptm_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_proposal_terms`
--

INSERT INTO `i_ext_et_proposal_terms` (`iexteptm_id`, `iexteptm_pid`, `iexteptm_term_id`, `iexteptm_status`) VALUES
(133, 2, 4, 'false'),
(134, 2, 6, 'true'),
(135, 2, 7, 'true'),
(136, 2, 8, 'true'),
(137, 2, 9, 'true'),
(138, 2, 10, 'true'),
(139, 2, 11, 'true'),
(140, 2, 12, 'true'),
(141, 2, 13, 'true'),
(142, 2, 24, 'true'),
(143, 2, 36, 'false'),
(155, 1, 4, 'true'),
(156, 1, 6, 'false'),
(157, 1, 7, 'false'),
(158, 1, 8, 'false'),
(159, 1, 9, 'false'),
(160, 1, 10, 'false'),
(161, 1, 11, 'false'),
(162, 1, 12, 'false'),
(163, 1, 13, 'false'),
(164, 1, 24, 'false'),
(165, 1, 36, 'false'),
(166, 1, 37, 'true'),
(167, 3, 4, 'false'),
(168, 3, 6, 'false'),
(169, 3, 7, 'false'),
(170, 3, 8, 'false'),
(171, 3, 9, 'false'),
(172, 3, 10, 'false'),
(173, 3, 11, 'false'),
(174, 3, 12, 'false'),
(175, 3, 13, 'false'),
(176, 3, 24, 'false'),
(177, 3, 36, 'false'),
(178, 3, 37, 'false'),
(217, 4, 42, 'false'),
(218, 4, 43, 'false'),
(219, 4, 50, 'false'),
(220, 4, 51, 'false'),
(221, 5, 42, 'true'),
(222, 5, 43, 'true'),
(223, 5, 50, 'true'),
(224, 5, 51, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase`
--

CREATE TABLE `i_ext_et_purchase` (
  `iextep_id` int(11) NOT NULL,
  `iextep_customer_id` int(11) DEFAULT NULL,
  `iextep_txn_id` varchar(100) DEFAULT NULL,
  `iextep_txn_date` date DEFAULT NULL,
  `iextep_type` varchar(100) DEFAULT NULL,
  `iextep_amount` varchar(100) DEFAULT NULL,
  `iextep_status` varchar(100) DEFAULT NULL,
  `iextep_note` varchar(500) DEFAULT NULL,
  `iextep_owner` int(11) DEFAULT NULL,
  `iextep_created` datetime DEFAULT NULL,
  `iextep_created_by` int(11) DEFAULT NULL,
  `iextep_modified` datetime DEFAULT NULL,
  `iextep_modified_by` int(11) DEFAULT NULL,
  `iextep_gid` int(11) DEFAULT NULL,
  `iextep_warranty` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_purchase`
--

INSERT INTO `i_ext_et_purchase` (`iextep_id`, `iextep_customer_id`, `iextep_txn_id`, `iextep_txn_date`, `iextep_type`, `iextep_amount`, `iextep_status`, `iextep_note`, `iextep_owner`, `iextep_created`, `iextep_created_by`, `iextep_modified`, `iextep_modified_by`, `iextep_gid`, `iextep_warranty`) VALUES
(2, 20, '1', '2019-01-11', 'formal', '787.5', 'paid', 'stationary products', 188, '2019-01-11 20:01:10', 188, '2019-01-11 20:01:16', 188, 0, 24),
(3, 19, '1111', '2019-01-14', 'formal', '50', 'paid', '', 188, '2019-01-14 10:01:44', 188, '2019-01-14 10:01:02', 188, 0, 24),
(4, 20, '12', '2019-01-14', 'formal', '525', 'paid', '', 188, '2019-01-14 11:01:54', 188, '2019-01-14 11:01:04', 188, 0, 24),
(5, 21, 'EVO/2018-2019/4', '2019-01-14', 'formal', '1109.85', 'unpaid', '', 188, '2019-01-14 18:01:26', 188, '2019-01-14 18:01:48', 188, 0, 12),
(6, 20, '12', '2019-01-15', 'formal', NULL, 'paid', '', 188, '2019-01-15 11:01:34', 188, NULL, NULL, 0, 12),
(7, 20, '1234', '2019-01-23', 'formal', '0', 'paid', '', 188, '2019-01-23 17:01:39', 188, '2019-01-23 17:01:44', 188, 0, 24),
(8, 20, '1234', '2019-01-23', 'formal', '0', 'paid', '', 188, '2019-01-23 19:01:17', 188, '2019-01-23 19:01:21', 188, 0, 24),
(9, 20, '12', '2019-01-24', 'formal', '1050', 'negotiate', '', 188, '2019-01-24 12:01:19', 188, '2019-01-24 12:01:43', 188, 0, 12),
(10, 21, 'EVO/2018-2019/9', '2019-01-30', 'formal', '1108.8', 'unpaid', 'welcome to note', 188, '2019-01-30 17:01:34', 188, '2019-01-30 18:01:47', 188, 0, 12),
(11, 21, 'EVO/2018-2019/10', '2019-01-30', 'active', '7560', NULL, '', 188, '2019-01-30 17:01:58', 188, NULL, NULL, 0, 12),
(12, 1, 'EVO/2018-2019/11', '2019-02-12', 'formal', '133.056', 'unpaid', '', 188, '2019-02-12 13:44:48', 188, '2019-02-12 13:55:00', 188, 0, 12),
(13, 110, '2', '2019-05-25', 'formal', '11800', 'negotiate', '', 1, '2019-05-25 15:10:40', 1, '2019-05-25 15:11:03', 1, 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase_inventory_map`
--

CREATE TABLE `i_ext_et_purchase_inventory_map` (
  `iextepim_id` int(11) NOT NULL,
  `iextepim_purchase_id` int(11) DEFAULT NULL,
  `iextepim_inventory_id` int(11) DEFAULT NULL,
  `iextepim_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase_mutual`
--

CREATE TABLE `i_ext_et_purchase_mutual` (
  `iexteprcm_id` int(11) NOT NULL,
  `iexteprcm_pid` int(11) DEFAULT NULL,
  `iexteprcm_uid` int(11) DEFAULT NULL,
  `iexteprcm_oid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase_product_details`
--

CREATE TABLE `i_ext_et_purchase_product_details` (
  `iexteppd_id` int(11) NOT NULL,
  `iexteppd_d_id` int(11) DEFAULT NULL,
  `iexteppd_product_id` int(11) DEFAULT NULL,
  `iexteppd_model_number` varchar(100) DEFAULT NULL,
  `iexteppd_serial_number` varchar(100) DEFAULT NULL,
  `iexteppd_rate` float DEFAULT NULL,
  `iexteppd_qty` float DEFAULT NULL,
  `iexteppd_discount` varchar(10) DEFAULT NULL,
  `iexteppd_amount` float DEFAULT NULL,
  `iexteppd_tax` int(11) DEFAULT NULL,
  `iexteppd_tax_amount` float DEFAULT NULL,
  `iexteppd_alias` varchar(100) DEFAULT NULL,
  `iexteppd_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_purchase_product_details`
--

INSERT INTO `i_ext_et_purchase_product_details` (`iexteppd_id`, `iexteppd_d_id`, `iexteppd_product_id`, `iexteppd_model_number`, `iexteppd_serial_number`, `iexteppd_rate`, `iexteppd_qty`, `iexteppd_discount`, `iexteppd_amount`, `iexteppd_tax`, `iexteppd_tax_amount`, `iexteppd_alias`, `iexteppd_owner`) VALUES
(28, 3, 257, NULL, '13', 10, 1, '', 10, 74, NULL, NULL, 188),
(20, 2, 266, NULL, '8901198012269', 150, 1, '', 150, 87, NULL, NULL, 188),
(19, 2, 266, NULL, '8901324036770', 150, 1, '', 150, 87, NULL, NULL, 188),
(18, 2, 266, NULL, '8901361303477', 150, 1, '', 150, 87, NULL, NULL, 188),
(17, 2, 266, NULL, '8901425011676', 150, 1, '', 150, 87, NULL, NULL, 188),
(16, 2, 266, NULL, '8901324017359', 150, 1, '', 150, 87, NULL, NULL, 188),
(27, 3, 257, NULL, '12', 10, 1, '', 10, 74, NULL, NULL, 188),
(26, 3, 257, NULL, '11', 10, 1, '', 10, 74, NULL, NULL, 188),
(29, 3, 257, NULL, '14', 10, 1, '', 10, 74, NULL, NULL, 188),
(30, 3, 257, NULL, '15', 10, 1, '', 10, 74, NULL, NULL, 188),
(38, 4, 263, NULL, '113', 100, 1, '', 100, 87, NULL, NULL, 188),
(37, 4, 263, NULL, '111', 100, 1, '', 100, 87, NULL, NULL, 188),
(36, 4, 263, NULL, '112', 100, 1, '', 100, 87, NULL, NULL, 188),
(39, 4, 263, NULL, '114', 100, 1, '', 100, 87, NULL, NULL, 188),
(40, 4, 263, NULL, '115', 100, 1, '', 100, 87, NULL, NULL, 188),
(44, 5, 255, NULL, '12', 100, 12, '12', 1200, 87, NULL, 'true', 188),
(43, 5, 270, NULL, '112', 1, 1, '', 1, 87, NULL, 'true', 188),
(45, 6, 255, NULL, '12', 100, 1, NULL, 100, 87, NULL, NULL, 188),
(46, 6, 255, NULL, '11', 100, 1, NULL, 100, 87, NULL, NULL, 188),
(47, 6, 271, NULL, '11', NULL, 1, NULL, 0, NULL, NULL, NULL, 188),
(49, 7, 273, NULL, '', 0, 10, '', 0, 0, NULL, '', 188),
(51, 8, 273, NULL, '', 0, 10, '', 0, 0, NULL, '', 188),
(53, 9, 274, NULL, '', 100, 10, '', 1000, 87, NULL, '', 188),
(62, 10, 276, NULL, '12', 100, 12, '12', 1200, 87, NULL, 'true', 188),
(58, 11, 258, NULL, '', 600, 12, '', 7200, 87, NULL, 'false', 188),
(73, 12, 393, NULL, '12', 12, 12, '12', 144, 87, NULL, 'false', 188),
(75, 13, 414, NULL, '', 100, 100, '', 10000, 90, NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase_product_taxes`
--

CREATE TABLE `i_ext_et_purchase_product_taxes` (
  `iexteppt_id` int(11) NOT NULL,
  `iexteppt_d_id` int(11) DEFAULT NULL,
  `iexteppt_p_id` int(11) DEFAULT NULL,
  `iexteppt_t_id` int(11) DEFAULT NULL,
  `iexteppt_t_name` varchar(100) DEFAULT NULL,
  `iexteppt_t_percent` float DEFAULT NULL,
  `iexteppt_t_amount` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase_property`
--

CREATE TABLE `i_ext_et_purchase_property` (
  `iexteprpt_id` int(11) NOT NULL,
  `iexteprpt_inid` int(11) DEFAULT NULL,
  `iexteprpt_property_value` varchar(200) DEFAULT NULL,
  `iexteprpt_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_purchase_property`
--

INSERT INTO `i_ext_et_purchase_property` (`iexteprpt_id`, `iexteprpt_inid`, `iexteprpt_property_value`, `iexteprpt_status`) VALUES
(22, 2, 'vinayalokhande1993@gmail.com', 'false'),
(23, 2, '400011', 'false'),
(24, 2, 'maharashtra', 'false'),
(25, 2, '2227794086', 'false'),
(26, 2, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(27, 2, '400708', 'false'),
(28, 2, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(34, 3, '9821406714', 'false'),
(35, 3, 'Maharashtra', 'false'),
(36, 3, '400011', 'false'),
(37, 3, 'Lower Parel, Mumbai', 'false'),
(38, 3, 'kpatole2@gmail.com', 'false'),
(46, 4, 'vinayalokhande1993@gmail.com', 'false'),
(47, 4, '400011', 'false'),
(48, 4, 'maharashtra', 'false'),
(49, 4, '2227794086', 'false'),
(50, 4, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(51, 4, '400708', 'false'),
(52, 4, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(54, 5, 'krishnakant@evomata.com', 'false'),
(55, 6, 'vinayalokhande1993@gmail.com', 'false'),
(56, 6, '400011', 'false'),
(57, 6, 'maharashtra', 'false'),
(58, 6, '2227794086', 'false'),
(59, 6, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(60, 6, '400708', 'false'),
(61, 6, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(69, 7, 'vinayalokhande1993@gmail.com', 'false'),
(70, 7, '400011', 'false'),
(71, 7, 'maharashtra', 'false'),
(72, 7, '2227794086', 'false'),
(73, 7, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(74, 7, '400708', 'false'),
(75, 7, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(83, 8, 'vinayalokhande1993@gmail.com', 'false'),
(84, 8, '400011', 'false'),
(85, 8, 'maharashtra', 'false'),
(86, 8, '2227794086', 'false'),
(87, 8, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(88, 8, '400708', 'false'),
(89, 8, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(97, 9, 'vinayalokhande1993@gmail.com', 'false'),
(98, 9, '400011', 'false'),
(99, 9, 'maharashtra', 'false'),
(100, 9, '2227794086', 'false'),
(101, 9, 'BINDUMADV NAGAR DIGHA NAVI MUMBAI', 'false'),
(102, 9, '400708', 'false'),
(103, 9, 'HINDAMATA VIDYLAYA THANE BELAPUR ROAD DIGHA', 'false'),
(108, 11, 'krishnakant@evomata.com', 'true'),
(112, 10, 'krishnakant@evomata.com', 'false'),
(123, 12, 'krishnakant@evomata.com', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase_tags`
--

CREATE TABLE `i_ext_et_purchase_tags` (
  `iextept_id` int(11) NOT NULL,
  `iextept_txn_id` int(11) DEFAULT NULL,
  `iextept_tag_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_purchase_terms`
--

CREATE TABLE `i_ext_et_purchase_terms` (
  `iexteprtm_id` int(11) NOT NULL,
  `iexteprtm_inid` int(11) DEFAULT NULL,
  `iexteprtm_term_id` int(11) DEFAULT NULL,
  `iexteprtm_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_purchase_terms`
--

INSERT INTO `i_ext_et_purchase_terms` (`iexteprtm_id`, `iexteprtm_inid`, `iexteprtm_term_id`, `iexteprtm_status`) VALUES
(1, 12, 34, 'true'),
(2, 12, 35, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_quotation`
--

CREATE TABLE `i_ext_et_quotation` (
  `iexteq_id` int(11) NOT NULL,
  `iexteq_customer_id` int(11) DEFAULT NULL,
  `iexteq_txn_id` varchar(100) DEFAULT NULL,
  `iexteq_txn_date` date DEFAULT NULL,
  `iexteq_type` varchar(100) DEFAULT NULL,
  `iexteq_amount` varchar(100) DEFAULT NULL,
  `iexteq_status` varchar(100) DEFAULT NULL,
  `iexteq_note` varchar(500) DEFAULT NULL,
  `iexteq_owner` int(11) DEFAULT NULL,
  `iexteq_created` datetime DEFAULT NULL,
  `iexteq_created_by` int(11) DEFAULT NULL,
  `iexteq_modified` datetime DEFAULT NULL,
  `iexteq_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_quotation`
--

INSERT INTO `i_ext_et_quotation` (`iexteq_id`, `iexteq_customer_id`, `iexteq_txn_id`, `iexteq_txn_date`, `iexteq_type`, `iexteq_amount`, `iexteq_status`, `iexteq_note`, `iexteq_owner`, `iexteq_created`, `iexteq_created_by`, `iexteq_modified`, `iexteq_modified_by`) VALUES
(18, 290, '121212', '2018-07-18', 'active', '141.6', 'open', '', 6, '2018-07-19 14:07:44', 6, NULL, NULL),
(19, 301, '1234', '2018-07-19', 'active', '1353', 'discuss', '', 6, '2018-07-19 14:07:41', 6, NULL, NULL),
(20, 8882, '123412', '2018-07-19', 'active', '118', 'draft', '', 6, '2018-07-19 16:07:23', 6, NULL, NULL),
(21, 8878, '1', '2018-08-28', 'active', '0', 'open', '', 6, '2018-08-28 14:08:45', 6, NULL, NULL),
(22, 8892, '', '2018-08-30', 'active', '0', NULL, '', 153, '2018-08-30 12:08:15', 153, NULL, NULL),
(23, 8893, '', '2018-08-30', 'active', '0', NULL, '', 153, '2018-08-30 12:08:18', 153, NULL, NULL),
(24, 13, '12', '2018-09-22', 'active', '0', NULL, '', 179, '2018-09-22 12:09:33', 179, NULL, NULL),
(25, 21, '', '2018-09-22', 'active', '0', NULL, '', 6, '2018-09-22 12:09:19', 6, NULL, NULL),
(26, 22, '', '2018-09-22', 'active', '0', NULL, '', 6, '2018-09-22 13:09:03', 6, NULL, NULL),
(27, 22, '123', '2018-09-22', 'active', '0', NULL, '', 6, '2018-09-22 13:09:20', 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_quotation_product_details`
--

CREATE TABLE `i_ext_et_quotation_product_details` (
  `iexteqpd_id` int(11) NOT NULL,
  `iexteqpd_d_id` int(11) DEFAULT NULL,
  `iexteqpd_product_id` int(11) DEFAULT NULL,
  `iexteqpd_model_number` varchar(100) DEFAULT NULL,
  `iexteqpd_serial_number` varchar(100) DEFAULT NULL,
  `iexteqpd_rate` float DEFAULT NULL,
  `iexteqpd_qty` float DEFAULT NULL,
  `iexteqpd_discount` varchar(10) DEFAULT NULL,
  `iexteqpd_amount` float DEFAULT NULL,
  `iexteqpd_tax` int(11) DEFAULT NULL,
  `iexteqpd_tax_amount` float DEFAULT NULL,
  `iexteqpd_alias` varchar(100) DEFAULT NULL,
  `iexteqpd_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_quotation_product_details`
--

INSERT INTO `i_ext_et_quotation_product_details` (`iexteqpd_id`, `iexteqpd_d_id`, `iexteqpd_product_id`, `iexteqpd_model_number`, `iexteqpd_serial_number`, `iexteqpd_rate`, `iexteqpd_qty`, `iexteqpd_discount`, `iexteqpd_amount`, `iexteqpd_tax`, `iexteqpd_tax_amount`, `iexteqpd_alias`, `iexteqpd_owner`) VALUES
(713, 18, 219, NULL, NULL, 10, 12, '', 120, 7, NULL, 'false', 6),
(698, 19, 219, NULL, NULL, 11, 123, '', 1353, 6, NULL, 'false', 6),
(718, 20, 219, NULL, NULL, 10, 10, '', 100, 7, NULL, 'false', 6),
(717, 41, 219, NULL, NULL, 10, 10, '', 100, 7, NULL, 'false', 6),
(725, 21, 219, NULL, NULL, 10, 0, '', 0, 0, NULL, 'false', 6),
(724, 21, 237, NULL, NULL, 1, 1, '1', 0, 0, NULL, 'false', 6),
(726, 22, 242, NULL, NULL, 0, 0, '', 0, 0, NULL, 'false', 153),
(727, 22, 242, NULL, NULL, 0, 0, '', 0, 0, NULL, 'false', 153),
(728, 22, 242, NULL, NULL, 0, 0, '', 0, 0, NULL, 'false', 153),
(729, 23, 242, NULL, NULL, 0, 0, '', 0, 0, NULL, 'false', 153),
(730, 23, 242, NULL, NULL, 0, 0, '', 0, 0, NULL, 'false', 153),
(731, 23, 242, NULL, NULL, 0, 0, '', 0, 0, NULL, 'false', 153);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_quotation_product_taxes`
--

CREATE TABLE `i_ext_et_quotation_product_taxes` (
  `iexteqpt_id` int(11) NOT NULL,
  `iexteqpt_d_id` int(11) DEFAULT NULL,
  `iexteqpt_p_id` int(11) DEFAULT NULL,
  `iexteqpt_t_id` int(11) DEFAULT NULL,
  `iexteqpt_t_name` varchar(100) DEFAULT NULL,
  `iexteqpt_t_percent` float DEFAULT NULL,
  `iexteqpt_t_amount` float DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_quotation_product_taxes`
--

INSERT INTO `i_ext_et_quotation_product_taxes` (`iexteqpt_id`, `iexteqpt_d_id`, `iexteqpt_p_id`, `iexteqpt_t_id`, `iexteqpt_t_name`, `iexteqpt_t_percent`, `iexteqpt_t_amount`) VALUES
(1086, 20, 718, 15, 'SGST 9%', 9, 9),
(1085, 20, 718, 14, 'CGST 9%', 9, 9),
(1076, 18, 713, 15, 'SGST 9%', 9, 10.8),
(1075, 18, 713, 14, 'CGST 9%', 9, 10.8),
(1083, 41, 717, 14, 'CGST 9%', 9, 9),
(1084, 41, 717, 15, 'SGST 9%', 9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_quotation_tags`
--

CREATE TABLE `i_ext_et_quotation_tags` (
  `iexteqt_id` int(11) NOT NULL,
  `iexteqt_txn_id` int(11) DEFAULT NULL,
  `iexteqt_tag_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_quotation_terms`
--

CREATE TABLE `i_ext_et_quotation_terms` (
  `iexteqtm_id` int(11) NOT NULL,
  `iexteqtm_q_id` int(11) DEFAULT NULL,
  `iexteqtm_terms` varchar(500) DEFAULT NULL,
  `iexteqtm_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_requirement`
--

CREATE TABLE `i_ext_et_requirement` (
  `iextetr_id` int(11) NOT NULL,
  `iextetr_title` varchar(200) DEFAULT NULL,
  `iextetr_type` varchar(100) DEFAULT NULL,
  `iextetr_type_id` int(11) DEFAULT NULL,
  `iextetr_owner` int(11) DEFAULT NULL,
  `iextetr_created` datetime DEFAULT NULL,
  `iextetr_created_by` int(11) DEFAULT NULL,
  `iextetr_modified` datetime DEFAULT NULL,
  `iextetr_modified_by` int(11) DEFAULT NULL,
  `iextetr_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_requirement`
--

INSERT INTO `i_ext_et_requirement` (`iextetr_id`, `iextetr_title`, `iextetr_type`, `iextetr_type_id`, `iextetr_owner`, `iextetr_created`, `iextetr_created_by`, `iextetr_modified`, `iextetr_modified_by`, `iextetr_gid`) VALUES
(6, 'kpatole', 'contact', 2, 1, '2019-03-05 13:37:09', 1, '2019-04-10 11:09:02', 1, 0),
(7, 'krishnakant', 'oppo', 51, 1, '2019-03-05 13:37:35', 1, '2019-03-08 16:04:31', 1, 0),
(11, 'krishnakant', 'oppo', 51, 1, '2019-03-05 14:55:51', 1, '2019-03-05 16:29:01', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_requirement_mutual`
--

CREATE TABLE `i_ext_et_requirement_mutual` (
  `iextetrm_id` int(11) NOT NULL,
  `iextetrm_req_id` int(11) DEFAULT NULL,
  `iextetrm_uid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_requirement_mutual`
--

INSERT INTO `i_ext_et_requirement_mutual` (`iextetrm_id`, `iextetrm_req_id`, `iextetrm_uid`) VALUES
(16, 6, 1),
(17, 6, 2),
(18, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_requirement_notes`
--

CREATE TABLE `i_ext_et_requirement_notes` (
  `iextetrn_id` int(11) NOT NULL,
  `iextetrn_req_id` int(11) DEFAULT NULL,
  `iextetrn_type` varchar(100) DEFAULT NULL,
  `iextetrn_content` varchar(200) DEFAULT NULL,
  `iextetrn_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_requirement_notes`
--

INSERT INTO `i_ext_et_requirement_notes` (`iextetrn_id`, `iextetrn_req_id`, `iextetrn_type`, `iextetrn_content`, `iextetrn_date`) VALUES
(1, 11, 'note', 'welcome bro', '2019-03-05 15:51:39'),
(2, 11, 'file', '01551781299.svg', '2019-03-05 15:51:39'),
(3, 11, 'file', '11551781299.svg', '2019-03-05 15:51:39'),
(4, 11, 'file', '21551781299.svg', '2019-03-05 15:51:39'),
(5, 11, 'file', '31551781299.svg', '2019-03-05 15:51:39'),
(6, 11, 'file', '41551781299.svg', '2019-03-05 15:51:39'),
(7, 11, 'file', '51551781299.svg', '2019-03-05 15:51:39'),
(8, 11, 'file', '61551781299.gif', '2019-03-05 15:51:39'),
(9, 11, 'file', '71551781299.png', '2019-03-05 15:51:39'),
(10, 11, 'file', '81551781299.png', '2019-03-05 15:51:39'),
(11, 11, 'file', '91551781299.png', '2019-03-05 15:51:39'),
(12, 11, 'file', '101551781299.png', '2019-03-05 15:51:39'),
(13, 11, 'file', '111551781299.png', '2019-03-05 15:51:39'),
(14, 11, 'file', '121551781299.svg', '2019-03-05 15:51:39'),
(15, 11, 'file', '131551781299.png', '2019-03-05 15:51:39'),
(16, 11, 'note', 'welcome to india', '2019-03-05 16:01:30'),
(17, 11, 'file', '01551781914.png', '2019-03-05 16:01:54'),
(18, 11, 'file', '11551781914.svg', '2019-03-05 16:01:54'),
(19, 11, 'file', '21551781914.png', '2019-03-05 16:01:54'),
(20, 11, 'file', '31551781914.png', '2019-03-05 16:01:54'),
(21, 11, 'note', 'lskdfngasnfmsafd', '2019-03-05 16:03:03'),
(22, 11, 'file', '01551781996.png', '2019-03-05 16:03:16'),
(23, 11, 'file', '11551781996.png', '2019-03-05 16:03:16'),
(24, 11, 'file', '21551781996.svg', '2019-03-05 16:03:16'),
(25, 11, 'file', '31551781996.png', '2019-03-05 16:03:16'),
(26, 11, 'file', '41551781996.png', '2019-03-05 16:03:16'),
(27, 11, 'file', '51551781996.svg', '2019-03-05 16:03:16'),
(28, 11, 'file', '61551781996.svg', '2019-03-05 16:03:16'),
(29, 11, 'file', '71551781996.png', '2019-03-05 16:03:16'),
(30, 6, 'file', '01552039098.png', '2019-03-08 15:28:18'),
(31, 6, 'file', '11552039098.svg', '2019-03-08 15:28:18'),
(32, 6, 'file', '21552039098.png', '2019-03-08 15:28:18'),
(33, 6, 'file', '31552039098.png', '2019-03-08 15:28:18'),
(34, 6, 'file', '41552039098.svg', '2019-03-08 15:28:18'),
(35, 7, 'file', '01552041271.xls', '2019-03-08 16:04:31'),
(36, 7, 'file', '11552041271.xlsx', '2019-03-08 16:04:31'),
(37, 7, 'file', '21552041271.', '2019-03-08 16:04:31'),
(38, 6, 'file', '01554874606.jpg', '2019-04-10 11:06:46'),
(39, 6, 'file', '01554874616.xls', '2019-04-10 11:06:56'),
(40, 6, 'file', '01554874719.', '2019-04-10 11:08:39'),
(41, 6, 'file', '01554874731.jpg', '2019-04-10 11:08:51'),
(42, 6, 'file', '01554874742.svg', '2019-04-10 11:09:02'),
(43, 6, 'file', '11554874742.svg', '2019-04-10 11:09:02'),
(44, 6, 'file', '21554874742.sql', '2019-04-10 11:09:02'),
(45, 6, 'file', '31554874742.svg', '2019-04-10 11:09:02');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_requirement_product`
--

CREATE TABLE `i_ext_et_requirement_product` (
  `iextetrp_id` int(11) NOT NULL,
  `iextetrp_req_id` int(11) DEFAULT NULL,
  `iextetrp_product_id` int(11) DEFAULT NULL,
  `iextetrp_qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_requirement_product`
--

INSERT INTO `i_ext_et_requirement_product` (`iextetrp_id`, `iextetrp_req_id`, `iextetrp_product_id`, `iextetrp_qty`) VALUES
(15, 11, 410, 123),
(28, 7, 395, 101),
(29, 7, 396, 101),
(38, 6, 395, 10),
(39, 6, 396, 10);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_work_module`
--

CREATE TABLE `i_ext_et_work_module` (
  `iextetwm_id` int(11) NOT NULL,
  `iextetwm_title` varchar(500) DEFAULT NULL,
  `iextetwm_owner` int(11) DEFAULT NULL,
  `iextetwm_created` datetime DEFAULT NULL,
  `iextetwm_created_by` int(11) DEFAULT NULL,
  `iextetwm_modified` datetime DEFAULT NULL,
  `iextetwm_modified_by` int(11) DEFAULT NULL,
  `iextetwm_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_work_module`
--

INSERT INTO `i_ext_et_work_module` (`iextetwm_id`, `iextetwm_title`, `iextetwm_owner`, `iextetwm_created`, `iextetwm_created_by`, `iextetwm_modified`, `iextetwm_modified_by`, `iextetwm_gid`) VALUES
(1, 'Supply System', 1, '2019-04-03 15:01:59', 1, '2019-04-19 10:41:23', 1, 0),
(3, 'work allot', 1, '2019-04-04 16:09:43', 1, NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_work_module_activity`
--

CREATE TABLE `i_ext_et_work_module_activity` (
  `iextetwma_id` int(11) NOT NULL,
  `iextetwma_wm_id` int(11) DEFAULT NULL,
  `iextetwma_title` varchar(500) DEFAULT NULL,
  `iextetwma_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_work_module_activity`
--

INSERT INTO `i_ext_et_work_module_activity` (`iextetwma_id`, `iextetwma_wm_id`, `iextetwma_title`, `iextetwma_owner`) VALUES
(46, 3, 'work allot 1', NULL),
(47, 3, 'work allot 2', NULL),
(48, 3, 'work allot 3', NULL),
(49, 3, 'work allot 4', NULL),
(50, 1, 'Total no of fixture connected', NULL),
(51, 1, 'Requirement ', NULL),
(52, 1, 'Requirement Of water supply', NULL),
(53, 1, 'water storage calculation', NULL),
(54, 1, 'underground sump sizing', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_et_work_module_allot`
--

CREATE TABLE `i_ext_et_work_module_allot` (
  `iextetwma_id` int(11) NOT NULL,
  `iextetwma_wm_id` int(11) DEFAULT NULL,
  `iextetwma_uid` int(11) DEFAULT NULL,
  `iextetwma_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_et_work_module_allot`
--

INSERT INTO `i_ext_et_work_module_allot` (`iextetwma_id`, `iextetwma_wm_id`, `iextetwma_uid`, `iextetwma_date`) VALUES
(1, 3, 2, '2019-04-04 00:00:00'),
(2, 3, 3, '2019-04-04 00:00:00'),
(3, 1, 1, '2019-04-19 10:41:35'),
(4, 1, 3, '2019-04-19 10:42:07'),
(5, 1, 2, '2019-04-19 10:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_product_list`
--

CREATE TABLE `i_ext_pro_product_list` (
  `iextppl_id` int(11) NOT NULL,
  `iextppl_product_id` int(11) DEFAULT NULL,
  `iextppl_rate` varchar(100) DEFAULT NULL,
  `iextppl_qty` varchar(100) DEFAULT NULL,
  `iextppl_project_id` int(11) DEFAULT NULL,
  `iextppl_project_group` int(11) DEFAULT NULL,
  `iextppl_owner` int(11) DEFAULT NULL,
  `iextppl_created` datetime DEFAULT NULL,
  `iextppl_created_by` int(11) DEFAULT NULL,
  `iextppl_modify` datetime DEFAULT NULL,
  `iextppl_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_pro_product_list`
--

INSERT INTO `i_ext_pro_product_list` (`iextppl_id`, `iextppl_product_id`, `iextppl_rate`, `iextppl_qty`, `iextppl_project_id`, `iextppl_project_group`, `iextppl_owner`, `iextppl_created`, `iextppl_created_by`, `iextppl_modify`, `iextppl_modified_by`) VALUES
(10, 255, '100', '1', 13, 55, 188, '2019-01-28 12:01:49', 188, NULL, NULL),
(11, 273, '100', '10', 13, 56, 188, '2019-01-28 12:01:24', 188, NULL, NULL),
(14, 270, '12', '12', 13, 54, 188, '2019-01-28 16:01:53', 188, NULL, NULL),
(16, 273, '10', '10', 19, 62, 188, '2019-01-28 17:01:36', 188, NULL, NULL),
(17, 257, '10', '10', 19, 62, 188, '2019-01-28 17:01:36', 188, NULL, NULL),
(18, 277, '200', '10', 13, 0, 188, '2019-01-31 14:01:05', 188, NULL, NULL),
(19, 275, '12', '12', 13, 53, 188, '2019-01-31 14:01:39', 188, NULL, NULL),
(20, 255, '12', '100', 13, 53, 188, '2019-01-31 14:01:39', 188, NULL, NULL),
(21, 277, '200', '10', 13, 53, 188, '2019-01-31 14:01:39', 188, NULL, NULL),
(22, 396, '100', '10', 22, 96, 1, '2019-04-08 14:05:37', 1, NULL, NULL),
(23, 395, '120', '10', 22, 96, 1, '2019-04-08 14:05:37', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_project`
--

CREATE TABLE `i_ext_pro_project` (
  `iextpp_id` int(11) NOT NULL,
  `iextpp_p_name` varchar(100) DEFAULT NULL,
  `iextpp_p_description` varchar(500) DEFAULT NULL,
  `iextpp_owner` int(11) DEFAULT NULL,
  `iextpp_created` datetime DEFAULT NULL,
  `iextpp_created_by` int(11) DEFAULT NULL,
  `iextpp_modified` datetime DEFAULT NULL,
  `iextpp_modified_by` int(11) DEFAULT NULL,
  `iextpp_gid` int(11) DEFAULT NULL,
  `iextpp_p_start_date` date DEFAULT NULL,
  `iextpp_p_end_date` date DEFAULT NULL,
  `iextpp_p_status` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_pro_project`
--

INSERT INTO `i_ext_pro_project` (`iextpp_id`, `iextpp_p_name`, `iextpp_p_description`, `iextpp_owner`, `iextpp_created`, `iextpp_created_by`, `iextpp_modified`, `iextpp_modified_by`, `iextpp_gid`, `iextpp_p_start_date`, `iextpp_p_end_date`, `iextpp_p_status`) VALUES
(25, 'test', '', 1, '2019-05-14 10:42:45', 1, NULL, NULL, 0, '2019-05-14', '0000-00-00', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_project_users`
--

CREATE TABLE `i_ext_pro_project_users` (
  `iextppu_id` int(11) NOT NULL,
  `iextppu_p_id` int(11) DEFAULT NULL,
  `iextppu_p_u_id` int(11) DEFAULT NULL,
  `iextppu_role` varchar(100) DEFAULT NULL,
  `iextppu_p_access` varchar(100) DEFAULT NULL,
  `iextppu_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_task`
--

CREATE TABLE `i_ext_pro_task` (
  `iextpt_id` int(11) NOT NULL,
  `iextpt_p_id` int(11) DEFAULT NULL,
  `iextpt_tg_id` int(11) DEFAULT NULL,
  `iextpt_owner` int(11) DEFAULT NULL,
  `iextpt_created_by` int(11) DEFAULT NULL,
  `iextpt_gid` int(11) DEFAULT NULL,
  `iextpt_aid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_pro_task`
--

INSERT INTO `i_ext_pro_task` (`iextpt_id`, `iextpt_p_id`, `iextpt_tg_id`, `iextpt_owner`, `iextpt_created_by`, `iextpt_gid`, `iextpt_aid`) VALUES
(3, 23, 95, 1, 1, 9, 52),
(4, 23, 95, 1, 1, 9, 53);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_task_comments`
--

CREATE TABLE `i_ext_pro_task_comments` (
  `iextptc_id` int(11) NOT NULL,
  `iextptc_p_id` int(11) DEFAULT NULL,
  `iextptc_tg_id` int(11) DEFAULT NULL,
  `iextptc_t_id` int(11) DEFAULT NULL,
  `iextptc_comment` varchar(800) DEFAULT NULL,
  `iextptc_owner` int(11) DEFAULT NULL,
  `iextptc_created` datetime DEFAULT NULL,
  `iextptc_created_by` int(11) DEFAULT NULL,
  `iextptc_modified` datetime DEFAULT NULL,
  `iextptc_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_pro_task_comments`
--

INSERT INTO `i_ext_pro_task_comments` (`iextptc_id`, `iextptc_p_id`, `iextptc_tg_id`, `iextptc_t_id`, `iextptc_comment`, `iextptc_owner`, `iextptc_created`, `iextptc_created_by`, `iextptc_modified`, `iextptc_modified_by`) VALUES
(1, 22, 94, 1, 'progress', 1, '2019-03-08 16:36:52', 1, NULL, NULL),
(2, 23, 95, 4, '', 1, '2019-03-08 17:45:40', 1, NULL, NULL),
(3, 23, 95, 4, 'done', 1, '2019-03-08 17:45:40', 1, NULL, NULL),
(4, 22, 94, 1, 'ghtgkvyuhsjdfuhsd', 1, '2019-04-01 16:50:33', 1, NULL, NULL),
(5, 22, 0, 2, 'welcome to india', 1, '2019-04-03 10:32:19', 1, NULL, NULL),
(6, 22, 0, 2, 'welcome to india', 1, '2019-04-03 10:32:19', 1, NULL, NULL),
(7, 22, 96, 8, '', 1, '2019-04-08 12:39:33', 1, NULL, NULL),
(8, 22, 96, 8, 'done', 1, '2019-04-08 12:39:33', 1, NULL, NULL),
(9, 22, 96, 2, 'progress', 1, '2019-04-19 10:46:34', 1, NULL, NULL),
(10, 22, 96, 2, 'test comment', 1, '2019-04-19 10:46:51', 1, NULL, NULL),
(11, 22, 96, 2, 'test comment', 1, '2019-04-19 10:46:51', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_task_group`
--

CREATE TABLE `i_ext_pro_task_group` (
  `iextptg_id` int(11) NOT NULL,
  `iextptg_p_id` int(11) DEFAULT NULL,
  `iextptg_name` varchar(100) DEFAULT NULL,
  `iextptg_owner` int(11) DEFAULT NULL,
  `iextptg_created` datetime DEFAULT NULL,
  `iextptg_created_by` int(11) DEFAULT NULL,
  `iextptg_modified` datetime DEFAULT NULL,
  `iextptg_modified_by` int(11) DEFAULT NULL,
  `iextptg_gid` int(11) DEFAULT NULL,
  `iextptg_p_grp` int(11) DEFAULT NULL,
  `iextptg_msg_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_task_group_user`
--

CREATE TABLE `i_ext_pro_task_group_user` (
  `iextptgu_id` int(11) NOT NULL,
  `iextptgu_p_id` int(11) DEFAULT NULL,
  `iextptgu_tg_id` int(11) DEFAULT NULL,
  `iextptgu_u_id` int(11) DEFAULT NULL,
  `iextptgu_access` varchar(100) DEFAULT NULL,
  `iextptgu_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_task_tags`
--

CREATE TABLE `i_ext_pro_task_tags` (
  `iextptt_id` int(11) NOT NULL,
  `iextptt_txn_id` int(11) DEFAULT NULL,
  `iextptt_tag_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_task_user`
--

CREATE TABLE `i_ext_pro_task_user` (
  `iextptu_id` int(11) NOT NULL,
  `iextptu_p_id` int(11) DEFAULT NULL,
  `iextptu_tg_id` int(11) DEFAULT NULL,
  `iextptu_t_id` int(11) DEFAULT NULL,
  `iextptu_u_id` int(11) DEFAULT NULL,
  `iextptu_subscribe` varchar(10) DEFAULT NULL,
  `iextptu_access` varchar(100) DEFAULT NULL,
  `iextptu_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_pro_user_role`
--

CREATE TABLE `i_ext_pro_user_role` (
  `iextprour_id` int(11) NOT NULL,
  `iextprour_uid` int(11) DEFAULT NULL,
  `iextprour_pid` int(11) DEFAULT NULL,
  `iextprour_task_gid` int(11) DEFAULT NULL,
  `iextprour_project` varchar(50) DEFAULT NULL,
  `iextprour_group` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_pro_user_role`
--

INSERT INTO `i_ext_pro_user_role` (`iextprour_id`, `iextprour_uid`, `iextprour_pid`, `iextprour_task_gid`, `iextprour_project`, `iextprour_group`) VALUES
(80, 2, 23, NULL, 'true', 'true'),
(81, 3, 23, NULL, 'true', 'true'),
(82, 2, 23, 95, 'true', 'true'),
(83, 3, 23, 95, 'true', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_research`
--

CREATE TABLE `i_ext_research` (
  `iextre_id` int(11) NOT NULL,
  `iextre_title` varchar(100) DEFAULT NULL,
  `iextre_owner` int(11) DEFAULT NULL,
  `iextre_created_by` int(11) DEFAULT NULL,
  `iextre_created` datetime DEFAULT NULL,
  `iextre_modified_by` int(11) DEFAULT NULL,
  `iextre_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_research`
--

INSERT INTO `i_ext_research` (`iextre_id`, `iextre_title`, `iextre_owner`, `iextre_created_by`, `iextre_created`, `iextre_modified_by`, `iextre_modified`) VALUES
(1, 'IRENE Research', 6, 6, '2018-08-06 14:08:50', 6, '2018-08-31 20:08:29'),
(2, 'IRENE Research', 6, 6, '2018-08-06 14:08:17', 6, '2018-08-06 15:08:50'),
(3, 'krishnakant edit', 6, 6, '2018-08-06 15:08:17', 6, '2018-08-08 18:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_research_details`
--

CREATE TABLE `i_ext_research_details` (
  `iextred_id` int(11) NOT NULL,
  `iextred_r_id` int(11) DEFAULT NULL,
  `iextred_title` varchar(100) DEFAULT NULL,
  `iextred_link` varchar(500) DEFAULT NULL,
  `iextred_image` varchar(100) DEFAULT NULL,
  `iextred_desc` varchar(500) DEFAULT NULL,
  `iextred_p_id` int(11) DEFAULT NULL,
  `iextred_owner` int(11) DEFAULT NULL,
  `iextred_created_by` int(11) DEFAULT NULL,
  `iextred_created` datetime DEFAULT NULL,
  `iextred_modified_by` int(11) DEFAULT NULL,
  `iextred_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_research_details`
--

INSERT INTO `i_ext_research_details` (`iextred_id`, `iextred_r_id`, `iextred_title`, `iextred_link`, `iextred_image`, `iextred_desc`, `iextred_p_id`, `iextred_owner`, `iextred_created_by`, `iextred_created`, `iextred_modified_by`, `iextred_modified`) VALUES
(1, 2, 'Parent Node 4', '', '', 'Testing Desc', 0, 6, 6, '2018-08-06 14:08:17', NULL, NULL),
(2, 2, 'Child Node 2 Parent 1', '', '', 'Desc 2', 1, 6, 6, '2018-08-06 15:08:50', NULL, NULL),
(3, 3, 'Parent Node 1', 'development.evomata.in', '', 'evomata link', 0, 6, 6, '2018-08-07 12:08:11', NULL, NULL),
(4, 3, 'Parent Node 2', 'development.evomata.in', '', 'evomata link', 0, 6, 6, '2018-08-07 12:08:11', 6, '2018-08-07 12:08:45'),
(44, 3, 'Parent Node 3', 'development.evomata.in', '', 'evomata link', 0, 6, 6, '2018-08-07 12:08:11', 6, '2018-08-07 12:08:54'),
(46, 3, 'Parent Node 4', 'https://www.google.co.in/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=2ahUKEwjp5eb-w93cAhUZfysKHVXpCwkQjRx6BAgBEAU&url=https%3A%2F%2Fwww.hindustantimes.com%2Fmumbai-news%2Fmaratha-reservation-is-back-at-the-centre-of-politics-in-maharashtra%2Fstory-wCIKbNGknE0tidT1cjK3FJ.html&psig=AOvVaw1TEAbW6lasid0aw93YhaL_&ust=1533820288589686', 'logo.jpg', 'link', 0, 6, 6, '2018-08-07 12:08:11', 6, '2018-08-08 18:08:13'),
(50, 3, 'PN1.1', '', '', '', 3, 6, 6, '2018-08-07 13:08:14', 6, '2018-08-07 14:08:50'),
(51, 3, 'PN1.2', '', '', '', 3, 6, 6, '2018-08-07 13:08:26', NULL, NULL),
(52, 3, 'Parent Node 5', 'development.evomata.in', '', 'evomata link', 0, 6, 6, '2018-08-07 13:08:55', 6, '2018-08-07 13:08:01'),
(53, 3, 'p n 6', '', 'logo.jpg', '', 0, 6, 6, '2018-08-07 14:08:06', 6, '2018-08-07 14:08:15'),
(54, 3, 'pn 1.1.1', '', NULL, '', 50, 6, 6, '2018-08-07 14:08:48', NULL, NULL),
(55, 1, 'title 1', '', NULL, '', 55, 6, 6, '2018-08-31 20:08:35', 6, '2018-08-31 20:08:51'),
(56, 1, 'title 1', '', NULL, '', 0, 6, 6, '2018-08-31 20:08:08', NULL, NULL),
(57, 1, 'title 1.1', '', NULL, '', 55, 6, 6, '2018-08-31 20:08:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_support`
--

CREATE TABLE `i_ext_support` (
  `ies_id` int(11) NOT NULL,
  `ies_ticket_id` int(11) DEFAULT NULL,
  `ies_cid` int(11) DEFAULT NULL,
  `ies_category` varchar(200) DEFAULT NULL,
  `ies_subject` varchar(500) DEFAULT NULL,
  `ies_desc` varchar(500) DEFAULT NULL,
  `ies_date` date DEFAULT NULL,
  `ies_priority` int(11) DEFAULT NULL,
  `ies_contact_person` varchar(100) DEFAULT NULL,
  `ies_remark` varchar(300) DEFAULT NULL,
  `ies_owner` int(11) DEFAULT NULL,
  `ies_created` datetime DEFAULT NULL,
  `ies_created_by` int(11) DEFAULT NULL,
  `ies_modified` datetime DEFAULT NULL,
  `ies_modified_by` int(11) DEFAULT NULL,
  `ies_gid` int(11) DEFAULT NULL,
  `ies_user_type` varchar(100) DEFAULT NULL,
  `ies_user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_support`
--

INSERT INTO `i_ext_support` (`ies_id`, `ies_ticket_id`, `ies_cid`, `ies_category`, `ies_subject`, `ies_desc`, `ies_date`, `ies_priority`, `ies_contact_person`, `ies_remark`, `ies_owner`, `ies_created`, `ies_created_by`, `ies_modified`, `ies_modified_by`, `ies_gid`, `ies_user_type`, `ies_user_id`) VALUES
(1, 1, 1, 'support', 'support ticket for ams', 'support', '2019-05-08', 5, NULL, NULL, 1, '2019-05-08 15:42:17', 1, NULL, NULL, 31, 'sub_user', 1),
(2, 1, 1, 'test', 'test', 'test', '2019-05-11', 5, NULL, NULL, 1, '2019-05-11 12:43:51', 1, NULL, NULL, 31, 'sub_user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_support_activity`
--

CREATE TABLE `i_ext_support_activity` (
  `iesa_id` int(11) NOT NULL,
  `iesa_sid` int(11) DEFAULT NULL,
  `iesa_aid` int(11) DEFAULT NULL,
  `iesa_code` varchar(100) DEFAULT NULL,
  `iesa_created` datetime DEFAULT NULL,
  `iesa_created_by` int(11) DEFAULT NULL,
  `iesa_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_support_activity`
--

INSERT INTO `i_ext_support_activity` (`iesa_id`, `iesa_sid`, `iesa_aid`, `iesa_code`, `iesa_created`, `iesa_created_by`, `iesa_owner`) VALUES
(1, 1, 4, '999291', '2019-05-08 15:59:58', 1, 1),
(2, 2, 6, '968886', '2019-05-11 12:45:26', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_ext_tags`
--

CREATE TABLE `i_ext_tags` (
  `iet_id` int(11) NOT NULL,
  `iet_type_id` int(11) DEFAULT NULL,
  `iet_type` varchar(50) DEFAULT NULL,
  `iet_m_id` int(11) DEFAULT NULL,
  `iet_tag_id` int(11) DEFAULT NULL,
  `iet_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_ext_tags`
--

INSERT INTO `i_ext_tags` (`iet_id`, `iet_type_id`, `iet_type`, `iet_m_id`, `iet_tag_id`, `iet_owner`) VALUES
(86, 196, 'invoice', 35, 1, 188),
(97, 55, 'purchase', 40, 1, 188),
(102, 82, 'expenses', 43, 1, 188),
(103, 89, 'expenses', 43, 2, 188),
(104, 72, 'expenses', 43, 1, 188),
(106, 41, 'opportunity', 50, 1, 188),
(116, 199, 'invoice', 36, 1, 188),
(117, 199, 'invoice', 36, 2, 188),
(118, 200, 'invoice', 36, 1, 188),
(119, 200, 'invoice', 36, 2, 188),
(124, 216, 'inventory', 36, 1, 188),
(125, 216, 'inventory', 36, 2, 188),
(126, 216, 'outward', 36, 1, 188),
(127, 216, 'outward', 36, 2, 188),
(130, 201, 'invoice', 36, 1, 188),
(131, 201, 'invoice', 36, 2, 188),
(132, 202, 'invoice', 36, 1, 188),
(133, 202, 'invoice', 36, 2, 188),
(137, 39, 'subscription', 42, 1, 188),
(141, 258, 'products', 34, 3, 188),
(142, 259, 'products', 34, 1, 188),
(147, 260, 'products', 34, 1, 188),
(149, 261, 'products', 34, 1, 188),
(150, 244, 'inventory', 36, 1, 188),
(151, 245, 'inventory', 36, 1, 188),
(153, 246, 'inventory', 36, 1, 188),
(154, 246, 'spare', 36, 1, 188),
(160, 247, 'inventory', 36, 1, 188),
(161, 247, 'spare', 36, 1, 188),
(165, 64, 'purchase', 40, 4, 188),
(169, 1, 'purchase', 40, 4, 188),
(170, 44, 'subscription', 42, 1, 188),
(171, 62, 'proposal', 51, 1, 188),
(172, 17, 'project', 49, 1, 188),
(173, 19, 'project', 49, 1, 188),
(178, 253, 'products', 34, 1, 188),
(179, 253, 'products', 34, 2, 188),
(187, 19, 'customers', 33, 1, 188),
(188, 44395, 'customers', 33, 1, 188),
(192, 21, 'project', 49, 1, 188),
(193, 29, 'customers', 33, 2085, 1),
(194, 29, 'customers', 33, 2086, 1),
(195, 30, 'customers', 33, 2085, 1),
(196, 30, 'customers', 33, 2086, 1),
(197, 31, 'customers', 33, 2085, 1),
(198, 31, 'customers', 33, 2086, 1),
(199, 32, 'customers', 33, 2085, 1),
(200, 32, 'customers', 33, 2086, 1),
(201, 34, 'customers', 33, 2085, 1),
(202, 34, 'customers', 33, 2086, 1),
(203, 41, 'customers', 33, 2086, 1),
(204, 41, 'customers', 33, 2085, 1),
(205, 59, 'customers', 33, 2085, 1),
(206, 59, 'customers', 33, 2086, 1),
(207, 68, 'customers', 33, 2087, 1),
(208, 69, 'customers', 33, 2086, 1),
(209, 78, 'customers', 33, 2086, 1),
(210, 79, 'customers', 33, 2086, 1),
(211, 80, 'customers', 33, 2086, 1),
(212, 80, 'customers', 33, 2085, 1),
(213, 81, 'customers', 33, 2086, 1),
(214, 81, 'customers', 33, 2085, 1),
(215, 82, 'customers', 33, 2086, 1),
(216, 82, 'customers', 33, 2085, 1),
(248, 6, 'customers', 33, 2086, 1),
(249, 6, 'customers', 33, 2085, 1),
(256, 84, 'customers', 33, 2086, 1),
(257, 84, 'customers', 33, 2085, 1),
(258, 84, 'customers', 33, 2088, 1),
(264, 90, 'customers', 33, 2090, 1),
(265, 88, 'customers', 33, 2089, 1),
(273, 9, 'inventory', 36, 2092, 1),
(277, 11, 'inventory', 36, 2094, 1),
(280, 10, 'inventory', 36, 2095, 1),
(281, 10, 'inward', 36, 2095, 1),
(282, 6, 'inventory', 36, 2096, 1),
(283, 6, 'outward', 36, 2096, 1),
(285, 8, 'inward', 36, 2085, 1),
(286, 124, 'invoice', 68, 2097, 1),
(299, 124, 'purchase_order', 68, 2097, 1),
(300, 126, 'invoice', 69, 2098, 1),
(305, 126, 'credit_note', 69, 2098, 1),
(306, 127, 'invoice', 70, 2099, 1),
(308, 127, 'debit_note', 70, 2099, 1),
(310, 10, 'inventory', 72, 2101, 19),
(311, 10, 'inventory', 72, 2102, 19),
(316, 10, 'inventory', 0, 2104, 19),
(317, 10, 'inward', 0, 2104, 19),
(318, 10, 'inventory', NULL, 2105, 19),
(319, 10, 'inward', NULL, 2105, 19),
(322, 10, 'inventory', 71, 2105, 19),
(323, 10, 'inventory', 71, 2101, 19),
(324, 10, 'inventory', 71, 2106, 19),
(325, 10, 'inventory', 71, 2107, 19),
(326, 10, 'inward', 71, 2105, 19),
(327, 10, 'inward', 71, 2101, 19),
(328, 10, 'inward', 71, 2106, 19),
(329, 10, 'inward', 71, 2107, 19),
(334, 11, 'inventory', 71, 2108, 19),
(335, 11, 'inward', 71, 2108, 19),
(338, 12, 'inventory', 71, 2109, 19),
(339, 12, 'inward', 71, 2109, 19),
(340, 14, 'inward', 71, 2110, 19),
(341, 14, 'inward', 71, 2109, 19),
(342, 15, 'inward', 71, 2109, 19),
(343, 15, 'inward', 71, 2111, 19),
(344, 15, 'inward', 71, 2108, 19),
(348, 16, 'inventory', 72, 2112, 19),
(349, 16, 'outward', 72, 2112, 19),
(351, 18, 'outward', 72, 2112, 19),
(356, 19, 'outward', 72, 2112, 19),
(357, 17, 'inventory', 72, 2112, 19),
(358, 17, 'outward', 72, 2112, 19),
(359, 20, 'outward', 72, 2112, 19),
(361, 21, 'inventory', 72, 2112, 19),
(362, 21, 'outward', 72, 2112, 19),
(363, 22, 'outward', 72, 2112, 19),
(370, 23, 'inventory', 71, 2110, 19),
(371, 23, 'inventory', 71, 2109, 19),
(372, 23, 'inward', 71, 2110, 19),
(373, 23, 'inward', 71, 2109, 19),
(376, 10, 'orders', 56, 2114, 19),
(383, 14, 'orders', 56, 2114, 19),
(386, 15, 'orders', 56, 2114, 19),
(387, 16, 'orders', 56, 2114, 19),
(388, 24, 'inventory', 71, 2101, 19),
(389, 24, 'inventory', 71, 2113, 19),
(390, 24, 'inward', 71, 2101, 19),
(391, 24, 'inward', 71, 2113, 19),
(400, 26, NULL, 77, 2115, 19),
(401, 26, 'inventory', 77, 2116, 19),
(402, 26, 'rej_in', 77, 2116, 19),
(403, 27, 'rej_out', 78, 2117, 19),
(404, 30, 'rej_in', 79, 2118, 19),
(405, 31, 'rej_in', 79, 2118, 19),
(406, 32, 'rej_in', 79, 2118, 19),
(407, 33, 'rej_in', 79, 2118, 19),
(408, 36, 'material_out', 80, 2119, 19),
(409, 36, 'material_out', 80, 2120, 19),
(410, 1, 'inward', 71, 2113, 19),
(411, 2, 'inward', 71, 2121, 4),
(412, 2, 'inward', 71, 2122, 4),
(413, 3, 'inward', 71, 2121, 4),
(414, 3, 'inward', 71, 2122, 4),
(415, 4, 'inward', 71, 2122, 4),
(416, 4, 'inward', 71, 2121, 4),
(417, 5, 'outward', 72, 2123, 4),
(418, 5, 'outward', 72, 2124, 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_function`
--

CREATE TABLE `i_function` (
  `ifun_id` int(11) NOT NULL,
  `ifun_domain_id` int(11) DEFAULT NULL,
  `ifun_name` varchar(100) DEFAULT NULL,
  `ifun_created` datetime DEFAULT NULL,
  `ifun_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_function`
--

INSERT INTO `i_function` (`ifun_id`, `ifun_domain_id`, `ifun_name`, `ifun_created`, `ifun_created_by`) VALUES
(109, 8, 'customers', '2018-09-19 15:09:42', NULL),
(110, 8, 'products', '2018-07-04 13:07:57', NULL),
(111, 8, 'account', '2018-07-05 22:07:07', NULL),
(113, 8, 'invoice', '2018-07-07 11:07:35', NULL),
(114, 8, 'inventory', '2018-07-09 11:07:57', NULL),
(116, 8, 'tax', '2018-07-13 12:07:58', NULL),
(117, 8, 'tax_group', '2018-07-13 12:07:27', NULL),
(118, 8, 'purchase', '2018-07-19 10:07:56', NULL),
(119, 8, 'quotation', '2018-07-19 14:07:25', NULL),
(120, 8, 'amc', '2018-07-19 16:07:46', NULL),
(121, 8, 'expenses', '2018-07-26 19:07:30', NULL),
(122, 14, 'research', '2018-08-06 12:08:10', NULL),
(123, 15, 'index', '2018-08-08 17:08:56', NULL),
(124, 8, 'amc_add', '2018-08-29 18:08:38', NULL),
(125, 8, 'invoice_add', '2018-08-29 19:08:34', NULL),
(126, 8, 'inventory_add', '2018-08-29 19:08:09', NULL),
(127, 8, 'quotation_add', '2018-08-29 19:08:42', NULL),
(128, 8, 'purchase_add', '2018-08-29 19:08:05', NULL),
(137, 22, 'home', '2019-01-04 13:26:20', NULL),
(132, 18, 'view', '2018-09-20 19:09:18', NULL),
(131, 17, 'home', '2018-09-25 15:09:28', NULL),
(133, 19, 'home', '2018-09-24 16:09:22', NULL),
(134, 17, 'proposal', '2018-09-28 17:09:27', NULL),
(135, 20, 'home', '2018-10-31 15:10:32', NULL),
(136, 21, 'home', '2018-11-10 12:11:20', NULL),
(138, 23, 'home', '2019-02-21 12:44:18', NULL),
(139, 24, 'home', '2019-02-22 12:25:34', NULL),
(140, 25, 'home', '2019-02-22 14:58:35', NULL),
(141, 26, 'home', '2019-03-08 18:29:36', NULL),
(142, 27, 'home', '2019-04-26 17:40:31', NULL),
(143, 28, 'home', '2019-03-09 09:57:52', NULL),
(144, 29, 'home', '2019-03-12 16:45:03', NULL),
(145, 30, 'home', '2019-03-13 15:16:12', NULL),
(146, 31, 'home', '2019-03-25 10:41:21', NULL),
(147, 32, 'home', '2019-04-03 13:12:08', NULL),
(148, 33, 'home', '2019-04-22 15:32:05', NULL),
(149, 34, 'inventory_new', '2019-05-13 12:47:54', NULL),
(150, 35, 'home', '2019-05-16 15:00:29', NULL),
(151, 36, 'purchase_order', '2019-05-25 15:27:54', NULL),
(152, 37, 'credit_note', '2019-05-27 12:31:14', NULL),
(153, 38, 'debit_note', '2019-05-27 13:47:29', NULL),
(154, 34, 'inward', '2019-06-01 17:38:46', NULL),
(155, 34, 'outward', '2019-06-01 17:38:40', NULL),
(156, 34, 'inventory_status', '2019-06-03 11:24:42', NULL),
(157, 34, 'inventory_accounts', '2019-06-03 11:30:09', NULL),
(158, 34, 'inventory_report', '2019-06-03 11:31:18', NULL),
(159, 34, 'inventory_settings', '2019-06-08 10:29:39', NULL),
(160, 34, 'rejection_in', '2019-06-14 11:03:06', NULL),
(161, 34, 'rejection_out', '2019-06-14 11:03:17', NULL),
(162, 34, 'material_in', '2019-06-14 12:55:58', NULL),
(163, 34, 'material_out', '2019-06-14 12:56:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_helper`
--

CREATE TABLE `i_helper` (
  `ih_id` int(11) NOT NULL,
  `ih_func_name` varchar(200) DEFAULT NULL,
  `ih_title` varchar(200) DEFAULT NULL,
  `ih_from_module` int(11) DEFAULT NULL,
  `ih_to_module` int(11) DEFAULT NULL,
  `ih_type` varchar(200) DEFAULT NULL,
  `ih_outcome_type` varchar(200) DEFAULT NULL,
  `ih_outcome_value` varchar(200) DEFAULT NULL,
  `ih_parameter` int(11) DEFAULT NULL,
  `ih_created` datetime DEFAULT NULL,
  `ih_created_by` int(11) DEFAULT NULL,
  `ih_modify` datetime DEFAULT NULL,
  `ih_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_helper`
--

INSERT INTO `i_helper` (`ih_id`, `ih_func_name`, `ih_title`, `ih_from_module`, `ih_to_module`, `ih_type`, `ih_outcome_type`, `ih_outcome_value`, `ih_parameter`, `ih_created`, `ih_created_by`, `ih_modify`, `ih_modified_by`) VALUES
(7, 'MH/transfer_proposal_inventory_outward', 'Proceed to Inventory Outward', 51, 66, 'Module', 'redirect', '\'Inventory/inventory_edit/outward/\'.$code.\'/\'.$mod_id.\'/\'.$txnid', 1, '2018-12-10 16:12:30', NULL, '2019-05-25 14:30:40', NULL),
(8, 'MH/add_project', 'Add project', 51, 49, 'Module', 'redirect', '\'Projects/edit_project/\'.$txnid.\'/\'.$code', 1, '2018-12-12 13:12:07', NULL, '2019-01-28 16:01:24', NULL),
(9, 'MH/transfer_proposal_invoice', 'Proceed to invoice', 51, 35, 'Module', 'redirect', '\'Enterprise/invoice_add/\'.$mod_id.\'/\'.$code.\'/\'.$txnid', 1, '2018-12-12 15:12:09', NULL, '2019-02-25 12:01:45', NULL),
(10, 'MH/transfer_inventory_outward_invoice', 'Proceed to invoice', 66, 35, 'Module', 'redirect', '\'Enterprise/invoice_add/\'.$mod_id.\'/\'.$code.\'/\'.$txnid', 1, '2018-12-12 16:12:16', NULL, '2019-05-25 14:00:53', NULL),
(11, 'MH/transfer_invoice_inventory_outward', 'Proceed to inventory outward', 35, 66, 'Module', 'redirect', '\'Inventory/inventory_edit/outward/\'.$code.\'/\'.$mod_id.\'/\'.$txnid', 1, '2018-12-12 16:12:11', NULL, '2019-05-25 14:31:08', NULL),
(12, 'MH/transfer_inventory_inward_purchase', 'Proceed to purchase', 66, 40, 'Module', 'redirect', '\'Enterprise/purchase_add/\'.$code.\'/\'.$mod_id.\'/\'.$txnid', 1, '2018-12-12 17:12:46', NULL, '2019-05-25 14:01:14', NULL),
(13, 'MH/transfer_purchase_inventory_inward', 'Proceed to Inventory inward', 40, 66, 'Module', 'redirect', '\'Inventory/inventory_edit/inward/\'.$code.\'/\'.$mod_id.\'/\'.$txnid', 1, '2018-12-12 18:12:35', NULL, '2019-05-25 14:31:25', NULL),
(14, 'MH/transfer_invoice_subscription', 'Proceed to Invoice to Subscription', 35, 42, 'Module', 'redirect', '\'Enterprise/amc_edit/\'.$mod_id.\'/\'.$code.\'/\'.$txnid', 1, '2018-12-12 18:12:10', NULL, '2018-12-12 18:12:44', NULL),
(15, 'MH/proposal_revision', 'Proposal revision', 51, 51, 'Module', 'redirect', '\'Sales/proposal_add/\'.$code.\'/\'.$mod_id.\'/\'.$txnid', 1, '2018-12-13 10:12:44', NULL, '2018-12-13 10:12:36', NULL),
(16, 'MH/transfer_orders_inventory_outward_dispatch', 'Proceed to inventory dispatch', 56, 66, 'module', 'redirect', '\'Inventory/inventory_edit/outward/\'.$code.\'/\'.$mod_id.\'/\'.$txnid', 1, '2019-02-25 12:03:08', NULL, '2019-05-25 14:31:55', NULL),
(17, 'MH/transfer_orders_inventory_outward', 'Proceed to inventory outward', 56, 66, 'module', 'redirect', '\'Inventory/inventory_edit/outward/\'.$code.\'/\'.$mod_id.\'/\'.$txnid', 1, '2019-02-25 12:08:18', NULL, '2019-05-25 14:31:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_helper_parameters`
--

CREATE TABLE `i_helper_parameters` (
  `ihp_id` int(11) NOT NULL,
  `ihp_ih_id` int(11) DEFAULT NULL,
  `ihp_value` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_helper_parameters`
--

INSERT INTO `i_helper_parameters` (`ihp_id`, `ihp_ih_id`, `ihp_value`) VALUES
(80, 14, '$code'),
(81, 14, '$tid'),
(86, 15, '$code'),
(87, 15, '$tid'),
(96, 8, '$code'),
(97, 8, '$tid'),
(100, 9, '$code'),
(101, 9, '$tid'),
(114, 10, '$code'),
(115, 10, '$tid'),
(116, 12, '$code'),
(117, 12, '$tid'),
(130, 7, '$code'),
(131, 7, '$tid'),
(132, 11, '$code'),
(133, 11, '$tid'),
(134, 13, '$code'),
(135, 13, '$tid'),
(136, 17, '$code'),
(137, 17, '$tid'),
(138, 16, '$code'),
(139, 16, '$tid');

-- --------------------------------------------------------

--
-- Table structure for table `i_inventory_accounts`
--

CREATE TABLE `i_inventory_accounts` (
  `iia_id` int(11) NOT NULL,
  `iia_name` varchar(100) DEFAULT NULL,
  `iia_owner` int(11) DEFAULT NULL,
  `iia_created` datetime DEFAULT NULL,
  `iia_created_by` int(11) DEFAULT NULL,
  `iia_modified` datetime DEFAULT NULL,
  `iia_modified_by` int(11) DEFAULT NULL,
  `iia_star` int(11) DEFAULT NULL,
  `iia_gid` int(11) DEFAULT NULL,
  `iia_barcode` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_inventory_accounts`
--

INSERT INTO `i_inventory_accounts` (`iia_id`, `iia_name`, `iia_owner`, `iia_created`, `iia_created_by`, `iia_modified`, `iia_modified_by`, `iia_star`, `iia_gid`, `iia_barcode`) VALUES
(20, 'Spare Account', 4, '2019-06-20 12:08:23', 4, NULL, NULL, NULL, 4, ''),
(19, 'Repair Account', 4, '2019-06-20 12:08:18', 4, NULL, NULL, NULL, 4, ''),
(18, 'Defective Account', 4, '2019-06-20 12:08:10', 4, NULL, NULL, NULL, 4, ''),
(17, 'Usable Stock', 4, '2019-06-20 12:07:35', 4, NULL, NULL, 1, 4, ''),
(15, 'Spares', 1, '2019-06-19 15:11:31', 1, NULL, NULL, NULL, 1, '2'),
(14, 'Usable Stock', 1, '2019-06-19 15:11:25', 1, NULL, NULL, 1, 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `i_inventory_new`
--

CREATE TABLE `i_inventory_new` (
  `iin_id` int(11) NOT NULL,
  `iin_from` varchar(100) DEFAULT NULL,
  `iin_from_type` varchar(100) DEFAULT NULL,
  `iin_to` varchar(100) DEFAULT NULL,
  `iin_to_type` varchar(100) DEFAULT NULL,
  `iin_p_id` int(11) DEFAULT NULL,
  `iin_inward` float DEFAULT NULL,
  `iin_outward` float DEFAULT NULL,
  `iin_date` date DEFAULT NULL,
  `iin_order_id` int(11) DEFAULT NULL,
  `iin_order_txn` int(11) DEFAULT NULL,
  `iin_txn_num` int(11) DEFAULT NULL,
  `iin_txn_date` date DEFAULT NULL,
  `iin_owner` int(11) DEFAULT NULL,
  `iin_created` datetime DEFAULT NULL,
  `iin_created_by` int(11) DEFAULT NULL,
  `iin_modified` datetime DEFAULT NULL,
  `iin_modified_by` int(11) DEFAULT NULL,
  `iin_gid` int(11) DEFAULT NULL,
  `iin_serial_number` varchar(200) DEFAULT NULL,
  `iin_alias` varchar(100) DEFAULT NULL,
  `iin_location` varchar(200) DEFAULT NULL,
  `iin_txn_type` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_inventory_new`
--

INSERT INTO `i_inventory_new` (`iin_id`, `iin_from`, `iin_from_type`, `iin_to`, `iin_to_type`, `iin_p_id`, `iin_inward`, `iin_outward`, `iin_date`, `iin_order_id`, `iin_order_txn`, `iin_txn_num`, `iin_txn_date`, `iin_owner`, `iin_created`, `iin_created_by`, `iin_modified`, `iin_modified_by`, `iin_gid`, `iin_serial_number`, `iin_alias`, `iin_location`, `iin_txn_type`) VALUES
(1, '1', 'contact', '14', 'account', 403, 100, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '', 'false', NULL, 'inward'),
(2, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '1', 'false', NULL, 'inward'),
(3, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '2', 'false', NULL, 'inward'),
(4, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '3', 'false', NULL, 'inward'),
(5, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '4', 'false', NULL, 'inward'),
(6, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '5', 'false', NULL, 'inward'),
(7, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '6', 'false', NULL, 'inward'),
(8, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '7', 'false', NULL, 'inward'),
(9, '1', 'contact', '14', 'account', 402, 1, 0, '2019-06-19', NULL, 1, NULL, NULL, 1, '2019-06-19 15:13:41', 1, NULL, NULL, 1, '8', 'false', NULL, 'inward'),
(10, '14', 'account', 'j2_2', 'location', 403, 50, 0, '2019-06-19', NULL, NULL, NULL, NULL, 1, '2019-06-19 15:14:38', 1, NULL, NULL, 1, '', NULL, '3', 'location'),
(11, '14', 'account', 'j2_2', 'location', 402, 1, 0, '2019-06-19', NULL, NULL, NULL, NULL, 1, '2019-06-19 15:14:38', 1, NULL, NULL, 1, '1', NULL, '3', 'location'),
(12, '14', 'account', 'j2_2', 'location', 402, 1, 0, '2019-06-19', NULL, NULL, NULL, NULL, 1, '2019-06-19 15:14:38', 1, NULL, NULL, 1, '2', NULL, '3', 'location'),
(13, '14', 'account', 'j2_2', 'location', 402, 1, 0, '2019-06-19', NULL, NULL, NULL, NULL, 1, '2019-06-19 15:14:38', 1, NULL, NULL, 1, '3', NULL, '3', 'location'),
(14, '14', 'account', 'j2_2', 'location', 402, 1, 0, '2019-06-19', NULL, NULL, NULL, NULL, 1, '2019-06-19 15:14:38', 1, NULL, NULL, 1, '4', NULL, '3', 'location'),
(15, 'j2_2', 'location', '15', 'account', 403, 50, 0, '2019-06-19', NULL, NULL, NULL, NULL, 1, '2019-06-19 15:16:08', 1, NULL, NULL, 1, '', NULL, NULL, 'location'),
(16, '15', 'account', 'j2_3', 'location', 403, 10, 0, '2019-06-19', NULL, NULL, NULL, NULL, 1, '2019-06-19 19:01:52', 1, NULL, NULL, 1, '', NULL, '4', 'location'),
(43, '17', 'account', '9', 'contact', 422, 1, 0, '2019-06-20', NULL, 5, NULL, NULL, 4, '2019-06-20 12:28:40', 4, NULL, NULL, 4, '087654321110', 'false', NULL, 'outward'),
(42, '17', 'account', '9', 'contact', 422, 1, 0, '2019-06-20', NULL, 5, NULL, NULL, 4, '2019-06-20 12:28:40', 4, NULL, NULL, 4, '8765432173', 'false', NULL, 'outward'),
(41, '17', 'account', '9', 'contact', 422, 1, 0, '2019-06-20', NULL, 5, NULL, NULL, 4, '2019-06-20 12:28:40', 4, NULL, NULL, 4, '8765432197', 'false', NULL, 'outward'),
(40, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '8765432180', 'false', NULL, 'inward'),
(39, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '087654321101', 'false', NULL, 'inward'),
(38, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '8765432166', 'false', NULL, 'inward'),
(33, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '8765432197', 'false', NULL, 'inward'),
(34, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '8765432173', 'false', NULL, 'inward'),
(35, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '087654321110', 'false', NULL, 'inward'),
(36, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '8765432159', 'false', NULL, 'inward'),
(37, '8', 'contact', '17', 'account', 422, 1, 0, '2019-06-20', NULL, 4, NULL, NULL, 4, '2019-06-20 12:10:16', 4, NULL, NULL, 4, '087654321129', 'false', NULL, 'inward'),
(45, '17', 'account', 'j2_2', 'location', 422, 1, 0, '2019-06-20', NULL, NULL, NULL, NULL, 4, '2019-06-20 12:34:50', 4, NULL, NULL, 4, '087654321129', NULL, '8765432128', 'location'),
(44, '17', 'account', '20', 'account', 422, 1, 0, '2019-06-20', NULL, 6, NULL, NULL, 4, '2019-06-20 12:31:40', 4, NULL, NULL, 4, '8765432159', 'false', NULL, 'material_in'),
(46, '17', 'account', 'j2_2', 'location', 422, 1, 0, '2019-06-20', NULL, NULL, NULL, NULL, 4, '2019-06-20 12:34:50', 4, NULL, NULL, 4, '8765432166', NULL, '8765432128', 'location'),
(47, '17', 'account', 'j2_2', 'location', 422, 1, 0, '2019-06-20', NULL, NULL, NULL, NULL, 4, '2019-06-20 12:34:50', 4, NULL, NULL, 4, '087654321101', NULL, '8765432128', 'location'),
(48, '17', 'account', 'j2_2', 'location', 422, 1, 0, '2019-06-20', NULL, NULL, NULL, NULL, 4, '2019-06-20 12:34:50', 4, NULL, NULL, 4, '8765432180', NULL, '8765432128', 'location'),
(49, 'j2_2', 'location', '17', 'account', 422, 1, 0, '2019-06-20', NULL, NULL, NULL, NULL, 4, '2019-06-20 12:35:28', 4, NULL, NULL, 4, '087654321129', NULL, NULL, 'location');

-- --------------------------------------------------------

--
-- Table structure for table `i_inventory_new_order`
--

CREATE TABLE `i_inventory_new_order` (
  `iino_id` int(11) NOT NULL,
  `iino_p_id` int(11) DEFAULT NULL,
  `iino_qty` int(11) DEFAULT NULL,
  `iino_owner` int(11) DEFAULT NULL,
  `iino_date` date DEFAULT NULL,
  `iino_created_by` int(11) DEFAULT NULL,
  `iino_created` datetime DEFAULT NULL,
  `iino_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_inventory_new_order`
--

INSERT INTO `i_inventory_new_order` (`iino_id`, `iino_p_id`, `iino_qty`, `iino_owner`, `iino_date`, `iino_created_by`, `iino_created`, `iino_gid`) VALUES
(5, 418, 10, 19, '2019-06-11', 22, '0000-00-00 00:00:00', 36),
(6, 419, 10, 19, '2019-06-11', 22, '0000-00-00 00:00:00', 36);

-- --------------------------------------------------------

--
-- Table structure for table `i_join_index`
--

CREATE TABLE `i_join_index` (
  `iji_id` int(11) NOT NULL,
  `iji_name` varchar(100) DEFAULT NULL,
  `iji_table1` varchar(100) DEFAULT NULL,
  `iji_column1` varchar(100) DEFAULT NULL,
  `iji_table2` varchar(100) DEFAULT NULL,
  `iji_column2` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_kpis`
--

CREATE TABLE `i_kpis` (
  `ikpi_id` int(11) NOT NULL,
  `ikpi_name` varchar(100) DEFAULT NULL,
  `ikpi_table` varchar(100) DEFAULT NULL,
  `ikpi_column` varchar(100) DEFAULT NULL,
  `ikpi_query` varchar(900) DEFAULT NULL,
  `ikpi_type` varchar(100) DEFAULT NULL,
  `ikpi_display` varchar(100) DEFAULT NULL,
  `ikpi_module` int(11) DEFAULT NULL,
  `ikpi_created` datetime DEFAULT NULL,
  `ikpi_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_messaging`
--

CREATE TABLE `i_messaging` (
  `ime_id` int(11) NOT NULL,
  `ime_title` varchar(200) DEFAULT NULL,
  `ime_file` varchar(200) DEFAULT NULL,
  `ime_owner` int(11) DEFAULT NULL,
  `ime_created` datetime DEFAULT NULL,
  `ime_created_by` int(11) DEFAULT NULL,
  `ime_status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_messaging`
--

INSERT INTO `i_messaging` (`ime_id`, `ime_title`, `ime_file`, `ime_owner`, `ime_created`, `ime_created_by`, `ime_status`) VALUES
(29, 'vinaya', '1551786187', 1, '2019-03-05 17:13:07', 1, 'true'),
(31, 'test share data', '1551944509', 1, '2019-03-07 13:11:49', 1, 'true'),
(32, 'test group 1', '1552047310', 1, '2019-03-08 17:45:10', 1, 'true'),
(33, 'kpatole', '1554361297', 1, '2019-04-04 12:31:37', 1, 'true'),
(34, 'welcome', '1554699995', 1, '2019-04-08 10:36:35', 1, 'true'),
(35, 'test', '1556268266', 1, '2019-04-26 14:14:26', 1, 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_modules`
--

CREATE TABLE `i_modules` (
  `im_id` int(11) NOT NULL,
  `im_name` varchar(100) DEFAULT NULL,
  `im_domain` int(11) DEFAULT NULL,
  `im_function` int(11) DEFAULT NULL,
  `im_created` datetime DEFAULT NULL,
  `im_created_by` int(11) DEFAULT NULL,
  `im_modified` datetime DEFAULT NULL,
  `im_modified_by` int(11) DEFAULT NULL,
  `im_desc` varchar(200) DEFAULT NULL,
  `im_price` int(11) DEFAULT NULL,
  `im_subscription` int(11) DEFAULT NULL,
  `im_publish` int(11) DEFAULT NULL,
  `im_benefit` varchar(500) DEFAULT NULL,
  `im_icon` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_modules`
--

INSERT INTO `i_modules` (`im_id`, `im_name`, `im_domain`, `im_function`, `im_created`, `im_created_by`, `im_modified`, `im_modified_by`, `im_desc`, `im_price`, `im_subscription`, `im_publish`, `im_benefit`, `im_icon`) VALUES
(33, 'Contact', 8, 109, '2018-07-04 13:07:34', 0, '2019-04-08 17:17:01', 0, 'contact module', 1000, 12, 0, '', NULL),
(34, 'Products', 8, 110, '2018-07-04 13:07:57', 0, '2019-04-08 17:17:10', 0, 'product', 1000, 12, 0, '', NULL),
(35, 'Invoice', 8, 113, '2018-07-06 11:07:15', 0, '2018-11-07 21:11:42', 0, 'invoice module', 1000, 12, 1, NULL, NULL),
(36, 'Inventory', 8, 114, '2018-07-09 11:07:34', 0, '2018-11-10 11:11:06', 0, 'inventory', 1000, 12, 1, NULL, NULL),
(38, 'Taxes', 8, 116, '2018-07-13 12:07:01', 0, '2019-04-08 17:17:19', 0, '', 1000, 12, 0, '', NULL),
(39, 'Tax Group', 8, 117, '2018-07-13 12:07:27', 0, '2019-01-24 15:01:25', 0, 'tax group', 1000, 12, 0, '', NULL),
(40, 'Purchase', 8, 118, '2018-07-19 10:07:46', 0, '2018-11-10 11:11:44', 0, '', 1000, 12, 1, NULL, NULL),
(41, 'Quotation', 8, 119, '2018-07-19 14:07:14', 0, '2019-01-24 15:01:18', 0, '', 1000, 12, 0, '', NULL),
(42, 'Subscription', 8, 120, '2018-07-19 16:07:21', 0, '2018-11-10 11:11:31', 0, '', 1000, 12, 1, NULL, NULL),
(43, 'Expenses', 8, 121, '2018-07-26 19:07:29', 0, '2018-11-10 11:11:26', 0, '', 1000, 12, 1, NULL, NULL),
(44, 'Research', 14, 122, '2018-08-06 12:08:45', 0, '2018-11-10 11:11:20', 0, 'welcome to research', 1000, 12, 1, NULL, NULL),
(48, 'Leads', 17, 131, '2018-09-18 11:09:28', 0, '2019-01-24 15:01:09', 0, 'Leads', 1000, 12, 0, '', NULL),
(49, 'Projects', 18, 132, '2018-09-20 19:09:05', 0, '2018-11-10 11:11:04', 0, '', 1000, 12, 1, NULL, NULL),
(50, 'Opportunity', 17, 131, '2018-09-24 16:09:00', 0, '2018-12-19 17:12:43', 0, 'Welcome to Opportunity', 1000, 12, 1, '', NULL),
(51, 'Proposal', 17, 134, '2018-09-28 17:09:15', 0, '2018-12-19 17:12:40', 0, 'add proposal 1', 1000, 12, 1, '', NULL),
(52, 'HR', 20, 135, '2018-10-31 15:10:05', 0, '2018-12-19 17:12:37', 0, 'welcome to HR module', 10000, 12, 1, '', NULL),
(53, 'Broadcast', 21, 136, '2018-11-10 12:11:53', 0, '2018-12-20 17:12:09', 0, 'welcome to broadcast', 1000, 12, 1, '', NULL),
(54, 'Support', 22, 137, '2019-01-04 14:25:24', 0, '2019-01-22 12:01:20', 0, '', 1, 0, 1, '', NULL),
(65, 'BOQ_fixed', 33, 148, '2019-04-22 15:32:45', 0, NULL, NULL, '', 1000, 12, 0, '', NULL),
(55, 'Barcode', 23, 138, '2019-02-21 12:44:42', 0, '2019-06-06 16:44:34', 0, '', 100, 0, 1, '', 'view_array'),
(56, 'Orders', 24, 139, '2019-02-22 12:26:07', 0, '2019-06-06 16:45:01', 0, '', 100, 0, 1, '', 'shopping_cart'),
(57, 'Letter', 25, 140, '2019-02-22 14:58:54', 0, '2019-02-22 14:58:58', 0, '', 1, 0, 1, '', NULL),
(58, 'Requirement', 26, 141, '2019-03-04 18:11:35', 0, '2019-03-04 18:15:06', 0, '', 100, 0, 1, '', NULL),
(59, 'Design Manager', 27, 142, '2019-03-06 12:21:51', 0, '2019-03-06 12:22:23', 0, '', 100, 0, 1, '', NULL),
(60, 'BOQ', 28, 143, '2019-03-09 09:58:32', 0, '2019-03-09 09:59:31', 0, '', 100, 0, 1, '', NULL),
(61, 'Quote compare', 29, 144, '2019-03-12 16:45:26', 0, '2019-03-12 16:45:30', 0, '', 100, 0, 1, '', NULL),
(62, 'Accounting', 30, 145, '2019-03-13 15:16:29', 0, '2019-03-13 15:16:34', 0, '', 100, 0, 1, '', NULL),
(63, 'Agreement', 31, 146, '2019-03-25 10:41:54', 0, '2019-05-16 17:33:32', 0, '', 100, 0, 1, '', NULL),
(64, 'Work Module', 32, 147, '2019-04-03 13:12:47', 0, '2019-04-03 13:12:56', 0, '', 10, 0, 1, '', NULL),
(66, 'Inventory_new', 34, 149, '2019-05-13 12:48:23', 0, '2019-05-13 12:48:28', 0, '', 100, 0, 1, '', NULL),
(67, 'Godown', 35, 150, '2019-05-16 15:00:45', 0, '2019-06-06 16:44:23', 0, '', 100, 0, 1, '', 'view_agenda'),
(68, 'Purchase_order', 36, 151, '2019-05-25 15:28:34', 0, '2019-06-05 12:27:16', 0, '', 100, 0, 1, '', NULL),
(69, 'Credit_note', 37, 152, '2019-05-27 12:31:37', 0, '2019-06-05 12:27:22', 0, '', 100, 0, 1, '', NULL),
(70, 'Debit_note', 38, 153, '2019-05-27 13:47:52', 0, '2019-06-05 12:38:02', 0, '', 100, 0, 1, '', NULL),
(71, 'Inward', 34, 154, '2019-06-03 11:23:12', 0, '2019-06-06 16:43:53', 0, '', 100, 0, 1, '', 'trending_up'),
(72, 'Outward', 34, 155, '2019-06-03 11:23:34', 0, '2019-06-06 16:44:06', 0, '', 100, 0, 1, '', 'trending_down'),
(73, 'Status', 34, 156, '2019-06-03 11:25:03', 0, '2019-06-06 17:42:56', 0, '', 100, 0, 1, '', 'assessment'),
(74, 'Accounts', 34, 157, '2019-06-03 11:30:35', 0, '2019-06-06 17:42:32', 0, '', 100, 0, 1, '', 'library_books'),
(75, 'Reports', 34, 158, '2019-06-03 11:31:41', 0, '2019-06-06 17:42:16', 0, '', 100, 0, 1, '', 'scatter_plot'),
(76, 'Inventory Settings', 34, 159, '2019-06-08 10:30:18', 0, '2019-06-19 12:01:06', 0, '', 0, 12, 0, '', 'settings'),
(77, 'Rejection In', 34, 160, '2019-06-14 11:04:24', 0, NULL, NULL, '', 100, 0, 0, '', 'arrow_downward'),
(78, 'Rejection Out', 34, 161, '2019-06-14 11:04:48', 0, '2019-06-19 12:01:15', 0, '', 100, 0, 0, '', 'arrow_upward'),
(79, 'Material In', 34, 162, '2019-06-14 12:58:59', 0, NULL, NULL, '', 100, 0, 0, '', 'trending_flat'),
(80, 'Material Out', 34, 163, '2019-06-14 12:59:35', 0, '2019-06-19 12:01:22', 0, '', 100, 0, 0, '', 'keyboard_backspace');

-- --------------------------------------------------------

--
-- Table structure for table `i_module_prefernces`
--

CREATE TABLE `i_module_prefernces` (
  `imp_id` int(11) NOT NULL,
  `imp_module_id` int(11) DEFAULT NULL,
  `imp_tag_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_m_files`
--

CREATE TABLE `i_m_files` (
  `imf_id` int(11) NOT NULL,
  `imf_mid` int(11) DEFAULT NULL,
  `imf_file` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_m_members`
--

CREATE TABLE `i_m_members` (
  `imm_id` int(11) NOT NULL,
  `imm_m_id` int(11) DEFAULT NULL,
  `imm_c_id` int(11) DEFAULT NULL,
  `imm_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_m_members`
--

INSERT INTO `i_m_members` (`imm_id`, `imm_m_id`, `imm_c_id`, `imm_owner`) VALUES
(73, 29, 1, 1),
(74, 29, 3, 1),
(81, 31, 1, 1),
(82, 31, 2, 1),
(83, 31, 3, 1),
(85, 32, 2, 1),
(86, 32, 3, 1),
(87, 32, 1, 1),
(88, 33, 1, 1),
(89, 33, 2, 1),
(91, 34, 3, 1),
(92, 34, 1, 1),
(93, 35, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_m_shortcuts`
--

CREATE TABLE `i_m_shortcuts` (
  `ims_id` int(11) NOT NULL,
  `ims_m_id` int(11) DEFAULT NULL,
  `ims_function` int(11) DEFAULT NULL,
  `ims_created` datetime DEFAULT NULL,
  `ims_created_by` int(11) DEFAULT NULL,
  `ims_modify` datetime DEFAULT NULL,
  `ims_modified_by` int(11) DEFAULT NULL,
  `ims_name` varchar(50) DEFAULT NULL,
  `ims_icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_m_shortcuts`
--

INSERT INTO `i_m_shortcuts` (`ims_id`, `ims_m_id`, `ims_function`, `ims_created`, `ims_created_by`, `ims_modify`, `ims_modified_by`, `ims_name`, `ims_icon`) VALUES
(10, 41, 127, '2018-08-29 00:00:00', 0, NULL, NULL, 'Add quotation', 'add'),
(11, 40, 128, '2018-08-29 00:00:00', 0, NULL, NULL, 'Add purchase', 'add'),
(12, 36, 126, '2018-08-29 00:00:00', 0, NULL, NULL, 'Add inventory', 'add'),
(13, 35, 125, '2018-08-29 00:00:00', 0, NULL, NULL, 'Add invoice', 'add'),
(21, 42, 124, '2018-08-30 00:00:00', 0, NULL, NULL, 'Add subscription', 'add'),
(22, 68, 151, '2019-05-27 00:00:00', 0, NULL, NULL, 'Add Purchase Order', 'add');

-- --------------------------------------------------------

--
-- Table structure for table `i_notifications`
--

CREATE TABLE `i_notifications` (
  `in_id` int(11) NOT NULL,
  `in_type_id` int(11) DEFAULT NULL,
  `in_type` varchar(50) DEFAULT NULL,
  `in_m_id` int(11) DEFAULT NULL,
  `in_person` int(11) DEFAULT NULL,
  `in_owner` int(11) DEFAULT NULL,
  `in_status` varchar(200) DEFAULT NULL,
  `in_date` datetime DEFAULT NULL,
  `in_content` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_notifications`
--

INSERT INTO `i_notifications` (`in_id`, `in_type_id`, `in_type`, `in_m_id`, `in_person`, `in_owner`, `in_status`, `in_date`, `in_content`) VALUES
(1, 9, 'inward', 0, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(2, 9, 'inward', 0, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(3, 10, 'inward', 72, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(4, 10, 'inward', 0, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(5, 10, 'inward', 0, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(6, 10, 'inward', 0, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(7, 10, 'inward', 0, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(8, 10, 'inward', 0, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(9, 10, 'inward', NULL, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(10, 10, 'inward', 71, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(11, 10, 'inward', 71, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(12, 11, 'inward', 71, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(13, 12, 'inward', 71, 134, 19, '0', '2019-06-10 00:00:00', NULL),
(14, 12, 'inward', 71, 134, 19, '0', '2019-06-10 00:00:00', NULL),
(15, 11, 'inward', 71, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(16, 12, 'inward', 71, 134, 19, '0', '2019-06-10 00:00:00', NULL),
(17, 12, 'inward', 71, 134, 19, '0', '2019-06-10 00:00:00', NULL),
(18, 1296, 'activity', 0, NULL, 19, '0', '2019-06-04 15:36:24', NULL),
(19, 13, 'inward', 71, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(20, 14, 'inward', 71, 134, 19, '0', '2019-06-10 00:00:00', NULL),
(21, 15, 'inward', 71, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(22, 16, 'outward', 72, 138, 19, '0', '2019-06-10 00:00:00', NULL),
(23, 16, 'outward', 72, 138, 19, '0', '2019-06-10 00:00:00', NULL),
(24, 16, 'outward', 72, 138, 19, '0', '2019-06-10 00:00:00', NULL),
(25, 17, 'outward', 72, 138, 19, '0', '2019-06-10 00:00:00', NULL),
(26, 18, 'outward', 72, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(27, 17, 'outward', 72, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(28, 17, 'outward', 72, 138, 19, '0', '2019-06-10 00:00:00', NULL),
(29, 19, 'outward', 72, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(30, 17, 'outward', 72, 138, 19, '0', '2019-06-10 00:00:00', NULL),
(31, 20, 'outward', 72, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(32, 21, 'outward', 72, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(33, 21, 'outward', 72, 121, 19, '0', '2019-06-10 00:00:00', NULL),
(34, 22, 'outward', 72, 138, 19, '0', '2019-06-10 00:00:00', NULL),
(35, 23, 'inward', 71, 134, 19, '0', '2019-06-11 00:00:00', NULL),
(36, 23, 'inward', 71, 134, 19, '0', '2019-06-11 00:00:00', NULL),
(37, 23, 'inward', 71, 134, 19, '0', '2019-06-11 00:00:00', NULL),
(38, 24, 'inward', 71, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(39, 10, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(40, 11, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(41, 11, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(42, 12, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(43, 12, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(44, 11, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(45, 13, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(46, 14, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(47, 15, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(48, 15, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(49, 15, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(50, 16, 'orders', 56, 138, 19, '0', '2019-06-12 00:00:00', NULL),
(51, 24, 'inward', 71, 138, 19, '0', '2019-06-13 00:00:00', NULL),
(52, 25, 'inward', 71, 138, 19, '0', '2019-06-13 00:00:00', NULL),
(53, 25, 'inward', 71, 138, 19, '0', '2019-06-13 00:00:00', NULL),
(54, 26, 'rej_in', 77, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(55, 26, NULL, 77, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(56, 26, NULL, 77, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(57, 26, NULL, 77, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(58, 26, NULL, 77, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(59, 26, 'rej_in', 77, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(60, 27, 'rej_out', 78, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(61, 28, 'rej_in', 77, 138, 19, '0', '2019-06-14 00:00:00', NULL),
(62, 29, 'rej_in', 77, 121, 19, '0', '2019-06-14 00:00:00', NULL),
(63, 30, 'rej_in', 79, 140, 19, '0', '2019-06-14 00:00:00', NULL),
(64, 31, 'rej_in', 79, 141, 19, '0', '2019-06-14 00:00:00', NULL),
(65, 32, 'rej_in', 79, 142, 19, '0', '2019-06-14 00:00:00', NULL),
(66, 33, 'rej_in', 79, 143, 19, '0', '2019-06-14 00:00:00', NULL),
(67, 34, 'rej_in', 79, 0, 19, '0', '2019-06-14 00:00:00', NULL),
(68, 35, 'material_in', 79, 0, 19, '0', '2019-06-14 00:00:00', NULL),
(69, 35, 'material_in', 79, 144, 19, '0', '2019-06-14 00:00:00', NULL),
(70, 35, 'material_in', 79, 145, 19, '0', '2019-06-14 00:00:00', NULL),
(71, 35, 'material_in', 79, 146, 19, '0', '2019-06-14 00:00:00', NULL),
(72, 35, 'material_in', 79, 147, 19, '0', '2019-06-14 00:00:00', NULL),
(73, 35, 'material_in', 79, 0, 19, '0', '2019-06-14 00:00:00', NULL),
(74, 36, 'material_out', 80, 0, 19, '0', '2019-06-14 00:00:00', NULL),
(75, 1, 'inward', 71, 134, 19, '0', '2019-06-14 00:00:00', NULL),
(76, 2, 'material_in', 79, 0, 19, '0', '2019-06-14 00:00:00', NULL),
(77, 3, 'rej_in', 77, 121, 19, '0', '2019-06-14 00:00:00', NULL),
(78, 17, 'orders', 56, 148, 19, '0', '2019-06-19 00:00:00', NULL),
(79, 18, 'orders', 56, 121, 19, '0', '2019-06-19 00:00:00', NULL),
(80, 19, 'orders', 56, 138, 19, '0', '2019-06-19 00:00:00', NULL),
(81, 4, 'outward', 72, 121, 19, '0', '2019-06-19 00:00:00', NULL),
(82, 5, 'rej_in', 77, 121, 19, '0', '2019-06-19 00:00:00', NULL),
(83, 6, 'rej_out', 78, 121, 19, '0', '2019-06-19 00:00:00', NULL),
(84, 7, 'material_out', 80, 0, 19, '0', '2019-06-19 00:00:00', NULL),
(85, 7, 'material_out', 80, 0, 19, '0', '2019-06-19 00:00:00', NULL),
(86, 8, 'inward', 71, 2, 1, '0', '2019-06-19 00:00:00', NULL),
(87, 9, 'inward', 71, 1, 1, '0', '2019-06-19 00:00:00', NULL),
(88, 1, 'inward', 71, 1, 1, '0', '2019-06-19 00:00:00', NULL),
(89, 2, 'inward', 71, 8, 4, '0', '2019-06-20 00:00:00', NULL),
(90, 3, 'inward', 71, 8, 4, '0', '2019-06-20 00:00:00', NULL),
(91, 6, 'activity', 0, NULL, 4, '0', '2019-06-22 11:45:40', NULL),
(92, 4, 'inward', 71, 8, 4, '0', '2019-06-20 00:00:00', NULL),
(93, 5, 'outward', 72, 9, 4, '0', '2019-06-20 00:00:00', NULL),
(94, 6, 'material_in', 79, 0, 4, '0', '2019-06-20 00:00:00', NULL),
(95, 20, 'orders', 56, 9, 4, '0', '2019-06-20 00:00:00', NULL),
(96, 21, 'orders', 56, 9, 4, '0', '2019-06-20 00:00:00', NULL),
(97, 21, 'orders', 56, 9, 4, '0', '2019-06-20 00:00:00', NULL),
(98, 22, 'orders', 56, 9, 4, '0', '2019-06-20 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_pay_mode`
--

CREATE TABLE `i_pay_mode` (
  `ipm_id` int(11) NOT NULL,
  `ipm_mode` varchar(100) DEFAULT NULL,
  `ipm_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_pay_mode`
--

INSERT INTO `i_pay_mode` (`ipm_id`, `ipm_mode`, `ipm_owner`) VALUES
(2, 'Chequ', 6);

-- --------------------------------------------------------

--
-- Table structure for table `i_portal_module_activity_type`
--

CREATE TABLE `i_portal_module_activity_type` (
  `ipmat_id` int(11) NOT NULL,
  `ipmat_mid` int(11) DEFAULT NULL,
  `ipmat_mname` varchar(100) DEFAULT NULL,
  `ipmat_act_type` varchar(200) DEFAULT NULL,
  `ipmat_date_display` varchar(50) DEFAULT NULL,
  `ipmat_shortcut_display` varchar(50) DEFAULT NULL,
  `ipmat_category_display` varchar(50) DEFAULT NULL,
  `ipmat_created` datetime DEFAULT NULL,
  `ipmat_created_by` int(11) DEFAULT NULL,
  `ipmat_modified` datetime DEFAULT NULL,
  `ipmat_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_portal_module_activity_type`
--

INSERT INTO `i_portal_module_activity_type` (`ipmat_id`, `ipmat_mid`, `ipmat_mname`, `ipmat_act_type`, `ipmat_date_display`, `ipmat_shortcut_display`, `ipmat_category_display`, `ipmat_created`, `ipmat_created_by`, `ipmat_modified`, `ipmat_modified_by`) VALUES
(10, 0, '', 'Event', 'no', 'yes', 'yes', '2019-02-18 11:11:21', 0, NULL, NULL),
(12, 49, 'Projects', 'project', 'yes', 'yes', 'no', '2019-02-18 12:07:17', 0, '2019-02-20 14:27:37', 0),
(13, 42, 'Subscription', 'subscription', 'yes', 'no', 'yes', '2019-02-20 16:51:44', 0, NULL, NULL),
(14, 54, 'Support', 'support', 'yes', 'no', 'yes', '2019-02-21 11:28:35', 0, NULL, NULL),
(15, 50, 'Opportunity', 'opportunity', 'yes', 'no', 'yes', '2019-02-21 15:46:04', 0, NULL, NULL),
(16, 66, 'Inventory_new', 'purchase_order', 'yes', 'yes', 'no', '2019-05-27 17:59:51', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_portal_price`
--

CREATE TABLE `i_portal_price` (
  `ipprice_id` int(11) NOT NULL,
  `ipprice_name` varchar(200) DEFAULT NULL,
  `ipprice_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_portal_price`
--

INSERT INTO `i_portal_price` (`ipprice_id`, `ipprice_name`, `ipprice_amount`) VALUES
(1, 'group', 11111),
(2, 'storage', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `i_product`
--

CREATE TABLE `i_product` (
  `ip_id` int(11) NOT NULL,
  `ip_product` varchar(100) DEFAULT NULL,
  `ip_owner` int(11) DEFAULT NULL,
  `ip_created` datetime DEFAULT NULL,
  `ip_created_by` int(11) DEFAULT NULL,
  `ip_modified` datetime DEFAULT NULL,
  `ip_modified_by` int(11) DEFAULT NULL,
  `ip_section` varchar(100) DEFAULT NULL,
  `ip_gid` int(11) DEFAULT NULL,
  `ip_cat_id` int(11) DEFAULT NULL,
  `ip_limit` int(11) DEFAULT NULL,
  `ip_default_qty` int(11) DEFAULT NULL,
  `ip_barcode` varchar(200) DEFAULT NULL,
  `ip_publish` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_product`
--

INSERT INTO `i_product` (`ip_id`, `ip_product`, `ip_owner`, `ip_created`, `ip_created_by`, `ip_modified`, `ip_modified_by`, `ip_section`, `ip_gid`, `ip_cat_id`, `ip_limit`, `ip_default_qty`, `ip_barcode`, `ip_publish`) VALUES
(394, 'pro1', 1, '2019-03-05 10:34:39', 1, '2019-05-21 16:24:18', 1, 'Products', 0, 15, 10, 10, '10', 'true'),
(401, 'hello', 1, '2019-03-05 12:56:20', 1, '2019-05-15 10:52:00', 1, 'Products', 0, 20, 12, 1, NULL, NULL),
(402, 'Jonson', 1, '2019-03-05 13:00:19', 1, '2019-05-21 16:15:22', 1, 'Products', 0, 21, 0, 0, '0', 'false'),
(403, 'parale', 1, '2019-03-05 13:00:19', 1, '2019-05-14 10:37:27', 1, 'Products', 0, 20, 10, NULL, NULL, NULL),
(409, 'welcome', 1, '2019-03-05 14:54:40', 1, '2019-05-21 16:22:19', 1, 'Products', 0, 21, 0, 0, '0', 'true'),
(410, 'lams', 1, '2019-03-05 14:55:51', 1, '2019-05-22 11:22:19', 1, 'Products', 0, 20, 0, 0, '0', 'true'),
(412, 'test', 1, '2019-05-15 11:06:26', 1, NULL, NULL, 'Products', 0, 0, NULL, NULL, NULL, NULL),
(413, 'wall stand', 1, '2019-05-17 16:48:16', 1, '2019-05-25 16:01:28', 1, 'Products', 0, 0, 10, 0, '10', 'true'),
(414, 'Pen', 1, '2019-05-18 17:27:14', 1, '2019-05-25 16:01:51', 1, 'Products', 0, 0, 100, 80, '100', 'false'),
(415, '123', 1, '2019-05-22 12:22:26', 1, NULL, NULL, 'Products', 31, 0, NULL, NULL, NULL, NULL),
(417, '', 1, '2019-05-30 17:49:13', 1, NULL, NULL, 'Products', 0, 0, NULL, NULL, NULL, NULL),
(418, 'Jonson', 19, '2019-06-10 12:08:22', 19, NULL, NULL, 'Products', 36, 0, NULL, NULL, NULL, NULL),
(419, 'Parle-g', 19, '2019-06-10 12:08:22', 19, NULL, NULL, 'Products', 36, 0, NULL, NULL, NULL, NULL),
(420, 'pen', 19, '2019-06-14 17:02:22', 19, NULL, NULL, 'Products', 36, 0, NULL, NULL, NULL, NULL),
(421, '', 19, '2019-06-19 10:53:11', 19, NULL, NULL, 'Products', 36, 0, NULL, NULL, NULL, NULL),
(422, 'Wall Stand', 4, '2019-06-20 11:43:40', 4, NULL, NULL, 'Products', 4, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_product_cat`
--

CREATE TABLE `i_product_cat` (
  `iproc_id` int(11) NOT NULL,
  `iproc_name` varchar(200) DEFAULT NULL,
  `iproc_pid` int(11) DEFAULT NULL,
  `iproc_img` varchar(200) DEFAULT NULL,
  `iproc_oid` int(11) DEFAULT NULL,
  `iproc_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_product_cat`
--

INSERT INTO `i_product_cat` (`iproc_id`, `iproc_name`, `iproc_pid`, `iproc_img`, `iproc_oid`, `iproc_gid`) VALUES
(11, 'main', 0, '01544015358.svg', 188, 0),
(12, 'main 1.1', 11, '01544015376.svg', 188, 0),
(13, 'another', 0, '01544015411.svg', 188, 0),
(14, 'another 1.1', 13, '01544018190.svg', 188, 0),
(15, 'Main 1', 20, NULL, 1, 0),
(16, 'Main 2', 0, NULL, 188, 0),
(17, 'Main 3', 0, NULL, 188, 0),
(18, 'Main 4', 0, NULL, 188, 0),
(19, 'Main 5', 0, NULL, 188, 0),
(20, 'main', 0, NULL, 1, 0),
(21, 'welcome', 0, '01557226513.png', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_product_pic`
--

CREATE TABLE `i_product_pic` (
  `ipp_id` int(11) NOT NULL,
  `ipp_file` varchar(100) DEFAULT NULL,
  `ipp_pid` int(11) DEFAULT NULL,
  `ipp_timestamp` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_product_pic`
--

INSERT INTO `i_product_pic` (`ipp_id`, `ipp_file`, `ipp_pid`, `ipp_timestamp`) VALUES
(1, '11538127242', 249, '01538457733.png'),
(2, '21538127079', 249, '11538457733.png'),
(3, '21538127242', 249, '21538457733.png'),
(4, '31538127079', 249, '31538457734.png'),
(5, '01538127079', 219, '01538460151.png'),
(6, '01538127242', 219, '11538460151.png'),
(7, '01538457733', 219, '21538460151.png'),
(8, '11538127079', 219, '31538460151.png'),
(9, '11538127242', 219, '41538460151.png'),
(10, '11538457733', 219, '51538460151.png'),
(11, '21538127079', 219, '61538460151.png'),
(12, '21538127242', 219, '71538460151.png'),
(13, '21538457733', 219, '81538460151.png'),
(14, 'logo', 255, '01543488595.jpg'),
(15, 'logo', 257, '01543488925.jpg'),
(16, 'test', 258, '01544106605.svg'),
(17, '11th Sci Mum', 255, '01545981435.xls'),
(18, 'animation', 260, '01546496718.gif'),
(19, 'done2', 261, '01546498679.svg'),
(20, 'logo', 410, '01558503856.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `i_property`
--

CREATE TABLE `i_property` (
  `ip_id` int(11) NOT NULL,
  `ip_property` varchar(100) DEFAULT NULL,
  `ip_owner` int(11) DEFAULT NULL,
  `ip_section` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_property`
--

INSERT INTO `i_property` (`ip_id`, `ip_property`, `ip_owner`, `ip_section`) VALUES
(1, 'email', 188, 'customer'),
(2, 'sirname', 188, 'customer'),
(3, 'email', 1, 'customer'),
(4, 'email', 2, 'customer'),
(5, 'Address', 1, 'customer'),
(6, 'mobile no ', 1, 'customer'),
(7, 'mobile no 2', 1, 'customer'),
(8, 'site 2', 1, 'customer'),
(9, '1', 1, NULL),
(10, '2', 1, NULL),
(11, 'phone1', 1, NULL),
(12, 'phone2', 1, NULL),
(13, 'address1', 1, NULL),
(14, 'address2', 1, NULL),
(15, 'email1', 1, NULL),
(16, 'email2', 1, NULL),
(17, '1 prop', 1, NULL),
(18, '2 prop', 1, NULL),
(19, 'prop 1', 1, NULL),
(20, 'prop 2', 1, NULL),
(21, 'l1', 1, NULL),
(22, 'l2', 1, NULL),
(23, 'phone3', 1, NULL),
(24, 'address3', 1, NULL),
(25, 'email3', 1, NULL),
(26, 'lebel 1', 1, NULL),
(27, 'label 2', 1, NULL),
(28, 'asdf', 1, NULL),
(29, 'sfg', 1, NULL),
(30, 'test', 1, NULL),
(31, 'test 1', 1, NULL),
(32, 'test_label', 1, NULL),
(33, 'test_l2', 1, NULL),
(34, '123', 1, NULL),
(35, '123123', 1, NULL),
(36, NULL, 1, NULL),
(37, NULL, 1, NULL),
(38, '', 1, NULL),
(39, 'email4', 1, NULL),
(40, '4th lable', 1, NULL),
(41, 'phone4', 1, NULL),
(42, 'email5', 1, NULL),
(43, '5th lable', 1, NULL),
(44, 'email', NULL, 'customer'),
(45, 'email', 4, 'customer'),
(46, 'email', 5, 'customer'),
(47, 'email', 6, 'customer'),
(48, 'email', 14, 'customer'),
(49, 'email', 16, 'customer'),
(50, 'email', 19, 'customer'),
(51, 'email', 21, 'customer'),
(52, 'email', 21, 'customer'),
(53, 'email', 21, 'customer'),
(54, 'email', 21, 'customer'),
(55, 'email', 21, 'customer'),
(56, 'email', 22, 'customer'),
(57, 'address', 19, 'customer'),
(58, 'email', 2, 'customer'),
(59, 'email', 3, 'customer');

-- --------------------------------------------------------

--
-- Table structure for table `i_p_additional_info`
--

CREATE TABLE `i_p_additional_info` (
  `ipai_id` int(11) NOT NULL,
  `ipai_p_id` int(11) DEFAULT NULL,
  `ipai_hsn_code` varchar(100) DEFAULT NULL,
  `ipai_description` varchar(500) DEFAULT NULL,
  `ipai_unit` int(11) DEFAULT NULL,
  `ipai_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_p_additional_info`
--

INSERT INTO `i_p_additional_info` (`ipai_id`, `ipai_p_id`, `ipai_hsn_code`, `ipai_description`, `ipai_unit`, `ipai_owner`) VALUES
(1, 1, '123456', '3.6mm lens, 72 degree coverage', 1, 188),
(2, 25, '', '', 177, 188),
(3, 58, '', '', 176, 188),
(4, 2, '', '', 8, 188),
(5, 42, '', '', 74, 188),
(6, 104, '', '', 221, 188),
(7, 105, '', '', 11, 188),
(8, 22, '', '', 180, 188),
(9, 24, '', '', 182, 188),
(10, 13, '', '', 84, 188),
(11, 106, '', '', 23, 188),
(12, 107, '', '', 132, 188),
(13, 16, '', '', 157, 188),
(14, 108, '', '', 34, 188),
(15, 109, '', '', 35, 188),
(16, 110, '', '', 26, 188),
(17, 7, '', '', 56, 188),
(18, 4, '', '', 66, 188),
(19, 116, '', '', 39, 188),
(20, 119, '', '', 98, 188),
(21, 113, '', '', 47, 188),
(22, 114, '', '', 42, 188),
(23, 112, '', '', 43, 188),
(24, 117, '', '', 90, 188),
(25, 118, '', '', 91, 188),
(26, 60, '', '', 97, 188),
(27, 15, '', '', 158, 188),
(28, 49, '', '', 51, 188),
(29, 26, '', '', 52, 188),
(30, 28, '', '', 53, 188),
(31, 35, '', '', 200, 188),
(32, 9, '', '', 62, 188),
(33, 6, '', '', 187, 188),
(34, 5, '', '', 60, 188),
(35, 10, '', '', 188, 188),
(36, 11, '', '', 186, 188),
(37, 12, '', '', 104, 188),
(38, 43, '', '', 73, 188),
(39, 23, '', '', 181, 188),
(40, 14, '', '', 79, 188),
(41, 41, '', '', 80, 188),
(42, 76, '', '', 81, 188),
(43, 51, '', '', 82, 188),
(44, 31, '', '', 93, 188),
(45, 66, '', '', 94, 188),
(46, 32, '', '', 99, 188),
(47, 50, '', '', 100, 188),
(48, 120, '', '', 102, 188),
(49, 21, '', '', 107, 188),
(50, 123, '', '', 108, 188),
(51, 124, '', '', 109, 188),
(52, 126, '', '', 112, 188),
(53, 127, '', '', 113, 188),
(54, 128, '', '', 114, 188),
(55, 129, '', '', 143, 188),
(56, 130, '', '', 137, 188),
(57, 131, '', '', 138, 188),
(58, 132, '', '', 136, 188),
(59, 133, '', '', 121, 188),
(60, 134, '', '', 141, 188),
(61, 135, '', '', 142, 188),
(62, 136, '', '', 144, 188),
(63, 137, '', '', 145, 188),
(64, 138, '', '', 146, 188),
(65, 139, '', '', 147, 188),
(66, 140, '', '', 148, 188),
(67, 141, '', '', 149, 188),
(68, 30, '', '', 150, 188),
(69, 152, '', '', 151, 188),
(70, 153, '', '', 152, 188),
(71, 159, '', '', 153, 188),
(72, 160, '', '', 154, 188),
(73, 162, '', '', 155, 188),
(74, 163, '', '', 156, 188),
(75, 164, '', '', 159, 188),
(76, 169, '', '', 160, 188),
(77, 173, '', '', 161, 188),
(78, 174, '', '', 164, 188),
(79, 175, '', '', 163, 188),
(80, 176, '', '', 165, 188),
(81, 177, '', '', 166, 188),
(82, 178, '', '', 168, 188),
(83, 158, '', '', 171, 188),
(84, 121, '', '', 178, 188),
(85, 179, '', '', 179, 188),
(86, 180, '', '', 183, 188),
(87, 181, '', '', 189, 188),
(88, 182, '', '', 196, 188),
(89, 183, '', '', 206, 188),
(90, 184, '', '', 197, 188),
(91, 185, '', '', 194, 188),
(92, 186, '', '', 201, 188),
(93, 187, '', '', 202, 188),
(94, 188, '', '', 203, 188),
(95, 189, '', '', 204, 188),
(96, 190, '', '', 205, 188),
(97, 95, '', '', 209, 188),
(98, 93, '', '', 208, 188),
(99, 94, '', '', 211, 188),
(100, 191, '', '', 214, 188),
(101, 192, '', '', 213, 188),
(102, 193, '', '', 216, 188),
(103, 194, '', '', 218, 188),
(104, 195, '', '', 222, 188),
(105, 196, '', '', 223, 188),
(106, 197, '123456', '3.6mm lens, 72 degree coverage', 199, 188),
(107, 221, '', '', 0, 188),
(108, 254, '', '', 0, 188),
(109, 198, '', '', 0, 188),
(110, 238, '', '', 0, 188),
(111, 300, '', '', 0, 188),
(112, 301, '', '', 0, 188),
(113, 218, '', '', 0, 188),
(114, 220, '', '', 0, 188),
(115, 209, '', '', 0, 188),
(116, 302, '', '', 0, 188),
(117, 303, '', '', 0, 188),
(118, 212, '', '', 0, 188),
(119, 304, '', '', 0, 188),
(120, 305, '', '', 0, 188),
(121, 306, '', '', 0, 188),
(122, 203, '', '', 0, 188),
(123, 200, '', '', 0, 188),
(124, 312, '', '', 0, 188),
(125, 315, '', '', 0, 188),
(126, 309, '', '', 0, 188),
(127, 310, '', '', 0, 188),
(128, 308, '', '', 0, 188),
(129, 313, '', '', 0, 188),
(130, 314, '', '', 0, 188),
(131, 256, '', '', 0, 188),
(132, 211, '', '', 0, 188),
(133, 245, '', '', 0, 188),
(134, 222, '', '', 0, 188),
(135, 224, '', '', 0, 188),
(136, 231, '', '', 0, 188),
(137, 205, '', '', 0, 188),
(138, 202, '', '', 0, 188),
(139, 201, '', '', 0, 188),
(140, 206, '', '', 0, 188),
(141, 207, '', '', 0, 188),
(142, 208, '', '', 0, 188),
(143, 239, '', '', 0, 188),
(144, 219, '', '', 0, 188),
(145, 210, '', '', 0, 188),
(146, 237, '', '', 0, 188),
(147, 272, '', '', 0, 188),
(148, 247, '', '', 0, 188),
(149, 227, '', '', 0, 188),
(150, 262, '', '', 0, 188),
(151, 228, '', '', 0, 188),
(152, 246, '', '', 0, 188),
(153, 316, '', '', 0, 188),
(154, 217, '', '', 0, 188),
(155, 319, '', '', 0, 188),
(156, 320, '', '', 0, 188),
(157, 322, '', '', 0, 188),
(158, 323, '', '', 0, 188),
(159, 324, '', '', 0, 188),
(160, 325, '', '', 0, 188),
(161, 326, '', '', 0, 188),
(162, 327, '', '', 0, 188),
(163, 328, '', '', 0, 188),
(164, 329, '', '', 0, 188),
(165, 330, '', '', 0, 188),
(166, 331, '', '', 0, 188),
(167, 332, '', '', 0, 188),
(168, 333, '', '', 0, 188),
(169, 334, '', '', 0, 188),
(170, 335, '', '', 0, 188),
(171, 336, '', '', 0, 188),
(172, 337, '', '', 0, 188),
(173, 226, '', '', 0, 188),
(174, 348, '', '', 0, 188),
(175, 349, '', '', 0, 188),
(176, 355, '', '', 0, 188),
(177, 356, '', '', 0, 188),
(178, 358, '', '', 0, 188),
(179, 359, '', '', 0, 188),
(180, 360, '', '', 0, 188),
(181, 365, '', '', 0, 188),
(182, 369, '', '', 0, 188),
(183, 370, '', '', 0, 188),
(184, 371, '', '', 0, 188),
(185, 372, '', '', 0, 188),
(186, 373, '', '', 0, 188),
(187, 374, '', '', 0, 188),
(188, 354, '', '', 0, 188),
(189, 317, '', '', 0, 188),
(190, 375, '', '', 0, 188),
(191, 376, '', '', 0, 188),
(192, 377, '', '', 0, 188),
(193, 378, '', '', 0, 188),
(194, 379, '', '', 0, 188),
(195, 380, '', '', 0, 188),
(196, 381, '', '', 0, 188),
(197, 382, '', '', 0, 188),
(198, 383, '', '', 0, 188),
(199, 384, '', '', 0, 188),
(200, 385, '', '', 0, 188),
(201, 386, '', '', 0, 188),
(202, 291, '', '', 0, 188),
(203, 289, '', '', 0, 188),
(204, 290, '', '', 0, 188),
(205, 387, '', '', 0, 188),
(206, 388, '', '', 0, 188),
(207, 389, '', '', 0, 188),
(208, 390, '', '', 0, 188),
(209, 391, '', '', 0, 188),
(210, 392, '', '', 0, 188),
(235, 394, '', '', 259, 1),
(212, 411, '', '', 236, 1),
(215, 395, '', 'best product ', 239, 1),
(214, 396, '', '', 238, 1),
(217, 403, '', '', 241, 1),
(218, 401, '', '', 242, 1),
(232, 402, '', '', 256, 1),
(234, 409, '', '', 258, 1),
(241, 410, '', '', 265, 1),
(245, 413, '', 'Mounting a TV is a great idea — today’s ultra-thin panels (like LG’s Wallpaper TVs) look fabulous on the wall, and it saves space, too. Doing this yourself may seem daunting, but mounting a TV isn’t actually all that hard. It starts with picking the right kind of wall mount, and that’s surprisingly easy. In this guide, we cover what you need to consider when shopping for the perfect mount, including what your wall is made of, your TVs specifications, and the different mount types available.', 269, 1),
(246, 414, '', '', 270, 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_p_child_product`
--

CREATE TABLE `i_p_child_product` (
  `ipcp_id` int(11) NOT NULL,
  `ipcp_p_pid` int(11) DEFAULT NULL,
  `ipcp_c_pid` int(11) DEFAULT NULL,
  `ipcp_owner` int(11) DEFAULT NULL,
  `ipcp_qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_p_child_product`
--

INSERT INTO `i_p_child_product` (`ipcp_id`, `ipcp_p_pid`, `ipcp_c_pid`, `ipcp_owner`, `ipcp_qty`) VALUES
(9, 261, 253, 188, NULL),
(10, 261, 255, 188, NULL),
(11, 261, 258, 188, NULL),
(23, 269, 263, 188, 1),
(24, 269, 264, 188, 2),
(25, 269, 265, 188, 3),
(26, 269, 267, 188, 4),
(30, 272, 263, 188, 1),
(31, 272, 267, 188, 1),
(32, 272, 258, 188, 1),
(33, 253, 10, 188, 1),
(34, 253, 262, 188, 1),
(35, 253, 263, 188, 2),
(36, 253, 264, 188, 2),
(41, 276, 10, 188, 1),
(42, 276, 262, 188, 2),
(43, 276, 263, 188, 3),
(44, 276, 264, 188, 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_p_features`
--

CREATE TABLE `i_p_features` (
  `ipf_id` int(11) NOT NULL,
  `ipf_product_id` int(11) DEFAULT NULL,
  `ipf_feature` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_p_features`
--

INSERT INTO `i_p_features` (`ipf_id`, `ipf_product_id`, `ipf_feature`) VALUES
(1, 1, ''),
(2, 197, ''),
(16, 413, 'f3'),
(15, 413, 'f2'),
(14, 413, 'f1'),
(10, 412, 'welcome to fe');

-- --------------------------------------------------------

--
-- Table structure for table `i_p_f_tags`
--

CREATE TABLE `i_p_f_tags` (
  `ipft_id` int(11) NOT NULL,
  `ipft_product_id` int(11) DEFAULT NULL,
  `ipft_tag_id` int(11) DEFAULT NULL,
  `ipft_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_p_f_tags`
--

INSERT INTO `i_p_f_tags` (`ipft_id`, `ipft_product_id`, `ipft_tag_id`, `ipft_owner`) VALUES
(1, 4236, 157, 188),
(2, 4244, 159, 188),
(3, 4252, 160, 188),
(4, 4264, 161, 188),
(5, 4269, 162, 188),
(6, 4206, 159, 188),
(7, 4271, 159, 188),
(8, 4219, 164, 188),
(9, 4432, 184, 188),
(10, 4440, 186, 188),
(11, 4448, 187, 188),
(12, 4460, 188, 188),
(13, 4465, 189, 188),
(14, 4402, 186, 188),
(15, 4467, 186, 188),
(16, 4415, 191, 188),
(17, 4628, 211, 188),
(18, 4636, 213, 188),
(19, 4644, 214, 188),
(20, 4656, 215, 188),
(21, 4661, 216, 188),
(22, 4598, 213, 188),
(23, 4663, 213, 188),
(24, 4611, 218, 188),
(25, 4824, 238, 188),
(26, 4832, 240, 188),
(27, 4840, 241, 188),
(28, 4852, 242, 188),
(29, 4857, 243, 188),
(30, 4794, 240, 188),
(31, 4859, 240, 188),
(32, 4807, 245, 188),
(33, 5020, 265, 188),
(34, 5028, 267, 188),
(35, 5036, 268, 188),
(36, 5048, 269, 188),
(37, 5053, 270, 188),
(38, 4990, 267, 188),
(39, 5055, 267, 188),
(40, 5003, 272, 188),
(41, 5216, 292, 188),
(42, 5224, 294, 188),
(43, 5232, 295, 188),
(44, 5244, 296, 188),
(45, 5249, 297, 188),
(46, 5186, 294, 188),
(47, 5251, 294, 188),
(48, 5199, 299, 188),
(49, 5412, 319, 188),
(50, 5420, 321, 188),
(51, 5428, 322, 188),
(52, 5440, 323, 188),
(53, 5445, 324, 188),
(54, 5382, 321, 188),
(55, 5447, 321, 188),
(56, 5395, 326, 188),
(57, 5608, 346, 188),
(58, 5616, 348, 188),
(59, 5624, 349, 188),
(60, 5636, 350, 188),
(61, 5641, 351, 188),
(62, 5578, 348, 188),
(63, 5643, 348, 188),
(64, 5591, 353, 188),
(65, 5804, 373, 188),
(66, 5812, 375, 188),
(67, 5820, 376, 188),
(68, 5832, 377, 188),
(69, 5837, 378, 188),
(70, 5774, 375, 188),
(71, 5839, 375, 188),
(72, 5787, 380, 188),
(73, 6000, 400, 188),
(74, 6008, 402, 188),
(75, 6016, 403, 188),
(76, 6028, 404, 188),
(77, 6033, 405, 188),
(78, 5970, 402, 188),
(79, 6035, 402, 188),
(80, 5983, 407, 188),
(81, 6196, 427, 188),
(82, 6204, 429, 188),
(83, 6212, 430, 188),
(84, 6224, 431, 188),
(85, 6229, 432, 188),
(86, 6166, 429, 188),
(87, 6231, 429, 188),
(88, 6179, 434, 188),
(89, 7290, 1642, 6),
(90, 7298, 1644, 6),
(91, 7306, 1645, 6),
(92, 7318, 1646, 6),
(93, 7323, 1647, 6),
(94, 7260, 1644, 6),
(95, 7325, 1644, 6),
(96, 7273, 1649, 6),
(97, 7486, 1669, 6),
(98, 7494, 1671, 6),
(99, 7502, 1672, 6),
(100, 7514, 1673, 6),
(101, 7519, 1674, 6),
(102, 7456, 1671, 6),
(103, 7521, 1671, 6),
(104, 7469, 1676, 6),
(105, 7682, 1696, 188),
(106, 7690, 1698, 188),
(107, 7698, 1699, 188),
(108, 7710, 1700, 188),
(109, 7715, 1701, 188),
(110, 7652, 1698, 188),
(111, 7717, 1698, 188),
(112, 7665, 1703, 188),
(113, 7878, 1723, 188),
(114, 7886, 1725, 188),
(115, 7894, 1726, 188),
(116, 7906, 1727, 188),
(117, 7911, 1728, 188),
(118, 7848, 1725, 188),
(119, 7913, 1725, 188),
(120, 7861, 1730, 188),
(121, 8074, 1750, 188),
(122, 8082, 1752, 188),
(123, 8090, 1753, 188),
(124, 8102, 1754, 188),
(125, 8107, 1755, 188),
(126, 8044, 1752, 188),
(127, 8109, 1752, 188),
(128, 8057, 1757, 188),
(129, 8270, 1777, 188),
(130, 8278, 1779, 188),
(131, 8286, 1780, 188),
(132, 8298, 1781, 188),
(133, 8303, 1782, 188),
(134, 8240, 1779, 188),
(135, 8305, 1779, 188),
(136, 8253, 1784, 188),
(137, 8466, 1804, 188),
(138, 8474, 1806, 188),
(139, 8482, 1807, 188),
(140, 8494, 1808, 188),
(141, 8499, 1809, 188),
(142, 8436, 1806, 188),
(143, 8501, 1806, 188),
(144, 8449, 1811, 188),
(145, 8662, 1831, 188),
(146, 8670, 1833, 188),
(147, 8678, 1834, 188),
(148, 8690, 1835, 188),
(149, 8695, 1836, 188),
(150, 8632, 1833, 188),
(151, 8697, 1833, 188),
(152, 8645, 1838, 188),
(153, 8858, 1858, 188),
(154, 8866, 1860, 188),
(155, 8874, 1861, 188),
(156, 8886, 1862, 188),
(157, 8891, 1863, 188),
(158, 8828, 1860, 188),
(159, 8893, 1860, 188),
(160, 8841, 1865, 188),
(161, 9054, 1885, 188),
(162, 9062, 1887, 188),
(163, 9070, 1888, 188),
(164, 9082, 1889, 188),
(165, 9087, 1890, 188),
(166, 9024, 1887, 188),
(167, 9089, 1887, 188),
(168, 9037, 1892, 188),
(169, 9250, 1912, 188),
(170, 9258, 1914, 188),
(171, 9266, 1915, 188),
(172, 9278, 1916, 188),
(173, 9283, 1917, 188),
(174, 9220, 1914, 188),
(175, 9285, 1914, 188),
(176, 9233, 1919, 188),
(177, 9446, 1939, 188),
(178, 9454, 1941, 188),
(179, 9462, 1942, 188),
(180, 9474, 1943, 188),
(181, 9479, 1944, 188),
(182, 9416, 1941, 188),
(183, 9481, 1941, 188),
(184, 9429, 1946, 188),
(185, 9642, 1966, 188),
(186, 9650, 1968, 188),
(187, 9658, 1969, 188),
(188, 9670, 1970, 188),
(189, 9675, 1971, 188),
(190, 9612, 1968, 188),
(191, 9677, 1968, 188),
(192, 9625, 1973, 188),
(193, 9838, 1993, 6),
(194, 9846, 1995, 6),
(195, 9854, 1996, 6),
(196, 9866, 1997, 6),
(197, 9871, 1998, 6),
(198, 9808, 1995, 6),
(199, 9873, 1995, 6),
(200, 9821, 2000, 6),
(201, 10034, 2020, 6),
(202, 10042, 2022, 6),
(203, 10050, 2023, 6),
(204, 10062, 2024, 6),
(205, 10067, 2025, 6),
(206, 10004, 2022, 6),
(207, 10069, 2022, 6),
(208, 10017, 2027, 6),
(209, 38, 2047, 188),
(210, 46, 2049, 188),
(211, 54, 2050, 188),
(212, 66, 2051, 188),
(213, 71, 2052, 188),
(214, 8, 2049, 188),
(215, 73, 2049, 188),
(216, 21, 2054, 188),
(217, 234, 2074, 188),
(218, 242, 2076, 188),
(219, 250, 2077, 188),
(220, 262, 2078, 188),
(221, 267, 2079, 188),
(222, 204, 2076, 188),
(223, 269, 2076, 188),
(224, 217, 2081, 188);

-- --------------------------------------------------------

--
-- Table structure for table `i_p_price`
--

CREATE TABLE `i_p_price` (
  `ipp_id` int(11) NOT NULL,
  `ipp_p_id` int(11) DEFAULT NULL,
  `ipp_alias` varchar(100) DEFAULT NULL,
  `ipp_cost_price` int(11) DEFAULT NULL,
  `ipp_sell_price` int(11) DEFAULT NULL,
  `ipp_active_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_p_price`
--

INSERT INTO `i_p_price` (`ipp_id`, `ipp_p_id`, `ipp_alias`, `ipp_cost_price`, `ipp_sell_price`, `ipp_active_date`) VALUES
(1, 1, 'Outdoor Camera', 2500, 2700, '0000-00-00'),
(2, 4, '', 6800, 10800, '0000-00-00'),
(3, 7, '16 Ch. DVR  Dahua', 5100, 12500, '0000-00-00'),
(4, 10, '', 4400, 5400, '0000-00-00'),
(5, 24, 'M.R.E.08d', 1225, 2500, '0000-00-00'),
(6, 13, '', 4648, 10500, '0000-00-00'),
(7, 14, '', 150, 350, '0000-00-00'),
(8, 16, '', 7, 35, '0000-00-00'),
(9, 17, '', 11750, 0, '0000-00-00'),
(10, 18, '', 3475, 0, '0000-00-00'),
(11, 19, '', 365, 0, '0000-00-00'),
(12, 26, '', 38, 85, '0000-00-00'),
(13, 27, '', 36, 0, '0000-00-00'),
(14, 28, '', 38, 85, '0000-00-00'),
(15, 29, '', 8500, 0, '0000-00-00'),
(16, 30, '', 14750, 14750, '0000-00-00'),
(17, 31, '', 1250, 2500, '0000-00-00'),
(18, 34, '', 11650, 0, '0000-00-00'),
(19, 5, '2mp IR Dome indoor Camera 20 mtr', 1150, 2500, '0000-00-00'),
(20, 6, '2mp IR Bullet camera out door Dahua 30mtr.', 1350, 2500, '0000-00-00'),
(21, 35, '', 7500, 9800, '0000-00-00'),
(22, 36, 'Nextron 15\'\'', 2850, 3500, '0000-00-00'),
(23, 38, '20', 5875, 8500, '0000-00-00'),
(24, 39, '2MP Indoor Dome Camera', 1100, 2500, '0000-00-00'),
(25, 40, '2MP Out Door Bulet Camera', 1375, 2700, '0000-00-00'),
(26, 41, '', 500, 900, '0000-00-00'),
(27, 43, '', 3300, 9000, '0000-00-00'),
(28, 44, 'Biometric T&A Access Control', 3590, 6500, '0000-00-00'),
(29, 45, '', 200, 600, '0000-00-00'),
(30, 47, '', 1100, 2250, '0000-00-00'),
(31, 46, '24M38H', 11200, 13500, '0000-00-00'),
(32, 48, '', 2441, 7000, '0000-00-00'),
(33, 49, '', 0, 0, '0000-00-00'),
(34, 50, 'Honet VDP PBX', 7000, 9000, '0000-00-00'),
(35, 51, 'Honet Door Camera', 1500, 3000, '0000-00-00'),
(36, 52, 'Honet VDP', 0, 0, '0000-00-00'),
(37, 53, 'Out door Lobby Panel', 10700, 18000, '0000-00-00'),
(38, 54, '', 4500, 10000, '0000-00-00'),
(39, 55, '', 250, 750, '0000-00-00'),
(40, 56, '', 250, 750, '0000-00-00'),
(41, 57, '', 0, 0, '0000-00-00'),
(42, 58, 'M.R.E.03', 275, 500, '0000-00-00'),
(43, 25, 'M.R.E02a', 175, 350, '0000-00-00'),
(44, 59, 'Biometric machine', 9199, 13500, '0000-00-00'),
(45, 61, '6\"', 1000, 1600, '0000-00-00'),
(46, 63, '', 0, 0, '0000-00-00'),
(47, 62, '', 0, 0, '0000-00-00'),
(48, 64, '24\"×30\"×6\"', 0, 8100, '0000-00-00'),
(49, 65, '', 0, 0, '0000-00-00'),
(50, 66, 'UA24H4003ARLXL', 13000, 15500, '0000-00-00'),
(51, 67, '', 100, 300, '0000-00-00'),
(52, 70, 'Ess keypad for Access Control', 0, 0, '0000-00-00'),
(53, 71, '', 800, 1500, '0000-00-00'),
(54, 72, '', 1875, 0, '0000-00-00'),
(55, 8, 'Ahuja Digital Player', 4667, 9000, '0000-00-00'),
(56, 73, '', 4500, 9000, '0000-00-00'),
(57, 74, '', 5200, 7700, '0000-00-00'),
(58, 9, '', 950, 2500, '0000-00-00'),
(59, 75, '', 0, 75, '0000-00-00'),
(60, 76, '', 300, 850, '0000-00-00'),
(61, 77, '', 3450, 0, '0000-00-00'),
(62, 78, '', 390, 0, '0000-00-00'),
(63, 79, '', 1250, 0, '0000-00-00'),
(64, 80, '', 9735, 13000, '0000-00-00'),
(65, 81, '', 10, 15, '0000-00-00'),
(66, 82, '', 7, 12, '0000-00-00'),
(67, 83, '', 0, 0, '0000-00-00'),
(68, 33, '', 0, 0, '0000-00-00'),
(69, 84, '', 450, 0, '0000-00-00'),
(70, 85, '', 25, 50, '0000-00-00'),
(71, 86, '', 0, 0, '0000-00-00'),
(72, 87, '', 0, 0, '0000-00-00'),
(73, 88, '', 60, 0, '0000-00-00'),
(74, 89, '', 0, 0, '0000-00-00'),
(75, 90, '', 0, 0, '0000-00-00'),
(76, 91, '', 0, 0, '0000-00-00'),
(77, 93, '', 30, 15, '0000-00-00'),
(78, 96, '', 0, 0, '0000-00-00'),
(79, 97, '', 0, 0, '0000-00-00'),
(80, 98, '', 0, 0, '0000-00-00'),
(81, 99, '', 0, 0, '0000-00-00'),
(82, 100, '', 0, 0, '0000-00-00'),
(83, 101, '', 0, 0, '0000-00-00'),
(84, 102, '', 0, 0, '0000-00-00'),
(85, 103, '', 0, 0, '0000-00-00'),
(86, 2, '', 2000, 2500, '0000-00-00'),
(87, 42, '', 25, 100, '0000-00-00'),
(88, 104, 'CP VAC D10L2', 650, 2150, '0000-00-00'),
(89, 105, 'CP VAC T10PL2', 750, 2700, '0000-00-00'),
(90, 106, 'Cabling ', 0, 90, '0000-00-00'),
(91, 107, 'Wiring 4+1 Coaxial cable', 0, 65, '0000-00-00'),
(92, 108, '8 CH DVR with 1 SATA', 3500, 9000, '0000-00-00'),
(93, 109, '8 CH DVR with 1 SATA', 3500, 9000, '0000-00-00'),
(94, 110, '16 CH DVR 2 SATA', 9500, 15500, '0000-00-00'),
(95, 116, '', 0, 0, '0000-00-00'),
(96, 119, '', 12000, 16000, '0000-00-00'),
(97, 113, '', 0, 0, '0000-00-00'),
(98, 114, '', 0, 0, '0000-00-00'),
(99, 112, '', 0, 0, '0000-00-00'),
(100, 117, '', 1500, 2800, '0000-00-00'),
(101, 118, '', 850, 2500, '0000-00-00'),
(102, 60, '', 175, 350, '0000-00-00'),
(103, 15, '', 12, 45, '0000-00-00'),
(104, 23, 'M.R.E 06', 590, 1800, '0000-00-00'),
(105, 11, '', 2100, 7000, '0000-00-00'),
(106, 12, '', 1700, 3000, '0000-00-00'),
(107, 32, 'TD W8961N', 1800, 2300, '0000-00-00'),
(108, 21, 'Sony Smart TV', 31000, 46500, '0000-00-00'),
(109, 120, 'Sony Smart Wi Fi ', 34000, 51000, '0000-00-00'),
(110, 123, '', 3150, 5400, '0000-00-00'),
(111, 124, '', 950, 2700, '0000-00-00'),
(112, 126, '', 0, 0, '0000-00-00'),
(113, 127, 'VDA', 900, 1800, '0000-00-00'),
(114, 128, 'VDA repair charges', 0, 0, '0000-00-00'),
(115, 129, '', 1290, 1550, '0000-00-00'),
(116, 130, '', 1550, 2300, '0000-00-00'),
(117, 131, '', 1390, 1600, '0000-00-00'),
(118, 132, '', 15000, 22500, '0000-00-00'),
(119, 133, '', 4900, 13250, '0000-00-00'),
(120, 134, '32 CH Power supply panel with cable guide', 4500, 7750, '0000-00-00'),
(121, 135, '8TB HDD', 15650, 20000, '0000-00-00'),
(122, 136, '', 0, 2700, '0000-00-00'),
(123, 137, '', 45825, 0, '0000-00-00'),
(124, 138, '', 0, 0, '0000-00-00'),
(125, 139, '', 560, 1000, '0000-00-00'),
(126, 140, '', 600, 1500, '0000-00-00'),
(127, 141, '', 400, 1500, '0000-00-00'),
(128, 152, '', 250, 500, '0000-00-00'),
(129, 153, 'Audio Mike', 300, 500, '0000-00-00'),
(130, 159, '', 4500, 0, '0000-00-00'),
(131, 160, 'CP Plus Out Door HD Camera', 1300, 2800, '0000-00-00'),
(132, 162, '1 TB Hdd surveillance', 2550, 3500, '0000-00-00'),
(133, 163, '', 1050, 3000, '0000-00-00'),
(134, 164, '', 20, 45, '0000-00-00'),
(135, 169, '', 2450, 4608, '0000-00-00'),
(136, 173, '', 1000, 2000, '0000-00-00'),
(137, 174, '', 175, 350, '0000-00-00'),
(138, 175, '', 325, 750, '0000-00-00'),
(139, 176, '', 425, 950, '0000-00-00'),
(140, 177, 'ZDL9908', 3150, 5500, '0000-00-00'),
(141, 178, '', 470, 1800, '0000-00-00'),
(142, 158, '', 1150, 2500, '0000-00-00'),
(143, 22, 'M.R.E 04', 490, 1500, '0000-00-00'),
(144, 121, '', 0, 0, '0000-00-00'),
(145, 179, '', 350, 600, '0000-00-00'),
(146, 180, '', 75, 110, '0000-00-00'),
(147, 181, '', 0, 0, '0000-00-00'),
(148, 183, '', 2250, 3900, '0000-00-00'),
(149, 184, '16 Ch. Matrix NVR 1 slot HDD', 13500, 22000, '0000-00-00'),
(150, 185, '16 Ch. NVR Matrix 1601X', 15000, 25000, '0000-00-00'),
(151, 182, '16 Ch. NVR Matrix 1602X 2 slot HDD', 22110, 38000, '0000-00-00'),
(152, 186, '', 0, 0, '0000-00-00'),
(153, 187, '', 0, 0, '0000-00-00'),
(154, 188, '', 11350, 19500, '0000-00-00'),
(155, 189, '', 15650, 23500, '0000-00-00'),
(156, 190, '', 15650, 23500, '0000-00-00'),
(157, 95, '', 6, 9, '0000-00-00'),
(158, 94, '', 60, 90, '0000-00-00'),
(159, 191, '', 150, 225, '0000-00-00'),
(160, 192, '', 12, 18, '0000-00-00'),
(161, 193, '', 15, 25, '0000-00-00'),
(162, 194, '', 10, 15, '0000-00-00'),
(163, 195, '', 0, 0, '0000-00-00'),
(164, 196, '', 1100, 2500, '0000-00-00'),
(165, 197, 'Outdoor Camera', 2500, 2700, '0000-00-00'),
(166, 200, '', 6800, 10800, '0000-00-00'),
(167, 203, '16 Ch. DVR  Dahua', 5100, 12500, '0000-00-00'),
(168, 206, '', 4400, 5400, '0000-00-00'),
(169, 220, 'M.R.E.08d', 1225, 2500, '0000-00-00'),
(170, 209, '', 4648, 10500, '0000-00-00'),
(171, 210, '', 150, 350, '0000-00-00'),
(172, 212, '', 7, 35, '0000-00-00'),
(173, 213, '', 11750, 0, '0000-00-00'),
(174, 214, '', 3475, 0, '0000-00-00'),
(175, 215, '', 365, 0, '0000-00-00'),
(176, 222, '', 38, 85, '0000-00-00'),
(177, 223, '', 36, 0, '0000-00-00'),
(178, 224, '', 38, 85, '0000-00-00'),
(179, 225, '', 8500, 0, '0000-00-00'),
(180, 226, '', 14750, 14750, '0000-00-00'),
(181, 227, '', 1250, 2500, '0000-00-00'),
(182, 230, '', 11650, 0, '0000-00-00'),
(183, 201, '2mp IR Dome indoor Camera 20 mtr', 1150, 2500, '0000-00-00'),
(184, 202, '2mp IR Bullet camera out door Dahua 30mtr.', 1350, 2500, '0000-00-00'),
(185, 231, '', 7500, 9800, '0000-00-00'),
(186, 232, 'Nextron 15\'\'', 2850, 3500, '0000-00-00'),
(187, 234, '20', 5875, 8500, '0000-00-00'),
(188, 235, '2MP Indoor Dome Camera', 1100, 2500, '0000-00-00'),
(189, 236, '2MP Out Door Bulet Camera', 1375, 2700, '0000-00-00'),
(190, 237, '', 500, 900, '0000-00-00'),
(191, 239, '', 3300, 9000, '0000-00-00'),
(192, 240, 'Biometric T&A Access Control', 3590, 6500, '0000-00-00'),
(193, 241, '', 200, 600, '0000-00-00'),
(194, 243, '', 1100, 2250, '0000-00-00'),
(195, 242, '24M38H', 11200, 13500, '0000-00-00'),
(196, 244, '', 2441, 7000, '0000-00-00'),
(197, 245, '', 0, 0, '0000-00-00'),
(198, 246, 'Honet VDP PBX', 7000, 9000, '0000-00-00'),
(199, 247, 'Honet Door Camera', 1500, 3000, '0000-00-00'),
(200, 248, 'Honet VDP', 0, 0, '0000-00-00'),
(201, 249, 'Out door Lobby Panel', 10700, 18000, '0000-00-00'),
(202, 250, '', 4500, 10000, '0000-00-00'),
(203, 251, '', 250, 750, '0000-00-00'),
(204, 252, '', 250, 750, '0000-00-00'),
(205, 253, '', 0, 0, '0000-00-00'),
(206, 254, 'M.R.E.03', 275, 500, '0000-00-00'),
(207, 221, 'M.R.E02a', 175, 350, '0000-00-00'),
(208, 255, 'Biometric machine', 9199, 13500, '0000-00-00'),
(209, 257, '6\"', 1000, 1600, '0000-00-00'),
(210, 259, '', 0, 0, '0000-00-00'),
(211, 258, '', 0, 0, '0000-00-00'),
(212, 260, '24\"×30\"×6\"', 0, 8100, '0000-00-00'),
(213, 261, '', 0, 0, '0000-00-00'),
(214, 262, 'UA24H4003ARLXL', 13000, 15500, '0000-00-00'),
(215, 263, '', 100, 300, '0000-00-00'),
(216, 266, 'Ess keypad for Access Control', 0, 0, '0000-00-00'),
(217, 267, '', 800, 1500, '0000-00-00'),
(218, 268, '', 1875, 0, '0000-00-00'),
(219, 204, 'Ahuja Digital Player', 4667, 9000, '0000-00-00'),
(220, 269, '', 4500, 9000, '0000-00-00'),
(221, 270, '', 5200, 7700, '0000-00-00'),
(222, 205, '', 950, 2500, '0000-00-00'),
(223, 271, '', 0, 75, '0000-00-00'),
(224, 272, '', 300, 850, '0000-00-00'),
(225, 273, '', 3450, 0, '0000-00-00'),
(226, 274, '', 390, 0, '0000-00-00'),
(227, 275, '', 1250, 0, '0000-00-00'),
(228, 276, '', 9735, 13000, '0000-00-00'),
(229, 277, '', 10, 15, '0000-00-00'),
(230, 278, '', 7, 12, '0000-00-00'),
(231, 279, '', 0, 0, '0000-00-00'),
(232, 229, '', 0, 0, '0000-00-00'),
(233, 280, '', 450, 0, '0000-00-00'),
(234, 281, '', 25, 50, '0000-00-00'),
(235, 282, '', 0, 0, '0000-00-00'),
(236, 283, '', 0, 0, '0000-00-00'),
(237, 284, '', 60, 0, '0000-00-00'),
(238, 285, '', 0, 0, '0000-00-00'),
(239, 286, '', 0, 0, '0000-00-00'),
(240, 287, '', 0, 0, '0000-00-00'),
(241, 289, '', 30, 15, '0000-00-00'),
(242, 292, '', 0, 0, '0000-00-00'),
(243, 293, '', 0, 0, '0000-00-00'),
(244, 294, '', 0, 0, '0000-00-00'),
(245, 295, '', 0, 0, '0000-00-00'),
(246, 296, '', 0, 0, '0000-00-00'),
(247, 297, '', 0, 0, '0000-00-00'),
(248, 298, '', 0, 0, '0000-00-00'),
(249, 299, '', 0, 0, '0000-00-00'),
(250, 198, '', 2000, 2500, '0000-00-00'),
(251, 238, '', 25, 100, '0000-00-00'),
(252, 300, 'CP VAC D10L2', 650, 2150, '0000-00-00'),
(253, 301, 'CP VAC T10PL2', 750, 2700, '0000-00-00'),
(254, 302, 'Cabling ', 0, 90, '0000-00-00'),
(255, 303, 'Wiring 4+1 Coaxial cable', 0, 65, '0000-00-00'),
(256, 304, '8 CH DVR with 1 SATA', 3500, 9000, '0000-00-00'),
(257, 305, '8 CH DVR with 1 SATA', 3500, 9000, '0000-00-00'),
(258, 306, '16 CH DVR 2 SATA', 9500, 15500, '0000-00-00'),
(259, 312, '', 0, 0, '0000-00-00'),
(260, 315, '', 12000, 16000, '0000-00-00'),
(261, 309, '', 0, 0, '0000-00-00'),
(262, 310, '', 0, 0, '0000-00-00'),
(263, 308, '', 0, 0, '0000-00-00'),
(264, 313, '', 1500, 2800, '0000-00-00'),
(265, 314, '', 850, 2500, '0000-00-00'),
(266, 256, '', 175, 350, '0000-00-00'),
(267, 211, '', 12, 45, '0000-00-00'),
(268, 219, 'M.R.E 06', 590, 1800, '0000-00-00'),
(269, 207, '', 2100, 7000, '0000-00-00'),
(270, 208, '', 1700, 3000, '0000-00-00'),
(271, 228, 'TD W8961N', 1800, 2300, '0000-00-00'),
(272, 217, 'Sony Smart TV', 31000, 46500, '0000-00-00'),
(273, 316, 'Sony Smart Wi Fi ', 34000, 51000, '0000-00-00'),
(274, 319, '', 3150, 5400, '0000-00-00'),
(275, 320, '', 950, 2700, '0000-00-00'),
(276, 322, '', 0, 0, '0000-00-00'),
(277, 323, 'VDA', 900, 1800, '0000-00-00'),
(278, 324, 'VDA repair charges', 0, 0, '0000-00-00'),
(279, 325, '', 1290, 1550, '0000-00-00'),
(280, 326, '', 1550, 2300, '0000-00-00'),
(281, 327, '', 1390, 1600, '0000-00-00'),
(282, 328, '', 15000, 22500, '0000-00-00'),
(283, 329, '', 4900, 13250, '0000-00-00'),
(284, 330, '32 CH Power supply panel with cable guide', 4500, 7750, '0000-00-00'),
(285, 331, '8TB HDD', 15650, 20000, '0000-00-00'),
(286, 332, '', 0, 2700, '0000-00-00'),
(287, 333, '', 45825, 0, '0000-00-00'),
(288, 334, '', 0, 0, '0000-00-00'),
(289, 335, '', 560, 1000, '0000-00-00'),
(290, 336, '', 600, 1500, '0000-00-00'),
(291, 337, '', 400, 1500, '0000-00-00'),
(292, 348, '', 250, 500, '0000-00-00'),
(293, 349, 'Audio Mike', 300, 500, '0000-00-00'),
(294, 355, '', 4500, 0, '0000-00-00'),
(295, 356, 'CP Plus Out Door HD Camera', 1300, 2800, '0000-00-00'),
(296, 358, '1 TB Hdd surveillance', 2550, 3500, '0000-00-00'),
(297, 359, '', 1050, 3000, '0000-00-00'),
(298, 360, '', 20, 45, '0000-00-00'),
(299, 365, '', 2450, 4608, '0000-00-00'),
(300, 369, '', 1000, 2000, '0000-00-00'),
(301, 370, '', 175, 350, '0000-00-00'),
(302, 371, '', 325, 750, '0000-00-00'),
(303, 372, '', 425, 950, '0000-00-00'),
(304, 373, 'ZDL9908', 3150, 5500, '0000-00-00'),
(305, 374, '', 470, 1800, '0000-00-00'),
(306, 354, '', 1150, 2500, '0000-00-00'),
(307, 218, 'M.R.E 04', 490, 1500, '0000-00-00'),
(308, 317, '', 0, 0, '0000-00-00'),
(309, 375, '', 350, 600, '0000-00-00'),
(310, 376, '', 75, 110, '0000-00-00'),
(311, 377, '', 0, 0, '0000-00-00'),
(312, 379, '', 2250, 3900, '0000-00-00'),
(313, 380, '16 Ch. Matrix NVR 1 slot HDD', 13500, 22000, '0000-00-00'),
(314, 381, '16 Ch. NVR Matrix 1601X', 15000, 25000, '0000-00-00'),
(315, 378, '16 Ch. NVR Matrix 1602X 2 slot HDD', 22110, 38000, '0000-00-00'),
(316, 382, '', 0, 0, '0000-00-00'),
(317, 383, '', 0, 0, '0000-00-00'),
(318, 384, '', 11350, 19500, '0000-00-00'),
(319, 385, '', 15650, 23500, '0000-00-00'),
(320, 386, '', 15650, 23500, '0000-00-00'),
(321, 291, '', 6, 9, '0000-00-00'),
(322, 290, '', 60, 90, '0000-00-00'),
(323, 387, '', 150, 225, '0000-00-00'),
(324, 388, '', 12, 18, '0000-00-00'),
(325, 389, '', 15, 25, '0000-00-00'),
(326, 390, '', 10, 15, '0000-00-00'),
(327, 391, '', 0, 0, '0000-00-00'),
(328, 392, '', 1100, 2500, '0000-00-00'),
(353, 394, 'product 1', 100, 1000, '0000-00-00'),
(332, 396, '', 0, 0, '0000-00-00'),
(333, 395, '', 0, 0, '0000-00-00'),
(335, 403, '', 0, 0, '0000-00-00'),
(336, 401, '', 0, 0, '0000-00-00'),
(350, 402, '', 0, 0, '0000-00-00'),
(352, 409, '', 0, 0, '0000-00-00'),
(359, 410, '', 0, 120, '0000-00-00'),
(363, 413, '', 0, 1000, '0000-00-00'),
(364, 414, '', 0, 0, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `i_p_specification`
--

CREATE TABLE `i_p_specification` (
  `ips_id` int(11) NOT NULL,
  `ips_pid` int(11) DEFAULT NULL,
  `ips_cat` varchar(200) DEFAULT NULL,
  `ips_val` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_p_specification`
--

INSERT INTO `i_p_specification` (`ips_id`, `ips_pid`, `ips_cat`, `ips_val`) VALUES
(2, 412, 'ram', '4gb'),
(3, 413, 'ram', '4gb'),
(4, 413, 'ram', '2gb');

-- --------------------------------------------------------

--
-- Table structure for table `i_p_taxes`
--

CREATE TABLE `i_p_taxes` (
  `ipt_id` int(11) NOT NULL,
  `ipt_p_id` int(11) DEFAULT NULL,
  `ipt_t_id` int(11) DEFAULT NULL,
  `ipt_oid` int(11) DEFAULT NULL,
  `ipt_created` datetime DEFAULT NULL,
  `ipt_created_by` int(11) DEFAULT NULL,
  `ipt_modified` datetime DEFAULT NULL,
  `ipt_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_p_taxes`
--

INSERT INTO `i_p_taxes` (`ipt_id`, `ipt_p_id`, `ipt_t_id`, `ipt_oid`, `ipt_created`, `ipt_created_by`, `ipt_modified`, `ipt_modified_by`) VALUES
(1, 1, 10, 188, '2018-01-29 13:01:00', 188, '0000-00-00 00:00:00', 188),
(2, 6, 10, 188, '2018-09-17 14:09:02', 188, '0000-00-00 00:00:00', 188),
(3, 4, 10, 188, '2018-02-21 13:02:10', 188, '0000-00-00 00:00:00', 188),
(4, 7, 10, 188, '2018-02-21 13:02:48', 188, '0000-00-00 00:00:00', 188),
(5, 10, 10, 188, '2018-09-17 14:09:33', 188, '0000-00-00 00:00:00', 188),
(6, 11, 10, 188, '2018-09-17 14:09:46', 188, '0000-00-00 00:00:00', 188),
(7, 12, 10, 188, '2018-03-15 13:03:18', 188, '0000-00-00 00:00:00', 188),
(8, 13, 10, 188, '2018-02-21 13:02:07', 188, '0000-00-00 00:00:00', 188),
(9, 14, 10, 188, '2018-02-21 13:02:19', 188, '0000-00-00 00:00:00', 188),
(10, 15, 10, 188, '2018-04-27 13:04:31', 188, '0000-00-00 00:00:00', 188),
(11, 16, 10, 188, '2018-04-27 13:04:13', 188, '0000-00-00 00:00:00', 188),
(12, 17, 10, 188, '2017-11-17 16:11:51', 188, '0000-00-00 00:00:00', 188),
(13, 18, 10, 188, '2017-11-17 16:11:28', 188, '0000-00-00 00:00:00', 188),
(14, 19, 10, 188, '2017-11-17 16:11:36', 188, '0000-00-00 00:00:00', 188),
(15, 22, 10, 188, '2018-06-18 12:06:19', 188, '0000-00-00 00:00:00', 188),
(16, 23, 10, 188, '2018-06-18 12:06:04', 188, '0000-00-00 00:00:00', 188),
(17, 24, 10, 188, '2018-06-18 12:06:33', 188, '0000-00-00 00:00:00', 188),
(18, 26, 10, 188, '2018-02-19 17:02:02', 188, '0000-00-00 00:00:00', 188),
(19, 27, 10, 188, '2017-12-02 16:12:43', 188, '0000-00-00 00:00:00', 188),
(20, 28, 10, 188, '2018-02-19 17:02:46', 188, '0000-00-00 00:00:00', 188),
(21, 29, 10, 188, '2017-12-02 16:12:21', 188, '0000-00-00 00:00:00', 188),
(22, 30, 10, 188, '2018-04-20 16:04:34', 188, '0000-00-00 00:00:00', 188),
(23, 31, 10, 188, '2018-02-21 14:02:55', 188, '0000-00-00 00:00:00', 188),
(24, 34, 10, 188, '2017-12-04 16:12:21', 188, '0000-00-00 00:00:00', 188),
(25, 5, 10, 188, '2018-02-21 13:02:01', 188, '0000-00-00 00:00:00', 188),
(26, 35, 10, 188, '2018-09-24 13:09:32', 188, '0000-00-00 00:00:00', 188),
(27, 36, 10, 188, '2017-12-11 15:12:53', 188, '0000-00-00 00:00:00', 188),
(28, 38, 10, 188, '2018-01-17 17:01:44', 188, '0000-00-00 00:00:00', 188),
(29, 39, 10, 188, '2017-12-20 14:12:31', 188, '0000-00-00 00:00:00', 188),
(30, 40, 10, 188, '2017-12-20 14:12:03', 188, '0000-00-00 00:00:00', 188),
(31, 41, 10, 188, '2018-02-21 13:02:13', 188, '0000-00-00 00:00:00', 188),
(32, 43, 10, 188, '2018-02-21 13:02:32', 188, '0000-00-00 00:00:00', 188),
(33, 44, 10, 188, '2017-12-29 13:12:59', 188, '0000-00-00 00:00:00', 188),
(34, 45, 10, 188, '2017-12-29 13:12:45', 188, '0000-00-00 00:00:00', 188),
(35, 47, 10, 188, '2017-12-29 13:12:04', 188, '0000-00-00 00:00:00', 188),
(36, 46, 10, 188, '2017-12-29 14:12:48', 188, '0000-00-00 00:00:00', 188),
(37, 48, 10, 188, '2018-01-17 12:01:58', 188, '0000-00-00 00:00:00', 188),
(38, 49, 10, 188, '2018-02-19 17:02:53', 188, '0000-00-00 00:00:00', 188),
(39, 50, 10, 188, '2018-03-10 11:03:28', 188, '0000-00-00 00:00:00', 188),
(40, 51, 10, 188, '2018-02-21 13:02:43', 188, '0000-00-00 00:00:00', 188),
(41, 52, 10, 188, '2018-01-02 13:01:40', 188, '0000-00-00 00:00:00', 188),
(42, 53, 10, 188, '2018-01-02 13:01:45', 188, '0000-00-00 00:00:00', 188),
(43, 54, 10, 188, '2018-01-04 11:01:02', 188, '0000-00-00 00:00:00', 188),
(44, 55, 10, 188, '2018-01-04 11:01:51', 188, '0000-00-00 00:00:00', 188),
(45, 56, 10, 188, '2018-01-04 11:01:02', 188, '0000-00-00 00:00:00', 188),
(46, 57, 10, 188, '2018-01-06 11:01:32', 188, '0000-00-00 00:00:00', 188),
(47, 58, 10, 188, '2018-06-06 13:06:50', 188, '0000-00-00 00:00:00', 188),
(48, 25, 10, 188, '2018-06-06 13:06:02', 188, '0000-00-00 00:00:00', 188),
(49, 59, 10, 188, '2018-01-08 16:01:08', 188, '0000-00-00 00:00:00', 188),
(50, 60, 10, 188, '2018-02-21 14:02:55', 188, '0000-00-00 00:00:00', 188),
(51, 61, 10, 188, '2018-01-09 13:01:05', 188, '0000-00-00 00:00:00', 188),
(52, 63, 10, 188, '2018-01-09 15:01:28', 188, '0000-00-00 00:00:00', 188),
(53, 62, 10, 188, '2018-01-09 15:01:00', 188, '0000-00-00 00:00:00', 188),
(54, 64, 10, 188, '2018-01-09 15:01:47', 188, '0000-00-00 00:00:00', 188),
(55, 65, 10, 188, '2018-01-09 15:01:57', 188, '0000-00-00 00:00:00', 188),
(56, 66, 11, 188, '2018-02-21 14:02:21', 188, '0000-00-00 00:00:00', 188),
(57, 67, 10, 188, '2018-01-11 11:01:58', 188, '0000-00-00 00:00:00', 188),
(58, 70, 10, 188, '2018-01-13 11:01:56', 188, '0000-00-00 00:00:00', 188),
(59, 71, 10, 188, '2018-01-13 11:01:43', 188, '0000-00-00 00:00:00', 188),
(60, 8, 10, 188, '2018-01-15 11:01:21', 188, '0000-00-00 00:00:00', 188),
(61, 73, 10, 188, '2018-01-15 11:01:39', 188, '0000-00-00 00:00:00', 188),
(62, 74, 10, 188, '2018-01-17 17:01:42', 188, '0000-00-00 00:00:00', 188),
(63, 76, 10, 188, '2018-02-21 13:02:14', 188, '0000-00-00 00:00:00', 188),
(64, 75, 10, 188, '2018-01-17 13:01:41', 188, '0000-00-00 00:00:00', 188),
(65, 9, 10, 188, '2018-02-21 13:02:55', 188, '0000-00-00 00:00:00', 188),
(66, 72, 10, 188, '2018-01-17 15:01:04', 188, '0000-00-00 00:00:00', 188),
(67, 77, 10, 188, '2018-01-17 15:01:10', 188, '0000-00-00 00:00:00', 188),
(68, 78, 10, 188, '2018-01-17 17:01:34', 188, '0000-00-00 00:00:00', 188),
(69, 79, 10, 188, '2018-01-17 17:01:22', 188, '0000-00-00 00:00:00', 188),
(70, 80, 10, 188, '2018-01-25 13:01:39', 188, '0000-00-00 00:00:00', 188),
(71, 81, 10, 188, '2018-01-27 14:01:12', 188, '0000-00-00 00:00:00', 188),
(72, 82, 10, 188, '2018-01-27 14:01:20', 188, '0000-00-00 00:00:00', 188),
(73, 83, 10, 188, '2018-01-27 14:01:57', 188, '0000-00-00 00:00:00', 188),
(74, 33, 10, 188, '2018-01-27 14:01:11', 188, '0000-00-00 00:00:00', 188),
(75, 84, 10, 188, '2018-01-27 14:01:34', 188, '0000-00-00 00:00:00', 188),
(76, 85, 10, 188, '2018-01-27 14:01:49', 188, '0000-00-00 00:00:00', 188),
(77, 86, 10, 188, '2018-01-27 14:01:56', 188, '0000-00-00 00:00:00', 188),
(78, 87, 10, 188, '2018-01-27 14:01:05', 188, '0000-00-00 00:00:00', 188),
(79, 88, 10, 188, '2018-01-27 14:01:50', 188, '0000-00-00 00:00:00', 188),
(80, 89, 10, 188, '2018-01-27 15:01:44', 188, '0000-00-00 00:00:00', 188),
(81, 90, 10, 188, '2018-01-27 14:01:17', 188, '0000-00-00 00:00:00', 188),
(82, 91, 10, 188, '2018-01-27 15:01:21', 188, '0000-00-00 00:00:00', 188),
(83, 93, 10, 188, '2018-09-24 13:09:43', 188, '0000-00-00 00:00:00', 188),
(84, 94, 10, 188, '2018-09-24 13:09:10', 188, '0000-00-00 00:00:00', 188),
(85, 95, 10, 188, '2018-09-24 13:09:23', 188, '0000-00-00 00:00:00', 188),
(86, 96, 10, 188, '2018-01-27 16:01:41', 188, '0000-00-00 00:00:00', 188),
(87, 97, 10, 188, '2018-01-27 16:01:09', 188, '0000-00-00 00:00:00', 188),
(88, 98, 10, 188, '2018-01-27 16:01:38', 188, '0000-00-00 00:00:00', 188),
(89, 99, 10, 188, '2018-01-27 16:01:02', 188, '0000-00-00 00:00:00', 188),
(90, 100, 10, 188, '2018-01-27 16:01:40', 188, '0000-00-00 00:00:00', 188),
(91, 101, 10, 188, '2018-01-27 16:01:11', 188, '0000-00-00 00:00:00', 188),
(92, 102, 10, 188, '2018-01-27 16:01:56', 188, '0000-00-00 00:00:00', 188),
(93, 103, 10, 188, '2018-01-27 16:01:23', 188, '0000-00-00 00:00:00', 188),
(94, 2, 10, 188, '2018-01-29 13:01:53', 188, '0000-00-00 00:00:00', 188),
(95, 42, 10, 188, '2018-02-21 13:02:52', 188, '0000-00-00 00:00:00', 188),
(96, 104, 10, 188, '2018-10-09 13:10:00', 188, '0000-00-00 00:00:00', 188),
(97, 105, 10, 188, '2018-01-29 14:01:46', 188, '0000-00-00 00:00:00', 188),
(98, 106, 10, 188, '2018-02-10 13:02:11', 188, '0000-00-00 00:00:00', 188),
(99, 107, 10, 188, '2018-04-03 12:04:41', 188, '0000-00-00 00:00:00', 188),
(100, 108, 10, 188, '2018-02-15 15:02:12', 188, '0000-00-00 00:00:00', 188),
(101, 109, 10, 188, '2018-02-15 15:02:41', 188, '0000-00-00 00:00:00', 188),
(102, 110, 10, 188, '2018-02-14 13:02:41', 188, '0000-00-00 00:00:00', 188),
(103, 116, 10, 188, '2018-02-16 17:02:52', 188, '0000-00-00 00:00:00', 188),
(104, 119, 10, 188, '2018-02-21 14:02:33', 188, '0000-00-00 00:00:00', 188),
(105, 113, 10, 188, '2018-02-16 17:02:52', 188, '0000-00-00 00:00:00', 188),
(106, 114, 10, 188, '2018-02-16 17:02:11', 188, '0000-00-00 00:00:00', 188),
(107, 112, 10, 188, '2018-02-16 17:02:38', 188, '0000-00-00 00:00:00', 188),
(108, 117, 10, 188, '2018-02-21 14:02:55', 188, '0000-00-00 00:00:00', 188),
(109, 118, 10, 188, '2018-02-21 14:02:03', 188, '0000-00-00 00:00:00', 188),
(110, 32, 10, 188, '2018-02-22 11:02:33', 188, '0000-00-00 00:00:00', 188),
(111, 120, 10, 188, '2018-03-15 13:03:18', 188, '0000-00-00 00:00:00', 188),
(112, 21, 10, 188, '2018-03-15 13:03:46', 188, '0000-00-00 00:00:00', 188),
(113, 123, 10, 188, '2018-03-17 15:03:27', 188, '0000-00-00 00:00:00', 188),
(114, 124, 10, 188, '2018-03-17 16:03:34', 188, '0000-00-00 00:00:00', 188),
(115, 126, 10, 188, '2018-03-26 12:03:42', 188, '0000-00-00 00:00:00', 188),
(116, 127, 10, 188, '2018-03-26 13:03:18', 188, '0000-00-00 00:00:00', 188),
(117, 128, 10, 188, '2018-03-27 14:03:07', 188, '0000-00-00 00:00:00', 188),
(118, 129, 10, 188, '2018-04-03 13:04:16', 188, '0000-00-00 00:00:00', 188),
(119, 130, 10, 188, '2018-04-03 12:04:47', 188, '0000-00-00 00:00:00', 188),
(120, 131, 10, 188, '2018-04-03 12:04:11', 188, '0000-00-00 00:00:00', 188),
(121, 132, 10, 188, '2018-04-03 12:04:13', 188, '0000-00-00 00:00:00', 188),
(122, 133, 10, 188, '2018-04-02 12:04:27', 188, '0000-00-00 00:00:00', 188),
(123, 134, 10, 188, '2018-04-03 13:04:05', 188, '0000-00-00 00:00:00', 188),
(124, 135, 10, 188, '2018-04-03 13:04:30', 188, '0000-00-00 00:00:00', 188),
(125, 136, 10, 188, '2018-04-06 15:04:36', 188, '0000-00-00 00:00:00', 188),
(126, 137, 10, 188, '2018-04-09 14:04:24', 188, '0000-00-00 00:00:00', 188),
(127, 139, 10, 188, '2018-04-14 11:04:18', 188, '0000-00-00 00:00:00', 188),
(128, 140, 10, 188, '2018-04-14 16:04:39', 188, '0000-00-00 00:00:00', 188),
(129, 141, 10, 188, '2018-04-14 16:04:54', 188, '0000-00-00 00:00:00', 188),
(130, 152, 10, 188, '2018-04-21 11:04:32', 188, '0000-00-00 00:00:00', 188),
(131, 153, 10, 188, '2018-04-23 11:04:20', 188, '0000-00-00 00:00:00', 188),
(132, 159, 10, 188, '2018-04-23 16:04:31', 188, '0000-00-00 00:00:00', 188),
(133, 160, 10, 188, '2018-04-25 11:04:55', 188, '0000-00-00 00:00:00', 188),
(134, 162, 10, 188, '2018-04-26 12:04:48', 188, '0000-00-00 00:00:00', 188),
(135, 163, 10, 188, '2018-04-27 13:04:15', 188, '0000-00-00 00:00:00', 188),
(136, 164, 10, 188, '2018-04-27 13:04:19', 188, '0000-00-00 00:00:00', 188),
(137, 169, 10, 188, '2018-05-04 12:05:46', 188, '0000-00-00 00:00:00', 188),
(138, 173, 10, 188, '2018-05-11 12:05:52', 188, '0000-00-00 00:00:00', 188),
(139, 174, 10, 188, '2018-05-28 17:05:24', 188, '0000-00-00 00:00:00', 188),
(140, 175, 10, 188, '2018-05-28 17:05:51', 188, '0000-00-00 00:00:00', 188),
(141, 176, 10, 188, '2018-05-28 17:05:51', 188, '0000-00-00 00:00:00', 188),
(142, 177, 10, 188, '2018-05-31 11:05:46', 188, '0000-00-00 00:00:00', 188),
(143, 178, 10, 188, '2018-06-01 14:06:38', 188, '0000-00-00 00:00:00', 188),
(144, 158, 10, 188, '2018-06-04 12:06:53', 188, '0000-00-00 00:00:00', 188),
(145, 121, 10, 188, '2018-06-08 12:06:56', 188, '0000-00-00 00:00:00', 188),
(146, 179, 10, 188, '2018-06-15 13:06:58', 188, '0000-00-00 00:00:00', 188),
(147, 180, 10, 188, '2018-08-30 12:08:26', 188, '0000-00-00 00:00:00', 188),
(148, 181, 10, 188, '2018-09-17 14:09:45', 188, '0000-00-00 00:00:00', 188),
(149, 182, 10, 188, '2018-09-24 13:09:12', 188, '0000-00-00 00:00:00', 188),
(150, 183, 10, 188, '2018-09-24 13:09:03', 188, '0000-00-00 00:00:00', 188),
(151, 184, 10, 188, '2018-09-24 13:09:21', 188, '0000-00-00 00:00:00', 188),
(152, 185, 10, 188, '2018-09-24 13:09:39', 188, '0000-00-00 00:00:00', 188),
(153, 188, 10, 188, '2018-09-24 13:09:19', 188, '0000-00-00 00:00:00', 188),
(154, 189, 10, 188, '2018-09-24 13:09:49', 188, '0000-00-00 00:00:00', 188),
(155, 190, 10, 188, '2018-09-24 13:09:00', 188, '0000-00-00 00:00:00', 188),
(156, 191, 10, 188, '2018-09-24 13:09:33', 188, '0000-00-00 00:00:00', 188),
(157, 192, 10, 188, '2018-09-24 13:09:49', 188, '0000-00-00 00:00:00', 188),
(158, 193, 10, 188, '2018-09-24 13:09:51', 188, '0000-00-00 00:00:00', 188),
(159, 194, 10, 188, '2018-09-24 13:09:44', 188, '0000-00-00 00:00:00', 188),
(160, 195, 10, 188, '2018-10-09 13:10:15', 188, '0000-00-00 00:00:00', 188),
(161, 196, 10, 188, '2018-10-31 10:10:08', 188, '0000-00-00 00:00:00', 188),
(162, 197, 10, 188, '2018-01-29 13:01:00', 188, '0000-00-00 00:00:00', 188),
(163, 202, 10, 188, '2018-09-17 14:09:02', 188, '0000-00-00 00:00:00', 188),
(164, 200, 10, 188, '2018-02-21 13:02:10', 188, '0000-00-00 00:00:00', 188),
(165, 203, 10, 188, '2018-02-21 13:02:48', 188, '0000-00-00 00:00:00', 188),
(166, 206, 10, 188, '2018-09-17 14:09:33', 188, '0000-00-00 00:00:00', 188),
(167, 207, 10, 188, '2018-09-17 14:09:46', 188, '0000-00-00 00:00:00', 188),
(168, 208, 10, 188, '2018-03-15 13:03:18', 188, '0000-00-00 00:00:00', 188),
(169, 209, 10, 188, '2018-02-21 13:02:07', 188, '0000-00-00 00:00:00', 188),
(170, 210, 10, 188, '2018-02-21 13:02:19', 188, '0000-00-00 00:00:00', 188),
(171, 211, 10, 188, '2018-04-27 13:04:31', 188, '0000-00-00 00:00:00', 188),
(172, 212, 10, 188, '2018-04-27 13:04:13', 188, '0000-00-00 00:00:00', 188),
(173, 213, 10, 188, '2017-11-17 16:11:51', 188, '0000-00-00 00:00:00', 188),
(174, 214, 10, 188, '2017-11-17 16:11:28', 188, '0000-00-00 00:00:00', 188),
(175, 215, 10, 188, '2017-11-17 16:11:36', 188, '0000-00-00 00:00:00', 188),
(176, 218, 10, 188, '2018-06-18 12:06:19', 188, '0000-00-00 00:00:00', 188),
(177, 219, 10, 188, '2018-06-18 12:06:04', 188, '0000-00-00 00:00:00', 188),
(178, 220, 10, 188, '2018-06-18 12:06:33', 188, '0000-00-00 00:00:00', 188),
(179, 222, 10, 188, '2018-02-19 17:02:02', 188, '0000-00-00 00:00:00', 188),
(180, 223, 10, 188, '2017-12-02 16:12:43', 188, '0000-00-00 00:00:00', 188),
(181, 224, 10, 188, '2018-02-19 17:02:46', 188, '0000-00-00 00:00:00', 188),
(182, 225, 10, 188, '2017-12-02 16:12:21', 188, '0000-00-00 00:00:00', 188),
(183, 226, 10, 188, '2018-04-20 16:04:34', 188, '0000-00-00 00:00:00', 188),
(184, 227, 10, 188, '2018-02-21 14:02:55', 188, '0000-00-00 00:00:00', 188),
(185, 230, 10, 188, '2017-12-04 16:12:21', 188, '0000-00-00 00:00:00', 188),
(186, 201, 10, 188, '2018-02-21 13:02:01', 188, '0000-00-00 00:00:00', 188),
(187, 231, 10, 188, '2018-09-24 13:09:32', 188, '0000-00-00 00:00:00', 188),
(188, 232, 10, 188, '2017-12-11 15:12:53', 188, '0000-00-00 00:00:00', 188),
(189, 234, 10, 188, '2018-01-17 17:01:44', 188, '0000-00-00 00:00:00', 188),
(190, 235, 10, 188, '2017-12-20 14:12:31', 188, '0000-00-00 00:00:00', 188),
(191, 236, 10, 188, '2017-12-20 14:12:03', 188, '0000-00-00 00:00:00', 188),
(192, 237, 10, 188, '2018-02-21 13:02:13', 188, '0000-00-00 00:00:00', 188),
(193, 239, 10, 188, '2018-02-21 13:02:32', 188, '0000-00-00 00:00:00', 188),
(194, 240, 10, 188, '2017-12-29 13:12:59', 188, '0000-00-00 00:00:00', 188),
(195, 241, 10, 188, '2017-12-29 13:12:45', 188, '0000-00-00 00:00:00', 188),
(196, 243, 10, 188, '2017-12-29 13:12:04', 188, '0000-00-00 00:00:00', 188),
(197, 242, 10, 188, '2017-12-29 14:12:48', 188, '0000-00-00 00:00:00', 188),
(198, 244, 10, 188, '2018-01-17 12:01:58', 188, '0000-00-00 00:00:00', 188),
(199, 245, 10, 188, '2018-02-19 17:02:53', 188, '0000-00-00 00:00:00', 188),
(200, 246, 10, 188, '2018-03-10 11:03:28', 188, '0000-00-00 00:00:00', 188),
(201, 247, 10, 188, '2018-02-21 13:02:43', 188, '0000-00-00 00:00:00', 188),
(202, 248, 10, 188, '2018-01-02 13:01:40', 188, '0000-00-00 00:00:00', 188),
(203, 249, 10, 188, '2018-01-02 13:01:45', 188, '0000-00-00 00:00:00', 188),
(204, 250, 10, 188, '2018-01-04 11:01:02', 188, '0000-00-00 00:00:00', 188),
(205, 251, 10, 188, '2018-01-04 11:01:51', 188, '0000-00-00 00:00:00', 188),
(206, 252, 10, 188, '2018-01-04 11:01:02', 188, '0000-00-00 00:00:00', 188),
(207, 253, 10, 188, '2018-01-06 11:01:32', 188, '0000-00-00 00:00:00', 188),
(208, 254, 10, 188, '2018-06-06 13:06:50', 188, '0000-00-00 00:00:00', 188),
(209, 221, 10, 188, '2018-06-06 13:06:02', 188, '0000-00-00 00:00:00', 188),
(210, 255, 10, 188, '2018-01-08 16:01:08', 188, '0000-00-00 00:00:00', 188),
(211, 256, 10, 188, '2018-02-21 14:02:55', 188, '0000-00-00 00:00:00', 188),
(212, 257, 10, 188, '2018-01-09 13:01:05', 188, '0000-00-00 00:00:00', 188),
(213, 259, 10, 188, '2018-01-09 15:01:28', 188, '0000-00-00 00:00:00', 188),
(214, 258, 10, 188, '2018-01-09 15:01:00', 188, '0000-00-00 00:00:00', 188),
(215, 260, 10, 188, '2018-01-09 15:01:47', 188, '0000-00-00 00:00:00', 188),
(216, 261, 10, 188, '2018-01-09 15:01:57', 188, '0000-00-00 00:00:00', 188),
(217, 262, 11, 188, '2018-02-21 14:02:21', 188, '0000-00-00 00:00:00', 188),
(218, 263, 10, 188, '2018-01-11 11:01:58', 188, '0000-00-00 00:00:00', 188),
(219, 266, 10, 188, '2018-01-13 11:01:56', 188, '0000-00-00 00:00:00', 188),
(220, 267, 10, 188, '2018-01-13 11:01:43', 188, '0000-00-00 00:00:00', 188),
(221, 204, 10, 188, '2018-01-15 11:01:21', 188, '0000-00-00 00:00:00', 188),
(222, 269, 10, 188, '2018-01-15 11:01:39', 188, '0000-00-00 00:00:00', 188),
(223, 270, 10, 188, '2018-01-17 17:01:42', 188, '0000-00-00 00:00:00', 188),
(224, 272, 10, 188, '2018-02-21 13:02:14', 188, '0000-00-00 00:00:00', 188),
(225, 271, 10, 188, '2018-01-17 13:01:41', 188, '0000-00-00 00:00:00', 188),
(226, 205, 10, 188, '2018-02-21 13:02:55', 188, '0000-00-00 00:00:00', 188),
(227, 268, 10, 188, '2018-01-17 15:01:04', 188, '0000-00-00 00:00:00', 188),
(228, 273, 10, 188, '2018-01-17 15:01:10', 188, '0000-00-00 00:00:00', 188),
(229, 274, 10, 188, '2018-01-17 17:01:34', 188, '0000-00-00 00:00:00', 188),
(230, 275, 10, 188, '2018-01-17 17:01:22', 188, '0000-00-00 00:00:00', 188),
(231, 276, 10, 188, '2018-01-25 13:01:39', 188, '0000-00-00 00:00:00', 188),
(232, 277, 10, 188, '2018-01-27 14:01:12', 188, '0000-00-00 00:00:00', 188),
(233, 278, 10, 188, '2018-01-27 14:01:20', 188, '0000-00-00 00:00:00', 188),
(234, 279, 10, 188, '2018-01-27 14:01:57', 188, '0000-00-00 00:00:00', 188),
(235, 229, 10, 188, '2018-01-27 14:01:11', 188, '0000-00-00 00:00:00', 188),
(236, 280, 10, 188, '2018-01-27 14:01:34', 188, '0000-00-00 00:00:00', 188),
(237, 281, 10, 188, '2018-01-27 14:01:49', 188, '0000-00-00 00:00:00', 188),
(238, 282, 10, 188, '2018-01-27 14:01:56', 188, '0000-00-00 00:00:00', 188),
(239, 283, 10, 188, '2018-01-27 14:01:05', 188, '0000-00-00 00:00:00', 188),
(240, 284, 10, 188, '2018-01-27 14:01:50', 188, '0000-00-00 00:00:00', 188),
(241, 285, 10, 188, '2018-01-27 15:01:44', 188, '0000-00-00 00:00:00', 188),
(242, 286, 10, 188, '2018-01-27 14:01:17', 188, '0000-00-00 00:00:00', 188),
(243, 287, 10, 188, '2018-01-27 15:01:21', 188, '0000-00-00 00:00:00', 188),
(244, 289, 10, 188, '2018-09-24 13:09:43', 188, '0000-00-00 00:00:00', 188),
(245, 290, 10, 188, '2018-09-24 13:09:10', 188, '0000-00-00 00:00:00', 188),
(246, 291, 10, 188, '2018-09-24 13:09:23', 188, '0000-00-00 00:00:00', 188),
(247, 292, 10, 188, '2018-01-27 16:01:41', 188, '0000-00-00 00:00:00', 188),
(248, 293, 10, 188, '2018-01-27 16:01:09', 188, '0000-00-00 00:00:00', 188),
(249, 294, 10, 188, '2018-01-27 16:01:38', 188, '0000-00-00 00:00:00', 188),
(250, 295, 10, 188, '2018-01-27 16:01:02', 188, '0000-00-00 00:00:00', 188),
(251, 296, 10, 188, '2018-01-27 16:01:40', 188, '0000-00-00 00:00:00', 188),
(252, 297, 10, 188, '2018-01-27 16:01:11', 188, '0000-00-00 00:00:00', 188),
(253, 298, 10, 188, '2018-01-27 16:01:56', 188, '0000-00-00 00:00:00', 188),
(254, 299, 10, 188, '2018-01-27 16:01:23', 188, '0000-00-00 00:00:00', 188),
(255, 198, 10, 188, '2018-01-29 13:01:53', 188, '0000-00-00 00:00:00', 188),
(256, 238, 10, 188, '2018-02-21 13:02:52', 188, '0000-00-00 00:00:00', 188),
(257, 300, 10, 188, '2018-10-09 13:10:00', 188, '0000-00-00 00:00:00', 188),
(258, 301, 10, 188, '2018-01-29 14:01:46', 188, '0000-00-00 00:00:00', 188),
(259, 302, 10, 188, '2018-02-10 13:02:11', 188, '0000-00-00 00:00:00', 188),
(260, 303, 10, 188, '2018-04-03 12:04:41', 188, '0000-00-00 00:00:00', 188),
(261, 304, 10, 188, '2018-02-15 15:02:12', 188, '0000-00-00 00:00:00', 188),
(262, 305, 10, 188, '2018-02-15 15:02:41', 188, '0000-00-00 00:00:00', 188),
(263, 306, 10, 188, '2018-02-14 13:02:41', 188, '0000-00-00 00:00:00', 188),
(264, 312, 10, 188, '2018-02-16 17:02:52', 188, '0000-00-00 00:00:00', 188),
(265, 315, 10, 188, '2018-02-21 14:02:33', 188, '0000-00-00 00:00:00', 188),
(266, 309, 10, 188, '2018-02-16 17:02:52', 188, '0000-00-00 00:00:00', 188),
(267, 310, 10, 188, '2018-02-16 17:02:11', 188, '0000-00-00 00:00:00', 188),
(268, 308, 10, 188, '2018-02-16 17:02:38', 188, '0000-00-00 00:00:00', 188),
(269, 313, 10, 188, '2018-02-21 14:02:55', 188, '0000-00-00 00:00:00', 188),
(270, 314, 10, 188, '2018-02-21 14:02:03', 188, '0000-00-00 00:00:00', 188),
(271, 228, 10, 188, '2018-02-22 11:02:33', 188, '0000-00-00 00:00:00', 188),
(272, 316, 10, 188, '2018-03-15 13:03:18', 188, '0000-00-00 00:00:00', 188),
(273, 217, 10, 188, '2018-03-15 13:03:46', 188, '0000-00-00 00:00:00', 188),
(274, 319, 10, 188, '2018-03-17 15:03:27', 188, '0000-00-00 00:00:00', 188),
(275, 320, 10, 188, '2018-03-17 16:03:34', 188, '0000-00-00 00:00:00', 188),
(276, 322, 10, 188, '2018-03-26 12:03:42', 188, '0000-00-00 00:00:00', 188),
(277, 323, 10, 188, '2018-03-26 13:03:18', 188, '0000-00-00 00:00:00', 188),
(278, 324, 10, 188, '2018-03-27 14:03:07', 188, '0000-00-00 00:00:00', 188),
(279, 325, 10, 188, '2018-04-03 13:04:16', 188, '0000-00-00 00:00:00', 188),
(280, 326, 10, 188, '2018-04-03 12:04:47', 188, '0000-00-00 00:00:00', 188),
(281, 327, 10, 188, '2018-04-03 12:04:11', 188, '0000-00-00 00:00:00', 188),
(282, 328, 10, 188, '2018-04-03 12:04:13', 188, '0000-00-00 00:00:00', 188),
(283, 329, 10, 188, '2018-04-02 12:04:27', 188, '0000-00-00 00:00:00', 188),
(284, 330, 10, 188, '2018-04-03 13:04:05', 188, '0000-00-00 00:00:00', 188),
(285, 331, 10, 188, '2018-04-03 13:04:30', 188, '0000-00-00 00:00:00', 188),
(286, 332, 10, 188, '2018-04-06 15:04:36', 188, '0000-00-00 00:00:00', 188),
(287, 333, 10, 188, '2018-04-09 14:04:24', 188, '0000-00-00 00:00:00', 188),
(288, 335, 10, 188, '2018-04-14 11:04:18', 188, '0000-00-00 00:00:00', 188),
(289, 336, 10, 188, '2018-04-14 16:04:39', 188, '0000-00-00 00:00:00', 188),
(290, 337, 10, 188, '2018-04-14 16:04:54', 188, '0000-00-00 00:00:00', 188),
(291, 348, 10, 188, '2018-04-21 11:04:32', 188, '0000-00-00 00:00:00', 188),
(292, 349, 10, 188, '2018-04-23 11:04:20', 188, '0000-00-00 00:00:00', 188),
(293, 355, 10, 188, '2018-04-23 16:04:31', 188, '0000-00-00 00:00:00', 188),
(294, 356, 10, 188, '2018-04-25 11:04:55', 188, '0000-00-00 00:00:00', 188),
(295, 358, 10, 188, '2018-04-26 12:04:48', 188, '0000-00-00 00:00:00', 188),
(296, 359, 10, 188, '2018-04-27 13:04:15', 188, '0000-00-00 00:00:00', 188),
(297, 360, 10, 188, '2018-04-27 13:04:19', 188, '0000-00-00 00:00:00', 188),
(298, 365, 10, 188, '2018-05-04 12:05:46', 188, '0000-00-00 00:00:00', 188),
(299, 369, 10, 188, '2018-05-11 12:05:52', 188, '0000-00-00 00:00:00', 188),
(300, 370, 10, 188, '2018-05-28 17:05:24', 188, '0000-00-00 00:00:00', 188),
(301, 371, 10, 188, '2018-05-28 17:05:51', 188, '0000-00-00 00:00:00', 188),
(302, 372, 10, 188, '2018-05-28 17:05:51', 188, '0000-00-00 00:00:00', 188),
(303, 373, 10, 188, '2018-05-31 11:05:46', 188, '0000-00-00 00:00:00', 188),
(304, 374, 10, 188, '2018-06-01 14:06:38', 188, '0000-00-00 00:00:00', 188),
(305, 354, 10, 188, '2018-06-04 12:06:53', 188, '0000-00-00 00:00:00', 188),
(306, 317, 10, 188, '2018-06-08 12:06:56', 188, '0000-00-00 00:00:00', 188),
(307, 375, 10, 188, '2018-06-15 13:06:58', 188, '0000-00-00 00:00:00', 188),
(308, 376, 10, 188, '2018-08-30 12:08:26', 188, '0000-00-00 00:00:00', 188),
(309, 377, 10, 188, '2018-09-17 14:09:45', 188, '0000-00-00 00:00:00', 188),
(310, 378, 10, 188, '2018-09-24 13:09:12', 188, '0000-00-00 00:00:00', 188),
(311, 379, 10, 188, '2018-09-24 13:09:03', 188, '0000-00-00 00:00:00', 188),
(312, 380, 10, 188, '2018-09-24 13:09:21', 188, '0000-00-00 00:00:00', 188),
(313, 381, 10, 188, '2018-09-24 13:09:39', 188, '0000-00-00 00:00:00', 188),
(314, 384, 10, 188, '2018-09-24 13:09:19', 188, '0000-00-00 00:00:00', 188),
(315, 385, 10, 188, '2018-09-24 13:09:49', 188, '0000-00-00 00:00:00', 188),
(316, 386, 10, 188, '2018-09-24 13:09:00', 188, '0000-00-00 00:00:00', 188),
(317, 387, 10, 188, '2018-09-24 13:09:33', 188, '0000-00-00 00:00:00', 188),
(318, 388, 10, 188, '2018-09-24 13:09:49', 188, '0000-00-00 00:00:00', 188),
(319, 389, 10, 188, '2018-09-24 13:09:51', 188, '0000-00-00 00:00:00', 188),
(320, 390, 10, 188, '2018-09-24 13:09:44', 188, '0000-00-00 00:00:00', 188),
(321, 391, 10, 188, '2018-10-09 13:10:15', 188, '0000-00-00 00:00:00', 188),
(322, 392, 10, 188, '2018-10-31 10:10:08', 188, '0000-00-00 00:00:00', 188),
(347, 394, 0, 1, '2019-05-21 16:24:18', 1, NULL, NULL),
(324, 411, 0, 1, '2019-04-01 16:51:17', 1, NULL, NULL),
(327, 395, 0, 1, '2019-05-13 16:53:01', 1, NULL, NULL),
(326, 396, 0, 1, '2019-05-13 13:17:59', 1, NULL, NULL),
(329, 403, 0, 1, '2019-05-14 10:37:27', 1, NULL, NULL),
(330, 401, 0, 1, '2019-05-15 10:52:00', 1, NULL, NULL),
(344, 402, 0, 1, '2019-05-21 16:15:22', 1, NULL, NULL),
(346, 409, 0, 1, '2019-05-21 16:22:19', 1, NULL, NULL),
(353, 410, 90, 1, '2019-05-22 11:22:19', 1, NULL, NULL),
(357, 413, 90, 1, '2019-05-25 16:01:28', 1, NULL, NULL),
(358, 414, 0, 1, '2019-05-25 16:01:51', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_store`
--

CREATE TABLE `i_store` (
  `is_id` int(11) NOT NULL,
  `is_uid` int(11) DEFAULT NULL,
  `is_mid` int(11) DEFAULT NULL,
  `is_status` varchar(50) DEFAULT NULL,
  `is_created` datetime DEFAULT NULL,
  `is_created_by` int(11) DEFAULT NULL,
  `is_modify` datetime DEFAULT NULL,
  `is_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_store`
--

INSERT INTO `i_store` (`is_id`, `is_uid`, `is_mid`, `is_status`, `is_created`, `is_created_by`, `is_modify`, `is_modified_by`) VALUES
(1, 6, 33, 'allot', '2018-09-14 10:09:24', 6, NULL, NULL),
(2, 6, 34, 'allot', '2018-09-14 10:09:24', 6, NULL, NULL),
(3, 6, 39, 'allot', '2018-09-14 10:09:24', 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_tags`
--

CREATE TABLE `i_tags` (
  `it_id` int(11) NOT NULL,
  `it_value` varchar(500) DEFAULT NULL,
  `it_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_tags`
--

INSERT INTO `i_tags` (`it_id`, `it_value`, `it_owner`) VALUES
(1, 'testing', 188),
(2, 'another', 188),
(3, 'product1', 188),
(4, 'stationary', 188),
(5, 'welcome', 188),
(6, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(7, 'DB8TO-Dbake Bldg.', 188),
(8, 'Chaitanya', 188),
(9, 'Goregaon', 188),
(10, 'Sai Sarovar', 188),
(11, 'TM10N2E - Chaitanya Goregaon', 188),
(12, 'TM10N3-26 & 13 Sai Sarovar', 188),
(13, 'Maitree Park', 188),
(14, '-0360B  - 8nos - Maitree Park', 188),
(15, '116HS-538714', 188),
(16, 'Damajibhai', 188),
(17, 'Sai Gabasti', 188),
(18, 'Vishal Diamond MIDC', 188),
(19, 'Malgudi-Turbhe', 188),
(20, 'Vishal', 188),
(21, 'New Dindoshi', 188),
(22, 'shree siddhi', 188),
(23, 'Anurag Nursing Home', 188),
(24, 'Practice Agile Solution Pvt.Ltd', 188),
(25, 'Mike Offset', 188),
(26, 'Surajmal Lallubhai', 188),
(27, 'Gokul Nagari', 188),
(28, 'Darshan Hights', 188),
(29, 'BNPL', 188),
(30, 'Office DVR', 188),
(31, 'Sanjuz Entrtentment', 188),
(32, 'A', 188),
(33, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(34, 'DB8TO-Dbake Bldg.', 188),
(35, 'Chaitanya', 188),
(36, 'Goregaon', 188),
(37, 'Sai Sarovar', 188),
(38, 'TM10N2E - Chaitanya Goregaon', 188),
(39, 'TM10N3-26 & 13 Sai Sarovar', 188),
(40, 'Maitree Park', 188),
(41, '-0360B  - 8nos - Maitree Park', 188),
(42, '116HS-538714', 188),
(43, 'Damajibhai', 188),
(44, 'Sai Gabasti', 188),
(45, 'Vishal Diamond MIDC', 188),
(46, 'Malgudi-Turbhe', 188),
(47, 'Vishal', 188),
(48, 'New Dindoshi', 188),
(49, 'shree siddhi', 188),
(50, 'Anurag Nursing Home', 188),
(51, 'Practice Agile Solution Pvt.Ltd', 188),
(52, 'Mike Offset', 188),
(53, 'Surajmal Lallubhai', 188),
(54, 'Gokul Nagari', 188),
(55, 'Darshan Hights', 188),
(56, 'BNPL', 188),
(57, 'Office DVR', 188),
(58, 'Sanjuz Entrtentment', 188),
(59, 'A', 188),
(60, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(61, 'DB8TO-Dbake Bldg.', 188),
(62, 'Chaitanya', 188),
(63, 'Goregaon', 188),
(64, 'Sai Sarovar', 188),
(65, 'TM10N2E - Chaitanya Goregaon', 188),
(66, 'TM10N3-26 & 13 Sai Sarovar', 188),
(67, 'Maitree Park', 188),
(68, '-0360B  - 8nos - Maitree Park', 188),
(69, '116HS-538714', 188),
(70, 'Damajibhai', 188),
(71, 'Sai Gabasti', 188),
(72, 'Vishal Diamond MIDC', 188),
(73, 'Malgudi-Turbhe', 188),
(74, 'Vishal', 188),
(75, 'New Dindoshi', 188),
(76, 'shree siddhi', 188),
(77, 'Anurag Nursing Home', 188),
(78, 'Practice Agile Solution Pvt.Ltd', 188),
(79, 'Mike Offset', 188),
(80, 'Surajmal Lallubhai', 188),
(81, 'Gokul Nagari', 188),
(82, 'Darshan Hights', 188),
(83, 'BNPL', 188),
(84, 'Office DVR', 188),
(85, 'Sanjuz Entrtentment', 188),
(86, 'A', 188),
(87, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(88, 'DB8TO-Dbake Bldg.', 188),
(89, 'Chaitanya', 188),
(90, 'Goregaon', 188),
(91, 'Sai Sarovar', 188),
(92, 'TM10N2E - Chaitanya Goregaon', 188),
(93, 'TM10N3-26 & 13 Sai Sarovar', 188),
(94, 'Maitree Park', 188),
(95, '-0360B  - 8nos - Maitree Park', 188),
(96, '116HS-538714', 188),
(97, 'Damajibhai', 188),
(98, 'Sai Gabasti', 188),
(99, 'Vishal Diamond MIDC', 188),
(100, 'Malgudi-Turbhe', 188),
(101, 'Vishal', 188),
(102, 'New Dindoshi', 188),
(103, 'shree siddhi', 188),
(104, 'Anurag Nursing Home', 188),
(105, 'Practice Agile Solution Pvt.Ltd', 188),
(106, 'Mike Offset', 188),
(107, 'Surajmal Lallubhai', 188),
(108, 'Gokul Nagari', 188),
(109, 'Darshan Hights', 188),
(110, 'BNPL', 188),
(111, 'Office DVR', 188),
(112, 'Sanjuz Entrtentment', 188),
(113, 'A', 188),
(114, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(115, 'DB8TO-Dbake Bldg.', 188),
(116, 'Chaitanya', 188),
(117, 'Goregaon', 188),
(118, 'Sai Sarovar', 188),
(119, 'TM10N2E - Chaitanya Goregaon', 188),
(120, 'TM10N3-26 & 13 Sai Sarovar', 188),
(121, 'Maitree Park', 188),
(122, '-0360B  - 8nos - Maitree Park', 188),
(123, '116HS-538714', 188),
(124, 'Damajibhai', 188),
(125, 'Sai Gabasti', 188),
(126, 'Vishal Diamond MIDC', 188),
(127, 'Malgudi-Turbhe', 188),
(128, 'Vishal', 188),
(129, 'New Dindoshi', 188),
(130, 'shree siddhi', 188),
(131, 'Anurag Nursing Home', 188),
(132, 'Practice Agile Solution Pvt.Ltd', 188),
(133, 'Mike Offset', 188),
(134, 'Surajmal Lallubhai', 188),
(135, 'Gokul Nagari', 188),
(136, 'Darshan Hights', 188),
(137, 'BNPL', 188),
(138, 'Office DVR', 188),
(139, 'Sanjuz Entrtentment', 188),
(140, 'A', 188),
(141, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(142, 'DB8TO-Dbake Bldg.', 188),
(143, 'Chaitanya', 188),
(144, 'Goregaon', 188),
(145, 'Sai Sarovar', 188),
(146, 'TM10N2E - Chaitanya Goregaon', 188),
(147, 'TM10N3-26 & 13 Sai Sarovar', 188),
(148, 'Maitree Park', 188),
(149, '-0360B  - 8nos - Maitree Park', 188),
(150, '116HS-538714', 188),
(151, 'Damajibhai', 188),
(152, 'Sai Gabasti', 188),
(153, 'Vishal Diamond MIDC', 188),
(154, 'Malgudi-Turbhe', 188),
(155, 'Vishal', 188),
(156, 'New Dindoshi', 188),
(157, 'shree siddhi', 188),
(158, 'Anurag Nursing Home', 188),
(159, 'Practice Agile Solution Pvt.Ltd', 188),
(160, 'Mike Offset', 188),
(161, 'Surajmal Lallubhai', 188),
(162, 'Gokul Nagari', 188),
(163, 'Darshan Hights', 188),
(164, 'BNPL', 188),
(165, 'Office DVR', 188),
(166, 'Sanjuz Entrtentment', 188),
(167, 'A', 188),
(168, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(169, 'DB8TO-Dbake Bldg.', 188),
(170, 'Chaitanya', 188),
(171, 'Goregaon', 188),
(172, 'Sai Sarovar', 188),
(173, 'TM10N2E - Chaitanya Goregaon', 188),
(174, 'TM10N3-26 & 13 Sai Sarovar', 188),
(175, 'Maitree Park', 188),
(176, '-0360B  - 8nos - Maitree Park', 188),
(177, '116HS-538714', 188),
(178, 'Damajibhai', 188),
(179, 'Sai Gabasti', 188),
(180, 'Vishal Diamond MIDC', 188),
(181, 'Malgudi-Turbhe', 188),
(182, 'Vishal', 188),
(183, 'New Dindoshi', 188),
(184, 'shree siddhi', 188),
(185, 'Anurag Nursing Home', 188),
(186, 'Practice Agile Solution Pvt.Ltd', 188),
(187, 'Mike Offset', 188),
(188, 'Surajmal Lallubhai', 188),
(189, 'Gokul Nagari', 188),
(190, 'Darshan Hights', 188),
(191, 'BNPL', 188),
(192, 'Office DVR', 188),
(193, 'Sanjuz Entrtentment', 188),
(194, 'A', 188),
(195, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(196, 'DB8TO-Dbake Bldg.', 188),
(197, 'Chaitanya', 188),
(198, 'Goregaon', 188),
(199, 'Sai Sarovar', 188),
(200, 'TM10N2E - Chaitanya Goregaon', 188),
(201, 'TM10N3-26 & 13 Sai Sarovar', 188),
(202, 'Maitree Park', 188),
(203, '-0360B  - 8nos - Maitree Park', 188),
(204, '116HS-538714', 188),
(205, 'Damajibhai', 188),
(206, 'Sai Gabasti', 188),
(207, 'Vishal Diamond MIDC', 188),
(208, 'Malgudi-Turbhe', 188),
(209, 'Vishal', 188),
(210, 'New Dindoshi', 188),
(211, 'shree siddhi', 188),
(212, 'Anurag Nursing Home', 188),
(213, 'Practice Agile Solution Pvt.Ltd', 188),
(214, 'Mike Offset', 188),
(215, 'Surajmal Lallubhai', 188),
(216, 'Gokul Nagari', 188),
(217, 'Darshan Hights', 188),
(218, 'BNPL', 188),
(219, 'Office DVR', 188),
(220, 'Sanjuz Entrtentment', 188),
(221, 'A', 188),
(222, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(223, 'DB8TO-Dbake Bldg.', 188),
(224, 'Chaitanya', 188),
(225, 'Goregaon', 188),
(226, 'Sai Sarovar', 188),
(227, 'TM10N2E - Chaitanya Goregaon', 188),
(228, 'TM10N3-26 & 13 Sai Sarovar', 188),
(229, 'Maitree Park', 188),
(230, '-0360B  - 8nos - Maitree Park', 188),
(231, '116HS-538714', 188),
(232, 'Damajibhai', 188),
(233, 'Sai Gabasti', 188),
(234, 'Vishal Diamond MIDC', 188),
(235, 'Malgudi-Turbhe', 188),
(236, 'Vishal', 188),
(237, 'New Dindoshi', 188),
(238, 'shree siddhi', 188),
(239, 'Anurag Nursing Home', 188),
(240, 'Practice Agile Solution Pvt.Ltd', 188),
(241, 'Mike Offset', 188),
(242, 'Surajmal Lallubhai', 188),
(243, 'Gokul Nagari', 188),
(244, 'Darshan Hights', 188),
(245, 'BNPL', 188),
(246, 'Office DVR', 188),
(247, 'Sanjuz Entrtentment', 188),
(248, 'A', 188),
(249, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(250, 'DB8TO-Dbake Bldg.', 188),
(251, 'Chaitanya', 188),
(252, 'Goregaon', 188),
(253, 'Sai Sarovar', 188),
(254, 'TM10N2E - Chaitanya Goregaon', 188),
(255, 'TM10N3-26 & 13 Sai Sarovar', 188),
(256, 'Maitree Park', 188),
(257, '-0360B  - 8nos - Maitree Park', 188),
(258, '116HS-538714', 188),
(259, 'Damajibhai', 188),
(260, 'Sai Gabasti', 188),
(261, 'Vishal Diamond MIDC', 188),
(262, 'Malgudi-Turbhe', 188),
(263, 'Vishal', 188),
(264, 'New Dindoshi', 188),
(265, 'shree siddhi', 188),
(266, 'Anurag Nursing Home', 188),
(267, 'Practice Agile Solution Pvt.Ltd', 188),
(268, 'Mike Offset', 188),
(269, 'Surajmal Lallubhai', 188),
(270, 'Gokul Nagari', 188),
(271, 'Darshan Hights', 188),
(272, 'BNPL', 188),
(273, 'Office DVR', 188),
(274, 'Sanjuz Entrtentment', 188),
(275, 'A', 188),
(276, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(277, 'DB8TO-Dbake Bldg.', 188),
(278, 'Chaitanya', 188),
(279, 'Goregaon', 188),
(280, 'Sai Sarovar', 188),
(281, 'TM10N2E - Chaitanya Goregaon', 188),
(282, 'TM10N3-26 & 13 Sai Sarovar', 188),
(283, 'Maitree Park', 188),
(284, '-0360B  - 8nos - Maitree Park', 188),
(285, '116HS-538714', 188),
(286, 'Damajibhai', 188),
(287, 'Sai Gabasti', 188),
(288, 'Vishal Diamond MIDC', 188),
(289, 'Malgudi-Turbhe', 188),
(290, 'Vishal', 188),
(291, 'New Dindoshi', 188),
(292, 'shree siddhi', 188),
(293, 'Anurag Nursing Home', 188),
(294, 'Practice Agile Solution Pvt.Ltd', 188),
(295, 'Mike Offset', 188),
(296, 'Surajmal Lallubhai', 188),
(297, 'Gokul Nagari', 188),
(298, 'Darshan Hights', 188),
(299, 'BNPL', 188),
(300, 'Office DVR', 188),
(301, 'Sanjuz Entrtentment', 188),
(302, 'A', 188),
(303, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(304, 'DB8TO-Dbake Bldg.', 188),
(305, 'Chaitanya', 188),
(306, 'Goregaon', 188),
(307, 'Sai Sarovar', 188),
(308, 'TM10N2E - Chaitanya Goregaon', 188),
(309, 'TM10N3-26 & 13 Sai Sarovar', 188),
(310, 'Maitree Park', 188),
(311, '-0360B  - 8nos - Maitree Park', 188),
(312, '116HS-538714', 188),
(313, 'Damajibhai', 188),
(314, 'Sai Gabasti', 188),
(315, 'Vishal Diamond MIDC', 188),
(316, 'Malgudi-Turbhe', 188),
(317, 'Vishal', 188),
(318, 'New Dindoshi', 188),
(319, 'shree siddhi', 188),
(320, 'Anurag Nursing Home', 188),
(321, 'Practice Agile Solution Pvt.Ltd', 188),
(322, 'Mike Offset', 188),
(323, 'Surajmal Lallubhai', 188),
(324, 'Gokul Nagari', 188),
(325, 'Darshan Hights', 188),
(326, 'BNPL', 188),
(327, 'Office DVR', 188),
(328, 'Sanjuz Entrtentment', 188),
(329, 'A', 188),
(330, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(331, 'DB8TO-Dbake Bldg.', 188),
(332, 'Chaitanya', 188),
(333, 'Goregaon', 188),
(334, 'Sai Sarovar', 188),
(335, 'TM10N2E - Chaitanya Goregaon', 188),
(336, 'TM10N3-26 & 13 Sai Sarovar', 188),
(337, 'Maitree Park', 188),
(338, '-0360B  - 8nos - Maitree Park', 188),
(339, '116HS-538714', 188),
(340, 'Damajibhai', 188),
(341, 'Sai Gabasti', 188),
(342, 'Vishal Diamond MIDC', 188),
(343, 'Malgudi-Turbhe', 188),
(344, 'Vishal', 188),
(345, 'New Dindoshi', 188),
(346, 'shree siddhi', 188),
(347, 'Anurag Nursing Home', 188),
(348, 'Practice Agile Solution Pvt.Ltd', 188),
(349, 'Mike Offset', 188),
(350, 'Surajmal Lallubhai', 188),
(351, 'Gokul Nagari', 188),
(352, 'Darshan Hights', 188),
(353, 'BNPL', 188),
(354, 'Office DVR', 188),
(355, 'Sanjuz Entrtentment', 188),
(356, 'A', 188),
(357, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(358, 'DB8TO-Dbake Bldg.', 188),
(359, 'Chaitanya', 188),
(360, 'Goregaon', 188),
(361, 'Sai Sarovar', 188),
(362, 'TM10N2E - Chaitanya Goregaon', 188),
(363, 'TM10N3-26 & 13 Sai Sarovar', 188),
(364, 'Maitree Park', 188),
(365, '-0360B  - 8nos - Maitree Park', 188),
(366, '116HS-538714', 188),
(367, 'Damajibhai', 188),
(368, 'Sai Gabasti', 188),
(369, 'Vishal Diamond MIDC', 188),
(370, 'Malgudi-Turbhe', 188),
(371, 'Vishal', 188),
(372, 'New Dindoshi', 188),
(373, 'shree siddhi', 188),
(374, 'Anurag Nursing Home', 188),
(375, 'Practice Agile Solution Pvt.Ltd', 188),
(376, 'Mike Offset', 188),
(377, 'Surajmal Lallubhai', 188),
(378, 'Gokul Nagari', 188),
(379, 'Darshan Hights', 188),
(380, 'BNPL', 188),
(381, 'Office DVR', 188),
(382, 'Sanjuz Entrtentment', 188),
(383, 'A', 188),
(384, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(385, 'DB8TO-Dbake Bldg.', 188),
(386, 'Chaitanya', 188),
(387, 'Goregaon', 188),
(388, 'Sai Sarovar', 188),
(389, 'TM10N2E - Chaitanya Goregaon', 188),
(390, 'TM10N3-26 & 13 Sai Sarovar', 188),
(391, 'Maitree Park', 188),
(392, '-0360B  - 8nos - Maitree Park', 188),
(393, '116HS-538714', 188),
(394, 'Damajibhai', 188),
(395, 'Sai Gabasti', 188),
(396, 'Vishal Diamond MIDC', 188),
(397, 'Malgudi-Turbhe', 188),
(398, 'Vishal', 188),
(399, 'New Dindoshi', 188),
(400, 'shree siddhi', 188),
(401, 'Anurag Nursing Home', 188),
(402, 'Practice Agile Solution Pvt.Ltd', 188),
(403, 'Mike Offset', 188),
(404, 'Surajmal Lallubhai', 188),
(405, 'Gokul Nagari', 188),
(406, 'Darshan Hights', 188),
(407, 'BNPL', 188),
(408, 'Office DVR', 188),
(409, 'Sanjuz Entrtentment', 188),
(410, 'A', 188),
(411, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(412, 'DB8TO-Dbake Bldg.', 188),
(413, 'Chaitanya', 188),
(414, 'Goregaon', 188),
(415, 'Sai Sarovar', 188),
(416, 'TM10N2E - Chaitanya Goregaon', 188),
(417, 'TM10N3-26 & 13 Sai Sarovar', 188),
(418, 'Maitree Park', 188),
(419, '-0360B  - 8nos - Maitree Park', 188),
(420, '116HS-538714', 188),
(421, 'Damajibhai', 188),
(422, 'Sai Gabasti', 188),
(423, 'Vishal Diamond MIDC', 188),
(424, 'Malgudi-Turbhe', 188),
(425, 'Vishal', 188),
(426, 'New Dindoshi', 188),
(427, 'shree siddhi', 188),
(428, 'Anurag Nursing Home', 188),
(429, 'Practice Agile Solution Pvt.Ltd', 188),
(430, 'Mike Offset', 188),
(431, 'Surajmal Lallubhai', 188),
(432, 'Gokul Nagari', 188),
(433, 'Darshan Hights', 188),
(434, 'BNPL', 188),
(435, 'Office DVR', 188),
(436, 'Sanjuz Entrtentment', 188),
(437, 'A', 188),
(438, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(439, 'DB8TO-Dbake Bldg.', 188),
(440, 'Chaitanya', 188),
(441, 'Goregaon', 188),
(442, 'Sai Sarovar', 188),
(443, 'TM10N2E - Chaitanya Goregaon', 188),
(444, 'TM10N3-26 & 13 Sai Sarovar', 188),
(445, 'Maitree Park', 188),
(446, '-0360B  - 8nos - Maitree Park', 188),
(447, '116HS-538714', 188),
(448, 'Damajibhai', 188),
(449, 'Sai Gabasti', 188),
(450, 'Vishal Diamond MIDC', 188),
(451, 'Malgudi-Turbhe', 188),
(452, 'Vishal', 188),
(453, 'New Dindoshi', 188),
(454, 'shree siddhi', 188),
(455, 'Anurag Nursing Home', 188),
(456, 'Practice Agile Solution Pvt.Ltd', 188),
(457, 'Mike Offset', 188),
(458, 'Surajmal Lallubhai', 188),
(459, 'Gokul Nagari', 188),
(460, 'Darshan Hights', 188),
(461, 'BNPL', 188),
(462, 'Office DVR', 188),
(463, 'Sanjuz Entrtentment', 188),
(464, 'A', 188),
(465, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(466, 'DB8TO-Dbake Bldg.', 188),
(467, 'Chaitanya', 188),
(468, 'Goregaon', 188),
(469, 'Sai Sarovar', 188),
(470, 'TM10N2E - Chaitanya Goregaon', 188),
(471, 'TM10N3-26 & 13 Sai Sarovar', 188),
(472, 'Maitree Park', 188),
(473, '-0360B  - 8nos - Maitree Park', 188),
(474, '116HS-538714', 188),
(475, 'Damajibhai', 188),
(476, 'Sai Gabasti', 188),
(477, 'Vishal Diamond MIDC', 188),
(478, 'Malgudi-Turbhe', 188),
(479, 'Vishal', 188),
(480, 'New Dindoshi', 188),
(481, 'shree siddhi', 188),
(482, 'Anurag Nursing Home', 188),
(483, 'Practice Agile Solution Pvt.Ltd', 188),
(484, 'Mike Offset', 188),
(485, 'Surajmal Lallubhai', 188),
(486, 'Gokul Nagari', 188),
(487, 'Darshan Hights', 188),
(488, 'BNPL', 188),
(489, 'Office DVR', 188),
(490, 'Sanjuz Entrtentment', 188),
(491, 'A', 188),
(492, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(493, 'DB8TO-Dbake Bldg.', 188),
(494, 'Chaitanya', 188),
(495, 'Goregaon', 188),
(496, 'Sai Sarovar', 188),
(497, 'TM10N2E - Chaitanya Goregaon', 188),
(498, 'TM10N3-26 & 13 Sai Sarovar', 188),
(499, 'Maitree Park', 188),
(500, '-0360B  - 8nos - Maitree Park', 188),
(501, '116HS-538714', 188),
(502, 'Damajibhai', 188),
(503, 'Sai Gabasti', 188),
(504, 'Vishal Diamond MIDC', 188),
(505, 'Malgudi-Turbhe', 188),
(506, 'Vishal', 188),
(507, 'New Dindoshi', 188),
(508, 'shree siddhi', 188),
(509, 'Anurag Nursing Home', 188),
(510, 'Practice Agile Solution Pvt.Ltd', 188),
(511, 'Mike Offset', 188),
(512, 'Surajmal Lallubhai', 188),
(513, 'Gokul Nagari', 188),
(514, 'Darshan Hights', 188),
(515, 'BNPL', 188),
(516, 'Office DVR', 188),
(517, 'Sanjuz Entrtentment', 188),
(518, 'A', 188),
(519, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(520, 'DB8TO-Dbake Bldg.', 188),
(521, 'Chaitanya', 188),
(522, 'Goregaon', 188),
(523, 'Sai Sarovar', 188),
(524, 'TM10N2E - Chaitanya Goregaon', 188),
(525, 'TM10N3-26 & 13 Sai Sarovar', 188),
(526, 'Maitree Park', 188),
(527, '-0360B  - 8nos - Maitree Park', 188),
(528, '116HS-538714', 188),
(529, 'Damajibhai', 188),
(530, 'Sai Gabasti', 188),
(531, 'Vishal Diamond MIDC', 188),
(532, 'Malgudi-Turbhe', 188),
(533, 'Vishal', 188),
(534, 'New Dindoshi', 188),
(535, 'shree siddhi', 188),
(536, 'Anurag Nursing Home', 188),
(537, 'Practice Agile Solution Pvt.Ltd', 188),
(538, 'Mike Offset', 188),
(539, 'Surajmal Lallubhai', 188),
(540, 'Gokul Nagari', 188),
(541, 'Darshan Hights', 188),
(542, 'BNPL', 188),
(543, 'Office DVR', 188),
(544, 'Sanjuz Entrtentment', 188),
(545, 'A', 188),
(546, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(547, 'DB8TO-Dbake Bldg.', 188),
(548, 'Chaitanya', 188),
(549, 'Goregaon', 188),
(550, 'Sai Sarovar', 188),
(551, 'TM10N2E - Chaitanya Goregaon', 188),
(552, 'TM10N3-26 & 13 Sai Sarovar', 188),
(553, 'Maitree Park', 188),
(554, '-0360B  - 8nos - Maitree Park', 188),
(555, '116HS-538714', 188),
(556, 'Damajibhai', 188),
(557, 'Sai Gabasti', 188),
(558, 'Vishal Diamond MIDC', 188),
(559, 'Malgudi-Turbhe', 188),
(560, 'Vishal', 188),
(561, 'New Dindoshi', 188),
(562, 'shree siddhi', 188),
(563, 'Anurag Nursing Home', 188),
(564, 'Practice Agile Solution Pvt.Ltd', 188),
(565, 'Mike Offset', 188),
(566, 'Surajmal Lallubhai', 188),
(567, 'Gokul Nagari', 188),
(568, 'Darshan Hights', 188),
(569, 'BNPL', 188),
(570, 'Office DVR', 188),
(571, 'Sanjuz Entrtentment', 188),
(572, 'A', 188),
(573, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(574, 'DB8TO-Dbake Bldg.', 188),
(575, 'Chaitanya', 188),
(576, 'Goregaon', 188),
(577, 'Sai Sarovar', 188),
(578, 'TM10N2E - Chaitanya Goregaon', 188),
(579, 'TM10N3-26 & 13 Sai Sarovar', 188),
(580, 'Maitree Park', 188),
(581, '-0360B  - 8nos - Maitree Park', 188),
(582, '116HS-538714', 188),
(583, 'Damajibhai', 188),
(584, 'Sai Gabasti', 188),
(585, 'Vishal Diamond MIDC', 188),
(586, 'Malgudi-Turbhe', 188),
(587, 'Vishal', 188),
(588, 'New Dindoshi', 188),
(589, 'shree siddhi', 188),
(590, 'Anurag Nursing Home', 188),
(591, 'Practice Agile Solution Pvt.Ltd', 188),
(592, 'Mike Offset', 188),
(593, 'Surajmal Lallubhai', 188),
(594, 'Gokul Nagari', 188),
(595, 'Darshan Hights', 188),
(596, 'BNPL', 188),
(597, 'Office DVR', 188),
(598, 'Sanjuz Entrtentment', 188),
(599, 'A', 188),
(600, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(601, 'DB8TO-Dbake Bldg.', 188),
(602, 'Chaitanya', 188),
(603, 'Goregaon', 188),
(604, 'Sai Sarovar', 188),
(605, 'TM10N2E - Chaitanya Goregaon', 188),
(606, 'TM10N3-26 & 13 Sai Sarovar', 188),
(607, 'Maitree Park', 188),
(608, '-0360B  - 8nos - Maitree Park', 188),
(609, '116HS-538714', 188),
(610, 'Damajibhai', 188),
(611, 'Sai Gabasti', 188),
(612, 'Vishal Diamond MIDC', 188),
(613, 'Malgudi-Turbhe', 188),
(614, 'Vishal', 188),
(615, 'New Dindoshi', 188),
(616, 'shree siddhi', 188),
(617, 'Anurag Nursing Home', 188),
(618, 'Practice Agile Solution Pvt.Ltd', 188),
(619, 'Mike Offset', 188),
(620, 'Surajmal Lallubhai', 188),
(621, 'Gokul Nagari', 188),
(622, 'Darshan Hights', 188),
(623, 'BNPL', 188),
(624, 'Office DVR', 188),
(625, 'Sanjuz Entrtentment', 188),
(626, 'A', 188),
(627, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(628, 'DB8TO-Dbake Bldg.', 188),
(629, 'Chaitanya', 188),
(630, 'Goregaon', 188),
(631, 'Sai Sarovar', 188),
(632, 'TM10N2E - Chaitanya Goregaon', 188),
(633, 'TM10N3-26 & 13 Sai Sarovar', 188),
(634, 'Maitree Park', 188),
(635, '-0360B  - 8nos - Maitree Park', 188),
(636, '116HS-538714', 188),
(637, 'Damajibhai', 188),
(638, 'Sai Gabasti', 188),
(639, 'Vishal Diamond MIDC', 188),
(640, 'Malgudi-Turbhe', 188),
(641, 'Vishal', 188),
(642, 'New Dindoshi', 188),
(643, 'shree siddhi', 188),
(644, 'Anurag Nursing Home', 188),
(645, 'Practice Agile Solution Pvt.Ltd', 188),
(646, 'Mike Offset', 188),
(647, 'Surajmal Lallubhai', 188),
(648, 'Gokul Nagari', 188),
(649, 'Darshan Hights', 188),
(650, 'BNPL', 188),
(651, 'Office DVR', 188),
(652, 'Sanjuz Entrtentment', 188),
(653, 'A', 188),
(654, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(655, 'DB8TO-Dbake Bldg.', 188),
(656, 'Chaitanya', 188),
(657, 'Goregaon', 188),
(658, 'Sai Sarovar', 188),
(659, 'TM10N2E - Chaitanya Goregaon', 188),
(660, 'TM10N3-26 & 13 Sai Sarovar', 188),
(661, 'Maitree Park', 188),
(662, '-0360B  - 8nos - Maitree Park', 188),
(663, '116HS-538714', 188),
(664, 'Damajibhai', 188),
(665, 'Sai Gabasti', 188),
(666, 'Vishal Diamond MIDC', 188),
(667, 'Malgudi-Turbhe', 188),
(668, 'Vishal', 188),
(669, 'New Dindoshi', 188),
(670, 'shree siddhi', 188),
(671, 'Anurag Nursing Home', 188),
(672, 'Practice Agile Solution Pvt.Ltd', 188),
(673, 'Mike Offset', 188),
(674, 'Surajmal Lallubhai', 188),
(675, 'Gokul Nagari', 188),
(676, 'Darshan Hights', 188),
(677, 'BNPL', 188),
(678, 'Office DVR', 188),
(679, 'Sanjuz Entrtentment', 188),
(680, 'A', 188),
(681, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(682, 'DB8TO-Dbake Bldg.', 188),
(683, 'Chaitanya', 188),
(684, 'Goregaon', 188),
(685, 'Sai Sarovar', 188),
(686, 'TM10N2E - Chaitanya Goregaon', 188),
(687, 'TM10N3-26 & 13 Sai Sarovar', 188),
(688, 'Maitree Park', 188),
(689, '-0360B  - 8nos - Maitree Park', 188),
(690, '116HS-538714', 188),
(691, 'Damajibhai', 188),
(692, 'Sai Gabasti', 188),
(693, 'Vishal Diamond MIDC', 188),
(694, 'Malgudi-Turbhe', 188),
(695, 'Vishal', 188),
(696, 'New Dindoshi', 188),
(697, 'shree siddhi', 188),
(698, 'Anurag Nursing Home', 188),
(699, 'Practice Agile Solution Pvt.Ltd', 188),
(700, 'Mike Offset', 188),
(701, 'Surajmal Lallubhai', 188),
(702, 'Gokul Nagari', 188),
(703, 'Darshan Hights', 188),
(704, 'BNPL', 188),
(705, 'Office DVR', 188),
(706, 'Sanjuz Entrtentment', 188),
(707, 'A', 188),
(708, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(709, 'DB8TO-Dbake Bldg.', 188),
(710, 'Chaitanya', 188),
(711, 'Goregaon', 188),
(712, 'Sai Sarovar', 188),
(713, 'TM10N2E - Chaitanya Goregaon', 188),
(714, 'TM10N3-26 & 13 Sai Sarovar', 188),
(715, 'Maitree Park', 188),
(716, '-0360B  - 8nos - Maitree Park', 188),
(717, '116HS-538714', 188),
(718, 'Damajibhai', 188),
(719, 'Sai Gabasti', 188),
(720, 'Vishal Diamond MIDC', 188),
(721, 'Malgudi-Turbhe', 188),
(722, 'Vishal', 188),
(723, 'New Dindoshi', 188),
(724, 'shree siddhi', 188),
(725, 'Anurag Nursing Home', 188),
(726, 'Practice Agile Solution Pvt.Ltd', 188),
(727, 'Mike Offset', 188),
(728, 'Surajmal Lallubhai', 188),
(729, 'Gokul Nagari', 188),
(730, 'Darshan Hights', 188),
(731, 'BNPL', 188),
(732, 'Office DVR', 188),
(733, 'Sanjuz Entrtentment', 188),
(734, 'A', 188),
(735, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(736, 'DB8TO-Dbake Bldg.', 188),
(737, 'Chaitanya', 188),
(738, 'Goregaon', 188),
(739, 'Sai Sarovar', 188),
(740, 'TM10N2E - Chaitanya Goregaon', 188),
(741, 'TM10N3-26 & 13 Sai Sarovar', 188),
(742, 'Maitree Park', 188),
(743, '-0360B  - 8nos - Maitree Park', 188),
(744, '116HS-538714', 188),
(745, 'Damajibhai', 188),
(746, 'Sai Gabasti', 188),
(747, 'Vishal Diamond MIDC', 188),
(748, 'Malgudi-Turbhe', 188),
(749, 'Vishal', 188),
(750, 'New Dindoshi', 188),
(751, 'shree siddhi', 188),
(752, 'Anurag Nursing Home', 188),
(753, 'Practice Agile Solution Pvt.Ltd', 188),
(754, 'Mike Offset', 188),
(755, 'Surajmal Lallubhai', 188),
(756, 'Gokul Nagari', 188),
(757, 'Darshan Hights', 188),
(758, 'BNPL', 188),
(759, 'Office DVR', 188),
(760, 'Sanjuz Entrtentment', 188),
(761, 'A', 188),
(762, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(763, 'DB8TO-Dbake Bldg.', 188),
(764, 'Chaitanya', 188),
(765, 'Goregaon', 188),
(766, 'Sai Sarovar', 188),
(767, 'TM10N2E - Chaitanya Goregaon', 188),
(768, 'TM10N3-26 & 13 Sai Sarovar', 188),
(769, 'Maitree Park', 188),
(770, '-0360B  - 8nos - Maitree Park', 188),
(771, '116HS-538714', 188),
(772, 'Damajibhai', 188),
(773, 'Sai Gabasti', 188),
(774, 'Vishal Diamond MIDC', 188),
(775, 'Malgudi-Turbhe', 188),
(776, 'Vishal', 188),
(777, 'New Dindoshi', 188),
(778, 'shree siddhi', 188),
(779, 'Anurag Nursing Home', 188),
(780, 'Practice Agile Solution Pvt.Ltd', 188),
(781, 'Mike Offset', 188),
(782, 'Surajmal Lallubhai', 188),
(783, 'Gokul Nagari', 188),
(784, 'Darshan Hights', 188),
(785, 'BNPL', 188),
(786, 'Office DVR', 188),
(787, 'Sanjuz Entrtentment', 188),
(788, 'A', 188),
(789, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(790, 'DB8TO-Dbake Bldg.', 188),
(791, 'Chaitanya', 188),
(792, 'Goregaon', 188),
(793, 'Sai Sarovar', 188),
(794, 'TM10N2E - Chaitanya Goregaon', 188),
(795, 'TM10N3-26 & 13 Sai Sarovar', 188),
(796, 'Maitree Park', 188),
(797, '-0360B  - 8nos - Maitree Park', 188),
(798, '116HS-538714', 188),
(799, 'Damajibhai', 188),
(800, 'Sai Gabasti', 188),
(801, 'Vishal Diamond MIDC', 188),
(802, 'Malgudi-Turbhe', 188),
(803, 'Vishal', 188),
(804, 'New Dindoshi', 188),
(805, 'shree siddhi', 188),
(806, 'Anurag Nursing Home', 188),
(807, 'Practice Agile Solution Pvt.Ltd', 188),
(808, 'Mike Offset', 188),
(809, 'Surajmal Lallubhai', 188),
(810, 'Gokul Nagari', 188),
(811, 'Darshan Hights', 188),
(812, 'BNPL', 188),
(813, 'Office DVR', 188),
(814, 'Sanjuz Entrtentment', 188),
(815, 'A', 188),
(816, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(817, 'DB8TO-Dbake Bldg.', 188),
(818, 'Chaitanya', 188),
(819, 'Goregaon', 188),
(820, 'Sai Sarovar', 188),
(821, 'TM10N2E - Chaitanya Goregaon', 188),
(822, 'TM10N3-26 & 13 Sai Sarovar', 188),
(823, 'Maitree Park', 188),
(824, '-0360B  - 8nos - Maitree Park', 188),
(825, '116HS-538714', 188),
(826, 'Damajibhai', 188),
(827, 'Sai Gabasti', 188),
(828, 'Vishal Diamond MIDC', 188),
(829, 'Malgudi-Turbhe', 188),
(830, 'Vishal', 188),
(831, 'New Dindoshi', 188),
(832, 'shree siddhi', 188),
(833, 'Anurag Nursing Home', 188),
(834, 'Practice Agile Solution Pvt.Ltd', 188),
(835, 'Mike Offset', 188),
(836, 'Surajmal Lallubhai', 188),
(837, 'Gokul Nagari', 188),
(838, 'Darshan Hights', 188),
(839, 'BNPL', 188),
(840, 'Office DVR', 188),
(841, 'Sanjuz Entrtentment', 188),
(842, 'A', 188),
(843, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(844, 'DB8TO-Dbake Bldg.', 188),
(845, 'Chaitanya', 188),
(846, 'Goregaon', 188),
(847, 'Sai Sarovar', 188),
(848, 'TM10N2E - Chaitanya Goregaon', 188),
(849, 'TM10N3-26 & 13 Sai Sarovar', 188),
(850, 'Maitree Park', 188),
(851, '-0360B  - 8nos - Maitree Park', 188),
(852, '116HS-538714', 188),
(853, 'Damajibhai', 188),
(854, 'Sai Gabasti', 188),
(855, 'Vishal Diamond MIDC', 188),
(856, 'Malgudi-Turbhe', 188),
(857, 'Vishal', 188),
(858, 'New Dindoshi', 188),
(859, 'shree siddhi', 188),
(860, 'Anurag Nursing Home', 188),
(861, 'Practice Agile Solution Pvt.Ltd', 188),
(862, 'Mike Offset', 188),
(863, 'Surajmal Lallubhai', 188),
(864, 'Gokul Nagari', 188),
(865, 'Darshan Hights', 188),
(866, 'BNPL', 188),
(867, 'Office DVR', 188),
(868, 'Sanjuz Entrtentment', 188),
(869, 'A', 188),
(870, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(871, 'DB8TO-Dbake Bldg.', 188),
(872, 'Chaitanya', 188),
(873, 'Goregaon', 188),
(874, 'Sai Sarovar', 188),
(875, 'TM10N2E - Chaitanya Goregaon', 188),
(876, 'TM10N3-26 & 13 Sai Sarovar', 188),
(877, 'Maitree Park', 188),
(878, '-0360B  - 8nos - Maitree Park', 188),
(879, '116HS-538714', 188),
(880, 'Damajibhai', 188),
(881, 'Sai Gabasti', 188),
(882, 'Vishal Diamond MIDC', 188),
(883, 'Malgudi-Turbhe', 188),
(884, 'Vishal', 188),
(885, 'New Dindoshi', 188),
(886, 'shree siddhi', 188),
(887, 'Anurag Nursing Home', 188),
(888, 'Practice Agile Solution Pvt.Ltd', 188),
(889, 'Mike Offset', 188),
(890, 'Surajmal Lallubhai', 188),
(891, 'Gokul Nagari', 188),
(892, 'Darshan Hights', 188),
(893, 'BNPL', 188),
(894, 'Office DVR', 188),
(895, 'Sanjuz Entrtentment', 188),
(896, 'A', 188),
(897, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(898, 'DB8TO-Dbake Bldg.', 188),
(899, 'Chaitanya', 188),
(900, 'Goregaon', 188),
(901, 'Sai Sarovar', 188),
(902, 'TM10N2E - Chaitanya Goregaon', 188),
(903, 'TM10N3-26 & 13 Sai Sarovar', 188),
(904, 'Maitree Park', 188),
(905, '-0360B  - 8nos - Maitree Park', 188),
(906, '116HS-538714', 188),
(907, 'Damajibhai', 188),
(908, 'Sai Gabasti', 188),
(909, 'Vishal Diamond MIDC', 188),
(910, 'Malgudi-Turbhe', 188),
(911, 'Vishal', 188),
(912, 'New Dindoshi', 188),
(913, 'shree siddhi', 188),
(914, 'Anurag Nursing Home', 188),
(915, 'Practice Agile Solution Pvt.Ltd', 188),
(916, 'Mike Offset', 188),
(917, 'Surajmal Lallubhai', 188),
(918, 'Gokul Nagari', 188),
(919, 'Darshan Hights', 188),
(920, 'BNPL', 188),
(921, 'Office DVR', 188),
(922, 'Sanjuz Entrtentment', 188),
(923, 'A', 188),
(924, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(925, 'DB8TO-Dbake Bldg.', 188),
(926, 'Chaitanya', 188),
(927, 'Goregaon', 188),
(928, 'Sai Sarovar', 188),
(929, 'TM10N2E - Chaitanya Goregaon', 188),
(930, 'TM10N3-26 & 13 Sai Sarovar', 188),
(931, 'Maitree Park', 188),
(932, '-0360B  - 8nos - Maitree Park', 188),
(933, '116HS-538714', 188),
(934, 'Damajibhai', 188),
(935, 'Sai Gabasti', 188),
(936, 'Vishal Diamond MIDC', 188),
(937, 'Malgudi-Turbhe', 188),
(938, 'Vishal', 188),
(939, 'New Dindoshi', 188),
(940, 'shree siddhi', 188),
(941, 'Anurag Nursing Home', 188),
(942, 'Practice Agile Solution Pvt.Ltd', 188),
(943, 'Mike Offset', 188),
(944, 'Surajmal Lallubhai', 188),
(945, 'Gokul Nagari', 188),
(946, 'Darshan Hights', 188),
(947, 'BNPL', 188),
(948, 'Office DVR', 188),
(949, 'Sanjuz Entrtentment', 188),
(950, 'A', 188),
(951, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(952, 'DB8TO-Dbake Bldg.', 188),
(953, 'Chaitanya', 188),
(954, 'Goregaon', 188),
(955, 'Sai Sarovar', 188),
(956, 'TM10N2E - Chaitanya Goregaon', 188),
(957, 'TM10N3-26 & 13 Sai Sarovar', 188),
(958, 'Maitree Park', 188),
(959, '-0360B  - 8nos - Maitree Park', 188),
(960, '116HS-538714', 188),
(961, 'Damajibhai', 188),
(962, 'Sai Gabasti', 188),
(963, 'Vishal Diamond MIDC', 188),
(964, 'Malgudi-Turbhe', 188),
(965, 'Vishal', 188),
(966, 'New Dindoshi', 188),
(967, 'shree siddhi', 188),
(968, 'Anurag Nursing Home', 188),
(969, 'Practice Agile Solution Pvt.Ltd', 188),
(970, 'Mike Offset', 188),
(971, 'Surajmal Lallubhai', 188),
(972, 'Gokul Nagari', 188),
(973, 'Darshan Hights', 188),
(974, 'BNPL', 188),
(975, 'Office DVR', 188),
(976, 'Sanjuz Entrtentment', 188),
(977, 'A', 188),
(978, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(979, 'DB8TO-Dbake Bldg.', 188),
(980, 'Chaitanya', 188),
(981, 'Goregaon', 188),
(982, 'Sai Sarovar', 188),
(983, 'TM10N2E - Chaitanya Goregaon', 188),
(984, 'TM10N3-26 & 13 Sai Sarovar', 188),
(985, 'Maitree Park', 188),
(986, '-0360B  - 8nos - Maitree Park', 188),
(987, '116HS-538714', 188),
(988, 'Damajibhai', 188),
(989, 'Sai Gabasti', 188),
(990, 'Vishal Diamond MIDC', 188),
(991, 'Malgudi-Turbhe', 188),
(992, 'Vishal', 188),
(993, 'New Dindoshi', 188),
(994, 'shree siddhi', 188),
(995, 'Anurag Nursing Home', 188),
(996, 'Practice Agile Solution Pvt.Ltd', 188),
(997, 'Mike Offset', 188),
(998, 'Surajmal Lallubhai', 188),
(999, 'Gokul Nagari', 188),
(1000, 'Darshan Hights', 188),
(1001, 'BNPL', 188),
(1002, 'Office DVR', 188),
(1003, 'Sanjuz Entrtentment', 188),
(1004, 'A', 188),
(1005, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1006, 'DB8TO-Dbake Bldg.', 188),
(1007, 'Chaitanya', 188),
(1008, 'Goregaon', 188),
(1009, 'Sai Sarovar', 188),
(1010, 'TM10N2E - Chaitanya Goregaon', 188),
(1011, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1012, 'Maitree Park', 188),
(1013, '-0360B  - 8nos - Maitree Park', 188),
(1014, '116HS-538714', 188),
(1015, 'Damajibhai', 188),
(1016, 'Sai Gabasti', 188),
(1017, 'Vishal Diamond MIDC', 188),
(1018, 'Malgudi-Turbhe', 188),
(1019, 'Vishal', 188),
(1020, 'New Dindoshi', 188),
(1021, 'shree siddhi', 188),
(1022, 'Anurag Nursing Home', 188),
(1023, 'Practice Agile Solution Pvt.Ltd', 188),
(1024, 'Mike Offset', 188),
(1025, 'Surajmal Lallubhai', 188),
(1026, 'Gokul Nagari', 188),
(1027, 'Darshan Hights', 188),
(1028, 'BNPL', 188),
(1029, 'Office DVR', 188),
(1030, 'Sanjuz Entrtentment', 188),
(1031, 'A', 188),
(1032, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1033, 'DB8TO-Dbake Bldg.', 188),
(1034, 'Chaitanya', 188),
(1035, 'Goregaon', 188),
(1036, 'Sai Sarovar', 188),
(1037, 'TM10N2E - Chaitanya Goregaon', 188),
(1038, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1039, 'Maitree Park', 188),
(1040, '-0360B  - 8nos - Maitree Park', 188),
(1041, '116HS-538714', 188),
(1042, 'Damajibhai', 188),
(1043, 'Sai Gabasti', 188),
(1044, 'Vishal Diamond MIDC', 188),
(1045, 'Malgudi-Turbhe', 188),
(1046, 'Vishal', 188),
(1047, 'New Dindoshi', 188),
(1048, 'shree siddhi', 188),
(1049, 'Anurag Nursing Home', 188),
(1050, 'Practice Agile Solution Pvt.Ltd', 188),
(1051, 'Mike Offset', 188),
(1052, 'Surajmal Lallubhai', 188),
(1053, 'Gokul Nagari', 188),
(1054, 'Darshan Hights', 188),
(1055, 'BNPL', 188),
(1056, 'Office DVR', 188),
(1057, 'Sanjuz Entrtentment', 188),
(1058, 'A', 188),
(1059, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1060, 'DB8TO-Dbake Bldg.', 188),
(1061, 'Chaitanya', 188),
(1062, 'Goregaon', 188),
(1063, 'Sai Sarovar', 188),
(1064, 'TM10N2E - Chaitanya Goregaon', 188),
(1065, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1066, 'Maitree Park', 188),
(1067, '-0360B  - 8nos - Maitree Park', 188),
(1068, '116HS-538714', 188),
(1069, 'Damajibhai', 188),
(1070, 'Sai Gabasti', 188),
(1071, 'Vishal Diamond MIDC', 188),
(1072, 'Malgudi-Turbhe', 188),
(1073, 'Vishal', 188),
(1074, 'New Dindoshi', 188),
(1075, 'shree siddhi', 188),
(1076, 'Anurag Nursing Home', 188),
(1077, 'Practice Agile Solution Pvt.Ltd', 188),
(1078, 'Mike Offset', 188),
(1079, 'Surajmal Lallubhai', 188),
(1080, 'Gokul Nagari', 188),
(1081, 'Darshan Hights', 188),
(1082, 'BNPL', 188),
(1083, 'Office DVR', 188),
(1084, 'Sanjuz Entrtentment', 188),
(1085, 'A', 188),
(1086, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1087, 'DB8TO-Dbake Bldg.', 188),
(1088, 'Chaitanya', 188),
(1089, 'Goregaon', 188),
(1090, 'Sai Sarovar', 188),
(1091, 'TM10N2E - Chaitanya Goregaon', 188),
(1092, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1093, 'Maitree Park', 188),
(1094, '-0360B  - 8nos - Maitree Park', 188),
(1095, '116HS-538714', 188),
(1096, 'Damajibhai', 188),
(1097, 'Sai Gabasti', 188),
(1098, 'Vishal Diamond MIDC', 188),
(1099, 'Malgudi-Turbhe', 188),
(1100, 'Vishal', 188),
(1101, 'New Dindoshi', 188),
(1102, 'shree siddhi', 188),
(1103, 'Anurag Nursing Home', 188),
(1104, 'Practice Agile Solution Pvt.Ltd', 188),
(1105, 'Mike Offset', 188),
(1106, 'Surajmal Lallubhai', 188),
(1107, 'Gokul Nagari', 188),
(1108, 'Darshan Hights', 188),
(1109, 'BNPL', 188),
(1110, 'Office DVR', 188),
(1111, 'Sanjuz Entrtentment', 188),
(1112, 'A', 188),
(1113, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1114, 'DB8TO-Dbake Bldg.', 188),
(1115, 'Chaitanya', 188),
(1116, 'Goregaon', 188),
(1117, 'Sai Sarovar', 188),
(1118, 'TM10N2E - Chaitanya Goregaon', 188),
(1119, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1120, 'Maitree Park', 188),
(1121, '-0360B  - 8nos - Maitree Park', 188),
(1122, '116HS-538714', 188),
(1123, 'Damajibhai', 188),
(1124, 'Sai Gabasti', 188),
(1125, 'Vishal Diamond MIDC', 188),
(1126, 'Malgudi-Turbhe', 188),
(1127, 'Vishal', 188),
(1128, 'New Dindoshi', 188),
(1129, 'shree siddhi', 188),
(1130, 'Anurag Nursing Home', 188),
(1131, 'Practice Agile Solution Pvt.Ltd', 188),
(1132, 'Mike Offset', 188),
(1133, 'Surajmal Lallubhai', 188),
(1134, 'Gokul Nagari', 188),
(1135, 'Darshan Hights', 188),
(1136, 'BNPL', 188),
(1137, 'Office DVR', 188),
(1138, 'Sanjuz Entrtentment', 188),
(1139, 'A', 188),
(1140, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1141, 'DB8TO-Dbake Bldg.', 188),
(1142, 'Chaitanya', 188),
(1143, 'Goregaon', 188),
(1144, 'Sai Sarovar', 188),
(1145, 'TM10N2E - Chaitanya Goregaon', 188),
(1146, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1147, 'Maitree Park', 188),
(1148, '-0360B  - 8nos - Maitree Park', 188),
(1149, '116HS-538714', 188),
(1150, 'Damajibhai', 188),
(1151, 'Sai Gabasti', 188),
(1152, 'Vishal Diamond MIDC', 188),
(1153, 'Malgudi-Turbhe', 188),
(1154, 'Vishal', 188),
(1155, 'New Dindoshi', 188),
(1156, 'shree siddhi', 188),
(1157, 'Anurag Nursing Home', 188),
(1158, 'Practice Agile Solution Pvt.Ltd', 188),
(1159, 'Mike Offset', 188),
(1160, 'Surajmal Lallubhai', 188),
(1161, 'Gokul Nagari', 188),
(1162, 'Darshan Hights', 188),
(1163, 'BNPL', 188),
(1164, 'Office DVR', 188),
(1165, 'Sanjuz Entrtentment', 188),
(1166, 'A', 188),
(1167, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1168, 'DB8TO-Dbake Bldg.', 188),
(1169, 'Chaitanya', 188),
(1170, 'Goregaon', 188),
(1171, 'Sai Sarovar', 188),
(1172, 'TM10N2E - Chaitanya Goregaon', 188),
(1173, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1174, 'Maitree Park', 188),
(1175, '-0360B  - 8nos - Maitree Park', 188),
(1176, '116HS-538714', 188),
(1177, 'Damajibhai', 188),
(1178, 'Sai Gabasti', 188),
(1179, 'Vishal Diamond MIDC', 188),
(1180, 'Malgudi-Turbhe', 188),
(1181, 'Vishal', 188),
(1182, 'New Dindoshi', 188),
(1183, 'shree siddhi', 188),
(1184, 'Anurag Nursing Home', 188),
(1185, 'Practice Agile Solution Pvt.Ltd', 188),
(1186, 'Mike Offset', 188),
(1187, 'Surajmal Lallubhai', 188),
(1188, 'Gokul Nagari', 188),
(1189, 'Darshan Hights', 188),
(1190, 'BNPL', 188),
(1191, 'Office DVR', 188),
(1192, 'Sanjuz Entrtentment', 188),
(1193, 'A', 188),
(1194, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1195, 'DB8TO-Dbake Bldg.', 188),
(1196, 'Chaitanya', 188),
(1197, 'Goregaon', 188),
(1198, 'Sai Sarovar', 188),
(1199, 'TM10N2E - Chaitanya Goregaon', 188),
(1200, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1201, 'Maitree Park', 188),
(1202, '-0360B  - 8nos - Maitree Park', 188),
(1203, '116HS-538714', 188),
(1204, 'Damajibhai', 188),
(1205, 'Sai Gabasti', 188),
(1206, 'Vishal Diamond MIDC', 188),
(1207, 'Malgudi-Turbhe', 188),
(1208, 'Vishal', 188),
(1209, 'New Dindoshi', 188),
(1210, 'shree siddhi', 188),
(1211, 'Anurag Nursing Home', 188),
(1212, 'Practice Agile Solution Pvt.Ltd', 188),
(1213, 'Mike Offset', 188),
(1214, 'Surajmal Lallubhai', 188),
(1215, 'Gokul Nagari', 188),
(1216, 'Darshan Hights', 188),
(1217, 'BNPL', 188),
(1218, 'Office DVR', 188),
(1219, 'Sanjuz Entrtentment', 188),
(1220, 'A', 188),
(1221, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1222, 'DB8TO-Dbake Bldg.', 188),
(1223, 'Chaitanya', 188),
(1224, 'Goregaon', 188),
(1225, 'Sai Sarovar', 188),
(1226, 'TM10N2E - Chaitanya Goregaon', 188),
(1227, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1228, 'Maitree Park', 188),
(1229, '-0360B  - 8nos - Maitree Park', 188),
(1230, '116HS-538714', 188),
(1231, 'Damajibhai', 188),
(1232, 'Sai Gabasti', 188),
(1233, 'Vishal Diamond MIDC', 188),
(1234, 'Malgudi-Turbhe', 188),
(1235, 'Vishal', 188),
(1236, 'New Dindoshi', 188),
(1237, 'shree siddhi', 188),
(1238, 'Anurag Nursing Home', 188),
(1239, 'Practice Agile Solution Pvt.Ltd', 188),
(1240, 'Mike Offset', 188),
(1241, 'Surajmal Lallubhai', 188),
(1242, 'Gokul Nagari', 188),
(1243, 'Darshan Hights', 188),
(1244, 'BNPL', 188),
(1245, 'Office DVR', 188),
(1246, 'Sanjuz Entrtentment', 188),
(1247, 'A', 188),
(1248, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1249, 'DB8TO-Dbake Bldg.', 188),
(1250, 'Chaitanya', 188),
(1251, 'Goregaon', 188),
(1252, 'Sai Sarovar', 188),
(1253, 'TM10N2E - Chaitanya Goregaon', 188),
(1254, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1255, 'Maitree Park', 188),
(1256, '-0360B  - 8nos - Maitree Park', 188),
(1257, '116HS-538714', 188),
(1258, 'Damajibhai', 188),
(1259, 'Sai Gabasti', 188),
(1260, 'Vishal Diamond MIDC', 188),
(1261, 'Malgudi-Turbhe', 188),
(1262, 'Vishal', 188),
(1263, 'New Dindoshi', 188),
(1264, 'shree siddhi', 188),
(1265, 'Anurag Nursing Home', 188),
(1266, 'Practice Agile Solution Pvt.Ltd', 188),
(1267, 'Mike Offset', 188),
(1268, 'Surajmal Lallubhai', 188),
(1269, 'Gokul Nagari', 188),
(1270, 'Darshan Hights', 188),
(1271, 'BNPL', 188),
(1272, 'Office DVR', 188),
(1273, 'Sanjuz Entrtentment', 188),
(1274, 'A', 188),
(1275, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1276, 'DB8TO-Dbake Bldg.', 188),
(1277, 'Chaitanya', 188),
(1278, 'Goregaon', 188),
(1279, 'Sai Sarovar', 188),
(1280, 'TM10N2E - Chaitanya Goregaon', 188),
(1281, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1282, 'Maitree Park', 188),
(1283, '-0360B  - 8nos - Maitree Park', 188),
(1284, '116HS-538714', 188),
(1285, 'Damajibhai', 188),
(1286, 'Sai Gabasti', 188),
(1287, 'Vishal Diamond MIDC', 188),
(1288, 'Malgudi-Turbhe', 188),
(1289, 'Vishal', 188),
(1290, 'New Dindoshi', 188),
(1291, 'shree siddhi', 188),
(1292, 'Anurag Nursing Home', 188),
(1293, 'Practice Agile Solution Pvt.Ltd', 188),
(1294, 'Mike Offset', 188),
(1295, 'Surajmal Lallubhai', 188),
(1296, 'Gokul Nagari', 188),
(1297, 'Darshan Hights', 188),
(1298, 'BNPL', 188),
(1299, 'Office DVR', 188),
(1300, 'Sanjuz Entrtentment', 188),
(1301, 'A', 188),
(1302, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1303, 'DB8TO-Dbake Bldg.', 188),
(1304, 'Chaitanya', 188),
(1305, 'Goregaon', 188),
(1306, 'Sai Sarovar', 188),
(1307, 'TM10N2E - Chaitanya Goregaon', 188),
(1308, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1309, 'Maitree Park', 188),
(1310, '-0360B  - 8nos - Maitree Park', 188),
(1311, '116HS-538714', 188),
(1312, 'Damajibhai', 188),
(1313, 'Sai Gabasti', 188),
(1314, 'Vishal Diamond MIDC', 188),
(1315, 'Malgudi-Turbhe', 188),
(1316, 'Vishal', 188),
(1317, 'New Dindoshi', 188),
(1318, 'shree siddhi', 188),
(1319, 'Anurag Nursing Home', 188),
(1320, 'Practice Agile Solution Pvt.Ltd', 188),
(1321, 'Mike Offset', 188),
(1322, 'Surajmal Lallubhai', 188),
(1323, 'Gokul Nagari', 188),
(1324, 'Darshan Hights', 188),
(1325, 'BNPL', 188),
(1326, 'Office DVR', 188),
(1327, 'Sanjuz Entrtentment', 188),
(1328, 'A', 188),
(1329, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1330, 'DB8TO-Dbake Bldg.', 188),
(1331, 'Chaitanya', 188),
(1332, 'Goregaon', 188),
(1333, 'Sai Sarovar', 188),
(1334, 'TM10N2E - Chaitanya Goregaon', 188),
(1335, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1336, 'Maitree Park', 188),
(1337, '-0360B  - 8nos - Maitree Park', 188),
(1338, '116HS-538714', 188),
(1339, 'Damajibhai', 188),
(1340, 'Sai Gabasti', 188),
(1341, 'Vishal Diamond MIDC', 188),
(1342, 'Malgudi-Turbhe', 188),
(1343, 'Vishal', 188),
(1344, 'New Dindoshi', 188),
(1345, 'shree siddhi', 188),
(1346, 'Anurag Nursing Home', 188),
(1347, 'Practice Agile Solution Pvt.Ltd', 188),
(1348, 'Mike Offset', 188),
(1349, 'Surajmal Lallubhai', 188),
(1350, 'Gokul Nagari', 188),
(1351, 'Darshan Hights', 188),
(1352, 'BNPL', 188),
(1353, 'Office DVR', 188),
(1354, 'Sanjuz Entrtentment', 188),
(1355, 'A', 188),
(1356, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1357, 'DB8TO-Dbake Bldg.', 188),
(1358, 'Chaitanya', 188),
(1359, 'Goregaon', 188),
(1360, 'Sai Sarovar', 188),
(1361, 'TM10N2E - Chaitanya Goregaon', 188),
(1362, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1363, 'Maitree Park', 188),
(1364, '-0360B  - 8nos - Maitree Park', 188),
(1365, '116HS-538714', 188),
(1366, 'Damajibhai', 188),
(1367, 'Sai Gabasti', 188),
(1368, 'Vishal Diamond MIDC', 188),
(1369, 'Malgudi-Turbhe', 188),
(1370, 'Vishal', 188),
(1371, 'New Dindoshi', 188),
(1372, 'shree siddhi', 188),
(1373, 'Anurag Nursing Home', 188),
(1374, 'Practice Agile Solution Pvt.Ltd', 188),
(1375, 'Mike Offset', 188),
(1376, 'Surajmal Lallubhai', 188),
(1377, 'Gokul Nagari', 188),
(1378, 'Darshan Hights', 188),
(1379, 'BNPL', 188),
(1380, 'Office DVR', 188),
(1381, 'Sanjuz Entrtentment', 188),
(1382, 'A', 188),
(1383, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1384, 'DB8TO-Dbake Bldg.', 188),
(1385, 'Chaitanya', 188),
(1386, 'Goregaon', 188),
(1387, 'Sai Sarovar', 188),
(1388, 'TM10N2E - Chaitanya Goregaon', 188),
(1389, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1390, 'Maitree Park', 188),
(1391, '-0360B  - 8nos - Maitree Park', 188),
(1392, '116HS-538714', 188),
(1393, 'Damajibhai', 188),
(1394, 'Sai Gabasti', 188),
(1395, 'Vishal Diamond MIDC', 188),
(1396, 'Malgudi-Turbhe', 188),
(1397, 'Vishal', 188),
(1398, 'New Dindoshi', 188),
(1399, 'shree siddhi', 188),
(1400, 'Anurag Nursing Home', 188),
(1401, 'Practice Agile Solution Pvt.Ltd', 188),
(1402, 'Mike Offset', 188),
(1403, 'Surajmal Lallubhai', 188),
(1404, 'Gokul Nagari', 188),
(1405, 'Darshan Hights', 188),
(1406, 'BNPL', 188),
(1407, 'Office DVR', 188),
(1408, 'Sanjuz Entrtentment', 188),
(1409, 'A', 188),
(1410, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1411, 'DB8TO-Dbake Bldg.', 188),
(1412, 'Chaitanya', 188),
(1413, 'Goregaon', 188),
(1414, 'Sai Sarovar', 188),
(1415, 'TM10N2E - Chaitanya Goregaon', 188),
(1416, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1417, 'Maitree Park', 188),
(1418, '-0360B  - 8nos - Maitree Park', 188),
(1419, '116HS-538714', 188),
(1420, 'Damajibhai', 188),
(1421, 'Sai Gabasti', 188),
(1422, 'Vishal Diamond MIDC', 188),
(1423, 'Malgudi-Turbhe', 188),
(1424, 'Vishal', 188),
(1425, 'New Dindoshi', 188),
(1426, 'shree siddhi', 188),
(1427, 'Anurag Nursing Home', 188),
(1428, 'Practice Agile Solution Pvt.Ltd', 188),
(1429, 'Mike Offset', 188),
(1430, 'Surajmal Lallubhai', 188),
(1431, 'Gokul Nagari', 188),
(1432, 'Darshan Hights', 188),
(1433, 'BNPL', 188),
(1434, 'Office DVR', 188),
(1435, 'Sanjuz Entrtentment', 188),
(1436, 'A', 188),
(1437, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1438, 'DB8TO-Dbake Bldg.', 188),
(1439, 'Chaitanya', 188),
(1440, 'Goregaon', 188),
(1441, 'Sai Sarovar', 188),
(1442, 'TM10N2E - Chaitanya Goregaon', 188),
(1443, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1444, 'Maitree Park', 188),
(1445, '-0360B  - 8nos - Maitree Park', 188),
(1446, '116HS-538714', 188),
(1447, 'Damajibhai', 188),
(1448, 'Sai Gabasti', 188),
(1449, 'Vishal Diamond MIDC', 188),
(1450, 'Malgudi-Turbhe', 188),
(1451, 'Vishal', 188),
(1452, 'New Dindoshi', 188),
(1453, 'shree siddhi', 188),
(1454, 'Anurag Nursing Home', 188),
(1455, 'Practice Agile Solution Pvt.Ltd', 188),
(1456, 'Mike Offset', 188),
(1457, 'Surajmal Lallubhai', 188),
(1458, 'Gokul Nagari', 188),
(1459, 'Darshan Hights', 188),
(1460, 'BNPL', 188),
(1461, 'Office DVR', 188),
(1462, 'Sanjuz Entrtentment', 188),
(1463, 'A', 188),
(1464, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1465, 'DB8TO-Dbake Bldg.', 188),
(1466, 'Chaitanya', 188),
(1467, 'Goregaon', 188),
(1468, 'Sai Sarovar', 188),
(1469, 'TM10N2E - Chaitanya Goregaon', 188),
(1470, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1471, 'Maitree Park', 188),
(1472, '-0360B  - 8nos - Maitree Park', 188),
(1473, '116HS-538714', 188),
(1474, 'Damajibhai', 188),
(1475, 'Sai Gabasti', 188),
(1476, 'Vishal Diamond MIDC', 188),
(1477, 'Malgudi-Turbhe', 188),
(1478, 'Vishal', 188),
(1479, 'New Dindoshi', 188),
(1480, 'shree siddhi', 188),
(1481, 'Anurag Nursing Home', 188),
(1482, 'Practice Agile Solution Pvt.Ltd', 188),
(1483, 'Mike Offset', 188),
(1484, 'Surajmal Lallubhai', 188),
(1485, 'Gokul Nagari', 188),
(1486, 'Darshan Hights', 188),
(1487, 'BNPL', 188),
(1488, 'Office DVR', 188),
(1489, 'Sanjuz Entrtentment', 188),
(1490, 'A', 188),
(1491, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1492, 'DB8TO-Dbake Bldg.', 188),
(1493, 'Chaitanya', 188),
(1494, 'Goregaon', 188),
(1495, 'Sai Sarovar', 188),
(1496, 'TM10N2E - Chaitanya Goregaon', 188),
(1497, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1498, 'Maitree Park', 188),
(1499, '-0360B  - 8nos - Maitree Park', 188),
(1500, '116HS-538714', 188),
(1501, 'Damajibhai', 188),
(1502, 'Sai Gabasti', 188),
(1503, 'Vishal Diamond MIDC', 188),
(1504, 'Malgudi-Turbhe', 188),
(1505, 'Vishal', 188),
(1506, 'New Dindoshi', 188),
(1507, 'shree siddhi', 188),
(1508, 'Anurag Nursing Home', 188),
(1509, 'Practice Agile Solution Pvt.Ltd', 188),
(1510, 'Mike Offset', 188),
(1511, 'Surajmal Lallubhai', 188),
(1512, 'Gokul Nagari', 188),
(1513, 'Darshan Hights', 188),
(1514, 'BNPL', 188),
(1515, 'Office DVR', 188),
(1516, 'Sanjuz Entrtentment', 188),
(1517, 'A', 188),
(1518, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1519, 'DB8TO-Dbake Bldg.', 188),
(1520, 'Chaitanya', 188),
(1521, 'Goregaon', 188),
(1522, 'Sai Sarovar', 188),
(1523, 'TM10N2E - Chaitanya Goregaon', 188),
(1524, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1525, 'Maitree Park', 188),
(1526, '-0360B  - 8nos - Maitree Park', 188),
(1527, '116HS-538714', 188),
(1528, 'Damajibhai', 188),
(1529, 'Sai Gabasti', 188),
(1530, 'Vishal Diamond MIDC', 188),
(1531, 'Malgudi-Turbhe', 188),
(1532, 'Vishal', 188),
(1533, 'New Dindoshi', 188),
(1534, 'shree siddhi', 188),
(1535, 'Anurag Nursing Home', 188),
(1536, 'Practice Agile Solution Pvt.Ltd', 188),
(1537, 'Mike Offset', 188),
(1538, 'Surajmal Lallubhai', 188),
(1539, 'Gokul Nagari', 188),
(1540, 'Darshan Hights', 188),
(1541, 'BNPL', 188),
(1542, 'Office DVR', 188),
(1543, 'Sanjuz Entrtentment', 188),
(1544, 'A', 188),
(1545, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1546, 'DB8TO-Dbake Bldg.', 188),
(1547, 'Chaitanya', 188),
(1548, 'Goregaon', 188),
(1549, 'Sai Sarovar', 188),
(1550, 'TM10N2E - Chaitanya Goregaon', 188),
(1551, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1552, 'Maitree Park', 188),
(1553, '-0360B  - 8nos - Maitree Park', 188),
(1554, '116HS-538714', 188),
(1555, 'Damajibhai', 188),
(1556, 'Sai Gabasti', 188),
(1557, 'Vishal Diamond MIDC', 188),
(1558, 'Malgudi-Turbhe', 188),
(1559, 'Vishal', 188),
(1560, 'New Dindoshi', 188),
(1561, 'shree siddhi', 188),
(1562, 'Anurag Nursing Home', 188),
(1563, 'Practice Agile Solution Pvt.Ltd', 188),
(1564, 'Mike Offset', 188),
(1565, 'Surajmal Lallubhai', 188),
(1566, 'Gokul Nagari', 188),
(1567, 'Darshan Hights', 188),
(1568, 'BNPL', 188),
(1569, 'Office DVR', 188),
(1570, 'Sanjuz Entrtentment', 188),
(1571, 'A', 188),
(1572, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1573, 'DB8TO-Dbake Bldg.', 188),
(1574, 'Chaitanya', 188),
(1575, 'Goregaon', 188),
(1576, 'Sai Sarovar', 188),
(1577, 'TM10N2E - Chaitanya Goregaon', 188),
(1578, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1579, 'Maitree Park', 188),
(1580, '-0360B  - 8nos - Maitree Park', 188),
(1581, '116HS-538714', 188),
(1582, 'Damajibhai', 188),
(1583, 'Sai Gabasti', 188),
(1584, 'Vishal Diamond MIDC', 188),
(1585, 'Malgudi-Turbhe', 188),
(1586, 'Vishal', 188),
(1587, 'New Dindoshi', 188),
(1588, 'shree siddhi', 188),
(1589, 'Anurag Nursing Home', 188),
(1590, 'Practice Agile Solution Pvt.Ltd', 188),
(1591, 'Mike Offset', 188),
(1592, 'Surajmal Lallubhai', 188),
(1593, 'Gokul Nagari', 188),
(1594, 'Darshan Hights', 188),
(1595, 'BNPL', 188),
(1596, 'Office DVR', 188),
(1597, 'Sanjuz Entrtentment', 188),
(1598, 'A', 188),
(1599, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1600, 'DB8TO-Dbake Bldg.', 188),
(1601, 'Chaitanya', 188),
(1602, 'Goregaon', 188),
(1603, 'Sai Sarovar', 188),
(1604, 'TM10N2E - Chaitanya Goregaon', 188),
(1605, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1606, 'Maitree Park', 188),
(1607, '-0360B  - 8nos - Maitree Park', 188),
(1608, '116HS-538714', 188),
(1609, 'Damajibhai', 188),
(1610, 'Sai Gabasti', 188),
(1611, 'Vishal Diamond MIDC', 188),
(1612, 'Malgudi-Turbhe', 188),
(1613, 'Vishal', 188),
(1614, 'New Dindoshi', 188),
(1615, 'shree siddhi', 188),
(1616, 'Anurag Nursing Home', 188),
(1617, 'Practice Agile Solution Pvt.Ltd', 188),
(1618, 'Mike Offset', 188),
(1619, 'Surajmal Lallubhai', 188),
(1620, 'Gokul Nagari', 188),
(1621, 'Darshan Hights', 188),
(1622, 'BNPL', 188),
(1623, 'Office DVR', 188),
(1624, 'Sanjuz Entrtentment', 188),
(1625, 'A', 188),
(1626, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 6),
(1627, 'DB8TO-Dbake Bldg.', 6),
(1628, 'Chaitanya', 6),
(1629, 'Goregaon', 6),
(1630, 'Sai Sarovar', 6),
(1631, 'TM10N2E - Chaitanya Goregaon', 6),
(1632, 'TM10N3-26 & 13 Sai Sarovar', 6),
(1633, 'Maitree Park', 6),
(1634, '-0360B  - 8nos - Maitree Park', 6),
(1635, '116HS-538714', 6),
(1636, 'Damajibhai', 6),
(1637, 'Sai Gabasti', 6),
(1638, 'Vishal Diamond MIDC', 6),
(1639, 'Malgudi-Turbhe', 6),
(1640, 'Vishal', 6),
(1641, 'New Dindoshi', 6),
(1642, 'shree siddhi', 6),
(1643, 'Anurag Nursing Home', 6),
(1644, 'Practice Agile Solution Pvt.Ltd', 6),
(1645, 'Mike Offset', 6),
(1646, 'Surajmal Lallubhai', 6),
(1647, 'Gokul Nagari', 6),
(1648, 'Darshan Hights', 6),
(1649, 'BNPL', 6),
(1650, 'Office DVR', 6),
(1651, 'Sanjuz Entrtentment', 6),
(1652, 'A', 6),
(1653, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 6),
(1654, 'DB8TO-Dbake Bldg.', 6),
(1655, 'Chaitanya', 6),
(1656, 'Goregaon', 6),
(1657, 'Sai Sarovar', 6),
(1658, 'TM10N2E - Chaitanya Goregaon', 6);
INSERT INTO `i_tags` (`it_id`, `it_value`, `it_owner`) VALUES
(1659, 'TM10N3-26 & 13 Sai Sarovar', 6),
(1660, 'Maitree Park', 6),
(1661, '-0360B  - 8nos - Maitree Park', 6),
(1662, '116HS-538714', 6),
(1663, 'Damajibhai', 6),
(1664, 'Sai Gabasti', 6),
(1665, 'Vishal Diamond MIDC', 6),
(1666, 'Malgudi-Turbhe', 6),
(1667, 'Vishal', 6),
(1668, 'New Dindoshi', 6),
(1669, 'shree siddhi', 6),
(1670, 'Anurag Nursing Home', 6),
(1671, 'Practice Agile Solution Pvt.Ltd', 6),
(1672, 'Mike Offset', 6),
(1673, 'Surajmal Lallubhai', 6),
(1674, 'Gokul Nagari', 6),
(1675, 'Darshan Hights', 6),
(1676, 'BNPL', 6),
(1677, 'Office DVR', 6),
(1678, 'Sanjuz Entrtentment', 6),
(1679, 'A', 6),
(1680, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1681, 'DB8TO-Dbake Bldg.', 188),
(1682, 'Chaitanya', 188),
(1683, 'Goregaon', 188),
(1684, 'Sai Sarovar', 188),
(1685, 'TM10N2E - Chaitanya Goregaon', 188),
(1686, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1687, 'Maitree Park', 188),
(1688, '-0360B  - 8nos - Maitree Park', 188),
(1689, '116HS-538714', 188),
(1690, 'Damajibhai', 188),
(1691, 'Sai Gabasti', 188),
(1692, 'Vishal Diamond MIDC', 188),
(1693, 'Malgudi-Turbhe', 188),
(1694, 'Vishal', 188),
(1695, 'New Dindoshi', 188),
(1696, 'shree siddhi', 188),
(1697, 'Anurag Nursing Home', 188),
(1698, 'Practice Agile Solution Pvt.Ltd', 188),
(1699, 'Mike Offset', 188),
(1700, 'Surajmal Lallubhai', 188),
(1701, 'Gokul Nagari', 188),
(1702, 'Darshan Hights', 188),
(1703, 'BNPL', 188),
(1704, 'Office DVR', 188),
(1705, 'Sanjuz Entrtentment', 188),
(1706, 'A', 188),
(1707, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1708, 'DB8TO-Dbake Bldg.', 188),
(1709, 'Chaitanya', 188),
(1710, 'Goregaon', 188),
(1711, 'Sai Sarovar', 188),
(1712, 'TM10N2E - Chaitanya Goregaon', 188),
(1713, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1714, 'Maitree Park', 188),
(1715, '-0360B  - 8nos - Maitree Park', 188),
(1716, '116HS-538714', 188),
(1717, 'Damajibhai', 188),
(1718, 'Sai Gabasti', 188),
(1719, 'Vishal Diamond MIDC', 188),
(1720, 'Malgudi-Turbhe', 188),
(1721, 'Vishal', 188),
(1722, 'New Dindoshi', 188),
(1723, 'shree siddhi', 188),
(1724, 'Anurag Nursing Home', 188),
(1725, 'Practice Agile Solution Pvt.Ltd', 188),
(1726, 'Mike Offset', 188),
(1727, 'Surajmal Lallubhai', 188),
(1728, 'Gokul Nagari', 188),
(1729, 'Darshan Hights', 188),
(1730, 'BNPL', 188),
(1731, 'Office DVR', 188),
(1732, 'Sanjuz Entrtentment', 188),
(1733, 'A', 188),
(1734, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1735, 'DB8TO-Dbake Bldg.', 188),
(1736, 'Chaitanya', 188),
(1737, 'Goregaon', 188),
(1738, 'Sai Sarovar', 188),
(1739, 'TM10N2E - Chaitanya Goregaon', 188),
(1740, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1741, 'Maitree Park', 188),
(1742, '-0360B  - 8nos - Maitree Park', 188),
(1743, '116HS-538714', 188),
(1744, 'Damajibhai', 188),
(1745, 'Sai Gabasti', 188),
(1746, 'Vishal Diamond MIDC', 188),
(1747, 'Malgudi-Turbhe', 188),
(1748, 'Vishal', 188),
(1749, 'New Dindoshi', 188),
(1750, 'shree siddhi', 188),
(1751, 'Anurag Nursing Home', 188),
(1752, 'Practice Agile Solution Pvt.Ltd', 188),
(1753, 'Mike Offset', 188),
(1754, 'Surajmal Lallubhai', 188),
(1755, 'Gokul Nagari', 188),
(1756, 'Darshan Hights', 188),
(1757, 'BNPL', 188),
(1758, 'Office DVR', 188),
(1759, 'Sanjuz Entrtentment', 188),
(1760, 'A', 188),
(1761, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1762, 'DB8TO-Dbake Bldg.', 188),
(1763, 'Chaitanya', 188),
(1764, 'Goregaon', 188),
(1765, 'Sai Sarovar', 188),
(1766, 'TM10N2E - Chaitanya Goregaon', 188),
(1767, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1768, 'Maitree Park', 188),
(1769, '-0360B  - 8nos - Maitree Park', 188),
(1770, '116HS-538714', 188),
(1771, 'Damajibhai', 188),
(1772, 'Sai Gabasti', 188),
(1773, 'Vishal Diamond MIDC', 188),
(1774, 'Malgudi-Turbhe', 188),
(1775, 'Vishal', 188),
(1776, 'New Dindoshi', 188),
(1777, 'shree siddhi', 188),
(1778, 'Anurag Nursing Home', 188),
(1779, 'Practice Agile Solution Pvt.Ltd', 188),
(1780, 'Mike Offset', 188),
(1781, 'Surajmal Lallubhai', 188),
(1782, 'Gokul Nagari', 188),
(1783, 'Darshan Hights', 188),
(1784, 'BNPL', 188),
(1785, 'Office DVR', 188),
(1786, 'Sanjuz Entrtentment', 188),
(1787, 'A', 188),
(1788, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1789, 'DB8TO-Dbake Bldg.', 188),
(1790, 'Chaitanya', 188),
(1791, 'Goregaon', 188),
(1792, 'Sai Sarovar', 188),
(1793, 'TM10N2E - Chaitanya Goregaon', 188),
(1794, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1795, 'Maitree Park', 188),
(1796, '-0360B  - 8nos - Maitree Park', 188),
(1797, '116HS-538714', 188),
(1798, 'Damajibhai', 188),
(1799, 'Sai Gabasti', 188),
(1800, 'Vishal Diamond MIDC', 188),
(1801, 'Malgudi-Turbhe', 188),
(1802, 'Vishal', 188),
(1803, 'New Dindoshi', 188),
(1804, 'shree siddhi', 188),
(1805, 'Anurag Nursing Home', 188),
(1806, 'Practice Agile Solution Pvt.Ltd', 188),
(1807, 'Mike Offset', 188),
(1808, 'Surajmal Lallubhai', 188),
(1809, 'Gokul Nagari', 188),
(1810, 'Darshan Hights', 188),
(1811, 'BNPL', 188),
(1812, 'Office DVR', 188),
(1813, 'Sanjuz Entrtentment', 188),
(1814, 'A', 188),
(1815, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1816, 'DB8TO-Dbake Bldg.', 188),
(1817, 'Chaitanya', 188),
(1818, 'Goregaon', 188),
(1819, 'Sai Sarovar', 188),
(1820, 'TM10N2E - Chaitanya Goregaon', 188),
(1821, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1822, 'Maitree Park', 188),
(1823, '-0360B  - 8nos - Maitree Park', 188),
(1824, '116HS-538714', 188),
(1825, 'Damajibhai', 188),
(1826, 'Sai Gabasti', 188),
(1827, 'Vishal Diamond MIDC', 188),
(1828, 'Malgudi-Turbhe', 188),
(1829, 'Vishal', 188),
(1830, 'New Dindoshi', 188),
(1831, 'shree siddhi', 188),
(1832, 'Anurag Nursing Home', 188),
(1833, 'Practice Agile Solution Pvt.Ltd', 188),
(1834, 'Mike Offset', 188),
(1835, 'Surajmal Lallubhai', 188),
(1836, 'Gokul Nagari', 188),
(1837, 'Darshan Hights', 188),
(1838, 'BNPL', 188),
(1839, 'Office DVR', 188),
(1840, 'Sanjuz Entrtentment', 188),
(1841, 'A', 188),
(1842, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1843, 'DB8TO-Dbake Bldg.', 188),
(1844, 'Chaitanya', 188),
(1845, 'Goregaon', 188),
(1846, 'Sai Sarovar', 188),
(1847, 'TM10N2E - Chaitanya Goregaon', 188),
(1848, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1849, 'Maitree Park', 188),
(1850, '-0360B  - 8nos - Maitree Park', 188),
(1851, '116HS-538714', 188),
(1852, 'Damajibhai', 188),
(1853, 'Sai Gabasti', 188),
(1854, 'Vishal Diamond MIDC', 188),
(1855, 'Malgudi-Turbhe', 188),
(1856, 'Vishal', 188),
(1857, 'New Dindoshi', 188),
(1858, 'shree siddhi', 188),
(1859, 'Anurag Nursing Home', 188),
(1860, 'Practice Agile Solution Pvt.Ltd', 188),
(1861, 'Mike Offset', 188),
(1862, 'Surajmal Lallubhai', 188),
(1863, 'Gokul Nagari', 188),
(1864, 'Darshan Hights', 188),
(1865, 'BNPL', 188),
(1866, 'Office DVR', 188),
(1867, 'Sanjuz Entrtentment', 188),
(1868, 'A', 188),
(1869, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1870, 'DB8TO-Dbake Bldg.', 188),
(1871, 'Chaitanya', 188),
(1872, 'Goregaon', 188),
(1873, 'Sai Sarovar', 188),
(1874, 'TM10N2E - Chaitanya Goregaon', 188),
(1875, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1876, 'Maitree Park', 188),
(1877, '-0360B  - 8nos - Maitree Park', 188),
(1878, '116HS-538714', 188),
(1879, 'Damajibhai', 188),
(1880, 'Sai Gabasti', 188),
(1881, 'Vishal Diamond MIDC', 188),
(1882, 'Malgudi-Turbhe', 188),
(1883, 'Vishal', 188),
(1884, 'New Dindoshi', 188),
(1885, 'shree siddhi', 188),
(1886, 'Anurag Nursing Home', 188),
(1887, 'Practice Agile Solution Pvt.Ltd', 188),
(1888, 'Mike Offset', 188),
(1889, 'Surajmal Lallubhai', 188),
(1890, 'Gokul Nagari', 188),
(1891, 'Darshan Hights', 188),
(1892, 'BNPL', 188),
(1893, 'Office DVR', 188),
(1894, 'Sanjuz Entrtentment', 188),
(1895, 'A', 188),
(1896, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1897, 'DB8TO-Dbake Bldg.', 188),
(1898, 'Chaitanya', 188),
(1899, 'Goregaon', 188),
(1900, 'Sai Sarovar', 188),
(1901, 'TM10N2E - Chaitanya Goregaon', 188),
(1902, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1903, 'Maitree Park', 188),
(1904, '-0360B  - 8nos - Maitree Park', 188),
(1905, '116HS-538714', 188),
(1906, 'Damajibhai', 188),
(1907, 'Sai Gabasti', 188),
(1908, 'Vishal Diamond MIDC', 188),
(1909, 'Malgudi-Turbhe', 188),
(1910, 'Vishal', 188),
(1911, 'New Dindoshi', 188),
(1912, 'shree siddhi', 188),
(1913, 'Anurag Nursing Home', 188),
(1914, 'Practice Agile Solution Pvt.Ltd', 188),
(1915, 'Mike Offset', 188),
(1916, 'Surajmal Lallubhai', 188),
(1917, 'Gokul Nagari', 188),
(1918, 'Darshan Hights', 188),
(1919, 'BNPL', 188),
(1920, 'Office DVR', 188),
(1921, 'Sanjuz Entrtentment', 188),
(1922, 'A', 188),
(1923, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1924, 'DB8TO-Dbake Bldg.', 188),
(1925, 'Chaitanya', 188),
(1926, 'Goregaon', 188),
(1927, 'Sai Sarovar', 188),
(1928, 'TM10N2E - Chaitanya Goregaon', 188),
(1929, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1930, 'Maitree Park', 188),
(1931, '-0360B  - 8nos - Maitree Park', 188),
(1932, '116HS-538714', 188),
(1933, 'Damajibhai', 188),
(1934, 'Sai Gabasti', 188),
(1935, 'Vishal Diamond MIDC', 188),
(1936, 'Malgudi-Turbhe', 188),
(1937, 'Vishal', 188),
(1938, 'New Dindoshi', 188),
(1939, 'shree siddhi', 188),
(1940, 'Anurag Nursing Home', 188),
(1941, 'Practice Agile Solution Pvt.Ltd', 188),
(1942, 'Mike Offset', 188),
(1943, 'Surajmal Lallubhai', 188),
(1944, 'Gokul Nagari', 188),
(1945, 'Darshan Hights', 188),
(1946, 'BNPL', 188),
(1947, 'Office DVR', 188),
(1948, 'Sanjuz Entrtentment', 188),
(1949, 'A', 188),
(1950, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(1951, 'DB8TO-Dbake Bldg.', 188),
(1952, 'Chaitanya', 188),
(1953, 'Goregaon', 188),
(1954, 'Sai Sarovar', 188),
(1955, 'TM10N2E - Chaitanya Goregaon', 188),
(1956, 'TM10N3-26 & 13 Sai Sarovar', 188),
(1957, 'Maitree Park', 188),
(1958, '-0360B  - 8nos - Maitree Park', 188),
(1959, '116HS-538714', 188),
(1960, 'Damajibhai', 188),
(1961, 'Sai Gabasti', 188),
(1962, 'Vishal Diamond MIDC', 188),
(1963, 'Malgudi-Turbhe', 188),
(1964, 'Vishal', 188),
(1965, 'New Dindoshi', 188),
(1966, 'shree siddhi', 188),
(1967, 'Anurag Nursing Home', 188),
(1968, 'Practice Agile Solution Pvt.Ltd', 188),
(1969, 'Mike Offset', 188),
(1970, 'Surajmal Lallubhai', 188),
(1971, 'Gokul Nagari', 188),
(1972, 'Darshan Hights', 188),
(1973, 'BNPL', 188),
(1974, 'Office DVR', 188),
(1975, 'Sanjuz Entrtentment', 188),
(1976, 'A', 188),
(1977, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 6),
(1978, 'DB8TO-Dbake Bldg.', 6),
(1979, 'Chaitanya', 6),
(1980, 'Goregaon', 6),
(1981, 'Sai Sarovar', 6),
(1982, 'TM10N2E - Chaitanya Goregaon', 6),
(1983, 'TM10N3-26 & 13 Sai Sarovar', 6),
(1984, 'Maitree Park', 6),
(1985, '-0360B  - 8nos - Maitree Park', 6),
(1986, '116HS-538714', 6),
(1987, 'Damajibhai', 6),
(1988, 'Sai Gabasti', 6),
(1989, 'Vishal Diamond MIDC', 6),
(1990, 'Malgudi-Turbhe', 6),
(1991, 'Vishal', 6),
(1992, 'New Dindoshi', 6),
(1993, 'shree siddhi', 6),
(1994, 'Anurag Nursing Home', 6),
(1995, 'Practice Agile Solution Pvt.Ltd', 6),
(1996, 'Mike Offset', 6),
(1997, 'Surajmal Lallubhai', 6),
(1998, 'Gokul Nagari', 6),
(1999, 'Darshan Hights', 6),
(2000, 'BNPL', 6),
(2001, 'Office DVR', 6),
(2002, 'Sanjuz Entrtentment', 6),
(2003, 'A', 6),
(2004, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 6),
(2005, 'DB8TO-Dbake Bldg.', 6),
(2006, 'Chaitanya', 6),
(2007, 'Goregaon', 6),
(2008, 'Sai Sarovar', 6),
(2009, 'TM10N2E - Chaitanya Goregaon', 6),
(2010, 'TM10N3-26 & 13 Sai Sarovar', 6),
(2011, 'Maitree Park', 6),
(2012, '-0360B  - 8nos - Maitree Park', 6),
(2013, '116HS-538714', 6),
(2014, 'Damajibhai', 6),
(2015, 'Sai Gabasti', 6),
(2016, 'Vishal Diamond MIDC', 6),
(2017, 'Malgudi-Turbhe', 6),
(2018, 'Vishal', 6),
(2019, 'New Dindoshi', 6),
(2020, 'shree siddhi', 6),
(2021, 'Anurag Nursing Home', 6),
(2022, 'Practice Agile Solution Pvt.Ltd', 6),
(2023, 'Mike Offset', 6),
(2024, 'Surajmal Lallubhai', 6),
(2025, 'Gokul Nagari', 6),
(2026, 'Darshan Hights', 6),
(2027, 'BNPL', 6),
(2028, 'Office DVR', 6),
(2029, 'Sanjuz Entrtentment', 6),
(2030, 'A', 6),
(2031, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(2032, 'DB8TO-Dbake Bldg.', 188),
(2033, 'Chaitanya', 188),
(2034, 'Goregaon', 188),
(2035, 'Sai Sarovar', 188),
(2036, 'TM10N2E - Chaitanya Goregaon', 188),
(2037, 'TM10N3-26 & 13 Sai Sarovar', 188),
(2038, 'Maitree Park', 188),
(2039, '-0360B  - 8nos - Maitree Park', 188),
(2040, '116HS-538714', 188),
(2041, 'Damajibhai', 188),
(2042, 'Sai Gabasti', 188),
(2043, 'Vishal Diamond MIDC', 188),
(2044, 'Malgudi-Turbhe', 188),
(2045, 'Vishal', 188),
(2046, 'New Dindoshi', 188),
(2047, 'shree siddhi', 188),
(2048, 'Anurag Nursing Home', 188),
(2049, 'Practice Agile Solution Pvt.Ltd', 188),
(2050, 'Mike Offset', 188),
(2051, 'Surajmal Lallubhai', 188),
(2052, 'Gokul Nagari', 188),
(2053, 'Darshan Hights', 188),
(2054, 'BNPL', 188),
(2055, 'Office DVR', 188),
(2056, 'Sanjuz Entrtentment', 188),
(2057, 'A', 188),
(2058, 'TM10N2E-Chaityna Goregaon &TM10N3-26 &13 Sai Sarovar', 188),
(2059, 'DB8TO-Dbake Bldg.', 188),
(2060, 'Chaitanya', 188),
(2061, 'Goregaon', 188),
(2062, 'Sai Sarovar', 188),
(2063, 'TM10N2E - Chaitanya Goregaon', 188),
(2064, 'TM10N3-26 & 13 Sai Sarovar', 188),
(2065, 'Maitree Park', 188),
(2066, '-0360B  - 8nos - Maitree Park', 188),
(2067, '116HS-538714', 188),
(2068, 'Damajibhai', 188),
(2069, 'Sai Gabasti', 188),
(2070, 'Vishal Diamond MIDC', 188),
(2071, 'Malgudi-Turbhe', 188),
(2072, 'Vishal', 188),
(2073, 'New Dindoshi', 188),
(2074, 'shree siddhi', 188),
(2075, 'Anurag Nursing Home', 188),
(2076, 'Practice Agile Solution Pvt.Ltd', 188),
(2077, 'Mike Offset', 188),
(2078, 'Surajmal Lallubhai', 188),
(2079, 'Gokul Nagari', 188),
(2080, 'Darshan Hights', 188),
(2081, 'BNPL', 188),
(2082, 'Office DVR', 188),
(2083, 'Sanjuz Entrtentment', 188),
(2084, 'A', 188),
(2085, 'test', 1),
(2086, 'save', 1),
(2087, 'owner', 1),
(2088, 'update', 1),
(2089, 'vinaya', 1),
(2090, 'shreyas', 1),
(2091, 'test new inv', 1),
(2092, 'test outward', 1),
(2093, 'new inve', 1),
(2094, 'asdasd', 1),
(2095, 'new inventory', 1),
(2096, 'test new', 1),
(2097, 'purchase_order', 1),
(2098, 'credit_note', 1),
(2099, 'debit_note', 1),
(2100, 'test', 19),
(2101, 'welcome', 19),
(2102, 'note', 19),
(2103, 'welcome tag', 19),
(2104, 'txt', 19),
(2105, 'ext', 19),
(2106, 'to', 19),
(2107, 'india', 19),
(2108, 'kpatole', 19),
(2109, 'vinaya', 19),
(2110, '12121212', 19),
(2111, 'save_as', 19),
(2112, 'outward', 19),
(2113, 'inward', 19),
(2114, 'order_note', 19),
(2115, '12', 19),
(2116, 'rejection in', 19),
(2117, 'rej out', 19),
(2118, 'welcome_mterial_in', 19),
(2119, '121212121', 19),
(2120, '212121212121212', 19),
(2121, 'Test vendor', 4),
(2122, 'inward', 4),
(2123, 'Test customer', 4),
(2124, 'outward', 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_taxes`
--

CREATE TABLE `i_taxes` (
  `itx_id` int(11) NOT NULL,
  `itx_name` varchar(100) DEFAULT NULL,
  `itx_percent` float DEFAULT NULL,
  `itx_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_taxes`
--

INSERT INTO `i_taxes` (`itx_id`, `itx_name`, `itx_percent`, `itx_owner`) VALUES
(158, 'SGST', 9, 1),
(157, 'CGST', 9, 1),
(156, 'SGST 14%', 14, 188),
(155, 'CGST 14%', 14, 188),
(151, 'CGST 2.5 %', 2.5, 188),
(152, 'SGST 2.5 %', 2.5, 188),
(153, 'CGST 9%', 9, 188),
(154, 'SGST 9%', 9, 188);

-- --------------------------------------------------------

--
-- Table structure for table `i_tax_cess`
--

CREATE TABLE `i_tax_cess` (
  `itxc_id` int(11) NOT NULL,
  `itxc_t_id` int(11) DEFAULT NULL,
  `itxc_cess_name` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_tax_group`
--

CREATE TABLE `i_tax_group` (
  `ittxg_id` int(11) NOT NULL,
  `ittxg_group_name` varchar(100) DEFAULT NULL,
  `ittxg_owner` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_tax_group`
--

INSERT INTO `i_tax_group` (`ittxg_id`, `ittxg_group_name`, `ittxg_owner`) VALUES
(87, 'GST 5%', 188),
(88, 'GST 18%', 188),
(89, 'GST 28%', 188),
(90, 'GST 18%', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_tax_group_collection`
--

CREATE TABLE `i_tax_group_collection` (
  `itxgc_id` int(11) NOT NULL,
  `itxgc_tg_id` int(11) DEFAULT NULL,
  `itxgc_tx_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_tax_group_collection`
--

INSERT INTO `i_tax_group_collection` (`itxgc_id`, `itxgc_tg_id`, `itxgc_tx_id`) VALUES
(168, 90, 157),
(164, 88, 153),
(167, 89, 156),
(163, 87, 152),
(169, 90, 158),
(166, 89, 155),
(165, 88, 154),
(162, 87, 151);

-- --------------------------------------------------------

--
-- Table structure for table `i_tc_columns`
--

CREATE TABLE `i_tc_columns` (
  `itcc_id` int(11) NOT NULL,
  `itcc_tc_id` int(11) DEFAULT NULL,
  `itcc_column` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_template`
--

CREATE TABLE `i_template` (
  `itemp_id` int(10) NOT NULL,
  `itemp_title` varchar(100) NOT NULL,
  `itemp_domain` varchar(50) NOT NULL,
  `itemp_module` varchar(50) NOT NULL,
  `itemp_file_name` varchar(100) NOT NULL,
  `itemp_img_name` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_template`
--

INSERT INTO `i_template` (`itemp_id`, `itemp_title`, `itemp_domain`, `itemp_module`, `itemp_file_name`, `itemp_img_name`) VALUES
(159, 'Simple', '8', '36', 'inventory_simple.php', NULL),
(158, 'Simple', '8', '35', 'invoice_simple.php', 'simple_invoice.jpg'),
(167, 'Classic', '8', '35', 'invoice_classic.php', NULL),
(160, 'Simple', '8', '40', 'purchase_simple.php', 'irene_icon.svg'),
(161, 'Classic', '8', '40', 'purchase_classic.php', NULL),
(162, 'Simple', '8', '51', 'proposal_simple.php', NULL),
(163, 'classic', '17', '51', 'proposal_classic.php', NULL),
(164, 'Simple', '8', '42', 'amc_simple.php', NULL),
(165, 'classic', '8', '42', 'amc_classic.php', NULL),
(166, 'classic', '8', '36', 'inventory_classic.php', NULL),
(168, 'Simple', '24', '56', 'order_simple.php', NULL),
(169, 'Evomata', '8', '42', 'amc_evomata.php', NULL),
(170, 'Evomata', '8', '36', 'inventory_evomata.php', NULL),
(171, 'Evomata', '8', '51', 'proposal_evomata.php', NULL),
(172, 'Evomata', '8', '35', 'invoice_evomata.php', NULL),
(173, 'Evomata', '36', '68', 'purchase_order_evomata.php', NULL),
(174, 'Evomata', '37', '69', 'credit_note_evomata.php', NULL),
(175, 'Evomata', '38', '70', 'debit_note_evomata.php', NULL),
(176, 'Evomata', '34', '72', 'inventory_evomata.php', NULL),
(177, 'Test', '34', '72', 'inventory_evomata.php', NULL),
(179, 'Evomata', '24', '56', 'order_evomata.php', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_time_constraint`
--

CREATE TABLE `i_time_constraint` (
  `itc_id` int(11) NOT NULL,
  `itc_name` varchar(100) DEFAULT NULL,
  `itc_table` varchar(100) DEFAULT NULL,
  `itc_column` varchar(100) DEFAULT NULL,
  `itc_query` varchar(900) DEFAULT NULL,
  `itc_display` int(11) DEFAULT NULL,
  `itc_module` int(11) DEFAULT NULL,
  `itc_created` datetime DEFAULT NULL,
  `itc_created_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_units`
--

CREATE TABLE `i_units` (
  `ipu_id` int(11) NOT NULL,
  `ipu_unit_name` varchar(100) DEFAULT NULL,
  `ipu_owner` int(11) DEFAULT NULL,
  `ipu_created` datetime DEFAULT NULL,
  `ipu_created_by` int(11) DEFAULT NULL,
  `ipu_modified` datetime DEFAULT NULL,
  `ipu_modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_units`
--

INSERT INTO `i_units` (`ipu_id`, `ipu_unit_name`, `ipu_owner`, `ipu_created`, `ipu_created_by`, `ipu_modified`, `ipu_modified_by`) VALUES
(183, NULL, 6, '2018-10-02 10:10:13', 6, NULL, NULL),
(184, NULL, 6, '2018-10-02 11:10:31', 6, NULL, NULL),
(185, NULL, 6, '2018-10-02 11:10:25', 6, NULL, NULL),
(186, NULL, 188, '2018-10-09 11:10:28', 188, NULL, NULL),
(187, NULL, 188, '2018-11-29 16:11:49', 188, NULL, NULL),
(188, NULL, 188, '2018-11-29 16:11:55', 188, NULL, NULL),
(189, '1234', 188, '2018-11-29 16:11:25', 188, NULL, NULL),
(190, NULL, 188, '2018-12-05 19:12:58', 188, NULL, NULL),
(191, NULL, 188, '2018-12-06 20:12:05', 188, NULL, NULL),
(192, NULL, 188, '2018-12-12 15:12:24', 188, NULL, NULL),
(193, NULL, 188, '2018-12-12 15:12:22', 188, NULL, NULL),
(194, NULL, 188, '2018-12-12 17:12:27', 188, NULL, NULL),
(195, NULL, 188, '2018-12-23 08:12:01', 188, NULL, NULL),
(196, NULL, 188, '2018-12-28 12:12:15', 188, NULL, NULL),
(197, NULL, 188, '2018-12-28 12:12:01', 188, NULL, NULL),
(198, NULL, 188, '2018-12-28 16:12:01', 188, NULL, NULL),
(199, NULL, 188, '2018-12-28 18:12:06', 188, NULL, NULL),
(200, NULL, 188, '2018-12-28 19:12:01', 188, NULL, NULL),
(201, NULL, 188, '2018-12-28 19:12:05', 188, NULL, NULL),
(202, NULL, 188, '2018-12-28 19:12:59', 188, NULL, NULL),
(203, NULL, 188, '2018-12-28 19:12:44', 188, NULL, NULL),
(204, NULL, 188, '2019-01-02 19:01:41', 188, NULL, NULL),
(205, NULL, 188, '2019-01-02 19:01:02', 188, NULL, NULL),
(206, NULL, 188, '2019-01-03 11:01:26', 188, NULL, NULL),
(207, NULL, 188, '2019-01-03 11:01:18', 188, NULL, NULL),
(208, NULL, 188, '2019-01-03 12:01:09', 188, NULL, NULL),
(209, NULL, 188, '2019-01-03 12:01:10', 188, NULL, NULL),
(210, NULL, 188, '2019-01-03 12:01:12', 188, NULL, NULL),
(211, NULL, 188, '2019-01-03 12:01:17', 188, NULL, NULL),
(212, NULL, 188, '2019-01-03 12:01:31', 188, NULL, NULL),
(213, NULL, 188, '2019-01-03 12:01:59', 188, NULL, NULL),
(214, NULL, 188, '2019-01-03 12:01:14', 188, NULL, NULL),
(215, NULL, 188, '2019-01-08 14:01:19', 188, NULL, NULL),
(216, NULL, 188, '2019-01-08 17:01:31', 188, NULL, NULL),
(217, NULL, 188, '2019-01-10 11:01:23', 188, NULL, NULL),
(218, NULL, 188, '2019-01-10 11:01:38', 188, NULL, NULL),
(219, NULL, 188, '2019-01-11 10:01:59', 188, NULL, NULL),
(220, NULL, 188, '2019-01-12 19:01:25', 188, NULL, NULL),
(221, NULL, 188, '2019-01-12 20:01:01', 188, NULL, NULL),
(222, NULL, 188, '2019-01-12 20:01:24', 188, NULL, NULL),
(223, NULL, 188, '2019-01-12 20:01:03', 188, NULL, NULL),
(224, NULL, 188, '2019-01-14 11:01:05', 188, NULL, NULL),
(225, NULL, 188, '2019-01-14 17:01:54', 188, NULL, NULL),
(226, NULL, 188, '2019-01-23 09:01:45', 188, NULL, NULL),
(227, NULL, 188, '2019-01-23 09:01:24', 188, NULL, NULL),
(228, NULL, 188, '2019-01-29 10:01:00', 188, NULL, NULL),
(229, NULL, 188, '2019-01-30 16:01:54', 188, NULL, NULL),
(230, NULL, 188, '2019-01-30 16:01:21', 188, NULL, NULL),
(231, NULL, 188, '2019-01-30 17:01:45', 188, NULL, NULL),
(232, NULL, 188, '2019-01-30 17:01:19', 188, NULL, NULL),
(233, NULL, 188, '2019-01-30 17:01:48', 188, NULL, NULL),
(234, NULL, 188, '2019-02-04 14:53:14', 188, NULL, NULL),
(235, NULL, 1, '2019-03-05 10:34:39', 1, NULL, NULL),
(236, NULL, 1, '2019-04-01 16:51:17', 1, NULL, NULL),
(237, NULL, 1, '2019-04-10 13:39:49', 1, NULL, NULL),
(238, NULL, 1, '2019-05-13 13:17:59', 1, NULL, NULL),
(239, NULL, 1, '2019-05-13 16:53:01', 1, NULL, NULL),
(240, NULL, 1, '2019-05-13 18:19:35', 1, NULL, NULL),
(241, NULL, 1, '2019-05-14 10:37:27', 1, NULL, NULL),
(242, NULL, 1, '2019-05-15 10:52:00', 1, NULL, NULL),
(243, NULL, 1, '2019-05-21 15:36:45', 1, NULL, NULL),
(244, NULL, 1, '2019-05-21 15:37:15', 1, NULL, NULL),
(245, NULL, 1, '2019-05-21 15:38:02', 1, NULL, NULL),
(246, NULL, 1, '2019-05-21 15:38:58', 1, NULL, NULL),
(247, NULL, 1, '2019-05-21 15:40:33', 1, NULL, NULL),
(248, NULL, 1, '2019-05-21 15:44:57', 1, NULL, NULL),
(249, NULL, 1, '2019-05-21 15:46:34', 1, NULL, NULL),
(250, NULL, 1, '2019-05-21 15:46:39', 1, NULL, NULL),
(251, NULL, 1, '2019-05-21 15:46:56', 1, NULL, NULL),
(252, NULL, 1, '2019-05-21 15:56:15', 1, NULL, NULL),
(253, NULL, 1, '2019-05-21 15:56:37', 1, NULL, NULL),
(254, NULL, 1, '2019-05-21 15:56:55', 1, NULL, NULL),
(255, NULL, 1, '2019-05-21 15:57:10', 1, NULL, NULL),
(256, NULL, 1, '2019-05-21 16:15:22', 1, NULL, NULL),
(257, NULL, 1, '2019-05-21 16:21:55', 1, NULL, NULL),
(258, NULL, 1, '2019-05-21 16:22:19', 1, NULL, NULL),
(259, NULL, 1, '2019-05-21 16:24:18', 1, NULL, NULL),
(260, NULL, 1, '2019-05-21 17:57:16', 1, NULL, NULL),
(261, NULL, 1, '2019-05-21 19:02:52', 1, NULL, NULL),
(262, NULL, 1, '2019-05-21 20:14:56', 1, NULL, NULL),
(263, NULL, 1, '2019-05-22 11:14:16', 1, NULL, NULL),
(264, NULL, 1, '2019-05-22 11:21:45', 1, NULL, NULL),
(265, NULL, 1, '2019-05-22 11:22:19', 1, NULL, NULL),
(266, NULL, 1, '2019-05-23 12:26:23', 1, NULL, NULL),
(267, NULL, 1, '2019-05-25 13:05:55', 1, NULL, NULL),
(268, NULL, 1, '2019-05-25 13:06:41', 1, NULL, NULL),
(269, NULL, 1, '2019-05-25 16:01:28', 1, NULL, NULL),
(270, NULL, 1, '2019-05-25 16:01:51', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_users`
--

CREATE TABLE `i_users` (
  `i_uid` int(11) NOT NULL,
  `i_uname` varchar(100) DEFAULT NULL,
  `i_upassword` varchar(100) DEFAULT NULL,
  `i_status` varchar(100) DEFAULT NULL,
  `i_subscription_start` datetime DEFAULT NULL,
  `i_subscription_renew` datetime DEFAULT NULL,
  `i_duration` int(11) DEFAULT NULL,
  `i_created` datetime DEFAULT NULL,
  `i_created_by` int(11) DEFAULT NULL,
  `i_modified` datetime DEFAULT NULL,
  `i_modified_by` int(11) DEFAULT NULL,
  `i_owner` int(11) DEFAULT NULL,
  `i_ref` int(11) DEFAULT NULL,
  `i_storage` int(11) DEFAULT NULL,
  `i_view` varchar(50) DEFAULT NULL,
  `i_g_limit` int(11) DEFAULT NULL,
  `iu_l_code` varchar(200) DEFAULT NULL,
  `i_user_code` varchar(100) DEFAULT NULL,
  `i_user_scheme` varchar(100) DEFAULT NULL,
  `i_u_home_view` varchar(100) DEFAULT NULL,
  `i_credit_amount` varchar(100) DEFAULT NULL,
  `i_color_theme` varchar(200) DEFAULT NULL,
  `i_gid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_users`
--

INSERT INTO `i_users` (`i_uid`, `i_uname`, `i_upassword`, `i_status`, `i_subscription_start`, `i_subscription_renew`, `i_duration`, `i_created`, `i_created_by`, `i_modified`, `i_modified_by`, `i_owner`, `i_ref`, `i_storage`, `i_view`, `i_g_limit`, `iu_l_code`, `i_user_code`, `i_user_scheme`, `i_u_home_view`, `i_credit_amount`, `i_color_theme`, `i_gid`) VALUES
(1, 'krishnakant@evomata.com', '12', 'old_user', NULL, NULL, NULL, '2019-06-19 11:30:01', 1, '2019-06-20 13:52:44', 1, 1, NULL, 0, 'false', 0, NULL, '4Z841', '3', NULL, '0', 'material.deep_purple-light_green.min.css', 1),
(2, 'kpatole2@gmail.com', '12', 'true', NULL, NULL, NULL, '2019-06-19 13:37:52', 2, '2019-06-19 13:48:56', 2, 2, NULL, 0, 'false', 0, NULL, 'W6BB2', '0', NULL, '0', NULL, NULL),
(3, 'vinayalokhande1993@gmail.com', '12', 'true', NULL, NULL, NULL, '2019-06-19 14:16:45', 3, '2019-06-19 14:21:23', 3, 3, NULL, 0, 'false', 0, NULL, 'TG3W3', '0', NULL, '0', 'material.pink-cyan.min.css', NULL),
(4, 'hitesh@evomata.com', '123', 'true', NULL, NULL, NULL, '2019-06-20 11:24:30', 4, '2019-06-20 11:25:59', 4, 4, NULL, 0, 'false', 0, NULL, 'SU704', '0', NULL, '0', 'material.orange-amber.min.css', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_users_cart`
--

CREATE TABLE `i_users_cart` (
  `iuc_id` int(11) NOT NULL,
  `iuc_uid` int(11) DEFAULT NULL,
  `iuc_group` int(11) DEFAULT NULL,
  `iuc_storage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_users_cart`
--

INSERT INTO `i_users_cart` (`iuc_id`, `iuc_uid`, `iuc_group`, `iuc_storage`) VALUES
(1, 1, 0, 0),
(2, 4, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_users_cart_modules`
--

CREATE TABLE `i_users_cart_modules` (
  `iucm_id` int(11) NOT NULL,
  `iucm_iuc_id` int(11) DEFAULT NULL,
  `iucm_mid` int(11) DEFAULT NULL,
  `iucm_users` int(11) DEFAULT NULL,
  `iucm_status` varchar(100) DEFAULT NULL,
  `iucm_txn_id` int(11) DEFAULT NULL,
  `iucm_sub_month` int(11) DEFAULT NULL,
  `iucm_type` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_users_cart_modules`
--

INSERT INTO `i_users_cart_modules` (`iucm_id`, `iucm_iuc_id`, `iucm_mid`, `iucm_users`, `iucm_status`, `iucm_txn_id`, `iucm_sub_month`, `iucm_type`) VALUES
(1, 1, 71, 1, 'paid', 3, 12, 'purchase'),
(2, 1, 72, 1, 'paid', 3, 12, 'purchase'),
(3, 1, 73, 1, 'paid', 3, 12, 'purchase'),
(4, 1, 76, 1, 'paid', 3, 12, 'purchase'),
(5, 1, 77, 1, 'paid', 3, 12, 'purchase'),
(6, 1, 78, 1, 'paid', 3, 12, 'purchase'),
(7, 1, 79, 1, 'paid', 3, 12, 'purchase'),
(8, 1, 80, 1, 'paid', 3, 12, 'purchase'),
(9, 1, 67, 1, 'paid', 3, 12, 'purchase'),
(10, 1, 75, 1, 'paid', 3, 12, 'purchase'),
(11, 1, 55, 1, 'paid', 3, 12, 'purchase'),
(12, 1, 56, 1, 'paid', 3, 12, 'purchase'),
(13, 1, 74, 1, 'paid', 3, 12, 'purchase'),
(14, 1, 67, 2, 'paid', 4, 12, 'add_user'),
(15, 1, 75, 2, 'paid', 4, 12, 'add_user'),
(16, 1, 55, 2, 'paid', 4, 12, 'add_user'),
(17, 1, 56, 2, 'paid', 4, 12, 'add_user'),
(18, 1, 74, 2, 'paid', 4, 12, 'add_user'),
(19, 1, 71, 2, 'paid', 4, 12, 'add_user'),
(20, 1, 72, 2, 'paid', 4, 12, 'add_user'),
(21, 1, 73, 2, 'paid', 4, 12, 'add_user'),
(22, 1, 76, 2, 'paid', 4, 12, 'add_user'),
(23, 1, 77, 2, 'paid', 4, 12, 'add_user'),
(24, 1, 78, 2, 'paid', 4, 12, 'add_user'),
(25, 1, 79, 2, 'paid', 4, 12, 'add_user'),
(26, 1, 80, 2, 'paid', 4, 12, 'add_user'),
(27, 2, 71, 1, 'paid', 5, 12, 'purchase'),
(28, 2, 72, 1, 'paid', 5, 12, 'purchase'),
(29, 2, 73, 1, 'paid', 5, 12, 'purchase'),
(30, 2, 76, 1, 'paid', 5, 12, 'purchase'),
(31, 2, 77, 1, 'paid', 5, 12, 'purchase'),
(32, 2, 78, 1, 'paid', 5, 12, 'purchase'),
(33, 2, 79, 1, 'paid', 5, 12, 'purchase'),
(34, 2, 80, 1, 'paid', 5, 12, 'purchase'),
(35, 2, 67, 1, 'paid', 5, 12, 'purchase'),
(36, 2, 75, 1, 'paid', 5, 12, 'purchase'),
(37, 2, 55, 1, 'paid', 5, 12, 'purchase'),
(38, 2, 56, 1, 'paid', 5, 12, 'purchase'),
(39, 2, 74, 1, 'paid', 5, 12, 'purchase'),
(40, 1, 55, 3, 'paid', 7, 12, 'renewal'),
(41, 1, 56, 3, 'paid', 7, 12, 'renewal'),
(42, 1, 67, 3, 'paid', 7, 12, 'renewal'),
(43, 1, 71, 3, 'paid', 7, 12, 'renewal'),
(44, 1, 72, 3, 'paid', 7, 12, 'renewal'),
(45, 1, 73, 3, 'paid', 7, 12, 'renewal'),
(46, 1, 74, 3, 'paid', 7, 12, 'renewal'),
(47, 1, 75, 3, 'paid', 7, 12, 'renewal'),
(48, 1, 76, 3, 'paid', 7, 12, 'renewal'),
(49, 1, 77, 3, 'paid', 7, 12, 'renewal'),
(50, 1, 78, 3, 'paid', 7, 12, 'renewal'),
(51, 1, 79, 3, 'paid', 7, 12, 'renewal'),
(52, 1, 80, 3, 'paid', 7, 12, 'renewal');

-- --------------------------------------------------------

--
-- Table structure for table `i_users_folder`
--

CREATE TABLE `i_users_folder` (
  `iuf_id` int(11) NOT NULL,
  `iuf_folder_name` varchar(200) DEFAULT NULL,
  `iuf_p_folder` int(11) DEFAULT NULL,
  `iuf_owner` int(11) DEFAULT NULL,
  `iuf_created` datetime DEFAULT NULL,
  `iuf_created_by` int(11) DEFAULT NULL,
  `iuf_modify` datetime DEFAULT NULL,
  `iuf_modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_users_folder`
--

INSERT INTO `i_users_folder` (`iuf_id`, `iuf_folder_name`, `iuf_p_folder`, `iuf_owner`, `iuf_created`, `iuf_created_by`, `iuf_modify`, `iuf_modified_by`) VALUES
(10, '1st', 0, 188, '2019-02-01 20:03:56', 188, '2019-02-02 19:59:40', 188),
(11, '2nd folder', 0, 188, '2019-02-01 22:47:18', 188, '2019-02-02 12:26:16', 188),
(24, 'testing subfolder', 9, 188, '2019-02-02 11:00:49', 188, '2019-02-02 11:01:01', 188),
(36, '1.1 folder', 10, 188, '2019-02-02 12:26:39', 188, '2019-02-02 19:59:27', 188),
(37, '1.2 folder', 10, 188, '2019-02-02 12:26:46', 188, '2019-02-02 12:26:51', 188),
(47, '3rd folder', 0, 188, '2019-02-02 19:58:09', 188, '2019-02-02 19:58:12', 188),
(48, 'welcme', 0, 1, '2019-04-19 10:32:38', 1, '2019-04-19 10:32:41', 1),
(49, 'Electrical', 0, 1, '2019-04-26 16:39:14', 1, '2019-04-26 16:39:27', 1),
(50, 'Plumbing', 0, 1, '2019-04-26 16:39:29', 1, '2019-04-26 16:39:33', 1),
(51, 'Wiring', 49, 1, '2019-04-26 16:39:39', 1, '2019-04-26 16:39:44', 1),
(52, 'Ducting', 49, 1, '2019-04-26 16:39:46', 1, '2019-04-26 16:39:49', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_users_folder_files`
--

CREATE TABLE `i_users_folder_files` (
  `iuff_id` int(11) NOT NULL,
  `iuff_folder_id` int(11) DEFAULT NULL,
  `iuff_doc_id` int(11) DEFAULT NULL,
  `iuff_created` datetime DEFAULT NULL,
  `iuff_created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_users_folder_files`
--

INSERT INTO `i_users_folder_files` (`iuff_id`, `iuff_folder_id`, `iuff_doc_id`, `iuff_created`, `iuff_created_by`) VALUES
(30, 0, 18, '2019-02-02 19:17:21', 188),
(31, 0, 19, '2019-02-02 19:21:55', 188),
(42, 36, 20, '2019-02-04 10:42:49', 188),
(43, 48, 136, '2019-04-19 10:40:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `i_users_visit`
--

CREATE TABLE `i_users_visit` (
  `iuv_id` int(11) NOT NULL,
  `iuv_agent` varchar(200) DEFAULT NULL,
  `iuv_mode` varchar(50) DEFAULT NULL,
  `iuv_date` datetime DEFAULT NULL,
  `iuv_remote_add` varchar(100) DEFAULT NULL,
  `iuv_country` varchar(50) DEFAULT NULL,
  `iuv_region` varchar(50) DEFAULT NULL,
  `iuv_city` varchar(50) DEFAULT NULL,
  `iuv_zip` varchar(50) DEFAULT NULL,
  `iuv_lat` varchar(100) DEFAULT NULL,
  `iuv_lon` varchar(100) DEFAULT NULL,
  `iuv_timezone` varchar(100) DEFAULT NULL,
  `iuv_isp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_users_visit`
--

INSERT INTO `i_users_visit` (`iuv_id`, `iuv_agent`, `iuv_mode`, `iuv_date`, `iuv_remote_add`, `iuv_country`, `iuv_region`, `iuv_city`, `iuv_zip`, `iuv_lat`, `iuv_lon`, `iuv_timezone`, `iuv_isp`) VALUES
(8, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0 Safari/605.1.15', 'key', '2018-11-17 17:11:06', '::1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_user_activity`
--

CREATE TABLE `i_user_activity` (
  `iua_id` int(11) NOT NULL,
  `iua_type` varchar(50) DEFAULT NULL,
  `iua_title` varchar(100) DEFAULT NULL,
  `iua_date` datetime DEFAULT NULL,
  `iua_place` varchar(100) DEFAULT NULL,
  `iua_to_do` int(11) DEFAULT NULL,
  `iua_note` varchar(100) DEFAULT NULL,
  `iua_owner` int(11) DEFAULT NULL,
  `iua_created_by` int(11) DEFAULT NULL,
  `iua_created` datetime DEFAULT NULL,
  `iua_status` varchar(10) DEFAULT NULL,
  `iua_categorise` varchar(100) DEFAULT NULL,
  `iua_p_activity` int(11) NOT NULL,
  `iua_modify` datetime DEFAULT NULL,
  `iua_modified_by` int(11) DEFAULT NULL,
  `iua_shortcuts` int(11) DEFAULT NULL,
  `iua_m_shortcuts` int(11) DEFAULT NULL,
  `iua_g_id` int(11) DEFAULT NULL,
  `iua_color` varchar(50) DEFAULT NULL,
  `iua_end_date` datetime DEFAULT NULL,
  `iua_repeat` varchar(100) NOT NULL,
  `iua_reminder` varchar(100) NOT NULL,
  `iua_priority` varchar(100) NOT NULL,
  `iua_repeat_date` date NOT NULL,
  `iua_allot_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_activity`
--

INSERT INTO `i_user_activity` (`iua_id`, `iua_type`, `iua_title`, `iua_date`, `iua_place`, `iua_to_do`, `iua_note`, `iua_owner`, `iua_created_by`, `iua_created`, `iua_status`, `iua_categorise`, `iua_p_activity`, `iua_modify`, `iua_modified_by`, `iua_shortcuts`, `iua_m_shortcuts`, `iua_g_id`, `iua_color`, `iua_end_date`, `iua_repeat`, `iua_reminder`, `iua_priority`, `iua_repeat_date`, `iua_allot_id`) VALUES
(1, 'module', 'Inventory - 1', '2019-06-19 14:27:10', NULL, 0, NULL, 1, 1, '2019-06-19 14:27:10', 'close', 'create', 0, NULL, NULL, 0, 0, 1, NULL, NULL, '', '', '', '0000-00-00', NULL),
(2, 'module', 'Inventory - 1', '2019-06-19 15:10:21', NULL, 0, NULL, 1, 1, '2019-06-19 15:10:21', 'close', 'create', 0, NULL, NULL, 0, 0, 1, NULL, NULL, '', '', '', '0000-00-00', NULL),
(3, 'module', 'Inventory - ', '2019-06-19 15:13:41', NULL, 0, NULL, 1, 1, '2019-06-19 15:13:41', 'close', 'create', 0, NULL, NULL, 0, 0, 1, NULL, NULL, '', '', '', '0000-00-00', NULL),
(4, 'module', 'Inventory - IN/12006/M', '2019-06-20 11:43:40', NULL, 0, NULL, 4, 4, '2019-06-20 11:43:40', 'close', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(5, 'module', 'Inventory - ', '2019-06-20 11:44:00', NULL, 0, NULL, 4, 4, '2019-06-20 11:44:00', 'close', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(6, 'Event', 'Reminder to pay Test vendor', '2019-06-22 11:45:40', 'null', 0, NULL, 4, 4, '2019-06-20 11:46:18', 'pending', 'Payments', 0, NULL, NULL, 0, 0, 4, 'rgba(255, 0, 0, 0.63)', '2019-06-22 11:45:40', 'one_time', 'null', 'null', '0000-00-00', NULL),
(7, 'module', 'Inventory - IN/2012', '2019-06-20 12:10:16', NULL, 0, NULL, 4, 4, '2019-06-20 12:10:16', 'close', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(8, 'module', 'Inventory - 1/OUT/', '2019-06-20 12:28:40', NULL, 0, NULL, 4, 4, '2019-06-20 12:28:40', 'close', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(9, 'module', 'Inventory - 123', '2019-06-20 12:31:40', NULL, 0, NULL, 4, 4, '2019-06-20 12:31:40', 'close', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(10, 'module', 'Orders - 1/OR/', '2019-06-20 12:40:39', NULL, 0, NULL, 4, 4, '2019-06-20 12:40:39', 'pending', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(11, 'module', 'Orders - /OR/2', '2019-06-20 12:40:39', NULL, 0, NULL, 4, 4, '2019-06-20 12:40:39', 'pending', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(12, 'module', 'Orders - /OR/2', '2019-06-20 12:43:24', NULL, 0, NULL, 4, 4, '2019-06-20 12:43:24', 'pending', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL),
(13, 'module', 'Orders - /OR/3', '2019-06-20 12:43:24', NULL, 0, NULL, 4, 4, '2019-06-20 12:43:24', 'pending', 'create', 0, NULL, NULL, 0, 0, 4, NULL, NULL, '', '', '', '0000-00-00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_user_devices`
--

CREATE TABLE `i_user_devices` (
  `iu_d_id` int(11) NOT NULL,
  `iu_d_name` varchar(200) DEFAULT NULL,
  `iu_d_location` varchar(200) DEFAULT NULL,
  `iu_d_serial_number` varchar(200) DEFAULT NULL,
  `iu_d_uid` int(11) DEFAULT NULL,
  `iu_d_owner` int(11) DEFAULT NULL,
  `iu_d_created` datetime DEFAULT NULL,
  `iu_d_created_by` int(11) DEFAULT NULL,
  `iu_d_modify` datetime DEFAULT NULL,
  `iu_d_modified_by` int(11) DEFAULT NULL,
  `iu_d_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_devices`
--

INSERT INTO `i_user_devices` (`iu_d_id`, `iu_d_name`, `iu_d_location`, `iu_d_serial_number`, `iu_d_uid`, `iu_d_owner`, `iu_d_created`, `iu_d_created_by`, `iu_d_modify`, `iu_d_modified_by`, `iu_d_gid`) VALUES
(4, 'Attendance Device', 'Entry door', 'ABC123', 1, 1, '2019-01-19 11:01:35', 1, '2019-01-19 11:01:06', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_user_email_template`
--

CREATE TABLE `i_user_email_template` (
  `iuetemp_id` int(11) NOT NULL,
  `iuetemp_title` varchar(100) DEFAULT NULL,
  `iuetemp_owner` int(11) DEFAULT NULL,
  `iuetemp_file` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_email_template`
--

INSERT INTO `i_user_email_template` (`iuetemp_id`, `iuetemp_title`, `iuetemp_owner`, `iuetemp_file`) VALUES
(45, 'final test', 188, '1549348435.txt'),
(47, 'sample', 188, '1549348462.txt'),
(48, 'email test with attach', 188, '1549966899.txt'),
(52, 'test from letter', 188, '1550840998.txt');

-- --------------------------------------------------------

--
-- Table structure for table `i_user_group`
--

CREATE TABLE `i_user_group` (
  `iug_id` int(11) NOT NULL,
  `iug_name` varchar(100) NOT NULL,
  `iug_created_by` int(11) NOT NULL,
  `iug_created` datetime NOT NULL,
  `iug_modified_by` int(11) NOT NULL,
  `iug_modify` datetime NOT NULL,
  `iug_owner` int(11) NOT NULL,
  `iug_m_group` varchar(30) DEFAULT NULL,
  `iug_company` varchar(100) DEFAULT NULL,
  `iug_address` varchar(300) DEFAULT NULL,
  `iug_gst` varchar(100) DEFAULT NULL,
  `iug_logo` varchar(100) DEFAULT NULL,
  `iug_logo_add` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_group`
--

INSERT INTO `i_user_group` (`iug_id`, `iug_name`, `iug_created_by`, `iug_created`, `iug_modified_by`, `iug_modify`, `iug_owner`, `iug_m_group`, `iug_company`, `iug_address`, `iug_gst`, `iug_logo`, `iug_logo_add`) VALUES
(1, 'Evomata', 1, '2019-06-19 11:41:40', 0, '0000-00-00 00:00:00', 1, NULL, 'Evomata', '18/48 Borivali', '82398', '01560924700.png', '11560924700.jpg'),
(2, 'evomata', 2, '2019-06-19 13:50:20', 0, '0000-00-00 00:00:00', 2, NULL, 'evomata', '18 / 48 Borivali', '798234', '01560932420.jpg', '11560932420.jpg'),
(3, 'evomata', 3, '2019-06-19 14:21:55', 0, '0000-00-00 00:00:00', 3, NULL, 'evomata', '18 / 48 borivali', '654', NULL, NULL),
(4, 'Evomata Innovation (OPC) Pvt Ltd', 4, '2019-06-20 11:30:57', 0, '0000-00-00 00:00:00', 4, NULL, 'Evomata Innovation (OPC) Pvt Ltd', 'Office No 6, Meera Upvan CHSL, Main Kasturba Road, Borivali (East), Mumbai - 400069', '', '01561010457.png', '11561010457.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `i_user_history`
--

CREATE TABLE `i_user_history` (
  `iuh_id` int(11) NOT NULL,
  `iuh_owner` int(11) NOT NULL,
  `iuh_mid` int(11) NOT NULL,
  `iuh_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_history`
--

INSERT INTO `i_user_history` (`iuh_id`, `iuh_owner`, `iuh_mid`, `iuh_date`) VALUES
(1, 188, 38, '2019-01-25 11:01:06'),
(2, 188, 38, '2019-01-25 11:01:09'),
(3, 188, 38, '2019-01-25 11:01:12'),
(4, 188, 36, '2019-01-25 11:01:19'),
(5, 188, 36, '2019-01-25 11:01:22'),
(6, 188, 38, '2019-01-25 11:01:44'),
(7, 188, 38, '2019-01-25 11:01:46'),
(8, 188, 38, '2019-01-25 11:01:50'),
(9, 188, 38, '2019-01-25 11:01:52'),
(10, 188, 38, '2019-01-25 11:01:55'),
(11, 188, 38, '2019-01-25 11:01:57'),
(12, 188, 38, '2019-01-25 11:01:59'),
(13, 188, 38, '2019-01-25 11:01:01'),
(14, 188, 33, '2019-01-25 11:01:09'),
(15, 188, 34, '2019-01-25 11:01:12'),
(16, 188, 35, '2019-01-25 11:01:16'),
(17, 188, 54, '2019-01-25 11:01:19'),
(18, 188, 53, '2019-01-25 11:01:22'),
(19, 188, 52, '2019-01-25 11:01:25'),
(20, 188, 51, '2019-01-25 11:01:28'),
(21, 188, 50, '2019-01-25 11:01:31'),
(22, 188, 49, '2019-01-25 11:01:34'),
(23, 188, 44, '2019-01-25 11:01:38'),
(24, 188, 43, '2019-01-25 11:01:45'),
(25, 188, 42, '2019-01-25 11:01:49'),
(26, 188, 40, '2019-01-25 11:01:59'),
(27, 188, 49, '2019-01-25 11:01:08'),
(28, 188, 33, '2019-01-25 11:01:25'),
(29, 188, 35, '2019-01-25 11:01:29'),
(30, 188, 33, '2019-01-25 11:01:33'),
(31, 188, 33, '2019-01-25 11:01:36'),
(32, 188, 33, '2019-01-25 11:01:38'),
(33, 188, 33, '2019-01-25 11:01:40'),
(34, 188, 33, '2019-01-25 11:01:42'),
(35, 188, 33, '2019-01-25 11:01:44'),
(36, 188, 33, '2019-01-25 11:01:46'),
(37, 188, 33, '2019-01-25 11:01:48'),
(38, 188, 33, '2019-01-25 11:01:50'),
(39, 188, 33, '2019-01-25 11:01:53'),
(40, 188, 38, '2019-01-25 11:01:57'),
(41, 188, 33, '2019-01-25 11:01:00'),
(42, 188, 49, '2019-01-25 11:01:07'),
(43, 188, 38, '2019-01-25 12:01:16'),
(44, 188, 33, '2019-01-25 12:01:20'),
(45, 188, 49, '2019-01-25 12:01:59'),
(46, 188, 49, '2019-01-25 14:01:33'),
(47, 188, 49, '2019-01-25 15:01:45'),
(48, 188, 49, '2019-01-25 15:01:10'),
(49, 188, 49, '2019-01-25 15:01:05'),
(50, 188, 49, '2019-01-25 15:01:41'),
(51, 188, 49, '2019-01-25 15:01:59'),
(52, 188, 49, '2019-01-25 15:01:43'),
(53, 188, 49, '2019-01-25 15:01:05'),
(54, 188, 42, '2019-01-25 16:01:11'),
(55, 188, 53, '2019-01-25 16:01:20'),
(56, 216, 42, '2019-01-25 16:01:57'),
(57, 216, 42, '2019-01-25 16:01:58'),
(58, 216, 42, '2019-01-25 16:01:58'),
(59, 216, 42, '2019-01-25 16:01:58'),
(60, 216, 42, '2019-01-25 16:01:59'),
(61, 216, 42, '2019-01-25 16:01:59'),
(62, 216, 42, '2019-01-25 16:01:59'),
(63, 188, 49, '2019-01-25 17:01:55'),
(64, 188, 49, '2019-01-25 17:01:22'),
(65, 188, 49, '2019-01-25 17:01:29'),
(66, 188, 49, '2019-01-25 19:01:49'),
(67, 188, 49, '2019-01-28 10:01:42'),
(68, 188, 49, '2019-01-28 11:01:40'),
(69, 188, 35, '2019-01-28 12:01:17'),
(70, 188, 36, '2019-01-28 12:01:08'),
(71, 188, 51, '2019-01-28 14:01:29'),
(72, 188, 53, '2019-01-28 15:01:34'),
(73, 188, 49, '2019-01-28 15:01:44'),
(74, 188, 51, '2019-01-28 16:01:30'),
(75, 188, 49, '2019-01-28 16:01:52'),
(76, 188, 49, '2019-01-28 16:01:37'),
(77, 188, 51, '2019-01-28 16:01:23'),
(78, 188, 51, '2019-01-28 16:01:59'),
(79, 188, 49, '2019-01-28 17:01:42'),
(80, 188, 51, '2019-01-28 17:01:25'),
(81, 188, 51, '2019-01-28 17:01:50'),
(82, 188, 36, '2019-01-28 17:01:10'),
(83, 188, 49, '2019-01-28 18:01:19'),
(84, 188, 36, '2019-01-28 18:01:32'),
(85, 188, 49, '2019-01-28 18:01:36'),
(86, 188, 36, '2019-01-28 19:01:56'),
(87, 188, 49, '2019-01-28 19:01:06'),
(88, 188, 34, '2019-01-29 10:01:44'),
(89, 188, 49, '2019-01-29 10:01:02'),
(90, 188, 36, '2019-01-29 10:01:48'),
(91, 188, 36, '2019-01-29 15:01:37'),
(92, 188, 36, '2019-01-29 16:01:13'),
(93, 188, 54, '2019-01-29 16:01:01'),
(94, 188, 33, '2019-01-29 16:01:29'),
(95, 188, 36, '2019-01-29 16:01:46'),
(96, 188, 36, '2019-01-29 17:01:30'),
(97, 188, 49, '2019-01-30 13:01:21'),
(98, 188, 35, '2019-01-30 15:01:09'),
(99, 188, 36, '2019-01-30 16:01:40'),
(100, 188, 42, '2019-01-30 16:01:06'),
(101, 188, 51, '2019-01-30 16:01:16'),
(102, 188, 34, '2019-01-30 16:01:44'),
(103, 188, 51, '2019-01-30 16:01:01'),
(104, 188, 34, '2019-01-30 16:01:18'),
(105, 188, 51, '2019-01-30 16:01:39'),
(106, 188, 42, '2019-01-30 16:01:17'),
(107, 188, 35, '2019-01-30 16:01:24'),
(108, 188, 34, '2019-01-30 16:01:04'),
(109, 188, 42, '2019-01-30 16:01:15'),
(110, 188, 51, '2019-01-30 16:01:42'),
(111, 188, 34, '2019-01-30 16:01:06'),
(112, 188, 34, '2019-01-30 16:01:38'),
(113, 188, 34, '2019-01-30 17:01:50'),
(114, 188, 36, '2019-01-30 17:01:57'),
(115, 188, 35, '2019-01-30 17:01:02'),
(116, 188, 40, '2019-01-30 17:01:38'),
(117, 188, 43, '2019-01-30 18:01:21'),
(118, 188, 38, '2019-01-30 18:01:53'),
(119, 188, 54, '2019-01-30 18:01:48'),
(120, 188, 53, '2019-01-30 18:01:14'),
(121, 188, 51, '2019-01-31 12:01:07'),
(122, 188, 54, '2019-01-31 14:01:07'),
(123, 188, 54, '2019-01-31 14:01:44'),
(124, 188, 49, '2019-01-31 14:01:39'),
(125, 188, 49, '2019-01-31 14:01:51'),
(126, 188, 49, '2019-01-31 14:01:02'),
(127, 188, 49, '2019-01-31 14:01:00'),
(128, 188, 38, '2019-01-31 15:01:06'),
(129, 188, 38, '2019-01-31 15:01:26'),
(130, 188, 38, '2019-01-31 15:01:59'),
(131, 188, 35, '2019-01-31 17:01:53'),
(132, 188, 35, '2019-01-31 17:01:25'),
(133, 188, 51, '2019-02-01 10:02:25'),
(134, 188, 35, '2019-02-01 10:02:28'),
(135, 188, 35, '2019-02-01 10:02:31'),
(136, 188, 35, '2019-02-01 10:02:33'),
(137, 188, 35, '2019-02-01 10:02:35'),
(138, 188, 35, '2019-02-01 10:02:37'),
(139, 188, 38, '2019-02-01 11:02:56'),
(140, 188, 49, '2019-02-01 11:02:14'),
(141, 188, 49, '2019-02-01 11:02:24'),
(142, 188, 49, '2019-02-01 14:02:36'),
(143, 188, 49, '2019-02-01 15:02:49'),
(144, 188, 49, '2019-02-01 15:02:09'),
(145, 188, 49, '2019-02-01 15:02:31'),
(146, 188, 36, '2019-02-01 15:02:15'),
(147, 188, 49, '2019-02-01 15:02:49'),
(148, 188, 49, '2019-02-01 15:02:33'),
(149, 188, 49, '2019-02-01 16:25:27'),
(150, 188, 42, '2019-02-01 16:27:13'),
(151, 188, 54, '2019-02-01 16:32:18'),
(152, 188, 49, '2019-02-01 16:56:37'),
(153, 188, 49, '2019-02-01 16:56:47'),
(154, 188, 49, '2019-02-01 16:58:04'),
(155, 188, 36, '2019-02-01 16:59:16'),
(156, 188, 36, '2019-02-01 16:59:42'),
(157, 188, 51, '2019-02-01 17:00:03'),
(158, 188, 54, '2019-02-01 17:00:36'),
(159, 188, 49, '2019-02-01 18:08:40'),
(160, 188, 49, '2019-02-01 22:54:49'),
(161, 188, 49, '2019-02-02 12:53:39'),
(162, 188, 49, '2019-02-02 17:17:50'),
(163, 188, 49, '2019-02-02 17:48:25'),
(164, 188, 49, '2019-02-02 17:49:36'),
(165, 188, 49, '2019-02-02 18:38:10'),
(166, 188, 49, '2019-02-02 19:16:04'),
(167, 188, 49, '2019-02-02 19:36:10'),
(168, 188, 49, '2019-02-04 12:01:37'),
(169, 188, 38, '2019-02-04 12:02:20'),
(170, 188, 38, '2019-02-04 12:05:52'),
(171, 188, 49, '2019-02-04 12:27:08'),
(172, 188, 49, '2019-02-04 12:27:22'),
(173, 188, 49, '2019-02-04 12:29:27'),
(174, 188, 33, '2019-02-04 12:55:14'),
(175, 188, 33, '2019-02-04 12:59:57'),
(176, 188, 33, '2019-02-04 13:10:22'),
(177, 188, 33, '2019-02-04 13:12:11'),
(178, 188, 33, '2019-02-04 13:15:26'),
(179, 188, 36, '2019-02-04 13:17:07'),
(180, 188, 36, '2019-02-04 13:23:11'),
(181, 188, 50, '2019-02-04 13:23:41'),
(182, 188, 36, '2019-02-04 13:41:56'),
(183, 188, 50, '2019-02-04 13:45:23'),
(184, 188, 36, '2019-02-04 13:50:29'),
(185, 188, 36, '2019-02-04 13:54:36'),
(186, 188, 36, '2019-02-04 13:57:08'),
(187, 188, 36, '2019-02-04 14:01:11'),
(188, 188, 35, '2019-02-04 14:46:05'),
(189, 188, 35, '2019-02-04 14:46:27'),
(190, 188, 34, '2019-02-04 14:48:15'),
(191, 188, 40, '2019-02-04 14:59:08'),
(192, 188, 43, '2019-02-04 15:04:02'),
(193, 188, 54, '2019-02-04 15:11:15'),
(194, 188, 54, '2019-02-04 15:24:31'),
(195, 188, 54, '2019-02-04 15:28:18'),
(196, 188, 53, '2019-02-04 15:31:34'),
(197, 188, 53, '2019-02-04 15:36:20'),
(198, 188, 52, '2019-02-04 15:36:44'),
(199, 188, 44, '2019-02-04 15:37:01'),
(200, 188, 51, '2019-02-04 15:37:30'),
(201, 188, 50, '2019-02-04 15:42:03'),
(202, 188, 50, '2019-02-04 15:46:56'),
(203, 188, 50, '2019-02-04 16:14:51'),
(204, 188, 50, '2019-02-04 17:56:54'),
(205, 188, 50, '2019-02-04 18:33:02'),
(206, 188, 50, '2019-02-05 09:23:54'),
(207, 188, 50, '2019-02-05 11:49:26'),
(208, 188, 50, '2019-02-05 12:04:40'),
(209, 188, 33, '2019-02-05 12:59:03'),
(210, 188, 50, '2019-02-05 12:59:58'),
(211, 188, 50, '2019-02-05 13:00:36'),
(212, 188, 50, '2019-02-05 14:12:20'),
(213, 188, 49, '2019-02-05 15:29:30'),
(214, 188, 49, '2019-02-05 15:29:49'),
(215, 188, 49, '2019-02-05 15:30:19'),
(216, 188, 49, '2019-02-05 16:58:38'),
(217, 188, 49, '2019-02-05 17:04:50'),
(218, 188, 49, '2019-02-05 17:24:00'),
(219, 188, 33, '2019-02-05 18:17:37'),
(220, 188, 49, '2019-02-05 18:40:28'),
(221, 188, 33, '2019-02-05 19:04:29'),
(222, 188, 49, '2019-02-06 09:29:58'),
(223, 188, 33, '2019-02-06 09:40:54'),
(224, 188, 49, '2019-02-06 09:42:41'),
(225, 188, 49, '2019-02-06 09:42:53'),
(226, 188, 49, '2019-02-06 09:57:55'),
(227, 188, 33, '2019-02-06 09:58:41'),
(228, 188, 33, '2019-02-06 09:58:50'),
(229, 188, 49, '2019-02-06 09:59:07'),
(230, 188, 49, '2019-02-06 09:59:13'),
(231, 188, 49, '2019-02-06 10:05:58'),
(232, 188, 49, '2019-02-06 10:06:16'),
(233, 188, 49, '2019-02-06 10:16:41'),
(234, 188, 49, '2019-02-06 10:48:11'),
(235, 188, 49, '2019-02-06 11:06:45'),
(236, 188, 49, '2019-02-06 11:07:44'),
(237, 188, 49, '2019-02-06 11:48:12'),
(238, 188, 49, '2019-02-06 12:32:34'),
(239, 188, 49, '2019-02-06 13:31:15'),
(240, 188, 33, '2019-02-06 13:38:29'),
(241, 188, 49, '2019-02-07 11:10:07'),
(242, 188, 49, '2019-02-07 11:33:25'),
(243, 188, 49, '2019-02-07 11:33:31'),
(244, 188, 49, '2019-02-07 11:33:34'),
(245, 188, 49, '2019-02-07 14:32:52'),
(246, 188, 49, '2019-02-07 14:33:03'),
(247, 188, 49, '2019-02-07 15:11:11'),
(248, 188, 49, '2019-02-07 15:12:05'),
(249, 188, 49, '2019-02-07 15:13:14'),
(250, 188, 33, '2019-02-07 18:00:19'),
(251, 188, 33, '2019-02-07 18:15:47'),
(252, 188, 49, '2019-02-08 09:43:11'),
(253, 188, 36, '2019-02-08 11:12:02'),
(254, 188, 35, '2019-02-08 11:12:14'),
(255, 188, 36, '2019-02-08 15:43:54'),
(256, 188, 42, '2019-02-08 15:45:07'),
(257, 188, 36, '2019-02-08 16:32:28'),
(258, 188, 36, '2019-02-08 16:37:05'),
(259, 188, 35, '2019-02-08 19:02:45'),
(260, 188, 38, '2019-02-09 09:40:44'),
(261, 188, 35, '2019-02-09 09:43:07'),
(262, 188, 51, '2019-02-09 10:21:49'),
(263, 188, 35, '2019-02-09 10:30:46'),
(264, 188, 51, '2019-02-09 10:32:36'),
(265, 188, 49, '2019-02-09 11:47:36'),
(266, 188, 36, '2019-02-09 11:47:39'),
(267, 188, 35, '2019-02-09 11:47:44'),
(268, 188, 36, '2019-02-09 11:48:30'),
(269, 188, 35, '2019-02-09 11:48:35'),
(270, 188, 51, '2019-02-09 11:48:39'),
(271, 188, 33, '2019-02-09 11:49:26'),
(272, 188, 33, '2019-02-09 11:54:41'),
(273, 188, 36, '2019-02-09 11:54:44'),
(274, 188, 35, '2019-02-09 11:54:47'),
(275, 188, 51, '2019-02-09 11:54:49'),
(276, 188, 42, '2019-02-09 11:54:51'),
(277, 188, 36, '2019-02-09 11:55:53'),
(278, 188, 35, '2019-02-09 11:56:56'),
(279, 188, 51, '2019-02-09 11:58:57'),
(280, 188, 33, '2019-02-09 12:00:23'),
(281, 188, 51, '2019-02-09 12:06:51'),
(282, 188, 34, '2019-02-09 12:11:47'),
(283, 188, 33, '2019-02-09 12:17:35'),
(284, 188, 36, '2019-02-09 12:17:47'),
(285, 188, 35, '2019-02-09 12:19:13'),
(286, 188, 51, '2019-02-09 12:20:00'),
(287, 188, 34, '2019-02-09 12:21:46'),
(288, 188, 51, '2019-02-09 12:41:45'),
(289, 188, 49, '2019-02-09 14:18:42'),
(290, 188, 49, '2019-02-09 14:18:55'),
(291, 188, 49, '2019-02-09 14:20:04'),
(292, 188, 49, '2019-02-09 14:53:56'),
(293, 188, 49, '2019-02-09 14:54:57'),
(294, 188, 49, '2019-02-09 14:55:31'),
(295, 231, 49, '2019-02-09 15:01:16'),
(296, 188, 49, '2019-02-09 15:07:38'),
(297, 188, 49, '2019-02-09 15:07:55'),
(298, 188, 49, '2019-02-09 15:09:31'),
(299, 188, 49, '2019-02-09 15:23:51'),
(300, 188, 49, '2019-02-09 15:37:18'),
(301, 188, 49, '2019-02-09 15:37:33'),
(302, 188, 35, '2019-02-09 15:46:19'),
(303, 188, 33, '2019-02-09 15:47:57'),
(304, 188, 35, '2019-02-09 15:48:56'),
(305, 188, 49, '2019-02-09 15:50:26'),
(306, 188, 49, '2019-02-09 15:50:42'),
(307, 188, 49, '2019-02-09 15:50:48'),
(308, 188, 49, '2019-02-09 15:51:26'),
(309, 188, 49, '2019-02-09 18:29:42'),
(310, 188, 49, '2019-02-09 18:36:53'),
(311, 188, 49, '2019-02-09 18:38:18'),
(312, 188, 49, '2019-02-09 19:16:14'),
(313, 188, 49, '2019-02-09 19:24:48'),
(314, 188, 49, '2019-02-09 19:43:29'),
(315, 188, 49, '2019-02-09 19:45:03'),
(316, 188, 49, '2019-02-09 19:55:33'),
(317, 188, 49, '2019-02-09 20:01:05'),
(318, 188, 49, '2019-02-09 20:10:14'),
(319, 188, 49, '2019-02-09 20:12:28'),
(320, 188, 49, '2019-02-09 20:16:00'),
(321, 188, 49, '2019-02-09 20:18:52'),
(322, 188, 49, '2019-02-09 20:19:19'),
(323, 188, 49, '2019-02-11 10:31:32'),
(324, 188, 35, '2019-02-11 10:41:12'),
(325, 188, 49, '2019-02-11 10:41:55'),
(326, 188, 49, '2019-02-11 11:02:19'),
(327, 188, 49, '2019-02-11 13:39:26'),
(328, 188, 49, '2019-02-11 13:39:37'),
(329, 188, 50, '2019-02-11 15:59:36'),
(330, 188, 50, '2019-02-11 16:23:35'),
(331, 188, 49, '2019-02-11 16:31:47'),
(332, 188, 49, '2019-02-11 16:42:46'),
(333, 188, 49, '2019-02-11 16:42:53'),
(334, 188, 49, '2019-02-12 10:31:42'),
(335, 188, 49, '2019-02-12 10:31:50'),
(336, 188, 49, '2019-02-12 10:32:09'),
(337, 188, 38, '2019-02-12 10:43:18'),
(338, 188, 36, '2019-02-12 10:49:46'),
(339, 188, 36, '2019-02-12 11:29:15'),
(340, 188, 36, '2019-02-12 12:09:09'),
(341, 188, 36, '2019-02-12 12:11:39'),
(342, 188, 36, '2019-02-12 12:13:09'),
(343, 188, 36, '2019-02-12 12:13:21'),
(344, 188, 35, '2019-02-12 12:19:48'),
(345, 188, 35, '2019-02-12 12:20:34'),
(346, 188, 35, '2019-02-12 12:20:56'),
(347, 188, 42, '2019-02-12 12:23:15'),
(348, 188, 35, '2019-02-12 12:55:21'),
(349, 188, 42, '2019-02-12 12:56:17'),
(350, 188, 42, '2019-02-12 13:30:09'),
(351, 188, 35, '2019-02-12 13:30:18'),
(352, 188, 40, '2019-02-12 13:41:45'),
(353, 188, 50, '2019-02-12 13:59:59'),
(354, 188, 33, '2019-02-12 14:01:17'),
(355, 188, 50, '2019-02-12 14:04:22'),
(356, 188, 33, '2019-02-12 14:15:30'),
(357, 188, 49, '2019-02-12 14:55:59'),
(358, 188, 49, '2019-02-12 15:22:54'),
(359, 188, 33, '2019-02-12 15:24:18'),
(360, 188, 50, '2019-02-12 15:33:07'),
(361, 188, 50, '2019-02-12 15:50:38'),
(362, 188, 36, '2019-02-12 15:55:56'),
(363, 188, 51, '2019-02-12 15:57:52'),
(364, 188, 51, '2019-02-12 16:10:57'),
(365, 188, 51, '2019-02-12 16:46:18'),
(366, 188, 51, '2019-02-12 16:46:47'),
(367, 188, 35, '2019-02-13 10:34:16'),
(368, 188, 51, '2019-02-13 10:34:38'),
(369, 188, 50, '2019-02-13 10:36:39'),
(370, 188, 50, '2019-02-13 11:34:19'),
(371, 188, 50, '2019-02-13 11:34:47'),
(372, 188, 33, '2019-02-13 11:40:56'),
(373, 188, 50, '2019-02-13 11:42:03'),
(374, 188, 33, '2019-02-13 11:42:18'),
(375, 188, 49, '2019-02-13 12:16:07'),
(376, 188, 49, '2019-02-13 12:17:38'),
(377, 188, 51, '2019-02-13 12:32:10'),
(378, 188, 50, '2019-02-13 12:37:32'),
(379, 188, 36, '2019-02-13 12:40:46'),
(380, 188, 49, '2019-02-13 12:41:44'),
(381, 188, 54, '2019-02-13 12:42:10'),
(382, 188, 54, '2019-02-13 12:44:34'),
(383, 188, 42, '2019-02-13 12:55:36'),
(384, 188, 50, '2019-02-13 13:12:08'),
(385, 188, 50, '2019-02-13 13:21:14'),
(386, 188, 51, '2019-02-13 16:03:44'),
(387, 188, 49, '2019-02-14 11:26:14'),
(388, 188, 49, '2019-02-14 11:28:45'),
(389, 188, 50, '2019-02-14 12:45:56'),
(390, 188, 50, '2019-02-14 13:36:13'),
(391, 188, 50, '2019-02-14 14:05:21'),
(392, 188, 36, '2019-02-16 15:37:33'),
(393, 188, 54, '2019-02-16 16:18:27'),
(394, 188, 42, '2019-02-16 16:19:14'),
(395, 188, 54, '2019-02-16 16:37:21'),
(396, 188, 49, '2019-02-18 13:48:38'),
(397, 188, 49, '2019-02-18 13:54:11'),
(398, 188, 50, '2019-02-18 19:08:08'),
(399, 188, 36, '2019-02-19 19:03:43'),
(400, 188, 49, '2019-02-20 13:29:17'),
(401, 188, 49, '2019-02-20 14:03:31'),
(402, 188, 49, '2019-02-20 14:57:31'),
(403, 188, 49, '2019-02-20 15:01:41'),
(404, 188, 49, '2019-02-20 15:06:30'),
(405, 188, 42, '2019-02-20 16:25:39'),
(406, 188, 49, '2019-02-20 18:12:31'),
(407, 188, 36, '2019-02-20 18:15:21'),
(408, 188, 50, '2019-02-20 19:23:20'),
(409, 188, 50, '2019-02-20 19:26:24'),
(410, 188, 50, '2019-02-20 19:55:25'),
(411, 188, 49, '2019-02-20 20:05:36'),
(412, 188, 35, '2019-02-20 20:06:03'),
(413, 188, 49, '2019-02-21 10:21:30'),
(414, 188, 49, '2019-02-21 10:23:10'),
(415, 188, 51, '2019-02-21 10:23:49'),
(416, 188, 49, '2019-02-21 10:24:20'),
(417, 188, 51, '2019-02-21 10:26:09'),
(418, 188, 33, '2019-02-21 10:28:26'),
(419, 188, 36, '2019-02-21 10:28:28'),
(420, 188, 38, '2019-02-21 10:28:33'),
(421, 188, 38, '2019-02-21 10:29:29'),
(422, 188, 33, '2019-02-21 10:29:54'),
(423, 188, 36, '2019-02-21 10:31:49'),
(424, 188, 36, '2019-02-21 10:51:33'),
(425, 188, 36, '2019-02-21 10:59:24'),
(426, 188, 36, '2019-02-21 11:00:08'),
(427, 188, 51, '2019-02-21 11:00:27'),
(428, 188, 35, '2019-02-21 11:02:21'),
(429, 188, 42, '2019-02-21 11:05:08'),
(430, 188, 34, '2019-02-21 11:06:51'),
(431, 188, 34, '2019-02-21 11:10:10'),
(432, 188, 54, '2019-02-21 11:10:37'),
(433, 188, 53, '2019-02-21 11:11:42'),
(434, 188, 40, '2019-02-21 11:13:19'),
(435, 188, 43, '2019-02-21 11:15:18'),
(436, 188, 50, '2019-02-21 11:16:54'),
(437, 188, 54, '2019-02-21 11:21:33'),
(438, 188, 36, '2019-02-21 12:29:03'),
(439, 188, 55, '2019-02-21 12:45:37'),
(440, 188, 55, '2019-02-21 12:46:06'),
(441, 188, 55, '2019-02-21 12:46:53'),
(442, 188, 55, '2019-02-21 12:47:22'),
(443, 188, 55, '2019-02-21 14:46:19'),
(444, 188, 55, '2019-02-21 15:32:27'),
(445, 188, 50, '2019-02-21 15:42:13'),
(446, 188, 51, '2019-02-21 16:03:59'),
(447, 188, 50, '2019-02-21 16:04:15'),
(448, 188, 51, '2019-02-21 16:04:34'),
(449, 188, 55, '2019-02-21 16:09:42'),
(450, 188, 53, '2019-02-21 16:41:11'),
(451, 188, 55, '2019-02-21 16:45:14'),
(452, 188, 49, '2019-02-22 12:04:01'),
(453, 188, 53, '2019-02-22 12:04:12'),
(454, 188, 56, '2019-02-22 12:26:47'),
(455, 188, 55, '2019-02-22 13:19:02'),
(456, 188, 55, '2019-02-22 13:24:56'),
(457, 188, 53, '2019-02-22 13:25:07'),
(458, 188, 55, '2019-02-22 13:26:22'),
(459, 188, 56, '2019-02-22 13:27:06'),
(460, 188, 51, '2019-02-22 13:43:41'),
(461, 188, 56, '2019-02-22 14:47:46'),
(462, 188, 57, '2019-02-22 14:59:37'),
(463, 188, 57, '2019-02-22 17:09:48'),
(464, 188, 33, '2019-02-22 17:31:22'),
(465, 188, 57, '2019-02-22 17:37:17'),
(466, 188, 57, '2019-02-22 17:39:42'),
(467, 188, 33, '2019-02-22 18:47:41'),
(468, 188, 57, '2019-02-22 18:48:51'),
(469, 188, 56, '2019-02-23 11:08:09'),
(470, 188, 56, '2019-02-25 10:15:14'),
(471, 188, 57, '2019-02-25 12:10:57'),
(472, 188, 33, '2019-02-25 12:37:44'),
(473, 188, 49, '2019-02-27 18:37:51'),
(474, 188, 49, '2019-02-28 12:53:24'),
(475, 188, 49, '2019-02-28 12:53:30'),
(476, 1, 33, '2019-02-28 14:10:04'),
(477, 1, 50, '2019-03-02 12:57:29'),
(478, 1, 50, '2019-03-02 12:59:11'),
(479, 1, 50, '2019-03-02 13:08:13'),
(480, 1, 51, '2019-03-02 15:43:45'),
(481, 1, 33, '2019-03-02 16:07:09'),
(482, 1, 33, '2019-03-02 16:50:31'),
(483, 1, 33, '2019-03-04 12:26:43'),
(484, 1, 33, '2019-03-04 13:05:24'),
(485, 1, 49, '2019-03-04 14:35:11'),
(486, 1, 49, '2019-03-04 14:40:43'),
(487, 1, 33, '2019-03-04 14:48:35'),
(488, 1, 49, '2019-03-04 14:53:19'),
(489, 1, 49, '2019-03-04 14:55:59'),
(490, 1, 49, '2019-03-04 15:20:01'),
(491, 1, 49, '2019-03-04 15:29:48'),
(492, 1, 49, '2019-03-04 15:31:25'),
(493, 1, 49, '2019-03-04 16:26:33'),
(494, 1, 49, '2019-03-04 16:51:46'),
(495, 1, 58, '2019-03-04 18:12:59'),
(496, 1, 58, '2019-03-04 18:14:14'),
(497, 1, 58, '2019-03-04 18:15:33'),
(498, 1, 34, '2019-03-05 10:34:05'),
(499, 1, 58, '2019-03-05 12:02:34'),
(500, 1, 35, '2019-03-05 16:32:11'),
(501, 1, 58, '2019-03-05 16:35:38'),
(502, 1, 59, '2019-03-06 12:22:50'),
(503, 1, 58, '2019-03-06 12:34:40'),
(504, 1, 59, '2019-03-06 14:27:58'),
(505, 1, 58, '2019-03-06 14:29:35'),
(506, 1, 59, '2019-03-06 14:29:53'),
(507, 1, 59, '2019-03-06 14:31:31'),
(508, 1, 59, '2019-03-06 14:31:47'),
(509, 1, 59, '2019-03-06 15:29:25'),
(510, 1, 57, '2019-03-06 16:43:02'),
(511, 1, 58, '2019-03-06 16:43:05'),
(512, 1, 50, '2019-03-06 16:43:12'),
(513, 1, 59, '2019-03-06 16:47:54'),
(514, 1, 50, '2019-03-06 17:15:39'),
(515, 1, 49, '2019-03-07 13:04:41'),
(516, 1, 49, '2019-03-07 13:04:51'),
(517, 1, 50, '2019-03-07 13:08:31'),
(518, 1, 49, '2019-03-07 13:11:33'),
(519, 1, 58, '2019-03-07 13:55:22'),
(520, 1, 35, '2019-03-07 13:56:55'),
(521, 1, 50, '2019-03-07 13:56:58'),
(522, 1, 59, '2019-03-07 18:08:31'),
(523, 1, 49, '2019-03-07 18:08:49'),
(524, 1, 59, '2019-03-07 18:08:55'),
(525, 1, 50, '2019-03-08 12:41:19'),
(526, 1, 50, '2019-03-08 12:59:18'),
(527, 1, 50, '2019-03-08 13:34:16'),
(528, 1, 50, '2019-03-08 13:53:49'),
(529, 1, 50, '2019-03-08 14:12:34'),
(530, 1, 50, '2019-03-08 14:20:25'),
(531, 1, 50, '2019-03-08 14:51:10'),
(532, 1, 58, '2019-03-08 14:53:57'),
(533, 1, 58, '2019-03-08 15:28:09'),
(534, 1, 58, '2019-03-08 15:31:45'),
(535, 1, 58, '2019-03-08 15:33:53'),
(536, 1, 58, '2019-03-08 16:04:05'),
(537, 1, 49, '2019-03-08 16:24:09'),
(538, 1, 49, '2019-03-08 16:28:09'),
(539, 1, 49, '2019-03-08 16:28:30'),
(540, 1, 49, '2019-03-08 16:35:55'),
(541, 1, 49, '2019-03-08 16:36:11'),
(542, 1, 49, '2019-03-08 16:37:12'),
(543, 1, 49, '2019-03-08 16:37:53'),
(544, 1, 50, '2019-03-08 17:10:15'),
(545, 1, 56, '2019-03-08 17:17:22'),
(546, 1, 36, '2019-03-08 17:21:14'),
(547, 1, 50, '2019-03-08 17:39:25'),
(548, 1, 50, '2019-03-08 17:40:26'),
(549, 1, 50, '2019-03-08 17:43:28'),
(550, 1, 49, '2019-03-08 17:44:10'),
(551, 1, 50, '2019-03-08 17:44:14'),
(552, 1, 49, '2019-03-08 17:44:32'),
(553, 1, 49, '2019-03-08 17:45:01'),
(554, 1, 49, '2019-03-08 17:45:17'),
(555, 1, 49, '2019-03-08 17:45:59'),
(556, 1, 49, '2019-03-08 17:46:26'),
(557, 1, 36, '2019-03-08 18:13:14'),
(558, 1, 36, '2019-03-09 09:00:51'),
(559, 1, 56, '2019-03-09 09:04:26'),
(560, 1, 49, '2019-03-09 09:52:14'),
(561, 1, 60, '2019-03-09 09:59:57'),
(562, 1, 56, '2019-03-09 10:06:51'),
(563, 1, 60, '2019-03-09 10:07:12'),
(564, 1, 60, '2019-03-09 10:10:24'),
(565, 1, 58, '2019-03-11 12:48:54'),
(566, 1, 60, '2019-03-11 13:02:01'),
(567, 1, 60, '2019-03-11 14:28:51'),
(568, 1, 38, '2019-03-11 15:19:40'),
(569, 1, 33, '2019-03-11 15:21:17'),
(570, 1, 38, '2019-03-11 15:21:21'),
(571, 1, 36, '2019-03-11 15:23:37'),
(572, 1, 60, '2019-03-11 18:33:20'),
(573, 1, 60, '2019-03-12 13:42:21'),
(574, 1, 60, '2019-03-12 13:51:49'),
(575, 1, 60, '2019-03-12 14:42:40'),
(576, 1, 60, '2019-03-12 14:58:31'),
(577, 1, 60, '2019-03-12 15:01:28'),
(578, 1, 60, '2019-03-12 15:12:59'),
(579, 1, 60, '2019-03-12 15:44:05'),
(580, 1, 60, '2019-03-12 15:54:33'),
(581, 1, 60, '2019-03-12 16:30:57'),
(582, 1, 60, '2019-03-12 16:31:37'),
(583, 1, 33, '2019-03-12 16:40:25'),
(584, 1, 60, '2019-03-12 16:41:01'),
(585, 1, 61, '2019-03-12 16:46:01'),
(586, 1, 59, '2019-03-12 16:47:23'),
(587, 1, 61, '2019-03-12 16:48:52'),
(588, 1, 61, '2019-03-12 17:23:19'),
(589, 1, 60, '2019-03-12 17:47:48'),
(590, 1, 61, '2019-03-12 17:50:04'),
(591, 1, 59, '2019-03-12 17:50:17'),
(592, 1, 61, '2019-03-12 17:50:22'),
(593, 1, 61, '2019-03-13 11:45:29'),
(594, 1, 61, '2019-03-13 11:47:18'),
(595, 1, 61, '2019-03-13 11:54:38'),
(596, 1, 61, '2019-03-13 11:57:43'),
(597, 1, 61, '2019-03-13 12:06:57'),
(598, 1, 61, '2019-03-13 12:07:14'),
(599, 1, 61, '2019-03-13 12:09:18'),
(600, 1, 61, '2019-03-13 12:10:00'),
(601, 1, 61, '2019-03-13 12:16:00'),
(602, 1, 60, '2019-03-13 13:24:22'),
(603, 1, 61, '2019-03-13 13:32:04'),
(604, 1, 60, '2019-03-13 13:45:25'),
(605, 1, 61, '2019-03-13 13:46:34'),
(606, 1, 60, '2019-03-13 13:47:15'),
(607, 1, 61, '2019-03-13 13:47:21'),
(608, 1, 51, '2019-03-13 14:28:31'),
(609, 1, 33, '2019-03-13 14:32:00'),
(610, 1, 61, '2019-03-13 14:32:30'),
(611, 1, 62, '2019-03-13 15:20:10'),
(612, 1, 33, '2019-03-13 15:21:05'),
(613, 1, 62, '2019-03-13 15:21:09'),
(614, 1, 62, '2019-03-13 15:37:29'),
(615, 1, 62, '2019-03-13 15:40:10'),
(616, 1, 62, '2019-03-13 15:56:18'),
(617, 1, 62, '2019-03-13 16:06:00'),
(618, 1, 62, '2019-03-13 16:08:56'),
(619, 1, 62, '2019-03-13 16:18:22'),
(620, 1, 62, '2019-03-13 16:25:04'),
(621, 1, 62, '2019-03-13 16:41:26'),
(622, 1, 62, '2019-03-13 17:58:58'),
(623, 1, 62, '2019-03-13 18:23:40'),
(624, 1, 62, '2019-03-13 18:29:40'),
(625, 1, 62, '2019-03-13 18:29:41'),
(626, 1, 62, '2019-03-13 18:29:42'),
(627, 1, 62, '2019-03-13 18:29:42'),
(628, 1, 62, '2019-03-13 18:29:59'),
(629, 1, 62, '2019-03-13 18:30:00'),
(630, 1, 62, '2019-03-13 18:30:00'),
(631, 1, 62, '2019-03-13 18:30:02'),
(632, 1, 62, '2019-03-13 18:30:14'),
(633, 1, 62, '2019-03-13 18:51:38'),
(634, 1, 61, '2019-03-13 19:03:55'),
(635, 1, 62, '2019-03-13 19:03:58'),
(636, 1, 61, '2019-03-14 11:14:07'),
(637, 1, 60, '2019-03-14 11:14:22'),
(638, 1, 61, '2019-03-14 11:15:44'),
(639, 1, 59, '2019-03-14 11:21:32'),
(640, 1, 58, '2019-03-14 11:28:27'),
(641, 1, 52, '2019-03-14 12:35:54'),
(642, 1, 52, '2019-03-14 13:38:03'),
(643, 1, 33, '2019-03-14 16:28:09'),
(644, 1, 59, '2019-03-14 18:54:14'),
(645, 1, 52, '2019-03-14 18:54:35'),
(646, 1, 52, '2019-03-14 21:59:21'),
(647, 1, 49, '2019-03-14 22:10:34'),
(648, 1, 52, '2019-03-14 23:04:32'),
(649, 1, 50, '2019-03-14 23:07:55'),
(650, 1, 59, '2019-03-14 23:09:07'),
(651, 1, 60, '2019-03-14 23:09:52'),
(652, 1, 61, '2019-03-14 23:10:23'),
(653, 1, 52, '2019-03-15 09:37:04'),
(654, 1, 33, '2019-03-15 17:28:41'),
(655, 1, 52, '2019-03-15 17:29:22'),
(656, 1, 52, '2019-03-16 09:21:26'),
(657, 1, 33, '2019-03-16 09:41:32'),
(658, 1, 33, '2019-03-16 09:42:38'),
(659, 1, 52, '2019-03-16 09:59:18'),
(660, 1, 52, '2019-03-16 13:43:50'),
(661, 1, 52, '2019-03-16 22:30:32'),
(662, 1, 52, '2019-03-18 10:32:42'),
(663, 1, 33, '2019-03-18 11:02:46'),
(664, 1, 52, '2019-03-18 11:03:46'),
(665, 1, 53, '2019-03-18 15:23:28'),
(666, 1, 52, '2019-03-18 15:23:31'),
(667, 1, 52, '2019-03-18 16:35:30'),
(668, 1, 36, '2019-03-19 12:08:52'),
(669, 1, 33, '2019-03-19 13:06:34'),
(670, 1, 33, '2019-03-19 13:09:52'),
(671, 1, 50, '2019-03-19 13:10:10'),
(672, 1, 38, '2019-03-19 13:11:45'),
(673, 1, 58, '2019-03-19 15:33:53'),
(674, 1, 33, '2019-03-19 15:43:18'),
(675, 1, 33, '2019-03-19 16:42:44'),
(676, 1, 33, '2019-03-19 16:48:41'),
(677, 1, 33, '2019-03-19 17:13:58'),
(678, 1, 33, '2019-03-19 17:41:51'),
(679, 1, 33, '2019-03-19 17:47:27'),
(680, 1, 35, '2019-03-19 17:48:06'),
(681, 1, 33, '2019-03-19 17:48:48'),
(682, 1, 50, '2019-03-19 17:49:29'),
(683, 1, 33, '2019-03-19 17:50:48'),
(684, 1, 52, '2019-03-19 18:22:33'),
(685, 1, 33, '2019-03-19 18:27:45'),
(686, 1, 52, '2019-03-19 18:27:53'),
(687, 1, 33, '2019-03-19 18:28:58'),
(688, 1, 33, '2019-03-19 18:30:47'),
(689, 1, 33, '2019-03-20 12:37:26'),
(690, 1, 35, '2019-03-22 13:33:32'),
(691, 1, 33, '2019-03-22 13:35:38'),
(692, 1, 33, '2019-03-23 13:40:29'),
(693, 1, 59, '2019-03-23 16:16:52'),
(694, 1, 33, '2019-03-23 16:48:09'),
(695, 1, 63, '2019-03-25 10:42:25'),
(696, 1, 63, '2019-03-25 10:42:41'),
(697, 1, 63, '2019-03-25 11:19:05'),
(698, 1, 50, '2019-03-25 14:57:06'),
(699, 1, 33, '2019-03-26 12:26:16'),
(700, 1, 33, '2019-03-26 12:26:25'),
(701, 1, 33, '2019-03-26 12:27:38'),
(702, 1, 33, '2019-03-26 13:58:20'),
(703, 1, 33, '2019-03-26 14:11:16'),
(704, 1, 33, '2019-03-26 14:12:56'),
(705, 1, 50, '2019-03-26 14:13:12'),
(706, 1, 33, '2019-03-26 14:35:46'),
(707, 1, 33, '2019-03-26 14:37:34'),
(708, 1, 59, '2019-04-01 16:43:56'),
(709, 1, 34, '2019-04-01 16:51:14'),
(710, 1, 49, '2019-04-02 18:14:39'),
(711, 1, 49, '2019-04-03 10:25:03'),
(712, 1, 63, '2019-04-03 10:33:32'),
(713, 1, 34, '2019-04-03 11:20:58'),
(714, 1, 33, '2019-04-03 11:24:54'),
(715, 1, 34, '2019-04-03 11:28:04'),
(716, 1, 33, '2019-04-03 11:28:52'),
(717, 1, 34, '2019-04-03 11:29:44'),
(718, 1, 33, '2019-04-03 11:33:38'),
(719, 1, 34, '2019-04-03 11:39:50'),
(720, 1, 33, '2019-04-03 12:03:31'),
(721, 1, 49, '2019-04-03 13:06:42'),
(722, 1, 33, '2019-04-03 13:06:47'),
(723, 1, 59, '2019-04-03 13:06:58'),
(724, 1, 64, '2019-04-03 13:13:45'),
(725, 1, 64, '2019-04-03 13:16:28'),
(726, 1, 64, '2019-04-03 15:29:08'),
(727, 1, 33, '2019-04-03 17:13:12'),
(728, 1, 64, '2019-04-03 17:30:23'),
(729, 1, 64, '2019-04-04 12:03:22'),
(730, 1, 33, '2019-04-04 12:12:53'),
(731, 1, 33, '2019-04-04 12:28:14'),
(732, 1, 64, '2019-04-04 13:23:02'),
(733, 3, 33, '2019-04-04 14:34:48'),
(734, 1, 49, '2019-04-04 15:01:36'),
(735, 1, 64, '2019-04-04 15:25:24'),
(736, 1, 64, '2019-04-04 16:08:53'),
(737, 1, 64, '2019-04-04 16:08:58'),
(738, 1, 64, '2019-04-04 16:28:03'),
(739, 1, 64, '2019-04-04 17:20:47'),
(740, 1, 59, '2019-04-04 17:21:33'),
(741, 1, 60, '2019-04-04 17:23:12'),
(742, 1, 49, '2019-04-04 17:23:49'),
(743, 1, 59, '2019-04-04 17:26:46'),
(744, 1, 60, '2019-04-04 17:31:01'),
(745, 1, 49, '2019-04-04 17:31:54'),
(746, 1, 59, '2019-04-04 17:56:13'),
(747, 1, 51, '2019-04-04 18:20:38'),
(748, 1, 33, '2019-04-04 18:27:47'),
(749, 1, 64, '2019-04-04 18:34:04'),
(750, 1, 64, '2019-04-04 18:34:13'),
(751, 1, 64, '2019-04-04 18:46:57'),
(752, 1, 59, '2019-04-05 11:03:16'),
(753, 1, 59, '2019-04-05 11:05:41'),
(754, 1, 60, '2019-04-05 14:17:31'),
(755, 1, 61, '2019-04-05 14:18:06'),
(756, 1, 49, '2019-04-05 15:00:50'),
(757, 1, 61, '2019-04-05 15:46:11'),
(758, 1, 49, '2019-04-05 17:31:22'),
(759, 1, 49, '2019-04-08 12:56:55'),
(760, 1, 33, '2019-04-08 14:17:05'),
(761, 1, 35, '2019-04-08 17:45:30'),
(762, 1, 35, '2019-04-09 15:40:53'),
(763, 1, 58, '2019-04-10 11:06:26'),
(764, 1, 35, '2019-04-10 11:13:00'),
(765, 1, 42, '2019-04-10 11:13:18'),
(766, 1, 36, '2019-04-10 11:21:56'),
(767, 1, 36, '2019-04-10 11:29:04'),
(768, 1, 35, '2019-04-10 12:14:11'),
(769, 1, 38, '2019-04-10 12:16:42'),
(770, 1, 35, '2019-04-10 12:17:16'),
(771, 1, 51, '2019-04-10 12:19:56'),
(772, 1, 51, '2019-04-10 12:40:03'),
(773, 1, 35, '2019-04-10 13:13:05'),
(774, 1, 51, '2019-04-10 13:15:09'),
(775, 1, 35, '2019-04-10 13:25:37'),
(776, 1, 34, '2019-04-10 13:39:28'),
(777, 1, 35, '2019-04-10 13:39:58'),
(778, 1, 42, '2019-04-10 14:31:37'),
(779, 1, 35, '2019-04-10 14:38:37'),
(780, 1, 42, '2019-04-10 14:39:21'),
(781, 1, 58, '2019-04-10 15:49:27'),
(782, 1, 36, '2019-04-10 15:51:50'),
(783, 1, 35, '2019-04-10 15:59:24'),
(784, 1, 42, '2019-04-10 16:00:38'),
(785, 1, 35, '2019-04-10 16:01:35'),
(786, 1, 51, '2019-04-10 16:03:18'),
(787, 1, 42, '2019-04-10 16:16:53'),
(788, 1, 36, '2019-04-10 16:17:00'),
(789, 1, 42, '2019-04-10 17:04:50'),
(790, 1, 51, '2019-04-10 17:25:26'),
(791, 1, 35, '2019-04-10 17:51:51'),
(792, 1, 51, '2019-04-10 18:43:08'),
(793, 1, 36, '2019-04-11 10:38:27'),
(794, 1, 35, '2019-04-11 10:43:35'),
(795, 1, 42, '2019-04-11 10:59:37'),
(796, 1, 35, '2019-04-11 11:14:43'),
(797, 1, 42, '2019-04-11 11:16:05'),
(798, 1, 36, '2019-04-11 11:18:08'),
(799, 1, 36, '2019-04-11 11:47:14'),
(800, 2, 33, '2019-04-11 15:01:56'),
(801, 1, 60, '2019-04-11 15:43:03'),
(802, 1, 61, '2019-04-11 15:52:58'),
(803, 1, 60, '2019-04-11 16:15:56'),
(804, 1, 61, '2019-04-11 16:19:57'),
(805, 1, 60, '2019-04-11 16:23:25'),
(806, 1, 60, '2019-04-11 16:35:04'),
(807, 1, 50, '2019-04-11 18:03:15'),
(808, 1, 36, '2019-04-11 18:03:19'),
(809, 1, 35, '2019-04-11 18:05:02'),
(810, 1, 36, '2019-04-11 18:05:55'),
(811, 1, 35, '2019-04-11 18:22:30'),
(812, 1, 36, '2019-04-11 18:23:10'),
(813, 1, 35, '2019-04-11 18:41:19'),
(814, 1, 36, '2019-04-11 18:41:54'),
(815, 1, 42, '2019-04-12 11:31:12'),
(816, 1, 36, '2019-04-12 11:37:47'),
(817, 1, 42, '2019-04-12 11:41:55'),
(818, 1, 35, '2019-04-12 12:42:19'),
(819, 1, 51, '2019-04-12 13:15:04'),
(820, 2, 33, '2019-04-12 17:50:43'),
(821, 1, 36, '2019-04-12 17:51:07'),
(822, 1, 35, '2019-04-12 17:52:58'),
(823, 1, 42, '2019-04-13 10:28:45'),
(824, 1, 35, '2019-04-13 10:51:03'),
(825, 1, 42, '2019-04-13 10:59:06'),
(826, 1, 35, '2019-04-13 11:11:05'),
(827, 1, 42, '2019-04-13 14:43:38'),
(828, 1, 51, '2019-04-13 15:09:42'),
(829, 1, 36, '2019-04-13 15:33:38'),
(830, 1, 36, '2019-04-13 16:04:02'),
(831, 1, 35, '2019-04-13 16:04:15'),
(832, 1, 51, '2019-04-13 16:04:39'),
(833, 1, 42, '2019-04-13 16:05:00'),
(834, 2, 33, '2019-04-15 15:26:28'),
(835, 2, 33, '2019-04-15 15:26:57'),
(836, 2, 92, '2019-04-15 15:43:34'),
(837, 2, 33, '2019-04-15 16:26:47'),
(838, 2, 59, '2019-04-16 17:34:21'),
(839, 1, 60, '2019-04-18 13:02:14'),
(840, 1, 59, '2019-04-18 13:02:31'),
(841, 1, 60, '2019-04-18 14:26:37'),
(842, 1, 61, '2019-04-18 14:28:07'),
(843, 1, 59, '2019-04-18 17:04:08'),
(844, 1, 64, '2019-04-19 10:41:09'),
(845, 1, 49, '2019-04-19 10:46:06'),
(846, 1, 52, '2019-04-22 10:45:56'),
(847, 1, 49, '2019-04-22 11:33:18'),
(848, 1, 33, '2019-04-22 11:33:46'),
(849, 1, 42, '2019-04-22 12:23:14'),
(850, 1, 60, '2019-04-22 15:12:10'),
(851, 1, 65, '2019-04-22 15:33:13'),
(852, 1, 35, '2019-04-22 16:24:30'),
(853, 1, 49, '2019-04-22 17:13:45'),
(854, 1, 35, '2019-04-22 17:15:49'),
(855, 1, 36, '2019-04-22 17:59:00'),
(856, 1, 35, '2019-04-22 18:32:25'),
(857, 1, 36, '2019-04-22 18:40:48'),
(858, 1, 65, '2019-04-22 18:51:34'),
(859, 1, 65, '2019-04-23 10:36:45'),
(860, 1, 65, '2019-04-23 18:05:57'),
(861, 1, 65, '2019-04-24 16:49:49'),
(862, 1, 65, '2019-04-25 10:33:14'),
(863, 1, 49, '2019-04-25 13:27:09'),
(864, 1, 49, '2019-04-25 13:27:53'),
(865, 1, 35, '2019-04-25 13:28:27'),
(866, 1, 42, '2019-04-25 14:21:55'),
(867, 1, 51, '2019-04-25 15:12:17'),
(868, 1, 42, '2019-04-25 15:12:34'),
(869, 1, 51, '2019-04-25 15:23:18'),
(870, 1, 49, '2019-04-25 16:35:19'),
(871, 1, 35, '2019-04-25 16:43:19'),
(872, 1, 35, '2019-04-25 17:22:05'),
(873, 1, 35, '2019-04-25 17:28:19'),
(874, 1, 51, '2019-04-25 17:40:44'),
(875, 1, 42, '2019-04-25 17:51:44'),
(876, 1, 52, '2019-04-25 18:18:11'),
(877, 1, 35, '2019-04-26 13:08:52'),
(878, 1, 35, '2019-04-26 14:02:42'),
(879, 1, 49, '2019-04-26 14:13:37'),
(880, 1, 49, '2019-04-26 14:14:06'),
(881, 1, 49, '2019-04-26 14:16:04'),
(882, 1, 49, '2019-04-26 14:46:08'),
(883, 1, 49, '2019-04-26 15:39:30'),
(884, 1, 59, '2019-04-26 16:01:38'),
(885, 1, 65, '2019-04-26 16:32:57'),
(886, 1, 59, '2019-04-26 16:35:37'),
(887, 1, 59, '2019-04-26 16:42:27'),
(888, 1, 34, '2019-04-26 16:53:30'),
(889, 1, 59, '2019-04-26 16:55:48'),
(890, 1, 49, '2019-04-26 17:00:57'),
(891, 1, 59, '2019-04-26 17:03:04'),
(892, 1, 59, '2019-04-26 17:39:59'),
(893, 1, 59, '2019-04-26 17:40:42'),
(894, 1, 59, '2019-04-26 17:41:31'),
(895, 1, 59, '2019-04-26 17:42:06'),
(896, 1, 65, '2019-04-26 17:56:15'),
(897, 1, 59, '2019-04-26 17:59:07'),
(898, 1, 59, '2019-04-27 09:55:51'),
(899, 1, 59, '2019-04-27 10:16:21'),
(900, 1, 35, '2019-04-27 11:07:09'),
(901, 1, 59, '2019-04-27 11:09:51'),
(902, 1, 49, '2019-04-29 16:24:52'),
(903, 1, 59, '2019-04-29 16:25:03'),
(904, 1, 59, '2019-04-29 17:05:37'),
(905, 1, 59, '2019-04-30 12:45:26'),
(906, 1, 49, '2019-04-30 12:45:29'),
(907, 1, 49, '2019-04-30 12:51:09'),
(908, 1, 59, '2019-04-30 12:51:20'),
(909, 1, 59, '2019-04-30 12:51:42'),
(910, 1, 60, '2019-04-30 13:25:16'),
(911, 1, 65, '2019-04-30 13:25:31'),
(912, 1, 59, '2019-04-30 13:26:45'),
(913, 1, 59, '2019-04-30 20:35:47'),
(914, 1, 59, '2019-05-02 11:52:28'),
(915, 1, 49, '2019-05-02 13:00:39'),
(916, 1, 49, '2019-05-02 14:28:27'),
(917, 1, 54, '2019-05-04 12:12:45'),
(918, 1, 54, '2019-05-04 13:16:46'),
(919, 1, 35, '2019-05-04 13:17:04'),
(920, 1, 36, '2019-05-04 13:17:11'),
(921, 1, 54, '2019-05-04 13:17:42'),
(922, 1, 54, '2019-05-04 13:22:09'),
(923, 1, 54, '2019-05-06 11:14:20'),
(924, 1, 54, '2019-05-06 11:15:08'),
(925, 1, 54, '2019-05-06 13:26:00'),
(926, 1, 54, '2019-05-06 14:50:46'),
(927, 1, 42, '2019-05-07 14:31:11'),
(928, 1, 42, '2019-05-07 15:47:36'),
(929, 1, 42, '2019-05-07 15:51:05'),
(930, 1, 34, '2019-05-07 16:24:47'),
(931, 1, 56, '2019-05-07 17:47:06'),
(932, 1, 34, '2019-05-07 17:53:43'),
(933, 1, 42, '2019-05-08 10:38:11'),
(934, 1, 42, '2019-05-08 11:00:52'),
(935, 1, 42, '2019-05-08 11:04:11'),
(936, 1, 42, '2019-05-08 11:04:32'),
(937, 1, 42, '2019-05-08 11:56:15'),
(938, 1, 49, '2019-05-08 12:30:37'),
(939, 1, 50, '2019-05-08 12:30:45'),
(940, 1, 33, '2019-05-08 12:36:27'),
(941, 1, 35, '2019-05-08 12:49:40'),
(942, 1, 54, '2019-05-08 14:26:33'),
(943, 1, 42, '2019-05-08 14:51:35'),
(944, 1, 42, '2019-05-08 15:39:52'),
(945, 1, 54, '2019-05-08 15:42:36'),
(946, 1, 54, '2019-05-08 15:43:46'),
(947, 1, 59, '2019-05-09 10:38:07'),
(948, 1, 59, '2019-05-09 11:22:54'),
(949, 1, 65, '2019-05-09 11:40:18'),
(950, 1, 49, '2019-05-09 12:03:50'),
(951, 1, 50, '2019-05-09 15:08:05'),
(952, 1, 58, '2019-05-09 16:05:41'),
(953, 1, 54, '2019-05-09 16:09:20'),
(954, 1, 52, '2019-05-10 06:51:48'),
(955, 1, 54, '2019-05-11 12:44:08'),
(956, 1, 42, '2019-05-11 18:49:24'),
(957, 1, 42, '2019-05-11 18:49:36'),
(958, 1, 35, '2019-05-13 10:45:52'),
(959, 1, 40, '2019-05-13 12:21:06'),
(960, 1, 51, '2019-05-13 12:21:20'),
(961, 1, 49, '2019-05-13 12:38:05'),
(962, 1, 36, '2019-05-13 12:39:23'),
(963, 1, 36, '2019-05-13 12:46:40'),
(964, 1, 66, '2019-05-13 12:49:16'),
(965, 1, 66, '2019-05-13 12:52:01'),
(966, 1, 66, '2019-05-13 13:02:21'),
(967, 1, 66, '2019-05-13 13:02:56'),
(968, 1, 34, '2019-05-13 13:14:50'),
(969, 1, 34, '2019-05-13 13:19:30'),
(970, 1, 66, '2019-05-13 13:19:44'),
(971, 1, 66, '2019-05-13 13:56:55'),
(972, 1, 66, '2019-05-13 15:41:27'),
(973, 1, 34, '2019-05-13 16:47:38'),
(974, 1, 66, '2019-05-13 16:56:46'),
(975, 1, 35, '2019-05-13 18:05:55'),
(976, 1, 66, '2019-05-13 18:06:59'),
(977, 1, 34, '2019-05-13 18:18:34'),
(978, 1, 34, '2019-05-13 18:20:02'),
(979, 1, 36, '2019-05-13 18:20:25'),
(980, 1, 66, '2019-05-13 18:20:28'),
(981, 1, 36, '2019-05-13 18:23:59'),
(982, 1, 66, '2019-05-13 18:26:55'),
(983, 1, 66, '2019-05-14 10:31:07'),
(984, 1, 34, '2019-05-14 10:37:17'),
(985, 1, 66, '2019-05-14 10:37:31'),
(986, 1, 36, '2019-05-14 10:41:39'),
(987, 1, 49, '2019-05-14 10:42:38'),
(988, 1, 49, '2019-05-14 10:42:56'),
(989, 1, 36, '2019-05-14 10:43:04'),
(990, 1, 49, '2019-05-14 10:47:35'),
(991, 1, 66, '2019-05-14 10:58:14'),
(992, 1, 66, '2019-05-14 11:09:45'),
(993, 1, 66, '2019-05-14 11:10:21'),
(994, 1, 66, '2019-05-14 11:12:17'),
(995, 1, 66, '2019-05-14 13:24:03'),
(996, 1, 36, '2019-05-14 14:39:44'),
(997, 1, 66, '2019-05-14 14:41:41'),
(998, 1, 66, '2019-05-14 14:54:25'),
(999, 1, 66, '2019-05-14 15:36:37'),
(1000, 1, 36, '2019-05-14 15:37:19'),
(1001, 1, 66, '2019-05-14 15:37:34'),
(1002, 1, 66, '2019-05-14 15:44:48'),
(1003, 1, 66, '2019-05-14 15:45:05'),
(1004, 1, 66, '2019-05-14 17:24:44'),
(1005, 1, 66, '2019-05-14 17:34:39'),
(1006, 1, 66, '2019-05-15 10:26:01'),
(1007, 1, 34, '2019-05-15 10:41:55'),
(1008, 1, 36, '2019-05-15 10:52:04'),
(1009, 1, 66, '2019-05-15 10:52:07'),
(1010, 1, 34, '2019-05-15 11:18:42'),
(1011, 1, 66, '2019-05-15 11:28:27'),
(1012, 1, 66, '2019-05-15 14:44:47'),
(1013, 1, 66, '2019-05-15 14:45:23'),
(1014, 1, 66, '2019-05-15 14:45:46'),
(1015, 1, 66, '2019-05-15 14:50:38'),
(1016, 1, 55, '2019-05-15 17:06:08'),
(1017, 1, 55, '2019-05-16 10:32:29'),
(1018, 1, 36, '2019-05-16 10:46:29'),
(1019, 1, 35, '2019-05-16 10:46:51'),
(1020, 1, 51, '2019-05-16 10:48:53'),
(1021, 1, 55, '2019-05-16 10:55:55'),
(1022, 1, 51, '2019-05-16 11:01:51'),
(1023, 1, 42, '2019-05-16 11:08:36'),
(1024, 1, 56, '2019-05-16 11:11:05'),
(1025, 1, 40, '2019-05-16 11:14:42'),
(1026, 1, 43, '2019-05-16 11:15:18'),
(1027, 1, 44, '2019-05-16 11:15:24'),
(1028, 1, 54, '2019-05-16 11:15:35'),
(1029, 1, 36, '2019-05-16 11:19:46'),
(1030, 1, 55, '2019-05-16 11:21:19'),
(1031, 1, 66, '2019-05-16 11:49:23'),
(1032, 1, 35, '2019-05-16 14:03:53'),
(1033, 1, 33, '2019-05-16 14:04:10'),
(1034, 1, 35, '2019-05-16 14:26:37'),
(1035, 1, 36, '2019-05-16 14:44:08'),
(1036, 1, 66, '2019-05-16 14:56:07'),
(1037, 1, 67, '2019-05-16 15:01:56'),
(1038, 1, 67, '2019-05-16 15:06:45'),
(1039, 1, 67, '2019-05-16 15:07:01'),
(1040, 1, 67, '2019-05-16 15:07:43'),
(1041, 1, 54, '2019-05-16 16:40:05'),
(1042, 1, 66, '2019-05-16 16:53:15'),
(1043, 1, 67, '2019-05-16 16:53:19'),
(1044, 1, 63, '2019-05-16 17:34:23'),
(1045, 1, 49, '2019-05-16 17:47:07'),
(1046, 1, 49, '2019-05-16 17:47:15'),
(1047, 1, 35, '2019-05-17 10:28:03'),
(1048, 1, 35, '2019-05-17 10:28:12'),
(1049, 1, 67, '2019-05-17 10:29:23'),
(1050, 1, 67, '2019-05-17 12:14:18'),
(1051, 1, 33, '2019-05-17 15:58:10'),
(1052, 1, 66, '2019-05-17 15:58:14'),
(1053, 1, 67, '2019-05-17 15:59:22'),
(1054, 1, 67, '2019-05-17 16:13:35'),
(1055, 1, 66, '2019-05-17 16:35:20'),
(1056, 1, 67, '2019-05-17 16:35:41'),
(1057, 1, 66, '2019-05-17 16:37:59'),
(1058, 1, 67, '2019-05-17 16:42:01'),
(1059, 1, 36, '2019-05-17 16:47:04'),
(1060, 1, 66, '2019-05-17 16:47:12'),
(1061, 1, 67, '2019-05-17 16:49:59'),
(1062, 1, 66, '2019-05-17 17:35:12'),
(1063, 1, 67, '2019-05-17 17:55:59'),
(1064, 1, 66, '2019-05-17 18:05:03'),
(1065, 1, 67, '2019-05-17 18:08:02'),
(1066, 1, 36, '2019-05-17 18:18:57'),
(1067, 1, 66, '2019-05-17 18:19:03'),
(1068, 1, 66, '2019-05-17 18:26:50'),
(1069, 1, 66, '2019-05-17 18:35:08'),
(1070, 1, 67, '2019-05-17 18:35:15'),
(1071, 1, 67, '2019-05-18 11:24:18'),
(1072, 1, 66, '2019-05-18 11:44:35'),
(1073, 1, 67, '2019-05-18 11:48:50'),
(1074, 1, 66, '2019-05-18 11:54:15'),
(1075, 1, 67, '2019-05-18 11:58:14'),
(1076, 1, 66, '2019-05-18 13:52:12'),
(1077, 1, 67, '2019-05-18 14:15:07'),
(1078, 1, 66, '2019-05-18 14:22:11'),
(1079, 1, 67, '2019-05-18 14:39:48'),
(1080, 1, 66, '2019-05-18 14:42:34'),
(1081, 1, 67, '2019-05-18 14:43:38'),
(1082, 1, 66, '2019-05-18 14:44:09'),
(1083, 1, 67, '2019-05-18 15:41:19'),
(1084, 1, 67, '2019-05-18 16:48:30'),
(1085, 1, 55, '2019-05-18 17:18:18'),
(1086, 1, 66, '2019-05-18 17:26:37'),
(1087, 1, 66, '2019-05-18 17:27:20'),
(1088, 1, 67, '2019-05-18 17:30:17'),
(1089, 1, 66, '2019-05-18 17:34:32'),
(1090, 1, 66, '2019-05-18 17:35:40'),
(1091, 1, 67, '2019-05-18 17:36:47'),
(1092, 1, 66, '2019-05-18 18:01:14'),
(1093, 1, 67, '2019-05-18 18:01:46'),
(1094, 1, 66, '2019-05-18 19:00:57'),
(1095, 1, 67, '2019-05-18 19:01:23'),
(1096, 1, 66, '2019-05-18 19:02:32'),
(1097, 1, 67, '2019-05-18 19:02:46'),
(1098, 1, 66, '2019-05-21 10:29:20'),
(1099, 1, 67, '2019-05-21 10:40:31'),
(1100, 1, 66, '2019-05-21 10:40:43'),
(1101, 1, 66, '2019-05-21 11:01:55'),
(1102, 1, 34, '2019-05-21 15:24:22'),
(1103, 1, 34, '2019-05-21 15:34:11'),
(1104, 1, 34, '2019-05-21 15:38:34'),
(1105, 1, 34, '2019-05-21 15:40:26'),
(1106, 1, 34, '2019-05-21 15:56:06'),
(1107, 1, 51, '2019-05-21 15:56:21'),
(1108, 1, 34, '2019-05-21 15:56:26'),
(1109, 1, 34, '2019-05-21 15:56:44'),
(1110, 1, 34, '2019-05-21 15:57:01'),
(1111, 1, 34, '2019-05-21 16:07:05'),
(1112, 1, 34, '2019-05-21 19:02:39'),
(1113, 1, 56, '2019-05-21 20:11:34'),
(1114, 1, 34, '2019-05-21 20:14:37'),
(1115, 1, 34, '2019-05-22 11:13:29'),
(1116, 1, 56, '2019-05-22 11:22:42'),
(1117, 1, 56, '2019-05-22 11:23:06'),
(1118, 1, 35, '2019-05-22 12:01:27'),
(1119, 1, 36, '2019-05-22 12:21:13'),
(1120, 1, 66, '2019-05-22 12:21:19'),
(1121, 1, 67, '2019-05-22 12:24:24'),
(1122, 1, 67, '2019-05-22 12:25:07'),
(1123, 1, 34, '2019-05-22 12:34:09'),
(1124, 1, 66, '2019-05-22 12:37:57'),
(1125, 1, 61, '2019-05-22 13:03:52'),
(1126, 1, 60, '2019-05-22 13:05:11'),
(1127, 1, 65, '2019-05-22 13:07:15'),
(1128, 1, 60, '2019-05-22 13:19:44'),
(1129, 1, 66, '2019-05-22 13:25:55'),
(1130, 1, 61, '2019-05-22 14:43:02'),
(1131, 1, 67, '2019-05-22 14:43:09'),
(1132, 1, 36, '2019-05-22 14:45:34'),
(1133, 1, 66, '2019-05-22 14:45:42'),
(1134, 1, 67, '2019-05-22 14:47:36'),
(1135, 1, 36, '2019-05-22 14:48:30'),
(1136, 1, 66, '2019-05-22 14:48:49'),
(1137, 1, 67, '2019-05-22 14:54:47'),
(1138, 1, 66, '2019-05-22 14:56:44'),
(1139, 1, 67, '2019-05-22 14:59:38'),
(1140, 1, 67, '2019-05-22 15:10:09'),
(1141, 1, 66, '2019-05-22 15:12:14'),
(1142, 1, 67, '2019-05-22 15:14:23'),
(1143, 1, 66, '2019-05-22 15:14:42'),
(1144, 1, 67, '2019-05-22 15:16:09'),
(1145, 1, 35, '2019-05-22 16:56:13'),
(1146, 1, 67, '2019-05-22 16:58:15'),
(1147, 1, 67, '2019-05-22 17:06:52'),
(1148, 1, 66, '2019-05-22 18:36:57'),
(1149, 1, 67, '2019-05-22 18:38:28'),
(1150, 1, 66, '2019-05-22 19:00:30'),
(1151, 1, 67, '2019-05-22 19:08:08'),
(1152, 1, 66, '2019-05-23 10:53:28'),
(1153, 1, 67, '2019-05-23 11:02:27'),
(1154, 1, 66, '2019-05-23 11:04:04'),
(1155, 1, 67, '2019-05-23 11:20:55'),
(1156, 1, 66, '2019-05-23 12:20:31'),
(1157, 1, 34, '2019-05-23 12:25:48'),
(1158, 1, 66, '2019-05-23 12:26:01'),
(1159, 1, 34, '2019-05-23 12:26:14'),
(1160, 1, 66, '2019-05-23 12:26:26'),
(1161, 1, 67, '2019-05-23 12:32:57'),
(1162, 1, 66, '2019-05-23 13:04:42'),
(1163, 1, 36, '2019-05-23 13:16:11'),
(1164, 1, 66, '2019-05-23 13:16:16'),
(1165, 1, 67, '2019-05-23 13:18:03'),
(1166, 1, 66, '2019-05-23 13:20:12'),
(1167, 1, 66, '2019-05-23 14:53:37'),
(1168, 1, 66, '2019-05-23 15:53:08'),
(1169, 1, 67, '2019-05-23 15:59:01'),
(1170, 1, 66, '2019-05-23 16:02:27'),
(1171, 1, 67, '2019-05-23 16:06:31'),
(1172, 1, 66, '2019-05-23 16:09:52'),
(1173, 1, 67, '2019-05-23 16:13:12'),
(1174, 1, 66, '2019-05-23 16:15:36'),
(1175, 1, 67, '2019-05-23 16:20:24'),
(1176, 1, 66, '2019-05-23 16:21:20'),
(1177, 1, 67, '2019-05-23 16:21:40'),
(1178, 1, 67, '2019-05-23 16:53:37'),
(1179, 1, 66, '2019-05-23 17:05:36'),
(1180, 1, 67, '2019-05-23 17:06:02'),
(1181, 1, 67, '2019-05-23 17:16:09'),
(1182, 1, 67, '2019-05-23 17:32:27'),
(1183, 1, 67, '2019-05-23 17:42:19'),
(1184, 1, 66, '2019-05-23 17:45:08'),
(1185, 1, 67, '2019-05-23 17:45:23'),
(1186, 1, 67, '2019-05-24 10:53:26'),
(1187, 1, 66, '2019-05-24 11:17:25'),
(1188, 1, 66, '2019-05-24 12:54:16'),
(1189, 1, 66, '2019-05-24 13:10:25'),
(1190, 1, 66, '2019-05-24 16:18:26'),
(1191, 1, 66, '2019-05-25 10:17:21'),
(1192, 1, 34, '2019-05-25 11:59:34'),
(1193, 1, 66, '2019-05-25 12:54:37'),
(1194, 1, 34, '2019-05-25 13:05:43'),
(1195, 1, 66, '2019-05-25 13:06:00'),
(1196, 1, 34, '2019-05-25 13:06:27'),
(1197, 1, 66, '2019-05-25 13:06:49'),
(1198, 1, 66, '2019-05-25 13:56:57'),
(1199, 1, 51, '2019-05-25 14:27:31'),
(1200, 1, 66, '2019-05-25 14:29:48'),
(1201, 1, 51, '2019-05-25 14:32:01'),
(1202, 1, 35, '2019-05-25 14:47:54'),
(1203, 1, 66, '2019-05-25 15:09:48'),
(1204, 1, 68, '2019-05-25 15:29:29'),
(1205, 1, 68, '2019-05-25 15:45:12'),
(1206, 1, 66, '2019-05-25 16:00:47'),
(1207, 1, 34, '2019-05-25 16:01:14'),
(1208, 1, 66, '2019-05-25 16:01:55'),
(1209, 1, 68, '2019-05-27 10:21:17'),
(1210, 1, 68, '2019-05-27 11:16:30'),
(1211, 1, 68, '2019-05-27 11:42:36'),
(1212, 1, 35, '2019-05-27 12:04:42'),
(1213, 1, 68, '2019-05-27 12:05:25'),
(1214, 1, 35, '2019-05-27 12:07:03'),
(1215, 1, 68, '2019-05-27 12:08:09'),
(1216, 1, 69, '2019-05-27 12:32:33'),
(1217, 1, 34, '2019-05-27 12:42:55'),
(1218, 1, 69, '2019-05-27 12:47:37'),
(1219, 1, 70, '2019-05-27 13:48:54'),
(1220, 1, 69, '2019-05-27 14:45:12'),
(1221, 1, 68, '2019-05-27 14:49:19'),
(1222, 1, 35, '2019-05-27 14:49:38'),
(1223, 1, 66, '2019-05-27 14:51:14'),
(1224, 1, 35, '2019-05-27 15:12:35'),
(1225, 1, 66, '2019-05-27 15:12:48'),
(1226, 1, 66, '2019-05-27 15:17:18'),
(1227, 1, 67, '2019-05-27 15:22:13'),
(1228, 1, 66, '2019-05-27 15:24:20'),
(1229, 1, 61, '2019-05-27 17:01:59'),
(1230, 1, 60, '2019-05-27 17:02:14'),
(1231, 1, 68, '2019-05-27 17:02:38'),
(1232, 1, 60, '2019-05-27 17:12:35'),
(1233, 1, 65, '2019-05-27 17:13:38'),
(1234, 1, 61, '2019-05-27 17:18:23'),
(1235, 1, 65, '2019-05-27 17:19:05'),
(1236, 1, 66, '2019-05-27 17:39:01'),
(1237, 1, 66, '2019-05-27 17:53:21'),
(1238, 1, 66, '2019-05-27 18:06:26'),
(1239, 1, 66, '2019-05-27 18:18:05'),
(1240, 1, 60, '2019-05-28 10:31:12'),
(1241, 1, 58, '2019-05-28 11:01:18'),
(1242, 1, 60, '2019-05-28 11:01:26'),
(1243, 1, 60, '2019-05-28 17:30:14'),
(1244, 1, 60, '2019-05-29 11:25:25'),
(1245, 1, 49, '2019-05-29 11:40:29'),
(1246, 1, 49, '2019-05-29 11:40:35'),
(1247, 1, 33, '2019-05-29 11:40:39'),
(1248, 1, 60, '2019-05-29 13:36:55'),
(1249, 1, 60, '2019-05-30 10:22:06'),
(1250, 1, 36, '2019-05-30 17:30:50'),
(1251, 1, 66, '2019-05-30 17:31:07'),
(1252, 1, 66, '2019-05-30 17:48:31'),
(1253, 1, 36, '2019-05-30 17:48:45'),
(1254, 1, 66, '2019-05-30 18:07:11'),
(1255, 1, 67, '2019-05-31 10:23:07'),
(1256, 1, 67, '2019-05-31 10:47:07'),
(1257, 1, 66, '2019-05-31 11:43:38'),
(1258, 1, 67, '2019-05-31 11:44:25'),
(1259, 1, 66, '2019-05-31 12:39:29'),
(1260, 1, 67, '2019-05-31 12:47:37'),
(1261, 1, 67, '2019-05-31 12:51:56'),
(1262, 1, 66, '2019-05-31 12:52:00'),
(1263, 1, 66, '2019-05-31 13:04:33'),
(1264, 1, 66, '2019-05-31 13:32:49'),
(1265, 1, 67, '2019-05-31 13:33:35'),
(1266, 1, 66, '2019-06-01 11:39:18'),
(1267, 1, 66, '2019-06-01 12:09:24'),
(1268, 1, 67, '2019-06-01 12:09:33'),
(1269, 1, 66, '2019-06-01 14:27:02'),
(1270, 1, 66, '2019-06-01 15:49:21'),
(1271, 1, 66, '2019-06-01 16:07:49'),
(1272, 1, 66, '2019-06-01 17:39:26'),
(1273, 19, 71, '2019-06-10 10:23:06'),
(1274, 19, 71, '2019-06-10 10:23:20'),
(1275, 19, 72, '2019-06-10 10:24:16'),
(1276, 19, 67, '2019-06-10 10:24:28'),
(1277, 19, 71, '2019-06-10 10:25:59'),
(1278, 19, 72, '2019-06-10 10:26:35'),
(1279, 19, 74, '2019-06-10 10:26:41'),
(1280, 19, 67, '2019-06-10 10:26:50'),
(1281, 19, 75, '2019-06-10 10:29:28'),
(1282, 19, 55, '2019-06-10 10:29:33'),
(1283, 19, 74, '2019-06-10 10:30:05'),
(1284, 19, 71, '2019-06-10 10:37:58'),
(1285, 19, 72, '2019-06-10 10:50:50'),
(1286, 19, 71, '2019-06-10 10:53:50'),
(1287, 19, 67, '2019-06-10 10:53:59'),
(1288, 19, 55, '2019-06-10 10:59:51'),
(1289, 19, 71, '2019-06-10 10:59:59'),
(1290, 19, 67, '2019-06-10 11:00:07'),
(1291, 19, 71, '2019-06-10 11:02:30'),
(1292, 19, 71, '2019-06-10 11:03:31'),
(1293, 19, 71, '2019-06-10 12:41:16'),
(1294, 19, 71, '2019-06-10 13:00:31'),
(1295, 19, 71, '2019-06-10 14:09:39'),
(1296, 19, 71, '2019-06-10 14:32:12'),
(1297, 19, 71, '2019-06-10 14:32:47'),
(1298, 19, 71, '2019-06-10 15:07:32'),
(1299, 19, 71, '2019-06-10 15:10:24'),
(1300, 19, 71, '2019-06-10 15:11:25'),
(1301, 19, 71, '2019-06-10 15:12:27'),
(1302, 19, 71, '2019-06-10 15:21:32'),
(1303, 19, 71, '2019-06-10 15:33:52'),
(1304, 19, 71, '2019-06-10 15:52:18'),
(1305, 19, 71, '2019-06-10 15:53:18'),
(1306, 19, 71, '2019-06-10 15:58:30'),
(1307, 19, 71, '2019-06-10 16:05:43'),
(1308, 19, 71, '2019-06-10 16:08:27'),
(1309, 19, 71, '2019-06-10 16:15:38'),
(1310, 19, 72, '2019-06-10 16:27:29'),
(1311, 19, 72, '2019-06-10 16:33:45'),
(1312, 19, 72, '2019-06-10 16:55:25'),
(1313, 19, 72, '2019-06-10 16:59:13'),
(1314, 19, 72, '2019-06-10 16:59:50'),
(1315, 19, 71, '2019-06-10 17:17:44'),
(1316, 19, 72, '2019-06-10 17:19:11'),
(1317, 19, 73, '2019-06-10 17:21:49'),
(1318, 19, 67, '2019-06-10 17:22:09'),
(1319, 19, 55, '2019-06-10 17:23:54'),
(1320, 19, 67, '2019-06-10 17:24:55'),
(1321, 19, 72, '2019-06-10 17:29:29'),
(1322, 19, 72, '2019-06-10 17:30:42'),
(1323, 19, 71, '2019-06-10 17:30:48'),
(1324, 19, 71, '2019-06-10 17:38:54'),
(1325, 19, 72, '2019-06-10 17:48:53'),
(1326, 19, 75, '2019-06-10 17:52:01'),
(1327, 19, 75, '2019-06-10 17:52:39'),
(1328, 19, 75, '2019-06-10 17:53:20'),
(1329, 19, 73, '2019-06-10 17:57:43'),
(1330, 19, 55, '2019-06-10 17:59:49'),
(1331, 19, 55, '2019-06-10 17:59:50'),
(1332, 19, 55, '2019-06-10 17:59:50'),
(1333, 19, 55, '2019-06-10 18:00:37'),
(1334, 19, 71, '2019-06-11 10:21:09'),
(1335, 19, 67, '2019-06-11 10:21:29'),
(1336, 19, 67, '2019-06-11 10:39:48'),
(1337, 19, 71, '2019-06-11 13:23:09'),
(1338, 19, 67, '2019-06-11 13:23:17'),
(1339, 19, 67, '2019-06-11 13:24:43'),
(1340, 19, 55, '2019-06-11 14:42:04'),
(1341, 19, 67, '2019-06-11 15:09:21'),
(1342, 19, 74, '2019-06-11 15:09:51'),
(1343, 19, 72, '2019-06-11 15:09:57'),
(1344, 19, 55, '2019-06-11 15:10:08'),
(1345, 19, 75, '2019-06-11 15:10:49'),
(1346, 19, 55, '2019-06-11 15:11:00'),
(1347, 19, 56, '2019-06-11 15:11:04'),
(1348, 19, 74, '2019-06-11 15:11:10'),
(1349, 19, 71, '2019-06-11 15:11:13'),
(1350, 19, 74, '2019-06-11 15:17:29'),
(1351, 19, 71, '2019-06-11 15:19:31'),
(1352, 19, 73, '2019-06-11 15:22:45'),
(1353, 19, 73, '2019-06-11 15:23:27'),
(1354, 19, 56, '2019-06-12 10:37:59'),
(1355, 19, 71, '2019-06-12 10:51:28'),
(1356, 19, 71, '2019-06-12 10:51:44'),
(1357, 19, 72, '2019-06-12 10:52:55'),
(1358, 19, 56, '2019-06-12 10:53:04'),
(1359, 19, 67, '2019-06-12 12:31:26'),
(1360, 19, 74, '2019-06-12 12:32:13'),
(1361, 19, 73, '2019-06-12 12:32:21'),
(1362, 19, 56, '2019-06-12 12:33:32'),
(1363, 19, 56, '2019-06-12 12:39:23'),
(1364, 19, 56, '2019-06-12 12:48:45'),
(1365, 19, 56, '2019-06-12 13:16:10'),
(1366, 19, 56, '2019-06-12 14:41:04'),
(1367, 19, 56, '2019-06-12 14:57:55'),
(1368, 19, 55, '2019-06-12 15:01:56'),
(1369, 19, 55, '2019-06-12 15:02:39'),
(1370, 19, 71, '2019-06-12 17:27:56'),
(1371, 19, 55, '2019-06-12 17:29:15'),
(1372, 19, 55, '2019-06-13 10:00:54'),
(1373, 19, 74, '2019-06-13 10:50:58'),
(1374, 19, 71, '2019-06-13 10:53:39'),
(1375, 19, 67, '2019-06-13 11:04:58'),
(1376, 19, 73, '2019-06-13 11:14:19'),
(1377, 19, 67, '2019-06-13 11:22:29'),
(1378, 19, 75, '2019-06-13 11:22:51'),
(1379, 19, 56, '2019-06-13 11:23:20'),
(1380, 19, 73, '2019-06-13 11:24:24'),
(1381, 19, 55, '2019-06-13 11:33:18'),
(1382, 19, 67, '2019-06-13 14:44:06'),
(1383, 19, 55, '2019-06-13 14:44:26'),
(1384, 19, 73, '2019-06-13 14:47:22'),
(1385, 19, 71, '2019-06-13 14:47:30'),
(1386, 19, 55, '2019-06-13 14:51:43'),
(1387, 19, 55, '2019-06-13 14:53:49');
INSERT INTO `i_user_history` (`iuh_id`, `iuh_owner`, `iuh_mid`, `iuh_date`) VALUES
(1388, 19, 55, '2019-06-13 16:15:53'),
(1389, 19, 55, '2019-06-13 16:18:58'),
(1390, 19, 55, '2019-06-13 16:40:32'),
(1391, 19, 74, '2019-06-13 16:49:03'),
(1392, 19, 74, '2019-06-13 16:50:37'),
(1393, 19, 55, '2019-06-13 17:13:02'),
(1394, 19, 55, '2019-06-13 17:21:08'),
(1395, 19, 75, '2019-06-13 17:21:11'),
(1396, 19, 55, '2019-06-13 19:42:02'),
(1397, 19, 56, '2019-06-13 19:45:53'),
(1398, 19, 75, '2019-06-13 19:46:15'),
(1399, 19, 71, '2019-06-13 19:46:22'),
(1400, 19, 71, '2019-06-13 19:48:23'),
(1401, 19, 71, '2019-06-13 19:49:26'),
(1402, 19, 77, '2019-06-14 11:16:18'),
(1403, 19, 77, '2019-06-14 11:18:09'),
(1404, 19, 78, '2019-06-14 11:24:35'),
(1405, 19, 77, '2019-06-14 11:35:07'),
(1406, 19, 77, '2019-06-14 12:02:00'),
(1407, 19, 78, '2019-06-14 12:02:08'),
(1408, 19, 77, '2019-06-14 12:02:14'),
(1409, 19, 78, '2019-06-14 12:10:00'),
(1410, 19, 78, '2019-06-14 12:13:41'),
(1411, 19, 78, '2019-06-14 12:15:22'),
(1412, 19, 77, '2019-06-14 12:15:27'),
(1413, 19, 79, '2019-06-14 13:16:54'),
(1414, 19, 79, '2019-06-14 14:49:09'),
(1415, 19, 79, '2019-06-14 15:45:58'),
(1416, 19, 80, '2019-06-14 16:56:28'),
(1417, 19, 71, '2019-06-14 17:01:30'),
(1418, 19, 67, '2019-06-14 17:02:32'),
(1419, 19, 79, '2019-06-14 17:03:50'),
(1420, 19, 67, '2019-06-14 17:04:20'),
(1421, 19, 73, '2019-06-14 18:02:27'),
(1422, 19, 77, '2019-06-14 18:02:46'),
(1423, 19, 73, '2019-06-14 18:03:15'),
(1424, 19, 78, '2019-06-14 18:03:46'),
(1425, 19, 77, '2019-06-14 18:03:50'),
(1426, 19, 75, '2019-06-14 18:05:09'),
(1427, 19, 56, '2019-06-14 18:07:53'),
(1428, 19, 67, '2019-06-15 09:40:49'),
(1429, 19, 55, '2019-06-15 10:08:36'),
(1430, 19, 67, '2019-06-15 10:09:08'),
(1431, 19, 56, '2019-06-15 12:59:07'),
(1432, 19, 56, '2019-06-15 13:29:16'),
(1433, 19, 56, '2019-06-15 13:54:18'),
(1434, 19, 56, '2019-06-15 14:03:13'),
(1435, 19, 56, '2019-06-15 14:17:44'),
(1436, 19, 56, '2019-06-15 14:27:59'),
(1437, 19, 75, '2019-06-15 21:48:21'),
(1438, 19, 71, '2019-06-15 21:48:30'),
(1439, 19, 67, '2019-06-17 09:57:38'),
(1440, 19, 77, '2019-06-17 22:32:20'),
(1441, 19, 67, '2019-06-18 15:42:31'),
(1442, 19, 71, '2019-06-18 15:45:38'),
(1443, 19, 55, '2019-06-18 15:45:49'),
(1444, 19, 72, '2019-06-18 15:46:07'),
(1445, 19, 67, '2019-06-19 09:56:56'),
(1446, 19, 67, '2019-06-19 09:59:39'),
(1447, 19, 67, '2019-06-19 10:01:02'),
(1448, 19, 75, '2019-06-19 10:01:06'),
(1449, 19, 55, '2019-06-19 10:03:17'),
(1450, 19, 56, '2019-06-19 10:04:52'),
(1451, 19, 55, '2019-06-19 10:17:50'),
(1452, 19, 75, '2019-06-19 10:17:55'),
(1453, 19, 67, '2019-06-19 10:17:59'),
(1454, 19, 55, '2019-06-19 10:18:03'),
(1455, 19, 56, '2019-06-19 10:21:46'),
(1456, 19, 55, '2019-06-19 10:26:47'),
(1457, 19, 56, '2019-06-19 10:26:52'),
(1458, 19, 71, '2019-06-19 10:28:01'),
(1459, 19, 72, '2019-06-19 10:38:02'),
(1460, 19, 72, '2019-06-19 10:39:14'),
(1461, 19, 73, '2019-06-19 10:40:01'),
(1462, 19, 77, '2019-06-19 10:42:47'),
(1463, 19, 77, '2019-06-19 10:42:54'),
(1464, 19, 77, '2019-06-19 10:46:15'),
(1465, 19, 77, '2019-06-19 10:46:21'),
(1466, 19, 78, '2019-06-19 10:46:32'),
(1467, 19, 79, '2019-06-19 10:49:18'),
(1468, 19, 80, '2019-06-19 10:51:42'),
(1469, 19, 79, '2019-06-19 10:52:42'),
(1470, 19, 80, '2019-06-19 10:52:53'),
(1471, 19, 75, '2019-06-19 10:56:56'),
(1472, 19, 56, '2019-06-19 10:57:06'),
(1473, 19, 72, '2019-06-19 11:03:07'),
(1474, 1, 71, '2019-06-19 14:13:02'),
(1475, 1, 71, '2019-06-19 14:13:48'),
(1476, 1, 71, '2019-06-19 14:26:10'),
(1477, 1, 71, '2019-06-19 14:29:57'),
(1478, 1, 75, '2019-06-19 14:30:43'),
(1479, 1, 73, '2019-06-19 14:30:54'),
(1480, 1, 73, '2019-06-19 14:31:22'),
(1481, 1, 67, '2019-06-19 14:31:53'),
(1482, 1, 55, '2019-06-19 14:41:28'),
(1483, 1, 67, '2019-06-19 14:41:38'),
(1484, 1, 71, '2019-06-19 15:09:46'),
(1485, 1, 67, '2019-06-19 15:10:29'),
(1486, 1, 67, '2019-06-19 15:13:03'),
(1487, 1, 71, '2019-06-19 15:13:06'),
(1488, 1, 67, '2019-06-19 15:13:51'),
(1489, 1, 73, '2019-06-19 15:18:49'),
(1490, 1, 67, '2019-06-19 15:20:48'),
(1491, 1, 67, '2019-06-19 19:39:59'),
(1492, 1, 73, '2019-06-19 19:51:13'),
(1493, 1, 67, '2019-06-20 10:22:20'),
(1494, 1, 71, '2019-06-20 10:22:26'),
(1495, 1, 67, '2019-06-20 10:23:25'),
(1496, 1, 55, '2019-06-20 10:32:28'),
(1497, 1, 56, '2019-06-20 11:08:28'),
(1498, 1, 55, '2019-06-20 11:09:22'),
(1499, 4, 67, '2019-06-20 11:35:43'),
(1500, 4, 71, '2019-06-20 11:39:45'),
(1501, 4, 72, '2019-06-20 11:48:53'),
(1502, 4, 75, '2019-06-20 11:49:19'),
(1503, 4, 77, '2019-06-20 11:56:49'),
(1504, 4, 71, '2019-06-20 12:07:01'),
(1505, 4, 56, '2019-06-20 12:08:28'),
(1506, 4, 71, '2019-06-20 12:08:44'),
(1507, 4, 71, '2019-06-20 12:11:34'),
(1508, 4, 73, '2019-06-20 12:21:47'),
(1509, 4, 75, '2019-06-20 12:23:35'),
(1510, 4, 72, '2019-06-20 12:24:15'),
(1511, 4, 79, '2019-06-20 12:30:47'),
(1512, 4, 73, '2019-06-20 12:31:56'),
(1513, 4, 67, '2019-06-20 12:32:08'),
(1514, 4, 67, '2019-06-20 12:36:37'),
(1515, 4, 55, '2019-06-20 12:36:43'),
(1516, 4, 56, '2019-06-20 12:39:35'),
(1517, 4, 73, '2019-06-20 12:47:59'),
(1518, 4, 75, '2019-06-20 12:48:35'),
(1519, 4, 71, '2019-06-20 12:49:33'),
(1520, 4, 71, '2019-06-20 12:50:20'),
(1521, 1, 67, '2019-06-20 12:51:16'),
(1522, 1, 75, '2019-06-20 12:57:09'),
(1523, 4, 56, '2019-06-20 13:01:13'),
(1524, 4, 71, '2019-06-20 13:39:05'),
(1525, 1, 71, '2019-06-20 15:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `i_user_invite`
--

CREATE TABLE `i_user_invite` (
  `iui_id` int(11) NOT NULL,
  `iui_type` varchar(25) NOT NULL,
  `iui_email` varchar(50) NOT NULL,
  `iui_u_id` int(11) NOT NULL,
  `iui_owner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_user_kpi`
--

CREATE TABLE `i_user_kpi` (
  `iuk_id` int(11) NOT NULL,
  `iuk_uid` int(11) DEFAULT NULL,
  `iuk_kpi_id` int(11) DEFAULT NULL,
  `iuk_mid` int(11) DEFAULT NULL,
  `iuk_gid` int(11) DEFAULT NULL,
  `iuk_created` datetime DEFAULT NULL,
  `iuk_created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_kpi`
--

INSERT INTO `i_user_kpi` (`iuk_id`, `iuk_uid`, `iuk_kpi_id`, `iuk_mid`, `iuk_gid`, `iuk_created`, `iuk_created_by`) VALUES
(23, 188, 16, 0, 0, '2018-12-25 14:12:57', 188),
(24, 188, 8, 0, 0, '2018-12-25 14:12:09', 188),
(25, 1, 16, 0, 0, '2019-02-28 19:19:39', 1),
(26, 1, 8, 0, 0, '2019-02-28 19:19:42', 1),
(27, 2, 8, 0, 31, '2019-05-31 13:13:55', 2);

-- --------------------------------------------------------

--
-- Table structure for table `i_user_scheme`
--

CREATE TABLE `i_user_scheme` (
  `iush_id` int(11) NOT NULL,
  `iush_name` varchar(50) DEFAULT NULL,
  `iush_limit` varchar(50) DEFAULT NULL,
  `iush_time` varchar(50) DEFAULT NULL,
  `iush_created` datetime DEFAULT NULL,
  `iush_created_by` int(11) DEFAULT NULL,
  `iush_modify` datetime DEFAULT NULL,
  `iush_modified_by` int(11) DEFAULT NULL,
  `iush_default` int(11) DEFAULT NULL,
  `iush_desc` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_scheme`
--

INSERT INTO `i_user_scheme` (`iush_id`, `iush_name`, `iush_limit`, `iush_time`, `iush_created`, `iush_created_by`, `iush_modify`, `iush_modified_by`, `iush_default`, `iush_desc`) VALUES
(1, 'R10U1000', '1', 'one_time', '2019-01-15 16:01:21', NULL, '2019-01-30 18:01:03', NULL, 0, NULL),
(2, 'R5PU5P', '-1', 'every_txn', '2019-01-16 11:01:31', NULL, '2019-01-31 12:01:23', NULL, 0, NULL),
(3, 'EVOMATAONLY', '-1', 'every_txn', '2019-01-29 16:01:53', NULL, '2019-06-18 16:13:36', NULL, 0, 'Copy this code and forward it to people when they are registering on Daifunc. You will get 30% credits of the total amount to your account which can be redeemed for future purchases.');

-- --------------------------------------------------------

--
-- Table structure for table `i_user_scheme_payment`
--

CREATE TABLE `i_user_scheme_payment` (
  `iushpay_id` int(11) NOT NULL,
  `iushpay_mode` varchar(100) DEFAULT NULL,
  `iushpay_date` date DEFAULT NULL,
  `iushpay_desc` varchar(500) DEFAULT NULL,
  `iushpay_amount` varchar(100) DEFAULT NULL,
  `iushpay_v_no` varchar(200) DEFAULT NULL,
  `iushpay_created` datetime DEFAULT NULL,
  `iushpay_modify` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_scheme_payment`
--

INSERT INTO `i_user_scheme_payment` (`iushpay_id`, `iushpay_mode`, `iushpay_date`, `iushpay_desc`, `iushpay_amount`, `iushpay_v_no`, `iushpay_created`, `iushpay_modify`) VALUES
(4, 'cash', '2019-01-18', 'slkdgfsdlfa;dhcalksflad;fkgadslkfljsdf', '3163.8900000000003', '128937981231', '2019-01-18 12:01:50', NULL),
(5, 'online', '2019-06-18', 'online txn', '5995', '123', '2019-06-18 16:20:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_user_scheme_txn`
--

CREATE TABLE `i_user_scheme_txn` (
  `iushtxn_id` int(11) NOT NULL,
  `iushtxn_uid` int(11) DEFAULT NULL,
  `iushtxn_ref_code` varchar(50) DEFAULT NULL,
  `iushtxn_amount` varchar(50) DEFAULT NULL,
  `iushtxn_txn_id` int(11) DEFAULT NULL,
  `iushtxn_created` datetime DEFAULT NULL,
  `iushtxn_sid` int(11) DEFAULT NULL,
  `iushtxn_payment_id` int(11) DEFAULT NULL,
  `iushtxn_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_scheme_txn`
--

INSERT INTO `i_user_scheme_txn` (`iushtxn_id`, `iushtxn_uid`, `iushtxn_ref_code`, `iushtxn_amount`, `iushtxn_txn_id`, `iushtxn_created`, `iushtxn_sid`, `iushtxn_payment_id`, `iushtxn_status`) VALUES
(5, 228, '0MFZ188', '54.166833333333', 8, '2019-01-17 08:30:27', 2, 4, 'paid'),
(6, 228, '0MFZ188', '54.166833333333', 9, '2019-01-16 18:01:21', 2, 4, 'paid'),
(8, 228, '0MFZ188', '3055.55', 11, '2019-01-17 11:01:33', 2, 4, 'paid'),
(9, 216, '0MFZ188', '12.5', 12, '2018-12-01 13:01:37', 2, 0, 'unpaid'),
(10, 228, NULL, '833.33316666667', NULL, NULL, 2, NULL, 'unpaid'),
(11, 19, 'W8XU19', '5995', 26, '2019-06-18 16:14:04', 3, 5, 'paid'),
(14, 1, '4Z841', '654', 3, '2019-06-19 12:50:33', 3, NULL, 'unpaid'),
(15, 4, 'EVOMATAONLY', '654', 5, '2019-06-20 11:34:26', 3, NULL, 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `i_user_template`
--

CREATE TABLE `i_user_template` (
  `iut_id` int(10) NOT NULL,
  `iut_owner` int(10) NOT NULL,
  `iut_mid` int(10) NOT NULL,
  `iut_tempid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_template`
--

INSERT INTO `i_user_template` (`iut_id`, `iut_owner`, `iut_mid`, `iut_tempid`) VALUES
(1, 4, 72, 168),
(2, 4, 56, 168);

-- --------------------------------------------------------

--
-- Table structure for table `i_user_transaction`
--

CREATE TABLE `i_user_transaction` (
  `iutxn_id` int(11) NOT NULL,
  `iutxn_uid` int(11) DEFAULT NULL,
  `iutxn_payment_id` varchar(100) DEFAULT NULL,
  `iutxn_timestamp` varchar(100) DEFAULT NULL,
  `iutxn_group` int(11) DEFAULT NULL,
  `iutxn_storage` int(11) DEFAULT NULL,
  `iutxn_date` datetime DEFAULT NULL,
  `iutxn_entity` varchar(100) DEFAULT NULL,
  `iutxn_amount` varchar(100) DEFAULT NULL,
  `iutxn_currency` varchar(100) DEFAULT NULL,
  `iutxn_status` varchar(100) DEFAULT NULL,
  `iutxn_order_id` varchar(100) DEFAULT NULL,
  `iutxn_invoice_id` varchar(100) DEFAULT NULL,
  `iutxn_international` varchar(100) DEFAULT NULL,
  `iutxn_method` varchar(100) DEFAULT NULL,
  `iutxn_amount_refunded` varchar(100) DEFAULT NULL,
  `iutxn_refund_status` varchar(100) DEFAULT NULL,
  `iutxn_captured` varchar(50) DEFAULT NULL,
  `iutxn_description` varchar(100) DEFAULT NULL,
  `iutxn_card_id` varchar(100) DEFAULT NULL,
  `iutxn_bank` varchar(100) DEFAULT NULL,
  `iutxn_wallet` varchar(100) DEFAULT NULL,
  `iutxn_vpa` varchar(100) DEFAULT NULL,
  `iutxn_email` varchar(100) DEFAULT NULL,
  `iutxn_contact` varchar(50) DEFAULT NULL,
  `iutxn_notes` varchar(100) DEFAULT NULL,
  `iutxn_address` varchar(100) DEFAULT NULL,
  `iutxn_fee` varchar(100) DEFAULT NULL,
  `iutxn_tax` varchar(100) DEFAULT NULL,
  `iutxn_error_code` varchar(100) DEFAULT NULL,
  `iutxn_error_description` varchar(100) DEFAULT NULL,
  `iutxn_created_at` varchar(100) DEFAULT NULL,
  `iutxn_ref_code` varchar(100) DEFAULT NULL,
  `iutxn_discount_amount` varchar(100) DEFAULT NULL,
  `iutxn_txn_type` varchar(100) DEFAULT NULL,
  `iutxn_storage_month` int(11) DEFAULT NULL,
  `iutxn_group_month` int(11) DEFAULT NULL,
  `iutxn_credit_amount` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_user_transaction`
--

INSERT INTO `i_user_transaction` (`iutxn_id`, `iutxn_uid`, `iutxn_payment_id`, `iutxn_timestamp`, `iutxn_group`, `iutxn_storage`, `iutxn_date`, `iutxn_entity`, `iutxn_amount`, `iutxn_currency`, `iutxn_status`, `iutxn_order_id`, `iutxn_invoice_id`, `iutxn_international`, `iutxn_method`, `iutxn_amount_refunded`, `iutxn_refund_status`, `iutxn_captured`, `iutxn_description`, `iutxn_card_id`, `iutxn_bank`, `iutxn_wallet`, `iutxn_vpa`, `iutxn_email`, `iutxn_contact`, `iutxn_notes`, `iutxn_address`, `iutxn_fee`, `iutxn_tax`, `iutxn_error_code`, `iutxn_error_description`, `iutxn_created_at`, `iutxn_ref_code`, `iutxn_discount_amount`, `iutxn_txn_type`, `iutxn_storage_month`, `iutxn_group_month`, `iutxn_credit_amount`) VALUES
(3, 1, 'pay_CjZEdNcomrgxjr', '11560928833', 1, 0, '2019-06-19 12:50:33', 'payment', '70800', 'INR', 'captured', NULL, NULL, '0', 'netbanking', '0', NULL, '1', 'Daifunc Components', NULL, 'KKBK', NULL, NULL, 'krishnakant@evomata.com', '+919821406714', NULL, NULL, '1670', '254', NULL, NULL, '1560928831', '4Z841', '600', 'purchase', 12, 12, '0'),
(4, 1, 'pay_CjZMo4W7Qr9n7D', '11560929297', NULL, NULL, '2019-06-19 12:58:16', 'payment', '240000', 'INR', 'captured', NULL, NULL, '0', 'netbanking', '0', NULL, '1', 'Daifunc Components', NULL, 'KKBK', NULL, NULL, 'krishnakant@evomata.com', '+919821406714', NULL, NULL, '5664', '864', NULL, NULL, '1560929295', NULL, NULL, 'add_user', NULL, NULL, '0'),
(5, 4, 'pay_CjwTKt6U9sUSy7', '41561010667', 1, 0, '2019-06-20 11:34:26', 'payment', '70800', 'INR', 'captured', NULL, NULL, '0', 'netbanking', '0', NULL, '1', 'Daifunc Components', NULL, 'SBIN', NULL, NULL, 'hitesh@evomata.com', '+919769351539', NULL, NULL, '1670', '254', NULL, NULL, '1561010663', 'EVOMATAONLY', '600', 'purchase', 12, 12, '0'),
(6, 2, '0', '0', 0, 0, '2019-06-20 14:06:38', 'payment', '0', 'INR', 'uncaptured', NULL, NULL, NULL, 'cheque', '0', NULL, '0', 'DaiFunc cheque', NULL, NULL, NULL, NULL, 'kpatole2@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1561019798', 'null', '0', 'renewal', 12, 12, '0'),
(7, 1, 'pay_Ck0KI2gHsKRofY', '11561024239', 0, 0, '2019-06-20 15:20:38', 'payment', '424800', 'INR', 'captured', NULL, NULL, '0', 'netbanking', '0', NULL, '1', 'Daifunc Components', NULL, 'KKBK', NULL, NULL, 'krishnakant@evomata.com', '+919821406714', NULL, NULL, '10026', '1530', NULL, NULL, '1561024236', '', '0', 'renewal', 12, 12, '0');

-- --------------------------------------------------------

--
-- Table structure for table `i_u_accounting`
--

CREATE TABLE `i_u_accounting` (
  `iua_id` int(11) NOT NULL,
  `iua_customer_id` int(11) DEFAULT NULL,
  `iua_start_date` date DEFAULT NULL,
  `iua_end_date` date DEFAULT NULL,
  `iua_year_code` varchar(100) DEFAULT NULL,
  `iua_status` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_accounting`
--

INSERT INTO `i_u_accounting` (`iua_id`, `iua_customer_id`, `iua_start_date`, `iua_end_date`, `iua_year_code`, `iua_status`) VALUES
(9, 188, '2018-12-01', '2019-12-01', '2018-2019', 'true'),
(20, 232, '2019-02-07', '2019-02-07', '2019-2019', NULL),
(14, 188, '2018-12-26', '2018-12-26', '2018-2018', 'false'),
(19, 231, '2019-01-31', '2019-01-31', '2019-2019', NULL),
(18, 228, '2019-01-15', '2019-01-15', '2019-2019', NULL),
(25, 5, '2019-04-15', '2019-04-15', '2019-2019', NULL),
(22, 2, '0000-00-00', '0000-00-00', '', NULL),
(23, 3, '0000-00-00', '0000-00-00', '', NULL),
(24, 1, '2018-04-01', '2019-03-31', '2018-2019', 'true'),
(26, 6, '2019-04-15', '2019-04-15', '2019-2019', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_activity_tags`
--

CREATE TABLE `i_u_activity_tags` (
  `iuat_id` int(11) NOT NULL,
  `iuat_a_id` int(11) NOT NULL,
  `iuat_t_id` int(11) NOT NULL,
  `iuat_owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_activity_tags`
--

INSERT INTO `i_u_activity_tags` (`iuat_id`, `iuat_a_id`, `iuat_t_id`, `iuat_owner`) VALUES
(1, 11, 128, 6),
(2, 37, 122, 6),
(3, 67, 152, 6),
(4, 67, 107, 6),
(5, 68, 153, 6),
(6, 69, 153, 6),
(10, 77, 109, 6),
(11, 83, 109, 6),
(12, 84, 109, 6),
(13, 84, 109, 6),
(15, 38, 159, 6),
(16, 39, 107, 6),
(20, 60, 114, 6),
(21, 60, 109, 6),
(22, 60, 157, 6),
(23, 61, 161, 6),
(24, 64, 161, 6),
(26, 391, 159, 188),
(27, 391, 132, 188),
(28, 391, 160, 188),
(29, 416, 163, 188),
(30, 416, 25, 188),
(31, 416, 41, 188),
(32, 417, 25, 188),
(33, 417, 164, 188);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_a_active_list`
--

CREATE TABLE `i_u_a_active_list` (
  `iuaal_id` int(11) NOT NULL,
  `iuaal_aid` int(11) DEFAULT NULL,
  `iuaal_owner` int(11) DEFAULT NULL,
  `iuaal_created` datetime DEFAULT NULL,
  `iuaal_created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_a_active_list`
--

INSERT INTO `i_u_a_active_list` (`iuaal_id`, `iuaal_aid`, `iuaal_owner`, `iuaal_created`, `iuaal_created_by`) VALUES
(1, 3, 1, '2019-03-08 11:44:45', 1),
(2, 46, 1, '2019-04-03 10:32:11', 1),
(3, 44, 1, '2019-04-03 12:21:40', 1),
(4, 72, 1, '2019-04-03 12:23:24', 1),
(5, 78, 2, '2019-04-04 12:19:05', 2);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_a_log`
--

CREATE TABLE `i_u_a_log` (
  `iual_id` int(11) NOT NULL,
  `iual_a_id` int(11) NOT NULL,
  `iual_owner` int(11) NOT NULL,
  `iual_created` datetime NOT NULL,
  `iual_created_by` int(11) NOT NULL,
  `iual_title` varchar(100) NOT NULL,
  `iual_comment` varchar(500) DEFAULT NULL,
  `iual_star_rating` int(11) DEFAULT NULL,
  `iual_action_taken` varchar(300) DEFAULT NULL,
  `iual_feedback_type` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_a_log`
--

INSERT INTO `i_u_a_log` (`iual_id`, `iual_a_id`, `iual_owner`, `iual_created`, `iual_created_by`, `iual_title`, `iual_comment`, `iual_star_rating`, `iual_action_taken`, `iual_feedback_type`) VALUES
(33407, 74, 1, '2019-04-04 11:18:23', 1, 'add', NULL, NULL, NULL, NULL),
(33408, 74, 1, '2019-04-04 11:18:30', 1, 'progress', 'progress', NULL, NULL, NULL),
(33409, 75, 1, '2019-04-04 11:18:39', 1, 'add', NULL, NULL, NULL, NULL),
(33410, 75, 1, '2019-04-04 11:18:42', 1, 'cancel', 'cancel', NULL, NULL, NULL),
(33411, 76, 1, '2019-04-04 11:18:50', 1, 'add', NULL, NULL, NULL, NULL),
(33412, 76, 1, '2019-04-04 11:18:51', 1, 'done', 'done', NULL, NULL, NULL),
(33413, 77, 1, '2019-04-04 11:43:55', 1, 'add', NULL, NULL, NULL, NULL),
(33414, 77, 1, '2019-04-04 11:43:57', 1, 'cancel', 'cancel', NULL, NULL, NULL),
(33415, 77, 1, '2019-04-04 11:43:59', 1, 'done', 'done', NULL, NULL, NULL),
(33416, 78, 2, '2019-04-04 12:19:02', 2, 'add', NULL, NULL, NULL, NULL),
(33417, 78, 2, '2019-04-04 12:19:06', 2, 'done', 'done', NULL, NULL, NULL),
(33418, 79, 1, '2019-04-04 12:19:34', 1, 'add', NULL, NULL, NULL, NULL),
(33419, 79, 2, '2019-04-04 12:19:41', 2, 'done', 'done', NULL, NULL, NULL),
(33420, 79, 2, '2019-04-04 12:19:54', 2, 'progress', 'progress', NULL, NULL, NULL),
(33421, 80, 1, '2019-04-04 12:26:10', 2, 'add', NULL, NULL, NULL, NULL),
(33422, 81, 1, '2019-04-04 13:14:19', 1, 'add', NULL, NULL, NULL, NULL),
(33423, 82, 3, '2019-04-04 13:37:44', 3, 'add', NULL, NULL, NULL, NULL),
(33424, 82, 3, '2019-04-04 13:37:46', 3, 'done', 'done', NULL, NULL, NULL),
(33425, 82, 3, '2019-04-04 13:37:52', 3, 'progress', 'progress', NULL, NULL, NULL),
(33426, 80, 1, '2019-04-04 13:39:57', 3, 'cancel', 'cancel', NULL, NULL, NULL),
(33427, 83, 1, '2019-04-04 13:40:09', 1, 'add', NULL, NULL, NULL, NULL),
(33428, 80, 1, '2019-04-04 14:30:13', 3, 'progress', 'progress', NULL, NULL, NULL),
(33429, 83, 1, '2019-04-04 14:55:17', 1, 'progress', 'progress', NULL, NULL, NULL),
(33430, 79, 1, '2019-04-04 14:55:22', 1, 'done', 'done', NULL, NULL, NULL),
(33431, 116, 1, '2019-04-04 17:07:52', 3, 'done', 'done', NULL, NULL, NULL),
(33432, 117, 1, '2019-04-04 17:09:38', 3, 'done', 'done', NULL, NULL, NULL),
(33433, 118, 1, '2019-04-04 17:13:20', 3, 'done', 'done', NULL, NULL, NULL),
(33434, 113, 1, '2019-04-04 17:19:14', 2, 'done', 'done', NULL, NULL, NULL),
(33435, 115, 1, '2019-04-04 18:45:03', 2, 'progress', 'progress', NULL, NULL, NULL),
(33436, 122, 1, '2019-04-08 12:16:06', 1, 'add', NULL, NULL, NULL, NULL),
(33437, 123, 1, '2019-04-08 12:16:25', 1, 'add', NULL, NULL, NULL, NULL),
(33438, 124, 1, '2019-04-08 12:16:41', 1, 'add', NULL, NULL, NULL, NULL),
(33439, 125, 1, '2019-04-08 12:16:50', 1, 'add', NULL, NULL, NULL, NULL),
(33440, 122, 1, '2019-04-08 12:17:02', 1, 'update', NULL, NULL, NULL, NULL),
(33441, 125, 1, '2019-04-08 12:17:10', 1, 'update', NULL, NULL, NULL, NULL),
(33442, 125, 1, '2019-04-08 12:39:33', 1, 'done', 'done', NULL, NULL, NULL),
(33443, 167, 2, '2019-04-18 13:36:11', 2, 'add', NULL, NULL, NULL, NULL),
(33444, 168, 2, '2019-04-18 13:36:18', 2, 'add', NULL, NULL, NULL, NULL),
(33445, 169, 2, '2019-04-18 13:36:22', 2, 'add', NULL, NULL, NULL, NULL),
(33446, 170, 2, '2019-04-18 13:36:28', 2, 'add', NULL, NULL, NULL, NULL),
(33447, 167, 2, '2019-04-18 13:36:33', 2, 'progress', 'progress', NULL, NULL, NULL),
(33448, 167, 2, '2019-04-18 13:37:04', 2, 'progress', 'progress', NULL, NULL, NULL),
(33449, 115, 2, '2019-04-18 00:00:00', 2, 'reschedule', '', NULL, NULL, NULL),
(33450, 171, 2, '2019-04-18 13:39:24', 2, 'add', NULL, NULL, NULL, NULL),
(33451, 172, 2, '2019-04-18 13:39:34', 2, 'add', NULL, NULL, NULL, NULL),
(33452, 171, 2, '2019-04-18 13:39:48', 2, 'progress', 'progress', NULL, NULL, NULL),
(33453, 167, 2, '2019-04-18 13:49:36', 2, 'done', 'done', NULL, NULL, NULL),
(33454, 168, 2, '2019-04-18 13:49:39', 2, 'progress', 'progress', NULL, NULL, NULL),
(33455, 74, 1, '2019-04-19 10:45:38', 1, 'done', 'done', NULL, NULL, NULL),
(33456, 46, 1, '2019-04-19 10:46:21', 1, 'update', NULL, NULL, NULL, NULL),
(33457, 46, 1, '2019-04-19 10:46:34', 1, 'progress', 'progress', NULL, NULL, NULL),
(33458, 46, 1, '2019-04-19 10:46:51', 1, 'done', 'test comment', NULL, NULL, NULL),
(33459, 199, 1, '2019-04-26 14:35:04', 1, 'add', NULL, NULL, NULL, NULL),
(33460, 200, 1, '2019-04-26 14:38:49', 1, 'add', NULL, NULL, NULL, NULL),
(33461, 201, 1, '2019-05-04 13:22:42', 1, 'add', NULL, NULL, NULL, NULL),
(33462, 201, 2, '2019-05-04 13:23:51', 2, 'progress', 'Doing work', NULL, NULL, NULL),
(33463, 168, 2, '2019-05-04 13:23:53', 2, 'done', 'done', NULL, NULL, NULL),
(33464, 201, 2, '2019-05-04 14:04:50', 2, 'done', 'work done', 5, NULL, NULL),
(33465, 202, 1, '2019-05-06 15:47:19', 1, 'add', NULL, NULL, NULL, NULL),
(33466, 202, 2, '2019-05-07 12:09:21', 2, 'progress', 'Work start', NULL, NULL, NULL),
(33467, 202, 2, '2019-05-07 00:00:00', 2, 'reschedule', 'reschedule', NULL, NULL, NULL),
(33468, 202, 2, '2019-05-07 00:00:00', 2, 'reschedule', 'reschedule', NULL, NULL, NULL),
(33469, 219, 1, '2019-05-08 10:47:59', 1, 'add', NULL, NULL, NULL, NULL),
(33470, 220, 1, '2019-05-08 11:01:05', 1, 'add', NULL, NULL, NULL, NULL),
(33471, 221, 1, '2019-05-08 11:01:54', 1, 'add', NULL, NULL, NULL, NULL),
(33472, 222, 1, '2019-05-08 11:03:50', 1, 'add', NULL, NULL, NULL, NULL),
(33473, 222, 1, '2019-05-08 11:04:48', 1, 'update', NULL, NULL, NULL, NULL),
(33474, 222, 1, '2019-05-08 11:57:45', 1, 'progress', 'start work', NULL, NULL, NULL),
(33475, 222, 1, '2019-05-08 12:40:11', 1, 'done', 'well done', 4, 'Action taken', NULL),
(33476, 222, 1, '2019-05-08 14:19:43', 1, 'progress', 'start work', NULL, NULL, NULL),
(33477, 224, 1, '2019-05-08 14:26:48', 1, 'add', NULL, NULL, NULL, NULL),
(33478, 224, 1, '2019-05-08 14:26:59', 1, 'progress', 'progress', NULL, NULL, NULL),
(33479, 224, 1, '2019-05-08 00:00:00', 1, 'reschedule', '', NULL, NULL, NULL),
(33480, 224, 1, '2019-05-08 14:49:44', 1, 'done', NULL, NULL, NULL, 'true'),
(33481, 224, 1, '2019-05-08 14:52:02', 1, 'progress', 'progress', NULL, NULL, NULL),
(33482, 224, 1, '2019-05-08 14:56:49', 1, 'done', NULL, NULL, NULL, 'true'),
(33483, 224, 1, '2019-05-08 14:57:28', 1, 'progress', 'progress', NULL, NULL, NULL),
(33484, 224, 1, '2019-05-08 15:06:16', 1, 'done', NULL, NULL, 'welcome', 'true'),
(33485, 1, 1, '2019-05-08 15:40:06', 1, 'add', NULL, NULL, NULL, NULL),
(33486, 1, 1, '2019-05-08 15:40:23', 1, 'progress', 'progress', NULL, NULL, NULL),
(33487, 1, 1, '2019-05-08 15:40:37', 1, 'done', 'well done good work', 5, 'work 1 done work 2 done', 'true'),
(33488, 2, 1, '2019-05-08 15:42:56', 1, 'add', NULL, NULL, NULL, NULL),
(33489, 2, 1, '2019-05-08 15:43:30', 1, 'done', NULL, NULL, 'work 1 done', 'true'),
(33490, 3, 1, '2019-05-08 15:56:59', 1, 'add', NULL, NULL, NULL, NULL),
(33491, 4, 1, '2019-05-08 15:59:58', 1, 'add', NULL, NULL, NULL, NULL),
(33492, 4, 2, '2019-05-08 17:04:32', 2, 'progress', 'progress', NULL, NULL, NULL),
(33493, 5, 1, '2019-05-09 15:08:14', 1, 'add', NULL, NULL, NULL, NULL),
(33494, 6, 1, '2019-05-11 12:45:26', 1, 'add', NULL, NULL, NULL, NULL),
(33495, 6, 1, '2019-05-11 12:45:58', 2, 'progress', 'progress', NULL, NULL, NULL),
(33496, 6, 1, '2019-05-11 13:15:09', 2, 'done', 'well done bro', 5, 'done work', 'true'),
(33497, 2, 1, '2019-05-21 11:33:50', 1, 'cancel', 'asdasd', NULL, NULL, NULL),
(33498, 109, 1, '2019-05-27 11:41:25', 1, 'add', NULL, NULL, NULL, NULL),
(33499, 115, 1, '2019-05-27 12:56:07', 1, 'add', NULL, NULL, NULL, NULL),
(33500, 125, 1, '2019-05-27 17:33:43', 1, 'add', NULL, NULL, NULL, NULL),
(33501, 125, 1, '2019-05-27 17:34:43', 1, 'update', NULL, NULL, NULL, NULL),
(33502, 125, 1, '2019-05-27 17:38:45', 1, 'update', NULL, NULL, NULL, NULL),
(33503, 126, 1, '2019-05-27 17:47:24', 1, 'add', NULL, NULL, NULL, NULL),
(33504, 127, 1, '2019-05-27 18:13:56', 1, 'add', NULL, NULL, NULL, NULL),
(33505, 128, 1, '2019-05-27 18:19:19', 1, 'add', NULL, NULL, NULL, NULL),
(33506, 130, 1, '2019-05-31 13:04:02', 1, 'add', NULL, NULL, NULL, NULL),
(33507, 131, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33508, 132, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33509, 133, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33510, 134, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33511, 135, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33512, 136, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33513, 137, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33514, 138, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33515, 139, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33516, 140, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33517, 141, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33518, 142, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33519, 143, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33520, 144, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33521, 145, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33522, 146, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33523, 147, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33524, 148, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33525, 149, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33526, 150, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33527, 151, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33528, 152, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33529, 153, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33530, 154, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33531, 155, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33532, 156, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33533, 157, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33534, 158, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33535, 159, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33536, 160, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33537, 161, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33538, 162, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33539, 163, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33540, 164, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33541, 165, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33542, 166, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33543, 167, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33544, 168, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33545, 169, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33546, 170, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33547, 171, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33548, 172, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33549, 173, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33550, 174, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33551, 175, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33552, 176, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33553, 177, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33554, 178, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33555, 179, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33556, 180, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33557, 181, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33558, 182, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33559, 183, 1, '2019-05-31 13:15:20', 2, 'add', NULL, NULL, NULL, NULL),
(33560, 131, 1, '2019-05-31 13:15:27', 2, 'progress', 'progress', NULL, NULL, NULL),
(33561, 131, 1, '2019-05-31 13:15:35', 2, 'done', 'done', NULL, NULL, NULL),
(33562, 131, 1, '2019-05-31 13:15:38', 2, 'cancel', 'cancel', NULL, NULL, NULL),
(33563, 131, 1, '2019-05-31 13:15:40', 2, 'cancel', 'cancel', NULL, NULL, NULL),
(33564, 131, 1, '2019-05-31 13:15:41', 2, 'cancel', 'cancel', NULL, NULL, NULL),
(33565, 184, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33566, 185, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33567, 186, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33568, 187, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33569, 188, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33570, 189, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33571, 190, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33572, 191, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33573, 192, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33574, 193, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33575, 194, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33576, 195, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33577, 196, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33578, 197, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33579, 198, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33580, 199, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33581, 200, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33582, 201, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33583, 202, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33584, 203, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33585, 204, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33586, 205, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33587, 206, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33588, 207, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33589, 208, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33590, 209, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33591, 210, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33592, 211, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33593, 212, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33594, 213, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33595, 214, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33596, 215, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33597, 216, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33598, 217, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33599, 218, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33600, 219, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33601, 220, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33602, 221, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33603, 222, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33604, 223, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33605, 224, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33606, 225, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33607, 226, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33608, 227, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33609, 228, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33610, 229, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33611, 230, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33612, 231, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33613, 232, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33614, 233, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33615, 234, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33616, 235, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33617, 236, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33618, 237, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33619, 238, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33620, 239, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33621, 240, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33622, 241, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33623, 242, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33624, 243, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33625, 244, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33626, 245, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33627, 246, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33628, 247, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33629, 248, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33630, 249, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33631, 250, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33632, 251, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33633, 252, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33634, 253, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33635, 254, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33636, 255, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33637, 256, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33638, 257, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33639, 258, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33640, 259, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33641, 260, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33642, 261, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33643, 262, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33644, 263, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33645, 264, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33646, 265, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33647, 266, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33648, 267, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33649, 268, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33650, 269, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33651, 270, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33652, 271, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33653, 272, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33654, 273, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33655, 274, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33656, 275, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33657, 276, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33658, 277, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33659, 278, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33660, 279, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33661, 280, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33662, 281, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33663, 282, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33664, 283, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33665, 284, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33666, 285, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33667, 286, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33668, 287, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33669, 288, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33670, 289, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33671, 290, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33672, 291, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33673, 292, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33674, 293, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33675, 294, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33676, 295, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33677, 296, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33678, 297, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33679, 298, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33680, 299, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33681, 300, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33682, 301, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33683, 302, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33684, 303, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33685, 304, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33686, 305, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33687, 306, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33688, 307, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33689, 308, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33690, 309, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33691, 310, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33692, 311, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33693, 312, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33694, 313, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33695, 314, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33696, 315, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33697, 316, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33698, 317, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33699, 318, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33700, 319, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33701, 320, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33702, 321, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33703, 322, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33704, 323, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33705, 324, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33706, 325, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33707, 326, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33708, 327, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33709, 328, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33710, 329, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33711, 330, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33712, 331, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33713, 332, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33714, 333, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33715, 334, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33716, 335, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33717, 336, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33718, 337, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33719, 338, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33720, 339, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33721, 340, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33722, 341, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33723, 342, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33724, 343, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33725, 344, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33726, 345, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33727, 346, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33728, 347, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33729, 348, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33730, 349, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33731, 350, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33732, 351, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33733, 352, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33734, 353, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33735, 354, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33736, 355, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33737, 356, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33738, 357, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33739, 358, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33740, 359, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33741, 360, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33742, 361, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33743, 362, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33744, 363, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33745, 364, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33746, 365, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33747, 366, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33748, 367, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33749, 368, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33750, 369, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33751, 370, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33752, 371, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33753, 372, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33754, 373, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33755, 374, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33756, 375, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33757, 376, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33758, 377, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33759, 378, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33760, 379, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33761, 380, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33762, 381, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33763, 382, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33764, 383, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33765, 384, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33766, 385, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33767, 386, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33768, 387, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33769, 388, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33770, 389, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33771, 390, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33772, 391, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33773, 392, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33774, 393, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33775, 394, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33776, 395, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33777, 396, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33778, 397, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33779, 398, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33780, 399, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33781, 400, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33782, 401, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33783, 402, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33784, 403, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33785, 404, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33786, 405, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33787, 406, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33788, 407, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33789, 408, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33790, 409, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33791, 410, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33792, 411, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33793, 412, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33794, 413, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33795, 414, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33796, 415, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33797, 416, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33798, 417, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33799, 418, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33800, 419, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33801, 420, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33802, 421, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33803, 422, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33804, 423, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33805, 424, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33806, 425, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33807, 426, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33808, 427, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33809, 428, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33810, 429, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33811, 430, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33812, 431, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33813, 432, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33814, 433, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33815, 434, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33816, 435, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33817, 436, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33818, 437, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33819, 438, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33820, 439, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33821, 440, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33822, 441, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33823, 442, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33824, 443, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33825, 444, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33826, 445, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33827, 446, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33828, 447, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33829, 448, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33830, 449, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33831, 450, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33832, 451, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33833, 452, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33834, 453, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33835, 454, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33836, 455, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33837, 456, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33838, 457, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33839, 458, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33840, 459, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33841, 460, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33842, 461, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33843, 462, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33844, 463, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33845, 464, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33846, 465, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33847, 466, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33848, 467, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33849, 468, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33850, 469, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33851, 470, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33852, 471, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33853, 472, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33854, 473, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33855, 474, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33856, 475, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33857, 476, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33858, 477, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33859, 478, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33860, 479, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33861, 480, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33862, 481, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33863, 482, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33864, 483, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33865, 484, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33866, 485, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33867, 486, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33868, 487, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33869, 488, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33870, 489, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33871, 490, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33872, 491, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33873, 492, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33874, 493, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33875, 494, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33876, 495, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33877, 496, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33878, 497, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33879, 498, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33880, 499, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33881, 500, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33882, 501, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33883, 502, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33884, 503, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33885, 504, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33886, 505, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33887, 506, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33888, 507, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33889, 508, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33890, 509, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33891, 510, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33892, 511, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33893, 512, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33894, 513, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33895, 514, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33896, 515, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33897, 516, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33898, 517, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33899, 518, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33900, 519, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33901, 520, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33902, 521, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33903, 522, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33904, 523, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33905, 524, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33906, 525, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33907, 526, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33908, 527, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33909, 528, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33910, 529, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33911, 530, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33912, 531, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33913, 532, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33914, 533, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33915, 534, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33916, 535, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33917, 536, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33918, 537, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33919, 538, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33920, 539, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33921, 540, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33922, 541, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33923, 542, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33924, 543, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33925, 544, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33926, 545, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33927, 546, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33928, 547, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33929, 548, 2, '2019-05-31 13:19:14', 2, 'add', NULL, NULL, NULL, NULL),
(33930, 549, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33931, 550, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33932, 551, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33933, 552, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33934, 553, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33935, 554, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33936, 555, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33937, 556, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33938, 557, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33939, 558, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33940, 559, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33941, 560, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33942, 561, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33943, 562, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33944, 563, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33945, 564, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33946, 565, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33947, 566, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33948, 567, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33949, 568, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33950, 569, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33951, 570, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33952, 571, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33953, 572, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33954, 573, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33955, 574, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33956, 575, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33957, 576, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33958, 577, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33959, 578, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33960, 579, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33961, 580, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33962, 581, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33963, 582, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33964, 583, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33965, 584, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33966, 585, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33967, 586, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33968, 587, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33969, 588, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33970, 589, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33971, 590, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33972, 591, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33973, 592, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33974, 593, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33975, 594, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33976, 595, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33977, 596, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33978, 597, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33979, 598, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33980, 599, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33981, 600, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33982, 601, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33983, 602, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33984, 603, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33985, 604, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33986, 605, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33987, 606, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33988, 607, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33989, 608, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33990, 609, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33991, 610, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33992, 611, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33993, 612, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33994, 613, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33995, 614, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33996, 615, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33997, 616, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33998, 617, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(33999, 618, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34000, 619, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34001, 620, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34002, 621, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34003, 622, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34004, 623, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34005, 624, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34006, 625, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34007, 626, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34008, 627, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34009, 628, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34010, 629, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34011, 630, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34012, 631, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34013, 632, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34014, 633, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34015, 634, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34016, 635, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34017, 636, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34018, 637, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34019, 638, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34020, 639, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34021, 640, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34022, 641, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34023, 642, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34024, 643, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34025, 644, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34026, 645, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34027, 646, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34028, 647, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34029, 648, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34030, 649, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34031, 650, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34032, 651, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34033, 652, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34034, 653, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34035, 654, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34036, 655, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34037, 656, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34038, 657, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34039, 658, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34040, 659, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34041, 660, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34042, 661, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34043, 662, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34044, 663, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34045, 664, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34046, 665, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34047, 666, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34048, 667, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34049, 668, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34050, 669, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34051, 670, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34052, 671, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34053, 672, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34054, 673, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34055, 674, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34056, 675, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34057, 676, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34058, 677, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34059, 678, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34060, 679, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34061, 680, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34062, 681, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34063, 682, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34064, 683, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34065, 684, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34066, 685, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34067, 686, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34068, 687, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34069, 688, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34070, 689, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34071, 690, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34072, 691, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34073, 692, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34074, 693, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34075, 694, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34076, 695, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34077, 696, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34078, 697, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34079, 698, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34080, 699, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34081, 700, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34082, 701, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34083, 702, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34084, 703, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34085, 704, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34086, 705, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34087, 706, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34088, 707, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34089, 708, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34090, 709, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34091, 710, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL);
INSERT INTO `i_u_a_log` (`iual_id`, `iual_a_id`, `iual_owner`, `iual_created`, `iual_created_by`, `iual_title`, `iual_comment`, `iual_star_rating`, `iual_action_taken`, `iual_feedback_type`) VALUES
(34092, 711, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34093, 712, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34094, 713, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34095, 714, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34096, 715, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34097, 716, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34098, 717, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34099, 718, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34100, 719, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34101, 720, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34102, 721, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34103, 722, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34104, 723, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34105, 724, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34106, 725, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34107, 726, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34108, 727, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34109, 728, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34110, 729, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34111, 730, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34112, 731, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34113, 732, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34114, 733, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34115, 734, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34116, 735, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34117, 736, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34118, 737, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34119, 738, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34120, 739, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34121, 740, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34122, 741, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34123, 742, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34124, 743, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34125, 744, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34126, 745, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34127, 746, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34128, 747, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34129, 748, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34130, 749, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34131, 750, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34132, 751, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34133, 752, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34134, 753, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34135, 754, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34136, 755, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34137, 756, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34138, 757, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34139, 758, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34140, 759, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34141, 760, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34142, 761, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34143, 762, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34144, 763, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34145, 764, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34146, 765, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34147, 766, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34148, 767, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34149, 768, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34150, 769, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34151, 770, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34152, 771, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34153, 772, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34154, 773, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34155, 774, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34156, 775, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34157, 776, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34158, 777, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34159, 778, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34160, 779, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34161, 780, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34162, 781, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34163, 782, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34164, 783, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34165, 784, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34166, 785, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34167, 786, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34168, 787, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34169, 788, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34170, 789, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34171, 790, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34172, 791, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34173, 792, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34174, 793, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34175, 794, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34176, 795, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34177, 796, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34178, 797, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34179, 798, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34180, 799, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34181, 800, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34182, 801, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34183, 802, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34184, 803, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34185, 804, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34186, 805, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34187, 806, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34188, 807, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34189, 808, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34190, 809, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34191, 810, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34192, 811, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34193, 812, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34194, 813, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34195, 814, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34196, 815, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34197, 816, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34198, 817, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34199, 818, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34200, 819, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34201, 820, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34202, 821, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34203, 822, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34204, 823, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34205, 824, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34206, 825, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34207, 826, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34208, 827, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34209, 828, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34210, 829, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34211, 830, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34212, 831, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34213, 832, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34214, 833, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34215, 834, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34216, 835, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34217, 836, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34218, 837, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34219, 838, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34220, 839, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34221, 840, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34222, 841, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34223, 842, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34224, 843, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34225, 844, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34226, 845, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34227, 846, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34228, 847, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34229, 848, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34230, 849, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34231, 850, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34232, 851, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34233, 852, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34234, 853, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34235, 854, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34236, 855, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34237, 856, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34238, 857, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34239, 858, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34240, 859, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34241, 860, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34242, 861, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34243, 862, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34244, 863, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34245, 864, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34246, 865, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34247, 866, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34248, 867, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34249, 868, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34250, 869, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34251, 870, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34252, 871, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34253, 872, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34254, 873, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34255, 874, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34256, 875, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34257, 876, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34258, 877, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34259, 878, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34260, 879, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34261, 880, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34262, 881, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34263, 882, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34264, 883, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34265, 884, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34266, 885, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34267, 886, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34268, 887, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34269, 888, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34270, 889, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34271, 890, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34272, 891, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34273, 892, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34274, 893, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34275, 894, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34276, 895, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34277, 896, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34278, 897, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34279, 898, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34280, 899, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34281, 900, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34282, 901, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34283, 902, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34284, 903, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34285, 904, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34286, 905, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34287, 906, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34288, 907, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34289, 908, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34290, 909, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34291, 910, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34292, 911, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34293, 912, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34294, 913, 2, '2019-05-31 13:19:18', 2, 'add', NULL, NULL, NULL, NULL),
(34295, 914, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34296, 915, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34297, 916, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34298, 917, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34299, 918, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34300, 919, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34301, 920, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34302, 921, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34303, 922, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34304, 923, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34305, 924, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34306, 925, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34307, 926, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34308, 927, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34309, 928, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34310, 929, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34311, 930, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34312, 931, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34313, 932, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34314, 933, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34315, 934, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34316, 935, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34317, 936, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34318, 937, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34319, 938, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34320, 939, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34321, 940, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34322, 941, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34323, 942, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34324, 943, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34325, 944, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34326, 945, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34327, 946, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34328, 947, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34329, 948, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34330, 949, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34331, 950, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34332, 951, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34333, 952, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34334, 953, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34335, 954, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34336, 955, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34337, 956, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34338, 957, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34339, 958, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34340, 959, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34341, 960, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34342, 961, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34343, 962, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34344, 963, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34345, 964, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34346, 965, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34347, 966, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34348, 967, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34349, 968, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34350, 969, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34351, 970, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34352, 971, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34353, 972, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34354, 973, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34355, 974, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34356, 975, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34357, 976, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34358, 977, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34359, 978, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34360, 979, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34361, 980, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34362, 981, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34363, 982, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34364, 983, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34365, 984, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34366, 985, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34367, 986, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34368, 987, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34369, 988, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34370, 989, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34371, 990, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34372, 991, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34373, 992, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34374, 993, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34375, 994, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34376, 995, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34377, 996, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34378, 997, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34379, 998, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34380, 999, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34381, 1000, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34382, 1001, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34383, 1002, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34384, 1003, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34385, 1004, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34386, 1005, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34387, 1006, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34388, 1007, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34389, 1008, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34390, 1009, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34391, 1010, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34392, 1011, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34393, 1012, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34394, 1013, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34395, 1014, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34396, 1015, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34397, 1016, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34398, 1017, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34399, 1018, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34400, 1019, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34401, 1020, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34402, 1021, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34403, 1022, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34404, 1023, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34405, 1024, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34406, 1025, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34407, 1026, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34408, 1027, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34409, 1028, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34410, 1029, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34411, 1030, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34412, 1031, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34413, 1032, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34414, 1033, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34415, 1034, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34416, 1035, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34417, 1036, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34418, 1037, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34419, 1038, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34420, 1039, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34421, 1040, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34422, 1041, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34423, 1042, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34424, 1043, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34425, 1044, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34426, 1045, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34427, 1046, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34428, 1047, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34429, 1048, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34430, 1049, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34431, 1050, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34432, 1051, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34433, 1052, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34434, 1053, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34435, 1054, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34436, 1055, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34437, 1056, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34438, 1057, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34439, 1058, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34440, 1059, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34441, 1060, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34442, 1061, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34443, 1062, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34444, 1063, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34445, 1064, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34446, 1065, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34447, 1066, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34448, 1067, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34449, 1068, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34450, 1069, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34451, 1070, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34452, 1071, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34453, 1072, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34454, 1073, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34455, 1074, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34456, 1075, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34457, 1076, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34458, 1077, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34459, 1078, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34460, 1079, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34461, 1080, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34462, 1081, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34463, 1082, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34464, 1083, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34465, 1084, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34466, 1085, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34467, 1086, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34468, 1087, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34469, 1088, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34470, 1089, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34471, 1090, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34472, 1091, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34473, 1092, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34474, 1093, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34475, 1094, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34476, 1095, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34477, 1096, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34478, 1097, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34479, 1098, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34480, 1099, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34481, 1100, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34482, 1101, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34483, 1102, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34484, 1103, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34485, 1104, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34486, 1105, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34487, 1106, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34488, 1107, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34489, 1108, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34490, 1109, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34491, 1110, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34492, 1111, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34493, 1112, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34494, 1113, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34495, 1114, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34496, 1115, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34497, 1116, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34498, 1117, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34499, 1118, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34500, 1119, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34501, 1120, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34502, 1121, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34503, 1122, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34504, 1123, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34505, 1124, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34506, 1125, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34507, 1126, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34508, 1127, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34509, 1128, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34510, 1129, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34511, 1130, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34512, 1131, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34513, 1132, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34514, 1133, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34515, 1134, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34516, 1135, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34517, 1136, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34518, 1137, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34519, 1138, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34520, 1139, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34521, 1140, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34522, 1141, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34523, 1142, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34524, 1143, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34525, 1144, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34526, 1145, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34527, 1146, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34528, 1147, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34529, 1148, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34530, 1149, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34531, 1150, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34532, 1151, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34533, 1152, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34534, 1153, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34535, 1154, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34536, 1155, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34537, 1156, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34538, 1157, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34539, 1158, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34540, 1159, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34541, 1160, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34542, 1161, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34543, 1162, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34544, 1163, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34545, 1164, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34546, 1165, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34547, 1166, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34548, 1167, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34549, 1168, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34550, 1169, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34551, 1170, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34552, 1171, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34553, 1172, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34554, 1173, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34555, 1174, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34556, 1175, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34557, 1176, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34558, 1177, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34559, 1178, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34560, 1179, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34561, 1180, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34562, 1181, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34563, 1182, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34564, 1183, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34565, 1184, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34566, 1185, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34567, 1186, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34568, 1187, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34569, 1188, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34570, 1189, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34571, 1190, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34572, 1191, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34573, 1192, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34574, 1193, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34575, 1194, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34576, 1195, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34577, 1196, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34578, 1197, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34579, 1198, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34580, 1199, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34581, 1200, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34582, 1201, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34583, 1202, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34584, 1203, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34585, 1204, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34586, 1205, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34587, 1206, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34588, 1207, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34589, 1208, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34590, 1209, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34591, 1210, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34592, 1211, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34593, 1212, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34594, 1213, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34595, 1214, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34596, 1215, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34597, 1216, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34598, 1217, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34599, 1218, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34600, 1219, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34601, 1220, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34602, 1221, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34603, 1222, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34604, 1223, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34605, 1224, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34606, 1225, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34607, 1226, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34608, 1227, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34609, 1228, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34610, 1229, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34611, 1230, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34612, 1231, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34613, 1232, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34614, 1233, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34615, 1234, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34616, 1235, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34617, 1236, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34618, 1237, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34619, 1238, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34620, 1239, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34621, 1240, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34622, 1241, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34623, 1242, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34624, 1243, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34625, 1244, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34626, 1245, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34627, 1246, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34628, 1247, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34629, 1248, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34630, 1249, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34631, 1250, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34632, 1251, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34633, 1252, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34634, 1253, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34635, 1254, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34636, 1255, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34637, 1256, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34638, 1257, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34639, 1258, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34640, 1259, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34641, 1260, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34642, 1261, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34643, 1262, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34644, 1263, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34645, 1264, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34646, 1265, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34647, 1266, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34648, 1267, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34649, 1268, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34650, 1269, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34651, 1270, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34652, 1271, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34653, 1272, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34654, 1273, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34655, 1274, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34656, 1275, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34657, 1276, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34658, 1277, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34659, 1278, 2, '2019-05-31 13:19:22', 2, 'add', NULL, NULL, NULL, NULL),
(34660, 549, 2, '2019-05-31 13:19:43', 2, 'cancel', 'cancel', NULL, NULL, NULL),
(34661, 549, 2, '2019-05-31 13:19:47', 2, 'cancel', 'cancel', NULL, NULL, NULL),
(34662, 130, 1, '2019-05-31 17:19:03', 1, 'cancel', 'cancel', NULL, NULL, NULL),
(34663, 1296, 19, '2019-06-10 15:36:49', 19, 'add', NULL, NULL, NULL, NULL),
(34664, 6, 4, '2019-06-20 11:46:18', 4, 'add', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_a_person`
--

CREATE TABLE `i_u_a_person` (
  `iuap_id` int(11) NOT NULL,
  `iuap_a_id` int(11) DEFAULT NULL,
  `iuap_p_id` int(11) DEFAULT NULL,
  `iuap_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_a_person`
--

INSERT INTO `i_u_a_person` (`iuap_id`, `iuap_a_id`, `iuap_p_id`, `iuap_owner`) VALUES
(3, 40, 1, 1),
(6, 43, 2, 1),
(7, 44, 2, 1),
(8, 47, 2, 1),
(9, 48, 2, 1),
(10, 49, 2, 1),
(11, 50, 1, 1),
(12, 51, 1, 1),
(13, 54, 1, 1),
(14, 55, 1, 1),
(15, 56, 1, 1),
(16, 57, 2, 1),
(17, 58, 2, 1),
(18, 59, 2, 1),
(19, 60, 2, 1),
(20, 61, 2, 1),
(21, 62, 2, 1),
(22, 63, 2, 1),
(23, 64, 2, 1),
(24, 65, 2, 1),
(25, 66, 2, 1),
(26, 67, 2, 1),
(27, 68, 2, 1),
(28, 69, 2, 1),
(29, 70, 2, 1),
(30, 71, 1, 1),
(31, 39, 1, 1),
(32, 72, 1, 1),
(33, 79, 2, 1),
(34, 120, 1, 1),
(35, 121, 1, 1),
(36, 126, 1, 1),
(37, 127, 1, 1),
(38, 128, 1, 1),
(39, 129, 1, 1),
(40, 130, 1, 1),
(41, 131, 1, 1),
(42, 132, 1, 1),
(43, 133, 1, 1),
(44, 134, 1, 1),
(45, 135, 1, 1),
(46, 136, 1, 1),
(47, 137, 1, 1),
(48, 138, 1, 1),
(49, 139, 1, 1),
(50, 140, 1, 1),
(51, 141, 1, 1),
(52, 142, 1, 1),
(53, 143, 1, 1),
(54, 144, 1, 1),
(55, 145, 1, 1),
(56, 146, 1, 1),
(57, 147, 1, 1),
(58, 148, 1, 1),
(59, 149, 1, 1),
(60, 150, 1, 1),
(61, 151, 1, 1),
(62, 152, 1, 1),
(63, 153, 2, 1),
(64, 154, 2, 1),
(65, 155, 1, 1),
(66, 156, 1, 1),
(67, 157, 1, 1),
(68, 158, 1, 1),
(69, 159, 1, 1),
(70, 160, 1, 1),
(71, 161, 1, 1),
(72, 162, 1, 1),
(73, 163, 1, 1),
(74, 164, 1, 1),
(75, 165, 1, 1),
(76, 166, 1, 1),
(77, 188, 2, 1),
(78, 189, 2, 1),
(79, 190, 1, 1),
(80, 191, 1, 1),
(81, 192, 1, 1),
(82, 193, 1, 1),
(83, 194, 1, 1),
(84, 195, 1, 1),
(85, 196, 1, 1),
(86, 197, 1, 1),
(87, 198, 1, 1),
(88, 200, 1, 1),
(89, 201, 2, 1),
(90, 202, 2, 1),
(91, 203, 1, 1),
(92, 204, 1, 1),
(93, 205, 1, 1),
(94, 206, 1, 1),
(95, 207, 1, 1),
(96, 208, 2, 1),
(97, 209, 1, 1),
(98, 210, 2, 1),
(99, 211, 1, 1),
(100, 212, 1, 1),
(101, 213, 1, 1),
(102, 214, 1, 1),
(103, 215, 1, 1),
(104, 216, 1, 1),
(105, 217, 1, 1),
(106, 218, 1, 1),
(107, 222, 2, 1),
(108, 223, 1, 1),
(109, 224, 1, 1),
(110, 2, 1, 1),
(111, 3, 2, 1),
(112, 4, 2, 1),
(113, 5, 2, 1),
(114, 6, 2, 1),
(115, 7, 2, 1),
(116, 8, 2, 1),
(117, 9, 1, 1),
(118, 10, 1, 1),
(119, 11, 1, 1),
(120, 12, 1, 1),
(121, 13, 2, 1),
(122, 14, 2, 1),
(123, 15, 2, 1),
(124, 16, 84, 1),
(125, 17, 2, 1),
(126, 18, 2, 1),
(127, 19, 92, 1),
(128, 20, 2, 1),
(129, 21, 1, 1),
(130, 22, 1, 1),
(131, 23, 1, 1),
(132, 24, 1, 1),
(133, 25, 1, 1),
(134, 26, 1, 1),
(135, 27, 1, 1),
(136, 28, 1, 1),
(137, 29, 1, 1),
(138, 30, 1, 1),
(139, 31, 1, 1),
(140, 32, 92, 1),
(141, 33, 92, 1),
(142, 34, 1, 1),
(143, 35, 1, 1),
(144, 36, 2, 1),
(145, 37, 1, 1),
(146, 38, 1, 1),
(147, 39, 2, 1),
(148, 40, 2, 1),
(149, 41, 108, 1),
(150, 42, 109, 1),
(151, 43, 110, 1),
(152, 44, 111, 1),
(153, 45, 110, 1),
(154, 46, 110, 1),
(155, 47, 111, 1),
(156, 48, 2, 1),
(157, 49, 2, 1),
(158, 50, 1, 1),
(159, 51, 1, 1),
(160, 52, 1, 1),
(161, 53, 1, 1),
(162, 54, 1, 1),
(163, 55, 1, 1),
(164, 56, 1, 1),
(165, 57, 1, 1),
(166, 58, 1, 1),
(167, 59, 1, 1),
(168, 60, 1, 1),
(169, 61, 1, 1),
(170, 62, 1, 1),
(171, 63, 1, 1),
(172, 64, 112, 1),
(173, 65, 1, 1),
(174, 66, 110, 1),
(175, 67, 113, 1),
(176, 68, 110, 1),
(177, 69, 1, 1),
(178, 70, 110, 1),
(179, 71, 113, 1),
(180, 72, 110, 1),
(181, 73, 113, 1),
(182, 74, 110, 1),
(183, 75, 110, 1),
(184, 76, 113, 1),
(185, 77, 1, 1),
(186, 78, 1, 1),
(187, 79, 1, 1),
(188, 80, 1, 1),
(189, 81, 1, 1),
(190, 82, 1, 1),
(191, 83, 1, 1),
(192, 84, 1, 1),
(193, 85, 1, 1),
(194, 86, 1, 1),
(195, 87, 1, 1),
(196, 88, 1, 1),
(197, 89, 110, 1),
(198, 90, 110, 1),
(199, 91, 110, 1),
(200, 92, 110, 1),
(201, 93, 110, 1),
(202, 94, 110, 1),
(203, 95, 1, 1),
(204, 96, NULL, 1),
(205, 97, NULL, 1),
(206, 98, 110, 1),
(207, 99, 110, 1),
(208, 100, 110, 1),
(209, 101, 110, 1),
(210, 102, 110, 1),
(211, 103, 110, 1),
(212, 104, 110, 1),
(213, 105, 110, 1),
(214, 106, 110, 1),
(215, 107, 110, 1),
(216, 108, 110, 1),
(217, 110, 110, 1),
(218, 111, 110, 1),
(219, 112, NULL, 1),
(220, 113, NULL, 1),
(221, 114, 110, 1),
(222, 116, 110, 1),
(223, 117, 110, 1),
(224, 118, 110, 1),
(225, 119, 110, 1),
(226, 120, 1, 1),
(227, 121, 1, 1),
(228, 122, 1, 1),
(229, 123, 110, 1),
(230, 124, 111, 1),
(231, 129, 111, 1),
(232, 1279, 121, 19),
(233, 1280, 121, 19),
(234, 1281, 121, 19),
(235, 1282, 121, 19),
(236, 1283, 121, 19),
(237, 1284, 121, 19),
(238, 1285, 121, 19),
(239, 1286, 121, 19),
(240, 1287, 121, 19),
(241, 1288, 121, 19),
(242, 1289, 121, 19),
(243, 1290, 121, 19),
(244, 1291, 134, 19),
(245, 1292, 134, 19),
(246, 1293, 121, 19),
(247, 1294, 134, 19),
(248, 1295, 134, 19),
(249, 1297, 121, 19),
(250, 1298, 134, 19),
(251, 1299, 121, 19),
(252, 1300, 138, 19),
(253, 1301, 138, 19),
(254, 1302, 138, 19),
(255, 1303, 138, 19),
(256, 1304, 121, 19),
(257, 1305, 121, 19),
(258, 1306, 138, 19),
(259, 1307, 121, 19),
(260, 1308, 138, 19),
(261, 1309, 121, 19),
(262, 1310, 121, 19),
(263, 1311, 121, 19),
(264, 1312, 138, 19),
(265, 1313, 134, 19),
(266, 1314, 134, 19),
(267, 1315, 134, 19),
(268, 1316, 138, 19),
(269, 1317, NULL, 19),
(270, 1318, NULL, 19),
(271, 1319, NULL, 19),
(272, 1320, NULL, 19),
(273, 1321, NULL, 19),
(274, 1322, NULL, 19),
(275, 1323, NULL, 19),
(276, 1324, NULL, 19),
(277, 1325, NULL, 19),
(278, 1326, NULL, 19),
(279, 1327, NULL, 19),
(280, 1328, NULL, 19),
(281, 1329, 138, 19),
(282, 1330, 138, 19),
(283, 1331, 138, 19),
(284, 1332, 138, 19),
(285, 1333, 138, 19),
(286, 1334, 138, 19),
(287, 1335, 138, 19),
(288, 1336, 138, 19),
(289, 1337, 138, 19),
(290, 1338, 138, 19),
(291, 1339, 138, 19),
(292, 1340, 121, 19),
(293, 1341, 140, 19),
(294, 1342, 141, 19),
(295, 1343, 142, 19),
(296, 1344, 143, 19),
(297, 1345, 0, 19),
(298, 1346, 0, 19),
(299, 1347, 144, 19),
(300, 1348, 145, 19),
(301, 1349, 146, 19),
(302, 1350, 147, 19),
(303, 1351, 0, 19),
(304, 1352, 0, 19),
(305, 1353, 134, 19),
(306, 1354, 0, 19),
(307, 1355, 121, 19),
(308, 1356, 0, 19),
(309, 1357, 21, 19),
(310, 1358, NULL, 19),
(311, 1359, 121, 19),
(312, 1360, 121, 19),
(313, 1361, 121, 19),
(314, 1362, 0, 19),
(315, 1363, 0, 19),
(316, 1, 2, 1),
(317, 2, 1, 1),
(318, 3, 1, 1),
(319, 4, 8, 4),
(320, 5, 8, 4),
(321, 7, 8, 4),
(322, 8, 9, 4),
(323, 9, 0, 4),
(324, 10, NULL, 4),
(325, 11, NULL, 4),
(326, 12, NULL, 4),
(327, 13, NULL, 4);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_a_todo`
--

CREATE TABLE `i_u_a_todo` (
  `iuat_id` int(11) NOT NULL,
  `iuat_title` varchar(100) NOT NULL,
  `iuat_status` varchar(50) NOT NULL,
  `iuat_a_id` int(11) DEFAULT NULL,
  `iuat_owner` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_a_todo`
--

INSERT INTO `i_u_a_todo` (`iuat_id`, `iuat_title`, `iuat_status`, `iuat_a_id`, `iuat_owner`) VALUES
(113, 't1', 'false', 1, 1),
(114, 't2', 'false', 1, 1),
(115, 't3', 'false', 1, 1),
(116, 't4', 'false', 1, 1),
(117, 't5', 'false', 1, 1),
(128, 't1', 'false', 4, 1),
(129, 't2', 'false', 4, 1),
(130, 't3', 'false', 4, 1),
(131, 't4', 'false', 4, 1),
(132, 't5', 'false', 4, 1),
(133, 't1', 'false', 5, 1),
(134, 't2', 'false', 5, 1),
(135, 't3', 'false', 5, 1),
(136, 't4', 'false', 5, 1),
(137, 't5', 'false', 5, 1),
(143, 't1', 'false', 7, 1),
(144, 't2', 'false', 7, 1),
(145, 't3', 'false', 7, 1),
(146, 't4', 'false', 7, 1),
(147, 't5', 'false', 7, 1),
(148, 't1', 'false', 8, 1),
(149, 't2', 'false', 8, 1),
(150, 't3', 'false', 8, 1),
(151, 't4', 'false', 8, 1),
(152, 't5', 'false', 8, 1),
(153, 't1', 'false', 9, 1),
(154, 't2', 'false', 9, 1),
(155, 't3', 'false', 9, 1),
(156, 't4', 'false', 9, 1),
(157, 't5', 'false', 9, 1),
(158, 't1', 'false', 10, 1),
(159, 't2', 'false', 10, 1),
(160, 't3', 'false', 10, 1),
(161, 't4', 'false', 10, 1),
(162, 't5', 'false', 10, 1),
(163, 't1', 'false', 11, 1),
(164, 't2', 'false', 11, 1),
(165, 't3', 'false', 11, 1),
(166, 't4', 'false', 11, 1),
(167, 't5', 'false', 11, 1),
(168, 't1', 'false', 12, 1),
(169, 't2', 'false', 12, 1),
(170, 't3', 'false', 12, 1),
(171, 't4', 'false', 12, 1),
(172, 't5', 'false', 12, 1),
(173, 't1', 'false', 13, 1),
(174, 't2', 'false', 13, 1),
(175, 't3', 'false', 13, 1),
(176, 't4', 'false', 13, 1),
(177, 't5', 'false', 13, 1),
(178, 't1', 'false', 14, 1),
(179, 't2', 'false', 14, 1),
(180, 't3', 'false', 14, 1),
(181, 't4', 'false', 14, 1),
(182, 't5', 'false', 14, 1),
(183, 't1', 'false', 15, 1),
(184, 't2', 'false', 15, 1),
(185, 't3', 'false', 15, 1),
(186, 't4', 'false', 15, 1),
(187, 't5', 'false', 15, 1),
(188, 't1', 'false', 16, 1),
(189, 't2', 'false', 16, 1),
(190, 't3', 'false', 16, 1),
(191, 't4', 'false', 16, 1),
(192, 't5', 'false', 16, 1),
(193, 't1', 'false', 17, 1),
(194, 't2', 'false', 17, 1),
(195, 't3', 'false', 17, 1),
(196, 't4', 'false', 17, 1),
(197, 't5', 'false', 17, 1),
(198, 't1', 'false', 18, 1),
(199, 't2', 'false', 18, 1),
(200, 't3', 'false', 18, 1),
(201, 't4', 'false', 18, 1),
(202, 't5', 'false', 18, 1),
(203, 't1', 'false', 19, 1),
(204, 't2', 'false', 19, 1),
(205, 't3', 'false', 19, 1),
(206, 't4', 'false', 19, 1),
(207, 't5', 'false', 19, 1),
(208, 't1', 'false', 20, 1),
(209, 't2', 'false', 20, 1),
(210, 't3', 'false', 20, 1),
(211, 't4', 'false', 20, 1),
(212, 't5', 'false', 20, 1),
(215, 't1', 'false', 2, 1),
(216, 't1', 'false', 6, 1),
(217, 't2', 'false', 6, 1),
(218, 't3', 'false', 6, 1),
(219, 't4', 'false', 6, 1),
(220, 't5', 'false', 6, 1),
(221, 't1', 'true', 3, 1),
(222, 't2', 'false', 3, 1),
(223, 't3', 'false', 3, 1),
(224, 't4', 'false', 3, 1),
(226, '', 'true', 185, 2),
(227, '', 'true', 186, 2),
(228, '', 'true', 187, 2),
(229, '', 'true', 188, 2),
(230, '', 'true', 189, 2),
(231, '', 'true', 190, 2),
(232, '', 'true', 191, 2),
(233, '', 'true', 192, 2),
(234, '', 'true', 193, 2),
(235, '', 'true', 194, 2),
(236, '', 'true', 195, 2),
(237, '', 'true', 196, 2),
(238, '', 'true', 197, 2),
(239, '', 'true', 198, 2),
(240, '', 'true', 199, 2),
(241, '', 'true', 200, 2),
(242, '', 'true', 201, 2),
(243, '', 'true', 202, 2),
(244, '', 'true', 203, 2),
(245, '', 'true', 204, 2),
(246, '', 'true', 205, 2),
(247, '', 'true', 206, 2),
(248, '', 'true', 207, 2),
(249, '', 'true', 208, 2),
(250, '', 'true', 209, 2),
(251, '', 'true', 210, 2),
(252, '', 'true', 211, 2),
(253, '', 'true', 212, 2),
(254, '', 'true', 213, 2),
(255, '', 'true', 214, 2),
(256, '', 'true', 215, 2),
(257, '', 'true', 216, 2),
(258, '', 'true', 217, 2),
(259, '', 'true', 218, 2),
(260, '', 'true', 219, 2),
(261, '', 'true', 220, 2),
(262, '', 'true', 221, 2),
(263, '', 'true', 222, 2),
(264, '', 'true', 223, 2),
(265, '', 'true', 224, 2),
(266, '', 'true', 225, 2),
(267, '', 'true', 226, 2),
(268, '', 'true', 227, 2),
(269, '', 'true', 228, 2),
(270, '', 'true', 229, 2),
(271, '', 'true', 230, 2),
(272, '', 'true', 231, 2),
(273, '', 'true', 232, 2),
(274, '', 'true', 233, 2),
(275, '', 'true', 234, 2),
(276, '', 'true', 235, 2),
(277, '', 'true', 236, 2),
(278, '', 'true', 237, 2),
(279, '', 'true', 238, 2),
(280, '', 'true', 239, 2),
(281, '', 'true', 240, 2),
(282, '', 'true', 241, 2),
(283, '', 'true', 242, 2),
(284, '', 'true', 243, 2),
(285, '', 'true', 244, 2),
(286, '', 'true', 245, 2),
(287, '', 'true', 246, 2),
(288, '', 'true', 247, 2),
(289, '', 'true', 248, 2),
(290, '', 'true', 249, 2),
(291, '', 'true', 250, 2),
(292, '', 'true', 251, 2),
(293, '', 'true', 252, 2),
(294, '', 'true', 253, 2),
(295, '', 'true', 254, 2),
(296, '', 'true', 255, 2),
(297, '', 'true', 256, 2),
(298, '', 'true', 257, 2),
(299, '', 'true', 258, 2),
(300, '', 'true', 259, 2),
(301, '', 'true', 260, 2),
(302, '', 'true', 261, 2),
(303, '', 'true', 262, 2),
(304, '', 'true', 263, 2),
(305, '', 'true', 264, 2),
(306, '', 'true', 265, 2),
(307, '', 'true', 266, 2),
(308, '', 'true', 267, 2),
(309, '', 'true', 268, 2),
(310, '', 'true', 269, 2),
(311, '', 'true', 270, 2),
(312, '', 'true', 271, 2),
(313, '', 'true', 272, 2),
(314, '', 'true', 273, 2),
(315, '', 'true', 274, 2),
(316, '', 'true', 275, 2),
(317, '', 'true', 276, 2),
(318, '', 'true', 277, 2),
(319, '', 'true', 278, 2),
(320, '', 'true', 279, 2),
(321, '', 'true', 280, 2),
(322, '', 'true', 281, 2),
(323, '', 'true', 282, 2),
(324, '', 'true', 283, 2),
(325, '', 'true', 284, 2),
(326, '', 'true', 285, 2),
(327, '', 'true', 286, 2),
(328, '', 'true', 287, 2),
(329, '', 'true', 288, 2),
(330, '', 'true', 289, 2),
(331, '', 'true', 290, 2),
(332, '', 'true', 291, 2),
(333, '', 'true', 292, 2),
(334, '', 'true', 293, 2),
(335, '', 'true', 294, 2),
(336, '', 'true', 295, 2),
(337, '', 'true', 296, 2),
(338, '', 'true', 297, 2),
(339, '', 'true', 298, 2),
(340, '', 'true', 299, 2),
(341, '', 'true', 300, 2),
(342, '', 'true', 301, 2),
(343, '', 'true', 302, 2),
(344, '', 'true', 303, 2),
(345, '', 'true', 304, 2),
(346, '', 'true', 305, 2),
(347, '', 'true', 306, 2),
(348, '', 'true', 307, 2),
(349, '', 'true', 308, 2),
(350, '', 'true', 309, 2),
(351, '', 'true', 310, 2),
(352, '', 'true', 311, 2),
(353, '', 'true', 312, 2),
(354, '', 'true', 313, 2),
(355, '', 'true', 314, 2),
(356, '', 'true', 315, 2),
(357, '', 'true', 316, 2),
(358, '', 'true', 317, 2),
(359, '', 'true', 318, 2),
(360, '', 'true', 319, 2),
(361, '', 'true', 320, 2),
(362, '', 'true', 321, 2),
(363, '', 'true', 322, 2),
(364, '', 'true', 323, 2),
(365, '', 'true', 324, 2),
(366, '', 'true', 325, 2),
(367, '', 'true', 326, 2),
(368, '', 'true', 327, 2),
(369, '', 'true', 328, 2),
(370, '', 'true', 329, 2),
(371, '', 'true', 330, 2),
(372, '', 'true', 331, 2),
(373, '', 'true', 332, 2),
(374, '', 'true', 333, 2),
(375, '', 'true', 334, 2),
(376, '', 'true', 335, 2),
(377, '', 'true', 336, 2),
(378, '', 'true', 337, 2),
(379, '', 'true', 338, 2),
(380, '', 'true', 339, 2),
(381, '', 'true', 340, 2),
(382, '', 'true', 341, 2),
(383, '', 'true', 342, 2),
(384, '', 'true', 343, 2),
(385, '', 'true', 344, 2),
(386, '', 'true', 345, 2),
(387, '', 'true', 346, 2),
(388, '', 'true', 347, 2),
(389, '', 'true', 348, 2),
(390, '', 'true', 349, 2),
(391, '', 'true', 350, 2),
(392, '', 'true', 351, 2),
(393, '', 'true', 352, 2),
(394, '', 'true', 353, 2),
(395, '', 'true', 354, 2),
(396, '', 'true', 355, 2),
(397, '', 'true', 356, 2),
(398, '', 'true', 357, 2),
(399, '', 'true', 358, 2),
(400, '', 'true', 359, 2),
(401, '', 'true', 360, 2),
(402, '', 'true', 361, 2),
(403, '', 'true', 362, 2),
(404, '', 'true', 363, 2),
(405, '', 'true', 364, 2),
(406, '', 'true', 365, 2),
(407, '', 'true', 366, 2),
(408, '', 'true', 367, 2),
(409, '', 'true', 368, 2),
(410, '', 'true', 369, 2),
(411, '', 'true', 370, 2),
(412, '', 'true', 371, 2),
(413, '', 'true', 372, 2),
(414, '', 'true', 373, 2),
(415, '', 'true', 374, 2),
(416, '', 'true', 375, 2),
(417, '', 'true', 376, 2),
(418, '', 'true', 377, 2),
(419, '', 'true', 378, 2),
(420, '', 'true', 379, 2),
(421, '', 'true', 380, 2),
(422, '', 'true', 381, 2),
(423, '', 'true', 382, 2),
(424, '', 'true', 383, 2),
(425, '', 'true', 384, 2),
(426, '', 'true', 385, 2),
(427, '', 'true', 386, 2),
(428, '', 'true', 387, 2),
(429, '', 'true', 388, 2),
(430, '', 'true', 389, 2),
(431, '', 'true', 390, 2),
(432, '', 'true', 391, 2),
(433, '', 'true', 392, 2),
(434, '', 'true', 393, 2),
(435, '', 'true', 394, 2),
(436, '', 'true', 395, 2),
(437, '', 'true', 396, 2),
(438, '', 'true', 397, 2),
(439, '', 'true', 398, 2),
(440, '', 'true', 399, 2),
(441, '', 'true', 400, 2),
(442, '', 'true', 401, 2),
(443, '', 'true', 402, 2),
(444, '', 'true', 403, 2),
(445, '', 'true', 404, 2),
(446, '', 'true', 405, 2),
(447, '', 'true', 406, 2),
(448, '', 'true', 407, 2),
(449, '', 'true', 408, 2),
(450, '', 'true', 409, 2),
(451, '', 'true', 410, 2),
(452, '', 'true', 411, 2),
(453, '', 'true', 412, 2),
(454, '', 'true', 413, 2),
(455, '', 'true', 414, 2),
(456, '', 'true', 415, 2),
(457, '', 'true', 416, 2),
(458, '', 'true', 417, 2),
(459, '', 'true', 418, 2),
(460, '', 'true', 419, 2),
(461, '', 'true', 420, 2),
(462, '', 'true', 421, 2),
(463, '', 'true', 422, 2),
(464, '', 'true', 423, 2),
(465, '', 'true', 424, 2),
(466, '', 'true', 425, 2),
(467, '', 'true', 426, 2),
(468, '', 'true', 427, 2),
(469, '', 'true', 428, 2),
(470, '', 'true', 429, 2),
(471, '', 'true', 430, 2),
(472, '', 'true', 431, 2),
(473, '', 'true', 432, 2),
(474, '', 'true', 433, 2),
(475, '', 'true', 434, 2),
(476, '', 'true', 435, 2),
(477, '', 'true', 436, 2),
(478, '', 'true', 437, 2),
(479, '', 'true', 438, 2),
(480, '', 'true', 439, 2),
(481, '', 'true', 440, 2),
(482, '', 'true', 441, 2),
(483, '', 'true', 442, 2),
(484, '', 'true', 443, 2),
(485, '', 'true', 444, 2),
(486, '', 'true', 445, 2),
(487, '', 'true', 446, 2),
(488, '', 'true', 447, 2),
(489, '', 'true', 448, 2),
(490, '', 'true', 449, 2),
(491, '', 'true', 450, 2),
(492, '', 'true', 451, 2),
(493, '', 'true', 452, 2),
(494, '', 'true', 453, 2),
(495, '', 'true', 454, 2),
(496, '', 'true', 455, 2),
(497, '', 'true', 456, 2),
(498, '', 'true', 457, 2),
(499, '', 'true', 458, 2),
(500, '', 'true', 459, 2),
(501, '', 'true', 460, 2),
(502, '', 'true', 461, 2),
(503, '', 'true', 462, 2),
(504, '', 'true', 463, 2),
(505, '', 'true', 464, 2),
(506, '', 'true', 465, 2),
(507, '', 'true', 466, 2),
(508, '', 'true', 467, 2),
(509, '', 'true', 468, 2),
(510, '', 'true', 469, 2),
(511, '', 'true', 470, 2),
(512, '', 'true', 471, 2),
(513, '', 'true', 472, 2),
(514, '', 'true', 473, 2),
(515, '', 'true', 474, 2),
(516, '', 'true', 475, 2),
(517, '', 'true', 476, 2),
(518, '', 'true', 477, 2),
(519, '', 'true', 478, 2),
(520, '', 'true', 479, 2),
(521, '', 'true', 480, 2),
(522, '', 'true', 481, 2),
(523, '', 'true', 482, 2),
(524, '', 'true', 483, 2),
(525, '', 'true', 484, 2),
(526, '', 'true', 485, 2),
(527, '', 'true', 486, 2),
(528, '', 'true', 487, 2),
(529, '', 'true', 488, 2),
(530, '', 'true', 489, 2),
(531, '', 'true', 490, 2),
(532, '', 'true', 491, 2),
(533, '', 'true', 492, 2),
(534, '', 'true', 493, 2),
(535, '', 'true', 494, 2),
(536, '', 'true', 495, 2),
(537, '', 'true', 496, 2),
(538, '', 'true', 497, 2),
(539, '', 'true', 498, 2),
(540, '', 'true', 499, 2),
(541, '', 'true', 500, 2),
(542, '', 'true', 501, 2),
(543, '', 'true', 502, 2),
(544, '', 'true', 503, 2),
(545, '', 'true', 504, 2),
(546, '', 'true', 505, 2),
(547, '', 'true', 506, 2),
(548, '', 'true', 507, 2),
(549, '', 'true', 508, 2),
(550, '', 'true', 509, 2),
(551, '', 'true', 510, 2),
(552, '', 'true', 511, 2),
(553, '', 'true', 512, 2),
(554, '', 'true', 513, 2),
(555, '', 'true', 514, 2),
(556, '', 'true', 515, 2),
(557, '', 'true', 516, 2),
(558, '', 'true', 517, 2),
(559, '', 'true', 518, 2),
(560, '', 'true', 519, 2),
(561, '', 'true', 520, 2),
(562, '', 'true', 521, 2),
(563, '', 'true', 522, 2),
(564, '', 'true', 523, 2),
(565, '', 'true', 524, 2),
(566, '', 'true', 525, 2),
(567, '', 'true', 526, 2),
(568, '', 'true', 527, 2),
(569, '', 'true', 528, 2),
(570, '', 'true', 529, 2),
(571, '', 'true', 530, 2),
(572, '', 'true', 531, 2),
(573, '', 'true', 532, 2),
(574, '', 'true', 533, 2),
(575, '', 'true', 534, 2),
(576, '', 'true', 535, 2),
(577, '', 'true', 536, 2),
(578, '', 'true', 537, 2),
(579, '', 'true', 538, 2),
(580, '', 'true', 539, 2),
(581, '', 'true', 540, 2),
(582, '', 'true', 541, 2),
(583, '', 'true', 542, 2),
(584, '', 'true', 543, 2),
(585, '', 'true', 544, 2),
(586, '', 'true', 545, 2),
(587, '', 'true', 546, 2),
(588, '', 'true', 547, 2),
(589, '', 'true', 548, 2),
(590, '', 'true', 549, 2),
(591, '', 'true', 550, 2),
(592, '', 'true', 551, 2),
(593, '', 'true', 552, 2),
(594, '', 'true', 553, 2),
(595, '', 'true', 554, 2),
(596, '', 'true', 555, 2),
(597, '', 'true', 556, 2),
(598, '', 'true', 557, 2),
(599, '', 'true', 558, 2),
(600, '', 'true', 559, 2),
(601, '', 'true', 560, 2),
(602, '', 'true', 561, 2),
(603, '', 'true', 562, 2),
(604, '', 'true', 563, 2),
(605, '', 'true', 564, 2),
(606, '', 'true', 565, 2),
(607, '', 'true', 566, 2),
(608, '', 'true', 567, 2),
(609, '', 'true', 568, 2),
(610, '', 'true', 569, 2),
(611, '', 'true', 570, 2),
(612, '', 'true', 571, 2),
(613, '', 'true', 572, 2),
(614, '', 'true', 573, 2),
(615, '', 'true', 574, 2),
(616, '', 'true', 575, 2),
(617, '', 'true', 576, 2),
(618, '', 'true', 577, 2),
(619, '', 'true', 578, 2),
(620, '', 'true', 579, 2),
(621, '', 'true', 580, 2),
(622, '', 'true', 581, 2),
(623, '', 'true', 582, 2),
(624, '', 'true', 583, 2),
(625, '', 'true', 584, 2),
(626, '', 'true', 585, 2),
(627, '', 'true', 586, 2),
(628, '', 'true', 587, 2),
(629, '', 'true', 588, 2),
(630, '', 'true', 589, 2),
(631, '', 'true', 590, 2),
(632, '', 'true', 591, 2),
(633, '', 'true', 592, 2),
(634, '', 'true', 593, 2),
(635, '', 'true', 594, 2),
(636, '', 'true', 595, 2),
(637, '', 'true', 596, 2),
(638, '', 'true', 597, 2),
(639, '', 'true', 598, 2),
(640, '', 'true', 599, 2),
(641, '', 'true', 600, 2),
(642, '', 'true', 601, 2),
(643, '', 'true', 602, 2),
(644, '', 'true', 603, 2),
(645, '', 'true', 604, 2),
(646, '', 'true', 605, 2),
(647, '', 'true', 606, 2),
(648, '', 'true', 607, 2),
(649, '', 'true', 608, 2),
(650, '', 'true', 609, 2),
(651, '', 'true', 610, 2),
(652, '', 'true', 611, 2),
(653, '', 'true', 612, 2),
(654, '', 'true', 613, 2),
(655, '', 'true', 614, 2),
(656, '', 'true', 615, 2),
(657, '', 'true', 616, 2),
(658, '', 'true', 617, 2),
(659, '', 'true', 618, 2),
(660, '', 'true', 619, 2),
(661, '', 'true', 620, 2),
(662, '', 'true', 621, 2),
(663, '', 'true', 622, 2),
(664, '', 'true', 623, 2),
(665, '', 'true', 624, 2),
(666, '', 'true', 625, 2),
(667, '', 'true', 626, 2),
(668, '', 'true', 627, 2),
(669, '', 'true', 628, 2),
(670, '', 'true', 629, 2),
(671, '', 'true', 630, 2),
(672, '', 'true', 631, 2),
(673, '', 'true', 632, 2),
(674, '', 'true', 633, 2),
(675, '', 'true', 634, 2),
(676, '', 'true', 635, 2),
(677, '', 'true', 636, 2),
(678, '', 'true', 637, 2),
(679, '', 'true', 638, 2),
(680, '', 'true', 639, 2),
(681, '', 'true', 640, 2),
(682, '', 'true', 641, 2),
(683, '', 'true', 642, 2),
(684, '', 'true', 643, 2),
(685, '', 'true', 644, 2),
(686, '', 'true', 645, 2),
(687, '', 'true', 646, 2),
(688, '', 'true', 647, 2),
(689, '', 'true', 648, 2),
(690, '', 'true', 649, 2),
(691, '', 'true', 650, 2),
(692, '', 'true', 651, 2),
(693, '', 'true', 652, 2),
(694, '', 'true', 653, 2),
(695, '', 'true', 654, 2),
(696, '', 'true', 655, 2),
(697, '', 'true', 656, 2),
(698, '', 'true', 657, 2),
(699, '', 'true', 658, 2),
(700, '', 'true', 659, 2),
(701, '', 'true', 660, 2),
(702, '', 'true', 661, 2),
(703, '', 'true', 662, 2),
(704, '', 'true', 663, 2),
(705, '', 'true', 664, 2),
(706, '', 'true', 665, 2),
(707, '', 'true', 666, 2),
(708, '', 'true', 667, 2),
(709, '', 'true', 668, 2),
(710, '', 'true', 669, 2),
(711, '', 'true', 670, 2),
(712, '', 'true', 671, 2),
(713, '', 'true', 672, 2),
(714, '', 'true', 673, 2),
(715, '', 'true', 674, 2),
(716, '', 'true', 675, 2),
(717, '', 'true', 676, 2),
(718, '', 'true', 677, 2),
(719, '', 'true', 678, 2),
(720, '', 'true', 679, 2),
(721, '', 'true', 680, 2),
(722, '', 'true', 681, 2),
(723, '', 'true', 682, 2),
(724, '', 'true', 683, 2),
(725, '', 'true', 684, 2),
(726, '', 'true', 685, 2),
(727, '', 'true', 686, 2),
(728, '', 'true', 687, 2),
(729, '', 'true', 688, 2),
(730, '', 'true', 689, 2),
(731, '', 'true', 690, 2),
(732, '', 'true', 691, 2),
(733, '', 'true', 692, 2),
(734, '', 'true', 693, 2),
(735, '', 'true', 694, 2),
(736, '', 'true', 695, 2),
(737, '', 'true', 696, 2),
(738, '', 'true', 697, 2),
(739, '', 'true', 698, 2),
(740, '', 'true', 699, 2),
(741, '', 'true', 700, 2),
(742, '', 'true', 701, 2),
(743, '', 'true', 702, 2),
(744, '', 'true', 703, 2),
(745, '', 'true', 704, 2),
(746, '', 'true', 705, 2),
(747, '', 'true', 706, 2),
(748, '', 'true', 707, 2),
(749, '', 'true', 708, 2),
(750, '', 'true', 709, 2),
(751, '', 'true', 710, 2),
(752, '', 'true', 711, 2),
(753, '', 'true', 712, 2),
(754, '', 'true', 713, 2),
(755, '', 'true', 714, 2),
(756, '', 'true', 715, 2),
(757, '', 'true', 716, 2),
(758, '', 'true', 717, 2),
(759, '', 'true', 718, 2),
(760, '', 'true', 719, 2),
(761, '', 'true', 720, 2),
(762, '', 'true', 721, 2),
(763, '', 'true', 722, 2),
(764, '', 'true', 723, 2),
(765, '', 'true', 724, 2),
(766, '', 'true', 725, 2),
(767, '', 'true', 726, 2),
(768, '', 'true', 727, 2),
(769, '', 'true', 728, 2),
(770, '', 'true', 729, 2),
(771, '', 'true', 730, 2),
(772, '', 'true', 731, 2),
(773, '', 'true', 732, 2),
(774, '', 'true', 733, 2),
(775, '', 'true', 734, 2),
(776, '', 'true', 735, 2),
(777, '', 'true', 736, 2),
(778, '', 'true', 737, 2),
(779, '', 'true', 738, 2),
(780, '', 'true', 739, 2),
(781, '', 'true', 740, 2),
(782, '', 'true', 741, 2),
(783, '', 'true', 742, 2),
(784, '', 'true', 743, 2),
(785, '', 'true', 744, 2),
(786, '', 'true', 745, 2),
(787, '', 'true', 746, 2),
(788, '', 'true', 747, 2),
(789, '', 'true', 748, 2),
(790, '', 'true', 749, 2),
(791, '', 'true', 750, 2),
(792, '', 'true', 751, 2),
(793, '', 'true', 752, 2),
(794, '', 'true', 753, 2),
(795, '', 'true', 754, 2),
(796, '', 'true', 755, 2),
(797, '', 'true', 756, 2),
(798, '', 'true', 757, 2),
(799, '', 'true', 758, 2),
(800, '', 'true', 759, 2),
(801, '', 'true', 760, 2),
(802, '', 'true', 761, 2),
(803, '', 'true', 762, 2),
(804, '', 'true', 763, 2),
(805, '', 'true', 764, 2),
(806, '', 'true', 765, 2),
(807, '', 'true', 766, 2),
(808, '', 'true', 767, 2),
(809, '', 'true', 768, 2),
(810, '', 'true', 769, 2),
(811, '', 'true', 770, 2),
(812, '', 'true', 771, 2),
(813, '', 'true', 772, 2),
(814, '', 'true', 773, 2),
(815, '', 'true', 774, 2),
(816, '', 'true', 775, 2),
(817, '', 'true', 776, 2),
(818, '', 'true', 777, 2),
(819, '', 'true', 778, 2),
(820, '', 'true', 779, 2),
(821, '', 'true', 780, 2),
(822, '', 'true', 781, 2),
(823, '', 'true', 782, 2),
(824, '', 'true', 783, 2),
(825, '', 'true', 784, 2),
(826, '', 'true', 785, 2),
(827, '', 'true', 786, 2),
(828, '', 'true', 787, 2),
(829, '', 'true', 788, 2),
(830, '', 'true', 789, 2),
(831, '', 'true', 790, 2),
(832, '', 'true', 791, 2),
(833, '', 'true', 792, 2),
(834, '', 'true', 793, 2),
(835, '', 'true', 794, 2),
(836, '', 'true', 795, 2),
(837, '', 'true', 796, 2),
(838, '', 'true', 797, 2),
(839, '', 'true', 798, 2),
(840, '', 'true', 799, 2),
(841, '', 'true', 800, 2),
(842, '', 'true', 801, 2),
(843, '', 'true', 802, 2),
(844, '', 'true', 803, 2),
(845, '', 'true', 804, 2),
(846, '', 'true', 805, 2),
(847, '', 'true', 806, 2),
(848, '', 'true', 807, 2),
(849, '', 'true', 808, 2),
(850, '', 'true', 809, 2),
(851, '', 'true', 810, 2),
(852, '', 'true', 811, 2),
(853, '', 'true', 812, 2),
(854, '', 'true', 813, 2),
(855, '', 'true', 814, 2),
(856, '', 'true', 815, 2),
(857, '', 'true', 816, 2),
(858, '', 'true', 817, 2),
(859, '', 'true', 818, 2),
(860, '', 'true', 819, 2),
(861, '', 'true', 820, 2),
(862, '', 'true', 821, 2),
(863, '', 'true', 822, 2),
(864, '', 'true', 823, 2),
(865, '', 'true', 824, 2),
(866, '', 'true', 825, 2),
(867, '', 'true', 826, 2),
(868, '', 'true', 827, 2),
(869, '', 'true', 828, 2),
(870, '', 'true', 829, 2),
(871, '', 'true', 830, 2),
(872, '', 'true', 831, 2),
(873, '', 'true', 832, 2),
(874, '', 'true', 833, 2),
(875, '', 'true', 834, 2),
(876, '', 'true', 835, 2),
(877, '', 'true', 836, 2),
(878, '', 'true', 837, 2),
(879, '', 'true', 838, 2),
(880, '', 'true', 839, 2),
(881, '', 'true', 840, 2),
(882, '', 'true', 841, 2),
(883, '', 'true', 842, 2),
(884, '', 'true', 843, 2),
(885, '', 'true', 844, 2),
(886, '', 'true', 845, 2),
(887, '', 'true', 846, 2),
(888, '', 'true', 847, 2),
(889, '', 'true', 848, 2),
(890, '', 'true', 849, 2),
(891, '', 'true', 850, 2),
(892, '', 'true', 851, 2),
(893, '', 'true', 852, 2),
(894, '', 'true', 853, 2),
(895, '', 'true', 854, 2),
(896, '', 'true', 855, 2),
(897, '', 'true', 856, 2),
(898, '', 'true', 857, 2),
(899, '', 'true', 858, 2),
(900, '', 'true', 859, 2),
(901, '', 'true', 860, 2),
(902, '', 'true', 861, 2),
(903, '', 'true', 862, 2),
(904, '', 'true', 863, 2),
(905, '', 'true', 864, 2),
(906, '', 'true', 865, 2),
(907, '', 'true', 866, 2),
(908, '', 'true', 867, 2),
(909, '', 'true', 868, 2),
(910, '', 'true', 869, 2),
(911, '', 'true', 870, 2),
(912, '', 'true', 871, 2),
(913, '', 'true', 872, 2),
(914, '', 'true', 873, 2),
(915, '', 'true', 874, 2),
(916, '', 'true', 875, 2),
(917, '', 'true', 876, 2),
(918, '', 'true', 877, 2),
(919, '', 'true', 878, 2),
(920, '', 'true', 879, 2),
(921, '', 'true', 880, 2),
(922, '', 'true', 881, 2),
(923, '', 'true', 882, 2),
(924, '', 'true', 883, 2),
(925, '', 'true', 884, 2),
(926, '', 'true', 885, 2),
(927, '', 'true', 886, 2),
(928, '', 'true', 887, 2),
(929, '', 'true', 888, 2),
(930, '', 'true', 889, 2),
(931, '', 'true', 890, 2),
(932, '', 'true', 891, 2),
(933, '', 'true', 892, 2),
(934, '', 'true', 893, 2),
(935, '', 'true', 894, 2),
(936, '', 'true', 895, 2),
(937, '', 'true', 896, 2),
(938, '', 'true', 897, 2),
(939, '', 'true', 898, 2),
(940, '', 'true', 899, 2),
(941, '', 'true', 900, 2),
(942, '', 'true', 901, 2),
(943, '', 'true', 902, 2),
(944, '', 'true', 903, 2),
(945, '', 'true', 904, 2),
(946, '', 'true', 905, 2),
(947, '', 'true', 906, 2),
(948, '', 'true', 907, 2),
(949, '', 'true', 908, 2),
(950, '', 'true', 909, 2),
(951, '', 'true', 910, 2),
(952, '', 'true', 911, 2),
(953, '', 'true', 912, 2),
(954, '', 'true', 913, 2),
(955, '', 'true', 914, 2),
(956, '', 'true', 915, 2),
(957, '', 'true', 916, 2),
(958, '', 'true', 917, 2),
(959, '', 'true', 918, 2),
(960, '', 'true', 919, 2),
(961, '', 'true', 920, 2),
(962, '', 'true', 921, 2),
(963, '', 'true', 922, 2),
(964, '', 'true', 923, 2),
(965, '', 'true', 924, 2),
(966, '', 'true', 925, 2),
(967, '', 'true', 926, 2),
(968, '', 'true', 927, 2),
(969, '', 'true', 928, 2),
(970, '', 'true', 929, 2),
(971, '', 'true', 930, 2),
(972, '', 'true', 931, 2),
(973, '', 'true', 932, 2),
(974, '', 'true', 933, 2),
(975, '', 'true', 934, 2),
(976, '', 'true', 935, 2),
(977, '', 'true', 936, 2),
(978, '', 'true', 937, 2),
(979, '', 'true', 938, 2),
(980, '', 'true', 939, 2),
(981, '', 'true', 940, 2),
(982, '', 'true', 941, 2),
(983, '', 'true', 942, 2),
(984, '', 'true', 943, 2),
(985, '', 'true', 944, 2),
(986, '', 'true', 945, 2),
(987, '', 'true', 946, 2),
(988, '', 'true', 947, 2),
(989, '', 'true', 948, 2),
(990, '', 'true', 949, 2),
(991, '', 'true', 950, 2),
(992, '', 'true', 951, 2),
(993, '', 'true', 952, 2),
(994, '', 'true', 953, 2),
(995, '', 'true', 954, 2),
(996, '', 'true', 955, 2),
(997, '', 'true', 956, 2),
(998, '', 'true', 957, 2),
(999, '', 'true', 958, 2),
(1000, '', 'true', 959, 2),
(1001, '', 'true', 960, 2),
(1002, '', 'true', 961, 2),
(1003, '', 'true', 962, 2),
(1004, '', 'true', 963, 2),
(1005, '', 'true', 964, 2),
(1006, '', 'true', 965, 2),
(1007, '', 'true', 966, 2),
(1008, '', 'true', 967, 2),
(1009, '', 'true', 968, 2),
(1010, '', 'true', 969, 2),
(1011, '', 'true', 970, 2),
(1012, '', 'true', 971, 2),
(1013, '', 'true', 972, 2),
(1014, '', 'true', 973, 2),
(1015, '', 'true', 974, 2),
(1016, '', 'true', 975, 2),
(1017, '', 'true', 976, 2),
(1018, '', 'true', 977, 2),
(1019, '', 'true', 978, 2),
(1020, '', 'true', 979, 2),
(1021, '', 'true', 980, 2),
(1022, '', 'true', 981, 2),
(1023, '', 'true', 982, 2),
(1024, '', 'true', 983, 2),
(1025, '', 'true', 984, 2),
(1026, '', 'true', 985, 2),
(1027, '', 'true', 986, 2),
(1028, '', 'true', 987, 2),
(1029, '', 'true', 988, 2),
(1030, '', 'true', 989, 2),
(1031, '', 'true', 990, 2),
(1032, '', 'true', 991, 2),
(1033, '', 'true', 992, 2),
(1034, '', 'true', 993, 2),
(1035, '', 'true', 994, 2),
(1036, '', 'true', 995, 2),
(1037, '', 'true', 996, 2),
(1038, '', 'true', 997, 2),
(1039, '', 'true', 998, 2),
(1040, '', 'true', 999, 2),
(1041, '', 'true', 1000, 2),
(1042, '', 'true', 1001, 2),
(1043, '', 'true', 1002, 2),
(1044, '', 'true', 1003, 2),
(1045, '', 'true', 1004, 2),
(1046, '', 'true', 1005, 2),
(1047, '', 'true', 1006, 2),
(1048, '', 'true', 1007, 2),
(1049, '', 'true', 1008, 2),
(1050, '', 'true', 1009, 2),
(1051, '', 'true', 1010, 2),
(1052, '', 'true', 1011, 2),
(1053, '', 'true', 1012, 2),
(1054, '', 'true', 1013, 2),
(1055, '', 'true', 1014, 2),
(1056, '', 'true', 1015, 2),
(1057, '', 'true', 1016, 2),
(1058, '', 'true', 1017, 2),
(1059, '', 'true', 1018, 2),
(1060, '', 'true', 1019, 2),
(1061, '', 'true', 1020, 2),
(1062, '', 'true', 1021, 2),
(1063, '', 'true', 1022, 2),
(1064, '', 'true', 1023, 2),
(1065, '', 'true', 1024, 2),
(1066, '', 'true', 1025, 2),
(1067, '', 'true', 1026, 2),
(1068, '', 'true', 1027, 2),
(1069, '', 'true', 1028, 2),
(1070, '', 'true', 1029, 2),
(1071, '', 'true', 1030, 2),
(1072, '', 'true', 1031, 2),
(1073, '', 'true', 1032, 2),
(1074, '', 'true', 1033, 2),
(1075, '', 'true', 1034, 2),
(1076, '', 'true', 1035, 2),
(1077, '', 'true', 1036, 2),
(1078, '', 'true', 1037, 2),
(1079, '', 'true', 1038, 2),
(1080, '', 'true', 1039, 2),
(1081, '', 'true', 1040, 2),
(1082, '', 'true', 1041, 2),
(1083, '', 'true', 1042, 2),
(1084, '', 'true', 1043, 2),
(1085, '', 'true', 1044, 2),
(1086, '', 'true', 1045, 2),
(1087, '', 'true', 1046, 2),
(1088, '', 'true', 1047, 2),
(1089, '', 'true', 1048, 2),
(1090, '', 'true', 1049, 2),
(1091, '', 'true', 1050, 2),
(1092, '', 'true', 1051, 2),
(1093, '', 'true', 1052, 2),
(1094, '', 'true', 1053, 2),
(1095, '', 'true', 1054, 2),
(1096, '', 'true', 1055, 2),
(1097, '', 'true', 1056, 2),
(1098, '', 'true', 1057, 2),
(1099, '', 'true', 1058, 2),
(1100, '', 'true', 1059, 2),
(1101, '', 'true', 1060, 2),
(1102, '', 'true', 1061, 2),
(1103, '', 'true', 1062, 2),
(1104, '', 'true', 1063, 2),
(1105, '', 'true', 1064, 2),
(1106, '', 'true', 1065, 2),
(1107, '', 'true', 1066, 2),
(1108, '', 'true', 1067, 2),
(1109, '', 'true', 1068, 2),
(1110, '', 'true', 1069, 2),
(1111, '', 'true', 1070, 2),
(1112, '', 'true', 1071, 2),
(1113, '', 'true', 1072, 2),
(1114, '', 'true', 1073, 2),
(1115, '', 'true', 1074, 2),
(1116, '', 'true', 1075, 2),
(1117, '', 'true', 1076, 2),
(1118, '', 'true', 1077, 2),
(1119, '', 'true', 1078, 2),
(1120, '', 'true', 1079, 2),
(1121, '', 'true', 1080, 2),
(1122, '', 'true', 1081, 2),
(1123, '', 'true', 1082, 2),
(1124, '', 'true', 1083, 2),
(1125, '', 'true', 1084, 2),
(1126, '', 'true', 1085, 2),
(1127, '', 'true', 1086, 2),
(1128, '', 'true', 1087, 2),
(1129, '', 'true', 1088, 2),
(1130, '', 'true', 1089, 2),
(1131, '', 'true', 1090, 2),
(1132, '', 'true', 1091, 2),
(1133, '', 'true', 1092, 2),
(1134, '', 'true', 1093, 2),
(1135, '', 'true', 1094, 2),
(1136, '', 'true', 1095, 2),
(1137, '', 'true', 1096, 2),
(1138, '', 'true', 1097, 2),
(1139, '', 'true', 1098, 2),
(1140, '', 'true', 1099, 2),
(1141, '', 'true', 1100, 2),
(1142, '', 'true', 1101, 2),
(1143, '', 'true', 1102, 2),
(1144, '', 'true', 1103, 2),
(1145, '', 'true', 1104, 2),
(1146, '', 'true', 1105, 2),
(1147, '', 'true', 1106, 2),
(1148, '', 'true', 1107, 2),
(1149, '', 'true', 1108, 2),
(1150, '', 'true', 1109, 2),
(1151, '', 'true', 1110, 2),
(1152, '', 'true', 1111, 2),
(1153, '', 'true', 1112, 2),
(1154, '', 'true', 1113, 2),
(1155, '', 'true', 1114, 2),
(1156, '', 'true', 1115, 2),
(1157, '', 'true', 1116, 2),
(1158, '', 'true', 1117, 2),
(1159, '', 'true', 1118, 2),
(1160, '', 'true', 1119, 2),
(1161, '', 'true', 1120, 2),
(1162, '', 'true', 1121, 2),
(1163, '', 'true', 1122, 2),
(1164, '', 'true', 1123, 2),
(1165, '', 'true', 1124, 2),
(1166, '', 'true', 1125, 2),
(1167, '', 'true', 1126, 2),
(1168, '', 'true', 1127, 2),
(1169, '', 'true', 1128, 2),
(1170, '', 'true', 1129, 2),
(1171, '', 'true', 1130, 2),
(1172, '', 'true', 1131, 2),
(1173, '', 'true', 1132, 2),
(1174, '', 'true', 1133, 2),
(1175, '', 'true', 1134, 2),
(1176, '', 'true', 1135, 2),
(1177, '', 'true', 1136, 2),
(1178, '', 'true', 1137, 2),
(1179, '', 'true', 1138, 2),
(1180, '', 'true', 1139, 2),
(1181, '', 'true', 1140, 2),
(1182, '', 'true', 1141, 2),
(1183, '', 'true', 1142, 2),
(1184, '', 'true', 1143, 2),
(1185, '', 'true', 1144, 2),
(1186, '', 'true', 1145, 2),
(1187, '', 'true', 1146, 2),
(1188, '', 'true', 1147, 2),
(1189, '', 'true', 1148, 2),
(1190, '', 'true', 1149, 2),
(1191, '', 'true', 1150, 2),
(1192, '', 'true', 1151, 2),
(1193, '', 'true', 1152, 2),
(1194, '', 'true', 1153, 2),
(1195, '', 'true', 1154, 2),
(1196, '', 'true', 1155, 2),
(1197, '', 'true', 1156, 2),
(1198, '', 'true', 1157, 2),
(1199, '', 'true', 1158, 2),
(1200, '', 'true', 1159, 2),
(1201, '', 'true', 1160, 2),
(1202, '', 'true', 1161, 2),
(1203, '', 'true', 1162, 2),
(1204, '', 'true', 1163, 2),
(1205, '', 'true', 1164, 2),
(1206, '', 'true', 1165, 2),
(1207, '', 'true', 1166, 2),
(1208, '', 'true', 1167, 2),
(1209, '', 'true', 1168, 2),
(1210, '', 'true', 1169, 2),
(1211, '', 'true', 1170, 2),
(1212, '', 'true', 1171, 2),
(1213, '', 'true', 1172, 2),
(1214, '', 'true', 1173, 2),
(1215, '', 'true', 1174, 2),
(1216, '', 'true', 1175, 2),
(1217, '', 'true', 1176, 2),
(1218, '', 'true', 1177, 2),
(1219, '', 'true', 1178, 2),
(1220, '', 'true', 1179, 2),
(1221, '', 'true', 1180, 2),
(1222, '', 'true', 1181, 2),
(1223, '', 'true', 1182, 2),
(1224, '', 'true', 1183, 2),
(1225, '', 'true', 1184, 2),
(1226, '', 'true', 1185, 2),
(1227, '', 'true', 1186, 2),
(1228, '', 'true', 1187, 2),
(1229, '', 'true', 1188, 2),
(1230, '', 'true', 1189, 2),
(1231, '', 'true', 1190, 2),
(1232, '', 'true', 1191, 2),
(1233, '', 'true', 1192, 2),
(1234, '', 'true', 1193, 2),
(1235, '', 'true', 1194, 2),
(1236, '', 'true', 1195, 2),
(1237, '', 'true', 1196, 2),
(1238, '', 'true', 1197, 2),
(1239, '', 'true', 1198, 2),
(1240, '', 'true', 1199, 2),
(1241, '', 'true', 1200, 2),
(1242, '', 'true', 1201, 2),
(1243, '', 'true', 1202, 2),
(1244, '', 'true', 1203, 2),
(1245, '', 'true', 1204, 2),
(1246, '', 'true', 1205, 2),
(1247, '', 'true', 1206, 2),
(1248, '', 'true', 1207, 2),
(1249, '', 'true', 1208, 2),
(1250, '', 'true', 1209, 2),
(1251, '', 'true', 1210, 2),
(1252, '', 'true', 1211, 2),
(1253, '', 'true', 1212, 2),
(1254, '', 'true', 1213, 2),
(1255, '', 'true', 1214, 2),
(1256, '', 'true', 1215, 2),
(1257, '', 'true', 1216, 2),
(1258, '', 'true', 1217, 2),
(1259, '', 'true', 1218, 2),
(1260, '', 'true', 1219, 2),
(1261, '', 'true', 1220, 2),
(1262, '', 'true', 1221, 2),
(1263, '', 'true', 1222, 2),
(1264, '', 'true', 1223, 2),
(1265, '', 'true', 1224, 2),
(1266, '', 'true', 1225, 2),
(1267, '', 'true', 1226, 2),
(1268, '', 'true', 1227, 2),
(1269, '', 'true', 1228, 2),
(1270, '', 'true', 1229, 2),
(1271, '', 'true', 1230, 2),
(1272, '', 'true', 1231, 2),
(1273, '', 'true', 1232, 2),
(1274, '', 'true', 1233, 2),
(1275, '', 'true', 1234, 2),
(1276, '', 'true', 1235, 2),
(1277, '', 'true', 1236, 2),
(1278, '', 'true', 1237, 2),
(1279, '', 'true', 1238, 2),
(1280, '', 'true', 1239, 2),
(1281, '', 'true', 1240, 2),
(1282, '', 'true', 1241, 2),
(1283, '', 'true', 1242, 2),
(1284, '', 'true', 1243, 2),
(1285, '', 'true', 1244, 2),
(1286, '', 'true', 1245, 2),
(1287, '', 'true', 1246, 2),
(1288, '', 'true', 1247, 2),
(1289, '', 'true', 1248, 2),
(1290, '', 'true', 1249, 2),
(1291, '', 'true', 1250, 2),
(1292, '', 'true', 1251, 2),
(1293, '', 'true', 1252, 2),
(1294, '', 'true', 1253, 2),
(1295, '', 'true', 1254, 2),
(1296, '', 'true', 1255, 2),
(1297, '', 'true', 1256, 2),
(1298, '', 'true', 1257, 2),
(1299, '', 'true', 1258, 2),
(1300, '', 'true', 1259, 2),
(1301, '', 'true', 1260, 2),
(1302, '', 'true', 1261, 2),
(1303, '', 'true', 1262, 2),
(1304, '', 'true', 1263, 2),
(1305, '', 'true', 1264, 2),
(1306, '', 'true', 1265, 2),
(1307, '', 'true', 1266, 2),
(1308, '', 'true', 1267, 2),
(1309, '', 'true', 1268, 2),
(1310, '', 'true', 1269, 2),
(1311, '', 'true', 1270, 2),
(1312, '', 'true', 1271, 2),
(1313, '', 'true', 1272, 2),
(1314, '', 'true', 1273, 2),
(1315, '', 'true', 1274, 2),
(1316, '', 'true', 1275, 2),
(1317, '', 'true', 1276, 2),
(1318, '', 'true', 1277, 2),
(1319, '', 'true', 1278, 2);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_details`
--

CREATE TABLE `i_u_details` (
  `iud_id` int(11) NOT NULL,
  `iud_u_id` int(11) DEFAULT NULL,
  `iud_name` varchar(100) DEFAULT NULL,
  `iud_company` varchar(100) DEFAULT NULL,
  `iud_email` varchar(100) DEFAULT NULL,
  `iud_phone` varchar(100) DEFAULT NULL,
  `iud_address` varchar(500) DEFAULT NULL,
  `iud_profile` varchar(100) NOT NULL,
  `iud_logo` varchar(100) DEFAULT NULL,
  `iud_gst` varchar(100) DEFAULT NULL,
  `iud_ref_code` varchar(200) DEFAULT NULL,
  `iud_logo_add` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_details`
--

INSERT INTO `i_u_details` (`iud_id`, `iud_u_id`, `iud_name`, `iud_company`, `iud_email`, `iud_phone`, `iud_address`, `iud_profile`, `iud_logo`, `iud_gst`, `iud_ref_code`, `iud_logo_add`) VALUES
(1, 1, 'Krishnakant', NULL, 'krishnakant@evomata.com', '9821406714', NULL, '21560924700.jpg', NULL, NULL, NULL, NULL),
(2, 2, 'kpatole', NULL, 'kpatole2@gmail.com', '1234567890', NULL, '21560932420.jpg', NULL, NULL, NULL, NULL),
(3, 3, 'vinaya lokhande', NULL, 'vinayalokhande1993@gmail.com', '65464646546', NULL, '', NULL, NULL, NULL, NULL),
(4, 4, 'Hitesh Suvarna', NULL, 'hitesh@evomata.com', '9769351539', NULL, '01561010507.svg', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_group_subscription`
--

CREATE TABLE `i_u_group_subscription` (
  `iugs_id` int(11) NOT NULL,
  `iugs_uid` int(11) DEFAULT NULL,
  `iugs_sub_start` datetime DEFAULT NULL,
  `iugs_sub_month` int(11) DEFAULT NULL,
  `iugs_renew_month` int(11) DEFAULT NULL,
  `iugs_renew_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_group_subscription`
--

INSERT INTO `i_u_group_subscription` (`iugs_id`, `iugs_uid`, `iugs_sub_start`, `iugs_sub_month`, `iugs_renew_month`, `iugs_renew_group`) VALUES
(3, 227, '2019-01-02 17:01:11', 0, NULL, NULL),
(20, 216, '2019-01-17 13:01:24', 0, NULL, NULL),
(45, 228, '2019-01-18 18:01:56', 0, NULL, NULL),
(65, 232, '2019-02-07 13:22:12', 0, NULL, NULL),
(66, 231, '2019-02-09 15:00:46', 0, NULL, NULL),
(72, 188, '2019-02-22 14:59:14', 0, NULL, NULL),
(90, 3, '2019-04-08 16:05:11', 0, NULL, NULL),
(127, 2, '2019-04-18 12:59:35', 12, NULL, NULL),
(134, 1, '2019-05-27 13:48:41', 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_g_module`
--

CREATE TABLE `i_u_g_module` (
  `iugm_id` int(11) NOT NULL,
  `iugm_m_id` int(11) NOT NULL,
  `iugm_owner` int(11) NOT NULL,
  `iugm_g_id` int(11) NOT NULL,
  `iugm_m_status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_u_g_user`
--

CREATE TABLE `i_u_g_user` (
  `iugu_id` int(11) NOT NULL,
  `iugu_u_id` int(11) NOT NULL,
  `iugu_owner` int(11) NOT NULL,
  `iugu_g_id` int(11) NOT NULL,
  `iugu_admin` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_u_g_user_role`
--

CREATE TABLE `i_u_g_user_role` (
  `iugur_id` int(11) NOT NULL,
  `iugur_guid` int(11) DEFAULT NULL,
  `iugur_pid` int(11) DEFAULT NULL,
  `iugur_project` varchar(50) DEFAULT NULL,
  `iugur_group` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_g_user_role`
--

INSERT INTO `i_u_g_user_role` (`iugur_id`, `iugur_guid`, `iugur_pid`, `iugur_project`, `iugur_group`) VALUES
(38, 190, 21, 'true', 'true'),
(39, 195, 21, 'false', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_u_key_performance_indicators`
--

CREATE TABLE `i_u_key_performance_indicators` (
  `iukpi_id` int(11) NOT NULL,
  `iukpi_title` varchar(100) DEFAULT NULL,
  `iukpi_query` varchar(900) DEFAULT NULL,
  `iukpi_domain` int(11) DEFAULT NULL,
  `iukpi_module` int(11) DEFAULT NULL,
  `iukpi_display_type` varchar(100) DEFAULT NULL,
  `iukpi_time_dependent` int(11) DEFAULT NULL,
  `iukpi_analytics_trigger` varchar(100) DEFAULT NULL,
  `iukpi_type` varchar(100) DEFAULT NULL,
  `iukpi_desc` varchar(500) DEFAULT NULL,
  `iukpi_code` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_key_performance_indicators`
--

INSERT INTO `i_u_key_performance_indicators` (`iukpi_id`, `iukpi_title`, `iukpi_query`, `iukpi_domain`, `iukpi_module`, `iukpi_display_type`, `iukpi_time_dependent`, `iukpi_analytics_trigger`, `iukpi_type`, `iukpi_desc`, `iukpi_code`) VALUES
(1, 'Student batch count', 'SELECT count(c.iextb_batch_name) AS Count, c.iextb_batch_name AS Batch FROM i_customers AS a LEFT JOIN i_ext_ed_batch_allot AS b ON a.ic_id=b.iextba_customer_id LEFT JOIN i_ext_ed_batch AS c ON b.iextba_batch_id=c.iextb_id WHERE a.ic_owner = \'$oid\' GROUP BY c.iextb_batch_name;', 0, 0, 'table', 0, 'student-batch-count', NULL, NULL, NULL),
(2, 'Total Pending Fees', 'SELECT SUM(balance_fee) AS Balance FROM (SELECT MIN(iextf_balance_fee) AS balance_fee FROM i_ext_ed_fees WHERE iextf_owner = \'$oid\' GROUP BY iextf_customer_id) AS T', 0, 0, 'number', 0, 'student-total-outstanding-fee', NULL, '', '1545046520'),
(3, 'Students that have paid in last 7 days', 'SELECT b.ic_name AS Student, a.iextf_paid_fee AS Amount, a.iextf_paid_date AS Date FROM i_ext_ed_fees AS a LEFT JOIN i_customers AS b ON a.iextf_customer_id=b.ic_id WHERE iextf_owner=\'$oid\' AND iextf_paid_date BETWEEN date_sub(now(), interval 1 week) AND now();', 1, 2, 'table', 0, 'students-fee-paid-last-week', 'display', NULL, NULL),
(4, 'Todays Lectures', 'SELECT group_concat(b.iextb_batch_name, \'<br>\', c.iexts_name , \'<br>\', d.ic_name , \'<br>\', DATE(a.iextls_from_date), \'(\', TIME(a.iextls_from_date), \' - \',  TIME(a.iextls_to_date), \')\') AS Lectures  FROM i_ext_ed_lecture_schedule AS a LEFT JOIN i_ext_ed_batch AS b ON a.iextls_batch_id=b.iextb_id LEFT JOIN i_ext_ed_subjects AS c ON a.iextls_subject_id=c.iexts_id LEFT JOIN i_customers AS d ON a.iextls_teacher_id=d.ic_id WHERE DATE(a.iextls_from_date) = CURDATE() AND a.iextls_owner=\'$oid\'', 1, 9, 'table', 0, 'todays-lectures', 'display', NULL, NULL),
(5, 'Marks scored by students in recent exams', 'SELECT b.ic_name As Student, a.iextmr_marks_obt AS Marks FROM i_ext_ed_marks_records AS a LEFT JOIN i_customers AS b ON a.iextmr_customer_id=b.ic_id WHERE iextmr_m_id=\'1\' ;', 1, 17, 'bar', 0, 'student-recent-exam-marks', 'display', NULL, NULL),
(6, 'Monthly Expenditure', 'SELECT monthname(a.iexte_date) AS Month, sum(iexte_amount) AS Amount FROM i_ext_ed_expenses AS a WHERE a.iexte_owner = \'$oid\' AND MONTH(a.iexte_date) BETWEEN MONTH(curdate() - interval 1 month) AND MONTH(curdate()) GROUP BY iexte_date;', 0, 0, 'line', 0, 'monthly-expenditure', NULL, '', '1545111934'),
(7, 'Students attendance for today lectures', 'SELECT ieea_status,count(ieea_status) FROM i_ext_ed_attendance WHERE ieea_date = curdate() AND ieea_owner = \'$oid\' GROUP BY ieea_status', 1, 11, 'pie', 0, 'students-attendance-today-all', 'display', NULL, NULL),
(8, 'Recent material inward', 'SELECT b.ic_name AS Vendor, a.iextei_txn_id AS TransactionNumber, a.iextei_txn_date AS Date FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_type=\'inward\' AND a.iextei_owner=\'$oid\' ORDER BY a.iextei_txn_date DESC LIMIT 5', 8, 36, 'table', 0, 'inventory-inward-recent', NULL, 'Recent material inward', '1547535596'),
(9, 'Majority material purchase', 'SELECT b.ic_name AS Vendor, count(a.iextei_customer_id) AS Times_Purchased FROM i_ext_et_inventory AS a LEFT JOIN i_customers AS b ON a.iextei_customer_id=b.ic_id WHERE a.iextei_type=\'inward\' AND a.iextei_owner=\'$oid\' GROUP BY a.iextei_customer_id LIMIT 5;', 3, 20, 'bar', 0, 'inventory-inward-majority-count', 'display', NULL, NULL),
(10, 'Demand to Supply Ratio for the current month', 'SELECT iextei_type AS Type, count(iextei_type) AS Count FROM  i_ext_et_inventory WHERE iextei_owner=\'$oid\' AND MONTH(iextei_txn_date) = MONTH(\'$dt\') GROUP BY iextei_type;', 0, 0, 'pie', 0, 'inventory-inward-outward-ratio', NULL, '', '1545055081'),
(11, 'Student Fee Specific Details', 'SELECT a.iextf_paid_fee AS Amount, a.iextf_balance_fee AS Balance, a.iextf_paid_date AS Date, CONCAT(a.iextf_medium,\' \',a.iextf_details) AS Details FROM `i_ext_ed_fees` AS a LEFT JOIN i_customers AS b ON a.iextf_customer_id=b.ic_id WHERE a.iextf_owner = \".$oid.\" AND b.ic_name LIKE \'%\".$parameters[0][\'student-name\'].\"%\'', 1, 2, 'table', 0, 'student-fee-outstanding-specific', 'query', NULL, NULL),
(16, 'Monthly Invoice Amount', 'select monthname(iextein_txn_date) as Month, sum(iextein_amount) as Amount from i_ext_et_invoice group by month(iextein_txn_date);', 8, 35, 'line', 0, 'monthly-expenditure', NULL, 'Monthly invoice amount', '1554830274'),
(17, '', '', 0, 0, 'table', 0, '', NULL, '', '1554830257');

-- --------------------------------------------------------

--
-- Table structure for table `i_u_login`
--

CREATE TABLE `i_u_login` (
  `iul_id` int(11) NOT NULL,
  `iul_u_id` int(11) DEFAULT NULL,
  `iul_login` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_u_mail`
--

CREATE TABLE `i_u_mail` (
  `iumail_id` int(10) NOT NULL,
  `iumail_uid` int(10) NOT NULL,
  `iumail_owner` int(10) NOT NULL,
  `iumail_domain` varchar(200) NOT NULL,
  `iumail_mail` varchar(25) NOT NULL,
  `iumail_password` varchar(25) NOT NULL,
  `iumail_port` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `i_u_modules`
--

CREATE TABLE `i_u_modules` (
  `ium_id` int(11) NOT NULL,
  `ium_u_id` varchar(200) DEFAULT NULL,
  `ium_m_id` int(11) DEFAULT NULL,
  `ium_status` varchar(100) DEFAULT NULL,
  `ium_created` datetime DEFAULT NULL,
  `ium_created_by` int(11) DEFAULT NULL,
  `ium_modified` datetime DEFAULT NULL,
  `ium_modified_by` int(11) DEFAULT NULL,
  `ium_document_syntax` varchar(200) DEFAULT NULL,
  `ium_insert_id` int(11) NOT NULL,
  `ium_user_limit` int(11) DEFAULT NULL,
  `ium_gid` int(11) DEFAULT NULL,
  `ium_admin` varchar(50) DEFAULT NULL,
  `ium_reg_status` varchar(50) DEFAULT NULL,
  `ium_subscription_start` date DEFAULT NULL,
  `ium_subscription_end` date DEFAULT NULL,
  `ium_renewal_user` int(11) DEFAULT NULL,
  `ium_renewal_month` int(11) DEFAULT NULL,
  `ium_module_alias` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_modules`
--

INSERT INTO `i_u_modules` (`ium_id`, `ium_u_id`, `ium_m_id`, `ium_status`, `ium_created`, `ium_created_by`, `ium_modified`, `ium_modified_by`, `ium_document_syntax`, `ium_insert_id`, `ium_user_limit`, `ium_gid`, `ium_admin`, `ium_reg_status`, `ium_subscription_start`, `ium_subscription_end`, `ium_renewal_user`, `ium_renewal_month`, `ium_module_alias`) VALUES
(1, '1', 71, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(2, '1', 72, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(3, '1', 73, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(4, '1', 76, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(5, '1', 77, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(6, '1', 78, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(7, '1', 79, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(8, '1', 80, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(9, '1', 67, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(10, '1', 75, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(11, '1', 55, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(12, '1', 56, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(13, '1', 74, 'active', '2019-06-19 12:50:39', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(14, '2', 67, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(15, '2', 75, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(16, '2', 55, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(17, '2', 56, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(18, '2', 74, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(19, '2', 71, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'false', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(20, '2', 72, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'false', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(21, '2', 73, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(22, '2', 76, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(23, '2', 77, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(24, '2', 78, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(25, '2', 79, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(26, '2', 80, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(27, '3', 67, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(28, '3', 75, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(29, '3', 55, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(30, '3', 56, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(31, '3', 74, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(32, '3', 71, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(33, '3', 72, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(34, '3', 73, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(35, '3', 76, 'false', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, '', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(36, '3', 77, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(37, '3', 78, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(38, '3', 79, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(39, '3', 80, 'active', '2019-06-19 12:58:22', 0, NULL, NULL, NULL, 0, NULL, 1, 'true', NULL, '2019-06-19', '2021-06-19', NULL, NULL, NULL),
(42, '4', 73, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(41, '4', 72, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(40, '4', 71, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(43, '4', 76, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(44, '4', 77, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(45, '4', 78, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(46, '4', 79, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(47, '4', 80, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(48, '4', 67, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(49, '4', 75, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(50, '4', 55, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(51, '4', 56, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL),
(52, '4', 74, 'active', '2019-06-20 11:34:34', 0, NULL, NULL, NULL, 0, NULL, 4, 'true', NULL, '2019-06-20', '2020-06-20', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_m_document_id`
--

CREATE TABLE `i_u_m_document_id` (
  `iumdi_id` int(11) NOT NULL,
  `iumdi_customer_id` int(11) DEFAULT NULL,
  `iumdi_module_id` int(11) DEFAULT NULL,
  `iumdi_doc_syntax` varchar(100) DEFAULT NULL,
  `iumdi_variable` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_m_document_id`
--

INSERT INTO `i_u_m_document_id` (`iumdi_id`, `iumdi_customer_id`, `iumdi_module_id`, `iumdi_doc_syntax`, `iumdi_variable`) VALUES
(1, 4, 56, 'acc_yr', 'true'),
(2, 4, 56, '/OR/', 'false'),
(3, 4, 56, 'txn_no', 'true'),
(4, 4, 72, 'acc_yr', 'true'),
(5, 4, 72, '/OUT/', 'false'),
(6, 4, 72, 'txn_no', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `i_u_scheme_parameter`
--

CREATE TABLE `i_u_scheme_parameter` (
  `iushp_id` int(11) NOT NULL,
  `iushp_sid` int(11) DEFAULT NULL,
  `iushp_type` varchar(100) DEFAULT NULL,
  `iushp_amount` varchar(100) DEFAULT NULL,
  `iushp_for` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_scheme_parameter`
--

INSERT INTO `i_u_scheme_parameter` (`iushp_id`, `iushp_sid`, `iushp_type`, `iushp_amount`, `iushp_for`) VALUES
(59, 1, 'percentage', '10', 'referrer'),
(60, 1, 'amount', '1000', 'user'),
(65, 2, 'percentage', '5', 'referrer'),
(66, 2, 'percentage', '10', 'user'),
(75, 3, 'percentage', '50', 'user'),
(76, 3, 'percentage', '50', 'referrer');

-- --------------------------------------------------------

--
-- Table structure for table `i_u_session`
--

CREATE TABLE `i_u_session` (
  `ius_id` int(11) NOT NULL,
  `ius_u_id` int(11) DEFAULT NULL,
  `ius_s_id` varchar(400) DEFAULT NULL,
  `ius_gid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_session`
--

INSERT INTO `i_u_session` (`ius_id`, `ius_u_id`, `ius_s_id`, `ius_gid`) VALUES
(334, 228, 'u8jw3knv39awszt3hg89sewol9s5ezxx1vut4drj5eugfkyeae3ptgfr0jl2v35k1t9j6r1e4fmqnrvhz7vngfz6k0qsey2f0obdigfdc5cy24qqdgytsgcohbcr03zu1imo4slsvmnyc280oesis5iggw4kvzp33pfhucxjtwfhdtn1ifix9jrhwrkk6j4b7h0rwtlnck4chiimsda8qb90pwkxhltpdluw9tpamygmiis9ojyc5selyg8d7cx41547796633', 0),
(335, 216, 'utg1l52oufm5mp9shp7po9imy7nfohmwaw85t0r8tl6lk5c8ulg00x5hijoll5uchpwgd089nbcq02wkscvw5zyi2necoyheog814zeaskxmg8la6dewzj6hd74sj7wdhn1nd73fg4xzf4d6v4pvoh96gr4267vilfokt8nah75aan3wkt4d20o8q8fqbbxws5div1kn25sizfnll5q2qp1ox0lf1acxejkexkgi4b0q0hbm62of0pc9db746vck1547817941', 7),
(336, 228, '95i1c51ivzb2zgzoc9rhigcv1kh63vrnxxddanawmxsl7ygajg4ycp6ni1e85gmgfiims7e1i3xbsrlbgyqqhfaxjxx52gzkjpj1y87z6jxiqlzy11q3k246xatvfyssvyez2t2s5wj04qvw7qah3f4xaiszk6vqmadqfgqvdg52yvnvvo0dn4neswh6axl4mazi2i2kjjusd6jdfalg5c0p59tsi0gi90znvw2r242d223rlqxanzbmqvve2naj1547877260', 0),
(364, 232, 'ur4el5hqcswxoi6zognqlf0shlvrgya03witnbamlgia3jh3f7zax6wwsdqjtettx7e26zg0xe6wn2br016rxkxgmrjipregw8dw5lmd8aozroler3lv3re3gzmwpihndvunyajvt6yqbv0zzwrkeh8xs4upf83td5ghj0axngrh5klo0a3005io5ikdi7o854xr54jw963fk95f88hwpa6d3f7t13aylqqox68vy4bo4zpn47641opz34549wsd1549519208', 0),
(383, 231, 'waahp40ukdrwvpyrwrvq3ft7yvq48o00nbplmdkzzx12i24aitil69ft79eawk6z29ft4i1qk2njathlb4vaax99akh3vrvsc8n4ne1xkm3cy8xtzn50yk9lq56dfz4cm1y9y0uryq14kq2b9gdalaaybeqxb0mm5jz7rlxvd6ykidfchkrjmbbdy30ws1g9acpihl1w92npmo1ow39or2u38d8vgj3vz9sm1bvmt2d8nc26lzg42wctusuzn9r91551252149', 0),
(578, 21, 'gfmlvhmorzt5ux9qvxh96eo0h3vdpeiyjim8sqgzwytdugdh8c3i79cnqt86apchpiyg4cfmtja9dt973n2blojtkm8asmt4h7tv1ggknkk3boglxm3n8exnlh6i76m9r1nyrtdcg8rgxfxv1orky5y5ijxkzmssdizhfxug8wt386iu5xme4ag2vf0qb8k3do69fifco6q6bb5rj6m0bbtdzct4kktubo93mcxkl6nj6mpj8r0s6r2o2nbgq3yw1560427082', 0),
(581, 22, 'h2h8sw4wu7mbm3gqzb2qztb7p9b7edgdo22p3h5qok74r62aiq1gh3sdx85r2co5m50kn2oiove4h43zaai62jl9zkshv1v24fmowizrms479dlxx5pbbr5ge49t3p101byacg8dqutli4zwwijoxbab79v12a59yjz6eodcbxqrcfjs2klnvlwx6rwsmlv3g2li27n7izh1png0399g2729k62sargbbyrw0rgtszf97ydn9rw595nsor7benz61560435497', 0),
(590, 22, 'nu04vlicijds0mk5k8y6bvnr30vkxz80ska9c9tdo5h3aqvy1p8pk6wg5mfmo2fdpsccs8ahkp2vmp5ji817pbhkigg989lh1pr3jy3idzt5vz6z7rklx0l19x1h58qfkt4m0zuua6r49ruw5tl7ppdc6hv3bf2ea8y5tlzo9annv6l8yzeyr6191sydq8vazk7o8no789ll2dmh9pnvk866esvp3i6c7sbnairc8tiopwaxgtz4zwlclmqgnjot1560587050', 0),
(595, 1, '8rlayje3ksr8sdhs7wtwa3hy2dal52v0f7oxoyn6dyevkpstqopetwcp12jc0xnnx3ie9lcln7n0pglfhwgk8t6mpdaed9fq9wdj6se7ihmem13xjfvqvio7lprfhhqo19bt450fftdt2i91rovfj1u3whba0lzqyjwq7t6vtqenjkkhe4k5qgcabbplp44rsk0i77e0w8pq08uu8pt4xbksbzaj7wgtr4j4v1g5p8qrq20pcj690zvyphofepv91560923591', 0),
(610, 3, 'd6pdhiv81zmsn2a1alnvtht2k1kwg82hh76gvb6709vgatxlqgc6xghbh64mdrjwpjm12gev9xrhdmvb85cpyyuskao3wnrgfdpon1o5p5611eu5adv6djy4wzsmfgfhudvs6lj085rrym4f6a0etrfn80oz8jhz8so5ultu5tc0w9ne96vp0e9ivdnf0w7ok46thghp08j6f2ds1udtajo5nay61e8yvk056wkik6m9glwpaz8pdazj52b16i9c1560934288', 0),
(619, 1, 'zgz7e3xhi6fwqlnt803ld0y6wxnq7smhezdttmvkos29w13wregmqb0kz5ghmn0m35jdfao17z44gygje35vxb15b5i19voi4v2lr5yqh6f0eb6hqnkqf0f2wcdoxn8oq6cw1afshyg7okd2ju6tq5cmbenkaxzpaynwvkn5x9xvmiemp3e8gqbb39ndtymj3rea5a5gl3a64f2o1tdxhgzl30crczhyump6p94wpq8ovg4y2f8s4xvqyccvdkdo1561023488', 0);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_storage_subscription`
--

CREATE TABLE `i_u_storage_subscription` (
  `iuss_id` int(11) NOT NULL,
  `iuss_uid` int(11) DEFAULT NULL,
  `iuss_sub_start` datetime DEFAULT NULL,
  `iuss_sub_month` int(11) DEFAULT NULL,
  `iuss_renew_month` int(11) DEFAULT NULL,
  `iuss_renew_storage` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_storage_subscription`
--

INSERT INTO `i_u_storage_subscription` (`iuss_id`, `iuss_uid`, `iuss_sub_start`, `iuss_sub_month`, `iuss_renew_month`, `iuss_renew_storage`) VALUES
(3, 227, '2019-01-02 17:01:11', 0, NULL, NULL),
(20, 216, '2019-01-17 13:01:24', 0, NULL, NULL),
(45, 228, '2019-01-18 18:01:56', 0, NULL, NULL),
(65, 232, '2019-02-07 13:22:12', 0, NULL, NULL),
(66, 231, '2019-02-09 15:00:46', 0, NULL, NULL),
(72, 188, '2019-02-22 14:59:14', 0, NULL, NULL),
(90, 3, '2019-04-08 16:05:11', 0, NULL, NULL),
(127, 2, '2019-04-18 12:59:35', 12, NULL, NULL),
(134, 1, '2019-05-27 13:48:41', 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `i_u_t_copies`
--

CREATE TABLE `i_u_t_copies` (
  `iutc_id` int(10) NOT NULL,
  `iutc_owner` int(10) NOT NULL,
  `iutc_mod_id` int(10) NOT NULL,
  `iutc_temp_id` int(10) NOT NULL,
  `iutc_copies` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `i_u_t_copies`
--

INSERT INTO `i_u_t_copies` (`iutc_id`, `iutc_owner`, `iutc_mod_id`, `iutc_temp_id`, `iutc_copies`) VALUES
(215, 188, 36, 166, '1'),
(216, 188, 36, 166, '2'),
(217, 188, 36, 166, '3'),
(218, 188, 35, 167, '1'),
(219, 188, 35, 167, '2'),
(220, 188, 35, 167, '3'),
(221, 188, 42, 165, 'original'),
(222, 188, 42, 165, 'duplicate'),
(223, 188, 51, 163, '1'),
(224, 188, 51, 163, '2'),
(225, 188, 51, 163, '3'),
(228, 188, 40, 161, 'Original'),
(229, 188, 56, 168, '1'),
(230, 188, 56, 168, '2'),
(231, 188, 56, 168, '3'),
(232, 188, 56, 168, '4'),
(233, 188, 56, 168, '5'),
(258, 1, 36, 170, 'Delivery Challan'),
(259, 1, 36, 170, '1'),
(271, 1, 42, 169, 'original'),
(272, 1, 42, 169, 'duplicate'),
(291, 1, 51, 171, '1'),
(292, 1, 51, 171, '2'),
(293, 1, 51, 171, '3'),
(294, 1, 51, 171, 'Sales Quotation'),
(295, 1, 56, 168, '1'),
(296, 1, 56, 168, '2'),
(297, 1, 56, 168, '3'),
(302, 1, 68, 173, 'original'),
(303, 1, 68, 173, 'duplicate'),
(304, 1, 69, 174, 'original'),
(305, 1, 69, 174, 'duplicate'),
(306, 1, 70, 175, 'original'),
(307, 1, 70, 175, 'duplicate'),
(308, 1, 35, 172, 'original'),
(309, 1, 35, 172, 'duplicate'),
(323, 22, 72, 179, 'Original'),
(324, 22, 72, 179, 'Duplicate'),
(325, 22, 56, 179, 'Original'),
(326, 22, 56, 179, 'Duplicate'),
(327, 19, 56, 176, 'Original'),
(328, 19, 56, 176, 'Duplicate'),
(329, 19, 72, 176, 'Original'),
(330, 19, 72, 176, 'Duplicate'),
(331, 4, 72, 168, 'Original'),
(332, 4, 72, 168, 'Duplicate'),
(333, 4, 56, 168, 'Original'),
(334, 4, 56, 168, 'Duplicate');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `demo_user_details`
--
ALTER TABLE `demo_user_details`
  ADD PRIMARY KEY (`dmud_id`);

--
-- Indexes for table `i_admins`
--
ALTER TABLE `i_admins`
  ADD PRIMARY KEY (`ia_id`);

--
-- Indexes for table `i_adm_cust_prefernces`
--
ALTER TABLE `i_adm_cust_prefernces`
  ADD PRIMARY KEY (`iacp_id`);

--
-- Indexes for table `i_adm_details`
--
ALTER TABLE `i_adm_details`
  ADD PRIMARY KEY (`iad_id`);

--
-- Indexes for table `i_adm_tags`
--
ALTER TABLE `i_adm_tags`
  ADD PRIMARY KEY (`iat_id`);

--
-- Indexes for table `i_column_index`
--
ALTER TABLE `i_column_index`
  ADD PRIMARY KEY (`ici_id`);

--
-- Indexes for table `i_customers`
--
ALTER TABLE `i_customers`
  ADD PRIMARY KEY (`ic_id`);

--
-- Indexes for table `i_customers_relations`
--
ALTER TABLE `i_customers_relations`
  ADD PRIMARY KEY (`icr_id`);

--
-- Indexes for table `i_c_attendance`
--
ALTER TABLE `i_c_attendance`
  ADD PRIMARY KEY (`ica_id`);

--
-- Indexes for table `i_c_basic_details`
--
ALTER TABLE `i_c_basic_details`
  ADD PRIMARY KEY (`icbd_id`);

--
-- Indexes for table `i_c_doc`
--
ALTER TABLE `i_c_doc`
  ADD PRIMARY KEY (`icd_id`);

--
-- Indexes for table `i_c_excel_module`
--
ALTER TABLE `i_c_excel_module`
  ADD PRIMARY KEY (`icem_id`);

--
-- Indexes for table `i_c_e_m_columns`
--
ALTER TABLE `i_c_e_m_columns`
  ADD PRIMARY KEY (`icemc_id`);

--
-- Indexes for table `i_c_e_m_preferences`
--
ALTER TABLE `i_c_e_m_preferences`
  ADD PRIMARY KEY (`icemp_id`);

--
-- Indexes for table `i_c_pic`
--
ALTER TABLE `i_c_pic`
  ADD PRIMARY KEY (`icp_id`);

--
-- Indexes for table `i_c_t_prefernces`
--
ALTER TABLE `i_c_t_prefernces`
  ADD PRIMARY KEY (`ictp_id`);

--
-- Indexes for table `i_daifunc_product`
--
ALTER TABLE `i_daifunc_product`
  ADD PRIMARY KEY (`idp_id`);

--
-- Indexes for table `i_daifunc_product_group`
--
ALTER TABLE `i_daifunc_product_group`
  ADD PRIMARY KEY (`idpg_id`);

--
-- Indexes for table `i_daifunc_product_group_module`
--
ALTER TABLE `i_daifunc_product_group_module`
  ADD PRIMARY KEY (`idpgm_id`);

--
-- Indexes for table `i_daifunc_tax`
--
ALTER TABLE `i_daifunc_tax`
  ADD PRIMARY KEY (`idt_id`);

--
-- Indexes for table `i_daifunc_tax_group`
--
ALTER TABLE `i_daifunc_tax_group`
  ADD PRIMARY KEY (`idtg_id`);

--
-- Indexes for table `i_display`
--
ALTER TABLE `i_display`
  ADD PRIMARY KEY (`id_id`);

--
-- Indexes for table `i_domain`
--
ALTER TABLE `i_domain`
  ADD PRIMARY KEY (`idom_id`);

--
-- Indexes for table `i_d_values`
--
ALTER TABLE `i_d_values`
  ADD PRIMARY KEY (`idv_id`);

--
-- Indexes for table `i_explore_collection`
--
ALTER TABLE `i_explore_collection`
  ADD PRIMARY KEY (`iec_id`);

--
-- Indexes for table `i_explore_collection_module`
--
ALTER TABLE `i_explore_collection_module`
  ADD PRIMARY KEY (`iecm_id`);

--
-- Indexes for table `i_ext_broadcast`
--
ALTER TABLE `i_ext_broadcast`
  ADD PRIMARY KEY (`iebrod_id`);

--
-- Indexes for table `i_ext_broadcast_mail_batch`
--
ALTER TABLE `i_ext_broadcast_mail_batch`
  ADD PRIMARY KEY (`iextbmb_id`);

--
-- Indexes for table `i_ext_bro_contact`
--
ALTER TABLE `i_ext_bro_contact`
  ADD PRIMARY KEY (`iebrodc_id`);

--
-- Indexes for table `i_ext_ed_attendance`
--
ALTER TABLE `i_ext_ed_attendance`
  ADD PRIMARY KEY (`ieea_id`);

--
-- Indexes for table `i_ext_ed_batch`
--
ALTER TABLE `i_ext_ed_batch`
  ADD PRIMARY KEY (`iextb_id`);

--
-- Indexes for table `i_ext_ed_batch_allot`
--
ALTER TABLE `i_ext_ed_batch_allot`
  ADD PRIMARY KEY (`iextba_id`);

--
-- Indexes for table `i_ext_ed_chapters`
--
ALTER TABLE `i_ext_ed_chapters`
  ADD PRIMARY KEY (`iextc_id`);

--
-- Indexes for table `i_ext_ed_exam_schedule`
--
ALTER TABLE `i_ext_ed_exam_schedule`
  ADD PRIMARY KEY (`iextes_id`);

--
-- Indexes for table `i_ext_ed_expenses`
--
ALTER TABLE `i_ext_ed_expenses`
  ADD PRIMARY KEY (`iexte_id`);

--
-- Indexes for table `i_ext_ed_expense_tag`
--
ALTER TABLE `i_ext_ed_expense_tag`
  ADD PRIMARY KEY (`iextet_id`);

--
-- Indexes for table `i_ext_ed_external_exams`
--
ALTER TABLE `i_ext_ed_external_exams`
  ADD PRIMARY KEY (`iextee_id`);

--
-- Indexes for table `i_ext_ed_fees`
--
ALTER TABLE `i_ext_ed_fees`
  ADD PRIMARY KEY (`iextf_id`);

--
-- Indexes for table `i_ext_ed_followup`
--
ALTER TABLE `i_ext_ed_followup`
  ADD PRIMARY KEY (`iextfu_id`);

--
-- Indexes for table `i_ext_ed_homework`
--
ALTER TABLE `i_ext_ed_homework`
  ADD PRIMARY KEY (`ieeh_id`);

--
-- Indexes for table `i_ext_ed_lecture_schedule`
--
ALTER TABLE `i_ext_ed_lecture_schedule`
  ADD PRIMARY KEY (`iextls_id`);

--
-- Indexes for table `i_ext_ed_marks`
--
ALTER TABLE `i_ext_ed_marks`
  ADD PRIMARY KEY (`iextm_id`);

--
-- Indexes for table `i_ext_ed_marks_records`
--
ALTER TABLE `i_ext_ed_marks_records`
  ADD PRIMARY KEY (`iextmr_id`);

--
-- Indexes for table `i_ext_ed_marks_tags`
--
ALTER TABLE `i_ext_ed_marks_tags`
  ADD PRIMARY KEY (`iextemt_id`);

--
-- Indexes for table `i_ext_ed_preliem`
--
ALTER TABLE `i_ext_ed_preliem`
  ADD PRIMARY KEY (`iextp_id`);

--
-- Indexes for table `i_ext_ed_punishment`
--
ALTER TABLE `i_ext_ed_punishment`
  ADD PRIMARY KEY (`ieep_id`);

--
-- Indexes for table `i_ext_ed_purchases`
--
ALTER TABLE `i_ext_ed_purchases`
  ADD PRIMARY KEY (`iextp_id`);

--
-- Indexes for table `i_ext_ed_purchase_document`
--
ALTER TABLE `i_ext_ed_purchase_document`
  ADD PRIMARY KEY (`iextpd_id`);

--
-- Indexes for table `i_ext_ed_purchase_tag`
--
ALTER TABLE `i_ext_ed_purchase_tag`
  ADD PRIMARY KEY (`iextpt_id`);

--
-- Indexes for table `i_ext_ed_receipt`
--
ALTER TABLE `i_ext_ed_receipt`
  ADD PRIMARY KEY (`iextr_id`);

--
-- Indexes for table `i_ext_ed_subjects`
--
ALTER TABLE `i_ext_ed_subjects`
  ADD PRIMARY KEY (`iexts_id`);

--
-- Indexes for table `i_ext_ed_teachers`
--
ALTER TABLE `i_ext_ed_teachers`
  ADD PRIMARY KEY (`iextt_id`);

--
-- Indexes for table `i_ext_ed_teacher_subjects`
--
ALTER TABLE `i_ext_ed_teacher_subjects`
  ADD PRIMARY KEY (`iextts_id`);

--
-- Indexes for table `i_ext_ed_tips`
--
ALTER TABLE `i_ext_ed_tips`
  ADD PRIMARY KEY (`iexttp_id`);

--
-- Indexes for table `i_ext_ed_tip_tags`
--
ALTER TABLE `i_ext_ed_tip_tags`
  ADD PRIMARY KEY (`iexttt_id`);

--
-- Indexes for table `i_ext_et_ac_classes`
--
ALTER TABLE `i_ext_et_ac_classes`
  ADD PRIMARY KEY (`iextetacc_id`);

--
-- Indexes for table `i_ext_et_ac_groups`
--
ALTER TABLE `i_ext_et_ac_groups`
  ADD PRIMARY KEY (`iextetacg_id`);

--
-- Indexes for table `i_ext_et_ac_journal_entries`
--
ALTER TABLE `i_ext_et_ac_journal_entries`
  ADD PRIMARY KEY (`iextetacje_id`);

--
-- Indexes for table `i_ext_et_ac_ledgers`
--
ALTER TABLE `i_ext_et_ac_ledgers`
  ADD PRIMARY KEY (`iextetacl_id`);

--
-- Indexes for table `i_ext_et_amc`
--
ALTER TABLE `i_ext_et_amc`
  ADD PRIMARY KEY (`iextamc_id`);

--
-- Indexes for table `i_ext_et_amc_mutual`
--
ALTER TABLE `i_ext_et_amc_mutual`
  ADD PRIMARY KEY (`iextamcm_id`);

--
-- Indexes for table `i_ext_et_amc_product_details`
--
ALTER TABLE `i_ext_et_amc_product_details`
  ADD PRIMARY KEY (`iextamcpd_id`);

--
-- Indexes for table `i_ext_et_amc_property`
--
ALTER TABLE `i_ext_et_amc_property`
  ADD PRIMARY KEY (`iextamcpt_id`);

--
-- Indexes for table `i_ext_et_amc_tags`
--
ALTER TABLE `i_ext_et_amc_tags`
  ADD PRIMARY KEY (`iextamctg_id`);

--
-- Indexes for table `i_ext_et_amc_task`
--
ALTER TABLE `i_ext_et_amc_task`
  ADD PRIMARY KEY (`iextamct_id`);

--
-- Indexes for table `i_ext_et_amc_taxes`
--
ALTER TABLE `i_ext_et_amc_taxes`
  ADD PRIMARY KEY (`iextamct_id`);

--
-- Indexes for table `i_ext_et_amc_terms`
--
ALTER TABLE `i_ext_et_amc_terms`
  ADD PRIMARY KEY (`iextamctm_id`);

--
-- Indexes for table `i_ext_et_barcode`
--
ALTER TABLE `i_ext_et_barcode`
  ADD PRIMARY KEY (`iextb_id`);

--
-- Indexes for table `i_ext_et_barcode_design`
--
ALTER TABLE `i_ext_et_barcode_design`
  ADD PRIMARY KEY (`iextbd_id`);

--
-- Indexes for table `i_ext_et_barcode_printing`
--
ALTER TABLE `i_ext_et_barcode_printing`
  ADD PRIMARY KEY (`iextbp_id`);

--
-- Indexes for table `i_ext_et_boq`
--
ALTER TABLE `i_ext_et_boq`
  ADD PRIMARY KEY (`iextetboq_id`);

--
-- Indexes for table `i_ext_et_boq_fixed`
--
ALTER TABLE `i_ext_et_boq_fixed`
  ADD PRIMARY KEY (`iextetboqf_id`);

--
-- Indexes for table `i_ext_et_boq_mail`
--
ALTER TABLE `i_ext_et_boq_mail`
  ADD PRIMARY KEY (`iextetboqm_id`);

--
-- Indexes for table `i_ext_et_boq_mutual`
--
ALTER TABLE `i_ext_et_boq_mutual`
  ADD PRIMARY KEY (`iextetboqm_id`);

--
-- Indexes for table `i_ext_et_boq_template`
--
ALTER TABLE `i_ext_et_boq_template`
  ADD PRIMARY KEY (`iextetboqt_id`);

--
-- Indexes for table `i_ext_et_design_manager`
--
ALTER TABLE `i_ext_et_design_manager`
  ADD PRIMARY KEY (`iextetdm_id`);

--
-- Indexes for table `i_ext_et_design_manager_category`
--
ALTER TABLE `i_ext_et_design_manager_category`
  ADD PRIMARY KEY (`iextetdmc_id`);

--
-- Indexes for table `i_ext_et_dm_category_upload`
--
ALTER TABLE `i_ext_et_dm_category_upload`
  ADD PRIMARY KEY (`iextetdmcu_id`);

--
-- Indexes for table `i_ext_et_dm_template`
--
ALTER TABLE `i_ext_et_dm_template`
  ADD PRIMARY KEY (`iextetdmt_id`);

--
-- Indexes for table `i_ext_et_document_terms`
--
ALTER TABLE `i_ext_et_document_terms`
  ADD PRIMARY KEY (`iextdt_id`);

--
-- Indexes for table `i_ext_et_expenses`
--
ALTER TABLE `i_ext_et_expenses`
  ADD PRIMARY KEY (`iextete_id`);

--
-- Indexes for table `i_ext_et_expense_tag`
--
ALTER TABLE `i_ext_et_expense_tag`
  ADD PRIMARY KEY (`iextetet_id`);

--
-- Indexes for table `i_ext_et_extension_share`
--
ALTER TABLE `i_ext_et_extension_share`
  ADD PRIMARY KEY (`iextetes_id`);

--
-- Indexes for table `i_ext_et_extension_share_info`
--
ALTER TABLE `i_ext_et_extension_share_info`
  ADD PRIMARY KEY (`iextetesi_id`);

--
-- Indexes for table `i_ext_et_godown_location`
--
ALTER TABLE `i_ext_et_godown_location`
  ADD PRIMARY KEY (`iextetgdl_id`);

--
-- Indexes for table `i_ext_et_hr`
--
ALTER TABLE `i_ext_et_hr`
  ADD PRIMARY KEY (`iexteth_id`);

--
-- Indexes for table `i_ext_et_hr_department`
--
ALTER TABLE `i_ext_et_hr_department`
  ADD PRIMARY KEY (`iextethd_id`);

--
-- Indexes for table `i_ext_et_hr_policie`
--
ALTER TABLE `i_ext_et_hr_policie`
  ADD PRIMARY KEY (`iextethp_id`);

--
-- Indexes for table `i_ext_et_hr_shift`
--
ALTER TABLE `i_ext_et_hr_shift`
  ADD PRIMARY KEY (`iexteths_id`);

--
-- Indexes for table `i_ext_et_inventory`
--
ALTER TABLE `i_ext_et_inventory`
  ADD PRIMARY KEY (`iextei_id`);

--
-- Indexes for table `i_ext_et_inventory_details`
--
ALTER TABLE `i_ext_et_inventory_details`
  ADD PRIMARY KEY (`iexteid_id`);

--
-- Indexes for table `i_ext_et_inventory_locations`
--
ALTER TABLE `i_ext_et_inventory_locations`
  ADD PRIMARY KEY (`iexteil_id`);

--
-- Indexes for table `i_ext_et_inventory_material_location`
--
ALTER TABLE `i_ext_et_inventory_material_location`
  ADD PRIMARY KEY (`iexteiml_id`);

--
-- Indexes for table `i_ext_et_inventory_mutual`
--
ALTER TABLE `i_ext_et_inventory_mutual`
  ADD PRIMARY KEY (`iexteinm_id`);

--
-- Indexes for table `i_ext_et_inventory_property`
--
ALTER TABLE `i_ext_et_inventory_property`
  ADD PRIMARY KEY (`iexteinvept_id`);

--
-- Indexes for table `i_ext_et_inventory_replacement`
--
ALTER TABLE `i_ext_et_inventory_replacement`
  ADD PRIMARY KEY (`iexteir_id`);

--
-- Indexes for table `i_ext_et_inventory_tags`
--
ALTER TABLE `i_ext_et_inventory_tags`
  ADD PRIMARY KEY (`iextett_id`);

--
-- Indexes for table `i_ext_et_inventory_terms`
--
ALTER TABLE `i_ext_et_inventory_terms`
  ADD PRIMARY KEY (`iexteinvetm_id`);

--
-- Indexes for table `i_ext_et_invoice`
--
ALTER TABLE `i_ext_et_invoice`
  ADD PRIMARY KEY (`iextein_id`);

--
-- Indexes for table `i_ext_et_invoice_inventory_map`
--
ALTER TABLE `i_ext_et_invoice_inventory_map`
  ADD PRIMARY KEY (`iexteiim_id`);

--
-- Indexes for table `i_ext_et_invoice_mutual`
--
ALTER TABLE `i_ext_et_invoice_mutual`
  ADD PRIMARY KEY (`iexteim_id`);

--
-- Indexes for table `i_ext_et_invoice_product_details`
--
ALTER TABLE `i_ext_et_invoice_product_details`
  ADD PRIMARY KEY (`iexteinpd_id`);

--
-- Indexes for table `i_ext_et_invoice_product_taxes`
--
ALTER TABLE `i_ext_et_invoice_product_taxes`
  ADD PRIMARY KEY (`iexteinpt_id`);

--
-- Indexes for table `i_ext_et_invoice_property`
--
ALTER TABLE `i_ext_et_invoice_property`
  ADD PRIMARY KEY (`iexteinpt_id`);

--
-- Indexes for table `i_ext_et_invoice_tags`
--
ALTER TABLE `i_ext_et_invoice_tags`
  ADD PRIMARY KEY (`iexteint_id`);

--
-- Indexes for table `i_ext_et_invoice_terms`
--
ALTER TABLE `i_ext_et_invoice_terms`
  ADD PRIMARY KEY (`iexteintm_id`);

--
-- Indexes for table `i_ext_et_letter`
--
ALTER TABLE `i_ext_et_letter`
  ADD PRIMARY KEY (`iextel_id`);

--
-- Indexes for table `i_ext_et_letter_details`
--
ALTER TABLE `i_ext_et_letter_details`
  ADD PRIMARY KEY (`iexteld_id`);

--
-- Indexes for table `i_ext_et_mapping_txn`
--
ALTER TABLE `i_ext_et_mapping_txn`
  ADD PRIMARY KEY (`iextemt_id`);

--
-- Indexes for table `i_ext_et_mobile`
--
ALTER TABLE `i_ext_et_mobile`
  ADD PRIMARY KEY (`iextetm_id`);

--
-- Indexes for table `i_ext_et_mobile_cart`
--
ALTER TABLE `i_ext_et_mobile_cart`
  ADD PRIMARY KEY (`iextetmc_id`);

--
-- Indexes for table `i_ext_et_mobile_users`
--
ALTER TABLE `i_ext_et_mobile_users`
  ADD PRIMARY KEY (`iextetmu_id`);

--
-- Indexes for table `i_ext_et_opportunity`
--
ALTER TABLE `i_ext_et_opportunity`
  ADD PRIMARY KEY (`iextetop_id`);

--
-- Indexes for table `i_ext_et_opportunity_activity`
--
ALTER TABLE `i_ext_et_opportunity_activity`
  ADD PRIMARY KEY (`iexteoa_id`);

--
-- Indexes for table `i_ext_et_opportunity_information`
--
ALTER TABLE `i_ext_et_opportunity_information`
  ADD PRIMARY KEY (`iexteoi_id`);

--
-- Indexes for table `i_ext_et_opportunity_information_files`
--
ALTER TABLE `i_ext_et_opportunity_information_files`
  ADD PRIMARY KEY (`iextetoif_id`);

--
-- Indexes for table `i_ext_et_opportunity_likehood`
--
ALTER TABLE `i_ext_et_opportunity_likehood`
  ADD PRIMARY KEY (`iexteoh_id`);

--
-- Indexes for table `i_ext_et_opportunity_mutual`
--
ALTER TABLE `i_ext_et_opportunity_mutual`
  ADD PRIMARY KEY (`iexteom_id`);

--
-- Indexes for table `i_ext_et_opportunity_note`
--
ALTER TABLE `i_ext_et_opportunity_note`
  ADD PRIMARY KEY (`iexteon_id`);

--
-- Indexes for table `i_ext_et_opportunity_proposal`
--
ALTER TABLE `i_ext_et_opportunity_proposal`
  ADD PRIMARY KEY (`iexteop_id`);

--
-- Indexes for table `i_ext_et_opportunity_status`
--
ALTER TABLE `i_ext_et_opportunity_status`
  ADD PRIMARY KEY (`iexteos_id`);

--
-- Indexes for table `i_ext_et_orders`
--
ALTER TABLE `i_ext_et_orders`
  ADD PRIMARY KEY (`iextetor_id`);

--
-- Indexes for table `i_ext_et_orders_mutual`
--
ALTER TABLE `i_ext_et_orders_mutual`
  ADD PRIMARY KEY (`iextetorm_id`);

--
-- Indexes for table `i_ext_et_orders_product_details`
--
ALTER TABLE `i_ext_et_orders_product_details`
  ADD PRIMARY KEY (`iextetodp_id`);

--
-- Indexes for table `i_ext_et_orders_property`
--
ALTER TABLE `i_ext_et_orders_property`
  ADD PRIMARY KEY (`iextetorp_id`);

--
-- Indexes for table `i_ext_et_orders_terms`
--
ALTER TABLE `i_ext_et_orders_terms`
  ADD PRIMARY KEY (`iextetort_id`);

--
-- Indexes for table `i_ext_et_payment`
--
ALTER TABLE `i_ext_et_payment`
  ADD PRIMARY KEY (`iextepay_id`);

--
-- Indexes for table `i_ext_et_proposal`
--
ALTER TABLE `i_ext_et_proposal`
  ADD PRIMARY KEY (`iextepro_id`);

--
-- Indexes for table `i_ext_et_proposal_mutual`
--
ALTER TABLE `i_ext_et_proposal_mutual`
  ADD PRIMARY KEY (`iextepm_id`);

--
-- Indexes for table `i_ext_et_proposal_product_details`
--
ALTER TABLE `i_ext_et_proposal_product_details`
  ADD PRIMARY KEY (`iexteprod_id`);

--
-- Indexes for table `i_ext_et_proposal_property`
--
ALTER TABLE `i_ext_et_proposal_property`
  ADD PRIMARY KEY (`iexteppt_id`);

--
-- Indexes for table `i_ext_et_proposal_terms`
--
ALTER TABLE `i_ext_et_proposal_terms`
  ADD PRIMARY KEY (`iexteptm_id`);

--
-- Indexes for table `i_ext_et_purchase`
--
ALTER TABLE `i_ext_et_purchase`
  ADD PRIMARY KEY (`iextep_id`);

--
-- Indexes for table `i_ext_et_purchase_inventory_map`
--
ALTER TABLE `i_ext_et_purchase_inventory_map`
  ADD PRIMARY KEY (`iextepim_id`);

--
-- Indexes for table `i_ext_et_purchase_mutual`
--
ALTER TABLE `i_ext_et_purchase_mutual`
  ADD PRIMARY KEY (`iexteprcm_id`);

--
-- Indexes for table `i_ext_et_purchase_product_details`
--
ALTER TABLE `i_ext_et_purchase_product_details`
  ADD PRIMARY KEY (`iexteppd_id`);

--
-- Indexes for table `i_ext_et_purchase_product_taxes`
--
ALTER TABLE `i_ext_et_purchase_product_taxes`
  ADD PRIMARY KEY (`iexteppt_id`);

--
-- Indexes for table `i_ext_et_purchase_property`
--
ALTER TABLE `i_ext_et_purchase_property`
  ADD PRIMARY KEY (`iexteprpt_id`);

--
-- Indexes for table `i_ext_et_purchase_tags`
--
ALTER TABLE `i_ext_et_purchase_tags`
  ADD PRIMARY KEY (`iextept_id`);

--
-- Indexes for table `i_ext_et_purchase_terms`
--
ALTER TABLE `i_ext_et_purchase_terms`
  ADD PRIMARY KEY (`iexteprtm_id`);

--
-- Indexes for table `i_ext_et_quotation`
--
ALTER TABLE `i_ext_et_quotation`
  ADD PRIMARY KEY (`iexteq_id`);

--
-- Indexes for table `i_ext_et_quotation_product_details`
--
ALTER TABLE `i_ext_et_quotation_product_details`
  ADD PRIMARY KEY (`iexteqpd_id`);

--
-- Indexes for table `i_ext_et_quotation_product_taxes`
--
ALTER TABLE `i_ext_et_quotation_product_taxes`
  ADD PRIMARY KEY (`iexteqpt_id`);

--
-- Indexes for table `i_ext_et_quotation_tags`
--
ALTER TABLE `i_ext_et_quotation_tags`
  ADD PRIMARY KEY (`iexteqt_id`);

--
-- Indexes for table `i_ext_et_quotation_terms`
--
ALTER TABLE `i_ext_et_quotation_terms`
  ADD PRIMARY KEY (`iexteqtm_id`);

--
-- Indexes for table `i_ext_et_requirement`
--
ALTER TABLE `i_ext_et_requirement`
  ADD PRIMARY KEY (`iextetr_id`);

--
-- Indexes for table `i_ext_et_requirement_mutual`
--
ALTER TABLE `i_ext_et_requirement_mutual`
  ADD PRIMARY KEY (`iextetrm_id`);

--
-- Indexes for table `i_ext_et_requirement_notes`
--
ALTER TABLE `i_ext_et_requirement_notes`
  ADD PRIMARY KEY (`iextetrn_id`);

--
-- Indexes for table `i_ext_et_requirement_product`
--
ALTER TABLE `i_ext_et_requirement_product`
  ADD PRIMARY KEY (`iextetrp_id`);

--
-- Indexes for table `i_ext_et_work_module`
--
ALTER TABLE `i_ext_et_work_module`
  ADD PRIMARY KEY (`iextetwm_id`);

--
-- Indexes for table `i_ext_et_work_module_activity`
--
ALTER TABLE `i_ext_et_work_module_activity`
  ADD PRIMARY KEY (`iextetwma_id`);

--
-- Indexes for table `i_ext_et_work_module_allot`
--
ALTER TABLE `i_ext_et_work_module_allot`
  ADD PRIMARY KEY (`iextetwma_id`);

--
-- Indexes for table `i_ext_pro_product_list`
--
ALTER TABLE `i_ext_pro_product_list`
  ADD PRIMARY KEY (`iextppl_id`);

--
-- Indexes for table `i_ext_pro_project`
--
ALTER TABLE `i_ext_pro_project`
  ADD PRIMARY KEY (`iextpp_id`);

--
-- Indexes for table `i_ext_pro_project_users`
--
ALTER TABLE `i_ext_pro_project_users`
  ADD PRIMARY KEY (`iextppu_id`);

--
-- Indexes for table `i_ext_pro_task`
--
ALTER TABLE `i_ext_pro_task`
  ADD PRIMARY KEY (`iextpt_id`);

--
-- Indexes for table `i_ext_pro_task_comments`
--
ALTER TABLE `i_ext_pro_task_comments`
  ADD PRIMARY KEY (`iextptc_id`);

--
-- Indexes for table `i_ext_pro_task_group`
--
ALTER TABLE `i_ext_pro_task_group`
  ADD PRIMARY KEY (`iextptg_id`);

--
-- Indexes for table `i_ext_pro_task_group_user`
--
ALTER TABLE `i_ext_pro_task_group_user`
  ADD PRIMARY KEY (`iextptgu_id`);

--
-- Indexes for table `i_ext_pro_task_tags`
--
ALTER TABLE `i_ext_pro_task_tags`
  ADD PRIMARY KEY (`iextptt_id`);

--
-- Indexes for table `i_ext_pro_task_user`
--
ALTER TABLE `i_ext_pro_task_user`
  ADD PRIMARY KEY (`iextptu_id`);

--
-- Indexes for table `i_ext_pro_user_role`
--
ALTER TABLE `i_ext_pro_user_role`
  ADD PRIMARY KEY (`iextprour_id`);

--
-- Indexes for table `i_ext_research`
--
ALTER TABLE `i_ext_research`
  ADD PRIMARY KEY (`iextre_id`);

--
-- Indexes for table `i_ext_research_details`
--
ALTER TABLE `i_ext_research_details`
  ADD PRIMARY KEY (`iextred_id`);

--
-- Indexes for table `i_ext_support`
--
ALTER TABLE `i_ext_support`
  ADD PRIMARY KEY (`ies_id`);

--
-- Indexes for table `i_ext_support_activity`
--
ALTER TABLE `i_ext_support_activity`
  ADD PRIMARY KEY (`iesa_id`);

--
-- Indexes for table `i_ext_tags`
--
ALTER TABLE `i_ext_tags`
  ADD PRIMARY KEY (`iet_id`);

--
-- Indexes for table `i_function`
--
ALTER TABLE `i_function`
  ADD PRIMARY KEY (`ifun_id`);

--
-- Indexes for table `i_helper`
--
ALTER TABLE `i_helper`
  ADD PRIMARY KEY (`ih_id`);

--
-- Indexes for table `i_helper_parameters`
--
ALTER TABLE `i_helper_parameters`
  ADD PRIMARY KEY (`ihp_id`);

--
-- Indexes for table `i_inventory_accounts`
--
ALTER TABLE `i_inventory_accounts`
  ADD PRIMARY KEY (`iia_id`);

--
-- Indexes for table `i_inventory_new`
--
ALTER TABLE `i_inventory_new`
  ADD PRIMARY KEY (`iin_id`);

--
-- Indexes for table `i_inventory_new_order`
--
ALTER TABLE `i_inventory_new_order`
  ADD PRIMARY KEY (`iino_id`);

--
-- Indexes for table `i_join_index`
--
ALTER TABLE `i_join_index`
  ADD PRIMARY KEY (`iji_id`);

--
-- Indexes for table `i_kpis`
--
ALTER TABLE `i_kpis`
  ADD PRIMARY KEY (`ikpi_id`);

--
-- Indexes for table `i_messaging`
--
ALTER TABLE `i_messaging`
  ADD PRIMARY KEY (`ime_id`);

--
-- Indexes for table `i_modules`
--
ALTER TABLE `i_modules`
  ADD PRIMARY KEY (`im_id`);

--
-- Indexes for table `i_module_prefernces`
--
ALTER TABLE `i_module_prefernces`
  ADD PRIMARY KEY (`imp_id`);

--
-- Indexes for table `i_m_files`
--
ALTER TABLE `i_m_files`
  ADD PRIMARY KEY (`imf_id`);

--
-- Indexes for table `i_m_members`
--
ALTER TABLE `i_m_members`
  ADD PRIMARY KEY (`imm_id`);

--
-- Indexes for table `i_m_shortcuts`
--
ALTER TABLE `i_m_shortcuts`
  ADD PRIMARY KEY (`ims_id`);

--
-- Indexes for table `i_notifications`
--
ALTER TABLE `i_notifications`
  ADD PRIMARY KEY (`in_id`);

--
-- Indexes for table `i_pay_mode`
--
ALTER TABLE `i_pay_mode`
  ADD PRIMARY KEY (`ipm_id`);

--
-- Indexes for table `i_portal_module_activity_type`
--
ALTER TABLE `i_portal_module_activity_type`
  ADD PRIMARY KEY (`ipmat_id`);

--
-- Indexes for table `i_portal_price`
--
ALTER TABLE `i_portal_price`
  ADD PRIMARY KEY (`ipprice_id`);

--
-- Indexes for table `i_product`
--
ALTER TABLE `i_product`
  ADD PRIMARY KEY (`ip_id`);

--
-- Indexes for table `i_product_cat`
--
ALTER TABLE `i_product_cat`
  ADD PRIMARY KEY (`iproc_id`);

--
-- Indexes for table `i_product_pic`
--
ALTER TABLE `i_product_pic`
  ADD PRIMARY KEY (`ipp_id`);

--
-- Indexes for table `i_property`
--
ALTER TABLE `i_property`
  ADD PRIMARY KEY (`ip_id`);

--
-- Indexes for table `i_p_additional_info`
--
ALTER TABLE `i_p_additional_info`
  ADD PRIMARY KEY (`ipai_id`);

--
-- Indexes for table `i_p_child_product`
--
ALTER TABLE `i_p_child_product`
  ADD PRIMARY KEY (`ipcp_id`);

--
-- Indexes for table `i_p_features`
--
ALTER TABLE `i_p_features`
  ADD PRIMARY KEY (`ipf_id`);

--
-- Indexes for table `i_p_f_tags`
--
ALTER TABLE `i_p_f_tags`
  ADD PRIMARY KEY (`ipft_id`);

--
-- Indexes for table `i_p_price`
--
ALTER TABLE `i_p_price`
  ADD PRIMARY KEY (`ipp_id`);

--
-- Indexes for table `i_p_specification`
--
ALTER TABLE `i_p_specification`
  ADD PRIMARY KEY (`ips_id`);

--
-- Indexes for table `i_p_taxes`
--
ALTER TABLE `i_p_taxes`
  ADD PRIMARY KEY (`ipt_id`);

--
-- Indexes for table `i_store`
--
ALTER TABLE `i_store`
  ADD PRIMARY KEY (`is_id`);

--
-- Indexes for table `i_tags`
--
ALTER TABLE `i_tags`
  ADD PRIMARY KEY (`it_id`);

--
-- Indexes for table `i_taxes`
--
ALTER TABLE `i_taxes`
  ADD PRIMARY KEY (`itx_id`);

--
-- Indexes for table `i_tax_cess`
--
ALTER TABLE `i_tax_cess`
  ADD PRIMARY KEY (`itxc_id`);

--
-- Indexes for table `i_tax_group`
--
ALTER TABLE `i_tax_group`
  ADD PRIMARY KEY (`ittxg_id`);

--
-- Indexes for table `i_tax_group_collection`
--
ALTER TABLE `i_tax_group_collection`
  ADD PRIMARY KEY (`itxgc_id`);

--
-- Indexes for table `i_tc_columns`
--
ALTER TABLE `i_tc_columns`
  ADD PRIMARY KEY (`itcc_id`);

--
-- Indexes for table `i_template`
--
ALTER TABLE `i_template`
  ADD PRIMARY KEY (`itemp_id`);

--
-- Indexes for table `i_time_constraint`
--
ALTER TABLE `i_time_constraint`
  ADD PRIMARY KEY (`itc_id`);

--
-- Indexes for table `i_units`
--
ALTER TABLE `i_units`
  ADD PRIMARY KEY (`ipu_id`);

--
-- Indexes for table `i_users`
--
ALTER TABLE `i_users`
  ADD PRIMARY KEY (`i_uid`);

--
-- Indexes for table `i_users_cart`
--
ALTER TABLE `i_users_cart`
  ADD PRIMARY KEY (`iuc_id`);

--
-- Indexes for table `i_users_cart_modules`
--
ALTER TABLE `i_users_cart_modules`
  ADD PRIMARY KEY (`iucm_id`);

--
-- Indexes for table `i_users_folder`
--
ALTER TABLE `i_users_folder`
  ADD PRIMARY KEY (`iuf_id`);

--
-- Indexes for table `i_users_folder_files`
--
ALTER TABLE `i_users_folder_files`
  ADD PRIMARY KEY (`iuff_id`);

--
-- Indexes for table `i_users_visit`
--
ALTER TABLE `i_users_visit`
  ADD PRIMARY KEY (`iuv_id`);

--
-- Indexes for table `i_user_activity`
--
ALTER TABLE `i_user_activity`
  ADD PRIMARY KEY (`iua_id`);

--
-- Indexes for table `i_user_devices`
--
ALTER TABLE `i_user_devices`
  ADD PRIMARY KEY (`iu_d_id`);

--
-- Indexes for table `i_user_email_template`
--
ALTER TABLE `i_user_email_template`
  ADD PRIMARY KEY (`iuetemp_id`);

--
-- Indexes for table `i_user_group`
--
ALTER TABLE `i_user_group`
  ADD PRIMARY KEY (`iug_id`);

--
-- Indexes for table `i_user_history`
--
ALTER TABLE `i_user_history`
  ADD PRIMARY KEY (`iuh_id`);

--
-- Indexes for table `i_user_invite`
--
ALTER TABLE `i_user_invite`
  ADD PRIMARY KEY (`iui_id`);

--
-- Indexes for table `i_user_kpi`
--
ALTER TABLE `i_user_kpi`
  ADD PRIMARY KEY (`iuk_id`);

--
-- Indexes for table `i_user_scheme`
--
ALTER TABLE `i_user_scheme`
  ADD PRIMARY KEY (`iush_id`);

--
-- Indexes for table `i_user_scheme_payment`
--
ALTER TABLE `i_user_scheme_payment`
  ADD PRIMARY KEY (`iushpay_id`);

--
-- Indexes for table `i_user_scheme_txn`
--
ALTER TABLE `i_user_scheme_txn`
  ADD PRIMARY KEY (`iushtxn_id`);

--
-- Indexes for table `i_user_template`
--
ALTER TABLE `i_user_template`
  ADD PRIMARY KEY (`iut_id`);

--
-- Indexes for table `i_user_transaction`
--
ALTER TABLE `i_user_transaction`
  ADD PRIMARY KEY (`iutxn_id`);

--
-- Indexes for table `i_u_accounting`
--
ALTER TABLE `i_u_accounting`
  ADD PRIMARY KEY (`iua_id`);

--
-- Indexes for table `i_u_activity_tags`
--
ALTER TABLE `i_u_activity_tags`
  ADD PRIMARY KEY (`iuat_id`);

--
-- Indexes for table `i_u_a_active_list`
--
ALTER TABLE `i_u_a_active_list`
  ADD PRIMARY KEY (`iuaal_id`);

--
-- Indexes for table `i_u_a_log`
--
ALTER TABLE `i_u_a_log`
  ADD PRIMARY KEY (`iual_id`);

--
-- Indexes for table `i_u_a_person`
--
ALTER TABLE `i_u_a_person`
  ADD PRIMARY KEY (`iuap_id`);

--
-- Indexes for table `i_u_a_todo`
--
ALTER TABLE `i_u_a_todo`
  ADD PRIMARY KEY (`iuat_id`);

--
-- Indexes for table `i_u_details`
--
ALTER TABLE `i_u_details`
  ADD PRIMARY KEY (`iud_id`);

--
-- Indexes for table `i_u_group_subscription`
--
ALTER TABLE `i_u_group_subscription`
  ADD PRIMARY KEY (`iugs_id`);

--
-- Indexes for table `i_u_g_module`
--
ALTER TABLE `i_u_g_module`
  ADD PRIMARY KEY (`iugm_id`);

--
-- Indexes for table `i_u_g_user`
--
ALTER TABLE `i_u_g_user`
  ADD PRIMARY KEY (`iugu_id`);

--
-- Indexes for table `i_u_g_user_role`
--
ALTER TABLE `i_u_g_user_role`
  ADD PRIMARY KEY (`iugur_id`);

--
-- Indexes for table `i_u_key_performance_indicators`
--
ALTER TABLE `i_u_key_performance_indicators`
  ADD PRIMARY KEY (`iukpi_id`);

--
-- Indexes for table `i_u_login`
--
ALTER TABLE `i_u_login`
  ADD PRIMARY KEY (`iul_id`);

--
-- Indexes for table `i_u_mail`
--
ALTER TABLE `i_u_mail`
  ADD PRIMARY KEY (`iumail_id`);

--
-- Indexes for table `i_u_modules`
--
ALTER TABLE `i_u_modules`
  ADD PRIMARY KEY (`ium_id`);

--
-- Indexes for table `i_u_m_document_id`
--
ALTER TABLE `i_u_m_document_id`
  ADD PRIMARY KEY (`iumdi_id`);

--
-- Indexes for table `i_u_scheme_parameter`
--
ALTER TABLE `i_u_scheme_parameter`
  ADD PRIMARY KEY (`iushp_id`);

--
-- Indexes for table `i_u_session`
--
ALTER TABLE `i_u_session`
  ADD PRIMARY KEY (`ius_id`);

--
-- Indexes for table `i_u_storage_subscription`
--
ALTER TABLE `i_u_storage_subscription`
  ADD PRIMARY KEY (`iuss_id`);

--
-- Indexes for table `i_u_t_copies`
--
ALTER TABLE `i_u_t_copies`
  ADD PRIMARY KEY (`iutc_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `demo_user_details`
--
ALTER TABLE `demo_user_details`
  MODIFY `dmud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_admins`
--
ALTER TABLE `i_admins`
  MODIFY `ia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `i_adm_cust_prefernces`
--
ALTER TABLE `i_adm_cust_prefernces`
  MODIFY `iacp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `i_adm_details`
--
ALTER TABLE `i_adm_details`
  MODIFY `iad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_adm_tags`
--
ALTER TABLE `i_adm_tags`
  MODIFY `iat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `i_column_index`
--
ALTER TABLE `i_column_index`
  MODIFY `ici_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_customers`
--
ALTER TABLE `i_customers`
  MODIFY `ic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `i_customers_relations`
--
ALTER TABLE `i_customers_relations`
  MODIFY `icr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `i_c_attendance`
--
ALTER TABLE `i_c_attendance`
  MODIFY `ica_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT for table `i_c_basic_details`
--
ALTER TABLE `i_c_basic_details`
  MODIFY `icbd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `i_c_doc`
--
ALTER TABLE `i_c_doc`
  MODIFY `icd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_c_excel_module`
--
ALTER TABLE `i_c_excel_module`
  MODIFY `icem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `i_c_e_m_columns`
--
ALTER TABLE `i_c_e_m_columns`
  MODIFY `icemc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_c_e_m_preferences`
--
ALTER TABLE `i_c_e_m_preferences`
  MODIFY `icemp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_c_pic`
--
ALTER TABLE `i_c_pic`
  MODIFY `icp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `i_c_t_prefernces`
--
ALTER TABLE `i_c_t_prefernces`
  MODIFY `ictp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `i_daifunc_product`
--
ALTER TABLE `i_daifunc_product`
  MODIFY `idp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_daifunc_product_group`
--
ALTER TABLE `i_daifunc_product_group`
  MODIFY `idpg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `i_daifunc_product_group_module`
--
ALTER TABLE `i_daifunc_product_group_module`
  MODIFY `idpgm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `i_daifunc_tax`
--
ALTER TABLE `i_daifunc_tax`
  MODIFY `idt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `i_daifunc_tax_group`
--
ALTER TABLE `i_daifunc_tax_group`
  MODIFY `idtg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_display`
--
ALTER TABLE `i_display`
  MODIFY `id_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_domain`
--
ALTER TABLE `i_domain`
  MODIFY `idom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `i_d_values`
--
ALTER TABLE `i_d_values`
  MODIFY `idv_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_explore_collection`
--
ALTER TABLE `i_explore_collection`
  MODIFY `iec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `i_explore_collection_module`
--
ALTER TABLE `i_explore_collection_module`
  MODIFY `iecm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_ext_broadcast`
--
ALTER TABLE `i_ext_broadcast`
  MODIFY `iebrod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_ext_broadcast_mail_batch`
--
ALTER TABLE `i_ext_broadcast_mail_batch`
  MODIFY `iextbmb_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_bro_contact`
--
ALTER TABLE `i_ext_bro_contact`
  MODIFY `iebrodc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `i_ext_ed_attendance`
--
ALTER TABLE `i_ext_ed_attendance`
  MODIFY `ieea_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `i_ext_ed_batch`
--
ALTER TABLE `i_ext_ed_batch`
  MODIFY `iextb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `i_ext_ed_batch_allot`
--
ALTER TABLE `i_ext_ed_batch_allot`
  MODIFY `iextba_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `i_ext_ed_chapters`
--
ALTER TABLE `i_ext_ed_chapters`
  MODIFY `iextc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `i_ext_ed_exam_schedule`
--
ALTER TABLE `i_ext_ed_exam_schedule`
  MODIFY `iextes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `i_ext_ed_expenses`
--
ALTER TABLE `i_ext_ed_expenses`
  MODIFY `iexte_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `i_ext_ed_expense_tag`
--
ALTER TABLE `i_ext_ed_expense_tag`
  MODIFY `iextet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `i_ext_ed_external_exams`
--
ALTER TABLE `i_ext_ed_external_exams`
  MODIFY `iextee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_ed_fees`
--
ALTER TABLE `i_ext_ed_fees`
  MODIFY `iextf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `i_ext_ed_followup`
--
ALTER TABLE `i_ext_ed_followup`
  MODIFY `iextfu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_ed_homework`
--
ALTER TABLE `i_ext_ed_homework`
  MODIFY `ieeh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `i_ext_ed_lecture_schedule`
--
ALTER TABLE `i_ext_ed_lecture_schedule`
  MODIFY `iextls_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `i_ext_ed_marks`
--
ALTER TABLE `i_ext_ed_marks`
  MODIFY `iextm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `i_ext_ed_marks_records`
--
ALTER TABLE `i_ext_ed_marks_records`
  MODIFY `iextmr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `i_ext_ed_marks_tags`
--
ALTER TABLE `i_ext_ed_marks_tags`
  MODIFY `iextemt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_ed_preliem`
--
ALTER TABLE `i_ext_ed_preliem`
  MODIFY `iextp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_ed_punishment`
--
ALTER TABLE `i_ext_ed_punishment`
  MODIFY `ieep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `i_ext_ed_purchases`
--
ALTER TABLE `i_ext_ed_purchases`
  MODIFY `iextp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_ed_purchase_document`
--
ALTER TABLE `i_ext_ed_purchase_document`
  MODIFY `iextpd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_ed_purchase_tag`
--
ALTER TABLE `i_ext_ed_purchase_tag`
  MODIFY `iextpt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_ed_receipt`
--
ALTER TABLE `i_ext_ed_receipt`
  MODIFY `iextr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_ext_ed_subjects`
--
ALTER TABLE `i_ext_ed_subjects`
  MODIFY `iexts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `i_ext_ed_teachers`
--
ALTER TABLE `i_ext_ed_teachers`
  MODIFY `iextt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_ed_teacher_subjects`
--
ALTER TABLE `i_ext_ed_teacher_subjects`
  MODIFY `iextts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `i_ext_ed_tips`
--
ALTER TABLE `i_ext_ed_tips`
  MODIFY `iexttp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_ed_tip_tags`
--
ALTER TABLE `i_ext_ed_tip_tags`
  MODIFY `iexttt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_ac_classes`
--
ALTER TABLE `i_ext_et_ac_classes`
  MODIFY `iextetacc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `i_ext_et_ac_groups`
--
ALTER TABLE `i_ext_et_ac_groups`
  MODIFY `iextetacg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_et_ac_journal_entries`
--
ALTER TABLE `i_ext_et_ac_journal_entries`
  MODIFY `iextetacje_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_ext_et_ac_ledgers`
--
ALTER TABLE `i_ext_et_ac_ledgers`
  MODIFY `iextetacl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `i_ext_et_amc`
--
ALTER TABLE `i_ext_et_amc`
  MODIFY `iextamc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `i_ext_et_amc_mutual`
--
ALTER TABLE `i_ext_et_amc_mutual`
  MODIFY `iextamcm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_amc_product_details`
--
ALTER TABLE `i_ext_et_amc_product_details`
  MODIFY `iextamcpd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1673;

--
-- AUTO_INCREMENT for table `i_ext_et_amc_property`
--
ALTER TABLE `i_ext_et_amc_property`
  MODIFY `iextamcpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT for table `i_ext_et_amc_tags`
--
ALTER TABLE `i_ext_et_amc_tags`
  MODIFY `iextamctg_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_amc_task`
--
ALTER TABLE `i_ext_et_amc_task`
  MODIFY `iextamct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `i_ext_et_amc_taxes`
--
ALTER TABLE `i_ext_et_amc_taxes`
  MODIFY `iextamct_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_amc_terms`
--
ALTER TABLE `i_ext_et_amc_terms`
  MODIFY `iextamctm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT for table `i_ext_et_barcode`
--
ALTER TABLE `i_ext_et_barcode`
  MODIFY `iextb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `i_ext_et_barcode_design`
--
ALTER TABLE `i_ext_et_barcode_design`
  MODIFY `iextbd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `i_ext_et_barcode_printing`
--
ALTER TABLE `i_ext_et_barcode_printing`
  MODIFY `iextbp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

--
-- AUTO_INCREMENT for table `i_ext_et_boq`
--
ALTER TABLE `i_ext_et_boq`
  MODIFY `iextetboq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `i_ext_et_boq_fixed`
--
ALTER TABLE `i_ext_et_boq_fixed`
  MODIFY `iextetboqf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `i_ext_et_boq_mail`
--
ALTER TABLE `i_ext_et_boq_mail`
  MODIFY `iextetboqm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `i_ext_et_boq_mutual`
--
ALTER TABLE `i_ext_et_boq_mutual`
  MODIFY `iextetboqm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `i_ext_et_boq_template`
--
ALTER TABLE `i_ext_et_boq_template`
  MODIFY `iextetboqt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `i_ext_et_design_manager`
--
ALTER TABLE `i_ext_et_design_manager`
  MODIFY `iextetdm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_ext_et_design_manager_category`
--
ALTER TABLE `i_ext_et_design_manager_category`
  MODIFY `iextetdmc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `i_ext_et_dm_category_upload`
--
ALTER TABLE `i_ext_et_dm_category_upload`
  MODIFY `iextetdmcu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `i_ext_et_dm_template`
--
ALTER TABLE `i_ext_et_dm_template`
  MODIFY `iextetdmt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_ext_et_document_terms`
--
ALTER TABLE `i_ext_et_document_terms`
  MODIFY `iextdt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `i_ext_et_expenses`
--
ALTER TABLE `i_ext_et_expenses`
  MODIFY `iextete_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `i_ext_et_expense_tag`
--
ALTER TABLE `i_ext_et_expense_tag`
  MODIFY `iextetet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_extension_share`
--
ALTER TABLE `i_ext_et_extension_share`
  MODIFY `iextetes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `i_ext_et_extension_share_info`
--
ALTER TABLE `i_ext_et_extension_share_info`
  MODIFY `iextetesi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `i_ext_et_godown_location`
--
ALTER TABLE `i_ext_et_godown_location`
  MODIFY `iextetgdl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `i_ext_et_hr`
--
ALTER TABLE `i_ext_et_hr`
  MODIFY `iexteth_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `i_ext_et_hr_department`
--
ALTER TABLE `i_ext_et_hr_department`
  MODIFY `iextethd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_ext_et_hr_policie`
--
ALTER TABLE `i_ext_et_hr_policie`
  MODIFY `iextethp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `i_ext_et_hr_shift`
--
ALTER TABLE `i_ext_et_hr_shift`
  MODIFY `iexteths_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory`
--
ALTER TABLE `i_ext_et_inventory`
  MODIFY `iextei_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_details`
--
ALTER TABLE `i_ext_et_inventory_details`
  MODIFY `iexteid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_locations`
--
ALTER TABLE `i_ext_et_inventory_locations`
  MODIFY `iexteil_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_material_location`
--
ALTER TABLE `i_ext_et_inventory_material_location`
  MODIFY `iexteiml_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_mutual`
--
ALTER TABLE `i_ext_et_inventory_mutual`
  MODIFY `iexteinm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_property`
--
ALTER TABLE `i_ext_et_inventory_property`
  MODIFY `iexteinvept_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_replacement`
--
ALTER TABLE `i_ext_et_inventory_replacement`
  MODIFY `iexteir_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_tags`
--
ALTER TABLE `i_ext_et_inventory_tags`
  MODIFY `iextett_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `i_ext_et_inventory_terms`
--
ALTER TABLE `i_ext_et_inventory_terms`
  MODIFY `iexteinvetm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice`
--
ALTER TABLE `i_ext_et_invoice`
  MODIFY `iextein_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice_inventory_map`
--
ALTER TABLE `i_ext_et_invoice_inventory_map`
  MODIFY `iexteiim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice_mutual`
--
ALTER TABLE `i_ext_et_invoice_mutual`
  MODIFY `iexteim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice_product_details`
--
ALTER TABLE `i_ext_et_invoice_product_details`
  MODIFY `iexteinpd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1141;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice_product_taxes`
--
ALTER TABLE `i_ext_et_invoice_product_taxes`
  MODIFY `iexteinpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3772;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice_property`
--
ALTER TABLE `i_ext_et_invoice_property`
  MODIFY `iexteinpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice_tags`
--
ALTER TABLE `i_ext_et_invoice_tags`
  MODIFY `iexteint_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_invoice_terms`
--
ALTER TABLE `i_ext_et_invoice_terms`
  MODIFY `iexteintm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6359;

--
-- AUTO_INCREMENT for table `i_ext_et_letter`
--
ALTER TABLE `i_ext_et_letter`
  MODIFY `iextel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `i_ext_et_letter_details`
--
ALTER TABLE `i_ext_et_letter_details`
  MODIFY `iexteld_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `i_ext_et_mapping_txn`
--
ALTER TABLE `i_ext_et_mapping_txn`
  MODIFY `iextemt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `i_ext_et_mobile`
--
ALTER TABLE `i_ext_et_mobile`
  MODIFY `iextetm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_ext_et_mobile_cart`
--
ALTER TABLE `i_ext_et_mobile_cart`
  MODIFY `iextetmc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `i_ext_et_mobile_users`
--
ALTER TABLE `i_ext_et_mobile_users`
  MODIFY `iextetmu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity`
--
ALTER TABLE `i_ext_et_opportunity`
  MODIFY `iextetop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_activity`
--
ALTER TABLE `i_ext_et_opportunity_activity`
  MODIFY `iexteoa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_information`
--
ALTER TABLE `i_ext_et_opportunity_information`
  MODIFY `iexteoi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_information_files`
--
ALTER TABLE `i_ext_et_opportunity_information_files`
  MODIFY `iextetoif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_likehood`
--
ALTER TABLE `i_ext_et_opportunity_likehood`
  MODIFY `iexteoh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_mutual`
--
ALTER TABLE `i_ext_et_opportunity_mutual`
  MODIFY `iexteom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_note`
--
ALTER TABLE `i_ext_et_opportunity_note`
  MODIFY `iexteon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_proposal`
--
ALTER TABLE `i_ext_et_opportunity_proposal`
  MODIFY `iexteop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `i_ext_et_opportunity_status`
--
ALTER TABLE `i_ext_et_opportunity_status`
  MODIFY `iexteos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `i_ext_et_orders`
--
ALTER TABLE `i_ext_et_orders`
  MODIFY `iextetor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `i_ext_et_orders_mutual`
--
ALTER TABLE `i_ext_et_orders_mutual`
  MODIFY `iextetorm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_orders_product_details`
--
ALTER TABLE `i_ext_et_orders_product_details`
  MODIFY `iextetodp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `i_ext_et_orders_property`
--
ALTER TABLE `i_ext_et_orders_property`
  MODIFY `iextetorp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `i_ext_et_orders_terms`
--
ALTER TABLE `i_ext_et_orders_terms`
  MODIFY `iextetort_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `i_ext_et_payment`
--
ALTER TABLE `i_ext_et_payment`
  MODIFY `iextepay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `i_ext_et_proposal`
--
ALTER TABLE `i_ext_et_proposal`
  MODIFY `iextepro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `i_ext_et_proposal_mutual`
--
ALTER TABLE `i_ext_et_proposal_mutual`
  MODIFY `iextepm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_proposal_product_details`
--
ALTER TABLE `i_ext_et_proposal_product_details`
  MODIFY `iexteprod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `i_ext_et_proposal_property`
--
ALTER TABLE `i_ext_et_proposal_property`
  MODIFY `iexteppt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `i_ext_et_proposal_terms`
--
ALTER TABLE `i_ext_et_proposal_terms`
  MODIFY `iexteptm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase`
--
ALTER TABLE `i_ext_et_purchase`
  MODIFY `iextep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase_inventory_map`
--
ALTER TABLE `i_ext_et_purchase_inventory_map`
  MODIFY `iextepim_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase_mutual`
--
ALTER TABLE `i_ext_et_purchase_mutual`
  MODIFY `iexteprcm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase_product_details`
--
ALTER TABLE `i_ext_et_purchase_product_details`
  MODIFY `iexteppd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase_product_taxes`
--
ALTER TABLE `i_ext_et_purchase_product_taxes`
  MODIFY `iexteppt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase_property`
--
ALTER TABLE `i_ext_et_purchase_property`
  MODIFY `iexteprpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase_tags`
--
ALTER TABLE `i_ext_et_purchase_tags`
  MODIFY `iextept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `i_ext_et_purchase_terms`
--
ALTER TABLE `i_ext_et_purchase_terms`
  MODIFY `iexteprtm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_et_quotation`
--
ALTER TABLE `i_ext_et_quotation`
  MODIFY `iexteq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `i_ext_et_quotation_product_details`
--
ALTER TABLE `i_ext_et_quotation_product_details`
  MODIFY `iexteqpd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=732;

--
-- AUTO_INCREMENT for table `i_ext_et_quotation_product_taxes`
--
ALTER TABLE `i_ext_et_quotation_product_taxes`
  MODIFY `iexteqpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1087;

--
-- AUTO_INCREMENT for table `i_ext_et_quotation_tags`
--
ALTER TABLE `i_ext_et_quotation_tags`
  MODIFY `iexteqt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_et_quotation_terms`
--
ALTER TABLE `i_ext_et_quotation_terms`
  MODIFY `iexteqtm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=473;

--
-- AUTO_INCREMENT for table `i_ext_et_requirement`
--
ALTER TABLE `i_ext_et_requirement`
  MODIFY `iextetr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `i_ext_et_requirement_mutual`
--
ALTER TABLE `i_ext_et_requirement_mutual`
  MODIFY `iextetrm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `i_ext_et_requirement_notes`
--
ALTER TABLE `i_ext_et_requirement_notes`
  MODIFY `iextetrn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `i_ext_et_requirement_product`
--
ALTER TABLE `i_ext_et_requirement_product`
  MODIFY `iextetrp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `i_ext_et_work_module`
--
ALTER TABLE `i_ext_et_work_module`
  MODIFY `iextetwm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_ext_et_work_module_activity`
--
ALTER TABLE `i_ext_et_work_module_activity`
  MODIFY `iextetwma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `i_ext_et_work_module_allot`
--
ALTER TABLE `i_ext_et_work_module_allot`
  MODIFY `iextetwma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `i_ext_pro_product_list`
--
ALTER TABLE `i_ext_pro_product_list`
  MODIFY `iextppl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `i_ext_pro_project`
--
ALTER TABLE `i_ext_pro_project`
  MODIFY `iextpp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `i_ext_pro_project_users`
--
ALTER TABLE `i_ext_pro_project_users`
  MODIFY `iextppu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `i_ext_pro_task`
--
ALTER TABLE `i_ext_pro_task`
  MODIFY `iextpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_ext_pro_task_comments`
--
ALTER TABLE `i_ext_pro_task_comments`
  MODIFY `iextptc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `i_ext_pro_task_group`
--
ALTER TABLE `i_ext_pro_task_group`
  MODIFY `iextptg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `i_ext_pro_task_group_user`
--
ALTER TABLE `i_ext_pro_task_group_user`
  MODIFY `iextptgu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `i_ext_pro_task_tags`
--
ALTER TABLE `i_ext_pro_task_tags`
  MODIFY `iextptt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_pro_task_user`
--
ALTER TABLE `i_ext_pro_task_user`
  MODIFY `iextptu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_ext_pro_user_role`
--
ALTER TABLE `i_ext_pro_user_role`
  MODIFY `iextprour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `i_ext_research`
--
ALTER TABLE `i_ext_research`
  MODIFY `iextre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_ext_research_details`
--
ALTER TABLE `i_ext_research_details`
  MODIFY `iextred_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `i_ext_support`
--
ALTER TABLE `i_ext_support`
  MODIFY `ies_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_support_activity`
--
ALTER TABLE `i_ext_support_activity`
  MODIFY `iesa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_ext_tags`
--
ALTER TABLE `i_ext_tags`
  MODIFY `iet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=419;

--
-- AUTO_INCREMENT for table `i_function`
--
ALTER TABLE `i_function`
  MODIFY `ifun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `i_helper`
--
ALTER TABLE `i_helper`
  MODIFY `ih_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `i_helper_parameters`
--
ALTER TABLE `i_helper_parameters`
  MODIFY `ihp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `i_inventory_accounts`
--
ALTER TABLE `i_inventory_accounts`
  MODIFY `iia_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `i_inventory_new`
--
ALTER TABLE `i_inventory_new`
  MODIFY `iin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `i_inventory_new_order`
--
ALTER TABLE `i_inventory_new_order`
  MODIFY `iino_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `i_join_index`
--
ALTER TABLE `i_join_index`
  MODIFY `iji_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `i_kpis`
--
ALTER TABLE `i_kpis`
  MODIFY `ikpi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_messaging`
--
ALTER TABLE `i_messaging`
  MODIFY `ime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `i_modules`
--
ALTER TABLE `i_modules`
  MODIFY `im_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `i_module_prefernces`
--
ALTER TABLE `i_module_prefernces`
  MODIFY `imp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `i_m_files`
--
ALTER TABLE `i_m_files`
  MODIFY `imf_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_m_members`
--
ALTER TABLE `i_m_members`
  MODIFY `imm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `i_m_shortcuts`
--
ALTER TABLE `i_m_shortcuts`
  MODIFY `ims_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `i_notifications`
--
ALTER TABLE `i_notifications`
  MODIFY `in_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `i_pay_mode`
--
ALTER TABLE `i_pay_mode`
  MODIFY `ipm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_portal_module_activity_type`
--
ALTER TABLE `i_portal_module_activity_type`
  MODIFY `ipmat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `i_portal_price`
--
ALTER TABLE `i_portal_price`
  MODIFY `ipprice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_product`
--
ALTER TABLE `i_product`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=423;

--
-- AUTO_INCREMENT for table `i_product_cat`
--
ALTER TABLE `i_product_cat`
  MODIFY `iproc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `i_product_pic`
--
ALTER TABLE `i_product_pic`
  MODIFY `ipp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `i_property`
--
ALTER TABLE `i_property`
  MODIFY `ip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `i_p_additional_info`
--
ALTER TABLE `i_p_additional_info`
  MODIFY `ipai_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `i_p_child_product`
--
ALTER TABLE `i_p_child_product`
  MODIFY `ipcp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `i_p_features`
--
ALTER TABLE `i_p_features`
  MODIFY `ipf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `i_p_f_tags`
--
ALTER TABLE `i_p_f_tags`
  MODIFY `ipft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `i_p_price`
--
ALTER TABLE `i_p_price`
  MODIFY `ipp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=365;

--
-- AUTO_INCREMENT for table `i_p_specification`
--
ALTER TABLE `i_p_specification`
  MODIFY `ips_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_p_taxes`
--
ALTER TABLE `i_p_taxes`
  MODIFY `ipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT for table `i_store`
--
ALTER TABLE `i_store`
  MODIFY `is_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_tags`
--
ALTER TABLE `i_tags`
  MODIFY `it_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2125;

--
-- AUTO_INCREMENT for table `i_taxes`
--
ALTER TABLE `i_taxes`
  MODIFY `itx_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `i_tax_cess`
--
ALTER TABLE `i_tax_cess`
  MODIFY `itxc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_tax_group`
--
ALTER TABLE `i_tax_group`
  MODIFY `ittxg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `i_tax_group_collection`
--
ALTER TABLE `i_tax_group_collection`
  MODIFY `itxgc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `i_tc_columns`
--
ALTER TABLE `i_tc_columns`
  MODIFY `itcc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_template`
--
ALTER TABLE `i_template`
  MODIFY `itemp_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `i_time_constraint`
--
ALTER TABLE `i_time_constraint`
  MODIFY `itc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_units`
--
ALTER TABLE `i_units`
  MODIFY `ipu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT for table `i_users`
--
ALTER TABLE `i_users`
  MODIFY `i_uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_users_cart`
--
ALTER TABLE `i_users_cart`
  MODIFY `iuc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_users_cart_modules`
--
ALTER TABLE `i_users_cart_modules`
  MODIFY `iucm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `i_users_folder`
--
ALTER TABLE `i_users_folder`
  MODIFY `iuf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `i_users_folder_files`
--
ALTER TABLE `i_users_folder_files`
  MODIFY `iuff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `i_users_visit`
--
ALTER TABLE `i_users_visit`
  MODIFY `iuv_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `i_user_activity`
--
ALTER TABLE `i_user_activity`
  MODIFY `iua_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `i_user_devices`
--
ALTER TABLE `i_user_devices`
  MODIFY `iu_d_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_user_email_template`
--
ALTER TABLE `i_user_email_template`
  MODIFY `iuetemp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `i_user_group`
--
ALTER TABLE `i_user_group`
  MODIFY `iug_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_user_history`
--
ALTER TABLE `i_user_history`
  MODIFY `iuh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1526;

--
-- AUTO_INCREMENT for table `i_user_invite`
--
ALTER TABLE `i_user_invite`
  MODIFY `iui_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_user_kpi`
--
ALTER TABLE `i_user_kpi`
  MODIFY `iuk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `i_user_scheme`
--
ALTER TABLE `i_user_scheme`
  MODIFY `iush_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `i_user_scheme_payment`
--
ALTER TABLE `i_user_scheme_payment`
  MODIFY `iushpay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `i_user_scheme_txn`
--
ALTER TABLE `i_user_scheme_txn`
  MODIFY `iushtxn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `i_user_template`
--
ALTER TABLE `i_user_template`
  MODIFY `iut_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `i_user_transaction`
--
ALTER TABLE `i_user_transaction`
  MODIFY `iutxn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `i_u_accounting`
--
ALTER TABLE `i_u_accounting`
  MODIFY `iua_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `i_u_activity_tags`
--
ALTER TABLE `i_u_activity_tags`
  MODIFY `iuat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `i_u_a_active_list`
--
ALTER TABLE `i_u_a_active_list`
  MODIFY `iuaal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `i_u_a_log`
--
ALTER TABLE `i_u_a_log`
  MODIFY `iual_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34665;

--
-- AUTO_INCREMENT for table `i_u_a_person`
--
ALTER TABLE `i_u_a_person`
  MODIFY `iuap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT for table `i_u_a_todo`
--
ALTER TABLE `i_u_a_todo`
  MODIFY `iuat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1320;

--
-- AUTO_INCREMENT for table `i_u_details`
--
ALTER TABLE `i_u_details`
  MODIFY `iud_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `i_u_group_subscription`
--
ALTER TABLE `i_u_group_subscription`
  MODIFY `iugs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `i_u_g_module`
--
ALTER TABLE `i_u_g_module`
  MODIFY `iugm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_u_g_user`
--
ALTER TABLE `i_u_g_user`
  MODIFY `iugu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_u_g_user_role`
--
ALTER TABLE `i_u_g_user_role`
  MODIFY `iugur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `i_u_key_performance_indicators`
--
ALTER TABLE `i_u_key_performance_indicators`
  MODIFY `iukpi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `i_u_login`
--
ALTER TABLE `i_u_login`
  MODIFY `iul_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_u_mail`
--
ALTER TABLE `i_u_mail`
  MODIFY `iumail_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `i_u_modules`
--
ALTER TABLE `i_u_modules`
  MODIFY `ium_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `i_u_m_document_id`
--
ALTER TABLE `i_u_m_document_id`
  MODIFY `iumdi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `i_u_scheme_parameter`
--
ALTER TABLE `i_u_scheme_parameter`
  MODIFY `iushp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `i_u_session`
--
ALTER TABLE `i_u_session`
  MODIFY `ius_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=620;

--
-- AUTO_INCREMENT for table `i_u_storage_subscription`
--
ALTER TABLE `i_u_storage_subscription`
  MODIFY `iuss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `i_u_t_copies`
--
ALTER TABLE `i_u_t_copies`
  MODIFY `iutc_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
