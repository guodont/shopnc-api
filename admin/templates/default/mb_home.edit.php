<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>首页设置</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=mb_home&op=mb_home_list" ><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="link_form" enctype="multipart/form-data" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="h_id" value="<?php echo $output['home_array']['h_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="h_title"><?php echo $lang['home_index_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['home_array']['h_title'];?>" name="h_title" id="h_title" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['home_add_name'];?></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="h_desc"><?php echo $lang['home_index_desc'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['home_array']['h_desc'];?>" name="h_desc" id="h_desc" class="txt"></td>
          <?php if($output['home_array']['h_type'] == 'type1') { ?>
          <td class="vatop tips"><?php echo $lang['home_add_desc'];?></td>
          <?php } else { ?>
          <td class="vatop tips">推荐两个关键词用逗号分割(例：精品女装,服装箱包)</td>
          <?php } ?>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="h_keyword"><?php echo $lang['home_index_keyword'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['home_array']['h_keyword'];?>" name="h_keyword" id="h_keyword" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['home_add_keyword'];?></td>
        </tr>
        <?php if($output['home_array']['h_type'] == 'type1') { ?>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="h_keyword">多关键词:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['home_array']['h_multi_keyword'];?>" name="h_multi_keyword" id="h_multi_keyword" class="txt"></td>
          <td class="vatop tips">首页显示的多关键词，最多6个词，用半角逗号分割(例子：男装,女装)</td>
        </tr>
        <?php } ?>
        <tr>
          <td colspan="2" class="required"><label for=""><?php echo $lang['home_index_pic_sign'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><span class="type-file-show"><img class="show_image" src="<?php echo ADMIN_TEMPLATES_URL;?>/images/preview.png">
            <div class="type-file-preview"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_MOBILE.'/home/'.$output['home_array']['h_img'];?>"></div>
            </span> <span class="type-file-box">
            <input name="h_img" type="file" class="type-file-file" id="h_img" size="30">
            </span></td>
          <td class="vatop tips"><?php echo $lang['home_add_sign']; ?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="h_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['home_array']['h_sort'];?>" name="h_sort" id="h_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['home_add_sort_tip'];?></td>
        </tr>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#link_form").valid()){
     $("#link_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#link_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	h_title : {
                required : true,
                maxlength : 6
            },
            h_desc  : {
                required : true,
                maxlength : 10
            },
            h_keyword  : {
                required : true,
                maxlength : 6
            },
            h_sort : {
                number   : true
            }
        },
        messages : {
        	h_title : {
                required : '<?php echo $lang['home_add_null'];?>',
                maxlength : '<?php echo $lang['home_add_maxlength'];?>'
            },
            h_desc  : {
                required : '<?php echo $lang['home_add_null'];?>',
                maxlength : '<?php echo $lang['home_add_maxlength'];?>'
            },
            h_keyword  : {
                required : '<?php echo $lang['home_add_null'];?>',
                maxlength : '<?php echo $lang['home_add_maxlength'];?>'
            },
            h_sort  : {
                number   : '<?php echo $lang['home_add_sort_int'];?>'
            }
        }
    });
});
</script> 
<script type="text/javascript">
$(function(){
    var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
	$(textButton).insertBefore("#h_img");
	$("#h_img").change(function(){
	$("#textfield1").val($("#h_img").val());
});
});
</script>
