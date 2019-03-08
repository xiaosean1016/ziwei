-- create_table
CREATE TABLE IF NOT EXISTS `zw_field`(
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`tablename` varchar(50) NOT NULL COMMENT '字段关联的表名',
	`fieldname` varchar(50) NOT NULL COMMENT '字段名',
	`fieldlabel` varchar(200) NOT NULL COMMENT '字段展示名称',
	`presence` TINYINT(4) NOT NULL DEFAULT 0 COMMENT '是否显示',
	`fieldtype` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '字段类型',
	`defaultvalue` varchar(200) DEFAULT NULL COMMENT '字段默认值',
	`length` varchar(200) COMMENT '字段长度',
	`required` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '是否必填',
	`signarea` varchar(20) DEFAULT NULL COMMENT '学生来源 local本区 nonlocal外省',
	`description` varchar(200) COMMENT '备注',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='字段表';

CREATE TABLE IF NOT EXISTS `zw_user` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`username` varchar(50) NOT NULL COMMENT '用户名',
	`phone` varchar(30) DEFAULT NULL COMMENT '手机号',
	`email` varchar(50) DEFAULT NULL COMMENT '电子邮箱',
	`password` varchar(255) DEFAULT NULL COMMENT '密码',
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
	`sex` varchar(4) COMMENT '性别',
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
	`is_integral_reach` varchar(20) COMMENT '积分是否达标',
	`social_security_total` varchar(10) COMMENT '社保累计月份',
	`createdatetime` datetime COMMENT '创建时间',
	`status` varchar(10) COMMENT '登记状态 wait pass refused',
	`templateid` int(10) COMMENT '模板id',
	`issentmsg` tinyint(4) DEFAULT 0 COMMENT '是否已发送通知',
	`msgcontent` varchar(250) COMMENT '通知话术内容',
	`approvedatetime` datetime COMMENT '审核时间',
	PRIMARY KEY (`id`),
	KEY `status` (`status`),
	KEY `templateid` (`templateid`),
	KEY `createdatetime` (`createdatetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '登记报名表';

CREATE TABLE IF NOT EXISTS `zw_vote` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`votename` varchar(200) NOT NULL COMMENT '投票活动名称',
	`description` text COMMENT '投票活动描述',
	`voteusernum` INT(10) COMMENT '参与人数',
	`votemaxballot` tinyint(4) COMMENT '限制投票的数量',
	`submitfield` text COMMENT '提交字段',
	`startdatetime` datetime COMMENT '活动开始时间',
	`stopdatetime` datetime COMMENT '活动结束时间',
	`status` varchar(100) COMMENT '活动状态 preparing progressing ending',
	`createdatetime` datetime COMMENT '创建时间',
	PRIMARY KEY (`id`),
	KEY `votename` (`votename`),
  KEY `createdatetime` (`createdatetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '投票表';

CREATE TABLE IF NOT EXISTS `zw_vote_option` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`voteid` INT(10) NOT NULL COMMENT '投票活动id',
	`optionname` varchar(200) COMMENT '选项名称',
	`description` text COMMENT '选项说明',
	`maxusers` INT(10) DEFAULT NULL COMMENT '最多投票人数 为空代表不限制',
	`optionimg` varchar(255) COMMENT '选项图片',
	`optionnum` INT(10) DEFAULT 0 COMMENT '投票人数',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '投票选项表';

CREATE TABLE IF NOT EXISTS `zw_vote_user` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`voteid` INT(10) NOT NULL COMMENT '投票活动id',
	`username` VARCHAR(50) COMMENT '用户名',
	`voteip` VARCHAR(40) COMMENT '投票ip',
	`submitjson` text COMMENT '提交内容',
	`submitcontent` VARCHAR(255) COMMENT '提交内容标记（用于去重查询）',
	`createdatetime` datetime NOT NULL COMMENT '投票时间',
	PRIMARY KEY (`id`),
	KEY `submitcontent` (`submitcontent`),
	KEY `createdatetime` (`createdatetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '投票用户表';

CREATE TABLE IF NOT EXISTS `zw_vote_user_option` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`voteid` INT(10) NOT NULL COMMENT '投票活动id',
	`voteuserid` INT(10) COMMENT '用户提交投票id',
	`optionid` INT(10) COMMENT '提交投票对应选项id',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '投票用户选项表';

CREATE TABLE IF NOT EXISTS `zw_config` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`key` varchar(100) NOT NULL COMMENT '配置key',
	`value` varchar(200) COMMENT '配置value',
	`comment` varchar(200) COMMENT '备注',
	PRIMARY KEY (`id`),
	UNIQUE KEY `configkey` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '配置表';

CREATE TABLE IF NOT EXISTS `zw_feedback` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`content` text NOT NULL COMMENT '反馈内容',
	`contact` varchar(200) COMMENT '联系方式',
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

-- add_fields
insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','name','姓名','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='name');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','sex','性别','1','varchar','','4',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='sex');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','nation','民族','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='nation');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','nativeplace','籍贯','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='nativeplace');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','dateofbirth','出生日期','1','date','','',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='dateofbirth');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','IDnumber','幼儿证件号','1','varchar','','50','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='IDnumber');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','residence_type','户口类型','1','select','','','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='residence_type');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','homeplace_street','户籍地-街道','1','varchar','','50','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_street');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','homeplace_committee','户籍地-居委','1','varchar','','50','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_committee');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','homeplace_relation_owner','户籍地-户主关系','1','select','','','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_relation_owner');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','homeplace_settle_date','户籍地-迁入日期','1','date','','','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_settle_date');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','homeplace_address','户籍地-户籍地址','1','varchar','','250',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_address');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','liveplace_street','居住地-街道','1','varchar','','50','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_street');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','liveplace_committee','居住地-居委','1','varchar','','50','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_committee');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','liveplace_relation_owner','居住地-户主关系','1','select','','','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_relation_owner');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','liveplace_telephone','居住地-固定电话','1','varchar','','20','local',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_telephone');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','liveplace_address','居住地-现住地址','1','varchar','','250',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_address');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_pri_appellation','监护人1-称谓','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_appellation');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_pri_name','监护人1-姓名','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_name');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_pri_age','监护人1-年龄','1','varchar','','10',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_age');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_pri_education','监护人1-学历','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_education');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_pri_workunit','监护人1-工作单位','1','varchar','','50',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_workunit');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_pri_phonenumber','监护人1-手机号码','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_phonenumber');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_sec_appellation','监护人2-称谓','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_appellation');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_sec_name','监护人2-姓名','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_name');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_sec_age','监护人2-年龄','1','varchar','','10',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_age');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_sec_education','监护人2-学历','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_education');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_sec_workunit','监护人2-工作单位','1','varchar','','50',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_workunit');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`required`)
select 'zw_signup','guardian_sec_phonenumber','监护人2-手机号码','1','varchar','','20',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_phonenumber');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','sourcearea','来源地区','1','select','','','nonlocal',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='sourcearea');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','IDtype','证件类型','1','select','','','nonlocal',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='IDtype');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','residence_expiration_date','居住证有效期至','1','date','','','nonlocal',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='residence_expiration_date');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','is_integral_reach','积分是否达标','1','select','','','nonlocal',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='is_integral_reach');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`,`required`)
select 'zw_signup','social_security_total','社保累计月份','1','varchar','','4','nonlocal',1 from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='social_security_total');

-- default template
insert into zw_template(`name`,`type`,`isshow`,`description`)
select '本区报名默认模板','local',1,'请携带以下材料于2019年5月16日 11:00来我园现场登记报名<br>递交所需材料：<br>1）户口簿；2）房屋产权证；3）公有居住房屋租赁合同；4）幼儿出生凭证<br>地址：上海市徐汇区桂平路129号<br>电话：021-54217515' from dual
where not exists(select 1 from zw_template where name='本区报名默认模板');

insert into zw_template(`name`,`type`,`isshow`,`description`)
select '外省报名默认模板','nonlocal',1,'请携带以下材料于2019年5月16日 11:00来我园现场登记报名<br>递交所需材料：<br>1）幼儿居住证/凭证；2）监护人居住证；3）房屋产权证；4）租赁合同；5）幼儿出生证<br>地址：上海市徐汇区桂平路129号<br>电话：021-54217515' from dual
where not exists(select 1 from zw_template where name='外省报名默认模板');

-- config_table
insert into zw_config(`key`, `value`, `comment`)
select 'vote_username','ziwei','投票登录用户名' from dual
where not exists(select 1 from zw_config where `key`='vote_username');

insert into zw_config(`key`, `value`, `comment`)
select 'vote_password','123456','投票登录密码' from dual
where not exists(select 1 from zw_config where `key`='vote_password');

insert into zw_config(`key`, `value`, `comment`)
select 'sign_active','1','报名活动状态 1开启 0关闭' from dual
where not exists(select 1 from zw_config where `key`='sign_active');

insert into zw_config(`key`, `value`, `comment`)
select 'cfg_index','1','自定义字段自增值记录' from dual
where not exists(select 1 from zw_config where `key`='cfg_index');

-- pick_list
select id into @fieldid from zw_field where fieldname='residence_type' and tablename='zw_signup';
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'人户一致','人户一致' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='人户一致');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'人户分离','人户分离' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='人户分离');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'集体户口','集体户口' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='集体户口');

select id into @fieldid from zw_field where fieldname='homeplace_relation_owner' and tablename='zw_signup';
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'本人','本人' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='本人');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'直系亲属','直系亲属' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='直系亲属');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'非直系亲属','非直系亲属' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='非直系亲属');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'非亲属','非亲属' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='非亲属');

select id into @fieldid from zw_field where fieldname='liveplace_relation_owner' and tablename='zw_signup';
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'本人','本人' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='本人');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'直系亲属','直系亲属' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='直系亲属');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'非直系亲属','非直系亲属' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='非直系亲属');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'非亲属','非亲属' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='非亲属');

select id into @fieldid from zw_field where fieldname='sourcearea' and tablename='zw_signup';
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'外省','外省' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='外省');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'香港','香港' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='香港');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'澳门','澳门' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='澳门');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'台湾','台湾' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='台湾');

select id into @fieldid from zw_field where fieldname='IDtype' and tablename='zw_signup';
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'身份证','身份证' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='身份证');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'来往大陆通行证','来往大陆通行证' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='来往大陆通行证');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'护照','护照' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='护照');

select id into @fieldid from zw_field where fieldname='is_integral_reach' and tablename='zw_signup';
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'是','是' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='是');
insert into zw_picklist(`fieldid`,`pickval`,`picktext`)
select @fieldid,'否','否' from dual where not exists
(select 1 from zw_picklist where fieldid=@fieldid and pickval='否');
