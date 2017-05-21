
drop table if exists `article`;
create table if not exists `article`(
	`art_id` int(11) unsigned not null auto_increment comment 'ID',
	`art_title` varchar(255) not null default '' comment '标题',
	`art_content` text comment '内容',
	`art_categoryid` int(4) not null default '1' comment '分类',
	`art_hot` int(11) unsigned not null default '0' comment '热度',
	`art_createtime` DATETIME default '2016-10-10 00:00:00' comment '创建时间',
	`art_updatetime` DATETIME default '2016-10-10 00:00:00' comment '更新时间',
	primary key (`art_id`)
) engine=myisam default charset=utf8 comment='日志表';

drop table if exists `article_tag_access`;	
create table if not exists `article_tag_access`(
`atc_artid` int(11) unsigned not null,
`atc_tagid` int(11) unsigned not null
) engine=myisam default charset=utf8 comment='日志-关键字-中间表';
	
	

drop table if exists `category`;	
create table if not exists `category`(
	`cat_id` int(11) unsigned not null auto_increment comment 'ID',
	`cat_title` varchar(255) not null default '' comment '分类名称',
	`cat_artnum` int(11) unsigned not null default '0' comment '日志数量',
	primary key (`cat_id`)
) engine=myisam default charset=utf8 comment='日志分类表';
insert into category(cat_id,cat_title) values(1,'默认分类');

drop table if exists `tag`;	
create table if not exists `tag`(
	`tag_id` int(11) unsigned not null auto_increment comment 'ID',
	`tag_title` varchar(255) not null default '' comment '关键字',
	`tag_artnum` int(11) unsigned not null default '0' comment '日志数量',
	primary key (`tag_id`)
) engine=myisam default charset=utf8 comment='日志关键字表';


drop table if exists `comment`;	
create table if not exists `comment`(
	`com_id` int(11) unsigned not null auto_increment comment 'ID',
	`com_content` text comment '内容',
	`com_user` varchar(255) not null default '路人甲' comment '评论人',
	`com_artid` int(11) comment '我评论的谁',
 	`com_createtime` DATETIME default '2016-10-10 00:00:00' comment '创建时间',
	`com_updatetime` DATETIME default '2016-10-10 00:00:00' comment '更新时间',
	primary key (`com_id`)
) engine=myisam default charset=utf8 comment='日志评论表';


drop table if exists `log`;	
create table if not exists `log`(
	`log_id` int(11) unsigned not null auto_increment comment 'ID',
	`log_from` varchar(255) comment '用户Ip',
	`log_to` varchar(255) comment '访问地址',
	`log_createtime` DATETIME default '2016-10-10 00:00:00' comment '创建时间',
	primary key (`log_id`)
) engine=myisam default charset=utf8 comment='访问记录表';

drop table if exists `about_comment`;
create table if not exists `about_comment`(
	`acom_id` int(11) unsigned not null auto_increment comment 'ID',
	`acom_user` varchar(255) not null default '路人甲' comment '评论人',
	`acom_content` text comment '内容',
	`acom_toid` int(11) unsigned not null default 0 comment 'parentID',
	`acom_createtime` DATETIME default '2016-10-10 00:00:00' comment '创建时间',
	primary key (`acom_id`)
)engine=myisam default charset=utf8 comment='访问记录表';

drop table if exists `login_failure`;	
create table if not exists `login_failure`(
	`failure_id` int(11) unsigned not null auto_increment comment 'ID',
	`failure_from` varchar(255) comment '用户Ip',
	`log_createtime` DATETIME default '2016-10-10 00:00:00' comment '创建时间',
	primary key (`failure_id`)
) engine=myisam default charset=utf8 comment='登录失败表';

drop table if exists `admin_user`;	
create table if not exists `admin_user`(
	`uid` int(11) unsigned not null auto_increment comment 'ID',
	`uname` varchar(255) comment '用户名',
	`password` varchar(255) comment '用户密码',
	`password2` varchar(255) comment '用户密码2',
	primary key (`uid`)
) engine=myisam default charset=utf8 comment='管理员表';