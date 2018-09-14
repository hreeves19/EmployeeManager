-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2018 at 03:36 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

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

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `deptartment_id` int(11) NOT NULL,
  `department_number` int(11) DEFAULT NULL COMMENT 'Department number given by company',
  `department_name` varchar(50) NOT NULL COMMENT 'Name of the department'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dept_emp`
--

CREATE TABLE `dept_emp` (
  `dept_emp_ID` int(11) NOT NULL COMMENT 'Primary key',
  `department_id` int(11) NOT NULL COMMENT 'Foreign key to the departments table',
  `from_date` varchar(50) NOT NULL COMMENT 'Day employee started working for the department',
  `to_date` varchar(50) NOT NULL COMMENT 'till this point'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dept_manager`
--

CREATE TABLE `dept_manager` (
  `dept_manager_ID` int(11) NOT NULL COMMENT 'Primary Key',
  `employee_id` int(11) NOT NULL COMMENT 'Foreign key to the employee table',
  `from_date` varchar(50) NOT NULL COMMENT 'Day manager started for department',
  `to_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL COMMENT 'Primary key to identify unique values',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL COMMENT 'M=male, F=female, O=other',
  `hire_date` varchar(25) NOT NULL COMMENT 'Date employee was hired',
  `adress_id` tinyint(1) NOT NULL COMMENT 'Foreign key to address table',
  `employee_number` int(11) NOT NULL COMMENT 'The employee number that the company gave'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `address_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `deptartment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dept_emp`
--
ALTER TABLE `dept_emp`
  MODIFY `dept_emp_ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key';

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Primary key to identify unique values';

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
