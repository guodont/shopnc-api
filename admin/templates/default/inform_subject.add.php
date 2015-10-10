<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['inform_manage_title'];?></h3>
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
        <li><a href="<?php echo $menu['menu_url'];?>" ><span><?php echo $menu['menu_name'];?></span></a></li>
        <?php 
               }
           } 
        ?>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <br/>
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=inform&op=inform_subject_save">
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><?php echo $lang['inform_type'];?>:</td>
        </tr>
        <tr>
          <td colspan="2"><ul class="nofloat">
              <?php foreach($output['list'] as $inform_type) {?>
              <li>
                <p>
                  <input type='radio' name="inform_subject_type" id="<?php echo $inform_type['inform_type_id'].','.$inform_type['inform_type_name'];?>" value ="<?php echo $inform_type['inform_type_id'].','.$inform_type['inform_type_name'];?>">
                  <label for="<?php echo $inform_type['inform_type_id'].','.$inform_type['inform_type_name'];?>"><?php echo $inform_type['inform_type_name'];?>:</label>
                  </input>
                  &nbsp;&nbsp;<span style="color:green" ><?php echo $inform_type['inform_type_desc'];?></span></p>
              </li>
              <?php } ?>
            </ul></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation"  for="inform_subject_content"><?php echo $lang['inform_subject'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="inform_subject_content" name="inform_subject_content" class="txt"></td>
          <td class="vatop tips"></td>
        </tr>
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
    //默认选中第一个radio
    $(":radio").first().attr("checked",true);
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
        	inform_subject_content: {
                required : true,
                maxlength : 100
            }
        },
        messages : {
      		inform_subject_content: {
       			required : '<?php echo $lang['inform_subject_add_null'];?>',
       			maxlength : '<?php echo $lang['inform_subject_add_null'];?>'
	    	}
        }
	});
});
//submit函数
function submit_form(submit_type){
	$('#add_form').submit();
}
</script>