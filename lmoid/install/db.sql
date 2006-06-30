CREATE DATABASE `lmo_iconbase`;
USE `lmo_iconbase`;


#
# Table structure for table team
#

CREATE TABLE `team` (
  `Id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `name_idx` (`name`)
) ENGINE=MyISAM;

#
# Table structure for table search
#

CREATE TABLE `search` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `league` varchar(255) NOT NULL DEFAULT '',
  `teams` text NOT NULL,
  `from` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM;