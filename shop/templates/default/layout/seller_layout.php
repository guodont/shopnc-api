<?php defined('InShopNC') or exit('Access Invalid!');?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>商家中心</title>
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL?>/css/seller_center.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo SHOP_RESOURCE_SITE_URL;?>/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<script>
var COOKIE_PRE = '<?php echo COOKIE_PRE;?>';var _CHARSET = '<?php echo strtolower(CHARSET);?>';var SITEURL = '<?php echo SHOP_SITE_URL;?>';var RESOURCE_SITE_URL = '<?php echo RESOURCE_SITE_URL;?>';var SHOP_RESOURCE_SITE_URL = '<?php echo SHOP_RESOURCE_SITE_URL;?>';var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/seller.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/html5shiv.js"></script>
      <script src="<?php echo RESOURCE_SITE_URL;?>/js/respond.min.js"></script>
<![endif]-->
<!--[if IE 6]>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/IE6_MAXMIX.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/IE6_PNG.js"></script>
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

</head>

<body>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<?php if (!empty($output['store_closed'])) { ?>
<div class="store-closed"><i class="icon-warning-sign"></i>
  <dl>
    <dt>您的店铺已被平台关闭</dt>
    <dd>关闭原因：<?php echo $output['store_close_info'];?></dd>
    <dd>在此期间，您的店铺以及商品将无法访问；如果您有异议或申诉请及时联系平台管理。</dd>
  </dl>
</div>
<?php } ?>
<header class="ncsc-head-layout w">
  <div class="wrapper">
    <div class="ncsc-admin">
      <dl class="ncsc-admin-info">
        <dt class="admin-avatar"><img src="<?php echo getMemberAvatarForID($_SESSION['member_id']);?>" width="32" class="pngFix" alt=""/></dt>
        <dd class="admin-permission">当前用户</dd>
        <dd class="admin-name"><?php echo $_SESSION['seller_name'];?></dd>
      </dl>
      <div class="ncsc-admin-function"><a href="<?php echo urlShop('show_store', 'index', array('store_id'=>$_SESSION['store_id']), $output['store_info']['store_domain']);?>" title="前往店铺" ><i class="icon-home"></i></a><a href="<?php echo urlShop('member_security', 'auth',array('type'=>'modify_pwd'));?>" title="修改密码" target="_blank"><i class="icon-wrench"></i></a><a href="<?php echo urlShop('seller_logout', 'logout');;?>" title="安全退出"><i class="icon-signout"></i></a></div>
    </div>
    <div class="center-logo"> <a href="<?php echo SHOP_SITE_URL;?>" target="_blank"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('seller_center_logo');?>" class="pngFix" alt=""/></a>
      <h1>商家中心</h1>
    </div>
    <div class="index-search-container">
      <div class="index-sitemap"><a href="javascript:void(0);">导航管理 <i class="icon-angle-down"></i></a>
        <div class="sitemap-menu-arrow"></div>
        <div class="sitemap-menu">
          <div class="title-bar">
            <h2> <i class="icon-sitemap"></i>管理导航<em>小提示：添加您经常使用的功能到首页侧边栏，方便操作。</em> </h2>
            <span id="closeSitemap" class="close">X</span></div>
          <div id="quicklink_list" class="content">
            <?php if(!empty($output['menu']) && is_array($output['menu'])) {?>
            <?php foreach($output['menu'] as $menu_value) {?>
            <dl>
              <dt><?php echo $menu_value['name'];?></dt>
              <?php if(!empty($menu_value['child']) && is_array($menu_value['child'])) {?>
              <?php foreach($menu_value['child'] as $submenu_value) {?>
              <dd <?php if(!empty($output['seller_quicklink'])) {echo in_array($submenu_value['act'], $output['seller_quicklink'])?'class="selected"':'';}?>><i nctype="btn_add_quicklink" data-quicklink-act="<?php echo $submenu_value['act'];?>" class="icon-check" title="添加为常用功能菜单"></i><a href="index.php?act=<?php echo $submenu_value['act'];?>&op=<?php echo $submenu_value['op'];?>"> <?php echo $submenu_value['name'];?> </a></dd>
              <?php } ?>
              <?php } ?>
            </dl>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="search-bar">
        <form method="get" target="_blank">
          <input type="hidden" name="act" value="search">
          <input type="text" nctype="search_text" name="keyword" placeholder="商城商品搜索" class="search-input-text">
          <input type="submit" nctype="search_submit" class="search-input-btn pngFix" value="">
        </form>
      </div>
    </div>
    <nav class="ncsc-nav">
      <dl class="<?php echo $output['current_menu']['model'] == 'index'?'current':'';?>">
        <dt><a href="index.php?act=seller_center&op=index">首页</a></dt>
        <dd class="arrow"></dd>
      </dl>
      <?php if(!empty($output['menu']) && is_array($output['menu'])) {?>
      <?php foreach($output['menu'] as $key => $menu_value) {?>
      <dl class="<?php echo $output['current_menu']['model'] == $key?'current':'';?>">
        <dt><a href="index.php?act=<?php echo $menu_value['child'][key($menu_value['child'])]['act'];?>&op=<?php echo $menu_value['child'][key($menu_value['child'])]['op'];?>"><?php echo $menu_value['name'];?></a></dt>
        <dd>
          <ul>
            <?php if(!empty($menu_value['child']) && is_array($menu_value['child'])) {?>
            <?php foreach($menu_value['child'] as $submenu_value) {?>
            <li> <a href="index.php?act=<?php echo $submenu_value['act'];?>&op=<?php echo $submenu_value['op'];?>"> <?php echo $submenu_value['name'];?> </a> </li>
            <?php } ?>
            <?php } ?>
          </ul>
        </dd>
        <dd class="arrow"></dd>
      </dl>
      <?php } ?>
      <?php } ?>
    </nav>
  </div>
</header>
<?php if(!$output['seller_layout_no_menu']) { ?>
<div class="ncsc-layout wrapper">
  <div id="layoutLeft" class="ncsc-layout-left">
    <div id="sidebar" class="sidebar">
      <div class="column-title" id="main-nav"><span class="ico-<?php echo $output['current_menu']['model'];?>"></span>
        <h2><?php echo $output['current_menu']['model_name'];?></h2>
      </div>
      <div class="column-menu">
        <ul id="seller_center_left_menu">
          <?php if(!empty($output['left_menu']) && is_array($output['left_menu'])) {?>
          <?php foreach($output['left_menu'] as $submenu_value) {?>
          <li <?php echo $_GET['act'] == 'seller_center'?"id='quicklink_".$submenu_value['act']."'":'';?>class="<?php echo $submenu_value['act'] == $_GET['act']?'current':'';?>"> <a href="index.php?act=<?php echo $submenu_value['act'];?>&op=<?php echo $submenu_value['op'];?>"> <?php echo $submenu_value['name'];?> </a> </li>
          <?php } ?>
          <?php } else { ?>
          <?php if ($_GET['act'] == 'seller_center') { ?>
          <div class="add-quickmenu"><a href="javascript:void(0);"><i class="icon-plus"></i>添加常用功能菜单</a></div>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  <div id="layoutRight" class="ncsc-layout-right">
    <div class="ncsc-path"><i class="icon-desktop"></i>商家管理中心<i class="icon-angle-right"></i><?php echo $output['current_menu']['model_name'];?><i class="icon-angle-right"></i><?php echo $output['current_menu']['name'];?></div>
    <div class="main-content" id="mainContent">
      <?php require_once($tpl_file); ?>
    </div>
  </div>
</div>
<?php } else { ?>
<div class="wrapper">
  <?php require_once($tpl_file); ?>
</div>
<?php } ?>
<script type="text/javascript">
</script>
<script type="text/javascript">
$(document).ready(function(){
    //添加删除快捷操作
    $('[nctype="btn_add_quicklink"]').on('click', function() {
        var $quicklink_item = $(this).parent();
        var item = $(this).attr('data-quicklink-act');
        if($quicklink_item.hasClass('selected')) {
            $.post("<?php echo urlShop('seller_center', 'quicklink_del');?>", { item: item }, function(data) {
                $quicklink_item.removeClass('selected');
                $('#quicklink_' + item).remove();
            }, "json");
        } else {
            var count = $('#quicklink_list').find('dd.selected').length;
            if(count >= 8) {
                showError('快捷操作最多添加8个');
            } else {
                $.post("<?php echo urlShop('seller_center', 'quicklink_add');?>", { item: item }, function(data) {
                    $quicklink_item.addClass('selected');
                    <?php if ($_GET['act'] == 'seller_center') { ?>
                        var $link = $quicklink_item.find('a');
                        var menu_name = $link.text();
                        var menu_link = $link.attr('href');
                        var menu_item = '<li id="quicklink_' + item + '"><a href="' + menu_link + '">' + menu_name + '</a></li>';
                        $(menu_item).appendTo('#seller_center_left_menu').hide().fadeIn();
                    <?php } ?>
                }, "json");
            }
        }
    });
    //浮动导航  waypoints.js
    $("#sidebar,#mainContent").waypoint(function(event, direction) {
        $(this).parent().toggleClass('sticky', direction === "down");
        event.stopPropagation();
        });
    });
    // 搜索商品不能为空
    $('input[nctype="search_submit"]').click(function(){
        if ($('input[nctype="search_text"]').val() == '') {
            return false;
        }
    });
</script>
<?php require_once template('footer');?>
<div id="tbox">
  <div class="btn" id="msg"><a href="<?php echo urlShop('store_msg', 'index');?>"><i class="msg"><?php if ($output['store_msg_num'] > 0) { ?><em><?php echo $output['store_msg_num'];?></em><?php } ?></i>站内消息</a></div>
  <div class="btn" id="im"><i class="im"><em id="new_msg" style="display:none;"></em></i><a href="javascript:void(0);">在线联系</a></div>
  <div class="btn" id="gotop" style="display:none;"><i class="top"></i><a href="javascript:void(0);">返回顶部</a></div>
</div>
</body>
</html>
