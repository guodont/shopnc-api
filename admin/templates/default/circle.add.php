<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['nc_circle_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=circle_manage&op=circle_list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=circle_manage&op=circle_verify"><span><?php echo $lang['circle_wait_verify'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="circle_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="c_name"><?php echo $lang['circle_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="c_name" id="c_name" class="txt" /></td>
          <td class="vatop tips"><?php echo $lang['circle_name_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="mastername"><?php echo $lang['circle_member_identity_master']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input type="text" name="mastername" id="mastername" readonly="readonly" class="txt" />
            <input type="hidden" name="masterid" id="masterid" />
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="" for="classid"><?php echo $lang['circle_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <select name="classid">
              <option value="0"><?php echo $lang['nc_common_pselect'];?></option>
              <?php if(!empty($output['class_list'])){?>
              <?php foreach ($output['class_list'] as $val){?>
              <option value="<?php echo $val['class_id'];?>"><?php echo $val['class_name'];?></option>
              <?php }?>
              <?php }?>
            </select>
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_desc"><?php echo $lang['circle_desc']?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <textarea class="tarea" rows="6" name="c_desc" id="c_desc"></textarea>
          </td>
          <td class="vatop tips"><?php echo $lang['circle_desc_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_tag"><?php echo $lang['circle_tag'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <input type="text" name="c_tag" class="txt" />
          </td>
          <td class="vatop tips"><?php echo $lang['circle_tag_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_notice"><?php echo $lang['circle_notice'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
            <textarea class="tarea" rows="6" name="c_notice" id="c_notice"></textarea>
          </td>
          <td class="vatop tips"><?php echo $lang['circle_notice_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['circle_image'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform">
			<span class="type-file-show">
			<img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
			<div class="type-file-preview" style="display: none;"><img id="view_img"></div>
			</span>          
            <span class="type-file-box">
              <input type='text' name='c_img' id='c_img' class='type-file-text' />
              <input type='button' name='button' id='button' value='' class='type-file-button' />
              <input name="_pic" type="file" class="type-file-file" id="_pic" size="30" hidefocus="true" />
            </span>
          </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_status"><?php echo $lang['circle_ststus'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="c_status1" class="cb-enable selected" ><span><?php echo $lang['open'];?></span></label>
            <label for="c_status0" class="cb-disable" ><span><?php echo $lang['close'];?></span></label>
            <input id="c_status1" name="c_status" checked="checked" value="1" type="radio">
            <input id="c_status0" name="c_status" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="c_recommend"><?php echo $lang['circle_is_recommend'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
            <label for="c_recommend1" class="cb-enable selected" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="c_recommend0" class="cb-disable" ><span><?php echo $lang['nc_no'];?></span></label>
            <input id="c_recommend1" name="c_recommend" checked="checked" value="1" type="radio">
            <input id="c_recommend0" name="c_recommend" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.js"></script>
<link href="<?php echo RESOURCE_SITE_URL;?>/js/jquery.Jcrop/jquery.Jcrop.min.css" rel="stylesheet" type="text/css" id="cssfile2" />
<script>
//裁剪图片后返回接收函数
function call_back(picname){
	$('#c_img').val(picname);
	$('#view_img').attr('src','<?php echo UPLOAD_SITE_URL.'/'.ATTACH_CIRCLE;?>/group/'+picname);
}
// 选择圈主
function chooseReturn(data) {
    $('#mastername').val(data.name);$('#masterid').val(data.id);
}
$(function(){
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
				url:'index.php?act=common&op=pic_upload&form_submit=ok&uploadpath=<?php echo ATTACH_CIRCLE;?>/group',
				secureuri:false,
				fileElementId:'_pic',
				dataType: 'json',
				success: function (data, status)
				{
					if (data.status == 1){
						ajax_form('cutpic','<?php echo $lang['nc_cut'];?>','index.php?act=common&op=pic_cut&type=circle&x=120&y=120&resize=1&ratio=1&url='+data.url,690);
					}else{
						alert(data.msg);
					}$('input[class="type-file-file"]').bind('change',uploadChange);
				},
				error: function (data, status, e)
				{
					alert('上传失败');$('input[class="type-file-file"]').bind('change',uploadChange);
				}
			}
		)
	}
	// 选择圈主弹出框
	$('#mastername').focus(function(){
		ajax_form('choose_master', '<?php echo $lang['circle_choose_master'];?>', 'index.php?act=circle_manage&op=choose_master', 320);
	});
	$("#submitBtn").click(function(){
		if($("#circle_form").valid()){
			$("#circle_form").submit();
		}
	});
	$('#circle_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	c_name : {
        		required : true,
                minlength : 4,
        		maxlength : 12,
            	remote : {
            		url : 'index.php?act=circle_manage&op=check_circle_name',
                    type: 'get',
                    data:{
                    	name : function(){
                            return $('#c_name').val();
                        }
                    }
            	}
            },
            mastername : {
            	required : true,
                remote   : {
                    url :'index.php?act=circle_manage&op=check_member&branch=ok',
                    type:'get',
                    data:{
                        name : function(){
                            return $('#mastername').val();
                        },
                        id : function(){
                            return $('#masterid').val();
                        }
                    }
                }
            },
            c_desc : {
            	maxlength : 240
            },
            c_tag : {
                maxlength : 50
            },
            c_notice : {
                maxlength : 240
            },
            c_sort : {
            	digits : true,
            	max : 255
            }
        },
        messages : {
            c_name : {
                required : '<?php echo $lang['circle_name_not_null'];?>',
                minlength : '<?php echo $lang['circle_name_length_4_12'];?>',
                maxlength : '<?php echo $lang['circle_name_length_4_12'];?>',
            	remote : '<?php echo $lang['circle_change_name_please'];?>'
            },
            mastername : {
            	required : '<?php echo $lang['circle_choose_master_please'];?>',
            	remote : '<?php echo $lang['circle_master_choose_error'];?>'
            },
            c_desc : {
            	maxlength : '<?php echo $lang['circle_desc_maxlength'];?>'
            },
            c_tag : {
                maxlength : '<?php echo $lang['circle_tag_maxlength'];?>'
            },
            c_notice : {
                maxlength : '<?php echo $lang['circle_notice_maxlength'];?>'
            },
            c_sort : {
            	digits : '<?php echo $lang['circle_sort_digits'];?>',
            	max : '<?php echo $lang['circle_sort_max'];?>'
            }
        }
    });
});
</script>
