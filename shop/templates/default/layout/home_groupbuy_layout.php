<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php include template('layout/common_layout');?>
<?php include template('layout/cur_local');?>

<div class="ncg-topbar">
  <div id="headRelative" class="ncg-topbar-wrapper">
    <div class="title" style="width:210px;">
      <h2> <?php echo $lang['text_groupbuy'];?> </h2>
      <?php if ($_GET['op'] == 'index' || strpos($_GET['op'], 'vr_groupbuy_') === 0) { ?>
      <div class="city"> 地区【<a href="javascript:void(0)" id="button_show">
        <h3 id="show_area_name">
          <?php if (empty($output['city_name'])){ echo '全国';}else{ echo $output['city_name'];}?>
        </h3>
        <i class="arrow"></i></a>】</div>
      <div id="list" class="list" style="display:none;"><a id="button_close" class="close" href="javascript:void(0)">&#215;</a>
        <ul>
          <li><a href="<?php echo urlShop('show_groupbuy', 'select_city'); ?>&back_op=<?php echo $_GET['op']; ?>&city_id=0"><?php echo $lang['text_country'];?></a></li>
          <?php $names = $output['groupbuy_vr_cities']['name']; foreach ($output['groupbuy_vr_cities']['children'][0] as $v) { ?>
          <li><a href="<?php echo urlShop('show_groupbuy', 'select_city'); ?>&back_op=<?php echo $_GET['op']; ?>&city_id=<?php echo $v; ?>"><?php echo $names[$v]; ?></a></li>
          <?php } ?>
        </ul>
      </div>
      <?php } ?>
    </div>
    <ul class="nav-menu">
      <li><a href="<?php echo urlShop('show_groupbuy', 'index'); ?>"<?php if (!isset($output['groupbuyMenuIsVr'])) echo ' class="current"'; ?>>抢购首页</a></li>
      <li><a href="<?php echo urlShop('show_groupbuy', 'groupbuy_list'); ?>"<?php if (isset($output['groupbuyMenuIsVr']) && !$output['groupbuyMenuIsVr']) echo ' class="current"'; ?>>线上抢</a></li>
      <li><a href="<?php echo urlShop('show_groupbuy', 'vr_groupbuy_list'); ?>"<?php if (isset($output['groupbuyMenuIsVr']) && $output['groupbuyMenuIsVr']) echo ' class="current"'; ?>>虚拟抢</a></li>
    </ul>
  </div>
</div>
<?php require_once($tpl_file);?>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/home_index.js" ></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/waypoints.js"></script>
<script language="JavaScript">
 //浮动导航  waypoints.js
$("#ncgCategory").waypoint(function(event, direction) {
	$(this).parent().toggleClass('sticky', direction === "down");
	event.stopPropagation();
});
//鼠标触及更替li样式
$(document).ready(function(){
    $("#list").hide();
    $("#button_show").click(function(){
        $("#list").toggle();
    });
    $("#button_close").click(function(){
        $("#list").hide();
    });
});
</script>
<?php require_once template('footer');?>
</body></html>