-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 10, 2025 at 09:42 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amour_roses`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `cate_id` int NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(120) NOT NULL,
  `cate_description` text NOT NULL,
  `cate_image` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cate_id`, `cate_name`, `cate_description`, `cate_image`, `datetime`) VALUES
(7, 'Best Seller', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'best_seller.png', '2024-12-21 13:46:15'),
(12, 'New Arrival', 'Hello New Arrival', 'new-arrival.jpg', '2024-12-25 01:34:02'),
(13, 'Bouquets', 'Amour Roses: Stunning Handcrafted Bouquets Designed to Express Love, Elegance, and Timeless Beauty.', '1745790557_bouquets.jpg', '2024-12-25 12:14:54'),
(14, 'Boxes', 'Amour Roses: Elegant Flower Boxes Crafted to Deliver Luxury and Lasting Impressions.', '1745790742_boxes.jpg', '2024-12-25 12:19:00'),
(15, 'Occasions', 'Amour Roses: Perfect Floral Arrangements for Every Special Occasion and Celebration.', '1745790511_occassions.jpg', '2024-12-25 12:21:01');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(200) NOT NULL,
  `product` varchar(250) NOT NULL,
  `amount` int NOT NULL,
  `address` text NOT NULL,
  `city` varchar(200) NOT NULL,
  `country` varchar(20) NOT NULL,
  `contact` bigint NOT NULL,
  `email` varchar(250) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `full_name`, `product`, `amount`, `address`, `city`, `country`, `contact`, `email`, `datetime`) VALUES
(2, 'Aliyan Amir', 'Berry Bliss', 3999, 'saddar, karachi', 'karachi', 'Pakistan', 3082788266, 'aliyan@gmail.com', '2025-04-29 04:07:05'),
(3, 'Hammad', 'White Wonders', 3599, 'Malir', 'karachi', 'Pakistan', 398738299, 'hammad@gmail.com', '2025-04-29 04:08:22');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `product_price` int NOT NULL,
  `product_category_id` int NOT NULL,
  `promotion_category_id` int NOT NULL,
  `product_image_1` varchar(255) NOT NULL,
  `product_image_2` varchar(255) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`),
  KEY `product_category` (`product_category_id`),
  KEY `promotion_category` (`promotion_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_sku`, `product_description`, `product_price`, `product_category_id`, `promotion_category_id`, `product_image_1`, `product_image_2`, `datetime`) VALUES
(14, 'Berry Bliss', 'berrybliss2832', '1 chrys, 2 rose, 1 spray rose, 1 gypso.', 3999, 13, 7, 'berry_bliss_1.webp', 'berry_bliss_2.webp', '2025-04-27 22:24:53'),
(15, 'Sweet Pink Symphony', 'pinksymphony2372', '3 Rose, 5 Spray Rose, 2 Chrysanthemums, 2 Gypso.', 2999, 15, 7, 'Pink_Symphony_1.webp', 'Pink_Symphony_2.webp', '2025-04-27 22:28:09'),
(16, 'Golden Glow', 'goldenglow29324', 'Rose (3), Spray Rose (2), Chrysanthemum (2), Gypso, Card.', 3999, 13, 7, 'golden_glow_1.webp', 'golden_glow_2.webp', '2025-04-27 22:31:15'),
(18, 'White Wonders', 'whitewonders439234', '7 Chrysanthemum, 1 Baby Breath. ', 3599, 13, 7, 'White_Wonders_1.webp', 'White_Wonders_2.webp', '2025-04-27 22:45:17'),
(19, 'Candy Clouds', 'candyclouds4839', '7 Rose, 8 Spray Rose. ', 2999, 15, 7, 'candy_cloud_1.webp', 'candy_cloud_2.webp', '2025-04-27 23:04:06'),
(20, 'Best Mom Ever', 'bestmom37329', '3 Rose, 3 Chrysanthemums, ', 3499, 15, 7, 'best_mom_1.webp', 'best_mom_2.webp', '2025-04-27 23:10:41'),
(21, 'Majestic Medley', 'majesticmedley43340', '7 imported spray rose, 1 gypso.', 3999, 13, 12, 'majesticmedley_1.webp', 'majesticmedley_2.webp', '2025-04-27 23:14:54'),
(22, 'Noir Mystique', 'noirmystique4328834', '6 Chrysanthemums, 6 Spray Rose.', 2999, 15, 12, 'noir_mystique_1.webp', 'noir_mystique_2.webp', '2025-04-27 23:20:54'),
(23, 'Super Dad', 'superdad3283', 'Sunflower (6), Gypso (1), Card.', 2999, 15, 12, 'superdad_1.webp', 'superdad_2.webp', '2025-04-27 23:23:53'),
(24, 'Eid Opulence', 'eid0pulence433423', '1 Danisa 90g, 1 Card, 2 Spray Rose, 3 Gerbera, 1 Kitkat 2F, 1 Hersheys Bar, 1 Snickers.', 3999, 14, 12, 'Eid_Opulence_1.webp', 'Eid_Opulence_2.webp', '2025-04-28 22:22:51'),
(25, 'Crescent Bliss', 'crescentbliss23834', '1 Danisa 90g, 1  Farmfield Biscuits, 1 White Castle Wafer Rolls 100g, 1 Lals Bar, 1 Galaxy. ', 3799, 14, 7, 'Crescent_Bliss_1.webp', 'Crescent_Bliss_2.webp', '2025-04-28 22:36:50'),
(26, 'Love Loot', 'LoveLoot4389', '1 Cadbury Dairy Milk Pouch 160g, 1 Danisa Cookies (S), 1 Lindt Excellence, 2 Kitkat (4F), 2 Rose.', 3999, 14, 7, 'Love_Loot_1.webp', 'Love_Loot_2.webp', '2025-04-28 22:43:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `datetime`) VALUES
(21, 'aliyan@gmail.com', 'aliyan', '2024-12-20 14:52:54');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_category` FOREIGN KEY (`product_category_id`) REFERENCES `category` (`cate_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `promotion_category` FOREIGN KEY (`promotion_category_id`) REFERENCES `category` (`cate_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
