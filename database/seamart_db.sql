-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 04:04 PM
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
-- Database: `seamart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `first_name`, `last_name`, `middle_name`, `address`, `address2`, `brgy`, `town`, `zip`, `phone`, `email`, `default`, `created_at`, `updated_at`) VALUES
(1, 2, 'Juan', 'Siony', 'Smith', 'Purok 1, Mainroad', 'Mallari\'s Store', 'Sta. CLara', 'Gonzaga', '3135', '09263070491', 'juansmith@gmail.com', 1, '2025-05-22 03:13:56', '2025-05-22 03:13:56'),
(2, 2, 'Jane', 'Smith', 'Labrador', 'Mabini Street, Hercy', 'beside Tinuno Express', 'Smart', 'Gonzaga', '3135', '09384758245', 'janesmith@gmail.com', 0, '2025-05-22 04:03:55', '2025-05-22 04:03:55'),
(4, 1, 'Gorgonio', 'Magalpok', NULL, 'Purok 5, Rizal Street', 'in Front of Brgy. Hall', 'Minanga', 'Gonzaga', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 1, '2025-05-21 23:34:03', '2025-05-21 23:34:03'),
(5, 1, 'Juan', 'Dela Cruz', NULL, '#25 Mabini Street', 'Apartment 4B', 'Sta. Maria', 'Tuguegarao', '3500', '09181234567', 'juan.delacruz@example.com', 0, '2025-05-22 00:45:13', '2025-05-22 00:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@seamart.com', '$2y$12$bbYMPAMKwrmWQOrNRcZ7s.MvRKQCyCKRJqgRuflKhwwbZD150Bt0m', '2025-05-16 17:24:20', '2025-05-16 17:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Water Fish', 'Fish commonly found in rivers and lakes', '2025-05-16 23:49:38', '2025-05-17 00:23:21'),
(2, 'Seaweed', 'Edible marine algae used in many dishes', '2025-05-17 00:03:07', '2025-05-17 00:33:36'),
(4, 'Salt Water Fish', 'Fish commonly found in Ocean Floors', '2025-05-17 01:13:59', '2025-05-17 01:13:59'),
(5, 'Crustaceans', 'Includes shrimp, crabs, and lobsters', '2025-05-17 01:14:56', '2025-05-17 01:14:56'),
(6, 'Dried Fish', 'Seafood products preserved by drying, known for their long shelf life and rich, savory flavor.', '2025-05-19 04:46:47', '2025-05-19 04:46:47');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Joseph Garcia', 'test@gmail.com', '$2y$12$CDYY4DYdh9/eR9ZPhwg5J.hr8/xiCHG99KkqoYz9kXnXw8dDm6b9.', '2025-05-18 08:38:31', '2025-05-19 04:20:25'),
(2, 'Anonymous User', 'anonymousabx@gmail.com', '$2y$12$p0hK1bC/SQRdkVum7UuAbOXceb3/OunwuXeH2uk33SzmP3E.Q4/3W', '2025-05-19 04:24:54', '2025-05-20 02:54:05'),
(5, 'Gorgonio Magalpok', 'gorgoniomagalpok@gmail.com', '$2y$12$sIED0OS8CKX3MTYEybtsROrnQD81ikwWWsIZ2fiR/a/zUFuKo4712', '2025-05-23 06:00:42', '2025-05-23 06:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`id`, `customer_id`, `picture`, `lname`, `fname`, `mname`, `contact_number`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin-assets/assets/images/customers/1747651789_clfswbhi3000fla08gpj0bnv0_1.jpg', 'Garcia', 'Joseph', NULL, '09384728574', 'test@gmail.com', 'Purok 5, Batangan, Gonzaga, Cagayan', '2025-05-19 01:43:45', '2025-05-19 02:51:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_17_002122_add_role_to_users_table', 1),
(5, '2025_05_17_004005_create_admins_table', 1),
(6, '2025_05_17_004017_create_customers_table', 1),
(7, '2025_05_17_063254_create_products_table', 2),
(8, '2025_05_17_063449_create_categories_table', 2),
(9, '2025_05_17_083908_create_products_table', 3),
(10, '2025_05_17_095130_create_customer_details_table', 4),
(11, '2025_05_18_014817_add_english_name_to_products_table', 5),
(12, '2025_05_18_020616_add_discount_to_products_table', 6),
(13, '2025_05_18_084132_add_tags_to_products_table', 7),
(14, '2025_05_19_011405_create_orders_table', 8),
(15, '2025_05_19_011657_create_order_items__table', 8),
(16, '2025_05_22_020542_add_mode_of_payment_to_orders_table', 9),
(17, '2025_05_22_025935_create_addresses_table', 10),
(18, '2025_05_22_085932_create_transaction_logs_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) NOT NULL,
  `town` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `order_notes` text DEFAULT NULL,
  `status` enum('Pending','Processing','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  `mode_of_payment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `first_name`, `last_name`, `address`, `address2`, `brgy`, `town`, `zip`, `phone`, `email`, `order_notes`, `status`, `mode_of_payment`, `created_at`, `updated_at`) VALUES
(1, 1, 'Juan', 'Dela Cruz', 'Purok 1', NULL, 'Amunitan', 'Gonzaga', '3513', '091836482674', 'juandelacruz@example.com', NULL, 'Cancelled', 'Cash on Delivery', '2025-05-18 19:01:12', '2025-05-18 22:43:42'),
(2, 1, 'Gorgonio', 'Magalpok', 'Purok 5', NULL, 'Minanga', 'Gonzaga', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Completed', 'GrabPay', '2025-05-18 19:07:40', '2025-05-18 21:59:42'),
(3, 1, 'Maria', 'Dimagiba', 'Purok 3', NULL, 'Tapel', 'Gonzaga', '3513', '09857263541', 'mariadimagiba@gmail.com', 'qwertyuiop', 'Pending', 'Cash on Delivery', '2025-05-18 19:18:50', '2025-05-18 19:18:50'),
(4, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Batangan, Gonzaga, Cagayan', 'Abay dakkel nga mangga', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Completed', 'Maya', '2025-05-20 06:13:23', '2025-05-20 06:16:48'),
(5, 2, 'Gorgonio', 'Magalpok', 'Purok 5, Batangan, Gonzaga, Cagayan', 'Abay dakkel nga mangga', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Pending', 'GCash', '2025-05-21 18:17:49', '2025-05-21 18:17:49'),
(6, 2, 'Juan', 'Siony', 'Purok 1, Mainroad', 'Mallari\'s Store', 'Sta. CLara', 'Gonzaga|3513', '3513', '09263070491', 'juansmith@gmail.com', NULL, 'Pending', 'GCash', '2025-05-21 23:06:52', '2025-05-21 23:06:52'),
(7, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Batangan, Gonzaga, Cagayan', 'Abay dakkel nga mangga', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Pending', 'Cash on Delivery', '2025-05-21 23:27:07', '2025-05-21 23:27:07'),
(8, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Rizal Street', 'in Front of Brgy. Hall', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Pending', 'Cash on Delivery', '2025-05-21 23:34:03', '2025-05-21 23:34:03'),
(9, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Rizal Street', 'in Front of Brgy. Hall', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Pending', 'Cash on Delivery', '2025-05-21 23:38:46', '2025-05-21 23:38:46'),
(10, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Rizal Street', 'in Front of Brgy. Hall', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Pending', 'Cash on Delivery', '2025-05-21 23:45:58', '2025-05-21 23:45:58'),
(11, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Rizal Street', 'in Front of Brgy. Hall', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', NULL, 'Pending', 'Cash on Delivery', '2025-05-21 23:53:57', '2025-05-21 23:53:57'),
(12, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Rizal Street', 'in Front of Brgy. Hall', 'Minanga', 'Gonzaga|3513', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', 'Please be careful with the item', 'Pending', 'Cash on Delivery', '2025-05-22 00:14:39', '2025-05-22 00:14:39'),
(13, 1, 'Gorgonio', 'Magalpok', 'Purok 5, Rizal Street', 'in Front of Brgy. Hall', 'Minanga', 'Gonzaga', '3513', '09384728574', 'gorgoniomagalpok@gmail.com', NULL, 'Pending', 'Cash on Delivery', '2025-05-22 00:30:46', '2025-05-22 00:30:46'),
(14, 1, 'Juan', 'Dela Cruz', '#25 Mabini Street', 'Apartment 4B', 'Sta. Maria', 'Tuguegarao', '3500', '09181234567', 'juan.delacruz@example.com', 'Leave at the front gate if no one answers.', 'Pending', 'GrabPay', '2025-05-22 00:45:13', '2025-05-22 00:45:13'),
(15, 2, 'Jane', 'Smith', 'Mabini Street, Hercy', 'beside Tinuno Express', 'Smart', 'Gonzaga', '3135', '09384758245', 'juansmith@gmail.com', 'Leave at the front gate if no one answers.', 'Pending', 'GCash', '2025-05-22 02:28:02', '2025-05-22 02:28:02'),
(16, 2, 'Jane', 'Smith', 'Mabini Street, Hercy', 'beside Tinuno Express', 'Smart', 'Gonzaga', '3135', '09384758245', 'juansmith@gmail.com', 'Leave at the front gate if no one answers.', 'Pending', 'GCash', '2025-05-22 02:28:58', '2025-05-22 02:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 3, 175.00, '2025-05-18 19:01:12', '2025-05-18 19:01:12'),
(2, 2, 3, 8, 175.00, '2025-05-18 19:07:40', '2025-05-18 19:07:40'),
(3, 2, 8, 1, 136.00, '2025-05-18 19:07:40', '2025-05-18 19:07:40'),
(4, 3, 2, 2, 250.00, '2025-05-18 19:18:50', '2025-05-18 19:18:50'),
(5, 3, 5, 1, 171.00, '2025-05-18 19:18:50', '2025-05-18 19:18:50'),
(6, 3, 7, 2, 300.00, '2025-05-18 19:18:50', '2025-05-18 19:18:50'),
(7, 4, 15, 7, 500.00, '2025-05-20 06:13:23', '2025-05-20 06:13:23'),
(8, 5, 2, 5, 225.00, '2025-05-21 18:17:49', '2025-05-21 18:17:49'),
(9, 5, 8, 1, 136.00, '2025-05-21 18:17:49', '2025-05-21 18:17:49'),
(10, 6, 10, 1, 525.00, '2025-05-21 23:06:52', '2025-05-21 23:06:52'),
(11, 7, 15, 1, 500.00, '2025-05-21 23:27:07', '2025-05-21 23:27:07'),
(12, 8, 9, 3, 450.00, '2025-05-21 23:34:03', '2025-05-21 23:34:03'),
(13, 8, 10, 1, 525.00, '2025-05-21 23:34:03', '2025-05-21 23:34:03'),
(14, 9, 3, 5, 122.50, '2025-05-21 23:38:46', '2025-05-21 23:38:46'),
(15, 9, 15, 1, 500.00, '2025-05-21 23:38:46', '2025-05-21 23:38:46'),
(16, 10, 7, 1, 300.00, '2025-05-21 23:45:59', '2025-05-21 23:45:59'),
(17, 10, 12, 3, 210.00, '2025-05-21 23:45:59', '2025-05-21 23:45:59'),
(18, 11, 12, 1, 210.00, '2025-05-21 23:53:57', '2025-05-21 23:53:57'),
(19, 12, 8, 1, 136.00, '2025-05-22 00:14:39', '2025-05-22 00:14:39'),
(20, 13, 8, 1, 136.00, '2025-05-22 00:30:46', '2025-05-22 00:30:46'),
(21, 14, 3, 1, 122.50, '2025-05-22 00:45:13', '2025-05-22 00:45:13'),
(22, 15, 12, 4, 210.00, '2025-05-22 02:28:02', '2025-05-22 02:28:02'),
(23, 16, 12, 4, 210.00, '2025-05-22 02:28:58', '2025-05-22 02:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `english_name` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `english_name`, `tags`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`, `discount`) VALUES
(2, 4, 'Bangus', 'Milk Fish', 'Top Catch, Hot', 'This is an example of description for the product bangus', 250.00, 4, 'admin-assets/assets/images/products/1747660795_milkfish-after-harvested-pond-260nw-2104156253.jpg', '2025-05-17 01:19:11', '2025-05-19 05:54:12', 0.00),
(3, 4, 'Galunggong', 'Blue Mackerel Scad', 'Top Catch, Hot', 'Galunggong description', 175.00, 20, 'admin-assets/assets/images/products/1747473912_galungong.webp', '2025-05-17 01:25:12', '2025-05-19 15:31:31', 30.00),
(5, 1, 'Tilapia', 'Chichlid Fish', 'Best Seller, Hot', 'This is a description for tilapia', 190.00, 0, 'admin-assets/assets/images/products/1747474753_tilapia2.jpg', '2025-05-17 01:39:13', '2025-05-22 02:23:02', 30.00),
(7, 5, 'Kappi', 'Local Crab', 'Limited, Seasonal, Hot', 'This is a description for crab', 300.00, 3, 'admin-assets/assets/images/products/1747533461_crab.jpg', '2025-05-17 17:57:42', '2025-05-22 01:39:11', 15.00),
(8, 4, 'Tulingan', 'Mackarel Tuna', 'Best Seller', 'This is a long description for tulingan', 170.00, 14, 'admin-assets/assets/images/products/1747541243_Tulingan.webp', '2025-05-17 20:07:24', '2025-05-22 01:37:53', 20.00),
(9, 6, 'Daing na Dilis', 'Dried Anchoivies', 'Best Seller, Hot', 'This is a long description', 450.00, 10, 'admin-assets/assets/images/products/1747658914_dilis.jpg', '2025-05-19 04:48:34', '2025-05-19 05:53:08', 0.00),
(10, 6, 'Daing nga Pusit', 'Dried Sword Fish', 'Hot, Best Seller', 'Long description', 700.00, 4, 'admin-assets/assets/images/products/1747659146_pusit.webp', '2025-05-19 04:52:26', '2025-05-19 05:50:37', 25.00),
(11, 6, 'Daing nga Bulung Unas', 'Dried Sword Fish', 'Limited, Top Catch', 'Long description', 850.00, 18, 'admin-assets/assets/images/products/1747659251_swordfish.jpg', '2025-05-19 04:54:11', '2025-05-23 06:03:36', 0.00),
(12, 5, 'Tahong', 'Mussel', 'Top Catch, Seasonal', 'long long long', 210.00, 15, 'admin-assets/assets/images/products/1747660193_1747659935_tahong.jpg', '2025-05-19 05:05:35', '2025-05-19 05:09:53', 0.00),
(13, 1, 'Paltat', 'Cat/Mud Fish', 'Hot', 'long description for paltat', 150.00, 0, 'admin-assets/assets/images/products/1747660208_1747659992_catfish.jpg', '2025-05-19 05:06:32', '2025-05-22 07:08:27', 0.00),
(15, 4, 'Ludong', 'Lobed river mullet', 'Hot, Seasonal, Top Catch', 'Long description', 500.00, 10, 'admin-assets/assets/images/products/1747747964_LudongFish-2.jpg', '2025-05-20 05:32:45', '2025-05-20 06:16:48', 0.00),
(16, 6, 'Daing nga Armang', 'Dried Krill', 'Hot', 'alamang description', 200.00, 51, 'admin-assets/assets/images/products/1747906643_armang.jpg', '2025-05-22 01:37:24', '2025-05-22 02:22:31', 0.00);

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
('3UZoBmvo8JQrJHrICl2W3e2ksemwGbTnfP78iaTf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzhKQVdYOFF2TDV3aktob0pSSG1vOUZSSktYUGcwd1VQc0psdW1FNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1748008842),
('riiavqCnuidnEH2sdUd2n5zmrhsUu6WbTVJdzxG5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicFBrbUJwc1pRbWNxcnJzSzRIY1VUVzQ4aVFIVnRwUTBrNDhNNFFESyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1748009021);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_logs`
--

CREATE TABLE `transaction_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction_logs`
--

INSERT INTO `transaction_logs` (`id`, `date`, `description`, `created_at`, `updated_at`) VALUES
(1, '2025-05-22', 'New product added: <a href=\'javascript:void(0)\' class=\'text-success d-block fw-normal\'>Daing nga Armang</a>', '2025-05-22 01:37:24', '2025-05-22 01:37:24'),
(2, '2025-05-22', '3 stock was added to inventory for item <b>Tulingan</b>', '2025-05-22 01:37:53', '2025-05-22 01:37:53'),
(3, '2025-05-22', 'Discount updated for <b>Tilapia</b> to 20%', '2025-05-22 01:38:09', '2025-05-22 01:38:09'),
(4, '2025-05-22', 'Discount updated for <b>Tilapia</b> to 50%', '2025-05-22 01:38:35', '2025-05-22 01:38:35'),
(5, '2025-05-22', 'Discount updated for <b>Kappi</b> to 15%', '2025-05-22 01:39:11', '2025-05-22 01:39:11'),
(6, '2025-05-22', '18 stock was added to inventory for item <b>Daing nga Armang</b>', '2025-05-22 02:19:13', '2025-05-22 02:19:13'),
(7, '2025-05-22', '21 stock was added to inventory for item <b>Daing nga Armang</b>', '2025-05-22 02:22:31', '2025-05-22 02:22:31'),
(8, '2025-05-22', 'Discount updated for <b>Tilapia</b> to 30%', '2025-05-22 02:23:02', '2025-05-22 02:23:02'),
(9, '2025-05-22', 'Customer <b>Joseph Garcia</b> purchased 4kg of TAHONG.', '2025-05-22 02:28:58', '2025-05-22 02:28:58'),
(10, '2025-05-22', 'Product updated: <b class=\'text-success d-block\'>Paltat</b> (Cat/Mud Fish)', '2025-05-22 07:08:27', '2025-05-22 07:08:27'),
(11, '2025-05-23', 'New registered customer: <a href=\'javascript:void(0)\' class=\'text-success d-block fw-normal\'>Gorgonio Magalpok</a>', '2025-05-23 06:00:42', '2025-05-23 06:00:42'),
(12, '2025-05-23', '18 stock was added to inventory for item <b>Daing nga Bulung Unas</b>', '2025-05-23 06:03:36', '2025-05-23 06:03:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_details_customer_id_unique` (`customer_id`),
  ADD UNIQUE KEY `customer_details_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `transaction_logs`
--
ALTER TABLE `transaction_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD CONSTRAINT `customer_details_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
