<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo CIRCLE_TEMPLATES_URL;?>/css/ubb.css" rel="stylesheet" type="text/css">
<div class="group warp-all">
  <?php require_once circle_template('group.top');?>
  <div class="theme-editor">
    <form method="post" id="theme_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=theme&op=save_theme&sp=1&c_id=<?php echo $output['c_id'];?>">
      <input type="hidden" name="form_submit" value="ok" />
      <div class="quick-thread">
        <div class="base-tab-menu">
          <ul class="base-tabs-nav">
            <li><a href="index.php?act=theme&op=new_theme&c_id=<?php echo $output['c_id'];?>"><?php echo $lang['circle_new_theme'];?></a></li>
            <li class="selected"><a href="javascript:void(0);"><?php echo $lang['circle_new_poll'];?></a></li>
          </ul>
        </div>
        <div class="quick-thread-box">
          <div class="title">
            <label class="mr10"><span class="t"><?php echo $lang['circle_type'].$lang['nc_colon'];?></span><span class="i">
              <select name="thtype" class="select">
                <option value="0"><?php echo $lang['nc_default'];?></option>
                <?php if(!empty($output['thclass_list'])){?>
                <?php foreach($output['thclass_list'] as $val){?>
                <?php if($output['super'] || in_array($output['identity'], array(1,2))){?>
                <option value="<?php echo $val['thclass_id'];?>"><?php echo $val['thclass_name'];?></option>
                <?php }else if($val['is_moderator'] == 0){?>
                <option value="<?php echo $val['thclass_id'];?>"><?php echo $val['thclass_name'];?></option>
                <?php }?>
                <?php }?>
                <?php }?>
              </select>
              </span></label>
            <label><span class="t"><?php echo $lang['nc_title'].$lang['nc_colon'];?></span><span class="i">
              <input name="name" type="text" class="text" />
              </span></label>
          </div>
          <div class="poll-options">
            <div class="top"> <span>
              <h4><?php echo $lang['circle_poll_options'].$lang['nc_colon'];?></h4>
              <?php echo $lang['circle_poll_options_max'];?> </span><span class="input-text">
              <h4><?php echo $lang['circle_poll_days'].$lang['nc_colon'];?></h4>
              <label>
                <input type="text" name="days" class="input-text" />
                <?php echo $lang['nc_day'];?></label>
              </span> <span id="poll_div_2" class="input-radio">
              <h4><?php echo $lang['circle_poll_patterns'].$lang['nc_colon'];?></h4>
              <label>
              <input type="radio" name="multiple" value="0" checked="checked" />
              <h5><?php echo $lang['circle_poll_radio'];?></h5>
              </label>
              <label>
              <input type="radio" name="multiple" value="1" />
              <h5><?php echo $lang['circle_poll_chexkbox'];?></h5>
              </label>
              </span></div>
            <div id="poll_div_1" class="add-poll"><a href="javascript:void(0);" nctype="addpolloption" class="btn"><i></i><?php echo $lang['circle_add_new'];?></a></div>
          </div>
          <?php echo showMiniEditor('themecontent', '', 'all', array(), 'goods', array(), $output['readperm']);?>
          <div class="bottom"> <a class="submit-btn" nctype="theme_submit" href="Javascript: void(0)"><?php echo $lang['nc_release_new_theme'];?></a> <a class="cancel-btn" nctype="theme_cancle" href="Javascript:history.go(-1);"><?php echo $lang['nc_cancel'];?></a>
            <div id="warning"></div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/miniditor/jquery.insertsome.min.js"></script> 
<script type="text/javascript" src="<?php echo CIRCLE_RESOURCE_SITE_URL;?>/js/miniditor/ubb.insert.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script> 
<script type="text/javascript">
var c_id = <?php echo $output['c_id'];?>;
$(function(){
	$('.theme-editor').ncUBB({
		c_id : c_id,
		UBBContent : $('#themecontent'),
		UBBSubmit : $('a[nctype="theme_submit"]'),
		UBBform : $('#theme_form'),
		UBBfileuploadurl : 'index.php?act=theme&op=image_upload&c_id='+c_id,
		UBBcontentleast : <?php echo intval(C('circle_contentleast'));?>,
		run : 'getUnusedAffix()'
	});
	//自定义滚定条
	$('#scrollbar').perfectScrollbar();
	// 表单验证
	jQuery.validator.addMethod("minOption",function(value, element){
		if($('input[name="polloption[]"][value!=""]').length < 2){
        	return false;
    	}else{
			return true;
        }
	});
	jQuery.validator.addMethod("nullOption",function(value, element){
		if($('input[name="polloption[]"][value!=""]').length == 0){
        	return false;
    	}else{
			return true;
        }
	});
	jQuery.validator.addMethod("maxlengthOption",function(value, element){
		var _s = true
		$('input[name="polloption[]"][value!=""]').each(function(){
			if($(this).val().length > 20) {_s = false;}
		});
		return _s;
	});
    $('#theme_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
        	
    		ajaxpost('theme_form', CIRCLE_SITE_URL+'/index.php?act=theme&op=save_theme&c_id='+c_id, '', 'onerror');
    	},
    	focusInvalid : false,
        rules : {
        	name : {
                required : true,
                minlength : 4,
            	maxlength : 30
            },
            themecontent : {
                required : true
                <?php if(intval(C('circle_contentleast')) > 0){?>
                ,minlength : <?php echo intval(C('circle_contentleast'));?>
                <?php }?>
            },
            'polloption[]' : {
            	nullOption : true,
                minOption : true,
                maxlengthOption : 20
            }
        },
        messages : {
        	name : {
                required : '<?php echo $lang['nc_name_not_null'];?>',
                minlength : '<?php echo $lang['nc_name_min_max_length'];?>',
            	maxlength : '<?php echo $lang['nc_name_min_max_length'];?>'
            },
            themecontent  : {
                required : '<?php echo $lang['nc_content_not_null'];?>'
                <?php if(intval(C('circle_contentleast')) > 0){?>
                ,minlength : '<?php printf(L('nc_content_min_length'), intval(C('circle_contentleast')));?>'
                <?php }?>
            },
            'polloption[]' : {
            	nullOption : '<?php echo $lang['circle_poll_options_not_null'];?>',
                minOption : '<?php echo $lang['circle_poll_options_min_error'];?>',
                maxlengthOption : '<?php echo $lang['circle_poll_options_max_error'];?>'
            }
        }
    });
	$('a[nctype="addpolloption"]').click(function(){
		addpolloption($(this));
	});	
	$('a[nctype="addpolloption"]').click().click().click();
});
// Add a voting option function
function addpolloption(o){
	// Adding quantity can't more than 20 options
	var len = $('#poll_div_1').find('p').length;
	if(len >= 22){
		return false;
	}
	
	$("<p class=\"new-add\"><input type=\"text\" name=\"polloption[]\" value=\"\" class=\"option\" /><a href=\"javascript:void(0);\"><?php echo $lang['nc_delete'];?></a></p>").find('a').click(function(){
		$(this).parent().remove();
	}).end().insertBefore(o);
}
</script>
