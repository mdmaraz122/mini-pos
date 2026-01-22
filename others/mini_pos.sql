-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2026 at 09:27 PM
-- Server version: 11.4.9-MariaDB-cll-lve-log
-- PHP Version: 8.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rawisnwp_miniPOS`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `password` varchar(800) NOT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `token` varchar(1500) DEFAULT NULL,
  `2fa_status` enum('Enabled','Disabled') NOT NULL DEFAULT 'Disabled',
  `status` enum('Active','Inactive','Unverified','Locked') NOT NULL DEFAULT 'Unverified',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `first_name`, `middle_name`, `last_name`, `email`, `phone`, `password`, `dob`, `gender`, `image`, `otp`, `token`, `2fa_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'Md.', '2', 'Maraz', 'maraz53334@gmail.com', '3243', '$2y$12$ZYo/PoVc70uR54IS7WptOOlK2G2MGEbWl99DEU1T.R2A6qsAxhpl6', '2025-06-04', 'Female', 'profile_1_1769020567.jpg', NULL, NULL, 'Disabled', 'Active', '2025-05-23 11:03:29', '2026-01-21 23:36:45');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `admin_id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ACI', 'aci', NULL, 'Active', '2025-05-23 06:42:29', '2025-05-23 06:42:29'),
(2, 1, 'Unilever', 'unilever', '68306d6628b5c.jpg', 'Active', '2025-05-23 06:43:02', '2025-06-01 15:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `admin_id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Home Cleaning', 'home-cleaning', NULL, 'Active', '2025-05-23 05:57:06', '2025-05-23 05:57:06'),
(3, 1, 'Food', 'food', NULL, 'Active', '2025-05-23 06:28:23', '2025-05-23 06:28:23'),
(4, 1, 'Medicine', 'medicine', NULL, 'Active', '2025-05-26 09:09:07', '2025-05-26 09:09:07'),
(5, 1, 'Stationery', 'stationery', NULL, 'Active', '2025-05-26 09:14:29', '2025-05-26 09:14:29'),
(6, 1, 'Beauty', 'beauty', NULL, 'Active', '2025-05-26 09:24:54', '2025-06-01 15:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `due` double NOT NULL DEFAULT 0,
  `advance` double NOT NULL DEFAULT 0,
  `address` varchar(10) DEFAULT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `due`, `advance`, `address`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Walking Customer', '99', 0, 0, 'nice', 'Active', '2025-05-28 14:48:34', '2025-05-28 14:48:34'),
(4, 'Rafi', '11', 0, 0, '', 'Active', '2025-05-28 15:13:15', '2025-05-28 15:13:15'),
(9, 'Md. Maraz', '01648837019', 0, 0, '', 'Active', '2026-01-21 23:51:14', '2026-01-21 23:51:14');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2025_05_06_110740_create_admins_table', 1),
(10, '2025_05_06_142415_create_sessions_table', 1),
(11, '2025_05_07_194314_create_categories_table', 1),
(12, '2025_05_07_194549_create_sub_categories_table', 1),
(13, '2025_05_09_195022_create_brands_table', 1),
(14, '2025_05_09_204826_create_taxes_table', 1),
(15, '2025_05_11_114957_create_units_table', 1),
(16, '2025_05_12_190851_create_products_table', 1),
(18, '2025_05_28_131614_create_customers_table', 2),
(21, '2025_05_29_135131_create_orders_table', 3),
(22, '2025_05_29_185022_create_order_details_table', 3),
(24, '2025_06_01_090609_create_notifications_table', 4),
(25, '2025_06_01_200307_create_settings_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `url` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `title`, `message`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 05:03:28'),
(2, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 05:04:13'),
(3, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:25'),
(4, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 06:27:24'),
(5, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:25'),
(6, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:25'),
(7, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(8, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(9, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(10, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(11, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(12, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(13, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(14, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(15, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(16, 'warning', 'Stock Alert', 'Product Friend Up 250ML stock is low. Only 1 left. Please restock.', '/products/view/friend-up-250ml', 1, '2025-06-01 03:33:45', '2025-06-01 04:44:26'),
(17, 'warning', 'Stock Alert', 'Product Nescafe Classic 45g stock is low. Only 2 left. Please restock.', '/products/view/nescafe-classic-45g', 1, '2025-06-01 05:09:20', '2025-06-01 06:22:54'),
(18, 'warning', 'Stock Alert', 'Product Nescafe Classic 45g stock is low. Only 1 left. Please restock.', '/products/view/nescafe-classic-45g', 1, '2025-06-01 06:37:20', '2025-06-01 06:40:27'),
(19, 'warning', 'Stock Alert', 'Product Nescafe Classic 45g stock is low. Only 0 left. Please restock.', '/products/view/nescafe-classic-45g', 1, '2025-06-01 06:40:35', '2025-06-01 06:40:53'),
(20, 'warning', 'Stock Alert', 'Product Nescafe Classic 45g stock is low. Only 0 left. Please restock.', '/products/view/nescafe-classic-45g', 1, '2025-06-03 05:26:43', '2025-06-03 05:33:30'),
(21, 'warning', 'Stock Alert', 'Product RC Cola 2L stock is low. Only 2 left. Please restock.', '/products/view/rc-cola-2l', 1, '2025-06-03 17:10:36', '2025-06-03 17:11:43'),
(22, 'warning', 'Stock Alert', 'Product RC Cola 2L stock is low. Only 0 left. Please restock.', '/products/view/rc-cola-2l', 0, '2026-01-21 23:53:26', '2026-01-21 23:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` double NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `pay` double NOT NULL DEFAULT 0,
  `due` double NOT NULL DEFAULT 0,
  `payment_method` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `customer_id`, `total_amount`, `quantity`, `pay`, `due`, `payment_method`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, '6839558', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-05-29 15:01:36', '2025-05-29 15:01:36'),
(2, '0607992', 2, 302.5, 1, 302.5, 0, 'Cash', NULL, 'Completed', '2025-05-29 15:51:23', '2025-05-29 15:51:23'),
(3, '9827327', 2, 120, 1, 120, 0, 'Cash', NULL, 'Completed', '2025-05-29 15:51:53', '2025-05-29 15:51:53'),
(4, '3882889', 2, 120, 1, 120, 0, 'Cash', NULL, 'Completed', '2025-05-29 15:52:31', '2025-05-29 15:52:31'),
(5, '6588936', 2, 2836.5, 7, 2836.5, 0, 'Cash', NULL, 'Completed', '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(6, '8939144', 2, 362.5, 2, 362.5, 0, 'Cash', NULL, 'Completed', '2025-05-29 16:10:03', '2025-05-29 16:10:03'),
(7, '8551402', 2, 120, 1, 120, 0, 'Cash', NULL, 'Completed', '2025-05-31 05:32:54', '2025-05-31 05:32:54'),
(8, '5107259', 2, 120, 1, 120, 0, 'Cash', NULL, 'Completed', '2025-05-31 12:04:59', '2025-05-31 12:04:59'),
(9, '2884579', 2, 120, 1, 120, 0, 'Cash', NULL, 'Completed', '2025-05-31 12:44:43', '2025-05-31 12:44:43'),
(10, '1151294', 2, 362.5, 2, 362.5, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:04:50', '2025-05-31 13:04:50'),
(11, '8559381', 2, 605, 1, 605, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:05:48', '2025-05-31 13:05:48'),
(12, '8246830', 2, 302.5, 1, 302.5, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:13:29', '2025-05-31 13:13:29'),
(13, '8597701', 2, 362.5, 2, 362.5, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:14:32', '2025-05-31 13:14:32'),
(14, '2795377', 2, 605, 1, 605, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:14:47', '2025-05-31 13:14:47'),
(15, '5963234', 2, 907.5, 1, 907.5, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:19:14', '2025-05-31 13:19:14'),
(16, '7761866', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:19:56', '2025-05-31 23:55:11'),
(17, '3746327', 2, 907.5, 1, 907.5, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:20:38', '2025-05-31 13:20:38'),
(18, '5648148', 2, 120, 1, 120, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:31:09', '2025-05-31 13:31:09'),
(19, '9501077', 2, 665, 2, 665, 0, 'Cash', NULL, 'Completed', '2025-05-31 13:33:25', '2025-05-31 13:33:25'),
(21, '4738048', 2, 1400, 1, 1400, 0, 'Cash', NULL, 'Completed', '2025-05-31 15:01:29', '2025-05-31 15:01:29'),
(22, '7833328', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-05-31 15:27:01', '2025-05-31 15:27:01'),
(23, '9813528', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-05-31 23:03:25', '2025-05-31 23:03:25'),
(24, '5258426', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-05-31 23:39:52', '2025-05-31 23:54:52'),
(25, '1897227', 2, 1400, 1, 1400, 0, 'Cash', NULL, 'Completed', '2025-06-01 00:16:14', '2025-06-01 00:16:14'),
(26, '5936270', 2, 580, 1, 580, 0, 'Cash', 'ffff', 'Completed', '2025-06-01 03:01:28', '2025-06-01 03:01:28'),
(27, '1397994', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:29:18', '2025-06-01 03:29:18'),
(28, '8483940', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:29:38', '2025-06-01 03:29:38'),
(29, '6627905', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:30:21', '2025-06-01 03:30:21'),
(30, '1592334', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:30:40', '2025-06-01 03:30:40'),
(31, '9170608', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:32:56', '2025-06-01 03:32:56'),
(32, '0326849', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:32:58', '2025-06-01 03:32:58'),
(33, '6279613', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:33:26', '2025-06-01 03:33:26'),
(34, '0545090', 2, 60, 1, 60, 0, 'Cash', NULL, 'Completed', '2025-06-01 03:33:45', '2025-06-01 03:33:45'),
(35, '9483452', 2, 1815, 1, 1815, 0, 'Cash', NULL, 'Completed', '2025-06-01 05:09:20', '2025-06-01 05:09:20'),
(37, '5224614', 2, 302.5, 1, 302.5, 0, 'Card', NULL, 'Completed', '2025-06-01 06:40:35', '2025-06-01 06:40:35'),
(38, '2466561', 2, 302.5, 1, 302.5, 0, 'Online', NULL, 'Completed', '2025-06-03 05:26:43', '2025-06-03 05:26:43'),
(39, '2567666', 2, 290, 1, 290, 0, 'Cash', NULL, 'Completed', '2025-06-03 05:28:19', '2025-06-03 05:28:19'),
(40, '6685905', 2, 1000, 1, 1000, 0, 'Cash', NULL, 'Completed', '2025-06-03 16:26:20', '2025-06-03 16:26:20'),
(43, '2916506', 2, 250, 1, 250, 0, 'Cash', NULL, 'Completed', '2025-06-03 17:29:56', '2025-06-03 17:29:56'),
(44, '1274561', 2, 250, 1, 250, 0, 'Cash', NULL, 'Completed', '2025-06-04 09:23:55', '2025-06-04 09:23:55'),
(45, '3674383', 2, 1812.5, 7, 1812.5, 0, 'Online', NULL, 'Completed', '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(46, '3719505', 2, 2100, 1, 2100, 0, 'Cash', NULL, 'Completed', '2025-06-04 12:40:18', '2025-06-04 12:40:18'),
(47, '6040627', 2, 362.5, 2, 362.5, 0, 'Cash', NULL, 'Completed', '2025-06-05 15:30:51', '2025-06-05 15:30:51'),
(48, '5288984', 2, 330, 1, 330, 0, 'Cash', NULL, 'Completed', '2025-06-05 15:33:10', '2025-06-05 15:33:10'),
(49, '4747374', 2, 725, 2, 725, 0, 'Cash', NULL, 'Completed', '2025-06-13 05:31:14', '2025-06-13 05:31:14'),
(50, '4582477', 2, 362.5, 2, 362.5, 0, 'Cash', NULL, 'Completed', '2025-06-17 21:50:48', '2025-06-17 21:50:48'),
(51, '0450326', 2, 120, 1, 120, 0, 'Cash', NULL, 'Completed', '2025-10-23 17:57:31', '2025-10-23 17:57:31'),
(52, '6591723', 2, 362.5, 2, 362.5, 0, 'Cash', NULL, 'Completed', '2026-01-21 23:17:13', '2026-01-21 23:17:13');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `tax` double DEFAULT NULL,
  `tax_type` varchar(255) DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `quantity`, `tax`, `tax_type`, `discount`, `discount_type`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-29 15:01:36', '2025-05-29 15:01:36'),
(2, 2, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-05-29 15:51:23', '2025-05-29 15:51:23'),
(3, 3, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-05-29 15:51:53', '2025-05-29 15:51:53'),
(4, 4, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-05-29 15:52:31', '2025-05-29 15:52:31'),
(5, 5, 8, 20, 1, 10, 'Inclusive', 0, 'Fixed', 20, '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(6, 5, 7, 700, 1, 0, 'Inclusive', 8, 'Percentage', 644, '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(7, 5, 6, 290, 5, 0, 'null', 0, 'Fixed', 1450, '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(8, 5, 5, 110, 1, 0, 'null', 0, 'Fixed', 110, '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(9, 5, 4, 250, 1, 0, 'null', 0, 'Fixed', 250, '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(10, 5, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(11, 5, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-29 15:53:39', '2025-05-29 15:53:39'),
(12, 6, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-29 16:10:03', '2025-05-29 16:10:03'),
(13, 6, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-05-29 16:10:03', '2025-05-29 16:10:03'),
(14, 7, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-05-31 05:32:54', '2025-05-31 05:32:54'),
(15, 8, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-05-31 12:04:59', '2025-05-31 12:04:59'),
(16, 9, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-05-31 12:44:43', '2025-05-31 12:44:43'),
(17, 10, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-31 13:04:50', '2025-05-31 13:04:50'),
(18, 10, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-05-31 13:04:50', '2025-05-31 13:04:50'),
(19, 11, 3, 275, 2, 10, 'Exclusive', 0, 'Fixed', 605, '2025-05-31 13:05:48', '2025-05-31 13:05:48'),
(20, 12, 3, 275, 1, 0, 'Exclusive', 0, 'Fixed', 275, '2025-05-31 13:13:29', '2025-05-31 13:13:29'),
(21, 13, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-31 13:14:32', '2025-05-31 13:14:32'),
(22, 13, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-05-31 13:14:32', '2025-05-31 13:14:32'),
(23, 14, 3, 275, 2, 10, 'Exclusive', 0, 'Fixed', 605, '2025-05-31 13:14:47', '2025-05-31 13:14:47'),
(24, 15, 3, 275, 3, 10, 'Exclusive', 0, 'Fixed', 907.5, '2025-05-31 13:19:14', '2025-05-31 13:19:14'),
(25, 16, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-31 13:19:56', '2025-05-31 13:19:56'),
(26, 17, 3, 275, 3, 10, 'Exclusive', 0, 'Fixed', 907.5, '2025-05-31 13:20:38', '2025-05-31 13:20:38'),
(27, 18, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-05-31 13:31:09', '2025-05-31 13:31:09'),
(28, 19, 3, 275, 2, 10, 'Exclusive', 0, 'Fixed', 605, '2025-05-31 13:33:25', '2025-05-31 13:33:25'),
(29, 19, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-31 13:33:25', '2025-05-31 13:33:25'),
(33, 21, 7, 700, 2, 0, 'Inclusive', 0, 'Percentage', 1400, '2025-05-31 15:01:29', '2025-05-31 15:01:29'),
(34, 22, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-31 15:27:01', '2025-05-31 15:27:01'),
(35, 23, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-31 23:03:25', '2025-05-31 23:03:25'),
(36, 24, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-05-31 23:39:52', '2025-05-31 23:39:52'),
(37, 25, 7, 700, 2, 0, 'Inclusive', 0, 'Percentage', 1400, '2025-06-01 00:16:14', '2025-06-01 00:16:14'),
(38, 26, 6, 290, 2, 0, 'null', 0, 'Fixed', 580, '2025-06-01 03:01:28', '2025-06-01 03:01:28'),
(39, 33, 8, 20, 3, 10, 'Inclusive', 0, 'Fixed', 60, '2025-06-01 03:33:26', '2025-06-01 03:33:26'),
(40, 34, 8, 20, 3, 10, 'Inclusive', 0, 'Fixed', 60, '2025-06-01 03:33:45', '2025-06-01 03:33:45'),
(41, 35, 3, 275, 6, 10, 'Exclusive', 0, 'Fixed', 1815, '2025-06-01 05:09:20', '2025-06-01 05:09:20'),
(43, 37, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-06-01 06:40:35', '2025-06-01 06:40:35'),
(44, 38, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-06-03 05:26:43', '2025-06-03 05:26:43'),
(45, 39, 6, 290, 1, 0, 'null', 0, 'Fixed', 290, '2025-06-03 05:28:19', '2025-06-03 05:28:19'),
(46, 40, 4, 250, 4, 0, 'null', 0, 'Fixed', 1000, '2025-06-03 16:26:20', '2025-06-03 16:26:20'),
(49, 43, 4, 250, 1, 0, 'null', 0, 'Fixed', 250, '2025-06-03 17:29:56', '2025-06-03 17:29:56'),
(50, 44, 4, 250, 1, 0, 'null', 0, 'Fixed', 250, '2025-06-04 09:23:55', '2025-06-04 09:23:55'),
(51, 45, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(52, 45, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(53, 45, 4, 250, 1, 0, 'null', 0, 'Fixed', 250, '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(54, 45, 5, 110, 1, 0, 'null', 0, 'Fixed', 110, '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(55, 45, 6, 290, 1, 0, 'null', 0, 'Fixed', 290, '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(56, 45, 7, 700, 1, 0, 'Inclusive', 0, 'Percentage', 700, '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(57, 45, 8, 20, 2, 10, 'Inclusive', 0, 'Fixed', 40, '2025-06-04 12:15:20', '2025-06-04 12:15:20'),
(58, 46, 7, 700, 3, 0, 'Inclusive', 0, 'Percentage', 2100, '2025-06-04 12:40:18', '2025-06-04 12:40:18'),
(59, 47, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-06-05 15:30:51', '2025-06-05 15:30:51'),
(60, 47, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-06-05 15:30:52', '2025-06-05 15:30:52'),
(61, 48, 5, 110, 3, 0, 'null', 0, 'Fixed', 330, '2025-06-05 15:33:10', '2025-06-05 15:33:10'),
(62, 49, 3, 275, 2, 10, 'Exclusive', 0, 'Fixed', 605, '2025-06-13 05:31:14', '2025-06-13 05:31:14'),
(63, 49, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-06-13 05:31:14', '2025-06-13 05:31:14'),
(64, 50, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2025-06-17 21:50:48', '2025-06-17 21:50:48'),
(65, 50, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2025-06-17 21:50:48', '2025-06-17 21:50:48'),
(66, 51, 2, 60, 2, 0, 'Inclusive', 0, 'Fixed', 120, '2025-10-23 17:57:31', '2025-10-23 17:57:31'),
(67, 52, 2, 60, 1, 0, 'Inclusive', 0, 'Fixed', 60, '2026-01-21 23:17:13', '2026-01-21 23:17:13'),
(68, 52, 3, 275, 1, 10, 'Exclusive', 0, 'Fixed', 302.5, '2026-01-21 23:17:13', '2026-01-21 23:17:13');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `sub_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `quantity_alert` double NOT NULL DEFAULT 0,
  `purchase_price` double NOT NULL DEFAULT 0,
  `mrp` double NOT NULL DEFAULT 0,
  `selling_price` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `discount_type` enum('Fixed','Percentage') NOT NULL DEFAULT 'Fixed',
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_type` enum('Inclusive','Exclusive') DEFAULT NULL,
  `short_description` text NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `admin_id`, `brand_id`, `category_id`, `sub_category_id`, `unit_id`, `name`, `slug`, `sku`, `barcode`, `image`, `quantity`, `quantity_alert`, `purchase_price`, `mrp`, `selling_price`, `discount`, `discount_type`, `tax_id`, `tax_type`, `short_description`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, 3, NULL, 5, 'RC Cola 1L', 'rc-cola-1l', 'food-925594', '880196272203', 'rc-cola-2-l_683447fa70c1b.jpg', 24, 18, 58, 60, 60, 0, 'Fixed', NULL, 'Inclusive', '', 'Active', '2025-05-26 04:52:42', '2026-01-21 23:17:13'),
(3, 1, NULL, 3, NULL, 5, 'Nescafe Classic 45g', 'nescafe-classic-45g', 'food-210092', '8901058006377', 'nescafe-classic-45g_6834835f8d124.jpg', 27, 6, 270, 275, 275, 3, 'Fixed', 1, 'Exclusive', '', 'Active', '2025-05-26 09:06:07', '2026-01-21 23:17:13'),
(4, 1, NULL, 4, NULL, 5, 'AXE Brand Universal Oil 5ML', 'axe-brand-universal-oil-5ml', 'medi-709348', '8888115000151', NULL, 14, 7, 220, 250, 250, 0, 'Fixed', NULL, NULL, '', 'Active', '2025-05-26 09:11:22', '2025-06-04 12:15:20'),
(5, 1, NULL, 3, NULL, 5, 'RC Cola 2L', 'rc-cola-2l', 'food-192957', '880196272401', 'rc-cola-2l_6834869a41c04.jpg', 6, 5, 105, 110, 110, 0, 'Fixed', NULL, NULL, '', 'Active', '2025-05-26 09:19:54', '2026-01-21 23:54:27'),
(6, 1, 1, 2, NULL, 5, 'Odonil Citrus Fresh 300ML', 'odonil-citrus-fresh-300ml', 'home-213160', '745125887128', 'odonil-citrus-fresh-300ml_683487aa3fc66.jpg', 21, 15, 285, 290, 290, 0, 'Fixed', NULL, NULL, '', 'Active', '2025-05-26 09:24:26', '2025-06-04 12:15:20'),
(7, 1, NULL, 6, NULL, 5, 'Vitamin E', 'vitamin-e', 'beau-234332', '8850722201504', NULL, 29, 2, 670, 700, 700, 8, 'Percentage', NULL, 'Inclusive', '', 'Active', '2025-05-26 09:26:08', '2025-06-04 12:40:18'),
(8, 1, 2, 3, NULL, 5, 'Friend Up 250ML', 'friend-up-250ml', 'food-15170', '8326310000434', NULL, 30, 2, 18, 20, 20, 5, 'Fixed', 1, 'Inclusive', '', 'Active', '2025-05-28 04:25:02', '2025-06-04 12:15:20');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('4xWV1Af87sFEe3fZJqnYnZfs2e5Vbrts4owPW9zs', NULL, '16.145.96.37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19582', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR3pzSVFmd2lieHFTNFRRWmVKS0lLQTRETDViWEpKcGlhYWRXSGhjQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769019345),
('6nxt0jlozKJ107TQOMkD5mYz6ywxdjPCUlrw06oA', NULL, '54.149.139.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.7559.96 Safari/537.36 Edge/18.19582', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1B0aW50dURtbjhtM3c2ZEYxWXhBaXBnY3M1NkdRM1oxMEhueXNwSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769020663),
('8lgleMhGXkEg9D7yxbkboLHlXGmmxPzaXIJMKp0s', NULL, '149.57.180.135', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia2tVWDdnWm91VWhXT3p2a0kzMGI2SENidDYyRnZ4MDVVWGlSS2tXbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769026167),
('An39AnDetNJMsftz1rOEvnRel1BQHvU2CgkBZBmP', NULL, '16.145.96.37', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G965U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTBvOWhYMWl0aVJTVnNSemdVc2x1eG9IWXo4MVFyb0Uyb2s5aTNIMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769019345),
('bQd5ciJH15IMsPGCrW6o5iyYKAdUrFGGQrqH2PTg', NULL, '23.27.145.134', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmN0SFpiZ1BuZWxFUlZxdlgyZ2dJNUswRFRZdE9JaDQ4aGRjRzJMRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769044783),
('bUXhx10qbVOLPur4T59nlDwSzKhgIuwyR2ktTyNF', NULL, '149.57.180.131', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXF2bmZPbkNPUGx2R0NVeW11NFc1RVB1MHNMZmFTajA4bGg4ZGpMciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769042967),
('bYFi1QZu6Fu3TCfSnE5Xlm5gitd2hp0GtQJZuG1M', NULL, '163.61.106.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidTFIZDN3Z21CTkZYaXVNS2IwTU9KVmFDZkpXblVPZUwxUFRSaTEwVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjQ6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9iYWNrZW5kRGF0YS9hY3RpdmVOb3RpZmljYXRpb25zLWxpc3QiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769021693),
('gzSgR8NV8tzp0KPp5m0qmxEpsSi8o5d4dqw5hPLB', NULL, '52.16.245.145', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFNTRXlma01jeFhCc1hNd2plUVFsaWVCbXZLNU1jV25COUxDWUViTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769043265),
('KFr2z9Gw0vdqQe6rIJFH6yESRZ21v7fnJjUuFN8y', NULL, '54.149.139.62', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G965U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.7559.96 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazI2eTVxU1lJQWJYYnFaZTd5ZGpPRXJ5R25pN1RERzNVb21MTnZaaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769020666),
('KIW9TIN8sERnhXhq2aLEXoCxGKERLFsvCNW2rj1x', NULL, '52.16.245.145', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjJiNmNWSFA2MTVkckdrdUFPRnFxN1FjdDNsZHFhdk42alh2Y09kYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769043328),
('mEubSrKUtLzQEYKyJtGPtrrdAQaUi5joUPjtBpAC', NULL, '16.145.96.37', 'Mozilla/5.0 (Linux; Android 8.0.0; SM-G965U Build/R16NW) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.111 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWdWcGxEOUJEWHN0aXJ5MFNlRm9xWW1tZWNmdEY2eTRsaVozdVFWbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769019345),
('qh0mICLf7MPO6Pw15LSmCsKCeoo4CKBTieC4dzAI', NULL, '23.27.145.29', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0JTT2N2Q3h3c2pIcGljTVpmWmJnYTJEd0tlRno1ZEdMQkVscWlWTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769046647),
('QNrrtRaHMXu6y9WsiwYGbOe7or28zaNTSqhjJC4i', NULL, '16.145.96.37', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19582', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVBNTEVnaXowWXV2d0s4NWZoaXRrRmdkVXBFQ0N6bEx6cHBBbUdTZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769019345),
('T7bVu7Sm9qBp0dmFtibbFWUZIFVmdCrfUwkBReVu', NULL, '23.27.145.213', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWVjRGdWNm1QeUpFQWFUcW54eDU0U2tXbGlVSXc5QXJmQUpqdmlsdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769029407),
('yecn1JscD8V64i8hCNH5plQac1jNeLN4CgiHQoep', NULL, '52.16.245.145', 'Mozilla/5.0 (X11; Linux x86_64; rv:83.0) Gecko/20100101 Firefox/83.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3Z6R2F0R3hwd1ptWFBLMGxMd1B6TlJuN1pZcFdFY1U3ODN4bklhZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vbWluaXBvcy5tZG1hcmF6Lm5ldC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769043264);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_name` varchar(255) NOT NULL,
  `shop_address` varchar(255) NOT NULL,
  `shop_phone` varchar(255) NOT NULL,
  `receipt_message` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `shop_name`, `shop_address`, `shop_phone`, `receipt_message`, `created_at`, `updated_at`) VALUES
(1, 'Raw It Solutions', '09/01,A Mirpur-11, Dhaka-1216', '01897964444', 'Thank you for shopping with us! Please visit again', '2025-06-01 20:19:23', '2025-11-06 15:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `admin_id`, `category_id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 3, 'Drink', 'drink', 'Active', '2025-05-23 06:39:11', '2025-05-23 06:39:11'),
(4, 1, 3, 'Coffee', 'coffee', 'Active', '2025-05-26 09:07:36', '2025-05-26 09:07:36'),
(5, 1, 5, 'Glue', 'glue', 'Active', '2025-05-26 09:14:40', '2025-05-26 09:14:40'),
(6, 1, 2, 'Air Freshner', 'air-freshner', 'Active', '2025-05-26 09:22:23', '2025-05-26 09:22:23'),
(7, 1, 6, 'Cream', 'cream', 'Active', '2025-05-26 09:25:07', '2025-05-26 09:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `percentage` double NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `admin_id`, `name`, `percentage`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Vat', 10, 'Active', '2025-05-23 06:43:31', '2025-05-23 06:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `admin_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'L', 'Active', '2025-05-23 06:48:27', '2025-05-23 06:48:27'),
(3, 1, 'G', 'Active', '2025-05-23 06:48:58', '2025-05-23 06:48:58'),
(5, 1, 'PECS', 'Active', '2025-05-26 04:27:52', '2025-05-26 04:27:52'),
(14, 1, 'KG', 'Active', '2025-06-02 09:38:16', '2025-06-02 09:38:16'),
(17, 1, 's', 'Active', '2026-01-21 23:43:58', '2026-01-21 23:43:58'),
(18, 1, 'sdd', 'Active', '2026-01-21 23:44:57', '2026-01-21 23:44:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_phone_unique` (`phone`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`),
  ADD KEY `brands_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_phone_unique` (`phone`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_details_order_id_foreign` (`order_id`),
  ADD KEY `order_details_product_id_foreign` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_admin_id_foreign` (`admin_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_sub_category_id_foreign` (`sub_category_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`),
  ADD KEY `products_tax_id_foreign` (`tax_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_categories_admin_id_foreign` (`admin_id`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `taxes_name_unique` (`name`),
  ADD KEY `taxes_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`),
  ADD KEY `units_admin_id_foreign` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brands`
--
ALTER TABLE `brands`
  ADD CONSTRAINT `brands_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `taxes_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
