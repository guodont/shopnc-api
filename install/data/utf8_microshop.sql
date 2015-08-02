
CREATE TABLE `#__micro_adv` (
  `adv_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告编号',
  `adv_type` varchar(50) DEFAULT '' COMMENT '广告类型',
  `adv_name` varchar(255) NOT NULL DEFAULT '' COMMENT '广告名称',
  `adv_image` varchar(255) NOT NULL DEFAULT '' COMMENT '广告图片',
  `adv_url` varchar(255) NOT NULL DEFAULT '' COMMENT '广告链接',
  `adv_sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '广告排序',
  PRIMARY KEY (`adv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城广告表';

CREATE TABLE `#__micro_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论编号',
  `comment_type` tinyint(1) NOT NULL COMMENT '评论类型编号',
  `comment_object_id` int(10) unsigned NOT NULL COMMENT '推荐商品编号',
  `comment_message` varchar(255) NOT NULL COMMENT '评论内容',
  `comment_member_id` int(10) unsigned NOT NULL COMMENT '评论人编号',
  `comment_time` int(10) unsigned NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城商品评论表';

CREATE TABLE `#__micro_goods` (
  `commend_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '推荐编号',
  `commend_member_id` int(10) unsigned NOT NULL COMMENT '推荐人用户编号',
  `commend_goods_id` int(10) unsigned NOT NULL COMMENT '推荐商品编号',
  `commend_goods_commonid` int(10) unsigned NOT NULL COMMENT '商品公共表id',
  `commend_goods_store_id` int(10) unsigned NOT NULL COMMENT '推荐商品店铺编号',
  `commend_goods_name` varchar(100) NOT NULL COMMENT '推荐商品名称',
  `commend_goods_price` decimal(11,2) NOT NULL COMMENT '推荐商品价格',
  `commend_goods_image` varchar(100) NOT NULL COMMENT '推荐商品图片',
  `commend_message` varchar(1000) NOT NULL COMMENT '推荐信息',
  `commend_time` int(10) unsigned NOT NULL COMMENT '推荐时间',
  `class_id` int(10) unsigned NOT NULL,
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢数',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击数',
  `microshop_commend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页推荐 0-否 1-推荐',
  `microshop_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`commend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城推荐商品表随心看';

CREATE TABLE `#__micro_goods_class` (
  `class_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类编号 ',
  `class_name` varchar(50) NOT NULL COMMENT '分类名称',
  `class_parent_id` int(11) unsigned NOT NULL COMMENT '父级分类编号',
  `class_sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `class_keyword` varchar(500) NOT NULL DEFAULT '' COMMENT '分类关键字',
  `class_image` varchar(100) NOT NULL DEFAULT '' COMMENT '分类图片',
  `class_commend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推荐标志0-不推荐 1-推荐到首页',
  `class_default` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '默认标志，0-非默认 1-默认',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城商品随心看分类表';

CREATE TABLE `#__micro_goods_relation` (
  `relation_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '关系编号',
  `class_id` int(10) unsigned NOT NULL COMMENT '微商城商品分类编号',
  `shop_class_id` int(10) unsigned NOT NULL COMMENT '商城商品分类编号',
  PRIMARY KEY (`relation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城商品分类和商城商品分类对应关系';

CREATE TABLE `#__micro_like` (
  `like_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '喜欢编号',
  `like_type` tinyint(1) NOT NULL COMMENT '喜欢类型编号',
  `like_object_id` int(10) unsigned NOT NULL COMMENT '喜欢对象编号',
  `like_member_id` int(10) unsigned NOT NULL COMMENT '喜欢人编号',
  `like_time` int(10) unsigned NOT NULL COMMENT '喜欢时间',
  PRIMARY KEY (`like_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城喜欢表';

CREATE TABLE `#__micro_member_info` (
  `member_id` int(11) unsigned NOT NULL COMMENT '用户编号',
  `visit_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '个人中心访问计数',
  `personal_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '已发布个人秀数量',
  `goods_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '已发布随心看数量',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城用户信息表';

CREATE TABLE `#__micro_personal` (
  `personal_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '推荐编号',
  `commend_member_id` int(10) unsigned NOT NULL COMMENT '推荐人用户编号',
  `commend_image` text NOT NULL COMMENT '推荐图片',
  `commend_buy` text NOT NULL COMMENT '购买信息',
  `commend_message` varchar(1000) NOT NULL COMMENT '推荐信息',
  `commend_time` int(10) unsigned NOT NULL COMMENT '推荐时间',
  `class_id` int(10) unsigned NOT NULL,
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢数',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0',
  `microshop_commend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '首页推荐 0-否 1-推荐',
  `microshop_sort` tinyint(3) unsigned NOT NULL DEFAULT '255' COMMENT '排序',
  PRIMARY KEY (`personal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城个人秀表';

CREATE TABLE `#__micro_personal_class` (
  `class_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类编号 ',
  `class_name` varchar(50) NOT NULL COMMENT '分类名称',
  `class_sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `class_image` varchar(100) NOT NULL DEFAULT '' COMMENT '分类图片',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城个人秀分类表';

CREATE TABLE `#__micro_store` (
  `microshop_store_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '店铺街店铺编号',
  `shop_store_id` int(11) unsigned NOT NULL COMMENT '商城店铺编号',
  `microshop_sort` tinyint(1) unsigned DEFAULT '255' COMMENT '排序',
  `microshop_commend` tinyint(1) unsigned DEFAULT '1' COMMENT '推荐首页标志 1-正常 2-推荐',
  `like_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '喜欢数',
  `comment_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`microshop_store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微商城店铺街表';

INSERT INTO `#__setting` (`name`, `value`) VALUES ('microshop_goods_default_class', '0'),
('microshop_header_pic', ''),
('microshop_isuse', '1'),
('microshop_logo', ''),
('microshop_personal_limit', '50'),
('microshop_seo_description', '多用户商城,微商城,随心看,个人秀,店铺街'),
('microshop_seo_keywords', '多用户商城,微商城,随心看,个人秀,店铺街,网上购物'),
('microshop_store_banner', ''),
('microshop_style', 'default');
