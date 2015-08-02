<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <a href="javascript:void(0);" class="ncsc-btn ncsc-btn-orange" dialog_id="store_msg_info" dialog_title="兑换码验证" dialog_width="640" nc_type="dialog" uri="<?php echo urlShop('store_liveorder', 'store_liveverify');?>"><i class="icon-edit"></i>兑换码验证</a> </div>
<div class="alert alert-block mt10 mb10">
  <h4><?php echo $lang['nc_explain'].$lang['nc_colon'];?></h4>
  <ul>
    <li>1、点击“兑换码验证”，输入买家所提供的“线下抢购兑换码”并提交验证。成功的操作将被记录在“操作日志”列表，以便核对记录使用。</li>
    <li>2、如用户抢购多组兑换码，请逐一进行输入操作，一码一销，全部验证后完成该笔订单。</li>
    <li class="orange">3、买家下单后未支付时，如有特殊情况可取消订单，谨慎操作。</li>
    <!--<li>4、 如未付款订单双方都未进行操作，系统将于下单后的XXX天自动取消该笔订单并还原库存。</li>-->
  </ul>
</div>
<form method="get">
  <table class="search-form">
    <input type="hidden" id='act' name='act' value='store_liveorder' />
    <input type="hidden" id='op' name='op' value='store_liveorder' />
    <tr>
      <td>&nbsp;</td>
      <td></td>
      <th><?php echo $lang['voucher_template_enddate'];?></th>
      <td class="w240"></td>
      <th><?php echo $lang['nc_status'];?></th>
      <td class="w120"><select class="w80" name="state">
          <option value="">请选择...</option>
          <option value="1" <?php if($_GET['state']==1){ echo 'selected';}?>>待支付</option>
          <option value="2" <?php if($_GET['state']==2){ echo 'selected';}?>>已支付</option>
          <option value="3" <?php if($_GET['state']==3){ echo 'selected';}?>>已消费</option>
        </select></td>
      <th class="w60">订单编号</th>
      <td class="w160"><input type="text" class="text w150"  value="<?php if(isset($_GET['order_sn']) && !empty($_GET['order_sn'])){ echo $_GET['order_sn'];}?>" id="order_sn" name="order_sn" /></td>
      <td class="tc w70"><label class="submit-border">
          <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
        </label></td>
  </table>
</form>
<table class="ncsc-table-style order">
  <thead>
    <tr>
      <th class="w10"></th>
      <th colspan="2">线下抢购活动</th>
      <th class="w70">单价</th>
      <th class="w50">数量</th>
      <th class="w110">买家</th>
      <th class="w110">订单总额</th>
      <th class="w110">交易操作</th>
    </tr>
  </thead>
  <tbody>
    <?php if (count($output['list'])>0) { ?>
    <?php foreach($output['list'] as $val) { ?>
    <tr>
      <td class="sep-row" colspan="20"></td>
    </tr>
  
    <th colspan="20"><span class="fl ml10">线下抢单号：<span class="goods-num"><em><?php echo $val['order_sn'];?></em></span></span><span class="fl ml20">下单时间：<em class="goods-time"><?php echo date("Y-m-d H:i",$val['add_time']);?></em></span><span class="fr mr5"> <a href="index.php?act=store_liveorder&op=store_livedetail&order_id=<?php echo $val['order_id'];?>"  class="ncsc-btn-mini"><i class="icon-compass"></i>查看订单</a> </span></th>
  <tr>
    <td class="bdl"></td>
    <td class="w50"><div class="pic-thumb"><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$val['groupbuy_id']));?>" target="_blank"><img src="<?php echo lgthumb($val['groupbuy_pic'], 'small');?>"/></a></div></td>
    <td class="tl"><dl class="goods-name">
        <dt><a target="_blank" href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$val['groupbuy_id']));?>"><?php echo $val['item_name'];?></a></dt>
        <dd></dd>
      </dl></td>
    <td><?php echo $val['groupbuy_price'];?></td>
    <td><?php echo $val['number'];?></td>
    <td class="bdl"><?php echo $val['member_name'];?></td>
    <td class="bdl"><?php echo $val['price'];?></td>
    <td class="bdl bdr"><p>
        <?php 
				if($val['state']==1){
					echo '待支付';
				}elseif($val['state']==2){
					echo '已支付';
				}elseif($val['state']==3){
					echo '已消费';
				}elseif($val['state']==4){
					echo '订单关闭';	
				}
			?>
      </p>
      <p>
        <?php if($val['state']==1){?>
        <a href="javascript:void(0)" class="ncsc-btn-mini ncsc-btn-red mt5" nc_type="dialog" dialog_width="480" dialog_title="取消订单" dialog_id="buyer_order_cancel_order" uri="index.php?act=store_liveorder&op=cancel&order_id=<?php echo $val['order_id'];?>"  id="order<?php echo $val['order_id'];?>_action_cancel"><i class="icon-ban-circle"></i>取消订单</a>
        <?php }?>
      </p></td>
  </tr>
  <?php }?>
  <?php } else { ?>
  <tr>
    <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
  </tr>
  <?php } ?>
    </tbody>
  
  <tfoot>
    <?php  if (count($output['list'])>0) { ?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
