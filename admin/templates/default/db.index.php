<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['db_index_db'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['db_index_backup'];?></span></a></li>
        <li><a href="index.php?act=db&op=db_restore" ><span><?php echo $lang['db_index_restore'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
            <li><?php echo $lang['db_index_help1'];?></li>
            <li><?php echo $lang['db_index_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="db_form">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['db_index_backup_method'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="radio" checked="checked" value="all" id="backup_all" name="backup_type">
                <label for="backup_all"><?php echo $lang['db_index_all_data'];?></label>
              </li>
              <li>
                <input type="radio" value="custom" id="backup_custom" name="backup_type">
                <label for="backup_custom"><?php echo $lang['db_index_spec_table'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tbody style="display:none;" id="tables">
        <tr>
          <td colspan="2" class="required" ><?php echo $lang['db_index_table'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><input type="checkbox" class="checkall" id="checkall">
            &nbsp;
            <label for="checkall"><?php echo $lang['nc_select_all'];?></label></td>
        </tr>
        <tr id="input">
          <td colspan="2" class="vatop rowform"><ul class="nofloat w830">
              <?php if(!empty($output['table_list']) && is_array($output['table_list'])){ ?>
              <?php foreach($output['table_list'] as $k => $v){ ?>
              <li class="left w25pre">
                <input type="checkbox" value="<?php echo $v;?>" class="checkitem" name="tables[]">
                <label><?php echo $v;?></label>
              </li>
              <?php } ?>
              <?php } ?>
            </ul></td>
        </tr>
      </tbody>
      <tbody>
      	<tr>
          <td colspan="2" class="required"><label><?php echo $lang['db_index_size'];?>(kb):</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="2048" name="file_size" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['db_index_min_size'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['db_index_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['back_dir'];?>" name="backup_name" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['db_index_name_tip'];?></td>
        </tr>
      </tbody>
      <tfoot class="tfoot">
        <tr>
          <td colspan="2">
          <a href="JavaScript:void(0);" class="btn" id="btn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(document).ready(function(){
	$('#backup_all').click(function(){
		$('#tables').css('display','none');
		$(".checkitem").attr("checked",true);
	});
	$('#backup_custom').click(function(){
		$('#tables').css('display','');
		$(".checkitem").attr("checked",false);
	});
	$('#btn').click(function(){
		if(confirm('<?php echo $lang['db_index_backup_tip'];?>?')){
			$("#db_form").submit();
		}else{
			return false;
		}
	});
});
</script>