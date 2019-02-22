/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : ziwei

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-01-25 16:15:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for zw_admin
-- ----------------------------
DROP TABLE IF EXISTS `zw_admin`;
CREATE TABLE `zw_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(50) NOT NULL COMMENT '管理员登录名',
  `password` varchar(50) NOT NULL COMMENT '密码',
  `realname` varchar(50) DEFAULT NULL COMMENT '姓名',
  `comment` varchar(200) DEFAULT NULL COMMENT '备注',
  `status` varchar(20) DEFAULT 'active' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of zw_admin
-- ----------------------------

-- ----------------------------
-- Table structure for zw_cfg_index
-- ----------------------------
DROP TABLE IF EXISTS `zw_cfg_index`;
CREATE TABLE `zw_cfg_index` (
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义字段记录值';

-- ----------------------------
-- Records of zw_cfg_index
-- ----------------------------
INSERT INTO `zw_cfg_index` VALUES ('1');

-- ----------------------------
-- Table structure for zw_feedback
-- ----------------------------
DROP TABLE IF EXISTS `zw_feedback`;
CREATE TABLE `zw_feedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '反馈内容',
  `clientip` varchar(50) DEFAULT NULL COMMENT '来源ip',
  `createdatetime` datetime DEFAULT NULL COMMENT '反馈时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='反馈表';

-- ----------------------------
-- Records of zw_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for zw_field
-- ----------------------------
DROP TABLE IF EXISTS `zw_field`;
CREATE TABLE `zw_field` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(50) NOT NULL COMMENT '字段关联的表名',
  `fieldname` varchar(50) NOT NULL COMMENT '字段名',
  `fieldlabel` varchar(200) NOT NULL COMMENT '字段展示名称',
  `presence` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否显示',
  `fieldtype` varchar(50) NOT NULL DEFAULT '' COMMENT '字段类型',
  `defaultvalue` varchar(200) DEFAULT NULL COMMENT '字段默认值',
  `length` varchar(200) DEFAULT NULL COMMENT '字段长度',
  `signarea` varchar(20) DEFAULT NULL COMMENT '学生来源 local本区 nonlocal外省',
  `description` varchar(200) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='字段表';

-- ----------------------------
-- Records of zw_field
-- ----------------------------
INSERT INTO `zw_field` VALUES ('1', 'zw_signup', 'name', '姓名', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('2', 'zw_signup', 'sex', '性别', '1', 'int', '', '4', null, null);
INSERT INTO `zw_field` VALUES ('3', 'zw_signup', 'nation', '民族', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('4', 'zw_signup', 'nativeplace', '籍贯', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('5', 'zw_signup', 'dateofbirth', '出生日期', '1', 'date', '', '', null, null);
INSERT INTO `zw_field` VALUES ('6', 'zw_signup', 'IDnumber', '幼儿证件号', '1', 'varchar', '', '50', 'local', null);
INSERT INTO `zw_field` VALUES ('7', 'zw_signup', 'residence_type', '户口类型', '1', 'int', '', '4', 'local', null);
INSERT INTO `zw_field` VALUES ('8', 'zw_signup', 'homeplace_street', '户籍地-街道', '1', 'varchar', '', '50', 'local', null);
INSERT INTO `zw_field` VALUES ('9', 'zw_signup', 'homeplace_committee', '户籍地-居委', '1', 'varchar', '', '50', 'local', null);
INSERT INTO `zw_field` VALUES ('10', 'zw_signup', 'homeplace_relation_owner', '户籍地-户主关系', '1', 'int', '', '4', 'local', null);
INSERT INTO `zw_field` VALUES ('11', 'zw_signup', 'homeplace_settle_date', '户籍地-迁入日期', '1', 'date', '', '', 'local', null);
INSERT INTO `zw_field` VALUES ('12', 'zw_signup', 'homeplace_address', '户籍地-户籍地址', '1', 'varchar', '', '250', null, null);
INSERT INTO `zw_field` VALUES ('13', 'zw_signup', 'liveplace_street', '居住地-街道', '1', 'varcahr', '', '50', 'local', null);
INSERT INTO `zw_field` VALUES ('14', 'zw_signup', 'liveplace_committee', '居住地-居委', '1', 'varchar', '', '50', 'local', null);
INSERT INTO `zw_field` VALUES ('15', 'zw_signup', 'liveplace_relation_owner', '居住地-户主关系', '1', 'int', '', '4', 'local', null);
INSERT INTO `zw_field` VALUES ('16', 'zw_signup', 'liveplace_telephone', '居住地-固定电话', '1', 'varcahr', '', '20', 'local', null);
INSERT INTO `zw_field` VALUES ('17', 'zw_signup', 'guardian_pri_appellation', '监护人1-称谓', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('18', 'zw_signup', 'guardian_pri_name', '监护人1-姓名', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('19', 'zw_signup', 'guardian_pri_age', '监护人1-年龄', '1', 'varchar', '', '10', null, null);
INSERT INTO `zw_field` VALUES ('20', 'zw_signup', 'guardian_pri_workunit', '监护人1-工作单位', '1', 'varchar', '', '50', null, null);
INSERT INTO `zw_field` VALUES ('21', 'zw_signup', 'guardian_pri_phonenumber', '监护人1-手机号码', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('22', 'zw_signup', 'guardian_sec_appellation', '监护人2-称谓', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('23', 'zw_signup', 'guardian_sec_name', '监护人2-姓名', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('24', 'zw_signup', 'guardian_sec_age', '监护人2-年龄', '1', 'varchar', '', '10', null, null);
INSERT INTO `zw_field` VALUES ('25', 'zw_signup', 'guardian_sec_workunit', '监护人2-工作单位', '1', 'varchar', '', '50', null, null);
INSERT INTO `zw_field` VALUES ('26', 'zw_signup', 'guardian_sec_phonenumber', '监护人2-手机号码', '1', 'varchar', '', '20', null, null);
INSERT INTO `zw_field` VALUES ('27', 'zw_signup', 'sourcearea', '来源地区', '1', 'varchar', '', '20', 'nonlocal', null);
INSERT INTO `zw_field` VALUES ('28', 'zw_signup', 'IDtype', '证件类型', '1', 'tinyint', '', '4', 'nonlocal', null);
INSERT INTO `zw_field` VALUES ('29', 'zw_signup', 'residence_expiration_date', '居住证有效期至', '1', 'date', '', '', 'nonlocal', null);
INSERT INTO `zw_field` VALUES ('30', 'zw_signup', 'is_integral_reach', '积分是否达标', '1', 'tinyint', '', '4', 'nonlocal', null);
INSERT INTO `zw_field` VALUES ('31', 'zw_signup', 'social_security_total', '社保累计月份', '1', 'tinyint', '', '4', 'nonlocal', null);
INSERT INTO `zw_field` VALUES ('32', 'zw_signup', 'liveplace_address', '居住地-现住地址', '1', 'varchar', '', '250', null, null);

-- ----------------------------
-- Table structure for zw_signup
-- ----------------------------
DROP TABLE IF EXISTS `zw_signup`;
CREATE TABLE `zw_signup` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `sex` tinyint(4) DEFAULT NULL COMMENT '性别',
  `nation` varchar(20) DEFAULT NULL COMMENT '民族',
  `nativeplace` varchar(20) DEFAULT NULL COMMENT '籍贯',
  `dateofbirth` date DEFAULT NULL COMMENT '出生日期',
  `IDnumber` varchar(50) DEFAULT NULL COMMENT '幼儿证件号',
  `residence_type` tinyint(4) DEFAULT NULL COMMENT '1人户一致 2人户分离 3集体户口',
  `homeplace_street` varchar(50) DEFAULT NULL COMMENT '户籍-街道',
  `homeplace_committee` varchar(50) DEFAULT NULL COMMENT '户籍-居委',
  `homeplace_relation_owner` tinyint(4) DEFAULT NULL COMMENT '户籍-户主关系（1本人 2直系亲属 3非直系亲属 4非亲属）',
  `homeplace_settle_date` date DEFAULT NULL COMMENT '户籍-迁入日期',
  `homeplace_address` varchar(250) DEFAULT NULL COMMENT '户籍-户籍地址',
  `liveplace_street` varchar(50) DEFAULT NULL COMMENT '居住-街道',
  `liveplace_committee` varchar(50) DEFAULT NULL COMMENT '居住-居委',
  `liveplace_relation_owner` tinyint(4) DEFAULT NULL COMMENT '居住-户主关系（1本人 2直系亲属 3非直系亲属 4非亲属）',
  `liveplace_telephone` varchar(20) DEFAULT NULL COMMENT '居住-固定电话',
  `liveplace_address` varchar(250) DEFAULT NULL COMMENT '居住-现住地址',
  `guardian_pri_appellation` varchar(20) DEFAULT NULL COMMENT '监护人1-称谓',
  `guardian_pri_name` varchar(20) DEFAULT NULL COMMENT '监护人1-姓名',
  `guardian_pri_age` varchar(10) DEFAULT NULL COMMENT '监护人1-年龄',
  `guardian_pri_workunit` varchar(50) DEFAULT NULL COMMENT '监护人1-工作单位',
  `guardian_pri_phonenumber` varchar(20) DEFAULT NULL COMMENT '监护人1-手机号码',
  `guardian_sec_appellation` varchar(20) DEFAULT NULL COMMENT '监护人2-称谓',
  `guardian_sec_name` varchar(20) DEFAULT NULL COMMENT '监护人2-姓名',
  `guardian_sec_age` varchar(10) DEFAULT NULL COMMENT '监护人2-年龄',
  `guardian_sec_workunit` varchar(50) DEFAULT NULL COMMENT '监护人2-工作单位',
  `guardian_sec_phonenumber` varchar(20) DEFAULT NULL COMMENT '监护人2-手机号码',
  `createdatetime` datetime DEFAULT NULL COMMENT '创建时间',
  `status` varchar(10) DEFAULT NULL COMMENT '登记状态 wait pase refused',
  `approvedatetime` datetime DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登记报名表';

-- ----------------------------
-- Records of zw_signup
-- ----------------------------

-- ----------------------------
-- Table structure for zw_user
-- ----------------------------
DROP TABLE IF EXISTS `zw_user`;
CREATE TABLE `zw_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `phonenumber` varchar(30) DEFAULT NULL COMMENT '手机号',
  `email` varchar(50) DEFAULT NULL COMMENT '电子邮箱',
  `password` varchar(50) DEFAULT NULL COMMENT '密码',
  `regdatetime` datetime DEFAULT NULL COMMENT '创建时间',
  `lastlogintime` datetime DEFAULT NULL COMMENT '上一次登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of zw_user
-- ----------------------------

-- ----------------------------
-- Table structure for zw_verify_code
-- ----------------------------
DROP TABLE IF EXISTS `zw_verify_code`;
CREATE TABLE `zw_verify_code` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `receiver` varchar(50) NOT NULL COMMENT '接收人',
  `usage` varchar(20) NOT NULL COMMENT '用途方式',
  `verifycode` varchar(20) NOT NULL COMMENT '验证码内容',
  `createdatetime` datetime NOT NULL COMMENT '创建时间',
  `clientip` varchar(45) NOT NULL COMMENT '客户端ip',
  `status` varchar(10) NOT NULL COMMENT '验证码状态',
  `senddatetime` datetime DEFAULT NULL COMMENT '发送时间',
  `sendtype` varchar(10) DEFAULT NULL COMMENT '发送类型email/mobile',
  `sendcount` int(11) NOT NULL DEFAULT '0' COMMENT '发送次数',
  `totalcount` int(11) NOT NULL DEFAULT '0',
  `failcount` int(11) NOT NULL DEFAULT '0',
  `isbadreceiver` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `receivercreatedatetime` (`receiver`,`createdatetime`),
  KEY `createdatetime` (`createdatetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='验证码表';

-- ----------------------------
-- Records of zw_verify_code
-- ----------------------------

-- ----------------------------
-- Table structure for zw_vote
-- ----------------------------
DROP TABLE IF EXISTS `zw_vote`;
CREATE TABLE `zw_vote` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `votename` varchar(200) NOT NULL COMMENT '投票活动名称',
  `voteusernum` int(10) DEFAULT NULL COMMENT '参与人数',
  `votemaxballot` tinyint(4) DEFAULT NULL COMMENT '限制投票的数量',
  `createdatetime` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票表';

-- ----------------------------
-- Records of zw_vote
-- ----------------------------

-- ----------------------------
-- Table structure for zw_vote_option
-- ----------------------------
DROP TABLE IF EXISTS `zw_vote_option`;
CREATE TABLE `zw_vote_option` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `voteid` int(10) NOT NULL COMMENT '投票活动id',
  `optionname` varchar(200) DEFAULT NULL COMMENT '选项名称',
  `optionnum` int(10) DEFAULT NULL COMMENT '投票人数',
  `maxusers` int(10) DEFAULT NULL COMMENT '最多投票人数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票选项表';

-- ----------------------------
-- Records of zw_vote_option
-- ----------------------------

-- ----------------------------
-- Table structure for zw_vote_user
-- ----------------------------
DROP TABLE IF EXISTS `zw_vote_user`;
CREATE TABLE `zw_vote_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `voteid` int(10) NOT NULL COMMENT '投票活动id',
  `username` varchar(50) DEFAULT NULL COMMENT '用户名',
  `voteip` varchar(40) DEFAULT NULL COMMENT '投票ip',
  `content` varchar(200) DEFAULT NULL COMMENT '投票选项内容',
  `createdatetime` datetime NOT NULL COMMENT '投票时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票用户表';

-- ----------------------------
-- Records of zw_vote_user
-- ----------------------------
