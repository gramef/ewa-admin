-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2025 at 06:33 AM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rqkxbfmy_admin_panel`
--
CREATE DATABASE IF NOT EXISTS `rqkxbfmy_admin_panel` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `rqkxbfmy_admin_panel`;

DELIMITER $$
--
-- Functions
--
DROP FUNCTION IF EXISTS `json_extract`$$
$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double(20,17) NOT NULL DEFAULT '0.00000000000000000',
  `longitude` double(20,17) NOT NULL DEFAULT '0.00000000000000000',
  `default` tinyint(1) DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `description`, `address`, `latitude`, `longitude`, `default`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Office', '56948 Rodriguez Tunnel\nWest Vergieville, NJ 74212', 51.95860044000000000, 9.55953253000000000, 0, 6, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(2, 'Building', '752 Herzog Haven\nKaylinmouth, HI 04077-2737', 50.85916713000000000, 10.49750220000000000, 0, 1, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(4, 'Workshop', '5823 Roberta Ridges Suite 771\nNorth Calistad, RI 42624-4116', 50.04593958000000000, 9.99969477000000000, 0, 5, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(5, 'Building', '6752 Mills Shoal\nOswaldton, NH 68232-5369', 51.31574726000000000, 9.14018341000000000, 0, 5, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(6, 'Building', '7359 Beatrice Centers Apt. 441\nOberbrunnerchester, NV 16762', 50.26693875000000000, 10.74220272000000000, 0, 6, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(7, 'Home', '4187 Alexandro Garden\nDarwinstad, ME 12712', 50.37482190000000000, 11.92281027000000000, 0, 1, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(9, 'Work', '981 Treutel Island Suite 999\nReinatown, NC 65225-2133', 50.85360797000000000, 11.20221908000000000, 0, 1, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(10, 'Building', '6998 Cecilia Trail\nStantonfort, MI 47436', 51.08871608000000000, 11.34506410000000000, 0, 1, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(11, 'Home', '136 Stroman Parks\nNew Erica, DC 28699', 51.64000790000000000, 10.43839751000000000, 0, 2, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(12, 'Office', '30940 Enola Ridge\nMcGlynnton, CA 73789-5981', 51.45875596000000000, 11.87992415000000000, 0, 3, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(14, 'Office', '1574 Medhurst Court\nAlisabury, CT 16970', 50.70328392000000000, 11.67926847000000000, 0, 4, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(15, 'Work', '8472 Savanna Mountains\nSchusterfurt, CA 73468', 50.59727881000000000, 9.35654337000000000, 0, 4, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(16, 'Workshop', '7220 Gorczany Ports\nEast Lorna, TX 48771', 50.92960177000000000, 9.71451022000000000, 0, 4, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(17, 'Home', '9104 Bahringer Field Suite 472\nOlsonmouth, PA 36283', 51.15009177000000000, 11.88800534000000000, 0, 7, '2024-07-01 16:05:35', '2024-07-28 23:03:14'),
(18, 'Office', '72894 Claire Shoals\nSchowaltermouth, WY 21369-0691', 50.37883984000000000, 9.68793504000000000, 0, 6, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(19, 'Building', '295 Veda Drives Suite 083\nGulgowskimouth, ID 03583', 50.03473852000000000, 11.60825709000000000, 0, 4, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(20, 'Home', '6942 May Trail\nEast Raheemmouth, ME 84474-1431', 51.66911618000000000, 10.56582035000000000, 0, 3, '2024-07-01 16:05:35', '2024-07-01 16:05:35'),
(21, 'Concrete Beatty-Larkin\'s Address', 'London, UK', 51.50725800000000000, -0.12780100000000005, 0, 1, '2024-07-05 21:58:34', '2024-07-05 22:13:01'),
(22, 'Road A4, H', 'Road A4, House, 19b Forthright Rd, behind punch newspaper, Magboro-Akeran 121101, Ogun State, Nigeria', 6.70200460000000000, 3.39856270000000000, 0, 9, '2024-07-06 15:06:23', '2024-07-06 15:06:23'),
(23, 'Pall Mall, London, UK', 'Pall Mall, London, UK', 51.50651120000000000, -0.13427579999999995, 0, 1, '2024-07-09 02:01:47', '2024-07-09 02:01:47'),
(24, NULL, '6 Ladipo Kuku St, off Allen ave, Allen, Ikeja 101233, Lagos, Nigeria', 6.59917650000000000, 3.35254520000000000, 0, 11, '2024-07-09 04:24:42', '2024-07-09 04:24:42'),
(25, '50 Grosven', '50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK', 52.46135400000000000, -1.96793480000000000, 0, 10, '2024-07-09 14:29:21', '2024-07-09 14:29:21'),
(26, '213B Muri', '213B Muri Okunola St, Eti-Osa, Lagos 106104, Lagos, Nigeria', 6.43518000000000000, 3.43102100000000000, 0, 9, '2024-07-29 19:22:59', '2024-07-29 19:22:59'),
(27, '1199 Ritso', '1199 Ritson Rd N, Oshawa, ON L1G 8B9, Canada', 43.93246380000000000, -78.86600290000000000, 0, 13, '2024-08-01 06:28:52', '2024-08-01 06:28:52'),
(28, '1516 Trowb', '1516 Trowbridge Dr, Oshawa, ON L1G 7R7, Canada', 43.93200010000000000, -78.85944970000000000, 0, 13, '2024-08-01 06:34:32', '2024-08-01 06:34:32'),
(29, 'Home', '5795 Breanna Mall\nZiemannburgh, MS 98096-5011', 50.97770080000000000, 11.09057026000000000, 0, 8, '2024-08-01 21:06:55', '2024-08-01 21:06:55'),
(30, 'H59H+7JR R', 'H59H+7JR Romford, UK', 51.56823310000000000, 0.17903090000000000, 0, 15, '2024-08-03 04:57:37', '2024-08-03 04:57:37'),
(31, '1429 Maypo', '1429 Mayport Dr, Oshawa, ON L1J 8K4, Canada', 43.85628060000000000, -78.86095830000000000, 0, 13, '2024-08-03 10:16:09', '2024-08-03 10:16:09'),
(32, '48 Grosven', '48 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK', 52.46135400000000000, -1.96793480000000000, 0, 10, '2024-08-06 14:49:16', '2024-08-06 16:05:48'),
(33, 'Lagos, Nig', 'Lagos, Nigeria', 6.52437930000000000, 3.37920570000000000, 0, 9, '2024-08-06 17:05:04', '2024-08-06 17:05:04'),
(34, NULL, '46 Bramley Hill, South Croydon CR2 6NS', 51.36622000000000000, -0.10136000000000000, 0, 1, '2024-11-27 21:56:56', '2024-11-27 21:56:56'),
(35, NULL, '56 Waltho Street, Wolverhampton, UK', 52.59746300000000000, -2.14272000000000000, 0, 1, '2025-03-28 17:15:00', '2025-03-28 17:15:00'),
(36, NULL, 'Telford, UK', 52.67758730000000000, -2.46726110000000000, 0, 34, '2025-03-28 17:18:30', '2025-03-28 17:18:30'),
(37, '5 Wellingt', '5 Wellington Rd, Donnington, Telford TF2 8AB, UK', 52.71806120000000000, -2.44406340000000000, 0, 34, '2025-03-28 17:23:17', '2025-03-28 18:04:40'),
(38, NULL, '5 Wellington Rd, Donnington, Telford TF2 8AB, UK', 52.71806120000000000, -2.44406340000000000, 0, 34, '2025-03-28 17:23:17', '2025-03-28 17:23:17'),
(39, NULL, '16 Taiwo Ayinla St, Ikorodu, 104101, Lagos, Nigeria', 6.67044340000000000, 3.48375600000000000, 0, 57, '2025-04-03 23:41:23', '2025-04-03 23:41:23'),
(40, '4 Shobowal', '4 Shobowale St, Ikorodu, 104101, Lagos, Nigeria', 6.66810430000000000, 3.47687910000000000, 0, 56, '2025-04-04 19:28:14', '2025-04-04 19:28:14'),
(41, 'Isolo, Lag', 'Isolo, Lagos 102214, Lagos, Nigeria', 6.53552580000000000, 3.32663820000000000, 0, 56, '2025-04-04 19:43:55', '2025-04-04 19:43:55'),
(42, '8XC2+PJW,', '8XC2+PJW, Mosfla Road, Ibadan 110115, Oyo, Nigeria', 7.32185470000000000, 3.95157990000000000, 0, 120, '2025-05-28 03:47:00', '2025-05-30 11:53:15'),
(43, NULL, 'Pirbright, Woking GU24 0ND, UK', 51.28031500000000000, -0.64140000000000000, 0, 130, '2025-06-11 20:12:32', '2025-06-11 20:12:32'),
(44, NULL, '2MGX+3Q3, Joe Farrington Rd, Nassau, The Bahamas', 25.02507840000000000, -77.30063150000000000, 0, 144, '2025-06-29 17:21:59', '2025-06-29 17:21:59'),
(45, NULL, '4283 east mound street Columbus Ohio 43237', 39.94222350000000000, -82.88098690000000000, 0, 155, '2025-07-21 12:37:24', '2025-07-21 12:37:24');

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
CREATE TABLE `app_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`id`, `key`, `value`) VALUES
(7, 'date_format', 'l jS F Y (H:i:s)'),
(8, 'language', 'en'),
(17, 'is_human_date_format', '1'),
(18, 'app_name', 'EWA'),
(19, 'app_short_description', 'Unlock Your Afro Beauty, Any style, Anytime, Anywhere.'),
(20, 'mail_driver', 'smtp'),
(21, 'mail_host', 'smtp.gmail.com'),
(22, 'mail_port', '465'),
(23, 'mail_username', 'ewaofficialapp@gmail.com'),
(24, 'mail_password', 'txkk vlhk bgty lelo'),
(25, 'mail_encryption', 'ssl'),
(26, 'mail_from_address', 'ewaofficialapp@gmail.com'),
(27, 'mail_from_name', 'EWA'),
(30, 'timezone', 'Europe/London'),
(32, 'theme_contrast', 'light'),
(33, 'theme_color', 'olive'),
(34, 'app_logo', '8853bb7c-e1e7-4c90-aca9-92058f55dae3'),
(35, 'nav_color', 'navbar-light'),
(38, 'logo_bg_color', '0'),
(66, 'default_role', 'admin'),
(68, 'facebook_app_id', '518416208939727'),
(69, 'facebook_app_secret', '93649810f78fa9ca0d48972fee2a75cd'),
(71, 'twitter_app_id', 'twitter'),
(72, 'twitter_app_secret', 'twitter 1'),
(74, 'google_app_id', '527129559488-roolg8aq110p8r1q952fqa9tm06gbloe.apps.googleusercontent.com'),
(75, 'google_app_secret', 'FpIi8SLgc69ZWodk-xHaOrxn'),
(77, 'enable_google', '0'),
(78, 'enable_facebook', '0'),
(93, 'enable_stripe', '1'),
(94, 'stripe_key', 'pk_live_51PcN9oRssJXysaDJAl75MKrQ41NFkOTIBhRRrbDRubkOKoyTm6MGL1zugQGaHBkh3lq2rE2lPH9RZwERErZMrIO100sshAbPgi'),
(95, 'stripe_secret', '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'),
(101, 'custom_field_models.0', 'App\\Models\\User'),
(104, 'default_tax', '10'),
(107, 'default_currency', '£'),
(108, 'fixed_header', '1'),
(109, 'fixed_footer', '0'),
(110, 'fcm_key', 'AAAAHMZiAQA:APA91bEb71b5sN5jl-w_mmt6vLfgGY5-_CQFxMQsVEfcwO3FAh4-mk1dM6siZwwR3Ls9U0pRDpm96WN1AmrMHQ906GxljILqgU2ZB6Y1TjiLyAiIUETpu7pQFyicER8KLvM9JUiXcfWK'),
(111, 'enable_notifications', '0'),
(112, 'paypal_username', 'sb-z3gdq482047_api1.business.example.com'),
(113, 'paypal_password', '-'),
(114, 'paypal_secret', '-'),
(115, 'enable_paypal', '0'),
(116, 'main_color', '#3B8062'),
(117, 'main_dark_color', '#DDBC46'),
(118, 'second_color', '#08143A'),
(119, 'second_dark_color', '#CCCCDD'),
(120, 'accent_color', '#8C9DA8'),
(121, 'accent_dark_color', '#9999AA'),
(122, 'scaffold_dark_color', '#2C2C2C'),
(123, 'scaffold_color', '#FAFAFA'),
(124, 'google_maps_key', 'AIzaSyD6DcUzmmYlODaH-cdC4A5SZJAV_M6Gei0'),
(125, 'mobile_language', 'en'),
(126, 'app_version', '1.0.0'),
(127, 'enable_version', '1'),
(128, 'default_currency_id', '7'),
(129, 'default_currency_code', 'GBP'),
(130, 'default_currency_decimal_digits', '2'),
(131, 'default_currency_rounding', '2'),
(132, 'currency_right', '0'),
(133, 'distance_unit', 'mi'),
(134, 'default_theme', 'light'),
(135, 'enable_paystack', '0'),
(136, 'paystack_key', 'pk_test_d754715fa3fa9048c9ab2832c440fb183d7c91f5'),
(137, 'paystack_secret', 'sk_test_66f87edaac94f8adcb28fdf7452f12ccc63d068d'),
(138, 'enable_flutterwave', '0'),
(139, 'flutterwave_key', 'FLWPUBK_TEST-d465ba7e4f6b86325cb9881835726402-X'),
(140, 'flutterwave_secret', 'FLWSECK_TEST-d3f8801da31fc093fb1207ea34e68fbb-X'),
(141, 'enable_stripe_fpx', '1'),
(142, 'stripe_fpx_key', 'pk_test_51IQ0zvB0wbAJesyPLo3x4LRgOjM65IkoO5hZLHOMsnO2RaF0NlH7HNOfpCkjuLSohvdAp30U5P1wKeH98KnwXkOD00mMDavaFX'),
(143, 'stripe_fpx_secret', 'sk_test_51IQ0zvB0wbAJesyPUtR7yGdyOR7aGbMQAX5Es9P56EDUEsvEQAC0NBj7JPqFuJEYXrvSCm5OPRmGaUQBswjkRxVB00mz8xhkFX'),
(144, 'enable_paymongo', '1'),
(145, 'paymongo_key', 'pk_test_iD6aYYm4yFuvkuisyU2PGSYH'),
(146, 'paymongo_secret', 'sk_test_oxD79bMKxb8sA47ZNyYPXwf3'),
(147, 'provider_app_name', 'EWA'),
(148, 'default_country_code', 'GB'),
(149, 'enable_otp', '0'),
(150, 'firebase_api_key', 'AIzaSyB2fO656sH4lNBLxjFbp03ZzDI-8eMsn0I'),
(151, 'firebase_auth_domain', 'ewa-hair.firebaseapp.com'),
(152, 'firebase_database_url', '0'),
(153, 'firebase_project_id', 'ewa-hair'),
(154, 'firebase_storage_bucket', 'ewa-hair.appspot.com'),
(155, 'firebase_messaging_sender_id', '15260961460'),
(156, 'firebase_app_id', '1:15260961460:web:fa5bbcacfadfab57e925e1'),
(157, 'firebase_measurement_id', 'G-9R5E2BW01L'),
(158, 'enable_email_notifications', '1'),
(159, 'paypal_mode', '0'),
(160, 'paypal_app_id', ''),
(161, 'enable_cash', '1'),
(162, 'enable_wallet', '0'),
(163, 'enable_twitter', '0'),
(164, 'firebase_credentials', '/tmp/phpf7QmYz');

-- --------------------------------------------------------

--
-- Table structure for table `availability_hours`
--

DROP TABLE IF EXISTS `availability_hours`;
CREATE TABLE `availability_hours` (
  `id` int(10) UNSIGNED NOT NULL,
  `day` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monday',
  `start_at` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_at` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci,
  `e_provider_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `availability_hours`
--

INSERT INTO `availability_hours` (`id`, `day`, `start_at`, `end_at`, `data`, `e_provider_id`) VALUES
(7, 'tuesday', '10:00', '15:00', '{\"en\":\"Et quasi ipsum aut autem.\"}', 4),
(9, 'friday', '09:00', '17:00', '{\"en\":\"Cumque et aut vel doloremque.\"}', 14),
(10, 'tuesday', '03:00', '17:00', '{\"en\":\"Animi nulla tempora cupiditate ea.\"}', 5),
(11, 'saturday', '08:00', '23:00', '{\"en\":\"Quasi occaecati soluta exercitationem occaecati.\"}', 4),
(12, 'friday', '11:00', '18:00', '{\"en\":\"Nihil ea ipsa aliquam consequatur qui.\"}', 9),
(13, 'tuesday', '02:00', '20:00', '{\"en\":\"Dolores maxime amet aspernatur.\"}', 11),
(14, 'monday', '12:00', '21:00', '{\"en\":\"Saepe omnis fugiat labore dolorum iure libero.\"}', 12),
(16, 'saturday', '11:00', '22:00', '{\"en\":\"Tenetur in velit officia et sunt qui.\"}', 3),
(17, 'friday', '04:00', '13:00', '{\"en\":\"Ea illo repudiandae in optio.\"}', 7),
(20, 'monday', '08:00', '22:00', '{\"en\":\"Maxime fuga deleniti iure quod eum.\"}', 18),
(24, 'sunday', '11:00', '20:00', '{\"en\":\"Quas quis id nemo quas.\"}', 10),
(27, 'friday', '10:00', '18:00', '{\"en\":\"Et quae vel eum numquam.\"}', 7),
(28, 'saturday', '04:00', '13:00', '{\"en\":\"Doloremque in inventore aut dolor.\"}', 17),
(29, 'saturday', '10:00', '14:00', '{\"en\":\"Sequi dolorem sunt et ex perferendis.\"}', 4),
(31, 'thursday', '11:00', '18:00', '{\"en\":\"Et aliquam id maiores ipsa a enim molestias.\"}', 4),
(33, 'saturday', '03:00', '22:00', '{\"en\":\"Ut qui consectetur rerum quos.\"}', 16),
(34, 'saturday', '07:00', '14:00', '{\"en\":\"Ab nesciunt et id vitae doloribus omnis.\"}', 5),
(35, 'saturday', '07:00', '15:00', '{\"en\":\"Porro et consequuntur molestiae omnis.\"}', 4),
(36, 'wednesday', '12:00', '13:00', '{\"en\":\"Quis sit placeat aperiam et quae odio.\"}', 5),
(37, 'thursday', '05:00', '20:00', '{\"en\":\"Quos corporis distinctio cum.\"}', 3),
(39, 'saturday', '08:00', '20:00', '{\"en\":\"Enim quis ad quo voluptatum id.\"}', 7),
(42, 'monday', '06:00', '17:00', '{\"en\":\"Veritatis minima non consectetur pariatur qui.\"}', 5),
(43, 'friday', '09:00', '15:00', '{\"en\":\"Et et voluptas est quia odit ut voluptatem.\"}', 7),
(45, 'sunday', '08:00', '17:00', '{\"en\":\"Aut a aut sint recusandae molestiae.\"}', 12),
(46, 'monday', '08:00', '23:00', '{\"en\":\"Quo ex ea nihil et molestiae.\"}', 6),
(48, 'wednesday', '02:00', '14:00', '{\"en\":\"Voluptas dolorum quia ipsum quo nesciunt aut.\"}', 10),
(49, 'wednesday', '11:00', '15:00', '{\"en\":\"Voluptate explicabo voluptates omnis soluta enim.\"}', 16),
(52, 'tuesday', '10:30', '22:30', '{\"en\":null}', 2),
(53, 'monday', '07:00', '23:59', '{\"en\":null}', 2),
(55, 'monday', '08:00', '21:00', '{\"en\":null}', 1),
(56, 'tuesday', '08:00', '21:25', '{\"en\":null}', 1),
(57, 'wednesday', '07:00', '21:26', '{\"en\":null}', 1),
(58, 'wednesday', '11:24', '15:24', '{\"en\":null}', 6),
(59, 'monday', '09:00', '18:00', '{\"en\":\"sbbsbsbsbsbdbdb\"}', 8),
(61, 'tuesday', '09:00', '18:00', '{\"en\":\"sbbsbsbsbsbdbdb\"}', 8),
(63, 'wednesday', '09:00', '18:00', '{\"en\":\"sbbsbsbsbsbdbdb\"}', 8),
(64, 'thursday', '09:00', '18:00', '{\"en\":\"sbbsbsbsbsbdbdb\"}', 8),
(65, 'friday', '09:00', '18:00', '{\"en\":\"sbbsbsbsbsbdbdb\"}', 8);

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

DROP TABLE IF EXISTS `awards`;
CREATE TABLE `awards` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `e_provider` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `e_service` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` longtext COLLATE utf8mb4_unicode_ci,
  `quantity` smallint(6) DEFAULT '1',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_status_id` int(10) UNSIGNED DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(10) UNSIGNED DEFAULT NULL,
  `coupon` longtext COLLATE utf8mb4_unicode_ci,
  `taxes` longtext COLLATE utf8mb4_unicode_ci,
  `booking_at` datetime DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `hint` text COLLATE utf8mb4_unicode_ci,
  `cancel` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `e_provider`, `e_service`, `options`, `quantity`, `user_id`, `booking_status_id`, `address`, `payment_id`, `coupon`, `taxes`, `booking_at`, `start_at`, `ends_at`, `hint`, `cancel`, `created_at`, `updated_at`) VALUES
(5, '{\"id\":2,\"name\":\"Lawal hair salon\",\"phone_number\":\"+19172849645\",\"mobile_number\":\"+44\"}', '{\"id\":41,\"name\":\"cornrows services\",\"price\":50,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":null,\"enable_booking\":true}', NULL, 1, 9, 6, '{\"id\":22,\"description\":\"Road A4, H\",\"address\":\"Road A4, House, 19b Forthright Rd, behind punch newspaper, Magboro-Akeran 121101, Ogun State, Nigeria\",\"latitude\":6.7020046000000004227104000165127217769622802734375,\"longitude\":3.398562699999999825450913704116828739643096923828125}', 1, NULL, '[]', '2024-07-08 22:52:00', '2024-07-08 23:04:00', '2024-07-08 23:04:00', NULL, 0, '2024-07-09 04:53:17', '2024-07-10 21:58:59'),
(7, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"386.680.3907\",\"mobile_number\":\"+1 (440) 494-0259\"}', '{\"id\":40,\"name\":\"cornrows\",\"price\":44.42999999999999971578290569595992565155029296875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 10, 6, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', 2, NULL, '[]', '2024-07-09 08:38:58', '2024-07-09 09:46:26', '2024-07-09 09:46:31', NULL, 0, '2024-07-09 14:39:13', '2024-07-09 15:47:31'),
(9, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"386.680.3907\",\"mobile_number\":\"+1 (440) 494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 1, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-07-10 11:56:48', NULL, NULL, NULL, 0, '2024-07-10 17:56:58', '2024-07-10 17:56:58'),
(10, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 9, 6, '{\"id\":22,\"description\":\"Road A4, H\",\"address\":\"Road A4, House, 19b Forthright Rd, behind punch newspaper, Magboro-Akeran 121101, Ogun State, Nigeria\",\"latitude\":6.7020046000000004227104000165127217769622802734375,\"longitude\":3.398562699999999825450913704116828739643096923828125}', NULL, NULL, '[]', '2024-07-14 15:25:27', '2024-07-14 15:29:45', '2024-07-14 15:31:49', NULL, 0, '2024-07-14 21:25:39', '2024-07-14 21:31:50'),
(11, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":40,\"name\":\"cornrows\",\"price\":44.42999999999999971578290569595992565155029296875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":22,\"description\":\"Road A4, H\",\"address\":\"Road A4, House, 19b Forthright Rd, behind punch newspaper, Magboro-Akeran 121101, Ogun State, Nigeria\",\"latitude\":6.7020046000000004227104000165127217769622802734375,\"longitude\":3.398562699999999825450913704116828739643096923828125}', NULL, NULL, '[]', '2024-07-14 19:31:30', NULL, NULL, NULL, 0, '2024-07-15 01:31:38', '2024-11-27 22:45:31'),
(12, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 10, 6, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-07-22 13:33:38', '2024-07-22 13:42:32', '2024-07-22 13:42:41', NULL, 0, '2024-07-22 19:33:50', '2024-07-22 19:42:42'),
(13, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 6, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-07-23 08:24:22', '2024-07-23 08:28:57', '2024-07-23 08:29:00', NULL, 0, '2024-07-23 14:24:37', '2024-07-23 14:29:02'),
(14, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":17,\"description\":\"Home\",\"address\":\"9104 Bahringer Field Suite 472\\nOlsonmouth, PA 36283\",\"latitude\":51.1500917700000030663431971333920955657958984375,\"longitude\":11.88800533999999942125214147381484508514404296875}', 6, NULL, '[]', '2024-07-23 10:14:00', '2024-07-23 10:30:00', '2024-07-23 11:00:00', NULL, 0, '2024-07-23 17:14:18', '2024-07-31 20:44:23'),
(15, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 6, '{\"id\":17,\"description\":\"Home\",\"address\":\"9104 Bahringer Field Suite 472\\nOlsonmouth, PA 36283\",\"latitude\":51.1500917700000030663431971333920955657958984375,\"longitude\":11.88800533999999942125214147381484508514404296875}', 5, NULL, '[]', '2024-07-28 17:02:00', '2024-07-30 17:15:32', '2024-07-30 17:15:39', NULL, 0, '2024-07-28 23:03:14', '2024-07-30 23:15:39'),
(16, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 6, '{\"id\":17,\"description\":\"Home\",\"address\":\"9104 Bahringer Field Suite 472\\nOlsonmouth, PA 36283\",\"latitude\":51.1500917700000030663431971333920955657958984375,\"longitude\":11.88800533999999942125214147381484508514404296875}', 15, NULL, '[]', '2024-07-28 17:02:00', '2024-07-30 16:51:42', '2024-07-30 16:51:58', NULL, 0, '2024-07-28 23:07:24', '2024-08-01 20:02:57'),
(17, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 10, 3, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-07-29 12:47:56', NULL, NULL, NULL, 0, '2024-07-29 18:48:13', '2024-07-29 18:53:28'),
(18, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":26,\"description\":\"213B Muri\",\"address\":\"213B Muri Okunola St, Eti-Osa, Lagos 106104, Lagos, Nigeria\",\"latitude\":6.43517999999999990023979989928193390369415283203125,\"longitude\":3.431020999999999876450829106033779680728912353515625}', NULL, NULL, '[]', '2024-07-29 13:22:14', NULL, NULL, NULL, 0, '2024-07-29 19:22:59', '2024-11-27 22:22:00'),
(19, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-07-29 14:06:23', NULL, NULL, NULL, 0, '2024-07-29 20:06:50', '2024-11-26 12:33:31'),
(20, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":26,\"description\":\"213B Muri\",\"address\":\"213B Muri Okunola St, Eti-Osa, Lagos 106104, Lagos, Nigeria\",\"latitude\":6.43517999999999990023979989928193390369415283203125,\"longitude\":3.431020999999999876450829106033779680728912353515625}', NULL, NULL, '[]', '2024-07-31 07:33:15', NULL, NULL, NULL, 0, '2024-07-31 13:33:23', '2024-07-31 13:33:56'),
(21, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-07-31 08:33:10', NULL, NULL, NULL, 0, '2024-07-31 14:33:17', '2024-07-31 14:34:16'),
(22, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":13,\"description\":\"Home\",\"address\":\"5795 Breanna Mall\\nZiemannburgh, MS 98096-5011\",\"latitude\":50.97770080000000092468326329253613948822021484375,\"longitude\":11.09057025999999979148924467153847217559814453125}', 8, NULL, '[]', '2024-07-31 14:48:00', NULL, NULL, NULL, 0, '2024-07-31 20:48:59', '2024-07-31 20:57:54'),
(23, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-07-31 16:57:21', NULL, NULL, NULL, 0, '2024-07-31 22:57:28', '2024-07-31 22:58:24'),
(24, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 9, 6, '{\"id\":26,\"description\":\"213B Muri\",\"address\":\"213B Muri Okunola St, Eti-Osa, Lagos 106104, Lagos, Nigeria\",\"latitude\":6.43517999999999990023979989928193390369415283203125,\"longitude\":3.431020999999999876450829106033779680728912353515625}', 9, NULL, '[]', '2024-07-31 17:29:25', '2024-07-31 17:33:45', '2024-07-31 17:33:56', NULL, 0, '2024-07-31 23:29:39', '2024-07-31 23:33:58'),
(25, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 13, 4, '{\"id\":27,\"description\":\"1199 Ritso\",\"address\":\"1199 Ritson Rd N, Oshawa, ON L1G 8B9, Canada\",\"latitude\":43.9324638000000078363882494159042835235595703125,\"longitude\":-78.8660028999999980214852257631719112396240234375}', NULL, NULL, '[]', '2024-08-01 00:28:26', NULL, NULL, NULL, 0, '2024-08-01 06:28:52', '2024-08-01 06:29:20'),
(26, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 13, 4, '{\"id\":28,\"description\":\"1516 Trowb\",\"address\":\"1516 Trowbridge Dr, Oshawa, ON L1G 7R7, Canada\",\"latitude\":43.93200010000000332865965901874005794525146484375,\"longitude\":-78.859449699999998983912519179284572601318359375}', NULL, NULL, '[]', '2024-08-01 00:34:05', NULL, NULL, NULL, 0, '2024-08-01 06:34:32', '2024-08-01 06:35:34'),
(27, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":13,\"description\":\"Home\",\"address\":\"5795 Breanna Mall\\nZiemannburgh, MS 98096-5011\",\"latitude\":50.97770080000000092468326329253613948822021484375,\"longitude\":11.09057025999999979148924467153847217559814453125}', 10, NULL, '[]', '2024-08-01 01:11:00', NULL, NULL, NULL, 0, '2024-08-01 07:11:28', '2024-08-01 07:16:12'),
(28, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":29,\"description\":\"Home\",\"address\":\"5795 Breanna Mall\\nZiemannburgh, MS 98096-5011\",\"latitude\":50.97770080000000092468326329253613948822021484375,\"longitude\":11.09057025999999979148924467153847217559814453125}', 21, NULL, '[]', '2024-08-01 15:06:00', NULL, NULL, NULL, 0, '2024-08-01 21:06:55', '2024-08-03 07:22:53'),
(29, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":29,\"description\":\"Home\",\"address\":\"5795 Breanna Mall\\nZiemannburgh, MS 98096-5011\",\"latitude\":50.97770080000000092468326329253613948822021484375,\"longitude\":11.09057025999999979148924467153847217559814453125}', 29, NULL, '[]', '2024-08-01 15:16:00', NULL, NULL, NULL, 0, '2024-08-01 21:17:04', '2024-08-12 03:18:44'),
(30, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 13, 4, '{\"id\":28,\"description\":\"1516 Trowb\",\"address\":\"1516 Trowbridge Dr, Oshawa, ON L1G 7R7, Canada\",\"latitude\":43.93200010000000332865965901874005794525146484375,\"longitude\":-78.859449699999998983912519179284572601318359375}', NULL, NULL, '[]', '2024-08-01 19:46:01', NULL, NULL, NULL, 0, '2024-08-02 01:46:06', '2024-08-02 02:03:56'),
(31, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 13, 4, '{\"id\":28,\"description\":\"1516 Trowb\",\"address\":\"1516 Trowbridge Dr, Oshawa, ON L1G 7R7, Canada\",\"latitude\":43.93200010000000332865965901874005794525146484375,\"longitude\":-78.859449699999998983912519179284572601318359375}', NULL, NULL, '[]', '2024-08-02 15:49:13', NULL, NULL, NULL, 0, '2024-08-02 21:49:19', '2024-08-02 21:51:00'),
(32, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 15, 4, '{\"id\":30,\"description\":\"H59H+7JR R\",\"address\":\"H59H+7JR Romford, UK\",\"latitude\":51.5682331000000004905814421363174915313720703125,\"longitude\":0.17903089999999999282209728335146792232990264892578125}', 16, NULL, '[]', '2024-08-02 22:57:31', NULL, NULL, NULL, 0, '2024-08-03 04:57:37', '2024-08-03 05:13:40'),
(33, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":29,\"description\":\"Home\",\"address\":\"5795 Breanna Mall\\nZiemannburgh, MS 98096-5011\",\"latitude\":50.97770080000000092468326329253613948822021484375,\"longitude\":11.09057025999999979148924467153847217559814453125}', 27, NULL, '[]', '2024-08-03 01:24:00', NULL, NULL, NULL, 0, '2024-08-03 07:24:53', '2024-08-10 23:35:32'),
(34, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":42,\"name\":\"razor hair style\",\"price\":2,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":null,\"enable_booking\":true}', NULL, 1, 13, 3, '{\"id\":31,\"description\":\"1429 Maypo\",\"address\":\"1429 Mayport Dr, Oshawa, ON L1J 8K4, Canada\",\"latitude\":43.85628059999999805995685164816677570343017578125,\"longitude\":-78.860958299999992959783412516117095947265625}', 23, NULL, '[]', '2024-08-03 04:15:51', NULL, NULL, NULL, 0, '2024-08-03 10:16:09', '2024-08-04 00:16:55'),
(35, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-08-03 16:51:50', NULL, NULL, NULL, 0, '2024-08-03 22:52:05', '2024-11-24 21:48:57'),
(36, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":25,\"description\":\"50 Grosven\",\"address\":\"50 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-08-03 17:02:54', NULL, NULL, NULL, 0, '2024-08-03 23:02:59', '2024-11-25 07:21:01'),
(37, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":32,\"description\":\"48 Grosven\",\"address\":\"48 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-08-06 08:47:48', NULL, NULL, NULL, 0, '2024-08-06 14:49:16', '2024-08-06 14:52:46'),
(38, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 16, 4, '{\"id\":32,\"description\":\"48 Grosven\",\"address\":\"48 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461312399999997069244273006916046142578125,\"longitude\":-1.967931899999999956207830109633505344390869140625}', NULL, NULL, '[]', '2024-08-06 09:15:36', NULL, NULL, NULL, 0, '2024-08-06 15:16:35', '2024-08-06 15:20:02'),
(39, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":32,\"description\":\"48 Grosven\",\"address\":\"48 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-08-06 10:05:42', NULL, NULL, NULL, 0, '2024-08-06 16:05:48', '2024-08-06 16:06:20'),
(40, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":32,\"description\":\"48 Grosven\",\"address\":\"48 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', NULL, NULL, '[]', '2024-08-06 10:07:26', NULL, NULL, NULL, 0, '2024-08-06 16:07:29', '2024-08-06 16:08:00'),
(41, '{\"id\":2,\"name\":\"Lawal hair salon\",\"phone_number\":\"+19172849645\",\"mobile_number\":\"+44\"}', '{\"id\":41,\"name\":\"cornrows services\",\"price\":2,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":null,\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":33,\"description\":\"Lagos, Nig\",\"address\":\"Lagos, Nigeria\",\"latitude\":6.52437929999999965957613312639296054840087890625,\"longitude\":3.37920569999999997889972291886806488037109375}', NULL, NULL, '[]', '2024-08-06 11:04:58', NULL, NULL, NULL, 0, '2024-08-06 17:05:04', '2024-08-06 17:05:25'),
(42, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":32,\"description\":\"48 Grosven\",\"address\":\"48 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', 25, NULL, '[]', '2024-08-06 11:31:59', NULL, NULL, NULL, 0, '2024-08-06 17:32:44', '2024-08-06 21:48:38'),
(43, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":42,\"name\":\"razor hair style\",\"price\":2,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":null,\"enable_booking\":true}', NULL, 1, 10, 4, '{\"id\":32,\"description\":\"48 Grosven\",\"address\":\"48 Grosvenor Rd, Harborne, Birmingham B17 9AN, UK\",\"latitude\":52.461354000000000041836756281554698944091796875,\"longitude\":-1.9679348000000000951104084379039704799652099609375}', 24, NULL, '[]', '2024-08-06 11:55:34', NULL, NULL, NULL, 0, '2024-08-06 17:55:37', '2024-08-06 18:07:04'),
(44, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":29,\"description\":\"Home\",\"address\":\"5795 Breanna Mall\\nZiemannburgh, MS 98096-5011\",\"latitude\":50.97770080000000092468326329253613948822021484375,\"longitude\":11.09057025999999979148924467153847217559814453125}', 28, NULL, '[]', '2024-08-10 17:37:00', NULL, NULL, NULL, 0, '2024-08-10 23:37:41', '2024-08-10 23:39:11'),
(45, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 8, 4, '{\"id\":29,\"description\":\"Home\",\"address\":\"5795 Breanna Mall\\nZiemannburgh, MS 98096-5011\",\"latitude\":50.97770080000000092468326329253613948822021484375,\"longitude\":11.09057025999999979148924467153847217559814453125}', 30, NULL, '[]', '2024-08-11 20:07:00', NULL, NULL, NULL, 0, '2024-08-12 02:07:47', '2024-08-12 02:08:40'),
(46, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 9, 6, '{\"id\":33,\"description\":\"Lagos, Nig\",\"address\":\"Lagos, Nigeria\",\"latitude\":6.52437929999999965957613312639296054840087890625,\"longitude\":3.37920569999999997889972291886806488037109375}', 31, NULL, '[]', '2024-08-22 16:19:27', '2024-08-22 16:46:02', '2024-08-22 16:49:53', NULL, 0, '2024-08-22 22:30:40', '2024-08-22 22:49:54'),
(47, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":33,\"description\":\"Lagos, Nig\",\"address\":\"Lagos, Nigeria\",\"latitude\":6.52437929999999965957613312639296054840087890625,\"longitude\":3.37920569999999997889972291886806488037109375}', NULL, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2024-09-19 14:16:00', NULL, NULL, NULL, 0, '2024-08-29 16:18:13', '2024-08-29 16:19:22'),
(48, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":33,\"description\":\"Lagos, Nig\",\"address\":\"Lagos, Nigeria\",\"latitude\":6.52437929999999965957613312639296054840087890625,\"longitude\":3.37920569999999997889972291886806488037109375}', NULL, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2024-08-29 10:24:57', NULL, NULL, NULL, 0, '2024-08-29 16:25:09', '2024-08-29 16:25:32'),
(49, '{\"id\":2,\"name\":\"Lawal hair salon\",\"phone_number\":\"+19172849645\",\"mobile_number\":\"+44\"}', '{\"id\":41,\"name\":\"cornrows services\",\"price\":2,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":null,\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":33,\"description\":\"Lagos, Nig\",\"address\":\"Lagos, Nigeria\",\"latitude\":6.52437929999999965957613312639296054840087890625,\"longitude\":3.37920569999999997889972291886806488037109375}', 33, NULL, '[]', '2024-08-29 10:27:14', NULL, NULL, NULL, 0, '2024-08-29 16:27:20', '2024-08-29 16:40:54'),
(50, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 3, 4, '{\"id\":20,\"description\":\"Home\",\"address\":\"6942 May Trail\\nEast Raheemmouth, ME 84474-1431\",\"latitude\":51.66911618000000316897057928144931793212890625,\"longitude\":10.565820349999999194778865785337984561920166015625}', NULL, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2024-10-18 11:49:00', NULL, NULL, NULL, 0, '2024-10-10 13:50:03', '2024-11-24 21:47:27'),
(51, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":51,\"name\":\"Knotles boho\",\"price\":250,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"03\",\"enable_booking\":true}', NULL, 1, 9, 4, '{\"id\":33,\"description\":\"Lagos, Nig\",\"address\":\"Lagos, Nigeria\",\"latitude\":6.52437929999999965957613312639296054840087890625,\"longitude\":3.37920569999999997889972291886806488037109375}', NULL, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2025-03-26 08:30:15', NULL, NULL, NULL, 0, '2025-03-26 14:30:45', '2025-03-26 14:32:28'),
(52, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":1,\"name\":\"Hair Twisting\",\"price\":35.9200000000000017053025658242404460906982421875,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"05:00\",\"enable_booking\":true}', NULL, 1, 34, 1, '{\"id\":37,\"description\":\"5 Wellingt\",\"address\":\"5 Wellington Rd, Donnington, Telford TF2 8AB, UK\",\"latitude\":52.71806120000000106529114418663084506988525390625,\"longitude\":-2.44406340000000010803660188685171306133270263671875}', NULL, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2025-03-28 12:04:13', NULL, NULL, NULL, 0, '2025-03-28 18:04:40', '2025-03-28 18:04:40'),
(53, '{\"id\":7,\"name\":\"First Seller\",\"phone_number\":\"+4470835545000\",\"mobile_number\":\"+445427075422\"}', '{\"id\":53,\"name\":\"Suku\",\"price\":200,\"discount_price\":150,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"2:30\",\"enable_booking\":true}', NULL, 1, 56, 5, '{\"id\":40,\"description\":\"4 Shobowal\",\"address\":\"4 Shobowale St, Ikorodu, 104101, Lagos, Nigeria\",\"latitude\":6.66810430000000042838337321882136166095733642578125,\"longitude\":3.476879100000000111236886368715204298496246337890625}', 34, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2025-04-04 13:26:00', NULL, NULL, 'nothing else', 0, '2025-04-04 19:28:14', '2025-04-04 20:12:54'),
(54, '{\"id\":7,\"name\":\"First Seller\",\"phone_number\":\"+4470835545000\",\"mobile_number\":\"+445427075422\"}', '{\"id\":53,\"name\":\"Suku\",\"price\":200,\"discount_price\":150,\"price_unit\":\"fixed\",\"quantity_unit\":null,\"duration\":\"2:30\",\"enable_booking\":true}', NULL, 1, 56, 7, '{\"id\":41,\"description\":\"Isolo, Lag\",\"address\":\"Isolo, Lagos 102214, Lagos, Nigeria\",\"latitude\":6.5355258000000002738261173362843692302703857421875,\"longitude\":3.326638200000000100686747828149236738681793212890625}', NULL, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2025-04-04 13:42:44', NULL, NULL, 'This is a test order', 1, '2025-04-04 19:43:55', '2025-04-04 19:50:46'),
(55, '{\"id\":2,\"name\":\"Lawal hair salon\",\"phone_number\":\"+19172849645\",\"mobile_number\":\"+44\"}', '{\"id\":41,\"name\":\"cornrows services\",\"price\":20,\"discount_price\":0,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 56, 1, '{\"id\":41,\"description\":\"Isolo, Lag\",\"address\":\"Isolo, Lagos 102214, Lagos, Nigeria\",\"latitude\":6.5355258000000002738261173362843692302703857421875,\"longitude\":3.326638200000000100686747828149236738681793212890625}', NULL, NULL, '[]', '2025-04-04 14:31:21', NULL, NULL, NULL, 0, '2025-04-04 20:31:28', '2025-04-04 20:31:28'),
(56, '{\"id\":1,\"name\":\"Concrete Beatty-Larkin\",\"phone_number\":\"+86.680.3907\",\"mobile_number\":\"+1(440)494-0259\"}', '{\"id\":9,\"name\":\"Braiding services\",\"price\":24.519999999999999573674358543939888477325439453125,\"discount_price\":null,\"price_unit\":\"fixed\",\"quantity_unit\":\"\",\"duration\":\"01:00\",\"enable_booking\":true}', NULL, 1, 120, 7, '{\"id\":42,\"description\":\"8XC2+PJW,\",\"address\":\"8XC2+PJW, Mosfla Road, Ibadan 110115, Oyo, Nigeria\",\"latitude\":7.3218546999999976065964801819063723087310791015625,\"longitude\":3.951579900000000034054892239510081708431243896484375}', NULL, NULL, '[{\"id\":4,\"name\":\"Service Tax\",\"value\":5,\"type\":\"percent\"}]', '2025-05-30 05:52:38', NULL, NULL, 'jsjdjdn', 1, '2025-05-30 11:53:15', '2025-05-30 13:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `booking_statuses`
--

DROP TABLE IF EXISTS `booking_statuses`;
CREATE TABLE `booking_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` longtext COLLATE utf8mb4_unicode_ci,
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_statuses`
--

INSERT INTO `booking_statuses` (`id`, `status`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Received', 1, '2021-01-25 18:25:46', '2021-01-29 16:56:35'),
(2, 'In Progress', 40, '2021-01-25 18:26:02', '2021-02-16 20:56:52'),
(3, 'On the Way', 20, '2021-01-28 06:47:23', '2021-02-16 11:10:13'),
(4, 'Accepted', 10, '2021-02-16 11:09:29', '2021-02-16 11:10:06'),
(5, 'Ready', 30, '2021-02-16 11:11:50', '2021-02-16 20:56:42'),
(6, 'Done', 50, '2021-02-16 20:57:02', '2021-02-16 20:57:02'),
(7, 'Failed', 60, '2021-02-16 20:58:36', '2021-02-16 20:58:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `color` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `order` int(11) DEFAULT '0',
  `featured` tinyint(1) DEFAULT '0',
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `color`, `description`, `order`, `featured`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"Braids\"}', '#3B8062', '{\"en\":\"<p><br></p>\"}', 1, 1, NULL, '2021-01-19 16:01:35', '2024-07-03 20:45:50'),
(2, '{\"en\":\"Twists and Locs\"}', '#3B8062', '{\"en\":\"<p><br></p>\"}', 2, 1, NULL, '2021-01-19 17:05:00', '2024-07-03 20:45:59'),
(3, '{\"en\":\"Wigs and Weaves\"}', '#3B8062', '{\"en\":\"<p><br></p>\"}', 3, 1, NULL, '2021-01-31 12:37:04', '2024-07-03 20:46:07'),
(4, '{\"en\":\"Natural Hair\"}', '#3B8062', '{\"en\":\"<p><br></p>\"}', 4, 0, NULL, '2021-01-31 12:38:37', '2024-07-03 20:46:17'),
(5, '{\"en\":\"Wash & Cut\"}', '#3B8062', '{\"en\":\"<p><br></p>\"}', 5, 0, NULL, '2021-01-31 12:42:02', '2024-07-03 20:46:26'),
(6, '{\"en\":\"Hair Straightening\"}', '#3B8062', '{\"en\":\"<p><br></p>\"}', 6, 0, NULL, '2021-01-31 12:43:20', '2024-07-03 20:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` double(8,2) NOT NULL DEFAULT '0.00',
  `discount_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'percent',
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `expires_at` datetime DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `symbol` longtext COLLATE utf8mb4_unicode_ci,
  `code` longtext COLLATE utf8mb4_unicode_ci,
  `decimal_digits` tinyint(3) UNSIGNED DEFAULT NULL,
  `rounding` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `code`, `decimal_digits`, `rounding`, `created_at`, `updated_at`) VALUES
(1, 'US Dollar', '$', 'USD', 2, 0, '2020-10-22 14:50:48', '2020-10-22 14:50:48'),
(2, 'Euro', '€', 'EUR', 2, 0, '2020-10-22 14:51:39', '2020-10-22 14:51:39'),
(7, '{\"en\":\"Pound Sterling\"}', '{\"en\":\"£\"}', '{\"en\":\"GBP\"}', 2, 2, '2020-10-22 14:56:26', '2024-07-02 17:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE `custom_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(56) COLLATE utf8mb4_unicode_ci NOT NULL,
  `values` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  `required` tinyint(1) DEFAULT NULL,
  `in_table` tinyint(1) DEFAULT NULL,
  `bootstrap_column` tinyint(4) DEFAULT NULL,
  `order` tinyint(4) DEFAULT NULL,
  `custom_field_model` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_fields`
--

INSERT INTO `custom_fields` (`id`, `name`, `type`, `values`, `disabled`, `required`, `in_table`, `bootstrap_column`, `order`, `custom_field_model`, `created_at`, `updated_at`) VALUES
(5, 'bio', 'textarea', NULL, 0, 0, 0, 6, 1, 'App\\Models\\User', '2019-09-06 20:43:58', '2019-09-06 20:43:58'),
(6, 'address', 'text', NULL, 0, 0, 0, 6, 3, 'App\\Models\\User', '2019-09-06 20:49:22', '2019-09-06 20:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `custom_field_values`
--

DROP TABLE IF EXISTS `custom_field_values`;
CREATE TABLE `custom_field_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `view` longtext COLLATE utf8mb4_unicode_ci,
  `custom_field_id` int(10) UNSIGNED NOT NULL,
  `customizable_type` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customizable_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_field_values`
--

INSERT INTO `custom_field_values` (`id`, `value`, `view`, `custom_field_id`, `customizable_type`, `customizable_id`, `created_at`, `updated_at`) VALUES
(30, 'Explicabo. Eum provi.', 'Explicabo. Eum provi.', 5, 'App\\Models\\User', 2, '2019-09-06 20:52:30', '2024-10-24 19:43:25'),
(31, 'Modi est libero qui', 'Modi est libero qui', 6, 'App\\Models\\User', 2, '2019-09-06 20:52:30', '2021-02-02 10:32:57'),
(33, '<br>', '', 5, 'App\\Models\\User', 1, '2019-09-06 20:53:58', '2025-03-24 13:50:27'),
(34, NULL, NULL, 6, 'App\\Models\\User', 1, '2019-09-06 20:53:58', '2025-03-24 13:50:27'),
(36, 'Dolor optio, error e', 'Dolor optio, error e', 5, 'App\\Models\\User', 3, '2019-10-15 16:21:32', '2021-02-02 10:33:23'),
(37, 'Voluptatibus ad ipsu', 'Voluptatibus ad ipsu', 6, 'App\\Models\\User', 3, '2019-10-15 16:21:32', '2021-02-02 10:33:23'),
(39, 'Faucibus ornare suspendisse sed nisi lacus sed. Pellentesque sit amet porttitor eget dolor morbi non arcu. Eu scelerisque felis imperdiet proin fermentum leo vel orci porta', 'Faucibus ornare suspendisse sed nisi lacus sed. Pellentesque sit amet porttitor eget dolor morbi non arcu. Eu scelerisque felis imperdiet proin fermentum leo vel orci porta', 5, 'App\\Models\\User', 4, '2019-10-16 18:31:46', '2019-10-16 18:31:46'),
(40, 'Sequi molestiae ipsa1', 'Sequi molestiae ipsa1', 6, 'App\\Models\\User', 4, '2019-10-16 18:31:46', '2021-02-21 22:32:10'),
(42, 'Omnis fugiat et cons.', 'Omnis fugiat et cons.', 5, 'App\\Models\\User', 5, '2019-12-15 17:49:44', '2021-02-02 10:29:47'),
(43, 'Consequatur delenit', 'Consequatur delenit', 6, 'App\\Models\\User', 5, '2019-12-15 17:49:44', '2021-02-02 10:29:47'),
(45, '<p>Short bio for this driver</p>', 'Short bio for this driver', 5, 'App\\Models\\User', 6, '2020-03-29 16:28:05', '2020-03-29 16:28:05'),
(46, '4722 Villa Drive', '4722 Villa Drive', 6, 'App\\Models\\User', 6, '2020-03-29 16:28:05', '2020-03-29 16:28:05'),
(48, 'Voluptatem. Omnis op.', 'Voluptatem. Omnis op.', 5, 'App\\Models\\User', 7, '2021-01-17 15:13:24', '2021-02-02 10:31:36'),
(49, 'Perspiciatis aut ei', 'Perspiciatis aut ei', 6, 'App\\Models\\User', 7, '2021-01-17 15:13:24', '2021-02-02 10:31:36'),
(51, 'sdfsdf56', 'sdfsdf56', 5, 'App\\Models\\User', 8, '2021-02-10 10:31:12', '2021-02-19 13:09:37'),
(52, 'Adressttt', 'Adressttt', 6, 'App\\Models\\User', 8, '2021-02-10 10:31:12', '2021-02-19 12:57:27'),
(53, NULL, '', 5, 'App\\Models\\User', 9, '2024-07-04 11:00:31', '2024-07-04 11:00:31'),
(54, '39 doctor Ladi Alakija  Street,Lekki', '39 doctor Ladi Alakija  Street,Lekki', 6, 'App\\Models\\User', 9, '2024-07-04 11:00:31', '2024-07-04 11:03:04'),
(55, NULL, '', 5, 'App\\Models\\User', 10, '2024-07-06 15:01:17', '2024-07-06 15:01:17'),
(56, NULL, NULL, 6, 'App\\Models\\User', 10, '2024-07-06 15:01:17', '2024-07-06 15:01:17'),
(57, NULL, '', 5, 'App\\Models\\User', 12, '2024-07-09 05:07:32', '2024-07-09 05:07:32'),
(58, NULL, NULL, 6, 'App\\Models\\User', 12, '2024-07-09 05:07:32', '2024-08-01 01:14:10'),
(59, NULL, '', 5, 'App\\Models\\User', 13, '2024-08-01 01:40:38', '2024-08-01 01:40:38'),
(60, NULL, NULL, 6, 'App\\Models\\User', 13, '2024-08-01 01:40:38', '2024-08-01 01:40:38'),
(61, NULL, '', 5, 'App\\Models\\User', 14, '2024-08-01 07:38:58', '2024-08-01 07:38:58'),
(62, NULL, NULL, 6, 'App\\Models\\User', 14, '2024-08-01 07:38:58', '2024-08-01 07:38:58'),
(63, NULL, '', 5, 'App\\Models\\User', 15, '2024-08-03 04:39:05', '2024-08-03 04:39:05'),
(64, NULL, NULL, 6, 'App\\Models\\User', 15, '2024-08-03 04:39:05', '2024-08-03 04:39:05'),
(65, NULL, '', 5, 'App\\Models\\User', 16, '2024-08-06 15:15:24', '2024-08-06 15:15:24'),
(66, NULL, NULL, 6, 'App\\Models\\User', 16, '2024-08-06 15:15:24', '2024-08-06 15:15:24'),
(67, '<p>Toyin Lawal is a talented hair stylist and entrepreneur, renowned for offering premium hair services. With a passion for enhancing beauty through creative hair solutions, she specializes in styling, installing, and maintaining wigs, hair extensions, and natural hair. Known for her attention to detail and personalized care, Toyin works with a diverse clientele, helping them achieve their desired look, whether for everyday elegance or special occasions. Her expertise, combined with a commitment to quality, has made her a trusted name in the hair industry.<br></p>', 'Toyin Lawal is a talented hair stylist and entrepreneur, renowned for offering premium hair services. With a passion for enhancing beauty through creative hair solutions, she specializes in styling, installing, and maintaining wigs, hair extensions, and natural hair. Known for her attention to detail and personalized care, Toyin works with a diverse clientele, helping them achieve their desired look, whether for everyday elegance or special occasions. Her expertise, combined with a commitment to quality, has made her a trusted name in the hair industry.', 5, 'App\\Models\\User', 11, '2024-08-06 16:45:48', '2024-10-16 18:39:42'),
(68, NULL, NULL, 6, 'App\\Models\\User', 11, '2024-08-06 16:45:48', '2024-08-06 16:45:48'),
(69, NULL, '', 5, 'App\\Models\\User', 23, '2025-01-02 22:11:15', '2025-01-02 22:11:15'),
(70, NULL, NULL, 6, 'App\\Models\\User', 23, '2025-01-02 22:11:15', '2025-01-02 22:11:15'),
(71, NULL, '', 5, 'App\\Models\\User', 25, '2025-01-17 18:07:28', '2025-01-17 18:07:28'),
(72, NULL, NULL, 6, 'App\\Models\\User', 25, '2025-01-17 18:07:28', '2025-01-17 18:07:28'),
(73, NULL, '', 5, 'App\\Models\\User', 31, '2025-02-21 23:29:51', '2025-02-21 23:29:51'),
(74, 'pea', 'pea', 6, 'App\\Models\\User', 31, '2025-02-21 23:29:51', '2025-02-22 00:32:01'),
(75, NULL, '', 5, 'App\\Models\\User', 32, '2025-02-21 23:38:28', '2025-02-21 23:38:28'),
(76, '4566 ghhh', '4566 ghhh', 6, 'App\\Models\\User', 32, '2025-02-21 23:38:28', '2025-02-22 00:31:35'),
(77, NULL, '', 5, 'App\\Models\\User', 34, '2025-02-22 00:22:48', '2025-02-22 00:22:48'),
(78, 'John', 'John', 6, 'App\\Models\\User', 34, '2025-02-22 00:22:48', '2025-02-22 00:32:40'),
(79, NULL, '', 5, 'App\\Models\\User', 35, '2025-02-22 00:32:56', '2025-02-22 00:32:56'),
(80, NULL, NULL, 6, 'App\\Models\\User', 35, '2025-02-22 00:32:56', '2025-02-22 00:32:56'),
(81, NULL, '', 5, 'App\\Models\\User', 52, '2025-03-27 15:55:18', '2025-03-27 15:55:18'),
(82, NULL, NULL, 6, 'App\\Models\\User', 52, '2025-03-27 15:55:18', '2025-03-27 15:55:18'),
(83, 'none', 'none', 5, 'App\\Models\\User', 56, '2025-04-03 23:17:01', '2025-04-03 23:35:14'),
(84, '3 jideowo close', '3 jideowo close', 6, 'App\\Models\\User', 56, '2025-04-03 23:17:01', '2025-04-03 23:33:52'),
(85, 'hpxfww', 'hpxfww', 5, 'App\\Models\\User', 79, '2025-04-19 13:03:00', '2025-04-19 13:03:00'),
(86, 'jiqtzz', 'jiqtzz', 6, 'App\\Models\\User', 79, '2025-04-19 13:03:00', '2025-04-19 13:03:00'),
(87, NULL, '', 5, 'App\\Models\\User', 120, '2025-05-30 11:47:32', '2025-05-30 11:47:32'),
(88, NULL, NULL, 6, 'App\\Models\\User', 120, '2025-05-30 11:47:32', '2025-05-30 11:47:32'),
(89, NULL, '', 5, 'App\\Models\\User', 173, '2025-08-06 15:34:49', '2025-08-06 15:34:49'),
(90, NULL, NULL, 6, 'App\\Models\\User', 173, '2025-08-06 15:34:49', '2025-08-06 15:34:49'),
(91, NULL, '', 5, 'App\\Models\\User', 192, '2025-08-25 22:14:25', '2025-08-25 22:14:25'),
(92, NULL, NULL, 6, 'App\\Models\\User', 192, '2025-08-25 22:14:25', '2025-08-25 22:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `custom_pages`
--

DROP TABLE IF EXISTS `custom_pages`;
CREATE TABLE `custom_pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` longtext COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_pages`
--

INSERT INTO `custom_pages` (`id`, `title`, `content`, `published`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"Privacy Policy\"}', '{\"en\":\"<h1>Privacy Policy&nbsp;</h1><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">Last Updated: 14/07/2024<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">Welcome to EWA! This Privacy Policy\\r\\nexplains how EWA collects, uses, discloses, and protects your information when\\r\\nyou use the EWA mobile application (\\\"App\\\"). By using the App, you\\r\\nagree to the collection and use of information in accordance with this Privacy\\r\\nPolicy. If you do not agree with any part of this policy, please do not use the\\r\\nApp.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">1. <b>Information We Collect</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">1.1 <b>Personal Information</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">When you create an account on the App, we\\r\\nmay collect the following personal information:<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l1 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Name<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l1 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Email address<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l1 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Phone number<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l1 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Profile picture (if uploaded)<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l1 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Any other information you\\r\\nchoose to provide<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">1.2 <b>Content</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">If you create and/or upload content (e.g.,\\r\\ntext, images), we will collect and store such content.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">1.3 <b>Usage Data</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">We may collect information on how the App\\r\\nis accessed and used, including:<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Device information (e.g.,\\r\\ndevice type, operating system, unique device identifiers)<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Log data (e.g., IP address,\\r\\nbrowser type, date and time of access)<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">App usage data (e.g., features\\r\\nused, pages viewed, actions taken)<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">2. <b>How We Use Your Information</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">We use the information we\\r\\ncollect for various purposes, including:<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">To provide and maintain the App<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">To allow you to create and\\r\\nmanage your account<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">To facilitate bookings with\\r\\nhair vendors<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">To respond to your inquiries\\r\\nand provide customer support<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">To send you updates,\\r\\npromotions, and other information that may be of interest to you<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">To monitor and analyze usage\\r\\nand trends to improve the App<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">To detect, prevent, and address\\r\\ntechnical issues<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">3. <b>How We Share Your Information</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">We may share your information with:<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l0 level1 lfo3\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Hair Vendors: When you book a\\r\\nservice, we may share your information with the relevant hair vendor to\\r\\nfacilitate the booking.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l0 level1 lfo3\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Service Providers: We may\\r\\nemploy third-party companies and individuals to facilitate our App, provide the\\r\\nservice on our behalf, perform App-related services, or assist us in analyzing\\r\\nhow our App is used.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l0 level1 lfo3\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Legal Requirements: We may\\r\\ndisclose your information if required to do so by law or in response to valid\\r\\nrequests by public authorities.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">4. <b>Security of Your Information</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">We are committed to protecting your\\r\\ninformation. We implement a variety of security measures to maintain the safety\\r\\nof your personal information. However, please be aware that no method of\\r\\ntransmission over the internet or method of electronic storage is 100% secure\\r\\nand we cannot guarantee absolute security.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">5. <b>Your Data Protection Rights</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">Under the General Data Protection\\r\\nRegulation (GDPR), you have the following rights:<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l2 level1 lfo4\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Access: You have the right to\\r\\nrequest copies of your personal data.<o:p></o:p></span></p><p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n</p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l2 level1 lfo4\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Rectification: You have the\\r\\nright to request that we correct any information you believe is inaccurate or\\r\\ncomplete information you believe<o:p></o:p></span></p>\"}', 1, '2021-02-24 10:53:21', '2024-07-15 00:10:42'),
(2, '{\"en\":\"Terms & Conditions\"}', '{\"en\":\"<h2>Terms &amp; Conditions</h2><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">Last Updated: 14/07/2024<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">Welcome to EWA! These Terms and Conditions\\r\\n(\\\"Terms\\\") govern your use of the EWA mobile application\\r\\n(\\\"App\\\"), operated by BELADIO SERVICES LIMITED. By accessing or using\\r\\nthe App, you agree to be bound by these Terms. If you do not agree with any\\r\\npart of these Terms, please do not use the App.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">1. <b>Account Creation</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l4 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Eligibility: To create an\\r\\naccount on the App, you must be at least 18 years old or have reached the age\\r\\nof majority in your jurisdiction.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l4 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Account Information: When\\r\\ncreating an account, you agree to provide accurate and complete information.\\r\\nYou are responsible for maintaining the confidentiality of your account\\r\\ncredentials and for all activities that occur under your account.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l4 level1 lfo1\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Account Security: You must\\r\\nnotify us immediately if you suspect any unauthorized use of your account.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">2. <b>User Content</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l5 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Content Creation and Upload:\\r\\nUsers can create and/or upload content, including but not limited to text and\\r\\nimages (\\\"User Content\\\").<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l5 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Responsibility for Content: You\\r\\nare solely responsible for the User Content you create or upload. You represent\\r\\nand warrant that you own or have the necessary rights to post such content and\\r\\nthat it does not infringe on any third party\'s rights.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l5 level1 lfo2\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Prohibited Content: You agree\\r\\nnot to post content that is unlawful, harmful, threatening, abusive, harassing,\\r\\ndefamatory, vulgar, obscene, invasive of another\'s privacy, or otherwise\\r\\nobjectionable.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">3. <b>Booking Hair Vendors</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l2 level1 lfo3\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Service Description: The App\\r\\nallows users to book hair vendors for home services.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpMiddle\\\" style=\\\"text-indent:-18.0pt;mso-list:l2 level1 lfo3\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Booking Process: You must\\r\\nfollow the booking process as outlined in the App. All bookings are subject to\\r\\navailability and confirmation by the hair vendor.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l2 level1 lfo3\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Payments: Payment terms and\\r\\nconditions for services provided by hair vendors will be detailed during the\\r\\nbooking process.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">4. <b>Communication</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">Contact Information: If you need more\\r\\ninformation or have any questions, you can contact us at info@ewaofficial.co.uk<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">5. <b>Intellectual Property</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l0 level1 lfo4\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Ownership: All intellectual\\r\\nproperty rights in the App and its content (excluding User Content) are owned\\r\\nby us or our licensors.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l0 level1 lfo4\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Limited License: We grant you a\\r\\nlimited, non-exclusive, non-transferable license to use the App in accordance\\r\\nwith these Terms.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">6. <b>Termination</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l1 level1 lfo5\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Termination by Us: We may\\r\\nterminate or suspend your account and access to the App at any time, without\\r\\nprior notice or liability, for any reason, including if you breach these Terms.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l1 level1 lfo5\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Termination by You: You may\\r\\nterminate your account at any time by deleting the App from your device and\\r\\nnotifying us at info@ewaofficial.co.uk<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">7. <b>Limitation of Liability</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo6\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Disclaimer: The App is provided\\r\\non an \\\"as is\\\" and \\\"as available\\\" basis. We do not warrant\\r\\nthat the App will be uninterrupted, error-free, or free of viruses or other\\r\\nharmful components.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l3 level1 lfo6\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Limitation: To the fullest\\r\\nextent permitted by law, we shall not be liable for any indirect, incidental,\\r\\nspecial, consequential, or punitive damages, or any loss of profits or\\r\\nrevenues, whether incurred directly or indirectly, or any loss of data, use,\\r\\ngoodwill, or other intangible losses, resulting from (i) your use or inability\\r\\nto use the App; (ii) any unauthorized access to or use of our servers and/or\\r\\nany personal information stored therein.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">8. <b>Governing Law</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">These Terms shall be governed by and\\r\\nconstrued in accordance with the laws of the United Kingdom, without regard to\\r\\nits conflict of law principles.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">9. <b>Changes to Terms</b><o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">We reserve the right to modify these Terms\\r\\nat any time. We will notify you of any changes by posting the new Terms on the\\r\\nApp. You are advised to review these Terms periodically for any changes.\\r\\nChanges to these Terms are effective when they are posted on this page.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">10. <b>Miscellaneous</b><o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpFirst\\\" style=\\\"text-indent:-18.0pt;mso-list:l6 level1 lfo7\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Entire Agreement: These Terms\\r\\nconstitute the entire agreement between you and us regarding the use of the\\r\\nApp.<o:p></o:p></span></p><p class=\\\"MsoListParagraphCxSpLast\\\" style=\\\"text-indent:-18.0pt;mso-list:l6 level1 lfo7\\\"><!--[if !supportLists]--><span lang=\\\"en-NG\\\" style=\\\"font-family:Symbol;mso-fareast-font-family:Symbol;mso-bidi-font-family:\\r\\nSymbol\\\">·<span style=\\\"font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-stretch: normal; font-size: 7pt; line-height: normal; font-family: &quot;Times New Roman&quot;;\\\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\\r\\n</span></span><!--[endif]--><span lang=\\\"en-NG\\\">Severability: If any provision\\r\\nof these Terms is found to be unenforceable or invalid, that provision will be\\r\\nlimited or eliminated to the minimum extent necessary, and the remaining\\r\\nprovisions will remain in full force and effect.<o:p></o:p></span></p><p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n</p><p class=\\\"MsoNormal\\\"><span lang=\\\"en-NG\\\">By using the EWA mobile application, you\\r\\nagree to these Terms and Conditions. If you have any questions, please contact\\r\\nus at info@ewaofficial.co.uk<o:p></o:p></span></p>\"}', 1, '2021-02-24 12:20:06', '2024-07-15 00:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `discountables`
--

DROP TABLE IF EXISTS `discountables`;
CREATE TABLE `discountables` (
  `id` int(10) UNSIGNED NOT NULL,
  `coupon_id` int(10) UNSIGNED NOT NULL,
  `discountable_type` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discountable_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

DROP TABLE IF EXISTS `earnings`;
CREATE TABLE `earnings` (
  `id` int(10) UNSIGNED NOT NULL,
  `e_provider_id` int(10) UNSIGNED DEFAULT NULL,
  `total_bookings` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `total_earning` double(10,2) NOT NULL DEFAULT '0.00',
  `admin_earning` double(10,2) NOT NULL DEFAULT '0.00',
  `e_provider_earning` double(10,2) NOT NULL DEFAULT '0.00',
  `taxes` double(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payout` double(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`id`, `e_provider_id`, `total_bookings`, `total_earning`, `admin_earning`, `e_provider_earning`, `taxes`, `created_at`, `updated_at`, `payout`) VALUES
(1, 1, 17, 517.11, 103.42, 113.69, 0.00, '2024-07-03 23:31:14', '2024-08-23 21:05:56', 300.00),
(2, 2, 2, 4.00, 0.80, 3.20, 0.00, '2024-07-03 23:31:14', '2024-08-29 16:30:35', 1.60),
(3, 3, 0, 0.00, 0.00, 0.00, 0.00, '2024-11-27 22:01:16', '2024-11-27 22:01:16', 0.00),
(4, 5, 0, 0.00, 0.00, 0.00, 0.00, '2025-03-28 18:06:37', '2025-03-28 18:06:37', 0.00),
(5, 6, 0, 0.00, 0.00, 0.00, 0.00, '2025-03-28 18:11:02', '2025-03-28 18:11:02', 0.00),
(6, 7, 0, 0.00, 0.00, 0.00, 0.00, '2025-04-04 15:23:27', '2025-04-04 15:23:27', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

DROP TABLE IF EXISTS `experiences`;
CREATE TABLE `experiences` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_providers`
--

DROP TABLE IF EXISTS `e_providers`;
CREATE TABLE `e_providers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `e_provider_type_id` int(10) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `phone_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability_range` double(9,2) DEFAULT '0.00',
  `available` tinyint(1) DEFAULT '1',
  `featured` tinyint(1) DEFAULT '0',
  `accepted` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_providers`
--

INSERT INTO `e_providers` (`id`, `name`, `e_provider_type_id`, `description`, `phone_number`, `mobile_number`, `availability_range`, `available`, `featured`, `accepted`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"Concrete Beatty-Larkin\"}', 2, '{\"en\":\"Perspiciatis error laboriosam dignissimos et optio doloremque. Architecto mollitia distinctio et est. Soluta enim ut enim enim explicabo laboriosam deleniti. At autem doloribus atque.\"}', '+86.680.3907', '+1(440)494-0259', 10498.71, 0, 0, 1, '2024-07-05 22:10:53', '2024-08-22 23:23:28'),
(2, '{\"en\":\"Lawal hair salon\"}', 3, '{\"en\":\"Lawal Hair isn’t just about selling wigs—it’s about empowering individuals to embrace their beauty with pride. Our mission is to create products that inspire confidence, enhance your style, and bring your hair goals to life.\"}', '+19172849645', '+44', 24.00, 1, 1, 1, '2024-07-09 04:28:07', '2024-11-27 22:10:01'),
(3, '{\"en\":\"Nikkie Hair\"}', 3, '{\"en\":\"<p>At Nikkie Hair, we believe that your hair is a powerful expression of who you are. That’s why we are dedicated to offering premium-quality hair products that cater to every style, preference, and personality. From luxurious wigs in a variety of textures and lengths to expertly crafted hairpieces, we provide everything you need to look and feel your best.</p>\"}', '+447411448252', NULL, 30.00, 1, 1, 1, '2024-11-27 22:00:37', '2024-11-27 22:01:16'),
(4, '{\"en\":\"GRAMEF Digital\"}', 2, '{\"en\":null}', NULL, NULL, 100.00, 0, 0, 0, '2025-03-28 17:16:18', '2025-03-28 17:16:18'),
(5, '{\"en\":\"Test\"}', 2, '{\"en\":\"This is a test\"}', '+4474551874', '+44846886776', 100.00, 1, 0, 1, '2025-03-28 17:21:42', '2025-03-28 18:08:42'),
(6, '{\"en\":\"Test\"}', 2, '{\"en\":\"Test\"}', '+441231231234', '+441231231234', 100.00, 1, 1, 1, '2025-03-28 17:24:07', '2025-03-28 18:11:02'),
(7, '{\"en\":\"First Seller\"}', 3, '{\"en\":\"none for now\"}', '+4470835545000', '+445427075422', 5.00, 1, 1, 1, '2025-04-03 23:43:28', '2025-04-04 15:23:27'),
(8, '{\"en\":\"Mayor group\"}', 2, '{\"en\":\"hdbdbbdbdbdbdbbdbdb\"}', '+23409158626428', '+23409158626428', 24.00, 1, 0, 0, '2025-05-28 03:52:50', '2025-05-28 03:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `e_provider_addresses`
--

DROP TABLE IF EXISTS `e_provider_addresses`;
CREATE TABLE `e_provider_addresses` (
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `address_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_provider_addresses`
--

INSERT INTO `e_provider_addresses` (`e_provider_id`, `address_id`) VALUES
(15, 1),
(10, 2),
(11, 2),
(10, 7),
(14, 7),
(17, 7),
(13, 12),
(13, 14),
(17, 14),
(18, 14),
(13, 15),
(9, 18),
(16, 19),
(13, 20),
(1, 21),
(2, 24),
(3, 34),
(4, 35),
(5, 36),
(6, 37),
(6, 38),
(7, 39),
(8, 42);

-- --------------------------------------------------------

--
-- Table structure for table `e_provider_locations`
--

DROP TABLE IF EXISTS `e_provider_locations`;
CREATE TABLE `e_provider_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_provider_locations`
--

INSERT INTO `e_provider_locations` (`id`, `e_provider_id`, `booking_id`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(2, 2, 5, 6.5991765, 3.3525452, '2024-07-09 04:53:17', '2024-07-09 04:53:17'),
(4, 1, 7, 6.7027713, 3.3994538, '2024-07-09 14:39:13', '2024-07-09 15:45:34'),
(6, 1, 9, 51.5072580, -0.1278010, '2024-07-10 17:56:58', '2024-07-10 17:56:58'),
(7, 1, 10, 51.5072580, -0.1278010, '2024-07-14 21:25:39', '2024-07-14 21:25:39'),
(8, 1, 11, 51.5072580, -0.1278010, '2024-07-15 01:31:38', '2024-07-15 01:31:38'),
(9, 1, 12, 51.5072580, -0.1278010, '2024-07-22 19:33:50', '2024-07-22 19:33:50'),
(10, 1, 13, 51.5072580, -0.1278010, '2024-07-23 14:24:37', '2024-07-23 14:24:37'),
(11, 1, 14, 51.5072580, -0.1278010, '2024-07-23 17:14:18', '2024-07-23 17:14:18'),
(12, 1, 15, 51.5072580, -0.1278010, '2024-07-28 23:03:14', '2024-07-28 23:03:14'),
(13, 1, 16, 51.5072580, -0.1278010, '2024-07-28 23:07:24', '2024-07-28 23:07:24'),
(14, 1, 17, 51.5072580, -0.1278010, '2024-07-29 18:48:13', '2024-07-29 18:48:13'),
(15, 1, 18, 51.5072580, -0.1278010, '2024-07-29 19:22:59', '2024-07-29 19:22:59'),
(16, 1, 19, 51.5072580, -0.1278010, '2024-07-29 20:06:50', '2024-07-29 20:06:50'),
(17, 1, 20, 51.5072580, -0.1278010, '2024-07-31 13:33:23', '2024-07-31 13:33:23'),
(18, 1, 21, 51.5072580, -0.1278010, '2024-07-31 14:33:17', '2024-07-31 14:33:17'),
(19, 1, 22, 51.5072580, -0.1278010, '2024-07-31 20:48:59', '2024-07-31 20:48:59'),
(20, 1, 23, 51.5072580, -0.1278010, '2024-07-31 22:57:28', '2024-07-31 22:57:28'),
(21, 1, 24, 51.5072580, -0.1278010, '2024-07-31 23:29:39', '2024-07-31 23:29:39'),
(22, 1, 25, 51.5072580, -0.1278010, '2024-08-01 06:28:52', '2024-08-01 06:28:52'),
(23, 1, 26, 51.5072580, -0.1278010, '2024-08-01 06:34:32', '2024-08-01 06:34:32'),
(24, 1, 27, 51.5072580, -0.1278010, '2024-08-01 07:11:28', '2024-08-01 07:11:28'),
(25, 1, 28, 51.5072580, -0.1278010, '2024-08-01 21:06:55', '2024-08-01 21:06:55'),
(26, 1, 29, 51.5072580, -0.1278010, '2024-08-01 21:17:04', '2024-08-01 21:17:04'),
(27, 1, 30, 51.5072580, -0.1278010, '2024-08-02 01:46:06', '2024-08-02 01:46:06'),
(28, 1, 31, 51.5072580, -0.1278010, '2024-08-02 21:49:19', '2024-08-02 21:49:19'),
(29, 1, 32, 51.5072580, -0.1278010, '2024-08-03 04:57:37', '2024-08-03 04:57:37'),
(30, 1, 33, 51.5072580, -0.1278010, '2024-08-03 07:24:53', '2024-08-03 07:24:53'),
(31, 1, 34, 51.5072580, -0.1278010, '2024-08-03 10:16:09', '2024-08-03 10:16:09'),
(32, 1, 35, 51.5072580, -0.1278010, '2024-08-03 22:52:05', '2024-08-03 22:52:05'),
(33, 1, 36, 51.5072580, -0.1278010, '2024-08-03 23:02:59', '2024-08-03 23:02:59'),
(34, 1, 37, 51.5072580, -0.1278010, '2024-08-06 14:49:16', '2024-08-06 14:49:16'),
(35, 1, 38, 51.5072580, -0.1278010, '2024-08-06 15:16:35', '2024-08-06 15:16:35'),
(36, 1, 39, 51.5072580, -0.1278010, '2024-08-06 16:05:48', '2024-08-06 16:05:48'),
(37, 1, 40, 51.5072580, -0.1278010, '2024-08-06 16:07:29', '2024-08-06 16:07:29'),
(38, 2, 41, 6.5991765, 3.3525452, '2024-08-06 17:05:04', '2024-08-06 17:05:04'),
(39, 1, 42, 51.5072580, -0.1278010, '2024-08-06 17:32:44', '2024-08-06 17:32:44'),
(40, 1, 43, 51.5072580, -0.1278010, '2024-08-06 17:55:37', '2024-08-06 17:55:37'),
(41, 1, 44, 51.5072580, -0.1278010, '2024-08-10 23:37:41', '2024-08-10 23:37:41'),
(42, 1, 45, 51.5072580, -0.1278010, '2024-08-12 02:07:47', '2024-08-12 02:07:47'),
(43, 1, 46, 51.5072580, -0.1278010, '2024-08-22 22:30:40', '2024-08-22 22:30:40'),
(44, 1, 47, 51.5072580, -0.1278010, '2024-08-29 16:18:13', '2024-08-29 16:18:13'),
(45, 1, 48, 51.5072580, -0.1278010, '2024-08-29 16:25:09', '2024-08-29 16:25:09'),
(46, 2, 49, 6.5991765, 3.3525452, '2024-08-29 16:27:20', '2024-08-29 16:27:20'),
(47, 1, 50, 51.5072580, -0.1278010, '2024-10-10 13:50:03', '2024-10-10 13:50:03'),
(48, 1, 51, 51.5072580, -0.1278010, '2025-03-26 14:30:45', '2025-03-26 14:30:45'),
(49, 1, 52, 51.5072580, -0.1278010, '2025-03-28 18:04:40', '2025-03-28 18:04:40'),
(50, 7, 53, 6.6704434, 3.4837560, '2025-04-04 19:28:14', '2025-04-04 19:28:14'),
(51, 7, 54, 6.6704434, 3.4837560, '2025-04-04 19:43:55', '2025-04-04 19:43:55'),
(52, 2, 55, 6.5991765, 3.3525452, '2025-04-04 20:31:28', '2025-04-04 20:31:28'),
(53, 1, 56, 51.5072580, -0.1278010, '2025-05-30 11:53:15', '2025-05-30 11:53:15');

-- --------------------------------------------------------

--
-- Table structure for table `e_provider_payouts`
--

DROP TABLE IF EXISTS `e_provider_payouts`;
CREATE TABLE `e_provider_payouts` (
  `id` int(10) UNSIGNED NOT NULL,
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `method` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `paid_date` datetime NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iban` varchar(34) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_code` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receipt_pdf` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_provider_payouts`
--

INSERT INTO `e_provider_payouts` (`id`, `e_provider_id`, `method`, `amount`, `paid_date`, `note`, `created_at`, `updated_at`, `full_name`, `bank_name`, `account_number`, `iban`, `sort_code`, `receipt_pdf`, `paid`) VALUES
(1, 2, 'Bank', 1.60, '2024-08-07 18:12:31', NULL, '2024-08-08 00:12:31', '2024-08-18 15:33:29', 'toyin', 'natwest', '5074559542', '233444', '4445555555', 'receipts/ujrqrD2GNjDA7gTQuiyy5hejZR0vF6iYpwSAExTt.pdf', 1),
(2, 1, 'Bank', 298.74, '2024-08-07 18:37:32', '<p>dhdhdhdhdhd</p>', '2024-08-08 00:37:32', '2024-08-08 00:37:32', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(3, 1, 'Bank', 200.00, '2024-08-16 16:19:45', NULL, '2024-08-16 22:19:45', '2024-08-16 22:21:33', 'Raouf', 'Wise', '1234', '654654654', '45646546545', 'receipts/9grpACVHcFkLTyqPAM9wHctWsI2DG6JzKIGjBNy5.pdf', 1),
(4, 1, 'Bank', 100.00, '2024-08-16 16:32:51', '<p>This is payout for concrete Beaty-Larkin</p>', '2024-08-16 22:32:51', '2024-08-16 22:33:52', 'Raouf smari', 'Wise', '121234325', '32423345082081248', 'ZEDROOF', 'receipts/9s8tIVQ9pKvzxvKNgo7xOScdxY9sUVkttBYyp1eb.pdf', 1),
(5, 1, 'Bank', 400.00, '2024-08-22 17:00:20', '<p>yg</p>', '2024-08-22 23:00:20', '2024-08-22 23:00:20', 'toyin', 'natwest', '5074559542', NULL, '55667777', NULL, 0),
(6, 1, 'Bank', 280.00, '2024-08-22 17:01:44', NULL, '2024-08-22 23:01:44', '2024-08-22 23:01:44', 'toyin', 'natwest', '5074559542', NULL, '55667777', NULL, 0),
(7, 1, 'Bank', 200.00, '2024-08-23 15:01:51', NULL, '2024-08-23 21:01:51', '2024-08-23 21:01:51', 'Raouf', 'Wise', '1234', '212121', '12121212', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `e_provider_subscriptions`
--

DROP TABLE IF EXISTS `e_provider_subscriptions`;
CREATE TABLE `e_provider_subscriptions` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `starts_at` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `subscription_package_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `e_provider_taxes`
--

DROP TABLE IF EXISTS `e_provider_taxes`;
CREATE TABLE `e_provider_taxes` (
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `tax_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_provider_taxes`
--

INSERT INTO `e_provider_taxes` (`e_provider_id`, `tax_id`) VALUES
(1, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `e_provider_types`
--

DROP TABLE IF EXISTS `e_provider_types`;
CREATE TABLE `e_provider_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `commission` double(5,2) NOT NULL DEFAULT '0.00',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_provider_types`
--

INSERT INTO `e_provider_types` (`id`, `name`, `commission`, `disabled`, `created_at`, `updated_at`) VALUES
(2, '{\"en\":\"Company\"}', 80.00, 0, '2021-01-13 17:05:35', '2024-07-09 16:19:20'),
(3, '{\"en\":\"Sole proprietorship\"}', 80.00, 0, '2021-01-17 18:27:18', '2024-07-09 16:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `e_provider_users`
--

DROP TABLE IF EXISTS `e_provider_users`;
CREATE TABLE `e_provider_users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `e_provider_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_provider_users`
--

INSERT INTO `e_provider_users` (`user_id`, `e_provider_id`) VALUES
(2, 1),
(11, 2),
(6, 3),
(2, 4),
(6, 4),
(34, 5),
(34, 6),
(57, 7),
(118, 8),
(6, 10),
(2, 12),
(2, 13),
(2, 14),
(6, 17),
(4, 18),
(6, 18);

-- --------------------------------------------------------

--
-- Table structure for table `e_services`
--

DROP TABLE IF EXISTS `e_services`;
CREATE TABLE `e_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `discount_price` double(10,2) DEFAULT '0.00',
  `price_unit` enum('hourly','fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_unit` longtext COLLATE utf8mb4_unicode_ci,
  `duration` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `featured` tinyint(1) DEFAULT '0',
  `enable_booking` tinyint(1) DEFAULT '1',
  `available` tinyint(1) DEFAULT '1',
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_services`
--

INSERT INTO `e_services` (`id`, `name`, `price`, `discount_price`, `price_unit`, `quantity_unit`, `duration`, `description`, `featured`, `enable_booking`, `available`, `e_provider_id`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"Hair Twisting\"}', 35.92, 0.00, 'fixed', '{\"en\":null}', '05:00', '{\"en\":\"We offer expert hair-twisting services to give you a stylish, protective look. From simple two-strand twists to intricate styles like Senegalese or Marley twists, our skilled stylists will create a beautiful, long-lasting hairstyle that promotes healthy hair growth. Book your appointment today for a look that’s both low-maintenance and stunning!\"}', 1, 1, 1, 1, '2024-07-01 16:05:34', '2024-10-09 20:19:02'),
(9, '{\"en\":\"Braiding services\"}', 24.52, NULL, 'fixed', '{\"en\":null}', '01:00', '{\"en\":\"We offer professional braiding services to give you a beautiful, long-lasting style. Whether you want classic box braids, cornrows, or other intricate styles, our expert stylists will create a protective and stylish look. Book your appointment today for a stunning, low-maintenance hairstyle!\"}', 1, 1, 1, 1, '2024-07-01 16:05:34', '2024-10-09 20:19:35'),
(10, '{\"en\":\"Wig revamps\"}', 14.84, NULL, 'fixed', '{\"en\":null}', '02:00', '{\"en\":\"We offer expert wig revamp services to refresh and restore your wigs to their original beauty. Whether restyling, washing, or repairing our skilled team will give your wig a new lease on life, making it look fresh, stylish, and ready to wear. Book your wig revamp service today!\"}', 1, 1, 1, 1, '2024-07-01 16:05:34', '2024-10-09 20:20:14'),
(11, '{\"en\":\"Hair perming\"}', 47.61, NULL, 'fixed', '{\"en\":null}', '04:00', '{\"en\":\"We provide professional hair perming services to give you beautiful, long-lasting curls or waves. Our skilled stylists use gentle techniques to ensure your hair stays healthy while achieving the perfect texture you desire. Book your hair perming appointment today for a gorgeous, voluminous look!\"}', 1, 1, 1, 1, '2024-07-01 16:05:34', '2024-10-09 20:20:52'),
(12, '{\"en\":\"Mens hair cut\"}', 29.30, NULL, 'fixed', '{\"en\":null}', '03:00', '{\"en\":\"We offer precision men’s haircuts tailored to your style. Our skilled barbers are dedicated to providing sharp, clean cuts that enhance your look, whether you prefer a classic style or a modern trend. Experience a fresh, stylish haircut—book your appointment today!\"}', 1, 1, 1, 1, '2024-07-01 16:05:34', '2024-10-09 20:21:23'),
(13, '{\"en\":\"Smooth Hair straightening\"}', 26.30, 0.00, 'fixed', '{\"en\":null}', NULL, '{\"en\":\"We specialize in smooth hair straightening services to give you sleek, shiny locks. Our professional stylists use advanced techniques to eliminate frizz and enhance your hair\'s natural beauty while ensuring it stays healthy and vibrant. Experience the transformation—book your smooth hair straightening appointment today!\"}', 1, 1, 1, 1, '2024-07-01 16:05:34', '2024-10-09 20:21:46'),
(40, '{\"en\":\"cornrows\"}', 44.43, 0.00, 'fixed', '{\"en\":null}', '05:00', '{\"en\":\"We offer professional cornrow services to create stylish and protective hairstyles. Our skilled stylists expertly weave your hair into beautiful cornrows, tailored to your unique preferences. Enjoy a low-maintenance look that lasts—book your cornrow appointment today!<br>\"}', 1, 1, 1, 1, '2024-07-01 16:05:34', '2024-10-09 20:22:12'),
(41, '{\"en\":\"cornrows services\"}', 20.00, 0.00, 'fixed', '{\"en\":null}', '01:00', '{\"en\":\"We provide expert cornrow services to give you a trendy and protective hairstyle. Our talented stylists create intricate and beautiful cornrow patterns tailored to your style, ensuring a look that is both chic and low-maintenance. Embrace your unique style—book your cornrow appointment today!\"}', 1, 1, 1, 2, '2024-07-09 04:37:57', '2024-11-27 22:10:52'),
(42, '{\"en\":\"razor hair style\"}', 290.00, 0.00, 'fixed', '{\"en\":null}', '01:00', '{\"en\":\"We specialize in razor hairstyle services to give you a modern and edgy look. Our skilled stylists use precise razor techniques to create texture and movement in your hair, enhancing your style with a fresh and dynamic finish. Transform your look with a razor cut—book your appointment today!\"}', 1, 1, 1, 1, '2024-08-03 08:57:32', '2024-11-27 22:11:39'),
(47, '{\"en\":\"Bob Bohemian Knotless Braids\"}', 200.00, NULL, 'fixed', '{\"en\":null}', '04:00', '{\"en\":\"<p>Introducing our Bob Bohemian Knotless Braids – a chic and trendy twist \\r\\non a classic hairstyle! At Nikkie Hair we\'re thrilled to offer this \\r\\nunique braiding service that combines the sophistication of a bob \\r\\nhaircut with the bohemian flair of knotless braids.</p>\"}', 1, 1, 1, 3, '2024-11-27 22:04:42', '2024-11-27 22:04:42'),
(48, '{\"en\":\"Medium Box Braids Bob\"}', 200.00, NULL, 'fixed', '{\"en\":null}', '03:00', '{\"en\":\"<p>Our Medium Box Braids Bob Length Hair service offers a professional and \\r\\nstylish look for those wanting a trendy and manageable hairstyle. \\r\\nPerfect for a chic and modern appearance.</p>\"}', 1, 1, 1, 3, '2024-11-27 22:06:35', '2024-11-27 22:06:35'),
(49, '{\"en\":\"Instant Dreadlocks\"}', 250.00, NULL, 'fixed', '{\"en\":null}', '01:00', '{\"en\":\"<p>Introducing our Instant Dreadlocks Service, the ultimate solution for \\r\\nachieving effortlessly cool and stylish dreadlocks in no time! At our \\r\\nsalon, we understand that dreadlocks are not just a hairstyle; they\'re a\\r\\n lifestyle. That\'s why we\'ve perfected a technique that allows you to \\r\\ntransform your hair into stunning dreadlocks instantly, without the \\r\\nwait. With our Instant Dreadlocks Service, you can say goodbye to the \\r\\nmonths-long process of natural dreadlock formation. Our skilled and \\r\\nexperienced stylists use a specialized method to create dreadlocks \\r\\nquickly and efficiently, saving you time and giving you the look you \\r\\ndesire in just one session. Whether you\'re looking to rock a full head \\r\\nof dreadlocks or add some dreadlock extensions for extra length and \\r\\nvolume, we\'ve got you covered.</p>\"}', 1, 1, 1, 3, '2024-11-27 22:08:33', '2024-11-27 22:08:33'),
(50, '{\"en\":\"Hair Retouch\"}', 120.00, NULL, 'fixed', '{\"en\":null}', '02:00', '{\"en\":\"<p>Our Hair Retouch service offers professional touch-ups starting at $120 \\r\\non weekdays. Enhance your look with expert care and precision. Schedule \\r\\nyour appointment today for a flawless finish.</p>\"}', 0, 1, 1, 1, '2024-11-27 22:15:39', '2024-11-27 22:15:39'),
(51, '{\"en\":\"Knotles boho\"}', 250.00, 0.00, 'fixed', NULL, '03', '{\"en\":\"this is for 20 inches curly whatever\"}', 0, 1, 1, 1, '2025-03-26 14:20:07', '2025-03-26 14:20:07'),
(52, '{\"en\":\"Test\"}', 50.00, 5.00, 'hourly', NULL, '01:00', '{\"en\":\"Test\"}', 0, 1, 1, 6, '2025-03-28 17:29:12', '2025-03-28 17:29:12'),
(53, '{\"en\":\"Suku\"}', 200.00, 150.00, 'fixed', NULL, '2:30', '{\"en\":\"suku a Nigerian style\"}', 1, 1, 1, 7, '2025-04-04 19:18:22', '2025-04-04 19:18:22'),
(54, '{\"en\":\"All Back\"}', 50.00, 25.00, 'hourly', NULL, '3:00', '{\"en\":\"All Back Nigerian Style\"}', 1, 1, 1, 7, '2025-04-04 20:46:10', '2025-04-04 20:46:10'),
(55, '{\"en\":\"cornrow hairstyle\"}', 50.00, 0.00, 'fixed', NULL, '2:00', '{\"en\":\"bdbbdndndnfncnncnc\"}', 0, 1, 1, 8, '2025-05-30 11:43:55', '2025-05-30 11:43:55');

-- --------------------------------------------------------

--
-- Table structure for table `e_service_categories`
--

DROP TABLE IF EXISTS `e_service_categories`;
CREATE TABLE `e_service_categories` (
  `e_service_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_service_categories`
--

INSERT INTO `e_service_categories` (`e_service_id`, `category_id`) VALUES
(9, 1),
(40, 1),
(41, 1),
(47, 1),
(48, 1),
(51, 1),
(52, 1),
(53, 1),
(55, 1),
(1, 2),
(49, 2),
(55, 2),
(10, 3),
(55, 3),
(11, 4),
(42, 4),
(54, 4),
(55, 4),
(12, 5),
(55, 5),
(13, 6),
(50, 6),
(55, 6);

-- --------------------------------------------------------

--
-- Table structure for table `e_service_reviews`
--

DROP TABLE IF EXISTS `e_service_reviews`;
CREATE TABLE `e_service_reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci,
  `rate` decimal(3,2) NOT NULL DEFAULT '0.00',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `e_service_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `e_service_reviews`
--

INSERT INTO `e_service_reviews` (`id`, `review`, `rate`, `user_id`, `e_service_id`, `created_at`, `updated_at`) VALUES
(1, 'very talented.  I\'ll recommend', 5.00, 9, 41, '2024-07-09 05:32:18', '2024-07-09 05:32:18'),
(2, 'ttt', 5.00, 10, 40, '2024-07-09 15:48:19', '2024-07-09 15:48:19'),
(3, 'good good good', 5.00, 9, 9, '2024-07-31 23:34:16', '2024-07-31 23:34:16'),
(4, 'nice', 5.00, 9, 1, '2024-08-22 22:52:53', '2024-08-22 22:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` int(10) UNSIGNED NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci,
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `faq_category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `faq_category_id`, `created_at`, `updated_at`) VALUES
(5, '{\"en\":\"<span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">How\\r\\ndoes Ewa handle payment processing for its hairstylists?</span>\"}', '{\"en\":\"<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">Ewa offers convenient and secure payment\\r\\nprocessing for our hairstylists and barbers. Once a service is completed, the\\r\\npayment is automatically processed and deposited into your account. From there,\\r\\nyou can easily withdraw their earnings through various options such as direct\\r\\ndeposit or PayPal. <o:p></o:p></span></p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">&nbsp;</span></p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">This ensures that our professionals have\\r\\nquick and easy access to their hard-earned income, allowing them to focus on\\r\\nwhat they do best - providing top-notch hair services to clients.<o:p></o:p></span></p>\"}', 5, '2024-07-01 16:05:35', '2024-10-16 18:44:21'),
(11, '{\"en\":\"<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">What do I do if my hairstylist cancels the\\r\\nappointment after payment?<o:p></o:p></span></p>\"}', '{\"en\":\"<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">At Ewa, we understand the frustration that\\r\\ncomes with a last-minute cancellation from your hairstylist. If your\\r\\nhairstylist cancels your appointment after payment, please reach out to our\\r\\ncustomer service team immediately. <o:p></o:p></span></p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">&nbsp;</span></p>\\r\\n\\r\\n<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">We will work swiftly to reschedule your\\r\\nappointment with another available stylist or provide a refund for the\\r\\ninconvenience. Our priority is to ensure that you receive the exceptional\\r\\nservice you deserve, and we are committed to making it right. Thank you for\\r\\nchoosing Ewa for your hair needs.<o:p></o:p></span></p>\"}', 3, '2024-07-01 16:05:35', '2024-10-16 18:45:51'),
(18, '{\"en\":\"<span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">Where\\r\\nis Ewa available?</span>\"}', '{\"en\":\"<span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">Ewa\\r\\nis currently available in the United Kingdom, and we have plans on expanding to\\r\\nother countries! Sign up for free now and see how our simple and flexible\\r\\nbooking software can help you achieve financial freedom.&nbsp;</span>\"}', 1, '2024-07-01 16:05:35', '2024-10-16 18:48:04'),
(19, '{\"en\":\"<p><span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">Are\\r\\nall hair stylists on Ewa verified?</span><br></p>\"}', '{\"en\":\"<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">Yes, all hair stylists on Ewa have pass\\r\\nthrough our verification process before they are able to offer their services\\r\\non our platform. <o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">&nbsp;</span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">Our verification process includes security\\r\\nchecks and a review of their professional experience and client feedback. We\\r\\ntake the trust and safety of our clients very seriously, which is why we ensure\\r\\nthat all the hair stylists on Ewa meet our high standards of quality,\\r\\nprofessionalism, and expertise. <o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">&nbsp;</span></p><p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n</p><p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">When you book a hair stylist through Ewa,\\r\\nyou can have confidence that you are working with a verified and reputable\\r\\nprofessional who is dedicated to providing exceptional home-based hair\\r\\nservices.<o:p></o:p></span></p>\"}', 3, '2024-10-16 18:46:56', '2024-10-16 18:46:56'),
(20, '{\"en\":\"<p><span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">Are\\r\\nall prices for hair listed on App fixed?</span><br></p>\"}', '{\"en\":\"<p><span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">At\\r\\nEwa, we understand that every client\'s hair needs are different and unique.\\r\\nAlthough most prices remain the same, there may be a little extra fee for full\\r\\nhair, full length hair or extra services it would take our hairstylists to give\\r\\nyou your desired beautiful look!&nbsp;</span><br></p>\"}', 3, '2024-10-16 18:47:24', '2024-10-16 18:47:24'),
(21, '{\"en\":\"<p><span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">How\\r\\ndo I contact you?</span><br></p>\"}', '{\"en\":\"<p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">For questions on bookings, sign ups,\\r\\npayments, or enquiries, we\'ve some useful answers in this FAQ section for any\\r\\nquestions you might have. If you can’t find the answer you’re looking for and\\r\\nstill need to get in touch, you can use our live chat feature.<o:p></o:p></span></p><p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">&nbsp;</span></p><p>\\r\\n\\r\\n\\r\\n\\r\\n</p><p class=\\\"MsoNormal\\\"><span lang=\\\"EN\\\" style=\\\"font-family:Nunito;mso-fareast-font-family:\\r\\nNunito;mso-bidi-font-family:Nunito\\\">Reach out to us via our Contact us form and\\r\\nwe\'ll get back to you as quickly as we can.<o:p></o:p></span></p>\"}', 1, '2024-10-16 18:48:29', '2024-10-16 18:48:29'),
(22, '{\"en\":\"<p><span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">What\\r\\npayment methods does Ewa accept?</span><br></p>\"}', '{\"en\":\"<p><span lang=\\\"EN\\\" style=\\\"font-size:11.0pt;line-height:\\r\\n115%;font-family:Nunito;mso-fareast-font-family:Nunito;mso-bidi-font-family:\\r\\nNunito;mso-ansi-language:EN;mso-fareast-language:#2000;mso-bidi-language:AR-SA\\\">We\\r\\naccept only credit cards (Visa, Mastercard, American Express), and digital\\r\\npayment platforms such as Apple Pay and Google Pay. Additionally, we also offer\\r\\nthe option for clients to securely store their preferred payment method on file\\r\\nfor seamless and contactless transactions. At Ewa, we prioritize convenience\\r\\nand flexibility for our clients when it comes to payment for our exceptional\\r\\nbeauty services.</span><br></p>\"}', 1, '2024-10-16 18:48:50', '2024-10-16 18:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `faq_categories`
--

DROP TABLE IF EXISTS `faq_categories`;
CREATE TABLE `faq_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '{\"en\":\"About EWA\"}', '2024-07-01 16:05:34', '2024-10-16 18:49:09'),
(3, '{\"en\":\"For Users\"}', '2024-07-01 16:05:34', '2024-10-16 18:34:36'),
(5, '{\"en\":\"For Vendors\"}', '2024-07-01 16:05:34', '2024-10-16 18:34:10');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE `favorites` (
  `id` int(10) UNSIGNED NOT NULL,
  `e_service_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `e_service_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 9, 8, '2024-10-09 20:09:21', '2024-10-09 20:09:21'),
(2, 1, 34, '2025-02-22 00:16:45', '2025-02-22 00:16:45'),
(3, 9, 56, '2025-04-04 04:24:14', '2025-04-04 04:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_options`
--

DROP TABLE IF EXISTS `favorite_options`;
CREATE TABLE `favorite_options` (
  `option_id` int(10) UNSIGNED NOT NULL,
  `favorite_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `e_provider_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `description`, `e_provider_id`, `created_at`, `updated_at`) VALUES
(15, '{\"en\":\"Inventore vel incidunt ipsa rem voluptatem dolore.\"}', 8, '2024-07-01 16:05:34', '2024-07-05 11:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `collection_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'public',
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_properties` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `uuid`, `model_type`, `model_id`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(5, NULL, 'App\\Models\\PaymentMethod', 5, 'logo', 'paypal', 'paypal.png', 'image/png', 'public', 'public', 15819, '[]', '{\"uuid\":\"2b8bd9b8-5c37-4464-a5c7-623496d7655f\",\"user_id\":1,\"generated_conversions\":{\"thumb\":true,\"icon\":true}}', '{\"thumb\":true,\"icon\":true}', '[]', 5, '2024-07-01 16:05:36', '2024-07-01 16:05:36'),
(7, NULL, 'App\\Models\\PaymentMethod', 6, 'logo', 'pay_pickup', 'pay_pickup.png', 'image/png', 'public', 'public', 11712, '[]', '{\"uuid\":\"5e06e7ca-ac33-413c-9ab0-6fd4e3083cc1\",\"user_id\":1,\"generated_conversions\":{\"thumb\":true,\"icon\":true}}', '{\"thumb\":true,\"icon\":true}', '[]', 7, '2024-07-01 16:05:36', '2024-07-01 16:05:36'),
(9, NULL, 'App\\Models\\PaymentMethod', 7, 'logo', 'stripe-logo', 'stripe-logo.png', 'image/png', 'public', 'public', 5436, '[]', '{\"uuid\":\"bd448a36-8a5e-4c85-8d6e-c356843429c8\",\"user_id\":1,\"generated_conversions\":{\"thumb\":true,\"icon\":true}}', '{\"thumb\":true,\"icon\":true}', '[]', 9, '2024-07-01 16:05:36', '2024-07-01 16:05:36'),
(10, NULL, 'App\\Models\\PaymentMethod', 9, 'logo', 'flutterwave', 'flutterwave.png', 'image/png', 'public', 'public', 5436, '[]', '{\"uuid\":\"bd558a96-8a5e-4a85-8d6e-c456648429c8\",\"user_id\":1,\"generated_conversions\":{\"thumb\":true,\"icon\":true}}', '{\"thumb\":true,\"icon\":true}', '[]', 10, '2024-07-01 16:05:36', '2024-07-01 16:05:36'),
(11, NULL, 'App\\Models\\PaymentMethod', 8, 'logo', 'paystack', 'paystack.png', 'image/png', 'public', 'public', 5436, '[]', '{\"uuid\":\"bd448a96-8a5e-4c85-8d6e-c356648429c8\",\"user_id\":1,\"generated_conversions\":{\"thumb\":true,\"icon\":true}}', '{\"thumb\":true,\"icon\":true}', '[]', 11, '2024-07-01 16:05:36', '2024-07-01 16:05:36'),
(13, NULL, 'App\\Models\\PaymentMethod', 11, 'logo', 'wallet', 'wallet.png', 'image/png', 'public', 'public', 5436, '[]', '{\"uuid\":\"bd558a84-8a5e-4b85-8d6f-c456648429c8\",\"user_id\":1,\"generated_conversions\":{\"thumb\":true,\"icon\":true}}', '{\"thumb\":true,\"icon\":true}', '[]', 12, '2024-07-01 16:05:36', '2024-07-01 16:05:36'),
(15, '619e00a5-eff0-4a30-bdb7-5a735dbf3f63', 'App\\Models\\Upload', 1, 'app_logo', 'EWA logo 2', 'EWA-logo-2.png', 'image/png', 'public', 'public', 131526, '[]', '{\"uuid\":\"8853bb7c-e1e7-4c90-aca9-92058f55dae3\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-01 23:07:24', '2024-07-01 23:07:25'),
(16, 'c324a4de-2e02-4bf0-ac57-a71ec4333eab', 'App\\Models\\Upload', 2, 'image', 'hair-straightening', 'hair-straightening.png', 'image/png', 'public', 'public', 75248, '[]', '{\"uuid\":\"d86f7491-f15f-406a-bedb-e72c45102bf9\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:45:55', '2024-07-02 17:45:55'),
(17, '75900831-3440-4f35-a2bd-1ad3635b528b', 'App\\Models\\Category', 6, 'image', 'hair-straightening', 'hair-straightening.png', 'image/png', 'public', 'public', 75248, '[]', '{\"uuid\":\"d86f7491-f15f-406a-bedb-e72c45102bf9\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:45:58', '2024-07-02 17:45:58'),
(18, '9140d802-bca4-41aa-8f50-15048725c20a', 'App\\Models\\Upload', 3, 'image', 'braids', 'braids.png', 'image/png', 'public', 'public', 76463, '[]', '{\"uuid\":\"273553e7-8274-41dc-87f7-8fee20f23107\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:46:54', '2024-07-02 17:46:54'),
(20, '187e7f2b-db4a-48fa-bac6-52cf283577cc', 'App\\Models\\Upload', 4, 'image', 'braid', 'braid.png', 'image/png', 'public', 'public', 21782, '[]', '{\"uuid\":\"22118f18-e3ae-4740-81f4-b328f122ae81\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:49:00', '2024-07-02 17:49:00'),
(21, '413163cc-d111-4ee9-a567-8bfda23cdc88', 'App\\Models\\Category', 2, 'image', 'braid', 'braid.png', 'image/png', 'public', 'public', 21782, '[]', '{\"uuid\":\"22118f18-e3ae-4740-81f4-b328f122ae81\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:49:12', '2024-07-02 17:49:12'),
(22, '36318694-5792-4e43-896c-8fecc005c744', 'App\\Models\\Upload', 5, 'image', 'wig', 'wig.png', 'image/png', 'public', 'public', 72733, '[]', '{\"uuid\":\"8ab76634-450c-4ea3-addb-e016e98bc857\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:50:58', '2024-07-02 17:50:58'),
(23, 'b37c90cc-6ff4-4d63-8442-ad6348a2352b', 'App\\Models\\Category', 3, 'image', 'wig', 'wig.png', 'image/png', 'public', 'public', 72733, '[]', '{\"uuid\":\"8ab76634-450c-4ea3-addb-e016e98bc857\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:51:00', '2024-07-02 17:51:00'),
(24, '6f02f9dd-9d19-4a87-bee1-1fd35f58a507', 'App\\Models\\Upload', 6, 'image', 'shampoo', 'shampoo.png', 'image/png', 'public', 'public', 61437, '[]', '{\"uuid\":\"af6e73dd-d3fd-424d-bcac-516ed5c0df42\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:53:04', '2024-07-02 17:53:04'),
(25, 'b901dd8d-fcf8-43fc-adde-faf8ee619531', 'App\\Models\\Category', 5, 'image', 'shampoo', 'shampoo.png', 'image/png', 'public', 'public', 61437, '[]', '{\"uuid\":\"af6e73dd-d3fd-424d-bcac-516ed5c0df42\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:53:06', '2024-07-02 17:53:06'),
(26, '85ec6e5f-7bcb-48c8-b8a5-3418e3db39de', 'App\\Models\\Upload', 7, 'image', 'women', 'women.png', 'image/png', 'public', 'public', 84583, '[]', '{\"uuid\":\"dc669e10-da9f-40e1-8ed7-599f94125d96\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:53:19', '2024-07-02 17:53:19'),
(27, '373503d3-2ead-45b9-9f1e-8210fabb3153', 'App\\Models\\Category', 4, 'image', 'women', 'women.png', 'image/png', 'public', 'public', 84583, '[]', '{\"uuid\":\"dc669e10-da9f-40e1-8ed7-599f94125d96\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-02 17:53:23', '2024-07-02 17:53:23'),
(28, '72fca251-7de3-453c-b20a-3261bd956a47', 'App\\Models\\Upload', 8, 'image', '1', '1.jpg', 'image/jpeg', 'public', 'public', 171138, '[]', '{\"uuid\":\"ce88129d-1242-4ca0-89cb-640b767defef\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 08:16:22', '2024-07-03 08:16:23'),
(29, '786e3778-da4c-4516-9f8d-27a48b6ff909', 'App\\Models\\Slide', 1, 'image', '1', '1.jpg', 'image/jpeg', 'public', 'public', 171138, '[]', '{\"uuid\":\"ce88129d-1242-4ca0-89cb-640b767defef\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 08:16:42', '2024-07-03 08:16:42'),
(30, 'a5ca51e1-2989-48aa-ac76-1110dab253cc', 'App\\Models\\Upload', 9, 'image', '2', '2.jpg', 'image/jpeg', 'public', 'public', 127360, '[]', '{\"uuid\":\"b61b740f-a51d-41cf-83cb-4f431e52067f\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 08:16:59', '2024-07-03 08:16:59'),
(31, '1ee77173-fecd-4452-922c-bb26d5cfce2d', 'App\\Models\\Slide', 2, 'image', '2', '2.jpg', 'image/jpeg', 'public', 'public', 127360, '[]', '{\"uuid\":\"b61b740f-a51d-41cf-83cb-4f431e52067f\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 08:17:06', '2024-07-03 08:17:06'),
(32, '1451d054-863f-4da7-b207-e8962a8d80e0', 'App\\Models\\Upload', 10, 'image', '3', '3.jpg', 'image/jpeg', 'public', 'public', 168456, '[]', '{\"uuid\":\"b944fd12-ed53-4d75-9bcd-9224cafad54c\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 08:17:17', '2024-07-03 08:17:17'),
(33, '1dd1ff18-3fe9-40ed-9e3e-acf88489e5e2', 'App\\Models\\Slide', 3, 'image', '3', '3.jpg', 'image/jpeg', 'public', 'public', 168456, '[]', '{\"uuid\":\"b944fd12-ed53-4d75-9bcd-9224cafad54c\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 08:17:24', '2024-07-03 08:17:24'),
(34, '17497d89-9b40-4379-b3b2-5ebdc942a7d3', 'App\\Models\\Upload', 11, 'image', 'hair', 'hair.jpg', 'image/jpeg', 'public', 'public', 27139, '[]', '{\"uuid\":\"a88e3c30-f519-40d1-8c75-eec78b46d40a\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 21:44:05', '2024-07-03 21:44:06'),
(35, '59793144-6a88-431f-8178-b7e90292bdf7', 'App\\Models\\EService', 1, 'image', 'hair', 'hair.jpg', 'image/jpeg', 'public', 'public', 27139, '[]', '{\"uuid\":\"a88e3c30-f519-40d1-8c75-eec78b46d40a\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 21:44:09', '2024-07-03 21:44:09'),
(36, '657918eb-4d60-409e-b786-7b70aba70464', 'App\\Models\\Upload', 12, 'image', 'braids', 'braids.png', 'image/png', 'public', 'public', 79435, '[]', '{\"uuid\":\"f2ebb61a-c64d-4788-943a-f67ff13074fc\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 22:56:13', '2024-07-03 22:56:13'),
(38, '04e4871b-8833-4a42-ae41-d1cfdafe5179', 'App\\Models\\Upload', 13, 'image', 'braids', 'braids.png', 'image/png', 'public', 'public', 75842, '[]', '{\"uuid\":\"af900489-b616-4cc2-931d-e7aec11c15a1\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 23:03:00', '2024-07-03 23:03:01'),
(39, '692bff10-6db5-4873-b5db-b4c781b75460', 'App\\Models\\Category', 1, 'image', 'braids', 'braids.png', 'image/png', 'public', 'public', 75842, '[]', '{\"uuid\":\"af900489-b616-4cc2-931d-e7aec11c15a1\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-03 23:03:04', '2024-07-03 23:03:04'),
(40, '7ac4762a-2484-4ff5-bb87-e2a1af96fbec', 'App\\Models\\Upload', 14, 'avatar', 'scaled_1000614051', 'scaled_1000614051.jpg', 'image/jpeg', 'public', 'public', 436082, '[]', '{\"uuid\":\"603b8c4f-b7a4-476a-be2c-a8dc9537ff20\",\"user_id\":9}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-04 11:01:37', '2024-07-04 11:01:38'),
(41, '2439a312-f081-4371-90ac-c512140d182c', 'App\\Models\\User', 9, 'avatar', 'scaled_1000614051', 'scaled_1000614051.jpg', 'image/jpeg', 'public', 'public', 436082, '[]', '{\"uuid\":\"603b8c4f-b7a4-476a-be2c-a8dc9537ff20\",\"user_id\":9}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-04 11:03:03', '2024-07-04 11:03:04'),
(42, 'd12e6fa9-77c7-4f3c-b59a-cad20760f51e', 'App\\Models\\Upload', 15, 'image', 'scaled_1000485284', 'scaled_1000485284.jpg', 'image/jpeg', 'public', 'public', 86854, '[]', '{\"uuid\":\"a81e3086-070b-4804-8eb0-18fe5783b2b1\",\"user_id\":11}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-09 04:25:51', '2024-07-09 04:25:52'),
(45, 'a0d00889-74ec-48e2-8f15-e1dcb183adc3', 'App\\Models\\Upload', 16, 'image', 'scaled_1000642331', 'scaled_1000642331.jpg', 'image/jpeg', 'public', 'public', 36203, '[]', '{\"uuid\":\"6142bb46-e398-47ca-b9d1-18be305f409c\",\"user_id\":11}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-07-09 04:37:02', '2024-07-09 04:37:02'),
(47, 'a54f2c6c-89ce-4e01-b282-ebf1f689185f', 'App\\Models\\Upload', 17, 'image', 'scaled_1000022320', 'scaled_1000022320.webp', 'image/jpeg', 'public', 'public', 89241, '[]', '{\"uuid\":\"c2b4218c-af3f-4177-b06d-a1701ae6ad74\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-03 08:47:21', '2024-08-03 08:47:21'),
(49, 'bcbc0c3c-65cb-4a0d-89f9-13c45f2b11d6', 'App\\Models\\Upload', 18, 'logo', 'google-pay-mark', 'google-pay-mark.png', 'image/png', 'public', 'public', 34146, '[]', '{\"uuid\":\"7f30fcdc-326a-4104-ad71-fcf1807aff29\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-10 20:23:48', '2024-08-10 20:23:48'),
(50, '8059fc40-1975-4097-aa48-f5aad418daef', 'App\\Models\\Upload', 19, 'logo', 'google-pay-mark', 'google-pay-mark.png', 'image/png', 'public', 'public', 34146, '[]', '{\"uuid\":\"716db4f7-8e4d-4e39-8b94-ccbb2c171da5\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-10 20:23:59', '2024-08-10 20:23:59'),
(52, 'ff994767-78e0-4424-9255-a050f61c4973', 'App\\Models\\Upload', 20, 'logo', 'apple-pay-og-twitter', 'apple-pay-og-twitter.jpg', 'image/jpeg', 'public', 'public', 33510, '[]', '{\"uuid\":\"7c2ce75a-78b4-410e-a50b-03d964167806\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-10 20:25:22', '2024-08-10 20:25:23'),
(54, '6c73f5ff-17fd-4340-ae6a-ee58ff40f222', 'App\\Models\\Upload', 21, 'logo', 'apple-pay_v49n', 'apple-pay_v49n.png', 'image/png', 'public', 'public', 6666, '[]', '{\"uuid\":\"4b76e35d-d8c9-4d93-a593-d5c3b7bf01ce\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-10 20:37:58', '2024-08-10 20:37:58'),
(56, 'ced0df45-756b-468c-be45-f5bb9598110a', 'App\\Models\\Upload', 22, 'logo', 'unnamed', 'unnamed.jpg', 'image/jpeg', 'public', 'public', 7431, '[]', '{\"uuid\":\"9c91c7f8-8144-40ae-af8c-3b638b75df13\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-10 20:38:04', '2024-08-10 20:38:04'),
(58, '4596410a-f50d-4bae-9ed8-972d33349f0f', 'App\\Models\\Upload', 23, 'logo', 'unnamed', 'unnamed.jpg', 'image/jpeg', 'public', 'public', 7431, '[]', '{\"uuid\":\"62ba0aac-a8c8-414a-a3da-b5c0e012e28b\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-10 20:38:35', '2024-08-10 20:38:35'),
(60, '76e32fed-0d19-4fac-9e84-1a5ca2a72947', 'App\\Models\\Upload', 24, 'logo', 'apple-pay_v49n', 'apple-pay_v49n.png', 'image/png', 'public', 'public', 6666, '[]', '{\"uuid\":\"8e5765e7-8d11-40a2-a684-79b9dd636d17\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-10 20:38:43', '2024-08-10 20:38:43'),
(62, '099eb83a-fc76-4b9a-8632-5139452b0ccb', 'App\\Models\\Upload', 25, 'image', 'scaled_1000057962', 'scaled_1000057962.jpg', 'image/jpeg', 'public', 'public', 1840576, '[]', '{\"uuid\":\"f7e9405f-3d12-46ca-85bd-271a500f400a\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-22 23:14:45', '2024-08-22 23:14:47'),
(64, '3cc7eea8-dbbb-4099-88f6-fbdca3ee3b88', 'App\\Models\\Upload', 26, 'image', 'scaled_1000057962', 'scaled_1000057962.jpg', 'image/jpeg', 'public', 'public', 1840576, '[]', '{\"uuid\":\"32dc4e24-6117-49c1-9f4b-021122d9e08f\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-22 23:20:55', '2024-08-22 23:20:58'),
(66, 'b85db20f-0c8a-4671-81b9-ce5909327141', 'App\\Models\\Upload', 27, 'image', 'scaled_1000078947', 'scaled_1000078947.jpg', 'image/jpeg', 'public', 'public', 154172, '[]', '{\"uuid\":\"56573f59-1db9-4970-8026-53dddc093f76\",\"user_id\":11}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-29 16:45:07', '2024-08-29 16:45:08'),
(68, '4abf2a56-642b-402c-b6f4-ca6bf7caa12b', 'App\\Models\\Upload', 28, 'image', 'scaled_1000070009', 'scaled_1000070009.jpg', 'image/jpeg', 'public', 'public', 802870, '[]', '{\"uuid\":\"f4c1829c-3463-4061-9178-ae729fea7a35\",\"user_id\":11}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-29 16:46:28', '2024-08-29 16:46:30'),
(70, 'bd524199-2192-42b9-989f-372294b212e4', 'App\\Models\\Upload', 29, 'image', 'scaled_1000078947', 'scaled_1000078947.jpg', 'image/jpeg', 'public', 'public', 154172, '[]', '{\"uuid\":\"1737f83b-48e8-4125-a2fe-ddabdd26f382\",\"user_id\":11}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-29 16:51:33', '2024-08-29 16:51:33'),
(71, '91342494-a049-4fe2-a30e-2f02062936ee', 'App\\Models\\Upload', 30, 'image', 'scaled_1000069981', 'scaled_1000069981.jpg', 'image/jpeg', 'public', 'public', 939557, '[]', '{\"uuid\":\"d36eac3c-1b51-48ed-84c0-41a1fecff0a5\",\"user_id\":11}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-08-29 16:51:44', '2024-08-29 16:51:45'),
(74, '8096d80f-fc63-4e04-84f5-4ea0586c1845', 'App\\Models\\Upload', 31, 'image', 'snapinsta-5-qce1b674s8adfg8yjm27z5pygc2nx18zlgazri3cem', 'snapinsta-5-qce1b674s8adfg8yjm27z5pygc2nx18zlgazri3cem.jpg', 'image/jpeg', 'public', 'public', 74211, '[]', '{\"uuid\":\"869e1870-f052-4b96-99bb-b16cd3ebea82\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 20:58:59', '2024-10-08 20:58:59'),
(75, 'b3eea188-33a7-4f39-b820-43113353605f', 'App\\Models\\EService', 9, 'image', 'snapinsta-5-qce1b674s8adfg8yjm27z5pygc2nx18zlgazri3cem', 'snapinsta-5-qce1b674s8adfg8yjm27z5pygc2nx18zlgazri3cem.jpg', 'image/jpeg', 'public', 'public', 74211, '[]', '{\"uuid\":\"869e1870-f052-4b96-99bb-b16cd3ebea82\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 20:59:01', '2024-10-08 20:59:02'),
(76, '45998166-0036-43e0-bf34-06d0b002be92', 'App\\Models\\Upload', 32, 'image', 'b2dd232f-3a2d-4399-8627-1f4b856fa850', 'b2dd232f-3a2d-4399-8627-1f4b856fa850.jpg', 'image/jpeg', 'public', 'public', 117154, '[]', '{\"uuid\":\"fca18d8e-c864-42ef-b542-928f026ba6d8\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:22:02', '2024-10-08 21:22:02'),
(77, 'b4273a57-e9ce-41f7-833c-acbe2ab40536', 'App\\Models\\EService', 41, 'image', 'b2dd232f-3a2d-4399-8627-1f4b856fa850', 'b2dd232f-3a2d-4399-8627-1f4b856fa850.jpg', 'image/jpeg', 'public', 'public', 117154, '[]', '{\"uuid\":\"fca18d8e-c864-42ef-b542-928f026ba6d8\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:22:04', '2024-10-08 21:22:04'),
(78, 'bda3da55-0b30-4eb8-9149-c56d71e69318', 'App\\Models\\Upload', 33, 'image', '2-pastel-purple-and-silver-layered-bob', '2-pastel-purple-and-silver-layered-bob.jpg', 'image/png', 'public', 'public', 315650, '[]', '{\"uuid\":\"7b4b4103-8da5-48f8-81f6-06741a96add0\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:24:36', '2024-10-08 21:24:36'),
(79, '1396101c-563d-4623-a0e5-240e72d56f1e', 'App\\Models\\EService', 42, 'image', '2-pastel-purple-and-silver-layered-bob', '2-pastel-purple-and-silver-layered-bob.jpg', 'image/png', 'public', 'public', 315650, '[]', '{\"uuid\":\"7b4b4103-8da5-48f8-81f6-06741a96add0\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:24:38', '2024-10-08 21:24:38'),
(80, 'ebaf771b-5453-44be-9a99-d629996fe014', 'App\\Models\\Upload', 34, 'image', '50392BC8-C1F8-4FBE-8DC6-CC77C9559ABF', '50392BC8-C1F8-4FBE-8DC6-CC77C9559ABF.jpg', 'image/png', 'public', 'public', 1067134, '[]', '{\"uuid\":\"e3883b97-3668-4387-8c09-82e822bf7251\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:24:47', '2024-10-08 21:24:47'),
(81, 'e1a0b20a-e4ca-4637-ae1f-e1e139d06601', 'App\\Models\\EService', 10, 'image', '50392BC8-C1F8-4FBE-8DC6-CC77C9559ABF', '50392BC8-C1F8-4FBE-8DC6-CC77C9559ABF.jpg', 'image/png', 'public', 'public', 1067134, '[]', '{\"uuid\":\"e3883b97-3668-4387-8c09-82e822bf7251\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:24:50', '2024-10-08 21:24:50'),
(82, 'b098bf10-7a7b-4ef7-8d60-c290a9ea83fe', 'App\\Models\\Upload', 35, 'image', 'perm-hairstyles-featured', 'perm-hairstyles-featured.jpg', 'image/png', 'public', 'public', 1223747, '[]', '{\"uuid\":\"660c9df0-f8f0-401a-83ca-9a529e618103\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:26:32', '2024-10-08 21:26:32'),
(83, 'ef01f66f-0a90-4e71-9dc8-a14ca531b346', 'App\\Models\\EService', 11, 'image', 'perm-hairstyles-featured', 'perm-hairstyles-featured.jpg', 'image/png', 'public', 'public', 1223747, '[]', '{\"uuid\":\"660c9df0-f8f0-401a-83ca-9a529e618103\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:26:34', '2024-10-08 21:26:34'),
(84, '48ff7600-3366-4f60-a53f-447a5b8395ca', 'App\\Models\\Upload', 36, 'image', 'f444f3b807363d8eb0a0acc89e89a727_screen', 'f444f3b807363d8eb0a0acc89e89a727_screen.jpg', 'image/jpeg', 'public', 'public', 103372, '[]', '{\"uuid\":\"e01d8947-07ec-46a9-9c93-e17c43328f30\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:27:53', '2024-10-08 21:27:53'),
(85, '0b58eb57-b92a-4274-a4f3-ee0a4029cbcf', 'App\\Models\\EService', 12, 'image', 'f444f3b807363d8eb0a0acc89e89a727_screen', 'f444f3b807363d8eb0a0acc89e89a727_screen.jpg', 'image/jpeg', 'public', 'public', 103372, '[]', '{\"uuid\":\"e01d8947-07ec-46a9-9c93-e17c43328f30\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:27:55', '2024-10-08 21:27:55'),
(86, '5a7d38e9-7d25-4ac3-8fc6-b2c853e6dabe', 'App\\Models\\Upload', 37, 'image', 'hair-straightening-treatments-featured', 'hair-straightening-treatments-featured.jpg', 'image/png', 'public', 'public', 1121740, '[]', '{\"uuid\":\"5639d889-0724-4f58-9081-b5c40493b2a3\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:28:48', '2024-10-08 21:28:48'),
(87, '3387bec0-cfd8-4005-93a9-1fb0ec89bcec', 'App\\Models\\EService', 13, 'image', 'hair-straightening-treatments-featured', 'hair-straightening-treatments-featured.jpg', 'image/png', 'public', 'public', 1121740, '[]', '{\"uuid\":\"5639d889-0724-4f58-9081-b5c40493b2a3\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:28:50', '2024-10-08 21:28:51'),
(88, 'cb1818ae-5b96-4c79-bb76-e7512a450b30', 'App\\Models\\Upload', 38, 'image', 'heartcornrows-516c2d6d14bc41f880ca2a3d6161082c', 'heartcornrows-516c2d6d14bc41f880ca2a3d6161082c.png', 'image/png', 'public', 'public', 906302, '[]', '{\"uuid\":\"02408e45-e1cd-40ab-a178-a45cc166dea1\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:29:46', '2024-10-08 21:29:46'),
(89, 'd0f2e5f9-2574-4d9d-bfdd-d5637f119448', 'App\\Models\\EService', 40, 'image', 'heartcornrows-516c2d6d14bc41f880ca2a3d6161082c', 'heartcornrows-516c2d6d14bc41f880ca2a3d6161082c.png', 'image/png', 'public', 'public', 906302, '[]', '{\"uuid\":\"02408e45-e1cd-40ab-a178-a45cc166dea1\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:29:48', '2024-10-08 21:29:48'),
(90, '805659fd-bf95-475e-90c6-0121d1bb5e57', 'App\\Models\\Upload', 39, 'image', 'Screenshot 2024-10-08 at 3.32.54 PM', 'Screenshot-2024-10-08-at-3.32.54 PM.png', 'image/png', 'public', 'public', 34228, '[]', '{\"uuid\":\"e59707f4-d0a0-4ff8-baef-bd28d222d862\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:33:04', '2024-10-08 21:33:05'),
(91, '7d94821d-5e5f-405b-a72a-f6666597322f', 'App\\Models\\EProvider', 1, 'image', 'Screenshot 2024-10-08 at 3.32.54 PM', 'Screenshot-2024-10-08-at-3.32.54 PM.png', 'image/png', 'public', 'public', 34228, '[]', '{\"uuid\":\"e59707f4-d0a0-4ff8-baef-bd28d222d862\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-08 21:33:06', '2024-10-08 21:33:06'),
(92, '8a7154f2-5122-449f-a7b3-82c9fa964f13', 'App\\Models\\Upload', 40, 'avatar', 'user-4', 'user-4.jpg', 'image/jpeg', 'public', 'public', 8398933, '[]', '{\"uuid\":\"b94b6e80-212a-46bf-95d3-b4ab542cc549\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:40:48', '2024-10-24 19:40:51'),
(93, '302d2b0c-6e7c-4a33-a082-0b54537e9128', 'App\\Models\\Upload', 41, 'avatar', 'user-1', 'user-1.jpg', 'image/jpeg', 'public', 'public', 838175, '[]', '{\"uuid\":\"57366277-173a-48ae-ab9b-6631b58743db\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:40:48', '2024-10-24 19:40:48'),
(94, '6558b954-31a6-4ae7-9fb7-5fae5cfdd6f8', 'App\\Models\\Upload', 42, 'avatar', 'user-2', 'user-2.jpg', 'image/jpeg', 'public', 'public', 190948, '[]', '{\"uuid\":\"e884919e-b021-42c0-8184-f38ce333b0b8\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:40:51', '2024-10-24 19:40:52'),
(95, '6268dd70-150f-4867-b660-af07f02c2aa1', 'App\\Models\\Upload', 43, 'avatar', 'user-8', 'user-8.jpg', 'image/jpeg', 'public', 'public', 1829586, '[]', '{\"uuid\":\"64f4f88c-d3d3-4bd5-8e21-6f803bc37833\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:40:58', '2024-10-24 19:41:01'),
(96, '0046808d-2339-4eae-b49a-b7beceed25b1', 'App\\Models\\Upload', 44, 'avatar', 'user-10', 'user-10.jpg', 'image/jpeg', 'public', 'public', 1565730, '[]', '{\"uuid\":\"fc23fbbe-e25a-4f40-a9b8-60a2ac131f15\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:02', '2024-10-24 19:41:05'),
(97, '3b380a81-8aa9-4c4b-a595-da49d522752d', 'App\\Models\\Upload', 45, 'avatar', 'user-11', 'user-11.jpg', 'image/jpeg', 'public', 'public', 160538, '[]', '{\"uuid\":\"2e918423-211b-4430-8194-4c5397430497\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:05', '2024-10-24 19:41:05'),
(98, '70c8c465-4777-4509-87fc-b6abda4d27c0', 'App\\Models\\Upload', 46, 'avatar', 'user-12', 'user-12.jpg', 'image/jpeg', 'public', 'public', 1271922, '[]', '{\"uuid\":\"7fcd04a2-d6be-47c1-8537-a4d3f56491ed\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:10', '2024-10-24 19:41:13'),
(99, '20d0b77d-bece-436e-bf39-29f494bee2ee', 'App\\Models\\Upload', 47, 'avatar', 'user-13', 'user-13.jpg', 'image/jpeg', 'public', 'public', 841140, '[]', '{\"uuid\":\"4601a807-64b7-40c0-ad29-e966c722abc5\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:14', '2024-10-24 19:41:15'),
(100, '04369766-d805-4915-a2c8-aadaa86950b0', 'App\\Models\\Upload', 48, 'avatar', 'user-14', 'user-14.jpg', 'image/jpeg', 'public', 'public', 814074, '[]', '{\"uuid\":\"51ebee87-c839-4627-b9d2-22363042c2c6\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:18', '2024-10-24 19:41:22'),
(101, '4d225962-886e-4ab5-ad74-376e698a99b2', 'App\\Models\\Upload', 49, 'avatar', 'user-15', 'user-15.jpg', 'image/jpeg', 'public', 'public', 851116, '[]', '{\"uuid\":\"d53f824e-0097-4b13-94ef-fa950d279d15\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:22', '2024-10-24 19:41:25'),
(102, '888aeb5c-0172-457a-bb4d-ce9b62a222da', 'App\\Models\\Upload', 50, 'avatar', 'user-16', 'user-16.jpg', 'image/jpeg', 'public', 'public', 1875101, '[]', '{\"uuid\":\"ae0d34ea-428f-4655-b78d-278407775e54\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:29', '2024-10-24 19:41:32'),
(103, '029905ae-ad5e-4115-b39a-5634a5cfdd4a', 'App\\Models\\Upload', 51, 'avatar', 'user-3', 'user-3.jpg', 'image/jpeg', 'public', 'public', 4717966, '[]', '{\"uuid\":\"0a349330-06cf-4345-a645-b3f1349fe387\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:39', '2024-10-24 19:41:41'),
(104, '66a572fa-263c-4dee-a645-cab291548fe7', 'App\\Models\\Upload', 52, 'avatar', 'user-13', 'user-13.jpg', 'image/jpeg', 'public', 'public', 841140, '[]', '{\"uuid\":\"2ae5fec2-fa29-4a87-a454-55dc973e2a49\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:46', '2024-10-24 19:41:48'),
(105, '2177ccce-9908-497e-a00a-6b27dc0aae4c', 'App\\Models\\Upload', 53, 'avatar', 'user-5', 'user-5.jpg', 'image/jpeg', 'public', 'public', 254499, '[]', '{\"uuid\":\"9024bb6f-1be3-4533-9669-bbab457b5358\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:52', '2024-10-24 19:41:52'),
(106, '02d97593-71ef-435a-b6cd-3fc9ff849b5b', 'App\\Models\\User', 10, 'avatar', 'user-4', 'user-4.jpg', 'image/jpeg', 'public', 'public', 8398933, '[]', '{\"uuid\":\"b94b6e80-212a-46bf-95d3-b4ab542cc549\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:56', '2024-10-24 19:41:59'),
(107, 'c338e298-0ec2-414a-990f-16afc6b42743', 'App\\Models\\User', 10, 'avatar', 'user-4', 'user-4.jpg', 'image/jpeg', 'public', 'public', 8398933, '[]', '{\"uuid\":\"b94b6e80-212a-46bf-95d3-b4ab542cc549\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:41:59', '2024-10-24 19:42:02'),
(108, 'c689f1cb-10e9-4dea-8eb2-5ceeb363d8cc', 'App\\Models\\User', 8, 'avatar', 'user-1', 'user-1.jpg', 'image/jpeg', 'public', 'public', 838175, '[]', '{\"uuid\":\"57366277-173a-48ae-ab9b-6631b58743db\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:42:07', '2024-10-24 19:42:07'),
(109, 'c6aebf29-820e-4752-97fe-9b44c8c41cca', 'App\\Models\\User', 7, 'avatar', 'user-2', 'user-2.jpg', 'image/jpeg', 'public', 'public', 190948, '[]', '{\"uuid\":\"e884919e-b021-42c0-8184-f38ce333b0b8\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:42:20', '2024-10-24 19:42:20'),
(110, 'e04a57d4-1e34-4094-a881-8daa22b4fb94', 'App\\Models\\Upload', 54, 'avatar', 'user-9', 'user-9.jpg', 'image/jpeg', 'public', 'public', 1997815, '[]', '{\"uuid\":\"9888f190-1456-4cee-b203-59648782c5ac\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:42:43', '2024-10-24 19:42:46'),
(111, 'f64c8685-b367-4c6f-a223-2910c799ef08', 'App\\Models\\User', 6, 'avatar', 'user-9', 'user-9.jpg', 'image/jpeg', 'public', 'public', 1997815, '[]', '{\"uuid\":\"9888f190-1456-4cee-b203-59648782c5ac\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:42:49', '2024-10-24 19:42:52'),
(112, '54796594-c3d1-4f02-a159-8d86432b7be8', 'App\\Models\\User', 5, 'avatar', 'user-10', 'user-10.jpg', 'image/jpeg', 'public', 'public', 1565730, '[]', '{\"uuid\":\"fc23fbbe-e25a-4f40-a9b8-60a2ac131f15\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:43:02', '2024-10-24 19:43:05'),
(113, '75d4f3cd-1958-4833-bab1-0e72c8af9055', 'App\\Models\\User', 4, 'avatar', 'user-11', 'user-11.jpg', 'image/jpeg', 'public', 'public', 160538, '[]', '{\"uuid\":\"2e918423-211b-4430-8194-4c5397430497\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:43:18', '2024-10-24 19:43:19'),
(114, 'a978598b-8585-4b0b-b500-b0940bde466f', 'App\\Models\\User', 3, 'avatar', 'user-12', 'user-12.jpg', 'image/jpeg', 'public', 'public', 1271922, '[]', '{\"uuid\":\"7fcd04a2-d6be-47c1-8537-a4d3f56491ed\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:43:21', '2024-10-24 19:43:24'),
(115, '92d59bc3-cdb6-4181-9c5b-a0f197606c68', 'App\\Models\\User', 2, 'avatar', 'user-13', 'user-13.jpg', 'image/jpeg', 'public', 'public', 841140, '[]', '{\"uuid\":\"4601a807-64b7-40c0-ad29-e966c722abc5\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:43:24', '2024-10-24 19:43:25'),
(117, '20c3be1c-f41f-45c9-b58d-7d4e91381228', 'App\\Models\\Upload', 55, 'avatar', 'user-16', 'user-16.jpg', 'image/jpeg', 'public', 'public', 1875101, '[]', '{\"uuid\":\"06a78516-2745-439d-94cb-a6d5e3f981cf\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:44:52', '2024-10-24 19:44:55'),
(118, 'b8fc9ffd-3df0-4553-8697-a4614e20117f', 'App\\Models\\Upload', 56, 'avatar', 'user-15', 'user-15.jpg', 'image/jpeg', 'public', 'public', 851116, '[]', '{\"uuid\":\"9a8e1043-26bf-4be2-8794-944b267aa5a7\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:44:55', '2024-10-24 19:44:57'),
(119, 'c0d0a407-08a4-4588-8f19-8f29c83e4fd6', 'App\\Models\\Upload', 57, 'avatar', 'user-14', 'user-14.jpg', 'image/jpeg', 'public', 'public', 814074, '[]', '{\"uuid\":\"91d0ce35-9c59-40f2-ac13-c8305b6d6eb6\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:44:59', '2024-10-24 19:45:03'),
(120, '3ef5aec3-6d7e-46dc-add1-aa1438b8c5b3', 'App\\Models\\Upload', 58, 'avatar', 'user-13', 'user-13.jpg', 'image/jpeg', 'public', 'public', 841140, '[]', '{\"uuid\":\"553b8573-bf7f-4ac5-9799-fc4e409ec4ff\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:45:03', '2024-10-24 19:45:04'),
(121, 'c58f4eaf-c2db-4da9-8821-af257f3312bd', 'App\\Models\\Upload', 59, 'avatar', 'user-12', 'user-12.jpg', 'image/jpeg', 'public', 'public', 1271922, '[]', '{\"uuid\":\"f1642a90-cf02-459d-a7c0-c1033283d6ee\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:45:08', '2024-10-24 19:45:11'),
(122, '3acaf30f-01fa-4af4-aa3a-d5e1a9b36e4b', 'App\\Models\\User', 11, 'avatar', 'user-12', 'user-12.jpg', 'image/jpeg', 'public', 'public', 1271922, '[]', '{\"uuid\":\"f1642a90-cf02-459d-a7c0-c1033283d6ee\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:45:13', '2024-10-24 19:45:16'),
(123, 'd005a684-b675-4aaf-aa9a-27e7fcea4504', 'App\\Models\\User', 13, 'avatar', 'user-13', 'user-13.jpg', 'image/jpeg', 'public', 'public', 841140, '[]', '{\"uuid\":\"553b8573-bf7f-4ac5-9799-fc4e409ec4ff\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:45:16', '2024-10-24 19:45:17'),
(124, '5c900ec9-83e0-43f0-bc6d-bc560f344863', 'App\\Models\\User', 14, 'avatar', 'user-14', 'user-14.jpg', 'image/jpeg', 'public', 'public', 814074, '[]', '{\"uuid\":\"91d0ce35-9c59-40f2-ac13-c8305b6d6eb6\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:45:18', '2024-10-24 19:45:24'),
(125, '69233b05-1e41-4c0b-8b86-393a7911a2c7', 'App\\Models\\User', 15, 'avatar', 'user-15', 'user-15.jpg', 'image/jpeg', 'public', 'public', 851116, '[]', '{\"uuid\":\"9a8e1043-26bf-4be2-8794-944b267aa5a7\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:45:22', '2024-10-24 19:45:24'),
(126, '3373d10a-6274-4c1d-a00a-081c89126601', 'App\\Models\\User', 16, 'avatar', 'user-16', 'user-16.jpg', 'image/jpeg', 'public', 'public', 1875101, '[]', '{\"uuid\":\"06a78516-2745-439d-94cb-a6d5e3f981cf\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-10-24 19:45:24', '2024-10-24 19:45:27'),
(127, '0cfda5d6-8d65-4929-9aaf-f42d5ec9172b', 'App\\Models\\Upload', 60, 'image', 'Beauty and Fashion Logo', 'Beauty-and-Fashion-Logo.jpg', 'image/jpeg', 'public', 'public', 15211, '[]', '{\"uuid\":\"16d833a0-98aa-4fcb-9cfd-8b3faa625205\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:00:27', '2024-11-27 22:00:28'),
(128, '99654a93-ec35-4c74-92fa-c9936f17d2c0', 'App\\Models\\EProvider', 3, 'image', 'Beauty and Fashion Logo', 'Beauty-and-Fashion-Logo.jpg', 'image/jpeg', 'public', 'public', 15211, '[]', '{\"uuid\":\"16d833a0-98aa-4fcb-9cfd-8b3faa625205\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:00:37', '2024-11-27 22:00:37'),
(129, 'c87e4599-8061-4406-9779-0ff555623def', 'App\\Models\\Upload', 61, 'image', 'Boho_Bob_Braids_480x480', 'Boho_Bob_Braids_480x480.jpg', 'image/jpeg', 'public', 'public', 67193, '[]', '{\"uuid\":\"dab0f65b-bb76-44ad-b407-3b0ee731a411\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:04:29', '2024-11-27 22:04:29'),
(130, 'e97da339-2f17-4d0d-9bb2-0c4ae39feb67', 'App\\Models\\EService', 47, 'image', 'Boho_Bob_Braids_480x480', 'Boho_Bob_Braids_480x480.jpg', 'image/jpeg', 'public', 'public', 67193, '[]', '{\"uuid\":\"dab0f65b-bb76-44ad-b407-3b0ee731a411\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:04:42', '2024-11-27 22:04:42'),
(131, 'd921505f-734c-443e-beee-b617c649053f', 'App\\Models\\Upload', 62, 'image', '20-medium-length-box-braids', '20-medium-length-box-braids.jpg', 'image/jpeg', 'public', 'public', 64394, '[]', '{\"uuid\":\"8ce12e84-4906-48af-b393-10715dd95ead\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:05:58', '2024-11-27 22:05:59'),
(132, '78bdd662-d59c-4ec6-95ca-009f592537db', 'App\\Models\\EService', 48, 'image', '20-medium-length-box-braids', '20-medium-length-box-braids.jpg', 'image/jpeg', 'public', 'public', 64394, '[]', '{\"uuid\":\"8ce12e84-4906-48af-b393-10715dd95ead\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:06:35', '2024-11-27 22:06:35'),
(133, '65c2de91-8e55-45e8-994f-badabed5540e', 'App\\Models\\Upload', 63, 'image', 'bb7b1c8056f89b9c3b04f1c478bd80f5', 'bb7b1c8056f89b9c3b04f1c478bd80f5.jpg', 'image/jpeg', 'public', 'public', 108661, '[]', '{\"uuid\":\"885f931d-b18b-4d25-9604-4cf73f7355f8\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:07:54', '2024-11-27 22:07:54'),
(134, '2faefd66-d93f-4d1f-b02d-f619fb4878af', 'App\\Models\\EService', 49, 'image', 'bb7b1c8056f89b9c3b04f1c478bd80f5', 'bb7b1c8056f89b9c3b04f1c478bd80f5.jpg', 'image/jpeg', 'public', 'public', 108661, '[]', '{\"uuid\":\"885f931d-b18b-4d25-9604-4cf73f7355f8\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:08:33', '2024-11-27 22:08:33'),
(135, '0af28f8b-9996-475a-a161-2a631d84974c', 'App\\Models\\Upload', 64, 'image', '7189bc2a40357ed65fed87930526f2fd', '7189bc2a40357ed65fed87930526f2fd.jpg', 'image/jpeg', 'public', 'public', 87870, '[]', '{\"uuid\":\"8ca50580-002f-4c44-991b-a153c6661e84\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:09:57', '2024-11-27 22:09:57'),
(136, '80bb1fa0-9c5d-4979-808c-ae49d4239d7f', 'App\\Models\\EProvider', 2, 'image', '7189bc2a40357ed65fed87930526f2fd', '7189bc2a40357ed65fed87930526f2fd.jpg', 'image/jpeg', 'public', 'public', 87870, '[]', '{\"uuid\":\"8ca50580-002f-4c44-991b-a153c6661e84\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:10:01', '2024-11-27 22:10:01'),
(137, 'c61958b2-b5da-4fcc-b55a-dee4ed4e5f67', 'App\\Models\\Upload', 65, 'image', '61r7FHG5vlL', '61r7FHG5vlL.jpg', 'image/jpeg', 'public', 'public', 98421, '[]', '{\"uuid\":\"04b433fc-cf80-4aa7-ba33-01a23cea87f7\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:15:33', '2024-11-27 22:15:33'),
(138, 'decaf299-0912-4a4f-909a-b66c5c421bb0', 'App\\Models\\EService', 50, 'image', '61r7FHG5vlL', '61r7FHG5vlL.jpg', 'image/jpeg', 'public', 'public', 98421, '[]', '{\"uuid\":\"04b433fc-cf80-4aa7-ba33-01a23cea87f7\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2024-11-27 22:15:39', '2024-11-27 22:15:39'),
(140, '800919e8-162f-4b02-90d5-ad54d5e6e1ca', 'App\\Models\\Upload', 67, 'avatar', 'image_picker_4D044FA6-7882-43D4-B6D3-3F25B022B811-9995-000003BE10A1C8B3', 'image_picker_4D044FA6-7882-43D4-B6D3-3F25B022B811-9995-000003BE10A1C8B3.jpg', 'image/jpeg', 'public', 'public', 2406490, '[]', '{\"uuid\":\"21a38dce-3b06-45ed-b990-6ae2220496be\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:21:37', '2025-02-22 00:21:40'),
(141, '9b81d91a-2d62-4943-aa8e-7a14eb27fe88', 'App\\Models\\Upload', 68, 'avatar', 'image_picker_E2AE2F1A-3317-424B-A1E5-182D6A80243E-9995-000003BE2F61A44A', 'image_picker_E2AE2F1A-3317-424B-A1E5-182D6A80243E-9995-000003BE2F61A44A.jpg', 'image/jpeg', 'public', 'public', 2303827, '[]', '{\"uuid\":\"2049ae05-4db4-4827-80b9-caa3526e96c6\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:21:58', '2025-02-22 00:22:01'),
(145, '122f57a5-9558-4bf9-b6b6-edec8a5b834e', 'App\\Models\\Upload', 71, 'avatar', 'image_picker_E6EE769B-F3FC-42D5-B115-D1BE48C675E8-9995-000003C073022A09', 'image_picker_E6EE769B-F3FC-42D5-B115-D1BE48C675E8-9995-000003C073022A09.jpg', 'image/jpeg', 'public', 'public', 1142877, '[]', '{\"uuid\":\"11dd7026-dfd4-447a-967c-cf527d212d7e\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:28:43', '2025-02-22 00:28:44'),
(147, '80917d9e-6082-460a-85dc-697f6a208889', 'App\\Models\\User', 34, 'avatar', 'image_picker_E6EE769B-F3FC-42D5-B115-D1BE48C675E8-9995-000003C073022A09', 'image_picker_E6EE769B-F3FC-42D5-B115-D1BE48C675E8-9995-000003C073022A09.jpg', 'image/jpeg', 'public', 'public', 1142877, '[]', '{\"uuid\":\"11dd7026-dfd4-447a-967c-cf527d212d7e\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:28:52', '2025-02-22 00:28:53'),
(148, 'add1ca7e-683d-45c1-b510-98fb8cf4f8d7', 'App\\Models\\Upload', 73, 'avatar', 'scaled_Screenshot_20250221-130434', 'scaled_Screenshot_20250221-130434.jpg', 'image/jpeg', 'public', 'public', 94553, '[]', '{\"uuid\":\"9a190e19-2f90-4345-a028-5c0af443df78\",\"user_id\":32}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:28:54', '2025-02-22 00:28:54'),
(151, '23ffcbdd-450f-453d-bd5f-d6408c13c949', 'App\\Models\\Upload', 76, 'avatar', 'scaled_henry_naija~p~DFich-NoC9n~1', 'scaled_henry_naija~p~DFich-NoC9n~1.jpg', 'image/jpeg', 'public', 'public', 108925, '[]', '{\"uuid\":\"a57dab22-6418-4f44-bac0-2d044c9ebe8b\",\"user_id\":32}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:29:31', '2025-02-22 00:29:32'),
(152, 'f1420518-54a0-4f2f-8d08-8be5e6dd830f', 'App\\Models\\Upload', 77, 'avatar', 'image_picker_4AC4B260-2BBB-4FE5-99E5-6304128536B6-4889-0000055B753964FC', 'image_picker_4AC4B260-2BBB-4FE5-99E5-6304128536B6-4889-0000055B753964FC.png', 'image/png', 'public', 'public', 69714, '[]', '{\"uuid\":\"c5ae3619-71a2-4575-b498-94d417451e70\",\"user_id\":31}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:29:56', '2025-02-22 00:29:56'),
(153, '1b5f7fa8-6faf-450f-a1d8-620f9d8a4d5a', 'App\\Models\\User', 31, 'avatar', 'image_picker_4AC4B260-2BBB-4FE5-99E5-6304128536B6-4889-0000055B753964FC', 'image_picker_4AC4B260-2BBB-4FE5-99E5-6304128536B6-4889-0000055B753964FC.png', 'image/png', 'public', 'public', 69714, '[]', '{\"uuid\":\"c5ae3619-71a2-4575-b498-94d417451e70\",\"user_id\":31}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:30:18', '2025-02-22 00:30:19'),
(154, '7315666d-6106-4360-bd2c-ed7eb1531ead', 'App\\Models\\User', 32, 'avatar', 'scaled_henry_naija~p~DFich-NoC9n~1', 'scaled_henry_naija~p~DFich-NoC9n~1.jpg', 'image/jpeg', 'public', 'public', 108925, '[]', '{\"uuid\":\"a57dab22-6418-4f44-bac0-2d044c9ebe8b\",\"user_id\":32}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:31:34', '2025-02-22 00:31:34'),
(155, 'ca50fafe-efb4-45f7-bd93-ea0f2d64b818', 'App\\Models\\Upload', 78, 'avatar', 'image_picker_A3FBA529-0826-40B0-846A-9511D3CC4B36-1991-0000010A601F1BC5', 'image_picker_A3FBA529-0826-40B0-846A-9511D3CC4B36-1991-0000010A601F1BC5.png', 'image/png', 'public', 'public', 3662970, '[]', '{\"uuid\":\"06016124-5e72-449d-bf6c-c08b1aa54710\",\"user_id\":35}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:33:24', '2025-02-22 00:33:25'),
(156, '3f2b8e48-9550-4d84-837d-324e7c710a2f', 'App\\Models\\Upload', 79, 'image', 'image_picker_5740AA07-8F22-4D25-98BD-C64763376C74-10636-000003C433BB7D5E', 'image_picker_5740AA07-8F22-4D25-98BD-C64763376C74-10636-000003C433BB7D5E.jpg', 'image/jpeg', 'public', 'public', 1142877, '[]', '{\"uuid\":\"7a6e22b2-1cf6-4226-b321-a3d53533304e\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:39:55', '2025-02-22 00:39:56'),
(157, '96d0dcc4-4768-4826-baca-33e26d3cf711', 'App\\Models\\Upload', 80, 'image', 'scaled_Screenshot_20250221-131707', 'scaled_Screenshot_20250221-131707.jpg', 'image/jpeg', 'public', 'public', 99677, '[]', '{\"uuid\":\"89bd42ef-6452-47ed-aa86-4f7412f194c7\",\"user_id\":32}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:44:36', '2025-02-22 00:44:37'),
(158, 'a7a1ac41-66c4-4278-a51d-91919d261723', 'App\\Models\\Upload', 81, 'image', 'image_picker_C7F9F262-2142-4611-837A-52D118B7D0CD-10636-000003C614ED838A', 'image_picker_C7F9F262-2142-4611-837A-52D118B7D0CD-10636-000003C614ED838A.jpg', 'image/jpeg', 'public', 'public', 1142877, '[]', '{\"uuid\":\"423068d7-fe24-47f8-945a-d7ba64a2d291\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-02-22 00:45:31', '2025-02-22 00:45:32'),
(159, '006c754e-b909-4758-b80d-188cb081c515', 'App\\Models\\Upload', 82, 'avatar', 'EWA logo 1', 'EWA-logo-1.png', 'image/png', 'public', 'public', 127458, '[]', '{\"uuid\":\"2b48cdcf-621f-4641-aea3-73c57eee960d\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-24 13:43:04', '2025-03-24 13:43:04'),
(160, 'cb1cbfd5-98f8-4960-ba35-605aa0dcdee8', 'App\\Models\\User', 1, 'avatar', 'EWA logo 1', 'EWA-logo-1.png', 'image/png', 'public', 'public', 127458, '[]', '{\"uuid\":\"2b48cdcf-621f-4641-aea3-73c57eee960d\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-24 13:43:10', '2025-03-24 13:43:10'),
(161, 'f2875da5-92a8-4b95-abb3-45bff3c719c5', 'App\\Models\\Upload', 83, 'image', 'scaled_1000524619', 'scaled_1000524619.jpg', 'image/jpeg', 'public', 'public', 269496, '[]', '{\"uuid\":\"7aae7a61-5ae9-45fd-90d5-59c6ec0e99b6\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-26 14:18:16', '2025-03-26 14:18:17'),
(162, '45184363-2f0c-4fc9-94b0-a0afb96ecdec', 'App\\Models\\Upload', 84, 'image', 'scaled_1000436774', 'scaled_1000436774.jpg', 'image/jpeg', 'public', 'public', 84324, '[]', '{\"uuid\":\"638c6d97-74f0-4c72-a274-af1efb21e73e\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-26 14:18:36', '2025-03-26 14:18:37'),
(163, 'b5f8c940-8687-4f32-b85a-3c296082fe7f', 'App\\Models\\Upload', 85, 'image', 'scaled_1000444216', 'scaled_1000444216.jpg', 'image/jpeg', 'public', 'public', 75775, '[]', '{\"uuid\":\"0b053878-7e05-4c89-b329-eac733de8dd6\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-26 14:18:51', '2025-03-26 14:18:52'),
(164, '0503c56d-5c0b-4472-b651-0717b07fcfc9', 'App\\Models\\EService', 51, 'image', 'scaled_1000524619', 'scaled_1000524619.jpg', 'image/jpeg', 'public', 'public', 269496, '[]', '{\"uuid\":\"7aae7a61-5ae9-45fd-90d5-59c6ec0e99b6\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-26 14:20:07', '2025-03-26 14:20:07'),
(165, '43976037-3fde-419e-b6be-c2afa204c5b7', 'App\\Models\\EService', 51, 'image', 'scaled_1000436774', 'scaled_1000436774.jpg', 'image/jpeg', 'public', 'public', 84324, '[]', '{\"uuid\":\"638c6d97-74f0-4c72-a274-af1efb21e73e\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-26 14:20:07', '2025-03-26 14:20:07'),
(166, '230cf02a-63d4-4fd4-83e7-01bb7397e53f', 'App\\Models\\EService', 51, 'image', 'scaled_1000444216', 'scaled_1000444216.jpg', 'image/jpeg', 'public', 'public', 75775, '[]', '{\"uuid\":\"0b053878-7e05-4c89-b329-eac733de8dd6\",\"user_id\":2}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-26 14:20:07', '2025-03-26 14:20:08'),
(167, '1262f72d-e6ce-41fb-81c8-6b58b665281b', 'App\\Models\\Upload', 86, 'image', 'GRAMEF DIGITAL ICON', 'GRAMEF-DIGITAL-ICON.jpg', 'image/jpeg', 'public', 'public', 80925, '[]', '{\"uuid\":\"8db19078-8e17-4b2c-b2f1-9b1a9f16f875\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:13:46', '2025-03-28 17:13:46'),
(168, 'cfbb79a5-d70c-4df0-908f-6dc6562f3e7b', 'App\\Models\\Upload', 87, 'image', 'GRAMEF DIGITAL ICON', 'GRAMEF-DIGITAL-ICON.png', 'image/png', 'public', 'public', 15442, '[]', '{\"uuid\":\"fda21a15-2c6f-49ce-b737-1b710702b930\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:15:46', '2025-03-28 17:15:46'),
(169, '20d3158f-501f-429a-b82e-ba65a3b0927b', 'App\\Models\\EProvider', 4, 'image', 'GRAMEF DIGITAL ICON', 'GRAMEF-DIGITAL-ICON.png', 'image/png', 'public', 'public', 15442, '[]', '{\"uuid\":\"fda21a15-2c6f-49ce-b737-1b710702b930\",\"user_id\":1}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:16:18', '2025-03-28 17:16:18'),
(170, '0ff225fe-ab8d-443f-9fe7-2f82173ecd00', 'App\\Models\\Upload', 88, 'image', 'image_picker_0B1B41E4-EB59-406B-A06A-DDB35B263204-9062-0000035D3294ACF8', 'image_picker_0B1B41E4-EB59-406B-A06A-DDB35B263204-9062-0000035D3294ACF8.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"70948c70-fa27-44ff-b44e-c96d7216b845\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:18:43', '2025-03-28 17:18:43'),
(171, 'ad44aede-db89-4228-bc95-5ae244418e1f', 'App\\Models\\Upload', 89, 'image', 'image_picker_25432D70-0F9D-4F25-A9CF-7A1985C01E45-9062-0000035D36849369', 'image_picker_25432D70-0F9D-4F25-A9CF-7A1985C01E45-9062-0000035D36849369.jpg', 'image/jpeg', 'public', 'public', 224848, '[]', '{\"uuid\":\"8ac0a2c9-4ab1-444e-bf9e-a525b0429fac\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:18:46', '2025-03-28 17:18:47'),
(172, '6f3aa80f-b015-4f79-b6f2-69998c69b19a', 'App\\Models\\Upload', 90, 'image', 'image_picker_EB4D2DD1-7FD0-4EE7-9A1C-7930A5BB1886-9062-0000035DC6F95E60', 'image_picker_EB4D2DD1-7FD0-4EE7-9A1C-7930A5BB1886-9062-0000035DC6F95E60.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"17392214-eda8-4ae2-8484-e82352dba756\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:20:27', '2025-03-28 17:20:27'),
(173, '4fc3e657-ecf3-4272-88ee-ffc758f61479', 'App\\Models\\Upload', 91, 'image', 'image_picker_152AEC9B-FCC8-4125-9292-E3E0BB0D99F3-9062-0000035DEA2D34BC', 'image_picker_152AEC9B-FCC8-4125-9292-E3E0BB0D99F3-9062-0000035DEA2D34BC.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"871c80f2-5a74-4a4f-9708-dfb9263c6e78\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:20:52', '2025-03-28 17:20:52'),
(174, '486e1e1f-05b8-4422-93f4-8cf5553e43e7', 'App\\Models\\Upload', 92, 'image', 'image_picker_C3D78A54-A24D-4B18-9BAE-99E1DAA5ED8D-9062-0000035DEDC5AD0B', 'image_picker_C3D78A54-A24D-4B18-9BAE-99E1DAA5ED8D-9062-0000035DEDC5AD0B.jpg', 'image/jpeg', 'public', 'public', 224848, '[]', '{\"uuid\":\"4f3a838a-89c8-4d87-9569-a7b4200eae97\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:20:54', '2025-03-28 17:20:55'),
(175, 'd8f0ed19-80d0-4985-85c8-3daa29f98be6', 'App\\Models\\EProvider', 5, 'image', 'image_picker_0B1B41E4-EB59-406B-A06A-DDB35B263204-9062-0000035D3294ACF8', 'image_picker_0B1B41E4-EB59-406B-A06A-DDB35B263204-9062-0000035D3294ACF8.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"70948c70-fa27-44ff-b44e-c96d7216b845\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:21:42', '2025-03-28 17:21:42'),
(176, 'aaa08de0-4e1b-41ba-a32b-308d11c9ab30', 'App\\Models\\EProvider', 5, 'image', 'image_picker_25432D70-0F9D-4F25-A9CF-7A1985C01E45-9062-0000035D36849369', 'image_picker_25432D70-0F9D-4F25-A9CF-7A1985C01E45-9062-0000035D36849369.jpg', 'image/jpeg', 'public', 'public', 224848, '[]', '{\"uuid\":\"8ac0a2c9-4ab1-444e-bf9e-a525b0429fac\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:21:42', '2025-03-28 17:21:42'),
(177, '1e382dc9-df5c-4c56-a6f8-cfcd17d06ecb', 'App\\Models\\EProvider', 5, 'image', 'image_picker_EB4D2DD1-7FD0-4EE7-9A1C-7930A5BB1886-9062-0000035DC6F95E60', 'image_picker_EB4D2DD1-7FD0-4EE7-9A1C-7930A5BB1886-9062-0000035DC6F95E60.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"17392214-eda8-4ae2-8484-e82352dba756\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:21:42', '2025-03-28 17:21:43'),
(178, 'aa2af332-6361-4c33-8936-a884cab30322', 'App\\Models\\EProvider', 5, 'image', 'image_picker_152AEC9B-FCC8-4125-9292-E3E0BB0D99F3-9062-0000035DEA2D34BC', 'image_picker_152AEC9B-FCC8-4125-9292-E3E0BB0D99F3-9062-0000035DEA2D34BC.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"871c80f2-5a74-4a4f-9708-dfb9263c6e78\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:21:43', '2025-03-28 17:21:43');
INSERT INTO `media` (`id`, `uuid`, `model_type`, `model_id`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(179, '10249e30-cfb5-4566-8337-831095931071', 'App\\Models\\EProvider', 5, 'image', 'image_picker_C3D78A54-A24D-4B18-9BAE-99E1DAA5ED8D-9062-0000035DEDC5AD0B', 'image_picker_C3D78A54-A24D-4B18-9BAE-99E1DAA5ED8D-9062-0000035DEDC5AD0B.jpg', 'image/jpeg', 'public', 'public', 224848, '[]', '{\"uuid\":\"4f3a838a-89c8-4d87-9569-a7b4200eae97\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:21:43', '2025-03-28 17:21:43'),
(180, 'f3bbd784-12a4-4d90-9ef1-1f4ff8ad8c1d', 'App\\Models\\Upload', 93, 'image', 'image_picker_EB0DF4CF-6E89-4B45-B0FE-4C4754DDA3D4-9062-0000035EC2C48458', 'image_picker_EB0DF4CF-6E89-4B45-B0FE-4C4754DDA3D4-9062-0000035EC2C48458.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"d61c7f52-c7b8-4e94-883c-d0fa0109ccfc\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:23:23', '2025-03-28 17:23:23'),
(181, '8aefbcb1-3610-4bcc-ae46-0c177b7852ed', 'App\\Models\\Upload', 94, 'image', 'image_picker_906D9E1F-A110-4643-8498-A9D8EA08D778-9062-0000035EC5B1B44F', 'image_picker_906D9E1F-A110-4643-8498-A9D8EA08D778-9062-0000035EC5B1B44F.jpg', 'image/jpeg', 'public', 'public', 224848, '[]', '{\"uuid\":\"2eb2ea9c-e40f-4731-b9b5-1cbeefe6d696\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:23:25', '2025-03-28 17:23:26'),
(182, '321dc5d8-722c-4a64-b756-760e520d8b19', 'App\\Models\\EProvider', 6, 'image', 'image_picker_EB0DF4CF-6E89-4B45-B0FE-4C4754DDA3D4-9062-0000035EC2C48458', 'image_picker_EB0DF4CF-6E89-4B45-B0FE-4C4754DDA3D4-9062-0000035EC2C48458.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"d61c7f52-c7b8-4e94-883c-d0fa0109ccfc\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:24:08', '2025-03-28 17:24:08'),
(183, '3eb321b2-b52e-40a6-aee1-bc888bd50905', 'App\\Models\\EProvider', 6, 'image', 'image_picker_906D9E1F-A110-4643-8498-A9D8EA08D778-9062-0000035EC5B1B44F', 'image_picker_906D9E1F-A110-4643-8498-A9D8EA08D778-9062-0000035EC5B1B44F.jpg', 'image/jpeg', 'public', 'public', 224848, '[]', '{\"uuid\":\"2eb2ea9c-e40f-4731-b9b5-1cbeefe6d696\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:24:08', '2025-03-28 17:24:08'),
(184, '0af323fb-00eb-4e81-bade-94a59634146a', 'App\\Models\\Upload', 95, 'image', 'image_picker_FADD5947-5499-44E7-B965-A493AAA1889B-9062-00000360625517F7', 'image_picker_FADD5947-5499-44E7-B965-A493AAA1889B-9062-00000360625517F7.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"d16a2eb4-ab9b-4da8-b2b5-f492a47bf343\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:28:14', '2025-03-28 17:28:14'),
(185, '572325cc-5b5f-4699-bd07-6c05b857a8f4', 'App\\Models\\EService', 52, 'image', 'image_picker_FADD5947-5499-44E7-B965-A493AAA1889B-9062-00000360625517F7', 'image_picker_FADD5947-5499-44E7-B965-A493AAA1889B-9062-00000360625517F7.jpg', 'image/jpeg', 'public', 'public', 75446, '[]', '{\"uuid\":\"d16a2eb4-ab9b-4da8-b2b5-f492a47bf343\",\"user_id\":34}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-03-28 17:29:12', '2025-03-28 17:29:12'),
(186, '598f7a88-ca42-4d84-9a39-977835a81e48', 'App\\Models\\Upload', 96, 'avatar', 'image_picker_028A441C-2193-4E03-BF43-19871CAF1F53-817-00000054CFADBAD1', 'image_picker_028A441C-2193-4E03-BF43-19871CAF1F53-817-00000054CFADBAD1.jpg', 'image/jpeg', 'public', 'public', 100465, '[]', '{\"uuid\":\"7d994ce9-f824-43ee-89d5-d07abef14dbe\",\"user_id\":56}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-04-03 23:33:08', '2025-04-03 23:33:08'),
(187, 'a3b1388e-faed-488b-af97-b0b4b90dcd37', 'App\\Models\\User', 56, 'avatar', 'image_picker_028A441C-2193-4E03-BF43-19871CAF1F53-817-00000054CFADBAD1', 'image_picker_028A441C-2193-4E03-BF43-19871CAF1F53-817-00000054CFADBAD1.jpg', 'image/jpeg', 'public', 'public', 100465, '[]', '{\"uuid\":\"7d994ce9-f824-43ee-89d5-d07abef14dbe\",\"user_id\":56}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-04-03 23:33:51', '2025-04-03 23:33:52'),
(188, '4a897c69-0ba2-4761-902e-f9d750f6afbb', 'App\\Models\\Upload', 97, 'image', 'image_picker_22BD790A-77C5-46FF-B777-62078BE87A12-892-00000057E98B0935', 'image_picker_22BD790A-77C5-46FF-B777-62078BE87A12-892-00000057E98B0935.png', 'image/png', 'public', 'public', 2234041, '[]', '{\"uuid\":\"62b517e7-0f7e-4e61-8b5b-09314edfc983\",\"user_id\":57}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-04-03 23:42:24', '2025-04-03 23:42:25'),
(189, '71f3099f-d14e-4994-8d06-66193e2cf26e', 'App\\Models\\EProvider', 7, 'image', 'image_picker_22BD790A-77C5-46FF-B777-62078BE87A12-892-00000057E98B0935', 'image_picker_22BD790A-77C5-46FF-B777-62078BE87A12-892-00000057E98B0935.png', 'image/png', 'public', 'public', 2234041, '[]', '{\"uuid\":\"62b517e7-0f7e-4e61-8b5b-09314edfc983\",\"user_id\":57}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-04-03 23:43:28', '2025-04-03 23:43:29'),
(190, '71a583a0-965f-4001-bfbb-c3d5185e79e3', 'App\\Models\\Upload', 98, 'image', 'image_picker_F0594041-364E-4D6A-9424-2206981BFFA0-7655-000008AEAFD5D2A9', 'image_picker_F0594041-364E-4D6A-9424-2206981BFFA0-7655-000008AEAFD5D2A9.jpg', 'image/jpeg', 'public', 'public', 122761, '[]', '{\"uuid\":\"e7f3ded0-5f59-4839-a401-720e990679c0\",\"user_id\":57}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-04-04 19:16:14', '2025-04-04 19:16:14'),
(192, '8f945995-da00-425c-bbfd-f25e38921ec2', 'App\\Models\\Upload', 99, 'image', 'image_picker_915DD9D6-6B3D-4C85-85CB-4AD8063174B6-2096-000001DF0B6F6B5A', 'image_picker_915DD9D6-6B3D-4C85-85CB-4AD8063174B6-2096-000001DF0B6F6B5A.png', 'image/png', 'public', 'public', 2963661, '[]', '{\"uuid\":\"3bc391cf-a186-46e4-b1dc-db01e4277801\",\"user_id\":57}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-04-04 20:45:17', '2025-04-04 20:45:18'),
(193, 'c935e873-375f-4b29-ab1d-3ecacf5233c0', 'App\\Models\\EService', 54, 'image', 'image_picker_915DD9D6-6B3D-4C85-85CB-4AD8063174B6-2096-000001DF0B6F6B5A', 'image_picker_915DD9D6-6B3D-4C85-85CB-4AD8063174B6-2096-000001DF0B6F6B5A.png', 'image/png', 'public', 'public', 2963661, '[]', '{\"uuid\":\"3bc391cf-a186-46e4-b1dc-db01e4277801\",\"user_id\":57}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-04-04 20:46:10', '2025-04-04 20:46:11'),
(194, 'b82082dd-6113-441c-8782-8df5e6eb1b32', 'App\\Models\\Upload', 100, 'image', 'scaled_1001379305', 'scaled_1001379305.png', 'image/png', 'public', 'public', 122046, '[]', '{\"uuid\":\"cadc36b3-ce25-4b0f-8150-a9c9c33761f7\",\"user_id\":118}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-05-28 03:47:21', '2025-05-28 03:47:22'),
(195, 'd4e8d985-125e-47d4-8748-0969fde5e7dd', 'App\\Models\\EProvider', 8, 'image', 'scaled_1001379305', 'scaled_1001379305.png', 'image/png', 'public', 'public', 122046, '[]', '{\"uuid\":\"cadc36b3-ce25-4b0f-8150-a9c9c33761f7\",\"user_id\":118}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-05-28 03:52:51', '2025-05-28 03:52:51'),
(196, '20f7aa37-dd92-46ae-ae91-b17931ec9fd6', 'App\\Models\\Upload', 101, 'image', 'scaled_1001384930', 'scaled_1001384930.jpg', 'image/jpeg', 'public', 'public', 70224, '[]', '{\"uuid\":\"73a1ca76-9ff4-48c9-b8fd-16ab4846075d\",\"user_id\":118}', '{\"thumb\":true,\"icon\":true}', '[]', 1, '2025-05-30 11:42:49', '2025-05-30 11:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
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
(3, '2018_05_26_175145_create_permission_tables', 1),
(4, '2018_06_12_140344_create_media_table', 1),
(5, '2018_06_13_035117_create_uploads_table', 1),
(6, '2018_07_17_180731_create_settings_table', 1),
(7, '2018_07_24_211308_create_custom_fields_table', 1),
(8, '2018_07_24_211327_create_custom_field_values_table', 1),
(9, '2019_08_19_000000_create_failed_jobs_table', 1),
(10, '2019_08_29_213829_create_faq_categories_table', 1),
(11, '2019_08_29_213926_create_faqs_table', 1),
(12, '2019_10_22_144652_create_currencies_table', 1),
(13, '2021_01_07_162658_create_payment_methods_table', 1),
(14, '2021_01_07_164755_create_payment_statuses_table', 1),
(15, '2021_01_07_165422_create_payments_table', 1),
(16, '2021_01_13_105605_create_e_provider_types_table', 1),
(17, '2021_01_13_111155_create_e_providers_table', 1),
(18, '2021_01_13_111622_create_experiences_table', 1),
(19, '2021_01_13_111730_create_awards_table', 1),
(20, '2021_01_13_114302_create_taxes_table', 1),
(21, '2021_01_13_200249_create_addresses_table', 1),
(22, '2021_01_15_115239_create_e_provider_addresses_table', 1),
(23, '2021_01_15_115747_create_e_provider_users_table', 1),
(24, '2021_01_15_115850_create_e_provider_taxes_table', 1),
(25, '2021_01_16_160838_create_availability_hours_table', 1),
(26, '2021_01_19_135951_create_e_services_table', 1),
(27, '2021_01_19_140427_create_categories_table', 1),
(28, '2021_01_19_171553_create_e_service_categories_table', 1),
(29, '2021_01_22_194514_create_option_groups_table', 1),
(30, '2021_01_22_200807_create_options_table', 1),
(31, '2021_01_22_205819_create_favorites_table', 1),
(32, '2021_01_22_205944_create_favorite_options_table', 1),
(33, '2021_01_23_125641_create_e_service_reviews_table', 1),
(34, '2021_01_23_201533_create_galleries_table', 1),
(35, '2021_01_25_105421_create_slides_table', 1),
(36, '2021_01_25_162055_create_notifications_table', 1),
(37, '2021_01_25_170522_create_coupons_table', 1),
(38, '2021_01_25_170529_create_discountables_table', 1),
(39, '2021_01_25_191833_create_booking_statuses_table', 1),
(40, '2021_01_25_212252_create_bookings_table', 1),
(41, '2021_01_30_111717_create_e_provider_payouts_table', 1),
(42, '2021_01_30_135356_create_earnings_table', 1),
(43, '2021_02_24_102838_create_custom_pages_table', 1),
(44, '2021_06_26_110636_create_json_extract_function', 1),
(45, '2021_08_08_134136_create_wallets_table', 1),
(46, '2021_08_08_155732_create_wallet_transactions_table', 1),
(47, '2022_03_18_092612_create_subscription_packages_table', 1),
(48, '2022_03_18_092804_create_e_provider_subscriptions_table', 1),
(49, '2023_10_02_143121_update_to_v300', 2),
(50, '2024_07_07_210204_create_e_provider_locations_table', 3),
(51, '2023_10_02_143122_update_to_v300', 4),
(52, '2024_09_24_112129_update_to_v310', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 7),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 16),
(4, 'App\\Models\\User', 17),
(4, 'App\\Models\\User', 18),
(4, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 20),
(4, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 23),
(4, 'App\\Models\\User', 24),
(4, 'App\\Models\\User', 25),
(4, 'App\\Models\\User', 26),
(4, 'App\\Models\\User', 27),
(4, 'App\\Models\\User', 28),
(4, 'App\\Models\\User', 29),
(4, 'App\\Models\\User', 30),
(4, 'App\\Models\\User', 31),
(4, 'App\\Models\\User', 32),
(4, 'App\\Models\\User', 33),
(3, 'App\\Models\\User', 34),
(4, 'App\\Models\\User', 35),
(4, 'App\\Models\\User', 36),
(4, 'App\\Models\\User', 37),
(4, 'App\\Models\\User', 38),
(4, 'App\\Models\\User', 39),
(4, 'App\\Models\\User', 40),
(4, 'App\\Models\\User', 41),
(4, 'App\\Models\\User', 42),
(4, 'App\\Models\\User', 43),
(4, 'App\\Models\\User', 44),
(4, 'App\\Models\\User', 45),
(4, 'App\\Models\\User', 46),
(4, 'App\\Models\\User', 47),
(4, 'App\\Models\\User', 48),
(4, 'App\\Models\\User', 49),
(4, 'App\\Models\\User', 50),
(4, 'App\\Models\\User', 51),
(4, 'App\\Models\\User', 52),
(4, 'App\\Models\\User', 53),
(4, 'App\\Models\\User', 54),
(4, 'App\\Models\\User', 55),
(4, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 57),
(4, 'App\\Models\\User', 58),
(4, 'App\\Models\\User', 59),
(4, 'App\\Models\\User', 60),
(4, 'App\\Models\\User', 61),
(4, 'App\\Models\\User', 62),
(4, 'App\\Models\\User', 63),
(4, 'App\\Models\\User', 64),
(4, 'App\\Models\\User', 65),
(4, 'App\\Models\\User', 66),
(4, 'App\\Models\\User', 67),
(4, 'App\\Models\\User', 68),
(4, 'App\\Models\\User', 69),
(4, 'App\\Models\\User', 70),
(4, 'App\\Models\\User', 71),
(4, 'App\\Models\\User', 72),
(4, 'App\\Models\\User', 73),
(4, 'App\\Models\\User', 74),
(4, 'App\\Models\\User', 75),
(4, 'App\\Models\\User', 76),
(4, 'App\\Models\\User', 77),
(4, 'App\\Models\\User', 78),
(4, 'App\\Models\\User', 79),
(4, 'App\\Models\\User', 80),
(4, 'App\\Models\\User', 81),
(4, 'App\\Models\\User', 82),
(4, 'App\\Models\\User', 83),
(4, 'App\\Models\\User', 84),
(4, 'App\\Models\\User', 85),
(4, 'App\\Models\\User', 86),
(4, 'App\\Models\\User', 87),
(4, 'App\\Models\\User', 88),
(4, 'App\\Models\\User', 89),
(4, 'App\\Models\\User', 90),
(4, 'App\\Models\\User', 91),
(4, 'App\\Models\\User', 92),
(4, 'App\\Models\\User', 93),
(4, 'App\\Models\\User', 94),
(4, 'App\\Models\\User', 95),
(4, 'App\\Models\\User', 96),
(4, 'App\\Models\\User', 97),
(4, 'App\\Models\\User', 98),
(4, 'App\\Models\\User', 99),
(4, 'App\\Models\\User', 100),
(4, 'App\\Models\\User', 101),
(4, 'App\\Models\\User', 102),
(4, 'App\\Models\\User', 103),
(4, 'App\\Models\\User', 104),
(4, 'App\\Models\\User', 105),
(4, 'App\\Models\\User', 106),
(4, 'App\\Models\\User', 107),
(4, 'App\\Models\\User', 108),
(4, 'App\\Models\\User', 109),
(4, 'App\\Models\\User', 110),
(4, 'App\\Models\\User', 111),
(4, 'App\\Models\\User', 112),
(4, 'App\\Models\\User', 113),
(4, 'App\\Models\\User', 114),
(4, 'App\\Models\\User', 115),
(4, 'App\\Models\\User', 116),
(4, 'App\\Models\\User', 117),
(4, 'App\\Models\\User', 118),
(4, 'App\\Models\\User', 119),
(4, 'App\\Models\\User', 120),
(4, 'App\\Models\\User', 121),
(4, 'App\\Models\\User', 122),
(4, 'App\\Models\\User', 123),
(4, 'App\\Models\\User', 124),
(4, 'App\\Models\\User', 125),
(4, 'App\\Models\\User', 126),
(4, 'App\\Models\\User', 127),
(4, 'App\\Models\\User', 128),
(4, 'App\\Models\\User', 129),
(4, 'App\\Models\\User', 130),
(4, 'App\\Models\\User', 131),
(4, 'App\\Models\\User', 132),
(4, 'App\\Models\\User', 133),
(4, 'App\\Models\\User', 134),
(4, 'App\\Models\\User', 135),
(4, 'App\\Models\\User', 136),
(4, 'App\\Models\\User', 137),
(4, 'App\\Models\\User', 138),
(4, 'App\\Models\\User', 139),
(4, 'App\\Models\\User', 140),
(4, 'App\\Models\\User', 141),
(4, 'App\\Models\\User', 142),
(4, 'App\\Models\\User', 143),
(4, 'App\\Models\\User', 144),
(4, 'App\\Models\\User', 145),
(4, 'App\\Models\\User', 146),
(4, 'App\\Models\\User', 147),
(4, 'App\\Models\\User', 148),
(4, 'App\\Models\\User', 149),
(4, 'App\\Models\\User', 150),
(4, 'App\\Models\\User', 151),
(4, 'App\\Models\\User', 152),
(4, 'App\\Models\\User', 153),
(4, 'App\\Models\\User', 154),
(4, 'App\\Models\\User', 155),
(4, 'App\\Models\\User', 156),
(4, 'App\\Models\\User', 157),
(4, 'App\\Models\\User', 158),
(4, 'App\\Models\\User', 159),
(4, 'App\\Models\\User', 160),
(4, 'App\\Models\\User', 161),
(4, 'App\\Models\\User', 162),
(4, 'App\\Models\\User', 163),
(4, 'App\\Models\\User', 164),
(4, 'App\\Models\\User', 165),
(4, 'App\\Models\\User', 166),
(4, 'App\\Models\\User', 167),
(4, 'App\\Models\\User', 168),
(4, 'App\\Models\\User', 169),
(4, 'App\\Models\\User', 170),
(4, 'App\\Models\\User', 171),
(4, 'App\\Models\\User', 172),
(4, 'App\\Models\\User', 173),
(4, 'App\\Models\\User', 174),
(4, 'App\\Models\\User', 175),
(4, 'App\\Models\\User', 176),
(4, 'App\\Models\\User', 177),
(4, 'App\\Models\\User', 178),
(4, 'App\\Models\\User', 179),
(4, 'App\\Models\\User', 180),
(4, 'App\\Models\\User', 181),
(4, 'App\\Models\\User', 182),
(4, 'App\\Models\\User', 183),
(4, 'App\\Models\\User', 184),
(4, 'App\\Models\\User', 185),
(4, 'App\\Models\\User', 186),
(4, 'App\\Models\\User', 187),
(4, 'App\\Models\\User', 188),
(4, 'App\\Models\\User', 189),
(4, 'App\\Models\\User', 190),
(4, 'App\\Models\\User', 191),
(4, 'App\\Models\\User', 192),
(4, 'App\\Models\\User', 193);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('005c7e9c-e175-4fb0-89ae-d14b0a769fa4', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":29}', NULL, '2024-08-03 07:12:16', '2024-08-03 07:12:16'),
('03036e74-20e8-4c5d-a489-9e561b538f71', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":21}', NULL, '2024-07-31 14:34:16', '2024-07-31 14:34:16'),
('034ca1f1-2d06-4b23-88e4-6da85714a940', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-07-30 22:43:57', '2024-07-30 22:43:57'),
('0461f480-bf38-4058-bfda-3a4db30dac22', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":30}', NULL, '2024-08-02 01:46:06', '2024-08-02 01:46:06'),
('0ae7ff6c-0818-49d4-a3cf-3f1ab0e72468', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":41}', NULL, '2024-08-06 17:05:25', '2024-08-06 17:05:25'),
('0d371847-e533-4d6d-8162-48ae658c6dea', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 21:08:51', '2024-07-06 21:08:51'),
('0e824d0c-ef59-4de0-9073-03aa2ce9f731', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":25}', NULL, '2024-08-01 06:28:52', '2024-08-01 06:28:52'),
('0e93eaa5-0cc6-4562-aca1-89c878447366', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 57, '{\"booking_id\":53}', '2025-04-04 19:41:55', '2025-04-04 19:33:51', '2025-04-04 19:41:55'),
('0f153e3d-cbde-45d1-8c99-a7b9e54523d6', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 13, '{\"booking_id\":34}', NULL, '2024-08-03 14:43:09', '2024-08-03 14:43:09'),
('106586ee-a03a-4f2c-bdc8-7a7b85cc3d81', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":3}', NULL, '2024-07-06 21:38:13', '2024-07-06 21:38:13'),
('106c6446-7b59-4167-bb23-451cf1f6a879', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":12}', '2024-07-22 19:36:20', '2024-07-22 19:36:16', '2024-07-22 19:36:20'),
('10b0422c-30d3-4ff5-a14a-125d159d16f3', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 20:28:29', '2024-07-06 20:28:29'),
('128f9514-6840-44ce-bfaf-2bf72890433d', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":4}', NULL, '2024-07-09 05:09:54', '2024-07-09 05:09:54'),
('1393da52-2c21-4c09-be78-aabf7e587a85', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 21:07:33', '2024-07-06 21:07:33'),
('13ce588e-64f0-4396-815d-5406b2d68c3b', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:55:14', '2024-07-10 21:55:14'),
('174e5599-115d-4e95-a53d-27acdbe10436', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":10}', NULL, '2024-07-14 21:25:40', '2024-07-14 21:25:40'),
('17a7ca6b-9261-471b-aeca-489d93016448', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":22}', NULL, '2024-07-31 20:48:59', '2024-07-31 20:48:59'),
('1822c5c7-0034-45d8-841a-7daceed3bdf1', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:17:41', '2024-07-10 21:17:41'),
('1a347e95-b46d-4613-9501-badf5d902641', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":48}', NULL, '2024-08-29 16:25:32', '2024-08-29 16:25:32'),
('1a4a6f05-c933-4ea8-aad3-935393d33b7d', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":29}', NULL, '2024-08-01 21:17:04', '2024-08-01 21:17:04'),
('1a59af10-cf4f-41e1-b0fb-3db161b5ce13', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":15}', NULL, '2024-07-30 23:15:33', '2024-07-30 23:15:33'),
('1a7e8986-7e4f-4101-9594-7bb645bdc0a2', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":14}', NULL, '2024-07-23 17:14:59', '2024-07-23 17:14:59'),
('1b2ece32-afba-45d6-88d6-d41c44f98b8d', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 8, '{\"booking_id\":45}', NULL, '2024-08-12 02:08:40', '2024-08-12 02:08:40'),
('1b9e0520-d178-4d3c-af22-1e206bda23a3', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":3}', NULL, '2024-07-07 22:23:09', '2024-07-07 22:23:09'),
('1d86d72d-ce03-49c3-806d-eca0451bf7d3', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":15}', NULL, '2024-07-30 22:46:32', '2024-07-30 22:46:32'),
('1e18fa65-bae4-4a34-a6ab-e45f23e6f960', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-11 19:51:06', '2024-07-11 19:51:06'),
('1ed674b7-ac92-4aec-a3f1-b4381b8adabf', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 21:15:31', '2024-07-06 21:15:31'),
('2064da63-297a-4866-8238-2c907a7e1cda', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:50:57', '2024-07-10 21:50:57'),
('20af4e48-fd20-43f2-a917-ae1bead0959f', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":28}', NULL, '2024-08-01 21:06:55', '2024-08-01 21:06:55'),
('248e3ccd-c5b6-4d18-8e57-fdf47aef513d', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":16}', NULL, '2024-07-30 22:50:22', '2024-07-30 22:50:22'),
('258d6046-771f-4854-b558-8c4666f9fa03', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":51}', NULL, '2025-03-26 14:32:28', '2025-03-26 14:32:28'),
('2647ad32-5f0f-434b-8879-7198542d4e5b', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":46}', NULL, '2024-08-22 22:42:18', '2024-08-22 22:42:18'),
('2672bdc5-3af0-40b8-a4ef-2325d2ff2113', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":14}', NULL, '2024-07-23 17:14:18', '2024-07-23 17:14:18'),
('26eada7f-e6fd-4d45-a7b8-3c7f9d215a8b', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 21:11:40', '2024-07-06 21:11:40'),
('2723833e-8d80-4962-85ef-cdc4d6d11cc5', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":12}', '2024-07-22 19:44:00', '2024-07-22 19:42:40', '2024-07-22 19:44:00'),
('2729f371-f6cc-405f-ae9f-eff0a3055d5b', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":14}', NULL, '2024-07-31 20:44:23', '2024-07-31 20:44:23'),
('28d78eea-e4c2-4424-af9f-070551152497', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":14}', NULL, '2024-07-31 20:31:18', '2024-07-31 20:31:18'),
('2a19e811-7fb8-4ffd-9adb-ac52c5c44aa1', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":46}', NULL, '2024-08-22 22:30:41', '2024-08-22 22:30:41'),
('2a3e40f2-1235-4773-b884-b4bed283bfff', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 21:14:36', '2024-07-06 21:14:36'),
('2b69d2d7-d69b-4a10-a933-7bb6b78c4716', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:33:01', '2024-07-10 21:33:01'),
('2b99eab9-9b4b-481d-90fd-6b3d646b9dc0', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":12}', NULL, '2024-07-22 19:33:50', '2024-07-22 19:33:50'),
('2bbac4dd-3060-483b-ab3a-19e63f1724eb', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":31}', NULL, '2024-08-02 21:49:20', '2024-08-02 21:49:20'),
('2c434992-ab99-4a04-b614-5b83d49c5155', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":48}', NULL, '2024-08-29 16:25:09', '2024-08-29 16:25:09'),
('2c77e51a-683b-4e06-8107-859e67497ec8', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-07-30 22:52:00', '2024-07-30 22:52:00'),
('2e28c842-a2f1-48b8-acd6-2f69e5b0a1ae', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":39}', NULL, '2024-08-06 16:06:20', '2024-08-06 16:06:20'),
('2f21abd0-3927-4931-af4f-1c49bf570eee', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 13, '{\"booking_id\":30}', NULL, '2024-08-02 02:03:56', '2024-08-02 02:03:56'),
('301d7d42-e243-40c0-b545-167da49bca29', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":47}', NULL, '2024-08-29 16:19:22', '2024-08-29 16:19:22'),
('3288a632-be0f-40ec-a952-7145dfddd34f', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:21:05', '2024-07-10 21:21:05'),
('32f86408-711c-45e0-a8e1-788de80aadbc', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":42}', NULL, '2024-08-06 17:33:30', '2024-08-06 17:33:30'),
('34c441cf-7011-458a-ac73-e3ca7ec2023b', 'App\\Notifications\\NewMessage', 'App\\Models\\User', 10, '{\"from\":\"Jennifer Paul\",\"message_id\":\"Instance of \'UniqueKey\'\"}', NULL, '2024-07-22 20:02:15', '2024-07-22 20:02:15'),
('352229d6-9b6d-4294-8005-d5049671b4cb', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:17:21', '2024-07-16 23:17:21'),
('3554ca95-f80c-4870-8bbc-435ea6f2e7a6', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 57, '{\"booking_id\":54}', NULL, '2025-04-04 19:43:55', '2025-04-04 19:43:55'),
('359c6555-c49a-465b-817d-38b2cefbc10f', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":33}', NULL, '2024-08-03 07:24:53', '2024-08-03 07:24:53'),
('36a5314f-95b5-4710-8df6-70845e38c23b', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":9}', NULL, '2024-07-10 17:56:58', '2024-07-10 17:56:58'),
('371e8a35-3a0e-4410-9acc-a67d3c932cb3', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":1}', '2024-07-09 03:49:16', '2024-07-08 21:43:49', '2024-07-09 03:49:16'),
('373ed721-1014-4095-ae88-2c8548e35543', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":36}', NULL, '2024-08-03 23:02:59', '2024-08-03 23:02:59'),
('37d14208-ec10-47cc-923b-658baec9779c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":16}', NULL, '2024-07-30 22:36:41', '2024-07-30 22:36:41'),
('3c1ceef8-4ac2-42cb-bb47-3117e5b578e1', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":2}', NULL, '2024-07-07 23:02:58', '2024-07-07 23:02:58'),
('3c737f0e-5544-43d8-8ac0-87a64e382ab5', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":52}', NULL, '2025-03-28 18:04:41', '2025-03-28 18:04:41'),
('3cc46618-3c38-4e1e-8c8c-2645bd440232', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":18}', NULL, '2024-11-27 22:22:00', '2024-11-27 22:22:00'),
('3cdaf7b4-5c41-4ead-82f0-2dae95a9778a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 11, '{\"booking_id\":5}', NULL, '2024-07-09 05:04:46', '2024-07-09 05:04:46'),
('3dcc14c2-d522-4bd2-8e9e-aa9a9dc7725f', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":28}', NULL, '2024-08-03 07:22:53', '2024-08-03 07:22:53'),
('3f142e6c-297d-4c3e-844e-74087737b4c2', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 57, '{\"booking_id\":54}', NULL, '2025-04-04 19:50:46', '2025-04-04 19:50:46'),
('3f1b6728-2fe1-456c-8c0d-b2103901cc95', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":15}', NULL, '2024-07-28 23:03:14', '2024-07-28 23:03:14'),
('40ab557d-124c-4cfa-ab68-ce5075164039', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":12}', NULL, '2024-07-22 19:42:32', '2024-07-22 19:42:32'),
('4207edf8-2f91-4693-8aa0-609e94681fa5', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":29}', NULL, '2024-08-01 21:17:20', '2024-08-01 21:17:20'),
('422104e4-a4bb-4249-91e7-00e50f1dbf21', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":27}', NULL, '2024-08-01 07:11:43', '2024-08-01 07:11:43'),
('43545df1-b4ce-460b-971e-47a9e346e411', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 8, '{\"booking_id\":33}', NULL, '2024-08-10 23:35:32', '2024-08-10 23:35:32'),
('44bc1b15-5c2d-4e87-9773-cdd127ac1a50', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":4}', NULL, '2024-07-09 01:58:04', '2024-07-09 01:58:04'),
('44d79f0b-da59-40fc-8155-4f714c019273', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 56, '{\"booking_id\":53}', NULL, '2025-04-04 20:12:54', '2025-04-04 20:12:54'),
('45daaaca-516a-4d53-b9d8-e789ecdf805e', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":46}', NULL, '2024-08-22 22:49:54', '2024-08-22 22:49:54'),
('46769032-60af-45d7-bac7-40997278ca78', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":7}', '2024-07-09 15:42:27', '2024-07-09 15:39:16', '2024-07-09 15:42:27'),
('46a156f2-4999-49e4-88cc-e9cd66dc940c', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 10, '{\"booking_id\":7}', NULL, '2024-07-09 15:48:37', '2024-07-09 15:48:37'),
('47acfcd2-a1fe-43c2-a793-fa13c45002bf', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":29}', NULL, '2024-08-03 07:21:49', '2024-08-03 07:21:49'),
('48348780-4c9b-4d53-a71b-cdd031e3e3a1', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-08-01 19:56:15', '2024-08-01 19:56:15'),
('4a800196-a7f4-454d-b087-01867395e84c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":13}', NULL, '2024-07-23 14:26:29', '2024-07-23 14:26:29'),
('4b64aadb-dab0-4c51-bb23-cc99cfe65cc0', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":16}', NULL, '2024-07-30 22:51:19', '2024-07-30 22:51:19'),
('4b9aa761-fe14-4521-92fb-001d2c6c3857', 'App\\Notifications\\NewMessage', 'App\\Models\\User', 9, '{\"from\":\"Jennifer Paul\",\"message_id\":\"Instance of \'UniqueKey\'\"}', '2024-07-06 15:17:03', '2024-07-06 15:16:40', '2024-07-06 15:17:03'),
('4ba07da5-6ab7-45e2-9e91-063ab33e2f4a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:29:21', '2024-07-16 23:29:21'),
('4bfc593c-87cb-42ef-b531-9e98458ef79e', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-07-30 22:51:42', '2024-07-30 22:51:42'),
('4c4e79bb-21f7-42e1-9caa-5c07ae16bee4', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-11 19:46:29', '2024-07-11 19:46:29'),
('4eb00b3a-5e0c-46ef-8186-e29427447bf0', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":19}', NULL, '2024-07-29 20:06:50', '2024-07-29 20:06:50'),
('50976316-bbc6-4052-ac82-fef087d6f775', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 2, '{\"booking_id\":15}', NULL, '2024-07-30 22:54:35', '2024-07-30 22:54:35'),
('53158d25-f551-4d47-adb6-1554140260b7', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":43}', NULL, '2024-08-06 18:07:04', '2024-08-06 18:07:04'),
('54ce4c3f-e422-4c5c-9765-cb21437b3ef1', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":51}', NULL, '2025-03-26 14:30:45', '2025-03-26 14:30:45'),
('56353636-f697-4c66-b4d6-95fae07b2c4d', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":38}', NULL, '2024-08-06 15:16:35', '2024-08-06 15:16:35'),
('567d7cfb-ca77-431c-a775-03a9f6d96dd9', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":43}', NULL, '2024-08-06 17:56:25', '2024-08-06 17:56:25'),
('59e79df4-c58e-4e20-8fbd-a62f41bcd19f', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":27}', NULL, '2024-08-01 07:11:28', '2024-08-01 07:11:28'),
('5a268492-0492-4820-8569-9b74a41b01b4', 'App\\Notifications\\NewMessage', 'App\\Models\\User', 2, '{\"from\":\"oluwaseun pepper\",\"message_id\":\"Instance of \'UniqueKey\'\"}', '2024-07-06 15:16:33', '2024-07-06 15:14:30', '2024-07-06 15:16:33'),
('5b511fa3-28be-43e4-bfd4-99525c3ee0a0', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 8, '{\"booking_id\":29}', NULL, '2024-08-11 08:39:28', '2024-08-11 08:39:28'),
('5c327b6d-36bb-4f3e-a654-ff208765162f', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":12}', '2024-07-22 19:39:50', '2024-07-22 19:35:19', '2024-07-22 19:39:50'),
('5cf9ede5-e8d8-482d-ba41-3c890e0c6dca', 'App\\Notifications\\NewMessage', 'App\\Models\\User', 10, '{\"from\":\"Jennifer Paul\",\"message_id\":\"Instance of \'UniqueKey\'\"}', NULL, '2024-07-22 20:01:56', '2024-07-22 20:01:56'),
('5d9dd5d1-f4a0-4c13-9d4d-e689e40da89e', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-07-28 23:07:24', '2024-07-28 23:07:24'),
('5dc0dac1-1d3d-41e3-99b5-b51ece789799', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-23 17:13:49', '2024-07-23 17:13:49'),
('5f31b014-644a-43f2-8f94-0494da66d4b2', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:23:00', '2024-07-16 23:23:00'),
('6029df76-0976-4c57-80b4-f827d5b1e7bc', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":24}', NULL, '2024-07-31 23:29:39', '2024-07-31 23:29:39'),
('617610a6-bdb2-4f0e-b8de-457cb966066d', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":7}', NULL, '2024-07-09 15:36:46', '2024-07-09 15:36:46'),
('668b55bf-5711-4824-a36c-419e41d065c8', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":23}', NULL, '2024-07-31 22:57:28', '2024-07-31 22:57:28'),
('67a1cbe7-204f-48c3-b902-bfd15157df98', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":18}', NULL, '2024-07-29 19:22:59', '2024-07-29 19:22:59'),
('68fe9e3f-6ee6-4316-b704-f81e5b6d3a92', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":49}', NULL, '2024-08-29 16:28:32', '2024-08-29 16:28:32'),
('6a3da535-5114-461b-82f5-a44c16278e68', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":24}', NULL, '2024-07-31 23:32:44', '2024-07-31 23:32:44'),
('6a5ac0e4-0476-45c4-8aa7-7ad71e3e3ffd', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 2, '{\"booking_id\":46}', NULL, '2024-08-22 22:35:38', '2024-08-22 22:35:38'),
('6bc42db3-2153-47a9-8cca-81284deb975a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":11}', NULL, '2024-11-27 22:45:31', '2024-11-27 22:45:31'),
('6c0b9163-5f9a-4d52-a74b-698ed5ede4b0', 'App\\Notifications\\NewEProviderPayout', 'App\\Models\\User', 1, '{\"e_provider_payout_id\":6}', NULL, '2024-08-22 23:01:44', '2024-08-22 23:01:44'),
('6c5b58bc-3c06-4314-bca6-d482dfec4893', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":5}', '2024-07-09 04:54:28', '2024-07-09 04:54:10', '2024-07-09 04:54:28'),
('6c9674ce-4985-435f-a427-d27c65fd2c3d', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-23 17:09:21', '2024-07-23 17:09:21'),
('6e696b52-e983-4112-8452-3ca8cd9b2700', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:24:56', '2024-07-16 23:24:56'),
('70601de2-f8da-4d86-855d-aa9ef42ef949', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":13}', NULL, '2024-07-23 14:28:58', '2024-07-23 14:28:58'),
('70ac9140-1781-4f4a-ab9f-f77225b7fcf2', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":24}', '2024-07-31 23:33:40', '2024-07-31 23:33:24', '2024-07-31 23:33:40'),
('710cebb4-fb3f-4625-9d3f-401b3b629948', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 11, '{\"booking_id\":41}', NULL, '2024-08-06 17:05:04', '2024-08-06 17:05:04'),
('72230da9-c5da-4831-80ae-2faa5f76fb49', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":46}', NULL, '2024-08-22 22:46:05', '2024-08-22 22:46:05'),
('727599a2-df9b-43b6-ab5e-341605bd42c5', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-07-31 20:50:48', '2024-07-31 20:50:48'),
('738831c2-1e2a-4b2c-b070-9ac18f3fbca4', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":29}', NULL, '2024-08-03 07:17:38', '2024-08-03 07:17:38'),
('75c4aa72-5cef-4552-80ce-30dace5e9c48', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 9, '{\"booking_id\":49}', NULL, '2024-08-29 16:40:55', '2024-08-29 16:40:55'),
('7635bfbd-f05e-4e45-8bce-6e3e30bb6619', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":22}', NULL, '2024-07-31 20:52:38', '2024-07-31 20:52:38'),
('77bcb158-ccab-4e97-8290-4d5387e4237c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 13, '{\"booking_id\":25}', '2024-08-01 06:32:05', '2024-08-01 06:29:20', '2024-08-01 06:32:05'),
('794d0029-8737-4e55-981b-f7ca95fab5fc', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":42}', NULL, '2024-08-06 17:32:44', '2024-08-06 17:32:44'),
('79638216-45ac-44a0-8c5f-89354748a4a2', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 13, '{\"booking_id\":31}', NULL, '2024-08-02 21:51:00', '2024-08-02 21:51:00'),
('7a463e59-7917-4ad8-8a1b-8bd23bc0856c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":3}', NULL, '2024-07-07 22:25:10', '2024-07-07 22:25:10'),
('7be074ce-dc61-4d70-b839-9f3241cf7773', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 9, '{\"booking_id\":5}', '2024-07-09 11:30:20', '2024-07-09 05:05:43', '2024-07-09 11:30:20'),
('7e2d7175-06a8-497a-9bd2-8e42bcf3cba2', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":10}', NULL, '2024-07-14 21:29:46', '2024-07-14 21:29:46'),
('7eb9a608-9857-439b-b33e-b8b2cfa859f7', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":15}', NULL, '2024-07-30 23:15:01', '2024-07-30 23:15:01'),
('7f905ea9-1629-4630-8c6d-d68f6dafe0d0', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":37}', '2024-08-06 14:53:43', '2024-08-06 14:52:46', '2024-08-06 14:53:43'),
('8003940c-d179-4b72-83a4-e094d282669d', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 11, '{\"booking_id\":5}', NULL, '2024-07-09 04:53:17', '2024-07-09 04:53:17'),
('8243a4bf-9847-477d-a47b-f905bff0fb0f', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:02:10', '2024-07-10 21:02:10'),
('833fce9a-f2a8-43bd-8219-5fec30cf64bd', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:50:27', '2024-07-10 21:50:27'),
('839376d1-58c0-478c-a642-1870313354fc', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":16}', NULL, '2024-07-30 22:35:18', '2024-07-30 22:35:18'),
('83c76d7e-b117-41fb-bb6b-0e331540f523', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":22}', NULL, '2024-07-31 20:57:54', '2024-07-31 20:57:54'),
('83f9b327-332c-46f8-8b27-42c3b7bcb84b', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 13, '{\"booking_id\":26}', '2024-08-01 06:40:49', '2024-08-01 06:35:34', '2024-08-01 06:40:49'),
('86209b03-3c76-410a-8057-e14811d4a049', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":35}', NULL, '2024-11-24 21:48:57', '2024-11-24 21:48:57'),
('864bd68c-a72a-4557-b1db-b8827865c7b3', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":24}', '2024-07-31 23:34:34', '2024-07-31 23:33:58', '2024-07-31 23:34:34'),
('86a5a569-6710-4ef8-b962-284a2b008f97', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:20:01', '2024-07-16 23:20:01'),
('88167fa3-a346-4de2-bb0d-615a3b964d9d', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":21}', NULL, '2024-07-31 14:33:17', '2024-07-31 14:33:17'),
('881a5f4f-68ab-4397-bcb6-507f005d4d4e', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":1}', NULL, '2024-07-06 15:06:23', '2024-07-06 15:06:23'),
('882af4ff-2c76-4eff-9357-a40db0003d53', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":7}', NULL, '2024-07-09 15:46:27', '2024-07-09 15:46:27'),
('8c83db43-731c-4f61-9339-f9b577889e3d', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-08-01 19:11:30', '2024-08-01 19:11:30'),
('8d203aee-01d3-4211-b102-dacb346c86b1', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":13}', '2024-07-23 14:28:54', '2024-07-23 14:27:12', '2024-07-23 14:28:54'),
('8d2a6a15-cd50-4441-b077-180819ddd79a', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":29}', NULL, '2024-08-03 07:24:32', '2024-08-03 07:24:32'),
('8df6ca1d-5faa-4a98-9dbb-5bc2d527df67', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":2}', NULL, '2024-07-06 20:27:13', '2024-07-06 20:27:13'),
('8f042849-89a4-4d89-a5b9-d4087a562a1c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":8}', NULL, '2024-07-15 23:18:56', '2024-07-15 23:18:56'),
('8f0f9357-9624-4f50-aa8a-99db10acbcfd', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 23:43:34', '2024-07-10 23:43:34'),
('8f56391c-86eb-4a79-ad99-8afd5e9a86ac', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":29}', NULL, '2024-08-03 07:09:17', '2024-08-03 07:09:17'),
('8f64a0ac-c29f-4f7c-8b3a-5c27e286693b', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":46}', NULL, '2024-08-22 22:32:48', '2024-08-22 22:32:48'),
('8fa87782-65d6-4b6c-8496-9f47925f9ed5', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-07 22:25:45', '2024-07-07 22:25:45'),
('9053fdab-9a25-4a03-9ade-35ac38cc21a8', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":27}', NULL, '2024-08-01 07:16:12', '2024-08-01 07:16:12'),
('91f1113e-f0dc-422f-8082-216ad518cf2d', 'App\\Notifications\\NewEProviderPayout', 'App\\Models\\User', 1, '{\"e_provider_payout_id\":4}', '2024-08-18 15:09:28', '2024-08-16 22:32:51', '2024-08-18 15:09:28'),
('93c3ad83-3e3f-4670-abd5-791397efc52a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":29}', NULL, '2024-08-07 21:35:20', '2024-08-07 21:35:20'),
('93d1a390-9632-4ff4-a00e-fc9fd7cfbc4b', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":3}', NULL, '2024-07-07 23:01:54', '2024-07-07 23:01:54'),
('963ecda3-c491-4326-b133-13f35c77a698', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":10}', '2024-07-14 21:28:40', '2024-07-14 21:28:14', '2024-07-14 21:28:40'),
('9797a274-ebdb-42ea-9f44-5ed7f33e69e1', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":2}', NULL, '2024-07-07 23:08:41', '2024-07-07 23:08:41'),
('982605e8-5cda-4beb-9abc-8bd4a1e652ab', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":5}', '2024-07-09 04:57:17', '2024-07-09 04:54:06', '2024-07-09 04:57:17'),
('9940b2bb-503f-4680-b42c-e89ed3f2fdab', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 20:58:54', '2024-07-10 20:58:54'),
('9951b298-9806-42fe-bb0d-164c3d2eb2b2', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":13}', NULL, '2024-07-23 14:24:38', '2024-07-23 14:24:38'),
('99846875-9054-4d56-ba4b-00b49c06cec1', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":4}', NULL, '2024-07-09 03:49:00', '2024-07-09 03:49:00'),
('9ba2fb8a-b365-4d89-a98c-486a9859f41f', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":35}', NULL, '2024-08-03 22:52:05', '2024-08-03 22:52:05'),
('9c0aee44-d849-468d-ad11-85bba4c0fac6', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":17}', '2024-07-29 18:53:41', '2024-07-29 18:53:28', '2024-07-29 18:53:41'),
('9c9cba21-24ba-449b-a983-0d5d8bbefabd', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":50}', NULL, '2024-10-10 13:50:04', '2024-10-10 13:50:04'),
('9de26b28-9d20-4ddb-a8e3-44532b340772', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":20}', '2024-07-31 13:34:18', '2024-07-31 13:33:56', '2024-07-31 13:34:18'),
('9e473451-ebc9-47c3-9d4e-3fa6f8cb2f84', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-08-01 20:02:57', '2024-08-01 20:02:57'),
('9ede10d2-41a7-4ebb-adc4-f013983f6f75', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":7}', NULL, '2024-07-09 14:39:13', '2024-07-09 14:39:13'),
('9eea4c45-bd43-4a5d-a7fe-1f5b16367391', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:53:22', '2024-07-10 21:53:22'),
('a1149d49-69a4-4325-99dd-9b3f2686d695', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 11, '{\"booking_id\":5}', NULL, '2024-07-09 05:04:33', '2024-07-09 05:04:33'),
('a1d838a6-fba7-47d9-b7d9-372daddd1692', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":1}', '2024-07-06 15:13:26', '2024-07-06 15:07:47', '2024-07-06 15:13:26'),
('a3c4a38b-ea81-484e-a387-e7c45ee61385', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-07-29 18:55:14', '2024-07-29 18:55:14'),
('a3c5dcc6-2c3e-4e7d-bf3e-12daa9c4117d', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 20:29:27', '2024-07-06 20:29:27'),
('a4733e3f-1b1f-4960-842f-c351dff2b056', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 9, '{\"booking_id\":49}', NULL, '2024-08-29 16:30:35', '2024-08-29 16:30:35'),
('a5435142-154e-4c4b-b4e1-4a378ce6d44a', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":40}', NULL, '2024-08-06 16:07:29', '2024-08-06 16:07:29'),
('a5f9d706-9a7f-4109-9880-5ce8850918ee', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:23:05', '2024-07-10 21:23:05'),
('a724bb14-b457-4f20-9f2b-a88bc1099242', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 8, '{\"booking_id\":44}', NULL, '2024-08-10 23:39:11', '2024-08-10 23:39:11'),
('a7954095-47ce-4f20-952c-b7e8d14fd5a1', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":37}', NULL, '2024-08-06 14:49:16', '2024-08-06 14:49:16'),
('a85760b2-d3dd-4443-b704-bc9ae8ff44d3', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:54:48', '2024-07-10 21:54:48'),
('a980c9ab-4cf8-4689-9400-3dfe86cedc60', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:07:40', '2024-07-16 23:07:40'),
('a9cda027-38ec-4192-914b-2f8903ae7fe7', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 11, '{\"booking_id\":49}', NULL, '2024-08-29 16:27:20', '2024-08-29 16:27:20'),
('aca4e44d-5726-4a38-a9fd-3de2ee5ad041', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 11, '{\"booking_id\":55}', NULL, '2025-04-04 20:31:28', '2025-04-04 20:31:28'),
('ad218d62-0348-44fb-a65f-69e2736689b2', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":39}', NULL, '2024-08-06 16:05:48', '2024-08-06 16:05:48'),
('ad41ba8c-519f-4e84-af6e-8c020a901d37', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":6}', NULL, '2024-07-09 14:29:21', '2024-07-09 14:29:21'),
('af560d06-da7a-45ae-9a1b-9c89c43d64c0', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":2}', NULL, '2024-07-06 21:18:45', '2024-07-06 21:18:45'),
('afaac162-ea84-47f6-a3b6-431529a67a37', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":6}', NULL, '2024-07-09 14:38:42', '2024-07-09 14:38:42'),
('b082f234-bcfc-4c72-96f4-b53cc5c5be1d', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 15, '{\"booking_id\":32}', NULL, '2024-08-03 05:00:42', '2024-08-03 05:00:42'),
('b2fb1bbf-d233-440a-bd75-426c119f2ec8', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:58:30', '2024-07-10 21:58:30'),
('b356849a-b03c-42e7-a452-e47b86dffd61', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:00:48', '2024-07-16 23:00:48'),
('b3fdebed-1a62-4523-babf-08ea9364965b', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":19}', NULL, '2024-11-26 12:33:31', '2024-11-26 12:33:31'),
('b7f37bc5-7116-48c0-bd82-9e20eca6ac20', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 11, '{\"booking_id\":5}', NULL, '2024-07-10 21:58:59', '2024-07-10 21:58:59'),
('b9b94270-79f8-4179-b4f7-29adfad7ab18', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-11 19:47:50', '2024-07-11 19:47:50'),
('bb8c0e34-6315-4bff-850d-b0cae72b14de', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":3}', NULL, '2024-07-07 22:17:27', '2024-07-07 22:17:27'),
('bead0d83-8c8a-4e28-9308-aac5f2d5b968', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":56}', NULL, '2025-05-30 11:53:15', '2025-05-30 11:53:15'),
('bf4692db-9d98-4085-9e91-936e2c60c20f', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":43}', NULL, '2024-08-06 17:55:37', '2024-08-06 17:55:37'),
('c20befb5-f412-49b4-ad52-c0ebe87b6092', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 16, '{\"booking_id\":38}', NULL, '2024-08-06 15:20:02', '2024-08-06 15:20:02'),
('c4036aa5-42d4-46a4-a0de-582dcfc532fe', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 8, '{\"booking_id\":29}', NULL, '2024-08-12 03:18:44', '2024-08-12 03:18:44'),
('c49ccde3-b5e0-46f1-b8f0-0e06d791c156', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 2, '{\"booking_id\":7}', NULL, '2024-07-09 15:47:31', '2024-07-09 15:47:31'),
('c4c2bd19-601d-42dc-98ec-4c7f2e9f750a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":14}', NULL, '2024-07-28 22:47:14', '2024-07-28 22:47:14'),
('c4ee85f3-4769-4786-871c-63237c151244', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":7}', '2024-07-09 15:46:18', '2024-07-09 15:45:41', '2024-07-09 15:46:18'),
('c7b2646c-fcb7-4f27-a62d-e8cf5bb7c786', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 13, '{\"booking_id\":34}', NULL, '2024-08-04 00:16:55', '2024-08-04 00:16:55'),
('c7ef98aa-6e35-4844-a997-aa79ba19b404', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":34}', NULL, '2024-08-03 10:16:09', '2024-08-03 10:16:09'),
('c7f53c0c-02d0-447d-979e-6325fdc6fb31', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":28}', NULL, '2024-08-01 21:07:06', '2024-08-01 21:07:06'),
('c9cbd883-21a4-4971-9c38-8a4925191470', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":13}', NULL, '2024-07-23 14:29:02', '2024-07-23 14:29:02'),
('cc0cbb51-cb4c-43f6-917c-40501104487e', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 3, '{\"booking_id\":50}', NULL, '2024-11-24 21:47:27', '2024-11-24 21:47:27'),
('cd22ab88-5d6a-44e7-bc6d-7229e088744f', 'App\\Notifications\\NewEProviderPayout', 'App\\Models\\User', 1, '{\"e_provider_payout_id\":7}', '2025-07-13 01:29:32', '2024-08-23 21:01:51', '2025-07-13 01:29:32'),
('ce754710-0513-4e5b-8441-ad978e6d9f93', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":10}', '2024-07-14 21:33:43', '2024-07-14 21:31:50', '2024-07-14 21:33:43'),
('cee769b2-3e7e-4200-8d05-9257e2aaf933', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:31:07', '2024-07-10 21:31:07'),
('d162d57e-fd79-4782-acc9-df1891b7c062', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":10}', '2024-07-14 21:29:32', '2024-07-14 21:29:04', '2024-07-14 21:29:32'),
('d1e16d84-1c35-4613-bdf9-ae3f0d12dc4a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 23:41:11', '2024-07-10 23:41:11'),
('d271b700-d983-4260-86d7-e55020874334', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":3}', NULL, '2024-07-07 22:59:43', '2024-07-07 22:59:43'),
('d299bcef-a43d-4ffc-a056-f332b449c5aa', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":8}', NULL, '2024-07-23 17:42:26', '2024-07-23 17:42:26'),
('d3210fb0-a438-45b1-8120-12676063a0fa', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":44}', NULL, '2024-08-10 23:37:41', '2024-08-10 23:37:41'),
('d3bc2178-4bae-4a5d-a171-47a66eb871d4', 'App\\Notifications\\NewMessage', 'App\\Models\\User', 10, '{\"from\":\"Jennifer Paul\",\"message_id\":\"Instance of \'UniqueKey\'\"}', NULL, '2024-07-22 20:02:23', '2024-07-22 20:02:23'),
('d40d0d98-97de-4d0b-b989-4d7b34ee1821', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 56, '{\"booking_id\":53}', NULL, '2025-04-04 20:12:45', '2025-04-04 20:12:45'),
('d416148f-ffd1-4d44-86eb-1af34e1d6b71', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":29}', NULL, '2024-08-07 21:26:32', '2024-08-07 21:26:32'),
('d45e4524-4091-4ac6-b3ce-38d5d73d571c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":24}', NULL, '2024-07-31 23:33:46', '2024-07-31 23:33:46'),
('d5136f08-a311-418e-b665-b3aaf10784fb', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-08-01 19:57:58', '2024-08-01 19:57:58'),
('da143f84-52d0-4087-b94a-6bd1057fb6ff', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":10}', '2024-07-14 21:26:40', '2024-07-14 21:26:14', '2024-07-14 21:26:40'),
('dbbca83a-7468-45f3-bb40-65a9cece0f82', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":56}', NULL, '2025-05-30 13:01:57', '2025-05-30 13:01:57'),
('dcd7bb47-7e23-4c0c-9bdd-aa7eac55f5e6', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:57:31', '2024-07-10 21:57:31'),
('dd01fea1-b9f7-4294-b1c2-cbe807c01846', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":24}', NULL, '2024-07-31 23:30:03', '2024-07-31 23:30:03'),
('dd7ed101-af6c-4ec0-ab46-9bf33b6afc33', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":8}', NULL, '2024-07-09 23:51:41', '2024-07-09 23:51:41'),
('dd9cf2e5-743a-4a05-bf8d-6dbd5ff1a3e4', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":32}', NULL, '2024-08-03 04:57:37', '2024-08-03 04:57:37'),
('de95de6c-78d6-4893-9f00-54e7aa64487a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:39:22', '2024-07-10 21:39:22'),
('dea386fe-ac41-49d8-8757-6add09329da1', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":40}', NULL, '2024-08-06 16:08:00', '2024-08-06 16:08:00'),
('df8a62ea-4472-4c01-8887-3a34189e7fae', 'App\\Notifications\\NewEProviderPayout', 'App\\Models\\User', 1, '{\"e_provider_payout_id\":3}', NULL, '2024-08-16 22:19:45', '2024-08-16 22:19:45'),
('e2104c29-4e1e-4417-a0ba-813a1514d328', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":2}', NULL, '2024-07-06 21:36:19', '2024-07-06 21:36:19'),
('e27a35a6-138f-4439-b460-75e03ecdd187', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":36}', NULL, '2024-11-25 07:21:02', '2024-11-25 07:21:02'),
('e365f5f7-9302-469e-8bd9-229e378bc932', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:28:27', '2024-07-10 21:28:27'),
('e3f91cf1-3bc2-43f7-b3b4-fb1453c29702', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":4}', NULL, '2024-07-09 01:59:10', '2024-07-09 01:59:10'),
('e612270f-fa2a-4ad2-bda8-33c2a8dd5dac', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 7, '{\"booking_id\":3}', NULL, '2024-07-07 22:59:13', '2024-07-07 22:59:13'),
('e7a5a2de-2803-425c-bcd6-79ed276a8eec', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":33}', NULL, '2024-08-03 07:25:08', '2024-08-03 07:25:08'),
('e7e383a7-8394-47ea-8792-d6023aaf2944', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:55:55', '2024-07-10 21:55:55'),
('e828ff32-f4ca-40be-980d-177f6312d5c7', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":17}', '2024-07-29 18:51:33', '2024-07-29 18:51:22', '2024-07-29 18:51:33'),
('e8ae66ee-2d5e-44d6-b25c-21cc30ab5236', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 57, '{\"booking_id\":53}', '2025-04-04 19:42:05', '2025-04-04 19:28:14', '2025-04-04 19:42:05'),
('e9353fdb-4079-42c5-90b0-6ee03ee8f841', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 22:47:02', '2024-07-10 22:47:02'),
('eac7dff3-337e-4495-aa4b-0c06260a6866', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 8, '{\"booking_id\":45}', NULL, '2024-08-12 02:08:01', '2024-08-12 02:08:01'),
('eb44480a-5702-4973-8bda-f41fd7c2321c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":23}', NULL, '2024-07-31 22:58:24', '2024-07-31 22:58:24'),
('ed1de6bd-6c3e-46e5-a951-0edd71a72d7e', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 21:51:40', '2024-07-10 21:51:40'),
('ef423821-94f4-4f4a-9d80-6fd05f921cc3', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":24}', '2024-07-31 23:32:27', '2024-07-31 23:31:52', '2024-07-31 23:32:27'),
('efba94f1-2da7-49ef-a364-22e0fed80b45', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":15}', NULL, '2024-07-30 23:15:39', '2024-07-30 23:15:39'),
('f0d4d47c-00a2-40d2-993c-1d90b3ba2394', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":8}', NULL, '2024-07-23 16:54:37', '2024-07-23 16:54:37'),
('f13ec5d2-457c-4770-97df-00a4a6f37aa2', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 11, '{\"booking_id\":5}', NULL, '2024-07-10 21:58:50', '2024-07-10 21:58:50'),
('f14c921a-461a-4eae-8c3b-f694be5d5cf4', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":42}', NULL, '2024-08-06 21:48:39', '2024-08-06 21:48:39'),
('f17922b4-61a6-4c8c-90fe-88a10fdb739b', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":16}', NULL, '2024-08-01 19:44:30', '2024-08-01 19:44:30'),
('f1c2fae9-ad09-4249-b75d-e354e3160bcd', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":17}', NULL, '2024-07-29 18:48:13', '2024-07-29 18:48:13'),
('f35f7910-7134-4daf-b735-3d5ca7df36bc', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":45}', NULL, '2024-08-12 02:07:47', '2024-08-12 02:07:47'),
('f3638912-c1a8-4798-aa89-75abdc3986a9', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-16 23:03:31', '2024-07-16 23:03:31'),
('f39a51b1-3f20-4fbd-8709-e29eef319068', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":15}', NULL, '2024-07-30 23:15:17', '2024-07-30 23:15:17'),
('f4cc7572-8c12-43c7-b7d0-642e5c12bca6', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":3}', NULL, '2024-07-07 23:01:14', '2024-07-07 23:01:14'),
('f646a18d-0a55-475b-8d45-e6018688351e', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":11}', NULL, '2024-07-15 01:31:38', '2024-07-15 01:31:38'),
('f7b00b3a-6c3f-4525-8cce-4ffd62ced998', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":5}', NULL, '2024-07-09 05:03:23', '2024-07-09 05:03:23'),
('f7bc1247-9f8d-4745-97a4-38328ab2a0e7', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 8, '{\"booking_id\":8}', NULL, '2024-07-10 22:45:39', '2024-07-10 22:45:39'),
('f80c688b-c769-450d-a861-a669a70f7738', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":47}', '2024-08-29 16:18:48', '2024-08-29 16:18:13', '2024-08-29 16:18:48'),
('f87157d8-a5a8-4c0d-ab86-7b154b8ad350', 'App\\Notifications\\NewEProviderPayout', 'App\\Models\\User', 1, '{\"e_provider_payout_id\":5}', NULL, '2024-08-22 23:00:20', '2024-08-22 23:00:20'),
('f96b0ea0-61f2-42e7-a77b-5a0c953c671b', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":32}', NULL, '2024-08-03 05:13:40', '2024-08-03 05:13:40'),
('f96b2d63-826b-476c-92db-af24b2904f58', 'App\\Notifications\\StatusChangedPayment', 'App\\Models\\User', 11, '{\"booking_id\":5}', '2024-07-09 05:05:37', '2024-07-09 05:05:18', '2024-07-09 05:05:37'),
('f9aecde3-c30f-4a35-959f-3aaa8afb3d5c', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 9, '{\"booking_id\":46}', NULL, '2024-08-22 22:37:54', '2024-08-22 22:37:54'),
('fa0cc2cf-1d5e-4089-b8c5-e75f3552239a', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":26}', '2024-08-01 06:35:16', '2024-08-01 06:34:32', '2024-08-01 06:35:16'),
('fb74aba2-ddc4-4ef2-b6ea-07a9416a49a2', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 8, '{\"booking_id\":44}', NULL, '2024-08-10 23:38:00', '2024-08-10 23:38:00'),
('fb7fbb44-7294-4a03-a5e9-004435fa9b17', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 2, '{\"booking_id\":7}', NULL, '2024-07-09 15:46:32', '2024-07-09 15:46:32'),
('fc58491b-8e2a-4b1e-995b-7ba8349f593a', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":13}', NULL, '2024-07-23 14:26:44', '2024-07-23 14:26:44'),
('fc70f927-28af-46dd-a553-a5571cc93c68', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":34}', NULL, '2024-08-03 21:03:27', '2024-08-03 21:03:27'),
('fcbb1c66-5a69-4b76-a82c-36b88a044b59', 'App\\Notifications\\StatusChangedBooking', 'App\\Models\\User', 10, '{\"booking_id\":12}', NULL, '2024-07-22 19:34:44', '2024-07-22 19:34:44'),
('fdab164d-7a49-489c-8d66-74a9b9de4b06', 'App\\Notifications\\NewBooking', 'App\\Models\\User', 2, '{\"booking_id\":20}', NULL, '2024-07-31 13:33:23', '2024-07-31 13:33:23');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `e_service_id` int(10) UNSIGNED NOT NULL,
  `option_group_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `option_groups`
--

DROP TABLE IF EXISTS `option_groups`;
CREATE TABLE `option_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `allow_multiple` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('biolakila@yahoo.com', '$2y$10$6zTOvfKDH03Hy/KIJCDoZeaK/Vw4PBFvXvZZjrlt48iIR4.y5OPWe', '2024-08-06 15:10:28'),
('akinolamosun15@gmail.com', '$2y$10$oLmAz6d7BRbRLmg3ayZ6u.6xsywPWHCe6pNPZD5D6Q4ujHpl.HbrG', '2025-02-21 23:43:12'),
('webify247@gmail.com', '$2y$10$7eXz.pywfZ9s.j/NYLe19e.TOBlvsgJ.nl./QZ6.hMPk2bODabEU2', '2025-04-03 23:29:52'),
('Samuel@wytepage.com', '$2y$10$dPZnpYUkgWJs7NVJqiM0fucKNYnCg4D89RWP65cNpAqCqlJ5BYAu2', '2025-04-04 14:36:23'),
('perrilqt6@gmail.com', '$2y$10$o0m.dm3DZUcysxtb0CBjYuJe5mz5L6htkgUpdTSNzn.ZlmSB.AQMG', '2025-04-19 00:32:05'),
('goldesher@gmail.com', '$2y$10$bGmE33WyA4NTIQdTcr3yo.XUh3GtSNVFLWMYMLEkSTvU2kBJLDSgi', '2025-04-30 00:32:35'),
('ffloresvs1980@gmail.com', '$2y$10$7QbwUJ8Z0Xr080x7RBxcyeyq/6SgRhjh7bdchO9ROpNQruxfTKnf6', '2025-07-03 13:58:49'),
('davislindsay14579@yahoo.com', '$2y$10$13M8oY3ClhDBEayJm7U36ec4c1749l5wJvzTcCNrhM6ny4T4jz.lm', '2025-08-10 06:20:16'),
('amexaliquzix40@gmail.com', '$2y$10$4l4D1aOlCgggyq/PkR67PO/wV2upAyig6v9yfHX6sO2vbAXoMPNha', '2025-08-29 11:48:58');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NOT NULL,
  `payment_status_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `amount`, `description`, `user_id`, `payment_method_id`, `payment_status_id`, `created_at`, `updated_at`) VALUES
(1, 50.00, NULL, 9, 6, 2, '2024-07-09 05:05:18', '2024-07-09 05:05:42'),
(2, 44.43, NULL, 10, 6, 2, '2024-07-09 15:47:31', '2024-07-09 15:48:37'),
(3, 35.92, 'Done', 8, 7, 2, '2024-07-23 17:42:26', '2024-07-23 17:42:26'),
(4, 35.92, 'Transaction for Booking #16', 8, 6, 2, '2024-07-30 22:43:57', '2024-07-30 22:50:22'),
(5, 35.92, NULL, 8, 6, 2, '2024-07-30 22:54:35', '2024-07-30 23:12:15'),
(6, 35.92, 'Done', 8, 7, 2, '2024-07-31 20:44:23', '2024-07-31 20:44:23'),
(7, 35.92, 'Done', 8, 7, 2, '2024-07-31 20:50:48', '2024-07-31 20:50:48'),
(8, 35.92, 'Done', 8, 7, 2, '2024-07-31 20:57:54', '2024-07-31 20:57:54'),
(9, 24.52, 'Done', 9, 7, 2, '2024-07-31 23:31:52', '2024-07-31 23:31:52'),
(10, 35.92, 'Done', 8, 7, 2, '2024-08-01 07:16:12', '2024-08-01 07:16:12'),
(11, 35.92, 'Done', 8, 7, 2, '2024-08-01 19:11:30', '2024-08-01 19:11:30'),
(12, 35.92, 'Done', 8, 7, 2, '2024-08-01 19:44:30', '2024-08-01 19:44:30'),
(13, 35.92, 'Done', 8, 7, 2, '2024-08-01 19:56:15', '2024-08-01 19:56:15'),
(14, 35.92, 'Done', 8, 7, 2, '2024-08-01 19:57:58', '2024-08-01 19:57:58'),
(15, 35.92, 'Done', 8, 7, 2, '2024-08-01 20:02:57', '2024-08-01 20:02:57'),
(16, 24.52, 'Done', 15, 7, 2, '2024-08-03 05:13:40', '2024-08-03 05:13:40'),
(17, 35.92, 'Done', 8, 7, 2, '2024-08-03 07:09:17', '2024-08-03 07:09:17'),
(18, 35.92, 'Done', 8, 7, 2, '2024-08-03 07:12:16', '2024-08-03 07:12:16'),
(19, 35.92, 'Done', 8, 7, 2, '2024-08-03 07:17:38', '2024-08-03 07:17:38'),
(20, 35.92, 'Done', 8, 7, 2, '2024-08-03 07:21:49', '2024-08-03 07:21:49'),
(21, 35.92, 'Done', 8, 7, 2, '2024-08-03 07:22:53', '2024-08-03 07:22:53'),
(22, 35.92, 'Done', 8, 7, 2, '2024-08-03 07:24:32', '2024-08-03 07:24:32'),
(23, 2.00, 'Done', 13, 7, 2, '2024-08-03 21:03:27', '2024-08-03 21:03:27'),
(24, 2.00, 'Done', 10, 7, 2, '2024-08-06 18:07:04', '2024-08-06 18:07:04'),
(25, 24.52, 'Done', 10, 7, 2, '2024-08-06 21:48:38', '2024-08-06 21:48:38'),
(26, 35.92, 'Done', 8, 7, 2, '2024-08-10 23:35:06', '2024-08-10 23:35:06'),
(27, 35.92, 'Done', 8, 7, 2, '2024-08-10 23:35:32', '2024-08-10 23:35:32'),
(28, 35.92, 'Done', 8, 7, 2, '2024-08-10 23:39:11', '2024-08-10 23:39:11'),
(29, 35.92, 'Done', 8, 7, 2, '2024-08-11 08:39:28', '2024-08-11 08:39:28'),
(30, 35.92, 'Done', 8, 7, 2, '2024-08-12 02:08:40', '2024-08-12 02:08:40'),
(31, 35.92, NULL, 9, 6, 2, '2024-08-22 22:35:38', '2024-08-22 22:36:29'),
(32, 2.00, 'Done', 9, 7, 2, '2024-08-29 16:30:35', '2024-08-29 16:30:35'),
(33, 2.00, 'Done', 9, 7, 2, '2024-08-29 16:40:54', '2024-08-29 16:40:54'),
(34, 157.50, 'Transaction for Booking #53', 56, 6, 1, '2025-04-04 19:33:51', '2025-04-04 19:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `route` varchar(127) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`, `route`, `order`, `default`, `enabled`, `created_at`, `updated_at`) VALUES
(5, '{\"en\":\"PayPal\"}', '{\"en\":\"Click to pay with your PayPal account\"}', '/PayPal', 1, 0, 0, '2021-01-17 14:46:06', '2024-07-14 20:48:00'),
(6, '{\"en\":\"Cash\"}', '{\"en\":\"Click to pay cash when finish\"}', '/Cash', 3, 0, 1, '2021-02-17 21:38:42', '2024-08-29 16:23:34'),
(7, '{\"en\":\"Stripe\"}', '{\"en\":\"Click to pay with your Credit Card\"}', '/Stripe', 3, 1, 1, '2021-02-17 21:38:42', '2024-07-14 21:50:54'),
(8, '{\"en\":\"PayStack\"}', '{\"en\":\"Click to pay with PayStack gateway\"}', '/PayStack', 5, 0, 0, '2021-07-23 21:38:42', '2024-07-14 20:47:43'),
(9, '{\"en\":\"FlutterWave\"}', '{\"en\":\"Click to pay with FlutterWave gateway\"}', '/FlutterWave', 6, 0, 0, '2021-07-23 21:38:42', '2024-07-14 20:47:34'),
(11, '{\"en\":\"Wallet\"}', '{\"en\":\"Click to pay with Wallet\"}', '/Wallet', 8, 0, 0, '2021-08-08 21:38:42', '2024-08-10 20:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `payment_statuses`
--

DROP TABLE IF EXISTS `payment_statuses`;
CREATE TABLE `payment_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` longtext COLLATE utf8mb4_unicode_ci,
  `order` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_statuses`
--

INSERT INTO `payment_statuses` (`id`, `status`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Pending', 1, '2021-01-17 14:28:28', '2021-02-17 20:55:15'),
(2, 'Paid', 10, '2021-01-11 22:19:49', '2021-02-17 20:55:53'),
(3, 'Failed', 20, '2021-01-17 13:05:04', '2021-02-17 20:56:32'),
(4, 'Refunded', 40, '2021-02-17 20:58:14', '2021-02-17 20:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'dashboard', 'web', '2021-01-07 12:17:34', '2021-01-07 12:17:34'),
(2, 'medias.create', 'web', '2021-01-07 12:17:35', '2021-01-07 12:17:35'),
(3, 'users.profile', 'web', '2021-01-07 12:17:35', '2021-01-07 12:17:35'),
(4, 'users.index', 'web', '2021-01-07 12:17:35', '2021-01-07 12:17:35'),
(5, 'users.create', 'web', '2021-01-07 12:17:35', '2021-01-07 12:17:35'),
(6, 'users.store', 'web', '2021-01-07 12:17:35', '2021-01-07 12:17:35'),
(7, 'users.show', 'web', '2021-01-07 12:17:35', '2021-01-07 12:17:35'),
(8, 'users.edit', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(9, 'users.update', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(10, 'users.destroy', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(11, 'medias.delete', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(12, 'medias', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(13, 'permissions.index', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(14, 'permissions.create', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(15, 'permissions.store', 'web', '2021-01-07 12:17:36', '2021-01-07 12:17:36'),
(16, 'permissions.show', 'web', '2021-01-07 12:17:37', '2021-01-07 12:17:37'),
(17, 'permissions.edit', 'web', '2021-01-07 12:17:37', '2021-01-07 12:17:37'),
(18, 'permissions.update', 'web', '2021-01-07 12:17:37', '2021-01-07 12:17:37'),
(19, 'permissions.destroy', 'web', '2021-01-07 12:17:37', '2021-01-07 12:17:37'),
(20, 'roles.index', 'web', '2021-01-07 12:17:37', '2021-01-07 12:17:37'),
(21, 'roles.create', 'web', '2021-01-07 12:17:37', '2021-01-07 12:17:37'),
(22, 'roles.store', 'web', '2021-01-07 12:17:37', '2021-01-07 12:17:37'),
(23, 'roles.show', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(24, 'roles.edit', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(25, 'roles.update', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(26, 'roles.destroy', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(27, 'customFields.index', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(28, 'customFields.create', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(29, 'customFields.store', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(30, 'customFields.show', 'web', '2021-01-07 12:17:38', '2021-01-07 12:17:38'),
(31, 'customFields.edit', 'web', '2021-01-07 12:17:39', '2021-01-07 12:17:39'),
(32, 'customFields.update', 'web', '2021-01-07 12:17:39', '2021-01-07 12:17:39'),
(33, 'customFields.destroy', 'web', '2021-01-07 12:17:39', '2021-01-07 12:17:39'),
(34, 'currencies.index', 'web', '2021-01-07 12:17:39', '2021-01-07 12:17:39'),
(35, 'currencies.create', 'web', '2021-01-07 12:17:39', '2021-01-07 12:17:39'),
(36, 'currencies.store', 'web', '2021-01-07 12:17:39', '2021-01-07 12:17:39'),
(37, 'currencies.edit', 'web', '2021-01-07 12:17:39', '2021-01-07 12:17:39'),
(38, 'currencies.update', 'web', '2021-01-07 12:17:40', '2021-01-07 12:17:40'),
(39, 'currencies.destroy', 'web', '2021-01-07 12:17:40', '2021-01-07 12:17:40'),
(40, 'users.login-as-user', 'web', '2021-01-07 12:17:40', '2021-01-07 12:17:40'),
(41, 'app-settings', 'web', '2021-01-07 12:17:40', '2021-01-07 12:17:40'),
(42, 'faqCategories.index', 'web', '2021-01-07 12:17:40', '2021-01-07 12:17:40'),
(43, 'faqCategories.create', 'web', '2021-01-07 12:17:40', '2021-01-07 12:17:40'),
(44, 'faqCategories.store', 'web', '2021-01-07 12:17:40', '2021-01-07 12:17:40'),
(45, 'faqCategories.edit', 'web', '2021-01-07 12:17:41', '2021-01-07 12:17:41'),
(46, 'faqCategories.update', 'web', '2021-01-07 12:17:41', '2021-01-07 12:17:41'),
(47, 'faqCategories.destroy', 'web', '2021-01-07 12:17:41', '2021-01-07 12:17:41'),
(48, 'faqs.index', 'web', '2021-01-07 12:17:41', '2021-01-07 12:17:41'),
(49, 'faqs.create', 'web', '2021-01-07 12:17:41', '2021-01-07 12:17:41'),
(50, 'faqs.store', 'web', '2021-01-07 12:17:41', '2021-01-07 12:17:41'),
(51, 'faqs.edit', 'web', '2021-01-07 12:17:41', '2021-01-07 12:17:41'),
(52, 'faqs.update', 'web', '2021-01-07 12:17:42', '2021-01-07 12:17:42'),
(53, 'faqs.destroy', 'web', '2021-01-07 12:17:42', '2021-01-07 12:17:42'),
(54, 'payments.index', 'web', '2021-01-10 23:04:33', '2021-01-10 23:04:33'),
(55, 'payments.show', 'web', '2021-01-10 23:04:33', '2021-01-10 23:04:33'),
(56, 'payments.update', 'web', '2021-01-10 23:04:33', '2021-01-10 23:04:33'),
(57, 'paymentMethods.index', 'web', '2021-01-10 23:04:33', '2021-01-10 23:04:33'),
(58, 'paymentMethods.create', 'web', '2021-01-10 23:04:34', '2021-01-10 23:04:34'),
(59, 'paymentMethods.store', 'web', '2021-01-10 23:04:34', '2021-01-10 23:04:34'),
(60, 'paymentMethods.edit', 'web', '2021-01-10 23:04:34', '2021-01-10 23:04:34'),
(61, 'paymentMethods.update', 'web', '2021-01-10 23:04:34', '2021-01-10 23:04:34'),
(62, 'paymentMethods.destroy', 'web', '2021-01-10 23:04:34', '2021-01-10 23:04:34'),
(63, 'paymentStatuses.index', 'web', '2021-01-10 23:04:34', '2021-01-10 23:04:34'),
(64, 'paymentStatuses.create', 'web', '2021-01-10 23:04:34', '2021-01-10 23:04:34'),
(65, 'paymentStatuses.store', 'web', '2021-01-10 23:04:35', '2021-01-10 23:04:35'),
(66, 'paymentStatuses.edit', 'web', '2021-01-10 23:04:35', '2021-01-10 23:04:35'),
(67, 'paymentStatuses.update', 'web', '2021-01-10 23:04:35', '2021-01-10 23:04:35'),
(68, 'paymentStatuses.destroy', 'web', '2021-01-10 23:04:35', '2021-01-10 23:04:35'),
(69, 'verification.notice', 'web', '2021-01-12 09:19:50', '2021-01-12 09:19:50'),
(70, 'verification.verify', 'web', '2021-01-12 09:19:50', '2021-01-12 09:19:50'),
(71, 'verification.resend', 'web', '2021-01-12 09:19:51', '2021-01-12 09:19:51'),
(72, 'awards.index', 'web', '2021-01-12 09:19:51', '2021-01-12 09:19:51'),
(73, 'awards.create', 'web', '2021-01-12 09:19:52', '2021-01-12 09:19:52'),
(74, 'awards.store', 'web', '2021-01-12 09:19:52', '2021-01-12 09:19:52'),
(75, 'awards.show', 'web', '2021-01-12 09:19:52', '2021-01-12 09:19:52'),
(76, 'awards.edit', 'web', '2021-01-12 09:19:52', '2021-01-12 09:19:52'),
(77, 'awards.update', 'web', '2021-01-12 09:19:52', '2021-01-12 09:19:52'),
(78, 'awards.destroy', 'web', '2021-01-12 09:19:52', '2021-01-12 09:19:52'),
(79, 'experiences.index', 'web', '2021-01-12 10:20:29', '2021-01-12 10:20:29'),
(80, 'experiences.create', 'web', '2021-01-12 10:20:29', '2021-01-12 10:20:29'),
(81, 'experiences.store', 'web', '2021-01-12 10:20:30', '2021-01-12 10:20:30'),
(82, 'experiences.show', 'web', '2021-01-12 10:20:30', '2021-01-12 10:20:30'),
(83, 'experiences.edit', 'web', '2021-01-12 10:20:30', '2021-01-12 10:20:30'),
(84, 'experiences.update', 'web', '2021-01-12 10:20:30', '2021-01-12 10:20:30'),
(85, 'experiences.destroy', 'web', '2021-01-12 10:20:30', '2021-01-12 10:20:30'),
(92, 'eProviderTypes.index', 'web', '2021-01-13 10:31:08', '2021-01-13 10:31:08'),
(93, 'eProviderTypes.create', 'web', '2021-01-13 10:31:09', '2021-01-13 10:31:09'),
(94, 'eProviderTypes.store', 'web', '2021-01-13 10:31:09', '2021-01-13 10:31:09'),
(95, 'eProviderTypes.edit', 'web', '2021-01-13 10:31:09', '2021-01-13 10:31:09'),
(96, 'eProviderTypes.update', 'web', '2021-01-13 10:31:09', '2021-01-13 10:31:09'),
(97, 'eProviderTypes.destroy', 'web', '2021-01-13 10:31:09', '2021-01-13 10:31:09'),
(98, 'eProviders.index', 'web', '2021-01-13 10:48:55', '2021-01-13 10:48:55'),
(99, 'eProviders.create', 'web', '2021-01-13 10:48:56', '2021-01-13 10:48:56'),
(100, 'eProviders.store', 'web', '2021-01-13 10:48:56', '2021-01-13 10:48:56'),
(101, 'eProviders.edit', 'web', '2021-01-13 10:48:56', '2021-01-13 10:48:56'),
(102, 'eProviders.update', 'web', '2021-01-13 10:48:56', '2021-01-13 10:48:56'),
(103, 'eProviders.destroy', 'web', '2021-01-13 10:48:56', '2021-01-13 10:48:56'),
(104, 'addresses.index', 'web', '2021-01-13 10:48:56', '2021-01-13 10:48:56'),
(105, 'addresses.create', 'web', '2021-01-13 10:48:57', '2021-01-13 10:48:57'),
(106, 'addresses.store', 'web', '2021-01-13 10:48:57', '2021-01-13 10:48:57'),
(107, 'addresses.edit', 'web', '2021-01-13 10:48:57', '2021-01-13 10:48:57'),
(108, 'addresses.update', 'web', '2021-01-13 10:48:57', '2021-01-13 10:48:57'),
(109, 'addresses.destroy', 'web', '2021-01-13 10:48:57', '2021-01-13 10:48:57'),
(110, 'taxes.index', 'web', '2021-01-13 10:48:57', '2021-01-13 10:48:57'),
(111, 'taxes.create', 'web', '2021-01-13 10:48:57', '2021-01-13 10:48:57'),
(112, 'taxes.store', 'web', '2021-01-13 10:48:58', '2021-01-13 10:48:58'),
(113, 'taxes.edit', 'web', '2021-01-13 10:48:58', '2021-01-13 10:48:58'),
(114, 'taxes.update', 'web', '2021-01-13 10:48:58', '2021-01-13 10:48:58'),
(115, 'taxes.destroy', 'web', '2021-01-13 10:48:58', '2021-01-13 10:48:58'),
(116, 'availabilityHours.index', 'web', '2021-01-16 15:14:21', '2021-01-16 15:14:21'),
(117, 'availabilityHours.create', 'web', '2021-01-16 15:14:21', '2021-01-16 15:14:21'),
(118, 'availabilityHours.store', 'web', '2021-01-16 15:14:21', '2021-01-16 15:14:21'),
(119, 'availabilityHours.edit', 'web', '2021-01-16 15:14:21', '2021-01-16 15:14:21'),
(120, 'availabilityHours.update', 'web', '2021-01-16 15:14:22', '2021-01-16 15:14:22'),
(121, 'availabilityHours.destroy', 'web', '2021-01-16 15:14:22', '2021-01-16 15:14:22'),
(122, 'eServices.index', 'web', '2021-01-19 13:03:00', '2021-01-19 13:03:00'),
(123, 'eServices.create', 'web', '2021-01-19 13:03:00', '2021-01-19 13:03:00'),
(124, 'eServices.store', 'web', '2021-01-19 13:03:00', '2021-01-19 13:03:00'),
(126, 'eServices.edit', 'web', '2021-01-19 13:03:01', '2021-01-19 13:03:01'),
(127, 'eServices.update', 'web', '2021-01-19 13:03:01', '2021-01-19 13:03:01'),
(128, 'eServices.destroy', 'web', '2021-01-19 13:03:01', '2021-01-19 13:03:01'),
(129, 'categories.index', 'web', '2021-01-19 13:08:55', '2021-01-19 13:08:55'),
(130, 'categories.create', 'web', '2021-01-19 13:08:55', '2021-01-19 13:08:55'),
(131, 'categories.store', 'web', '2021-01-19 13:08:55', '2021-01-19 13:08:55'),
(132, 'categories.edit', 'web', '2021-01-19 13:08:55', '2021-01-19 13:08:55'),
(133, 'categories.update', 'web', '2021-01-19 13:08:56', '2021-01-19 13:08:56'),
(134, 'categories.destroy', 'web', '2021-01-19 13:08:56', '2021-01-19 13:08:56'),
(135, 'optionGroups.index', 'web', '2021-01-22 18:48:32', '2021-01-22 18:48:32'),
(136, 'optionGroups.create', 'web', '2021-01-22 18:48:32', '2021-01-22 18:48:32'),
(137, 'optionGroups.store', 'web', '2021-01-22 18:48:32', '2021-01-22 18:48:32'),
(138, 'optionGroups.edit', 'web', '2021-01-22 18:48:32', '2021-01-22 18:48:32'),
(139, 'optionGroups.update', 'web', '2021-01-22 18:48:32', '2021-01-22 18:48:32'),
(140, 'optionGroups.destroy', 'web', '2021-01-22 18:48:32', '2021-01-22 18:48:32'),
(141, 'options.index', 'web', '2021-01-22 19:10:51', '2021-01-22 19:10:51'),
(142, 'options.create', 'web', '2021-01-22 19:10:51', '2021-01-22 19:10:51'),
(143, 'options.store', 'web', '2021-01-22 19:10:52', '2021-01-22 19:10:52'),
(144, 'options.edit', 'web', '2021-01-22 19:10:52', '2021-01-22 19:10:52'),
(145, 'options.update', 'web', '2021-01-22 19:10:52', '2021-01-22 19:10:52'),
(146, 'options.destroy', 'web', '2021-01-22 19:10:52', '2021-01-22 19:10:52'),
(147, 'favorites.index', 'web', '2021-01-22 20:01:13', '2021-01-22 20:01:13'),
(148, 'favorites.create', 'web', '2021-01-22 20:01:13', '2021-01-22 20:01:13'),
(149, 'favorites.store', 'web', '2021-01-22 20:01:13', '2021-01-22 20:01:13'),
(150, 'favorites.edit', 'web', '2021-01-22 20:01:13', '2021-01-22 20:01:13'),
(151, 'favorites.update', 'web', '2021-01-22 20:01:13', '2021-01-22 20:01:13'),
(152, 'favorites.destroy', 'web', '2021-01-22 20:01:13', '2021-01-22 20:01:13'),
(153, 'eServiceReviews.index', 'web', '2021-01-23 18:42:57', '2021-01-23 18:42:57'),
(154, 'eServiceReviews.create', 'web', '2021-01-23 18:42:58', '2021-01-23 18:42:58'),
(155, 'eServiceReviews.store', 'web', '2021-01-23 18:42:58', '2021-01-23 18:42:58'),
(156, 'eServiceReviews.edit', 'web', '2021-01-23 18:42:58', '2021-01-23 18:42:58'),
(157, 'eServiceReviews.update', 'web', '2021-01-23 18:42:58', '2021-01-23 18:42:58'),
(158, 'eServiceReviews.destroy', 'web', '2021-01-23 18:42:58', '2021-01-23 18:42:58'),
(160, 'galleries.index', 'web', '2021-01-23 19:17:46', '2021-01-23 19:17:46'),
(161, 'galleries.create', 'web', '2021-01-23 19:17:47', '2021-01-23 19:17:47'),
(162, 'galleries.store', 'web', '2021-01-23 19:17:47', '2021-01-23 19:17:47'),
(163, 'galleries.edit', 'web', '2021-01-23 19:17:47', '2021-01-23 19:17:47'),
(164, 'galleries.update', 'web', '2021-01-23 19:17:47', '2021-01-23 19:17:47'),
(165, 'galleries.destroy', 'web', '2021-01-23 19:17:47', '2021-01-23 19:17:47'),
(166, 'requestedEProviders.index', 'web', '2021-01-25 08:53:17', '2021-01-25 08:53:17'),
(167, 'slides.index', 'web', '2021-01-25 10:01:20', '2021-01-25 10:01:20'),
(168, 'slides.create', 'web', '2021-01-25 10:01:20', '2021-01-25 10:01:20'),
(169, 'slides.store', 'web', '2021-01-25 10:01:20', '2021-01-25 10:01:20'),
(170, 'slides.edit', 'web', '2021-01-25 10:01:20', '2021-01-25 10:01:20'),
(171, 'slides.update', 'web', '2021-01-25 10:01:20', '2021-01-25 10:01:20'),
(172, 'slides.destroy', 'web', '2021-01-25 10:01:20', '2021-01-25 10:01:20'),
(173, 'notifications.index', 'web', '2021-01-25 14:42:33', '2021-01-25 14:42:33'),
(174, 'notifications.show', 'web', '2021-01-25 14:42:34', '2021-01-25 14:42:34'),
(175, 'notifications.destroy', 'web', '2021-01-25 14:42:34', '2021-01-25 14:42:34'),
(176, 'coupons.index', 'web', '2021-01-25 15:11:55', '2021-01-25 15:11:55'),
(177, 'coupons.create', 'web', '2021-01-25 15:11:55', '2021-01-25 15:11:55'),
(178, 'coupons.store', 'web', '2021-01-25 15:11:55', '2021-01-25 15:11:55'),
(179, 'coupons.edit', 'web', '2021-01-25 15:11:55', '2021-01-25 15:11:55'),
(180, 'coupons.update', 'web', '2021-01-25 15:11:55', '2021-01-25 15:11:55'),
(181, 'coupons.destroy', 'web', '2021-01-25 15:11:55', '2021-01-25 15:11:55'),
(182, 'bookingStatuses.index', 'web', '2021-01-25 18:21:01', '2021-01-25 18:21:01'),
(183, 'bookingStatuses.create', 'web', '2021-01-25 18:21:01', '2021-01-25 18:21:01'),
(184, 'bookingStatuses.store', 'web', '2021-01-25 18:21:01', '2021-01-25 18:21:01'),
(185, 'bookingStatuses.edit', 'web', '2021-01-25 18:21:01', '2021-01-25 18:21:01'),
(186, 'bookingStatuses.update', 'web', '2021-01-25 18:21:01', '2021-01-25 18:21:01'),
(187, 'bookingStatuses.destroy', 'web', '2021-01-25 18:21:01', '2021-01-25 18:21:01'),
(188, 'bookings.index', 'web', '2021-01-25 20:27:09', '2021-01-25 20:27:09'),
(189, 'bookings.create', 'web', '2021-01-25 20:27:09', '2021-01-25 20:27:09'),
(190, 'bookings.store', 'web', '2021-01-25 20:27:09', '2021-01-25 20:27:09'),
(191, 'bookings.show', 'web', '2021-01-25 20:27:09', '2021-01-25 20:27:09'),
(192, 'bookings.edit', 'web', '2021-01-25 20:27:09', '2021-01-25 20:27:09'),
(193, 'bookings.update', 'web', '2021-01-25 20:27:09', '2021-01-25 20:27:09'),
(194, 'bookings.destroy', 'web', '2021-01-25 20:27:09', '2021-01-25 20:27:09'),
(195, 'eProviderPayouts.index', 'web', '2021-01-30 10:23:08', '2021-01-30 10:23:08'),
(196, 'eProviderPayouts.create', 'web', '2021-01-30 10:23:08', '2021-01-30 10:23:08'),
(197, 'eProviderPayouts.store', 'web', '2021-01-30 10:23:08', '2021-01-30 10:23:08'),
(198, 'eProviderPayouts.destroy', 'web', '2021-01-30 10:23:09', '2021-01-30 10:23:09'),
(199, 'earnings.index', 'web', '2021-01-30 12:57:57', '2021-01-30 12:57:57'),
(200, 'earnings.create', 'web', '2021-01-30 12:57:57', '2021-01-30 12:57:57'),
(201, 'earnings.store', 'web', '2021-01-30 12:57:57', '2021-01-30 12:57:57'),
(202, 'earnings.destroy', 'web', '2021-01-30 12:57:57', '2021-01-30 12:57:57'),
(203, 'customPages.index', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(204, 'customPages.create', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(205, 'customPages.store', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(206, 'customPages.show', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(207, 'customPages.edit', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(208, 'customPages.update', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(209, 'customPages.destroy', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(210, 'wallets.index', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(211, 'wallets.create', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(212, 'wallets.store', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(213, 'wallets.update', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(214, 'wallets.edit', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(215, 'wallets.destroy', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(216, 'walletTransactions.index', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(217, 'walletTransactions.create', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(218, 'walletTransactions.store', 'web', '2021-02-24 10:37:44', '2021-02-24 10:37:44'),
(219, 'modules.update', 'web', '2024-07-01 16:05:34', '2024-07-01 16:05:34'),
(220, 'modules.install', 'web', '2024-07-01 16:05:34', '2024-07-01 16:05:34'),
(221, 'modules.index', 'web', '2024-07-01 16:05:34', '2024-07-01 16:05:34'),
(222, 'modules.enable', 'web', '2024-07-01 16:05:34', '2024-07-01 16:05:34'),
(223, 'payments.stripe.return', 'web', '2024-07-01 16:05:34', '2024-07-01 16:05:34'),
(224, 'eProviderPayouts.edit', 'web', '2021-01-30 18:23:08', '2021-01-30 18:23:08'),
(225, 'eProviderPayouts.update', 'web', '2021-01-30 18:23:08', '2021-01-30 18:23:08');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web',
  `default` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `default`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'web', 0, NULL, NULL),
(3, 'provider', 'web', 0, NULL, NULL),
(4, 'customer', 'web', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(16, 2),
(19, 2),
(20, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(66, 2),
(67, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(122, 2),
(123, 2),
(124, 2),
(126, 2),
(127, 2),
(128, 2),
(129, 2),
(130, 2),
(131, 2),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(139, 2),
(140, 2),
(141, 2),
(142, 2),
(143, 2),
(144, 2),
(145, 2),
(146, 2),
(147, 2),
(148, 2),
(149, 2),
(150, 2),
(151, 2),
(152, 2),
(153, 2),
(156, 2),
(157, 2),
(158, 2),
(160, 2),
(161, 2),
(162, 2),
(163, 2),
(164, 2),
(165, 2),
(166, 2),
(167, 2),
(168, 2),
(169, 2),
(170, 2),
(171, 2),
(172, 2),
(173, 2),
(174, 2),
(175, 2),
(176, 2),
(177, 2),
(178, 2),
(179, 2),
(180, 2),
(181, 2),
(182, 2),
(185, 2),
(186, 2),
(188, 2),
(191, 2),
(192, 2),
(193, 2),
(194, 2),
(195, 2),
(196, 2),
(197, 2),
(199, 2),
(200, 2),
(203, 2),
(204, 2),
(205, 2),
(206, 2),
(207, 2),
(208, 2),
(209, 2),
(210, 2),
(211, 2),
(212, 2),
(213, 2),
(214, 2),
(215, 2),
(216, 2),
(217, 2),
(218, 2),
(219, 2),
(220, 2),
(221, 2),
(222, 2),
(223, 2),
(224, 2),
(225, 2),
(2, 3),
(3, 3),
(9, 3),
(11, 3),
(12, 3),
(42, 3),
(48, 3),
(54, 3),
(57, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3),
(81, 3),
(82, 3),
(83, 3),
(84, 3),
(85, 3),
(92, 3),
(98, 3),
(99, 3),
(100, 3),
(101, 3),
(102, 3),
(104, 3),
(105, 3),
(106, 3),
(107, 3),
(108, 3),
(109, 3),
(116, 3),
(117, 3),
(118, 3),
(119, 3),
(120, 3),
(121, 3),
(122, 3),
(123, 3),
(124, 3),
(126, 3),
(127, 3),
(128, 3),
(129, 3),
(135, 3),
(136, 3),
(137, 3),
(141, 3),
(142, 3),
(143, 3),
(144, 3),
(145, 3),
(146, 3),
(147, 3),
(149, 3),
(151, 3),
(153, 3),
(156, 3),
(157, 3),
(160, 3),
(161, 3),
(162, 3),
(163, 3),
(164, 3),
(165, 3),
(166, 3),
(173, 3),
(175, 3),
(176, 3),
(179, 3),
(180, 3),
(182, 3),
(188, 3),
(191, 3),
(192, 3),
(193, 3),
(194, 3),
(195, 3),
(196, 3),
(197, 3),
(199, 3),
(200, 3),
(203, 3),
(210, 3),
(216, 3),
(224, 3),
(225, 3),
(2, 4),
(3, 4),
(9, 4),
(11, 4),
(42, 4),
(48, 4),
(54, 4),
(98, 4),
(99, 4),
(100, 4),
(104, 4),
(105, 4),
(106, 4),
(107, 4),
(108, 4),
(109, 4),
(122, 4),
(129, 4),
(147, 4),
(153, 4),
(156, 4),
(157, 4),
(166, 4),
(173, 4),
(175, 4),
(188, 4),
(191, 4),
(203, 4),
(210, 4),
(216, 4),
(223, 4);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

DROP TABLE IF EXISTS `slides`;
CREATE TABLE `slides` (
  `id` int(10) UNSIGNED NOT NULL,
  `order` int(10) UNSIGNED DEFAULT '0',
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `button` longtext COLLATE utf8mb4_unicode_ci,
  `text_position` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'start',
  `text_color` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_color` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indicator_color` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_fit` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'cover',
  `e_service_id` int(10) UNSIGNED DEFAULT NULL,
  `e_provider_id` int(10) UNSIGNED DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `order`, `text`, `button`, `text_position`, `text_color`, `button_color`, `background_color`, `indicator_color`, `image_fit`, `e_service_id`, `e_provider_id`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 1, '{\"en\":null}', '{\"en\":null}', 'bottom_start', '#333333', '#009E6A', '#FFFFFF', '#333333', 'cover', NULL, NULL, 1, '2021-01-25 10:51:45', '2024-07-03 21:13:04'),
(2, 2, '{\"en\":null}', '{\"en\":null}', 'bottom_start', '#333333', '#F4841F', '#FFFFFF', '#333333', 'cover', NULL, NULL, 1, '2021-01-25 13:23:49', '2024-07-03 21:13:35'),
(3, 3, '{\"en\":null}', '{\"en\":null}', 'bottom_start', '#333333', '#1FA3F4', '#FFFFFF', '#333333', 'cover', NULL, NULL, 1, '2021-01-31 10:04:36', '2024-07-03 22:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_packages`
--

DROP TABLE IF EXISTS `subscription_packages`;
CREATE TABLE `subscription_packages` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `discount_price` double(10,2) DEFAULT '0.00',
  `duration_in_days` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

DROP TABLE IF EXISTS `taxes`;
CREATE TABLE `taxes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` longtext COLLATE utf8mb4_unicode_ci,
  `value` double(10,2) NOT NULL DEFAULT '0.00',
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `value`, `type`, `created_at`, `updated_at`) VALUES
(4, '{\"en\":\"Service Tax\"}', 5.00, 'percent', '2021-02-01 20:24:12', '2024-07-15 00:06:14');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE `uploads` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `uuid`, `created_at`, `updated_at`) VALUES
(1, '8853bb7c-e1e7-4c90-aca9-92058f55dae3', '2024-07-01 23:07:24', '2024-07-01 23:07:24'),
(2, 'd86f7491-f15f-406a-bedb-e72c45102bf9', '2024-07-02 17:45:55', '2024-07-02 17:45:55'),
(3, '273553e7-8274-41dc-87f7-8fee20f23107', '2024-07-02 17:46:54', '2024-07-02 17:46:54'),
(4, '22118f18-e3ae-4740-81f4-b328f122ae81', '2024-07-02 17:49:00', '2024-07-02 17:49:00'),
(5, '8ab76634-450c-4ea3-addb-e016e98bc857', '2024-07-02 17:50:58', '2024-07-02 17:50:58'),
(6, 'af6e73dd-d3fd-424d-bcac-516ed5c0df42', '2024-07-02 17:53:04', '2024-07-02 17:53:04'),
(7, 'dc669e10-da9f-40e1-8ed7-599f94125d96', '2024-07-02 17:53:19', '2024-07-02 17:53:19'),
(8, 'ce88129d-1242-4ca0-89cb-640b767defef', '2024-07-03 08:16:22', '2024-07-03 08:16:22'),
(9, 'b61b740f-a51d-41cf-83cb-4f431e52067f', '2024-07-03 08:16:59', '2024-07-03 08:16:59'),
(10, 'b944fd12-ed53-4d75-9bcd-9224cafad54c', '2024-07-03 08:17:17', '2024-07-03 08:17:17'),
(11, 'a88e3c30-f519-40d1-8c75-eec78b46d40a', '2024-07-03 21:44:05', '2024-07-03 21:44:05'),
(12, 'f2ebb61a-c64d-4788-943a-f67ff13074fc', '2024-07-03 22:56:12', '2024-07-03 22:56:12'),
(13, 'af900489-b616-4cc2-931d-e7aec11c15a1', '2024-07-03 23:03:00', '2024-07-03 23:03:00'),
(14, '603b8c4f-b7a4-476a-be2c-a8dc9537ff20', '2024-07-04 11:01:37', '2024-07-04 11:01:37'),
(15, 'a81e3086-070b-4804-8eb0-18fe5783b2b1', '2024-07-09 04:25:51', '2024-07-09 04:25:51'),
(16, '6142bb46-e398-47ca-b9d1-18be305f409c', '2024-07-09 04:37:02', '2024-07-09 04:37:02'),
(17, 'c2b4218c-af3f-4177-b06d-a1701ae6ad74', '2024-08-03 08:47:20', '2024-08-03 08:47:20'),
(18, '7f30fcdc-326a-4104-ad71-fcf1807aff29', '2024-08-10 20:23:48', '2024-08-10 20:23:48'),
(19, '716db4f7-8e4d-4e39-8b94-ccbb2c171da5', '2024-08-10 20:23:59', '2024-08-10 20:23:59'),
(20, '7c2ce75a-78b4-410e-a50b-03d964167806', '2024-08-10 20:25:22', '2024-08-10 20:25:22'),
(21, '4b76e35d-d8c9-4d93-a593-d5c3b7bf01ce', '2024-08-10 20:37:58', '2024-08-10 20:37:58'),
(22, '9c91c7f8-8144-40ae-af8c-3b638b75df13', '2024-08-10 20:38:04', '2024-08-10 20:38:04'),
(23, '62ba0aac-a8c8-414a-a3da-b5c0e012e28b', '2024-08-10 20:38:35', '2024-08-10 20:38:35'),
(24, '8e5765e7-8d11-40a2-a684-79b9dd636d17', '2024-08-10 20:38:43', '2024-08-10 20:38:43'),
(25, 'f7e9405f-3d12-46ca-85bd-271a500f400a', '2024-08-22 23:14:45', '2024-08-22 23:14:45'),
(26, '32dc4e24-6117-49c1-9f4b-021122d9e08f', '2024-08-22 23:20:55', '2024-08-22 23:20:55'),
(27, '56573f59-1db9-4970-8026-53dddc093f76', '2024-08-29 16:45:07', '2024-08-29 16:45:07'),
(28, 'f4c1829c-3463-4061-9178-ae729fea7a35', '2024-08-29 16:46:28', '2024-08-29 16:46:28'),
(29, '1737f83b-48e8-4125-a2fe-ddabdd26f382', '2024-08-29 16:51:33', '2024-08-29 16:51:33'),
(30, 'd36eac3c-1b51-48ed-84c0-41a1fecff0a5', '2024-08-29 16:51:44', '2024-08-29 16:51:44'),
(31, '869e1870-f052-4b96-99bb-b16cd3ebea82', '2024-10-08 20:58:59', '2024-10-08 20:58:59'),
(32, 'fca18d8e-c864-42ef-b542-928f026ba6d8', '2024-10-08 21:22:02', '2024-10-08 21:22:02'),
(33, '7b4b4103-8da5-48f8-81f6-06741a96add0', '2024-10-08 21:24:36', '2024-10-08 21:24:36'),
(34, 'e3883b97-3668-4387-8c09-82e822bf7251', '2024-10-08 21:24:47', '2024-10-08 21:24:47'),
(35, '660c9df0-f8f0-401a-83ca-9a529e618103', '2024-10-08 21:26:32', '2024-10-08 21:26:32'),
(36, 'e01d8947-07ec-46a9-9c93-e17c43328f30', '2024-10-08 21:27:53', '2024-10-08 21:27:53'),
(37, '5639d889-0724-4f58-9081-b5c40493b2a3', '2024-10-08 21:28:48', '2024-10-08 21:28:48'),
(38, '02408e45-e1cd-40ab-a178-a45cc166dea1', '2024-10-08 21:29:46', '2024-10-08 21:29:46'),
(39, 'e59707f4-d0a0-4ff8-baef-bd28d222d862', '2024-10-08 21:33:04', '2024-10-08 21:33:04'),
(40, 'b94b6e80-212a-46bf-95d3-b4ab542cc549', '2024-10-24 19:40:48', '2024-10-24 19:40:48'),
(41, '57366277-173a-48ae-ab9b-6631b58743db', '2024-10-24 19:40:48', '2024-10-24 19:40:48'),
(42, 'e884919e-b021-42c0-8184-f38ce333b0b8', '2024-10-24 19:40:51', '2024-10-24 19:40:51'),
(43, '64f4f88c-d3d3-4bd5-8e21-6f803bc37833', '2024-10-24 19:40:58', '2024-10-24 19:40:58'),
(44, 'fc23fbbe-e25a-4f40-a9b8-60a2ac131f15', '2024-10-24 19:41:02', '2024-10-24 19:41:02'),
(45, '2e918423-211b-4430-8194-4c5397430497', '2024-10-24 19:41:05', '2024-10-24 19:41:05'),
(46, '7fcd04a2-d6be-47c1-8537-a4d3f56491ed', '2024-10-24 19:41:10', '2024-10-24 19:41:10'),
(47, '4601a807-64b7-40c0-ad29-e966c722abc5', '2024-10-24 19:41:14', '2024-10-24 19:41:14'),
(48, '51ebee87-c839-4627-b9d2-22363042c2c6', '2024-10-24 19:41:18', '2024-10-24 19:41:18'),
(49, 'd53f824e-0097-4b13-94ef-fa950d279d15', '2024-10-24 19:41:22', '2024-10-24 19:41:22'),
(50, 'ae0d34ea-428f-4655-b78d-278407775e54', '2024-10-24 19:41:29', '2024-10-24 19:41:29'),
(51, '0a349330-06cf-4345-a645-b3f1349fe387', '2024-10-24 19:41:39', '2024-10-24 19:41:39'),
(52, '2ae5fec2-fa29-4a87-a454-55dc973e2a49', '2024-10-24 19:41:46', '2024-10-24 19:41:46'),
(53, '9024bb6f-1be3-4533-9669-bbab457b5358', '2024-10-24 19:41:52', '2024-10-24 19:41:52'),
(54, '9888f190-1456-4cee-b203-59648782c5ac', '2024-10-24 19:42:43', '2024-10-24 19:42:43'),
(55, '06a78516-2745-439d-94cb-a6d5e3f981cf', '2024-10-24 19:44:52', '2024-10-24 19:44:52'),
(56, '9a8e1043-26bf-4be2-8794-944b267aa5a7', '2024-10-24 19:44:55', '2024-10-24 19:44:55'),
(57, '91d0ce35-9c59-40f2-ac13-c8305b6d6eb6', '2024-10-24 19:44:59', '2024-10-24 19:44:59'),
(58, '553b8573-bf7f-4ac5-9799-fc4e409ec4ff', '2024-10-24 19:45:03', '2024-10-24 19:45:03'),
(59, 'f1642a90-cf02-459d-a7c0-c1033283d6ee', '2024-10-24 19:45:08', '2024-10-24 19:45:08'),
(60, '16d833a0-98aa-4fcb-9cfd-8b3faa625205', '2024-11-27 22:00:27', '2024-11-27 22:00:27'),
(61, 'dab0f65b-bb76-44ad-b407-3b0ee731a411', '2024-11-27 22:04:29', '2024-11-27 22:04:29'),
(62, '8ce12e84-4906-48af-b393-10715dd95ead', '2024-11-27 22:05:58', '2024-11-27 22:05:58'),
(63, '885f931d-b18b-4d25-9604-4cf73f7355f8', '2024-11-27 22:07:54', '2024-11-27 22:07:54'),
(64, '8ca50580-002f-4c44-991b-a153c6661e84', '2024-11-27 22:09:57', '2024-11-27 22:09:57'),
(65, '04b433fc-cf80-4aa7-ba33-01a23cea87f7', '2024-11-27 22:15:33', '2024-11-27 22:15:33'),
(67, '21a38dce-3b06-45ed-b990-6ae2220496be', '2025-02-22 00:21:37', '2025-02-22 00:21:37'),
(68, '2049ae05-4db4-4827-80b9-caa3526e96c6', '2025-02-22 00:21:58', '2025-02-22 00:21:58'),
(71, '11dd7026-dfd4-447a-967c-cf527d212d7e', '2025-02-22 00:28:43', '2025-02-22 00:28:43'),
(73, '9a190e19-2f90-4345-a028-5c0af443df78', '2025-02-22 00:28:54', '2025-02-22 00:28:54'),
(76, 'a57dab22-6418-4f44-bac0-2d044c9ebe8b', '2025-02-22 00:29:31', '2025-02-22 00:29:31'),
(77, 'c5ae3619-71a2-4575-b498-94d417451e70', '2025-02-22 00:29:56', '2025-02-22 00:29:56'),
(78, '06016124-5e72-449d-bf6c-c08b1aa54710', '2025-02-22 00:33:24', '2025-02-22 00:33:24'),
(80, '89bd42ef-6452-47ed-aa86-4f7412f194c7', '2025-02-22 00:44:36', '2025-02-22 00:44:36'),
(81, '423068d7-fe24-47f8-945a-d7ba64a2d291', '2025-02-22 00:45:31', '2025-02-22 00:45:31'),
(82, '2b48cdcf-621f-4641-aea3-73c57eee960d', '2025-03-24 13:43:04', '2025-03-24 13:43:04'),
(83, '7aae7a61-5ae9-45fd-90d5-59c6ec0e99b6', '2025-03-26 14:18:16', '2025-03-26 14:18:16'),
(84, '638c6d97-74f0-4c72-a274-af1efb21e73e', '2025-03-26 14:18:36', '2025-03-26 14:18:36'),
(85, '0b053878-7e05-4c89-b329-eac733de8dd6', '2025-03-26 14:18:51', '2025-03-26 14:18:51'),
(86, '8db19078-8e17-4b2c-b2f1-9b1a9f16f875', '2025-03-28 17:13:46', '2025-03-28 17:13:46'),
(87, 'fda21a15-2c6f-49ce-b737-1b710702b930', '2025-03-28 17:15:46', '2025-03-28 17:15:46'),
(88, '70948c70-fa27-44ff-b44e-c96d7216b845', '2025-03-28 17:18:43', '2025-03-28 17:18:43'),
(89, '8ac0a2c9-4ab1-444e-bf9e-a525b0429fac', '2025-03-28 17:18:46', '2025-03-28 17:18:46'),
(90, '17392214-eda8-4ae2-8484-e82352dba756', '2025-03-28 17:20:27', '2025-03-28 17:20:27'),
(91, '871c80f2-5a74-4a4f-9708-dfb9263c6e78', '2025-03-28 17:20:52', '2025-03-28 17:20:52'),
(92, '4f3a838a-89c8-4d87-9569-a7b4200eae97', '2025-03-28 17:20:54', '2025-03-28 17:20:54'),
(93, 'd61c7f52-c7b8-4e94-883c-d0fa0109ccfc', '2025-03-28 17:23:23', '2025-03-28 17:23:23'),
(94, '2eb2ea9c-e40f-4731-b9b5-1cbeefe6d696', '2025-03-28 17:23:25', '2025-03-28 17:23:25'),
(95, 'd16a2eb4-ab9b-4da8-b2b5-f492a47bf343', '2025-03-28 17:28:14', '2025-03-28 17:28:14'),
(96, '7d994ce9-f824-43ee-89d5-d07abef14dbe', '2025-04-03 23:33:08', '2025-04-03 23:33:08'),
(97, '62b517e7-0f7e-4e61-8b5b-09314edfc983', '2025-04-03 23:42:24', '2025-04-03 23:42:24'),
(98, 'e7f3ded0-5f59-4839-a401-720e990679c0', '2025-04-04 19:16:14', '2025-04-04 19:16:14'),
(99, '3bc391cf-a186-46e4-b1dc-db01e4277801', '2025-04-04 20:45:17', '2025-04-04 20:45:17'),
(100, 'cadc36b3-ce25-4b0f-8150-a9c9c33761f7', '2025-05-28 03:47:21', '2025-05-28 03:47:21'),
(101, '73a1ca76-9ff4-48c9-b8fd-16ab4846075d', '2025-05-30 11:42:49', '2025-05-30 11:42:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` char(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `paypal_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `phone_verified_at`, `email_verified_at`, `password`, `api_token`, `device_token`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`, `paypal_email`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'EWA', 'admin@ewaofficialapp.com', '+1 234 8996 321', '2021-01-10 16:22:10', '2021-01-10 16:22:10', '$2y$10$ZamMyY63uniZr91mGgGaxeoXghOeoJW.MOnqzVoBNsGn/coaMe0Wa', 'PivvPlsQWxPl1bB5KrbKNBuraJit0PrUZekQUgtLyTRuyBq921atFtoR1HuA', 'cr_cQC4JnxHgDLKaNRi3VA:APA91bHMkXIhn4K9amIDiMMqpsGkD5jWnfscl2rVPju2bWhEmsjplgiEuSkegyQV40glE7e5yQGFeIUwePbvCCG9fAapRaram8gqJX_OFY8TNw8XcZLkQ04', NULL, NULL, NULL, NULL, NULL, 'IojJRHoPMtgRiLvyw7dE2YCZMRjKaiYnzlZZP8Y5mopu3xRU1fD9SRGOtaAs', NULL, '2025-03-24 13:50:27'),
(2, 'Jennifer Paul', 'provider@demo.com', '+1 234 8996 322', '2021-01-10 16:22:10', '2021-01-10 16:22:10', '$2y$10$iTZ2foLVyiTY4t1ooaevtuS7I8OcWkK3y72SegUjfI8pBP7vYaWvW', 'tVSfIKRSX2Yn8iAMoUS3HPls84ycS8NAxO2dj2HvePbbr4WHorp4gIFRmFwB', 'eGWPPjvQTs-S65y7_hoZPX:APA91bEHdHcD65Om17uq6V076MUDkVk10N6eBQJNojjfcPnXuwtQeX7pjBDta2ki-pz5LSajvPbTnM0XS6_FSoojN0wJmgd-WDTIjTlWoycUWgsAWMUgWfW4LJvMJwmsPZC6AGcB4gG2', NULL, NULL, NULL, NULL, NULL, 'TeYvJLanMrqqOcqStPpERmNKWQgD9zDBQKuFEAcYFJT3SY12oASszW8SzorR', NULL, '2025-03-26 14:12:11'),
(3, 'Germaine Guzman', 'customer@demo.com', '+1 234 8996 323', '2021-01-10 16:22:10', '2021-01-10 16:22:10', '$2y$10$EBubVy3wDbqNbHvMQwkj3OTYVitL8QnHvh/zV0ICVOaSbALy5dD0K', 'fXLu7VeYgXDu82SkMxlLPG1mCAXc4EBIx6O5isgYVIKFQiHah0xiOHmzNsBv', 'f2lmUMV350VloPHFh8qTOU:APA91bGkmE-3V2JE0P-VtGiCav_36AA5SEl8O_CtTDSvJxbmny14uGd2j2ueiatFuO0jK00lVH49Y1B8foB268r9hoNEuRekEdsilVJ0nZvUQoCeWAEs-Zo', NULL, NULL, NULL, NULL, NULL, 'SPz6luq3aoxCbgIS1gqmFDgM1qzGlIDtF0HgmDbtWcx2reaeFcogcFQzdP2F', NULL, '2024-12-14 19:04:11'),
(4, 'Aimee Mcgee', 'provider1@demo.com', '+1 234 8996 324', '2021-01-10 16:22:10', '2021-01-10 16:22:10', '$2y$10$pmdnepS1FhZUMqOaFIFnNO0spltJpziz3j13UqyEwShmLhokmuoei', 'Czrsk9rwD0c75NUPkzNXM2WvbxYHKj8p0nG29pjKT0PZaTgMVzuVyv4hOlte', '', NULL, NULL, NULL, NULL, NULL, 'yCzPqDP1oczySU57q6G71SxTIJSiZUBE4vYdXbXCqzpzC2iN09igcs3jzSQK', NULL, '2021-02-21 13:50:29'),
(5, 'Josephine Harding', 'customer3@demo.com', '+69933215478', NULL, NULL, '$2y$10$n/06hZG121ZGp3tSwDQS3uhsQKxEYspjKrn7kGlLxRinUZKiulrEm', 'gkEWScQHIol9EIRhP3m5m7JqnK5UvcGdEsKQJo7YeBcQawYFq3JAJ6SX9UKy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-11 09:55:52', '2024-10-24 19:43:02'),
(6, 'Nicolette Christiansen', 'provider2@demo.com', '+12556698474', NULL, '2021-01-10 23:00:00', '$2y$04$WRpHC9iMxZ3f.gctQ4igsuZjsYfGjX7igVM8GsC2AMME3.4au3dYu', 'TKArYDDFHNiEI33sfExaBEhxHCs5kFaWP7EO6aNlUZfnqHrvsMCwsYeAk9s2', NULL, NULL, NULL, NULL, NULL, NULL, 'JbiYaHlRWGKkfITxH9qI87GzTMPf0zJ2Iw6NIdlS5dDvWuT5PC2sP5ELGwKx', '2021-01-11 10:33:59', '2024-10-24 19:42:49'),
(7, 'Rose Bauer', 'raoufsmari@yahoo.com', '+213562207593', NULL, NULL, '$2y$10$FMcR98lHjX7LKxRIXfGIB.WN4ssNeLGGPPJ0oQPESYvTJXG48hnyi', 'w6QJYqZyllY24AIR3nSsKqgj5eMSZevmgpSywwxJxUS9nwULcuriRLBxEXZC', 'e6JtZXeURkylbToqwFvrzx:APA91bH7uWmAQ5qAxDIBcxn7-ed18bqrKd6h3h2NUzNojTWUgw0C37CiOnkWaQsGX5An2yA_qpbXKUxQgM1_kF0KCHm_YQjMN3ki5RlkMk7qGdjDcVce5amdUlNaz9RpaxQ4_XMLRjQn', NULL, NULL, NULL, NULL, NULL, 'WxYP9zjTBy9SYF5OWjcFbMt2Ob9r0bahBKzPDOtw9OrAJ89JqaMxkN5aqu8J', '2021-01-17 15:13:24', '2024-08-01 07:10:07'),
(8, 'smarter8', 'raoufsmari30@gmail.com', '+12645595482', NULL, NULL, '$2y$10$b8RbCRgSU.a/o1CKct9J3OF3fbYDQa502ZmLH3RyykgE5JvbJmys6', 'WivbG2oAEbEGl51EBeBuHaZeCqyfBnCVGo18nSaj2FwwiDjux2ZOAZWUoddK', 'c6_fHyc8RXmJrbMGQMAatK:APA91bHcFT2nPRIDzaP9ilJ3L0jxmykraSrpaL7MPteeVeGPmyaTWS1OZB5I35WvRmcd3158M2iOqnIXbvHLOsHHzFKSx-AVTrC012wtcmN75S3CIM2dXm3Q_uHxC4MkoL_RGOcuab5v', NULL, NULL, NULL, NULL, NULL, 'SdstZCaeYW0pjqZn832HMzBD7WPGJ5m9hwWG28nhbIrzSS0etj33rbTRJ6kD', '2021-02-10 10:31:12', '2024-10-08 21:30:29'),
(9, 'oluwaseun pepper', 'pepworkfromhome@gmail.com', '+2347060830970', '2024-07-04 11:03:02', NULL, '$2y$10$E35SkrIPiTJEQucbORNVpeKB5lA2tUwRy2RQ.TmXsqWb.r.oDjwui', 'MDLT3OXzDU5ZPSu9nAYf8UdhUYpvIla0t23mGkGpBKlEt4K9fC8nA4X8cumO', 'entm25Hb56QHNqWFjr_1-p:APA91bE8G2V2uI5R-KevBNWCuhLH1J08GxePecveYk9MnKxte05H4aR3BsSzWM2bF-awkdlMYcQhT1tKVsC6mSNMrtfRrh4aipFCtroBLubgJKOVOMaxzpw896TVneEmOLu4GB8H_CW2', NULL, NULL, NULL, NULL, NULL, 'kg0KfAmMZWgOzDppMX5cEMIzxUzyL9nbxIjoGC8VB7F7vdSOgsUDulJWJt6O', '2024-07-04 11:00:31', '2025-03-26 13:42:59'),
(10, 'abiola Onalaja', 'biolakila@yahoo.com', '+4407856293361', '2024-07-06 15:01:15', NULL, '$2y$10$ZpSBcL1ITKqtqVg0O0xzEuVR7hXJh1hMALXKBR2oTQ8zlzy7gdp0C', 'EzPB4nG8jLZJ2Z48oQymXpNALAhtUXAWQZbtJ5uPf3oRcK5vMORqSeG80dNQ', 'e0I1VzJUQBS5rpSGaZ6_qw:APA91bEe01d7o0VntGexTDSuRaQ3EvvcLfgMTnmeddW9LgWXJjTsGDl9slnrIt84xKy_4PHnHkqZCYkcQShnmuTuWKO6OhO2tKdX56yNHD7hHTvlbQgdN10TJN589c__IljMI6QCJ8ir', NULL, NULL, NULL, NULL, NULL, 'mHl5alG3dbBGZPsMvfQg6Ygwk2R4TIE6DuZpBgUb3ScTZ5d9lLfyYKyPEZzv', '2024-07-06 15:01:17', '2024-08-06 17:31:49'),
(11, 'Toyin Lawal', 'seanmlthap@gmail.com', '+19172849645', '2024-07-09 04:22:21', NULL, '$2y$10$uV1v4CHQtdxOunyHoqhDCO9eamDyLTLxn1JXMlOcR8XNTdHoc/wly', 'n5aUXJSuwIqYetTMesZ8Dm89ANCzoW25YJI6RtM2wwnb8hqq4f6NcRxG3uCb', 'eGWPPjvQTs-S65y7_hoZPX:APA91bEHdHcD65Om17uq6V076MUDkVk10N6eBQJNojjfcPnXuwtQeX7pjBDta2ki-pz5LSajvPbTnM0XS6_FSoojN0wJmgd-WDTIjTlWoycUWgsAWMUgWfW4LJvMJwmsPZC6AGcB4gG2', NULL, NULL, NULL, NULL, NULL, '9WyJ3XNttAxqCP3DVAC759S6FwDsmigpumIoleHhbuJT7TtylYuKeX7bpGMZ', '2024-07-09 04:22:24', '2024-11-27 21:31:50'),
(13, 'Deji Faniyan', 'dejiajila@gmail.com', '+14374416671', '2024-07-31 20:40:38', NULL, '$2y$10$2NLwaN1xXTlsfPByntehz.kgL/dG8KT4Y/N201yEFP22QbrjTwhM6', 'M9KJmjE25UhL3nt3Pq9W9GdvatjmhXTlIIciQcTghVT9rLCJ4XGIZTOTiwGT', 'daE5KcWdTUSmQs4fEEO3-9:APA91bEaR2EMAKG39qD2gk938tUfS6G_MZ4LPtjGSOLvwp9ctrJymtmiEBcDBWvBVH3qxXuoyp7ZlRKzxq3848aUetw0WrcAnQCqIGC7XRTg12YoTEyBzeIRGLnQgYBbctp2gYVzfsyQ', NULL, NULL, NULL, NULL, NULL, 'DQlOENLYAZUwMWnx2ExwfiDHzlHG5FnOVtEmG9cY7OxvXz5JC7GEcgoZJMTe', '2024-08-01 01:40:38', '2024-08-03 10:15:04'),
(14, 'smarters vision', 'smarters@gmail.com', '+123456789', NULL, NULL, '$2y$10$.ys0Fb2eTEZ3igffvwP0s.5hoXUuzInt/RodhAAcgniqDgohriw16', 'pGdxQWFAhtpad8q0QQlQbXjiQ9Y2mjSRBktMSL9hOKNm5Ac8WA6PQN8Nh5mr', 'e6JtZXeURkylbToqwFvrzx:APA91bH7uWmAQ5qAxDIBcxn7-ed18bqrKd6h3h2NUzNojTWUgw0C37CiOnkWaQsGX5An2yA_qpbXKUxQgM1_kF0KCHm_YQjMN3ki5RlkMk7qGdjDcVce5amdUlNaz9RpaxQ4_XMLRjQn', NULL, NULL, NULL, NULL, NULL, NULL, '2024-08-01 07:38:58', '2024-10-24 19:45:18'),
(15, 'joseph shotunde', 'josephshotunde@yahoo.com', '+447411448252', NULL, NULL, '$2y$10$/zIHTkUq2jXR/pHSBrXla.ONvZrhfJI6ZcQJVHIJsdrexHqI2LVwe', 'WKODOimX4ivzaoTAWF1jOlRb8m9hHHDBBLGoNVzMSUQqTU5U0e4Lmli0kFNM', 'dQOLclW2Tmq_4ekBbTOHiZ:APA91bGVnOmeN1Kb44Lt89TrO5V0Z7qzKbbGRPZfCpVfjoWz-e_aJ49oJpVsU-r30EvB1cGnbxz2W-3uHAh_bcl5M7-jvS26OW4678QAK3nG7GvjG6AYK5LdgH8mFVgceu2_rJYkfSjQ', NULL, NULL, NULL, NULL, NULL, 'm4iwtvMyWPKp3N7xfNAdcT6cWHmwY3IRux7lRv2boLh8KwuUuux08s7wYDGC', '2024-08-03 04:39:05', '2024-08-03 04:42:55'),
(16, 'Taiwo Onalaja', 'Taiwoonalaja@gmail.com', '+4407849889719', '2024-08-06 15:15:23', NULL, '$2y$10$ASGpdQpC85gpT/gSaRfkPedfoizUYmFLQ2.K8qdRej12evcRfvIBG', 'LP0k20icNFhB9vmxqoMdkXryYGZO7dwyYLKifnEUvDQ0DWxnPzbNi3ZdfXtc', 'dbJCByEIQeeMg_HIrmDJS2:APA91bFZukfV4dOyxpkSfpX8RP36dqGBPkFOCh6CkdoPhdKcy6mS_d6ZW6MpDgtaVvJee-bdl3wSBmFtWSafjjWjj21Z7ZipIcEGhzuVHA88g8rqaLvX2EI--xyWiVS2r46IwYxmd9aT', NULL, NULL, NULL, NULL, NULL, 'Ribdd2pteJfkN39FFzXs1tVpGBiGybKT6vvSB8oqFOCkgz4UapKXvMy3djgx', '2024-08-06 15:15:24', '2024-08-06 15:15:24'),
(17, 'zTIdgwJnFB', 'otisbyq1998@gmail.com', NULL, NULL, NULL, '$2y$10$3ZvZK.N5de2XuFaCeh68rOmWb.cnWXDtIWHdtN/SFQP7f93w34Yke', 'zLqfjE9eLMp3IhKorR1acSfrAaqjbjUsiqPD59FbcDTxpp5p129iV5Dm82Mg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-19 20:54:34', '2024-11-19 20:54:34'),
(18, 'Nfejdekofhofjwdoe jirekdwjfreohogjkerwkrj rekwlrkfekjgoperrkfoek ojeopkfwkferjgiejfwk okfepjfgrihgoiejfklegjroi jeiokferfekfrjgiorjofeko jeoighirhgioejfoekforjgijriogjeo foefojeigjrigklej jkr', 'yasen.krasen.13+78387@mail.ru', NULL, NULL, NULL, '$2y$10$TE2XLNC28iqGsCGBxNzZ2ugSjUs/IgMaG77jNr5FF17/LN1SdfmEG', 'Ost0wJIEQ9K2JsJrmPf0paXexkEsf2vddri2SBeFNcBpOrlSoLk0BA1ohN54', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-27 08:20:17', '2024-11-27 08:20:17'),
(19, 'sNBHwXQh', 'gywot9xjayr7nj@yahoo.com', NULL, NULL, NULL, '$2y$10$4mtfx0JmJFotj41d40x/jO./wQBHVpx0uanmZTQJMV2ZO8RnFYjiO', 'U5XoCGm3p7MMYFiCtnLz1PpYgAimznEqOSATAbuWHfiMLQgQMwN9gl0tNb5V', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-29 01:30:59', '2024-11-29 01:30:59'),
(20, 'unique Moseley', 'aintthatunique1@gmail.com', '+442288705552', NULL, NULL, '$2y$10$DFSxhA0.HVgHCwt0.aVGhu0FzZwRoluIPk7/k5b41UPisGz65Ff5C', 'DMSY3QRxN3g397Ufrm5Ek7eHBLmAY98kJ8eOWdbCm8HwrRrL1xzGTbrUQgmx', 'fRTswYd8xk6XmgpHEvlUGL:APA91bEYo1X-d-R_0SCTiVj2lZn6fDB7_yz1stS6nkXeAlpm0PQ02ua92JlgLJ5cpaAZarI8mvRhXRRu3fmsv9RdGgw6UDqGsCSDBBvIXzGzRI2_MJ62fvk', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-16 01:41:14', '2024-12-16 01:41:14'),
(21, 'Jakiera Hobbs', 'jakierahobbs16@gmail.com', '+446018080668', NULL, NULL, '$2y$10$9DgPtfD6ObkTFZxQBDZVpOnnyT0mq4Mhb9avwT1.vxbbLGUJ6YRre', '5xupDOet99OdcZhPFTnFPKUx0t0yb6BirXvNFNURNNjY9n3n3ifl25N2ap58', 'dcWe_ptIek-yqauJ3Kg5T-:APA91bH6rvPsDAirtN50dtExVrYKjab2f3SsHi8evDIcD_0LcP8qAG2armGOdB0OB4A2uNA5eAYyhAx94CNV1cHS3EIRCywlRZnPUMtWJy4iIQNawVqKTvU', NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-16 22:02:19', '2024-12-16 22:02:19'),
(22, 'buPMQiexqp', 'guvalabweman@yahoo.com', NULL, NULL, NULL, '$2y$10$Bicc5jUG5T7IJNbWSjjenOImnk23NGjWt/gkrvOVsOZEstYTOWR5m', 'YbCs4LA6lleDJFdEiYeRFiL3rMzAMUu10th4RPOkYQh89OJmlxaItW6kgP6a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-02 05:06:45', '2025-01-02 05:06:45'),
(23, 'Junior KABORE', 'junior.kabore@gmail.com', '+447458114647', NULL, NULL, '$2y$10$gEG1bwgWqHKtftsGiTH06OcHXekWOlKxQnConWdBHGkO5XiwAPT7C', 'Cwr3iSlFbRZU4f6I36VosKC42FnrQWzvypOpUDsXu5m0BUjeq32BBnGPRyOd', 'eTQGMqzxPUH4u65MRmHlH2:APA91bEVTui4YjkcEdf-GQdEVPy01pEVF9JAFyBgX2qzXcZiGU6u5-R73K76Rh2wMW-01IMHWI1fs7MVy4_En12wZJjl73fLkKMyzNAXMaRMXLFpC1v3o18', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-02 22:11:15', '2025-01-02 22:11:15'),
(24, 'cherish Gerald', 'cherish.gerald03@gmail.com', '+19177084459', NULL, NULL, '$2y$10$Se6H4ogWe6ZtlXgU1dNifuW9u/VcX0mZM1KwG5Oe9jvWRye9ipEue', 'MzOEipN5qlBhxznIU6AEjRbOuKaDh3ADmPpSqlskY4TPJKb0gTuHVsOcDthE', 'drnc2uEm9EcAj8IblnbGBv:APA91bFr9Sli6ZBPWDjEJR24sJxUJjGJjPQu2GZY-l0gea8DU2K9yTfzC8zomL5SVJGjSw2NyyjPQewZt1-7XltM4I6CxrRpe3erjqfEGNIACknfQ1hvOnc', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-14 22:44:41', '2025-01-14 22:44:41'),
(25, 'Cordelia Smith-Okoduwa', 'cordeliasmithuk@yahoo.co.uk', '+447950705275', NULL, NULL, '$2y$10$JCDG8FqpkbrIic.Mb35ewuW5WZhWvFN4beyTjAodDq9Gof7o5F4OK', 'C3mzbdKQmmJNiBK0YVLCXZPQE1fMWEuqg19TCbv4ifs7m00tXdcxYEkdhRxg', 'eZO8LUfkRVudcCHzIDblzU:APA91bFCHO6WaWFxfU4bX0G9rrlF9MZ9XLx9NH0T6b5dCmdRwTGKjlbN4CqgHwPEWb9xVwo7PqeceoZntZybuP2u3wIPuuscLqayCOIl2Isg00gQCJAMbUU', NULL, NULL, NULL, NULL, NULL, 'qIbeYOUKcxFqR6fl1DY58oObB082bTSTAQsypCeHrRKLNHpaTE9EpDZqXf2d', '2025-01-17 18:07:28', '2025-01-17 18:07:28'),
(26, 'Dana Semi', 'bilandaseme02r@gmail.com', '+1(912) 789-6174', NULL, NULL, '$2y$10$EAPgGwq1C033iRhMugqebO8VGVyX/.ZdAJUy/cInVj5DBD4vIISUi', 'PBjNcuTXNPuq0ELLn02swub6dKGqK1no5nLgYXt41MiozcGfWWVzRpZ7cPhL', 'f3Cge_EAI04sv9pXXjK9w3:APA91bFt2mptthrYbfI1jAS8cOba259nKgtWV1NFH-jI5L3lT3YwrSEl7wUKBj3SOX7EgZJuBCTyJXLCYQIWJun3gcbxNf1C4sjZiiDhVvYH3c4vW2QGbQY', NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-26 09:45:02', '2025-01-26 09:45:02'),
(27, 'aUkzzPbxp', 'avamejusupa25@gmail.com', NULL, NULL, NULL, '$2y$10$5YIqz1hmci9UkSOcsSY9pOE5UkpLysJLm23hlt/H.raWg1OpQ8zdm', 'ngrRGJqXWloOsyGJlQ7kEgoBCOfom6HMTGC9ZZIWzl0X3zdVZ3DBp55aqMTV', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-02 04:47:27', '2025-02-02 04:47:27'),
(28, 'Ruby Mbama', 'rubymbama@gmail.com', '+12043991844', NULL, NULL, '$2y$10$rXzn4hpwBzQQ5bEa/Z/Hmukgjfq0E4MKw60Qqj9xttYLP2cU2kYji', 'a6PsDGxaIk2LL18BtgXNleGf01iIxem6CqmXV9j6jsJDN4Kd2jfRd6bCX3EM', 'due1ntJlxEtzrT7CjutC4x:APA91bGs9B7h3Iorwd68VqgsMBJLqNCVFVMCHyVBMg2BspJnPrZ03HwebfytMuJgaMnGicIU-Gwk-YsG-KwYgUixKeW7lv81nKgbnzS1xk3SVibKbOmlqWE', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-03 04:01:14', '2025-02-03 04:01:14'),
(29, 'AEQrOAEIYpDzAlQ', 'yapulzs7qsu8ufe5m@yahoo.com', NULL, NULL, NULL, '$2y$10$7uEZIYsV7ReoEHrxKo7cZujQG3dX/ao4I9r/gS83ca3PW9r6th1ba', 'L9RVon2ESnCZyGx7egPRSSEgaiKEMMol82hD1W3fFsJVAfLGTalOxMDwCbr1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-18 00:47:10', '2025-02-18 00:47:10'),
(30, 'Isaac Akerele', 'officialakisaac2018@gmail.com', '+23409064525786', NULL, NULL, '$2y$10$02E3iUMt909Oj.YTyEVPbuaKcgyE8EzTJUG90HznJJCLO2l2m8M16', 'MW9Q7eKhmtcVtXotpvfhuhMIR4ZhPjRCEQzmfUYuwpKwjUuYHfz301JLYRUX', 'ctpxOklBZ0F8sbbgxtLMiq:APA91bEdAaYzXh--qQyLVfwzEl8jXC-NiiVAY-afUTrW053BrxBt227he49FXluLEawVdEJyxh_k7P2_Bg1IZo6DedrGY973dN2XUIcryiOer3-EHYN8Qnw', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-20 16:53:27', '2025-07-21 15:49:31'),
(31, 'mosunmola', 'akinolamosun15@gmail.com', '+2349030188157', NULL, NULL, '$2y$10$tKuPgjGtJ0tpH1Yo4a9FZu4wbKLpBWKYG5bpG2gTry/dPq6mCCohK', 'TNvHU8fQfwAjHgms8p37K3YnjqFiv50IoCmgNCIkAxOKT2GabZKyez1bgF0s', 'dDKeQ4NmxUakjpmvhFjsNr:APA91bFt9R71LrTuCWwtlpsXi-vzpwaZ9CdA771GA9EPHP2j-fGCGdCAykEQynkrbJMn1mUBvJI1D42W7m7v6jUBAcFWC_dwhXblRWnAVEdkf1OsmrZuOhQ', NULL, NULL, NULL, NULL, NULL, 'sLS649MiRCz6uae0ARkOTV7PJsX5lssO3YyW60anmbVe8eiNeibSK8adsYT1', '2025-02-21 23:29:51', '2025-03-27 15:59:29'),
(32, 'Josh Banks', 'joshbanks513@yahoo.com', '+2347080380361', NULL, NULL, '$2y$10$ZfXk3YyX0y2qh6lKzTqrHuURrpT2n0dN2ROT9iFogZv891boXQXJu', 'KD3xWNWR9FL7tEbozdaBtHDQQcdm8qEEFlx9badzNsSQktAjusvZj1CaOyz8', 'fd0sMoEtSWKBQge79pNwWP:APA91bGAljvZukQLTALHxGHTbp1H4Lf-9zs-AEpmQwcL4zDD8bX_nlItCL6OtW6yAMNlpa4EkdhTxSmNFjGObKj18F96LZoWDvEJ98PGVcgcXnCujF9jys4', NULL, NULL, NULL, NULL, NULL, 'SeEEmBv3coDPdWXT81Q6aWfq7JyBKaISvaqjW7Pb6CfLInboE2bD7qV0rTKL', '2025-02-21 23:38:28', '2025-02-21 23:43:26'),
(33, 'Ajala Samuel', 'generalistsam@gmail.com', '+234814768261', NULL, NULL, '$2y$10$XlVfY0rvkoyeywrJ11coWOnLMHBXTqqwEpikCWqM1vhk7HM9FhUj2', 'ltSTmSOexFQwZDiSMf7W1Cnz6v5TWtMijgSYXrABuHJ9aX4r4L9TyqvlywW1', 'fh1isK1Py03pu_7fqaj9qC:APA91bFz7AcJVA4u0ezpIK4iCfhcxpgxkFIe5OBBvKpnbNAD91gI1hEXCRL_m2NhRRfD3Lg_IzkIQ-toRhrjHNYyxc6lB9LoPknrZVHA2GQQK_7S3Y8LiBQ', NULL, NULL, NULL, NULL, NULL, '3AcPOveFEU2lxDMufpbBIE573K63hFWM9xlwdxCrjtq8DmXRE49YIr1Ka0VD', '2025-02-21 23:43:08', '2025-03-27 16:05:12'),
(34, 'FMA', 'Muyiwa.dih@gmail.com', '+447359317743', NULL, NULL, '$2y$10$kZG3.CpAcamobbUf2WBbauCBXL8lrpA1LFhrYZzRX4wzx1DelCzW.', 'U5bp4Zbxmu8xyovpBLW4x7XxasDeBqFchwTw5Wfrl6kxLoVZnstsf0WDzjfR', 'dPP_J2UmlEAallFPsU-UOi:APA91bENj98rzDfgH5VPHE9nmYNMqeZtsLuFaZHCzExnI_OFkOQkCXd8-WdrbSkoIPa-xPInOPIukXMOqg6eJCALeCeMjeKqsYVJL0uOWAbRLmtY0_P6vF0', NULL, NULL, NULL, NULL, NULL, 'H1ImtCxUpuSfCrERXzBD98ZrGPC2pqfMo3EkphBZX9iGhi4Mm0ByF1YJJg3o', '2025-02-21 23:57:05', '2025-04-01 17:41:31'),
(35, 'Ajala Samuel', 'samzy5236@gmail.com', '+2348147683261', NULL, NULL, '$2y$10$04CXHz7lLo36qm.lYmilwu0jxoIFn2DWpWgSpt521qCuOhMRJ0a2q', 'DUGVrBe175SZCqI2tlF8KoLtKZUiv6mYRSwRnZhPe3GrzE83xhlEA2XDIIyx', 'dcIlA31zqEPFkT-eSR6Fhv:APA91bFT9yfBSJ1rNUja_FvsrtYXSVmOfc-9wijFk8VP6iPjQ_FitxPvRJlLJjKLsbvUhjV3qfftAOFBMonNrP3Qagp9OiTATyXg4vtRN7KGJfXa29WZsLU', NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-22 00:32:56', '2025-02-22 00:32:56'),
(36, 'Jasonken', 'allli.nks3001@gmail.com', NULL, NULL, NULL, '$2y$10$/WaP23p1RcUHBs/cvf95Iu.VaoOQ3ufowuz/6j7QhQm8A3kBm4QY.', 'rSUZR60Ke6jZlHvPkEz1YPTC6AgoXCjRFuLg2zNgbQAGwB5ufAnin4ZxlydK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-22 03:50:48', '2025-02-22 03:50:48'),
(37, 'aSVrSEvsK', 'tempestoi71legacyoi@gmail.com', NULL, NULL, NULL, '$2y$10$M11VI4CCbeQXUwqlPp0oC.MTZpe7iaF6p4wdPKIvNGJ5dGP4oPV8i', 'nWpmOxLVft7QTmfc51EC45QRZTKEMlzrsGO7r0ZgThfUF2rM4vt4vVImZN4X', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-26 14:45:21', '2025-02-26 14:45:21'),
(38, 'fsGluaINH', 'belwatsoiy26@gmail.com', NULL, NULL, NULL, '$2y$10$1gxMlyQ1rqtEwx5ybA8UDuUldcJF6jSymcQp/GSrqGqDldZLPFZF6', '0AdGU8LvfPjszbq9Is51pgwFAkdgrMP7Jbuof84YYAfEwLvi61nIbuYulVnm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-02-27 12:13:55', '2025-02-27 12:13:55'),
(39, 'idYZzRCBhDtmFi', 'housfloe43@gmail.com', NULL, NULL, NULL, '$2y$10$n36A0/0obnicmNMIxHuZIOcBTuw0df8vn1WaFsGCh20sI0x.dwq7a', 'V8QNfhccpfNmOkfJkOwH3tYijIdqEDCttnosWve5TJExd8ZbfZ78vuGcRmwS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-03 09:58:17', '2025-03-03 09:58:17'),
(40, 'pqVCEyhQooOHhO', 'luksblankey32@gmail.com', NULL, NULL, NULL, '$2y$10$2PuKIXeShy7TjNgfdhE6gefmdk.ANK2l0M91iQoyB/WEX8tyUsSZO', 'sEVeLAgsyCxXNhw3GCv4zSIZPTY5TOgscDaIGCnQmTPjibsx9Ckwf5nA7FV8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-05 11:29:16', '2025-03-05 11:29:16'),
(41, 'jNchFuigA', 'rhettakx9@gmail.com', NULL, NULL, NULL, '$2y$10$c/ifT94fd5umdHmWoFixKOMsru2g0nd6NmZIX7XuQExCPVHma/IJW', 'JSSLNv8AnTV5Q509zh5jdGndadQvXj9mC1Q9fQvAyks1oxfoDLMDsbBJdeKT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-10 22:11:51', '2025-03-10 22:11:51'),
(42, 'Breanna Jefferson', 'bjefferson1653@yahoo.com', '+444699012021', NULL, NULL, '$2y$10$5p.oHqE97enpi8iPmmN3reB1Zt9920QYY7Ky6cuRRmQBbRxPmgAtW', 'btT1a2vbas91MVo45snSsMi4kKdVM4efRHRpzuuOV7pEuBNoGwMo34cRIKa5', 'c9j4927X2EXkr7owMAqTlv:APA91bHJxd5pJnP1aaHIT1qOrACw3sgdk3nMMwBgYrvbfE5egdt2_T3owOO8-0x21rNil422AADKubI3rVZxKjMwU3cEzSEZkJmrpUkHriXCqaN6hjMUvTQ', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-14 03:30:38', '2025-03-14 03:30:38'),
(43, 'bsxVSAuiM', 'walker.denise760154@yahoo.com', NULL, NULL, NULL, '$2y$10$Prvw3EN5ZH6SGjzGNX1ZruZNAmV6QZA6L8QMnnwHIDQ4EX1.IuT7m', 'U79SEAIQCjStwrtI8C92TK8mXmZ7mUeSDhw2W0DU8hphX7vmdrrJxRaSRJtN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-16 00:26:41', '2025-03-16 00:26:41'),
(44, 'RGODznfg', 'russell.smith777729@yahoo.com', NULL, NULL, NULL, '$2y$10$i4NsUB8EJQcp7cN1zG2kX.7ZBbMXlQfr.S5bBxklXNeONwUP9H8gq', 'v24bIqRK3jzzEAYFVg2r4fRBtT2xKzFYxiLAKft0Lu0855v89kUXuO4dOP0w', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-16 17:30:12', '2025-03-16 17:30:12'),
(45, 'Anna', 'annamairehale14@myyahoo.com', '+13855077444', NULL, NULL, '$2y$10$NP0B28CVzc.PqwHZ5Jzqt.cjk6e100p3egXwj/FDoQog7LMCBL/O2', 'L4IhcJ4Dv5iVcqIdETaq8H6n7oTGJaxynb7dLvTV5nGggSK9Sou8BtKXmz6O', 'cOxsNKhw7E0utgKJSyZXKS:APA91bHIbhIEXiW-_rl3hVdzfjUBmAmhsMybd5t-zJuBHPHyoMx_0w24WT4zzOiBNTmXkLokfzWg2Ft2xP9aVWALlBCIfb_2y_qBAJaOAeaSOV_et6xK3cY', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-18 22:25:03', '2025-03-18 22:25:03'),
(46, 'bwruMVesffeTi', 'dayzeksf1991@gmail.com', NULL, NULL, NULL, '$2y$10$CRIrBx5XmcJbgRG3ouUaCeOuyJopKvBcXb1h75QS81PYFaDMqhVmG', 'aIRpWsaxMfPB1z9tzE4lV4gylorJwqThp1JRAXFnlJws8Y33Trnv0MB4vQhy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 02:34:25', '2025-03-20 02:34:25'),
(47, 'Willesha Davis', 'daviswillesha@gmail.com', '+16613462223', NULL, NULL, '$2y$10$DLJrx8oJEj5gUV3kaL8/kOtrJv5RJNGl/hmEgiTJNRuI1sg2Ig7Wq', 'ghZRN5zVAYIGa8ZoJyyRlfxpuc5HoGhrdrGoNpQkUbojaz86AcGVB9EfyMbU', 'cKt9byUtCEfygxNgtvYz7q:APA91bGb2R4qzjOixACa4v8mnJxV2MSQdPaR0tqfWKsEULp14u0bXESorv8Fe4k-SRO4W0NaXNc3PmOxhX_0iL_-baR6V7gqhhUuy0V2k2hpZyfE_2aXoOs', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-20 10:38:36', '2025-03-20 10:38:36'),
(48, 'ryrzGPcgTEBkJP', 'rasmussenmetuac47@gmail.com', NULL, NULL, NULL, '$2y$10$mdUS/bO1.oWgms/aP.j/DudVjurbN57JcLjEWKRZiFp7ptVGTQx1u', 'ZaVJSPzPy1xbfwkSLG8SmfVuu3kZ2ObmBlhDW1So8cwCNofJBxnuToB0KDwG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-23 10:25:45', '2025-03-23 10:25:45'),
(49, 'qCKgcdHl', 'frazirfischerxj98@gmail.com', NULL, NULL, NULL, '$2y$10$VhgiomSLCKQb2ZCIzSHKLuqjbPCm6vVdRrOuJv1CxLxgzVEgpeJiW', 'OXOSgrG7au7kVySO5txjuivEnhn4HAN8Klr9SRkhU9LRehSxKrcVk1az2KBT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-24 03:58:22', '2025-03-24 03:58:22'),
(50, 'kunle Remi', 'hi@rechapa.com', '+447700123456', '2025-03-26 15:04:28', NULL, '$2y$10$b2FZNIizvxPFZ.IDd6izRu/fhGLx90eSmlLdcUPQ18FJvH9yLe7VK', 'cNqjtJ5oeqThLe6GvgGchhS5nhKY0CykA82eFr9PO0HrH5TMyLHyyB6B2KXU', 'eGWPPjvQTs-S65y7_hoZPX:APA91bEHdHcD65Om17uq6V076MUDkVk10N6eBQJNojjfcPnXuwtQeX7pjBDta2ki-pz5LSajvPbTnM0XS6_FSoojN0wJmgd-WDTIjTlWoycUWgsAWMUgWfW4LJvMJwmsPZC6AGcB4gG2', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-26 14:04:31', '2025-03-26 14:04:31'),
(51, 'angie', 'kangellynn@gmail.com', '+444096558515', NULL, NULL, '$2y$10$ITs5ikaROCZP9XPsxBqoyexQIWqJ/jfvcRXQh5S63Q7TJ9LUExFR2', 'HNtq4AW5r8v3YQSdA4ZFy1h9AENHAtwDqUG52yFT26uJ1fEo5KmEjWL7QsoY', 'dTIB-Q7E1Ez5lu592RsVvB:APA91bF05ANisaDoy4H6eVX9zq7-Vhwtkhgj1V0Axh-8cFmg9uJkdzoBm3yZOVqO43uR_1HtaAZ6Vd716h6QFUWwe9QNtidaHa0qQnGWPiatWLlFPpaS2LI', NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-27 12:20:51', '2025-03-27 12:20:51'),
(52, 'Bolajoko', 'mobolajoko.a@gmail.com', '+447440311669', NULL, NULL, '$2y$10$ElZKlcCSTn5Am9N9pI5Ssus0/eEKmV8eOHsxg2XaZl1vsUROcz7Ti', 'egHegNFdnmMsu6Lhl5gncFxi4ObUghvecA79QW6t9CQpPOlBn1BJubi9V1jP', 'czH4PBhfsEhRrZUqwLGAJP:APA91bEEbdKa6cxSiQsvj84R_dbjOr7KZvfhfEffdEEE46bj869f0OH9a3ZDECU7DLnVWDzThsTrDUTLadlXC-Uo1yf1mpJ68FU7onOyWxyKk6y8OCu1bTQ', NULL, NULL, NULL, NULL, NULL, '97waWRd6H7Nct6uhsePOlLKG5mb8tnOf5OsEXg492LeAIw8rx1o6b3do0bY4', '2025-03-27 15:55:18', '2025-03-27 16:06:44'),
(53, 'qJzjnPASfehZI', 'gzanderma@gmail.com', NULL, NULL, NULL, '$2y$10$ZFvMkzONcIO7zVrh11jI0uK1O2iG2cFM2puQsayZAVNMNDwtxdiaC', '8Kb9v3Y385e1iKsleHsQBzlbsOBvqLQkh2RJ3XIhPmKx7arZYMevobb8jSdF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-03-29 06:38:22', '2025-03-29 06:38:22'),
(54, 'xwhvNEpjVbSP', 'jennifer.phelps925201@yahoo.com', NULL, NULL, NULL, '$2y$10$ImBSw7TbbsJEEnemWmdMjOGHZc1QQa3Is8rlyGPj5tuZXzL.lGOcy', 'lHGkRArAG1grWSswhYY9kkmbj67Hs9kNU9KHmmLlAQcqwIEu6BfqLnxaG0k0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-01 02:27:03', '2025-04-01 02:27:03'),
(55, 'vDwNqFHMUnbixS', 'mejkorri@gmail.com', NULL, NULL, NULL, '$2y$10$pJLX0uWbBPXaFimHJ0yOv.2pZ..bL4tkdADDULpnQr9oP8w54fj1q', 'uAwlvQkAed7HmmJsU4QnUYhthO0hRv0FlghYUVQG0e2S9d3JUgLT7wJLCLjK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-02 06:16:20', '2025-04-02 06:16:20'),
(56, 'Tester', 'webify247@gmail.com', '+2347083554000', NULL, NULL, '$2y$10$LfaU2tJgMyBdQVMZ6Clcpe07TTaPAkhDyLRzMufYxPOdeFkCAg7eO', '80eMfBFEsfni08ke2bR0n40qSZOR50yr8kGmKi05Y8cOVzSAkSOQYSSpLA1d', 'fGgVw-de-EB8oJhx5TK10m:APA91bF0vmj-4IwSS-uMwBaJ_lbUUEGxHNmw3K-9nvV2cuG2eBGYFzgKXrKo0o4g3z04HpTOI1BNEQYzGxdqCB5SYbPc6QuHAnafQGjA33bkcJSSbwLyEVE', NULL, NULL, NULL, NULL, NULL, 'IjYmq4x1ScK36ZH9KK6ds9wyjAUYZtyd8ex0YJVT3gurowUKPA3sNTp172yN', '2025-04-03 23:17:01', '2025-04-04 20:29:03'),
(57, 'Seller', 'Samuel@wytepage.com', '+44123580748', NULL, NULL, '$2y$10$pERPQ8NSaXHRAtlDkvO5XecRKvJk7u6xijtmSLt1wV/Z5l0WC5PK6', 'OvInXZ2Owyrljs4KiXP4ppLY2sVhRCWfTbRKIkuRJoeOq80TavxY96Bi8Ffs', 'dmJsNLIMxkE0rYE5SCMguD:APA91bEfJ8iTcME6expigx7vfriTgMbdQbP3zUJVQz-UsFxGOL7qzQvDsFMdZOVZQsQG5aQLdrn-ghAe93gCd7SJ49RGEubbGN8PzY13hdZ9ZIqCny8qFCc', NULL, NULL, NULL, NULL, NULL, 'oVR0EzllwHAEnGN1Z7D7vKqPivB7OvXuXu0PO1endJBV1S5TmQUrG2eLdDwZ', '2025-04-03 23:40:48', '2025-04-04 19:40:44'),
(58, 'Opdwodowkdwiidwok djwkqdwqofhjqwlsqj jfkmclasdkjfjewlfjkwkdjoiqw fnedkwdkowfwhi jiowjiowhfiwkj rohriowjropwjrofwjrijeiwo ewaofficialapp.com', 'nomin.momin+372r6@mail.ru', NULL, NULL, NULL, '$2y$10$Ql49YMb4Xs8RL6pghKYUDuuJ/8INWyyUelfsRSZkx4PzsY/50TIuu', 'TVtzNDOkwmqytRLk9pgz417yrJbkjomOXagVvqZjn8Wd73FnSgo0JC7BDo0P', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-04 08:27:24', '2025-04-04 08:27:24'),
(59, 'aXlyxDTrGoAFiQk', 'anna.long1994@yahoo.com', NULL, NULL, NULL, '$2y$10$34Hl1khVhhjqJKBX9yTdZ.pJ5HfasWe/oayKAjvq874FY.sdEwF5y', 'l83qmHMfbsBZIkLvX6U6RBjAPIhgts0Y0d6pgLC65EfZXBlYZazxjvpuyvyc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-06 11:22:44', '2025-04-06 11:22:44'),
(60, 'shnCBQONHUBQcOB', 'kcarrillot32@gmail.com', NULL, NULL, NULL, '$2y$10$DPSNl0.pXa/w/1Y0nSuRVOqP.YdfA5xKNWYtaUwfE/biuzo0FfGDq', '0FLQy7yahozdhduP4pmhWkd8fWOo4qnkKfQTwS1AqCRb8eZZoMLwghKt05w8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-08 01:53:53', '2025-04-08 01:53:53'),
(61, 'jLlQmRmVQ', 'downmannik6@gmail.com', NULL, NULL, NULL, '$2y$10$s25m/Jh7HLhnUpuoAQCgXOvQOt4Uv0D1dRcuIkKoV4nA13FJmKql.', 'zBSq0AOlasB0Ak0UraJe1n3QxORwDhNhR8s2npXvHuHX4ngmj5bjBkxaqzBB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-09 00:38:27', '2025-04-09 00:38:27'),
(62, 'UkpPAbLfJoJaHwe', 'donna_anderson729599@yahoo.com', NULL, NULL, NULL, '$2y$10$CM.SENITOdll2AaK2LB6SeASBax5D5l/EG1NhCHFvyYyoTRathrAa', 'KhWMbVuXYevxW1FnmaGe8xVpeoULrwkzmwwNhKcozhezeZqEehTuayW3Gb3F', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-09 00:46:19', '2025-04-09 00:46:19'),
(63, 'qVMwyYIEKuyh', 'dollaybakl1984@gmail.com', NULL, NULL, NULL, '$2y$10$qHmi3F2Eio3FJPFHk54l7.GyJcrtLanWyM.iTcyIx1UArNnihTal.', 'IHDGMGU5koFtK51rYZCukmYSNYT3zGyVsiWkAGWl2Pdxwhr86A1v97TUzV3k', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-13 04:17:47', '2025-04-13 04:17:47'),
(64, 'qOPejkqg', 'penadjerikoi5@gmail.com', NULL, NULL, NULL, '$2y$10$looY1DoimhmZShmbXPokr.gwS4hvjM7wkT6aQiGuULRtoG9UirT52', 'aKETT2oUazx36raFLgo2h9gdi3VngIDp2l8I8Jl5SxB3ZQNdIxFlnWkSbS1R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-13 10:38:21', '2025-04-13 10:38:21'),
(65, 'VaPOWZww', 'bflemingr3@gmail.com', NULL, NULL, NULL, '$2y$10$WLSDOpLXEOJneZHGOPBiHO3.m3JaB4NXepGu1DTRZEgZrtRVDLYw2', 'Drs4XurSXdlj9SnoVPHxxcWQ6TsG3S6wKKaEOOr2uc4UrOIuDOZS1hEpIBRS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-14 15:16:02', '2025-04-14 15:16:02'),
(66, 'jt', 'jeniyali45@gmail.com', '+446469383038', NULL, NULL, '$2y$10$ApJ6cPWoBDQcbYvMNxbAY.DgQmvrMXiVIj1R5spNuZF1Ns8WXDkSW', 'Ih3c1UCkFs6wzyLJCQsqporjvEGth0zUgMljA98zd4zAEyrp91zSOzWRJs95', 'fSrDPvozM0tHvMevIAAuuV:APA91bFLRaGZPnnOKFAzRPPTCggaqGQbwKAepO-t3QqGZ9Vr3EDxFfK6opGomqiEBVgzNiPldpyOcmQQ3RA0ic_XrNEnJRBBR2kdWHex7YjZWgoyJ-b_6XA', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-14 16:16:07', '2025-04-14 16:16:07'),
(67, 'TlSpGrdKDeBLIQ', 'nikolalogan24@gmail.com', NULL, NULL, NULL, '$2y$10$cTwUoJq0NYoHndhvzMK/9eBHSRwanDBgEkDfX1SwtjG61iY3K0./y', 'lxGekHc7u07VSIYeRy76NuL2Gpz58doPmu1rgF3ImEU9s1KZfgIT35sxGKFb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-14 23:12:15', '2025-04-14 23:12:15'),
(68, 'vuyolwethu Tonci', 'vuyolwethutonci@gmail.com', '+27745530721', NULL, NULL, '$2y$10$aTUoaPdFjx/n77p3VBsgZeNGn6QRz0osw3WZYvLbl4se8Z8/f/NZa', 'WqC1DHFiNtwTpmVXvGtCpkzeaP5SgtkbgJIAHDA6wCYSulr63MkCOwGunzeH', 'czHdhW_FFE7jrcdADgQOIM:APA91bHPNdXhjF4t71cg3CCpqzIae30ALsORY0_CBha1hr4203vsygG_WoMK9UIEfYAJ_yROKPXWK8CGmMWB5et7eD66zPW30RMlwihNKxxuGLvVthS_Omw', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-15 04:49:12', '2025-04-15 04:49:12'),
(69, 'mxSAioDVAdudQM', 'bflayert@gmail.com', NULL, NULL, NULL, '$2y$10$rblU4Dke/vBry3TpEsx0NeMLsCP0AimTDMPk82WOhSabEnFi4lrI2', 'zABkv0vHG7moqcbfQGEOwp0anLUuzNHRrR4TzjEJJPubbe0xgJ8QGn46kxI3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-15 12:59:12', '2025-04-15 12:59:12'),
(70, 'Fyah Hotti', 'prestyledon@gmail.com', '+14734583967', NULL, NULL, '$2y$10$rDXcbT.UHhRAstRmhz6pOebZ7P1/19q90U6jIk4.ar37cLUKMWSiy', 'MuuezVSG3fRM52nb5vJB4aGohjLA3Ln3qaf9BlFF2SKXUVHkiH61HxIDHB8O', 'eAMjDtiNIEMTkBw88sba1V:APA91bGIIMMxZDB4OekAToWB8JSH7BxSPIgyDl0aR1ebpR-FRjbVj3eJZxEQHX4yxPoPzZBa0eKXr1_Qx8LlXzOwoHHpiRSxODAUPaNJkqOVjB6lj-mFILI', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-15 22:19:20', '2025-04-15 22:19:20'),
(71, 'weObEpwURuoTxEz', 'cooleyabott@gmail.com', NULL, NULL, NULL, '$2y$10$vOHxl39sdnEKyu8Ery2SwOrlp4iyGdSdRwj2kuPJzYVg/iszaBl7y', 'YCjPC1LIUh0lsfEL68FBZzydqKeRWkooGAJt3p5TL8kZzXU6TYNIDBQTmWMa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-15 23:40:21', '2025-04-15 23:40:21'),
(72, 'ASzkrXBRp', 'allisteircpc2005@gmail.com', NULL, NULL, NULL, '$2y$10$d9ZXM.rheRx8.9RvHnNGuObPPYWWOvo7ntMnKvOcSGGIZ7v893BRm', 'mQYW5N7bU9QLAZTjeZyksDk9xTdtEEJhiaRMZWognf9gMdXK1bRHms58byFN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-16 10:34:47', '2025-04-16 10:34:47'),
(73, 'BDBagyYG', 'mckenziepeidjiq1990@gmail.com', NULL, NULL, NULL, '$2y$10$liiwGN1ZtNKxowMRDbiaIuktyEt.jcxgN0e2fyoFq2EYkxoHN.p8W', 'iAafWHw6pjCc4qf3cW99muoK83q3pDE4KDM1TprXv9nBklV8kmVcUN555nZk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-16 18:24:49', '2025-04-16 18:24:49'),
(74, 'vpHbCavBWnlkWW', 'byrdchelsiuu28@gmail.com', NULL, NULL, NULL, '$2y$10$HiZBG2P6p2cEMsyXSbrt7e4PbS2hOhPrlEjlewlBGYbYke7zwqmFG', 'mpjHV3n4rpkYQiwKX9e1X2WPAOSXuienuR71BL9PAIjIU3SH7t3oiu1J6bdT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-17 15:53:04', '2025-04-17 15:53:04'),
(75, 'gbpZZUfdejj', 'perrilqt6@gmail.com', NULL, NULL, NULL, '$2y$10$ydzaqrxPfDWIVsKCHzBMuuCD2zxETrh3HePul8E7ZUFdU6ZBRk3Hi', 'PwXYfboXjQkuonSRhIKbzc0xXuy3Mlp6XwLulRMMDD562pFzWaLfyGyIimAp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-17 22:01:11', '2025-04-17 22:01:11'),
(76, 'RLgThlNAjlD', 'hughesberlinhp52@gmail.com', NULL, NULL, NULL, '$2y$10$xYBIwo66GKVqT25033VePeiEkakZ6YXABrvhwVJTyh57KQwXGIwFW', 'XyIOEYFB8qh27QfGMc5VPsyNYjNnGL9ZiYV6Bupx7UE61ZDJ7m8qgPQAjfAl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-18 09:05:18', '2025-04-18 09:05:18'),
(77, 'OSCdMmRMNm', 'lusiwolfz1980@gmail.com', NULL, NULL, NULL, '$2y$10$qD1qRibkaRsykhuck9Vf2OQ2BjE48auWwS7L.VLoZrobQtj4k2YOS', 'dkpCYqhCH8YljjMIJ3u6JSEjKySbu8JgGhbMag9D4T9xzfCUvhSoAd2z6VgU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-19 03:21:36', '2025-04-19 03:21:36'),
(78, 'TiAUsZGGcapXiT', 'dhernandezrn47@gmail.com', NULL, NULL, NULL, '$2y$10$9Mf8.sJTqsLeMfuYvNuRQudZhs8ggnOY919ljinwMOlXvOrBCmfv6', 'JaOHcQwvwDdIxOly0FXrptAPleeO5XmMOVKQIV1pFi8UTW7T0WFeb2rLGLLn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-19 04:05:04', '2025-04-19 04:05:04'),
(79, '* * * Snag Your Free Gift: https://mushfind.ru/index.php?1bzdst * * * hs=0955f8e2019be69f2cf760ca761c0385* ххх*', 'pazapz@mailbox.in.ua', '046147969670', NULL, NULL, '$2y$10$Kw7x721kIhB7Fb1Wf3CniOlXJ/.Mr6PTAbUHwTpikhP5g.OsLtTvu', 'bA5kSgdWoyKOlxhQtrKxyqeeTdMu7yuWLsbUSIhVC1wZm800Z9ZcRpwnDHyG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-19 13:02:55', '2025-04-19 13:03:00'),
(80, 'WEcTvAVkz', 'grosempecof1973@yahoo.com', NULL, NULL, NULL, '$2y$10$j2.CvYZVYJgXqSYG7h8psudztP94E.fF0OersSytgKZ1mp4w3l7mO', 'u4zHHK3V21qS8vdgvklxLPb9Q1NH9TFczRB6PhSK9PzoSdEjFYIvkudiE9rc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-20 03:19:09', '2025-04-20 03:19:09'),
(81, 'Adipi Nancy', 'adipinelva30@gmail.com', '+5977164692', NULL, NULL, '$2y$10$SAZI/jIqinIMFHwtpb.u6O0fM39wBS0XwViEDdj.BHRLhqxypOMy2', 'ojscWsMmhdRZXAeqRvZ1jqWytxp588yEkRDXSPXawqbYpI01J2VnWq9v4Z8o', 'cHAGMGB1UEnWlY7kfkwfQ1:APA91bEBRAJzDUvbhTgKAWdmnYzVlcoBida6pkvcRn6Xtqw2Hx7FrIDb93duaghCOCirIGu47gI7R3eXba5fDMMSdNAplhUesu3DGPYCJH9MdosCatsBWTo', NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-23 23:54:11', '2025-04-23 23:54:11'),
(82, 'esfAsFARMfX', 'goldesher@gmail.com', NULL, NULL, NULL, '$2y$10$EdimVnH6lmojOA/9Uqt6cuyMg0X3K5mkuMWVI6gPgXXLMEKGoVFG2', 'SqJhAr368EPBssdQoBoiTJ1SZxy5vBrgZAE83x6BiXxl8d6qxZzjGQYXcQVB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-29 19:52:41', '2025-04-29 19:52:41'),
(83, 'bzkgHdrAFRIo', 'richardainboyerm@gmail.com', NULL, NULL, NULL, '$2y$10$Tcc8eF323c6E7zU7YGpawuGolSQjSVuoXe9VxLb/6X0dayHLWlI/a', 'ego151bXZooVYsklrA2JK6qndcLGOUiVQ18fMwIWzpPpX7NOqzANnlseHAyy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-02 10:51:41', '2025-05-02 10:51:41'),
(84, 'DcdSINnjrVR', 'kainkey2004@gmail.com', NULL, NULL, NULL, '$2y$10$/ZcFmgEg2BLi9nEBJspwxuA1g8C0/s5kGdl33lg4YjglTcp5WvLPq', 'jo7j6uECRBnkmZ4h1VQEWgXNUwlFzERKM3TCnOK0ruHL6ZqXSBdAsJPeLuoJ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-02 12:23:18', '2025-05-02 12:23:18'),
(85, 'KkBTSYvb', 'arlainchenbd2@gmail.com', NULL, NULL, NULL, '$2y$10$YcaFFXAQPTbd3WrL/tpRNeZ.dZzOgj9bh3kBv1FpNx1FN0YH/y2vu', 'FEObd2oNTAOheHwkC5W12zH3V3lVSVW9Tk62WMFJ5bxdVsd4rPLjgJS2WCBz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-04 22:22:16', '2025-05-04 22:22:16'),
(86, 'DFmObIcJuXPCnX', 'elmliuur1984@gmail.com', NULL, NULL, NULL, '$2y$10$Hiuh00aORz.U5gfpaCYuqutWZ2O8iYVEMJwzZmq7IsAdr.NmKY432', 'TIjoXrhJZsPvmvkBTL48b3SBYSQxpdxu3doXQ6JuTkY8KMNTDA72Rj1NWKmp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-07 10:38:27', '2025-05-07 10:38:27'),
(87, 'pfMaorXT', 'cbredaru@gmail.com', NULL, NULL, NULL, '$2y$10$Mw4BlPa/Zy9zetOa1HX49emkm9oB/NJnrXLI7LujxaNiulT6QMDf6', 'r4xMDlWVw8OcDrnL6W4nOBMuibdYgaUPoKDV78BHEvWvoq6WlXTbXynrjcqi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-08 03:21:55', '2025-05-08 03:21:55'),
(88, 'Lyt', 'janay4eva@gmail.com', '+445612014669', NULL, NULL, '$2y$10$q7d2A.EQln2kl7l6YqDsH.X4z8ZMarG/.eT3htNNyniQrT93ym6gS', 'q241XNxP7nHyNCpFXXz3RPmNDkbwWGVTv6Kx6cJj2cPGa42blPoQMpomXHD6', 'cfaTophQJEU1q5_w8DW4sU:APA91bGnLPSPj-Awomi2M8YO2M6vvpM32ECFwG6yldOJvvZTy34WmHVrvTX5NyAnQ4y_43NdRKA5GU4y6lGz0MpB_EA3aEQHFX8fBF6YE2iMojaW9RoLXHU', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-10 00:43:49', '2025-05-10 00:43:49'),
(89, 'wNiYfwiE', 'wendysimpson89144@yahoo.com', NULL, NULL, NULL, '$2y$10$qL/nhKB65vCIW4QflYdtGezoZTFPNlU8VBIHP0H7IC845DYKhrjVO', 'MFB3Dgnaa2mFgnDBogIsgyRKCHKgi3iQwx2ORe29pjVzVgpXN3X5eVUzxB9Y', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-10 22:27:01', '2025-05-10 22:27:01'),
(90, 'WmoFvvVKWALQIpJ', 'pbredfordw6@gmail.com', NULL, NULL, NULL, '$2y$10$U7R9FCoP8AL0h7K95d2o2eLY8Q3Hwu8RtRHmPH1sDpmQhR34VkzOy', 'glDQyDIwLsEyt4TNo5vjga72zzr07FGCHs8ibkxHatPNMuuOiG35fdKdodgo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-11 00:05:52', '2025-05-11 00:05:52'),
(91, 'pBmUdXAB', 'alemcphm48@gmail.com', NULL, NULL, NULL, '$2y$10$6tCdUzi47urgKWnre62Gje2G4doxlOtAZgoU6S9gNLQCv3uR5XWqm', 'gAdMMzcGtUTmaF1oHH5h6L3DM71a92FMkTlKj4gVcwQUXOQIYzHkzpoVNIp4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-11 18:46:10', '2025-05-11 18:46:10'),
(92, 'rNPMJnqxBTYydTW', 'mulcirater1977@yahoo.com', NULL, NULL, NULL, '$2y$10$GG3GEQeJqGQBydP/GvMQJuuHcrPdLs5RY0bBiLEnqW/T0KJjwaLMe', 'w89y2NlKhS8mxXed7VnHrQoTKPVMl7mO1mGi4FdWGeElxqCFEedJoWgcPtW9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12 05:57:42', '2025-05-12 05:57:42'),
(93, 'fDQaFSiVA', 'foxphilip1990@yahoo.com', NULL, NULL, NULL, '$2y$10$9yGUJ4q/fBCrU3NGDguONuJDoI1OWQTBC19H8gpFiAKS6H18vxbke', 'MtaU0qoJyyEQFP9jnxePCDwXzfE58Y7zQzanandJXQgBzNSy6g7jHG1X2IJg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12 11:39:34', '2025-05-12 11:39:34'),
(94, 'NftsjOxuNrLm', 'macktamran1995@gmail.com', NULL, NULL, NULL, '$2y$10$cIWJx7PGYffrfeXDMJdtZuECr2M60QRAQabsKUDqJhBfAOLcIYaB6', 'BImZXJvszH6QUrkvw4BtvGh199d6ZsYEK4XZ0VjfH0SN430BdLy4Mb032tMj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-12 18:46:26', '2025-05-12 18:46:26'),
(95, 'njcGlbLGob', 'vincenthills1990@yahoo.com', NULL, NULL, NULL, '$2y$10$djas9G5yKAPv.9hI4DX86u.XWemXfsrbXYnwLCaIC4qCu/QkPFqgW', 'b6dEwgQqrj2E9YChiO3Vet1STzxu6RQIDAAj2kjxDmr73anCU4Xw2SEv0x6L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-13 12:55:01', '2025-05-13 12:55:01'),
(96, 'VdQkiwfoa', 'lihnissh1@gmail.com', NULL, NULL, NULL, '$2y$10$/30/8FWGxlv8hIRneaT4cu4C6hLD/fYSUzMeC6.F94ogmbnVb26Qu', 'trFYbETVRbX6n79nsy3TMtOtBlWqhorS8ImMmf90DF8hf4KSFsXLmXKVzyA3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-17 10:46:04', '2025-05-17 10:46:04'),
(97, 'ZtTdCpmFsoKTyKF', 'kimgreiemy@gmail.com', NULL, NULL, NULL, '$2y$10$ceZ0T04/BsznW0MJfb.70u2dYsrjv3d8R4S19jQMP3eJe5CqFRsUa', 'RNfvspMI7pXoH653yUZOALkm5yO2oF53OFk60np5ZRYzFPig34MSdVnvzFQR', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-17 21:37:12', '2025-05-17 21:37:12'),
(98, 'cmQhkEkj', 'malihgr51@gmail.com', NULL, NULL, NULL, '$2y$10$GNBOjb27.R.ECwN2da5lweGpNbSIEFgbJ6y7hundUPtpOi.2GhaHe', 'Uv1jOsU7jNPOIgRLdcnuc0dEBwteZJijxc5yJFjO4gqltQQhSKSZWiMDPEEE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-18 11:11:30', '2025-05-18 11:11:30'),
(99, 'DUTnQaBBybwcUXw', 'harpedjanen54@gmail.com', NULL, NULL, NULL, '$2y$10$PPhN420Lr.5yjy/C6WlYnOLFvL0QadfBp.dqhcHGFEzknTq228dOi', 'lEGi5vcyLjAncC6N9wEuam72WXb453wdnUGFwouYNvtfpcQxRs3dBsUz5LmP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-18 19:12:48', '2025-05-18 19:12:48'),
(100, 'wqeeOpwizVpn', 'knbimcmillanq81@gmail.com', NULL, NULL, NULL, '$2y$10$YMWlUbSehgVqK2rIAU8lW.dNXDDapwx9FlEnsoT1u6aQl1vO5ciRW', 'pxCAMyvHTlKyCOwKMdQ18RzVTiDnSGJ21YNmX4lKLgNT0E3G6AmhLOVgd6Nc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-19 10:51:12', '2025-05-19 10:51:12'),
(101, 'lhIpSSJUwim', 'adoylea1991@gmail.com', NULL, NULL, NULL, '$2y$10$f1oG/aNtCL2jtpiObloi.OtYtX8lwYb3A00kn239eG1xPBDWqT92i', 'cXiRHIzk5wcyw9tsBH5irAzfS4tPvzgvUtwgAOeEOnAf95TwK5XVn7AxIDiu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-19 13:20:15', '2025-05-19 13:20:15'),
(102, 'mHeVHDNBeR', 'huffshinr@gmail.com', NULL, NULL, NULL, '$2y$10$mMECTO60sg41bujsV4a/I.QRlSnEhm1p1zVTwGYkJFXFLzJuUk0hK', 'TWDbJx9tiEFOdPvahCtANEIcC0cM9YbEGAQPXRzFj9Maxba3kcHyjaltSzCK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-19 13:45:41', '2025-05-19 13:45:41'),
(103, 'BtDigXVd', 'dawncarlin855084@yahoo.com', NULL, NULL, NULL, '$2y$10$wrqe.Qj0hKd57vj1.q1mHeHyQ/zfudOzOu6KQfoQmmFXGMvToCBCu', 'uhvMzAwpY4KB3LfVEwYvMhAoQXa4V7O8dzLFhO6TNm22g7etBPNJwlehhOUj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-20 00:56:02', '2025-05-20 00:56:02'),
(104, 'qwxouAXJVp', 'vcabreragw60@gmail.com', NULL, NULL, NULL, '$2y$10$u0G4.tScHIv/bq7jkHDb0.6iX3YSEZW5on2ACkQEjOXqXAYjCosOS', 'JubmXyXbXnzuIgtC9WbnBkaNskZInqicxl0bu1GkNRNrX7Tm5CUlRH42PLJw', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-20 10:04:45', '2025-05-20 10:04:45'),
(105, 'SNnrqJVYQV', 'hunterpeitonp5@gmail.com', NULL, NULL, NULL, '$2y$10$3PD73PN/yIAnrnagYF7Opea4U7Adf/EQ1bsfXnFFgsbXb4gdpy2AG', 'deeyKkdavAadawF4HJBJBUxA1RR5TimBocFIer1RU9n2sSkVBgqRFWr4EWeX', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-20 18:29:44', '2025-05-20 18:29:44'),
(106, 'iWSaINIZoygM', 'harrellmurtaza858950@yahoo.com', NULL, NULL, NULL, '$2y$10$hkHUydreLbDZsi4NntH//Oac0JFa.Qo3pmggS.xFs03vxLhKa/hWG', 'fxssjhTl48d2LIcqqddTFJJjvLoclnp5fw2my3mPqUujX13c1KbrSW7OVV06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-23 05:50:25', '2025-05-23 05:50:25'),
(107, 'TtVnnvfgWlIr', 'baileyjennifer110806@yahoo.com', NULL, NULL, NULL, '$2y$10$NFP8ee6yRJ.eDqiIzKE.Ee6crIdGq842jLKiTmDRXE/Hp2ORWWUwi', 'WrGCVFVDTgTUMW8K7voefvIE5YSSHScKlpaJwZsah43LZMbNpx5xBiXTDaRQ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-23 07:22:31', '2025-05-23 07:22:31'),
(108, 'aXiaUTQWmgp', 'deninecolon381378@yahoo.com', NULL, NULL, NULL, '$2y$10$Eix4Qy6wOK2oP7xvGziqwO1eaW4JeyyxjiTcxo18r.G3IufK3hZHi', 'QqXKDt7M5rJYAZv8UG03D3moYq6nmUZTq35Pc8dxqQlq7dHbMW1xI3N7f8m6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-24 05:01:45', '2025-05-24 05:01:45'),
(109, 'lekan Idris', 'stuixz2@gmail.com', '+2348130158313', NULL, NULL, '$2y$10$/MIL/ZT9bzMPew21LFmYt.0NpHvn3MWJ0t8faqpy2mr/yqYbEt/Gy', '3GWLOdSK8yFUwL3L1UYbU8tvQsEQJTr67Xfed2pKWnvsd29DlDmGXaotaEpz', 'dXgaPLm5P0C1jIbh2AiFXe:APA91bGoFxksFBwaYkhUTvNCUAtJJdyiUsNqrZo_2xOqTeK3Qf9pV-vcCmZ90x4L_IcvTmql5eG7KNdam4W9H-4v2Tt3fhlHR5DadiGtCjh3wDcoFBSM60s', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-24 13:49:34', '2025-05-24 13:49:34'),
(110, 'mUlaTpAnwZ', 'langleysarah595906@yahoo.com', NULL, NULL, NULL, '$2y$10$A1ZUaaCZS6sDN2kxIa14vORH6uFTmoAvEn9Rt6t6Z.eh9JWKo4e0C', 'MPpYXipv6SFyTfavhdcQEZ2InSBSc5ntXQGfyqD6K1FBDegnPzoXOvR2KdEl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-25 10:51:09', '2025-05-25 10:51:09'),
(111, 'QIAcpxzXMbMeNn', 'idverdmckeeu1@gmail.com', NULL, NULL, NULL, '$2y$10$zYCL71HASlc/6QuPWllm8..50u8vvlhhwkIe87JlvGigCiShYKH/2', '11b796OrrKX4gB57aZhstsmCTEwM2qsfpUv1N7nEwAzppetNOI7DKh5xiYsp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-26 03:27:10', '2025-05-26 03:27:10'),
(112, 'swhCRlPFFbA', 'dburnettt2@gmail.com', NULL, NULL, NULL, '$2y$10$LtwFEOzz92ib/MoIQ8QCW.UUsNLIc1nSuo6i0kofl/SgGlpyR7KVS', 'z9yjqfpwnkuBWmiQsP5NMYuF2xRvbrybWDKfVvRbpANixlnVrAnyThK9HWIT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-26 07:19:18', '2025-05-26 07:19:18'),
(113, 'FItSmGfA', 'pvelazquezt52@gmail.com', NULL, NULL, NULL, '$2y$10$J77bMa4U5NoxCu0CbWKL1uuZ3XfkxhGQavjGzYR/sXcsUaHDrSYvK', 'Vnq5B5Kc4HpkMqY3wOayP5o2cZ4nt1Ktc9S4LuQ2RyR8dRNRxzQQNsHuwy0x', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-26 13:59:19', '2025-05-26 13:59:19'),
(114, 'BmFjJvcsuzFUOa', 'fergusonevak48@gmail.com', NULL, NULL, NULL, '$2y$10$0tqe7Pam7yCYrR3emZi0cu.Y.cMN20bM/hPO3IZ9DRzQzUw4PBW6a', 'yYYC2NSA9YrM6nTPJ2c2ytZ8k29L7hwPvj0UpHF84hAUB9Sb7jOE7QhKbrwc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-26 19:35:49', '2025-05-26 19:35:49'),
(115, 'nrcUWKMHfxP', 'fonzjm27@gmail.com', NULL, NULL, NULL, '$2y$10$NiZGETvjOkYSncKi.uFiWOvYjdcXGSNGaJwzJ8sEFAemZmDfd/zTK', 'AXQeI711IMsYnzEoBDF4bNwuQvvUvh2mORLBXaTCg6nSKVfuUM2zxpVID6mF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-27 00:14:52', '2025-05-27 00:14:52'),
(116, 'OYdiEsAeFPxF', 'cmolkom80@gmail.com', NULL, NULL, NULL, '$2y$10$4.cXiDzmFF8aZTjtU/CIxOV7WvMr/Nu0rjM9GEMNoDkeUMS7FgdHe', 'smYG1S54u8eqlKpRoVbCUOkd7w8GeuKE1FDZhYKulekbEb4ymyJaZrvwuYdB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-27 01:48:41', '2025-05-27 01:48:41'),
(117, 'JXnlirFrGRGciJw', 'ahartmanf@gmail.com', NULL, NULL, NULL, '$2y$10$0hBIGbmY2CRj5dKJZxsJ6uzTUDZ6bodphZNZvFBJ1Dq9JvFy7/6PS', 'HPtHrammh5fC0ApItILSUtVAkSvzldsQoISHZbkvMRYF0iuuLPxb6hKI1K5M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-27 11:25:15', '2025-05-27 11:25:15'),
(118, 'Khadijah', 'adedirankhadijaheniola@gmail.com', '+23409158626428', NULL, NULL, '$2y$10$a/pW/5Z5HJmAF90JOjPZfeYZEohBRmMoSwJ0E/YQJ3YavrxEirxg6', 'fnKRcHgemmCP60CIOyQNVXEIUAG6v4503UciEJxuT7ojLqSjDdHm0S961xRP', 'ddV5HGGnSYK1qPWJq0Iy3E:APA91bEX-e5Dso2IQzHBNR9fCr80_Uf8OtsBeS-KEQHMmZNvBhGFR5AXwAo_lZZU_K3mbC6lnSpJ-G9DsoGJQ_FU37-xkPnvtxTnwIdQDlRCLdlWmiwjVfA', NULL, NULL, NULL, NULL, NULL, 'lvzA7g5YkCXZj8Bsje925tYQFsecxfJiFTWwG0mGtJ1dCeSvq05tQ6gkBzTj', '2025-05-28 03:44:55', '2025-05-28 03:44:55'),
(119, 'Asive', 'nasivexego@gmail.com', '+27731274611', NULL, NULL, '$2y$10$oV1KI31sqCkCwjW/V34aCOU5.lstM0tKJNPOXhuoOHQfYHX0356EG', 'YhESfkbPl3Gw8ViWVl4EEkTv8nkZnzmgBoavjz8pSnCzpBKPzVg1Jfin1L2Q', 'eSdF-0ecs0XordhzsPzXUY:APA91bG8hb0itIKZm-DmTs3upJL-sRB3s6BAHoLRKDYOJBxwogOCOrytcmB_N3FFvurZIZnKG49n7YatQf6q1nqlBqaB1jf5cZFHZO7-TyfdmxTm4YxqdV0', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-29 16:18:54', '2025-05-29 16:18:54'),
(120, 'Khadijah', 'kharddyheniola@gmail.com', '+23408095631123', NULL, NULL, '$2y$10$wMsNfLbkKYLwt5S6QdB9D.9kA.UcsHXHSkHiVcJOufHSmQcYdidqm', 'B6rMT7o64WYhGD8QQbFRaOulKZ3elNP3SfexNbpdFH3bvxsx1dQAjRdIbj0E', 'cezZCp_0TZmtP1ICKeF833:APA91bEB17pjjQ0bH604TWt_NldGv_dyppo5A1NZW9wZUVOxjQabelNpWafzZKc3qijSzF-tkp3gfAhdIy_qZw0uNJhJNuD88naOohYkq-nCeHxgjLCBH5E', NULL, NULL, NULL, NULL, NULL, 'Qp0iwa5Rzb3nPmqyEaOpZuYgkTHPNBUPecPp3aPG6RL43Q0YR6gNe6bcPwFD', '2025-05-30 11:47:32', '2025-05-30 11:47:32'),
(121, 'HAznffOvVou', 'watterskevin354075@yahoo.com', NULL, NULL, NULL, '$2y$10$dXVXHWDLPHUcxgqQDysGVuqJCgpn9nZXnEyXMqSq5ptvV7lonIu3C', 'vbixX7vFhmHyjcn1MhRk58BWjpYjDvT8k3Zed0I1B67xkOAIfxSunpWPNGJf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-30 20:50:21', '2025-05-30 20:50:21'),
(122, 'tansilu', 'ishmetova0903@gmail.com', '+79374747963', NULL, NULL, '$2y$10$7vyhD8L2D16xfjl8ZpQp/.AHO1c3lmxEVDuB8DQU1iaGRtfT2FLMu', 'QBS1moy0i3go91cjhTpeiBblO9H8o7eI3B60elkN8Hxj8P4DRlsKQv3qhlni', 'fBjKV-kRSkgnv7-aKLotvE:APA91bGc1NlnQ3ViTxQ17Sqop-KkR5vG_KA6ryPxLJr0w373HRLAeskeevX4vzIs8ooV_gm4m5JVA4cjGi_nWeBNWqFXBMvrShAl7h7LbVS44OpusZ4xilo', NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-30 21:09:44', '2025-05-30 21:09:44'),
(123, 'EQwKoNqR', 'hovivianmd54@gmail.com', NULL, NULL, NULL, '$2y$10$6tWKadR3ATatMDtCSSZaeOmUXAG2Hk8zjzYI67ZvQGKH4Fybnhu8u', 'UAxpenizsfEz4ZJo6U5NC2k8mJLyE22Sl7qHgLL8PuM7j0qexJD3U74rU8sg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-03 20:15:36', '2025-06-03 20:15:36'),
(124, 'IwvQVRBEKC', 'castanedalakeshiyar1985@gmail.com', NULL, NULL, NULL, '$2y$10$nsHouQb7x4bKZVD/ydYBeO9sP5jW71IdvXDi6Ua4euUTzhuQV9ZPi', 'AMdTLmSQ3EYYMgIfB5liZZbIpjZrf2Y3BC2VdGgoIq1XQidDI91JCE60vXXA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-05 09:34:35', '2025-06-05 09:34:35'),
(125, 'eUeOFDlFVs', 'vyattwarh95@gmail.com', NULL, NULL, NULL, '$2y$10$IXWUz7WmEilKJawBa8dcPOx0sdvvY7NHIoZZAjURlOU2duN1SWPZe', '8Gtp0TNTiDXuCUTfDT0LNDkGzWItKC4F9Txc8dVoOBhad8qzqlTcwFThZh0A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-07 00:40:55', '2025-06-07 00:40:55'),
(126, 'pIVquaaKJruSXp', 'ornatrujil@gmail.com', NULL, NULL, NULL, '$2y$10$OkszP4/hn/jnh7oskjsR.ebunxMqtCUGJxGE3xyjHhwbmFhGsb5ge', 'cRw85pAL343fGoyedtTtZww4Roy5c66WPg7ml493Mx7FvTzTIH1OlzZINWMl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-07 20:17:20', '2025-06-07 20:17:20'),
(127, 'NdMlrmcjGmug', 'rybencb1995@gmail.com', NULL, NULL, NULL, '$2y$10$AGfFjIEy9QT4wB.UMe4u/usPKjBHlrITrvO3hWBry/lqx8VVzVfUC', 'pAy9tRbjFVKlT7MFBMhkZXRP3cPkMLL1bMXG2qvZI9nTnLhMNJaM724HxGvS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-08 15:14:40', '2025-06-08 15:14:40'),
(128, 'yerRfKybQcvbqWG', 'breweraselin@gmail.com', NULL, NULL, NULL, '$2y$10$oG3bZqHb4vWzfqAaJpjHKexbcLA2KJOKkc.9u9fCOLoD4nFq6HMDa', 'RyswswmWqhkYrIQB2uI1YxKj6DyhNJlcrjBjdw5W5meg4SU5cbnyPMQQSfnU', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-11 13:03:01', '2025-06-11 13:03:01'),
(129, 'ORhRDZdFrSz', 'pandjelika23@gmail.com', NULL, NULL, NULL, '$2y$10$mvy.YSiWj7i9kzQySWpNseFi4WPDjoMtn9hpS.reUIwv0EuWlMwZq', 'hZ3xv95KL2bh4Y4ls3PrGEpSDpuXWTZKeLlYWMLqHkfymBBIVzqxmnV5vrT5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-11 17:44:36', '2025-06-11 17:44:36'),
(130, 'Irene Ubachukwu', 'Ireneubachukwu@gmail.com', '+447415011671', NULL, NULL, '$2y$10$u9xMQB/cVg7tPD8F/nZfGuGEp7QzMzVBSEvmyQov5xfZo8dXt07cW', 'Dg4TsGZx6LPpE6j31MgGqpChz0KcgcjrizTtuRA24gsB3ZawWEYYCxhAe238', 'cfwFc6Wop0NRseinN3XaQ7:APA91bFjn6YmUWL-BPc6y8qucd4xlCRXbz-aDqQu4ySf_qb39OLEdbS8FhbE18UJTesqLmW4hDQ4Tn3qpd9E0-HJJqMwbgRc0MgX-tmzsuuZPA6kQABjYFg', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-11 20:11:54', '2025-06-11 20:11:54'),
(131, 'mKFrugvHMG', 'lucasnannayab@gmail.com', NULL, NULL, NULL, '$2y$10$7f2qcTae1k46foazXhwNmegjpeW7IDkhEUsFvwovVmeBQH.cfEqlm', '6mlgIs7dheTH6aiqzyiwBLBZTNyGeehuINlcRFy2XAymgGF5uUAagtkt1oRi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-12 10:12:05', '2025-06-12 10:12:05'),
(132, 'oiBMTkVJs', 'kiliangreen2005@gmail.com', NULL, NULL, NULL, '$2y$10$M0h.CO3ycO4csD.n2a/yE.T1mIKEB4dyr/GEM1TkIGOAEChRVsveW', 'W2YQjaZdzyMb8BomXYEXrisHnjLw66U2nr6cNhajkyaqjJQA2dWJULfistbB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-12 10:47:01', '2025-06-12 10:47:01'),
(133, 'ClcxcviauZ', 'hortolukst85@gmail.com', NULL, NULL, NULL, '$2y$10$GpyC1Xtym9mkEywLq/FqCeJId1ZhaxIkhCXy2eXQdGxtNzdw7aOYu', 'XGUh5BOwDXmEhagNs4ntdCvXcYscceHLeIvMDVZCnRYM953Trl8DnpvQS62B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-15 17:17:01', '2025-06-15 17:17:01'),
(134, 'ZUcLbbrLPVzroXl', 'howardmilisb87@gmail.com', NULL, NULL, NULL, '$2y$10$smRH58ByMIrqHIAV519E1O1.2K7KOGOceOkDXX2q7yIIXHEKferKe', '63siM71KIV9U0cPGkEm8m75aA5wlix1OFqQVOJNlChabhDJxZhSzlIIftC4g', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-16 18:46:12', '2025-06-16 18:46:12'),
(135, 'eOdIwnQyg', 'ocodjaddf3@gmail.com', NULL, NULL, NULL, '$2y$10$1Y0hLnuLWyDqLSyRRA9Sf.Ud.2dgKEaEOlzgqI7B5IZKpVHvFdcHW', 'VStQD3sCQGie7MHZYVACQNJmxwuscxLD8RnGujLn2xtdoU6SKiXhci8jW9tX', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-21 03:11:42', '2025-06-21 03:11:42'),
(136, 'KShawna', 'jaylnnedenie96@icloud.com', '+448646966004', NULL, NULL, '$2y$10$4AZiAY6x.HT/WSSLi/tlD.IPMGVxFjRsupe4nAwoUCIOm2u92HxHi', 'Iy3S83vM1ED7Gk2cVdJWHBAu55ezLd8WB7aMiZubTSdHUv8pacMGm66AnZAq', 'cakCDQnrn0-aqiaTY1ScPm:APA91bEW_EpdHxXSXoB45HdN6oWnZJTbsCgix7Hkqg3xQVoVVBSCOCkM1WFDNSAdExBzw_iwY_b5BmmWY6fj5cOZ5SXHUPIJ0WgEpGQJJDERC5JSaxp4rXQ', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 04:07:24', '2025-06-23 04:07:24'),
(137, 'GdUifgdUxZf', 'draiksharpao@gmail.com', NULL, NULL, NULL, '$2y$10$WYakjOVj950QrGKe7.y6.encNeIz8ibWQhpQrbjr.Y6ujqEr2SMua', '7jsPo6YcXO3U9jfnwT0YuSzwOo15zfimGNUi7PGxQOu6IwkYordB0JZQz58I', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 09:30:57', '2025-06-23 09:30:57'),
(138, 'MVaCDDjvc', 'zhapegq@gmail.com', NULL, NULL, NULL, '$2y$10$ejQpr/.t.6F1cY7.T3IymeiVN3UHqAXTpoEkN1Zzh3UIe0Y/d2uWe', 'P3XYbPtwoCa8ZT1RnnD5qdRXqiJjZVsV4g3DJkLeKCzPCLSGGHlELrjONJRe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-23 13:15:26', '2025-06-23 13:15:26'),
(139, 'ZmoIwVLJPTzRl', 'cantudaksa4@gmail.com', NULL, NULL, NULL, '$2y$10$S8bDlALvVqBR/K3vD/UZvO39EFkJ1.7qhrF6JLX8PykK9pUVhOum.', 'TC5H2a7l5WadwqPYrXQo6sPfFgTSd3IRroDCxeiQ5eAEqAkDD7CSGNsMem5l', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-25 18:26:38', '2025-06-25 18:26:38'),
(140, 'mPJGAASNnbbsusT', 'apanumpe1972@yahoo.com', NULL, NULL, NULL, '$2y$10$eF5OxjC63tY5NwxJkYNsv.516oo8KtOsyLHzIHfwIXHaqSRKLoP/e', 'YAs2fT9fafQHw8crHxnsNoaQ5bX5wfA8vdrx57wdh2Gg9WoqCUDXHajERTgK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-26 07:26:26', '2025-06-26 07:26:26'),
(141, 'vkCDqIMuLaLn', 'ufamezeci541@gmail.com', NULL, NULL, NULL, '$2y$10$KVC3oz.hLeN2T1LfmaBHEuNItmlvPvIEtNEUmMecaqwt.WGTPkY0K', 'rzhcUY39BaMkzg0nDMr7hxo7saBArnuXcVPFrnIkDg2LYXrkpyliZOJKT4CX', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-27 20:00:49', '2025-06-27 20:00:49'),
(142, 'wCgDHIvVs', 'iqexekoli78@gmail.com', NULL, NULL, NULL, '$2y$10$sVsZtU08tY9oi8PY.XJ89.F1Ov.0hhedyT0WCOXFNM7F4N4GL3Ogu', 'fLxWTdm4VuNVVcv9WgE39gRjCVh4v29Be67HHqIX2E56S23MLPuuGV45orC1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-28 18:11:29', '2025-06-28 18:11:29'),
(143, 'mqaAwSJtvoohLR', 'cteilttay26@gmail.com', NULL, NULL, NULL, '$2y$10$YshREo40szOjQH4JGo/lz.hsFZbzWCEl2zvtC3Bx.5VV49MF7RXd2', 'PK2m969L4All9vxlZJeL2fhhQuENnYg7lsDv7f91Q0tEbkFWN7ewrSQ8nYoH', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-29 14:58:07', '2025-06-29 14:58:07'),
(144, 'BRITANNY', 'brittannywilliams@hotmail.com', '+12428243327', NULL, NULL, '$2y$10$xlbwLQ37lfklLuzjr9d5C.A88FBqWCYaizLFFp93xLY4GXm1VHU9e', 'lSY7jS1iyRrNWhVGfHigG8qpnr6QjFmfeNjweHhwkaPAJfGucFmHJAyX8Wdk', 'cHXxYit-i0TWrOadp6jd1r:APA91bH6FkhT-eGeqmNiwUm0vnzWP6wG_Aeic6ajyNDLsqcq6xE2hD2S7fS2Gc9chY1rEtjcjyySkPAQZ5Gq7IzOxHTwLpUkSShlzW_1Ghw1FbnbeEFIux0', NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-29 17:21:39', '2025-06-29 17:21:39'),
(145, 'OHttWybsfZM', 'lambertdanielle402843@yahoo.com', NULL, NULL, NULL, '$2y$10$xnZiFm354a/MGd2VKbIoDeRzfbP78/nMLxORNFYsAbJd/IyMTEi4e', 'xt4phkb64xUIxU3we0GV1mYvy07PKIKYlr4tcni4FK3mvQy9sUsZ9a4A4Dte', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-01 08:37:50', '2025-07-01 08:37:50');
INSERT INTO `users` (`id`, `name`, `email`, `phone_number`, `phone_verified_at`, `email_verified_at`, `password`, `api_token`, `device_token`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`, `paypal_email`, `remember_token`, `created_at`, `updated_at`) VALUES
(146, 'lmyEYHPc', 'mcdolykian@gmail.com', NULL, NULL, NULL, '$2y$10$6Ap3xHVthepj3VP1q0KWSuNKSteAQtCBZORHFza45Ulf62QAQZQOa', 'GpPqW1X4PE8FnmAV4zk4OZmyS5n8tKqDs1fIDFfXXK29qpRjA3PC1AEJvMob', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-02 00:08:14', '2025-07-02 00:08:14'),
(147, 'faQTBLTIutXjNq', 'ruiztiarnm@gmail.com', NULL, NULL, NULL, '$2y$10$TRggOT7X.ETb5.e/8XH3ROvXEAfRu207LRGX3IWYvRQELDNNRM34q', 'd6SjUA91XWx6KlBoce71bii9FGFkQnRypygeIVz5z1AsleT2OVJ3BHyyoLvO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-02 18:25:17', '2025-07-02 18:25:17'),
(148, 'WLalRaDLMrmY', 'ffloresvs1980@gmail.com', NULL, NULL, NULL, '$2y$10$8FzGpF7hCAPLwsb79SkeCuWMCijVUWncjdNazyyv7eIgCdiWuGnFa', 'Az7r2CEfXO3ccYuYSeXC7FEFRocNtipdpmIHMQK2aeVsc0aSn0ZoVjKUG6M1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-02 19:10:55', '2025-07-02 19:10:55'),
(149, 'IXBYpsXhznhIvv', 'smithlaura2001@yahoo.com', NULL, NULL, NULL, '$2y$10$COKJS1BX6mR6.O2VX5jRkuf/UZ5TPY66B.s7sPI9Ft335V6LZR/j6', 'AchlmpWuVht8OHoR622IAAi2v1Y0jfWPYp2TLfy4J55RSFV1UtQx5o9Zl66c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-03 00:40:21', '2025-07-03 00:40:21'),
(150, 'JFhxkUUOVjLIUq', 'djeispenceiv46@gmail.com', NULL, NULL, NULL, '$2y$10$Z6VGvHmOEbhxRzjbKsgR0OPV1rAwqxBWLA7a42OlRh5ypBxtyEgbm', 'Mz6ydqpcbkjQAuQ4jbzrWrUzj55L3vctX5Fb0ludi9k5AZX6hxplWTTq4Wid', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-12 16:15:32', '2025-07-12 16:15:32'),
(151, 'QRvmpMKvVqyv', 'loqoxaxev440@gmail.com', NULL, NULL, NULL, '$2y$10$.nHhkNcXwUf5MFHuxEjwBeBySRFK3Y7sHgQle4HpQCgjNM5Qba.da', 'Jikvs6x32hJCIOLtOhN89OFBvVasIZH7yw4wS2iL5Glw66pJyvlO8p2v07lG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-12 22:37:07', '2025-07-12 22:37:07'),
(152, 'VxMWmWqeGgydtNm', 'zaramayerv1984@gmail.com', NULL, NULL, NULL, '$2y$10$prSaSQRceoRyCp2x4ZyEheLpeyslvYAUnVm8WkO0uVPf1Qepjdauy', 'QNyyPQ24bL2MOvE4ngbJnbOn1bDHG5t9WQiAupgZWMEN4aLWkr6GgFrRmUzk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-14 18:14:19', '2025-07-14 18:14:19'),
(153, 'CFQYlKcuOlK', 'hogbene87@gmail.com', NULL, NULL, NULL, '$2y$10$/2waR8a19lEY2GC4HTjm.OIBSqi9gSd06Hsv7lxWL5jDF9ATy0N4q', 'wfKpUFXkukJDrJEpxcEVKvRoMhqdDKqGmBPPuEEwoVOaQNK7dEFFpmZC6ck3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-15 08:50:58', '2025-07-15 08:50:58'),
(154, 'Diana Richard', 'dianarichard1477@gmail.com', '+1+1 (347) 570-9823', NULL, NULL, '$2y$10$NN0EDjDg7EDhgDdk.rt2qe6VCDVUT9X/C2dl2/GOo0ljgq7UCYPmq', 'MW4MAqpS5bhMJfXbbMGe5if7XWUCJn2tIzkybRL6kKfABFg2B8SHkAz50Z9H', 'eIcbSthHIU8Sky2_wmG32U:APA91bEppbBNVrpiPKdqpnJOKiQ-JeFgYEfGYIcKJ-3xMjYP-EbFdQnBhKzNgNMNYJYv69ezGEyoC34HPOL7lHMsmcWKfYvyifHtatKTPB8CUzzzLC3tijI', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-16 22:18:39', '2025-07-16 22:18:39'),
(155, 'Shannon McCauley', 'shannonmccauley28@gmail.com', '+12202383827', NULL, NULL, '$2y$10$5njMw6pKS7Hw4aBAZQDl3e3PWzpfZSOY0wI32sQdDn5SSXOfsIW6K', 'EfeztVKZA2JuwCAEZBCrb4Z6LzSoOn2XfDaf51Su3V8H16Mo99BaeQkRs30w', 'dYBsHmCn10mnpOxJN4aKvI:APA91bFu46mbaFNBU9eJcnWr3ukwsDUTRULldCouFR47pEF-02xZ70vojx49HVXQSswgaUBLZuQwSSTOLjECccpcWyjjSsibmr0_ly5b6RcHwD53M7lfBu8', NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-21 12:36:31', '2025-07-21 12:36:31'),
(156, 'abCXnlZudIw', 'nikkoylrf@gmail.com', NULL, NULL, NULL, '$2y$10$tNN1ZsUefc/aUubHHZgQAedpmAQaLFhdmLz.iRDPgbbDt2NBs3WTa', '0rdR8X1ZPYwlsAn26HBu4eizbgOi7NliF2oBc0dpmZAeFRdnQx1KbojxTXl6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-21 18:44:44', '2025-07-21 18:44:44'),
(157, 'Mfuehudwj hiwjswdwidjwidji jdiwjswihdfeufhiwj ijdiwjwihdiwkdoq jiwjdwidjwifjei jwdodkwofjiehiehgiejdiw jifjeifjeifwkfijrghis kwoskowfiejifefefefe ewaofficialapp.com', 'nomin.momin+381f8@mail.ru', NULL, NULL, NULL, '$2y$10$MBnCE4HE7.8rAHAiKH0rP.hVL1TnQUPzlVEnTNQGstxQvO/lPWhNC', 'eF7VAZdM0Rm1JsPH9hJ9Xjb70i8gzq30DXYOmogickqruuADnLQTnmcK9UrG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-23 21:33:28', '2025-07-23 21:33:28'),
(158, 'QxvYzJZOvVMxVME', 'jasonshetler456802@yahoo.com', NULL, NULL, NULL, '$2y$10$Hh3FGcRRPDiJuo8cByc/bOxsV0lgjnwACwE3qNrXKeKMIivJKmJhe', 'zzi6eljmxqw1zxskI3I6hzLbbbvnpkVzV7ojlJIFGCOFbiwMU54b2sKIw8kh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-24 07:47:55', '2025-07-24 07:47:55'),
(159, 'CaWZbwkMAAYp', 'djydayapi@gmail.com', NULL, NULL, NULL, '$2y$10$zPwCNrFul3hM9TIAiX7I9.Rkx59zgWU4rRrqnjQDu85QlX5Wyk/Bu', 'kOaDZsaYIf75hM2WpDGElPMUztIHzxKLe1VnxYt09pnOOomB9sI2ZHWuX7M5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-25 05:09:02', '2025-07-25 05:09:02'),
(160, 'LWyDBwCsZpBv', 'suxedosux17@gmail.com', NULL, NULL, NULL, '$2y$10$4mCm6j3l1xnFXGf8WbAfK./iOm4bDFmXOlMWeSmGPu/Mc/cwtT85i', 'F5mMUJbT4LfKa0p7OUMF07fy5tYyHh4PAaa5sRDPfQlGSlN0aLOT4yxeCWih', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-26 07:36:07', '2025-07-26 07:36:07'),
(161, 'dcNxKyLVW', 'blisnewmano1987@gmail.com', NULL, NULL, NULL, '$2y$10$YpNjTHZved1qRitIA2IBeetPRbhyuG42Wqodym4hldT4t9NjTaoTu', 'uJySctWVgckqOd9cwjZgoiJC3Cis1Twhw52jxW9kISsmYr6sdVjpoks5HWB1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-27 08:40:13', '2025-07-27 08:40:13'),
(162, 'aWdeHfyblyc', 'grahamcurtis146671@yahoo.com', NULL, NULL, NULL, '$2y$10$POtQfFM/LD5dpRfaajNTQ.dYfX/IcEXa3iXEJ6uNorUohB6mPBvW.', 'Ca5tOXRqNqO70SbQlMP0Si6fMgntXI6PNzOru8RCxCrRZ7nu12BsWfEluYFC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-31 00:31:29', '2025-07-31 00:31:29'),
(163, 'Mfuehudwj hiwjswdwidjwidji jdiwjswihdfeufhiwj ijdiwjwihdiwkdoq jiwjdwidjwifjei jwdodkwofjiehiehgiejdiw jifjeifjeifwkfijrghis kwoskowfiejifefefefe ewaofficialapp.com', 'nomin.momin+469b1@mail.ru', NULL, NULL, NULL, '$2y$10$/EG3.FDIvhWPnjOJfcMERe7kvf66oLn/scjo5W3coYmum93BlLqa2', '05Qze21hUGUNUfjyEveQVJQCFSn9fbqoqmfIHG6Ylh8evvjAJ63LHu4DqGQe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-31 10:59:23', '2025-07-31 10:59:23'),
(164, 'paNTiQqv', 'irerewic49@gmail.com', NULL, NULL, NULL, '$2y$10$1fhu6XhdvuQs/t.Eh2gAOObfYJWAqpRReayTEamRSRf4mvdEYjTSG', '4YZSfvhfzoDKCVcp2J90WHKmeVdBMUEQ0kaUIz4rZigUcvQVFdlxo25zDW4u', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-31 15:06:15', '2025-07-31 15:06:15'),
(165, 'ADcCGtuE', 'qidosagoy775@gmail.com', NULL, NULL, NULL, '$2y$10$78F/56dk0jH7JRL8LVtzvebnQ.1NhHxL9wNdEjWCZrb2xXz1uNX4y', 'oMWd2DoXcgfXcoOcX6S3tJOQnN4G4Vix8ZlSThwNWxho1T9UUID0xs30hIMh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-01 12:13:03', '2025-08-01 12:13:03'),
(166, 'ILESRpZyFEZdur', 'heceyozino43@gmail.com', NULL, NULL, NULL, '$2y$10$VH2I1RKkuj9XtJNPBvW3HOFskXsqzJB6hPyyPFhlGcv3PK9nTvouG', '5YRRS7a3hIUSPsDMnhVGNrGRDEZUYF2x3ZWYpESqSpoMVVazEcagkl4oycnQ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-01 14:47:05', '2025-08-01 14:47:05'),
(167, 'RFfeBGokWv', 'adamhaglund218060@yahoo.com', NULL, NULL, NULL, '$2y$10$8.g64ZtKwUYzN5jb4MycIulj44a/UTCeRqEp9Cd3J4okk/PQIRK3q', 'a837vkij3Lg1bX6RlTfgIB2Se12bErjU0K3EwpVcXfS1K3JTYTMByu5uUxCf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-01 19:13:47', '2025-08-01 19:13:47'),
(168, 'wbCboNzMjOUEWc', 'pixecibi204@gmail.com', NULL, NULL, NULL, '$2y$10$otCQHr.0avQ3EPSE3AANaeeEPtkHZRauM9dWx2VP45IcqvO6Li6qK', 'Y7nJ0IvUwt8u6NB0dTltQL0BFVDEBzaHxDr0yLL81qFPKfSqozxshHbuHQnG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-01 19:23:09', '2025-08-01 19:23:09'),
(169, 'bPBXkmfZKJiMUTO', 'wurimaqunag974@gmail.com', NULL, NULL, NULL, '$2y$10$CuVJvVdYl6IEvS0UceMr2eLN7H9lpMpWcnWFQZNyegiMyOKhB3zy.', 'TVJcziDdDLbIqeKGkKCtJ1rfD8XGNTbEAgwgOrxsYIa8Ae9fkzcyw8mR5mTY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-01 19:57:47', '2025-08-01 19:57:47'),
(170, 'rJyludNLNM', 'acicona973@gmail.com', NULL, NULL, NULL, '$2y$10$uW2V72xc9KssDeMe4Mg3yuIZNEj9A49zz0RtpNPcRsF4SAxtrtRDW', 'cL5l6NKyDGfeRvx5jt9riKF0XZ2mju1CDdBCGOiRzYUlTiS5Q5jV1lDOFyj4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-02 23:37:14', '2025-08-02 23:37:14'),
(171, 'PxmOmtcY', 'ujatasok902@gmail.com', NULL, NULL, NULL, '$2y$10$GpS.oiLMPTpT1POmTAYLt.FWZN3pgH0OuXz1ml/x9jpzLx5zcqK6i', '5GlyUtaZjPrKHuYl0sl17vhA6VwuNyP3ZLufQ56gmaujF537BFMZSFyceKvS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-04 03:24:20', '2025-08-04 03:24:20'),
(172, 'qBXLkeVpHv', 'ihidigomanab87@gmail.com', NULL, NULL, NULL, '$2y$10$iQllE/wv/iQ7bJPopkwJkusDSI8xuN9N6tgLsW/BYhgaKFiG/6c2G', '5ZINaFuU7izY4wcKi3mVdP4JSR1lpsX0G31YY4oJiNUc23NOsydkL158Gvd1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-05 09:17:17', '2025-08-05 09:17:17'),
(173, 'Madhan', 'madhana.rao@brillio.com', '+91', NULL, NULL, '$2y$10$yvOe9d.SsTlGQgJDvGP.YOQHlu/sHPTWkRpDY61q6DRex3UkJlAmi', 'bq1ESm96tMfc8ZLRJbrrg6yjB8EUsxMslyzRshvA35n1gssgCuPoTNL6hw03', 'e_zE30pARfSpDSt1Aceutu:APA91bHdvBpGo-wwIyZJ2pBXCJQ6PDev3A6xrz28CWJ1lNlgF4QUFlcqV2jwrt-FCmrvP0TgzoioFO217wA1kBOk9TwxewIfRlXKltuGEC80lihVEpGtm6g', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-06 15:34:49', '2025-08-06 15:34:49'),
(174, 'ETAwEltiSxY', 'morsevayhan@gmail.com', NULL, NULL, NULL, '$2y$10$RptPvFPGSWWChbLlC.GyCuW7ClclI.nQQ4e59ZQ5OGQsgxjDD5V9K', 'f7wfwWaEhMUze0q1zanrhTbL48SWnSTLDhrBpb18lFGZ43C7NyIqghJWtRPg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-07 09:19:34', '2025-08-07 09:19:34'),
(175, 'cFbCpwWZ', 'wojupeya738@gmail.com', NULL, NULL, NULL, '$2y$10$NhcgG9Hrm2euo4M2WU5f.u2fkRCre0qvtH9T.5qaCibQYnNvZJdzW', 'gsbVgZbo0dg73hAnwiDLF553F3TxqRLsLlfX2x6F6DBgWgAULnxXyo1m0GFp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-07 19:09:45', '2025-08-07 19:09:45'),
(176, 'eViiHKdWOOOx', 'vutebizuw427@gmail.com', NULL, NULL, NULL, '$2y$10$Evns12.MgywF.3w9zrPJsuxASxt3dLyUvV0SRbqekoFK0xWi9Yxbu', 'cK0icj00brXKbJdQqrQrad93yqM5XkEnyH0EwK17MsXeKLLuGfEel8LMuU6e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-08 08:08:33', '2025-08-08 08:08:33'),
(177, 'iCnWYEStLWSpe', 'davislindsay14579@yahoo.com', NULL, NULL, NULL, '$2y$10$Cx0Lc6p2PDt2v8/ld33Br.LxsAeTpvKrdBPSbLpU8902jKHmNlUD.', 'zYiLXMkRe8631PlrgDuEIUilYGGtg2KjMOKecmYJeP72KfItk4mErcl8Ie1J', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-10 04:53:40', '2025-08-10 04:53:40'),
(178, 'AUWgHZFVt', 'maxinatuci64@gmail.com', NULL, NULL, NULL, '$2y$10$qPhhgYjZHCkIpJKegyZwp.MUGBimAkzExG4xguDfOCJY6KlCmHsq.', 'xPsqHKgQnXfp21OGdIChHFz4gA43mV2r2Q8AQPvbT6x72bpEn6UieO6YuUV0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-11 13:11:58', '2025-08-11 13:11:58'),
(179, 'sgKeNGak', 'skylerharris971511@yahoo.com', NULL, NULL, NULL, '$2y$10$NKrCmiCKGmi44L4Gtg0.VO7iQz2udv0pKEsDZkCby77zkZakFgUDC', 'x3FoYmVqPNOvrIvsDj4r1fkAZmgU1z3rLom3R8XsbAMoDH00RBOKaLGSGQqf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-13 10:23:56', '2025-08-13 10:23:56'),
(180, 'rDZaayeAFfLAeL', 'enafenuvari598@gmail.com', NULL, NULL, NULL, '$2y$10$wjvrv3SsymX43akJzQC4S.mVer.i2tx8p7YEXpMRqQl6rdTYGWb3y', '1zKNdHd6vmVm7wj8dw6aT8TUIbA4ECF6I4kiaGjT2HZjxstWTohZIrThowuh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-14 23:54:48', '2025-08-14 23:54:48'),
(181, 'TsvRBmYQpSKlU', 'oloxusil203@gmail.com', NULL, NULL, NULL, '$2y$10$JxCqEsYN.X9vfuV5cLgHVu2c3FYgEy9x29PVnKH1rBnEmbiOvIxFi', 'qkzRXELTKd78IYzbZ745QfpScV71becVuvptzN2P7j5SVFFCj6kLk8x9r4qa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-15 08:13:55', '2025-08-15 08:13:55'),
(182, 'qmqyWuAEItcMnNF', 'azefisasowo953@gmail.com', NULL, NULL, NULL, '$2y$10$COu27LUiJE0sZmuLU0BBMuc.pkEFn0htIH/Pf178PNzR8v453xXqm', 'JBSH7vrp1l0jLLTUWLqxpHVMiZ2AczBYJxYw3Re1D6w1bk2RC030j3KxIsBO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-16 14:43:40', '2025-08-16 14:43:40'),
(183, 'nPgwmmLmHyJwYPa', 'ihigakuhe54@gmail.com', NULL, NULL, NULL, '$2y$10$wJ15f/Da.49GlMqrhyi76OhvUFagk7OhsIBSDjcWtgiW0o0/FobSS', 'SpK6W3axAo2wfkPuhVmg2M2Uuq1N76KNd8brCP83WN7bcjIIffOBgQ3ObBm0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-16 23:06:35', '2025-08-16 23:06:35'),
(184, '* * * Unlock Free Spins Today: https://86car.net/index.php?ji12n9 * * * hs=a7d6ddc40be73f6e8a45d73562245e02* ххх*', 'paouqua@mailbox.in.ua', NULL, NULL, NULL, '$2y$10$SgAAUqoxAc.72500LUSyauUTmkbBPJFl7qjT7UwsxYu.3YsyUe1Qa', 'JUJIO7toOJ7ItDnxdF3RSdO7jKjYmyE4naKC4h0qYyTf95qkr6MVteUVfvpY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-17 03:19:08', '2025-08-17 03:19:08'),
(185, 'kirdmhauUqC', 'ecahaqog33@gmail.com', NULL, NULL, NULL, '$2y$10$8622EifAuxHaGWPtMZms7uNnt1syMw2zPB4ULyLfBQS4hI/rB/XN.', 'SdOhpKSUOVf8FEjdvxK8pDaFBSkQc35s0DFjcRUwFgZYT3hlSsmMetmK3XcY', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-18 07:28:49', '2025-08-18 07:28:49'),
(186, 'Latonya Ceaser', 'ceaserlatonya51@gmail.com', '+449016918075', NULL, NULL, '$2y$10$p8njsg0FFtlhbfGB4zZrsu45GASiG5AcKrhO6mGmomI44XVVKxnt2', 'tBPZupwY51OMhrpNkbg1TuiPh74vN03PaxxIV0soJC4n7yj3Kam6MYCZjS7K', 'ff9tMeOPuU-btBn78ybAO9:APA91bFm09vKtLRmD6V6v1MI38rtuCXWdOiedGri5NzMsENpOQYX5pQWf_x71alzAlkK4RWu3I2fG-lBqtux5Dtfqi9F0L-XeERvbrMjKjdcDZOyPOa31z8', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-18 14:18:49', '2025-08-18 14:18:49'),
(187, 'TdEXnuqfjxqGORp', 'yuzimunu777@gmail.com', NULL, NULL, NULL, '$2y$10$2WRb41AT.5xR9qL/W19JY.skRN.XSFXrX/cKfKm2NV78eoibGJLCC', 'GqUXP5UwAu8pOWM2JcgqyyHeO5Q8OSfdeG3LNeObBa8Gan7fOmjywit3HdJy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-22 06:41:26', '2025-08-22 06:41:26'),
(188, 'CdBrwRYk', 'iwubehexu351@gmail.com', NULL, NULL, NULL, '$2y$10$6s6weUU8c45e44bVWIeVyeaMWlMPnNgXXjccYSFCCYTZzwHLo1O/a', 'uRPiacghZR4ruh0xrCIiheHdsfTPysCYYebu6JJsjrqwWI9O0xBo5Pf0lDXQ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-23 07:19:48', '2025-08-23 07:19:48'),
(189, 'oWfKivoftMFN', 'rufowowa00@gmail.com', NULL, NULL, NULL, '$2y$10$Z/YQ/xdpyU1auj9r.LzQn.qA9h39vzlu3hwQrP8k9JO3elVwdxTyW', 'w8oNWZALl1V3yxjuJg1VY5seYgBhp4NAX1PUh1Ky8QZUpPfca692p3XV1Dby', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-23 18:59:16', '2025-08-23 18:59:16'),
(190, 'SwOUWYLAxsDCOtm', 'amexaliquzix40@gmail.com', NULL, NULL, NULL, '$2y$10$WWFaNIuw2geSSF9vvUWJ7u.ctxzrnpN/kGszTiaFbBHIIy6DBDFwO', 'o7SvJ9bYw6LHbVgcrHhKQmPnD1WlqRv3RquJ123TNFnYMZiTT52nQ1NDCDhP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-25 06:35:57', '2025-08-25 06:35:57'),
(191, 'TIfpSAuVrck', 'esuzaxi568@gmail.com', NULL, NULL, NULL, '$2y$10$shux5dywaCL8/3.tfAdbR.3QSjqluKJVnO2W2I3byFv8WkB5P7QCK', 'ufgQCTeP8CdeVJTatAf6ctPbOkD3ofxdAO5sKjYuznxPrjgqwdf5797ucSga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-25 19:23:57', '2025-08-25 19:23:57'),
(192, 'mohammd adm Mohammed', 'mohmmadffhhjj @gmail.com', '+2490995054627', NULL, NULL, '$2y$10$oH2/XRNopsmt8fVYEfq9su/ynaLSs33rz6gKv8ceCo1E.j1DR6Qem', 'OCCtGqCACz7XwSUINSjdrH3ZeHHKfFT7pWSbINtFT5SO6kPaewiUyuwabrK2', 'cTM8MaZPRhCNRGXG8hTLpF:APA91bFkEakGgaIBqXG_nqsQuRGXfOEHA-IBZrChi04AGIZNlGE2L7QQA3rAmVX8yaKmDdp1gmXkViZWlYQXprI3YhMvhp4twXeI98yL-zJ6zOQ4_k8gzcI', NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-25 22:14:25', '2025-08-25 22:14:25'),
(193, 'pchSqejpYSHl', 'titovet172@gmail.com', NULL, NULL, NULL, '$2y$10$ZJ4uCDxq8eRghg5qBkgWku3LbtMdc.2SAEAbT6L8IbpXZBJz7W3k2', 'ykJYDEPRSBKknwJgR14e0Sd0WCJf0FRxx15KI0HKIwZ43r3tKtaEqaTeDqWQ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-08-28 20:05:45', '2025-08-28 20:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` double(16,2) NOT NULL DEFAULT '0.00',
  `currency` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `name`, `balance`, `currency`, `user_id`, `enabled`, `created_at`, `updated_at`) VALUES
('01194a4f-f302-47af-80b2-ceb2075d36dc', 'My USD Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 1, 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('02194a4f-f302-47af-80b2-ceb2075d36dc', 'Home USD Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 2, 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('03194a4f-f302-47af-80b2-ceb2075d36dc', 'Work USD Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 3, 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('04194a4f-f302-47af-80b2-ceb2075d36dc', 'Dummy USD Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 4, 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('05194a4f-f302-47af-80b2-ceb2075d36dc', 'Old USD Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 5, 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('06194a4f-f302-47af-80b2-ceb2075d36dc', 'New USD Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 6, 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('07194a4f-f302-47af-80b2-ceb2075d36dc', 'USD Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 7, 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('1246aa37-8a7d-4b48-be75-44dabec00012', 'Mine', 0.00, '{\"id\":7,\"name\":\"Pound Sterling\",\"symbol\":\"\\u00a3\",\"code\":\"GBP\",\"decimal_digits\":2,\"rounding\":2}', 34, 1, '2025-02-22 00:34:04', '2025-02-22 00:34:04'),
('84b404e2-b005-4c35-a438-7d3699416f42', 'wallet', 0.00, '{\"id\":7,\"name\":\"Pound Sterling\",\"symbol\":\"\\u00a3\",\"code\":\"GBP\",\"decimal_digits\":2,\"rounding\":2}', 34, 1, '2025-03-27 16:03:29', '2025-03-27 16:03:29'),
('8d194a4f-f302-47af-80b2-ceb2075d36dc', 'Dollar Wallet', 200.00, '{\"id\":1,\"name\":\"US Dollar\",\"symbol\":\"$\",\"code\":\"USD\",\"decimal_digits\":2,\"rounding\":0}', 8, 1, '2021-01-07 12:17:34', '2021-01-07 12:17:34'),
('8f285f83-1b2a-48b3-bd65-f01033501a41', 'wallet 2', 0.00, '{\"id\":7,\"name\":\"Pound Sterling\",\"symbol\":\"\\u00a3\",\"code\":\"GBP\",\"decimal_digits\":2,\"rounding\":2}', 34, 1, '2025-02-22 01:15:53', '2025-02-22 01:15:53'),
('99b91d16-e693-4a5a-9b7c-0a75575b5dd0', 'test', 0.00, '{\"id\":7,\"name\":\"Pound Sterling\",\"symbol\":\"\\u00a3\",\"code\":\"GBP\",\"decimal_digits\":2,\"rounding\":2}', 56, 1, '2025-04-04 04:35:14', '2025-04-04 04:35:14'),
('da6498fb-04f6-4daa-a754-14cae5e70f10', 'PayPal', 0.00, '{\"id\":7,\"name\":\"Pound Sterling\",\"symbol\":\"\\u00a3\",\"code\":\"GBP\",\"decimal_digits\":2,\"rounding\":2}', 31, 1, '2025-02-22 00:34:07', '2025-02-22 00:34:07');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
CREATE TABLE `wallet_transactions` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` enum('credit','debit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `wallet_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `amount`, `description`, `action`, `wallet_id`, `user_id`, `created_at`, `updated_at`) VALUES
('01194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '01194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('02194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '02194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('03194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '03194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('04194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '04194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('05194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '05194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('06194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '06194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('07194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '07194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34'),
('8d194a4f-f302-47af-80b2-ceb2075d36dc', 200.00, 'First Transaction', 'credit', '8d194a4f-f302-47af-80b2-ceb2075d36dc', 1, '2021-08-07 12:17:34', '2021-08-07 12:17:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `app_settings_key_index` (`key`);

--
-- Indexes for table `availability_hours`
--
ALTER TABLE `availability_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `availability_hours_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `awards_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_booking_status_id_foreign` (`booking_status_id`),
  ADD KEY `bookings_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `booking_statuses`
--
ALTER TABLE `booking_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_fields`
--
ALTER TABLE `custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_field_values_custom_field_id_foreign` (`custom_field_id`);

--
-- Indexes for table `custom_pages`
--
ALTER TABLE `custom_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discountables`
--
ALTER TABLE `discountables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discountables_coupon_id_foreign` (`coupon_id`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `earnings_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiences_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `e_providers`
--
ALTER TABLE `e_providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_providers_e_provider_type_id_foreign` (`e_provider_type_id`);

--
-- Indexes for table `e_provider_addresses`
--
ALTER TABLE `e_provider_addresses`
  ADD PRIMARY KEY (`e_provider_id`,`address_id`),
  ADD KEY `e_provider_addresses_address_id_foreign` (`address_id`);

--
-- Indexes for table `e_provider_locations`
--
ALTER TABLE `e_provider_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_provider_locations_e_provider_id_foreign` (`e_provider_id`),
  ADD KEY `e_provider_locations_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `e_provider_payouts`
--
ALTER TABLE `e_provider_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_provider_payouts_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `e_provider_subscriptions`
--
ALTER TABLE `e_provider_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_provider_subscriptions_payment_id_foreign` (`payment_id`),
  ADD KEY `e_provider_subscriptions_e_provider_id_foreign` (`e_provider_id`),
  ADD KEY `e_provider_subscriptions_subscription_package_id_foreign` (`subscription_package_id`);

--
-- Indexes for table `e_provider_taxes`
--
ALTER TABLE `e_provider_taxes`
  ADD PRIMARY KEY (`e_provider_id`,`tax_id`),
  ADD KEY `e_provider_taxes_tax_id_foreign` (`tax_id`);

--
-- Indexes for table `e_provider_types`
--
ALTER TABLE `e_provider_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `e_provider_users`
--
ALTER TABLE `e_provider_users`
  ADD PRIMARY KEY (`user_id`,`e_provider_id`),
  ADD KEY `e_provider_users_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `e_services`
--
ALTER TABLE `e_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_services_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `e_service_categories`
--
ALTER TABLE `e_service_categories`
  ADD PRIMARY KEY (`e_service_id`,`category_id`),
  ADD KEY `e_service_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `e_service_reviews`
--
ALTER TABLE `e_service_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_service_reviews_user_id_foreign` (`user_id`),
  ADD KEY `e_service_reviews_e_service_id_foreign` (`e_service_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `faqs_faq_category_id_foreign` (`faq_category_id`);

--
-- Indexes for table `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_e_service_id_foreign` (`e_service_id`),
  ADD KEY `favorites_user_id_foreign` (`user_id`);

--
-- Indexes for table `favorite_options`
--
ALTER TABLE `favorite_options`
  ADD PRIMARY KEY (`option_id`,`favorite_id`),
  ADD KEY `favorite_options_favorite_id_foreign` (`favorite_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_e_service_id_foreign` (`e_service_id`),
  ADD KEY `options_option_group_id_foreign` (`option_group_id`);

--
-- Indexes for table `option_groups`
--
ALTER TABLE `option_groups`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_foreign` (`user_id`),
  ADD KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  ADD KEY `payments_payment_status_id_foreign` (`payment_status_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
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
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slides_e_service_id_foreign` (`e_service_id`),
  ADD KEY `slides_e_provider_id_foreign` (`e_provider_id`);

--
-- Indexes for table `subscription_packages`
--
ALTER TABLE `subscription_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_number_unique` (`phone_number`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallets_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_wallet_id_foreign` (`wallet_id`),
  ADD KEY `wallet_transactions_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `availability_hours`
--
ALTER TABLE `availability_hours`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `booking_statuses`
--
ALTER TABLE `booking_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `custom_fields`
--
ALTER TABLE `custom_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `custom_pages`
--
ALTER TABLE `custom_pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `discountables`
--
ALTER TABLE `discountables`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `e_providers`
--
ALTER TABLE `e_providers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `e_provider_locations`
--
ALTER TABLE `e_provider_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `e_provider_payouts`
--
ALTER TABLE `e_provider_payouts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `e_provider_types`
--
ALTER TABLE `e_provider_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `e_services`
--
ALTER TABLE `e_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `e_service_reviews`
--
ALTER TABLE `e_service_reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `option_groups`
--
ALTER TABLE `option_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment_statuses`
--
ALTER TABLE `payment_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `availability_hours`
--
ALTER TABLE `availability_hours`
  ADD CONSTRAINT `availability_hours_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_booking_status_id_foreign` FOREIGN KEY (`booking_status_id`) REFERENCES `booking_statuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `bookings_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `custom_field_values`
--
ALTER TABLE `custom_field_values`
  ADD CONSTRAINT `custom_field_values_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `discountables`
--
ALTER TABLE `discountables`
  ADD CONSTRAINT `discountables_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `earnings`
--
ALTER TABLE `earnings`
  ADD CONSTRAINT `earnings_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_providers`
--
ALTER TABLE `e_providers`
  ADD CONSTRAINT `e_providers_e_provider_type_id_foreign` FOREIGN KEY (`e_provider_type_id`) REFERENCES `e_provider_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_provider_addresses`
--
ALTER TABLE `e_provider_addresses`
  ADD CONSTRAINT `e_provider_addresses_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_provider_addresses_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_provider_locations`
--
ALTER TABLE `e_provider_locations`
  ADD CONSTRAINT `e_provider_locations_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_provider_locations_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_provider_payouts`
--
ALTER TABLE `e_provider_payouts`
  ADD CONSTRAINT `e_provider_payouts_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_provider_subscriptions`
--
ALTER TABLE `e_provider_subscriptions`
  ADD CONSTRAINT `e_provider_subscriptions_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_provider_subscriptions_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_provider_subscriptions_subscription_package_id_foreign` FOREIGN KEY (`subscription_package_id`) REFERENCES `subscription_packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_provider_taxes`
--
ALTER TABLE `e_provider_taxes`
  ADD CONSTRAINT `e_provider_taxes_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_provider_taxes_tax_id_foreign` FOREIGN KEY (`tax_id`) REFERENCES `taxes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_provider_users`
--
ALTER TABLE `e_provider_users`
  ADD CONSTRAINT `e_provider_users_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_provider_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_services`
--
ALTER TABLE `e_services`
  ADD CONSTRAINT `e_services_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_service_categories`
--
ALTER TABLE `e_service_categories`
  ADD CONSTRAINT `e_service_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_service_categories_e_service_id_foreign` FOREIGN KEY (`e_service_id`) REFERENCES `e_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `e_service_reviews`
--
ALTER TABLE `e_service_reviews`
  ADD CONSTRAINT `e_service_reviews_e_service_id_foreign` FOREIGN KEY (`e_service_id`) REFERENCES `e_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `e_service_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_faq_category_id_foreign` FOREIGN KEY (`faq_category_id`) REFERENCES `faq_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_e_service_id_foreign` FOREIGN KEY (`e_service_id`) REFERENCES `e_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorite_options`
--
ALTER TABLE `favorite_options`
  ADD CONSTRAINT `favorite_options_favorite_id_foreign` FOREIGN KEY (`favorite_id`) REFERENCES `favorites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorite_options_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_e_service_id_foreign` FOREIGN KEY (`e_service_id`) REFERENCES `e_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `options_option_group_id_foreign` FOREIGN KEY (`option_group_id`) REFERENCES `option_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_payment_status_id_foreign` FOREIGN KEY (`payment_status_id`) REFERENCES `payment_statuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `slides`
--
ALTER TABLE `slides`
  ADD CONSTRAINT `slides_e_provider_id_foreign` FOREIGN KEY (`e_provider_id`) REFERENCES `e_providers` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `slides_e_service_id_foreign` FOREIGN KEY (`e_service_id`) REFERENCES `e_services` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wallet_transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
