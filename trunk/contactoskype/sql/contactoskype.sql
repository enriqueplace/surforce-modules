/*
MySQL Data Transfer
Source Host: localhost
Source Database: surforce-base
Target Host: localhost
Target Database: surforce-base
Date: 06/03/2008 05:59:45 p.m.
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for contactoskype
-- ----------------------------
CREATE TABLE `contactoskype` (
  `id` int(10) NOT NULL auto_increment,
  `nombre` varchar(50) collate utf8_spanish_ci NOT NULL,
  `usuarioskype` varchar(50) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- ----------------------------
-- Records 
-- ----------------------------
INSERT INTO `contactoskype` VALUES ('1', 'Juan Pablo Antunez', 'jantunez_dinamica');
INSERT INTO `contactoskype` VALUES ('2', 'Ana G. Pino', 'apino_dinamica');
INSERT INTO `contactoskype` VALUES ('3', 'Fabian Bueno', 'fbueno_dinamica');
