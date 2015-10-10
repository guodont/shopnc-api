<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>查看地区</h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>管理</span></a></li>
        <li><a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['region_index_import_tip'];?>?')){location.href='index.php?act=flea_region&op=flea_import_default_area';}"><span>导入全国地区数据[三级]</span></a></li>
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
            <li>添加，编辑或删除操作后需要点击"提交"按钮才生效</li>
          </ul></td>
      </tr>
    </tbody>
  </table> 
  <table class="tb-type1 noborder search">
    <tbody>
      <tr>
        <th><label>查看下一级地区</label></th>
        <td><select name="province" id="province" onchange="refreshdistrict($(this).val(),'province')">
			<option value="" <?php if($output['province'] == ''){ ?>selected='selected'<?php }?>>-城市-</option>
			<?php if(!empty($output['province_list']) && is_array($output['province_list'])){ ?>
			<?php foreach($output['province_list'] as $k => $v){ ?>
			<option value="<?php echo $v['flea_area_id'];?>" <?php if($output['province'] == $v['flea_area_id']){ ?>selected='selected'<?php }?>><?php echo $v['flea_area_name'];?></option>
			<?php } ?>
			<?php } ?>
		  </select>
		  <select name="city" id="city" onchange="refreshdistrict($(this).val(),'city')">
			<option value="" <?php if($output['city'] == ''){ ?>selected='selected'<?php }?>>-地区-</option>
			<?php if(!empty($output['city_list']) && is_array($output['city_list'])){ ?>
			<?php foreach($output['city_list'] as $k => $v){ ?>
			<option value="<?php echo $v['flea_area_id'];?>" <?php if($output['city'] == $v['flea_area_id']){ ?>selected='selected'<?php }?>><?php echo $v['flea_area_name'];?></option>
			<?php } ?>
			<?php } ?>
		  </select></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id='form_area_list';>
    <input type="hidden" name="form_submit" value="ok" />
    <input type='hidden' name='flea_area_parent_id' value="<?php echo $output['flea_area_parent_id']?>" />
    <input type='hidden' name='child_area_deep' value="<?php echo $output['child_area_deep']?>" />
    <input type='hidden' name='hidden_del_id' id='hidden_del_id' value='' />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="align-center">排序</th>
          <th>地区名称</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
		<?php if(!empty($output['area_list']) && is_array($output['area_list'])){ ?>
        <?php foreach($output['area_list'] as $k => $v){?>
        <tr id='area_tr_<?php echo $v['flea_area_id'];?>' class="hover edit">
        <td class="w48 sort align-center"><span id='area_sort_<?php echo $v['flea_area_id'];?>'><input name="area_sort[<?php echo $v['flea_area_id'];?>]" value="<?php echo $v['flea_area_sort'];?>" type='text'/></span></td><td class="node"><span class="node_name" id='area_name_<?php echo $v['flea_area_id'];?>'><input name="area_name[<?php echo $v['flea_area_id'];?>]" value="<?php echo $v['flea_area_name'];?>" type='text'/></span></td>
        <td class="w72 align-center"><a href="javascript:void(0)" onclick='del("<?php echo $v['flea_area_id'];?>");'><?php echo $lang['nc_del'];?></a></td>
        </tr>
        <?php } ?>
        <?php } ?>
      </tbody>
      <tbody>
        <tr>
          <td colspan="15"><a href="JavaScript:void(0);" class="btn-add marginleft" onclick='add_tr();'><span><?php echo $lang['region_index_add'];?></span></a></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" onclick="form_list_submit();"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>


function add_tr(){
	$('#treet1').append('<tr class="hover edit"><td class="w48 sort"><input type="text" name="new_area_sort[]" value="0" /></td><td class="node"><input type="text" name="new_area_name[]" value="" /></td><td></td></tr>');
}
function edit(id){
	//sort
	$('#area_sort_'+id).html("<input name='area_sort["+id+"]' value='"+$('#hidden_area_sort_'+id).val()+"' type='text'/>");
	//name
	$('#area_name_'+id).html("<input name='area_name["+id+"]' value='"+$('#hidden_area_name_'+id).val()+"' type='text'/> ");
}
function del(id){
	$('#area_tr_'+id).remove();
	$('#hidden_del_id').val($('#hidden_del_id').val()+'|'+id);
}
function refreshdistrict(parent_id,type){
	var url = '';
	if(type == 'province'){
		url += '&province='+$('#province').val();
	}
	if(type == 'city'){
		url += '&province='+$('#province').val()+'&city='+$('#city').val();
	}
	if(type == 'district'){
		url += '&province='+$('#province').val()+'&city='+$('#city').val()+'&district='+$('#district').val();
	}
	location.href='index.php?act=flea_region&op=flea_region&flea_area_parent_id='+parent_id+url;
}
function form_list_submit(){
	if($('#hidden_del_id').val()){
		if(!confirm('<?php echo $lang['region_index_del_tip'];?>?')){
			return false;
		}
	}
	$('#form_area_list').submit();
}
</script> 