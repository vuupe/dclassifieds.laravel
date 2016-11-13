-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 13, 2016 at 05:14 PM
-- Server version: 5.1.42
-- PHP Version: 5.2.12

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dclassifieds_install`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `condition_id` int(10) unsigned NOT NULL,
  `ad_email` varchar(255) DEFAULT NULL,
  `ad_publish_date` datetime DEFAULT NULL,
  `ad_valid_until` date DEFAULT NULL,
  `ad_active` tinyint(4) DEFAULT '0',
  `ad_ip` varchar(20) DEFAULT NULL,
  `ad_price` double(10,2) DEFAULT '0.00',
  `ad_free` tinyint(4) DEFAULT '0',
  `ad_phone` varchar(255) DEFAULT NULL,
  `ad_title` varchar(255) DEFAULT NULL,
  `ad_description` text,
  `ad_description_hash` varchar(40) DEFAULT NULL,
  `ad_puslisher_name` varchar(255) DEFAULT NULL,
  `code` char(30) DEFAULT NULL,
  `ad_promo` tinyint(4) DEFAULT '0',
  `ad_promo_until` date DEFAULT NULL,
  `ad_link` varchar(255) DEFAULT NULL,
  `ad_video` varchar(255) DEFAULT NULL,
  `ad_lat_lng` varchar(255) DEFAULT NULL,
  `ad_skype` varchar(255) DEFAULT NULL,
  `ad_address` varchar(255) DEFAULT NULL,
  `ad_pic` varchar(255) DEFAULT NULL,
  `ad_view` int(11) DEFAULT '0',
  `estate_type_id` int(11) DEFAULT '0',
  `estate_sq_m` int(11) DEFAULT '0',
  `estate_year` int(11) DEFAULT '0',
  `estate_construction_type_id` int(11) DEFAULT '0',
  `estate_floor` int(11) DEFAULT '0',
  `estate_num_floors_in_building` int(11) DEFAULT '0',
  `estate_heating_type_id` int(11) DEFAULT '0',
  `estate_furnishing_type_id` int(11) DEFAULT '0',
  `car_brand_id` int(11) DEFAULT '0',
  `car_model_id` int(11) DEFAULT '0',
  `car_engine_id` int(11) DEFAULT '0',
  `car_transmission_id` int(11) DEFAULT '0',
  `car_modification_id` int(11) DEFAULT '0',
  `car_condition_id` int(11) DEFAULT '0',
  `car_year` int(11) DEFAULT '0',
  `car_kilometeres` int(11) DEFAULT '0',
  `clothes_size_id` int(11) DEFAULT '0',
  `shoes_size_id` int(11) DEFAULT '0',
  `bonus_added` tinyint(4) DEFAULT '0',
  `expire_warning_mail_send` tinyint(4) DEFAULT '0',
  `promo_expire_warning_mail_send` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ad_id`),
  UNIQUE KEY `code` (`code`),
  KEY `category_id` (`category_id`),
  KEY `location_id` (`location_id`),
  KEY `ad_description_hash` (`ad_description_hash`),
  FULLTEXT KEY `ad_title` (`ad_title`,`ad_description`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad`
--


-- --------------------------------------------------------

--
-- Table structure for table `admin_menu`
--

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_parent_id` int(11) DEFAULT NULL,
  `menu_type_id` tinyint(4) DEFAULT '1',
  `menu_title_key` varchar(255) NOT NULL,
  `menu_icon` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) NOT NULL,
  `menu_controller` varchar(255) NOT NULL,
  `menu_ord` int(11) NOT NULL,
  `menu_active` tinyint(1) NOT NULL,
  `menu_external_link` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `admin_menu`
--

INSERT INTO `admin_menu` (`menu_id`, `menu_parent_id`, `menu_type_id`, `menu_title_key`, `menu_icon`, `menu_link`, `menu_controller`, `menu_ord`, `menu_active`, `menu_external_link`) VALUES
(1, NULL, 1, 'dashboard', 'fa fa-link', 'admin', 'admincontroller', 10, 1, 0),
(2, NULL, 1, 'locations', 'fa fa-globe', 'admin/location', 'locationcontroller', 20, 1, 0),
(3, NULL, 1, 'categories', 'fa fa-sitemap', 'admin/category', 'categorycontroller', 30, 1, 0),
(4, NULL, 1, 'ads', 'fa fa-edit', 'admin/ad', 'adcontroller', 40, 1, 0),
(5, NULL, 1, 'users', 'fa fa-users', 'admin/user', 'usercontroller', 50, 1, 0),
(6, NULL, 2, 'common_types', 'fa fa-gears', '', '', 60, 1, 0),
(7, 6, 1, 'adtype', 'fa fa-circle-o', 'admin/adtype', 'adtypecontroller', 10, 1, 0),
(8, 6, 1, 'adcondition', 'fa fa-circle-o', 'admin/adcondition', 'adconditioncontroller', 20, 1, 0),
(9, NULL, 2, 'real_estate_types', 'fa fa-gears', '', '', 70, 1, 0),
(10, 9, 1, 'estate_construction_type', 'fa fa-circle-o', 'admin/estateconstruction', 'estateconstructioncontroller', 10, 1, 0),
(11, 9, 1, 'estate_furnishing_type', 'fa fa-circle-o', 'admin/estatefurnishing', 'estatefurnishingcontroller', 20, 1, 0),
(12, 9, 1, 'estate_heating_type', 'fa fa-circle-o', 'admin/estateheating', 'estateheatingcontroller', 30, 1, 0),
(13, 9, 1, 'estate_type', 'fa fa-circle-o', 'admin/estatetype', 'estatetypecontroller', 40, 1, 0),
(14, NULL, 2, 'car_types', 'fa fa-gears', '', '', 80, 1, 0),
(15, 14, 1, 'car_brand', 'fa fa-circle-o', 'admin/carbrand', 'carbrandcontroller', 10, 1, 0),
(16, 14, 1, 'car_model', 'fa fa-circle-o', 'admin/carmodel', 'carmodelcontroller', 20, 1, 0),
(17, 14, 1, 'car_condition', 'fa fa-circle-o', 'admin/carcondition', 'carconditioncontroller', 30, 1, 0),
(18, 14, 1, 'car_engine', 'fa fa-circle-o', 'admin/carengine', 'carenginecontroller', 40, 1, 0),
(19, 14, 1, 'car_modification', 'fa fa-circle-o', 'admin/carmodification', 'carmodificationcontroller', 50, 1, 0),
(20, 14, 1, 'car_transmission', 'fa fa-circle-o', 'admin/cartransmission', 'cartransmissioncontroller', 60, 1, 0),
(21, NULL, 1, 'banner', 'fa fa-dollar', 'admin/banner', 'bannercontroller', 90, 1, 0),
(22, NULL, 1, 'settings', 'fa fa-gear', 'admin/settings', 'settingscontroller', 100, 1, 0),
(23, NULL, 1, 'pages', 'fa fa-file-text-o', 'admin/page', 'pagecontroller', 120, 1, 0),
(24, NULL, 1, 'reports', 'fa fa-warning', 'admin/report', 'reportcontroller', 130, 1, 0),
(25, NULL, 1, 'wallet', 'fa fa-money', 'admin/wallet', 'walletcontroller', 140, 1, 0),
(26, NULL, 1, 'payment_options', 'fa fa-credit-card', 'admin/pay', 'paycontroller', 150, 1, 0),
(27, NULL, 1, 'mail', 'fa fa-envelope-o', 'admin/mail', 'mailcontroller', 160, 1, 0),
(28, NULL, 1, 'ipban', 'fa fa-ban', 'admin/ipban', 'ipbancontroller', 170, 1, 0),
(29, NULL, 1, 'mailban', 'fa fa-ban', 'admin/mailban', 'mailbancontroller', 180, 1, 0),
(30, NULL, 1, 'clear_cache', 'fa fa-eraser', 'admin/clearcache', 'clearcachecontroller', 190, 1, 0),
(31, NULL, 2, 'clothes_types', 'fa fa-gears', '', '', 85, 1, 0),
(32, 31, 1, 'clothes_sizes', 'fa fa-circle-o', 'admin/clothes', 'clothescontroller', 10, 1, 0),
(33, 31, 1, 'shoes_sizes', 'fa fa-circle-o', 'admin/shoes', 'shoescontroller', 20, 1, 0),
(34, NULL, 1, 'magic_keywords', 'fa fa-magic', 'admin/magic', 'magiccontroller', 200, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ad_ban_email`
--

CREATE TABLE IF NOT EXISTS `ad_ban_email` (
  `ban_email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_email` varchar(255) NOT NULL,
  `ban_reason` varchar(255) NOT NULL,
  PRIMARY KEY (`ban_email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_ban_email`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_ban_ip`
--

CREATE TABLE IF NOT EXISTS `ad_ban_ip` (
  `ban_ip_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ban_ip` varchar(50) NOT NULL,
  `ban_reason` varchar(255) NOT NULL,
  PRIMARY KEY (`ban_ip_id`),
  UNIQUE KEY `ban_ip` (`ban_ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_ban_ip`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_condition`
--

CREATE TABLE IF NOT EXISTS `ad_condition` (
  `ad_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_condition_name` varchar(255) NOT NULL,
  PRIMARY KEY (`ad_condition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_condition`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_fav`
--

CREATE TABLE IF NOT EXISTS `ad_fav` (
  `ad_fav_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ad_fav_id`),
  KEY `ad_id` (`ad_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_fav`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_pic`
--

CREATE TABLE IF NOT EXISTS `ad_pic` (
  `ad_pic_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_id` int(10) unsigned NOT NULL,
  `ad_pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ad_pic_id`),
  KEY `ad_id` (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_pic`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_report`
--

CREATE TABLE IF NOT EXISTS `ad_report` (
  `report_id` int(11) NOT NULL AUTO_INCREMENT,
  `report_ad_id` int(11) NOT NULL,
  `report_type_id` int(11) NOT NULL,
  `report_info` text,
  `report_date` datetime NOT NULL,
  `report_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `ad_id` (`report_ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_report`
--


-- --------------------------------------------------------

--
-- Table structure for table `ad_type`
--

CREATE TABLE IF NOT EXISTS `ad_type` (
  `ad_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`ad_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ad_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_position` int(11) NOT NULL,
  `banner_type` int(11) NOT NULL,
  `banner_name` varchar(255) NOT NULL,
  `banner_link` varchar(255) DEFAULT NULL,
  `banner_code` text,
  `banner_image` varchar(255) DEFAULT NULL,
  `banner_active_from` date DEFAULT NULL,
  `banner_active_to` date DEFAULT NULL,
  `banner_num_views` int(11) DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `banner`
--


-- --------------------------------------------------------

--
-- Table structure for table `car_brand`
--

CREATE TABLE IF NOT EXISTS `car_brand` (
  `car_brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_brand_name` varchar(255) NOT NULL,
  `car_brand_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`car_brand_id`),
  UNIQUE KEY `car_brand_name` (`car_brand_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `car_brand`
--


-- --------------------------------------------------------

--
-- Table structure for table `car_condition`
--

CREATE TABLE IF NOT EXISTS `car_condition` (
  `car_condition_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_condition_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_condition_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `car_condition`
--


-- --------------------------------------------------------

--
-- Table structure for table `car_engine`
--

CREATE TABLE IF NOT EXISTS `car_engine` (
  `car_engine_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_engine_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_engine_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `car_engine`
--


-- --------------------------------------------------------

--
-- Table structure for table `car_model`
--

CREATE TABLE IF NOT EXISTS `car_model` (
  `car_model_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_brand_id` int(11) NOT NULL,
  `car_model_name` varchar(255) NOT NULL,
  `car_model_active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`car_model_id`),
  KEY `car_brand_id` (`car_brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `car_model`
--


-- --------------------------------------------------------

--
-- Table structure for table `car_modification`
--

CREATE TABLE IF NOT EXISTS `car_modification` (
  `car_modification_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_modification_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_modification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `car_modification`
--


-- --------------------------------------------------------

--
-- Table structure for table `car_transmission`
--

CREATE TABLE IF NOT EXISTS `car_transmission` (
  `car_transmission_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_transmission_name` varchar(255) NOT NULL,
  PRIMARY KEY (`car_transmission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `car_transmission`
--


-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_parent_id` int(10) unsigned DEFAULT NULL,
  `category_type` tinyint(4) DEFAULT '1',
  `category_title` varchar(255) DEFAULT NULL,
  `category_slug` varchar(255) NOT NULL,
  `category_description` varchar(255) DEFAULT NULL,
  `category_keywords` varchar(255) DEFAULT NULL,
  `category_img` varchar(255) DEFAULT NULL,
  `category_active` tinyint(4) DEFAULT '1',
  `category_ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_slug` (`category_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `category`
--


-- --------------------------------------------------------

--
-- Table structure for table `clothes_size`
--

CREATE TABLE IF NOT EXISTS `clothes_size` (
  `clothes_size_id` int(11) NOT NULL AUTO_INCREMENT,
  `clothes_size_name` varchar(255) NOT NULL,
  `clothes_size_ord` int(11) NOT NULL,
  PRIMARY KEY (`clothes_size_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `clothes_size`
--


-- --------------------------------------------------------

--
-- Table structure for table `estate_construction_type`
--

CREATE TABLE IF NOT EXISTS `estate_construction_type` (
  `estate_construction_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `estate_construction_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_construction_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `estate_construction_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `estate_furnishing_type`
--

CREATE TABLE IF NOT EXISTS `estate_furnishing_type` (
  `estate_furnishing_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estate_furnishing_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_furnishing_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `estate_furnishing_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `estate_heating_type`
--

CREATE TABLE IF NOT EXISTS `estate_heating_type` (
  `estate_heating_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estate_heating_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_heating_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `estate_heating_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `estate_type`
--

CREATE TABLE IF NOT EXISTS `estate_type` (
  `estate_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estate_type_name` varchar(255) NOT NULL,
  PRIMARY KEY (`estate_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `estate_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_parent_id` int(11) DEFAULT NULL,
  `location_active` tinyint(4) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `location_slug` varchar(255) NOT NULL,
  `location_post_code` varchar(255) DEFAULT NULL,
  `location_ord` int(11) DEFAULT '0',
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location_slug` (`location_slug`),
  KEY `post_code` (`location_post_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `location`
--


-- --------------------------------------------------------

--
-- Table structure for table `magic_keywords`
--

CREATE TABLE IF NOT EXISTS `magic_keywords` (
  `keyword_id` int(11) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(255) NOT NULL,
  `keyword_count` int(11) DEFAULT '1',
  `keyword_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`keyword_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `magic_keywords`
--


-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_position` tinyint(4) NOT NULL,
  `page_slug` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_description` varchar(255) DEFAULT NULL,
  `page_keywords` varchar(255) DEFAULT NULL,
  `page_content` text NOT NULL,
  `page_active` tinyint(4) DEFAULT '1',
  `page_ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_slug` (`page_slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `page`
--


-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_reset_user_email_index` (`email`),
  KEY `password_reset_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--


-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE IF NOT EXISTS `pay` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(255) NOT NULL,
  `pay_active` tinyint(4) NOT NULL,
  `pay_ord` int(11) NOT NULL,
  `pay_info_url` varchar(255) NOT NULL,
  `pay_sum` double(8,2) NOT NULL,
  `pay_promo_period` int(11) NOT NULL,
  `pay_sms_prefix` varchar(255) DEFAULT NULL,
  `pay_description` text,
  `pay_ping_url` varchar(255) DEFAULT NULL,
  `pay_allowed_ip` varchar(255) DEFAULT NULL,
  `pay_number` varchar(255) DEFAULT NULL,
  `pay_secret` varchar(255) DEFAULT NULL,
  `pay_testmode` tinyint(4) DEFAULT '0',
  `pay_paypal_mail` varchar(255) DEFAULT NULL,
  `pay_sum_to_charge` double(8,2) DEFAULT '0.00',
  `pay_currency` varchar(10) DEFAULT NULL,
  `pay_locale` varchar(10) DEFAULT NULL,
  `pay_log` tinyint(4) DEFAULT '0',
  `pay_page_name` varchar(255) DEFAULT NULL,
  `pay_secret_key` varchar(255) DEFAULT NULL,
  `pay_publish_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pay`
--

INSERT INTO `pay` (`pay_id`, `pay_name`, `pay_active`, `pay_ord`, `pay_info_url`, `pay_sum`, `pay_promo_period`, `pay_sms_prefix`, `pay_description`, `pay_ping_url`, `pay_allowed_ip`, `pay_number`, `pay_secret`, `pay_testmode`, `pay_paypal_mail`, `pay_sum_to_charge`, `pay_currency`, `pay_locale`, `pay_log`, `pay_page_name`, `pay_secret_key`, `pay_publish_key`) VALUES
(1, 'Mobio SMS Pay', 1, 10, 'http://mobio.bg/site/en/', 4.60, 7, 'DC', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English.', 'http://your domain/mobiopay', '87.120.176.216,194.12.244.114', '1666', NULL, 0, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL),
(2, 'Fortumo SMS Pay', 1, 20, 'https://fortumo.com/', 4.60, 7, 'TXT DCAA', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. ', 'http://your domain/fortumopay', '127.0.0.1,79.125.125.1,79.125.5.205,79.125.5.95,54.72.6.23', '1855', '2e1a1e7515ce57e7475462720a85dd2f', 0, NULL, 0.00, NULL, NULL, 0, NULL, NULL, NULL),
(3, 'Paypal Standard Pay', 1, 30, 'https://www.paypal.com', 4.60, 7, NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', NULL, NULL, NULL, NULL, 0, 'paypal@dedo.bg', 1.00, 'EUR', 'US', 0, 'paypalpay', NULL, NULL),
(4, 'Stripe', 1, 40, 'https://stripe.com/', 4.60, 7, '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', NULL, '', '', '', 0, '', 1.00, 'EUR', '', 0, 'stripepay', 'sk_test_BQokikJOvBiI2HlWgH4olfQ2', 'pk_test_6pRNASCoBOKtIshFeQd4XMUh');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` text,
  `setting_description` varchar(255) NOT NULL,
  `setting_show_in_admin` tinyint(4) DEFAULT '1',
  `setting_field_type` varchar(10) DEFAULT 'text',
  `setting_more_info` varchar(255) DEFAULT NULL,
  `setting_ord` int(11) DEFAULT '0',
  `setting_required` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`, `setting_description`, `setting_show_in_admin`, `setting_field_type`, `setting_more_info`, `setting_ord`, `setting_required`) VALUES
(1, 'site_domain', 'dclassifieds.eu', 'Site domain name', 1, 'text', NULL, 0, 1),
(2, 'site_logo_name', 'DClassifieds V3', 'Site Logo Name', 1, 'text', NULL, 0, 1),
(3, 'site_home_page_title', 'DClassifieds V3', 'Site home page title', 1, 'text', NULL, 0, 1),
(4, 'site_copyright_name', 'DClassifieds', 'Site Copyright Name', 1, 'text', NULL, 0, 1),
(5, 'site_url', 'http://www.dclassifieds.eu', 'Site Url', 1, 'text', NULL, 0, 1),
(6, 'site_price_sign', '&euro;', 'Site Price Sign', 1, 'text', NULL, 0, 1),
(7, 'facebook_site_url', 'https://www.facebook.com/DClassifieds.eu/', 'Facebook Page Url', 1, 'text', NULL, 0, 1),
(8, 'home_page_seo_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit', 'Enter Seo Text For Homepage', 1, 'textarea', NULL, 0, 1),
(9, 'admin_list_num_items', '50', 'Num Items on Admin List Page', 1, 'text', NULL, 0, 1),
(10, 'admin_logo_name', '<b>DC</b>lassifieds', 'Admin Logo Name', 1, 'text', NULL, 0, 1),
(11, 'admin_short_logo_name', '<b>DC</b>', 'Admin Short Logo Name', 1, 'text', NULL, 0, 1),
(12, 'admin_skin', 'red', 'Admin Skin', 1, 'text', 'admin_skin', 0, 1),
(13, 'site_logo_img', '592_logo.png', 'Site Logo Image', 1, 'file', 'site_logo_image_info', 0, 0),
(14, 'site_logo_alt', NULL, 'Site Logo Alernate Text', 1, 'text', NULL, 0, 0),
(15, 'footer_html', '<div>Icons made by <a href="http://www.flaticon.com/authors/situ-herrera" title="Situ Herrera">Situ Herrera</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div>', 'Footer HTML', 1, 'textarea', NULL, 0, 0),
(16, 'head_scripts', NULL, 'Head Scripts', 1, 'textarea', 'head_scripts', 0, 0),
(17, 'end_body_scripts', NULL, 'Body/Footer Scripts', 1, 'textarea', 'end_body_scripts', 0, 0),
(18, 'start_body_scripts', '<div id="fb-root"></div>\r\n        <script>(function(d, s, id) {\r\n            var js, fjs = d.getElementsByTagName(s)[0];\r\n            if (d.getElementById(id)) return;\r\n            js = d.createElement(s); js.id = id;\r\n            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";\r\n            fjs.parentNode.insertBefore(js, fjs);\r\n        }(document, ''script'', ''facebook-jssdk''));</script>', 'Body Start Scripts', 1, 'textarea', 'start_body_scripts', 0, 0),
(19, 'num_promo_ads_home_page', '10', 'Num Promo Ads on Home page', 1, 'text', NULL, 0, 1),
(20, 'enable_new_ads_on_homepage', '1', 'Enable New/Latest Ads on Home page', 1, 'yesno', NULL, 0, 1),
(21, 'num_latest_ads_home_page', '12', 'Num New/Latest Ads on Home Page', 1, 'text', NULL, 0, 1),
(22, 'show_small_item_ads_list', '1', 'Show small ad item on home page and search', 1, 'yesno', NULL, 0, 1),
(23, 'num_promo_ads_list', '6', 'Num Promo ads on Ad List/Search', 1, 'text', NULL, 0, 1),
(24, 'num_ads_list', '24', 'Num Ads on Ad List/Search', 1, 'text', NULL, 0, 1),
(25, 'num_addition_ads_from_user', '4', 'Num Additions Ads From User', 1, 'text', 'Num Additions Ads From User', 0, 1),
(26, 'num_last_viewed_ads', '4', 'Num Ads In Last Viewed', 1, 'text', NULL, 0, 1),
(27, 'site_currency_code', 'EUR', 'Site Currency Code', 1, 'text', NULL, 0, 1),
(28, 'require_ad_image', '1', 'Require at least one image on ad publish', 1, 'yesno', NULL, 0, 1),
(29, 'ad_num_images', '5', 'Num Ad Images', 1, 'text', NULL, 0, 1),
(48, 'control_mail_edit_subject', '[CONTROL][EDIT] dclassifieds', 'Control Edit Mail Subject', 1, 'text', NULL, 0, 1),
(31, 'num_rows_ad_description_textarea', '10', 'Num Rows Ad Description Field', 1, 'text', NULL, 0, 1),
(32, 'ad_description_min_lenght', '50', 'Ad Description min Lenght in Words', 1, 'text', NULL, 0, 1),
(33, 'ad_image_max_size', '300', 'Ad image Max size in kb', 1, 'text', NULL, 0, 1),
(34, 'enable_link_in_ad', '1', 'Enable link in Ad', 1, 'yesno', NULL, 0, 1),
(35, 'enable_video_in_ad', '1', 'Enable video in Ad', 1, 'yesno', NULL, 0, 1),
(36, 'enable_dofollow_link', '0', 'Enable do follow link in ad', 1, 'yesno', NULL, 0, 1),
(37, 'enable_dofollow_link_promo', '1', 'Enable do follow link only in promo Ad', 1, 'yesno', NULL, 0, 1),
(38, 'privacy_policy_link', NULL, 'Privacy Policy Link', 1, 'text', NULL, 0, 1),
(39, 'enable_control_mails', '1', 'Send Control Mail On Publish/Edit Ad', 1, 'yesno', NULL, 0, 1),
(40, 'control_mail', 'admin@admin.com', 'Control Mail', 1, 'text', NULL, 0, 1),
(41, 'control_mail_subject', '[CONTROL] dclassifieds', 'Control Mail Subject', 1, 'text', NULL, 0, 1),
(42, 'ad_valid_period_in_days', '30', 'Ad Valid Period In Days', 1, 'text', NULL, 0, 1),
(43, 'site_contact_mail', 'admin@admin.com', 'Site Contact Mail', 1, 'text', NULL, 0, 1),
(44, 'enable_promo_ads', '1', 'Enable Promo Ads', 1, 'yesno', NULL, 0, 1),
(45, 'site_metric_system', 'sq. m.', 'Site Metric System', 1, 'text', NULL, 0, 1),
(46, 'wallet_promo_ad_price', '4.60', 'Promo Ad Price when payed from wallet', 1, 'text', NULL, 0, 1),
(47, 'wallet_promo_ad_period', '7', 'Promo Ad Period in Days When payed from Wallet', 1, 'text', NULL, 0, 1),
(49, 'num_ads_on_myads', '30', 'Num Ads on My Ads List', 1, 'text', NULL, 0, 1),
(50, 'num_ads_user_list', '30', 'Num Ads on User Ads List', 1, 'text', NULL, 0, 1),
(51, 'mywallet_num_items', '30', 'My Wallet Num Items', 1, 'text', NULL, 0, 1),
(52, 'ad_contact_min_words', '20', 'Minimum Words in Ad Contact Field', 1, 'text', NULL, 0, 1),
(53, 'site_contact_min_words', '10', 'Minimum Words in Site Contact Field', 1, 'text', NULL, 0, 1),
(54, 'enable_recaptcha_site_contact', '0', 'Enable reCaptcha for Site Contact Page', 1, 'yesno', 'recaptcha_info', 0, 1),
(55, 'recaptcha_site_key', '', 'reCaptcha Site Key', 1, 'text', 'recaptcha_info', 0, 0),
(56, 'recaptcha_secret_key', '', 'reCaptcha Secret Key', 1, 'text', 'recaptcha_info', 0, 0),
(57, 'enable_recaptcha_register', '0', 'Enable reCaptcha for Site Register Page', 1, 'yesno', 'recaptcha_info', 0, 1),
(58, 'enable_recaptcha_publish', '0', 'Enable reCaptcha for Site Publish Page', 1, 'yesno', NULL, 0, 1),
(59, 'recaptcha_lang', 'en', 'reCaptcha Language', 1, 'text', NULL, 0, 1),
(60, 'enable_recaptcha_ad_contact', '0', 'Enable reCaptcha for Ad Contact Page', 1, 'yesno', NULL, 0, 1),
(61, 'enable_facebook_login', '0', 'Enable Facebook Login', 1, 'yesno', NULL, 0, 1),
(62, 'facebook_app_client_id', '', 'Facebook App Client Id', 1, 'text', NULL, 0, 0),
(63, 'facebook_app_secret', '', 'Facebook App Client Secret', 1, 'text', NULL, 0, 0),
(64, 'enable_google_login', '0', 'Enable Google Login', 1, 'yesno', NULL, 0, 1),
(65, 'google_app_client_id', NULL, 'Google App Client Id', 1, 'text', NULL, 0, 0),
(66, 'google_app_secret', NULL, 'Google App Client Secret', 1, 'text', NULL, 0, 0),
(67, 'enable_twitter_login', '0', 'Enable Twitter Login', 1, 'yesno', NULL, 0, 1),
(68, 'twitter_app_client_id', NULL, 'Twitter App Client Id', 1, 'text', NULL, 0, 0),
(69, 'twitter_app_secret', NULL, 'Twitter App Client Secret', 1, 'text', NULL, 0, 0),
(70, 'enable_magic_keywords', '1', 'Enable Magic Keywords', 1, 'yesno', NULL, 0, 1),
(71, 'minimum_results_to_save_magic_keyword', '10', 'Minimum Results To Save Magic Keyword', 1, 'text', NULL, 0, 1),
(72, 'num_magic_keywords_to_show', '10', 'Num Magic Keywords to Show', 1, 'text', NULL, 0, 1),
(73, 'enable_bonus_on_ad_activation', '1', 'Enable Bonus on Ad Activation', 1, 'yesno', NULL, 0, 1),
(74, 'bonus_sum_on_ad_activation', '0.10', 'Bonus Sum On Ad Activation', 1, 'text', NULL, 0, 1),
(75, 'send_warning_mail_ad_expire', '5', 'Send Warning Mail Ad Will Expire Before Days', 1, 'text', NULL, 0, 1),
(76, 'num_mails_to_send_at_once', '200', 'How many Ad expire Warning mails to send at once', 1, 'text', 'how many mails to send at once on one script run', 0, 1),
(77, 'send_warning_mail_promo_expire', '2', 'Send Warning Mail Ad Promo Will Expire Before Days', 1, 'text', NULL, 0, 1),
(78, 'num_mails_to_send_at_once_promo_warning', '200', 'How many Promo Ad expire Warning mails to send at once', 1, 'text', 'how many promo expire mails to send at once on one script run', 0, 1),
(79, 'enable_rss', '1', 'Enable Rss', 1, 'yesno', NULL, 0, 1),
(80, 'rss_num_items', '100', 'Num items in Rss Feed', 1, 'text', NULL, 0, 1),
(81, 'rss_feed_description', 'the best rss feed', 'Rss Feed Description', 1, 'text', NULL, 0, 1),
(82, 'theme', 'basic', 'Theme', 1, 'text', NULL, 0, 1),
(83, 'cache_type', 'file', 'Cache Type', 1, 'text', 'cache_types_info', 0, 1),
(84, 'cache_prefix', 'dclassifieds', 'Cache Prefix', 1, 'text', 'cache_prefix_info', 0, 1),
(85, 'memcached_host', '127.0.0.1', 'Memcached host', 1, 'text', NULL, 0, 1),
(86, 'memcached_port', '11211', 'Memcached port', 1, 'text', NULL, 0, 1),
(87, 'memcached_weight', '100', 'Memcached weight', 1, 'text', NULL, 0, 1),
(88, 'mail_driver', 'mail', 'Mail driver', 1, 'text', 'mail_driver_info', 0, 1),
(89, 'mail_host', 'smtp.mailgun.org', 'Mail host', 1, 'text', NULL, 0, 1),
(90, 'mail_port', '587', 'Mail port', 1, 'text', NULL, 0, 1),
(91, 'mail_encryption', 'tls', 'Mail encryption', 1, 'text', NULL, 0, 1),
(92, 'mail_user', NULL, 'Mail user', 1, 'text', NULL, 0, 1),
(93, 'mail_password', NULL, 'Mail password', 1, 'text', NULL, 0, 1),
(94, 'app_env', 'production', 'Application Environment', 1, 'text', 'Application Environment info', 0, 1),
(95, 'app_debug', '1', 'Application Debug Mode', 1, 'yesno', 'Application Debug Mode info', 0, 1),
(96, 'api_key', 'T1RYgieja3iJnqzQVaVtQ0OM6yCb4444', 'Encryption Key', 1, 'text', 'Encryption Key info', 0, 1),
(97, 'app_locale', 'en', 'Site Language', 1, 'text', NULL, 0, 1),
(98, 'app_timezone', 'UTC', 'Timezone', 1, 'text', NULL, 0, 1),
(99, 'watermark', '', 'Watermark', 1, 'file', NULL, 0, 0),
(100, 'watermark_position', 'center', 'Watermark position', 1, 'text', 'Watermark position info', 0, 1),
(101, 'show_price_sign_before_price', '1', 'Show Price Sign Before Price', 1, 'yesno', NULL, 0, 1),
(102, 'enable_category_description_in_search', '0', 'Enable category description in search results', 1, 'yesno', NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shoes_size`
--

CREATE TABLE IF NOT EXISTS `shoes_size` (
  `shoes_size_id` int(11) NOT NULL AUTO_INCREMENT,
  `shoes_size_name` varchar(255) NOT NULL,
  `shoes_size_ord` int(11) NOT NULL,
  PRIMARY KEY (`shoes_size_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `shoes_size`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_activated` tinyint(4) DEFAULT '0',
  `user_activation_token` char(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_location_id` int(11) DEFAULT '0',
  `user_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_lat_lng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_site` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_user_email_unique` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `avatar`, `email`, `password`, `remember_token`, `user_activated`, `user_activation_token`, `user_location_id`, `user_phone`, `user_skype`, `user_address`, `user_lat_lng`, `user_site`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, 'admin@admin.com', '$2y$10$ijGqYTGg6MdHVcRElWfUdevL5.GwAe0hK1/93YgUVJitaJ0pdl/Gm', NULL, 1, 'h5r8ZOzXEO4xoFdlppKrv3r2j6LLyb', 0, NULL, NULL, NULL, NULL, NULL, 1, '2016-11-13 15:06:15', '2016-11-13 15:06:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_mail`
--

CREATE TABLE IF NOT EXISTS `user_mail` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_id` int(11) NOT NULL,
  `user_id_from` int(11) NOT NULL,
  `user_id_to` int(11) NOT NULL,
  `mail_text` text NOT NULL,
  `mail_date` datetime NOT NULL,
  `mail_hash` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`mail_id`),
  KEY `mail_hash` (`mail_hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_mail`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_mail_status`
--

CREATE TABLE IF NOT EXISTS `user_mail_status` (
  `mail_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mail_status` tinyint(4) NOT NULL,
  `mail_deleted` tinyint(4) DEFAULT '0',
  `mail_hash` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`mail_status_id`),
  KEY `mail_hash` (`mail_hash`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user_mail_status`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_social_account`
--

CREATE TABLE IF NOT EXISTS `user_social_account` (
  `user_id` int(11) NOT NULL,
  `provider_user_id` varchar(255) NOT NULL,
  `provider` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_social_account`
--


-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE IF NOT EXISTS `wallet` (
  `wallet_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `sum` double(8,2) NOT NULL,
  `wallet_date` datetime NOT NULL,
  `wallet_description` varchar(255) NOT NULL,
  PRIMARY KEY (`wallet_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `wallet`
--

