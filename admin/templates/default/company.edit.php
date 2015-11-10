<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['company_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=company&op=company"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=company&op=company_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="company_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="company_id" value="<?php echo $output['company_array']['company_id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="company_title"><?php echo $lang['company_index_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['company_array']['company_title'];?>" name="company_title" id="company_title" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="cate_id"><?php echo $lang['company_add_class'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="ac_id" id="ac_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['class_list']) && is_array($output['class_list'])){ ?>
              <?php foreach($output['class_list'] as $k => $v){ ?>
              <option <?php if($output['company_array']['ac_id'] == $v['class_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['class_id'];?>"><?php echo $v['class_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="company_address"><?php echo $lang['company_add_url'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['company_array']['company_address'];?>" name="company_address" id="company_address" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['company_add_url_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="if_show"><?php echo $lang['company_add_show'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="company_show1" class="cb-enable <?php if($output['company_array']['company_show'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="company_show0" class="cb-disable <?php if($output['company_array']['company_show'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_no'];?></span></label>
            <input id="company_show1" name="company_show" <?php if($output['company_array']['company_show'] == '1'){ ?>checked="checked"<?php } ?>  value="1" type="radio">
            <input id="company_show0" name="company_show" <?php if($output['company_array']['company_show'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
            <td colspan="2" class="required"><label><?php echo $lang['company_add_push'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform onoff"><label for="company_recommend1" class="cb-enable <?php if($output['company_array']['company_recommend'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_yes'];?></span></label>
                <label for="company_recommend0" class="cb-disable <?php if($output['company_array']['company_recommend'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_no'];?></span></label>
                <input id="company_recommend1" name="company_recommend" <?php if($output['company_array']['company_recommend'] == '1'){ ?>checked="checked"<?php } ?> checked="checked" value="1" type="radio">
                <input id="company_recommend0" name="company_recommend" <?php if($output['company_array']['company_recommend'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
            <td class="vatop tips"></td>
        </tr>		
        <tr>
          <td colspan="2" class="required"><?php echo $lang['nc_sort'];?>:</td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['company_array']['company_sort'];?>" name="company_sort" id="company_sort" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['company_add_content'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><?php showEditor('company_content',$output['company_array']['company_content']);?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['company_add_upload'];?>:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" id="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['company_add_uploaded'];?>:</td>
        </tr>
        <tr class="noborder">
          <td colspan="2"><ul id="thumbnails" class="thumblists">
              <?php if(is_array($output['file_upload'])){?>
              <?php foreach($output['file_upload'] as $k => $v){ ?>
              <li id="<?php echo $v['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo $v['upload_path'];?>" alt="<?php echo $v['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['company_add_insert'];?></a></span><span><a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul></td>
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
    if($("#company_form").valid()){
     $("#company_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#company_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            company_title : {
                required   : true
            },
			ac_id : {
                required   : true
            },
			company_content : {
                required   : true
            },
            company_sort : {
                number   : true
            }
        },
        messages : {
            company_title : {
                required   : '<?php echo $lang['company_add_title_null'];?>'
            },
			ac_id : {
                required   : '<?php echo $lang['company_add_class_null'];?>'
            },
			company_content : {
                required   : '<?php echo $lang['company_add_content_null'];?>'
            },
            company_sort  : {
                number   : '<?php echo $lang['company_add_sort_int'];?>'
            }
        }
    });
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=company&op=company_pic_upload&item_id=<?php echo $output['company_array']['company_id'];?>',
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
	var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '\');"><?php echo $lang['company_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('company_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=company&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['company_add_del_fail'];?>');
        }
    });
}
</script>