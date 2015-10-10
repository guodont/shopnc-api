<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_member_predepositmanage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=predeposit&op=predeposit"><span><?php echo $lang['admin_predeposit_rechargelist']?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['admin_predeposit_cashmanage']; ?></span></a></li>
        <li><a href="index.php?act=predeposit&op=pd_log_list"><span><?php echo $lang['nc_member_predepositlog'];?></span></a></li>
         <li><a href="index.php?act=predeposit&op=predeposit_add"><span>调节预存款</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" action="index.php" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="predeposit">
    <input type="hidden" name="op" value="pd_cash_list">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><?php echo $lang['admin_predeposit_membername'];?></th>
          <td><input type="text" name="mname" class="txt" value='<?php echo $_GET['mname'];?>'></td>
          <th><?php echo $lang['admin_predeposit_apptime']; ?></th>
          <td colspan="2"><input type="text" id="stime" name="stime" class="txt date" value="<?php echo $_GET['stime'];?>">
            <label>~</label>
            <input type="text" id="etime" name="etime" class="txt date" value="<?php echo $_GET['etime'];?>"></td>
        </tr>
        <tr>
          <th><?php echo $lang['admin_predeposit_cash_shoukuanname'];?></th>
          <td><input type="text" name="pdc_bank_user" class="txt" value='<?php echo $_GET['pdc_bank_user'];?>'></td>
          <th><?php echo $lang['admin_predeposit_paystate']?></th>
          <td>
            <select id="paystate_search" name="paystate_search">
              <option value=""><?php echo $lang['nc_please_choose']; ?></option>
              <option value="0" <?php if($_GET['paystate_search'] == '0' ) { ?>selected="selected"<?php } ?>>未支付</option>
              <option value="1" <?php if($_GET['paystate_search'] == '1' ) { ?>selected="selected"<?php } ?>>已支付</option>
            </select>
            <a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['admin_predeposit_cash_help1'];?></li>
            <li><?php echo $lang['admin_predeposit_cash_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <div style="text-align:right;"><a class="btns" target="_blank" href="index.php?<?php echo $_SERVER['QUERY_STRING'];?>&op=export_cash_step1"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
  <table class="table tb-type2 nobdb">
    <thead>
      <tr class="thead">
        <th>&nbsp;</th>
        <th><?php echo $lang['admin_predeposit_cs_sn'];?></th>
        <th><?php echo $lang['admin_predeposit_membername'];?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_apptime'];?></th>
        <th class="align-center"><?php echo $lang['admin_predeposit_cash_price']; ?>(<?php echo $lang['currency_zh']; ?>)</th>
        <th class="align-center"><?php echo $lang['admin_predeposit_paystate']; ?></th>
        <th class="align-center"><?php echo $lang['nc_handle']; ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <?php foreach($output['list'] as $k => $v){?>
      <tr class="hover">
        <td class="w12">&nbsp;</td>
        <td><?php echo $v['pdc_sn']; ?></td>
        <td><?php echo $v['pdc_member_name']; ?></td>
        <td class="nowrap align-center"><?php echo @date('Y-m-d H:i:s',$v['pdc_add_time']);?></td>
        <td class="align-center"><?php echo $v['pdc_amount'];?></td>
        <td class="align-center"><?php echo str_replace(array('0','1'), array('未支付','已支付'), $v['pdc_payment_state']); ?></td>
        <td class="w90 align-center">
          <?php if ($v['pdc_payment_state'] == '0'){ ?>
          <a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del']; ?>')){window.location='index.php?act=predeposit&op=pd_cash_del&id=<?php echo $v['pdc_id']; ?>';}else{return false;}"><?php echo $lang['nc_del']; ?></a> 
          <?php } ?><a href="index.php?act=predeposit&op=pd_cash_view&id=<?php echo $v['pdc_id']; ?>" class="edit"><?php echo $lang['nc_view']; ?></a>
          </td>
      </tr>
      <?php } ?>
      <?php }else { ?>
      <tr class="no_data">
        <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="16" id="dataFuncs"><div class="pagination"> <?php echo $output['show_page'];?> </div></td>
      </tr>
    </tfoot>
  </table>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script language="javascript">
$(function(){
	$('#stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#etime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#ncsubmit').click(function(){
    	$('input[name="op"]').val('pd_cash_list');$('#formSearch').submit();
    });
});
</script>