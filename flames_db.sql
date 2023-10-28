-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 25, 2023 at 06:55 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `flames_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `compatibility`
--

CREATE TABLE `compatibility` (
  `id` int(11) NOT NULL,
  `prospect_one_zodiac` varchar(50) NOT NULL,
  `prospect_two_zodiac` varchar(50) NOT NULL,
  `compatibility` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compatibility`
--

INSERT INTO `compatibility` (`id`, `prospect_one_zodiac`, `prospect_two_zodiac`, `compatibility`) VALUES
(1, 'Aries', 'Aries', 'Great Match'),
(2, 'Aries', 'Leo', 'Great Match'),
(3, 'Aries', 'Sagittarius', 'Great Match'),
(4, 'Aries', 'Taurus', 'Not Favorable'),
(5, 'Aries', 'Virgo', 'Not Favorable'),
(6, 'Aries', 'Capricornus', 'Not Favorable'),
(7, 'Aries', 'Gemini', 'Great Match'),
(8, 'Aries', 'Libra', 'Great Match'),
(9, 'Aries', 'Aquarius', 'Great Match'),
(10, 'Aries', 'Cancer', 'Not Favorable'),
(11, 'Aries', 'Scorpio', 'Not Favorable'),
(12, 'Aries', 'Pisces', 'Favorable Match'),
(13, 'Leo', 'Aries', 'Great Match'),
(14, 'Leo', 'Leo', 'Great Match'),
(15, 'Leo', 'Sagittarius', 'Great Match'),
(16, 'Leo', 'Taurus', 'Not Favorable'),
(17, 'Leo', 'Virgo', 'Not Favorable'),
(18, 'Leo', 'Capricornus', 'Not Favorable'),
(19, 'Leo', 'Gemini', 'Great Match'),
(20, 'Leo', 'Libra', 'Great Match'),
(21, 'Leo', 'Aquarius', 'Great Match'),
(22, 'Leo', 'Cancer', 'Favorable Match'),
(23, 'Leo', 'Scorpio', 'Favorable Match'),
(24, 'Leo', 'Pisces', 'Favorable Match'),
(25, 'Sagittarius', 'Aries', 'Great Match'),
(26, 'Sagittarius', 'Leo', 'Great Match'),
(27, 'Sagittarius', 'Sagittarius', 'Great Match'),
(28, 'Sagittarius', 'Taurus', 'Not Favorable'),
(29, 'Sagittarius', 'Virgo', 'Not Favorable'),
(30, 'Sagittarius', 'Capricornus', 'Not Favorable'),
(31, 'Sagittarius', 'Gemini', 'Great Match'),
(32, 'Sagittarius', 'Libra', 'Great Match'),
(33, 'Sagittarius', 'Aquarius', 'Great Match'),
(34, 'Sagittarius', 'Cancer', 'Favorable Match'),
(35, 'Sagittarius', 'Scorpio', 'Favorable Match'),
(36, 'Sagittarius', 'Pisces', 'Favorable Match'),
(37, 'Taurus', 'Aries', 'Not Favorable'),
(38, 'Taurus', 'Leo', 'Favorable Match'),
(39, 'Taurus', 'Sagittarius', 'Not Favorable'),
(40, 'Taurus', 'Taurus', 'Great Match'),
(41, 'Taurus', 'Virgo', 'Great Match'),
(42, 'Taurus', 'Capricornus', 'Great Match'),
(43, 'Taurus', 'Gemini', 'Not Favorable'),
(44, 'Taurus', 'Libra', 'Favorable Match'),
(45, 'Taurus', 'Aquarius', 'Not Favorable'),
(46, 'Taurus', 'Cancer', 'Great Match'),
(47, 'Taurus', 'Scorpio', 'Great Match'),
(48, 'Taurus', 'Pisces', 'Great Match'),
(49, 'Virgo', 'Aries', 'Not Favorable'),
(50, 'Virgo', 'Leo', 'Favorable Match'),
(51, 'Virgo', 'Sagittarius', 'Not Favorable'),
(52, 'Virgo', 'Taurus', 'Great Match'),
(53, 'Virgo', 'Virgo', 'Great Match'),
(54, 'Virgo', 'Capricornus', 'Great Match'),
(55, 'Virgo', 'Gemini', 'Not Favorable'),
(56, 'Virgo', 'Libra', 'Not Favorable'),
(57, 'Virgo', 'Aquarius', 'Favorable Match'),
(58, 'Virgo', 'Cancer', 'Great Match'),
(59, 'Virgo', 'Scorpio', 'Great Match'),
(60, 'Virgo', 'Pisces', 'Favorable Match'),
(61, 'Capricornus', 'Aries', 'Not Favorable'),
(62, 'Capricornus', 'Leo', 'Favorable Match'),
(63, 'Capricornus', 'Sagittarius', 'Not Favorable'),
(64, 'Capricornus', 'Taurus', 'Great Match'),
(65, 'Capricornus', 'Virgo', 'Great Match'),
(66, 'Capricornus', 'Capricornus', 'Great Match'),
(67, 'Capricornus', 'Gemini', 'Not Favorable'),
(68, 'Capricornus', 'Libra', 'Favorable Match'),
(69, 'Capricornus', 'Aquarius', 'Not Favorable'),
(70, 'Capricornus', 'Cancer', 'Great Match'),
(71, 'Capricornus', 'Scorpio', 'Great Match'),
(72, 'Capricornus', 'Pisces', 'Great Match'),
(73, 'Gemini', 'Aries', 'Great Match'),
(74, 'Gemini', 'Leo', 'Great Match'),
(75, 'Gemini', 'Sagittarius', 'Favorable Match'),
(76, 'Gemini', 'Taurus', 'Not Favorable'),
(77, 'Gemini', 'Virgo', 'Favorable Match'),
(78, 'Gemini', 'Capricornus', 'Favorable Match'),
(79, 'Gemini', 'Gemini', 'Great Match'),
(80, 'Gemini', 'Libra', 'Great Match'),
(81, 'Gemini', 'Aquarius', 'Great Match'),
(82, 'Gemini', 'Cancer', 'Not Favorable'),
(83, 'Gemini', 'Scorpio', 'Not Favorable'),
(84, 'Gemini', 'Pisces', 'Not Favorable'),
(85, 'Libra', 'Aries', 'Favorable Match'),
(86, 'Libra', 'Leo', 'Great Match'),
(87, 'Libra', 'Sagittarius', 'Great Match'),
(88, 'Libra', 'Taurus', 'Favorable Match'),
(89, 'Libra', 'Virgo', 'Not Favorable'),
(90, 'Libra', 'Capricornus', 'Not Favorable'),
(91, 'Libra', 'Gemini', 'Great Match'),
(92, 'Libra', 'Libra', 'Great Match'),
(93, 'Libra', 'Aquarius', 'Great Match'),
(94, 'Libra', 'Cancer', 'Not Favorable'),
(95, 'Libra', 'Scorpio', 'Not Favorable'),
(96, 'Libra', 'Pisces', 'Favorable Match'),
(97, 'Aquarius', 'Aries', 'Great Match'),
(98, 'Aquarius', 'Leo', 'Great Match'),
(99, 'Aquarius', 'Sagittarius', 'Great Match'),
(100, 'Aquarius', 'Taurus', 'Not Favorable'),
(101, 'Aquarius', 'Virgo', 'Not Favorable'),
(102, 'Aquarius', 'Capricornus', 'Not Favorable'),
(103, 'Aquarius', 'Gemini', 'Great Match'),
(104, 'Aquarius', 'Libra', 'Great Match'),
(105, 'Aquarius', 'Aquarius', 'Great Match'),
(106, 'Aquarius', 'Cancer', 'Not Favorable'),
(107, 'Aquarius', 'Scorpio', 'Favorable Match'),
(108, 'Aquarius', 'Pisces', 'Favorable Match'),
(109, 'Cancer', 'Aries', 'Not Favorable'),
(110, 'Cancer', 'Leo', 'Favorable Match'),
(111, 'Cancer', 'Sagittarius', 'Favorable Match'),
(112, 'Cancer', 'Taurus', 'Great Match'),
(113, 'Cancer', 'Virgo', 'Great Match'),
(114, 'Cancer', 'Capricornus', 'Great Match'),
(115, 'Cancer', 'Gemini', 'Not Favorable'),
(116, 'Cancer', 'Libra', 'Not Favorable'),
(117, 'Cancer', 'Aquarius', 'Not Favorable'),
(118, 'Cancer', 'Cancer', 'Great Match'),
(119, 'Cancer', 'Scorpio', 'Great Match'),
(120, 'Cancer', 'Pisces', 'Great Match'),
(121, 'Scorpio', 'Aries', 'Favorable Match'),
(122, 'Scorpio', 'Leo', 'Favorable Match'),
(123, 'Scorpio', 'Sagittarius', 'Not Favorable'),
(124, 'Scorpio', 'Taurus', 'Great Match'),
(125, 'Scorpio', 'Virgo', 'Great Match'),
(126, 'Scorpio', 'Capricornus', 'Great Match'),
(127, 'Scorpio', 'Gemini', 'Not Favorable'),
(128, 'Scorpio', 'Libra', 'Not Favorable'),
(129, 'Scorpio', 'Aquarius', 'Not Favorable'),
(130, 'Scorpio', 'Cancer', 'Great Match'),
(131, 'Scorpio', 'Scorpio', 'Great Match'),
(132, 'Scorpio', 'Pisces', 'Great Match'),
(133, 'Pisces', 'Aries', 'Favorable Match'),
(134, 'Pisces', 'Leo', 'Favorable Match'),
(135, 'Pisces', 'Sagittarius', 'Favorable Match'),
(136, 'Pisces', 'Taurus', 'Great Match'),
(137, 'Pisces', 'Virgo', 'Favorable Match'),
(138, 'Pisces', 'Capricornus', 'Great Match'),
(139, 'Pisces', 'Gemini', 'Not Favorable'),
(140, 'Pisces', 'Libra', 'Not Favorable'),
(141, 'Pisces', 'Aquarius', 'Not Favorable'),
(142, 'Pisces', 'Cancer', 'Great Match'),
(143, 'Pisces', 'Scorpio', 'Great Match'),
(144, 'Pisces', 'Pisces', 'Great Match');

-- --------------------------------------------------------

--
-- Table structure for table `flames`
--

CREATE TABLE `flames` (
  `modulo` int(11) NOT NULL,
  `result` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flames`
--

INSERT INTO `flames` (`modulo`, `result`) VALUES
(0, 'Soulmates'),
(1, 'Friends'),
(2, 'Lovers'),
(3, 'Anger'),
(4, 'Married'),
(5, 'Engaged');

-- --------------------------------------------------------

--
-- Table structure for table `prospects`
--

CREATE TABLE `prospects` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `zodiac_sign` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prospects`
--

INSERT INTO `prospects` (`id`, `first_name`, `last_name`, `birthday`, `zodiac_sign`, `user_email`) VALUES
(1, 'Hans', 'Laguna', '2001-09-25', 'Libra', 'hans@outlook.ph'),
(2, 'Hanna', 'Medina', '2001-12-07', 'Sagittarius', 'hans@outlook.ph');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `address_line_1` varchar(50) NOT NULL,
  `address_line_2` varchar(50) DEFAULT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `address_line_1`, `address_line_2`, `city`, `state`, `email`, `password`) VALUES
(1, 'Hans', 'Laguna', '9 Buttercup St.', 'San Joaquin', 'Pasig', 'Metro Manila', 'hans@outlook.ph', '$2y$10$uOnPJvU4XZshiJtbGe14R.FoZGHYCtWgx/m5db6aOfwYBlby0WMc6');

-- --------------------------------------------------------

--
-- Table structure for table `zodiac`
--

CREATE TABLE `zodiac` (
  `id` int(11) NOT NULL,
  `zodiac_sign` varchar(50) NOT NULL,
  `zodiac_symbol` varchar(50) NOT NULL,
  `start_date` varchar(50) NOT NULL,
  `end_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zodiac`
--

INSERT INTO `zodiac` (`id`, `zodiac_sign`, `zodiac_symbol`, `start_date`, `end_date`) VALUES
(1, 'Aries', 'Ram', 'March 21', 'April 19'),
(2, 'Taurus', 'Bull', 'April 20', 'May 20'),
(3, 'Gemini', 'Twins', 'May 21', 'June 21'),
(4, 'Cancer', 'Crab', 'June 22', 'July 22'),
(5, 'Leo', 'Lion', 'July 23', 'August 22'),
(6, 'Virgo', 'Virgin', 'August 23', 'September 22'),
(7, 'Libra', 'Balance', 'September 23', 'October 23'),
(8, 'Scorpio', 'Scorpion', 'October 24', 'November 21'),
(9, 'Sagittarius', 'Archer', 'November 22', 'December 21'),
(10, 'Capricornus', 'Goat', 'December 22', 'January 19'),
(11, 'Aquarius', 'Water Bearer', 'January 20', 'February 18'),
(12, 'Pisces', 'Fish', 'February 19', 'March 20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `prospects`
--
ALTER TABLE `prospects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prospects_users` (`user_email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `prospects`
--
ALTER TABLE `prospects`
  ADD CONSTRAINT `fk_prospects_users` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
