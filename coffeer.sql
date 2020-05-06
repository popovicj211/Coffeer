-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2020 at 10:52 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeer`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `total` decimal(5,2) NOT NULL,
  `quantity` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `total`, `quantity`, `user_id`, `created`, `modified`) VALUES
(16, '306.00', 2, 1, '2020-02-20 20:06:23', '2020-02-29 00:09:38'),
(24, '576.00', 3, 1, '2020-02-20 20:16:40', '2020-02-29 00:09:38'),
(33, '396.00', 2, 1, '2020-02-29 00:02:07', '2020-02-29 00:09:38'),
(34, '640.00', 4, 1, '2020-03-01 00:06:28', '2020-03-01 00:06:28'),
(35, '600.00', 4, 1, '2020-03-01 00:13:29', '2020-03-01 00:13:29'),
(37, '300.00', 2, 1, '2020-03-01 00:20:05', '2020-03-01 00:20:05'),
(38, '765.00', 5, 8, '2020-03-02 23:36:52', '2020-03-02 23:36:52'),
(41, '306.00', 2, 30, '2020-03-16 18:23:12', '2020-03-16 18:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `cart_checkout`
--

CREATE TABLE `cart_checkout` (
  `cach_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `cho_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart_checkout`
--

INSERT INTO `cart_checkout` (`cach_id`, `cart_id`, `cho_id`) VALUES
(9, 33, NULL),
(10, 34, NULL),
(11, 35, NULL),
(13, 37, NULL),
(14, 38, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_drinkfood`
--

CREATE TABLE `cart_drinkfood` (
  `cadf_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `df_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart_drinkfood`
--

INSERT INTO `cart_drinkfood` (`cadf_id`, `cart_id`, `df_id`) VALUES
(22, 16, 7),
(30, 24, 5),
(39, 33, 2),
(40, 34, 3),
(41, 35, 4),
(43, 37, 4),
(44, 38, 7),
(46, 41, 7);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `name`) VALUES
(1, 'Coffee'),
(2, 'Main Dish'),
(3, 'Drinks'),
(4, 'Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `cho_id` int(11) NOT NULL,
  `street` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `plc_id` int(11) NOT NULL,
  `postcode` int(5) NOT NULL,
  `phone` int(15) NOT NULL,
  `cardnumber` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `pa_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `name`) VALUES
(1, 'Belgrade'),
(2, 'Novi Sad');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `cont_id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`cont_id`, `name`, `email`, `subject`, `message`, `created`, `modified`) VALUES
(1, 'Jovan Popovic', 'jovanpop2101@gmail.com', 'Kafa', 'Kafa vam je super!', '2020-03-16 22:38:35', '2020-03-16 22:39:03'),
(2, 'Mitar Mirić', 'mitar@gmail.com', 'Burgerrr', 'Burger je vrh.', '2020-03-16 22:38:35', '2020-03-16 22:39:03'),
(3, 'Pera Peric', 'pera@gmail.com', 'Milaaaoooo', 'Milaaaaaaaaaaaaaaaappp', '2020-03-17 01:04:25', '2020-03-17 01:04:25');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `dis_id` int(11) NOT NULL,
  `percent` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`dis_id`, `percent`) VALUES
(1, 10),
(2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `drinkfood`
--

CREATE TABLE `drinkfood` (
  `df_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `newprice` decimal(5,2) DEFAULT NULL,
  `dis_id` int(11) DEFAULT NULL,
  `cat_id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `drinkfood`
--

INSERT INTO `drinkfood` (`df_id`, `name`, `desc`, `price`, `newprice`, `dis_id`, `cat_id`, `img_id`, `created`, `modified`) VALUES
(1, 'Hamburger', 'Hamburger jeee superrrrrrr', '200.00', NULL, NULL, 2, 1, '2020-02-29 00:31:06', '2020-02-29 00:31:42'),
(2, 'Cheeseburger', 'Cheeseburger jeeeeeee vrh', '220.00', '198.00', 1, 2, 2, '2020-02-29 00:31:06', '2020-02-29 00:31:42'),
(3, 'Esspreso', 'Esspressooooo', '160.00', NULL, NULL, 1, 3, '2020-02-29 00:31:06', '2020-02-29 00:31:42'),
(4, 'Staropramen beer', 'Staroprameeeeeeen', '152.00', NULL, NULL, 3, 4, '2020-02-29 00:31:06', '2020-03-15 12:00:11'),
(5, 'Superburger', 'Supeeeeeeeer', '240.00', '192.00', 2, 2, 5, '2020-02-29 00:31:06', '2020-02-29 00:31:42'),
(6, 'Crepes', 'Vrepeeeeeees', '180.00', '162.00', 1, 4, 6, '2020-02-29 00:31:06', '2020-02-29 00:31:42'),
(7, 'Choco coffee', 'Chocoooo', '170.00', '153.00', 1, 1, 7, '2020-02-29 00:31:06', '2020-02-29 00:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `images2`
--

CREATE TABLE `images2` (
  `img_id` int(11) NOT NULL,
  `link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images2`
--

INSERT INTO `images2` (`img_id`, `link`, `alt`) VALUES
(1, 'hamburgerSingleCart.jpg', 'hamburgerSingleCart'),
(2, 'cheeseburgerSingleCart.jpg', 'cheeseburgerSingleCart'),
(3, 'esspresoSingleCart.jpg', 'esspresoSingleCart'),
(4, 'beerSingleCart.jpg', 'beerSingleCart'),
(5, 'superburgerSingleCart.jpg', 'superburgerSingleCart'),
(6, 'crepesSingleCart.jpg', 'crepesSingleCart'),
(7, 'chococaffeSingleCart.jpg', 'chococaffeSingleCart'),
(8, 'bg_1.jpg', 'Slide coffee'),
(9, 'bg_2.jpg', 'Slide esspreso'),
(10, 'bg_3.jpg', '	\r\nSlide bar');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `session` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `link`, `session`) VALUES
(1, 'HOME', '/home', 2),
(2, 'MENU', '/drinkfood', 2),
(4, 'ABOUT', '/about', 2),
(5, 'CONTACT', '/contact', 2),
(7, 'AUTHOR', '/author', 2),
(8, 'USERS', '/admin/users', 1),
(9, 'PRODUCTS', '/admin/products', 1),
(10, 'CART', '/admin/cart', 1),
(11, 'RESERVATION', '/admin/reservation', 1),
(12, 'CONTACT', '/admin/contact', 1),
(13, 'LOG', '/admin/log/1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meridiem`
--

CREATE TABLE `meridiem` (
  `mer_id` int(11) NOT NULL,
  `name` char(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meridiem`
--

INSERT INTO `meridiem` (`mer_id`, `name`) VALUES
(1, 'am'),
(2, 'pm');

-- --------------------------------------------------------

--
-- Table structure for table `paymentmetod`
--

CREATE TABLE `paymentmetod` (
  `pa_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `paymentmetod`
--

INSERT INTO `paymentmetod` (`pa_id`, `name`) VALUES
(1, 'Visa'),
(2, 'Master card');

-- --------------------------------------------------------

--
-- Table structure for table `place`
--

CREATE TABLE `place` (
  `plc_id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `place`
--

INSERT INTO `place` (`plc_id`, `name`) VALUES
(1, 'House'),
(2, 'Building');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `res_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `mobile` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`res_id`, `date`, `mobile`, `message`, `created`, `modified`, `user_id`) VALUES
(5, '2020-03-18 01:30:00', '+381 65 111 1111', 'Extra!', '2020-03-06 21:13:08', '2020-03-17 14:48:52', 30),
(12, '2020-03-20 02:30:00', '+381 65 111 1122', 'Eeeeeeeeeeee', '2020-03-17 15:05:09', '2020-03-17 15:05:09', 8),
(13, '2020-03-21 22:22:00', '+381 65 123 4567', 'Addddddddddddddddddddddd', '2020-03-17 22:37:36', '2020-03-17 22:37:36', 19),
(14, '2020-03-22 22:05:00', '+381 69 222 3333', 'Rezervacijaaa', '2020-03-18 00:36:41', '2020-03-18 00:36:41', 8);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slide_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `img_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slide_id`, `name`, `text`, `img_id`) VALUES
(1, 'The Best Coffee Testing Experience', 'A small river named Duden flows by their place and supplies it with the necessary regelialia.', 8),
(2, 'Amazing Taste Beautiful Place', 'A small river named Duden flows by their place and supplies it with the necessary regelialia.', 9),
(3, 'Creamy Hot and Ready to Serve', 'A small river named Duden flows by their place and supplies it with the necessary regelialia.', 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `username`, `email`, `password`, `created`, `modified`, `token`, `active`, `role_id`) VALUES
(1, 'Jovan Popovic', '@jovan97', 'moralnapobeda71@gmail.com', 'c2d9684a4165bd2a8784a1942062b4c8', '2020-01-29 22:27:41', '2020-03-03 14:56:32', '061fe6efb5a4b8d47793466aacccb3dc', 1, 1),
(8, 'Luka Lukic', '@lukaaa', 'luka@gmail.com', '41cd8012060774402caef35e261bc90c', '2020-02-15 20:09:47', '2020-03-03 14:56:32', 'c5b5fb7379ae94f560c5133bb56992fc', 1, 2),
(9, 'Danijela Nikitin', 'dacaaa', 'daca@gmail.com', '96048268c0b8de2bd3f3201d443782fe', '2020-02-15 21:39:21', '2020-03-03 14:56:32', 'a60a319b3af85dd8186b9d1ee9700afb', 1, 2),
(10, 'Milena Vesic', '@milenaa', 'milena@gmail.com', '0dbf3e8d771b15f6ec26c0a0ad05d6d1', '2020-02-15 21:44:17', '2020-03-03 14:56:32', '9000666503c2ed983c49c3e517c46351', 1, 2),
(11, 'Stefan Bogdanovic', '@panter', 'fmp@gmail.com', '0687a4b8802b1da7bfadcc14d70b572b', '2020-02-15 21:51:00', '2020-03-03 14:56:32', '63fd2417fd41151a0e026b483075216e', 1, 2),
(12, 'Pera Peric', 'peraa', 'pera@gmail.com', '1d777f5bcc64dbb777b4818cffbad000', '2020-02-15 22:46:57', '2020-03-03 14:56:32', 'c06bf6c3f9c4da5bc471cc1bb81f2d02', 1, 2),
(14, 'Moralna Pobeda', '@moralnaa', 'jovanpopovicwd@gmail.com', '64f375842a21ad70a79f5f0ec108c6e0', '2020-02-15 23:39:37', '2020-03-03 14:56:32', '14e21d6c8b28c774362418315a37b22f', 1, 2),
(16, 'Nemanja Ranisavljevic', '@necaa', 'neca@gmail.com', '8703000860e27257c0a1711e042a1592', '2020-02-16 13:58:03', '2020-03-03 14:56:32', '821a8973f42ec9527e2a2d4f66e3568d', 1, 2),
(17, 'Vladimir Petrovic', '@pizon', 'pizon@gmail.com', 'd4bf8c518745d6ee2ef715f2a64374f8', '2020-02-16 14:03:52', '2020-03-03 14:56:32', '54cc032ba7f85053fa2baeb14de8c5e5', 1, 2),
(19, 'Andjela Perlas', '@perla', 'perla@gmail.com', 'fd8fb15f4ee79030204063219c711dbd', '2020-02-16 16:00:31', '2020-03-03 14:56:32', '91f5b9fe134b3b16a29e79b7ead40706', 1, 2),
(20, 'Nikos Nikić', '@nikos2', 'nikos@gmail.com', '60df17546acbce1b34a7d9ef74522df0', '2020-03-04 01:45:53', '2020-03-09 00:50:46', 'f25a992426042017ec60857dc03368fe', 2, 1),
(27, 'Ivan Obradović', '@iloo', 'ilo@gmail.com', '556fb07a2fd5d1657e48cb62468ae553', '2020-03-04 21:06:53', '2020-03-04 21:06:53', 'd06a4671e47d2e22f429583b4b5c8482', 1, 2),
(30, 'Stefan Perović', '@peroviccc', 'perovic@gmail.com', '7da816581a2c54d43939e79e34899083', '2020-03-05 20:10:50', '2020-03-08 23:10:02', 'fb71f496d64aa839e641d9474c30755f', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_checkout`
--
ALTER TABLE `cart_checkout`
  ADD PRIMARY KEY (`cach_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `cho_id` (`cho_id`);

--
-- Indexes for table `cart_drinkfood`
--
ALTER TABLE `cart_drinkfood`
  ADD PRIMARY KEY (`cadf_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `df_id` (`df_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`cho_id`),
  ADD UNIQUE KEY `cardnumber` (`cardnumber`),
  ADD KEY `pa_id` (`pa_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `plc_id` (`plc_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`cont_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`dis_id`);

--
-- Indexes for table `drinkfood`
--
ALTER TABLE `drinkfood`
  ADD PRIMARY KEY (`df_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `dis_id` (`dis_id`),
  ADD KEY `img_id` (`img_id`);

--
-- Indexes for table `images2`
--
ALTER TABLE `images2`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `meridiem`
--
ALTER TABLE `meridiem`
  ADD PRIMARY KEY (`mer_id`);

--
-- Indexes for table `paymentmetod`
--
ALTER TABLE `paymentmetod`
  ADD PRIMARY KEY (`pa_id`);

--
-- Indexes for table `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`plc_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`res_id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slide_id`),
  ADD KEY `img_id` (`img_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `cart_checkout`
--
ALTER TABLE `cart_checkout`
  MODIFY `cach_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart_drinkfood`
--
ALTER TABLE `cart_drinkfood`
  MODIFY `cadf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `cho_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `cont_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `dis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drinkfood`
--
ALTER TABLE `drinkfood`
  MODIFY `df_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `images2`
--
ALTER TABLE `images2`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `meridiem`
--
ALTER TABLE `meridiem`
  MODIFY `mer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `paymentmetod`
--
ALTER TABLE `paymentmetod`
  MODIFY `pa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `place`
--
ALTER TABLE `place`
  MODIFY `plc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slide_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_checkout`
--
ALTER TABLE `cart_checkout`
  ADD CONSTRAINT `cart_checkout_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_checkout_ibfk_2` FOREIGN KEY (`cho_id`) REFERENCES `checkout` (`cho_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_drinkfood`
--
ALTER TABLE `cart_drinkfood`
  ADD CONSTRAINT `cart_drinkfood_ibfk_1` FOREIGN KEY (`df_id`) REFERENCES `drinkfood` (`df_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_drinkfood_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`pa_id`) REFERENCES `paymentmetod` (`pa_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `city` (`city_id`),
  ADD CONSTRAINT `checkout_ibfk_3` FOREIGN KEY (`plc_id`) REFERENCES `place` (`plc_id`);

--
-- Constraints for table `drinkfood`
--
ALTER TABLE `drinkfood`
  ADD CONSTRAINT `drinkfood_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`cat_id`),
  ADD CONSTRAINT `drinkfood_ibfk_3` FOREIGN KEY (`dis_id`) REFERENCES `discount` (`dis_id`),
  ADD CONSTRAINT `drinkfood_ibfk_4` FOREIGN KEY (`img_id`) REFERENCES `images2` (`img_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `slider`
--
ALTER TABLE `slider`
  ADD CONSTRAINT `slider_ibfk_1` FOREIGN KEY (`img_id`) REFERENCES `images2` (`img_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
