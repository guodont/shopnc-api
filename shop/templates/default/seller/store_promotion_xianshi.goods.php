<?php defined('InShopNC') or exit('Access Invalid!');?>
<?php if(!empty($output['goods_list']) && is_array($output['goods_list'])){?>

<ul class="goods-list">
  <?php foreach($output['goods_list'] as $key=>$val){?>
  <li>
    <div class="goods-thumb"> <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['goods_id']));?>" target="_blank"><img src="<?php echo thumb($val, 240);?>"/></a></div>
    <dl class="goods-info">
      <dt><a href="<?php echo urlShop('goods', 'index', array('goods_id' => $val['goods_id']));?>" target="_blank"><?php echo $val['goods_name'];?></a> </dt>
      <dd>销售价格：<?php echo $lang['currency'].$val['goods_price'];?>
    </dl>
    <a nctype="btn_add_xianshi_goods" data-goods-id="<?php echo $val['goods_id'];?>" data-goods-name="<?php echo $val['goods_name'];?>" data-goods-img="<?php echo thumb($val, 240);?>" data-goods-price="<?php echo $val['goods_price'];?>" href="javascript:void(0);" class="ncsc-btn-mini">选择商品/修改折扣价</a> </li>
  <?php } ?>
</ul>
<div class="pagination"><?php echo $output['show_page']; ?></div>
<?php } else { ?>
<div><?php echo $lang['no_record'];?></div>
<?php } ?>
<div id="dialog_add_xianshi_goods" style="display:none;">
  <input id="dialog_goods_id" type="hidden">
  <input id="dialog_input_goods_price" type="hidden">
  <div class="selected-goods-info">
    <div class="goods-thumb"><img id="dialog_goods_img" src="" alt=""></div>
    <dl class="goods-info">
      <dt id="dialog_goods_name"></dt>
      <dd>销售价格：<?php echo $lang['currency']; ?><span id="dialog_goods_price"></span></dd>
      <dd>折扣价格：<input id="dialog_xianshi_price" type="text" class="text w70"><em class="add-on"><i class="icon-renminbi"></i></em>
      <p id="dialog_add_xianshi_goods_error">
          <label for="dialog_xianshi_price" class="error" ><i class='icon-exclamation-sign'></i>折扣价格不能为空，且必须小于商品价格</label></p></dd>
        
    </dl>
  </div>
  <div class="eject_con">
    <div class="bottom pt10 pb10"><a id="btn_submit" class="submit" href="javascript:void(0);">提交</a></div>
  </div>
</div>
