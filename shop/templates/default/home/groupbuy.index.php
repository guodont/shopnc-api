<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_group.css" rel="stylesheet" type="text/css">
<style type="text/css">
.nch-breadcrumb-layout {display: none; }
</style>
<div class="nch-breadcrumb-layout" style="display: block;">
  <div class="nch-breadcrumb wrapper"> <i class="icon-home"></i> <span> <a href="<?php echo urlShop(); ?>">首页</a> </span> <span class="arrow">></span> <span>商城抢购</span></div>
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
    <?php if (!empty($output['picArr'])) { ?>
    <div class="ncg-slides-banner">
      <ul id="fullScreenSlides" class="full-screen-slides">
        <?php foreach($output['picArr'] as $p) { ?>
        <li><a href="<?php echo $p[1];?>" target="_blank"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_LIVE.'/'.$p[0];?>"></a></li>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>

    <div class="group-list mt20">
      <div class="ncg-recommend-title">
        <h3>线上抢购推荐</h3>
        <a href="<?php echo urlShop('show_groupbuy', 'groupbuy_list'); ?>" class="more">查看更多</a></div>
      <?php if (!empty($output['groupbuy'])) { ?>
      <ul>
        <?php foreach ($output['groupbuy'] as $groupbuy) { ?>
        <li class="<?php echo $output['current'];?>">
          <div class="ncg-list-content"> <a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" class="pic-thumb" target="_blank"><img src="<?php echo gthumb($groupbuy['groupbuy_image'],'mid');?>" alt=""></a>
            <h3 class="title"><a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank"><?php echo $groupbuy['groupbuy_name'];?></a></h3>
            <?php list($integer_part, $decimal_part) = explode('.', $groupbuy['groupbuy_price']);?>
            <div class="item-prices"> <span class="price"><i><?php echo $lang['currency'];?></i><?php echo $integer_part;?><em>.<?php echo $decimal_part;?></em></span>
              <div class="dock"><span class="limit-num"><?php echo $groupbuy['groupbuy_rebate'];?>&nbsp;<?php echo $lang['text_zhe'];?></span> <del class="orig-price"><?php echo $lang['currency'].$groupbuy['goods_price'];?></del></div>
              <span class="sold-num"><em><?php echo $groupbuy['buy_quantity']+$groupbuy['virtual_quantity'];?></em><?php echo $lang['text_piece'];?><?php echo $lang['text_buy'];?></span><a href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank" class="buy-button">我要抢</a></div>
          </div>
        </li>
        <?php } ?>
      </ul>
      <?php } else { ?>
      <div class="norecommend">暂无线上抢购推荐</div>
      <?php } ?>
    </div>
    <div class="group-list mt30">
      <div class="ncg-recommend-title">
        <h3>虚拟抢购推荐</h3>
        <a href="<?php echo urlShop('show_groupbuy', 'vr_groupbuy_list'); ?>" class="more">查看更多</a></div>
      <?php if (!empty($output['vr_groupbuy'])) { ?>
      <ul>
        <?php foreach($output['vr_groupbuy'] as $groupbuy) { ?>
        <li class="<?php echo $output['current'];?>">
          <div class="ncg-list-content"> <a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" class="pic-thumb" target="_blank"><img src="<?php echo gthumb($groupbuy['groupbuy_image'],'mid');?>" alt=""></a>
            <h3 class="title"><a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank"><?php echo $groupbuy['groupbuy_name'];?></a></h3>
            <?php list($integer_part, $decimal_part) = explode('.', $groupbuy['groupbuy_price']);?>
            <div class="item-prices"> <span class="price"><i><?php echo $lang['currency'];?></i><?php echo $integer_part;?><em>.<?php echo $decimal_part;?></em></span>
              <div class="dock"><span class="limit-num"><?php echo $groupbuy['groupbuy_rebate'];?>&nbsp;<?php echo $lang['text_zhe'];?></span> <del class="orig-price"><?php echo $lang['currency'].$groupbuy['goods_price'];?></del></div>
              <span class="sold-num"><em><?php echo $groupbuy['buy_quantity']+$groupbuy['virtual_quantity'];?></em><?php echo $lang['text_piece'];?><?php echo $lang['text_buy'];?></span><a href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank" class="buy-button">我要抢</a></div>
          </div>
        </li>
        <?php } ?>
      </ul>
      <?php } else{ ?>
      <div class="norecommend">暂无虚拟抢购推荐</div>
      <?php } ?>
    </div>
  </div>
</div>
