<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrapper mt10">
  <div class="ncs-main-container">
    <div class="title">
      <h4>
        <?php if(!empty($_GET['stc_id'])){echo $output['stc_name'];}elseif(!empty($_GET['inkeyword'])){echo $lang['show_store_index_include'].$_GET['inkeyword'].$lang['show_store_index_goods'];}else{ echo $lang['nc_whole_goods']; }?>
      </h4>
    </div>
    <div class="ncs-goodslist-bar">
      <ul class="ncs-array">
        <li class='<?php echo $_GET['key'] == '1'?'selected':'';?>'><a <?php if($_GET['key'] == '1'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> href="<?php echo ($_GET['key'] == '1' && $_GET['order'] == '2') ? replaceParam(array('key' => '1', 'order'=>'1')) : replaceParam(array('key' => '1', 'order' => '2'));?>"><?php echo $lang['show_store_all_new'];?></a></li>
        <li class='<?php echo $_GET['key'] == '2'?'selected':'';?>'><a <?php if($_GET['key'] == '2'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> href="<?php echo ($_GET['key'] == '2' && $_GET['order'] == '2') ? replaceParam(array('key' => '2', 'order'=>'1')) : replaceParam(array('key' => '2', 'order' => '2'));?>"><?php echo $lang['show_store_all_price'];?></a></li>
        <li class='<?php echo $_GET['key'] == '3'?'selected':'';?>'><a <?php if($_GET['key'] == '3'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> href="<?php echo ($_GET['key'] == '3' && $_GET['order'] == '2') ? replaceParam(array('key' => '3', 'order'=>'1')) : replaceParam(array('key' => '3', 'order' => '2'));?>"><?php echo $lang['show_store_all_sale'];?></a></li>
        <li class='<?php echo $_GET['key'] == '4'?'selected':'';?>'><a <?php if($_GET['key'] == '4'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> href="<?php echo ($_GET['key'] == '4' && $_GET['order'] == '2') ? replaceParam(array('key' => '4', 'order'=>'1')) : replaceParam(array('key' => '4', 'order' => '2'));?>"><?php echo $lang['show_store_all_collect'];?></a></li>
        <li class='<?php echo $_GET['key'] == '5'?'selected':'';?>'><a <?php if($_GET['key'] == '5'){?>class="<?php echo $_GET['order'] == 1 ? 'asc' : 'desc';?>"<?php }?> href="<?php echo ($_GET['key'] == '5' && $_GET['order'] == '2') ? replaceParam(array('key' => '5', 'order'=>'1')) : replaceParam(array('key' => '5', 'order' => '2'));?>"><?php echo $lang['show_store_all_click'];?></a></li>
      </ul> <div class="ncs-search">
      <form id="" name="searchShop" method="get" action="index.php" >
        <input type="hidden" name="act" value="show_store" />
        <input type="hidden" name="op" value="goods_all" />
        <input type="hidden" name="store_id" value="<?php echo $output['store_info']['store_id'];?>" />
        <input type="text" class="text w120" name="inkeyword" value="<?php echo $_GET['inkeyword'];?>" placeholder="搜索店内商品">
        <a href="javascript:document.searchShop.submit();" class="ncs-btn"><?php echo $lang['nc_search'];?></a>
      </form>
    </div>
    </div>
    <?php if(!empty($output['recommended_goods_list']) && is_array($output['recommended_goods_list'])){?>
    <div class="content ncs-all-goods-list mb15">
      <ul>
        <?php foreach($output['recommended_goods_list'] as $value){?>
        <li>
          <dl>
            <dt><a href="<?php echo urlShop('goods', 'index',array('goods_id'=>$value['goods_id']));?>" class="goods-thumb" target="_blank"><img src="<?php echo thumb($value, 240);?>" alt="<?php echo $value['goods_name'];?>" /></a>
              <ul class="goods-thumb-scroll-show">
              <?php if (is_array($value['image'])) {?>
                  <?php $i=0;foreach ($value['image'] as $val) {$i++?>
                  <li<?php if($i==1) {?> class="selected"<?php }?>><a href="javascript:void(0);"><img src="<?php echo thumb($val, 60);?>"/></a></li>
                  <?php }?>
              <?php } else {?>
                  <li class="selected"><a href="javascript:void(0)"><img src="<?php echo thumb($value, 60);?>"></a></li>
              <?php }?>
              </ul>
            </dt>
            <dd class="goods-name"><a href="<?php echo urlShop('goods', 'index', array('goods_id'=>$value['goods_id']));?>" title="<?php echo $value['goods_name'];?>" target="_blank"><?php echo $value['goods_name']?></a></dd>
            <dd class="goods-info"><span class="price"><?php echo $lang['currency'];?>
              <?php echo $value['goods_promotion_price']?>
              </span><span class="goods-sold"><?php echo $lang['nc_sell_out'];?><strong><?php echo $value['goods_salenum'];?></strong> <?php echo $lang['nc_jian'];?></span></dd>
            <?php if (C('groupbuy_allow') && $value['goods_promotion_type'] == 1) {?>
            <dd class="goods-promotion"><span>抢购商品</span></dd>
            <?php } elseif (C('promotion_allow') && $value['goods_promotion_type'] == 2)  {?>
            <dd class="goods-promotion"><span>限时折扣</span></dd>
            <?php }?>
          </dl>
        </li>
        <?php }?>
      </ul>
    </div>
    <div class="pagination"><?php echo $output['show_page']; ?></div>
    <?php }else{?>
    <div class="content ncs-all-goods-list">
    <div class="nothing">
      <p><?php echo $lang['show_store_index_no_record'];?></p>
    </div></div>
    <?php }?>
  </div>
</div>
<script>
$(function(){
    // 图片切换效果
    $('.goods-thumb-scroll-show').find('a').mouseover(function(){
        $(this).parents('li:first').addClass('selected').siblings().removeClass('selected');
        var _src = $(this).find('img').attr('src');
        _src = _src.replace('_60.', '_240.');
        $(this).parents('dt').find('.goods-thumb').find('img').attr('src', _src);
    });
});
</script>