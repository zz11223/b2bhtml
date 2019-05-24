/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : chengxin31520190505

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-05-24 10:43:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `destoon_links`
-- ----------------------------
DROP TABLE IF EXISTS `destoon_links`;
CREATE TABLE `destoon_links` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `company` int(11) NOT NULL DEFAULT '0' COMMENT '公司',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `edittime` int(11) NOT NULL DEFAULT '0',
  `linkurl` varchar(255) NOT NULL DEFAULT '' COMMENT '特别指定的url',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='新建的友情链接库，供公司随机选择';

-- ----------------------------
-- Records of destoon_links
-- ----------------------------
INSERT INTO `destoon_links` VALUES ('1', '安徽汇百信息科技开发有限公司', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('2', '合肥网站优化', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('3', '合肥网络推广', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('4', '合肥网站推广', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('5', '安徽网站优化', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('6', '合肥网络公司', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('7', '合肥百度优化', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('8', '合肥网站推广公司', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('9', '合肥网站优化公司', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('10', '合肥网络推广公司', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('11', '合肥百度排名', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('12', '合肥SEO优化', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('13', '合肥SEO', '1', '1558665548', '1558665548', '');
INSERT INTO `destoon_links` VALUES ('14', '合肥无缝管', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('15', '合肥镀锌方管', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('16', '合肥钢管厂', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('17', '安徽钢管厂', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('18', '合肥不锈钢管', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('19', '合肥螺旋钢管', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('20', '合肥焊管厂', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('21', '合肥方管', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('22', '合肥无缝钢管', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('23', '合肥角钢', '2', '1558665668', '1558665668', '');
INSERT INTO `destoon_links` VALUES ('24', '合肥双驰数码科技有限公司', '3', '1558665695', '1558665695', '');
INSERT INTO `destoon_links` VALUES ('25', '复印机、传真机、碎纸机、考勤机、打印机', '3', '1558665695', '1558665695', '');
