-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2022 at 10:32 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `j2x_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `business`
--

CREATE TABLE `business` (
  `business_id` int(11) NOT NULL,
  `business_orient` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `business`
--

INSERT INTO `business` (`business_id`, `business_orient`) VALUES
(1, 'B2B'),
(2, 'B2C'),
(3, 'C2C'),
(4, 'O2O'),
(5, 'P2E'),
(6, 'Online intermediary'),
(7, 'Online marketplace'),
(8, 'SaaS'),
(9, 'Web 3.0'),
(10, 'Hardware'),
(11, 'Software'),
(12, 'Energy / mining / commodities'),
(13, 'Luxuries'),
(14, 'Manufacturing'),
(15, 'Real estate (asset related)'),
(16, 'Retail '),
(17, 'Services – Financial'),
(18, 'Services - IT'),
(19, 'Services – legal'),
(20, 'Services – accounting / consulting'),
(21, 'Services - others'),
(22, 'Telecommunication'),
(23, 'Transportation/ logistics / distribution'),
(24, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `buyorder`
--

CREATE TABLE `buyorder` (
  `buy_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `estsize` int(11) DEFAULT NULL,
  `pps` decimal(11,2) DEFAULT NULL,
  `valuation` int(11) DEFAULT NULL,
  `shareclass` varchar(30) DEFAULT NULL,
  `structure` varchar(30) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `category_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyorder`
--

INSERT INTO `buyorder` (`buy_id`, `user_id`, `company_id`, `estsize`, `pps`, `valuation`, `shareclass`, `structure`, `comments`, `status_id`, `category_id`) VALUES
(1, 2, 6, 23, '23.00', 25, 'Common', 'SPV', 'asddd', NULL, NULL),
(2, 2, 6, 12, '222.00', 12, 'Preferred', 'Direct Shares', 'Test', NULL, NULL),
(3, 2, 6, 9, '100.00', 9, 'Preferred', 'Direct Shares', 'jhjkjh', NULL, NULL),
(4, 1, 1, 89, '909.00', 9, 'Common', 'Forward', 'jhui', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `comp_name` varchar(60) DEFAULT NULL,
  `geog_id` int(11) DEFAULT NULL,
  `contact` varchar(40) DEFAULT NULL,
  `layer_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `estsize` int(11) DEFAULT NULL,
  `pricepershare` decimal(11,0) NOT NULL DEFAULT 0,
  `valuation` decimal(11,0) NOT NULL DEFAULT 0,
  `class_id` int(11) DEFAULT NULL,
  `structure_id` int(11) DEFAULT NULL,
  `feestruc` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `sector_id` varchar(100) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `background` text DEFAULT NULL,
  `deal_type` text DEFAULT NULL,
  `invest_stage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `comp_name`, `geog_id`, `contact`, `layer_id`, `category_id`, `estsize`, `pricepershare`, `valuation`, `class_id`, `structure_id`, `feestruc`, `comment`, `sector_id`, `business_id`, `background`, `deal_type`, `invest_stage`) VALUES
(1, 'Company 1', 7, 'John DOE', 1, 4, 200, '500', '100000', 2, 1, 'LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM ', 'LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM LOREM IPSUM', '13', 9, 'dsfsdf', 'test', 'Mid stage'),
(2, 'Test 2 Company', NULL, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, NULL, '3', NULL, NULL, NULL, NULL),
(3, 'jkjhkjk', NULL, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL),
(4, 'jhjh', 9, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, '1', '6', 1, 'jhjhjh', NULL, 'Early stage'),
(5, 'New C', 6, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, '8', 'Y', 18, 'sdasd', NULL, 'Mid stage'),
(6, 'NEW C1', 4, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, 'asdasd', '2', 4, NULL, 'sddfsdf', 'Mid stage'),
(7, 'company', 4, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, 'sadfasd', '2', 3, NULL, 'sdasd', 'Mid stage'),
(8, 'hhh', 5, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, 'sdfsdf', '3', 4, NULL, 'sdfdf', 'Mid stage'),
(9, 'jkjj', 1, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, 'jkjk', '2', 3, NULL, 'jkjk', 'Mid stage'),
(10, 'yuuyu', 1, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, 'jkjk', '1', 1, NULL, 'jkjk', 'Early stage'),
(11, 'jhh', 9, NULL, 0, NULL, NULL, '0', '0', NULL, NULL, NULL, 'jk', '33', 1, NULL, 'jk', 'Late stage');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `geogcover`
--

CREATE TABLE `geogcover` (
  `geog_id` int(11) NOT NULL,
  `geogarea` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `geogcover`
--

INSERT INTO `geogcover` (`geog_id`, `geogarea`) VALUES
(1, 'US'),
(2, 'Other North America'),
(3, 'Latin America'),
(4, 'UK'),
(5, 'EU block'),
(6, 'Other European'),
(7, 'China'),
(8, 'India'),
(9, 'Japan'),
(10, 'Korea'),
(11, 'SE Asia'),
(12, 'Other Asia'),
(13, 'Israel'),
(14, 'Other MENA');

-- --------------------------------------------------------

--
-- Table structure for table `holding`
--

CREATE TABLE `holding` (
  `holding_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `holding` int(11) DEFAULT 0,
  `pps` decimal(11,2) DEFAULT 0.00,
  `target` int(11) DEFAULT NULL,
  `shareclass` varchar(30) NOT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `holding`
--

INSERT INTO `holding` (`holding_id`, `company_id`, `user_id`, `holding`, `pps`, `target`, `shareclass`, `comments`) VALUES
(1, 1, 2, 9, '9.00', 9, 'Common', 'jkjk'),
(2, 4, 1, 9, '9.00', 9, 'Common', 'jhjhjh'),
(3, 1, 1, NULL, NULL, NULL, 'Common', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `layers`
--

CREATE TABLE `layers` (
  `layer_id` int(5) NOT NULL,
  `layername` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `layers`
--

INSERT INTO `layers` (`layer_id`, `layername`) VALUES
(1, 'DIRECT'),
(2, '1 LEVEL'),
(3, '2 LEVEL'),
(4, '3 LEVEL');

-- --------------------------------------------------------

--
-- Table structure for table `matching`
--

CREATE TABLE `matching` (
  `match_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `buy_id` int(11) NOT NULL,
  `sell_id` int(11) NOT NULL,
  `estsize` int(11) DEFAULT NULL,
  `pps` decimal(12,2) DEFAULT NULL,
  `pair_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matching`
--

INSERT INTO `matching` (`match_id`, `company_id`, `buy_id`, `sell_id`, `estsize`, `pps`, `pair_id`) VALUES
(1, 6, 3, 1, NULL, NULL, 4),
(2, 6, 2, 1, NULL, NULL, 5),
(3, 6, 2, 2, NULL, NULL, 5),
(5, 1, 4, 3, NULL, NULL, 11),
(6, 1, 4, 3, NULL, NULL, 12),
(7, 0, 1, 3, NULL, NULL, 13),
(8, 0, 3, 3, NULL, NULL, 13),
(9, 0, 3, 1, NULL, NULL, 15),
(10, 0, 3, 3, NULL, NULL, 15);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_09_09_174053_create_permission_tables', 2),
(6, '2022_09_09_180029_add_columns_to_users_table', 3),
(7, '2022_09_11_190654_create_pairs_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 2),
(6, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `pairs`
--

CREATE TABLE `pairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pairs`
--

INSERT INTO `pairs` (`id`, `comment`, `created_at`, `updated_at`) VALUES
(5, 'sdasds', '2022-09-12 09:36:10', '2022-09-12 09:36:10'),
(11, NULL, '2022-09-17 13:35:57', '2022-09-17 13:35:57'),
(12, NULL, '2022-09-17 13:36:23', '2022-09-17 13:36:23'),
(13, NULL, '2022-09-17 14:04:30', '2022-09-17 14:04:30'),
(15, 'klkl', '2022-09-17 14:07:43', '2022-09-17 14:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phpgen_users`
--

CREATE TABLE `phpgen_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `layer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `geog_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phpgen_users`
--

INSERT INTO `phpgen_users` (`user_id`, `user_name`, `user_password`, `layer_id`, `category_id`, `class_id`, `geog_id`) VALUES
(1, 'admin', 'f25ebb8dc508322e46c56a800fb10d1f', 1, 1, 1, 1),
(2, 'ekgrad', '38d3ee56881eacbf44e17d1e87636cfe', 2, 2, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(5, 'Admin', 'web', NULL, NULL),
(6, 'User', 'web', NULL, NULL),
(7, 'Company', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `sector_id` int(11) NOT NULL,
  `sectorname` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`sector_id`, `sectorname`) VALUES
(1, 'AI / machine learning'),
(2, 'Adtech / advertising / marketing'),
(3, 'Agtech'),
(4, 'Analytics / big data'),
(5, 'Biotech / bioscience'),
(6, 'Crypto / blockchain / NFT'),
(7, 'Climate/Sustainability/Clean/Carbon tech'),
(8, 'Cloudtech & DevOps'),
(9, 'Consumer software / application'),
(10, 'Consumer electronics'),
(11, 'Data management / storage'),
(12, 'Edutech'),
(13, 'E-commerce'),
(14, 'Enterprise software'),
(15, 'ESG'),
(16, 'Games / AR / VR / metaverse'),
(17, 'Fintech'),
(18, 'Foodtech'),
(19, 'Healthcare / healthtech'),
(20, 'Hosting / development'),
(21, 'Industrial application'),
(22, 'Information security / cybersecurity'),
(23, 'Insurtech'),
(24, 'IoT'),
(25, 'Media / entertainment'),
(26, 'Mobility / robotics / autonomous tech '),
(27, 'Proptech'),
(28, 'Retail tech'),
(29, 'Semiconductor'),
(30, 'Social media'),
(31, 'Space tech'),
(32, 'Supply chain tech'),
(33, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `sellorder`
--

CREATE TABLE `sellorder` (
  `sell_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `estsize` int(11) DEFAULT NULL,
  `pps` decimal(11,2) DEFAULT NULL,
  `valuation` int(11) DEFAULT NULL,
  `shareclass` varchar(30) DEFAULT NULL,
  `structure` varchar(30) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellorder`
--

INSERT INTO `sellorder` (`sell_id`, `user_id`, `company_id`, `estsize`, `pps`, `valuation`, `shareclass`, `structure`, `comments`, `status_id`, `category_id`) VALUES
(1, 2, NULL, 90, '120.00', 91, 'Ordinary', 'Direct Shares', 'uiuiui', NULL, NULL),
(2, 2, 6, 80, '70.00', 70, 'Preferred', 'Direct Shares', 'JOB', NULL, NULL),
(3, 1, 1, 8, '77.00', 60, 'Preferred', 'Direct Shares', 'Teest', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shareclass`
--

CREATE TABLE `shareclass` (
  `class_id` int(11) NOT NULL,
  `classname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shareclass`
--

INSERT INTO `shareclass` (`class_id`, `classname`) VALUES
(1, 'Common'),
(2, 'Preferred'),
(3, 'Ordinary');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `structure`
--

CREATE TABLE `structure` (
  `struct_id` int(11) NOT NULL,
  `structurename` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `structure`
--

INSERT INTO `structure` (`struct_id`, `structurename`) VALUES
(1, 'SPV'),
(2, 'Direct Shares'),
(3, 'Forward');

-- --------------------------------------------------------

--
-- Table structure for table `target`
--

CREATE TABLE `target` (
  `target_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `estsize` int(11) NOT NULL,
  `pps` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `target`
--

INSERT INTO `target` (`target_id`, `user_id`, `company_id`, `estsize`, `pps`) VALUES
(1, 1, 1, 89, '89.00');

-- --------------------------------------------------------

--
-- Table structure for table `usercategory`
--

CREATE TABLE `usercategory` (
  `category_id` int(11) NOT NULL,
  `categoryname` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usercategory`
--

INSERT INTO `usercategory` (`category_id`, `categoryname`) VALUES
(1, 'VC'),
(2, 'Broker'),
(3, 'PE Fund'),
(4, 'Accredited Individual');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comments` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `geog_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sector_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `comments`, `street_address`, `geog_id`, `sector_id`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, '$2y$10$I6nnfe9TrgwhnTBw76XKgOFsgL56T93pl4ACyC6YuugFvJFORScD6', NULL, '2022-09-09 13:28:51', '2022-09-09 13:28:51', NULL, NULL, NULL, NULL, NULL),
(2, 'test', 'test@gmail.vom', NULL, '$2y$10$Qb4vId1o/tlKNrG1RAwU7.Uy5gmqfl9rjUHE3f/9ACPM64ZiJOidG', NULL, '2022-09-09 13:31:46', '2022-09-09 14:07:58', '090980', 'jhjh', 'jhjh h4', 4, 3),
(3, 'Bilal', 'bilal@gmail.com', NULL, '$2y$10$wsPBDncrlZzGlax7xHY3SOmzVLyiVHCQddmzgqV45dxFC5kCRy2ya', NULL, '2022-09-12 12:40:58', '2022-09-12 12:40:58', '12389', 'jhjhjh', 'jhjhjh', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`business_id`);

--
-- Indexes for table `buyorder`
--
ALTER TABLE `buyorder`
  ADD PRIMARY KEY (`buy_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `geogcover`
--
ALTER TABLE `geogcover`
  ADD PRIMARY KEY (`geog_id`);

--
-- Indexes for table `holding`
--
ALTER TABLE `holding`
  ADD PRIMARY KEY (`holding_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `layers`
--
ALTER TABLE `layers`
  ADD PRIMARY KEY (`layer_id`);

--
-- Indexes for table `matching`
--
ALTER TABLE `matching`
  ADD PRIMARY KEY (`match_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `pairs`
--
ALTER TABLE `pairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `phpgen_users`
--
ALTER TABLE `phpgen_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`sector_id`);

--
-- Indexes for table `sellorder`
--
ALTER TABLE `sellorder`
  ADD PRIMARY KEY (`sell_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `shareclass`
--
ALTER TABLE `shareclass`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `structure`
--
ALTER TABLE `structure`
  ADD PRIMARY KEY (`struct_id`);

--
-- Indexes for table `target`
--
ALTER TABLE `target`
  ADD PRIMARY KEY (`target_id`);

--
-- Indexes for table `usercategory`
--
ALTER TABLE `usercategory`
  ADD PRIMARY KEY (`category_id`);

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
-- AUTO_INCREMENT for table `business`
--
ALTER TABLE `business`
  MODIFY `business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `buyorder`
--
ALTER TABLE `buyorder`
  MODIFY `buy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `geogcover`
--
ALTER TABLE `geogcover`
  MODIFY `geog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `holding`
--
ALTER TABLE `holding`
  MODIFY `holding_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `layers`
--
ALTER TABLE `layers`
  MODIFY `layer_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `matching`
--
ALTER TABLE `matching`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pairs`
--
ALTER TABLE `pairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phpgen_users`
--
ALTER TABLE `phpgen_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `sector_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sellorder`
--
ALTER TABLE `sellorder`
  MODIFY `sell_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shareclass`
--
ALTER TABLE `shareclass`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `structure`
--
ALTER TABLE `structure`
  MODIFY `struct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `target`
--
ALTER TABLE `target`
  MODIFY `target_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usercategory`
--
ALTER TABLE `usercategory`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

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
