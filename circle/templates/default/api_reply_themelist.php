<?php defined('InShopNC') or exit('Access Invalid!');?>
<ul class="circle-reply-themelist">
    <?php if(!empty($output['reply_themelist']) && is_array($output['reply_themelist'])) {?>
    <?php foreach($output['reply_themelist'] as $key=>$value) {?>
    <li class="circle-theme-item">
    <span class="circle-theme-thclass_name"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $value['circle_id'];?>&thc_id=<?php echo $value['thclass_id'];?>" target="_blank">[<?php echo empty($value['thclass_name'])?$lang['nc_default']:$value['thclass_name'];?>]</a></span>
    <span class="circle-theme-name"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $value['circle_id'];?>&t_id=<?php echo $value['theme_id'];?>" target="_blank"><?php echo $value['theme_name'];?></a></span>
    </li>
    <?php } ?>
    <?php } ?>
</ul>
