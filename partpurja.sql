-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2025 at 05:32 PM
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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `product_id`, `user_id`, `comment_text`, `created_at`) VALUES
(1, 1, 1, 'Is this product still available?', '2025-02-15 12:41:48'),
(39, 1, 14, 'test comment', '2025-02-18 16:28:13');

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
  `product_status` enum('available','sold','removed') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `user_id`, `title`, `description`, `category_id`, `price`, `product_condition`, `product_status`, `created_at`) VALUES
(1, 1, 'HP Laptop Battery', 'Original HP 6-cell battery, compatible with Pavilion series. Original HP 6-cell battery, compatible with Pavilion series. Original HP 6-cell battery, compatible with Pavilion series. Original HP 6-cell battery, compatible with Pavilion series.', 1, 45.00, 'new', 'available', '2025-02-13 23:42:54'),
(2, 2, 'Lenovo ThinkPad Keyboard', 'Replacement keyboard for ThinkPad T490 series.', 1, 30.00, 'new', 'available', '2025-02-13 23:42:54'),
(3, 3, 'Dell 8GB DDR4 RAM', 'Dell original DDR4 RAM module for laptops.', 1, 50.00, 'used', 'available', '2025-02-13 23:42:54'),
(4, 2, 'Samsung Galaxy S20 Battery', 'Genuine Samsung battery for Galaxy S20.', 2, 35.00, 'new', 'available', '2025-02-13 23:42:54'),
(5, 3, 'Google Pixel 6 Charging Port', 'Original charging port replacement for Pixel 6.', 2, 25.00, 'new', 'available', '2025-02-13 23:42:54'),
(6, 1, 'Pioneer Car Subwoofer', 'Powerful 12-inch subwoofer for deep bass.', 3, 180.00, 'used', 'available', '2025-02-13 23:42:54'),
(7, 2, 'Dash Cam 1080p', 'Night vision dashboard camera with loop recording.', 3, 75.00, 'new', 'available', '2025-02-13 23:42:54'),
(8, 3, 'Razer BlackWidow Keyboard', 'Mechanical gaming keyboard with RGB lighting.', 4, 90.00, 'used', 'available', '2025-02-13 23:42:54'),
(9, 4, 'PlayStation 5 Controller', 'Official Sony DualSense PS5 Controller.', 4, 55.00, 'new', 'available', '2025-02-13 23:42:54'),
(10, 1, 'GoPro Hero 9', 'Waterproof action camera with 5K video.', 5, 250.00, 'used', 'available', '2025-02-13 23:42:54'),
(11, 2, 'Sony Mirrorless Camera Battery', 'Rechargeable battery for Sony Alpha cameras.', 5, 40.00, 'new', 'available', '2025-02-13 23:42:54'),
(12, 3, 'TP-Link WiFi Router', 'Dual-band wireless router for high-speed internet.', 6, 60.00, 'new', 'available', '2025-02-13 23:42:54'),
(13, 4, 'Netgear Gigabit Switch', '8-port gigabit Ethernet switch for fast networking.', 6, 45.00, 'new', 'available', '2025-02-13 23:42:54'),
(14, 1, 'Samsung 1TB SSD', 'Samsung EVO 1TB NVMe SSD for fast performance.', 7, 120.00, 'new', 'available', '2025-02-13 23:42:54'),
(15, 2, 'Seagate 2TB External HDD', 'Seagate external hard drive with USB 3.0.', 7, 80.00, 'used', 'available', '2025-02-13 23:42:54'),
(16, 3, 'Logitech MX Master 3', 'Ergonomic wireless mouse with multi-device support.', 8, 75.00, 'new', 'available', '2025-02-13 23:42:54'),
(17, 4, 'AOC 24-inch Monitor', '1080p Full HD monitor with 144Hz refresh rate.', 8, 150.00, 'used', 'available', '2025-02-13 23:42:54'),
(18, 1, 'Bose Noise-Canceling Headphones', 'Wireless headphones with active noise cancellation.', 9, 180.00, 'used', 'available', '2025-02-13 23:42:54'),
(19, 2, 'JBL Bluetooth Speaker', 'Portable speaker with powerful bass and long battery.', 9, 90.00, 'new', 'available', '2025-02-13 23:42:54'),
(20, 3, 'Amazon Echo Dot', 'Smart speaker with Alexa voice assistant.', 10, 45.00, 'new', 'available', '2025-02-13 23:42:54'),
(21, 4, 'Google Nest Thermostat', 'Smart thermostat with energy-saving automation.', 10, 120.00, 'new', 'available', '2025-02-13 23:42:54'),
(22, 1, 'Apple Watch Series 6', 'GPS model, 44mm with sport band.', 11, 250.00, 'used', 'available', '2025-02-13 23:42:54'),
(23, 2, 'Fitbit Charge 5', 'Fitness tracker with heart rate and sleep tracking.', 11, 120.00, 'new', 'available', '2025-02-13 23:42:54'),
(24, 3, 'HP LaserJet Printer', 'Black and white laser printer for home office.', 12, 200.00, 'used', 'available', '2025-02-13 23:42:54'),
(25, 4, 'Ergonomic Office Chair', 'Adjustable chair with lumbar support.', 12, 180.00, 'new', 'available', '2025-02-13 23:42:54');

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
(27, 1, '../assets/uploads/hp_battery_1.jpg', '2025-02-13 23:43:21'),
(28, 1, '../assets/uploads/hp_battery_2.jpg', '2025-02-13 23:43:21'),
(29, 2, '../assets/uploads/thinkpad_keyboard.jpg', '2025-02-13 23:43:21'),
(30, 3, '../assets/uploads/dell_ram.jpg', '2025-02-13 23:43:21'),
(31, 4, '../assets/uploads/samsung_battery.jpg', '2025-02-13 23:43:21'),
(32, 5, '../assets/uploads/pixel_charging_port.jpg', '2025-02-13 23:43:21'),
(33, 6, '../assets/uploads/pioneer_subwoofer.jpg', '2025-02-13 23:43:21'),
(34, 7, '../assets/uploads/dash_cam.jpg', '2025-02-13 23:43:21'),
(35, 8, '../assets/uploads/razer_keyboard.jpg', '2025-02-13 23:43:21'),
(36, 9, '../assets/uploads/ps5_controller.jpg', '2025-02-13 23:43:21'),
(37, 10, '../assets/uploads/gopro_hero9.jpg', '2025-02-13 23:43:21'),
(38, 11, '../assets/uploads/sony_battery.jpg', '2025-02-13 23:43:21'),
(39, 12, '../assets/uploads/tplink_router.jpg', '2025-02-13 23:43:21'),
(40, 13, '../assets/uploads/netgear_switch.jpg', '2025-02-13 23:43:21'),
(41, 14, '../assets/uploads/samsung_ssd.jpg', '2025-02-13 23:43:21'),
(42, 15, '../assets/uploads/seagate_hdd.jpg', '2025-02-13 23:43:21'),
(43, 16, '../assets/uploads/logitech_mouse.jpg', '2025-02-13 23:43:21'),
(44, 17, '../assets/uploads/aoc_monitor.jpg', '2025-02-13 23:43:21'),
(45, 18, '../assets/uploads/bose_headphones.jpg', '2025-02-13 23:43:21'),
(46, 19, '../assets/uploads/jbl_speaker.jpg', '2025-02-13 23:43:21'),
(47, 20, '../assets/uploads/amazon_echo.jpg', '2025-02-13 23:43:21'),
(48, 21, '../assets/uploads/google_thermostat.jpg', '2025-02-13 23:43:21'),
(49, 22, '../assets/uploads/apple_watch.jpg', '2025-02-13 23:43:21'),
(50, 23, '../assets/uploads/fitbit_charge.jpg', '2025-02-13 23:43:21'),
(51, 24, '../assets/uploads/hp_printer.jpg', '2025-02-13 23:43:21'),
(52, 25, '../assets/uploads/ergonomic_chair.jpg', '2025-02-13 23:43:21');

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

--
-- Dumping data for table `product_requests`
--

INSERT INTO `product_requests` (`request_id`, `user_id`, `request_title`, `description`, `category_id`, `status`, `created_at`) VALUES
(1, 1, 'Looking for MacBook Air Charger', 'I need an original Apple 30W USB-C power adapter for my MacBook Air.', 1, 'open', '2025-02-17 13:55:55'),
(2, 2, 'Need Dell XPS Battery', 'Looking for a replacement battery for Dell XPS 15 (Model 7590).', 1, 'open', '2025-02-17 13:55:55'),
(3, 3, 'iPhone 13 Pro Screen Replacement', 'My screen is cracked, looking for an original iPhone 13 Pro display.', 2, 'open', '2025-02-17 13:55:55'),
(4, 4, 'Samsung Galaxy S21 Camera Lens', 'Need a replacement camera lens for Samsung Galaxy S21 Ultra.', 2, 'open', '2025-02-17 13:55:55'),
(5, 1, 'Car Bluetooth Audio Adapter', 'Need a Bluetooth adapter for my Toyota Corolla (2017) audio system.', 3, 'open', '2025-02-17 13:55:55'),
(6, 2, 'Dash Cam with Parking Mode', 'Looking for a 1080p+ dash cam that supports 24/7 parking monitoring.', 3, 'open', '2025-02-17 13:55:55'),
(7, 3, 'Razer Gaming Headset', 'Looking for a Razer Kraken or Razer BlackShark headset for gaming.', 4, 'open', '2025-02-17 13:55:55'),
(8, 4, 'PS5 Cooling Fan', 'Need an external cooling fan for my PlayStation 5 console.', 4, 'open', '2025-02-17 13:55:55'),
(9, 1, 'Canon Camera Battery LP-E6N', 'Need a backup battery for my Canon EOS 90D.', 5, 'open', '2025-02-17 13:55:55'),
(10, 2, 'Tripod for DSLR Camera', 'Looking for a sturdy tripod for landscape photography.', 5, 'open', '2025-02-17 13:55:55'),
(11, 3, 'WiFi Range Extender', 'Need a WiFi signal booster for a large house.', 6, 'open', '2025-02-17 13:55:55'),
(12, 4, 'Cat6 Ethernet Cables (50m)', 'Looking for high-quality Cat6 Ethernet cables for home networking.', 6, 'open', '2025-02-17 13:55:55'),
(13, 1, 'External SSD (500GB or 1TB)', 'Need a fast portable SSD, preferably Samsung or WD.', 7, 'open', '2025-02-17 13:55:55'),
(14, 2, 'NAS Storage System', 'Looking for a 2-bay or 4-bay NAS system for home storage.', 7, 'open', '2025-02-17 13:55:55'),
(15, 3, 'Mechanical Keyboard with RGB', 'Looking for a good mechanical keyboard, preferably Logitech or Corsair.', 8, 'open', '2025-02-17 13:55:55'),
(16, 4, 'Vertical Ergonomic Mouse', 'Need an ergonomic vertical mouse for wrist pain relief.', 8, 'open', '2025-02-17 13:55:55'),
(17, 1, 'Wireless Earbuds (Noise Cancelling)', 'Looking for high-quality noise-canceling wireless earbuds.', 9, 'open', '2025-02-17 13:55:55'),
(18, 2, 'Studio Microphone (USB/XLR)', 'Need a professional microphone for podcasting and streaming.', 9, 'open', '2025-02-17 13:55:55'),
(19, 3, 'Smart Light Bulbs (WiFi Enabled)', 'Looking for color-changing smart bulbs compatible with Alexa.', 10, 'open', '2025-02-17 13:55:55'),
(20, 4, 'Smart Door Lock', 'Need a smart door lock with fingerprint and remote access.', 10, 'open', '2025-02-17 13:55:55'),
(21, 1, 'Garmin Smartwatch', 'Looking for a Garmin Forerunner series smartwatch for running.', 11, 'open', '2025-02-17 13:55:55'),
(22, 2, 'Replacement Band for Fitbit', 'Need a replacement strap for my Fitbit Charge 4.', 11, 'open', '2025-02-17 13:55:55'),
(23, 3, 'Standing Desk', 'Looking for a height-adjustable standing desk for home office.', 12, 'open', '2025-02-17 13:55:55'),
(24, 4, 'Multi-Function Laser Printer', 'Need a printer with scanning and wireless printing.', 12, 'open', '2025-02-17 13:55:55');

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
  `profile_image` varchar(255) NOT NULL DEFAULT '../assets/images/default.png',
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','suspended','banned') NOT NULL DEFAULT 'active',
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `password_hash`, `profile_image`, `role`, `status`, `is_verified`, `created_at`) VALUES
(1, 'John Doe', 'johndoe@example.com', '9800000001', '$2y$10$examplehash1', '../assets/images/default.png', 'user', 'active', 1, '2025-02-13 23:38:27'),
(2, 'Jane Smith', 'janesmith@example.com', '9800000002', '$2y$10$examplehash2', '../assets/images/default.png', 'user', 'active', 1, '2025-02-13 23:38:27'),
(3, 'Alice Brown', 'alicebrown@example.com', '9800000003', '$2y$10$examplehash3', '../assets/images/default.png', 'admin', 'active', 1, '2025-02-13 23:38:27'),
(4, 'Bob Johnson', 'bobjohnson@example.com', '9800000004', '$2y$10$examplehash4', '../assets/images/default.png', 'user', 'active', 1, '2025-02-13 23:38:27'),
(13, 'sachin lama', 'sachinlama2003@gmail.com', '9845353156', 'adcd7048512e64b48da55b027577886ee5a36350', '../assets/profile_pictures/@Ehxamination.jpg', 'user', 'active', 1, '2025-02-18 15:38:43'),
(14, 'alt sachin', 'sachinlama2060@gmail.com', '9845353155', 'adcd7048512e64b48da55b027577886ee5a36350', '../assets/profile_pictures/@Ehxamination.jpg', 'user', 'active', 1, '2025-02-18 16:27:44');

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
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `product_requests`
--
ALTER TABLE `product_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
