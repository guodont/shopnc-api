<?php defined('InShopNC') or exit('Access Invalid!');?>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<?php if ($output['hidden_nctoolbar'] != 1) {?>
<div id="ncToolbar" class="nc-appbar">
  <div class="nc-appbar-tabs" id="appBarTabs">
    <div class="ever">
    <?php if (!$output['hidden_rtoolbar_cart']) { ?>
      <div class="cart"><a href="javascript:void(0);" id="rtoolbar_cart"><span class="icon"></span> <span class="name">购物车</span><i id="rtoobar_cart_count" class="new_msg" style="display:none;"></i></a></div>
       <?php } ?>
      <div class="chat"><a href="javascript:void(0);" id="chat_show_user"><span class="icon"></span><i id="new_msg" class="new_msg" style="display:none;"></i><span class="tit">在线联系</span></a></div>
    </div>
    <div class="variation">
      <div class="middle">
        <?php if ($_SESSION['is_login']) {?>
    <div class="user" nctype="a-barUserInfo">
     <a href="javascript:void(0);">
      <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/></div>
<span class="tit">会员登录</span>
</a>
    </div>
    <div class="user-info" nctype="barUserInfo" style="display:none;"><i class="arrow"></i>
      <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/>
        <div class="frame"></div>
      </div>
      <dl>
        <dt>Hi, <?php echo $_SESSION['member_name'];?></dt>
        <dd>当前等级：<strong nctype="barMemberGrade"><?php echo $output['member_info']['level_name'];?></strong></dd>
        <dd>当前经验值：<strong nctype="barMemberExp"><?php echo $output['member_info']['member_exppoints'];?></strong></dd>
      </dl>
    </div>
    <?php } else {?>
    <div class="user" nctype="a-barLoginBox"> <a href="javascript:void(0);" >
          <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/></div>
          <span class="tit">会员登录</span> </a> </div>
    <div class="user-login-box" nctype="barLoginBox" style="display:none;"> <i class="arrow"></i> <a href="javascript:void(0);" class="close" nctype="close-barLoginBox" title="关闭">X</a>
      <form id="login_form" method="post" action="index.php?act=login&op=login" onsubmit="ajaxpost('login_form', '', '', 'onerror')">
        <?php Security::getToken();?>
        <input type="hidden" name="form_submit" value="ok" />
        <input name="nchash" type="hidden" value="<?php echo getNchash('login','index');?>" />
        <dl>
          <dt><strong>登录名</strong></dt>
          <dd>
            <input type="text" class="text" tabindex="1" autocomplete="off"  name="user_name" autofocus >
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><strong>登录密码</strong><a href="index.php?act=login&op=forget_password" target="_blank">忘记登录密码？</a></dt>
          <dd>
            <input tabindex="2" type="password" class="text" name="password" autocomplete="off">
            <label></label>
          </dd>
        </dl>
        <?php if(C('captcha_status_login') == '1') { ?>
        <dl>
          <dt><strong>验证码</strong><a href="javascript:void(0)" class="ml5" onclick="javascript:document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash('login','index');?>&t=' + Math.random();">更换验证码</a></dt>
          <dd>
            <input tabindex="3" type="text" name="captcha" autocomplete="off" class="text w130" id="captcha2" maxlength="4" size="10" />
            <img src="" name="codeimage" border="0" id="codeimage" class="vt">
            <label></label>
          </dd>
        </dl>
        <?php } ?>
        <div class="bottom">
          <input type="submit" class="submit" value="确认">
          <input type="hidden" value="<?php echo $_GET['ref_url']?>" name="ref_url">
          <a href="index.php?act=login&op=register&ref_url=<?php echo urlencode($output['ref_url']);?>" target="_blank">注册新用户</a> </div>
      </form>
    </div>
    <?php }?>
        
        <div class="prech">&nbsp;</div>
        <?php if (!$output['hidden_rtoolbar_compare']) { ?>
        <div class="compare"><a href="javascript:void(0);" id="compare"><span class="icon"></span><span class="tit">商品对比</span></a></div>
      <?php } ?>
      </div>
      <div class="gotop"><a href="javascript:void(0);" id="gotop"><span class="icon"></span><span class="tit">返回顶部</span></a></div>
    </div>
    <div class="content-box" id="content-compare">
      <div class="top">
        <h3>商品对比</h3>
        <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
      <div id="comparelist"></div>
    </div>
    <div class="content-box" id="content-cart">
      <div class="top">
        <h3>我的购物车</h3>
        <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
      <div id="rtoolbar_cartlist"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
//返回顶部
backTop=function (btnId){
	var btn=document.getElementById(btnId);
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	window.onscroll=set;
	btn.onclick=function (){
		btn.style.opacity="0.5";
		window.onscroll=null;
		this.timer=setInterval(function(){
		    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			scrollTop-=Math.ceil(scrollTop*0.1);
			if(scrollTop==0) clearInterval(btn.timer,window.onscroll=set);
			if (document.documentElement.scrollTop > 0) document.documentElement.scrollTop=scrollTop;
			if (document.body.scrollTop > 0) document.body.scrollTop=scrollTop;
		},10);
	};
	function set(){
	    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	    btn.style.opacity=scrollTop?'1':"0.5";
	}
};
backTop('gotop');
//动画显示边条内容区域
$(function() {
    ncToolbar();
    $(window).resize(function() {
        ncToolbar();
    });
    function ncToolbar() {
        if ($(window).width() >= 1240) {
            $('#appBarTabs >.variation').show();
        } else {
            $('#appBarTabs >.variation').hide();
        }
    }
    $('#appBarTabs').hover(
        function() {
            $('#appBarTabs >.variation').show();
        }, 
        function() {
            ncToolbar();
        }
    );
    $("#compare").click(function(){
    	if ($("#content-compare").css('right') == '-210px') {
 		   loadCompare(false);
 		   $('#content-cart').animate({'right': '-210px'});
  		   $("#content-compare").animate({right:'35px'});
    	} else {
    		$(".close").click();
    		$(".chat-list").css("display",'none');
        }
	});
    $("#rtoolbar_cart").click(function(){
        if ($("#content-cart").css('right') == '-210px') {
         	$('#content-compare').animate({'right': '-210px'});
    		$("#content-cart").animate({right:'35px'});
    		if (!$("#rtoolbar_cartlist").html()) {
    			$("#rtoolbar_cartlist").load('index.php?act=cart&op=ajax_load&type=html');
    		}
        } else {
        	$(".close").click();
        	$(".chat-list").css("display",'none');
        }
	});
	$(".close").click(function(){
		$(".content-box").animate({right:'-210px'});
      });

	$(".quick-menu dl").hover(function() {
		$(this).addClass("hover");
	},
	function() {
		$(this).removeClass("hover");
	});

    // 右侧bar用户信息
    $('div[nctype="a-barUserInfo"]').click(function(){
        $('div[nctype="barUserInfo"]').toggle();
    });
    // 右侧bar登录
    $('div[nctype="a-barLoginBox"]').click(function(){
        $('div[nctype="barLoginBox"]').toggle();
        document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=c93636e5&t=' + Math.random();
    });
    $('a[nctype="close-barLoginBox"]').click(function(){
        $('div[nctype="barLoginBox"]').toggle();
    });
     <?php if ($output['cart_goods_num'] > 0) { ?>
    $('#rtoobar_cart_count').html(<?php echo $output['cart_goods_num'];?>).show();
    <?php } ?>
});
</script>
<?php } ?>
<div class="public-top-layout w">
  <div class="topbar wrapper">
    <div class="user-entry">
      <?php if($_SESSION['is_login'] == '1'){?>
      <?php echo $lang['nc_hello'];?> <span>
      <a href="<?php echo urlShop('member','home');?>"><?php echo $_SESSION['member_name'];?></a>
      <?php if ($output['member_info']['level_name']){ ?>
      <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?></div>
      <?php } ?>
      </span> <?php echo $lang['nc_comma'],$lang['welcome_to_site'];?> <a href="<?php echo BASE_SITE_URL;?>"  title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><span><?php echo $output['setting_config']['site_name']; ?></span></a> <span>[<a href="<?php echo urlShop('login','logout');?>"><?php echo $lang['nc_logout'];?></a>] </span>
      <?php }else{?>
      <?php echo $lang['nc_hello'].$lang['nc_comma'].$lang['welcome_to_site'];?> <a href="<?php echo BASE_SITE_URL;?>" title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><?php echo $output['setting_config']['site_name']; ?></a> <span>[<a href="<?php echo urlShop('login');?>"><?php echo $lang['nc_login'];?></a>]</span> <span>[<a href="<?php echo urlShop('login','register');?>"><?php echo $lang['nc_register'];?></a>]</span>
      <?php }?><span style="margin-left:10px;"><a href="index.php?act=invite" style="color:red;">邀请返利</a></span>
    </div>
    <div class="quick-menu">
      <dl>
        <dt><a href="<?php echo BASE_SITE_URL;?>/wap">手机触屏版</a></dt>
      </dl>
	  <dl>
        <dt><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_joinin&op=index" title="免费开店">免费开店</a><i></i></dt>
        <dd>
          <ul>
		    <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_joinin&op=index" title="招商入驻">招商入驻</a></li>
            <li><a href="<?php echo urlShop('seller_login','show_login');?>" target="_blank" title="登录商家管理中心">商家登录</a></li>
          </ul>
        </dd>
      </dl>
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
            <li><a href="<?php echo urlShop('article', 'article', array('ac_id' => 2));?>">帮助中心</a></li>
            <li><a href="<?php echo urlShop('article', 'article', array('ac_id' => 5));?>">售后服务</a></li>
            <li><a href="<?php echo urlShop('article', 'article', array('ac_id' => 6));?>">客服中心</a></li>
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
        	case '2':echo urlShop('article', 'article', array('ac_id'=>$nav['item_id']));break;
        	case '3':echo urlShop('activity', 'index', array('activity_id'=>$nav['item_id']));break;
        }
        echo '"';
        ?>><?php echo $nav['nav_title'];?></a></li>
            <?php }?>
          </ul>
        </dd>
      </dl>
      <?php }?>
	  <dl class="weixin">
        <dt>关注我们<i></i></dt>
        <dd>
          <h4>扫描二维码<br/>
            关注商城微信号</h4>
          <img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.$GLOBALS['setting_config']['site_logowx']; ?>" > </dd>
        </dl>
    </div>
  </div>
</div>
