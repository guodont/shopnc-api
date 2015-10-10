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
            </td>
        </tr>
      </tbody>
    </table>
  </form>
<table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center">店铺</th>
        <th class="align-center">促销名称</th>
        <th class="align-center">促销费用</th>
        <th class="align-center">申请日期</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($output['cost_list']) && !empty($output['cost_list'])){?>
      <?php foreach($output['cost_list'] as $cost_info){?>
      <tr class="hover">
        <td class="align-center"><?php echo $output['store_info']['store_name'];?></td>
        <td class="align-center"><?php echo $cost_info['cost_remark'];?></td>
        <td class="align-center"><?php echo ncPriceFormat($cost_info['cost_price']);?></td>
        <td class="align-center"><?php echo date('Y-m-d',$cost_info['cost_time']);?></td>
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