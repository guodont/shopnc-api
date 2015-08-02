<?php defined('InShopNC') or exit('Access Invalid!');?>
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>店铺帮助</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=help_store&op=help_store"><span><?php echo '帮助内容';?></span></a></li>
        <li><a href="index.php?act=help_store&op=help_type"><span><?php echo '帮助类型';?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '编辑内容';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="post_form" method="post" name="form1">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
      	<tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="help_title">帮助标题:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input id="help_title" name="help_title" value="<?php echo $output['help']['help_title']?>" class="txt" type="text"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="type_id">帮助类型:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="type_id" id="type_id">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['type_list']) && is_array($output['type_list'])){ ?>
              <?php foreach($output['type_list'] as $key => $val){ ?>
              <option <?php if($val['type_id'] == $output['help']['type_id']){?>selected<?php }?> value="<?php echo $val['type_id'];?>"><?php echo $val['type_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="help_sort"><?php echo $lang['nc_sort'];?>:</label>
            </td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['help']['help_sort']?>" name="help_sort" id="help_sort" class="txt"></td>
          <td class="vatop tips">数字范围为0~255，数字越小越靠前</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="help_url">链接地址:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['help']['help_url']?>" name="help_url" id="help_url" class="txt"></td>
          <td class="vatop tips">当填写"链接"后点击标题将直接跳转至链接地址，不显示内容。链接格式请以http://开头</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation">帮助内容:</label></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="vatop rowform"><?php showEditor('content',$output['help']['help_info']);?></td>
        </tr>
        <tr>
          <td colspan="2" class="required">图片上传:</td>
        </tr>
        <tr class="noborder">
          <td colspan="3" id="divComUploadContainer"><input type="file" multiple="multiple" id="fileupload" name="fileupload" /></td>
        </tr>
        <tr>
          <td colspan="2" class="required">已传图片:</td>
        <tr>
          <td colspan="2">
            <ul id="thumbnails" class="thumblists">
              <?php if(!empty($output['pic_list']) && is_array($output['pic_list'])){?>
              <?php foreach($output['pic_list'] as $key => $val){ ?>
              <li id="pic_<?php echo $val['upload_id'];?>" class="picture" >
                <input type="hidden" name="file_id[]" value="<?php echo $val['upload_id'];?>" />
                <div class="size-64x64"><span class="thumb"><i></i>
                    <img src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/'.$val['file_name'];?>" onload="javascript:DrawImage(this,64,64);"/></span></div>
                <p><span><a href="javascript:insert_editor('<?php echo $val['file_name'];?>');">插入</a></span><span><a href="javascript:del_file_upload('<?php echo $val['upload_id'];?>');"><?php echo $lang['nc_del'];?></a></span></p>
              </li>
              <?php } ?>
              <?php } ?>
            </ul>
          </td>
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
var UPLOAD_ARTICLE_URL = "<?php echo UPLOAD_SITE_URL.'/'.ATTACH_ARTICLE.'/'; ?>";
//按钮先执行验证再提交表单
$(function(){
	$("#submitBtn").click(function(){
        if($("#post_form").valid()){
            $("#post_form").submit();
    	}
	});
	$("#post_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
            help_title : {
                required : true
            },
            type_id : {
                required : true
            },
            help_sort : {
                required : true,
                digits   : true
            },
			help_url : {
				url : true
            },
			content : {
                required   : true
            }
        },
        messages : {
            help_title : {
                required : "类型名称不能为空"
            },
            type_id : {
                required : "请选择帮助类型"
            },
            help_sort  : {
                required : "排序仅可以为数字",
                digits   : "排序仅可以为数字"
            },
            help_url : {
                url : "链接格式不正确"
            },
            content : {
                required : "帮助内容不能为空"
            }
        }
	});
    // 图片上传
    $('#fileupload').each(function(){
        $(this).fileupload({
            dataType: 'json',
            url: 'index.php?act=help_store&op=upload_pic&item_id=<?php echo $output['help']['help_id']?>',
            done: function (e,data) {
                if(data != 'error'){
                	add_uploadedfile(data.result);
                }
            }
        });
    });
});

function add_uploadedfile(file){
    var newImg = '<li id="pic_' + file.file_id + '" class="picture"><input type="hidden" name="file_id[]" value="' + file.file_id
        + '" /><div class="size-64x64"><span class="thumb"><i></i><img src="'+UPLOAD_ARTICLE_URL
        + file.file_name + '" width="64px" height="64px"/></span></div><p><span><a href="javascript:insert_editor(\'' + file.file_name +
        '\');">插入</a></span><span><a href="javascript:del_file_upload(' + file.file_id + ');"><?php echo $lang['nc_del'];?></a></span></p></li>';
    $('#thumbnails').prepend(newImg);
}
function insert_editor(file_name){
	KE.appendHtml('content', '<img src="'+UPLOAD_ARTICLE_URL+ file_name + '">');
}
function del_file_upload(file_id){
    if(!window.confirm('<?php echo $lang['nc_ensure_del'];?>')){
        return;
    }
    $.getJSON('index.php?act=help_store&op=del_pic&file_id=' + file_id, function(result){
        if(result){
            $('#pic_' + file_id).remove();
        }
    });
}
</script>
