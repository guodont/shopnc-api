<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_type_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=type&op=type"><span><?php echo $lang['nc_list'];?></span></a></li>
        <li><a href="index.php?act=type&op=type_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="type_form" method="post">
    <table id="prompt" class="table tb-type2">
      <tbody>
        <tr class="space odd">
          <th colspan="12"> <div class="title">
              <h5><?php echo $lang['nc_prompts'];?></h5>
              <span class="arrow"></span> </div>
          </th>
        </tr>
        <tr class="odd">
          <td><ul>
              <li><?php echo $lang['type_add_prompts_one'];?></li>
              <li><?php echo $lang['type_add_prompts_two'];?></li>
              <li><?php echo $lang['type_add_prompts_three'];?></li>
              <li><?php echo $lang['type_add_prompts_four'];?></li>
            </ul></td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="t_id" value="<?php echo $output['type_info']['type_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td class="required" colspan="2"><label class="validation" for="t_mane"><?php echo $lang['type_index_type_name'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="t_mane" id="t_mane" value="<?php echo $output['type_info']['type_name'];?>" /></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label class="" for="s_sort"><?php echo $lang['type_common_belong_class'].$lang['nc_colon'];;?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform" id="gcategory">
            <input type="hidden" value="<?php echo $output['type_info']['class_id'];?>" class="mls_id" name="class_id" />
            <input type="hidden" value="<?php echo $output['type_info']['class_name'];?>" class="mls_name" name="class_name" />
            <span class="mr10"><?php echo $output['type_info']['class_name'];?></span>
            <?php if (!empty($output['type_info']['class_id'])) {?>
            <input class="edit_gcategory" type="button" value="<?php echo $lang['nc_edit'];?>">
            <?php }?>
            <select <?php if (!empty($output['type_info']['class_id'])) {?>style="display:none;"<?php }?> class="class-select">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['gc_list'])){ ?>
              <?php foreach($output['gc_list'] as $k => $v){ ?>
              <?php if ($v['gc_parent_id'] == 0) {?>
              <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"><?php echo $lang['type_common_belong_class_tips'];?></td>
        </tr>
        <tr>
          <td class="required" colspan="2"><label class="validation" for="t_sort"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="t_sort" id="t_sort" value="<?php echo $output['type_info']['type_sort'];?>" /></td>
          <td class="vatop tips"><?php echo $lang['type_add_sort_desc'];?></td>
        </tr>
      </tbody>
    </table>
    <div style="width: 49%; float: left; margin: 10px 0; border: solid #DEEFFB; border-width: 0 0 1px 0;">
      <table class="table tb-type2">
        <thead class="thead">
          <tr class="space">
            <th class="required" colspan="15"><label style=" float: left; margin-right: 10px;"><?php echo $lang['type_add_related_spec'].$lang['nc_colon'];?></label>
              <input type="hidden" name="spec_checkbox" id="spec_checkbox" value="" />
              <div id="speccategory" style=" float: left;">
                <select>
                  <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
                  <?php if(!empty($output['gc_list'])){ ?>
                  <?php foreach($output['gc_list'] as $k => $v){ ?>
                  <?php if ($v['gc_parent_id'] == 0) {?>
                  <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div><?php echo $lang['nc_quickly_targeted'];?>
            </th>
          </tr>
          <tr>
            <th style="text-align: right;" colspan="15"><a class="btns" nctype="spec_hide" href="javascript:void(0);"><span><?php echo $lang['type_common_checked_hide'];?></span></a></th>
          </tr>
        </thead>
      </table>
      <div style="position:relative; max-height:240px; overflow: hidden;" id="spec_div">
        <table class="table tb-type2" id="spec_table">
          <input type="hidden" value="" name="spec[form_submit]" nc_type="submit_value" />
          <?php if(is_array($output['spec_list'])){?>
          <tbody>
            <?php foreach($output['spec_list'] as $k=>$val){?>
            <tr class="hover edit">
              <td colspan="15"><h6 class="clear" id="spec_h6_<?php echo $k;?>"><?php echo $val['name'];?></h6>
              <?php if(is_array($val['spec'])){?>
              <ul class="nofloat">
              <?php foreach($val['spec'] as $v){?>
                <li class="left w33pre h36">
                  <input class="checkitem" nc_type="change_default_spec_value" type="checkbox" <?php if(in_array($v['sp_id'], $output['spec_related'])){ echo 'checked="checked"';}?> value="<?php echo $v['sp_id'];?>" name="spec_id[]">
                  <?php echo $v['sp_name'] . $v['sp_value'];?>
                </li>
              <?php }?>
              </ul>
              <?php }?>
              </td></tr>
            <?php }?>
          </tbody>
          <?php }else{?>
          <tbody>
            <tr>
              <td class="tips" colspan="15"><?php echo $lang['type_add_spec_null_one'];?><a href="JavaScript:void(0);" onclick="window.parent.openItem('spec,spec,goods')"><?php echo $lang['nc_spec_manage'];?></a><?php echo $lang['type_add_spec_null_two']?></td>
            </tr>
          </tbody>
          <?php }?>
        </table>
      </div>
    </div>
    <div style="width: 49%; float: right; margin: 10px 0; border: solid #DEEFFB; border-width: 0 0 1px 0;">
      <table class="table tb-type2">
        <thead class="thead">
          <tr class="space">
            <th colspan="15"> <label for="member_name" style=" float: left; margin-right: 10px;"><?php echo $lang['type_add_related_brand'].$lang['nc_colon'];?></label>
              <div id="brandcategory" style=" float: left;">
                <select class="class-select">
                  <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
                  <?php if(!empty($output['gc_list'])){ ?>
                  <?php foreach($output['gc_list'] as $k => $v){ ?>
                  <?php if ($v['gc_parent_id'] == 0) {?>
                  <option value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div><?php echo $lang['nc_quickly_targeted'];?>
            </th>
          </tr>
          <tr>
            <th style="text-align: right;" colspan="15"><a class="btns" nctype="brand_hide" href="javascript:void(0);"><span><?php echo $lang['type_common_checked_hide'];?></span></a></th>
          </tr>
        </thead>
      </table>
      <div style="position:relative; max-height:240px; overflow: hidden;" id="brand_div">
        <table class="table tb-type2" id="brand_table">
          <?php if(is_array($output['brand_list']) && !empty($output['brand_list'])) {?>
          <tbody>
          <input type="hidden" value="" name="brand[form_submit]" nc_type="submit_value" />
          <?php foreach ($output['brand_list'] as $k=>$val){?>
          <tr class="hover edit">
            <td><h6 class="clear" id="brand_h6_<?php echo $k;?>"><?php echo $val['name'];?></h6>
              <ul class="nofloat">
                <?php if($val['brand']) {?>
                <?php foreach ($val['brand'] as $bval){?>
                <li class="left w33pre h36">
                  <input type="checkbox" name="brand_id[]" class="brand_change_default_submit_value" value="<?php echo $bval['brand_id']?>" <?php if(in_array($bval['brand_id'], $output['brang_related'])){ echo 'checked="checked"';}?> id="brand_<?php echo $bval['brand_id'];?>" />
                  <label for="brand_<?php echo $bval['brand_id'];?>"><?php echo $bval['brand_name']?></label>
                </li>
                <?php }?>
                <?php }?>
              </ul></td>
          </tr>
          <?php }?>
          </tbody>
          <?php }else{?>
          <tbody>
            <tr>
              <td class="tips" colspan="15"><?php echo $lang['type_add_brand_null_one'];?><a href="JavaScript:void(0);" onclick="window.parent.openItem('brand,brand,goods')"><?php echo $lang['nc_brand_manage'];?></a><?php echo $lang['type_add_brand_null_two']?></td>
            </tr>
          </tbody>
          <?php }?>
        </table>
      </div>
    </div>
    <table class="table tb-type2">
      <thead class="thead">
        <tr class="space">
          <th colspan="15"><?php echo $lang['type_add_attr_add'].$lang['nc_colon'];?></th>
        </tr>
        <tr>
          <th><?php echo $lang['nc_del'];?></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><?php echo $lang['type_add_attr_name'];?></th>
          <th><?php echo $lang['type_add_attr_value'];?></th>
          <th class="align-center"><?php echo $lang['nc_display'];?></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="tr_model">
        <tr></tr>
        <?php if (is_array($output['attr_list']) && !empty($output['attr_list'])){?>
        <?php foreach ($output['attr_list'] as $aval){?>
        <tr class="hover edit">
          <input type="hidden" value="" name="at_value[<?php echo $aval['attr_id'];?>][form_submit]" nc_type="submit_value" />
          <input type="hidden" value="<?php echo $aval['attr_id'];?>" name="at_value[<?php echo $aval['attr_id'];?>][a_id]" nc_type='ajax_attr_id' />
          <td class="w48"><input type="checkbox" name="a_del[<?php echo $aval['attr_id'];?>]" value="<?php echo $aval['attr_id'];?>" /></td>
          <td class="w48 sort"><input type="text" class="change_default_submit_value" name="at_value[<?php echo $aval['attr_id'];?>][sort]" value="<?php echo $aval['attr_sort'];?>" /></td>
          <td class="w25pre name"><input type="text" class="change_default_submit_value" name="at_value[<?php echo $aval['attr_id'];?>][name]" value="<?php echo $aval['attr_name'];?>" /></td>
          <td class="w50pre name"><?php echo $aval['attr_value'];?></td>
          <td class="align-center power-onoff"><input type="checkbox" class="change_default_submit_value" <?php if($aval['attr_show'] == '1'){echo 'checked="checked"';}?> nc_type="checked_show" />
            <input type="hidden" name="at_value[<?php echo $aval['attr_id'];?>][show]" value="<?php echo $aval['attr_show'];?>" /></td>
          <td class="w60 align-center"><a href="index.php?act=type&op=attr_edit&attr_id=<?php echo $aval['attr_id'];?>"><?php echo $lang['nc_edit'];?></a></td>
        </tr>
        <?php }?>
        <?php }?>
      </tbody>
      <tbody>
        <tr>
          <td colspan="15"><a id="add_type" class="btn-add marginleft" href="JavaScript:void(0);"> <span><?php echo $lang['type_add_attr_add_one'];?></span> </a></td>
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
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script>
$(function(){
    // 编辑分类时清除分类信息
    $('.edit_gcategory').click(function(){
        $('input[name="class_id"]').val('');
        $('input[name="class_name"]').val('');
    });

    $('#spec_div').perfectScrollbar();
    $('#brand_div').perfectScrollbar();
	
	var i = 0;
	var tr_model = '<tr class="hover edit"><td></td>'+
		'<td class="w48 sort"><input type="text" name="at_value[key][sort]" value="0" /></td>'+
		'<td class="w25pre name"><input type="text" name="at_value[key][name]" value="" /></td>'+
		'<td class="w50pre name"><textarea rows="10" cols="80" name="at_value[key][value]"></textarea></td>'+
		'<td class="align-center power-onoff"><input type="checkbox" checked="checked" nc_type="checked_show" /><input type="hidden" name="at_value[key][show]" value="1" /></td>'+
		'<td class="w60 align-center"><a onclick="remove_tr($(this));" href="JavaScript:void(0);"><?php echo $lang['nc_del'];?></a></td>'+
	'</tr>';
	$("#add_type").click(function(){
		$('#tr_model > tr:last').after(tr_model.replace(/key/g, 's_' + i));
		$.getScript(RESOURCE_SITE_URL+"/js/admincp.js");
		i++;
	});

	$('input[nc_type="checked_show"]').live('click', function(){
		var o = $(this).next();
		//alert(o.val());
		if(o.val() == '1'){
			o.val('0');
		}else if(o.val() == '0'){
			o.val('1');
		}
	});


	//表单验证
    $('#type_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	t_mane: {
        		required : true,
                maxlength: 20,
                minlength: 1
            },
            t_sort: {
				required : true,
				digits	 : true
            }
        },
        messages : {
        	t_mane : {
        		required : '<?php echo $lang['type_add_name_no_null'];?>',
        		maxlength: '<?php echo $lang['type_add_name_max'];?>',
        		minlength: '<?php echo $lang['type_add_name_max'];?>' 
            },
            t_sort: {
            	required : '<?php echo $lang['type_add_sort_no_null'];?>',
            	digits : '<?php echo $lang['type_add_sort_no_digits'];?>' 
            }
        }
    });

    //按钮先执行验证再提交表单
    $("#submitBtn").click(function(){
    	spec_check();
        if($("#type_form").valid()){
        	$("#type_form").submit();
    	}
    });

    $('input[nc_type="change_default_spec_value"]').click(function(){
		$(this).parents('table:first').find("input[nc_type='submit_value']").val('ok');
    });

    $('input[class="change_default_submit_value"]').change(function(){
		$(this).parents('tr:first').find("input[nc_type='submit_value']").val('ok');
    });

    $('input[class="brand_change_default_submit_value"]').change(function(){
    	$(this).parents('tbody:first').find("input[nc_type='submit_value']").val('ok');
    });

	// 所属分类
    $("#gcategory > select").live('change',function(){
    	spec_scroll($(this));
    	brand_scroll($(this));
    });

	// 规格搜索
    $("#speccategory > select").live('change',function(){
    	spec_scroll($(this));
    });
	// 品牌搜索
    $("#brandcategory > select").live('change',function(){
    	brand_scroll($(this));
    });

    // 规格隐藏未选项
    $('a[nctype="spec_hide"]').live('click',function(){
    	checked_hide('spec');
    });
	// 规格全部显示
	$('a[nctype="spec_show"]').live('click',function(){
		checked_show('spec');
	});
	// 品牌隐藏未选项
	$('a[nctype="brand_hide"]').live('click',function(){
    	checked_hide('brand');
	});
	// 品牌全部显示
	$('a[nctype="brand_show"]').live('click',function(){
		checked_show('brand');
	});
});
var specScroll = 0;
function spec_scroll(o){
	var id = o.val();
	if(!$('#spec_h6_'+id).is('h6')){
		return false;
	}
	$('#spec_div').scrollTop(-specScroll);
	var sp_top = $('#spec_h6_'+id).offset().top;
	var div_top = $('#spec_div').offset().top;
	$('#spec_div').scrollTop(sp_top-div_top);
	specScroll = sp_top-div_top;
}

var brandScroll = 0;
function brand_scroll(o){
	var id = o.val();
	if(!$('#brand_h6_'+id).is('h6')){
		return false;
	}
	$('#brand_div').scrollTop(-brandScroll);
	var sp_top = $('#brand_h6_'+id).offset().top;
	var div_top = $('#brand_div').offset().top;
	$('#brand_div').scrollTop(sp_top-div_top);
	brandScroll = sp_top-div_top;
}

//隐藏未选项
function checked_show(str) {
	$('#'+str+'_table').find('h6').show().end().find('li').show();
	$('#'+str+'_table').find('tr').show();
	$('a[nctype="'+str+'_show"]').attr('nctype',str+'_hide').children().html('<?php echo $lang['type_common_checked_hide'];?>');
    $('#'+str+'_div').perfectScrollbar('destroy').perfectScrollbar();
}

// 显示全部选项
function checked_hide(str) {
	$('#'+str+'_table').find('h6').hide();
	$('#'+str+'_table').find('input[type="checkbox"]').parents('li').hide();
	$('#'+str+'_table').find('input[type="checkbox"]:checked').parents('li').show();
	$('#'+str+'_table').find('tr').each(function(){
	    if ($(this).find('input[type="checkbox"]:checked').length == 0 ) $(this).hide();
	});
	$('a[nctype="'+str+'_hide"]').attr('nctype',str+'_show').children().html('<?php echo $lang['type_common_checked_show'];?>');
    $('#'+str+'_div').perfectScrollbar('destroy').perfectScrollbar();
}

function spec_check(){
	var id='';
	$('input[nc_type="change_default_spec_value"]:checked').each(function(){
		if(!isNaN($(this).val())){
			id += $(this).val();
		}
	});
	if(id != ''){
		$('#spec_checkbox').val('ok');
	}else{
		$('#spec_checkbox').val('');
	}
}

function remove_tr(o){
	o.parents('tr:first').remove();
}
// 所属分类
gcategoryInit('gcategory');
// 规格搜索
gcategoryInit('speccategory');
// 品牌搜索
gcategoryInit('brandcategory');

</script>
