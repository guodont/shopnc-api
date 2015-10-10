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
          <th><label for="add_time_from">成交时间</label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['query_start_date'];?>" id="query_start_date" name="query_start_date">
            <label>~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['query_end_date'];?>" id="query_end_date" name="query_end_date"/></td>       
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></a>
          <a class="btns" href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>&op=export_order"><span><?php echo $lang['nc_exposrt'];?>导出订单明细</span></a>
            </td>
        </tr>
      </tbody>
    </table>
  </form>
<table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center">订单编号</th>
        <th class="align-center">订单金额</th>
        <th class="align-center">运费</th>
        <th class="align-center">佣金</th>
        <th class="align-center">下单日期</th>
        <th class="align-center">成交日期</th>
        <th class="align-center">买家</th>
        <th><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($output['order_list']) && !empty($output['order_list'])){?>
      <?php foreach($output['order_list'] as $order_info){?>
      <tr class="hover">
        <td class="align-center"><?php echo $order_info['order_sn'];?></td>
        <td class="align-center"><?php echo $order_info['order_amount'];?></td>
        <td class="align-center"><?php echo $order_info['shipping_fee'];?></td>
        <td class="align-center"><?php echo ncPriceFormat($output['commis_list'][$order_info['order_id']]['commis_amount']);?></td>
        <td class="align-center"><?php echo date('Y-m-d',$order_info['add_time']);?></td>
        <td class="align-center"><?php echo date('Y-m-d',$order_info['finnshed_time']);?></td>
        <td class="align-center"><?php echo $order_info['buyer_name'];?></rd>
        <td>
        <a href="index.php?act=order&op=show_order&order_id=<?php echo $order_info['order_id'];?>"><?php echo $lang['nc_view'];?></a>
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
