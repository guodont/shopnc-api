<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="sidebar">
  <div class="my-info">
    <div class="avatar"><img class="t-img" src="<?php echo getMemberAvatarForID($output['cm_info']['member_id']);?>" /><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_information&op=avatar" title="<?php echo $lang['nc_edit_avatar'];?>"><?php echo $lang['nc_edit_avatar'];?></a></div>
    <dl>
      <dt>
        <h2><a href="javascript:void(0);" target="_blank"><?php echo $output['cm_info']['member_name'];?></a></h2>
      </dt>
      <dd><span><?php echo $lang['circle_theme'].$lang['nc_colon'];?><em>(<b><?php echo intval($output['cm_info']['cm_thcount']);?></b>)</em></span><span><?php echo $lang['circle_reply'].$lang['nc_colon'];?><em>(<b><?php echo intval($output['cm_info']['cm_comcount']);?></b>)</em></span></dd>
    </dl>
  </div>
  <ul class="sidebar-menu">
    <li <?php if($output['menu_type'] == 'theme'){?>class="selected"<?php }?>><a href="index.php?act=p_center"><?php echo $lang['p_center_my_posts'];?></a></li>
    <li <?php if($output['menu_type'] == 'group'){?>class="selected"<?php }?>><a href="index.php?act=p_center&op=my_group"><?php echo $lang['p_center_my_circle'];?></a></li>
    <li <?php if($output['menu_type'] == 'inform'){?>class="selected"<?php }?>><a href="index.php?act=p_center&op=my_inform"><?php echo $lang['p_center_my_inform'];?></a></li>
    <li <?php if($output['menu_type'] == 'recycled'){?>class="selected"<?php }?>><a href="index.php?act=p_center&op=my_recycled"><?php echo $lang['p_center_my_recycled'];?></a></li>
  </ul>
</div>
