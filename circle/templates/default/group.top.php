<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="group-top">
  <dl class="circle-info">
    <dt class="name">
      <h2><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $output['c_id'];?>" class="group-name"><?php echo $output['circle_info']['circle_name'];?></a></h2>
      <?php switch ($output['identity']){
      	case 0:
      	case 5:
      		echo '<div class="button"><a href="javascript:void(0);" nctype="apply" class="btn"><i class="apply"></i>'.$lang['circle_apply_to_join'].'</a></div>';
      		break;
      	case 1:
      		echo '<div class="button"><a href="index.php?act=manage&c_id='.$output['circle_info']['circle_id'].'" class="btn"><i class="manage"></i>'.$lang['manage_circle'].'</a></div>';
      		if($output['circle_info']['new_verifycount'] != 0)
      			echo '<div class="pending"><a href="index.php?act=manage&op=applying&c_id='.$output['c_id'].'">'.$lang['circle_wait_verity_count'].'</a><sup>'.$output['circle_info']['new_verifycount'].'</sup></div>';
      		if($output['circle_info']['new_informcount'] != 0)
      			echo '<div class="pending"><a href="index.php?act=manage_inform&op=inform&c_id='.$output['c_id'].'">'.$lang['circle_new_inform'].'</a><sup>'.$output['circle_info']['new_informcount'].'</sup></div>';
      		if($output['circle_info']['new_mapplycount'] != 0)
      			echo '<div class="pending"><a href="index.php?act=manage_mapply&c_id='.$output['c_id'].'">'.$lang['circle_management_application'].'</a><sup>'.$output['circle_info']['new_mapplycount'].'</sup></div>';
      		break;
      	case 2:
      		echo '<div class="button"><a href="index.php?act=manage&c_id='.$output['circle_info']['circle_id'].'" class="btn"><i class="manage"></i>'.$lang['manage_circle'].'</a><a href="javascript:void(0);" nctype="quitGroup" class="btn"><i class="quit"></i>'.$lang['circle_quit_group'].'</a></div>';
      		if($output['circle_info']['new_verifycount'] != 0)
      			echo '<div class="pending"><a href="index.php?act=manage&op=applying&c_id='.$output['c_id'].'">'.$lang['circle_wait_verity_count'].'</a><sup>'.$output['circle_info']['new_verifycount'].'</sup></div>';
      		if($output['circle_info']['new_informcount'] != 0)
      			echo '<div class="pending"><a href="index.php?act=manage_inform&op=inform&c_id='.$output['c_id'].'">'.$lang['circle_new_inform'].'</a><sup>'.$output['circle_info']['new_informcount'].'</sup></div>';
      		
      		break;
      	case 4:
      		echo '<div class="button"><a href="javascript:void(0);" class="btn">'.$lang['circle_applying_wait_verify'].'</a></div>';
      		break;
      	case 3:
      	case 6:
      		echo '<div class="button"><a href="javascript:void(0);" nctype="quitGroup" class="btn"><i class="quit"></i>'.$lang['circle_quit_group'].'</a></div>';
      		break;
      }?>
    </dt>
    <dd class="pic"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $output['c_id'];?>"><img src="<?php echo circleLogo($output['circle_info']['circle_id']);?>"/></a></dd>
    <dd class="intro"><?php if($output['circle_info']['circle_desc'] != ''){ echo $output['circle_info']['circle_desc'];}else{ echo $lang['circle_desc_null_default'];}?></dd>
    <dd class="manage">
      <span class="master">
        <?php echo $lang['circle_manager'].$lang['nc_colon'];?><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&op=theme&mid=<?php echo $output['creator']['member_id'];?>" nctype="mcard" data-param="{'id':<?php echo $output['creator']['member_id'];?>}"><i></i><?php echo $output['creator']['member_name'];?></a>
      </span>
      <span class="moderator">
        <?php echo $lang['circle_administrate'].$lang['nc_colon'];?>
        <?php if(!empty($output['manager_list'])){foreach($output['manager_list'] as $val){?>
        <a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $val['member_id'];?>"  nctype="mcard" data-param="{'id':<?php echo $val['member_id'];?>}"><i></i><?php echo $val['member_name'];?></a>
        <?php }}else{echo $lang['circle_no_administrate'];}?>
        <?php if($output['circle_info']['mapply_open'] == 1 && $output['identity'] == 3 && $output['cm_info']['cm_level'] >= $output['circle_info']['mapply_ml']){?>
        <a href="javascript:void(0);" nctype="manageApply"><?php echo $lang['circle_apply_to_be_a_management'];?></a>
        <?php }?>
      </span>
    </dd>
  </dl>
  <div class="circle-create"><a href="javascript:void(0);" nctype="create_circle"><i></i><?php echo $lang['circle_create_my_new_circle'];?></a></div>
  <div class="clear"></div>
</div>
<div class="breadcrumd">
  <h4><?php echo $lang['circle_current_location'].$lang['nc_colon'];?></h4>
  <?php if(!empty($output['breadcrumd'])){?>
    <?php foreach ($output['breadcrumd'] as $val){?>
    <?php if($val['link'] != ''){?>
    <a href="<?php echo $val['link'];?>"><?php echo $val['title'];?></a>
    <?php }else{echo $val['title'];}?>
    <?php }?>
  <?php }?>
</div>
<script type="text/javascript" src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/group.js" charset="utf-8"></script> 
<script>
var c_id = <?php echo $output['c_id'];?>;
var identity = <?php echo $output['identity'];?>;
</script>
