-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2026 at 11:34 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rytoyu`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) NOT NULL,
  `type` enum('administrator','admin','seller') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'seller',
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `mobile` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_verified_at` datetime DEFAULT NULL,
  `password_plain` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission_rate` double(8,2) NOT NULL DEFAULT 0.00,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `request_status` enum('pending','approved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `last_login_at` datetime DEFAULT NULL,
  `last_logout_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `password_reset_code` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `code`, `type`, `role_id`, `name`, `email`, `email_verified_at`, `mobile`, `verification_code`, `mobile_verified_at`, `password_plain`, `password`, `commission_rate`, `remember_token`, `image`, `status`, `request_status`, `last_login_at`, `last_logout_at`, `created_at`, `updated_at`, `created_by`, `password_reset_code`, `deleted_at`) VALUES
(1, 101, 'administrator', 1, 'Mr. Admin', 'administrator@mail.com', NULL, '12345679810', '426268', '2025-04-14 05:23:00', '123456', '$2y$10$Egnk6AWhYNvuFlHPg6zM0e1Gxak7P/FImXXg9rsQkzBNkOVU3uIiG', 15.00, NULL, NULL, 'active', 'approved', '2026-02-21 10:28:15', NULL, '2025-02-27 10:35:48', '2026-02-21 04:28:15', 1, NULL, NULL),
(2, 102, 'seller', NULL, 'Glenna Romero', 'qojuqyt@mailinator.com', NULL, '01609696858', NULL, '2025-07-05 17:49:01', '123456', '$2y$10$67o/cMH2Wz4.YzBj64s84Ohmovz4/5.EuUbHxQSmVdltWLzz/D7na', 10.00, '2oFlMGXmmHESScoTLZh8oBntBgZYtLld6rmu1cpOF3yLYR0sXFUyUR32Ch3a', 'assets/files/images/admin/1741103423-avatar-icon-images-4.jpg', 'active', 'approved', '2025-10-10 18:58:37', NULL, '2025-03-04 09:50:23', '2025-10-10 12:58:37', 1, NULL, NULL),
(3, 103, 'seller', NULL, 'Travis Newton', 'lapimimak@mailinator.com', NULL, '01598585858', NULL, NULL, '123456', '$2y$10$pJzlhg3JvJt4FN8vwjOtD.C.VLmYWi4ttwNSCDVq9NWrZkac89vhS', 5.00, NULL, 'assets/files/images/admin/1741103500-images (3).png', 'active', 'approved', '2025-03-06 08:17:00', NULL, '2025-03-04 09:51:40', '2025-03-06 02:17:00', 1, NULL, NULL),
(4, 104, 'seller', NULL, 'Piper Harper', 'hanyqesaqy@mailinator.com', NULL, '01254789652', NULL, NULL, '123456', '$2y$10$jlYd2sG1L.rxkShx2I8ODOXjnpO9aHdd5dVaY7qk/wUmWsqodfe96', 10.00, NULL, 'assets/files/images/admin/1741103526-download.png', 'active', 'approved', NULL, NULL, '2025-03-04 09:52:06', '2025-03-04 09:53:04', 1, NULL, NULL),
(5, 105, 'seller', NULL, 'Ivy Horton', 'lugoj@mailinator.com', NULL, '01693652458', NULL, NULL, '123456', '$2y$10$MvNzV1cTcXtGJLZajn2Bd.RnhRmAmKVyI1c/BzJNb4UwO7RGHIMQG', 15.00, NULL, 'assets/files/images/admin/1741103845-images (1).png', 'active', 'approved', NULL, NULL, '2025-03-04 09:57:25', '2025-05-21 10:25:10', 1, NULL, NULL),
(7, 106, 'seller', NULL, 'Rebecca Vazquez', 'hequ@mailinator.com', NULL, '01609605494', NULL, NULL, 'Pa$$w0rd!', '$2y$10$rdJtZUPRqMiirQZPN3bvKOUhZd5GX6QZIxZDKKYIAoQbBKVXwoTli', 0.00, NULL, NULL, 'active', 'approved', '2025-07-11 09:47:05', NULL, '2025-07-11 03:32:29', '2025-07-11 03:47:05', NULL, NULL, NULL),
(8, 107, 'seller', NULL, 'Ollie O\'Kon', 'your.email37089@gmail.com', NULL, '01609605495', NULL, NULL, '123456', '$2y$10$DWhtFC98XlHCrpRQzxf/DuI3llcBjSWNroHbnoKP7gR9GAt5qlqJW', 0.00, NULL, NULL, 'active', 'approved', '2025-09-13 11:48:22', NULL, '2025-07-11 03:34:05', '2025-09-13 05:48:22', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `highlighted_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `highlighted_title`, `created_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Free Shipping With Orders', 'Over Tk.2000', 1, '2025-04-14 08:56:46', '2025-04-14 09:01:03', NULL),
(3, 'test', 'test', 1, '2025-04-14 09:01:54', '2025-04-14 09:02:37', '2025-04-14 09:02:37'),
(4, 'Sign-Up To Receive Flat', 'Tk.100 off', 1, '2025-04-14 09:02:59', '2025-04-14 09:02:59', NULL),
(5, 'Free Shipping With Orders', 'Over Tk.2000', 1, '2025-04-14 09:03:15', '2025-04-14 09:03:15', NULL),
(6, 'Sign-Up To Receive Flat', 'Tk.100 off', 1, '2025-04-14 09:03:30', '2025-04-14 09:03:30', NULL),
(7, 'Free Shipping With Orders', 'Over Tk.2000', 1, '2025-04-14 09:03:45', '2025-04-14 09:03:45', NULL),
(8, 'Sign-Up To Receive Flat', 'Tk.100 off', 1, '2025-04-14 09:04:01', '2025-04-14 09:04:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `image`, `status`, `created_at`, `updated_at`, `created_by`, `sorting_serial`, `deleted_at`) VALUES
(1, 'HIGHTECH', 'hightech', 'assets/files/images/brand/1741016722-logo2.png', 'assets/files/images/brand/1741016723-img1.png', 'active', '2025-03-03 09:45:23', '2025-03-03 09:50:02', 1, 2, NULL),
(2, 'DIGITECH', 'digitech', 'assets/files/images/brand/1741016765-logo1.png', 'assets/files/images/brand/1741016765-img2.png', 'active', '2025-03-03 09:46:05', '2025-03-03 09:50:02', 1, 3, NULL),
(3, 'TECHLOGO', 'techlogo', 'assets/files/images/brand/1741016812-logo3.png', 'assets/files/images/brand/1741016812-img3.png', 'active', '2025-03-03 09:46:52', '2025-03-03 09:50:02', 1, 4, NULL),
(4, 'DIGITAL STORE', 'digital-store', 'assets/files/images/brand/1741016859-logo4.png', 'assets/files/images/brand/1741016859-img4.png', 'active', '2025-03-03 09:47:39', '2025-03-03 09:47:39', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brand_banners`
--

CREATE TABLE `brand_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand_banners`
--

INSERT INTO `brand_banners` (`id`, `brand_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'assets/files/images/brand/1741016723-women1.png', '2025-03-03 09:45:23', '2025-03-03 09:45:23'),
(2, 1, 'assets/files/images/brand/1741016723-women2.png', '2025-03-03 09:45:23', '2025-03-03 09:45:23'),
(3, 1, 'assets/files/images/brand/1741016723-women3.png', '2025-03-03 09:45:23', '2025-03-03 09:45:23'),
(4, 2, 'assets/files/images/brand/1741016765-men1.png', '2025-03-03 09:46:06', '2025-03-03 09:46:06'),
(5, 2, 'assets/files/images/brand/1741016766-men2.png', '2025-03-03 09:46:06', '2025-03-03 09:46:06'),
(6, 2, 'assets/files/images/brand/1741016766-men3.png', '2025-03-03 09:46:06', '2025-03-03 09:46:06'),
(7, 3, 'assets/files/images/brand/1741016812-women_casual_1.png', '2025-03-03 09:46:52', '2025-03-03 09:46:52'),
(8, 3, 'assets/files/images/brand/1741016812-women_casual_2.png', '2025-03-03 09:46:52', '2025-03-03 09:46:52'),
(9, 3, 'assets/files/images/brand/1741016812-women_casual_3.png', '2025-03-03 09:46:52', '2025-03-03 09:46:52'),
(10, 4, 'assets/files/images/brand/1741016859-women_winter_2.png', '2025-03-03 09:47:39', '2025-03-03 09:47:39'),
(11, 4, 'assets/files/images/brand/1741016859-women_winter_3.png', '2025-03-03 09:47:39', '2025-03-03 09:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `commission_rate` double(3,2) NOT NULL DEFAULT 0.00,
  `is_mega_menu` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `image`, `status`, `commission_rate`, `is_mega_menu`, `created_at`, `updated_at`, `created_by`, `sorting_serial`, `deleted_at`) VALUES
(1, 'MEN', 'men', 'assets/files/images/category/1740841244-man.png', 'assets/files/images/category/1740841197-man.png', 'active', 0.00, 'yes', '2025-03-01 08:59:57', '2025-04-24 09:44:43', 1, 2, NULL),
(2, 'WOMEN', 'women', 'assets/files/images/category/1740841575-woman.png', 'assets/files/images/category/1740841575-women.png', 'active', 0.00, 'yes', '2025-03-01 09:06:15', '2025-04-24 09:44:43', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_banners`
--

CREATE TABLE `category_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_banners`
--

INSERT INTO `category_banners` (`id`, `category_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'assets/files/images/category/1740841197-men1.png', '2025-03-01 08:59:57', '2025-03-01 08:59:57'),
(2, 1, 'assets/files/images/category/1740841197-men2.png', '2025-03-01 08:59:58', '2025-03-01 08:59:58'),
(3, 1, 'assets/files/images/category/1740841198-men3.png', '2025-03-01 08:59:58', '2025-03-01 08:59:58'),
(4, 2, 'assets/files/images/category/1740841575-women1.png', '2025-03-01 09:06:15', '2025-03-01 09:06:15'),
(5, 2, 'assets/files/images/category/1740841575-women2.png', '2025-03-01 09:06:15', '2025-03-01 09:06:15'),
(6, 2, 'assets/files/images/category/1740841575-women3.png', '2025-03-01 09:06:15', '2025-03-01 09:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `color_code`, `slug`, `created_at`, `updated_at`, `created_by`, `deleted_at`) VALUES
(1, 'GREY', '#f0f0f0', 'grey', '2025-03-03 10:01:09', '2025-03-03 10:01:16', 1, NULL),
(2, 'BLACK', '#151414', 'black', '2025-03-03 10:01:53', '2025-03-03 10:01:53', 1, NULL),
(3, 'RED', '#c92222', 'red', '2025-03-03 10:02:04', '2025-03-03 10:02:04', 1, NULL),
(4, 'ORANGE', '#e16623', 'orange', '2025-03-03 10:02:27', '2025-03-03 10:02:27', 1, NULL),
(5, 'YELOW', '#e6df19', 'yelow', '2025-03-03 10:02:40', '2025-03-03 10:02:40', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `valid_for` enum('all-user','new-user') COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_type` enum('flat','percentage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int(11) NOT NULL,
  `used_limit` int(11) NOT NULL DEFAULT 1,
  `minimum_cost` int(11) NOT NULL DEFAULT 0,
  `up_to` int(11) NOT NULL DEFAULT 0,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `valid_for`, `coupon_code`, `discount_type`, `discount`, `used_limit`, `minimum_cost`, `up_to`, `start_date`, `end_date`, `status`, `created_by`, `created_at`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'new-user', 'DUMMY1234', 'flat', 20, 19, 25, 40, '2025-09-24', '2025-09-30', 'active', 1, '2025-09-27 10:09:31', '2025-09-27 10:28:24', 1, NULL, 1),
(2, 'all-user', 'DUMMY20', 'percentage', 10, 51, 50, 34, '2025-09-26', '2025-09-30', 'active', 1, '2025-09-27 10:10:03', '2025-09-27 10:16:46', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charges`
--

CREATE TABLE `delivery_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `district_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_charges`
--

INSERT INTO `delivery_charges` (`id`, `district_name`, `slug`, `delivery_charge`, `created_by`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Dhaka', 'dhaka', '60.00', 1, 'active', '2025-05-30 22:49:07', '2025-05-30 22:59:49', NULL),
(2, 'Rangpur', 'rangpur', '100.00', 1, 'active', '2025-05-30 22:56:04', '2025-05-30 22:59:33', NULL),
(3, 'Rajshahi', 'rajshahi', '0.00', 1, 'inactive', '2025-05-30 22:59:19', '2025-06-02 10:48:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, 'd9c9e008-5c15-4d23-b35f-79e33ae11b76', 'database', 'default', '{\"uuid\":\"d9c9e008-5c15-4d23-b35f-79e33ae11b76\",\"displayName\":\"App\\\\Jobs\\\\LogSellerOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\LogSellerOrderJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\LogSellerOrderJob\\\":1:{s:10:\\\"\\u0000*\\u0000orderId\\\";i:31;}\"}}', 'DivisionByZeroError: Division by zero in W:\\xampp_8_1_10\\htdocs\\rytoyu\\app\\Jobs\\LogSellerOrderJob.php:46\nStack trace:\n#0 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\LogSellerOrderJob->handle()\n#1 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#2 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#3 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#4 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(661): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#5 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#6 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(141): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\LogSellerOrderJob))\n#7 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(116): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\LogSellerOrderJob))\n#8 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#9 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(124): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\LogSellerOrderJob), false)\n#10 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(141): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\LogSellerOrderJob))\n#11 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(116): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\LogSellerOrderJob))\n#12 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(126): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#13 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\LogSellerOrderJob))\n#14 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#15 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(425): Illuminate\\Queue\\Jobs\\Job->fire()\n#16 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(375): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#17 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(173): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#18 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#20 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#21 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(41): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#22 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#23 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#24 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(661): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#25 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(183): Illuminate\\Container\\Container->call(Array)\n#26 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\symfony\\console\\Command\\Command.php(326): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#27 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(153): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\symfony\\console\\Application.php(1078): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#29 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\symfony\\console\\Application.php(324): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\symfony\\console\\Application.php(175): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(102): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 W:\\xampp_8_1_10\\htdocs\\rytoyu\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(155): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 W:\\xampp_8_1_10\\htdocs\\rytoyu\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 {main}', '2025-10-10 11:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(2, 'What are the delivery charges for orders from the Online Shop?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id convallis tellus. Nulla aliquam in mi et convallis. Pellentesque rutrum feugiat ante ut imperdiet. Vivamus et dolor nec nisl consectetur vulputate id non ante.', '2025-07-09 11:17:19', '2025-07-09 11:17:19'),
(3, 'Which payment methods are accepted in the Online Shop?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id convallis tellus. Nulla aliquam in mi et convallis. Pellentesque rutrum feugiat ante ut imperdiet. Vivamus et dolor nec nisl consectetur vulputate id non ante.', '2025-07-09 11:17:34', '2025-07-09 11:17:34'),
(4, 'How long will delivery take?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id convallis tellus. Nulla aliquam in mi et convallis. Pellentesque rutrum feugiat ante ut imperdiet. Vivamus et dolor nec nisl consectetur vulputate id non ante.', '2025-07-09 11:17:49', '2025-07-09 11:17:49'),
(5, 'How secure is shopping in the Online Shop? Is my data protected?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id convallis tellus. Nulla aliquam in mi et convallis. Pellentesque rutrum feugiat ante ut imperdiet. Vivamus et dolor nec nisl consectetur vulputate id non ante.', '2025-07-09 11:18:05', '2025-07-09 11:18:05'),
(6, 'What exactly happens after ordering?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id convallis tellus. Nulla aliquam in mi et convallis. Pellentesque rutrum feugiat ante ut imperdiet. Vivamus et dolor nec nisl consectetur vulputate id non ante.', '2025-07-09 11:18:20', '2025-07-09 11:18:20'),
(7, 'Do I receive an invoice for my order ?', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id convallis tellus. Nulla aliquam in mi et convallis. Pellentesque rutrum feugiat ante ut imperdiet. Vivamus et dolor nec nisl consectetur vulputate id non ante.', '2025-07-09 11:18:37', '2025-07-09 11:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `join_requests`
--

CREATE TABLE `join_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cv_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','shortlisted','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `join_requests`
--

INSERT INTO `join_requests` (`id`, `name`, `email`, `mobile`, `cv_path`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ivy Berger', 'pecesewify@mailinator.com', '01609605494', '1752337575_.pdf', 'pending', '2025-07-12 10:26:15', '2025-07-12 10:26:15'),
(2, 'Cassandra Terrell', 'bocyza@mailinator.com', '01609605494', '1752337836_.pdf', 'pending', '2025-07-12 10:30:36', '2025-07-12 10:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `latest_offer_products`
--

CREATE TABLE `latest_offer_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `latest_offer_products`
--

INSERT INTO `latest_offer_products` (`id`, `seller_id`, `product_id`, `sorting_serial`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, '2025-05-14 10:14:46', '2025-05-14 10:19:40'),
(2, 1, 3, 3, '2025-05-14 10:14:53', '2025-05-14 10:19:40'),
(3, 1, 7, 4, '2025-05-14 10:14:59', '2025-05-14 10:19:40'),
(4, 1, 8, 5, '2025-05-14 10:15:03', '2025-05-14 10:15:03'),
(5, 1, 9, 1, '2025-05-14 10:15:07', '2025-05-14 10:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_03_161830_create_admins_table', 1),
(6, '2024_05_03_173255_create_categories_table', 1),
(7, '2024_05_06_162033_create_sub_categories_table', 1),
(8, '2024_05_06_174341_create_sizes_table', 1),
(9, '2024_05_06_174456_create_colors_table', 1),
(10, '2024_05_06_174503_create_units_table', 1),
(11, '2024_05_06_175226_create_sub_subcategories_table', 1),
(12, '2024_05_07_134442_create_brands_table', 1),
(13, '2024_05_08_140756_create_products_table', 1),
(14, '2024_05_08_144644_create_product_images_table', 1),
(15, '2024_05_10_061326_create_tags_table', 1),
(16, '2024_11_27_183203_create_seller_shops_table', 1),
(17, '2024_11_28_150451_create_product_variants_table', 1),
(18, '2025_01_25_050917_create_web_product_sections_table', 1),
(19, '2025_01_25_051733_create_section_products_table', 1),
(20, '2025_02_20_175403_create_category_banners_table', 1),
(21, '2025_02_20_175444_create_sub_category_banners_table', 1),
(22, '2025_02_20_175455_create_sub_sub_category_banners_table', 1),
(23, '2025_02_20_175507_create_brand_banners_table', 1),
(24, '2025_02_27_160100_create_product_types_table', 1),
(25, '2025_03_03_160800_add_extra_field_on_products_table', 2),
(26, '2025_03_04_162333_add_seller_id_on_products', 3),
(29, '2025_04_14_053003_create_sliders_table', 4),
(31, '2025_04_14_053434_create_slider_products_table', 5),
(33, '2025_04_14_144024_create_announcements_table', 6),
(34, '2025_04_15_152040_create_new_in_products_table', 7),
(35, '2025_04_26_042340_create_carts_table', 8),
(36, '2014_10_12_000000_create_users_table', 9),
(37, '2025_04_29_153309_create_product_type_categories_table', 10),
(38, '2025_04_29_165543_add_fulltext_index_to_products_table', 11),
(47, '2025_04_30_151142_create_orders_table', 12),
(48, '2025_04_30_151416_create_order_products_table', 12),
(49, '2025_05_07_154740_add_google_id_column', 13),
(50, '2025_05_07_162556_add_google_id_column', 14),
(51, '2025_05_13_160841_add_verification_code', 15),
(52, '2025_05_14_155541_create_latest_offer_products_table', 16),
(55, '2025_05_17_152851_create_seller_order_logs_table', 17),
(56, '2025_05_17_162333_create_jobs_table', 18),
(58, '2025_05_30_184627_create_push_subscriptions_table', 19),
(60, '2025_05_31_032933_create_delivery_charges_table', 20),
(64, '2025_05_31_184416_create_transactions_table', 22),
(67, '2025_05_31_033615_add_extr_field', 23),
(68, '2025_07_09_170108_create_faqs_table', 24),
(69, '2025_07_12_161500_create_join_requests_table', 25),
(70, '2025_07_13_171944_create_reviews_table', 26),
(71, '2025_07_23_174315_create_wishlists_table', 27),
(74, '2025_08_29_054245_create_coupons_table', 28),
(76, '2025_10_10_180044_add_extr_table_field', 29);

-- --------------------------------------------------------

--
-- Table structure for table `new_in_products`
--

CREATE TABLE `new_in_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `new_in_products`
--

INSERT INTO `new_in_products` (`id`, `product_id`, `sorting_serial`, `created_at`, `updated_at`) VALUES
(16, 7, 3, '2025-05-14 09:40:52', '2025-06-02 11:09:25'),
(17, 10, 4, '2025-05-14 09:40:53', '2025-06-02 11:09:04'),
(18, 11, 2, '2025-05-14 09:40:57', '2025-06-02 11:09:25'),
(19, 9, 1, '2025-05-14 09:41:01', '2025-06-02 11:09:25');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unique_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_item_unit_price` double(8,2) NOT NULL DEFAULT 0.00,
  `total_item_discount` double(8,2) NOT NULL DEFAULT 0.00,
  `total_item_order_price` double(8,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `shipping_fee` double(8,2) NOT NULL DEFAULT 0.00,
  `seller_count` int(11) NOT NULL DEFAULT 0,
  `service_charge` double(8,2) NOT NULL DEFAULT 0.00,
  `total_vat` double(8,2) NOT NULL DEFAULT 0.00,
  `total_discount` double(8,2) NOT NULL,
  `total_order_price` double(8,2) NOT NULL,
  `order_status` enum('pending','canceled','processing','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` enum('cash-on-delivery','online-payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash-on-delivery',
  `payment_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `paid_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `due_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` int(255) DEFAULT NULL,
  `city_town` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` int(11) DEFAULT NULL,
  `additional_information` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `delete_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `unique_id`, `order_number`, `invoice`, `user_id`, `total_item_unit_price`, `total_item_discount`, `total_item_order_price`, `coupon_code`, `coupon_discount_amount`, `shipping_fee`, `seller_count`, `service_charge`, `total_vat`, `total_discount`, `total_order_price`, `order_status`, `payment_method`, `payment_status`, `paid_amount`, `due_amount`, `first_name`, `last_name`, `mobile`, `email`, `district_id`, `city_town`, `address`, `post_code`, `additional_information`, `created_at`, `updated_at`, `deleted_at`, `delete_by`) VALUES
(32, 'WZ76EYWHTG', '0001', 'RT-68288997', 6, 9512.00, 1105.00, 8407.00, '', 0.00, 120.00, 2, 0.00, 0.00, 1105.00, 8527.00, 'pending', 'cash-on-delivery', 'unpaid', 0.00, 8527.00, 'Stewart', 'Sanford', '01609605491', 'mkraju.eatl@gmail.com', 1, 'Eligendi occaecat es', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', 5256, NULL, '2025-10-10 12:09:10', '2025-10-10 12:09:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_unit_price` double(8,2) NOT NULL DEFAULT 0.00,
  `item_discount_price` double(8,2) NOT NULL DEFAULT 0.00,
  `item_order_price` double(8,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `item_total_unit_price` double(8,2) NOT NULL DEFAULT 0.00,
  `item_total_discount` double(8,2) NOT NULL DEFAULT 0.00,
  `item_total_order_price` double(8,2) NOT NULL DEFAULT 0.00,
  `size` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_status` enum('pending','canceled','processing','shipped','delivered','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `last_updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id`, `order_id`, `user_id`, `seller_id`, `variant_id`, `product_id`, `item_unit_price`, `item_discount_price`, `item_order_price`, `quantity`, `item_total_unit_price`, `item_total_discount`, `item_total_order_price`, `size`, `color`, `order_status`, `last_updated_by`, `created_at`, `updated_at`) VALUES
(90, 32, 6, 2, 32, 11, 5000.00, 4800.00, 4800.00, 1, 5000.00, 200.00, 4800.00, 'L', 'ORANGE', 'delivered', 2, '2025-10-10 12:09:10', '2025-10-10 12:19:08'),
(91, 32, 6, 1, 19, 7, 500.00, 800.00, 400.00, 2, 1000.00, 600.00, 800.00, 'M', 'GREY', 'pending', NULL, '2025-10-10 12:09:10', '2025-10-10 12:09:10'),
(92, 32, 6, 2, 38, 13, 912.00, 707.00, 707.00, 1, 912.00, 205.00, 707.00, 'N/A', 'N/A', 'delivered', 2, '2025-10-10 12:09:10', '2025-10-10 12:19:08'),
(93, 32, 6, 1, 2, 1, 800.00, 600.00, 600.00, 1, 800.00, 200.00, 600.00, 'M', 'BLACK', 'pending', NULL, '2025-10-10 12:09:10', '2025-10-10 12:09:10'),
(94, 32, 6, 1, 7, 3, 900.00, 700.00, 700.00, 1, 900.00, 200.00, 700.00, 'L', 'BLACK', 'pending', NULL, '2025-10-10 12:09:10', '2025-10-10 12:09:10'),
(95, 32, 6, 1, 22, 8, 900.00, 800.00, 800.00, 1, 900.00, 100.00, 800.00, 'L', 'GREY', 'pending', NULL, '2025-10-10 12:09:10', '2025-10-10 12:09:10');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) NOT NULL DEFAULT 1,
  `product_type_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `sub_subcategory_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `product_details` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_specification` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_compare` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `special_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warranty` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `thumbnail_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_tags` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_exchangeable` tinyint(1) NOT NULL DEFAULT 0,
  `is_refundable` tinyint(1) NOT NULL DEFAULT 0,
  `contact_person` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `listed_on` enum('featured','new-arrivals','best-selling') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'featured',
  `request_status` enum('pending','approved') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `product_type_id`, `category_id`, `subcategory_id`, `sub_subcategory_id`, `brand_id`, `product_code`, `name`, `slug`, `unit_price`, `discount_price`, `product_details`, `product_specification`, `product_compare`, `short_description`, `special_note`, `warranty`, `video_link`, `view_count`, `thumbnail_path`, `product_unit`, `product_tags`, `is_exchangeable`, `is_refundable`, `contact_person`, `listed_on`, `request_status`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_at`) VALUES
(1, 1, 1, 1, 1, 2, 4, 'MSC-100', 'Mens Casual Romper Short Sleeve Playsuit Work Jumpsuit Fashion Cargo Long Pants', 'msc-100-mens-casual-romper-short-sleeve-playsuit-work-jumpsuit-fashion-cargo-long-pants', '800.00', '600.00', '<p>* Item:Mens Casual Romper Short Sleeve Playsuit Work Jumpsuit Fashion Cargo Long Pants<br />\r\n* Condition: 100% Brand New<br />\r\n* Color:</p>\r\n\r\n<p>Black&nbsp; &nbsp;Dark Blue&nbsp;&nbsp;</p>\r\n\r\n<p><br />\r\n* Size:Asian&nbsp;Asian M&nbsp; &nbsp;Asian L&nbsp; &nbsp;Asian XL&nbsp; &nbsp;Asian 2XL&nbsp; &nbsp;Asian 3XL&nbsp;&nbsp;<br />\r\n* Package:1pc&nbsp;Outfits&nbsp;(without any accessories ）</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;Please note:</p>\r\n\r\n<p>1.Please allow a little error due to manual measurement.</p>\r\n\r\n<p>2.The color maybe a little difference because of the light,screen reflection etc.</p>\r\n\r\n<p>3.If you are not sure what size to choose, you can tell us your height and weight, we will recommend the right size for you.</p>', '<p>* Item:Mens Casual Romper Short Sleeve Playsuit Work Jumpsuit Fashion Cargo Long Pants<br />\r\n* Condition: 100% Brand New<br />\r\n* Color:</p>\r\n\r\n<p>Black&nbsp; &nbsp;Dark Blue&nbsp;&nbsp;</p>\r\n\r\n<p><br />\r\n* Size:Asian&nbsp;Asian M&nbsp; &nbsp;Asian L&nbsp; &nbsp;Asian XL&nbsp; &nbsp;Asian 2XL&nbsp; &nbsp;Asian 3XL&nbsp;&nbsp;<br />\r\n* Package:1pc&nbsp;Outfits&nbsp;(without any accessories ）</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;Please note:</p>\r\n\r\n<p>1.Please allow a little error due to manual measurement.</p>\r\n\r\n<p>2.The color maybe a little difference because of the light,screen reflection etc.</p>\r\n\r\n<p>3.If you are not sure what size to choose, you can tell us your height and weight, we will recommend the right size for you.</p>', NULL, 'Mens Casual Romper Short Sleeve Playsuit Work Jumpsuit Fashion Cargo Long Pants', 'Your Item(s) will be shipped within 5-15 business days once payment received.', NULL, NULL, 0, 'assets/files/images/products/1741020567-product_1.png', '1', 'JUMPSUITS,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-03 10:49:28', '2025-03-03 10:57:09', 1, 1, NULL),
(2, 1, 1, 1, 1, 2, 2, 'MSC-101', 'Mens Knitted Sweaters Warm Long Sleeve Pullover Winter Cardigan Sweatshirt', 'msc-101-mens-knitted-sweaters-warm-long-sleeve-pullover-winter-cardigan-sweatshirt', '1000.00', '0.00', '<p>Seller assumes all responsibility for this listing.</p>\r\n\r\n<p>eBay item number:125141355312</p>\r\n\r\n<p>Last updated on&nbsp;Feb 25, 2025 00:32:32 PST<a data-click=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;parentrq&quot;:&quot;5ce2882e1950adf15369decdffff3fbe&quot;,&quot;pageci&quot;:&quot;4853b588-53d7-4f1b-b6d6-6cfef1d64ed3&quot;,&quot;moduledtl&quot;:&quot;mi:148105|li:48144&quot;,&quot;sid&quot;:&quot;p4429486.m148105.l48144&quot;}}\" data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;OPEN_WINDOW&quot;}\" data-testid=\"ux-action\" data-vi-tracking=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;parentrq&quot;:&quot;5ce2882e1950adf15369decdffff3fbe&quot;,&quot;pageci&quot;:&quot;4853b588-53d7-4f1b-b6d6-6cfef1d64ed3&quot;,&quot;moduledtl&quot;:&quot;mi:148105|li:48144&quot;,&quot;sid&quot;:&quot;p4429486.m148105.l48144&quot;}}\" href=\"https://www.ebay.com/rvh/125141355312?rt=nc&amp;_trksid=p4429486.m148105.l48144\" target=\"_blank\">View all revisionsView all revisions</a></p>\r\n\r\n<h2 id=\"s0-1-26-7-18-1-92[2]-2-3-7[0]-7[0]-4[0]-11[1]-1-3-title\">Item specifics</h2>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Condition</p>\r\n	</dt>\r\n	<dd>\r\n	<p>New with tags: This item is brand new and has never been worn. It still has the original tags and/or ...&nbsp;<button data-click=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\" data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;EXPAND_INLINE&quot;}\" data-testid=\"ux-action\" data-vi-tracking=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\">Read moreabout the condition</button></p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Pattern</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Camouflage</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Knit Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Medium</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Sleeve Length</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Long Sleeve</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Occasion</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Casual</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Garment Care</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Machine Washable</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size</p>\r\n	</dt>\r\n	<dd>\r\n	<p>M</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Material</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Wool blend</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fabric Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Jersey</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Brand</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Unbranded</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fit</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Department</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Men</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Sweater</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Pullover</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Theme</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Sports</p>\r\n	</dd>\r\n</dl>', '<p>Seller assumes all responsibility for this listing.</p>\r\n\r\n<p>eBay item number:125141355312</p>\r\n\r\n<p>Last updated on&nbsp;Feb 25, 2025 00:32:32 PST<a data-click=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;parentrq&quot;:&quot;5ce2882e1950adf15369decdffff3fbe&quot;,&quot;pageci&quot;:&quot;4853b588-53d7-4f1b-b6d6-6cfef1d64ed3&quot;,&quot;moduledtl&quot;:&quot;mi:148105|li:48144&quot;,&quot;sid&quot;:&quot;p4429486.m148105.l48144&quot;}}\" data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;OPEN_WINDOW&quot;}\" data-testid=\"ux-action\" data-vi-tracking=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;parentrq&quot;:&quot;5ce2882e1950adf15369decdffff3fbe&quot;,&quot;pageci&quot;:&quot;4853b588-53d7-4f1b-b6d6-6cfef1d64ed3&quot;,&quot;moduledtl&quot;:&quot;mi:148105|li:48144&quot;,&quot;sid&quot;:&quot;p4429486.m148105.l48144&quot;}}\" href=\"https://www.ebay.com/rvh/125141355312?rt=nc&amp;_trksid=p4429486.m148105.l48144\" target=\"_blank\">View all revisionsView all revisions</a></p>\r\n\r\n<h2 id=\"s0-1-26-7-18-1-92[2]-2-3-7[0]-7[0]-4[0]-11[1]-1-3-title\">Item specifics</h2>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Condition</p>\r\n	</dt>\r\n	<dd>\r\n	<p>New with tags: This item is brand new and has never been worn. It still has the original tags and/or ...&nbsp;<button data-click=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\" data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;EXPAND_INLINE&quot;}\" data-testid=\"ux-action\" data-vi-tracking=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\">Read moreabout the condition</button></p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Pattern</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Camouflage</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Knit Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Medium</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Sleeve Length</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Long Sleeve</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Occasion</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Casual</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Garment Care</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Machine Washable</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size</p>\r\n	</dt>\r\n	<dd>\r\n	<p>M</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Material</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Wool blend</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fabric Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Jersey</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Brand</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Unbranded</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fit</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Department</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Men</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Sweater</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Pullover</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Theme</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Sports</p>\r\n	</dd>\r\n</dl>', NULL, 'Mens Cardigan Sweater Cable Knit Button Cotton Sweater Winter Warm Pockets Tops\r\nNew (Other)', 'Please make sure your checked our size instruction first!!!   \r\n\r\nNormally it will be made in 3 days and arrive in 10-20 days.\r\n\r\nif there is any confuse, please feel free to contact us anytime.', NULL, NULL, 0, 'assets/files/images/products/1741021322-product_2_1.png', '1', 'JUMPSUITS,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-03 11:02:02', '2025-07-23 10:50:06', 1, 1, NULL),
(3, 1, 1, 1, 1, 2, 1, 'MSC-102', 'Men Cardigan Sweater Autumn Winter Warm V-Neck Button Sweater Knitted Pullover', 'msc-102-men-cardigan-sweater-autumn-winter-warm-v-neck-button-sweater-knitted-pullover', '900.00', '700.00', '<h2 id=\"s0-1-26-7-18-1-92[2]-2-3-7[0]-7[0]-4[0]-11[1]-1-3-title\">tem specifics</h2>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Condition</p>\r\n	</dt>\r\n	<dd>\r\n	<p>New with tags: This item is brand new and has never been worn. It still has the original tags and/or original packaging.&nbsp;<a data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;OPEN_WINDOW&quot;}\" data-testid=\"ux-action\" href=\"https://pages.ebay.com/ru/en-us/help/sell/contextual/condition_2.html\" target=\"_blank\">See all condition definitionsopens in a new window or tab</a></p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Accents</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Button</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Brand</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Unbranded</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Country/Region of Manufacture</p>\r\n	</dt>\r\n	<dd>\r\n	<p>China</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Department</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Men</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Features</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Breathable, Lightweight</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fit</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Classic</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Material</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Acrylic, Polyester</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>MPN</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Does Not Apply</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Neckline</p>\r\n	</dt>\r\n	<dd>\r\n	<p>V-Neck</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Pattern</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Solid</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Performance/Activity</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Walking</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Cardigan</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Theme</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Classic</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Sweater</p>\r\n	</dd>\r\n</dl>', '<h2 id=\"s0-1-26-7-18-1-92[2]-2-3-7[0]-7[0]-4[0]-11[1]-1-3-title\">tem specifics</h2>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Condition</p>\r\n	</dt>\r\n	<dd>\r\n	<p>New with tags: This item is brand new and has never been worn. It still has the original tags and/or original packaging.&nbsp;<a data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;OPEN_WINDOW&quot;}\" data-testid=\"ux-action\" href=\"https://pages.ebay.com/ru/en-us/help/sell/contextual/condition_2.html\" target=\"_blank\">See all condition definitionsopens in a new window or tab</a></p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Accents</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Button</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Brand</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Unbranded</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Country/Region of Manufacture</p>\r\n	</dt>\r\n	<dd>\r\n	<p>China</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Department</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Men</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Features</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Breathable, Lightweight</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fit</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Classic</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Material</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Acrylic, Polyester</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>MPN</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Does Not Apply</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Neckline</p>\r\n	</dt>\r\n	<dd>\r\n	<p>V-Neck</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Pattern</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Solid</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Performance/Activity</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Walking</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Cardigan</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Theme</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Classic</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Sweater</p>\r\n	</dd>\r\n</dl>', NULL, 'Cardigan Men Sweater Autumn Winter Warm V-Neck Button Sweater Knitted Pullover', 'Men Cardigan Sweater Autumn Winter Warm V-Neck Button Sweater Knitted Pullover', NULL, NULL, 0, 'assets/files/images/products/1741021723-product_3_3.png', '1', 'JUMPSUITS,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-03 11:08:43', '2025-03-03 11:08:43', 1, 1, NULL),
(4, 1, 1, 2, 3, 5, 1, 'WJP-100', 'Colourful Oliver Bonas Pink Star Knitted Bomber Jacket/Cardigan Size 16 BNWT', 'wjp-100-colourful-oliver-bonas-pink-star-knitted-bomber-jacketcardigan-size-16-bnwt', '500.00', '450.00', '<p><strong>Oliver Bonas Pink Geometric Star Knitted Bomber Jacket Size 16 BNWT.</strong></p>\r\n\r\n<p>Gorgeous cardigan/bomber jacket.</p>\r\n\r\n<p>Brand New with tags.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Dispatched with Royal Mail Tracked 48.</p>', '<p><strong>Oliver Bonas Pink Geometric Star Knitted Bomber Jacket Size 16 BNWT.</strong></p>\r\n\r\n<p>Gorgeous cardigan/bomber jacket.</p>\r\n\r\n<p>Brand New with tags.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Dispatched with Royal Mail Tracked 48.</p>', NULL, 'Colourful Oliver Bonas Pink Star Knitted Bomber Jacket/Cardigan Size 16 BNWT', 'Colourful Oliver Bonas Pink Star Knitted Bomber Jacket/Cardigan Size 16 BNWT', NULL, NULL, 0, 'assets/files/images/products/1741087327-w_p_1_1.png', '1', 'JUMPSUITS,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-04 05:22:08', '2025-07-23 10:50:05', 1, 1, NULL),
(5, 1, 1, 2, 3, 5, 1, 'WJP-101', 'Mint Velvet Grey Longline Cardigan UK 10 EU 38 RRP £89 LN142 AA 01', 'wjp-101-mint-velvet-grey-longline-cardigan-uk-10-eu-38-rrp-ps89-ln142-aa-01', '800.00', '0.00', '<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\"><b><font size=\"5\">Mint Velvet Grey Longline Cardigan&nbsp;</font></b></span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\"><b><font size=\"5\">UK 10 EU 38&nbsp;</font></b></span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\"><b><font size=\"5\">RRP &pound;89</font></b></span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">Spun with a touch of cashmere for softness, this grey cardigan is knitted in a relaxed silhouette with a waterfall front. Mint Velvet have added metallic stripes at the sleeves and back for a sporty look &ndash; just slip yours over jeans and joggers alike.</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">Hand wash only.</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">49% Cotton, 24% Viscose, 21% Nylon, 6% Cashmere.</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">pit to pit 18 inch</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">length 25-35 inch</span></span></span></span></span></span></span></span></span></span></div>', '<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\"><b><font size=\"5\">Mint Velvet Grey Longline Cardigan&nbsp;</font></b></span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\"><b><font size=\"5\">UK 10 EU 38&nbsp;</font></b></span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\"><b><font size=\"5\">RRP &pound;89</font></b></span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">Spun with a touch of cashmere for softness, this grey cardigan is knitted in a relaxed silhouette with a waterfall front. Mint Velvet have added metallic stripes at the sleeves and back for a sporty look &ndash; just slip yours over jeans and joggers alike.</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">Hand wash only.</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">49% Cotton, 24% Viscose, 21% Nylon, 6% Cashmere.</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\">&nbsp;</div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">pit to pit 18 inch</span></span></span></span></span></span></span></span></span></span></div>\r\n\r\n<div style=\"text-align:center\"><span style=\"font-size:medium\"><span style=\"color:#000000\"><span style=\"font-family:&quot;Market Sans&quot;, Arial, sans-serif\"><span style=\"font-style:normal\"><span style=\"font-variant-ligatures:normal\"><span style=\"font-weight:400\"><span style=\"white-space:normal\"><span style=\"text-decoration-thickness:initial\"><span style=\"text-decoration-style:initial\"><span style=\"text-decoration-color:initial\">length 25-35 inch</span></span></span></span></span></span></span></span></span></span></div>', NULL, 'Mint Velvet Grey Longline Cardigan UK 10 EU 38 RRP £89 LN142 AA 01', 'Mint Velvet Grey Longline Cardigan UK 10 EU 38 RRP £89 LN142 AA 01', NULL, NULL, 0, 'assets/files/images/products/1741088362-w_p_2_1.png', '1', 'JUMPSUITS,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-04 05:39:22', '2025-03-04 05:39:22', 1, 1, NULL),
(6, 1, 2, 2, 4, 6, 1, 'WC-100', 'Ladies Linen Mix Floral Midi Knee Length Dress RRP', 'wc-100-ladies-linen-mix-floral-midi-knee-length-dress-rrp', '900.00', '700.00', '<h2 id=\"s0-1-26-7-18-1-92[2]-2-3-7[0]-7[0]-4[0]-11[1]-1-3-title\">Item specifics</h2>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Condition</p>\r\n	</dt>\r\n	<dd>\r\n	<p>New without tags: This item is brand new and has never been worn, but doesn&rsquo;t have tags and/or is ...&nbsp;<button data-click=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\" data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;EXPAND_INLINE&quot;}\" data-testid=\"ux-action\" data-vi-tracking=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\">Read moreabout the condition</button></p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Pattern</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Floral</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Sleeve Length</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Short Sleeve</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Neckline</p>\r\n	</dt>\r\n	<dd>\r\n	<p>V-Neck</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Closure</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Pullover</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Occasion</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Casual</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Material</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Linen</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fabric Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Jersey</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Colour</p>\r\n	</dt>\r\n	<dd>\r\n	<p>White</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Dress Length</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Knee Length</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Vintage</p>\r\n	</dt>\r\n	<dd>\r\n	<p>No</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Brand</p>\r\n	</dt>\r\n	<dd>\r\n	<p>ex High Street</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Department</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Women</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Knee Length Dress</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Season</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Summer</p>\r\n	</dd>\r\n</dl>', '<h2 id=\"s0-1-26-7-18-1-92[2]-2-3-7[0]-7[0]-4[0]-11[1]-1-3-title\">Item specifics</h2>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Condition</p>\r\n	</dt>\r\n	<dd>\r\n	<p>New without tags: This item is brand new and has never been worn, but doesn&rsquo;t have tags and/or is ...&nbsp;<button data-click=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\" data-clientpresentationmetadata=\"{&quot;presentationType&quot;:&quot;EXPAND_INLINE&quot;}\" data-testid=\"ux-action\" data-vi-tracking=\"{&quot;eventFamily&quot;:&quot;ITM&quot;,&quot;eventAction&quot;:&quot;ACTN&quot;,&quot;actionKind&quot;:&quot;CLICK&quot;,&quot;operationId&quot;:&quot;4429486&quot;,&quot;flushImmediately&quot;:false,&quot;eventProperty&quot;:{&quot;moduledtl&quot;:&quot;mi:3560|li:106744&quot;,&quot;sid&quot;:&quot;p4429486.m3560.l106744&quot;}}\">Read moreabout the condition</button></p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Pattern</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Floral</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Sleeve Length</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Short Sleeve</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Neckline</p>\r\n	</dt>\r\n	<dd>\r\n	<p>V-Neck</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Closure</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Pullover</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Occasion</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Casual</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Material</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Linen</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Fabric Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Jersey</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Colour</p>\r\n	</dt>\r\n	<dd>\r\n	<p>White</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Dress Length</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Knee Length</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Vintage</p>\r\n	</dt>\r\n	<dd>\r\n	<p>No</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Brand</p>\r\n	</dt>\r\n	<dd>\r\n	<p>ex High Street</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Size Type</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Regular</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Department</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Women</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Style</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Knee Length Dress</p>\r\n	</dd>\r\n</dl>\r\n\r\n<dl data-testid=\"ux-labels-values\">\r\n	<dt>\r\n	<p>Season</p>\r\n	</dt>\r\n	<dd>\r\n	<p>Summer</p>\r\n	</dd>\r\n</dl>', NULL, 'Ladies Linen Mix Floral Midi Knee Length Dress RRP', 'Ladies Linen Mix Floral Midi Knee Length Dress RRP', NULL, NULL, 0, 'assets/files/images/products/1741089321-w_p_3_1.png', '1', 'ONE PIECE', 0, 0, NULL, 'featured', 'pending', 'active', '2025-03-04 05:55:21', '2025-07-23 11:08:23', 1, 1, NULL),
(7, 1, 1, 2, 4, 6, 3, 'WJP-102', 'Womens V Neck Boho Floral Mini Dress Long Sleeve Holiday Beach Swing Sundress', 'wjp-102-womens-v-neck-boho-floral-mini-dress-long-sleeve-holiday-beach-swing-sundress', '500.00', '400.00', '<p>Womens V Neck Boho Floral Mini Dress Long Sleeve Holiday Beach Swing Sundress</p>', '<p>Womens V Neck Boho Floral Mini Dress Long Sleeve Holiday Beach Swing Sundress</p>', NULL, 'Womens V Neck Boho Floral Mini Dress Long Sleeve Holiday Beach Swing Sundress', 'Womens V Neck Boho Floral Mini Dress Long Sleeve Holiday Beach Swing Sundress', NULL, NULL, 0, 'assets/files/images/products/1741100575-product_4_2.png', NULL, 'JUMPSUITS,ONE PIECE,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-04 09:02:55', '2025-03-04 09:06:16', 1, 1, NULL),
(8, 1, 2, 2, 4, 6, 2, 'WJP-105', 'Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', 'wjp-105-women-floral-boho-midi-dress-ladies-summer-holiday-beach-swing-kaftan-sundress', '900.00', '800.00', '<p>Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>', '<p>Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>', NULL, 'Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', 'Women Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', NULL, NULL, 0, 'assets/files/images/products/1741101389-w_p_4_1.png', '1', 'JUMPSUITS,ONE PIECE,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-04 09:16:29', '2025-03-04 09:16:29', 1, 1, NULL),
(9, 1, 2, 2, 4, 6, 4, 'WJP-109', 'Womens Floral Boho Midi Dress Ladies Summer heroin Holiday Beach Swing Kaftan Sundress', 'wjp-109-womens-floral-boho-midi-dress-ladies-summer-holiday-beach-swing-kaftan-sundress', '900.00', '700.00', '<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>', '<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>', NULL, 'Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', 'Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', NULL, NULL, 0, 'assets/files/images/products/1741101564-w_p_1_1.png', '1', 'JUMPSUITS,ONE PIECE,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-04 09:19:24', '2025-03-04 09:19:24', 1, 1, NULL),
(10, 1, 2, 2, 4, 6, 4, 'WJP-110', 'Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', 'wjp-110-womens-floral-boho-midi-dress-ladies-summer-holiday-beach-swing-kaftan-sundress', '800.00', '500.00', '<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>', '<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>\r\n\r\n<p>Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress</p>', NULL, 'Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', 'Womens Floral Boho Midi Dress Ladies Summer Holiday Beach Swing Kaftan Sundress', NULL, NULL, 0, 'assets/files/images/products/1741101853-w_p_5_1.png', NULL, 'JUMPSUITS,ONE PIECE,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-04 09:24:14', '2025-03-04 09:24:14', 1, 1, NULL),
(11, 2, 2, 2, 4, 6, 1, 'WJP-206', 'Summer V Neck Holiday Mini Dresses UK Womens Short Sleeve Dress Ladies Plus Size', 'wjp-206-summer-v-neck-holiday-mini-dresses-uk-womens-short-sleeve-dress-ladies-plus-size', '5000.00', '4800.00', '<p>Summer V Neck Holiday Mini Dresses UK Womens Short Sleeve Dress Ladies Plus Size</p>', '<ul>\r\n	<li>Summer V Neck Holiday</li>\r\n	<li>Mini Dresses UK Womens</li>\r\n	<li>Short Sleeve Dress Ladies Plus Size</li>\r\n</ul>', NULL, 'Summer V Neck Holiday Mini Dresses UK Womens Short Sleeve Dress Ladies Plus Size', 'Summer V Neck Holiday Mini Dresses UK Womens Short Sleeve Dress Ladies Plus Size', NULL, NULL, 0, 'assets/files/images/products/1741107161-w_p_6_1.png', NULL, 'JUMPSUITS,ONE PIECE,ROMPERS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-04 10:52:41', '2025-07-23 10:53:27', 2, 2, NULL),
(12, 1, 2, 1, 2, 3, 2, 'MSC-108', 'Volodymyr Zelenskyy Army Military Coat of Arms Long Sleeve T-Shirt for Ukraine', 'msc-108-volodymyr-zelenskyy-army-military-coat-of-arms-long-sleeve-t-shirt-for-ukraine', '4000.00', '3500.00', '<p>Volodymyr Zelenskyy Army Military Coat of Arms Long Sleeve T-Shirt for Ukraine</p>', '<p>Volodymyr Zelenskyy Army Military Coat of Arms Long Sleeve T-Shirt for Ukraine</p>', NULL, 'Volodymyr Zelenskyy Army Military Coat of Arms Long Sleeve T-Shirt for Ukraine', 'Volodymyr Zelenskyy Army Military Coat of Arms Long Sleeve T-Shirt for Ukraine', NULL, NULL, 0, 'assets/files/images/products/1741261314-mp_1_1.png', '1', 'ONE PIECE', 0, 0, NULL, 'featured', 'approved', 'active', '2025-03-06 05:41:55', '2025-03-06 05:41:55', 1, 1, NULL),
(13, 2, 3, 2, 4, 6, 4, '326857', 'Mini Dresses UK Womens Short Sleeve Dress Ladies Plus Size', '326857-ivory-barrett', '0.00', '0.00', '<p>qojuqyt@mailinator.com</p>', '<p>qojuqyt@mailinator.com</p>', NULL, 'Non voluptatem Rati', 'Sequi eiusmod iure l', 'Debitis et non omnis', NULL, 0, 'assets/files/images/products/1753289776-1741019819-product_1.png', NULL, 'JUMPSUITS', 0, 0, NULL, 'featured', 'approved', 'active', '2025-07-23 10:56:17', '2025-07-23 11:17:52', 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'assets/files/images/products/1741020568-product_1.png', '2025-03-03 10:49:28', '2025-03-03 10:49:28', NULL),
(2, 1, 'assets/files/images/products/1741020568-product_2.png', '2025-03-03 10:49:28', '2025-03-03 10:49:28', NULL),
(3, 1, 'assets/files/images/products/1741020568-product_3.png', '2025-03-03 10:49:28', '2025-03-03 10:49:28', NULL),
(4, 2, 'assets/files/images/products/1741021322-product_2_1.png', '2025-03-03 11:02:03', '2025-03-03 11:02:03', NULL),
(5, 2, 'assets/files/images/products/1741021323-product_2_2.png', '2025-03-03 11:02:03', '2025-03-03 11:02:03', NULL),
(6, 2, 'assets/files/images/products/1741021323-product_2_3.png', '2025-03-03 11:02:03', '2025-03-03 11:02:03', NULL),
(7, 3, 'assets/files/images/products/1741021723-product_3_1.png', '2025-03-03 11:08:43', '2025-03-03 11:08:43', NULL),
(8, 3, 'assets/files/images/products/1741021723-product_3_2.png', '2025-03-03 11:08:43', '2025-03-03 11:08:43', NULL),
(9, 3, 'assets/files/images/products/1741021723-product_3_3.png', '2025-03-03 11:08:43', '2025-03-03 11:08:43', NULL),
(10, 4, 'assets/files/images/products/1741087328-w_p_1_1.png', '2025-03-04 05:22:08', '2025-03-04 05:22:08', NULL),
(11, 4, 'assets/files/images/products/1741087328-w_p_1_2.png', '2025-03-04 05:22:08', '2025-03-04 05:22:08', NULL),
(12, 4, 'assets/files/images/products/1741087328-w_p_1_3.png', '2025-03-04 05:22:09', '2025-03-04 05:22:09', NULL),
(13, 5, 'assets/files/images/products/1741088362-w_p_2_1.png', '2025-03-04 05:39:22', '2025-03-04 05:39:22', NULL),
(14, 5, 'assets/files/images/products/1741088362-w_p_2_2.png', '2025-03-04 05:39:22', '2025-03-04 05:39:22', NULL),
(15, 5, 'assets/files/images/products/1741088362-w_p_2_3.png', '2025-03-04 05:39:23', '2025-03-04 05:39:23', NULL),
(16, 6, 'assets/files/images/products/1741089321-w_p_3_1.png', '2025-03-04 05:55:21', '2025-03-04 05:55:21', NULL),
(17, 6, 'assets/files/images/products/1741089321-w_p_3_2.png', '2025-03-04 05:55:21', '2025-03-04 05:55:21', NULL),
(18, 6, 'assets/files/images/products/1741089321-w_p_3_3.png', '2025-03-04 05:55:22', '2025-03-04 05:55:22', NULL),
(19, 6, 'assets/files/images/products/1741089322-w_p_3_4.png', '2025-03-04 05:55:22', '2025-03-04 05:55:22', NULL),
(20, 6, 'assets/files/images/products/1741089322-w_p_3_5.png', '2025-03-04 05:55:22', '2025-03-04 05:55:22', NULL),
(21, 7, 'assets/files/images/products/1741100575-product_4_1.png', '2025-03-04 09:02:56', '2025-03-04 09:02:56', NULL),
(22, 7, 'assets/files/images/products/1741100576-product_4_4.png', '2025-03-04 09:02:56', '2025-03-04 09:02:56', NULL),
(23, 7, 'assets/files/images/products/1741100576-product_4_4.png', '2025-03-04 09:02:56', '2025-03-04 09:02:56', NULL),
(24, 7, 'assets/files/images/products/1741100576-product_4_5.png', '2025-03-04 09:02:56', '2025-03-04 09:02:56', NULL),
(25, 7, 'assets/files/images/products/1741100576-s-l1600 (16).png', '2025-03-04 09:02:56', '2025-03-04 09:02:56', NULL),
(26, 8, 'assets/files/images/products/1741101389-w_p_4_2.png', '2025-03-04 09:16:29', '2025-03-04 09:16:29', NULL),
(27, 8, 'assets/files/images/products/1741101389-w_p_4_3.png', '2025-03-04 09:16:30', '2025-03-04 09:16:30', NULL),
(28, 8, 'assets/files/images/products/1741101390-w_p_4_1.png', '2025-03-04 09:16:30', '2025-03-04 09:16:30', NULL),
(29, 9, 'assets/files/images/products/1741101564-w_p_1_1.png', '2025-03-04 09:19:25', '2025-03-04 09:19:25', NULL),
(30, 9, 'assets/files/images/products/1741101565-w_p_1_2.png', '2025-03-04 09:19:25', '2025-03-04 09:19:25', NULL),
(31, 9, 'assets/files/images/products/1741101565-w_p_1_3.png', '2025-03-04 09:19:25', '2025-03-04 09:19:25', NULL),
(32, 10, 'assets/files/images/products/1741101854-w_p_5_2.png', '2025-03-04 09:24:14', '2025-03-04 09:24:14', NULL),
(33, 10, 'assets/files/images/products/1741101854-w_p_5_1.png', '2025-03-04 09:24:14', '2025-03-04 09:24:14', NULL),
(34, 10, 'assets/files/images/products/1741101854-w_p_5_3.png', '2025-03-04 09:24:14', '2025-03-04 09:24:14', NULL),
(35, 11, 'assets/files/images/products/1741107161-w_p_6_1.png', '2025-03-04 10:52:41', '2025-03-04 10:52:41', NULL),
(36, 11, 'assets/files/images/products/1741107161-w_p_6_2.png', '2025-03-04 10:52:42', '2025-03-04 10:52:42', NULL),
(38, 12, 'assets/files/images/products/1741261315-mp_1_1.png', '2025-03-06 05:41:55', '2025-03-06 05:41:55', NULL),
(39, 12, 'assets/files/images/products/1741261315-mp_1_2.png', '2025-03-06 05:41:55', '2025-03-06 05:41:55', NULL),
(40, 13, 'assets/files/images/products/1753289777-1741021723-product_3_2.png', '2025-07-23 10:56:17', '2025-07-23 10:56:17', NULL),
(41, 13, 'assets/files/images/products/1753289777-1741087328-w_p_1_1.png', '2025-07-23 10:56:17', '2025-07-23 10:56:17', NULL),
(42, 13, 'assets/files/images/products/1753289777-1741021723-product_3_2.png', '2025-07-23 10:56:18', '2025-07-23 10:56:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE `product_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `name`, `slug`, `icon`, `image`, `status`, `created_at`, `updated_at`, `created_by`, `sorting_serial`, `deleted_at`) VALUES
(1, 'Basics', 'basics', 'assets/files/images/product_type/1740839256-basic-needs.png', 'assets/files/images/product_type/1740839659-basics.png', 'active', '2025-03-01 08:27:38', '2025-04-29 09:53:54', 1, 2, NULL),
(2, 'Casual Wear', 'casual-wear', 'assets/files/images/product_type/1740839771-casual.png', 'assets/files/images/product_type/1740839771-casual-wear.png', 'active', '2025-03-01 08:36:11', '2025-04-29 09:07:23', 1, 4, NULL),
(3, 'Office Wear', 'office-wear', 'assets/files/images/product_type/1740839836-office-wear.png', 'assets/files/images/product_type/1740839836-office-wear.png', 'active', '2025-03-01 08:37:16', '2025-04-29 09:07:23', 1, 7, NULL),
(4, 'Traditional', 'traditional', 'assets/files/images/product_type/1740839920-clothing.png', 'assets/files/images/product_type/1740839920-traditional.png', 'active', '2025-03-01 08:38:41', '2025-04-29 09:08:31', 1, 8, NULL),
(5, 'Pants', 'pants', 'assets/files/images/product_type/1740840001-trousers.png', 'assets/files/images/product_type/1740840001-pants.png', 'active', '2025-03-01 08:40:02', '2025-04-29 10:10:37', 1, 1, NULL),
(6, 'Footwear', 'footwear', 'assets/files/images/product_type/1740840063-shoes.png', 'assets/files/images/product_type/1740840063-Footwear.png', 'active', '2025-03-01 08:41:03', '2025-04-29 09:07:23', 1, 5, NULL),
(7, 'Jewelry', 'jewelry', 'assets/files/images/product_type/1740840132-jewelry.png', 'assets/files/images/product_type/1740840132-Jewelry.png', 'active', '2025-03-01 08:42:13', '2025-04-29 09:07:23', 1, 6, NULL),
(8, 'Accessories', 'accessories', 'assets/files/images/product_type/1740840210-bags.png', 'assets/files/images/product_type/1740840210-Accessories.png', 'active', '2025-03-01 08:43:30', '2025-04-29 09:52:54', 1, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_type_categories`
--

CREATE TABLE `product_type_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_type_categories`
--

INSERT INTO `product_type_categories` (`id`, `product_type_id`, `category_id`, `created_at`, `updated_at`) VALUES
(8, 2, 1, '2025-04-29 10:09:07', '2025-04-29 10:09:07'),
(9, 2, 2, '2025-04-29 10:09:07', '2025-04-29 10:09:07'),
(10, 1, 1, '2025-07-11 02:50:54', '2025-07-11 02:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `inventory` int(11) NOT NULL DEFAULT 0,
  `alert_quantity` int(11) NOT NULL DEFAULT 0,
  `weight` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size_id`, `color_id`, `unit_price`, `discount_price`, `image`, `is_default`, `inventory`, `alert_quantity`, `weight`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 3, 2, '1000.00', '800.00', NULL, 0, 100, 0, '0.00', '2025-03-03 10:49:28', '2025-03-03 10:57:09', NULL),
(2, 1, 2, 2, '800.00', '600.00', NULL, 1, 97, 0, '0.00', '2025-03-03 10:49:28', '2025-10-10 12:09:10', NULL),
(3, 1, 3, 4, '1000.00', '700.00', NULL, 0, 100, 0, '0.00', '2025-03-03 10:49:28', '2025-03-03 10:49:28', NULL),
(4, 2, 2, 1, '1000.00', '0.00', NULL, 1, 95, 0, '0.00', '2025-03-03 11:02:02', '2025-07-23 11:38:11', NULL),
(5, 2, 1, 2, '800.00', '600.00', NULL, 0, 100, 0, '0.00', '2025-03-03 11:02:02', '2025-03-03 11:02:02', NULL),
(6, 2, 4, 1, '2000.00', '1800.00', NULL, 0, 100, 0, '0.00', '2025-03-03 11:02:02', '2025-03-03 11:02:02', NULL),
(7, 3, 3, 2, '900.00', '700.00', NULL, 1, 94, 0, '0.00', '2025-03-03 11:08:43', '2025-10-10 12:09:10', NULL),
(8, 3, 4, 2, '800.00', '700.00', NULL, 0, 98, 0, '0.00', '2025-03-03 11:08:43', '2025-08-23 06:04:25', NULL),
(9, 3, 4, 2, '900.00', '700.00', NULL, 0, 100, 0, '0.00', '2025-03-03 11:08:43', '2025-03-03 11:08:43', NULL),
(10, 4, 3, 2, '500.00', '450.00', NULL, 1, 100, 0, '0.00', '2025-03-04 05:22:08', '2025-03-04 05:22:08', NULL),
(11, 4, 1, 1, '900.00', '800.00', NULL, 0, 100, 0, '0.00', '2025-03-04 05:22:08', '2025-03-04 05:22:08', NULL),
(12, 4, 6, 3, '900.00', '0.00', NULL, 0, 100, 0, '0.00', '2025-03-04 05:22:08', '2025-03-04 05:22:08', NULL),
(13, 5, 3, 5, '800.00', '0.00', NULL, 1, 100, 0, '0.00', '2025-03-04 05:39:22', '2025-03-04 05:39:22', NULL),
(14, 5, 1, 2, '600.00', '0.00', NULL, 0, 100, 0, '0.00', '2025-03-04 05:39:22', '2025-03-04 05:39:22', NULL),
(15, 6, 3, 4, '900.00', '700.00', NULL, 1, 100, 0, '0.00', '2025-03-04 05:55:21', '2025-05-01 09:00:30', NULL),
(16, 6, 2, 1, '1000.00', '980.00', NULL, 0, 100, 0, '0.00', '2025-03-04 05:55:21', '2025-03-04 05:55:21', NULL),
(17, 6, 4, 4, '600.00', '500.00', NULL, 0, 100, 0, '0.00', '2025-03-04 05:55:21', '2025-05-01 09:00:30', NULL),
(18, 6, 1, 1, '800.00', '600.00', NULL, 0, 100, 0, '0.00', '2025-03-04 05:55:21', '2025-03-04 05:55:21', NULL),
(19, 7, 2, 1, '500.00', '400.00', NULL, 1, 91, 0, '0.00', '2025-03-04 09:02:55', '2025-10-10 12:09:10', NULL),
(20, 7, 1, 2, '900.00', '500.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:02:55', '2025-03-04 09:02:55', NULL),
(21, 7, 1, 5, '800.00', '600.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:02:55', '2025-03-04 09:02:55', NULL),
(22, 8, 3, 1, '900.00', '800.00', NULL, 1, 96, 0, '0.00', '2025-03-04 09:16:29', '2025-10-10 12:09:10', NULL),
(23, 8, 2, 4, '700.00', '600.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:16:29', '2025-03-04 09:16:29', NULL),
(24, 8, 2, 1, '900.00', '800.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:16:29', '2025-03-04 09:16:29', NULL),
(25, 9, 3, 2, '900.00', '700.00', NULL, 1, 100, 0, '0.00', '2025-03-04 09:19:24', '2025-06-02 10:52:03', NULL),
(26, 9, 2, 1, '900.00', '800.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:19:24', '2025-03-04 09:19:24', NULL),
(27, 9, 4, 4, '800.00', '700.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:19:24', '2025-03-04 09:19:24', NULL),
(28, 10, 3, 1, '800.00', '500.00', NULL, 1, 89, 0, '0.00', '2025-03-04 09:24:14', '2025-09-23 10:36:11', NULL),
(29, 10, 1, 3, '900.00', '700.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:24:14', '2025-03-04 09:24:14', NULL),
(30, 10, 4, 3, '800.00', '700.00', NULL, 0, 100, 0, '0.00', '2025-03-04 09:24:14', '2025-06-02 10:52:03', NULL),
(31, 11, 2, 1, '4500.00', '0.00', NULL, 0, 100, 0, '0.00', '2025-03-04 10:52:41', '2025-04-25 09:56:36', NULL),
(32, 11, 3, 4, '5000.00', '4800.00', NULL, 1, 96, 0, '0.00', '2025-03-04 10:52:41', '2025-10-10 12:09:10', NULL),
(33, 11, 4, 2, '5000.00', '4800.00', NULL, 0, 100, 0, '0.00', '2025-03-04 10:52:41', '2025-03-04 10:52:41', NULL),
(34, 12, 3, 2, '4000.00', '3500.00', NULL, 1, 98, 0, '0.00', '2025-03-06 05:41:55', '2025-07-23 11:38:11', NULL),
(35, 12, 2, 3, '4000.00', '3500.00', NULL, 0, 100, 0, '0.00', '2025-03-06 05:41:55', '2025-03-06 05:41:55', NULL),
(36, 12, 4, 5, '800.00', '0.00', NULL, 0, 100, 0, '0.00', '2025-03-06 05:41:55', '2025-03-06 05:41:55', NULL),
(37, 11, NULL, NULL, '800.00', '600.00', NULL, 0, 100, 0, '0.00', '2025-04-25 11:24:41', '2025-04-25 11:24:41', NULL),
(38, 13, NULL, NULL, '912.00', '707.00', NULL, 1, 6, 0, '0.00', '2025-07-23 10:56:17', '2025-10-10 12:09:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `order_id`, `order_product_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(4, 6, 27, 66, 9, 3, 'McLaughlin - Predovic Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-07-13 11:45:10', '2025-07-13 11:46:41'),
(5, 6, 27, 65, 10, 4, 'Aute ut dolor non coLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2025-07-13 11:45:27', '2025-07-13 11:46:30');

-- --------------------------------------------------------

--
-- Table structure for table `section_products`
--

CREATE TABLE `section_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_order_logs`
--

CREATE TABLE `seller_order_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_product` int(11) NOT NULL DEFAULT 0,
  `shipping_fee` double NOT NULL DEFAULT 0,
  `order_amount` double NOT NULL DEFAULT 0,
  `commission_rate` double(8,2) NOT NULL DEFAULT 0.00,
  `total_commission` double NOT NULL DEFAULT 0,
  `order_price` double NOT NULL DEFAULT 0,
  `seller_amount` double NOT NULL DEFAULT 0,
  `payment_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pay_to` enum('seller','merchant') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'merchant'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_order_logs`
--

INSERT INTO `seller_order_logs` (`id`, `seller_id`, `order_id`, `order_number`, `invoice`, `total_product`, `shipping_fee`, `order_amount`, `commission_rate`, `total_commission`, `order_price`, `seller_amount`, `payment_status`, `created_at`, `updated_at`, `pay_to`) VALUES
(23, 2, '32', '0001', 'RT-68288997', 2, 60, 5507, 10.00, 550.7, 5567, 4956.3, 'unpaid', '2025-10-10 12:09:33', '2025-10-10 12:09:33', 'merchant'),
(24, 1, '32', '0001', 'RT-68288997', 4, 60, 2900, 15.00, 435, 2960, 2465, 'unpaid', '2025-10-10 12:09:33', '2025-10-10 12:09:33', 'merchant');

-- --------------------------------------------------------

--
-- Table structure for table `seller_shops`
--

CREATE TABLE `seller_shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) NOT NULL,
  `shop_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_from` date DEFAULT NULL,
  `licence_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `licence_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pdf',
  `website_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_shops`
--

INSERT INTO `seller_shops` (`id`, `seller_id`, `shop_name`, `email`, `mobile`, `phone`, `address`, `start_from`, `licence_no`, `licence_file`, `website_url`, `logo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ferdinand Duncan', 'dijyt@mailinator.com', '01609605494', '+1 (989) 674-1798', 'Pariatur Laborum V', '2025-02-12', 'Consequat Neque odi', NULL, 'https://www.lenonuliqiwaz.org', NULL, '2025-02-27 10:38:17', '2025-06-27 00:48:16'),
(2, 2, 'Chaney Potter', 'vabugaru@mailinator.com', '01636958789', '+1 (981) 938-3582', 'Illum quisquam volu', '2025-03-20', '251259151', NULL, 'https://www.miqo.ws', NULL, '2025-03-04 10:48:27', '2025-07-23 11:27:10'),
(3, 3, 'Anika Atkinson', 'bavivil@mailinator.com', '01827271455', '+1 (289) 385-9915', 'Qui atque molestias', '2025-03-20', 'Officia repudiandae', NULL, 'https://www.quhi.me', NULL, '2025-03-06 02:17:50', '2025-03-06 02:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `slug`, `created_at`, `updated_at`, `created_by`, `deleted_at`) VALUES
(1, 'S', 's', '2025-03-03 09:58:49', '2025-03-03 09:58:49', 1, NULL),
(2, 'M', 'm', '2025-03-03 09:58:55', '2025-03-03 09:58:55', 1, NULL),
(3, 'L', 'l', '2025-03-03 09:59:06', '2025-03-03 09:59:06', 1, NULL),
(4, 'XL', 'xl', '2025-03-03 09:59:12', '2025-03-03 09:59:12', 1, NULL),
(5, 'XXL', 'xxl', '2025-03-03 09:59:45', '2025-03-03 09:59:45', 1, NULL),
(6, 'XS', 'xs', '2025-03-03 09:59:58', '2025-03-03 09:59:58', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlighted_title` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `highlighted_caption` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `sorting_serial` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `highlighted_title`, `caption`, `highlighted_caption`, `slug`, `image_path`, `redirect_link`, `button_name`, `status`, `sorting_serial`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Lifestyle Collection', 'For Traveling', 'Sale up to', '30% off', '1744611641-lifestyle-collection', 'assets/files/images/slider/1744610791-1.png', NULL, 'Shop Now', 'active', 1, 1, '2025-04-14 00:06:31', '2025-04-14 01:35:49'),
(2, 'Just for you', 'Make your Travel products', 'Up to', '50% off', '1744611189-just-for-you', 'assets/files/images/slider/1744611189-Compulsive-shopper-JFW.jpg', NULL, 'Shop Here', 'active', 2, 1, '2025-04-14 00:13:09', '2025-04-14 01:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `slider_products`
--

CREATE TABLE `slider_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slider_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slider_products`
--

INSERT INTO `slider_products` (`id`, `slider_id`, `product_id`, `sorting_serial`, `created_at`, `updated_at`) VALUES
(9, 1, 7, 1, '2025-04-14 08:31:08', '2025-05-14 10:22:08'),
(10, 1, 9, 3, '2025-04-14 08:31:12', '2025-05-14 10:22:08'),
(11, 1, 10, 2, '2025-04-14 08:31:15', '2025-05-14 10:22:08'),
(12, 1, 11, 5, '2025-04-14 08:31:19', '2025-05-14 10:22:08'),
(13, 1, 8, 4, '2025-04-14 08:31:23', '2025-05-14 10:22:08');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_mega_menu` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `slug`, `icon`, `image`, `status`, `is_mega_menu`, `created_at`, `updated_at`, `created_by`, `sorting_serial`, `deleted_at`) VALUES
(1, 1, 'WINTER', 'men-winter', 'assets/files/images/sub_category/1740842272-man.png', NULL, 'active', 'yes', '2025-03-01 09:17:52', '2025-03-01 10:33:03', 1, 1, NULL),
(2, 1, 'CASUAL DRESS', 'men-casual-dress', 'assets/files/images/sub_category/1740842289-man.png', NULL, 'active', 'no', '2025-03-01 09:18:09', '2025-03-01 10:27:44', 1, 2, NULL),
(3, 2, 'WINTER', 'women-winter', 'assets/files/images/sub_category/1740842532-woman.png', NULL, 'active', 'no', '2025-03-01 09:22:12', '2025-03-01 10:27:11', 1, 1, NULL),
(4, 2, 'CASUAL DRESS', 'women-casual-dress', 'assets/files/images/sub_category/1740842559-woman.png', NULL, 'active', 'no', '2025-03-01 09:22:39', '2025-03-01 10:28:11', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category_banners`
--

CREATE TABLE `sub_category_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_category_banners`
--

INSERT INTO `sub_category_banners` (`id`, `subcategory_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'assets/files/images/category/1740845287-men_winter_1.png', '2025-03-01 10:08:07', '2025-03-01 10:08:07'),
(2, 1, 'assets/files/images/category/1740845287-men_winter_2.png', '2025-03-01 10:08:07', '2025-03-01 10:08:07'),
(3, 1, 'assets/files/images/category/1740845287-men_winter_3.png', '2025-03-01 10:08:07', '2025-03-01 10:08:07'),
(4, 3, 'assets/files/images/category/1740846431-women_winter_1.png', '2025-03-01 10:27:11', '2025-03-01 10:27:11'),
(5, 3, 'assets/files/images/category/1740846431-women_winter_2.png', '2025-03-01 10:27:11', '2025-03-01 10:27:11'),
(6, 3, 'assets/files/images/category/1740846431-women_winter_3.png', '2025-03-01 10:27:11', '2025-03-01 10:27:11'),
(7, 2, 'assets/files/images/category/1740846464-men_casual_1.png', '2025-03-01 10:27:44', '2025-03-01 10:27:44'),
(8, 2, 'assets/files/images/category/1740846464-men_casual_2.png', '2025-03-01 10:27:44', '2025-03-01 10:27:44'),
(9, 2, 'assets/files/images/category/1740846464-men_casual_3.png', '2025-03-01 10:27:45', '2025-03-01 10:27:45'),
(10, 4, 'assets/files/images/category/1740846491-men_casual_1.png', '2025-03-01 10:28:11', '2025-03-01 10:28:11'),
(11, 4, 'assets/files/images/category/1740846491-men_casual_2.png', '2025-03-01 10:28:11', '2025-03-01 10:28:11'),
(12, 4, 'assets/files/images/category/1740846491-men_casual_3.png', '2025-03-01 10:28:11', '2025-03-01 10:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `sub_subcategories`
--

CREATE TABLE `sub_subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_mega_menu` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `sorting_serial` int(11) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_subcategories`
--

INSERT INTO `sub_subcategories` (`id`, `category_id`, `subcategory_id`, `name`, `slug`, `icon`, `image`, `status`, `is_mega_menu`, `created_at`, `updated_at`, `created_by`, `sorting_serial`, `deleted_at`) VALUES
(1, 1, 1, 'DRESSES', 'men-winter-dresses', 'assets/files/images/sub_category/1740843629-man.png', NULL, 'active', 'yes', '2025-03-01 09:40:30', '2025-03-03 09:58:38', 1, 1, NULL),
(2, 1, 1, 'Rompers and Jumpsuits', 'men-winter-rompers-and-jumpsuits', 'assets/files/images/sub_sub_category/1741017364-clothing.png', NULL, 'active', 'yes', '2025-03-03 09:56:04', '2025-03-03 09:58:26', 1, 2, NULL),
(3, 1, 2, 'T-SHIRTS and Vests', 'men-casual-dress-t-shirts-and-vests', 'assets/files/images/sub_sub_category/1741017423-office-wear.png', NULL, 'active', 'yes', '2025-03-03 09:57:03', '2025-03-03 09:57:03', 1, 1, NULL),
(4, 2, 3, 'DRESSES', 'women-winter-dresses', 'assets/files/images/sub_sub_category/1741017484-woman.png', NULL, 'active', 'yes', '2025-03-03 09:58:04', '2025-03-03 09:58:04', 1, 1, NULL),
(5, 2, 3, 'Rompers and Jumpsuits', 'women-winter-rompers-and-jumpsuits', 'assets/files/images/sub_sub_category/1741087393-woman.png', NULL, 'active', 'yes', '2025-03-04 05:23:13', '2025-03-04 05:23:13', 1, 2, NULL),
(6, 2, 4, 'DRESSES', 'women-casual-dress-dresses', 'assets/files/images/sub_sub_category/1741088951-clothing.png', NULL, 'active', 'yes', '2025-03-04 05:49:11', '2025-03-04 05:49:11', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sub_sub_category_banners`
--

CREATE TABLE `sub_sub_category_banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_subcategory_id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_sub_category_banners`
--

INSERT INTO `sub_sub_category_banners` (`id`, `sub_subcategory_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'assets/files/images/sub_sub_category/1741017277-men_winter_1.png', '2025-03-03 09:53:23', '2025-03-03 09:54:37'),
(2, 1, 'assets/files/images/sub_sub_category/1741017203-men_casual_2.png', '2025-03-03 09:53:23', '2025-03-03 09:53:23'),
(3, 2, 'assets/files/images/sub_sub_category/1741017364-men1.png', '2025-03-03 09:56:04', '2025-03-03 09:56:04'),
(4, 2, 'assets/files/images/sub_sub_category/1741017364-men3.png', '2025-03-03 09:56:04', '2025-03-03 09:56:04'),
(5, 3, 'assets/files/images/sub_sub_category/1741017423-men2.png', '2025-03-03 09:57:03', '2025-03-03 09:57:03'),
(6, 4, 'assets/files/images/sub_sub_category/1741017484-women_winter_1.png', '2025-03-03 09:58:05', '2025-03-03 09:58:05'),
(7, 4, 'assets/files/images/sub_sub_category/1741017485-women_winter_2.png', '2025-03-03 09:58:05', '2025-03-03 09:58:05'),
(8, 4, 'assets/files/images/sub_sub_category/1741017485-women_winter_3.png', '2025-03-03 09:58:05', '2025-03-03 09:58:05'),
(9, 5, 'assets/files/images/sub_sub_category/1741087393-women1.png', '2025-03-04 05:23:13', '2025-03-04 05:23:13'),
(10, 5, 'assets/files/images/sub_sub_category/1741087393-women2.png', '2025-03-04 05:23:13', '2025-03-04 05:23:13'),
(11, 5, 'assets/files/images/sub_sub_category/1741087393-women3.png', '2025-03-04 05:23:13', '2025-03-04 05:23:13'),
(12, 6, 'assets/files/images/sub_sub_category/1741088951-women1.png', '2025-03-04 05:49:11', '2025-03-04 05:49:11'),
(13, 6, 'assets/files/images/sub_sub_category/1741088951-women1.png', '2025-03-04 05:49:11', '2025-03-04 05:49:11'),
(14, 6, 'assets/files/images/sub_sub_category/1741088951-women3.png', '2025-03-04 05:49:11', '2025-03-04 05:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`, `created_by`, `deleted_at`) VALUES
(1, 'ROMPERS', 'rompers', '2025-03-03 10:15:52', '2025-03-03 10:15:52', 1, NULL),
(2, 'JUMPSUITS', 'jumpsuits', '2025-03-03 10:16:00', '2025-03-03 10:16:00', 1, NULL),
(3, 'ONE PIECE', 'one-piece', '2025-03-04 05:50:04', '2025-03-04 05:50:04', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `unique_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_amount` double(8,2) NOT NULL,
  `vat` double(8,2) DEFAULT NULL,
  `store_amount` double(8,2) DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_rate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_tran_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `error` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_issuer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_sub_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_issuer_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_issuer_country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_sign` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_key` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_sign_sha2` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_fair` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `risk_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `risk_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city_town` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `order_id`, `unique_id`, `order_number`, `invoice`, `gateway`, `transaction_id`, `transaction_invoice`, `transaction_time`, `transaction_ip`, `transaction_amount`, `vat`, `store_amount`, `currency`, `currency_type`, `currency_amount`, `currency_rate`, `status`, `message`, `val_id`, `card_type`, `card_no`, `bank_tran_id`, `transaction_date`, `error`, `card_issuer`, `card_brand`, `card_sub_brand`, `card_issuer_country`, `card_issuer_country_code`, `store_id`, `verify_sign`, `verify_key`, `verify_sign_sha2`, `base_fair`, `risk_level`, `risk_title`, `name`, `mobile`, `city_town`, `post_code`, `address`, `created_at`, `updated_at`) VALUES
(1, 6, 24, 'D2QBMKAWZD', '0024', 'RT-65618643', 'sslcommerz', '683C4C5DAAEA5', NULL, '2025-06-01 18:49:35', '127.0.0.1', 460.00, NULL, 448.50, 'BDT', 'BDT', '460.00', '1.0000', 'SUCCESS', 'Issuer Bank Declined', '250601185018IpDeCqooCZ4UHjH', 'VISA-Dutch Bangla', '418117XXXXXX7814', '25060118501819XheDz2UfxpDmL', '2025-06-01 18:49:35', NULL, 'TRUST BANK, LTD.', 'VISA', 'Classic', 'Bangladesh', 'BD', 'mobix615553a06cc1f', 'd5a9205f482d9925b7219d9536515693', 'amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d', '91d2f3c8b6de38a61f89dfd3e1b0da3349134537c9bcc74d72901b0256e3c0f5', '0.00', '0', 'Safe', 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-06-01 06:49:33', '2025-06-01 06:50:21'),
(2, 6, 23, 'F62Y5JV0BP', '0023', 'RT-43209725', 'sslcommerz', '683C4C93C173E', NULL, '2025-06-01 12:50:27', '127.0.0.1', 4260.00, NULL, 4153.50, 'BDT', 'BDT', '4260.00', '1.0000', 'FAILED', '3D Security Validation Failed', '25060122541BudQPfDcJdwYsS7', 'BKASH-BKash', NULL, '250601225410mTuCYJekMB6XQu', NULL, NULL, 'BKash Mobile Banking', 'MOBILEBANKING', 'Classic', 'Bangladesh', 'BD', 'mobix615553a06cc1f', '391c700bd4e96f25b353d3c98937043e', 'amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d', '5154d2f8c0bf5ceb1b6c61141d9fca55a42c77fca981dd82d45e73a2622374ef', '0.00', '0', 'Safe', 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-06-01 06:50:27', '2025-06-01 06:51:22'),
(3, 6, 22, 'ZBKFXEQKAI', '0022', 'RT-84286112', 'sslcommerz', '683C11598D7B3', NULL, '2025-06-01 08:37:45', '::1', 4260.00, NULL, 4153.50, 'BDT', 'BDT', '4260.00', '1.0000', 'FAILED', 'Do not honor', '250601225531nfRj7ng7iRhDQP', 'DBBLMOBILEB-Dbbl Mobile Banking', NULL, '2506012255318TAeHJ9kuLF3E8', NULL, NULL, 'DBBL Mobile Banking', 'MOBILEBANKING', 'Classic', 'Bangladesh', 'BD', 'mobix615553a06cc1f', '474c9ff8b132478ee81783d6d8389477', 'amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d', '5db700f00d05fe8a827b2f67643bcdf083c59f4ae4b1cfba3f419b3b75b4d4c5', '0.00', '0', 'Safe', 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-06-01 02:37:45', '2025-06-01 02:37:54'),
(4, 6, 21, 'C4NEVLHXNG', '0021', 'RT-81578206', 'sslcommerz', '683B6703094FD', NULL, '2025-06-01 02:31:01', '::1', 4260.00, NULL, 4153.50, 'BDT', 'BDT', '4260.00', '1.0000', 'SUCCESS', '', '250601233110jDiUxlkbDpMeey', 'VISA-Dutch Bangla', '432149XXXXXX0667', '250601233111kWCHj7bd2JHtBg', '2025-06-01 02:31:01', NULL, 'BRAC BANK, LTD.', 'VISA', 'Classic', 'Bangladesh', 'BD', 'mobix615553a06cc1f', 'a413c72c59208c78285d0fb365bded51', 'amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d', '7ade6952dbbbedf91235872b4b606a97c13278e10ff5c4a54b0807085e083b04', '0.00', '0', 'Safe', 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-05-31 14:30:59', '2025-05-31 14:33:21'),
(5, 6, 19, 'MPIWUNSCFI', '0019', 'RT-53878240', NULL, '683C0C217B8B8', NULL, '2025-06-01 08:15:29', '::1', 2400.00, NULL, NULL, 'BDT', NULL, NULL, NULL, 'PENDING', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-06-01 02:15:29', '2025-06-01 02:15:29'),
(6, 6, 25, 'UXPRLA1MRO', '0025', 'RT-86409952', 'sslcommerz', '687004082923B', NULL, '2025-07-11 00:18:50', '::1', 1224.00, NULL, 1193.40, 'BDT', 'BDT', '1224.00', '1.0000', 'SUCCESS', NULL, '250711019021SmS35gUPebqFpe', 'VISA-Dutch Bangla', '421481XXXXXX4177', '25071101902DCscb4IM9U6jF3t', '2025-07-11 00:18:50', NULL, 'STANDARD CHARTERED BANK', 'VISA', 'Classic', 'Bangladesh', 'BD', 'mobix615553a06cc1f', '68c634837202e4cbd2b236be588951e4', 'amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d', '9b8bc52933d57e5cdd9b2598fe70dd3ea11dd1411f97c9d908c18c809614bfbb', '0.00', '0', 'Safe', 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-07-10 12:18:48', '2025-07-10 12:19:03'),
(7, 6, 20, 'TY49VZJWVA', '0020', 'RT-24545298', 'sslcommerz', '683C713B82739', NULL, '2025-06-01 21:26:53', '127.0.0.1', 2400.00, NULL, 2340.00, 'BDT', 'BDT', '2400.00', '1.0000', 'SUCCESS', NULL, '2506012127310Bo50X03PrIq6bi', 'VISA-Dutch Bangla', '432149XXXXXX0667', '2506012127310nN8WgpeDKhlbMI', '2025-06-01 21:26:53', NULL, 'BRAC BANK, LTD.', 'VISA', 'Classic', 'Bangladesh', 'BD', 'mobix615553a06cc1f', '972ff3b5f66e340b72e8c1184bc886dd', 'amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d', '44303799e743e0d40d69888d5b7dbc10b2063b9a58918ab7d58a1877087dc861', '0.00', '0', 'Safe', 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-06-01 09:26:51', '2025-06-01 09:27:33'),
(8, 6, 27, '06ZXJDCPYW', '0027', 'RT-47764322', 'sslcommerz', '683DD6C2531B7', NULL, '2025-06-02 22:52:20', '::1', 3060.00, NULL, 2983.50, 'BDT', 'BDT', '3060.00', '1.0000', 'SUCCESS', NULL, '250602225326106D5e55QlxoQTo', 'BKASH-BKash', NULL, '250602225326XNeowcAhh7ItFpM', '2025-06-02 22:52:20', NULL, 'BKash Mobile Banking', 'MOBILEBANKING', 'Classic', 'Bangladesh', 'BD', 'mobix615553a06cc1f', '4729dc27cfaff7a6dbdd3adc0c1e91a2', 'amount,bank_tran_id,base_fair,card_brand,card_issuer,card_issuer_country,card_issuer_country_code,card_no,card_sub_brand,card_type,currency,currency_amount,currency_rate,currency_type,error,risk_level,risk_title,status,store_amount,store_id,tran_date,tran_id,val_id,value_a,value_b,value_c,value_d', '410b9f178921b93b0c0f2ddc4acc887b3d0c4834e29d294b6de2eac8d973f41b', '0.00', '0', 'Safe', 'Stewart Sanford', '01609605491', 'Eligendi occaecat es', '5256', 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '2025-06-02 10:52:18', '2025-06-02 10:53:28');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `slug`, `created_at`, `updated_at`, `created_by`, `deleted_at`) VALUES
(1, 'PIECE', 'piece', '2025-03-03 10:02:53', '2025-03-03 10:02:53', 1, NULL),
(2, 'BUNDLE', 'bundle', '2025-03-03 10:03:05', '2025-03-03 10:03:05', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mobile` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `need_change_mobile` tinyint(1) NOT NULL DEFAULT 0,
  `need_change_password` tinyint(1) NOT NULL DEFAULT 0,
  `verification_code` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `mobile`, `mobile_verified_at`, `district_id`, `city`, `zip_code`, `home_address`, `delivery_address`, `password`, `remember_token`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`, `google_id`, `facebook_id`, `instagram_id`, `need_change_mobile`, `need_change_password`, `verification_code`) VALUES
(1, 'Yoshi', 'Tillman', 'rike@mailinator.com', NULL, '01609605494', NULL, 1, 'Eligendi occaecat es', '26367', NULL, 'Voluptas non et quis', '$2y$10$y61CaR4AuaXQk/xNE1gL/ek0Kul.9en66EC0qj7pZnuWwGJdPn61u', NULL, NULL, 'active', '2025-04-27 08:45:57', '2025-05-06 07:27:01', NULL, NULL, NULL, NULL, 0, 0, NULL),
(5, 'MD', 'RAJU', 'raju.eatl.nu@gmail.com', '2025-05-08 10:24:19', 'google21830', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$iwB/rOBQcGFLCAu789V4QeQQgG.hpWJt4YAOP7XtOQeInazZxhz8m', NULL, NULL, 'active', '2025-05-07 10:28:59', '2025-05-08 10:24:19', NULL, '101401432118761020988', NULL, NULL, 1, 1, NULL),
(6, 'Stewart', 'Sanford', 'mkraju.eatl@gmail.com', '2025-08-11 11:05:12', '01609605491', '2025-06-01 06:41:42', 1, 'Eligendi occaecat es', '5256', NULL, 'Shibu lichu bagan, Baruahat, Kaunia, Rangpur', '$2y$10$BDQqs8rIORIVbxtq3EtoROHifTgm2fkFhCiiEzXoZnZm7DSxFijge', NULL, NULL, 'active', '2025-05-07 11:02:17', '2025-08-11 11:05:12', NULL, NULL, '122103821372861332', NULL, 0, 0, NULL),
(7, 'Moktadirul', 'Raju', 'moktadirulraju@gmail.com', '2025-05-18 10:40:56', 'google14616', NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$oCQk8jUGK4P/E8S8caoAmOMxPCxNWldmFXxRqGovrkCaXAzY8yWxm', NULL, NULL, 'active', '2025-05-18 10:40:56', NULL, NULL, '111616602669580760558', NULL, NULL, 1, 1, NULL),
(8, 'Gage', 'Delacruz', 'nahixekony@mailinator.com', NULL, '01737773393', NULL, 2, 'Nostrud voluptates d', '33979', NULL, 'Ut consequatur excep', '$2y$10$P7TQ5RnE136UsXoelu.rWuGYZmfkWsgZTsY6i2ChidXcCs5cM0oqS', NULL, NULL, 'active', '2025-08-29 01:35:32', '2025-08-29 01:35:32', NULL, NULL, NULL, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(5, 6, 10, '2025-07-23 12:27:09', '2025-07-23 12:27:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_mobile_unique` (`mobile`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand_banners`
--
ALTER TABLE `brand_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_banners`
--
ALTER TABLE `category_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_coupon_code_unique` (`coupon_code`);

--
-- Indexes for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `join_requests`
--
ALTER TABLE `join_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `latest_offer_products`
--
ALTER TABLE `latest_offer_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_in_products`
--
ALTER TABLE `new_in_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_unique_id_unique` (`unique_id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD UNIQUE KEY `orders_invoice_unique` (`invoice`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_product_code_unique` (`product_code`);
ALTER TABLE `products` ADD FULLTEXT KEY `products_name_fulltext` (`name`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_type_categories`
--
ALTER TABLE `product_type_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_products`
--
ALTER TABLE `section_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_order_logs`
--
ALTER TABLE `seller_order_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seller_order_logs_seller_id_order_id_order_number_invoice_unique` (`seller_id`,`order_id`,`order_number`,`invoice`);

--
-- Indexes for table `seller_shops`
--
ALTER TABLE `seller_shops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seller_shops_email_unique` (`email`),
  ADD UNIQUE KEY `seller_shops_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `seller_shops_phone_unique` (`phone`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider_products`
--
ALTER TABLE `slider_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_category_banners`
--
ALTER TABLE `sub_category_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_subcategories`
--
ALTER TABLE `sub_subcategories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_sub_category_banners`
--
ALTER TABLE `sub_sub_category_banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brand_banners`
--
ALTER TABLE `brand_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `category_banners`
--
ALTER TABLE `category_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_charges`
--
ALTER TABLE `delivery_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `join_requests`
--
ALTER TABLE `join_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `latest_offer_products`
--
ALTER TABLE `latest_offer_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `new_in_products`
--
ALTER TABLE `new_in_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_type_categories`
--
ALTER TABLE `product_type_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `section_products`
--
ALTER TABLE `section_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller_order_logs`
--
ALTER TABLE `seller_order_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `seller_shops`
--
ALTER TABLE `seller_shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slider_products`
--
ALTER TABLE `slider_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sub_category_banners`
--
ALTER TABLE `sub_category_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sub_subcategories`
--
ALTER TABLE `sub_subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sub_sub_category_banners`
--
ALTER TABLE `sub_sub_category_banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
