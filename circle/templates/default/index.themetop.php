<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="theme-top clearfix">
  <div class="title">
    <ul class="tabs-nav">
      <li class="tabs-selected"><a href="javascript:void(0)"><?php echo $lang['circle_new_theme_two'];?></a></li>
      <li><a href="javascript:void(0)"><?php echo $lang['circle_hot_theme'];?></a></li>
      <li><a href="javascript:void(0)"><?php echo $lang['circle_hot_reply'];?></a></li>
    </ul>
  </div>
  <div class="contnet theme-list">
    <?php if(!empty($output['new_themelist'])){?>
    <ul class="tabs-panel">
    <?php foreach ($output['new_themelist'] as $val){?>
      <li>
        <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"class="theme-title" title="<?php echo $val['theme_name'];?>"><?php echo $val['theme_name'];?></a>
        <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>" class="group-name" title="<?php echo $lang['circle_theme_come_from'].$lang['nc_colon'].$val['circle_name'];?>"><?php echo $val['circle_name'];?></a>
      </li>
    <?php }?>
    </ul>
    <?php }?>
    <?php if(!empty($output['hot_themelist'])){?>
    <ul class="tabs-panel tabs-hide">
    <?php foreach ($output['hot_themelist'] as $val){?>
      <li>
        <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>" class="theme-title" title="<?php echo $val['theme_name'];?>"><?php echo $val['theme_name'];?></a>
        <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>" class="group-name" title="<?php echo $lang['circle_theme_come_from'].$lang['nc_colon'].$val['circle_name'];?>"><?php echo $val['circle_name'];?></a>
      </li>
    <?php }?>
    </ul>
    <?php }?>
    <?php if(!empty($output['reply_themelist'])){?>
    <ul class="tabs-panel tabs-hide">
    <?php foreach ($output['reply_themelist'] as $val){?>
      <li>
        <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"class="theme-title" title="<?php echo $val['theme_name'];?>"><?php echo $val['theme_name'];?></a>
        <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>" class="group-name" title="<?php echo $lang['circle_theme_come_from'].$lang['nc_colon'].$val['circle_name'];?>"><?php echo $val['circle_name'];?></a>
      </li>
    <?php }?>
    </ul>
    <?php }?>
  </div>
</div>
<script>
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