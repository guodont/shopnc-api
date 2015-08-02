<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form id="add_form" action="<?php echo urlShop('store_account_group', 'group_save');?>" method="post">
    <?php if(!empty($output['group_info'])) { ?>
    <input name="group_id" type="hidden" value="<?php echo $output['group_info']['group_id'];?>" />
    <?php } ?>
    <dl>
      <dt><i class="required">*</i>组名称<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <input class="w120 text" name="seller_group_name" type="text" id="seller_group_name" value="<?php if(!empty($output['group_info'])) {echo $output['group_info']['group_name'];};?>" />
        <span></span>
        <p class="hint">设定权限组名称，方便区分权限类型。</p>
      </dd>
    </dl>
    <dl id="function_list">
      <dt><i class="required">*</i>权限<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-account-all">
          <input id="btn_select_all" name="btn_select_all" class="checkbox" type="checkbox" />
          <label for="btn_select_all">全选</label>
          <span></span>
          <?php if(!empty($output['menu']) && is_array($output['menu'])) {?>
          <?php foreach($output['menu'] as $key => $value) {?>
        </div>
        <div class="ncsc-account-container">
          <h4>
            <input id="<?php echo $key;?>" class="checkbox" nctype="btn_select_module" type="checkbox" />
            <label for="<?php echo $key;?>"><?php echo $value['name'];?></label>
          </h4>
          <?php $submenu = $value['child'];?>
          <?php if(!empty($submenu) && is_array($submenu)) {?>
          <ul class="ncsc-account-container-list">
            <?php foreach($submenu as $submenu_value) {?>
            <li>
              <input id="<?php echo $submenu_value['act'];?>" class="checkbox" name="limits[]" value="<?php echo $submenu_value['act'];?>" <?php if(!empty($output['group_limits'])) {if(in_array($submenu_value['act'], $output['group_limits'])) { echo 'checked'; }}?> type="checkbox" />
              <label for="<?php echo $submenu_value['act'];?>"><?php echo $submenu_value['name'];?></label>
            </li>
            <?php } ?>
          </ul>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <p class="hint"></p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required"></i>消息接收权限<?php echo $lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-account-all">
          <input id="smt_select_all" class="checkbox" type="checkbox" />
          <label for="smt_select_all">全选</label>
        </div>
        <div class="ncsc-account-container">
          <?php if (!empty($output['smt_list'])) {?>
          <ul class="ncsc-account-container-list" style=" width: 99%; padding-left: 1%;">
            <?php foreach ($output['smt_list'] as $val) {?>
            <li style=" width: 25%;">
              <input id="<?php echo $val['smt_code'];?>" class="checkbox" name="smt_limits[]" value="<?php echo $val['smt_code'];?>" <?php if (!empty($output['smt_limits']) && in_array($val['smt_code'], $output['smt_limits'])) {?>checked<?php }?> type="checkbox" />
              <label for="<?php echo $val['smt_code'];?>"><?php echo $val['smt_name'];?></label>
            </li>
            <?php }?>
          </ul>
          <?php }?>
        </div>
        <p class="hint">如需设置消息接收权限，请设置该权限组允许查看“系统消息”。</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border">
        <input type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>设置">
      </label>
    </div>
  </form>
</div>
<script>
$(document).ready(function(){
    $('#btn_select_all').on('click', function() {
        if($(this).prop('checked')) {
            $(this).parents('dd').find('input:checkbox').prop('checked', true);
        } else {
            $(this).parents('dd').find('input:checkbox').prop('checked', false);
        }
    });
    $('[nctype="btn_select_module"]').on('click', function() {
        if($(this).prop('checked')) {
            $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', true);
        } else {
            $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', false);
        }
    });
    $('#smt_select_all').on('click', function() {
        if($(this).prop('checked')) {
            $(this).parents('dl').find('input:checkbox').prop('checked', true);
        } else {
            $(this).parents('dl').find('input:checkbox').prop('checked', false);
        }
    });
    jQuery.validator.addMethod("function_check", function(value, element) {       
        var count = $('#function_list').find('input:checkbox:checked').length;
        return count > 0;
    });    
    $('#add_form').validate({
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
            submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
        rules : {
            seller_group_name: {
                required: true,
                maxlength: 50 
            },
            btn_select_all: {
                function_check: true 
            }
        },
        messages: {
            seller_group_name: {
                required: '<i class="icon-exclamation-sign"></i>组名称不能为空',
                maxlength: '<i class="icon-exclamation-sign"></i>组名最多50个字' 
            },
            btn_select_all: {
                function_check: '请选择权限'
            }
        }
    });

    // 商品相关权限关联选择
    $('#store_goods_add,#store_goods_online,#store_goods_offline').on('click', function() {
        if($(this).prop('checked')) {
            store_goods_select(true);
        } else {
            store_goods_select(false);
        }
    });

    function store_goods_select(state) {
        $('#store_goods_add').prop('checked', state);
        $('#store_goods_online').prop('checked', state);
        $('#store_goods_offline').prop('checked', state);
    }
});
</script> 
