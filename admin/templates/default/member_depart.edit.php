<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>单位管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=member_depart&op=member_depart"><span>管理</span></a></li>
        <li><a href="index.php?act=member_depart&op=member_depart_add"><span>新增</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>编辑</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="member_depart_form" name="goodsClassForm" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="depart_id" value="<?php echo $output['class_array']['depart_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="depart_name validation">单位名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['depart_name'];?>" name="depart_name" id="depart_name" class="txt"></td>
          <td class="vatop tips">单位名称</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>显示:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="depart_show1" class="cb-enable <?php if($output['class_array']['depart_show'] == '1'){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="depart_show0" class="cb-disable <?php if($output['class_array']['depart_show'] == '0'){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="depart_show1" name="depart_show" <?php if($output['class_array']['depart_show'] == '1'){ ?>checked="checked"<?php }?> value="1" type="radio">
            <input id="depart_show0" name="depart_show" <?php if($output['class_array']['depart_show'] == '0'){ ?>checked="checked"<?php }?> value="0" type="radio">
           
            
            </td>
          <td class="vatop tips">新增的单位名称是否显示</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>开放管理:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="depart_manage1" class="cb-enable <?php if($output['class_array']['depart_manage'] == '1'){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="depart_manage0" class="cb-disable <?php if($output['class_array']['depart_manage'] == '0'){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="depart_manage1" name="depart_manage" <?php if($output['class_array']['depart_manage'] == '1'){ ?>checked="checked"<?php }?> value="1" type="radio">
            <input id="depart_manage0" name="depart_manage" <?php if($output['class_array']['depart_manage'] == '0'){ ?>checked="checked"<?php }?> value="0" type="radio"></td>
          <td class="vatop tips">是否允许新增单位自行管理</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="depart_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['class_array']['depart_sort'];?>" name="depart_sort" id="depart_sort" class="txt"></td>
          <td class="vatop tips">更新排序</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot"><td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
$(document).ready(function(){
	//按钮先执行验证再提交表单
	$("#submitBtn").click(function(){
	    if($("#member_depart_form").valid()){
	     $("#member_depart_form").submit();
		}
	});

	$('#t_id').change(function(){
		if($(this).val() == '0'){
			$('#t_name').val('');
		}else{
			$('#t_name').val($(this).find('option:selected').text());
		}
	});
	
	$('#member_depart_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            depart_name : {
                required : true,
                remote   : {                
                url :'index.php?act=member_depart&op=ajax&branch=check_class_name',
                type:'get',
                data:{
                    depart_name : function(){
                        return $('#depart_name').val();
                    },
                    depart_parent_id : function() {
                        return $('#depart_parent_id').val();
                    },
                    depart_id : '<?php echo $output['class_array']['depart_id'];?>'
                  }
                }
            },
            depart_sort : {
                number   : true
            }
        },
        messages : {
             depart_name : {
                required : '<?php echo $lang['member_depart_add_name_null'];?>',
                remote   : '<?php echo $lang['member_depart_add_name_exists'];?>'
            },
            depart_sort  : {
                number   : '<?php echo $lang['member_depart_add_sort_int'];?>'
            }
        }
    });
});
</script>