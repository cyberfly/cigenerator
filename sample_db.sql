-- phpMyAdmin SQL Dump
-- version 2.11.9.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2013 at 06:16 PM
-- Server version: 5.1.67
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `sample_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_brand`
--

CREATE TABLE IF NOT EXISTS `tb_brand` (
  `brand_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(40) NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `tb_category`
--

CREATE TABLE IF NOT EXISTS `tb_category` (
  `category_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `product_group_id` smallint(5) NOT NULL COMMENT 'FK',
  `category_name` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `tb_product_group`
--

CREATE TABLE IF NOT EXISTS `tb_product_group` (
  `product_group_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(40) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`product_group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `tb_repair_product`
--

CREATE TABLE IF NOT EXISTS `tb_repair_product` (
  `repair_product_id` int(5) NOT NULL AUTO_INCREMENT,
  `product_group_id` smallint(5) NOT NULL,
  `category_id` smallint(5) NOT NULL,
  `brand_id` smallint(5) NOT NULL,
  `dealer_id` int(5) NOT NULL DEFAULT '0',
  `product_model` varchar(20) NOT NULL,
  `serial_no` varchar(30) DEFAULT NULL,
  `serial_no_2` varchar(60) NOT NULL COMMENT 'also imei_no',
  `price` double(10,2) NOT NULL DEFAULT '0.00',
  `description` varchar(60) DEFAULT NULL,
  `product_address` text NOT NULL,
  `date_purchase` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`repair_product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tb_repair_product`
--


