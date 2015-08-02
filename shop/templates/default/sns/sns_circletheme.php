<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="sidebar">
  <?php include template('sns/sns_sidebar_visitor');?>
  <?php include template('sns/sns_sidebar_messageboard');?>
</div>
<div class="left-content">
  <div class="tabmenu">
    <?php include template('layout/submenu'); ?>
  </div>
  <div class="circle-theme-list">
  <?php if(!empty($output['theme_list'])){?>
    <ul>
    <?php foreach ($output['theme_list'] as $val){?>
      <li>
        <dl class="theme-info">
          <dt class="theme-title"><?php echo $val['member_name'].$lang['nc_colon'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"><?php echo $val['theme_name'];?></a><span>(<?php echo @date('Y-m-d', $val['theme_addtime']);?>)</span></dt>
          <dd class="theme-file">
          <?php if(!empty($output['affix_list'][$val['theme_id']])){$array = array_slice($output['affix_list'][$val['theme_id']], 0, 3)?>
          <?php foreach ($array as $v){?>
            <div class="thumb-cut"><a href="Javascript: void(0);"><img src="<?php echo themeImageUrl($v['affix_filethumb']);?>" class="t-img" /></a></div>
          <?php }?>
          <?php }?>
          </dd>
          <dd class="theme-txt"><p><?php echo removeUBBTag($val['theme_content']);?></p><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>">[<?php echo $lang['sns_look_at_original'];?>]</a></dd>
          <dd class="theme-date"><?php if($val['lastspeak_name']){?><?php echo $lang['sns_lastspeak_time'].$lang['nc_colon'];?><em><?php echo @date('Y-m-d', $val['lastspeak_time'])?></em><?php }else{echo $lang['sns_reply_null'];}?><span><?php echo $lang['sns_come_from'].$lang['nc_colon'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name'];?></a></span></dd>
        </dl>
      </li>
    <?php }?>
    </ul>
    <div class="clear"></div>
    <div class="pagination mb30"><?php echo $output['showpage'];?></div>
  <?php }else{?>
  <!-- 为空提示 START -->
  <div class="sns-norecord"><i class="theme-ico pngFix"></i><span><?php echo $lang['sns_regrettably'];?><br />
    <?php if ($output['relation'] == 3){echo $lang['sns_me']; }else {?>TA<?php }?><?php echo $lang['sns_not_yet'];?><a href="<?php echo CIRCLE_SITE_URL;?>" target="_blank"><?php echo $lang['sns_group'];?></a><?php echo $lang['sns_in_publish_theme'];?></span></div>
  <?php }?>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$(".theme-file .t-img").VMiddleImg({"width":100,"height":100});
});
</script>