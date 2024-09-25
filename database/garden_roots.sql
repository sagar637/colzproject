-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2023 at 06:50 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `garden_roots`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`) VALUES
(1, 'rushilprasad', 'password', 'rushil321@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `blog_title` varchar(30) NOT NULL,
  `blog_data` varchar(200) NOT NULL,
  `blog_image` varchar(30) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `admin_id`, `blog_title`, `blog_data`, `blog_image`, `date`) VALUES
(1, 1, 'Fresh Journey', 'Ever wondered how fresh produce reaches your local grocery store shelves? Explore the fascinating process...', 'blog1.jpg', '2023-08-15'),
(2, 1, 'Online Convenien', 'Experience the ease and convenience of online grocery shopping today. Shop smart and save time...', 'blog2.jpg', '2023-08-15'),
(3, 1, 'Kitchen Essentials', 'Upgrade your cooking game with these essential kitchen gadgets for better meals and happier cooking...', 'blog3.jpg', '2023-08-15'),
(4, 1, 'Sustainable Choices', 'Make eco-friendly choices and reduce your environmental impact with sustainable shopping habits...', 'blog4.jpg', '2023-08-15'),
(5, 1, 'Quick Dinners', 'Discover easy and nutritious weeknight dinner ideas using pantry staples. Dinner solved deliciously...', 'blog5.jpg', '2023-08-15');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `user_id`, `quantity`) VALUES
(254, 10, 10, 1),
(255, 9, 10, 1),
(257, 5, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `gallery_image` varchar(30) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gallery_id`, `admin_id`, `gallery_image`, `date`) VALUES
(1, 1, 'gallery1.jpg', '2023-08-15'),
(2, 1, 'gallery2.jpg', '2023-08-15'),
(3, 1, 'gallery3.jpg', '2023-08-15'),
(4, 1, 'gallery4.jpg', '2023-08-15'),
(5, 1, 'gallery1.jpg', '2023-08-15'),
(6, 1, 'gallery2.jpg', '2023-08-15');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `order_set` varchar(10) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(20) NOT NULL,
  `address` varchar(300) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`order_id`, `order_set`, `product_id`, `user_id`, `quantity`, `total`, `date`, `status`, `payment_method`, `address`, `time`) VALUES
(118, 'YQN', 6, 1, 3, 598, '2023-07-12', 'delivered', 'credit card', '156, Sayda Marg, Narayan Street, Opp Ramesh park, Manjalpur -390012', '2023-09-12 09:23:34'),
(119, 'YQN', 9, 1, 5, 598, '2023-07-12', 'delivered', 'credit card', '156, Sayda Marg, Narayan Street, Opp Ramesh park, Manjalpur -390012', '2023-09-12 09:23:34'),
(120, 'YQN', 10, 1, 2, 598, '2023-07-12', 'delivered', 'credit card', '156, Sayda Marg, Narayan Street, Opp Ramesh park, Manjalpur -390012', '2023-09-12 09:23:34'),
(121, 'YQN', 14, 1, 2, 598, '2023-07-12', 'delivered', 'credit card', '156, Sayda Marg, Narayan Street, Opp Ramesh park, Manjalpur -390012', '2023-09-12 09:23:34'),
(122, 'YQN', 12, 1, 4, 598, '2023-07-12', 'delivered', 'credit card', '156, Sayda Marg, Narayan Street, Opp Ramesh park, Manjalpur -390012', '2023-09-12 09:23:34'),
(123, 'YQN', 19, 1, 2, 598, '2023-07-12', 'delivered', 'credit card', '156, Sayda Marg, Narayan Street, Opp Ramesh park, Manjalpur -390012', '2023-09-12 09:23:34'),
(125, 'AK0', 5, 2, 2, 593, '2023-07-22', 'delivered', 'pay balance', '502, Nirma Residence, Near Basant Road, Karelibaugh -390015', '2023-09-12 09:24:41'),
(126, 'AK0', 7, 2, 3, 593, '2023-07-22', 'delivered', 'pay balance', '502, Nirma Residence, Near Basant Road, Karelibaugh -390015', '2023-09-12 09:24:41'),
(127, 'AK0', 8, 2, 3, 593, '2023-07-22', 'delivered', 'pay balance', '502, Nirma Residence, Near Basant Road, Karelibaugh -390015', '2023-09-12 09:24:41'),
(128, 'AK0', 11, 2, 5, 593, '2023-07-22', 'delivered', 'pay balance', '502, Nirma Residence, Near Basant Road, Karelibaugh -390015', '2023-09-12 09:24:41'),
(129, 'AK0', 18, 2, 2, 593, '2023-07-22', 'delivered', 'pay balance', '502, Nirma Residence, Near Basant Road, Karelibaugh -390015', '2023-09-12 09:24:41'),
(130, 'AK0', 13, 2, 1, 593, '2023-07-22', 'delivered', 'pay balance', '502, Nirma Residence, Near Basant Road, Karelibaugh -390015', '2023-09-12 09:24:41'),
(132, 'ZF1', 1, 5, 3, 608, '2023-07-30', 'delivered', 'credit card', '22-B, Mahesh Gandhi Duplex,opp Janata Garage, Maneja -380011 ', '2023-09-12 09:25:52'),
(133, 'ZF1', 15, 5, 2, 608, '2023-07-30', 'delivered', 'credit card', '22-B, Mahesh Gandhi Duplex,opp Janata Garage, Maneja -380011 ', '2023-09-12 09:25:52'),
(134, 'ZF1', 21, 5, 2, 608, '2023-07-30', 'delivered', 'credit card', '22-B, Mahesh Gandhi Duplex,opp Janata Garage, Maneja -380011 ', '2023-09-12 09:25:52'),
(135, 'ZF1', 2, 5, 2, 608, '2023-07-30', 'delivered', 'credit card', '22-B, Mahesh Gandhi Duplex,opp Janata Garage, Maneja -380011 ', '2023-09-12 09:25:52'),
(136, 'ZF1', 3, 5, 2, 608, '2023-07-30', 'delivered', 'credit card', '22-B, Mahesh Gandhi Duplex,opp Janata Garage, Maneja -380011 ', '2023-09-12 09:25:52'),
(137, 'ZF1', 4, 5, 4, 608, '2023-07-30', 'delivered', 'credit card', '22-B, Mahesh Gandhi Duplex,opp Janata Garage, Maneja -380011 ', '2023-09-12 09:25:52'),
(139, '8BI', 13, 6, 1, 443, '2023-08-10', 'on delivery', 'pay balance', '5-B, Rajesh Duplex, Near Sangham Char Rasta, Harni - 390211', '2023-09-12 09:27:39'),
(140, '8BI', 14, 6, 2, 443, '2023-08-10', 'on delivery', 'pay balance', '5-B, Rajesh Duplex, Near Sangham Char Rasta, Harni - 390211', '2023-09-12 09:27:39'),
(141, '8BI', 12, 6, 2, 443, '2023-08-10', 'on delivery', 'pay balance', '5-B, Rajesh Duplex, Near Sangham Char Rasta, Harni - 390211', '2023-09-12 09:27:39'),
(142, '8BI', 20, 6, 4, 443, '2023-08-10', 'on delivery', 'pay balance', '5-B, Rajesh Duplex, Near Sangham Char Rasta, Harni - 390211', '2023-09-12 09:27:39'),
(143, '8BI', 19, 6, 2, 443, '2023-08-10', 'on delivery', 'pay balance', '5-B, Rajesh Duplex, Near Sangham Char Rasta, Harni - 390211', '2023-09-12 09:27:39'),
(144, '8BI', 18, 6, 2, 443, '2023-08-10', 'on delivery', 'pay balance', '5-B, Rajesh Duplex, Near Sangham Char Rasta, Harni - 390211', '2023-09-12 09:27:39'),
(150, 'DON', 14, 10, 1, 51, '2023-09-18', 'pending', 'cash on delivery', '21 Shivam Park Society, near NEO summer school, Tarsali, Vadodara - 392100 ', '2023-09-18 16:07:33'),
(151, 'DON', 12, 10, 1, 51, '2023-09-18', 'pending', 'cash on delivery', '21 Shivam Park Society, near NEO summer school, Tarsali, Vadodara - 392100 ', '2023-09-18 16:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product` varchar(20) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `product_image` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `category` varchar(20) NOT NULL,
  `sales` bigint(20) NOT NULL DEFAULT 0,
  `ordered` bigint(20) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product`, `price`, `discount`, `product_image`, `description`, `category`, `sales`, `ordered`, `featured`) VALUES
(1, 'apple -4pc', 69, 52, 'apple.png', '0', 'fruits', 3, 1, 1),
(2, 'avocado -4pc', 59, 49, 'avocado.png', '0', 'fruits', 2, 1, 0),
(3, 'banana -4pc', 24, 19, 'banana.png', '0', 'fruits', 2, 1, 0),
(4, 'blueberry -200g', 39, 24, 'blueberry.png', '0', 'fruits', 4, 1, 0),
(5, 'bread -100g', 24, 19, 'bread.png', '0', 'bakery', 2, 1, 1),
(6, 'broccoli -200g', 49, 36, 'broccoli.png', '0', 'vegetables', 3, 1, 0),
(7, 'buns -100g', 29, 24, 'buns.png', '0', 'bakery', 3, 1, 0),
(8, 'butter -100g', 59, 44, 'butter.png', '0', 'dairy', 3, 1, 1),
(9, 'carrot -200g', 36, 24, 'carrot.png', '0', 'vegetables', 5, 1, 1),
(10, 'cauliflower -200g', 54, 36, 'cauliflower.png', '0', 'vegetables', 2, 1, 1),
(11, 'cheese -100g', 59, 34, 'cheese.png', '0', 'dairy', 5, 1, 1),
(12, 'cucumber -5pc', 29, 24, 'cucumber.png', '0', 'vegetables', 7, 3, 1),
(13, 'eggs -12pc', 79, 69, 'eggs.png', '0', 'dairy', 2, 2, 0),
(14, 'garlic -100g', 24, 19, 'garlic.png', '0', 'vegetables', 5, 3, 1),
(15, 'grape -200g', 49, 36, 'grape.png', '0', 'fruits', 2, 1, 0),
(16, 'guava -4pc', 49, 36, 'guava.png', '0', 'fruits', 0, 0, 0),
(17, 'kiwi -4pc', 54, 42, 'kiwi.png', '0', 'fruits', 0, 0, 0),
(18, 'milk -1l', 35, 24, 'milk.png', '0', 'dairy', 4, 2, 1),
(19, 'olive -200g', 54, 46, 'olive.png', '0', 'fruits', 4, 2, 0),
(20, 'onion -200g', 35, 24, 'onion.png', '0', 'vegetables', 4, 1, 1),
(21, 'orange -4pc', 49, 44, 'orange.png', '0', 'fruits', 2, 1, 0),
(22, 'paneer -100g', 44, 34, 'paneer.png', '0', 'dairy', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `review` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `rating`, `review`) VALUES
(1, 1, 4, 'A fantastic online grocery shopping experience! The website\'s layout is intuitive, making it a breeze to find everything I need. The prices are competitive, and the timely delivery is a big plus. Highly recommended!'),
(2, 2, 5, 'Absolutely love this grocery website! It\'s incredibly convenient and user-friendly. The wide selection of fresh produce and pantry staples keeps me coming back for more. Fast delivery and excellent customer service too!'),
(3, 3, 4, 'This grocery website has revolutionized my shopping routine. With its seamless navigation and diverse product range, I can easily stock up on essentials. The responsive customer support team adds an extra layer of trust!'),
(4, 4, 5, 'Impressive variety and quality on this grocery website. From organic goodies to international delights, they\'ve got it all. Ordering is effortless, and their on-time delivery never disappoints. Top-notch service!'),
(5, 5, 5, 'I can\'t stop praising this grocery website! The search feature is efficient, allowing me to quickly locate my favorite items. The packaging is sturdy, ensuring my groceries arrive in perfect condition. A must-try for all shop'),
(6, 6, 3, 'Kudos to this grocery website for making my life easier! With their vast assortment of specialty items, I can explore new flavors. The smooth checkout process and reliable delivery make shopping delightful. 5-star experience!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `profile_pic` varchar(30) NOT NULL DEFAULT 'default.png',
  `add1` varchar(100) DEFAULT NULL,
  `add2` varchar(100) DEFAULT NULL,
  `add3` varchar(100) DEFAULT NULL,
  `credits` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `phone`, `profile_pic`, `add1`, `add2`, `add3`, `credits`) VALUES
(1, 'EmmaJohnson', 'password', 'emmajohnson@gmail.com', '9821456472', 'user1.jpeg', '156, Sayda Marg, Narayan Street, Opp Ramesh park, Manjalpur -390012', NULL, NULL, 0),
(2, 'LiamAnderson', 'password', 'liamanderson@gmail.com', '9853157562', 'user2.jpeg', '502, Nirma Residence, Near Basant Road, Karelibaugh -390015', NULL, NULL, 0),
(3, 'NoahSmith', 'password', 'noahsmith@gmail.com', '9124812756', 'user3.jpeg', NULL, NULL, NULL, 0),
(4, 'SophiaWilliams', 'password', 'sophiawilliams@gmail.com', '9124578432', 'user4.jpg', NULL, NULL, NULL, 0),
(5, 'EthanMartinez', 'password', 'ethanmartinez@gmail.com', '9454879452', 'user5.jpeg', '22-B, Mahesh Gandhi Duplex,opp Janata Garage, Maneja -380011 ', NULL, NULL, 0),
(6, 'BenjaminTaylor', 'password', 'benjamintaylor@gmail.com', '9245784510', 'user6.jpg', '5-B, Rajesh Duplex, Near Sangham Char Rasta, Harni - 390211', NULL, NULL, 0),
(10, 'rushilprasad', 'password', 'default@gmail.com', '8153656410', 'user6.jpg', '21 Shivam Park Society, near NEO summer school, Tarsali, Vadodara - 392100 ', '43-B Swayam Residence Opp Vishnu Park, Maneja, Vadodara - 390011', NULL, 200);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD UNIQUE KEY `admin_id` (`admin_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD UNIQUE KEY `blog_id` (`blog_id`),
  ADD UNIQUE KEY `blog_title` (`blog_title`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD UNIQUE KEY `cart_id` (`cart_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD UNIQUE KEY `gallery_id` (`gallery_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD UNIQUE KEY `product` (`product`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD UNIQUE KEY `review_id` (`review_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
