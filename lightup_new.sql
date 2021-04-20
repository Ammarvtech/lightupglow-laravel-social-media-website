-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2018 at 05:44 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lightup_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `comment_id` int(10) UNSIGNED NOT NULL,
  `like_user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`comment_id`, `like_user_id`, `created_at`, `updated_at`, `seen`) VALUES
(3, 1, '2018-05-01 05:05:13', '2018-05-01 05:05:13', 0),
(13, 1, NULL, NULL, 0),
(13, 5, NULL, NULL, 0),
(13, 121, NULL, NULL, 0),
(16, 1, '2018-03-22 15:20:40', '2018-03-22 15:20:40', 0),
(17, 1, '2018-03-22 13:49:11', '2018-03-22 13:49:11', 0),
(21, 1, '2018-03-22 13:49:12', '2018-03-22 13:49:12', 0),
(22, 1, '2018-03-22 13:48:46', '2018-03-22 13:48:46', 0),
(23, 1, '2018-03-22 13:49:18', '2018-03-22 13:49:18', 0),
(32, 1, '2018-03-22 14:57:12', '2018-03-22 14:57:12', 0),
(33, 1, '2018-03-22 14:57:12', '2018-03-22 14:57:12', 0),
(56, 121, '2018-04-02 10:28:17', '2018-04-02 10:28:17', 0),
(79, 1, '2018-04-03 10:19:40', '2018-04-03 10:19:40', 0),
(79, 121, '2018-04-03 10:19:56', '2018-04-03 10:19:56', 0),
(87, 1, '2018-04-03 10:20:26', '2018-04-03 10:20:26', 0),
(87, 121, '2018-04-03 10:20:40', '2018-04-03 10:20:40', 0),
(124, 1, '2018-04-12 04:42:21', '2018-04-12 04:42:21', 0),
(143, 1, '2018-04-18 01:20:52', '2018-04-18 01:20:52', 0),
(144, 121, '2018-04-17 07:50:37', '2018-04-17 07:50:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shortname` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `json` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `shortname`, `json`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '{\"country_id\":\"1\",\"insta1name\":\"251454156\",\"insta1\":\"56465\",\"insta2name\":\"4564\",\"insta2\":\"564\",\"insta3name\":\"564\",\"insta3\":\"56456\",\"insta4name\":\"465\",\"insta4\":\"465\",\"insta5name\":\"456\",\"insta5\":\"4564\",\"insta6name\":\"564\",\"insta6\":\"654\",\"fb1name\":\"564\",\"fb1\":\"564\",\"fb2name\":\"564\",\"fb2\":\"564\",\"fb3name\":\"132\",\"fb3\":\"1\",\"fb4name\":\"651\",\"fb4\":\"654\",\"fb5name\":\"564\",\"fb5\":\"654\",\"fb6name\":\"651\",\"fb6\":\"654\",\"twi1name\":\"654\",\"twi1\":\"564\",\"twi2name\":\"56\",\"twi2\":\"65456\",\"twi3name\":\"465\",\"twi3\":\"465\",\"twi4name\":\"6\",\"twi4\":\"4564\",\"twi5name\":\"654\",\"twi5\":\"654\",\"twi6name\":\"64\",\"twi6\":\"654\",\"you1name\":\"654\",\"you1\":\"654\",\"you2name\":\"5645\",\"you2\":\"64\",\"you3name\":\"654\",\"you3\":\"\",\"you4name\":\"4\",\"you4\":\"5645\",\"you5name\":\"6465\",\"you5\":\"465\",\"you6name\":\"465\",\"you6\":\"\"}'),
(2, '&Aring;land', 'AX', 'ALA', NULL),
(3, 'Albania', 'AL', 'ALB', NULL),
(4, 'Algeria', 'DZ', 'DZA', '{\"country_id\":\"4\",\"insta1name\":\"1\",\"insta1\":\"2\",\"insta2name\":\"3\",\"insta2\":\"4\",\"insta3name\":\"5\",\"insta3\":\"6\",\"insta4name\":\"7\",\"insta4\":\"8\",\"insta5name\":\"9\",\"insta5\":\"1\",\"insta6name\":\"2\",\"insta6\":\"3\",\"fb1name\":\"4\",\"fb1\":\"5\",\"fb2name\":\"6\",\"fb2\":\"7\",\"fb3name\":\"8\",\"fb3\":\"9\",\"fb4name\":\"4\",\"fb4\":\"25\",\"fb5name\":\"4\",\"fb5\":\"654\",\"fb6name\":\"654\",\"fb6\":\"654\",\"twi1name\":\"65465\",\"twi1\":\"4654654\",\"twi2name\":\"65464\",\"twi2\":\"654\",\"twi3name\":\"654\",\"twi3\":\"65\",\"twi4name\":\"651\",\"twi4\":\"561\",\"twi5name\":\"64\",\"twi5\":\"564\",\"twi6name\":\"651\",\"twi6\":\"6165\",\"you1name\":\"165\",\"you1\":\"1651\",\"you2name\":\"306516546465465654654654666514\",\"you2\":\"65\",\"you3name\":\"654\",\"you3\":\"651\",\"you4name\":\"6516516516516\",\"you4\":\"1651\",\"you5name\":\"651\",\"you5\":\"65165\",\"you6name\":\"1651\",\"you6\":\"6151\"}'),
(5, 'American Samoa', 'AS', 'ASM', NULL),
(6, 'Andorra', 'AD', 'AND', NULL),
(7, 'Angola', 'AO', 'AGO', NULL),
(8, 'Anguilla', 'AI', 'AIA', NULL),
(9, 'Antarctica', 'AQ', 'ATA', NULL),
(10, 'Antigua and Barbuda', 'AG', 'ATG', NULL),
(11, 'Argentina', 'AR', 'ARG', NULL),
(12, 'Armenia', 'AM', 'ARM', NULL),
(13, 'Aruba', 'AW', 'ABW', NULL),
(14, 'Australia', 'AU', 'AUS', NULL),
(15, 'Austria', 'AT', 'AUT', NULL),
(16, 'Azerbaijan', 'AZ', 'AZE', NULL),
(17, 'Bahamas', 'BS', 'BHS', NULL),
(18, 'Bahrain', 'BH', 'BHR', NULL),
(19, 'Bangladesh', 'BD', 'BGD', NULL),
(20, 'Barbados', 'BB', 'BRB', NULL),
(21, 'Belarus', 'BY', 'BLR', NULL),
(22, 'Belgium', 'BE', 'BEL', NULL),
(23, 'Belize', 'BZ', 'BLZ', NULL),
(24, 'Benin', 'BJ', 'BEN', NULL),
(25, 'Bermuda', 'BM', 'BMU', NULL),
(26, 'Bhutan', 'BT', 'BTN', NULL),
(27, 'Bolivia', 'BO', 'BOL', NULL),
(28, 'Bonaire', 'BQ', 'BES', NULL),
(29, 'Bosnia and Herzegovina', 'BA', 'BIH', NULL),
(30, 'Botswana', 'BW', 'BWA', NULL),
(31, 'Bouvet Island', 'BV', 'BVT', NULL),
(32, 'Brazil', 'BR', 'BRA', NULL),
(33, 'British Indian Ocean Territory', 'IO', 'IOT', NULL),
(34, 'British Virgin Islands', 'VG', 'VGB', NULL),
(35, 'Brunei', 'BN', 'BRN', NULL),
(36, 'Bulgaria', 'BG', 'BGR', NULL),
(37, 'Burkina Faso', 'BF', 'BFA', NULL),
(38, 'Burundi', 'BI', 'BDI', NULL),
(39, 'Cambodia', 'KH', 'KHM', NULL),
(40, 'Cameroon', 'CM', 'CMR', NULL),
(41, 'Canada', 'CA', 'CAN', NULL),
(42, 'Cape Verde', 'CV', 'CPV', NULL),
(43, 'Cayman Islands', 'KY', 'CYM', NULL),
(44, 'Central African Republic', 'CF', 'CAF', NULL),
(45, 'Chad', 'TD', 'TCD', NULL),
(46, 'Chile', 'CL', 'CHL', NULL),
(47, 'China', 'CN', 'CHN', NULL),
(48, 'Christmas Island', 'CX', 'CXR', NULL),
(49, 'Cocos [Keeling] Islands', 'CC', 'CCK', NULL),
(50, 'Colombia', 'CO', 'COL', NULL),
(51, 'Comoros', 'KM', 'COM', NULL),
(52, 'Cook Islands', 'CK', 'COK', NULL),
(53, 'Costa Rica', 'CR', 'CRI', NULL),
(54, 'Croatia', 'HR', 'HRV', NULL),
(55, 'Cuba', 'CU', 'CUB', NULL),
(56, 'Curacao', 'CW', 'CUW', NULL),
(57, 'Cyprus', 'CY', 'CYP', NULL),
(58, 'Czech Republic', 'CZ', 'CZE', NULL),
(59, 'Democratic Republic of the Congo', 'CD', 'COD', NULL),
(60, 'Denmark', 'DK', 'DNK', NULL),
(61, 'Djibouti', 'DJ', 'DJI', NULL),
(62, 'Dominica', 'DM', 'DMA', NULL),
(63, 'Dominican Republic', 'DO', 'DOM', NULL),
(64, 'East Timor', 'TL', 'TLS', NULL),
(65, 'Ecuador', 'EC', 'ECU', NULL),
(66, 'Egypt', 'EG', 'EGY', NULL),
(67, 'El Salvador', 'SV', 'SLV', NULL),
(68, 'Equatorial Guinea', 'GQ', 'GNQ', NULL),
(69, 'Eritrea', 'ER', 'ERI', NULL),
(70, 'Estonia', 'EE', 'EST', NULL),
(71, 'Ethiopia', 'ET', 'ETH', NULL),
(72, 'Falkland Islands', 'FK', 'FLK', NULL),
(73, 'Faroe Islands', 'FO', 'FRO', NULL),
(74, 'Fiji', 'FJ', 'FJI', NULL),
(75, 'Finland', 'FI', 'FIN', NULL),
(76, 'France', 'FR', 'FRA', NULL),
(77, 'French Guiana', 'GF', 'GUF', NULL),
(78, 'French Polynesia', 'PF', 'PYF', NULL),
(79, 'French Southern Territories', 'TF', 'ATF', NULL),
(80, 'Gabon', 'GA', 'GAB', NULL),
(81, 'Gambia', 'GM', 'GMB', NULL),
(82, 'Georgia', 'GE', 'GEO', NULL),
(83, 'Germany', 'DE', 'DEU', NULL),
(84, 'Ghana', 'GH', 'GHA', NULL),
(85, 'Gibraltar', 'GI', 'GIB', NULL),
(86, 'Greece', 'GR', 'GRC', NULL),
(87, 'Greenland', 'GL', 'GRL', NULL),
(88, 'Grenada', 'GD', 'GRD', NULL),
(89, 'Guadeloupe', 'GP', 'GLP', NULL),
(90, 'Guam', 'GU', 'GUM', NULL),
(91, 'Guatemala', 'GT', 'GTM', NULL),
(92, 'Guernsey', 'GG', 'GGY', NULL),
(93, 'Guinea', 'GN', 'GIN', NULL),
(94, 'Guinea-Bissau', 'GW', 'GNB', NULL),
(95, 'Guyana', 'GY', 'GUY', NULL),
(96, 'Haiti', 'HT', 'HTI', NULL),
(97, 'Heard Island and McDonald Islands', 'HM', 'HMD', NULL),
(98, 'Honduras', 'HN', 'HND', NULL),
(99, 'Hong Kong', 'HK', 'HKG', NULL),
(100, 'Hungary', 'HU', 'HUN', NULL),
(101, 'Iceland', 'IS', 'ISL', NULL),
(102, 'India', 'IN', 'IND', '{\"country_id\":\"102\",\"insta1name\":\"cute relationship\",\"insta1\":\"sexymidnights\",\"insta2name\":\"Love\",\"insta2\":\"love_is_forever_life\",\"insta3name\":\"cute\",\"insta3\":\"_cute_fantasy\",\"insta4name\":\"Couple\",\"insta4\":\"couplegoals\",\"insta5name\":\"the\",\"insta5\":\"cutest_conversations\",\"insta6name\":\"relationship\",\"insta6\":\"_cute._.relationship_\",\"fb1name\":\"my love\",\"fb1\":\"myloveloveforever\",\"fb2name\":\"lavi\",\"fb2\":\"LOVE-79261534203\",\"fb3name\":\"lovim\",\"fb3\":\"laviyou\",\"fb4name\":\"loveispart\",\"fb4\":\"Loveispartoflifeashu\",\"fb5name\":\"team\",\"fb5\":\"teamwelove\",\"fb6name\":\"like\",\"fb6\":\"LikeLoveQuotes\",\"twi1name\":\"court\",\"twi1\":\"Courtney\",\"twi2name\":\"love\",\"twi2\":\"love\",\"twi3name\":\"my sotore\",\"twi3\":\"MzFlame_86\",\"twi4name\":\"i am\",\"twi4\":\"iamErica_Mena\",\"twi5name\":\"domein\",\"twi5\":\"DonnieWahlberg\",\"twi6name\":\"virat\",\"twi6\":\"VirzhaIDOL8\",\"you1name\":\"tera yar\",\"you1\":\"UCr7g6Tho6plOiPncqkVmTng\",\"you2name\":\"char bagadi\",\"you2\":\"UCuw_xLM0MZGLh0I7ja7Ksig\",\"you3name\":\"rona ser ma\",\"you3\":\"UCaBSZni0Q5JF__Ipkahcvkg\",\"you4name\":\"ma tara ashiwad\",\"you4\":\"UC1D8u_swQoWAz04d_5pr5aw\",\"you5name\":\"janu tu mari nahi\",\"you5\":\"UC6wE1QldDPmYWwGyuudy3Tg\",\"you6name\":\"rat gai bat gai\",\"you6\":\"UCJZ57R_fVWX1RHSQ9IogICw\"}'),
(103, 'Indonesia', 'ID', 'IDN', NULL),
(104, 'Iran', 'IR', 'IRN', NULL),
(105, 'Iraq', 'IQ', 'IRQ', NULL),
(106, 'Ireland', 'IE', 'IRL', NULL),
(107, 'Isle of Man', 'IM', 'IMN', NULL),
(108, 'Israel', 'IL', 'ISR', NULL),
(109, 'Italy', 'IT', 'ITA', NULL),
(110, 'Ivory Coast', 'CI', 'CIV', NULL),
(111, 'Jamaica', 'JM', 'JAM', NULL),
(112, 'Japan', 'JP', 'JPN', NULL),
(113, 'Jersey', 'JE', 'JEY', NULL),
(114, 'Jordan', 'JO', 'JOR', NULL),
(115, 'Kazakhstan', 'KZ', 'KAZ', NULL),
(116, 'Kenya', 'KE', 'KEN', NULL),
(117, 'Kiribati', 'KI', 'KIR', NULL),
(118, 'Kosovo', 'XK', 'XKX', NULL),
(119, 'Kuwait', 'KW', 'KWT', NULL),
(120, 'Kyrgyzstan', 'KG', 'KGZ', NULL),
(121, 'Laos', 'LA', 'LAO', NULL),
(122, 'Latvia', 'LV', 'LVA', NULL),
(123, 'Lebanon', 'LB', 'LBN', NULL),
(124, 'Lesotho', 'LS', 'LSO', NULL),
(125, 'Liberia', 'LR', 'LBR', NULL),
(126, 'Libya', 'LY', 'LBY', NULL),
(127, 'Liechtenstein', 'LI', 'LIE', NULL),
(128, 'Lithuania', 'LT', 'LTU', NULL),
(129, 'Luxembourg', 'LU', 'LUX', NULL),
(130, 'Macao', 'MO', 'MAC', NULL),
(131, 'Macedonia', 'MK', 'MKD', NULL),
(132, 'Madagascar', 'MG', 'MDG', NULL),
(133, 'Malawi', 'MW', 'MWI', NULL),
(134, 'Malaysia', 'MY', 'MYS', NULL),
(135, 'Maldives', 'MV', 'MDV', NULL),
(136, 'Mali', 'ML', 'MLI', NULL),
(137, 'Malta', 'MT', 'MLT', NULL),
(138, 'Marshall Islands', 'MH', 'MHL', NULL),
(139, 'Martinique', 'MQ', 'MTQ', NULL),
(140, 'Mauritania', 'MR', 'MRT', NULL),
(141, 'Mauritius', 'MU', 'MUS', NULL),
(142, 'Mayotte', 'YT', 'MYT', NULL),
(143, 'Mexico', 'MX', 'MEX', NULL),
(144, 'Micronesia', 'FM', 'FSM', NULL),
(145, 'Moldova', 'MD', 'MDA', NULL),
(146, 'Monaco', 'MC', 'MCO', NULL),
(147, 'Mongolia', 'MN', 'MNG', NULL),
(148, 'Montenegro', 'ME', 'MNE', NULL),
(149, 'Montserrat', 'MS', 'MSR', NULL),
(150, 'Morocco', 'MA', 'MAR', NULL),
(151, 'Mozambique', 'MZ', 'MOZ', NULL),
(152, 'Myanmar [Burma]', 'MM', 'MMR', NULL),
(153, 'Namibia', 'NA', 'NAM', NULL),
(154, 'Nauru', 'NR', 'NRU', NULL),
(155, 'Nepal', 'NP', 'NPL', NULL),
(156, 'Netherlands', 'NL', 'NLD', NULL),
(157, 'New Caledonia', 'NC', 'NCL', NULL),
(158, 'New Zealand', 'NZ', 'NZL', NULL),
(159, 'Nicaragua', 'NI', 'NIC', NULL),
(160, 'Niger', 'NE', 'NER', NULL),
(161, 'Nigeria', 'NG', 'NGA', NULL),
(162, 'Niue', 'NU', 'NIU', NULL),
(163, 'Norfolk Island', 'NF', 'NFK', NULL),
(164, 'North Korea', 'KP', 'PRK', NULL),
(165, 'Northern Mariana Islands', 'MP', 'MNP', NULL),
(166, 'Norway', 'NO', 'NOR', NULL),
(167, 'Oman', 'OM', 'OMN', NULL),
(168, 'Pakistan', 'PK', 'PAK', NULL),
(169, 'Palau', 'PW', 'PLW', NULL),
(170, 'Palestine', 'PS', 'PSE', NULL),
(171, 'Panama', 'PA', 'PAN', NULL),
(172, 'Papua New Guinea', 'PG', 'PNG', NULL),
(173, 'Paraguay', 'PY', 'PRY', NULL),
(174, 'Peru', 'PE', 'PER', NULL),
(175, 'Philippines', 'PH', 'PHL', NULL),
(176, 'Pitcairn Islands', 'PN', 'PCN', NULL),
(177, 'Poland', 'PL', 'POL', NULL),
(178, 'Portugal', 'PT', 'PRT', NULL),
(179, 'Puerto Rico', 'PR', 'PRI', NULL),
(180, 'Qatar', 'QA', 'QAT', NULL),
(181, 'Republic of the Congo', 'CG', 'COG', NULL),
(182, 'Réunion', 'RE', 'REU', NULL),
(183, 'Romania', 'RO', 'ROU', NULL),
(184, 'Russia', 'RU', 'RUS', NULL),
(185, 'Rwanda', 'RW', 'RWA', NULL),
(186, 'Saint Barthélemy', 'BL', 'BLM', NULL),
(187, 'Saint Helena', 'SH', 'SHN', NULL),
(188, 'Saint Kitts and Nevis', 'KN', 'KNA', NULL),
(189, 'Saint Lucia', 'LC', 'LCA', NULL),
(190, 'Saint Martin', 'MF', 'MAF', NULL),
(191, 'Saint Pierre and Miquelon', 'PM', 'SPM', NULL),
(192, 'Saint Vincent and the Grenadines', 'VC', 'VCT', NULL),
(193, 'Samoa', 'WS', 'WSM', NULL),
(194, 'San Marino', 'SM', 'SMR', NULL),
(195, 'São Tomé and Príncipe', 'ST', 'STP', NULL),
(196, 'Saudi Arabia', 'SA', 'SAU', NULL),
(197, 'Senegal', 'SN', 'SEN', NULL),
(198, 'Serbia', 'RS', 'SRB', NULL),
(199, 'Seychelles', 'SC', 'SYC', NULL),
(200, 'Sierra Leone', 'SL', 'SLE', NULL),
(201, 'Singapore', 'SG', 'SGP', NULL),
(202, 'Sint Maarten', 'SX', 'SXM', NULL),
(203, 'Slovakia', 'SK', 'SVK', NULL),
(204, 'Slovenia', 'SI', 'SVN', NULL),
(205, 'Solomon Islands', 'SB', 'SLB', NULL),
(206, 'Somalia', 'SO', 'SOM', NULL),
(207, 'South Africa', 'ZA', 'ZAF', NULL),
(208, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', NULL),
(209, 'South Korea', 'KR', 'KOR', NULL),
(210, 'South Sudan', 'SS', 'SSD', NULL),
(211, 'Spain', 'ES', 'ESP', NULL),
(212, 'Sri Lanka', 'LK', 'LKA', NULL),
(213, 'Sudan', 'SD', 'SDN', NULL),
(214, 'Suriname', 'SR', 'SUR', NULL),
(215, 'Svalbard and Jan Mayen', 'SJ', 'SJM', NULL),
(216, 'Swaziland', 'SZ', 'SWZ', NULL),
(217, 'Sweden', 'SE', 'SWE', NULL),
(218, 'Switzerland', 'CH', 'CHE', NULL),
(219, 'Syria', 'SY', 'SYR', NULL),
(220, 'Taiwan', 'TW', 'TWN', NULL),
(221, 'Tajikistan', 'TJ', 'TJK', NULL),
(222, 'Tanzania', 'TZ', 'TZA', NULL),
(223, 'Thailand', 'TH', 'THA', NULL),
(224, 'Togo', 'TG', 'TGO', NULL),
(225, 'Tokelau', 'TK', 'TKL', NULL),
(226, 'Tonga', 'TO', 'TON', NULL),
(227, 'Trinidad and Tobago', 'TT', 'TTO', NULL),
(228, 'Tunisia', 'TN', 'TUN', NULL),
(229, 'Turkey', 'TR', 'TUR', NULL),
(230, 'Turkmenistan', 'TM', 'TKM', NULL),
(231, 'Turks and Caicos Islands', 'TC', 'TCA', NULL),
(232, 'Tuvalu', 'TV', 'TUV', NULL),
(233, 'U.S. Minor Outlying Islands', 'UM', 'UMI', NULL),
(234, 'U.S. Virgin Islands', 'VI', 'VIR', NULL),
(235, 'Uganda', 'UG', 'UGA', NULL),
(236, 'Ukraine', 'UA', 'UKR', NULL),
(237, 'United Arab Emirates', 'AE', 'ARE', NULL),
(238, 'United Kingdom', 'GB', 'GBR', NULL),
(239, 'United States', 'US', 'USA', NULL),
(240, 'Uruguay', 'UY', 'URY', NULL),
(241, 'Uzbekistan', 'UZ', 'UZB', NULL),
(242, 'Vanuatu', 'VU', 'VUT', NULL),
(243, 'Vatican City', 'VA', 'VAT', NULL),
(244, 'Venezuela', 'VE', 'VEN', NULL),
(245, 'Vietnam', 'VN', 'VNM', NULL),
(246, 'Wallis and Futuna', 'WF', 'WLF', NULL),
(247, 'Western Sahara', 'EH', 'ESH', NULL),
(248, 'Yemen', 'YE', 'YEM', NULL),
(249, 'Zambia', 'ZM', 'ZMB', NULL),
(250, 'Zimbabwe', 'ZW', 'ZWE', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `hobby_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `hobby_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hobbies`
--

CREATE TABLE `hobbies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hobbies`
--

INSERT INTO `hobbies` (`id`, `name`) VALUES
(1, 'Reading'),
(2, 'Watching TV'),
(3, 'Family Time'),
(4, 'Going to Movies'),
(5, 'Fishing'),
(6, 'Computer'),
(7, 'Gardening'),
(8, 'Renting Movies'),
(9, 'Walking'),
(10, 'Exercise'),
(11, 'Listening to Music'),
(12, 'Entertaining'),
(13, 'Hunting'),
(14, 'Team Sports'),
(15, 'Shopping'),
(16, 'Traveling'),
(17, 'Sleeping'),
(18, 'Socializing'),
(19, 'Sewing'),
(20, 'Golf'),
(21, 'Church Activities'),
(22, 'Relaxing'),
(23, 'Playing Music'),
(24, 'Housework'),
(25, 'Crafts'),
(26, 'Watching Sports'),
(27, 'Bicycling'),
(28, 'Playing Cards'),
(29, 'Hiking'),
(30, 'Cooking'),
(31, 'Eating Out'),
(32, 'Dating Online'),
(33, 'Swimming'),
(34, 'Camping'),
(35, 'Skiing'),
(36, 'Working on Cars'),
(37, 'Writing'),
(38, 'Boating'),
(39, 'Motorcycling'),
(40, 'Animal Care'),
(41, 'Bowling'),
(42, 'Painting'),
(43, 'Running'),
(44, 'Dancing'),
(45, 'Horseback Riding'),
(46, 'Tennis'),
(47, 'Theater'),
(48, 'Billiards'),
(49, 'Beach'),
(50, 'Volunteer Work');

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
(3, '2017_05_20_131345_update_users_table', 1),
(4, '2017_05_20_131839_create_user_direct_messages', 1),
(5, '2017_05_20_132515_create_user_following_table', 1),
(6, '2017_05_20_133038_create_countries', 1),
(7, '2017_05_20_133151_create_cities_table', 1),
(8, '2017_05_20_133406_create_hobbies_table', 1),
(9, '2017_05_20_133512_create_groups_table', 1),
(10, '2017_05_20_133707_create_user_hobbies_table', 1),
(11, '2017_05_20_133850_create_user_locations_table', 1),
(12, '2017_05_20_134119_create_posts_tables', 1),
(13, '2017_05_20_202256_update_users_table_2', 1),
(14, '2017_06_03_143218_update_users_table_3', 1),
(15, '2017_06_03_185756_update_user_locations_table', 1),
(16, '2017_06_06_182742_create_user_relationship_table', 1),
(17, '2017_06_08_181805_update_seen_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('pragnesh.2601@gmail.com', '$2y$10$VRw836P064NyxiFVh3D4Z.IYAuz9OKAnchZNMxEi0vwL4SQcpO69C', '2018-03-27 06:18:32'),
('modijaymin86@gmail.com', '$2y$10$OkhL4pDDBvxHNaA8YCsqTuHYVUqxopSYG0GIzei/93Bj6El9D2Ou.', '2018-03-30 07:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `has_image` tinyint(1) NOT NULL DEFAULT '0',
  `has_video` tinyint(1) NOT NULL DEFAULT '0',
  `has_attachment` tinyint(1) NOT NULL DEFAULT '0',
  `has_link` tinyint(1) NOT NULL DEFAULT '0',
  `has_shared` tinyint(1) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `group_id`, `has_image`, `has_video`, `has_attachment`, `has_link`, `has_shared`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, 0, 0, 0, 0, '', '2018-02-23 08:27:01', '2018-02-23 08:27:01'),
(2, 2, 0, 1, 0, 0, 0, 0, '', '2018-03-07 06:56:12', '2018-03-07 06:56:12'),
(5, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-08 05:58:52', '2018-03-08 05:58:52'),
(6, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-13 05:02:08', '2018-03-13 05:02:08'),
(7, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-13 06:00:45', '2018-03-13 06:00:45'),
(9, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-13 06:16:38', '2018-03-13 06:16:38'),
(11, 121, 0, 1, 0, 0, 0, 0, 'Hello Everyone,\r\n\r\nIts good to see you here...', '2018-03-19 08:51:20', '2018-03-19 08:51:20'),
(12, 121, 0, 1, 0, 0, 0, 0, 'hoiiii', '2018-03-21 06:28:47', '2018-03-21 06:28:47'),
(13, 1, 0, 1, 0, 0, 0, 0, 'Test', '2018-03-21 06:51:41', '2018-03-21 06:51:41'),
(14, 1, 0, 1, 0, 0, 0, 0, 'sssss', '2018-03-22 00:33:13', '2018-03-22 00:33:13'),
(15, 1, 0, 0, 0, 0, 0, 0, 'Hiiiiiiiii', '2018-03-22 03:52:24', '2018-03-22 03:52:24'),
(16, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 03:52:39', '2018-03-22 03:52:39'),
(19, 1, 0, 0, 0, 1, 0, 0, 'Doc', '2018-03-22 03:55:53', '2018-03-22 03:55:53'),
(35, 1, 0, 0, 1, 0, 0, 0, 'Hello', '2018-03-22 04:32:51', '2018-03-22 04:32:51'),
(37, 1, 0, 0, 1, 0, 0, 0, 'Dj Movie Super', '2018-03-22 05:40:52', '2018-03-22 05:40:52'),
(38, 1, 0, 0, 0, 1, 0, 0, 'Test File Upload', '2018-03-22 05:44:12', '2018-03-22 05:44:12'),
(39, 1, 0, 0, 0, 1, 0, 0, '', '2018-03-22 05:44:21', '2018-03-22 05:44:21'),
(40, 1, 0, 0, 0, 1, 0, 0, 'Testing ', '2018-03-22 05:44:28', '2018-03-22 05:44:28'),
(41, 1, 0, 0, 0, 1, 0, 0, 'Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello Hello ', '2018-03-22 05:44:34', '2018-03-22 05:44:34'),
(42, 1, 0, 0, 0, 1, 0, 0, '', '2018-03-22 05:57:36', '2018-03-22 05:57:36'),
(49, 2, 0, 0, 0, 1, 0, 0, '', '2018-03-22 07:03:15', '2018-03-22 07:03:15'),
(51, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:23:42', '2018-03-22 07:23:42'),
(52, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:23:50', '2018-03-22 07:23:50'),
(53, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:23:56', '2018-03-22 07:23:56'),
(54, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:24:01', '2018-03-22 07:24:01'),
(55, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:24:06', '2018-03-22 07:24:06'),
(56, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:24:21', '2018-03-22 07:24:21'),
(57, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:24:24', '2018-03-22 07:24:24'),
(58, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:24:27', '2018-03-22 07:24:27'),
(59, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:24:30', '2018-03-22 07:24:30'),
(62, 1, 0, 1, 0, 0, 0, 0, '', '2018-03-22 07:24:39', '2018-04-10 05:51:33'),
(68, 2, 0, 0, 0, 0, 0, 0, 'hiiiii test?????', '2018-03-22 09:08:20', '2018-03-22 09:08:20'),
(69, 2, 0, 1, 0, 0, 0, 0, 'test demo', '2018-03-22 09:08:38', '2018-03-22 09:08:38'),
(70, 2, 0, 0, 0, 0, 0, 0, 'test', '2018-03-22 09:09:06', '2018-03-22 09:09:06'),
(71, 2, 0, 0, 0, 0, 0, 0, 'test', '2018-03-22 09:09:28', '2018-03-22 09:09:28'),
(72, 2, 0, 0, 1, 0, 0, 0, 'test', '2018-03-22 09:10:53', '2018-03-22 09:10:53'),
(73, 2, 0, 0, 0, 1, 0, 0, 'ddd', '2018-03-22 09:11:19', '2018-03-22 09:11:19'),
(76, 121, 0, 0, 0, 0, 1, 0, '', '2018-03-23 07:54:24', '2018-03-23 07:54:24'),
(77, 121, 0, 0, 0, 0, 1, 0, '', '2018-03-23 07:56:25', '2018-03-23 07:56:25'),
(78, 121, 0, 0, 0, 0, 1, 0, '', '2018-03-23 08:10:17', '2018-03-23 08:10:17'),
(79, 121, 0, 0, 0, 0, 1, 0, '', '2018-03-23 08:14:59', '2018-03-23 08:14:59'),
(92, 1, 0, 0, 0, 0, 1, 0, '123456http://lillkjglhkghtupglobal.dev.com/post/92#tab_3-33', '2018-04-04 03:16:21', '2018-04-10 06:54:34'),
(94, 1, 0, 0, 0, 0, 0, 1, 'Nice Link >>>>!', '2018-04-04 04:19:18', '2018-04-04 04:19:18'),
(95, 1, 0, 0, 0, 0, 0, 1, 'nice....!', '2018-04-04 04:19:47', '2018-04-04 04:19:47'),
(96, 1, 0, 0, 0, 0, 0, 1, 'REmove THis... !', '2018-04-04 04:21:15', '2018-04-04 04:21:15'),
(97, 123, 0, 0, 0, 0, 0, 0, 'Hie People...!', '2018-04-06 07:00:29', '2018-04-06 07:00:29'),
(98, 1, 0, 0, 0, 0, 0, 0, 'Oye', '2018-04-07 01:14:14', '2018-04-07 01:14:14'),
(101, 1, 0, 0, 0, 0, 0, 0, 'HHHiii', '2018-04-10 06:59:02', '2018-04-10 06:59:02'),
(102, 1, 0, 1, 0, 0, 0, 0, '555511sjk1j', '2018-04-10 06:59:14', '2018-04-11 07:18:49'),
(103, 1, 0, 1, 0, 0, 0, 0, 'Video :)12jl\'yk', '2018-04-10 06:59:30', '2018-04-11 09:12:02'),
(104, 1, 0, 0, 0, 0, 0, 0, '123456dfgdckghjjjyyyjk', '2018-04-10 06:59:40', '2018-04-17 04:46:05'),
(105, 1, 0, 0, 0, 0, 0, 0, '123456ggys;f3jg', '2018-04-10 06:59:48', '2018-04-11 09:01:41'),
(107, 1, 0, 1, 0, 0, 0, 0, ';;;;jk', '2018-04-11 07:18:49', '2018-04-11 09:10:43'),
(108, 1, 0, 1, 0, 0, 0, 0, 'o', '2018-04-11 07:21:42', '2018-04-11 09:10:36'),
(109, 1, 0, 1, 0, 0, 0, 0, '', '2018-04-11 07:25:12', '2018-04-11 07:25:12'),
(110, 1, 0, 1, 0, 0, 0, 0, 'ggg;kl', '2018-04-11 07:26:34', '2018-04-11 09:10:22'),
(111, 1, 0, 0, 0, 0, 0, 0, 'hgkhjk', '2018-04-11 09:12:11', '2018-04-11 09:12:15'),
(112, 1, 0, 1, 0, 0, 0, 0, '333', '2018-04-11 09:12:19', '2018-04-17 04:42:15'),
(113, 1, 0, 1, 0, 0, 0, 0, 'jjjj', '2018-04-13 05:53:41', '2018-04-13 06:47:36'),
(114, 1, 0, 1, 0, 0, 0, 0, '123', '2018-04-13 06:34:29', '2018-04-17 04:42:02'),
(115, 1, 0, 0, 0, 0, 0, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2018-04-13 06:54:05', '2018-04-13 06:54:05'),
(116, 1, 0, 0, 0, 0, 0, 0, 'What is Lorem Ipsum?\r\nLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2018-04-13 07:02:55', '2018-04-13 07:02:55'),
(117, 1, 0, 0, 0, 0, 0, 0, 'hi\r\n\r\nhii\r\n\r\nhii\r\n\r\nhii', '2018-04-13 07:03:35', '2018-04-13 07:03:35'),
(118, 1, 0, 0, 0, 0, 0, 0, '<b><i><u>Hello</u>', '2018-04-13 09:13:13', '2018-04-17 04:41:33'),
(119, 1, 0, 0, 0, 0, 0, 1, '', '2018-04-20 08:15:02', '2018-04-20 08:15:02'),
(120, 1, 0, 1, 0, 0, 0, 0, '', '2018-04-24 05:40:09', '2018-04-24 05:40:09'),
(123, 1, 0, 0, 1, 0, 0, 0, '', '2018-04-24 06:59:30', '2018-04-24 06:59:30'),
(124, 1, 0, 0, 1, 0, 0, 0, '', '2018-04-24 07:42:13', '2018-04-24 07:42:13'),
(129, 1, 0, 0, 0, 0, 1, 0, '', '2018-04-28 02:06:24', '2018-04-28 02:06:24'),
(130, 1, 0, 0, 0, 0, 1, 0, '', '2018-05-01 05:24:10', '2018-05-01 05:24:10'),
(131, 1, 0, 0, 1, 0, 0, 0, '', '2018-05-01 05:56:55', '2018-05-01 05:56:55'),
(132, 1, 0, 0, 1, 0, 0, 0, '', '2018-05-01 06:59:32', '2018-05-01 06:59:32'),
(133, 1, 0, 0, 1, 0, 0, 0, '', '2018-05-01 06:59:47', '2018-05-01 06:59:47'),
(134, 1, 0, 0, 1, 0, 0, 0, '', '2018-05-01 07:00:02', '2018-05-01 07:00:02'),
(135, 1, 0, 0, 1, 0, 0, 0, '', '2018-05-01 07:00:16', '2018-05-01 07:00:16'),
(136, 1, 0, 0, 1, 0, 0, 0, '', '2018-05-01 07:00:59', '2018-05-01 07:00:59'),
(137, 1, 0, 0, 1, 0, 0, 0, '', '2018-05-01 07:05:12', '2018-05-01 07:05:12'),
(139, 1, 0, 0, 0, 0, 1, 0, '', '2018-05-01 07:07:54', '2018-05-01 07:07:54'),
(140, 1, 0, 0, 0, 0, 1, 0, '', '2018-05-01 07:08:29', '2018-05-01 07:08:29'),
(141, 1, 0, 0, 0, 0, 1, 0, '', '2018-05-01 07:10:04', '2018-05-01 07:10:04'),
(142, 1, 0, 0, 0, 0, 1, 0, '', '2018-05-01 07:10:32', '2018-05-01 07:10:32'),
(143, 1, 0, 0, 0, 0, 1, 0, '', '2018-05-01 07:11:17', '2018-05-01 07:11:17'),
(144, 121, 0, 0, 0, 0, 0, 0, 'Nice One', '2018-05-02 02:11:47', '2018-05-02 02:11:47'),
(145, 1, 0, 1, 0, 0, 0, 0, '', '2018-05-11 08:42:54', '2018-05-11 08:42:54'),
(146, 1, 0, 1, 0, 0, 0, 0, '', '2018-05-11 08:42:59', '2018-05-11 08:42:59'),
(147, 1, 0, 1, 0, 0, 0, 0, '', '2018-05-11 08:43:03', '2018-05-11 08:43:03'),
(148, 1, 0, 1, 0, 0, 0, 0, '', '2018-05-11 10:28:23', '2018-05-11 10:28:23'),
(149, 1, 0, 1, 0, 0, 0, 0, '', '2018-05-11 10:29:32', '2018-05-11 10:29:32'),
(150, 1, 0, 1, 0, 0, 0, 0, '', '2018-05-11 10:30:20', '2018-05-11 10:30:20'),
(151, 1, 0, 0, 0, 1, 0, 0, '', '2018-05-17 08:27:27', '2018-05-17 08:27:27'),
(152, 1, 0, 0, 0, 1, 0, 0, '', '2018-05-17 08:29:00', '2018-05-17 08:29:00'),
(153, 1, 0, 0, 0, 1, 0, 0, '', '2018-05-17 08:29:27', '2018-05-17 08:29:27'),
(154, 1, 0, 0, 0, 1, 0, 0, '', '2018-05-17 08:29:49', '2018-05-17 08:29:49'),
(155, 1, 0, 0, 0, 1, 0, 0, '', '2018-05-17 08:32:26', '2018-05-17 08:32:26'),
(156, 141, 0, 0, 0, 0, 0, 0, 'hii', '2018-05-18 00:15:39', '2018-05-18 00:15:39'),
(157, 141, 0, 1, 0, 0, 0, 0, '', '2018-05-18 00:57:21', '2018-05-18 00:57:21'),
(159, 141, 0, 0, 0, 0, 0, 1, 'hii', '2018-05-18 01:04:28', '2018-05-18 01:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `post_attachments`
--

CREATE TABLE `post_attachments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `attachment_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attachment_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Attachment'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_attachments`
--

INSERT INTO `post_attachments` (`id`, `post_id`, `attachment_path`, `attachment_name`) VALUES
(1, 19, 'f787e6034f732305524fc2238c22f860.pdf', 'Attachment'),
(2, 20, 'b6146e03703465c17bf0317aeb3b8aca.pdf', 'Attachment'),
(3, 21, 'b3efd7be74e0b486be05edc7c1422f1a.pdf', 'Attachment'),
(4, 22, '7e0acadacc7a88207ce190de15e1d3fa.pdf', 'Attachment'),
(5, 23, 'b4fef4a475b07ec04e6edb6eb63e8e76.pdf', 'Attachment'),
(6, 24, '40cd64d14fec472560e39aa0e406ef22.pdf', 'Attachment'),
(7, 25, '7d2a19fccbe01d65a6afbb5c6315d8f3.pdf', 'Attachment'),
(8, 26, '62d6c4215ce5fd77623e66a71db9502f.pdf', 'Attachment'),
(9, 38, '83dfa383fde11babf835cdb698d28927.txt', 'Attachment'),
(10, 39, '11a7448a19ca22014eeedc1c6c969c19.txt', 'Attachment'),
(11, 40, 'fcce3bc93e2a375d18e2cd4deb1270c9.txt', 'Attachment'),
(12, 41, '049fc25a9975574e07832956a09a3716.txt', 'Attachment'),
(13, 42, '8863a7c81609bbcf2032e5df7630cd77.sql', 'users.sql'),
(14, 43, '7aa6d341f954432a5626d1d650bd880f.txt', 'Show-original.txt'),
(15, 44, 'edf09af4b5ad595368c3780ef5c20fef.txt', '11a7448a19ca22014eeedc1c6c969c19.txt'),
(16, 45, 'f42c9b21bf620980c0eba694f9a67bfe.txt', '11a7448a19ca22014eeedc1c6c969c19.txt'),
(17, 46, '73a9361b5d4c15e2e247d84871c48ec2.txt', '11a7448a19ca22014eeedc1c6c969c19.txt'),
(18, 47, '78ea3b02bfce6aa58ec6b8f0c51d5c6f.txt', '11a7448a19ca22014eeedc1c6c969c19.txt'),
(19, 48, 'c857dcaf7288720ec0e2d6e8f17114ed.txt', '11a7448a19ca22014eeedc1c6c969c19.txt'),
(20, 49, 'e46a1d4df70dbb3e6f6b63212fac1505.txt', '11a7448a19ca22014eeedc1c6c969c19.txt'),
(21, 50, '10b82f6682c3b751bae517ea1fa114e0.txt', '11a7448a19ca22014eeedc1c6c969c19.txt'),
(22, 73, 'e4ce507031ba0854b1aeec05ad1e8926.docx', '5-2-18-amazon.docx'),
(23, 129, 'bb39748e0b4603714c5a1a39b9f3039a.txt', '049fc25a9975574e07832956a09a3716.txt'),
(24, 130, '41c870674ddc3edd93146d709dd5ecde.pdf', 'f787e6034f732305524fc2238c22f860.pdf'),
(25, 131, '5572264978217e272fe58b10ee62a740.pdf', 'f787e6034f732305524fc2238c22f860.pdf'),
(26, 132, '953677d10fea24cffc77763f0089a253.pdf', 'f787e6034f732305524fc2238c22f860.pdf'),
(27, 133, '23dc27162f05ffa1125913a3d2725897.pdf', 'f787e6034f732305524fc2238c22f860.pdf'),
(28, 134, 'e3e700136809547f8e509e96f25615e2.pdf', 'demo.pdf'),
(29, 135, '231d144e16ffcb0409b5f1ee907889bf.pdf', 'demo.pdf'),
(30, 136, '4af3391691b8fd828dc98f6eea0720e2.pdf', 'demo.pdf'),
(31, 137, '235576545da1ba7b2534185ef78d9e56.pdf', 'demo.pdf'),
(32, 151, '05a85c2aea4286e3f3de8fe0a0e6c2ab.log', 'ipmsg.log'),
(33, 152, 'c9bc82444ebb38fc2840482d21cedb22.pdf', 'demo.pdf'),
(34, 153, '88f1f998116ffae868fff61e7e39444e.pdf', 'demo.pdf'),
(35, 154, '8612d88c32a44c19c2c8e64bcb7c5644.log', 'ipmsg.log'),
(36, 155, '6ab2c69d2f727f4e84188494c04b18ad.pdf', 'demo.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `comment_user_id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_id`, `parent_id`, `comment_user_id`, `comment`, `created_at`, `updated_at`, `seen`) VALUES
(1, 1, NULL, 1, 'hii', '2018-02-23 08:29:03', '2018-04-17 07:04:06', 1),
(2, 1, NULL, 2, 'super', '2018-03-07 06:56:29', '2018-04-17 07:04:06', 1),
(3, 2, NULL, 1, 'dd', '2018-03-08 03:25:04', '2018-03-08 03:25:04', 0),
(4, 1, NULL, 1, 'supper se uppper', '2018-03-11 10:58:45', '2018-04-17 07:04:06', 1),
(5, 1, NULL, 1, 'Nice Click', '2018-03-11 10:58:53', '2018-04-17 07:04:06', 1),
(11, 5, NULL, 1, 'ff', '2018-03-22 06:15:22', '2018-05-01 05:20:44', 1),
(12, 11, NULL, 121, 'lkk', '2018-03-22 06:19:37', '2018-05-01 10:05:48', 1),
(14, 73, NULL, 1, 'Hello AGain', '2018-03-22 10:59:25', '2018-05-02 04:10:42', 1),
(15, 73, NULL, 1, 'Hello12', '2018-03-22 11:05:38', '2018-05-02 04:10:42', 1),
(17, 73, 15, 1, 'VIsh', '2018-03-22 11:57:47', '2018-05-02 04:10:42', 1),
(19, 73, 13, 1, 'hfghgfh', '2018-03-22 12:02:29', '2018-05-02 04:10:42', 1),
(20, 73, 13, 1, 'gjfhgjhg', '2018-03-22 12:03:20', '2018-05-02 04:10:42', 1),
(21, 73, 15, 1, 'hello newwwwwwww', '2018-03-22 13:19:16', '2018-05-02 04:10:42', 1),
(22, 73, 14, 1, 'hjgj', '2018-03-22 13:19:36', '2018-05-02 04:10:42', 1),
(23, 73, 14, 1, 'hjgj', '2018-03-22 13:19:43', '2018-05-02 04:10:42', 1),
(24, 11, NULL, 1, 'hiiii', '2018-03-22 13:24:46', '2018-05-01 10:05:48', 1),
(25, 11, NULL, 1, 'hiiiiii', '2018-03-22 13:24:50', '2018-05-01 10:05:48', 1),
(28, 11, 25, 1, 'jfghj', '2018-03-22 13:25:29', '2018-05-01 10:05:48', 1),
(29, 11, 12, 1, 'hjkgjkh', '2018-03-22 13:26:08', '2018-05-01 10:05:48', 1),
(30, 11, 12, 1, 'jhkgh', '2018-03-22 13:26:17', '2018-05-01 10:05:48', 1),
(31, 11, 12, 1, 'hjkgh', '2018-03-22 13:26:23', '2018-05-01 10:05:48', 1),
(32, 72, NULL, 1, 'Hi', '2018-03-22 14:39:00', '2018-03-22 14:55:34', 0),
(37, 72, 33, 1, 'hgjghj', '2018-03-22 16:40:27', '2018-03-22 16:40:30', 0),
(38, 72, 33, 1, 'hgjghj', '2018-03-22 16:40:29', '2018-03-22 16:40:30', 0),
(39, 72, 33, 1, 'hgjghj', '2018-03-22 16:40:30', '2018-03-22 16:40:30', 0),
(40, 72, 33, 1, 'hgjghj', '2018-03-22 16:40:30', '2018-03-22 16:40:30', 0),
(41, 72, 33, 1, 'hgjghj', '2018-03-22 16:40:30', '2018-03-22 16:40:30', 0),
(42, 72, 33, 1, 'hgjghj', '2018-03-22 16:40:30', '2018-03-22 16:40:30', 0),
(43, 72, 33, 1, 'hgjghj', '2018-03-22 16:40:30', '2018-03-22 16:40:30', 0),
(44, 79, NULL, 121, 'hi All 1', '2018-03-23 12:20:35', '2018-04-17 07:06:05', 1),
(45, 79, NULL, 121, 'jhkghk', '2018-03-23 12:31:47', '2018-04-17 07:06:05', 1),
(46, 79, 44, 121, 'ghjghj', '2018-03-23 12:31:50', '2018-04-17 07:06:05', 1),
(51, 73, 16, 1, 'super', '2018-03-30 02:08:56', '2018-05-02 04:10:42', 1),
(62, 73, 16, 1, 'Hello', '2018-04-02 10:35:59', '2018-05-02 04:10:42', 1),
(63, 79, 44, 1, 'hh', '2018-04-02 10:47:50', '2018-04-17 07:06:05', 1),
(64, 79, 44, 1, 'gggg', '2018-04-02 10:48:20', '2018-04-17 07:06:05', 1),
(65, 79, 45, 1, 'hhhffffffffffffffffffffffff', '2018-04-02 10:48:39', '2018-04-17 07:06:05', 1),
(66, 73, 16, 1, 'gg', '2018-04-02 10:49:14', '2018-05-02 04:10:42', 1),
(67, 73, 14, 1, 'gg', '2018-04-02 10:49:25', '2018-05-02 04:10:42', 1),
(70, 68, NULL, 1, 'gg', '2018-04-03 01:51:36', '2018-04-03 01:51:36', 0),
(71, 59, NULL, 1, 'dd', '2018-04-03 02:00:53', '2018-04-06 03:34:52', 0),
(73, 77, NULL, 1, 'edit', '2018-04-03 02:02:35', '2018-04-28 02:39:52', 1),
(74, 69, NULL, 1, 'gg', '2018-04-03 02:08:35', '2018-04-12 07:19:58', 0),
(76, 76, NULL, 1, 'hh', '2018-04-03 02:51:28', '2018-05-01 10:21:33', 1),
(77, 79, 45, 1, 'hkjhk', '2018-04-03 03:57:31', '2018-04-17 07:06:05', 1),
(82, 79, 79, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2018-04-03 04:18:38', '2018-04-17 07:06:05', 1),
(83, 62, NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2018-04-03 05:07:12', '2018-04-17 07:03:33', 1),
(84, 71, NULL, 1, 'hii', '2018-04-03 05:46:27', '2018-04-03 05:46:27', 0),
(86, 79, 80, 1, 'ffff', '2018-04-03 06:13:50', '2018-04-17 07:06:05', 1),
(87, 79, 79, 1, 'gg.kk', '2018-04-03 06:50:05', '2018-04-17 07:06:05', 1),
(88, 79, 78, 1, 'Hi..', '2018-04-03 07:09:29', '2018-04-17 07:06:05', 1),
(89, 79, 78, 1, 'hrllo', '2018-04-03 07:51:04', '2018-04-17 07:06:05', 1),
(102, 62, NULL, 121, 'Nice Picture', '2018-04-04 06:24:20', '2018-04-17 07:03:33', 1),
(103, 98, NULL, 1, 'hiii', '2018-04-10 03:22:35', '2018-04-11 08:40:57', 0),
(104, 98, NULL, 1, 'g.g', '2018-04-10 03:22:42', '2018-04-11 08:40:57', 0),
(105, 78, NULL, 1, 'hhh,hhh', '2018-04-10 03:24:08', '2018-04-17 07:06:12', 1),
(106, 78, NULL, 1, 'hhh.hhh', '2018-04-10 03:25:21', '2018-04-17 07:06:12', 1),
(107, 78, NULL, 1, 'lorem\'Need%20tips%3F%20Visit%20W3Schools%21', '2018-04-10 03:25:49', '2018-04-17 07:06:12', 1),
(108, 78, NULL, 1, 'Need%20tips%3F%20Visit%20W3Schools%21', '2018-04-10 03:25:58', '2018-04-17 07:06:12', 1),
(109, 78, NULL, 1, '%', '2018-04-10 03:26:25', '2018-04-17 07:06:12', 1),
(119, 79, NULL, 1, 'hi.hh', '2018-04-10 03:31:06', '2018-04-17 07:06:05', 1),
(120, 79, NULL, 1, 'hh\'hh', '2018-04-10 03:33:01', '2018-04-17 07:06:05', 1),
(121, 79, NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing g elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Vicky', '2018-04-10 03:38:23', '2018-04-17 07:06:05', 1),
(122, 103, NULL, 1, 'hii', '2018-04-11 08:38:14', '2018-04-20 07:27:23', 1),
(123, 108, NULL, 1, 'hii', '2018-04-12 02:59:31', '2018-04-18 07:57:14', 1),
(124, 109, NULL, 1, 'hii', '2018-04-12 04:35:40', '2018-04-19 07:21:31', 1),
(125, 112, NULL, 1, 'hii', '2018-04-12 05:39:25', '2018-04-17 08:17:06', 1),
(126, 96, NULL, 1, 'jkljklkjl', '2018-04-12 08:01:51', '2018-04-20 07:24:38', 1),
(127, 96, NULL, 1, 'jghjh', '2018-04-12 08:02:04', '2018-04-20 07:24:38', 1),
(128, 96, NULL, 1, 'fjghk', '2018-04-12 08:02:07', '2018-04-20 07:24:38', 1),
(129, 112, NULL, 1, 'gg', '2018-04-12 08:02:40', '2018-04-17 08:17:06', 1),
(130, 112, NULL, 1, 'g', '2018-04-12 08:02:42', '2018-04-17 08:17:06', 1),
(131, 112, NULL, 1, 'g', '2018-04-12 08:02:44', '2018-04-17 08:17:06', 1),
(132, 112, NULL, 1, 'hh', '2018-04-12 09:03:36', '2018-04-17 08:17:06', 1),
(133, 112, NULL, 1, 'hh', '2018-04-12 09:03:38', '2018-04-17 08:17:06', 1),
(134, 112, NULL, 1, 'tt', '2018-04-12 09:03:41', '2018-04-17 08:17:06', 1),
(135, 112, NULL, 1, 'dffs33', '2018-04-12 09:03:44', '2018-04-17 08:17:06', 1),
(136, 96, NULL, 1, 'jgj', '2018-04-12 09:13:52', '2018-04-20 07:24:38', 1),
(137, 96, NULL, 1, 'jgjgj', '2018-04-12 09:13:55', '2018-04-20 07:24:38', 1),
(138, 96, NULL, 1, 'jgg', '2018-04-12 09:13:58', '2018-04-20 07:24:38', 1),
(139, 96, NULL, 1, 'jhj', '2018-04-12 09:14:00', '2018-04-20 07:24:38', 1),
(140, 113, NULL, 1, 'Nice Picture', '2018-04-13 06:48:27', '2018-04-17 08:18:37', 1),
(141, 113, 140, 1, 'Thanks Buddy', '2018-04-13 06:48:37', '2018-04-17 08:18:37', 1),
(142, 115, NULL, 121, 'fghfg', '2018-04-17 07:50:23', '2018-04-18 08:02:30', 1),
(143, 114, NULL, 121, 'kjljkl', '2018-04-17 07:50:26', '2018-04-17 23:48:56', 1),
(144, 113, NULL, 121, 'l;', '2018-04-17 07:50:33', '2018-04-17 08:18:37', 1),
(145, 113, NULL, 121, 'l;\r\n;\'', '2018-04-17 07:50:33', '2018-04-17 08:18:37', 1),
(146, 112, NULL, 121, 'hjkhjkhjkhjk', '2018-04-17 07:50:41', '2018-04-17 08:17:06', 1),
(147, 78, NULL, 1, 'New Coomment', '2018-04-17 08:06:11', '2018-04-28 02:39:43', 1),
(148, 78, NULL, 1, 'ghjg', '2018-04-17 08:06:55', '2018-04-28 02:39:43', 1),
(149, 118, NULL, 1, 'u', '2018-04-19 01:52:44', '2018-04-20 03:57:13', 1),
(150, 124, NULL, 1, 'super vidoes', '2018-04-28 01:29:05', '2018-04-28 01:29:08', 1),
(151, 140, NULL, 1, 'Hii', '2018-05-01 09:26:05', '2018-05-01 10:19:39', 1),
(152, 143, NULL, 1, 'super', '2018-05-01 10:13:59', '2018-05-01 10:14:00', 1),
(153, 143, NULL, 1, 'asome', '2018-05-01 10:14:10', '2018-05-01 10:14:11', 1),
(154, 143, NULL, 1, 'nic:-)', '2018-05-01 10:14:25', '2018-05-01 10:14:28', 1),
(155, 143, NULL, 1, 'sdjf', '2018-05-01 10:14:38', '2018-05-01 10:14:43', 1),
(156, 143, NULL, 1, 'dsfdsf', '2018-05-01 10:14:41', '2018-05-01 10:14:43', 1),
(157, 143, NULL, 1, 'super', '2018-05-01 10:15:24', '2018-05-01 10:15:36', 1),
(158, 143, NULL, 1, 'super', '2018-05-01 10:15:27', '2018-05-01 10:15:36', 1),
(159, 143, NULL, 1, 'super', '2018-05-01 10:15:29', '2018-05-01 10:15:36', 1),
(160, 142, NULL, 1, 'dfsgdf', '2018-05-01 10:17:18', '2018-05-01 10:17:21', 1),
(161, 142, NULL, 1, 'gdfgf', '2018-05-01 10:17:28', '2018-05-01 10:17:29', 1),
(162, 142, NULL, 1, 'dfg', '2018-05-01 10:17:34', '2018-05-01 10:17:39', 1),
(163, 142, NULL, 1, 'dfgd', '2018-05-01 10:17:37', '2018-05-01 10:17:39', 1),
(164, 140, NULL, 121, 'Nice Video', '2018-05-01 10:20:04', '2018-05-01 10:20:56', 1),
(165, 140, NULL, 121, 'Going Nice', '2018-05-01 10:20:26', '2018-05-01 10:20:56', 1),
(170, 136, NULL, 1, 'asome', '2018-05-01 10:28:12', '2018-05-01 10:28:58', 1),
(171, 136, NULL, 1, 'super', '2018-05-01 10:28:18', '2018-05-01 10:28:58', 1),
(172, 136, NULL, 1, 'cooling', '2018-05-01 10:28:26', '2018-05-01 10:28:58', 1),
(173, 136, NULL, 1, 'nic photo', '2018-05-01 10:28:37', '2018-05-01 10:28:58', 1),
(174, 144, NULL, 1, 'h', '2018-05-09 06:15:55', '2018-05-09 06:42:08', 1),
(175, 144, 174, 1, 'g', '2018-05-09 07:21:23', '2018-05-09 07:21:23', 0),
(176, 73, NULL, 1, 'hi', '2018-05-14 09:20:26', '2018-05-14 09:20:26', 0),
(177, 150, NULL, 1, '123', '2018-05-14 09:21:03', '2018-05-14 09:23:47', 1),
(183, 159, NULL, 141, 'hi', '2018-05-18 04:39:58', '2018-05-18 04:39:58', 0),
(184, 159, NULL, 141, 'hi', '2018-05-18 04:39:58', '2018-05-18 04:39:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_images`
--

INSERT INTO `post_images` (`id`, `post_id`, `image_path`) VALUES
(1, 1, 'd881312189a682e75ecbec0364ab7e1e.jpg'),
(2, 2, 'a00941217941b2f38ff3d5d8d301bc7f.jpg'),
(5, 5, 'f4ecac8470692dba34005bcb1041a924.jpg'),
(6, 6, 'c35f4817d592ffbbbbeb6b5c33ff0208.png'),
(7, 7, 'a9e3129643bae15f9a48e2b9d27e4b7c.png'),
(9, 9, 'dd7a417f88ddd94435714372d52ce555.jpg'),
(11, 11, 'c064f41d9433a15ba4ec31154236b398.jpg'),
(12, 12, '5c56886826576d3a0202aeea3e28ae6d.png'),
(13, 13, '59c6d48f34c506ef2e2256631947f073.jpg'),
(14, 14, '19e14f4a76e63d1a493829052af38b56.jpg'),
(15, 16, '01cb83f3cb04128e8a76efe12866c9eb.jpg'),
(16, 51, 'c7bf54c087a82089237819f80c833bc7.jpg'),
(17, 52, 'e524cc05b419e5eddf9f20abf098c875.jpg'),
(18, 53, '3f036bed0d78922eaa3963843dfb1168.jpg'),
(19, 54, '7f99f165660c84c46bb77b540e664e52.png'),
(20, 55, 'e02baaf1f769eb4f3b0a8f8c3c0cf565.png'),
(21, 56, 'c7e23b838e758d1faf9649f77e1bac86.png'),
(22, 57, '1f8b8f0a2e499369d365ad0ba7124f70.png'),
(23, 58, '50dcb6eab2f323eac9390da00089aaa6.png'),
(24, 59, '90361e05f12881d5f36f6c44a52dbbd2.png'),
(29, 69, 'a8f438639b48a85ae38dcb07edb966a9.jpg'),
(36, 62, 'd7f06d0fe834005e60326b228cbbe26a.png'),
(44, 102, 'f6edcd1cf0eff37db5b3b1c52b621c78.jpg'),
(45, 103, '6e2747ec29f0f027818b06e21c32343d.jpg'),
(46, 107, 'b2b12da9931b5f2c7aead2c78383735c.jpg'),
(47, 108, '34637a33ec967d7d19dbd94c03371a6b.jpg'),
(48, 109, '05f26ebc04522cfbfb8043112ea0e2f9.jpg'),
(49, 110, 'a3744e6741c13bfde7f3c70923f4f6cf.png'),
(50, 112, '665f20496e8d656056ad3b6c5e79c4e8.jpg'),
(51, 113, 'b3f1c9b678a4771d89c705a98c1fed88.jpg'),
(52, 114, '49ef311cf71cba9ce2031be832e8ada0.jpg'),
(53, 120, 'f62a3138c89eec541b9e8fe041271ad5.png'),
(54, 145, 'bea388d262f274ad567089de1d05d049.jpg'),
(55, 146, '1dde22da6ad4055552ffc36bb4a0342c.png'),
(56, 147, '97ef2f3ee305358a8af62d8de461867c.png'),
(57, 148, '62a87dbbf01aedf7e688097477fa16c2.jpg'),
(58, 149, '55f0d52f03ea678265347da3fdffea06.png'),
(59, 150, '49b2449d22acd7945307f0ab6733226a.png'),
(60, 157, '0105713fbd230eb3efb9bfbf848e2ed9.png');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `like_user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`post_id`, `like_user_id`, `created_at`, `updated_at`, `seen`) VALUES
(1, 1, '2018-03-07 07:47:01', '2018-05-01 05:20:47', 1),
(2, 1, '2018-03-07 06:58:05', '2018-03-07 07:54:53', 0),
(9, 1, '2018-03-19 08:50:20', '2018-05-01 05:20:38', 1),
(11, 1, '2018-04-17 07:31:39', '2018-05-01 10:05:48', 1),
(11, 121, '2018-03-22 09:14:52', '2018-05-01 10:05:48', 1),
(12, 1, '2018-04-17 07:31:37', '2018-05-01 10:05:59', 1),
(73, 1, '2018-03-22 13:40:32', '2018-05-02 04:10:42', 1),
(76, 1, '2018-04-17 07:31:35', '2018-05-01 10:21:33', 1),
(76, 121, '2018-05-01 10:21:43', '2018-05-01 10:21:43', 0),
(77, 1, '2018-04-17 07:31:32', '2018-04-28 02:39:52', 1),
(78, 1, '2018-04-17 08:06:16', '2018-04-28 02:39:43', 1),
(79, 1, '2018-04-17 07:43:50', '2018-04-28 02:39:27', 1),
(79, 121, '2018-04-03 10:18:53', '2018-04-17 07:27:54', 1),
(96, 1, '2018-04-04 05:51:52', '2018-04-20 07:24:38', 1),
(111, 1, '2018-04-13 05:01:16', '2018-04-13 06:54:32', 0),
(112, 1, '2018-04-12 05:13:54', '2018-04-17 08:17:06', 1),
(112, 121, '2018-04-17 07:50:43', '2018-04-17 08:17:06', 1),
(113, 121, '2018-04-17 07:50:37', '2018-04-17 08:18:37', 1),
(114, 121, '2018-04-17 07:50:27', '2018-04-17 23:48:56', 1),
(115, 121, '2018-04-17 07:50:21', '2018-04-18 08:02:31', 1),
(116, 121, '2018-04-17 07:50:19', '2018-04-19 01:34:11', 1),
(117, 121, '2018-04-17 07:50:18', '2018-04-17 23:48:53', 1),
(118, 121, '2018-04-17 07:50:16', '2018-04-17 23:48:50', 1),
(150, 2, '2018-05-14 06:55:34', '2018-05-14 09:20:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post_links`
--

CREATE TABLE `post_links` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `link_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_code` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_links`
--

INSERT INTO `post_links` (`id`, `post_id`, `link_url`, `link_code`) VALUES
(2, 74, 'https://www.youtube.com/watch?v=AGW_UfrSi58', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/AGW_UfrSi58?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(3, 75, 'https://www.youtube.com/embed/FM7MFYoylVs', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/FM7MFYoylVs?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(4, 76, 'https://youtu.be/Io0fBr1XBUA', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/Io0fBr1XBUA?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(5, 77, 'http://www.thehindu.com/news/national/facebook-is-committed-to-stopping-interference-in-indian-elections-zuckerberg/article23318800.ece', NULL),
(6, 76, 'https://www.instagram.com/p/BQvaPaXAyN7', '<blockquote class=\"instagram-media\" data-instgrm-captioned data-instgrm-permalink=\"https://www.instagram.com/p/BQvaPaXAyN7/\" data-instgrm-version=\"8\" style=\" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);\"><div style=\"padding:8px;\"> <div style=\" background:#F8F8F8; line-height:0; margin-top:40px; padding:50.0% 0; text-align:center; width:100%;\"> <div style=\" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;\"></div></div> <p style=\" margin:8px 0 0 0; padding:0 4px;\"> <a href=\"https://www.instagram.com/p/BQvaPaXAyN7/\" style=\" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;\" target=\"_blank\">Pehle Main bhi Samajhdar Hua Karta Tha,  Phir Mujhe #PagalDost Mil Gaye..😍😘 #Reunion #Frndzzz #Family #Masti #Fun #Phychos</a></p> <p style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;\">A post shared by <a href=\"https://www.instagram.com/imvdiyora/\" style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;\" target=\"_blank\"> Vicky Diyora</a> (@imvdiyora) on <time style=\" font-family:Arial,sans-serif; font-size:14px; line-height:17px;\" datetime=\"2017-02-20T16:52:09+00:00\">Feb 20, 2017 at 8:52am PST</time></p></div></blockquote>\r\n<script async defer src=\"//www.instagram.com/embed.js\"></script>'),
(7, 77, 'https://www.instagram.com/p/BQvaPaXAyN7', '<blockquote class=\"instagram-media\" data-instgrm-captioned data-instgrm-permalink=\"https://www.instagram.com/p/BQvaPaXAyN7/\" data-instgrm-version=\"8\" style=\" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);\"><div style=\"padding:8px;\"> <div style=\" background:#F8F8F8; line-height:0; margin-top:40px; padding:50.0% 0; text-align:center; width:100%;\"> <div style=\" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;\"></div></div> <p style=\" margin:8px 0 0 0; padding:0 4px;\"> <a href=\"https://www.instagram.com/p/BQvaPaXAyN7/\" style=\" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;\" target=\"_blank\">Pehle Main bhi Samajhdar Hua Karta Tha,  Phir Mujhe #PagalDost Mil Gaye..😍😘 #Reunion #Frndzzz #Family #Masti #Fun #Phychos</a></p> <p style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;\">A post shared by <a href=\"https://www.instagram.com/imvdiyora/\" style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;\" target=\"_blank\"> Vicky Diyora</a> (@imvdiyora) on <time style=\" font-family:Arial,sans-serif; font-size:14px; line-height:17px;\" datetime=\"2017-02-20T16:52:09+00:00\">Feb 20, 2017 at 8:52am PST</time></p></div></blockquote>\r\n<script async defer src=\"//www.instagram.com/embed.js\"></script>'),
(8, 78, 'https://www.instagram.com/p/BQvaPaXAyN7', '<blockquote class=\"instagram-media\" data-instgrm-captioned data-instgrm-permalink=\"https://www.instagram.com/p/BQvaPaXAyN7/\" data-instgrm-version=\"8\" style=\" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);\"><div style=\"padding:8px;\"> <div style=\" background:#F8F8F8; line-height:0; margin-top:40px; padding:50.0% 0; text-align:center; width:100%;\"> <div style=\" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;\"></div></div> <p style=\" margin:8px 0 0 0; padding:0 4px;\"> <a href=\"https://www.instagram.com/p/BQvaPaXAyN7/\" style=\" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;\" target=\"_blank\">Pehle Main bhi Samajhdar Hua Karta Tha,  Phir Mujhe #PagalDost Mil Gaye..😍😘 #Reunion #Frndzzz #Family #Masti #Fun #Phychos</a></p> <p style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;\">A post shared by <a href=\"https://www.instagram.com/imvdiyora/\" style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;\" target=\"_blank\"> Vicky Diyora</a> (@imvdiyora) on <time style=\" font-family:Arial,sans-serif; font-size:14px; line-height:17px;\" datetime=\"2017-02-20T16:52:09+00:00\">Feb 20, 2017 at 8:52am PST</time></p></div></blockquote>\n<script async defer src=\"//www.instagram.com/embed.js\"></script>'),
(9, 79, 'https://www.youtube.com/watch?v=yAoLSRbwxL8', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/yAoLSRbwxL8?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(10, 80, 'https://www.youtube.com/watch?v=MfDaueqi0XU', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/MfDaueqi0XU?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(11, 81, 'https://swirlster.ndtv.com/beauty/charcoal-to-clay-7-ingredients-youll-find-in-beauty-products-1827883', NULL),
(16, 92, 'https://www.youtube.com/watch?v=FM7MFYoylVs', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/FM7MFYoylVs?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(18, 105, 'https://www.youtube.com/watch?v=FM7MFYoylVs', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/FM7MFYoylVs?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(19, 106, 'https://www.instagram.com/p/BcC7GI3l-Ws/?taken-by=roonikapoor1554', '<blockquote class=\"instagram-media\" data-instgrm-permalink=\"https://www.instagram.com/p/BcC7GI3l-Ws/\" data-instgrm-version=\"8\" style=\" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);\"><div style=\"padding:8px;\"> <div style=\" background:#F8F8F8; line-height:0; margin-top:40px; padding:50.0% 0; text-align:center; width:100%;\"> <div style=\" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;\"></div></div><p style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;\"><a href=\"https://www.instagram.com/p/BcC7GI3l-Ws/\" style=\" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;\" target=\"_blank\">A post shared by roonikapoor (@roonikapoor1554)</a> on <time style=\" font-family:Arial,sans-serif; font-size:14px; line-height:17px;\" datetime=\"2017-11-28T16:30:09+00:00\">Nov 28, 2017 at 8:30am PST</time></p></div></blockquote>\n<script async defer src=\"//www.instagram.com/embed.js\"></script>'),
(20, 138, 'https://www.youtube.com/watch?v=FCUPcNBpq4E', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/FCUPcNBpq4E?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(21, 129, 'https://www.youtube.com/watch?v=nzopehMyaLg', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/nzopehMyaLg?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(22, 130, 'https://www.youtube.com/watch?v=FM7MFYoylVs', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/FM7MFYoylVs?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(23, 138, 'https://www.youtube.com/watch?v=3mH9E8987zI', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/3mH9E8987zI?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(24, 139, 'https://www.youtube.com/watch?v=3mH9E8987zI', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/3mH9E8987zI?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(25, 140, 'https://www.youtube.com/watch?v=3mH9E8987zI', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/3mH9E8987zI?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(26, 141, 'https://www.youtube.com/watch?v=VVKK6HJuxEI', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/VVKK6HJuxEI?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(27, 142, 'https://www.youtube.com/watch?v=NmVc7tPU0k4', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/NmVc7tPU0k4?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>'),
(28, 143, 'https://www.youtube.com/watch?v=VVKK6HJuxEI', '<iframe width=\"480\" height=\"270\" src=\"https://www.youtube.com/embed/VVKK6HJuxEI?feature=oembed\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `post_shares`
--

CREATE TABLE `post_shares` (
  `id` int(11) NOT NULL,
  `post_id` int(10) NOT NULL,
  `shared_post_id` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_shares`
--

INSERT INTO `post_shares` (`id`, `post_id`, `shared_post_id`, `created_at`, `updated_at`) VALUES
(2, 94, 73, '2018-04-04 04:19:19', '2018-04-04 04:19:19'),
(3, 95, 79, '2018-04-04 04:19:47', '2018-04-04 04:19:47'),
(4, 96, 72, '2018-04-04 04:21:15', '2018-04-04 04:21:15'),
(5, 119, 114, '2018-04-20 08:15:02', '2018-04-20 08:15:02'),
(6, 159, 158, '2018-05-18 01:04:28', '2018-05-18 01:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `post_videos`
--

CREATE TABLE `post_videos` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `video_path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_videos`
--

INSERT INTO `post_videos` (`id`, `post_id`, `video_path`) VALUES
(1, 18, '0a64f53bc7d9a320dcd953b2ac73f72d.3gp'),
(2, 27, '6f26305eabb99c8ac628bf2be68de859.3gp'),
(3, 28, 'd3ddd14edf06c3ab5bf2fbf2d63f5a1f.3gp'),
(4, 29, '5222315c7091a41e220a725ebd8aefb9.3gp'),
(5, 30, 'a0e7c4817ac3331cf3db63f288e7fad0.3gp'),
(6, 31, '13b512b51b7b558e7a808c620143509e.3gp'),
(7, 32, '1a1ea70b6d93872210b0ec6bdfd26786.3gp'),
(8, 33, '87ed9c3d0f04011138488e6bf4ef530b.3gp'),
(9, 34, 'fec2fd60b79206597d31e7a1c9d9211a.mp4'),
(10, 35, 'dee142860ca0b0de6984612635244a8b.mp4'),
(11, 36, '863b1424c12c5c4f9c50dfffb317c912.3gp'),
(12, 37, 'e7477fd3d3de41ca4ce450372d04b2ac.mp4'),
(13, 72, 'dc4e50ec0524b2c0b2bc4f04bc4d739c.mp4'),
(14, 80, '75b1e21ad78f36b6f6eba16634d47a2c.mp4'),
(15, 100, 'e3c6bed666764847128c992f2fde2e30.mp4'),
(16, 100, ''),
(17, 100, ''),
(18, 100, '539b5279c2daf8d9475873c32e95ccf9.mp4'),
(19, 121, '07149c6e98378bbe515e041a1ea241a0.mp4'),
(20, 122, '343af1de89d939a141ecca78164bf145.mp4'),
(21, 123, '4b462ce5fa98bd10dd183d8391389d72.mp4'),
(22, 124, 'bb6762839b0342f84a6cac82f86d2f26.mp4'),
(23, 125, '60847088b6d786b89c3905dc449fcf77.mp4'),
(24, 126, '308d8f893d253136ab2aeeb57c0d38a9.mp4'),
(25, 127, 'f44d3c9a9622f624c165045f6716362c.mp4'),
(26, 128, '5e1a9053c090192d06fe36c0c622d065.mp4'),
(27, 131, 'bc24dbf95feb338b118a7a69d39174cf.mp4'),
(28, 132, '645690c3c59593b42c44263a79dccce1.mp4'),
(29, 133, '6e07e6681356002d4f6b9960a3a39b1d.mp4'),
(30, 134, '0d67ce109245d8525224097fbfadee51.mp4'),
(31, 135, '24a19afddd5077d7103181a77d604904.mp4'),
(32, 136, '1467e29514e278a21348e6f289f6a32f.mp4'),
(33, 137, '242e2fad94df6ecbe366340dea742911.mp4'),
(34, 158, 'f6f1e15c9e8b33aea29b7ca047cf5938.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `json` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `json`) VALUES
(1, '{\"youtube1\":\"https:\\/\\/www.youtube.com\\/watch?v=qyiTOmNDAFw\",\"youtube1Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/qyiTOmNDAFw?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube1Title\":\"OVERPROTECTIVE WIFE - 2018 Nigerian Movies Latest African Nollywood Full Movies\",\"youtube2\":\"https:\\/\\/www.youtube.com\\/watch?v=uD8FFUVYQtw\",\"youtube2Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/uD8FFUVYQtw?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube2Title\":\"THE EVIL JEALOUS FRIEND - 2017 Latest Nigerian Movies African Nollywood Full Movies\",\"youtube3\":\"https:\\/\\/www.youtube.com\\/watch?v=6jU6hyGwxA4\",\"youtube3Code\":\"<iframe width=\\\"459\\\" height=\\\"344\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/6jU6hyGwxA4?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube3Title\":\"SORROWS OF A POOR GIRL - 2017 Latest Nigerian Movies African Nollywood Full Movies\",\"youtube4\":\"https:\\/\\/www.youtube.com\\/watch?v=65QQkwyX2gQ\",\"youtube4Code\":\"<iframe width=\\\"459\\\" height=\\\"344\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/65QQkwyX2gQ?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube4Title\":\"A POOR BEGGAR MARRIES A BILLIONAIRE PRINCE 2017 Latest Nigerian Movies African Nollywood Full Movies\",\"youtube5Code\":\"<iframe width=\\\"459\\\" height=\\\"344\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/E0AY136v2AI?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube5Title\":\"Leave My Man Alone {MERCY JOHNSON} 1 -  Nigerian Movies 2016  Full Movies | Latest Nollywood Movies\",\"youtube6Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/M_1EOEfW_p4?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube6Title\":\"AFTER MY WEALTH 1  -  2017 Latest Nigerian Movies African Nollywood Movies\",\"youtube7Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/FM7MFYoylVs?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube7Title\":\"The Chainsmokers & Coldplay - Something Just Like This (Lyric)\",\"youtube8Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/FM7MFYoylVs?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube8Title\":\"The Chainsmokers & Coldplay - Something Just Like This (Lyric)\",\"youtube9Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/FM7MFYoylVs?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube9Title\":\"The Chainsmokers & Coldplay - Something Just Like This (Lyric)\",\"youtube10Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/FM7MFYoylVs?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube10Title\":\"The Chainsmokers & Coldplay - Something Just Like This (Lyric)\",\"youtube11Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/FM7MFYoylVs?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube11Title\":\"The Chainsmokers & Coldplay - Something Just Like This (Lyric)\",\"youtube12Code\":\"<iframe width=\\\"480\\\" height=\\\"270\\\" src=\\\"https:\\/\\/www.youtube.com\\/embed\\/FM7MFYoylVs?feature=oembed\\\" frameborder=\\\"0\\\" allow=\\\"autoplay; encrypted-media\\\" allowfullscreen><\\/iframe>\",\"youtube12Title\":\"The Chainsmokers & Coldplay - Something Just Like This (Lyric)\",\"youtube5\":\"https:\\/\\/www.youtube.com\\/watch?v=E0AY136v2AI\",\"youtube6\":\"https:\\/\\/www.youtube.com\\/watch?v=M_1EOEfW_p4\",\"youtube7\":\"https:\\/\\/www.youtube.com\\/watch?v=FM7MFYoylVs\",\"youtube8\":\"https:\\/\\/www.youtube.com\\/watch?v=FM7MFYoylVs\",\"youtube9\":\"https:\\/\\/www.youtube.com\\/watch?v=FM7MFYoylVs\",\"youtube10\":\"https:\\/\\/www.youtube.com\\/watch?v=FM7MFYoylVs\",\"youtube11\":\"https:\\/\\/www.youtube.com\\/watch?v=FM7MFYoylVs\",\"youtube12\":\"https:\\/\\/www.youtube.com\\/watch?v=FM7MFYoylVs\",\"instagram\":\"nollywood\",\"fb\":\"nollyafritv\",\"twitter\":\"nollywoodtweets\",\"youtube\":\"UCVUoS7uOLH-PoNJecAvzT7g\"}');

-- --------------------------------------------------------

--
-- Table structure for table `social_comments`
--

CREATE TABLE `social_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `comment_user_id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_comments`
--

INSERT INTO `social_comments` (`id`, `post_id`, `source`, `parent_id`, `comment_user_id`, `comment`, `created_at`, `updated_at`, `seen`) VALUES
(1, '1766879938658880370', 'instagram', NULL, 1, 'Hello', '2018-04-24 07:42:24', '2018-04-24 07:42:24', 0),
(2, '1763479783960034592', 'instagram', NULL, 1, 'Hello123', '2018-04-24 07:42:25', '2018-04-24 07:42:25', 0),
(3, '1763479783960034592', 'instagram', NULL, 1, 'Hello1234', '2018-04-24 07:44:25', '2018-04-24 07:44:25', 0),
(4, '1763479783960034592', 'instagram', NULL, 121, 'Hello1', '2018-04-24 07:43:25', '2018-04-24 07:43:25', 0),
(5, '1770488221592422988', '', NULL, 1, 'Hi', '2018-05-07 03:56:44', '2018-05-07 03:56:44', 0),
(6, '1770488221592422988', '', NULL, 1, 'Hi', '2018-05-07 03:56:53', '2018-05-07 03:56:53', 0),
(7, '1770488221592422988', '', NULL, 1, 'Hi', '2018-05-07 03:57:07', '2018-05-07 03:57:07', 0),
(8, '1770488221592422988', '', NULL, 1, 'Hi', '2018-05-07 03:57:31', '2018-05-07 03:57:31', 0),
(9, '1770488221592422988', '', NULL, 1, 'kjhk', '2018-05-07 04:01:03', '2018-05-07 04:01:03', 0),
(10, '1770488221592422988', '', NULL, 1, 'kjhk', '2018-05-07 04:01:49', '2018-05-07 04:01:49', 0),
(11, '1770488221592422988', '', NULL, 1, 'll', '2018-05-07 04:04:30', '2018-05-07 04:04:30', 0),
(12, '1770488221592422988', '', NULL, 1, 'll', '2018-05-07 04:07:46', '2018-05-07 04:07:46', 0),
(13, '1770488221592422988', '', NULL, 1, 'll', '2018-05-07 04:08:41', '2018-05-07 04:08:41', 0),
(14, '1770488221592422988', '', NULL, 1, 'll', '2018-05-07 04:08:59', '2018-05-07 04:08:59', 0),
(15, '1772738542695748973', '', NULL, 1, '123', '2018-05-07 04:09:27', '2018-05-07 04:09:27', 0),
(16, '1772738542695748973', '', NULL, 1, '1234', '2018-05-07 04:09:49', '2018-05-07 04:09:49', 0),
(17, '1772738542695748973', '', NULL, 1, '1234', '2018-05-07 04:10:33', '2018-05-07 04:10:33', 0),
(18, '1772738542695748973', '', NULL, 1, 'hi', '2018-05-07 04:11:08', '2018-05-07 04:11:08', 0),
(19, '1772738542695748973', '', NULL, 1, 'hi', '2018-05-07 04:11:35', '2018-05-07 04:11:35', 0),
(20, '1771254644916687676', '', NULL, 1, 'hii', '2018-05-07 04:12:53', '2018-05-07 04:12:53', 0),
(21, '1771254644916687676', '', NULL, 1, 'helo', '2018-05-07 04:13:01', '2018-05-07 04:13:01', 0),
(22, '1770488221592422988', '', NULL, 1, 'vicky', '2018-05-07 04:14:13', '2018-05-07 04:14:13', 0),
(23, '1763479783960034592', '', NULL, 1, 'nice', '2018-05-07 04:14:48', '2018-05-07 04:14:48', 0),
(24, '133670981091864576', '', NULL, 1, 'hello', '2018-05-07 04:18:03', '2018-05-07 04:18:03', 0),
(25, 'Ce4EbZ9T2vs', '', NULL, 1, 'youtube111', '2018-05-07 04:18:13', '2018-05-07 04:18:13', 0),
(26, '1771254644916687676', '', NULL, 121, '333', '2018-05-07 04:18:51', '2018-05-07 04:18:51', 0),
(27, '1770036619588763144', '', NULL, 121, '369*', '2018-05-07 04:18:57', '2018-05-07 04:18:57', 0),
(28, '1762500088556803073', '', NULL, 121, '36', '2018-05-07 04:19:17', '2018-05-07 04:19:17', 0),
(29, 'Ce4EbZ9T2vs', '', NULL, 121, '222', '2018-05-07 04:19:34', '2018-05-07 04:19:34', 0),
(30, '124716107639720_1138744462903541', '', NULL, 1, 'hii', '2018-05-07 04:44:09', '2018-05-07 04:44:09', 0),
(31, 'ashrS6GKcUo', '', NULL, 1, 'good videos', '2018-05-07 09:04:40', '2018-05-07 09:04:40', 0),
(32, '124716107639720_1448801965231121', '', NULL, 1, 'ok', '2018-05-08 09:27:44', '2018-05-08 09:27:44', 0),
(33, '124716107639720_1448801965231121', '', NULL, 1, 'ok2', '2018-05-08 09:28:12', '2018-05-08 09:28:12', 0),
(34, '124716107639720_1448801965231121', '', NULL, 1, 'ok2', '2018-05-08 09:30:29', '2018-05-08 09:30:29', 0),
(35, '124716107639720_1448801965231121', '', NULL, 1, 'ok3', '2018-05-08 09:31:01', '2018-05-08 09:31:01', 0),
(36, '1430286123916724_1878459035766095', '', NULL, 1, 'hii', '2018-05-09 05:35:46', '2018-05-09 05:35:46', 0),
(37, 'null', '', NULL, 1, 'c', '2018-05-09 06:21:01', '2018-05-09 06:21:01', 0),
(38, 'null', '', NULL, 1, 'b', '2018-05-09 06:21:05', '2018-05-09 06:21:05', 0),
(39, 'null', '', NULL, 1, 'h', '2018-05-09 06:28:06', '2018-05-09 06:28:06', 0),
(40, 'null', '', NULL, 1, 'j', '2018-05-09 06:28:22', '2018-05-09 06:28:22', 0),
(41, 'null', '', NULL, 1, 'ja', '2018-05-09 06:28:22', '2018-05-09 06:28:22', 0),
(42, 'null', '', NULL, 1, 'h', '2018-05-09 06:31:28', '2018-05-09 06:31:28', 0),
(43, 'null', '', NULL, 1, 'd', '2018-05-09 06:31:37', '2018-05-09 06:31:37', 0),
(44, 'null', '', NULL, 1, 'j', '2018-05-09 06:31:43', '2018-05-09 06:31:43', 0),
(45, 'null', '', NULL, 1, 'ja', '2018-05-09 06:31:44', '2018-05-09 06:31:44', 0),
(46, 'null', '', NULL, 121, 'hii', '2018-05-09 06:41:24', '2018-05-09 06:41:24', 0),
(47, 'null', '', NULL, 1, 'hi', '2018-05-09 06:41:29', '2018-05-09 06:41:29', 0),
(48, 'null', '', NULL, 121, 'hh', '2018-05-09 06:41:34', '2018-05-09 06:41:34', 0),
(49, 'null', '', NULL, 1, 'dd', '2018-05-09 06:48:31', '2018-05-09 06:48:31', 0),
(50, '1430286123916724_1878457312432934', '', NULL, 1, 'hii', '2018-05-09 06:49:23', '2018-05-09 06:49:23', 0),
(51, 'null', '', NULL, 1, 'su', '2018-05-09 06:49:43', '2018-05-09 06:49:43', 0),
(52, '1430286123916724_1878457312432934', '', NULL, 1, 'jaymin', '2018-05-09 06:50:11', '2018-05-09 06:50:11', 0),
(53, 'null', '', NULL, 1, 'pragnesh bhai', '2018-05-09 06:50:31', '2018-05-09 06:50:31', 0),
(54, 'null', '', NULL, 1, 'oh', '2018-05-09 06:52:58', '2018-05-09 06:52:58', 0),
(55, 'null', '', NULL, 1, 'pragnesh bhai', '2018-05-09 06:58:14', '2018-05-09 06:58:14', 0),
(56, '1430286123916724_1878457312432934', '', NULL, 1, 'fff', '2018-05-09 06:58:47', '2018-05-09 06:58:47', 0),
(57, 'null', '', NULL, 1, 'ooooo', '2018-05-09 07:00:39', '2018-05-09 07:00:39', 0),
(58, 'null', '', NULL, 1, 'ooooo', '2018-05-09 07:00:42', '2018-05-09 07:00:42', 0),
(59, 'null', '', NULL, 1, 'ooooo', '2018-05-09 07:00:43', '2018-05-09 07:00:43', 0),
(60, 'undefined', '', NULL, 1, 'ooo', '2018-05-09 07:10:08', '2018-05-09 07:10:08', 0),
(61, 'undefined', '', NULL, 1, 'pragnesh', '2018-05-09 07:10:53', '2018-05-09 07:10:53', 0),
(62, 'undefined', '', NULL, 1, 'pragnesh', '2018-05-09 07:15:39', '2018-05-09 07:15:39', 0),
(63, '1771938261003245021', '', NULL, 1, 'Hi', '2018-05-10 03:52:34', '2018-05-10 03:52:34', 0),
(64, '1430286123916724_1878457312432934', '', NULL, 1, 'hii', '2018-05-10 03:52:44', '2018-05-10 03:52:44', 0),
(65, 'null', '', NULL, 1, 'hi', '2018-05-11 08:49:22', '2018-05-11 08:49:22', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `current_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `interested_in` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `marital_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hidepost` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Admin','Celebrity','Follower','Fanpage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `private`, `birthday`, `sex`, `phone`, `bio`, `profile_path`, `username`, `cover_path`, `nickname`, `first_name`, `last_name`, `current_city`, `nationality`, `interested_in`, `marital_status`, `skills`, `hidepost`, `category`, `role`, `instagram_uid`, `facebook_uid`, `twitter_uid`, `linkedin_uid`, `youtube_uid`) VALUES
(1, 'Jaymin Modi', 'modijaymin86@gmail.com', '$2y$10$2fwHnJ6AnL/qMiw9ThazteenaNJJhCsPRq0W5lelWUGgDP78Ib1xS', 'cpXuh7PswChdVbngN2FY65i5wWJZmgHxOwbT0U7iTVWLHt7oiw95nuhXrTsn', '2018-02-23 06:56:14', '2018-04-17 07:29:52', 0, NULL, 0, '7878388760', 'I recently stumbled upon a guide for coding PHP the right way. On this site they go through most aspects of the PHP language and history, from basic syntax all the way through testing and deployments.', 'f93791838d8e3f9da7cb8a7ff97f1c3a.png', 'jaymin', '4a65fd0ae9c8ede23e515593c012a62e.jpg', '', 'Jaymin', 'Modi', 'Pune', 'India', 'Male', 'single', 'wordpress,php,c.m.s', '', 'php devloper', 'Admin', 'imvdiyora', 'pragneshpanchalofficial', 'imvdiyora', 'imvdiyora', 'UCZRIvleceNUxAQpVQdQwLAg'),
(2, 'Rooni Kapoor', 'roonikapoor86@gmail.com', '$2y$10$2fwHnJ6AnL/qMiw9ThazteenaNJJhCsPRq0W5lelWUGgDP78Ib1xS', 'CduTO2P8ZN5ULnvZstnEBKr0u2sONgcNSSHBKn4VcfjjRBuN6Ul4hbLYVBDw', '2018-03-07 06:55:42', '2018-03-07 06:55:42', 0, NULL, 0, NULL, NULL, NULL, 'rooni', NULL, '', '', '', '', '', '', '', '', '', '', 'Admin', NULL, NULL, NULL, '', ''),
(3, 'Kishan Modi', 'kishan@gmail.com', '$2y$10$51X/2Wp1Zhr4RQMrAZ8T4.mRiHejDFqaCDpXkVI3mQ5ylB1NpfCEu', NULL, '2018-03-10 12:32:49', '2018-03-10 12:32:49', 0, NULL, 0, NULL, NULL, NULL, 'kishan', NULL, '', '', '', '', '', '', '', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(4, 'Solomon Joseph', 'solomonjoseph284luv@yahoo.com', '$P$B8g9RdNk0KLb6gyO84lpDWPcfns5j91', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', '1508044_568018169945162_1525026247_n.jpg', 'admin', 'jump-silhouette-facebook-cover.jpg', '', 'Solomon', 'Joseph', 'London', '', 'male', 'single', '', '', 'Admin', 'Admin', NULL, NULL, NULL, '', ''),
(5, 'Lightup Global', 'solomonjoseph95@yahoo.co.uk', '$P$B/05jLobcKuNsywoI22sI5yH7CRyLd1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Hey everyone, My is name LightupGlobal. Really \r\n prefer to have some sort of intellectual conversation, \r\none liners don\'t do it for me. ph', 'LightUpGlobal_large.png', 'solomonjoseph95@yahoo.co.uk', 'LightUpGlobal_large1.png', '', 'Lightupglobal', 'LightupGlobal', 'London', 'Nigeria', 'both', 'single', 'Management & Analyst', '', 'Student', 'Celebrity', NULL, NULL, 'lightupglobal', '', ''),
(6, 'Bright Okpocha', 'Basketmouth@yahoo.com', '$P$BBCSg0cJk/F2tVJHDtqjR6R/5U6BAy1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Bright Okpocha born September 14, 1978 is a Nigerian comedian and actor from Abia State who has organized popular stand-up comedy concerts l', 'basketmouth2.png', 'Basketmouth@yahoo.com', NULL, '', 'Bright', 'Okpocha', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Comedian', '', 'Art & Entertainments', 'Celebrity', 'basketmouth', '115495218604273', 'basket_mouth', '', ''),
(7, 'Solomon Joseph', 'lightupsolomon@yahoo.com', '$P$BAXjzPaL/BAEz5aWPFESGBv9Ni7LLJ/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Solomon is a Man who stand on his word without compromising.', 'IMG_0708.jpg', 'lightupsolomon@yahoo.com', 'Jellyfish.jpg', '', 'Solomon', 'Joseph', 'London', 'Nigeria', 'female', 'in relationship', 'IT & Management', '', 'Student', 'Follower', NULL, NULL, NULL, '', ''),
(8, 'Innovative Ideas', 'InnovativeIdeas_fanpagelightupsolomon@yahoo.com', '$P$B7lvBUlWL.suu.hlmN8uXlwC7H823a.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'SolomonJ-240.jpg', 'Innovative Ideas_fanpagelightupsolomon@yahoo.com', 'ideas.jpg', '', 'Innovative Ideas', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(9, 'Genevieve Nnaji', 'Genevieve@yahoo.com', '$P$Bd01csiy15i84E5Oklwbog3y3g1wPx1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Genevieve Nnaji is a Nigerian actress and singer. She won the Africa Movie Academy Award for Best Actress in a Leading Role in 2005.', 'Genevieve.png', 'Genevieve@yahoo.com', 'Jellyfish2.jpg', '', 'Genevieve', 'Nnaji', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', 'Movies /Entertainments', '', 'Art & Entertainments', 'Celebrity', 'genevievennaji', 'GenevieveOfficial', 'genevievennaji1', '', ''),
(10, 'Stella A Damasus', 'stella@yahoo.com', '$P$BdDusDTphZ8ZIGhacxa7K82vZE/ggZ.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Stella Damasus is a Nigerian actress and singer. She was nominated for Best Actress in a Leading Role at the Africa Movie Academy Awards in ', 'stella.png', 'stella@yahoo.com', NULL, '', 'Stella', 'Damasus Aboderin', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Entertainment', '', 'Art & Entertainments', 'Celebrity', 'stelladamasus', 'stelladamasus', 'stelladamasus', '', ''),
(11, 'Bovi Ugboma', 'sheriff@yahoo.com', '$P$BLeCTOpvdrtHtHmguJoFD6sZmqGixW/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Bovi Ugboma is a Nigerian comedian, director, producer, actor, and writer from Delta State, Nigeria. Wikipedia\r\nBorn: September 25, 1979 (ag', 'bovi.png', 'sheriff@yahoo.com', 'IMG_0693.jpg', '', 'Bovi Ugboma', 'Bovi Ugboma', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Comedian', '', 'Art & Entertainments', 'Celebrity', 'Boviugboma', '370730713042087', 'bovicomedian', '', ''),
(12, 'Ramsey Nouah', 'ramsey@yahoo.com', '$P$BPoPGPvzR.X79TsLMxJZ7mgKUkEuY30', 'sssoFKrOPYgBLwWmUUMtii29eRROU4AH3Ui3v8LgY7ZtDDuZEt9DEMN1Fiue', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Ramsey Nouah is a Nigerian actor. He won the Africa Movie Academy Award for Best Actor in a Leading Role in 2010. Wikipedia\r\nBorn: December ', 'Ramsey-nouah.png', 'ramsey@yahoo.com', 'ramsey2.png', '', 'Ramsey', 'Nouah', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Movie / Entertainment', '', 'Art & Entertainments', 'Celebrity', 'ramseytnouah', 'gistzone', 'ramseytnouah', '', ''),
(13, 'Pete Edochie', 'peter@yahoo.com', '$P$Bp6621VRh26JFrbvHCPUIiGo.QRJts.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Pete Edochie is a Nigerian actor. Edochie is considered one of Africa’s most talented actors, by both Movie Awards and Movie Magic’s Africa ', 'peter-udochie1.jpg', 'peter@yahoo.com', 'peter-udochie.jpg', '', 'Pete', 'Edochie', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Movie/ Entertainments', '', 'Art & Entertainments', 'Celebrity', 'peteedochie', 'peteedochie01', 'pete_edochie', '', ''),
(14, 'Patience Ozokwor', 'Patience@yahoo.com', '$P$BMj/7OuZRQlwbFkvve04Pw3JBn7qTy0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Patience Ozokwor is a Nigerian actress. She won the Best Supporting Actress award at the 10th Africa Movie Academy Awards. Wikipedia\r\nBorn: ', 'patience-ozokwor-1.jpg', 'Patience@yahoo.com', 'Patience-Ozokwor2.jpg', '', 'Patience', 'Ozokwor', 'Enugu Nigeria', 'Nigeria', 'both', 'married', 'Art & Entertainments', '', 'Actress/Director', 'Celebrity', 'patienceozokwor', 'PZmamG', 'patienceozokwo', '', ''),
(15, 'Chris Oyakhilome', 'chris@yahoo.com', '$P$BfMCbhvi0sCVtBbOIoDDvZ0JwdbTdI0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Chris Oyakhilome is a Nigerian minister who is the founding president of Believers\' LoveWorld Incorporated also known as \"Christ Embassy\", a', 'pastor-chris1.jpg', 'chris@yahoo.com', 'pastor-chris3.jpg', '', 'Chris', 'Oyakhilome', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Bible-based', '', 'Pastor/The founding president of Believers\' LoveWorld Incorporated also known as', 'Celebrity', 'chrisoyakhilome', 'PastorChrisLive', 'pstchrisonline', '', ''),
(16, 'Enoch Adeboye', 'adeboye@yahoo.com', '$P$BBgh1B/rC1EH1CP4vESD.L0YW26yuf.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Enoch Adejare Adeboye is a Nigerian pastor and the General Overseer of Redeemed Christian Church of God Pastor Adeboye had his B.Sc. in Math', 'PastorAdeboye2.jpg', 'adeboye@yahoo.com', 'adeboye.jpg', '', 'Enoch', 'Adeboye', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Bible-based', '', 'Pastor/General Overseer of Redeemed Christian Church of God', 'Celebrity', 'PastorEAAdeboye', 'PastorEAAdeboye', 'pastoreaadeboye', '', ''),
(17, 'David Oyedepo', 'David@yahoo.com', '$P$Bytq/foH8PbQGBgZp8nFmmALqGwYfp1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'David O. Oyedepo is a Nigerian Christian author, preacher, the founder and presiding Bishop of Living Faith Church World Wide, also known as', 'david3.png', 'David@yahoo.com', 'david2.jpg', '', 'David', 'Oyedepo', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Bible-based', '', 'Pastor/ Bishop of Living Faith Church World Wide, also known as Winners\' Chapel', 'Celebrity', 'BishopDavidOyedepo', 'davidoyedepoministries', 'drdavidoyedepo', '', ''),
(18, 'Robyn Rihanna Fenty', 'Rihanna@yahoo.com', '$P$Bbc/dnNhvW1xcIXuj4SU4pV6TU45Pi0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Robyn Rihanna Fenty, known by her stage name Rihanna, is a Barbadian singer, actress, and fashion designer. Wikipedia\r\nBorn: February 20, 19', 'rihanna-1.jpg', 'Rihanna@yahoo.com', 'Rihanna-2.jpg', '', 'Robyn Rihanna', 'Fenty', 'New York City, New York, U.S', 'Barbadian', 'both', 'in relationship', 'Art & Entertainments', '', 'Singer, actress, and fashion designer.', 'Celebrity', 'RobynRihannaFenty', 'RobzFentyQueen', 'rrfcolombia', '', ''),
(19, 'A.Y Makun', 'ayomakun@yahoo.com', '$P$BF/6Hva3nT3jyPdnWACoFeOFY8hxVn1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Ayo Makun (Ayodeji Richard Makun, also known by his stage name A.Y) is a multi-award winning Nigerian actor, comedian, radio and T.V present', 'AY-1.jpg', 'ayomakun@yahoo.com', 'AY-2.jpg', '', 'A.Y', 'Makun', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Comedian', '', 'Art & Entertainments', 'Celebrity', 'aycomedian', 'aylivejokes.ng', 'aycomedian', '', ''),
(20, 'Tonto Dikeh', 'tonto@yahoo.com', '$P$BveuQk/dqOv9aXvUUX0B5tBCf8/7.U0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Tonto Charity Dikeh, also known as Tonto Dike, is a Nigerian actress and singer from Rivers State and is of the Ikwerre tribe. Dikeh is from', 'tontodikeh1.png', 'tonto@yahoo.com', 'tontonew.png', '', 'Tonto', 'Dikeh', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', 'Movie & Entertainments', '', 'Actress & Singer', 'Celebrity', 'tontolet', 'tontodikehofficialfanpage', 'tontolet', '', ''),
(21, 'Joshua, Temitope Balogun', 'Joshua@yahoo.com', '$P$BNNGI1M0XW7sbpNJEdzr3.I6Z0JgfN1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Temitope Balogun Joshua, commonly referred to as T. B. Joshua, is a Christian minister, televangelist and faith healer. Wikipedia\r\nBorn: Jun', 'T.P-1.jpg', 'Joshua@yahoo.com', 'TB2.jpg', '', 'Joshua,', 'Temitope Balogun', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Bible-based', '', 'Prophet T.B Joshua faith healer.', 'Celebrity', 'tbjoshua', 'goodsamaritan.jesus', 'scoantbjoshua', '', ''),
(22, 'Monalisa Chinda', 'MonalisaChinda@yahoo.com', '$P$Btb0epV9hQWLH5OEdEm2WnNkFdYb2u1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Monalisa Chinda is a Nigerian actress, film producer, television personality and media personality. Wikipedia\r\nBorn: September 13, 1974 (age', 'Monalisa-Chinda2.jpg', 'MonalisaChinda@yahoo.com', 'Monalisa-Chinda3.jpg', '', 'Monalisa', 'Chinda', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Art & Entertainments', '', 'Nigerian actress, film producer, television personality and media personality.', 'Celebrity', 'monalisacode', 'monalisachindafanpage', 'teammonalisac', '', ''),
(23, 'Michel Majid', 'Majidmichel@yahoo.com', '$P$B6U2coePr3nYw6mt.Ut4O6Fd83Vqh4.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Majid Michel is a Ghanaian actor. He received nominations for Best Actor in a Leading Role at the Africa Movie Academy Awards in 2009, 2010,', 'Majid-Michel-1.jpg', 'Majidmichel@yahoo.com', 'Majid-Michel2.jpg', '', 'Michel', 'Majid', 'Accra Ghana', 'Ghana', 'both', 'married', '', '', 'Are & Entertainments', 'Celebrity', 'majidmichel', '328955123793412', 'majidmichelmm', '', ''),
(24, 'Kate Henshaw', 'KateHenshaw@yahoo.com', '$P$BKT/5R4NxyPIFNEaU/8HubP7YerY9N.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Kate Henshaw - also credited as Kate Henshaw-Nuttall - is a Nigerian actress. In 2008 she won the Africa Movie Academy Award for Best Actres', 'kate-henshaw1.jpg', 'KateHenshaw@yahoo.com', 'kate-henshaw2.jpg', '', 'Kate', 'Henshaw', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Art & Entertainments', 'Celebrity', 'KateHenshaw', '230349083296', 'henshawkate', '', ''),
(25, 'Tunde Bakare', 'Tunde@yahoo.com', '$P$BC2sPg7I51J5WcJ6kttCmwkH8HHy4K.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Tunde Bakare is a Nigerian Prophetic-Apostolic pastor. He has received national and international attention for his televangelism, which has', 'Pastor-Tunde-Bakare-1.jpg', 'Tunde@yahoo.com', 'pastor-tunde-bakare2.jpg', '', 'Tunde', 'Bakare', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Prophetic-Apostolic pastor.  He has received national and international attention for his televangelism.', 'Celebrity', 'tundebakare', 'OfficialTundeBakare', 't_bakare', '', ''),
(26, 'Ayodele Joseph Oritsejafor', 'Ayodele@yahoo.com', '$P$BDZ053tvXzImCln3MT9eIroVsm2fDs1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Ayodele Joseph Oritsejafor is the founding and Senior Pastor of Word of Life Bible Church, located in Warri, southern Nigeria, and is curren', 'Ayo.jpeg', 'Ayodele@yahoo.com', 'AYO2.jpg', '', 'Ayodele Joseph', 'Oritsejafor', 'Warri Delta State, Nigeria', 'Nigeria', 'both', 'married', '', '', 'The founding and Senior Pastor of Word of Life Bible Church,', 'Celebrity', 'AyoOritsejafor', '56480042941', 'ayo_oritsejafor', '', ''),
(27, 'T. D. Jakes', 'TDJakes@yahoo.com', '$P$Bx44nixzf4pYBc3E4E9VEnFZddV6tn.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Thomas Dexter \"T. D.\" Jakes, Sr. is the Apostle/Bishop of The Potter\'s House, a non-denominational American megachurch, with 30,000 members.', 'td-jakes-1.jpg', 'TDJakes@yahoo.com', 'Bishop-TD-2.jpg', '', 'T. D.', 'Jakes', 'N/A', 'United States', 'both', 'married', '', '', 'Thomas Dexter \"T. D.\" Jakes, Sr. is the Apostle/Bishop of The Potter\'s House, a non-denominational American megachurch, with 30,000 members.', 'Celebrity', 'bishopjakes', 'bishopjakes?fref=nf', 'bishopjakes', '', ''),
(28, 'Matthew Ashimolowo', 'Matthew@yahoo.com', '$P$BlU4TNB11I3yRvgh.HcZ/81D4Rm/I5/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Matthew Ashimolowo is the Senior Pastor of Kingsway International Christian Centre in London. His Winning Ways programme is aired daily on P', 'Matthew-Ashimolowo1.jpeg', 'Matthew@yahoo.com', 'MATTHEW-ASHIMOLOWO-2.jpg', '', 'Matthew', 'Ashimolowo', 'London United Kindgdom', 'Nigeria', 'both', 'married', '', '', 'Senior Pastor of Kingsway International Christian Centre in London.', 'Celebrity', 'matthewashimolowo', 'KICCUK', 'kicclondon', '', ''),
(29, 'Chris Okotie', 'ChrisOkotie@yahoo.com', '$P$BKbpuTx2GnYFXe.sOXT8Wkjlpq.YHN/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Christopher Oghenebrorie Okotie is a leading Nigerian televangelist and the pastor of the Household of God Church International Ministries, ', 'Chris-Okotie1.jpg', 'ChrisOkotie@yahoo.com', 'Chris-Okotie3.jpeg', '', 'Chris', 'Okotie', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Christopher Oghenebrorie Okotie is a leading Nigerian televangelist and the pastor of the Household of God Church International Ministries, a Pentecostal congregation in Lagos, Nigeria since February 1987.', 'Celebrity', 'chrisokotie', '43434048829', 'revchrisokotie', '', ''),
(30, 'Ini Edo', 'iniedo@yahoo.com', '$P$BernWLxd7JHsE327d8Mv4AQDQzPm9T0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Ini Edo is a Nigerian actress. She began her film career in the year 2000, and has featured in more than 200 movies since that time. Edo is ', 'Ini-Edo-2.jpg', 'iniedo@yahoo.com', 'Ini-Edo-21.jpg', '', 'Ini', 'Edo', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Nigerian actress', 'Celebrity', 'iniedo', '196117450466359', 'loveiniedo', '', ''),
(31, 'David Ibiyeomie Ibiyeomie', 'DavidIbiyeomie@yahoo.com', '$P$BjWEzg6tHrupthoBY6g7c.osWVoGtU/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'David Ibiyeomie (born October 21, 1962) is a Nigerian pastor. He is the founder and presiding pastor of Salvation Ministries Worldwide (Home', 'salvetion3.jpg', 'DavidIbiyeomie@yahoo.com', 'servation1.jpeg', '', 'David Ibiyeomie', 'Ibiyeomie', 'Port Harcourt Nigeria', 'Nigeria', 'both', 'married', '', '', 'Nigerian pastor. He is the founder and presiding pastor of Salvation Ministries Worldwide', 'Celebrity', 'davidibiyeomie', '261166207258335', 'davidibiyeomie', '', ''),
(32, 'Psquare Peter &amp; Paul', 'psquare@yahoo.com', '$P$BTXMa9NkSDx814qRHp04s.HTnmu0V7.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'P-Square are a Nigerian R&B duo composed of identical twin brothers Peter Okoye and Paul Okoye.[1] They produce and release their albums thr', 'P-Square_1.jpg', 'psquare@yahoo.com', 'P-Square1-3.jpg', '', 'Psquare', 'Peter &amp; Paul', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'P-Square are a Nigerian R&B duo composed of identical twin brothers Peter Okoye and Paul Okoye.', 'Celebrity', 'psquare', 'mypsquare?fref=nf', 'hashtagpsquare', '', ''),
(33, 'Sheriff Solomon', 'sheriff2@yahoo.com', '$P$B5z0HhITd8E/Tk2QrVMr3Ryy/24nf1/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Solomon is a great man of God in the world without fear of any body.', 'image21.jpg', 'sheriff2@yahoo.com', 'image22.jpg', '', 'Sheriff', 'Solomon', 'London UK', 'Nigeria', 'female', 'single', '', '', 'Student', 'Follower', NULL, NULL, NULL, '', ''),
(34, 'Testuser Testuser', 'testuser.cometchat@gmail.com', '$P$BfJyazP7EbNAE7jmhC0LF19nfYyD/h/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'testuser.cometchat@gmail.com', NULL, '', 'Testuser', 'Testuser', '', '', 'male', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(35, 'OPC', 'OPC_fanpageramsey@yahoo.com', '$P$B2C2wpoMJOpFJQrNsLR3/gyZKNTKGv.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'Penguins.jpg', 'OPC_fanpageramsey@yahoo.com', 'Jellyfish.jpg', '', 'OPC', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(36, 'John Okafor', 'okafor@yahoo.com', '$P$Bm1q0JIF54lUWILcfU6.UIaAhd.TRj0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'John Okafor is a Nollywood actor and comedian. Okafor is considered to be one of Nigeria’s most talented comic characters. His humorous acti', 'Ibu2.jpg', 'okafor@yahoo.com', 'Ibu1.jpg', '', 'John', 'Okafor', 'Enugu Nigeria', 'Nigeria', 'both', 'married', '', '', 'Art/ Entertainments', 'Follower', NULL, NULL, NULL, '', ''),
(37, 'John Okafor', 'okafor2@yahoo.com', '$P$BPMOIQtVQhv7hB9LKXqvhuu37cwS9R.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'John Okafor is a Nollywood actor and comedian. Okafor is considered to be one of Nigeria’s most talented comic characters. His humorous acti', 'Ibu21.jpg', 'okafor2@yahoo.com', 'Ibu11.jpg', '', 'John', 'Okafor', 'Enugu Nigeria', 'Nigeria', 'both', 'married', '', '', 'Art/Entertainments', 'Celebrity', 'johnokafor', '505857692794341', 'IBUJOHN', '', ''),
(38, 'Julious Agwu', 'julious@yahoo.com', '$P$B75Bu7XzvNOcalxQuvpCkEnEuyrl2I.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Iam the Real Julius Agwu- an actor, director, compere, comedian, musicomedian, life-coach, public-speaker and author... Bookings call: +2348', 'Julious-Argu.jpg', 'julious@yahoo.com', 'Julious-Argu.jpg', '', 'Julious', 'Agwu', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Art & Entertainment', '', 'Art & Entertainment', 'Follower', NULL, NULL, NULL, '', ''),
(39, 'solomonji', 'simonpeter398@yahoo.co.uk', '$P$BJ97yveZxGlhhKb4kJTa3sBM6hkMOc1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'solomonji', 'abc_med1.jpg', '', 'Naija', 'Solomon', '', '', '', '', '', '', '', 'Admin', NULL, NULL, NULL, '', ''),
(40, 'Peter Okoye', 'peterj@yahoo.com', '$P$BhpyERd6Ml7Yo9C6MO4SyU4wSrYgB.0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'P-Square are a Nigerian R&B duo composed of identical twin brothers Peter Okoye and Paul Okoye. They produced and released their albums thro', 'Peter-Okoye.png', 'peterj@yahoo.com', 'Jellyfish.jpg', '', 'Peter', 'Okoye', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Act/Entertainments', '', 'Music group: P-Square (Since 2001)', 'Celebrity', 'peterpsquare', 'OfficialPeterPsquare', 'peterpsquare', '', ''),
(41, 'Paul Okoye', 'paulj@yahoo.com', '$P$BFv6zpghirbS2cpbJrcRnrs5qtIrfi.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'P-Square are a Nigerian R&B duo composed of identical twin brothers Peter Okoye and Paul Okoye. They produced and released their albums thro', 'Paul-Okoye.jpg', 'paulj@yahoo.com', 'Paul-Okoye.jpg', '', 'Paul', 'Okoye', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Music group', '', 'Music Group Psquare', 'Celebrity', 'paulokoye', 'nonsookoye.psquare', 'rudeboypsquare', '', ''),
(42, 'Jackie Appiah', 'Jackie@yahoo.com', '$P$BPWr/pIdXP8ERUgLCuL93aV4nQvu1y/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Jackie Appiah Agyemang is a Ghanaian actress. For her work as an actress she has received several awards and nominations, including the awar', 'jackie.jpg', 'Jackie@yahoo.com', 'jackie.jpg', '', 'Jackie', 'Appiah', 'Accra Ghana', 'Ghana', 'both', 'in relationship', 'Actress', '', 'Act/ Entertainments', 'Celebrity', 'jackieappiah', 'jackieappiahworld', 'jackie_appiah', '', ''),
(43, 'John Dumelo', 'John1@yahoo.com', '$P$BtMwN3H5W7vUZOfHugTGcX7LlvATf//', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'John Dumelo is a Ghanaian actor and humanitarian. He was nominated for categories Most Promising Actor and Best Actor in a Supporting Role a', 'john.jpg', 'John1@yahoo.com', 'john.jpg', '', 'John', 'Dumelo', 'Accra Ghana', 'Ghana', 'both', 'in relationship', '', '', 'Art/Entertainments', 'Celebrity', 'JohnDumelo', 'Johndumeloofficial', 'johndumelo1', '', ''),
(44, 'Sarkodie Sarkodie', 'Sarkodie@yahoo.com', '$P$B7lZOpO78r1r0x41fY3dB0OA/MVOwh1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Michael Owusu Addo, known by his stage name Sarkodie, is a Ghanaian hip hop and hiplife recording artist from Tema. \r\nBorn: July 10, 1985 (a', 'Sarkodie.jpg', 'Sarkodie@yahoo.com', 'Sarkodie.jpeg', '', 'Sarkodie', 'Sarkodie', 'Accra Ghana', 'Ghanaian', 'both', 'in relationship', '', '', 'Hip-hop artist', 'Celebrity', 'sarkodie1', 'SarkodieFansBand', 'sarkodie', '', ''),
(45, 'Yvonne Okoro', 'Okoro@yahoo.com', '$P$BHhcyMreCbEdln2Q1k.stN7UDTZCBj/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Chinyere Yvonne Okoro is a Ghanaian actress of Nigerian and Ghanaian origin. She has received Ghana Movie Awards Best Actress Award in 2010 ', 'Yvonne-Okoro.jpg', 'Okoro@yahoo.com', 'Yvonne-Okoro.jpg', '', 'Yvonne', 'Okoro', 'Accra Ghana', 'Ghanaian', 'both', 'in relationship', '', '', 'Actress', 'Celebrity', 'yvonneokoro', '365510437985?sk=photos_stream', 'yvonneokoro', '', ''),
(46, 'Joselyn Dumas', 'Joselyn@yahoo.com', '$P$B0d2uQLmWQh5uJFU65NXPoffxnqUBs0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Joselyn Dumas is a Ghanaian television host and actress. In 2014 she starred in a A Northern Affair, a role that earned her a Ghana Movie Aw', 'Joselyn-Dumas.jpg', 'Joselyn@yahoo.com', 'Joselyn-Dumas.jpg', '', 'Joselyn', 'Dumas', 'Accra Ghana', 'Ghanaian', 'both', 'in relationship', '', '', 'Actress', 'Celebrity', 'joselyn_dumas', 'JoselynDumas', 'luvjoselyndumas', '', ''),
(47, 'Omotola Jalade Ekeinde', 'Omotola@yahoo.com', '$P$Bt2KNHRr04UNGFvuf7fT.tW9cNIuoL.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Omotola Jalade Ekeinde is a Nigerian actress, singer, philanthropist and former model of an Ondo descent from Lagos, Nigeria. Since her Noll', 'omotola1.jpg', 'Omotola@yahoo.com', 'Omotola.jpg', '', 'Omotola', 'Jalade Ekeinde', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Actress', 'Celebrity', 'realomosexy', 'Omotolaofficial', 'omotolafans', '', ''),
(48, 'Don Jazzy', 'DonJazzyj@yahoo.com', '$P$BmKl5rlYcUPwe1UTfrxlfJlViawhQj.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Michael Collins Ajereh, better known as Don Jazzy, is a Nigerian Multi award-winning record producer, singer-songwriter, musician, former CE', 'Don-Jazzy.jpg', 'DonJazzyj@yahoo.com', 'Don-Jazzy.jpg', '', 'Don', 'Jazzy', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Record producer, singer-songwriter, musician, former CEO of Nigerian record label', 'Celebrity', 'DonDorobucci', 'OFFICIALDONJAZZY', 'DONJAZZY', '', ''),
(49, 'D\'banj O', 'Dbanj@yahoo.com', '$P$BZ3nDKMaRD0gQGyTM68Gvvh2DFB7fe0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Oladapo Daniel Oyebanjo is a Nigerian singer-songwriter, harmonica player, and businessman. He has won several music awards, including the a', 'Dbanj11.jpg', 'Dbanj@yahoo.com', 'Jellyfish5.jpg', '', 'D\'banj', 'Oladapo Daniel Oyebanjo', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', 'singer-songwriter, harmonica player, and businessman.', '', 'Singer-songwriter', 'Celebrity', 'iamdbanj', 'iambangalee?sk=photos', 'teamdbanjdaily', '', ''),
(50, 'Davido Adedeji Adeleke', 'davido@yahoo.com', '$P$B4w6FyU5FpoIq4E25Jck79lt.kmjxQ/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'David Adedeji Adeleke (born November 21, 1992),[1][2] better known by his stage name Davido, is an American-born Nigerian recording artist, ', 'davido.jpeg', 'davido@yahoo.com', 'davido.jpeg', '', 'Davido', 'Adedeji Adeleke', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', 'Recording artist, performer and record producer.', '', 'Art/Entertainments', 'Celebrity', 'davidoofficial', 'iamdavidohknmusic', 'iam_davido', '', ''),
(51, 'Banky W Olubankole', 'bankyw@yahoo.com', '$P$BAFVHqM6I1NByE5.6qRaINFzmGyH..0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Birth name	Olubankole Wellington\r\nAlso known as	Banky\r\nBorn	27 March 1981 (age 34)\r\nUnited States\r\nGenres	R&B\r\nOccupation(s)	Singer-songwrit', 'bankyw.jpg', 'bankyw@yahoo.com', 'bankyw.jpg', '', 'Banky W', 'Olubankole', 'Lagos Nigeria', 'Nigeria', 'both', 'married', 'Olubankole Wellington, known under the stage name Banky W, is a Nigerian R&B artist.', '', 'Art/Entertainments', 'Celebrity', 'bankywellington', 'ItsBankyW', 'bankyw', '', ''),
(52, 'David Cameron', 'davidcameron@yahoo.com', '$P$BKxxVCJxG6teIrojw5/X4R6g4yoBwH.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'David William Donald Cameron is a British politician who has served as the Prime Minister of the United Kingdom since 2010, as Leader of the', 'David-Cameron1.jpg', 'davidcameron@yahoo.com', 'david_cameron.jpg', '', 'David', 'Cameron', 'London/England', 'UK', 'both', 'married', '', '', 'British Prime Minister', 'Celebrity', 'davidcameron', 'DavidCameronOfficial', 'number10gov', '', ''),
(53, 'Barack Obama', 'obama@yahoo.com', '$P$B.785enctzVq72UFAyNrvDIgCOU3VJ.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Barack Hussein Obama II is the 44th and current President of the United States, and the first African American to hold the office.\r\nBorn: Au', 'obama.jpg', 'obama@yahoo.com', 'barack-obama3.jpg', '', 'Barack', 'Obama', 'Washington/ U.S', 'U.S', 'both', 'married', '', '', '44th U.S. President', 'Celebrity', 'barackobama', 'WhiteHouse', 'barackobama', '', ''),
(54, 'Desmond Elliot', 'desmondj@yahoo.com', '$P$B4Pd0J.6RU6pAuOftzv32VxY/kUljj.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Desmond Elliot is a Nigerian actor and director, and politician who has starred in over two hundred films and a number of television shows a', 'desmond.jpg', 'desmondj@yahoo.com', 'desmond.jpg', '', 'Desmond', 'Elliot', 'Lagos Island, Lagos, Nigeria', 'Nigeria', 'both', 'married', '', '', 'Art/Entertainments', 'Celebrity', 'desmondelliot', '158109514286374', 'deselliot', '', ''),
(55, 'Ice Prince', 'iceprince@yahoo.com', '$P$BWi3xya4XiNnTmJjnva1TiZjfM3lBV0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Panshak Zamani, better known by his stage name Ice Prince, is a Nigerian hip hop recording artist and actor. He rose to fame after releasing', 'Ice-Prince1.jpg', 'iceprince@yahoo.com', 'Ice-Prince1.jpg', '', 'Ice', 'Prince', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Nigerian hip hop recording artist and actor.', 'Celebrity', 'iceprincezamani', '167069146652578', 'Iceprincezamani', '', ''),
(56, 'Tiwa Savage', 'tiwasavagej@yahoo.com', '$P$BgQ3ep/vhSX45VB8aMEerEgOiaGnzK1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Tiwatope Savage-Balogun, better known by her stage name Tiwa Savage, is a Nigerian singer-songwriter, recording artist, performer and actres', 'Tiwa-Salvage1.jpeg', 'tiwasavagej@yahoo.com', 'Tiwa-Salvage1.jpeg', '', 'Tiwa', 'Savage', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Nigerian singer-songwriter, recording artist, performer and actress.', 'Celebrity', 'officialtiwasavage', '145754122141160', 'tiwababyboo', '', ''),
(57, 'Chris Brown', 'chrisbrownj@yahoo.com', '$P$BPTce.LesGnTPfbwH.d2f3JWxyOCSk.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Christopher Maurice \"Chris\" Brown is an American recording artist, dancer and actor. Born in Tappahannock, Virginia, he taught himself to si', 'chris-brown2.jpg', 'chrisbrownj@yahoo.com', 'chris-brown2.jpg', '', 'Chris', 'Brown', 'New York', 'United State', 'both', 'in relationship', '', '', 'American recording artist, dancer and actor.', 'Celebrity', 'chrisbrownofficial', 'chrisbrown', 'chrisbfacts', '', ''),
(58, '50 Cent Curtis James. J III', '50Cent@yahoo.com', '$P$BOgCMKP4pyH/Kw8/oq3IXp.mkeRslj0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '50 Cent\r\nRapper\r\nCurtis James Jackson III, better known by his stage name 50 Cent, is an American rapper, singer, entrepreneur, investor and', '50Cent2.jpg', '50Cent@yahoo.com', '50Cent1.jpg', '', '50 Cent', 'Curtis James. J III', 'New York City', 'United State', 'both', 'in relationship', '', '', 'American rapper, singer, entrepreneur, investor and actor from New York City.', 'Celebrity', '50cent', '50cent', '50cent', '', ''),
(59, 'Jim Iyke', 'jimikye@yahoo.com', '$P$B5yesQKlWQBXp5dp5TZu6gLN4GIHh1/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Jim Iyke\r\nActor\r\nJames Ikechukwu Esomugha, popularly known as Jim Iyke, is a Nigerian actor in Nigeria\'s movie industry and one of the stars', 'Jim-Iyke5.jpg', 'jimikye@yahoo.com', 'jim_iyke2.jpg', '', 'Jim', 'Iyke', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Art/Entertainments', 'Celebrity', 'JimIyke', '428904117198002', 'teamjimiyke1', '', ''),
(60, '2face Idibia', '2facej@yahoo.com', '$P$B8IVFoLFM9Sw2Ww8a/sV0ICe7VleQ1.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Innocent Ujah Idibia, better known by his stage name 2face Idibia, is a Nigerian singer, songwriter and record producer. He officially disco', '2face2.jpg', '2facej@yahoo.com', '2face2.jpg', '', '2face', 'Idibia', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Singer', 'Celebrity', '2faceidibia1', '32289393200', 'hypertekdigital', '', ''),
(61, 'Segun Arinze', 'segun@yahoo.com', '$P$B7A3joKI9UFqNQa2AO9/vy8XWizwgN.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Segun Arinze is a Nigerian actor and singer. \r\nBorn: Onitsha, Nigeria\r\nNationality: Nigerian', 'segun-1.jpg', 'segun@yahoo.com', 'Jellyfish1.jpg', '', 'Segun', 'Arinze', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Nigeria Nollywood Actor & Ex- AGN President', 'Celebrity', 'segunarinze', 'SegunArinzefans', 'segunarinzeaina', '', ''),
(62, 'Linda Ikeji', 'linda@yahoo.com', '$P$Bs22ARUUPMPUISZYFCeaGklAva2MAc0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Linda Ikeji is a Nigerian blogger, writer, model and entrepreneur best known for her controversial publications.', 'Linda3.jpg', 'linda@yahoo.com', 'Jellyfish2.jpg', '', 'Linda', 'Ikeji', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Nigerian blogger, writer, model and entrepreneur.', 'Celebrity', 'officiallindaikeji', 'lindaikejiblogs', 'lindaikeji', '', ''),
(63, 'Nonso Diobi', 'nonso@yahoo.com', '$P$B6okucw/CyZmqsjmf0iHEsprSC/kAZ0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Nonso Diobi who has featured in over 60 movies was born on July 17th in Enugu to the Diobi\'s family. However, Nonso grew up in Anambra state', 'nonso1.jpg', 'nonso@yahoo.com', 'Jellyfish3.jpg', '', 'Nonso', 'Diobi', 'Lagos Nigeria', 'Nigeria', 'both', 'single', '', '', 'Art/Entertainments', 'Celebrity', 'nonsodiobi', '161853350534563', 'iam_nonsodiobi', '', ''),
(64, 'Mercy Johnson', 'mercy@yahoo.com', '$P$B4NGXxfBVlX/HvwuWina.W5ZcBBysn.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Mercy Johnson Okojie, popularly known as Mercy Johnson, was born in Lagos on 28 August 1984, is a Nigerian actress who made her acting debut', 'MJ2.jpg', 'mercy@yahoo.com', 'MJ2.jpg', '', 'Mercy', 'Johnson', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Nigerian actress', 'Celebrity', 'mercyjohnsonokojie', '279627022197605', 'realmercyj', '', ''),
(65, 'Chika Ike', 'chika@yahoo.com', '$P$BebO.62bBM9IXkC/egyzcqlD6M9NWd0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Chika \'Nancy\' Ike is a leading Nigerian actress, entrepreneur and philanthropist. She is a UN Ambassador, Refugee Ambassador for Displaced p', 'chika.jpg', 'chika@yahoo.com', NULL, '', 'Chika', 'Ike', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Nigerian actress, entrepreneur and philanthropist.', 'Follower', NULL, NULL, NULL, '', ''),
(66, 'Chika Ika', 'chikaj@yahoo.com', '$P$BCLe/sEsx3sv2Ob0F8Pgegd5iqQrqh/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Chika \'Nancy\' Ike is a leading Nigerian actress, entrepreneur and philanthropist. She is a UN Ambassador, Refugee Ambassador for Displaced p', 'chika1.jpg', 'chikaj@yahoo.com', 'chika.jpg', '', 'Chika', 'Ika', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Nigerian actress, entrepreneur and philanthropist.', 'Celebrity', 'chikaike', '76330522571', 'chikaike', '', ''),
(67, 'Osita Iheme', 'osita@yahoo.com', '$P$BHd2zU3qRvSwRUFtn3XJQT2tgSQOiH1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Osita Iheme is a Nigerian actor. He is widely known for playing the role of \'Pawpaw\' in the film Aki na Ukwa alongside Chinedu Ikedieze. In ', 'osita.jpg', 'osita@yahoo.com', 'osita1.jpg', '', 'Osita', 'Iheme', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Art/Entertainments', 'Celebrity', 'ositaiheme', 'ositaihemeinspires', 'ositaiheme', '', ''),
(68, 'Chinedu Ikedieze', 'chinedu@yahoo.com', '$P$BbNp7wQeSXf8SqJspQ.GXV.dK57TyJ1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Chinedu Ikedieze, MFR is a Nigerian actor. He is best known for playing alongside Osita Iheme in most movies after their breakthrough in the', 'chinedu.jpg', 'chinedu@yahoo.com', 'Jellyfish4.jpg', '', 'Chinedu', 'Ikedieze', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Art/Entertainments', 'Celebrity', 'chineduikedieze', 'chinedu.ikedieze', 'edukapo', '', ''),
(69, 'Rita Dominic', 'ritadominic@yahoo.com', '$P$BtfyGzp4HPk6HxanznCzcU6Mp90xn01', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Rita Uchenna Nkem Dominic Waturuocha is a Nigerian actress. In 2012 she won the Africa Movie Academy Award for Best Actress in a Leading Rol', 'rita-2.jpg', 'ritadominic@yahoo.com', 'rita.jpg', '', 'Rita', 'Dominic', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Nigerian actress.', 'Celebrity', 'ritadominic', 'RitaDominicOfficial', 'ritaudominic', '', ''),
(70, 'Iyanya Onoyom Mbuk', 'iyanya@yahoo.com', '$P$Byv3WLUPBruUno4IiQQJUM1143Yhim1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Iyanya Onoyom Mbuk, known by his mononym Iyanya, is a Nigerian recording artist, singer, songwriter and performer. He is best known for winn', 'iyanya-1.jpg', 'iyanya@yahoo.com', 'Iyanya.jpg', '', 'Iyanya', 'Onoyom Mbuk', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Nigerian recording artist, singer, songwriter and performer', 'Celebrity', 'iyanya', 'iyanyaofficial', 'iyanya', '', ''),
(71, 'Mike Ezuruonye', 'Mikej@yahoo.com', '$P$BSOBk0edg2pyKwPurzkFiTwedS5kYT.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Mike Ezuruonye is a Nigerian actor. Wikipedia\r\nBorn: September 21, 1982 (age 32), Nigeria\r\nNationality: Nigerian\r\nSpouse: Nkechi Nnorom (m. ', 'Mike2.jpg', 'Mikej@yahoo.com', 'Mike.jpg', '', 'Mike', 'Ezuruonye', 'Lagos Nigeria', 'Nigeria', 'both', 'married', '', '', 'Nigeria Actor', 'Celebrity', 'mikeezu', 'mikeezuOfficial', 'realmikeezu', '', ''),
(72, 'Vangard Daily News', 'vangard@yahoo.com', '$P$BropF5DE1ZMPF/tNZhN.d8rlHbuz99.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'This article is about the Nigerian daily. For the white supremacist website, see Vanguard News Network.\r\nThe Vanguard is a daily newspaper p', 'vangard.jpeg', 'vangard@yahoo.com', 'Vanguard-News-135140476511057-cover.jpg', '', 'Vangard', 'Daily News', 'Lagos Nigeria', 'Nigeria', 'both', 'single', '', '', 'Daily newspaper', 'Celebrity', 'vanguardngr', 'vanguardngr', 'vanguardngrnews', '', ''),
(73, 'Sahara Reporters', 'sahara@yahoo.com', '$P$BWM2g5k.l0sy0yi2cQNbh.B74sJMOb1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Sahara Reporters is an online news agency that focuses on promoting citizen journalism by encouraging everyday people to report stories abou', 'sahara.jpg', 'sahara@yahoo.com', 'sahara.jpg', '', 'Sahara', 'Reporters', 'Nigeria', 'Nigeria', 'both', 'single', '', '', 'Daily News Reporters', 'Celebrity', 'saharareporters', 'ReportYourself', 'saharareporters', '', ''),
(74, 'BBC NEWS', 'bbcnews@yahoo.com', '$P$BNCZmo1Wu7jR1ILBbtWoHpCc1WkCFH/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'The British Broadcasting Corporation is the public-service broadcaster of the United Kingdom, headquartered at Broadcasting House in London.', 'bbc2.png', 'bbcnews@yahoo.com', NULL, '', 'BBC', 'NEWS', 'London UK', '', 'both', 'single', '', '', 'broadcaster of the United Kingdom, headquartered at Broadcasting House in London.', 'Celebrity', 'bbcworldnews', 'bbcworldnews', 'bbcworld', '', ''),
(75, 'Jeremy Corbyn', 'Jeremy@yahoo.com', '$P$B/.aIVck2vykpHTT29HavKuQwoxSUh1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Jeremy Bernard Corbyn is a British Labour Party politician who is Leader of the Labour Party and the Leader of the Opposition. He has been t', 'Jeremy-Corbyn-330250343871.jpg', 'Jeremy@yahoo.com', 'Jeremy-Corbyn-330250343871-cover.jpg', '', 'Jeremy', 'Corbyn', 'MP Islington North, London, The Labour Party', 'United Kingdom', 'both', 'married', '', '', 'Leader of the Labour Party and the Leader of the Opposition.', 'Celebrity', 'jeremyforlabour', '330250343871', 'jeremycorbyn', '', ''),
(76, 'Mike Godson', 'MikeGodson@yahoo.com', '$P$BOvbo0Bi7A2s7eKOvAT2wKk9HVqX6d/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Michael godson ifeanyichukwu, better known as Mike Godson is a Nigerian actor from IMO State, born in Kano state Nigeria. Since his Nollywoo', 'mike2.png', 'MikeGodson@yahoo.com', 'Jellyfish.jpg', '', 'Mike', 'Godson', 'Lagos Nigeria', 'Nigeria', 'both', 'in relationship', '', '', 'Art/Ent', 'Celebrity', 'MikeGodson', '534318140038708', 'mikegodson2u', '', ''),
(77, 'Ben Lecovoney', 'mash2x2@gmail.com', '$P$B4.A1RHmOCraJCP7Cq9aPeK.j6ZY0k1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', '', 'campers-jessica-jones.jpg', 'mash2x2@gmail.com', NULL, '', 'Ben', 'Lecovoney', '', '', 'male', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(78, 'Sayed Taqui', 'sayedwp@gmail.com', '$P$BvNEEi3cRr19v1LfLKvUCvw.OLQTRV0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'me1.jpg', 'sayedwp@gmail.com', NULL, '', 'Sayed', 'Taqui', '', '', 'female', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(79, 'John Doe', 'raheelwebstech@gmail.com', '$P$BcoCC71rvuI1MMbK2A3v1DIB4uiV0l/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheelwebstech@gmail.com', NULL, '', 'John', 'Doe', '', '', 'female', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(80, 'Raheeldsa Hassansda', 'raheelwebstech1a@gmail.com', '$P$BH8m1YOSEsJr4SM3q7P8A/5Nx9ByBp/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheelwebstech1a@gmail.com', NULL, '', 'Raheeldsa', 'Hassansda', '', '', 'female', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(81, 'John Doe', 'raheelwebstecsssssh1a@gmail.com', '$P$Bkxe7xPiAv260nv6eFuiHYAT0EiGMd/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheelwebstecsssssh1a@gmail.com', NULL, '', 'John', 'Doe', '', '', '', '', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(82, 'Raheel We', 'raheelwe2222bstech@gmail.com', '$P$B9ac8D83G/AoGzzM.QgdQ7PQG92VWI1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheelwe2222bstech@gmail.com', NULL, '', 'Faaaaaaddd', 'Fdddddddddddddd', '', '', '', '', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(83, 'Raheel Webtech', 'raheelawqwebstech@gmail.com', '$P$BJOzRoZSOTiHCRlg8XyBOKIYHCX2yd/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheelawqwebstech@gmail.com', NULL, '', 'Faaaaaaddd', 'Fdddddddddddddd', '', '', '', '', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(84, 'Raheel Webtech', 'raheelwesssbstech@gmail.com', '$P$B4vSUgipKkYLo1eCCGr8WXoq9lKNdl.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheelwesssbstech@gmail.com', NULL, '', 'Faaaaaaddds', 'Dsadasd', '', '', '', '', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(85, 'Raheel', 'raheel@gmail.com', '$P$BY7Sl8mFbFzcjCmQ3hdYN2w1yBiS0W1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheel@gmail.com', NULL, '', 'Hyyhuhuh', 'Uhiuhiuh', '', '', '', '', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(86, 'First Bank Nigeria', 'firstbank@yahoo.com', '$P$BsLEKh96d/1Zsf4u.mwrKl9B1pou8n0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'First Bank of Nigeria, sometimes referred to as FirstBank, is a Nigerian multinational bank and financial services company. It is the countr', 'Jellyfish3.jpg', 'firstbank@yahoo.com', 'Hydrangeas.jpg', '', 'First Bank', 'Nigeria', 'Lagos', 'Nigeria', 'both', 'single', '', '', 'First Bank Organisation', 'Celebrity', NULL, NULL, NULL, '', ''),
(87, 'Solomon Joseph', 'solomonjoseph@yahoo.com', '$P$Bldf7Ydw5bC51bI0mnO7r/TVVI77aS/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'SolomonJ-356.jpg', 'solomonjoseph@yahoo.com', NULL, '', 'Solomon', 'Joseph', '', '', 'female', 'single', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(88, 'Johnsss Doesssss', 'raheelwebswwwwwwwtech1a@gmail.com', '$P$Bl5iwSpMwBVQhJDVrWE3x4piefj/IH1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheelwebswwwwwwwtech1a@gmail.com', NULL, '', 'Johnsss', 'Doesssss', '', '', '', '', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(89, 'Raheelhassan Murtaza', 'raheel@mailinator.com', '$P$BwvWy9lcwHgRrAC6edWz2GI2GT672f.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheel@mailinator.com', NULL, '', 'Raheelhassan', 'Murtaza', '', '', '', '', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(90, 'Test New User Test', 'raheel2@mailinator.com', '$P$BNxJGt8tMyhyjwmNEfWvTrXthJ.j7G0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheel2@mailinator.com', NULL, '', 'Test New User', 'Test', '', '', '', '', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(91, 'Kinga Tokoli', 'tokolik980@yahoo.com', '$P$BHcaVONrgS3ALgK2z51knRVIS6rhPA/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'Kinga is Nice and good looking woman able to achieve', 'SAM_3896.jpg', 'tokolik980@yahoo.com', 'IMG_0613.jpg', '', 'Kinga', 'Tokoli', 'London UK', 'United Kingdom', 'both', 'single', 'Hairdresser', '', 'Professional', 'Celebrity', NULL, NULL, NULL, '', ''),
(92, 'John Doe', 'raheel222222@mailinator.com', '$P$B/sztd3Ges5ME9YQKtgPfNHoP99rpc0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheel222222@mailinator.com', NULL, '', 'John', 'Doe', '', '', 'female', 'single', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(93, 'raja khan', 'raheesl222222@mailinator.com', '$P$BZmywH8FVvOwCM6FqtEoV9r1/.H9Nt/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheesl222222@mailinator.com', NULL, '', 'John', 'Doe', '', '', 'female', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(94, 'John Doe', 'raheel22ss2222@mailinator.com', '$P$BRO4wkjlZJPIVOTYt0iA5TfCLnGTq0/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'raheel22ss2222@mailinator.com', NULL, '', 'John', 'Doe', '', '', 'female', 'single', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(95, 'John Paul', 'johnpaul@yahoo.com', '$P$BYy6NA85LrHRIu7AhX.Wmp24LviTGo1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'SAM_3925.jpg', 'johnpaul@yahoo.com', NULL, '', 'John', 'Paul', '', '', 'female', 'single', 'Educator', '', 'Professional Lecturer', 'Celebrity', NULL, NULL, NULL, '', ''),
(96, 'Fight for Your Right', 'FightforYourRight_fanpagepeter@yahoo.com', '$P$B/ZtvEYeAN7d2Ce/M2cSN.p3O8xUJo.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'buchi.png', 'Fight for Your Right_fanpagepeter@yahoo.com', 'buchi.png', '', 'Fight for Your Right', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(97, 'Sdjflfsdj Dslfjlsdf', 'jsldfjlsfjlsjfdslj@gmail.com', '$P$BXjoXRDSbbOHIdarMBEdgWWSpWhzZq0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', '', 'hero-profile.jpg', 'jsldfjlsfjlsjfdslj@gmail.com', NULL, '', 'Sdjflfsdj', 'Dslfjlsdf', '', '', 'female', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(98, 'Deepak Jangid', 'deepakj@unv7.com', '$P$BXNsdyGFyO8unmTaAfMQdZJwS5t02v1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'deepakj@unv7.com', NULL, '', 'Deepak', 'Jangid', '', '', 'female', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(99, 'Surendra RAo', 'surendrar@unv7.com', '$P$BnN9rClOKf6x69iSysI.2wz7v/.rWm.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'surendrar@unv7.com', NULL, '', 'Surendra', 'RAo', '', '', 'female', 'single', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(100, 'Apoorv Vyas', 'apoorv.yugtia@gmail.com', '$P$BKin7dXe1mGu2DZKtsA64UDnhxUb/w0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'asdfasdfasdfasdfdf', NULL, 'apoorv.yugtia@gmail.com', NULL, '', 'Apoorv', 'Vyas', 'Ahmedabad', 'India', 'female', 'single', 'Website Development', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(101, 'Apps Vyas', 'apvvyas@ymail.com', '$P$BN.J6dWakUUz4SNK4PRP32DvO2fQjP/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'apvvyas@ymail.com', NULL, '', 'Apps', 'Vyas', '', '', 'female', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(102, 'Apps Vyas', '22vyas@gmail.com', '$P$Bq1i9r0TRTVR82b6Bsj6NPSofn5WIT0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', '', NULL, '22vyas@gmail.com', NULL, '', 'Apps', 'Vyas', '', '', '', '', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(103, 'Mayur Devmurari', 'mayur.devmurari@yugtia.com', '$P$B83dBnkYJ7LtAxo4axgPx1mbzKIOyf0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Enjoy...things here...', '10537210_700132156725219_9197125201380104379_o-1.jpg', 'mayur.devmurari@yugtia.com', 'Kathiyawad-231681073539771-cover.jpg', '', 'Mayur', 'Devmurari', 'Ahmedabad', 'Indian', 'both', 'single', 'Acting, Programming', '', 'Actor', 'Celebrity', NULL, NULL, NULL, '', '');
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `private`, `birthday`, `sex`, `phone`, `bio`, `profile_path`, `username`, `cover_path`, `nickname`, `first_name`, `last_name`, `current_city`, `nationality`, `interested_in`, `marital_status`, `skills`, `hidepost`, `category`, `role`, `instagram_uid`, `facebook_uid`, `twitter_uid`, `linkedin_uid`, `youtube_uid`) VALUES
(104, 'Khushal Bhalsod', 'khushal@yugtia.com', '$P$B9A/hnGN3nFh3PInZtPVE1e3DWb5m70', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'relax-time-on-set_.jpg', 'khushal@yugtia.com', NULL, '', 'Khushal', 'Bhalsod', 'Ahmedabad', 'Indian', 'both', 'in relationship', 'Acting, Programming', '', 'Actor', 'Celebrity', NULL, NULL, NULL, '', ''),
(105, 'Pop Music', 'PopMusic_fanpageapvvyas@ymail.com', '$P$Bu3eqqLPoTyHzeNetBeKbi1dPcK.c./', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'Pop Music_fanpageapvvyas@ymail.com', NULL, '', 'Pop Music', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(106, 'Test', 'Test_fanpageramsey@yahoo.com', '$P$BINJemJe0He0hzW8nadNwbFbr0.4eB.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'Test_fanpageramsey@yahoo.com', NULL, '', 'Test', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(107, 'Lets', 'Lets_fanpageramsey@yahoo.com', '$P$BwGIBWSReXwSBvfdRWNM0kmEksEjnE/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'Lets_fanpageramsey@yahoo.com', NULL, '', 'Lets', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(108, 'My Personal Thoughts', 'MyPersonalThoughts_fanpageramsey@yahoo.com', '$P$BBCZ7jiB/cAPODIwbj33riu.oIICdC1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'My Personal Thoughts_fanpageramsey@yahoo.com', NULL, '', 'My Personal Thoughts', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(109, 'Raj Dev', 'testyugtia@gmail.com', '$P$B40qERTDS26X8tVBOKwR6LywisoLUp1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Any', '474038-rajinikanth-123.jpg', 'testyugtia@gmail.com', NULL, '', 'Raj', 'Dev', 'Banglore', 'Indian', 'male', 'single', 'Any', '', 'Any', 'Follower', NULL, NULL, NULL, '', ''),
(110, 'My Bio', 'MyBio_fanpageapvvyas@ymail.com', '$P$BMzwr0bpadgrwDwHwFc2wQYhMAIzAW0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'My Bio_fanpageapvvyas@ymail.com', NULL, '', 'My Bio', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(111, 'Rose Odimegwu', 'roesemaryodimegwu@yahoo.com', '$P$Be12DVvRf8krGhdcCeU5T1MiySeGR1/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', '', 'lightupnaija.jpg', 'roesemaryodimegwu@yahoo.com', NULL, '', 'Rose', 'Odimegwu', 'Port Hartcourt', 'Nigeria', 'female', 'single', '', '', 'Mentor', 'Celebrity', NULL, NULL, NULL, '', ''),
(112, 'Franka Johnson', 'francka@yahoo.com', '$P$B1HUZ.7KxI12IX7t7hJdb0i2CPFsek/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', '', NULL, 'francka@yahoo.com', NULL, '', 'Franka', 'Johnson', '', '', 'male', 'single', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(113, 'Bookshop', 'Bookshop_fanpageramsey@yahoo.com', '$P$BVOuZEqouzI4Ego9UR4QagSpvkaEmo.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'DSC_0009.jpg', 'Bookshop_fanpageramsey@yahoo.com', 'DSC_0146.jpg', '', 'Bookshop', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(114, 'Rose Stephen', 'rosemary@yahoo.com', '$P$Bqa1qT6d8MG05ynpTaF96ieFL1Aa65.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', '', 'IMG_1566.jpg', 'rosemary@yahoo.com', 'IMG_1529.jpg', '', 'Rose', 'Stephen', 'Lagos', 'Nigeria', 'male', 'in relationship', 'Publisher', '', 'Organiser', 'Celebrity', NULL, NULL, NULL, '', ''),
(115, 'Mausam Patel', 'djmadi.musik@gmail.com', '$P$BnYloErVLJ2Gf.ysSabXy/bUEnygPY0', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'I am an Entrepreneur.', '10394062_1024393834248504_2244151606986131195_n.jpg', 'djmadi.musik@gmail.com', NULL, '', 'Mausam', 'Patel', 'Ahmedabaad', 'Indian', 'male', 'single', 'Business Development', '', 'Information Technology', 'Celebrity', 'patelmausam', 'mausam1015', 'mausam1015', '', ''),
(116, 'Piyush Bhatt', 'piyush@yugtia.com', '$P$BassPNDJEG1SpZClTOCsWUfDInYet81', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 1, '', 'HELLO', '^15152D05A59AE5047B0B1490B216C7B957C56F1B31E5FFE9C6^pimgpsh_fullsize_distr.jpg', 'piyush@yugtia.com', NULL, '', 'Piyush', 'Bhatt', 'Ahmedabad', 'India', 'female', 'married', 'abc', '', 'cyz', 'Celebrity', NULL, NULL, NULL, '', ''),
(117, 'ABC', 'ABC_fanpagepiyush@yugtia.com', '$P$Be7Nr.MmaRZHHCS4QJWTPC7dnOS8210', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'ABC_fanpagepiyush@yugtia.com', NULL, '', 'ABC', '', '', '', '', '', '', '', '', 'Fanpage', NULL, NULL, NULL, '', ''),
(118, 'Solomon Joseph', 'solomon@yahoo.com', '$P$BI6dwwvUoQx1nxMj61nIcbnvpNxQ8b/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Innovative and Developer', 'SolomonJ-328.jpg', 'solomon@yahoo.com', 'SolomonJ-013.jpg', '', 'Solomon', 'Joseph', 'London', 'Nigeria', 'female', 'single', 'Management', '', 'Analyst', 'Follower', NULL, NULL, NULL, '', ''),
(119, 'Pragnesh Panchal', 'pragnesh.ritpritech@gmail.com', '$P$BppaXp.r8pxMic7g9k5hr9g.j/bnN./', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'Test', NULL, 'pragnesh.ritpritech@gmail.com', NULL, '', 'Pragnesh', 'Panchal', 'Ahmedabad', 'Indian', 'male', 'married', 'Developing', '', 'Internet', 'Follower', NULL, NULL, NULL, '', ''),
(120, 'Pragnesh Panchal', 'pragnesh.2601@hotmail.com', '$P$BOQQXs9.MI4QnskP3mWu1L5jEUV32G.', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', 'We are Leading web site Development Company from Ahmedabad,Gujarat and providing every kind of internet Solutions as per customer´s requirem', 'pragnesh.jpg', 'pragnesh.2601@hotmail.com', 'Kalika-Webtech-Solutions-272787172759673-cover.jpg', '', 'Pragnesh', 'Panchal', 'Ahmedabad', 'Indian', 'male', 'married', 'PHP Developer', '', 'Internet & Software', 'Follower', NULL, NULL, NULL, '', ''),
(121, 'Pragnesh Panchal', 'pragnesh.2601@gmail.com', '$2y$10$OEgqEoTNtoMwMp8dOMye2epEhRh/srWBNY6oss2VAki68XnmS2q3W', 'ECleDeQiR73e7U9F8jihFzG4c7tFQo9hpFXZeRlACMwOuID3pJq4Rn378uBS', '0000-00-00 00:00:00', '2018-04-17 08:09:30', 0, '0000-00-00', 0, '9998965461', 'i am php web developer', 'pragnesh.jpg', 'pragnesh.2601', 'Jellyfish.jpg', '', 'Pragnesh', 'Panchal', 'Ahmedabad', 'Indian', 'Both', 'married', 'Web Developer,php web developer', '', 'Web Developing', 'Celebrity', 'pragneshpanchalofficial', 'pragneshpanchalofficial', 'pragnesh2601', '', 'UCSoJq5sQp30qLawd2gKBMUw'),
(122, 'Vivek Rathod', 'vvk7117@gmail.com', '$P$BD8h6g0rLHcdJI8Usr67dtL7ZxwCig/', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', 'ddd.jpg', 'vvk7117@gmail.com', NULL, '', 'Vivek', 'Rathod', '', '', 'female', 'single', '', '', '', 'Celebrity', NULL, NULL, NULL, '', ''),
(123, 'Ritpri Tech', 'RitpriTech_fanpagemodijaymin86@gmail.com', '$P$BgbNT7h9jo6AtYNZxi.Y.nqxgGQhkk1', 'BEySRiZa9FMMpwHCRb5uxydh0HHxhx2EXlAQLU0u5B9bSWTcyKGjnZwwLkxi', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'Ritpri Tech_fanpagemodijaymin86@gmail.com', NULL, '', 'Ritpri Tech', '', '', '', '', '', '', '', '', 'Fanpage', 'patelmausam', NULL, NULL, '', ''),
(124, 'Jaymin Modi', 'divinetechnolog@gmail.com', '$P$BbBtjpHXvWPNu.jWZn7ZDEoP8pIL.s1', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00', 0, '', '', NULL, 'divinetechnolog@gmail.com', NULL, '', 'Jaymin', 'Modi', '', '', '', '', '', '', '', 'Follower', NULL, NULL, NULL, '', 'UCZRIvleceNUxAQpVQdQwLAg'),
(135, ' Intergral Coderz', 'Integral-Coderz_fanpagepragnesh.2601@gmail.com', '$2y$10$OEgqEoTNtoMwMp8dOMye2epEhRh/srWBNY6oss2VAki68XnmS2q3W', 'QBKT3eYkQSJMKFvEmmBxx6BFVcK8DZAJCIh9YbeniwJK6K3HlhSv3pieESTp', '2018-04-05 06:10:55', '2018-04-05 06:13:26', 0, NULL, 0, '9998965461', 'We are website Design company', '4cfeee63bc88b24089554cd903be6250.jpg', 'Integral-Coderz', NULL, '', '', '', 'Ahmedabad', 'Indian', 'Male', 'single', 'php,laravel', '', 'Company', 'Fanpage', NULL, 'pragneshpanchalofficial', NULL, '', 'UCZRIvleceNUxAQpVQdQwLAg'),
(139, 'Vicky Diyora', 'imvdiyora@gmail.com', '$2y$10$YY6eyvAKtmj0ZjvzXlJYh.i8hAyclCyAfVhT0mSKBl7yd3RsbpheK', 'FQMln2C7gXakWbu9S2Mkz90hd0rX11HXq6YuFCJASnReTXD1z0ULAYPnyJfD', '2018-04-06 04:50:15', '2018-04-06 04:50:15', 0, '1905-01-01', 0, NULL, NULL, NULL, 'vicky-diyora', NULL, '', 'Vicky', 'Diyora', '', '', '', '', '', '', '', 'Celebrity', 'katdenningsss', 'JustWannaBeWithYou', 'imvdiyora', '', 'UC7sRFTKIbH4NNpFXmpUAWuA'),
(140, 'dhaval modi', 'dhaval@gmail.com', '$2y$10$9Ua6cB1awq5aOLf21HEEk.XwGGyBGVO5hcAnFHVg1.yICRRPD3nXi', 'AnXXcPmoWabBdDLtxZdeMt59Su04vw6b1QzZoxzi4rEruny2bXpDAqunKotN', '2018-05-03 09:36:30', '2018-05-03 09:36:30', 0, '1921-12-15', 0, NULL, NULL, NULL, 'dhaval-modi', NULL, '', 'dhaval', 'modi', '', '', '', '', '', '', '', 'Follower', NULL, NULL, NULL, '', ''),
(141, 'viki modi', 'viki@gmail.com', '$2y$10$GVcLjMmBwJ91KF0Q6SWcgOCkF8/IOy5aR8rPBkduR4rhEX/sFE2SO', 'DVcwhaKCvTs6kvTC6zK4dbqqwKmZ94wufnt8KCj7jMNII7Bgbu66N9tbtPaD', '2018-05-18 00:07:18', '2018-05-18 05:07:02', 0, '1994-11-16', 0, '7878388760', 'ndjfngndfng', 'c4ad45ee13a6e807d34cd6f8334f37c6.png', 'viki-modi', NULL, '', 'viki', 'modi', 'patan', 'india', 'Female', 'single', 'php,45,5151,484', '', 'dsfd', 'Follower', NULL, NULL, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_direct_messages`
--

CREATE TABLE `user_direct_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `sender_user_id` int(10) UNSIGNED NOT NULL,
  `receiver_user_id` int(10) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `sender_delete` tinyint(1) NOT NULL DEFAULT '0',
  `receiver_delete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_direct_messages`
--

INSERT INTO `user_direct_messages` (`id`, `sender_user_id`, `receiver_user_id`, `message`, `seen`, `sender_delete`, `receiver_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'hii', 1, 1, 1, '2018-03-07 06:59:05', '2018-04-30 05:02:37'),
(2, 1, 2, 'nkjl', 1, 1, 1, '2018-03-09 06:41:15', '2018-04-30 05:02:37'),
(3, 1, 2, 'adf', 1, 1, 1, '2018-03-10 11:17:50', '2018-03-19 08:58:11'),
(4, 2, 1, 'ff', 1, 0, 1, '2018-03-19 09:00:03', '2018-04-30 05:02:37'),
(5, 2, 1, 'dd', 1, 0, 1, '2018-03-19 09:00:15', '2018-04-30 05:02:37'),
(6, 2, 1, 'ddd', 1, 0, 1, '2018-03-19 09:00:18', '2018-04-30 05:02:37'),
(7, 1, 2, '?', 1, 1, 1, '2018-03-19 09:00:32', '2018-04-30 05:02:37'),
(8, 121, 1, 'Hello', 1, 0, 1, '2018-03-19 09:01:10', '2018-04-30 05:02:33'),
(9, 121, 1, 'Have you got the message?', 1, 0, 1, '2018-03-19 09:01:39', '2018-04-30 05:02:33'),
(10, 1, 121, 'ghg', 1, 1, 0, '2018-03-19 09:54:26', '2018-04-30 05:02:33'),
(11, 121, 1, 'asdfdsf', 1, 0, 1, '2018-04-23 01:27:49', '2018-04-30 05:02:33'),
(12, 121, 1, 'df', 1, 0, 1, '2018-04-23 01:27:50', '2018-04-30 05:02:33'),
(13, 121, 1, 'f', 1, 0, 1, '2018-04-23 01:27:51', '2018-04-30 05:02:33'),
(14, 121, 1, 'sdf', 1, 0, 1, '2018-04-23 01:27:51', '2018-04-30 05:02:33'),
(15, 121, 1, 'dsf', 1, 0, 1, '2018-04-23 01:27:52', '2018-04-30 05:02:33'),
(16, 121, 1, 'dsf', 1, 1, 1, '2018-04-23 01:27:52', '2018-04-30 05:02:33'),
(17, 121, 1, 'dsf', 1, 1, 1, '2018-04-23 01:27:53', '2018-04-30 05:02:33'),
(18, 121, 1, 'dsf', 1, 1, 1, '2018-04-23 01:27:54', '2018-04-30 05:02:33'),
(19, 121, 1, 'sdf', 1, 1, 1, '2018-04-23 01:27:55', '2018-04-30 05:02:33'),
(20, 121, 1, 'HI', 1, 0, 1, '2018-04-30 05:02:55', '2018-04-30 05:04:18'),
(21, 1, 121, 'oh:)', 1, 1, 0, '2018-04-30 05:03:03', '2018-04-30 05:05:28'),
(22, 121, 1, ':-)', 1, 0, 1, '2018-04-30 05:03:21', '2018-04-30 05:03:31'),
(23, 121, 1, 'hello jaymin', 1, 0, 0, '2018-04-30 05:07:07', '2018-04-30 05:07:46'),
(24, 1, 121, 'hi', 1, 0, 0, '2018-04-30 05:08:01', '2018-04-30 05:08:02'),
(25, 1, 121, 'hi', 0, 0, 0, '2018-04-30 05:08:27', '2018-04-30 05:08:27'),
(26, 1, 121, 'HI', 0, 0, 0, '2018-05-02 10:20:47', '2018-05-02 10:20:47');

-- --------------------------------------------------------

--
-- Table structure for table `user_following`
--

CREATE TABLE `user_following` (
  `id` int(10) UNSIGNED NOT NULL,
  `following_user_id` int(10) UNSIGNED NOT NULL,
  `follower_user_id` int(10) UNSIGNED NOT NULL,
  `allow` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_following`
--

INSERT INTO `user_following` (`id`, `following_user_id`, `follower_user_id`, `allow`) VALUES
(12, 120, 2, 1),
(13, 1, 2, 1),
(83, 4, 1, 1),
(84, 7, 1, 1),
(85, 10, 1, 1),
(86, 11, 1, 1),
(87, 15, 1, 1),
(88, 8, 1, 1),
(89, 6, 1, 1),
(90, 12, 1, 1),
(92, 13, 1, 1),
(93, 17, 1, 1),
(94, 14, 1, 1),
(140, 5, 1, 1),
(142, 18, 1, 1),
(143, 19, 1, 1),
(145, 16, 1, 1),
(148, 5, 2, 1),
(149, 9, 2, 1),
(150, 11, 2, 1),
(167, 121, 123, 3),
(173, 1, 141, 1),
(175, 141, 1, 1),
(176, 141, 121, 3),
(177, 121, 141, 1),
(180, 6, 123, 1),
(182, 5, 121, 1),
(183, 4, 121, 1),
(184, 1, 121, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_hobbies`
--

CREATE TABLE `user_hobbies` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `hobby_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_hobbies`
--

INSERT INTO `user_hobbies` (`user_id`, `hobby_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user_locations`
--

CREATE TABLE `user_locations` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `latitud` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitud` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_relationship`
--

CREATE TABLE `user_relationship` (
  `id` int(10) UNSIGNED NOT NULL,
  `related_user_id` int(10) UNSIGNED NOT NULL,
  `main_user_id` int(10) UNSIGNED NOT NULL,
  `relation_type` int(11) NOT NULL DEFAULT '0',
  `allow` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_country_id_foreign` (`country_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`comment_id`,`like_user_id`) USING BTREE,
  ADD KEY `post_likes_like_user_id_foreign` (`like_user_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `groups_hobby_id_foreign` (`hobby_id`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `post_attachments`
--
ALTER TABLE `post_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_images_post_id_foreign` (`post_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_post_id_foreign` (`post_id`),
  ADD KEY `post_comments_comment_user_id_foreign` (`comment_user_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_images_post_id_foreign` (`post_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`post_id`,`like_user_id`),
  ADD KEY `post_likes_like_user_id_foreign` (`like_user_id`);

--
-- Indexes for table `post_links`
--
ALTER TABLE `post_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_images_post_id_foreign` (`post_id`);

--
-- Indexes for table `post_shares`
--
ALTER TABLE `post_shares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_videos`
--
ALTER TABLE `post_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_images_post_id_foreign` (`post_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_comments`
--
ALTER TABLE `social_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_comments_comment_user_id_foreign` (`comment_user_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_direct_messages`
--
ALTER TABLE `user_direct_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_direct_messages_sender_user_id_foreign` (`sender_user_id`),
  ADD KEY `user_direct_messages_receiver_user_id_foreign` (`receiver_user_id`);

--
-- Indexes for table `user_following`
--
ALTER TABLE `user_following`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_following_following_user_id_foreign` (`following_user_id`),
  ADD KEY `user_following_follower_user_id_foreign` (`follower_user_id`);

--
-- Indexes for table `user_hobbies`
--
ALTER TABLE `user_hobbies`
  ADD PRIMARY KEY (`user_id`,`hobby_id`),
  ADD KEY `user_hobbies_hobby_id_foreign` (`hobby_id`);

--
-- Indexes for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_locations_city_id_foreign` (`city_id`);

--
-- Indexes for table `user_relationship`
--
ALTER TABLE `user_relationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_relationship_related_user_id_foreign` (`related_user_id`),
  ADD KEY `user_relationship_main_user_id_foreign` (`main_user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hobbies`
--
ALTER TABLE `hobbies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `post_attachments`
--
ALTER TABLE `post_attachments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `post_links`
--
ALTER TABLE `post_links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `post_shares`
--
ALTER TABLE `post_shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post_videos`
--
ALTER TABLE `post_videos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_comments`
--
ALTER TABLE `social_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `user_direct_messages`
--
ALTER TABLE `user_direct_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_following`
--
ALTER TABLE `user_following`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `user_relationship`
--
ALTER TABLE `user_relationship`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_hobby_id_foreign` FOREIGN KEY (`hobby_id`) REFERENCES `hobbies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_comment_user_id_foreign` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_like_user_id_foreign` FOREIGN KEY (`like_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_direct_messages`
--
ALTER TABLE `user_direct_messages`
  ADD CONSTRAINT `user_direct_messages_receiver_user_id_foreign` FOREIGN KEY (`receiver_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_direct_messages_sender_user_id_foreign` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_following`
--
ALTER TABLE `user_following`
  ADD CONSTRAINT `user_following_follower_user_id_foreign` FOREIGN KEY (`follower_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_following_following_user_id_foreign` FOREIGN KEY (`following_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_hobbies`
--
ALTER TABLE `user_hobbies`
  ADD CONSTRAINT `user_hobbies_hobby_id_foreign` FOREIGN KEY (`hobby_id`) REFERENCES `hobbies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_hobbies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_locations`
--
ALTER TABLE `user_locations`
  ADD CONSTRAINT `user_locations_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `user_locations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_relationship`
--
ALTER TABLE `user_relationship`
  ADD CONSTRAINT `user_relationship_main_user_id_foreign` FOREIGN KEY (`main_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_relationship_related_user_id_foreign` FOREIGN KEY (`related_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
