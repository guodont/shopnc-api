<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){ ?>

<div class="goods-select-box">
  <div class="arrow"></div>
  <ul id="goods_search_list" class="goods-search-list">
    <?php foreach($output['goods_list'] as $value){ ?>
    <?php $goods_info = array();?>
    <?php $goods_info['url'] = getGoodsUrl($value['goods_id']);?>
    <?php $goods_info['title'] = $value['goods_name'];?>
    <?php $goods_info['image'] = thumb($value, 240);?>
    <?php $goods_info['price'] = $value['goods_store_price'];?>
    <?php $goods_info['type'] = 'store';?>
    <li nctype="btn_goods_select" goods_url="<?php echo $goods_info['url'];?>" goods_title="<?php echo $goods_info['title'];?>" goods_image="<?php echo $goods_info['image'];?>" goods_price="<?php echo $goods_info['price'];?>" goods_type="<?php echo $goods_info['type'];?>">
      <dl>
        <dt class="name"><a href="<?php echo $goods_info['url'];?>" target="_blank"> <?php echo $goods_info['title'];?> </a></dt>
        <dd class="image"><img title="<?php echo $goods_info['title'];?>" src="<?php echo $goods_info['image'];?>" /></dd>
        <dd class="price"><?php echo $lang['nc_common_price'];?><?php echo $lang['nc_colon'];?><em><?php echo $goods_info['price'];?></em></dd>
      </dl>
      <i><?php echo $lang['api_goods_add'];?></i></li>
    <?php } ?>
  </ul>
  <div class="pagination"><?php echo $output['show_page'];?></div>
</div>
<?php }else { ?>
<div class="no-record"><?php echo $lang['no_record'];?></div>
<?php } ?>
