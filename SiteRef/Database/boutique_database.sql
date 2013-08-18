-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2013 at 04:18 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `boutique_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `boutique_advertisements`
--

CREATE TABLE IF NOT EXISTS `boutique_advertisements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `address_line_one` text NOT NULL,
  `address_line_two` text,
  `address_line_three` text,
  `mobile_no` varchar(20) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `selected_position` enum('top','right','left') NOT NULL,
  `selected_period` int(4) NOT NULL,
  `selected_period_unit` enum('day','week','month','year') NOT NULL,
  `run_from` date NOT NULL,
  `image_file_path` varchar(100) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `mode_of_payment` enum('cash','cheque','paypal','other') NOT NULL,
  `payment_cheque_id` int(11) DEFAULT NULL,
  `paypal_transaction_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) unsigned DEFAULT '0',
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `boutique_advertisements`
--

INSERT INTO `boutique_advertisements` (`id`, `customer_name`, `address_line_one`, `address_line_two`, `address_line_three`, `mobile_no`, `email_address`, `selected_position`, `selected_period`, `selected_period_unit`, `run_from`, `image_file_path`, `url`, `description`, `amount`, `mode_of_payment`, `payment_cheque_id`, `paypal_transaction_id`, `is_active`, `created_at`, `modified_at`) VALUES
(1, ' a', 'zdbxasohdfsjfjds', 'klnsdfkjadsjfkdjfsgj', 'sklnfdjdgfsjdgjdjg', '  12345678', 'sdasfsd@yahoo.com', 'top', 7, 'day', '2012-10-01', 'images.jpg', '  http://localhost/Butique-shop/index.php/advertisements/advertisement_add', '', 10000.00, 'cheque', 123456, 0, 0, '2012-09-29 01:00:00', NULL),
(2, 'Rahmat Ullah', 'Village: Paragaon, P/S: Joydevpur, P/O: Kalni', 'Shivbari', 'Gazipur', '0191258963', 'rahmat@gmail.com', 'left', 2, 'day', '2012-11-05', '', 'http://www.someurl.com', 'Test Details', 15000.00, 'cash', 0, 0, 1, '2012-11-05 07:23:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_advertisement_images`
--

CREATE TABLE IF NOT EXISTS `boutique_advertisement_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advertisement_id` int(11) NOT NULL,
  `dimension` varchar(25) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `uploaded_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_boutique_advertisement_images` (`advertisement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `boutique_advertisement_images`
--

INSERT INTO `boutique_advertisement_images` (`id`, `advertisement_id`, `dimension`, `file_name`, `uploaded_at`) VALUES
(1, 2, '341X148', '509803ff36019.jpg', '2012-11-05 07:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `boutique_categories`
--

CREATE TABLE IF NOT EXISTS `boutique_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `product_section_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_boutique_category_sections` (`product_section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `boutique_categories`
--

INSERT INTO `boutique_categories` (`id`, `name`, `product_section_id`, `created_at`) VALUES
(1, 'Bags', 2, '2012-09-28'),
(3, 'Shoe', 1, '2012-09-30'),
(4, 'Skirts & Tops', 3, '2013-01-01'),
(5, 'Sunglasses', 2, '2013-01-01'),
(6, 'School Bags', 3, '2013-01-15'),
(7, 'Mini Skirts', 3, '2013-01-15'),
(8, 'Suits', 1, '2013-01-15'),
(9, 'Blazers', 1, '2013-01-15'),
(10, 'Shoe', 1, '2013-01-15'),
(11, 'School Accessories', 3, '2013-01-23');

-- --------------------------------------------------------

--
-- Table structure for table `boutique_country_codes`
--

CREATE TABLE IF NOT EXISTS `boutique_country_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(60) NOT NULL,
  `code` int(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

--
-- Dumping data for table `boutique_country_codes`
--

INSERT INTO `boutique_country_codes` (`id`, `country`, `code`, `created_at`, `modified_at`) VALUES
(1, 'Bangladesh', 880, '2012-12-22 08:19:16', NULL),
(2, 'Singapore', 65, '2012-12-22 08:21:18', NULL),
(3, 'Afghanistan', 93, '2012-12-22 08:37:49', NULL),
(4, 'Burma (Myanmar)', 95, '2012-12-22 08:40:17', NULL),
(5, 'Canada', 1, '2012-12-22 08:41:57', NULL),
(6, 'China', 86, '2012-12-22 08:43:09', NULL),
(7, 'India', 91, '2012-12-22 08:44:39', NULL),
(8, 'Indonesia', 62, '2012-12-22 08:45:13', NULL),
(9, 'Italy', 39, '2012-12-22 08:46:08', NULL),
(10, 'Japan', 81, '2012-12-22 08:46:36', NULL),
(11, 'Kenya', 254, '2012-12-22 08:47:24', NULL),
(12, 'North Korea', 850, '2012-12-22 08:48:38', NULL),
(13, 'Pakistan', 92, '2012-12-22 08:49:10', NULL),
(14, 'South Korea', 82, '2012-12-22 08:50:03', NULL),
(15, 'Sri Lanka', 94, '2012-12-22 08:50:28', NULL),
(16, 'Sweden', 46, '2012-12-22 08:51:11', NULL),
(17, 'Switzerland', 41, '2012-12-22 08:51:40', NULL),
(18, 'Libya', 218, '2012-12-22 08:52:07', NULL),
(19, 'Turkey', 90, '2012-12-22 08:52:50', NULL),
(20, 'Kuwait', 965, '2012-12-22 08:54:11', NULL),
(21, 'United States', 1, '2012-12-22 08:54:44', NULL),
(22, 'United Arab Emirates', 971, '2012-12-22 08:55:32', NULL),
(23, 'Taiwan', 886, '2012-12-22 08:56:18', NULL),
(24, 'Sudan', 249, '2012-12-22 08:57:05', NULL),
(25, 'Spain', 34, '2012-12-22 08:57:36', NULL),
(26, 'South Africa', 27, '2012-12-22 08:58:05', NULL),
(27, 'Saudi Arabia', 966, '2012-12-22 08:58:55', NULL),
(28, 'Russia', 7, '2012-12-22 08:59:31', NULL),
(29, 'Romania', 40, '2012-12-22 08:59:56', NULL),
(30, 'Qatar', 974, '2012-12-22 09:00:25', NULL),
(31, 'Poland', 48, '2012-12-22 09:00:49', NULL),
(32, 'Philippines', 63, '2012-12-22 09:01:15', NULL),
(33, 'Peru', 51, '2012-12-22 09:01:40', NULL),
(34, 'Paraguay', 595, '2012-12-22 09:02:06', NULL),
(35, 'Oman', 968, '2012-12-22 09:02:46', NULL),
(36, 'Norway', 47, '2012-12-22 09:03:17', NULL),
(37, 'New Zealand', 64, '2012-12-22 09:04:14', NULL),
(38, 'Nepal', 977, '2012-12-22 09:04:54', NULL),
(39, 'Morocco', 212, '2012-12-22 09:05:26', NULL),
(40, 'Mexico', 52, '2012-12-22 09:05:58', NULL),
(41, 'Maldives', 960, '2012-12-22 09:06:38', NULL),
(42, 'Malaysia', 60, '2012-12-22 09:07:07', NULL),
(43, 'Jamaica', 1876, '2012-12-22 09:12:18', NULL),
(44, 'Israel', 972, '2012-12-22 09:14:35', NULL),
(45, 'Ireland', 353, '2012-12-22 09:15:05', NULL),
(46, 'Iraq', 964, '2012-12-22 09:15:39', NULL),
(47, 'Iran', 98, '2012-12-22 09:16:05', NULL),
(48, 'Hungary', 36, '2012-12-22 09:16:55', NULL),
(49, 'Hong Kong', 852, '2012-12-22 09:17:19', NULL),
(50, 'Ghana', 233, '2012-12-22 09:18:15', NULL),
(51, 'Germany', 49, '2012-12-22 09:18:47', NULL),
(52, 'France', 33, '2012-12-22 09:19:14', NULL),
(53, 'Finland', 358, '2012-12-22 09:19:42', NULL),
(54, 'Egypt', 20, '2012-12-22 09:20:21', NULL),
(55, 'Ecuador', 593, '2012-12-22 09:20:47', NULL),
(56, 'Denmark', 45, '2012-12-22 09:21:15', NULL),
(57, 'Colombia', 57, '2012-12-22 09:21:55', NULL),
(58, 'Cameroon', 237, '2012-12-22 09:22:30', NULL),
(59, 'Cambodia', 855, '2012-12-22 09:22:52', NULL),
(60, 'Bulgaria', 359, '2012-12-22 09:23:28', NULL),
(61, 'Azerbaijan', 994, '2012-12-22 09:24:17', NULL),
(62, 'Austria', 43, '2012-12-22 09:24:38', NULL),
(63, 'Australia', 61, '2012-12-22 09:25:03', NULL),
(64, 'Argentina', 54, '2012-12-22 09:25:30', NULL),
(65, 'Antarctica', 672, '2012-12-22 09:26:03', NULL),
(66, 'Algeria', 213, '2012-12-22 09:27:14', NULL),
(67, 'Aruba', 297, '2012-12-22 09:28:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_general_payments`
--

CREATE TABLE IF NOT EXISTS `boutique_general_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_stock_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `mode_of_payment` enum('cash','cheque','paypal','other') NOT NULL,
  `payment_cheque_id` int(11) DEFAULT NULL,
  `paypal_transaction_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`product_stock_id`),
  KEY `boutique_general_payments_FKIndex1` (`payment_cheque_id`),
  KEY `boutique_general_payments_FKIndex2` (`product_stock_id`),
  KEY `boutique_general_payments_FKIndex3` (`paypal_transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `boutique_general_payments`
--


-- --------------------------------------------------------

--
-- Table structure for table `boutique_messages`
--

CREATE TABLE IF NOT EXISTS `boutique_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_name` varchar(60) NOT NULL,
  `message` text NOT NULL,
  `message_media` enum('email','sms','both') NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `boutique_messages`
--

INSERT INTO `boutique_messages` (`id`, `action_name`, `message`, `message_media`, `created_at`, `modified_at`) VALUES
(1, 'START GREETING', 'Dear NAME,', 'both', '2012-12-24 08:07:50', '2012-12-24 08:19:09'),
(2, 'ACCOUNT ACTIVATION', 'Welcome to COMPANY. Checkout your mobile phone to get the SMS from us with a 4-digit activation code. Then go to the following link and submit the code to complete registration.', 'email', '2012-12-24 08:25:35', '2012-12-25 06:26:48'),
(3, 'SHIPMENT STATUS', 'Your shipment of the consignment NUMBER has been sent through COURIER on DATE.', 'email', '2012-12-24 08:27:00', NULL),
(5, 'ORDER CONFIRMATION', 'You have successfully placed an order in COMPANY. Check email for details. Your order track id is NUMBER.', 'both', '2012-12-24 08:36:38', NULL),
(7, 'SHIPMENT CLOSED', 'Your shipment of the consignment NUMBER has been delivered on DATE.', 'both', '2012-12-24 08:45:54', NULL),
(8, 'END GREETING', '--Boutique', 'both', '2012-12-24 08:47:46', NULL),
(9, 'ORDER INFO TO ADMIN', 'The following order is placed by the user NAME. Please take all the neccessary steps.', 'email', '2012-12-24 08:50:35', NULL),
(12, 'SMS 2FA', 'Please check your mailbox to get the activation link. Click the link and type 2FA in the input box to complete registration.', 'sms', '2012-12-25 06:33:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_other_payments`
--

CREATE TABLE IF NOT EXISTS `boutique_other_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `bill_no` bigint(16) NOT NULL,
  `payment_date` date NOT NULL,
  `mode_of_payment` enum('cash','cheque','paypal','other') NOT NULL,
  `payment_cheque_id` int(11) DEFAULT NULL,
  `paypal_transaction_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boutique_other_payments_FKIndex1` (`paypal_transaction_id`),
  KEY `boutique_other_payments_FKIndex2` (`payment_cheque_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `boutique_other_payments`
--

INSERT INTO `boutique_other_payments` (`id`, `expense_name`, `amount`, `bill_no`, `payment_date`, `mode_of_payment`, `payment_cheque_id`, `paypal_transaction_id`, `created_at`, `modified_at`) VALUES
(3, 'Employee Salaray for October, 2012', 2500.00, 190601513, '2012-11-05', 'cash', 0, 0, '2012-11-11 05:00:38', NULL),
(4, 'Needle Machine', 800.00, 882392257, '2012-10-20', 'cheque', 1, 0, '2012-11-11 05:02:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_payment_cheques`
--

CREATE TABLE IF NOT EXISTS `boutique_payment_cheques` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` varchar(60) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `bank_name` varchar(60) NOT NULL,
  `bank_branch` varchar(45) NOT NULL,
  `cheque_issue_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `boutique_payment_cheques`
--

INSERT INTO `boutique_payment_cheques` (`id`, `account_no`, `account_name`, `bank_name`, `bank_branch`, `cheque_issue_date`, `created_at`, `modified_at`) VALUES
(1, '147852', 'Salma Begum', 'Standard Chartered', 'Uttara', '2012-10-25', '2012-11-11 05:02:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_paypal_transactions`
--

CREATE TABLE IF NOT EXISTS `boutique_paypal_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(30) NOT NULL,
  `bill_no` bigint(20) NOT NULL,
  `payment_status` varchar(15) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `paid_currency` varchar(8) NOT NULL,
  `paytime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `boutique_paypal_transactions`
--


-- --------------------------------------------------------

--
-- Table structure for table `boutique_products`
--

CREATE TABLE IF NOT EXISTS `boutique_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `product_stock_id` int(11) NOT NULL,
  `product_name` varchar(60) NOT NULL,
  `product_no` varchar(30) NOT NULL,
  `guarantee` int(11) NOT NULL,
  `guarantee_unit` enum('hour','day','week','month') NOT NULL,
  `available_quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) unsigned DEFAULT '0',
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`category_id`,`product_stock_id`),
  KEY `boutique_products_FKIndex1` (`category_id`),
  KEY `boutique_products_FKIndex2` (`product_stock_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `boutique_products`
--

INSERT INTO `boutique_products` (`id`, `category_id`, `product_stock_id`, `product_name`, `product_no`, `guarantee`, `guarantee_unit`, `available_quantity`, `unit_price`, `description`, `is_active`, `created_at`, `modified_at`) VALUES
(5, 1, 1, 'BAG-1', 'B001', 24, 'month', 15, 350.00, 'This is a test Bag', 1, '2012-10-07 08:17:15', '2012-12-28 05:53:56'),
(6, 1, 1, 'BAG-2', 'B002', 1, 'month', 98, 475.00, 'This is a test Bag-2', 1, '2012-10-07 08:31:53', '2012-10-23 03:59:03'),
(7, 1, 2, 'Purse-1', 'H001', 24, 'month', 13, 280.00, 'This is a purse bg', 1, '2012-10-07 08:35:28', '2012-10-23 03:59:31'),
(8, 3, 7, 'High Hills', 'H001', 7, 'month', 10, 250.00, 'These are test Hill product', 1, '2012-10-07 08:50:28', '2012-10-23 10:10:42'),
(9, 1, 2, 'BAG-2', 'B001', 1, 'week', 15, 285.00, 'This is a test Bag', 1, '2012-10-07 09:26:33', '2012-10-23 03:58:44'),
(10, 3, 8, 'Colorful Boot', 'P174', 24, 'month', 4, 650.00, 'Ladies first impression in a bar, party, horse-ranche, sports occassion...', 1, '2012-10-23 04:10:16', NULL),
(11, 4, 7, 'Black Frock with Golden Spots', 'SK001', 24, 'month', 120, 450.00, 'Elastic in the middle. Non-washable silky.', 1, '2013-01-01 04:17:03', '2013-01-01 06:24:14'),
(12, 4, 7, 'Pink & Silky Gown', 'SK002', 12, 'month', 89, 275.00, 'Smooth and comfortable for night dress', 1, '2013-01-01 04:18:53', NULL),
(13, 4, 9, 'School Skirt', 'SK003', 12, 'month', 150, 200.00, 'School wear looks good with any white tops', 1, '2013-01-01 04:20:49', NULL),
(15, 4, 5, 'Stylish Tops', 'SK004', 24, 'month', 60, 14.98, 'Some details on Tops', 1, '2013-01-01 09:58:04', '2013-01-01 10:02:34'),
(16, 4, 5, 'White Creamy Tops', 'SK005', 12, 'month', 15, 18.75, 'Silky and smooth', 1, '2013-01-01 09:59:51', NULL),
(17, 4, 5, 'Orange Stripe Tops', 'SK006', 24, 'month', 14, 35.75, 'Some details on Tops', 1, '2013-01-01 10:01:07', '2013-01-01 10:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `boutique_product_images`
--

CREATE TABLE IF NOT EXISTS `boutique_product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `dimension` varchar(25) NOT NULL,
  `uploaded_at` datetime NOT NULL,
  `image_order` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_boutique_product_images` (`product_id`),
  KEY `FK_boutique_images_of_category` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `boutique_product_images`
--

INSERT INTO `boutique_product_images` (`id`, `product_id`, `category_id`, `file_name`, `dimension`, `uploaded_at`, `image_order`) VALUES
(3, 7, 1, '5071dad98aba1.jpg', '140X140', '2012-10-07 09:41:22', 1),
(4, 8, 3, '50723cef57bd0.jpg', '193X148', '2012-10-08 04:39:59', 1),
(6, 5, 1, '50843548c65d5.jpg', '140X140', '2012-10-21 07:50:32', 1),
(7, 9, 1, '5084360a31976.jpg', '140X140', '2012-10-21 07:51:11', 1),
(8, 6, 1, '508436273567f.jpg', '500X579', '2012-10-21 07:51:39', 1),
(9, 7, 1, '5071dab1dad5e.jpg', 'X', '2012-10-23 03:59:31', 2),
(10, 8, 3, '50723cef76418.jpg', 'X', '2012-10-23 03:59:48', 1),
(11, 10, 3, '5085fc370040c.jpg', '562X400', '2012-10-23 04:10:17', 1),
(12, 5, 1, '50ddce9b6731f.jpg', '287X300', '2012-12-28 05:53:56', 2),
(13, 5, 1, '50ddce9b85b66.jpg', '300X225', '2012-12-28 05:53:56', 3),
(15, 12, 4, '50e2559913d81.jpg', '600X600', '2013-01-01 04:18:53', 1),
(16, 13, 4, '50e2560da0fce.jpg', '600X600', '2013-01-01 04:20:49', 1),
(26, 11, 4, '50e31a768b28f.jpg', '600X600', '2013-01-01 06:18:52', 1),
(27, 11, 4, '50e31bb442ae4.jpg', '600X600', '2013-01-01 06:24:15', 2),
(28, 11, 4, '50e31bb45991b.jpg', '600X600', '2013-01-01 06:24:15', 3),
(29, 11, 4, '50e31bb47fb74.jpg', '600X600', '2013-01-01 06:24:15', 4),
(30, 11, 4, '50e31bb52429c.jpg', '600X600', '2013-01-01 06:24:15', 5),
(31, 15, 1, '50e34df3d3a3a.jpg', '600X600', '2013-01-01 09:58:36', 2),
(32, 15, 1, '50e34df3ee579.jpg', '600X600', '2013-01-01 09:58:36', 1),
(33, 15, 1, '50e34df41c88b.jpg', '600X600', '2013-01-01 09:58:36', 3),
(34, 16, 4, '50e34e0ec831f.jpg', '600X600', '2013-01-01 09:59:51', 1),
(35, 17, 1, '50e34e905991a.jpg', '600X600', '2013-01-01 10:01:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_product_sections`
--

CREATE TABLE IF NOT EXISTS `boutique_product_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `boutique_product_sections`
--

INSERT INTO `boutique_product_sections` (`id`, `name`, `is_active`, `created_at`, `modified_at`) VALUES
(1, 'men', 1, '2013-01-23 08:41:48', NULL),
(2, 'women', 1, '2013-01-23 08:45:13', '2013-01-23 08:51:15'),
(3, 'kids', 0, '2013-01-23 08:50:26', '2013-01-23 09:03:50'),
(4, 'adult', 0, '2013-01-23 09:04:10', '2013-01-23 09:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `boutique_product_stocks`
--

CREATE TABLE IF NOT EXISTS `boutique_product_stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(60) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `brought_from` varchar(60) NOT NULL,
  `bill_no` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `boutique_product_stocks`
--

INSERT INTO `boutique_product_stocks` (`id`, `product_name`, `quantity`, `amount`, `brought_from`, `bill_no`, `created_at`, `modified_at`) VALUES
(1, 'Goocci Bags', 100, 100.00, 'USA', 9223372036854775807, '2012-09-28 21:07:18', '2012-09-28 21:07:18'),
(2, 'Hand Bag', 10, 100.00, ' UK', 9223372036854775807, '2012-09-28 21:10:41', '2012-09-28 21:10:41'),
(3, 'School Bag', 15, 100.00, ' Dhaka', 9223372036854775807, '2012-09-28 21:11:22', '2012-09-28 21:11:22'),
(4, 'Kid Bag', 25, 150.00, 'Uttara', 9223372036854775807, '2012-09-28 21:13:00', '2012-10-06 06:27:22'),
(5, ' Stock Bundle', 500, 15000.00, 'ABC Comp.', 321456, '2012-09-30 20:35:04', NULL),
(7, 'STOCK-A', 7841, 35870.45, 'Uttara', 1515164501, '2012-10-06 06:36:28', NULL),
(8, 'STOCK-A2', 2310, 4500.98, 'Seller-A', 387015838, '2012-10-09 10:39:45', NULL),
(9, 'STOCK-B', 0, 7500.00, 'Selle-B', 297880969, '2012-11-04 02:54:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_shipment_levels`
--

CREATE TABLE IF NOT EXISTS `boutique_shipment_levels` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `level_status_message` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `boutique_shipment_levels`
--

INSERT INTO `boutique_shipment_levels` (`id`, `level_status_message`) VALUES
(1, 'Your shipment under process'),
(2, 'Your shipment has been sent through'),
(3, 'Your shipment has been delivered on'),
(4, 'Level4');

-- --------------------------------------------------------

--
-- Table structure for table `boutique_shopping_cart`
--

CREATE TABLE IF NOT EXISTS `boutique_shopping_cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_chosen_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_boutique_shopping_cart_user` (`user_id`),
  KEY `FK_boutique_products_in_shopping_cart` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `boutique_shopping_cart`
--

INSERT INTO `boutique_shopping_cart` (`id`, `product_id`, `user_id`, `quantity`, `item_chosen_at`) VALUES
(8, 12, 20, 1, '2013-01-01 04:31:59'),
(9, 10, 20, 2, '2013-01-01 04:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `boutique_temporary_activation_codes`
--

CREATE TABLE IF NOT EXISTS `boutique_temporary_activation_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(80) NOT NULL,
  `activation_code` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `boutique_temporary_activation_codes`
--


-- --------------------------------------------------------

--
-- Table structure for table `boutique_users`
--

CREATE TABLE IF NOT EXISTS `boutique_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `email_address` varchar(80) NOT NULL,
  `mobile_no` varchar(20) NOT NULL,
  `residence_address` text NOT NULL,
  `office_address` text,
  `country_code_id` int(11) NOT NULL,
  `is_residence_preferred_delivery_place` tinyint(1) unsigned DEFAULT NULL,
  `is_admin` tinyint(1) unsigned DEFAULT '1',
  `is_active` tinyint(1) unsigned DEFAULT '0',
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_boutique_user_country` (`country_code_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `boutique_users`
--

INSERT INTO `boutique_users` (`id`, `full_name`, `user_password`, `email_address`, `mobile_no`, `residence_address`, `office_address`, `country_code_id`, `is_residence_preferred_delivery_place`, `is_admin`, `is_active`, `created_at`, `modified_at`) VALUES
(1, 'Mizanur Islam Laskar', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@domain.com', '4235464564', 'dfsdfsdfsdgdsgf', 'sfdsagdf', 2, 0, 1, 1, '2012-09-29 00:00:00', NULL),
(2, 'Afsana Rahman', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'sales@universalsigning.com', '011-65-8123 456', 'Some Home Address', 'Some Official Address', 2, 1, 0, 1, '2012-10-04 04:05:50', NULL),
(3, 'Salman Khan', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'salman@gmail.com', '011-65-8123 456', 'Mumbai Home Address', 'DELLHI Office Address', 2, 1, 0, 0, '2012-10-04 08:20:55', '2012-10-05 06:09:53'),
(4, 'Khaled Habib', '4b48ce0c2a02e7d4277ac184f8d99ebb348c25cf', 'khaled@gmail.com', '011-65-8123 456', 'Gazipur Home Address', 'POLAR Office Address', 2, 1, 0, 1, '2012-10-04 09:54:30', '2012-10-05 07:25:32'),
(5, 'Mashrura Islam', 'bf798206ea453f4cfc4cb1b20aaac638f0ef2927', 'mashrura@gmail.com', '011-65-8123 788', 'Gazipur Home Address', 'Some Official Address', 1, 1, 0, 1, '2012-10-05 05:57:39', '2012-12-22 03:49:08'),
(6, 'Sazia Afrin', '4c869544815205bde1f31f7b2fb09b97a22fa722', 'sazia@gmail.com', '011-65-8123 471', 'Mumbai Home Address', 'POLAR Office Address', 2, 1, 0, 1, '2012-10-05 06:04:16', NULL),
(7, 'Saima Kuratul Aine', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'saima@msn.com', '011-65-8123 781', 'Gazipur Home Address', 'DELLHI Office Address', 2, 0, 0, 1, '2012-10-05 06:07:20', NULL),
(8, 'Nafisa Kuratul Aine', '20d75fe135fc3abc15aee2f6e4657c3107899d6a', 'nafisa@yahoo.com', '011-65-8123 471', 'Gazipur Home Address', 'POLAR Office Address', 2, 0, 0, 1, '2012-10-05 06:17:25', NULL),
(9, 'Sabina Yesmin', '7c222fb2927d828af22f592134e8932480637c0d', 'sabina@aol.com', '011-65-8123 470', 'Mumbai Home Address', 'POLAR Office Address', 2, 1, 0, 1, '2012-10-05 06:21:39', NULL),
(12, 'Anushka Islam', '20eabe5d64b0e216796e834f52d61fd0b70332fc', 'anu@gmail.com', '011-65-8123 788', 'Gazipur Home Address', '', 2, 0, 0, 1, '2012-10-05 06:29:25', NULL),
(13, 'Dipika Padugon', 'be920fdca4a28c5da65a91076b38471b31229194', 'dip@mns.com', '011-65-8123 473', 'Gazipur Home Address', '', 2, 0, 0, 1, '2012-10-05 06:32:28', NULL),
(15, 'Rishi Kapoor', '7c222fb2927d828af22f592134e8932480637c0d', 'rishi@gmail.com', '011-65-8123 477', 'Rangpur home', 'Rangpur thana', 2, 1, 0, 1, '2012-10-05 06:38:03', NULL),
(16, 'Some Customer', '84bc185d5f04685f7031c29913bd13af35256833', 'customer@gmail.com', '01871233', 'sdddd', 'okkiia', 2, 1, 0, 1, '2012-10-18 03:21:49', NULL),
(17, 'Another ANME', '17111b8664066497e22d610b57eb7fac74e7f01d', 'someone@msn.com', '0147852', 'sdasd', 'ssdfsdg', 2, 0, 0, 1, '2012-10-18 03:25:39', NULL),
(18, 'mizan123', '06d9b5eb513d695a15a99001fed73bd552b17ca5', 'mizan123@msn', '011-65-8123 788', 'jvjhbjhb', 'kjbkjjk', 2, 1, 0, 1, '2012-10-20 02:27:24', NULL),
(19, 'mizan12', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'mizan12@msn.com', '011-65-8123 788', 'adfr', 'fght', 2, 1, 0, 1, '2012-10-20 02:30:24', NULL),
(20, 'Mizanur Islam', '7d23d91e4379ccf2240d3564be0e72f42ff4b244', 'ruman@gmail.com', '01816719318', 'Home Address', 'Office Address', 1, 1, 0, 1, '2012-10-22 05:04:36', '2012-12-22 03:49:47'),
(21, 'Ashraf Uddoula', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'ashraf@msn.com', '01747465999', 'Home Address', 'Office Address', 1, 0, 0, 1, '2012-12-22 03:53:12', NULL),
(34, 'Salman Khan', '76c74be25ae3827c5c8bc9d24ebf87cd532d46c2', 'salman@aol.com', '01816719318', 'res', 'off', 1, 0, 0, 1, '2012-12-26 07:08:39', NULL),
(35, 'Rumana Afrin', 'df76fb3fed9f8053357d8d46e5b528ac3c1fe2f1', 'rumana@aol.com', '01727232666', 'es', 'off', 1, 1, 0, 1, '2012-12-26 07:26:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `boutique_user_orders`
--

CREATE TABLE IF NOT EXISTS `boutique_user_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `shipment_level_id` int(4) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `bill_no` bigint(20) NOT NULL,
  `order_date` date NOT NULL,
  `is_open` tinyint(1) DEFAULT NULL,
  `courier_name` varchar(100) DEFAULT NULL,
  `courier_no` varchar(100) DEFAULT NULL,
  `delivered_on` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`,`product_id`,`shipment_level_id`),
  KEY `boutique_user_orders_FKIndex1` (`user_id`),
  KEY `boutique_user_orders_FKIndex3` (`shipment_level_id`),
  KEY `FK_boutique_user_orders` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `boutique_user_orders`
--

INSERT INTO `boutique_user_orders` (`id`, `user_id`, `product_id`, `shipment_level_id`, `order_quantity`, `bill_no`, `order_date`, `is_open`, `courier_name`, `courier_no`, `delivered_on`, `created_at`, `modified_at`) VALUES
(1, 20, 6, 3, 21, 163908918, '2012-10-22', 0, 'DHL', '147852', '2012-12-10 00:00:00', '2012-10-22 10:46:02', NULL),
(2, 20, 8, 2, 2, 423315295, '2012-10-23', 1, 'FedEx', '258753', NULL, '2012-10-23 11:03:34', NULL),
(3, 20, 10, 1, 2, 423315295, '2012-10-23', 1, NULL, NULL, NULL, '2012-10-23 11:03:35', NULL),
(4, 20, 6, 1, 2, 691041945, '2012-11-06', 1, NULL, NULL, NULL, '2012-11-06 07:27:00', NULL),
(5, 20, 8, 1, 1, 691041945, '2012-11-06', 1, NULL, NULL, NULL, '2012-11-06 07:27:00', NULL),
(6, 20, 7, 1, 1, 132288191, '2012-11-06', 1, NULL, NULL, NULL, '2012-11-06 07:48:22', NULL),
(7, 20, 10, 1, 1, 975002054, '2012-11-10', 1, NULL, NULL, NULL, '2012-11-10 03:47:35', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boutique_advertisement_images`
--
ALTER TABLE `boutique_advertisement_images`
  ADD CONSTRAINT `FK_boutique_advertisement_images` FOREIGN KEY (`advertisement_id`) REFERENCES `boutique_advertisements` (`id`);

--
-- Constraints for table `boutique_categories`
--
ALTER TABLE `boutique_categories`
  ADD CONSTRAINT `FK_boutique_category_sections` FOREIGN KEY (`product_section_id`) REFERENCES `boutique_product_sections` (`id`);

--
-- Constraints for table `boutique_products`
--
ALTER TABLE `boutique_products`
  ADD CONSTRAINT `boutique_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `boutique_categories` (`id`),
  ADD CONSTRAINT `boutique_products_ibfk_2` FOREIGN KEY (`product_stock_id`) REFERENCES `boutique_product_stocks` (`id`);

--
-- Constraints for table `boutique_product_images`
--
ALTER TABLE `boutique_product_images`
  ADD CONSTRAINT `FK_boutique_images_of_category` FOREIGN KEY (`category_id`) REFERENCES `boutique_categories` (`id`),
  ADD CONSTRAINT `FK_boutique_product_images` FOREIGN KEY (`product_id`) REFERENCES `boutique_products` (`id`);

--
-- Constraints for table `boutique_shopping_cart`
--
ALTER TABLE `boutique_shopping_cart`
  ADD CONSTRAINT `FK_boutique_products_in_shopping_cart` FOREIGN KEY (`product_id`) REFERENCES `boutique_products` (`id`),
  ADD CONSTRAINT `FK_boutique_shopping_cart_user` FOREIGN KEY (`user_id`) REFERENCES `boutique_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `boutique_users`
--
ALTER TABLE `boutique_users`
  ADD CONSTRAINT `FK_boutique_user_country` FOREIGN KEY (`country_code_id`) REFERENCES `boutique_country_codes` (`id`);

--
-- Constraints for table `boutique_user_orders`
--
ALTER TABLE `boutique_user_orders`
  ADD CONSTRAINT `boutique_user_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `boutique_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `boutique_user_orders_ibfk_3` FOREIGN KEY (`shipment_level_id`) REFERENCES `boutique_shipment_levels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_boutique_user_orders` FOREIGN KEY (`product_id`) REFERENCES `boutique_products` (`id`);
