-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2013 at 03:10 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: 'routerboard'
--
CREATE DATABASE routerboard DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE routerboard;

-- --------------------------------------------------------

--
-- Table structure for table 'group'
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  group_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  group_name varchar(25) NOT NULL,
  PRIMARY KEY (group_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table 'group'
--

INSERT INTO `group` (group_id, group_name) VALUES
(1, 'Integrated solutions'),
(2, 'RouterBOARD'),
(3, 'Enclosures'),
(4, 'Interfaces'),
(5, 'Accessories'),
(6, 'Product archive');

-- --------------------------------------------------------

--
-- Table structure for table 'product'
--

DROP TABLE IF EXISTS product;
CREATE TABLE IF NOT EXISTS product (
  product_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  description text NOT NULL,
  price decimal(10,2) NOT NULL,
  group_id int(10) unsigned NOT NULL,
  PRIMARY KEY (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table 'user'
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  user_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  user_name varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  deleted tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
