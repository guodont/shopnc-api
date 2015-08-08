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

###积分信息

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
    index.php?act=circle&op=ajax_themeinfo

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
    index.php?act=circle&op=theme_detail

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
    index.php?act=circle&op=ajax_themeinfo

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
    index.php?act=circle&op=create_reply

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
    index.php?act=circle&op=del_reply

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
        
