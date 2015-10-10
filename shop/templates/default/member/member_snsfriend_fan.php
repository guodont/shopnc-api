<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <?php if ($output['fan_list']) { ?>
  <ul class="ncm-friend-list">
    <?php foreach($output['fan_list'] as $k => $v){ ?>
    <li id="recordone_<?php echo $v['friend_frommid']; ?>">
      <div class="avatar"><a href="index.php?act=member_snshome&mid=<?php echo $v['friend_frommid'];?>" target="_blank" data-param="{'id':<?php echo $v['friend_frommid'];?>}" nctype="mcard"><img src="<?php if ($v['member_avatar']!='') { echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR.DS.$v['member_avatar']; } else { echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('default_user_portrait'); } ?>" alt="<?php echo $v['friend_frommname']; ?>"/></a></div>
      <dl class="info">
        <dt><a href="index.php?act=member_snshome&mid=<?php echo $v['friend_frommid'];?>" title="<?php echo $v['friend_tomname']; ?>" target="_blank" data-param="{'id':<?php echo $v['friend_frommid'];?>}" nctype="mcard"><?php echo $v['friend_frommname']; ?></a><i class="<?php echo $v['sex_class'];?>"></i></dt>
        <dd class="area"><?php echo $v['member_areainfo'];?></dd>
        <dd><a href="index.php?act=member_message&op=sendmsg&member_id=<?php echo $v['friend_frommid']; ?>" target="_blank" title="<?php echo $lang['nc_message'] ;?>"><i class="icon-envelope"></i><?php echo $lang['nc_message'] ;?></a></dd>
      </dl>
      <div class="follow" nc_type="signmodule"><p nc_type="mutualsign" style="<?php echo $v['friend_followstate']!=2?'display:none;':'';?>"><i></i><?php echo $lang['snsfriend_follow_eachother']?></p> <a href="javascript:void(0)" class="ncm-btn-mini ncm-btn-green" nc_type="followbtn" data-param='{"mid":"<?php echo $v['friend_frommid'];?>"}' style="<?php echo $v['friend_followstate']==2?'display:none;':'';?>"><i class="icon-plus"></i><?php echo $lang['snsfriend_followbtn'];?></a> </div>
    </li>
    <?php } ?>
  </ul>
  <?php } else { ?>
  <div class="warning-option"><i></i><span><?php echo $lang['no_record'];?></span></div>
  <?php } ?>
  <?php if ($output['fan_list']) { ?>
  <div class="tc"><div class="pagination"> <?php echo $output['show_page']; ?> </div></div>
  </td>
  <?php } ?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns_friend.js"></script> 
