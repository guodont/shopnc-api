<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script> 
<script type="text/javascript">
$(document).ready(function(){
    $('#add_time_from').datepicker();
    $('#add_time_to').datepicker();
});
</script>
<div class="tabmenu">
    <?php include template('layout/submenu');?>
</div>
<form method="get">
  <input type="hidden" name="act" value="store_cost" />
  <input type="hidden" name="op" value="cost_list" />
  <table class="search-form">
    <tr>
      <td>&nbsp;</td>
      <th>消费内容</th>
      <td class="w160"><input type="text" class="text w150" name="cost_remark" value="<?php echo trim($_GET['cost_remark']); ?>" /></td>
      <th>时间</th>
      <td class="w240"><input name="add_time_from" id="add_time_from" type="text" class="text w70" value="<?php echo $_GET['add_time_from']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label>&nbsp;&#8211;&nbsp;<input name="add_time_to" id="add_time_to" type="text" class="text w70" value="<?php echo $_GET['add_time_to']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label></td>     
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w120">消费金额</th>
      <th class="tl">消费内容</th>
      <th class="w80">状态</th>
      <th class="w130">时间</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['cost_list']) && is_array($output['cost_list'])){?>
    <?php foreach($output['cost_list'] as $key => $value){?>
    <tr class="bd-line">
      <td><?php echo $value['cost_price'];?></td>
      <td class="tl"><?php echo $value['cost_remark'];?></td>
      <td><?php echo $value['cost_state']?'已结算':'未结算';?></td>
      <td><?php echo date('Y-m-d H:s', $value['cost_time']);?></td>
    </tr>
    <?php }?>
    <?php }else{?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
  </tfoot>
</table>
