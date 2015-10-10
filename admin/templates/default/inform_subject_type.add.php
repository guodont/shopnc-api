<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['inform_manage_title'];?></h3>
      <ul class="tab-base">
        <?php  foreach($output['menu'] as $menu) {  if($menu['menu_type'] == 'text') { ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php } else { ?>
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php  } }  ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=inform&op=inform_subject_type_save" name="form1">
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['inform_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="inform_type_name" name="inform_type_name" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"><?php echo $lang['inform_type_desc'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="inform_type_desc" rows="6" id="inform_type_desc" class="tarea"></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2" ><a href="JavaScript:void(0);" class="btn" onclick="document.form1.submit()"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#goods_class_form").valid()){
     $("#goods_class_form").submit();
	}
	});
});
//
$(document).ready(function(){
    //添加按钮的单击事件
    $("#btn_add").click(function(){
        submit_form();
    });
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	inform_type_name: {
        		required : true,
                maxlength : 50
        	},
        	inform_type_desc: {
                required : true,
                maxlength : 100
            }
        },
        messages : {
      		inform_type_name: {
       			required : '<?php echo $lang['inform_type_null'];?>',
       			maxlength : '<?php echo $lang['inform_type_null'];?>'
	    	},
	    	inform_type_desc: {
                required : '<?php echo $lang['inform_type_desc_null'];?>',
                maxlength : '<?php echo $lang['inform_type_desc_null'];?>'
		    }
        }
	});
});
//submit函数
function submit_form(submit_type){
	$('#add_form').submit();
}
</script>