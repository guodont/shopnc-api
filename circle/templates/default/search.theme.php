<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="search-page">
  <div class="layout-l">
    <div class="search-title">
      <h3><?php echo $lang['circle_to_search'];?>"<em><?php echo $output['count'];?></em>"<?php echo $lang['circle_item'];?>
        <?php if($_GET['keyword'] != ''){?>
        <?php echo $lang['circle_yu'];?>"<em><?php echo $_GET['keyword'];?></em>"<?php echo $lang['circle_relevant'];?>
        <?php }?>
        <?php echo $lang['circle_result'];?></h3>
    </div>
    <?php if(!empty($output['theme_list'])){?>
    <ul class="search-theme-list">
      <?php foreach($output['theme_list'] as $val){?>
      <li>
        <dl>
          <dt class="theme-title"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>"><?php echo $val['theme_name'];?></a></dt>
          <dd class="member-avatar-m"><img src="<?php echo getMemberAvatarForID($val['member_id']);?>"/></dd>
          <dd class="theme-sub"><span class="theme-avatar"><?php echo $lang['circle_theme_author'].$lang['nc_colon'];?><a target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=sns_circle&mid=<?php echo $val['member_id'];?>"><?php echo $val['member_name'];?></a></span><span><?php echo $lang['circle_release_time'].$lang['nc_colon'];?><em><?php echo @date('Y-m-d', $val['theme_addtime']);?></em></span><span class="theme-group"><?php echo $lang['circle_come_from_group'].$lang['nc_colon'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name'];?></a></span></dd>
          <?php if($val['theme_editname'] != ''){?>
          <dd class="theme-date"><span class="theme-replyer"><?php echo $lang['circle_lastspeak'].$lang['nc_colon'];?><a href="Javascript: void(0);"><?php echo $val['theme_editname'];?></a></span><span><?php echo $lang['circle_reply_time'].$lang['nc_colon'];?><em><?php echo @date('Y-m-d', $val['theme_edittime']);?></em></span></dd>
          <?php }?>
          <dd class="theme-preface"><span><?php echo replaceUBBTag($val['theme_content'], 0);?></span><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>">[<?php echo $lang['circle_look_at_original'];?>]</a></dd>
        </dl>
      </li>
      <?php }?>
    </ul>
    <div class="pagination"><?php echo $output['show_page'];?></div>
    <?php }else{?>
    <div class="no-theme"><span> <i></i><?php echo $lang['circle_result_null'];?></span></div>
    <?php }?>
  </div>
  <div class="layout-r">
    <?php require_once circle_template('index.themetop');?>
  </div>
</div>
