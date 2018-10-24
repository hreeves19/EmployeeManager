-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2018 at 03:41 AM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

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
(1, '1773 Ennis Joslin Rd', 'Corpus Christi', 78412, 'Tx', 'United States'),
(2, '2921 Airline Rd Apartment 325', 'Corpus Christi', 78414, 'Tx', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE `calendar` (
  `schedule_id` int(11) NOT NULL COMMENT 'PK schedule_id',
  `date` date NOT NULL COMMENT 'Date scheduled',
  `mandatory` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not mandatory, 1 = is mandatory',
  `time_start` time NOT NULL COMMENT 'Time the event starts',
  `time_end` time NOT NULL COMMENT 'Time the event ends',
  `event_id` int(11) NOT NULL COMMENT 'FK to the event table',
  `employee_id` int(11) NOT NULL COMMENT 'FK to the employees table, the employee attached to this'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

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
(1, '2018-10-01', '2018-10-23', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dept_manager`
--

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
  `adress_id` tinyint(1) NOT NULL COMMENT 'Foreign key to address table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `gender`, `hire_date`, `employee_number`, `password`, `admin`, `title_id`, `adress_id`) VALUES
(1, 'John', 'Doe', 'M', '2018-10-09', 123456789, 'password', 0, 1, 1),
(2, 'Jane', 'Doe', 'F', '2018-10-16', 987654321, 'password', 0, 1, 1),
(3, 'Jack', 'Myer', 'M', '2018-10-16', 111222333, 'password', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL COMMENT 'PK',
  `name` varchar(50) NOT NULL COMMENT 'Name of the event',
  `start_time` time NOT NULL COMMENT 'Time event starts',
  `end_time` time NOT NULL COMMENT 'time event ends',
  `description` varchar(250) NOT NULL COMMENT 'The description of the event',
  `mandatory` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not, 1 = is',
  `dept_manager_ID` int(11) NOT NULL COMMENT 'The manager who schedule it'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pay_period`
--

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
(2, '2018-10-22', '2018-11-02');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

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

CREATE TABLE `time_sheet` (
  `time_id` int(11) NOT NULL,
  `number_hours` float NOT NULL COMMENT 'Number of hours submitted',
  `time_from` time NOT NULL COMMENT 'Time work started',
  `time_to` time NOT NULL COMMENT 'Time work ended',
  `date` date NOT NULL COMMENT 'Day time submitted on',
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to the employee table',
  `pay_period_id` int(11) NOT NULL COMMENT 'Foreign key to the pay period'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `time_sheet`
--

INSERT INTO `time_sheet` (`time_id`, `number_hours`, `time_from`, `time_to`, `date`, `employee_id`, `pay_period_id`) VALUES
(1, 1.05, '00:00:00', '00:00:00', '2018-10-17', 3, 1),
(2, 0.916667, '13:05:00', '14:00:00', '2018-10-17', 3, 1),
(3, 0.0333333, '13:03:00', '13:05:00', '2018-10-17', 3, 1),
(4, 9, '08:00:00', '17:00:00', '2018-10-18', 3, 1),
(5, 3.91667, '08:00:00', '11:55:00', '2018-10-19', 3, 1),
(6, 4, '08:00:00', '12:00:00', '2018-10-18', 1, 1),
(7, 2, '15:00:00', '17:00:00', '2018-10-22', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

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
  MODIFY `dept_emp_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key', AUTO_INCREMENT=2;

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
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK';

--
-- AUTO_INCREMENT for table `pay_period`
--
ALTER TABLE `pay_period`
  MODIFY `pay_period_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `salary_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key to identify unique values', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `time_sheet`
--
ALTER TABLE `time_sheet`
  MODIFY `time_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
