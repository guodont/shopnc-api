<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_type_manage'];?></h3>
      <ul class="tab-base">
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_list'];?></span></a></li>
        <li><a href="index.php?act=type&op=type_add"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table id="prompt" class="table tb-type2">
    <tbody>
      <tr class="space odd">
        <th colspan="12" class="nobg"> <div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span> </div>
        </th>
      </tr>
      <tr class="odd">
        <td><ul>
            <li><?php echo $lang['type_index_prompts_one'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form id="form_spec" method="get">
    <input type="hidden" name="act" value="type" />
    <input type="hidden" name="op" value="type_del" />
    <div style="text-align: right;"><a class="btns" href="index.php?act=type&op=export_step1"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['type_index_type_name'];?></th>
          <th><?php echo $lang['type_common_belong_class'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if ( !empty($output['type_list']) && is_array($output['type_list']) ) {?>
        <?php foreach ($output['type_list'] as $val) {?>
        <tr class="hover edit">
          <td class="w24"><input type="checkbox" class="checkitem" name="del_id[]" value="<?php echo $val['type_id'];?>" /></td>
          <td class="w48 sort"><span class=" editable" title="<?php echo $lang['nc_editable'];?>" maxvalue="255" datatype="pint" fieldid="<?php echo $val['type_id'];?>" ajax_branch="sort" fieldname="type_sort" nc_type="inline_edit"><?php echo $val['type_sort'];?></span></td>
          <td class=""><?php echo $val['type_name'];?></td>
          <td class="w150 name"><?php echo $val['class_name'];?></td>
          <td class="w96 align-center"><a href="index.php?act=type&op=type_edit&t_id=<?php echo $val['type_id'];?>"><?php echo $lang['nc_edit'];?></a> | <a onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=type&op=type_del&del_id=<?php echo $val['type_id'];?>';}else{return false;}" href="javascript:void(0)"><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php }?>
        <?php }else{ ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php }?>
      </tbody>
      <?php if(!empty($output['type_list']) && is_array($output['type_list'])){ ?>
      <tfoot>
        <tr>
          <td><input type="checkbox" class="checkall" id="checkallBottom" /></td>
          <td id="dataFuncs" colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all'];?></label>&nbsp;&nbsp;
            <a class="btn" onclick="submit_form('recommend');" href="JavaScript:void(0);"> <span><?php echo $lang['nc_del'];?></span> </a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        <tr>
      </tfoot>
      <?php }?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
function submit_form(type){
	var id='';
	$('input[type=checkbox]:checked').each(function(){
		if(!isNaN($(this).val())){
			id += $(this).val();
		}
	});
	if(id == ''){
		alert('<?php echo $lang['nc_ensure_del'];?>');
		return false;
	}
	if(type=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
	}
	$('#form_spec').submit();
}
</script>