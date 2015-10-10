<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<form method="get" action="index.php">
  <input type="hidden" name="act" value="store_refund" />
  <input type="hidden" name="lock" value="<?php echo $_GET['lock']; ?>" />
  <table class="search-form">
    <tr>
      <td>&nbsp;</td>
      <th><?php echo $lang['refund_order_add_time'];?></th>
      <td class="w240"><input name="add_time_from" id="add_time_from" type="text" class="text w70" value="<?php echo $_GET['add_time_from']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label> &#8211; <input name="add_time_to" id="add_time_to" type="text" class="text w70" value="<?php echo $_GET['add_time_to']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label></td>
      <th class="w60">处理状态</th>
      <td class="w80"><select name="state">
          <option value="" <?php if($_GET['state'] == ''){?>selected<?php }?>>全部</option>
          <option value="1" <?php if($_GET['state'] == '1'){?>selected<?php }?>><?php echo $lang['refund_state_confirm']; ?></option>
          <option value="2" <?php if($_GET['state'] == '2'){?>selected<?php }?>><?php echo $lang['refund_state_yes']; ?></option>
          <option value="3" <?php if($_GET['state'] == '3'){?>selected<?php }?>><?php echo $lang['refund_state_no']; ?></option>
        </select></td>
      <th class="w120"><select name="type">
          <option value="order_sn" <?php if($_GET['type'] == 'order_sn'){?>selected<?php }?>><?php echo $lang['refund_order_ordersn']; ?></option>
          <option value="refund_sn" <?php if($_GET['type'] == 'refund_sn'){?>selected<?php }?>><?php echo $lang['refund_order_refundsn']; ?></option>
          <option value="buyer_name" <?php if($_GET['type'] == 'buyer_name'){?>selected<?php }?>><?php echo $lang['refund_order_buyer']; ?></option>
        </select></th>
      <td class="w160"><input type="text" class="text" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>

      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w10"></th>
      <th colspan="2">商品/订单号/退款号</th>
      <th class="w70"><?php echo $lang['refund_order_refund'];?></th>
      <th class="w90"><?php echo $lang['refund_order_buyer'];?></th>
      <th class="w120"><?php echo $lang['refund_order_add_time'];?></th>
      <th class="w80">处理状态</th>
      <th class="w80">平台确认</th>
      <th class="w90"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
    <?php foreach ($output['refund_list'] as $key => $val) { ?>
    <tr class="bd-line" >
        <td></td>
		    <?php if ($val['goods_id'] > 0) { ?>
        <td class="w50"><div class="pic-thumb">
            <a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" target="_blank">
                <img src="<?php echo thumb($val,60);?>" onMouseOver="toolTip('<img src=<?php echo thumb($val,240); ?>>')" onMouseOut="toolTip()"/></a></div></td>
        <td class="tl" title="<?php echo $val['store_name']; ?>">
		<dl class="goods-name">
		    <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" target="_blank"><?php echo $val['goods_name']; ?></a></dt>
        <dd><?php echo $lang['refund_order_ordersn'].$lang['nc_colon'];?><a href="index.php?act=store_order&op=show_order&order_id=<?php echo $val['order_id']; ?>" target="_blank"><?php echo $val['order_sn'];?></a></dd>
        <dd><?php echo $lang['refund_order_refundsn'].$lang['nc_colon'];?><?php echo $val['refund_sn']; ?></dd></dl></td>
		    <?php } else { ?>
        <td class="tl" title="<?php echo $val['store_name']; ?>" colspan="2">
		<dl class="goods-name">
		    <dt><?php echo $val['goods_name']; ?></dt>
        <dd><?php echo $lang['refund_order_ordersn'].$lang['nc_colon'];?><a href="index.php?act=store_order&op=show_order&order_id=<?php echo $val['order_id']; ?>" target="_blank"><?php echo $val['order_sn'];?></a></dd>
        <dd><?php echo $lang['refund_order_refundsn'].$lang['nc_colon'];?><?php echo $val['refund_sn']; ?></dd></dl></td>
		    <?php } ?>
        <td><?php echo $lang['currency'];?><?php echo $val['refund_amount'];?></td>
      <td><?php echo $val['buyer_name']; ?></td>
      <td><?php echo date("Y-m-d H:i:s",$val['add_time']);?></td>
      <td><?php echo $output['state_array'][$val['seller_state']]; ?></td>
      <td><?php echo $val['seller_state']==2 ? $output['admin_array'][$val['refund_state']]:'无'; ?></td>
      <td class="nscs-table-handle"><?php if ($val['seller_state'] == 1) { ?>
    	<span><a href="index.php?act=store_refund&op=edit&refund_id=<?php echo $val['refund_id']; ?>" class="btn-blue"><i class="icon-edit"></i><p>处理</p></a></span>
    	<?php } else { ?>
    	<span><a href="index.php?act=store_refund&op=view&refund_id=<?php echo $val['refund_id']; ?>" class="btn-orange"><i class="icon-eye-open"></i><p><?php echo $lang['nc_view'];?></p></a></span><?php } ?>
       </td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign">&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script>
	$(function(){
	    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
	    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
