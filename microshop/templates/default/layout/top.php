<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<title><?php echo $output['html_title'];?></title>
<meta name="keywords" content="<?php echo $output['seo_keywords']; ?>" />
<meta name="description" content="<?php echo $output['seo_description']; ?>" />
<link href="<?php echo MICROSHOP_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo MICROSHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<!--[if IE 6]><style type="text/css">body { _behavior: url(<?php echo MICROSHOP_TEMPLATES_URL;?>/css/csshover.htc);}</style><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/IE6_MAXMIX.js"></script>
<script src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/IE6_PNG.js"></script>
<script>
DD_belatedPNG.fix('.pngFix');
</script>
<script> 
// <![CDATA[ 
if((window.navigator.appName.toUpperCase().indexOf("MICROSOFT")>=0)&&(document.execCommand)) 
    try{ 
        document.execCommand("BackgroundImageCache", false, true); 
   } 
catch(e){} 
// ]]> 
</script> 
<![endif]-->
<script>
COOKIE_PRE = '<?php echo COOKIE_PRE;?>';
_CHARSET = '<?php echo strtolower(CHARSET);?>';
SITEURL = '<?php echo SHOP_SITE_URL;?>';
SHOP_SITE_URL = '<?php echo SHOP_SITE_URL;?>';
var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';
</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script id="dialog_js" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/jquery.masonry.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo MICROSHOP_RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".ms-box").mouseenter(function(){
            $("#micro_search_type_list").show();
        });
        $(".ms-box").mouseleave(function(){
            $("#micro_search_type_list").hide();
        });
        $("#micro_search_type_list li").click(function(){
            $("#micro_search span").text($(this).text());
            $("#micro_search span").attr("search_type",$(this).attr("search_type"));
            $("#act").val($(this).attr("search_type"));
            $("#micro_search_type_list").hide();
            $("#micro_search").show();
        });
        $("#btn_search").click(function(){
            $("#form_search").submit();
        });

        /**
         * 同步第三方应用
         **/
            $("[nc_type='share_app_switch']").click(function(){
                    if($(this).attr("checked") == "checked") {
                    $(this).parent().find("[nc_type='bindbtn']").each(function(){
                        var data_str = $(this).attr('data-param');
                        eval( "data_str = "+data_str);
                        //判断是否已经绑定
                        var isbind = $(this).attr('attr_isbind');
                        if(isbind == '1'){//已经绑定
                        $(this).removeClass(data_str.apikey+'-disable');
                        $(this).addClass(data_str.apikey+'-enable');
                        $("#checkapp_"+data_str.apikey).val(data_str.apikey);
                        } else {
                        $(this).removeClass(data_str.apikey+'-enable');
                        $(this).addClass(data_str.apikey+'-disable');
                        $("#checkapp_"+data_str.apikey).val('');
                        }
                        });  
                    } else {
                    $("[nc_type='bindbtn']").each(function(){
                        var data_str = $(this).attr('data-param');
                        eval( "data_str = "+data_str);
                        $(this).removeClass(data_str.apikey+'-enable');
                        $(this).addClass(data_str.apikey+'-disable');
                        $("#checkapp_"+data_str.apikey).val('');
                        });  
                    }
            });
    $("[nc_type='bindbtn']").bind('click',function(){
            var data_str = $(this).attr('data-param');
            eval( "data_str = "+data_str);
            //判断是否已经绑定
            var isbind = $(this).attr('attr_isbind');
            if(isbind == '1'){//已经绑定
            if($("#checkapp_"+data_str.apikey).val() == ''){
            if($("[nc_type='share_app_switch']").attr("checked") == "checked") {
            $(this).removeClass(data_str.apikey+'-disable');
            $(this).addClass(data_str.apikey+'-enable');
            $("#checkapp_"+data_str.apikey).val(data_str.apikey);
            }
            }else{
            $(this).removeClass(data_str.apikey+'-enable');
            $(this).addClass(data_str.apikey+'-disable');
            $("#checkapp_"+data_str.apikey).val('');
            }
            }else{
            var html = $("#bindtooltip_module").text();
            //替换关键字
            html = html.replace(/@apikey/g,data_str.apikey);
            html = html.replace(/@apiname/g,data_str.apiname);
            html_form("bindtooltip", "<?php echo $lang['microshop_share_account_link'];?>", html, 360, 0);	    
            window.open('<?php echo SHOP_SITE_URL.DS;?>api.php?act=sharebind&type='+data_str.apikey);
            }
    });
    $("#finishbtn").live('click',function(){
            var data_str = $(this).attr('data-param');
            eval( "data_str = "+data_str);
            //验证是否绑定成功
            var url = '<?php echo SHOP_SITE_URL.DS;?>index.php?act=member_sharemanage&op=checkbind&callback=?';
            $.getJSON(url, {'k':data_str.apikey}, function(data){
                DialogManager.close('bindtooltip');
                if (data.done)
                {
                $("[nc_type='appitem_"+data_str.apikey+"']").addClass('check');
                $("[nc_type='appitem_"+data_str.apikey+"']").removeClass('disable');
                $('#checkapp_'+data_str.apikey).val('1');
                $("[nc_type='appitem_"+data_str.apikey+"']").find('i').attr('attr_isbind','1');
                }
                else
                {
                showDialog(data.msg, 'notice');
                }
                });
            });
    });
</script>
</head>
<body>
<!-- 头 -->
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="public-top-layout w">
  <div class="topbar warp-all">
    <div class="user-entry">
      <?php if($_SESSION['is_login'] == '1'){?>
      <?php echo $lang['nc_hello'];?><span><a href="<?php echo urlShop('member', 'home');?>"><?php echo str_cut($_SESSION['member_name'],20);?></a></span><?php echo $lang['nc_comma'],$lang['welcome_to_site'];?> <a href="<?php echo SHOP_SITE_URL;?>"  title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><span><?php echo $output['setting_config']['site_name']; ?></span></a> <span>[<a href="<?php echo urlShop('login','logout');?>"><?php echo $lang['nc_logout'];?></a>]</span>
      <?php }else{?>
      <?php echo $lang['nc_hello'].$lang['nc_comma'].$lang['welcome_to_site'];?> <a href="<?php echo SHOP_SITE_URL;?>" title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"><?php echo $output['setting_config']['site_name']; ?></a> <span>[<a href="<?php echo urlShop('login');?>"><?php echo $lang['nc_login'];?></a>]</span> <span>[<a href="<?php echo urlShop('login','register');?>"><?php echo $lang['nc_register'];?></a>]</span>
      <?php }?>
      <span class="seller-login"><a href="<?php echo urlShop('seller_login','show_login');?>" target="_blank" title="登录商家管理中心"><i class="icon-signin"></i>商家管理中心</a></span></div>
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
<!-- 导航 -->
<header id="topHeader">
  <div class="warp-all">
    <div class="micro-logo"> <a href="<?php echo MICROSHOP_SITE_URL;?>">
      <?php if(C('microshop_logo')) { ?>
      <img src="<?php echo MICROSHOP_IMG_URL.DS.C('microshop_logo');?>" class="pngFix">
      <?php } else { ?>
      <img src="<?php echo MICROSHOP_IMG_URL.DS.'default_logo_image.png';?>" class="pngFix">
      <?php } ?>
      </a> </div>
    <div class="micro-header-pic"> <a href="<?php echo MICROSHOP_SITE_URL;?>">
      <?php if(C('microshop_header_pic')) { ?>
      <img src="<?php echo MICROSHOP_IMG_URL.DS.C('microshop_header_pic');?>" class="pngFix">
      <?php } else { ?>
      <img src="<?php echo MICROSHOP_IMG_URL.DS.'default_header_pic_image.png';?>" class="pngFix">
      <?php } ?>
      </a> </div>
    <div class="micro-search">
      <div class="ms-box">
        <div id="micro_search" class="ms-type">
          <?php if(in_array($_GET['act'],array_keys($output['search_type']))) { ?>
          <span id="micro_search_type" search_type="<?php echo $_GET['act'];?>"><?php echo $output['search_type'][$_GET['act']];?></span>
          <?php } else { ?>
          <span id="micro_search_type" search_type="<?php echo key($output['search_type']);?>"><?php echo current($output['search_type']);?></span>
          <?php } ?>
          <i></i> </div>
        <ul class="ms-list" id="micro_search_type_list" style="display:none;">
          <?php if(!empty($output['search_type']) && is_array($output['search_type'])) {?>
          <?php foreach($output['search_type'] as $key=>$val) {?>
          <li search_type="<?php echo $key;?>"><?php echo $val;?></li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
      <div class="ms-form">
        <form id="form_search" method="get" action="<?php echo MICROSHOP_SITE_URL;?>/index.php">
          <?php if(in_array($_GET['act'],array_keys($output['search_type']))) { ?>
          <input id="act" name="act" type="hidden" value="<?php echo $_GET['act'];?>"/>
          <?php } else { ?>
          <input id="act" name="act" type="hidden" value="goods"/>
          <?php } ?>
          <?php if(isset($_GET['goods_class_root_id'])) { ?>
          <input name="goods_class_root_id" type="hidden" value="<?php echo $_GET['goods_class_root_id'];?>"/>
          <?php } ?>
          <?php if(isset($_GET['goods_class_menu_id'])) { ?>
          <input name="goods_class_menu_id" type="hidden" value="<?php echo $_GET['goods_class_menu_id'];?>"/>
          <?php } ?>
          <input id="keyword" name="keyword" type="text" class="input-text" value="<?php echo isset($_GET['keyword'])?$_GET['keyword']:'';?>" maxlength="60" x-webkit-speech="" lang="zh-CN" onwebkitspeechchange="foo()" x-webkit-grammar="builtin:search" />
          <input id="btn_search" type="button" class="input-button pngFix">
        </form>
      </div>
    </div>
  </div>
</header>
<div id="navBar" class="pngFix">
  <div id="navBox">
    <ul class="nc-nav-menu">
      <li <?php echo $output['index_sign'] == 'index'&&$output['index_sign'] != '0'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>" class="pngFix"><span class="pngFix"><?php echo $lang['nc_index'];?></span></a></li>
      <li <?php echo $output['index_sign'] == 'goods'&&$output['index_sign'] != '0'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=goods" class="pngFix"><span class="pngFix"><?php echo $lang['nc_microshop_goods'];?></span></a></li>
      <!--
      <li <?php echo $output['index_sign'] == 'album'&&$output['index_sign'] != '0'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=album"><span><?php echo $lang['nc_microshop_album'];?></span></a></li>
      -->
      <li <?php echo $output['index_sign'] == 'personal'&&$output['index_sign'] != '0'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=personal" class="pngFix"><span class="pngFix"><?php echo $lang['nc_microshop_personal'];?></span></a></li>
      <li <?php echo $output['index_sign'] == 'store'&&$output['index_sign'] != '0'?'class="current"':'class="link"'; ?>><a href="<?php echo MICROSHOP_SITE_URL;?>/index.php?act=store" class="pngFix"><span class="pngFix"><?php echo $lang['nc_microshop_store'];?></span></a></li>
    </ul>
    <div class="microMall-user">
      <?php $member_avatar = MICROSHOP_TEMPLATES_URL.DS.'images'.DS.'default_user_portrait.gif' ?>
      <?php if(isset($_SESSION['is_login'])) { ?>
      <?php $member_avatar = getMemberAvatar($_SESSION['member_avatar']); ?>
      <?php } ?>
      <div class="head-portrait"><span class="thumb size32" title="<?php echo $_SESSION['member_name'];?>"><i></i><img src="<?php echo $member_avatar;?>" onload="javascript:DrawImage(this,30,30);" /></span></div>
      <ul class="sub-menu">
        <?php if(isset($_SESSION['is_login'])) {?>
        <li class="pngFix"><a href="javascript:void(0)"><span title="<?php echo $_SESSION['member_name'];?>"><?php echo $_SESSION['member_name'];?></span><i></i></a>
          <ul>
            <li><a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=goods'?>"><?php echo $lang['nc_microshop_goods'];?></a></li>
            <li><a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=personal'?>"><?php echo $lang['nc_microshop_personal'];?></a></li>
            <!--
            <li> <a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=album'?>"><?php echo $lang['nc_microshop_album'];?></a> </li>
            -->
          </ul>
        </li>
        <?php } else { ?>
        <li class="no-sub pngFix"><a href="<?php echo SHOP_SITE_URL.'/index.php?act=login&ref_url='.getRefUrl();?>"><?php echo $lang['nc_login'];?></a></li>
        <?php } ?>
        <li class="pngFix"><a href="javascript:void(0)"><?php echo $lang['nc_publish'];?><i></i></a>
          <ul>
            <li><a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=publish&op=goods_buy';?>"><?php echo $lang['microshop_goods_buy'];?></a> </li>
            <li><a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=publish&op=goods_favorites';?>"><?php echo $lang['microshop_goods_favorite'];?></a> </li>
            <li><a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=personal&publish=personal';?>"><?php echo $lang['nc_microshop_personal'];?></a> </li>
            <!--
            <li> <a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=publish&op=album';?>"><?php echo $lang['nc_microshop_album'];?></a> </li>
            -->
          </ul>
        </li>
        <li class="pngFix"><a href="javascript:void(0)"><?php echo $lang['microshop_text_like'];?><i></i></a>
          <ul>
            <li> <a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=like_list&type=goods'?>"><?php echo $lang['nc_microshop_goods'];?></a> </li>
            <!--
            <li> <a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=like_list&type=personal'?>"><?php echo $lang['nc_microshop_album'];?></a> </li>
            -->
            <li> <a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=like_list&type=personal'?>"><?php echo $lang['nc_microshop_personal'];?></a> </li>
            <li> <a href="<?php echo MICROSHOP_SITE_URL.'/index.php?act=home&op=like_list&type=store'?>"><?php echo $lang['nc_microshop_store'];?></a> </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
