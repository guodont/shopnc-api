<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="search-page">
  <div class="layout-l">
    <div class="search-title">
      <h3><?php echo $lang['circle_to_search'];?>"<em><?php echo $output['count'];?></em>"<?php echo $lang['circle_item'];?><?php if($_GET['keyword'] != ''){?><?php echo $lang['circle_yu'];?>"<em><?php echo $_GET['keyword'];?></em>"<?php echo $lang['circle_relevant'];?><?php }elseif($_GET['class_name'] != ''){?><?php echo $lang['circle_yu'];?>"<em><?php echo $_GET['class_name'];?></em>"<?php echo $lang['circle_class_relavant']; }?><?php echo $lang['circle_result'];?></h3>
    </div>
  <div class="search-group-list">
  <?php if(!empty($output['circle_list'])){?>
    <ul>
    <?php foreach($output['circle_list'] as $val){?>
      <li>
        <dl class="group-info">
          <dt class="group-name"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name']?></a></dt>
          <dd class="group-pic"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><img src="<?php echo circleLogo($val['circle_id']);?>" /></a></dd>
          <dd class="group-time"><?php echo $lang['circle_created_at'];?><em><?php echo @date('Y-m-d', $val['circle_addtime'])?></em></dd>
          <dd class="group-total"><em><?php echo $val['circle_mcount'];?></em><?php echo $lang['circle_members'];?></dd>
          <dd class="group-intro"><?php echo $val['circle_desc'];?></dd>
        </dl>
      </li>
      <?php }?>
    </ul>
    <div class="pagination"><?php echo $output['show_page'];?></div>
    <?php }else{?>
    <div class="no-theme">
      <i></i>
      <span><?php echo $lang['circle_result_null'].L('nc_comma,circle_go');?><a href="<?php echo CIRCLE_SITE_URL;?>"><?php echo L('circle_home_page_around');?></a></span>
      <br>
      <span><?php echo $lang['circle_search_null_msg'];?><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=index&op=add_group&kw=<?php echo $_GET['keyword'];?>"><?php echo $lang['circle_instantly_create'];?></a></span>
    </div>
    <div></div>
    <?php }?>
  </div></div>
  <div class="layout-r">
    <?php require_once circle_template('index.themetop');?>
  </div>
</div>