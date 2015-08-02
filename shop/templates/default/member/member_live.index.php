<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <form method="get" action="index.php" target="_self">
    <table class="ncm-search-table">
      <input type="hidden" name="act" value="member_live" />
      <tr>
        <td>&nbsp;</td>
        <th><?php echo $lang['member_order_state'];?></th>
        <td class="w100"><select name="state">
            <option value="" ><?php echo $lang['member_order_all'];?></option>
            <option value="1" <?php if($output['state']==1){ echo 'selected';}?> >待支付</option>
            <option value="2" <?php if($output['state']==2){ echo 'selected';}?> >已支付</option>
            <option value="3" <?php if($output['state']==3){ echo 'selected';}?> >已消费</option>
          </select></td>
        <th><?php echo $lang['member_order_time'];?></th>
        <td class="w240"><input type="text" class="text w70" name="query_start_date" id="query_start_date" value="<?php echo $_GET['query_start_date']; ?>"/><label class="add-on"><i class="icon-calendar"></i></label>&nbsp;&#8211;&nbsp;<input type="text" class="text w70" name="query_end_date" id="query_end_date" value="<?php echo $_GET['query_end_date']; ?>"/><label class="add-on"><i class="icon-calendar"></i></label></td>
        <th><?php echo $lang['member_order_sn'];?></th>
        <td class="w160"><input type="text" class="text w150" name="order_sn" value="<?php echo $_GET['order_sn']; ?>"></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>"/>
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table order">
    <thead>
      <tr>
        <th class="w10"></th>
        <th colspan="2">线下抢购</th>
        <th class="w100">单价 (元)</th>
        <th class="w40">数量</th>
        <th class="w120">订单金额</th>
        <th class="w100">交易状态</th>
        <th class="w120">交易操作</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list'])){ ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr>
		<td class="sep-row" colspan="19"></td>
	  </tr>
      <tr>
        <th colspan="20"><span class="ml10">线下抢购单号：<?php echo $val['order_sn'];?></span><span>下单时间：<?php echo date("Y-m-d H:i",$val['add_time']);?></span><span><a href="<?php echo urlShop('show_store','index',array('store_id'=>$val['store_id']));?>"  target="_blank" title="<?php echo $val['store_name'];?>"><?php echo $val['store_name'];?></a></span> 
          <!-- QQ --> 

          <span member_id="<?php echo $val['store_member_id'];?>">
          <?php if(!empty($val['store_qq'])){?>
          <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $val['store_qq'];?>&site=qq&menu=yes" title="QQ: <?php echo $val['store_qq'];?>"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $val['store_qq'];?>:52" style=" vertical-align: middle;"/></a>
          <?php }?>
          
          <!-- wang wang --> 

          <?php if(!empty($val['store_ww'])){?>
          <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo $val['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>"  class="vm" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo $val['store_ww'];?>&site=cntaobao&s=2&charset=<?php echo CHARSET;?>" alt="Wang Wang"  style=" vertical-align: middle;"/></a>
          <?php }?>
          </span></th>
      </tr>
      <tr>
        <td class="bdl"></td>
        <td class="w70"><div class="ncm-goods-thumb"><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$val['groupbuy_id']));?>" target="_blank" onMouseOver="toolTip('<img src=<?php echo lgthumb($val['groupbuy_pic'], 'small');?>>')" onMouseOut="toolTip()"/><img src="<?php echo lgthumb($val['groupbuy_pic'], 'small');?>"/></a></div></td>
        <td class="tl"><dl class="goods-name">
            <dt><a href="<?php echo urlShop('show_live_groupbuy','groupbuy_detail',array('groupbuy_id'=>$val['groupbuy_id']));?>" target="_blank" title="<?php echo $val['item_name'];?>"><?php echo $val['item_name'];?></a></dt>
            <dd><span class="sale-type">有效期：<?php echo date("Y-m-d",$val['validity']);?></span></dd>
          </dl></td>
        <td><?php echo $val['groupbuy_price'];?></td>
        <td><?php echo $val['number'];?></td>
        <td class="bdl"><strong><?php echo $val['price'];?></strong></td>
        <td class="bdl"><p>
            <?php 
				if($val['state'] == 1){
					echo '<span style="color:#F30">待付款</span>';
				}elseif($val['state'] == 2){
					echo '<span style="color:#5BB75B">兑换使用</span>';
				}elseif($val['state'] == 3){
					echo '<span style="color:#AAA">使用完成</span>';
				}elseif($val['state']==4){
					echo '<span style="color:#AAA">订单取消</span>';
				}
				?>
          </p>
          <p> <a href="index.php?act=member_live&op=member_livedetail&order_id=<?php echo $val['order_id'];?>">订单详情</a></p></td>
        <td class="bdl bdr">
		  <?php if($val['state']==1){?>
          <p><a class="ncm-btn ncm-btn-orange" href="index.php?act=show_live_groupbuy&op=pay&order_sn=<?php echo $val['order_sn']; ?>"><i class="icon-shield"></i>订单支付</a></p> 		  
		  <!--取消订单-->
          <p class="mt5"><a href="javascript:void(0)" class="ncm-btn ncm-btn-red" nc_type="dialog" dialog_width="480" dialog_title="取消抢购" dialog_id="buyer_order_cancel_order" uri="index.php?act=member_live&op=cancel&order_id=<?php echo $val['order_id'];?>"  id="order<?php echo $val['order_id'];?>_action_cancel"><i class="icon-ban-circle"></i>取消抢购</a></p>
		  <?php }?>
		  </td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i></i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php  if (count($output['list'])>0) { ?>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<script charset="utf-8" type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" ></script> 
<script type="text/javascript">
$(function(){
    $('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script> 
