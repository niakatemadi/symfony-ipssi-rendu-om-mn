-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 04, 2022 at 09:52 PM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsymfony-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_23A0E66F675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `author_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'new ipsum', 'orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2022-12-02 13:36:14', '2022-12-02 14:36:53'),
(2, 5, 'Lorem ', 'orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2022-12-02 14:36:00', '2022-12-02 15:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `card_product`
--

DROP TABLE IF EXISTS `card_product`;
CREATE TABLE IF NOT EXISTS `card_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_84508EDB1AD5CDBF` (`cart_id`),
  KEY `IDX_84508EDB4584665A` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'telephone'),
(2, 'ordinateur');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `quantity` int(11) DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  KEY `IDX_D34A04AD8DE820D9` (`seller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `seller_id`, `title`, `description`, `price`, `image`, `created_at`, `updated_at`, `quantity`, `color`) VALUES
(1, 1, 1, 'Iphone edition 1', 'tres puisssant telephone americain', '800', 'iphone image', '2022-12-03 08:37:53', '2022-12-03 08:37:53', 0, 'gris'),
(2, 2, 1, 'samsung', 'telephone ergonomique', '200', 'android picture', '2022-12-03 08:37:53', '2022-12-03 08:37:53', 25, 'blue'),
(4, 1, 1, 'android X', 'pas cher et puissant', '100', 'no image', '2022-12-03 10:15:09', '2022-12-03 10:15:09', NULL, 'purple'),
(5, 1, 8, 'samsung X11', 'Model unique de chez samsung', '999', 'no image', '2022-12-03 16:12:45', '2022-12-03 16:12:45', 5, 'black'),
(6, 1, 1, 'Iphone XV', 'new generation power 8', '1555', 'no image', NULL, NULL, 78, 'white'),
(7, 1, 1, 'Samsung XV', 'unique model of the world', '1444', 'no images', '2022-12-03 18:53:53', NULL, 20, 'red'),
(16, 1, 3, 'androidium', 'metal argenté', '212', 'no image', '2022-12-04 09:04:02', NULL, 214, 'bluegrey'),
(18, 1, 3, 'orange', 'eveedv', '356', 'lkl', '2022-12-04 18:32:31', NULL, 545, '54');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D6491AD5CDBF` (`cart_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `cart_id`, `name`, `firstname`, `statut`) VALUES
(1, 'caramel@test.com', '[]', '$2y$13$lTDJWlWA9BmdLNi0W0Orh.giCTXgSgslP5Oc204/rulWIvnt65O6S', NULL, 'caramel', 'cara', 'client'),
(2, 'fraise@test.com', '[]', '$2y$13$zbyogenbNd2AuNNJEWMVG.NslqG.RP4WEO/lTxooGIgCMUlJ7HY9y', NULL, 'fraise', 'Fraisier', 'client'),
(3, 'testing@test.com', '[\"ROLE_ADMIN\"]', '$2y$13$2dPWeUQvADYCGSsiFkxQ1.e5ouajCGB6///xm5rxXNTp.faC47zfe', NULL, 'testing', 'dimso', 'client'),
(4, 'bobo@test.com', '[]', '$2y$13$ssrWbipr1nSrVsEj8V2J.O6eWzopMehpjdjJdzpfD/E.6UDwsOKjy', NULL, 'bobo', 'bubu', 'client'),
(5, 'coucou@test.com', '[]', '$2y$13$hCmEuYzVKJ9dA2IgpJLbS.u55lbot2uIiUYE1vvWcbR3B28mv8TNK', NULL, 'coucou', 'coco', 'client'),
(6, 'prune@test.com', '[]', '$2y$13$yo5lrHo9mVku1Kp9ZkHJkOOMZDQq5dKgJANgIIRQ4qpz1WgDR68Eq', NULL, 'prune', 'pruneau', 'vendeur'),
(7, 'pomme@test.com', '[]', '$2y$13$ljFv/UVDa91Prqz/iNKu0u1AVhcGyQQZNmxRdgmKhP1M48Sux/5.2', NULL, 'cerdrik', 'julien', 'vendeur'),
(8, 'cerise@test.com', '[]', '$2y$13$Ktih77BNWIr.qjMAsvytZOKL/SDn5bHFRBbBQamSIzGj76gF7MFFO', NULL, 'cerise', 'risette', 'client'),
(9, 'madrid@test.com', '[]', '$2y$13$Xe0NqL/KGLvH0KR5Fy4CyunMkSKycHOae0wHlGXluvmB2ue8.jb0q', NULL, 'real', 'madrid', 'vendeur');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `card_product`
--
ALTER TABLE `card_product`
  ADD CONSTRAINT `FK_84508EDB1AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_84508EDB4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D34A04AD8DE820D9` FOREIGN KEY (`seller_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6491AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
