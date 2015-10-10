<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['store_class'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=store_class&op=store_class" ><span><?php echo $lang['manage'];?></span></a></li>
        <li><a href="index.php?act=store_class&op=store_class_add" ><span><?php echo $lang['nc_new'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_edit'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="store_class_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="sc_id" value="<?php echo $output['class_array']['sc_id'];?>" />
    <input type="hidden" name="sc_parent_id" value="<?php echo $output['class_array']['sc_parent_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" class="sc_name"><?php echo $lang['store_class_name'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['sc_name'];?>" name="sc_name" id="sc_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="sc_name"><?php echo $lang['store_class_bail'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['sc_bail'];?>" name="sc_bail" id="sc_bail" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="sc_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['sc_sort'];?>" name="sc_sort" id="sc_sort" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['update_sort'];?></td>
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
    if($("#store_class_form").valid()){
     $("#store_class_form").submit();
	}
	});
});
//
$(document).ready(function(){
	$('#store_class_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
            sc_name : {
                required : true,
                remote   : {
                url :'index.php?act=store_class&op=ajax&branch=check_class_name',
                type:'get',
                data:{
                    sc_name : function(){
                        return $('#sc_name').val();
                    },
                    sc_id : '<?php echo $output['class_array']['sc_id'];?>'
                  }
                }
            },
            sc_sort : {
                number   : true
            }
        },
        messages : {
            sc_name : {
                required : '<?php echo $lang['store_class_name_no_null'];?>',
                remote   : '<?php echo $lang['store_class_name_is_there'];?>'
            },
            sc_sort  : {
                number   : '<?php echo $lang['store_class_sort_only_number'];?>'
            }
        }
    });
});
</script>