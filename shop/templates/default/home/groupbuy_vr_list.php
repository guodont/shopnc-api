<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php require('groupbuy_head.php');?>
<div class="nch-breadcrumb-layout" style="display: block;">
  <div class="nch-breadcrumb wrapper"> <i class="icon-home"></i> <span> <a href="<?php echo urlShop(); ?>">首页</a> </span> <span class="arrow">></span> <span>虚拟抢</span></div>
</div>

<div class="ncg-container">
  <div class="ncg-category" id="ncgCategory">
    <h3>线上抢</h3>
    <ul>
<?php $i = 0; $names = $output['groupbuy_classes']['name']; foreach ((array) $output['groupbuy_classes']['children'][0] as $v) { if (++$i > 6) break; ?>
      <li><a href="<?php echo urlShop('show_groupbuy', 'groupbuy_list', array('class' => $v)); ?>"><?php echo $names[$v]; ?></a></li>
<?php } ?>
    </ul>
    <h3>虚拟抢</h3>
    <ul>
<?php $i = 0; $names = $output['groupbuy_vr_classes']['name']; foreach ((array) $output['groupbuy_vr_classes']['children'][0] as $v) { if (++$i > 6) break; ?>
      <li><a href="<?php echo urlShop('show_groupbuy', 'vr_groupbuy_list', array('vr_class' => $v)); ?>"><?php echo $names[$v]; ?></a></li>
<?php } ?>
    </ul>
  </div>

  <div class="ncg-content">
    <div class="ncg-nav">
      <ul>
        <li<?php if ($output['current'] == 'online') echo ' class="current"'; ?>><a href="<?php echo urlShop('show_groupbuy', 'vr_groupbuy_list');?>">正在进行</a></li>
        <li<?php if ($output['current'] == 'soon') echo ' class="current"'; ?>><a href="<?php echo urlShop('show_groupbuy', 'vr_groupbuy_soon');?>">即将开始</a></li>
        <li<?php if ($output['current'] == 'history') echo ' class="current"'; ?>><a href="<?php echo urlShop('show_groupbuy', 'vr_groupbuy_history');?>">已经结束</a></li>
      </ul>
    </div>

    <div class="ncg-screen">

<?php if ($output['groupbuy_vr_classes']['children'][0]) { ?>
      <!-- 分类过滤列表 -->
      <dl>
        <dt>分类：</dt>
        <dd class="nobg<?php if (!($hasChildren = !empty($_GET['vr_class']))) echo ' selected'; ?>"><a href="<?php echo dropParam(array('vr_class', 'vr_s_class')); ?>"><?php echo $lang['text_no_limit']; ?></a></dd>
<?php $names = $output['groupbuy_vr_classes']['name']; foreach ($output['groupbuy_vr_classes']['children'][0] as $v) { ?>
        <dd<?php if ($hasChildren && $_GET['vr_class'] == $v) echo ' class="selected"'; ?>><a href="<?php echo replaceAndDropParam(array('vr_class' => $v), array('vr_s_class')); ?>"><?php echo $names[$v]; ?></a></dd>
<?php } ?>
<?php if ($hasChildren && $output['groupbuy_vr_classes']['children'][$_GET['vr_class']]) { ?>
        <ul>
<?php foreach ($output['groupbuy_vr_classes']['children'][$_GET['vr_class']] as $v) { ?>
          <li<?php if ($_GET['vr_s_class'] == $v) echo ' class="selected"'; ?>><a href="<?php echo replaceParam(array('vr_s_class' => $v)); ?>"><?php echo $names[$v]; ?></a></li>
<?php } ?>
        </ul>
<?php } ?>
      </dl>
<?php } ?>

<?php
$vr_city_id = (int) $output['vr_city_id'];
$vr_area_id = (int) $output['vr_area_id'];
$vr_mall_id = (int) $output['vr_mall_id'];

if ($vr_city_id > 0) {
    $names = $output['groupbuy_vr_cities']['name'];

    $areaIds = (array) $output['groupbuy_vr_cities']['children'][$vr_city_id];
    $areaIsNoLimit = !$areaIds || $vr_area_id < 1;
    $mallIds = in_array($vr_area_id, $areaIds)
        ? (array) $output['groupbuy_vr_cities']['children'][$vr_area_id]
        : array();

?>
      <!-- 区域过滤列表 -->
      <dl>
        <dt>区域：</dt>
        <dd class="nobg<?php if ($areaIsNoLimit) echo ' selected'; ?>"><a href="<?php echo dropParam(array('vr_area', 'vr_mall')); ?>"><?php echo $lang['text_no_limit']; ?></a></dd>
<?php foreach ($areaIds as $v) { ?>
        <dd<?php if ($vr_area_id == $v) echo ' class="selected"'; ?>><a href="<?php echo replaceAndDropParam(array('vr_area' => $v), array('vr_mall')); ?>"><?php echo $names[$v]; ?></a></dd>
<?php } ?>
<?php if ($mallIds) { ?>
        <ul>
<?php foreach ($mallIds as $v) { ?>
          <li<?php if ($vr_mall_id == $v) echo ' class="selected"'; ?>><a href="<?php echo replaceParam(array('vr_mall' => $v)); ?>"><?php echo $names[$v]; ?></a></li>
<?php } ?>
        </ul>
<?php } ?>
      </dl>
<?php } ?>

      <!-- 价格过滤列表 -->
      <dl>
        <dt><?php echo $lang['text_price'];?>：</dt>
        <dd class="<?php echo empty($_GET['groupbuy_price'])?'selected':''?>"><a href="<?php echo dropParam(array('groupbuy_price'));?>"><?php echo $lang['text_no_limit'];?></a></dd>
        <?php if(is_array($output['price_list'])) { ?>
        <?php foreach($output['price_list'] as $groupbuy_price) { ?>
        <dd <?php echo $_GET['groupbuy_price'] == $groupbuy_price['range_id']?"class='selected'":'';?>> <a href="<?php echo replaceParam(array('groupbuy_price' => $groupbuy_price['range_id']));?>"><?php echo $groupbuy_price['range_name'];?></a> </dd>
        <?php } ?>
        <?php } ?>
      </dl>

      <dl class="ncg-sortord">
        <dt>排序：</dt>
        <dd class="<?php echo empty($_GET['groupbuy_order_key'])?'selected':''?>"><a href="<?php echo dropParam(array('groupbuy_order_key', 'groupbuy_order'))?>"><?php echo $lang['text_default'];?><i></i></a></dd>
        <dd <?php echo $_GET['groupbuy_order_key'] == '1'?"class='selected'":'';?>><a <?php echo $_GET['groupbuy_order_key'] == '1'?"class='". ($_GET['groupbuy_order'] == 1 ? 'asc' : 'desc') ."'":'';?> href="<?php echo ($_GET['groupbuy_order_key'] == '1' && $_GET['groupbuy_order'] == '2' ? replaceParam(array('groupbuy_order_key' => '1', 'groupbuy_order' => '1')) : replaceParam(array('groupbuy_order_key' => '1', 'groupbuy_order' => '2')));?>"><?php echo $lang['text_price'];?><i></i></a></dd>
        <dd <?php echo $_GET['groupbuy_order_key'] == '2'?"class='selected'":'';?>><a <?php echo $_GET['groupbuy_order_key'] == '2'?"class='". ($_GET['groupbuy_order'] == 1 ? 'asc' : 'desc') ."'":'';?> href="<?php echo ($_GET['groupbuy_order_key'] == '2' && $_GET['groupbuy_order'] == '2' ? replaceParam(array('groupbuy_order_key' => '2', 'groupbuy_order' => '1')) : replaceParam(array('groupbuy_order_key' => '2', 'groupbuy_order' => '2')));?>"><?php echo $lang['text_rebate'];?><i></i></a></dd>
        <dd <?php echo $_GET['groupbuy_order_key'] == '3'?"class='selected'":'';?>><a <?php echo $_GET['groupbuy_order_key'] == '3'?"class='". ($_GET['groupbuy_order'] == 1 ? 'asc' : 'desc') ."'":'';?> href="<?php echo ($_GET['groupbuy_order_key'] == '3' && $_GET['groupbuy_order'] == '2' ? replaceParam(array('groupbuy_order_key' => '3', 'groupbuy_order' => '1')) : replaceParam(array('groupbuy_order_key' => '3', 'groupbuy_order' => '2')));?>"><?php echo $lang['text_sale'];?><i></i></a></dd>
      </dl>
    </div>

    <?php if (!empty($output['groupbuy_list']) && is_array($output['groupbuy_list'])) { ?>
    <!-- 抢购活动列表 -->
    <div class="group-list">
      <ul>
        <?php foreach ($output['groupbuy_list'] as $groupbuy) { ?>
        <li class="<?php echo $output['current']; ?>">
          <div class="ncg-list-content"> <a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" class="pic-thumb" target="_blank"><img src="<?php echo gthumb($groupbuy['groupbuy_image'],'mid');?>" alt=""></a>
            <h3 class="title"><a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank"><?php echo $groupbuy['groupbuy_name'];?></a></h3>
            <?php list($integer_part, $decimal_part) = explode('.', $groupbuy['groupbuy_price']);?>
            <div class="item-prices"> <span class="price"><i><?php echo $lang['currency'];?></i><?php echo $integer_part;?><em>.<?php echo $decimal_part;?></em></span>
              <div class="dock"><span class="limit-num"><?php echo $groupbuy['groupbuy_rebate'];?>&nbsp;<?php echo $lang['text_zhe'];?></span> <del class="orig-price"><?php echo $lang['currency'].$groupbuy['goods_price'];?></del></div>
              <span class="sold-num"><em><?php echo $groupbuy['buy_quantity']+$groupbuy['virtual_quantity'];?></em><?php echo $lang['text_piece'];?><?php echo $lang['text_buy'];?></span><a href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank" class="buy-button"><?php echo $output['buy_button'];?></a></div>
          </div>
        </li>
        <?php } ?>
      </ul>
    </div>
    <div class="tc mt20 mb20">
      <div class="pagination"><?php echo $output['show_page'];?></div>
    </div>
    <?php } else { ?>
    <div class="no-content"><?php echo $lang['no_groupbuy_info'];?></div>
    <?php } ?>

  </div>
</div>
