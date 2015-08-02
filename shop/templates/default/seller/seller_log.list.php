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
  <input type="hidden" name="act" value="seller_log" />
  <input type="hidden" name="op" value="log_list" />
  <table class="search-form">
    <tr>
      <td>&nbsp;</td><th>账号</th>
      <td class="w100"><input type="text" class="text w80" name="seller_name" value="<?php echo trim($_GET['seller_name']); ?>" /></td>
      <th>日志内容</th>
      <td class="w160"><input type="text" class="text w150" name="log_content" value="<?php echo trim($_GET['log_content']); ?>" /></td>
      <th>时间</th>
      <td class="w240"><input name="add_time_from" id="add_time_from" type="text" class="text w70" value="<?php echo $_GET['add_time_from']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label>&nbsp;&#8211;&nbsp;<input name="add_time_to" id="add_time_to" type="text" class="text w70" value="<?php echo $_GET['add_time_to']; ?>" /><label class="add-on"><i class="icon-calendar"></i></label></td>     
      <td class="w70 tc"><label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" /></label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr>
      <th class="w100">账号</th>
      <th class="tl">日志内容</th>
      <th class="w80">状态</th>
      <th class="w110">ip</th>
      <th class="w130">时间</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($output['log_list']) && is_array($output['log_list'])){?>
    <?php foreach($output['log_list'] as $key => $value){?>
    <tr class="bd-line">
      <td height="30"><?php echo $value['log_seller_name'];?></td>
      <td class="tl"><?php echo $value['log_content'];?></td>
      <td><?php echo $value['log_state']?'成功':'失败';?></td>
      <td><?php echo $value['log_seller_ip'];?></td>
      <td><?php echo date('Y-m-d H:s', $value['log_time']);?></td>
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
