<?php defined('InShopNC') or exit('Access Invalid!');?>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="public-top-layout w">
  <div class="topbar wrapper">
    <div class="user-entry">
    <?php if($_SESSION['is_login'] == '1'){?>
      <?php echo $lang['nc_hello'];?><span><a href="<?php echo urlShop('member', 'home');?>"><?php echo str_cut($_SESSION['member_name'],20);?></a></span><?php echo $lang['nc_comma'],$lang['welcome_to_site'];?>
      <a href="<?php echo SHOP_SITE_URL;?>"  title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><span><?php echo $output['setting_config']['site_name']; ?></span></a>
      <span>[<a href="<?php echo urlShop('login','logout');?>"><?php echo $lang['nc_logout'];?></a>]</span>
    <?php }else{?>
      <?php echo $lang['nc_hello'].$lang['nc_comma'].$lang['welcome_to_site'];?>
      <a href="<?php echo SHOP_SITE_URL;?>" title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><?php echo $output['setting_config']['site_name']; ?></a>
       <span>[<a href="<?php echo urlShop('login');?>"><?php echo $lang['nc_login'];?></a>]</span>
        <span>[<a href="<?php echo urlShop('login','register');?>"><?php echo $lang['nc_register'];?></a>]</span>
    <?php }?></div>

    <div class="quick-menu">
      <dl>
        <dt><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order">我的订单</a><i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_new">待付款订单</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_send">待确认收货</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_noeval">待评价交易</a></li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_favorites&op=fglist"><?php echo $lang['nc_favorites'];?></a><i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_favorites&op=fglist">商品收藏</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_favorites&op=fslist">店铺收藏</a></li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt>客户服务<i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=article&ac_id=2">帮助中心</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=article&ac_id=5">售后服务</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=article&ac_id=6">客服中心</a></li>
          </ul>
        </dd>
      </dl>
      <?php
      if(!empty($output['nav_list']) && is_array($output['nav_list'])){
	      foreach($output['nav_list'] as $nav){
	      if($nav['nav_location']<1){
	      	$output['nav_list_top'][] = $nav;
	      }
	      }
      }
      if(!empty($output['nav_list_top']) && is_array($output['nav_list_top'])){
      	?>
      <dl>
        <dt>站点导航<i></i></dt>
        <dd>
          <ul>
              <?php foreach($output['nav_list_top'] as $nav){?>
              <li><a
        <?php
        if($nav['nav_new_open']) {
            echo ' target="_blank"';
        }
        echo ' href="';
        switch($nav['nav_type']) {
        	case '0':echo $nav['nav_url'];break;
        	case '1':echo urlShop('search', 'index', array('cate_id'=>$nav['item_id']));break;
        	case '2':echo urlShop('article', 'article',array('ac_id'=>$nav['item_id']));break;
        	case '3':echo urlShop('activity', 'index',array('activity_id'=>$nav['item_id']));break;
        }
        echo '"';
        ?>><?php echo $nav['nav_title'];?></a></li>
              <?php }?>
          </ul>
        </dd>
      </dl>
      <?php }?>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$(".quick-menu dl").hover(function() {
		$(this).addClass("hover");
	},
	function() {
		$(this).removeClass("hover");
	});

});
</script>
<!-- 圈子头部 -->
<header id="topHeader">
  <div class="warp-all">
    <div class="circle-logo"><a href="<?php echo CIRCLE_SITE_URL;?>"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_CIRCLE.'/'.C('circle_logo');?>"/></a></div>
    <div class="circle-search" id="circleSearch">
      <form id="form_search" method="get" action="<?php echo CIRCLE_SITE_URL;?>/index.php" >
        <input type="hidden" name="act" value="search" />
        <div class="input-box"><i class="icon"></i>
          <input id="keyword" name="keyword" type="text" class="input-text" value="<?php echo isset($_GET['keyword'])?$_GET['keyword']:'';?>" maxlength="60" x-webkit-speech="" lang="zh-CN" onwebkitspeechchange="foo()" x-webkit-grammar="builtin:search" />
          <input id="btn_search" type="submit" class="input-btn" value="<?php echo $lang['nc_search_nbsp'];?>">
        </div>
        <div class="radio-box">
          <label>
            <input name="op" value="theme" type="radio" <?php if($output['search_sign']=='theme' || !isset($output['search_sign'])){?>checked="checked"<?php }?> />
            <h5><?php echo $lang['search_theme'];?></h5></label>
          <label>
            <input name="op" value="group" type="radio" <?php if($output['search_sign']=='group'){?>checked="checked"<?php }?> />
            <h5><?php echo $lang['search_circle'];?></h5></label>
        </div>
      </form>
    </div>
    <div class="circle-user">
      <h2><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=search&op=group"><?php echo $lang['nc_find_fascinating'];?></a></h2>
      <div class="head-portrait"><span class="thumb size20"> <?php if ($output['super']) {?><i title="超级管理员"></i><?php }?><img src="<?php  echo getMemberAvatarForID($_SESSION['member_id']);?>" /></span></div>
      <div class="user-login">
        <?php if($_SESSION['is_login']){?>
        <div class="my-group"><?php echo $lang['my_circle'];?><span><i></i></span><span class="hidden" nctype="span-mygroup">
          </span> </div>
        <?php }else{?>
        <a href="Javascript:void(0)" nctype="login"><?php echo $lang['nc_login'];?></a> | <a href="<?php echo SHOP_SITE_URL.'/';?>index.php?act=login&op=register"><?php echo $lang['nc_register'];?></a>
        <?php }?>
      </div>
    </div>
  </div>
</header>
