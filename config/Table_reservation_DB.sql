-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 08, 2024 at 08:54 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Table_reservation_DB`
--

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE `details` (
  `details_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `number_phone` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `status_pay` enum('0','1','2') NOT NULL,
  `file` varchar(255) NOT NULL,
  `data_type` enum('shirt','table') NOT NULL,
  `time_reservation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_shirt_items`
--

CREATE TABLE `order_shirt_items` (
  `order_id` int(11) NOT NULL,
  `details_id` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_table_items`
--

CREATE TABLE `order_table_items` (
  `reservation_item_id` int(11) NOT NULL,
  `details_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `time_re` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `table_re`
--

CREATE TABLE `table_re` (
  `table_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  `table_number` varchar(50) NOT NULL,
  `table_status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `table_re`
--

INSERT INTO `table_re` (`table_id`, `zone_id`, `table_number`, `table_status`) VALUES
(66, 3, '1', '0'),
(67, 3, '2', '0'),
(68, 3, '3', '0'),
(69, 3, '4', '0'),
(70, 3, '5', '0'),
(71, 3, '6', '0'),
(72, 3, '7', '0'),
(73, 3, '8', '0'),
(74, 3, '9', '0'),
(75, 3, '10', '0'),
(76, 3, '11', '0'),
(77, 3, '12', '0'),
(78, 3, '13', '0'),
(79, 3, '14', '0'),
(80, 3, '15', '0'),
(81, 3, '16', '0'),
(82, 3, '17', '0'),
(83, 3, '18', '0'),
(84, 3, '19', '0'),
(85, 3, '20', '0'),
(86, 3, '21', '0'),
(87, 3, '22', '0'),
(88, 3, '23', '0'),
(89, 3, '24', '0'),
(90, 4, '1', '0'),
(91, 4, '2', '0'),
(92, 4, '3', '0'),
(93, 4, '4', '0'),
(94, 4, '5', '0'),
(95, 4, '6', '0'),
(96, 4, '7', '0'),
(97, 4, '8', '0'),
(98, 4, '9', '0'),
(99, 4, '10', '0'),
(100, 4, '11', '0'),
(101, 4, '12', '0'),
(102, 4, '13', '0'),
(103, 4, '14', '0'),
(104, 4, '15', '0'),
(105, 4, '16', '0'),
(106, 4, '17', '0'),
(107, 4, '18', '0'),
(108, 4, '19', '0'),
(109, 4, '20', '0'),
(110, 4, '21', '0'),
(111, 4, '22', '0'),
(112, 4, '23', '0'),
(113, 4, '24', '0'),
(114, 4, '25', '0'),
(115, 4, '26', '0'),
(116, 4, '27', '0'),
(117, 4, '28', '0'),
(118, 4, '29', '0'),
(119, 4, '30', '0'),
(120, 4, '31', '0'),
(121, 4, '32', '0'),
(122, 4, '33', '0'),
(123, 4, '34', '0'),
(124, 4, '35', '0'),
(125, 4, '36', '0'),
(126, 4, '37', '0'),
(127, 4, '38', '0'),
(128, 4, '39', '0'),
(129, 4, '40', '0'),
(130, 5, '1', '0'),
(131, 5, '2', '0'),
(132, 5, '3', '0'),
(133, 5, '4', '0'),
(134, 5, '5', '0'),
(135, 5, '6', '0'),
(136, 5, '7', '0'),
(137, 5, '8', '0'),
(138, 5, '9', '0'),
(139, 5, '10', '0'),
(140, 5, '11', '0'),
(141, 5, '12', '0'),
(142, 5, '13', '0'),
(143, 5, '14', '0'),
(144, 5, '15', '0'),
(145, 5, '16', '0'),
(146, 5, '17', '0'),
(147, 5, '18', '0'),
(148, 5, '19', '0'),
(149, 5, '20', '0'),
(150, 5, '21', '0'),
(151, 5, '22', '0'),
(152, 5, '23', '0'),
(153, 5, '24', '0'),
(154, 5, '25', '0'),
(155, 5, '26', '0'),
(156, 5, '27', '0'),
(157, 5, '28', '0'),
(158, 5, '29', '0'),
(159, 5, '30', '0'),
(160, 5, '31', '0'),
(161, 5, '32', '0'),
(162, 5, '33', '0'),
(163, 5, '34', '0'),
(164, 5, '35', '0'),
(165, 5, '36', '0'),
(166, 5, '37', '0'),
(167, 5, '38', '0'),
(168, 5, '39', '0'),
(169, 5, '40', '0'),
(170, 6, '1', '0'),
(171, 6, '2', '0'),
(172, 6, '3', '0'),
(173, 6, '4', '0'),
(174, 6, '5', '0'),
(175, 6, '6', '0'),
(176, 6, '7', '0'),
(177, 6, '8', '0'),
(178, 6, '9', '0'),
(179, 6, '10', '0'),
(180, 6, '11', '0'),
(181, 6, '12', '0'),
(182, 6, '13', '0'),
(183, 6, '14', '0'),
(184, 6, '15', '0'),
(185, 6, '16', '0'),
(186, 6, '17', '0'),
(187, 6, '18', '0'),
(188, 6, '19', '0'),
(189, 6, '20', '0'),
(190, 6, '21', '0'),
(191, 6, '22', '0'),
(192, 6, '23', '0'),
(193, 6, '24', '0'),
(194, 6, '25', '0'),
(195, 6, '26', '0'),
(196, 6, '27', '0'),
(197, 6, '28', '0'),
(198, 6, '29', '0'),
(199, 6, '30', '0'),
(200, 6, '31', '0'),
(201, 6, '32', '0'),
(202, 6, '33', '0'),
(203, 6, '34', '0'),
(204, 6, '35', '0'),
(205, 6, '36', '0'),
(206, 6, '37', '0'),
(207, 6, '38', '0'),
(208, 6, '39', '0'),
(209, 6, '40', '0'),
(210, 7, '1', '0'),
(211, 7, '2', '0'),
(212, 7, '3', '0'),
(213, 7, '4', '0'),
(214, 7, '5', '0'),
(215, 7, '6', '0'),
(216, 7, '7', '0'),
(217, 7, '8', '0'),
(218, 7, '9', '0'),
(219, 7, '10', '0'),
(220, 7, '11', '0'),
(221, 7, '12', '0'),
(222, 7, '13', '0'),
(223, 7, '14', '0'),
(224, 7, '15', '0'),
(225, 7, '16', '0'),
(226, 7, '17', '0'),
(227, 7, '18', '0'),
(228, 7, '19', '0'),
(229, 7, '20', '0'),
(230, 7, '21', '0'),
(231, 7, '22', '0'),
(232, 7, '23', '0'),
(233, 7, '24', '0'),
(234, 7, '25', '0'),
(235, 7, '26', '0'),
(236, 7, '27', '0'),
(237, 7, '28', '0'),
(238, 7, '29', '0'),
(239, 7, '30', '0'),
(240, 7, '31', '0'),
(241, 7, '32', '0'),
(242, 7, '33', '0'),
(243, 7, '34', '0'),
(244, 7, '35', '0'),
(245, 7, '36', '0'),
(246, 8, '1', '0'),
(247, 8, '2', '0'),
(248, 8, '3', '0'),
(249, 8, '4', '0'),
(250, 8, '5', '0'),
(251, 8, '6', '0'),
(252, 8, '7', '0'),
(253, 8, '8', '0'),
(254, 8, '9', '0'),
(255, 8, '10', '0'),
(256, 8, '11', '0'),
(257, 8, '12', '0'),
(258, 9, '18', '0'),
(259, 9, '19', '0'),
(260, 9, '20', '0'),
(261, 9, '21', '0'),
(262, 9, '22', '0'),
(263, 9, '23', '0'),
(264, 9, '24', '0'),
(265, 9, '25', '0'),
(266, 9, '26', '0'),
(267, 9, '27', '0'),
(268, 9, '28', '0'),
(269, 9, '29', '0'),
(270, 9, '30', '0'),
(271, 9, '31', '0'),
(272, 9, '32', '0'),
(273, 9, '33', '0'),
(274, 9, '34', '0'),
(275, 9, '35', '0');

-- --------------------------------------------------------

--
-- Table structure for table `zone_table`
--

CREATE TABLE `zone_table` (
  `zone_id` int(11) NOT NULL,
  `zone_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zone_table`
--

INSERT INTO `zone_table` (`zone_id`, `zone_name`) VALUES
(3, 'A'),
(4, 'D'),
(5, 'E'),
(6, 'F'),
(7, 'C'),
(8, 'B'),
(9, 'G');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`details_id`);

--
-- Indexes for table `order_shirt_items`
--
ALTER TABLE `order_shirt_items`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_table_items`
--
ALTER TABLE `order_table_items`
  ADD PRIMARY KEY (`reservation_item_id`);

--
-- Indexes for table `table_re`
--
ALTER TABLE `table_re`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `zone_table`
--
ALTER TABLE `zone_table`
  ADD PRIMARY KEY (`zone_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `details`
--
ALTER TABLE `details`
  MODIFY `details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `order_shirt_items`
--
ALTER TABLE `order_shirt_items`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `order_table_items`
--
ALTER TABLE `order_table_items`
  MODIFY `reservation_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `table_re`
--
ALTER TABLE `table_re`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT for table `zone_table`
--
ALTER TABLE `zone_table`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
