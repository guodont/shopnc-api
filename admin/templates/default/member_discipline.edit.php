<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>学科门类</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=member_discipline&op=member_discipline"><span>管理</span></a></li>
        <li><a href="index.php?act=member_discipline&op=member_discipline_add"><span>新增</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>编辑</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="discipline_form" name="goodsClassForm" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="discipline_id" value="<?php echo $output['discipline_array']['discipline_id'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="discipline_name validation">学科名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['discipline_array']['discipline_name'];?>" name="discipline_name" id="discipline_name" class="txt"></td>
          <td class="vatop tips">学科名称</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>显示:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="discipline_show1" class="cb-enable <?php if($output['discipline_array']['discipline_show'] == '1'){ ?>selected<?php }?>"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="discipline_show0" class="cb-disable <?php if($output['discipline_array']['discipline_show'] == '0'){ ?>selected<?php }?>"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="discipline_show1" name="discipline_show" <?php if($output['discipline_array']['discipline_show'] == '1'){ ?>checked="checked"<?php }?> value="1" type="radio">
            <input id="discipline_show0" name="discipline_show" <?php if($output['discipline_array']['discipline_show'] == '0'){ ?>checked="checked"<?php }?> value="0" type="radio">
           
            
            </td>
          <td class="vatop tips">新增的学科名称是否显示</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="discipline_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="<?php echo $output['discipline_array']['discipline_sort'];?>" name="discipline_sort" id="discipline_sort" class="txt"></td>
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
	    if($("#discipline_form").valid()){
	     $("#discipline_form").submit();
		}
	});

	$('#t_id').change(function(){
		if($(this).val() == '0'){
			$('#t_name').val('');
		}else{
			$('#t_name').val($(this).find('option:selected').text());
		}
	});
	
	$('#discipline_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            discipline_name : {
                required : true,
                remote   : {                
                url :'index.php?act=member_discipline&op=ajax&branch=check_discipline_name',
                type:'get',
                data:{
                    discipline_name : function(){
                        return $('#discipline_name').val();
                    },
                    discipline_parent_id : function() {
                        return $('#discipline_parent_id').val();
                    },
                    discipline_id : '<?php echo $output['discipline_array']['discipline_id'];?>'
                  }
                }
            },
            discipline_sort : {
                number   : true
            }
        },
        messages : {
             discipline_name : {
                required : '<?php echo $lang['discipline_add_name_null'];?>',
                remote   : '<?php echo $lang['discipline_add_name_exists'];?>'
            },
            discipline_sort  : {
                number   : '<?php echo $lang['discipline_add_sort_int'];?>'
            }
        }
    });
});
</script>