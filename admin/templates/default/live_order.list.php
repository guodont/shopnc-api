<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript">
function submit_delete_batch(){
    /* 获取选中的项 */
    var items = '';
    $('.checkitem:checked').each(function(){
        items += this.value + ',';
    });
    if(items != '') {
        items = items.substr(0, (items.length - 1));
        submit_delete(items);
    }  
    else {
        alert('<?php echo $lang['nc_please_select_item'];?>');
    }
}
function submit_delete(id){
    if(confirm('<?php echo $lang['nc_ensure_del'];?>')) {
        $('#list_form').attr('method','post');
        $('#list_form').attr('action','index.php?act=live_order&op=del_order');
        $('#order_id').val(id);
        $('#list_form').submit();
    }
}
</script>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>线下抢订单</h3>
      <ul class="tab-base">
        <li><a href="javascript:void(0);" class="current"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>

  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="live_order" />
    <input type="hidden" name="op" value="index" />
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
         <th><label>订单号</label></th>
         <td><input class="txt2" type="text" name="order_sn" value="<?php echo $_GET['order_sn'];?>" /></td>
         <th>店铺</th>
         <td><input class="txt-short" type="text" name="store_name" value="<?php echo $_GET['store_name'];?>" /></td>
         <th><label>订单状态</label></th>
          <td colspan="4">
			<select name="state" class="querySelect">
              <option value=""><?php echo $lang['nc_please_choose'];?></option>
              <option value="1"<?php if($_GET['state'] == '1'){?>selected<?php }?>>待付款</option>
              <option value="2"<?php if($_GET['state'] == '2'){?>selected<?php }?>>兑换使用</option>
              <option value="3"<?php if($_GET['state'] == '3'){?>selected<?php }?>>使用完成</option>
              <option value="4"<?php if($_GET['state'] == '4'){?>selected<?php }?>>取消订单</option>
            </select></td>
        
        </tr>
        <tr>
          <th><label for="query_start_time">下单时间</label></th>
          <td><input class="txt date" type="text" value="<?php echo $_GET['query_start_time'];?>" id="query_start_time" name="query_start_time">
            <label for="query_start_time">~</label>
            <input class="txt date" type="text" value="<?php echo $_GET['query_end_time'];?>" id="query_end_time" name="query_end_time"/></td>
         <th>买家</th>
         <td><input class="txt-short" type="text" name="member_name" value="<?php echo $_GET['member_name'];?>" /></td> <th>付款方式</th>
         <td>
            <select name="payment_code" class="w100">
            <option value=""><?php echo $lang['nc_please_choose'];?></option>
            <?php foreach($output['payment_list'] as $val) { ?>
			<?php if($val['payment_code']=='offline') continue;?>
            <option value="<?php echo $val['payment_code']; ?>"><?php echo $val['payment_name']; ?></option>
            <?php } ?>
            </select>
         </td>
          <td><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a>
            
            </td>
        </tr>
      </tbody>
    </table>
  </form>
  <!-- 操作说明 -->
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg">
	        <div class="title">
	            <h5><?php echo $lang['nc_prompts'];?></h5>
	            <span class="arrow"></span>
	        </div>
        </th>
      </tr>
      <tr>
        <td>
		  <ul>
            <li>点击查看操作将显示订单的详细信息</li>
            <li>可以按照订单号、店铺、订单状态、下单时间、买家、付款方式进行查询</li>
          </ul>
		</td>
      </tr>
    </tbody>
  </table>
  <form id="list_form" method='post'>
    <input id="order_id" name="order_id" type="hidden" />
    <table class="table tb-type2">
	  <thead>
		<tr class="thead">
			<th>订单号</th>
			<th>店铺</th>
			<th>买家</th>
			<th class="align-center">下单时间</th>
			<th class="align-center">订单总额</th>
			<th class="align-center">支付方式</th>
			<th class="align-center">订单状态</th>
			<th class="align-center"><?php echo $lang['nc_handle'];?></th>
		</tr>
	  </thead>
      <tbody>
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $val){ ?>
        <tr class="hover edit">
		  <td><?php echo $val['order_sn'];?></td>
		  <td><?php echo $val['store_name'];?></td>
		  <td><?php echo $val['member_name'];?></td>
		  <td class="align-center"><?php echo date("Y-m-d",$val['add_time']);?></td>
		  <td class="align-center"><?php echo $val['price'];?></td>
		  <td class="align-center"><?php echo orderPaymentName($val['payment_code']);?></td>
		  <td class="align-center">
		  	<?php 
		  		if($val['state'] == 1){
		  			echo '待付款';
		  		}elseif($val['state'] == 2){
		  			echo '兑换使用';
		  		}elseif($val['state'] == 3){
		  			echo '使用完成';
		  		}elseif($val['state'] == 4){
					echo '取消订单';
				}
		  	?>
		  </td>
		  <td class='align-center'><a href="index.php?act=live_order&op=order_detail&order_id=<?php echo $val['order_id'];?>">查看</a></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="8"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td></td>
          <td id="batchAction" colspan="15">
            <div class="pagination"><?php echo $output['show_page'];?></div>
          </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script type="text/javascript">
$(function(){
    $('#query_start_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#query_end_time').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('index');$('#formSearch').submit();
    });
});
</script> 