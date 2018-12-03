-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2018 at 07:51 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employeemanager`
--
CREATE DATABASE IF NOT EXISTS `employeemanager` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `employeemanager`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `address_ID` int(11) NOT NULL COMMENT 'Primary key',
  `street_address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zipcode` int(11) NOT NULL COMMENT 'Zip code of city',
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_ID`, `street_address`, `city`, `zipcode`, `state`, `country`) VALUES
(1, '1773 Ennis Joslin Rd', 'Corpus Christi', 78412, 'TX', 'United States'),
(2, '2921 Airline Rd Apartment 325', 'Corpus Christi', 78414, 'TX', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
CREATE TABLE `calendar` (
  `schedule_id` int(11) NOT NULL COMMENT 'PK schedule_id',
  `date` date NOT NULL COMMENT 'Date scheduled',
  `event_id` int(11) NOT NULL COMMENT 'FK to the event table',
  `employee_id` int(11) NOT NULL COMMENT 'FK to the employees table, the employee attached to this'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `deptartment_id` int(11) NOT NULL,
  `department_number` int(11) DEFAULT NULL COMMENT 'Department number given by company',
  `department_name` varchar(50) NOT NULL COMMENT 'Name of the department'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`deptartment_id`, `department_number`, `department_name`) VALUES
(1, 123, 'IT Department');

-- --------------------------------------------------------

--
-- Table structure for table `dept_emp`
--

DROP TABLE IF EXISTS `dept_emp`;
CREATE TABLE `dept_emp` (
  `dept_emp_ID` int(11) NOT NULL COMMENT 'Primary key',
  `from_date` date NOT NULL COMMENT 'Day employee started working for the department',
  `to_date` date NOT NULL COMMENT 'Present or when they stopped',
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to employee table',
  `department_id` int(11) NOT NULL COMMENT 'Foreign key to the departments table',
  `dept_manager_id` int(11) NOT NULL COMMENT 'Foreign key to the dept_manager table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dept_emp`
--

INSERT INTO `dept_emp` (`dept_emp_ID`, `from_date`, `to_date`, `employee_id`, `department_id`, `dept_manager_id`) VALUES
(1, '2018-10-01', '2018-10-23', 1, 1, 1),
(2, '2018-10-01', '2018-10-16', 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dept_manager`
--

DROP TABLE IF EXISTS `dept_manager`;
CREATE TABLE `dept_manager` (
  `dept_manager_ID` int(11) NOT NULL COMMENT 'Primary Key',
  `from_date` date NOT NULL COMMENT 'Day manager started for department',
  `to_date` date NOT NULL,
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to the employee table',
  `department_id` int(11) NOT NULL COMMENT 'Foreign key to the departments table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dept_manager`
--

INSERT INTO `dept_manager` (`dept_manager_ID`, `from_date`, `to_date`, `employee_id`, `department_id`) VALUES
(1, '2018-10-01', '2018-10-16', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL COMMENT 'Primary key to identify unique values',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL COMMENT 'M=male, F=female, O=other',
  `hire_date` date NOT NULL COMMENT 'Date employee was hired',
  `employee_number` int(11) NOT NULL COMMENT 'The employee number that the company gave',
  `password` varchar(50) DEFAULT NULL,
  `admin` int(11) DEFAULT '0' COMMENT '0 = not admin, 1 = admin',
  `title_id` int(11) NOT NULL COMMENT 'Foreign key to title table',
  `address_id` tinyint(1) NOT NULL COMMENT 'Foreign key to address table',
  `image` varchar(100) DEFAULT NULL COMMENT 'Path to the file of the image'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `gender`, `hire_date`, `employee_number`, `password`, `admin`, `title_id`, `address_id`, `image`) VALUES
(1, 'John', 'Doe', 'M', '2018-10-09', 123456789, 'password', 0, 1, 1, '../../EmployeeManager/Master/Profile_Images/samtheman.jpg'),
(2, 'Jane', 'Doe', 'F', '2018-10-16', 987654321, 'password', 0, 1, 1, '../../EmployeeManager/Master/Profile_Images/courtland.jpg'),
(3, 'Jack', 'Myer', 'M', '2018-10-16', 111222333, 'password', 1, 1, 2, '../../EmployeeManager/Master/Profile_Images/ProPics.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
  `event_id` int(11) NOT NULL COMMENT 'PK',
  `date` date NOT NULL COMMENT 'Date of the event',
  `date_end` date NOT NULL COMMENT 'Date ends',
  `name` varchar(50) NOT NULL COMMENT 'Name of the event',
  `start_time` time NOT NULL COMMENT 'Time event starts',
  `end_time` time NOT NULL COMMENT 'time event ends',
  `description` varchar(250) NOT NULL COMMENT 'The description of the event',
  `mandatory` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not, 1 = is',
  `dept_manager_ID` int(11) NOT NULL COMMENT 'The manager who schedule it'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `date`, `date_end`, `name`, `start_time`, `end_time`, `description`, `mandatory`, `dept_manager_ID`) VALUES
(11, '0000-00-00', '2018-10-03', '', '00:00:00', '00:00:00', '', 0, 1),
(12, '0000-00-00', '2018-10-04', '', '00:00:00', '00:00:00', '', 0, 1),
(13, '2018-10-16', '2018-10-19', 'NO SCHOOL', '08:00:00', '17:00:00', 'There is no school!', 1, 1),
(14, '0000-00-00', '2018-10-01', '', '00:00:00', '00:00:00', '', 0, 1),
(15, '0000-00-00', '2018-10-02', '', '00:00:00', '00:00:00', '', 0, 1),
(16, '0000-00-00', '2018-10-03', '', '00:00:00', '00:00:00', '', 0, 1),
(17, '0000-00-00', '2018-10-10', '', '00:00:00', '00:00:00', '', 0, 1),
(18, '2018-10-10', '2018-10-12', 'Training', '08:00:00', '17:00:00', 'Training for all employees.', 1, 1),
(19, '2018-10-10', '2018-10-10', 'Bake Sale', '10:00:00', '12:00:00', 'Bake sale outside our office!', 0, 1),
(20, '2018-12-20', '2018-12-21', 'Christmas Holiday Break', '08:00:00', '17:00:00', 'There will be no work held between these days for the Christmas Holidays.', 1, 1),
(21, '2018-12-24', '2018-12-26', 'No Work', '08:00:00', '17:00:00', 'Continuation of the Christmas Holiday break.', 1, 1),
(22, '2018-12-27', '2018-12-27', 'Back to Work', '08:00:00', '17:00:00', 'Resume normal work schedules on this day.', 1, 1),
(23, '2018-12-31', '2018-12-31', 'New Years Lunch-in', '12:00:00', '13:30:00', 'Hey all!\n\nWe are having a New Years lunch celebration, stop by if you want!', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pay_period`
--

DROP TABLE IF EXISTS `pay_period`;
CREATE TABLE `pay_period` (
  `pay_period_id` int(11) NOT NULL,
  `date_from` date NOT NULL COMMENT 'Date that pay period has started',
  `date_to` date NOT NULL COMMENT 'Date that pay period ends'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pay_period`
--

INSERT INTO `pay_period` (`pay_period_id`, `date_from`, `date_to`) VALUES
(1, '2018-10-08', '2018-10-19'),
(6, '2018-10-22', '2018-11-02'),
(7, '2018-11-05', '2018-11-16'),
(8, '2018-11-19', '2018-11-30'),
(9, '2018-12-03', '2018-12-14');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

DROP TABLE IF EXISTS `salaries`;
CREATE TABLE `salaries` (
  `salary_ID` int(11) NOT NULL COMMENT 'Primary key to identify unique values',
  `salary_per_hour` int(11) NOT NULL COMMENT 'Amount employee is making per hour',
  `title_id` int(11) NOT NULL COMMENT 'Foreign key to title table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`salary_ID`, `salary_per_hour`, `title_id`) VALUES
(2, 55, 1);

-- --------------------------------------------------------

--
-- Table structure for table `time_sheet`
--

DROP TABLE IF EXISTS `time_sheet`;
CREATE TABLE `time_sheet` (
  `time_id` int(11) NOT NULL,
  `number_hours` float NOT NULL COMMENT 'Number of hours submitted',
  `time_from` time NOT NULL COMMENT 'Time work started',
  `time_to` time NOT NULL COMMENT 'Time work ended',
  `date` date NOT NULL COMMENT 'Day time submitted on',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to the employee table',
  `pay_period_id` int(11) NOT NULL COMMENT 'Foreign key to the pay period'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_sheet`
--

INSERT INTO `time_sheet` (`time_id`, `number_hours`, `time_from`, `time_to`, `date`, `approved`, `employee_id`, `pay_period_id`) VALUES
(1, 1.05, '00:00:00', '00:00:00', '2018-10-17', 0, 3, 1),
(2, 0.916667, '13:05:00', '14:00:00', '2018-10-17', 0, 3, 1),
(3, 0.0333333, '13:03:00', '13:05:00', '2018-10-17', 0, 3, 1),
(4, 9, '08:00:00', '17:00:00', '2018-10-18', 0, 3, 1),
(5, 3.91667, '08:00:00', '11:55:00', '2018-10-19', 0, 3, 1),
(6, 4, '08:00:00', '12:00:00', '2018-10-18', 0, 1, 1),
(7, 2, '15:00:00', '17:00:00', '2018-10-22', 0, 3, 2),
(8, 3.8, '08:12:00', '12:00:00', '2018-10-24', 0, 3, 2),
(9, 9, '08:00:00', '17:00:00', '2018-10-30', 0, 2, 2),
(10, 9, '08:00:00', '17:00:00', '2018-11-12', 0, 3, 3),
(11, 9, '08:00:00', '17:00:00', '2018-11-19', 0, 1, 5),
(12, 4.75, '08:00:00', '12:45:00', '2018-11-22', 0, 1, 5),
(13, 9, '08:00:00', '17:00:00', '2018-11-20', 0, 3, 5),
(14, 5.5, '08:00:00', '13:30:00', '2018-11-23', 0, 3, 5),
(15, 9, '08:00:00', '17:00:00', '2018-11-19', 0, 2, 5),
(16, 4, '12:00:00', '16:00:00', '2018-11-21', 0, 2, 5),
(17, 4, '08:00:00', '12:00:00', '2018-12-03', 0, 1, 9),
(18, 4, '13:00:00', '17:00:00', '2018-12-03', 0, 1, 9),
(19, 3, '10:00:00', '13:00:00', '2018-12-04', 0, 1, 9),
(20, 4, '08:00:00', '12:00:00', '2018-12-05', 0, 1, 9),
(21, 3.75, '13:15:00', '17:00:00', '2018-12-05', 0, 1, 9),
(22, 3, '14:00:00', '17:00:00', '2018-12-06', 0, 1, 9),
(23, 5, '08:00:00', '13:00:00', '2018-12-07', 0, 1, 9),
(24, 9, '08:00:00', '17:00:00', '2018-12-03', 0, 2, 9),
(25, 1, '12:00:00', '13:00:00', '2018-12-04', 0, 2, 9),
(26, 4, '08:00:00', '12:00:00', '2018-12-05', 0, 2, 9),
(27, 2, '15:00:00', '17:00:00', '2018-12-06', 0, 2, 9),
(28, 1, '08:00:00', '09:00:00', '2018-12-03', 0, 3, 9),
(29, 5, '12:00:00', '17:00:00', '2018-12-03', 0, 3, 9),
(30, 5, '12:00:00', '17:00:00', '2018-12-05', 0, 3, 9),
(31, 8, '08:00:00', '16:00:00', '2018-12-06', 0, 3, 9),
(32, 3, '09:00:00', '12:00:00', '2018-12-07', 0, 3, 9);

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

DROP TABLE IF EXISTS `titles`;
CREATE TABLE `titles` (
  `title_id` int(11) NOT NULL COMMENT 'Primary key',
  `title` varchar(50) NOT NULL COMMENT 'Job title description'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `titles`
--

INSERT INTO `titles` (`title_id`, `title`) VALUES
(1, 'Software Developer 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_ID`);

--
-- Indexes for table `calendar`
--
ALTER TABLE `calendar`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`deptartment_id`);

--
-- Indexes for table `dept_emp`
--
ALTER TABLE `dept_emp`
  ADD PRIMARY KEY (`dept_emp_ID`);

--
-- Indexes for table `dept_manager`
--
ALTER TABLE `dept_manager`
  ADD PRIMARY KEY (`dept_manager_ID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `pay_period`
--
ALTER TABLE `pay_period`
  ADD PRIMARY KEY (`pay_period_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`salary_ID`);

--
-- Indexes for table `time_sheet`
--
ALTER TABLE `time_sheet`
  ADD PRIMARY KEY (`time_id`);

--
-- Indexes for table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`title_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `calendar`
--
ALTER TABLE `calendar`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK schedule_id';

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `deptartment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dept_emp`
--
ALTER TABLE `dept_emp`
  MODIFY `dept_emp_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dept_manager`
--
ALTER TABLE `dept_manager`
  MODIFY `dept_manager_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key to identify unique values', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK', AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pay_period`
--
ALTER TABLE `pay_period`
  MODIFY `pay_period_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `salary_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key to identify unique values', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `time_sheet`
--
ALTER TABLE `time_sheet`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `title_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`address_ID`) REFERENCES `employee` (`id`);

--
-- Constraints for table `titles`
--
ALTER TABLE `titles`
  ADD CONSTRAINT `titles_ibfk_1` FOREIGN KEY (`title_id`) REFERENCES `employee` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
