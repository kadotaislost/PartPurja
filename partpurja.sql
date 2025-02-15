-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2025 at 12:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `partpurja`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(9, 'Audio Equipment'),
(5, 'Cameras & Photography'),
(8, 'Computer Peripherals'),
(4, 'Gaming Accessories'),
(1, 'Laptop Components'),
(2, 'Mobile Parts'),
(6, 'Networking Devices'),
(12, 'Office Equipment'),
(10, 'Smart Home Devices'),
(7, 'Storage Devices'),
(3, 'Vehicle Electronics'),
(11, 'Wearable Tech');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `product_condition` enum('new','used') NOT NULL,
  `contact_phone` varchar(15) DEFAULT NULL,
  `product_status` enum('available','sold','removed') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `title`, `description`, `category_id`, `price`, `product_condition`, `contact_phone`, `product_status`, `created_at`) VALUES
(1, 1, 'HP Laptop Battery', 'Original HP 6-cell battery, compatible with Pavilion series. Original HP 6-cell battery, compatible with Pavilion series. Original HP 6-cell battery, compatible with Pavilion series. Original HP 6-cell battery, compatible with Pavilion series.', 1, 45.00, 'new', '9800000001', 'available', '2025-02-13 23:42:54'),
(2, 2, 'Lenovo ThinkPad Keyboard', 'Replacement keyboard for ThinkPad T490 series.', 1, 30.00, 'new', '9800000002', 'available', '2025-02-13 23:42:54'),
(3, 3, 'Dell 8GB DDR4 RAM', 'Dell original DDR4 RAM module for laptops.', 1, 50.00, 'used', '9800000003', 'available', '2025-02-13 23:42:54'),
(4, 2, 'Samsung Galaxy S20 Battery', 'Genuine Samsung battery for Galaxy S20.', 2, 35.00, 'new', '9800000002', 'available', '2025-02-13 23:42:54'),
(5, 3, 'Google Pixel 6 Charging Port', 'Original charging port replacement for Pixel 6.', 2, 25.00, 'new', '9800000003', 'available', '2025-02-13 23:42:54'),
(6, 1, 'Pioneer Car Subwoofer', 'Powerful 12-inch subwoofer for deep bass.', 3, 180.00, 'used', '9800000001', 'available', '2025-02-13 23:42:54'),
(7, 2, 'Dash Cam 1080p', 'Night vision dashboard camera with loop recording.', 3, 75.00, 'new', '9800000002', 'available', '2025-02-13 23:42:54'),
(8, 3, 'Razer BlackWidow Keyboard', 'Mechanical gaming keyboard with RGB lighting.', 4, 90.00, 'used', '9800000003', 'available', '2025-02-13 23:42:54'),
(9, 4, 'PlayStation 5 Controller', 'Official Sony DualSense PS5 Controller.', 4, 55.00, 'new', '9800000004', 'available', '2025-02-13 23:42:54'),
(10, 1, 'GoPro Hero 9', 'Waterproof action camera with 5K video.', 5, 250.00, 'used', '9800000001', 'available', '2025-02-13 23:42:54'),
(11, 2, 'Sony Mirrorless Camera Battery', 'Rechargeable battery for Sony Alpha cameras.', 5, 40.00, 'new', '9800000002', 'available', '2025-02-13 23:42:54'),
(12, 3, 'TP-Link WiFi Router', 'Dual-band wireless router for high-speed internet.', 6, 60.00, 'new', '9800000003', 'available', '2025-02-13 23:42:54'),
(13, 4, 'Netgear Gigabit Switch', '8-port gigabit Ethernet switch for fast networking.', 6, 45.00, 'new', '9800000004', 'available', '2025-02-13 23:42:54'),
(14, 1, 'Samsung 1TB SSD', 'Samsung EVO 1TB NVMe SSD for fast performance.', 7, 120.00, 'new', '9800000001', 'available', '2025-02-13 23:42:54'),
(15, 2, 'Seagate 2TB External HDD', 'Seagate external hard drive with USB 3.0.', 7, 80.00, 'used', '9800000002', 'available', '2025-02-13 23:42:54'),
(16, 3, 'Logitech MX Master 3', 'Ergonomic wireless mouse with multi-device support.', 8, 75.00, 'new', '9800000003', 'available', '2025-02-13 23:42:54'),
(17, 4, 'AOC 24-inch Monitor', '1080p Full HD monitor with 144Hz refresh rate.', 8, 150.00, 'used', '9800000004', 'available', '2025-02-13 23:42:54'),
(18, 1, 'Bose Noise-Canceling Headphones', 'Wireless headphones with active noise cancellation.', 9, 180.00, 'used', '9800000001', 'available', '2025-02-13 23:42:54'),
(19, 2, 'JBL Bluetooth Speaker', 'Portable speaker with powerful bass and long battery.', 9, 90.00, 'new', '9800000002', 'available', '2025-02-13 23:42:54'),
(20, 3, 'Amazon Echo Dot', 'Smart speaker with Alexa voice assistant.', 10, 45.00, 'new', '9800000003', 'available', '2025-02-13 23:42:54'),
(21, 4, 'Google Nest Thermostat', 'Smart thermostat with energy-saving automation.', 10, 120.00, 'new', '9800000004', 'available', '2025-02-13 23:42:54'),
(22, 1, 'Apple Watch Series 6', 'GPS model, 44mm with sport band.', 11, 250.00, 'used', '9800000001', 'available', '2025-02-13 23:42:54'),
(23, 2, 'Fitbit Charge 5', 'Fitness tracker with heart rate and sleep tracking.', 11, 120.00, 'new', '9800000002', 'available', '2025-02-13 23:42:54'),
(24, 3, 'HP LaserJet Printer', 'Black and white laser printer for home office.', 12, 200.00, 'used', '9800000003', 'available', '2025-02-13 23:42:54'),
(25, 4, 'Ergonomic Office Chair', 'Adjustable chair with lumbar support.', 12, 180.00, 'new', '9800000004', 'available', '2025-02-13 23:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `created_at`) VALUES
(27, 1, 'uploads/hp_battery_1.jpg', '2025-02-13 23:43:21'),
(28, 1, 'uploads/hp_battery_2.jpg', '2025-02-13 23:43:21'),
(29, 2, 'uploads/thinkpad_keyboard.jpg', '2025-02-13 23:43:21'),
(30, 3, 'uploads/dell_ram.jpg', '2025-02-13 23:43:21'),
(31, 4, 'uploads/samsung_battery.jpg', '2025-02-13 23:43:21'),
(32, 5, 'uploads/pixel_charging_port.jpg', '2025-02-13 23:43:21'),
(33, 6, 'uploads/pioneer_subwoofer.jpg', '2025-02-13 23:43:21'),
(34, 7, 'uploads/dash_cam.jpg', '2025-02-13 23:43:21'),
(35, 8, 'uploads/razer_keyboard.jpg', '2025-02-13 23:43:21'),
(36, 9, 'uploads/ps5_controller.jpg', '2025-02-13 23:43:21'),
(37, 10, 'uploads/gopro_hero9.jpg', '2025-02-13 23:43:21'),
(38, 11, 'uploads/sony_battery.jpg', '2025-02-13 23:43:21'),
(39, 12, 'uploads/tplink_router.jpg', '2025-02-13 23:43:21'),
(40, 13, 'uploads/netgear_switch.jpg', '2025-02-13 23:43:21'),
(41, 14, 'uploads/samsung_ssd.jpg', '2025-02-13 23:43:21'),
(42, 15, 'uploads/seagate_hdd.jpg', '2025-02-13 23:43:21'),
(43, 16, 'uploads/logitech_mouse.jpg', '2025-02-13 23:43:21'),
(44, 17, 'uploads/aoc_monitor.jpg', '2025-02-13 23:43:21'),
(45, 18, 'uploads/bose_headphones.jpg', '2025-02-13 23:43:21'),
(46, 19, 'uploads/jbl_speaker.jpg', '2025-02-13 23:43:21'),
(47, 20, 'uploads/amazon_echo.jpg', '2025-02-13 23:43:21'),
(48, 21, 'uploads/google_thermostat.jpg', '2025-02-13 23:43:21'),
(49, 22, 'uploads/apple_watch.jpg', '2025-02-13 23:43:21'),
(50, 23, 'uploads/fitbit_charge.jpg', '2025-02-13 23:43:21'),
(51, 24, 'uploads/hp_printer.jpg', '2025-02-13 23:43:21'),
(52, 25, 'uploads/ergonomic_chair.jpg', '2025-02-13 23:43:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_requests`
--

CREATE TABLE `product_requests` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` enum('open','fulfilled','closed') DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','suspended','banned') NOT NULL DEFAULT 'active',
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password_hash`, `profile_image`, `role`, `status`, `is_verified`, `created_at`) VALUES
(1, 'John Doe', 'johndoe@example.com', '9800000001', '$2y$10$examplehash1', 'john.jpg', 'user', 'active', 1, '2025-02-13 23:38:27'),
(2, 'Jane Smith', 'janesmith@example.com', '9800000002', '$2y$10$examplehash2', 'jane.jpg', 'user', 'active', 1, '2025-02-13 23:38:27'),
(3, 'Alice Brown', 'alicebrown@example.com', '9800000003', '$2y$10$examplehash3', NULL, 'admin', 'active', 1, '2025-02-13 23:38:27'),
(4, 'Bob Johnson', 'bobjohnson@example.com', '9800000004', '$2y$10$examplehash4', 'bob.jpg', 'user', 'active', 1, '2025-02-13 23:38:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_requests`
--
ALTER TABLE `product_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `product_requests`
--
ALTER TABLE `product_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_requests`
--
ALTER TABLE `product_requests`
  ADD CONSTRAINT `product_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_requests_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
