<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
.ncc-table-style tbody tr.item_disabled td {
	background: none repeat scroll 0 0 #F9F9F9;
	height: 30px;
	padding: 10px 0;
	text-align: center;
}
</style>
<div class="ncc-receipt-info">
  <div class="ncc-receipt-info-title">
    <h3>商品清单</h3>
    <?php if(!empty($output['ifcart'])){?>
    <a href="index.php?act=cart"><?php echo $lang['cart_step1_back_to_cart'];?></a>
    <?php }?>
  </div>
  <table class="ncc-table-style">
    <thead>
      <tr>
        <th class="w20"></th>
        <th></th>
        <th><?php echo $lang['cart_index_store_goods'];?></th>
        <th class="w120"><?php echo $lang['cart_index_price'].'('.$lang['currency_zh'].')';?></th>
        <th class="w120"><?php echo $lang['cart_index_amount'];?></th>
        <th class="w120"><?php echo $lang['cart_index_sum'].'('.$lang['currency_zh'].')';?></th>
      </tr>
    </thead>
    <?php foreach($output['store_cart_list'] as $store_id => $cart_list) {?>
    <tbody>
      <tr>
        <th colspan="20"><strong>店铺：<a href="<?php echo urlShop('show_store','index',array('store_id'=>$store_id));?>"><?php echo $cart_list[0]['store_name']; ?></a></strong> <span member_id="<?php echo $output['store_list'][$store_id]['member_id'];?>"></span>
          <div class="store-sale">
            <?php if (!empty($output['cancel_calc_sid_list'][$store_id])) {?>
            <em><i class="icon-gift"></i>店铺活动-免运费</em><?php echo $output['cancel_calc_sid_list'][$store_id]['desc'];?>
            <?php } ?>
            <?php if (!empty($output['store_mansong_rule_list'][$store_id])) {?>
            <em><i class="icon-gift"></i>店铺活动-满即送</em><?php echo $output['store_mansong_rule_list'][$store_id]['desc'];?>
            <?php if (is_array($output['store_premiums_list'][$store_id])) {?>
            <?php foreach ($output['store_premiums_list'][$store_id] as $goods_info) { ?>
            <a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['goods_id']));?>" target="_blank" class="ncc-store-gift" title="<?php echo $goods_info['goods_name']; ?>"><img src="<?php echo cthumb($goods_info['goods_image'],60,$store_id);?>" alt="<?php echo $goods_info['goods_name']; ?>" /></a>
            <?php } ?>
            <?php  } ?>
            <?php } ?>
          </div></th>
      </tr>
      <?php foreach($cart_list as $cart_info) {?>
      <tr id="cart_item_<?php echo $cart_info['cart_id'];?>" class="shop-list <?php echo ($cart_info['state'] && $cart_info['storage_state']) ? '' : 'item_disabled';?>">
        <td><?php if ($cart_info['state'] && $cart_info['storage_state']) {?>
          <input type="hidden" value="<?php echo $cart_info['cart_id'].'|'.$cart_info['goods_num'];?>" name="cart_id[]">
          <?php } ?></td>
        <?php if ($cart_info['bl_id'] == '0') {?>
        <td class="w60"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$cart_info['goods_id']));?>" target="_blank" class="ncc-goods-thumb"><img src="<?php echo thumb($cart_info,60);?>" alt="<?php echo $cart_info['goods_name']; ?>" /></a></td>
        <?php } ?>
        <td class="tl" <?php if ($cart_info['bl_id'] != '0') {?>colspan="2"<?php }?>><dl class="ncc-goods-info">
            <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$cart_info['goods_id']));?>" target="_blank"><?php echo $cart_info['goods_name']; ?></a></dt>
            <?php if (!empty($cart_info['xianshi_info'])) {?>
            <dd> <span class="xianshi">满<strong><?php echo $cart_info['xianshi_info']['lower_limit'];?></strong>件，单价直降<em>￥<?php echo $cart_info['xianshi_info']['down_price']; ?></em></span> </dd>
            <?php }?>
            <?php if ($cart_info['ifgroupbuy']) {?>
            <dd> <span class="groupbuy">抢购</span></dd>
            <?php }?>
            <?php if ($cart_info['bl_id'] != '0') {?>
            <dd> <span class="buldling">优惠套装，单套直降<em>￥<?php echo $cart_info['down_price']; ?></em></span></dd>
            <?php }?>
            <?php if (!empty($cart_info['gift_list'])) { ?>
            <dd><span class="ncc-goods-gift">赠</span>
              <ul class="ncc-goods-gift-list">
                <?php foreach ($cart_info['gift_list'] as $goods_info) { ?>
                <li nc_group="<?php echo $cart_info['cart_id'];?>"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['gift_goodsid']));?>" target="_blank" class="thumb" title="赠品：<?php echo $goods_info['gift_goodsname']; ?> * <?php echo $goods_info['gift_amount'] * $cart_info['goods_num']; ?>"><img src="<?php echo cthumb($goods_info['gift_goodsimage'],60,$store_id);?>" alt="<?php echo $goods_info['gift_goodsname']; ?>"/></a> </li>
                <?php } ?>
              </ul>
            </dd>
            <?php  } ?>
          </dl></td>
        <td class="w120"><em><?php echo $cart_info['goods_price']; ?></em></td>
        <td class="w60"><?php echo $cart_info['state'] ? $cart_info['goods_num'] : ''; ?></td>
        <td class="w120"><?php if ($cart_info['state'] && $cart_info['storage_state']) {?>
          <em id="item<?php echo $cart_info['cart_id']; ?>_subtotal" nc_type="eachGoodsTotal"><?php echo $cart_info['goods_total']; ?></em>
          <?php } elseif (!$cart_info['storage_state']) {?>
          <span style="color: #F00;">库存不足</span>
          <?php }elseif (!$cart_info['state']) {?>
          <span style="color: #F00;">已下架</span>
          <?php }?></td>
        <td></td>
      </tr>

      <!-- S bundling goods list -->
      <?php if (is_array($cart_info['bl_goods_list'])) {?>
      <?php foreach ($cart_info['bl_goods_list'] as $goods_info) { ?>
      <tr class="shop-list <?php echo $cart_info['state'] && $cart_info['storage_state'] ? '' : 'item_disabled';?>">
        <td></td>
        <td class="w60"><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['goods_id']));?>" target="_blank" class="ncc-goods-thumb"><img src="<?php echo cthumb($goods_info['goods_image'],60,$store_id);?>" alt="<?php echo $goods_info['goods_name']; ?>" /></a></td>
        <td class="tl"><dl class="ncc-goods-info">
            <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=>$goods_info['goods_id']));?>" target="_blank"><?php echo $goods_info['goods_name']; ?></a> </dt>
          </dl></td>
        <td><em><?php echo $goods_info['bl_goods_price'];?></em></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <?php } ?>
      <?php  } ?>
      <!-- E bundling goods list -->

      <?php } ?>
      <tr>
        <td class="w10"></td>
        <td class="tl" colspan="2">买家留言：
          <textarea  name="pay_message[<?php echo $store_id;?>]" class="ncc-msg-textarea" placeholder="选填：对本次交易的说明（建议填写已经和商家达成一致的说明）" title="选填：对本次交易的说明（建议填写已经和商家达成一致的说明）"  maxlength="150"></textarea></td>
        <td class="tl" colspan="10"><div class="ncc-form-default"> </div></td>
      </tr>
      <tr>
        <td class="tr" colspan="20"><div class="ncc-store-account">
            <dl class="freight">
              <dt>运费：</dt>
              <dd><em id="eachStoreFreight_<?php echo $store_id;?>">0.00</em><?php echo $lang['currency_zh'];?></dd>
            </dl>
            <dl>
              <dt>商品金额：</dt>
              <dd><em id="eachStoreGoodsTotal_<?php echo $store_id;?>"><?php echo $output['store_goods_total'][$store_id];?></em><?php echo $lang['currency_zh'];?></dd>
            </dl>
            <?php if (!empty($output['store_mansong_rule_list'][$store_id]['discount'])) {?>
            <dl class="mansong">
              <dt>满即送-<?php echo $output['store_mansong_rule_list'][$store_id]['desc'];?>：</dt>
              <dd><em id="eachStoreManSong_<?php echo $store_id;?>">-<?php echo $output['store_mansong_rule_list'][$store_id]['discount'];?></em><?php echo $lang['currency_zh'];?></dd>
            </dl>
            <?php } ?>

            <!-- S voucher list -->

            <?php if (!empty($output['store_voucher_list'][$store_id]) && is_array($output['store_voucher_list'][$store_id])) {?>
            <dl class="voucher">
              <dt>
                <select nctype="voucher" name="voucher[<?php echo $store_id;?>]">
                  <option value="<?php echo $voucher['voucher_t_id'];?>|<?php echo $store_id;?>|0.00">选择代金券</option>
                  <?php foreach ($output['store_voucher_list'][$store_id] as $voucher) {?>
                  <option value="<?php echo $voucher['voucher_t_id'];?>|<?php echo $store_id;?>|<?php echo $voucher['voucher_price'];?>"><?php echo $voucher['desc'];?></option>
                  <?php } ?>
                </select>：
              </dt>
              <dd><em id="eachStoreVoucher_<?php echo $store_id;?>">-0.00</em><?php echo $lang['currency_zh'];?></dd>
            </dl>
            <?php } ?>

            <!-- E voucher list -->

            <dl class="total">
              <dt>本店合计：</dt>
              <dd><em store_id="<?php echo $store_id;?>" nc_type="eachStoreTotal"></em><?php echo $lang['currency_zh'];?></dd>
            </dl>
          </div></td>
      </tr>
      <?php }?>

      <!-- S 预存款 & 充值卡 -->
      <?php if (!empty($output['available_pd_amount']) || !empty($output['available_rcb_amount'])) { ?>
      <tr id="pd_panel">
        <td class="pd-account" colspan="20"><div class="ncc-pd-account">
        <?php if (!empty($output['available_rcb_amount'])) { ?>
            <div class="mt5 mb5">
              <label>
                <input type="checkbox" class="vm mr5" value="1" name="rcb_pay">
                使用充值卡（可用金额：<em><?php echo $output['available_rcb_amount'];?></em><?php echo $lang['currency_zh'];?>）</label>
            </div>
       <?php } ?>
       <?php if (!empty($output['available_pd_amount'])) { ?>
            <div class="mt5 mb5">
              <label>
                <input type="checkbox" class="vm mr5" value="1" name="pd_pay">
                使用预存款（可用金额：<em><?php echo $output['available_pd_amount'];?></em><?php echo $lang['currency_zh'];?>）</label>
            </div>
      <?php } ?>
      <?php if (!empty($output['available_pd_amount']) && !empty($output['available_rcb_amount'])) { ?>
      <div class="mt5 mb5">如果二者同时使用，系统优先使用充值卡&nbsp;&nbsp;</div>
      <?php } ?>
            <div id="pd_password" style="display: none">支付密码：
              <input type="password" class="text w120" value="" name="password" id="pay-password" maxlength="35" autocomplete="off">
              <input type="hidden" value="" name="password_callback" id="password_callback">
              <a class="ncc-btn-mini ncc-btn-orange" id="pd_pay_submit" href="javascript:void(0)">使用</a>
              <?php if (!$output['member_paypwd']) {?>
              还未设置支付密码，<a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_security&op=auth&type=modify_paypwd" target="_blank">马上设置</a>
              <?php } ?>
            </div>
          </div></td>
      </tr>
      <?php } ?>
      <!-- E 预存款 -->

      <!-- S fcode -->
      <?php if ($output['store_cart_list'][key($output['store_cart_list'])][0]['is_fcode'] == 1) { ?>
      <tr>
        <td class="tr" colspan="20"><div class="ncc-store-account"> 该商品需要F码才能购买，请输入您的F码：
            <input type="text" class="text w120" value="" name="fcode" id="fcode" maxlength="20">
          </div></td>
      </tr>
      <?php } ?>
      <!-- E fcode -->

    </tbody>
    <tfoot>
      <tr>
        <td colspan="20"><div class="ncc-all-account">订单总金额：<em id="orderTotal"></em><?php echo $lang['currency_zh'];?></div></td>
      </tr>
    </tfoot>
  </table>
</div>
