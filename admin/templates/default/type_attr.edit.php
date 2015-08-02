<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_type_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=type&op=type"><span><?php echo $lang['nc_list'];?></span></a></li>
        <li><a href="index.php?act=type&op=type_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['type_edit_type_attr_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="attr_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="attr_id" value="<?php echo $output['attr_info']['attr_id']?>" />
    <input type="hidden" name="type_id" value="<?php echo $output['attr_info']['type_id']?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td class="required" colspan="2"><label class="validation" for="attr_name"><?php echo $lang['type_add_attr_name'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="attr_name" id="attr_name" value="<?php echo $output['attr_info']['attr_name'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['type_attr_edit_name_desc'];?></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label class="validation" for="attr_sort"><?php echo $lang['nc_sort'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="attr_sort" id="attr_sort" value="<?php echo $output['attr_info']['attr_sort'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['type_attr_edit_sort_desc'];?></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label><?php echo $lang['type_edit_type_attr_is_show'];?></label></td>
        </tr>
        <tr class="noborder">
		  <td class="vatop rowform onoff"><label for="attr_show1" class="cb-enable <?php if($output['attr_info']['attr_show'] == '1'){?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="attr_show0" class="cb-disable <?php if($output['attr_info']['attr_show'] == '0'){?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="attr_show1" name="attr_show" <?php if($output['attr_info']['attr_show'] == '1'){?>checked="checked"<?php }?> value="1" type="radio" />
            <input id="attr_show0" name="attr_show" <?php if($output['attr_info']['attr_show'] == '0'){?>checked="checked"<?php }?> value="0" type="radio" />
          </td>
          </tr>
      </tbody>
    </table>
    <table class="table tb-type2 ">
      <thead class="thead">
        <tr class="space">
          <th colspan="15"><?php echo $lang['spec_add_spec_add'];?></th>
        </tr>
        <tr class="noborder">
          <th><?php echo $lang['nc_del'];?></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['type_add_attr_value'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="tr_model">
        <tr></tr>
        <?php if(is_array($output['attr_value_list']) && !empty($output['attr_value_list'])) {?>
        <?php foreach($output['attr_value_list'] as $val) {?>
        <tr class="hover edit">
          <input type="hidden" nc_type="submit_value" name='attr_value[<?php echo $val['attr_value_id'];?>][form_submit]' value='' />
          <td class="w48"><input type="checkbox" name="attr_del[<?php echo $val['attr_value_id'];?>]" value="<?php echo $val['attr_value_id'];?>" /></td>
          <td class="w48 sort"><input type="text" nc_type="change_default_submit_value" name="attr_value[<?php echo $val['attr_value_id'];?>][sort]" value="<?php echo $val['attr_value_sort'];?>" /></td>
          <td class="w270 name"><input type="text" nc_type="change_default_submit_value" name="attr_value[<?php echo $val['attr_value_id'];?>][name]" value="<?php echo $val['attr_value_name'];?>" /></td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['spec_edit_spec_value_null'];?></td>
        </tr>
        <?php }?>
      </tbody>
      <tbody>
        <tr>
          <td colspan="15"><a class="btn-add marginleft" id="add_type" href="JavaScript:void(0);"> <span><?php echo $lang['type_add_attr_add_one_value'];?></span> </a></td>
        </tr>
      </tbody>
    </table>
    <table class="table tb-type2">
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a id="submitBtn" class="btn" href="JavaScript:void(0);"> <span><?php echo $lang['nc_submit'];?></span> </a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
$(function(){
    var i=0;
	var tr_model = '<tr class="hover edit">'+
		'<td class="w48"></td><td class="w48 sort"><input type="text" name="attr_value[key][sort]" value="0" /></td>'+
		'<td class="w270 name"><input type="text" name="attr_value[key][name]" value="" /></td>'+
		'<td></td><td class="w150 align-center"><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo $lang['nc_del'];?></a></td>'+
	'</tr>';
	$("#add_type").click(function(){
		$('#tr_model > tr:last').after(tr_model.replace(/key/g,'s_'+i));
		<?php if(empty($output['attr_value_list'])) {?>
		$('.no_data').hide();
		<?php }?>
		$.getScript(RESOURCE_SITE_URL+"/js/admincp.js");
		i++;
	});

	//表单验证
    $('#attr_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	attr_name: {
        		required : true,
                maxlength: 10,
                minlength: 1
            },
            attr_sort: {
				required : true,
				digits	 : true
            }
        },
        messages : {
        	attr_name : {
            	required : '<?php echo $lang['type_edit_type_attr_name_no_null'];?>',
                maxlength: '<?php echo $lang['type_edit_type_attr_name_max'];?>',
                minlength: '<?php echo $lang['type_edit_type_attr_name_max'];?>'
            },
            attr_sort: {
				required : '<?php echo $lang['type_edit_type_attr_sort_no_null'];?>',
				digits   : '<?php echo $lang['type_edit_type_attr_sort_no_digits'];?>'
            }
        }
    });

    //按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
        if($("#attr_form").valid()){
        	$("#attr_form").submit();
    	}
    });

    //预览图片
    $("input[nc_type='change_default_goods_image']").live("change", function(){
		var src = getFullPath($(this)[0]);
		$(this).parent().prev().find('.low_source').attr('src',src);
	});

    $("input[nc_type='change_default_goods_image']").change(function(){
		$(this).parents('tr:first').find("input[nc_type='submit_value']").val('ok');
	});

    $("input[nc_type='change_default_submit_value']").change(function(){
    	$(this).parents('tr:first').find("input[nc_type='submit_value']").val('ok');
    });
	
});

function remove_tr(o){
	o.parents('tr:first').remove();
}
</script> 
<script type="text/javascript">
$(function(){
	$('input[nc_type="change_default_goods_image"]').live("change", function(){
		$(this).parent().find('input[class="type-file-text"]').val($(this).val());
	});
});
</script> 