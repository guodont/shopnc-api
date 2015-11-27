<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrapper mt10" style="min-height: 400px;">
  <table class="ncd-table">
    <thead> <tr>
        <td colspan="20"><form action="index.php" method="get">
            <input type="hidden" name="act" value="d_center">
            <?php if (!empty($output['search_name'])) {?>
            <input type="hidden" name="search_name" value="<?php echo $output['search_name'];?>">
            <?php }?>
            <input type="checkbox" style="vertical-align: middle; margin-right: 5px;" name="hidden_success" id="hidden_success" value="1" <?php if ($output['hidden_success'] == 1) {?>checked<?php }?>>隐藏已提货订单
          </form></td>
      </tr>
      <tr>
        <th width="20%">商城订单</th>
        <th width="30%">物流运单</th>
        <th width="30%">收货人信息</th>
        <th class="tc">状态</th>
        <th width="10%" class="tc">操作</th>
      </tr>
     
    </thead>
    <tbody>
      <?php if(!empty($output['dorder_list'])){ ?>
      <?php foreach($output['dorder_list'] as $k => $v){ ?>
      <tr class="hover">
        <td><dl>
            <dt>订单号：<?php echo $v['order_sn'];?></dt>
            <dd class="date"><?php echo date('Y-m-d H:i:s', $v['addtime']);?></dd>
          </dl></td>
        <td><dl>
            <dt>运单号：<?php echo $v['shipping_code'];?><span class="express">(<?php echo $v['express_name'];?>)</span></dt>
            <dd><a href="javascript:void(0);" class="link" onclick="javascript:ajax_form('get_express', '查看物流', 'index.php?act=d_center&op=get_express&e_code=<?php echo $v['express_code'];?>&shipping_code=<?php echo $v['shipping_code'];?>')">查看物流跟踪</a></dd>
            
          </dl></td>
        <td><dl>
            <dt>收件人：<?php echo $v['reciver_name'];?></dt>
            <dd class="tel"><span>手机：<?php echo $v['reciver_mobphone'];?></span><span>座机：<?php echo $v['reciver_telphone'];?></span></dd>
            
          </dl></td>
        <td class="tc"><?php echo $output['dorder_state'][$v['dlyo_state']];?></td>
        <td class="tc handle"><?php if ($v['dlyo_state'] == DELIVERY_ORDER_DEFAULT) {?>
          <a href="javascript:void(0);" class="btn" onclick="javascript:ajax_get_confirm('请确认包裹已经到站，提醒买家取件？','<?php echo DELIVERY_SITE_URL;?>/index.php?act=d_center&op=arrive_point&order_id=<?php echo $v['order_id'];?>');">到站</a>
          <?php } else if ($v['dlyo_state'] == DELIVERY_ORDER_ARRIVE) {?>
          <a href="javascript:void(0);" class="btn" onclick="javascript:ajax_form('pickup_parcel', '取货', 'index.php?act=d_center&op=pickup_parcel&order_id=<?php echo $v['order_id'];?>')">取货</a>
          <?php } else {?>
          --
          <?php }?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr>
        <td colspan="10"><div class="ncd-nodata">很抱歉，暂无任何数据</div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php if(!empty($output['dorder_list'])){ ?>
      <tr class="tfoot">
        <td colspan="16" class="tc"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script type="text/javascript">
$(function(){
    $('#hidden_success').click(function(){
        $(this).parents('form:first').submit();
    });
});
</script>