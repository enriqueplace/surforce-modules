/*
MySQL Data Transfer
Source Host: localhost
Source Database: surforce-base
Target Host: localhost
Target Database: surforce-base
Date: 14/03/2008 04:28:23 p.m.
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for parametroscontactoskype
-- ----------------------------
CREATE TABLE `parametroscontactoskype` (
  `idskypeasignado` int(50) NOT NULL default '0',
  PRIMARY KEY  (`idskypeasignado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `parametroscontactoskype` VALUES ('0');
