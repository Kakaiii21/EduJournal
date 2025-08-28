-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 28, 2025 at 01:50 PM
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

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `post_id`, `user_id`, `created_at`) VALUES
(29, 45, 36, '2025-08-28 20:21:48'),
(30, 50, 36, '2025-08-28 20:21:50'),
(34, 50, 35, '2025-08-28 21:26:14'),
(35, 58, 35, '2025-08-28 21:27:52'),
(36, 58, 36, '2025-08-28 21:27:59');

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
  `is_featured` enum('pending','approved','draft','denied') NOT NULL DEFAULT 'draft',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `content`, `category_id`, `is_featured`, `created_at`, `updated_at`) VALUES
(45, 35, 'Capturing Moments Through the Lens', 'Photography is more than just pressing a button—it is an art of preserving emotions, stories, and fleeting moments that words often fail to describe. Each click of the shutter freezes a unique perspective, whether it’s the warmth of a smile, the beauty of nature, or the vibrance of everyday life. A single photograph has the power to transport us back to a time and place, allowing us to relive the emotions that were once present.\r\n\r\nBeyond its artistic value, photography also serves as a universal language that connects people across cultures. Images can convey feelings and ideas without the need for translation, making them a powerful medium of expression. Whether you are a professional photographer with advanced equipment or someone who simply enjoys capturing memories with a phone, the essence of photography lies in telling a story that resonates with others.', 4, 'approved', '2025-08-28 19:42:40', '2025-08-28 19:42:45'),
(50, 36, 'The Role of Research in a Student’s Journey', 'Research plays a vital role in the academic journey of every student. It is not only a requirement for school projects and theses but also a valuable tool for expanding one’s understanding of the world. Through research, students learn how to gather reliable information, analyze data critically, and form well-founded conclusions. This process teaches discipline and develops essential skills such as problem-solving, time management, and communication.\r\n\r\nFrom a student’s perspective, research can feel overwhelming at first, especially when dealing with large volumes of information and complex topics. However, with practice and guidance, it becomes a rewarding experience that sharpens both intellectual and practical skills. It encourages curiosity, allows students to ask meaningful questions, and provides a platform to express their ideas with evidence. Ultimately, research bridges classroom learning with real-world applications.\r\n\r\nMoreover, research empowers students to contribute to their communities. By studying issues that matter—such as education, environment, or technology—students can propose solutions that address real problems. This sense of contribution gives purpose to their studies and motivates them to strive for excellence. In the long run, engaging in research not only enhances academic growth but also prepares students to be innovators and critical thinkers in their future careers.', 2, 'approved', '2025-08-28 20:20:56', '2025-08-28 20:21:20'),
(58, 35, 'The Art and Power of Writing', 'Writing is one of the most powerful forms of human expression. Through words, we can communicate ideas, emotions, and experiences that transcend time and space. Whether it’s crafting a novel, composing a poem, or writing a simple journal entry, writing allows us to reflect, imagine, and connect with others on a deeper level. It transforms thoughts into tangible forms that can inspire, educate, and entertain.\r\n\r\nMoreover, writing is a skill that develops critical thinking and creativity. When we write, we organize our thoughts, structure arguments, and explore new perspectives. It challenges us to articulate complex ideas clearly and encourages introspection. For students, professionals, and creatives alike, honing writing skills can open doors to new opportunities, deepen understanding, and foster personal growth. Writing is not merely a task; it is a lifelong journey of expression, discovery, and connection.\r\n\r\nBeyond self-expression, writing plays a critical role in preserving knowledge and culture. Throughout history, civilizations have documented their stories, discoveries, and traditions through written records. Writing not only captures the essence of human experience but also enables the transfer of knowledge from one generation to the next. It gives permanence to ideas that might otherwise fade and allows future readers to learn from the past.', 5, 'approved', '2025-08-28 21:27:07', '2025-08-28 21:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `post_categories`
--

CREATE TABLE `post_categories` (
  `post_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `post_categories`
--

INSERT INTO `post_categories` (`post_id`, `category_id`) VALUES
(45, 4);

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
(35, 'Casey Dellamas', 'dellamascasey@gmail.com', '$2y$10$KyhCGc4KVcGcJtaQDgzqG.f3QoU23WDNdIv9NJGHrsetl.d2Z/wSu', 'student', '2025-08-27 15:14:10'),
(36, 'Eunice Jayce', 'eunicejayce@gmail.com', '$2y$10$oceAMKnz6xr1nYBpJmTRoe96UWyhi2aF7G2TFMX8LhaZ5p8LCgbOu', 'student', '2025-08-28 20:19:59');

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
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
