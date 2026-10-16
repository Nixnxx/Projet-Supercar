-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql-nix.alwaysdata.net
-- Generation Time: Oct 16, 2026 at 12:29 PM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 8.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nix_supercar`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `niveau` varchar(50) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `tentatives_echouees` int(11) NOT NULL DEFAULT 0,
  `derniere_tentative` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id_login`, `login`, `mot_de_passe`, `niveau`, `id_client`, `tentatives_echouees`, `derniere_tentative`) VALUES
(3, 'admin@gmail.com', '$2y$10$qB5MPJhAk8qgq8aJFqPHhOlTcuEzbbxhpEecpZxd.NZAkm1hWOs.u', 'admin', NULL, 0, '2026-09-10 11:11:11'),
(7, 'naxrakoto@gmail.com', '$2y$10$78ZNUNH/hJsrWUoWrpc4K.jG0pjxQ77U9oNoVGug97K9MEKN4Ffn.', 'client', 8, 0, NULL),
(29, 'nix@gmail.com', '$2y$10$QPKLpqg0twDPF.cdsiR.A.FQiqCegShOQsfGEFeLjiJrvZ1ryYFkC', 'admin', NULL, 0, NULL),
(38, 'jess@gmail.com', '$2y$12$AMlpAagYVEuFKhtkyPGtmePRllX0I0pYv5xkTd26unn2X23IrybXG', 'client', 33, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD KEY `id_client` (`id_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
