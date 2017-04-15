-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2017 at 10:19 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `upload_img`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `uid` int(11) NOT NULL DEFAULT '1',
  `keywords` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `title`, `url`, `uid`, `keywords`, `date_created`) VALUES
(61, 'tải xuống tét 12356', 'uploads/89c292c35c73eaeb73bf5c74d66bb07e.png', 1, '33', '2017-04-14 10:15:37'),
(62, 'user_default', 'uploads/5fa0c84a54d3b8529d3261b7a2563c74.png', 1, '33', '2017-04-14 10:15:37'),
(65, 'diploma 45678', 'uploads/ade2a84a943565351b4e45ab46469dba.png', 1, '34,35', '2017-04-14 10:16:37'),
(66, 'diploma 1', 'uploads/e6acf86e5b300b49cd6dbc28d79d6a01.png', 1, '34', '2017-04-14 10:16:37'),
(67, 'user', 'uploads/05f7b16f8a11320e6d1c79d30beddd33.gif', 1, '36', '2017-04-14 10:20:54'),
(68, 'user2', 'uploads/655afc829e556e504e98ffbc3d8e1895.png', 1, '36', '2017-04-14 10:20:54'),
(69, '3', 'uploads/98c4b13d39c406e4a21c8a823846f473.jpg', 1, '37,38,39', '2017-04-14 10:21:59'),
(70, '4', 'uploads/1d86f00a70b8f530cc4ec2064f4662f7.jpg', 1, '37,38,39', '2017-04-14 10:21:59'),
(71, '2', 'uploads/ee0aaae22b5fe149e879edf23d084dde.jpg', 1, '37,39', '2017-04-14 10:21:59'),
(72, '12', 'uploads/a646be640d4c13c6cbe0d9800206cc6c.jpg', 1, '39,40', '2017-04-14 10:22:30'),
(74, '9', 'uploads/745e101f25787789ab8c71c0c836da46.jpg', 1, '39,40', '2017-04-14 10:22:30'),
(75, 'imgr5', 'uploads/2002c6b35d8714f8378bc50cc680ca30.gif', 1, '33,41,66', '2017-04-14 10:23:11'),
(76, 'imgl847', 'uploads/bfd62782aa670eeb38e84a82a3ca64cf.gif', 1, '41', '2017-04-14 10:23:11'),
(77, '03', 'uploads/aa7c134a11640b9527db37c987cbb918.jpg', 1, '39', '2017-04-14 10:23:24'),
(79, 'blog-single', 'uploads/3034b439f94165f965614fc2a0555117.jpg', 1, '42,44', '2017-04-14 10:24:13'),
(80, '15', 'uploads/edb177523c8efc84aff6188adfca99ac.jpg', 1, '33,39', '2017-04-14 14:30:05'),
(81, '2', 'uploads/559169e61cef515f31ba5d70cd379fa2.jpg', 1, '39,40', '2017-04-14 14:30:05'),
(82, 'imgblog', 'uploads/1ac844c7955dad8f8aa2891eec4bee74.jpg', 1, '65', '2017-04-15 02:15:11'),
(83, 'index2-head', 'uploads/f5b0cc8ce8c7aed195e7ae571d140968.jpg', 1, '65', '2017-04-15 02:15:11'),
(84, 'middle-text ', 'uploads/3d7e40f8f51ebfc6a6b7a43675e38fa5.jpg', 1, '44,65,43', '2017-04-15 02:15:12'),
(87, 'image-3[1]', 'uploads/6e78d32200358253d6fedaaf1ce0f86b.jpg', 1, '69', '2017-04-15 04:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `keywords`
--

CREATE TABLE `keywords` (
  `key_id` int(11) NOT NULL,
  `keyword` varchar(250) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keywords`
--

INSERT INTO `keywords` (`key_id`, `keyword`, `date_created`) VALUES
(33, 'default', '2017-04-14 10:15:36'),
(34, 'diploma', '2017-04-14 10:16:36'),
(35, 'degree', '2017-04-14 10:16:37'),
(36, 'user', '2017-04-14 10:20:53'),
(37, 'porfolio', '2017-04-14 10:21:59'),
(38, 'nature', '2017-04-14 10:21:59'),
(39, 'background', '2017-04-14 10:21:59'),
(40, 'person', '2017-04-14 10:22:30'),
(41, 'floating', '2017-04-14 10:23:11'),
(42, 'blog', '2017-04-14 10:24:12'),
(43, 'time', '2017-04-14 10:24:12'),
(44, 'computer', '2017-04-14 10:24:13'),
(45, 'newke', '2017-04-14 14:43:08'),
(46, 'a1 a2', '2017-04-14 14:45:39'),
(47, 'h3', '2017-04-14 14:45:51'),
(48, 'kh', '2017-04-14 14:46:31'),
(49, 'a1', '2017-04-14 14:46:31'),
(50, '12', '2017-04-14 14:46:32'),
(51, 'a3', '2017-04-14 14:46:32'),
(52, 'a5', '2017-04-14 14:46:32'),
(53, 'a6', '2017-04-14 14:46:32'),
(54, 'a7', '2017-04-14 14:46:32'),
(55, 'a8', '2017-04-14 14:46:32'),
(56, 'a9', '2017-04-14 14:46:32'),
(57, 'a10', '2017-04-14 14:46:32'),
(58, 'a11', '2017-04-14 14:46:32'),
(59, 'a12', '2017-04-14 14:46:32'),
(60, 'a13', '2017-04-14 14:46:32'),
(61, 'a14', '2017-04-14 14:46:32'),
(62, 'a15', '2017-04-14 14:46:32'),
(63, 'a16', '2017-04-14 14:46:32'),
(64, 'a17', '2017-04-14 14:46:32'),
(65, 'image', '2017-04-15 02:15:11'),
(66, 'ko', '2017-04-15 03:56:27'),
(67, 'cu', '2017-04-15 03:57:34'),
(68, 'shark', '2017-04-15 03:58:30'),
(69, 'eyes', '2017-04-15 04:03:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `keywords`
--
ALTER TABLE `keywords`
  ADD PRIMARY KEY (`key_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `keywords`
--
ALTER TABLE `keywords`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
