-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2020 at 06:03 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resultsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `Class_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `ClassRef` varchar(100) NOT NULL,
  `Status` int(11) DEFAULT 1,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `School` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`Class_id`, `Name`, `ClassRef`, `Status`, `DateCreated`, `DateUpdated`, `School`, `OrganizerId`) VALUES
(13, 'Primary 1', 'DSR-3484695', 1, '2019-11-22 17:39:23', '0000-00-00 00:00:00', 4, 1),
(14, 'Primary 2', 'DSR-4759960', 1, '2019-11-22 17:39:23', '0000-00-00 00:00:00', 4, 1),
(15, 'Primary 3', 'DSR-6865463', 1, '2019-11-22 17:39:23', '0000-00-00 00:00:00', 4, 1),
(16, 'Primary 4', 'DSR-6035528', 1, '2019-11-22 17:39:23', '0000-00-00 00:00:00', 4, 1),
(17, 'Primary 5', 'DSR-5136709', 1, '2019-11-22 17:39:23', '0000-00-00 00:00:00', 4, 1),
(18, 'Primary 6', 'DSR-7248254', 1, '2019-11-22 17:39:23', '0000-00-00 00:00:00', 4, 1),
(19, 'JSS 1', 'DSR-8933200', 1, '2019-11-22 17:41:02', '0000-00-00 00:00:00', 5, 1),
(20, 'JSS 2', 'DSR-9287591', 1, '2019-11-22 17:41:02', '0000-00-00 00:00:00', 5, 1),
(21, 'JSS 3', 'DSR-6305325', 1, '2019-11-22 17:41:02', '0000-00-00 00:00:00', 5, 1),
(22, 'SSS 1', 'DSR-6546118', 1, '2019-11-22 17:41:02', '0000-00-00 00:00:00', 5, 1),
(23, 'SSS 2', 'DSR-9744100', 1, '2019-11-22 17:41:02', '0000-00-00 00:00:00', 5, 1),
(24, 'SSS 3', 'DSR-4244537', 1, '2019-11-22 17:41:02', '0000-00-00 00:00:00', 5, 1),
(25, 'Jss 1', 'DSR-3955706', 1, '2020-01-21 18:02:25', '0000-00-00 00:00:00', 7, 3),
(26, 'JSS 2', 'DSR-6754885', 1, '2020-01-21 18:03:09', '0000-00-00 00:00:00', 7, 3),
(27, 'Jss 3', 'DSR-3573217', 1, '2020-01-21 18:03:09', '0000-00-00 00:00:00', 7, 3),
(28, 'Sss 1', 'DSR-9922958', 1, '2020-01-21 18:03:09', '0000-00-00 00:00:00', 7, 3),
(29, 'Sss 2', 'DSR-1464996', 1, '2020-01-21 18:03:09', '0000-00-00 00:00:00', 7, 3),
(30, 'SSS 3', 'DSR-5661196', 1, '2020-01-21 18:03:09', '0000-00-00 00:00:00', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `Faq_id` int(11) NOT NULL,
  `Question` text NOT NULL,
  `Answer` longtext NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `Category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`Faq_id`, `Question`, `Answer`, `Status`, `Category`) VALUES
(1, 'How to enable scratch pin usage.', 'ehhdjjkdooe', 1, 1),
(3, 'dfjrejriooreuiooieopio', 'efwjikdioioewroioieioioe3', 1, 3),
(5, 'eikrieiireeeeeee', 'hjrhjrjkreeeeeeeeeeeeeee', 1, 2),
(6, 'fkjfruruoiroiir', 'weujweuuuuuuuuuuuuuuuuue', 1, 4),
(7, 'rrrrrr', 'fdfgh fhgfgt bgghhggtr', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `faq_category`
--

CREATE TABLE `faq_category` (
  `Category_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Icon` varchar(150) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_category`
--

INSERT INTO `faq_category` (`Category_id`, `Name`, `Icon`, `Status`) VALUES
(1, 'Security', 'ti-lock', 2),
(2, 'Profile', 'ti-user', 1),
(3, 'General', 'ti-world', 1),
(4, 'Support', 'ti-support', 1),
(5, 'LiveChat', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faq_request`
--

CREATE TABLE `faq_request` (
  `Request_id` int(11) NOT NULL,
  `Category` int(11) NOT NULL,
  `Question` text NOT NULL,
  `Answer` longtext NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq_request`
--

INSERT INTO `faq_request` (`Request_id`, `Category`, `Question`, `Answer`, `Status`) VALUES
(1, 2, 'How to create a school', 'Navigate to ...', 3);

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `Site_name` varchar(150) NOT NULL,
  `Site_tag` text NOT NULL,
  `Site_description` longtext NOT NULL,
  `Site_shortname` varchar(100) NOT NULL,
  `Site_email` varchar(150) NOT NULL,
  `Site_supportemail` varchar(150) NOT NULL,
  `Footer_about` text NOT NULL,
  `Maintenance` int(11) NOT NULL,
  `Resultpin_length` int(11) NOT NULL,
  `Pin_usage` int(11) NOT NULL,
  `Teacher_add_students` int(11) NOT NULL,
  `Teacher_add_result` int(11) NOT NULL,
  `footer_text` text NOT NULL,
  `Site_logo` varchar(150) NOT NULL,
  `Serialpin_length` int(11) NOT NULL,
  `Result_type` int(11) NOT NULL,
  `Default_password` varchar(100) NOT NULL,
  `Check_result_nologin` int(11) NOT NULL,
  `Site_notification` int(11) NOT NULL DEFAULT 1,
  `Site_twoway` int(11) NOT NULL DEFAULT 1,
  `Allow_newsletter` int(11) NOT NULL DEFAULT 2,
  `Link` text NOT NULL,
  `show_testmonials` int(11) NOT NULL DEFAULT 2,
  `Site_address` text NOT NULL,
  `Site_phone` text NOT NULL,
  `Site_state` varchar(150) NOT NULL,
  `Site_country` varchar(150) NOT NULL,
  `Site_registration` int(11) NOT NULL DEFAULT 1,
  `Email_verification` int(11) NOT NULL,
  `Currency_sign` varchar(20) NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `Mastercode_length` int(11) NOT NULL DEFAULT 8,
  `Securitycode_length` int(11) NOT NULL DEFAULT 7
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `Site_name`, `Site_tag`, `Site_description`, `Site_shortname`, `Site_email`, `Site_supportemail`, `Footer_about`, `Maintenance`, `Resultpin_length`, `Pin_usage`, `Teacher_add_students`, `Teacher_add_result`, `footer_text`, `Site_logo`, `Serialpin_length`, `Result_type`, `Default_password`, `Check_result_nologin`, `Site_notification`, `Site_twoway`, `Allow_newsletter`, `Link`, `show_testmonials`, `Site_address`, `Site_phone`, `Site_state`, `Site_country`, `Site_registration`, `Email_verification`, `Currency_sign`, `Currency`, `Mastercode_length`, `Securitycode_length`) VALUES
(1, 'Digital School Result', 'School Results, Academica Result Management System', 'Diginal Result Manager is an online content management system for schools to safely store their students\' results. We have built this system with great care to ensure that every data is safely stored  and available at all time to the school.', 'DSR', 'academicarms@gmail.com', 'support@digitalresults.com', '<p>Diginal Result Manager is an online content management system for schools to safely store their students\' results. We have built this system with great care to ensure that every data is safely stored  and available at all time to the school.</p>', 2, 10, 4, 1, 1, '&copy; All Rights Reserved.', '30a4d4e0945678b9f67deca386d8266b.png', 20, 2, 'ARMSTART', 1, 1, 1, 1, 'https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&id=92a4423d01', 1, 'University of Nigeria, Nsukka', '08147298815', 'Enugu', 'Nigeria', 1, 2, '$', 'USD', 8, 7);

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `Grade_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Min_Score` varchar(100) NOT NULL,
  `Max_Score` varchar(100) NOT NULL,
  `Comment` varchar(100) NOT NULL,
  `Grade_point` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `School_id` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`Grade_id`, `Name`, `Min_Score`, `Max_Score`, `Comment`, `Grade_point`, `Status`, `School_id`, `OrganizerId`) VALUES
(13, 'A', '70', '100', 'Excellent', '5', 1, 4, 1),
(14, 'B', '60', '69', 'Good', '4', 1, 4, 1),
(15, 'C', '50', '59', 'Credit', '3', 1, 4, 1),
(16, 'D', '40', '49', 'Pass', '2', 1, 4, 1),
(17, 'F', '0', '39', 'Fail', '0', 1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

CREATE TABLE `organizer` (
  `OrganizerId` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Balance` varchar(150) NOT NULL DEFAULT '0',
  `Twoway` int(11) NOT NULL,
  `Twoway_code` varchar(100) NOT NULL,
  `ResetCode` varchar(100) NOT NULL,
  `EmailVerifyCode` varchar(100) NOT NULL,
  `EmailVerify` int(11) NOT NULL,
  `MasterCode` varchar(150) NOT NULL,
  `SecurityCode` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Notifyme` int(11) NOT NULL,
  `Active_package` int(11) NOT NULL DEFAULT 1,
  `OrganSess` varchar(100) NOT NULL,
  `Country` varchar(150) NOT NULL,
  `State` varchar(150) NOT NULL,
  `City` varchar(150) NOT NULL,
  `Zip` varchar(100) NOT NULL,
  `Position` varchar(150) NOT NULL DEFAULT 'Organizer',
  `About` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`OrganizerId`, `Name`, `Email`, `Password`, `Username`, `Balance`, `Twoway`, `Twoway_code`, `ResetCode`, `EmailVerifyCode`, `EmailVerify`, `MasterCode`, `SecurityCode`, `Status`, `Notifyme`, `Active_package`, `OrganSess`, `Country`, `State`, `City`, `Zip`, `Position`, `About`) VALUES
(1, 'Michael Erastus', 'meritinfos@gmail.com', '$2y$10$ryjm3VaB6UeBlmLE./lavu9SQYG27pNV3vwtoRaKuzi3CS2EBPlca', 'meritinfos', '0', 2, '', '', '', 1, '1234', '1234', '1', 1, 2, '', 'Nigeria', 'Virgin Islands', 'Enugu', '467281', 'Web Developer', 'I am a web devloper'),
(2, 'Michael Erastus', 'meritinfosweb@gmail.com', '$2y$10$Y2XlqJPKBQWfLWHtQqNEeuNJycmvBLf3lo.FrppRHOAVtUggWswlm', 'meritinfos1', '1000', 1, '', '', '', 1, '123456', '23456', '1', 1, 2, 'f32dd36a5c17a0f95938170a9ae6b5f485521e0f', '', '', '', '', 'Organizer', '');

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `MethodId` int(11) NOT NULL,
  `MethodName` varchar(100) NOT NULL,
  `Merchant_id` varchar(150) NOT NULL,
  `Private_key` text NOT NULL,
  `Public_key` text NOT NULL,
  `Web_Hook` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `paymentmethod`
--

INSERT INTO `paymentmethod` (`MethodId`, `MethodName`, `Merchant_id`, `Private_key`, `Public_key`, `Web_Hook`, `Status`) VALUES
(1, 'Paystack', '', '', '', '', 1),
(2, 'Flutterwave', '', '', '', '', 1),
(3, 'Account Balance', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `Payment_id` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `Amount_paid` varchar(100) NOT NULL,
  `Payment_method` int(11) NOT NULL,
  `Payment_Ref` varchar(150) NOT NULL,
  `Transaction_id` varchar(150) NOT NULL,
  `Payment_Status` int(11) NOT NULL,
  `Coupon` int(11) NOT NULL,
  `Amount_off` varchar(100) NOT NULL,
  `Date_payment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`Payment_id`, `OrganizerId`, `Amount_paid`, `Payment_method`, `Payment_Ref`, `Transaction_id`, `Payment_Status`, `Coupon`, `Amount_off`, `Date_payment`) VALUES
(2, 2, '2000', 2, '1201778127', 'DSR-1586219239', 1, 0, '', '1586219240'),
(3, 2, '1000', 3, '5579384743', 'DSR-1586268488', 1, 0, '', '1586268488');

-- --------------------------------------------------------

--
-- Table structure for table `pin_usage`
--

CREATE TABLE `pin_usage` (
  `Usage_id` int(11) NOT NULL,
  `Pin_id` int(11) NOT NULL,
  `Session` int(11) NOT NULL,
  `Term` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `Student` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pin_usage`
--

INSERT INTO `pin_usage` (`Usage_id`, `Pin_id`, `Session`, `Term`, `Class`, `Student`, `School_id`) VALUES
(1, 201, 1, 4, 13, 1, 4),
(2, 201, 1, 4, 13, 1, 4),
(3, 201, 1, 4, 13, 1, 4),
(4, 201, 1, 4, 13, 1, 4),
(5, 202, 1, 4, 13, 1, 4),
(6, 202, 1, 4, 13, 1, 4),
(7, 202, 1, 4, 13, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `Position_id` int(11) NOT NULL,
  `Result_type` int(11) NOT NULL,
  `Student` int(11) NOT NULL,
  `Position` text NOT NULL,
  `Teacher_comment` mediumtext NOT NULL,
  `Headteacher_comment` mediumtext NOT NULL,
  `Principal_comment` mediumtext NOT NULL,
  `Session` int(11) NOT NULL,
  `Term` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`Position_id`, `Result_type`, `Student`, `Position`, `Teacher_comment`, `Headteacher_comment`, `Principal_comment`, `Session`, `Term`, `Class`, `OrganizerId`, `School_id`) VALUES
(1, 6, 1, '1st', 'Excellent Performance', '', '', 1, 4, 13, 1, 4),
(2, 6, 2, '2nd', 'Excellent', '', '', 1, 4, 13, 1, 4),
(3, 6, 1, '1st', 'Excellent', '', '', 1, 5, 13, 1, 4),
(4, 6, 1, '2nd', 'Excellent', 'Excellent', 'Good work', 1, 6, 13, 1, 4),
(5, 5, 1, '1st', 'Excellent', 'Excellent Work', 'Nice Work', 1, 6, 13, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `pricing_table`
--

CREATE TABLE `pricing_table` (
  `Package_id` int(11) NOT NULL,
  `PackageName` varchar(200) NOT NULL,
  `Description` text NOT NULL,
  `Amount` varchar(150) NOT NULL,
  `New_price` varchar(100) NOT NULL,
  `Old_price` varchar(150) NOT NULL,
  `Number_of_schools` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL,
  `Recommended` int(11) NOT NULL,
  `Recommend_text` varchar(150) NOT NULL,
  `Features` longtext NOT NULL,
  `Is_free` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pricing_table`
--

INSERT INTO `pricing_table` (`Package_id`, `PackageName`, `Description`, `Amount`, `New_price`, `Old_price`, `Number_of_schools`, `Status`, `Recommended`, `Recommend_text`, `Features`, `Is_free`) VALUES
(1, 'Free', 'This package helps you run your result management at a zero cost.', '0', '0', '100', '1', 1, 2, '', '                                                 <p>Unlimited Results</p>                                                 <p class=\"not-available\">Result Pins</p>                                                 <p class=\"not-available\">Students CheckResult with Pin</p>', 1),
(2, 'Premium', 'This package gives you an extended feature such as earning through the sales of resultpin.', '100/pin', '100', '250', '4', 1, 1, 'Popular', '<p>Unlimited Results</p>\r\n                                                <p>Result Pins</p>\r\n                                                <p>Students CheckResult with Pin</p>', 2),
(3, 'Ultimate', 'This is the ultimate package which helps you add more schools. With this package you can earn more.', '200/pin', '200', '400', '10', 1, 2, '', '<p>Unlimited Results</p>\r\n\r\n<p>Result Pins</p>\r\n\r\n<p>Students CheckResult with Pin</p>', 2),
(4, 'Professional', 'For Developers and schools with multiple school to handle and needs a quick solution.', '300/pin', '300', '600', '15', 1, 1, 'Master', '<p>Unlimited Results</p><p><span xss=removed>Result Pins</span></p>\r\n\r\n<p>Students CheckResult with Pin</p>', 2);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `Result_id` int(11) NOT NULL,
  `Session` int(11) NOT NULL,
  `Semester` int(11) NOT NULL,
  `Student` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `Subject` int(11) NOT NULL,
  `Exam_score` varchar(100) NOT NULL,
  `Test_score` varchar(100) NOT NULL,
  `Total_score` varchar(100) NOT NULL,
  `Grade` varchar(20) NOT NULL,
  `Status` int(11) NOT NULL,
  `Grade_id` int(11) NOT NULL,
  `Gradepoint` varchar(20) NOT NULL,
  `Unit_load` varchar(50) NOT NULL,
  `Unit_point` varchar(50) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`Result_id`, `Session`, `Semester`, `Student`, `Class`, `Subject`, `Exam_score`, `Test_score`, `Total_score`, `Grade`, `Status`, `Grade_id`, `Gradepoint`, `Unit_load`, `Unit_point`, `OrganizerId`, `School_id`) VALUES
(1, 1, 4, 1, 13, 1, '40', '30', '70', 'A', 1, 13, '5', '3', '9', 1, 4),
(2, 1, 4, 1, 13, 2, '50.55', '20.55', '71.1', 'A', 1, 13, '5', '2', '10', 1, 4),
(3, 1, 4, 1, 13, 3, '50', '12', '62', 'B', 1, 14, '4', '2', '8', 1, 4),
(5, 1, 5, 1, 13, 1, '50', '12', '62', 'B', 1, 14, '4', '3', '12', 1, 4),
(6, 1, 5, 1, 13, 2, '50', '12', '62', 'B', 1, 14, '4', '2', '8', 1, 4),
(7, 1, 5, 1, 13, 3, '40', '20', '60', 'B', 1, 14, '4', '2', '8', 1, 4),
(8, 1, 4, 2, 13, 1, '50.55', '20.55', '71.1', 'A', 1, 13, '5', '3', '15', 1, 4),
(9, 1, 4, 2, 13, 2, '50', '12', '62', 'B', 1, 14, '4', '2', '8', 1, 4),
(10, 1, 4, 2, 13, 3, '40', '20.55', '60.55', 'B', 1, 14, '4', '2', '8', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `result_pins`
--

CREATE TABLE `result_pins` (
  `Pin_id` int(11) NOT NULL,
  `Pin_number` varchar(150) NOT NULL,
  `Serial_number` varchar(150) NOT NULL,
  `Status` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `result_pins`
--

INSERT INTO `result_pins` (`Pin_id`, `Pin_number`, `Serial_number`, `Status`, `OrganizerId`, `School_id`) VALUES
(201, 'MP25JARZCYI69LS', 'W8JCM3U4PSRA6EIV1GXF', 1, 1, 4),
(202, 'K4HTEUCG3MFAIOB', 'YKDBCES6IW50J2GNZ91O', 1, 1, 4),
(203, '6IFBVH9X17JELD8', '1NV8AUBJLXZKHI96DGC5', 1, 1, 4),
(204, 'FIY058P7BMX2KO6', 'F0TMP26IXVYR435GW7JL', 1, 1, 4),
(205, 'NBYTX7Q0FUPMK6I', 'U3FOBRD7MZ1KTJE5Q9AL', 1, 1, 4),
(206, '6PW45UZBO7ARYJC', '2M9TGSYUOCN7HBFZ8DJE', 1, 1, 4),
(207, '8HEDW5K26LYN3ST', '4F3CL2TSQWGXPEJO1I7V', 1, 1, 4),
(208, '2DJGPTU8RN970VQ', 'JNL3I7PT2D4EOZKUV0XG', 1, 1, 4),
(209, '9VPT1M5ZSL7YDQ3', '3T42H9IEDZM8X6JP5B01', 1, 1, 4),
(210, 'U7YR6DX28BTQK0P', 'U9YTOK6S2JA4W5QHMRXB', 1, 1, 4),
(211, 'I3W5C67PDYGB1QH', 'Q19VUOSTLWDH3BEAKGC2', 1, 1, 4),
(212, '4I0VBWZOHFCPMJE', 'B0H3JEQXTDCLPSF7R4UW', 1, 1, 4),
(213, 'IV2QRP1OGWZ6F0S', 'OQRDYTWFMZ2BAX3NHSK7', 1, 1, 4),
(214, 'W6V5BCORYQGKLAT', 'FUO31BN68LXWYI5HC90Z', 1, 1, 4),
(215, '3C4IZEJVKLYUBRT', 'LT0JSBYIN163UVW9FDC2', 1, 1, 4),
(216, '9ZOIDG67QE2YPB5', '034MQ7BRD1CXJLKFS5P9', 1, 1, 4),
(217, 'ATPFBNVIWH95EKD', '4MC2LKZOGTDV3690EIP7', 1, 1, 4),
(218, 'Z9JHVN6GCPD0521', '56ZYMGPEFHJBUK8CI9NV', 1, 1, 4),
(219, '75F6JNKQ3PSHDCI', '307KJG68OH42VLRTEYDS', 1, 1, 4),
(220, '1IHROJBCZ6QE02L', '2Z0UFWQ6GY3EAK7CXPDR', 1, 1, 4),
(221, 'NL98RI0QS14DAMW', 'W6OAYQTLJ2DR9CV5FP47', 1, 1, 4),
(222, 'XOGSDT0HI9231YA', '6059RNYG7BHX3QKFTOM8', 1, 1, 4),
(223, '9DS31YLT84PXZAJ', 'BQMKIFP7R6TLVOUZ8409', 1, 1, 4),
(224, 'RQYNT4MHDO6B57P', 'C8WOU9N6BKSFZE0HMVAP', 1, 1, 4),
(225, 'HMU2GC19KIE0SPJ', 'HXLU12OKZ7EIN93GQ4FC', 1, 1, 4),
(226, 'ZIAEJ60V5KXSWD4', 'B2U6SNY9EA5VOF34GK7X', 1, 1, 4),
(227, 'WZ2RMN9ILQ31YPA', 'D671JKIXOF3SHAQN2UG5', 1, 1, 4),
(228, '7CAF36KMBYPLQTO', 'A18DCWB2RV0TXMZOH5S4', 1, 1, 4),
(229, 'SZ4BFW5683RDV2I', '3NZO0F8AGVBXJDQ9U4M7', 1, 1, 4),
(230, 'JXILO80K4FM95BT', '4A0EQT9BHZ8R7S3IFNVY', 1, 1, 4),
(231, 'DN83FXKS2I7G1LR', 'RBW4TH2DUMAECFK7S0Y5', 1, 1, 4),
(232, '37JX6E0OV19AIMH', 'E0IZPNCOJAD458M7LXRH', 1, 1, 4),
(233, 'U3FNCM0ZWLHS6P4', '0WX7S4TAV36UYIOFZN1P', 1, 1, 4),
(234, '8Z0FJELOKNDRX45', '4IS6BTCJKROF2DU8M7N1', 1, 1, 4),
(235, 'B0RESCNOUAG1I2F', 'F9I8K7DWGCYX0A5MLRNB', 1, 1, 4),
(236, 'HW8CU0K51TR67V4', '34TUMNAHJD0Q8REW792K', 1, 1, 4),
(237, '2B0XM5H96FOQUZE', '2OGF50CSB8ZRQH7XP3KL', 1, 1, 4),
(238, 'O2HY1D09QE4VSNL', 'N23VOMYX1BIFJ8PGZAH0', 1, 1, 4),
(239, '9RC1FWE5LQB0VNU', 'KX4TOBJUZERC293GMI0W', 1, 1, 4),
(240, 'O0ZSRMIL4T17KH2', 'M5AHN67ZR8EUD2J0FTKP', 1, 1, 4),
(241, 'B64IF9O0SK85AMW', 'RUB18KGP465JLFCQ9MIO', 1, 1, 4),
(242, 'WO0KMLQDZB24EFR', 'M0XK38J2FC4BOVIG7RT6', 1, 1, 4),
(243, 'KU1T4H6E2ZG9587', 'SGC2AJP9DFZYIVQR4L86', 1, 1, 4),
(244, '2EFTIKYP3ZCD9JA', 'M0A2H7LIEXY8JT6KB4RQ', 1, 1, 4),
(245, 'O6TYWNZX3Q9FCAK', '3QC28UOJM7NWDX1T6SR5', 1, 1, 4),
(246, 'I594WQOE6SCUVMB', 'WCK85BTJOLMHGRP67ZVU', 1, 1, 4),
(247, 'B9V8X5NHK3EQ2MD', 'F5U8031WTHDI9GEP7NMR', 1, 1, 4),
(248, 'EC2LJVMGHDON9UR', 'UF1HPSKOZQBL7A0WV4M2', 1, 1, 4),
(249, 'KRNBXGMU7ACJD89', 'VN3X7O02Q6E9YGULZ1W4', 1, 1, 4),
(250, 'RQ83H2JAENCWMBP', '37W6YFUXACJRN9V1S25Q', 1, 1, 4),
(251, '7V3XMUQ049ZK2IG', 'B5XJOI28D9C67TFZU0GA', 1, 1, 4),
(252, 'A7MBGC1IRKT2XFO', '9F18QMOHCL26AVBGSJI7', 1, 1, 4),
(253, 'HX145VNIDM8AQ0Z', 'AU8XNB2YV45S1HC0M6E3', 1, 1, 4),
(254, 'C2WIDJ7ARSXOVQ0', 'O4QVERCD8HNZW37P9T0A', 1, 1, 4),
(255, 'UWVSPG5MLR9K867', 'LDME0NH5VJC9K23ZIQ78', 1, 1, 4),
(256, '9YIEAKSWQ0N8B2X', '47ET8BILSQH5JP0MRGZ6', 1, 1, 4),
(257, 'JKZLI97H2Y03PWN', '87WKRH2EQS05FIBJDP96', 1, 1, 4),
(258, 'OWNLQ9YR6P3BUJZ', 'FS2CG9MEDRWPUTNX48IA', 1, 1, 4),
(259, 'UPEYJK42O7VRBLQ', 'CZJ3GO8SE6AXTKLHD574', 1, 1, 4),
(260, 'V5B0K4X81TJAHNQ', 'VQCJFYPTDG2LA8E6IZ7O', 1, 1, 4),
(261, '52OE3IBTYHDP0VQ', 'YKRFW3QU1IBP45H27MS0', 1, 1, 4),
(262, 'Q5ZY3GJV8MFELU4', 'GTUWQKJLFDIMS4EA5Y61', 1, 1, 4),
(263, '67ORB2ZECFTI1AW', '0OUGQKEZ94SIYPXBHN3M', 1, 1, 4),
(264, 'CFWP6198NUH0OMI', 'C392I6JEKYN7FSDZ40GU', 1, 1, 4),
(265, 'DJ87RMO1GU539PI', 'KYTHQ945IOWRXDUMNP28', 1, 1, 4),
(266, 'E0FB1IRW6N5Z3P8', '5WQ2R6VOBCTS73AIKL89', 1, 1, 4),
(267, 'VAK9C05R3QW17ZG', 'CRNHFZTWP63IJ1854E07', 1, 1, 4),
(268, 'BP3XE2705NDK4QF', 'MUEYHDR8OA7VSKPGJQ3F', 1, 1, 4),
(269, 'YH9Z1E6BMC25NIT', 'TU2XJQCKOD3FVE8IP6BL', 1, 1, 4),
(270, 'KHQAOT2NX9RW8U7', 'OSCPYW7Z0D1F8EJ5QGAK', 1, 1, 4),
(271, 'F04MA2XLD3IG7CK', 'OWM3CLFU0ZAYJ6N7GISK', 1, 1, 4),
(272, 'GUN3BMSJ25DYFX7', 'K3C4G06X1FHSDO8ZLTAI', 1, 1, 4),
(273, '0BPHOL4D832XKQR', 'IYRSD5XN8JE91GF0WOQA', 1, 1, 4),
(274, 'EFOCGZY8D9LMRHJ', 'ZOJTELVMKNS02QX571FW', 1, 1, 4),
(275, 'H9TOIK780SJ1RML', 'L1U32GFZSCTJ7N8PBVEO', 1, 1, 4),
(276, 'PCABHL0XY957RDE', 'G2P8NKBAIQT37SDHVU5L', 1, 1, 4),
(277, '0QW5IZG3SKLVCDA', 'TIP2N0CFS61AZJ8XEMGO', 1, 1, 4),
(278, '9XQPCTH5EO0UFNA', '297JNV350DFWRBQCPUAM', 1, 1, 4),
(279, 'IGDRUYFZV7LQCB9', '1KLM5OSUJTFGZ3AI8W2H', 1, 1, 4),
(280, 'KPWX67EG0291SCY', 'EVDWLHJATR7GX8N10CPO', 1, 1, 4),
(281, 'HR4OB35AYS1WTIC', 'CQLV1TES7JHI23Y0BWNO', 1, 1, 4),
(282, 'GRL81ZHYMV35PDI', '1FS8W6NK94CMZVGE7RIJ', 1, 1, 4),
(283, 'FD36K2I490L7BJM', 'I9NY60QWUDF5MJ3PKZAT', 1, 1, 4),
(284, 'EJ7Y10WB5C3LX8T', '761NORJFYVUBGS9C4LE0', 1, 1, 4),
(285, '1C70P9JAYM6SUQ2', 'K4FXSMORWGHL0793ZYE8', 1, 1, 4),
(286, 'FBV0JHGAEL21SXD', 'O9JAZH4RPBVSFK6TNW71', 1, 1, 4),
(287, '6QZJU8RAVNLD491', 'GB0X2S18AEMTZHQDN9LI', 1, 1, 4),
(288, 'Q2ZI7LVXJMCBA5U', 'U6K1NG4M5ZCH2DJF8TI7', 1, 1, 4),
(289, 'I6YMPV7OS1RBNKE', '9X46CVRP1O3JTYAHUNDB', 1, 1, 4),
(290, '90R1DVN7IMASG6P', '4E3KBCP1Y7QJ8OMTIW0U', 1, 1, 4),
(291, '8MFEAVHBJPW9UKO', 'JSPI3MHE9O0KVGTZFQXN', 1, 1, 4),
(292, 'X6R2WG4OQBT9YFK', '8EFBXYC56JZK9LTGWPAU', 1, 1, 4),
(293, '7WJT3I0E9NKMV85', 'A9VLSEO28FD67NCQXP5Y', 1, 1, 4),
(294, '35ZWMDNTC7R4HFY', 'POWBDUM0HFQGVN4L562K', 1, 1, 4),
(295, 'TVRX0SIHYF5B8JM', 'YIPDGT64VA0BKMJ7N189', 1, 1, 4),
(296, 'XVLEBRM4YF07GH2', '9EPMWZC6SU0LFYVTXOQ3', 1, 1, 4),
(297, 'VG6QW2PRAFTIOSB', 'G92HTXPRB8I6O4K75QLA', 1, 1, 4),
(298, 'G3XEBCKSR10QI8Y', 'Z5E4FWRN2UD7K0AMOCHY', 1, 1, 4),
(299, 'GAUPYIX8W5T6VHZ', 'BQAU5MVK16RIXGTPJ0ND', 1, 1, 4),
(300, 'W30GISKB4JRCM28', 'SABI3J6RKNC5OU87W4Z2', 1, 1, 4),
(301, 'U3DI9PG6CB', 'XJ2EPBV0MTLFSA8', 1, 1, 5),
(302, 'H8A1PTC3N4', 'FBG6J84L1KIOTDH', 1, 1, 5),
(303, '08AQGH6V1Z', 'HJGTD42ZAF8V1RQ', 1, 1, 5),
(304, '6XTMW2A14S', 'TB6U92NVL05IDGC', 1, 1, 5),
(305, 'F7UXVHJCSZ', '0YJGO72XRCS8ABE', 1, 1, 5),
(306, 'PGTA0NR8Y9', 'F431Z96LYUT7VRX', 1, 1, 5),
(307, 'Q0W1J7RS8B', 'KVYRO67IJEUC0S5', 1, 1, 5),
(308, 'MA3GU0CNOB', 'M7V104XR9GOWJTU', 1, 1, 5),
(309, '8L93XSEC1K', 'F2L69703HGNWK5T', 1, 1, 5),
(310, 'MI6DJCB0FE', '3JFN4WBPLZ1RUD6', 1, 1, 5),
(311, 'R7VDOXQLCE', 'RZ162NVD9TBOCFQ', 1, 1, 5),
(312, 'NFEC0K1HRZ', '7IG04QBHDAW3U5M', 1, 1, 5),
(313, 'M0UZYONT4P', 'QWXF64UO97C518N', 1, 1, 5),
(314, 'ENVO6MZXY8', 'MPFG8Q97AX4YU2Z', 1, 1, 5),
(315, '8HEBCKQGS7', 'MHFVU6YR8BJXP7Q', 1, 1, 5),
(316, '860VK4GFSH', 'X4T2VGJ0NA3QZ9Y', 1, 1, 5),
(317, '59OWS7FCK8', 'O96ISHPMG130RKF', 1, 1, 5),
(318, 'GUR1A6CTM5', 'ZJ9OLS532BIA8VF', 1, 1, 5),
(319, 'DYSK0Z41U5', 'F5ST2JQHO9E47LW', 1, 1, 5),
(320, 'GXM2TVKJWB', '8OYL96AU3XR5P14', 1, 1, 5),
(321, 'V54DFR8MIC', 'C92YLBKPI5S7VXN', 1, 1, 5),
(322, 'D9CEK5QIWB', 'O7QCRZ8MEBJLY4H', 1, 1, 5),
(323, 'POFRJ4LQ1E', '3TRO876YSIEFBKX', 1, 1, 5),
(324, 'U6VT359IEK', '75VM8U2XAEN9PKZ', 1, 1, 5),
(325, 'C0IZK41G9P', 'OJ6FI81WGQ73KCE', 1, 1, 5),
(326, 'GBLCU9FNVY', 'RNWPS6710I5K2HG', 1, 1, 5),
(327, 'HUQN5APLCT', 'Y79DSTFH2XMIZ3J', 1, 1, 5),
(328, 'BN5LSCH0T7', '9WMJDNOV65TA04I', 1, 1, 5),
(329, '70RUQ8Y261', 'QGS8DTRCUWYVAX7', 1, 1, 5),
(330, 'FC8XWTN0U2', 'LIS19AJ73KBXW6V', 1, 1, 5),
(331, 'ESZ9CIGB1K', 'IF8Q3WKS5OVYPZX', 1, 1, 5),
(332, 'W1RUKM9GZQ', '1ACSPL95H4DFMWG', 1, 1, 5),
(333, 'WKEY1Z756X', '8H3QZ0OJ4I1AL9M', 1, 1, 5),
(334, 'ZOL5E42FVS', 'LXK90VPOSBFTI8C', 1, 1, 5),
(335, 'AR4UYTZ73B', 'HLUQ0J3WT1VF5BK', 1, 1, 5),
(336, 'J38EA0CHPT', 'SY1C47PXT39WBU2', 1, 1, 5),
(337, 'X82V3ESCLW', 'UAXBCOLV8EJ4T3W', 1, 1, 5),
(338, '97FM6I3JTA', '5RI9STVUM3P4O7W', 1, 1, 5),
(339, 'QA6TESYDKC', 'HG26Q3IECT5KMNB', 1, 1, 5),
(340, 'LKPTESQ06B', '7XTJ0GPVOLQ6SHE', 1, 1, 5),
(341, '2TBUGE8SKN', 'XAQ0TYFZNO6RSPJ', 1, 1, 5),
(342, 'IPZ1FT4UCJ', 'YJMTR9UHWG2VZ6F', 1, 1, 5),
(343, '30X9JBNUHR', 'CAWXVS2T5IRNMFP', 1, 1, 5),
(344, '86KYL7FGNV', 'F2L6KJQ3HNTIAY1', 1, 1, 5),
(345, '5WQK8E4H7D', '463FOAYQSGXDTWJ', 1, 1, 5),
(346, 'YHMTD9AS8Z', 'IR3U72P5ZMXK4W9', 1, 1, 5),
(347, '57PVXUJMRK', 'NARLE72CZOGPYFW', 1, 1, 5),
(348, 'Z17IU0WRQD', 'HYIL6DF1S473GQZ', 1, 1, 5),
(349, 'UI2SPMFLJG', 'D0Z58JL4UPFR1V9', 1, 1, 5),
(350, 'NB5HSR2D69', 'NOQVPT2JIU1BHW0', 1, 1, 5),
(351, 'KCRT4GDNIL', '49FZC0U5LEQ67WH', 1, 1, 5),
(352, 'QLKRIVW9HX', '23LHZC48N7JFDX5', 1, 1, 5),
(353, 'J6ULPD3M95', 'KEWI2DXJAGL0ZY4', 1, 1, 5),
(354, 'IY41ET3WGZ', '6OTN1843MIEKFZ5', 1, 1, 5),
(355, 'KQFS7UZLBN', '3F4DUWZHN89BEJ7', 1, 1, 5),
(356, '1U4YTQFDRI', 'NAOI0J74ZQCXKME', 1, 1, 5),
(357, 'DYBN8C5K4E', '3928QONDZXUS7RJ', 1, 1, 5),
(358, 'K2GAO6XRIT', '6YB98QOEP5SRZ0L', 1, 1, 5),
(359, '2DOAR9PZGS', '3O8C69XAV4S0EQU', 1, 1, 5),
(360, 'Q4O2PK6193', '0QX1TIKZ7FURJBO', 1, 1, 5),
(361, 'C2UETAKVJZ', 'OX8CBHLUDQT635F', 1, 1, 5),
(362, 'PC0BXLIDO1', '06FMO7IWD3GT89Q', 1, 1, 5),
(363, 'EL0MND2F8H', 'G8SZ9350UI4TJHE', 1, 1, 5),
(364, 'XYNJKAG7PD', '6SETM195VNG4ZI7', 1, 1, 5),
(365, 'PBUEXO90MF', 'QJ35E9086SKWFRY', 1, 1, 5),
(366, 'KB08FNTV3G', '17692R4C05YIEO8', 1, 1, 5),
(367, 'D26TURHQEV', 'HBY6FL18QAT5GRZ', 1, 1, 5),
(368, 'SL89JZP604', 'VZFUX9B60C7R14D', 1, 1, 5),
(369, 'Y29O78ECXP', 'A9WYMRUJEIQN0PO', 1, 1, 5),
(370, 'PE9ILNCQXO', 'ARFKPJ2QVSI6G8W', 1, 1, 5),
(371, 'PF4ZS5CD7T', 'X1NAGZ4BPW6T5ML', 1, 1, 5),
(372, 'FDYBK71PJ4', 'RLF5NXM3OJBT8I6', 1, 1, 5),
(373, '4HL9OJ5ZEX', '4J5WQNIVBZFG68A', 1, 1, 5),
(374, 'BQUELSIXD2', 'R75VD8BZUC9FA61', 1, 1, 5),
(375, '0OMC34EHJF', '7YMOESD3G8LJPRW', 1, 1, 5),
(376, 'EOIVJTXGCQ', 'JC9SEB2Y8LKVUH3', 1, 1, 5),
(377, 'KFYNCJ2G5P', 'WHTEB6U58OJP1IL', 1, 1, 5),
(378, 'MD15O3CSWV', '51RMYDWVSHFBPT6', 1, 1, 5),
(379, '17SJH6WV5A', 'DKOB3FJC07MYP8Z', 1, 1, 5),
(380, '147IGD98YA', 'XSAUMZ8V506NIO9', 1, 1, 5),
(381, '0X73DWPNV6', 'JOQ8P1M09LB6NAS', 1, 1, 5),
(382, 'I0W5SHND9X', 'LPXZ9AI3B81CF2Q', 1, 1, 5),
(383, 'EP0WTI8K2B', 'DSLU5ZRNYMXH1BF', 1, 1, 5),
(384, 'CUS683KPLF', '8VG1YSH2RQIZXBD', 1, 1, 5),
(385, '4VSNUYH3FK', '92E8U540YCLZWF1', 1, 1, 5),
(386, 'AX23ESDBIN', 'IL5W3QVNZOMBXEK', 1, 1, 5),
(387, 'EAP461TU93', 'ZADKS3W54E86OX1', 1, 1, 5),
(388, 'XTP954AZ36', 'Q9KVT4MIYUR2P73', 1, 1, 5),
(389, 'RFLDE2A6OY', 'WNTO3JG0Z27RFP5', 1, 1, 5),
(390, 'N4V7IRSJY0', '4IKUL5Y6Q27VPBA', 1, 1, 5),
(391, 'QHKUJRN32W', 'QNFSIUHDTAP7GC2', 1, 1, 5),
(392, 'J1E5S30GXP', 'CP960HVLAN413BQ', 1, 1, 5),
(393, 'GSVKWXM9JI', 'YZ8XAOGU5B6RMKT', 1, 1, 5),
(394, 'ABZUID8J0Q', 'A6QB2SI37UMX4LO', 1, 1, 5),
(395, 'RXV8ME9OTC', '0CQZ85XKURV71SE', 1, 1, 5),
(396, 'ZG9IBUPA58', '904RVBH8EQ6J2FI', 1, 1, 5),
(397, 'TH9GU407FV', 'E6N4M7YPBGTUH2F', 1, 1, 5),
(398, 'EXBF20ISAT', 'UIAGT324HYZON5P', 1, 1, 5),
(399, '0SHXVF3BYL', 'ZJ4SUIPDA8LBG3X', 1, 1, 5),
(400, '3BG5UDZFOA', '1FRQ892B0DMVKI3', 1, 1, 5),
(401, '3ONAQBFKR6', 'IBJT9E7CVGRZ480', 1, 1, 5),
(402, 'IH80QXYLCZ', 'F2QR40GBNJ5YL3O', 1, 1, 5),
(403, 'ZIYEF02H8O', 'U9TIVMFG4HSPNDX', 1, 1, 5),
(404, 'R7TVYBQW01', 'JDRGVPO6Q39KNMX', 1, 1, 5),
(405, 'PI2RYAFDHK', 'NTUV3GEXQKSID65', 1, 1, 5),
(406, 'G57ZAOW0CM', 'M8E7HROYNUA2D0P', 1, 1, 5),
(407, '6AXTBU9YDE', 'Q1GMXZ0WF3N2RY9', 1, 1, 5),
(408, 'Q81WD2P6KB', 'G90FHS7J3T426MY', 1, 1, 5),
(409, 'I6LMR43USV', 'NU2R1YO8K5EHAD6', 1, 1, 5),
(410, '2ID8SC3GUW', 'HGRPWS7YB126X0J', 1, 1, 5),
(411, '6PZIYX09U4', 'JESI527NVW486U0', 1, 1, 5),
(412, '7NC8D1BVYH', 'CXT7WR4FS1MV0ZE', 1, 1, 5),
(413, 'VHAPKE23GX', 'RZSNKUCX7VGLTQ4', 1, 1, 5),
(414, 'LGUE4MBZQ2', '9Z8RDAYTSWF617M', 1, 1, 5),
(415, '68LAY0ECMS', 'G0PYKIOS2WBRQZ7', 1, 1, 5),
(416, '19IG6LES7R', 'MOPSZE2BFCU0T6D', 1, 1, 5),
(417, 'Y0TUDZKF47', 'ZYVODECXA98NIUH', 1, 1, 5),
(418, '170J5M6WT4', 'LIY0M9ZE6V3WFBQ', 1, 1, 5),
(419, '52MUVGZ1BS', '0I7EATBCQ9NOVS3', 1, 1, 5),
(420, 'HW81CIFMQ0', 'OT41DGRML89C7QY', 1, 1, 5),
(421, 'OS1TENHZM4', '3QP4B186RV9ALGK', 1, 1, 5),
(422, 'ATOP2F6Z9C', 'T3HV0RFZPG67U1E', 1, 1, 5),
(423, 'P8UHFRYOW3', 'Q5JSI02OKWB8REV', 1, 1, 5),
(424, '3O4SB2HGKA', 'USQD8IF2XVL01GM', 1, 1, 5),
(425, 'AV4XLB6DTS', 'PRW4UCK7ANQLVED', 1, 1, 5),
(426, 'YVDWHULGOJ', 'OPHUJ09DTMG16K5', 1, 1, 5),
(427, '76ACHXSLVT', 'CIOR0JHFVUW8Z4P', 1, 1, 5),
(428, '75AJEK2TR6', 'D8FEHWQRN4P6JY3', 1, 1, 5),
(429, 'SZH5B9EFYA', 'I37XVOCTYKQU2RL', 1, 1, 5),
(430, 'GFXR1BYWQT', 'HYLUN0K3O194IQ6', 1, 1, 5),
(431, 'K8FW6RGNU2', '3Z5NHPFCMD6A2Y7', 1, 1, 5),
(432, 'CDYU128WTJ', 'X20TS7MLVCQZW8K', 1, 1, 5),
(433, 'PDYRBAOLNS', '1YACPTSGR43XNF0', 1, 1, 5),
(434, '1CBZXJV4T3', 'A9H1O2VBU8TEDSJ', 1, 1, 5),
(435, 'KGVWFTH25Z', '5RFZVYUP36TONBQ', 1, 1, 5),
(436, 'QYU1PBHJW3', 'AN8BHUJYM03IEOR', 1, 1, 5),
(437, '1IG3DE96CA', '8EJI31DSV2WQ0Z9', 1, 1, 5),
(438, 'RVW480UA5Z', 'YXZ41FQTO36IEWA', 1, 1, 5),
(439, 'H6KNBUCWP9', 'WMCZ67TKN2YDPSU', 1, 1, 5),
(440, 'AIYKC0ZF2T', 'YRJLQDTS256914O', 1, 1, 5),
(441, 'LSUMVDKY6N', '2TZPCEQ1D5XY0AL', 1, 1, 5),
(442, '3P4RBCMS06', '82O1AJUFKT5GRMZ', 1, 1, 5),
(443, '4Y5UJKZMOS', 'D7SCMQTU2WAG3NP', 1, 1, 5),
(444, 'RVKWTOMZ41', 'ZU3MSVB7NR9IA5C', 1, 1, 5),
(445, 'Y2MJ0QXRSU', 'AB1QVLM2YKP04SU', 1, 1, 5),
(446, '5KR2S8LF0O', '41N7FW5UOQHI3ZC', 1, 1, 5),
(447, '1FD42MY7UC', '6BCT5KF0R31JY9X', 1, 1, 5),
(448, 'DBI5LK7C1J', 'O4FT05AUXQRH38K', 1, 1, 5),
(449, 'QRNU745TOD', 'DB7PHX9E58I4NRV', 1, 1, 5),
(450, 'LS6DHY3TUC', 'CD0TQBG27KAJ8M3', 1, 1, 5),
(451, '5DHLAT4MOE', '1YE3A5DGPTS4ZVL', 1, 1, 5),
(452, '5H83G41BCX', 'B4CUVHF7LEDRM1P', 1, 1, 5),
(453, 'HWYCP0Z2O5', 'I3ASHMO0WVK8L4N', 1, 1, 5),
(454, 'BTU4O8YQ10', 'M2B65S4XL1ATJFC', 1, 1, 5),
(455, 'EVD2GLFS4I', '4FYJC5XVRQ9PMGO', 1, 1, 5),
(456, 'RBI3Z57DNP', '0FTRCKMAVQY56PX', 1, 1, 5),
(457, 'DNRCHUP980', 'IQCB8XH1GPRF9VZ', 1, 1, 5),
(458, 'NWJDQ57LG0', 'U5T0S1HMGAKFJPW', 1, 1, 5),
(459, 'T0DLO6AYGV', 'YFD7NPRG0O8J9BM', 1, 1, 5),
(460, 'AZVEIDBTQJ', 'WS9K06RFULJHM4C', 1, 1, 5),
(461, 'RY7JEN20DZ', 'PMFUD9BJH1WCN83', 1, 1, 5),
(462, '701PU3ESNC', '1PQNG0ZHUCI7V3R', 1, 1, 5),
(463, 'H5YD8NZXG2', 'OH6X1RVFQC0GNYA', 1, 1, 5),
(464, 'Z8J0O1BMLG', '8BSOK2I0WGNPX64', 1, 1, 5),
(465, 'C1E7A9ZKRP', 'V6SM9GAPJTO17Z8', 1, 1, 5),
(466, 'TWMIENL69A', 'N4HKL2FQ8Z93PCV', 1, 1, 5),
(467, 'D841OW25QI', 'XGWMAELVKTBH9OJ', 1, 1, 5),
(468, 'IQ3RMZLWG9', '1S5NF89Z2TQKBYV', 1, 1, 5),
(469, 'H3GWC7ANYP', 'P8WQCNUEX2IKG9M', 1, 1, 5),
(470, 'V4J31RL2YS', '93NJOX6EYADCK7P', 1, 1, 5),
(471, '7K9DWG0MAN', 'P60IN8LQDGXFJCT', 1, 1, 5),
(472, 'JCHSM0RB18', 'N2K974YR5LXBPZS', 1, 1, 5),
(473, 'GLWBKI7RFQ', 'QHIJ8BODNC529FS', 1, 1, 5),
(474, 'Z6D7201ML8', 'RJP4BTIDKE3SV6F', 1, 1, 5),
(475, 'Q5AP83OC10', 'QJWDUG3Y1OXZ7P0', 1, 1, 5),
(476, '9MIRZF5KL1', 'U30HOQBMJ7E6P12', 1, 1, 5),
(477, '1BEUW5YPCZ', 'Y0ACHILNGWXJ9QE', 1, 1, 5),
(478, 'S0FCBWEN75', 'AO7V5NPZ9JG1EXU', 1, 1, 5),
(479, 'MDV8FGISPH', '2K3N9Q81UTY4FOR', 1, 1, 5),
(480, 'LY7RCZU5XD', 'KANCY4EQLX3JP2U', 1, 1, 5),
(481, 'YM3HBOAJ2F', 'LUBM8N70W1VS3IR', 1, 1, 5),
(482, 'OW9DGK3Y2I', 'JZYDSE37M8IGF0U', 1, 1, 5),
(483, 'Z3ND8FORGW', 'IVJE1XP2B0LN3UZ', 1, 1, 5),
(484, 'K0X7U2V9H3', '3A61F4INQ2RXS9T', 1, 1, 5),
(485, '7JQ4M3F1KP', '74VPZD56T0GM8H3', 1, 1, 5),
(486, '5EWX341R78', 'MVQF6DXSIC8WHE1', 1, 1, 5),
(487, 'G2156Z9YUF', 'KNR9E2A073BJUT8', 1, 1, 5),
(488, 'WL0MXDVUOJ', 'M7XEDHZLST2J4AF', 1, 1, 5),
(489, '6LVCTWR1ZO', 'SMKW0TOXF54Y2LA', 1, 1, 5),
(490, 'IA9XQ3OWFY', 'NRK0LBQ93S2UWVC', 1, 1, 5),
(491, 'I9ZXBR870O', '31K64Z0LJ752APV', 1, 1, 5),
(492, 'CGXKOLBWA7', 'YQ72V1BG96HZERF', 1, 1, 5),
(493, '9CAJZG536O', '2OG5PK83N7BDCEI', 1, 1, 5),
(494, '1FQ3SVGPN7', 'QCBFUKRGP7VDXT4', 1, 1, 5),
(495, 'G6ZRKFMDJT', 'ZEY9V7Q4WIKXJHU', 1, 1, 5),
(496, 'JGBLYMI1VO', 'WI86OP5ZYSNGJBL', 1, 1, 5),
(497, 'X5N4ZWLAV9', 'GLD0FWE6VMJ35RX', 1, 1, 5),
(498, 'VM5OI7TE1U', 'XKETQ4HR23VLCUF', 1, 1, 5),
(499, 'TGCL8OEQUM', 'HNT3GJ95XBKAU1W', 1, 1, 5),
(500, 'AVBL6ROX31', 'TKPJ2MD7HV9ZE3L', 1, 1, 5),
(701, 'PCGKOMQFTZ5DRI8', 'YIM58QU1RA2NT6PS09HZ', 1, 1, 4),
(702, '2G3QCU1KBVTEF0W', '06IS7H32QMLR4ZGOJU8X', 1, 1, 4),
(703, 'F5UI6TLHOXN9WCP', 'U3KLNM59IJQZ1HF64PDE', 1, 1, 4),
(704, 'SK72ZC3Y9WVN18F', 'XGZNS8KTC1U2FV9WBM3A', 1, 1, 4),
(705, 'NPBU9FH5XYW81EK', '23WGCHSBO71U5NXJMDYV', 1, 1, 4),
(706, 'N6QXDOASGWV2IE8', 'IRF62OQY5GVA48H7E1M3', 1, 1, 4),
(707, '8DUWE4H9PJMB1FV', 'DV72QOK9GP6TFYSURJI4', 1, 1, 4),
(708, 'AQVX7HSE84JUBCG', 'KV8NIYJCQ0SG96XZHTRE', 1, 1, 4),
(709, 'PDHAS4UFZY86RIX', 'WD4JCGK697T8FZ3RNXE2', 1, 1, 4),
(710, '7ZHOFGTSJYL9C0P', 'WIDBMCKEUXVNHSF8G01J', 1, 1, 4),
(711, 'Y0S2RDC84NGIM7Z', 'J35V8960O72P1TMFU4ND', 1, 1, 4),
(712, 'WMZ5CUX23JVIGK9', '8MPL03VO5QY1D96WZJFT', 1, 1, 4),
(713, 'THG6JEUM5XPVR9W', 'LGPOKA83J59B0NSFMT2H', 1, 1, 4),
(714, '2YU4ZI19GVJLHST', 'A01ST7JIF4KBQY562RH3', 1, 1, 4),
(715, 'M9LO7WBX2JA50DK', '8V532C1DBFPKZLRIWY06', 1, 1, 4),
(716, 'H3ZJ2IY5WME9RSF', 'QRMUBXPN0CKH53YAEOL4', 1, 1, 4),
(717, 'PF8QU2L4HATEBRX', 'PT5N08VCB3IZ9SKAFOUJ', 1, 1, 4),
(718, 'FSDTNZCG9WK0864', '1W3BVYED97QFI2RLUCX0', 1, 1, 4),
(719, '7HV3MIDZJKPLUCS', 'PB71SKV9CY0L356XNZ4R', 1, 1, 4),
(720, 'YUMHWX62ANQJRC5', 'OY7REHI4F632NPSQK9CJ', 1, 1, 4),
(721, 'TKMIBOH68CJXWZR', 'Q7L38GMZJOBAF594PURD', 1, 1, 4),
(722, 'PUDS9QW1E4ZH3VT', '2RE8OTBIWKVN15DXHJGU', 1, 1, 4),
(723, '0VZHMEL8XG3U462', 'SFG0JB5A92WV7P3DZQI4', 1, 1, 4),
(724, '861NLERF37AZCKW', '35VQDYKB2GJSXHTLRNEP', 1, 1, 4),
(725, 'YJN5UODKLH0VACQ', 'W4H8NTVLZ0SE2RF1BYG3', 1, 1, 4),
(726, 'M9Q6N3CORH0TSWP', 'S2W4X5PKCVA638F1GB9D', 1, 1, 4),
(727, 'GXAH6IFC9OW1QD2', '4WJV25AH8OM6LFI1KQXR', 1, 1, 4),
(728, 'ABU49R2Q3Y71ZHT', 'LX1FECIA9KQ3N5V8MBWG', 1, 1, 4),
(729, '92LTP7GHMDNW41Y', 'X8EL0IR9VKQYNTBWUO3G', 1, 1, 4),
(730, 'FT3E1JAZ9MLH4NI', 'CD6KBLHVZQGEW0XT2UAR', 1, 1, 4),
(731, 'LXG10JQ2RSCZN8P', 'KY69NAVSR1UMQ8DFE7IX', 1, 1, 4),
(732, 'PZA5GVX4QUTYL07', 'BGJ5EUSKDH4W2ARN3ZP8', 1, 1, 4),
(733, 'UQY0O2IK46DH7XE', 'HUC1DKG7XQZ3M5J6BPRY', 1, 1, 4),
(734, 'ZXQ9ON5A0WY4VR6', 'LU2VP7QMSGW3AX90BK4Z', 1, 1, 4),
(735, 'FBNGDJSHUKMQ4A0', 'ON8X0AJ52KVSED4BQZC9', 1, 1, 4),
(736, 'UDOTNJP6WMCS51Z', 'ZNM3UGPSX4H6JA197BVF', 1, 1, 4),
(737, '48IPSTAZXBH092J', 'ER4FPDKMWJN9TOC6SYH5', 1, 1, 4),
(738, 'SMJUBNP0FGR364X', 'WUJ4YTABD5MX9P7ZS0LF', 1, 1, 4),
(739, 'HK12S8G0JAEXW74', 'P2MWYE17RVFKO30Z96GX', 1, 1, 4),
(740, 'QDFCBOK3VEXZ45L', 'VXMB9JAZQ1NI47W8RCF3', 1, 1, 4),
(741, 'Q01C5DTBPY89IGL', '563NR8JIZ7KP20B9YSXC', 1, 1, 4),
(742, 'H0PN5BMIJD4GQOY', 'GQ0C2XA3HW7OUJKRIZES', 1, 1, 4),
(743, 'TY7QZKVB8FGD9MH', '503QI7THVDN1SG6AB9LU', 1, 1, 4),
(744, 'G6NVD95SAO7LZXP', 'BH9UN6I1PY0E35XZLV8G', 1, 1, 4),
(745, 'KBFI2L1MA7CRZUW', 'X0ANQMKZTPJYU5DVBHR2', 1, 1, 4),
(746, '8B3DUZ5MCE47WLA', '4AK6N5YEVRTBWU9SI10Q', 1, 1, 4),
(747, 'NF268TL5KVZIMOW', '6IJ94BVTYH8Q1XPKGZSW', 1, 1, 4),
(748, 'JD0RN2UOW1S3G97', 'WZ6ECOGPAD83FQSBMI20', 1, 1, 4),
(749, 'FTVWDJ95CURESQP', '23XNB0QCALGUM5TJS9KO', 1, 1, 4),
(750, '5VYDTQKNRG9J40F', 'KA1NC4LQZR07X2WJ8SO3', 1, 1, 4),
(751, 'CQ092RAMLB4DYS6', 'P5K84VS9FQN7MO0ECBJI', 1, 1, 4),
(752, 'TBW4YQ5DIRFX12Z', '9QNYULXO8VSG4FWZI12M', 1, 1, 4),
(753, '3W5KVENQ7MU61CF', 'Q4LJD678OB20ATMUR9GW', 1, 1, 4),
(754, 'OR95EJBLX3A21Z8', 'STAD456XYCNI3108OQG2', 1, 1, 4),
(755, 'SLKJG142F58WOYN', 'F6E9MTKS3ZY5HQLR20NO', 1, 1, 4),
(756, 'PMVZ0H6ES8YTOK4', 'AJHE3ML6GF9UV14PW8KI', 1, 1, 4),
(757, '5GSWLJ8XTACNBYF', '1IG72DALC8URN3HWP5O9', 1, 1, 4),
(758, 'JNRCQ297M3KDVHY', 'EAQLP5MGXZKVJW9SBIUN', 1, 1, 4),
(759, 'INPA8L92U1BFJ50', 'C2H6BRW34LT0XNZP8OYS', 1, 1, 4),
(760, '4QM6KH7351BCTZ9', 'KETN0C49FSMYZB2VPAU3', 1, 1, 4),
(761, 'EI04CT5DFAWUSZ3', 'IZB3ACJOH4PKMWRY72LF', 1, 1, 4),
(762, 'V06H9ZE1GFWBNJR', '3LUBZCERQIASHM80JXTD', 1, 1, 4),
(763, '0ICRJGTD4OEN976', 'FGQAP8LMOTJ62IV10RKB', 1, 1, 4),
(764, '4C1HSOIZ9QT35ND', 'VKA3F4X812WGUCPMISNQ', 1, 1, 4),
(765, 'V6KOFE5JM1US0WC', 'I2YNR3BCPK96EAWUD4G8', 1, 1, 4),
(766, '3HU8MLQNIWP6T1D', 'JQ7NLHYRF6M3TUVB4COG', 1, 1, 4),
(767, 'UFI75SOJEYC6ZX3', '6ZTNBVP05O4D1IXRY9ME', 1, 1, 4),
(768, 'KFPY6ZIVHUDAG15', '17RD52L0JCN3HMSXBU4A', 1, 1, 4),
(769, '8E9ICNLPQ02ABSZ', 'X012S5IDTPZ84AEWNFQY', 1, 1, 4),
(770, 'EGQ3PKD2INZBST5', '2FTKWQ1B6V9I80GZU7CH', 1, 1, 4),
(771, 'F2KOP6N3ZL5U149', '8RLHG36STZE4W9KQO05B', 1, 1, 4),
(772, '0YVZ1CJUW7GADI5', '8UQD43TG2EF750YPLC91', 1, 1, 4),
(773, 'SL6YZ2FXHUTOCGV', '7Q6KIPCHVFO5JLBNXTRY', 1, 1, 4),
(774, 'BHQ1TLA9UEKNSGZ', 'CZE9AM4I6NRJF3BSQVU0', 1, 1, 4),
(775, 'D5EVOT1KA7JX8L0', 'VLG4WJF75EKMBZANY6U8', 1, 1, 4),
(776, 'DYB4TK5OL9U71J0', 'REL8P3UDJWA0QG79VKBI', 1, 1, 4),
(777, 'STINYAUMWBDQ68F', 'QP8SH3VLZ5B09WUF2CDX', 1, 1, 4),
(778, 'S0HEW8RQ7NJK9G3', '9NS2310TMJXHDAUR6WBP', 1, 1, 4),
(779, 'PD4N31AZL2KCUSV', 'PINBDJYS76H1QKW3VGO8', 1, 1, 4),
(780, 'XW51JG34DML2A79', 'UQZ1VR0LAY2XB784H9W6', 1, 1, 4),
(781, 'OXIZR82UKNMPHQF', 'KFCIOXULSDGT4EW02RQ5', 1, 1, 4),
(782, 'AW7ZMEYDVS05KP3', 'ZLXRH4C65BM37WYANK0G', 1, 1, 4),
(783, 'H0OLVURGYM1EWF5', 'FCVTLWOUZ4XHAK2Q1E3S', 1, 1, 4),
(784, '6RQJC2BM4IT0FLN', 'OT8KFL7AEC5NR0BMH23X', 1, 1, 4),
(785, 'X3L5RCB92WQIGFP', 'IF962GBJ31NDK8XWMT5U', 1, 1, 4),
(786, '832VGMYBKEFCXHI', 'L7TW5MNI80AEXP92FZ6O', 1, 1, 4),
(787, '6X8RYSB4T2ZKVMP', '35HSNT9B0QZUVYWCIKF2', 1, 1, 4),
(788, 'FVU0MH6P74WRJTB', 'YD92S1REIJ0MA5FVUL3C', 1, 1, 4),
(789, 'R9FDBH8OLYS35IE', '4IJ8GTSMDLCFYRQUWAX5', 1, 1, 4),
(790, 'FHL2WZV346PT0AS', '16J7S9H0OBP2DXAZVMF4', 1, 1, 4),
(791, 'YS7COG8W42DMINV', 'W8069A3HTJEZXP1UCV2K', 1, 1, 4),
(792, 'LH435RXMDU7J9EZ', 'XCEP9Y6SWV27QBAK50I1', 1, 1, 4),
(793, '3W1CQ0OHTBKY476', 'CJDG0F61U93YPTZSOA54', 1, 1, 4),
(794, '6MZFNCUWA58J42L', '2QOSWBT768JMC91VFIEH', 1, 1, 4),
(795, 'SC8IBANVXHKW1DE', '4VF76I5CH2PU0M3GB8KD', 1, 1, 4),
(796, '4HSI392NKJ10XAB', '1ZOXRJN4P9CAIQM26SF0', 1, 1, 4),
(797, 'NKF4L91TSOM7CWI', '0QUCNEZD3GHI5SY47FOW', 1, 1, 4),
(798, 'B5Z49IKASFM3XGW', 'RCFTLAP9IJN8MZ0U5G64', 1, 1, 4),
(799, 'HIQX75MN48RPTED', 'NARO3WHY5GE6KMZLI8XT', 1, 1, 4),
(800, '4VCFY8WUJATI5KO', 'JY30TOG59B2W7C618PIZ', 1, 1, 4),
(801, '8AZXKOVCD5GPE4Y', '35G6IZ7JOELRVMUN4BKS', 1, 1, 4),
(802, 'IMEW96LTDHKJ24Z', '6E73MX2W9CANKOB0H5GY', 1, 1, 4),
(803, 'CJKPBRMIHV2LYQT', 'N9UZJA6R5BW4I8LKHXYM', 1, 1, 4),
(804, 'SMIKQ7U3LPNOWJF', '4CWLENQT2FUO01H7I3YA', 1, 1, 4),
(805, 'BDI41UQT6MVAZLH', 'DWCI9XE52PKG0SH36JB4', 1, 1, 4),
(806, 'QNYOCZ1FXR6EGKH', 'N2MYTSJ0EIV97C8A45BF', 1, 1, 4),
(807, 'WECAZVDB3SX9H21', 'E4MJQID193OBR8WKYC0L', 1, 1, 4),
(808, '4SO3XA8M1KR7V6G', '1MR6EW3G0NI8YPTKA54B', 1, 1, 4),
(809, 'LV21GRQXJ9UEH48', 'U8GH6SX2V7C94M5O1KWR', 1, 1, 4),
(810, 'PK8BJ1SUIRL23C4', 'O8AHYWFT7LJMIX91KRDB', 1, 1, 4),
(811, '3RYHQUXC15Z2WVT', '3CGHVZA1X2469NI8J7OP', 1, 1, 4),
(812, '56K237ZVJWSI8L4', 'X1RQTHW6N3UVMD45J7FL', 1, 1, 4),
(813, 'YISTBWA2E5VUKOL', 'Q6C7IKPM3BV1N2HFZSAU', 1, 1, 4),
(814, 'Q3GO8R4CWUEZJHD', '7DESTHM5UFYWGZ4QI1NJ', 1, 1, 4),
(815, '4B8D5H1T0F39I2K', '1UREJSVMNWQZL4BXT9G8', 1, 1, 4),
(816, 'A5F14X69V7DEM3P', 'K4UVGFQNM5JA92L6SPW8', 1, 1, 4),
(817, 'AL3GWVUE1JZR57I', 'D96BIC8NO7EZ3RUSTLMJ', 1, 1, 4),
(818, '1AP39OY8N6CF4RD', 'GQE9HI17M3U20DXYANZO', 1, 1, 4),
(819, 'IM5DT7JCBFVYL08', 'GB4YUO92AJVREIPNZL86', 1, 1, 4),
(820, '6YTZGV3LWUSO0EB', '6A4NGLQCWV9BDISE7T2F', 1, 1, 4),
(821, 'HL20XN7FJ89RDP6', '7U432LCJMZW1EPHKQ5SA', 1, 1, 4),
(822, '3GAVKW8YULNC027', 'M52RVB6DFPX9UZSL8Y4E', 1, 1, 4),
(823, '4VZMOFSGK9TDYC2', '5WXS81FIAK0PB29R7YVU', 1, 1, 4),
(824, '80U25M4ZNP9BLJW', 'PYJ3AW50RIOLKMUFZH68', 1, 1, 4),
(825, '8IV5P24Q09BKEMZ', 'R7AB0GPF69JIYTSV5O2X', 1, 1, 4),
(826, 'MOWSKTNU4I6XEPY', 'N05XED7RO4M6TA1UYWVZ', 1, 1, 4),
(827, 'B80IRZ3NJG7MDCE', 'RTM7Z6B9G58HJ3ACEL04', 1, 1, 4),
(828, 'NAJPC6LXVTFR1MZ', '20EJTPXKZ1WG5NRFI7LU', 1, 1, 4),
(829, 'RLGBCJZY87VM5WK', 'S36J7R8YCLXQ20DFVHGM', 1, 1, 4),
(830, 'WCYGA4H1VDOPM3K', '14DGF03XPOH8JAL9EZCY', 1, 1, 4),
(831, 'CHJRDP9LAWY3KSO', '0L9INJKTS6QR12D8BPAO', 1, 1, 4),
(832, 'DE54C3WGHNT8KOL', '2F0YR7LVDPS5WAIHCM4O', 1, 1, 4),
(833, 'VQY9CF6KN5U0T8I', 'PT7FXKD2NAOB4ZIQEHVG', 1, 1, 4),
(834, 'VZ5F1PJR3SDNA7Y', '342V1680LFOHQXZGWDYA', 1, 1, 4),
(835, '3BQONLSU7G420PM', 'COYT5VHRI14AQM7ZPESJ', 1, 1, 4),
(836, 'M1I2DB6T8CLO9QX', '54RS6DFBOHYP2UWA0QTM', 1, 1, 4),
(837, 'A5STO68D0QHP1RU', 'AT3FHBGN0P718UOI6DW4', 1, 1, 4),
(838, 'MS69J3XDB250KA8', 'UH3I8C2QPTFXZ0DLWKE1', 1, 1, 4),
(839, '7483TIBY2XOECMJ', 'GTIBP4L7NDEWU2FSA9XK', 1, 1, 4),
(840, 'XESHLK18WAN2B4R', 'B1XIOT709S3NYR8ZVH6D', 1, 1, 4),
(841, 'H2Z194CIDGWSE6J', 'LHRDPIZCYTMQ5ASJW96F', 1, 1, 4),
(842, 'RLQBAGVD7P6SNHC', 'V7UXS2WEM8KPHCIZAN6L', 1, 1, 4),
(843, 'PKDE2MIU6TBJ5G7', '8QU2V9O5L30GRCM64N1P', 1, 1, 4),
(844, '3I4VU67RXB08C95', 'UHV2JODPBGTA4C7WQE68', 1, 1, 4),
(845, 'KVHASO1I4N2LEY8', 'DK85VQ2H9R3IEXP6WTMC', 1, 1, 4),
(846, '81RFZNY7GVWATIP', 'SN5Q0IHA38XDOUYWGKBC', 1, 1, 4),
(847, 'ROGVTE7MSPH893W', '25N36OA7YCIKETH04DML', 1, 1, 4),
(848, 'URXAVZI8MS7L2DN', 'JPUW209QG16VNAT3BECI', 1, 1, 4),
(849, '0FSR72HVNZK9YT8', '2MN4VWLBJ9Z6HARIT3CY', 1, 1, 4),
(850, '5MGURZPB8HSLFOI', 'SZDYNP4XTA01HLQIF8EU', 1, 1, 4),
(851, 'W9RECK5ST10G2LV', 'V3LDHK1XWGS8UR6IOCQ0', 1, 1, 4),
(852, 'DCXRQ6EA21KJ9V4', 'VLK5BGF23IEP061DY4MR', 1, 1, 4),
(853, 'YEFNVGQISL1ARZ6', '078BWPQLMEDFA42YSTJN', 1, 1, 4),
(854, '2G4D9C3HBFWAZ1L', 'XYR86OGZ3EKQ7MJ5B02F', 1, 1, 4),
(855, '5YE8SF6MVLG0HTI', 'UJDQNG4V025KYR8ZBWFT', 1, 1, 4),
(856, 'YC9UTF2DZBMPK8A', '8HUTQRC2E6N0WZY1M7VS', 1, 1, 4),
(857, 'HZP8JQ6D75I1UCM', '25V1X7BIYJR3A4ZMLWTP', 1, 1, 4),
(858, '60R9T8KL4UQIYWZ', '3UTB0HSO1QJZ6K98MNIY', 1, 1, 4),
(859, 'G6P8CS9R1AKHD3N', 'ORGMDZXQY4IASBH689VW', 1, 1, 4),
(860, 'V3H9X7Q81ELYF5I', 'PBZLWK0E18VYX5R4H9IC', 1, 1, 4),
(861, '5J0L2S9GIT7VYK6', 'HP1SE9TKV50LOX8UZY27', 1, 1, 4),
(862, 'RB3UM96EI5G1LF4', 'X7WE25GJCA4NIO6BHRYK', 1, 1, 4),
(863, 'E0IKP47XM3YB61C', '3IP2U1SNAQ875KBZDGJO', 1, 1, 4),
(864, 'YS3RFD0ZMC9G6UH', 'HQXUJNC2S09R5KBA8WZE', 1, 1, 4),
(865, 'FG7MAQSLCJ24ZU0', 'GOK9AHX5BM74063QFJCD', 1, 1, 4),
(866, 'R58O7LBG6IZAEPN', 'XL2US3K9HC5JDPR4EBF1', 1, 1, 4),
(867, 'GJQM8IZF520EPYC', 'SHM1ZJPYWQXTOD46CGNV', 1, 1, 4),
(868, 'XZ50PI4EOD1N2GT', 'U2Y4GNF8SO0EAM7ZJCWL', 1, 1, 4),
(869, 'VI48FN6QD3GU5S7', 'BH4SQN5U39ETA1GYLR6W', 1, 1, 4),
(870, 'KPZU0FYIHJR7E5G', '231FMCTZKIQUD9J4R0NG', 1, 1, 4),
(871, 'CGYSRE1FPKU342H', 'MPO28JNLIEQV9H64KFS5', 1, 1, 4),
(872, '8WVCUODXT3Q2FPL', 'EZRAPJ1KHM8FY4DCWOIQ', 1, 1, 4),
(873, '5JBG3ACPEUVF0NR', 'MT1KV98D5EGANZBSICQP', 1, 1, 4),
(874, 'WAQ72LZBRX68MTO', '3YBCHSQL5690F2R1ZXVO', 1, 1, 4),
(875, 'HJ5IG3A0PCWYQEB', '03UDECA4OT19PNRMBHGX', 1, 1, 4),
(876, 'RI4SW93JBT2HKE0', '5NWPFL1CJRYISEO0KB84', 1, 1, 4),
(877, 'XLH5Z0Y7DPTA4KJ', '3P8RSFIZGX67CD25LHMQ', 1, 1, 4),
(878, 'FJQW26Z78X9EV3I', '8QXDJAK1NYB5HR3ECT2F', 1, 1, 4),
(879, 'JAZ846P9VRG07YI', '1Y59N3JZ6OVA4BLRP7FI', 1, 1, 4),
(880, 'AMO9CZ14GYUEWLT', '08DYHWFCG2OPKTB7JNLI', 1, 1, 4),
(881, 'SHGQ3M5XN0RA8IW', '81RIEJU0Z52M9KG6XOAC', 1, 1, 4),
(882, 'RKILQD1XY9VS763', 'DS7L3I4Q5HR6KNVFA2P8', 1, 1, 4),
(883, 'BTQ62SIM0HERO8G', 'CUI8XMSJF0YQHVE7RA4T', 1, 1, 4),
(884, '7QI0D81JSF6MOAN', '6QTPHFZW1GKBVNAYEU9R', 1, 1, 4),
(885, '5CXYJ29G7FZATLQ', 'DSFJP5R1VLX39UQAZI4C', 1, 1, 4),
(886, 'YSW14RLQZ6DVU7H', 'ZTVNGPIBWKSLF7Y9H6U5', 1, 1, 4),
(887, '2B8CN0ELQTUWJP5', 'PS0WBR3FYH49L5X26U78', 1, 1, 4),
(888, 'OH8FCWKLY3MSERG', 'HPIWD4G72OUQ1SKJ06ZC', 1, 1, 4),
(889, 'FP8V5XDJA6NCR4K', 'K8ZNH503OG1Q2XY6WFVD', 1, 1, 4),
(890, 'WOLS9I4CNTXJ6AQ', 'KBE3XRG8N1QCH59TS7MA', 1, 1, 4),
(891, '95PUXJWD0C8EMHI', 'GX9LT184ZFMJ6RP7BWKS', 1, 1, 4),
(892, 'GF1DCT7LAJQ2WMP', 'CR981TKAIVSGQXDUFOE3', 1, 1, 4),
(893, 'KRT0UDW5SQFCPXY', 'WHBSK2IP671F3UAD5CXL', 1, 1, 4),
(894, 'H1KXUMS9EG3DN4P', 'MPLENQ329O5KGHI68TXY', 1, 1, 4),
(895, 'S1HY873ODRLCI60', 'F0ZMTPY3XJKNDR2AH6IW', 1, 1, 4),
(896, 'SKNOCVWMJA56D3Z', 'YB15NETMV8FP7GOAWUZ9', 1, 1, 4),
(897, 'KNSVGQPM09C3JA1', 'HYRGE2OUPTSWZJF471Q0', 1, 1, 4),
(898, '69H2VPJSWYB5XGE', '9CGPSX6M8ZHJNIDR5KAQ', 1, 1, 4),
(899, 'WDERY5TF7L2KCN3', 'ETYSFH29N03I45PDCURL', 1, 1, 4),
(900, 'P9MBD8LE7QVH1TS', 'U84KDZQRYG67P2LNJCSX', 1, 1, 4),
(1621, '6QA0WOIXRV2F', 'Q2Y4SDZVF5CB9GE', 1, 2, 6),
(1622, 'RG0S6I5CWM21', '2ZI5W3BNM9TLXSG', 1, 2, 6),
(1623, 'Q5ILM89HWFD7', 'SB67R2JZ9NVDWH8', 1, 2, 6),
(1624, 'CUTQY1ZR64L5', '3Z41O0965SBFRJ2', 1, 2, 6),
(1625, 'Z5US06GQXI9E', 'YS158CQKO7X4FUR', 1, 2, 6),
(1626, '51X6W0ICDYO8', '3ZCU5HJSPY4LNRI', 1, 2, 6),
(1627, '0H49QRO1MYTG', 'FELDPR4BVUOX2JQ', 1, 2, 6),
(1628, 'JOIG4Z981BR0', '5F3G1YBIWDM2COK', 1, 2, 6),
(1629, 'M1QJNRYT0WXB', 'MAY6I1DJ8KES9U0', 1, 2, 6),
(1630, 'MJ5S98ULHAKX', 'O87G51N9HBCP4XV', 1, 2, 6),
(1631, 'NSXT7GK5WEUI', 'CHUQ2Z96SPO8NLV', 1, 2, 6),
(1632, '69VI7Y43BXKL', 'XHE9YDNV8ARTMPB', 1, 2, 6),
(1633, 'S3QJREKCF164', '31K5ZTIACHVYRQW', 1, 2, 6),
(1634, 'OAV8HJ361L57', '3VP0J4ASG67ZTKR', 1, 2, 6),
(1635, 'UESIRQ4YLTFO', 'NC3BIPMRZ6DTV8Y', 1, 2, 6),
(1636, '1GFW6ZK4E7H0', '7JNOA92RB38TQX1', 1, 2, 6),
(1637, 'PR0O3S6M4J9K', '5D7YRLBSKNXTF6M', 1, 2, 6),
(1638, 'MQUFCK39NIE4', 'FUQ12AYSWJ9E5KI', 1, 2, 6),
(1639, 'EQRJDKNYBZT3', 'A13MVCL527DPWTS', 1, 2, 6),
(1640, '1SYC76OX3FBW', '905PGXO3URVZ6YT', 1, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `result_type`
--

CREATE TABLE `result_type` (
  `Type_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `OrganizerId` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `result_type`
--

INSERT INTO `result_type` (`Type_id`, `Name`, `Status`, `OrganizerId`, `School_id`) VALUES
(5, 'Annual', 1, 1, 4),
(6, 'Terminal', 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `School_id` int(11) NOT NULL,
  `School_name` text NOT NULL,
  `School_description` longtext NOT NULL,
  `School_mark` varchar(100) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `School_status` text NOT NULL,
  `School_type` varchar(100) NOT NULL,
  `School_url` varchar(200) NOT NULL,
  `School_logo` varchar(100) NOT NULL,
  `Date_created` varchar(150) NOT NULL,
  `Resultpin_length` int(11) NOT NULL,
  `Pin_usage` int(11) NOT NULL,
  `Teacher_add_students` int(11) NOT NULL,
  `Teacher_add_result` int(11) NOT NULL,
  `Serialpin_length` int(11) NOT NULL,
  `Result_type` int(11) NOT NULL,
  `Address` varchar(200) NOT NULL,
  `Phone` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Round_to` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`School_id`, `School_name`, `School_description`, `School_mark`, `OrganizerId`, `School_status`, `School_type`, `School_url`, `School_logo`, `Date_created`, `Resultpin_length`, `Pin_usage`, `Teacher_add_students`, `Teacher_add_result`, `Serialpin_length`, `Result_type`, `Address`, `Phone`, `Email`, `Round_to`) VALUES
(4, 'Bethel Secondary School Uwani', 'The place for every child.', 'DSR-989783640', 1, '1', '6', 'bethel-school-uwani', '7be4f4cd176a3c7606710c4456f7ac8e.jpg', '1574428908', 15, 4, 1, 1, 20, 1, 'Obiagu', '08147298815', 'meritinfos@gmail.com', 3),
(5, 'Ivory Science Academy', 'The citadel of learning', 'DSR-619834798', 1, '1', '6', 'ivory-science-academy', 'a459144af9e6cd5b09def3a5a8060eb2.jpg', '1574430289', 10, 3, 1, 1, 15, 1, '', '', '', 2),
(6, 'Bethel Secondary School Enugu', 'The pearl of education', 'DSR-574945297', 2, '1', '10', 'bethel-school-enugu', 'a3812af0f2cb0029bf2fafc9c05d7352.jpg', '1579013612', 12, 3, 1, 1, 15, 1, 'Obiagu', '08147298815', 'meritinfos@gmail.com', 2),
(7, 'Joe ice International', 'Citadel of learning', 'DSR-1179729295', 3, '1', '11', 'joe-ice', 'd204eebca5af308c8e564503f6c85562.jpg', '1579629482', 0, 0, 0, 0, 0, 0, '', '', '', 2),
(8, 'Awgu Boys', 'A place to be', 'DSR-881752049', 3, '1', '11', 'Awgu-Boys', 'be9d67ab06505d3c7affb9f3b404b901.jpg', '1579638431', 0, 0, 0, 0, 0, 0, '', '', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `school_images`
--

CREATE TABLE `school_images` (
  `School_image_id` int(11) NOT NULL,
  `School_id` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `Image` varchar(140) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `school_type`
--

CREATE TABLE `school_type` (
  `School_type_id` int(11) NOT NULL,
  `School_type_name` varchar(150) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `Date_created` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `school_type`
--

INSERT INTO `school_type` (`School_type_id`, `School_type_name`, `OrganizerId`, `Status`, `Date_created`) VALUES
(6, 'Private School', 1, 1, '1574422229'),
(7, 'Public School', 1, 1, '1574422237'),
(8, 'Secondary School', 1, 1, '1574422248'),
(9, 'Primary school', 1, 1, '1574422263'),
(10, 'Private School', 2, 1, '1579013444'),
(11, 'Private School', 3, 1, '1579629395');

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `Semester_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`Semester_id`, `Name`, `Status`, `OrganizerId`, `School_id`) VALUES
(4, 'First Term', 1, 1, 4),
(5, 'Second Term', 1, 1, 4),
(6, 'Third Term', 1, 1, 4),
(7, 'First Semester', 1, 1, 5),
(8, 'Second Semester', 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `Session_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`Session_id`, `Name`, `Status`, `OrganizerId`, `School_id`) VALUES
(1, '2015/2016', 1, 1, 4),
(2, '2016/2017', 1, 1, 4),
(3, '2017/2018', 1, 1, 4),
(4, '2018/2019', 1, 1, 5),
(5, '2019/2020', 1, 1, 4),
(8, '2016/2017', 1, 1, 5),
(9, '2017/2018', 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `Student_id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Reg_no` varchar(100) NOT NULL,
  `Class` int(11) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `Status` int(11) NOT NULL,
  `School_id` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `State` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`Student_id`, `Name`, `Reg_no`, `Class`, `DateCreated`, `DateUpdated`, `Status`, `School_id`, `OrganizerId`, `State`) VALUES
(1, 'Michael Erastus', 'DSR/2019/952182', 13, '2019-12-15 07:21:31', '0000-00-00 00:00:00', 1, 4, 1, 2),
(2, 'Okike Erastus', 'DSR/2019/697216', 13, '2019-12-15 07:21:31', '0000-00-00 00:00:00', 1, 4, 1, 2),
(4, 'Michael Erastus', 'DSR/2019/493997', 17, '2019-12-15 07:30:47', '0000-00-00 00:00:00', 1, 4, 1, 2),
(5, 'Michael Erastus', 'DSR/2020/434533', 25, '2020-01-21 18:10:36', '0000-00-00 00:00:00', 1, 7, 3, 2),
(6, 'Okike Erastus', 'DSR/2020/171987', 25, '2020-01-21 18:10:36', '0000-00-00 00:00:00', 1, 7, 3, 2),
(7, 'Chinedu Vitalis', 'DSR/2020/340435', 25, '2020-01-21 18:10:36', '0000-00-00 00:00:00', 1, 7, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `Subject_id` int(11) NOT NULL,
  `Subject_name` varchar(120) NOT NULL,
  `Subject_code` varchar(120) NOT NULL,
  `Unit_load` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `School_id` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`Subject_id`, `Subject_name`, `Subject_code`, `Unit_load`, `Status`, `School_id`, `OrganizerId`) VALUES
(1, 'General Mathematics', 'MTH101', '3', 1, 4, 1),
(2, 'Basic Inorganic Chemistry', 'CHM101', '2', 1, 4, 1),
(3, 'Use of English', 'GSP 101', '2', 1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `subject_combination`
--

CREATE TABLE `subject_combination` (
  `Combination_id` int(11) NOT NULL,
  `Subject` int(11) NOT NULL,
  `Class` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `School_id` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject_combination`
--

INSERT INTO `subject_combination` (`Combination_id`, `Subject`, `Class`, `Status`, `School_id`, `OrganizerId`) VALUES
(1, 1, 13, 1, 4, 1),
(2, 2, 13, 1, 4, 1),
(3, 3, 13, 1, 4, 1),
(4, 1, 16, 1, 4, 1),
(5, 3, 16, 1, 4, 1),
(6, 1, 14, 1, 4, 1),
(7, 2, 14, 1, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `support_replies`
--

CREATE TABLE `support_replies` (
  `Reply_id` int(11) NOT NULL,
  `Ticketid` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `Response` text NOT NULL,
  `Type` int(11) NOT NULL,
  `Time_replied` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `Ticket_id` int(11) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `Subject` text NOT NULL,
  `Comment` text NOT NULL,
  `Ticket_mark` varchar(120) NOT NULL,
  `Status` int(11) NOT NULL,
  `Department` int(11) NOT NULL,
  `Date_created` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sysadmin`
--

CREATE TABLE `sysadmin` (
  `admin_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Admin_type` int(11) NOT NULL,
  `AdminSess` varchar(100) NOT NULL,
  `Status` int(11) NOT NULL,
  `ResetCode` varchar(120) NOT NULL,
  `Email_code` varchar(150) NOT NULL,
  `Twoway` int(11) NOT NULL DEFAULT 1,
  `Notifyme` int(11) NOT NULL DEFAULT 1,
  `Twoway_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sysadmin`
--

INSERT INTO `sysadmin` (`admin_id`, `Name`, `Email`, `Password`, `Admin_type`, `AdminSess`, `Status`, `ResetCode`, `Email_code`, `Twoway`, `Notifyme`, `Twoway_code`) VALUES
(1, 'Superadmin', 'superadmin@admin.com', '$2y$10$T0XQOP0Bqz1J.bTgawdCc.Bdpfwuwtv5qD3ly.bbpNRFz9hLxxXvW', 1, '2184d8619075de0587395b834c4c96f03de1d49a', 1, '', '', 2, 1, ''),
(2, 'Admin', 'admin@admin.com', '$2y$10$ydSQ.89xsdqEhHEEdsD2cOX73CJrjPLD8z9ccQBn50jgEVkyw6suq', 2, '', 1, '', '', 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `Teacher_id` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Email` varchar(150) DEFAULT NULL,
  `Password` varchar(150) NOT NULL,
  `Class` int(11) NOT NULL,
  `Photo` varchar(150) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `Status` int(11) NOT NULL,
  `TeacherSess` varchar(150) NOT NULL,
  `EmailCode` varchar(120) NOT NULL,
  `Email_code` varchar(150) NOT NULL,
  `OrganizerId` int(11) NOT NULL,
  `School_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`Teacher_id`, `Name`, `Email`, `Password`, `Class`, `Photo`, `RegDate`, `DateUpdated`, `Status`, `TeacherSess`, `EmailCode`, `Email_code`, `OrganizerId`, `School_id`) VALUES
(4, 'Michael Erastus', 'meritinfos@gmail.com', '$2y$10$uobHi96Bcji4yaPpDqPqi.tR.Q8kJJAYAAINUEFYkUXzxUvnSXuUG', 13, '918c6bf78c82b8e0f6010c446048b952.png', '2019-12-14 17:20:00', '2020-04-02 08:53:03', 1, '', '', '', 1, 4),
(5, 'Michael Chinedu', 'meritinfoweb@gmail.com', '$2y$10$DxaOeHrH2GGUn84NJETcX.ETm0pC.aJk2pL7sQXSk37KHeioW1Ozm', 14, 'admin-image.png', '2019-12-14 17:20:01', '2020-04-01 17:03:21', 1, '', '', '', 1, 4),
(6, 'Joseph Migget', 'joseph@gmail.com', '$2y$10$DVJh0XKXDAaBxEdFwgmak.qhE4xpn.KyBXz0.C2gGaQNzLzjKzjDu', 19, 'admin-image.png', '2019-12-14 17:21:21', '2020-04-01 17:03:25', 1, '', '', '', 1, 5),
(7, 'Clara Edison', 'clara@gmail.com', '$2y$10$TMReFGto6JybRX3iBrxhlu76gt83WALo32dkknivouTMjA/yGS4Xi', 20, 'admin-image.png', '2019-12-14 17:21:21', '2020-04-01 17:03:29', 1, '', '', '', 1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`Class_id`),
  ADD KEY `Name` (`Name`),
  ADD KEY `ClassRef` (`ClassRef`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`Faq_id`);

--
-- Indexes for table `faq_category`
--
ALTER TABLE `faq_category`
  ADD PRIMARY KEY (`Category_id`);

--
-- Indexes for table `faq_request`
--
ALTER TABLE `faq_request`
  ADD PRIMARY KEY (`Request_id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`Grade_id`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`OrganizerId`);

--
-- Indexes for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`MethodId`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`Payment_id`);

--
-- Indexes for table `pin_usage`
--
ALTER TABLE `pin_usage`
  ADD PRIMARY KEY (`Usage_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`Position_id`);

--
-- Indexes for table `pricing_table`
--
ALTER TABLE `pricing_table`
  ADD PRIMARY KEY (`Package_id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`Result_id`);

--
-- Indexes for table `result_pins`
--
ALTER TABLE `result_pins`
  ADD PRIMARY KEY (`Pin_id`);

--
-- Indexes for table `result_type`
--
ALTER TABLE `result_type`
  ADD PRIMARY KEY (`Type_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`School_id`);

--
-- Indexes for table `school_images`
--
ALTER TABLE `school_images`
  ADD PRIMARY KEY (`School_image_id`);

--
-- Indexes for table `school_type`
--
ALTER TABLE `school_type`
  ADD PRIMARY KEY (`School_type_id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`Semester_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`Session_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`Student_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`Subject_id`);

--
-- Indexes for table `subject_combination`
--
ALTER TABLE `subject_combination`
  ADD PRIMARY KEY (`Combination_id`);

--
-- Indexes for table `support_replies`
--
ALTER TABLE `support_replies`
  ADD PRIMARY KEY (`Reply_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`Ticket_id`);

--
-- Indexes for table `sysadmin`
--
ALTER TABLE `sysadmin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`Teacher_id`),
  ADD KEY `Name` (`Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `Class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `Faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faq_category`
--
ALTER TABLE `faq_category`
  MODIFY `Category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `faq_request`
--
ALTER TABLE `faq_request`
  MODIFY `Request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `Grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `organizer`
--
ALTER TABLE `organizer`
  MODIFY `OrganizerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  MODIFY `MethodId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `Payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pin_usage`
--
ALTER TABLE `pin_usage`
  MODIFY `Usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `Position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pricing_table`
--
ALTER TABLE `pricing_table`
  MODIFY `Package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `Result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `result_pins`
--
ALTER TABLE `result_pins`
  MODIFY `Pin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1641;

--
-- AUTO_INCREMENT for table `result_type`
--
ALTER TABLE `result_type`
  MODIFY `Type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `School_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `school_images`
--
ALTER TABLE `school_images`
  MODIFY `School_image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_type`
--
ALTER TABLE `school_type`
  MODIFY `School_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `Semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `Session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `Student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `Subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subject_combination`
--
ALTER TABLE `subject_combination`
  MODIFY `Combination_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `support_replies`
--
ALTER TABLE `support_replies`
  MODIFY `Reply_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `Ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sysadmin`
--
ALTER TABLE `sysadmin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `Teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
