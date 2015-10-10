<?php defined('InShopNC') or exit('Access Invalid!');?>

<ul class="circle-more-membertheme">
  <?php if(!empty($output['more_membertheme']) && is_array($output['more_membertheme'])) {?>
  <?php foreach($output['more_membertheme'] as $key=>$value) {?>
  <li class="circle-member-item">
    <div class="circle-member-avatar"> <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $value['member_id'];?>" target="_blank"> <img src="<?php echo getMemberAvatarForID($value['member_id']);?>" /> </a> </div>
    <div class="circle-member-name"> <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $value['member_id'];?>" target="_blank"> <?php echo $value['member_name'];?> </a> </div>
    <div class="circle-member-theme"> <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $value['circle_id'];?>&t_id=<?php echo $value['theme_id'];?>" target="_blank"> <?php echo $value['theme_name'];?> </a> </div>
  </li>
  <?php } ?>
  <?php } ?>
</ul>
