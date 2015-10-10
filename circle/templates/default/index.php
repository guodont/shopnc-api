<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="homepage warp-all">
  <div class="layout-l">
    <div class="focus-banner flexslider">
      <ul class="slides">
        <?php if(!empty($output['loginpic']) && is_array($output['loginpic'])){?>
        <?php foreach($output['loginpic'] as $val){?>
        <li><a href="<?php if($val['url'] != ''){echo $val['url'];}else{echo 'javascript:void(0);';}?>" target="_blank"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_CIRCLE.'/'.$val['pic'];?>"></a></li>
        <?php }?>
        <?php }?>
      </ul>
    </div>
  </div>
  <div class="layout-r">
    <?php if($_SESSION['is_login'] == 0){?>
    <dl class="member-no-login">
      <dd class="avatar"><img src="<?php  echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('default_user_portrait');?>" /> </dd>
      <dd class="welcomes"><?php echo $lang['circle_welcome_to']?><strong><?php echo C('circle_name');?></strong></dd>
      <dd class="quick-link"> <?php echo $lang['circle_login_prompt_one'];?><a href="javascript:void(0);" nctype="login" class="url">[<?php echo $lang['nc_login'];?>]</a><?php echo $lang['circle_login_prompt_two'];?><br/>
        <?php echo $lang['circle_register_prompt_one'];?><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=login&op=register" class="url">[<?php echo $lang['nc_register'];?>]</a><?php echo $lang['circle_register_prompt_two'];?></dd>
    </dl>
    <?php }else{?>
    <dl class="member-me-info">
      <dt class="member-name"><?php echo $_SESSION['member_name'];?></dt>
      <dd class="avatar"><img src="<?php  echo getMemberAvatarForID($_SESSION['member_id']);?>" /><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_information&op=avatar" title="<?php echo $lang['nc_edit_avatar'];?>"><?php echo $lang['nc_edit_avatar'];?></a></dd>
      <dd class="welcomes"> <?php echo $lang['circle_welcome_back_to'].C('circle_name');?></dd>
      <dd class="go-btn"><a target="_blank" href="index.php?act=p_center"><?php echo $lang['circle_into_user_centre'];?></a></dd>
      <dd class="quick-link"> <a target="_blank" href="index.php?act=p_center&op=my_group" class="url"><?php echo $lang['my_circle'];?></a> <a href="index.php?act=p_center" class="url"><?php echo $lang['my_theme'];?></a> <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=login&op=loginout" class="url"><?php echo $lang['nc_logout'];?></a> </dd>
    </dl>
    <?php }?>
    <?php if(!empty($output['hot_themelist'])){$array = array_slice($output['hot_themelist'], 0, 5);?>
    <div class="group-theme-list">
      <ul>
        <?php foreach($array as $val){?>
        <li><span>[<?php echo ($val['thclass_name'] != ''?$val['thclass_name']:$lang['nc_default']);?>]</span><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>" title="<?php echo $val['theme_name'];?>"><?php echo $val['theme_name'];?></a></li>
        <?php }?>
      </ul>
    </div>
    <?php }?>
    <div class="new-group"><a href="javascript:void(0);" nctype="create_circle"><i></i><?php echo $lang['circle_create_my_new_circle'];?></a></div>
  </div>
  <?php if(!empty($output['circle_list'])){?>
  <div class="warp-all hot-group clearfix">
    <div class="title">
      <h3><i></i><?php echo $lang['circle_hot_group'];?></h3>
    </div>
    <div class="content">
      <ul class="group-list">
        <?php foreach ($output['circle_list'] as $val){?>
        <li>
          <dl>
            <dt class="group-name">
              <h4><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name'];?></a></h4>
            </dt>
            <dd class="group-pic"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><img src="<?php echo circleLogo($val['circle_id']);?>" /></a></dd>
            <dd class="group-stat"><span><em><?php echo $val['circle_thcount'];?></em><?php echo $lang['circle_theme'];?>&nbsp;(<i title="<?php echo $lang['circle_new_theme'];?>"><?php echo intval($output['nowthemecount_array'][$val['circle_id']]['count']);?></i>)</span><span><em><?php echo $val['circle_mcount'];?></em><?php echo $lang['circle_group_member'];?>&nbsp;(<i title="<?php echo $lang['circle_new_member'];?>"><?php echo intval($output['nowjoincount_array'][$val['circle_id']]['count']);?></i>)</span></dd>
            <dd class="group-intro" title="<?php if($val['circle_desc'] != ''){ echo $val['circle_desc'];}else{echo $lang['circle_desc_null_default'];}?>">
              <?php if($val['circle_desc'] != ''){ echo $val['circle_desc'];}else{echo $lang['circle_desc_null_default'];}?>
            </dd>
          </dl>
          <?php if(!empty($val['theme_list'])){?>
          <ul class="new-theme">
            <?php foreach ($val['theme_list'] as $v){?>
            <li>
              <dl>
                <dt class="theme-title"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $v['circle_id'];?>&t_id=<?php echo $v['theme_id'];?>" title="<?php echo $v['theme_name'];?>"><?php echo $v['theme_name'];?></a></dt>
                <dd class="member-avatar-s"><img src="<?php echo getMemberAvatarForID($v['member_id']);?>"/></dd>
                <dd class="theme-intro"><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $v['member_id'];?>" class="member-name" title="<?php echo $v['member_name'];?>"><?php echo $v['member_name'];?></a><span class="date"><?php echo @date('Y-m-d H:i', $v['theme_addtime']);?></span></dd>
              </dl>
            </li>
            <?php }?>
          </ul>
          <?php }?>
        </li>
        <?php }?>
      </ul>
    </div>
  </div>
  <?php }?>
  <div class="warp-all recommend-group">
    <div class="title">
      <h3><i></i><?php echo $lang['circle_recommend_group'];?></h3>
      <div class="group-class-nav">
        <?php if(!empty($output['class_list'])){?>
        <?php foreach ($output['class_list'] as $val){?>
        <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=search&op=group&class_id=<?php echo $val['class_id'];?>&class_name=<?php echo $val['class_name'];?>"><?php echo $val['class_name'];?></a>
        <?php }?>
        <?php }?>
      </div>
    </div>
    <div class="content">
      <ul id="mycarousel1" class="jcarousel-skin-tango">
        <?php if(!empty($output['rcircle_list'])){?>
        <?php foreach($output['rcircle_list'] as $val){?>
        <li title="<?php echo $val['circle_name'];?>"><img src="<?php echo circleLogo($val['circle_id']);?>" /><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>">
          <p class="extra"><?php echo $val['circle_name'];?></p>
          </a> </li>
        <?php }?>
        <?php }?>
      </ul>
    </div>
  </div>
  <div class="warp-all">
    <div class="layout-l">
      <div class="recommend-theme">
        <div class="title">
          <h3><?php echo $lang['circle_recommend_theme'];?></h3>
        </div>
        <div class="content">
          <ul class="recommend-theme-list">
            <?php if(!empty($output['theme_list'])){?>
            <?php foreach($output['theme_list'] as $val){?>
            <li>
              <dl>
                <dt class="theme-title" title="<?php echo $val['theme_name'];?>"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"><?php echo $val['theme_name'];?></a></dt>
                <dd class="thumb"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"><img src="<?php echo $val['affix'];?>" class="t-img" /></a></dd>
                <dd class="group-name" title="<?php echo $lang['circle_come_from'];?><?php echo $val['circle_name'];?>"><?php echo $lang['circle_come_from'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name'];?></a></dd>
              </dl>
            </li>
            <?php }?>
            <?php }?>
          </ul>
          <div class="clear"></div>
        </div>
        <div class="title">
          <h3><?php echo $lang['circle_friend_show_order'];?></h3>
        </div>
        <div class="content show-goods">
          <?php if(!empty($output['gtheme_list'])){?>
          <?php foreach ($output['gtheme_list'] as $val){?>
          <dl>
            <dt class="theme-title" title="<?php echo $val['theme_name'];?>"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"><?php echo $val['theme_name'];?></a></dt>
            <dd class="theme-info"><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $val['member_id'];?>" class="member-name" title="<?php echo $val['member_name'];?>"><?php echo $val['member_name'];?></a><span class="group-name"><?php echo $lang['circle_come_from'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>" title="<?php echo $val['circle_name'];?>"><?php echo $val['circle_name'];?></a></span>
            <dd class="member-avatar"><img src="<?php echo getMemberAvatarForID($val['member_id']);?>"/></dd>
            <?php if(!empty($output['thg_list'][$val['theme_id']])){?>
            <dd class="goods-list">
              <ul>
                <?php foreach($output['thg_list'][$val['theme_id']] as $val){?>
                <li class="thumb"><a href="<?php echo $val['thg_url'];?>"><img src="<?php echo $val['image'];?>" class="t-img" /></a></li>
                <?php }?>
              </ul>
            </dd>
            <?php }?>
          </dl>
          <?php }?>
          <?php }?>
        </div>
      </div>
    </div>
    <div class="layout-r">
      <div class="good-member clearfix">
        <div class="title">
          <h3><?php echo $lang['circle_excellent_goods'];?>...</h3>
        </div>
        <?php if(!empty($output['one_member'])){?>
        <div class="contnet special">
          <dl class="member-info">
            <dt class="name"><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $output['one_member']['member_id'];?>"><?php echo $output['one_member']['member_name'];?></a></dt>
            <dd class="avatar thumb"><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $output['one_member']['member_id'];?>"><img src="<?php echo getMemberAvatarForID($output['one_member']['member_id']);?>"  class="t-img"/></a></dd>
            <dd class="group"><?php echo $lang['circle_come_from'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $output['one_member']['circle_id'];?>"><?php echo $output['one_member']['circle_name'];?></a></dd>
            <dd class="intro"><?php echo $output['one_member']['cm_intro'];?></dd>
            <?php if(!empty($output['one_membertheme'])){?>
            <dd class="theme">
              <ul>
                <?php foreach ($output['one_membertheme'] as $val){?>
                <li><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"><span>[<?php echo ($val['thclass_name'] != ''?$val['thclass_name']:$lang['nc_default']);?>]</span><?php echo $val['theme_name'];?></a></li>
                <?php }?>
              </ul>
            </dd>
            <?php }?>
          </dl>
        </div>
        <?php }?>
        <?php if(!empty($output['more_membertheme'])){?>
        <div class="contnet normal">
          <?php foreach ($output['more_membertheme'] as $val){?>
          <dl class="member-info">
            <dt class="member-name"><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $val['member_id'];?>"><?php echo $val['member_name'];?></a></dt>
            <dd class="avatar"><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $val['member_id'];?>"><img src="<?php echo getMemberAvatarForID($val['member_id']);?>"/></a></dd>
            <dd class="theme"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"><span>[<?php echo ($val['thclass_name'] != ''?$val['thclass_name']:$lang['nc_default']);?>]</span><?php echo $val['theme_name'];?></a></dd>
          </dl>
          <?php }?>
        </div>
        <?php }?>
      </div>
      <?php require_once circle_template('index.themetop');?>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jcarousel/jquery.jcarousel.min.js" charset="utf-8"></script> 
<!-- 引入幻灯片JS --> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.flexslider-min.js"></script> 
<script>
$(function(){
// 绑定幻灯片事件 
	$('.flexslider').flexslider();
	//图片轮换
    	$('#mycarousel1').jcarousel({visible: 8,itemFallbackDimension: 300});

	//横高局中比例缩放隐藏显示图片
	$(window).load(function () {
		$(".recommend-theme-list .t-img").VMiddleImg({"width":145,"height":96});
		$(".good-member .t-img").VMiddleImg({"width":140,"height":96});
		$(".show-goods .t-img").VMiddleImg({"width":30,"height":30});
	});
});
$(function() {
	$(".tabs-nav > li > a").mouseover(function(e) {
	if (e.target == this) {
		var tabs = $(this).parent().parent().children("li");
		var panels = $(this).parents('.theme-top:first').find(".tabs-panel");
		var index = $.inArray(this, $(this).parent().parent().find("a"));
		if (panels.eq(index)[0]) {
			tabs.removeClass("tabs-selected")
				.eq(index).addClass("tabs-selected");
			panels.addClass("tabs-hide")
				.eq(index).removeClass("tabs-hide");
		}
	}
	});
});
</script> 