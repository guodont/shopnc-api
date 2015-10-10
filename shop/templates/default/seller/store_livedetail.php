<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="wrap-all ncu-order-view">
  <dl>
    <dt>订单状态<?php echo $lang['nc_colon'];?></dt>
    <dd><strong><?php if($output['order']['state']==1){ echo '未支付';}elseif($output['order']['state']==2){ echo '已支付';}elseif($output['order']['state']==3){ echo '已消费';}elseif($output['order']['state']==4){ echo '订单取消';}?></strong></dd>
    <dt>订单编号<?php echo $lang['nc_colon'];?></dt>
    <dd> <?php echo $output['order']['order_sn']; ?> </dd>
    <dt>下单时间<?php echo $lang['nc_colon'];?></dt>
    <dd><?php echo date("Y-m-d H:i:s",$output['order']['add_time']); ?></dd>
  </dl>
  <h3>订单信息</h3>
  <table class="ncsc-table-style">
    <thead>
      <tr>
        <th class="w10">&nbsp;</th>
        <th class="w70">&nbsp;</th>
        <th class="w200">抢购名称</th>
        <th class="w100">数量</th>
        <th class="w100">价格</th>
		<th class="w100">会员名称</th>
      </tr>
    </thead>
    <tbody>
      <tr class="bd-line">
		<td></td>
		<td>
			<div class="goods-pic-small"><span class="thumb size60"><i></i><a target="_blank" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['live_groupbuy']['groupbuy_id']));?>"><img src="<?php echo lgthumb($output['live_groupbuy']['groupbuy_pic'],20); ?>" /></a></span></div>		
		</td>
		<td><a target="_blank" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$output['live_groupbuy']['groupbuy_id']));?>"><?php echo $output['order']['item_name']?></a></td>
		<td><?php echo $output['order']['number']?></td>
		<td><?php echo $output['order']['price']?></td>
		<td><?php echo $output['order']['member_name']?></td>
      </tr>
    </tbody>
  </table>
  <ul class="order_detail_list">
    <li>抢购密码：</li>
	<?php if(!empty($output['order_pwd'])){?>
	<?php foreach($output['order_pwd'] as $pwd){?>
	<li>
	<?php 
		if($pwd['state']==1){
			echo substr($pwd['order_pwd'],0,4).'************'.'&nbsp;&nbsp;未使用';
		}else{
			echo $pwd['order_pwd'].'&nbsp;&nbsp;已使用,使用时间：'.date("Y-m-d H:i",$pwd['use_time']);
		}
	?>
	</li>
	<?php }?>
	<?php }?>
  </ul>
</div>