<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['refund_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '待处理';?></span></a></li>
        <li><a href="index.php?act=refund&op=refund_all"><span><?php echo '所有记录';?></span></a></li>
        <li><a href="index.php?act=refund&op=reason"><span><?php echo '退款退货原因';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="refund" />
    <input type="hidden" name="op" value="refund_manage" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th><select name="type">
            <option value="order_sn" <?php if($_GET['type'] == 'order_sn'){?>selected<?php }?>><?php echo $lang['refund_order_ordersn']; ?></option>
            <option value="refund_sn" <?php if($_GET['type'] == 'refund_sn'){?>selected<?php }?>><?php echo $lang['refund_order_refundsn']; ?></option>
            <option value="store_name" <?php if($_GET['type'] == 'store_name'){?>selected<?php }?>><?php echo $lang['refund_store_name']; ?></option>
            <option value="goods_name" <?php if($_GET['type'] == 'goods_name'){?>selected<?php }?>><?php echo '商品名称'; ?></option>
            <option value="buyer_name" <?php if($_GET['type'] == 'buyer_name'){?>selected<?php }?>><?php echo $lang['refund_order_buyer']; ?></option>
          </select></th>
        <td><input type="text" class="text" name="key" value="<?php echo trim($_GET['key']); ?>" /></td>
          <th><label for="add_time_from"><?php echo '申请时间';?></label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['add_time_from'];?>" id="add_time_from" name="add_time_from">
            <label for="add_time_to">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['add_time_to'];?>" id="add_time_to" name="add_time_to"/></td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li>买家提交申请，商家同意并经平台确认后，退款金额以预存款的形式返还给买家（充值卡部分只能退回到充值卡余额）。</li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th><?php echo $lang['refund_order_ordersn'];?></th>
        <th><?php echo $lang['refund_order_refundsn'];?></th>
        <th><?php echo $lang['refund_store_name'];?></th>
        <th>商品名称</th>
        <th><?php echo $lang['refund_order_buyer'];?></th>
        <th class="align-center"><?php echo $lang['refund_buyer_add_time'];?></th>
        <th class="align-center">商家审核时间</th>
        <th class="align-center"><?php echo $lang['refund_order_refund'];?></th>
        <th class="align-center"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
      <?php foreach ($output['refund_list'] as $key => $val) { ?>
      <tr class="bd-line" >
        <td><?php echo $val['order_sn'];?></td>
        <td><?php echo $val['refund_sn'];?></td>
        <td><?php echo $val['store_name']; ?></td>
        <td><?php echo $val['goods_name']; ?></td>
        <td><?php echo $val['buyer_name']; ?></td>
        <td class="align-center"><?php echo date('Y-m-d H:i:s',$val['add_time']);?></td>
        <td class="align-center"><?php echo date('Y-m-d H:i:s',$val['seller_time']); ?></td>
        <td class="align-center"><?php echo $val['refund_amount'];?></td>
        <td class="align-center"><a href="index.php?act=refund&op=edit&refund_id=<?php echo $val['refund_id']; ?>"> 确认 </a></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php } else { ?>
    <tbody>
      <tr class="no_data">
        <td colspan="20"><?php echo $lang['no_record'];?></td>
      </tr>
    </tbody>
    <?php } ?>
      <?php if (is_array($output['refund_list']) && !empty($output['refund_list'])) { ?>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('#formSearch').submit();
    });
});
</script>
