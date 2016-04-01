-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 01, 2016 at 03:44 PM
-- Server version: 5.5.44-0+deb8u1
-- PHP Version: 5.6.17-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cmsc447`
--

-- --------------------------------------------------------

--
-- Table structure for table `Administrators`
--

CREATE TABLE IF NOT EXISTS `Administrators` (
  `GoogleId` varchar(21) NOT NULL COMMENT 'Google account user id number'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users with administrator privledges';

-- --------------------------------------------------------

--
-- Table structure for table `Assignments`
--

CREATE TABLE IF NOT EXISTS `Assignments` (
`AssignmentId` bigint(20) unsigned NOT NULL COMMENT 'Assignment unique id',
  `AssignmentName` varchar(256) NOT NULL COMMENT 'Name of the assignment',
  `DateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp the assignment was last modified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Instructor created assignment information';

-- --------------------------------------------------------

--
-- Table structure for table `Assignments_Courses`
--

CREATE TABLE IF NOT EXISTS `Assignments_Courses` (
  `AssignmentId` bigint(20) unsigned NOT NULL COMMENT 'Assignment unique id',
  `CourseId` bigint(20) NOT NULL COMMENT 'Course unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Associates assignments with courses';

-- --------------------------------------------------------

--
-- Table structure for table `Assignments_Documents`
--

CREATE TABLE IF NOT EXISTS `Assignments_Documents` (
  `AssignmentId` bigint(20) unsigned NOT NULL COMMENT 'Assignment unique id',
  `DocumentId` bigint(20) unsigned NOT NULL COMMENT 'Document unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Associates assignments with documents';

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE IF NOT EXISTS `Courses` (
`CourseId` bigint(20) unsigned NOT NULL COMMENT 'Course unique id',
  `CourseName` tinytext NOT NULL COMMENT 'Name of the course',
  `CourseDesc` tinytext NOT NULL COMMENT 'Description of the course',
  `DateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp the course was last modified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Administrator created course information';

-- --------------------------------------------------------

--
-- Table structure for table `Documents`
--

CREATE TABLE IF NOT EXISTS `Documents` (
`DocumentId` bigint(20) unsigned NOT NULL COMMENT 'Unique document id',
  `DocumentName` varchar(20) NOT NULL COMMENT 'Name of the document',
  `DocumentType` tinytext NOT NULL COMMENT 'The type of document',
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp the document was added'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User uploaded document information';

-- --------------------------------------------------------

--
-- Table structure for table `Instructors`
--

CREATE TABLE IF NOT EXISTS `Instructors` (
  `GoogleId` varchar(21) NOT NULL COMMENT 'Google account user id number'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users that are instructors';

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `GoogleId` varchar(21) NOT NULL COMMENT 'Google account user id number'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users that are students';

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `GoogleId` varchar(21) NOT NULL COMMENT '21 character google user id number',
  `Email` varchar(18) NOT NULL COMMENT 'UMBC email address',
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp the user was added to the system'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Information on the users';

-- --------------------------------------------------------

--
-- Table structure for table `Users_Courses`
--

CREATE TABLE IF NOT EXISTS `Users_Courses` (
  `GoogleId` varchar(21) NOT NULL COMMENT 'Google account user id number',
  `CourseId` bigint(20) unsigned NOT NULL COMMENT 'Course unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Associates users with courses';

-- --------------------------------------------------------

--
-- Table structure for table `Users_Documents`
--

CREATE TABLE IF NOT EXISTS `Users_Documents` (
  `GoogleId` varchar(21) NOT NULL COMMENT 'Google account user id number',
  `DocumentId` bigint(20) unsigned NOT NULL COMMENT 'Document unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Associates users with documents';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Administrators`
--
ALTER TABLE `Administrators`
 ADD PRIMARY KEY (`GoogleId`);

--
-- Indexes for table `Assignments`
--
ALTER TABLE `Assignments`
 ADD PRIMARY KEY (`AssignmentId`), ADD UNIQUE KEY `AssignmentId` (`AssignmentId`);

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
 ADD PRIMARY KEY (`CourseId`), ADD UNIQUE KEY `CourseId` (`CourseId`);

--
-- Indexes for table `Documents`
--
ALTER TABLE `Documents`
 ADD PRIMARY KEY (`DocumentId`), ADD UNIQUE KEY `DocumentId` (`DocumentId`);

--
-- Indexes for table `Instructors`
--
ALTER TABLE `Instructors`
 ADD PRIMARY KEY (`GoogleId`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
 ADD PRIMARY KEY (`GoogleId`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
 ADD PRIMARY KEY (`GoogleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Assignments`
--
ALTER TABLE `Assignments`
MODIFY `AssignmentId` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Assignment unique id';
--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
MODIFY `CourseId` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Course unique id';
--
-- AUTO_INCREMENT for table `Documents`
--
ALTER TABLE `Documents`
MODIFY `DocumentId` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique document id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
