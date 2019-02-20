CREATE TABLE IF NOT EXISTS `zw_field`(
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`tablename` varchar(50) NOT NULL COMMENT '字段关联的表名',
	`fieldname` varchar(50) NOT NULL COMMENT '字段名',
	`fieldlabel` varchar(200) NOT NULL COMMENT '字段展示名称',
	`presence` TINYINT(4) NOT NULL DEFAULT 0 COMMENT '是否显示',
	`fieldtype` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '字段类型',
	`defaultvalue` varchar(200) DEFAULT NULL COMMENT '字段默认值',
	`length` varchar(200) COMMENT '字段长度',
	`signarea` varchar(20) DEFAULT NULL COMMENT '学生来源 local本区 nonlocal外省',
	`description` varchar(200) COMMENT '备注',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='字段表';

CREATE TABLE IF NOT EXISTS `zw_cfg_index` (
	`id` INT(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义字段记录值';

CREATE TABLE IF NOT EXISTS `zw_user` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`username` varchar(50) NOT NULL COMMENT '用户名',
	`phonenumber` varchar(30) DEFAULT NULL COMMENT '手机号',
	`email` varchar(50) DEFAULT NULL COMMENT '电子邮箱',
	`password` varchar(50) DEFAULT NULL COMMENT '密码',
	`regdatetime` datetime DEFAULT NULL COMMENT '创建时间',
	`lastlogintime` datetime DEFAULT NULL COMMENT '上一次登录时间',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '用户表';

CREATE TABLE IF NOT EXISTS `zw_admin` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`adminname` varchar(50) NOT NULL COMMENT '管理员登录名',
	`password` varchar(255) NOT NULL COMMENT '密码',
	`realname` varchar(50) DEFAULT NULL COMMENT '姓名',
	`comment` varchar(200) DEFAULT NULL COMMENT '备注',
	`status` varchar(20) DEFAULT 'active' COMMENT '状态',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '管理员表';

CREATE TABLE IF NOT EXISTS `zw_signup` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`userid` INT(10) NOT NULL COMMENT '用户id',
	`name` varchar(20) NOT NULL COMMENT '姓名',
	`sex` tinyint(4) COMMENT '性别',
	`nation` varchar(20) COMMENT '民族',
	`nativeplace` varchar(20) COMMENT '籍贯',
	`dateofbirth` date COMMENT '出生日期',
	`IDnumber` varchar(50) COMMENT '幼儿证件号',
	`residence_type` varchar(200) COMMENT '人户一致 人户分离 集体户口',
	`homeplace_street` varchar(50) COMMENT '户籍-街道',
	`homeplace_committee` varchar(50) COMMENT '户籍-居委',
	`homeplace_relation_owner` varchar(200) COMMENT '户籍-户主关系（本人 直系亲属 非直系亲属 非亲属）',
	`homeplace_settle_date` date COMMENT '户籍-迁入日期',
	`homeplace_address` varchar(250) COMMENT '户籍-户籍地址',
	`liveplace_street` varchar(50) COMMENT '居住-街道',
	`liveplace_committee` varchar(50) COMMENT '居住-居委',
	`liveplace_relation_owner` varchar(200) COMMENT '居住-户主关系（1本人 2直系亲属 3非直系亲属 4非亲属）',
	`liveplace_telephone` varchar(20) COMMENT '居住-固定电话',
	`liveplace_address` varchar(250) COMMENT '居住-现住地址',
	`guardian_pri_appellation` varchar(20) COMMENT '监护人1-称谓',
	`guardian_pri_name` varchar(20) COMMENT '监护人1-姓名',
	`guardian_pri_age` varchar(10) COMMENT '监护人1-年龄',
	`guardian_pri_education` varchar(20) COMMENT '监护人1-学历',
	`guardian_pri_workunit` varchar(50) COMMENT '监护人1-工作单位',
	`guardian_pri_phonenumber` varchar(20) COMMENT '监护人1-手机号码',
	`guardian_sec_appellation` varchar(20) COMMENT '监护人2-称谓',
	`guardian_sec_name` varchar(20) COMMENT '监护人2-姓名',
	`guardian_sec_age` varchar(10) COMMENT '监护人2-年龄',
	`guardian_sec_education` varchar(20) COMMENT '监护人2-学历',
	`guardian_sec_workunit` varchar(50) COMMENT '监护人2-工作单位',
	`guardian_sec_phonenumber` varchar(20) COMMENT '监护人2-手机号码',
	`sourcearea` varchar(200) COMMENT '来源地区（外省 香港 澳门 台湾）',
	`IDtype` varchar(200) COMMENT '证件类型（身份证 来往大陆通行证 护照）',
	`residence_expiration_date` date COMMENT '居住证到期日',
	`is_integral_reach` tinyint(4) COMMENT '积分是否达标',
	`social_security_total` varchar(10) COMMENT '社保累计月份',
	`createdatetime` datetime COMMENT '创建时间',
	`status` varchar(10) COMMENT '登记状态 wait pass refused',
	`templateid` int(10) COMMENT '模板id',
	`issentmsg` tinyint(4) DEFAULT 0 COMMENT '是否已发送通知',
	`msgcontent` varchar(250) COMMENT '通知话术内容',
	`approvedatetime` datetime COMMENT '审核时间',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '登记报名表';

CREATE TABLE IF NOT EXISTS `zw_vote` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`votename` varchar(200) NOT NULL COMMENT '投票活动名称',
	`voteusernum` INT(10) COMMENT '参与人数',
	`votemaxballot` tinyint(4) COMMENT '限制投票的数量',
	`createdatetime` datetime COMMENT '创建时间',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '投票表';

CREATE TABLE IF NOT EXISTS `zw_vote_option` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`voteid` INT(10) NOT NULL COMMENT '投票活动id',
	`optionname` varchar(200) COMMENT '选项名称',
	`optionnum` INT(10) DEFAULT NULL COMMENT '投票人数',
	`maxusers` INT(10) DEFAULT NULL COMMENT '最多投票人数',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '投票选项表';

CREATE TABLE IF NOT EXISTS `zw_vote_user` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`voteid` INT(10) NOT NULL COMMENT '投票活动id',
	`username` VARCHAR(50) COMMENT '用户名',
	`voteip` VARCHAR(40) COMMENT '投票ip',
	`content` VARCHAR(200) COMMENT '投票选项内容',
	`createdatetime` datetime NOT NULL COMMENT '投票时间',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '投票用户表';

CREATE TABLE IF NOT EXISTS `zw_feedback` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`content` text NOT NULL COMMENT '反馈内容',
	`clientip` varchar(50) COMMENT '来源ip',
	`createdatetime` datetime COMMENT '反馈时间',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '反馈表';

CREATE TABLE IF NOT EXISTS `zw_verify_code` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `receiver` varchar(50) NOT NULL COMMENT '接收人',
  `usage` varchar(20) NOT NULL COMMENT '用途方式',
  `verifycode` varchar(20) NOT NULL COMMENT '验证码内容',
  `createdatetime` datetime NOT NULL COMMENT '创建时间',
  `clientip` varchar(45) NOT NULL COMMENT '客户端ip',
  `status` varchar(10) NOT NULL COMMENT '验证码状态',
  `senddatetime` datetime DEFAULT NULL COMMENT '发送时间',
  `sendtype` varchar(10) DEFAULT NULL COMMENT '发送类型email/mobile',
  `sendcount` int(11) NOT NULL DEFAULT 0 COMMENT '发送次数',
  `totalcount` int(11) NOT NULL DEFAULT 0,
  `failcount` int(11) NOT NULL DEFAULT 0,
  `isbadreceiver` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `receivercreatedatetime` (`receiver`,`createdatetime`),
  KEY `createdatetime` (`createdatetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '验证码表';

CREATE TABLE IF NOT EXISTS `zw_template` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`name` varchar(200) NOT NULL COMMENT '模板名称',
	`type` varchar(20) COMMENT '模板类型',
	`isshow` tinyint(4) COMMENT '是否展示',
	`description` text COMMENT '描述',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '模板表';

CREATE TABLE IF NOT EXISTS `zw_picklist` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`fieldid` int(10) NOT NULL COMMENT '字段id',
	`pickval` varchar(200) COMMENT '下拉框val',
	`picktext` varchar(200) COMMENT '下拉框text',
	PRIMARY KEY (`id`)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '下拉框选项表';

CREATE TABLE IF NOT EXISTS `zw_list_fields` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`templateid` int(10) NOT NULL COMMENT '模板id',
	`fieldname` varchar(50) COMMENT '字段名称',
	`sequence` int(10) COMMENT '顺序值',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '列表字段表';

