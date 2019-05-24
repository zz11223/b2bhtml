/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : chengxin31520190505

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-05-24 10:43:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `destoon_links_uid`
-- ----------------------------
DROP TABLE IF EXISTS `destoon_links_uid`;
CREATE TABLE `destoon_links_uid` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `linkid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '友情链接id',
  PRIMARY KEY (`itemid`),
  KEY `linkid` (`linkid`),
  KEY `company` (`company`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='公司和友链的绑定';

-- ----------------------------
-- Records of destoon_links_uid
-- ----------------------------
