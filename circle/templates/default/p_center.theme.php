<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-layout">
  <div class="mainbox">
    <div class="base-tab-menu">
      <ul class="base-tabs-nav">
        <?php if(!empty($output['member_menu'])){?>
        <?php foreach ($output['member_menu'] as $val){?>
        <li <?php if($val['menu_key'] == $output['menu_key']){?>class="selected"<?php }?>><a href="<?php echo $val['menu_url'];?>"><?php echo $val['menu_name'];?></a></li>
        <?php }?>
        <?php }?>
      </ul>
    </div>
    <div class="my-theme-list">
      <?php if(!empty($output['theme_list'])){?>
      <ul class="group-theme-list">
        <?php foreach($output['theme_list'] as $val){?>
        <li>
          <dl class="theme-info" data-param="{t_id:<?php echo $val['theme_id'];?>,c_id:<?php echo $val['circle_id'];?>}">
            <dt><span class="theme-title"><a href="index.php?act=theme&op=theme_detail&c_id=<?php echo $val['circle_id'];?>&t_id=<?php echo $val['theme_id'];?>" target="_blank" class="title"><?php echo $val['theme_name'];?></a></span></dt>
            <dd class="theme-content">
              <div class="theme-file">
                <?php if(!empty($output['affix_list'][$val['theme_id']])){$array = array_slice($output['affix_list'][$val['theme_id']], 0, 3)?>
                <?php foreach ($array as $v){?>
                <span><a href="Javascript: void(0);"><img src="<?php echo themeImageUrl($v['affix_filethumb']);?>" class="t-img" /></a></span>
                <?php }?>
                <?php }?>
              </div>
              <div class="theme-summary"><?php echo replaceUBBTag($val['theme_content'], 0);?></div>
              <div class="theme-info">
                <time><?php echo date('Y-m-d', $val['theme_addtime']);?></time>
                <?php echo $lang['p_center_published_since'];?><span class="group-name">&#8220;<a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name'];?></a>&#8221;<?php echo $lang['p_center_is_theme'];?></span>
                <?php if($val['lastspeak_name']){?>
                <span class="ml20"><?php echo $lang['circle_reply'];?>(<em><?php echo $val['theme_commentcount'];?></em>)</span>
                <?php }else{?>
                </span> <span class="ml20"><?php echo $lang['circle_no_comment'];?></span>
                <?php }?>
                <span class="ml10"><?php echo $lang['circle_like'];?>(<em><?php echo $val['theme_likecount'];?></em>)</span></div>
            </dd>
          </dl>
        </li>
        <?php }?>
      </ul>
      <div class="pagination"><?php echo $output['show_page'];?></div>
      <?php }else{?>
      <div class="no-theme"><span><i></i><?php echo $lang['p_center_not_published_theme'];?></span></div>
      <?php }?>
    </div>
  </div>
  <?php include circle_template('p_center.sidebar');?>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script type="text/javascript">
$(function(){
	$(".theme-file .t-img").VMiddleImg({"width":100,"height":100});
});
</script>