<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>闲置分类</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=flea_class&op=goods_class"><span>管理</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span>新增</span></a></li>
        <li><a href="index.php?act=flea_class&op=goods_class_export" ><span>导出</span></a></li>
        <li><a href="index.php?act=flea_class&op=goods_class_import" ><span>导入</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="goods_class_form" method="post">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation" for="gc_name">分类名称:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="" name="gc_name" id="gc_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="parent_id">上级分类:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="gc_parent_id" id="gc_parent_id">
              <option value="0"><?php echo $lang['nc_please_choose'];?>...</option>
              <?php if(!empty($output['parent_list']) && is_array($output['parent_list'])){ ?>
              <?php foreach($output['parent_list'] as $k => $v){ ?>
              <option <?php if($output['gc_parent_id'] == $v['gc_id']){ ?>selected='selected'<?php } ?> value="<?php echo $v['gc_id'];?>"><?php echo $v['gc_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td class="vatop tips">如果选择上级分类，那么新增的分类则为被选择上级分类的子分类</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_display'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="gc_show1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="gc_show0" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="gc_show1" name="gc_show" checked="checked" value="1" type="radio">
            <input id="gc_show0" name="gc_show" value="0" type="radio"></td>
          <td class="vatop tips">新增的分类名称是否显示</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>首页显示:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff"><label for="gc_index_show1" class="cb-enable selected"><span><?php echo $lang['nc_yes'];?></span></label>
            <label for="gc_index_show0" class="cb-disable"><span><?php echo $lang['nc_no'];?></span></label>
            <input id="gc_index_show1" name="gc_index_show" checked="checked" value="1" type="radio">
            <input id="gc_index_show0" name="gc_index_show" value="0" type="radio"></td>
          <td class="vatop tips">新增的分类名称是否显示</td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" value="255" name="gc_sort" id="gc_sort" class="txt"></td>
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
		if($("#goods_class_form").valid()){
			$("#goods_class_form").submit();
		}
	});
	
	$('#t_id').change(function(){
		if($(this).val() == '0'){
			$('#t_name').val('');
		}else{
			$('#t_name').val($(this).find('option:selected').text());
		}
	});
	
	$('#goods_class_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        success: function(label){
            label.addClass('valid');
        },
        rules : {
            gc_name : {
                required : true,
                remote   : {                
                url :'index.php?act=flea_class&op=ajax&branch=check_class_name',
                type:'get',
                data:{
                    gc_name : function(){
                        return $('#gc_name').val();
                    },
                    gc_parent_id : function() {
                        return $('#gc_parent_id').val();
                    },
                    gc_id : ''
                  }
                }
            },
            gc_sort : {
                number   : true
            }
        },
        messages : {
            gc_name : {
                required : '<?php echo $lang['goods_class_add_name_null'];?>',
                remote   : '<?php echo $lang['goods_class_add_name_exists'];?>'
            },
            gc_sort  : {
                number   : '<?php echo $lang['goods_class_add_sort_int'];?>'
            }
        }
    });
});
</script>