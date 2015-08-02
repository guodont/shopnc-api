<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['member_index_manage']?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=member&op=member" ><span><?php echo $lang['nc_manage']?></span></a></li>
        <li><a href="index.php?act=member&op=member_add" ><span><?php echo $lang['nc_new']?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="user_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="member_id" value="<?php echo $output['member_array']['member_id'];?>" />
    <input type="hidden" name="old_member_avatar" value="<?php echo $output['member_array']['member_avatar'];?>" />
    <input type="hidden" name="member_name" value="<?php echo $output['member_array']['member_name'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['member_index_name']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['member_array']['member_name'];?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="member_passwd"><?php echo $lang['member_edit_password']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="member_passwd" name="member_passwd" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['member_edit_password_keep']?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="member_email"><?php echo $lang['member_index_email']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['member_array']['member_email'];?>" id="member_email" name="member_email" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['member_index_email']?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="member_truename"><?php echo $lang['member_index_true_name']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['member_array']['member_truename'];?>" id="member_truename" name="member_truename" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_edit_sex']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul>
              <li>
                <input type="radio" <?php if($output['member_array']['member_sex'] == 0){ ?>checked="checked"<?php } ?> value="0" name="member_sex" id="member_sex0">
                <label for="member_sex0"><?php echo $lang['member_edit_secret']?></label>
              </li>
              <li>
                <input type="radio" <?php if($output['member_array']['member_sex'] == 1){ ?>checked="checked"<?php } ?> value="1" name="member_sex" id="member_sex1">
                <label for="member_sex1"><?php echo $lang['member_edit_male']?></label>
              </li>
              <li>
                <input type="radio" <?php if($output['member_array']['member_sex'] == 2){ ?>checked="checked"<?php } ?> value="2" name="member_sex" id="member_sex2">
                <label for="member_sex2"><?php echo $lang['member_edit_female']?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <!--//zmr>v30-->
         <tr>
          <td colspan="2" class="required"><label class="member_areainfo">所在地区:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"  colspan="2">
        <span id="region" class="w400">
            <input type="hidden" value="<?php echo $output['member_array']['member_provinceid'];?>" name="province_id" id="province_id">
            <input type="hidden" value="<?php echo $output['member_array']['member_cityid'];?>" name="city_id" id="city_id">
            <input type="hidden" value="<?php echo $output['member_array']['member_areaid'];?>" name="area_id" id="area_id" class="area_ids" />
            <input type="hidden" value="<?php echo $output['member_array']['member_areainfo'];?>" name="area_info" id="area_info" class="area_names" />
            <?php if(!empty($output['member_array']['member_areaid'])){?>
            <span><?php echo $output['member_array']['member_areainfo'];?></span>
            <input type="button" value="<?php echo $lang['nc_edit'];?>" style="background-color: #F5F5F5; width: 60px; height: 32px; border: solid 1px #E7E7E7; cursor: pointer" class="edit_region" />
            <select style="display:none;">
            </select>
            <?php }else{?>
            <select>
            </select>
            <?php }?>
            </span>
        </td>
         
        </tr>
        
        
          <tr>
          <td colspan="2" class="required"><label class="member_mobile">手机号码:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['member_array']['member_mobile'];?>" id="member_mobile" name="member_mobile" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        
        <tr>
          <td colspan="2" class="required"><label class="member_qq">QQ:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['member_array']['member_qq'];?>" id="member_qq" name="member_qq" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="member_ww"><?php echo $lang['member_edit_wangwang']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['member_array']['member_ww'];?>" id="member_ww" name="member_ww" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_edit_pic']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
			<span class="type-file-show">
			<img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
			<div class="type-file-preview" style="display: none;"><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR; ?>/<?php echo $output['member_array']['member_avatar'];?>" id="view_img"></div>
			</span>
            <span class="type-file-box">
              <input type='text' name='member_avatar' id='member_avatar' class='type-file-text' />
              <input type='button' name='button' id='button' value='' class='type-file-button' />
              <input name="_pic" type="file" class="type-file-file" id="_pic" size="30" hidefocus="true" />
            </span>            
            </td>
          <td class="vatop tips"><?php echo $lang['member_edit_support']?>gif,jpg,jpeg,png</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_index_inform'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="inform_allow1" class="cb-enable <?php if($output['member_array']['inform_allow'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="inform_allow2" class="cb-disable <?php if($output['member_array']['inform_allow'] == '2'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="inform_allow1" name="inform_allow" <?php if($output['member_array']['inform_allow'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="inform_allow2" name="inform_allow" <?php if($output['member_array']['inform_allow'] == '2'){ ?>checked="checked"<?php } ?> value="2" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_edit_allowbuy']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="isbuy_1" class="cb-enable <?php if($output['member_array']['is_buy'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="isbuy_2" class="cb-disable <?php if($output['member_array']['is_buy'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="isbuy_1" name="isbuy" <?php if($output['member_array']['is_buy'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="isbuy_2" name="isbuy" <?php if($output['member_array']['is_buy'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['member_edit_allowbuy_tip']; ?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_edit_allowtalk']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="allowtalk_1" class="cb-enable <?php if($output['member_array']['is_allowtalk'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="allowtalk_2" class="cb-disable <?php if($output['member_array']['is_allowtalk'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="allowtalk_1" name="allowtalk" <?php if($output['member_array']['is_allowtalk'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="allowtalk_2" name="allowtalk" <?php if($output['member_array']['is_allowtalk'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"><?php echo $lang['member_edit_allowtalk_tip']; ?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_edit_allowlogin']; ?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="memberstate_1" class="cb-enable <?php if($output['member_array']['member_state'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_allow'];?></span></label>
            <label for="memberstate_2" class="cb-disable <?php if($output['member_array']['member_state'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['member_edit_deny'];?></span></label>
            <input id="memberstate_1" name="memberstate" <?php if($output['member_array']['member_state'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="memberstate_2" name="memberstate" <?php if($output['member_array']['member_state'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        
        
        
        <!--zmr>v30-->
          <tr>
          <td colspan="2" class="required"><label>手机号码验证:</label></td>
        </tr>
         <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="membermobilebind_1" class="cb-enable <?php if($output['member_array']['member_mobile_bind'] == '1'){ ?>selected<?php } ?>" ><span>已验证</span></label>
            <label for="membermobilebind_2" class="cb-disable <?php if($output['member_array']['member_mobile_bind'] == '0'){ ?>selected<?php } ?>" ><span>未验证</span></label>
            <input id="membermobilebind_1" name="membermobilebind" <?php if($output['member_array']['member_mobile_bind'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="membermobilebind_2" name="membermobilebind" <?php if($output['member_array']['member_mobile_bind'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        
        
        
        
        
         <!--zmr>v30-->
          <tr>
          <td colspan="2" class="required"><label>邮箱验证:</label></td>
        </tr>
         <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="memberemailbind_1" class="cb-enable <?php if($output['member_array']['member_email_bind'] == '1'){ ?>selected<?php } ?>" ><span>已验证</span></label>
            <label for="memberemailbind_2" class="cb-disable <?php if($output['member_array']['member_email_bind'] == '0'){ ?>selected<?php } ?>" ><span>未验证</span></label>
            <input id="memberemailbind_1" name="memberemailbind" <?php if($output['member_array']['member_email_bind'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="memberemailbind_2" name="memberemailbind" <?php if($output['member_array']['member_email_bind'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        
        
        
        
        
        
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_index_points']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $lang['member_index_points']?>&nbsp;<strong class="red"><?php echo $output['member_array']['member_points']; ?></strong>&nbsp;<?php echo $lang['points_unit']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>经验值:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">经验值&nbsp;<strong class="red"><?php echo $output['member_array']['member_exppoints']; ?></strong>&nbsp;<?php echo $lang['points_unit']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_index_available'];?><?php echo $lang['member_index_prestore'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $lang['member_index_available'];?>&nbsp;<strong class="red"><?php echo $output['member_array']['available_predeposit']; ?></strong>&nbsp;<?php echo $lang['currency_zh']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['member_index_frozen'];?><?php echo $lang['member_index_prestore'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $lang['member_index_frozen'];?>&nbsp;<strong class="red"><?php echo $output['member_array']['freeze_predeposit']; ?></strong>&nbsp;<?php echo $lang['currency_zh']; ?></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
//裁剪图片后返回接收函数
function call_back(picname){
	$('#member_avatar').val(picname);
	$('#view_img').attr('src','<?php echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR;?>/'+picname+'?'+Math.random());
}
$(function(){
	//zmr>v30
	regionInit("region");
	$('input[class="type-file-file"]').change(uploadChange);
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
				url:'index.php?act=common&op=pic_upload&form_submit=ok&uploadpath=<?php echo ATTACH_AVATAR;?>',
				secureuri:false,
				fileElementId:'_pic',
				dataType: 'json',
				success: function (data, status)
				{
					if (data.status == 1){
						ajax_form('cutpic','<?php echo $lang['nc_cut'];?>','index.php?act=common&op=pic_cut&type=member&x=120&y=120&resize=1&ratio=1&filename=<?php echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR;?>/avatar_<?php echo $_GET['member_id'];?>.jpg&url='+data.url,690);
					}else{
						alert(data.msg);
					}
					$('input[class="type-file-file"]').bind('change',uploadChange);
				},
				error: function (data, status, e)
				{
					alert('上传失败');$('input[class="type-file-file"]').bind('change',uploadChange);
				}
			}
		)
	};
$("#submitBtn").click(function(){
    if($("#user_form").valid()){
     $("#user_form").submit();
	}
	});
    $('#user_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            member_passwd: {
                maxlength: 20,
                minlength: 6
            },
            member_email   : {
                required : true,
                email : true,
				remote   : {
                    url :'index.php?act=member&op=ajax&branch=check_email',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#member_email').val();
                        },
                        member_id : '<?php echo $output['member_array']['member_id'];?>'
                    }
                }
            }
        },
        messages : {
            member_passwd : {
                maxlength: '<?php echo $lang['member_edit_password_tip']?>',
                minlength: '<?php echo $lang['member_edit_password_tip']?>'
            },
            member_email  : {
                required : '<?php echo $lang['member_edit_email_null']?>',
                email   : '<?php echo $lang['member_edit_valid_email']?>',
				remote : '<?php echo $lang['member_edit_email_exists']?>'
            }
        }
    });
});
</script> 
