-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 05, 2023 at 07:31 AM
-- Server version: 10.3.39-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keyeduau_muhamad`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_text` text NOT NULL,
  `banner_image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `banner_text`, `banner_image`, `created_at`, `updated_at`) VALUES
(1, '<h5><h3><b style=\"font-family: inherit;\">Book Now Pay Later with Zip!</b></h3><span style=\"font-family: inherit;\">We offer<br></span>Traffic Management Courses<br>White Card Course<br>First Aid Courses<br>Electrical Spotters Course<br>Roller Operator course</h5><div><br></div>', 'banner-6203d52c534db.jpg', '2022-02-09 08:51:35', '2022-04-24 15:11:26');

-- --------------------------------------------------------

--
-- Table structure for table `booking_dates`
--

DROP TABLE IF EXISTS `booking_dates`;
CREATE TABLE `booking_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_dates`
--

INSERT INTO `booking_dates` (`id`, `course_id`, `booking_date`, `created_at`, `updated_at`) VALUES
(990, 12, '2021-11-17', '2022-05-22 22:13:55', '2022-05-22 22:13:55'),
(991, 12, '2021-12-01', '2022-05-22 22:13:55', '2022-05-22 22:13:55'),
(992, 12, '2021-12-15', '2022-05-22 22:13:55', '2022-05-22 22:13:55'),
(999, 16, '2021-09-02', '2022-05-22 22:14:29', '2022-05-22 22:14:29'),
(1000, 16, '2021-09-16', '2022-05-22 22:14:29', '2022-05-22 22:14:29'),
(1001, 16, '2021-09-30', '2022-05-22 22:14:29', '2022-05-22 22:14:29'),
(1020, 17, '2021-11-16', '2022-06-29 02:30:05', '2022-06-29 02:30:05'),
(1021, 17, '2021-11-30', '2022-06-29 02:30:05', '2022-06-29 02:30:05'),
(1022, 17, '2021-12-14', '2022-06-29 02:30:05', '2022-06-29 02:30:05'),
(1071, 10, '2021-11-15', '2022-06-29 02:32:01', '2022-06-29 02:32:01'),
(1072, 10, '2021-11-29', '2022-06-29 02:32:01', '2022-06-29 02:32:01'),
(1073, 10, '2021-12-13', '2022-06-29 02:32:01', '2022-06-29 02:32:01'),
(1100, 25, '2022-04-25', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1101, 25, '2022-05-09', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1102, 25, '2022-05-23', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1103, 25, '2022-06-06', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1104, 25, '2022-06-20', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1105, 25, '2022-07-04', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1106, 25, '2022-07-18', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1107, 25, '2022-08-01', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1108, 25, '2022-08-15', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1109, 25, '2022-08-29', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1110, 25, '2022-09-12', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1111, 25, '2022-09-26', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1112, 25, '2022-10-10', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1113, 25, '2022-10-24', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1114, 25, '2022-11-07', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1115, 25, '2022-11-21', '2022-06-29 02:32:55', '2022-06-29 02:32:55'),
(1116, 24, '2022-03-14', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1117, 24, '2022-03-28', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1118, 24, '2022-04-11', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1119, 24, '2022-04-25', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1120, 24, '2022-05-09', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1121, 24, '2022-05-23', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1122, 24, '2022-06-06', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1123, 24, '2022-06-20', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1124, 24, '2022-07-04', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1125, 24, '2022-07-18', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1126, 24, '2022-08-01', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1127, 24, '2022-08-15', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1128, 24, '2022-08-29', '2022-06-29 02:33:22', '2022-06-29 02:33:22'),
(1132, 32, '2023-07-01', '2022-07-01 22:21:59', '2022-07-01 22:21:59'),
(1133, 32, '2023-07-02', '2022-07-01 22:21:59', '2022-07-01 22:21:59'),
(1134, 32, '2023-07-03', '2022-07-01 22:21:59', '2022-07-01 22:21:59'),
(1135, 33, '2023-07-01', '2022-07-01 22:28:52', '2022-07-01 22:28:52'),
(1137, 34, '2023-07-01', '2022-07-02 02:56:06', '2022-07-02 02:56:06'),
(1138, 35, '2023-07-01', '2022-07-02 03:03:00', '2022-07-02 03:03:00'),
(1139, 19, '2021-09-09', '2022-07-02 03:07:04', '2022-07-02 03:07:04'),
(1140, 19, '2021-09-23', '2022-07-02 03:07:04', '2022-07-02 03:07:04'),
(1141, 19, '2021-10-07', '2022-07-02 03:07:04', '2022-07-02 03:07:04'),
(1143, 37, '2022-07-10', '2022-07-02 03:33:05', '2022-07-02 03:33:05'),
(1144, 38, '2022-09-01', '2022-07-02 03:40:12', '2022-07-02 03:40:12'),
(1146, 36, '2022-08-04', '2022-07-02 03:51:05', '2022-07-02 03:51:05'),
(1147, 39, '2022-09-01', '2022-07-02 03:52:23', '2022-07-02 03:52:23'),
(1148, 40, '2022-08-05', '2022-07-02 04:00:38', '2022-07-02 04:00:38'),
(1149, 41, '2022-07-17', '2022-07-02 04:16:10', '2022-07-02 04:16:10'),
(1150, 42, '2022-07-07', '2022-07-02 04:21:16', '2022-07-02 04:21:16'),
(1154, 43, '2022-07-15', '2022-07-02 04:26:43', '2022-07-02 04:26:43'),
(1155, 43, '2022-07-29', '2022-07-02 04:26:43', '2022-07-02 04:26:43'),
(1156, 44, '2022-07-29', '2022-07-02 04:42:21', '2022-07-02 04:42:21'),
(1157, 45, '2022-07-30', '2022-07-02 04:55:36', '2022-07-02 04:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `slug` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `description`, `slug`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Traffic Management', 'storage/images/courses/traffic-management-package-61ef6b621447e.jpg', NULL, 'traffic-management', 0, 1, '2022-06-28 11:51:55', '2022-06-29 02:27:36'),
(2, 'High risk work licence', 'storage/images/courses/traffic-management-and-white-card-package-61ef6b872ddd1.jpg', NULL, 'high-risk-work-licence', 1, 1, '2022-06-28 11:51:55', '2022-06-29 02:35:24'),
(3, 'White Card', 'storage/images/courses/2.jpg', NULL, 'white-card', 2, 1, '2022-06-28 11:51:55', '2022-06-29 14:57:19'),
(4, 'First Aid', 'storage/images/categories/first-aid-62bcf47115e31.jpg', NULL, 'first-aid', 3, 1, '2022-06-28 11:51:55', '2022-06-29 14:55:13'),
(5, 'Electrical Spotters Course', 'storage/images/courses/3.jpg', NULL, 'electrical-spotters-course', 4, 1, '2022-06-28 11:51:55', '2022-06-28 11:51:55'),
(6, 'Earthmoving Courses', 'storage/images/categories/earthmoving-courses-62bc489d3034c.webp', NULL, 'earthmoving-courses', 5, 1, '2022-06-28 11:51:56', '2022-06-29 02:42:05'),
(7, 'Working at heights & EWP', 'storage/images/categories/working-at-heights-ewp-62bc4a0c223e5.jpg', NULL, 'working-at-heights-ewp', 6, 1, '2022-06-28 11:51:56', '2022-06-29 02:48:12'),
(8, 'Confined space', 'storage/images/categories/confined-space-62bc4acf777d8.webp', NULL, 'confined-space', 7, 1, '2022-06-28 11:51:56', '2022-06-29 02:51:27');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` double(8,2) NOT NULL,
  `image` varchar(1500) NOT NULL,
  `description` varchar(1500) DEFAULT NULL,
  `course_code` varchar(20) DEFAULT NULL,
  `department` varchar(155) DEFAULT NULL,
  `study_area` varchar(155) DEFAULT NULL,
  `campus` varchar(155) DEFAULT NULL,
  `course_length` varchar(25) DEFAULT NULL,
  `prerequisites` text DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `fee_details` text DEFAULT NULL,
  `course_duration` text DEFAULT NULL,
  `additional_details` text DEFAULT NULL,
  `detail_image` varchar(1500) NOT NULL,
  `slug` varchar(1000) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `price`, `image`, `description`, `course_code`, `department`, `study_area`, `campus`, `course_length`, `prerequisites`, `display_order`, `fee_details`, `course_duration`, `additional_details`, `detail_image`, `slug`, `created_at`, `updated_at`, `category_id`) VALUES
(10, 'RIIWHS205E Control traffic with  a stop slow bat', 220.00, '1.jpg', 'This unit describes the skills and knowledge required to control vehicle and pedestrian traffic using stop-slow bats, hand signals and approved communication devices in the resources and infrastructure industries.\r\n\r\nIt applies to those working in operational roles. They generally work in teams in live traffic environments under some degree of supervision.\r\n\r\nNote: The terms Occupational Health and Safety (OHS) and Work Health and Safety (WHS) are equivalent and generally either can be used in the workplace. In jurisdictions where the National Model WHS Legislation has not been implemented registered training organisations are advised to contextualise the unit of competency by referring to the existing state/territory OHS legislative requirements', 'RIIWHS205E', 'Professional, Creative & Environment', 'Traffic Management', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'None', 3, '$220', '1 Day', 'All applicants will need to apply via our website or by email info@key.edu.au', 'details-611f2b7bccfbc.jpg', 'riiwhs205e-control-traffic-with-a-stop-slow-bat', '2021-05-25 06:30:20', '2022-06-29 02:32:01', 1),
(12, 'CPCCWHS1001 Prepare to work safely in the construction industry (White Card)', 220.00, '2.jpg', 'White Card Course\r\n\r\n\r\n\r\nThis unit of competency specifies the mandatory work health and safety training required prior to undertaking construction work. The unit requires the person to demonstrate personal awareness and knowledge of health and safety legislative requirements in order to work safely and prevent injury or harm to self and others. It covers identifying and orally reporting common construction hazards, understanding basic risk control measures, and identifying procedures for responding to potential incidents and emergencies. It also covers correctly selecting and fitting common personal protective equipment (PPE) used for construction work.\r\n\r\nThis unit meets the general construction induction training requirements of:\r\n\r\nPart 1.1 Definitions and Part 6.5 of the Model Work Health and Safety Regulations;\r\nDivision 11 of Part 3 of the Occupational Safety and Health Regulations 1996 for Western Australia; and\r\nDivision 3 of Part 5.1 of the Occupational Health and Safety Regulations 2007 for Victoria.\r\nIt is expected that site-specific induction training will be conducted prior to conducting construction work.\r\n\r\nLicensing, legislative, regulatory or certification requirements apply to this unit. Relevant work health and safety state and territory regulatory authorities should be consulted to confirm jurisdictional requirements.', 'CPCCWHS1001', 'Professional, Creative & Environment', 'Construction', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'None', 30, '$220', '6 Hours', '1 Day', '60fe82f301006.jpg', 'cpccwhs1001-prepare-to-work-safely-in-the-construction-industry-white-card', '2021-05-25 06:30:20', '2022-06-28 11:51:55', 3),
(16, 'Electrical Spotters Course', 330.00, '3.jpg', 'VU21936 - Observe for the safe operation of plant and equipment around overhead and underground assets.\r\n\r\n\r\nTo become a electrical spotter you must complete the unit of competency VU21936 Observe for the safe operation of plant and equipment around overhead and underground assets with a Registered Training Organisation that is approve by Energy safe Victoria. The ticket if valid for three years and you must have up to date HLTAID003 Provide first aid and CPR.\r\nThe role of a electrical spotter is to solely spot for machinery while working in a  potentially hazardous situation and warn the operator to prevent striking a live service.\r\nAs a spotter you must spot for only one machine at a time and remain with that machine until the task is complete.', 'VU21936', 'Professional, Creative & Environment', 'Electrical Spotter', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', '1. A person must have a current competency to Provide First Aid (HLTAID003) or equivalent competency; and\r\n\r\n2. A person must hold a current competency to Provide Cardiopulmonary Resuscitation (HLTAID001) or equivalent competency; and\r\n\r\n3. A person must have undertaken an approved Spotter training course (22325VIC) (Course in Workplace Spotting for Service Assets) and hold an appropriate Spotters Registration Certificate/Card which is valid for a period of three (3) years.\r\n\r\n4. A trained Dogman/Rigger may act as a spotter for any type of plant (without holding a ticket or demonstrate competence and experience for that item of plant), subject to compliance with items 1, 2 and 3 above.\r\n\r\n5. For all other plant and equipment, a person must hold a Certificate of Competency or WorkSafe ticket for the item of plant that person will be spotting for; or a. For items of plant such as an EWP', 50, '$330', '1 Day', '1 Day', '60fe83048cd8d.jpg', 'electrical-spotters-course', '2021-05-25 06:30:20', '2022-06-28 11:51:55', 5),
(17, 'RIIWHS302E Implement Traffic Management Plans', 220.00, 'traffic pic.jpg', 'Traffic Management Course\r\n\r\nThis unit describes the skills and knowledge required to set out, monitor and close down traffic management plans and traffic guidance schemes in civil construction.\r\n\r\nIt applies to those working in supervisory roles. They generally work in teams in live traffic environments and hold some responsibility for the outcomes of others.\r\n\r\nLicensing, legislative and certification requirements that apply to this unit can vary between states, territories, and industry sectors. Users must check requirements with relevant body before applying the unit.\r\n\r\nNote: The terms Occupational Health and Safety (OHS) and Work Health and Safety (WHS) are equivalent and generally either can be used in the workplace. In jurisdictions where the National Model WHS Legislation has not been implemented registered training organisations are advised to contextualise the unit of competency by referring to the existing state/territory OHS legislative requirements.', 'RIIWHS302E', 'Professional, Creative & Environment', 'Traffic Management', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'None', 70, '$220', '1 Day', '1 Day', '60fe82eb0d61a.jpg', 'riiwhs302e-implement-traffic-management-plans', '2021-05-25 06:30:20', '2022-06-29 02:30:05', 1),
(19, 'RIIMPO317F Conduct roller operations', 660.00, '4.jpg', 'This unit describes the skills and knowledge required to operate a roller to compact material.\r\n\r\nThis unit applies to those working in site based roles.\r\n\r\nLicensing, legislative, regulatory and certification requirements that apply to this unit can vary between states, territories, and industry sectors, and must be sourced from state jurisdictions prior to applying this unit.\r\n\r\nThis unit alone does not provide sufficient skill to independently load and unload equipment. To perform this activity safely, personnel must either complete or be assisted by someone who has completed RIIHAN308F Load and Unload Plant or equivalent.', 'RIIMPO317F', 'Professional, Creative & Environment', 'Construction Roller Operator', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'None', 140, '$660', '2 Days', '2 Days', '60fe830e83845.jpg', 'riimpo317f-conduct-roller-operations', '2021-05-25 06:30:20', '2022-07-02 03:07:04', 6),
(24, 'Traffic Management Package', 360.00, 'traffic-management-package-61ef6b621447e.jpg', 'RIIWHS205E Control traffic with stop-slow bat, RIIWHS302E Implement Traffic management plans is face to face training. Classes will be held at our Brooklyn Campus.\r\n●	You will learn how to control traffic using stop slow bat, as a traffic controller your job is to  direct vehicles, machinery and pedestrians with mobility issues, pedestrians with prams , cyclist people using a Stop slow bat.\r\n●	You will gain the skills and knowledge required to set out, monitor and close down traffic management plans and traffic guidance schemes in civil construction.\r\n●	During the two day course you will learn \r\n	Prepare to control traffic \r\n	Control traffic and operate communication devices\r\n	Conduct housekeeping activities', 'Traffic Management', NULL, 'Traffic management', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'None', 40, '$360', 'Two days for both units.', 'All applicants will need to apply via our website or by email info@key.edu.au', 'details-61ef6b62266fa.jpg', 'traffic-management-package', '2021-11-07 17:31:01', '2022-06-29 02:33:22', 1),
(25, 'Traffic Management and White Card Package', 550.00, 'traffic-management-and-white-card-package-61ef6b872ddd1.jpg', 'Want to get into traffic management industry?\r\nWe have put together a package that will get you started.\r\nLearn to control traffic using stop slow bat and Implement traffic management plan confidently with our traffic management course.\r\nLearn to  demonstrate personal awareness and knowledge of health and safety legislative requirements in order to work safely and prevent injury or harm to self and others. It covers identifying and orally reporting common construction hazards, understanding basic risk control measures, and identifying procedures for responding to potential incidents and emergencies. It also covers correctly selecting and fitting common personal protective equipment (PPE) used for construction work with our white card course.\r\nRIIWHS205E - Control traffic with stop-slow bat\r\nRIIWHS302E - Implement traffic management plansCPCCWHS1001 - Prepare to work safely in the construction industry', 'RII&CPC', NULL, 'Traffic Management and White Card Package', '2/1 Millers Road Brooklyn VIC 3012', '3 Days', NULL, 50, '$550', '3 Days', NULL, 'details-61ef6b872e28e.jpg', 'traffic-management-and-white-card-package', '2021-12-16 18:31:07', '2022-06-29 02:32:55', 1),
(32, 'CPCCLDG3001 Licence to perform dogging', 1600.00, 'cpccldg3001-licence-to-perform-dogging-62bfffd2011a7.jpg', 'This unit specifies the skills and knowledge required to safely perform dogging work. Dogging consists of the application of slinging techniques to move a load, including the selection and inspection of lifting gear, and the directing of a plant operator in the movement of a load when the load is out of sight of the operator.\r\n\r\nDogging work is conducted in the construction industry and other industries where loads are lifted and moved using cranes or hoists.\r\n\r\nCompletion of the general construction induction training program, specified in the Safe Work Australia model Code of Practice: Construction Work, is required by anyone carrying out construction work. Achievement of CPCCWHS1001 Prepare to work safely in the construction industry meets this requirement.\r\n\r\nCompetence in this unit does not in itself result in a licence. A licence is obtained after competence is assessed under applicable Commonwealth, state or territory work health and safety (WHS) regulations.', 'CPCCLDG3001', NULL, 'Licence to perform dogging', '2/1 Millers Road, Brooklyn VIC 3012', '5 Days', 'Nil', 141, '$1600', '5 Days 8 Hours each day', NULL, 'details-62bfffd2014b7.jpg', 'cpccldg3001-licence-to-perform-dogging', '2022-07-01 22:20:34', '2022-07-01 22:21:59', 2),
(33, 'TLILIC0003 Licence to operate a forklift truck', 500.00, 'tlilic0003-licence-to-operate-a-forklift-truck-62c001c4ed65e.jpg', 'This unit specifies the skills and knowledge required to operate a forklift truck safely in accordance with all relevant legislative requirements. Competence in this unit, does not in itself result in a HRWL licence to operate this plant.\r\n\r\nForklift truck means a powered industrial truck equipped with lifting media made up of a mast and an elevating load carriage to which is attached a pair of fork arms or other attachments that can be raised 900 mm or more above the ground, but does not include a pedestrian-operated truck or a pallet truck.\r\n\r\nA person performing this work is required to hold a forklift truck High Risk Work Licence (HRWL).\r\n\r\nThis unit requires a person operating a forklift truck to:\r\n\r\nplan for the work/task\r\nprepare for the work/task\r\nperform work/task\r\npack up', 'TLILIC0003', NULL, 'Operate a forklift truck', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil', 142, '$500', '2 Day course 8 hours each day', NULL, 'details-62c001c4ed8b3.jpg', 'tlilic0003-licence-to-operate-a-forklift-truck', '2022-07-01 22:28:52', '2022-07-01 22:28:52', 2),
(34, 'TLILIC0004  Licence to operate an order picking forklift truck', 500.00, 'tlilic0004-licence-to-operate-an-order-picking-forklift-truck-62c0406604f17.jpg', 'This unit specifies the skills and knowledge required to operate an order picking forklift truck safely in accordance with all relevant legislative requirements. Competence in this unit, does not in itself result in a HRWL licence to operate this plant.\r\n\r\nOrder picking forklift truck means an order picking forklift truck where the operator controls are incorporated with the lifting media and elevate with the lifting media.\r\n\r\nA person performing this work is required to hold an order picking forklift truck High Risk Work Licence (HRWL).\r\n\r\nThis unit requires a person operating an order picking forklift truck to:\r\n\r\nplan for the work/task\r\nprepare for the work/task\r\nperform work/task\r\npack up', 'TLILIC0004', NULL, 'Licence to operate an order picking forklift truck', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil.', 143, '$500', '2 Day course 8 hours each day', NULL, 'details-62c0406605380.jpg', 'tlilic0004-licence-to-operate-an-order-picking-forklift-truck', '2022-07-02 02:53:36', '2022-07-02 02:56:06', 2),
(35, 'TLILIC0005 Licence to operate a boom-type elevating work platform (boom length 11 metres or more)', 500.00, 'tlilic0005-licence-to-operate-a-boom-type-elevating-work-platform-boom-length-11-metres-or-more-62c0420487531.png', 'This unit specifies the skills and knowledge required to safely operate a boom-type Elevating Work Platform (EWP) where the length of the boom is 11 metres or more in accordance with all relevant legislative requirements. Competence in this unit, does not in itself result in a Risk Work Licence (HRWL) to operate this plant.\r\n\r\nBoom-type elevating work platform means a telescoping device, hinged device, or articulated device, or any combination of these, used to support a platform on which personnel, equipment and materials may be elevated.\r\n\r\nA person performing this work is required to hold a boom-type elevating work platform HRWL.\r\n\r\nThis unit requires a person operating an EWP to:\r\n\r\nplan for the work/task\r\nprepare for the work/task\r\nperform work/task\r\npack up.', 'TLILIC0005', NULL, 'Licence to operate a boom-type elevating work platform (boom length 11 metres or more)', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil', 144, '500', '2 Days 8 hours each day', NULL, 'details-62c04204877a5.jpg', 'tlilic0005-licence-to-operate-a-boom-type-elevating-work-platform-boom-length-11-metres-or-more', '2022-07-02 03:03:00', '2022-07-02 03:03:00', 2),
(36, 'RIIMPO337E Conduct articulated haul truck operations', 700.00, 'riimpo337e-conduct-articulated-haul-truck-operations-62c0479930021.jpg', 'This unit describes the skills and knowledge required to operate, load, haul and dump materials using an articulated haul truck.\r\n\r\nThis unit applies to those who work in operational roles.\r\n\r\nThis unit applies to both front and rear dumping haul trucks.\r\n\r\nLicensing, legislative, regulatory and certification requirements that apply to this unit can vary between states, territories, and industry sectors, and must be sourced form state jurisdictions prior to applying this unit.', 'RIIMPO337E', NULL, 'Conduct articulated haul truck operations', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil', 145, '$700', '2 Days 8 hours each day', NULL, 'details-62c0479930252.jpg', 'riimpo337e-conduct-articulated-haul-truck-operations', '2022-07-02 03:26:49', '2022-07-02 03:51:05', 6),
(37, 'RIIMPO321F Conduct civil construction wheeled front end loader operations', 550.00, 'riimpo321f-conduct-civil-construction-wheeled-front-end-loader-operations-62c04910eca34.webp', 'This unit describes the skills and knowledge required to conduct wheeled front end loader operations.\r\n\r\nThis unit applies to those working in site- based roles.\r\n\r\nWhere equipment being assessed requires the fitting and removal of attachments to be demonstrated an integrated tool carrier unit should be used.\r\n\r\nLicensing, legislative, regulatory and certification requirements that apply to this unit can vary between states, territories, and industry sectors, and must be sourced from state jurisdictions prior to applying this unit.\r\n\r\nThis unit alone does not provide sufficient skill to independently load and unload equipment. To perform this activity safely, personnel must either complete or be assisting someone who has completed RIIHAN308F Load and unload plant or equivalent.', 'RIIMPO321F', NULL, 'Conduct civil construction wheeled front end loader operations', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil', 146, '550', '2 Day course 8 hours each day', NULL, 'details-62c04910f0056.png', 'riimpo321f-conduct-civil-construction-wheeled-front-end-loader-operations', '2022-07-02 03:33:04', '2022-07-02 03:33:04', 6),
(38, 'RIIMPO318F Conduct civil construction skid steer loader operations', 550.00, 'riimpo318f-conduct-civil-construction-skid-steer-loader-operations-62c04abc6cecd.jpg', 'This unit describes the skills and knowledge required operate a skid steer loader to load, haul and distribute materials.\r\n\r\nThis unit applies to those working in site based roles.\r\n\r\nLicensing, legislative, regulatory and certification requirements that apply to this unit can vary between states, territories, and industry sectors, and must be sourced from state jurisdictions prior to applying this unit.\r\n\r\nThis unit alone does not provide sufficient skill to independently load and unload equipment. To perform this activity safely, personnel must either complete or be assisting someone who has completed RIIHAN308F Load and unload plant or equivalent.', 'RIIMPO318F', NULL, 'Conduct civil construction skid steer loader operations', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil', 147, '$550', '2 Day course 8 hours each day', NULL, 'details-62c04abc6d13c.jpg', 'riimpo318f-conduct-civil-construction-skid-steer-loader-operations', '2022-07-02 03:40:12', '2022-07-02 03:40:12', 6),
(39, 'RIIHAN309F Conduct telescopic materials handler operations', 700.00, 'riihan309f-conduct-telescopic-materials-handler-operations-62c04d9729cf4.jpg', 'This unit describes the skills and knowledge required to conduct telescopic materials handler operations.\r\n\r\nThis unit applies to those working in site-based roles.\r\n\r\nLicensing, legislative, regulatory and certification requirements that apply to this unit can vary between states, territories, and industry sectors, and must be sourced from state jurisdictions prior to applying this unit.', 'RIIHAN309F', NULL, 'Conduct telescopic materials handler operations', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil', 148, '700', '2 Day Course 8 hours each day', NULL, 'details-62c04d972a155.jpg', 'riihan309f-conduct-telescopic-materials-handler-operations', '2022-07-02 03:50:42', '2022-07-02 03:52:23', 6),
(40, 'RIIMPO320F - Conduct civil construction excavator operations', 550.00, 'riimpo320f-conduct-civil-construction-excavator-operations-62c04f860b175.jpg', 'This unit describes the skills and knowledge required to operate excavator operations to lift carry and place materials.\r\n\r\nThis unit applies to those working in site based roles.\r\n\r\nLicensing, legislative, regulatory and certification requirements that apply to this unit can vary between states, territories, and industry sectors, and must be sourced from state jurisdictions prior to applying this unit.\r\n\r\nThis unit alone does not provide sufficient skill to independently load and unload equipment. To perform this activity safely, personnel must either complete or be assisting someone who has completed RIIHAN308F Load and unload plant or equivalent.', 'RIIMPO320F', NULL, 'Conduct civil construction excavator operations', '2/1 Millers Road, Brooklyn VIC 3012', '2 Days', 'Nil', 149, '$550', '2 Day course $550', NULL, 'details-62c04f860b41d.jpg', 'riimpo320f-conduct-civil-construction-excavator-operations', '2022-07-02 04:00:38', '2022-07-02 04:00:38', 6),
(41, 'HLTAID009 Provide cardiopulmonary resuscitation CPR', 99.00, 'hltaid009-provide-cardiopulmonary-resuscitation-cpr-62c0532a709ee.jpg', 'This unit describes the skills and knowledge required to perform cardiopulmonary resuscitation (CPR) in line with the Australian Resuscitation Council (ARC) guidelines.\r\n\r\nThis unit applies to all persons who may be required to provide CPR, in a range of situations, including community and workplace settings.\r\n\r\nSpecific licensing/regulatory requirements relating to this competency, including requirements for refresher training should be obtained from the relevant national/state/territory Work Health and Safety Regulatory Authorities.', 'HLTAID009', NULL, 'Provide cardiopulmonary resuscitation', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'Nil', 150, '$99', '1 Day Course', NULL, 'details-62c0532a70bc9.jpg', 'hltaid009-provide-cardiopulmonary-resuscitation-cpr', '2022-07-02 04:16:10', '2022-07-02 04:16:10', 4),
(42, 'HLTAID011 Provide First Aid', 160.00, 'hltaid011-provide-first-aid-62c0545cdecbb.jpg', 'This unit describes the skills and knowledge required to provide a first aid response to a casualty in line with first aid guidelines determined by the Australian Resuscitation Council (ARC) and other Australian national peak clinical bodies.\r\n\r\nThe unit applies to all persons who may be required to provide a first aid response in a range of situations, including community and workplace settings.\r\n\r\nSpecific licensing/regulatory requirements relating to this competency, including requirements for refresher training should be obtained from the relevant national/state/territory Work Health and Safety Regulatory Authorities.', 'HLTAID011', NULL, 'Provide First Aid', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'Nil', 151, '$160', '1 Day Course', NULL, 'details-62c0545cdef2f.jpg', 'hltaid011-provide-first-aid', '2022-07-02 04:21:16', '2022-07-02 04:21:16', 4),
(43, 'HLTAID012 Provide First Aid in an education and care setting', 220.00, 'hltaid012-provide-first-aid-in-an-education-and-care-setting-62c055a39941d.jpg', 'This unit describes the skills and knowledge required to provide a first aid response to infants and children in line with first aid guidelines determined by the Australian Resuscitation Council (ARC) and other Australian national peak clinical bodies.\r\n\r\nThis unit applies to a range of workers within an education and care setting who are required to respond to a first aid emergency, including asthma and anaphylactic emergencies. This includes early childhood workers and educators who work with school age children in outside school hours care and vacation programs.\r\n\r\nThis unit of competency may contribute towards approved first aid, asthma and anaphylaxis training under the Education and Care Services National Law, and the Education and Care Services National Regulations (2011).\r\n\r\nSpecific licensing/regulatory requirements relating to this competency, including requirements for refresher training should be obtained from the relevant national/state/territory Work Health and Safety Regulatory Authorities', 'HLTAID012', NULL, 'Provide First Aid in an education and care setting', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'Nil', 152, '$220', '1 Day 8 course', NULL, 'details-62c055a3995d5.jpg', 'hltaid012-provide-first-aid-in-an-education-and-care-setting', '2022-07-02 04:26:43', '2022-07-02 04:26:43', 4),
(44, 'RIIWHS204E Work safely at heights', 220.00, 'riiwhs204e-work-safely-at-heights-62c0594d09bb8.jpg', 'This unit describes the skills and knowledge required to work safely at heights in the resources and infrastructure industries.\r\n\r\nIt applies to those working in operational roles. They generally work under supervision to undertake a prescribed range of functions involving known routines and procedures and take responsibility for the quality of work outcomes.\r\n\r\nLicensing, legislative and certification requirements that apply to this unit can vary between states, territories and industry sectors. Users must check requirements with relevant body before applying the unit.\r\n\r\nNote: The terms Occupational Health and Safety (OHS) and Work Health and Safety (WHS) are equivalent and generally either can be used in the workplace. In jurisdictions where the National Model WHS Legislation has not been implemented RTOs are advised to contextualise the unit of competency by referring to the existing State/Territory OHS legislative requirements.', 'RIIWHS204E', NULL, 'Work safely at heights', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'Nil', 153, '$220', '1Daycourse 8 Hours', NULL, 'details-62c0594d09cec.jpg', 'riiwhs204e-work-safely-at-heights', '2022-07-02 04:42:21', '2022-07-02 04:42:21', 7),
(45, 'RIIHAN301E Operate elevating work platform', 350.00, 'riihan301e-operate-elevating-work-platform-62c05c68d2cc4.jpg', 'This unit describes the skills and knowledge required to operate an elevating work platform at any height.\r\n\r\nThis unit applies to those working in operational roles.\r\n\r\nThe work required in this unit relates to the National Standard for High Risk Work but this unit does not provide the licence. Licensing, legislative, regulatory or certification requirements that may apply to this unit can vary between states, territories and industry sectors, and must be sourced prior to applying this unit.\r\n\r\nThis unit alone does not provide sufficient skill to independently load and unload equipment. To perform this activity safely, personnel must either complete or be assisted by someone who has completed RIIHAN308F Load and Unload Plant or equivalent.', 'RIIHAN301E', NULL, 'Operate elevating work platform', '2/1 Millers Road, Brooklyn VIC 3012', '1 Day', 'Nil', 154, '$350', '1 Day course 8 hours', NULL, 'details-62c05c68d2f09.jpg', 'riihan301e-operate-elevating-work-platform', '2022-07-02 04:55:36', '2022-07-02 04:55:36', 7);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
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
-- Table structure for table `meta_tags`
--

DROP TABLE IF EXISTS `meta_tags`;
CREATE TABLE `meta_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `property` varchar(255) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meta_tags`
--

INSERT INTO `meta_tags` (`id`, `name`, `property`, `content`, `created_at`, `updated_at`) VALUES
(3, 'description', NULL, 'Knowledge Empowers You', '2021-08-26 01:21:13', '2022-01-24 00:09:22'),
(7, 'robots', NULL, 'index, follow', '2022-01-24 00:14:06', '2022-01-24 00:14:06'),
(8, 'RIIWHS205E Control traffic with stop slow bat', 'RIIWHS205E Control traffic with stop slow bat', 'RIIWHS205E Control traffic with stop slow bat', '2022-03-21 19:22:23', '2022-03-21 19:22:23'),
(9, 'Traffic Management Course Melbourne', 'Traffic Management Course Melbourne', 'Traffic Management Course Melbourne', '2022-12-24 23:16:52', '2022-12-24 23:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `meta_tag_page`
--

DROP TABLE IF EXISTS `meta_tag_page`;
CREATE TABLE `meta_tag_page` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meta_tag_id` bigint(20) UNSIGNED NOT NULL,
  `page_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meta_tag_page`
--

INSERT INTO `meta_tag_page` (`id`, `meta_tag_id`, `page_id`, `created_at`, `updated_at`) VALUES
(10, 3, 1, NULL, NULL),
(12, 3, 2, NULL, NULL),
(13, 3, 3, NULL, NULL),
(19, 7, 1, NULL, NULL),
(30, 8, 4, NULL, NULL),
(31, 9, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
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
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_08_19_145349_create_courses_table', 1),
(6, '2021_08_19_145411_create_booking_dates_table', 1),
(7, '2021_08_25_145420_create_pages_table', 2),
(8, '2021_08_25_160409_create_meta_tags_table', 2),
(9, '2021_08_26_033411_create_meta_tag_page_table', 2),
(11, '2021_08_30_073247_add_title_to_pages_table', 3),
(12, '2022_06_28_172032_create_categories_table', 4),
(13, '2022_06_28_172341_add_category_id_to_courses_table', 5),
(14, '2022_07_01_195526_create_students_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Knowledge Empowers You',
  `slug` varchar(255) DEFAULT NULL,
  `is_course` tinyint(1) NOT NULL DEFAULT 0,
  `course_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `slug`, `is_course`, `course_id`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'Knowledge Empowers You', 'home', 0, NULL, '2021-08-25 22:30:37', '2022-01-24 00:03:20'),
(2, 'Contact', 'Knowledge Empowers You - Contact', 'contact', 0, NULL, '2021-08-25 22:30:37', '2022-01-24 00:27:32'),
(3, 'About', 'Knowledge Empowers You - About', 'about', 0, NULL, '2021-08-25 22:30:37', '2022-01-24 00:27:44'),
(4, 'RIIWHS205E Control traffic with  a stop slow bat', 'Course | RIIWHS205E Control traffic with  a stop slow bat', 'riiwhs205e-control-traffic-with-a-stop-slow-bat', 1, 10, '2021-08-25 22:30:37', '2022-06-29 02:32:01'),
(5, 'CPCCWHS1001 Prepare to work safely in the construction industry (White Card)', 'Course | CPCCWHS1001 Prepare to work safely in the construction industry (White Card)', 'cpccwhs1001-prepare-to-work-safely-in-the-construction-industry-white-card', 1, 12, '2021-08-25 22:30:37', '2022-05-22 22:13:55'),
(7, 'Electrical Spotters Course', 'Course | Electrical Spotters Course', 'electrical-spotters-course', 1, 16, '2021-08-25 22:30:37', '2022-05-22 22:14:29'),
(8, 'RIIWHS302E Implement Traffic Management Plans', 'Course | RIIWHS302E Implement Traffic Management Plans', 'riiwhs302e-implement-traffic-management-plans', 1, 17, '2021-08-25 22:30:37', '2022-06-29 02:30:05'),
(9, 'RIIMPO317F Conduct roller operations', 'Course | RIIMPO317F Conduct roller operations', 'riimpo317f-conduct-roller-operations', 1, 19, '2021-08-25 22:30:37', '2022-07-02 03:07:04'),
(11, 'Traffic Management Package', 'Course | Traffic Management Package', 'traffic-management-package', 1, 24, '2021-11-07 17:31:01', '2022-06-29 02:33:22'),
(12, 'Traffic Management and White Card Package', 'Course | Traffic Management and White Card Package', 'traffic-management-and-white-card-package', 1, 25, '2021-12-16 18:31:07', '2022-06-29 02:32:55'),
(18, 'Category', 'Knowledge Empowers You - Category', 'category', 0, NULL, '2021-08-25 22:30:37', '2022-01-24 00:27:44'),
(20, 'CPCCLDG3001 Licence to perform dogging', 'Course | CPCCLDG3001 Licence to perform dogging', 'cpccldg3001-licence-to-perform-dogging', 1, 32, '2022-07-01 22:20:34', '2022-07-01 22:21:59'),
(21, 'TLILIC0003 Licence to operate a forklift truck', 'TLILIC0003 Licence to operate a forklift truck', 'tlilic0003-licence-to-operate-a-forklift-truck', 1, 33, '2022-07-01 22:28:52', '2022-07-02 18:42:13'),
(22, 'TLILIC0004  Licence to operate an order picking forklift truck', 'Course | TLILIC0004  Licence to operate an order picking forklift truck', 'tlilic0004-licence-to-operate-an-order-picking-forklift-truck', 1, 34, '2022-07-02 02:53:36', '2022-07-02 02:56:06'),
(23, 'TLILIC0005 Licence to operate a boom-type elevating work platform (boom length 11 metres or more)', 'TLILIC0005 Licence to operate a boom-type elevating work platform (boom length 11 metres or more)', 'tlilic0005-licence-to-operate-a-boom-type-elevating-work-platform-boom-length-11-metres-or-more', 1, 35, '2022-07-02 03:03:00', '2022-07-02 18:42:26'),
(24, 'RIIMPO337E Conduct articulated haul truck operations', 'Course | RIIMPO337E Conduct articulated haul truck operations', 'riimpo337e-conduct-articulated-haul-truck-operations', 1, 36, '2022-07-02 03:26:49', '2022-07-02 03:51:05'),
(25, 'RIIMPO321F Conduct civil construction wheeled front end loader operations', 'RIIMPO321F Conduct civil construction wheeled front end loader operations', 'riimpo321f-conduct-civil-construction-wheeled-front-end-loader-operations', 1, 37, '2022-07-02 03:33:04', '2022-07-02 18:41:56'),
(26, 'RIIMPO318F Conduct civil construction skid steer loader operations', 'RIIMPO318F Conduct civil construction skid steer loader operations', 'riimpo318f-conduct-civil-construction-skid-steer-loader-operations', 1, 38, '2022-07-02 03:40:12', '2022-07-02 18:43:04'),
(27, 'RIIHAN309F Conduct telescopic materials handler operations', 'Course | RIIHAN309F Conduct telescopic materials handler operations', 'riihan309f-conduct-telescopic-materials-handler-operations', 1, 39, '2022-07-02 03:50:42', '2022-07-02 03:52:23'),
(28, 'RIIMPO320F - Conduct civil construction excavator operations', 'RIIMPO320F - Conduct civil construction excavator operations', 'riimpo320f-conduct-civil-construction-excavator-operations', 1, 40, '2022-07-02 04:00:38', '2022-07-02 18:43:39'),
(29, 'HLTAID009 Provide cardiopulmonary resuscitation CPR', 'HLTAID009 Provide cardiopulmonary resuscitation CPR', 'hltaid009-provide-cardiopulmonary-resuscitation-cpr', 1, 41, '2022-07-02 04:16:10', '2022-07-02 18:43:17'),
(30, 'HLTAID011 Provide First Aid', 'HLTAID011 Provide First Aid', 'hltaid011-provide-first-aid', 1, 42, '2022-07-02 04:21:16', '2022-07-02 18:43:53'),
(31, 'HLTAID012 Provide First Aid in an education and care setting', 'HLTAID012 Provide First Aid in an education and care setting', 'hltaid012-provide-first-aid-in-an-education-and-care-setting', 1, 43, '2022-07-02 04:26:43', '2022-07-02 18:44:10'),
(32, 'RIIWHS204E Work safely at heights', 'RIIWHS204E Work safely at heights', 'riiwhs204e-work-safely-at-heights', 1, 44, '2022-07-02 04:42:21', '2022-07-02 18:42:51'),
(33, 'RIIHAN301E Operate elevating work platform', 'RIIHAN301E Operate elevating work platform', 'riihan301e-operate-elevating-work-platform', 1, 45, '2022-07-02 04:55:36', '2022-07-02 18:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `pdf` text NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `extra` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `key`, `pdf`, `display_order`, `status`, `extra`, `created_at`, `updated_at`) VALUES
(6, 'Traffic Management', 'traffic-management-289693', 'storage/files/students/traffic-management-289693.pdf', 0, 1, NULL, '2022-07-02 18:28:35', '2022-07-02 18:28:35'),
(9, 'Marcel Khalife', 'marcel-khalife-029775', 'storage/files/students/marcel-khalife-029775.pdf', 0, 1, NULL, '2022-08-01 21:32:27', '2022-08-01 21:32:27'),
(10, 'Sidrak Dinkneh', 'sidrak-dinkneh-104540', 'storage/files/students/sidrak-dinkneh-104540.pdf', 0, 1, NULL, '2022-08-01 22:22:32', '2022-08-01 22:22:32'),
(11, 'Abdihakin Mohamed', 'abdihakin-mohamed-833498', 'storage/files/students/abdihakin-mohamed-833498.pdf', 0, 1, NULL, '2022-08-01 22:30:55', '2022-08-01 22:30:55'),
(12, 'Sidrak Dinkneh First Aid', 'sidrak-dinkneh-first-aid-163004', 'storage/files/students/sidrak-dinkneh-first-aid-163004.pdf', 0, 1, NULL, '2022-08-07 12:30:13', '2022-08-07 12:30:13'),
(13, 'Magud Maniel', 'magud-maniel-277484', 'storage/files/students/magud-maniel-277484.pdf', 0, 1, NULL, '2022-08-08 17:21:53', '2022-08-08 17:21:53'),
(14, 'Madeline Frankel', 'madeline-frankel-173498', 'storage/files/students/madeline-frankel-173498.pdf', 0, 1, NULL, '2022-08-08 17:24:46', '2022-08-08 17:24:46'),
(15, 'Paul Muckian RIIWHS204E Work safely at heights', 'paul-muckian-riiwhs204e-work-safely-at-heights-575805', 'storage/files/students/paul-muckian-riiwhs204e-work-safely-at-heights-575805.pdf', 0, 1, NULL, '2022-08-09 13:23:06', '2022-08-09 13:23:06'),
(16, 'Paul Muckian First Aid', 'paul-muckian-first-aid-647237', 'storage/files/students/paul-muckian-first-aid-647237.pdf', 0, 1, NULL, '2022-08-09 13:23:46', '2022-08-09 13:23:46'),
(17, 'Madibu Koko', 'madibu-koko-914345', 'storage/files/students/madibu-koko-914345.pdf', 0, 1, NULL, '2022-08-17 16:42:50', '2022-08-17 16:42:50'),
(18, 'Emma Nicholls', 'emma-nicholls-687497', 'storage/files/students/emma-nicholls-687497.pdf', 0, 1, NULL, '2022-09-18 01:20:46', '2022-09-18 01:20:46'),
(19, 'Muhammad Jami', 'muhammad-jami-141682', 'storage/files/students/muhammad-jami-141682.pdf', 0, 1, NULL, '2022-09-18 01:21:37', '2022-09-18 01:21:37'),
(20, 'Rexhep Emini', 'rexhep-emini-565354', 'storage/files/students/rexhep-emini-565354.pdf', 0, 1, NULL, '2022-09-18 01:38:03', '2022-09-18 01:38:03'),
(21, 'Rexhep Emini', 'rexhep-emini-402705', 'storage/files/students/rexhep-emini-402705.pdf', 0, 1, NULL, '2022-09-18 01:38:05', '2022-09-18 01:38:05'),
(22, 'Nicole Porter', 'nicole-porter-243182', 'storage/files/students/nicole-porter-243182.pdf', 0, 1, NULL, '2022-09-19 17:13:57', '2022-09-19 17:13:57'),
(23, 'Caine Hampshire', 'caine-hampshire-946825', 'storage/files/students/caine-hampshire-946825.pdf', 0, 1, NULL, '2022-09-19 17:14:40', '2022-09-19 17:14:40'),
(24, 'Steve Longinidis', 'steve-longinidis-837571', 'storage/files/students/steve-longinidis-837571.pdf', 0, 1, NULL, '2022-09-19 17:15:19', '2022-09-19 17:15:19'),
(25, 'Tracy Fox', 'tracy-fox-143244', 'storage/files/students/tracy-fox-143244.pdf', 0, 1, NULL, '2022-09-19 17:16:43', '2022-09-19 17:16:43'),
(26, 'Steven Biddle', 'steve-biddle-008274', 'storage/files/students/steve-biddle-008274.pdf', 0, 1, NULL, '2022-09-19 17:17:16', '2022-10-08 23:37:56'),
(27, 'Stuart Stanford', 'stuart-stanford-276162', 'storage/files/students/stuart-stanford-276162.pdf', 0, 1, NULL, '2022-09-20 18:18:52', '2022-09-20 18:18:52'),
(28, 'Marcel Alfuaadi', 'marcel-alfuaadi-367886', 'storage/files/students/marcel-alfuaadi-367886.pdf', 0, 1, NULL, '2022-10-13 12:44:06', '2022-10-13 12:44:06'),
(29, 'Joseta Upoko', 'joseta-upoko-544901', 'storage/files/students/joseta-upoko-544901.pdf', 0, 1, NULL, '2022-10-13 13:12:45', '2022-10-13 13:12:45'),
(30, 'Noah Harfouche', 'noah-harfouche-694405', 'storage/files/students/noah-harfouche-694405.pdf', 0, 1, NULL, '2022-10-13 13:27:40', '2022-10-13 13:27:40'),
(31, 'Ousama Abdul-Rahman', 'ousama-abdul-rahman-333490', 'storage/files/students/ousama-abdul-rahman-333490.pdf', 0, 1, NULL, '2022-10-13 13:35:19', '2022-10-13 13:35:19'),
(32, 'Jeremy De La Garde', 'jeremy-de-la-garde-596961', 'storage/files/students/jeremy-de-la-garde-596961.pdf', 0, 1, NULL, '2022-10-13 13:41:38', '2022-10-13 13:41:38'),
(33, 'Shane Camilleri', 'shane-camilleri-560581', 'storage/files/students/shane-camilleri-560581.pdf', 0, 1, NULL, '2022-10-13 13:42:18', '2022-10-13 13:42:18'),
(34, 'Dylan Yasar', 'dylan-yasar-112213', 'storage/files/students/dylan-yasar-112213.pdf', 0, 1, NULL, '2022-10-13 13:55:36', '2022-10-13 13:55:36'),
(35, 'Colin Bigham', 'colin-bigham-164975', 'storage/files/students/colin-bigham-164975.pdf', 0, 1, NULL, '2022-10-17 13:10:55', '2022-10-17 13:10:55'),
(36, 'Chantell Waho-Moo', 'chantell-waho-moo-487901', 'storage/files/students/chantell-waho-moo-487901.pdf', 0, 1, NULL, '2022-12-08 15:37:16', '2022-12-08 15:37:16'),
(37, 'Abdalla Omar', 'abdalla-omar-647809', 'storage/files/students/abdalla-omar-647809.pdf', 0, 1, NULL, '2022-12-08 15:40:47', '2022-12-08 15:40:47'),
(38, 'Ali Abubaker', 'abli-abubaker-712111', 'storage/files/students/abli-abubaker-712111.pdf', 0, 1, NULL, '2022-12-08 15:45:39', '2022-12-08 15:48:42'),
(39, 'Taha Rajab', 'taha-rajab-340555', 'storage/files/students/taha-rajab-340555.pdf', 0, 1, NULL, '2022-12-18 17:52:36', '2022-12-18 17:52:36'),
(40, 'Paul Donnellan', 'paul-donnellan-408105', 'storage/files/students/paul-donnellan-408105.pdf', 0, 1, NULL, '2023-01-28 23:26:52', '2023-01-28 23:26:52'),
(41, 'Paul Downie', 'paul-downie-128776', 'storage/files/students/paul-downie-128776.pdf', 0, 1, NULL, '2023-01-28 23:36:14', '2023-01-28 23:36:14'),
(42, 'Ryan Wills', 'ryan-wills-323107', 'storage/files/students/ryan-wills-323107.pdf', 0, 1, NULL, '2023-01-28 23:39:53', '2023-01-28 23:39:53'),
(43, 'David Taylor', 'david-taylor-389510', 'storage/files/students/david-taylor-389510.pdf', 0, 1, NULL, '2023-01-28 23:42:22', '2023-01-28 23:42:22'),
(44, 'Sabah Harfouche', 'sabah-harfouche-233973', 'storage/files/students/sabah-harfouche-233973.pdf', 0, 1, NULL, '2023-01-28 23:48:28', '2023-01-28 23:48:28'),
(45, 'Saydin Hersi', 'saydin-hersi-747990', 'storage/files/students/saydin-hersi-747990.pdf', 0, 1, NULL, '2023-01-28 23:53:16', '2023-01-28 23:53:16'),
(46, 'Adam Soliman', 'adam-adam-516341', 'storage/files/students/adam-adam-516341.pdf', 0, 1, NULL, '2023-01-29 00:07:10', '2023-09-17 17:16:45'),
(47, 'Mohamad El-Hussein', 'mohamad-el-hussein-374651', 'storage/files/students/mohamad-el-hussein-374651.pdf', 0, 1, NULL, '2023-01-29 00:07:53', '2023-01-29 00:07:53'),
(48, 'Zachary Green', 'zachary-green-342906', 'storage/files/students/zachary-green-342906.pdf', 0, 1, NULL, '2023-01-29 00:08:10', '2023-01-29 00:08:10'),
(49, 'Hamza Habib', 'hamza-habib-401998', 'storage/files/students/hamza-habib-401998.pdf', 0, 1, NULL, '2023-01-29 00:08:33', '2023-01-29 00:08:33'),
(50, 'Saydin Hersi 2', 'saydin-hersi-2-698234', 'storage/files/students/saydin-hersi-2-698234.pdf', 0, 1, NULL, '2023-01-29 00:09:06', '2023-01-29 00:09:06'),
(51, 'Emily Ward', 'emily-ward-209569', 'storage/files/students/emily-ward-209569.pdf', 0, 1, NULL, '2023-01-29 00:10:21', '2023-01-29 00:10:21'),
(52, 'Susan Pallo', 'susan-pallo-755245', 'storage/files/students/susan-pallo-755245.pdf', 0, 1, NULL, '2023-01-29 00:14:28', '2023-01-29 00:14:28'),
(53, 'Qu Lamande', 'qu-lamande-528623', 'storage/files/students/qu-lamande-528623.pdf', 0, 1, NULL, '2023-01-29 00:18:33', '2023-01-29 00:18:33'),
(54, 'Sayed Hussaini', 'sayed-hussaini-882605', 'storage/files/students/sayed-hussaini-882605.pdf', 0, 1, NULL, '2023-01-29 00:22:42', '2023-01-29 00:22:42'),
(55, 'Abshir Ali', 'abshir-ali-038435', 'storage/files/students/abshir-ali-038435.pdf', 0, 1, NULL, '2023-02-14 08:14:04', '2023-02-14 08:14:04'),
(56, 'Luca Bertinazzi', 'luca-bertinazzi-688259', 'storage/files/students/luca-bertinazzi-688259.pdf', 0, 1, NULL, '2023-02-14 08:23:12', '2023-02-14 08:23:12'),
(57, 'Ousama Abdul-Rahman', 'ousama-abdul-rahman-536016', 'storage/files/students/ousama-abdul-rahman-536016.pdf', 0, 1, NULL, '2023-02-14 08:24:11', '2023-02-14 08:24:11'),
(58, 'Yama Bromand', 'yama-bromand-770890', 'storage/files/students/yama-bromand-770890.pdf', 0, 1, NULL, '2023-03-07 10:14:06', '2023-03-07 10:14:06'),
(59, 'Daniella Haddad', 'daniella-haddad-799884', 'storage/files/students/daniella-haddad-799884.pdf', 0, 1, NULL, '2023-03-07 10:15:53', '2023-03-07 10:15:53'),
(60, 'Raniya Hurmiz', 'raniya-hurmiz-280527', 'storage/files/students/raniya-hurmiz-280527.pdf', 0, 1, NULL, '2023-03-07 10:16:41', '2023-03-07 10:16:41'),
(61, 'David Bennet', 'david-bennet-183264', 'storage/files/students/david-bennet-183264.pdf', 0, 1, NULL, '2023-03-07 10:25:20', '2023-03-07 10:25:20'),
(62, 'Hafiz Raza', 'hafiz-raza-143473', 'storage/files/students/hafiz-raza-143473.pdf', 0, 1, NULL, '2023-03-09 14:07:33', '2023-03-09 14:07:33'),
(63, 'Waseem Ashrif', 'waseem-ashrif-870315', 'storage/files/students/waseem-ashrif-870315.pdf', 0, 1, NULL, '2023-03-09 17:02:48', '2023-03-09 17:02:48'),
(64, 'Usman Umer', 'usman-umer-081305', 'storage/files/students/usman-umer-081305.pdf', 0, 1, NULL, '2023-03-09 17:04:20', '2023-03-09 17:04:20'),
(65, 'Muhammad Khalid', 'muhammad-khalid-472858', 'storage/files/students/muhammad-khalid-472858.pdf', 0, 1, NULL, '2023-03-09 17:04:49', '2023-03-09 17:04:49'),
(66, 'Muashir Ali', 'muashir-ali-632406', 'storage/files/students/muashir-ali-632406.pdf', 0, 1, NULL, '2023-03-09 17:05:24', '2023-03-09 17:05:24'),
(67, 'Hassam Ahmed', 'hassam-ahmed-274733', 'storage/files/students/hassam-ahmed-274733.pdf', 0, 1, NULL, '2023-03-09 17:22:14', '2023-03-09 17:22:14'),
(68, 'Husnain Ahmed', 'husnain-ahmed-492683', 'storage/files/students/husnain-ahmed-492683.pdf', 0, 1, NULL, '2023-03-09 17:23:08', '2023-03-09 17:23:08'),
(69, 'Ahmad Raza', 'ahmad-raza-476363', 'storage/files/students/ahmad-raza-476363.pdf', 0, 1, NULL, '2023-03-09 17:23:31', '2023-03-09 17:23:31'),
(70, 'Atif Mehmood', 'atif-mehmood-882308', 'storage/files/students/atif-mehmood-882308.pdf', 0, 1, NULL, '2023-03-09 17:23:58', '2023-03-09 17:23:58'),
(71, 'Prabin Suwal', 'prabin-suwal-772991', 'storage/files/students/prabin-suwal-772991.pdf', 0, 1, NULL, '2023-03-16 15:49:03', '2023-03-16 15:49:03'),
(72, 'Yati Sharma', 'yati-sharma-237518', 'storage/files/students/yati-sharma-237518.pdf', 0, 1, NULL, '2023-03-16 15:51:51', '2023-03-16 15:51:51'),
(73, 'Mohamed Mehrez', 'mohamed-mehrez-950292', 'storage/files/students/mohamed-mehrez-950292.pdf', 0, 1, NULL, '2023-03-26 13:48:33', '2023-03-26 13:48:33'),
(74, 'Mohammad Ahmadzay', 'mohammad-ahmadzay-291784', 'storage/files/students/mohammad-ahmadzay-291784.pdf', 0, 1, NULL, '2023-03-26 23:05:07', '2023-03-26 23:05:07'),
(75, 'Anthony Sassine', 'anthony-sassine-791643', 'storage/files/students/anthony-sassine-791643.pdf', 0, 1, NULL, '2023-03-26 23:11:06', '2023-03-26 23:11:06'),
(77, 'Gorgi Nikolovski', 'gorgi-nikolovski-088910', 'storage/files/students/gorgi-nikolovski-088910.pdf', 0, 1, NULL, '2023-03-26 23:12:06', '2023-03-26 23:12:06'),
(78, 'Mahmoud Jarrari', 'mahmoud-jarrari-083520', 'storage/files/students/mahmoud-jarrari-083520.pdf', 0, 1, NULL, '2023-03-26 23:12:44', '2023-03-26 23:12:44'),
(79, 'Kadir Turkmen', 'kadir-turkmen-042164', 'storage/files/students/kadir-turkmen-042164.pdf', 0, 1, NULL, '2023-03-26 23:13:18', '2023-03-26 23:13:18'),
(80, 'Antonio Rossi', 'antonio-rossi-302367', 'storage/files/students/antonio-rossi-302367.pdf', 0, 1, NULL, '2023-04-12 17:58:37', '2023-04-12 17:58:37'),
(82, 'Joseph Adams', 'joseph-adams-968008', 'storage/files/students/joseph-adams-968008.pdf', 0, 1, NULL, '2023-04-13 05:22:44', '2023-04-13 05:22:44'),
(83, 'Aaron Gomes', 'aaron-gomes-236466', 'storage/files/students/aaron-gomes-236466.pdf', 0, 1, NULL, '2023-04-13 05:23:46', '2023-04-13 05:23:46'),
(84, 'Christopher Doulis', 'christopher-doulis-794155', 'storage/files/students/christopher-doulis-794155.pdf', 0, 1, NULL, '2023-04-13 05:24:16', '2023-04-13 05:24:16'),
(85, 'Damian Mitchell', 'damian-mitchell-064883', 'storage/files/students/damian-mitchell-064883.pdf', 0, 1, NULL, '2023-04-13 05:24:36', '2023-04-13 05:24:36'),
(86, 'Daniel Cavanagh', 'daniel-cavanagh-401178', 'storage/files/students/daniel-cavanagh-401178.pdf', 0, 1, NULL, '2023-04-13 05:25:14', '2023-04-13 05:25:14'),
(87, 'Daniel Ruggieri', 'daniel-ruggieri-764101', 'storage/files/students/daniel-ruggieri-764101.pdf', 0, 1, NULL, '2023-04-13 05:25:37', '2023-04-13 05:25:37'),
(88, 'David Napier', 'david-napier-749020', 'storage/files/students/david-napier-749020.pdf', 0, 1, NULL, '2023-04-13 05:26:14', '2023-04-13 05:26:14'),
(89, 'Giovanni Moleta', 'giovanni-moleta-320198', 'storage/files/students/giovanni-moleta-320198.pdf', 0, 1, NULL, '2023-04-13 05:26:53', '2023-04-13 05:26:53'),
(90, 'James Cassar', 'james-cassar-345974', 'storage/files/students/james-cassar-345974.pdf', 0, 1, NULL, '2023-04-13 05:27:14', '2023-04-13 05:27:14'),
(91, 'Liam Porter', 'liam-porter-956250', 'storage/files/students/liam-porter-956250.pdf', 0, 1, NULL, '2023-04-13 05:27:40', '2023-04-13 05:27:40'),
(92, 'Orion Laban', 'orion-laban-982432', 'storage/files/students/orion-laban-982432.pdf', 0, 1, NULL, '2023-04-13 05:29:12', '2023-04-13 05:29:12'),
(93, 'Peter Spitts', 'peter-spitts-579732', 'storage/files/students/peter-spitts-579732.pdf', 0, 1, NULL, '2023-04-13 05:29:42', '2023-04-13 05:29:42'),
(94, 'Phuong Tran', 'phuong-tran-857104', 'storage/files/students/phuong-tran-857104.pdf', 0, 1, NULL, '2023-04-13 05:30:06', '2023-04-13 05:30:06'),
(95, 'Rimoon Gorgiss', 'rimoon-gorgiss-220383', 'storage/files/students/rimoon-gorgiss-220383.pdf', 0, 1, NULL, '2023-04-13 05:30:29', '2023-04-13 05:30:29'),
(96, 'Sebastian Zielinski', 'sebastian-zielinski-196874', 'storage/files/students/sebastian-zielinski-196874.pdf', 0, 1, NULL, '2023-04-13 05:31:03', '2023-04-13 05:31:03'),
(97, 'Shane Watt', 'shane-watt-142263', 'storage/files/students/shane-watt-142263.pdf', 0, 1, NULL, '2023-04-13 05:31:27', '2023-04-13 05:31:27'),
(98, 'Tristen Sutherland', 'tristen-sutherland-735556', 'storage/files/students/tristen-sutherland-735556.pdf', 0, 1, NULL, '2023-04-13 05:31:57', '2023-04-13 05:31:57'),
(99, 'Viliami Kafoa Taufahema', 'viliami-kafoa-taufahema-586057', 'storage/files/students/viliami-kafoa-taufahema-586057.pdf', 0, 1, NULL, '2023-04-13 05:32:50', '2023-04-13 05:32:50'),
(100, 'Zubayr Benmassoud', 'zubayr-benmassoud-067193', 'storage/files/students/zubayr-benmassoud-067193.pdf', 0, 1, NULL, '2023-04-13 05:33:16', '2023-04-13 05:33:16'),
(101, 'Joseph Habchi', 'joseph-habchi-828239', 'storage/files/students/joseph-habchi-828239.pdf', 0, 1, NULL, '2023-04-13 06:14:58', '2023-04-13 06:14:58'),
(102, 'Mohamed Awo', 'mohamed-awo-448178', 'storage/files/students/mohamed-awo-448178.pdf', 0, 1, NULL, '2023-04-13 06:15:58', '2023-04-13 06:15:58'),
(103, 'Zainoun Mazloum control traffic', 'zainoun-mazloum-control-traffic-590021', 'storage/files/students/zainoun-mazloum-control-traffic-590021.pdf', 0, 1, NULL, '2023-04-13 06:16:27', '2023-04-13 06:16:27'),
(104, 'Zainoun Mazloum Implement traffic', 'zainoun-mazloum-implement-traffic-651762', 'storage/files/students/zainoun-mazloum-implement-traffic-651762.pdf', 0, 1, NULL, '2023-04-13 06:16:57', '2023-04-13 06:16:57'),
(105, 'Joseph Adams', 'joseph-adams-978309', 'storage/files/students/joseph-adams-978309.pdf', 0, 1, NULL, '2023-04-13 08:48:55', '2023-04-13 08:48:55'),
(106, 'Aaron Gomes', 'aaron-gomes-899866', 'storage/files/students/aaron-gomes-899866.pdf', 0, 1, NULL, '2023-04-13 08:49:13', '2023-04-13 08:49:13'),
(109, 'Christopher Doulis', 'christopher-doulis-485176', 'storage/files/students/christopher-doulis-485176.pdf', 0, 1, NULL, '2023-04-13 08:50:21', '2023-04-13 08:50:21'),
(110, 'Damian Mitchell', 'damian-mitchell-008420', 'storage/files/students/damian-mitchell-008420.pdf', 0, 1, NULL, '2023-04-13 08:50:36', '2023-04-13 08:50:36'),
(111, 'Daniel Cavanagh', 'daniel-cavanagh-623245', 'storage/files/students/daniel-cavanagh-623245.pdf', 0, 1, NULL, '2023-04-13 08:50:50', '2023-04-13 08:50:50'),
(112, 'Daniel Ruggieri', 'daniel-ruggieri-579144', 'storage/files/students/daniel-ruggieri-579144.pdf', 0, 1, NULL, '2023-04-13 08:51:03', '2023-04-13 08:51:03'),
(113, 'David Napier', 'david-napier-308117', 'storage/files/students/david-napier-308117.pdf', 0, 1, NULL, '2023-04-13 08:51:20', '2023-04-13 08:51:20'),
(114, 'Giovanni Moleta', 'giovanni-moleta-701345', 'storage/files/students/giovanni-moleta-701345.pdf', 0, 1, NULL, '2023-04-13 08:51:37', '2023-04-13 08:51:37'),
(115, 'James Cassar', 'james-cassar-789384', 'storage/files/students/james-cassar-789384.pdf', 0, 1, NULL, '2023-04-13 08:51:50', '2023-04-13 08:51:50'),
(116, 'Liam Porter', 'liam-porter-800896', 'storage/files/students/liam-porter-800896.pdf', 0, 1, NULL, '2023-04-13 08:52:09', '2023-04-13 08:52:09'),
(117, 'Mohamed Awo', 'mohamed-awo-451485', 'storage/files/students/mohamed-awo-451485.pdf', 0, 1, NULL, '2023-04-13 08:52:25', '2023-04-13 08:52:25'),
(118, 'Orion Laban', 'orion-laban-652395', 'storage/files/students/orion-laban-652395.pdf', 0, 1, NULL, '2023-04-13 08:52:42', '2023-04-13 08:52:42'),
(119, 'Peter Spitts', 'peter-spitts-568814', 'storage/files/students/peter-spitts-568814.pdf', 0, 1, NULL, '2023-04-13 08:52:58', '2023-04-13 08:52:58'),
(120, 'Phuong Tran', 'phuong-tran-640760', 'storage/files/students/phuong-tran-640760.pdf', 0, 1, NULL, '2023-04-13 08:53:17', '2023-04-13 08:53:17'),
(121, 'Rimoon Gorgiss', 'rimoon-gorgiss-314372', 'storage/files/students/rimoon-gorgiss-314372.pdf', 0, 1, NULL, '2023-04-13 08:53:33', '2023-04-13 08:53:33'),
(122, 'Sebastian Zielinski', 'sebastian-zielinski-196551', 'storage/files/students/sebastian-zielinski-196551.pdf', 0, 1, NULL, '2023-04-13 08:53:46', '2023-04-13 08:53:46'),
(123, 'Shane Watt', 'shane-watt-557254', 'storage/files/students/shane-watt-557254.pdf', 0, 1, NULL, '2023-04-13 08:53:57', '2023-04-13 08:53:57'),
(124, 'Tristen Sutherland', 'tristen-sutherland-437551', 'storage/files/students/tristen-sutherland-437551.pdf', 0, 1, NULL, '2023-04-13 08:54:09', '2023-04-13 08:54:09'),
(125, 'Viliami Kafoa Taufahema', 'viliami-kafoa-taufahema-914522', 'storage/files/students/viliami-kafoa-taufahema-914522.pdf', 0, 1, NULL, '2023-04-13 08:54:21', '2023-04-13 08:54:21'),
(126, 'Zubayr Benmassoud', 'zubayr-benmassoud-523231', 'storage/files/students/zubayr-benmassoud-523231.pdf', 0, 1, NULL, '2023-04-13 08:54:37', '2023-04-13 08:54:37'),
(127, 'Rachel Duncan', 'rachel-duncan-650787', 'storage/files/students/rachel-duncan-650787.pdf', 0, 1, NULL, '2023-05-08 20:21:35', '2023-05-08 20:21:35'),
(128, 'Tony Khouny', 'tony-khouny-424969', 'storage/files/students/tony-khouny-424969.pdf', 0, 1, NULL, '2023-05-08 20:22:23', '2023-05-08 20:22:23'),
(129, 'Ritchie Elliott', 'ritchie-elliott-131385', 'storage/files/students/ritchie-elliott-131385.pdf', 0, 1, NULL, '2023-05-08 20:23:06', '2023-05-08 20:23:06'),
(130, 'Ahmad Al-Musawi', 'ahmad-al-musawi-915177', 'storage/files/students/ahmad-al-musawi-915177.pdf', 0, 1, NULL, '2023-05-15 19:17:44', '2023-05-15 19:17:44'),
(131, 'Luca Bertinazzi', 'luca-bertinazzi-268919', 'storage/files/students/luca-bertinazzi-268919.pdf', 0, 1, NULL, '2023-05-17 16:46:06', '2023-05-17 16:46:06'),
(132, 'Joshua White', 'joshua-white-887173', 'storage/files/students/joshua-white-887173.pdf', 0, 1, NULL, '2023-05-21 11:22:31', '2023-05-21 11:22:31'),
(133, 'Tavita Latu', 'tavita-latu-047994', 'storage/files/students/tavita-latu-047994.pdf', 0, 1, NULL, '2023-05-21 11:29:11', '2023-05-21 11:29:11'),
(134, 'Wade Worth', 'wade-worth-244567', 'storage/files/students/wade-worth-244567.pdf', 0, 1, NULL, '2023-05-21 11:29:31', '2023-05-21 11:29:31'),
(135, 'Abdinasir Chilal', 'abdinasir-chilal-084425', 'storage/files/students/abdinasir-chilal-084425.pdf', 0, 1, NULL, '2023-06-07 14:19:12', '2023-06-07 14:19:12'),
(136, 'Aden Farhan', 'aden-farhan-849854', 'storage/files/students/aden-farhan-849854.pdf', 0, 1, NULL, '2023-06-07 14:19:47', '2023-06-07 14:19:47'),
(137, 'John Bamblett', 'john-bamblett-527440', 'storage/files/students/john-bamblett-527440.pdf', 0, 1, NULL, '2023-06-07 14:25:33', '2023-06-07 14:25:33'),
(138, 'Samson Anderson', 'samson-anderson-785660', 'storage/files/students/samson-anderson-785660.pdf', 0, 1, NULL, '2023-06-07 14:26:16', '2023-06-07 14:26:16'),
(139, 'Tyron Bloomfield', 'tyron-bloomfield-063494', 'storage/files/students/tyron-bloomfield-063494.pdf', 0, 1, NULL, '2023-06-07 14:26:36', '2023-06-07 14:26:36'),
(140, 'Achmat Sadien', 'achmat-sadien-806524', 'storage/files/students/achmat-sadien-806524.pdf', 0, 1, NULL, '2023-06-14 18:10:59', '2023-06-14 18:10:59'),
(141, 'Buri Abdo', 'buri-abdo-502859', 'storage/files/students/buri-abdo-502859.pdf', 0, 1, NULL, '2023-06-14 18:11:28', '2023-06-14 18:11:28'),
(142, 'Carmen Ly', 'carmen-ly-979572', 'storage/files/students/carmen-ly-979572.pdf', 0, 1, NULL, '2023-06-14 18:11:41', '2023-06-14 18:11:41'),
(143, 'Sam Elkhouri', 'sam-elkhouri-241913', 'storage/files/students/sam-elkhouri-241913.pdf', 0, 1, NULL, '2023-08-29 13:34:18', '2023-08-29 13:34:18'),
(144, 'Shaun Giblin', 'shaun-giblin-664914', 'storage/files/students/shaun-giblin-664914.pdf', 0, 1, NULL, '2023-08-29 16:05:01', '2023-08-29 16:05:01'),
(145, 'Shaun Giblin', 'shaun-giblin-003731', 'storage/files/students/shaun-giblin-003731.pdf', 0, 1, NULL, '2023-08-29 16:05:03', '2023-08-29 16:05:03'),
(146, 'Ali Abubaker Roller', 'ali-abubaker-roller-181693', 'storage/files/students/ali-abubaker-roller-181693.pdf', 0, 1, NULL, '2023-08-31 14:37:25', '2023-08-31 14:37:25'),
(147, 'Ali Abubaker Roller', 'ali-abubaker-roller-560603', 'storage/files/students/ali-abubaker-roller-560603.pdf', 0, 1, NULL, '2023-08-31 14:37:27', '2023-08-31 14:37:27'),
(148, 'Ross D\'Aspromonte', 'ross-daspromonte-710242', 'storage/files/students/ross-daspromonte-710242.pdf', 0, 1, NULL, '2023-08-31 14:51:14', '2023-08-31 14:51:14'),
(149, 'Corey Matthews', 'corey-matthews-435296', 'storage/files/students/corey-matthews-435296.pdf', 0, 1, NULL, '2023-09-17 13:46:13', '2023-09-17 13:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@admin.com', NULL, '$2y$10$Q9EozRc3CnmAf0zw9l7p9O9hMwUxQveOQNlf1YQqpoCZunGt6XJFq', NULL, '2021-08-19 10:05:31', '2023-04-13 05:19:49'),
(2, 'Maintainer', 'maintainer', 'maintainer@admin.com', NULL, '$2a$12$/Byd3d4B3akMUjgbJ0QJSuW.bA5LHT.LUlAMuMkBMM8DuId1wyHJe', NULL, '2021-08-19 10:05:31', '2022-04-24 03:38:44'),
(3, 'Editor', 'editor', 'editor@admin.com', NULL, '$2a$12$pMB1lj6ECbYtbsFNkcfhaOq5fdXlMIhIYR7lWp3fyrx1ViTC04XdC', NULL, '2021-08-19 10:05:31', '2022-04-24 03:38:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_dates`
--
ALTER TABLE `booking_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_dates_course_id_foreign` (`course_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_category_id_foreign` (`category_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `meta_tags`
--
ALTER TABLE `meta_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_tag_page`
--
ALTER TABLE `meta_tag_page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_tag_page_meta_tag_id_foreign` (`meta_tag_id`),
  ADD KEY `meta_tag_page_page_id_foreign` (`page_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
