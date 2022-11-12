-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20221014.c92621d023
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2022 at 04:49 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web2_tpe`
--
CREATE DATABASE IF NOT EXISTS `web2_tpe` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web2_tpe`;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

DROP TABLE IF EXISTS `authors`;
CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `last_name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `authors`:
--

--
-- Truncate table before insert `authors`
--

TRUNCATE TABLE `authors`;
--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `last_name`) VALUES
(1, 'Martin', 'Cappi'),
(2, 'Coco', 'Michi'),
(3, 'JRR', 'Tolkien');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(240) NOT NULL,
  `genre` varchar(120) DEFAULT NULL,
  `FK_author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `books`:
--   `FK_author_id`
--       `authors` -> `id`
--

--
-- Truncate table before insert `books`
--

TRUNCATE TABLE `books`;
--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `genre`, `FK_author_id`) VALUES
(1, 'Como dormir la siesta', 'Life-hacks', 2),
(2, 'Codeando a ultimo momento', 'Procrastination', 1),
(3, 'Odio a los perros', 'Autobio', 2),
(6, 'el señor de los anillos', 'historico', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(120) NOT NULL,
  `alias` varchar(80) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- RELATIONSHIPS FOR TABLE `users`:
--

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `alias`, `is_admin`) VALUES
(3, 'mail@mail.com', '$2y$10$LApuRcCMnCjFDc3teyHOueIEYrJ6CK111fBMj.CvD5DcXTbLi29a2', 'Martin', 0),
(5, 'mail2@mail.com', '$2y$10$VZZjriG1KEroetDn0TRC4.fEr0CcPF4ttjfClSUWZolCWIjqE6XDG', 'Ricardo', 0),
(6, 'mail3@mail.com', '$2y$10$osEyNHbnXwVxRWOmkP9okOPBhIydNeoe9RGjhHcE1UuAJNiofrar2', 'Coco', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_author_id` (`FK_author_id`);

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
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`FK_author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
