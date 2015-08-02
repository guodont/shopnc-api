<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['document_index_document'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=document&op=document"><span><?php echo $lang['nc_manage'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="doc_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="doc_id" value="<?php echo $output['doc']['doc_id'];?>" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['document_index_title'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['doc']['doc_title'];?>" name="doc_title" id="doc_title" class="infoTableInput"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['document_index_content'];?>: </label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php showEditor('doc_content',$output['doc']['doc_content']);?></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['document_index_pic_upload'];?>:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" id="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><?php echo $lang['document_index_uploaded_pic'];?>:</td>
        </tr>
        <tr>
          <td colspan="2" ><div class="tdare">
              <table width="600px" cellspacing="0" class="dataTable">
                <tbody id="thumbnails">
                  <?php if(is_array($output['file_upload'])){?>
                  <?php foreach($output['file_upload'] as $k => $v){ ?>
                  <tr id="<?php echo $v['upload_id'];?>" class="tatr2">
                    <input type="hidden" name="file_id[]" value="<?php echo $v['upload_id'];?>" />
                    <td><img width="40px" height="40px" src="<?php echo $v['upload_path'];?>" /></td>
                    <td><?php echo $v['file_name'];?></td>
                    <td><a href="javascript:insert_editor('<?php echo $v['upload_path'];?>');"><?php echo $lang['document_index_insert'];?></a> | <a href="javascript:del_file_upload('<?php echo $v['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></td>
                  </tr>
                  <?php } ?>
                  <?php } ?>
                </tbody>
              </table>
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
    if($("#doc_form").valid()){
     $("#doc_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#doc_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            doc_title : {
                required   : true
            },
			doc_content : {
                required   : true
            }
        },
        messages : {
            doc_title : {
                required   : '<?php echo $lang['document_index_title_null'];?>'
            },
			doc_content : {
                required   : '<?php echo $lang['document_index_content_null'];?>'
            }
        }
    });
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=document&op=document_pic_upload&item_id=<?php echo $output['doc']['doc_id'];?>',
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
    var newImg = '<tr id="' + file_data.file_id + '" class="tatr2"><input type="hidden" name="file_id[]" value="' + file_data.file_id + '" /><td><img width="40px" height="40px" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '" /></td><td>' + file_data.file_name + '</td><td><a href="javascript:insert_editor(\'<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/';?>' + file_data.file_name + '\');"><?php echo $lang['document_index_insert'];?></a> | <a href="javascript:del_file_upload(' + file_data.file_id + ');"><?php echo $lang['nc_del'];?></a></td></tr>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_path){
	KE.appendHtml('doc_content', '<img src="'+ file_path + '" alt="'+ file_path + '">');
}
function del_file_upload(file_id)
{
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=document&op=ajax&branch=del_file_upload&file_id=' + file_id, function(result){
        if(result){
            $('#' + file_id).remove();
        }else{
            alert('<?php echo $lang['document_index_del_fail'];?>');
        }
    });
}
</script>