-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2020 at 08:05 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comic`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `flaged` text NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` text NOT NULL,
  `flaged` varchar(3) NOT NULL,
  `deleted` text NOT NULL,
  `subject` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `flaged`, `deleted`, `subject`) VALUES
(1, 'test', 'BlueDefender', 'Welcome to the site! I how you enjoy it!', '2020-11-22 13:57:38', ',BlueDefender,', 'no', ',', 'Welcom to Kcomics! ');

-- --------------------------------------------------------

--
-- Table structure for table `message_replies`
--

CREATE TABLE `message_replies` (
  `id` int(11) NOT NULL,
  `messages_id` int(11) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` text NOT NULL,
  `flaged` varchar(3) NOT NULL,
  `deleted` text NOT NULL,
  `subject` text NOT NULL,
  `user_to` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `date` date NOT NULL,
  `likes` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `flags` int(11) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `flag` text NOT NULL,
  `views` int(11) NOT NULL,
  `sound` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `username`, `title`, `description`, `image`, `date`, `likes`, `comments`, `flags`, `deleted`, `flag`, `views`, `sound`) VALUES
(1, 'BooksBeat', 'Batman Covers', 'Just some covers of batman comics I liked.', 'assets/images/posts/5fbaaef5bbe4a5c4f2b9873c473.jpg,assets/images/posts/5fbaaef5bc4135c4f2b9873ffb4.jpg,assets/images/posts/5fbaaef5bc8a15c4f2b98738a22.jpg,assets/images/posts/5fbaaef5bcd4d5c4f2b98734801.jpeg,', '2020-11-22', 2, 0, 0, 'no', ',', 12, 'BKSBTBTMNKFRS'),
(2, 'BooksBeat', 'Live Pics', 'Some live and 3d pics.', 'assets/images/posts/5fbaaf697531f5c4f3b6f483f31.jpg,assets/images/posts/5fbaaf69758d55c4f3b6f4884a2.jpg,assets/images/posts/5fbaaf6975db05c4f3b6f4900e4.jpg,assets/images/posts/5fbaaf697621d5c4f3b6f498186.jpg,assets/images/posts/5fbaaf69766aa5c4f3b2620d422.jpg,assets/images/posts/5fbaaf6976baa5c4f3b5722f039.jpg,', '2020-11-22', 0, 0, 0, 'no', ',', 0, 'BKSBTLFPKS'),
(3, 'BooksBeat', 'Oldies', 'Some Older comics I liked.', 'assets/images/posts/5fbab012e0e8e5c4f2c63ca4302.jpg,assets/images/posts/5fbab012e13fc5c4f2df43e9224.jpg,assets/images/posts/5fbab012e18745c4f2e1cc98ba8.jpg,', '2020-11-22', 2, 0, 0, 'no', ',', 8, 'BKSBTOLTS'),
(4, 'BlueDefender', 'Covers', 'Some marvel covers', 'assets/images/posts/5fbab2c0d14165c4f2b9874ae07.jpg,assets/images/posts/5fbab2c0d199b5c4f2bfb45bbcAvengers 013-001.jpg,assets/images/posts/5fbab2c0d1e295c4f2bfb4575cAvengers 013-000.jpg,', '2020-11-22', 0, 0, 0, 'no', ',', 1, 'BLTFNTRKFRS'),
(5, 'BlueDefender', 'Older Comics', 'Some older comics I liked', 'assets/images/posts/5fbab2e045ae85c4f2e1cc94fb7.jpg,assets/images/posts/5fbab2e04621d5c4f2e1cc89284.jpg,assets/images/posts/5fbab2e0467055c4f2e1cc91316.jpg,', '2020-11-22', 0, 0, 0, 'no', ',', 0, 'BLTFNTROLTRKMKS'),
(6, 'BlueDefender', 'SPIDER Man!', 'Spider senses.', 'assets/images/posts/5fbab38fdacbd5c4f3b6f498186.jpg,', '2020-11-22', 0, 0, 0, 'no', ',', 1, 'BLTFNTRSPTRMN');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `birthdate` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `favorites` text NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `subscribers` text NOT NULL,
  `subscriptions` text NOT NULL,
  `active` char(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `birthdate`, `gender`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `favorites`, `num_likes`, `user_closed`, `subscribers`, `subscriptions`, `active`) VALUES
(2, '1974-03-03', '', 'test', 'Test@gmail.com', '5a105e8b9d40e1329780d62ea2265d8a', '2020-11-22', 'assets/images/profile_pics/defaults/head_deep_blue.png', ',3,1,', 0, 'no', ',', ',BlueDefender,BooksBeat,', NULL),
(4, '1987-11-11', 'Female', 'BooksBeat', 'Test3@gmail.com', '5a105e8b9d40e1329780d62ea2265d8a', '2020-11-22', 'assets/images/profile_pics/BooksBeat686556bb339a97256a66149731ec70ccn.jpeg', ',1,', 0, 'no', ',BlueDefender,test,', ',', NULL),
(10, '1975-03-04', 'Male', 'BlueDefender', 'Test1@gmail.com', '5a105e8b9d40e1329780d62ea2265d8a', '2020-11-22', 'assets/images/profile_pics/BlueDefender3677bbf4d9f0a98811ad449be201525cn.jpeg', ',3,', 0, 'no', ',test,', ',BooksBeat,', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_replies`
--
ALTER TABLE `message_replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message_replies`
--
ALTER TABLE `message_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
