<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>预约编辑</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=service&op=service"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=service&op=service_add"><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="service_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="yuyue_id" value="<?php echo $output['service_yuyue_array']['yuyue_id'];?>" />
    <input type="hidden" name="ref_url" value="<?php echo getReferer();?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="service_title">预约人:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['service_yuyue_array']['yuyue_member_id']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="service_title">预约服务:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['service_yuyue_array']['yuyue_service_id']; ?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="service_title">服务单位:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['service_yuyue_array']['yuyue_company_id']; ?></td>
          <td class="vatop tips"></td>
        </tr>		
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="service_title">起止时间:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo date('Y-m-d',$output['service_yuyue_array']['yuyue_start_time']);?>——<?php echo date('Y-m-d',$output['service_yuyue_array']['yuyue_end_time']);?></td>
          <td class="vatop tips"></td>
        </tr>
	     <?php if($output['service_yuyue_array']['yuyue_pay_status']==1){ ?>					
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="service_title">支付情况:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['service_yuyue_array']['yuyue_pay_way']; ?>——<?php echo $output['service_yuyue_array']['yuyue_pay_status']; ?>——<?php echo $output['service_yuyue_array']['yuyue_pay_number']; ?></td>
          <td class="vatop tips"></td>
        </tr>
		<?php }else{ ?>
        <tr>
          <td colspan="2" class="required"><label>是否支付:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="service_show1" class="cb-enable <?php if($output['service_yuyue_array']['yuyue_pay_status'] == '1'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="service_show0" class="cb-disable <?php if($output['service_yuyue_array']['yuyue_pay_status'] == '0'){ ?>selected<?php } ?>" ><span><?php echo $lang['nc_no'];?></span></label>
            <input id="yuyue_pay_status1" name="yuyue_pay_status" <?php if($output['service_yuyue_array']['yuyue_pay_status'] == '1'){ ?>checked="checked"<?php } ?> value="1" type="radio">
            <input id="yuyue_pay_status0" name="yuyue_pay_status" <?php if($output['service_yuyue_array']['yuyue_pay_status'] == '0'){ ?>checked="checked"<?php } ?> value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>		
        <tr>
          <td colspan="2" class="required"><label for="serviceform">支付方式</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['service_yuyue_array']['yuyue_pay_way'];?>" name="service_price" id="service_price" class="txt"></td>
          <td class="vatop tips">若选择支付，支付方式不能为空</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="serviceform">支付单号</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['service_yuyue_array']['yuyue_pay_number'];?>" name="service_price" id="service_price" class="txt"></td>
          <td class="vatop tips">若选择支付，支付单号不能为空</td>
        </tr>		
		<?php } ?>				
        <tr>
          <td colspan="2" class="required"><label class="validation" for="cate_id">服务状态:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><label class="mr10">
              <input name="yuyue_Complete_status" type="radio" value="1" <?php if($output['service_yuyue_array']['yuyue_Complete_status'] == '1') echo 'checked';?> />
              审核中</label>
            <label class="mr10">
              <input name="yuyue_Complete_status" type="radio" value="2" <?php if($output['service_yuyue_array']['yuyue_Complete_status'] == '2') echo 'checked';?>/>
              已安排</label>
            <label class="mr10">
              <input name="yuyue_Complete_status" type="radio" value="3" <?php if($output['service_yuyue_array']['yuyue_Complete_status'] == '3') echo 'checked';?>/>
              进行中</label>
            <label class="mr10">
              <input name="yuyue_Complete_status" type="radio" value="4" <?php if($output['service_yuyue_array']['yuyue_Complete_status'] == '4') echo 'checked';?>/>
              已完成</label>
            </select></td>
          <td class="vatop tips"></td>
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
            service_title : {
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
            service_title : {
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
            url: 'index.php?act=service&op=service_pic_upload&item_id=<?php echo $output['service_array']['service_id'];?>',
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
	var newImg = '<li id="' + file_data.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" alt="' + file_data.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '\');"><?php echo $lang['service_img_add_insert'];?></a></span><span><a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
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