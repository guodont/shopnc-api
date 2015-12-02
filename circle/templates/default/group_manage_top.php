<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-tab-menu">
  <dl class="my-manage">
    <dt class="group-name"><strong><a href="<?php echo CIRCLE_SITE_URL;?>/index.php?act=group&c_id=<?php echo $output['c_id'];?>"><?php echo $output['circle_info']['circle_name'];?></a></strong>[<?php echo $lang['circle_management_center'];?>]</dt>
    <dd class="group-pic"><img src="<?php echo circleLogo($output['circle_info']['circle_id']);?>" /></dd>
    <dd class="group-ID"> <?php echo memberIdentity($output['identity']);?> </dd>
  </dl>
  <ul class="base-tabs-nav" id="jsddm">
    <?php if(!empty($output['sidebar_menu'])){?>
    <?php foreach($output['sidebar_menu'] as $key=>$val){?>
    <li <?php if($output['sidebar_sign'] == $key){ echo 'class="selected"';}?>>
      <?php if($key == 'applying' && $output['circle_info']['new_verifycount'] != 0){?>
      <sup><?php echo $output['circle_info']['new_verifycount'];?></sup>
      <?php }else if($key == 'inform' && $output['circle_info']['new_informcount'] != 0){?>
      <sup><?php echo $output['circle_info']['new_informcount'];?></sup>
      <?php }else if($key == 'managerapply' && $output['circle_info']['new_mapplycount'] != 0){?>
      <sup><?php echo $output['circle_info']['new_mapplycount'];?></sup>
      <?php }?>
      <a href="<?php echo $val['menu_url'];?>"><?php echo $val['menu_name'];?></a>
      <?php if(!empty($val['menu_child'])){?>
      <div class="tabs-child-menu">
        <?php foreach ($val['menu_child'] as $k=>$v){?>
        <a href="<?php echo $v['url'];?>" <?php if($output['sidebar_child_sign'] == $k){echo 'class="selected"';}?>><i></i><?php echo $v['name'];?></a>
        <?php }?>
      </div>
      <?php }?>
    </li>
    <?php }?>
    <?php }?>
  </ul>
</div>
