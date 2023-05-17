-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 17, 2023 at 07:22 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aeon-backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_value` varchar(255) NOT NULL,
  `token_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token_value`, `token_user`) VALUES
('27c303531d71e342506482e8599baabe', 5),
('a83b154d10de299aba54d25a81c83a8d', 5),
('bf723aac22f690df476b9678555c95e4', 5),
('cb8a37e1d2ccfbe00f2b01dbb65d67c3', 5),
('5c91f572249af7e37ff0235fb94c63c2', 9),
('5c3801f28db5ff981e317cf5ab08769c', 5),
('605ff8f0a2bc9c924fdb06aa5e2bca7b', 5),
('c39086c595257f7cf1eff82d2ca61a02', 5),
('e8905600c975c89a2c8f6e9aab29f207', 5),
('dba44882fed7d8beb166e52403e8a417', 5),
('0c167f571124a1aae42a30b398e9f2ec', 5),
('14ad46a7c7c4683935a1c18a72db182e', 5),
('2929d617c7c1f1b49765a2f2c82813c6', 5),
('cdb85c8ca0a3f7fa7f74165cff5e355a', 5),
('9e33bb31fe860a8d5207d4e782766928', 10),
('3a2ba390dccda9af9fd20736809f120a', 10),
('e7108002023589e99eb5b53df8682cc4', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `user_login`, `user_password`) VALUES
(5, 'user1', '$2y$10$bpks/0QhhFzqhAAUXhPJM.wKotXe4TLODdG1.WMSQlKHvhO4MNLrC'),
(9, 'mrreads', '$2y$10$MBg4AUZSaaKpOoA1Nm9bXewnr8gFvKPseoMRp/YSunyv1Y2wxK.S.'),
(10, '123', '$2y$10$WfgmeOCd7pExpiRBTHfIKuSItY91egjm.hRMWIm9Yp8/CF9MVWFVi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD KEY `token-user` (`token_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `token-user` FOREIGN KEY (`token_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
