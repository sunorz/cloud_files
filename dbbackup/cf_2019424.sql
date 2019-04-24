/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50724
Source Host           : localhost:3306
Source Database       : cf

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-04-24 22:21:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `flinfo`
-- ----------------------------
DROP TABLE IF EXISTS `flinfo`;
CREATE TABLE `flinfo` (
  `shcd` varchar(8) NOT NULL,
  `md5fn` varchar(20) DEFAULT NULL,
  `fn` text NOT NULL,
  PRIMARY KEY (`shcd`),
  UNIQUE KEY `shcd` (`shcd`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of flinfo
-- ----------------------------


-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `coln` varchar(50) NOT NULL DEFAULT '' COMMENT 'username',
  `colp` varchar(32) NOT NULL COMMENT 'password',
  PRIMARY KEY (`coln`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('admin', '31e51c693a54a982a25c39cc81edac39');
