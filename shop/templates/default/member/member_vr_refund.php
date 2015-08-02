<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <form method="get" action="index.php">
    <input type="hidden" name="act" value="member_vr_refund" />
    <input type="hidden" name="op" value="index" />
    <table class="ncm-search-table">
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['refund_buyer_add_time'];?></th>
        <td class="w240"><input name="add_time_from" id="add_time_from" type="text" class="text w70" value="<?php echo $_GET['add_time_from']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label>&nbsp;&#8211;&nbsp;<input name="add_time_to" id="add_time_to" type="text" class="text w70" value="<?php echo $_GET['add_time_to']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label></td>
        <th><select name="type">
            <option value="order_sn" <?php if($_GET['type'] == 'order_sn'){?>selected<?php }?>><?php echo $lang['refund_order_ordersn']; ?></option>
            <option value="refund_sn" <?php if($_GET['type'] == 'refund_sn'){?>selected<?php }?>><?php echo $lang['refund_order_refundsn']; ?></option>
            <option value="goods_name" <?php if($_GET['type'] == 'goods_name'){?>selected<?php }?>><?php echo '商品名称'; ?></option>
          </select></th>
        <td class="w160"><input type="text" class="text w150" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table order">
    <thead>
      <tr>
        <th class="w10"></th>
        <th colspan="2">商品</th>
        <th class="w100"><?php echo $lang['refund_order_refund'];?>（元）</th>
        <th class="w100"><?php echo $lang['refund_state'];?></th>
        <th class="w100"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
      <?php foreach ($output['refund_list'] as $key => $val) { ?>
      <tr>
        <td colspan="20" class="sep-row"></td>
      </tr>
      <tr>
        <th colspan="20"> <span class="ml10"><?php echo $lang['refund_order_refundsn'].$lang['nc_colon'];?><?php echo $val['refund_sn']; ?></span><span><?php echo $lang['refund_buyer_add_time'].$lang['nc_colon'];?><?php echo date("Y-m-d H:i:s",$val['add_time']);?></span>

          <!-- store_name -->
          <span> <a href="<?php echo urlShop('show_store','index',array('store_id'=> $val['store_id']), $output['store_list'][$val['store_id']]['store_domain']);?>" title="<?php echo $val['store_name'];?>"><?php echo $val['store_name']; ?></a></span>

          <span member_id="<?php echo $output['store_list'][$val['store_id']]['member_id'];?>">
          <!-- QQ -->
          <?php if(!empty($output['store_list'][$val['store_id']]['store_qq'])){?>
          <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $output['store_list'][$val['store_id']]['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $output['store_list'][$val['store_id']]['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $output['store_list'][$val['store_id']]['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
          <?php }?>

          <!-- wang wang -->
          <?php if(!empty($output['store_list'][$val['store_id']]['store_ww'])){?>
          <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $output['store_list'][$val['store_id']]['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $output['store_list'][$val['store_id']]['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
          <?php }?>
          </span>
          </th>
      </tr>
      <tr class="bd-line" >
        <td class="bdl"></td>
        <td class="w50"><div class="pic-thumb"><a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" target="_blank"><img src="<?php echo thumb($val,60);?>"  onMouseOver="toolTip('<img src=<?php echo thumb($val,240);?>>')" onMouseOut="toolTip()"/></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a href="<?php echo urlShop('goods','index',array('goods_id'=> $val['goods_id']));?>" target="_blank"><?php echo $val['goods_name']; ?></a></dt>
            <dd><?php echo $lang['refund_order_ordersn'].$lang['nc_colon'];?><a href="index.php?act=member_vr_order&op=show_order&order_id=<?php echo $val['order_id']; ?>" target="_blank"><?php echo $val['order_sn'];?></a></dd>
          </dl></td>
        <td><?php echo $val['refund_amount'];?></td>
        <td><?php echo $output['admin_array'][$val['admin_state']]; ?></td>
        <td class="bdr"><a href="index.php?act=member_vr_refund&op=view&refund_id=<?php echo $val['refund_id']; ?>" class="ncm-btn"><?php echo $lang['nc_view'];?> </a></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php } else { ?>
    <tbody>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
    </tbody>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<script type="text/javascript">
	$(function(){
	    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
	    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
