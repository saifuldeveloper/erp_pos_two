-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 01, 2024 at 08:04 PM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sherazip_demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `initial_balance` double DEFAULT NULL,
  `total_balance` double NOT NULL,
  `note` text DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_no`, `name`, `initial_balance`, `total_balance`, `note`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '019912229', 'Cash In Hand', 15000, 15000, 'This is the default account.', 1, 1, '2023-02-05 07:12:15', '2024-09-29 11:47:05'),
(2, '002', 'Bank', 5000, 5000, NULL, NULL, 0, '2024-03-21 21:05:21', '2024-04-01 12:17:08'),
(3, '546464566465645', 'Bkash MArchent', 0, 0, NULL, NULL, 0, '2024-05-04 16:26:39', '2024-08-17 12:43:10'),
(4, '123456879', 'Bkash', 500, 500, NULL, NULL, 1, '2024-08-17 12:43:40', '2024-09-19 15:53:37'),
(5, '018574968584', 'Nagad', 0, 0, NULL, NULL, 1, '2024-09-19 15:54:16', '2024-09-19 15:54:16'),
(6, '258746589522', 'Bank', NULL, 0, NULL, NULL, 1, '2024-09-19 15:54:31', '2024-09-19 15:54:31'),
(7, '01671518383', 'kazi bkash', NULL, 0, NULL, NULL, 1, '2024-09-29 15:02:57', '2024-09-29 15:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `acc_adjustments`
--

CREATE TABLE `acc_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('deposit','withdrawal') NOT NULL,
  `amount` double NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acc_adjustments`
--

INSERT INTO `acc_adjustments` (`id`, `user_id`, `account_id`, `type`, `amount`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 'deposit', 1000000, NULL, '2024-09-25 19:03:06', '2024-09-25 19:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `adjustments`
--

CREATE TABLE `adjustments` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `total_qty` double NOT NULL,
  `item` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adjustments`
--

INSERT INTO `adjustments` (`id`, `reference_no`, `warehouse_id`, `document`, `total_qty`, `item`, `note`, `created_at`, `updated_at`) VALUES
(1, 'adr-20240407-030416', 1, NULL, 2, 1, NULL, '2024-04-07 03:04:16', '2024-04-07 03:04:16'),
(2, 'adr-20240902-010143', 1, NULL, 1000, 1, NULL, '2024-09-02 13:01:43', '2024-09-02 13:01:43'),
(3, 'adr-20240902-010320', 1, NULL, 110, 1, NULL, '2024-09-02 13:03:20', '2024-09-02 13:03:20'),
(4, 'adr-20240902-010340', 1, NULL, 1, 1, NULL, '2024-09-02 13:03:40', '2024-09-02 13:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `employee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `checkin` varchar(255) NOT NULL,
  `checkout` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `date`, `employee_id`, `user_id`, `checkin`, `checkout`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, '2024-04-24', 1, 1, '10:00am', '6:00am', 1, NULL, '2024-04-24 15:30:39', '2024-04-24 15:30:39'),
(2, '2024-04-23', 1, 1, '10:00am', '6:00am', 1, NULL, '2024-04-24 15:30:58', '2024-04-24 15:30:58'),
(7, '2024-05-01', 1, 1, '10:00am', '6:45am', 1, NULL, '2024-05-01 23:58:40', '2024-05-01 23:58:40'),
(8, '2024-05-28', 1, 1, '10:00am', '6:00am', 1, NULL, '2024-05-28 17:03:02', '2024-05-28 17:03:02'),
(9, '2024-08-11', 1, 1, '10:00am', '6:00am', 1, NULL, '2024-08-11 04:17:30', '2024-08-11 04:17:30'),
(10, '2024-08-11', 3, 1, '10:00am', '6:00am', 1, NULL, '2024-08-11 04:17:55', '2024-08-11 04:17:55'),
(11, '2024-09-02', 5, 1, '10:00am', '6:00am', 1, NULL, '2024-09-02 14:34:49', '2024-09-02 14:34:49'),
(12, '2024-09-10', 1, 1, '10:00am', '6:00am', 1, NULL, '2024-09-10 20:15:44', '2024-09-10 20:15:44'),
(13, '2024-09-14', 2, 1, '10:00am', '6:00am', 1, NULL, '2024-09-14 18:23:04', '2024-09-14 18:23:04');

-- --------------------------------------------------------

--
-- Table structure for table `billers`
--

CREATE TABLE `billers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `billers`
--

INSERT INTO `billers` (`id`, `name`, `image`, `company_name`, `vat_number`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Billing from Super Admin', NULL, 'Sherazi POS', NULL, 'contact@sheraziit.com', '01819011229', 'House 20, Road 1, Sector 9, Uttara', 'Uttara', NULL, '1230', 'Bangladesh', 1, '2024-04-01 10:07:27', '2024-04-01 10:07:27'),
(2, 'Sales Man Rofik', NULL, 'Expert Event BD', NULL, 'sheraziit360@gmail.com', '01919011229', 'House 20, Road 01, Sector 9, Uttara,Dhaka', 'Uttaradit', NULL, '1230', 'Bangladesh', 1, '2024-05-12 18:28:56', '2024-05-12 18:28:56'),
(3, 'Kazi', NULL, 'xyz', NULL, 'captain@gmail.com', '01919011229', 'House 20, Road 01, Sector 9, Uttara,Dhaka', 'Uttaradit', NULL, '1230', 'Bangladesh', 1, '2024-09-29 15:32:13', '2024-09-29 15:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `title`, `image`, `page_title`, `short_description`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Basmoti chal', 'demo_20240401100526.jpg', NULL, NULL, NULL, 1, '2024-04-01 10:05:26', '2024-04-01 10:05:26'),
(2, 'sozul', NULL, NULL, NULL, NULL, 1, '2024-04-23 10:49:33', '2024-09-12 00:09:44'),
(3, 'Samsung', 'demo_20240509121147.png', NULL, NULL, NULL, 1, '2024-04-23 10:55:55', '2024-05-09 00:11:47'),
(4, 'Livelynine', 'demo_20240519121115.jpg', NULL, NULL, NULL, 1, '2024-05-19 12:11:15', '2024-05-19 12:11:15'),
(5, 'Laxfo', 'demo_20240525100138.jpeg', NULL, NULL, NULL, 1, '2024-05-25 22:01:38', '2024-05-25 22:01:38'),
(6, 'Supperstar', 'demo_20240525100255.jpg', NULL, NULL, NULL, 1, '2024-05-25 22:02:15', '2024-05-25 22:02:55'),
(7, 'Walton', 'demo_20240525100332.png', NULL, NULL, NULL, 1, '2024-05-25 22:03:32', '2024-05-25 22:03:32'),
(8, 'Safty VTS', NULL, NULL, NULL, NULL, 1, '2024-06-05 12:00:11', '2024-06-05 12:00:11'),
(9, 'Nikki', NULL, NULL, NULL, NULL, 1, '2024-06-05 22:08:15', '2024-06-05 22:08:15'),
(10, 'Autonics', NULL, NULL, NULL, NULL, 1, '2024-06-10 14:42:19', '2024-06-10 14:42:19'),
(11, 'Fresh Miniket', NULL, NULL, NULL, NULL, 1, '2024-06-23 11:16:26', '2024-06-23 11:16:26'),
(12, 'Beximco Pharmaceuticals Ltd.', 'demo_20240706125744.png', NULL, NULL, NULL, 1, '2024-07-06 12:57:44', '2024-07-06 12:57:44'),
(13, 'Beximco Pharmaceuticals Ltd', 'demo_20240706125805.png', NULL, NULL, NULL, 0, '2024-07-06 12:58:05', '2024-07-06 12:59:03'),
(14, 'Beximco', NULL, NULL, NULL, NULL, 0, '2024-07-06 12:58:41', '2024-07-06 12:58:55'),
(15, 'Water', 'demo_20240902113020.jpg', NULL, NULL, NULL, 1, '2024-09-02 11:30:20', '2024-09-02 11:30:20'),
(16, 'rbc', NULL, NULL, NULL, NULL, 1, '2024-09-11 11:46:54', '2024-09-11 11:46:54'),
(17, 'easy', NULL, NULL, NULL, NULL, 1, '2024-09-14 19:15:18', '2024-09-14 19:15:18'),
(18, 'vibro shape', NULL, NULL, NULL, NULL, 1, '2024-09-25 13:01:23', '2024-09-25 13:01:23'),
(19, 'dolphin messager', NULL, NULL, NULL, NULL, 1, '2024-09-25 13:01:55', '2024-09-25 13:01:55'),
(20, 'curex edta', NULL, NULL, NULL, NULL, 1, '2024-09-29 12:44:41', '2024-09-29 12:44:41'),
(21, 'wellmed edta', NULL, NULL, NULL, NULL, 1, '2024-09-29 12:45:06', '2024-09-29 12:45:06'),
(22, 'qure edta', NULL, NULL, NULL, NULL, 1, '2024-09-29 12:45:30', '2024-09-29 12:45:30'),
(23, 'nmc edta', NULL, NULL, NULL, NULL, 1, '2024-09-29 12:46:07', '2024-09-29 12:46:07'),
(24, 'jita edta', NULL, NULL, NULL, NULL, 1, '2024-09-29 12:46:32', '2024-09-29 12:46:32'),
(25, 'Baby Cloth', 'demo_20240930021619.jpeg', NULL, NULL, NULL, 1, '2024-09-30 14:16:19', '2024-09-30 14:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `cash_registers`
--

CREATE TABLE `cash_registers` (
  `id` int(10) UNSIGNED NOT NULL,
  `cash_in_hand` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_registers`
--

INSERT INTO `cash_registers` (`id`, `cash_in_hand`, `user_id`, `warehouse_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 30000, 1, 1, 0, '2024-04-01 10:24:22', '2024-05-13 16:13:55'),
(2, 6, 1, 2, 1, '2024-05-09 00:26:43', '2024-05-09 00:26:43'),
(3, 3, 7, 1, 1, '2024-05-12 18:32:46', '2024-05-12 18:32:46'),
(4, 6, 1, 1, 1, '2024-05-15 12:55:25', '2024-05-15 12:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `parent_id`, `page_title`, `short_description`, `slug`, `icon`, `featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Chal', 'demo_20240401100402.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(2, 'demo', NULL, 2, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL),
(3, 'Oil', 'demo_20240407022108.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(4, 'Baby Shoes', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL),
(5, 'Boys', NULL, 4, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(6, 'Girls', NULL, 4, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(7, 'Keds', NULL, 5, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(8, 'Cendel', NULL, 5, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(9, 'A', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2024-05-22 14:50:09'),
(10, 'Electronics', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(11, 'Smart Phone', 'demo_20240509121109.png', 10, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL),
(12, 'Refrigerator', NULL, 10, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(13, 'Watch', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(14, 'Fan', NULL, 10, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(15, 'Groceries', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(16, 'Washing Powder', NULL, 15, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(17, 'Water Pump', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(18, 'Sarees', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(19, 'Shoes', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(20, 'Interior Paint', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(21, 'Tiles', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(22, 'Mamun Muhammad', 'demo_20240519045542.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(23, 'bf burner', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(24, 'demoerererer', 'demo_20240522031652.jpg', 22, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(25, '5w LED', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(26, 'Light', 'demo_20240525100942.jpg', NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL),
(27, 'Circit Bracker', 'demo_20240525101103.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(28, 'Monthly Package', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(29, 'Aluminum', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(30, 'Switch', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(31, 'Miniket Chal', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(32, 'MENS POLO', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(33, 'Analgesics', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(34, 'Tablet', 'demo_20240706010010.jfif', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(35, 'Samrtphone', 'demo_20240730022525.png', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(36, 'Service', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(37, 'Electrotonic', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(38, 'fish', 'demo_20240901110831.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(39, 'wather', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(40, 'water', 'demo_20240902111813.jpg', NULL, NULL, NULL, NULL, NULL, 0, 1, NULL, NULL),
(41, 'nebulajer', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(42, 'nebu', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(43, 'toys', 'demo_20240909023821.jpeg', 7, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(44, 'safe accu', NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(45, 'double head machine', NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(46, 'tanita650', NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(47, 'save nebulizar', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(48, 'tanita 880', NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(49, 'alp 2k', NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(50, 'rionet', NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(51, 'panjabhi', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(52, 'vibro shape messager', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(53, 'Baby Cloth', NULL, 7, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(54, 'digital print 3pc', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(55, 'wellmed weight scale', NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(56, 'gym ball', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(57, 'easy respiro mitar', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(58, 'body messager black', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(59, 'mini messager gun', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL),
(60, 'mediron nebulizar digital', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `page_title` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `products` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `minimum_amount` double DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `used` int(11) NOT NULL,
  `expired_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `amount`, `minimum_amount`, `quantity`, `used`, `expired_date`, `user_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sherazi 123', 'percentage', 10, NULL, 20, 0, '2024-09-30', 1, 1, '2024-09-09 15:31:09', '2024-09-09 15:31:09'),
(2, 'Ny8vNphZLa', 'percentage', 1000, NULL, 2, 0, '2024-09-29', 1, 0, '2024-09-29 13:29:21', '2024-09-29 13:29:40'),
(3, 'Kazi 210', 'percentage', 1000, NULL, 5, 0, '2024-09-29', 1, 1, '2024-09-29 13:30:09', '2024-09-29 13:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `phone_number`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hosain', '01819011229', 'House 20, Road 1, Sector 9, Uttara', 1, '2024-07-07 16:58:18', '2024-07-07 16:58:18'),
(2, 'alif', '01788729031', 'uttara dhaka', 1, '2024-09-01 14:33:20', '2024-09-01 14:33:20'),
(3, 'mosharaf vai', '1233556787', 'sonamgong', 1, '2024-09-15 12:09:50', '2024-09-15 12:09:50');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `symbol` varchar(2) DEFAULT NULL,
  `exchange_rate` double NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `exchange_rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'US Dollar', 'USD', NULL, 12, 0, '2020-11-01 00:22:58', '2024-03-21 20:56:10'),
(2, 'BDT', 'BDT', NULL, 1, 1, '2024-03-18 14:23:32', '2024-03-21 20:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `tax_no` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `points` double DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `expense` double DEFAULT NULL,
  `wishlist` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_group_id`, `user_id`, `name`, `company_name`, `email`, `phone_number`, `tax_no`, `address`, `city`, `state`, `postal_code`, `country`, `points`, `is_active`, `created_at`, `updated_at`, `deposit`, `expense`, `wishlist`) VALUES
(1, 1, NULL, 'Walking Customer', NULL, NULL, '0', NULL, 'Uttara', 'Dhaka', NULL, NULL, NULL, NULL, 1, '2024-04-01 11:12:17', '2024-04-24 15:28:05', 160, 160, NULL),
(2, 1, NULL, 'MD TORIKUL ISLAM', NULL, 'mahmudur76@gmail.com', '+8801738546755', NULL, '711/A, Road No 6, Shopnodhara Housing', 'Dhaka', NULL, NULL, NULL, NULL, 1, '2024-04-03 23:05:33', '2024-09-24 14:18:56', 4000, NULL, NULL),
(3, 1, NULL, 'Niloy Banikg', NULL, 'niloybanik0000@gmail.com', '01310223888', NULL, 'Sunamganj, Sylhet, Bangladesh', 'Sunamganj', NULL, NULL, NULL, NULL, 1, '2024-04-18 19:18:41', '2024-04-18 19:18:41', NULL, NULL, NULL),
(4, 1, NULL, 'Hosain', NULL, 'contact@sherazimart.com', '01819011229', NULL, 'House 20, Road 1, Sector 9, Uttara', 'Uttara', NULL, NULL, NULL, NULL, 1, '2024-04-22 20:13:55', '2024-04-22 20:13:55', NULL, NULL, NULL),
(5, 1, NULL, 'Rofik Mia', NULL, NULL, '01745555545', NULL, 'Uttara', 'Dhaka', NULL, NULL, NULL, NULL, 1, '2024-05-12 18:20:42', '2024-05-12 18:20:42', NULL, NULL, NULL),
(6, 1, NULL, 'Salam', NULL, NULL, '01919011228', NULL, 'House 20, Road 01, Sector 9, Uttara,Dhaka', 'Uttaradit', NULL, NULL, NULL, NULL, 1, '2024-05-19 11:52:37', '2024-05-19 11:52:37', NULL, NULL, NULL),
(7, 1, NULL, 'Hosain 22', NULL, 'contact@sherazimart.com', '01819011227', NULL, 'House 20, Road 1, Sector 9, Uttara', 'Uttara', NULL, NULL, NULL, NULL, 1, '2024-05-20 14:24:19', '2024-05-20 14:24:19', NULL, NULL, NULL),
(8, 1, NULL, 'Salma', NULL, NULL, '01474545415578', NULL, 'hhjhj', 'khh', NULL, NULL, NULL, NULL, 1, '2024-05-21 17:05:48', '2024-05-21 17:05:48', NULL, NULL, NULL),
(9, 1, NULL, 'Nil', NULL, 'niloybanik0000@gmail.com', '01310223887', NULL, 'Sunamganj, Sylhet, Bangladesh', 'Sunamganj', NULL, NULL, NULL, NULL, 1, '2024-05-23 11:28:12', '2024-05-23 11:28:12', NULL, NULL, NULL),
(10, 1, NULL, 'Harun Sahab', NULL, NULL, '051874734y324', NULL, 'dfgdgdfg', 'dfgdg', NULL, NULL, NULL, NULL, 1, '2024-05-25 22:37:12', '2024-05-25 22:37:12', NULL, NULL, NULL),
(11, 1, NULL, 'Hasan Mia', NULL, NULL, '65464646523', NULL, 'House 20, Road 01, Sector 9, Uttara,Dhaka', 'Uttaradit', NULL, NULL, NULL, NULL, 1, '2024-05-25 22:47:10', '2024-05-25 22:47:10', NULL, NULL, NULL),
(12, 1, NULL, 'Rebekah Ortizerew', NULL, NULL, '29231124662', NULL, 'Sunt inventore volup', 'Nam et magna aut at', NULL, NULL, NULL, NULL, 1, '2024-05-28 16:59:00', '2024-05-28 16:59:00', NULL, NULL, NULL),
(13, 2, NULL, 'Abu Samsul(User ID)(Monthly Fee)', 'Device Number: 345353524343', NULL, '01785292561', 'IEMI Number: 23542424234234', 'Sector 18, Uttara, Dhaka', 'Dhaka', 'Object name:', NULL, NULL, NULL, 1, '2024-06-05 12:12:08', '2024-06-05 12:12:08', NULL, NULL, NULL),
(14, 1, NULL, 'Hosain87686', NULL, 'cont8789act@sherazimart.com', '01819011298', NULL, 'House 20, Road 1, Sector 9, Uttara2', 'Uttara2', NULL, NULL, NULL, NULL, 1, '2024-06-05 22:24:15', '2024-06-05 22:24:15', NULL, NULL, NULL),
(15, 1, NULL, 'Ruku', NULL, 'ruku@gmail.com', '01887058961', NULL, 'Mirpur 2', 'Dhaka', NULL, NULL, NULL, NULL, 1, '2024-06-10 11:17:22', '2024-06-10 11:17:22', NULL, NULL, NULL),
(16, 1, NULL, 'Rukunujjaman', NULL, NULL, '01834555007', NULL, 'Mirpur', 'Dhaka', NULL, NULL, NULL, NULL, 1, '2024-06-10 14:58:46', '2024-06-10 14:58:46', NULL, NULL, NULL),
(17, 1, NULL, 'Hosain', NULL, NULL, '01819011221', NULL, 'House 20, Road 1, Sector 9, Uttara', 'Uttara', 'Dhaka', '12345678', 'Bangladesh', NULL, 1, '2024-06-23 11:47:06', '2024-06-23 11:47:06', NULL, NULL, NULL),
(18, 1, NULL, 'Arif Showel', NULL, NULL, '01823030230', NULL, '183 taltola, Dhaka', 'dhaka', NULL, NULL, NULL, NULL, 1, '2024-07-02 20:01:32', '2024-07-02 20:01:32', NULL, NULL, NULL),
(19, 1, NULL, 'Anis Mia', NULL, NULL, '017584257', NULL, 'House #20, Road #01, Sector #09, Uttara', 'Dhaka, Bangladesh', NULL, NULL, NULL, NULL, 1, '2024-08-28 20:14:18', '2024-08-28 20:14:18', NULL, NULL, NULL),
(20, 1, NULL, 'alom', NULL, NULL, '01312345678', NULL, 'najim masterv er bari,kewa srp,gazipur', 'gsazipur', NULL, NULL, NULL, NULL, 1, '2024-08-29 00:39:37', '2024-08-29 00:58:46', 11000, NULL, NULL),
(21, 1, NULL, 'Aliai Ho', NULL, NULL, '01475745574', NULL, 'uttara', 'dhakja', NULL, NULL, NULL, NULL, 1, '2024-09-01 11:55:28', '2024-09-01 11:55:28', NULL, NULL, NULL),
(22, 1, NULL, 'alif hossen', NULL, 'sahadt132@gmail.com', '01788729031', NULL, 'uttara', 'dhaka', NULL, NULL, NULL, NULL, 1, '2024-09-01 12:30:22', '2024-09-01 12:30:22', NULL, NULL, NULL),
(23, 1, NULL, 'dfg', NULL, NULL, '01819011657', NULL, 'House 20, Road 1, Sector 9, Uttara', 'Uttara', NULL, NULL, NULL, NULL, 1, '2024-09-06 15:26:09', '2024-09-06 15:26:09', NULL, NULL, NULL),
(24, 1, NULL, 'Sakil', NULL, NULL, '01742518455', NULL, 'বেরাইদেরচালা,শ্রীপুর,গাজীপুর', 'গাজীপুর', NULL, NULL, NULL, NULL, 1, '2024-09-07 10:56:53', '2024-09-07 10:56:53', NULL, NULL, NULL),
(25, 1, NULL, 'shawon', NULL, NULL, '01770921384', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-08 10:41:26', '2024-09-08 10:41:26', NULL, NULL, NULL),
(26, 1, NULL, 'Hosain mia', NULL, NULL, '0152752522', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-08 13:16:37', '2024-09-08 13:16:37', NULL, NULL, NULL),
(27, 1, NULL, 'new customer', NULL, NULL, '01712345678', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-08 16:08:51', '2024-09-08 16:08:51', NULL, NULL, NULL),
(28, 1, NULL, 'Rohim', NULL, NULL, '12345769780', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-09 13:59:50', '2024-09-09 13:59:50', NULL, NULL, NULL),
(29, 1, NULL, 'mahfuz ahemad', NULL, 'mahfuz@gmail.com', '01620200329', NULL, 'uttara dhaka', 'dhaka', NULL, NULL, NULL, NULL, 1, '2024-09-09 15:20:33', '2024-09-09 15:20:33', NULL, NULL, NULL),
(30, 1, NULL, 'mosharaf', NULL, NULL, '1233556787', NULL, 'smg', 'dhaka', NULL, NULL, NULL, NULL, 1, '2024-09-11 12:14:36', '2024-09-11 12:14:36', NULL, NULL, NULL),
(31, 1, NULL, 'Sep Customer', NULL, NULL, '04156456456', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-16 12:15:36', '2024-09-16 12:15:36', NULL, NULL, NULL),
(32, 1, NULL, 'Vaisakh R S', NULL, NULL, '9526289230', NULL, 'TVM', 'Thiruvananthapuram', NULL, NULL, NULL, NULL, 1, '2024-09-18 16:15:29', '2024-09-18 16:15:29', NULL, NULL, NULL),
(33, 1, NULL, 'MD Saiyul', NULL, NULL, '0147524556254', NULL, 'hjkighk', 'hjkhjk', NULL, NULL, NULL, NULL, 1, '2024-09-28 12:38:46', '2024-09-28 12:38:46', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_groups`
--

CREATE TABLE `customer_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `percentage` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_groups`
--

INSERT INTO `customer_groups` (`id`, `name`, `percentage`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'General Customers', '0', 1, '2024-04-01 11:11:36', '2024-04-01 11:11:36'),
(2, 'Safety VTS', '0', 1, '2024-06-05 12:06:44', '2024-06-05 12:06:44'),
(3, 'Daily Customer', '0', 1, '2024-09-30 14:17:56', '2024-09-30 14:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

CREATE TABLE `custom_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `belongs_to` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `default_value` text DEFAULT NULL,
  `option_value` text DEFAULT NULL,
  `grid_value` int(11) NOT NULL,
  `is_table` tinyint(1) NOT NULL,
  `is_invoice` tinyint(1) NOT NULL,
  `is_required` tinyint(1) NOT NULL,
  `is_admin` tinyint(1) NOT NULL,
  `is_disable` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `courier_id` int(11) DEFAULT NULL,
  `address` text NOT NULL,
  `delivered_by` varchar(255) DEFAULT NULL,
  `recieved_by` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`id`, `reference_no`, `sale_id`, `user_id`, `courier_id`, `address`, `delivered_by`, `recieved_by`, `file`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dr-20240509-124941', 29, 1, NULL, 'Uttara Dhaka', NULL, NULL, NULL, NULL, '3', '2024-05-09 00:50:01', '2024-05-09 00:50:01'),
(2, 'dr-20240610-112107', 62, 1, NULL, 'Mirpur 2 Dhaka', 'fghjggjh', 'gthhgt', NULL, NULL, '3', '2024-06-10 11:21:23', '2024-06-10 15:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sale Department', 1, '2024-04-03 23:09:19', '2024-04-24 15:28:55'),
(2, 'Customer Support', 1, '2024-07-30 14:23:19', '2024-07-30 14:23:19'),
(3, 'Support Engineer', 1, '2024-09-29 15:07:26', '2024-09-29 15:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `amount`, `customer_id`, `user_id`, `note`, `created_at`, `updated_at`) VALUES
(2, 160, 1, 1, NULL, '2024-04-24 15:28:05', '2024-04-24 15:28:05'),
(3, 6000, 20, 1, NULL, '2024-08-29 00:54:23', '2024-08-29 00:54:23'),
(4, 5000, 20, 1, '14/09/254', '2024-08-29 00:58:46', '2024-08-29 00:58:46'),
(5, 4000, 2, 1, NULL, '2024-09-24 14:18:56', '2024-09-24 14:18:56');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `applicable_for` varchar(255) NOT NULL,
  `product_list` longtext DEFAULT NULL,
  `valid_from` date NOT NULL,
  `valid_till` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `minimum_qty` double NOT NULL,
  `maximum_qty` double NOT NULL,
  `days` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `name`, `applicable_for`, `product_list`, `valid_from`, `valid_till`, `type`, `value`, `minimum_qty`, `maximum_qty`, `days`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'wather', 'All', NULL, '2024-09-02', '2025-11-04', 'percentage', 10, 10, 20, 'Wed', 1, '2024-09-02 16:34:35', '2024-09-02 16:34:35');

-- --------------------------------------------------------

--
-- Table structure for table `discount_plans`
--

CREATE TABLE `discount_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_plans`
--

INSERT INTO `discount_plans` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'water', 1, '2024-09-02 16:30:38', '2024-09-02 16:30:38'),
(2, 'fgh', 1, '2024-09-28 13:06:40', '2024-09-28 13:06:40');

-- --------------------------------------------------------

--
-- Table structure for table `discount_plan_customers`
--

CREATE TABLE `discount_plan_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount_plan_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_plan_customers`
--

INSERT INTO `discount_plan_customers` (`id`, `discount_plan_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '2024-09-02 16:30:38', '2024-09-02 16:30:38'),
(2, 2, 7, '2024-09-28 13:06:40', '2024-09-28 13:06:40'),
(3, 2, 10, '2024-09-28 13:06:40', '2024-09-28 13:06:40');

-- --------------------------------------------------------

--
-- Table structure for table `discount_plan_discounts`
--

CREATE TABLE `discount_plan_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` int(11) NOT NULL,
  `discount_plan_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discount_plan_discounts`
--

INSERT INTO `discount_plan_discounts` (`id`, `discount_id`, `discount_plan_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-09-02 16:34:35', '2024-09-02 16:34:35');

-- --------------------------------------------------------

--
-- Table structure for table `dso_alerts`
--

CREATE TABLE `dso_alerts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_info` longtext NOT NULL,
  `number_of_products` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ecommerce_settings`
--

CREATE TABLE `ecommerce_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_title` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `store_phone` varchar(255) DEFAULT NULL,
  `store_email` varchar(255) DEFAULT NULL,
  `store_address` varchar(255) DEFAULT NULL,
  `home_page` bigint(20) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `contact_form_email` varchar(255) DEFAULT NULL,
  `free_shipping_from` double DEFAULT NULL,
  `flat_rate_shipping` double DEFAULT NULL,
  `checkout_pages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`checkout_pages`)),
  `gift_card` tinyint(4) NOT NULL DEFAULT 0,
  `custom_css` varchar(255) DEFAULT NULL,
  `custom_js` varchar(255) DEFAULT NULL,
  `chat_code` varchar(255) DEFAULT NULL,
  `analytics_code` varchar(255) DEFAULT NULL,
  `fb_pixel_code` varchar(255) DEFAULT NULL,
  `sell_without_stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `staff_id` varchar(191) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `phone_number`, `department_id`, `user_id`, `staff_id`, `image`, `address`, `city`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Ismail Hosain', 'contact@sheraziit.com', '01819011229', 1, NULL, '78979879', NULL, 'House 20, Road 1, Sector 9, Uttara', 'Uttara', 'Bangladesh', 1, '2024-04-24 15:29:35', '2024-04-24 15:30:07'),
(2, 'Sales Man Rofik', 'sheraziit360@gmail.com', '01919011234', 1, 7, '45', NULL, 'House 20, Road 01, Sector 9, Uttara,Dhaka', 'Uttaradit', 'Bangladesh', 1, '2024-05-12 18:32:04', '2024-05-12 18:32:04'),
(3, 'rasel', 'akterh83@gmail.com', '01834555007', 1, NULL, '09', NULL, 'Mirpur', 'Dhaka', NULL, 1, '2024-06-10 15:29:22', '2024-06-10 15:29:22'),
(4, 'Rukunujjaman', 'rukunujjaman2019@gmail.com', '01887058961', 2, NULL, '6541', NULL, 'Purbo Rajar Bajar ,Farmgate Dhaka', 'Dhaka, Bangladesh', 'Bangladesh', 1, '2024-07-30 14:24:12', '2024-07-30 14:24:12'),
(5, 'rohim mia', 'rohim123@gmail.com', '01788729031', 1, 10, '234567453', NULL, 'uttara dhaka', 'dhaka', 'Bangladesh', 1, '2024-09-02 14:34:29', '2024-09-02 14:34:29'),
(6, 'Kazi', 'captain@gmail.com', '01919011229', 3, 13, '2112', NULL, 'House 20, Road 01, Sector 9, Uttara,Dhaka', 'Uttaradit', 'Bangladesh', 1, '2024-09-29 15:09:03', '2024-09-29 15:09:03');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `expense_category_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cash_register_id` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `reference_no`, `expense_category_id`, `warehouse_id`, `account_id`, `user_id`, `cash_register_id`, `amount`, `note`, `created_at`, `updated_at`) VALUES
(1, 'er-20240610-030705', 2, 1, 1, 1, 4, 500, NULL, '2024-06-10 00:00:00', '2024-06-10 15:07:05'),
(2, 'er-20240623-120445', 1, 1, 1, 1, 4, 20000, NULL, '2024-06-23 00:00:00', '2024-06-23 12:04:45'),
(3, 'er-20240630-043928', 2, 1, 1, 1, 4, 500, NULL, '2024-06-30 00:00:00', '2024-06-30 16:39:28'),
(4, 'er-20240828-075947', 3, 2, 1, 1, 2, 500, NULL, '2024-08-28 19:59:47', '2024-08-28 19:59:47'),
(5, 'er-20240902-051321', 4, 1, 1, 1, 4, 1500, NULL, '2024-09-02 00:00:00', '2024-09-02 17:13:21'),
(6, 'er-20240914-095624', 1, 2, 1, 1, 2, 77, NULL, '2024-09-14 21:56:24', '2024-09-14 21:56:24'),
(7, 'er-20240917-121244', 5, 2, 1, 1, 2, 300, 'From Office to Paltan, up-down by Bike', '2024-09-17 00:00:00', '2024-09-17 12:12:44'),
(8, 'er-20240918-041713', 2, 1, 1, 1, 4, 10000, NULL, '2024-09-18 00:00:00', '2024-09-18 16:17:13');

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `code`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '44273101', 'emoploye salary', 0, '2024-06-10 15:06:30', '2024-09-29 17:38:17'),
(2, '09331189', 'Nasta', 1, '2024-06-10 15:06:43', '2024-06-10 15:06:43'),
(3, '81722999', 'Electcity Bill', 1, '2024-08-28 19:59:25', '2024-08-28 19:59:25'),
(4, '06940230', 'mahafuj', 1, '2024-09-02 17:12:27', '2024-09-02 17:12:27'),
(5, '89652929', 'Conveyance', 1, '2024-09-17 12:11:04', '2024-09-17 12:11:04');

-- --------------------------------------------------------

--
-- Table structure for table `external_services`
--

CREATE TABLE `external_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `details` longtext NOT NULL,
  `active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `order` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

CREATE TABLE `faq_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `is_rtl` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `currency` varchar(255) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `subscription_type` varchar(255) DEFAULT NULL,
  `staff_access` varchar(255) NOT NULL,
  `without_stock` varchar(255) NOT NULL DEFAULT 'no',
  `date_format` varchar(255) NOT NULL,
  `developed_by` varchar(255) DEFAULT NULL,
  `invoice_format` varchar(255) DEFAULT NULL,
  `decimal` int(11) DEFAULT 2,
  `state` int(11) DEFAULT NULL,
  `theme` varchar(255) NOT NULL,
  `modules` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `currency_position` varchar(255) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_zatca` tinyint(1) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `vat_registration_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_title`, `site_logo`, `is_rtl`, `created_at`, `updated_at`, `currency`, `package_id`, `subscription_type`, `staff_access`, `without_stock`, `date_format`, `developed_by`, `invoice_format`, `decimal`, `state`, `theme`, `modules`, `currency_position`, `expiry_date`, `is_zatca`, `company_name`, `vat_registration_number`) VALUES
(1, 'Sherazi POS', '20240929120056.png', 0, '2018-07-06 06:13:11', '2024-09-29 12:00:56', '2', 1, 'yearly', 'own', 'no', 'd/m/Y', 'Sherazi IT', 'standard', 2, 1, 'default.css', NULL, 'prefix', '2025-12-30', 0, 'Sherazi Mart', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` int(10) UNSIGNED NOT NULL,
  `card_no` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `expense` double NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gift_cards`
--

INSERT INTO `gift_cards` (`id`, `card_no`, `amount`, `expense`, `customer_id`, `user_id`, `expired_date`, `created_by`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '5520', 100, 0, 29, NULL, '2024-10-30', 1, 1, '2024-09-09 15:30:05', '2024-09-09 15:30:05'),
(2, '8509081443175017', 40, 0, NULL, 5, '2024-09-25', 1, 1, '2024-09-25 20:28:57', '2024-09-25 20:28:57'),
(3, '6733184719690924', 1200, 0, 5, NULL, '2024-09-26', 1, 1, '2024-09-26 12:19:52', '2024-09-26 12:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `gift_card_recharges`
--

CREATE TABLE `gift_card_recharges` (
  `id` int(10) UNSIGNED NOT NULL,
  `gift_card_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `note` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `user_id`, `from_date`, `to_date`, `note`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-08-11', '2024-08-13', NULL, 1, '2024-08-11 04:26:01', '2024-08-11 04:26:01');

-- --------------------------------------------------------

--
-- Table structure for table `hrm_settings`
--

CREATE TABLE `hrm_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `checkin` varchar(255) NOT NULL,
  `checkout` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_settings`
--

INSERT INTO `hrm_settings` (`id`, `checkin`, `checkout`, `created_at`, `updated_at`) VALUES
(1, '10:00am', '6:00am', '2024-03-19 15:41:09', '2024-04-24 15:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(50) NOT NULL,
  `link` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `widget_title` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mail_settings`
--

CREATE TABLE `mail_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `from_address` varchar(255) NOT NULL,
  `from_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `encryption` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `target` varchar(255) DEFAULT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_02_17_060412_create_categories_table', 1),
(4, '2018_02_20_035727_create_brands_table', 1),
(5, '2018_02_25_100635_create_suppliers_table', 1),
(6, '2018_02_27_101619_create_warehouse_table', 1),
(7, '2018_03_03_040448_create_units_table', 1),
(8, '2018_03_04_041317_create_taxes_table', 1),
(9, '2018_03_10_061915_create_customer_groups_table', 1),
(10, '2018_03_10_090534_create_customers_table', 1),
(11, '2018_03_11_095547_create_billers_table', 1),
(12, '2018_04_05_054401_create_products_table', 1),
(13, '2018_04_06_133606_create_purchases_table', 1),
(14, '2018_04_06_154600_create_product_purchases_table', 1),
(15, '2018_04_06_154915_create_product_warhouse_table', 1),
(16, '2018_04_10_085927_create_sales_table', 1),
(17, '2018_04_10_090133_create_product_sales_table', 1),
(18, '2018_04_10_090254_create_payments_table', 1),
(19, '2018_04_10_090341_create_payment_with_cheque_table', 1),
(20, '2018_04_10_090509_create_payment_with_credit_card_table', 1),
(21, '2018_04_13_121436_create_quotation_table', 1),
(22, '2018_04_13_122324_create_product_quotation_table', 1),
(23, '2018_04_14_121802_create_transfers_table', 1),
(24, '2018_04_14_121913_create_product_transfer_table', 1),
(25, '2018_05_13_082847_add_payment_id_and_change_sale_id_to_payments_table', 1),
(26, '2018_05_13_090906_change_customer_id_to_payment_with_credit_card_table', 1),
(27, '2018_05_20_054532_create_adjustments_table', 1),
(28, '2018_05_20_054859_create_product_adjustments_table', 1),
(29, '2018_05_21_163419_create_returns_table', 1),
(30, '2018_05_21_163443_create_product_returns_table', 1),
(31, '2018_06_02_050905_create_roles_table', 1),
(32, '2018_06_02_073430_add_columns_to_users_table', 1),
(33, '2018_06_03_053738_create_permission_tables', 1),
(34, '2018_06_21_063736_create_pos_setting_table', 1),
(35, '2018_06_21_094155_add_user_id_to_sales_table', 1),
(36, '2018_06_21_101529_add_user_id_to_purchases_table', 1),
(37, '2018_06_21_103512_add_user_id_to_transfers_table', 1),
(38, '2018_06_23_061058_add_user_id_to_quotations_table', 1),
(39, '2018_06_23_082427_add_is_deleted_to_users_table', 1),
(40, '2018_06_25_043308_change_email_to_users_table', 1),
(41, '2018_07_06_115449_create_general_settings_table', 1),
(42, '2018_07_08_043944_create_languages_table', 1),
(43, '2018_07_11_102144_add_user_id_to_returns_table', 1),
(44, '2018_07_11_102334_add_user_id_to_payments_table', 1),
(45, '2018_07_22_130541_add_digital_to_products_table', 1),
(46, '2018_07_24_154250_create_deliveries_table', 1),
(47, '2018_08_16_053336_create_expense_categories_table', 1),
(48, '2018_08_17_115415_create_expenses_table', 1),
(49, '2018_08_18_050418_create_gift_cards_table', 1),
(50, '2018_08_19_063119_create_payment_with_gift_card_table', 1),
(51, '2018_08_25_042333_create_gift_card_recharges_table', 1),
(52, '2018_08_25_101354_add_deposit_expense_to_customers_table', 1),
(53, '2018_08_26_043801_create_deposits_table', 1),
(54, '2018_09_02_044042_add_keybord_active_to_pos_setting_table', 1),
(55, '2018_09_09_092713_create_payment_with_paypal_table', 1),
(56, '2018_09_10_051254_add_currency_to_general_settings_table', 1),
(57, '2018_10_22_084118_add_biller_and_store_id_to_users_table', 1),
(58, '2018_10_26_034927_create_coupons_table', 1),
(59, '2018_10_27_090857_add_coupon_to_sales_table', 1),
(60, '2018_11_07_070155_add_currency_position_to_general_settings_table', 1),
(61, '2018_11_19_094650_add_combo_to_products_table', 1),
(62, '2018_12_09_043712_create_accounts_table', 1),
(63, '2018_12_17_112253_add_is_default_to_accounts_table', 1),
(64, '2018_12_19_103941_add_account_id_to_payments_table', 1),
(65, '2018_12_20_065900_add_account_id_to_expenses_table', 1),
(66, '2018_12_20_082753_add_account_id_to_returns_table', 1),
(67, '2018_12_26_064330_create_return_purchases_table', 1),
(68, '2018_12_26_144708_create_purchase_product_return_table', 1),
(69, '2018_12_27_110018_create_departments_table', 1),
(70, '2018_12_30_054844_create_employees_table', 1),
(71, '2018_12_31_125210_create_payrolls_table', 1),
(72, '2018_12_31_150446_add_department_id_to_employees_table', 1),
(73, '2019_01_01_062708_add_user_id_to_expenses_table', 1),
(74, '2019_01_02_075644_create_hrm_settings_table', 1),
(75, '2019_01_02_090334_create_attendances_table', 1),
(76, '2019_01_27_160956_add_three_columns_to_general_settings_table', 1),
(77, '2019_02_15_183303_create_stock_counts_table', 1),
(78, '2019_02_17_101604_add_is_adjusted_to_stock_counts_table', 1),
(79, '2019_04_13_101707_add_tax_no_to_customers_table', 1),
(80, '2019_08_19_000000_create_failed_jobs_table', 1),
(81, '2019_10_14_111455_create_holidays_table', 1),
(82, '2019_11_13_145619_add_is_variant_to_products_table', 1),
(83, '2019_11_13_150206_create_product_variants_table', 1),
(84, '2019_11_13_153828_create_variants_table', 1),
(85, '2019_11_25_134041_add_qty_to_product_variants_table', 1),
(86, '2019_11_25_134922_add_variant_id_to_product_purchases_table', 1),
(87, '2019_11_25_145341_add_variant_id_to_product_warehouse_table', 1),
(88, '2019_11_29_182201_add_variant_id_to_product_sales_table', 1),
(89, '2019_12_04_121311_add_variant_id_to_product_quotation_table', 1),
(90, '2019_12_05_123802_add_variant_id_to_product_transfer_table', 1),
(91, '2019_12_08_114954_add_variant_id_to_product_returns_table', 1),
(92, '2019_12_08_203146_add_variant_id_to_purchase_product_return_table', 1),
(93, '2020_02_28_103340_create_money_transfers_table', 1),
(94, '2020_07_01_193151_add_image_to_categories_table', 1),
(95, '2020_09_26_130426_add_user_id_to_deliveries_table', 1),
(96, '2020_10_11_125457_create_cash_registers_table', 1),
(97, '2020_10_13_155019_add_cash_register_id_to_sales_table', 1),
(98, '2020_10_13_172624_add_cash_register_id_to_returns_table', 1),
(99, '2020_10_17_212338_add_cash_register_id_to_payments_table', 1),
(100, '2020_10_18_124200_add_cash_register_id_to_expenses_table', 1),
(101, '2020_10_21_121632_add_developed_by_to_general_settings_table', 1),
(102, '2020_10_30_135557_create_notifications_table', 1),
(103, '2020_11_01_044954_create_currencies_table', 1),
(104, '2020_11_01_140736_add_price_to_product_warehouse_table', 1),
(105, '2020_11_02_050633_add_is_diff_price_to_products_table', 1),
(106, '2020_11_09_055222_add_user_id_to_customers_table', 1),
(107, '2020_11_17_054806_add_invoice_format_to_general_settings_table', 1),
(108, '2021_02_10_074859_add_variant_id_to_product_adjustments_table', 1),
(109, '2021_03_07_093606_create_product_batches_table', 1),
(110, '2021_03_07_093759_add_product_batch_id_to_product_warehouse_table', 1),
(111, '2021_03_07_093900_add_product_batch_id_to_product_purchases_table', 1),
(112, '2021_03_11_132603_add_product_batch_id_to_product_sales_table', 1),
(113, '2021_03_25_125421_add_is_batch_to_products_table', 1),
(114, '2021_05_19_120127_add_product_batch_id_to_product_returns_table', 1),
(115, '2021_05_22_105611_add_product_batch_id_to_purchase_product_return_table', 1),
(116, '2021_05_23_124848_add_product_batch_id_to_product_transfer_table', 1),
(117, '2021_05_26_153106_add_product_batch_id_to_product_quotation_table', 1),
(118, '2021_06_08_213007_create_reward_point_settings_table', 1),
(119, '2021_06_16_104155_add_points_to_customers_table', 1),
(120, '2021_06_17_101057_add_used_points_to_payments_table', 1),
(121, '2021_07_06_132716_add_variant_list_to_products_table', 1),
(122, '2021_09_27_161141_add_is_imei_to_products_table', 1),
(123, '2021_09_28_170052_add_imei_number_to_product_warehouse_table', 1),
(124, '2021_09_28_170126_add_imei_number_to_product_purchases_table', 1),
(125, '2021_10_03_170652_add_imei_number_to_product_sales_table', 1),
(126, '2021_10_10_145214_add_imei_number_to_product_returns_table', 1),
(127, '2021_10_11_104504_add_imei_number_to_product_transfer_table', 1),
(128, '2021_10_12_160107_add_imei_number_to_purchase_product_return_table', 1),
(129, '2021_10_12_205146_add_is_rtl_to_general_settings_table', 1),
(130, '2022_01_13_191242_create_discount_plans_table', 1),
(131, '2022_01_14_174318_create_discount_plan_customers_table', 1),
(132, '2022_01_14_202439_create_discounts_table', 1),
(133, '2022_01_16_153506_create_discount_plan_discounts_table', 1),
(134, '2022_02_05_174210_add_order_discount_type_and_value_to_sales_table', 1),
(135, '2022_05_26_195506_add_daily_sale_objective_to_products_table', 1),
(136, '2022_05_28_104209_create_dso_alerts_table', 1),
(137, '2022_06_01_112100_add_is_embeded_to_products_table', 1),
(138, '2022_06_14_130505_add_sale_id_to_returns_table', 1),
(139, '2022_07_19_115504_add_variant_data_to_products_table', 1),
(140, '2022_07_25_194300_add_additional_cost_to_product_variants_table', 1),
(141, '2022_09_04_195610_add_purchase_id_to_return_purchases_table', 1),
(142, '2022_09_05_213845_create_sliders_table', 1),
(143, '2022_09_05_214402_create_pages_table', 1),
(144, '2022_09_05_235844_add_multiple_column_to_categories_table', 1),
(145, '2022_09_06_215257_add_symbol_to_currencies_table', 1),
(146, '2022_09_13_194813_create_links_table', 1),
(147, '2022_09_14_151339_add_widget_title_to_links_table', 1),
(148, '2022_09_14_151904_add_multiple_column_to_products_table', 1),
(149, '2023_01_18_125040_alter_table_general_settings', 1),
(150, '2023_01_18_133701_alter_table_pos_setting', 1),
(151, '2023_01_25_145309_add_expiry_date_to_general_settings_table', 1),
(152, '2023_02_05_132001_add_change_to_payments_table', 1),
(153, '2023_02_23_125656_alter_table_sales', 1),
(154, '2023_02_26_124100_add_package_id_to_general_settings_table', 1),
(155, '2023_03_04_120325_create_custom_fields_table', 1),
(156, '2023_03_14_174658_add_subscription_type_to_general_setting_table', 1),
(157, '2023_03_22_174352_add_currency_id_and_exchange_rate_to_returns_table', 1),
(158, '2023_03_27_114320_add_currency_id_and_exchange_rate_to_purchases_table', 1),
(159, '2023_03_27_132747_add_currency_id_and_exchange_rate_to_return_purchases_table', 1),
(160, '2023_04_25_150236_create_mail_settings_table', 1),
(161, '2023_05_13_125424_add_zatca_to_general_settings_table', 1),
(162, '2023_05_28_155540_create_tables_table', 1),
(163, '2023_05_29_115039_add_is_table_to_pos_setting_table', 1),
(164, '2023_05_29_115301_add_table_id_to_sales_table', 1),
(165, '2023_05_31_165049_add_queue_no_to_sales_table', 1),
(166, '2023_07_23_160254_create_couriers_table', 1),
(167, '2023_07_23_174343_add_courier_id_to_deliveries_table', 1),
(168, '2023_08_12_124016_add_staff_id_to_employees_table', 1),
(169, '2023_08_14_142608_add_is_active_to_currencies_table', 1),
(170, '2023_08_24_130203_change_columns_to_attendances_table', 1),
(171, '2023_09_10_134503_add_without_stock_to_general_settings_table', 1),
(172, '2023_09_26_211542_add_modules_to_general_settings_table', 1),
(173, '2023_10_05_190729_create_ecommerce_settings_table', 1),
(174, '2023_10_05_201640_create_social_links_table', 1),
(175, '2023_10_08_211633_crete_menus_table', 1),
(176, '2023_10_08_211806_crete_menu_items_table', 1),
(177, '2023_10_12_101855_crete_widgets_table', 1),
(178, '2023_10_15_124306_add_return_qty_to_product_sales_table', 1),
(179, '2023_10_19_211003_crete_page_widgets_table', 1),
(180, '2023_11_09_110943_crete_collections_table', 1),
(181, '2023_11_09_113224_crete_customer_addresses_table', 1),
(182, '2023_11_09_113237_crete_faqs_table', 1),
(183, '2023_11_09_114154_add_multiple_columns_to_brands_table', 1),
(184, '2023_11_09_125124_crete_faq_categories_table', 1),
(185, '2023_11_14_155545_crete_newsletter_table', 1),
(186, '2023_12_01_110636_add_multiple_columns_to_sales_table', 1),
(187, '2023_12_03_235606_crete_external_services_table', 1),
(188, '2024_01_27_185652_add_multiple_columns_to_ecommerce_settings_table', 1),
(189, '2024_02_03_183124_add_multiple_columns_to_products_table', 1),
(190, '2024_02_04_131826_add_unit_cost_to_product_adjustments_table', 1),
(191, '2024_02_06_133230_edi_sales_table', 1),
(192, '2024_02_13_173126_change_modules_to_general_settings_table', 1),
(193, '2024_02_12_235611_change_page_widgets_table', 2),
(194, '2024_02_18_175556_add_columns_to_customers_table', 2),
(195, '2024_03_03_231218_add_gift_card_to_ecommerce_settings_table', 2),
(196, '2024_09_18_104118_create_acc_adjustments_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `money_transfers`
--

CREATE TABLE `money_transfers` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `money_transfers`
--

INSERT INTO `money_transfers` (`id`, `reference_no`, `from_account_id`, `to_account_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'mtr-20240817-124539', 1, 4, 500, '2024-08-17 12:45:39', '2024-08-17 12:45:39'),
(2, 'mtr-20240918-041406', 1, 4, 10, '2024-09-18 16:14:06', '2024-09-18 16:14:06'),
(3, 'mtr-20240929-030317', 1, 7, 1000, '2024-09-29 15:03:17', '2024-09-29 15:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('c095254b-134a-4c02-b11e-eed1cf81c175', 'App\\Notifications\\SendNotification', 'App\\Models\\User', 5, '{\"sender_id\":\"1\",\"receiver_id\":\"5\",\"reminder_date\":\"2024-09-01\",\"document_name\":null,\"message\":\"where are now....?\"}', NULL, '2024-09-01 15:29:31', '2024-09-01 15:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `template` varchar(255) NOT NULL DEFAULT 'Default',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_widgets`
--

CREATE TABLE `page_widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `page_id` varchar(255) NOT NULL,
  `order` varchar(255) NOT NULL,
  `product_category_title` varchar(255) DEFAULT NULL,
  `product_category_id` varchar(255) DEFAULT NULL,
  `product_category_type` varchar(255) DEFAULT NULL,
  `product_category_slider_loop` varchar(255) DEFAULT NULL,
  `product_category_slider_autoplay` varchar(255) DEFAULT NULL,
  `product_category_limit` varchar(255) DEFAULT NULL,
  `tab_product_collection_id` varchar(255) DEFAULT NULL,
  `tab_product_collection_type` varchar(255) DEFAULT NULL,
  `tab_product_collection_slider_loop` varchar(255) DEFAULT NULL,
  `tab_product_collection_slider_autoplay` varchar(255) DEFAULT NULL,
  `tab_product_collection_limit` varchar(255) DEFAULT NULL,
  `product_collection_title` varchar(255) DEFAULT NULL,
  `product_collection_id` varchar(255) DEFAULT NULL,
  `product_collection_type` varchar(255) DEFAULT NULL,
  `product_collection_slider_loop` varchar(255) DEFAULT NULL,
  `product_collection_slider_autoplay` varchar(255) DEFAULT NULL,
  `product_collection_limit` varchar(255) DEFAULT NULL,
  `category_slider_title` varchar(255) DEFAULT NULL,
  `category_slider_loop` varchar(255) DEFAULT NULL,
  `category_slider_autoplay` varchar(255) DEFAULT NULL,
  `category_slider_ids` varchar(255) DEFAULT NULL,
  `brand_slider_title` varchar(255) DEFAULT NULL,
  `brand_slider_loop` varchar(255) DEFAULT NULL,
  `brand_slider_autoplay` varchar(255) DEFAULT NULL,
  `brand_slider_ids` varchar(255) DEFAULT NULL,
  `3c_banner_link1` varchar(255) DEFAULT NULL,
  `3c_banner_image1` varchar(255) DEFAULT NULL,
  `3c_banner_link2` varchar(255) DEFAULT NULL,
  `3c_banner_image2` varchar(255) DEFAULT NULL,
  `3c_banner_link3` varchar(255) DEFAULT NULL,
  `3c_banner_image3` varchar(255) DEFAULT NULL,
  `2c_banner_link1` varchar(255) DEFAULT NULL,
  `2c_banner_image1` varchar(255) DEFAULT NULL,
  `2c_banner_link2` varchar(255) DEFAULT NULL,
  `2c_banner_image2` varchar(255) DEFAULT NULL,
  `1c_banner_link1` varchar(255) DEFAULT NULL,
  `1c_banner_image1` varchar(255) DEFAULT NULL,
  `text_title` varchar(255) DEFAULT NULL,
  `text_content` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `cash_register_id` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `payment_reference` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `used_points` double DEFAULT NULL,
  `change` double DEFAULT NULL,
  `paying_method` varchar(255) NOT NULL,
  `payment_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `purchase_id`, `sale_id`, `cash_register_id`, `account_id`, `payment_reference`, `user_id`, `amount`, `used_points`, `change`, `paying_method`, `payment_note`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 0, 'ppr-20240401-101127', 1, 650000, NULL, 0, 'Cash', NULL, '2024-04-01 10:11:27', '2024-04-01 10:11:27'),
(2, NULL, 1, 1, 1, 'spr-20240403-014248', 1, 130, NULL, 0, 'Credit Card', 'sdf', '2024-04-03 01:42:48', '2024-04-03 01:42:48'),
(3, NULL, 2, 1, 1, 'spr-20240403-014354', 1, 80, NULL, 0, 'Cash', NULL, '2024-04-03 01:43:54', '2024-04-03 01:43:54'),
(4, NULL, 3, 1, 1, 'spr-20240403-014508', 1, 80, NULL, 0, 'Deposit', NULL, '2024-04-03 01:45:08', '2024-04-03 01:45:08'),
(6, NULL, 5, 1, 1, 'spr-20240404-010301', 1, 86, NULL, 0, 'Cash', NULL, '2024-04-04 01:03:01', '2024-04-04 01:03:01'),
(7, NULL, 6, 1, 1, 'spr-20240404-010330', 1, 80, NULL, 0, 'Credit Card', NULL, '2024-04-04 01:03:30', '2024-04-04 01:03:30'),
(8, NULL, 7, 1, 1, 'spr-20240404-010923', 1, 80, NULL, 0, 'Cheque', NULL, '2024-04-04 01:09:23', '2024-04-04 01:09:23'),
(9, NULL, 8, 1, 1, 'spr-20240404-010929', 1, 80, NULL, 0, 'Cash', NULL, '2024-04-04 01:09:29', '2024-04-04 01:09:29'),
(10, NULL, 7, 1, 1, 'spr-20240404-011211', 1, 0, NULL, 500, 'Cash', NULL, '2024-04-04 01:12:11', '2024-04-04 01:12:11'),
(11, NULL, 8, 1, 1, 'spr-20240404-011322', 1, 10, NULL, 70, 'Cash', NULL, '2024-04-04 01:13:22', '2024-04-04 01:13:22'),
(12, NULL, 8, 1, 1, 'spr-20240404-011350', 1, 50, NULL, 20, 'Cash', NULL, '2024-04-04 01:13:50', '2024-04-04 01:13:50'),
(13, 2, NULL, NULL, 0, 'ppr-20240407-022227', 1, 1000, NULL, 0, 'Cash', NULL, '2024-04-07 02:22:27', '2024-04-07 02:22:27'),
(14, NULL, 9, 1, 1, 'spr-20240407-093231', 1, 110, NULL, 10, 'Cash', NULL, '2024-04-07 21:32:31', '2024-04-07 21:32:31'),
(15, NULL, 10, 1, 1, 'spr-20240408-010059', 1, 50, NULL, 30, 'Cash', NULL, '2024-04-08 01:00:59', '2024-04-08 01:00:59'),
(16, 3, NULL, NULL, 1, 'ppr-20240418-071647', 1, 1950, NULL, 0, 'Cash', NULL, '2024-04-18 19:16:47', '2024-04-18 19:16:47'),
(17, NULL, 11, 1, 1, 'spr-20240418-071919', 1, 1000, NULL, 1000, 'Cash', NULL, '2024-04-18 19:19:19', '2024-04-18 19:19:19'),
(18, NULL, 12, 1, 1, 'spr-20240420-041227', 1, 200, NULL, 0, 'Cash', NULL, '2024-04-20 16:12:27', '2024-04-20 16:12:27'),
(19, NULL, 13, 1, 1, 'spr-20240420-055621', 1, 320, NULL, 0, 'Credit Card', 'jgik', '2024-04-20 17:56:21', '2024-04-20 17:56:21'),
(20, 4, NULL, NULL, 1, 'ppr-20240421-060512', 1, 5000, NULL, 0, 'Cash', NULL, '2024-04-21 18:05:12', '2024-04-21 18:05:12'),
(21, NULL, 14, 1, 1, 'spr-20240421-060640', 1, 240, NULL, 260, 'Cash', NULL, '2024-04-21 18:06:40', '2024-04-21 18:06:40'),
(22, NULL, 15, 1, 1, 'spr-20240421-100112', 1, 200, NULL, 0, 'Cash', NULL, '2024-04-21 22:01:12', '2024-04-21 22:01:12'),
(23, 5, NULL, NULL, 1, 'ppr-20240422-081156', 1, 1000, NULL, 0, 'Cash', NULL, '2024-04-22 20:11:56', '2024-04-22 20:11:56'),
(24, 5, NULL, NULL, 1, 'ppr-20240422-081208', 1, 4000, NULL, 0, 'Cash', NULL, '2024-04-22 20:12:08', '2024-04-22 20:12:08'),
(25, NULL, 16, 1, 1, 'spr-20240422-081333', 1, 600, NULL, 0, 'Cash', NULL, '2024-04-22 20:13:33', '2024-04-22 20:13:33'),
(26, NULL, 17, 1, 1, 'spr-20240422-081542', 1, 1300, NULL, 200, 'Cash', NULL, '2024-04-22 20:15:42', '2024-04-22 20:15:42'),
(27, NULL, 18, 1, 1, 'spr-20240424-031834', 1, 80, NULL, 0, 'Cash', NULL, '2024-04-24 15:18:34', '2024-04-24 15:18:34'),
(28, NULL, 19, 1, 1, 'spr-20240424-032619', 1, 50, NULL, 0, 'Cash', NULL, '2024-04-24 15:26:19', '2024-04-24 15:26:19'),
(29, NULL, 20, 1, 1, 'spr-20240424-032751', 1, 80, NULL, 0, 'Deposit', NULL, '2024-04-24 15:27:51', '2024-04-24 15:27:51'),
(30, NULL, 21, 1, 1, 'spr-20240428-030111', 1, 200, NULL, 0, 'Cash', NULL, '2024-04-28 15:01:11', '2024-04-28 15:01:11'),
(31, 10, NULL, NULL, 1, 'ppr-20240501-055105', 1, 9000, NULL, 0, 'Cash', NULL, '2024-05-01 17:51:05', '2024-05-01 17:51:05'),
(32, NULL, 22, 1, 1, 'spr-20240501-055429', 1, 5075, NULL, 0, 'Cash', NULL, '2024-05-01 17:54:29', '2024-05-01 17:54:29'),
(33, NULL, 23, 1, 1, 'spr-20240501-115442', 1, 80, NULL, 0, 'Cash', 'sdf', '2024-05-01 23:54:42', '2024-05-01 23:54:42'),
(34, 11, NULL, NULL, 1, 'ppr-20240504-042304', 1, 1000, NULL, 0, 'Cash', NULL, '2024-05-04 16:23:04', '2024-05-04 16:23:04'),
(35, 11, NULL, NULL, 1, 'ppr-20240504-042329', 1, 600, NULL, 0, 'Cash', NULL, '2024-05-04 16:23:29', '2024-05-04 16:23:29'),
(36, NULL, 24, 1, 1, 'spr-20240504-042844', 1, 945, NULL, 0, 'Cash', 'Bkash', '2024-05-04 16:28:44', '2024-05-04 16:28:44'),
(37, NULL, 25, 1, 1, 'spr-20240506-073001', 1, 120, NULL, 380, 'Cash', NULL, '2024-05-06 19:30:01', '2024-05-06 19:30:01'),
(38, NULL, 26, 1, 1, 'spr-20240506-111134', 1, 160, NULL, 0, 'Cash', NULL, '2024-05-06 23:11:34', '2024-05-06 23:11:34'),
(39, NULL, 17, 1, 1, 'spr-20240507-125036', 1, -650, NULL, 0, 'Cash', 'ghgh', '2024-05-07 00:50:36', '2024-05-07 00:50:36'),
(40, NULL, 27, 1, 1, 'spr-20240507-084446', 1, 80, NULL, 0, 'Cash', NULL, '2024-05-07 20:44:46', '2024-05-07 20:44:46'),
(41, 12, NULL, NULL, 0, 'ppr-20240509-121540', 1, 3000000, NULL, 0, 'Cash', NULL, '2024-05-09 00:15:40', '2024-05-09 00:15:40'),
(42, 13, NULL, NULL, 0, 'ppr-20240509-121540', 1, 1500000, NULL, 0, 'Cash', NULL, '2024-05-09 00:15:40', '2024-05-09 00:15:40'),
(43, NULL, 28, 1, 1, 'spr-20240509-122120', 1, 10000, NULL, 0, 'Cash', NULL, '2024-05-09 00:21:20', '2024-05-09 00:21:20'),
(44, NULL, 29, 2, 1, 'spr-20240509-122720', 1, 4000, NULL, 0, 'Cash', NULL, '2024-05-09 00:27:20', '2024-05-09 00:27:20'),
(45, NULL, 29, 2, 1, 'spr-20240509-124417', 1, 30000, NULL, 0, 'Cash', NULL, '2024-05-09 00:44:17', '2024-05-09 00:44:17'),
(46, NULL, 30, 1, 1, 'spr-20240509-054912', 1, 80, NULL, 0, 'Cash', NULL, '2024-05-09 17:49:12', '2024-05-09 17:49:12'),
(47, NULL, 31, 1, 1, 'spr-20240509-055045', 1, 50, NULL, 0, 'Cash', NULL, '2024-05-09 17:50:45', '2024-05-09 17:50:45'),
(48, 14, NULL, NULL, 1, 'ppr-20240512-061526', 1, 5000, NULL, 0, 'Cash', NULL, '2024-05-12 18:15:26', '2024-05-12 18:15:26'),
(50, NULL, 33, 3, 1, 'spr-20240512-063253', 7, 80, NULL, 0, 'Cash', NULL, '2024-05-12 18:32:53', '2024-05-12 18:32:53'),
(51, NULL, 34, 1, 1, 'spr-20240512-064036', 1, 600, NULL, 0, 'Cash', NULL, '2024-05-12 18:40:36', '2024-05-12 18:40:36'),
(54, 16, NULL, NULL, 1, 'ppr-20240519-115044', 1, 10000, NULL, 0, 'Cash', NULL, '2024-05-19 11:50:44', '2024-05-19 11:50:44'),
(55, 16, NULL, NULL, 1, 'ppr-20240519-115100', 1, 5000, NULL, 0, 'Cash', NULL, '2024-05-19 11:51:00', '2024-05-19 11:51:00'),
(56, NULL, 37, 4, 1, 'spr-20240519-115310', 1, 13400, NULL, 0, 'Cash', NULL, '2024-05-19 11:53:10', '2024-05-19 11:53:10'),
(57, NULL, 40, 4, 1, 'spr-20240519-011700', 1, 825, NULL, 0, 'Cash', NULL, '2024-05-19 13:17:00', '2024-05-19 13:17:00'),
(58, 19, NULL, NULL, 1, 'ppr-20240520-022219', 1, 5000, NULL, 0, 'Cash', NULL, '2024-05-20 14:22:19', '2024-05-20 14:22:19'),
(59, 19, NULL, NULL, 1, 'ppr-20240520-022237', 1, 1000, NULL, 0, 'Cash', NULL, '2024-05-20 14:22:37', '2024-05-20 14:22:37'),
(60, NULL, 41, 4, 1, 'spr-20240520-022556', 1, 500, NULL, 0, 'Cash', NULL, '2024-05-20 14:25:56', '2024-05-20 14:25:56'),
(61, 20, NULL, NULL, 1, 'ppr-20240521-050301', 1, 1000, NULL, 0, 'Cash', NULL, '2024-05-21 17:03:01', '2024-05-21 17:03:01'),
(62, 20, NULL, NULL, 1, 'ppr-20240521-050315', 1, 149100, NULL, 0, 'Cash', NULL, '2024-05-21 17:03:15', '2024-05-21 17:03:15'),
(63, NULL, 42, 4, 1, 'spr-20240521-050559', 1, 500, NULL, 0, 'Cash', NULL, '2024-05-21 17:05:59', '2024-05-21 17:05:59'),
(64, NULL, 43, 4, 1, 'spr-20240521-050758', 1, 500, NULL, 0, 'Cash', NULL, '2024-05-21 17:07:58', '2024-05-21 17:07:58'),
(65, 21, NULL, NULL, 1, 'ppr-20240523-112707', 1, 400, NULL, 0, 'Cash', NULL, '2024-05-23 11:27:07', '2024-05-23 11:27:07'),
(66, 21, NULL, NULL, 1, 'ppr-20240523-112718', 1, 2000, NULL, 0, 'Cash', NULL, '2024-05-23 11:27:18', '2024-05-23 11:27:18'),
(67, NULL, 44, 4, 1, 'spr-20240523-112818', 1, 200, NULL, 0, 'Cash', NULL, '2024-05-23 11:28:18', '2024-05-23 11:28:18'),
(68, NULL, 45, 4, 1, 'spr-20240524-074817', 1, 480, NULL, 0, 'Cash', NULL, '2024-05-24 19:48:17', '2024-05-24 19:48:17'),
(69, NULL, 46, 4, 1, 'spr-20240525-114512', 1, 900, NULL, 0, 'Cash', '100', '2024-05-25 11:45:12', '2024-05-25 11:45:12'),
(70, NULL, 47, 4, 1, 'spr-20240525-114640', 1, 150, NULL, 10, 'Cash', 'FF', '2024-05-25 11:46:40', '2024-05-25 11:46:40'),
(71, 22, NULL, NULL, 1, 'ppr-20240525-103309', 1, 40000, NULL, 0, 'Cash', NULL, '2024-05-25 22:33:09', '2024-05-25 22:33:09'),
(72, 22, NULL, NULL, 1, 'ppr-20240525-103410', 1, 21500, NULL, 0, 'Cash', NULL, '2024-05-25 22:34:10', '2024-05-25 22:34:10'),
(73, NULL, 48, 4, 1, 'spr-20240525-103742', 1, 1020, NULL, 0, 'Cash', NULL, '2024-05-25 22:37:42', '2024-05-25 22:37:42'),
(74, NULL, 49, 4, 1, 'spr-20240525-104114', 1, 5000, NULL, 0, 'Cash', NULL, '2024-05-25 22:41:14', '2024-05-25 22:41:14'),
(75, NULL, 50, 4, 1, 'spr-20240525-104927', 1, 80000, NULL, 0, 'Cash', NULL, '2024-05-25 22:49:27', '2024-05-25 22:49:27'),
(76, NULL, 50, 4, 1, 'spr-20240525-105136', 1, 6000, NULL, 0, 'Cash', NULL, '2024-05-25 22:51:36', '2024-05-25 22:51:36'),
(77, NULL, 50, 4, 1, 'spr-20240525-105228', 1, 460, NULL, 0, 'Cash', NULL, '2024-05-25 22:52:28', '2024-05-25 22:52:28'),
(78, 23, NULL, NULL, 1, 'ppr-20240528-045600', 1, 2500, NULL, 0, 'Cash', NULL, '2024-05-28 16:56:00', '2024-05-28 16:56:00'),
(79, 23, NULL, NULL, 1, 'ppr-20240528-045646', 1, 4700, NULL, 300, 'Cash', NULL, '2024-05-28 16:56:46', '2024-05-28 16:56:46'),
(80, NULL, 51, 4, 1, 'spr-20240528-045939', 1, 20000, NULL, 0, 'Cash', NULL, '2024-05-28 16:59:39', '2024-05-28 16:59:39'),
(81, NULL, 51, 4, 1, 'spr-20240528-050152', 1, 20000, NULL, 0, 'Cash', NULL, '2024-05-28 17:01:52', '2024-05-28 17:01:52'),
(82, NULL, 52, 4, 1, 'spr-20240528-052629', 1, 20000, NULL, 0, 'Cash', '3 months EMI Payment', '2024-05-28 17:26:29', '2024-05-28 17:26:29'),
(83, NULL, 53, 4, 1, 'spr-20240531-121520', 1, 80, NULL, 0, 'Cash', NULL, '2024-05-31 00:15:20', '2024-05-31 00:15:20'),
(84, NULL, 54, 4, 1, 'spr-20240531-121639', 1, 80, NULL, 0, 'Cash', 'Payment Note', '2024-05-31 00:16:39', '2024-05-31 00:16:39'),
(85, 26, NULL, NULL, 1, 'ppr-20240601-064421', 1, 500, NULL, 0, 'Cash', NULL, '2024-06-01 18:44:21', '2024-06-01 18:44:21'),
(86, 26, NULL, NULL, 1, 'ppr-20240601-064519', 1, 440, NULL, 0, 'Cash', NULL, '2024-06-01 18:45:19', '2024-06-01 18:45:19'),
(87, NULL, 55, 4, 1, 'spr-20240601-064703', 1, 500, NULL, 0, 'Cash', NULL, '2024-06-01 18:47:03', '2024-06-01 18:47:03'),
(88, NULL, 55, 4, 1, 'spr-20240601-064848', 1, 500, NULL, 0, 'Cash', NULL, '2024-06-01 18:48:48', '2024-06-01 18:48:48'),
(89, NULL, 56, 4, 1, 'spr-20240604-022048', 1, 80, NULL, 0, 'Cash', NULL, '2024-06-04 14:20:48', '2024-06-04 14:20:48'),
(90, NULL, 57, 4, 1, 'spr-20240605-113130', 1, 80, NULL, 0, 'Cash', NULL, '2024-06-05 11:31:30', '2024-06-05 11:31:30'),
(91, NULL, 58, 4, 1, 'spr-20240605-121340', 1, 300, NULL, 0, 'Cash', NULL, '2024-06-05 12:13:40', '2024-06-05 12:13:40'),
(92, 27, NULL, NULL, 1, 'ppr-20240605-102204', 1, 5000, NULL, 0, 'Cash', NULL, '2024-06-05 22:22:04', '2024-06-05 22:22:04'),
(93, 27, NULL, NULL, 1, 'ppr-20240605-102231', 1, 2000, NULL, 0, 'Cash', NULL, '2024-06-05 22:22:31', '2024-06-05 22:22:31'),
(94, NULL, 59, 4, 1, 'spr-20240605-102800', 1, 3023.28, NULL, 0, 'Cash', NULL, '2024-06-05 22:28:00', '2024-06-05 22:28:00'),
(95, 27, NULL, NULL, 1, 'ppr-20240610-103850', 1, 4000, NULL, 0, 'Cash', NULL, '2024-06-10 10:38:50', '2024-06-10 10:38:50'),
(96, NULL, 61, 4, 1, 'spr-20240610-110621', 1, 120, NULL, 0, 'Cheque', NULL, '2024-06-10 11:06:21', '2024-06-10 11:06:21'),
(97, 28, NULL, NULL, 1, 'ppr-20240610-025203', 1, 48000, NULL, 0, 'Cash', NULL, '2024-06-10 14:52:03', '2024-06-10 14:52:03'),
(98, NULL, 63, 4, 1, 'spr-20240610-030228', 1, 5625, NULL, 0, 'Cash', NULL, '2024-06-10 15:02:28', '2024-06-10 15:02:28'),
(99, NULL, 62, 4, 1, 'spr-20240610-061928', 1, 450, NULL, 0, 'Cash', NULL, '2024-06-10 18:19:28', '2024-06-10 18:19:28'),
(100, NULL, 62, 4, 1, 'spr-20240610-061943', 1, 40, NULL, 0, 'Cash', NULL, '2024-06-10 18:19:43', '2024-06-10 18:19:43'),
(101, NULL, 65, 4, 1, 'spr-20240610-062809', 1, 760, NULL, 0, 'Cash', NULL, '2024-06-10 18:28:09', '2024-06-10 18:28:09'),
(102, 32, NULL, NULL, 1, 'ppr-20240623-113718', 1, 600, NULL, 200, 'Cash', NULL, '2024-06-23 11:37:18', '2024-06-23 11:37:18'),
(103, 32, NULL, NULL, 1, 'ppr-20240623-113758', 1, 200, NULL, 0, 'Cash', NULL, '2024-06-23 11:37:58', '2024-06-23 11:37:58'),
(104, NULL, 66, 4, 1, 'spr-20240623-115526', 1, 1150, NULL, 0, 'Cash', NULL, '2024-06-23 11:55:26', '2024-06-23 11:55:26'),
(105, NULL, 67, 4, 1, 'spr-20240630-044402', 1, 800, NULL, 0, 'Cash', 'dis', '2024-06-30 16:44:02', '2024-06-30 16:44:02'),
(106, NULL, 67, 4, 1, 'spr-20240630-044617', 1, 0, NULL, 80, 'Cash', 'dis', '2024-06-30 16:46:17', '2024-06-30 16:46:17'),
(107, 33, NULL, NULL, 1, 'ppr-20240701-104327', 1, 1000, NULL, 0, 'Cash', NULL, '2024-07-01 10:43:27', '2024-07-01 10:43:27'),
(108, 33, NULL, NULL, 1, 'ppr-20240701-104351', 1, 910, NULL, 0, 'Cash', NULL, '2024-07-01 10:43:51', '2024-07-01 10:43:51'),
(109, NULL, 68, 4, 1, 'spr-20240701-104749', 1, 500, NULL, 0, 'Cash', NULL, '2024-07-01 10:47:49', '2024-07-01 10:47:49'),
(110, NULL, 69, 4, 1, 'spr-20240701-104905', 1, 80, NULL, 0, 'Cash', NULL, '2024-07-01 10:49:05', '2024-07-01 10:49:05'),
(111, NULL, 70, 4, 1, 'spr-20240701-040159', 1, 1110, NULL, 0, 'Cash', NULL, '2024-07-01 16:01:59', '2024-07-01 16:01:59'),
(112, NULL, 71, 4, 1, 'spr-20240702-080855', 1, 5000, NULL, 0, 'Cash', NULL, '2024-07-02 20:08:55', '2024-07-02 20:08:55'),
(113, NULL, 71, 4, 1, 'spr-20240702-081025', 1, 4800, NULL, 0, 'Cash', NULL, '2024-07-02 20:10:25', '2024-07-02 20:10:25'),
(114, 34, NULL, NULL, 1, 'ppr-20240702-082630', 1, 50000, NULL, 0, 'Cash', NULL, '2024-07-02 20:26:30', '2024-07-02 20:26:30'),
(115, 34, NULL, NULL, 1, 'ppr-20240702-082653', 1, 231500, NULL, 0, 'Cash', NULL, '2024-07-02 20:26:53', '2024-07-02 20:26:53'),
(116, 33, NULL, NULL, 1, 'ppr-20240703-031821', 1, 500, NULL, 0, 'Cash', NULL, '2024-07-03 15:18:21', '2024-07-03 15:18:21'),
(117, NULL, 72, 4, 1, 'spr-20240704-095959', 1, 68030, NULL, 0, 'Cash', NULL, '2024-07-04 09:59:59', '2024-07-04 09:59:59'),
(118, NULL, 73, 4, 1, 'spr-20240704-100029', 1, 80, NULL, 0, 'Cash', NULL, '2024-07-04 10:00:29', '2024-07-04 10:00:29'),
(119, NULL, 74, 4, 1, 'spr-20240704-100051', 1, 110, NULL, 0, 'Cash', NULL, '2024-07-04 10:00:51', '2024-07-04 10:00:51'),
(120, NULL, 75, 4, 1, 'spr-20240704-095123', 1, 80, NULL, 20, 'Cash', NULL, '2024-07-04 21:51:23', '2024-07-04 21:51:23'),
(121, NULL, 76, 4, 1, 'spr-20240705-040518', 1, 34130, NULL, 0, 'Cash', NULL, '2024-07-05 16:05:18', '2024-07-05 16:05:18'),
(122, NULL, 77, 4, 1, 'spr-20240705-041736', 1, 34000, NULL, 0, 'Cash', NULL, '2024-07-05 16:17:36', '2024-07-05 16:17:36'),
(123, NULL, 78, 4, 1, 'spr-20240706-104951', 1, 34020, NULL, 0, 'Cash', NULL, '2024-07-06 10:49:51', '2024-07-06 10:49:51'),
(124, 36, NULL, NULL, 1, 'ppr-20240706-045439', 1, 1600, NULL, 0, 'Cash', NULL, '2024-07-06 16:54:39', '2024-07-06 16:54:39'),
(125, NULL, 79, 4, 1, 'spr-20240706-045544', 1, 12, NULL, 0, 'Cash', NULL, '2024-07-06 16:55:44', '2024-07-06 16:55:44'),
(126, NULL, 80, 4, 1, 'spr-20240706-045745', 1, 12, NULL, 0, 'Cash', NULL, '2024-07-06 16:57:45', '2024-07-06 16:57:45'),
(127, NULL, 81, 4, 1, 'spr-20240706-050240', 1, 4177, NULL, 0, 'Cash', NULL, '2024-07-06 17:02:40', '2024-07-06 17:02:40'),
(128, NULL, 82, 4, 1, 'spr-20240706-050316', 1, 3, NULL, 0, 'Cash', NULL, '2024-07-06 17:03:16', '2024-07-06 17:03:16'),
(129, NULL, 83, 4, 1, 'spr-20240706-050344', 1, 6, NULL, 0, 'Cash', NULL, '2024-07-06 17:03:44', '2024-07-06 17:03:44'),
(130, NULL, 85, 4, 1, 'spr-20240711-102213', 1, 580, NULL, 0, 'Cash', NULL, '2024-07-11 10:22:13', '2024-07-11 10:22:13'),
(131, NULL, 86, 4, 1, 'spr-20240712-023549', 1, 80, NULL, 0, 'Cash', NULL, '2024-07-12 14:35:49', '2024-07-12 14:35:49'),
(132, NULL, 87, 4, 1, 'spr-20240712-023631', 1, 50, NULL, 0, 'Cash', NULL, '2024-07-12 14:36:31', '2024-07-12 14:36:31'),
(133, 40, NULL, NULL, 1, 'ppr-20240713-062804', 1, 5000, NULL, 0, 'Cash', NULL, '2024-07-13 18:28:04', '2024-07-13 18:28:04'),
(134, 40, NULL, NULL, 1, 'ppr-20240713-062837', 1, 600, NULL, 0, 'Cash', NULL, '2024-07-13 18:28:37', '2024-07-13 18:28:37'),
(135, NULL, 88, 4, 1, 'spr-20240713-063226', 1, 20000, NULL, 0, 'Cash', NULL, '2024-07-13 18:32:26', '2024-07-13 18:32:26'),
(136, NULL, 89, 4, 1, 'spr-20240715-021015', 1, 34500, NULL, 0, 'Cash', NULL, '2024-07-15 14:10:15', '2024-07-15 14:10:15'),
(137, 7, NULL, 4, 1, 'ppr-20240715-094747', 1, 912000, NULL, 0, 'Cash', NULL, '2024-07-15 21:47:47', '2024-07-15 21:47:47'),
(138, 41, NULL, 4, 1, 'ppr-20240715-095828', 1, 6500, NULL, 0, 'Cash', NULL, '2024-07-15 21:58:28', '2024-07-15 21:58:28'),
(139, 42, NULL, 4, 1, 'ppr-20240715-095828', 1, 1500, NULL, 0, 'Cash', NULL, '2024-07-15 21:58:28', '2024-07-15 21:58:28'),
(140, NULL, 90, 4, 1, 'spr-20240730-043819', 1, 75373, NULL, 0, 'Cash', NULL, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(141, NULL, 91, 4, 1, 'spr-20240730-044400', 1, 36660, NULL, 0, 'Cash', NULL, '2024-07-30 16:44:00', '2024-07-30 16:44:00'),
(142, NULL, 92, 4, 1, 'spr-20240730-044837', 1, 750, NULL, 0, 'Cash', NULL, '2024-07-30 16:48:37', '2024-07-30 16:48:37'),
(143, NULL, 93, 4, 1, 'spr-20240730-045009', 1, 37620, NULL, 0, 'Cash', NULL, '2024-07-30 16:50:09', '2024-07-30 16:50:09'),
(144, NULL, 94, 4, 1, 'spr-20240809-025002', 1, 34200, NULL, 516800, 'Cash', NULL, '2024-08-09 14:50:02', '2024-08-09 14:50:02'),
(145, NULL, 95, 4, 1, 'spr-20240811-043131', 1, 120, NULL, 0, 'Cash', NULL, '2024-08-11 04:31:31', '2024-08-11 04:31:31'),
(146, NULL, 96, 4, 1, 'spr-20240816-120727', 1, 1000, NULL, 0, 'Cash', NULL, '2024-08-16 00:07:27', '2024-08-16 00:07:27'),
(147, NULL, 97, 4, 1, 'spr-20240822-113912', 1, 80, NULL, 0, 'Cash', 'Payment Note', '2024-08-22 11:39:12', '2024-08-22 11:39:12'),
(148, NULL, 98, 4, 1, 'spr-20240826-094125', 1, 80, NULL, 0, 'Cash', NULL, '2024-08-26 21:41:25', '2024-08-26 21:41:25'),
(149, NULL, 99, 4, 1, 'spr-20240827-011453', 1, 200, NULL, 0, 'Cash', NULL, '2024-08-27 13:14:53', '2024-08-27 13:14:53'),
(150, NULL, 100, 4, 1, 'spr-20240828-081529', 1, 30, NULL, 0, 'Cash', NULL, '2024-08-28 20:15:29', '2024-08-28 20:15:29'),
(151, NULL, 100, 4, 1, 'spr-20240828-081647', 1, 30, NULL, 0, 'Cash', NULL, '2024-08-28 20:16:47', '2024-08-28 20:16:47'),
(152, 44, NULL, NULL, 4, 'ppr-20240829-123327', 1, 250000, NULL, 0, 'Cash', NULL, '2024-08-29 00:33:27', '2024-09-05 12:52:56'),
(153, NULL, 101, 4, 1, 'spr-20240829-123624', 1, 15000, NULL, 0, 'Cash', NULL, '2024-08-29 00:36:24', '2024-08-29 00:36:24'),
(154, NULL, 102, 4, 1, 'spr-20240829-124127', 1, 10500, NULL, 0, 'Cash', NULL, '2024-08-29 00:41:27', '2024-08-29 00:41:27'),
(155, NULL, 103, 4, 1, 'spr-20240829-124932', 1, 3000, NULL, 8000, 'Cash', 'emi 3', '2024-08-29 00:49:32', '2024-08-29 00:49:32'),
(156, NULL, 100, 4, 1, 'spr-20240829-112912', 1, 10, NULL, 0, 'Cash', NULL, '2024-08-29 11:29:12', '2024-08-29 11:29:12'),
(157, NULL, 100, 4, 1, 'spr-20240829-112930', 1, 10, NULL, 0, 'Cash', NULL, '2024-08-29 11:29:30', '2024-08-29 11:29:30'),
(158, NULL, 104, 4, 1, 'spr-20240829-114933', 1, 20000, NULL, 0, 'Cash', NULL, '2024-08-29 11:49:33', '2024-08-29 11:49:33'),
(159, NULL, 104, 4, 1, 'spr-20240829-115019', 1, 10000, NULL, 0, 'Cash', NULL, '2024-08-29 11:50:19', '2024-08-29 11:50:19'),
(160, NULL, 105, 4, 1, 'spr-20240901-114659', 1, 31600, NULL, 0, 'Cash', NULL, '2024-09-01 11:46:59', '2024-09-01 11:46:59'),
(161, NULL, 106, 4, 1, 'spr-20240901-115902', 1, 500, NULL, 0, 'Cash', NULL, '2024-09-01 11:59:02', '2024-09-01 11:59:02'),
(162, NULL, 107, 4, 1, 'spr-20240901-123726', 1, 20000, NULL, 0, 'Cash', NULL, '2024-09-01 12:37:26', '2024-09-01 12:37:26'),
(163, NULL, 108, 4, 1, 'spr-20240902-125234', 1, 160, NULL, 0, 'Cash', NULL, '2024-09-02 12:52:34', '2024-09-02 12:52:34'),
(164, NULL, 109, 4, 1, 'spr-20240902-125400', 1, 260, NULL, 0, 'Cash', NULL, '2024-09-02 12:54:00', '2024-09-02 12:54:00'),
(165, NULL, 110, 4, 1, 'spr-20240902-125636', 1, 60, NULL, 20, 'Cash', NULL, '2024-09-02 12:56:36', '2024-09-02 12:56:36'),
(166, 45, NULL, NULL, 1, 'ppr-20240902-045238', 1, 271, NULL, 0, 'Cash', NULL, '2024-09-02 16:52:38', '2024-09-02 16:52:38'),
(167, NULL, 111, 4, 1, 'spr-20240902-050624', 1, 260, NULL, 0, 'Cash', NULL, '2024-09-02 17:06:24', '2024-09-02 17:06:24'),
(168, NULL, 112, 4, 1, 'spr-20240902-050730', 1, 100, NULL, 0, 'Cash', NULL, '2024-09-02 17:07:30', '2024-09-02 17:07:30'),
(169, NULL, 113, 4, 1, 'spr-20240902-050826', 1, 180, NULL, 0, 'Cash', NULL, '2024-09-02 17:08:26', '2024-09-02 17:08:26'),
(170, 45, NULL, NULL, 1, 'ppr-20240902-051044', 1, 269, NULL, 0, 'Cash', NULL, '2024-09-02 17:10:44', '2024-09-02 17:10:44'),
(171, NULL, 114, 4, 1, 'spr-20240902-051342', 1, 720, NULL, 0, 'Cash', NULL, '2024-09-02 17:13:42', '2024-09-02 17:13:42'),
(172, NULL, 116, 4, 1, 'spr-20240902-062219', 1, 150, NULL, 0, 'Cash', NULL, '2024-09-02 18:22:19', '2024-09-02 18:22:19'),
(173, NULL, 117, 4, 1, 'spr-20240904-125233', 1, 140, NULL, 0, 'Cash', NULL, '2024-09-04 12:52:33', '2024-09-04 12:52:33'),
(174, NULL, 118, 4, 1, 'spr-20240904-010448', 1, 840, NULL, 0, 'Cash', NULL, '2024-09-04 13:04:48', '2024-09-04 13:04:48'),
(175, NULL, 118, 4, 1, 'spr-20240904-011849', 1, 840, NULL, 0, 'Cash', NULL, '2024-09-04 13:18:49', '2024-09-04 13:18:49'),
(176, NULL, 119, 4, 1, 'spr-20240904-055303', 1, 160, NULL, 0, 'Cash', NULL, '2024-09-04 17:53:03', '2024-09-04 17:53:03'),
(177, NULL, 120, 4, 1, 'spr-20240904-055729', 1, 34130, NULL, 0, 'Cash', NULL, '2024-09-04 17:57:29', '2024-09-04 17:57:29'),
(178, NULL, 121, 4, 1, 'spr-20240904-055808', 1, 120, NULL, 0, 'Cash', NULL, '2024-09-04 17:58:08', '2024-09-04 17:58:08'),
(179, NULL, 122, 4, 1, 'spr-20240904-060001', 1, 29000, NULL, 0, 'Cash', NULL, '2024-09-04 18:00:01', '2024-09-04 18:00:01'),
(180, NULL, 123, 4, 1, 'spr-20240904-060115', 1, 120, NULL, 0, 'Cash', NULL, '2024-09-04 18:01:15', '2024-09-04 18:01:15'),
(181, NULL, 124, 4, 1, 'spr-20240904-060349', 1, 120, NULL, 0, 'Cash', NULL, '2024-09-04 18:03:49', '2024-09-04 18:03:49'),
(182, NULL, 125, 4, 1, 'spr-20240904-060616', 1, 120, NULL, 0, 'Cash', NULL, '2024-09-04 18:06:16', '2024-09-04 18:06:16'),
(183, NULL, 126, 4, 1, 'spr-20240904-060858', 1, 80, NULL, 0, 'Cash', NULL, '2024-09-04 18:08:58', '2024-09-04 18:08:58'),
(184, NULL, 127, 4, 1, 'spr-20240905-110055', 1, 80, NULL, 0, 'Cash', NULL, '2024-09-05 11:00:55', '2024-09-05 11:00:55'),
(185, NULL, 128, 4, 1, 'spr-20240905-125613', 1, 470, NULL, 0, 'Cash', NULL, '2024-09-05 12:56:13', '2024-09-05 12:56:13'),
(186, NULL, 129, 4, 1, 'spr-20240905-125624', 1, 800, NULL, 0, 'Cash', NULL, '2024-09-05 12:56:24', '2024-09-05 12:56:24'),
(187, NULL, 130, 4, 1, 'spr-20240906-031506', 1, 34000, NULL, 0, 'Cash', NULL, '2024-09-06 15:15:06', '2024-09-06 15:15:06'),
(188, NULL, 131, 4, 1, 'spr-20240908-101249', 1, 80, NULL, 0, 'Cash', NULL, '2024-09-08 10:12:49', '2024-09-08 10:12:49'),
(189, NULL, 132, 4, 1, 'spr-20240908-104141', 1, 120, NULL, 0, 'Cash', NULL, '2024-09-08 10:41:41', '2024-09-08 10:41:41'),
(190, 54, NULL, NULL, 1, 'ppr-20240908-011429', 1, 10000, NULL, 0, 'Cash', NULL, '2024-09-08 13:14:29', '2024-09-08 13:14:29'),
(191, 54, NULL, NULL, 1, 'ppr-20240908-011453', 1, 5000, NULL, 0, 'Cash', NULL, '2024-09-08 13:14:53', '2024-09-08 13:14:53'),
(192, NULL, 133, 4, 1, 'spr-20240908-011747', 1, 200, NULL, 0, 'Cash', NULL, '2024-09-08 13:17:47', '2024-09-08 13:17:47'),
(193, NULL, 134, 4, 1, 'spr-20240908-011849', 1, 100, NULL, 0, 'Cash', NULL, '2024-09-08 13:18:49', '2024-09-08 13:18:49'),
(194, NULL, 133, 4, 1, 'spr-20240908-012100', 1, 100, NULL, 0, 'Cash', NULL, '2024-09-08 13:21:00', '2024-09-08 13:21:00'),
(195, NULL, 135, 4, 1, 'spr-20240908-040920', 1, 34000, NULL, 0, 'Cash', NULL, '2024-09-08 16:09:20', '2024-09-08 16:09:20'),
(196, NULL, 136, 4, 1, 'spr-20240909-102541', 1, 120, NULL, 0, 'Cash', NULL, '2024-09-09 10:25:41', '2024-09-09 10:25:41'),
(197, NULL, 137, 4, 1, 'spr-20240909-102639', 1, 1, NULL, 0, 'Cash', NULL, '2024-09-09 10:26:39', '2024-09-09 10:26:39'),
(198, NULL, 138, 4, 1, 'spr-20240909-020243', 1, 2000, NULL, 0, 'Cash', NULL, '2024-09-09 14:02:43', '2024-09-09 14:02:43'),
(199, NULL, 139, 4, 1, 'spr-20240909-020458', 1, 2000, NULL, 0, 'Cash', NULL, '2024-09-09 14:04:58', '2024-09-09 14:04:58'),
(200, NULL, 140, 4, 1, 'spr-20240909-020656', 1, 6700, NULL, 0, 'Cash', NULL, '2024-09-09 14:06:56', '2024-09-09 14:06:56'),
(201, NULL, 138, 4, 1, 'spr-20240909-021413', 1, 2000, NULL, 0, 'Cash', NULL, '2024-09-09 14:14:13', '2024-09-09 14:14:13'),
(202, NULL, 138, 4, 1, 'spr-20240909-021500', 1, 700, NULL, 0, 'Cash', NULL, '2024-09-09 14:15:00', '2024-09-09 14:15:00'),
(203, NULL, 141, 4, 1, 'spr-20240909-021830', 1, 800, NULL, 0, 'Cash', NULL, '2024-09-09 14:18:30', '2024-09-09 14:18:30'),
(204, NULL, 142, 4, 1, 'spr-20240909-023902', 1, 1000, NULL, 0, 'Cash', NULL, '2024-09-09 14:39:02', '2024-09-09 14:39:02'),
(205, 56, NULL, NULL, 4, 'ppr-20240909-031649', 1, 29600, NULL, 0, 'Cash', NULL, '2024-09-09 15:16:49', '2024-09-09 15:16:49'),
(206, NULL, 144, 4, 1, 'spr-20240909-032445', 1, 3323.5, NULL, 176.5, 'Cash', NULL, '2024-09-09 15:24:45', '2024-09-09 15:24:45'),
(207, NULL, 145, 4, 1, 'spr-20240909-032816', 1, 490, NULL, 10, 'Cash', NULL, '2024-09-09 15:28:16', '2024-09-09 15:28:16'),
(208, 55, NULL, NULL, 1, 'ppr-20240910-080322', 1, 130000, NULL, 0, 'Cash', NULL, '2024-09-10 20:03:22', '2024-09-10 20:03:22'),
(209, NULL, 146, 4, 1, 'spr-20240910-080406', 1, 1, NULL, 0, 'Cash', NULL, '2024-09-10 20:04:06', '2024-09-10 20:04:06'),
(210, NULL, 147, 4, 1, 'spr-20240910-082222', 1, 4790, NULL, 0, 'Cash', NULL, '2024-09-10 20:22:22', '2024-09-10 20:22:22'),
(211, NULL, 148, 4, 1, 'spr-20240911-115644', 1, 20000, NULL, 0, 'Cash', NULL, '2024-09-11 11:56:44', '2024-09-11 11:56:44'),
(212, NULL, 149, 4, 1, 'spr-20240911-120310', 1, 1523, NULL, 0, 'Cash', NULL, '2024-09-11 12:03:10', '2024-09-11 12:03:10'),
(213, NULL, 150, 4, 1, 'spr-20240911-120607', 1, 20000, NULL, 0, 'Cash', NULL, '2024-09-11 12:06:07', '2024-09-11 12:06:07'),
(214, NULL, 151, 4, 1, 'spr-20240911-121203', 1, 2000, NULL, 0, 'Cash', NULL, '2024-09-11 12:12:03', '2024-09-11 12:12:03'),
(215, NULL, 152, 4, 1, 'spr-20240911-121515', 1, 5760, NULL, 0, 'Cash', NULL, '2024-09-11 12:15:15', '2024-09-11 12:15:15'),
(216, NULL, 153, 4, 1, 'spr-20240911-122906', 1, 2000, NULL, 0, 'Cash', NULL, '2024-09-11 12:29:06', '2024-09-11 12:29:06'),
(217, NULL, 154, 4, 1, 'spr-20240911-011128', 1, 80, NULL, 0, 'Cash', NULL, '2024-09-11 13:11:28', '2024-09-11 13:11:28'),
(218, NULL, 155, 4, 1, 'spr-20240911-013431', 1, 100, NULL, 0, 'Cash', NULL, '2024-09-11 13:34:31', '2024-09-11 13:34:31'),
(219, NULL, 156, 4, 1, 'spr-20240912-023313', 1, 200, NULL, 0, 'Cash', NULL, '2024-09-12 14:33:13', '2024-09-12 14:33:13'),
(220, NULL, 157, 4, 1, 'spr-20240912-023720', 1, 160, NULL, 0, 'Cash', NULL, '2024-09-12 14:37:20', '2024-09-12 14:37:20'),
(221, NULL, 158, 4, 1, 'spr-20240912-092750', 1, 2492.88, NULL, 507.12, 'Cash', NULL, '2024-09-12 21:27:50', '2024-09-12 21:27:50'),
(222, NULL, 159, 4, 1, 'spr-20240914-012348', 1, 120, NULL, 0, 'Cash', NULL, '2024-09-14 13:23:48', '2024-09-14 13:23:48'),
(223, NULL, 160, 4, 1, 'spr-20240914-041506', 1, 760, NULL, 0, 'Cash', NULL, '2024-09-14 16:15:06', '2024-09-14 16:15:06'),
(224, 62, NULL, NULL, 1, 'ppr-20240914-055129', 1, 4750, NULL, 250, 'Cash', NULL, '2024-09-14 17:51:29', '2024-09-14 17:51:29'),
(225, NULL, 161, 4, 1, 'spr-20240914-055416', 1, 1018, NULL, 0, 'Cash', NULL, '2024-09-14 17:54:16', '2024-09-14 17:54:16'),
(226, 7, NULL, 4, 1, 'ppr-20240914-061003', 1, 500, NULL, 0, 'Cash', NULL, '2024-09-14 18:10:03', '2024-09-14 18:10:03'),
(227, 59, NULL, NULL, 1, 'ppr-20240914-061900', 1, 6650, NULL, 0, 'Cash', NULL, '2024-09-14 18:19:00', '2024-09-14 18:19:00'),
(228, NULL, 163, 4, 1, 'spr-20240914-102959', 1, 320, NULL, 0, 'Cash', NULL, '2024-09-14 22:29:59', '2024-09-14 22:29:59'),
(229, NULL, 164, 4, 1, 'spr-20240915-024835', 1, 102000, NULL, 0, 'Cash', NULL, '2024-09-15 14:48:35', '2024-09-15 14:48:35'),
(230, NULL, 165, 4, 1, 'spr-20240915-024939', 1, 40000, NULL, 0, 'Cash', NULL, '2024-09-15 14:49:39', '2024-09-15 14:49:39'),
(231, NULL, 166, 4, 1, 'spr-20240915-025026', 1, 1000, NULL, 0, 'Cash', NULL, '2024-09-15 14:50:26', '2024-09-15 14:50:26'),
(232, NULL, 166, 4, 1, 'spr-20240915-025123', 1, 100, NULL, 0, 'Cash', NULL, '2024-09-15 14:51:23', '2024-09-15 14:51:23'),
(233, 7, NULL, 4, 1, 'ppr-20240916-111525', 1, 200, NULL, 0, 'Cash', 'paid by cash', '2024-09-16 11:15:25', '2024-09-16 11:15:25'),
(234, NULL, 167, 4, 4, 'spr-20240916-121548', 1, 50, NULL, 0, 'Cash', NULL, '2024-09-16 12:15:48', '2024-09-16 12:18:07'),
(235, NULL, 168, 4, 1, 'spr-20240916-015844', 1, 80, NULL, 0, 'Cash', NULL, '2024-09-16 13:58:44', '2024-09-16 13:58:44'),
(236, NULL, 170, 4, 1, 'spr-20240917-121312', 1, 40, NULL, 0, 'Cash', NULL, '2024-09-17 00:13:12', '2024-09-17 00:13:12'),
(237, NULL, 171, 4, 1, 'spr-20240917-041517', 1, 500, NULL, 0, 'Cash', NULL, '2024-09-17 16:15:17', '2024-09-17 16:15:17'),
(238, NULL, 172, 4, 1, 'spr-20240917-041617', 1, 130, NULL, 0, 'Cash', NULL, '2024-09-17 16:16:17', '2024-09-17 16:16:17'),
(239, NULL, 173, 4, 1, 'spr-20240918-022303', 1, 420, NULL, 0, 'Cash', NULL, '2024-09-18 14:23:03', '2024-09-18 14:23:03'),
(240, NULL, 174, 4, 1, 'spr-20240918-024037', 1, 200, NULL, 0, 'Cash', NULL, '2024-09-18 14:40:37', '2024-09-18 14:40:37'),
(241, NULL, 175, 4, 1, 'spr-20240918-041942', 1, 43940, NULL, 2560, 'Cash', NULL, '2024-09-18 16:19:42', '2024-09-18 16:19:42'),
(242, NULL, 176, 4, 1, 'spr-20240921-123002', 1, 3000, NULL, 0, 'Cash', NULL, '2024-09-21 12:30:02', '2024-09-21 12:30:02'),
(243, NULL, 177, 4, 1, 'spr-20240921-123056', 1, 3000, NULL, 0, 'Cash', NULL, '2024-09-21 12:30:56', '2024-09-21 12:30:56'),
(244, NULL, 178, 4, 1, 'spr-20240921-124108', 1, 800, NULL, 0, 'Cash', NULL, '2024-09-21 12:41:08', '2024-09-21 12:41:08'),
(245, NULL, 179, 4, 1, 'spr-20240921-035652', 1, 34000, NULL, 0, 'Cash', NULL, '2024-09-21 15:56:52', '2024-09-21 15:56:52'),
(246, NULL, 180, 4, 1, 'spr-20240922-013010', 1, 160, NULL, 0, 'Cash', NULL, '2024-09-22 13:30:10', '2024-09-22 13:30:10'),
(247, NULL, 180, 4, 1, 'spr-20240924-012108', 1, 100, NULL, 0, 'Cash', NULL, '2024-09-24 13:21:08', '2024-09-24 13:21:08'),
(248, NULL, 182, 4, 1, 'spr-20240924-012329', 1, 220, NULL, 0, 'Cash', NULL, '2024-09-24 13:23:29', '2024-09-24 13:23:29'),
(249, NULL, 162, 4, 1, 'spr-20240924-022110', 1, 450, NULL, 0, 'Cash', NULL, '2024-09-24 14:21:10', '2024-09-24 14:21:10'),
(250, NULL, 183, 4, 1, 'spr-20240924-022110', 1, 9550, NULL, 0, 'Cash', NULL, '2024-09-24 14:21:10', '2024-09-24 14:21:10'),
(251, NULL, 183, 4, 1, 'spr-20240924-022128', 1, 169000, NULL, 0, 'Cash', NULL, '2024-09-24 14:21:28', '2024-09-24 14:21:28'),
(252, NULL, 183, 4, 1, 'spr-20240924-022153', 1, 1525950, NULL, 0, 'Cash', NULL, '2024-09-24 14:21:53', '2024-09-24 14:21:53'),
(253, NULL, 180, 4, 1, 'spr-20240924-035441', 1, -100, NULL, 0, 'Cash', 'fgf', '2024-09-24 15:54:41', '2024-09-24 15:54:41'),
(254, NULL, 181, 4, 1, 'spr-20240924-035441', 1, 450, NULL, 0, 'Cash', 'fgf', '2024-09-24 15:54:41', '2024-09-24 15:54:41'),
(255, NULL, 184, 4, 1, 'spr-20240925-063416', 1, 80, NULL, 0, 'Cash', NULL, '2024-09-25 18:34:16', '2024-09-25 18:34:16'),
(256, NULL, 185, 4, 4, 'spr-20240925-063641', 1, 200, NULL, 0, 'Cash', NULL, '2024-09-25 18:36:41', '2024-09-25 18:36:41'),
(257, NULL, 186, 4, 4, 'spr-20240925-064510', 1, 600, NULL, 0, 'Cash', NULL, '2024-09-25 18:45:10', '2024-09-25 18:45:10'),
(258, NULL, 8, 4, 4, 'spr-20240925-064648', 1, 20, NULL, 0, 'Cash', NULL, '2024-09-25 18:46:48', '2024-09-25 18:46:48'),
(259, NULL, 9, 4, 4, 'spr-20240925-064648', 1, 10, NULL, 0, 'Cash', NULL, '2024-09-25 18:46:48', '2024-09-25 18:46:48'),
(260, NULL, 10, 4, 4, 'spr-20240925-064648', 1, 30, NULL, 0, 'Cash', NULL, '2024-09-25 18:46:48', '2024-09-25 18:46:48'),
(261, NULL, 19, 4, 4, 'spr-20240925-064648', 1, 30, NULL, 0, 'Cash', NULL, '2024-09-25 18:46:48', '2024-09-25 18:46:48'),
(262, NULL, 28, 4, 4, 'spr-20240925-064648', 1, 1310, NULL, 0, 'Cash', NULL, '2024-09-25 18:46:48', '2024-09-25 18:46:48'),
(263, NULL, 28, 4, 6, 'spr-20240925-064703', 1, 14000, NULL, 0, 'Cash', NULL, '2024-09-25 18:47:03', '2024-09-25 18:47:03'),
(264, 25, NULL, 4, 5, 'ppr-20240925-064904', 1, 9470, NULL, 0, 'Cash', NULL, '2024-09-25 18:49:04', '2024-09-25 18:49:04'),
(265, 54, NULL, 4, 5, 'ppr-20240925-064904', 1, 45200, NULL, 0, 'Cash', NULL, '2024-09-25 18:49:04', '2024-09-25 18:49:04'),
(266, 67, NULL, 4, 5, 'ppr-20240925-064904', 1, 45330, NULL, 0, 'Cash', NULL, '2024-09-25 18:49:04', '2024-09-25 18:49:04'),
(267, NULL, 187, 4, 5, 'spr-20240925-070835', 1, 36000, NULL, 0, 'Cash', NULL, '2024-09-25 19:08:35', '2024-09-25 19:15:39'),
(268, NULL, 187, 4, 4, 'spr-20240925-071551', 1, 100000, NULL, 0, 'Cash', NULL, '2024-09-25 19:15:51', '2024-09-25 19:15:51'),
(269, NULL, 188, 4, 5, 'spr-20240926-051026', 1, 350, NULL, 0, 'Cash', NULL, '2024-09-26 17:10:26', '2024-09-26 17:10:26'),
(270, NULL, 188, 4, 1, 'spr-20240926-051037', 1, 3150, NULL, 0, 'Cash', NULL, '2024-09-26 17:10:37', '2024-09-26 17:10:37'),
(271, NULL, 189, 4, 1, 'spr-20240927-041357', 1, 23000, NULL, 0, 'Cash', NULL, '2024-09-27 16:13:57', '2024-09-27 16:13:57'),
(272, NULL, 188, 4, 1, 'spr-20240927-042231', 1, -3500, NULL, 0, 'Cash', NULL, '2024-09-27 16:22:31', '2024-09-27 16:22:31'),
(273, NULL, 189, 4, 1, 'spr-20240927-042527', 1, -40, NULL, 0, 'Cash', NULL, '2024-09-27 16:25:27', '2024-09-27 16:25:27'),
(274, 83, NULL, NULL, 1, 'ppr-20240928-123518', 1, 5000, NULL, 0, 'Cash', NULL, '2024-09-28 12:35:18', '2024-09-28 12:35:18'),
(275, 83, NULL, NULL, 4, 'ppr-20240928-123619', 1, 5000, NULL, 0, 'Cash', NULL, '2024-09-28 12:36:19', '2024-09-28 12:36:19'),
(276, NULL, 190, 4, 6, 'spr-20240928-124020', 1, 5000, NULL, 0, 'Cash', NULL, '2024-09-28 12:40:20', '2024-09-28 12:40:20'),
(277, NULL, 190, 4, 1, 'spr-20240928-124949', 1, -5100, NULL, 0, 'Cash', NULL, '2024-09-28 12:49:49', '2024-09-28 12:49:49'),
(278, 84, NULL, NULL, 1, 'ppr-20240929-120956', 1, 150, NULL, 0, 'Cash', NULL, '2024-09-29 12:09:56', '2024-09-29 12:09:56'),
(279, NULL, 191, 4, 1, 'spr-20240929-123446', 1, 6690, NULL, 0, 'Cash', NULL, '2024-09-29 12:34:46', '2024-09-29 12:34:46'),
(280, NULL, 192, 4, 1, 'spr-20240929-124105', 1, 1400, NULL, 0, 'Cash', NULL, '2024-09-29 12:41:05', '2024-09-29 12:41:05'),
(281, NULL, 193, 4, 1, 'spr-20240929-124318', 1, 1200, NULL, 0, 'Cash', NULL, '2024-09-29 12:43:18', '2024-09-29 12:43:18'),
(282, NULL, 194, 4, 1, 'spr-20240929-012509', 1, 650, NULL, 0, 'Cash', NULL, '2024-09-29 13:25:09', '2024-09-29 13:25:09'),
(283, NULL, 195, 4, 1, 'spr-20240929-013745', 1, 2400, NULL, 0, 'Cash', NULL, '2024-09-29 13:37:45', '2024-09-29 13:37:45'),
(284, NULL, 196, 4, 1, 'spr-20240929-014459', 1, 2560, NULL, 0, 'Cash', NULL, '2024-09-29 13:44:59', '2024-09-29 13:44:59'),
(285, NULL, 197, 4, 1, 'spr-20240929-015229', 1, 1400, NULL, 0, 'Cash', NULL, '2024-09-29 13:52:29', '2024-09-29 13:52:29'),
(286, NULL, 198, 4, 1, 'spr-20240929-033614', 1, 8880, NULL, 0, 'Cash', NULL, '2024-09-29 15:36:14', '2024-09-29 15:36:14'),
(287, NULL, 198, 4, 1, 'spr-20240929-054312', 1, -400, NULL, 0, 'Cash', NULL, '2024-09-29 17:43:12', '2024-09-29 17:43:12'),
(288, NULL, 199, 4, 4, 'spr-20240930-061513', 1, 540, NULL, 0, 'Credit Card', NULL, '2024-09-30 18:15:13', '2024-09-30 18:15:13'),
(289, NULL, 200, 4, 5, 'spr-20240930-061841', 1, 1, NULL, 0, 'Cash', NULL, '2024-09-30 18:18:41', '2024-09-30 18:18:41'),
(290, NULL, 201, 4, 1, 'spr-20241001-120049', 1, 2720, NULL, 0, 'Cash', NULL, '2024-10-01 12:00:49', '2024-10-01 12:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_cheque`
--

CREATE TABLE `payment_with_cheque` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_with_cheque`
--

INSERT INTO `payment_with_cheque` (`id`, `payment_id`, `cheque_no`, `created_at`, `updated_at`) VALUES
(1, 96, '3456345', '2024-06-10 11:06:21', '2024-06-10 11:06:21');

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_credit_card`
--

CREATE TABLE `payment_with_credit_card` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_stripe_id` varchar(255) DEFAULT NULL,
  `charge_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_gift_card`
--

CREATE TABLE `payment_with_gift_card` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `gift_card_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_with_paypal`
--

CREATE TABLE `payment_with_paypal` (
  `id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `paying_method` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payrolls`
--

INSERT INTO `payrolls` (`id`, `reference_no`, `employee_id`, `account_id`, `user_id`, `amount`, `paying_method`, `note`, `created_at`, `updated_at`) VALUES
(1, 'payroll-20240424-033501', 1, 1, 1, 15000, '1', NULL, '2024-04-24 15:35:01', '2024-04-24 15:35:01'),
(2, 'payroll-20240811-042533', 1, 1, 1, 5000, '0', NULL, '2024-08-11 04:25:33', '2024-08-11 04:25:33'),
(3, 'payroll-20240901-031025', 1, 1, 1, 3, '2', NULL, '2024-09-01 15:10:25', '2024-09-01 15:10:25'),
(4, 'payroll-20240902-023724', 5, 1, 1, 15000, '0', 'monthely selary', '2024-09-02 14:37:24', '2024-09-02 14:37:24'),
(5, 'payroll-20240910-081605', 1, 1, 1, 8000, '0', NULL, '2024-09-10 20:16:05', '2024-09-10 20:16:05'),
(6, 'payroll-20240925-072105', 1, 1, 1, 500, '0', NULL, '2024-09-25 19:21:05', '2024-09-25 19:21:05'),
(7, 'payroll-20240929-031211', 6, 1, 1, 20000, '0', NULL, '2024-09-29 15:12:11', '2024-09-29 15:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(4, 'products-edit', 'web', '2018-06-03 01:00:09', '2018-06-03 01:00:09'),
(5, 'products-delete', 'web', '2018-06-03 22:54:22', '2018-06-03 22:54:22'),
(6, 'products-add', 'web', '2018-06-04 00:34:14', '2018-06-04 00:34:14'),
(7, 'products-index', 'web', '2018-06-04 03:34:27', '2018-06-04 03:34:27'),
(8, 'purchases-index', 'web', '2018-06-04 08:03:19', '2018-06-04 08:03:19'),
(9, 'purchases-add', 'web', '2018-06-04 08:12:25', '2018-06-04 08:12:25'),
(10, 'purchases-edit', 'web', '2018-06-04 09:47:36', '2018-06-04 09:47:36'),
(11, 'purchases-delete', 'web', '2018-06-04 09:47:36', '2018-06-04 09:47:36'),
(12, 'sales-index', 'web', '2018-06-04 10:49:08', '2018-06-04 10:49:08'),
(13, 'sales-add', 'web', '2018-06-04 10:49:52', '2018-06-04 10:49:52'),
(14, 'sales-edit', 'web', '2018-06-04 10:49:52', '2018-06-04 10:49:52'),
(15, 'sales-delete', 'web', '2018-06-04 10:49:53', '2018-06-04 10:49:53'),
(16, 'quotes-index', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(17, 'quotes-add', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(18, 'quotes-edit', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(19, 'quotes-delete', 'web', '2018-06-04 22:05:10', '2018-06-04 22:05:10'),
(20, 'transfers-index', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(21, 'transfers-add', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(22, 'transfers-edit', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(23, 'transfers-delete', 'web', '2018-06-04 22:30:03', '2018-06-04 22:30:03'),
(24, 'returns-index', 'web', '2018-06-04 22:50:24', '2018-06-04 22:50:24'),
(25, 'returns-add', 'web', '2018-06-04 22:50:24', '2018-06-04 22:50:24'),
(26, 'returns-edit', 'web', '2018-06-04 22:50:25', '2018-06-04 22:50:25'),
(27, 'returns-delete', 'web', '2018-06-04 22:50:25', '2018-06-04 22:50:25'),
(28, 'customers-index', 'web', '2018-06-04 23:15:54', '2018-06-04 23:15:54'),
(29, 'customers-add', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(30, 'customers-edit', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(31, 'customers-delete', 'web', '2018-06-04 23:15:55', '2018-06-04 23:15:55'),
(32, 'suppliers-index', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(33, 'suppliers-add', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(34, 'suppliers-edit', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(35, 'suppliers-delete', 'web', '2018-06-04 23:40:12', '2018-06-04 23:40:12'),
(36, 'product-report', 'web', '2018-06-24 23:05:33', '2018-06-24 23:05:33'),
(37, 'purchase-report', 'web', '2018-06-24 23:24:56', '2018-06-24 23:24:56'),
(38, 'sale-report', 'web', '2018-06-24 23:33:13', '2018-06-24 23:33:13'),
(39, 'customer-report', 'web', '2018-06-24 23:36:51', '2018-06-24 23:36:51'),
(40, 'due-report', 'web', '2018-06-24 23:39:52', '2018-06-24 23:39:52'),
(41, 'users-index', 'web', '2018-06-25 00:00:10', '2018-06-25 00:00:10'),
(42, 'users-add', 'web', '2018-06-25 00:00:10', '2018-06-25 00:00:10'),
(43, 'users-edit', 'web', '2018-06-25 00:01:30', '2018-06-25 00:01:30'),
(44, 'users-delete', 'web', '2018-06-25 00:01:30', '2018-06-25 00:01:30'),
(45, 'profit-loss', 'web', '2018-07-14 21:50:05', '2018-07-14 21:50:05'),
(46, 'best-seller', 'web', '2018-07-14 22:01:38', '2018-07-14 22:01:38'),
(47, 'daily-sale', 'web', '2018-07-14 22:24:21', '2018-07-14 22:24:21'),
(48, 'monthly-sale', 'web', '2018-07-14 22:30:41', '2018-07-14 22:30:41'),
(49, 'daily-purchase', 'web', '2018-07-14 22:36:46', '2018-07-14 22:36:46'),
(50, 'monthly-purchase', 'web', '2018-07-14 22:48:17', '2018-07-14 22:48:17'),
(51, 'payment-report', 'web', '2018-07-14 23:10:41', '2018-07-14 23:10:41'),
(52, 'warehouse-stock-report', 'web', '2018-07-14 23:16:55', '2018-07-14 23:16:55'),
(53, 'product-qty-alert', 'web', '2018-07-14 23:33:21', '2018-07-14 23:33:21'),
(54, 'supplier-report', 'web', '2018-07-30 03:00:01', '2018-07-30 03:00:01'),
(55, 'expenses-index', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(56, 'expenses-add', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(57, 'expenses-edit', 'web', '2018-09-05 01:07:10', '2018-09-05 01:07:10'),
(58, 'expenses-delete', 'web', '2018-09-05 01:07:11', '2018-09-05 01:07:11'),
(59, 'general_setting', 'web', '2018-10-19 23:10:04', '2018-10-19 23:10:04'),
(60, 'mail_setting', 'web', '2018-10-19 23:10:04', '2018-10-19 23:10:04'),
(61, 'pos_setting', 'web', '2018-10-19 23:10:04', '2018-10-19 23:10:04'),
(62, 'hrm_setting', 'web', '2019-01-02 10:30:23', '2019-01-02 10:30:23'),
(63, 'purchase-return-index', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(64, 'purchase-return-add', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(65, 'purchase-return-edit', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(66, 'purchase-return-delete', 'web', '2019-01-02 21:45:14', '2019-01-02 21:45:14'),
(67, 'account-index', 'web', '2019-01-02 22:06:13', '2019-01-02 22:06:13'),
(68, 'balance-sheet', 'web', '2019-01-02 22:06:14', '2019-01-02 22:06:14'),
(69, 'account-statement', 'web', '2019-01-02 22:06:14', '2019-01-02 22:06:14'),
(70, 'department', 'web', '2019-01-02 22:30:01', '2019-01-02 22:30:01'),
(71, 'attendance', 'web', '2019-01-02 22:30:01', '2019-01-02 22:30:01'),
(72, 'payroll', 'web', '2019-01-02 22:30:01', '2019-01-02 22:30:01'),
(73, 'employees-index', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(74, 'employees-add', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(75, 'employees-edit', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(76, 'employees-delete', 'web', '2019-01-02 22:52:19', '2019-01-02 22:52:19'),
(77, 'user-report', 'web', '2019-01-16 06:48:18', '2019-01-16 06:48:18'),
(78, 'stock_count', 'web', '2019-02-17 10:32:01', '2019-02-17 10:32:01'),
(79, 'adjustment', 'web', '2019-02-17 10:32:02', '2019-02-17 10:32:02'),
(80, 'sms_setting', 'web', '2019-02-22 05:18:03', '2019-02-22 05:18:03'),
(81, 'create_sms', 'web', '2019-02-22 05:18:03', '2019-02-22 05:18:03'),
(82, 'print_barcode', 'web', '2019-03-07 05:02:19', '2019-03-07 05:02:19'),
(83, 'empty_database', 'web', '2019-03-07 05:02:19', '2019-03-07 05:02:19'),
(84, 'customer_group', 'web', '2019-03-07 05:37:15', '2019-03-07 05:37:15'),
(85, 'unit', 'web', '2019-03-07 05:37:15', '2019-03-07 05:37:15'),
(86, 'tax', 'web', '2019-03-07 05:37:15', '2019-03-07 05:37:15'),
(87, 'gift_card', 'web', '2019-03-07 06:29:38', '2019-03-07 06:29:38'),
(88, 'coupon', 'web', '2019-03-07 06:29:38', '2019-03-07 06:29:38'),
(89, 'holiday', 'web', '2019-10-19 08:57:15', '2019-10-19 08:57:15'),
(90, 'warehouse-report', 'web', '2019-10-22 06:00:23', '2019-10-22 06:00:23'),
(91, 'warehouse', 'web', '2020-02-26 06:47:32', '2020-02-26 06:47:32'),
(92, 'brand', 'web', '2020-02-26 06:59:59', '2020-02-26 06:59:59'),
(93, 'billers-index', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(94, 'billers-add', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(95, 'billers-edit', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(96, 'billers-delete', 'web', '2020-02-26 07:11:15', '2020-02-26 07:11:15'),
(97, 'money-transfer', 'web', '2020-03-02 05:41:48', '2020-03-02 05:41:48'),
(98, 'category', 'web', '2020-07-13 12:13:16', '2020-07-13 12:13:16'),
(99, 'delivery', 'web', '2020-07-13 12:13:16', '2020-07-13 12:13:16'),
(100, 'send_notification', 'web', '2020-10-31 06:21:31', '2020-10-31 06:21:31'),
(101, 'today_sale', 'web', '2020-10-31 06:57:04', '2020-10-31 06:57:04'),
(102, 'today_profit', 'web', '2020-10-31 06:57:04', '2020-10-31 06:57:04'),
(103, 'currency', 'web', '2020-11-09 00:23:11', '2020-11-09 00:23:11'),
(104, 'backup_database', 'web', '2020-11-15 00:16:55', '2020-11-15 00:16:55'),
(105, 'reward_point_setting', 'web', '2021-06-27 04:34:42', '2021-06-27 04:34:42'),
(106, 'revenue_profit_summary', 'web', '2022-02-08 13:57:21', '2022-02-08 13:57:21'),
(107, 'cash_flow', 'web', '2022-02-08 13:57:22', '2022-02-08 13:57:22'),
(108, 'monthly_summary', 'web', '2022-02-08 13:57:22', '2022-02-08 13:57:22'),
(109, 'yearly_report', 'web', '2022-02-08 13:57:22', '2022-02-08 13:57:22'),
(110, 'discount_plan', 'web', '2022-02-16 09:12:26', '2022-02-16 09:12:26'),
(111, 'discount', 'web', '2022-02-16 09:12:38', '2022-02-16 09:12:38'),
(112, 'product-expiry-report', 'web', '2022-03-30 05:39:20', '2022-03-30 05:39:20'),
(113, 'purchase-payment-index', 'web', '2022-06-05 14:12:27', '2022-06-05 14:12:27'),
(114, 'purchase-payment-add', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(115, 'purchase-payment-edit', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(116, 'purchase-payment-delete', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(117, 'sale-payment-index', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(118, 'sale-payment-add', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(119, 'sale-payment-edit', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(120, 'sale-payment-delete', 'web', '2022-06-05 14:12:28', '2022-06-05 14:12:28'),
(121, 'all_notification', 'web', '2022-06-05 14:12:29', '2022-06-05 14:12:29'),
(122, 'sale-report-chart', 'web', '2022-06-05 14:12:29', '2022-06-05 14:12:29'),
(123, 'dso-report', 'web', '2022-06-05 14:12:29', '2022-06-05 14:12:29'),
(124, 'product_history', 'web', '2022-08-25 14:04:05', '2022-08-25 14:04:05'),
(125, 'supplier-due-report', 'web', '2022-08-31 09:46:33', '2022-08-31 09:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `pos_setting`
--

CREATE TABLE `pos_setting` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `product_number` int(11) NOT NULL,
  `keybord_active` tinyint(1) NOT NULL,
  `is_table` tinyint(1) NOT NULL DEFAULT 0,
  `stripe_public_key` varchar(255) DEFAULT NULL,
  `stripe_secret_key` varchar(255) DEFAULT NULL,
  `paypal_live_api_username` varchar(255) DEFAULT NULL,
  `paypal_live_api_password` varchar(255) DEFAULT NULL,
  `paypal_live_api_secret` varchar(255) DEFAULT NULL,
  `payment_options` text DEFAULT NULL,
  `invoice_option` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pos_setting`
--

INSERT INTO `pos_setting` (`id`, `customer_id`, `warehouse_id`, `biller_id`, `product_number`, `keybord_active`, `is_table`, `stripe_public_key`, `stripe_secret_key`, `paypal_live_api_username`, `paypal_live_api_password`, `paypal_live_api_secret`, `payment_options`, `invoice_option`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 4, 1, 1, NULL, NULL, NULL, NULL, NULL, 'cash,card,cheque,gift_card,deposit', 'A4_style1', '2023-05-28 06:57:03', '2024-10-01 22:21:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `barcode_symbology` varchar(255) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `purchase_unit_id` int(11) NOT NULL,
  `sale_unit_id` int(11) NOT NULL,
  `cost` double NOT NULL,
  `price` double NOT NULL,
  `qty` double DEFAULT NULL,
  `alert_quantity` double DEFAULT NULL,
  `daily_sale_objective` double DEFAULT NULL,
  `promotion` tinyint(4) DEFAULT NULL,
  `promotion_price` varchar(255) DEFAULT NULL,
  `starting_date` date DEFAULT NULL,
  `last_date` date DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `tax_method` int(11) DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `is_embeded` tinyint(1) DEFAULT NULL,
  `is_variant` tinyint(1) DEFAULT NULL,
  `is_batch` tinyint(1) DEFAULT NULL,
  `is_diffPrice` tinyint(1) DEFAULT NULL,
  `is_imei` tinyint(1) DEFAULT NULL,
  `featured` tinyint(4) DEFAULT NULL,
  `is_online` tinyint(4) DEFAULT NULL,
  `in_stock` tinyint(4) DEFAULT NULL,
  `track_inventory` tinyint(4) NOT NULL DEFAULT 0,
  `product_list` varchar(255) DEFAULT NULL,
  `variant_list` varchar(255) DEFAULT NULL,
  `qty_list` varchar(255) DEFAULT NULL,
  `price_list` varchar(255) DEFAULT NULL,
  `product_details` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `specification` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `related_products` longtext DEFAULT NULL,
  `variant_option` text DEFAULT NULL,
  `variant_value` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `tags`, `code`, `type`, `barcode_symbology`, `brand_id`, `category_id`, `unit_id`, `purchase_unit_id`, `sale_unit_id`, `cost`, `price`, `qty`, `alert_quantity`, `daily_sale_objective`, `promotion`, `promotion_price`, `starting_date`, `last_date`, `tax_id`, `tax_method`, `image`, `file`, `is_embeded`, `is_variant`, `is_batch`, `is_diffPrice`, `is_imei`, `featured`, `is_online`, `in_stock`, `track_inventory`, `product_list`, `variant_list`, `qty_list`, `price_list`, `product_details`, `short_description`, `specification`, `meta_title`, `meta_description`, `related_products`, `variant_option`, `variant_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Basmoti Chal', NULL, NULL, '86997504', 'standard', 'C128', 1, 1, 1, 1, 1, 65, 80, 10123, 200, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404011011271.jpg', NULL, 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-01 10:11:27', '2024-09-29 17:42:37'),
(2, 'Fresh Oil 2 Litter', NULL, NULL, '59122776', 'standard', 'C128', NULL, 3, 2, 2, 2, 100, 120, 14, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404070222271.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-07 02:22:27', '2024-09-27 16:13:57'),
(3, 'Fan', NULL, NULL, '58992496', 'standard', 'C128', 1, 9, 2, 2, 2, 500, 600, 8, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-04-22 20:09:25', '2024-05-22 14:50:09'),
(4, 'vivo Y17s (6GB/128GB)', NULL, NULL, '00127202', 'standard', 'C128', 2, 11, 2, 2, 2, 13599, 15999, 42, 10, 50, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<ul class=@@>\r\n<li class=@@>Internal Model: PD2317F/CF/DF/EF/JF/IF/GF/KF/NF/LF</li>\r\n<li class=@@>External Model:Y17s</li>\r\n<li class=@@>Network Registration Model:V2310</li>\r\n<li class=@@>Color:Glitter Purple, Forest Green</li>\r\n<li class=@@>Ingress Protection Rating:IP54\\</li>\r\n<li class=@@>Operating System:Funtouch OS 13</li>\r\n<li class=@@>Android Version:Android 13</li>\r\n<li class=@@>Processor:MediaTek Helio G85</li>\r\n<li class=@@>CPU Core Count:8</li>\r\n<li class=@@>Process Node:12 nm</li>\r\n<li class=@@>CPU Clock Speed:2 &times; 2.0 GHz + 6 &times; 1.8 GHz</li>\r\n<li class=@@>RAM &amp; ROM:6 GB + 128 GB</li>\r\n<li class=@@>RAM Type:LPDDR4X</li>\r\n<li class=@@>ROM Type:eMMC 5.1</li>\r\n<li class=@@>Expandable RAM Capacity:6 GB</li>\r\n<li class=@@>Expandable ROM Capacity:1 TB</li>\r\n<li class=@@>Battery:5000 mAh (TYP)</li>\r\n<li class=@@>Charging Power:15W</li>\r\n<li class=@@>Battery Type:Li-ion battery</li>\r\n<li class=@@>Dimensions:163.74 &times; 75.43 &times; 8.09 mm</li>\r\n<li class=@@>Weight:186g</li>\r\n<li class=@@>Back Cover Material:Composite plastic sheet</li>\r\n<li class=@@>Fingerprint Sensor Type:Side-mounted fingerprint scanner</li>\r\n<li class=@@>Size:6.56-inch</li>\r\n<li class=@@>Resolution:1612 &times; 720</li>\r\n<li class=@@>Refresh Rate:60 Hz</li>\r\n<li class=@@>Local Peak Brightness:N/A</li>\r\n<li class=@@>Color Gamut:DCI-P3 not supported</li>\r\n<li class=@@>Color Saturation:83% NTSC</li>\r\n<li class=@@>Pixel Density:269 ppi</li>\r\n<li class=@@>Light-Emitting Material:LED</li>\r\n<li class=@@>Type:LCD</li>\r\n<li class=@@>Touch ScreenCapacitive: multi-touch</li>\r\n<li class=@@>Country/Region: Bangladesh/Myanmar/Nepal/Bhutan/Egypt/Kenya/Tanzania/Nigeri</li>\r\n</ul>', NULL, NULL, NULL, NULL, NULL, '[\"Color\"]', '[\"Forest Green,Glitter Purple\"]', 1, '2024-04-23 10:52:31', '2024-09-01 14:14:39'),
(5, 'Samsung RB21KMFH5SK/D3 Refrigerator with Digital Inverter (218 Liter)', NULL, NULL, '15239996', 'standard', 'C128', 3, 12, 2, 2, 2, 40500, 42500, 43, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Color\"]', '[\"Red,Silver,Gold\"]', 1, '2024-04-23 10:58:06', '2024-09-18 16:19:42'),
(6, 'Watch for Men Gift', NULL, NULL, '95843612', 'standard', 'C39', NULL, 13, 2, 2, 2, 250, 399, 0, 10, 30, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231103091.jpg', NULL, 0, 1, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Color\"]', '[\"Black,Silver,Gold\"]', 1, '2024-04-23 11:03:09', '2024-04-24 15:20:37'),
(7, 'Portable Hand Fan Battery Operated USB Rechargeable Handheld Mini Fan', NULL, NULL, '10286023', 'standard', 'C128', NULL, 14, 2, 2, 2, 300, 450, 30, 10, 30, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:07:05', '2024-09-24 14:20:25'),
(8, 'WICON 36&quot; CLASSIC CELLING FAN', NULL, NULL, '28364992', 'standard', 'C128', NULL, 14, 2, 2, 2, 2000, 3000, 12, 5, 25, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:09:50', '2024-09-28 12:34:39'),
(9, 'Rechargeable Fan Defender/kennede (12”) AC/DC KN 2912 (Service Warranty 02 Years)', NULL, NULL, '74740158', 'standard', 'C128', NULL, 14, 2, 2, 2, 2500, 3500, 53, 5, 15, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:10:47', '2024-09-27 16:21:00'),
(10, 'Pure Litchi Flower Honey – 250gm', NULL, NULL, '99053210', 'standard', 'C128', NULL, 15, 1, 1, 1, 150, 210, 0, 10, 20, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231116582.jpg', NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:16:34', '2024-04-23 11:16:58'),
(11, 'Al Shifa Natural Honey - 250gm (Originally Imported- Saudi Arabia', NULL, NULL, '07158860', 'standard', 'C128', NULL, 15, 1, 1, 1, 500, 600, 141, 10, 20, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231118331.jpg', NULL, 0, NULL, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:18:33', '2024-09-30 18:15:13'),
(12, 'Wheel Washing (Detergent) Powder 2in1 Clean &amp; Fresh 1Kg', NULL, NULL, '21201886', 'standard', 'C128', NULL, 16, 1, 1, 1, 110, 133, 10, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231122471.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:22:47', '2024-09-28 12:34:39'),
(13, 'Chaka Advanced Washing Powder - 500g', NULL, NULL, '79020823', 'standard', 'C128', NULL, 16, 1, 1, 1, 52, 62, 1, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231124391.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:24:39', '2024-09-26 17:01:21'),
(14, 'Gasoline Water Pump 7HP TOTAL - TP3302', NULL, NULL, '64803730', 'standard', 'C128', NULL, 17, 2, 2, 2, 20000, 22890, 0, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231128492.jpg', NULL, 0, NULL, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:28:17', '2024-04-24 15:20:07'),
(15, 'JET PUMP 1100W-1.5HP INGCO (JP11008)', NULL, NULL, '61027839', 'standard', 'C128', NULL, 17, 2, 2, 2, 10000, 11500, 7, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231134531.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:34:53', '2024-09-14 17:50:17'),
(16, 'VINTAGE T9 TRIMMER PROFESSIONAL CUT &amp; SHAVE METAL BODY', NULL, NULL, '60130194', 'standard', 'C128', NULL, 10, 2, 2, 2, 300, 450, 0, 10, 30, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231138211.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:38:21', '2024-04-23 11:38:21'),
(17, 'Tangail Tat Yellow Maslaice Cotton Saree For Women', NULL, NULL, '07412376', 'standard', 'C128', NULL, 18, 2, 2, 2, 1500, 2000, 0, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231147041.jpg', NULL, 0, 1, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Color\"]', '[\"Yellow\"]', 1, '2024-04-23 11:47:04', '2024-04-24 15:20:55'),
(18, 'Tangail Tat Multi Colour Trendy Moslin Jamdani Saree for Women', NULL, NULL, '30397249', 'standard', 'C128', NULL, 18, 2, 2, 2, 900, 1200, 3, 5, 16, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231148521.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:48:52', '2024-09-14 17:50:17'),
(19, 'Stylish and Fashionable Winter and Summer Sneakers for Men', NULL, NULL, '83325407', 'standard', 'C128', NULL, 19, 2, 2, 2, 400, 600, 0, 5, 20, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231152061.jpg', NULL, 0, NULL, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:52:06', '2024-04-24 15:20:21'),
(20, 'Converse Shoes For Men', NULL, NULL, '78990263', 'standard', 'C128', NULL, 19, 2, 2, 2, 450, 750, 0, 10, 20, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231155571.jpg', NULL, 0, NULL, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:55:57', '2024-04-24 15:19:53'),
(21, 'K33 Black Waterproof Electronic Arc Plasma Lighter with Outdoor Camping Light Flashlight', NULL, NULL, '03820951', 'standard', 'C128', NULL, 10, 2, 2, 2, 450, 650, 0, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404231159381.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-23 11:59:38', '2024-04-23 11:59:38'),
(22, 'Silk Glamor High Sheen', NULL, NULL, '17632685', 'standard', 'C128', NULL, 20, 2, 2, 2, 1200, 1500, 0, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404291133041.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-29 11:33:05', '2024-04-29 11:33:05'),
(23, 'Seal-O-Prime', NULL, NULL, '71904526', 'standard', 'C128', NULL, 20, 2, 2, 2, 2000, 2500, 0, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404291134231.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-29 11:34:23', '2024-04-29 11:34:23'),
(24, 'Rangoli Total Care', NULL, NULL, '72693257', 'standard', 'C128', NULL, 20, 2, 2, 2, 3000, 3500, 0, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404291135491.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-29 11:35:49', '2024-04-29 11:35:49'),
(25, 'Bison Wall Putty', NULL, NULL, '47356130', 'standard', 'C128', NULL, 20, 2, 2, 2, 2500, 3000, 0, 5, 10, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202404291138451.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-04-29 11:38:45', '2024-04-29 11:38:45'),
(26, 'Nagisil', NULL, NULL, '34824691', 'standard', 'C128', 1, 1, 2, 2, 2, 2500, 2575, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, 0, 1, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Size\"]', '[\"25kg,50kg\"]', 1, '2024-05-01 17:44:03', '2024-07-30 16:38:19'),
(27, 'SS10', NULL, NULL, '38225400', 'standard', 'C128', 2, 5, 2, 2, 2, 100, 200, 12, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Size and color\"]', '[\"36 balck,36 pink,37 black,37 pink\"]', 1, '2024-05-04 16:20:09', '2024-05-04 16:37:58'),
(28, 'sdsd', NULL, NULL, 'sdsds', 'service', 'C128', 1, 2, 0, 0, 0, 0, 66, 0, NULL, 55, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202405070422511.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-07 16:22:51', '2024-05-07 16:22:51'),
(29, 'Baby Shoes', NULL, NULL, '13103887', 'standard', 'C128', 1, 4, 2, 2, 2, 500, 600, 0, 6, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Size\",\"Pattern\"]', '[\"m,l,xl\",\"blue patern,Red Patern\"]', 1, '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(30, 'Samsung Galaxy F23 5G RAM 6GB ROM 128GB', NULL, NULL, '97866032', 'standard', 'C128', 3, 11, 2, 2, 2, 30000, 34000, 75, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202405091215401.png', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-09 00:15:40', '2024-09-28 12:48:52'),
(31, 'Polo Shirt', NULL, NULL, '54419832', 'standard', 'C128', 2, 2, 2, 2, 2, 160, 200, 103, NULL, NULL, NULL, NULL, '2024-05-12', NULL, NULL, 1, 'demo_202405120609431.jpg', NULL, 0, 1, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Size-color\"]', '[\"M-Black,L-Blue,XL-Red\"]', 1, '2024-05-12 18:09:43', '2024-09-01 11:46:59'),
(32, 'Tiles RE', NULL, NULL, '72053232', 'standard', 'C128', 4, 21, 2, 8, 8, 100, 120, 891, 50, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202405191149241.jpg', NULL, 0, NULL, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-05-19 11:49:24', '2024-05-19 12:13:22'),
(33, 'Livelynine Tiles', NULL, NULL, '15903853', 'standard', 'C128', 4, 21, 2, 8, 8, 20, 30, 110, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202405191217061.jpg', NULL, 0, 1, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"Color\"]', '[\"Grey,White Peel,Tile Marble Viny\"]', 1, '2024-05-19 12:17:06', '2024-07-30 16:48:37'),
(34, 'single ignation', NULL, NULL, '62006281', 'standard', 'C128', 4, 23, 2, 2, 2, 125, 130, 480, 50, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202405200220011.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-20 14:20:01', '2024-09-17 16:16:17'),
(35, 'Rangia Bahar', NULL, NULL, '31644529', 'standard', 'C128', NULL, 2, 2, 2, 2, 300, 500, 484, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202405210500271.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-21 17:00:28', '2024-09-29 15:36:14'),
(36, '12w AC/DC', NULL, NULL, '79581658', 'standard', 'C128', 5, 26, 2, 2, 2, 480, 518, 96, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202405251020411.png', NULL, 0, NULL, NULL, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-25 22:20:41', '2024-09-29 15:36:14'),
(37, 'Walton 180 lt frize', NULL, NULL, '91057232', 'standard', 'C128', 7, 2, 2, 2, 2, 25000, 28000, 15, 5, 18, NULL, NULL, '2024-05-28', NULL, NULL, 1, 'demo_202405280453001.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-05-28 16:53:00', '2024-09-15 17:25:08'),
(38, 'GPS Non Voice Monthly Package', NULL, NULL, '04361461', 'service', 'C128', 8, 28, 0, 0, 0, 0, 300, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-05 12:05:38', '2024-06-05 12:05:38'),
(39, 'Outerside', NULL, NULL, '46928536', 'standard', 'C128', 9, 29, 4, 4, 4, 80, 102, 115, 22, NULL, NULL, NULL, '2024-06-05', NULL, NULL, 1, 'demo_202406051016061.jpeg', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '[\"color\"]', '[\"Silver,Browns,Matik\"]', 1, '2024-06-05 22:16:06', '2024-09-01 11:59:02'),
(40, 'Troximity Sensor', NULL, NULL, '48261175', 'standard', 'C128', 10, 30, 2, 2, 2, 1200, 1250, 44, 10, 5, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202406100247481.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-10 14:47:48', '2024-09-15 14:55:55'),
(41, 'Power Supply', NULL, NULL, '32310530', 'standard', 'C128', 10, 30, 2, 2, 2, 8000, 10500, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-10 16:15:23', '2024-07-13 18:32:26'),
(42, 'Miniket Chal 28', NULL, NULL, '98007162', 'standard', 'C128', 11, 31, 1, 10, 10, 3000, 3500, 1.2, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-06-23 11:27:22', '2024-07-30 16:42:25'),
(43, 'Napa Extra Tablet', NULL, NULL, '12920150', 'standard', 'C128', 12, 34, 2, 2, 2, 0.5, 1, 1383, 50, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202407060102041.png', NULL, 0, NULL, 1, 0, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-07-06 13:02:04', '2024-09-30 18:18:41'),
(44, 'Vivo y21', NULL, NULL, '14861490', 'standard', 'C128', 2, 11, 2, 2, 2, 9000, 12000, 0, NULL, 11, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202407300228081.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-07-30 14:28:08', '2024-07-30 14:28:08'),
(45, 'T-shirt', NULL, NULL, '75896333', 'standard', 'C128', NULL, 2, 2, 2, 2, 120, 250, 0, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-07-31 13:55:42', '2024-07-31 13:55:42'),
(46, 'Quran', NULL, NULL, '43815599', 'standard', 'C128', 3, 6, 4, 4, 4, 200, 400, 0, 5, 2, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202408090121261.jpg,demo_202408090121262.jpg,demo_202408090121263.jpg,demo_202408090121274.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<p>Hello I love you too baby girl I love you too 💋 💋 you too baby girl I love you too baby&nbsp;</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-08-09 13:21:27', '2024-08-09 13:21:27'),
(47, 'Filter Setup Services', NULL, NULL, '73311562', 'service', 'C128', NULL, 36, 0, 0, 0, 0, 500, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202408161206071.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<p>Filter Service means&nbsp;<strong>the removal of used air filters from the Facility; furnishing and installing new factory air filters and vacuuming of the filter plenums</strong>. Replace and repair broken holding clips within the filter chamber.</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-08-16 00:06:08', '2024-08-16 00:06:08'),
(48, 'Avatech 18650 Battery Charger Universal Smart USB Chargering for Rechargeable Lithium Battery', NULL, NULL, '07991836', 'standard', 'C128', NULL, 10, 2, 2, 2, 70, 100, 47, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202408280808271.png', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<h2 class=@pdp-mod-section-title outer-title@ data-spm-anchor-id=@a2a0e.pdp_revamp.0.i2.704d32a9WVVWMy@>Product details of Avatech 18650 Battery Charger Universal Smart USB Chargering for Rechargeable Lithium Battery Charger Li-ion 18650 26650 14500 17670</h2>\r\n<div class=@pdp-product-detail@ data-spm=@product_detail@>\r\n<div class=@pdp-product-desc height-limit@>\r\n<div class=@html-content pdp-product-highlights@>\r\n<ul class=@@>\r\n<li class=@@>Material: ABS</li>\r\n<li class=@@>Input: dc 5v</li>\r\n<li class=@@>Output: 4.2v/500ma</li>\r\n<li class=@@>Compatible batteries: 3.7V/3.8V lithium-ion battery (26650 / 18650 / 18500 /18350 / 17670 / 16340 /14500 / 10440).</li>\r\n<li class=@@>Features: fast charging, overcharge protection,.</li>\r\n<li class=@@>Description.100% brand new and high quality.</li>\r\n<li class=@@>Made of fireproof board and flame retardant plastic, safe and durable.Small and lightweight, plug and play, simple to use.</li>\r\n<li class=@@>With LED indicator, red light on when charging, green light on when fully charged.</li>\r\n</ul>\r\n</div>\r\n</div>\r\n</div>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-08-28 20:08:27', '2024-08-29 11:49:33'),
(49, 'aarong cap', NULL, NULL, '455455', 'standard', 'UPCA', 7, 10, 2, 2, 2, 5000, 6000, 43, 2, NULL, 1, '5500', '2024-08-30', '2024-09-03', NULL, 1, 'demo_202408291222081.jpg', NULL, 0, NULL, NULL, 0, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<p>gosdkfiwafgqqojFIOYOHPL;Fjiuryhqegolkdhncjkvhauiodfghqih</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-08-29 00:22:09', '2024-08-29 00:49:32'),
(50, 'Fresh Oil Parn 1 Litter', NULL, NULL, '29611927', 'standard', 'C128', NULL, 3, 2, 2, 2, 400, 500, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-01 09:11:21', '2024-09-01 09:11:21'),
(51, 'fish', NULL, NULL, '73086824', 'standard', 'C128', NULL, 38, 1, 1, 1, 120, 150, 0, 100, 10, NULL, NULL, NULL, NULL, 1, 1, 'demo_202409011132252.jpg', NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-01 11:31:41', '2024-09-01 11:32:54'),
(52, 'Metador Hi School Pen', NULL, NULL, 'NLNC-1', 'standard', 'C128', NULL, 2, 2, 2, 2, 4.75, 5, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-02 09:02:55', '2024-09-02 09:02:55'),
(53, 'Fresh Water', NULL, NULL, '69072571', 'standard', 'C128', NULL, 40, 11, 11, 11, 35, 40, 1438, 2, 20, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202409021134581.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<p>it is pure water</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-02 11:34:58', '2024-09-27 16:18:08'),
(54, 'Mum Water', NULL, NULL, '91654014', 'standard', 'C128', 15, 40, 11, 11, 11, 32, 40, 948, 2, 20, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202409021137131.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<p>it,s totally pure water</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-02 11:37:13', '2024-09-24 13:23:29'),
(55, 'kinley Water', NULL, NULL, '06940230', 'standard', 'C128', 15, 40, 11, 11, 11, 30, 35, 0, 2, NULL, 1, '-3', '2024-09-02', NULL, NULL, 1, 'demo_202409021140221.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '<p>kinley is supper pure water</p>', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-02 11:40:22', '2024-09-02 11:40:22'),
(56, 'fresh', NULL, NULL, '19253768', 'standard', 'C128', NULL, 40, 11, 11, 11, 30, 40, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202409020459371.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-02 16:59:37', '2024-09-02 16:59:37'),
(57, 'FM Nebu', NULL, NULL, '53200011', 'standard', 'C128', NULL, 41, 2, 2, 2, 1300, 1350, 58, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202409090147201.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-09 13:47:20', '2024-09-11 12:06:07'),
(58, 'car for 2 bettary', NULL, NULL, '43868571', 'standard', 'C128', 7, 43, 2, 2, 2, 415, 450, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202409090245321.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-09 14:45:32', '2024-09-09 14:45:32'),
(59, 'Robot toys', NULL, NULL, '93830687', 'standard', 'C128', 7, 43, 2, 2, 2, 590, 650, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202409090247221.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-09 14:47:22', '2024-09-12 21:27:50'),
(60, 'jef car (Black)', NULL, NULL, '54123317', 'standard', 'C128', 7, 43, 2, 2, 2, 445, 490, 92, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'demo_202409090248571.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-09 14:48:57', '2024-09-12 21:27:50'),
(61, 'medtedch', NULL, NULL, '23993827', 'standard', 'C128', NULL, 2, 2, 2, 2, 1330, 1440, 57, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-09 19:06:11', '2024-10-01 12:00:49'),
(62, 'medtech', NULL, NULL, '24572364', 'standard', 'C128', 16, 41, 2, 2, 2, 1300, 1350, 0, 50, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-11 11:50:41', '2024-09-11 11:50:41'),
(63, 'welmed nebulizar', NULL, NULL, '59132480', 'standard', 'C128', 1, 2, 2, 2, 2, 1250, 1280, 4, 50, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-11 12:27:02', '2024-10-01 12:00:49'),
(64, 'safe accu', NULL, NULL, '91504782', 'standard', 'C128', 1, 2, 2, 2, 2, 800, 82020, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-09-11 15:43:58', '2024-09-11 15:46:08'),
(65, 'safe accu', NULL, NULL, '65092721', 'standard', 'C128', 2, 2, 2, 2, 2, 800, 820, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-11 15:51:45', '2024-09-11 15:51:45'),
(66, 'camera', NULL, NULL, '101', 'digital', 'C128', 16, 37, 0, 0, 0, 0, 15000, 0, NULL, 0, NULL, NULL, '2024-09-11', NULL, NULL, 1, 'demo_202409111146391.jpg', '1726076799.jpg', 1, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-11 23:46:39', '2024-09-11 23:46:39'),
(67, 'matress', NULL, NULL, '69094620', 'standard', 'C128', 17, 10, 2, 2, 2, 2100, 2250, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-14 19:20:59', '2024-09-14 19:20:59'),
(68, 'Cash Taka', NULL, NULL, '12212122121', 'standard', 'C128', NULL, 36, 1, 1, 1, 1, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-14 22:17:40', '2024-09-14 22:17:40'),
(69, 'double head machine', NULL, NULL, '18029568', 'standard', 'C128', 8, 45, 2, 2, 2, 1300, 1320, 3, 1450, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-15 11:59:02', '2024-10-01 11:58:25'),
(70, 'tanita650', NULL, NULL, '25436699', 'standard', 'C128', 10, 46, 2, 2, 2, 1450, 1480, 86, 50, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-15 14:24:05', '2024-09-15 14:49:38'),
(71, 'save nebulizar', NULL, NULL, '35179626', 'standard', 'C128', 3, 2, 2, 2, 2, 1300, 1400, 12, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-17 10:45:13', '2024-09-29 13:52:29'),
(72, 'kindly 5 litter', NULL, NULL, '24959985', 'standard', 'C128', 5, 1, 11, 11, 11, 50, 55, 100, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-17 16:24:11', '2024-09-17 16:24:47'),
(73, 'tanita 880', NULL, NULL, '44665132', 'standard', 'C128', 7, 48, 2, 2, 2, 1350, 1420, 85, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-21 11:38:17', '2024-09-27 16:13:57'),
(74, 'alp  2k', NULL, NULL, '00689301', 'standard', 'C128', 2, 2, 2, 2, 2, 1200, 1600, 96, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-21 12:24:17', '2024-09-21 12:30:56'),
(75, 'rionet', NULL, NULL, '54579092', 'standard', 'C128', 3, 2, 2, 2, 2, 800, 1200, 0, 10, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-21 12:38:23', '2024-09-21 12:41:08'),
(76, 'fency panjabhi', NULL, NULL, '58243832', 'standard', 'C128', 2, 51, 2, 2, 2, 2000, 2500, 105, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-24 13:36:37', '2024-09-24 14:04:32'),
(77, 'Panjabi Print', NULL, NULL, '34203191', 'standard', 'C128', NULL, 51, 2, 2, 2, 800, 1000, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-24 14:00:52', '2024-09-24 14:04:32'),
(78, 'vibro shape messager', NULL, NULL, '00379912', 'standard', 'C128', 18, 52, 2, 2, 2, 1450, 1480, 14, 5, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-25 13:05:53', '2024-09-25 13:10:54'),
(79, 'Baby Cloth', NULL, NULL, '111111', 'standard', 'UPCA', 17, 53, 2, 2, 2, 500, 650, 199, 100, 20, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-28 11:19:23', '2024-09-29 13:25:09'),
(80, 'wellmed weight scale', NULL, NULL, '83969717', 'standard', 'C128', 3, 55, 2, 2, 2, 650, 1050, 45, 20, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'zummXD2dvAtI.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-29 12:31:13', '2024-09-29 12:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_adjustments`
--

CREATE TABLE `product_adjustments` (
  `id` int(10) UNSIGNED NOT NULL,
  `adjustment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `unit_cost` double DEFAULT NULL,
  `qty` double NOT NULL,
  `action` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_adjustments`
--

INSERT INTO `product_adjustments` (`id`, `adjustment_id`, `product_id`, `variant_id`, `unit_cost`, `qty`, `action`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, 65, 2, '-', '2024-04-07 03:04:16', '2024-04-07 03:04:16'),
(2, 2, 54, NULL, 32, 1000, '-', '2024-09-02 13:01:43', '2024-09-02 13:01:43'),
(3, 3, 53, NULL, 35, 110, '-', '2024-09-02 13:03:20', '2024-09-02 13:03:20'),
(4, 4, 53, NULL, 35, 1, '-', '2024-09-02 13:03:40', '2024-09-02 13:03:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_batches`
--

CREATE TABLE `product_batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `expired_date` date NOT NULL,
  `qty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_batches`
--

INSERT INTO `product_batches` (`id`, `product_id`, `batch_no`, `expired_date`, `qty`, `created_at`, `updated_at`) VALUES
(1, 43, '1720', '2025-07-17', 0, '2024-07-06 16:54:17', '2024-07-06 17:02:40'),
(2, 43, '1721', '2024-07-07', 1083, '2024-07-06 16:59:17', '2024-09-30 18:18:41'),
(3, 43, '2230', '2025-11-28', 300, '2024-09-29 12:07:46', '2024-09-29 12:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchases`
--

CREATE TABLE `product_purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_batch_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `imei_number` text DEFAULT NULL,
  `qty` double NOT NULL,
  `recieved` double NOT NULL,
  `purchase_unit_id` int(11) NOT NULL,
  `net_unit_cost` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchases`
--

INSERT INTO `product_purchases` (`id`, `purchase_id`, `product_id`, `product_batch_id`, `variant_id`, `imei_number`, `qty`, `recieved`, `purchase_unit_id`, `net_unit_cost`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, 10000, 10000, 1, 65, 0, 0, 0, 650000, '2024-04-01 10:11:27', '2024-04-01 10:11:27'),
(2, 2, 2, NULL, NULL, NULL, 10, 10, 2, 100, 0, 0, 0, 1000, '2024-04-07 02:22:27', '2024-04-07 02:22:27'),
(3, 3, 1, NULL, NULL, NULL, 30, 30, 1, 65, 0, 0, 0, 1950, '2024-04-18 19:16:26', '2024-04-18 19:16:26'),
(4, 4, 2, NULL, NULL, NULL, 50, 50, 2, 100, 0, 0, 0, 5000, '2024-04-21 18:04:46', '2024-04-21 18:04:46'),
(5, 5, 3, NULL, NULL, NULL, 10, 10, 2, 500, 0, 0, 0, 5000, '2024-04-22 20:11:22', '2024-04-22 20:11:22'),
(6, 6, 4, NULL, 2, NULL, 20, 20, 2, 13599, 0, 0, 0, 271980, '2024-04-23 10:54:31', '2024-04-23 10:54:31'),
(7, 6, 4, NULL, 1, NULL, 20, 20, 2, 13599, 0, 0, 0, 271980, '2024-04-23 10:54:31', '2024-04-23 10:54:31'),
(8, 7, 5, NULL, 5, NULL, 20, 20, 2, 40500, 0, 0, 0, 810000, '2024-04-23 10:59:15', '2024-04-23 10:59:15'),
(9, 7, 5, NULL, 4, NULL, 10, 10, 2, 40500, 0, 0, 0, 405000, '2024-04-23 10:59:15', '2024-04-23 10:59:15'),
(10, 7, 5, NULL, 3, NULL, 10, 10, 2, 40500, 0, 0, 0, 405000, '2024-04-23 10:59:15', '2024-04-23 10:59:15'),
(11, 8, 7, NULL, NULL, NULL, 40, 40, 2, 300, 0, 0, 0, 12000, '2024-04-23 11:08:12', '2024-04-23 11:08:12'),
(12, 9, 26, NULL, 9, NULL, 20, 20, 2, 5000, 0, 0, 0, 100000, '2024-05-01 17:46:39', '2024-05-01 17:46:39'),
(13, 9, 26, NULL, 8, NULL, 10, 10, 2, 2500, 0, 0, 0, 25000, '2024-05-01 17:46:39', '2024-05-01 17:46:39'),
(14, 10, 26, NULL, 8, NULL, 2, 2, 2, 2250, 500, 0, 0, 4500, '2024-05-01 17:49:51', '2024-05-01 17:49:51'),
(15, 10, 26, NULL, 9, NULL, 5, 5, 2, 5000, 0, 0, 0, 25000, '2024-05-01 17:49:51', '2024-05-01 17:49:51'),
(16, 11, 27, NULL, 10, NULL, 4, 4, 2, 100, 0, 0, 0, 400, '2024-05-04 16:22:35', '2024-05-04 16:22:35'),
(17, 11, 27, NULL, 11, NULL, 4, 4, 2, 100, 0, 0, 0, 400, '2024-05-04 16:22:35', '2024-05-04 16:22:35'),
(18, 11, 27, NULL, 12, NULL, 4, 4, 2, 100, 0, 0, 0, 400, '2024-05-04 16:22:35', '2024-05-04 16:22:35'),
(19, 11, 27, NULL, 13, NULL, 4, 4, 2, 100, 0, 0, 0, 400, '2024-05-04 16:22:35', '2024-05-04 16:22:35'),
(20, 12, 30, NULL, NULL, NULL, 100, 100, 2, 30000, 0, 0, 0, 3000000, '2024-05-09 00:15:40', '2024-05-09 00:15:40'),
(21, 13, 30, NULL, NULL, NULL, 50, 50, 2, 30000, 0, 0, 0, 1500000, '2024-05-09 00:15:40', '2024-05-09 00:15:40'),
(28, 14, 31, NULL, 23, NULL, 5, 5, 2, 160, 0, 0, 0, 800, '2024-05-16 11:19:31', '2024-05-16 11:19:31'),
(29, 14, 31, NULL, 22, NULL, 6, 6, 2, 160, 0, 0, 0, 960, '2024-05-16 11:19:31', '2024-05-16 11:19:31'),
(30, 14, 31, NULL, 21, NULL, 10, 10, 2, 160, 0, 0, 0, 1600, '2024-05-16 11:19:31', '2024-05-16 11:19:31'),
(31, 14, 31, NULL, 20, NULL, 10, 10, 2, 160, 0, 0, 0, 1600, '2024-05-16 11:19:31', '2024-05-16 11:19:31'),
(32, 14, 31, NULL, 24, NULL, 2, 2, 2, 160, 0, 0, 0, 320, '2024-05-16 11:19:31', '2024-05-16 11:19:31'),
(33, 16, 32, NULL, NULL, NULL, 1000, 1000, 2, 100, 0, 0, 0, 100000, '2024-05-19 11:50:14', '2024-05-19 11:50:14'),
(34, 17, 33, NULL, 27, NULL, 2, 2, 8, 500, 0, 0, 0, 1000, '2024-05-19 12:22:10', '2024-05-19 12:22:10'),
(35, 17, 33, NULL, 26, NULL, 1, 1, 8, 500, 0, 0, 0, 500, '2024-05-19 12:22:10', '2024-05-19 12:22:10'),
(36, 17, 33, NULL, 25, NULL, 1, 1, 8, 500, 0, 0, 0, 500, '2024-05-19 12:22:10', '2024-05-19 12:22:10'),
(37, 18, 33, NULL, 25, NULL, 2.5, 2.5, 8, 500, 0, 0, 0, 1250, '2024-05-19 13:21:23', '2024-05-19 13:21:23'),
(38, 19, 34, NULL, NULL, NULL, 500, 500, 2, 125, 0, 0, 0, 62500, '2024-05-20 14:21:15', '2024-05-20 14:21:15'),
(39, 20, 2, NULL, NULL, NULL, 1, 1, 2, 100, 0, 0, 0, 100, '2024-05-21 17:02:05', '2024-05-21 17:02:05'),
(40, 20, 35, NULL, NULL, NULL, 500, 500, 2, 300, 0, 0, 0, 150000, '2024-05-21 17:02:05', '2024-05-21 17:02:05'),
(41, 21, 31, NULL, 22, NULL, 5, 5, 2, 160, 0, 0, 0, 800, '2024-05-23 11:26:30', '2024-05-23 11:26:30'),
(42, 21, 31, NULL, 21, NULL, 10, 10, 2, 160, 0, 0, 0, 1600, '2024-05-23 11:26:30', '2024-05-23 11:26:30'),
(43, 22, 8, NULL, NULL, NULL, 2, 2, 2, 2000, 0, 0, 0, 4000, '2024-05-25 22:31:23', '2024-05-25 22:31:23'),
(44, 22, 36, NULL, NULL, NULL, 120, 120, 2, 475, 0, 0, 0, 57000, '2024-05-25 22:31:23', '2024-05-25 22:31:23'),
(45, 23, 37, NULL, NULL, NULL, 1, 1, 2, 25000, 0, 0, 0, 25000, '2024-05-28 16:55:29', '2024-05-28 16:55:29'),
(46, 24, 37, NULL, NULL, NULL, 10, 10, 2, 25000, 0, 0, 0, 250000, '2024-05-28 16:57:36', '2024-05-28 16:57:36'),
(47, 25, 9, NULL, NULL, NULL, 3, 3, 2, 2500, 0, 0, 0, 7500, '2024-06-01 18:42:17', '2024-06-01 18:42:17'),
(48, 25, 7, NULL, NULL, NULL, 5, 5, 2, 300, 0, 0, 0, 1500, '2024-06-01 18:42:17', '2024-06-01 18:42:17'),
(49, 26, 36, NULL, NULL, NULL, 2, 2, 2, 470, 0, 0, 0, 940, '2024-06-01 18:43:42', '2024-06-01 18:43:42'),
(50, 27, 39, NULL, 29, NULL, 120, 120, 4, 80, 0, 0, 0, 9600, '2024-06-05 22:19:16', '2024-06-05 22:19:16'),
(51, 27, 39, NULL, 28, NULL, 21, 21, 4, 80, 0, 0, 0, 1680, '2024-06-05 22:19:16', '2024-06-05 22:19:16'),
(52, 27, 39, NULL, 4, NULL, 18, 18, 4, 80, 0, 0, 0, 1440, '2024-06-05 22:19:16', '2024-06-05 22:19:16'),
(54, 29, 40, NULL, NULL, NULL, 10, 10, 2, 1200, 0, 0, 0, 12000, '2024-06-10 15:25:18', '2024-06-10 15:25:18'),
(55, 28, 40, NULL, NULL, NULL, 40, 40, 2, 1200, 0, 0, 0, 48000, '2024-06-10 15:26:18', '2024-06-10 15:26:18'),
(56, 30, 41, NULL, NULL, NULL, 20, 20, 2, 8000, 0, 0, 0, 160000, '2024-06-10 16:16:25', '2024-06-10 16:16:25'),
(58, 32, 42, NULL, NULL, NULL, 10, 10, 10, 60, 0, 0, 0, 600, '2024-06-23 11:36:20', '2024-06-23 11:36:20'),
(61, 34, 5, NULL, 5, NULL, 2, 2, 2, 40500, 0, 0, 0, 81000, '2024-07-02 20:25:49', '2024-07-02 20:25:49'),
(62, 34, 5, NULL, 4, NULL, 5, 5, 2, 40000, 0, 0, 0, 200000, '2024-07-02 20:25:49', '2024-07-02 20:25:49'),
(63, 35, 1, NULL, NULL, NULL, 10, 10, 1, 65, 0, 0, 0, 650, '2024-07-05 16:04:34', '2024-07-05 16:04:34'),
(64, 36, 43, 1, NULL, NULL, 3200, 3200, 2, 0.5, 0, 0, 0, 1600, '2024-07-06 16:54:17', '2024-07-06 16:54:17'),
(65, 37, 43, 2, NULL, NULL, 1200, 1200, 2, 0.5, 0, 0, 0, 600, '2024-07-06 16:59:17', '2024-07-06 16:59:17'),
(66, 38, 43, 1, NULL, NULL, 1, 1, 2, 0.5, 0, 0, 0, 0.5, '2024-07-06 16:59:56', '2024-07-06 16:59:56'),
(67, 39, 43, 1, NULL, NULL, 1000, 1000, 2, 0.5, 0, 0, 0, 500, '2024-07-06 17:01:06', '2024-07-06 17:01:06'),
(68, 40, 31, NULL, 24, NULL, 50, 50, 2, 162, 0, 0, 0, 8100, '2024-07-13 18:27:03', '2024-07-13 18:27:03'),
(69, 40, 31, NULL, 21, NULL, 20, 20, 2, 160, 0, 0, 0, 3200, '2024-07-13 18:27:03', '2024-07-13 18:27:03'),
(70, 41, 1, NULL, NULL, NULL, 100, 100, 1, 65, 0, 0, 0, 6500, '2024-07-15 21:57:39', '2024-07-15 21:57:39'),
(71, 42, 2, NULL, NULL, NULL, 20, 20, 2, 100, 0, 0, 0, 2000, '2024-07-15 21:57:59', '2024-07-15 21:57:59'),
(72, 33, 11, NULL, NULL, NULL, 50, 50, 1, 450, 2500, 0, 0, 22500, '2024-07-30 16:41:47', '2024-07-30 16:41:47'),
(73, 33, 9, NULL, NULL, NULL, 50, 50, 2, 2500, 0, 0, 0, 125000, '2024-07-30 16:41:47', '2024-07-30 16:41:47'),
(74, 31, 42, NULL, NULL, NULL, 50, 50, 10, 0.02, 0, 0, 0, 1.2, '2024-07-30 16:42:25', '2024-07-30 16:42:25'),
(75, 43, 48, NULL, NULL, '324234234', 50, 50, 2, 70, 0, 0, 0, 3500, '2024-08-28 20:11:56', '2024-08-28 20:11:56'),
(76, 44, 49, NULL, NULL, NULL, 50, 50, 2, 5000, 0, 0, 0, 250000, '2024-08-29 00:32:46', '2024-08-29 00:32:46'),
(77, 45, 4, NULL, 2, NULL, 2, 2, 2, 13599, 0, 0, 0, 27198, '2024-09-01 14:14:39', '2024-09-01 14:14:39'),
(78, 46, 54, NULL, NULL, NULL, 600, 600, 11, 32, 0, 0, 0, 19200, '2024-09-02 12:48:07', '2024-09-02 12:48:07'),
(79, 47, 53, NULL, NULL, NULL, 550, 550, 11, 35, 0, 0, 0, 19250, '2024-09-02 12:48:56', '2024-09-02 12:48:56'),
(80, 48, 54, NULL, NULL, NULL, 1000, 1000, 11, 32, 0, 0, 0, 32000, '2024-09-02 12:50:39', '2024-09-02 12:50:39'),
(81, 49, 54, NULL, NULL, NULL, 20, 20, 11, 32, 0, 0, 0, 640, '2024-09-02 13:13:33', '2024-09-02 13:13:33'),
(82, 50, 53, NULL, NULL, NULL, 6, 0, 11, 35, 0, 0, 0, 210, '2024-09-02 14:44:02', '2024-09-02 14:44:02'),
(83, 51, 53, NULL, NULL, NULL, 15, 15, 11, 35, 0, 0, 0, 525, '2024-09-02 15:08:05', '2024-09-02 15:08:05'),
(84, 52, 53, NULL, NULL, NULL, 1000, 1000, 11, 35, 0, 0, 0, 35000, '2024-09-02 17:01:36', '2024-09-02 17:01:36'),
(85, 53, 1, NULL, NULL, NULL, 10, 10, 1, 65, 0, 0, 0, 650, '2024-09-05 12:51:15', '2024-09-05 12:51:15'),
(86, 53, 54, NULL, NULL, NULL, 100, 100, 11, 35, 0, 0, 0, 3500, '2024-09-05 12:51:15', '2024-09-05 12:51:15'),
(87, 54, 15, NULL, NULL, NULL, 6, 6, 2, 10000, 0, 0, 0, 60000, '2024-09-08 13:13:32', '2024-09-08 13:13:32'),
(88, 54, 2, NULL, NULL, NULL, 2, 2, 2, 100, 0, 0, 0, 200, '2024-09-08 13:13:32', '2024-09-08 13:13:32'),
(89, 55, 57, NULL, NULL, NULL, 100, 100, 2, 1300, 0, 0, 0, 130000, '2024-09-09 13:55:12', '2024-09-09 13:55:12'),
(90, 56, 59, NULL, NULL, NULL, 50, 50, 2, 590, 0, 0, 0, 29500, '2024-09-09 15:09:41', '2024-09-09 15:09:41'),
(91, 57, 60, NULL, NULL, NULL, 50, 50, 2, 445, 0, 0, 0, 22250, '2024-09-09 15:10:39', '2024-09-09 15:10:39'),
(92, 58, 60, NULL, NULL, NULL, 50, 50, 2, 445, 0, 0, 0, 22250, '2024-09-09 15:11:35', '2024-09-09 15:11:35'),
(93, 59, 61, NULL, NULL, NULL, 5, 5, 2, 1330, 0, 0, 0, 6650, '2024-09-09 20:10:26', '2024-09-09 20:10:26'),
(94, 60, 61, NULL, NULL, NULL, 100, 100, 2, 1330, 0, 0, 0, 133000, '2024-09-11 11:52:55', '2024-09-11 11:52:55'),
(95, 61, 8, NULL, NULL, NULL, 1, 1, 2, 2000, 0, 0, 0, 2000, '2024-09-14 09:43:01', '2024-09-14 09:43:01'),
(96, 61, 7, NULL, NULL, NULL, 1, 1, 2, 300, 0, 0, 0, 300, '2024-09-14 09:43:01', '2024-09-14 09:43:01'),
(97, 61, 1, NULL, NULL, NULL, 1, 1, 1, 65, 0, 0, 0, 65, '2024-09-14 09:43:01', '2024-09-14 09:43:01'),
(98, 62, 18, NULL, NULL, NULL, 3, 3, 2, 900, 0, 0, 0, 2700, '2024-09-14 17:50:17', '2024-09-14 17:50:17'),
(99, 62, 15, NULL, NULL, NULL, 1, 1, 2, 10000, 0, 0, 0, 10000, '2024-09-14 17:50:17', '2024-09-14 17:50:17'),
(100, 62, 1, NULL, NULL, NULL, 1, 1, 1, 65, 0, 0, 0, 65, '2024-09-14 17:50:17', '2024-09-14 17:50:17'),
(101, 63, 8, NULL, NULL, NULL, 1, 1, 2, 2000, 0, 0, 0, 2000, '2024-09-14 18:18:45', '2024-09-14 18:18:45'),
(102, 64, 69, NULL, NULL, NULL, 17, 17, 2, 1400, 0, 0, 0, 23800, '2024-09-15 12:01:35', '2024-09-15 12:01:35'),
(103, 65, 8, NULL, NULL, NULL, 5, 5, 2, 2000, 0, 0, 0, 10000, '2024-09-15 14:47:01', '2024-09-15 14:47:01'),
(104, 66, 70, NULL, NULL, NULL, 100, 100, 2, 1450, 0, 0, 0, 145000, '2024-09-15 14:48:05', '2024-09-15 14:48:05'),
(105, 67, 1, NULL, NULL, NULL, 100, 100, 1, 65, 0, 0, 0, 6500, '2024-09-15 17:25:08', '2024-09-15 17:25:08'),
(106, 67, 37, NULL, NULL, NULL, 10, 10, 2, 25000, 0, 0, 0, 250000, '2024-09-15 17:25:08', '2024-09-15 17:25:08'),
(107, 68, 71, NULL, NULL, NULL, 14, 14, 2, 1300, 0, 0, 0, 18200, '2024-09-17 10:47:01', '2024-09-17 10:47:01'),
(108, 69, 72, NULL, NULL, NULL, 100, 100, 11, 50, 0, 0, 0, 5000, '2024-09-17 16:24:47', '2024-09-17 16:24:47'),
(109, 70, 73, NULL, NULL, NULL, 100, 100, 2, 1350, 0, 0, 0, 135000, '2024-09-21 11:41:12', '2024-09-21 11:41:12'),
(110, 71, 74, NULL, NULL, NULL, 100, 100, 2, 1200, 0, 0, 0, 120000, '2024-09-21 12:26:50', '2024-09-21 12:26:50'),
(111, 72, 75, NULL, NULL, NULL, 1, 1, 2, 800, 0, 0, 0, 800, '2024-09-21 12:39:36', '2024-09-21 12:39:36'),
(112, 73, 54, NULL, NULL, NULL, 100, 100, 11, 32, 0, 0, 0, 3200, '2024-09-21 17:09:33', '2024-09-21 17:09:33'),
(113, 74, 54, NULL, NULL, NULL, 1, 1, 11, 32, 0, 0, 0, 32, '2024-09-24 12:48:38', '2024-09-24 12:48:38'),
(114, 75, 54, NULL, NULL, NULL, 1, 1, 11, 32, 0, 0, 0, 32, '2024-09-24 12:56:54', '2024-09-24 12:56:54'),
(115, 76, 63, NULL, NULL, NULL, 10, 10, 2, 1250, 0, 0, 0, 12500, '2024-09-24 13:17:09', '2024-09-24 13:17:09'),
(116, 76, 54, NULL, NULL, NULL, 100, 100, 11, 32, 0, 0, 0, 3200, '2024-09-24 13:17:09', '2024-09-24 13:17:09'),
(117, 77, 54, NULL, NULL, NULL, 100, 100, 11, 32, 0, 0, 0, 3200, '2024-09-24 13:18:39', '2024-09-24 13:18:39'),
(118, 78, 76, NULL, NULL, NULL, 100, 100, 2, 2000, 0, 0, 0, 200000, '2024-09-24 13:37:47', '2024-09-24 13:37:47'),
(119, 79, 76, NULL, NULL, NULL, 5, 5, 2, 2000, 0, 0, 0, 10000, '2024-09-24 14:04:32', '2024-09-24 14:04:32'),
(120, 79, 77, NULL, NULL, NULL, 50, 50, 2, 850, 0, 0, 0, 42500, '2024-09-24 14:04:32', '2024-09-24 14:04:32'),
(121, 80, 78, NULL, NULL, NULL, 14, 14, 2, 1450, 0, 0, 0, 20300, '2024-09-25 13:10:54', '2024-09-25 13:10:54'),
(122, 81, 11, NULL, NULL, NULL, 10, 10, 1, 500, 0, 0, 0, 5000, '2024-09-26 17:01:21', '2024-09-26 17:01:21'),
(123, 81, 13, NULL, NULL, NULL, 1, 1, 1, 52, 0, 0, 0, 52, '2024-09-26 17:01:21', '2024-09-26 17:01:21'),
(125, 82, 79, NULL, NULL, NULL, 200, 200, 2, 500, 0, 0, 0, 100000, '2024-09-28 11:27:16', '2024-09-28 11:27:16'),
(126, 83, 11, NULL, NULL, NULL, 100, 100, 1, 450, 0, 0, 0, 45000, '2024-09-28 12:34:39', '2024-09-28 12:34:39'),
(127, 83, 12, NULL, NULL, NULL, 10, 10, 1, 100, 100, 0, 0, 1000, '2024-09-28 12:34:39', '2024-09-28 12:34:39'),
(128, 83, 8, NULL, NULL, NULL, 5, 5, 2, 2000, 0, 0, 0, 10000, '2024-09-28 12:34:39', '2024-09-28 12:34:39'),
(129, 84, 43, 3, NULL, NULL, 300, 300, 2, 0.5, 0, 0, 0, 150, '2024-09-29 12:07:46', '2024-09-29 12:07:46'),
(130, 85, 80, NULL, NULL, NULL, 50, 50, 2, 650, 0, 0, 0, 32500, '2024-09-29 12:32:45', '2024-09-29 12:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_quotation`
--

CREATE TABLE `product_quotation` (
  `id` int(10) UNSIGNED NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_batch_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `qty` double NOT NULL,
  `sale_unit_id` int(11) NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_quotation`
--

INSERT INTO `product_quotation` (`id`, `quotation_id`, `product_id`, `product_batch_id`, `variant_id`, `qty`, `sale_unit_id`, `net_unit_price`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(7, 4, 30, NULL, NULL, 2, 2, 34000, 0, 0, 0, 68000, '2024-05-24 13:59:50', '2024-05-24 13:59:50'),
(8, 5, 28, NULL, NULL, 1, 0, 66, 0, 0, 0, 66, '2024-06-01 15:12:15', '2024-06-01 15:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_returns`
--

CREATE TABLE `product_returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `return_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_batch_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `imei_number` text DEFAULT NULL,
  `qty` double NOT NULL,
  `sale_unit_id` int(11) NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_returns`
--

INSERT INTO `product_returns` (`id`, `return_id`, `product_id`, `product_batch_id`, `variant_id`, `imei_number`, `qty`, `sale_unit_id`, `net_unit_price`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL, NULL, 1, 1, 80, 0, 0, 0, 80, '2024-04-24 15:23:17', '2024-04-24 15:23:17'),
(2, 4, 3, NULL, NULL, NULL, 1, 2, 650, 0, 0, 0, 650, '2024-04-24 15:24:23', '2024-04-24 15:24:23'),
(3, 5, 27, NULL, 12, NULL, 1, 2, 200, 0, 0, 0, 200, '2024-05-04 16:37:58', '2024-05-04 16:37:58'),
(4, 6, 31, NULL, 23, NULL, 1, 2, 200, 0, 0, 0, 200, '2024-05-12 18:41:50', '2024-05-12 18:41:50'),
(5, 7, 1, NULL, NULL, NULL, 1, 1, 80, 0, 0, 0, 80, '2024-07-01 10:52:59', '2024-07-01 10:52:59'),
(8, 9, 48, NULL, NULL, '524647897954', 1, 2, 100, 0, 0, 0, 100, '2024-08-28 20:18:20', '2024-08-28 20:18:20'),
(9, 10, 40, NULL, NULL, NULL, 1, 2, 1250, 0, 0, 0, 1250, '2024-09-15 14:55:55', '2024-09-15 14:55:55'),
(10, 11, 53, NULL, NULL, NULL, 1, 11, 40, 0, 0, 0, 40, '2024-09-27 16:18:08', '2024-09-27 16:18:08'),
(11, 12, 9, NULL, NULL, NULL, 1, 2, 3500, 0, 0, 0, 3500, '2024-09-27 16:21:00', '2024-09-27 16:21:00'),
(12, 13, 30, NULL, NULL, '4353534567', 1, 2, 35000, 0, 0, 0, 35000, '2024-09-28 12:48:52', '2024-09-28 12:48:52'),
(13, 14, 1, NULL, NULL, NULL, 5, 1, 80, 0, 0, 0, 400, '2024-09-29 17:42:37', '2024-09-29 17:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `product_sales`
--

CREATE TABLE `product_sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_batch_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `imei_number` text DEFAULT NULL,
  `qty` double NOT NULL,
  `return_qty` double NOT NULL DEFAULT 0,
  `sale_unit_id` int(11) NOT NULL,
  `net_unit_price` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sales`
--

INSERT INTO `product_sales` (`id`, `sale_id`, `product_id`, `product_batch_id`, `variant_id`, `imei_number`, `qty`, `return_qty`, `sale_unit_id`, `net_unit_price`, `discount`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-03 01:42:48', '2024-04-03 01:42:48'),
(2, 2, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-03 01:43:54', '2024-04-03 01:43:54'),
(3, 3, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-03 01:45:08', '2024-04-03 01:45:08'),
(5, 5, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-04 01:03:01', '2024-04-04 01:03:01'),
(6, 6, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-04 01:03:30', '2024-04-04 01:03:30'),
(7, 7, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-04 01:09:23', '2024-04-04 01:09:23'),
(8, 8, 1, NULL, NULL, NULL, 2, 0, 1, 80, 0, 0, 0, 160, '2024-04-04 01:09:29', '2024-04-04 01:12:35'),
(9, 9, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-04-07 21:32:31', '2024-04-07 21:32:31'),
(10, 10, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-08 01:00:59', '2024-04-08 01:00:59'),
(11, 11, 2, NULL, NULL, NULL, 3, 0, 2, 120, 0, 0, 0, 360, '2024-04-18 19:19:19', '2024-04-18 19:19:19'),
(12, 11, 1, NULL, NULL, NULL, 8, 0, 1, 80, 0, 0, 0, 640, '2024-04-18 19:19:19', '2024-04-18 19:19:19'),
(13, 12, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-04-20 16:12:27', '2024-04-20 16:12:27'),
(14, 12, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-20 16:12:27', '2024-04-20 16:12:27'),
(15, 13, 1, NULL, NULL, NULL, 4, 0, 1, 80, 0, 0, 0, 320, '2024-04-20 17:56:21', '2024-04-20 17:56:21'),
(16, 14, 2, NULL, NULL, NULL, 2, 0, 2, 120, 0, 0, 0, 240, '2024-04-21 18:06:40', '2024-04-21 18:06:40'),
(17, 15, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-04-21 22:01:12', '2024-04-21 22:01:12'),
(18, 15, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-21 22:01:12', '2024-04-21 22:01:12'),
(19, 16, 3, NULL, NULL, NULL, 1, 0, 2, 600, 0, 0, 0, 600, '2024-04-22 20:13:33', '2024-04-22 20:13:33'),
(20, 17, 3, NULL, NULL, NULL, 2, 1, 2, 650, 0, 0, 0, 1300, '2024-04-22 20:15:42', '2024-04-24 15:24:23'),
(21, 18, 1, NULL, NULL, NULL, 1, 1, 1, 80, 0, 0, 0, 80, '2024-04-24 15:18:34', '2024-04-24 15:23:17'),
(22, 19, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-24 15:26:19', '2024-04-24 15:26:19'),
(23, 20, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-24 15:27:51', '2024-04-24 15:27:51'),
(24, 21, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-04-28 15:01:11', '2024-04-28 15:01:11'),
(25, 21, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-04-28 15:01:11', '2024-04-28 15:01:11'),
(26, 22, 26, NULL, 8, NULL, 2, 0, 2, 2575, 0, 0, 0, 5150, '2024-05-01 17:54:29', '2024-05-01 17:54:29'),
(27, 23, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-05-01 23:54:42', '2024-05-01 23:54:42'),
(28, 24, 27, NULL, 12, NULL, 1, 1, 2, 200, 0, 0, 0, 200, '2024-05-04 16:28:44', '2024-05-04 16:37:58'),
(29, 24, 27, NULL, 10, NULL, 1, 0, 2, 200, 0, 0, 0, 200, '2024-05-04 16:28:44', '2024-05-04 16:28:44'),
(30, 24, 27, NULL, 13, NULL, 3, 0, 2, 200, 0, 0, 0, 600, '2024-05-04 16:28:44', '2024-05-04 16:28:44'),
(31, 25, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-05-06 19:30:01', '2024-05-06 19:30:01'),
(32, 26, 1, NULL, NULL, NULL, 2, 0, 1, 80, 0, 0, 0, 160, '2024-05-06 23:11:34', '2024-05-06 23:11:34'),
(33, 27, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-05-07 20:44:46', '2024-05-07 20:44:46'),
(34, 28, 30, NULL, NULL, '6787686768876897979', 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-05-09 00:21:20', '2024-05-09 00:21:20'),
(35, 29, 30, NULL, NULL, '4567657568678979', 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-05-09 00:27:20', '2024-05-09 00:42:53'),
(36, 30, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-05-09 17:49:12', '2024-05-09 17:49:12'),
(37, 31, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-05-09 17:50:45', '2024-05-09 17:50:45'),
(40, 33, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-05-12 18:32:53', '2024-05-12 18:32:53'),
(41, 34, 31, NULL, 23, NULL, 3, 1, 2, 200, 0, 0, 0, 600, '2024-05-12 18:40:36', '2024-05-12 18:41:50'),
(45, 37, 1, NULL, NULL, NULL, 4, 0, 1, 80, 0, 0, 0, 320, '2024-05-19 11:53:10', '2024-05-19 11:53:10'),
(46, 37, 32, NULL, NULL, NULL, 109, 0, 2, 120, 0, 0, 0, 13080, '2024-05-19 11:53:10', '2024-05-19 11:53:10'),
(47, 38, 33, NULL, 26, NULL, 2, 0, 8, 750, 0, 0, 0, 0, '2024-05-19 13:15:21', '2024-05-19 13:15:21'),
(48, 39, 33, NULL, 26, NULL, 2, 0, 8, 750, 0, 0, 0, 0, '2024-05-19 13:15:34', '2024-05-19 13:15:34'),
(49, 40, 33, NULL, 25, NULL, 1.1, 0, 8, 750, 0, 0, 0, 825, '2024-05-19 13:17:00', '2024-05-19 13:17:00'),
(50, 41, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-05-20 14:25:56', '2024-05-20 14:25:56'),
(51, 41, 34, NULL, NULL, NULL, 10, 0, 2, 130, 0, 0, 0, 1300, '2024-05-20 14:25:56', '2024-05-20 14:25:56'),
(52, 42, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-05-21 17:05:59', '2024-05-21 17:05:59'),
(53, 43, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-05-21 17:07:58', '2024-05-21 17:07:58'),
(54, 44, 31, NULL, 22, NULL, 1, 0, 2, 200, 0, 0, 0, 200, '2024-05-23 11:28:18', '2024-05-23 11:28:18'),
(55, 45, 2, NULL, NULL, NULL, 2, 0, 2, 120, 0, 0, 0, 240, '2024-05-24 19:48:17', '2024-05-24 19:48:17'),
(56, 46, 7, NULL, NULL, NULL, 2, 0, 2, 450, 0, 0, 0, 900, '2024-05-25 11:45:12', '2024-05-25 11:45:12'),
(57, 47, 1, NULL, NULL, NULL, 2, 0, 1, 80, 0, 0, 0, 160, '2024-05-25 11:46:40', '2024-05-25 11:46:40'),
(58, 48, 36, NULL, NULL, NULL, 2, 0, 2, 510, 0, 0, 0, 1020, '2024-05-25 22:37:42', '2024-05-25 22:37:42'),
(59, 49, 8, NULL, NULL, NULL, 2, 0, 2, 3000, 0, 0, 0, 6000, '2024-05-25 22:41:14', '2024-05-25 22:41:14'),
(60, 49, 36, NULL, NULL, NULL, 3, 0, 2, 500, 0, 0, 0, 1500, '2024-05-25 22:41:14', '2024-05-25 22:41:14'),
(61, 50, 5, NULL, 5, NULL, 2, 0, 2, 42500, 0, 0, 0, 85000, '2024-05-25 22:49:27', '2024-05-25 22:49:27'),
(62, 50, 36, NULL, NULL, NULL, 3, 0, 2, 520, 0, 0, 0, 1560, '2024-05-25 22:49:27', '2024-05-25 22:49:27'),
(63, 51, 5, NULL, 5, NULL, 1, 0, 2, 42500, 0, 0, 0, 42500, '2024-05-28 16:59:39', '2024-05-28 16:59:39'),
(64, 51, 37, NULL, NULL, NULL, 1, 0, 2, 28000, 0, 0, 0, 28000, '2024-05-28 16:59:39', '2024-05-28 16:59:39'),
(65, 52, 37, NULL, NULL, NULL, 1, 0, 2, 28000, 0, 0, 0, 28000, '2024-05-28 17:26:29', '2024-05-28 17:26:29'),
(66, 53, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-05-31 00:15:20', '2024-05-31 00:15:20'),
(67, 54, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-05-31 00:16:39', '2024-05-31 00:16:39'),
(68, 55, 36, NULL, NULL, NULL, 2, 0, 2, 510, 0, 0, 0, 1020, '2024-06-01 18:47:03', '2024-06-01 18:47:03'),
(69, 56, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-06-04 14:20:48', '2024-06-04 14:20:48'),
(70, 57, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-06-05 11:31:30', '2024-06-05 11:31:30'),
(71, 58, 38, NULL, NULL, NULL, 1, 0, 0, 300, 0, 0, 0, 300, '2024-06-05 12:13:40', '2024-06-05 12:13:40'),
(72, 59, 39, NULL, 4, NULL, 21, 0, 4, 102, 0, 0, 0, 2142, '2024-06-05 22:28:00', '2024-06-05 22:28:00'),
(73, 59, 39, NULL, 29, NULL, 18, 0, 4, 102, 0, 0, 0, 1836, '2024-06-05 22:28:00', '2024-06-05 22:28:00'),
(74, 60, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-06-05 22:45:10', '2024-06-05 22:45:10'),
(75, 61, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-06-10 11:06:21', '2024-06-10 11:06:21'),
(76, 62, 7, NULL, NULL, NULL, 1, 0, 2, 450, 0, 0, 0, 450, '2024-06-10 11:17:51', '2024-06-10 11:17:51'),
(77, 63, 40, NULL, NULL, NULL, 5, 0, 2, 1250, 0, 0, 0, 6250, '2024-06-10 15:02:28', '2024-06-10 15:02:28'),
(78, 64, 41, NULL, NULL, NULL, 5, 0, 2, 10500, 0, 0, 0, 52500, '2024-06-10 16:18:04', '2024-06-10 16:18:04'),
(79, 65, 34, NULL, NULL, NULL, 1, 0, 2, 130, 0, 0, 0, 130, '2024-06-10 18:28:09', '2024-06-10 18:28:09'),
(80, 65, 36, NULL, NULL, NULL, 1, 0, 2, 510, 0, 0, 0, 510, '2024-06-10 18:28:09', '2024-06-10 18:28:09'),
(81, 65, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-06-10 18:28:09', '2024-06-10 18:28:09'),
(82, 66, 40, NULL, NULL, NULL, 1, 0, 2, 1250, 0, 0, 0, 1250, '2024-06-23 11:55:26', '2024-06-23 11:55:26'),
(83, 67, 2, NULL, NULL, NULL, 2, 0, 2, 120, 0, 0, 0, 240, '2024-06-30 16:44:02', '2024-06-30 16:44:02'),
(84, 67, 1, NULL, NULL, NULL, 8, 0, 1, 80, 0, 0, 0, 640, '2024-06-30 16:44:02', '2024-06-30 16:44:02'),
(85, 68, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-07-01 10:47:49', '2024-07-01 10:47:49'),
(86, 68, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-07-01 10:47:49', '2024-07-01 10:47:49'),
(87, 69, 1, NULL, NULL, NULL, 1, 1, 1, 80, 0, 0, 0, 80, '2024-07-01 10:49:05', '2024-07-01 10:52:59'),
(88, 70, 11, NULL, NULL, NULL, 1, 0, 1, 600, 0, 0, 0, 600, '2024-07-01 16:01:59', '2024-07-01 16:01:59'),
(89, 70, 36, NULL, NULL, NULL, 1, 0, 2, 510, 0, 0, 0, 510, '2024-07-01 16:01:59', '2024-07-01 16:01:59'),
(90, 71, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-07-02 20:08:55', '2024-07-02 20:08:55'),
(91, 72, 30, NULL, NULL, NULL, 2, 0, 2, 34000, 0, 0, 0, 68000, '2024-07-04 09:59:59', '2024-07-04 09:59:59'),
(92, 73, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-07-04 10:00:29', '2024-07-04 10:00:29'),
(93, 74, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-07-04 10:00:51', '2024-07-04 10:00:51'),
(94, 75, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-07-04 21:51:23', '2024-07-04 21:51:23'),
(95, 76, 34, NULL, NULL, NULL, 1, 0, 2, 130, 0, 0, 0, 130, '2024-07-05 16:05:18', '2024-07-05 16:05:18'),
(96, 76, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-07-05 16:05:18', '2024-07-05 16:05:18'),
(97, 77, 30, NULL, NULL, '68769798', 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-07-05 16:17:36', '2024-07-05 16:17:36'),
(98, 78, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-07-06 10:49:51', '2024-07-06 10:49:51'),
(99, 79, 43, 1, NULL, NULL, 12, 0, 2, 1, 0, 0, 0, 12, '2024-07-06 16:55:44', '2024-07-06 16:55:44'),
(100, 80, 43, 1, NULL, NULL, 12, 0, 2, 1, 0, 0, 0, 12, '2024-07-06 16:57:45', '2024-07-06 16:57:45'),
(101, 81, 43, 1, NULL, NULL, 4177, 0, 2, 1, 0, 0, 0, 4177, '2024-07-06 17:02:40', '2024-07-06 17:02:40'),
(102, 82, 43, 2, NULL, NULL, 3, 0, 2, 1, 0, 0, 0, 3, '2024-07-06 17:03:16', '2024-07-06 17:03:16'),
(103, 83, 43, 2, NULL, NULL, 6, 0, 2, 1, 0, 0, 0, 6, '2024-07-06 17:03:44', '2024-07-06 17:03:44'),
(104, 84, 36, NULL, NULL, NULL, 2, 0, 2, 340, 20, 0, 0, 680, '2024-07-08 10:46:01', '2024-07-08 10:46:01'),
(105, 84, 36, NULL, NULL, NULL, 2, 0, 2, 21, 0, 0, 0, 42, '2024-07-08 10:46:01', '2024-07-08 10:46:01'),
(106, 84, 36, NULL, NULL, NULL, 2, 0, 2, 21, 0, 0, 0, 42, '2024-07-08 10:46:01', '2024-07-08 10:46:01'),
(107, 84, 36, NULL, NULL, NULL, 2, 0, 2, 21, 0, 0, 0, 42, '2024-07-08 10:46:01', '2024-07-08 10:46:01'),
(108, 84, 36, NULL, NULL, NULL, 2, 0, 2, 21, 0, 0, 0, 42, '2024-07-08 10:46:01', '2024-07-08 10:46:01'),
(109, 85, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-07-11 10:22:13', '2024-07-11 10:22:13'),
(110, 85, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-07-11 10:22:13', '2024-07-11 10:22:13'),
(111, 86, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-07-12 14:35:49', '2024-07-12 14:35:49'),
(112, 87, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-07-12 14:36:31', '2024-07-12 14:36:31'),
(113, 88, 41, NULL, NULL, NULL, 2, 0, 2, 10500, 0, 0, 0, 21000, '2024-07-13 18:32:26', '2024-07-13 18:32:26'),
(114, 88, 31, NULL, 24, NULL, 5, 0, 2, 205, 0, 0, 0, 1025, '2024-07-13 18:32:26', '2024-07-13 18:32:26'),
(115, 89, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-07-15 14:10:15', '2024-07-15 14:10:15'),
(116, 89, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-07-15 14:10:15', '2024-07-15 14:10:15'),
(117, 90, 31, NULL, 21, NULL, 1, 0, 2, 200, 0, 0, 0, 200, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(118, 90, 31, NULL, 24, NULL, 1, 0, 2, 200, 0, 0, 0, 200, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(119, 90, 31, NULL, 22, NULL, 2, 0, 2, 200, 0, 0, 0, 400, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(120, 90, 26, NULL, 9, NULL, 1, 0, 2, 5225, 0, 0, 0, 5225, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(121, 90, 36, NULL, NULL, NULL, 1, 0, 2, 518, 0, 0, 0, 518, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(122, 90, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(123, 90, 34, NULL, NULL, NULL, 1, 0, 2, 130, 0, 0, 0, 130, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(124, 90, 30, NULL, NULL, NULL, 2, 0, 2, 34000, 0, 0, 0, 68000, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(125, 90, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(126, 90, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-07-30 16:38:19', '2024-07-30 16:38:19'),
(127, 91, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-07-30 16:44:00', '2024-07-30 16:44:00'),
(128, 91, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-07-30 16:44:00', '2024-07-30 16:44:00'),
(129, 91, 11, NULL, NULL, NULL, 3, 0, 1, 600, 0, 0, 0, 1800, '2024-07-30 16:44:00', '2024-07-30 16:44:00'),
(130, 91, 2, NULL, NULL, NULL, 3, 0, 2, 120, 0, 0, 0, 360, '2024-07-30 16:44:00', '2024-07-30 16:44:00'),
(131, 92, 33, NULL, 25, NULL, 1, 0, 8, 750, 0, 0, 0, 750, '2024-07-30 16:48:37', '2024-07-30 16:48:37'),
(132, 93, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-07-30 16:50:09', '2024-07-30 16:50:09'),
(133, 93, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-07-30 16:50:09', '2024-07-30 16:50:09'),
(134, 93, 11, NULL, NULL, NULL, 4, 0, 1, 600, 0, 0, 0, 2400, '2024-07-30 16:50:09', '2024-08-27 12:02:26'),
(135, 93, 2, NULL, NULL, NULL, 6, 0, 2, 120, 0, 0, 0, 720, '2024-07-30 16:50:09', '2024-08-27 12:02:26'),
(136, 94, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-08-09 14:50:02', '2024-08-09 14:50:02'),
(137, 94, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-08-09 14:50:02', '2024-08-09 14:50:02'),
(138, 94, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-08-09 14:50:02', '2024-08-09 14:50:02'),
(139, 95, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-08-11 04:31:31', '2024-08-11 04:31:31'),
(140, 96, 47, NULL, NULL, NULL, 2, 0, 0, 500, 0, 0, 0, 1000, '2024-08-16 00:07:27', '2024-08-16 00:07:27'),
(141, 97, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-08-22 11:39:12', '2024-08-22 11:39:12'),
(142, 98, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-08-26 21:41:25', '2024-08-26 21:41:25'),
(143, 99, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-08-27 13:14:53', '2024-08-27 13:14:53'),
(144, 99, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-08-27 13:14:53', '2024-08-27 13:14:53'),
(145, 100, 48, NULL, NULL, '524647897954', 2, 1, 2, 100, 0, 0, 0, 200, '2024-08-28 20:15:29', '2024-08-28 20:18:20'),
(146, 101, 49, NULL, NULL, NULL, 3, 0, 2, 5500, 0, 0, 0, 16500, '2024-08-29 00:36:24', '2024-08-29 00:36:24'),
(147, 102, 49, NULL, NULL, NULL, 2, 0, 2, 5500, 0, 0, 0, 11000, '2024-08-29 00:41:27', '2024-08-29 00:41:27'),
(148, 103, 49, NULL, NULL, NULL, 2, 0, 2, 5500, 0, 0, 0, 11000, '2024-08-29 00:49:32', '2024-08-29 00:49:32'),
(149, 104, 48, NULL, NULL, '2465', 2, 0, 2, 100, 0, 0, 0, 200, '2024-08-29 11:49:33', '2024-08-29 11:49:33'),
(150, 104, 37, NULL, NULL, NULL, 1, 0, 2, 28000, 0, 0, 0, 28000, '2024-08-29 11:49:33', '2024-08-29 11:49:33'),
(151, 104, 30, NULL, NULL, '56465', 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-08-29 11:49:33', '2024-08-29 11:49:33'),
(152, 105, 37, NULL, NULL, NULL, 1, 0, 2, 28000, 0, 0, 0, 28000, '2024-09-01 11:46:59', '2024-09-01 11:46:59'),
(153, 105, 31, NULL, 22, NULL, 3, 0, 2, 200, 0, 0, 0, 600, '2024-09-01 11:46:59', '2024-09-01 11:46:59'),
(154, 105, 11, NULL, NULL, NULL, 4, 0, 1, 600, 0, 0, 0, 2400, '2024-09-01 11:46:59', '2024-09-01 11:46:59'),
(155, 105, 2, NULL, NULL, NULL, 3, 0, 2, 120, 0, 0, 0, 360, '2024-09-01 11:46:59', '2024-09-01 11:46:59'),
(156, 105, 1, NULL, NULL, NULL, 3, 0, 1, 80, 0, 0, 0, 240, '2024-09-01 11:46:59', '2024-09-01 11:46:59'),
(157, 106, 39, NULL, 29, NULL, 5, 0, 4, 100, 0, 0, 0, 500, '2024-09-01 11:59:02', '2024-09-01 11:59:02'),
(158, 106, 2, NULL, NULL, NULL, 3, 0, 2, 122, 0, 0, 0, 366, '2024-09-01 11:59:02', '2024-09-01 11:59:02'),
(159, 107, 37, NULL, NULL, NULL, 1, 0, 2, 25000, 0, 0, 0, 25000, '2024-09-01 12:37:26', '2024-09-01 12:37:26'),
(160, 107, 2, NULL, NULL, NULL, 1, 0, 2, 122, 0, 0, 0, 122, '2024-09-01 12:37:26', '2024-09-01 12:37:26'),
(161, 108, 54, NULL, NULL, NULL, 4, 0, 11, 40, 0, 0, 0, 160, '2024-09-02 12:52:34', '2024-09-02 12:52:34'),
(162, 109, 53, NULL, NULL, NULL, 2, 0, 11, 40, 0, 0, 0, 80, '2024-09-02 12:54:00', '2024-09-02 12:54:00'),
(163, 109, 54, NULL, NULL, NULL, 5, 0, 11, 40, 0, 0, 0, 200, '2024-09-02 12:54:00', '2024-09-02 12:54:00'),
(164, 110, 53, NULL, NULL, NULL, 1, 0, 11, 40, 0, 0, 0, 40, '2024-09-02 12:56:36', '2024-09-02 12:56:36'),
(165, 110, 54, NULL, NULL, NULL, 1, 0, 11, 40, 0, 0, 0, 40, '2024-09-02 12:56:36', '2024-09-02 12:56:36'),
(166, 111, 53, NULL, NULL, NULL, 3, 0, 11, 40, 0, 0, 0, 120, '2024-09-02 17:06:24', '2024-09-02 17:06:24'),
(167, 111, 2, NULL, NULL, NULL, 2, 0, 2, 120, 0, 0, 0, 240, '2024-09-02 17:06:24', '2024-09-02 17:06:24'),
(168, 112, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-02 17:07:30', '2024-09-02 17:07:30'),
(169, 112, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-02 17:07:30', '2024-09-02 17:07:30'),
(170, 113, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-02 17:08:26', '2024-09-02 17:08:26'),
(171, 113, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-02 17:08:26', '2024-09-02 17:08:26'),
(172, 114, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-02 17:13:42', '2024-09-02 17:13:42'),
(173, 114, 11, NULL, NULL, NULL, 1, 0, 1, 600, 0, 0, 0, 600, '2024-09-02 17:13:42', '2024-09-02 17:13:42'),
(174, 115, 54, NULL, NULL, NULL, 1, 0, 11, 40, 0, 0, 0, 40, '2024-09-02 17:32:46', '2024-09-02 17:32:46'),
(175, 116, 54, NULL, NULL, NULL, 4, 0, 11, 43, 0, 0, 0, 172, '2024-09-02 18:22:19', '2024-09-02 18:22:19'),
(176, 117, 54, NULL, NULL, NULL, 4, 0, 11, 40, 0, 0, 0, 160, '2024-09-04 12:52:33', '2024-09-04 12:52:33'),
(177, 118, 11, NULL, NULL, NULL, 1, 0, 1, 600, 0, 0, 0, 600, '2024-09-04 13:04:48', '2024-09-04 13:04:48'),
(178, 118, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-04 13:04:48', '2024-09-04 13:04:48'),
(179, 118, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-04 13:04:48', '2024-09-04 13:04:48'),
(180, 118, 54, NULL, NULL, NULL, 1, 0, 11, 40, 0, 0, 0, 40, '2024-09-04 13:04:48', '2024-09-04 13:04:48'),
(181, 119, 1, NULL, NULL, NULL, 2, 0, 1, 80, 0, 0, 0, 160, '2024-09-04 17:53:03', '2024-09-04 17:53:03'),
(182, 120, 34, NULL, NULL, NULL, 1, 0, 2, 130, 0, 0, 0, 130, '2024-09-04 17:57:29', '2024-09-04 17:57:29'),
(183, 120, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-09-04 17:57:29', '2024-09-04 17:57:29'),
(184, 121, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-04 17:58:08', '2024-09-04 17:58:08'),
(185, 122, 37, NULL, NULL, NULL, 1, 0, 2, 28000, 0, 0, 0, 28000, '2024-09-04 18:00:01', '2024-09-04 18:00:01'),
(186, 122, 47, NULL, NULL, NULL, 2, 0, 0, 500, 0, 0, 0, 1000, '2024-09-04 18:00:01', '2024-09-04 18:00:01'),
(187, 123, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-04 18:01:15', '2024-09-04 18:01:15'),
(188, 124, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-04 18:03:49', '2024-09-04 18:03:49'),
(189, 125, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-04 18:06:16', '2024-09-04 18:06:16'),
(190, 126, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-04 18:08:58', '2024-09-04 18:08:58'),
(191, 127, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-05 11:00:55', '2024-09-05 11:00:55'),
(192, 128, 2, NULL, NULL, NULL, 2, 0, 2, 120, 0, 0, 0, 240, '2024-09-05 12:56:13', '2024-09-05 12:56:13'),
(193, 128, 1, NULL, NULL, NULL, 3, 0, 1, 80, 0, 0, 0, 240, '2024-09-05 12:56:13', '2024-09-05 12:56:13'),
(194, 129, 11, NULL, NULL, NULL, 1, 0, 1, 600, 0, 0, 0, 600, '2024-09-05 12:56:24', '2024-09-05 12:56:24'),
(195, 129, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-05 12:56:24', '2024-09-05 12:56:24'),
(196, 129, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-05 12:56:24', '2024-09-05 12:56:24'),
(197, 130, 30, NULL, NULL, '987979779', 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-09-06 15:15:06', '2024-09-06 15:15:06'),
(198, 131, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-08 10:12:49', '2024-09-08 10:12:49'),
(199, 132, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-08 10:41:41', '2024-09-08 10:41:41'),
(200, 133, 43, 2, NULL, NULL, 2, 0, 2, 1, 0, 0, 0, 2, '2024-09-08 13:17:47', '2024-09-08 13:17:47'),
(201, 133, 34, NULL, NULL, NULL, 3, 0, 2, 130, 0, 0, 0, 390, '2024-09-08 13:17:47', '2024-09-08 13:17:47'),
(202, 134, 43, 2, NULL, NULL, 100, 0, 2, 1, 0, 0, 0, 100, '2024-09-08 13:18:49', '2024-09-08 13:18:49'),
(203, 135, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-09-08 16:09:20', '2024-09-08 16:09:20'),
(204, 136, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-09 10:25:41', '2024-09-09 10:25:41'),
(205, 137, 43, 2, NULL, NULL, 1, 0, 2, 1, 0, 0, 0, 1, '2024-09-09 10:26:39', '2024-09-09 10:26:39'),
(206, 138, 57, NULL, NULL, NULL, 5, 0, 2, 1350, 0, 0, 0, 6750, '2024-09-09 14:02:43', '2024-09-09 14:02:43'),
(207, 139, 57, NULL, NULL, NULL, 5, 0, 2, 1350, 0, 0, 0, 6750, '2024-09-09 14:04:58', '2024-09-09 14:04:58'),
(208, 140, 57, NULL, NULL, NULL, 5, 0, 2, 1350, 0, 0, 0, 6750, '2024-09-09 14:06:56', '2024-09-09 14:06:56'),
(209, 141, 54, NULL, NULL, NULL, 20, 0, 11, 40, 0, 0, 0, 800, '2024-09-09 14:18:30', '2024-09-09 14:18:30'),
(210, 142, 57, NULL, NULL, NULL, 7, 0, 2, 1350, 0, 0, 0, 9450, '2024-09-09 14:39:02', '2024-09-09 14:39:02'),
(213, 144, 59, NULL, NULL, NULL, 3, 0, 2, 650, 0, 0, 0, 1950, '2024-09-09 15:24:45', '2024-09-09 15:24:45'),
(214, 144, 60, NULL, NULL, NULL, 4, 0, 2, 490, 0, 0, 0, 1960, '2024-09-09 15:24:45', '2024-09-09 15:24:45'),
(215, 145, 60, NULL, NULL, NULL, 1, 0, 2, 490, 0, 0, 0, 490, '2024-09-09 15:28:16', '2024-09-09 15:28:16'),
(216, 146, 43, 2, NULL, NULL, 1, 0, 2, 1, 0, 0, 0, 1, '2024-09-10 20:04:05', '2024-09-10 20:04:05'),
(217, 147, 61, NULL, NULL, NULL, 3, 0, 2, 1430, 0, 0, 0, 4290, '2024-09-10 20:22:22', '2024-09-10 20:22:22'),
(218, 147, 47, NULL, NULL, NULL, 1, 0, 0, 500, 0, 0, 0, 500, '2024-09-10 20:22:22', '2024-09-10 20:22:22'),
(219, 148, 61, NULL, NULL, NULL, 20, 0, 2, 1440, 0, 0, 0, 28800, '2024-09-11 11:56:44', '2024-09-11 11:56:44'),
(220, 149, 43, 2, NULL, NULL, 3, 0, 2, 1, 0, 0, 0, 3, '2024-09-11 12:03:10', '2024-09-11 12:03:10'),
(221, 149, 11, NULL, NULL, NULL, 2, 0, 1, 600, 0, 0, 0, 1200, '2024-09-11 12:03:10', '2024-09-11 12:03:10'),
(222, 149, 1, NULL, NULL, NULL, 4, 0, 1, 80, 0, 0, 0, 320, '2024-09-11 12:03:10', '2024-09-11 12:03:10'),
(223, 150, 57, NULL, NULL, NULL, 20, 0, 2, 1350, 0, 0, 0, 27000, '2024-09-11 12:06:07', '2024-09-11 12:06:07'),
(224, 151, 61, NULL, NULL, NULL, 3, 0, 2, 1440, 0, 0, 0, 4320, '2024-09-11 12:12:03', '2024-09-11 12:12:03'),
(225, 152, 61, NULL, NULL, NULL, 4, 0, 2, 1440, 0, 0, 0, 5760, '2024-09-11 12:15:15', '2024-09-11 12:15:15'),
(226, 153, 61, NULL, NULL, NULL, 2, 0, 2, 1440, 0, 0, 0, 2880, '2024-09-11 12:29:06', '2024-09-11 12:29:06'),
(227, 154, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-11 13:11:28', '2024-09-11 13:11:28'),
(228, 155, 54, NULL, NULL, NULL, 5, 0, 11, 40, 0, 0, 0, 200, '2024-09-11 13:34:31', '2024-09-11 13:34:31'),
(229, 156, 1, NULL, NULL, NULL, 5, 0, 1, 80, 0, 0, 0, 400, '2024-09-12 14:33:13', '2024-09-12 14:33:13'),
(230, 157, 54, NULL, NULL, NULL, 4, 0, 11, 40, 0, 0, 0, 160, '2024-09-12 14:37:20', '2024-09-12 14:37:20'),
(231, 158, 60, NULL, NULL, NULL, 3, 0, 2, 489.96, 0, 0, 0, 1469.88, '2024-09-12 21:27:50', '2024-09-12 21:27:50'),
(232, 158, 59, NULL, NULL, NULL, 2, 0, 2, 650, 0, 0, 0, 1300, '2024-09-12 21:27:50', '2024-09-12 21:27:50'),
(233, 159, 54, NULL, NULL, NULL, 5, 0, 11, 40, 0, 0, 0, 200, '2024-09-14 13:23:48', '2024-09-14 13:23:48'),
(234, 160, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-09-14 16:15:06', '2024-09-14 16:15:06'),
(235, 160, 34, NULL, NULL, NULL, 2, 0, 2, 130, 0, 0, 0, 260, '2024-09-14 16:15:06', '2024-09-14 16:15:06'),
(236, 161, 36, NULL, NULL, NULL, 1, 0, 2, 518, 0, 0, 0, 518, '2024-09-14 17:54:16', '2024-09-14 17:54:16'),
(237, 161, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-09-14 17:54:16', '2024-09-14 17:54:16'),
(238, 162, 7, NULL, NULL, NULL, 1, 0, 2, 450, 0, 0, 0, 450, '2024-09-14 22:22:03', '2024-09-14 22:22:03'),
(239, 163, 1, NULL, NULL, NULL, 4, 0, 1, 80, 0, 0, 0, 320, '2024-09-14 22:29:59', '2024-09-14 22:29:59'),
(240, 164, 30, NULL, NULL, NULL, 3, 0, 2, 34000, 0, 0, 0, 102000, '2024-09-15 14:48:35', '2024-09-15 14:48:35'),
(241, 165, 70, NULL, NULL, NULL, 14, 0, 2, 1480, 0, 0, 0, 20720, '2024-09-15 14:49:38', '2024-09-15 14:49:38'),
(242, 165, 69, NULL, NULL, NULL, 14, 0, 2, 1450, 0, 0, 0, 20300, '2024-09-15 14:49:38', '2024-09-15 14:49:38'),
(243, 165, 61, NULL, NULL, NULL, 14, 0, 2, 1440, 0, 0, 0, 20160, '2024-09-15 14:49:38', '2024-09-15 14:49:38'),
(244, 166, 40, NULL, NULL, NULL, 1, 1, 2, 1250, 0, 0, 0, 1250, '2024-09-15 14:50:26', '2024-09-15 14:55:55'),
(245, 167, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-16 12:15:48', '2024-09-16 12:15:48'),
(246, 168, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-16 13:58:44', '2024-09-16 13:58:44'),
(247, 169, 7, NULL, NULL, NULL, 1, 0, 2, 450, 0, 0, 0, 450, '2024-09-17 00:11:15', '2024-09-17 00:11:15'),
(248, 170, 53, NULL, NULL, NULL, 1, 0, 11, 40, 0, 0, 0, 40, '2024-09-17 00:13:12', '2024-09-17 00:13:12'),
(249, 171, 35, NULL, NULL, NULL, 1, 0, 2, 500, 0, 0, 0, 500, '2024-09-17 16:15:17', '2024-09-17 16:15:17'),
(250, 172, 34, NULL, NULL, NULL, 1, 0, 2, 130, 0, 0, 0, 130, '2024-09-17 16:16:17', '2024-09-17 16:16:17'),
(251, 173, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-18 14:23:03', '2024-09-18 14:23:03'),
(252, 173, 1, NULL, NULL, NULL, 3, 0, 1, 80, 0, 0, 0, 240, '2024-09-18 14:23:03', '2024-09-18 14:23:03'),
(253, 174, 54, NULL, NULL, NULL, 10, 0, 11, 40, 0, 0, 0, 400, '2024-09-18 14:40:37', '2024-09-18 14:40:37'),
(254, 175, 5, NULL, 3, NULL, 1, 0, 2, 42500, 0, 0, 0, 42500, '2024-09-18 16:19:42', '2024-09-18 16:19:42'),
(255, 175, 1, NULL, NULL, NULL, 18, 0, 1, 80, 0, 0, 0, 1440, '2024-09-18 16:19:42', '2024-09-18 16:19:42'),
(256, 176, 74, NULL, NULL, NULL, 2, 0, 2, 1600, 0, 0, 0, 3200, '2024-09-21 12:30:02', '2024-09-21 12:30:02'),
(257, 177, 74, NULL, NULL, NULL, 2, 0, 2, 1600, 0, 0, 0, 3200, '2024-09-21 12:30:56', '2024-09-21 12:30:56'),
(258, 178, 75, NULL, NULL, NULL, 1, 0, 2, 1200, 0, 0, 0, 1200, '2024-09-21 12:41:08', '2024-09-21 12:41:08'),
(259, 179, 30, NULL, NULL, NULL, 1, 0, 2, 34000, 0, 0, 0, 34000, '2024-09-21 15:56:52', '2024-09-21 15:56:52'),
(260, 180, 1, NULL, NULL, NULL, 2, 0, 1, 80, 0, 0, 0, 160, '2024-09-22 13:30:10', '2024-09-22 13:30:10'),
(261, 181, 7, NULL, NULL, NULL, 1, 0, 2, 450, 0, 0, 0, 450, '2024-09-24 12:26:02', '2024-09-24 12:26:02'),
(262, 182, 54, NULL, NULL, NULL, 10, 0, 11, 40, 0, 0, 0, 400, '2024-09-24 13:23:29', '2024-09-24 13:23:29'),
(263, 183, 30, NULL, NULL, 'ghf', 50, 0, 2, 34000, 0, 0, 0, 1700000, '2024-09-24 14:20:25', '2024-09-24 14:20:25'),
(264, 183, 7, NULL, NULL, NULL, 10, 0, 2, 450, 0, 0, 0, 4500, '2024-09-24 14:20:25', '2024-09-24 14:20:25'),
(265, 184, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-25 18:34:16', '2024-09-25 18:34:16'),
(266, 185, 2, NULL, NULL, NULL, 1, 0, 2, 120, 0, 0, 0, 120, '2024-09-25 18:36:41', '2024-09-25 18:36:41'),
(267, 185, 1, NULL, NULL, NULL, 1, 0, 1, 80, 0, 0, 0, 80, '2024-09-25 18:36:41', '2024-09-25 18:36:41'),
(268, 186, 11, NULL, NULL, NULL, 1, 0, 1, 600, 0, 0, 0, 600, '2024-09-25 18:45:10', '2024-09-25 18:45:10'),
(269, 187, 30, NULL, NULL, '3453453', 4, 0, 2, 34000, 0, 0, 0, 136000, '2024-09-25 19:08:35', '2024-09-25 19:08:35'),
(270, 188, 9, NULL, NULL, NULL, 1, 1, 2, 3500, 0, 0, 0, 3500, '2024-09-26 17:05:38', '2024-09-27 16:21:00'),
(271, 189, 73, NULL, NULL, NULL, 15, 0, 2, 1420, 0, 0, 0, 21300, '2024-09-27 16:13:57', '2024-09-27 16:13:57'),
(272, 189, 53, NULL, NULL, NULL, 10, 1, 11, 40, 0, 0, 0, 400, '2024-09-27 16:13:57', '2024-09-27 16:18:08'),
(273, 189, 2, NULL, NULL, NULL, 13, 0, 2, 120, 0, 0, 0, 1560, '2024-09-27 16:13:57', '2024-09-27 16:13:57'),
(274, 190, 30, NULL, NULL, '4353534567', 1, 1, 2, 35000, 0, 0, 0, 35000, '2024-09-28 12:40:20', '2024-09-28 12:48:52'),
(275, 191, 61, NULL, NULL, NULL, 1, 0, 2, 1440, 0, 0, 0, 1440, '2024-09-29 12:34:46', '2024-09-29 12:34:46'),
(276, 191, 80, NULL, NULL, NULL, 5, 0, 2, 1050, 0, 0, 0, 5250, '2024-09-29 12:34:46', '2024-09-29 12:34:46'),
(277, 192, 71, NULL, NULL, NULL, 1, 0, 2, 1400, 0, 0, 0, 1400, '2024-09-29 12:41:05', '2024-09-29 12:41:05'),
(278, 193, 63, NULL, NULL, NULL, 1, 0, 2, 1280, 0, 0, 0, 1280, '2024-09-29 12:43:17', '2024-09-29 12:43:17'),
(279, 194, 79, NULL, NULL, NULL, 1, 0, 2, 650, 0, 0, 0, 650, '2024-09-29 13:25:09', '2024-09-29 13:25:09'),
(280, 195, 63, NULL, NULL, NULL, 2, 0, 2, 1280, 0, 0, 0, 2560, '2024-09-29 13:37:45', '2024-09-29 13:37:45'),
(281, 196, 63, NULL, NULL, NULL, 2, 0, 2, 1280, 0, 0, 0, 2560, '2024-09-29 13:44:59', '2024-09-29 13:44:59'),
(282, 197, 71, NULL, NULL, NULL, 1, 0, 2, 1400, 0, 0, 0, 1400, '2024-09-29 13:52:29', '2024-09-29 13:52:29'),
(283, 198, 36, NULL, NULL, NULL, 10, 0, 2, 518, 0, 0, 0, 5180, '2024-09-29 15:36:14', '2024-09-29 15:36:14'),
(284, 198, 35, NULL, NULL, NULL, 5, 0, 2, 500, 0, 0, 0, 2500, '2024-09-29 15:36:14', '2024-09-29 15:36:14'),
(285, 198, 1, NULL, NULL, NULL, 15, 5, 1, 80, 0, 0, 0, 1200, '2024-09-29 15:36:14', '2024-09-29 17:42:37'),
(286, 199, 11, NULL, NULL, NULL, 1, 0, 1, 600, 0, 0, 0, 600, '2024-09-30 18:15:13', '2024-09-30 18:15:13'),
(287, 200, 43, 2, NULL, NULL, 1, 0, 2, 1, 0, 0, 0, 1, '2024-09-30 18:18:41', '2024-09-30 18:18:41'),
(288, 201, 61, NULL, NULL, NULL, 1, 0, 2, 1440, 0, 0, 0, 1440, '2024-10-01 12:00:49', '2024-10-01 12:00:49'),
(289, 201, 63, NULL, NULL, NULL, 1, 0, 2, 1280, 0, 0, 0, 1280, '2024-10-01 12:00:49', '2024-10-01 12:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `product_transfer`
--

CREATE TABLE `product_transfer` (
  `id` int(10) UNSIGNED NOT NULL,
  `transfer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_batch_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `imei_number` text DEFAULT NULL,
  `qty` double NOT NULL,
  `purchase_unit_id` int(11) NOT NULL,
  `net_unit_cost` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_transfer`
--

INSERT INTO `product_transfer` (`id`, `transfer_id`, `product_id`, `product_batch_id`, `variant_id`, `imei_number`, `qty`, `purchase_unit_id`, `net_unit_cost`, `tax_rate`, `tax`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 7, NULL, NULL, NULL, 2, 2, 300, 0, 0, 600, '2024-06-10 10:26:59', '2024-06-10 10:26:59'),
(2, 2, 4, NULL, 2, NULL, 4, 2, 13599, 0, 0, 54396, '2024-09-01 14:58:24', '2024-09-01 14:58:24'),
(3, 3, 54, NULL, NULL, NULL, 3, 11, 32, 0, 0, 96, '2024-09-02 14:46:44', '2024-09-02 14:46:44'),
(4, 4, 53, NULL, NULL, NULL, 15, 11, 35, 0, 0, 525, '2024-09-02 17:14:30', '2024-09-02 17:14:30'),
(5, 5, 72, NULL, NULL, NULL, 30, 11, 50, 0, 0, 1500, '2024-09-17 16:25:47', '2024-09-17 16:25:47'),
(6, 6, 79, NULL, NULL, NULL, 100, 2, 500, 0, 0, 50000, '2024-09-29 13:39:58', '2024-09-29 13:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `additional_cost` double DEFAULT NULL,
  `additional_price` double DEFAULT NULL,
  `qty` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `variant_id`, `position`, `item_code`, `additional_cost`, `additional_price`, `qty`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 1, 'Forest Green-00127202', NULL, NULL, 20, '2024-04-23 10:52:31', '2024-05-16 10:46:31'),
(2, 4, 2, 2, 'Glitter Purple-00127202', NULL, NULL, 22, '2024-04-23 10:52:31', '2024-09-01 14:14:39'),
(3, 5, 3, 1, 'Red-15239996', NULL, NULL, 9, '2024-04-23 10:58:06', '2024-09-18 16:19:42'),
(4, 5, 4, 2, 'Silver-15239996', NULL, NULL, 15, '2024-04-23 10:58:06', '2024-07-02 20:25:49'),
(5, 5, 5, 3, 'Gold-15239996', NULL, NULL, 19, '2024-04-23 10:58:06', '2024-07-02 20:25:49'),
(6, 6, 6, 1, 'Black-95843612', NULL, NULL, 0, '2024-04-23 11:03:09', '2024-04-23 11:03:09'),
(7, 6, 4, 2, 'Silver-95843612', NULL, NULL, 0, '2024-04-23 11:03:09', '2024-04-23 11:03:09'),
(8, 6, 5, 3, 'Gold-95843612', NULL, NULL, 0, '2024-04-23 11:03:09', '2024-04-23 11:03:09'),
(9, 17, 7, 1, 'Yellow-07412376', NULL, NULL, 0, '2024-04-23 11:47:04', '2024-04-23 11:47:04'),
(10, 26, 8, 1, '25kg-34824691', NULL, NULL, 10, '2024-05-01 17:44:03', '2024-05-01 17:54:29'),
(11, 26, 9, 2, '50kg-34824691', 2500, 2650, 24, '2024-05-01 17:44:03', '2024-07-30 16:38:19'),
(12, 27, 10, 1, '36 balck-38225400', NULL, NULL, 3, '2024-05-04 16:20:09', '2024-05-04 16:28:44'),
(13, 27, 11, 2, '36 pink-38225400', NULL, NULL, 4, '2024-05-04 16:20:09', '2024-05-04 16:22:35'),
(14, 27, 12, 3, '37 black-38225400', NULL, NULL, 4, '2024-05-04 16:20:09', '2024-05-04 16:37:58'),
(15, 27, 13, 4, '37 pink-38225400', NULL, NULL, 1, '2024-05-04 16:20:09', '2024-05-04 16:28:44'),
(16, 29, 14, 1, 'm/blue patern-13103887', NULL, NULL, 0, '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(17, 29, 15, 2, 'm/Red Patern-13103887', NULL, 50, 0, '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(18, 29, 16, 3, 'l/blue patern-13103887', NULL, NULL, 0, '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(19, 29, 17, 4, 'l/Red Patern-13103887', NULL, NULL, 0, '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(20, 29, 18, 5, 'xl/blue patern-13103887', 10, 60, 0, '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(21, 29, 19, 6, 'xl/Red Patern-13103887', NULL, NULL, 0, '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(23, 31, 21, 1, 'M-Black-54419832', NULL, NULL, 39, '2024-05-12 18:09:43', '2024-07-30 16:38:19'),
(24, 31, 22, 2, 'L-Blue-54419832', NULL, NULL, 5, '2024-05-12 18:09:43', '2024-09-01 11:46:59'),
(26, 31, 24, 3, 'XL-Red-54419832', NULL, NULL, 46, '2024-05-12 18:09:43', '2024-07-30 16:38:19'),
(27, 33, 25, 1, 'Grey-15903853', NULL, NULL, 35, '2024-05-19 12:17:06', '2024-07-30 16:48:37'),
(28, 33, 26, 2, 'White Peel-15903853', NULL, NULL, 25, '2024-05-19 12:17:06', '2024-05-19 12:22:10'),
(29, 33, 27, 3, 'Tile Marble Viny-15903853', NULL, NULL, 50, '2024-05-19 12:17:06', '2024-05-19 12:22:10'),
(30, 39, 4, 1, 'Silver-46928536', NULL, NULL, -3, '2024-06-05 22:16:06', '2024-06-05 22:28:00'),
(31, 39, 28, 2, 'Browns-46928536', NULL, NULL, 21, '2024-06-05 22:16:06', '2024-06-05 22:19:16'),
(32, 39, 29, 3, 'Matik-46928536', NULL, NULL, 97, '2024-06-05 22:16:06', '2024-09-01 11:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `product_warehouse`
--

CREATE TABLE `product_warehouse` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_batch_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `imei_number` text DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `qty` double NOT NULL,
  `price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_warehouse`
--

INSERT INTO `product_warehouse` (`id`, `product_id`, `product_batch_id`, `variant_id`, `imei_number`, `warehouse_id`, `qty`, `price`, `created_at`, `updated_at`) VALUES
(1, '1', NULL, NULL, NULL, 1, 10111, NULL, '2024-04-01 10:11:27', '2024-09-29 17:42:37'),
(2, '2', NULL, NULL, NULL, 1, 14, NULL, '2024-04-07 02:22:27', '2024-09-27 16:13:57'),
(3, '3', NULL, NULL, NULL, 1, 8, 600, '2024-04-22 20:11:22', '2024-04-24 15:24:23'),
(4, '4', NULL, 2, NULL, 1, 18, 15999, '2024-04-23 10:54:31', '2024-09-01 14:58:24'),
(5, '4', NULL, 1, NULL, 1, 20, 15999, '2024-04-23 10:54:31', '2024-04-23 10:54:31'),
(6, '5', NULL, 5, NULL, 1, 19, 42500, '2024-04-23 10:59:15', '2024-07-02 20:25:49'),
(7, '5', NULL, 4, NULL, 1, 15, 42500, '2024-04-23 10:59:15', '2024-07-02 20:25:49'),
(8, '5', NULL, 3, NULL, 1, 9, 42500, '2024-04-23 10:59:15', '2024-09-18 16:19:42'),
(9, '7', NULL, NULL, NULL, 1, 28, 450, '2024-04-23 11:08:12', '2024-09-24 14:20:25'),
(10, '26', NULL, 9, NULL, 1, 24, NULL, '2024-05-01 17:46:39', '2024-07-30 16:38:19'),
(11, '26', NULL, 8, NULL, 1, 10, 2575, '2024-05-01 17:46:39', '2024-05-01 17:54:29'),
(12, '27', NULL, 10, NULL, 1, 3, 200, '2024-05-04 16:22:35', '2024-05-04 16:28:44'),
(13, '27', NULL, 11, NULL, 1, 4, 200, '2024-05-04 16:22:35', '2024-05-04 16:22:35'),
(14, '27', NULL, 12, NULL, 1, 4, 200, '2024-05-04 16:22:35', '2024-05-04 16:37:58'),
(15, '27', NULL, 13, NULL, 1, 1, 200, '2024-05-04 16:22:35', '2024-05-04 16:28:44'),
(16, '30', NULL, NULL, '4353534567', 1, 25, NULL, '2024-05-09 00:15:40', '2024-09-28 12:48:52'),
(17, '30', NULL, NULL, '', 2, 50, NULL, '2024-05-09 00:15:40', '2024-05-09 00:42:53'),
(18, '31', NULL, 23, NULL, 1, 3, NULL, '2024-05-12 18:14:43', '2024-05-16 11:54:43'),
(19, '31', NULL, 22, NULL, 1, 5, 200, '2024-05-12 18:14:43', '2024-09-01 11:46:59'),
(20, '31', NULL, 21, NULL, 1, 39, 200, '2024-05-12 18:14:43', '2024-07-30 16:38:19'),
(21, '31', NULL, 20, NULL, 1, 10, 200, '2024-05-12 18:14:43', '2024-05-16 11:19:31'),
(22, '31', NULL, 24, NULL, 1, 46, 200, '2024-05-12 18:14:43', '2024-07-30 16:38:19'),
(23, '4', NULL, 1, NULL, 2, 0, 15999, '2024-05-13 17:04:36', '2024-05-16 10:46:31'),
(24, '32', NULL, NULL, NULL, 1, 891, NULL, '2024-05-19 11:50:14', '2024-05-19 12:12:31'),
(25, '33', NULL, 27, NULL, 1, 50, 30, '2024-05-19 12:22:10', '2024-05-19 12:22:10'),
(26, '33', NULL, 26, NULL, 1, 25, 30, '2024-05-19 12:22:10', '2024-05-19 12:22:10'),
(27, '33', NULL, 25, NULL, 1, 35, 30, '2024-05-19 12:22:10', '2024-07-30 16:48:37'),
(28, '34', NULL, NULL, NULL, 1, 480, 130, '2024-05-20 14:21:15', '2024-09-17 16:16:17'),
(29, '35', NULL, NULL, NULL, 1, 484, 500, '2024-05-21 17:02:05', '2024-09-29 15:36:14'),
(30, '8', NULL, NULL, NULL, 1, 10, 3000, '2024-05-25 22:31:23', '2024-09-28 12:34:39'),
(31, '36', NULL, NULL, NULL, 1, 88, NULL, '2024-05-25 22:31:23', '2024-09-29 15:36:14'),
(32, '37', NULL, NULL, NULL, 1, 15, 28000, '2024-05-28 16:55:29', '2024-09-15 17:25:08'),
(33, '9', NULL, NULL, NULL, 1, 53, 3500, '2024-06-01 18:42:17', '2024-09-27 16:21:00'),
(34, '39', NULL, 29, NULL, 1, 97, 102, '2024-06-05 22:19:16', '2024-09-01 11:59:02'),
(35, '39', NULL, 28, NULL, 1, 21, 102, '2024-06-05 22:19:16', '2024-06-05 22:19:16'),
(36, '39', NULL, 4, NULL, 1, -3, 102, '2024-06-05 22:19:16', '2024-06-05 22:28:00'),
(37, '7', NULL, NULL, NULL, 2, 2, NULL, '2024-06-10 10:26:59', '2024-09-17 00:11:15'),
(38, '40', NULL, NULL, NULL, 1, 44, 1250, '2024-06-10 14:51:25', '2024-09-15 14:55:55'),
(39, '41', NULL, NULL, NULL, 1, 13, 10500, '2024-06-10 16:16:25', '2024-07-13 18:32:26'),
(40, '42', NULL, NULL, NULL, 1, 1.2, 3500, '2024-06-23 11:33:03', '2024-07-30 16:42:25'),
(41, '11', NULL, NULL, NULL, 1, 141, 600, '2024-07-01 10:43:04', '2024-09-30 18:15:13'),
(42, '1', NULL, NULL, NULL, 2, 12, 80, '2024-07-05 16:04:34', '2024-09-14 17:50:17'),
(43, '43', 1, NULL, NULL, 1, 0, NULL, '2024-07-06 16:54:17', '2024-07-06 17:02:40'),
(44, '43', 2, NULL, NULL, 1, 1083, NULL, '2024-07-06 16:59:17', '2024-09-30 18:18:41'),
(45, '48', NULL, NULL, '324234234,524647897954', 1, 47, 100, '2024-08-28 20:11:56', '2024-08-29 11:49:33'),
(46, '49', NULL, NULL, NULL, 1, 43, 6000, '2024-08-29 00:32:46', '2024-08-29 00:49:32'),
(47, '4', NULL, 2, NULL, 2, 4, NULL, '2024-09-01 14:58:24', '2024-09-01 14:58:24'),
(48, '54', NULL, NULL, NULL, 1, 948, 40, '2024-09-02 12:48:07', '2024-09-24 13:23:29'),
(49, '53', NULL, NULL, NULL, 1, 1423, 40, '2024-09-02 12:48:56', '2024-09-27 16:18:08'),
(50, '53', NULL, NULL, NULL, 2, 15, NULL, '2024-09-02 17:14:30', '2024-09-02 17:14:30'),
(51, '15', NULL, NULL, NULL, 1, 6, 11500, '2024-09-08 13:13:32', '2024-09-08 13:13:32'),
(52, '57', NULL, NULL, NULL, 1, 58, 1350, '2024-09-09 13:55:12', '2024-09-11 12:06:07'),
(53, '59', NULL, NULL, NULL, 1, 45, 650, '2024-09-09 15:09:41', '2024-09-12 21:27:50'),
(54, '60', NULL, NULL, NULL, 1, 92, 490, '2024-09-09 15:10:39', '2024-09-12 21:27:50'),
(55, '61', NULL, NULL, NULL, 1, 57, 1440, '2024-09-09 20:10:26', '2024-10-01 12:00:49'),
(56, '8', NULL, NULL, NULL, 2, 2, 3000, '2024-09-14 09:43:01', '2024-09-14 18:18:45'),
(57, '18', NULL, NULL, NULL, 2, 3, 1200, '2024-09-14 17:50:17', '2024-09-14 17:50:17'),
(58, '15', NULL, NULL, NULL, 2, 1, 11500, '2024-09-14 17:50:17', '2024-09-14 17:50:17'),
(59, '69', NULL, NULL, NULL, 1, 3, NULL, '2024-09-15 12:01:35', '2024-10-01 11:58:25'),
(60, '70', NULL, NULL, NULL, 1, 86, 1480, '2024-09-15 14:48:05', '2024-09-15 14:49:38'),
(61, '71', NULL, NULL, NULL, 1, 12, 1400, '2024-09-17 10:47:01', '2024-09-29 13:52:29'),
(62, '72', NULL, NULL, NULL, 1, 70, 55, '2024-09-17 16:24:47', '2024-09-17 16:25:47'),
(63, '72', NULL, NULL, NULL, 2, 30, NULL, '2024-09-17 16:25:47', '2024-09-17 16:25:47'),
(64, '73', NULL, NULL, NULL, 1, 85, 1420, '2024-09-21 11:41:12', '2024-09-27 16:13:57'),
(65, '74', NULL, NULL, NULL, 1, 96, 1600, '2024-09-21 12:26:50', '2024-09-21 12:30:56'),
(66, '75', NULL, NULL, NULL, 1, 0, 1200, '2024-09-21 12:39:36', '2024-09-21 12:41:08'),
(67, '63', NULL, NULL, NULL, 1, 4, 1280, '2024-09-24 13:17:09', '2024-10-01 12:00:49'),
(68, '76', NULL, NULL, NULL, 1, 105, 2500, '2024-09-24 13:37:47', '2024-09-24 14:04:32'),
(69, '77', NULL, NULL, NULL, 1, 50, 1000, '2024-09-24 14:04:32', '2024-09-24 14:04:32'),
(70, '78', NULL, NULL, NULL, 1, 14, 1480, '2024-09-25 13:10:54', '2024-09-25 13:10:54'),
(71, '13', NULL, NULL, NULL, 1, 1, 62, '2024-09-26 17:01:21', '2024-09-26 17:01:21'),
(72, '79', NULL, NULL, NULL, 1, 99, 650, '2024-09-28 11:23:32', '2024-09-29 13:39:58'),
(73, '12', NULL, NULL, NULL, 1, 10, 133, '2024-09-28 12:34:39', '2024-09-28 12:34:39'),
(74, '43', 3, NULL, NULL, 1, 300, NULL, '2024-09-29 12:07:46', '2024-09-29 12:07:46'),
(75, '80', NULL, NULL, NULL, 1, 45, 1050, '2024-09-29 12:32:45', '2024-09-29 12:34:46'),
(76, '79', NULL, NULL, NULL, 2, 100, NULL, '2024-09-29 13:39:58', '2024-09-29 13:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `item` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `paid_amount` double NOT NULL,
  `status` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `reference_no`, `user_id`, `warehouse_id`, `supplier_id`, `currency_id`, `exchange_rate`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_cost`, `order_tax_rate`, `order_tax`, `order_discount`, `shipping_cost`, `grand_total`, `paid_amount`, `status`, `payment_status`, `document`, `note`, `created_at`, `updated_at`) VALUES
(1, 'pr-20240401-101127', 1, 1, NULL, NULL, NULL, 1, 10000, 0, 0, 650000, NULL, 0, NULL, NULL, 650000, 650000, 1, 2, NULL, NULL, '2024-04-01 10:11:27', '2024-04-01 10:11:27'),
(2, 'pr-20240407-022227', 1, 1, NULL, NULL, NULL, 1, 10, 0, 0, 1000, NULL, 0, NULL, NULL, 1000, 1000, 1, 2, NULL, NULL, '2024-04-07 02:22:27', '2024-04-07 02:22:27'),
(3, 'pr-20240418-071626', 1, 1, 1, 2, 1, 1, 30, 0, 0, 1950, 0, 0, 0, 0, 1950, 1950, 1, 2, NULL, NULL, '2024-04-18 19:16:26', '2024-04-18 19:16:47'),
(4, 'pr-20240421-060446', 1, 1, 1, 2, 1, 1, 50, 0, 0, 5000, 0, 0, 0, 0, 5000, 5000, 1, 2, NULL, NULL, '2024-04-21 18:04:46', '2024-04-21 18:05:12'),
(5, 'pr-20240422-081122', 1, 1, 1, 2, 1, 1, 10, 0, 0, 5000, 0, 0, 0, 0, 5000, 5000, 1, 2, NULL, NULL, '2024-04-22 20:11:22', '2024-04-22 20:12:08'),
(6, 'pr-20240423-105431', 1, 1, NULL, 2, 1, 2, 40, 0, 0, 543960, 0, 0, 100, 300, 544160, 0, 1, 1, NULL, NULL, '2024-04-23 10:54:31', '2024-04-23 10:54:31'),
(7, 'pr-20240423-105915', 1, 1, 1, 2, 1, 3, 40, 0, 0, 1620000, 0, 0, 1000, 2000, 1621000, 912700, 1, 1, NULL, NULL, '2024-04-23 10:59:15', '2024-09-16 11:15:25'),
(8, 'pr-20240423-110812', 1, 1, NULL, 2, 1, 1, 40, 0, 0, 12000, 0, 0, 500, 300, 11800, 0, 1, 1, NULL, NULL, '2024-04-23 11:08:12', '2024-04-23 11:08:12'),
(9, 'pr-20240501-054639', 1, 1, 1, 2, 1, 2, 30, 0, 0, 125000, 0, 0, 0, 0, 125000, 0, 1, 1, NULL, NULL, '2024-05-01 17:46:39', '2024-05-01 17:46:39'),
(10, 'pr-20240501-054951', 1, 1, 1, 2, 1, 2, 7, 500, 0, 29500, 0, 0, 500, 0, 29000, 9000, 1, 1, NULL, NULL, '2024-05-01 17:49:51', '2024-05-01 17:51:05'),
(11, 'pr-20240504-042235', 1, 1, 1, 2, 1, 4, 16, 0, 0, 1600, 0, 0, 0, 0, 1600, 1600, 1, 2, NULL, NULL, '2024-05-04 16:22:35', '2024-05-04 16:23:29'),
(12, 'pr-20240509-121540', 1, 1, NULL, NULL, NULL, 1, 100, 0, 0, 3000000, NULL, 0, NULL, NULL, 3000000, 3000000, 1, 2, NULL, NULL, '2024-05-09 00:15:40', '2024-05-09 00:15:40'),
(13, 'pr-20240509-121540', 1, 2, NULL, NULL, NULL, 1, 50, 0, 0, 1500000, NULL, 0, NULL, NULL, 1500000, 1500000, 1, 2, NULL, NULL, '2024-05-09 00:15:40', '2024-05-09 00:15:40'),
(14, 'pr-20240512-061443', 1, 1, 1, 2, 1, 5, 33, 0, 0, 5280, 0, 0, 100, 500, 5680, 5000, 1, 1, NULL, NULL, '2024-05-12 00:00:00', '2024-05-16 11:19:31'),
(16, 'pr-20240519-115014', 1, 1, 1, 2, 1, 1, 1000, 0, 0, 100000, 0, 0, 0, 50, 100050, 15000, 1, 1, NULL, NULL, '2024-05-19 11:50:14', '2024-05-19 11:51:00'),
(17, 'pr-20240519-122210', 1, 1, 1, 2, 1, 3, 4, 0, 0, 2000, 0, 0, 0, 0, 2000, 0, 1, 1, NULL, NULL, '2024-05-19 12:22:10', '2024-05-19 12:22:10'),
(18, 'pr-20240519-012123', 1, 1, 1, 2, 1, 1, 3, 0, 0, 1250, 0, 0, 0, 0, 1250, 0, 1, 1, NULL, NULL, '2024-05-19 13:21:23', '2024-05-19 13:21:23'),
(19, 'pr-20240520-022115', 1, 1, 1, 2, 1, 1, 500, 0, 0, 62500, 0, 0, 0, 0, 62500, 6000, 1, 1, NULL, NULL, '2024-05-20 14:21:15', '2024-05-20 14:22:37'),
(20, 'pr-20240521-050205', 1, 1, 1, 2, 1, 2, 501, 0, 0, 150100, 0, 0, 0, 0, 150100, 150100, 1, 2, NULL, NULL, '2024-05-21 17:02:05', '2024-05-21 17:03:15'),
(21, 'pr-20240523-112630', 1, 1, 1, 2, 1, 2, 15, 0, 0, 2400, 0, 0, 10, 10, 2400, 2400, 1, 2, NULL, NULL, '2024-05-23 11:26:30', '2024-05-23 11:27:18'),
(22, 'pr-20240525-103123', 1, 1, 2, 2, 1, 2, 122, 0, 0, 61000, 0, 0, 500, 1000, 61500, 61500, 1, 2, NULL, NULL, '2024-05-25 22:31:23', '2024-05-25 22:34:10'),
(23, 'pr-20240528-045529', 1, 1, 3, 2, 1, 1, 1, 0, 0, 25000, 0, 0, 0, 0, 25000, 7200, 1, 1, NULL, NULL, '2024-05-28 16:55:29', '2024-05-28 16:56:46'),
(24, 'pr-20240528-045736', 1, 1, 3, 2, 1, 1, 10, 0, 0, 250000, 0, 0, 0, 0, 250000, 0, 1, 1, NULL, NULL, '2024-05-28 16:57:36', '2024-05-28 16:57:36'),
(25, 'pr-20240601-064217', 1, 1, 2, 2, 1, 2, 8, 0, 0, 9000, 0, 0, 30, 500, 9470, 9470, 1, 2, NULL, NULL, '2024-06-01 18:42:17', '2024-09-25 18:49:04'),
(26, 'pr-20240601-064342', 1, 1, 3, 2, 1, 1, 2, 0, 0, 940, 0, 0, 0, 0, 940, 940, 1, 2, NULL, NULL, '2024-06-01 18:43:42', '2024-06-01 18:45:19'),
(27, 'pr-20240605-101916', 1, 1, 1, 2, 1, 3, 159, 0, 0, 12720, 0, 0, 1200, 50, 11570, 11000, 1, 1, NULL, NULL, '2024-06-05 22:19:16', '2024-06-10 10:38:50'),
(28, 'pr-20240610-025125', 1, 1, 4, 2, 1, 1, 40, 0, 0, 48000, 0, 0, 0, 0, 48000, 48000, 1, 2, NULL, NULL, '2024-06-10 00:00:00', '2024-06-10 15:26:18'),
(29, 'pr-20240610-032518', 1, 1, 4, 2, 1, 1, 10, 0, 0, 12000, 0, 0, 0, 0, 12000, 0, 1, 1, NULL, NULL, '2024-06-10 00:00:00', '2024-06-10 15:25:18'),
(30, 'pr-20240610-041625', 1, 1, 4, 2, 1, 1, 20, 0, 0, 160000, 0, 0, 0, 0, 160000, 0, 1, 1, NULL, NULL, '2024-06-10 00:00:00', '2024-06-10 16:16:25'),
(31, 'pr-20240623-113303', 1, 1, 5, 2, 1, 1, 50, 0, 0, 1.2, 0, 0, 0, 200, 201.2, 0, 1, 1, NULL, NULL, '2024-07-01 00:00:00', '2024-07-30 16:42:25'),
(32, 'pr-20240623-113620', 1, 1, 5, 2, 1, 1, 10, 0, 0, 600, 0, 0, 0, 200, 800, 800, 1, 2, NULL, NULL, '2024-06-23 00:00:00', '2024-06-23 11:37:58'),
(33, 'pr-20240701-104304', 1, 1, 3, 2, 1, 2, 100, 2500, 0, 147500, 0, 0, 50, 10, 147460, 2410, 1, 1, NULL, NULL, '2024-07-01 00:00:00', '2024-07-30 16:41:47'),
(34, 'pr-20240702-082549', 1, 1, 6, 2, 1, 2, 7, 0, 0, 281000, 0, 0, 500, 1000, 281500, 281500, 1, 2, NULL, NULL, '2024-07-02 20:25:49', '2024-07-02 20:26:53'),
(35, 'pr-20240705-040434', 1, 2, NULL, 2, 1, 1, 10, 0, 0, 650, 0, 0, 0, 0, 650, 0, 1, 1, NULL, NULL, '2024-07-05 16:04:34', '2024-07-05 16:04:34'),
(36, 'pr-20240706-045417', 1, 1, 7, 2, 1, 1, 3200, 0, 0, 1600, 0, 0, 0, 60, 1660, 1600, 1, 1, NULL, NULL, '2024-07-06 16:54:17', '2024-07-06 16:54:39'),
(37, 'pr-20240706-045917', 1, 1, 7, 2, 1, 1, 1200, 0, 0, 600, 0, 0, 0, 0, 600, 0, 1, 1, NULL, NULL, '2024-07-06 16:59:17', '2024-07-06 16:59:17'),
(38, 'pr-20240706-045956', 1, 1, 7, 2, 1, 1, 1, 0, 0, 0.5, 0, 0, 0, 0, 0.5, 0, 1, 1, NULL, NULL, '2024-07-06 16:59:56', '2024-07-06 16:59:56'),
(39, 'pr-20240706-050106', 1, 1, 7, 2, 1, 1, 1000, 0, 0, 500, 0, 0, 0, 0, 500, 0, 1, 1, NULL, NULL, '2024-07-06 17:01:06', '2024-07-06 17:01:06'),
(40, 'pr-20240713-062703', 1, 1, 5, 2, 1, 2, 70, 0, 0, 11300, 0, 0, 200, 500, 11600, 5600, 1, 1, NULL, NULL, '2024-07-13 18:27:03', '2024-07-13 18:28:37'),
(41, 'pr-20240715-095739', 1, 1, 8, 2, 1, 1, 100, 0, 0, 6500, 0, 0, 0, 0, 6500, 6500, 1, 2, NULL, NULL, '2024-07-15 21:57:39', '2024-07-15 21:58:28'),
(42, 'pr-20240715-095759', 1, 1, 8, 2, 1, 1, 20, 0, 0, 2000, 0, 0, 0, 0, 2000, 1500, 1, 1, NULL, NULL, '2024-07-15 21:57:59', '2024-07-15 21:58:28'),
(43, 'pr-20240828-081156', 1, 1, 1, 2, 1, 1, 50, 0, 0, 3500, 0, 0, 0, 0, 3500, 0, 1, 1, NULL, NULL, '2024-08-28 20:11:56', '2024-08-28 20:11:56'),
(44, 'pr-20240829-123246', 1, 1, 3, 2, 1, 1, 50, 0, 0, 250000, 0, 0, 0, 0, 250000, 250000, 1, 2, NULL, NULL, '2024-08-29 00:00:00', '2024-09-05 12:52:56'),
(45, 'pr-20240901-021439', 1, 1, 6, 2, 1, 1, 2, 0, 0, 27198, 0, 0, 0, 0, 27198, 540, 1, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 17:10:44'),
(46, 'pr-20240902-124807', 1, 1, 9, 2, 1, 1, 600, 0, 0, 19200, 0, 0, 0, 0, 19200, 0, 1, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 12:48:07'),
(47, 'pr-20240902-124856', 1, 1, 9, 2, 1, 1, 550, 0, 0, 19250, 0, 0, 0, 0, 19250, 0, 1, 1, 'demo_20240902124856.jpg', NULL, '2024-09-02 00:00:00', '2024-09-02 12:48:56'),
(48, 'pr-20240902-125039', 1, 1, NULL, 2, 1, 1, 1000, 0, 0, 32000, 0, 0, 0, 0, 32000, 0, 1, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 12:50:39'),
(49, 'pr-20240902-011333', 1, 1, 9, 2, 1, 1, 20, 0, 0, 640, 0, 0, 0, 0, 640, 0, 1, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 13:13:33'),
(50, 'pr-20240902-024402', 1, 1, 9, 2, 1, 1, 6, 0, 0, 210, 0, 0, 10, 0, 200, 0, 4, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 14:44:02'),
(51, 'pr-20240902-030805', 1, 1, 9, 2, 12, 1, 15, 0, 0, 525, 0, 0, 0, 0, 525, 0, 1, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 15:08:05'),
(52, 'pr-20240902-050136', 1, 1, 1, 2, 1, 1, 1000, 0, 0, 35000, 0, 0, 0, 0, 35000, 0, 1, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 17:01:36'),
(53, 'pr-20240905-125115', 1, 1, 1, 2, 1, 2, 110, 0, 0, 4150, 0, 0, 0, 0, 4150, 0, 1, 1, NULL, NULL, '2024-09-05 00:00:00', '2024-09-05 12:51:15'),
(54, 'pr-20240908-011332', 1, 1, 2, 2, 1, 2, 8, 0, 0, 60200, 0, 0, 0, 0, 60200, 60200, 1, 2, NULL, NULL, '2024-09-08 13:13:32', '2024-09-25 18:49:04'),
(55, 'pr-20240909-015512', 1, 1, 10, 2, 1, 1, 100, 0, 0, 130000, 0, 0, 0, 0, 130000, 130000, 1, 2, NULL, NULL, '2024-09-09 00:00:00', '2024-09-10 20:03:22'),
(56, 'pr-20240909-030941', 1, 1, 3, 2, 445, 1, 50, 0, 0, 29500, 0, 0, 0, 100, 29600, 29600, 1, 2, NULL, NULL, '2024-09-09 00:00:00', '2024-09-09 15:16:49'),
(57, 'pr-20240909-031039', 1, 1, 3, 2, NULL, 1, 50, 0, 0, 22250, 0, 0, 0, 300, 22550, 0, 1, 1, NULL, NULL, '2024-09-09 00:00:00', '2024-09-09 15:10:39'),
(58, 'pr-20240909-031135', 1, 1, 3, 2, NULL, 1, 50, 0, 0, 22250, 0, 0, 0, 200, 22450, 0, 1, 1, NULL, NULL, '2024-09-02 00:00:00', '2024-09-09 15:11:35'),
(59, 'pr-20240909-081026', 1, 1, NULL, 2, 1, 1, 5, 0, 0, 6650, 0, 0, 0, 0, 6650, 6650, 1, 2, NULL, NULL, '2024-09-09 00:00:00', '2024-09-14 18:19:00'),
(60, 'pr-20240911-115255', 1, 1, 1, 2, 1, 1, 100, 0, 0, 133000, 0, 0, 0, 0, 133000, 0, 1, 1, NULL, NULL, '2024-09-11 00:00:00', '2024-09-11 11:52:55'),
(61, 'pr-20240914-094301', 1, 2, 3, 2, 1, 3, 3, 0, 0, 2365, 0, 0, 0, 0, 2365, 0, 1, 1, NULL, NULL, '2024-09-14 00:00:00', '2024-09-14 09:43:01'),
(62, 'pr-20240914-055017', 1, 2, 1, 2, 1, 3, 5, 0, 0, 12765, 0, 0, 0, 0, 12765, 4750, 1, 1, NULL, NULL, '2024-09-14 17:50:17', '2024-09-14 17:51:29'),
(63, 'pr-20240914-061845', 1, 2, 1, 2, 1, 1, 1, 0, 0, 2000, 0, 0, 0, 0, 2000, 0, 1, 1, NULL, NULL, '2024-09-14 18:18:45', '2024-09-14 18:18:45'),
(64, 'pr-20240915-120135', 1, 1, 1, 2, 1, 1, 17, 0, 0, 23800, 0, 0, 0, 0, 23800, 0, 1, 1, NULL, NULL, '2024-09-15 00:00:00', '2024-09-15 12:01:35'),
(65, 'pr-20240915-024701', 1, 1, NULL, 2, 1, 1, 5, 0, 0, 10000, 0, 0, 0, 0, 10000, 0, 1, 1, NULL, NULL, '2024-09-15 14:47:01', '2024-09-15 14:47:01'),
(66, 'pr-20240915-024805', 1, 1, 1, 2, 1, 1, 100, 0, 0, 145000, 0, 0, 0, 0, 145000, 0, 1, 1, NULL, NULL, '2024-09-15 00:00:00', '2024-09-15 14:48:05'),
(67, 'pr-20240915-052508', 1, 1, 2, 2, 1, 2, 110, 0, 0, 256500, 0, 0, 0, 0, 256500, 45330, 1, 1, NULL, NULL, '2024-09-14 00:00:00', '2024-09-25 18:49:04'),
(68, 'pr-20240917-104701', 1, 1, 1, 2, 1, 1, 14, 0, 0, 18200, 0, 0, 0, 0, 18200, 0, 1, 1, NULL, NULL, '2024-09-17 00:00:00', '2024-09-17 10:47:01'),
(69, 'pr-20240917-042447', 1, 1, 2, 2, 1, 1, 100, 0, 0, 5000, 0, 0, 0, 0, 5000, 0, 1, 1, NULL, NULL, '2024-09-17 16:24:47', '2024-09-17 16:24:47'),
(70, 'pr-20240921-114112', 1, 1, 1, 2, 1, 1, 100, 0, 0, 135000, 0, 0, 0, 0, 135000, 0, 1, 1, NULL, NULL, '2024-09-21 00:00:00', '2024-09-21 11:41:12'),
(71, 'pr-20240921-122650', 1, 1, 5, 2, 1, 1, 100, 0, 0, 120000, 0, 0, 0, 0, 120000, 0, 1, 1, NULL, NULL, '2024-09-21 00:00:00', '2024-09-21 12:26:50'),
(72, 'pr-20240921-123936', 1, 1, 2, 2, 1, 1, 1, 0, 0, 800, 0, 0, 0, 0, 800, 0, 1, 1, NULL, NULL, '2024-09-21 00:00:00', '2024-09-21 12:39:36'),
(73, 'pr-20240921-050933', 1, 1, 1, 2, 1, 1, 100, 0, 0, 3200, 0, 0, 0, 0, 3200, 0, 1, 1, NULL, NULL, '2024-09-18 00:00:00', '2024-09-21 17:09:33'),
(74, 'pr-20240924-124838', 1, 1, 1, 2, 1, 1, 1, 0, 0, 32, 0, 0, 0, 0, 32, 0, 1, 1, NULL, NULL, '2024-09-24 00:00:00', '2024-09-24 12:48:38'),
(75, 'pr-20240924-125654', 1, 1, 1, 2, 1, 1, 1, 0, 0, 32, 0, 0, 0, 0, 32, 0, 1, 1, NULL, NULL, '2024-09-24 00:00:00', '2024-09-24 12:56:54'),
(76, 'pr-20240924-011709', 1, 1, 1, 2, 1, 2, 110, 0, 0, 15700, 0, 0, 0, 0, 15700, 0, 1, 1, NULL, NULL, '2024-09-24 00:00:00', '2024-09-24 13:17:09'),
(77, 'pr-20240924-011839', 1, 1, 1, 2, 1, 1, 100, 0, 0, 3200, 0, 0, 0, 0, 3200, 0, 1, 1, NULL, NULL, '2024-09-24 00:00:00', '2024-09-24 13:18:39'),
(78, 'pr-20240924-013747', 1, 1, 1, 2, 1, 1, 100, 0, 0, 200000, 0, 0, 0, 0, 200000, 0, 1, 1, NULL, NULL, '2024-09-24 00:00:00', '2024-09-24 13:37:47'),
(79, 'pr-20240924-020432', 1, 1, 1, 2, 1, 2, 55, 0, 0, 52500, 0, 0, 0, 0, 52500, 0, 1, 1, NULL, NULL, '2024-09-24 14:04:32', '2024-09-24 14:04:32'),
(80, 'pr-20240925-011054', 1, 1, NULL, 2, 1, 1, 14, 0, 0, 20300, 0, 0, 0, 0, 20300, 0, 1, 1, NULL, NULL, '2024-09-25 00:00:00', '2024-09-25 13:10:54'),
(81, 'pr-20240926-050121', 1, 1, 5, 2, 1, 2, 11, 0, 0, 5052, 0, 0, 0, 0, 5052, 0, 1, 1, NULL, NULL, '2024-09-26 17:01:21', '2024-09-26 17:01:21'),
(82, 'pr-20240928-112332', 1, 1, 1, 2, 1000000, 1, 200, 0, 0, 100000, 0, 0, 0, 0, 100000, 0, 1, 1, NULL, NULL, '2024-09-28 00:00:00', '2024-09-28 11:27:16'),
(83, 'pr-20240928-123439', 1, 1, 5, 2, 1, 3, 115, 100, 0, 56000, 0, 0, 0, 0, 56000, 10000, 1, 1, NULL, NULL, '2024-09-28 12:34:39', '2024-09-28 12:36:19'),
(84, 'pr-20240929-120746', 1, 1, 7, 2, 1, 1, 300, 0, 0, 150, 0, 0, 0, 0, 150, 150, 1, 2, NULL, NULL, '2024-09-29 12:07:46', '2024-09-29 12:09:56'),
(85, 'pr-20240929-123245', 1, 1, 1, 2, 1, 1, 50, 0, 0, 32500, 0, 0, 0, 0, 32500, 0, 1, 1, NULL, NULL, '2024-09-29 00:00:00', '2024-09-29 12:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product_return`
--

CREATE TABLE `purchase_product_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `return_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_batch_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `imei_number` text DEFAULT NULL,
  `qty` double NOT NULL,
  `purchase_unit_id` int(11) NOT NULL,
  `net_unit_cost` double NOT NULL,
  `discount` double NOT NULL,
  `tax_rate` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `quotation_status` int(11) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `reference_no`, `user_id`, `biller_id`, `supplier_id`, `customer_id`, `warehouse_id`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_price`, `order_tax_rate`, `order_tax`, `order_discount`, `shipping_cost`, `grand_total`, `quotation_status`, `document`, `note`, `created_at`, `updated_at`) VALUES
(4, 'qr-20240524-015950', 1, 1, NULL, 1, 1, 1, 2, 0, 0, 68000, 0, 0, NULL, NULL, 68000, 1, NULL, NULL, '2024-05-24 13:59:50', '2024-05-24 13:59:50'),
(5, 'qr-20240601-031215', 1, 1, 1, 4, 2, 1, 1, 0, 0, 66, 0, 0, NULL, NULL, 66, 1, NULL, NULL, '2024-06-01 15:12:15', '2024-06-01 15:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `cash_register_id` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `staff_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `reference_no`, `user_id`, `sale_id`, `cash_register_id`, `customer_id`, `warehouse_id`, `biller_id`, `account_id`, `currency_id`, `exchange_rate`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_price`, `order_tax_rate`, `order_tax`, `grand_total`, `document`, `return_note`, `staff_note`, `created_at`, `updated_at`) VALUES
(1, 'rr-20240421-061155', 1, 11, 1, 3, 1, 1, 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2024-04-21 18:11:55', '2024-04-21 18:11:55'),
(2, 'rr-20240422-082006', 1, 17, 1, 4, 1, 1, 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2024-04-22 20:20:06', '2024-04-22 20:20:06'),
(3, 'rr-20240424-032317', 1, 18, 1, 1, 1, 1, 1, 2, 1, 1, 1, 0, 0, 80, 0, 0, 80, NULL, NULL, NULL, '2024-04-24 15:23:17', '2024-04-24 15:23:17'),
(4, 'rr-20240424-032423', 1, 17, 1, 4, 1, 1, 1, 2, 1, 1, 1, 0, 0, 650, 0, 0, 650, NULL, NULL, NULL, '2024-04-24 15:24:23', '2024-04-24 15:24:23'),
(5, 'rr-20240504-043758', 1, 24, 1, 1, 1, 1, 1, 2, 1, 1, 1, 0, 0, 200, 0, 0, 200, NULL, NULL, NULL, '2024-05-04 16:37:58', '2024-05-04 16:37:58'),
(6, 'rr-20240512-064150', 1, 34, 1, 1, 1, 1, 1, 2, 1, 1, 1, 0, 0, 200, 0, 0, 200, NULL, NULL, NULL, '2024-05-12 18:41:50', '2024-05-12 18:41:50'),
(7, 'rr-20240701-105259', 1, 69, 4, 5, 1, 1, 1, 2, 1, 1, 1, 0, 0, 80, 0, 0, 80, NULL, NULL, NULL, '2024-07-01 10:52:59', '2024-07-01 10:52:59'),
(9, 'rr-20240828-081820', 1, 100, 4, 19, 1, 1, 1, 2, 1, 1, 1, 0, 0, 100, 0, 0, 100, NULL, NULL, NULL, '2024-08-28 20:18:20', '2024-08-28 20:18:20'),
(10, 'rr-20240915-025555', 1, 166, 4, 1, 1, 1, 1, 2, 1, 1, 1, 0, 0, 1250, 0, 0, 1250, NULL, NULL, NULL, '2024-09-15 14:55:55', '2024-09-15 14:55:55'),
(11, 'rr-20240927-041808', 1, 189, 4, 1, 1, 1, 1, 2, 1, 1, 1, 0, 0, 40, 0, 0, 40, NULL, NULL, NULL, '2024-09-27 16:18:08', '2024-09-27 16:18:08'),
(12, 'rr-20240927-042100', 1, 188, 4, 2, 1, 1, 1, 2, 1, 1, 1, 0, 0, 3500, 0, 0, 3500, NULL, NULL, NULL, '2024-09-27 16:21:00', '2024-09-27 16:21:00'),
(13, 'rr-20240928-124852', 1, 190, 4, 33, 1, 1, 1, 2, 1, 1, 1, 0, 0, 35000, 0, 0, 35000, NULL, NULL, NULL, '2024-09-28 12:48:52', '2024-09-28 12:48:52'),
(14, 'rr-20240929-054237', 1, 198, 4, 1, 1, 1, 1, 2, 1, 1, 5, 0, 0, 400, 0, 0, 400, NULL, NULL, NULL, '2024-09-29 17:42:37', '2024-09-29 17:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `return_purchases`
--

CREATE TABLE `return_purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `return_note` text DEFAULT NULL,
  `staff_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reward_point_settings`
--

CREATE TABLE `reward_point_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `per_point_amount` double NOT NULL,
  `minimum_amount` double NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reward_point_settings`
--

INSERT INTO `reward_point_settings` (`id`, `per_point_amount`, `minimum_amount`, `duration`, `type`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1000, 5000, 3, 'Month', 1, '2024-09-30 12:26:14', '2024-09-30 12:26:14');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `guard_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`, `guard_name`) VALUES
(1, 'Admin', 'admin can access all data...', 1, '2018-06-01 23:46:44', '2018-06-02 23:13:05', 'web'),
(2, 'Owner', 'Staff of shop', 1, '2018-10-22 02:38:13', '2022-02-01 13:13:30', 'web'),
(4, 'staff', 'staff has specific acess...', 1, '2018-06-02 00:05:27', '2022-02-01 13:13:04', 'web'),
(5, 'Customer', NULL, 1, '2020-11-05 06:43:16', '2020-11-15 00:24:15', 'web'),
(6, 'Sales Men', NULL, 1, '2024-03-21 21:17:38', '2024-03-21 21:17:38', 'web'),
(7, 'Rasel Hossain', 'Developer', 1, '2024-06-10 10:29:14', '2024-06-10 10:29:14', 'web'),
(8, 'Manager', NULL, 1, '2024-09-02 11:49:46', '2024-09-02 11:49:46', 'web'),
(9, 'alif', NULL, 0, '2024-09-02 16:27:52', '2024-09-02 16:28:32', 'web');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(4, 1),
(4, 8),
(5, 1),
(5, 8),
(6, 1),
(6, 6),
(6, 8),
(7, 1),
(7, 6),
(7, 8),
(8, 1),
(8, 6),
(9, 1),
(9, 6),
(9, 8),
(10, 1),
(10, 8),
(11, 1),
(12, 1),
(12, 6),
(12, 8),
(13, 1),
(13, 6),
(13, 8),
(14, 1),
(14, 8),
(15, 1),
(16, 1),
(16, 6),
(17, 1),
(17, 6),
(18, 1),
(19, 1),
(20, 1),
(20, 6),
(21, 1),
(21, 6),
(22, 1),
(23, 1),
(24, 1),
(24, 6),
(25, 1),
(25, 6),
(26, 1),
(27, 1),
(28, 1),
(28, 6),
(29, 1),
(29, 6),
(30, 1),
(31, 1),
(32, 1),
(32, 6),
(33, 1),
(33, 6),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(55, 6),
(56, 1),
(56, 6),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(63, 6),
(64, 1),
(64, 6),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(73, 6),
(74, 1),
(74, 6),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(113, 6),
(114, 1),
(114, 6),
(114, 8),
(115, 1),
(115, 8),
(116, 1),
(117, 1),
(117, 6),
(117, 8),
(118, 1),
(118, 6),
(118, 8),
(119, 1),
(119, 8),
(120, 1),
(120, 8),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cash_register_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `queue` int(11) DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `biller_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_discount` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_price` double NOT NULL,
  `grand_total` double NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `exchange_rate` double DEFAULT NULL,
  `order_tax_rate` double DEFAULT NULL,
  `order_tax` double DEFAULT NULL,
  `order_discount_type` varchar(255) DEFAULT NULL,
  `order_discount_value` double DEFAULT NULL,
  `order_discount` double DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `coupon_discount` double DEFAULT NULL,
  `shipping_cost` double DEFAULT NULL,
  `sale_status` int(11) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `billing_name` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(255) DEFAULT NULL,
  `billing_email` varchar(255) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_phone` varchar(255) DEFAULT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `shipping_zip` varchar(255) DEFAULT NULL,
  `sale_type` varchar(255) DEFAULT 'pos',
  `payment_mode` varchar(255) DEFAULT NULL,
  `sale_note` text DEFAULT NULL,
  `staff_note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `reference_no`, `user_id`, `cash_register_id`, `table_id`, `queue`, `customer_id`, `warehouse_id`, `biller_id`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_price`, `grand_total`, `currency_id`, `exchange_rate`, `order_tax_rate`, `order_tax`, `order_discount_type`, `order_discount_value`, `order_discount`, `coupon_id`, `coupon_discount`, `shipping_cost`, `sale_status`, `payment_status`, `document`, `paid_amount`, `billing_name`, `billing_phone`, `billing_email`, `billing_address`, `billing_city`, `billing_state`, `billing_country`, `billing_zip`, `shipping_name`, `shipping_phone`, `shipping_email`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_country`, `shipping_zip`, `sale_type`, `payment_mode`, `sale_note`, `staff_note`, `created_at`, `updated_at`) VALUES
(1, 'posr-20240403-014248', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 130, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 50, 1, 4, NULL, 130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'sdf', 'sdfsd', '2024-04-03 01:42:48', '2024-04-03 01:42:48'),
(2, 'posr-20240403-014354', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-03 01:43:54', '2024-04-03 01:43:54'),
(3, 'posr-20240403-014508', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-03 01:45:08', '2024-04-03 01:45:08'),
(5, 'posr-20240404-010301', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 86, 2, 1, 0, 0, 'Flat', 4, 4, NULL, NULL, 10, 1, 4, NULL, 86, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-04 01:03:01', '2024-04-04 01:03:01'),
(6, 'posr-20240404-010330', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-04 01:03:30', '2024-04-04 01:03:30'),
(7, 'posr-20240404-010923', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-04 01:09:23', '2024-04-04 01:09:23'),
(8, 'posr-20240404-010929', 1, 1, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 160, 160, 2, 1, 0, 0, 'Flat', 0, 0, NULL, NULL, 0, 1, 4, NULL, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-04 00:00:00', '2024-09-25 18:46:48'),
(9, 'posr-20240407-093231', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-07 21:32:31', '2024-09-25 18:46:48'),
(10, 'posr-20240408-010059', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-08 01:00:59', '2024-09-25 18:46:48'),
(11, 'posr-20240418-071919', 1, 1, NULL, NULL, 3, 1, 1, 2, 11, 0, 0, 1000, 1000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-18 19:19:19', '2024-04-18 19:19:19'),
(12, 'posr-20240420-041227', 1, 1, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-20 16:12:27', '2024-04-20 16:12:27'),
(13, 'posr-20240420-055621', 1, 1, NULL, NULL, 1, 1, 1, 1, 4, 0, 0, 320, 320, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 320, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'jfyf', 'mkuju', '2024-04-20 17:56:21', '2024-04-20 17:56:21'),
(14, 'posr-20240421-060640', 1, 1, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 240, 240, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 240, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-21 18:06:40', '2024-04-21 18:06:40'),
(15, 'posr-20240421-100112', 1, 1, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-21 22:01:12', '2024-04-21 22:01:12'),
(16, 'posr-20240422-081333', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 600, 600, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-22 20:13:33', '2024-04-22 20:13:33'),
(17, 'posr-20240422-081542', 1, 1, NULL, NULL, 4, 1, 1, 1, 2, 0, 0, 1300, 1300, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 4, 2, NULL, 650, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-22 20:15:42', '2024-05-07 00:50:36'),
(18, 'posr-20240424-031834', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 4, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-24 15:18:34', '2024-04-24 15:23:17'),
(19, 'posr-20240424-032619', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-24 15:26:19', '2024-09-25 18:46:48'),
(20, 'posr-20240424-032751', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-24 15:27:51', '2024-04-24 15:27:51'),
(21, 'posr-20240428-030111', 1, 1, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-04-28 15:01:11', '2024-04-28 15:01:11'),
(22, 'posr-20240501-055429', 1, 1, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 5150, 5075, 2, 1, 0, 0, 'Flat', 75, 75, NULL, NULL, 0, 1, 4, NULL, 5075, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-01 17:54:29', '2024-05-01 17:54:29'),
(23, 'posr-20240501-115442', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, 'sdf', '2024-05-01 23:54:42', '2024-05-01 23:54:42'),
(24, 'posr-20240504-042844', 1, 1, NULL, NULL, 1, 1, 1, 3, 5, 0, 0, 1000, 945, 2, 1, 0, 0, 'Flat', 55, 55, NULL, NULL, 0, 1, 4, NULL, 945, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-04 16:28:44', '2024-05-04 16:28:44'),
(25, 'posr-20240506-073001', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-06 19:30:01', '2024-05-06 19:30:01'),
(26, 'posr-20240506-111134', 1, 1, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 160, 160, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-06 23:11:34', '2024-05-06 23:11:34'),
(27, 'posr-20240507-084446', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-07 20:44:46', '2024-05-07 20:44:46'),
(28, 'posr-20240509-122120', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 34000, 34000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 25310, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Monthly: 6000tk\r\nDuration: 4 Month\r\nEnd EMI Date: 09- Sep-2024', NULL, '2024-05-09 00:21:20', '2024-09-25 18:47:03'),
(29, 'posr-20240509-122720', 1, 2, NULL, NULL, 1, 2, 1, 1, 1, 0, 0, 34000, 34000, 2, 1, 0, 0, 'Flat', 0, 0, NULL, NULL, 0, 2, 4, NULL, 34000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-09 00:00:00', '2024-05-09 00:44:17'),
(30, 'posr-20240509-054912', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-09 17:49:12', '2024-05-09 17:49:12'),
(31, 'posr-20240509-055045', 1, 1, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-09 17:50:45', '2024-05-09 17:50:45'),
(33, 'posr-20240512-063253', 7, 3, NULL, NULL, 1, 1, 2, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-12 18:32:53', '2024-05-12 18:32:53'),
(34, 'posr-20240512-064036', 1, 1, NULL, NULL, 1, 1, 1, 1, 3, 0, 0, 600, 600, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-12 18:40:36', '2024-05-12 18:40:36'),
(37, 'posr-20240519-115310', 1, 4, NULL, NULL, 6, 1, 1, 2, 113, 0, 0, 13400, 13400, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 13400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-19 11:53:10', '2024-05-19 11:53:10'),
(38, 'posr-20240519-011521', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 0, 0, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 3, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-19 13:15:21', '2024-05-19 13:15:21'),
(39, 'posr-20240519-011534', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 0, 0, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 3, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-19 13:15:34', '2024-05-19 13:15:34'),
(40, 'posr-20240519-011700', 1, 4, NULL, NULL, 1, 1, 1, 1, 1.1, 0, 0, 825, 825, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 825, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-19 13:17:00', '2024-05-19 13:17:00'),
(41, 'posr-20240520-022556', 1, 4, NULL, NULL, 7, 1, 1, 2, 11, 0, 0, 1380, 1311, 2, 1, 0, 0, 'Percentage', 5, 69, NULL, NULL, 0, 1, 2, NULL, 500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-20 14:25:56', '2024-05-20 14:25:56'),
(42, 'posr-20240521-050559', 1, 4, NULL, NULL, 8, 1, 1, 1, 1, 0, 0, 500, 500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-21 17:05:59', '2024-05-21 17:05:59'),
(43, 'posr-20240521-050758', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 500, 500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-21 17:07:58', '2024-05-21 17:07:58'),
(44, 'posr-20240523-112818', 1, 4, NULL, NULL, 9, 1, 1, 1, 1, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-23 11:28:18', '2024-05-23 11:28:18'),
(45, 'posr-20240524-074817', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 240, 480, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 240, 1, 4, NULL, 480, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-24 19:48:17', '2024-05-24 19:48:17'),
(46, 'posr-20240525-114512', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 900, 900, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 900, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-25 11:45:12', '2024-05-25 11:45:12'),
(47, 'posr-20240525-114640', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 160, 160, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'FF', NULL, '2024-05-25 11:46:40', '2024-05-25 11:46:40'),
(48, 'posr-20240525-103742', 1, 4, NULL, NULL, 10, 1, 1, 1, 2, 0, 0, 1020, 1020, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1020, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-25 22:37:42', '2024-05-25 22:37:42'),
(49, 'posr-20240525-104114', 1, 4, NULL, NULL, 3, 1, 1, 2, 5, 0, 0, 7500, 7450, 2, 1, 0, 0, 'Flat', 100, 100, NULL, NULL, 50, 1, 2, NULL, 5000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-25 22:41:14', '2024-05-25 22:41:14'),
(50, 'posr-20240525-104927', 1, 4, NULL, NULL, 11, 1, 1, 2, 5, 0, 0, 86560, 86460, 2, 1, 0, 0, 'Flat', 100, 100, NULL, NULL, 0, 1, 4, NULL, 86460, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-25 22:49:27', '2024-05-25 22:52:28'),
(51, 'posr-20240528-045939', 1, 4, NULL, NULL, 12, 1, 1, 2, 2, 0, 0, 70500, 70500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 40000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-28 16:59:39', '2024-05-28 17:01:52'),
(52, 'posr-20240528-052629', 1, 4, NULL, NULL, 3, 1, 1, 1, 1, 0, 0, 28000, 28000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 20000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-05-28 17:26:29', '2024-05-28 17:26:29'),
(53, 'posr-20240531-121520', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Warranty 3 month', NULL, '2024-05-31 00:15:20', '2024-05-31 00:15:20'),
(54, 'posr-20240531-121639', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Sale Note', 'Staff Note', '2024-05-31 00:16:39', '2024-05-31 00:16:39'),
(55, 'posr-20240601-064703', 1, 4, NULL, NULL, 4, 1, 1, 1, 2, 0, 0, 1020, 1020, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'test', NULL, '2024-06-01 18:47:03', '2024-06-01 18:48:48'),
(56, 'posr-20240604-022048', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-04 14:20:48', '2024-06-04 14:20:48'),
(57, 'posr-20240605-113130', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-05 11:31:30', '2024-06-05 11:31:30'),
(58, 'posr-20240605-121340', 1, 4, NULL, NULL, 13, 1, 1, 1, 1, 0, 0, 300, 300, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 300, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-05 12:13:40', '2024-06-05 12:13:40'),
(59, 'posr-20240605-102800', 1, 4, NULL, NULL, 14, 1, 1, 2, 39, 0, 0, 3978, 3023.28, 2, 1, 0, 0, 'Percentage', 24, 954.7199999999999, NULL, NULL, 0, 1, 4, NULL, 3023.28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-05 22:28:00', '2024-06-05 22:28:00'),
(60, 'posr-20240605-104510', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 3, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-05 22:45:10', '2024-06-05 22:45:10'),
(61, 'posr-20240610-110621', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-10 00:00:00', '2024-06-10 11:06:21'),
(62, 'sr-20240610-111751', 1, 4, NULL, NULL, 15, 1, 1, 1, 1, 0, 0, 450, 490, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 40, 1, 4, NULL, 490, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-10 11:17:51', '2024-06-10 18:19:43'),
(63, 'sr-20240610-030228', 1, 4, NULL, NULL, 16, 1, 1, 1, 5, 0, 0, 6250, 5625, 2, 1, 0, 0, 'Percentage', 10, 625, NULL, NULL, 0, 1, 4, NULL, 5625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-10 00:00:00', '2024-06-10 15:02:28'),
(64, 'sr-20240610-041804', 1, 4, NULL, NULL, 16, 1, 1, 1, 5, 0, 0, 52500, 52500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-10 00:00:00', '2024-06-10 16:18:04'),
(65, 'posr-20240610-062809', 1, 4, NULL, NULL, 1, 1, 1, 3, 3, 0, 0, 760, 760, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 760, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-10 18:28:09', '2024-06-10 18:28:09'),
(66, 'sr-20240623-115526', 1, 4, NULL, NULL, 17, 1, 1, 1, 1, 0, 0, 1250, 1150, 2, 1, 0, 0, 'Flat', 100, 100, NULL, NULL, 0, 1, 4, NULL, 1150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-23 00:00:00', '2024-06-23 11:55:26'),
(67, 'posr-20240630-044402', 1, 4, NULL, NULL, 5, 1, 1, 2, 10, 0, 0, 880, 880, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 800, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-06-30 16:44:02', '2024-06-30 16:44:02'),
(68, 'posr-20240701-104749', 1, 4, NULL, NULL, 5, 1, 1, 2, 2, 0, 0, 580, 580, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-01 10:47:49', '2024-07-01 10:47:49'),
(69, 'posr-20240701-104905', 1, 4, NULL, NULL, 5, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 4, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-01 10:49:05', '2024-07-01 10:52:59'),
(70, 'posr-20240701-040159', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 1110, 1110, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1110, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-01 16:01:59', '2024-07-01 16:01:59'),
(71, 'posr-20240702-080855', 1, 4, NULL, NULL, 18, 1, 1, 1, 1, 0, 0, 34000, 34000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 9800, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Every Month Down Payment 4800tk. Total 6 Months', NULL, '2024-07-02 20:08:55', '2024-07-02 20:10:25'),
(72, 'posr-20240704-095959', 1, 4, NULL, NULL, 4, 1, 1, 1, 2, 0, 0, 68000, 68030, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 30, 1, 4, NULL, 68030, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-04 09:59:59', '2024-07-04 09:59:59'),
(73, 'posr-20240704-100029', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-04 10:00:29', '2024-07-04 10:00:29'),
(74, 'posr-20240704-100051', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 110, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 30, 1, 4, NULL, 110, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-04 10:00:51', '2024-07-04 10:00:51'),
(75, 'posr-20240704-095123', 1, 4, NULL, NULL, 3, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-04 21:51:23', '2024-07-04 21:51:23'),
(76, 'posr-20240705-040518', 1, 4, NULL, NULL, 5, 1, 1, 2, 2, 0, 0, 34130, 34130, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-05 16:05:18', '2024-07-05 16:05:18'),
(77, 'posr-20240705-041736', 1, 4, NULL, NULL, 6, 1, 1, 1, 1, 0, 0, 34000, 34000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Warranty 3 months', NULL, '2024-07-05 16:17:36', '2024-07-05 16:17:36'),
(78, 'posr-20240706-104951', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 34000, 34020, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 20, 1, 4, NULL, 34020, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-06 10:49:51', '2024-07-06 10:49:51'),
(79, 'posr-20240706-045544', 1, 4, NULL, NULL, 1, 1, 1, 1, 12, 0, 0, 12, 12, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-06 16:55:44', '2024-07-06 16:55:44'),
(80, 'posr-20240706-045745', 1, 4, NULL, NULL, 1, 1, 1, 1, 12, 0, 0, 12, 12, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-06 16:57:45', '2024-07-06 16:57:45'),
(81, 'posr-20240706-050240', 1, 4, NULL, NULL, 1, 1, 1, 1, 4177, 0, 0, 4177, 4177, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 4177, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-06 17:02:40', '2024-07-06 17:02:40'),
(82, 'posr-20240706-050316', 1, 4, NULL, NULL, 1, 1, 1, 1, 3, 0, 0, 3, 3, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-06 17:03:16', '2024-07-06 17:03:16'),
(83, 'posr-20240706-050344', 1, 4, NULL, NULL, 7, 1, 1, 1, 6, 0, 0, 6, 6, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-06 17:03:44', '2024-07-06 17:03:44'),
(84, 'sr-20240708-104601', 1, NULL, NULL, NULL, 18, 1, 2, 5, 10, 20, 0, 848, 848, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-08 10:46:01', '2024-07-08 10:46:01'),
(85, 'posr-20240711-102213', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 580, 580, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 580, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-11 10:22:13', '2024-07-11 10:22:13'),
(86, 'posr-20240712-023549', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-12 14:35:49', '2024-07-12 14:35:49'),
(87, 'posr-20240712-023631', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-12 14:36:31', '2024-07-12 14:36:31'),
(88, 'posr-20240713-063226', 1, 4, NULL, NULL, 3, 1, 1, 2, 7, 0, 0, 22025, 21825, 2, 1, 0, 0, 'Flat', 200, 200, NULL, NULL, 0, 1, 2, NULL, 20000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-13 18:32:26', '2024-07-13 18:32:26'),
(89, 'posr-20240715-021015', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 34500, 34500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-15 14:10:15', '2024-07-15 14:10:15'),
(90, 'posr-20240730-043819', 1, 4, NULL, NULL, 4, 1, 1, 10, 12, 0, 0, 75373, 75373, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 75373, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-30 00:00:00', '2024-07-30 16:38:19'),
(91, 'posr-20240730-044400', 1, 4, NULL, NULL, 1, 1, 1, 4, 8, 0, 0, 36660, 36660, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 36660, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-30 16:44:00', '2024-07-30 16:44:00'),
(92, 'posr-20240730-044837', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 750, 750, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 750, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-30 16:48:37', '2024-07-30 16:48:37'),
(93, 'posr-20240730-045009', 1, 4, NULL, NULL, 13, 1, 1, 4, 12, 0, 0, 37620, 37620, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 37620, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-07-30 16:50:09', '2024-07-30 16:50:09'),
(94, 'posr-20240809-025002', 1, 4, NULL, NULL, 1, 1, 1, 3, 3, 0, 0, 34200, 34200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-08-09 14:50:02', '2024-08-09 14:50:02'),
(95, 'posr-20240811-043131', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-08-11 04:31:31', '2024-08-11 04:31:31'),
(96, 'posr-20240816-120727', 1, 4, NULL, NULL, 2, 1, 1, 1, 2, 0, 0, 1000, 1000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-08-16 00:07:27', '2024-08-16 00:07:27'),
(97, 'posr-20240822-113912', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Sale Note', 'Staff Note', '2024-08-22 11:39:12', '2024-08-22 11:39:12'),
(98, 'posr-20240826-094125', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-08-26 21:41:25', '2024-08-26 21:41:25'),
(99, 'posr-20240827-011453', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-08-27 13:14:53', '2024-08-27 13:14:53'),
(100, 'posr-20240828-081529', 1, 4, NULL, NULL, 19, 1, 1, 1, 2, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 4, 2, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Total EMI: 5 Time\r\nMonthly EMI: 50tk', NULL, '2024-08-28 20:15:29', '2024-08-29 11:29:30'),
(101, 'posr-20240829-123624', 1, 4, NULL, NULL, 1, 1, 1, 1, 3, 0, 0, 16500, 15000, 2, 1, 0, 0, 'Flat', 1500, 1500, NULL, NULL, 0, 1, 4, NULL, 15000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-08-28 00:00:00', '2024-08-29 00:36:24'),
(102, '128', 1, 4, NULL, NULL, 20, 1, 1, 1, 2, 0, 0, 11000, 10500, 2, 1, 0, 0, 'Flat', 1000, 1000, NULL, NULL, 500, 1, 4, NULL, 10500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-08-28 00:00:00', '2024-08-29 00:41:27'),
(103, 'posr-20240829-124932', 1, 4, NULL, NULL, 20, 1, 1, 1, 2, 0, 0, 11000, 11000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 3000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'kisti', NULL, '2024-08-29 00:49:32', '2024-08-29 00:49:32'),
(104, 'posr-20240829-114933', 1, 4, NULL, NULL, 3, 1, 1, 3, 4, 0, 0, 62200, 62400, 2, 1, 0, 0, 'Flat', 200, 200, NULL, NULL, 400, 1, 2, NULL, 30000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'Monthly Total EMI: 5 times, Monthly EMI Bill: 10000', NULL, '2024-08-29 11:49:33', '2024-08-29 11:50:19'),
(105, 'posr-20240901-114659', 1, 4, NULL, NULL, 1, 1, 1, 5, 14, 0, 0, 31600, 31600, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 31600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-01 11:46:59', '2024-09-01 11:46:59'),
(106, 'posr-20240901-115902', 1, 4, NULL, NULL, 21, 1, 1, 2, 8, 0, 0, 866, 800, 2, 1, 0, 0, 'Flat', 66, 66, NULL, NULL, 0, 1, 2, NULL, 500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-01 11:59:02', '2024-09-01 11:59:02'),
(107, 'posr-20240901-123726', 1, 4, NULL, NULL, 22, 1, 1, 2, 2, 0, 0, 25122, 25000, 2, 1, 0, 0, 'Flat', 122, 122, NULL, NULL, 0, 1, 2, NULL, 20000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-01 12:37:26', '2024-09-01 12:37:26'),
(108, 'posr-20240902-125234', 1, 4, NULL, NULL, 22, 1, 2, 1, 4, 0, 0, 160, 160, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-01 00:00:00', '2024-09-02 12:52:34'),
(109, 'posr-20240902-125400', 1, 4, NULL, NULL, 22, 1, 2, 2, 7, 0, 0, 280, 260, 2, 1, 0, 0, 'Flat', 20, 20, NULL, NULL, 0, 1, 4, NULL, 260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-01 00:00:00', '2024-09-02 12:54:00'),
(110, 'alif', 1, 4, 1, 1, 1, 1, 1, 2, 2, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 12:56:36'),
(111, 'posr-20240902-050624', 1, 4, NULL, NULL, 22, 1, 1, 2, 5, 0, 0, 360, 360, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 260, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 17:06:24'),
(112, 'posr-20240902-050730', 1, 4, NULL, NULL, 21, 1, 1, 2, 2, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 17:07:30'),
(113, 'posr-20240902-050826', 1, 4, NULL, NULL, 21, 1, 1, 2, 2, 0, 0, 200, 180, 2, 1, 0, 0, 'Flat', 20, 20, NULL, NULL, 0, 1, 4, NULL, 180, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 17:08:26'),
(114, 'posr-20240902-051342', 1, 4, 1, 2, 1, 1, 1, 2, 2, 0, 0, 720, 720, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 720, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-05 00:00:00', '2024-09-02 17:13:42'),
(115, 'sr-20240902-053246', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 40, 40, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-02 17:32:46', '2024-09-02 17:32:46'),
(116, 'posr-20240902-062219', 1, 4, NULL, NULL, 1, 1, 1, 1, 4, 0, 0, 172, 170, 2, 1, 0, 0, 'Flat', 2, 2, NULL, NULL, 0, 1, 2, NULL, 150, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-02 18:22:19', '2024-09-02 18:22:19'),
(117, 'posr-20240904-125233', 1, 4, NULL, NULL, 1, 1, 1, 1, 4, 0, 0, 160, 140, 2, 1, 0, 0, 'Flat', 20, 20, NULL, NULL, 0, 1, 4, NULL, 140, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-04 12:52:33', '2024-09-04 12:52:33'),
(118, 'posr-20240904-010448', 1, 4, NULL, NULL, 1, 1, 1, 4, 4, 0, 0, 840, 840, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 1680, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-04 13:04:48', '2024-09-04 13:18:49'),
(119, 'posr-20240904-055303', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 160, 160, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'asd', NULL, '2024-09-04 17:53:03', '2024-09-04 17:53:03'),
(120, 'posr-20240904-055729', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 34130, 34130, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'asdfsdfsd', NULL, '2024-09-04 17:57:29', '2024-09-04 17:57:29'),
(121, 'posr-20240904-055808', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-04 17:58:08', '2024-09-04 17:58:08'),
(122, 'posr-20240904-060001', 1, 4, NULL, NULL, 1, 1, 1, 2, 3, 0, 0, 29000, 29000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 29000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'zsdfsdf', NULL, '2024-09-04 18:00:01', '2024-09-04 18:00:01'),
(123, 'posr-20240904-060115', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'dfsfd', NULL, '2024-09-04 18:01:15', '2024-09-04 18:01:15'),
(124, 'posr-20240904-060349', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'sdgdfg', NULL, '2024-09-04 18:03:49', '2024-09-04 18:03:49'),
(125, 'posr-20240904-060616', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'sfddf', NULL, '2024-09-04 18:06:16', '2024-09-04 18:06:16'),
(126, 'posr-20240904-060858', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'sfddf', NULL, '2024-09-04 18:08:58', '2024-09-04 18:08:58'),
(127, 'posr-20240905-110055', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-05 11:00:55', '2024-09-05 11:00:55'),
(128, 'posr-20240905-125613', 1, 4, NULL, NULL, 5, 1, 1, 2, 5, 0, 0, 480, 470, 2, 1, 0, 0, 'Flat', 10, 10, NULL, NULL, 0, 1, 4, NULL, 470, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-05 12:56:13', '2024-09-05 12:56:13'),
(129, 'posr-20240905-125624', 1, 4, NULL, NULL, 1, 1, 1, 3, 3, 0, 0, 800, 800, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 800, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-05 12:56:24', '2024-09-05 12:56:24'),
(130, 'posr-20240906-031506', 1, 4, NULL, NULL, 4, 1, 1, 1, 1, 0, 0, 34000, 34000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-06 15:15:06', '2024-09-06 15:15:06'),
(131, 'posr-20240908-101249', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-08 10:12:49', '2024-09-08 10:12:49'),
(132, 'posr-20240908-104141', 1, 4, NULL, NULL, 25, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-08 10:41:41', '2024-09-08 10:41:41'),
(133, 'posr-20240908-011747', 1, 4, NULL, NULL, 26, 1, 1, 2, 5, 0, 0, 392, 342, 2, 1, 0, 0, 'Flat', 50, 50, NULL, NULL, 0, 1, 2, NULL, 300, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-08 13:17:47', '2024-09-08 13:21:00'),
(134, 'posr-20240908-011849', 1, 4, NULL, NULL, 11, 1, 1, 1, 100, 0, 0, 100, 100, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-08 13:18:49', '2024-09-08 13:18:49'),
(135, 'posr-20240908-040920', 1, 4, NULL, NULL, 27, 1, 1, 1, 1, 0, 0, 34000, 34000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-08 16:09:20', '2024-09-08 16:09:20'),
(136, 'posr-20240909-102541', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 10:25:41', '2024-09-09 10:25:41'),
(137, 'posr-20240909-102639', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 1, 1, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 10:26:39', '2024-09-09 10:26:39'),
(138, 'posr-20240909-020243', 1, 4, NULL, NULL, 28, 1, 1, 1, 5, 0, 0, 6750, 6700, 2, 1, 0, 0, 'Flat', 50, 50, NULL, NULL, 0, 1, 2, NULL, 4700, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 00:00:00', '2024-09-09 14:15:00'),
(139, 'posr-20240909-020458', 1, 4, NULL, NULL, 5, 1, 1, 1, 5, 0, 0, 6750, 6700, 2, 1, 0, 0, 'Flat', 50, 50, NULL, NULL, 0, 1, 2, NULL, 2000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 00:00:00', '2024-09-09 14:04:58'),
(140, 'posr-20240909-020656', 1, 4, NULL, NULL, 5, 1, 1, 1, 5, 0, 0, 6750, 6700, 2, 1, 0, 0, 'Flat', 50, 50, NULL, NULL, 0, 1, 4, NULL, 6700, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 00:00:00', '2024-09-09 14:06:56'),
(141, 'posr-20240909-021830', 1, 4, NULL, NULL, 1, 1, 1, 1, 20, 0, 0, 800, 800, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 800, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 00:00:00', '2024-09-09 14:18:30'),
(142, 'posr-20240909-023902', 1, 4, NULL, NULL, 1, 1, 1, 1, 7, 0, 0, 9450, 9450, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 1000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 14:39:02', '2024-09-09 14:39:02'),
(144, 'posr-20240909-032445', 1, 4, NULL, NULL, 29, 1, 1, 2, 7, 0, 0, 3910, 3323.5, 2, 1, 0, 0, 'Percentage', 15, 586.5, NULL, NULL, 0, 1, 4, NULL, 3323.5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-09 00:00:00', '2024-09-09 15:24:45'),
(145, 'sr-20240909-032816', 1, 4, NULL, NULL, 19, 1, 1, 1, 1, 0, 0, 490, 490, 2, 1, 0, 0, 'Percentage', 0, 0, NULL, NULL, 0, 1, 4, NULL, 490, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-02 00:00:00', '2024-09-09 15:28:16'),
(146, 'posr-20240910-080405', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 1, 1, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-10 20:04:05', '2024-09-10 20:04:05'),
(147, 'posr-20240910-082222', 1, 4, NULL, NULL, 6, 1, 1, 2, 4, 0, 0, 4790, 4790, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 4790, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-10 20:22:22', '2024-09-10 20:22:22'),
(148, 'posr-20240911-115644', 1, 4, NULL, NULL, 1, 1, 1, 1, 20, 0, 0, 28800, 28800, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 20000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 11:56:44', '2024-09-11 11:56:44'),
(149, 'posr-20240911-120310', 1, 4, NULL, NULL, 1, 1, 1, 3, 9, 0, 0, 1523, 1523, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1523, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 12:03:10', '2024-09-11 12:03:10'),
(150, 'posr-20240911-120607', 1, 4, NULL, NULL, 1, 1, 1, 1, 20, 0, 0, 27000, 27000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 20000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 12:06:07', '2024-09-11 12:06:07'),
(151, 'posr-20240911-121203', 1, 4, NULL, NULL, 1, 1, 1, 1, 3, 0, 0, 4320, 4320, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 2000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 12:12:03', '2024-09-11 12:12:03'),
(152, 'posr-20240911-121515', 1, 4, NULL, NULL, 30, 1, 1, 1, 4, 0, 0, 5760, 5760, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 5760, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 12:15:15', '2024-09-11 12:15:15'),
(153, 'posr-20240911-122906', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 2880, 2880, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 2000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 12:29:06', '2024-09-11 12:29:06'),
(154, 'posr-20240911-011128', 1, 4, NULL, NULL, 4, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 00:00:00', '2024-09-11 13:11:28'),
(155, 'posr-20240911-013431', 1, 4, NULL, NULL, 5, 1, 1, 1, 5, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-11 13:34:31', '2024-09-11 13:34:31'),
(156, 'posr-20240912-023313', 1, 4, NULL, NULL, 6, 1, 1, 1, 5, 0, 0, 400, 400, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-12 14:33:13', '2024-09-12 14:33:13'),
(157, 'posr-20240912-023720', 1, 4, NULL, NULL, 1, 1, 1, 1, 4, 0, 0, 160, 160, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-12 14:37:20', '2024-09-12 14:37:20'),
(158, 'posr-20240912-092750', 1, 4, NULL, NULL, 29, 1, 1, 2, 5, 0, 0, 2769.88, 2492.88, 2, 1, NULL, 0, NULL, NULL, 277, NULL, NULL, 0, 1, 4, NULL, 2492.88, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-12 21:27:50', '2024-09-12 21:27:50'),
(159, 'posr-20240914-012348', 1, 4, NULL, NULL, 5, 1, 1, 1, 5, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 120, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-14 13:23:48', '2024-09-14 13:23:48'),
(160, 'posr-20240914-041506', 1, 4, NULL, NULL, 1, 1, 1, 2, 3, 0, 0, 760, 760, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 760, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-14 16:15:06', '2024-09-14 16:15:06'),
(161, 'posr-20240914-055416', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 1018, 1018, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1018, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-14 17:54:16', '2024-09-14 17:54:16'),
(162, 'sr-20240914-102203', 1, 4, NULL, NULL, 2, 1, 1, 1, 1, 0, 0, 450, 450, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 450, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-14 22:22:03', '2024-09-24 14:21:10'),
(163, 'posr-20240914-102959', 1, 4, NULL, NULL, 1, 1, 1, 1, 4, 0, 0, 320, 320, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 320, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-14 22:29:59', '2024-09-14 22:29:59'),
(164, 'posr-20240915-024835', 1, 4, NULL, NULL, 1, 1, 1, 1, 3, 0, 0, 102000, 102000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 102000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-15 14:48:35', '2024-09-15 14:48:35');
INSERT INTO `sales` (`id`, `reference_no`, `user_id`, `cash_register_id`, `table_id`, `queue`, `customer_id`, `warehouse_id`, `biller_id`, `item`, `total_qty`, `total_discount`, `total_tax`, `total_price`, `grand_total`, `currency_id`, `exchange_rate`, `order_tax_rate`, `order_tax`, `order_discount_type`, `order_discount_value`, `order_discount`, `coupon_id`, `coupon_discount`, `shipping_cost`, `sale_status`, `payment_status`, `document`, `paid_amount`, `billing_name`, `billing_phone`, `billing_email`, `billing_address`, `billing_city`, `billing_state`, `billing_country`, `billing_zip`, `shipping_name`, `shipping_phone`, `shipping_email`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_country`, `shipping_zip`, `sale_type`, `payment_mode`, `sale_note`, `staff_note`, `created_at`, `updated_at`) VALUES
(165, 'posr-20240915-024938', 1, 4, NULL, NULL, 1, 1, 1, 3, 42, 0, 0, 61180, 61180, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 40000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-15 14:49:38', '2024-09-15 14:49:38'),
(166, 'posr-20240915-025026', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 1250, 1250, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 4, 2, NULL, 1100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-15 14:50:26', '2024-09-15 14:55:55'),
(167, 'posr-20240916-121547', 1, 4, NULL, NULL, 31, 1, 1, 1, 1, 0, 0, 120, 120, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 50, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-16 12:15:47', '2024-09-16 12:16:38'),
(168, 'posr-20240916-015844', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-16 13:58:44', '2024-09-16 13:58:44'),
(169, 'sr-20240917-121115', 1, 2, NULL, NULL, 3, 2, 1, 1, 1, 0, 0, 450, 450, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-17 00:11:15', '2024-09-17 00:11:15'),
(170, 'sr-20240917-121312', 1, 4, NULL, NULL, 30, 1, 2, 1, 1, 0, 0, 40, 40, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-17 00:13:12', '2024-09-17 00:13:12'),
(171, 'posr-20240917-041517', 1, 4, NULL, NULL, 5, 1, 1, 1, 1, 0, 0, 500, 500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-17 16:15:17', '2024-09-17 16:15:17'),
(172, 'posr-20240917-041617', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 130, 130, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 130, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-17 16:16:17', '2024-09-17 16:16:17'),
(173, 'posr-20240918-022303', 1, 4, NULL, NULL, 1, 1, 1, 2, 4, 0, 0, 360, 420, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 60, 1, 4, NULL, 420, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-18 14:23:03', '2024-09-18 14:23:03'),
(174, 'posr-20240918-024037', 1, 4, NULL, NULL, 1, 1, 1, 1, 10, 0, 0, 400, 400, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-18 14:40:37', '2024-09-18 14:40:37'),
(175, 'posr-20240918-041942', 1, 4, 1, 1, 2, 1, 1, 2, 19, 0, 0, 43940, 43940, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 43940, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-18 00:00:00', '2024-09-18 16:19:42'),
(176, 'posr-20240921-123002', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 3200, 3200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 3000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-21 00:00:00', '2024-09-21 12:30:02'),
(177, 'posr-20240921-123056', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 3200, 3200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 3000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-21 00:00:00', '2024-09-21 12:30:56'),
(178, 'posr-20240921-124108', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 1200, 1200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 800, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-21 12:41:08', '2024-09-21 12:41:08'),
(179, 'posr-20240921-035652', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 34000, 34000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 34000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-21 15:56:52', '2024-09-21 15:56:52'),
(180, '1234', 1, 4, 1, 1, 8, 1, 1, 1, 2, 0, 0, 160, 160, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 160, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-22 00:00:00', '2024-09-24 15:54:41'),
(181, 'gg', 1, 4, NULL, NULL, 8, 1, 2, 1, 1, 0, 0, 450, 450, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 450, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-24 00:00:00', '2024-09-24 15:54:41'),
(182, 'posr-20240924-012329', 1, 4, NULL, NULL, 5, 1, 1, 1, 10, 0, 0, 400, 400, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 220, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-24 13:23:29', '2024-09-24 13:23:29'),
(183, 'sr-20240924-022025', 1, 4, NULL, NULL, 2, 1, 1, 2, 60, 0, 0, 1704500, 1704500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1704500, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-24 14:20:25', '2024-09-24 14:21:53'),
(184, 'posr-20240925-063416', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 80, 80, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 80, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-25 18:34:16', '2024-09-25 18:34:16'),
(185, 'posr-20240925-063641', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 200, 200, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-25 18:36:41', '2024-09-25 18:36:41'),
(186, 'sr-20240925-064510', 1, 4, NULL, NULL, 2, 1, 1, 1, 1, 0, 0, 600, 600, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-25 18:45:10', '2024-09-25 18:45:10'),
(187, 'posr-20240925-070835', 1, 4, NULL, NULL, 1, 1, 1, 1, 4, 0, 0, 136000, 136000, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 136000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-25 19:08:35', '2024-09-25 19:15:51'),
(188, 'posr-20240926-050538', 1, 4, NULL, NULL, 2, 1, 1, 1, 1, 0, 0, 3500, 3500, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 4, 2, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-26 17:05:38', '2024-09-27 16:22:31'),
(189, 'posr-20240927-041357', 1, 4, NULL, NULL, 1, 1, 1, 3, 38, 0, 0, 23260, 23000, 2, 1, 0, 0, 'Flat', 260, 260, NULL, NULL, 0, 1, 2, NULL, 22960, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-27 16:13:57', '2024-09-27 16:25:27'),
(190, 'posr-20240928-124020', 1, 4, NULL, NULL, 33, 1, 1, 1, 1, 0, 0, 35000, 34900, 2, 1, 0, 0, 'Flat', 100, 100, NULL, NULL, 0, 4, 2, NULL, -100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, 'EMI Payment Monthly: 5000tk || Total 5 Times.', NULL, '2024-09-28 12:40:20', '2024-09-28 12:49:49'),
(191, 'posr-20240929-123446', 1, 4, NULL, NULL, 1, 1, 1, 2, 6, 0, 0, 6690, 6690, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 6690, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 12:34:46', '2024-09-29 12:34:46'),
(192, 'mosh', 1, 4, NULL, NULL, 30, 1, 1, 1, 1, 0, 0, 1400, 1400, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 12:41:05', '2024-09-29 12:41:05'),
(193, 'posr-20240929-124317', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 1280, 1280, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 1200, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 12:43:17', '2024-09-29 12:43:17'),
(194, 'sr-20240929-012509', 1, 4, NULL, NULL, 1, 1, 2, 1, 1, 0, 0, 650, 650, 2, 1000, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 650, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 00:00:00', '2024-09-29 13:25:09'),
(195, 'posr-20240929-013745', 1, 4, NULL, NULL, 1, 1, 1, 1, 2, 0, 0, 2560, 2560, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 2400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 13:37:45', '2024-09-29 13:37:45'),
(196, 'posr-20240929-014459', 1, 4, NULL, NULL, 30, 1, 1, 1, 2, 0, 0, 2560, 2560, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 2560, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 13:44:59', '2024-09-29 13:44:59'),
(197, 'posr-20240929-015229', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 1400, 1400, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 13:52:29', '2024-09-29 13:52:29'),
(198, 'posr-20240929-033614', 1, 4, NULL, NULL, 1, 1, 1, 3, 30, 0, 0, 8880, 8880, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 2, NULL, 8480, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-29 15:36:14', '2024-09-29 17:43:12'),
(199, 'posr-20240930-061513', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 600, 540, 2, 1, 0, 0, 'Percentage', 10, 60, NULL, NULL, 0, 1, 4, NULL, 540, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-30 18:15:13', '2024-09-30 18:15:13'),
(200, 'posr-20240930-061841', 1, 4, NULL, NULL, 1, 1, 1, 1, 1, 0, 0, 1, 1, 2, 1, 0, 0, 'Percentage', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-09-30 18:18:41', '2024-09-30 18:18:41'),
(201, 'posr-20241001-120049', 1, 4, NULL, NULL, 1, 1, 1, 2, 2, 0, 0, 2720, 2720, 2, 1, 0, 0, 'Flat', NULL, 0, NULL, NULL, 0, 1, 4, NULL, 2720, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pos', NULL, NULL, NULL, '2024-10-01 12:00:49', '2024-10-01 12:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `icon` text DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_counts`
--

CREATE TABLE `stock_counts` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `brand_id` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `initial_file` varchar(255) DEFAULT NULL,
  `final_file` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_adjusted` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_counts`
--

INSERT INTO `stock_counts` (`id`, `reference_no`, `warehouse_id`, `category_id`, `brand_id`, `user_id`, `type`, `initial_file`, `final_file`, `note`, `is_adjusted`, `created_at`, `updated_at`) VALUES
(1, 'scr-20240407-024423', 1, NULL, NULL, 1, 'full', '20240407-024423.csv', NULL, NULL, 0, '2024-04-07 02:44:23', '2024-04-07 02:44:23'),
(2, 'scr-20240528-052115', 1, NULL, NULL, 1, 'full', '20240528-052115.csv', NULL, NULL, 0, '2024-05-28 17:21:15', '2024-05-28 17:21:15'),
(3, 'scr-20240528-052250', 1, NULL, NULL, 1, 'full', '20240528-052250.csv', NULL, NULL, 0, '2024-05-28 17:22:50', '2024-05-28 17:22:50'),
(4, 'scr-20240623-120307', 2, NULL, NULL, 1, 'full', '20240623-120307.csv', NULL, NULL, 0, '2024-06-23 12:03:07', '2024-06-23 12:03:07'),
(5, 'scr-20240701-051804', 1, NULL, NULL, 1, 'full', '20240701-051804.csv', NULL, NULL, 0, '2024-07-01 17:18:04', '2024-07-01 17:18:04'),
(6, 'scr-20240902-010436', 1, NULL, NULL, 1, 'full', '20240902-010436.csv', NULL, NULL, 0, '2024-09-02 13:04:36', '2024-09-02 13:04:36'),
(7, 'scr-20240902-010735', 1, '40', '15', 1, 'partial', '20240902-010735.csv', NULL, NULL, 0, '2024-09-02 13:07:35', '2024-09-02 13:07:35'),
(8, 'scr-20240915-052232', 1, NULL, NULL, 1, 'full', '20240915-052232.csv', NULL, NULL, 0, '2024-09-15 17:22:32', '2024-09-15 17:22:32'),
(9, 'scr-20241001-110951', 1, NULL, NULL, 1, 'full', '20241001-110951.csv', NULL, NULL, 0, '2024-10-01 11:09:51', '2024-10-01 11:09:51'),
(10, 'scr-20241001-124751', 1, NULL, NULL, 1, 'full', '20241001-124751.csv', NULL, NULL, 0, '2024-10-01 12:47:51', '2024-10-01 12:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) NOT NULL,
  `vat_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `image`, `company_name`, `vat_number`, `email`, `phone_number`, `address`, `city`, `state`, `postal_code`, `country`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Rofik Mia', NULL, 'Denim', NULL, 'niloybanik0000@gmail.com', '01310223888', 'Sunamganj, Sylhet, Bangladesh', 'Sunamganj', NULL, '3070', 'Bangladesh', 1, '2024-04-18 19:15:08', '2024-04-18 19:15:08'),
(2, 'Minhaz (Walton)', NULL, 'Walton', NULL, 'mindsf@gmail.com', '01919011229', 'House 20, Road 01, Sector 9, Uttara,Dhaka', 'Uttaradit', NULL, '1230', 'Bangladesh', 1, '2024-05-25 22:26:44', '2024-05-25 22:26:44'),
(3, 'Ali Hoshain', NULL, 'waton', NULL, 'contact@sherazimart.com', '01819011229', 'House 20, Road 1, Sector 9, Uttara', 'Uttara', NULL, '1230', 'Bangladesh', 1, '2024-05-28 16:54:27', '2024-05-28 16:54:27'),
(4, 'Sheam', NULL, 'Sheam Electric', NULL, 'akterh83@gmail.com', '01834555007', 'Nababpur', 'Dhaka', NULL, NULL, NULL, 1, '2024-06-10 14:50:00', '2024-06-10 14:50:00'),
(5, 'Md Sumon', NULL, 'NPT', NULL, 'npt@gmail.com', '018899999', 'House 20, Road 1, Sector 9, Uttara', 'Uttara', 'Dhaka', '1230', 'Bangladesh', 1, '2024-06-23 11:29:51', '2024-06-23 11:29:51'),
(6, 'Sagor', NULL, 'Oppo', NULL, 'sagor@gmail.com', '01785258241', 'dhaka 1208', 'dhaka', NULL, NULL, NULL, 1, '2024-07-02 20:18:39', '2024-07-02 20:18:39'),
(7, 'Beximco Pharmaceutical', NULL, 'Beximco Pharmaceuticals Ltd', NULL, 'Beximco@gmail.com', '018190112267', 'House 20, Road 1, Sector 9, Uttara', 'Uttara', NULL, '1230', 'Bangladesh', 1, '2024-07-06 10:52:37', '2024-07-06 10:52:37'),
(8, 'Al Amin Hossain', 'ParanCompany.png', 'Paran Company', NULL, 'contact@Paran.com', '01819011321', 'Sector 9, Uttara', 'Uttara', NULL, NULL, NULL, 1, '2024-07-15 21:56:23', '2024-07-15 21:56:58'),
(9, 'rohim mia', NULL, 'product ltd', '23', 'rohim123@gmail.com', '01788729031', 'uttara dhaka', 'dhaka', NULL, NULL, 'Bangladesh', 1, '2024-09-02 12:45:27', '2024-09-02 12:45:27'),
(10, 'Namuzl hasan', NULL, 'MEDi surgical', NULL, 'najmulhasan123@gmail', '1233556787', 'dhaka', 'dhaka', NULL, NULL, NULL, 1, '2024-09-09 13:53:19', '2024-09-09 13:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `number_of_person` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `number_of_person`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'demo', 9, 'its our company table', 1, '2024-09-01 15:32:21', '2024-09-01 15:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` double NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'no tax', 0, 1, '2024-07-08 10:44:57', '2024-07-08 10:45:08');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` int(10) UNSIGNED NOT NULL,
  `reference_no` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `from_warehouse_id` int(11) NOT NULL,
  `to_warehouse_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `total_qty` double NOT NULL,
  `total_tax` double NOT NULL,
  `total_cost` double NOT NULL,
  `shipping_cost` double DEFAULT NULL,
  `grand_total` double NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `reference_no`, `user_id`, `status`, `from_warehouse_id`, `to_warehouse_id`, `item`, `total_qty`, `total_tax`, `total_cost`, `shipping_cost`, `grand_total`, `document`, `note`, `created_at`, `updated_at`) VALUES
(1, 'tr-20240610-102659', 1, 1, 1, 2, 1, 2, 0, 600, 50, 650, NULL, NULL, '2024-06-10 00:00:00', '2024-06-10 10:26:59'),
(2, 'tr-20240901-025824', 1, 1, 1, 2, 1, 4, 0, 54396, NULL, 54396, NULL, NULL, '2024-09-02 00:00:00', '2024-09-01 14:58:24'),
(3, 'tr-20240902-024644', 1, 2, 1, 2, 1, 3, 0, 96, NULL, 96, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 14:46:44'),
(4, 'tr-20240902-051430', 1, 1, 1, 2, 1, 15, 0, 525, NULL, 525, NULL, NULL, '2024-09-02 00:00:00', '2024-09-02 17:14:30'),
(5, 'tr-20240917-042547', 1, 1, 1, 2, 1, 30, 0, 1500, NULL, 1500, NULL, NULL, '2024-09-17 16:25:47', '2024-09-17 16:25:47'),
(6, 'tr-20240929-013958', 1, 1, 1, 2, 1, 100, 0, 50000, 100, 50100, NULL, NULL, '2024-09-29 00:00:00', '2024-09-29 13:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_code` varchar(255) NOT NULL,
  `unit_name` varchar(255) NOT NULL,
  `base_unit` int(11) DEFAULT NULL,
  `operator` varchar(255) DEFAULT NULL,
  `operation_value` double DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_code`, `unit_name`, `base_unit`, `operator`, `operation_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Kg', 'Kg', NULL, '*', 1, 1, '2024-04-01 10:08:52', '2024-04-01 10:08:52'),
(2, 'Pisces', 'Pisces', NULL, '*', 1, 1, '2024-04-01 10:10:02', '2024-04-01 10:10:02'),
(3, 'Dorgon', 'Dorgon', 2, '1', 12, 1, '2024-04-20 16:22:55', '2024-04-20 16:22:55'),
(4, '8998989', 'Fit', NULL, '*', 1, 1, '2024-05-01 18:02:01', '2024-05-01 18:02:01'),
(5, '657', 'Bosta', NULL, '*', 1, 0, '2024-05-01 18:08:12', '2024-05-01 18:36:15'),
(6, '8768', '25 kg', NULL, '*', 1, 0, '2024-05-01 18:10:19', '2024-05-01 18:34:19'),
(7, '5464', 'Bosta', 1, '*', 25, 1, '2024-05-01 18:36:41', '2024-05-01 18:36:41'),
(8, 'Box(25)', 'Box(25)', 2, '*', 25, 1, '2024-05-19 12:09:54', '2024-05-19 12:09:54'),
(9, 'Service', 'Service', NULL, '*', 1, 1, '2024-06-05 12:01:55', '2024-06-05 12:01:55'),
(10, '001', '1 Bag', 1, '50', 50, 1, '2024-06-23 11:19:14', '2024-06-23 11:19:14'),
(11, '6783', 'litter', NULL, '*', 1, 1, '2024-09-02 11:28:11', '2024-09-02 11:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `biller_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `company_name`, `role_id`, `biller_id`, `warehouse_id`, `is_active`, `is_deleted`) VALUES
(1, 'demo', 'demo@gmail.com', '$2y$10$mLyIDR5h3DA3SQuzMRgOm.9aXUeDNVwgUqAcJccKvnjJPUyZq7p.K', '1Ttd0AGpNRVcLClChMXJqOHN9ktyLyc3qGbjYWH9DVoHwWfhX4bmBH7u1u6B', '2018-06-02 03:24:15', '2018-09-05 00:14:15', '1819011229', 'demo', 1, NULL, NULL, 1, 0),
(2, 'Khondokar', 'kishorsanitaryandtiles@gmail.com', '$2y$10$zTRa.R/IcFWKoxqVhQ6gteIVjkGG2P4Py2RiH7B74PTHbjQ3Zn862', NULL, '2024-03-17 23:16:12', '2024-03-17 23:16:12', '01707991020', 'Kishor Sanitary', 2, NULL, NULL, 0, 0),
(3, 'ruku99', 'rukunujjamancub@gmail.com', '$2y$10$ft0spqDS9SfR4H/LAfAdvecOwpSo8a1ntsdk4khoa4izRtmK50FY6', NULL, '2024-03-18 10:48:20', '2024-03-18 10:48:20', '01316595561', 'SSR Limited', 1, NULL, NULL, 0, 0),
(4, 'Aliha', 'reazuli656@gmail.com', '$2y$10$nRt/U4itrGpsDHzd9Hi9cez6cE6YYR58.hITrDh/9V5LpA8BGmREK', NULL, '2024-03-19 10:29:51', '2024-03-19 10:29:51', '01608967880', NULL, 1, NULL, NULL, 0, 0),
(5, 'rofik', 'contact@sherazimar12t.com', '$2y$10$oeYFK/ptILvUakCFDaq6Kelq7h29TE5VGrNH6bXBBOT7OO.reY92.', NULL, '2024-03-21 21:24:22', '2024-03-22 15:56:04', '01819011223', 'Branch 1', 6, 2, 1, 1, 0),
(6, 'Hosain', 'contact@sherazimart.com', '$2y$10$pXD/4naUUuuhXDWFHvm7weM/SkPTfH20L7qu4izcG5dsVtKGMEu9.', NULL, '2024-03-22 13:36:37', '2024-03-22 13:37:53', '01819011229', 'Sherazi IT', 1, NULL, NULL, 1, 0),
(7, 'rofik1', 'sheraziit360@gmail.com', '$2y$10$oRxmWvJOLnndF7t50jM2s.BOpMI1WaJd4hbhJTYPRnDUUBR1xlA7m', NULL, '2024-05-12 18:32:04', '2024-05-12 18:32:04', '01919011234', NULL, 6, 2, 1, 1, 0),
(8, 'MD Tofayel Alam', 'tofayelalam3@gmail.com', '$2y$10$TmfrCoOx9g3QpCoGgDc6we1ZuW3IIw.miPIvEdiywHh25BR2ehUyC', NULL, '2024-05-25 14:43:31', '2024-05-25 14:43:31', '01307768063', 'AAA Photoggraphy', 2, NULL, NULL, 0, 0),
(9, 'Hossain Bakshi', 'urmibakshi@gmail.com', '$2y$10$unDY8E7urpy7I/lMGJGWsOhyUSGQ30T2lgnHB3IMXZmMXfIrC1ikW', NULL, '2024-08-21 20:47:27', '2024-08-21 20:47:27', '01754446935', 'PEOPLES NATURAL  PRODUCTS', 2, NULL, NULL, 0, 0),
(10, 'rohimmia12', 'rohim123@gmail.com', '$2y$10$.METpRZ5vjxnUfjJW7uTueFdw01.5TpjOkPQeULDFWSDWmmUi9eYa', NULL, '2024-09-02 14:34:29', '2024-09-02 14:34:29', '01788729031', NULL, 8, 2, 1, 1, 0),
(11, 'Abu Zahid Faruki', 'azfaruki77@gmail.com', '$2y$10$NkixodqWPZUX5uzwjU.ct.DypdpW8mP00SuDI63FpMuDBio1avHeq', NULL, '2024-09-04 11:33:52', '2024-09-04 11:33:52', '01793484725', 'Nodir Tir health care & Madicin Super Shop Ltd.', 2, NULL, NULL, 0, 0),
(12, 'Fx Fahim Vai', 'fxfashion9@gmail.com', '$2y$10$AkpVotlpX0KVmAILZbFuLOowBnWTkGM61C8Vv0KXkqJ3RoJcdyzWi', NULL, '2024-09-27 22:47:13', '2024-09-27 22:47:13', '01834756008', 'My trusted shop', 1, NULL, NULL, 0, 0),
(13, 'Kazi Shadhin', 'captain@gmail.com', '$2y$10$ZEOey.1LwgvJtZZr4v7fQOMkfUEEi7zZXUcJPAigXWHLgrqU5VM/2', NULL, '2024-09-29 15:09:03', '2024-09-29 15:09:03', '01919011229', NULL, 8, 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `variants`
--

CREATE TABLE `variants` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variants`
--

INSERT INTO `variants` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Forest Green', '2024-04-23 10:52:31', '2024-04-23 10:52:31'),
(2, 'Glitter Purple', '2024-04-23 10:52:31', '2024-04-23 10:52:31'),
(3, 'Red', '2024-04-23 10:58:06', '2024-04-23 10:58:06'),
(4, 'Silver', '2024-04-23 10:58:06', '2024-04-23 10:58:06'),
(5, 'Gold', '2024-04-23 10:58:06', '2024-04-23 10:58:06'),
(6, 'Black', '2024-04-23 11:03:09', '2024-04-23 11:03:09'),
(7, 'Yellow', '2024-04-23 11:47:04', '2024-04-23 11:47:04'),
(8, '25kg', '2024-05-01 17:44:03', '2024-05-01 17:44:03'),
(9, '50kg', '2024-05-01 17:44:03', '2024-05-01 17:44:03'),
(10, '36 balck', '2024-05-04 16:20:09', '2024-05-04 16:20:09'),
(11, '36 pink', '2024-05-04 16:20:09', '2024-05-04 16:20:09'),
(12, '37 black', '2024-05-04 16:20:09', '2024-05-04 16:20:09'),
(13, '37 pink', '2024-05-04 16:20:09', '2024-05-04 16:20:09'),
(14, 'm/blue patern', '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(15, 'm/Red Patern', '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(16, 'l/blue patern', '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(17, 'l/Red Patern', '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(18, 'xl/blue patern', '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(19, 'xl/Red Patern', '2024-05-08 16:52:47', '2024-05-08 16:52:47'),
(20, 'M-white', '2024-05-12 18:09:43', '2024-05-12 18:09:43'),
(21, 'M-Black', '2024-05-12 18:09:43', '2024-05-12 18:09:43'),
(22, 'L-Blue', '2024-05-12 18:09:43', '2024-05-12 18:09:43'),
(23, 'L-white', '2024-05-12 18:09:43', '2024-05-12 18:09:43'),
(24, 'XL-Red', '2024-05-12 18:09:43', '2024-05-12 18:09:43'),
(25, 'Grey', '2024-05-19 12:17:06', '2024-05-19 12:17:06'),
(26, 'White Peel', '2024-05-19 12:17:06', '2024-05-19 12:17:06'),
(27, 'Tile Marble Viny', '2024-05-19 12:17:06', '2024-05-19 12:17:06'),
(28, 'Browns', '2024-06-05 22:16:06', '2024-06-05 22:16:06'),
(29, 'Matik', '2024-06-05 22:16:06', '2024-06-05 22:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `phone`, `email`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Main Branch', '01819011229', 'ranknstyle23@gmail.com', 'House 20, Road 1, Sector 9, Uttara', 1, '2024-04-01 10:07:56', '2024-09-01 15:31:18'),
(2, 'Branch 2', '01819011229', 'contact@sherazimart.com', 'House 20, Road 1, Sector 9, Uttara', 1, '2024-05-04 16:42:08', '2024-05-04 16:42:08');

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `order` varchar(255) NOT NULL,
  `feature_title` varchar(255) DEFAULT NULL,
  `feature_secondary_title` varchar(255) DEFAULT NULL,
  `feature_icon` varchar(255) DEFAULT NULL,
  `site_info_name` varchar(255) DEFAULT NULL,
  `site_info_description` varchar(255) DEFAULT NULL,
  `site_info_address` varchar(255) DEFAULT NULL,
  `site_info_phone` varchar(255) DEFAULT NULL,
  `site_info_email` varchar(255) DEFAULT NULL,
  `site_info_hours` varchar(255) DEFAULT NULL,
  `newsletter_title` varchar(255) DEFAULT NULL,
  `newsletter_text` varchar(255) DEFAULT NULL,
  `quick_links_title` varchar(255) DEFAULT NULL,
  `quick_links_menu` varchar(255) DEFAULT NULL,
  `text_title` varchar(255) DEFAULT NULL,
  `text_content` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acc_adjustments`
--
ALTER TABLE `acc_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `attendances_date_employee_id_checkin_unique` (`date`,`employee_id`,`checkin`);

--
-- Indexes for table `billers`
--
ALTER TABLE `billers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_registers`
--
ALTER TABLE `cash_registers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_groups`
--
ALTER TABLE `customer_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_plans`
--
ALTER TABLE `discount_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_plan_customers`
--
ALTER TABLE `discount_plan_customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_plan_discounts`
--
ALTER TABLE `discount_plan_discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dso_alerts`
--
ALTER TABLE `dso_alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ecommerce_settings`
--
ALTER TABLE `ecommerce_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `external_services`
--
ALTER TABLE `external_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_card_recharges`
--
ALTER TABLE `gift_card_recharges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_settings`
--
ALTER TABLE `hrm_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_settings`
--
ALTER TABLE `mail_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `money_transfers`
--
ALTER TABLE `money_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_widgets`
--
ALTER TABLE `page_widgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_cheque`
--
ALTER TABLE `payment_with_cheque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_gift_card`
--
ALTER TABLE `payment_with_gift_card`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_with_paypal`
--
ALTER TABLE `payment_with_paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_setting`
--
ALTER TABLE `pos_setting`
  ADD UNIQUE KEY `pos_setting_id_unique` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_adjustments`
--
ALTER TABLE `product_adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_batches`
--
ALTER TABLE `product_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_purchases`
--
ALTER TABLE `product_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_quotation`
--
ALTER TABLE `product_quotation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_returns`
--
ALTER TABLE `product_returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_transfer`
--
ALTER TABLE `product_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_product_return`
--
ALTER TABLE `purchase_product_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_purchases`
--
ALTER TABLE `return_purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reward_point_settings`
--
ALTER TABLE `reward_point_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_counts`
--
ALTER TABLE `stock_counts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `acc_adjustments`
--
ALTER TABLE `acc_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `adjustments`
--
ALTER TABLE `adjustments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `billers`
--
ALTER TABLE `billers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cash_registers`
--
ALTER TABLE `cash_registers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_groups`
--
ALTER TABLE `customer_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `discount_plans`
--
ALTER TABLE `discount_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discount_plan_customers`
--
ALTER TABLE `discount_plan_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discount_plan_discounts`
--
ALTER TABLE `discount_plan_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dso_alerts`
--
ALTER TABLE `dso_alerts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ecommerce_settings`
--
ALTER TABLE `ecommerce_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `external_services`
--
ALTER TABLE `external_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gift_card_recharges`
--
ALTER TABLE `gift_card_recharges`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hrm_settings`
--
ALTER TABLE `hrm_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mail_settings`
--
ALTER TABLE `mail_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `money_transfers`
--
ALTER TABLE `money_transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_widgets`
--
ALTER TABLE `page_widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT for table `payment_with_cheque`
--
ALTER TABLE `payment_with_cheque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment_with_credit_card`
--
ALTER TABLE `payment_with_credit_card`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_with_gift_card`
--
ALTER TABLE `payment_with_gift_card`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_with_paypal`
--
ALTER TABLE `payment_with_paypal`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `product_adjustments`
--
ALTER TABLE `product_adjustments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_batches`
--
ALTER TABLE `product_batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_purchases`
--
ALTER TABLE `product_purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `product_quotation`
--
ALTER TABLE `product_quotation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_returns`
--
ALTER TABLE `product_returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT for table `product_transfer`
--
ALTER TABLE `product_transfer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `product_warehouse`
--
ALTER TABLE `product_warehouse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `purchase_product_return`
--
ALTER TABLE `purchase_product_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `return_purchases`
--
ALTER TABLE `return_purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reward_point_settings`
--
ALTER TABLE `reward_point_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_counts`
--
ALTER TABLE `stock_counts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
