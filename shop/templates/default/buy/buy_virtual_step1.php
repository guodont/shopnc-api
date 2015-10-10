<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="ncc-main">
 <div class="ncc-title">
    <h3>购买兑换码</h3>
    <h5>设置购买数量</h5>
 </div>
  <form action="<?php echo urlShop('buy_virtual','buy_step2');?>" method="POST" id="form_buy" name="form_buy">
  <input type="hidden" name="goods_id" value="<?php echo $output['goods_info']['goods_id'];?>">
    <table class="ncc-table-style" nc_type="table_cart">
      <thead>
        <tr>
          <th colspan="3">商品</th>
          <th class="w120">单价(<?php echo $lang['currency_zh'];?>)</th>
          <th class="w120">数量</th>
          <th class="w120">小计(<?php echo $lang['currency_zh'];?>)</th>
          <th class="w80">操作</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="20"><i class="icon-home"></i><a href="<?php echo urlShop('show_store','index',array('store_id'=>$output['store_info']['store_id']));?>"><?php echo $output['store_info']['store_name'];?></a> <span member_id="<?php echo $output['store_info']['member_id'];?>"></span>
          </th>
        </tr>

        <tr class="shop-list">
          <td class="w10"></td>
          <td class="w60"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$output['goods_info']['goods_id']));?>" target="_blank" class="ncc-goods-thumb"><img src="<?php echo thumb($output['goods_info'],60);?>" alt="<?php echo $output['goods_info']['goods_name']; ?>" /></a></td>
          <td class="tl"><dl class="ncc-goods-info">
              <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$output['goods_info']['goods_id']));?>" target="_blank"><?php echo $output['goods_info']['goods_name']; ?></a></dt>
              <dd>
                <?php if ($output['goods_info']['ifgroupbuy']) { ?>
                <span class="groupbuy">抢购</span>
                <?php } ?>
              最多允许购买<?php echo $output['goods_info']['virtual_limit'];?>个</dd>
            </dl></td>
          <td class="w120"><em id="item_price"><?php echo $output['goods_info']['goods_price'];?></em></td>
          <td class="w120 ws0"><a href="JavaScript:void(0);" onclick="decrease_quantity();" class="add-substract-key ">-</a>
            <input id="quantity" name="quantity" value="<?php echo $output['goods_info']['quantity'];?>" maxvalue="<?php echo $output['goods_info']['virtual_limit'];?>" price="<?php echo $output['goods_info']['goods_price'];?>" onkeyup="change_quantity(this);" type="text" class="text w20"/>
            <a href="JavaScript:void(0);" title="最多允许购买<?php echo $output['goods_info']['virtual_limit'];?>个" onclick="add_quantity();" class="add-substract-key tip" >+</a></td>
          <td class="w120"><em id="item_subtotal"><?php echo $output['goods_info']['goods_total'];?></em></td>
          <td class="w80">
            <a href="javascript:void(0)" onclick="collect_goods('<?php echo $output['goods_info']['goods_id']; ?>');">收藏</a>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20"><div class="ncc-all-account">商品总价￥<em id="cartTotal"><?php echo $output['goods_info']['goods_total']; ?></em>元</div></td>
        </tr>
      </tfoot>
    </table>
  </form>
  <div class="ncc-bottom"><a id="next_submit" href="javascript:void(0)" class="ncc-btn ncc-btn-acidblue fr">下一步</a></div>

</div>
<script>
$(document).ready(function(){
	$('#next_submit').on('click',function(){
		$('#form_buy').submit();
	});
});
</script>
