<?php defined('InShopNC') or exit('Access Invalid!');?>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_pointprod'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=pointprod&op=pointprod" ><span><?php echo $lang['admin_pointprod_list_title'];?></span></a></li>
        <li><a href="index.php?act=pointprod&op=prod_add" ><span><?php echo $lang['admin_pointprod_add_title'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_pointorder_list_title'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
    <input type="hidden" name="act" value="pointorder">
    <input type="hidden" name="op" value="pointorder_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="pordersn"><?php echo $lang['admin_pointorder_ordersn']; ?></label></th>
          <td><input type="text" name="pordersn" id="pordersn" class="txt" value='<?php echo $_GET['pordersn'];?>'></td>
          <th><label for="pbuyname"><?php echo $lang['admin_pointorder_membername']; ?></label></th>
          <td><input type="text" name="pbuyname" id="pbuyname" class="txt" value='<?php echo $_GET['pbuyname'];?>'></td>
          <td>
            <select name="porderstate">
              <option value="" <?php if (!$_GET['porderstate']){echo 'selected=selected';}?>><?php echo $lang['admin_pointorder_orderstate']; ?></option>
              <?php foreach ($output['pointorderstate_arr'] as $k=>$v){ ?>
              <option value="<?php echo $k;?>" <?php if ($_GET['porderstate'] == $k){echo 'selected=selected';}?>><?php echo $v[1]; ?></option>
              <?php } ?>
            </select></td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <form method='post' id="form_order" action="index.php">
    <input type="hidden" name="act" value="pointorder">
    <input type="hidden" id="list_op" name="op" value="order_dropall">
    <table class="table tb-type2">
      <thead> <tr class="space">
          <th colspan="15"><?php echo $lang['nc_list'];?></th>
        </tr>
        <tr class="thead">
          <th>&nbsp;</th>
          <th><?php echo $lang['admin_pointorder_ordersn']; ?></th>
          <th><?php echo $lang['admin_pointorder_membername'];?></th>
          <th class="align-center"><?php echo $lang['admin_pointorder_exchangepoints']; ?></th>
          <th class="align-center"><?php echo $lang['admin_pointorder_addtime']; ?></th>
          <th class="align-center"><?php echo $lang['admin_pointorder_orderstate']; ?></th>
          <th class="align-center"><?php echo $lang['nc_handle']; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($output['order_list']) && is_array($output['order_list'])){ ?>
        <?php foreach($output['order_list'] as $k => $v){?>
        <tr class="hover">
          <td class="w12">&nbsp;</td>
          <td><?php echo $v['point_ordersn'];?></td>
          <td><?php echo $v['point_buyername'];?></td>
          <td class="align-center"><?php echo $v['point_allpoint'];?></td>
          <td class="nowarp align-center"><?php echo @date('Y-m-d H:i:s',$v['point_addtime']);?></td>
          <td class="align-center"><?php echo $v['point_orderstatetext'];?></td>
          <td class="w150 align-center">
            <a href="index.php?act=pointorder&op=order_info&order_id=<?php echo $v['point_orderid']; ?>" class="edit"><?php echo $lang['nc_view']; ?></a>
            <?php if ($v['point_orderallowship']) {//发货（已确认付款，待发货）?>
            <a href="index.php?act=pointorder&op=order_ship&id=<?php echo $v['point_orderid']; ?>"><?php echo $lang['admin_pointorder_ship_title']; ?></a>
            <?php } ?>
            <?php if ($v['point_orderalloweditship']) {//修改物流（已发货，待收货）?>
            <a href="index.php?act=pointorder&op=order_ship&id=<?php echo $v['point_orderid']; ?>"><?php echo $lang['admin_pointorder_ship_modtip']; ?></a>
            <?php } ?>
            <!-- 取消订单 -->
            <?php if ($v['point_orderallowcancel']){//取消订单（未发货） ?>
            <a href="javascript:void(0)" onclick="confirmorder('index.php?act=pointorder&op=order_cancel&id=<?php echo $v['point_orderid']; ?>','<?php echo $lang['admin_pointorder_cancel_confirmtip']; ?>');"><?php echo $lang['admin_pointorder_cancel_title']; ?></a>
            <?php } ?>
            <br>
            <!-- 删除订单 -->
            <?php if ($v['point_orderallowdelete']) {?>
            <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){window.location='index.php?act=pointorder&op=order_drop&order_id=<?php echo $v['point_orderid']; ?>';}else{return false;}"><?php echo $lang['nc_del']; ?></a>
            <?php } ?></td>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <?php if(!empty($output['order_list']) && is_array($output['order_list'])){ ?>
        <tr class="tfoot"> 
          <td colspan="16" id="dataFuncs">
            <div class="pagination"> <?php echo $output['show_page'];?> </div></td>
        </tr>
        <?php } ?>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
function confirmorder(url,msg){
	if(!confirm(msg)){
		return false;
	}else{
		window.location.href = url;
	}
}
</script>
