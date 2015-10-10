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
  <form id="add_form" method="post" enctype="multipart/form-data" action="index.php?act=complain&op=complain_setting_save">
    <table class="table tb-type2 nobdb">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label for="complain_time_limit"><?php echo $lang['complain_time_limit'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input name="complain_time_limit" id="complain_time_limit" value="<?php echo intval($output['list_setting']['complain_time_limit'])/86400;?>" type="text" class="txt"></td>
          <td class="vatop tips"><?php echo $lang['complain_time_limit_desc'];?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot"><td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="btn_add"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript">
//
$(document).ready(function(){
    //添加按钮的单击事件
    $("#btn_add").click(function(){
        $("#add_form").submit();
    });
    //页面输入内容验证
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	complain_time_limit: {
                required : true,
                digits : true
            }
        },
        messages : {
      		complain_time_limit: {
       			required : '<?php echo $lang['complain_time_limit_error'];?>',
                digits : '<?php echo $lang['complain_time_limit_error'];?>'
	    	}
        }
	});
});
</script>
