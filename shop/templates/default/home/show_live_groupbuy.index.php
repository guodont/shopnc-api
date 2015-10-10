<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_group.css" rel="stylesheet" type="text/css">
<style type="text/css">
.nch-breadcrumb-layout {
	display: none;
}
</style>
<div class="nch-breadcrumb-layout" style="display: block;">
  <div class="nch-breadcrumb wrapper"> <i class="icon-home"></i> <span> <a href="index.php">首页</a> </span> <span class="arrow">></span> <span>商城抢购</span></div>
</div>
<div class="ncg-container">
  <div class="ncg-category" id="ncgCategory">
    <h3>抢商品</h3>
    <ul>
      <?php if(!empty($output['online'])){?>
      <?php $i = 0;?>
      <?php foreach($output['online'] as $online){?>
      <?php if($i>7) break;?>
      <li><a href="index.php?act=show_groupbuy&op=index&groupbuy_class=<?php echo $online['class_id'];?>"><?php echo $online['class_name'];?></a></li>
      <?php $i++;?>
      <?php }?>
      <?php }?>
    </ul>
    <h3>线下抢</h3>
    <ul>
      <?php if(!empty($output['class_root'])){?>
      <?php $j = 0;?>
      <?php foreach($output['class_root'] as $offline){?>
      <?php if($j>7) break;?>
      <li><a href="index.php?act=show_live_groupbuy&op=live_groupbuy_list&class_id=<?php echo $offline['live_class_id'];?>"><?php echo $offline['live_class_name'];?></a></li>
      <?php $j++;?>
      <?php }?>
      <?php }?>
    </ul>
  </div>
  <div class="ncg-content">
    <div class="ncg-slides-banner">
      <ul id="fullScreenSlides" class="full-screen-slides">
        <?php if(!empty($output['picArr'])){?>
        <?php foreach($output['picArr'] as $p){?>
        <li><a href="<?php echo $p[1];?>" target="_blank"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_LIVE.'/'.$p[0];?>"></a></li>
        <?php }?>
        <?php }?>
      </ul>
    </div>
    <div class="group-list mt20">
      <div class="ncg-recommend-title">
        <h3>商品抢购推荐</h3>
        <a href="<?php echo urlShop('show_groupbuy', 'index');?>" class="more">查看更多</a></div>
      <?php if(!empty($output['groupbuy'])){?>
      <ul>
        <?php foreach($output['groupbuy'] as $groupbuy) { ?>
        <li class="<?php echo $output['current'];?>">
          <div class="ncg-list-content"> <a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" class="pic-thumb" target="_blank"><img src="<?php echo gthumb($groupbuy['groupbuy_image'],'mid');?>" alt=""></a>
            <h3 class="title"><a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank"><?php echo $groupbuy['groupbuy_name'];?></a></h3>
            <?php list($integer_part, $decimal_part) = explode('.', $groupbuy['groupbuy_price']);?>
            <div class="item-prices"> <span class="price"><i><?php echo $lang['currency'];?></i><?php echo $integer_part;?><em>.<?php echo $decimal_part;?></em></span>
              <div class="dock"><span class="limit-num"><?php echo $groupbuy['groupbuy_rebate'];?>&nbsp;<?php echo $lang['text_zhe'];?></span> <del class="orig-price"><?php echo $lang['currency'].$groupbuy['goods_price'];?></del></div>
              <span class="sold-num"><em><?php echo $groupbuy['buy_quantity']+$groupbuy['virtual_quantity'];?></em><?php echo $lang['text_piece'];?><?php echo $lang['text_buy'];?></span><a href="<?php echo $groupbuy['groupbuy_url'];?>" target="_blank" class="buy-button"><?php echo $lang['nc_groupbuy_buy_button'];?></a></div>
          </div>
        </li>
        <?php } ?>
      </ul>
      <?php }else{ ?>
      <div class="norecommend">暂无抢购推荐</div>
      <?php }?>
    </div>
    <div class="group-list mt30">
      <div class="ncg-recommend-title">
        <h3>线下抢购推荐</h3>
        <a href="<?php echo urlShop('show_live_groupbuy', 'live_groupbuy_list');?>" class="more">查看更多</a></div>
      <?php if(!empty($output['live_groupbuy'])){?>
      <ul>
        <?php foreach($output['live_groupbuy'] as $groupbuy) { ?>
        <li class="<?php echo $output['current'];?>">
          <div class="ncg-list-content"> <a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$groupbuy['groupbuy_id']));?>" class="pic-thumb" target="_blank"><img src="<?php echo lgthumb($groupbuy['groupbuy_pic'],'mid');?>" alt=""></a>
            <h3 class="title"><a title="<?php echo $groupbuy['groupbuy_name'];?>" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$groupbuy['groupbuy_id']));?>" target="_blank"><?php echo $groupbuy['groupbuy_name'];?></a></h3>
            <div class="item-prices"> <span class="price"><i><?php echo $lang['currency'];?></i><em><?php echo $groupbuy['groupbuy_price'];?></em></span>
              <div class="dock"> <span class="limit-num"><?php echo round(($groupbuy['groupbuy_price']/$groupbuy['original_price'])*10,2);?>&nbsp;<?php echo $lang['text_zhe'];?></span> <del class="orig-price"><i><?php echo $lang['currency'];?></i><?php echo $groupbuy['original_price'];?></del> </div>
              <span class="sold-num"> <em><?php echo $groupbuy['buyer_num'];?></em>个<?php echo $lang['text_buy'];?> </span> <a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$groupbuy['groupbuy_id']));?>" target="_blank" class="buy-button">我要抢</a> </div>
          </div>
        </li>
        <?php } ?>
      </ul>
      <?php }else{ ?>
      <div class="norecommend">暂无抢购推荐</div>
      <?php }?>
    </div>
  </div>
</div>
