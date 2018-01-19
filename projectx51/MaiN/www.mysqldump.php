<?php
/*
-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:3306
-- Generation Time: Jan 14, 2008 at 05:46 AM
-- Server version: 4.1.22
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `projectx5`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `lol_members`
-- 

CREATE TABLE IF NOT EXISTS `lol_members` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(10) NOT NULL default '',
  `password` varchar(10) NOT NULL default '',
  `email` varchar(32) NOT NULL default '',
  `clan` char(3) NOT NULL default '',
  `charname` varchar(10) NOT NULL default '',
  `session` decimal(20,2) unsigned NOT NULL default '0.00',
  `timer` decimal(20,2) unsigned NOT NULL default '0.00',
  `money` bigint(20) NOT NULL default '0',
  `x` smallint(6) NOT NULL default '0',
  `y` smallint(6) NOT NULL default '0',
  `x0` int(11) NOT NULL default '0',
  `x1` int(11) NOT NULL default '0',
  `x2` int(11) NOT NULL default '0',
  `x3` int(11) NOT NULL default '0',
  `x4` int(11) NOT NULL default '0',
  `x5` int(11) NOT NULL default '0',
  `x6` int(11) NOT NULL default '0',
  `x7` int(11) NOT NULL default '0',
  `x8` int(11) NOT NULL default '0',
  `x9` int(11) NOT NULL default '0',
  `x10` int(11) NOT NULL default '0',
  `x11` int(11) NOT NULL default '0',
  `x12` int(11) NOT NULL default '0',
  `x13` int(11) NOT NULL default '0',
  `x14` int(11) NOT NULL default '0',
  `x15` int(11) NOT NULL default '0',
  `x16` int(11) NOT NULL default '0',
  `x17` int(11) NOT NULL default '0',
  `x18` int(11) NOT NULL default '0',
  `x19` int(11) NOT NULL default '0',
  `x20` int(11) NOT NULL default '0',
  `x21` int(11) NOT NULL default '0',
  `x22` int(11) NOT NULL default '0',
  `x23` int(11) NOT NULL default '0',
  `x24` int(11) NOT NULL default '0',
  `x25` int(11) NOT NULL default '0',
  `x26` int(11) NOT NULL default '0',
  `x27` int(11) NOT NULL default '0',
  `x28` int(11) NOT NULL default '0',
  `x29` int(11) NOT NULL default '0',
  `x30` int(11) NOT NULL default '0',
  `x31` int(11) NOT NULL default '0',
  `x32` int(11) NOT NULL default '0',
  `x33` int(11) NOT NULL default '0',
  `x34` int(11) NOT NULL default '0',
  `x35` int(11) NOT NULL default '0',
  `x36` int(11) NOT NULL default '0',
  `x37` int(11) NOT NULL default '0',
  `x38` int(11) NOT NULL default '0',
  `x39` int(11) NOT NULL default '0',
  `x40` int(11) NOT NULL default '0',
  `x41` int(11) NOT NULL default '0',
  `x42` int(11) NOT NULL default '0',
  `x43` int(11) NOT NULL default '0',
  `x44` int(11) NOT NULL default '0',
  `x45` int(11) NOT NULL default '0',
  `x46` int(11) NOT NULL default '0',
  `x47` int(11) NOT NULL default '0',
  `x48` int(11) NOT NULL default '0',
  `x49` int(11) NOT NULL default '0',
  `x50` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `charname` (`charname`),
  KEY `timer` (`timer`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `lol_members`
-- 

CREATE TABLE IF NOT EXISTS `lol_location` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `mid` int(11) NOT NULL default '0',
  `timer` decimal(20,2) unsigned NOT NULL default '0.00',
  `x` smallint(6) NOT NULL default '0',
  `y` smallint(6) NOT NULL default '0',
  `x0` int(11) NOT NULL default '0',
  `x1` int(11) NOT NULL default '0',
  `x2` int(11) NOT NULL default '0',
  `x3` int(11) NOT NULL default '0',
  `x4` int(11) NOT NULL default '0',
  `x5` int(11) NOT NULL default '0',
  `x6` int(11) NOT NULL default '0',
  `x7` int(11) NOT NULL default '0',
  `x8` int(11) NOT NULL default '0',
  `x9` int(11) NOT NULL default '0',
    PRIMARY KEY  (`id`),
  KEY `timer` (`timer`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `lol_members` (`id`, `username`, `password`, `email`, `clan`, `charname`, `session`, `timer`, `money`, `x`, `y`, `x0`, `x1`, `x2`, `x3`, `x4`, `x5`, `x6`, `x7`, `x8`, `x9`, `x10`, `x11`, `x12`, `x13`, `x14`, `x15`, `x16`, `x17`, `x18`, `x19`, `x20`, `x21`, `x22`, `x23`, `x24`, `x25`, `x26`, `x27`, `x28`, `x29`, `x30`, `x31`, `x32`, `x33`, `x34`, `x35`, `x36`, `x37`, `x38`, `x39`, `x40`, `x41`, `x42`, `x43`, `x44`, `x45`, `x46`, `x47`, `x48`, `x49`, `x50`) VALUES 
(1, 'demo', 'demo', 'demo', '', 'demo', 1200315360.00, 1200318099.00, 14824, 500, 500, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
*/
?>