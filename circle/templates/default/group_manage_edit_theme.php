<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo CIRCLE_TEMPLATES_URL;?>/css/ubb.css" rel="stylesheet" type="text/css">
<div class="group warp-all">
  <?php require_once circle_template('group.top');?>
  <div class="theme-editor">
    <form method="post" id="theme_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&op=edit_theme&c_id=<?php echo $output['c_id'];?>&t_id=<?php echo $output['t_id']; ?>">
      <input type="hidden" name="form_submit" value="ok" />
      <div class="quick-thread">
        <div class="quick-thread-box">
          <div class="title">
            <label class="mr10"><span class="t"><?php echo $lang['nc_sort'].$lang['nc_colon'];?></span><span class="i">
              <select name="thtype" class="select">
                <option value="0"><?php echo $lang['nc_default'];?></option>
                <?php if(!empty($output['thclass_list'])){?>
                <?php foreach($output['thclass_list'] as $val){?>
                <?php if($output['super'] || in_array($output['identity'], array(1,2))){?>
                <option value="<?php echo $val['thclass_id'];?>" <?php if($output['theme_info']['thclass_id'] == $val['thclass_id']){?>selected="selected"<?php }?>><?php echo $val['thclass_name'];?></option>
                <?php }else if($val['is_moderator'] == 0){?>
                <option value="<?php echo $val['thclass_id'];?>" <?php if($output['theme_info']['thclass_id'] == $val['thclass_id']){?>selected="selected"<?php }?>><?php echo $val['thclass_name'];?></option>
                <?php }?>
                <?php }?>
                <?php }?>
              </select>
              </span></label>
            <label><span class="t"><?php echo $lang['nc_title'].$lang['nc_colon'];?></span><span class="i">
              <input name="name" type="text" class="text" value="<?php echo $output['theme_info']['theme_name'];?>" />
              </span></label>
          </div>
          <?php echo showMiniEditor('themecontent', $output['theme_info']['theme_content'], 'manage', $output['affix_list'], 'goods', $output['goods_list'], $output['readperm'], $output['theme_info']['theme_readperm']);?>
          <div class="bottom"> <a class="submit-btn" nctype="theme_submit" href="Javascript: void(0)"><?php echo $lang['nc_edit_theme'];?></a> <a class="cancel-btn" nctype="theme_cancle" href="Javascript:history.go(-1);"><?php echo $lang['nc_cancel']; ?></a>
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
<script type="text/javascript">
var c_id = <?php echo $output['c_id'];?>;
var t_id = <?php echo $output['t_id'];?>;
$(function(){
	// UBB
	$('.theme-editor').ncUBB({
		c_id : c_id,
		t_id : t_id,
		UBBContent : $('#themecontent'),
		UBBSubmit : $('a[nctype="theme_submit"]'),
		UBBform : $('#theme_form'),
		UBBfileuploadurl : 'index.php?act=theme&op=image_upload&c_id='+c_id,
		UBBcontentleast : <?php echo intval(C('circle_contentleast'));?>
	});
	// 表单验证
    $('#theme_form').validate({
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
               $('#warning').show();
        },
    	submitHandler:function(form){
    		ajaxpost('theme_form', CIRCLE_SITE_URL+'/index.php?act=manage&op=edit_theme&c_id='+c_id+'&t_id='+t_id, '', 'onerror');
    	},
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
            }
        }
    });
});
</script>