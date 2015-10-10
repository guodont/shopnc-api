<?php defined('InShopNC') or exit('Access Invalid!');?>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
    <?php if(empty($output['xianshi_info'])) { ?>
    <form id="add_form" action="index.php?act=store_promotion_xianshi&op=xianshi_save" method="post">
    <?php } else { ?>
    <form id="add_form" action="index.php?act=store_promotion_xianshi&op=xianshi_edit_save" method="post">
        <input type="hidden" name="xianshi_id" value="<?php echo $output['xianshi_info']['xianshi_id'];?>">
    <?php } ?>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['xianshi_name'];?><?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="xianshi_name" name="xianshi_name" type="text"  maxlength="25" class="text w400" value="<?php echo empty($output['xianshi_info'])?'':$output['xianshi_info']['xianshi_name'];?>"/>
          <span></span>
        <p class="hint"><?php echo $lang['xianshi_name_explain'];?></p>
      </dd>
    </dl>
    <dl>
      <dt>活动标题<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="xianshi_title" name="xianshi_title" type="text"  maxlength="10" class="text w200" value="<?php echo empty($output['xianshi_info'])?'':$output['xianshi_info']['xianshi_title'];?>"/>
          <span></span>
        <p class="hint"><?php echo $lang['xianshi_title_explain'];?></p>
      </dd>
    </dl>
    <dl>
      <dt>活动描述<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="xianshi_explain" name="xianshi_explain" type="text"  maxlength="30" class="text w400" value="<?php echo empty($output['xianshi_info'])?'':$output['xianshi_info']['xianshi_explain'];?>"/>
          <span></span>
        <p class="hint"><?php echo $lang['xianshi_explain_explain'];?></p>
      </dd>
    </dl>
    <?php if(empty($output['xianshi_info'])) { ?>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['start_time'];?><?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="start_time" name="start_time" type="text" class="text w130" /><em class="add-on"><i class="icon-calendar"></i></em><span></span>
        <p class="hint">
<?php if (!$output['isOwnShop'] && $output['current_xianshi_quota']['start_time'] > 1) { ?>
        <?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['start_time']));?>
<?php } ?>
        </p>
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i><?php echo $lang['end_time'];?><?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="end_time" name="end_time" type="text" class="text w130"/><em class="add-on"><i class="icon-calendar"></i></em><span></span>
        <p class="hint">
<?php if (!$output['isOwnShop']) { ?>
        <?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['end_time']));?>
<?php } ?>
        </p>
      </dd>
    </dl>
    <?php } ?>
    <dl>
      <dt><i class="required">*</i>购买下限<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="lower_limit" name="lower_limit" type="text" class="text w130" value="<?php echo empty($output['xianshi_info'])?'1':$output['xianshi_info']['lower_limit'];?>"/><span></span>
        <p class="hint">参加活动的最低购买数量，默认为1</p>
      </dd>
    </dl>
    <div class="bottom">
      <label class="submit-border"><input id="submit_button" type="submit" class="submit" value="<?php echo $lang['nc_submit'];?>"></label>
    </div>
  </form>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script>
$(document).ready(function(){
    <?php if(empty($output['xianshi_info'])) { ?>
    $('#start_time').datetimepicker({
        controlType: 'select'
    });

    $('#end_time').datetimepicker({
        controlType: 'select'
    });
    <?php } ?>

    jQuery.validator.methods.greaterThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };
    jQuery.validator.methods.lessThanDate = function(value, element, param) {
        var date1 = new Date(Date.parse(param.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 > date2;
    };
    jQuery.validator.methods.greaterThanStartDate = function(value, element) {
        var start_date = $("#start_time").val();
        var date1 = new Date(Date.parse(start_date.replace(/-/g, "/")));
        var date2 = new Date(Date.parse(value.replace(/-/g, "/")));
        return date1 < date2;
    };

    //页面输入内容验证
    $("#add_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd').children('span');
            error_td.append(error);
        },
        onfocusout: false,
    	submitHandler:function(form){
    		ajaxpost('add_form', '', '', 'onerror');
    	},
        rules : {
            xianshi_name : {
                required : true
            },
            start_time : {
                required : true,
                greaterThanDate : '<?php echo date('Y-m-d H:i',$output['current_xianshi_quota']['start_time']);?>'
            },
            end_time : {
                required : true,
<?php if (!$output['isOwnShop']) { ?>
                lessThanDate : '<?php echo date('Y-m-d H:i',$output['current_xianshi_quota']['end_time']);?>',
<?php } ?>
                greaterThanStartDate : true
            },
            lower_limit: {
                required: true,
                digits: true,
                min: 1
            }
        },
        messages : {
            xianshi_name : {
                required : '<i class="icon-exclamation-sign"></i><?php echo $lang['xianshi_name_error'];?>'
            },
            start_time : {
            required : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['start_time']));?>',
                greaterThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_start_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['start_time']));?>'
            },
            end_time : {
            required : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['end_time']));?>',
<?php if (!$output['isOwnShop']) { ?>
                lessThanDate : '<i class="icon-exclamation-sign"></i><?php echo sprintf($lang['xianshi_add_end_time_explain'],date('Y-m-d H:i',$output['current_xianshi_quota']['end_time']));?>',
<?php } ?>
                greaterThanStartDate : '<i class="icon-exclamation-sign"></i><?php echo $lang['greater_than_start_time'];?>'
            },
            lower_limit: {
                required : '<i class="icon-exclamation-sign"></i>购买下限不能为空',
                digits: '<i class="icon-exclamation-sign"></i>购买下限必须为数字',
                min: '<i class="icon-exclamation-sign"></i>购买下限不能小于1'
            }
        }
    });
});
</script>
