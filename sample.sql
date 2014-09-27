-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 09, 2014 at 05:47 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------

--
-- Table structure for table `arrivals`
--

CREATE TABLE IF NOT EXISTS `arrivals` (
  `aid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `time` decimal(14,4) unsigned NOT NULL,
  `oid` int(6) unsigned NOT NULL,
  `category` enum('E/D','FLOOR') COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(5,2) DEFAULT NULL,
  `pid` int(6) unsigned DEFAULT NULL,
  `fullname` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `did` int(6) unsigned DEFAULT NULL,
  `type` enum('P','PL','RR') COLLATE utf8_unicode_ci DEFAULT NULL,
  `reason` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reversed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  UNIQUE KEY `time` (`time`),
  KEY `oid` (`oid`),
  KEY `category` (`category`),
  KEY `pid` (`pid`),
  KEY `did` (`did`),
  KEY `type` (`type`),
  KEY `reversed` (`reversed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `copartnerships`
--

CREATE TABLE IF NOT EXISTS `copartnerships` (
  `cid` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(6) unsigned NOT NULL,
  `since` int(10) unsigned NOT NULL,
  `expiration` int(10) unsigned NOT NULL,
  `bio` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `pid` (`pid`),
  KEY `cancelled` (`cancelled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE IF NOT EXISTS `designations` (
  `did` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `eid` int(4) unsigned NOT NULL,
  `begin` int(10) unsigned NOT NULL,
  `end` int(10) unsigned NOT NULL,
  `note` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reason` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`did`),
  KEY `eid` (`eid`,`cancelled`),
  KEY `cancelled` (`cancelled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eid` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `category` enum('C','P','S','R','MIX') COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `lid` int(2) unsigned NOT NULL,
  `level` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(5,2) unsigned DEFAULT NULL,
  `discount` decimal(5,2) unsigned DEFAULT NULL,
  `pricenote` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `discountnote` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `repetition` enum('W','W1','W2','W3','W4','W5') COLLATE utf8_unicode_ci DEFAULT NULL,
  `frequency` enum('MON','TUE','WED','THU','FRI','SAT','SUN') COLLATE utf8_unicode_ci DEFAULT NULL,
  `begindate` int(10) unsigned DEFAULT NULL,
  `enddate` int(10) unsigned DEFAULT NULL,
  `begintime` int(10) unsigned DEFAULT NULL,
  `endtime` int(10) unsigned DEFAULT NULL,
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`),
  KEY `label` (`label`),
  KEY `category` (`category`),
  KEY `lid` (`lid`),
  KEY `level` (`level`),
  KEY `account` (`account`),
  KEY `repetition` (`repetition`),
  KEY `frequency` (`frequency`),
  KEY `cancelled` (`cancelled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `fid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `checksum` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `gid` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `removed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`),
  KEY `removed` (`removed`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`gid`, `name`, `removed`) VALUES
(1, 'SALSA', 0),
(2, 'BACHATA', 0),
(3, 'KIZOMBA', 0),
(4, 'ARGENTINE TANGO', 0),
(5, 'TANGO', 0),
(6, 'WALTZ', 0),
(7, 'BOLERO', 0),
(8, 'FOXTROT', 0),
(9, 'RUMBA', 0),
(10, 'JIVE', 0),
(11, 'SAMBA', 0),
(12, 'NIGHT CLUB TWO STEP', 0),
(13, 'HUSTLE', 0),
(14, 'VIENNESE WALTZ', 0),
(15, 'EAST COAST SWING', 0),
(16, 'WEST COAST SWING', 0),
(17, 'CHA CHA CHA', 0),
(18, 'QUICKSTEP', 0),
(19, 'COUNTRY TWO STEP', 0),
(20, 'PASO DOBLE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `instructions`
--

CREATE TABLE IF NOT EXISTS `instructions` (
  `iid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `category` enum('P','G/E','G/D') COLLATE utf8_unicode_ci NOT NULL,
  `eid` int(4) unsigned DEFAULT NULL,
  `did` int(6) unsigned DEFAULT NULL,
  `pid` int(6) unsigned DEFAULT NULL,
  `gid` int(2) unsigned DEFAULT NULL,
  `removed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`iid`),
  KEY `category` (`category`),
  KEY `eid` (`eid`),
  KEY `did` (`did`),
  KEY `pid` (`pid`),
  KEY `gid` (`gid`),
  KEY `removed` (`removed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `jid` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `category` enum('BOD','MANAGEMENT','HOST','DJ','TAXI') COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(6) unsigned NOT NULL,
  `expiration` int(10) unsigned NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `bio` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reason` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `removed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`jid`),
  KEY `category` (`category`),
  KEY `pid` (`pid`),
  KEY `removed` (`removed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `lid` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lid`),
  KEY `disabled` (`disabled`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`lid`, `name`, `disabled`) VALUES
(1, 'MAIN', 0);

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
  `mid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('A','R','S') COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(6) unsigned NOT NULL,
  `since` int(10) unsigned NOT NULL,
  `expiration` int(10) unsigned NOT NULL,
  `amount` decimal(5,2) DEFAULT NULL,
  `oid` int(6) unsigned DEFAULT NULL,
  `reason` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`),
  KEY `type` (`type`),
  KEY `pid` (`pid`),
  KEY `oid` (`oid`),
  KEY `cancelled` (`cancelled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE IF NOT EXISTS `notices` (
  `nid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `message` varchar(500) DEFAULT NULL,
  `removed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`nid`),
  KEY `removed` (`removed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `oid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `category` enum('A','M') NOT NULL,
  `tid` int(6) unsigned DEFAULT NULL,
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`oid`),
  KEY `category` (`category`),
  KEY `tid` (`tid`),
  KEY `cancelled` (`cancelled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `pid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` int(5) unsigned DEFAULT NULL,
  `email` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `cellphone` bigint(10) unsigned DEFAULT NULL,
  `homephone` bigint(10) unsigned DEFAULT NULL,
  `emergencyphone` bigint(10) unsigned DEFAULT NULL,
  `birthmonth` enum('1','2','3','4','5','6','7','8','9','10','11','12') COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fid` int(5) unsigned DEFAULT NULL,
  `reason` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `fid` (`fid`),
  KEY `card` (`card`),
  KEY `lastname` (`lastname`),
  KEY `zipcode` (`zipcode`),
  KEY `email` (`email`),
  KEY `cellphone` (`cellphone`),
  KEY `birthmonth` (`birthmonth`),
  KEY `disabled` (`disabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE IF NOT EXISTS `reminders` (
  `rid` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(10) unsigned NOT NULL,
  `fid` int(5) unsigned NOT NULL,
  `removed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`),
  KEY `fid` (`fid`),
  KEY `removed` (`removed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sponsorships`
--

CREATE TABLE IF NOT EXISTS `sponsorships` (
  `sid` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `amount` decimal(6,2) unsigned NOT NULL,
  `available` decimal(6,2) unsigned NOT NULL,
  `cancelled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `cancelled` (`cancelled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `tid` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `time` decimal(14,4) unsigned NOT NULL,
  `payment` enum('CA/CHK','CC/DC') COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(6,2) unsigned NOT NULL,
  `reference` varchar(27) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vid` int(5) unsigned DEFAULT NULL,
  `sid` int(4) unsigned DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `time` (`time`),
  KEY `payment` (`payment`),
  KEY `reference` (`reference`),
  KEY `vid` (`vid`),
  KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `permission` enum('D','O','S','A') COLLATE utf8_unicode_ci NOT NULL,
  `suspended` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`),
  KEY `permission` (`permission`),
  KEY `suspended` (`suspended`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `values`
--

CREATE TABLE IF NOT EXISTS `values` (
  `vid` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('G','P') COLLATE utf8_unicode_ci NOT NULL,
  `expiration` int(10) DEFAULT NULL,
  `redeemed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`vid`),
  UNIQUE KEY `code` (`code`),
  KEY `type` (`type`),
  KEY `redeemed` (`redeemed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `_logs`
--

/*CREATE TABLE IF NOT EXISTS `_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `activity` int(10) unsigned NOT NULL,
  `user_query` mediumtext NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;*/

-- --------------------------------------------------------

--
-- Table structure for table `_sessions`
--

CREATE TABLE IF NOT EXISTS `_sessions` (
  `session_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
