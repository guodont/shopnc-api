<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <div class="alert"><strong><?php echo $lang['nc_explain'].$lang['nc_colon'];?></strong><?php echo $lang['store_callcenter_notes'];?>
    </li>
  </div>
  <form method="post" action="index.php?act=store_callcenter&op=save" id="callcenter_form" onsubmit="ajaxpost('callcenter_form','','','onerror')" class="ncs-message">
    <input type="hidden" name="form_submit" value="ok" />
    <dl nctype="pre">
      <dt><?php echo $lang['store_callcenter_presales_service'].$lang['nc_colon']?></dt>
      <dd>
        <div class="ncs-message-title"><span class="name"><?php echo $lang['store_callcenter_service_name'];?></span><span class="tool"><?php echo $lang['store_callcenter_service_tool'];?></span><span class="number"><?php echo $lang['store_callcenter_service_number'];?></span></div>
        <?php if(empty($output['storeinfo']['store_presales'])){?>
        <div class="ncs-message-list"><span class="name tip" title="<?php echo $lang['store_callcenter_name_title'];?>">
          <input type="text" class="text w60" value="<?php echo $lang['store_callcenter_presales'];?>1" name="pre[1][name]" maxlength="10" />
          </span><span class="tool tip" title="<?php echo $lang['store_callcenter_tool_title'];?>">
          <select name="pre[1][type]">
            <option value="0"><?php echo $lang['store_callcenter_please_choose'];?></option>
            <option value="1">QQ</option>
            <option value="2"><?php echo $lang['store_callcenter_wangwang'];?></option>
            <option value="3">站内IM</option>
          </select>
          </span><span class="number tip" title="<?php echo $lang['store_callcenter_number_title'];?>">
          <input name="pre[1][num]" type="text" class="text w180" maxlength="25" />
          </span><span class="del"><a nctype="del" href="javascript:void(0);" class="ncsc-btn"><i class="icon-trash"></i><?php echo $lang['nc_delete'];?></a></span></div>
        <?php }else{?>
        <?php foreach ($output['storeinfo']['store_presales'] as $key=>$val){?>
        <div class="ncs-message-list"><span class="name tip" title="<?php echo $lang['store_callcenter_name_title'];?>">
          <input type="text" class="text w60" value="<?php echo $val['name'];?>" name="pre[<?php echo $key;?>][name]" maxlength="10" />
          </span><span class="tool tip" title="<?php echo $lang['store_callcenter_tool_title'];?>">
          <select name="pre[<?php echo $key;?>][type]">
            <option value="1" <?php if($val['type'] == 1){?>selected="selected"<?php }?>>QQ</option>
            <option value="2" <?php if($val['type'] == 2){?>selected="selected"<?php }?>><?php echo $lang['store_callcenter_wangwang'];?></option>
            <option value="3" <?php if($val['type'] == 3){?>selected="selected"<?php }?>>站内IM</option>
          </select>
          </span><span class="number tip" title="<?php echo $lang['store_callcenter_number_title'];?>">
          <input name="pre[<?php echo $key;?>][num]" type="text" class="text w180" value="<?php echo $val['num'];?>" maxlength="25" />
          </span><span class="del"><a nctype="del" href="javascript:void(0);" class="ncsc-btn"><i class="icon-trash"></i><?php echo $lang['nc_delete'];?></a></span> </div>
        <?php }?>
        <?php }?>
        <p><span><a href="javascript:void(0);" onclick="add_service('pre');" class="ncsc-btn ncsc-btn-acidblue mt10"><i class="icon-plus"></i><?php echo $lang['store_callcenter_add_service'];?></a></span></p>
      </dd>
    </dl>
    <dl nctype="after" >
      <dt><?php echo $lang['store_callcenter_aftersales_service'].$lang['nc_colon'];?></dt>
      <dd>
        <div class="ncs-message-title"><span class="name"><?php echo $lang['store_callcenter_service_name'];?></span><span class="tool"><?php echo $lang['store_callcenter_service_tool'];?></span><span class="number"><?php echo $lang['store_callcenter_service_number'];?></span></div>
        <?php if(empty($output['storeinfo']['store_aftersales'])){?>
        <div class="ncs-message-list"><span class="name tip" title="<?php echo $lang['store_callcenter_name_title'];?>">
          <input type="text" class="text w60" value="<?php echo $lang['store_callcenter_aftersales'];?>1" name="after[1][name]" maxlength="10" />
          </span><span class="tool tip" title="<?php echo $lang['store_callcenter_tool_title'];?>">
          <select name="after[1][type]">
            <option value="0"><?php echo $lang['store_callcenter_please_choose'];?></option>
            <option value="1">QQ</option>
            <option value="2"><?php echo $lang['store_callcenter_wangwang'];?></option>
            <option value="3">站内IM</option>
          </select>
          </span><span class="number tip" title="<?php echo $lang['store_callcenter_number_title'];?>">
          <input type="text" class="text w180" name="after[1][num]" maxlength="25" />
          </span><span><a nctype="del" href="javascript:void(0);" class="ncsc-btn"><i class="icon-trash"></i><?php echo $lang['nc_delete'];?></a></span> </div>
        <?php }else{?>
        <?php foreach($output['storeinfo']['store_aftersales'] as $key=>$val){?>
        <div class="ncs-message-list"><span class="name tip" title="<?php echo $lang['store_callcenter_name_title'];?>">
          <input type="text" class="text w60" value="<?php echo $val['name'];?>" name="after[<?php echo $key;?>][name]" maxlength="10" />
          </span><span class="tool tip" title="<?php echo $lang['store_callcenter_tool_title'];?>">
          <select name="after[<?php echo $key;?>][type]">
            <option value="1" <?php if($val['type'] == 1){?>selected="selected"<?php }?>>QQ</option>
            <option value="2" <?php if($val['type'] == 2){?>selected="selected"<?php }?>><?php echo $lang['store_callcenter_wangwang'];?></option>
            <option value="3" <?php if($val['type'] == 3){?>selected="selected"<?php }?>>站内IM</option>
          </select>
          </span><span class="number tip" title="<?php echo $lang['store_callcenter_number_title'];?>">
          <input type="text" class="text w180" name="after[<?php echo $key;?>][num]" maxlength="25" value="<?php echo $val['num'];?>" />
          </span><span class="del"><a nctype="del" href="javascript:void(0);" class="ncsc-btn"><i class="icon-trash"></i><?php echo $lang['nc_delete'];?></a></span> </div>
        <?php }?>
        <?php }?>
        <p><span><a href="javascript:void(0);" onclick="add_service('after');" class="ncsc-btn ncsc-btn-acidblue mt10"><i class="icon-plus"></i><?php echo $lang['store_callcenter_add_service'];?></a></span></p>
      </dd>
    </dl>
    <dl >
      <dt><em class="pngFix"><?php echo $lang['store_callcenter_working_time'].$lang['nc_colon'];?></em></dt>
      <dd>
        <div class="ncs-message-title"><span><?php echo $lang['store_callcenter_working_time_title'];?></span></div>
        <div>
          <textarea name="working_time" class="textarea w500 h50"><?php echo $output['storeinfo']['store_workingtime'];?></textarea>
        </div>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['nc_common_button_submit'];?>" /></label>
    </div>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<script>
    var seller_option = '';
    <?php if (is_array($output['seller_list']) && !empty($output['seller_list'])) { ?>
    <?php foreach ($output['seller_list'] as $key => $val) { ?>
        seller_option += '<option value="<?php echo $val['member_id'];?>"><?php echo $val['seller_name'];?></option>';
    <?php } ?>
    <?php } ?>
	$('#callcenter_form').find('.tool select').live('change', function(){
		var obj = $(this).parent().parent();
		var input_obj = obj.find(".number input");
		var input_name = input_obj.attr("name");
		var input_val = input_obj.val();
		var select_val = $(this).val();
		if ( select_val == 3 ) {//选择站内IM时出现下拉列表并隐藏文本框
		    obj.find(".number").html('<input type="hidden" name="'+input_name+'" value="'+input_val+'" /><select name="'+
	                input_name+'">'+seller_option+'</select>');
		    obj.find(".number select").val(input_val);
		} else {
		    obj.find(".number").html('<input class="text w180" type="text" name="'+input_name+'" value="'+input_val+'" />');
		}
	});
	$('#callcenter_form').find('.tool select').trigger("change");//初始化已有数据
$(function(){
	$('#callcenter_form').find('a[nctype="del"]').live('click', function(){
		$(this).parents('div:first').remove();
	});
	titleTip();
});
function add_service(param){
	if(param == 'pre'){
		var text = '<?php echo $lang['store_callcenter_presales'];?>';
	}else if(param == 'after'){
		var text = '<?php echo $lang['store_callcenter_aftersales'];?>';
	}
	obj = $('dl[nctype="'+param+'"]').children('dd').find('p');
	len = $('dl[nctype="'+param+'"]').children('dd').find('div').length;
	key = 'k'+len+Math.floor(Math.random()*100);
	var add_html = '';
	add_html += '<div class="ncs-message-list">';
	add_html += '<span class="name tip" title="<?php echo $lang['store_callcenter_name_title'];?>">';
	add_html += '<input type="text" class="text w60" value="'+text+len+'" name="'+param+'['+key+'][name]" /></span>';
	add_html += '<span class="tool tip" title="<?php echo $lang['store_callcenter_tool_title'];?>"><select name="'+param+'['+key+'][type]">';
	add_html += '<option class="" value="0"><?php echo $lang['store_callcenter_please_choose'];?></option><option value="1">QQ</option>';
	add_html += '<option value="2"><?php echo $lang['store_callcenter_wangwang'];?></option><option value="3">站内IM</option></select></span>';
	add_html += '<span class="number tip" title="<?php echo $lang['store_callcenter_number_title'];?>"><input class="text w180" type="text" name="'+param+'['+key+'][num]" /></span>';
	add_html += '<span class="del"><a nctype="del" href="javascript:void(0);" class="ncsc-btn"><i class="icon-trash"></i><?php echo $lang['nc_delete'];?></a></span>';
	add_html += '</div>';
	obj.before(add_html);
	titleTip();
}
function titleTip(){
	//title提示
	$('.tip').unbind().poshytip({
		className: 'tip-yellowsimple',
		showTimeout: 1,
		alignTo: 'target',
		alignX: 'center',
		alignY: 'top',
		offsetX: 5,
		offsetY: 0,
		allowTipHover: false
	});
}
</script>