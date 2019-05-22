/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : chengxin31520190505

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-05-22 20:06:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `destoon_links`
-- ----------------------------
DROP TABLE IF EXISTS `destoon_links`;
CREATE TABLE `destoon_links` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `username` varchar(30) NOT NULL DEFAULT '' COMMENT '会员',
  `aname` varchar(30) NOT NULL DEFAULT '' COMMENT '添加编辑人',
  `linkurl` varchar(255) NOT NULL DEFAULT '',
  `addtime` int(11) NOT NULL DEFAULT '0',
  `edittime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='新建的友情链接库，供公司随机选择';

-- ----------------------------
-- Records of destoon_links
-- ----------------------------
INSERT INTO `destoon_links` VALUES ('1', '百度', 'huibai', '', 'https://www.baidu.com/', '1558524550', '1558524985');
INSERT INTO `destoon_links` VALUES ('2', '百度', 'ss', '', 'https://www.baidu.com/', '1558524550', '1558525001');
INSERT INTO `destoon_links` VALUES ('3', '百度', 'vv', '', 'https://www.baidu.com/', '1558524550', '1558525020');
INSERT INTO `destoon_links` VALUES ('4', '百度', 'ss', '', 'https://www.baidu.com/', '1558524550', '1558525033');
INSERT INTO `destoon_links` VALUES ('6', '百度', 'ssssssss', '', 'https://www.baidu.com/', '1558525054', '1558525054');
INSERT INTO `destoon_links` VALUES ('5', '百度', 'ssssssss', '', 'https://www.baidu.com/', '1558524888', '1558525043');
INSERT INTO `destoon_links` VALUES ('7', '百度', 'ssssssss', '', 'https://www.baidu.com/', '1558525057', '1558525057');
INSERT INTO `destoon_links` VALUES ('8', '百度', '汇百', '', 'https://www.baidu.com/', '1558525063', '1558525063');
INSERT INTO `destoon_links` VALUES ('9', '百度', '汇百', '', 'https://www.baidu.com/', '1558525065', '1558525065');
INSERT INTO `destoon_links` VALUES ('10', '百度', '汇百', '', 'https://www.baidu.com/', '1558525068', '1558525068');
INSERT INTO `destoon_links` VALUES ('11', '百度', '汇百', '', 'https://www.baidu.com/', '1558525070', '1558525070');
INSERT INTO `destoon_links` VALUES ('12', '百度', '汇百', '', 'https://www.baidu.com/', '1558525072', '1558525072');
INSERT INTO `destoon_links` VALUES ('13', '百度', '汇百', '', 'https://www.baidu.com/', '1558525074', '1558525074');
INSERT INTO `destoon_links` VALUES ('14', '百度', '汇百', '', 'https://www.baidu.com/', '1558525077', '1558525077');
INSERT INTO `destoon_links` VALUES ('15', '百度', '汇百', '', 'https://www.baidu.com/', '1558525080', '1558525080');
INSERT INTO `destoon_links` VALUES ('16', '百度', '汇百', '', 'https://www.baidu.com/', '1558525082', '1558525082');
INSERT INTO `destoon_links` VALUES ('17', '百度', '汇百', '', 'https://www.baidu.com/', '1558525084', '1558525084');
INSERT INTO `destoon_links` VALUES ('18', '百度', '汇百', '', 'https://www.baidu.com/', '1558525087', '1558525087');
INSERT INTO `destoon_links` VALUES ('19', '百度', '汇百', '', 'https://www.baidu.com/', '1558525089', '1558525089');
INSERT INTO `destoon_links` VALUES ('20', '百度', '汇百', '', 'https://www.baidu.com/', '1558525091', '1558525091');
INSERT INTO `destoon_links` VALUES ('21', '百度', '汇百', '', 'https://www.baidu.com/', '1558525094', '1558525094');
INSERT INTO `destoon_links` VALUES ('22', '百度', '汇百', '', 'https://www.baidu.com/', '1558525096', '1558525096');
INSERT INTO `destoon_links` VALUES ('23', '百度', '汇百', '', 'https://www.baidu.com/', '1558525098', '1558525098');
INSERT INTO `destoon_links` VALUES ('24', '百度', '汇百', '', 'https://www.baidu.com/', '1558525101', '1558525101');
INSERT INTO `destoon_links` VALUES ('25', '百度', '汇百', '', 'https://www.baidu.com/', '1558525103', '1558525103');
INSERT INTO `destoon_links` VALUES ('26', '百度', '汇百', '', 'https://www.baidu.com/', '1558525105', '1558525105');
INSERT INTO `destoon_links` VALUES ('27', '百度', '汇百', '', 'https://www.baidu.com/', '1558525107', '1558525107');
INSERT INTO `destoon_links` VALUES ('28', '百度', '汇百', '', 'https://www.baidu.com/', '1558525110', '1558525110');
INSERT INTO `destoon_links` VALUES ('29', '百度', '汇百', '', 'https://www.baidu.com/', '1558525117', '1558525117');
INSERT INTO `destoon_links` VALUES ('30', '百度', '汇百', '', 'https://www.baidu.com/', '1558525119', '1558525119');
INSERT INTO `destoon_links` VALUES ('31', '百度', '汇百', '', 'https://www.baidu.com/', '1558525121', '1558525121');
INSERT INTO `destoon_links` VALUES ('32', '百度', '汇百', '', 'https://www.baidu.com/', '1558525124', '1558525124');
INSERT INTO `destoon_links` VALUES ('33', '百度', '汇百', '', 'https://www.baidu.com/', '1558525126', '1558525126');
INSERT INTO `destoon_links` VALUES ('34', '百度', '汇百', '', 'https://www.baidu.com/', '1558525128', '1558525128');
INSERT INTO `destoon_links` VALUES ('35', '百度', '汇百', '', 'https://www.baidu.com/', '1558525581', '1558525581');
INSERT INTO `destoon_links` VALUES ('36', '百度', '汇百', '', 'https://www.baidu.com/', '1558525640', '1558525640');
INSERT INTO `destoon_links` VALUES ('37', '百度', '汇百', '', 'https://www.baidu.com/', '1558525683', '1558525683');
INSERT INTO `destoon_links` VALUES ('38', '百度', '汇百', '', 'https://www.baidu.com/', '1558525723', '1558525723');
