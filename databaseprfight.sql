-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 26, 2017 at 02:36 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `databaseprfight`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_alt` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `recoveries`
--

CREATE TABLE `recoveries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `idroles` int(11) NOT NULL,
  `role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`idroles`, `role`) VALUES
(1, 'user'),
(2, 'administrator');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `cpf` int(11) NOT NULL,
  `faixa` varchar(45) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(100) NOT NULL,
  `salt` varchar(256) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `descricao` varchar(500) DEFAULT NULL,
  `roles_id` int(11) DEFAULT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `cpf`, `faixa`, `username`, `password`, `email`, `salt`, `status`, `descricao`, `roles_id`, `image`) VALUES
(1, 'ewertton', 0, 'Branca 7 Kyu', 'ewertton', '0672a1289b2a882c2bc979ab02ca5aa2d147894842cb79710c931d91db2c6dfbb272823bc932129132c3ac75c9b2ad8b8c486254adbef0fb875acbc70712e62b', 'ewertton.klaytton@hotmail.com', '375ccbc1ee974652d0c9bab58da763197430a9d3422d825acf6b8f06fbf9f34a01dcf0785aa30b4a4afcf71b5b06cf15911b04300ac385eae5889049c0a40c22', 1, '                              ', 2, 'ca0f652b9d620aab9b1792cbcf75f860.png'),
(2, 'klaytton', 0, 'Branca 7 Kyu', 'klaytton', '1a5451673e4484f79ca56712bbc5ac06c3fbbad060caf7da4f27f9fdd1a4902b8862f86e84949ee722fc4a7f238ab8c31cf911d2f8ae37eb8d063c3862df85f2', 'ewertton02@gmail.com', '5ea91936a70d8e5bbffc21fa36744b320170372584edd881b564f3d8b98ba3431ba89c50f23165a30411c23507454486c8715af881512b4afc3163edfed17ada', 1, '                              ', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_login_attempts_id_user_idx` (`user_id`);

--
-- Indexes for table `recoveries`
--
ALTER TABLE `recoveries`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `passwords_id_user_idx` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idroles`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alunos_role_id_idx` (`roles_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `recoveries`
--
ALTER TABLE `recoveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `idroles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `fk_login_attempts_id_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `recoveries`
--
ALTER TABLE `recoveries`
  ADD CONSTRAINT `recoveries_id_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_roles_id` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`idroles`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
