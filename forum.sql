-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 18, 2019 at 02:34 AM
-- Server version: 5.6.38
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `comment_created_by` int(11) NOT NULL,
  `comment_belongs_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_text`, `comment_created_by`, `comment_belongs_to`) VALUES
(59, 'Hello!', 10, 66),
(60, 'I like your post!', 11, 66),
(61, 'Welcome!', 11, 67),
(62, '2 posts in a row!', 11, 68),
(63, 'Me too !', 12, 69),
(64, 'Hi!', 12, 67),
(65, 'Nice!', 12, 66),
(66, 'Good luck! I have an 8 hour shift on Monday and Wednesday.', 9, 70),
(67, 'Woohoo!', 9, 67),
(70, 'Yay for 3 posts!', 13, 74),
(71, 'Yay!', 13, 73),
(72, 'Yes! You can delete any post you submit from your dashboard!', 10, 75),
(73, 'You can also delete your own posts directly from the home page :)', 12, 75);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `body`, `created_at`, `created_by`) VALUES
(66, 'Post 1', 'This is my very first post.', '2019-05-17 23:26:44', 9),
(67, 'Hello', 'I have just joined this forum!', '2019-05-17 23:30:15', 10),
(68, 'Post 2', 'This is my second post.', '2019-05-17 23:31:13', 10),
(69, 'Forum Feedback', 'I love this forum!', '2019-05-17 23:34:36', 11),
(70, 'Work Schedule', 'I will be working everyday this week. Anyone else?', '2019-05-17 23:42:05', 12),
(73, 'Post Two', 'This is my second post.', '2019-05-17 23:50:41', 9),
(74, 'Post 3', 'This is my third post!', '2019-05-17 23:50:55', 9),
(75, 'Delete a Post', 'Is it possible to delete a post?', '2019-05-17 23:54:43', 13);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `post_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`post_id`, `comment_id`) VALUES
(66, 59),
(66, 60),
(67, 61),
(68, 62),
(69, 63),
(67, 64),
(66, 65),
(70, 66),
(67, 67),
(74, 70),
(73, 71),
(75, 72),
(75, 73);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstName` varchar(256) NOT NULL,
  `lastName` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `userName` varchar(256) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstName`, `lastName`, `email`, `userName`, `password`) VALUES
(9, 'Liana', 'Saryan', 'liana.saryan.214@my.csun.edu', 'Liana_s', '9e1360cf6796393906ca44440fc519b2'),
(10, 'John ', 'Doe', 'jdoe@gmail.com', 'John_Doe', '527bd5b5d689e2c32ae974c6229ff785'),
(11, 'Amanda', 'Page', 'amandapage@yahoo.com', 'P_amanda', '608f0b988db4a96066af7dd8870de96c'),
(12, 'Cherry', 'Blossom', 'cherryB@yahoo.com', 'CherryBlossom', '4781ac9273d3335229ca90e8e00a1c71'),
(13, 'Stacy', 'Reynolds', 'stacyReynolds@att.net', 'Stacy_Reynolds', 'ecd3d37ea8bdbab7bc3e5b20665a68f1');

-- --------------------------------------------------------

--
-- Table structure for table `user_comments`
--

CREATE TABLE `user_comments` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_comments`
--

INSERT INTO `user_comments` (`user_id`, `comment_id`) VALUES
(10, 59),
(11, 60),
(11, 61),
(11, 62),
(12, 63),
(12, 64),
(12, 65),
(9, 66),
(9, 67),
(13, 70),
(13, 71),
(10, 72),
(12, 73);

-- --------------------------------------------------------

--
-- Table structure for table `user_posts`
--

CREATE TABLE `user_posts` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `post_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_posts`
--

INSERT INTO `user_posts` (`user_id`, `post_id`) VALUES
(9, 66),
(10, 67),
(10, 68),
(11, 69),
(12, 70),
(9, 73),
(9, 74),
(13, 75);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_created_by` (`comment_created_by`),
  ADD KEY `comment_belongs_to` (`comment_belongs_to`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`comment_belongs_to`) REFERENCES `posts` (`post_id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
