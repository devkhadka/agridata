-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2011 at 01:06 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `agricare_nepal`
--

-- --------------------------------------------------------

--
-- Table structure for table `syn_access`
--

CREATE TABLE IF NOT EXISTS `syn_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `access_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_collection_plan`
--

CREATE TABLE IF NOT EXISTS `syn_collection_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `party_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `syn_party_due`
--
CREATE TABLE IF NOT EXISTS `syn_party_due` (
`id` int(11)  NOT NULL AUTO_INCREMENT,
`collected_date` date NOT NULL,
`amount` decimal(10,2)  NOT NULL,
`party_id` int(11)  NOT NULL,
`created_by` int(11) NOT NULL,
`created_at` date NOT NULL,
 PRIMARY KEY (`id`)
)ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;
-- --------------------------------------------------------

--
-- Table structure for table `syn_customertitle`
--

CREATE TABLE IF NOT EXISTS `syn_customertitle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_dcr`
--

CREATE TABLE IF NOT EXISTS `syn_dcr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collected_date` date NOT NULL,
  `name` varchar(100) NOT NULL,
  `customer_title_id` int(11) NOT NULL,
  `remark` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `approved_date` datetime NOT NULL,
  `approved_by` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_headquater`
--

CREATE TABLE IF NOT EXISTS `syn_headquater` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_infotitle`
--

CREATE TABLE IF NOT EXISTS `syn_infotitle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `regexp` varchar(255) NOT NULL,
  `importance` varchar(10) NOT NULL,
  `visibility` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_infovalues`
--

CREATE TABLE IF NOT EXISTS `syn_infovalues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `info_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_material`
--

CREATE TABLE IF NOT EXISTS `syn_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `unit` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_ndprice`
--

CREATE TABLE IF NOT EXISTS `syn_ndprice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `price` varchar(10) NOT NULL,
  `effective_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_news`
--

CREATE TABLE IF NOT EXISTS `syn_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `date` date NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_party`
--

CREATE TABLE IF NOT EXISTS `syn_party` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_partystock`
--

CREATE TABLE IF NOT EXISTS `syn_partystock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collected_date` date NOT NULL,
  `party_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `no_of_case` int(11) NOT NULL,
  `indivisual` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=165 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_party_due`
--

CREATE TABLE IF NOT EXISTS `syn_party_due` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collected_date` datetime DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `party_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_party_headquater`
--

CREATE TABLE IF NOT EXISTS `syn_party_headquater` (
  `party_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headquater_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_party_user`
--

CREATE TABLE IF NOT EXISTS `syn_party_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `party_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_product`
--

CREATE TABLE IF NOT EXISTS `syn_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `quantity` varchar(10) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `no_in_case` varchar(10) NOT NULL,
  `active` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=68 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_productdetails`
--

CREATE TABLE IF NOT EXISTS `syn_productdetails` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syn_profile`
--

CREATE TABLE IF NOT EXISTS `syn_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_sales_plan`
--

CREATE TABLE IF NOT EXISTS `syn_sales_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `party_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_sales_plan_detail`
--

CREATE TABLE IF NOT EXISTS `syn_sales_plan_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sales_plan_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `plan_case` int(11) NOT NULL,
  `plan_individual` int(11) NOT NULL,
  `discount_case` int(11) NOT NULL,
  `discount_individual` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_stock`
--

CREATE TABLE IF NOT EXISTS `syn_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `ri_date` date NOT NULL,
  `qty` double NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_tada`
--

CREATE TABLE IF NOT EXISTS `syn_tada` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visited_date` date NOT NULL,
  `visit_place` varchar(255) NOT NULL,
  `distance` varchar(10) NOT NULL,
  `da` varchar(20) NOT NULL,
  `other` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `approved_date` datetime NOT NULL,
  `approved_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_tasetting`
--

CREATE TABLE IF NOT EXISTS `syn_tasetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `effective_date` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_unit`
--

CREATE TABLE IF NOT EXISTS `syn_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_user`
--

CREATE TABLE IF NOT EXISTS `syn_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `password` varchar(32) NOT NULL,
  `access_value` int(5) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `manager_id` int(11) NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_user_headquater`
--

CREATE TABLE IF NOT EXISTS `syn_user_headquater` (
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headquater_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `syn_visit_plan`
--

CREATE TABLE IF NOT EXISTS `syn_visit_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `collected_date` date NOT NULL,
  `place` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `remark` tinytext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `approved_date` datetime NOT NULL,
  `approved_by` int(11) NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Structure for view `syn_current_due`
--
DROP VIEW IF EXISTS `syn_current_due`;

CREATE VIEW `syn_current_due` AS select `syn_party_due`.`id` AS `id`,`syn_party_due`.`collected_date` AS `collected_date`,`syn_party_due`.`amount` AS `amount`,`syn_party_due`.`party_id` AS `party_id`,`syn_party_due`.`created_by` AS `created_by`,`syn_profile`.`name` AS `party_name` from ((`syn_party_due` join `syn_party` on((`syn_party_due`.`party_id` = `syn_party`.`id`))) join `syn_profile` on((`syn_profile`.`id` = `syn_party`.`profile_id`))) order by `syn_party_due`.`collected_date` desc;

