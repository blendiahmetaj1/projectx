-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 19, 2018 at 02:08 AM
-- Server version: 5.7.19
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `megod_megod`
--

-- --------------------------------------------------------

--
-- Table structure for table `god_cfg_levels`
--

DROP TABLE IF EXISTS `god_cfg_levels`;
CREATE TABLE IF NOT EXISTS `god_cfg_levels` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level` bigint(20) NOT NULL DEFAULT '0',
  `timer` bigint(20) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `monsters` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_cfg_main`
--

DROP TABLE IF EXISTS `god_cfg_main`;
CREATE TABLE IF NOT EXISTS `god_cfg_main` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `root_url` varchar(64) NOT NULL DEFAULT '',
  `images_url` varchar(64) NOT NULL DEFAULT '',
  `server` varchar(16) NOT NULL DEFAULT '',
  `paypal_email` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(32) NOT NULL DEFAULT '',
  `title_description` varchar(128) NOT NULL DEFAULT '',
  `title_descriptionb` varchar(128) NOT NULL DEFAULT '',
  `mute_time` bigint(20) NOT NULL DEFAULT '0',
  `logout_time` bigint(20) NOT NULL DEFAULT '0',
  `max_gold` bigint(20) NOT NULL DEFAULT '0',
  `admin_name` varchar(32) NOT NULL DEFAULT '',
  `col_bg` varchar(16) NOT NULL DEFAULT '',
  `col_text` varchar(16) NOT NULL DEFAULT '',
  `col_link` varchar(16) NOT NULL DEFAULT '',
  `col_hover` varchar(16) NOT NULL DEFAULT '',
  `col_form` varchar(16) NOT NULL DEFAULT '',
  `col_warning` varchar(16) NOT NULL DEFAULT '',
  `col_special` varchar(16) NOT NULL DEFAULT '',
  `font_family` varchar(64) NOT NULL DEFAULT '',
  `font_size` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `server` (`server`,`title`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_chat`
--

DROP TABLE IF EXISTS `god_chat`;
CREATE TABLE IF NOT EXISTS `god_chat` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timer` bigint(20) NOT NULL DEFAULT '0',
  `sex` varchar(8) NOT NULL DEFAULT '',
  `charname` varchar(16) NOT NULL DEFAULT '',
  `level` bigint(20) NOT NULL DEFAULT '0',
  `receiver` varchar(16) NOT NULL DEFAULT '',
  `channel` varchar(16) NOT NULL DEFAULT '',
  `message` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6200 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_feedback`
--

DROP TABLE IF EXISTS `god_feedback`;
CREATE TABLE IF NOT EXISTS `god_feedback` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timer` bigint(20) NOT NULL DEFAULT '0',
  `file` varchar(64) NOT NULL DEFAULT '',
  `feedback` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_items`
--

DROP TABLE IF EXISTS `god_items`;
CREATE TABLE IF NOT EXISTS `god_items` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `charname` varchar(16) NOT NULL DEFAULT '',
  `kind` varchar(16) NOT NULL DEFAULT '',
  `power` varchar(16) NOT NULL DEFAULT '0',
  `bonus` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `timer` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84126 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_logs`
--

DROP TABLE IF EXISTS `god_logs`;
CREATE TABLE IF NOT EXISTS `god_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timer` bigint(20) NOT NULL DEFAULT '0',
  `day` bigint(20) NOT NULL DEFAULT '0',
  `month` bigint(20) NOT NULL DEFAULT '0',
  `year` bigint(20) NOT NULL DEFAULT '0',
  `ip` varchar(128) NOT NULL DEFAULT '',
  `username` varchar(16) NOT NULL DEFAULT '',
  `charname` varchar(16) NOT NULL DEFAULT '',
  `file` varchar(32) NOT NULL DEFAULT '',
  `action` varchar(64) NOT NULL DEFAULT '',
  `exp` bigint(20) NOT NULL DEFAULT '0',
  `credits` bigint(20) NOT NULL DEFAULT '0',
  `miscs` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_messages`
--

DROP TABLE IF EXISTS `god_messages`;
CREATE TABLE IF NOT EXISTS `god_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timer` bigint(20) NOT NULL DEFAULT '0',
  `charname` varchar(16) NOT NULL DEFAULT '',
  `receiver` varchar(16) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_paper`
--

DROP TABLE IF EXISTS `god_paper`;
CREATE TABLE IF NOT EXISTS `god_paper` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `timer` int(11) NOT NULL DEFAULT '0',
  `charname` varchar(16) NOT NULL DEFAULT '',
  `news` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67548 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `god_players`
--

DROP TABLE IF EXISTS `god_players`;
CREATE TABLE IF NOT EXISTS `god_players` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timer` bigint(20) NOT NULL DEFAULT '0',
  `x` bigint(20) NOT NULL DEFAULT '0',
  `y` bigint(20) NOT NULL DEFAULT '0',
  `quest` bigint(20) NOT NULL DEFAULT '0',
  `ip` varchar(64) NOT NULL DEFAULT '',
  `lastip` varchar(64) NOT NULL DEFAULT '',
  `fail` tinyint(4) NOT NULL DEFAULT '0',
  `failip` varchar(64) NOT NULL DEFAULT '',
  `username` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `clan` varchar(8) NOT NULL DEFAULT '',
  `sex` varchar(8) NOT NULL DEFAULT '',
  `charname` varchar(16) NOT NULL DEFAULT '',
  `god` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `credits` bigint(20) NOT NULL DEFAULT '0',
  `level` bigint(20) NOT NULL DEFAULT '0',
  `exp` bigint(20) NOT NULL DEFAULT '0',
  `gold` bigint(20) NOT NULL DEFAULT '0',
  `life` bigint(20) NOT NULL DEFAULT '0',
  `stamina` bigint(20) NOT NULL DEFAULT '0',
  `mana` bigint(20) NOT NULL DEFAULT '0',
  `stealth` bigint(20) NOT NULL DEFAULT '0',
  `damage` bigint(20) NOT NULL DEFAULT '0',
  `rating` bigint(20) NOT NULL DEFAULT '0',
  `defense` bigint(20) NOT NULL DEFAULT '0',
  `speed` bigint(20) NOT NULL DEFAULT '0',
  `bonus` bigint(20) NOT NULL DEFAULT '0',
  `mute` bigint(20) NOT NULL DEFAULT '0',
  `jail` bigint(20) NOT NULL DEFAULT '0',
  `dead` bigint(20) NOT NULL DEFAULT '0',
  `session` decimal(20,2) NOT NULL DEFAULT '0.00',
  `friend` varchar(16) NOT NULL DEFAULT '',
  `ticket` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `charname` (`charname`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=4654 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
