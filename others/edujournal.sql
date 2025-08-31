-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 31, 2025 at 01:47 PM
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
(45, 45, 39, '2025-08-31 21:42:41');

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
(72, 35, 'testing 2', 'fsadf asdfsafasdf', 14, 'draft', '2025-08-31 21:17:09', '2025-08-31 21:17:09'),
(77, 36, 'A Student’s Journey in Taking on a Project', 'Taking on a project as a student feels like stepping into both an exciting and challenging adventure. At first, there’s the thrill of coming up with ideas—sometimes you don’t even know where to start, but the curiosity and eagerness to try something new make it worth it. There’s a mix of nerves and excitement, especially when you realize that the project is your chance to show not just what you’ve learned in class, but also your creativity and determination.\r\n\r\nAlong the way, the journey isn’t always smooth. There are times when things don’t go as planned—like running into problems with research, facing deadlines, or dealing with group misunderstandings. These struggles can feel overwhelming, but they also teach resilience and patience. Little by little, you start learning how to adapt, find solutions, and manage your time better. It’s in those moments that you begin to understand the real value of the project.\r\n\r\nBy the time the project is completed, the sense of fulfillment is unmatched. Looking back at all the effort, late nights, and brainstorming sessions, you realize how much you’ve grown not only academically but also personally. It’s more than just grades—it’s about proving to yourself that you’re capable of overcoming challenges and turning your ideas into something real. That journey, with all its ups and downs, becomes an experience you’ll always carry as a student.', 1, 'approved', '2025-08-31 21:39:03', '2025-08-31 21:39:03'),
(78, 36, 'Research as a Creative Process', 'Research isn’t just about gathering facts—it’s about curiosity and imagination. It often begins with a simple question, something that sparks interest or challenges the way things are usually understood. Like sketching the first line of a drawing, that question slowly shapes into an idea that sets the direction of the study.\r\n\r\nAs the process continues, creativity shows up in unexpected ways. Finding connections between different sources, rethinking old ideas, and even designing experiments require a kind of problem-solving that feels a lot like creating art. It’s not just following steps—it’s inventing new ways to approach problems and seeing possibilities where others might not.\r\n\r\nWhat makes research exciting is that it combines discipline with creativity. The structure of gathering data and analyzing results is there, but within that framework, there’s room to explore, experiment, and even fail before finding the right path. In the end, research becomes more than a requirement—it’s a way of turning curiosity into something meaningful and original.', 2, 'approved', '2025-08-31 21:40:03', '2025-08-31 21:40:03'),
(79, 35, 'Art as Expression', 'Art is more than colors on a canvas or lines on paper—it’s a language of its own. Every drawing, design, or piece of work carries a story, a mood, or even just a moment of inspiration. It allows us to express what words sometimes can’t, whether it’s joy, struggle, or the simple beauty of everyday life.\r\n\r\nFor students, art often becomes a safe space to explore imagination. It’s where ideas flow without strict rules, where mistakes can turn into something beautiful, and where creativity feels limitless. Even the smallest doodle in a notebook can spark bigger ideas and reveal something about the way we see the world.\r\n\r\nWhat makes art special is its ability to connect with others. A single painting or design can be understood in so many ways, depending on who’s looking at it. That’s the power of art—it’s personal, yet universal, and it shows that creativity is something we all share.', 3, 'approved', '2025-08-31 21:41:02', '2025-08-31 21:41:02'),
(80, 35, 'olunteering and Giving Back', 'Volunteering is more than just offering time—it’s about sharing kindness and creating an impact, no matter how small it may seem. Whether it’s helping in a community event, assisting a classmate, or joining an outreach program, each act of service brings people closer together and makes a difference.\r\n\r\nIt’s also a way to grow as a person. Through volunteering, we learn to understand different perspectives, practice empathy, and discover the value of teamwork. It shows us that real fulfillment doesn’t always come from receiving, but from giving and being part of something meaningful.\r\n\r\nWhat makes volunteering powerful is that it creates a chain reaction. A single gesture of help inspires others to do the same, and together, these small actions can build stronger, more compassionate communities.', 7, 'approved', '2025-08-31 21:41:25', '2025-08-31 21:41:25'),
(81, 39, 'Reflections and Growth', 'Taking time to reflect allows us to pause and look back on what we’ve done, what we’ve learned, and how we’ve changed. It’s in these quiet moments of thought that we recognize both our progress and the areas where we still want to improve.\r\n\r\nReflections help us see meaning in our experiences. A simple challenge faced in school, a project completed, or even a mistake made can teach lessons that go beyond the classroom. By looking back, we gain clarity and prepare ourselves better for what comes next.\r\n\r\nMost importantly, reflections remind us that growth is a continuous process. Each step, whether big or small, adds to the person we are becoming. By embracing both achievements and setbacks, we learn to move forward with more wisdom and purpose.', 9, 'approved', '2025-08-31 21:42:38', '2025-08-31 21:42:38'),
(82, 39, 'Learning Through Internship', 'Internships provide a valuable opportunity to apply what we’ve learned in real situations. They give us the chance to experience how things work outside the classroom and allow us to connect theory with practice. It’s a space where knowledge turns into action.\r\n\r\nDuring an internship, we also discover new skills and sharpen the ones we already have. Tasks may seem challenging at first, but each one helps build confidence and teaches lessons that can’t always be found in books. Working alongside professionals also offers insights that shape our perspective about future careers.\r\n\r\nMost of all, internships open doors. They show us possibilities, help us build connections, and give us a clearer vision of the path we want to take. Beyond gaining experience, internships prepare us for the responsibilities and opportunities ahead.', 6, 'approved', '2025-08-31 21:43:05', '2025-08-31 21:43:09');

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
(77, 1),
(78, 2),
(79, 3),
(45, 4),
(82, 6),
(80, 7),
(81, 9);

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
(36, 'Eunice Jayce', 'eunicejayce@gmail.com', '$2y$10$VuH..YxgCIq6N3R.zeCB1Ol5kld0E4ZCgqnbF5dbGT1a/UuOSzt9O', 'student', '2025-08-28 20:19:59'),
(38, 'dummy123', 'dummy@gmail.com', '$2y$10$irPQPIObfy2PsUfb8k6BYO0y6CBazbDDGfPma0SUC894O83NWupyC', 'student', '2025-08-29 16:44:39'),
(39, 'Christel Jheane', 'cj@gmail.com', '$2y$10$wI3/SgYvkWnnpWFggntKHuXRMXo7kybQeNHrbou5fdcwwohaXfFsG', 'student', '2025-08-31 21:42:03');

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
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
