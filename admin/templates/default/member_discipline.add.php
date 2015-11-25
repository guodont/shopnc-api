<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>学科门类</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=member_discipline&op=member_discipline"><span>管理</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="discipline_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="discipline_name">学科名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="discipline_name" id="discipline_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_id">上级学科:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="discipline_parent_id" id="discipline_parent_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
              <?php foreach($output['parent_list'] as $k => $v){ ?>
              <option <?php if($output['discipline_parent_id'] == $v['discipline_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['discipline_id'];?>"><?php echo $v['discipline_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips">如果选择上级学科，那么新增的学科则为被选择上级学科的子学科</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_display'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="discipline_show1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="discipline_show0" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="discipline_show1" name="discipline_show" checked="checked" value="1" type="radio">
            <input id="discipline_show0" name="discipline_show" value="0" type="radio"></td>
          <td class="vatop tips">新增的学科名称是否显示</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="255" name="discipline_sort" id="discipline_sort" class="txt"></td>
          <td class="vatop tips">更新排序</td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script>
//按钮先执行验证再提交表单
$(function(){

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
                    discipline_id : ''
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