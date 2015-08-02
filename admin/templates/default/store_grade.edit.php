<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store_grade'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store_grade&op=store_grade" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store_grade&op=store_grade_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="grade_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="sg_id" value="<?php echo $output['grade_array']['sg_id'];?>" />
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="sg_name"><?php echo $lang['store_grade_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['grade_array']['sg_name'];?>" id="sg_name" name="sg_name" class="txt"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="sg_goods_limit"><?php echo $lang['allow_pubilsh_product_num'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['grade_array']['sg_goods_limit'];?>" id="sg_goods_limit" name="sg_goods_limit" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['zero_said_no_limit'];?></td>
        </tr>
        <tr><td colspan="2" class="required"><label> <?php echo $lang['allow_upload_album_num'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['grade_array']['sg_album_limit'];?>" id="sg_album_limit" name="sg_album_limit" class="txt"></td><td class="vatop tips"><?php echo $lang['zero_said_no_limit'];?></td>
		</tr>
        <tr>
          <td colspan="2" class="required"><label for="skin_limit"><?php echo $lang['optional_template_num'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $output['grade_array']['sg_template_number'];?> <span class="grey">(<?php echo $lang['in_store_grade_list_set'];?>)</span></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="skin_limit"><?php echo $lang['additional_features'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><ul class="nofloat">
              <li>
                <input type="checkbox" <?php if(@in_array('editor_multimedia',$output['grade_array']['sg_function'])){ ?>checked="checked"<?php } ?> id="function_editor_multimedia" value="editor_multimedia" name="sg_function[]">
                <label for="function_editor_multimedia"><?php echo $lang['editor_media_features'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="sg_price"><?php echo $lang['charges_standard'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['grade_array']['sg_price'];?>" id="sg_price" name="sg_price" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['charges_standard_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['application_note'];?>:</label></td>
        </tr>
        <tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea id="sg_description" rows="6" class="tarea" name="sg_description"><?php echo $output['grade_array']['sg_description'];?></textarea></td>
          <td class="vatop tips"><?php echo $lang['application_note_notice'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="sg_sort"><?php echo $lang['grade_sortname']; //级别?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php if ($output['grade_array']['sg_id'] == 1){?>
            <input type="text" value="<?php echo $output['grade_array']['sg_sort'];?>" id="sg_sort" name="sg_sort" class="txt" readonly="readonly">
            <?php }else{?>
            <input type="text" value="<?php echo $output['grade_array']['sg_sort'];?>" id="sg_sort" name="sg_sort" class="txt">
            <?php }?></td>
          <td class="vatop tips"><?php echo $lang['grade_sort_tip']; //数值越大表明级别越高?></td>
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
<script>
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#grade_form").valid()){
     $("#grade_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#grade_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
            sg_name : {
                required : true,
                remote   : {
                url :'index.php?act=store_grade&op=ajax&branch=check_grade_name',
                type:'get',
                data:{
                        sg_name : function(){
                        	return $('#sg_name').val();
                        },
                        sg_id  : '<?php echo $output['grade_array']['sg_id'];?>'
                    }
                }
            },
			sg_price : {
                required  : true,
                number : true,
                min : 0
            },
            sg_goods_limit : {
                digits  : true
            },
            sg_space_limit : {
                digits : true
            },
            sg_sort : {
            	required  : true,
                digits  : true,
                remote   : {
	                url :'index.php?act=store_grade&op=ajax&branch=check_grade_sort',
	                type:'get',
	                data:{
	                        sg_sort : function(){
	                        	return $('#sg_sort').val();
	                        },
	                        sg_id  : '<?php echo $output['grade_array']['sg_id']; ?>'
	                    }
                }
            }
        },
        messages : {
            sg_name : {
                required : '<?php echo $lang['store_grade_name_no_null'];?>',
                remote   : '<?php echo $lang['now_store_grade_name_is_there'];?>'
            },
			sg_price : {
                required  : "<?php echo $lang['charges_standard_no_null'];?>",
                number : "<?php echo $lang['charges_standard_no_null'];?>",
                min : "<?php echo $lang['charges_standard_no_null'];?>"
            },
            sg_goods_limit : {
                digits : '<?php echo $lang['only_lnteger'];?>'
            },
            sg_space_limit : {
                digits  : '<?php echo $lang['only_lnteger'];?>'
            },
            sg_sort  : {
            	required : '<?php echo $lang['grade_add_sort_null_error']; //级别信息不能为空?>',
                digits   : '<?php echo $lang['only_lnteger'];?>',
                remote   : '<?php echo $lang['add_gradesortexist']; //级别已经存在?>'
            }
        }
    });
});
</script>
