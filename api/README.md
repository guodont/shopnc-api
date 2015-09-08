#API

##数据格式约定

返回数据为json格式，code为200表示数据正常，datas为返回的数据

    {code: 200, datas: {}}
    
###返回值

####获取数据

    //有内容直接返回数组，无内容返回空数组[]
    //hasmore为是否有下一页
    {"code":200,"hasmore":true,"datas":{"goods_list":[]}}
    
####操作成功

    //操作成返回"1"
    {"code":200,"datas":{"1"}}
    
####错误

    //出现错误返回error，error内为错误信息
    {"code":200,"datas":{"error":"参数错误"}}
    //登录失败，login:0
    {"code":200,"login":"0","datas":{"error":"请登录"}}

##个人中心API

###登录

####登录接口(GET)
    index.php?act=login

####请求参数
    + username： 用户名
    + password：密码
    + client：客户端类型(android wap ios wechat)
    
####返回数据
    + username 用户名
    + uid  用户id
    + key 登录令牌
    
###注册

####注册接口(POST)
    index.php?act=login&op=register

####请求参数
    + username： 用户名
    + password：密码
    + assword_confirm 密码确认
    + email 邮箱
    + client：客户端类型(android wap ios wechat)
    
####返回数据
    + username 用户名
    + key 登录令牌
    
###注销

####注册接口(POST)
    index.php?act=logout

####请求参数
    + username： 用户名
    + key 当前登录令牌
    + client：客户端类型(android wap ios wechat)
    
####返回数据
    + 1

###用户信息

####接口(GET)
    index.php?act=user_center&op=user_info

####请求参数
    + uid : 用户id
####返回数据

    + user_info 用户信息数据
        + member_id 用户id
        + member_name 用户名
        + member_avatar 头像
        + member_email 邮箱
        + member_sex 性别
        + member_birthday 生日
        + member_mobile 手机
        + member_cityid 城市id
        + member_provinceid 省份id
        + level 等级
        + level_name 等级名称
        + member_points 用户积分
        + member_exppoints 经验值
        + following_count 关注数
        + follower_count 粉丝数
       
###用户粉丝列表

####接口(GET)
    index.php?act=user_center&op=followers

####请求参数
    + uid : 用户id
    + page:     每页数量
    + curpage:  当前页码
    
####返回数据

    + followers 用户粉丝信息数据
        + member_id 用户id
        + member_name 用户名
        + member_avatar 头像
        + member_sex 性别

###用户关注人列表

####接口(GET)
    index.php?act=user_center&op=following

####请求参数
    + uid : 用户id
    + page:     每页数量
    + curpage:  当前页码
    
####返回数据

    + followers 用户关注人息数据
        + member_id 用户id
        + member_name 用户名
        + member_avatar 头像
        + member_sex 性别

###用户商品收藏列表

####接口(GET)
    index.php?act=user_center&op=goods_favorites_list

####请求参数
    + uid : 用户id
    + page:     每页数量
    + curpage:  当前页码

####返回数据

    + goods_favorites_list
        +
###用户加入的圈子

####接口(GET)
    index.php?act=user_center&op=user_circles

####请求参数
    + uid : 用户id

####返回数据

    + circle_list
        +
###用户的话题

####接口(GET)
    index.php?act=user_center&op=user_themes

####请求参数
    + uid : 用户id
    + page:     每页数量
    + curpage:  当前页码

####返回数据

    + themes
        ＋

##圈子API

###圈子分类

####接口(GET)
    index.php?act=circle&op=class

####请求参数
无
####返回数据

    + circle_classes 分类数据
        + class_id 分类id
        + class_name 分类名称
        + class_addtime 分类创建时间
        + class_sort 排序
        + class_status 分类状态
        + is_recommend 是否推荐

###圈子搜索

####接口(GET)

    index.php?act=circle&op=group

####请求参数

    + keyword:  搜索关键字
    + class_id: 分类id
    + page:     每页数量
    + curpage:  当前页码

####返回数据

    + circle_info   圈子数据
        + circle_id 圈子id
        + circle_name   圈子名称
        + circle_desc   圈子描述
        + circle_masterid   圈主id
        + circle_mastername 圈主名称
        + circle_img    圈子图片
        + class_id  类别id
        + circle_mcount 圈子会员数
        + circle_thcount    圈子主题数
        + circle_gcount     圈子分组数
        + circle_pursuereason   圈子申请理由
        + circle_notice 圈子公告
        + circle_status 圈子状态，0关闭，1开启，2审核中，3审核失败
        + circle_statusinfo 关闭或审核失败原因
        + circle_statusinfo 加入圈子时候需要审核，0不需要，1需要
        + circle_statusinfo 圈子创建时间
        + circle_noticetime 圈子公告更新时间
        + is_recommend  是否推荐 0未推荐，1已推荐
        + is_hot    是否为热门圈子 1是 0否
        + circle_tag    圈子标签
        + new_verifycount   等待审核成员数
        + new_informcount   等待处理举报数
        + mapply_open   申请管理是否开启 0关闭，1开启
        + mapply_ml     成员级别
        + new_mapplycount   管理申请数量

###话题搜索

####接口(GET)
    index.php?act=circle&op=theme

####请求参数

    + keyword:  搜索关键字
    + class_id: 分类id
    + page:     每页数量
    + curpage:  当前页码

####返回数据

    + themes 话题数据
        + theme_id  主题id
        + theme_name    主题名称
        + theme_content 主题内容
        + circle_id 圈子id
        + circle_name   圈子名称
        + thclass_id    主题分类id
        + thclass_name  主题分类名称
        + member_id 会员id
        + member_name   会员名称
        + is_identity   1圈主 2管理 3成员
        + theme_addtime 主题发表时间    
        + theme_editname    编辑人名称
        + theme_edittime    主题编辑时间
        + theme_likecount   喜欢数量
        + theme_commentcount    评论数量
        + theme_browsecount 浏览数量
        + theme_sharecount  分享数量
        + is_stick  是否置顶 1是  0否
        + is_digest 是否加精 1是 0否
        + lastspeak_id  最后发言人id
        + lastspeak_name    最后发言人名称
        + lastspeak_time    最后发言时间
        + has_goods 商品标记 1是 0否
        + has_affix 附件标记 1是 0 否
        + is_closed 屏蔽 1是 0否
        + is_recommend  是否推荐 1是 0否
        + is_shut   主题是否关闭 1是 0否
        + theme_exp 获得经验
        + theme_readperm    阅读权限
        + theme_special 特殊话题 0普通 1投票


###圈子所有话题

####接口(GET)
    index.php?act=circle&op=circleThemes

####请求参数
    + page:     每页数量
    + curpage:  当前页码
####返回数据

    + themes 话题数据
        + theme_id  主题id
        + theme_name    主题名称
        + theme_content 主题内容
        + circle_id 圈子id
        + circle_name   圈子名称
        + thclass_id    主题分类id
        + thclass_name  主题分类名称
        + member_id 会员id
        + member_name   会员名称
        + member_avatar 会员头像
        + is_identity   1圈主 2管理 3成员
        + theme_addtime 主题发表时间    
        + theme_editname    编辑人名称
        + theme_edittime    主题编辑时间
        + theme_likecount   喜欢数量
        + theme_commentcount    评论数量
        + theme_browsecount 浏览数量
        + theme_sharecount  分享数量
        + is_stick  是否置顶 1是  0否
        + is_digest 是否加精 1是 0否
        + lastspeak_id  最后发言人id
        + lastspeak_name    最后发言人名称
        + lastspeak_time    最后发言时间
        + has_goods 商品标记 1是 0否
        + has_affix 附件标记 1是 0 否
        + is_closed 屏蔽 1是 0否
        + is_recommend  是否推荐 1是 0否
        + is_shut   主题是否关闭 1是 0否
        + theme_exp 获得经验
        + theme_readperm    阅读权限
        + theme_special 特殊话题 0普通 1投票


###圈子详细信息

####接口(GET)
    index.php?act=circle&op=circleInfo

####请求参数

    + circle_id: 圈子id


####返回数据

    + circle_info   圈子信息
        + circle_id 圈子id
        + circle_name   圈子名称
        + circle_desc   圈子描述
        + circle_masterid   圈主id
        + circle_mastername 圈主名称
        + circle_masteravatar 圈主头像
        + circle_img    圈子图片
        + class_id  类别id
        + circle_mcount 圈子会员数
        + circle_thcount    圈子主题数
        + circle_gcount     圈子分组数
        + circle_pursuereason   圈子申请理由
        + circle_notice 圈子公告
        + circle_status 圈子状态，0关闭，1开启，2审核中，3审核失败
        + circle_statusinfo 关闭或审核失败原因
        + circle_statusinfo 加入圈子时候需要审核，0不需要，1需要
        + circle_statusinfo 圈子创建时间
        + circle_noticetime 圈子公告更新时间
        + is_recommend  是否推荐 0未推荐，1已推荐
        + is_hot    是否为热门圈子 1是 0否
        + circle_tag    圈子标签
        + new_verifycount   等待审核成员数
        + new_informcount   等待处理举报数
        + mapply_open   申请管理是否开启 0关闭，1开启
        + mapply_ml     成员级别
        + new_mapplycount   管理申请数量
    + creator   创建者
    
    + manager_list  管理员列表


###话题详情

####接口(GET)
    index.php?act=circle_theme&op=ajax_themeinfo

####请求参数

    + c_id: 圈子id
    + t_id: 话题id
    + key:  访问令牌

####返回数据

    + theme_info 
        + theme_id  主题id
            + theme_name    主题名称
            + theme_content 主题内容
            + circle_id 圈子id
            + circle_name   圈子名称
            + thclass_id    主题分类id
            + thclass_name  主题分类名称
            + member_id 会员id
            + member_name   会员名称
            + member_avatar 会员头像
            + is_identity   1圈主 2管理 3成员
            + theme_addtime 主题发表时间    
            + theme_editname    编辑人名称
            + theme_edittime    主题编辑时间
            + theme_likecount   喜欢数量
            + theme_commentcount    评论数量
            + theme_browsecount 浏览数量
            + theme_sharecount  分享数量
            + is_stick  是否置顶 1是  0否
            + is_digest 是否加精 1是 0否
            + lastspeak_id  最后发言人id
            + lastspeak_name    最后发言人名称
            + lastspeak_time    最后发言时间
            + has_goods 商品标记 1是 0否
            + has_affix 附件标记 1是 0 否
            + is_closed 屏蔽 1是 0否
            + is_recommend  是否推荐 1是 0否
            + is_shut   主题是否关闭 1是 0否
            + theme_exp 获得经验
            + theme_readperm    阅读权限
            + theme_special 特殊话题 0普通 1投票

###话题回复信息

####接口(GET)
    index.php?act=circle_theme&op=theme_detail

####请求参数

    + c_id: 圈子id
    + key:  访问令牌
    + t_id: 话题id
    + only_id:  只看某个用户id的回复 

####返回数据
    + replys 回复数据
        + reply_id 评论id
        + circle_id 圈子id
        + member_id 会员id
        + member_name 会员名称
        + member_avatar 会员头像
        + reply_content 评论内容
        + reply_addtime 发表时间
        + reply_replyid 回复楼层id
        + reply_replyname 回复楼层会员名称
        + is_closed 屏蔽 1是 0否
        + reply_exp 获得经验
    + member_list 参与用户列表
        + TODO
    
    + theme_nolike 用户是否赞过话题 赞过0 未赞1
        + TODO


###创建话题

####接口(POST)
    index.php?act=circle_theme&op=ajax_themeinfo

####请求参数

    + c_id: 圈子id
    + key:  访问令牌
    + name：话题标题
    + themecontent： 话题内容
    + readperm： 阅读权限(可为空) 

####返回数据
    + success: 创建成功
    + url：  话题链接url

###创建回复

####接口(POST)
    index.php?act=circle_theme&op=create_reply

####请求参数

    + c_id: 圈子id
    + t_id: 话题id
    + key:  访问令牌
    + replycontent： 回复内容
    + answer_id: 回复楼层id （回复话题时为空）

####返回数据
    + success: 回复成功

###删除回复

####接口(POST)
    index.php?act=circle_theme&op=del_reply

####请求参数

    + r_id: 回复id
    + t_id: 话题id
    + key:  访问令牌

####返回数据

    + success: 成功消息

###推荐话题

####接口(GET)
    index.php?act=circle&op=get_theme_list

####请求参数

    + page:     每页数量
    + curpage:  当前页码

####返回数据

    + theme_list 
        + theme_id  主题id
        + theme_name    主题名称
        + theme_content 主题内容
        + circle_id 圈子id
        + circle_name   圈子名称
        + thclass_id    主题分类id
        + thclass_name  主题分类名称
        + member_id 会员id
        + member_name   会员名称
        + member_avatar   会员头像
        + is_identity   1圈主 2管理 3成员
        + theme_addtime 主题发表时间    
        + theme_editname    编辑人名称
        + theme_edittime    主题编辑时间
        + theme_likecount   喜欢数量
        + theme_commentcount    评论数量
        + theme_browsecount 浏览数量
        + theme_sharecount  分享数量
        + is_stick  是否置顶 1是  0否
        + is_digest 是否加精 1是 0否
        + lastspeak_id  最后发言人id
        + lastspeak_name    最后发言人名称
        + lastspeak_time    最后发言时间
        + has_goods 商品标记 1是 0否
        + has_affix 附件标记 1是 0 否
        + is_closed 屏蔽 1是 0否
        + is_recommend  是否推荐 1是 0否
        + is_shut   主题是否关闭 1是 0否
        + theme_exp 获得经验
        + theme_readperm    阅读权限
        + theme_special 特殊话题 0普通 1投票
      
###人气话题

####接口(GET)
    index.php?act=circle&op=get_reply_themelist

####请求参数

    + page:     每页数量
    + curpage:  当前页码

####返回数据

    + reply_themelist： 
        + theme_id  主题id
        + theme_name    主题名称
        + theme_content 主题内容
        + circle_id 圈子id
        + circle_name   圈子名称
        + thclass_id    主题分类id
        + thclass_name  主题分类名称
        + member_id 会员id
        + member_name   会员名称
        + member_avatar   会员头像
        + is_identity   1圈主 2管理 3成员
        + theme_addtime 主题发表时间    
        + theme_editname    编辑人名称
        + theme_edittime    主题编辑时间
        + theme_likecount   喜欢数量
        + theme_commentcount    评论数量
        + theme_browsecount 浏览数量
        + theme_sharecount  分享数量
        + is_stick  是否置顶 1是  0否
        + is_digest 是否加精 1是 0否
        + lastspeak_id  最后发言人id
        + lastspeak_name    最后发言人名称
        + lastspeak_time    最后发言时间
        + has_goods 商品标记 1是 0否
        + has_affix 附件标记 1是 0 否
        + is_closed 屏蔽 1是 0否
        + is_recommend  是否推荐 1是 0否
        + is_shut   主题是否关闭 1是 0否
        + theme_exp 获得经验
        + theme_readperm    阅读权限
        + theme_special 特殊话题 0普通 1投票
        
##交易API

###交易分类

####描述

交易的分类接口

传入gc_id 为0时返回数据为所有一级分类，反之为gc_id 的下一级分类，无下一级分类时返回class_list: 0

####接口(GET)
    index.php?act=trade_class

####请求参数
    + gc_id : 父级分类id 0为所有一级分类
    
####返回数据

    + class_list 分类数据
        + gc_id 分类id
        + gc_name 分类名称

###所有交易列表

####接口(GET)
    index.php?act=trade&op=all_trade_list

####请求参数
    + page:     每页数量
    + curpage:  当前页码
    
####返回数据

    + trade_list 交易数据
        + goods_id 交易id
        + goods_name 交易名称
        + gc_name 分类名称
        + member_id 发布者id
        + member_name 发布者名字
        + goods_image 交易图片
        + goods_tag 交易标签
        + goods_price 交易原价交
        + goods_store_price 交易转让价格
        + goods_click 交易浏览数
        + flea_collect_num  总收藏次数
        + goods_add_time 交易添加时间
        + goods_description 交易描述
        + commentnum 评论数
        + salenum 售出数
        + flea_quality 闲置物品成色，0未选择，9-5九五成新，3是低于五成新
        + flea_area_name 闲置物品地区名称
        + member_avatar 发布者头像
        + time  发布时间 格式为 xx秒/时/小时/月/年前 

###分类下所有交易

####接口(GET)
    index.php?act=trade&op=class_trade_list

####请求参数
    + page:     每页数量
    + curpage:  当前页码
    + cid:      分类id
    
####返回数据

    + trade_list 交易数据
        + goods_id 交易id
        + goods_name 交易名称
        + gc_name 分类名称
        + member_id 发布者id
        + member_name 发布者名字
        + goods_image 交易图片
        + goods_tag 交易标签
        + goods_price 交易原价交
        + goods_store_price 易转让价格
        + goods_click 交易浏览数
        + flea_collect_num  总收藏次数
        + goods_add_time 交易添加时间
        + goods_description 交易描述
        + commentnum 评论数
        + salenum 售出数
        + flea_quality 闲置物品成色，0未选择，9-5九五成新，3是低于五成新
        + flea_area_name 闲置物品地区名称
        + member_avatar 发布者头像
        + time  发布时间 格式为 xx秒/时/小时/月/年前    

###交易详情

####接口(GET)
    index.php?act=trade&op=trade_info

####请求参数
    + page:     每页数量
    + curpage:  当前页码
    + tid:      交易id
    
####返回数据

    + trade_info 交易详情数据
        + goods_id 交易id
        + goods_name 交易名称
        + gc_id 分类id
        + gc_name 分类名称
        + member_id 发布者id
        + member_name 发布者名字
        + goods_image 交易图片
        + goods_tag 交易标签
        + goods_price 交易原价
        + goods_store_price 交易转让价格
        + goods_show 是否上架 1 上架 0 下架
        + goods_click 交易浏览数
        + flea_collect_num 总收藏次数
        + goods_commend 闲置推荐 1 推荐 0 默认
        + goods_add_time 交易添加时间
        + goods_keywords 交易关键字
        + goods_description 交易描述
        + goods_body    交易详细内容
        + commentnum 评论数
        + salenum 售出数
        + flea_quality 闲置物品成色，0未选择，9-5九五成新，3是低于五成新
        + flea_pname 闲置商品联系人
        + flea_pphone 闲置商品联系人电话
        + flea_area_id 闲置物品地区id
        + flea_area_name 闲置物品地区名称
        + member_avatar 发布者头像
        + time     发布时间 格式为 xx秒/时/小时/月/年前  
           
###用户所有交易

####接口(GET)
    index.php?act=trade&op=user_trade_list

####请求参数
    + page:     每页数量
    + curpage:  当前页码
    + uid:      用户id
    
####返回数据

    + trade_list 交易数据
        + goods_id 交易id
        + goods_name 交易名称
        + gc_name 分类名称
        + member_id 发布者id
        + member_name 发布者名字
        + goods_image 交易图片
        + goods_tag 交易标签
        + goods_price 交易原价交
        + goods_store_price 易转让价格
        + goods_click 交易浏览数
        + flea_collect_num  总收藏次数
        + goods_add_time 交易添加时间
        + goods_description 交易描述
        + commentnum 评论数
        + salenum 售出数
        + flea_quality 闲置物品成色，0未选择，9-5九五成新，3是低于五成新
        + flea_area_name 闲置物品地区名称
        + member_avatar 发布者头像
        + time  发布时间 格式为 xx秒/时/小时/月/年前    

##问答api

###所有问答类型

####接口(GET)
    index.php?act=question&op=allQuestionType

####请求参数
####返回数据
    + questionClasses:
        + thclass_id
        + thclass_name
        + thclass_status
        + is_moderator
        + thclass_sort
        + circle_id
        
###所有问答话题列表

####接口(GET)
    index.php?act=question&op=allQuestions

####请求参数
    + type: 5 问专家 6 问达人
    + c_id: 圈子id 不传时默认为0 首页不需要传
    + page:     每页数量
    + curpage:  当前页码
    
####返回数据
    + questions： 
        + theme_id  问题id
        + theme_name    问题名称
        + theme_content 问题内容
        + circle_id 圈子id
        + circle_name   圈子名称
        + thclass_id    主题分类id
        + thclass_name  主题分类名称
        + member_id 会员id
        + member_name   会员名称
        + member_avatar   会员头像
        + is_identity   1圈主 2管理 3成员
        + theme_addtime 主题发表时间    
        + theme_editname    编辑人名称
        + theme_edittime    主题编辑时间
        + theme_likecount   喜欢数量
        + theme_commentcount    评论数量
        + theme_browsecount 浏览数量
        + theme_sharecount  分享数量
        + is_stick  是否置顶 1是  0否
        + is_digest 是否加精 1是 0否
        + lastspeak_id  最后发言人id
        + lastspeak_name    最后发言人名称
        + lastspeak_time    最后发言时间
        + has_goods 商品标记 1是 0否
        + has_affix 附件标记 1是 0 否
        + is_closed 屏蔽 1是 0否
        + is_recommend  是否推荐 1是 0否
        + is_shut   主题是否关闭 1是 0否
        + theme_exp 获得经验
        + theme_readperm    阅读权限
        + theme_special 特殊话题 0普通 1投票
        
###问题详情

####接口(GET)
    index.php?act=question&op=question

####请求参数
    + q_id: 问题（话题）id
    
####返回数据
    + questionInfo： 
        + theme_id  问题id
        + theme_name    问题名称
        + theme_content 问题内容
        + circle_id 圈子id
        + circle_name   圈子名称
        + thclass_id    主题分类id
        + thclass_name  主题分类名称
        + member_id 会员id
        + member_name   会员名称
        + member_avatar   会员头像
        + is_identity   1圈主 2管理 3成员
        + theme_addtime 主题发表时间    
        + theme_editname    编辑人名称
        + theme_edittime    主题编辑时间
        + theme_likecount   喜欢数量
        + theme_commentcount    评论数量
        + theme_browsecount 浏览数量
        + theme_sharecount  分享数量
        + is_stick  是否置顶 1是  0否
        + is_digest 是否加精 1是 0否
        + lastspeak_id  最后发言人id
        + lastspeak_name    最后发言人名称
        + lastspeak_time    最后发言时间
        + has_goods 商品标记 1是 0否
        + has_affix 附件标记 1是 0 否
        + is_closed 屏蔽 1是 0否
        + is_recommend  是否推荐 1是 0否
        + is_shut   主题是否关闭 1是 0否
        + theme_exp 获得经验
        + theme_readperm    阅读权限
        
###问题回复信息

####接口(GET)
    index.php?act=question&op=answers

####请求参数

    + q_id: 问题id
    + page:     每页数量
    + curpage:  当前页码

####返回数据
    + answers 回复数据
        + reply_id 评论id
        + circle_id 圈子id
        + member_id 会员id
        + member_name 会员名称
        + member_avatar 会员头像
        + reply_content 评论内容
        + reply_addtime 发表时间
        + reply_replyid 回复楼层id
        + reply_replyname 回复楼层会员名称
        + is_closed 屏蔽 1是 0否
        + reply_exp 获得经验
    + member_list 参与用户列表
        + TODO

###创建一个问题

####接口(POST)
    index.php?act=question_answer&op=createQuestion

####请求参数

    + type:问答类型  5：问达人 6：问专家 
    + c_id: 圈子id 没有圈子id时传0（首页直接提问传0）
    + name：标题
    + content：内容
    + readperm：权限 默认为0
####返回数据
    + ok：
        + id： 问题id
###创建一个答案（回复）

####接口(POST)
    index.php?act=question_answer&op=create_answer

####请求参数

    + c_id: 圈子id 没有圈子id时传0
    + q_id: 问题id
    + key:  访问令牌
    + content： 回复内容
    + answer_id: 回复楼层id （回复话题时为空）
    
####返回数据
    + success: 回复成功