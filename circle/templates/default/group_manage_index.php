<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="base-layout">
  <div class="mainbox">
    <?php include circle_template('group_manage_top');?>
    <form id="circle_form" action="<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&c_id=<?php echo $output['c_id'];?>" method="post" class="base-form-style">
      <input type="hidden" value="ok" name="form_submit">
      <dl>
        <dt><?php echo $lang['circle_desc'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea name="c_desc" id="c_desc" class="textarea w500 h100"><?php echo $output['circle_info']['circle_desc'];?></textarea>
          <span class="count" id="desccharcount"></span> </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['circle_notice'].$lang['nc_colon'];?></dt>
        <dd>
          <textarea name="c_notice" id="c_notice" class="textarea w500 h100"><?php echo $output['circle_info']['circle_notice'];?></textarea>
          <span class="count" id="noticecharcount"></span> </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['circle_logo'].$lang['nc_colon'];?></dt>
        <dd>
          <div class="picture"><img id="view_img" src="<?php echo circleLogo($output['circle_info']['circle_id']);?>"/></div>
          <div class="upload-btn"> <a href="javascript:void(0);"> <span>
            <input type="file" name="c_img" id="c_img" multiple="" file_id="0" class="file" size="1" hidefocus="true" maxlength="0" />
            </span>
            <div class="upload-button"><i></i><?php echo $lang['circle_image_upload'];?></div>
            <input id="submit_button" style="display:none" type="button" value="&nbsp;" onClick="submit_form($(this))" />
            </a></div>
        </dd>
      </dl>
      <dl>
        <dt><?php echo $lang['circle_apply_verify'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="radio" name="c_joinaudit" value="1" <?php if($output['circle_info']['circle_joinaudit'] == 1){?>checked="checked"<?php }?> />
          <h5 class="mr20"><?php echo $lang['nc_yes'];?></h5>
          <input type="radio" name="c_joinaudit" value="0" <?php if($output['circle_info']['circle_joinaudit'] == 0){?>checked="checked"<?php }?> />
          <h5><?php echo $lang['nc_no'];?></h5> </dd>
      </dl>
      <dl style="border-bottom: none;">
        <dt><?php echo $lang['circle_mapply'].$lang['nc_colon'];?></dt>
        <dd>
          <input type="radio" name="c_mapply" value="1" <?php if($output['circle_info']['mapply_open'] == 1){?>checked="checked"<?php }?> />
          <h5 class="mr20"><?php echo $lang['nc_yes'];?></h5>
          <input type="radio" name="c_mapply" value="0" <?php if($output['circle_info']['mapply_open'] == 0){?>checked="checked"<?php }?> />
          <h5><?php echo $lang['nc_no'];?></h5>
        </dd>
      </dl>
      <dl>
       <dt></dt>
       <dd><select name="c_ml" class="mr10">
           <option value="0"><?php echo $lang['circle_no_requirement'];?></option>
           <?php for($i=1; $i<=16; $i++){?>
           <option value="<?php echo $i;?>" <?php if($output['circle_info']['mapply_ml'] == $i){?>selected="selected"<?php }?>><?php echo $output['ml_info']['ml_'.$i].'&nbsp;LV'.$i;?></option>
           <?php }?>
         </select><span class="count"><?php echo $lang['circle_need_grade'];?></span>
         
       </dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd><a href="Javascript: void(0)" class="submit-btn" nctype="submit-btn"><?php echo $lang['circle_submit_setting'];?></a></dd>
      </dl>
    </form>
  </div>
  <div class="sidebar">
    <?php include circle_template('group_manage_sidebar');?>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script> 
<script>
//裁剪图片后返回接收函数
function call_back(picname){
	$('#c_img').val('');
	$('#view_img').attr('src','<?php echo UPLOAD_SITE_URL.'/'.ATTACH_CIRCLE;?>/group/'+picname+'?'+Math.random());
}
$(function(){
	$('#c_img').change(uploadChange);
	function uploadChange(){
		var filepatd=$(this).val();
		var extStart=filepatd.lastIndexOf(".");
		var ext=filepatd.substring(extStart,filepatd.lengtd).toUpperCase();		
		if(ext!=".PNG"&&ext!=".GIF"&&ext!=".JPG"&&ext!=".JPEG"){
			alert("file type error");
			$(this).attr('value','');
			return false;
		}
		if ($(this).val() == '') return false;
		ajaxFileUpload();
	}
	function ajaxFileUpload()
	{
		$.ajaxFileUpload
		(
			{
				url:'index.php?act=cut&op=pic_upload&form_submit=ok&uploadpath=<?php echo ATTACH_CIRCLE;?>/group',
				secureuri:false,
				fileElementId:'c_img',
				dataType: 'json',
				success: function (data, status)
				{
					if (data.status == 1){
						ajax_form('cutpic','<?php echo $lang['nc_cut'];?>','index.php?act=cut&op=pic_cut&filename=<?php echo ATTACH_CIRCLE;?>/group/<?php echo intval($_GET['c_id']);?>.jpg&x=120&y=120&resize=1&url='+data.url,680);
					}else{
						alert(data.msg);
					}
					$('#c_img').bind('change',uploadChange);
				},
				error: function (data, status, e)
				{
					alert('upload failed');$('#c_img').bind('change',uploadChange);
				}
			}
		)
	};
	$('a[nctype="submit-btn"]').click(function(){
		$('#circle_form').submit();
	});
    $('#circle_form').validate({
        errorPlacement: function(error, element){
            $(element).parents('dd:first').children('.field_notice').html(error);
        },
    	submitHandler:function(form){
    		ajaxpost('circle_form', '<?php echo CIRCLE_SITE_URL;?>/index.php?act=manage&c_id=<?php echo $output['c_id'];?>', '', 'onerror');
    	},
        rules : {
        	c_desc : {
            	maxlength : 255
            },
            c_notice : {
                maxlength : 255
            }
        },
        messages : {
        	c_desc  : {
            	maxlength : '<?php echo $lang['circle_maxlength'];?>'
            },
            c_notice : {
                maxlength : '<?php echo $lang['circle_maxlength'];?>'
            }
        }
    });
    //字符个数动态计算
    $("#c_desc").charCount({
		allowed: 255,
		warning: 10,
		counterContainerID:'desccharcount',
		firstCounterText:'<?php echo $lang['charCount_firsttext'];?>',
		endCounterText:'<?php echo $lang['charCount_endtext'];?>',
		errorCounterText:'<?php echo $lang['charCount_errortext'];?>'
	});
    //字符个数动态计算
    $("#c_notice").charCount({
		allowed: 255,
		warning: 10,
		counterContainerID:'noticecharcount',
		firstCounterText:'<?php echo $lang['charCount_firsttext'];?>',
		endCounterText:'<?php echo $lang['charCount_endtext'];?>',
		errorCounterText:'<?php echo $lang['charCount_errortext'];?>'
	});
});
</script>