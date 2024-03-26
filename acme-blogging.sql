-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2024 at 03:19 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `acme-blogging`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogpost`
--

CREATE TABLE `blogpost` (
  `post_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `post_type` text NOT NULL,
  `content` text NOT NULL,
  `creation_date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `update_date` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogpost`
--

INSERT INTO `blogpost` (`post_id`, `user_id`, `title`, `description`, `post_type`, `content`, `creation_date`, `update_date`) VALUES
(5, 1, 'test', 'test', 'text', 'test', '2024-03-26 13:11:01.669400', '2024-03-26 00:00:00.000000'),
(6, 1, 'another', 'test', 'text', 'TEST', '2024-03-26 13:10:02.103321', '2024-03-26 00:00:00.000000'),
(12, 1, 'test', 'tes', 'image', 'image_6602c649592a5.jpg', '2024-03-26 13:09:58.401466', '2024-03-26 00:00:00.000000'),
(13, 1, 'I frame sample', 'Youtube Video Sample', 'iframe', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/DJi_KeZLL_g?si=cwqsSfbbJ7WAmGYK\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2024-03-26 13:12:27.288595', '2024-03-26 00:00:00.000000'),
(14, 1, 'Test Iframe', 'test', 'iframe', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/DJi_KeZLL_g?si=cwqsSfbbJ7WAmGYK\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>', '2024-03-26 13:12:30.375035', '2024-03-26 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `comment_text`, `created_at`) VALUES
(1, 5, 1, 'Test', '2024-03-26 14:03:19'),
(2, 5, 1, 'Test', '2024-03-26 14:03:33'),
(3, 5, 1, 'Test', '2024-03-26 14:04:36'),
(4, 5, 1, 'another comment', '2024-03-26 14:04:49'),
(5, 13, 1, 'Wow amazing!', '2024-03-26 14:07:52'),
(6, 6, 1, 'New Comment', '2024-03-26 14:08:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `employee_id` int(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `date_of_registration` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `date_of_record_update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `email`, `password`, `employee_id`, `date_of_birth`, `date_of_registration`, `date_of_record_update`) VALUES
(1, 'tester', 'rodel@test.com', '$2y$10$szstEOc2r2y97O.gMPW3dutX7lbvtiKDKwfFquPVPJvMLAH0AEcwy', 0, '0000-00-00', '2024-03-26 11:09:33.058458', '0000-00-00'),
(2, 'Rodelio Domingo', 'test@tester.com', '$2y$10$JQ7C6dTvTd0QAhnmNSzzBeC9ueILe7siQaC27dzvS5Fcz8ta5kBui', 1, '1997-12-30', '2024-03-26 11:10:36.804538', '2024-03-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blogpost`
--
ALTER TABLE `blogpost`
  MODIFY `post_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blogpost` (`post_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
