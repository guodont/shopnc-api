<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3> <?php echo $lang['complain_manage_title'];?> </h3>
      <ul class="tab-base">
        <?php
            foreach($output['menu'] as $menu) {
                if($menu['menu_type'] == 'text') {
        ?>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php
                }
                else {
        ?>
        <li><a href="<?php echo $menu['menu_url'];?>"><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php
               }
           }
        ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=complain&op=complain_subject_save">
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="complain_subject_content"><?php echo $lang['complain_subject_content'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="complain_subject_content" name="complain_subject_content" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" for="complain_subject_desc"><?php echo $lang['complain_subject_desc'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><textarea name="complain_subject_desc" rows="6" class="tarea" id="complain_subject_desc"></textarea></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot"><td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
//按钮先执行验证再提交表单
$(function(){$("#submitBtn").click(function(){
    if($("#add_form").valid()){
     $("#add_form").submit();
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
        	complain_subject_content: {
                required : true,
                maxlength : 50
            },
        	complain_subject_desc: {
                required : true,
                maxlength : 100
            }
        },
        messages : {
      		complain_subject_content: {
       			required : '<?php echo $lang['complain_subject_content_error'];?>',
       			maxlength : '<?php echo $lang['complain_subject_content_error'];?>'
	    	},
      		complain_subject_desc: {
       			required : '<?php echo $lang['complain_subject_desc_error'];?>',
       			maxlength : '<?php echo $lang['complain_subject_desc_error'];?>'
	    	}
        }
	});
});
//submit函数
function submit_form(submit_type){
	$('#add_form').submit();
}
</script>
