<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>服务管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=service&op=service_manage"><span>所有服务</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="service_form" method="post" name="serviceform">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['service_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="service_name" id="service_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="cate_id"><?php echo $lang['service_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="gc_id" id="gc_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['class_list']) && is_array($output['class_list'])){ ?>
              <?php foreach($output['class_list'] as $k => $v){ ?>
              <option value="<?php echo $v['class_id'];?>"><?php echo $v['class_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="cate_id">服务单位:</label></td>
        </tr>		
        <tr class="noborder">
          <td class="vatop rowform"><select name="depart_id" id="depart_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['depart_list']) && is_array($output['depart_list'])){ ?>
              <?php foreach($output['depart_list'] as $k => $v){ ?>
              <option <?php if($output['depart_id'] == $v['depart_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['depart_id'];?>"><?php echo $v['depart_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>		
        <tr>
          <td colspan="2" class="required"><label for="serviceform"><?php echo $lang['service_price'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="service_price" id="service_price" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['service_price_null'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="serviceform"><?php echo $lang['service_now_price'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="service_now_price" id="service_now_price" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['service_now_price_null'];?></td>
        </tr>		
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['service_show'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="service_show1" class="cb-enable selected" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="service_show0" class="cb-disable" ><span><?php echo $lang['nc_no'];?></span></label>
            <input id="service_show1" name="service_show" checked="checked" value="1" type="radio">
            <input id="service_show0" name="service_show" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label><?php echo $lang['service_order'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform onoff"><label for="service_order1" class="cb-enable selected" ><span><?php echo $lang['nc_yes'];?></span></label>
                <label for="service_order0" class="cb-disable" ><span><?php echo $lang['nc_no'];?></span></label>
                <input id="service_order1" name="service_order" checked="checked" value="1" type="radio">
                <input id="service_order0" name="service_order" value="0" type="radio"></td>
            <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label><?php echo $lang['service_pay'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform onoff"><label for="service_pay1" class="cb-enable selected" ><span><?php echo $lang['nc_yes'];?></span></label>
                <label for="service_pay0" class="cb-disable" ><span><?php echo $lang['nc_no'];?></span></label>
                <input id="service_pay1" name="service_pay" checked="checked" value="1" type="radio">
                <input id="service_pay0" name="service_pay" value="0" type="radio"></td>
            <td class="vatop tips"></td>
        </tr>		
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_sort'];?>: 
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="255" name="service_sort" id="service_sort" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['service_abstract'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><textarea name="service_abstract" cols="110" rows="5" id="service_abstract"></textarea></td>
        </tr>		
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['service_content'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><?php showEditor('service_content');?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['service_contact_person'];?>: 
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="service_pname" id="service_pname" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['service_contact_tel'];?>: 
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" name="service_pphone" id="service_pphone" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>				
        <tr>
          <td colspan="2" class="required"><?php echo $lang['service_add_upload'];?>:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" id="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['service_add_uploaded'];?>:</td>
        <tr>
          <td colspan="2"><ul id="thumbnails" class="thumblists">
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['service_img_add_insert'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul><div class="tdare">
              
          </div></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script> 
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#service_form").valid()){
     $("#service_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#service_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            service_name : {
                required   : true
            },
			gc_id : {
                required   : true
            },
			service_price : {
                required   : true
            },
			service_now_price : {
                required   : true
            },					
			service_content : {
                required   : true
            },
			service_pname : {
                required   : true
            },
			service_pphone : {
                required   : true
            },				
            service_sort : {
                number   : true
            },
            service_pphone : {
                number   : true
            }			
        },
        messages : {
            service_name : {
                required   : '<?php echo $lang['service_name_null'];?>'
            },
			gc_id : {
                required   : '<?php echo $lang['service_add_class_null'];?>'
            },
			service_price : {
                required   : '<?php echo $lang['service_price_null'];?>'
            },
			service_now_price : {
                required   : '<?php echo $lang['service_now_price_null'];?>'
            },						
			service_content : {
                required   : '<?php echo $lang['service_add_content_null'];?>'
            },
			service_pname : {
                required   : '<?php echo $lang['service_contact_unnull'];?>'
            },
			service_pphone : {
                required   : '<?php echo $lang['service_tel_unnull'];?>'
            },									
            service_sort  : {
                number   : '<?php echo $lang['service_add_sort_int'];?>'
            },	
			service_pphone : {
                number   : '<?php echo $lang['service_tel_number'];?>'
            }		
        }
    });
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=service&op=service_pic_upload',
            done: function (e,data) {
                if(data != 'error'){
                	add_uploadedfile(data.result);
                }
            }
        });
    });
});


function add_uploadedfile(file_data)
{
    var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SERVICE.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_SERVICE.'/';?>' + file_data.file_name + '\');"><?php echo $lang['service_img_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('service_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=service&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['service_add_del_fail'];?>');
        }
    });
}
</script>