<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>单位管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=member_depart&op=member_depart"><span>管理</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>新增</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="member_depart_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="depart_name">单位名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="depart_name" id="depart_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_id">上级单位:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="depart_parent_id" id="depart_parent_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
              <?php foreach($output['parent_list'] as $k => $v){ ?>
              <option <?php if($output['depart_parent_id'] == $v['depart_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['depart_id'];?>"><?php echo $v['depart_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips">如果选择上级单位，那么新增的单位则为被选择上级单位的子单位</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_display'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="depart_show1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="depart_show0" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="depart_show1" name="depart_show" checked="checked" value="1" type="radio">
            <input id="depart_show0" name="depart_show" value="0" type="radio"></td>
          <td class="vatop tips">新增的单位名称是否显示</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>开放管理:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="depart_manage1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="depart_manage0" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="depart_manage1" name="depart_manage" checked="checked" value="1" type="radio">
            <input id="depart_manage0" name="depart_manage" value="0" type="radio"></td>
          <td class="vatop tips">是否允许新增单位自行管理</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="255" name="depart_sort" id="depart_sort" class="txt"></td>
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
                    depart_id : ''
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