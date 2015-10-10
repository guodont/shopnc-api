<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="ncm-flow-layout">
  <div class="ncm-flow-container">
    <div class="title">
      <h3><?php echo $lang['member_show_express_detail'];?></h3>
    </div>
    <div class="alert alert-block alert-info">
    
     <ul><li><strong><?php echo $lang['member_show_receive_info'].$lang['nc_colon'];?></strong><?php echo $output['order_info']['extend_order_common']['reciver_name']?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $output['order_info']['extend_order_common']['reciver_info']['phone'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $output['order_info']['extend_order_common']['reciver_info']['address'];?></li>
      <li><strong><?php echo $lang['member_show_expre_my_fdback'].$lang['nc_colon'];?></strong><?php echo $output['order_info']['extend_order_common']['order_message']; ?></li>
      <li><strong><?php echo $lang['member_show_deliver_info'].$lang['nc_colon'];?></strong><?php echo $output['daddress_info']['seller_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $output['daddress_info']['telphone'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $output['daddress_info']['area_info'];?>&nbsp;&nbsp;<?php echo $output['daddress_info']['address'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $output['daddress_info']['company'];?></li></ul>
    </div>
    <div class="tabmenu">
      <ul class="tab pngFix">
        <li class="active"><a><?php echo $lang['member_show_express_ship_dstatus'];?></a></li>
      </ul>
    </div>
    <ul class="express-log" id="express_list">
      <?php if($output['order_info']['extend_order_common']['shipping_time']) { ?>
      <li class="loading"><?php echo $lang['nc_common_loading'];?></li>
      <?php } ?>
    </ul>
    <div class="alert"><?php echo $lang['member_show_express_ship_tips'];?></div>
  </div>
  <div class="ncm-flow-item">
    <div class="title"><?php echo $lang['member_show_order_info'];?></div>
    <div class="item-goods">
      <?php if(is_array($output['order_info']['extend_order_goods']) and !empty($output['order_info']['extend_order_goods'])) { foreach($output['order_info']['extend_order_goods'] as $val) { ?>
      <dl>
        <dt>
          <div class="ncm-goods-thumb-mini"><a href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><img src="<?php echo thumb($val,'60'); ?>" onMouseOver="toolTip('<img src=<?php echo thumb($val,'240'); ?>>')" onMouseOut="toolTip()"/></a></div>
        </dt>
        <dd><a href="index.php?act=goods&goods_id=<?php echo $val['goods_id']; ?>" target="_blank"><?php echo $val['goods_name']; ?></a> <span class="rmb-price"><?php echo $val['goods_price']; ?>&nbsp;*&nbsp;<?php echo $val['goods_num']; ?>
        <?php if ($val['goods_type'] != 1) {?>
        <font color="#AAA">（<?php echo orderGoodsType($val['goods_type']);?>）</font>
        <?php } ?>
        </span></dd>
      </dl>
      <?php } } ?>
    </div>
    <div class="item-order">
      <dl>
        <dt>运费：</dt>
        <dd><?php echo $output['order_info']['shipping_fee'];?></dd>
      </dl>
      <dl>
        <dt>订单总额：</dt>
        <dd><strong><?php echo $lang['currency'].$output['order_info']['order_amount'];?></strong></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['member_change_order_no'].$lang['nc_colon'];?></dt>
        <dd><a href="javascript:void(0);"><?php echo $output['order_info']['order_sn']; ?></a><a href="javascript:void(0);" class="a">更多<i class="icon-angle-down"></i>
          <div class="more"> <span class="arrow"></span>
            <ul>
              <li>支付方式：<span><?php echo $output['order_info']['payment_name']; ?>
                <?php if($output['order_info']['payment_code'] != 'offline' && !in_array($output['order_info']['order_state'],array(ORDER_STATE_CANCEL,ORDER_STATE_NEW))) { ?>
                (<?php echo '付款单号'.$lang['nc_colon'];?><?php echo $output['order_info']['pay_sn']; ?>)
                <?php } ?>
                </span> </li>
              <li><?php echo $lang['member_order_time'].$lang['nc_colon'];?><span><?php echo date('Y-m-d H:i:s',$output['order_info']['add_time']);?></span></li>
              <?php if(intval($output['order_info']['payment_time'])) { ?>
              <li><?php echo $lang['member_show_order_pay_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['payment_time']); ?></span></li>
              <?php } ?>
              <?php if($output['order_info']['extend_order_common']['shipping_time']) { ?>
              <li><?php echo $lang['member_show_order_send_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?></span></li>
              <?php } ?>
              <?php if(intval($output['order_info']['finnshed_time'])) { ?>
              <li><?php echo $lang['member_show_order_finish_time'].$lang['nc_colon'];?><span><?php echo date("Y-m-d H:i:s",$output['order_info']['finnshed_time']); ?></span></li>
              <?php } ?>
            </ul>
          </div>
          </a></dd>
      </dl>
      <dl>
        <dt><?php echo $lang['member_show_express_ship_code'].$lang['nc_colon'];?></dt>
        <dd><?php echo $output['order_info']['shipping_code']; ?><a href="<?php echo $output['e_url'];?>" class="a" target="_blank"><?php echo $output['e_name'];?></a></dd>
      </dl>
      <dl class="line">
        <dt>商&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;家：</dt>
        <dd><?php echo $output['store_info']['store_name'];?><a href="javascript:void(0);" class="a">更多<i class="icon-angle-down"></i>
          <div class="more"><span class="arrow"></span>
            <ul>
              <li><?php echo $lang['member_address_location'].$lang['nc_colon'];?><span><?php echo $output['store_info']['area_info'].'&nbsp;'.$output['store_info']['store_address'];?></span></li>
              <li>联系电话：<span><?php echo $output['store_info']['store_phone'];?></span></li>
            </ul>
          </div>
          </a>
          <div><span member_id="<?php echo $output['store_info']['member_id'];?>"></span>
          <?php if (!empty($output['store_info']['store_qq'])) { ?>
          <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['store_info']['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $output['store_info']['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_info']['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
          <?php } ?>
          <?php if (!empty($output['store']['store_ww'])) { ?>
          <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_info']['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
          <?php } ?>
          </div>
        </dd>
      </dl>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script> 
<script>
$(function(){
	//Ajax提示
	$('.tip').poshytip({
		className: 'tip-yellowsimple',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'center',
		alignY: 'bottom',
		offsetX: 5,
		offsetY: 0,
		allowTipHover: false
	});
      var_send = '<?php echo date("Y-m-d H:i:s",$output['order_info']['extend_order_common']['shipping_time']); ?>&nbsp;&nbsp;<?php echo $lang['member_show_seller_has_send'];?><br/>';
	$.getJSON('index.php?act=member_order&op=get_express&e_code=<?php echo $output['e_code']?>&shipping_code=<?php echo $output['order_info']['shipping_code']?>&t=<?php echo random(7);?>',function(data){
		if(data){
			data = var_send+data.join('<br/>');
			$('#express_list').html(data).next().css('display','');
		}else{
			$('#express_list').html(var_send);
		}
	});
});
</script>