<?php defined('InShopNC') or exit('Access Invalid!');?>

<ul class="circle-theme-list">
  <?php if(!empty($output['theme_list']) && is_array($output['theme_list'])) {?>
  <?php foreach($output['theme_list'] as $key=>$value) {?>
  <li class="circle-theme-item">
    <div class="circle-theme-pic cms-thumb"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $value['circle_id'];?>&t_id=<?php echo $value['theme_id'];?>" target="_blank"><img src="<?php echo $value['affix'];?>" class="t-img" /></a></div>
    <div class="circle-theme-name"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $value['circle_id'];?>&t_id=<?php echo $value['theme_id'];?>" target="_blank"><?php echo $value['theme_name'];?></a></div>
    <div class="circle-theme-circle-name"><?php echo $lang['circle_come_from'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $value['circle_id'];?>" target="_blank"><?php echo $value['circle_name'];?></a></div>
  </li>
  <?php } ?>
  <?php } ?>
</ul>
