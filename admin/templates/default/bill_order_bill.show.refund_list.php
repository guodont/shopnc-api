<?php defined('InShopNC') or exit('Access Invalid!');?>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="bill" />
    <input type="hidden" name="op" value="show_bill" />
    <input type="hidden" name="ob_no" value="<?php echo $_GET['ob_no'];?>" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
        <th><label for="add_time_from">订单类型</label></th>
          <td>
			<select name="query_type" class="querySelect">
			<option value="order" <?php if($_GET['query_type'] == 'order'){?>selected<?php }?>>订单列表</option>
			<option value="refund" <?php if($_GET['query_type'] == 'refund'){?>selected<?php }?>>退单列表</option>
			<option value="cost" <?php if($_GET['query_type'] == 'cost'){?>selected<?php }?>>店铺费用</option>
			</select>
          </td>
          <th><label for="add_time_from">退款时间</label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['query_start_date'];?>" id="query_start_date" name="query_start_date">
            <label>~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['query_end_date'];?>" id="query_end_date" name="query_end_date"/></td>       
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></a>
          <a class="btns" href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>&op=export_refund_order"><span><?php echo $lang['nc_exposrt'];?>导出退单明细</span></a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
<table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center">退单编号</th>
        <th class="align-center">订单编号</th>
        <th class="align-center">退单金额</th>
        <th class="align-center">退还佣金</th>
        <th class="align-center">类型</th>
        <th class="align-center">退款日期</th>
        <th class="align-center">买家</th>
        <th><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($output['refund_list']) && !empty($output['refund_list'])){?>
      <?php foreach($output['refund_list'] as $refund_info){?>
      <tr class="hover">
        <td class="align-center"><?php echo $refund_info['refund_sn'];?></td>
        <td class="align-center"><?php echo $refund_info['order_sn'];?></td>
        <td class="align-center"><?php echo $refund_info['refund_amount'];?></td>
        <td class="align-center"><?php echo ncPriceFormat($refund_info['commis_amount']);?></td>
        <td class="align-center"><?php echo str_replace(array(1,2), array('退款 ','退货'),$refund_info['refund_type']);?></td>
        <td class="align-center"><?php echo date('Y-m-d',$refund_info['admin_time']);?></td>
        <td class="align-center"><?php echo $refund_info['buyer_name'];?></rd>
        <td>
        <?php if ($refund_info['refund_type'] == 1) {?>
        <a href="index.php?act=refund&op=view&refund_id=<?php echo $refund_info['refund_id'];?>"><?php echo $lang['nc_view'];?></a>
        <?php } else {?>
        <a href="index.php?act=return&op=view&return_id=<?php echo $refund_info['refund_id'];?>"><?php echo $lang['nc_view'];?></a>
        <?php } ?>
        </td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr class="no_data">
        <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr class="tfoot">
        <td colspan="15" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
