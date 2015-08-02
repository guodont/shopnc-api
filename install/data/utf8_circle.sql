
CREATE TABLE `#__circle` (
  `circle_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '圈子id',
  `circle_name` varchar(12) NOT NULL COMMENT '圈子名称',
  `circle_desc` varchar(255) DEFAULT NULL COMMENT '圈子描述',
  `circle_masterid` int(11) unsigned NOT NULL COMMENT '圈主id',
  `circle_mastername` varchar(50) NOT NULL COMMENT '圈主名称',
  `circle_img` varchar(50) DEFAULT NULL COMMENT '圈子图片',
  `class_id` int(11) unsigned NOT NULL COMMENT '圈子分类',
  `circle_mcount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '圈子成员数',
  `circle_thcount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '圈子主题数',
  `circle_gcount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '圈子商品数',
  `circle_pursuereason` varchar(255) DEFAULT NULL COMMENT '圈子申请理由',
  `circle_notice` varchar(255) DEFAULT NULL COMMENT '圈子公告',
  `circle_status` tinyint(3) unsigned NOT NULL COMMENT '圈子状态，0关闭，1开启，2审核中，3审核失败',
  `circle_statusinfo` varchar(255) DEFAULT NULL COMMENT '关闭或审核失败原因',
  `circle_joinaudit` tinyint(3) unsigned NOT NULL COMMENT '加入圈子时候需要审核，0不需要，1需要',
  `circle_addtime` varchar(10) NOT NULL COMMENT '圈子创建时间',
  `circle_noticetime` varchar(10) DEFAULT NULL COMMENT '圈子公告更新时间',
  `is_recommend` tinyint(3) unsigned NOT NULL COMMENT '是否推荐 0未推荐，1已推荐',
  `is_hot` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否为热门圈子 1是 0否',
  `circle_tag` varchar(60) DEFAULT NULL COMMENT '圈子标签',
  `new_verifycount` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '等待审核成员数',
  `new_informcount` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '等待处理举报数',
  `mapply_open` tinyint(4) NOT NULL DEFAULT '0' COMMENT '申请管理是否开启 0关闭，1开启',
  `mapply_ml` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成员级别',
  `new_mapplycount` int(5) unsigned NOT NULL DEFAULT '0' COMMENT '管理申请数量',
  PRIMARY KEY (`circle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='圈子表';

CREATE TABLE `#__circle_affix` (
  `affix_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '附件id',
  `affix_filename` varchar(100) NOT NULL COMMENT '文件名称',
  `affix_filethumb` varchar(100) NOT NULL COMMENT '缩略图名称',
  `affix_filesize` int(10) unsigned NOT NULL COMMENT '文件大小，单位字节',
  `affix_addtime` varchar(10) NOT NULL COMMENT '上传时间',
  `affix_type` tinyint(3) unsigned NOT NULL COMMENT '文件类型 0无 1主题 2评论',
  `member_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `theme_id` int(11) unsigned NOT NULL COMMENT '主题id',
  `reply_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  PRIMARY KEY (`affix_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='附件表';

CREATE TABLE `#__circle_class` (
  `class_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '圈子分类id',
  `class_name` varchar(50) NOT NULL COMMENT '圈子分类名称',
  `class_addtime` varchar(10) NOT NULL COMMENT '圈子分类创建时间',
  `class_sort` tinyint(3) unsigned NOT NULL COMMENT '圈子分类排序',
  `class_status` tinyint(3) unsigned NOT NULL COMMENT '圈子分类状态 0不显示，1显示',
  `is_recommend` tinyint(3) unsigned NOT NULL COMMENT '是否推荐 0未推荐，1已推荐',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='圈子分类表';

CREATE TABLE `#__circle_explog` (
  `el_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '经验日志id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `member_id` int(11) unsigned NOT NULL COMMENT '成员id',
  `member_name` varchar(50) NOT NULL COMMENT '成员名称',
  `el_exp` int(10) NOT NULL COMMENT '获得经验',
  `el_time` varchar(10) NOT NULL COMMENT '获得时间',
  `el_type` tinyint(3) unsigned NOT NULL COMMENT '类型 1管理员操作 2发表话题 3发表回复 4话题被回复 5话题被删除 6回复被删除',
  `el_itemid` varchar(100) NOT NULL COMMENT '信息id',
  `el_desc` varchar(255) NOT NULL COMMENT '描述',
  PRIMARY KEY (`el_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='经验日志表';

CREATE TABLE `#__circle_expmember` (
  `member_id` int(11) NOT NULL COMMENT '成员id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `em_exp` int(10) NOT NULL COMMENT '获得经验',
  `em_time` varchar(10) NOT NULL COMMENT '获得时间',
  PRIMARY KEY (`member_id`,`circle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='成员每天获得经验表';

CREATE TABLE `#__circle_exptheme` (
  `theme_id` int(11) unsigned NOT NULL COMMENT '主题id',
  `et_exp` int(10) NOT NULL COMMENT '获得经验',
  `et_time` varchar(10) NOT NULL COMMENT '获得时间',
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主题每天获得经验表';

CREATE TABLE `#__circle_fs` (
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `friendship_id` int(11) unsigned NOT NULL COMMENT '友情圈子id',
  `friendship_name` varchar(11) NOT NULL COMMENT '友情圈子名称',
  `friendship_sort` tinyint(4) unsigned NOT NULL COMMENT '友情圈子排序',
  `friendship_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '友情圈子名称 1显示 0隐藏',
  PRIMARY KEY (`circle_id`,`friendship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='友情圈子表';

CREATE TABLE `#__circle_inform` (
  `inform_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '举报id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `circle_name` varchar(12) NOT NULL COMMENT '圈子名称',
  `theme_id` int(11) unsigned NOT NULL COMMENT '话题id',
  `theme_name` varchar(50) NOT NULL COMMENT '主题名称',
  `reply_id` int(11) unsigned NOT NULL COMMENT '回复id',
  `member_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `inform_content` varchar(255) NOT NULL COMMENT '举报内容',
  `inform_time` varchar(10) NOT NULL COMMENT '举报时间',
  `inform_type` tinyint(4) NOT NULL COMMENT '类型 0话题、1回复',
  `inform_state` tinyint(4) NOT NULL COMMENT '状态 0未处理、1已处理',
  `inform_opid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作人id',
  `inform_opname` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人名称',
  `inform_opexp` tinyint(4) NOT NULL COMMENT '操作经验',
  `inform_opresult` varchar(255) NOT NULL DEFAULT '' COMMENT '处理结果',
  PRIMARY KEY (`inform_id`),
  KEY `circle_id` (`circle_id`,`theme_id`,`reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='圈子举报表';

CREATE TABLE `#__circle_like` (
  `theme_id` int(11) unsigned NOT NULL COMMENT '主题id',
  `member_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主题赞表';

CREATE TABLE `#__circle_mapply` (
  `mapply_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '申请id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `member_id` int(11) unsigned NOT NULL COMMENT '成员id',
  `mapply_reason` varchar(255) NOT NULL COMMENT '申请理由',
  `mapply_time` varchar(10) NOT NULL COMMENT '申请时间',
  PRIMARY KEY (`mapply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='申请管理表';

CREATE TABLE `#__circle_member` (
  `member_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `circle_name` varchar(12) NOT NULL COMMENT '圈子名称',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `cm_applycontent` varchar(255) DEFAULT '' COMMENT '申请内容',
  `cm_applytime` varchar(10) NOT NULL COMMENT '申请时间',
  `cm_state` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0申请中 1通过 2未通过',
  `cm_intro` varchar(255) DEFAULT '' COMMENT '自我介绍',
  `cm_jointime` varchar(10) NOT NULL COMMENT '加入时间',
  `cm_level` int(11) NOT NULL DEFAULT '1' COMMENT '成员级别',
  `cm_levelname` varchar(10) NOT NULL DEFAULT '初级粉丝' COMMENT '成员头衔',
  `cm_exp` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '会员经验',
  `cm_nextexp` int(10) NOT NULL DEFAULT '5' COMMENT '下一级所需经验',
  `is_identity` tinyint(3) unsigned NOT NULL COMMENT '1圈主 2管理 3成员',
  `is_allowspeak` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否允许发言 1允许 0禁止',
  `is_star` tinyint(4) NOT NULL DEFAULT '0' COMMENT '明星成员 1是 0否',
  `cm_thcount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主题数',
  `cm_comcount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复数',
  `cm_lastspeaktime` varchar(10) DEFAULT '' COMMENT '最后发言时间',
  `is_recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐 1是 0否',
  PRIMARY KEY (`member_id`,`circle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='圈子会员表';

CREATE TABLE `#__circle_ml` (
  `circle_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '圈子id',
  `mlref_id` int(10) DEFAULT NULL COMMENT '参考头衔id 0为默认 null为自定义',
  `ml_1` varchar(10) NOT NULL COMMENT '1级头衔名称',
  `ml_2` varchar(10) NOT NULL COMMENT '2级头衔名称',
  `ml_3` varchar(10) NOT NULL COMMENT '3级头衔名称',
  `ml_4` varchar(10) NOT NULL COMMENT '4级头衔名称',
  `ml_5` varchar(10) NOT NULL COMMENT '5级头衔名称',
  `ml_6` varchar(10) NOT NULL COMMENT '6级头衔名称',
  `ml_7` varchar(10) NOT NULL COMMENT '7级头衔名称',
  `ml_8` varchar(10) NOT NULL COMMENT '8级头衔名称',
  `ml_9` varchar(10) NOT NULL COMMENT '9级头衔名称',
  `ml_10` varchar(10) NOT NULL COMMENT '10级头衔名称',
  `ml_11` varchar(10) NOT NULL COMMENT '11级头衔名称',
  `ml_12` varchar(10) NOT NULL COMMENT '12级头衔名称',
  `ml_13` varchar(10) NOT NULL COMMENT '13级头衔名称',
  `ml_14` varchar(10) NOT NULL COMMENT '14级头衔名称',
  `ml_15` varchar(10) NOT NULL COMMENT '15级头衔名称',
  `ml_16` varchar(10) NOT NULL COMMENT '16级头衔名称',
  PRIMARY KEY (`circle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员头衔表';

CREATE TABLE `#__circle_mldefault` (
  `mld_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '头衔等级',
  `mld_name` varchar(10) NOT NULL COMMENT '头衔名称',
  `mld_exp` int(10) NOT NULL COMMENT '所需经验值',
  PRIMARY KEY (`mld_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='成员头衔默认设置表';

CREATE TABLE `#__circle_mlref` (
  `mlref_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '参考头衔id',
  `mlref_name` varchar(10) NOT NULL COMMENT '参考头衔名称',
  `mlref_addtime` varchar(10) NOT NULL COMMENT '创建时间',
  `mlref_status` tinyint(3) unsigned NOT NULL COMMENT '状态',
  `mlref_1` varchar(10) NOT NULL COMMENT '1级头衔名称',
  `mlref_2` varchar(10) NOT NULL COMMENT '2级头衔名称',
  `mlref_3` varchar(10) NOT NULL COMMENT '3级头衔名称',
  `mlref_4` varchar(10) NOT NULL COMMENT '4级头衔名称',
  `mlref_5` varchar(10) NOT NULL COMMENT '5级头衔名称',
  `mlref_6` varchar(10) NOT NULL COMMENT '6级头衔名称',
  `mlref_7` varchar(10) NOT NULL COMMENT '7级头衔名称',
  `mlref_8` varchar(10) NOT NULL COMMENT '8级头衔名称',
  `mlref_9` varchar(10) NOT NULL COMMENT '9级头衔名称',
  `mlref_10` varchar(10) NOT NULL COMMENT '10级头衔名称',
  `mlref_11` varchar(10) NOT NULL COMMENT '11级头衔名称',
  `mlref_12` varchar(10) NOT NULL COMMENT '12级头衔名称',
  `mlref_13` varchar(10) NOT NULL COMMENT '13级头衔名称',
  `mlref_14` varchar(10) NOT NULL COMMENT '14级头衔名称',
  `mlref_15` varchar(10) NOT NULL COMMENT '15级头衔名称',
  `mlref_16` varchar(10) NOT NULL COMMENT '16级头衔名称',
  PRIMARY KEY (`mlref_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='会员参考头衔表';

CREATE TABLE `#__circle_recycle` (
  `recycle_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '回收站id',
  `member_id` int(11) NOT NULL COMMENT '会员id',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `circle_name` varchar(12) NOT NULL COMMENT '圈子名称',
  `theme_name` varchar(50) NOT NULL COMMENT '主题名称',
  `recycle_content` text NOT NULL COMMENT '内容',
  `recycle_opid` int(11) unsigned NOT NULL COMMENT '操作人id',
  `recycle_opname` varchar(50) NOT NULL COMMENT '操作人名称',
  `recycle_type` tinyint(3) unsigned NOT NULL COMMENT '类型 1话题，2回复',
  `recycle_time` varchar(10) NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`recycle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='圈子回收站表';

CREATE TABLE `#__circle_thclass` (
  `thclass_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主题分类id',
  `thclass_name` varchar(20) NOT NULL COMMENT '主题名称',
  `thclass_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '主题状态 1开启，0关闭',
  `is_moderator` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '管理专属 1是，0否',
  `thclass_sort` tinyint(3) unsigned NOT NULL COMMENT '分类排序',
  `circle_id` int(11) unsigned NOT NULL COMMENT '所属圈子id',
  PRIMARY KEY (`thclass_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='圈子主题分类表';

CREATE TABLE `#__circle_theme` (
  `theme_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主题id',
  `theme_name` varchar(50) NOT NULL COMMENT '主题名称',
  `theme_content` text NOT NULL COMMENT '主题内容',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `circle_name` varchar(12) NOT NULL COMMENT '圈子名称',
  `thclass_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '主题分类id',
  `thclass_name` varchar(20) NOT NULL COMMENT '主题分类名称',
  `member_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `is_identity` tinyint(3) unsigned NOT NULL COMMENT '1圈主 2管理 3成员',
  `theme_addtime` varchar(10) NOT NULL COMMENT '主题发表时间',
  `theme_editname` varchar(50) DEFAULT NULL COMMENT '编辑人名称',
  `theme_edittime` varchar(10) DEFAULT NULL COMMENT '主题编辑时间',
  `theme_likecount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢数量',
  `theme_commentcount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `theme_browsecount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数量',
  `theme_sharecount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分享数量',
  `is_stick` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶 1是  0否',
  `is_digest` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否加精 1是 0否',
  `lastspeak_id` int(11) unsigned DEFAULT NULL COMMENT '最后发言人id',
  `lastspeak_name` varchar(50) DEFAULT NULL COMMENT '最后发言人名称',
  `lastspeak_time` varchar(10) DEFAULT NULL COMMENT '最后发言时间',
  `has_goods` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品标记 1是 0否',
  `has_affix` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '附件标记 1是 0 否',
  `is_closed` tinyint(4) NOT NULL DEFAULT '0' COMMENT '屏蔽 1是 0否',
  `is_recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐 1是 0否',
  `is_shut` tinyint(4) NOT NULL DEFAULT '0' COMMENT '主题是否关闭 1是 0否',
  `theme_exp` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '获得经验',
  `theme_readperm` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '阅读权限',
  `theme_special` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '特殊话题 0普通 1投票',
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='圈子主题表';

CREATE TABLE `#__circle_thg` (
  `themegoods_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主题商品id',
  `theme_id` int(11) NOT NULL COMMENT '主题id',
  `reply_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `goods_name` varchar(100) NOT NULL COMMENT '商品名称',
  `goods_price` decimal(10,2) NOT NULL COMMENT '商品价格',
  `goods_image` varchar(1000) NOT NULL COMMENT '商品图片',
  `store_id` int(11) NOT NULL COMMENT '店铺id',
  `thg_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '商品类型 0为本商城、1为淘宝 默认为0',
  `thg_url` varchar(1000) DEFAULT NULL COMMENT '商品链接',
  PRIMARY KEY (`themegoods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='主题商品表';

CREATE TABLE `#__circle_thpoll` (
  `theme_id` int(11) unsigned NOT NULL COMMENT '话题id',
  `poll_multiple` tinyint(3) unsigned NOT NULL COMMENT '单/多选 0单选、1多选',
  `poll_startime` varchar(10) NOT NULL COMMENT '开始时间',
  `poll_endtime` varchar(10) NOT NULL COMMENT '结束时间',
  `poll_days` tinyint(3) unsigned NOT NULL COMMENT '投票天数',
  `poll_voters` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '投票参与人数',
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票表';

CREATE TABLE `#__circle_thpolloption` (
  `pollop_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '投票选项id',
  `theme_id` int(11) unsigned NOT NULL COMMENT '话题id',
  `pollop_option` varchar(80) NOT NULL COMMENT '投票选项',
  `pollop_votes` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '得票数',
  `pollop_sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `pollop_votername` mediumtext COMMENT '投票者名称',
  PRIMARY KEY (`pollop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='投票选项表';

CREATE TABLE `#__circle_thpollvoter` (
  `theme_id` int(11) unsigned NOT NULL COMMENT '话题id',
  `member_id` int(11) unsigned NOT NULL COMMENT '成员id',
  `member_name` varchar(50) NOT NULL COMMENT '成员名称',
  `pollvo_options` mediumtext NOT NULL COMMENT '投票选项',
  `pollvo_time` varchar(10) NOT NULL COMMENT '投票选项',
  KEY `theme_id` (`theme_id`,`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='成员投票信息表';

CREATE TABLE `#__circle_threply` (
  `theme_id` int(11) unsigned NOT NULL COMMENT '主题id',
  `reply_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `circle_id` int(11) unsigned NOT NULL COMMENT '圈子id',
  `member_id` int(11) unsigned NOT NULL COMMENT '会员id',
  `member_name` varchar(50) NOT NULL COMMENT '会员名称',
  `reply_content` text NOT NULL COMMENT '评论内容',
  `reply_addtime` varchar(10) NOT NULL COMMENT '发表时间',
  `reply_replyid` int(11) unsigned DEFAULT NULL COMMENT '回复楼层id',
  `reply_replyname` varchar(50) DEFAULT NULL COMMENT '回复楼层会员名称',
  `is_closed` tinyint(4) NOT NULL DEFAULT '0' COMMENT '屏蔽 1是 0否',
  `reply_exp` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '获得经验',
  PRIMARY KEY (`theme_id`,`reply_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主题评论表';

INSERT INTO `#__setting` (`name`, `value`) VALUES 
('circle_contentleast', '10'),
('circle_createsum', '6'),
('circle_exprelease', '2'),
('circle_expreleasemax', '10'),
('circle_expreplied', '3'),
('circle_exprepliedmax', '1000'),
('circle_expreply', '1'),
('circle_intervaltime', '1'),
('circle_iscreate', '1'),
('circle_istalk', '1'),
('circle_isuse', '1'),
('circle_joinsum', '12'),
('circle_loginpic', 'a:4:{i:1;a:2:{s:3:"pic";s:5:"1.jpg";s:3:"url";s:22:"http://www.baidu.com/";}i:2;a:2:{s:3:"pic";s:5:"2.jpg";s:3:"url";s:22:"http://www.baidu.com/";}i:3;a:2:{s:3:"pic";s:5:"3.jpg";s:3:"url";s:22:"http://www.baidu.com/";}i:4;a:2:{s:3:"pic";s:5:"4.jpg";s:3:"url";s:22:"http://www.baidu.com/";}}'),
('circle_logo', 'logo.png'),
('circle_managesum', '4'),
('circle_name', '圈子'),
('circle_seodescription', '发现精彩：圈子是买家们自己创建的私属领地，我们排斥广告分子，我们热爱真实分享！'),
('circle_seokeywords', '圈子,帮派,讨论小组,购物,生活,分享,show,秀,商品,电子商务,社区,消费者社区,论坛,资讯,热门话题,朋友'),
('circle_seotitle', '发现精彩 - 圈子'),
('circle_wordfilter', NULL);

INSERT INTO `#__circle_mldefault` (`mld_id`, `mld_name`, `mld_exp`) VALUES (1, '初级粉丝', 1),
(2, '中级粉丝', 5),
(3, '高级粉丝', 15),
(4, '正式会员', 30),
(5, '正式会员', 50),
(6, '核心会员', 100),
(7, '核心会员', 200),
(8, '铁杆会员', 500),
(9, '铁杆会员', 1000),
(10, '知名人士', 2000),
(11, '知名人士', 3000),
(12, '人气楷模', 6000),
(13, '人气楷模', 10000),
(14, '意见领袖', 18000),
(15, '资深元老', 30000),
(16, '荣耀元老', 60000);

INSERT INTO `#__circle_mlref` (`mlref_id`, `mlref_name`, `mlref_addtime`, `mlref_status`, `mlref_1`, `mlref_2`, `mlref_3`, `mlref_4`, `mlref_5`, `mlref_6`, `mlref_7`, `mlref_8`, `mlref_9`, `mlref_10`, `mlref_11`, `mlref_12`, `mlref_13`, `mlref_14`, `mlref_15`, `mlref_16`) VALUES (1, '校园系列', '1371784037', 1, '托儿所', '幼儿园', '学前班', '一年级', '二年级', '三年级', '四年级', '五年级', '六年级', '初一', '初二', '初三', '高一', '高二', '高三', '大学'),
(2, '名气系列', '1371797598', 1, '默默无闻', '崭露头角', '锋芒毕露', '小有名气', '小有美名', '颇具名气', '颇具盛名', '富有名气', '富有美誉', '远近闻名', '崭露头角', '声名远扬', '赫赫有名', '大名鼎鼎', '如雷贯耳', '名扬四海'),
(3, '内涵系列', '1371884423', 1, '1L喂熊', '抢个沙发', '自带板凳', '路人甲君', '打酱油的', '华丽飘过', '前来围观', '我勒个去', '亮了瞎了', '兰州烧饼', '鸭梨山大', '笑而不语', '内牛满面', '虎躯一震', '霸气外露', '此贴必火'),
(4, '军衔系列', '1371884788', 1, '下士', '中士', '上士', '少尉', '中尉', '上尉', '大尉', '少校', '中校', '上校', '大校', '少将', '中将', '上将', '大将', '元帅'),
(5, '书生系列', '1371884953', 1, '白丁', '童生', '秀才', '举人', '举人', '贡士', '进士', '进士', '进士', '探花', '探花', '榜眼', '榜眼', '状元', '状元', '圣贤'),
(6, '武侠系列', '1371885047', 1, '初涉江湖', '无名之辈', '仗剑天涯', '人海孤鸿', '四方游侠', '江湖少侠', '后起之秀', '武林新贵', '武林高手', '英雄豪杰', '人中龙凤', '自成一派', '名震江湖', '武林盟主', '一代宗师', '笑傲江湖');
