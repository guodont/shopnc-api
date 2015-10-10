<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="homepage-focus">
<h4>兑换码列表</h4>
<ul class="tab-menu">
<li class="<?php echo $_GET['query_type'] == 'timeout' ? '' : 'current';?>"><a href="index.php?act=vr_bill&op=show_bill&ob_no=<?php echo $_GET['ob_no'];?>&query_type=">已使用</a></li>
<li class="<?php echo $_GET['query_type'] == 'timeout' ? 'current' : '';?>"><a href="index.php?act=vr_bill&op=show_bill&ob_no=<?php echo $_GET['ob_no'];?>&query_type=timeout">已过期</a></li>
</ul>
</div>

<div style="text-align:right;">
<a class="btns" href="index.php?act=vr_bill&op=show_bill&ob_no=<?php echo $_GET['ob_no'];?>&query_type=<?php echo $_GET['query_type'];?>&op=export_order" target="_blank">
<span>导出CSV</span>
</a>
</div>

<table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th class="align-center">兑换码</th>
        <th class="align-center"><?php echo $_GET['query_type'] == 'timeout' ? '过期时间' : '消费时间';?></th>
        <th class="align-center">订单号</th>
        <th class="align-center">消费金额</th>
        <th class="align-center">佣金金额</th>
        <th class="align-center">买家</th>
        <th class="align-center">商家</th>
        <th><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($output['code_list']) && !empty($output['code_list'])){?>
      <?php foreach($output['code_list'] as $code_info){?>
      <tr class="hover">
        <td class="align-center"><?php echo $code_info['vr_code'];?></td>
        <td class="align-center">
        <?php if ($_GET['query_type'] == 'timeout') { ?>
        <?php echo date('Y-m-d H:i:s',$code_info['vr_indate']);?>
        <?php } else {?>
        <?php echo date('Y-m-d H:i:s',$code_info['vr_usetime']);?>
        <?php } ?>
        </td>
        <td class="align-center"><?php echo $output['order_list'][$code_info['order_id']]['order_sn'];?></td>
        <td class="align-center"><?php echo $code_info['pay_price'];?></td>
        <td class="align-center"><?php echo ncPriceFormat($code_info['pay_price']*$code_info['commis_rate']/100);?></td>
        <td class="align-center"><?php echo $output['order_list'][$code_info['order_id']]['buyer_name'];?></td>
        <td class="align-center"><?php echo $output['order_list'][$code_info['order_id']]['store_name'];?></td>
        <td>
        <a href="index.php?act=vr_order&op=show_order&order_id=<?php echo $code_info['order_id'];?>"><?php echo $lang['nc_view'];?></a>
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
