/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : chengxin31520190505

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-05-24 10:43:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `destoon_links_company`
-- ----------------------------
DROP TABLE IF EXISTS `destoon_links_company`;
CREATE TABLE `destoon_links_company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `comurl` varchar(255) NOT NULL DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='公司表';

-- ----------------------------
-- Records of destoon_links_company
-- ----------------------------
INSERT INTO `destoon_links_company` VALUES ('1', '安徽汇百', 'http://www.jiuyundao.cn/', 'www.jiuyundao.cn');
INSERT INTO `destoon_links_company` VALUES ('2', '合肥浩哲钢管', 'http://hhfzz.com/', 'hhfzz.com');
INSERT INTO `destoon_links_company` VALUES ('3', '合肥双驰数码', 'http://ssgqq.com/', 'ssgqq.com');
