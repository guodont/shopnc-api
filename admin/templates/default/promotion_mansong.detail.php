<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page"> 
  <!-- 页面导航 -->
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['promotion_mansong'];?></h3>
      <ul class="tab-base">
        <?php   foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php }  else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- 帮助 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2">
    <thead>
      <tr class="thead">
        <th class="w24"></th>
        <th class="align-left"><?php echo $lang['mansong_name'];?></th>
        <th class="align-center"><?php echo $lang['start_time'];?></th>
        <th class="align-center"><?php echo $lang['end_time'];?></th>
        <th class="align-center">活动内容</th>
        <th class="align-center"><?php echo $lang['nc_state'];?></th>
      </tr>
    </thead>
    <tbody>
      <tr class="bd-line">
        <td></td>
        <td class="align-left"><?php echo $output['mansong_info']['mansong_name'];?></td>
        <td class="align-center"><?php echo date('Y-m-d H:i',$output['mansong_info']['start_time']);?></td>
        <td class="align-center"><?php echo date('Y-m-d H:i',$output['mansong_info']['end_time']);?></td>
        <td><ul class="mansong-rule-list">
            <?php if(!empty($output['list']) && is_array($output['list'])){?>
            <?php foreach($output['list'] as $key=>$val){?>
            <li><?php echo $lang['level_price'];?><strong><?php echo $val['price'];?></strong>元，&nbsp;<?php echo $lang['level_discount'];?><strong><?php echo empty($val['discount'])?$lang['text_not_join']:$val['discount'];?></strong>元，&nbsp;
              <?php if(empty($val['goods_id'])) { ?>
              <?php echo $lang['gift_name'];?> <span><?php echo $lang['text_not_join'];?></span>
              <?php } else { ?>
              <a href="<?php echo $val['goods_url'];?>" title="<?php echo $val['mansong_goods_name'];?>" target="_blank" class="goods-thumb"> <img src="<?php echo cthumb($val['goods_image']);?>"/> </a>
              <?php } ?>
            </li>
            <?php }?>
            <?php }?>
          </ul></td>
        <td class="align-center"><?php echo $output['mansong_info']['mansong_state_text'];?></td>
      </tr>
    <tbody>
  </table>
</div>
