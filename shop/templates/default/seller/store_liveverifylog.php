<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="tabmenu">
    <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block mt10 mb10">
  <h4><?php echo $lang['nc_explain'].$lang['nc_colon'];?></h4>
  <ul>
    <li>1.商铺管理员操作日志，兑换码操作时间进行记录</li>
  </ul>
</div>
<table class="ncsc-table-style">
  <thead>
    <tr>
      <th class="w200">抢购单号</th>
      <th class="w200">抢购码</th>
      <th class="w130">操作时间</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['log']) && is_array($output['log'])){?>
    <?php foreach($output['log'] as $key => $value){?>
    <tr class="bd-line">
		<td><a href="index.php?act=store_liveorder&op=store_livedetail&order_id=<?php echo $value['order_id'];?>"><?php echo $value['order_sn'];?></a></td>
		<td><?php echo $value['order_pwd'];?></td>
		<td><?php echo date("Y-m-d H:i",$value['use_time']);?></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
	<?php  if (count($output['log'])>0) { ?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
	<?php }?>
  </tfoot>
</table>
