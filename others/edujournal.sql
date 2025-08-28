-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 27, 2025 at 01:48 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edujournal`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`, `created_at`) VALUES
(1, 'Projects', 'School and personal projects', '2025-08-22 02:33:13'),
(2, 'Research', 'Research papers and findings', '2025-08-22 02:33:13'),
(3, 'Art', 'Drawings, designs, and creative art', '2025-08-22 02:33:13'),
(4, 'Photography', 'Photos and visual works', '2025-08-22 02:33:13'),
(5, 'Writing', 'Poems, stories, essays', '2025-08-22 02:33:13'),
(6, 'Internship', 'Internship experiences', '2025-08-22 02:33:13'),
(7, 'Volunteering', 'Community service activities', '2025-08-22 02:33:13'),
(8, 'Competitions', 'Academic or skill-based competitions', '2025-08-22 02:33:13'),
(9, 'Reflections', 'Personal reflections and learnings', '2025-08-22 02:33:13');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `category_id` int NOT NULL,
  `is_featured` enum('pending','approved','draft') NOT NULL DEFAULT 'draft',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `content`, `category_id`, `is_featured`, `created_at`, `updated_at`) VALUES
(22, 30, 'dsafsa drafting', 'dsafsdfas', 4, 'draft', '2025-08-27 09:18:46', '2025-08-27 09:18:46'),
(24, 30, 'pendingg test', 'dsafe4wadfsafds ', 2, 'approved', '2025-08-27 09:25:38', '2025-08-27 09:25:38'),
(25, 10, 'Pending test 2 for the categorues', 'categories in approved', 8, 'approved', '2025-08-27 09:36:20', '2025-08-27 09:36:20'),
(26, 10, 'category test', 'dafsdsafas', 4, 'pending', '2025-08-27 09:46:44', '2025-08-27 09:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `post_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') DEFAULT 'student',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(10, 'Casey', 'adminkai@school.com', '$2y$10$/J3UvVFpPcBpIw1Kxw/6peOr0e.l2cIFtTFfCWkF.gJj1LO0sm8TS', 'admin', '2025-08-22 11:06:23'),
(25, 'kai', 'kai@gmail.com', '$2y$10$TCt4YI/g87oeY71m6865yuQs8lp5pX/4omrxrEwLU8jOHxhmft3Dm', 'student', '2025-08-24 09:26:36'),
(26, 'admin site 2', 'admineun@school.com', '$2y$10$wN7HLUh4SYeOAivmpvZCs.ZmA4JmP1BYDvJbVJOMP5lo1AODWIIfK', 'admin', '2025-08-24 09:47:23'),
(28, 'casey21', 'casey@gmail.com', '$2y$10$2.e9MFe/Xba0yF.5BcKKWuHsdB2l7kRITXB3JHMgwIbfWsK0w/4pK', 'student', '2025-08-24 19:15:05'),
(30, 'eun', 'eun@gmail.com', '$2y$10$CmtpX2VdP/U9qzSNb1MSi.v1jkmknT/tLR1GnMGpU9CkuIbFoAYtC', 'student', '2025-08-24 21:16:04'),
(31, 'jayce', 'jayce@gmail.com', '$2y$10$8EvdBrDP.UHU4LfkZr7HbOHU/lVJIgpZFU60nWiwRom..3YjeQFfi', 'student', '2025-08-25 12:00:53'),
(34, 'kakai', 'kakai@gmail.com', '$2y$10$Jsx.qt5oDHjqe/dDQR69buCtvPJj3QusYsLSe7ulz2Rm8tKfdD4X2', 'student', '2025-08-25 22:21:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `post_id_fk_likes` (`post_id`),
  ADD KEY `user_id_fk_likes` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `users_id_fk` (`user_id`);

--
-- Indexes for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `post_categories`
--
ALTER TABLE `post_categories`
  ADD CONSTRAINT `post_categories_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_categories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
