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
  <div class="layout-l">
  <div class="search-group-list">
  <?php if(!empty($output['circle_list'])){?>
    <ul>
    <?php foreach($output['circle_list'] as $val){?>
      <li>
        <dl class="group-info">
          <dt class="group-name">
            <a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><?php echo $val['circle_name']?></a>
            <?php echo memberLevelHtml(array('cm_level'=>$output['cm_array'][$val['circle_id']]['cm_level'], 'cm_levelname'=>$output['cm_array'][$val['circle_id']]['cm_levelname'], 'circle_id'=>$val['circle_id']));?>
          </dt>
          <dd class="group-pic"><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $val['circle_id'];?>"><img src="<?php echo circleLogo($val['circle_id']);?>" /></a></dd>
          <dd class="group-time"><?php echo $lang['circle_created_at'];?><em><?php echo @date('Y-m-d', $val['circle_addtime'])?></em></dd>
          <dd class="group-total"><em><?php echo $val['circle_mcount'];?></em><?php echo $lang['circle_members'];?></dd>
          <dd class="group-intro"><?php echo $val['circle_desc'];?></dd>
        </dl>
      </li>
      <?php }?>
    </ul>
    <?php }else{?>
    <div class="no-theme"><span> <i></i><?php echo $lang['p_center_not_jion_circle'];?></span></div>
    <?php }?>
  </div></div>
</div>
  <?php include circle_template('p_center.sidebar');?>
</div>