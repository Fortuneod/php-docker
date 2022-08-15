-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 13, 2022 at 10:35 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `psn_expense`
--

-- --------------------------------------------------------

--
-- Table structure for table `depts`
--

DROP TABLE IF EXISTS `depts`;
CREATE TABLE IF NOT EXISTS `depts` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dept_name` (`dept_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `depts`
--

INSERT INTO `depts` (`id`, `dept_name`) VALUES
(1, 'Accounts'),
(2, 'Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `emp_name` varchar(200) NOT NULL,
  `emp_job` varchar(200) NOT NULL,
  `emp_loc` varchar(200) NOT NULL,
  `emp_dept` varchar(200) NOT NULL,
  `emp_photo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `emp_name`, `emp_job`, `emp_loc`, `emp_dept`, `emp_photo`) VALUES
(1, 'John Doe', 'Manager', 'Lagos', 'Engineering', 'd46a934506_Som.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant` varchar(100) NOT NULL,
  `expense_date` varchar(50) NOT NULL,
  `amount` double NOT NULL,
  `comments` varchar(200) NOT NULL,
  `receipt` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `merchant`, `expense_date`, `amount`, `comments`, `receipt`, `status`) VALUES
(1, 'John Doe', '2022-05-27', 230.05, 'Expense for Airline', '', 'New'),
(2, 'John Doe', '2022-05-27', 68.5, 'Feeding Expenses', '', 'New'),
(3, 'John Doe', '2022-05-27', 103.65, 'Hotel Accommodation Expense', '', 'New'),
(4, 'John Doe', '2022-05-27', 84.99, 'Conference Fee', '', 'New'),
(5, 'John Doe', '2022-05-26', 30, 'Expense on Office Supplies', '', 'New'),
(6, 'John Doe', '2022-05-27', 49.99, 'Staff Bonus', '', 'New'),
(7, 'John Doe', '2022-05-25', 24.99, 'Expense on Electricity Bill', '', 'New'),
(8, 'John Doe', '2022-05-23', 26.79, 'Leave Bonus', '', 'New'),
(9, 'John Doe', '2022-05-24', 607.65, 'Housing Allowance', '', 'New');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_name` varchar(200) NOT NULL,
  `job_desc` varchar(2000) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_name` (`job_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_name`, `job_desc`) VALUES
(1, 'Manager', 'Oversee affairs of the department'),
(2, 'Team Lead', 'Lead a particular team within a department');

-- --------------------------------------------------------

--
-- Table structure for table `locs`
--

DROP TABLE IF EXISTS `locs`;
CREATE TABLE IF NOT EXISTS `locs` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `loc_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loc_name` (`loc_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locs`
--

INSERT INTO `locs` (`id`, `loc_name`) VALUES
(2, 'Abuja'),
(1, 'Lagos');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

DROP TABLE IF EXISTS `merchants`;
CREATE TABLE IF NOT EXISTS `merchants` (
  `id` int(25) UNSIGNED NOT NULL AUTO_INCREMENT,
  `merchant` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `merchant` (`merchant`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `merchant`) VALUES
(11, 'Airline'),
(10, 'Breakfast'),
(4, 'Electronics'),
(8, 'Fast food'),
(3, 'Hotel'),
(12, 'Office Supplies'),
(2, 'Parking'),
(7, 'Rental Car'),
(5, 'Restaurant'),
(1, 'Ride Sharing'),
(6, 'Shuttle'),
(9, 'Taxi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_info`
--

DROP TABLE IF EXISTS `tbl_info`;
CREATE TABLE IF NOT EXISTS `tbl_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_info`
--

INSERT INTO `tbl_info` (`id`, `name`, `description`, `date`) VALUES
(1, 'Kids Dresses', ' Fancy party dreasses for kids', '2022-05-27 10:15:36'),
(2, 'Toys', 'Mechanical and battery toys', '2022-05-27 10:15:36'),
(3, 'Snacks', 'Creamy cakes and sweets', '2022-05-27 10:15:36'),
(4, 'Stationaries', 'Books and notebooks, craft papers', '2022-05-27 10:15:36'),
(5, 'Tools', 'First aid tools', '2022-05-27 10:15:36');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
