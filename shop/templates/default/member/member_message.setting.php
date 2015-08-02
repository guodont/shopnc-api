<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <ul class="tab">
      <?php if(is_array($output['member_menu']) and !empty($output['member_menu'])) {
	foreach ($output['member_menu'] as $key => $val) {
		$classname = 'normal';
		if($val['menu_key'] == $output['menu_key']) {
			$classname = 'active';
		}
		if ($val['menu_key'] == 'message'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newcommon'].'</span>)</a></li>';
		}elseif ($val['menu_key'] == 'system'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newsystem'].'</span>)</a></li>';
		}elseif ($val['menu_key'] == 'close'){
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'(<span style="color: red;">'.$output['newpersonal'].'</span>)</a></li>';
		}else{
			echo '<li class="'.$classname.'"><a href="'.$val['menu_url'].'">'.$val['menu_name'].'</a></li>';
		}
	}
}?>
    </ul>
    <?php if ($output['isallowsend']){?>
    <a href="index.php?act=member_message&op=sendmsg" class="ncm-btn ncm-btn-orange" title="<?php echo $lang['home_message_send_message'];?>"><i class="icon-envelope-alt"></i><?php echo $lang['home_message_send_message'];?></a>
    <?php }?>
  </div>
  <div class="ncm-message-setting">
    <form method="post" action="<?php echo urlShop('member_message', 'setting');?>" id="setting_form" onsubmit="ajaxpost('setting_form', '', '', 'onerror');">
      <input type="hidden" name="form_submit" value="ok">
      <dl>
        <dt><span><i class="icon-shopping-cart"></i></span>订单交易通知</dt>
        <dd>
          <ul>
            <li>
              <input type="checkbox" name="order_payment_success" id="order_payment_success" value="1" <?php if ($output['setting_array']['order_payment_success'] || !isset($output['setting_array']['order_payment_success'])) {?>checked<?php }?> />
              <label for="order_payment_success">付款成功提示</label></li>
            <li>
              <input type="checkbox" name="order_deliver_success" id="order_deliver_success" value="1" <?php if ($output['setting_array']['order_deliver_success'] || !isset($output['setting_array']['order_deliver_success'])) {?>checked<?php }?> />
              <label for="order_deliver_success">商品出库提示</label></li>
            <li>
              <input type="checkbox" name="vr_code_will_expire" id="vr_code_will_expire" value="1" <?php if ($output['setting_array']['vr_code_will_expire'] || !isset($output['setting_array']['vr_code_will_expire'])) {?>checked<?php }?> />
              <label for="vr_code_will_expire">兑换码即将到期提醒</label></li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt><span><i class="icon-money"></i></span>余额卡券提醒</dt>
        <dd>
          <ul>
            <li>
              <input type="checkbox" name="predeposit_change" id="predeposit_change" value="1" <?php if ($output['setting_array']['predeposit_change'] || !isset($output['setting_array']['predeposit_change'])) {?>checked<?php }?> />
              <label for="predeposit_change">余额变动提醒</label></li>
            <li>
              <input type="checkbox" name="recharge_card_balance_change" id="recharge_card_balance_change" value="1" <?php if ($output['setting_array']['recharge_card_balance_change'] || !isset($output['setting_array']['recharge_card_balance_change'])) {?>checked<?php }?> />
              <label for="recharge_card_balance_change">充值卡余额变动提醒</label></li>
            <li>
              <input type="checkbox" name="voucher_use" id="voucher_use" value="1" <?php if ($output['setting_array']['voucher_use'] || !isset($output['setting_array']['voucher_use'])) {?>checked<?php }?> />
              <label for="voucher_use">代金券使用提醒</label></li>
            <li>
              <input type="checkbox" name="voucher_will_expire" id="voucher_will_expire" value="1" <?php if ($output['setting_array']['voucher_will_expire'] || !isset($output['setting_array']['voucher_will_expire'])){?>checked<?php }?> />
              <label for="voucher_will_expire">代金券即将到期提醒</label></li>
          </ul>
        </dd>
      </dl>
      <dl>
        <dt><span><i class="icon-coffee"></i></span>售后服务消息</dt>
        <dd>
          <ul>
            <li>
              <input type="checkbox" name="refund_return_notice" id="refund_return_notice" value="1" <?php if ($output['setting_array']['refund_return_notice'] || !isset($output['setting_array']['refund_return_notice'])) {?>checked<?php }?> />
              <label for="refund_return_notice">退换货消息</label></li>
            <li>
              <input type="checkbox" name="arrival_notice" id="arrival_notice" value="1" <?php if ($output['setting_array']['arrival_notice'] || !isset($output['setting_array']['arrival_notice'])) {?>checked<?php }?> />
              <label for="arrival_notice">到货通知消息</label></li>
            <li>
              <input type="checkbox" name="consult_goods_reply" id="consult_goods_reply" value="1" <?php if ($output['setting_array']['consult_goods_reply'] || !isset($output['setting_array']['consult_goods_reply'])) {?>checked<?php }?> />
              <label for="consult_goods_reply">商品咨询回复提示</label></li>
            <li>
              <input type="checkbox" name="consult_mall_reply" id="consult_mall_reply" value="1" <?php if ($output['setting_array']['consult_mall_reply'] || !isset($output['setting_array']['consult_mall_reply'])) {?>checked<?php }?> />
              <label for="consult_mall_reply">平台咨询回复提示</label></li>
          </ul>
        </dd>
      </dl>
      <div class="bottom tc">
        <label class="submit-border">
          <input id="btn_inform_submit" type="submit" class="submit" value="保存更改" />
        </label>
      </div>
    </form>
  </div>
</div>
