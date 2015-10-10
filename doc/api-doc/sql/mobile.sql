INSERT INTO  `#__setting` (`name`, `value`) VALUES ('mobile_isuse', '1');
INSERT INTO  `#__setting` (`name`, `value`) VALUES ('mobile_app', 'mb_app.png');
INSERT INTO  `#__setting` (`name`, `value`) VALUES ('mobile_apk', '');
INSERT INTO  `#__setting` (`name`, `value`) VALUES ('mobile_apk_version', '3.0');
INSERT INTO  `#__setting` (`name`, `value`) VALUES ('mobile_ios', '');

CREATE TABLE  `#__mb_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(500) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL COMMENT '1来自手机端2来自PC端',
  `ftime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '反馈时间',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='意见反馈';

CREATE TABLE  `#__mb_category` (
  `gc_id` smallint(5) unsigned DEFAULT NULL COMMENT '商城系统的分类ID',
  `gc_thumb` varchar(150) DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`gc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='一级分类缩略图[手机端]';

INSERT INTO  `#__mb_category` VALUES (1,'b3270daacaca2c74dbfe1b7fdcefcd8d.png'),(2,'7ac89f535680e83b16a68e5b463706b0.png'),(3,'f64e7393c3f15bf23c9e28f65361a5d8.png'),(8,'6a96d167a9fb65d0b5290958d9176b2a.png'),(4,'4c08033155e5e6a3d611cf6d5a16795b.png'),(5,'55dac983f83d749ea9bfa49417ea7859.png'),(7,'83e0bd1790eb7a2484b58eebcfa813a0.png'),(6,'7f5e6dfbca829d704986c48f01516dcd.png');

CREATE TABLE  `#__mb_user_token` (
  `token_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '令牌编号',
  `member_id` int(10) unsigned NOT NULL COMMENT '用户编号',
  `member_name` varchar(50) NOT NULL COMMENT '用户名',
  `token` varchar(50) NOT NULL COMMENT '登录令牌',
  `login_time` int(10) unsigned NOT NULL COMMENT '登录时间',
  `client_type` varchar(10) NOT NULL COMMENT '客户端类型 android wap',
  PRIMARY KEY (`token_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='移动端登录令牌表';

CREATE TABLE  `#__mb_payment` (
  `payment_id` tinyint(1) unsigned NOT NULL COMMENT '支付索引id',
  `payment_code` char(10) NOT NULL COMMENT '支付代码名称',
  `payment_name` char(10) NOT NULL COMMENT '支付名称',
  `payment_config` varchar(255) COMMENT '支付接口配置信息',
  `payment_state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '接口状态0禁用1启用',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='手机支付方式表';

INSERT INTO  `#__mb_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_config`, `payment_state`) VALUES ('1', 'alipay', '支付宝', '', '0');
INSERT INTO  `#__mb_payment` (`payment_id`, `payment_code`, `payment_name`, `payment_config`, `payment_state`) VALUES ('2', 'wxpay', '微信支付', '', '0');

CREATE TABLE  `#__mb_special` (
  `special_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '专题编号',
  `special_desc` varchar(20) NOT NULL COMMENT '专题描述',
  PRIMARY KEY (`special_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='手机专题表';

CREATE TABLE  `#__mb_special_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '专题项目编号',
  `special_id` int(10) unsigned NOT NULL COMMENT '专题编号',
  `item_type` varchar(50) NOT NULL COMMENT '项目类型',
  `item_data` varchar(2000) NOT NULL COMMENT '项目内容',
  `item_usable` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '项目是否可用 0-不可用 1-可用',
  `item_sort` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '项目排序',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='手机专题项目表';
