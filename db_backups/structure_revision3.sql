-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2016 at 02:14 PM
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
  `UserId` bigint(20) unsigned NOT NULL COMMENT 'User unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Administrators`
--

INSERT INTO `Administrators` (`UserId`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `Assignments`
--

CREATE TABLE IF NOT EXISTS `Assignments` (
`AssignmentId` bigint(20) unsigned NOT NULL COMMENT 'Assignment unique id',
  `AssignmentName` varchar(256) NOT NULL COMMENT 'Name of the assignment',
  `CourseId` bigint(20) unsigned NOT NULL COMMENT 'Course unique id',
  `DateModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timestamp the assignment was last modified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Instructor created assignment information';

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
  `AssignmentId` bigint(20) unsigned NOT NULL COMMENT 'Assignment unique id',
  `UserId` bigint(20) unsigned NOT NULL COMMENT 'User unique id',
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp the document was added'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='User uploaded document information';

-- --------------------------------------------------------

--
-- Table structure for table `Instructors`
--

CREATE TABLE IF NOT EXISTS `Instructors` (
  `UserId` bigint(20) unsigned NOT NULL COMMENT 'User unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users that are instructors';

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE IF NOT EXISTS `Students` (
  `UserId` bigint(20) unsigned NOT NULL COMMENT 'User unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users that are students';

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
`UserId` bigint(20) unsigned NOT NULL COMMENT 'User unique id',
  `Email` varchar(255) NOT NULL COMMENT 'UMBC email address',
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp the user was added to the system'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Information on the users';

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserId`, `Email`, `DateAdded`) VALUES
(1, 'g60@umbc.edu', '2016-04-03 18:11:17'),
(2, 'tadams2@umbc.edu', '2016-04-02 01:42:04'),
(3, 'vkonen1@umbc.edu', '2016-04-01 22:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `Users_Courses`
--

CREATE TABLE IF NOT EXISTS `Users_Courses` (
  `UserId` bigint(20) unsigned NOT NULL COMMENT 'User unique id',
  `CourseId` bigint(20) unsigned NOT NULL COMMENT 'Course unique id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Associates users with courses';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Administrators`
--
ALTER TABLE `Administrators`
 ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `Assignments`
--
ALTER TABLE `Assignments`
 ADD PRIMARY KEY (`AssignmentId`), ADD UNIQUE KEY `AssignmentId` (`AssignmentId`), ADD KEY `CourseId` (`CourseId`);

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
 ADD PRIMARY KEY (`CourseId`), ADD UNIQUE KEY `CourseId` (`CourseId`);

--
-- Indexes for table `Documents`
--
ALTER TABLE `Documents`
 ADD PRIMARY KEY (`DocumentId`), ADD UNIQUE KEY `DocumentId` (`DocumentId`), ADD KEY `AssignmentId` (`AssignmentId`), ADD KEY `GoogleId` (`UserId`), ADD KEY `Email` (`UserId`);

--
-- Indexes for table `Instructors`
--
ALTER TABLE `Instructors`
 ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
 ADD PRIMARY KEY (`UserId`), ADD KEY `Email` (`UserId`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
 ADD PRIMARY KEY (`UserId`), ADD UNIQUE KEY `UserId_2` (`UserId`), ADD KEY `Email` (`Email`), ADD KEY `UserId` (`UserId`), ADD KEY `UserId_3` (`UserId`);

--
-- Indexes for table `Users_Courses`
--
ALTER TABLE `Users_Courses`
 ADD KEY `CourseId` (`CourseId`), ADD KEY `Email` (`UserId`), ADD KEY `CourseId_2` (`CourseId`);

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
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
MODIFY `UserId` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User unique id',AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Assignments`
--
ALTER TABLE `Assignments`
ADD CONSTRAINT `Assignment_Course` FOREIGN KEY (`CourseId`) REFERENCES `Courses` (`CourseId`);

--
-- Constraints for table `Documents`
--
ALTER TABLE `Documents`
ADD CONSTRAINT `User_Document` FOREIGN KEY (`UserId`) REFERENCES `Users` (`UserId`),
ADD CONSTRAINT `Assginment_Document` FOREIGN KEY (`AssignmentId`) REFERENCES `Assignments` (`AssignmentId`);

--
-- Constraints for table `Users_Courses`
--
ALTER TABLE `Users_Courses`
ADD CONSTRAINT `Course` FOREIGN KEY (`CourseId`) REFERENCES `Courses` (`CourseId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
