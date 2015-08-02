<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/home_cart.css" rel="stylesheet" type="text/css">
<style type="text/css">
.head-search-bar, .head-user-menu, .public-nav-layout, .head-app {
	display: none !important;
}
</style>
<div class="wrapper pr">
  <ul class="ncc-flow ncc-point-flow">
    <li class=""><i class="step1"></i>
      <p><?php echo $lang['pointcart_ensure_order'];?></p>
      <sub></sub>
      <div class="hr"></div>
    </li>
    <li class="current"><i class="step2"></i>
      <p><?php echo $lang['pointcart_ensure_info'];?></p>
      <sub></sub>
      <div class="hr"></div>
    </li>
    <li class=""><i class="step4"></i>
      <p><?php echo $lang['pointcart_exchange_finish'];?></p>
      <sub></sub>
      <div class="hr"></div>
    </li>
  </ul>
  <div class="ncc-main">
    <div class="ncc-title">
      <h3><?php echo $lang['pointcart_ensure_info'];?></h3>
      <h5>请仔细核对填写收货、发票等信息，以确保物流快递及时准确投递。</h5>
    </div>
    <form method="post" id="porder_form" name="porder_form" action="index.php?act=pointcart&op=step2">
      <div class="ncc-receipt-info">
        <div class="ncc-receipt-info-title">
          <h3><?php echo $lang['pointcart_step1_receiver_address'];?><a href="index.php?act=member_address&op=address" target="_blank">[管理]</a></h3>
        </div>
        <!-- 已经存在的收获地址start -->        
        <div class="ncc-candidate-items">
          <?php if (!empty($output['address_list'])){ ?>
          <?php foreach($output['address_list'] as $k=>$val){ ?>
          <ul class="receive_add address_item">
            <li style="margin-top:0px;">
              <label for="address_<?php echo $val['address_id']; ?>">
              <input id="address_<?php echo $val['address_id']; ?>" type="radio" name="address_options" value="<?php echo $val['address_id']; ?>" <?php if ($val['is_default'] == 1) echo 'checked'; ?>/>
              &nbsp;&nbsp;<?php echo $val['area_info']; ?>&nbsp;&nbsp;<?php echo $val['address']; ?>&nbsp;&nbsp; <?php echo $val['true_name']; ?><?php echo $lang['cart_step1_receiver_shou'];?>&nbsp;&nbsp;
              <?php if($val['mob_phone']) echo $val['mob_phone']; else echo $val['tel_phone']; ?>
              </label>
            </li>
          </ul>
          <?php } ?>
          <?php } else { ?>
          <div style="color:#d93600; height:25px; padding-top:3px;">暂无收货人地址，请先点击上方 “ 【管理】 ” ，新增收货地址，再进行兑换吧！</div>
          <?php }?>
        </div>
        <!-- 已经存在的收获地址end -->
      </div>

      <!-- 留言start -->
      <div class="ncc-receipt-info">
        <div class="ncc-receipt-info-title">
          <h3><?php echo $lang['pointcart_step1_chooseprod'];?></h3>
        </div>

        <!-- 已经选择礼品start -->

        <table class="ncc-table-style">
          <thead>
            <tr>
              <th class="w20"></th>
              <th class="tl" colspan="2"><?php echo $lang['pointcart_step1_goods_info'];?></th>
              <th class="w120"><?php echo $lang['pointcart_step1_goods_num'];?></th>
              <th class="w120"><?php echo $lang['pointcart_step1_goods_point'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
	  			if(is_array($output['pointprod_arr']['pointprod_list']) and count($output['pointprod_arr']['pointprod_list'])>0) {
				foreach($output['pointprod_arr']['pointprod_list'] as $val) {
			?>
            <tr class="shop-list ">
              <td></td>
              <td class="w60"><a href="<?php echo urlShop('pointprod', 'pinfo', array('id' => $val['pgoods_id']));?>" class="ncc-goods-thumb" target="_blank"><img src="<?php echo $val['pgoods_image_small']; ?>" alt="<?php echo $val['pgoods_name']; ?>"/></a></td>
              <td class="tl"><dl class="ncc-goods-info">
                  <dt><a target="_blank" href="<?php echo urlShop('pointprod', 'pinfo', array('id' => $val['pgoods_id']));?>"><?php echo $val['pgoods_name']; ?></a></dt>
                </dl></td>
              <td><?php echo $val['quantity']; ?></td>
              <td><?php echo $val['onepoints']; ?><?php echo $lang['points_unit']; ?></td>
            </tr>
            <?php } }?>
            <tr>
            <td></td>
              <td colspan="20" class="tl"><label><?php echo $lang['pointcart_step1_message'].$lang['nc_colon'];?>
                  <input type="text" class="w400 text" onclick="pcart_messageclear(this);" value="<?php echo $lang['pointcart_step1_message_advice'];?>" />
                </label></td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="20"><div class="ncc-all-account"><?php echo $lang['pointcart_cart_allpoints'].$lang['nc_colon'];?><em><?php echo $output['pointprod_arr']['pgoods_pointall']; ?></em><?php echo $lang['points_unit']; ?></div></td>
            </tr>
          </tfoot>
        </table>
        <!-- 已经选择礼品end -->

      </div>
      <div class="ncc-bottom">
        <a href="index.php?act=pointcart" class="ncc-btn"><?php echo $lang['pointcart_step1_return_list'];?></a>
        <a id="submitpointorder" href="javascript:void(0);" class="ncc-btn ncc-btn-acidblue fr"><?php echo $lang['pointcart_step1_submit'];?></a>
       </div>
    </form>
  </div>
</div>
<script type="text/javascript">
	function pcart_messageclear(tt){
		if (!tt.name)
		{
			tt.value = '';
			tt.name = 'pcart_message';
		}
	}

	$("#submitpointorder").click(function(){
		var chooseaddress = parseInt($("input[name='address_options']:checked").val());
		if(!chooseaddress || chooseaddress <= 0){
			showDialog('请选择收货人地址');
		} else {
			$('#porder_form').submit();
		}
	});
</script>
