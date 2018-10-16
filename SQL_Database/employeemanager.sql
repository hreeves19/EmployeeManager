-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2018 at 11:39 PM
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
  `from_date` varchar(50) NOT NULL COMMENT 'Day employee started working for the department',
  `to_date` varchar(50) NOT NULL COMMENT 'till this point',
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to employee table',
  `department_id` int(11) NOT NULL COMMENT 'Foreign key to the departments table',
  `dept_manager_id` int(11) NOT NULL COMMENT 'Foreign key to the dept_manager table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `adress_id` tinyint(1) NOT NULL COMMENT 'Foreign key to address table',
  `employee_number` int(11) NOT NULL COMMENT 'The employee number that the company gave',
  `password` varchar(50) DEFAULT NULL,
  `admin` int(11) DEFAULT '0' COMMENT '0 = not admin, 1 = admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `gender`, `hire_date`, `adress_id`, `employee_number`, `password`, `admin`) VALUES
(1, 'John', 'Doe', 'M', '2018-10-09', 1, 123456789, 'password', 0),
(2, 'Jane', 'Doe', 'F', '2018-10-16', 1, 987654321, 'password', 0),
(3, 'Jack', 'Myer', 'M', '2018-10-16', 2, 111222333, 'password', 1);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `salary_ID` int(11) NOT NULL COMMENT 'Primary key to identify unique values',
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to foreign table',
  `salary` int(11) NOT NULL COMMENT 'Amount employee is making',
  `from_date` varchar(50) NOT NULL,
  `to_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `titles`
--

CREATE TABLE `titles` (
  `title_id` int(11) NOT NULL COMMENT 'Primary key',
  `title` varchar(50) NOT NULL COMMENT 'Job title description',
  `from_date` varchar(50) NOT NULL COMMENT 'Day title was given',
  `to_date` varchar(50) NOT NULL COMMENT 'Day title was ended/changed',
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to employee table'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_ID`);

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
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`salary_ID`);

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
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `deptartment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dept_emp`
--
ALTER TABLE `dept_emp`
  MODIFY `dept_emp_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

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
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `salary_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key to identify unique values';

--
-- AUTO_INCREMENT for table `titles`
--
ALTER TABLE `titles`
  MODIFY `title_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
