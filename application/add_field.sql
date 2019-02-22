insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','name','姓名','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='name');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','sex','性别','1','varchar','','4' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='sex');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','nation','民族','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='nation');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','nativeplace','籍贯','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='nativeplace');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','dateofbirth','出生日期','1','date','','' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='dateofbirth');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','IDnumber','幼儿证件号','1','varchar','','50','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='IDnumber');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','residence_type','户口类型','1','select','','','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='residence_type');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','homeplace_street','户籍地-街道','1','varchar','','50','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_street');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','homeplace_committee','户籍地-居委','1','varchar','','50','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_committee');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','homeplace_relation_owner','户籍地-户主关系','1','select','','','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_relation_owner');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','homeplace_settle_date','户籍地-迁入日期','1','date','','','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_settle_date');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','homeplace_address','户籍地-户籍地址','1','varchar','','250' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='homeplace_address');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','liveplace_street','居住地-街道','1','varchar','','50','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_street');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','liveplace_committee','居住地-居委','1','varchar','','50','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_committee');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','liveplace_relation_owner','居住地-户主关系','1','select','','','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_relation_owner');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','liveplace_telephone','居住地-固定电话','1','varchar','','20','local' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_telephone');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','liveplace_address','居住地-现住地址','1','varchar','','250' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='liveplace_address');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_pri_appellation','监护人1-称谓','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_appellation');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_pri_name','监护人1-姓名','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_name');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_pri_age','监护人1-年龄','1','varchar','','10' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_age');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_pri_education','监护人1-学历','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_education');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_pri_workunit','监护人1-工作单位','1','varchar','','50' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_workunit');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_pri_phonenumber','监护人1-手机号码','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_pri_phonenumber');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_sec_appellation','监护人2-称谓','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_appellation');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_sec_name','监护人2-姓名','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_name');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_sec_age','监护人2-年龄','1','varchar','','10' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_age');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_sec_education','监护人2-学历','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_education');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_sec_workunit','监护人2-工作单位','1','varchar','','50' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_workunit');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`)
select 'zw_signup','guardian_sec_phonenumber','监护人2-手机号码','1','varchar','','20' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='guardian_sec_phonenumber');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','sourcearea','来源地区','1','select','','','nonlocal' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='sourcearea');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','IDtype','证件类型','1','select','','','nonlocal' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='IDtype');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','residence_expiration_date','居住证有效期至','1','date','','','nonlocal' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='residence_expiration_date');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','is_integral_reach','积分是否达标','1','checkbox','','','nonlocal' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='is_integral_reach');

insert into zw_field(`tablename`,`fieldname`,`fieldlabel`,`presence`,`fieldtype`,`defaultvalue`,`length`,`signarea`)
select 'zw_signup','social_security_total','社保累计月份','1','varchar','','4','nonlocal' from dual where not exists
(select 1 from zw_field where tablename='zw_signup' and fieldname='social_security_total');

insert into zw_cfg_index(`id`) select 1 from dual where not exists(select 1 from zw_cfg_index);

insert into zw_template(`name`,`type`,`isshow`,`description`)
select '本区报名默认模板','local',1,'' from dual
where not exists(select 1 from zw_template where name='本区报名默认模板');

insert into zw_template(`name`,`type`,`isshow`,`description`)
select '外省报名默认模板','nonlocal',1,'' from dual
where not exists(select 1 from zw_template where name='外省报名默认模板');



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
